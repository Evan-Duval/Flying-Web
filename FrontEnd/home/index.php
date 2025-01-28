<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="style.css">
    <title>FlyingWeb Accueil</title>
</head>
<body>

    <div class="title">
        <h1>Flying Web</h1>
    </div>

    <?php 
    include '../components/navbar.php';

    $ch = curl_init('http://127.0.0.1:8000/api/aeroport/get-all');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    $aeroports = json_decode($response, true);

    $ch = curl_init('http://127.0.0.1:8000/api/flies/get-all');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    $flies = json_decode($response, true);

    $dateFilter = $_GET['date'] ?? '';
    $departFilter = $_GET['depart'] ?? '';
    $arriveFilter = $_GET['arrive'] ?? '';
    $typeFilter = $_GET['type'] ?? '';
    $seePastsFlights = $_GET['see-past-flights'] ?? null;

    $returnFlight = $_GET['success'] ?? null;
    ?>

    <div id="notification" class="notification"></div>

    <div class="main-container">

    <div class="filters-section">
    <form method="GET" class="filters-form">
        <div class="filter-group">
            <label for="date">Date de départ:</label>
            <input type="date" id="date" name="date" value="<?php echo $dateFilter; ?>">
        </div>

        <div class="filter-group">
            <label for="type">Type de vol:</label>
            <select name="type" id="type">
                <option default value="aller" <?php echo ($typeFilter == 'aller')?'selected' : '';?>>Aller Simple</option>
                <option value="aller-retour" <?php echo ($typeFilter == 'aller-retour')?'selected' : '';?>>Aller-Retour</option>
            </select>
        </div>

        <div class="filter-group">
            <label for="depart">Aéroport de départ:</label>
            <select name="depart" id="depart">
                <option value="">Tous les aéroports</option>
                <?php foreach ($aeroports as $aeroport): ?>
                    <option value="<?php echo $aeroport['id']; ?>" 
                            <?php echo ($departFilter == $aeroport['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($aeroport['city']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="filter-group">
            <label for="arrive">Aéroport d'arrivée:</label>
            <select name="arrive" id="arrive">
                <option value="">Tous les aéroports</option>
                <?php foreach ($aeroports as $aeroport): ?>
                    <option value="<?php echo $aeroport['id']; ?>" 
                            <?php echo ($arriveFilter == $aeroport['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($aeroport['city']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="filter-group">
            <label for="see-past-flights">Voir les vols passés</label>
            <input type="checkbox" id="see-past-flights" name="see-past-flights" 
            <?php if ($seePastsFlights) {
                echo 'checked';
            };?>>
        </div>

        <button type="submit" class="filter-button">Filtrer</button>
    </form>
    </div>

        <?php
        include '../components/api/myreservations.php';

        date_default_timezone_set('Europe/Paris');

        foreach ($flies as $flight) {
            $reserved = false;

            // Vérification des réservations dans la session
            if (isset($_SESSION['user']['reservations']) && !empty($_SESSION['user']['reservations'])) {
                foreach ($_SESSION['user']['reservations'] as $reservation) {
                    if ($reservation['flie_id'] == $flight['id']) {
                        $reserved = true;
                        $reservationId = $reservation['id'];
                        break;
                    }
                }
            }

            $currentDateTime = new DateTime();
            $takeoffTime = new DateTime($flight["takeoffTime"]);
            $landingTime = new DateTime($flight["landingTime"]);

            if ($currentDateTime > $landingTime) {
                if (!$seePastsFlights) {
                    continue;
                }
                $flight['status'] = "Passé";
            } 
            elseif ($currentDateTime >= $takeoffTime && $currentDateTime <= $landingTime) {
                $flight['status'] = "En cours";
            }
            else {
                $flight['status'] = "Disponible";
            }

            if ($dateFilter && date('Y-m-d', strtotime($flight['takeoffTime'])) != $dateFilter) {
                continue;
            }
            if ($departFilter && $flight['aeroport_depart_id'] != $departFilter) {
                continue;
            }
            if ($arriveFilter && $flight['aeroport_arrive_id'] != $arriveFilter) {
                continue;
            }

            $departureAirport = array_filter($aeroports, function($aeroport) use ($flight) {
                return $aeroport['id'] == $flight['aeroport_depart_id'];
            });
            $departureAirport = reset($departureAirport);

            $arrivalAirport = array_filter($aeroports, function($aeroport) use ($flight) {
                return $aeroport['id'] == $flight['aeroport_arrive_id'];
            });
            $arrivalAirport = reset($arrivalAirport);
            ?>
            <div class="flight-card">
                <div class="flight-info">
                    <div class="flight-header">
                        <!-- Nom du vol aligné à gauche -->
                        <h3>Vol <?php echo htmlspecialchars($flight['flightNumber']); ?></h3>
                        
                        <!-- Statut et Vol Retour alignés à droite -->
                        <div style="display: flex; align-items: center;">
                            <?php if (isset($returnFlight) && $returnFlight) { ?>
                                <h3 class="return-flight">Vol Retour</h3>
                            <?php } ?>
                            <h3 class="status <?php 
                                echo match($flight['status']) {
                                    'Passé' => 'status-past',
                                    'Disponible' => 'status-available',
                                    'En cours' => 'status-ongoing',
                                    default => ''
                                };
                            ?>">
                                <?php echo htmlspecialchars($flight['status']); ?>
                            </h3>
                        </div>
                    </div>
                    <div class="flight-details">
                        <p>Départ de: <b><?php echo htmlspecialchars($departureAirport['city'] ?? 'N/A'); ?></b></p>
                        <p>Arrivée à: <b><?php echo htmlspecialchars($arrivalAirport['city'] ?? 'N/A'); ?></b></p>
                        <p>Date de départ: <b><?php echo date('d/m/Y H:i', strtotime($flight['takeoffTime'])); ?></b></p>
                        <p>Date d'arrivée: <b><?php echo date('d/m/Y H:i', strtotime($flight['landingTime'])); ?></b></p>
                        <p>Durée: <b><?php echo $flight['flightDuration']; ?> minutes</b></p>

                        <?php
                        if (isset($_SESSION['user'])) {
                            $user = $_SESSION['user'];
                            if ($user['rank'] == 'admin') {
                                echo '<button class="edit-button">
                                <a href="flight_manage.php?flightId=' . $flight['id'] . '">
                                    <i class="bx bx-edit-alt"></i> 
                                </a>
                            </button>';
                            }
                        }
                        ?>
                        

                        <button 
                        onclick="<?php 
                                echo $reserved ? 
                                    "annulerVol({$reservationId})" : 
                                    "reserverVol(
                                        {$flight['id']}, 
                                        '".($typeFilter == "aller-retour" ?? '')."'
                                    )"; 
                            ?>"
                            class="reserve-button"
                            <?php echo ($flight['status'] == "Passé" || $flight['status'] == "En cours") ? "hidden" : "" ?>>
                            <?php echo $reserved ? "Annuler ma réservation" : "Réserver"; ?>
                        </button>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        // Pour les notifications
        function showNotification(message, type) {
            const notification = document.getElementById('notification');
            notification.textContent = message;
            notification.className = 'notification ' + (type === 'success' ? '' : 'error');
            notification.style.display = 'block';

            setTimeout(() => {
                notification.style.display = 'none';
            }, 3000);
        }
        

        
        flatpickr("#date", {
            dateFormat: "Y-m-d",
        });

        function reserverVol(flightId, volRetour) {
            if (volRetour === '' || volRetour === null) {
                window.location.href = 'reserver.php?flightId=' + flightId
            } else {
                window.location.href = 'reserver.php?flightId=' + flightId + '&volRetour=' + volRetour;
            }
        }

        function annulerVol(reservationId) {
            fetch(`http://127.0.0.1:8000/api/reservation/delete/${reservationId}`, {
                method: 'DELETE'
            })
            .then(response => {
                if (!response.ok) {
                    showNotification('Erreur lors de la suppression', 'error');
                } else {
                    window.location.reload();
                }
                });
        }
    </script>
</body>
</html>