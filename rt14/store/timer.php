<?php

/***************************************************************************
 *   copyright            : (C) 2012 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/

if (array_key_exists('func',$_REQUEST)) {
$func = $_REQUEST['func'];
} else {
$func = "";
}



function timerstart() {
require_once("validate.php");
require("deps.php");
require("common.php");

$woid = 0;
$timername = pv($_REQUEST['timername']);

if("$timername" == "") {
$timername = "(".pcrtlang("no description").")";
}

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');




$rs_insert_timer = "INSERT INTO timers (timerdesc,timerstart,woid,byuser) VALUES ('$timername','$currentdatetime','$woid','$ipofpc')";
@mysqli_query($rs_connect, $rs_insert_timer);

header("Location: cart.php");
}



function timerstop() {
require_once("validate.php");
require("deps.php");
require("common.php");

$timerid = pv($_REQUEST['timerid']);

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');




$rs_stop_timer = "UPDATE timers SET timerstop = '$currentdatetime' WHERE timerid = '$timerid'";
@mysqli_query($rs_connect, $rs_stop_timer);

header("Location: cart.php");
}


function timerdelete() {
require_once("validate.php");
require("deps.php");
require("common.php");

$timerid = pv($_REQUEST['timerid']);




$rs_delete_timer = "DELETE FROM timers WHERE timerid = '$timerid'";
@mysqli_query($rs_connect, $rs_delete_timer);

header("Location: cart.php");
}

function timerbill() {
require_once("validate.php");
require("deps.php");
require("common.php");


$timerid = $_REQUEST['timerid'];
$billtime = $_REQUEST['billtime'];
$billrate = $_REQUEST['billrate'];
$timerdesc = urlencode($_REQUEST['timerdesc']);




$rs_bill_timer = "UPDATE timers SET billedout = '1' WHERE timerid = '$timerid'";
@mysqli_query($rs_connect, $rs_bill_timer);

#wip
header("Location: cart.php?func=add_labor2&labordesc=$timerdesc&laborprice=$billrate&qty=$billtime");
}



function timerbillfirst() {

require_once("header.php");
require("deps.php");

$timerid = $_REQUEST['timerid'];
$billtime = $_REQUEST['billtime'];
$timerdesc = $_REQUEST['timerdesc'];

$labordec = mf(($billtime / 3600));

$roundarray = explode(".", "$labordec");

if(".$roundarray[1]" == 0) {
$minutes15 = "0";
} elseif((".$roundarray[1]" > 0) && (".$roundarray[1]" <= ".25")) {
$minutes15 = ".25";
} elseif((".$roundarray[1]" > ".25") && (".$roundarray[1]" <= ".5")) {
$minutes15 = ".5";
} elseif((".$roundarray[1]" > ".5") && (".$roundarray[1]" <= ".75")) {
$minutes15 = ".75";
} else {
$minutes15 = "1";
}

if(".$roundarray[1]" == 0) {
$minutes30 = "0";
} elseif((".$roundarray[1]" > 0) && (".$roundarray[1]" <= ".5")) {
$minutes30 = ".5";
} else {
$minutes30 = "1";
}

if(".$roundarray[1]" == 0) {
$minutes60 = "0";
} else {
$minutes60 = "1";
}


$r15 = $minutes15 + $roundarray['0'];
$r30 = $minutes30 + $roundarray['0'];
$r60 = $minutes60 + $roundarray['0'];
$r60d = $roundarray['0'];

start_blue_box(pcrtlang("Bill Hours"));

echo "<table>";

echo "<tr><td>".pcrtlang("Labor Description").": </td><td>";
echo "<form action=timer.php?func=timerbill&timerid=$timerid method=post><input type=text id=timerdesc name=timerdesc value=\"$timerdesc\" class=textbox style=\"width:200px;\"></td></tr>";

echo "<tr><td>".pcrtlang("Choose Bill Hours").":</td><td>";
echo "<div class=\"radiobox\">";
if($r60d != 0) {
echo "<input type=radio id=\"r60d\" value=\"$r60d\" name=\"billtime\"><label for=\"r60d\">".pcrtlang("Round Down (hour)").": $r60d</input></label><br>";
}
echo "<input type=radio id=\"act\" value=\"$labordec\" name=\"billtime\"><label for=\"act\">".pcrtlang("Actual").": $labordec</input></label><br>";

if($r15 != $r30) {
echo "<input type=radio id=\"r15\" value=\"$r15\" name=\"billtime\"><label for=\"r15\">".pcrtlang("Round Up (15 min)").": $r15</input></label><br>";
}
if($r30 != $r60) {
echo "<input type=radio id=\"r30\" value=\"$r30\" name=\"billtime\"><label for=\"r30\">".pcrtlang("Round Up (half hour)").": $r30</input></label><br>";
}
echo "<input checked type=radio id=\"r60\" value=\"$r60\" name=\"billtime\"><label for=\"r60\">".pcrtlang("Round Up (hour)").": $r60</input></label>";
echo "</div></td></tr>";

echo "<tr><td>".pcrtlang("Choose Option").":<br><span class=\"sizemesmaller\">(".pcrtlang("or manually enter hourly rate").")</span></td><td>";

$rs_quicklabor2 = "SELECT * FROM quicklabor ORDER BY theorder DESC";
$rs_result_ql2  = mysqli_query($rs_connect, $rs_quicklabor2);

echo "<select name=pricepick id=stringall onchange='document.getElementById(\"billrate\").value=this.options[this.selectedIndex].value'>";
echo "<option value=\"0\">".pcrtlang("Choose").":</option>";
while($rs_result_qld2 = mysqli_fetch_object($rs_result_ql2)) {
$labordesc = "$rs_result_qld2->labordesc";
$laborprice = mf("$rs_result_qld2->laborprice");
$primero = substr("$labordesc", 0, 1);
if("$primero" != "-") {
echo "<option value=\"$laborprice\">$money$laborprice - $labordesc</option>";
} else {
$labordesc3 = substr("$labordesc", 1);
echo "<option value=\"0\" style=\"background:#000000;color:#ffffff;padding:1px;\">$labordesc3</option>";
}
}

echo "</td></tr>";

echo "<tr><td>".pcrtlang("Hourly Rate").": </td>";
echo "<td>$money<input type=text id=billrate name=billrate class=textbox size=6></td></tr>";
echo "<tr><td colspan=2><input type=submit value=\"".pcrtlang("Bill Hours")."\" class=button></form></td></tr>";
echo "</table>";
stop_box();



require_once("footer.php");


}


function timeredit() {

require_once("header.php");
require("deps.php");

$timerid = $_REQUEST['timerid'];

$rs_findtimers = "SELECT * FROM timers WHERE timerid = '$timerid'";
$rs_result_t = mysqli_query($rs_connect, $rs_findtimers);
$rs_result_qt = mysqli_fetch_object($rs_result_t);
$timerdesc = "$rs_result_qt->timerdesc";
$timerstart = "$rs_result_qt->timerstart";
$timerstop = "$rs_result_qt->timerstop";
$timerid = "$rs_result_qt->timerid";

start_blue_box(pcrtlang("Edit Timer"));

echo "<table>";
echo "<tr><td>".pcrtlang("Labor Description").": </td><td>";
echo "<form action=timer.php?func=timeredit2&timerid=$timerid method=post><input type=text style=\"width:400px;\" name=timerdesc class=textbox value=\"$timerdesc\"></td></tr>";

$thestartdate = date("Y-m-d", strtotime($timerstart));
echo "<tr><td>".pcrtlang("Start Date/Time").":</td><td>";
echo "<input id=\"startday2\" type=text class=textbox name=startdate value=\"$thestartdate\" style=\"width:120px;\">";
$starttime = date("g:i A", strtotime($timerstart));
picktime('starttime',"$starttime");
echo "</td></tr>";

$thestopdate = date("Y-m-d", strtotime($timerstop));
echo "<tr><td>".pcrtlang("Stop Date/Time").":</td><td>";
echo "<input id=\"stopday2\" type=text class=textbox name=stopdate value=\"$thestopdate\" style=\"width:120px;\">";
$stoptime = date("g:i A", strtotime($timerstop));
picktime('stoptime',"$stoptime");
echo "</td></tr>";

if(!isset($pcrt_weekstart)) {
$pcrt_weekstart = "Sunday";
}
if ($pcrt_weekstart == "Sunday") {
echo "<script type=\"text/javascript\" src=\"../repair/jq/datepickr.js\"></script>";
} else {
echo "<script type=\"text/javascript\" src=\"../repair/jq/datepickr2.js\"></script>";
}

?>
<script type="text/javascript">
new datepickr('startday2', { dateFormat: 'Y-m-d', theCurrentDate: document.getElementById("startday2").value });
new datepickr('stopday2', { dateFormat: 'Y-m-d', theCurrentDate: document.getElementById("stopday2").value });
</script>
<?php



echo "<tr><td colspan=2><input type=submit value=\"".pcrtlang("Save")."\" class=button></form></td></tr>";
echo "</table>";
stop_box();

require_once("footer.php");

}


function timeredit2() {
require_once("validate.php");
require("deps.php");
require("common.php");

$timerid = pv($_REQUEST['timerid']);

$startdate = $_REQUEST['startdate'];
$starttime = $_REQUEST['starttime'];
$stopdate = $_REQUEST['stopdate'];
$stoptime = $_REQUEST['stoptime'];
$timerdesc = $_REQUEST['timerdesc'];

$timerstart = date("Y-m-d H:i:s", strtotime("$startdate $starttime"));
$timerstop = date("Y-m-d H:i:s", strtotime("$stopdate $stoptime"));

$timerstart2 = strtotime("$startdate $starttime");
$timerstop2 = strtotime("$stopdate $stoptime");

if($timerstop < $timerstart) {
die(pcrtlang("Error: Stop date cannot be earlier that start date."));
}





$rs_save_timer = "UPDATE timers SET timerdesc = '$timerdesc', timerstop = '$timerstop', timerstart = '$timerstart', billedout = '0' WHERE timerid = '$timerid'";
@mysqli_query($rs_connect, $rs_save_timer);

header("Location: cart.php");
}


function timereditprog() {

require_once("header.php");
require("deps.php");

$timerid = $_REQUEST['timerid'];

$rs_findtimers = "SELECT * FROM timers WHERE timerid = '$timerid'";
$rs_result_t = mysqli_query($rs_connect, $rs_findtimers);
$rs_result_qt = mysqli_fetch_object($rs_result_t);
$timerdesc = "$rs_result_qt->timerdesc";
$timerstart = "$rs_result_qt->timerstart";
$timerid = "$rs_result_qt->timerid";

start_blue_box(pcrtlang("Edit Timer"));

echo "<table>";
echo "<tr><td>".pcrtlang("Labor Description").": </td><td>";
echo "<form action=timer.php?func=timeredit2prog&timerid=$timerid method=post><input type=text name=timerdesc class=textbox value=\"$timerdesc\"></td></tr>";

$thestartdate = date("Y-m-d", strtotime($timerstart));
echo "<tr><td>".pcrtlang("Start Date/Time").":</td><td>";
echo "<input id=\"startday2\" type=text class=textbox name=startdate value=\"$thestartdate\" style=\"width:120px;\">";
$starttime = date("g:i A", strtotime($timerstart));
picktime('starttime',"$starttime");
echo "</td></tr>";

if(!isset($pcrt_weekstart)) {
$pcrt_weekstart = "Sunday";
}
if ($pcrt_weekstart == "Sunday") {
echo "<script type=\"text/javascript\" src=\"../repair/jq/datepickr.js\"></script>";
} else {
echo "<script type=\"text/javascript\" src=\"../repair/jq/datepickr2.js\"></script>";
}

?>
<script type="text/javascript">
new datepickr('startday2', { dateFormat: 'Y-m-d', theCurrentDate: document.getElementById("startday2").value });
</script>
<?php



echo "<tr><td colspan=2><input type=submit value=\"".pcrtlang("Save")."\" class=button></form></td></tr>";
echo "</table>";
stop_box();

require_once("footer.php");

}

function timeredit2prog() {
require_once("validate.php");
require("deps.php");
require("common.php");

$woid = pv($_REQUEST['woid']);
$timerid = pv($_REQUEST['timerid']);

$startdate = $_REQUEST['startdate'];
$starttime = $_REQUEST['starttime'];
$timerdesc = $_REQUEST['timerdesc'];

$timerstart = date("Y-m-d H:i:s", strtotime("$startdate $starttime"));




$rs_save_timer = "UPDATE timers SET timerdesc = '$timerdesc', timerstart = '$timerstart', billedout = '0' WHERE timerid = '$timerid'";
@mysqli_query($rs_connect, $rs_save_timer);

header("Location: cart.php");
}





#####

switch($func) {
                                                                                                    
    default:
    timerstart();
    break;

case "timerstart":
    timerstart();
    break;

case "timerstartmanual":
    timerstartmanual();
    break;


case "timerstop":
    timerstop();
    break;

case "timerdelete":
    timerdelete();
    break;

case "timerresume":
    timerresume();
    break;

case "timerbill":
    timerbill();
    break;

case "timerbillfirst":
    timerbillfirst();
    break;

case "timeredit":
    timeredit();
    break;

case "timeredit2":
    timeredit2();
    break;

case "timereditprog":
    timereditprog();
    break;

case "timeredit2prog":
    timeredit2prog();
    break;


}

?>
