<?php
//This php function will output our html inside the html. It has 2 parameter, title and the stylesheet paths.
//The styleSheetPath is an array so we can use multiple stylesheets.
function headerOutput($title, $styleSheetPath)
{
    echo '<!DOCTYPE html>
        <html lang="en">
        <head>
        <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">';
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
    $pageTitle = array("Home", "Bookings", "Contact", "About", "Login");

    // An array variable with our file names which we'll redirect to using the HREF attribute.
    $fileNames = array("index.php", "bookings.php", "contact.php", "about.php", "login.php");

    if (empty($_SESSION["email"])) {

        array_splice($pageTitle, 1, 1);
        array_splice($pageTitle, 2, 1);
        array_splice($fileNames, 1, 1);
        array_splice($fileNames, 2, 1);
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
        if (isset($_SESSION["email"])) {
            // If the if statement returns true, we'll get the 4th index in our array and change the string to logout.
            // Since the user is logged in, we want to display logout instead of login/register.
            $pageTitle[4] = "Logout";
            $fileNames[4] = "inc/logout.inc.php";
        }

        // We then echo out our html code.
        echo '><a id="' . $pageTitle[$i] . '" href="' . $fileNames[$i] . '">' . $pageTitle[$i] . '</a></li>';
    }
}