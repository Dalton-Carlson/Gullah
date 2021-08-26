<?php

/**
 * Class: csci303fa20
 * User: Dalton
 * Date: 10/20/2020
 * Time: 7:19 PM
 */
 
 session_start();
 session_unset();
 session_destroy();
header("Location: confirm.php?state=1");

?>