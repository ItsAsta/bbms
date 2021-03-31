<?php
//This php function will output our html inside the html. It has 2 parameter, title and the stylesheet paths.
//The styleSheetPath is an array so we can use multiple stylesheets.
function headerOutput($title, $styleSheetPath)
{
    echo '<!DOCTYPE html>
        <html lang="en">
        <head>
        <link rel="icon" type="image/png" sizes="16x16" href="../assets/bbms_icon.png">
        <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
        <title>BBMS</title>';
    //We iterate over the length of the passed array so we can echo out every stylesheet that is passed as an argument.
    for ($i = 0; $i < count($styleSheetPath); $i++) {
        echo '<link rel="stylesheet" type="text/css" href="' . $styleSheetPath[$i] . '">';
    }

    echo '<title>' . $title . '</title>';

    //This function echo's out our java scripts.
    outputScripts();
    echo '</head>
          <body>';
}

//Simple function to output our scripts to our html.
function outputScripts()
{
    echo '<script src="https://kit.fontawesome.com/a054ec7c89.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="assets/js/datatables.js"></script>
        <script type="text/javascript" src="assets/js/main.js"></script>
        <script src="assets/js/picker.min.js"></script>
        <script src="assets/js/bootstrap.js"></script>
        <script src="assets/js/bootstrap-datepicker.js"></script>
        <script src="assets/js/jquery.timepicker.js"></script>
        <script src="assets/js/moment.js"></script>
        ';
}

function navigationOutput($currentPage)
{

    // Using PHP, we'll add the first part of our navigation, which will be our class inside a div. It acts as a container.
    echo '<div class="nav-bar">
        <ul>';

    loopNavigation($currentPage);

    // At the end, we'll just close our element tags.
    echo '</ul>';
//    outputPromotionNav();
    echo '</div>';
}

//This function will print out our navigation.
function loopNavigation($currentPage)
{
    // An array variable with our page names, which we'll match using the index with our second array.
    $pageTitle = array("Home", "Bookings", "Contact", "About Us", "Login");

    // An array variable with our file names which we'll redirect to using the HREF attribute.
    $fileNames = array("index.php", "bookings.php", "contact.php", "about_us.php", "login.php");

    if (empty($_SESSION["email"])) {

        array_splice($pageTitle, 1, 1);
        array_splice($fileNames, 1, 1);
        array_splice($pageTitle, 2, 1);
        array_splice($fileNames, 2, 1);
        array_splice($pageTitle, 1, 1);
        array_splice($fileNames, 1, 1);
    }

    // We iterating over the length of $names array using a for loop.
    for ($i = 0; $i < count($pageTitle); $i++) {
        echo '<li ';
        /*
            In this if statement, we are checking if the name we currently iterated on is the same as the page we
            passed as an arguement inside our $currentPage parameter.
            If it matches, we'll add an id attribute into our element, and the string `active` which we use in our css.
        */
        if ($pageTitle[$i] == $currentPage) {
            echo 'id="active" ';
        }

        // We checking if the user is logged in by checking if there is any session set.
        if (!empty($_SESSION["email"])) {
            // If the if statement returns true, we'll get the 4th index in our array and change the string to logout.
            // Since the user is logged in, we want to display logout instead of login/register.
            $pageTitle[4] = "Logout";
            $fileNames[4] = "inc/logout.inc.php";
        }

        // We then echo out our html code.
        echo '><a id="' . $pageTitle[$i] . '" href="' . $fileNames[$i] . '">' . $pageTitle[$i] . '</a></li>';
    }
}

//Outputs all the contents for the footer.
function footerOutput($currentPage)
{
    openFooter();
    leftFooterOutput($currentPage);
    centerFooterOutput();
    rightFooterOutput();
    closeFooter();
    copyrightFooterOutput();
    exit();
}

function leftFooterOutput($currentPage)
{
    // Using PHP, we'll add the first part of our navigation, which will be our class inside a div. It acts as a container.
    echo '<div class="footer-container-left">
        <h2>NAVIGATE</h2>
        <hr style="background-color: white">
        <div class="footer-nav">
            <ul>';

    loopNavigation($currentPage);

    // At the end, we'll just close our elements tags.
    echo '</ul></div></div>';
}

//A very simple php function to just output html.
function centerFooterOutput()
{
    echo '<div class="footer-container-center">
            <h2>SOCIALS</h2>
            <hr style="background-color: white">
            
            <i class="fab fa-snapchat"></i>
            <span>@AzuzAlDosari</span>
            
            <a href="https://www.instagram.com/Abzzzz._/">
            <i class="fab fa-instagram"></i>
            <span>@Abzzzz._</span>
            </a>
            
            <a href="https://github.com/ItsAsta">
            <i class="fab fa-github"></i>
            <span>@ItsAsta</span>
            </a>
            
            <a href="https://rspeer.org/">
            <i class="fas fa-globe"></i>
            <span>WWW.RSPeer.org</span>
            </a>
          </div>';
}


function rightFooterOutput() {

    echo '<div class="footer-container-right">
        <h2>BOOKINGS</h2>
        <hr style="background-color: white">
        <ul class="footer-top-list">';

    if (!empty($_SESSION["email"])) {
        $db = mysqli_connect('localhost', 'root', '', 'bbms') or die("Connection to database could not be established!");

        $sql = "SELECT `booking`.*, `user`.*, `barbershop`.* FROM `booking` INNER JOIN `user` ON booking.booking_email = user.user_email INNER JOIN `barbershop` ON booking.barbershop_id = barbershop.barbershop_id WHERE booking.booking_email = '" . $_SESSION["email"] . "' AND `booking_status` = 0 ORDER BY CAST(booking_date_time_booked AS DATE) ASC LIMIT 3";
        $result = mysqli_query($db, $sql);
        $resultCheck = mysqli_num_rows($result);

        if ($resultCheck > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<li>" . $row["barbershop_name"] . "</li>";
                echo "<li style='font-style: italic'>" . date("d/m/Y H:i A", strtotime($row["booking_date_time_booked"])) . "</li>";
            }
        } else {
            echo "<li>No Bookings!</li>";
        }
    } else {
        echo "<li>No Bookings!</li>";
    }

    echo '</ul>
    </div>';
}


function copyrightFooterOutput()
{
    echo '<div class="copyright-footer">
        <span>© Middlesex University - AbdulAziz Al-Khafaji</span>
    </div>';
}

//A function to open our footer element.
function openFooter()
{
    echo '<div class="footer">';
}

//A function to close our footer element.
function closeFooter()
{
    echo '</div></body></html>';
}