<?php

/**
 * Class: csci303fa20
 * User: Dalton
 * Date: 11/26/2020
 * Time: 12:50 PM
 */
 
$pagename = "Create Tags";
$errmsg = 0;
$errtag = "";
$showform = 1;

require_once 'includes/header.php';

checkLogin();
checkAdmin();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $tagname = trim(strtolower($_POST['tagname']));

    if (empty($tagname)) {
        $errmsg = 1;
        $errtag = "Please enter a tag name";
    }
    $sql = "SELECT * FROM tags WHERE tagname = ?";
    $tagnameexists = checkdup($pdo, $sql, $tagname);
    if ($tagnameexists) {
        $errmsg = 1;
        $errtag = "This tag name already exists";
    }

    if ($errmsg == 1) {
        echo "<p class='error'>There are errors with the form.</p>";
    }
    else {
        echo "<p>The tag has been successfully added</p>";

        try {
            $sqlquery = "INSERT INTO tags (tagname) VALUE (:tagname)";
            $sqlinsert = $pdo->prepare($sqlquery);
            $sqlinsert->bindValue(':tagname', $tagname);
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
    <form method="post" action="<?php echo $currentfile;?>" id="addtag" name="addtag">
        <label for="tagname">Tag Name: </label>
        <input type="text" name="tagname" id="tagname" placeholder="Tag Name...">
        <?php if (!empty($errtag)) {echo "<span class='error'>$errtag</span>";} ?><br>
        <input type="submit" id="tagsubmit" value="Add Tag">
    </form>

<?php
} //End showform
require_once 'includes/footer.php';