<?php

// Récupération et validation des données
$pisteNumber = $_POST['pisteNumber'] ?? null;
$pisteLenght = $_POST['pisteLenght'] ?? null;
$aeroport_id = $_POST['aeroport_id'] ?? null;

if (!$aeroport_id) {
    echo "<h3 style=\"color:red;\">Erreur : Aéroport non sélectionné.</h3>";
    echo '<a href="admin.php">Retour au formulaire</a>';
    exit;
}

// Préparation des données pour l'API
$data = array(
    'pisteNumber' => $pisteNumber,
    'pisteLenght' => $pisteLenght,
    'aeroport_id' => $aeroport_id, // Clé étrangère
);

// Configuration de la requête cURL
$ch = curl_init('http://127.0.0.1:8000/api/piste/create');
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
    echo "<h3 style=\"color:green;\">Piste(s) insérée(s). Vous allez être redirigé vers la page Admin...</h3>";
    header("refresh:2;url=..\admin.php");
    exit;
} else {
    $errorMessage = isset($result['message']) ? $result['message'] : "Une erreur est survenue lors de l'insertion de(s) Piste(s)";
    echo "<h3>Erreur : " . htmlspecialchars($errorMessage) . "</h3>";
    echo "<div class=\"wrapper\">
            <div class=\"register-link\"> 
                <p>Retourner à la page admin ? <a href=\"piste.php\">Réessayer</a></p> 
            </div>
        </div>";
}