<?php
session_start();

include_once('inc/header.inc.php');
include_once('inc/dbh.inc.php');
headerOutput('Home', array("assets/styles/bootstrap.css", "assets/styles/stylesheet.css", "assets/styles/picker.css", "assets/styles/bootstrap-datepicker3.css", "assets/styles/jquery.timepicker.css"));
navigationOutput('Home');

if (empty($_SESSION["email"])) {
    header("location: login.php");
}
?>

    <form method="post" action="inc/book_app.inc.php">
        <h3>Book Appointment</h3>
        <hr style="background-color: white">
        <div class="form-row">
            <div class="col-md-auto">
                <div class="form-row">
                    <div class="form-group">
                        <select name="bookBarbershopSelect" id="bookBarbershopSelect">
                            <option disabled selected value>Select Barbershop</option>
                            <?php
                            $sql = "SELECT * FROM barbershop WHERE barbershop_id NOT IN(SELECT barbershop_id FROM barbershop WHERE barbershop_id = 1)";
                            $result = mysqli_query($db, $sql);
                            $resultCheck = mysqli_num_rows($result);

                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $row["barbershop_id"] . "'>" . $row["barbershop_name"] . " (" . $row["barbershop_branch"] . ")</option>";
                            }
                            ?>
                        </select>
                        <br>
                        <?php
                        $sql = "SELECT * FROM user WHERE user_email = '" . $_SESSION["email"] . "'";
                        $result = mysqli_query($db, $sql);
                        $resultCheck = mysqli_num_rows($result);
                        $row = mysqli_fetch_assoc($result);

                        echo "<label for='" . $row["user_first_name"] . " " . $row["user_last_name"] . "'>Name</label>";
                        echo "<input name='" . $row["user_first_name"] . " " . $row["user_last_name"] . "' id='" . $row["user_first_name"] . " " . $row["user_last_name"] . "' value='" . $row["user_first_name"] . " " . $row["user_last_name"] . "' disabled>";

                        echo "<label for='" . $row["user_email"] . "'>Email</label>";
                        echo "<input name='" . $row["user_email"] . "' id='" . $row["user_email"] . "' value='" . $row["user_email"] . "' disabled>";
                        ?>

                        <label for="bookedDate">Date</label>
                        <input name="bookedDate" id="bookedDate" autocomplete="disabled">
                    </div>
                    <div class="form-group">
                        <select name="bookBarberSelect" id="bookBarberSelect">
                            <option disabled selected value>Select Barber</option>
                        </select>
                        <br>
                        <?php
                        $sql = "SELECT * FROM user WHERE user_email = '" . $_SESSION["email"] . "'";
                        $result = mysqli_query($db, $sql);
                        $resultCheck = mysqli_num_rows($result);
                        $row = mysqli_fetch_assoc($result);

                        echo "<label for='" . $row["user_address"] . ", " . $row["user_postcode"] . "'>Address</label>";
                        echo "<input name='" . $row["user_address"] . ", " . $row["user_postcode"] . "' id='" . $row["user_address"] . ", " . $row["user_postcode"] . "' value='" . $row["user_address"] . ", " . $row["user_postcode"] . "' disabled>";

                        echo "<label for='" . $row["user_phone_number"] . "'>Email</label>";
                        echo "<input name='" . $row["user_phone_number"] . "' id='" . $row["user_phone_number"] . "' value='" . $row["user_phone_number"] . "' disabled>";
                        ?>
                        <label for="bookedTime">Time</label>
                        <input name="bookedTime" id="bookedTime" class="bookedTime" placeholder="Select Time">

                    </div>
                </div>
            </div>
        </div>
        <div class="button-wrapper">
            <button name="bookApp" type="submit" id="bookAppBtn">Book Appointment</button>
        </div>
        <?php
        if (isset($_GET["error"])) {

            if ($_GET["error"] == "incomplete") {
                echo "<p class='error' style='text-align: center'>Can't complete action: Please complete booking form!</p>";
            } else if ($_GET["error"] == "stmtFailed") {
                echo "<p class='error' style='text-align: center'>Can't complete action: Failed creating a booking, please try again!</p>";
            } else if ($_GET["error"] == "time") {
                echo "<p class='error' style='text-align: center'>Can't complete action: Please choose a time that has not passed yet!</p>";
            }
        }
        ?>
    </form>

<?php footerOutput('Home') ?>