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
        <h2>Montre</h2>
        <?php
        var_dump($_GET['id']);
        ?>
    </main>

    <?php
    getPageTopButton();
    getPageFooter();
    ?>
</body>

</html>