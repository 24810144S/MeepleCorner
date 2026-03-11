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
    <title>Reservation Review - Drone Training Center</title>
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
            <p class="tagline">Reservation Review Page</p>
        </div>
    </div>
    <div class="header-note">Review • Confirm • Submit</div>
</header>

<main>
    <section class="review-card">
        <h2>Review Your Reservation Information</h2>

        <p>
            Please review all submitted information carefully before confirming your reservation.
            If any information is incorrect, press <strong>Back</strong> to return to the reservation form.
        </p>

        <table class="review-table">
            <tr><th>Organization</th><td><?= e($organization) ?></td></tr>
            <tr><th>Member First Name</th><td><?= e($firstName) ?></td></tr>
            <tr><th>Member Last Name</th><td><?= e($lastName) ?></td></tr>
            <tr><th>Gender</th><td><?= e($gender) ?></td></tr>
            <tr><th>Date of Reservation</th><td><?= e($reservationDate) ?></td></tr>
            <tr><th>Time of Reservation</th><td><?= e($reservationTime) ?></td></tr>
            <tr><th>Item to Reserve</th><td><?= e($itemToReserve) ?></td></tr>
            <tr><th>Contact Mailing Address</th><td><?= nl2br(e($mailingAddress)) ?></td></tr>
            <tr><th>Contact Phone Number</th><td><?= e($phoneNumber) ?></td></tr>
            <tr><th>Email Address</th><td><?= e($emailAddress) ?></td></tr>
            <tr><th>Member Username</th><td><?= e($username) ?></td></tr>
            <tr><th>Member Password</th><td><?= str_repeat('*', strlen($password)) ?></td></tr>
        </table>

        <div class="hint-box">
            <strong>Reminder:</strong> The final confirmation step will check whether the selected
            reservation date and time are between 24 and 72 hours in advance.
        </div>

        <div class="review-actions">
            <button type="button" class="back-btn" onclick="history.back()">Back</button>

            <form action="check.php" method="post">
                <input type="hidden" name="organization" value="<?= e($organization) ?>">
                <input type="hidden" name="first_name" value="<?= e($firstName) ?>">
                <input type="hidden" name="last_name" value="<?= e($lastName) ?>">
                <input type="hidden" name="gender" value="<?= e($gender) ?>">
                <input type="hidden" name="reservation_date" value="<?= e($reservationDate) ?>">
                <input type="hidden" name="reservation_time" value="<?= e($reservationTime) ?>">
                <input type="hidden" name="item_to_reserve" value="<?= e($itemToReserve) ?>">
                <input type="hidden" name="mailing_address" value="<?= e($mailingAddress) ?>">
                <input type="hidden" name="phone_number" value="<?= e($phoneNumber) ?>">
                <input type="hidden" name="email_address" value="<?= e($emailAddress) ?>">
                <input type="hidden" name="username" value="<?= e($username) ?>">
                <input type="hidden" name="password" value="<?= e($password) ?>">

                <button type="submit" class="confirm-btn">Confirm</button>
            </form>
        </div>
    </section>
</main>

<footer class="site-footer">
    Drone Training Center Equipment Rental Portal • SEHS4517 Individual Assignment
</footer>

</body>
</html>