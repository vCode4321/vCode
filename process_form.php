<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect the form data
    $service = $_POST['service'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Validate the data
    if (empty($service) || empty($name) || empty($email) || empty($message)) {
        error_log("Form submission error: Missing required fields.");
        die("Please fill all required fields.");
    }

    // Database connection
    $db_host = 'localhost';
    $db_user = 'root';
    $db_pass = '';
    $db_name = 'vcode';

    $db = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($db->connect_error) {
        error_log("Database connection error: " . $db->connect_error);
        die("Connection failed: " . $db->connect_error);
    }

    // Prepare and bind
    $stmt = $db->prepare("INSERT INTO contacts (service, name, email, message) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        error_log("Statement preparation error: " . $db->error);
        die("Statement preparation error: " . $db->error);
    }
    $stmt->bind_param("ssss", $service, $name, $email, $message);

    // Execute the statement
    if ($stmt->execute()) {
        // Send the email 
        $to = "sales@vcodetechnologies.com";
        $subject = "New Contact Form Submission";
        $body = "Service: $service\nName: $name\nEmail: $email\nMessage: $message";
        $headers = "From: $email";

        if (mail($to, $subject, $body, $headers)) {
            header("Location: contact.html"); // Redirect to contact.html
            exit(); // Ensure no further code is executed
        } else {
            error_log("Failed to send email.");
            echo "Failed to send message.";
        }
    } else {
        error_log("Database insertion error: " . $stmt->error);
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $db->close();
} else {
    error_log("Invalid request method.");
    echo "Invalid request method.";
}
?>
