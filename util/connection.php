<?php
// File used for configuration and connection to the database and the account

session_start();

define('DB_HOSTNAME', "localhost");
define('DB_NAME', "octime");
define('DB_USERNAME', "root");
define('DB_PASSWORD', "");

$connection = new PDO("mysql:host=".DB_HOSTNAME.";dbname=".DB_NAME, DB_USERNAME, DB_PASSWORD);
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 