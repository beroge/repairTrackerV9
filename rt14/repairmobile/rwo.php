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


function addrwo() {

$pcid = $_REQUEST['pcid'];

if(array_key_exists("woid",$_REQUEST)) {
$woid = $_REQUEST['woid'];
} else {
$woid = 0;
}

if(array_key_exists("scid",$_REQUEST)) {
$scid = $_REQUEST['scid'];
} else {
$scid = 0;
}

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
$months3 = date('Y-m-d', strtotime("+3 month"));
$months6 = date('Y-m-d', strtotime("+6 month"));
$year1 = date('Y-m-d', strtotime("+1 year"));

$thenow = date('Y-m-d');


echo "<div data-role=\"header\" data-theme=\"b\"><h2>".pcrtlang("Recurring Work Order")."</h2></div>";
echo "<div class=\"ui-content\" role=\"main\">";


echo "<form action=rwo.php?func=addrwo2 method=post data-ajax=\"false\">";
echo "<input type=hidden name=pcid value=$pcid>";
echo "<input type=hidden name=woid value=$woid>";
echo "<input type=hidden name=scid value=$scid>";

echo pcrtlang("Next Recurrence");
echo "<select name=myoptions onchange='document.getElementById(\"notifydate\").value=this.options[this.selectedIndex].value'>";
echo "<option value=\"\">".pcrtlang("choose a date")."</option>";

echo "<option value=\"$month1\">$month1 &bull; ".pcrtlang("1 Month")."</option>";
echo "<option value=\"$months2\">$months2 &bull; ".pcrtlang("2 Months")."</option>";
echo "<option value=\"$months3\">$months3 &bull; ".pcrtlang("3 Months")."</option>";
echo "<option value=\"$months6\">$months6 &bull; ".pcrtlang("6 Months")."</option>";
echo "<option value=\"$year1\">$year1 &bull; ".pcrtlang("1 Year")."</option>";


echo "</select>";

echo "<input id=notifydate type=date name=notifydate value=\"$thenow\">";



echo pcrtlang("Interval")."<select name=interval>";

$intervals = array('1W' => pcrtlang('Weekly'),'2W' => pcrtlang('Every 2 Weeks'),'1M' => pcrtlang('Monthly'),'2M' => pcrtlang('Every 2 Months'),'3M' => pcrtlang('Quarterly'),'6M' => pcrtlang('Every 6 Months'),'1Y' => pcrtlang('Yearly'),'2Y' => pcrtlang('2 Years'));

foreach($intervals as $k => $v) {
echo "<option value=$k>$v</option>";
}

echo "</select>";


if ($activestorecount > "1") {
echo pcrtlang("Assigned Store");

$rs_find_stores = "SELECT * FROM stores WHERE storeenabled = '1' ORDER BY storesname ASC";
$rs_result_stores = mysqli_query($rs_connect, $rs_find_stores);

echo "<select name=rwostoreid>";

while($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
$rwostoresname = "$rs_result_storeq->storesname";
$rwostoreid = "$rs_result_storeq->storeid";

if ($defaultuserstore == $rwostoreid) {
echo "<option selected value=$rwostoreid>$rwostoresname</option>";
} else {
echo "<option value=$rwostoreid>$rwostoresname</option>";
}
}

echo "</select>";

} else {
echo "<input type=hidden name=rwostoreid value=$defaultuserstore>";
}




echo pcrtlang("Task Summary")."<input type=text name=tasksummary>";

echo pcrtlang("Task")."<textarea name=message></textarea>";

echo pcrtlang("Landing Status");

$statuscolors = getstatusselectorcolors();
$boxtitles = getboxtitles();


$coptions = "";
$rs_qc = "SELECT * FROM boxstyles WHERE statusid > 99";
$rs_result1 = mysqli_query($rs_connect, $rs_qc);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$statusid = "$rs_result_q1->statusid";
$selectorcolor2 = "$rs_result_q1->selectorcolor";
$boxtitle2 = "$rs_result_q1->boxtitle";
$coptions .= "<option value=\"$statusid\" style=\"background:#$selectorcolor2\">$boxtitle2</option>";
}



