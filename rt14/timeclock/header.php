<?php require("validate.php"); 

$startpagetime = microtime(true);

?>
<!DOCTYPE html>
<html>

<head>
<meta http-equiv="Content-Type"
content="text/html; charset=iso-8859-1">

<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">

 <link href="../repair/jq/facebox.css" media="screen" rel="stylesheet" type="text/css" />
  <script src="../repair/jq/jquery.js" type="text/javascript"></script>
  <script src="../repair/jq/facebox.js" type="text/javascript"></script>
  <script type="text/javascript">
    jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        loadingImage : '../repair/jq/loading.gif',
        closeImage : '../repair/jq/closelabel.png'
      })
    })
  </script>


<link rel="stylesheet" href="../repair/fa5/css/all.min.css">
<link rel="stylesheet" href="../repair/fa5/css/v4-shims.min.css">


<?php
require("deps.php");
require_once("common.php");
if ($ipofpc != "admin") {
if (!perm_check("5")) {
die("Permission Denied");
}
}

if (preg_match("/index/i", $_SERVER['REQUEST_URI'])) {
echo "<script type=\"text/javascript\" src=\"textarea.js\"></script>\n";

}

?>



<title><?php echo "$sitename | ".pcrtlang("Logged in as")." $ipofpc"; ?></title>

<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=ISO-8859-1">
<meta NAME="AUTHOR" CONTENT="Luke Stroven">

<link rel="stylesheet" type="text/css" href="../repair/style.css">




</head>


<body bgcolor="#FFFFFF">

<!-- ########################## -->

<?php
$storeinfoarray = getdefaultstoreinfo();


if($defloc != 0) {
$rs_find_tax = "SELECT * FROM locations WHERE locid = '$defloc'";
$rs_result_tax = mysqli_query($rs_connect, $rs_find_tax);
$rs_result_tq = mysqli_fetch_object($rs_result_tax);
$locname = "$rs_result_tq->locname";
} else {
$locname = pcrtlang("Inactive");
}


?>

<div id=topnavbarfixed style="white-space: nowrap;">
<table style="border-collapse:collapse;width:100%"><tr><td style="padding:0px;width:200px;">

<?php
if(strlen("$locname") > 24) {
$menufontsize = "font-size:12px;";
} elseif(strlen("$locname") > 15) {
$menufontsize = "font-size:14px;";
} else {
$menufontsize = "";
}
?>


<ul id="navgonew"><li><a class="primary_linkgonew" href="javascript:void(0)" style="<?php echo "$storeinfoarray[linestyle] $menufontsize"; ?>">
<i class="fa fa-bars"></i> <?php echo "$locname"; ?></a><div class="dropdowngonew" style="border-left: 8px solid #777777">
<?php
require_once("topnavmenuvert.php");
?>
</div></li></ul>

</td><td>
<?php
if(perm_check("1")) {
echo "<a href=\"employee.php?func=addemployee\" class=notifybarlink><i class=\"fa fa-user-plus fa-lg\"></i> ".pcrtlang("New Employee")."</a>";
}
?>
<a href="clock.php" class=notifybarlink><i class="fa fa-line-chart fa-lg"></i> <?php echo pcrtlang("Reports"); ?></a><a href="index.php" class=notifybarlink><i class="fa fa-calculator fa-lg"></i> <?php echo pcrtlang("Punch Clock"); ?></a>
</td><td>
<form action= method=post><input type=text class=textbox autocomplete=off id=autosearchbox name=thesearch size=8
required=required onkeyup="window.scrollTo(0, 0)"><button class=button style="padding:4px 4px;">&nbsp;&nbsp;<i class="fa fa-search"></i>&nbsp;&nbsp;</button></form>

</td><td style="text-align:right;">

</td><td style="padding:0px;width:200px;">
<ul id="navgo_rightnew">
<li><a class="primary_linkgo_rightnew" href="javascript:void(0)">
<i class="fa fa-user"></i> <?php echo $ipofpc; ?> </a><div class="dropdowngo_rightnew" style="border-right: 8px solid #777777">
<?php
require_once("topnavmenuvertnew_right.php");
?>
</div></li></ul>

