<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management - CrawDeals</title>
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
        h1, h2 {
            font-size: 28px;
            color: #5c677d;
        }
        p {
            font-size: 16px;
            color: #5c677d;
        }
        input[type="text"],
        input[type="number"],
        select,
        input[type="submit"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            font-size: 16px;
            background-color: #4a90e2;
            color: #ffffff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #357abd;
        }
        form {
            text-align: left;
            display: inline-block;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        echo "<h1>Inventory Management</h1>";
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
        $sql = "SELECT isOwner, isEmployee, isManager, isAdmin FROM Personnel WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($isOwner, $isEmployee, $isManager, $isAdmin);
            $stmt->fetch();
        
            if (($isOwner == 1) || ($isManager == 1) || ($isAdmin == 1)) {
                // Handle form submission to add item
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_add_item"])) {
                    // Retrieve form data
                    $product_name = $_POST["product_name"];
                    $quantity_available = $_POST["quantity_available"];
                    $unit_price = $_POST["unit_price"];
    
                    // Prepare SQL statement to insert data into the 'Inventory' table
                    $sql = "INSERT INTO Inventory (product_name, quantity_available, unit_price) VALUES (?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sid", $product_name, $quantity_available, $unit_price);
    
                    // Execute the prepared statement
                    if ($stmt->execute()) {
                        echo "<p>Item added to inventory successfully.</p>";
                    } else {
                        echo "<p>Error adding item to inventory: " . $stmt->error . "</p>";
                    }
                }
                
                // Display form to add an item to the inventory
                echo "<h2>Add Item to Inventory</h2>";
                echo "<form action='' method='post'>";
                echo "Product Name: <input type='text' name='product_name' required><br>";
                echo "Quantity Available: <input type='number' name='quantity_available' required><br>";
                echo "Unit Price: <input type='text' name='unit_price' required><br>";
                echo "<input type='submit' name='submit_add_item' value='Add Item'>";
                echo "</form>";
    
                // Display form to update quantity or unit price of an item
                echo "<h2>Update Inventory</h2>";
                echo "<form action='' method='post'>";
                echo "Item: ";
                echo "<select name='productID'>";
                echo "<option value=''>Select Item</option>";
                // Fetch items from inventory table
                $sql = "SELECT productID, product_name FROM Inventory";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['productID'] . "'>" . $row['product_name'] . "</option>";
                    }
                }
                echo "</select>";
                echo "<input type='submit' name='submit_select_item' value='Select'>";
                echo "</form>";

                // Process form submission to select an item and display its details
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_select_item"])) {
                    if (isset($_POST['productID']) && $_POST['productID'] !== '') {
                        $selected_productID = $_POST['productID'];
                        $sql = "SELECT product_name, quantity_available, unit_price FROM Inventory WHERE productID = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $selected_productID);
                        $stmt->execute();
                        $stmt->bind_result($product_name, $quantity_available, $unit_price);
                        $stmt->fetch();

                        // Display form to update quantity or unit price of the selected item
                        echo "<form action='' method='post'>";
                        echo "Product Name: <span>$product_name</span><br>";
                        echo "Current Quantity Available: <input type='number' name='quantity_available' value='$quantity_available'><br>";
                        echo "Current Unit Price: <input type='text' name='unit_price' value='$unit_price'><br>";
                        echo "<input type='hidden' name='productID' value='$selected_productID'>";
                        echo "<input type='submit' name='submit_update_item' value='Update'>";
                        echo "<input type='submit' name='submit_remove_item' value='Remove'>";
                        echo "</form>";
                    }
                }

                // Process form submission to update item
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_update_item"])) {
                    // Retrieve form data
                    $productID = $_POST["productID"];
                    $quantity_available = $_POST["quantity_available"];
                    $unit_price = $_POST["unit_price"];

                    // Prepare SQL statement to update data in the 'Inventory' table
                    $sql = "UPDATE Inventory SET quantity_available = ?, unit_price = ? WHERE productID = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("idi", $quantity_available, $unit_price, $productID);

                    // Execute the prepared statement
                    if ($stmt->execute()) {
                        echo "<p>Item updated successfully.</p>";
                    } else {
                        echo "<p>Error updating item: " . $stmt->error . "</p>";
                    }
                }

                // Process form submission to remove item
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_remove_item"])) {
                    // Retrieve form data
                    $productID = $_POST["productID"];

                    // Prepare SQL statement to delete data from the 'Inventory' table
                    $sql = "DELETE FROM Inventory WHERE productID = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $productID);

                    // Execute the prepared statement
                    if ($stmt->execute()) {
                        echo "<p>Item removed successfully.</p>";
                    } else {
                        echo "<p>Error removing item: " . $stmt->error . "</p>";
                    }
                }
            } else {
                echo "<p>Error, you are missing the required permissions to view this page!</p>";
            }
        } else {
            echo "<p>User not found.</p>";
        }
        
        $stmt->close();
        $conn->close();
        ?>
        <p>Additional content for the inventory page...</p>
    </div>
</body>
</html>
