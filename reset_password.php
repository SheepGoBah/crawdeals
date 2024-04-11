<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - CrawDeals</title>
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Reset Password</h1>
        <?php
        // Database connection parameters and password update logic
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

        // Check if username and token are provided in the URL
        if (isset($_GET['username']) && isset($_GET['token'])) {
            $username = $_GET['username'];
            $token = $_GET['token'];

            // Verify the token against the database
            $stmt = $conn->prepare("SELECT reset_token FROM Personnel WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($stored_token);
                $stmt->fetch();

                if ($token === $stored_token) {
                    // Token is valid, allow the user to reset the password
                    // Check if form is submitted
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        // Check if passwords match
                        if ($_POST["new_password"] === $_POST["confirm_password"]) {
                            // Hash the new password
                            $hashed_password = password_hash($_POST["new_password"], PASSWORD_DEFAULT);
                            // Update the password in the database
                            $sql = "UPDATE Personnel SET Password = ? WHERE username = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("ss", $hashed_password, $username);
                            if ($stmt->execute()) {
                                echo "<p style='color: green;'>Password updated successfully. You will be redirected to the login page shortly.</p>";
                                // JavaScript to redirect to login page after a delay
                                echo "<script>setTimeout(function(){ window.location.href = 'login.php'; }, 3000);</script>";
                            } else {
                                echo "<p style='color: red;'>Error updating password.</p>";
                            }
                        } else {
                            echo "<p style='color: red;'>Passwords do not match. Please try again.</p>";
                        }
                    }
                    ?>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?username=' . $_GET["username"] . '&token=' . $_GET["token"]; ?>" method="post">
                        <label for="new_password">New Password:</label>
                        <input type="password" id="new_password" name="new_password" required><br>

                        <label for="confirm_password">Confirm Password:</label>
                        <input type="password" id="confirm_password" name="confirm_password" required><br>

                        <input type="submit" value="Reset Password">
                    </form>
                    <?php
                } else {
                    echo "Invalid token.";
                }
            } else {
                echo "User not found.";
            }

            $stmt->close();
        } else {
            // If username or token is missing, deny access
            echo "Invalid request.";
        }
        ?>
    </div>
</body>
</html>