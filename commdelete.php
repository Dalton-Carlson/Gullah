<?php

/**
 * Class: csci303fa20
 * User: Dalton
 * Date: 11/17/2020
 * Time: 12:23 PM
 */
 

 //Set Initial Variables
$showform = 1;
$pagename = "Delete";

require_once "includes/header.php";
checkLogin();


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //Query
    $sql = "DELETE FROM communities WHERE cname = :cname";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':cname', $_POST['cname']);
    $stmt->execute();
    //Confirm for User
    echo "<p>Entry <strong>" . $_POST['cname'] . "</strong> has been deleted.</p>";
    //Hide form
    $showform = 0;
}

if ($showform == 1) {
?>
<p>Are you sure you want to delete <?php echo $_GET['C']; ?> ?</p>
    <form id="deletecomm" name="deletecomm" action="<?php echo $currentfile;?>" method="post">
        <input type="hidden" id="commID" name="commID" value="<?php echo $_GET['q']; ?>">
        <input type="hidden" id="cname" name="cname" value="<?php echo $_GET['C']; ?>">

        <input type="submit" id="delete" name="delete" value="YES">
        <input type="button" id="nodelete" name="nodelete" value="NO" onclick="document.location='contmanagement.php'">
    </form>

<?php
}//End show form
    require_once "includes/footer.php";