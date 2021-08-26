<?php

/**
 * Class: csci303fa20
 * User: Dalton
 * Date: 11/13/2020
 * Time: 12:40 AM
 */
 
 $pagename = "Community Management";
 require_once "includes/header.php";

 checkLogin();

 //Add Content button
?>
    <p><button onclick="document.location='commadd.php'">Add Community</button></p><br> <?php
 //Query the Database
$sql = "SELECT * FROM communities ORDER BY cname ASC";

//Execute Query
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Display Results
foreach ($result as $row) {
    echo "<a href='commdetails.php?q=" . $row['commID'] . "'>View</a>";?>
    &vert; <?php
    if (isset($_SESSION['ID']) && $_SESSION['ID'] == $row['FK_ID']) {echo "<a href='commupdate.php?q=" . $row['commID'] . "'>Edit &vert; </a>";}?>
    <?php
    if (isset($_SESSION['ID']) && $_SESSION['ID'] == $row['FK_ID']) {echo "<a href='commdelete.php?C=" . $row['cname'] . "'>Delete &vert; </a>";}
    echo "<p" . $row['commID'] . "'><strong>" . $row['cname'] . "</strong></p>";
}

require_once "includes/footer.php";