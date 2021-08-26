<?php

/**
 * Class: csci303fa20
 * User: Dalton
 * Date: 11/16/2020
 * Time: 6:58 PM
 */
 
 $pagename = "Search Results";

 require_once "includes/header.php";
?><br>
<?php
 //$showform = 1;

 if (isset($_POST['search'])) {
     $search = ($_POST['search']);

     $sql = "SELECT * FROM communities WHERE cname LIKE '%" . $search . "%' ";
     $stmt = $pdo->prepare($sql);
     $stmt->bindValue(':commID', $_POST['search']);
     $stmt->execute();
     $result = $stmt->fetchAll();

     foreach ($result as $row) {
         echo "<strong>" . $row['cname'] . "</strong> &vert; ";
         echo "<a href='commdetails.php?q=" . $row['commID'] . "'> View Community</a><br>";
     }

     require_once "includes/footer.php";
 }

/**
 if ($showform == 1) {
     ?>
    <form name="search" id="search" action="search.php" method="post">
        <input type="text" name="search" id="search" placeholder="Search Communities or Locations...">
        <input type="submit" value=">>">
    </form>
    <?php
        }//Show form end
    require_once "includes/footer.php";
*/