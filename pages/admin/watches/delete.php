<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/util/common.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/util/connection.php');

if(isset($_GET['id'])){
    $stmt = $connection->prepare("DELETE FROM watches WHERE id = ?");
    $code = $stmt->execute([(int)$_GET['id']]);
    $_SESSION[$code ? 'watchDeleted' : 'error'] = true;
}

header('location:../watches');