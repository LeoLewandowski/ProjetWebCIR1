<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/util/common.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/util/connection.php');
    getPageHead(_('The Octeam'), 'team')
        ?>
</head>

<body>
    <?php
    getPageHeader('team', $userInfo);
    ?>

    <main>
        <h1><?= _('Our team') ?> </h1>
        <h4><?=  _('This website is brought to you by our finest team of devs from ISEN Lille') ?></h4>
        <div class="pfp">
            <div>
                <span class="rond">
                    <?= _('Lead <br> Home, products and watch management pages <br> Logo design <br> Global help') ?>
                </span>
                <img src="/images/pfp_leo.gif">
                <h5> Lewandowski Léo </h5>
            </div>
            <div>
                <span class="rond">
                    <?= _('Writing of the site\'s text <br> History and contact pages') ?>
                </span>
                <img src="/images/pfp_mathis.png">
                <h5>Van Uytvanck Mathis</h5>
            </div>
            <div>
                <span class="rond">
                    <?= _('Login, signup and shopping cart pages <br> Report writing') ?>
                </span>
                <img src="/images/pfp_simon.gif">
                <h5>Leroy Simon</h5>
            </div>
            <div>
                <span class="rond">
                    <?= _('Messages management page <br> Artistic direction') ?>
                </span>
                <img src="/images/pfp_adele.png">
                <h5>Lebrun Adèle</h5>
            </div>
            <div>
                <span class="rond">
                    <?= _('Cart, conditions and concept pages') ?>
                </span>
                <img src="/images/pfp_sasha.png">
                <h5> Le Roux Zielinski Sasha </h5>
            </div>
        </div>

    </main>

    <?php
    getPageTopButton();
    getPageFooter();
    ?>
</body>

</html>