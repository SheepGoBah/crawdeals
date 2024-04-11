<?php
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration - CrawDeals</title>
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
        h2{
            text-align: center;
        }
        label {
            display: inline-block;
            width: 150px; /* Set the width to 100 pixels */
        }
    </style>     
</head>
<body>
    <div class="container">
        <?php
        echo "<h2>Register New Customer</h2>";
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

        // If the form is submitted to add a new customer
        if (isset($_POST['submit_new_customer'])) {
            $customer_name = $_POST['customer_name'];
            $customer_phone = $_POST['customer_phone'];
            $customer_city = $_POST['customer_city'];
            $customer_state = $_POST['customer_state'];
            $customer_street = $_POST['customer_street'];
            $customer_postal = $_POST['customer_postal'];

            // Insert new customer into the database
            $insert_sql = "INSERT INTO customer (C_Name, C_Phone, C_City, C_State, C_Street, C_Postal) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insert_sql);
            $stmt->bind_param("ssssss", $customer_name, $customer_phone, $customer_city, $customer_state, $customer_street, $customer_postal);

            if ($stmt->execute()) {
                echo "<p>New customer registered successfully.</p>";
                echo "<script>setTimeout(function(){ window.location.href = 'pos.php'; }, 1000);</script>";
            } else {
                echo "<p>Error registering new customer: " . $conn->error . "</p>";
            }
        }

        // Display form to register a new customer
        echo "<div>";
        echo "<form action='' method='post'>";
        echo "<label for='customer_name'>Customer Name:</label>";
        echo "<input type='text' name='customer_name' required><br>";
        echo "<label for='customer_phone'>Customer Phone:</label>";
        echo "<input type='text' name='customer_phone' required><br>";
        echo "<label for='customer_city'>City:</label>";
        echo "<input type='text' name='customer_city' required><br>";
        echo "<label for='customer_state'>State:</label>";
        echo "<input type='text' name='customer_state' required><br>";
        echo "<label for='customer_street'>Street:</label>";
        echo "<input type='text' name='customer_street' required><br>";
        echo "<label for='customer_postal'>Postal Code:</label>";
        echo "<input type='text' name='customer_postal' required><br><br>";
        echo "<input type='submit' name='submit_new_customer' value='Register Customer'>";
        echo "</form>";
        echo "</div>";





        // Check user's role
        $username = $_SESSION['username']; // Fetch the username of the currently logged in user
        $sql = "SELECT isOwner, isEmployee, isManager, isAdmin FROM Personnel WHERE Username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();


        ?>
    </div>
</body>
</html>
