<?php
// File used to incude HTML Elements common to multiple pages, such as the header and the footer
require_once ('connection.php');
enum Localization: string
{

    #region INVALID_INPUTS
    case VALUE_INVALID = 'This option is invalid, please choose another one';
    case NAME_INVALID = 'This name is invalid. Names must only contain word characters or ideogras, hyphens and apostrophes, and be shorter than 64 characters';
    case PASSWORD_INVALID = 'The password must be between 8 and 64 characters long and can only include the following characters, with at least one of each type :<ul><li>Lower or upper-case latin letters, without accents</li><li>Digits (between 0 and 9)</li><li>Special characters in this list : \\*/+-_=#~&@$</li></ul>';
    case PASSWORD_WRONG = 'Wrong password !';
    case EMAIL_INVALID = 'The given email adress is invalid, or it is longer than 64 characters';
    case EMAIL_USED = "This email adress is already linked to an account";
    case ERROR_EMAIL_UNUSED = "This email adress is not linked to any account";
    case DATE_INVALID = 'The given date must be between today and 1900/01/01';
    case CONDITIONS_UNACCEPTED = 'You must accept the conditions to continue';
    #endregion

    #region ERRORS
    case ERROR_WATCH_NOT_FOUND = "<h3>Sorry, this watch is unavailable</h3><br><h4>Please go back to the <a href=\"/products\">products page</a></h4>";
    case ERROR_DEFAULT = "<span class='error'>An error occured</span>";
    #endregion

    #region INPUT
    case EMAIL = 'Email';
    case NAME = 'Name';
    case SURNAME = 'Surname';
    case PASSWORD = 'Password';
    #endregion

    #region TEXT
    case CHARACTERICS = 'Characteristics';
    case TIME_SYSTEM = 'Time system';
    case PRICE = 'Price';
    case BRACELET_COMPOSITION = 'Bracelet composition';
    case ACCOUNT_INFOS = 'Account informations';
    case GREETING = 'Welcome, ';
    case LOGIN = 'Log in';
    case SIGNUP = 'Sign up';
    case GENDER_NEUTRAL = 'Other / Prefers not to say';
    case GENDER_MALE = 'Male';
    case GENDER_FEMALE = 'Female';
    case GENDER_CIVILITY = 'Gender';
    case BIRTH_DATE = 'Birth date';
    case CONDITIONS_AGREE = 'I agree to the <a href="/conditions">terms and conditions</a> of this website';
    case DANGER_ZONE = 'Danger zone';
    case APPLY_CHANGES = 'Apply changes';
    #endregion
}


enum TimeType: string
{
    case Duodecimal = 'D';
    case Octal = 'O';
}

enum BraceletMaterial: string
{
    case Silicone = 'S';
    case Leather = 'L';
    case Metal = 'M';
}

enum Language: string
{
    case French = 'fr';
    case English = 'en';
}

enum Gender: string
{
    case Male = 'M';
    case Female = 'F';
    case Unspecified = 'N';
}

Locale::setDefault('en');
setlocale(LC_ALL, 'en_US');
putenv('LC_ALL=en_US');
bindtextdomain('main', realpath('../') . DIRECTORY_SEPARATOR . 'localization');
textdomain("main");

$lg = Language::French;
if (isset($_COOKIE['lang']))
    $lg = Language::tryFrom($_COOKIE['lang']) ?? Language::French;

define('LANGUAGE', $lg);

