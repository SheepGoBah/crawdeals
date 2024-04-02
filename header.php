<?php
// Start or resume session
if (!isset($_SESSION)) {
    session_start();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // Replace with your actual password
$dbname = "ims_project"; // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve user role based on username from session
if(isset($_SESSION['username'])) {
    $loggedInUsername = $_SESSION['username'];

    // Query to fetch user data from the database
    $sql = "SELECT isOwner, isManager, isEmployee, isAdmin FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $loggedInUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch user data
    $userData = $result->fetch_assoc();

    // Close statement
    $stmt->close();

    // Check user's role
    $isOwner = $userData['isOwner'] === 1;
    $isManager = $userData['isManager'] === 1;
    $isEmployee = $userData['isEmployee'] === 1;
    $isAdmin = $userData['isAdmin'] === 1;
}
else {
    // Redirect to login page if session username is not set
    header("Location: login.php");
    exit();
}

if (isset($_SESSION['last_activity'])) {
    // Set the session expiration time (e.g., 30 minutes)
    $session_expiration_time = 30 * 60; // 30 minutes in seconds

    // Calculate the time difference between current time and last activity time
    $time_since_last_activity = time() - $_SESSION['last_activity'];

    // If the time difference exceeds the session expiration time, destroy the session and log the user out
    if ($time_since_last_activity > $session_expiration_time) {
        session_unset();    // Unset all session variables
        session_destroy();  // Destroy the session
        header("Location: login.php");  // Redirect to login page
        exit();
    }
}
$_SESSION['last_activity'] = time();
?>

<!DOCTYPE html>
<html>
<head>
    <title>CrawDeals</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
        }
        h1 {
            font-size: 34px;
            color: #333;
            margin-top: 0;
        }
        #app-name {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }
        #app-name h1 {
            margin: 0;
            padding: 0;
            color: #ff9900; /* Unique color for the application name */
        }
        nav {
            background-color: #333;
            padding: 10px 0;
        }
        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        nav ul li {
            display: inline;
            margin-right: 20px;
        }
        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
        }
        nav ul li a:hover {
            color: #ccc;
        }
    </style>
</head>
<body>

<div id="app-name">
    <h1>CrawDeals</h1>
</div>

<nav>
    <ul>
        <li><a href="pos.php">Point of Sale</a></li>
        <?php if ($isOwner || $isManager) { ?>
            <li><a href="management.php">Manage Users</a></li>
            <li><a href="inventory.php">Manage Inventory</a></li>
        <?php } ?>
        <?php if ($isOwner || $isAdmin) { ?>
            <li><a href="reports.php">Sales Reports</a></li>
        <?php } ?>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>

</body>
</html>
