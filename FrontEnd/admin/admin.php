<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="admin.css">
    <title>Admin Panel</title>
</head>
<body>

    <?php 
        include '../components/navbar.php';
        include '../components/api/adminverif.php';

        include '../components/api/getall_aeroports.php';
    ?>

    <div id="notification" class="notification"></div>

    <div class="form-container">
        <form id="form1" method="POST" action="aeroport/aeroport_traitement.php">
            <h3>Ajouter un aéroport</h3>
            <label for="city">Ville :</label>
            <input type="text" name="city" id="city" required>
            <label for="maxLenght">Taille maximum :</label>
            <input type="number" name="maxLenght" id="maxLenght" required>
            <label for="capacity">Capacité en avions :</label>
            <input type="number" name="capacity" id="capacity" required>
            <button type="submit">Ajouter</button>
        </form>

        <form id="form2" method="POST" action="">
            <h3>Ou sélectionnez-en un</h3>
            <label for="aeroport_id">Aéroport</label>
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
            <button type="button" onclick="redirectAirportManagement()">Gérer</button>
        </form>
    </div>


    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>

    document.getElementById('form1').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('aeroport/aeroport_traitement.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            showNotification(data.message, data.type);
            
            if (data.type === 'success') {
                document.getElementById('form1').reset();
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

        function redirectAirportManagement() {
            const selectedAirport = document.getElementById('aeroport_id');            
            
            const selectedAirportId = selectedAirport.value;
            console.log(selectedAirportId)
    
            if (!selectedAirportId) {
                showNotification('Erreur : Veuillez sélectionner un aéroport', 'error')
                return;
            }

            fetch(`http://127.0.0.1:8000/api/aeroport/get-by-id/${selectedAirportId}`)
                .then(response => {
                    if (!response.ok) {
                        showNotification('Aéroport non trouvé');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data) {
                        window.location.href = `airport_management/manage.php`;
                    }
                })
                .catch(error => {
                    showNotification("Erreur : L'aéroport sélectionné n'existe pas");
                    console.error('Erreur:', error);
                });
        }
    </script>
</body>
</html>