<?php

if (isset($_POST["cancel_booking"])) {

    $booking_reference = $_POST["booking_ref"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    cancelBooking($db, $booking_reference);
}
