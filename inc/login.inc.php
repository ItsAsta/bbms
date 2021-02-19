<?php

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (emptyLoginInput($email, $password) !== false) {
        header("location: ../login.php?error=empty");
        exit();
    }

    loginCustomer($db, $email, $password);
}
