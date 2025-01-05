<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

// Include configuration (optional, for better organization)
$config = include('config.php');

// Database connection
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'vcode';

$db = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($db->connect_error) {
    die("Database connection failed: " . $db->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect the form data
    $service = $_POST['service'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Validate the data
    if (empty($service) || empty($name) || empty($email) || empty($message)) {
        die("Please fill all required fields.");
    }

    // Insert the form data into the database
    $stmt = $db->prepare("INSERT INTO contacts (service, name, email, message) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Statement preparation error: " . $db->error);
    }

    $stmt->bind_param("ssss", $service, $name, $email, $message);

    if (!$stmt->execute()) {
        die("Error inserting data into database: " . $stmt->error);
    }

    // Send the email using PHPMailer
    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = $config['mail_host']; // Use your mail host
        $mail->SMTPAuth = true;
        $mail->Username = $config['mail_username']; // Your email address
        $mail->Password = $config['mail_password']; // Your email password or app password
        $mail->SMTPSecure = $config['mail_encryption']; // Use TLS encryption
        $mail->Port = $config['mail_port'];

        // Sender and recipient
        $mail->setFrom($config['mail_from_address'], $config['mail_from_name']);
        $mail->addAddress('vcodetechnologiesusa@gmail.com'); // Recipient email address

        // Email content
        $mail->isHTML(false); // Set email format to plain text
        $mail->Subject = "New Contact Form Submission";
        $mail->Body = "Service: $service\nName: $name\nEmail: $email\nMessage: $message";

        // Send the email
        $mail->send();

        // Redirect on success
        header("Location: contact.html"); // Redirect to the contact page after successful submission
        exit();
    } catch (Exception $e) {
        echo "Failed to send message. Error: " . $mail->ErrorInfo;
    }
}

// Close the database connection
$db->close();
?>
