<?php

/**
 * Class: csci303fa20
 * User: Dalton
 * Date: 10/22/2020
 * Time: 11:07 AM
 */

/*
 * EXAMPLE FILE USED TO SEND EMAIL VIA PHPMAILER
 */

//Include Required Files - Need Autoloader
require 'PHPMailer/PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer();

//Set the hostname of the mail server
$mail->Host = 'smtp.gmail.com';

//Whether to use SMTP authentication
$mail->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = 'ccucsciweb@gmail.com';

//Password to use for SMTP authentication
$mail->Password = 'csci303&409';

//Set the encryption
$mail->SMTPSecure = 'ssl';

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 465;

//Set the subject line
$mail->Subject = 'PHPMailer GMail SMTP test';

//Using HTML Email Body
$mail->isHTML(true);

//Set the Message Body
$mail->Body = '<p style="color:purple">This is a message.</p>';

//Set who the message is to be sent from
$mail->setFrom('ccucsciweb@gmail.com', 'CSCI 303 Class Email');

//Set who the message is to be sent to
/*
 * CHANGE THE CODE BELOW TO YOUR EMAIL IN YOUR INITIAL TESTING!!!
 */
$mail->addAddress('dacarlson@coastal.edu', 'Dalton Carlson');

//send the message, check for errors
if ($mail->send()) {
    echo '<p class="success">Email worked!</p>';
} else {
    echo '<p class="error">Problems with email. See video for troubleshooting.</p>';
}