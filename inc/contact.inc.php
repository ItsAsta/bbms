<?php

if (isset($_POST["contactSendBtn"])) {
    $subject = $_POST["contactSubject"];
    $message = $_POST["contactMessage"];
    $bookingRef = $_POST["contactBookingRef"];
    $currentDateTime = date('Y-m-d H:i:s');

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (emptyInput(array($subject, $message))) {
        header("location: ../contact.php?error=empty");
        exit();
    }

    receiveMessage($db, $_SESSION["email"], $bookingRef, $subject, $message, $currentDateTime);
}
