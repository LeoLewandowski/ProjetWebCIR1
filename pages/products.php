<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    require_once('../util/common.php');
    require_once('../util/connection.php');
    getPageHead('Produits', 'products');

    $params = [];

    $timeType = $_GET['timeType'] ?? "";
    $braceletType = $_GET['braceletType'] ?? "";
    $minPrice = $_GET['minPrice'] ?? "";
    $maxPrice = $_GET['maxPrice'] ?? "";

    $req = "SELECT * FROM watches WHERE 1=1";

    if(isset($timeType) && $timeType != '') {
        $req .= " AND timeType = :timeType";
        $params['timeType'] = $timeType;
    }

    if(isset($braceletType) && $braceletType != '') {
        $req .= " AND braceletType = :$braceletType";
        $params['braceletType'] = $braceletType;
    }

    if(isset($minPrice) && $minPrice != '') {
        $req .= " AND price >= :minPrice";
        $params['minPrice'] = $minPrice;
    }
    
    if(isset($maxPrice) && $maxPrice != '') {
        $req .= " AND price <= :maxPrice";
        $params['maxPrice'] = $maxPrice;
    }
    ?>
</head>

<body>
    <?php
    getPageHeader('produits');
    ?>

    <main>
        <form class="filters" method="get">
            <h3>Filtres</h3>
            <div>
                <label for="timeType">Montres</label>
                <select name="timeType" id="hsystem">
                    <?php
                    echo "<option value=''" . ($timeType == "" ? " selected" : '') . ">Toutes</option>"
                    .    "<option value='O'" . ($timeType == "O" ? " selected" : '') . ">Octales</option>"
                    .    "<option value='D'" . ($timeType == "D" ? " selected" : '') . ">Dodécales</option>";
                    ?>
                </select>
            </div>
            <div>
                <label for="braceletType">Bracelets</label>
                <select name="braceletType" id="wrist">
                    <?php
                    echo "<option value=''" . ($braceletType == "" ? " selected" : '') . ">Tous</option>"
                    .    "<option value='L'" . ($braceletType == "L" ? " selected" : '') . ">Cuir</option>"
                    .    "<option value='S'" . ($braceletType == "S" ? " selected" : '') . ">Silicone</option>"
                    .    "<option value='M'" . ($braceletType == "M" ? " selected" : '') . ">Métal</option>";
                    ?>
                </select>
            </div>
            <div>
                <label>Intervalle de prix</label>
                <?php
                echo "<input name='minPrice' type='number' placeholder='50€' value='$minPrice'>"
                .    "<input name='maxPrice' type='number' placeholder='500€' value='$maxPrice'>";
                ?>
            </div>
            <input type="submit" value="Appliquer">
        </form>
        <section class="products">
            <?php

            $empty = true;

            $watches = $connection->prepare($req);
            $watches->execute($params);

            foreach($watches->fetchAll(PDO::FETCH_ASSOC) as $watch){

                $wID = $watch['id'];
                $wName = $watch['name'];
                $wDesc = $watch['description'];

                $empty = false;

                if(strlen($wDesc) > 125) $wDesc = substr($wDesc, 0, 125) . '<span style="color:gray;">...</span>';

                echo
                "<a href='/watch?id=$wID'>
                     <img src=\"/images/watch/montre_$wID.png\">
                     <h3>$wName</h3>
                     <h4>$wDesc</h4>
                 </a>";
            }

            if($empty) echo "
            <div>
                <h3>Aucune montre ne correspond à ces critères</h3>
                <h4 style='color:grey'>Veuillez essayer autre chose</h4>
            </div>";
            ?>
            
        </section>
    </main>

    <?php
    getPageTopButton();
    getPageFooter();
    ?>
</body>

</html>