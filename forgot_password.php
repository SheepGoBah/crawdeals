<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - CrawDeals</title>
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Forgot Password</h1>
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
            // Check if username and security answers are provided
            if (!empty($_POST["username"]) && !empty($_POST["security_question1"]) && !empty($_POST["security_question2"]) && !empty($_POST["security_question3"])) {
                // Sanitize user input
                $username = $_POST["username"];
                $security_question1 = $_POST["security_question1"];
                $security_question2 = $_POST["security_question2"];
                $security_question3 = $_POST["security_question3"];

                // Prepare SQL statement to retrieve user data based on username and security answers
                $stmt = $conn->prepare("SELECT * FROM Users WHERE username = ? AND security_question1 = ? AND security_question2 = ? AND security_question3 = ?");
                $stmt->bind_param("ssss", $username, $security_question1, $security_question2, $security_question3);
                $stmt->execute();
                $result = $stmt->get_result();

                // Check if user exists and security answers match
                if ($result->num_rows > 0) {
                    // Redirect to reset password page
                    $token = bin2hex(random_bytes(32));
                    $stmt = $conn->prepare("UPDATE Users SET reset_token = ? WHERE username = ?");
                    $stmt->bind_param("ss", $token, $username);
                    $stmt->execute();
                    $stmt->close();
                    header("Location: reset_password.php?username=$username&token=$token");
                    exit();
                } else {
                    // User or security answers do not match
                    echo "<p style='color: red;'>Invalid username or security answers. Please try again.</p>";
                }

                // Close prepared statement
                $stmt->close();
            } else {
                // Username or security answers not provided
                echo "<p style='color: red;'>Please enter both username and security answers.</p>";
            }
        }
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>

            <label for="security_question1">What is your favorite color?</label>
            <input type="text" id="security_question1" name="security_question1" required><br>

            <label for="security_question2">What city did you go to high school at?</label>
            <input type="text" id="security_question2" name="security_question2" required><br>

            <label for="security_question3">What brand was your first car?</label>
            <input type="text" id="security_question3" name="security_question3" required><br>

            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
