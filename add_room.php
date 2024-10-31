<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Room</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Add New Room</h1>
    </header>
    <div class="container">
        <!-- Ensure enctype="multipart/form-data" to handle file uploads -->
        <form action="process_add_room.php" method="post" enctype="multipart/form-data">
            <label for="room_type">Room Type:</label>
            <input type="text" id="room_type" name="room_type" required>
            
            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>
            
            <label for="price_per_night">Price Per Night:</label>
            <input type="number" id="price_per_night" name="price_per_night" step="0.01" required>
            
            <label for="availability">Availability:</label>
            <select id="availability" name="availability">
                <option value="1">Available</option>
                <option value="0">Not Available</option>
            </select>
            
            <!-- New Image Upload Field -->
            <label for="room_image">Room Image:</label>
            <input type="file" id="room_image" name="room_image" accept="image/*" required>
            
            <button type="submit">Add Room</button>
        </form>
    </div>
</body>
</html>
