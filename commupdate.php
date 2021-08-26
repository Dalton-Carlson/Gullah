<?php

/**
 * Class: csci303fa20
 * User: Dalton
 * Date: 11/13/2020
 * Time: 10:41 AM
 */
 
 $pagename = "Edit Content";
 require_once "includes/header.php";

 checkLogin();

 //Initial Variables
$showform = 1;
$errmsg = 0;
$errcname = "";
$errlocation = "";
$errdescription = "";

//Tracking the ID
if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['q'])) {
    $commID = $_GET['q'];
}
elseif($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['commID'])) {
    $commID = $_POST['commID'];
}
else {
    echo "<p class='error'>Could not find entry</p>";
    $errmsg = 1;
}

//Form Processing
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //Sanatize data
    $cname = $_POST['cname'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    //Error Checking
    if (empty($cname)) {
        $errmsg = 1;
        $errcname = "Missing Community Name";
    }
    if (empty($location)) {
        $errmsg = 1;
        $errlocation = "Missing Community Location";
    }
    if (empty($description)) {
        $errmsg = 1;
        $errdescription = "Please provide a description of the community";
    }

    //Check Duplicates
    if ($cname != $_POST['origcname']) {
        $sql = "SELECT * FROM communities WHERE cname = ?";
        $cnameexists = checkdup($pdo, $sql, $cname);
        if ($cnameexists) {
            $errmsg = 1;
            $errcname = "Community name has already been added";
        }
    }
    elseif ($description != $_POST['origdescription']) {
        $sql = "SELECT * FROM communities WHERE description = ?";
        $descriptionexists = checkdup($pdo, $sql, $description);
        if ($descriptionexists) {
            $errmsg = 1;
            $errdescription = "This exact description has already been used, please try something new";
        }
    }

    //Program Control
    if ($errmsg == 1) {
        echo "<p class='error'>There are errors with the information you added, please try again</p>";
    }
    else {
        echo "<p class='success'>Thank you! We have added the community to the forum, go take a look!</p>";

        //Update DB
        $sql = "UPDATE communities SET cname =:cname, location = :location, description = :description, dateupdated = :dateupdated WHERE commID = :commID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':cname', $cname);
        $stmt->bindValue(':location', $location);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':commID', $commID);
        $stmt->bindValue(':dateupdated', date('Y-m-d H:i:s'));
        $stmt->execute();

        $showform = 0;

    }


}//Server POST END



//Show Form
if ($showform == 1) {
    //Query the DB
    $sql = "SELECT * FROM communities WHERE commID =:commID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':commID', $commID);
    $stmt->execute();
    $row = $stmt->fetch();
    ?>
<form method="post" action="<?php echo $currentfile;?>" id="commupdate" name="commupdate">
    <fieldset>
        <legend>Add Community:</legend>
        <label for="cname">Enter Community Name: </label>
        <input type="text" name="cname" id="cname" placeholder="Community Name"
               value="<?php if (isset($cname)) {echo htmlspecialchars($cname);} else{echo htmlspecialchars($row['cname']);}?>">
        <?php if (!empty($errcname)) {echo "<span class='error'>$errcname</span>";} ?><br>
        <label for="location">Location of Community: </label>
        <input type="text" name="location" id="location" placeholder="Community Location"
               value="<?php if (isset($location)) {echo htmlspecialchars($location);} else{echo htmlspecialchars($row['location']);}?>">
        <?php if (!empty($errlocation)) {echo "<span class='error'>$errlocation</span>";} ?><br>
        <label for="description">Description of Community: </label>
        <textarea name="description" id="description" form="commupdate" placeholder="Enter Description Here...">
            <?php if (isset($location)) {echo htmlspecialchars($description);} else{echo htmlspecialchars($row['description']);}?>
        </textarea>
        <input type="submit" id="commsubmit" value="Submit">

        <br>
        <input type="hidden" name="commID" value="<?php echo $row['commID'];?>">
        <input type="hidden" name="origcname" value="<?php echo $row['cname'];?>">
        <input type="hidden" name="origlocation" value="<?php echo $row['location'];?>">
        <input type="hidden" name="origdescription" value="<?php echo $row['description'];?>">
    </fieldset>
</form>
    <?php
}//Show form
    require_once "includes/footer.php";