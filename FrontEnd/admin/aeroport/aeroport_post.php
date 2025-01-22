<?php
include '../../components/api/getall_aeroports.php';

// Récupération et validation des données
$city = $_POST['city'] ?? null;
$maxLenght = $_POST['maxLenght'] ?? null;
$capacity = $_POST['capacity'] ?? null;

if (!empty($aeroports)) {
    foreach ($aeroports as $aeroport) {
        if ($aeroport['city'] == $city) {
            echo json_encode([
                'type' => 'error',
                'message' => 'Erreur : Cette ville existe déjà dans notre base de données.'
            ]);
            exit;
        };
    }
}
if (!ctype_alpha($city)) {
    echo json_encode([
        'type' => 'error',
        'message' => 'Erreur : Le champ ville doit être une chaîne de caractères.'
    ]);
    exit;
}

// Préparation des données pour l'API
$data = array(
    'city' => $city,
    'maxLenght' => $maxLenght,
    'capacity' => $capacity,
);

// Configuration de la requête cURL
$ch = curl_init('http://127.0.0.1:8000/api/aeroport/create');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Accept: application/json'
));

// Exécution de la requête
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Gestion de la réponse
$result = json_decode($response, true);
if ($httpCode == 201 || $httpCode == 200) {
    echo json_encode([
        'type' => 'success',
        'message' => 'Succès : Aéroport ajouté avec succès !'
    ]);
} else {
    $errorMessage = isset($result['message']) ? $result['message'] : "Une erreur est survenue lors de l'insertion de l'aéroport";
    echo json_encode([
        'type' => 'error',
        'message' => $errorMessage
    ]);
}
