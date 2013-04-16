<?php
require_once "../config.php";
require_once "../src/controllers.php";

function __autoload($class) {
	if (file_exists($path = "../src/models/" . strtolower($class) . ".php")) {
		require_once $path;
	}
}

global $db;
$db = new PDO(
	$config["database"]
);

try {
	$url = $_SERVER["REQUEST_URI"];
	echo Router::Route(
		$url
	);
}
catch (Exception $e) {
	echo Router::Route(
		"/error"
	);
}
?>
