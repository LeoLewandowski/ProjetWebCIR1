<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/util/common.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/util/connection.php');

// Si l'utilisateur n'est pas admin, on affiche la page 404 à la place
if (!$userInfo['admin']) {
    require ('../404.php');
    die();
}

$params = [];
$err = $result = null;

$timeType = $_GET['timeType'] ?? "";
$braceletType = $_GET['braceletType'] ?? "";
$minPrice = $_GET['minPrice'] ?? "";
$maxPrice = $_GET['maxPrice'] ?? "";

$req = "SELECT * FROM watches WHERE 1=1";

if (isset($timeType) && $timeType != '') {
    $req .= " AND timeType = :timeType";
    $params['timeType'] = $timeType;
}

if (isset($braceletType) && $braceletType != '') {
    $req .= " AND braceletType = :$braceletType";
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

$stmt = $connection->prepare($req);

if (!$stmt->execute($params))
    $err = _('Sorry, an unknown error occured');
else
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    getPageHead(_('Admin - product management'), 'admin');
    ?>
    <link rel="stylesheet" href="/css/products.css">
</head>

<body>
    <?php
    getPageHeader($userInfo);
    ?>
    <h1><?= _('Watch management') ?></h1>
    <main>
        <form class="filters" method="get">
            <h3>Filtres</h3>
            <div>
                <label for="timeType">Montres</label>
                <select name="timeType" id="hsystem">
                    <?php
                    echo "<option value=''" . ($timeType == "" ? " selected" : '') . ">Toutes</option>"
                        . "<option value='O'" . ($timeType == "O" ? " selected" : '') . ">Octales</option>"
                        . "<option value='D'" . ($timeType == "D" ? " selected" : '') . ">Dodécales</option>";
                    ?>
                </select>
            </div>
            <div>
                <label for="braceletType">Bracelets</label>
                <select name="braceletType" id="wrist">
                    <?php
                    echo "<option value=''" . ($braceletType == "" ? " selected" : '') . ">Tous</option>"
                        . "<option value='L'" . ($braceletType == "L" ? " selected" : '') . ">Cuir</option>"
                        . "<option value='S'" . ($braceletType == "S" ? " selected" : '') . ">Silicone</option>"
                        . "<option value='M'" . ($braceletType == "M" ? " selected" : '') . ">Métal</option>";
                    ?>
                </select>
            </div>
            <div>
                <label>Intervalle de prix</label>
                <?php
                echo "<input name='minPrice' type='number' placeholder='50€' value='$minPrice'>"
                    . "<input name='maxPrice' type='number' placeholder='500€' value='$maxPrice'>";
                ?>
            </div>
            <input type="submit" value="Appliquer">
        </form>
        <?php
        if (isset($_SESSION['watchDeleted'])) {
            echo '<span class="confirm">' . _('Watch deleted successfully') . '</span>';
            $_SESSION['watchDeleted'] = null;
        }
        if (isset($_SESSION['watchEdited'])) {
            echo '<span class="confirm">' . _('Watch edited successfully') . '</span>';
            $_SESSION['watchEdited'] = null;
        }
        if (isset($_SESSION['error'])) {
            echo '<span class="error">' . _('An error occured') . '</span>';
            $_SESSION['error'] = null;
        }
        ?>
        <table class="mainTable">

            <thead>
                <th><?= _('Actions') ?></th>
                <th><?= _('Name') ?></th>
                <th><?= _('Description') ?></th>
                <th><?= _('Price') ?></th>
                <th><?= _('Bracelet') ?></th>
                <th><?= _('Time system') ?></th>
            </thead>
            <tbody>
                <?php
                if (isset($err))
                    echo $err;
                else if (count($result) < 1)
                    echo _("<div><h3>No watch match these filters</h3><h4 style='color:grey'>Please try something else</h4></div>");
                else
                    foreach ($result as $watch) {
                        $desc = $watch['description_' . LANGUAGE->value];
                        if (strlen($desc) > 64)
                            $desc = substr($desc, 0, 64) . '<span style="color:gray;">...</span>';
                        ?>
                            <tr>
                                <td>
                                    <a href="./watches/edit?id=<?= $watch['id'] ?>">📝Edit</a>
                                    <a href="./watches/delete?id=<?= $watch['id'] ?>">❌Delete</a>
                                </td>
                                <td><?= $watch['name'] ?></td>
                                <td><?= $desc ?></td>
                                <td><?= $watch['price'] ?> €</td>
                                <td><?= _(BraceletMaterial::tryFrom($watch['braceletType'])->name) ?></td>
                                <td><?= _(TimeType::tryFrom($watch['timeType'])->name) ?></td>
                            </tr>
                        <?php
                    }
                ?>
                <tr>
                    <td id="addWatch" colspan=6>
                        <div>
                            <a href="./watches/add">
                                <svg width="64" height="64" stroke-width="4" stroke-linecap="round" viewBox="0 0 64 64">
                                    <circle cx="32" cy="32" r="28" fill="none" stroke-dasharray="8 14" />
                                    <line x1="31.5" x2="31.5" y1="15" y2="48" />
                                    <line x1="15" x2="48" y1="31.5" y2="31.5" />
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </main>
    <?php
    getPageFooter();
    ?>
</body>

</html>