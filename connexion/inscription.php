<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../home/style.css">
    <link rel="stylesheet" href="inscriptionstyle.css">
    <title>Flying Web Inscription</title>
</head>
<body>
    <h1>Formulaire d'inscription</h1>
    <form action="connexion.php" method="post">
        <label for="firstName">Prénom :</label>
        <input type="text" id="firstName" name="firstName" required>

        <label for="lastName">Nom :</label>
        <input type="text" id="lastName" name="lastName" required>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>

        <label for="birthday">Date de naissance :</label>
        <input type="date" id="birthday" name="birthday" required>

        <label for="password">Mot de Passe</label>
        <input type="password" id="password" name="password" required>

        <?php
            $firstName = $_POST['firstName'] ?? null;
            $lastName = $_POST['lastName'] ?? null;
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;
            $birthday = $_POST['birthday'] ?? null;
            
            include '../sql/connexion.php';
            
            try {
                $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
                $stmt = $pdo->prepare(
                    "INSERT INTO user
                    (firstName, lastName, email, password, birthday) 
                    VALUES (:prenom, :nom, :email, :password, :birthday)"
                );
                $stmt->execute([
                    ':prenom' => $firstName,
                    ':nom' => $lastName,
                    ':email' => $email,
                    ':password' => $password,
                    ':birthday' => $birthday,
                ]);
            
                echo "Inscription terminée. Vous serez redirigé vers l'accueil dans 2 secondes...";
            
                header(header: "refresh:2;url=connexion.php");
                exit;
            } catch (PDOException $e) {
                echo "Erreur : " . $e->getMessage();
            }
        ?>

    </form>
</body>
</html>
