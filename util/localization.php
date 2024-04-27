<?php
// Fichier pour traduction anglais-français

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
bindtextdomain('fr', realpath('../') . DIRECTORY_SEPARATOR . 'localization');

$lg = getClientLang(['fr', 'en']);
if (isset($_COOKIE['lang']))
    $lg = Language::tryFrom($_COOKIE['lang']) ?? $lg;

define('LANGUAGE', $lg);

textdomain($lg->value);

// Recherche la première langue acceptée par le client qui est aussi supportée par le site
function getClientLang($checklanguages, $default = Language::English): Language
{
    if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
        $langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
        foreach ($langs as $value) {
            $getlang = substr($value, 0, 2);
            if (in_array($getlang, $checklanguages)) {
                $test = Language::tryFrom($getlang);
                if(isset($test)) return $test;
            }
        }
    }
    //Return default.
    return $default;
}