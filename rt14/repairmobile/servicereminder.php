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

                                                                                                    
function nothing() {
require_once("header.php");


require_once("footer.php");
                                                                                                    
}


function addsr() {

$pcid = $_REQUEST['pcid'];
$woid = $_REQUEST['pcwo'];

if($pcid == "") {
die("Error: PCID missing");
}

require("deps.php");
require_once("common.php");

require("dheader.php");

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}

$month1 = date('Y-m-d', strtotime("+1 month"));
$months2 = date('Y-m-d', strtotime("+2 month"));
$months2_minus1week = date('Y-m-d', (strtotime("+2 month") - 604800));
$months3 = date('Y-m-d', strtotime("+3 month"));
$months3_minus1week = date('Y-m-d', (strtotime("+3 month") - 604800));
$months6 = date('Y-m-d', strtotime("+6 month"));
$months6_minus2week = date('Y-m-d', (strtotime("+6 month") - 1209600));
$year1 = date('Y-m-d', strtotime("+1 year"));
$year1_minus2week = date('Y-m-d', (strtotime("+1 year") - 1209600));

$thenow = date('Y-m-d');


echo "<div data-role=\"header\" data-theme=\"b\"><h2>".pcrtlang("Add Reminder")."</h2></div>";
echo "<div class=\"ui-content\" role=\"main\">";

echo "<form action=servicereminder.php?func=addsr2 method=post data-ajax=\"false\">";
echo "<input type=hidden name=pcid value=$pcid>";
echo "<input type=hidden name=woid value=$woid>";

echo pcrtlang("When").":";
echo "<select name=myoptions onchange='document.getElementById(\"notifydate\").value=this.options[this.selectedIndex].value'  data-native-menu=\"false\">";
echo "<option value=\"\">".pcrtlang("choose a time")."</option>";

echo "<option value=\"$month1\">$month1 &bull; ".pcrtlang("1 Month")."</option>";
echo "<option value=\"$months2\">$months2 &bull; ".pcrtlang("2 Months")."</option>";
echo "<option value=\"$months2_minus1week\">$months2_minus1week &bull; ".pcrtlang("2 Months - 1 Week Advance Notice")."</option>";
echo "<option value=\"$months3\">$months3 &bull; ".pcrtlang("3 Months")."</option>";
echo "<option value=\"$months3_minus1week\">$months3_minus1week &bull; ".pcrtlang("3 Months - 1 Week Advance Notice")."</option>";
echo "<option value=\"$months6\">$months6 &bull; ".pcrtlang("6 Months")."</option>";
echo "<option value=\"$months6_minus2week\">$months6_minus2week &bull; ".pcrtlang("6 Months - 2 Weeks Advance Notice")."</option>";
echo "<option value=\"$year1\">$year1 &bull; ".pcrtlang("1 Year")."</option>";
echo "<option value=\"$year1_minus2week\">$year1_minus2week &bull; ".pcrtlang("1 Year - 2 Weeks Advance Notice")."</option>";


echo "</select>";

echo "<input id=notifydate type=text name=notifydate value=\"$thenow\">";

?>
<script type="text/javascript" src="../repair/jq/datepickr.js"></script>
<script type="text/javascript">
new datepickr('notifydate', { dateFormat: 'Y-m-d', theCurrentDate: document.getElementById("notifydate").value });
</script>
<?php


echo pcrtlang("Recurring")."?";
echo "<select name=srsent class=select data-native-menu=\"false\">";

echo "<option selected value=0>".pcrtlang("No")."</option>";
echo "<option value=2>".pcrtlang("Yes")."</option>";

echo "</select>";


echo pcrtlang("Recurring Interval").": <select name=interval data-native-menu=\"false\">";

$intervals = array('1W' => pcrtlang('Weekly'),'2W' => pcrtlang('Every 2 Weeks'),'1M' => pcrtlang('Monthly'),'2M' => pcrtlang('Every 2 Months'),'3M' => pcrtlang('Quarterly'),'6M' => pcrtlang('Every 6 Months'),'1Y' => pcrtlang('Yearly'),'2Y' => pcrtlang('2 Years'));

foreach($intervals as $k => $v) {
echo "<option value=$k>$v</option>";
}

echo "</select>";



echo pcrtlang("Custom Message")."<textarea name=message></textarea>";

echo pcrtlang("Standard Messages").":";

$rs_findcsr = "SELECT * FROM serviceremindercanned ORDER BY srorder DESC";
$rs_resultcsr = mysqli_query($rs_connect, $rs_findcsr);
while($rs_result_qcsr = mysqli_fetch_object($rs_resultcsr)) {
$srid = "$rs_result_qcsr->srid";
$srtitle = "$rs_result_qcsr->srtitle";
$srtext = "$rs_result_qcsr->srtext";

echo "<input type=checkbox id=\"$srid\" value=\"$srid\" name=\"cannedsr[]\"><label for=\"$srid\">$srtitle
<br>$srtext</input></label>";
}


echo "<input type=submit class=button value=\"".pcrtlang("Save")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Saving")."...'; this.form.submit();\" data-theme=\"b\"></form>";


echo "</div>";
require_once("dfooter.php");

}






function addsr2() {

require("deps.php");
require_once("validate.php");
require("common.php");

$pcid = $_REQUEST['pcid'];
$woid = $_REQUEST['woid'];
$cannedsr = $_REQUEST['cannedsr'];
$message = pv($_REQUEST['message']);
$notifydate = pv($_REQUEST['notifydate']);
$srsent = pv($_REQUEST['srsent']);
$interval = pv($_REQUEST['interval']);


$cannedsr2 = pv(serialize($cannedsr));






$rs_insert_sr = "INSERT INTO servicereminders (srpcid,srnote,srdate,srcanned,srsent,recurringinterval) VALUES ('$pcid','$message','$notifydate','$cannedsr2','$srsent','$interval')";
@mysqli_query($rs_connect, $rs_insert_sr);

userlog(33,$pcid,'pcid','');

header("Location: index.php?pcwo=$woid");


}


function deletesr() {

require("deps.php");
require("common.php");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
} 

$woid = $_REQUEST['woid'];
$srid = $_REQUEST['srid'];

require_once("validate.php");




$rs_delsr = "DELETE FROM servicereminders WHERE srid = '$srid'";
@mysqli_query($rs_connect, $rs_delsr);

if(!array_key_exists("returnurl",$_REQUEST)) {
header("Location: index.php?pcwo=$woid");
} else {
$returnurl = $_REQUEST['returnurl'];
header("Location: $returnurl");
}

}

