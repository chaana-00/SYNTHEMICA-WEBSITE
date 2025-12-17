<?php
// ======================
// CONFIG
// ======================
require __DIR__ . "/vendor/autoload.php";   // PHPMailer
require __DIR__ . "/config/db.php";         // DB connection

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// ======================
// CHECK REQUEST
// ======================
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.html");
    exit;
}

$email = trim($_POST['email'] ?? '');

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: index.html?subscribe=invalid");
    exit;
}

// ======================
// INSERT INTO DATABASE (SAFE)
// ======================
$stmt = $conn->prepare("INSERT INTO subscribers (email, created_at) VALUES (?, NOW())");
$stmt->bind_param("s", $email);

if (!$stmt->execute()) {

    // If duplicate entry (email already subscribed)
    if ($conn->errno == 1062) {
        header("Location: index.html?subscribe=exists");
        exit;
    }

    // Other DB errors
    header("Location: index.html?subscribe=dberror");
    exit;
}

// ======================
// SEND EMAILS
// ======================
$mail = new PHPMailer(true);

try {
    // SMTP CONFIG
    $mail->isSMTP();
    $mail->Host       = "smtp.gmail.com";
    $mail->SMTPAuth   = true;
    $mail->Username   = "yourmail@gmail.com";      // your email
    $mail->Password   = "your-app-password";       // your app password
    $mail->SMTPSecure = "tls";
    $mail->Port       = 587;

    // -----------------------
    // SEND EMAIL TO SUBSCRIBER
    // -----------------------
    $mail->setFrom("yourmail@gmail.com", "Medivesta");
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = "Subscription Successful – Medivesta";
    $mail->Body = "
        <h3>Thank you for subscribing!</h3>
        <p>You will now receive our latest news, offers, and updates.</p>
        <br>
        <strong>Medivesta Laboratory (Pvt) Ltd.</strong>
    ";

    $mail->send();
    $mail->clearAddresses();

    // -----------------------
    // EMAIL TO ADMIN
    // -----------------------
    $mail->addAddress("info@medivesta.com");
    $mail->Subject = "New Website Subscriber";
    $mail->Body = "
        <h3>New Subscriber</h3>
        <p>Email: <b>{$email}</b></p>
        <p>Subscribed on: " . date("Y-m-d H:i:s") . "</p>
    ";

    $mail->send();

} catch (Exception $e) {
    // (Optional) Log email error to file
}

// ======================
// REDIRECT
// ======================
header("Location: index.html?subscribe=success");
exit;
?>
