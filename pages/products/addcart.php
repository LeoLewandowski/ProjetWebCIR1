<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/util/common.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/util/connection.php');

// Si l'utilisateur est un admin, il n'a pas de panier et donc on n'insère pas la montre dans la table
if (!$userInfo['admin'] && isset($_POST['product_id']) && isset($_POST['quantite'])) {
    $product_id = $_POST['product_id'];
    $quantite = $_POST['quantite'];
    $requete = $connection->prepare('INSERT INTO shopping_carts (product_id, count, client_id) VALUES (:product_id, :count, :client_id)');
    $arr = array(
        'product_id' => $product_id,
        'count' => $quantite,
        'client_id' => $userInfo['id']
    );
    var_dump($arr);
    $requete->execute($arr);
}
header('location: /products');