function marksentsr() {

require("deps.php");
require("common.php");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}

$woid = $_REQUEST['woid'];
$srid = $_REQUEST['srid'];
$srsent = $_REQUEST['srsent'];
$interval = $_REQUEST['interval'];

require_once("validate.php");

if($srsent != 2) {
$rs_massr = "UPDATE servicereminders SET srsent = '1' WHERE srid = '$srid'";
} else {

if ($interval == "1W") {
$thedatesql = "DATE_ADD(srdate, INTERVAL 1 week)";
} elseif ($interval == "2W") {
$thedatesql = "DATE_ADD(srdate, INTERVAL 2 week)";
} elseif ($interval == "1M") {
$thedatesql = "DATE_ADD(srdate, INTERVAL 1 month)";
} elseif ($interval == "2M") {
$thedatesql = "DATE_ADD(srdate, INTERVAL 2 month)";
} elseif ($interval == "3M") {
$thedatesql = "DATE_ADD(srdate, INTERVAL 3 month)";
} elseif ($interval == "6M") {
$thedatesql = "DATE_ADD(srdate, INTERVAL 6 month)";
} elseif ($interval == "1Y") {
$thedatesql = "DATE_ADD(srdate, INTERVAL 1 year)";
} elseif ($interval == "2Y") {
$thedatesql = "DATE_ADD(srdate, INTERVAL 2 year)";
} else {
die("Error: Unhandled Interval");
}

$rs_massr = "UPDATE servicereminders SET srdate = $thedatesql WHERE srid = '$srid'";

}


@mysqli_query($rs_connect, $rs_massr);

if(!array_key_exists("returnurl",$_REQUEST)) {
header("Location: index.php?pcwo=$woid");
} else {
$returnurl = $_REQUEST['returnurl'];
header("Location: $returnurl");
}

}



function editsr() {

$srid = $_REQUEST['srid'];

require_once("common.php");
require("dheader.php");


require("deps.php");

$pcid = $_REQUEST['pcid'];
$woid = $_REQUEST['woid'];


if(array_key_exists("returnurl",$_REQUEST)) {
$returnurl = $_REQUEST['returnurl'];
} else {
$returnurl = "index.php?pcwo=$woid";
}

if(array_key_exists("returnurl",$_REQUEST)) {
$returnurl = $_REQUEST['returnurl'];
} else {
$returnurl = "index.php?pcwo=$woid";
}


if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}

$month1 = date('Y-m-d', strtotime("+1 month"));
$months2 = date('Y-m-d', strtotime("+2 month"));
$months2_minus1week = date('Y-m-d', (strtotime("+2 month") - 604800));
$months3 = date('Y-m-d', strtotime("+3 month"));
$months3_minus1week = date('Y-m-d', (strtotime("+3 month") - 604800));
$months6 = date('Y-m-d', strtotime("+6 month"));
$months6_minus2week = date('Y-m-d', (strtotime("+6 month") - 1209600));
$year1 = date('Y-m-d', strtotime("+1 year"));
$year1_minus2week = date('Y-m-d', (strtotime("+1 year") - 1209600));

$rs_foundsr = "SELECT * FROM servicereminders WHERE srid = '$srid'";
$rs_result_fsr = mysqli_query($rs_connect, $rs_foundsr);
$rs_result_fsr2 = mysqli_fetch_object($rs_result_fsr);
$srnote = "$rs_result_fsr2->srnote";
$srdate = "$rs_result_fsr2->srdate";
$srcanned = "$rs_result_fsr2->srcanned";
$srsent = "$rs_result_fsr2->srsent";
$interval = "$rs_result_fsr2->recurringinterval";


if ($srcanned != "") {
$srcanned2 = unserialize($srcanned);
if(is_array($srcanned2)) {
$srcanned3 = $srcanned2;
} else {
$srcanned3 = array();
}
} else {
$srcanned3 = array();
}



echo "<div data-role=\"header\" data-theme=\"b\"><h2>".pcrtlang("Edit Reminder")."</h2></div>";
echo "<div class=\"ui-content\" role=\"main\">";


echo "<form action=servicereminder.php?func=editsr2 method=post data-ajax=\"false\">";
echo "<input type=hidden name=pcid value=$pcid>";
echo "<input type=hidden name=woid value=$woid>";
echo "<input type=hidden name=srid value=$srid>";

echo pcrtlang("When").":";
echo "<select data-native-menu=\"false\" name=myoptions onchange='document.getElementById(\"notifydate\").value=this.options[this.selectedIndex].value'>";
echo "<option value=\"\">".pcrtlang("choose a time")."</option>";

echo "<option value=\"$month1\">$month1 &bull; ".pcrtlang("1 Month")."</option>";
echo "<option value=\"$months2\">$months2 &bull; ".pcrtlang("2 Months")."</option>";
echo "<option value=\"$months2_minus1week\">$months2_minus1week &bull; ".pcrtlang("2 Months - 1 Week Advance Notice")."</option>";
echo "<option value=\"$months3\">$months3 &bull; ".pcrtlang("3 Months")."</option>";
echo "<option value=\"$months3_minus1week\">$months3_minus1week &bull; ".pcrtlang("3 Months - 1 Week Advance Notice")."</option>";
echo "<option value=\"$months6\">$months6 &bull; ".pcrtlang("6 Months")."</option>";
echo "<option value=\"$months6_minus2week\">$months6_minus2week &bull; ".pcrtlang("6 Months - 2 Weeks Advance Notice")."</option>";
echo "<option value=\"$year1\">$year1 &bull; ".pcrtlang("1 Year")."</option>";
echo "<option value=\"$year1_minus2week\">$year1_minus2week &bull; ".pcrtlang("1 Year - 2 Weeks Advance Notice")."</option>";


echo "</select>";

echo "<input id=notifydate type=text name=notifydate value=\"$srdate\"><input type=hidden name=returnurl value=\"$returnurl\">";

?>
<script type="text/javascript" src="../repair/jq/datepickr.js"></script>
<script type="text/javascript">
new datepickr('notifydate', { dateFormat: 'Y-m-d', theCurrentDate: document.getElementById("notifydate").value });
</script>
<?php



echo "<strong>".pcrtlang("Recurring")."?</strong>";
echo "<select name=srsent class=select>";

