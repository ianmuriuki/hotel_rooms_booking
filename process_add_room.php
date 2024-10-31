<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room_type = htmlspecialchars($_POST['room_type']);
    $description = htmlspecialchars($_POST['description']);
    $price_per_night = htmlspecialchars($_POST['price_per_night']);
    $availability = (int)$_POST['availability'];

    // Handle file upload
    if (isset($_FILES['room_image'])) {
        $image_name = $_FILES['room_image']['name'];
        $image_tmp_name = $_FILES['room_image']['tmp_name'];
        $image_size = $_FILES['room_image']['size'];
        $image_error = $_FILES['room_image']['error'];
        
        // Debugging information
        echo "Image Name: $image_name<br>";
        echo "Temporary Name: $image_tmp_name<br>";
        echo "Image Size: $image_size<br>";
        echo "Image Error: $image_error<br>";
        
        if ($image_error === 0) {
            // Define the directory to store images
            $image_directory = 'rooms_images/';
            
            // Ensure the directory exists
            if (!is_dir($image_directory)) {
                mkdir($image_directory, 0755, true);
            }

            // Generate a unique name for the image
            $image_new_name = uniqid('', true) . '-' . $image_name;
            $image_destination = $image_directory . $image_new_name;
            
            // Move the uploaded file to the target directory
            if (move_uploaded_file($image_tmp_name, $image_destination)) {
                // Insert room details into the database
                $stmt = $conn->prepare("INSERT INTO rooms (room_type, description, price_per_night, availability, image) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("ssdis", $room_type, $description, $price_per_night, $availability, $image_new_name);
                
                if ($stmt->execute()) {
                    echo "Room added successfully!";
                } else {
                    echo "Error: " . $stmt->error;
                }
                
                $stmt->close();
            } else {
                echo "Failed to move the uploaded image.";
            }
        } else {
            echo "There was an error uploading your file. Error code: $image_error";
            // Print out a more specific error message
            switch ($image_error) {
                case UPLOAD_ERR_INI_SIZE:
                    echo "The uploaded file exceeds the upload_max_filesize directive in php.ini.";
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    echo "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.";
                    break;
                case UPLOAD_ERR_PARTIAL:
                    echo "The uploaded file was only partially uploaded.";
                    break;
                case UPLOAD_ERR_NO_FILE:
                    echo "No file was uploaded.";
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    echo "Missing a temporary folder.";
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    echo "Failed to write file to disk.";
                    break;
                case UPLOAD_ERR_EXTENSION:
                    echo "A PHP extension stopped the file upload.";
                    break;
                default:
                    echo "Unknown error.";
                    break;
            }
        }
    } else {
        echo "No image uploaded or an unknown error occurred.";
    }
}

$conn->close();
