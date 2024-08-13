<?php
include 'db.php';

$name = $_POST['name'];
$email = $_POST['email'];
$event_id = $_POST['event_id'];
$timestamp = date("Y-m-d H:i:s");

$sql = "INSERT INTO attendance (name, email, event_id, timestamp) VALUES ('$name', '$email', $event_id, '$timestamp')";

if ($conn->query($sql) === TRUE) {
    echo "Attendance recorded successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
