<?php
include 'db.php';

$sql = "SELECT id, event_name FROM events";
$result = $conn->query($sql);

$events = [];
while($row = $result->fetch_assoc()) {
    $events[] = $row;
}

echo json_encode($events);
?>
