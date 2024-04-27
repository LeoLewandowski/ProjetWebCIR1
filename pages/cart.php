<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="/css/cart.css"> 
    <?php
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/util/common.php');
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/util/connection.php');
    getPageHead('Panier', 'panier');
    if (empty($userInfo))
        header('location:./login');

    // Si l'utilisateur est un admin, on le redirige vers le panel admin
    if ($userInfo['admin'])
        header('location: /admin');

    if (isset($_POST['remove_product'])) {
        $product_id = $_POST['product_id'];
        $stmt = $connection->prepare("DELETE FROM shopping_carts WHERE client_id = :client_id AND product_id = :product_id");
        $stmt->execute([':client_id' => $userInfo['id'], ':product_id' => $product_id]);
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }

    if (isset($_POST['update_quantity'])) {
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];
        $stmt = $connection->prepare("UPDATE shopping_carts SET count = :quantity WHERE client_id = :client_id AND product_id = :product_id");
        $stmt->execute([':quantity' => $quantity, ':client_id' => $userInfo['id'], ':product_id' => $product_id]);
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
    ?>
</head>

<body>
    <?php
    getPageHeader($userInfo);
    ?>

    <main>
        <h1>Panier</h1>
        <table class="mainTable">
            <thead>
                <th>Montre</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Total</th>
                <th>Action</th>
            </thead>
            <tbody>
                <?php
                $uID = $userInfo['id'];
                $stmt = $connection->prepare("SELECT watches.id AS product_id, watches.name, watches.price, shopping_carts.count FROM shopping_carts LEFT JOIN watches ON watches.id = shopping_carts.product_id WHERE shopping_carts.client_id = :client_id");
                $stmt->execute([':client_id' => $uID]);
                $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $total = 0;
                foreach ($cartItems as $item) {
                    $subtotal = $item['price'] * $item['count'];
                    $total += $subtotal;
                    ?>
                    <tr>
                        <td><?= $item['name'] ?></td>
                        <td><?= $item['price'] ?>€</td>
                        <td>
                            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                                <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                                <input type="number" name="quantity" value="<?= $item['count'] ?>" min="1" id="quantity">
                                <button type="submit" name="update_quantity">Modifier</button>
                            </form>
                        </td>
                        <td><?= $subtotal ?>€</td>
                        <td>
                            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                                <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                                <button type="submit" name="remove_product">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="4" style="text-align: right;"><strong>Total :</strong></td>
                    <td><?= $total ?>€</td>
                </tr>
            </tbody>
        </table>
        <form action="TuVaRaquerChef.php" method="post">
            <button type="submit">Procéder au paiement</button>
        </form>
    </main>
</body>

</html>
