<?php

/**
 * Class: csci303fa20
 * User: Dalton
 * Date: 11/13/2020
 * Time: 12:52 AM
 */
 
 $pagename = "Community Details";
 require_once "includes/header.php";

//Query DB
$sql = "SELECT * FROM `registeredUsers` INNER JOIN `communities` ON `registeredUsers`.`ID`=`communities`.`FK_ID` WHERE commID = :commID";
//$sql = "SELECT * FROM communities WHERE commID = :commID";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':commID', $_GET['q']);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

//Display Community Info
echo "<p><strong>Community Name: </strong>" . $row['cname'] . "</p>";
echo "<p><strong>Location of Community: </strong>" . $row['location'] . "</p>";
echo "<p><strong>Description of Community: </strong>" . $row['description'] . "</p>";
echo "<p><strong>Added on: </strong>" . $row['commdate'] . "</p>";
echo "<p><strong>Added by: </strong>" . $row['uname'] . "</p>";
echo "<p><strong>Last Update: </strong>" . $row['dateupdated'] . "</p>";

require_once "includes/footer.php";