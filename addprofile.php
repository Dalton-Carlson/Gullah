<?php

/**
 * Class: csci303fa20
 * User: Dalton
 * Date: 11/14/2020
 * Time: 11:51 AM
 */
 
 $pagename = "Add Profile Picture";
 require_once "includes/header.php";

 //Initial Variables
$showform = 1;
$errmsg = 0;
$errfile = "";
$ID = $_SESSION['ID'];

checkLogin();

//Tracking the ID
if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['q'])) {
    $ID = $_GET['q'];
}
elseif($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['ID'])) {
    $ID = $_POST['ID'];
}
else {
    //echo "<p class='error'>Could not find entry</p>";
    //$errmsg = 1;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {


//File Error Checking
    if ($_FILES['myfile']['error'] == 0) {
        //Pathinfo to isolate filename
        $userfile = $_FILES['myfile']['name'];
        $pathparts = pathinfo($userfile);

        //Finalizing File name and File path
        $extension = strtolower($pathparts['extension']);
        $finalfile = $_SESSION['uname'] . "_" . $userfile;
        echo "<p><strong>Final File Name: </strong>" . $finalfile . "</p>";
        $workingfile = "/var/www/html/uploads/" . $finalfile;

        //Check for duplicate file names
        if (file_exists($workingfile)) {
            $errmsg = 1;
            $errfile = "File already exists";
        }

        //Check if file is an image
        if ($extension != "gif" && $extension != "jpg" && $extension != "jpeg" && $extension != "png") {
            $errmsg = 1;
            $errfile = "File is not an image";
        } else {
            //Check file size
            $imginfo = getimagesize($_FILES['myfile']['tmp_name']);
            if ($imginfo[0] > 250 || $imginfo[1] > 250) {
                $errmsg = 1;
                $errfile = "Image is too big";
            }
        }
        if ($errmsg == 1) {
            echo "<p class='error'>That didn't work</p>";
        }else {
            echo "<p class='success'>Your profile picture has been updated.</p>";

            //Try to move files
            if (!move_uploaded_file($_FILES['myfile']['tmp_name'], $workingfile)) {
                echo "<p class='error'>Could not move file.</p>";
            } else {
                echo "<p class='success'>Your file has been uploaded<br>";
                echo "You can view your file at ";
                echo "<a href='/uploads/" . $finalfile . "' target='_blank'>" . $finalfile . "</a></p>";
            }

            //Update DB
            $sql = "UPDATE registeredUsers SET profilepic = :profilepic WHERE ID = :ID";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':profilepic', $finalfile);
            $stmt->bindValue(':ID', $ID);
            $stmt->execute();


            $showform = 0;
        }
    }
}

if ($showform == 1) {
    //Query the DB
    $sql = "SELECT * FROM registeredUsers WHERE ID = :ID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':ID', $ID);
    $stmt->execute();
    $row = $stmt->fetch();
    ?>
    <p>*Submitting without inserting a file will reset your profile picture to the default image</p>
<form name="updateprof" id="updateprof" action="<?php echo $currentfile;?>" method="post" enctype="multipart/form-data">
    <label for="profilepic">Profile Picture:</label>
    <input type="file" name="myfile" id="myfile"
           value ="<?php if (isset($profilepic)) {echo "<img src='/uploads/" . $row['profilepic'] . "' alt='Profile picture for " . $row['uname'] . "' class='profile'>";}?>">
    <?php if (!empty($errfile)) {echo "<span class='error'>$errfile</span>";}?>
    <br><label for="submit">Submit</label>
    <input type="submit" id="submit" name="submit" value="UPDATE">
</form>
<?php
}//Showform End
    require_once "includes/footer.php";
