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

if(isset($_SESSION["username"])) {
if (array_key_exists($ipofpc, $passwords)) {
$validated = true;
}
}

if($validated) {
//Ok - continue
} else {
//Go to login page

die("<a href=../repairmobile/login.php class=\"linkbuttonmedium linkbuttongray radiusall\">please login</a>");


exit;
}

