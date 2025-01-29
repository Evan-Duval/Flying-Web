<?php

// Récupération et validation des données
$aeroport_id = isset($_GET['aeroport']) ? $_GET['aeroport'] : null;
$city = $_POST['city'] ?? null;
$maxLenght = $_POST['maxLenght'] ?? null;
$capacity = $_POST['capacity'] ?? null;

// Vérification de l'ID d'aéroport
if (!$aeroport_id) {
    echo json_encode([
        'type' => 'error',
        'message' => 'Erreur : ID de l\'aéroport non fourni.'
    ]);
    exit;
}

// Validation des données
if (!$city || !preg_match('/^[a-zA-ZÀ-ÿ\s]+$/u',$city)) {
    echo json_encode([
        'type' => 'error',
        'message' => 'Erreur : Le champ ville doit être une chaîne de caractères valide.'
    ]);
    exit;
}

if (!$maxLenght || !in_array($maxLenght, ['Petit', 'Moyen', 'Grand'])) {
    echo json_encode([
        'type' => 'error',
        'message' => 'Erreur : La taille de l\'aéroport est invalide (Petit, Moyen, Grand uniquement).'
    ]);
    exit;
}

if (!$capacity || !ctype_digit($capacity)) {
    echo json_encode([
        'type' => 'error',
        'message' => 'Erreur : La capacité doit être un nombre entier valide.'
    ]);
    exit;
}

// Préparation des données pour l'API
$data = array(
    'city' => $city,
    'maxLenght' => $maxLenght,
    'capacity' => $capacity,
);

// Configuration de la requête cURL pour une méthode PUT
$ch = curl_init('http://127.0.0.1:8000/api/aeroport/update/' . urlencode($aeroport_id));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); // Configuration explicite pour une requête PUT
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Les données à envoyer
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Accept: application/json',
    'Content-Length: ' . strlen(json_encode($data)) // Longueur du contenu
));

// Exécution de la requête
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Gestion de la réponse
$result = json_decode($response, true);
if ($httpCode == 202) {
    echo json_encode([
        'type' => 'success',
        'message' => 'Succès : Aéroport modifié avec succès !'
    ]);
} else {
    $errorMessage = isset($result['message']) ? "Erreur : " . $result['message'] : "Une erreur est survenue lors de la modification de l'aéroport.";
    echo json_encode([
        'type' => 'error',
        'message' => $errorMessage
    ]);
}
?>
