<!DOCTYPE html>
<html>
<head>
    <title>CrawDeals - H-Craw Small Traders Inc.</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        #app-name {
            background-color: #ffffff;
            color: #5c677d;
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid #e1e1e1;
        }
        #app-name h1 {
            font-size: 28px;
            margin: 0;
            padding: 0;
        }
        nav {
            background-color: #ffffff;
            padding: 10px 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        nav ul li {
            display: inline;
            margin-right: 20px;
        }
        nav ul li a {
            font-size: 16px;
            color: #4a90e2;
            text-decoration: none;
        }
        nav ul li a:hover {
            color: #357abd;
        }
    </style>
</head>
<body>

<div id="app-name">
    <img src="crawfish.png" alt="CrawDeals Logo"> <!-- LOGO IMAGE -->
    <h1>Welcome to CrawDeals</h1>
</div>

<nav>
    <ul>
        <li><a href="pos.php">Point of Sale</a></li>
        <?php if ($isOwner || $isManager) { ?>
            <li><a href="management.php">Manage Personnel</a></li>
            <li><a href="inventory.php">Manage Inventory</a></li>
        <?php } ?>
        <?php if ($isOwner || $isAdmin) { ?>
            <li><a href="reports.php">Sales Reports</a></li>
        <?php } ?>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>

</body>
</html>
