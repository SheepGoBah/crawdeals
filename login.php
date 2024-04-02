<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CrawDeals</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 24px;
            color: #333;
            margin-top: 0;
        }
        label {
            font-size: 18px;
            color: #666;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            font-size: 18px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .forgot-password {
            text-align: right;
            font-size: 14px;
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <?php
        // Database connection parameters
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

        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Check if username and password are provided
            if (!empty($_POST["username"]) && !empty($_POST["password"])) {
                // Sanitize user input
                $username = $_POST["username"];
                $password = $_POST["password"];

                // Prepare SQL statement to retrieve user data based on username
                $stmt = $conn->prepare("SELECT * FROM Users WHERE username = ?");
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();

                // Check if user exists
                if ($result->num_rows > 0) {
                    // Fetch user data
                    $row = $result->fetch_assoc();
                    $hashed_password = $row["password"];

                    // Verify password
                    if (password_verify($password, $hashed_password)) {
                        session_start();
                        // Assuming $username is set after successful login
                        $_SESSION['username'] = $username; // Store username in session
                        // Password is correct, redirect to point of sale or another page
                        header("Location: pos.php");
                        exit();
                    } else {
                        // Password is incorrect
                        echo "<p style='color: red;'>Invalid username or password. Please try again.</p>";
                    }
                } else {
                    // User does not exist
                    echo "<p style='color: red;'>Invalid username or password. Please try again.</p>";
                }

                // Close prepared statement
                $stmt->close();
            } else {
                // Username or password not provided
                echo "<p style='color: red;'>Please enter both username and password.</p>";
            }
        }
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>

            <input type="submit" value="Login">
        </form>
        <p class="forgot-password"><a href="forgot_password.php">Forgot password?</a></p>
    </div>
</body>
</html>