if ($srsent == 2) {
echo "<option selected value=2>".pcrtlang("Yes")."</option>";
echo "<option value=0>".pcrtlang("No")."</option>";
} else {
echo "<option selected value=0>".pcrtlang("No")."</option>";
echo "<option value=2>".pcrtlang("Yes")."</option>";
}

echo "</select>";


echo "<strong>".pcrtlang("Interval").":</strong> <select name=interval>";

$intervals = array('1W' => pcrtlang('Weekly'),'2W' => pcrtlang('Every 2 Weeks'),'1M' => pcrtlang('Monthly'),'2M' => pcrtlang('Every 2 Months'),'3M' => pcrtlang('Quarterly'),'6M' => pcrtlang('Every 6 Months'),'1Y' => pcrtlang('Yearly'),'2Y' => pcrtlang('2 Years'));

foreach($intervals as $k => $v) {
if ($k == "$interval") {
echo "<option selected value=$k>$v</option>";
} else {
echo "<option value=$k>$v</option>";
}
}



echo "</select>";






echo pcrtlang("Custom Message")."<textarea name=message>$srnote</textarea>";

echo pcrtlang("Standard Messages").":";

$rs_findcsr = "SELECT * FROM serviceremindercanned ORDER BY srorder DESC";
$rs_resultcsr = mysqli_query($rs_connect, $rs_findcsr);
while($rs_result_qcsr = mysqli_fetch_object($rs_resultcsr)) {
$srid = "$rs_result_qcsr->srid";
$srtitle = "$rs_result_qcsr->srtitle";
$srtext = "$rs_result_qcsr->srtext";

if (in_array("$srid", $srcanned3)) {
echo "<input type=checkbox checked id=\"$srid\" value=\"$srid\" name=\"cannedsr[]\"><label for=\"$srid\"><strong>$srtitle</strong><br>$srtext</input></label>";
} else {
echo "<input type=checkbox id=\"$srid\" value=\"$srid\" name=\"cannedsr[]\"><label for=\"$srid\"><strong>$srtitle<strong><br>$srtext</input></label>";
}
}


echo "<input type=submit data-theme=\"b\" value=\"".pcrtlang("Save")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Saving")."...'; this.form.submit();\"></form>";

echo "</div>";
require_once("dfooter.php");



} 


function editsr2() {

require("deps.php");
require_once("validate.php");
require("common.php");

$returnurl = $_REQUEST['returnurl'];
$pcid = $_REQUEST['pcid'];
$woid = $_REQUEST['woid'];
$srid = $_REQUEST['srid'];
$cannedsr = $_REQUEST['cannedsr'];
$message = pv($_REQUEST['message']);
$notifydate = pv($_REQUEST['notifydate']);
$interval = $_REQUEST['interval'];
$srsent = pv($_REQUEST['srsent']);

$cannedsr2 = pv(serialize($cannedsr));




$rs_update_sr = "UPDATE servicereminders SET srnote = '$message', srdate = '$notifydate', srcanned= '$cannedsr2', srsent = '$srsent', recurringinterval = '$interval' WHERE srid = '$srid'";
@mysqli_query($rs_connect, $rs_update_sr);

header("Location: $returnurl");


}

