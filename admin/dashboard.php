<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Resetting some default styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-image: url('../images/travel_HD.png');
            background-size: cover;
            
        }
        .navbar {
            background-color: #555;
            padding: 10px 15px;
        }

        .navbar-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-logo {
            color: #fff;
            font-size: 24px;
            font-weight: bold;
            text-decoration: none;
        }

        .navbar-links {
            list-style-type: none;
            display: flex;
        }

        .navbar-links li {
            margin-left: 20px;
        }

        .navbar-links a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            padding: 8px 16px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .navbar-links a:hover {
            background-color: #ddd;
            color: black;
        }

        .navbar-links li:hover {
            background-color: #555;
        }

        @media (max-width: 768px) {
            .navbar-container {
                flex-direction: column;
                text-align: center;
            }

            .navbar-links {
                flex-direction: column;
                margin-top: 10px;
            }

            .navbar-links li {
                margin: 10px 0;
            }
        }
        h1 {
            font-size: 36px;
            font-family: Arial, sans-serif;
            color: #333333;
            text-align: center;
            margin-top: 280px;
            margin-bottom: 20px;
            text-transform: uppercase;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3); /* Horizontal, Vertical, Blur, Color */
        }


    </style>
    <title>Navbar</title>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="/" class="navbar-logo">#</a>
            <ul class="navbar-links">
                <li><a href="/admin/add_tour.php">Add tour</a></li>
                <li><a href="/admin/all_registrations.php">All registrations</a></li>
                <li><a href="/admin/all_tours.php">All tour</a></li>
                <li><a href="/">Home</a></li>
            </ul>
        </div>
    </nav>
    <h1>Sahara tour and travels</h1>
</body>
</html>
