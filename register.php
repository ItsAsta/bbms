<?php
require __DIR__ . '/vendor/autoload.php';

include_once('inc/register.inc.php');
include_once('inc/header.inc.php');
headerOutput('Login', array("assets/styles/bootstrap.css", "assets/styles/stylesheet.css", "assets/styles/picker.css"));
navigationOutput('Login');
?>

<div class="container" style="background-color: #1e1e1e; margin: 50px; max-width: 100%">
    <div class="form-wrapper">
        <!-- REGISTER FORM -->
        <form method="post" action="inc/register.inc.php" id="userRegisterForm">
            <h3>Register</h3>
            <hr style="background-color: white">
            <div class="form-row">
                <div class="col-md-auto">
                    <div class="form-group">
                        <label for="userFirstName">First name</label>
                        <input id="userFirstName" type="text" name="firstName">

                        <label for="userLastName">Last name</label>
                        <input id="userLastName" type="text" name="lastName">

                        <label for="userAddress">Address</label>
                        <input id="userAddress" type="text" name="address">

                        <label for="userPostcode">Postcode</label>
                        <input id="userPostcode" type="text" name="postcode">

                        <label for="userPhoneNumber">Phone number</label>
                        <input id="userPhoneNumber" type="tel" name="phoneNumber">
                    </div>
                </div>
                <div class="col-md-auto">
                    <div class="form-group">
                        <label class="control-label">Email</label>
                        <input id="userRegisterEmail" type="email" name="email">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="userRegisterPassword">Password</label>
                        <input id="userRegisterPassword" type="password" name="password">
                        <label class="control-label" for="userConfirmRegisterPassword">Confirm Password</label>
                        <input id="userConfirmRegisterPassword" type="password"
                               name="confirmPassword">
                    </div>
                </div>
            </div>
            <div class="button-wrapper">
                <button name="register" type="submit" id="registerBtn">REGISTER</button>
            </div>
            <p>Already Registered? <b id="loginRedirect" onclick="window.location.href='login.php'">Login!</b></p>
            <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "empty") {
                    echo "<p class='error'>Can't complete action: One or more fields are empty!</p>";
                } elseif ($_GET["error"] == "email") {
                    echo "<p class='error'>Can't complete action: Invalid email format!</p>";
                } elseif ($_GET["error"] == "alreadyRegistered") {
                    echo "<p class='error'>Can't complete action: Email already registered!</p>";
                } elseif ($_GET["error"] == "password") {
                    echo "<p class='error'>Can't complete action: Passwords are not matching!</p>";
                } elseif ($_GET["error"] == "phoneNumber") {
                    echo "<p class='error'>Can't complete action: Invalid phone number format!</p>";
                } elseif ($_GET["error"] == "stmtfailed") {
                    echo "<p class='error' style='text-align: center'>Can't complete action: Database Error, please try again!</p>";
                } elseif ($_GET["error"] == "wronglogin") {
                    echo "<p class='error'>Can't complete action: Incorrect details, please try again!</p>";
                }
            }
            ?>
        </form>
    </div>
</div>

<?php footerOutput('Login') ?>
