<?php 


/***************************************************************************
 *   copyright            : (C) 2010 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/

require_once("deps.php");
require_once("validate.php"); 
require_once("common.php");
?>
<!DOCTYPE html>
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<meta NAME="AUTHOR" CONTENT="PCRT">

  <script src="jq/jquery.js" type="text/javascript"></script>

<?php



$rs_ql = "SELECT * FROM users WHERE username = '$ipofpc'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$touchrefresh = "$rs_result_q1->touchrefresh";

if ($touchrefresh > "10") {
echo "<meta http-equiv=\"refresh\" content=\"$touchrefresh;url=touch.php\">";
}

echo "<title>".pcrtlang("Dashboard")."</title>";

?>

<title><?php echo pcrtlang("Repair Touchscreen"); ?> | <?php echo pcrtlang("Logged in as")." $ipofpc";  ?></title>

<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">


<?php
if(!isset($pcrt_stylesheet)) {
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\">";
} else {
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"$pcrt_stylesheet\">";
}
?>

<link rel="stylesheet" href="fa5/css/all.min.css">
<link rel="stylesheet" href="fa5/css/v4-shims.min.css">
<link rel="stylesheet" href="fa5/font-awesome-animation.min.css">


</head>

<body>

<script type='text/javascript' src='jq/jquery.autogrow-textarea.js'></script>
