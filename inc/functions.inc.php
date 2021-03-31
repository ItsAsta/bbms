<?php

session_start();
require("../PHPMailer/src/PHPMailer.php");
require("../PHPMailer/src/SMTP.php");

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

function userExists($db, $email) {
    $sql = "SELECT * FROM user WHERE user_email = ?;";
    $stmt = mysqli_stmt_init($db);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.inc.php?error=stmtFailed");
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

function registerUser($db, $email, $password, $firstName, $lastName, $address, $postcode, $phoneNumber) {
    $sql = "INSERT INTO user (user_email, user_password, user_first_name, user_last_name, user_address, user_postcode, user_phone_number) VALUES
                            (?, ?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($db);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.inc.php?error=stmtFailed");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sssssss", $email, $hashedPassword, $firstName, $lastName, $address, $postcode, $phoneNumber);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../register.php?success=yes");
}

function emptyInput($array) {
    $result = null;
    foreach ($array as $value) {
        if (empty($value)) {
            $result = true;
            return $result;
        } else {
            $result = false;
        }
    }

    return $result;
}

function loginUser($db, $email, $password) {
    $emailExists = userExists($db, $email);

    if ($emailExists === false) {
        header("location: ../login.php?error=nonexistent");
        exit();
    }

    $passwordHashed = $emailExists["user_password"];
    $checkPassword = password_verify($password, $passwordHashed);

    if ($checkPassword === false) {
        header("location: ../login.php?error=wronglogin");
    } else {
        session_start();
        $_SESSION["email"] = $emailExists["user_email"];
        header("location: ../index.php");
        exit();
    }
}

function bookAppointment($db, $barbershopId, $barberId, $email, $bookedDate, $bookedTime, $currentDateTime, $status) {

    $bookedDateTime = $bookedDate . " " . $bookedTime;

    $sql = "INSERT INTO `booking` (`barbershop_id`, `barber_id`, `booking_email`, `booking_date_time_of_booking`, `booking_date_time_booked`, `booking_status`) VALUES
           (?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_stmt_init($db);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../book_app.inc.php?error=stmtFailed");
        exit();
    }


    mysqli_stmt_bind_param($stmt, "ssssss", $barbershopId, $barberId, $email, $currentDateTime, $bookedDateTime, $status);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../bookings.php?success=yes");
}

function cancelBooking($db, $booking_reference) {
    $sql = "UPDATE `booking` SET `booking_status`=1 WHERE booking_reference = ?;";

    $stmt = mysqli_stmt_init($db);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../book_app.inc.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $booking_reference);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../bookings.php");
}

function receiveMessage($db, $email, $bookingRef, $subject, $message, $currentDateTime) {
    $sql = "INSERT INTO `inbox` (`inbox_email`, `inbox_booking_reference`, `inbox_subject`, `inbox_message`, `inbox_date_time`) VALUES
            (?, ?, ?, ?, ?)";

    $stmt = mysqli_stmt_init($db);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../contact.php?error=stmtFailed");
        exit();
    }


    mysqli_stmt_bind_param($stmt, "sssss", $email, $bookingRef, $subject, $message, $currentDateTime);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    sendNoReplyMessage($email);
}

function sendNoReplyMessage($email) {
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->IsSMTP();

    $mail->SMTPDebug = 1;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465;
    $mail->IsHTML(true);
    $mail->Username = "maxedasta@gmail.com";
    $mail->Password = "gmailperker";
    $mail->SetFrom("no-reply@asta.dev");
    $mail->Subject = "Email Received!";
    $mail->Body = "Thank you for contacting us, we have successfully received your message! We will get back to you within 24 hours.";
    $mail->AddAddress($email);

    if(!$mail->Send()) {
        header("location: ../contact.php?error=stmtFailed");
    } else {
        header("location: ../contact.php?success=yes");
    }
}

// Redirects the page to the login page or view booking page depends if we are logged in.
if (isset($_POST["loginRedirect"])) {
    session_start();
    if (empty($_SESSION["email"])) {
        // Redirect to a different page to do the booking passing over the store ID as reference to the page using POST
        header("location: ../bookings.php");
        exit();
    } else {
        header("location: ../login.php");
        exit();
    }
}