<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    require_once('../util/common.php');
    require_once('../util/connection.php');
    getPageHead('Montre', 'products');
    ?>
</head>

<body>
    <?php
    getPageHeader('products');
    ?>

    <main>
        <?php
        $lang = $_GET['lang'] ?? LANGUAGE->value;
        $err = false;

        $wID = $_GET['id'];
        if (is_numeric($wID)) {
            $stmt = $connection->prepare("SELECT * FROM watches WHERE id = ?");
            $stmt->execute([$wID]);
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($res) <= 0 || !isset($res)) $err = true;
            else $watch = $res[0];
        } else {
            $stmt = $connection->query("SELECT * FROM watches WHERE name = ?");
            $stmt->execute($wID);
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($res) <= 0 || !isset($res)) $err = true;
            else $watch = $res[0];
        }

        if ($err) echo $connection->query("SELECT txt FROM translations WHERE name = 'watchNotFound' AND FIND_IN_SET('$lang', langs)")->fetchAll()[0][0];
        else {
            $wID = $watch['id'];

            $characteristics = $connection->query("SELECT txt FROM translations WHERE name = 'characteristics' AND FIND_IN_SET('$lang', langs)")->fetchAll()[0][0];
            $timeTitle = $connection->query("SELECT txt FROM translations WHERE name = 'timeTitle' AND FIND_IN_SET('$lang', langs)")->fetchAll()[0][0];
            $timeSys = $connection->query("SELECT txt FROM translations WHERE name = 'timeType" . $watch['timeType'] . "' AND FIND_IN_SET('$lang', langs)")->fetchAll()[0][0];
            $price = $connection->query("SELECT txt FROM translations WHERE name = 'price' AND FIND_IN_SET('$lang', langs)")->fetchAll()[0][0];
            $braceletTitle = $connection->query("SELECT txt FROM translations WHERE name = 'braceletTitle' AND FIND_IN_SET('$lang', langs)")->fetchAll()[0][0];
            $braceletType = $connection->query("SELECT txt FROM translations WHERE name = 'braceletType" . $watch['braceletType'] . "' AND FIND_IN_SET('$lang', langs)")->fetchAll()[0][0];

            echo "<h2>" . $watch['name'] . "</h2>
            <img src='/images/watch/montre_$wID.png'>
            <p>" . $watch['description'] . "</p>
            <h3>$characteristics :</h4>
            <ul>
                <li>$price : <span class='info'>" . $watch['price'] . "€</span></li>
                <li>$timeTitle : <span class='info'>" . $timeSys . "</span></li>
                <li>$braceletTitle : <span class='info'>" . $braceletType . "</span></li>
            </ul>";
        }
        ?>

    </main>

    <?php
    getPageTopButton();
    getPageFooter();
    ?>
</body>

</html>