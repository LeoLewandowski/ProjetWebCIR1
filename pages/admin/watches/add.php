<?php

require_once ($_SERVER['DOCUMENT_ROOT'] . '/util/common.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/util/connection.php');

// Si l'utilisateur n'est pas admin, on affiche la page 404 à la place
if (!$userInfo['admin']) {
    require ('../404.php');
    die();
}

$invalid = false;

$wName = $wDescEn = $wDescFr = 'default';
$wPrice = $wBracelet = $wTime = null;

$imgError = $priceError = $braceletError = $timeError = null;

// Si l'admin a modifié la montre
if (isset($_POST['add']) && !$invalid) {
    // On vérifie la validité des inputs
    if (isset($_POST['name']))
        $wName = cleanData($_POST['name']);
    if (isset($_POST['description_en']))
        $wDescEn = cleanData($_POST['description_en']);
    if (isset($_POST['description_fr']))
        $wDescFr = cleanData($_POST['description_fr']);
    if (isset($_POST['price']) && is_numeric($_POST['price']))
        $wPrice = (int) $_POST['price'];
    else
        $priceError = _('The price must be an integer');

    if (isset($_POST['braceletType']))
        $wBracelet = BraceletMaterial::tryFrom($_POST['braceletType']);
    if (empty($braceletType))
        $braceletError = _('Invalid value for') . ' : ' . _('Bracelet type');

    if (isset($_POST['timeType']))
        $wTime = TimeType::tryFrom($_POST['timeType']);
    if (empty($timeType))
        $timeError = _('Invalid value for') . ' : ' . _('Time type');

    $stmt = $connection->prepare("INSERT INTO watches (name, description_en, description_fr, price, timeType, braceletType) VALUES (?, ?, ?, ?, ?, ?)");
    $code = $stmt->execute([$wName, $wDescEn, $wDescFr, $wPrice, $wTime->value, $wBracelet->value]);
    $wId = (int)$connection->lastInsertId();

    // Si l'image a aussi été modifiée
    if ($code && isset($_FILES['watch']) && $_FILES['watch']['error'] != 4) {
        $img = $_FILES['watch'];
        if ($img['error'] == 0 && $img['size'] <= 30_000_000 && $img['type'] == 'image/png')
            move_uploaded_file($img['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/images/watch/montre_' . $wId . '.png');
        else
            $imgError = _('This picture does not respect the rules !');
    }

    if (empty($imgError) && empty($braceletError) && empty($timeError) && empty($priceError)) echo 'lol';
        // header('location: ../watches');
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    getPageHead(_('Add watch'), 'admin');
    ?>
    <link rel="stylesheet" href="/css/watch.css">
    <script src="/util/imageChange.js"></script>
</head>

<body>
    <?php
    getPageHeader('admin', $userInfo);
    ?>

    <main>
        <form id="watchEdit" class="form-generic center" enctype="multipart/form-data" action="#account-info"
            method="post">
            <div id="watchDisplay" class="display-box">
                <img id="watchImage" src='/images/placeholder.svg'>
                <div id="watchOverlay" onclick="document.getElementById('watchImageInput').click()">
                    <input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
                    <input id="watchImageInput" type="file" name="watch" hidden
                        onchange="updateImage(this.files, 'watchImage')" accept="image/png">
                    <p>Change image</p>
                </div>
                <?php if (isset($imgError))
                    echo $imgError; ?>
            </div>
            <div class="input-box">
                <input type="text" placeholder=" " name="name" required>
                <label><?= _('Name') ?></label>
            </div>
            <div class="input-box force-anim">
                <textarea rows="12" cols="50" placeholder=" " name="description_en"
                    required></textarea>
                <label><?= _('Watch description (English)') ?></label>
            </div>
            <div class="input-box force-anim">
                <textarea rows="12" cols="50" placeholder=" " name="description_fr"
                    required></textarea>
                <label><?= _('Watch description (French)') ?></label>
            </div>
            <h3><?= _('Characteristics') ?></h3>
            <div class="error-wrapper">
                <div class="input-box">
                    <input type="number" name="price" placeholder=" ">
                    <label><?= _('Price') ?></label>
                </div>
                <?php if ($priceError)
                    echo "<span class='error'>$priceError</span>" ?>
                </div>
                <div class="error-wrapper">
                    <div class="input-box force-anim">
                        <label><?= _('Time system') ?> </label>
                    <select name="timeType">
                        <option value='O'>
                            <?= _('Octal') ?>
                        </option>
                        <option value='D'>
                            <?= _('Duodecimal') ?>
                        </option>
                    </select>
                </div>
                <?php if ($timeError)
                    echo "<span class='error'>$timeError</span>" ?>
                </div>
                <div class="error-wrapper">
                    <div class="input-box force-anim">
                        <label><?= _('Bracelet material') ?></label>
                    <select name="braceletType">
                        <option value='L'>
                            <?= _('Leather') ?>
                        </option>
                        <option value='S'><?= _('Silicone') ?></option>
                        <option value='M'>
                            <?= _('Metal') ?>
                        </option>
                    </select>
                </div>
                <?php if ($braceletError)
                    echo "<span class='error'>$braceletError</span>" ?>
                </div>
                <input type="submit" name="add" value="<?= _('Add watch') ?>">
        </form>

    </main>

    <?php
    getPageTopButton();
    getPageFooter();
    ?>
</body>

</html>