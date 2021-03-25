<?php

if (isset($_POST["bookApp"])) {
    $barberId = $_POST["bookBarberSelect"];
    $barbershopId = $_POST["bookBarbershopSelect"];
    $date = $_POST["bookedDate"];
    $time = $_POST["bookedTime"];
    $currentDateTime = date('Y-m-d H:i:s');

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    $convertedTime = date( "H:i:s", strtotime($time));
    $convertedDate = date("Y-m-d", strtotime($date));


    if (emptyInput(array($barberId, $barbershopId, $date, $time))) {
        header("location: ../book_app.php?error=incomplete");
        exit();
    }

    bookAppointment($db, $barbershopId, $barberId, $_SESSION["email"], $convertedDate, $convertedTime, $currentDateTime, 0);
}
