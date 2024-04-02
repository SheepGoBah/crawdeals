<?php
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Point of Sale - CrawDeals</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        p {
            font-size: 18px;
            color: #666;
        }
    </style>    
</head>
<body>
    <div class="container">
        <?php
        echo "<h1>Point of Sale</h1>";
        // Database connection parameters and user role checking
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

        // Check user's role
        $username = $_SESSION['username']; // Fetch the username of the currently logged in user
        $sql = "SELECT isOwner, isEmployee, isManager, isAdmin FROM Users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();


        ?>
        <p>Additional content for the pos page...</p>
    </div>
</body>
</html>
