<?php

/**
 * Class: csci303fa20
 * User: Dalton
 * Date: 11/9/2020
 * Time: 11:14 PM
 */
 
 $pagename = "User Update";
 require_once 'includes/header.php';

 checkLogin();

//Initial Variables
$showform = 1;
$errmsg = 0;
$errfname = "";
$errlname = "";
$erruname = "";
$erremail = "";

//Tracking the ID
if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['q'])) {
    $ID = $_GET['q'];
}
elseif($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['ID'])) {
    $ID = $_POST['ID'];
}
else {
    echo "<p class='error'>Could not find entry</p>";
    $errmsg = 1;
}

//Form Processing
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //Sanatize data
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $uname = trim(strtolower($_POST['uname']));
    $num = $_POST['num'];
    $email = trim(strtolower($_POST['email']));
    $ID = $_POST['ID'];




    //Error Checking
    if (empty($fname)) {
        $errmsg = 1;
        $errfname = "Missing First Name";
    }
    if (empty($lname)) {
        $errmsg = 1;
        $errlname = "Missing First Name";
    }
    if (empty($uname)) {
        $errmsg = 1;
        $erruname = "Missing First Name";
    }
    if (empty($email)) {
        $errmsg = 1;
        $erremail = "Missing Email";
    }

    else {
        //Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errmsg = 1;
            $erremail = "Email is not valid";
        }
        //Check for duplicate email
        elseif($email != $_POST['origemail']) {
            $sql = "SELECT * FROM registeredUsers WHERE email = ?";
            $emailexists = checkdup($pdo, $sql, $email);
            if ($emailexists) {
                $errmsg = 1;
                $erremail = "This email is already taken";
            }
        }
        //Check for duplicate username
        elseif ($uname != $_POST['origuname']) {
            $sql = "SELECT * FROM registeredUsers WHERE uname = ?";
            $unameexists = checkdup($pdo, $sql, $uname);
            if ($unameexists) {
                $errmsg = 1;
                $erruname = "This username is already taken";
            }
        }
    }

//Program Control
    if ($errmsg == 1) {
        echo "<p class='error'>There are errors with the form, please try making changes.</p>";
    }
    else {
        echo "<p class='success'>Thank you for updating your information.</p>";





        //Update DB (ALL)
            $sql = "UPDATE registeredUsers SET fname = :fname, lname = :lname, uname = :uname, num = :num, email = :email WHERE ID = :ID";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':fname', $fname);
            $stmt->bindValue(':lname', $lname);
            $stmt->bindValue(':uname', $uname);
            $stmt->bindValue(':num', $num);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':ID', $ID);
            $stmt->execute();


            $showform = 0;

    }
}



//Show Form
if ($showform == 1) {
    //Query the DB
    $sql = "SELECT * FROM registeredUsers WHERE ID = :ID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':ID', $ID);
    $stmt->execute();
    $row = $stmt->fetch();
    ?>
<p>Phone number is not required.</p>
<form name="update" id="update" action="<?php echo $currentfile;?>" method="post" enctype="multipart/form-data">
    <label for="fname">First Name: </label>
    <input type="text" name="fname" id="fname" placeholder="First Name"
           value="<?php if (isset($fname)) {echo htmlspecialchars($fname);} else{echo htmlspecialchars($row['fname']);}?>">
    <?php if (!empty($errfname)) {echo "<span class='error'>$errfname</span>";} ?><br>
    <label for="lname">Last Name: </label>
    <input type="text" name="lname" id="lname" placeholder="Last Name"
           value="<?php if (isset($lname)) {echo htmlspecialchars($lname);} else{echo htmlspecialchars($row['lname']);}?>">
    <?php if (!empty($errlname)) {echo "<span class='error'>$errlname</span>";} ?><br>
    <label for="uname">Username: </label>
    <input type="text" name="uname" id="uname" placeholder="Username"
           value="<?php if (isset($uname)) {echo htmlspecialchars($uname);} else{echo htmlspecialchars($row['uname']);}?>">
    <?php if (!empty($erruname)) {echo "<span class='error'>$erruname</span>";} ?><br>
    <label for="num">Phone Number:</label>
    <input type="tel" name="num" id="num" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" placeholder="111-222-3333"
            value="<?php if (isset($num)) {echo htmlspecialchars($num);} else{echo htmlspecialchars($row['num']);}?>"><br>
    <label for="email">Email: </label>
    <input type="email" id="email" name="email" placeholder="Enter Email"
           value="<?php if (isset($email)) {echo htmlspecialchars($email);} else{echo htmlspecialchars($row['email']);}?>">
    <?php if (!empty($erremail)) {echo "<span class='error'>$erremail</span>";}?><br>


    <br>
    <?php
    //Update Profile Button
    echo "<a href='addprofile.php?q=" . $row['ID'] . "'>Update Profile Picture</a></p>";?>


    <input type="hidden" name="ID" value="<?php echo $row['ID'];?>">
    <input type="hidden" name="origemail" value="<?php echo $row['email'];?>">
    <input type="hidden" name="origuname" value="<?php echo $row['uname'];?>">
    <label for="submit">Submit</label>
    <input type="submit" id="submit" name="submit" value="UPDATE">
</form>
    <?php
}//Show form
    require_once 'includes/footer.php';