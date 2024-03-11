<?php
// File used for configuration and connection to the database and the account

session_start();

$hostname = "localhost";
$database = "main";
$username = "root";
$password = "";

$connection = mysqli_connect($hostname,$username,$password,"");
if (mysqli_connect_errno()) {
    exit("". mysqli_connect_error());
}