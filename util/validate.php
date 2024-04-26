<?php

// Nettoie la chaîne de caractères passée en paramètre
function cleanData(string|null $data) : string {
    // Enlève les espaces en trop, formate les backslash et les caractères spéciaux html 
    return htmlspecialchars(stripslashes(trim($data)));
}

// Vérifie la validité d'un nom ou d'un prénom
function validateName(string|null $name) : bool {
    return isset($name)
    // Nom / prénom composé seulement de lettres (ou caractères type idéogrammes), tirets, espaces ou
    // apostrophes et contenant entre 1 et 64 caractères.
    // \p{L} matche toutes les lettres possibles, y compris celles avec accents et de type idéogramme
    // le u à la fin du RegEx est nécessaire pour préciser l'encodage Unicode, pour matcher les accents
        && preg_match("/^[\p{L}\-']{1,64}$/u", $name);
}

// Vérifie la validité d'un mot de passe
function validatePassword(string|null $password) : bool {
    return isset($password)
    // MdP contient au moins 1 lettre latine non accentuée
        && preg_match("/[a-zA-Z]+/", $password)
    // MdP contient au moins 1 chiffre
        && preg_match("/[0-9]+/", $password)
    // MdP contient au moins 1 caractère spécial
        && preg_match("/[\\*\/+\-_=#~&@$]+/", $password)
    // Longueur entre 8 et 64 caractères et composé seulement les caractères susmentionnés
        && preg_match("/^[a-zA-Z0-9\\*\/+\-_=#~&@$]{8,64}$/", $password);
}

// Vérifie la validité d'un email
function validateEmail(string|null $email) : bool {
    return isset($email)
    // Vérifie si l'email est valide ou non
        && filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Vérifie si une date sous format textuel est bien valide
function validateDate(string|null $date) : bool {
    if(!isset($date)) return false;
    $dt = strtotime($date);
    return isset($date)
    // Vérifie que le texte est bien convertissable en date, que cette date est antérieure à aujourd'hui
    // et postérieure au 1er janvier 1900
        && $dt
        && $dt < time()
        && $dt > strtotime('1900-01-01');
}

function validateId(string|null $id) : bool {
    return isset($id)
        && strlen($id) == 23
        && preg_match('/^[a-z0-9]{14}\.[a-z0-9]{8}$/', $id);
}