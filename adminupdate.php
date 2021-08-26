<?php

/**
 * Class: csci303fa20
 * User: Dalton
 * Date: 11/24/2020
 * Time: 11:32 AM
 */

$pagename="Admin Update";
require "includes/header.php";
checkAdmin();
$errmsg = "";
$showform = 1;


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($_POST['status'] == 1){
        echo "<p class='error'>This user is already an admin.</p>";
        $showform = 0;
    }
    else {
        $_POST['status'] = 1;
        //Query
        $sql = "UPDATE registeredUsers SET status = :status WHERE ID = :ID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':status', $_POST['status']);
        $stmt->bindValue(':ID', $_POST['ID']);
        $stmt->execute();
        //Confirm for User
        echo "<p>User <strong>" . $_POST['uname'] . "</strong> has been made an admin.</p>";
        //Hide form
        $showform = 0;
    }
    }


if ($showform == 1) {
    //Query the DB
    $sql = "SELECT * FROM registeredUsers WHERE ID = :ID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':ID', $_GET['q']);
    $stmt->execute();
    $row = $stmt->fetch();
    ?>
    <p>Are you sure you want to make <strong><?php echo $row['uname']; ?></strong> an admin?</p>
    <form id="updateadmin" name="updateadmin" action="<?php echo $currentfile;?>" method="post">
        <input type="hidden" id="status" name="status" value="<?php echo $row['status']; ?>">
        <input type="hidden" id="uname" name="uname" value="<?php echo $row['uname']; ?>">
        <input type="hidden" id="ID" name="ID" value="<?php echo $_GET['q']; ?>">

        <input type="submit" id="adminconf" name="adminconf" value="YES">
        <input type="button" id="noadmin" name="noadmin" value="NO" onclick="document.location='admin.php'">
    </form>

    <?php
}//End show form
require_once "includes/footer.php";