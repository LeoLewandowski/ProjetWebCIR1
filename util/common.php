<?php
require('localization.php');
// File used to incude HTML Elements common to multiple pages, such as the header and the footer

define('DB_HOSTNAME', "127.0.0.1");
define('DB_NAME', "octime");
define('DB_USERNAME', "root");
define('DB_PASSWORD', "");

function getPageHeader($pageName = '', $uInfo = null)
{
    if(empty($uInfo) && is_array($pageName)){
        $uInfo = $pageName;
        $pageName = null;
    }
    ?>
    <header>
        <a id="logo-header" href="/">
            <picture class="img-theme">
                <source srcset="/images/logo.svg" media="(min-width:992px)">
                <img src="/images/logo_short.svg">
            </picture>
        </a>
        <button id="nav-button" onclick="openNav()">
            <svg class="img-theme" width="50" height="50">
                <line x1="0" y1="50%" x2="100%" y2="50%" class="nav-btn-bar" id="nav-btn-bar1" />
                <line x1="0" y1="50%" x2="100%" y2="50%" class="nav-btn-bar" id="nav-btn-bar2" />
                <line x1="0" y1="50%" x2="100%" y2="50%" class="nav-btn-bar" id="nav-btn-bar3" />
            </svg>
        </button>
        <nav id="nav">
            <a href="/history" <?= $pageName == 'history' ? 'style="color: var(--theme-accent-color);"' : '' ?> >Présentation</a>
            <a href="/concept" <?= $pageName == 'concept' ? 'style="color: var(--theme-accent-color);"' : '' ?> >Concept</a>
            <a href="/products" <?= $pageName == 'products' ? 'style="color: var(--theme-accent-color);"' : '' ?> >Produits</a>
            <a href="/team" <?= $pageName == 'team' ? 'style="color: var(--theme-accent-color);"' : '' ?> >Notre équipe</a>
            <a href="/contact" <?= $pageName == 'contact' ? 'style="color: var(--theme-accent-color);"' : '' ?> >Contact</a>
        </nav>
        <a id="login" class="center container-vertical" title="<?= isset($uInfo) ? _('Your account') . ($uInfo['admin'] ? '" href="/admin"' : '" href="/account"') : _(Localization::LOGIN->value) . '" href="/login"' ?>"><img id="pfp" src="/images/<?= isset($uInfo) ? ('pfp/' . $uInfo['id'] . '.' . $uInfo['pfp_extension']) : 'login.svg" class="img-theme' ?>" ></a>
    </header>
    <?php
}

function getPageFooter()
{
    ?>
    <footer>
        Projet Web - Décembre 2023
        <a href="/conditions">Conditions d\'utilisation</a>
    </footer>
    <?php
}

function getPageTopButton()
{
    echo '<a id="up" href="#"><img src="/images/arrow.svg"></a>';
}

function getPageHead(string $title, string|null $cssFileName = '')
{
    ?>
    <title><?= $title ?></title>
    <link rel="stylesheet" href="/css/main.css">
    <link rel="icon" href="/images/clock.svg">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        function openNav(force = null){
            if(force === false || (force === null && document.querySelector('header').classList.contains('nav-opened'))) document.querySelector('header').classList.remove('nav-opened');
            else document.querySelector('header').classList.add('nav-opened');
        }
    </script>
    <?php 
    if ($cssFileName)
        echo '<link rel="stylesheet" href="/css/' . $cssFileName . '.css">';
}

