<?php
require_once "pkg/route/route.php";

function __autoload($class) {
	if (file_exists($path = "../src/models/" . strtolower($class) . ".php")) {
		require_once $path;
	}
}

Router::AddRoutes([
	"/" => ["function" => "Highscore"]
]);

function Highscore() {
	return "Hello, world.";
}
?>
