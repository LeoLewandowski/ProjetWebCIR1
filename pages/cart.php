<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/util/common.php');
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/util/connection.php');
    getPageHead('Panier', 'panier');
    // Si l'utilisateur n'est pas connecté, on le redirge vers la page de connexion
    if (empty($userInfo))
        header('location:./login');

    // Si l'utilisateur est un admin, on le redirige vers le panel admin
    if ($userInfo['admin'])
        header('location: /admin');
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
            </thead>
            <tbody>
                <?php
                $uID = $userInfo['id'];
                $crt = $connection->prepare("SELECT * FROM shopping_carts WHERE client_id = ?");
                $crt->execute([$uID]);
                $res = $crt->fetchAll(PDO::FETCH_ASSOC);
                $total = 0;
                foreach ($res as $watch) {
                    $wID = $watch['watch_id'];
                    $stmt = $connection->prepare("SELECT * FROM watches WHERE id = ?");
                    $stmt->execute([$wID]);
                    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $watch = $res[0];
                    $total += $watch['price'] * $watch['quantity'];
                    ?>
                    <tr>
                        <td><?= $watch['name'] ?></td>
                        <td><?= $watch['price'] ?>€</td>
                        <td><?= $watch['quantity'] ?></td>
                        <td><?= $watch['price'] * $watch['quantity'] ?>€</td>
                    </tr>
                    <?php
                } ?>
            </tbody>
        </table>
    </main>
</body>

</html>