</td></tr></table>

</div>


<div id="autosearch2"></div>
<script type="text/javascript">

$(document).ready(function(){
  var globalTimeout = null;
  $("input#autosearchbox").keyup(function(){
    if(this.value.length<3) {
      $("div#autosearch2").slideUp(200,function(){
        return false;
      });
    }else{
           var encoded = encodeURIComponent(this.value);
  if (globalTimeout != null) {
    clearTimeout(globalTimeout);
  }
  globalTimeout = setTimeout(function() {
    globalTimeout = null;
        $('div#autosearch2').load('autosearch.php?func=esearch&search='+encoded).slideDown(200);
}, 300);
    }
  });
});
</script>






<!-- ########################### -->


<table class=interface>
    <tr>
       	<td style="width:30%;background:#<?php echo $storeinfoarray['interfacecolor1']; ?>;padding:50px 20px 20px 40px;"></td>
        <td style="width:70%;background:#<?php echo $storeinfoarray['interfacecolor2']; ?>;padding:50px 20px 20px 40px;"></td></tr>

    <tr>
       	<td style="width:30%;background:#<?php echo $storeinfoarray['interfacecolor1']; ?>;padding:0px 20px 20px 20px;vertical-align:top">


<?php


if ($defloc != 0) {
$rs_findpcs3 = "SELECT * FROM employees WHERE isactive = '1' AND location = '$defloc' ORDER BY employeename ASC";
} else {
$rs_findpcs3 = "SELECT * FROM employees WHERE isactive = '0' ORDER BY employeename ASC";
}

$rs_result3 = mysqli_query($rs_connect, $rs_findpcs3);
start_blue_box(pcrtlang("Employee List"));



$rs_find_tax = "SELECT * FROM locations";
$rs_result_tax = mysqli_query($rs_connect, $rs_find_tax);
echo "<form method=post action=admin.php?func=setdefloc2><span class=text12b>".pcrtlang("Location").":</span> <select name=locname class=selects onchange='this.form.submit()'>";

while($rs_result_tq = mysqli_fetch_object($rs_result_tax)) {
$locname = "$rs_result_tq->locname";
$locid = "$rs_result_tq->locid";

if(in_array("$locid", $locpermsthisuser)) {
if ($locid == $defloc) {
echo "<option selected value=$locid>$locname</option>";
} else {
echo "<option value=$locid>$locname</option>";
}
}
}

if ($defloc == 0) {
echo "<option value=0 selected>".pcrtlang("Inactive")."</option>";
} else {
echo "<option value=0>".pcrtlang("Inactive")."</option>";
}

echo "</select><button type=submit class=ibutton><i class=\"fa fa-chevron-left\"></i></button></form>";

$totalpeepsin = 0;


