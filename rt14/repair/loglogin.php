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

#Build Allowed IP Address List
$rs_qip = "SELECT ipid,ipaddress FROM allowedip";
$rs_result1ip = mysqli_query($rs_connect, $rs_qip);
$ips = array();
while($rowi = mysqli_fetch_array($rs_result1ip)) {
$aipid = $rowi['ipid'];
$aipaddress = $rowi['ipaddress'];
$ips[$aipid]=$aipaddress;
}

#Insert New/Update Allowed IP
$vip = $_SERVER['REMOTE_ADDR'];
if(filter_var($vip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
$vip2 = explode('.',$vip);
if (!in_array("$vip2[0].$vip2[1].$vip2[2]", $ips)) {
$ins_newip = "$vip2[0].$vip2[1].$vip2[2]";
$rs_insert_ip = "INSERT INTO allowedip  (ipaddress,dateadded,lastaccess) VALUES ('$ins_newip',NOW(),NOW())";
@mysqli_query($rs_connect, $rs_insert_ip);
} else {
$vip2 = explode('.',$vip);
$ins_newip = "$vip2[0].$vip2[1].$vip2[2]";
$rs_update_ip = "UPDATE allowedip SET lastaccess = NOW() WHERE ipaddress = '$ins_newip'";
@mysqli_query($rs_connect, $rs_update_ip);
}
}

$rs_update_co = "DELETE FROM allowedip WHERE lastaccess < DATE_SUB(NOW(), INTERVAL 30 DAY)";
@mysqli_query($rs_connect, $rs_update_co);

#temp in transition - remove after v9 or later
$rs_setmodal = "UPDATE users SET gomodal = '1'";
@mysqli_query($rs_connect, $rs_setmodal);

header("Location: $gotouri");



?>
