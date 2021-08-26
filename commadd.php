<?php

/**
 * Class: csci303fa20
 * User: Dalton
 * Date: 11/12/2020
 * Time: 10:59 PM
 */
 
 //Initial Variables
$showform = 1;
$errmsg = 0;
$errcname = "";
$errlocation = "";
$errdescription = "";
$pagename = "Add Community";

require_once 'includes/header.php';

checkLogin();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $cname = $_POST['cname'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $tagID = $_POST['tag'];

    //Check empty Fields
    if (empty($cname)) {
        $errmsg = 1;
        $errcname = "Please enter community name";
    }
    if (empty($location)) {
        $errmsg = 1;
        $errlocation = "Please enter community location";
    }
    if (empty($description)) {
        $errmsg = 1;
        $errdescription = "Please enter a description";
    }

    //Check for duplicates
    //Community name
    $sql = "SELECT * FROM communities WHERE cname = ?";
    $cnameexists = checkdup($pdo, $sql, $cname);
    if ($cnameexists) {
        $errmsg = 1;
        $errcname = "Community has already been entered";
    }

    //Control Form
    if ($errmsg == 1) {
        echo "<p class='error'>There is an issue with the information you added, please review and try again!</p>";
        $showform = 1;
    } else {
        echo "<p class='success'>The community has been added to the forum!</p>";

        //Insert into DB
        try {

            $sqlquery = "INSERT INTO communities (FK_ID, FK_tagID, cname, location, description, commdate) VALUES (:FK_ID, :FK_tagID, :cname, :location, :description, :commdate)";
            $sqlinsert = $pdo->prepare($sqlquery);
            $sqlinsert->bindValue(':FK_ID', $_SESSION['ID']);
            $sqlinsert->bindValue(':FK_tagID', $tagID);
            $sqlinsert->bindValue(':cname', $cname);
            $sqlinsert->bindValue(':location', $location);
            $sqlinsert->bindValue(':description', $description);
            $sqlinsert->bindValue(':commdate', date('Y-m-d H:i:s'));
            $sqlinsert->execute();

            $showform = 0;
        }
        catch (PDOException $e)
        {
            echo 'Error Inserting' .$e->getMessage();
            include 'includes/footer.php';
            exit();
        }
    }
}


if ($showform == 1) {
    ?>
<form method="post" action="<?php echo $currentfile;?>" id="commadd" name="commadd">
    <fieldset>
        <legend>Add Community:</legend>
        <label for="cname">Enter Community Name: </label>
        <input type="text" name="cname" id="cname" placeholder="Community Name"
               value="<?php if (isset($cname)) {echo htmlspecialchars($cname, ENT_QUOTES, "UTF-8");}?>">
        <?php if (!empty($errcname)) {echo "<span class='error'>$errcname</span>";} ?><br>
        <label for="location">Location of Community: </label>
        <input type="text" name="location" id="location" placeholder="Community Location"
        value="<?php if (isset($location)) {echo htmlspecialchars($location, ENT_QUOTES, "UTF-8");}?>">
        <?php if (!empty($errlocation)) {echo "<span class='error'>$errlocation</span>";} ?><br>
        <label for="description">Description of Community: </label>
        <textarea name="description" id="description" form="commadd" placeholder="Enter Description Here..."></textarea>

        <label for="tag">Choose a Tag: </label>
        <select name="tag" id="tag">
            <?php
            $sql = "SELECT * FROM tags ORDER BY tagname ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($result as $row) {
                echo "<option value='" . $row['tagID'] . "'>" . $row['tagname'] . "</option>";

            }
            ?>
        </select><br>



        <input type="submit" id="commsubmit" value="Submit">
    </fieldset>
</form>

<?php }//End of showform

require_once 'includes/footer.php';