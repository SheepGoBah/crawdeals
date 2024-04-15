<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Point of Sale - CrawDeals</title>
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
        p {
            font-size: 16px;
            color: #5c677d;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
        }
        input[type="submit"], input[type="button"], select {
            padding: 10px;
            margin-top: 10px;
            background-color: #4a90e2;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover, input[type="button"]:hover {
            background-color: #357abd;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php include 'header.php'; ?>
        <h2>Point of Sale</h2>
        <?php
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


        echo "<form action='' method='post'>";
        echo "Customer: ";
        echo "<select name='CustomerName'>";
        echo "<option value=''>Select Customer</option>";
        
        // Fetch items from inventory table
        $customerSQL = "SELECT Customer_ID, C_Name FROM customer";
        $customerResult = $conn->query($customerSQL);
        if ($customerResult->num_rows > 0) {
            while ($row = $customerResult->fetch_assoc()) {
                echo "<option value='" . $row['Customer_ID'] . "'>" . $row['C_Name'] . "</option>";
            }
        }
        echo "</select>";
        echo "<input type='submit' name='submit_select_item' value='Select'>";
        
        // Register New Customer button
        echo "<input type='submit' formaction='register_customer.php' formmethod='post' name='register_new_customer' value='Register New Customer'>";
        
        echo "</form>";
        ?>
        <?php
        // Process when a customer is selected
        if (isset($_POST['submit_select_item'])) {
            $customer_id = $_POST['CustomerName'];
            // Retrieve customer name from the database
            $customer_query = "SELECT C_Name FROM customer WHERE Customer_ID = $customer_id";
            $customer_result = $conn->query($customer_query);
            $customer_name = "";
            if ($customer_result->num_rows > 0) {
                $row = $customer_result->fetch_assoc();
                $customer_name = $row['C_Name'];
            }
        }
            ?>

            <?php
            // Display selected customer and order summary form
            if (isset($_POST['submit_select_item'])) {
                // Your PHP code to display selected customer and order summary form
                echo "<p>Customer: $customer_name</p>";
            ?>
                <form id="order-form">
                    <!-- Your HTML form elements for adding items -->
                    <label for='item'>Select Item:</label>
                    <select id='item' name='item'>
                        <?php
                        // Fetch items from inventory table
                        $inventory_query = "SELECT Product_ID, Product_Name, Unit_Price FROM inventory";
                        $inventory_result = $conn->query($inventory_query);
                        if ($inventory_result->num_rows > 0) {
                            while ($row = $inventory_result->fetch_assoc()) {
                                echo "<option value='" . $row['Product_ID'] . "' data-price='" . $row['Unit_Price'] . "'>" . $row['Product_Name'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                    <label for='quantity'>Quantity:</label>
                    <input type='number' id='quantity' name='quantity' value='1' min='1'>
                    <input type='button' id='add-item' value='Add'>
                </form>
                <table id="order-table">
                    <tr>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </table>
                <div id="total-amount-row" style="display: none;">
                    <p>Total Amount: <span id="total-amount">0.00</span></p>
                </div>
                <input type="button" id="confirm-order" value="Confirm Order">

            <?php
            }
            ?>

            <p>Additional content for the pos page...</p>
        </div>
    
        <script>
            // JavaScript to add rows to the order table
            document.addEventListener("DOMContentLoaded", function() {
                const orderForm = document.getElementById("order-form");
                const orderTable = document.getElementById("order-table");
                const addItemButton = document.getElementById("add-item");
                const confirmOrderButton = document.getElementById("confirm-order");
                const totalAmountRow = document.getElementById("total-amount-row");
                const totalAmountSpan = document.getElementById("total-amount");

                const amounts = [];

                // Function to update total amount
                function updateTotalAmount() {
                    let total = 0;
                    for (const amount of amounts) {
                        total += amount;
                    }
                    totalAmountSpan.textContent = total.toFixed(2);
                }

                addItemButton.addEventListener("click", function() {
                    const itemSelect = document.getElementById("item");
                    const quantityInput = document.getElementById("quantity");

                    // Retrieve selected item and quantity
                    const itemId = itemSelect.value;
                    const itemName = itemSelect.options[itemSelect.selectedIndex].text;
                    const quantity = quantityInput.value;

                    // Retrieve item price and calculate amount
                    const price = parseFloat(itemSelect.options[itemSelect.selectedIndex].dataset.price);
                    const amount = price * quantity;

                    // Create new row for the order table
                    const newRow = document.createElement("tr");
                    newRow.innerHTML = `
                        <td>${itemName}</td>
                        <td>${price}</td>
                        <td>${quantity}</td>
                        <td>${amount}</td>
                        <td><button type="button" class="remove-item">Remove</button></td>
                    `;

                    // Append new row to the order table
                    orderTable.appendChild(newRow);

                    // Add amount to the amounts array
                    amounts.push(amount);

                    // Update total amount
                    updateTotalAmount();

                    // Reset form inputs
                    itemSelect.selectedIndex = 0;
                    quantityInput.value = 1;

                    // Show total amount row
                    totalAmountRow.style.display = "block";
                });

                confirmOrderButton.addEventListener("click", function() {
                    // Here you should send the order details to the server for insertion into the database
                    // You can retrieve the order details from the order table
                });

                // JavaScript function to remove row from the order table
                orderTable.addEventListener("click", function(event) {
                    if (event.target.classList.contains("remove-item")) {
                        const row = event.target.closest("tr");
                        const index = Array.from(row.parentNode.children).indexOf(row);
                        const amount = parseFloat(row.cells[3].textContent);
                        amounts.splice(index, 1);
                        row.parentNode.removeChild(row);
                        // Update total amount
                        updateTotalAmount();
                        // Hide total amount row if there are no items
                        if (orderTable.rows.length === 1) {
                            totalAmountRow.style.display = "none";
                        }
                    }
                });
            });
        </script>

    </body>
    </html>