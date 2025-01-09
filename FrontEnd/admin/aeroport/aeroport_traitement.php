<?php

// Récupération et validation des données
$city = $_POST['city'] ?? null;
$maxLenght = $_POST['maxLenght'] ?? null;
$capacity = $_POST['capacity'] ?? null;

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
    echo "<h3 style=\"color:green;\">Aéroport inséré. Vous allez être redirigé vers la page Admin...</h3>";
    header("refresh:2;url=..\admin.php");
    exit;
} else {
    $errorMessage = isset($result['message']) ? $result['message'] : "Une erreur est survenue lors de l'insertion de l'aéroport";
    echo "<h3>Erreur : " . htmlspecialchars($errorMessage) . "</h3>";
    echo "<div class=\"wrapper\">
            <div class=\"register-link\"> 
                <p>Retourner à la page admin ? <a href=\"aeroport.php\">Réessayer</a></p> 
            </div>
        </div>";
}
