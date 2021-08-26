<?php

/**
 * Class: csci303fa20
 * User: Dalton
 * Date: 10/20/2020
 * Time: 12:34 PM
 */

$pagename = "User Details";
require_once "includes/header.php";

checkLogin();
$sql = "SELECT * FROM registeredUsers WHERE ID = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $_GET['q']);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

//Display User Info
echo "<p><strong>Profile Picture: </strong></p>";

//Display Profile Pic
if (is_null($row['profilepic'])) {
    echo "<img src='../includes/defaultpic.jpg' alt='Default Profile Picture' class='profile'>";
} else {
    echo "<img src='/uploads/" . $row['profilepic'] . "' alt='Profile picture for " . $row['uname'] . "' class='profile'>";
}
echo "<p><strong>ID Number: </strong>" . $_GET['q'] . ".</p>";
echo "<p><strong>Username: </strong>" . $row['uname'] . ".</p>";
echo "<p><strong>Full Name: </strong>" . $row['fname'] . " " . $row['lname'] . ".</p>";
echo "<p><strong>E-mail: </strong>" . $row['email'] . ".</p>";
echo "<p><strong>Number: </strong>" . $row['num'] . "</p>";
echo "<p><strong>Admin Status: </strong>"; if($row['status'] != 1) {echo "Not an admin.</p>";} else{echo "Admin. </p>";}?>
<?php //echo "<p><strong>Date Registered: </strong>" . $row['dateadded'] . ".</p>";


?>

    <br>
<?php

require_once "includes/footer.php";