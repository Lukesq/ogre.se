<?php
require_once dirname(__FILE__) . "/../db/db.php";

class Highscores {
	static function GetPlayer($player_id, $time) {
		global $db;
		$sql = "
		SELECT
			skill,
			rank,
			level,
			xp
		FROM (
			SELECT DISTINCT ON(player_id) * FROM highscore
			WHERE time <= ?
			AND player_id = ?
			ORDER BY player_id
			DESC
		) AS highscore
		JOIN highscore_stats
			ON highscore_id = highscore.id
		";
		$query = $db->prepare($sql);
		$query->execute([
			$time,
			$player_id
		]);
		$highscore = $query->fetchAll(PDO::FETCH_ASSOC);
		if ($highscore) {
			return $highscore;
		}
		else {
			return false;
		}
	}
	
	static function GetSkill($skill, $time) {
		global $db;
		$sql = "
		SELECT
			name,
			skill,
			rank,
			level,
			xp
		FROM (
			SELECT DISTINCT ON(player_id) * FROM highscore
			WHERE time <= ?
			ORDER BY player_id
			DESC
		) AS highscore
		JOIN player
			on player_id = player.id
		JOIN highscore_stats
			ON highscore_id = highscore.id
		WHERE skill = ?
		ORDER BY rank
		";
		$query = $db->prepare($sql);
		$query->execute([
			$time,
			$skill
		]);
		$highscore = $query->fetchAll(PDO::FETCH_ASSOC);
		if ($highscore) {
			return $highscore;
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
		$highscore_id = $db->lastInsertId("highscore_id_seq");
		$sql = "
		INSERT INTO highscore_stats(highscore_id, skill, rank, level, xp)
		VALUES (?, ?, ?, ?, ?)
		";
		$query = $db->prepare($sql);
		foreach ($stats as $k => $v) {
			extract($v);
			$query->execute([
				$highscore_id,
				$k,
				$rank,
				$level,
				$xp
			]);
		}
		return true;
	}
};
?>
