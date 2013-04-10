<?php
require_once "../src/controllers.php";

error_reporting(0);
register_shutdown_function(function() {
	$err = error_get_last();
	if ($err !== null) {
		echo Router::Route("/error");
	}
});

$url = $_SERVER["REQUEST_URI"];
echo Router::Route(
	$url
);
?>
