<?php
include 'admin_config.php';

if (isset($_GET['id'])) {
    $room_id = (int)$_GET['id'];

    // Fetch the image filename from the database
    $stmt = $conn->prepare("SELECT image FROM rooms WHERE room_id = ?");
    $stmt->bind_param("i", $room_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $room = $result->fetch_assoc();
        $image_name = $room['image'];
        
        // Define the directory where images are stored
        $image_directory = 'rooms_images/';
        $image_path = $image_directory . $image_name;

        // Delete the image file from the server
        if (file_exists($image_path)) {
            unlink($image_path);
        }

        // Delete the room record from the database
        $stmt = $conn->prepare("DELETE FROM rooms WHERE room_id = ?");
        $stmt->bind_param("i", $room_id);
        
        if ($stmt->execute()) {
            echo "Room deleted successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        echo "Room not found.";
    }
    
    $conn->close();
} else {
    echo "Invalid request.";
}
