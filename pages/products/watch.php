<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/util/common.php');
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/util/connection.php');

    $invalid = false;

    $wID = $_GET['id'];

    if (is_numeric($wID)) {
        $stmt = $connection->prepare("SELECT * FROM watches WHERE id = ?");
        $stmt->execute([$wID]);
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($res) <= 0 || !isset($res))
            $invalid = true;
        else
            $watch = $res[0];
    } else {
        $stmt = $connection->query("SELECT * FROM watches WHERE name = ?");
        $stmt->execute($wID);
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($res) <= 0 || !isset($res))
            $invalid = true;
        else
            $watch = $res[0];
    }

    getPageHead($invalid ? 'Invalid' : $watch['name'], 'watch');
    ?>
</head>

<body>
    <?php
    getPageHeader('products', $userInfo);
    ?>

    <main>
        <?php
        if ($invalid)
            echo _(Localization::ERROR_WATCH_NOT_FOUND->value);
        else {
            $wID = $watch['id'];

            $characteristics = _(Localization::CHARACTERICS->value);
            $timeTitle = _(Localization::TIME_SYSTEM->value);
            $timeSys = _(TimeType::tryFrom($watch['timeType'])->name ?? Localization::ERROR_DEFAULT);
            $price = _(Localization::PRICE->value);
            $braceletTitle = _(Localization::BRACELET_COMPOSITION->value);
            $braceletType = _(BraceletMaterial::tryFrom($watch['braceletType'])->name ?? Localization::ERROR_DEFAULT);


            ?>
            <h2><?= $watch['name'] ?></h2>
            <div id="watchDisplay" class="display-box"><img src='/images/watch/montre_<?= $wID ?>.png'></div>
            <p class="display-box"><?= _($watch['description_' . LANGUAGE->value]) ?></p>
            <h3><?= $characteristics ?></h4>
            <ul class="display-box">
                <li><?= $price ?> : <span class='info'><?= $watch['price'] ?>€</span></li>
                <li><?= $timeTitle ?> : <span class='info'><?= $timeSys ?></span></li>
                <li><?= $braceletTitle ?> : <span class='info'><?= $braceletType ?></span></li>
            </ul>
            <?php } ?>

    </main>

    <?php
    getPageTopButton();
    getPageFooter();
    ?>
</body>

</html>