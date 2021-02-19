<?php

require_once 'dbh.inc.php';

if (isset($_POST["bookApp"])) {
    $barberId = $_POST["bookBarberSelect"];
    $barbershopId = $_POST["bookBarbershopSelect"];
    $date = $_POST["bookedDate"];
    $time = $_POST["bookedTime"];
    $currentDateTime = date('Y-m-d H:i:s');

    require_once 'functions.inc.php';

    $convertedTime = date( "H:i:s", strtotime($time));
    $convertedDate = date("Y-m-d", strtotime($date));

//    $sql = "INSERT INTO `booking`(`barbershop_id`, `barber_id`, `email`, `date_time_of_booking`, `date_time_booked`, `status`) VALUES ('$barbershopId', '$barberId', '" . $_SESSION['email'] ."', '$currentDateTime', '" . $date . " " . $time . "', '1')";
//
//    $query = mysqli_query($db, $sql);

    bookAppointment($db, $barbershopId, $barberId, $_SESSION["email"], $convertedDate, $convertedTime, $currentDateTime, 0);
}
