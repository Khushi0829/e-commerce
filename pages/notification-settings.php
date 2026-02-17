<?php
session_start();
require_once __DIR__ . '/../config/db.php';


// $user_id = $_SESSION['user_id'];


// fetch preferences
$stmt = $conn->prepare("SELECT * FROM notification_preferences WHERE user_id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$prefs = $result->fetch_assoc();

// default values if not exists
$prefs = $prefs ?? [
    'email_notify'=>1,
    'sms_notify'=>0,
    'whatsapp_notify'=>0,
    'order_updates'=>1,
    'promotions'=>0
];
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Preferences</title>

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/master.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">

</head>
<body>

<?php
 // ✅ load header (BASE_URL etc)
 require_once __DIR__ . '/../includes/header.php';

   if (!isset($_SESSION['user_id'])){
     include __DIR__ . '/../includes/login-required.php';
    exit; // stop rest of page
    }
 ?>

<div class="notify-box" data-aos="fade-up" data-aos-delay="0">
    <h4 class="mb-3" data-aos="fade-up" data-aos-delay="100">
        <i class="fa fa-bell" aria-hidden="true"></i> Notification Preferences
    </h4>

    <form action="save-notification.php" method="POST">
        <div class="notify-item" data-aos="fade-up" data-aos-delay="200">
            <span>Email Notifications</span>
            <input type="checkbox" name="email_notify" <?= $prefs['email_notify'] ? 'checked' : '' ?>>
        </div>

        <div class="notify-item" data-aos="fade-up" data-aos-delay="300">
            <span>SMS Notifications</span>
            <input type="checkbox" name="sms_notify" <?= $prefs['sms_notify'] ? 'checked' : '' ?>>
        </div>

        <div class="notify-item" data-aos="fade-up" data-aos-delay="400">
            <span>WhatsApp Notifications</span>
            <input type="checkbox" name="whatsapp_notify" <?= $prefs['whatsapp_notify'] ? 'checked' : '' ?>>
        </div>

        <div class="notify-item" data-aos="fade-up" data-aos-delay="500">
            <span>Order Updates</span>
            <input type="checkbox" name="order_updates" <?= $prefs['order_updates'] ? 'checked' : '' ?>>
        </div>

        <div class="notify-item" data-aos="fade-up" data-aos-delay="600">
            <span>Offers & Promotions</span>
            <input type="checkbox" name="promotions" <?= $prefs['promotions'] ? 'checked' : '' ?>>
        </div>

        <button class="btn search-btn w-100 mt-3" data-aos="fade-up" data-aos-delay="700">Save Preferences</button>
    </form>
</div>

<?php include "../includes/footer.php" ?>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous">
    </script>

    <!-- --------------AOS JS---------- -->

    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

    <script>
        AOS.init({
            duration: 700,
            easing: 'ease-out-cubic',
            once: true,          // animation runs once
            offset: 120          // triggers slightly before visible
        });
    </script>

    <script src="../assets/js/script.js"></script>
</body>
</html>
