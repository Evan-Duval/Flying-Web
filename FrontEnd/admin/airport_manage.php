<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="css/add_airport.css">
    <title>Airport Management</title>
</head>
<body>
    <?php 
        include '../components/navbar.php';
        include '../components/api/adminverif.php';

        $aeroport_id = isset($_GET['aeroport_id']) ? $_GET['aeroport_id'] : null;

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
                ?>
                <div class="div-container">
                    <div class="content">
                        <h3>Informations de l'aéroport sélectionné :</h3>
                        <table>
                            <tr>
                                <th>ID</th>
                                <td><?php echo htmlspecialchars($aeroport['id']);?></td>
                            </tr>
                            <tr>
                                <th>Ville</th>
                                <td><?php echo htmlspecialchars($aeroport['city']);?></td>
                            </tr>
                            <tr>
                                <th>Longueur maximale</th>
                                <td><?php echo htmlspecialchars($aeroport['maxLenght']);?></td>
                                <th>Actions :</th>
                                <td><button><i class='bx bx-edit-alt'></i></button></td>
                            </tr>
                            <tr>
                                <th>Capacité</th>
                                <td><?php echo htmlspecialchars($aeroport['capacity']);?></td>
                                <th>Actions :</th>
                                <td><button><i class='bx bx-edit-alt'></i></button></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <?php
            }
        }
    ?>


    <script>
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