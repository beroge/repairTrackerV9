<?php

if (session_status() === PHP_SESSION_NONE){session_start();}

$rs_connect = mysqli_connect($dbhost, $dbuname, $dbpass, $dbname) or die("Couldn't connect the db");

if(!$rs_connect) {
echo mysqli_connect_error();
}

mysqli_query($rs_connect, "SET NAMES utf8");
mysqli_query($rs_connect, "SET SESSION sql_mode=''");

$passwords = array();

$rs_ql = "SELECT username,userpass,twofactor,twofactorpassword FROM users WHERE enabled = '1'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
while($row = mysqli_fetch_array($rs_result1)) {
$ausername =  str_replace('.', '_', $row['username']);
$apassword = $row['userpass'];
$atwofactor = $row['twofactor'];
$atwofactorpassword = $row['twofactorpassword'];
$passwords[$ausername]=$apassword;
$twofactorenabled[$ausername] = $atwofactor;
$passwords2fa[$ausername] = $atwofactorpassword;
}


if (array_key_exists("username", $_SESSION)) {
$ipofpc = $_SESSION["username"];
}

