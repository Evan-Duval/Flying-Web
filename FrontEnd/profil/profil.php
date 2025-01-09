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

    <div class="identity">
        <?php   
            session_start();  
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
            <a href="#">Supprimer mon compte</a>
        </div>

    </div>

    <div class="my-reservations">
        <h1>Mes réservations</h1>

        <div class="reservation">
            <table class="reservations-table">
                <thead>
                    <tr>
                        <th>Date et heure</th>
                        <th>Type</th>
                        <th>Numéro de siège</th>
                        <th>ID de l'utilisateur</th>
                        <th>ID du vol</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include '../components/api/myreservations.php';

                    // Vérification si des réservations existent
                    if (isset($_SESSION['user']['reservations']) && !empty($_SESSION['user']['reservations'])) {
                        foreach ($_SESSION['user']['reservations'] as $reservation) {
                            // Vérification que chaque réservation est un tableau
                            if (is_array($reservation)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($reservation['dateTime']) . "</td>";
                                echo "<td>" . htmlspecialchars($reservation['type']) . "</td>";
                                echo "<td>" . htmlspecialchars($reservation['placeNumber']) . "</td>";
                                echo "<td>" . htmlspecialchars($reservation['user_id']) . "</td>";
                                echo "<td>" . htmlspecialchars($reservation['flie_id']) . "</td>";
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


    <script src="script.js"></script>
                    
    <script>
    document.getElementById('show-password-form').addEventListener('click', function(event) {
        event.preventDefault();
        const form = document.getElementById('password-form');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    });
    </script>
</body>
</html>