function runsr() {
require_once("header.php");
require("deps.php");
require_once("common.php");

perm_boot("17");





echo "<h3>".pcrtlang("Process Service Reminders")."</h3>";
echo "<form action=servicereminder.php?func=runsr2 method=post data-ajax=\"false\">";

$rs_sr = "SELECT * FROM servicereminders WHERE srdate < NOW() AND srsent != '1' ORDER BY srdate";
$rs_find_sr = @mysqli_query($rs_connect, $rs_sr);
$sr_thecount = mysqli_num_rows($rs_find_sr);

while($rs_find_sr_q = mysqli_fetch_object($rs_find_sr)) {
$sr_id = "$rs_find_sr_q->srid";
$sr_pcid = "$rs_find_sr_q->srpcid";
$sr_note = "$rs_find_sr_q->srnote";
$sr_date = "$rs_find_sr_q->srdate";
$sr_canned = "$rs_find_sr_q->srcanned";
$srsent = "$rs_find_sr_q->srsent";
$interval = "$rs_find_sr_q->recurringinterval";

if ($sr_canned != "") {
$sr_canned2 = unserialize($sr_canned);
if(is_array($sr_canned2)) {
$sr_canned3 = $sr_canned2;
} else {
$sr_canned3 = array();
}
} else {
$sr_canned3 = array();
}


$rs_sr_recentwo = "SELECT storeid,woid FROM pc_wo WHERE pcid = '$sr_pcid' ORDER BY dropdate DESC LIMIT 1";
$rs_find_recent_storeid = @mysqli_query($rs_connect, $rs_sr_recentwo);
$rs_find_srwo_q = mysqli_fetch_object($rs_find_recent_storeid);
$recent_store_id = "$rs_find_srwo_q->storeid";
$recent_woid = "$rs_find_srwo_q->woid";

$rs_sr_pcinfo = "SELECT pcname,pcemail,pcgroupid,pcaddress FROM pc_owner WHERE pcid = '$sr_pcid'";
$rs_find_pcinfo_q = @mysqli_query($rs_connect, $rs_sr_pcinfo);
$rs_find_pcinfo_qq = mysqli_fetch_object($rs_find_pcinfo_q);
$sr_pcname = "$rs_find_pcinfo_qq->pcname";
$sr_pcemail = "$rs_find_pcinfo_qq->pcemail";
$sr_pcaddress = "$rs_find_pcinfo_qq->pcaddress";
$sr_pcgroupid = "$rs_find_pcinfo_qq->pcgroupid";

if (($sr_pcgroupid != "0") && ($sr_pcemail == "")) {
$rs_sr_groupinfo = "SELECT grpemail,grpaddress1 FROM pc_group WHERE pcgroupid = '$sr_pcgroupid'";
$rs_find_groupinfo_q = @mysqli_query($rs_connect, $rs_sr_groupinfo);
$rs_find_groupinfo_qq = mysqli_fetch_object($rs_find_groupinfo_q);
$sr_groupemail = "$rs_find_groupinfo_qq->grpemail";
$sr_groupaddress1 = "$rs_find_groupinfo_qq->grpaddress1";
if($sr_pcemail == "") {
$sr_pcemail = "$sr_groupemail (group email)";
}
}

if ($sr_pcaddress == "") {

if(isset($sr_groupaddress1)) {

if ($sr_groupaddress1 == "") {
$addresswarning = pcrtlang("Warning: Address not specified");
} else {
$addresswarning = "";
}

} else {
$addresswarning = pcrtlang("Warning: Address not specified");
}

} else {
$addresswarning = "";
}



$storeinfoarray = getstoreinfo($recent_store_id);


echo "\n<table class=standard><tr><th>$sr_pcname</th></tr>";

if ($activestorecount > 1) {
echo "<tr><td>$storeinfoarray[storesname]</td></tr>";
}

$returnurl = urlencode("../repairmobile/servicereminder.php?func=runsr");

echo "<tr><td>$sr_date";

if($srsent == 2) {
echo "<br><span>".pcrtlang("Recurring")."</span>";
}



echo "</td></tr>";
echo "<tr><td>$sr_note";

$rs_findcsr = "SELECT * FROM serviceremindercanned";
$rs_resultcsr = mysqli_query($rs_connect, $rs_findcsr);
while($rs_result_qcsr = mysqli_fetch_object($rs_resultcsr)) {
$srid = "$rs_result_qcsr->srid";
$srtitle = "$rs_result_qcsr->srtitle";
if (in_array($srid, $sr_canned3)) {
echo "<br>&bull; $srtitle";
}
}


echo "</td></tr>";
echo "<tr><td>";

echo "<div data-role=\"collapsible\">";
echo "<h3>".pcrtlang("Actions")."</h3>";
echo "<button type=button onClick=\"parent.location='servicereminder.php?func=editsr&srid=$sr_id&returnurl=$returnurl&woid=$recent_woid&pcid=$sr_pcid'\"> <i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("Edit")."</button>";

echo "<button type=button onClick=\"parent.location='servicereminder.php?func=editowner&pcid=$sr_pcid&woid=0&returnurl=$returnurl'\"> <i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("Edit PC/Owner")."</button>"; 

if($srsent == 1) {
echo "<button type=button onClick=\"parent.location='servicereminder.php?func=marksentsr&pcid=$sr_pcid&srid=$sr_id&srsent=$srsent&interval=$interval&woid=0&returnurl=$returnurl'\"> <i class=\"fa fa-check fa-lg\"></i> ".pcrtlang("Mark as Sent")."</button>";
} elseif($srsent == 2) {
echo "<button type=button onClick=\"parent.location='servicereminder.php?func=marksentsr&pcid=$sr_pcid&srid=$sr_id&srsent=$srsent&interval=$interval&woid=0&returnurl=$returnurl'\"> <i class=\"fa fa-step-forward fa-lg\"></i> ".pcrtlang("Skip this Recurrence")."</button>";
} else {

}



echo "<a href=\"#popupdeletesr$srid\" data-rel=\"popup\" data-position-to=\"window\" data-transition=\"pop\" class=\"ui-btn ui-shadow ui-corner-all\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete Reminder")."</a>";
echo "<div data-role=\"popup\" id=\"popupdeletesr$srid\" data-overlay-theme=\"b\"  data-theme=\"a\" data-dismissible=\"false\">";
echo "<div data-role=\"header\" data-theme=\"b\">";
echo "<h1>".pcrtlang("Delete Reminder")."?</h1>";
echo "</div>";
echo "<div role=\"main\" class=\"ui-content\">";
echo "<p>".pcrtlang("Are you sure you wish to permanently delete this Service Reminder!!!?")."</p>";
echo "<div align=\"right\"><a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\" data-inline=\"true\"><i class=\"fa fa-ban fa-lg\"></i> Cancel</a>";
echo "<button onClick=\"parent.location='servicereminder.php?func=deletesr&pcid=$sr_pcid&srid=$sr_id&woid=0&returnurl=$returnurl'\" data-inline=\"true\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")." </button></div>";
echo "</div>";
echo "</div>";


echo "</div></td></tr>";


echo "<tr><td>";

echo "<fieldset data-role=\"controlgroup\">";

echo "\n<input type=checkbox checked name=gsr_id[] value=\"$sr_id\" id=process$sr_id> <label for=process$sr_id> <i class=\"fa fa-bell fa-lg\"></i> ".pcrtlang("Create Service Reminder")."</label>";
if($sr_pcemail == "") {
echo "\n<input type=checkbox checked name=psr_id[] value=\"$sr_id\" id=print$sr_id> <label for=print$sr_id> <i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Print")."$addresswarning</label>";
} else {
echo "\n<input type=checkbox checked name=esr_id[] value=\"$sr_id\" id=email$sr_id> <label for=email$sr_id> <i class=\"fa fa-envelope fa-lg\"></i> ".pcrtlang("Email to").": $sr_pcemail</label>";
echo "\n<input type=checkbox name=psr_id[] value=\"$sr_id\" id=print$sr_id> <label for=print$sr_id> <i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Print")."$addresswarning</label>";
}

echo "</fieldset>";

echo "</td></tr></table><br>";


}

if ($sr_thecount != "0") {
echo "<input type=submit value=\"".pcrtlang("Send Service Reminders")."\"  data-theme=\"b\">";
} else {
echo pcrtlang("No Service Reminders to Process");
}

echo "</form>";




require_once("footer.php");
}


function runsr2() {
require_once("validate.php");
require("deps.php");
require("common.php");

perm_boot("17");

$gsr_id = $_REQUEST['gsr_id'];

if (array_key_exists('psr_id',$_REQUEST)) {
$psr_id = $_REQUEST['psr_id'];
} else {
$psr_id = array();
}

if (array_key_exists('esr_id',$_REQUEST)) {
$esr_id = $_REQUEST['esr_id'];
} else {
$esr_id = array();
}

$psr_id2 = array();
$esr_id2 = array();


foreach($gsr_id as $key => $sr_id) {

if (in_array("$sr_id", $psr_id)) {
$psr_id2[] = $sr_id;
}
if (in_array("$sr_id", $esr_id)) {
$esr_id2[] = $sr_id;
}

}

$thefurl = "";
$thefurl2 = "";
foreach($esr_id2 as $key => $esr_id3) {
$thefurl .= "&esr_id[]=$esr_id3";
}

foreach($psr_id2 as $key => $psr_id3) {
$thefurl .= "&psr_id[]=$psr_id3";
}

reset($psr_id2);
foreach($psr_id2 as $key => $psr_id3) {
$thefurl2 .= "&sr_id[]=$psr_id3";
}


if (count($esr_id2) > 0) {
header("Location: servicereminder.php?func=emailsr$thefurl");
} elseif (count($psr_id2) > 0) {
header("Location: servicereminder.php?func=printsr$thefurl2");
} else {
header("Location: servicereminder.php?func=runsr");
}

}



