<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter au panier</title>
</head>
<body>
    <?php
        require_once ($_SERVER['DOCUMENT_ROOT'] . '/util/common.php');
        require_once ($_SERVER['DOCUMENT_ROOT'] . '/util/connection.php');
        
        if(isset($_POST['product_id']) && isset($_POST['quantite'])) {
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
    ?>
</body>
</html>