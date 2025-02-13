<?php
include 'connection.php'; 

$sql = "SELECT * FROM rooms WHERE availability = TRUE";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Booking</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
       
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
                <li><a href="about.php"><i class="fas fa-info-circle"></i> About Us</a></li>
                <li><a href="contacts.php"><i class="fas fa-phone"></i> Contacts</a></li>
                <li><a href="rooms.php"><i class="fas fa-bed"></i> Rooms</a></li>
                <li style="float:right"><a href="#" onclick="showSignUpForm()"><i class="fas fa-user-plus"></i> Sign Up</a></li>
                <li style="float:right"><a href="#" onclick="showLoginForm()"><i class="fas fa-sign-in-alt"></i> Login</a></li>
            </ul>
        </nav>
    </header>
    
    <div class="container">
        <h1 class="text-center mb-5">Available Rooms for Booking</h1>
        <div class="row">
            <?php while($row = $result->fetch_assoc()): ?>
            <div class="col-lg-6 col-md-6 mb-4">
                <div class="room-card">
                    <img src="rooms_images/<?php echo htmlspecialchars($row['image']); ?>" alt="Room Image">
                    <div class="card-body">
                        <h2><?php echo htmlspecialchars($row['room_type']); ?></h2>
                        <p><?php echo htmlspecialchars($row['description']); ?></p>
                        <p>Price per night: $<?php echo htmlspecialchars($row['price_per_night']); ?></p>
                        <a href="bookings.php?room_id=<?php echo $row['room_id']; ?>">Book Now</a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Sign Up Form -->
    <div id="signUpForm" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeSignUpForm()">&times;</span>
            <form id="signUp" action="signup.php" method="post">
                <h2>Sign Up</h2>
                <label for="name">Username:</label>
                <input type="text" id="name" name="name" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Sign Up</button>
            </form>
        </div>
    </div>

    <!-- Login Form -->
    <div id="loginForm" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeLoginForm()">&times;</span>
            <form id="login" action="login.php" method="post">
                <h2>Login</h2>
                <label for="name">Username:</label>
                <input type="text" id="nameLogin" name="name" required>
                <label for="password">Password:</label>
                <input type="password" id="passwordLogin" name="password" required>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
    
    <footer>
        <p>&copy; 2024 Room Booking System. All rights reserved.</p>
    </footer>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Show/Hide Modal Forms
        function showSignUpForm() {
            $('#signUpForm').fadeIn();
        }

        function closeSignUpForm() {
            $('#signUpForm').fadeOut();
        }

        function showLoginForm() {
            $('#loginForm').fadeIn();
        }

        function closeLoginForm() {
            $('#loginForm').fadeOut();
        }
    </script>
</body>
</html>
