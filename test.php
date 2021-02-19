<?php
session_start();

include_once('inc/header.inc.php');
include_once('inc/dbh.inc.php');
headerOutput('View Booking', array("assets/styles/bootstrap.css", "assets/styles/stylesheet.css", "assets/styles/picker.css"));
navigationOutput('View Booking');
?>

<button class="btn btn-default" data-toggle="modal" data-target="#settings">
    <img src="img/settings.png" alt="" class="img-circle">
</button>
<button class="btn btn-default" data-toggle="modal" data-target="#help">
    <img src="img/help.png" alt="" class="img-circle">
</button>

<div id="settings" class="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Settings</h3>
            </div>
            <div class="modal-body">
                <h4> Tethering</h4>
                <label>Name: </label>
                <input type="text" id="wlanName" size="15">
                <label>Passphrase: </label>
                <input type="text" id="passPhrase" size="15">
                <br>
                <br>
                <button type="button" class="btn btn-success" onclick="enableTethering()">Enable tethering</button>
                <button type="button" class="btn btn-danger" onclick="disableTethering()">Disable tethering</button>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>






<div id="help" class="modal" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Help</h3>
            </div>
            <div class="modal-body">
                *CONTENT TO BE MADE*
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>