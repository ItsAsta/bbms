<?php
require __DIR__ . '/vendor/autoload.php';

include_once('inc/header.inc.php');
headerOutput('Login', array("assets/styles/bootstrap.css", "assets/styles/stylesheet.css", "assets/styles/picker.css"));
navigationOutput('Login');
?>

<div class="container" style="background-color: #1e1e1e; margin: 50px; max-width: 100%">
    <div class="form-wrapper">
        <!-- LOGIN FORM -->
        <form method="post" action="inc/login.inc.php" id="userLoginForm">
            <h3>Login</h3>
            <hr style="background-color: white">
            <div class="form-row">
                <div class="col-md-auto">
                    <div class="form-group">
                        <label for="userLoginEmail">Email</label>
                        <input id="userLoginEmail" type="email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="userPassword">Password</label>
                        <input id="userPassword" type="password" name="password">
                    </div>
                </div>
            </div>
            <div class="button-wrapper">
                <button name="login" type="submit" id="loginBtn">LOGIN</button>
            </div>
            <p>Not Registered? <b id="registerRedirect" onclick="window.location.href='register.php'">Register!</b></p>
            <?php
            if (isset($_GET["error"])) {

                if ($_GET["error"] == "empty") {
                    echo "<p class='error'>One or more fields are empty!</p>";
                    exit();
                } elseif ($_GET["error"] == "nonexistent") {
                    echo "<p class='error'>Email does not exist!</p>";
                    exit();
                } elseif ($_GET["error"] == "wronglogin") {
                    echo "<p class='error'>Password is incorrect!</p>";
                    exit();
                } elseif ($_GET["error"] == "stmtFailed") {
                    echo "<p class='error'>Failed to login, please try again!</p>";
                    exit();
                }
            }
            ?>
        </form>
    </div>
</div>
