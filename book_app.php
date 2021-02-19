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
                            echo "<option value='" . $row["barbershop_id"] . "'>" . $row["name"] . " (" . $row["branch"] . ")</option>";
                        }
                        ?>
                    </select>
                    <br>
                    <?php
                    $sql = "SELECT * FROM customer WHERE email = '" . $_SESSION["email"] . "'";
                    $result = mysqli_query($db, $sql);
                    $resultCheck = mysqli_num_rows($result);
                    $row = mysqli_fetch_assoc($result);

                    echo "<label for='" . $row["first_name"] . " " . $row["last_name"] . "'>Name</label>";
                    echo "<input name='" . $row["first_name"] . " " . $row["last_name"] . "' id='" . $row["first_name"] . " " . $row["last_name"] . "' value='" . $row["first_name"] . " " . $row["last_name"] . "' disabled>";

                    echo "<label for='" . $row["email"] . "'>Email</label>";
                    echo "<input name='" . $row["email"] . "' id='" . $row["email"] . "' value='" . $row["email"] . "' disabled>";
                    ?>

                    <label for="bookedDate">Date</label>
                    <input name="bookedDate" id="bookedDate">
                </div>
                <div class="form-group">
                    <select name="bookBarberSelect" id="bookBarberSelect">
                        <option disabled selected value>Select Barber</option>
                    </select>
                    <br>
                    <?php
                    $sql = "SELECT * FROM customer WHERE email = '" . $_SESSION["email"] . "'";
                    $result = mysqli_query($db, $sql);
                    $resultCheck = mysqli_num_rows($result);
                    $row = mysqli_fetch_assoc($result);

                    echo "<label for='" . $row["address"] . ", " . $row["postcode"] . "'>Address</label>";
                    echo "<input name='" . $row["address"] . ", " . $row["postcode"] . "' id='" . $row["address"] . ", " . $row["postcode"] . "' value='" . $row["address"] . ", " . $row["postcode"] . "' disabled>";

                    echo "<label for='" . $row["phone_number"] . "'>Email</label>";
                    echo "<input name='" . $row["phone_number"] . "' id='" . $row["phone_number"] . "' value='" . $row["phone_number"] . "' disabled>";
                    ?>
                    <label for="bookedTime">Time</label>
                    <input name="bookedTime" id="bookedTime" class="bookedTime">


                    <div id="tester"></div>
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