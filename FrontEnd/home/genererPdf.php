<?php
require("./fpdf/fpdf.php");

session_start();

class FlightReservationPDF extends FPDF
{
    private $data;
    private $flightData;
    private $reservationData;
    private $planeData;
    private $userFirstName;
    private $userLastName;
    private $userEmail;
    private $userBirthday;
    private $aeroportDepart;
    private $aeroportArrive;

    public function __construct($flightId, $reservationId)
    {
        parent::__construct();
        $this->SetMargins(15, 15, 15);
        $this->SetAutoPageBreak(true, 15);

        // Récupération des informations sur le vol
        $ch = curl_init("http://127.0.0.1:8000/api/flies/get-by-id/" . $flightId);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $this->flightData = json_decode($response, true);

        // Récupération des informations sur la réservation
        $ch = curl_init("http://127.0.0.1:8000/api/reservation/get-by-id/" . $reservationId);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $this->reservationData = json_decode($response, true);

        // Récupération des informations sur l'avion
        $ch = curl_init("http://127.0.0.1:8000/api/planes/get-by-id/" . $this->flightData['plane_id']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $this->planeData = json_decode($response, true);

        // Récupérer le nom de l'aéroport de départ
        $ch = curl_init("http://127.0.0.1:8000/api/aeroport/get-by-id/" . $this->flightData['aeroport_depart_id']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $this->data = json_decode($response, true);
        $this->aeroportDepart = $this->data['city'];

        // Récupérer le nom de l'aéroport d'arrivée
        $ch = curl_init("http://127.0.0.1:8000/api/aeroport/get-by-id/" . $this->flightData['aeroport_arrive_id']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $this->data = json_decode($response, true);
        $this->aeroportArrive = $this->data['city'];

        // Récupération des informations sur l'utilisateur
        $this->userFirstName = $_SESSION['user']['first_name'];
        $this->userLastName = $_SESSION['user']['last_name'];
        $this->userEmail = $_SESSION['user']['email'];
        $this->userBirthday = $_SESSION['user']['birthday'];
    }

    public function Header()
    {
        $this->SetFont("Arial", "B", 16);
        $this->SetTextColor(0, 51, 102); // Dark blue
        $this->Cell(0, 10, "Flight Reservation Ticket", 0, 1, "C");
        $this->SetLineWidth(0.5);
        $this->Line(15, 25, $this->GetPageWidth() - 15, 25);
        $this->Ln(10);
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont("Arial", "I", 8);
        $this->SetTextColor(128);
        $this->Cell(0, 10, "Page " . $this->PageNo() . " / {nb}", 0, 0, "C");
    }

    public function CreateContent()
    {
        // Section Vol
        $this->SetFont("Arial", "B", 12);
        $this->SetTextColor(0, 51, 102); // Dark blue
        $this->Cell(0, 10, "Informations de Vol", 0, 1, "L");
        $this->SetFont("Arial", "", 10);
        $this->SetTextColor(0);

        $this->CreateInfoRow("Numero de Vol", $this->flightData['flightNumber']);
        $this->CreateInfoRow("Depart de", $this->aeroportDepart);
        $this->CreateInfoRow("Destination", $this->aeroportArrive);
        $this->CreateInfoRow("Depart a", $this->flightData['takeoffTime']);
        $this->CreateInfoRow("Arrivee a", $this->flightData['landingTime']);
        $this->CreateInfoRow("Duree du vol", $this->flightData['flightDuration'] . " minutes");
        $this->CreateInfoRow("Modele de l'Avion", $this->planeData['model'] ?? 'Inconnu');
        $this->CreateInfoRow("Numero de siege", $this->reservationData['placeNumber'] ?? 'Placement Libre');

        $this->Ln(10);

        // Section Passager
        $this->SetFont("Arial", "B", 12);
        $this->SetTextColor(0, 51, 102); // Dark blue
        $this->Cell(0, 10, "Informations du Passager", 0, 1, "L");
        $this->SetFont("Arial", "", 10);
        $this->SetTextColor(0);

        $this->CreateInfoRow("Prenom Nom", $this->userFirstName . " " . $this->userLastName);
        $this->CreateInfoRow("Email", $this->userEmail);
        $this->CreateInfoRow("Date de Naissance", $this->userBirthday);
    }

    private function CreateInfoRow($label, $value)
    {
        $this->SetFont("Arial", "B", 10);
        $this->Cell(50, 7, $label . ":", 0, 0, "L");
        $this->SetFont("Arial", "", 10);
        $this->Cell(0, 7, $value, 0, 1, "L");
    }
}

$flightId = $_GET['flightId'];
$reservationId = $_GET['reservationId'];
$pdf = new FlightReservationPDF($flightId, $reservationId);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->CreateContent();
ob_clean();
$pdf->Output();
?>