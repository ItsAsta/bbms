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

    $sql = "SELECT `date_time_booked` FROM `booking` WHERE `barbershop_id` = " . $_POST['barbershopId'] . " AND barber_id = " . $_POST["barberId"] . " AND DATE(date_time_booked) = '" . $_POST["date"] . "'";

    $result = mysqli_query($db, $sql);
    $resultCheck = mysqli_num_rows($result);
    $jsonBookedTimesObject = array();

    while ($row = mysqli_fetch_assoc($result)) {
        array_push($jsonBookedTimesObject, array('date_time_booked' => $row["date_time_booked"]));
    }

    $jsonBookedTimes = json_encode($jsonBookedTimesObject);

    $openCloseTimesSql = "SELECT `open_time`, `close_time` FROM `opening_hours` WHERE `barbershop_id` = " . $_POST['barbershopId'] . " AND weekday = " . $_POST["weekday"];

    $openCloseTimesResult = mysqli_query($db, $openCloseTimesSql);
    $openCloseTimesResultCheck = mysqli_num_rows($openCloseTimesResult);
    $jsonOpenCloseTimesObject = array();

    while ($row = mysqli_fetch_assoc($openCloseTimesResult)) {
//        array_push($jsonOpenCloseTimesObject, array('open_time' => $row['open_time'], 'close_time' => $row['close_time']));
        $jsonOpenCloseTimesObject = array('open_time' => $row['open_time'], 'close_time' => $row['close_time']);
    }

    $jsonOpenCloseTimes = json_encode($jsonOpenCloseTimesObject);

    $data = array();

    array_push($data, $jsonBookedTimesObject, $jsonOpenCloseTimesObject);

    $jsonData = json_encode($data);

    echo $jsonData;
}