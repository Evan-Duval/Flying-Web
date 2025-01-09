<?php

// Configuration de la requête pour obtenir l'utilisateur
$ch = curl_init('http://127.0.0.1:8000/api/reservation/get-by-user/' . $_SESSION['user']['id']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$_SESSION['user']['reservations'] = json_decode($response, true);

// Vérifiez si la requête a réussi
if ($httpCode == 200) {
    return $_SESSION['user']['reservations'];
} else {
    die("Une erreur est survenue");
}