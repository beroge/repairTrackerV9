<?php

/***************************************************************************
 *   copyright            : (C) 2012 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/


require_once("validate.php");

require("common.php");

$gotouri = $_REQUEST['gotouri'];

$useripaddy = $_SERVER['REMOTE_ADDR'];
$useragent = $_SERVER['HTTP_USER_AGENT'];

userlog(30,'','',pcrtlang("Logged In From")." $useripaddy | $useragent");

header("Location: $gotouri");



?>
