<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="styles.css">
    <title>Flying Web Inscription</title>
</head>
<body>

    <nav class="sidebar">
        <div class="logo-menu">
            <h2 class="logo">Flying Web</h2>
            <i class='bx bx-menu toggle-btn'></i>
        </div>

        <ul class="list">
            <li class="list-item active">
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
            <li class="list-item">
                <a href="#">
                    <i class='bx bxs-contact'></i>
                    <span class="link-name" style="--i:3;">Profil</span>
                </a>
            </li>
            <li class="list-item">
                <a href="#">
                    <i class='bx bxs-user'></i>
                    <span class="link-name" style="--i:4;">Se connecter</span>
                </a>
            </li>
        </ul>
    </nav>

    <div class="wrapper">

        <form action="traitement.php" method="post">

            <h1>Connexion</h1>
            <div class="input-box">
                <input type="email" id="email" name="email" placeholder="Adresse e-mail" required>
                <i class='bx bxs-envelope'></i>
            </div>
            <div class="input-box">
                <input type="password" id="password" name="password" placeholder="Mot de passe" required>
                <i class='bx bxs-lock-alt' ></i>
            </div>

            <button type="submit" class="btn">Se connecter</button>

            <div class="register-link">
                <p>Vous n'avez pas de compte ? <a href="inscription.php">S'inscrire</a></p>
            </div>

        </form>
    </div>

    <script src="script.js"></script>
</body>
</html>
