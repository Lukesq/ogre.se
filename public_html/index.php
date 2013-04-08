<?php
require_once "../src/controllers.php";

register_shutdown_function(function() {
	$err = error_get_last();
	if ($err !== null) {
		// Catch fatal errors here
	}
});

echo Router::Route("/a");
?>
