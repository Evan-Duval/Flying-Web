<?php

$plane_id = isset($_GET['plane']) ? $_GET['plane'] : null;
$model = $_POST['model'] ?? null;
$identification = $_POST['identification'] ?? null;
$nbPlace = $_POST['nbPlace'] ?? null;
$dimension = $_POST['dimension'] ?? null;

if (!$plane_id) {
    echo json_encode([
        'type' => 'error',
        'message' => 'Erreur : ID de l\'aéroport non fourni.'
    ]);
    exit;
}

$data = array(
    'model' => $model,
    'identification' => $identification,
    'nbPlace' => $nbPlace,
    'dimension' => $dimension,
);

$ch = curl_init('http://127.0.0.1:8000/api/plane/update/' . urlencode($plane_id));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); 
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Accept: application/json',
    'Content-Length: ' . strlen(json_encode($data))
));

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

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
