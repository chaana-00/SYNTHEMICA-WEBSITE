<?php
// ===============================
// Career Form Processing
// ===============================

$servername = "localhost";
$username   = "root";
$password   = "1234";
$dbname     = "medivesta_db"; // CHANGE IF NEEDED

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("DB connection failed: " . $conn->connect_error);
}

// Upload directory
$upload_dir = __DIR__ . "/uploads/cv/";
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Get POST data
$name     = $_POST['c_name'] ?? '';
$email    = $_POST['c_email'] ?? '';
$contact  = $_POST['c_contact'] ?? '';
$position = $_POST['c_position'] ?? '';
$message  = $_POST['c_message'] ?? '';

$cv_name = "";

// ===============================
// File Upload
// ===============================
if (!empty($_FILES['cv_file']['name'])) {
    
    $file_tmp  = $_FILES['cv_file']['tmp_name'];
    $file_name = time() . "_" . basename($_FILES['cv_file']['name']);

    $allowed = ['pdf', 'doc', 'docx'];
    $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) {
        die("Invalid CV format. Allowed: PDF, DOC, DOCX");
    }

    move_uploaded_file($file_tmp, $upload_dir . $file_name);
    $cv_name = $file_name;
}

// ===============================
// Save to Database
// ===============================
$stmt = $conn->prepare("
    INSERT INTO career_applications
    (full_name, email, contact, position, message, cv_filename)
    VALUES (?, ?, ?, ?, ?, ?)
");

$stmt->bind_param("ssssss", $name, $email, $contact, $position, $message, $cv_name);
$stmt->execute();
$stmt->close();
$conn->close();

// ===============================
// Redirect back with success
// ===============================
header("Location: career.html?success=1");
exit;
?>
