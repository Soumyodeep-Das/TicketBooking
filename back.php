<?php
session_start(); // Start the session
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    $user_details = $_SESSION['user_details'];
    $name = $user_details['name'];
    $email = $user_details['email'];
    $phone = $user_details['phone_no'];
} else {
    echo $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
}

$ticket = $_POST['ticket'];
$payment = $_POST['payment'];

$starting_station = isset($_POST['starting_station']) ? $_POST['starting_station'] : '';
$destination_station = isset($_POST['destination_station']) ? $_POST['destination_station'] : '';
$date = isset($_POST['date']) ? $_POST['date'] : '';
$trainIndex = isset($_POST['trainIndex']) ? $_POST['trainIndex'] : '';
$time = isset($_POST['time']) ? $_POST['time'] : '';

$starting_station=preg_replace('/\s+/', '', $starting_station);
$destination_station=preg_replace('/\s+/', '', $destination_station);

date_default_timezone_set('Asia/Kolkata');
$current_time = date("H:i:s");

// echo $name . "<br>" . $email . "<br>" . $phone . "<br>" . $ticket . "<br>" . $payment . "<br>" . $starting_station . "<br>" . $destination_station . "<br>" . $id . "<br>" . $trainIndex . "<br>" . $boarding_time . "<br>" . $arrival_time . "<br>" . $time . "<br>" . $current_time . "<br>";


$servername = "localhost";
$username = "root";
$password = "";
$database = "trains"; // Replace with actual database name

// Create connection
$conn = mysqli_connect($servername, $username, $password);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// echo "<br>Connected successfully";

// Select the database
mysqli_select_db($conn, $database);

// Sanitize and escape user inputs to prevent SQL injection
$starting_station = mysqli_real_escape_string($conn, $starting_station);
$destination_station = mysqli_real_escape_string($conn, $destination_station);

// Construct the SQL query with JOIN

$sql ="SELECT id FROM userdetails ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$id = $row['id'];
$id = (int)$id+1;

$sql_train = "SELECT trainTime FROM $starting_station WHERE trainIndex = '$trainIndex'";
$result_train = mysqli_query($conn, $sql_train);
$row_train = mysqli_fetch_assoc($result_train);
$boarding_time = $row_train['trainTime'];

$sql_train = "SELECT trainTime FROM $destination_station WHERE trainIndex = '$trainIndex'";
$result_train = mysqli_query($conn, $sql_train);
$row_train = mysqli_fetch_assoc($result_train);
$arrival_time = $row_train['trainTime'];


$sql = "INSERT INTO `userdetails` (`name`, `email`, `phone_no`, `no_of_tickets`, `payment_method`, `starting_train`, `destination_train`, `id`, `train_id`, `boarding_time`, `arrival_time`, `booking_time`) VALUES ('$name', '$email', '$phone', '$ticket', '$payment', '$starting_station', '$destination_station', '$id', '$trainIndex', '$boarding_time', '$arrival_time', '$time')" ;

// Execute the query

$result = mysqli_query($conn, $sql);

mysqli_close($conn);
// echo "<br>Connection closed";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styling/back.css">
    <title>ERS</title>
</head>
<body>
    <table>
        <tr>
            <th colspan="2" class="heading">Electronic Reservation Slip (ERS)</th>
        </tr>
        <tr>
            <td><strong>Boarding From:</strong></td>
            <td><strong>Arriving To:</strong></td>
        </tr>
        <tr>
            <td><?php echo strtoupper($starting_station); ?></td>
            <td><?php echo strtoupper($destination_station); ?></td>
        </tr>
        <tr>
            <td><strong>Boarding Time:</strong></td>
            <td><strong>Arriving Time:</strong></td>
        </tr>
        <tr>
            <td><?php echo $boarding_time; ?></td>
            <td><?php echo $arrival_time; ?></td>
        </tr>
    </table>
    <hr>
    <table>
        <tr>
            <th colspan="6" class="heading">Payment Details</th>
        </tr>
        <tr>
            <td><strong>Payment Method:</strong></td>
            <td><?php echo $payment; ?></td>
            <td><strong>Status:</strong></td>
            <td>Done</td>
            <td><strong>Booking Time:</strong></td>
            <td><?php echo $time;?></td>
        </tr>
    </table>
    <hr>
    <table>
        <tr>
            <th colspan="5" class="heading">Passenger Details</th>
        </tr>
        <tr>
            <td><strong>Name:</strong></td>
            <td><strong>Email:</strong></td>
            <td><strong>Phone NO:</strong></td>
            <td><strong>No of Ticket:</strong></td>
            <td><strong>Status:</strong></td>
        </tr>
        <tr>
            <td><?php echo $name; ?></td>
            <td><?php echo $email; ?></td>
            <td><?php echo $phone; ?></td>
            <td><?php echo $ticket; ?></td>
            <td>Confirmed</td>
        </tr>
    </table>
    <hr>

    <button class="butt" onclick="window.location.href='download_pdf.php'">Print Ticket</button>
    
</body>
</html>