echo "<select name=statnum>
<option value=1 style=\"background:#$statuscolors[1]\">$boxtitles[1]</option>
<option selected value=2 style=\"background:#$statuscolors[2]\">$boxtitles[2]</option>
<option value=8 style=\"background:#$statuscolors[8]\">$boxtitles[8]</option>
<option value=9 style=\"background:#$statuscolors[9]\">$boxtitles[9]</option>
<option value=3 style=\"background:#$statuscolors[3]\">$boxtitles[3]</option>
<option value=6 style=\"background:#$statuscolors[6]\">$boxtitles[6]</option>";
echo "$coptions";

echo "</select>";





echo "<input type=submit value=\"".pcrtlang("Save")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Saving")."...'; this.form.submit();\" data-theme=\"b\"></form>";

echo "</div>";
require("dfooter.php");

}






function addrwo2() {

require("deps.php");
require_once("validate.php");
require("common.php");

$pcid = $_REQUEST['pcid'];
$statnum = $_REQUEST['statnum'];
$message = pv($_REQUEST['message']);
$notifydate = pv($_REQUEST['notifydate']);
$tasksummary = pv($_REQUEST['tasksummary']);
$interval = pv($_REQUEST['interval']);
$rwostoreid = pv($_REQUEST['rwostoreid']);

if(array_key_exists("woid",$_REQUEST)) {
$woid = $_REQUEST['woid'];
} else {
$woid = 0;
}

if(array_key_exists("scid",$_REQUEST)) {
$scid = $_REQUEST['scid'];
} else {
$scid = 0;
}

$cannedsr2 = pv(serialize($cannedsr));

$rs_insert_sr = "INSERT INTO rwo (pcid,rwodate,rwointerval,rwotask,rwostatus,tasksummary,rwostoreid) VALUES ('$pcid','$notifydate','$interval','$message','$statnum','$tasksummary','$rwostoreid')";
@mysqli_query($rs_connect, $rs_insert_sr);


if($woid != 0) {
header("Location: index.php?pcwo=$woid");
} else {
header("Location: msp.php?func=viewservicecontract&scid=$scid");
}


}


function deleterwo() {

require("deps.php");
require("common.php");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
} 

if(array_key_exists("woid",$_REQUEST)) {
$woid = $_REQUEST['woid'];
} else {
$woid = 0;
}

if(array_key_exists("scid",$_REQUEST)) {
$scid = $_REQUEST['scid'];
} else {
$scid = 0;
}

$rwoid = $_REQUEST['rwoid'];

require_once("validate.php");


$rs_delrwo = "DELETE FROM rwo WHERE rwoid = '$rwoid'";
@mysqli_query($rs_connect, $rs_delrwo);


if(!array_key_exists("returnurl",$_REQUEST)) {
if($woid != 0) {
header("Location: index.php?pcwo=$woid");
} else {
header("Location: msp.php?func=viewservicecontract&scid=$scid");
}
} else {
$returnurl = $_REQUEST['returnurl'];
header("Location: $returnurl");
}

}




function editrwo() {


require_once("common.php");
require("dheader.php");


require("deps.php");

$pcid = $_REQUEST['pcid'];
$rwoid = $_REQUEST['rwoid'];

if(array_key_exists("woid",$_REQUEST)) {
$woid = $_REQUEST['woid'];
} else {
$woid = 0;
}

if(array_key_exists("scid",$_REQUEST)) {
$scid = $_REQUEST['scid'];
} else {
$scid = 0;
}


if(array_key_exists("returnurl",$_REQUEST)) {
$returnurl = $_REQUEST['returnurl'];
} else {

if($woid != 0) {
$returnurl = "index.php?pcwo=$woid";
} else {
$returnurl = "msp.php?func=viewservicecontract&scid=$scid";
}

}


if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}


$month1 = date('Y-m-d', strtotime("+1 month"));
$months2 = date('Y-m-d', strtotime("+2 month"));
$months3 = date('Y-m-d', strtotime("+3 month"));
$months6 = date('Y-m-d', strtotime("+6 month"));
$year1 = date('Y-m-d', strtotime("+1 year"));

