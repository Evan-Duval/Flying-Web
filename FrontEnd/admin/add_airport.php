<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/add_airport.css">
    <title>Admin Panel - Ajouter un aéroport</title>
</head>
<body>

    <?php 
        include '../components/navbar.php';
        include '../components/api/adminverif.php';

        include '../components/api/getall_aeroports.php';
    ?>

    <div id="notification" class="notification"></div>

    <div class="form-container">
        <a class="go-back-btn" href="admin.php">Retour</a>
        <form id="form1" method="POST" action="aeroport/aeroport_traitement.php">
            <h3>Ajouter un aéroport</h3>
            <label for="city">Ville :</label>
            <input type="text" name="city" id="city" required>
            <label for="maxLenght">Taille :</label>
            <select name="maxLenght" id="maxLenght" required>
                <option value="" disabled selected>Choisissez une taille</option>
                <option value="Petit">Petit Aéroport</option>
                <option value="Moyen">Moyen Aéroport</option>
                <option value="Grand">Grand Aéroport</option>
            </select>
            <label for="capacity">Capacité en avions :</label>
            <input type="number" name="capacity" id="capacity" required>
            <button type="submit">Ajouter</button>
        </form>
    </div>


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
                window.location.href = "admin.php";
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