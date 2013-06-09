<?php
date_default_timezone_set("US/Eastern");

global $config;
$config = [
	// Reference:
	// DSN: http://www.php.net/manual/en/ref.pdo-pgsql.connection.php
	"database" => "pgsql:host=localhost;dbname=ogre.se;"
];
?>
