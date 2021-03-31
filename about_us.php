<?php
session_start();

include_once('inc/header.inc.php');
include_once('inc/dbh.inc.php');
headerOutput('About Us', array("assets/styles/bootstrap.css", "assets/styles/stylesheet.css", "assets/styles/picker.css"));
navigationOutput('About Us');
?>

<div class="about-us-container">
    <div class="about-us-title">
        <h2>About US</h2>
    </div>
    <hr style="background-color: white">
    <div class="about-us-heading">
        <ul>
            <li class="headingSelection" id="aboutUsActive" onclick="showUs(this)">About BBMS</li>
            <li class="headingSelection" onclick="showFaq(this)">FAQ</li>
        </ul>
    </div>

    <div class="about-us-body" id="usSection">
        <h3>Safety & Reliability</h3>
        <p>This project was made in mind to integrate technology into small barbershop businesses & increase safety.
            The idea came to mind when the Covid-19 pandemic happened and social distancing were enforced across all
            businesses.
            Barbershops across the country had a hard time making sure that people were able to social distance within
            the shop, customer were forced to line up outside the shop. For that reason, this project was started and
        implemented to eliminate standing outside the barbershop waiting for your turn.</p>
    </div>

    <div class="about-us-body" id="faqSection">
        <h4 class="question">What is this system? <i style="font-size: 18px" class="fas fa-arrow-down"></i></h4>
        <p class="question-answers">Users are able to book an appointment with their barbershop if the barbershop has signed up with us.</p>

        <h4 class="question">Why choose you? <i style="font-size: 18px" class="fas fa-arrow-down"></i></h4>
        <p class="question-answers">We have got the largest collection of barbershops to book with.
            On top of that, our users can select which barber they would like to book with.</p>

        <h4 class="question">Do I have to pay? <i style="font-size: 18px" class="fas fa-arrow-down"></i></h4>
        <p class="question-answers">This service is completely free to all users.</p>

        <h4 class="question">Can I cancel my booking? <i style="font-size: 18px" class="fas fa-arrow-down"></i></h4>
        <p class="question-answers">Yes. You can cancel your booking under <a href="bookings.php">Bookings</a></p>

        <h4 class="question">How can I get in contact with you? <i style="font-size: 18px" class="fas fa-arrow-down"></i></h4>
        <p class="question-answers">You can drop us a message under here <a href="contact.php">Contact</a>. We will get back to you within 24 hours!</p>
    </div>

</div>

<?php footerOutput('About Us'); ?>