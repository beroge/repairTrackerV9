<?php 


/***************************************************************************
 *   copyright            : (C) 2017 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/


require_once("validate.php"); ?>
<!DOCTYPE html>

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta NAME="AUTHOR" CONTENT="Luke Stroven">

  <script src="jq/jquery.js" type="text/javascript"></script>

<?php
require_once("deps.php");
require_once("common.php");



$rs_ql = "SELECT * FROM users WHERE username = '$ipofpc'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$touchrefresh = "$rs_result_q1->touchrefresh";

if ($touchrefresh > "10") {
echo "<meta http-equiv=\"refresh\" content=\"$touchrefresh;url=touch.php\">";
}

echo "<title>".pcrtlang("Dashboard")."</title>";

?>


<link rel="apple-touch-icon" sizes="57x57" href="favicon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="favicon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="favicon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="favicon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="favicon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="favicon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="favicon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="favicon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="favicon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
<link rel="manifest" href="favicon/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">



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

<table style="width:100%;border-collapse:collapse;"><tr><td style="width:275px;background:#444444;vertical-align:top;text-align:center;border-collapse:collapse;padding:10px;">

<?php

$func = $_REQUEST['func'];
$woid = $_REQUEST['woid'];


$rs_findpcid = "SELECT * FROM pc_wo WHERE woid = '$woid'";
$rs_result1 = mysqli_query($rs_connect, $rs_findpcid);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$pcid = "$rs_result_q1->pcid";
$pcstatus = "$rs_result_q1->pcstatus";

$rs_findowner = "SELECT * FROM pc_owner WHERE pcid = '$pcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
while($rs_result_q2 = mysqli_fetch_object($rs_result2)) {
$pcname = "$rs_result_q2->pcname";
$pcmake = "$rs_result_q2->pcmake";

echo "<span class=\"colormewhite sizeme2x\">$pcname</span><br>";
echo "<span class=\"colormewhite boldme\"><i class=\"fa fa-tag fa-lg\"></i> $pcid</span>&nbsp;&nbsp;";
echo "<span class=\"colormewhite boldme\"><i class=\"fa fa-clipboard fa-lg\"></i> $woid</span><br><br>";

$rs_findcreds = "SELECT * FROM creds WHERE pcid = '$pcid' AND credtype < '3' ORDER BY creddate DESC";
$rs_result_creds = mysqli_query($rs_connect, $rs_findcreds);
while($rs_result_qcreds = mysqli_fetch_object($rs_result_creds)) {
$creddesc = "$rs_result_qcreds->creddesc";
$creduser = "$rs_result_qcreds->creduser";
$credpass = "$rs_result_qcreds->credpass";
$credtype = "$rs_result_qcreds->credtype";
$patterndata = "$rs_result_qcreds->patterndata";
if($credtype == 1) {
echo "<br><span class=\"colormewhite sizeme16\">$creddesc: <br><i class=\"fa fa-user\"></i> $creduser <i class=\"fa fa-key\"></i> $credpass</span>";
} else {
echo "<br><span class=\"colormewhite sizeme16\">$creddesc: <br><i class=\"fa fa-thumb-tack\"></i> $credpass</span>";
}
}

$rs_findcreds = "SELECT * FROM creds WHERE pcid = '$pcid' AND credtype = '3' ORDER BY creddate DESC";
$rs_result_creds = mysqli_query($rs_connect, $rs_findcreds);
require_once("patterns.php");
while($rs_result_qcreds = mysqli_fetch_object($rs_result_creds)) {
$creddesc = "$rs_result_qcreds->creddesc";
$patterndata = "$rs_result_qcreds->patterndata";
echo "<br><br><span class=\"sizeme10 colormewhite\">$creddesc:</span><br>";
echo draw3x3("$patterndata","small")."<br><br>";
}





$boxstyles = getboxstyle("$pcstatus");
echo "<br><span class=\"linkbuttonsmall linkbuttongraylabel\">S</span><span class=\"linkbuttonsmall linkbuttongraylabel\" style=\"background:#$boxstyles[selectorcolor]\">$boxstyles[boxtitle]</span><br><br>";

}
}



if ($func == "record") {
echo "<span class=\"linkbutton2x linkbuttongraydisabled radiustop displayblock\">".pcrtlang("Overview")."</span>";
} else {
echo "<a href=\"touch.php?func=record&woid=$woid\" class=\"linkbutton2x linkbuttongray radiustop displayblock\">".pcrtlang("Overview")."</a>";
}

if ($func == "notes") {
echo "<span class=\"linkbutton2x linkbuttongraydisabled displayblock\">".pcrtlang("Notes")."</span>";
} else {
echo "<a href=\"touch.php?func=notes&woid=$woid\" class=\"linkbutton2x linkbuttongray displayblock\">".pcrtlang("Notes")."</a>";
}


if ($func == "wochecks") {
echo "<span class=\"linkbutton2x linkbuttongraydisabled displayblock\">".pcrtlang("Checks")."</span>";
} else {
echo "<a href=\"touch.php?func=wochecks&woid=$woid\" class=\"linkbutton2x linkbuttongray displayblock\">".pcrtlang("Checks")."</a>";
}


if ($func == "recordscan1") {
echo "<span class=\"linkbutton2x linkbuttongraydisabled displayblock\">".pcrtlang("Scans")."</span>";
} else {
echo "<a href=\"touch.php?func=recordscan1&woid=$woid\" class=\"linkbutton2x linkbuttongray displayblock\">".pcrtlang("Scans")."</a>";
}

if ($func == "recordscan2") {
$scantype = $_REQUEST['scantype'];
if ($scantype == "1") {
echo "<span class=\"linkbutton2x linkbuttongraydisabled displayblock\">".pcrtlang("Actions")."</span>";
} else {
echo "<a href=\"touch.php?func=recordscan2&woid=$woid&scantype=1\" class=\"linkbutton2x linkbuttongray displayblock\">".pcrtlang("Actions")."</a>";
}
if ($scantype == "2") {
echo "<span class=\"linkbutton2x linkbuttongraydisabled displayblock\">".pcrtlang("Installs")."</span>";
} else {
echo "<a href=\"touch.php?func=recordscan2&woid=$woid&scantype=2\" class=\"linkbutton2x linkbuttongray displayblock\">".pcrtlang("Installs")."</a>";
}
if ($scantype == "3") {
echo "<span class=\"linkbutton2x linkbuttongraydisabled displayblock\">".pcrtlang("Notes & Rec.")."</span>";
} else {
echo "<a href=\"touch.php?func=recordscan2&woid=$woid&scantype=3\" class=\"linkbutton2x linkbuttongray displayblock\">".pcrtlang("Notes & Rec.")."</a>";
}
} else {
echo "<a href=\"touch.php?func=recordscan2&woid=$woid&scantype=1\" class=\"linkbutton2x linkbuttongray displayblock\">".pcrtlang("Actions")."</a>";
echo "<a href=\"touch.php?func=recordscan2&woid=$woid&scantype=2\" class=\"linkbutton2x linkbuttongray displayblock\">".pcrtlang("Installs")."</a>";
echo "<a href=\"touch.php?func=recordscan2&woid=$woid&scantype=3\" class=\"linkbutton2x linkbuttongray displayblock\">".pcrtlang("Notes & Rec.")."</a>";
}


echo "<a href=\"touch.php\" class=\"linkbutton2x linkbuttongreen displayblock\"><i class=\"fa fa-dashboard\"></i> ".pcrtlang("Dashboard")."</a>";

echo "<a href=\"index.php?pcwo=$woid\" class=\"linkbuttonred linkbutton2x radiusbottom displayblock\"> <i class=\"fa fa-sign-out fa-lg\"></i> ".pcrtlang("Exit Dashboard")."</a>";


?>


</td><td style="vertical-align:top" class=touchbackground>
<table style="width:95%;margin-left:auto;margin-right:auto;" class=touchbackground><tr><td style="vertical-align:top"><br>
