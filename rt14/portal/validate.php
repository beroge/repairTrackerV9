<?php

/***************************************************************************
 *   copyright            : (C) 2017 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/


include("deps.php");
$validated = false;

if(isset($_SESSION["portallogin"])) {
$loginemail = $_SESSION["portallogin"];
$rs_chk_group = "SELECT * FROM pc_group WHERE grpemail = '$loginemail'";
$checkforgroup = @mysqli_query($rs_connect, $rs_chk_group);
if (mysqli_num_rows($checkforgroup) != "0") {
$validated = true;
}
}


if($validated) {
//Ok - continue
} else {
//Go to login page

header("Location: login.php");
exit;
}
