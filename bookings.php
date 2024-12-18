<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['room_id'])) {
    $room_id = $_GET['room_id'];
    
    // Fetch room details
    $sql = "SELECT * FROM rooms WHERE room_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $room_id);
    $stmt->execute();
    $room = $stmt->get_result()->fetch_assoc();
}

if (isset($_POST["submit"])) {
    $room_id = $_POST['room_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];

    // Calculate duration of stay
    $start_date = new DateTime($check_in);
    $end_date = new DateTime($check_out);
    $duration = $start_date->diff($end_date)->days; // Number of nights

    // Fetch room price
    $sql = "SELECT price_per_night FROM rooms WHERE room_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $room_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $room = $result->fetch_assoc();
    $price_per_night = $room['price_per_night'];

    // Calculate total price
    $total_price = $duration * $price_per_night;

    // Insert booking details into the database
    $sql = "INSERT INTO bookings (room_id, name, email, check_in, check_out, total_price) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssd", $room_id, $name, $email, $check_in, $check_out, $total_price);
    
    if ($stmt->execute()) {
        // Redirect to pay.php with booking details
        $booking_id = $stmt->insert_id; // Get the last inserted booking ID
        header("Location: pay.php?booking_id=$booking_id&total_price=$total_price");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
