<?php

session_start();

// Registration
function emptyRegisterInput($email, $password, $confirmPassword, $firstName, $lastName, $address, $postcode, $phoneNumber) {
    $result = null;
    if (empty($email) || empty($password) || empty($confirmPassword) || empty($firstName) || empty($lastName) ||
        empty($address) || empty($postcode) || empty($phoneNumber)) {
        $result = true;
    } else {
        $result = false;
    }


    return $result;
}

function customerExists($db, $email) {
    $sql = "SELECT * FROM customer WHERE email = ?;";
    $stmt = mysqli_stmt_init($db);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.inc.php?register=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        return $result = false;
    }

    mysqli_stmt_close($stmt);
}

function registerCustomer($db, $email, $password, $firstName, $lastName, $address, $postcode, $phoneNumber) {
    $sql = "INSERT INTO customer (email, password, first_name, last_name, address, postcode, phone_number) VALUES
                            (?, ?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($db);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.inc.php?register=stmtFailed");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sssssss", $email, $hashedPassword, $firstName, $lastName, $address, $postcode, $phoneNumber);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../login.php?success=yes");
}

// Login
function emptyLoginInput($email, $password) {
    $result = null;
    if (empty($email) || empty($password)) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

function loginCustomer($db, $email, $password) {
    $emailExists = customerExists($db, $email);

    if ($emailExists === false) {
        header("location: ../login.php?error=nonexistant");
        exit();
    }

    $passwordHashed = $emailExists["password"];
    $checkPassword = password_verify($password, $passwordHashed);

    if ($checkPassword === false) {
        header("location: ../login.php?error=wronglogin");
    } else {
        session_start();
        $_SESSION["email"] = $emailExists["email"];
        header("location: ../index.php");
        exit();
    }
}

function incompleteBookingForm($barbershopId, $barberId, $bookedDate, $bookedTime) {
    $result = null;
    if (empty($barbershopId) || empty($barberId) || empty($bookedDate) || empty($bookedTime)) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}


function bookAppointment($db, $barbershopId, $barberId, $email, $bookedDate, $bookedTime, $currentDateTime, $status) {

    if (incompleteBookingForm($barbershopId, $barberId, $bookedDate, $bookedTime)) {
        header("location: ../book_app.php?error=incomplete");
        exit();
    }



    $bookedDateTime = $bookedDate . " " . $bookedTime;

    $sql = "INSERT INTO `booking`(`barbershop_id`, `barber_id`, `email`, `date_time_of_booking`, `date_time_booked`, `status`) VALUES
           (?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_stmt_init($db);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../book_app.inc.php?booking=stmtFailed");
        exit();
    }


    mysqli_stmt_bind_param($stmt, "ssssss", $barbershopId, $barberId, $email, $currentDateTime, $bookedDateTime, $status);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../bookings.php?success=yes");
}

function cancelBooking($db, $booking_reference) {
    $sql = "UPDATE `booking` SET `status`=1 WHERE booking_reference = ?;";

    $stmt = mysqli_stmt_init($db);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../book_app.inc.php?booking=stmtFailed");
        exit();
    }


    mysqli_stmt_bind_param($stmt, "s", $booking_reference);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../bookings.php");
}

// Redirects the page to the login page or view booking page depends if we are logged in.
if (isset($_POST["loginRedirect"])) {
    session_start();
    if (isset($_SESSION["email"])) {
        // Redirect to a different page to do the booking passing over the store ID as reference to the page using POST
        header("location: ../bookings.php");
        exit();
    } else {
        header("location: ../login.php");
        exit();
    }
}