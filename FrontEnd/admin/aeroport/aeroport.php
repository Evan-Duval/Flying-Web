<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../admin.css">
    <title>Aeroport</title>
</head>
<body>

    <form method="POST" action="aeroport_traitement.php">
        <label for="city">City : </label>
        <input type="text" name="city" id="city" required>
        <label for="maxLenght">Max Lenght : </label>
        <input type="number" name="maxLenght" id="maxLenght" required>
        <label for="capacity">Capacity : </label>
        <input type="number" name="capacity" id="capacity" required>

        <button type="submit">Ajouter l'aéroport</button>
    </form>
    
</body>
</html>