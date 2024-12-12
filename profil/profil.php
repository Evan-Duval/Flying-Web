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
    <nav class="sidebar">
        <div class="logo-menu">
            <h2 class="logo">Flying Web</h2>
            <i class='bx bx-menu toggle-btn'></i>
        </div>

        <ul class="list">
            <li class="list-item">
                <a href="../home/index.php">
                    <i class='bx bxs-home'></i>
                    <span class="link-name" style="--i:1;">Accueil</span>
                </a>
            </li>
            <li class="list-item">
                <a href="#">
                    <i class='bx bxs-store'></i>
                    <span class="link-name" style="--i:2;">- - - - -</span>
                </a>
            </li>
            <li class="list-item active">
                <a href="#">
                    <i class='bx bxs-contact'></i>
                    <span class="link-name" style="--i:3;">Profil</span>
                </a>
            </li>
            <li class="list-item">
                <a href="../connexion/connexion.php">
                    <i class='bx bxs-user'></i>
                    <span class="link-name" style="--i:4;">Se connecter</span>
                </a>
            </li>
        </ul>
    </nav>

    <div class="identity">

        <div class="user-info">
            <h2>Prénom</h2>
            <h2>Nom</h2>
            <p>Email: 123@example.com</p>
            <p>Date de naissance: 01/01/2000</p>
            <a href="#">Modifier mes informations</a>
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