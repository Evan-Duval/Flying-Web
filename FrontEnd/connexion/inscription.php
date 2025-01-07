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

    <?php 
        include '../components/navbar.php';
    ?>

    <div class="wrapper">

        <form action="insc_traitement.php" method="post">

            <h1>Inscription</h1>
            <div class="input-box">
                <input type="text" id="first_name" name="first_name" placeholder="Prénom" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
            <input type="text" id="last_name" name="last_name" placeholder="Nom" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="email" id="email" name="email" placeholder="Adresse e-mail" required>
                <i class='bx bxs-envelope'></i>
            </div>
            <div class="input-box">
                <input type="date" id="birthday" name="birthday" placeholder="Date de naissance" required>
                <i class='bx bxs-calendar'></i>
            </div>
            <div class="input-box">
                <input type="password" id="password" name="password" placeholder="Mot de passe" required>
                <i class='bx bxs-lock-alt' ></i>
            </div>
            <div class="input-box">
                <input type="password" id="c_password" name="c_password" placeholder="Confirmer le Mot de passe" required>
                <i class='bx bxs-lock-alt' ></i>
            </div>

            <button type="submit" class="btn">S'inscrire</button>

            <div class="register-link">
                <p>Vous avez déjà un compte ? <a href="connexion.php">Se connecter</a></p>
            </div>

        </form>
    </div>

    <script src="script.js"></script>
</body>
</html>
