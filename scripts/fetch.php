<?php
require_once dirname(__FILE__) . "/../src/pkg/runecrawler/crawler.php";

// Only allow local execution.
if (PHP_SAPI != "cli") {
	die();
}

function __autoload($class) {
	if (file_exists($path = dirname(__FILE__) . "/../src/models/" . strtolower($class) . ".php")) {
		require_once $path;
	}
}

date_default_timezone_set("Europe/Stockholm");
$time = date("Y-m-d H:i") . "+01";

echo "Fetching..\n";

foreach (Players::GetAllPlayers() as $player) {
	extract($player);

	set_time_limit(0);
	echo "* ";

	$values = Crawler::Fetch($name);
	if (!$values) {
		echo "'$name' failure\n";
		continue;
	}
	
	Highscores::SaveHighscore(
		$id,
		$time,
		$values
	);
	
	echo "'$name' success\n";
}

echo "Done.\n";
?>