<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    require_once('../util/common.php');
    getPageHead('Montre', 'products');
    ?>
</head>

<body>
    <?php
    getPageHeader('produits');
    ?>

    <main>
        <?php
        $ID = $_GET['id'];
        echo "<h2>Montre n°$ID</h2>";
        ?>
    </main>

    <?php
    getPageTopButton();
    getPageFooter();
    ?>
</body>

</html>