function emailsr() {

require_once("validate.php");

$sendingerror = 0;
$infopass = "";

if (array_key_exists('psr_id',$_REQUEST)) {
$psr_id = $_REQUEST['psr_id'];
}

$esr_id = $_REQUEST['esr_id'];

include("deps.php");
include("common.php");

perm_boot("17");

if (($pcrt_mailer == "pearsmtp") || ($pcrt_mailer == "pearsmtpauth") || ($pcrt_mailer == "pearphpmailer")) {
include('Mail.php');
include('Mail/mime.php');
}


if (array_key_exists('returnurl',$_REQUEST)) {
$returnurl = $_REQUEST['returnurl'];
} else {
$returnurl = "servicereminder.php?func=runsr";
}

foreach($esr_id as $key => $resr_id) {

userlog(34,$resr_id,'pcid','');


if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}

#######
// HERE




$rs_sr = "SELECT * FROM servicereminders WHERE srid = '$resr_id'";
$rs_find_sr = @mysqli_query($rs_connect, $rs_sr);
$rs_find_sr_q = mysqli_fetch_object($rs_find_sr);
$sr_id = "$rs_find_sr_q->srid";
$sr_pcid = "$rs_find_sr_q->srpcid";
$sr_note = "$rs_find_sr_q->srnote";
$sr_date = "$rs_find_sr_q->srdate";
$sr_canned = "$rs_find_sr_q->srcanned";
$srsent = "$rs_find_sr_q->srsent";
$interval = "$rs_find_sr_q->recurringinterval";

if($srsent == 1) {
$rs_update_sr = "UPDATE servicereminders SET srsent = '1' WHERE srid = '$resr_id'";
@mysqli_query($rs_connect, $rs_update_sr);
} elseif ($srsent == 2) {

if ($interval == "1W") {
$thedatesql = "DATE_ADD(srdate, INTERVAL 1 week)";
} elseif ($interval == "2W") {
$thedatesql = "DATE_ADD(srdate, INTERVAL 2 week)";
} elseif ($interval == "1M") {
$thedatesql = "DATE_ADD(srdate, INTERVAL 1 month)";
} elseif ($interval == "2M") {
$thedatesql = "DATE_ADD(srdate, INTERVAL 2 month)";
} elseif ($interval == "3M") {
$thedatesql = "DATE_ADD(srdate, INTERVAL 3 month)";
} elseif ($interval == "6M") {
$thedatesql = "DATE_ADD(srdate, INTERVAL 6 month)";
} elseif ($interval == "1Y") {
$thedatesql = "DATE_ADD(srdate, INTERVAL 1 year)";
} elseif ($interval == "2Y") {
$thedatesql = "DATE_ADD(srdate, INTERVAL 2 year)";
} else {
die("Error: Unhandled Interval");
}

$rs_update_sr = "UPDATE servicereminders SET srdate = $thedatesql WHERE srid = '$resr_id'";
@mysqli_query($rs_connect, $rs_update_sr);

} else {

}




if ($sr_canned != "") {
$srcanned2 = unserialize($sr_canned);
if(is_array($srcanned2)) {
$srcanned3 = $srcanned2;
} else {
$srcanned3 = array();
}
} else {
$srcanned3 = array();
}


$rs_sr_pcinfo = "SELECT * FROM pc_owner WHERE pcid = '$sr_pcid'";
$rs_find_pcinfo_q = @mysqli_query($rs_connect, $rs_sr_pcinfo);
$rs_find_pcinfo_qq = mysqli_fetch_object($rs_find_pcinfo_q);
$sr_pcname = "$rs_find_pcinfo_qq->pcname";
$sr_pcemail = "$rs_find_pcinfo_qq->pcemail";
$sr_pcaddress = "$rs_find_pcinfo_qq->pcaddress";
$sr_pcgroupid = "$rs_find_pcinfo_qq->pcgroupid";
$sr_pcid = "$rs_find_pcinfo_qq->pcid";
$sr_pcname = "$rs_find_pcinfo_qq->pcname";
$sr_pcmake = "$rs_find_pcinfo_qq->pcmake";

$rs_findrwo = "SELECT storeid FROM pc_wo WHERE pcid = '$sr_pcid' ORDER BY dropdate DESC LIMIT 1";
$rs_resultrwoq = mysqli_query($rs_connect, $rs_findrwo);
$rs_result_qrwo = mysqli_fetch_object($rs_resultrwoq);
$recent_store_id = "$rs_result_qrwo->storeid";


$storeinfoarray = getstoreinfo($recent_store_id);

$to = "$sr_pcemail";

if("$storeinfoarray[storeccemail]" != "")       {
$to .= ",$storeinfoarray[storeccemail]";
}

$subject = "$storeinfoarray[storename] - ".pcrtlang("Service Reminder");
$random_hash = md5(date('r', time()));
$headers = "From: $storeinfoarray[storeemail]\nReply-To: $storeinfoarray[storeemail]\nX-Mailer: PHP/".phpversion();
$headers .= "\nMIME-Version: 1.0";
$headers .= "\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
$headers .= "\nMIME-Version: 1.0";

$message = "--PHP-alt-$random_hash\n";
$message .= "Content-Transfer-Encoding: 7bit\n";
$message .= "Content-Type: text/plain; charset=\"utf-8\"\n\n";

$peartext = "Sorry, Your email client does not support html email.\n\n";
$message .= "Sorry, Your email client does not support html email.\n\n";

$message .= "--PHP-alt-$random_hash\n";
$message .= "Content-Transfer-Encoding: 7bit\n";
$message .= "Content-Type: text/html; charset=\"utf-8\"\n\n";

$message .= "<html><head><title>$sitename</title></head>\n\n";
$pearhtml = "<html><head><title>$sitename</title></head>\n\n";

$message .= "<table width=100%><tr><td valign=top><font size=5>$storeinfoarray[storename]</font></td><td>\n";
$pearhtml .= "<table width=100%><tr><td valign=top><img src=$logo></td><td>\n";

$message .= "<b><font size=4>".pcrtlang("Service Reminder")."</font><br><br>$storeinfoarray[storename]";
$message .= "<br>$storeinfoarray[storeaddy1]";
if ("$storeinfoarray[storeaddy2]" != "") {
$message .= "<br>$storeinfoarray[storeaddy2]";
}
$message .= "<br>$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]";
$message .= "<br>$storeinfoarray[storephone]</b><br>\n";


$pearhtml .= "<b><font size=4>".pcrtlang("Service Reminder")."</font><br><br>$storeinfoarray[storename]";
$pearhtml .= "<br>$storeinfoarray[storeaddy1]";
if ("$storeinfoarray[storeaddy2]" != "") {
$pearhtml .= "<br>$storeinfoarray[storeaddy2]";
}
$pearhtml .= "<br>$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]";
$pearhtml .= "<br>$storeinfoarray[storephone]</b><br>\n";


$message .= "</td></tr></table><br>\n";
$pearhtml .= "</td></tr></table><br>\n";

$message .= "<font size=4>".pcrtlang("To").": <b>$sr_pcname</b></font><br><font size=2>".pcrtlang("Computer ID").": <font color=red size=2><b>$sr_pcid</b></font>\n";
$pearhtml .= "<font size=4>".pcrtlang("To").": <b>$sr_pcname</b></font><br><font size=2>".pcrtlang("Computer ID").": <font color=red size=2><b>$sr_pcid</b></font>\n";

$message .= "<br><font size=2><br>".pcrtlang("Make/Model").": <b>$sr_pcmake</b></font>\n";
$pearhtml .= "<br><font size=2><br>".pcrtlang("Make/Model").": <b>$sr_pcmake</b></font>\n";

if($sr_note != "") {
$message .= "<br><br><font size=2><font size=2><b>".pcrtlang("Special Note")."</b><br>$sr_note</font>\n";
$pearhtml .= "<br><br><font size=2><font size=2><b>".pcrtlang("Special Note")."</b><br>$sr_note</font>\n";
}

foreach($srcanned3 as $key => $cannedsr) {
$rs_findcsr = "SELECT * FROM serviceremindercanned ORDER BY srorder DESC";
$rs_resultcsr = mysqli_query($rs_connect, $rs_findcsr);
while($rs_result_qcsr = mysqli_fetch_object($rs_resultcsr)) {
$srid = "$rs_result_qcsr->srid";
$srtitle = "$rs_result_qcsr->srtitle";
$srtext = nl2br("$rs_result_qcsr->srtext");
if("$srid" == "$cannedsr") {
$message .= "<br><br><font size=2><b>$srtitle</b><br>$srtext</font>";
$pearhtml .= "<br><br><font size=2><b>$srtitle</b><br>$srtext</font>";
}
}
}

$message .= "</body></html>\n\n";
$pearhtml .= "</body></html>\n\n";

$message .= "--PHP-alt-$random_hash--\n\n";

#######

if (!isset($pcrt_mailer)) {
$pcrt_mailer = "mail";
}

if ($pcrt_mailer == "mail") {

$mail_sent = @mail( $to, $subject, $message, $headers );
if($mail_sent) {
$infopass .= pcrtlang("Service Reminder Sent to")." $to<br>";
} else {
$infopass .= pcrtlang("Failed to send Service Reminder to")." $to<br>";
$sendingerror = 1;
}

} elseif (($pcrt_mailer == "pearsmtp") || ($pcrt_mailer == "pearsmtpauth") || ($pcrt_mailer == "pearphpmailer")) {

    $pearmessage2 = new Mail_mime();

    $pearmessage2->setTXTBody($peartext);
    $pearmessage2->setHTMLBody($pearhtml);

$imagetype = substr("$logo", -3);
if ($imagetype == "gif") {
$pearmessage2->addHTMLImage("../store/$logo", 'image/gif');
} elseif ($imagetype == "jpg") {
$pearmessage2->addHTMLImage("../store/$logo", 'image/jpeg');
} elseif ($imagetype == "png") {
$pearmessage2->addHTMLImage("../store/$logo", 'image/png');
} else {
}

    $body = $pearmessage2->get();
    $extraheaders = array("From"=>"$storeinfoarray[storeemail]", "Subject"=>"$subject");
    $pearheaders = $pearmessage2->headers($extraheaders);

if ("$pcrt_mailer" == "pearsmtpauth") {
$smtp = Mail::factory('smtp',
   array ('host' => $pcrt_pear_host,
     'auth' => true,
     'port' => $pcrt_pear_port,
     'username' => $pcrt_pear_username,
     'password' => $pcrt_pear_password));
} elseif ("$pcrt_mailer" == "pearphpmailer") {
$smtp = Mail::factory('mail');
} elseif ("$pcrt_mailer" == "pearsmtp")  {
$smtp = Mail::factory('smtp');
} else {
die("Invalid Mailer Chosen");
}


$mailresult = $smtp->send("$to", $pearheaders, $body);

if (PEAR::isError($mailresult)) {
$infopass .= $mailresult->getMessage() . "<br><br>";
$sendingerror = 1;
  } else {
$infopass .= pcrtlang("Service Reminder sent to")." $to<br>";
  }

} else {
$infopass .= pcrtlang("Error: invalid mailer specified in the deps.php config file");
}



}



