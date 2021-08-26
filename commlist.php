<?php

/**
 * Class: csci303fa20
 * User: Dalton
 * Date: 11/13/2020
 * Time: 9:36 PM
 */

$pagename = "Community Management";
require_once "includes/header.php";

//Query the Database
$sql = "SELECT * FROM communities ORDER BY cname ASC";

//Execute Query
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Display Results
foreach ($result as $row) {
    echo "<p" . $row['commID'] . "'><strong>" . $row['cname'] . "</strong>";?>
    &vert; <?php
    echo "<a href='commdetails.php?q=" . $row['commID'] . "'>View</a></p>";?>
    <?php
}

require_once "includes/footer.php";