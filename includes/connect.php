<?php

/**
 * Class: csci303fa20
 * User: Dalton
 * Date: 10/6/2020
 * Time: 12:26 PM
 */

$dsn = "mysql:host=localhost;dbname=303dacarlson";
$user = "303dacarlson";
$dbpwd = "csci1078";
$pdo = new PDO($dsn,$user,$dbpwd);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