if ((count($esr_id) == 1) && ($sendingerror == 0) && (!array_key_exists('psr_id', $_REQUEST))) {
echo "<html><head><meta http-equiv=\"refresh\" content=\"2;url=$returnurl\"></head><body>";
echo "$infopass";
echo "<br><a href=$returnurl>".pcrtlang("Return")."</a></body></html>";
} else {

if(!array_key_exists('psr_id', $_REQUEST)) {
echo "<html><head></head><body>";
echo "$infopass";
echo "<br><a href=$returnurl>".pcrtlang("Return")."</a></body></html>";
} else {
echo "<html><head></head><body>";
echo "$infopass";
$thefurl = "";
$psr_id = $_REQUEST['psr_id'];
foreach($psr_id as $key => $psr_id3) {
$thefurl .= "&sr_id[]=$psr_id3";
}
echo "<br><br><a href=\"servicereminder.php?func=printsr$thefurl\">".pcrtlang("Print Service Reminders")."</a>";
}

}


}


#######

function printsr() {
require_once("validate.php");
$sr_ids2 = $_REQUEST['sr_id'];

include("deps.php");
include("common.php");

perm_boot("17");

if(!is_array($sr_ids2)) {
$sr_ids = array("$sr_ids2");
} else {
$sr_ids = $sr_ids2;
}


$returnurl = "servicereminder.php?func=runsr";

echo "<html><head><title>".pcrtlang("Print Service Reminders")."</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../repair/printstyle.css\">";

echo "</head>";

echo "<body class=printpagebg>";

if (count($sr_ids) > 1) {
echo "<div class=printbar>";
echo "<button onClick=\"parent.location='$returnurl'\" class=bigbutton><img src=../store/images/left.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Return")."</button>";
echo "<font class=text30b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>";
echo "<button onClick=\"print();\" class=bigbutton><img src=../store/images/print.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Print")."</button>";
echo "</div>";
}


