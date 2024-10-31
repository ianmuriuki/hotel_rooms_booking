<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
    </header>
    <div class="container">
        <h2>Manage Rooms</h2>
        <a href="add_room.php">Add New Room</a>
        <h3>Available Rooms</h3>
        <?php
        include 'admin_config.php';
        
        $sql = "SELECT * FROM rooms";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            echo '<table>';
            echo '<tr><th>Room ID</th><th>Room Type</th><th>Description</th><th>Price Per Night</th><th>Availability</th><th>Actions</th></tr>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['room_id']) . '</td>';
                echo '<td>' . htmlspecialchars($row['room_type']) . '</td>';
                echo '<td>' . htmlspecialchars($row['description']) . '</td>';
                echo '<td>$' . htmlspecialchars($row['price_per_night']) . '</td>';
                echo '<td>' . ($row['availability'] ? 'Available' : 'Not Available') . '</td>';
                echo '<td><a href="edit_room.php?id=' . $row['room_id'] . '">Edit</a> | <a href="delete_room.php?id=' . $row['room_id'] . '">Delete</a></td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo 'No rooms available.';
        }
        ?>
    </div>
</body>
</html>
