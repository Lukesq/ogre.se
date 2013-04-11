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
	"/error" => ["function" => "Error"],
	"/register" => ["function" => "Register"],
	"/skill/:skill" => ["function" => "Skill"],
	"/:player" => ["function" => "Player"]
]);

function Skill($args) {
	$skill = &$args["skill"];
	if (!Skills::IsSkill($skill)) {
		trigger_error(
			"Skill '$skill' does not exist.",
			E_USER_ERROR
		);
	}
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
		"../views/masterpage.php", [
			"body" => Import("../views/browse.php", $data)
		] + $data
	);
}

function Player($args) {
	extract($args);
	$player = str_replace(
		"_", 
		" ",
		$player
	);
	$player_id = Players::GetPlayerIdByName($player);
	if (!$player_id) {
		trigger_error(
			"Player '$player' does not exist.",
			E_USER_ERROR
		);
	}
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
		"../views/masterpage.php", [
			"body" => Import("../views/browse.php", $data)
		] + $data
	);
}

function Register() {
	$data = [];
	if (REQUEST == "POST") {
		$name = &$_POST["name"];
		if ($success = Players::AddPlayer($name)) {
			header("Refresh: 2; url=/");
		}
		$data += [
			"success" => $success
		];
	}
	return Import(
		"../views/masterpage.php", [
			"body" => Import("../views/register.php", $data)
		] + $data
	);
}

function Error() {
	return Import(
		"../views/masterpage.php", [
			"body" => Import("../views/error.php")
		]
	);
}
?>