foreach($sr_ids as $key => $sr_id) {



$rs_sr = "SELECT * FROM servicereminders WHERE srid = '$sr_id'";
$rs_find_sr = @mysqli_query($rs_connect, $rs_sr);
$rs_find_sr_q = mysqli_fetch_object($rs_find_sr);
$sr_id = "$rs_find_sr_q->srid";
$sr_pcid = "$rs_find_sr_q->srpcid";
$sr_note = "$rs_find_sr_q->srnote";
$sr_date = "$rs_find_sr_q->srdate";
$sr_canned = "$rs_find_sr_q->srcanned";
$srsent = "$rs_find_sr_q->srsent";
$interval = "$rs_find_sr_q->recurringinterval";

if($srsent == 1) {
$rs_update_sr = "UPDATE servicereminders SET srsent = '1' WHERE srid = '$resr_id'";
@mysqli_query($rs_connect, $rs_update_sr);
} elseif ($srsent == 2) {

if ($interval == "1W") {
$thedatesql = "DATE_ADD(srdate, INTERVAL 1 week)";
} elseif ($interval == "2W") {
$thedatesql = "DATE_ADD(srdate, INTERVAL 2 week)";
} elseif ($interval == "1M") {
$thedatesql = "DATE_ADD(srdate, INTERVAL 1 month)";
} elseif ($interval == "2M") {
$thedatesql = "DATE_ADD(srdate, INTERVAL 2 month)";
} elseif ($interval == "3M") {
$thedatesql = "DATE_ADD(srdate, INTERVAL 3 month)";
} elseif ($interval == "6M") {
$thedatesql = "DATE_ADD(srdate, INTERVAL 6 month)";
} elseif ($interval == "1Y") {
$thedatesql = "DATE_ADD(srdate, INTERVAL 1 year)";
} elseif ($interval == "2Y") {
$thedatesql = "DATE_ADD(srdate, INTERVAL 2 year)";
} else {
die("Error: Unhandled Interval");
}

$rs_update_sr = "UPDATE servicereminders SET srdate = $thedatesql WHERE srid = '$resr_id'";
@mysqli_query($rs_connect, $rs_update_sr);

} else {

}




if ($sr_canned != "") {
$srcanned2 = unserialize($sr_canned);
if(is_array($srcanned2)) {
$srcanned3 = $srcanned2;
} else {
$srcanned3 = array();
}
} else {
$srcanned3 = array();
}

$rs_sr_pcinfo = "SELECT * FROM pc_owner WHERE pcid = '$sr_pcid'";
$rs_find_pcinfo_q = @mysqli_query($rs_connect, $rs_sr_pcinfo);
$rs_find_pcinfo_qq = mysqli_fetch_object($rs_find_pcinfo_q);
$sr_pcname = "$rs_find_pcinfo_qq->pcname";
$sr_pccompany = "$rs_find_pcinfo_qq->pccompany";
$sr_pcemail = "$rs_find_pcinfo_qq->pcemail";
$sr_pcaddress = "$rs_find_pcinfo_qq->pcaddress";
$sr_pcaddress2 = "$rs_find_pcinfo_qq->pcaddress2";
$sr_pccity = "$rs_find_pcinfo_qq->pccity";
$sr_pcstate = "$rs_find_pcinfo_qq->pcstate";
$sr_pczip = "$rs_find_pcinfo_qq->pczip";
$sr_pcgroupid = "$rs_find_pcinfo_qq->pcgroupid";
$sr_pcid = "$rs_find_pcinfo_qq->pcid";
$sr_pcname = "$rs_find_pcinfo_qq->pcname";
$sr_pcmake = "$rs_find_pcinfo_qq->pcmake";

$rs_findrwo = "SELECT storeid FROM pc_wo WHERE pcid = '$sr_pcid' ORDER BY dropdate DESC LIMIT 1";
$rs_resultrwoq = mysqli_query($rs_connect, $rs_findrwo);
$rs_result_qrwo = mysqli_fetch_object($rs_resultrwoq);
$recent_store_id = "$rs_result_qrwo->storeid";


$storeinfoarray = getstoreinfo($recent_store_id);


$sr_soldto_ue = urlencode($sr_pcname);
$sr_company_ue = urlencode($sr_pccompany);
$sr_ad1_ue = urlencode($sr_pcaddress);
$sr_ad2_ue = urlencode($sr_pcaddress2);
$sr_city_ue = urlencode($sr_pccity);
$sr_state_ue = urlencode($sr_pcstate);
$sr_zip_ue = urlencode($sr_pczip);

if (count($sr_ids) == 1) {
echo "<div class=printbar>";
echo "<button onClick=\"parent.location='$returnurl'\" class=bigbutton><img src=../store/images/left.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Return")."</button>";
echo "<font class=text30b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>";
echo "<button onClick=\"print();\" class=bigbutton><img src=../store/images/print.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Print")."</button>";
echo "<font class=text30b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>";
echo "<button onClick=\"parent.location='../repair/addresslabel.php?pcname=$sr_soldto_ue&pccompany=$sr_company_ue&pcaddress1=$sr_ad1_ue&pcaddress2=$sr_ad2_ue&pccity=$sr_city_ue&pcstate=$sr_state_ue&pczip=$sr_zip_ue'\" class=bigbutton><img src=../repair/images/labelprinter.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Address Label")."</button>";
echo "</div>";
}

userlog(35,$sr_id,'pcid','');

echo "<div class=printpage>";
echo "<table width=100%><tr><td width=55%>";

$storeinfoarray = getstoreinfo($recent_store_id);

echo "<img src=../store/$printablelogo><br><br><font class=text12b>";
echo "$storeinfoarray[storename]</font><font class=text12><br>$storeinfoarray[storeaddy1]";
if ("$storeinfoarray[storeaddy2]" != "") {
echo "<br>$storeinfoarray[storeaddy2]";
}
echo "<br>$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]";
echo "</font><br><br><font class=text12>".pcrtlang("Phone").": $storeinfoarray[storephone]</font></font><br><br>";

