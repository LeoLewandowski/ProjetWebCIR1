<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/util/common.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/util/connection.php');
    getPageHead('Montre', 'products');
    ?>
</head>

<body>
    <?php
    getPageHeader('products', $userInfo);
    ?>

    <main>
        <?php
        $lang = $_GET['lang'] ?? LANGUAGE->value;
        $valid = false;

        $wID = $_GET['id'];
        if (is_numeric($wID)) {
            $stmt = $connection->prepare("SELECT * FROM watches WHERE id = ?");
            $stmt->execute([$wID]);
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($res) <= 0 || !isset($res)) $valid = true;
            else $watch = $res[0];
        } else {
            $stmt = $connection->query("SELECT * FROM watches WHERE name = ?");
            $stmt->execute($wID);
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($res) <= 0 || !isset($res)) $valid = true;
            else $watch = $res[0];
        }

        if ($valid) echo _(Localization::ERROR_WATCH_NOT_FOUND->value);
        else {
            $wID = $watch['id'];

            $characteristics = _(Localization::CHARACTERICS->value);
            $timeTitle = _(Localization::TIME_SYSTEM->value);
            $timeSys = _(TimeType::tryFrom($watch['timeType'])->name ?? Localization::ERROR_DEFAULT);
            $price = _(Localization::PRICE->value);
            $braceletTitle = _(Localization::BRACELET_COMPOSITION->value);
            $braceletType = _(BraceletMaterial::tryFrom($watch['braceletType'])->name ?? Localization::ERROR_DEFAULT);


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