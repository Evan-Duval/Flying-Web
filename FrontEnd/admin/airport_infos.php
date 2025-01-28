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

            <div id="deleteModal" class="modal" style="display: none;">
                <div class="modal-content">
                    <p>Êtes-vous sûr de vouloir supprimer cela ?</p>
                    <div class="modal-buttons">
                        <button onclick="hideDeleteModal()" class="btn-cancel">Annuler</button>
                        <button onclick="confirmDelete()" class="btn-confirm">Confirmer</button>
                    </div>
                </div>
            </div>

    <div class="div-container">
        <div class="content">
            <h3>Informations de l'aéroport sélectionné :</h3>
            <table class="maininfos">
                <tr>
                    <th>ID</th>
                    <td><?php echo htmlspecialchars($aeroport['id']);?></td>
                </tr>
                <tr>
                    <th>Ville</th>
                    <td><?php echo htmlspecialchars($aeroport['city']);?></td>
                </tr>
                <tr>
                    <th>Taille</th>
                    <td><?php echo htmlspecialchars($aeroport['maxLenght']);?></td>
                </tr>
                <tr>
                    <th>Capacité</th>
                    <td><?php echo htmlspecialchars($aeroport['capacity']);?></td>
                </tr>
            </table>

            <table>
                <h3 style="margin-top: 4em;">Informations des pistes :</h3>
                <?php
                    $ch = curl_init('http://127.0.0.1:8000/api/piste/get-by-airport/' . $aeroport['id']);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    curl_close($ch);

                    $pistes = json_decode($response, true);
                    if (!empty($pistes)) {
                        echo '<tr>';
                        echo '<th>ID</th>';
                        echo '<th>Numéro de piste</th>';
                        echo '<th>Longueur</th>';
                        echo '</tr>';
                        foreach ($pistes as $piste) {
                            echo '<tr>';
                            echo '<td>'. htmlspecialchars($piste['id']). '</td>';
                            echo '<td>'. htmlspecialchars($piste['pisteNumber']). '</td>';
                            echo '<td>'. htmlspecialchars($piste['pisteLenght']). '</td>';
                            echo '</tr>';
                        }
                        echo '</table>';
                    } else {
                        echo '<tr><td colspan="2">Aucune piste associée à cet aéroport</td></tr>';
                    }
                ?>
            </table>

            


            <table>
                <h3 style="margin-top: 4em;">Informations des avions :</h3>
                <?php
                    $ch = curl_init('http://127.0.0.1:8000/api/plane/get-by-airport/' . $aeroport['id']);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    curl_close($ch);

                    $planes = json_decode($response, true);
                    if (!empty($planes)) {
                        echo '<tr>';
                        echo '<th>ID</th>';
                        echo '<th>Modèle</th>';
                        echo '<th>Identification</th>';
                        echo '<th>Nombre de place</th>';
                        echo '<th>Dimension</th>';
                        echo '</tr>';
                        foreach ($planes as $plane) {
                            echo '<tr>';
                            echo '<td>'. htmlspecialchars($plane['id']). '</td>';
                            echo '<td>'. htmlspecialchars($plane['model']). '</td>';
                            echo '<td>'. htmlspecialchars($plane['identification']). '</td>';
                            echo '<td>'. htmlspecialchars($plane['nbPlace']). '</td>';
                            echo '<td>'. htmlspecialchars($plane['dimension']). '</td>';
                            echo '<td>
                                <button><a href="plane_manage.php?plane='. $plane['id'] . '"><i class=\'bx bx-edit-alt\'></i></a></button>
                                <button onclick="showDeleteModal(' . $plane['id'] . ')" class="delete-btn">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </td>';
                            echo '</tr>';
                        }
                        echo '</table>';
                    } else {
                        echo '<tr><td colspan="2">Aucune piste associée à cet aéroport</td></tr>';
                    }
                ?>
            </table>

            <table class="planesInfos">

            </table>
                
        </div>
    </div>


    <script>
        function showDeleteModal(id) {
            document.getElementById('deleteModal').style.display = 'flex';
            document.getElementById('deleteModal').dataset.deleteId = id;
        }

        function hideDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }

        function confirmDelete() {
            const id = document.getElementById('deleteModal').dataset.deleteId;
            fetch(`http://127.0.0.1:8000/api/plane/delete/${id}`, {
                method: 'DELETE'
            })
            .then(response => {
                if (response.ok) {
                    hideDeleteModal();
                    window.location.reload();
                }
            });
        }
    </script>
</body>
</html>