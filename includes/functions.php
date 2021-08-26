<?php

/**
 * Class: csci303fa20
 * User: Dalton
 * Date: 10/6/2020
 * Time: 1:09 PM
 */

//checking duplicates - function only
function checkdup($pdo, $sql, $field) {
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $field);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
}

//Checking is user is logged in
function checkLogin()
{
    if (!isset($_SESSION['ID'])) {
        echo "<p class='error'>This page requires authentication.  Please log in to view details.</p>";
        require_once "footer.php";
        exit();
    }
}

//Check if user is an admin
function checkAdmin()
{
    if (isset($_SESSION['status']) && $_SESSION['status'] != 1) {
        echo "<p class='error'>This page is only for admins.</p>";
        require_once "footer.php";
        exit();
    }
}