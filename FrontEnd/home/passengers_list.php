<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>FlyingWeb</title>
</head>
<body>
    <?php 
        include '../components/api/adminverif.php';

        $flightId = isset($_GET['flightId']) ? $_GET['flightId'] : null;

        if ($flightId) {
            // Récupération des détails du vol
            $chFlie = curl_init("http://127.0.0.1:8000/api/flies/get-by-id/" . $flightId);
            curl_setopt($chFlie, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($chFlie, CURLOPT_HTTPHEADER, array(
                'Accept: application/json'
            ));
            $flieResponse = curl_exec($chFlie);
            $flieHttpCode = curl_getinfo($chFlie, CURLINFO_HTTP_CODE);
            curl_close($chFlie);

            if ($flieHttpCode == 200) {
                $flie = json_decode($flieResponse, true);
            }

            // Récupération des réservations liées au vol
            $chReservations = curl_init("http://127.0.0.1:8000/api/reservation/get-by-flight/" . $flightId);
            curl_setopt($chReservations, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($chReservations, CURLOPT_HTTPHEADER, array(
                'Accept: application/json'
            ));
            $reservationsResponse = curl_exec($chReservations);
            $reservationsHttpCode = curl_getinfo($chReservations, CURLINFO_HTTP_CODE);
            curl_close($chReservations);

            if ($reservationsHttpCode == 200) {
                $reservations = json_decode($reservationsResponse, true);
            } else {
                $reservations = [];
            }
        }
    ?>

    <div class="container">
        <h1>Détails du Vol</h1>
        <?php if (!empty($flie)) : ?>
            <p><strong>Numéro du vol :</strong> <?= htmlspecialchars($flie['flightNumber']) ?></p>
            <p><strong>Date et Heure du Décollage :</strong> <?= htmlspecialchars($flie['takeoffTime']) ?></p>
            <p><strong>Date et Heure de l'Arrivée :</strong> <?= htmlspecialchars($flie['landingTime']) ?></p>
            <p><strong>Durée du Vol :</strong> <?= htmlspecialchars($flie['flightDuration'])?> minutes</p>
        <?php else : ?>
            <p>Vol introuvable.</p>
        <?php endif; ?>

        <h2>Liste des Réservations</h2>
        <?php if (!empty($reservations)) : ?>
            <?php if (count($reservations) === 1) : ?>
                <!-- Cas où il n'y a qu'une seule réservation -->
                <?php $reservation = $reservations[0]; 

                // Récupération des informations de l'utilisateur
                $chUser = curl_init("http://127.0.0.1:8000/api/user/get-by-id/" . $reservation['user_id']);
                curl_setopt($chUser, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($chUser, CURLOPT_HTTPHEADER, array('Accept: application/json'));
                $userResponse = curl_exec($chUser);
                curl_close($chUser);
                $user = json_decode($userResponse, true);
                ?>
                
                <div>
                    <strong>Réservation #<?= htmlspecialchars($reservation['id']) ?></strong><br>
                    Passager : <?= htmlspecialchars($user['first_name'] . '' . $user['last_name']) ?><br>
                    Numéro de Siège : <?= htmlspecialchars($reservation['placeNumber']) ?>
                </div>
            <?php else : ?>
                <!-- Cas où il y a plusieurs réservations -->
                <ul>
                    <?php foreach ($reservations as $reservation) : ?>
                        <?php if ($reservation['flie_id'] == $flightId) : ?>
                            <?php 
                                $chUser = curl_init("http://127.0.0.1:8000/api/user/get-by-id/" . $reservation['user_id']);
                                curl_setopt($chUser, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($chUser, CURLOPT_HTTPHEADER, array('Accept: application/json'));
                                $userResponse = curl_exec($chUser);
                                curl_close($chUser);
                                $user = json_decode($userResponse, true); 
                            ?>
                            <li>
                                <strong>Réservation #<?= htmlspecialchars($reservation['id']) ?></strong><br>
                                Passager : <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?><br>
                                Numéro de Siège : <?= htmlspecialchars($reservation['placeNumber']) ?>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        <?php else : ?>
            <p>Aucune réservation pour ce vol.</p>
        <?php endif; ?>
    </div>

    <script src="script.js"></script>
</body>
</html>
