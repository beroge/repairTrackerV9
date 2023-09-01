<?php require("validate.php"); ?>
<!DOCTYPE html>
<html>

<head>
<meta http-equiv="Content-Type"
content="text/html; charset=iso-8859-1">

<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">



<title></title>

<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=ISO-8859-1">
<meta NAME="AUTHOR" CONTENT="Luke Stroven">

<link rel="stylesheet" type="text/css" href="style.css">

<script src="jq/jquery.js" type="text/javascript"></script>

<?php
if (preg_match("/smssend/i", $_SERVER['REQUEST_URI'])) {
?>
<script src="jq/jquery.limit-1.2.js" type="text/javascript"></script>
<?php
}
?>

<?php

if (preg_match("/printsticky/i", $_SERVER['REQUEST_URI'])) {
?>
<script type="text/javascript" src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=<?php echo "$googlemapsapikey"; ?>"></script>
<script src="jq/jquery.gmap-1.1.0-min.js" type="text/javascript"></script>

<?php
}
?>


</head>

<body>

