

<?php 
include 'connection.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payment_code = $_POST['payment_code'];
    $total_price = $_POST['total_price'];

    // Defines a hardcoded valid payment code (p1a2i3d4) for demonstration purposes.
    $valid_payment_code = 'p1a2i3d4';

    // Check if the payment code is valid
    if ($payment_code === $valid_payment_code) {
        // Find the latest booking with pending payment
        $sql = "SELECT booking_id FROM bookings WHERE total_price = ? AND payment_status = 'Pending' ORDER BY booking_id DESC LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("d", $total_price);
        $stmt->execute();
        $result = $stmt->get_result();
        $booking = $result->fetch_assoc();

        if ($booking) {
            // Update booking status
            $sql = "UPDATE bookings SET payment_status = 'Completed' WHERE booking_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $booking['booking_id']);
            $stmt->execute();

            echo "Payment confirmed! Your booking is complete.";
        } else {
            echo "No pending booking found for the given amount.";
        }
    } else {
        echo "Payment successfully.";
        Header("Location:index.php");
    }
}