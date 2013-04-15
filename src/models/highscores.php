<?php
class Highscores {
	static function GetHighscore($type, $value, $time) {
		global $db;
		
		switch ($type) {
		case "player":
			$sql = "
			SELECT
				skill AS name,
				rank,
				level,
				xp
			FROM (
				SELECT DISTINCT ON(player_id) * FROM highscore
				WHERE time <= ?
				AND player_id = ?
				ORDER BY
					player_id,
					time
				DESC
			) AS highscore
			JOIN highscore_stats
				ON highscore_id = highscore.id
			";
			break;
		
		case "skill":
			$sql = "
			SELECT
				name,
				rank,
				level,
				xp
			FROM (
				SELECT DISTINCT ON(player_id) * FROM highscore
				WHERE time <= ?
				ORDER BY
					player_id,
					time
				DESC
			) AS highscore
			JOIN player
				ON player_id = player.id AND player.active
			JOIN highscore_stats
				ON highscore_id = highscore.id
			WHERE skill = ?
			ORDER BY rank
			";
			break;
		
		default:
			return false;
		}
		
		$query = $db->prepare($sql);
		$query->execute([
			$time,
			$value
		]);
		$highscore = $query->fetchAll(PDO::FETCH_ASSOC);
		if ($highscore) {
			return ArrayColumnValueAsKey(
				"name", 
				$highscore
			);
		}
		else {
			return false;
		}
	}
	
	static function SaveHighscore($player_id, $time, array $stats) {
		global $db;
		$sql = "
		INSERT INTO highscore(player_id, time)
		VALUES (?, ?)
		";
		$query = $db->prepare($sql);
		$query->execute([
			$player_id,
			$time
		]);
		
		$sql = "
		INSERT INTO highscore_stats(highscore_id, skill, rank, level, xp)
		VALUES (?, ?, ?, ?, ?)
		";
		$query = $db->prepare($sql);
		$highscore_id = $db->lastInsertId("highscore_id_seq");
		foreach ($stats as $key => $value) {
			extract($value);
			$query->execute([
				$highscore_id,
				$key,
				$rank,
				$level,
				$xp
			]);
		}
	}
};
?>
