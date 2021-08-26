<?php

/**
 * Class: csci303fa20
 * User: Dalton
 * Date: 10/6/2020
 * Time: 1:15 PM
 */

//Include header file
$showform = 1;
$errmsg = 0;
$errfname = "";
$errlname = "";
$erruname = "";
$erremail= "";
$errpass = "";
$errpass2 = "";
$errconf = "";
$pagename = "Register";
require_once "includes/header.php";
?>
<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //Sanitize Data
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $uname = trim(strtolower($_POST['uname']));
    $num = $_POST['num'];
    $email = trim(strtolower($_POST['email']));
    $pass = $_POST['pass'];
    $pass2 = $_POST['confirmpass'];


    //Check empty fields
    if (empty($fname)) {
        $errmsg = 1;
        $errfname = "Missing First Name";
    } else {
        //URL & E-mail Validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errmsg = 1;
            $erremail = "Please use a valid e-mail";
        }
    }
    if (empty($lname)) {
        $errmsg = 1;
        $errlname = "Missing Last Name";
    }
    if (empty($uname)) {
        $errmsg = 1;
        $erruname = "Missing User Name";
    }
    if (empty($email)) {
        $errmsg = 1;
        $erremail = "Missing E-mail";
    }
    if (empty($pass)) {
        $errmsg = 1;
        $errpass = "Missing Password";
    }
    if (empty($pass2)) {
        $errmsg = 1;
        $errpass2 = "Missing Confirmation Password";
    }
    if ($pass != $pass2) {
        $errmsg = 1;
        $errconf = "Passwords do not match";
    }

    //Check for duplicates
//Email
    $sql = "SELECT * FROM registeredUsers WHERE email = ?";
    $emailexists = checkdup($pdo, $sql, $email);
    if ($emailexists) {
        $errmsg = 1; //update the general error flag
        $erremail .= " This email is already being used.";
    }
//Username
    $sql = "SELECT * FROM registeredUsers WHERE uname = ?";
    $unameexists = checkdup($pdo, $sql, $uname);
    if ($unameexists) {
        $errmsg = 1; //update the general error flag
        $erruname .= " This username is already taken.";
    }

    //Control for form
    if ($errmsg == 1) {
        echo "<p class='error'>Uh-oh! Looks like there are some errors on your form. Try resetting the form and trying again!</p>";
        $showform = 1;
    }
    else {
        echo "<p class='success'>Perfect! Thank you for registering to our website!</p>";
        $hashpass = password_hash($pass, PASSWORD_DEFAULT);

        //Insert into DB
        try {
            $sqlquery = "INSERT INTO registeredUsers (fname, lname, uname, num, email, pass, dateadded) VALUES (:fname, :lname, :uname, :num, :email, :pass, :dateadded)";
            $sqlinsert = $pdo->prepare($sqlquery);
            $sqlinsert->bindValue(':fname', $fname);
            $sqlinsert->bindValue(':lname', $lname);
            $sqlinsert->bindValue(':uname', $uname);
            $sqlinsert->bindValue(':num', $num);
            $sqlinsert->bindValue(':email', $email);
            $sqlinsert->bindValue(':fname', $fname);
            $sqlinsert->bindValue(':pass', $hashpass);
            $sqlinsert->bindValue(':dateadded', date('Y-m-d H:i:s'));
            $sqlinsert->execute();

            //Send Email
            $emailmsg = '<p style="color:purple">Welcome ' . $fname . '! Thank you for registering for the Gullah Geechee Communities Website.</p>';
            $emailsubject = 'GGC Registration Confirmation';
            require_once 'includes/phpmailer';

            //Successfully executed
            echo "<p>'Great!'</p>";
            $showform = 0;


        }
        catch (PDOException $e)
        {
            echo 'Error inserting' .$e->getMessage();
            include 'includes/footer.php';
            exit();
        }
    }

}
if ($showform == 1) {
    ?>
    <form method="POST" action="<?php echo $currentfile; ?>" id="register" name="register">
        <fieldset>
            <legend>Registration Form</legend>
            <p>Star sign (*) = Required field</p>
            <label for="fname">Enter First Name: *</label>
            <input type="text" name="fname" id="fname" placeholder="First Name"
                   value="<?php if (isset($fname)) {echo htmlspecialchars($fname, ENT_QUOTES, "UTF-8");}?>">
            <?php if (!empty($errfname)) {echo "<span class='error'>$errfname</span>";} ?><br>
            <label for="lname">Enter Last Name: *</label>
            <input type="text" name="lname" id="lname" placeholder="Last Name"
                   value="<?php if (isset($lname)) {echo htmlspecialchars($lname, ENT_QUOTES, "UTF-8");}?>">
            <?php if (!empty($errlname)) {echo "<span class='error'>$errlname</span>";} ?><br>
            <label for="uname">Enter Username: *</label>
            <input type="text" name="uname" id="uname" placeholder="Username"
                   value="<?php if (isset($uname)) {echo htmlspecialchars($uname, ENT_QUOTES, "UTF-8");}?>">
            <?php if (!empty($erruname)) {echo "<span class='error'>$erruname</span>";} ?><br>
            <label for="num">Enter Phone Number:</label>
            <input type="tel" name="num" id="num" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" placeholder="111-222-3333"><br>
            <label for="email">Enter E-mail: *</label>
            <input type="email" name="email" id="email" placeholder="E-mail Address"
                   value="<?php if (isset($email)) {echo htmlspecialchars($email, ENT_QUOTES, "UTF-8");}?>">
            <?php if (!empty($erremail)) {echo "<span class='error'>$erremail</span>";} ?><br>
            <label for="pass">Create Password (minimum of 8 characters): *</label>
            <input type="password" name="pass" id="pass" minlength="8" placeholder="Password">
            <?php if (!empty($errpass)) {echo "<span class='error'>$errpass</span>";} ?>
            <?php if (!empty($errconf)) {echo "<span class='error'>$errconf</span>";} ?><br>
            <label for="confirmpass">Confirm Password:</label>
            <input type="password" name="confirmpass" id="confirmpass" minlength="8" placeholder="Confirm Password">
            <?php if (!empty($errpass2)) {echo "<span class='error'>$errpass2</span>";} ?>
            <?php if (!empty($errconf)) {echo "<span class='error'>$errconf</span>";} ?><br>
            <input type="submit" id="submit" value="Register">
        </fieldset>
    </form>
<?php }// End of showform
//Include footer file
require_once "includes/footer.php";
?>