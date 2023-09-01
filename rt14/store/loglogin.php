<?php

/***************************************************************************
 *   copyright            : (C) 2020 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/


require_once("validate.php");

require("deps.php");
require("common.php");

$gotouri = $_REQUEST['gotouri'];

$useripaddy = $_SERVER['REMOTE_ADDR'];
$useragent = $_SERVER['HTTP_USER_AGENT'];

userlog(30,'','',pcrtlang("Logged In From")." $useripaddy | $useragent");


$check1sql = "SELECT cashchange2 FROM deposits";
$check1 = mysqli_query($rs_connect, $check1sql);
if(!$check1) {
@mysqli_query($rs_connect, "ALTER TABLE deposits ADD cashchange2 TEXT NOT NULL");
}

$check2sql = "SELECT wocheckstime FROM pc_wo";
$check2 = mysqli_query($rs_connect, $check2sql);
if(!$check2) {
@mysqli_query($rs_connect, "ALTER TABLE pc_wo ADD wocheckstime DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER wochecks");
}



@mysqli_query($rs_connect, "UPDATE messages SET mediaurls = '' WHERE mediaurls LIKE '%photoid=0%'");


header("Location: $gotouri");



?>
