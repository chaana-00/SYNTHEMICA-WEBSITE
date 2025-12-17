<?php
// ===============================
// DB CONNECTION
// ===============================
require __DIR__ . "/config/db.php";   // change if needed

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// ===============================
// CHECK REQUEST METHOD
// ===============================
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request");
}

// ===============================
// COLLECT & CLEAN FORM DATA
// ===============================
$name    = trim($_POST['p_name'] ?? '');
$email   = trim($_POST['p_email'] ?? '');
$subject = trim($_POST['p_subject'] ?? '');
$message = trim($_POST['p_message'] ?? '');

// ===============================
// VALIDATION
// ===============================
if ($name === "" || $email === "" || $message === "") {
    die("Please fill all required fields.");
}

// ===============================
// SAVE TO DATABASE
// ===============================
$stmt = $conn->prepare("
    INSERT INTO contact_messages (name, email, subject, message)
    VALUES (?, ?, ?, ?)
");

$stmt->bind_param("ssss", $name, $email, $subject, $message);

if ($stmt->execute()) {

    // OPTIONAL EMAIL TO ADMIN
    $to = "info@medivesta.com";
    $subject_mail = "New Contact Message from $name";

    $body = "
    Name: $name
    Email: $email
    Subject: $subject

    Message:
    $message
    ";

    $headers = "From: $email";

    // mail($to, $subject_mail, $body, $headers); // enable if server supports mail

    echo "
        <h2>Message Sent Successfully!</h2>
        <p>Thank you <b>$name</b>, we received your message.</p>
        <a href='contact.html'>Go back</a>
    ";

} else {
    echo "Failed to save message. Try again.";
}

$stmt->close();
$conn->close();

// INSERT SUCCESS — redirect back to contact.html
header("Location: contact.html?success=1");
exit();

?>
