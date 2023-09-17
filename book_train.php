<?php
$starting_station = isset($_GET['starting_station']) ? $_GET['starting_station'] : '';
$destination_station = isset($_GET['destination_station']) ? $_GET['destination_station'] : '';
$date = isset($_GET['date']) ? $_GET['date'] : '';

$starting_station=preg_replace('/\s+/', '', $starting_station);
$destination_station=preg_replace('/\s+/', '', $destination_station);

date_default_timezone_set('Asia/Kolkata');
$current_time = date("H:i:s");
$current_date = date("Y-m-d");

echo "
<style>
body {
    min-height: 100vh;
    background: url(train2.jpg) no-repeat bottom fixed;
    background-size: cover; /* Ensure the background image covers the entire viewport */
    margin: 0;
    padding: 0;
    font-family: Arial, Helvetica, sans-serif;
}

header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    padding: 20px 100px;
    justify-content: space-between;
    align-items: center;
    transition: 0.6s;
    z-index: 99;
    font-family: 'Times New Roman, Times, serif;
    
}

.frame {
    margin: 0 auto;
    width: 80%;
    padding: 1em;
    border: 2px solid rgb(197, 159, 76);
    border-radius: 1em;
    background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white background */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Add a subtle box shadow */
    font-size: 22.5px;
    text-align: center;
}

.button {
    border: none;
    color: white;
    padding: 16px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    transition-duration: 0.4s;
    cursor: pointer;
    margin-left: 10%;
    width: 80%;
    background-color: #4CAF50; /* Default button background color */
}

.button1 {
    background-color: white;
    color: black;
    border: 2px solid #4CAF50;
}

.button1:hover {
    background-color: #4CAF50;
    color: white;
}

h3 , h1{
    text-align: center;
    padding: 10px;
    background: transparent;
    font-size: 30px;
    color: black;
    margin: 0 auto;
    width: 80%;
    border-radius: 1em;
    // border-bottom: 0.5px solid #fff;
    // box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Add a subtle shadow to the header */
}

.error {
    text-align: center;
    padding: 1em;
    background: transparent;
    font-size: 30px;
    color: #e03a3a;
    margin: 0 auto;
    width: 80%;
    border-radius: 1em;
    border: 1.5px solid red;
}
</style>
";


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
// echo "<br>Connected successfully";

// Select the database
mysqli_select_db($conn, $database);

// Sanitize and escape user inputs to prevent SQL injection
$starting_station = mysqli_real_escape_string($conn, $starting_station);
$destination_station = mysqli_real_escape_string($conn, $destination_station);
$current_time = mysqli_real_escape_string($conn, $current_time);
// Construct the SQL query with JOIN
// $sql = "SELECT *
//         FROM $starting_station AS start
//         INNER JOIN $destination_station AS dest ON start.trainIndex = dest.trainIndex AND start.trainTime>time($current_time) AND dest.trainTime>time($current_time) ORDER BY start.trainTime ASC" ;

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

// $sql = "SELECT *
//         FROM $starting_station AS start
//         INNER JOIN $destination_station AS dest ON start.trainIndex = dest.trainIndex
//         WHERE TIME(start.trainTime) > '$current_time' AND TIME(dest.trainTime) > '$current_time'
//         ORDER BY start.trainTime ASC";


        // Execute the query
$result = mysqli_query($conn, $sql);

// echo "<br>Result: <br>";

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

            // echo "<td><button class='button button1' onclick='window.location.href=\"logged_in_user_details.php\"'>Book</button></td>";

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
// echo "<br>Connection closed";

?>