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
            echo _("<h3>Sorry, this watch is unavailable</h3><br><h4>Please go back to the <a href=\"/products\">products page</a></h4>");
        else {
            $wID = $watch['id'];

            ?>
            <h2><?= $watch['name'] ?></h2>
            <div id="watchDisplay" class="display-box"><img src='/images/watch/montre_<?= $wID ?>.png'></div>
            <p class="display-box"><?= _($watch['description_' . LANGUAGE->value]) ?></p>
            <h3><?= _('Characteristics') ?></h4>
                <ul class="display-box">
                    <li><?= _('Price') ?> : <span class='info'><?= $watch['price'] ?>€</span></li>
                    <li><?= _('Time system') ?> : <span
                            class='info'><?= _(TimeType::tryFrom($watch['timeType'])->name) ?></span></li>
                    <li><?= _('Bracelet material') ?> : <span
                            class='info'><?= _(BraceletMaterial::tryFrom($watch['braceletType'])->name) ?></span></li>
                </ul>
                <?php if ($userInfo['admin']) { ?>
                    <form class="generic-form" action="/admin/watches/edit" method="get">
                        <input type="hidden" name="id" value="<?= $wID ?>">
                        <input type="submit" value="<?= _('Update watch') ?>">
                    </form>
                <?php } else { ?>
                    <h3><?= _('Add to cart') ?></h3>
                    <form class="form-generic display-box center" action="addcart" method="post">
                        <input type="hidden" name="product_id" value="<?= $wID ?>">
                        <div class="input-box">
                            <input type="number" placeholder=" " name="quantite" min="1" value="1" max="10">
                            <label><?= _('Quantity') ?></label>
                        </div>
                        <input type="submit" id="addcart" value="<?= _('Add to cart') ?>">
                    </form>
                <?php }
        } ?>

    </main>

    <?php
    getPageTopButton();
    getPageFooter();
    ?>
</body>

</html>