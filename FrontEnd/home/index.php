<!DOCTYPE html>
<html lang="en">
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
    ?>

    <div class="main-container">

    <div class="filters-section">
    <form method="GET" class="filters-form">
        <div class="filter-group">
            <label for="date">Date de départ:</label>
            <input type="date" id="date" name="date" value="<?php echo $dateFilter; ?>">
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

        <button type="submit" class="filter-button">Filtrer</button>
    </form>
    </div>

        <?php
        foreach ($flies as $flight) {
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
                        <h3>Vol <?php echo htmlspecialchars($flight['flightNumber']); ?></h3>
                    </div>
                    <div class="flight-details">
                        <p>Départ de: <b><?php echo htmlspecialchars($departureAirport['city'] ?? 'N/A'); ?></b></p>
                        <p>Arrivée à: <b><?php echo htmlspecialchars($arrivalAirport['city'] ?? 'N/A'); ?></b></p>
                        <p>Date de départ: <b><?php echo date('d/m/Y H:i', strtotime($flight['takeoffTime'])); ?></b></p>
                        <p>Date d'arrivée: <b><?php echo date('d/m/Y H:i', strtotime($flight['landingTime'])); ?></b></p>
                        <p>Durée: <b><?php echo $flight['flightDuration']; ?> minutes</b></p>
                        <button onclick="reserverVol(<?php echo $flight['id']; ?>)" class="reserve-button">Réserver</button>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#date", {
            dateFormat: "Y-m-d",
        });

        function reserverVol(flightId) {
            window.location.href = 'reserver.php?flightId=' + flightId;
        }
    </script>
</body>
</html>