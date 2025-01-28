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
        $plane_id = isset($_GET['plane']) ? $_GET['plane'] : null;

        if ($plane_id) {
            $ch = curl_init("http://127.0.0.1:8000/api/plane/get-by-id/" . $plane_id);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Accept: application/json'
            ));

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode == 200) {
                $plane = json_decode($response, true);
            }
        }
    ?>

    <div id="notification" class="notification"></div>

    <div class="form-container">
        <a class="go-back-btn" href="airport_infos.php?aeroport=<?php echo htmlspecialchars($plane['aeroport_id']);?>">Retour</a>
        <form id="form1" method="PUT">
            <h3>Modifier l'Avion n°<?php echo htmlspecialchars($plane['id']);?></h3>
            <label for="model">Modèle :</label>
            <input type="text" name="model" id="model" required value="<?php echo htmlspecialchars($plane['model']);?>">
            <label for="identification">Identification :</label>
            <input type="text" name="identification" id="identification" required value="<?php echo htmlspecialchars($plane['identification'])?>">
            <label for="nbPlace">Nombre de place :</label>
            <input type="number" name="nbPlace" id="nbPlace" required value="<?php echo htmlspecialchars($plane['nbPlace'])?>">
            <label for="dimension">Dimension :</label>
            <input type="text" name="dimension" id="dimension" required value="<?php echo htmlspecialchars($plane['dimension'])?>">
            <button type="submit" onlick="">Modifier les informations</button>
        </form>
    </div>

    <script>
        document.getElementById('form1').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('plane/plane_update.php?plane=<?php echo htmlspecialchars($plane['id']);?>' , {
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