$rs_foundrwo = "SELECT * FROM rwo WHERE rwoid = '$rwoid'";
$rs_result_frwo = mysqli_query($rs_connect, $rs_foundrwo);
$rs_result_frwo2 = mysqli_fetch_object($rs_result_frwo);
$rwodate = "$rs_result_frwo2->rwodate";
$rwointerval = "$rs_result_frwo2->rwointerval";
$rwotask = "$rs_result_frwo2->rwotask";
$rwostatus = "$rs_result_frwo2->rwostatus";
$tasksummary = "$rs_result_frwo2->tasksummary";
$rwostoreidindb = "$rs_result_frwo2->rwostoreid";

echo "<div data-role=\"header\" data-theme=\"b\"><h2>".pcrtlang("Edit Recurring WO")."</h2></div>";
echo "<div class=\"ui-content\" role=\"main\">";

echo "<form action=rwo.php?func=editrwo2 method=post data-ajax=\"false\">";
echo "<input type=hidden name=pcid value=$pcid>";
echo "<input type=hidden name=woid value=$woid>";
echo "<input type=hidden name=scid value=$scid>";
echo "<input type=hidden name=rwoid value=$rwoid>";
echo "<input type=hidden name=returnurl value=\"$returnurl\">";


echo pcrtlang("Next Recurrence");
echo "<select name=myoptions onchange='document.getElementById(\"notifydate\").value=this.options[this.selectedIndex].value'>";
echo "<option value=\"\">".pcrtlang("choose a date")."</option>";

echo "<option value=\"$month1\">$month1 &bull; ".pcrtlang("1 Month")."</option>";
echo "<option value=\"$months2\">$months2 &bull; ".pcrtlang("2 Months")."</option>";
echo "<option value=\"$months3\">$months3 &bull; ".pcrtlang("3 Months")."</option>";
echo "<option value=\"$months6\">$months6 &bull; ".pcrtlang("6 Months")."</option>";
echo "<option value=\"$year1\">$year1 &bull; ".pcrtlang("1 Year")."</option>";


echo "</select>";

echo "<input id=notifydate type=date name=rwodate value=\"$rwodate\">";


echo pcrtlang("Interval")."<select name=rwointerval>";

$intervals = array('1W' => pcrtlang('Weekly'),'2W' => pcrtlang('Every 2 Weeks'),'1M' => pcrtlang('Monthly'),'2M' => pcrtlang('Every 2 Months'),'3M' => pcrtlang('Quarterly'),'6M' => pcrtlang('Every 6 Months'),'1Y' => pcrtlang('Yearly'),'2Y' => pcrtlang('2 Years'));

foreach($intervals as $k => $v) {
if($rwointerval == "$k") {
echo "<option selected value=$k>$v</option>";
} else {
echo "<option value=$k>$v</option>";
}
}

echo "</select>";



if ($activestorecount > "1") {
echo pcrtlang("Assigned Store");

$rs_find_stores = "SELECT * FROM stores WHERE storeenabled = '1' ORDER BY storesname ASC";
$rs_result_stores = mysqli_query($rs_connect, $rs_find_stores);

echo "<select name=rwostoreid>";

while($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
$rwostoresnameindb = "$rs_result_storeq->storesname";
$rwostoreid = "$rs_result_storeq->storeid";

if ($rwostoreidindb == $rwostoreid) {
echo "<option selected value=$rwostoreid>$rwostoresnameindb</option>";
} else {
echo "<option value=$rwostoreid>$rwostoresnameindb</option>";
}
}

echo "</select>";

} else {
echo "<input type=hidden name=rwostoreid value=$rwostoreidindb>";
}



echo pcrtlang("Task Summary")."<input type=text name=tasksummary value=\"$tasksummary\">";

echo pcrtlang("Task")."<textarea name=rwotask>$rwotask</textarea>";

echo pcrtlang("Landing Status");

$statuscolors = getstatusselectorcolors();
$boxtitles = getboxtitles();

