<?php
session_start();

include_once('inc/header.inc.php');
include_once('inc/dbh.inc.php');
headerOutput('Contact', array("assets/styles/bootstrap.css", "assets/styles/stylesheet.css", "assets/styles/picker.css"));
navigationOutput('Contact');
?>
<div class="container" style="background-color: #1e1e1e; margin: 50px;">
    <div class="form-wrapper contact-page">
        <!-- LOGIN FORM -->
        <form method="post" action="inc/contact.inc.php">
            <h3>Write To Us</h3>
            <hr style="background-color: white">
            <div class="form-row">
                <div class="col-md-auto">
                    <div class="form-group">
                        <input id="contactSubject" type="text" name="contactSubject" placeholder="Subject*">
                    </div>
                    <div class="form-group">
                        <input id="contactBookingRef" type="number" name="contactBookingRef" placeholder="Booking Reference">
                    </div>
                    <div class="form-group">
                        <textarea name="contactMessage" placeholder="Message*"></textarea>
                    </div>
                </div>
            </div>
            <div class="button-wrapper">
                <button name="contactSendBtn" type="submit" id="contactSendBtn">SEND <i class="fa fa-paper-plane" aria-hidden="true"></i></button>
            </div>
            <hr style="background-color: white">
            <?php
            if (isset($_GET["error"])) {

                if ($_GET["error"] == "empty") {
                    echo "<p class='error'>One or more fields are empty!</p>";
                    exit();
                } else if ($_GET["error"] == "stmtFailed") {
                    echo "<p class='error'>Error sending message, please try again!</p>";
                }
            }

            if (isset($_GET["success"])) {
                if ($_GET["success"] == "yes") {
                    echo "<p class='success'>Successfully sent message, please check your email!</p>";
                }
            }
            ?>
        </form>
    </div>
</div>