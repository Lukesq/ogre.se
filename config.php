<?php
date_default_timezone_set("Europe/Stockholm");

global $config;
$config = [
	"database" => "pgsql:host=localhost;dbname=ogre.se;"
];

// References:
// DSN: http://www.php.net/manual/en/ref.pdo-pgsql.connection.php
?>
