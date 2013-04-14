<?php
date_default_timezone_set("Europe/Stockholm");

global $config;
$config = [
	// Reference:
	// DSN: http://www.php.net/manual/en/ref.pdo-pgsql.connection.php
	"database" => "pgsql:host=localhost;dbname=ogre.se;"
];
?>
