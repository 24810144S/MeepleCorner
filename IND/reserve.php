<?php
/*
SEHS4517 Web Application Development and Management
Individual Assignment
Scenario: Drone Training Center Equipment Rental Portal
Full Name: LIU SHA
Student ID: 24810144S
*/

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
$password          = $_POST['password'] ?? '';

// Optional: simple protection if user opens reserve.php directly
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: reserve.html');
    exit;
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Review - Drone Training Center</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .review-card {
            width: 85%;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            padding: 40px 80px;
        }

        .review-card h2 {
            margin-top: 0;
            color: var(--blue);
            border-left: 5px solid var(--orange);
            padding-left: 10px;
        }

        .review-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .review-table th,
        .review-table td {
            padding: 14px 12px;
            border-bottom: 1px solid #d7e2ef;
            vertical-align: top;
        }

        .review-table th {
            width: 280px;
            text-align: left;
            color: var(--blue-dark);
            background: #f7fbff;
        }

        .review-actions {
            margin-top: 30px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .review-actions button {
            border: none;
            padding: 11px 18px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
        }

        .back-btn {
            background: #7b8794;
            color: #ffffff;
        }

        .back-btn:hover {
            background: #59636e;
        }

        .confirm-btn {
            background: var(--blue);
            color: #ffffff;
        }

        .confirm-btn:hover {
            background: var(--orange);
        }

        .hint-box {
            background: #eef4fb;
            border: 1px solid #d7e2ef;
            border-radius: 8px;
            padding: 16px 18px;
            margin-top: 20px;
        }

        @media (max-width: 900px) {
            .review-card {
                width: 92%;
                padding: 28px 22px;
            }

            .review-table th,
            .review-table td {
                display: block;
                width: 100%;
            }
        }
    </style>
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
            <tr>
                <th>Organization</th>
                <td><?= e($organization) ?></td>
            </tr>
            <tr>
                <th>Member First Name</th>
                <td><?= e($firstName) ?></td>
            </tr>
            <tr>
                <th>Member Last Name</th>
                <td><?= e($lastName) ?></td>
            </tr>
            <tr>
                <th>Gender</th>
                <td><?= e($gender) ?></td>
            </tr>
            <tr>
                <th>Date of Reservation</th>
                <td><?= e($reservationDate) ?></td>
            </tr>
            <tr>
                <th>Time of Reservation</th>
                <td><?= e($reservationTime) ?></td>
            </tr>
            <tr>
                <th>Item to Reserve</th>
                <td><?= e($itemToReserve) ?></td>
            </tr>
            <tr>
                <th>Contact Mailing Address</th>
                <td><?= nl2br(e($mailingAddress)) ?></td>
            </tr>
            <tr>
                <th>Contact Phone Number</th>
                <td><?= e($phoneNumber) ?></td>
            </tr>
            <tr>
                <th>Email Address</th>
                <td><?= e($emailAddress) ?></td>
            </tr>
            <tr>
                <th>Member Username</th>
                <td><?= e($username) ?></td>
            </tr>
            <tr>
                <th>Member Password</th>
                <td><?= e($password) ?></td>
            </tr>
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