$statii = array(1,2,8,9,3,6);

$rs_qc = "SELECT * FROM boxstyles WHERE statusid > 99";
$rs_result1 = mysqli_query($rs_connect, $rs_qc);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$statusid = "$rs_result_q1->statusid";
$selectorcolor2 = "$rs_result_q1->selectorcolor";
$boxtitle2 = "$rs_result_q1->boxtitle";
$statii[] = $statusid;
}



echo "<select name=statnum>";

foreach($statii as $k => $v) {
if($rwostatus == "$v") {
echo "<option value=$v selected style=\"background:#$statuscolors[$v]\">$boxtitles[$v]</option>";
} else {
echo "<option value=$v style=\"background:#$statuscolors[$v]\">$boxtitles[$v]</option>";
}
}


echo "</select>";

echo "<input type=submit value=\"".pcrtlang("Save")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Saving")."...'; this.form.submit();\" data-theme=\"b\"></form>";

echo "</div>";
require("dfooter.php");


} 


function editrwo2() {

require("deps.php");
require_once("validate.php");
require("common.php");

$returnurl = $_REQUEST['returnurl'];
$pcid = $_REQUEST['pcid'];
$rwoid = $_REQUEST['rwoid'];
$rwotask = $_REQUEST['rwotask'];
$tasksummary = pv($_REQUEST['tasksummary']);
$rwodate = pv($_REQUEST['rwodate']);
$rwointerval = $_REQUEST['rwointerval'];
$statnum = $_REQUEST['statnum'];
$rwostoreid = $_REQUEST['rwostoreid'];

if(array_key_exists("woid",$_REQUEST)) {
$woid = $_REQUEST['woid'];
} else {
$woid = 0;
}

if(array_key_exists("scid",$_REQUEST)) {
$scid = $_REQUEST['scid'];
} else {
$scid = 0;
}

$rs_update_rwo = "UPDATE rwo SET rwotask = '$rwotask', tasksummary = '$tasksummary', rwodate = '$rwodate', rwointerval = '$rwointerval', rwostatus = '$statnum', rwostoreid = '$rwostoreid' WHERE rwoid = '$rwoid'";
@mysqli_query($rs_connect, $rs_update_rwo);

header("Location: $returnurl");


}

