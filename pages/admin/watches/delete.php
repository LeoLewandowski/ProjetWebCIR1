<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/util/common.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/util/connection.php');

// Si l'utilisateur n'est pas admin, on affiche la page 404 à la place
if (!$userInfo['admin']) {
    require ($_SERVER['DOCUMENT_ROOT'] .'/pages/404.php');
    die();
}

if(isset($_GET['id'])){
    $stmt = $connection->prepare("DELETE FROM watches WHERE id = ?");
    $code = $stmt->execute([(int)$_GET['id']]);
    $_SESSION[$code ? 'watchDeleted' : 'error'] = true;
}

header('location:../watches');