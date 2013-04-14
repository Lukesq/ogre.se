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

Router::AddRoutes([
	"/error"        => ["function" => "Error"],
	"/register"     => ["class" => "Highscore", "function" => "Register"],
	"/:type/:param" => ["class" => "Highscore", "function" => "Browse", "type" => "skill", "param" => "overall"]
]);

function Error() {
	return Import(
		"../views/share/masterpage.php", [
			"body" => Import("../views/error/error.php")
		]
	);
}

class Highscore {
	static function Browse($args) {
		extract($args);
		$from = Date::Yesterday(DATE);
		$to = DATE;
		
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
			"../views/share/masterpage.php", [
				"body" => Import("../views/highscore/browse.php", $data)
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
			"../views/share/masterpage.php", [
				"body" => Import("../views/highscore/register.php", $data)
			] + $data
		);
	}
};
?>
