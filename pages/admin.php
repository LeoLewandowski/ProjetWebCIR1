<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/util/common.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/util/connection.php');

// Si l'utilisateur n'est pas admin, on affiche la page 404 à la place
if (!$userInfo['admin']) {
    require('404.php');
    die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    getPageHead(_('Admin - main panel'));
    ?>
    <style>
        main {
            gap: 20px;
        }

        main a {
            border: 2px solid var(--theme-accent-color);
            padding: 10px;
            border-radius: 5px;
            text-decoration: none;
            box-shadow: 0 0 3px 1px var(--theme-accent-color);
        }
    </style>
</head>

<body>
    <?php
    getPageHeader($userInfo);
    ?>
    <h1><?= _('Admin panel') ?></h1>
    <main>
        <a href="/admin/watches">Watch management</a>
        <a href="/admin/messages">Review client messages</a>
    </main>
    <?php
    getPageFooter();
    ?>
</body>

</html>