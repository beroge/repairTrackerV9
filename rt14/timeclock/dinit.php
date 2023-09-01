<?php

if (session_status() === PHP_SESSION_NONE){session_start();}

$rs_connect = mysqli_connect($dbhost, $dbuname, $dbpass, $dbname) or die("Couldn't connect the db");
mysqli_query($rs_connect, "SET NAMES utf8");
mysqli_query($rs_connect, "SET SESSION sql_mode=''");

$passwords = array();

$rs_ql = "SELECT username,userpass FROM users WHERE enabled = '1'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
while($row = mysqli_fetch_array($rs_result1)) {
$ausername = $row['username'];
$apassword = $row['userpass'];
$passwords[$ausername]=$apassword;
}

if (array_key_exists("username", $_SESSION)) {
$ipofpc = $_SESSION["username"];
}

$rs_qip = "SELECT ipid,ipaddress FROM allowedip";
$rs_result1ip = mysqli_query($rs_connect, $rs_qip);
$ips = array();
while($rowi = mysqli_fetch_array($rs_result1ip)) {
$aipid = $rowi['ipid'];
$aipaddress = $rowi['ipaddress'];
$ips[$aipid]=$aipaddress;

}


