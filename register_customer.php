<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration - CrawDeals</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            text-align: center;
        }
        .container {
            width: 90%;
            max-width: 800px;
            padding: 40px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        h2 {
            font-size: 28px;
            color: #5c677d;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-top: 10px;
            color: #5c677d;
            font-size: 16px;
        }
        input[type="text"], input[type="submit"] {
            padding: 10px;
            width: 100%;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            background-color: #4a90e2;
            color: #ffffff;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #357abd;
        }
    </style>     
</head>
<body>
    <div class="container">
        <?php
        include 'header.php';
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
        echo "<form action='' method='post'>";
        echo "<label for='customer_name'>Customer Name:</label>";
        echo "<input type='text' id='customer_name' name='customer_name' required>";
        echo "<label for='customer_phone'>Customer Phone:</label>";
        echo "<input type='text' id='customer_phone' name='customer_phone' required>";
        echo "<label for='customer_city'>City:</label>";
        echo "<input type='text' id='customer_city' name='customer_city' required>";
        echo "<label for='customer_state'>State:</label>";
        echo "<input type='text' id='customer_state' name='customer_state' required>";
        echo "<label for='customer_street'>Street:</label>";
        echo "<input type='text' id='customer_street' name='customer_street' required>";
        echo "<label for='customer_postal'>Postal Code:</label>";
        echo "<input type='text' id='customer_postal' name='customer_postal' required>";
        echo "<br><br>";
        echo "<input type='submit' name='submit_new_customer' value='Register Customer'>";
        echo "</form>";
        echo "</div>";
        ?>
    </div>
</body>
</html>
