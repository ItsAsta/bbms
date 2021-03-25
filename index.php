<?php
session_start();

include_once('inc/header.inc.php');
include_once('inc/dbh.inc.php');
headerOutput('Home', array("assets/styles/bootstrap.css", "assets/styles/stylesheet.css", "assets/styles/picker.css"));
navigationOutput('Home');
?>

<div class="container" style="background-color: #1e1e1e; margin: 50px; max-width: 100%">
    <div class="landing-page-container">
            <div class="button-wrapper">
                <button onclick="window.location.href='book_app.php'">Start Booking</button>
            </div>
    </div>
</div>

<?php footerOutput('Home') ?>
