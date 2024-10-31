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

    // Insert booking details into the database
    $sql = "INSERT INTO bookings (room_id, name, email, check_in, check_out) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $room_id, $name, $email, $check_in, $check_out);
    
    if ($stmt->execute()) {
        echo "Booking information received successfully!";
        header("Location: index.php");
        exit(); // Ensure no further code execution after redirect
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Room</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
body{
    background-image: url(img1.jpg);
}
</style>
<body>
    <h1>Book Room</h1>
    <form action="bookings.php" method="post">
        <input type="hidden" name="room_id" value="<?php echo htmlspecialchars($room['room_id']); ?>">
        
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="check_in">Check-in Date:</label>
        <input type="date" id="check_in" name="check_in" required>
        
        <label for="check_out">Check-out Date:</label>
        <input type="date" id="check_out" name="check_out" required>
        
        <button type="submit" name="submit">Book now</button>
    </form>
</body>
</html>
