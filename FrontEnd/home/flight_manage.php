<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../admin/css/admin.css">
    <link rel="stylesheet" href="../admin/css/add_airport.css">
    <title>Airport Management</title>
</head>
<body>
    <?php 
        include '../components/navbar.php';
        include '../components/api/adminverif.php';
        $flie_id = isset($_GET['flightId']) ? $_GET['flightId'] : null;

        if ($flie_id) {
            $ch = curl_init("http://127.0.0.1:8000/api/flies/get-by-id/" . $flie_id);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Accept: application/json'
            ));

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode == 200) {
                $flie = json_decode($response, true);
            }
        }
    ?>

    <div id="notification" class="notification"></div>

    <div class="form-container">
        <a class="go-back-btn" href="index.php">Retour</a>
        <form id="form1" method="PUT">
            <h3>Modifier le vol n°<?php echo htmlspecialchars($flie['id']);?></h3>
            <label for="takeoffTime">Décollage :</label>
            <input type="text" name="takeoffTime" id="takeoffTime" required value="<?php echo htmlspecialchars($flie['takeoffTime']);?>">

            <label for="landingTime">Atterrissage :</label>
            <input type="text" name="landingTime" id="landingTime" required value="<?php echo htmlspecialchars($flie['landingTime'])?>">

            <label for="flightNumber">Numéro de vol :</label>
            <input type="text" name="flightNumber" id="flightNumber" required value="<?php echo htmlspecialchars($flie['flightNumber'])?>">

            <label for="flightDuration">Temps de vol (en minute) :</label>
            <input type="text" name="flightDuration" id="flightDuration" required value="<?php echo htmlspecialchars($flie['flightDuration'])?>">

            <label for="plane_id">Avion :</label>
            <select name="plane_id" id="plane_id" required>
                <option value="">Chargement...</option>
            </select>

            <label for="aeroport_depart_id">Aéroport de départ :</label>
            <select name="aeroport_depart_id" id="aeroport_depart_id" required>
                <option value="">Chargement...</option>
            </select>
        
            <label for="aeroport_arrive_id">Aéroport d'arrivée :</label>
            <select name="aeroport_arrive_id" id="aeroport_arrive_id" required>
                <option value="">Chargement...</option>
            </select>
            
            <button type="submit" onlick="">Modifier les informations</button>
        </form>
    </div>

    <script>
        document.getElementById('form1').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('flight_update.php?flightId=<?php echo htmlspecialchars($flie['id']);?>' , {
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



        document.addEventListener("DOMContentLoaded", function() {
    loadSelectOptions("http://127.0.0.1:8000/api/plane/get-all", "plane_id", "<?php echo $flie['plane_id']; ?>");
    loadSelectOptions("http://127.0.0.1:8000/api/aeroport/get-all", "aeroport_depart_id", "<?php echo $flie['aeroport_depart_id']; ?>");
    loadSelectOptions("http://127.0.0.1:8000/api/aeroport/get-all", "aeroport_arrive_id", "<?php echo $flie['aeroport_arrive_id']; ?>");
});

function loadSelectOptions(apiUrl, selectId, selectedValue) {
    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById(selectId);
            select.innerHTML = ""; // Vide les options existantes
            data.forEach(item => {
                const option = document.createElement("option");
                option.value = item.id;
                option.textContent = item.name || `ID ${item.id}`;
                if (item.id == selectedValue) {
                    option.selected = true;
                }
                select.appendChild(option);
            });
        })
        .catch(error => console.error(`Erreur lors du chargement des données pour ${selectId}:`, error));
}
    </script>
</body>
</html>