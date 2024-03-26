<?php
// File used to incude HTML Elements common to multiple pages, such as the header and the footer

enum Language:string {
    case French = 'fr';
    case English = 'en';
}

$lg = Language::French;
if(isset($_COOKIE['lang'])) $lg = Language::from($_COOKIE['lang']);

define('LANGUAGE', $lg);

function getPageHeader( string|null $pageName = '' ) {
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
            <a href="/history"'. ($pageName == 'history' ? 'style="color: var(--theme-accent-color);"' : '') .'>Présentation</a>
            <a href="/concept"'. ($pageName == 'concept' ? 'style="color: var(--theme-accent-color);"' : '') .'>Concept</a>
            <a href="/products"'. ($pageName == 'products' ? 'style="color: var(--theme-accent-color);"' : '') .'>Produits</a>
            <a href="/team"'. ($pageName == 'team' ? 'style="color: var(--theme-accent-color);"' : '') .'>Notre équipe</a>
            <a href="/contact"'. ($pageName == 'contact' ? 'style="color: var(--theme-accent-color);"' : '') .'>Contact</a>
        </nav>
        <a id="login" class="center container-vertical" title="Se connecter" href="/login"><img
                src="/images/login.svg" class="img-theme"></a>
    </header>';
}

function getPageFooter() {
    echo '
    <footer>
        Projet Web - Décembre 2023
        <a href="/conditions">Conditions d\'utilisation</a>
    </footer>';
}

function getPageTopButton() {
    echo '<a id="up" href="#"><img src="/images/arrow.svg"></a>';
}

function getPageHead( string $title, string|null $cssFileName = '') {
    echo '
    <title>'.$title.'</title>
    <link rel="stylesheet" href="/css/main.css">
    <link rel="icon" href="/images/clock.svg">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">';
    if($cssFileName) echo '<link rel="stylesheet" href="/css/'.$cssFileName.'.css">';
}