<?php

// Database credentials - MAKE SURE THESE ARE CORRECT FOR YOUR XAMPP SETUP
$host = "localhost";
$username = "root";
$password = ""; // Default XAMPP password is often blank
$database = "portfolio"; // The database name you created

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $websites = isset($_POST['websites']) ? 1 : 0;
    $branding = isset($_POST['branding']) ? 1 : 0;
    $ecommerce = isset($_POST['ecommerce']) ? 1 : 0;
    $digital_card = isset($_POST['digital_card']) ? 1 : 0;
    $project_details = mysqli_real_escape_string($conn, $_POST['project_details']);

    // Prepare and execute the SQL query
    $sql = "INSERT INTO contact_form (name, email, websites, branding, ecommerce, digital_card, project_details) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    // Corrected bind_param: s for name, s for email, i for checkboxes, s for project_details
    $stmt->bind_param("ssiiiss", $name, $email, $websites, $branding, $ecommerce, $digital_card, $project_details);

    if ($stmt->execute()) {
        echo "Thank you for your message. We will get back to you shortly!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();

?>