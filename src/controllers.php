<?php
require_once "utils.php";
require_once "pkg/route/route.php";

function __autoload($class) {
	if (file_exists($path = "../src/models/" . strtolower($class) . ".php")) {
		require_once $path;
	}
}

Router::AddRoutes([
	"/" => ["function" => "Browse"]
]);

function Browse() {
	return Import(
		"../views/share/masterpage.php", [
			"body" => Import("../views/highscore/browse.php")
		]
	);
}
?>
