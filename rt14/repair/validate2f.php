<?php

/***************************************************************************
 *   copyright            : (C) 2020 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/

include("deps.php");
$validated = false;

if(isset($_SESSION["username2fa"])) {
if (array_key_exists($_SESSION["username2fa"], $passwords)) {
$validated = true;
}
}

if($validated) {
//Ok; don.t need to do anything
} else {
//Make user go to login page

$ruri = urlencode($_SERVER['REQUEST_URI']);


header("Location: ../repair/login.php?RURI=$ruri&METHOD=$_SERVER[REQUEST_METHOD]");
exit;
}
?>
