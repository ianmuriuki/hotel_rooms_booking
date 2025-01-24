<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room_id = $_POST['room_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];

    // Fetch room price
    $sql = "SELECT * FROM rooms WHERE room_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $room_id);
    $stmt->execute();
    $room = $stmt->get_result()->fetch_assoc();
    
    // Calculate price
    $price_per_night = $room['price_per_night'];
    $check_in_date = new DateTime($check_in);
    $check_out_date = new DateTime($check_out);
    $interval = $check_in_date->diff($check_out_date);
    $nights = $interval->days;
    $total_price = $nights * $price_per_night;
    
    // Save booking to database
    $sql = "INSERT INTO bookings (user_id, room_id, check_in_date, check_out_date, total_price) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    // User ID should be fetched from session or user login
    $user_id = 1; // Example user ID
    $stmt->bind_param("iissd", $user_id, $room_id, $check_in, $check_out, $total_price);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Payment Details</h1>
    <p>Room ID: <?php echo htmlspecialchars($room_id); ?></p>
    <p>Name: <?php echo htmlspecialchars($name); ?></p>
    <p>Email: <?php echo htmlspecialchars($email); ?></p>
    <p>Check-in Date: <?php echo htmlspecialchars($check_in); ?></p>
    <p>Check-out Date: <?php echo htmlspecialchars($check_out); ?></p>
    <p>Total Price: $<?php echo htmlspecialchars($total_price); ?></p>

    <!-- Payment gateway integration here -->
    <form action="process_payment.php" method="post">
        <input type="hidden" name="total_price" value="<?php echo htmlspecialchars($total_price); ?>">
        <button type="submit">Pay Now</button>
    </form>
</body>
</html>