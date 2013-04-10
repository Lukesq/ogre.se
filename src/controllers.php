<?php
require_once "utils.php";
require_once "pkg/route/route.php";

define(
	"REQUEST", 
	$_SERVER["REQUEST_METHOD"]
);
define(
	"DATE",
	isset($_GET["date"]) ? date("Y-m-d", strtotime($_GET["date"]))
		: Date::Today()
);

function __autoload($class) {
	if (file_exists($path = "../src/models/" . strtolower($class) . ".php")) {
		require_once $path;
	}
}

Router::AddRoutes([
	"/" => ["function" => "Skill", "skill" => "overall"],
	"/skill/:skill" => ["function" => "Skill"],
	"/:player" => ["function" => "Player"],
	"/register" => ["function" => "Register"]
]);

function Skill($args) {
	$skill = &$args["skill"];
	$from = Date::Yesterday(DATE);
	$to = DATE;
	$data = [
		"type" => "skill",
		"title" => $skill,
		"from" => $from,
		"to" => $to,
		"old" => Highscores::GetSkill($skill, $from),
		"highscore" => Highscores::GetSkill($skill, $to)
	];
	return Import(
		"../views/share/masterpage.php", [
			"body" => Import("../views/highscore/browse.php", $data)
		] + $data
	);
}

function Player($args) {
	extract($args);
	$player = str_replace(
		"+", 
		" ",
		$player
	);
	$player_id = Players::GetPlayerIdByName($player);
	$from = Date::Yesterday(DATE);
	$to = DATE;
	$data = [
		"type" => "player",
		"title" => $player,
		"from" => $from,
		"to" => $to,
		"old" => Highscores::GetPlayer($player_id, $from),
		"highscore" => Highscores::GetPlayer($player_id, $to)
	];
	return Import(
		"../views/share/masterpage.php", [
			"body" => Import("../views/highscore/browse.php", $data)
		] + $data
	);
}

function Register() {
	$data = [];
	if (REQUEST == "POST") {
		$name = &$_POST["name"];
		$data += [
			"success" => Players::AddPlayer($name)
		];
	}
	return Import(
		"../views/share/masterpage.php", [
			"body" => Import("../views/highscore/register.php", $data)
		] + $data
	);
}
?>
