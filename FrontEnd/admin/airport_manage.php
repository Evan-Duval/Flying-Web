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


    <div class="right-form">
    <div class="form-container">
    <a class="go-back-btn" href="admin.php">Retour</a>
    <form id="form2" method="POST">
            <h3>Ajouter un piste à l'Aéroport n°<?php echo htmlspecialchars($aeroport['id']);?></h3>
            <input type="hidden" name="aeroport_id" id="aeroport_id" value="<?php echo htmlspecialchars($aeroport['id']); ?>">
            <label for="pisteNumber">Numéro de la piste :</label>
            <input type="number" name="pisteNumber" id="pisteNumber" required>
            <label for="pisteLenght">Longueur de la piste :</label>
            <input type="number" name="pisteLenght" id="pisteLenght" required>
            <button type="submit" onlick="">Ajouter la piste</button>
        </form>
    </div>

    <div class="form-container">
    <a class="go-back-btn" href="admin.php">Retour</a>
    <form id="form3" method="POST">
            <h3>Ajouter un avion à l'Aéroport n°<?php echo htmlspecialchars($aeroport['id']);?></h3>
            <input type="hidden" name="aeroport_id" id="aeroport_id" value="<?php echo htmlspecialchars($aeroport['id']); ?>">
            <label for="model"> Modèle :</label>
            <input type="text" name="model" id="model" required>

            <label for="identification">Identification :</label>
            <input type="text" name="identification" id="identification" required>

            <label for="nbPlace">Nombre de Place :</label>
            <input type="number" name="nbPlace" id="nbPlace" required>

            <label for="dimension">Dimension :</label>
            <input type="text" name="dimension" id="dimension" required>

            <button type="submit" onlick="">Ajouter l'avion</button>
        </form>
    </div>
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



        document.getElementById('form2').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('http://127.0.0.1:8000/api/piste/create', {
                method: 'POST',
                body: formData,
            })
            .then((response) => response.json())
            .then((data) => {
                    window.location.reload();
            })
            .catch((error) => {
                showNotification(
                    'Une erreur est survenue lors de la communication avec le serveur',
                    'error'
                );
            });
        });


        document.getElementById('form3').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('http://127.0.0.1:8000/api/plane/create', {
                method: 'POST',
                body: formData,
            })
            .then((response) => response.json())
            .then((data) => {
                    window.location.reload();
            })
            .catch((error) => {
                showNotification(
                    'Une erreur est survenue lors de la communication avec le serveur',
                    'error'
                );
            });
        });

    </script>
</body>
</html>