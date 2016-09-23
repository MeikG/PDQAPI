<?php
// Require our composer libraries.
require 'vendor/autoload.php';
require 'config.php';

// Initialise our database variable.
global $config;
global $db;
$db = new \stdClass;

// Grab the PDQ Deploy and Inventory databases.
$db->deploy = new medoo([
	'database_type' => 'sqlite',
	'database_file' => $config->PDQ_Deploy_Database
]);

$db->inventory = new medoo([
	'database_type' => 'sqlite',
	'database_file' => $config->PDQ_Inventory_Database
]);
