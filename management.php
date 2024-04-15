<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - CrawDeals</title>
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
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #333;
            color: #fff;
        }
        form {
            display: inline;
        }
        h2 {
            font-size: 28px;
            color: #5c677d;
            text-align: center;
        }
        input[type="submit"], select {
            padding: 8px;
            margin-top: 5px;
            background-color: #4a90e2;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #357abd;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>
<h2>User Management System</h2>
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
    $sql = "SELECT isOwner, isManager FROM Personnel WHERE username = ?";
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
    
    // Redirect if user is neither owner nor manager
    if (!$isOwner && !$isManager) {
        header("Location: pos.php");
        exit();
    }
}
else {
    // Redirect to login page if session username is not set
    header("Location: login.php");
    exit();
}

// Update user role
if (isset($_POST['update_role'])) {
    $userId = $_POST['Personnel_id'];
    $newRole = $_POST['new_role'];

    // Update user role in the database
    $updateSql = "UPDATE Personnel SET isOwner = 0, isManager = 0, isEmployee = 0 WHERE Personnel_id = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("i", $userId);
    $updateStmt->execute();

    if ($newRole == 'Owner') {
        $updateSql = "UPDATE Personnel SET isOwner = 1 WHERE Personnel_id = ?";
    } elseif ($newRole == 'Manager') {
        $updateSql = "UPDATE Personnel SET isManager = 1 WHERE Personnel_id = ?";
    } elseif ($newRole == 'Employee') {
        $updateSql = "UPDATE Personnel SET isEmployee = 1 WHERE Personnel_id = ?";
    }
    
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("i", $userId);
    $updateStmt->execute();
    $updateStmt->close();
}
?>

<h2>User Management System</h2>

<?php
// Fetch all Personnel from the database
$Personnelsql = "SELECT Personnel_id, username, isOwner, isManager, isEmployee FROM Personnel";
$userResult = $conn->query($Personnelsql);

if ($userResult->num_rows > 0) {
    // Display table header
    echo "<table>";
    echo "<tr><th>ID</th><th>Username</th><th>Role</th><th>Action</th></tr>";

    // Display Personnel and their roles
    while($row = $userResult->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["Personnel_id"] . "</td>";
        echo "<td>" . $row["username"] . "</td>";
        echo "<td>";
        if ($row["isOwner"] == 1) {
            echo "Owner";
        } elseif ($row["isManager"] == 1) {
            echo "Manager";
        } elseif ($row["isEmployee"] == 1) {
            echo "Employee";
        } else {
            echo "Inactive";
        }
        echo "</td>";
        echo "<td>";
        
        // Display update role form for managers
        if ($isManager && $row["isOwner"] != 1) { // Check if the user is a manager and the role is not Owner
            echo "<form action='management.php' method='post'>";
            echo "<input type='hidden' name='Personnel_id' value='" . $row["Personnel_id"] . "'>";
            echo "<select name='new_role'>";
            echo "<option value='Inactive'>Inactive</option>";
            echo "<option value='Employee'>Employee</option>";
            echo "</select>";
            echo "<input type='submit' name='update_role' value='Update'>";
            echo "</form>";
        }

        // Display update role form for owners
        if ($isOwner) {
            echo "<form action='management.php' method='post'>";
            echo "<input type='hidden' name='Personnel_id' value='" . $row["Personnel_id"] . "'>";
            echo "<select name='new_role'>";
            echo "<option value='Inactive'>Inactive</option>";
            echo "<option value='Employee'>Employee</option>";
            echo "<option value='Manager'>Manager</option>";
            echo "<option value='Owner'>Owner</option>";
            echo "</select>";
            echo "<input type='submit' name='update_role' value='Update'>";
            echo "</form>";
        }
        
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No Personnel found.";
}
?>

</body>
</html>