// Convertit une couleur HSL en RGB
function ColorHSLToRGB($h, $s, $l)
{
    // Définition des valeurs rgb
    $r = $l;
    $g = $l;
    $b = $l;
    // Valeur HSL
    $v = ($l <= 0.5) ? ($l * (1.0 + $s)) : ($l + $s - $l * $s);
    if ($v > 0) {
        // Définition variables nécessaires
        $m = $sv = $sextant = $fract = $vsf = $mid1 = $mid2 = 0;

        $m = $l + $l - $v;
        $sv = ($v - $m) / $v;
        $h *= 6.0;
        $sextant = floor($h);
        $fract = $h - $sextant;
        $vsf = $v * $sv * $fract;
        $mid1 = $m + $vsf;
        $mid2 = $v - $vsf;

        switch ($sextant) {
            case 0:
                $r = $v;
                $g = $mid1;
                $b = $m;
                break;
            case 1:
                $r = $mid2;
                $g = $v;
                $b = $m;
                break;
            case 2:
                $r = $m;
                $g = $v;
                $b = $mid1;
                break;
            case 3:
                $r = $m;
                $g = $mid2;
                $b = $v;
                break;
            case 4:
                $r = $mid1;
                $g = $m;
                $b = $v;
                break;
            case 5:
                $r = $v;
                $g = $m;
                $b = $mid2;
                break;
        }
    }
    return array('r' => $r * 255.0, 'g' => $g * 255.0, 'b' => $b * 255.0);
}

function createPfp(string $imageName, string $text, int $width = 500, int $height = 500, int $minPadding = 100): bool|null
{
    // Paramètre pour la taille de police
    $fontSize = 800;

    // Crée une image avec les dimensions données
    $im = imagecreate($width, $height)
        or die("Cannot Initialize new GD image stream");

    // Définit une couleur de fond à partir d'une couleur HSL. On utilise HSL pour obtenir une couleur pastel,
    // que l'on décode ensuite en RGB pour l'allocation sur l'image
    $randomRGB = ColorHSLToRGB(random_int(0, 359) / 360, 1, 0.8);
    $background_color = imagecolorallocate($im, $randomRGB['r'], $randomRGB['g'], $randomRGB['b']);

    // Le texte est écrit en noir
    $text_color = imagecolorallocate($im, 0, 0, 0);

    // On réduit la taille de la police jusqu'à ce que le texte rentre dans l'image, avec un
    // padding minimum (défini par le paramètre `$minPadding`) entre le texte et le bord de l'image
    do {
        $fontSize -= 1;
        // On dessine le texte, puis on récupère les coordonnées des 4 points du rectangle de texte
        $rect = imagettftext($im, $fontSize, 0, 0, 0, $text_color, '../font/arial.ttf', $text);
        $minX = min(array($rect[0], $rect[2], $rect[4], $rect[6]));
        $maxX = max(array($rect[0], $rect[2], $rect[4], $rect[6]));
        $minY = min(array($rect[1], $rect[3], $rect[5], $rect[7]));
        $maxY = max(array($rect[1], $rect[3], $rect[5], $rect[7]));

        // On définit la "boîte" qui contient le texte
        $box = array(
            "left" => abs($minX) - 1,
            "top" => abs($minY) - 1,
            "width" => $maxX - $minX,
            "height" => $maxY - $minY
        );
    // Tant que la taille de la boîte plus le padding minimum (fois 2 car des deux côtés) est supérieur
    // à la taille de l'image, on répète la boucle (rétrécissement de la taille de police, check, etc.)
    } while ($box['width'] + 2 * $minPadding > $width || $box['height'] + 2 * $minPadding > $height);

    // On définit des paddings en fonction de la taille de la boîte de texte et de l'espace inutilisé
    // Permet de centrer le texte au milieu de l'image
    $topPadding = $box['top'] + ($height - $box['height']) / 2;
    $leftPadding = -$box['left'] + ($width - $box['width']) / 2;

    // Rectangle pour mettre le fond de l'image + recouvrir les textes précédents (essais de taille)
    imagefilledrectangle($im, 0, 0, $width, $height, $background_color);

    // Ecriture du texte au centre de l'image, avec la bonne taille
    imagettftext($im, $fontSize, 0, $leftPadding, $topPadding, $text_color, '../font/arial.ttf', $text);

    // Enregistrement de l'image sous format PNG
    imagepng($im, '../images/pfp/' . $imageName);

    // Image non nécessaire ; on la détruit
    imagedestroy($im);

    // L'opération s'est terminée ; on renvoiei true
    return true;
}