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

        $ch = curl_init('http://127.0.0.1:8000/api/aeroport/get-all');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        
        $aeroports = json_decode($response, true);
    ?>

    <div id="notification" class="notification"></div>

    <div class="form-container">
        <form id="form1" method="POST" action="aeroport/aeroport_traitement.php">
            <h3>Ajouter un aéroport</h3>
            <label for="city">City :</label>
            <input type="text" name="city" id="city" required>
            <label for="maxLenght">Max Length :</label>
            <input type="number" name="maxLenght" id="maxLenght" required>
            <label for="capacity">Capacity :</label>
            <input type="number" name="capacity" id="capacity" required>
            <button type="button" onclick="submitForm('form1')">Ajouter</button>
        </form>

        <form id="form2" method="POST" action="piste/piste_traitement.php">
            <h3>Ajouter une piste</h3>
            <label for="pisteNumber">Nombre de piste(s) :</label>
            <input type="number" name="pisteNumber" id="pisteNumber" required>
            <label for="pisteLenght">Longueur des pistes :</label>
            <input type="number" name="pisteLenght" id="pisteLenght" required>
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
            <button type="button" onclick="submitForm('form2')">Ajouter</button>
        </form>

        <form id="form3" method="POST" action="plane/plane_traitement.php">
            <h3>Ajouter un avion</h3>
            <label for="model">Nom du modèle :</label>
            <input type="text" name="model" id="model" required>
            <label for="identification">Identification :</label>
            <input type="text" name="identification" id="identification" required>
            <label for="nbPlace">Nombre de place :</label>
            <input type="number" name="nbPlace" id="nbPlace" required>
            <label for="dimension">Dimension :</label>
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
            <button type="button" onclick="submitForm('form3')">Ajouter</button>
        </form>
    </div>


    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        async function submitForm(formId) {
            const form = document.getElementById(formId);
            const formData = new FormData(form);
            const action = form.getAttribute('action');

            try {
                const response = await fetch(action, {
                    method: 'POST',
                    body: formData
                });

                if (response.ok) {
                    showNotification('Succès : Données envoyées avec succès.', 'success');
                } else {
                    showNotification("Erreur : Échec de l`'envoi des données.", 'error');
                }
            } catch (error) {
                showNotification('Erreur : Une erreur est survenue.', 'error');
            }
        }

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