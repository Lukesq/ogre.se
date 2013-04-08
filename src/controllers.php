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
	"/" => ["function" => "Browse"],
	"/register" => ["function" => "Register"]
]);

function Browse() {
	return Import(
		"../views/share/masterpage.php", [
			"body" => Import("../views/highscore/browse.php")
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
			"body" => Import(
				"../views/highscore/register.php",
				$data
			)
		]
	);
}
?>
