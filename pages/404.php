<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/util/common.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/util/connection.php');
    getPageHead(_('Page not found'));
    ?>
</head>
<body>
    <?php
    getPageHeader($userInfo);
    ?>
    <h1>404</h1>
    <h2><?= _("Oops, seems the page you just requisted doesn't exist !") ?></h2>
    <?php
    getPageFooter();
    ?>
</body>
</html>