<?php

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

// Select the database
mysqli_select_db($conn, $database);

// SQL query to fetch data from the 'userdetails' table
$query=mysqli_query($conn,"select * from userdetails");

// While loop to fetch data
while($row=mysqli_fetch_array($query)){
    $name = $row['name'];
    $email = $row['email'];
    $phone = $row['phone_no'];
    $ticket = $row['no_of_tickets'];
    $payment = $row['payment_method'];
    $starting_station = strtoupper($row['starting_train']);
    $destination_station = strtoupper($row['destination_train']);
    $boarding_time = strtoupper($row['boarding_time']);
    $arrival_time = strtoupper($row['arrival_time']);
    $time = strtoupper($row['booking_time']);
}


mysqli_close($conn);

require('fpdf/fpdf.php');


// Create a PDF instance
$pdf = new FPDF();
$pdf->AddPage();

// Set font
$pdf->SetFont('Arial', 'B', 14);

// Title
$pdf->Cell(0, 10, 'Electronic Reservation Slip (ERS)', 0, 1, 'C');
$pdf->Ln(10); // Line break

// Create a table with centered text and improved alignment
$pdf->SetFillColor(173, 216, 230); // Light Blue
$pdf->SetTextColor(0); // Text color: Black
$pdf->SetDrawColor(0); // Border color: Black

// Section headers
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Boarding Information', 1, 1, 'C', true);
$pdf->Cell(95, 10, 'Boarding From:', 1, 0, 'C');
$pdf->Cell(95, 10, 'Arriving To:', 1, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(95, 10, $starting_station, 1, 0, 'C');
$pdf->Cell(95, 10, $destination_station, 1, 1, 'C');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(95, 10, 'Boarding Time:', 1, 0, 'C');
$pdf->Cell(95, 10, 'Arriving Time:', 1, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(95, 10, $boarding_time, 1, 0, 'C'); // Replace with actual time
$pdf->Cell(95, 10, $arrival_time, 1, 1, 'C');
$pdf->Ln(10); // Line break

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Payment Details', 1, 1, 'C', true);
$pdf->Cell(70, 10, 'Payment Method:', 1, 0, 'C');
$pdf->Cell(70, 10, 'Booking Time:', 1, 0, 'C');
$pdf->Cell(50, 10, 'Status:', 1, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(70, 10, $payment, 1, 0, 'C');
$pdf->Cell(70, 10, $time, 1, 0, 'C');
$pdf->SetFillColor(144, 238, 144); // Light Green
$pdf->Cell(50, 10, 'Done', 1, 1, 'C', true);
$pdf->Ln(10); // Line break

$pdf->SetFillColor(173, 216, 230); // Light Blue
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Passenger Details', 1, 1, 'C', true);
$pdf->Cell(70, 10, 'Name:', 1, 0, 'C');
$pdf->Cell(80, 10, 'Email:', 1, 0, 'C');
$pdf->Cell(40, 10, 'Phone No:', 1, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(70, 10, $name, 1, 0, 'C');
$pdf->Cell(80, 10, $email, 1, 0, 'C');
$pdf->Cell(40, 10, $phone, 1, 0, 'C');

$pdf->SetFillColor(144, 238, 144); // Light Green
$pdf->Ln(10); // Line break
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(95, 10, 'No of Ticket:', 1, 0, 'C');
$pdf->Cell(95, 10, 'Status:', 1, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(95, 10, $ticket, 1, 0, 'C');
$pdf->Cell(95, 10, 'Confirmed', 1, 1, 'C', true);
//Image Logo
$pdf->Image('photos/logo.jpeg', 40, 5, -300);

// Output PDF
$pdf->Output();
?>
