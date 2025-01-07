<?php
    // Récupération des données du formulaire
    $first_name = $_POST['first_name'] ?? null;
    $last_name = $_POST['last_name'] ?? null;
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;
    $c_password = $_POST['c_password'] ?? null;
    $birthday = $_POST['birthday'] ?? null;

    // Préparation des données pour l'API
    $data = array(
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $email,
        'password' => $password,
        'c_password' => $c_password,
        'birthday' => $birthday
    );

    // Configuration de la requête cURL
    $ch = curl_init('http://127.0.0.1:8000/api/auth/register');
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
    if ($httpCode == 201 || $httpCode == 200) {
        // Succès
        echo "<h3 style=\"color:white;\">Inscription terminée. Vous allez être redirigé vers la page de connexion...</h3>";
        header("refresh:2;url=connexion.php");
        exit;
    } else {
        // Erreur
        $errorMessage = isset($result['message']) ? $result['message'] : "Une erreur est survenue lors de l'inscription";
        echo "<h3>Erreur : " . htmlspecialchars($errorMessage) . "</h3>";
        echo "<div class=\"wrapper\">
                <div class=\"register-link\"> 
                    <p>Retourner à l'inscription ? <a href=\"inscription.php\">Réessayer</a></p> 
                </div>
            </div>";
    }

?>