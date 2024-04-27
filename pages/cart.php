<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/util/common.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/util/connection.php');

    // Si l'utilisateur n'est pas connecté, on le redirge vers la page de connexion
    if (empty($userInfo))
        header('location:./login');
    ?>
</head>
    <?php
    getPageHeader($userInfo);
    ?>

    <main>
        <h1>Panier</h1>
        <table>
            <tr>
                <th>Montre</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Total</th>
            </tr>
            <?php
            $query = "SELECT * FROM shopping_carts WHERE user_id = " . $userInfo['id'];
            $result = $conn->query($query);
            $total = 0;
            while ($row = $result->fetch_assoc()) {
                $query = "SELECT * FROM watches WHERE id = " . $row['watch_id'];
                $watch = $conn->query($query)->fetch_assoc();
                $total += $watch['price'] * $row['quantity'];
            ?>
                <tr>
                    <td><?php echo $watch['name'] ?></td>
                    <td><?php echo $watch['price'] ?>€</td>
                    <td><?php echo $row['quantity'] ?></td>
                    <td><?php echo $watch['price'] * $row['quantity'] ?>€</td>
                </tr>
            <?php
            }
            ?>
            <tr>
                <td colspan="3">Total</td>
                <td><?php echo $total ?>€</td>
            </tr>
        </table>
    </main>

    <?php
    getPageFooter();
    ?>