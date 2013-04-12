<?php
// Only allow local execution.
if (PHP_SAPI != "cli") {
	die();
}

require_once dirname(__FILE__) . "/../config.php";
require_once dirname(__FILE__) . "/../src/pkg/runecrawler/crawler.php";

global $db;
$db = new PDO(
	$config["database"]
);

function __autoload($class) {
	if (file_exists($path = dirname(__FILE__) . "/../src/models/" . strtolower($class) . ".php")) {
		require_once $path;
	}
}

$timestamp = date("Y-m-d H:i");
echo "Fetching..\n";

foreach (Players::GetAllPlayers() as $player) {
	extract($player);
	set_time_limit(0);
	echo "* ";
	$crawl = Crawler::Fetch($name);
	if (!$crawl) {
		echo "'$name' failure\n";
		continue;
	}
	Highscores::SaveHighscore(
		$id,
		$timestamp,
		$crawl
	);
	echo "'$name' success\n";
}

echo "Done.\n";
?>