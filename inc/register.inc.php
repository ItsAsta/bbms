<?php
session_start();

// Registration
if (isset($_POST["register"])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $address = $_POST['address'];
    $postcode = $_POST['postcode'];
    $phoneNumber = $_POST['phoneNumber'];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (emptyRegisterInput($email, $password, $confirmPassword, $firstName, $lastName, $address, $postcode, $phoneNumber) !== false) {
        header("location: ../register.php?error=empty");
        exit();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("location: ../register.php?error=email");
        exit();
    }
    if (customerExists($db, $email) !== false) {
        header("location: ../register.php?error=alreadyRegistered");
        exit();
    }
    if ($password != $confirmPassword) {
        header("location: ../register.php?error=password");
        exit();
    }
    if (!ctype_digit($phoneNumber)) {
        header("location: ../register.php?error=phoneNumber");
        exit();
    }

    registerCustomer($db, $email, $password, $firstName, $lastName, $address, $postcode, $phoneNumber);
}