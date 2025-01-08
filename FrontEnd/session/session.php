<?php
session_start();

if (!isset($_SESSION['auth_token'])) {
    die("Veuillez vous connecter pour accéder à cette page");
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

$user = json_decode($response, true);

// Vérifiez si la requête a réussi
if ($httpCode == 200) {
    return $user;
} else {
    echo "Impossible de récupérer les informations de l'utilisateur.";
}
