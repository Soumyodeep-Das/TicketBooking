<?php
$starting_station = isset($_GET['starting_station']) ? $_GET['starting_station'] : '';
$destination_station = isset($_GET['destination_station']) ? $_GET['destination_station'] : '';
$date = isset($_GET['date']) ? $_GET['date'] : '';

$starting_station=preg_replace('/\s+/', '', $starting_station);
$destination_station=preg_replace('/\s+/', '', $destination_station);

date_default_timezone_set('Asia/Kolkata');
$current_time = date("H:i:s");
$current_date = date("Y-m-d");

echo "<link rel='stylesheet' href='styling/book_train.css'>";
echo '<style>
body {
    background-image: url("photos/train2.jpg");
    background-repeat: no-repeat;
    background-size: cover;
}
</style>';


$servername = "localhost";
$username = "root";
$password = "";
$database = "trains"; 

// Create connection
$conn = mysqli_connect($servername, $username, $password);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Select the database
mysqli_select_db($conn, $database);

// Sanitize and escape user inputs to prevent SQL injection
$starting_station = mysqli_real_escape_string($conn, $starting_station);
$destination_station = mysqli_real_escape_string($conn, $destination_station);
$current_time = mysqli_real_escape_string($conn, $current_time);

if($date==$current_date)
{
    $sql = "SELECT *
    FROM $starting_station AS start
    INNER JOIN $destination_station AS dest ON start.trainIndex = dest.trainIndex
    WHERE TIME(start.trainTime) > '$current_time' AND TIME(dest.trainTime) > '$current_time'
    ORDER BY start.trainTime ASC";
}
else
{
    $sql = "SELECT *
    FROM $starting_station AS start
    INNER JOIN $destination_station AS dest ON start.trainIndex = dest.trainIndex
    ORDER BY start.trainTime ASC";
}

        // Execute the query
$result = mysqli_query($conn, $sql);


echo "<div>
    <h1>Bharatiya Railways</h1>        
    <h3>Departing from " . strtoupper($starting_station) . " Arriving at " . strtoupper($destination_station) . "</h3>
    <h3>On " . $date . " at " . $current_time . "</h3>
</div>";



if ($result) {
    // Check if there are any results
    if (mysqli_num_rows($result) > 0) {
        echo "<table border='1' class='frame'>";
        echo "<tr><th>ID</th><th>Train Time</th><th>Train Status</th></tr>"; // Replace with actual column names

        // Iterate through the rows and print data in table rows
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['trainIndex'] . "</td>"; 
            
            echo "<td>" . $row['trainTime'] . "</td>"; 
            
            echo "<td>" . $row['trainType'] . "</td>"; 

            session_start(); // Start the session

            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
                // User is logged in, redirect to logged_in_user_details.php
                echo "<td><button class='button button1' onclick=\"window.location.href='logged_in_user_details.php?starting_station=" . urlencode(strtolower($_GET['starting_station'])) . "&destination_station=" . urlencode(strtolower($_GET['destination_station'])) . "&date=" . urlencode($_GET['date']) . "&trainIndex=" . urlencode($row['trainIndex']) . "';\">Book Train</button></td>";
            } else {
                // User is not logged in, redirect to details_page.php
                echo "<td><button class='button button1' onclick=\"window.location.href='details_page.php?starting_station=" . urlencode(strtolower($_GET['starting_station'])) . "&destination_station=" . urlencode(strtolower($_GET['destination_station'])) . "&date=" . urlencode($_GET['date']) . "&trainIndex=" . urlencode($row['trainIndex']) . "';\">Book Train</button></td>";
            }           
            echo "</tr>";
        }        
        echo "</table>";
    } else {
        echo "<div class='error'>No Trains are Available to Book currently</div>";
    }
} else {
    // Handle query errors
    echo "Error: " . mysqli_error($conn);
}



mysqli_close($conn);
//Connection closed";

?>