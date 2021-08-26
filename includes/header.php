<?php

/**
 * Class: csci303fa20
 * User: Dalton
 * Date: 9/18/2020
 * Time: 7:46 PM
 */

session_start();

//Error Reporting
error_reporting(E_ALL);
ini_set('display_errors','1');

//Current File
$currentfile = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dalton Carlson</title>
    <link rel="stylesheet" href="includes/styles.css">
    <?php require_once "functions.php";?>
    <?php require_once "connect.php";?>
    <script src="https://cdn.tiny.cloud/1/5o7mj88vhvtv3r2c5v5qo4htc088gcb5l913qx5wlrtjn81y/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
</head>
<body>
<div class="upperhead">
    <h1>Gullah Geechee Communities</h1>
    <h2><?php echo $pagename; ?></h2>
    <nav>
        <ul>
        <?php
        echo ($currentfile == 'index.php') ? "<li>Home</li>" : "<li><a href='index.php'>Home</a></li>";
        if(!isset($_SESSION['ID'])){echo ($currentfile == 'program3.php') ? "<li>Sign-Up</li>" : "<li><a href='program3.php'>Sign-Up</a></li>";}
        echo ($currentfile == 'commlist.php') ? "<li>Communities</li>" : "<li><a href='commlist.php'>Communities</a></li>";
        if(!isset($_SESSION['ID'])){echo ($currentfile == 'login.php') ? "<li>Login</li>" : "<li><a href='login.php'>Login</a></li>";}
        if(isset($_SESSION['ID'])){echo ($currentfile == 'userlist.php') ? "<li>User Dashboard</li>" : "<li><a href='userlist.php'>User Dashboard</a></li>";}
        if(isset($_SESSION['ID'])){echo ($currentfile == 'contmanagement.php') ? "<li>Community Management</li>" : "<li><a href='contmanagement.php'>Community Management</a></li>";}
        if(isset($_SESSION['ID']) && $_SESSION['status'] == 1){echo ($currentfile == 'admin.php') ? "<li>Admin Page</li>" : "<li><a href='admin.php'>Admin Page</a></li>";}
        if(isset($_SESSION['ID'])){echo ($currentfile == 'logout.php') ? "<li>Logout</li>" : "<li><a href='logout.php'>Logout</a></li>";}

        //Search
        ?>  <div class="search">
            <form name="search" id="search" action="search.php" method="post">
                <input type="text" name="search" id="search" placeholder="Search Communities or Locations...">
                <input type="submit" value=">>">
            </form>
            </div>
            </ul>
    </nav>
</div>

