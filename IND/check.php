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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Result - Drone Training Center</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .result-card {
            width: 85%;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            padding: 40px 80px;
            text-align: center;
        }

        .result-card h2 {
            margin-top: 0;
            font-size: 32px;
        }

        .result-success h2 {
            color: #1f7a3d;
        }

        .result-error h2 {
            color: #b42318;
        }

        .result-badge {
            display: inline-block;
            padding: 10px 18px;
            border-radius: 999px;
            font-weight: bold;
            margin-bottom: 18px;
        }

        .result-success .result-badge {
            background: #e8f7ed;
            color: #1f7a3d;
            border: 1px solid #b7e4c7;
        }

        .result-error .result-badge {
            background: #fdecec;
            color: #b42318;
            border: 1px solid #f5c2c7;
        }

        .result-message {
            max-width: 720px;
            margin: 0 auto 24px;
            font-size: 17px;
            line-height: 1.7;
        }

        .summary-box {
            margin: 30px auto 0;
            max-width: 760px;
            text-align: left;
            background: #f7fbff;
            border: 1px solid #d7e2ef;
            border-radius: 8px;
            padding: 20px 24px;
        }

        .summary-box h3 {
            margin-top: 0;
            color: var(--blue);
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
        }

        .summary-table th,
        .summary-table td {
            padding: 10px 8px;
            border-bottom: 1px solid #d7e2ef;
            vertical-align: top;
        }

        .summary-table th {
            width: 240px;
            text-align: left;
            color: var(--blue-dark);
        }

        .result-actions {
            margin-top: 28px;
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .result-actions a,
        .result-actions button {
            display: inline-block;
            text-decoration: none;
            border: none;
            padding: 11px 18px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
        }

        .home-btn {
            background: var(--blue);
            color: #ffffff;
        }

        .home-btn:hover {
            background: var(--orange);
        }

        .back-btn {
            background: #7b8794;
            color: #ffffff;
        }

        .back-btn:hover {
            background: #59636e;
        }

        @media (max-width: 900px) {
            .result-card {
                width: 92%;
                padding: 28px 22px;
            }

            .summary-table th,
            .summary-table td {
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
            <p class="tagline">Final Reservation Result</p>
        </div>
    </div>
    <div class="header-note">Validate • Result • Complete</div>
</header>

<main>
    <section class="result-card <?php echo $isValid ? 'result-success' : 'result-error'; ?>">
        <div class="result-badge">
            <?php echo $isValid ? 'Reservation Approved' : 'Reservation Not Approved'; ?>
        </div>

        <h2>
            <?php echo $isValid ? 'Thank You!' : 'Sorry'; ?>
        </h2>

        <p class="result-message">
            <?php
            if ($isValid) {
                echo 'Thank you for your reservation. Your booking request has been accepted and recorded successfully.';
            } else {
                echo e($statusMessage);
            }
            ?>
        </p>

        <div class="summary-box">
            <h3>Reservation Summary</h3>
            <table class="summary-table">
                <tr>
                    <th>Organization</th>
                    <td><?php echo e($organization); ?></td>
                </tr>
                <tr>
                    <th>Member Name</th>
                    <td><?php echo e($firstName . ' ' . $lastName); ?></td>
                </tr>
                <tr>
                    <th>Gender</th>
                    <td><?php echo e($gender); ?></td>
                </tr>
                <tr>
                    <th>Date of Reservation</th>
                    <td><?php echo e($reservationDate); ?></td>
                </tr>
                <tr>
                    <th>Time of Reservation</th>
                    <td><?php echo e($reservationTime); ?></td>
                </tr>
                <tr>
                    <th>Item to Reserve</th>
                    <td><?php echo e($itemToReserve); ?></td>
                </tr>
                <tr>
                    <th>Contact Mailing Address</th>
                    <td><?php echo nl2br(e($mailingAddress)); ?></td>
                </tr>
                <tr>
                    <th>Contact Phone Number</th>
                    <td><?php echo e($phoneNumber); ?></td>
                </tr>
                <tr>
                    <th>Email Address</th>
                    <td><?php echo e($emailAddress); ?></td>
                </tr>
                <tr>
                    <th>Member Username</th>
                    <td><?php echo e($username); ?></td>
                </tr>
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