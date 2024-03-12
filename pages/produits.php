<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    require_once('../util/common.php');
    getPageHead('Produits', 'products');
    ?>
</head>

<body>
    <?php
    getPageHeader('produits');
    ?>

    <main>
        <form class="filters">
            <h3>Filtres</h3>
            <div>
                <label for="hsystem">Montres</label>
                <select name="hsystem" id="hsystem">
                    <option value="">Toutes</option>
                    <option value="oct">Octales</option>
                    <option value="dod">Dodécales</option>
                </select>
            </div>
            <div>
                <label for="wrist">Bracelets</label>
                <select name="wrist" id="wrist">
                    <option value="">Tous</option>
                    <option value="leather">Cuir</option>
                    <option value="silicone">Silicone</option>
                    <option value="metal">Métal</option>
                </select>
            </div>
            <div>
                <label>Intervalle de prix</label>
                <input name="minPrice" type="number" placeholder="50€">
                <input name="maxPrice" type="number">
            </div>
            <input type="submit" value="Appliquer">
        </form>
        <section class="products">
            <?php
            $i = 0;
            foreach(scandir("../images/watch/") as $watch) {
                if(is_dir($watch)) continue;
                $i++;
                echo
               "<a href='/watch?id=$i'>
                    <img src=\"/images/watch/$watch\">
                    <p>Montre $i</p>
                </a>";
            }
            ?>
            
        </section>
    </main>

    <?php
    getPageTopButton();
    getPageFooter();
    ?>
</body>

</html>