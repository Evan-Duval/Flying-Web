<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/admin.css">
    <title>Admin Panel</title>
</head>
<body>

    <?php 
        include '../components/navbar.php';
        include '../components/api/adminverif.php';

        include '../components/api/getall_aeroports.php';
    ?>

    <div id="notification" class="notification"></div>

    <div class="table-container">
        <a class="add-airport-btn" href="add_airport.php">Ajouter un Aéroport</a>
        <table>
            <thead>
                <th>Ville</th>
                <th>Capacité Avion</th>
                <th>Taille Max</th>
                <th>Actions</th>
            </thead>
            <tbody>
                <?php
                    if (!empty($aeroports)) {
                        foreach ($aeroports as $aeroport) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($aeroport['city']) . '</td>';
                            echo '<td>' . htmlspecialchars($aeroport['capacity']) . '</td>';
                            echo '<td>' . htmlspecialchars($aeroport['maxLenght']) . '</td>';
                            echo '<td>
                                <button><i class=\'bx bx-search-alt\'></i></button>
                                <button><i class=\'bx bx-edit-alt\'></i></button>
                                <button><i class=\'bx bx-trash\'></i></button>
                            </td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="4">Aucun aéroport disponible</td></tr>';
                    }
            ?>
            </tbody>
        </table>
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
                        window.location.href = `airport_manage.php?aeroport_id=` + selectedAirportId;
                    }
                })
                .catch(error => {
                    showNotification("Erreur : L'aéroport sélectionné n'existe pas");
                });
        }
    </script>
</body>
</html>