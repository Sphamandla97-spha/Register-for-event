<?php
include 'db.php';
require 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Now you can use getenv() or $_ENV to access the variables
$username = getenv('GMAIL_USERNAME');
$password = getenv('GMAIL_PASSWORD');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $event_id = $_POST['event'];
    $unique_code = generateUniqueCode();
    $timestamp = date("Y-m-d H:i:s");

    $sql = "INSERT INTO registrations (name, email, event_id, unique_code, timestamp) VALUES ('$name', '$email', $event_id, '$unique_code', '$timestamp')";

    
    if ($conn->query($sql) === TRUE) {
        // Redirect to send confirmation email
        header("Location: send_confirmation.php?name=$name&email=$email&event_id=$event_id&unique_code=$unique_code");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
    
    
function generateUniqueCode() {
    return 'NECT' . rand(100, 999);
}
?>