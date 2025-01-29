<?php

// Récupération et validation des données
$model = $_POST['model'] ?? null;
$identification = $_POST['identification'] ?? null;
$nbPlace = $_POST['nbPlace'] ?? null;
$dimension = $_POST['dimension'] ?? null;
$aeroport_id = $_POST['aeroport_id'] ?? null;

if (!$aeroport_id) {
    echo "<h3 style=\"color:red;\">Erreur : Aéroport non sélectionné.</h3>";
    echo '<a href="admin.php">Retour au formulaire</a>';
    exit;
}

// Préparation des données pour l'API
$data = array(
    'model' => $model,
    'identification' => $identification,
    'nbPlace' => $nbPlace,
    'dimension' => $dimension,
    'aeroport_id' => $aeroport_id // clé etrangère
);

// Configuration de la requête cURL
$ch = curl_init('http://127.0.0.1:8000/api/plane/create');
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
    echo "<h3 style=\"color:green;\">Avion inséré. Vous allez être redirigé vers la page Admin...</h3>";
    header("refresh:2;url=..\admin.php");
    exit;
} else {
    $errorMessage = isset($result['message']) ? $result['message'] : "Une erreur est survenue lors de l'insertion de l'avion";
    echo "<h3>Erreur : " . htmlspecialchars($errorMessage) . "</h3>";
    echo "<div class=\"wrapper\">
            <div class=\"register-link\"> 
                <p>Retourner à la page admin ? <a href=\"plane.php\">Réessayer</a></p> 
            </div>
        </div>";
}