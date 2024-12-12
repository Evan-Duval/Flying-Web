<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="styles.css">
    <title>Traitement...</title>
</head>

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
            
                echo "<h3 style=\"color:white;\">Inscription terminée. Vous allez être redirigé vers la page de connexion...</h3>";
            
                header(header: "refresh:2;url=connexion.php");
                exit;
            } catch (PDOException $e) {
                echo "<h3>Erreur : " . $e->getMessage() . "</h3>";
                echo "<div class=\"wrapper\">
                        <div class=\"register-link\"> 
                            <p>Retourner à l'inscription ? <a href=\"inscription.php\">Réessayer</a></p> 
                        </div>
                    </div>";
            }
        ?>