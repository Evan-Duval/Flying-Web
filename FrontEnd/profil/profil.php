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
            <p>Mot de Passe : (caché) <a href="#">Modifier</a> </p>
            <a href="#">Modifier mes informations</a>
            <a href="../connexion/logout.php">Se déconnecter</a>
            <a href="#">Supprimer mon compte</a>
        </div>

    </div>

    <div class="my-reservations">
        <h1>Mes réservations</h1>

        <div class="reservation">
            <table class="reservations-table">

            <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Numéro de Siège</th>
                <th>Informations de vol</th>
            </tr>

            <tr>
                <td>01/01/2022</td>
                <td>Aller simple</td>
                <td>A1</td>
                <td>Aéroport de Paris-Charles-de-Gaulle à Aéroport de Rennes</td>
            </tr>

            <tr>
                <td>02/01/2022</td>
                <td>Aller-Retour</td>
                <td>A2</td>
                <td>Aéroport de Rennes à Aéroport de Paris-Charles-de-Gaulle</td>
            </tr>

            </table>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>