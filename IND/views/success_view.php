<?php
/*
SEHS4517 Web Application Development and Management
Individual Assignment
Scenario: Drone Training Center Equipment Rental Portal
Full Name: LIU SHA
Student ID: 24810144S
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Approved - Drone Training Center</title>
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<header class="site-header">
    <div class="brand-wrap">
        <div class="logo-box">
            <img src="images/logo.svg" alt="Drone Training Center Logo" class="logo-icon">
        </div>
        <div>
            <h1>Drone Training Center</h1>
            <p class="tagline">Reservation Approved</p>
        </div>
    </div>
    <div class="header-note">Validate • Result • Complete</div>
</header>

<main>
    <section class="result-card">
        <div class="result-badge">Reservation Approved</div>
        <h2>Thank You!</h2>

        <p class="result-message">
            Thank you for your reservation. Your booking request has been accepted and recorded successfully.
        </p>

        <div class="summary-box">
            <h3>Reservation Summary</h3>
            <table class="summary-table">
                <tr><th>Organization</th><td><?= e($organization) ?></td></tr>
                <tr><th>Member Name</th><td><?= e($firstName . ' ' . $lastName) ?></td></tr>
                <tr><th>Gender</th><td><?= e($gender) ?></td></tr>
                <tr><th>Date of Reservation</th><td><?= e($reservationDate) ?></td></tr>
                <tr><th>Time of Reservation</th><td><?= e($reservationTime) ?></td></tr>
                <tr><th>Item to Reserve</th><td><?= e($itemToReserve) ?></td></tr>
                <tr><th>Contact Mailing Address</th><td><?= nl2br(e($mailingAddress)) ?></td></tr>
                <tr><th>Contact Phone Number</th><td><?= e($phoneNumber) ?></td></tr>
                <tr><th>Email Address</th><td><?= e($emailAddress) ?></td></tr>
                <tr><th>Member Username</th><td><?= e($username) ?></td></tr>
            </table>
        </div>

        <div class="result-actions">
            <a href="reserve.html" class="home-btn">Return to Reservation Form</a>
        </div>
    </section>
</main>

<footer class="site-footer">
    Drone Training Center Equipment Rental Portal • SEHS4517 Individual Assignment
</footer>

</body>
</html>