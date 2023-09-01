<?php
if (session_status() === PHP_SESSION_NONE){session_start();}

$rs_connect = mysqli_connect($dbhost, $dbuname, $dbpass, $dbname) or die("Couldn't connect the db");
mysqli_query($rs_connect, "SET NAMES utf8");
mysqli_query($rs_connect, "SET SESSION sql_mode=''");

if (array_key_exists("portallogin", $_SESSION)) {
$portallogin = $_SESSION['portallogin'];
$portalgroupid = $_SESSION['groupid'];
}

