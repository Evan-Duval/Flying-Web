<?php

// Supprimer si une session est en cours
include 'resetsession.php';

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 86400, // 24 heures
        'path' => '/',
    ]);
    session_start();
}

if (!isset($_SESSION['auth_token'])) {
    die("<p style=\"color:white; font-size:2em; text-align:center;\">Veuillez vous connecter pour accéder à cette page. <a style=\"display: inline-block;
    color: #000; text-decoration: none;\"href=\"../connexion/connexion.php\">Se connecter</a></p>");
}

// Configuration de la requête pour obtenir l'utilisateur
$ch = curl_init('http://127.0.0.1:8000/api/auth/user');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $_SESSION['auth_token'],
    'Accept: application/json',
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$_SESSION['user'] = json_decode($response, true);

// Vérifiez si la requête a réussi
if ($httpCode == 200) {
    return $_SESSION['user'];
} else {
    die("Une erreur est survenue");
}
