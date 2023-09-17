<?php
session_start();
$_SESSION['logged_in'] = false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styling/style.css">
    <link rel="stylesheet" href="styling/login.css">
    <link rel="stylesheet" href="styling/details_page.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        body {
            background-image: url("photos/train2.jpg");
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
    <title>Ticket</title>
</head>
<body>
    <?php
        $starting_station = isset($_GET['starting_station']) ? $_GET['starting_station'] : '';
        $destination_station = isset($_GET['destination_station']) ? $_GET['destination_station'] : '';
        $date = isset($_GET['date']) ? $_GET['date'] : '';
        $trainIndex = isset($_GET['trainIndex']) ? $_GET['trainIndex'] : '';
        date_default_timezone_set('Asia/Kolkata');
        $current_time = date("H:i:s");
    ?>
    <header>
        <h1>Bharatiya Railways</h1>
        <nav>
            <ul class="navigation">
                <li><img src="photos/logo-less.png" alt="train" class="logo"></li>
                <span class="menu">
                    <li><a href="index.html">Home</a></li>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                    <li><a href="station.php">Stations</a></li>
                    <li><button class="btnLogin-popup">Admin</button></li>
                </span>
            </ul>
        </nav>
    </header>

    <div class="wrapper">        
        <form action="back.php" method="POST">
        <h2>User Details</h2>
        <div class="input-box">
            <input type="text" name="name" id="name" placeholder="Enter your Name" required>
            <i class="bx bx-user-circle"></i>
        </div>
        
        <div class="input-box">
            <input type="email" name="email" id="email" placeholder="Enter your Email" required>
            <i class="bx bxs-envelope"></i>                
        </div>
        <div class="input-box">
            <input type="tel" name="phone" id="phone" placeholder="Enter your Phone Number" required>
            <i class="bx bx-phone"></i>
        </div>
        <div class="input-box ">
            <label for="no_of_tickets">Tickets : </label>
            <div class="select-box ">
                <select name="ticket" id="ticket" required>
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>  
        </div>
        <div class="input-box ">
            <label for="payment">Payment : </label>
            <div class="select-box ">
                <select name="payment" id="payment" required>
                    <option value="none">none</option>
                    <option value="Cash">Cash</option>
                    <option value="UPI">UPI</option>
                    <option value="Credit Card">Credit Card</option>
                    <option value="Debit Card">Debit Card</option>
                    <option value="Net Banking">Net Banking</option>
                </select> 
            </div>          
        </div>
        <input type="hidden" name="starting_station" value="<?php echo $starting_station; ?>">
        <input type="hidden" name="destination_station" value="<?php echo $destination_station; ?>">
        <input type="hidden" name="date" value="<?php echo $date; ?>">
        <input type="hidden" name="time" value="<?php echo $current_time; ?>">
        <input type="hidden" name="trainIndex" value="<?php echo $trainIndex; ?>">
        <input type="submit" name="submit" value="Book Ticket" class="submit-butt">
        </form>
    </div>

    
</body>
</html>