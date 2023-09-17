<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="register.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Register Page</title>
</head>
<body>
    <header>
        <h1>Bharatiya Railways</h1>
        <nav>
            <ul class="navigation">
                <li><img src="logo-less.png" alt="train" class="logo"></li>
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
        <form action="register.php" method="POST">
            <h2>Register</h2>
            <div class="input-box">
                <input type="text" name="name" id="name" placeholder="Enter your Name" required>
                <i class='bx bx-user-circle'></i>
            </div>
            <div class="input-box">
                <input type="text" name="username" id="username" placeholder="Enter your username" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="email" name="email" id="email" placeholder="Enter your Email" required>
                <i class='bx bxs-envelope'></i>                
            </div>
            <div class="input-box">
                <input type="tel" name="phone" id="phone" placeholder="Enter your Phone Number" required>
                <i class='bx bx-phone'></i>
            <div class="input-box">
                <input type="password" name="password" id="password" placeholder="Enter your password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <div class="input-box">
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm your password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <button type="submit" class="btn">Register</button>
            <div class="register-link">
                <p>Or <a href="index.html">Login as Guest</a></p>
            </div>            
        </form>
    </div>
    <?php
if (isset($_POST['name'], $_POST['username'], $_POST['email'], $_POST['phone'], $_POST['password'])) {
    $db_username = "root";
    $db_password = "";

    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    $servername = "localhost";
    $database = "trains"; // Replace with your actual database name

    // Create connection
    $conn = mysqli_connect($servername, $db_username, $db_password, $database);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // SQL query with prepared statement
    $sql = "INSERT INTO users (name, username, email, phone_no, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssss", $name, $username, $email, $phone, $password);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo "<script>alert('Registration Successful')</script>";
            echo "<script>window.location.href='login.php'</script>";
        } else {
            echo "<script>alert('Registration Failed')</script>";
            echo "<script>window.location.href='register.php'</script>";
        }

        mysqli_stmt_close($stmt);
    } else {
        // Handle query errors
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    // Handle case where required fields are not set
    //echo "Please fill in all required fields.";
}
?>

</body>
</html>