<?php
session_start();
$_SESSION['logged_in'] = false;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styling/login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        body {
            background-image: url("photos/train2.jpg");
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
    <title>Login Page</title>
</head>
<body>
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
        <form action="login.php" method="POST">
            <h2>Login</h2>
            <div class="input-box">
                <input type="text" name="username" id="username" placeholder="Enter your username" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" id="password" placeholder="Enter your password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <div class="remember-forgot">
                <label><input type="checkbox">Remember Me</label>
                <a href="forgot_password.html">Forgot Password ?</a>
            </div>
            <button type="submit" class="btn">Login</button>

            <div class="register-link">
                <p>Don't have an account ?<a href="register.php">Register Now</a></p>
            </div>
            <div class="register-link">
                <p>Or <a href="index.html">Login as Guest</a></p>
            </div>
        </form>
    </div>
    <?php
        
        if (isset($_POST['username'], $_POST['password'])) {
            $db_username = "root";
            $db_password = "";

            $input_username = $_POST['username'];
            $input_password = $_POST['password'];

            $servername = "localhost";
            $database = "trains"; // Replace with your actual database name

            // Create connection
            $conn = mysqli_connect($servername, $db_username, $db_password, $database);

            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // SQL query with prepared statement
            $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
            $stmt = mysqli_prepare($conn, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ss", $input_username, $input_password);
                mysqli_stmt_execute($stmt);

                $result = mysqli_stmt_get_result($stmt);

                // After successful login, fetch user details and store them in the session
                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $_SESSION['logged_in'] = true;
                    $_SESSION['user_details'] = array(
                        'name' => $row['name'],
                        'email' => $row['email'],
                        'phone_no' => $row['phone_no']
                    );

                    echo "<script>window.location.href='index.html'</script>";
                } else {
                    echo "<script>alert('Login Failed')</script>";
                    echo "<script>window.location.href='login.php'</script>";
                }


                mysqli_stmt_close($stmt);
            } else {
                // Handle query errors
                echo "Error: " . mysqli_error($conn);
            }

            mysqli_close($conn);
        } else {
            // Handle case where username and password are not set
            //echo "Please provide both username and password.";
        }
        ?>

</body>
</html>