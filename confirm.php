<?php

/**
 * Class: csci303fa20
 * User: Dalton
 * Date: 10/20/2020
 * Time: 2:58 PM
 */
 
 $pagename = "Confirmation";
 require_once "includes/header.php";

if ($_GET['state']==1) {
    echo "<p>Logout Confirmed. <a href='login.php'>Log in</a> again to view the page.</p>";
}
elseif ($_GET['state']==2) {
    echo "<p>Thank you for logging in, " . $_SESSION['fname'] . "!</p>";
}


require_once "includes/footer.php";