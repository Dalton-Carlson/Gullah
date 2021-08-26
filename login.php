<?php

/**
 * Class: csci303fa20
 * User: Dalton
 * Date: 10/20/2020
 * Time: 1:25 PM
 */

//Include header file
$showform = 1;
$errmsg = 0;
$erruname = "";
$errpass = "";
$pagename = "Login Page";
require_once "includes/header.php";

//Check is user is logged in
if(isset($_SESSION['ID'])) {
    echo "<p class='error'>You are already logged in.</p>";
    include_once "includes/footer.php";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
//Cleanse the data
    $formfield['logUser'] = trim(strtolower($_POST['logUser']));
    $formfield['logPass'] = $_POST['logPass'];
//Check for empty fields
    if (empty($formfield['logUser'])) {
        $errmsg = 1;
        $erruname = "Missing username.";
    }
    if (empty($formfield['logPass'])) {
        $errmsg = 1;
        $errpass = "Missing password.";
    }
//Display Error
    if ($errmsg != "") {
        echo "<p class='error'>There seems to be a problem with the information you entered. Please try again.</p>";
    }
    //Get User from DB
    try {
        $sqllogin = "SELECT * FROM registeredUsers WHERE uname = :uname";
        $slogin = $pdo->prepare($sqllogin);
        $slogin->bindValue(':uname', $formfield['logUser']);
        $slogin->execute();
        $rowlogin = $slogin->fetch();
        $countlogin = $slogin->rowCount();

        //See results
        if ($countlogin < 1) {
            $errmsg = 1;
            $erruname = "This username cannot be found.";
        }
        else {
            if(password_verify($formfield['logPass'],$rowlogin['pass']))
            {
                $_SESSION['ID'] = $rowlogin['ID'];
                $_SESSION['fname'] = $rowlogin['fname'];
                $_SESSION['uname'] = $rowlogin['uname'];
                $_SESSION['status'] = $rowlogin['status'];
                $_SESSION['profilepic'] = $rowlogin['profilepic'];
                $showform = 0;
                header("Location: confirm.php?state=2");
            }
            else {
                $errmsg = 1;
                $errpass = "Incorrect username and password combination.";
            }
        }
    }//try
    catch (PDOException $e)
    {
        echo 'Error fecthing user' .$e->getMessage();
        include 'includes/footer.php';
        exit();
    }
}

if ($showform == 1) {
?>
<p>Enter your username and password to login.</p>
<form name="loginForm" id="loginForm" method="post" action="login.php">
    <fieldset>
        <legend>Login Here</legend>
        <label for="logUser">Enter Username:</label>
        <input type="text" name="logUser" id="logUser" placeholder="Username"
            value="<?php if (isset($formfield['logUser'])) {echo htmlspecialchars($formfield['logUser'], ENT_QUOTES, "UTF-8");}?>">
        <?php if (!empty($erruname)) {echo "<span class='error'>$erruname</span>";}?><br>
        <label for="logPass">Enter Password:</label>
        <input type="password" name="logPass" id="logPass" placeholder="Password">
        <?php if (!empty($errpass)) {echo "<span class='error'>$errpass</span>";}?><br>
        <input type="submit" id="logSubmit" value="Login">
    </fieldset>
</form><br>
<?php }// End of showform
//Include footer file
require_once "includes/footer.php";
?>