<?php
require_once "utils.php";
require_once "pkg/route/route.php";

function __autoload($class) {
	if (file_exists($path = "../src/models/" . strtolower($class) . ".php")) {
		require_once $path;
	}
}

define(
	"REQUEST", 
	$_SERVER["REQUEST_METHOD"]
);
define(
	"DATE",
	isset($_GET["date"]) ? date("Y-m-d", strtotime($_GET["date"]))
		: Date::Today("-4 hours")
);

Router::AddRoutes([
	"/error"                  => ["function" => "error"],
	"/:function/:type/:param" => ["class" => "Highscore", "function" => "Browse", "type" => "skill", "param" => "overall"]
]);

function Error() {
	return Import(
		"../views/masterpage.php", [
			"body" => Import("../views/error.php")
		]
	);
}

class Highscore {
	static function Browse($args) {
		extract($args);
		$from = Date::Yesterday(DATE) . " 04:00";
		$to = DATE . " 04:00";
	
		switch ($type) {
		case "player":
			$title = str_replace(
				"_",
				" ",
				$param
			);
			$param = Players::GetPlayerIdByName($title);
			if (!$param) {
				throw new Exception(
					"Player '$title' does not exist."
				);
			}
			break;
	
		case "skill":
			$title = $param;
			if (!Skills::IsSkill($param)) {
				throw new Exception("Skill '$param' does not exist.");
			}
			break;
	
		default:
			throw new Exception(
				"Type '$type' does not exist."
			);
		}
	
		$data = [
			"type"      => $type,
			"title"     => $title,
			"highscore" => Highscores::GetHighscore($type, $param, $to),
			"old"       => Highscores::GetHighscore($type, $param, $from),
			"from"      => $from,
			"to"        => $to,
		];
		return Import(
			"../views/masterpage.php", [
				"body" => Import("../views/browse.php", $data)
			] + $data
		);
	}

	static function Register() {
		$data = [];
		if (REQUEST == "POST") {
			$data["success"] = Players::AddPlayer($name = &$_POST["name"]);
			if ($data["success"]) {
				header("Refresh: 2; url=/");
			}
		}
		return Import(
			"../views/masterpage.php", [
				"body" => Import("../views/register.php", $data)
			] + $data
		);
	}
};
?>
