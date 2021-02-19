<?php
session_start();

include_once('inc/header.inc.php');
include_once('inc/dbh.inc.php');
headerOutput('Home', array("assets/styles/bootstrap.css", "assets/styles/stylesheet.css", "assets/styles/picker.css"));
navigationOutput('Home');
?>

<div class="container" style="background-color: #1e1e1e; margin: 50px; max-width: 100%">
    <div class="landing-page-container">
<!--        <form method="post" action="inc/functions.inc.php">-->
<!--            <label class="barbershop-landing-heading" for="barbershopSearch">SELECT BARBERSHOP</label>-->
<!--            <select name="barbershopSelect" id="barbershopSearch">-->
<!--                <option value="" disabled selected value>Select Barbershop</option>-->
<!--                --><?php
//                $sql = "SELECT * FROM barbershop";
//                $result = mysqli_query($db, $sql);
//                $resultCheck = mysqli_num_rows($result);
//
//                while ($row = mysqli_fetch_assoc($result)) {
//                    echo "<option value='" . $row["barbershop_id"] . "'>" . $row["name"] . " (" . $row["branch"] . ")</option>";
//                }
//                ?>
<!--            </select>-->
            <div class="button-wrapper">
<!--                <button type="submit" name="loginRedirect" id="loginRedirect" value="redirect">Start Booking</button>-->
                <button onclick="window.location.href='book_app.php'">Start Booking</button>
            </div>
<!--        </form>-->
    </div>
</div>