function runrwo() {
require_once("header.php");
require("deps.php");
require_once("common.php");

perm_boot("28");




echo "<h3>".pcrtlang("Process Recurring Work Orders")."</h3>";
echo "<form action=rwo.php?func=runrwo2 method=post data-ajax=\"false\">";
echo "<table class=\"standard\">";

$rs_rwo = "SELECT * FROM rwo WHERE rwodate < NOW() ORDER BY rwodate";
$rs_find_rwo = @mysqli_query($rs_connect, $rs_rwo);
$rwo_thecount = mysqli_num_rows($rs_find_rwo);

while($rs_find_rwo_q = mysqli_fetch_object($rs_find_rwo)) {
$rwoid = "$rs_find_rwo_q->rwoid";
$rwopcid = "$rs_find_rwo_q->pcid";
$rwodate = "$rs_find_rwo_q->rwodate";
$rwointerval = "$$rs_find_rwo_q->rwointerval";
$rwotask = "$rs_find_rwo_q->rwotask";
$rwostatus = "$rs_find_rwo_q->rwostatus";
$tasksummary = "$rs_find_rwo_q->tasksummary";
$rwostoreid = "$rs_find_rwo_q->rwostoreid";

$storeinfoarray = getstoreinfo($rwostoreid);

$rs_rwo_pcinfo = "SELECT pcname FROM pc_owner WHERE pcid = '$rwopcid'";
$rs_find_pcinfo_q = @mysqli_query($rs_connect, $rs_rwo_pcinfo);
$rs_find_pcinfo_qq = mysqli_fetch_object($rs_find_pcinfo_q);
$rwo_pcname = "$rs_find_pcinfo_qq->pcname";

echo "<tr><th colspan=2>$rwo_pcname</th></tr>";


if ($activestorecount > 1) {
echo "<tr><td>".pcrtlang("Store").":</td><td>$storeinfoarray[storesname]</td></tr>";
}

$returnurl = urlencode("../repair/rwo.php?func=runrwo");

echo "<tr><td>".pcrtlang("Date").":</td><td>$rwodate</td></tr>";

echo "<tr><td>".pcrtlang("Task Summary")."</td><td>$tasksummary</td></tr>";


echo "<tr>";
echo "<td colspan=2>";

echo "<button type=button onClick=\"parent.location='rwo.php?func=editrwo&rwoid=$rwoid&returnurl=$returnurl&pcid=$rwopcid&woid=0'\" class=\"ui-btn-inline ui-btn ui-shadow ui-corner-all\"><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("edit")."</button>";

echo "<a href=\"#popupdeleterwo$rwoid\" data-rel=\"popup\" data-position-to=\"window\" data-transition=\"pop\"
class=\"ui-btn-inline ui-btn ui-shadow ui-corner-all\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> remove</a>";
echo "<div data-role=\"popup\" id=\"popupdeleterwo$rwoid\" data-overlay-theme=\"b\"  data-theme=\"a\" data-dismissible=\"false\">";
echo "<div data-role=\"header\" data-theme=\"b\">";
echo "<h1>".pcrtlang("Delete")."?</h1>";
echo "</div>";
echo "<div role=\"main\" class=\"ui-content\">";
echo "<p>".pcrtlang("Are you sure you wish to delete this recurring work order?")."</p>";
echo "<div align=\"right\"><a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\" data-inline=\"true\">
<i class=\"fa fa-ban fa-lg\"></i> ".pcrtlang("Cancel")."</a>";
echo "<button onClick=\"parent.location='rwo.php?func=deleterwo&pcid=$rwopcid&rwoid=$rwoid&woid=0&returnurl=$returnurl'\" data-inline=\"true\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")." </button></div>";
echo "</div>";
echo "</div>";



echo "</td></tr>";


echo "<tr><td colspan=2>";

echo "\n<input type=checkbox checked name=grwoid[] value=\"$rwoid\" id=process$rwoid> <label for=process$rwoid><font class=text12b>".pcrtlang("Create Work Order")."</font></label>";

echo "\n<input type=checkbox name=srwoid[] value=\"$rwoid\" id=skip$rwoid> <label for=skip$rwoid><font class=text12b>".pcrtlang("Skip this Recurrence")."</font></label>";

echo "</td>";

echo "</tr>";


}

echo "</table>";
if ($rwo_thecount != "0") {
echo "<br><br><button type=submit class=button><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Create Work Orders")."<br><i class=\"fa fa-forward fa-lg\"></i> ".pcrtlang("Skip Recurrences")."</button>";
} else {
echo "<font class=textgray12i><br>".pcrtlang("No Recurring Work Orders Due")."</font><br><br>";
}

echo "</form>";


echo "<br>";


require_once("footer.php");
}


