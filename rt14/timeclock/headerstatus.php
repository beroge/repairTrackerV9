<?php 


/***************************************************************************
 *   copyright            : (C) 2010 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/


require_once("deps.php");
require_once("common.php");

$vip = $_SERVER['REMOTE_ADDR'];
if(filter_var($vip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
$vip2 = explode('.',$vip);
if (!in_array("$vip2[0].$vip2[1].$vip2[2]", $ips)) {
require("validate.php");
}
} else {
require("validate.php");
}


?>

<!DOCTYPE html>
<html>

<head>
<meta http-equiv="Content-Type"
content="text/html; charset=iso-8859-1">

<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=ISO-8859-1">
<meta NAME="AUTHOR" CONTENT="Luke Stroven">

<title><?php echo "$systemname";  ?></title>

<link rel="stylesheet" href="../repair/fa/css/font-awesome.min.css">

<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">

<link rel="stylesheet" type="text/css" href="../repair/style.css">

<script src="../repair/jq/jquery.js" type="text/javascript"></script>

<SCRIPT language="JavaScript">
<!--

function startclock()
{
var thetime=new Date();

var nhours=thetime.getHours();
var mhours=thetime.getHours();
var nmins=thetime.getMinutes();
var nsecn=thetime.getSeconds();
var nday=thetime.getDay();
var sday=thetime.getDay();
var nmonth=thetime.getMonth();
var ntoday=thetime.getDate();
var nyear=thetime.getYear();
var AorP=" ";

if (nhours>=12)
    AorP="PM";
else
    AorP="AM";

if (nhours>=13)
    nhours-=12;

if (nhours==0)
   nhours=12;

if (nsecn<10)
 nsecn="0"+nsecn;

if (nmins<10)
 nmins="0"+nmins;

if (nday==0)
  nday="<?php echo pcrtlang("Sunday"); ?>";
if (nday==1)
  nday="<?php echo pcrtlang("Monday"); ?>";
if (nday==2)
  nday="<?php echo pcrtlang("Tuesday"); ?>";
if (nday==3)
  nday="<?php echo pcrtlang("Wednesday"); ?>";
if (nday==4)
  nday="<?php echo pcrtlang("Thursday"); ?>";
if (nday==5)
  nday="<?php echo pcrtlang("Friday"); ?>";
if (nday==6)
  nday="<?php echo pcrtlang("Saturday"); ?>";

if (sday==0)
  sday="Domingo";
if (sday==1)
  sday="Lunes";
if (sday==2)
  sday="Martes";
if (sday==3)
  sday="Mi\xe9rcoles";
if (sday==4)
  sday="Jueves";
if (sday==5)
  sday="Viernes";
if (sday==6)
  sday="S\xe1bado";


nmonth+=1;

if (nyear<=99)
  nyear= "19"+nyear;

if ((nyear>99) && (nyear<2000))
 nyear+=1900;

<?php
if(!isset($pcrt_hours24)) {
$pcrt_hours24 = "12";
}

if($pcrt_hours24 == 12) {
echo "document.clockform.clock.value=nhours+\":\"+nmins+\":\"+nsecn+\" \"+AorP;";
} else {
echo "document.clockform.clock.value=mhours+\":\"+nmins+\":\"+nsecn;";
}

?>

document.clockform.date.value=nday+", "+nmonth+"/"+ntoday+"/"+nyear;
document.clockform.sdate.value=sday+", "+ntoday+"/"+nmonth+"/"+nyear;
document.clockform.hdate.value=nyear+"/"+nmonth+"/"+ntoday;
setTimeout('startclock()',1000);

} 

//-->
</SCRIPT>


</head>

<body bgcolor="#FFFFFF">

