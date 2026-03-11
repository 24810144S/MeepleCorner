<?php
/*
SEHS4517 Web Application Development and Management
Individual Assignment
Scenario: Drone Training Center Equipment Rental Portal
Full Name: LIU SHA
Student ID: 24810144S
*/

require_once 'ReservationModel.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: reserve.html');
    exit;
}

$organization      = $_POST['organization'] ?? 'Drone Training Center';
$firstName         = trim($_POST['first_name'] ?? '');
$lastName          = trim($_POST['last_name'] ?? '');
$gender            = $_POST['gender'] ?? '';
$reservationDate   = $_POST['reservation_date'] ?? '';
$reservationTime   = $_POST['reservation_time'] ?? '';
$itemToReserve     = $_POST['item_to_reserve'] ?? '';
$mailingAddress    = trim($_POST['mailing_address'] ?? '');
$phoneNumber       = trim($_POST['phone_number'] ?? '');
$emailAddress      = trim($_POST['email_address'] ?? '');
$username          = trim($_POST['username'] ?? '');

$model = new ReservationModel();
$result = $model->validateReservation($reservationDate, $reservationTime);

$isValid = $result['valid'];
$statusMessage = $result['message'];

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

if ($isValid) {
    require 'views/success_view.php';
} else {
    require 'views/error_view.php';
}