<?php
require_once "../config.php";
require_once "../src/controllers.php";

global $db;
$db = new PDO(
	$config["database"]
);

try {
	$url = $_SERVER["REQUEST_URI"];
	echo Router::Route(
		$url
	);
} catch (Exception $e) {
	echo Router::Route(
		"/error"
	);
}
?>
