<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="profilstyle.css">
    <title>Flying Web - Profil</title>
</head>
<body>

    <?php
        include '../components/navbar.php';
    ?>

    <div id="notification" class="notification"></div>

    <div id="deleteModal1" class="modal" style="display: none;">
        <div class="modal-content">
            <p>Êtes-vous sûr de vouloir supprimer votre compte ?</p>
            <div class="modal-buttons">
                <button onclick="hideDeleteModal()" class="btn-cancel">Annuler</button>
                <button onclick="confirmDelete(1)" class="btn-confirm">Confirmer</button>
            </div>
        </div>
    </div>
    <div id="deleteModal2" class="modal" style="display: none;">
        <div class="modal-content">
            <p>Êtes-vous sûr de vouloir annuler cette réservation ?</p>
            <div class="modal-buttons">
                <button onclick="hideDeleteModal()" class="btn-cancel">Annuler</button>
                <button onclick="confirmDelete(2)" class="btn-confirm">Confirmer</button>
            </div>
        </div>
    </div>

    <div class="identity">
        <?php   
            if (!isset ($_SESSION['user'])) {
                die("<p style=\"color:white; font-size:2em; text-align:center;\">Veuillez vous connecter pour accéder à cette page. <a style=\"display: inline-block;
    color: #000; text-decoration: none;\"href=\"../connexion/connexion.php\">Se connecter</a></p>");
            };
        ?>

        <div class="user-info">
            <h2 class="info"><?php echo htmlspecialchars($_SESSION['user']['first_name'])?></h2>
            <h2 class="info"><?php echo htmlspecialchars($_SESSION['user']['last_name'])?></h2>
            <p>Email : <?php echo htmlspecialchars($_SESSION['user']['email'])?></p>
            <p>Date de Naissance (YYYY/MM/DD) : <?php echo htmlspecialchars($_SESSION['user']['birthday'])?></p>
            <p>Mot de Passe : (caché) <a href="#" id="show-password-form">Modifier</a></p>
                <div id="password-form" style="display: none;">
                    <form id="change-password-form" method="POST" action="http://127.0.0.1:8000/api/auth/update-password">
                        <br>
                        <label for="current_password">Mot de passe actuel :</label>
                        <input type="password" id="current_password" name="current_password" required>
                        <br>
                        <br>
                        <label for="new_password">Nouveau mot de passe :</label>
                        <input type="password" id="new_password" name="new_password" required>
                        <br>
                        <br>
                        <label for="new_password_confirmation">Confirmer le mot de passe :</label>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" required>
                        <br>
                        <br>
                        <input type="hidden" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['user']['email']); ?>">
                        <button type="submit">Modifier</button>
                        <br>
                        <br>
                    </form>
                </div>
            <a href="#">Modifier mes informations</a>
            <a href="../connexion/logout.php">Se déconnecter</a>
            <button onclick="showDeleteModal('<?php echo htmlspecialchars($_SESSION['user']['id']); ?>', 1)" class="delete-btn">
                Supprimer mon compte
            </button>
        </div>

    </div>

    <div class="my-reservations">
        <h1>Mes réservations</h1>

        <div class="reservation">
            <table class="reservations-table">
                <thead>
                    <tr>
                        <th>Reservé le</th>
                        <th>Status</th>
                        <th>Numéro de siège</th>
                        <th>Passager</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include '../components/api/myreservations.php';

                    // Vérification si des réservations existent
                    if (isset($_SESSION['user']['reservations']) && !empty($_SESSION['user']['reservations'])) {
                        foreach ($_SESSION['user']['reservations'] as $reservation) {

                            $ch = curl_init('http://127.0.0.1:8000/api/flies/get-by-id/' . $reservation['flie_id']);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            $response = curl_exec($ch);
                            curl_close($ch);

                            $flight = json_decode($response, true);

                            $currentDateTime = new DateTime();
                            $takeoffTime = new DateTime($flight["takeoffTime"]);
                            $landingTime = new DateTime($flight["landingTime"]);

                            if ($currentDateTime > $landingTime) {
                                $flight['status'] = "Passé";
                            } 
                            elseif ($currentDateTime >= $takeoffTime && $currentDateTime <= $landingTime) {
                                $flight['status'] = "En cours";
                            }
                            else {
                                $flight['status'] = "A venir";
                            }

                            // Vérification que chaque réservation est un tableau
                            if (is_array($reservation)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($reservation['dateTime']) . "</td>";
                                echo "<td>" . htmlspecialchars($flight['status']) . "</td>";
                                echo "<td>" . htmlspecialchars($reservation['placeNumber']) . "</td>";
                                echo "<td>" . htmlspecialchars($_SESSION['user']['first_name'] . " " . $_SESSION['user']['last_name']) . "</td>";
                                echo "<td>
                                    <button class='btn-view-ticket'>
                                        <a href='../home/genererPdf.php?flightId=" . htmlspecialchars($reservation['flie_id']) . "&reservationId=" . htmlspecialchars($reservation['id']) . "' target='_blank'>
                                            <i class='bx bx-link-external'></i>
                                        </a>
                                    </button>
                                    <button onclick='showDeleteModal(" . $reservation['id'] . ", 2)' class='btn-view-ticket'>
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </td>";
                                echo "</tr>";
                            } else {
                                echo "<tr><td colspan='5'>Réservation invalide</td></tr>";
                            }
                        }
                    } else {
                        echo "<tr><td colspan='5'>Aucune réservation trouvée.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

                    
    <script>
        // Pour les notifications
        function showNotification(message, type) {
            const notification = document.getElementById('notification');
            notification.textContent = message;
            notification.className = 'notification ' + (type === 'success' ? '' : 'error');
            notification.style.display = 'block';

            setTimeout(() => {
                notification.style.display = 'none';
            }, 3000);
        }


        document.getElementById('show-password-form').addEventListener('click', function(event) {
            event.preventDefault();
            const form = document.getElementById('password-form');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        });



        document.getElementById('change-password-form').addEventListener('submit', function(event) {
            event.preventDefault(); 

            const form = event.target;

            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                showNotification('Succés : ' + (data.message || 'Mot de passe bien modifié.', 'sucess'));
                    form.reset();
            })
            .catch(error => {
                showNotification('Erreur : Une erreur réseau s\'est produite.');
                console.error(error);
            });
        });

        // Supprimer un joueur (Confirmation Popup)
        function showDeleteModal(id, index) {
            switch (index) {
                case 1:    
                    document.getElementById('deleteModal1').style.display = 'flex';
                    document.getElementById('deleteModal1').dataset.deleteId = id;
                    break;
                case 2:
                    document.getElementById('deleteModal2').style.display = 'flex';
                    document.getElementById('deleteModal2').dataset.deleteId = id;
                    break; 

            }              
        }

        function hideDeleteModal() {
            document.getElementById('deleteModal1').style.display = 'none';
        }

        function confirmDelete(index) {
            switch (index) {

                case 1:       
                    const idModal1 = document.getElementById('deleteModal1').dataset.deleteId;
                    fetch(`http://127.0.0.1:8000/api/auth/delete-user/${idModal1}`, {
                        method: 'POST'
                    })
                    .then(response => {
                        if (!response.ok) {
                            showNotification('Erreur lors de la suppression', 'error');
                        } else {
                            showNotification('Utilisateur supprimé avec succès', 'success');
                            window.location.href = "../connexion/logout.php";
                        }
                    });
                    break;
                case 2: 
                    const idModal2 = document.getElementById('deleteModal2').dataset.deleteId;
                    fetch(`http://127.0.0.1:8000/api/reservation/delete/${idModal2}`, {
                        method: 'DELETE'
                    })
                   .then(response => {
                        if (!response.ok) {
                            showNotification('Erreur lors de la suppression', 'error');
                        } else {
                            showNotification('Réservation supprimée avec succès', 'success');
                            window.location.reload();
                        }
                        });
                    break;
            }
        }

    </script>
</body>
</html>