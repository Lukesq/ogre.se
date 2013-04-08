<?php
require_once "utils.php";
require_once "pkg/route/route.php";

define(
	"REQUEST", 
	$_SERVER["REQUEST_METHOD"]
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
	$highscore = Highscores::GetSkill($skill, Date::Tomorrow());
	$data = [
		"type" => "skill",
		"title" => $skill,
		"highscore" => $highscore
	];
	return Import(
		"../views/share/masterpage.php", [
			"body" => Import("../views/highscore/browse.php", $data)
		]
	);
}

function Player($args) {
	extract($args);
	$player = str_replace(
		"+", 
		" ",
		$player
	);
	$highscore = Highscores::GetPlayer(
		Players::GetPlayerIdByName($player),
		Date::Tomorrow()
	);
	$data = [
		"type" => "player",
		"title" => $player,
		"highscore" => $highscore
	];
	return Import(
		"../views/share/masterpage.php", [
			"body" => Import("../views/highscore/browse.php", $data)
		]
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
		]
	);
}
?>
