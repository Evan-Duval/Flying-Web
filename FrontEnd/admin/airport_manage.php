<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/add_airport.css">
    <title>Airport Management</title>
</head>
<body>
    <?php 
        include '../components/navbar.php';
        include '../components/api/adminverif.php';
        $aeroport_id = isset($_GET['aeroport']) ? $_GET['aeroport'] : null;

        if ($aeroport_id) {
            $ch = curl_init("http://127.0.0.1:8000/api/aeroport/get-by-id/" . $aeroport_id);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Accept: application/json'
            ));

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode == 200) {
                $aeroport = json_decode($response, true);
            }
        }
    ?>

    <div id="notification" class="notification"></div>

    <div class="form-container">
        <a class="go-back-btn" href="admin.php">Retour</a>
        <form id="form1" method="PUT">
            <h3>Modifier l'Aéroport n°<?php echo htmlspecialchars($aeroport['id']);?></h3>
            <label for="city">Ville :</label>
            <input type="text" name="city" id="city" required value="<?php echo htmlspecialchars($aeroport['city']);?>">
            <label for="maxLenght">Taille :</label>
            <select name="maxLenght" id="maxLenght" required>
                <!-- Option par défaut -->
                <option value="<?php echo htmlspecialchars($aeroport['maxLenght']); ?>" selected>
                    <?php echo htmlspecialchars($aeroport['maxLenght']); ?> Aéroport
                </option>
                
                <!-- Autres options -->
                <?php if ($aeroport['maxLenght'] !== 'Petit'): ?>
                    <option value="Petit">Petit Aéroport</option>
                <?php endif; ?>
                
                <?php if ($aeroport['maxLenght'] !== 'Moyen'): ?>
                    <option value="Moyen">Moyen Aéroport</option>
                <?php endif; ?>
                
                <?php if ($aeroport['maxLenght'] !== 'Grand'): ?>
                    <option value="Grand">Grand Aéroport</option>
                <?php endif; ?>
            </select>
            <label for="capacity">Capacité en avions :</label>
            <input type="number" name="capacity" id="capacity" required value="<?php echo htmlspecialchars($aeroport['capacity'])?>">
            <button type="submit" onlick="">Modifier les informations</button>
        </form>
    </div>


    <script>
        document.getElementById('form1').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('aeroport/aeroport_update.php?aeroport=<?php echo htmlspecialchars($aeroport['id']);?>' , {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                showNotification(data.message, data.type);
                
                if (data.type === 'success') {
                    window.location.reload();
                }
            })
            .catch(error => {
                showNotification('Une erreur est survenue lors de la communication avec le serveur', 'error');
            });
        });

        function showNotification(message, type) {
            const notification = document.getElementById('notification');
            notification.textContent = message;
            notification.className = 'notification ' + (type === 'success' ? '' : 'error');
            notification.style.display = 'block';

            setTimeout(() => {
                notification.style.display = 'none';
            }, 3000);
        }


    </script>
</body>
</html>