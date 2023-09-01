<?php 
require("validate.php"); 
require("common.php");

?>
<!DOCTYPE html>
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">



<title></title>

<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=ISO-8859-1">
<meta NAME="AUTHOR" CONTENT="Luke Stroven">

<link rel="stylesheet" type="text/css" href="printstyle.css">

<script src="jq/jquery.js" type="text/javascript"></script>

<?php
if (preg_match("/smssend/i", $_SERVER['REQUEST_URI'])) {
?>
<script src="jq/jquery.limit-1.2.js" type="text/javascript"></script>
<?php
}
?>

<?php

if ((preg_match("/printsticky/i", $_SERVER['REQUEST_URI'])) || (preg_match("/callmap/i", $_SERVER['REQUEST_URI']))) {

if(isset($googlemapsapikey)) {
$mapkeyvar = "&key=$googlemapsapikey";
} else {
$mapkeyvar = "";
}

if(checkssl()) {
?>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?<?php echo "$mapkeyvar"; ?>"></script>
<script src="jq/jquery.gmap.min.js" type="text/javascript"></script>
<script src="jq/gmap3.js" type="text/javascript"></script>
<?php
} else {
?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?<?php echo "$mapkeyvar"; ?>"></script>
<script src="jq/jquery.gmap.min.js" type="text/javascript"></script>
<script src="jq/gmap3.js" type="text/javascript"></script>
<?php
}

}
?>


</head>

<body>

