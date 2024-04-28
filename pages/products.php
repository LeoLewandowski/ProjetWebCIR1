<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/util/common.php');
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/util/connection.php');
    getPageHead(_('Products'), 'products');

    $params = [];

    $timeType = $braceletType = $minPrice = $maxPrice = "";

    $req = "SELECT * FROM watches WHERE 1=1";

    if (isset($_POST['filter'])) {
        $timeType = $_GET['timeType'] ?? "";
        $braceletType = $_GET['braceletType'] ?? "";
        $minPrice = $_GET['minPrice'] ?? "";
        $maxPrice = $_GET['maxPrice'] ?? "";

        if (isset($timeType) && $timeType != '') {
            $req .= " AND timeType = :timeType";
            $params['timeType'] = $timeType;
        }

        if (isset($braceletType) && $braceletType != '') {
            $req .= " AND braceletType = :braceletType";
            $params['braceletType'] = $braceletType;
        }

        if (isset($minPrice) && $minPrice != '') {
            $req .= " AND price >= :minPrice";
            $params['minPrice'] = $minPrice;
        }

        if (isset($maxPrice) && $maxPrice != '') {
            $req .= " AND price <= :maxPrice";
            $params['maxPrice'] = $maxPrice;
        }
    }
    ?>
</head>

<body>
    <?php
    getPageHeader('products', $userInfo);
    ?>

    <main>
        <form class="filters" method="get">
            <h3><?= _('Filters') ?></h3>
            <div>
                <label for="timeType"><?= _('Time system') ?></label>
                <select name="timeType" id="hsystem">
                    <option value='' <?= $timeType == "" ? " selected" : '' ?>><?= _('All') ?></option>
                    <option value='O' <?= $timeType == TimeType::Octal->value ? " selected" : '' ?>><?= _('Octal') ?>
                    </option>
                    <option value='D' <?= $timeType == TimeType::Duodecimal->value ? " selected" : '' ?>>
                        <?= _('Duodecimal') ?>
                    </option>
                </select>
            </div>
            <div>
                <label for="braceletType"><?= _('Bracelet material') ?></label>
                <select name="braceletType" id="wrist">
                    <option value='' <?= $braceletType == "" ? " selected" : '' ?>><?= _('All') ?></option>
                    <option value='L' <?= $braceletType == BraceletMaterial::Leather->value ? " selected" : '' ?>>
                        <?= _('Leather') ?>
                    </option>
                    <option value='S' <?= $braceletType == BraceletMaterial::Silicone->value ? " selected" : '' ?>>
                        <?= _('Silicone') ?>
                    </option>
                    <option value='M' <?= $braceletType == BraceletMaterial::Metal->value ? " selected" : '' ?>>
                        <?= _('Metal') ?>
                    </option>
                </select>
            </div>
            <div>
                <label><?= _('Price interval') ?></label>
                <?php
                echo "<input name='minPrice' type='number' placeholder='50€' value='$minPrice'>"
                    . "<input name='maxPrice' type='number' placeholder='500€' value='$maxPrice'>";
                ?>
            </div>
            <div class="container-horizontal center">
                <input type="submit" name="filter" value="<?= _('Apply') ?>">
                <input type="submit" name="reset" value="<?= _('Reset') ?>">
            </div>
        </form>
        <section class="products">
            <?php

            $empty = true;

            $watches = $connection->prepare($req);
            $watches->execute($params);

            foreach ($watches->fetchAll(PDO::FETCH_ASSOC) as $watch) {

                $wID = $watch['id'];
                $wName = $watch['name'];

                $empty = false;

                ?>
                <a href='/products/watch?id=<?= $wID ?>'>
                    <img src="/images/watch/montre_<?= $wID ?>.png">
                    <h4><?= $wName ?></h4>
                </a>
            <?php }

            if ($empty)
                echo _("<div><h3>No watch match these filters</h3><h4 style='color:grey'>Please try something else</h4></div>");
            ?>

        </section>
    </main>

    <?php
    getPageTopButton();
    getPageFooter();
    ?>
</body>

</html>