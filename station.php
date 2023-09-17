<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Add your CSS styles for the flowchart here */
        .flowchart {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin: 20px;
        }

        .station {
            width: 150px;
            height: 50px;
            background-color: #0074D9;
            color: #fff;
            text-align: center;
            line-height: 50px;
            border-radius: 5px;
            margin: 10px;
        }
    </style>
    <title>Station Flowchart</title>
</head>
<body>
    <div class="flowchart">
        <?php
            // Include your database connection code here
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "trains";

            $conn = mysqli_connect($servername, $username, $password, $database);

            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Fetch station names from the database
            $sql = "SELECT stationName FROM stations";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $stationName = $row['stationName'];
                    echo "<div class='station'>$stationName</div>";
                }
            } else {
                echo "No stations found in the database.";
            }

            mysqli_close($conn);
        ?>
    </div>
</body>
</html>