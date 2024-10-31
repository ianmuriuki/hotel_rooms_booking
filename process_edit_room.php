<?php
include 'admin_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room_id = $_POST['room_id'];
    $room_type = $_POST['room_type'];
    $description = $_POST['description'];
    $price_per_night = $_POST['price_per_night'];
    $availability = $_POST['availability'];
    
    $sql = "UPDATE rooms SET room_type = ?, description = ?, price_per_night = ?, availability = ? WHERE room_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdii", $room_type, $description, $price_per_night, $availability, $room_id);
    
    if ($stmt->execute()) {
        echo "Room updated successfully.";
    } else {
        echo "Error updating room: ";
    }
}
