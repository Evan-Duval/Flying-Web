<?php

session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../connexion/connexion.php');
    exit;
}

$flightId = $_GET['flightId'];
$volRetour = isset($_GET['volRetour']) ? $_GET['volRetour'] : null;

$ch = curl_init("http://127.0.0.1:8000/api/flies/get-by-id/" . $flightId);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$flight = json_decode($response, true);

$ch = curl_init("http://127.0.0.1:8000/api/plane/get-by-id/" . $flight['plane_id']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$plane = json_decode($response, true);

$reservation = [
    'dateTime' => date('Y-m-d H:i:s'),
    'type' => 'aller-simple',
    'placeNumber' => rand(1, $plane['nbPlace']),
    'user_id' => $_SESSION['user']['id'],
    'flie_id' => $flightId
];

$ch = curl_init('http://127.0.0.1:8000/api/reservation/create');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($reservation));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
$response = curl_exec($ch);
curl_close($ch);

if ($volRetour) {
    header('Location: index.php?success=1&type=aller&depart=' . $flight['aeroport_arrive_id'] . '&arrive=' . $flight['aeroport_depart_id'] . '&hide-past-flights=on'); 
}
else {
    header('Location: index.php?aller_success=1'); 
}

?>