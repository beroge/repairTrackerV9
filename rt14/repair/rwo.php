<?php
                                                                                                    
/***************************************************************************
 *   copyright            : (C) 2017 PCRepairTracker.com
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

if($gomodal != "1") {
require("header.php");
} else {
require_once("validate.php");
}

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}

$month1 = date('Y-m-d', strtotime("+1 month"));
$months2 = date('Y-m-d', strtotime("+2 month"));
$months3 = date('Y-m-d', strtotime("+3 month"));
$months6 = date('Y-m-d', strtotime("+6 month"));
$year1 = date('Y-m-d', strtotime("+1 year"));

$thenow = date('Y-m-d');


if($gomodal != "1") {
start_blue_box(pcrtlang("Add Recurring Work Order"));
} else {
echo "<h4>".pcrtlang("Add Recurring Work Order")."</h4><br><br>";
}

echo "<form action=rwo.php?func=addrwo2 method=post id=catcheditrwoform>";
echo "<input type=hidden name=pcid value=$pcid>";
echo "<input type=hidden name=woid value=$woid>";
echo "<input type=hidden name=scid value=$scid>";
echo "<table width=100%>";


echo "<tr><td>".pcrtlang("Next Recurrence").":</td>";
echo "<td><select name=myoptions onchange='document.getElementById(\"notifydate\").value=this.options[this.selectedIndex].value'>";
echo "<option value=\"\">".pcrtlang("choose a date")."</option>";

echo "<option value=\"$month1\">$month1 &bull; ".pcrtlang("1 Month")."</option>";
echo "<option value=\"$months2\">$months2 &bull; ".pcrtlang("2 Months")."</option>";
echo "<option value=\"$months3\">$months3 &bull; ".pcrtlang("3 Months")."</option>";
echo "<option value=\"$months6\">$months6 &bull; ".pcrtlang("6 Months")."</option>";
echo "<option value=\"$year1\">$year1 &bull; ".pcrtlang("1 Year")."</option>";


echo "</select></td></tr>";

echo "<tr><td></td><td><input id=notifydate size=11 type=text name=notifydate class=textboxw value=\"$thenow\"></td></tr>";


if(!isset($pcrt_weekstart)) {
$pcrt_weekstart = "Sunday";
}
if ($pcrt_weekstart == "Sunday") {
echo "<script type=\"text/javascript\" src=\"jq/datepickr.js\"></script>";
} else {
echo "<script type=\"text/javascript\" src=\"jq/datepickr2.js\"></script>";
}


?>
<script type="text/javascript">
new datepickr('notifydate', { dateFormat: 'Y-m-d', theCurrentDate: document.getElementById("notifydate").value });
</script>
<?php




echo "<tr><td>".pcrtlang("Interval").":</td><td><select name=interval>";

$intervals = array('1W' => pcrtlang('Weekly'),'2W' => pcrtlang('Every 2 Weeks'),'1M' => pcrtlang('Monthly'),'2M' => pcrtlang('Every 2 Months'),'3M' => pcrtlang('Quarterly'),'6M' => pcrtlang('Every 6 Months'),'1Y' => pcrtlang('Yearly'),'2Y' => pcrtlang('2 Years'));

foreach($intervals as $k => $v) {
echo "<option value=$k>$v</option>";
}

echo "</select>";

echo "</td></tr>";


if ($activestorecount > "1") {
echo "<tr><td>".pcrtlang("Assigned Store")."</td><td>";

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

echo "</td></tr>";
} else {
echo "<tr><td>&nbsp;</td><td><input type=hidden name=rwostoreid value=$defaultuserstore></td></tr>";
}




echo "<tr><td>".pcrtlang("Task Summary")."</td><td><input type=text name=tasksummary class=textboxw size=50></td></tr>";

echo "<tr><td>".pcrtlang("Task")."</td><td><textarea class=textbox name=message cols=80></textarea></td></tr>";

echo "<tr><td>".pcrtlang("Landing Status")."</td><td>";

$statuscolors = getstatusselectorcolors();
$boxtitles = getboxtitles();


$coptions = "";
$rs_qc = "SELECT * FROM boxstyles WHERE statusid > 99";
$rs_result1 = mysqli_query($rs_connect, $rs_qc);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$statusid = "$rs_result_q1->statusid";
$selectorcolor2 = "$rs_result_q1->selectorcolor";
$boxtitle2 = "$rs_result_q1->boxtitle";
$coptions .= "<option value=\"$statusid\" class=statusdrop style=\"background:#$selectorcolor2\">$boxtitle2</option>";
}



echo "<select name=statnum>
<option value=1 class=statusdrop style=\"background:#$statuscolors[1]\">$boxtitles[1]</option>
<option selected value=2 class=statusdrop style=\"background:#$statuscolors[2]\">$boxtitles[2]</option>
<option value=8 class=statusdrop style=\"background:#$statuscolors[8]\">$boxtitles[8]</option>
<option value=9 class=statusdrop style=\"background:#$statuscolors[9]\">$boxtitles[9]</option>
<option value=3 class=statusdrop style=\"background:#$statuscolors[3]\">$boxtitles[3]</option>
<option value=6 class=statusdrop style=\"background:#$statuscolors[6]\">$boxtitles[6]</option>";
echo "$coptions";

echo "</select></td></tr>";





echo "<tr><td colspan=2><input type=submit class=button value=\"".pcrtlang("Save")."\"></form></td></tr>";
echo "</table>";

if($gomodal != 1) {
stop_blue_box();
}

if($gomodal != 1) {
require_once("footer.php");
}

if($woid != 0) {
?>
<script type='text/javascript'>
$(document).ready(function(){
$('#catcheditrwoform').submit(function(e) { // catch the form's submit event
        e.preventDefault();
        $('.ajaxspinner').toggle();
        $.ajax({ // create an AJAX call...
        data: $(this).serialize(), // get the form data
        type: $(this).attr('method'), // GET or POST
        url: $(this).attr('action'), // the file to call
        success: function(response) { // on success..
                $.get('ajaxhelpers.php?func=rwoarea&pcwo=<?php echo "$woid"; ?>&pcid=<?php echo "$pcid"; ?>', function(data) {
                $('#rwoarea').html(data);
                $('.ajaxspinner').toggle();
                });
                $(document).trigger('close.facebox');
    }
    });
});
});
</script>
<?php
}


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
} elseif ($scid != 0) {
header("Location: msp.php?func=viewservicecontract&scid=$scid");
} else {
header("Location: pc.php?func=showpc&pcid=$pcid");
}



}


function deleterwo() {

require("deps.php");
require("common.php");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
} 

$rwoid = $_REQUEST['rwoid'];

if(array_key_exists("woid",$_REQUEST)) {
$woid = $_REQUEST['woid'];
} else {
$woid = 0;
}

if(array_key_exists("pcid",$_REQUEST)) {
$pcid = $_REQUEST['pcid'];
} else {
$pcid = 0;
}


if(array_key_exists("scid",$_REQUEST)) {
$scid = $_REQUEST['scid'];
} else {
$scid = 0;
}


require_once("validate.php");


$rs_delrwo = "DELETE FROM rwo WHERE rwoid = '$rwoid'";
@mysqli_query($rs_connect, $rs_delrwo);


if(!array_key_exists("returnurl",$_REQUEST)) {
if($woid != 0) {
header("Location: index.php?pcwo=$woid");
} elseif($scid != 0) {
header("Location: msp.php?func=viewservicecontract&scid=$scid");
} else {
header("Location: pc.php?func=showpc&pcid=$pcid");
}
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



function editrwo() {


if(array_key_exists("nomodal",$_REQUEST)) {
$nomodal = $_REQUEST['nomodal'];
} else {
$nomodal = "";
}


require_once("common.php");
if(($gomodal != "1") || ($nomodal == "nomodal")) {
require("header.php");
} else {
require_once("validate.php");
}


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
} elseif($scid != 0) {
$returnurl = "msp.php?func=viewservicecontract&scid=$scid";
} else {
$returnurl = "pc.php?func=showpc&pcid=$pcid";
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
$pcid = "$rs_result_frwo2->pcid";

$boxtitle = pcrtlang("Edit Recurring Work Order");

if(($gomodal != "1") || ($nomodal == "nomodal")) {
start_blue_box("$boxtitle");
} else {
echo "<h4>$boxtitle</h4><br><br>";
}

echo "<form action=rwo.php?func=editrwo2 method=post id=catcheditrwoform>";
echo "<input type=hidden name=pcid value=$pcid>";
echo "<input type=hidden name=woid value=$woid>";
echo "<input type=hidden name=scid value=$scid>";
echo "<input type=hidden name=rwoid value=$rwoid>";
echo "<input type=hidden name=returnurl value=\"$returnurl\">";

echo "<table width=100%>";

echo "<tr><td>".pcrtlang("Next Recurrence").":</td>";
echo "<td><select name=myoptions onchange='document.getElementById(\"notifydate\").value=this.options[this.selectedIndex].value'>";
echo "<option value=\"\">".pcrtlang("choose a date")."</option>";

echo "<option value=\"$month1\">$month1 &bull; ".pcrtlang("1 Month")."</option>";
echo "<option value=\"$months2\">$months2 &bull; ".pcrtlang("2 Months")."</option>";
echo "<option value=\"$months3\">$months3 &bull; ".pcrtlang("3 Months")."</option>";
echo "<option value=\"$months6\">$months6 &bull; ".pcrtlang("6 Months")."</option>";
echo "<option value=\"$year1\">$year1 &bull; ".pcrtlang("1 Year")."</option>";


echo "</select></td></tr>";

echo "<tr><td></td><td><input id=notifydate size=11 type=text name=rwodate class=textboxw value=\"$rwodate\"></td></tr>";


if(!isset($pcrt_weekstart)) {
$pcrt_weekstart = "Sunday";
}
if ($pcrt_weekstart == "Sunday") {
echo "<script type=\"text/javascript\" src=\"jq/datepickr.js\"></script>";
} else {
echo "<script type=\"text/javascript\" src=\"jq/datepickr2.js\"></script>";
}


?>
<script type="text/javascript">
new datepickr('notifydate', { dateFormat: 'Y-m-d', theCurrentDate: document.getElementById("notifydate").value });
</script>
<?php

echo "<tr><td>".pcrtlang("Interval").":</td><td><select name=rwointerval>";

$intervals = array('1W' => pcrtlang('Weekly'),'2W' => pcrtlang('Every 2 Weeks'),'1M' => pcrtlang('Monthly'),'2M' => pcrtlang('Every 2 Months'),'3M' => pcrtlang('Quarterly'),'6M' => pcrtlang('Every 6 Months'),'1Y' => pcrtlang('Yearly'),'2Y' => pcrtlang('2 Years'));

foreach($intervals as $k => $v) {
if($rwointerval == "$k") {
echo "<option selected value=$k>$v</option>";
} else {
echo "<option value=$k>$v</option>";
}
}

echo "</select>";

echo "</td></tr>";


if ($activestorecount > "1") {
echo "<tr><td>".pcrtlang("Assigned Store")."</td><td>";

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

echo "</td></tr>";
} else {
echo "<tr><td>&nbsp;</td><td><input type=hidden name=rwostoreid value=$rwostoreidindb></td></tr>";
}



echo "<tr><td>".pcrtlang("Task Summary")."</td><td><input type=text name=tasksummary class=textboxw size=50 value=\"$tasksummary\"></td></tr>";

echo "<tr><td>".pcrtlang("Task")."</td><td><textarea class=textbox name=rwotask cols=80>$rwotask</textarea></td></tr>";

echo "<tr><td>".pcrtlang("Landing Status")."</td><td>";

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
echo "<option value=$v selected class=statusdrop style=\"background:#$statuscolors[$v]\">$boxtitles[$v]</option>";
} else {
echo "<option value=$v class=statusdrop style=\"background:#$statuscolors[$v]\">$boxtitles[$v]</option>";
}
}


echo "</select></td></tr>";

echo "<tr><td colspan=2><input type=submit class=button value=\"".pcrtlang("Save")."\"></form></td></tr>";
echo "</table>";

if(($gomodal != "1") || ($nomodal == "nomodal")) {
stop_blue_box();
require_once("footer.php");
}

if($woid != 0) {
?>
<script type='text/javascript'>
$(document).ready(function(){
$('#catcheditrwoform').submit(function(e) { // catch the form's submit event
        e.preventDefault();
        $('.ajaxspinner').toggle();
        $.ajax({ // create an AJAX call...
        data: $(this).serialize(), // get the form data
        type: $(this).attr('method'), // GET or POST
        url: $(this).attr('action'), // the file to call
        success: function(response) { // on success..
                $.get('ajaxhelpers.php?func=rwoarea&pcwo=<?php echo "$woid"; ?>&pcid=<?php echo "$pcid"; ?>', function(data) {
                $('#rwoarea').html(data);
		$('.ajaxspinner').toggle();
                });
                $(document).trigger('close.facebox');
    }
    });
});
});
</script>
<?php
}

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


if ($gomodal == 1) {
$therel = "rel=facebox";
} else {
$therel = "";
}


start_color_box("50",pcrtlang("Process Recurring Work Orders"));
echo "<form action=rwo.php?func=runrwo2 method=post>";
echo "<table class=\"doublestandard\">";
echo "<tr><th>".pcrtlang("Customer Name")."&nbsp;&nbsp;</th>";

if ($activestorecount > 1) {
echo "<th>".pcrtlang("Store")."</th>";
}

echo "<th>".pcrtlang("Date")."</th>";
echo "<th> ".pcrtlang("Task Summary")." &nbsp;&nbsp;</th><th>".pcrtlang("Actions")."&nbsp;&nbsp;</th></tr>";

$a = 3;

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

echo "\n<tr><td style=\"vertical-align:top;\">$rwo_pcname</td>";


if ($activestorecount > 1) {
echo "<td style=\"vertical-align:top;\">$storeinfoarray[storesname]</td>";
}

$returnurl = urlencode("../repair/rwo.php?func=runrwo");

echo "<td style=\"vertical-align:top;\">$rwodate";

echo "</td><td>$tasksummary<br>";


echo "</td>";
echo "<td style=\"vertical-align:top;\"><a href=rwo.php?func=editrwo&rwoid=$rwoid&returnurl=$returnurl&pcid=$rwopcid&woid=0 $therel class=\"linkbuttonsmall linkbuttongray\"><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("Edit")."</a>";

echo "<a href=rwo.php?func=deleterwo&pcid=$rwopcid&rwoid=$rwoid&woid=0&returnurl=$returnurl class=\"linkbuttonsmall linkbuttongray\"><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")."</a>";
echo "</td></tr>";


if ($activestorecount > 1) {
echo "<tr><td colspan=4>";
} else {
echo "<tr><td colspan=3>";
}

echo "\n<input type=checkbox checked name=grwoid[] value=\"$rwoid\" id=process$rwoid> <label for=process$rwoid>".pcrtlang("Create Work Order")."</label><br>";

echo "\n<input type=checkbox name=srwoid[] value=\"$rwoid\" id=skip$rwoid> <label for=skip$rwoid>".pcrtlang("Skip this Recurrence")."</label><br>";

echo "</td>";

echo "<td colspan=3>";

echo "</td></tr>";

$a++;

}

echo "</table>";
if ($rwo_thecount != "0") {
echo "<br><br><button type=submit class=button><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Create Work Orders")." &nbsp;&nbsp;&nbsp;&nbsp; <i class=\"fa fa-forward fa-lg\"></i> ".pcrtlang("Skip Recurrences")."</button>";
} else {
echo "<span class=\"italme colormegray\"><br>".pcrtlang("No Recurring Work Orders Due")."</span><br><br>";
}

echo "</form>";

stop_color_box();

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



function browserwo() {

require("deps.php");
require_once("common.php");

require_once("header.php");

echo "<script type=\"text/javascript\">document.title = \"".pcrtlang("Recurring Work Orders")."\";</script>";

if (array_key_exists("pageNumber", $_REQUEST)) {
$pageNumber = $_REQUEST['pageNumber'];
} else {
$pageNumber = 1;
}

if (array_key_exists("sortby", $_REQUEST)) {
$sortby = $_REQUEST['sortby'];
} else {
$sortby = "date_asc";
}

if (array_key_exists("search", $_REQUEST)) {
$search = $_REQUEST['search'];
} else {
$search = "";
}

$search_ue = urlencode($search);

start_blue_box(pcrtlang("Browse Recurring Work Orders"));

echo "<table style=\"width:100%\"><tr><td>";
echo "</td><td style=\"text-align:right\">";
echo "<i class=\"fa fa-search fa-lg\"></i> <input type=text class=textbox id=searchbox placeholder=\"".pcrtlang("Enter Search Text")."\" value=\"$search\">";
echo "</td></tr></table><br>";

echo "<div id=themain>";

echo "</div>";

?>

<script type="text/javascript">
$(document).ready(function () {
     $.get('rwo.php?func=browserwoajax&pageNumber=<?php echo $pageNumber; ?>&sortby=<?php echo $sortby; ?>&search=<?php echo $search_ue; ?>', function(data) {
     $('#themain').html(data);
     });
});
</script>



<script type="text/javascript">
$(document).ready(function(){
  var globalTimeoutrs = null;
  $("input#searchbox").keyup(function(){
                        if (globalTimeoutrs != null) {
                        clearTimeout(globalTimeoutrs);
                        }
                        var encodedinv = encodeURIComponent(this.value);
                        var searchlength = this.value.length;
                        globalTimeoutrs = setTimeout(function() {
                        globalTimeoutrs = null;
                                if(searchlength<3) {
                                        $('div#themain').load('rwo.php?func=browserwoajax&pageNumber=<?php echo $pageNumber; ?>&sortby=<?php echo $sortby; ?>').slideDown(200,function(){
                                        return false;
                                        });
                                }else{
                                        $('div#themain').load('rwo.php?func=browserwoajax&pageNumber=<?php echo $pageNumber; ?>&sortby=<?php echo $sortby; ?>&search='+encodedinv).slideDown(200);
                                }
                        }, 500);
  });
});
</script>



<?php

stop_blue_box();

require("footer.php");

}




function browserwoajax() {

require("deps.php");
require_once("validate.php");
require_once("common.php");


if (array_key_exists("pageNumber", $_REQUEST)) {
$pageNumber = $_REQUEST['pageNumber'];
} else {
$pageNumber = 1;
}

if (array_key_exists("sortby", $_REQUEST)) {
$sortby = $_REQUEST['sortby'];
} else {
$sortby = "date_asc";
}



$results_per_page = 40;

if ($pageNumber == "") {
$offset = "0";
} else {
$offset = ($pageNumber * $results_per_page) - $results_per_page;
}

if (array_key_exists("search", $_REQUEST)) {
$search = $_REQUEST['search'];
if($search != "") {
$searchsql = "AND (rwo.rwotask LIKE '%$search%' OR pc_owner.pcname LIKE '%$search%' OR pc_owner.pccompany LIKE '%$search%')";
} else {
$searchsql = "";
$search = "";
}
} else {
$searchsql = "";
$search = "";
}

$search_ue = urlencode($search);

if ("$sortby" == "woid_asc") {
$rs_find_rwo = "SELECT * FROM rwo,pc_owner WHERE rwo.pcid = pc_owner.pcid $searchsql ORDER BY rwo.pcid ASC LIMIT $offset,$results_per_page";
} elseif ("$sortby" == "woid_desc") {
$rs_find_rwo = "SELECT * FROM rwo,pc_owner WHERE rwo.pcid = pc_owner.pcid $searchsql ORDER BY rwo.pcid DESC LIMIT $offset,$results_per_page";
} elseif ("$sortby" == "date_desc") {
$rs_find_rwo = "SELECT * FROM rwo,pc_owner WHERE rwo.pcid = pc_owner.pcid $searchsql ORDER BY rwo.rwodate DESC LIMIT $offset,$results_per_page";
} else {
$rs_find_rwo = "SELECT * FROM rwo,pc_owner WHERE rwo.pcid = pc_owner.pcid $searchsql ORDER BY rwo.rwodate ASC LIMIT $offset,$results_per_page";
}


$rs_result = mysqli_query($rs_connect, $rs_find_rwo);


$rs_find_rwo_total = "SELECT * FROM rwo";
$rs_result_total = mysqli_query($rs_connect, $rs_find_rwo_total);

$totalentries = mysqli_num_rows($rs_result_total);
$lastpage = $totalentries / $results_per_page;
if($lastpage != floor($lastpage)) {
$lastpage = floor($lastpage) + 1;
}

if($pageNumber > $lastpage) {
$pageNumber = 1;
$offset = 0;
}

echo "<table class=standard>";
echo "<tr><th>".pcrtlang("Asset ID")."#";
echo "</th><th><a href=rwo.php?func=browserwo&pageNumber=$pageNumber&sortby=woid_asc&search=$search_ue class=\"linkbuttontiny linkbuttongray radiustop\">
<i class=\"fa fa-chevron-up\"></i></a><br>";
echo "<a href=rwo.php?func=browserwo&pageNumber=$pageNumber&sortby=woid_desc&search=$search_ue class=\"linkbuttontiny linkbuttongray radiusbottom\">
<i class=\"fa fa-chevron-down\"></i></a>";
echo "</th><th>".pcrtlang("Next Recurrence");
echo "</th><th><a href=rwo.php?func=browserwo&pageNumber=$pageNumber&sortby=date_asc&search=$search_ue class=\"linkbuttontiny linkbuttongray radiustop\">
<i class=\"fa fa-chevron-up\"></i></a><br>";
echo "<a href=rwo.php?func=browserwo&pageNumber=$pageNumber&sortby=date_desc&search=$search_ue class=\"linkbuttontiny linkbuttongray radiusbottom\">
<i class=\"fa fa-chevron-down\"></i></a>";
echo "</th><th>".pcrtlang("Customer")."</th><th style=\"width:40%\">".pcrtlang("Task")."</th><th></th><th></th>";
echo "</tr>";
while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rwoid = "$rs_result_q->rwoid";
$pcid = "$rs_result_q->pcid";
$rwodate = "$rs_result_q->rwodate";
$rwointerval = "$rs_result_q->rwointerval";
$rwotask = "$rs_result_q->rwotask";

$rs_rwo_pcinfo = "SELECT pcname,pccompany FROM pc_owner WHERE pcid = '$pcid'";
$rs_find_pcinfo_q = @mysqli_query($rs_connect, $rs_rwo_pcinfo);
$rs_find_pcinfo_qq = mysqli_fetch_object($rs_find_pcinfo_q);
$rwo_name = "$rs_find_pcinfo_qq->pcname";
$rwo_company = "$rs_find_pcinfo_qq->pccompany";

#wip

$rwodate2 = pcrtdate("$pcrt_shortdate", "$rwodate");

$returnurl = urlencode("rwo.php?func=browserwo&pageNumber=$pageNumber&sortby=$sortby&search=$search");

echo "<tr><td style=\"width:70px;\" colspan=2><a href=pc.php?func=showpc&pcid=$pcid class=\"linkbuttonsmall linkbuttongray radiusall\">#$pcid</a></td>";

echo "<td style=\"width:150px;\" colspan=2>$rwodate2 <span class=floatright>$rwointerval</span></td>";

echo "<td style=\"width:150px;\"><span class=boldme>$rwo_name</span>";

if("$rwo_company" != "") {
echo "<br><span class=\"sizemesmaller\">$rwo_company</span>";
}

echo "</td>";


echo "<td>$rwotask</td>";




echo "<td>";


echo "<a href=rwo.php?func=editrwo&rwoid=$rwoid&returnurl=$returnurl&pcid=$pcid&woid=0&nomodal=nomodal class=\"linkbuttonsmall linkbuttongray radiusall\">
<i class=\"fa fa-edit fa-lg\"></i></a>";

echo "</td><td><a href=rwo.php?func=deleterwo&pcid=$pcid&rwoid=$rwoid&woid=0&returnurl=$returnurl class=\"linkbuttonsmall linkbuttonred radiusall\">
<i class=\"fa fa-trash fa-lg\"></i></a>";


echo "</td>";



echo "</tr>";

}

echo "</table>";

echo "<br>";

#browse here

echo "<center>";

if($pageNumber != 1) {
$prevpage = $pageNumber - 1;
echo "<a href=rwo.php?func=browserwo&pageNumber=$prevpage&sortby=$sortby&search=$search_ue class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-left fa-lg\"></i></a>";
}

$html = get_paged_nav($totalentries, $results_per_page, false);
$html = str_replace("browserwoajax", "browserwo", "$html");
echo "$html";

if($lastpage != $pageNumber) {
$nextpage = $pageNumber + 1;
echo "<a href=rwo.php?func=browserwo&pageNumber=$nextpage&sortby=$sortby&search=$search_ue class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-right fa-lg\"></i></a>";
}

echo "</center>";

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

  case "browserwo":
    browserwo();
    break;

  case "browserwoajax":
    browserwoajax();
    break;


}
