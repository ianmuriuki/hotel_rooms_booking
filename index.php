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
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url(room_images/image3.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            color: #333;
        }

        nav {
            background-color: #333;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: space-between;
        }

        nav ul li {
            padding: 14px 20px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
        }

        nav ul li a:hover {
            background-color: #555;
        }

        .container {
            padding: 40px;
        }

        .room-card {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            transition: 0.3s;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .room-card:hover {
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        }

        .room-card img {
            width: 100%;
            height: 300px; /* Set fixed height to create a square */
            object-fit: cover; /* Ensure the image covers the square without distortion */
        }

        .room-card .card-body {
            padding: 15px;
        }

        .room-card h2 {
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        .room-card p {
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .room-card a {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }

        .room-card a:hover {
            background-color: #555;
        }

        .modal-content {
            background-color: #fefefe;
            border: 1px solid #333;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
        }

        .modal-content h2 {
            margin-bottom: 20px;
            color: #e74c3c;
        }

        .modal-content label {
            margin-bottom: 10px;
        }

        .modal-content input {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
        }

        .modal-content button {
            background-color: #e74c3c;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }

        .modal-content button:hover {
            background-color: #c0392b;
        }

        .close {
            color: #aaa;
            font-size: 28px;
            position: absolute;
            right: 20px;
            top: 20px;
            cursor: pointer;
        }

        footer {
            text-align: center;
            padding: 10px 0;
            background-color: #333;
            color: white;
            margin-top: 30px;
        }
    </style>
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