function runrwo2() {
require_once("validate.php");
require("deps.php");
require("common.php");

perm_boot("28");

if (array_key_exists('grwoid',$_REQUEST)) {
$grwoid = $_REQUEST['grwoid'];
} else {
$grwoid = array();
}

if (array_key_exists('srwoid',$_REQUEST)) {
$srwoid = $_REQUEST['srwoid'];
} else {
$srwoid = array();
}


if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');


foreach($grwoid as $key => $rwoid) {
if(!in_array($rwoid, $srwoid)) {
$rs_rwo = "SELECT * FROM rwo WHERE rwoid = '$rwoid'";
$rs_find_rwo = @mysqli_query($rs_connect, $rs_rwo);
$rs_find_rwo_q = mysqli_fetch_object($rs_find_rwo);
$rwopcid = "$rs_find_rwo_q->pcid";
$rwodate = "$rs_find_rwo_q->rwodate";
$rwointerval = pv("$rs_find_rwo_q->rwointerval");
$rwotask = pv("$rs_find_rwo_q->rwotask");
$rwostatus = "$rs_find_rwo_q->rwostatus";
$tasksummary = pv("$rs_find_rwo_q->tasksummary");
$rwostoreid = "$rs_find_rwo_q->rwostoreid";

$rs_insert_wo = "INSERT INTO pc_wo (pcid,probdesc,dropdate,pcstatus,cibyuser,storeid) VALUES  ('$rwopcid','$tasksummary\n\n$rwotask','$currentdatetime','$rwostatus','$ipofpc','$rwostoreid')";
@mysqli_query($rs_connect, $rs_insert_wo);

if ($rwointerval == "1W") {
$thedatesql = "DATE_ADD(rwodate, INTERVAL 1 week)";
} elseif ($rwointerval == "2W") {
$thedatesql = "DATE_ADD(rwodate, INTERVAL 2 week)";
} elseif ($rwointerval == "1M") {
$thedatesql = "DATE_ADD(rwodate, INTERVAL 1 month)";
} elseif ($rwointerval == "2M") {
$thedatesql = "DATE_ADD(rwodate, INTERVAL 2 month)";
} elseif ($rwointerval == "3M") {
$thedatesql = "DATE_ADD(rwodate, INTERVAL 3 month)";
} elseif ($rwointerval == "6M") {
$thedatesql = "DATE_ADD(rwodate, INTERVAL 6 month)";
} elseif ($rwointerval == "1Y") {
$thedatesql = "DATE_ADD(rwodate, INTERVAL 1 year)";
} elseif ($rwointerval == "2Y") {
$thedatesql = "DATE_ADD(rwodate, INTERVAL 2 year)";
} else {
die("Error: Unhandled Interval 1 $rwointerval");
}

$rs_update_rwo = "UPDATE rwo SET rwodate = $thedatesql WHERE rwoid = '$rwoid'";
@mysqli_query($rs_connect, $rs_update_rwo);

###
}
}


foreach($srwoid as $key => $rwoid) {

$rs_rwo = "SELECT * FROM rwo WHERE rwoid = '$rwoid'";
$rs_find_rwo = @mysqli_query($rs_connect, $rs_rwo);
$rs_find_rwo_q = mysqli_fetch_object($rs_find_rwo);
$rwointerval = "$rs_find_rwo_q->rwointerval";


if ($rwointerval == "1W") {
$thedatesql = "DATE_ADD(rwodate, INTERVAL 1 week)";
} elseif ($rwointerval == "2W") {
$thedatesql = "DATE_ADD(rwodate, INTERVAL 2 week)";
} elseif ($rwointerval == "1M") {
$thedatesql = "DATE_ADD(rwodate, INTERVAL 1 month)";
} elseif ($rwointerval == "2M") {
$thedatesql = "DATE_ADD(rwodate, INTERVAL 2 month)";
} elseif ($rwointerval == "3M") {
$thedatesql = "DATE_ADD(rwodate, INTERVAL 3 month)";
} elseif ($rwointerval == "6M") {
$thedatesql = "DATE_ADD(rwodate, INTERVAL 6 month)";
} elseif ($rwointerval == "1Y") {
$thedatesql = "DATE_ADD(rwodate, INTERVAL 1 year)";
} elseif ($rwointerval == "2Y") {
$thedatesql = "DATE_ADD(rwodate, INTERVAL 2 year)";
} else {
die("Error: Unhandled Interval 2 $rwointerval");
}

$rs_update_rwo = "UPDATE rwo SET rwodate = $thedatesql WHERE rwoid = '$rwoid'";
@mysqli_query($rs_connect, $rs_update_rwo);

}


header("Location: rwo.php?func=runrwo");

}





switch($func) {
                                                                                                    
    default:
    nothing();
    break;
                                
    case "addrwo":
    addrwo();
    break;

    case "addrwo2":
    addrwo2();
    break;

    case "editrwo":
    editrwo();
    break;

    case "editrwo2":
    editrwo2();
    break;

   case "deleterwo":
    deleterwo();
    break;

   case "marksentsr":
    marksentsr();
    break;

  case "browsesr":
    browsesr();
    break;

  case "runrwo":
    runrwo();
    break;

  case "runrwo2":
    runrwo2();
    break;




}

?>