echo "<table cellpadding=3 cellspacing=0 border=0><tr><td valign=top><font class=text12b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></td><td>";
if("$sr_pccompany" == "") {
echo "<font class=text12>$sr_pcname";
} else {
echo "<font class=text12>$sr_pccompany";
}

echo "<br>$sr_pcaddress";

if ($sr_pcaddress2 != "") {
echo "<br>$sr_pcaddress2";
}

echo "<br>";

if ($sr_pccity != "") {
echo "$sr_pccity,";
}
echo "$sr_pcstate $sr_pczip";



echo "</font></td></tr></table>";

echo "</font><br></td><td valign=top><table><tr><td align=right width=45% valign=top>";
echo "<font class=textidnumber>".pcrtlang("Service Reminder")."<br></font>";


$sr_date2 = date("F j, Y", strtotime($sr_date));

echo "<br><font class=text12>".pcrtlang("Date").": </font><font class=text12b>$sr_date2</font>";


echo "</td></tr><tr><td>";


echo "</td></tr></table></td></tr></table>";

if("$sr_pccompany" != "") {
echo "<br><font class=text12><br>".pcrtlang("Customer Name").": </font><font class=text12b>$sr_pcname</font>\n";
}

echo "<br><font class=text12><br>".pcrtlang("Make/Model").": </font><font class=text12b>$sr_pcmake</font>\n";
echo "<br><font class=text12>PC ID: </font><font class=text12b>#$sr_pcid</font>";

if($sr_note != "") {
echo "<br><br><font class=text12b>".pcrtlang("Special Note")."</font><br><font class=text12>$sr_note</font>\n";
}


foreach($srcanned3 as $key => $cannedsr) {
$rs_findcsr = "SELECT * FROM serviceremindercanned ORDER BY srorder DESC";
$rs_resultcsr = mysqli_query($rs_connect, $rs_findcsr);
while($rs_result_qcsr = mysqli_fetch_object($rs_resultcsr)) {
$srid = "$rs_result_qcsr->srid";
$srtitle = "$rs_result_qcsr->srtitle";
$srtext = nl2br("$rs_result_qcsr->srtext");
if("$srid" == "$cannedsr") {
echo "<br><br><font class=text12b>$srtitle</font><font class=text12><br>$srtext</font>";
}
}
}


echo "</div>";

if (count($sr_ids) > 1) {
echo "\n\n<DIV style=\"page-break-after:always\"></DIV>\n\n";
}


}


echo "</body></html>";


}


#######

function editowner() {
require_once("common.php");

require("deps.php");

require("dheader.php");

$pcid = $_REQUEST['pcid'];

dheader(pcrtlang("Edit Owner"));





$rs_find_pc = "SELECT * FROM pc_owner WHERE pcid = '$pcid'";
$rs_result_item = mysqli_query($rs_connect, $rs_find_pc);

while($rs_result_item_q = mysqli_fetch_object($rs_result_item)) {
$pcname = "$rs_result_item_q->pcname";
$pccompany = "$rs_result_item_q->pccompany";
$pcmake = pf("$rs_result_item_q->pcmake");

$pcemail = "$rs_result_item_q->pcemail";
$pcaddress = pf("$rs_result_item_q->pcaddress");
$pcaddress2 = pf("$rs_result_item_q->pcaddress2");
$pccity = pf("$rs_result_item_q->pccity");
$pcstate = pf("$rs_result_item_q->pcstate");
$pczip = pf("$rs_result_item_q->pczip");

echo "<form action=servicereminder.php?func=editowner2 method=post data-ajax=\"false\">";
echo pcrtlang("Customer Name").":<input type=text value=\"$pcname\" name=custname>";
echo pcrtlang("Company").":<input type=text value=\"$pccompany\" name=custcompany>";
echo pcrtlang("Computer Make/Model").":<input type=text value=\"$pcmake\" name=pcmake><input type=hidden name=pcid value=$pcid>";


echo pcrtlang("Email Address").":<input type=text name=pcemail value=\"$pcemail\">";

echo "$pcrt_address1<input type=text name=pcaddress value=\"$pcaddress\">";
echo "$pcrt_address2<input type=text name=pcaddress2 value=\"$pcaddress2\">";
echo "$pcrt_city, $pcrt_state, $pcrt_zip<input type=text name=pccity value=\"$pccity\">
<input type=text name=pcstate value=\"$pcstate\"><input type=text name=pczip value=\"$pczip\">";


echo "<input type=submit value=\"".pcrtlang("Edit Owner")."\" data-theme=\"b\"></form>";

}
dfooter();
require_once("dfooter.php");



}


function editowner2() {
require_once("validate.php");
require("deps.php");
require("common.php");

$custname = pv($_REQUEST['custname']);
$custcompany = pv($_REQUEST['custcompany']);
$pcmake = pv($_REQUEST['pcmake']);
$pcid = $_REQUEST['pcid'];

$pcemail = pv($_REQUEST['pcemail']);
$pcaddress = pv($_REQUEST['pcaddress']);
$pcaddress2 = pv($_REQUEST['pcaddress2']);
$pccity = pv($_REQUEST['pccity']);
$pcstate = pv($_REQUEST['pcstate']);
$pczip = pv($_REQUEST['pczip']);


if ($custname == "") { die(pcrtlang("Please go back and enter the customers name")); }




$rs_insert_pc = "UPDATE pc_owner SET pcname = '$custname', pccompany = '$custcompany', pcmake = '$pcmake', pcemail = '$pcemail', pcaddress = '$pcaddress', pcaddress2 = '$pcaddress2', pccity = '$pccity', pcstate = '$pcstate', pczip = '$pczip' WHERE pcid = '$pcid'";
@mysqli_query($rs_connect, $rs_insert_pc);

header("Location: servicereminder.php?func=runsr");

}



switch($func) {
                                                                                                    
    default:
    nothing();
    break;
                                
    case "addsr":
    addsr();
    break;

    case "addsr2":
    addsr2();
    break;

    case "editsr":
    editsr();
    break;

    case "editsr2":
    editsr2();
    break;

   case "deletesr":
    deletesr();
    break;

   case "marksentsr":
    marksentsr();
    break;

  case "browsesr":
    browsesr();
    break;

  case "runsr":
    runsr();
    break;

  case "runsr2":
    runsr2();
    break;


 case "emailsr":
    emailsr();
    break;

 case "printsr":
    printsr();
    break;

 case "editowner":
    editowner();
    break;
                                   
 case "editowner2":
    editowner2();
    break;


}

?>
