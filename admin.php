<?php

/**
 * Class: csci303fa20
 * User: Dalton
 * Date: 10/21/2020
 * Time: 2:28 PM
 */
 
$pagename="Admin Page";
require "includes/header.php";
$errmsg = "";

checkLogin();
checkAdmin();

echo "<h4>Content Control:</h4>";

echo "<p><a href='addtag.php'>Add new community tag</a></p>";
//Display list of communities
//Query the Database
//$sql = "SELECT * FROM communities ORDER BY cname ASC";
$sql = "SELECT * FROM `registeredUsers` INNER JOIN `communities` ON `registeredUsers`.`ID`=`communities`.`FK_ID`";
//Execute Query
$stmt = $pdo->prepare($sql);
//$stmt->bindValue(':ID', $_SESSION['ID']);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Display Communities
foreach ($result as $row) {

    echo "<p" . $row['commID'] . "'><strong>" . $row['cname'] . "</strong>";?>
    &nbsp; &nbsp; <?php
    echo "<a href='commdetails.php?q=" . $row['commID'] . "'>View</a>";?>
    &vert; <?php
    if (isset($_SESSION['ID'])) {echo "<a href='commupdate.php?q=" . $row['commID'] . "'>Edit &vert; </a>";}?>
    <?php
    if (isset($_SESSION['ID'])) {echo "<a href='commdelete.php?C=" . $row['cname'] . "'>Delete</a></p>";}


}
?><br><hr>
<h4>User Control:</h4>
<?php


//Display Users
$sql = "SELECT * FROM registeredUsers ORDER BY lname ASC";
//Execute Query
$stmt = $pdo->prepare($sql);
//$stmt->bindValue(':ID', $_SESSION['ID']);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($result as $row) {
    echo "<p" . $row['ID'] . "'><strong>" . $row['fname'] . " " . $row['lname'] . "</strong>&nbsp; &nbsp;";
    if (isset($_SESSION['ID'])) {echo "<a href='update.php?q=" . $row['ID'] . "'>Update &vert;</a>";}?>
    <?php
    echo "<a href='adminupdate.php?q=" . $row['ID'] . "'>Admin Update &vert;</a>";
    echo "<a href='userdetails.php?q=" . $row['ID'] . "'>View</a></p>";?>
    <?php

}



 echo "<p>This is the admin page and contains sensitive material.";

 require_once 'includes/footer.php';