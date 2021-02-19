<?php

require_once 'dbh.inc.php';


if (isset($_POST["populateBarbers"])) {

    $sql = "SELECT * FROM barbers WHERE barbershop_id = " . $_POST['barbershopId'] . ";";
    $result = mysqli_query($db, $sql);
    $resultCheck = mysqli_num_rows($result);

    echo "<option disabled selected value>Select Barber</option>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
    }
}

if (isset($_POST["bookedTimes"])) {
//    header("location: ../book_app.php");

    $sql = "SELECT `date_time_booked` FROM `booking` WHERE `barbershop_id` = " . $_POST['barbershopId'] . " AND barber_id = " . $_POST["barberId"];

    $result = mysqli_query($db, $sql);
    $resultCheck = mysqli_num_rows($result);
    $jsonObject = array();

    while ($row = mysqli_fetch_assoc($result)) {
        array_push($jsonObject, array('date_time_booked' => $row["date_time_booked"]));
    }

    $json = json_encode($jsonObject);
    echo $json;
}