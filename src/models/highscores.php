<?php
require_once dirname(__FILE__) . "/../db/db.php";

class Highscores {
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
