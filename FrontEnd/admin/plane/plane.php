<?php

$ch = curl_init('http://127.0.0.1:8000/api/aeroport/get-all');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$aeroports = json_decode($response, true);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../admin.css">
    <title>Plane</title>
</head>
<body>
    <form method="POST" action="plane_traitement.php">
        <label for="model">Nom du modèle : </label>
        <input type="text" name="model" id="model" required>

        <label for="identification">Identification : </label>
        <input type="text" name="identification" id="identification" required>

        <label for="nbPlace">Nombre de place : </label>
        <input type="number" name="nbPlace" id="nbPlace" required>

        <label for="dimension">Dimension : </label>
        <input type="text" name="dimension" id="dimension" required>

        <label for="aeroport_id">Associer à un aéroport :</label>
        <select name="aeroport_id" id="aeroport_id" required>
            <option value="" disabled selected>Choisissez un aéroport</option>
            <?php
            if (!empty($aeroports)) {
                foreach ($aeroports as $aeroport) {
                    echo '<option value="' . htmlspecialchars($aeroport['id']) . '">' . htmlspecialchars($aeroport['city']) . '</option>';
                }
            } else {
                echo '<option disabled>Aucun aéroport disponible</option>';
            }
            ?>
        </select>

        <button type="submit">Ajouter la piste</button>
    </form>
</body>
</html>
