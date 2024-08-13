<?php
include 'db.php';

$unique_code = $_POST['uniqueCode'];

$sql = "SELECT r.name, r.email, e.event_name 
        FROM registrations r 
        JOIN events e ON r.event_id = e.id 
        WHERE r.unique_code = '$unique_code'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $details = $result->fetch_assoc();
    echo json_encode($details);
} else {
    echo json_encode(null);
}

$conn->close();
?>
