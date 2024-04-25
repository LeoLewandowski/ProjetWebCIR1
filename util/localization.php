<?php
// Fichier pour traduction anglais-français

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
    case GENDER_CIVILITY = 'Gender';
    case BIRTH_DATE = 'Birth date';
    case CONDITIONS_AGREE = 'I agree to the <a href="/conditions">terms and conditions</a> of this website';
    case DANGER_ZONE = 'Danger zone';
    case APPLY_CHANGES = 'Apply changes';
    case CART_EMPTIED = 'Your cart was successfully emptied !';
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

// Locale::setDefault('en');
// setlocale(LC_ALL, 'en_US');
// putenv('LC_ALL=en_US');
bindtextdomain('main', realpath('../') . DIRECTORY_SEPARATOR . 'localization');
textdomain("main");

$lg = Language::English;
if (isset($_COOKIE['lang']))
    $lg = Language::tryFrom($_COOKIE['lang']) ?? Language::English;

define('LANGUAGE', $lg);