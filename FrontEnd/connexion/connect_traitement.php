<?php
    session_start();

    // Récupération des données du formulaire
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    // Préparation des données pour l'API
    $data = array(
        'email' => $email,
        'password' => $password
    );

    // Configuration de la requête cURL
    $ch = curl_init('http://127.0.0.1:8000/api/auth/login');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Accept: application/json'
    ));

    // Exécution de la requête
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Décodage de la réponse
    $result = json_decode($response, true);

    // Gestion de la réponse
    if ($httpCode == 200) {
        // Succès
        $_SESSION['auth_token'] = $result['accessToken'];

        // Redirection ou affichage d'un message de succès
        echo "<h3 style=\"color:green;\">Connexion réussie ! Vous allez être redirigé...</h3>";
        header("refresh:2;url=../home/index.php");
        exit;
    } else {
        // Échec - Affichage du message d'erreur
        $errorMessage = $result['message'] ?? 'Erreur de connexion. Veuillez réessayer.';
        echo "<h3 style=\"color:red;\">Erreur : " . htmlspecialchars($errorMessage) . "</h3>";
        echo "<div class=\"wrapper\">
                <div class=\"register-link\"> 
                    <p>Retourner à la connexion ? <a href=\"connexion.php\">Réessayer</a></p> 
                </div>
              </div>";
    }

?>