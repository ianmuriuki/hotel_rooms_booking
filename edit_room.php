<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Room</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Edit Room</h1>
    </header>
    <div class="container">
        <?php
        include 'admin_config.php';
        
        $room_id = $_GET['id'];
        
        $sql = "SELECT * FROM rooms WHERE room_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $room_id);
        $stmt->execute();
        $room = $stmt->get_result()->fetch_assoc();
        ?>
        
        <form action="process_edit_room.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="room_id" value="<?php echo htmlspecialchars($room['room_id']); ?>">
            
            <label for="room_type">Room Type:</label>
            <input type="text" id="room_type" name="room_type" value="<?php echo htmlspecialchars($room['room_type']); ?>" required>
            
            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($room['description']); ?></textarea>
            
            <label for="price_per_night">Price Per Night:</label>
            <input type="number" id="price_per_night" name="price_per_night" step="0.01" value="<?php echo htmlspecialchars($room['price_per_night']); ?>" required>
            
            <label for="availability">Availability:</label>
            <select id="availability" name="availability">
                <option value="1" <?php echo $room['availability'] ? 'selected' : ''; ?>>Available</option>
                <option value="0" <?php echo !$room['availability'] ? 'selected' : ''; ?>>Not Available</option>
            </select>
            
            <label for="room_image">Current Image:</label>
            <br>
            <img src="rooms_images/<?php echo htmlspecialchars($room['image']); ?>" alt="Room Image" style="width: 150px; height: 150px; object-fit: cover;">
            <br><br>
            
            <label for="room_image">Upload New Image:</label>
            <input type="file" id="room_image" name="room_image" accept="image/*">
            
            <button type="submit">Update Room</button>
        </form>
    </div>
</body>
</html>