function getPageHeader(string|null $pageName = '')
{
    echo '
    <header>
        <a id="logo-header" href="/">
            <picture class="img-theme">
                <source srcset="/images/logo.svg" media="(min-width:992px)">
                <img src="/images/logo_short.svg">
            </picture>
        </a>
        <button id="nav-button">
            <svg class="img-theme" width="50" height="50">
                <line x1="0" y1="50%" x2="100%" y2="50%" class="nav-btn-bar" id="nav-btn-bar1" />
                <line x1="0" y1="50%" x2="100%" y2="50%" class="nav-btn-bar" id="nav-btn-bar2" />
                <line x1="0" y1="50%" x2="100%" y2="50%" class="nav-btn-bar" id="nav-btn-bar3" />
            </svg>
        </button>
        <nav id="nav">
            <a href="/history"' . ($pageName == 'history' ? 'style="color: var(--theme-accent-color);"' : '') . '>Présentation</a>
            <a href="/concept"' . ($pageName == 'concept' ? 'style="color: var(--theme-accent-color);"' : '') . '>Concept</a>
            <a href="/products"' . ($pageName == 'products' ? 'style="color: var(--theme-accent-color);"' : '') . '>Produits</a>
            <a href="/team"' . ($pageName == 'team' ? 'style="color: var(--theme-accent-color);"' : '') . '>Notre équipe</a>
            <a href="/contact"' . ($pageName == 'contact' ? 'style="color: var(--theme-accent-color);"' : '') . '>Contact</a>
        </nav>
        <a id="login" class="center container-vertical" title="Se connecter" href="/login"><img id="pfp" src="/images/login.svg" class="img-theme"></a>
    </header>';
}

function getPageFooter()
{
    echo '
    <footer>
        Projet Web - Décembre 2023
        <a href="/conditions">Conditions d\'utilisation</a>
    </footer>';
}

function getPageTopButton()
{
    echo '<a id="up" href="#"><img src="/images/arrow.svg"></a>';
}

function getPageHead(string $title, string|null $cssFileName = '')
{
    echo '
    <title>' . $title . '</title>
    <link rel="stylesheet" href="/css/main.css">
    <link rel="icon" href="/images/clock.svg">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">';
    if ($cssFileName)
        echo '<link rel="stylesheet" href="/css/' . $cssFileName . '.css">';
}

function ColorHSLToRGB($h, $s, $l)
{

    $r = $l;
    $g = $l;
    $b = $l;
    $v = ($l <= 0.5) ? ($l * (1.0 + $s)) : ($l + $s - $l * $s);
    if ($v > 0) {
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

function createPfp(string $imageName, string $text): bool|null
{
    $minPadding = 50;
    $fontSize = 800;
    $height = 500;
    $width = 500;

    $im = @imagecreate($width, $height)
        or die("Cannot Initialize new GD image stream");
    $randomRGB = ColorHSLToRGB(random_int(0, 359) / 360, 1, 0.8);
    $background_color = imagecolorallocate($im, $randomRGB['r'], $randomRGB['g'], $randomRGB['b']);
    $rectColor = imagecolorallocate($im, 255, 0, 0);
    $text_color = imagecolorallocate($im, 0, 0, 0);

    do {
        $fontSize -= 1;
        $rect = imagettftext($im, $fontSize, 0, 0, 0, $text_color, '../font/arial.ttf', $text);
        $minX = min(array($rect[0], $rect[2], $rect[4], $rect[6]));
        $maxX = max(array($rect[0], $rect[2], $rect[4], $rect[6]));
        $minY = min(array($rect[1], $rect[3], $rect[5], $rect[7]));
        $maxY = max(array($rect[1], $rect[3], $rect[5], $rect[7]));

        $box = array(
            "left" => abs($minX) - 1,
            "top" => abs($minY) - 1,
            "width" => $maxX - $minX,
            "height" => $maxY - $minY,
            "boundingBox" => $rect
        );
    } while ($box['width'] + 2 * $minPadding > $width || $box['height'] + 2 * $minPadding > $height);

    $topPadding = $box['top'] + ($height - $box['height']) / 2;
    $leftPadding = $box['left'] + ($width - $box['width']) / 2;

    imagefilledrectangle($im, 0, ($height - $box['height']) / 2, $box['width'], $box['height'] + ($height - $box['height']) / 2, $rectColor);
    imagettftext($im, $fontSize, 0, $leftPadding, $topPadding, $text_color, '../font/arial.ttf', $text);
    imagepng($im, '../images/pfp/' . $imageName);
    imagedestroy($im);
    return true;
}