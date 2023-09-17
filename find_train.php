<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $starting_station = strtolower($_POST['starting_station']);
    $destination_station = strtolower($_POST['destination_station']);
    $date = $_POST['date'];
    echo "<link rel='stylesheet' href='styling/find_train.css'>";
    
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
    // echo "Connected successfully";

    // Select the database
    mysqli_select_db($conn, $database);

    // SQL query
    $sql = "SELECT * FROM stations WHERE stationName LIKE '%$starting_station%' OR stationName LIKE '%$destination_station%'";
    $result = mysqli_query($conn, $sql);

    // echo "<br>Result: <br>";

    $count=0;

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                // echo "stationIndex: " . $row["stationIndex"] . " - stationName: " . $row["stationName"] . "<br>";
                $count++;
            }
        } else {
            echo "0 results";
        }
        if($count==2){
            $availability = "Train is <span id='available'>available</span> <br>between <br>". strtoupper($starting_station)." and ". strtoupper($destination_station)."<br>on $date";
        } else {
            $availability = "Train is <span id='notavailable'>not available</span> <br>between <br>". strtoupper($starting_station)." and ". strtoupper($destination_station)." <br>on $date";
        }
    } else {
        // Handle query errors
        echo "Error: " . mysqli_error($conn);
    }

    echo "<table class='frame'> 
            <tr> <th>Starting Station</th> <th>Destination Station</th> <th>Date</th> <th>Availability</th></tr>
            <tr>
            <td>". strtoupper($starting_station)."</td>
            <td>". strtoupper($destination_station)."</td>
            <td>$date</td>
            <td>$availability</td>
            </tr>
        </table>";
    
    if($count==2){
        echo "<br><br><button class='button button1' onclick=\"window.location.href='book_train.php?starting_station=' + encodeURIComponent('" . strtolower($_POST['starting_station']) . "') + '&destination_station=' + encodeURIComponent('" . strtolower($_POST['destination_station']) . "') + '&date=' + encodeURIComponent('" . $_POST['date'] . "')\">Book Train</button>";

    }
    else {
        echo "<br><br><button class='button button2' onclick='window.location.href=\"index.html\"'>Back</button>";
    }

    mysqli_close($conn);
    // echo "<br>Connection closed";

    // Redirect to book_train.php
//     header("Location: book_train.php");
//     exit;
}

?>
