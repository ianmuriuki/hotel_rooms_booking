<?php
include 'connection.php';

if (isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];

    // Fetch booking details
    $sql = "SELECT b.booking_id, b.name, b.email, b.check_in, b.check_out, b.duration, r.room_name, r.price_per_night
            FROM bookings b
            JOIN rooms r ON b.room_id = r.room_id
            WHERE b.booking_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $booking = $result->fetch_assoc();

    if (!$booking) {
        die("Booking not found.");
    }

    // Calculate total price
    $total_price = $booking['duration'] * $booking['price_per_night'];
} else {
    die("No booking ID provided.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
body {
    background-image: url(img2.jpg);
    font-family: Arial, sans-serif;
    color: #333;
}
.container {
    width: 50%;
    margin: 50px auto;
    padding: 20px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}
h2, h3 {
    margin-bottom: 15px;
}
button {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
button:hover {
    background-color: #0056b3;
}
</style>
<body>
    <div class="container">
        <h2>Payment Confirmation</h2>
        <p><strong>Booking ID:</strong> <?php echo htmlspecialchars($booking['booking_id']); ?></p>
        <p><strong>Room:</strong> <?php echo htmlspecialchars($booking['room_name']); ?></p>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($booking['name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($booking['email']); ?></p>
        <p><strong>Check-in:</strong> <?php echo htmlspecialchars($booking['check_in']); ?></p>
        <p><strong>Check-out:</strong> <?php echo htmlspecialchars($booking['check_out']); ?></p>
        <p><strong>Duration:</strong> <?php echo $booking['duration']; ?> nights</p>
        <h3>Total Price: $<?php echo number_format($total_price, 2); ?></h3>

        <form action="payment_process.php" method="post">
            <input type="hidden" name="booking_id" value="<?php echo $booking['booking_id']; ?>">
            <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
            <button type="submit" name="pay">Confirm Payment</button>
        </form>
    </div>
</body>
</html>
