<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <title>Flying Web Accueil</title>
</head>
<body>

    <nav class="sidebar">
        <div class="logo-menu">
            <h2 class="logo">Flying Web</h2>
            <i class='bx bx-menu toggle-btn'></i>
        </div>

        <ul class="list">
            <li class="list-item active">
                <a href="#">
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
            <li class="list-item">
                <a href="../profil/profil.php">
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

    <div class="title">
        <h1>Flying Web</h1>
    </div>

    <div class="blank">
        <div class="resa-info">
            <div class="left">
                <form class="reservation-form">
                    <h2>Réserver</h2>
                    <label for="destination">Destination :</label>
                    <input type="text" id="destination" name="destination" placeholder="Votre destination">

                    <label for="Classe">Classe :</label>
                    <select id="Classe" name="Classe">
                        <option value="">Choisir une classe</option>
                        <option value="paris">Économique</option>
                        <option value="london">Buisness</option>
                        <option value="new-york">First Class</option>
                    </select>

                    <label for="date">Date :</label>
                    <input type="date" id="date" name="date">

                    <button type="submit">Voir les prix</button>
                </form>
            </div>
            <div class="right">
                
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>