echo "<table class=standard>";
while($rs_result_q3 = mysqli_fetch_object($rs_result3)) {
$eid = "$rs_result_q3->employeeid";
$cn = "$rs_result_q3->clocknumber";
$ename = "$rs_result_q3->employeename";
$locationid2 = "$rs_result_q3->location";
$deptid2 = "$rs_result_q3->deptid";
$fulltime = "$rs_result_q3->fulltime";

if(in_array("$locationid2", $locpermsthisuser)) {
if(in_array("$deptid2", $deptpermsthisuser)) {





$rs_find_punch_status = "SELECT * FROM punches WHERE employeeid = '$cn' ORDER BY punchin DESC LIMIT 1";
$punchchkq = mysqli_query($rs_connect, $rs_find_punch_status);
$totalpunches = mysqli_num_rows($punchchkq);
if($totalpunches == '0') {
$currentpunchstatus = "out";
$servertime = "";
$punchtypeout = 0;
} else {
$rs_result_q1 = mysqli_fetch_object($punchchkq);
$currentpunchstatus = "$rs_result_q1->punchstatus";
$punchtype = "$rs_result_q1->punchtype";
$punchtypeout = "$rs_result_q1->punchtypeout";
$servertime = "$rs_result_q1->servertime";
$punchout = "$rs_result_q1->punchout";
}


echo "<tr><td>";

if($currentpunchstatus == "in") {
echo "<span class=colormegreen><i class=\"fa fa-user fa-lg fa-fw\"></i></span>";
if($punchtype == 1) {
echo "<span class=colormered><i class=\"fa fa-hand-o-up fa-lg fa-fw\"></i></span>";
} elseif($punchtype == 0) {
echo "<span class=colormegray><i class=\"fa fa-credit-card fa-lg fa-fw\"></i></span>";
} else {
echo "<span class=colormeblue><i class=\"fa fa-edit fa-lg fa-fw\"></i></span>";
}
$totalpeepsin++;
} else {
echo "<span class=colormered><i class=\"fa fa-minus-circle fa-lg fa-fw\"></i></span>";
if($punchtypeout == 1) {
echo "<span class=colormered><i class=\"fa fa-hand-o-up fa-lg fa-fw\"></i></span>";
} elseif($punchtypeout == 0) {
echo "<span class=colormegray><i class=\"fa fa-credit-card fa-lg fa-fw\"></i></span>";
} else {
echo "<span class=colormeblue><i class=\"fa fa-edit fa-lg fa-fw\"></i></span>";
}
}


if($fulltime == "0") {
echo "<i class=\"fa fa-hourglass fa-lg fa-fw\"></i>";
} else {
echo "<i class=\"fa fa-hourglass-half fa-lg fa-fw\"></i>";
}

echo "</td>";

$ename2 = urlencode("$ename");

$serverpunchstamp = strtotime($servertime);
$servertimestamp = time();
$timelapse = $servertimestamp - $serverpunchstamp;
$timelapsehours = $timelapse / 3600;
$timelapsehours_f = number_format($timelapsehours, 2, '.', '');

echo "<td>";
if(perm_check("6")) {
echo "<a href=\"badge.php?name=$ename2&dymojsapi=html&backurl=index.php&clocknumber=$cn&eid=$eid\" class=\"linkbuttonsmall linkbuttongray radiusall\"><i class=\"fa fa-credit-card fa-lg fa-fw\"></i></a> ";
}
echo "<span class=boldme>$cn</span></td>";
echo "<td><a href=\"employee.php?func=viewemployee&eid=$eid&cn=$cn\" class=\"linkbuttonsmall linkbuttongray radiusall\">$ename</a>";
if($currentpunchstatus == "in") {
if($timelapse > 21600) {
echo " <span class=colormered><i class=\"fa fa-clock-o fa-lg\"></i> $timelapsehours_f</span>";
}
} else {

if(($servertimestamp - $serverpunchstamp) > 1209600) {
echo " <span style=\"color:orange\"><i class=\"fa fa-warning fa-2x floatright\"></i></span>";
}

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}

$currentdate = date('Y-m-d');

$rs_qar = "SELECT * FROM absenses WHERE eid = '$eid' AND abdate LIKE '$currentdate%' ORDER BY abdate DESC LIMIT 1";
$rs_resultqar = mysqli_query($rs_connect, $rs_qar);

#die($rs_qar);

$acount = mysqli_num_rows($rs_resultqar);
if($acount > 0) {
$rs_result_aq = mysqli_fetch_object($rs_resultqar);
$abreason = "$rs_result_aq->abreason";
echo " <i class=\"fa faa-tada animated fa-".$abreasonicons["$abreason"]." colormered fa-lg\"></i>";
}




}




echo "</td></tr>";


}
}

}
echo "</table>";

echo "<br><span class=\"colormegreen boldme\">".pcrtlang("Total Punched IN").": $totalpeepsin</span>";

stop_blue_box();




echo "<br>";


?>




</td>
        <td style="width:70%; vertical-align:top; background:#<?php echo $storeinfoarray['interfacecolor2']; ?>; padding:20px 40px 20px 20px;">
