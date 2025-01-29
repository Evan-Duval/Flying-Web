<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="styles.css">
    <title>Flying Web Connexion</title>
</head>
<body>

    <?php 
        include '../components/navbar.php';
    ?>


    <div class="wrapper">

        <?php
            if (isset($_SESSION['user'])) {
                echo "<h2>Vous êtes connecté en tant que " . $_SESSION['user']['first_name']. " " . $_SESSION['user']['last_name'] . ". <a href=\"logout.php\">Déconnexion</a></h2>";
            } else {
                echo 
                "<form action=\"connect_traitement.php\" method=\"post\">

                    <h1>Connexion</h1>
                    <div class=\"input-box\">
                        <input type=\"email\" id=\"email\" name=\"email\" placeholder=\"Adresse e-mail\" required>
                        <i class='bx bxs-envelope'></i>
                    </div>
                    <div class=\"input-box\">
                        <input type=\"password\" id=\"password\" name=\"password\" placeholder=\"Mot de passe\" required>
                        <i class='bx bxs-lock-alt' ></i>
                    </div>

                    <button type=\"submit\" class=\"btn\">Se connecter</button>

                    <div class=\"register-link\">
                        <p>Vous n'avez pas de compte ? <a href=\"inscription.php\">S'inscrire</a></p>
                    </div>

                </form>";
            }
        ?>
    </div>

    <script src="script.js"></script>
</body>
</html>
