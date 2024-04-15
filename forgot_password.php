<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - CrawDeals</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }
        .container {
            width: 90%;
            max-width: 400px;
            padding: 40px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 28px;
            color: #5c677d;
            margin-bottom: 20px;
        }
        label {
            font-size: 16px;
            color: #5c677d;
            display: block;
            text-align: left;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4a90e2;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #357abd;
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
                $stmt = $conn->prepare("SELECT * FROM Personnel WHERE username = ? AND security_question1 = ? AND security_question2 = ? AND security_question3 = ?");
                $stmt->bind_param("ssss", $username, $security_question1, $security_question2, $security_question3);
                $stmt->execute();
                $result = $stmt->get_result();

                // Check if user exists and security answers match
                if ($result->num_rows > 0) {
                    // Redirect to reset password page
                    $token = bin2hex(random_bytes(32));
                    $stmt = $conn->prepare("UPDATE Personnel SET reset_token = ? WHERE username = ?");
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
