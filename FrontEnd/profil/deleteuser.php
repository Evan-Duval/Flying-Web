<?php

$ch = curl_init('http://127.0.0.1:8000/api/auth/delete-user/' + $_SESSION['user']['id']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$result = json_decode($response, true);
if ($httpCode == 200) {
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