<?php
session_start();

include_once('inc/header.inc.php');
include_once('inc/dbh.inc.php');
headerOutput('Book Appointment', array("assets/styles/bootstrap.css", "assets/styles/stylesheet.css", "assets/styles/picker.css", "assets/styles/bootstrap-datepicker3.css", "assets/styles/jquery.timepicker.css"));
navigationOutput('Book Appointment');

if (empty($_SESSION["email"])) {
    header("location: login.php");
}
?>

<form method="post" action="inc/book_app.inc.php">
    <h3>Login</h3>
    <hr style="background-color: white">
    <div class="form-row">
        <div class="col-md-auto">
            <div class="form-row">
                <div class="form-group">
                    <select name="bookBarbershopSelect" id="bookBarbershopSelect">
                        <option disabled selected value>Select Barbershop</option>
                        <?php
                        $sql = "SELECT * FROM barbershop";
                        $result = mysqli_query($db, $sql);
                        $resultCheck = mysqli_num_rows($result);

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='" . $row["barbershop_id"] . "'>" . $row["barbershop_name"] . " (" . $row["barbershop_branch"] . ")</option>";
                        }
                        ?>
                    </select>
                    <br>
                    <?php
                    $sql = "SELECT * FROM customer WHERE customer_email = '" . $_SESSION["email"] . "'";
                    $result = mysqli_query($db, $sql);
                    $resultCheck = mysqli_num_rows($result);
                    $row = mysqli_fetch_assoc($result);

                    echo "<label for='" . $row["customer_first_name"] . " " . $row["customer_last_name"] . "'>Name</label>";
                    echo "<input name='" . $row["customer_first_name"] . " " . $row["customer_last_name"] . "' id='" . $row["customer_first_name"] . " " . $row["customer_last_name"] . "' value='" . $row["customer_first_name"] . " " . $row["customer_last_name"] . "' disabled>";

                    echo "<label for='" . $row["customer_email"] . "'>Email</label>";
                    echo "<input name='" . $row["customer_email"] . "' id='" . $row["customer_email"] . "' value='" . $row["customer_email"] . "' disabled>";
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
                    $sql = "SELECT * FROM customer WHERE customer_email = '" . $_SESSION["email"] . "'";
                    $result = mysqli_query($db, $sql);
                    $resultCheck = mysqli_num_rows($result);
                    $row = mysqli_fetch_assoc($result);

                    echo "<label for='" . $row["customer_address"] . ", " . $row["customer_postcode"] . "'>Address</label>";
                    echo "<input name='" . $row["customer_address"] . ", " . $row["customer_postcode"] . "' id='" . $row["customer_address"] . ", " . $row["customer_postcode"] . "' value='" . $row["customer_address"] . ", " . $row["customer_postcode"] . "' disabled>";

                    echo "<label for='" . $row["customer_phone_number"] . "'>Email</label>";
                    echo "<input name='" . $row["customer_phone_number"] . "' id='" . $row["customer_phone_number"] . "' value='" . $row["customer_phone_number"] . "' disabled>";
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
            echo "<p class='error' style='text-align: center'>Please complete booking form!</p>";
            exit();
        }
    }
    ?>
</form>