<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CrawDeals - H-Craw Small Traders Inc.</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f4f4f9; /* A light greyish-blue background */
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
            max-width: 450px;
            padding: 40px;
            background-color: #ffffff; /* Pure white background for contrast */
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .container:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15);
        }
        h1 {
            font-size: 28px;
            color: #5c677d; /* Soft dark gray-blue for headers */
            margin-bottom: 10px;
        }
        h2 {
            font-size: 20px;
            color: #5c677d;
            margin-top: 0;
            margin-bottom: 20px;
        }
        p {
            font-size: 16px;
            color: #5c677d;
            margin-bottom: 30px;
        }
        button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4a90e2; /* A vibrant blue for buttons */
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            margin-bottom: 10px;
        }
        button:hover {
            background-color: #357abd; /* A slightly darker shade of blue for hover */
            transform: translateY(-3px);
        }
        a {
            text-decoration: none;
            color: inherit;
            display: block;
        }
        a:hover {
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to CrawDeals</h1>
        <h2>H-Craw Small Traders Inc.</h2>
        <p>Select an option to get started</p>
        <a href="login.php"><button>Login</button></a>
        <a href="register.php"><button>Create Account</button></a>
    </div>
</body>
</html>
