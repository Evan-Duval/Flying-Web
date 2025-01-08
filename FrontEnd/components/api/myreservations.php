<?php

if (!isset($_SESSION['auth_token']) || (!isset($user))) {
    die("<p style=\"color:white; font-size:2em; text-align:center;\">Veuillez vous connecter pour accéder à cette page. <a style=\"display: inline-block;
    color: #000; text-decoration: none;\"href=\"../connexion/connexion.php\">Se connecter</a></p>");
}

// Configuration de la requête pour obtenir l'utilisateur
$ch = curl_init('http://127.0.0.1:8000/api/reservation/get-by-user/' . $user['id']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
