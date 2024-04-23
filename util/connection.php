<?php
// File used for configuration and connection to the database and the account

require_once('../util/validate.php');

session_start();

define('DB_HOSTNAME', "127.0.0.1");
define('DB_NAME', "octime");
define('DB_USERNAME', "root");
define('DB_PASSWORD', "");

$connection = new PDO("mysql:host=".DB_HOSTNAME.";dbname=".DB_NAME, DB_USERNAME, DB_PASSWORD);
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$userInfo = null;

// Si l'email donné dans les cookies est valide, on tente de connecter l'utilisateur automatiquement
if(isset($_COOKIE['email']) && validateEmail($_COOKIE['email']) && isset($_COOKIE['password'])) try {
    // On sélection le compte via l'email
    $stmt = $connection->prepare("SELECT * FROM accounts WHERE email = ?");
    $stmt->execute([$_COOKIE['email']]);
    $res = $stmt->fetch(PDO::FETCH_ASSOC);

    // On vérifie que les MdP (préalablement hashés) soient bien les mêmes
    // Si c'est le cas, alors on définit l'userInfo comme la ligne de données associées à cet user
    if($res['password'] == $_COOKIE['password']) $userInfo = $res;
} catch(Exception $e) { $userInfo = null; }

function login(string $email, string $hashedPwd):bool {
    try {

        return true;
    } catch (Exception $e) { return false; }
}