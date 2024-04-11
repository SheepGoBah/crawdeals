<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - CrawDeals</title>
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
        <h1>Create Account</h1>
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

        // Function to sanitize user input
        function sanitize_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        // Initialize variables to store form data
        $username = $password = $confirm_password = $security_question1 = $security_question2 = $security_question3 = "";

        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Sanitize and store form data
            $username = sanitize_input($_POST["username"]);
            $password = $_POST["password"];
            $confirm_password = $_POST["confirm_password"];
            $security_question1 = sanitize_input($_POST["security_question1"]);
            $security_question2 = sanitize_input($_POST["security_question2"]);
            $security_question3 = sanitize_input($_POST["security_question3"]);

            // Check if all fields are provided
            if (!empty($username) && !empty($password) && !empty($confirm_password) && !empty($security_question1) && !empty($security_question2) && !empty($security_question3)) {
                // Check if password matches confirm password
                if ($password !== $confirm_password) {
                    $error_message = "Password and confirm password do not match.";
                } else {
                    // Check if username already exists in the database
                    $sql = "SELECT * FROM Personnel WHERE username = '$username'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $error_message = "Username already exists. Please choose a different username.";
                    } else {
                        // Hash the password
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                        // Insert user data into the database
                        $sql = "INSERT INTO Personnel (username, password, security_question1, security_question2, security_question3) VALUES ('$username', '$hashed_password', '$security_question1', '$security_question2', '$security_question3')";
                        if ($conn->query($sql) === TRUE) {
                            // Redirect user to login page after successful registration
                            header("Location: login.php");
                            exit();
                        } else {
                            $error_message = "Error: " . $sql . "<br>" . $conn->error;
                        }
                    }
                }
            } else {
                $error_message = "Please fill out all fields.";
            }
        }
        ?>
        <?php if (isset($error_message)) { echo "<p style='color: red;'>$error_message</p>"; } ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $username; ?>" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required><br>

            <label for="security_question1">What is your favorite color?</label>
            <input type="text" id="security_question1" name="security_question1" required><br>

            <label for="security_question2">What city did you go to high school at?</label>
            <input type="text" id="security_question2" name="security_question2" required><br>

            <label for="security_question3">What brand was your first car?</label>
            <input type="text" id="security_question3" name="security_question3" required><br>

            <input type="submit" value="Create Account">
        </form>
    </div>
</body>
</html>
