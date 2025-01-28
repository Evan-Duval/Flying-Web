<?php

$flie_id = isset($_GET['flightId']) ? $_GET['flightId'] : null;
$takeoffTime = $_POST['takeoffTime'] ?? null;
$landingTime = $_POST['landingTime'] ?? null;
$flightNumber = $_POST['flightNumber'] ?? null;
$flightDuration = $_POST['flightDuration'] ?? null;
$plane_id = $_POST['plane_id'] ?? null;
$aeroport_depart_id = $_POST['aeroport_depart_id'] ?? null;
$aeroport_arrive_id = $_POST['aeroport_arrive_id'] ?? null;

if (!$flie_id) {
    echo json_encode([
        'type' => 'error',
        'message' => 'Erreur : ID de l\'aéroport non fourni.'
    ]);
    exit;
}

$data = array(
    'takeoffTime' => $takeoffTime,
    'landingTime' => $landingTime,
    'flightNumber' => $flightNumber,
    'flightDuration' => $flightDuration,
    'plane_id' => $plane_id,
    'aeroport_depart_id' => $aeroport_depart_id,
    'aeroport_arrive_id' => $aeroport_arrive_id,
);

// Configuration de la requête cURL pour une méthode PUT
$ch = curl_init('http://127.0.0.1:8000/api/flies/update/' . urlencode($flie_id));
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
        'message' => 'Succès : Vol modifié avec succès !'
    ]);
} else {
    $errorMessage = isset($result['message']) ? "Erreur : " . $result['message'] : "Une erreur est survenue lors de la modification de l'aéroport.";
    echo json_encode([
        'type' => 'error',
        'message' => $errorMessage
    ]);
}
?>
