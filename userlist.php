<?php

/**
 * Class: csci303fa20
 * User: Dalton
 * Date: 10/20/2020
 * Time: 12:22 PM
 */

$pagename = "User Dashboard";
require_once "includes/header.php";


?><br><?php

//QUERY THE DATABASE
$sql = "SELECT * FROM registeredUsers ORDER BY lname ASC";

//EXECUTE THE QUERY TO GET THE RESULTS
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//Display Result
foreach($result as $row) {
    echo "<p" . $row['ID'] . "'>" . $row['fname'] . " " . $row['lname'] . "&nbsp; &nbsp;";
    if (isset($_SESSION['ID']) && $_SESSION['ID'] == $row['ID']) {echo "<a href='update.php?q=" . $row['ID'] . "'>Update &vert;</a>";}?>
    <?php
    echo "<a href='userdetails.php?q=" . $row['ID'] . "'>View</a></p>";?>
     <?php

}
require_once 'includes/footer.php';
?>

