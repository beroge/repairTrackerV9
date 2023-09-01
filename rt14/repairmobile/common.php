<?php

/***************************************************************************
 *   copyright            : (C) 2017 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/

require("deps.php");
require("validate.php");

$rs_ql = "SELECT gomodal,autoprint,touchview,floatbar,defaultstore,statusview,narrow,narrowct FROM users WHERE username = '$ipofpc'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$gomodal = "$rs_result_q1->gomodal";
$autoprint = "$rs_result_q1->autoprint";
$touchview = "$rs_result_q1->touchview";
$floatbar = "$rs_result_q1->floatbar";
$defaultuserstore = "$rs_result_q1->defaultstore";
$statusview = "$rs_result_q1->statusview";
$receiptsnarrow = "$rs_result_q1->narrow";
$narrowct = "$rs_result_q1->narrowct";

function skedwhen($thetime) {
require("deps.php");
if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$thetimestamp = strtotime($thetime);

$thetimestamptommorrow = time() + 86400;
$thenowday = date("d");

$thecheckday = date("d", $thetimestamp);

$thetomorrowday = date("d", $thetimestamptommorrow);

if($thenowday == $thecheckday) {
echo "<font class=textred12b>".pcrtlang("Today @")." ";
echo date("g:i a", $thetimestamp)."</font>";
} elseif($thetomorrowday == $thecheckday) {
echo "<font class=textblue12b>".pcrtlang("Tomorrow @")." ";
echo date("g:i a", $thetimestamp)."</font>";
} elseif(time() > $thetimestamp) {
echo "<font class=textred12b>".pcrtlang("Past Due").": ";
echo elaps($thetime)."</font>";
} else {
echo "<font class=text10b>".date("Y-m-d g:i a", $thetimestamp)."</font>";
}
}


function start_status_box_plain($status_title) {
	$boxstyle = getboxstyle(50);
	echo "<div class=statusboxtop style=\"background: #$boxstyle[selectorcolor]\"><font class=textwhiteregular>$status_title</font></div>";
}

function stop_status_box_plain() {
        echo "</div>\n";
}

function start_gray_box($gray_title) {
        echo "<div class=colortitletopround><font class=textwhite16b>$gray_title</font></div><div class=whitebottom>";
}

function stop_gray_box() {
        echo "</div>\n";
}



function start_status_box($statusid,$status_title) {
	$boxstyle = getboxstyle($statusid);
        echo "<div class=\"statusboxtop\" style=\"background:#$boxstyle[selectorcolor];border-color:#$boxstyle[selectorcolor]\">\n";
        echo "<font class=textwhiteregular>$status_title</font></div>\n";
}


function start_status_box_collapsed($statusid,$status_title) {
        $boxstyle = getboxstyle($statusid);
        echo "<div class=\"statusboxtop\" style=\"background:#$boxstyle[selectorcolor];border-color:#$boxstyle[selectorcolor]\">\n";
        echo "<font class=textwhiteregular>$status_title</font>";

if($statusid == "4") {
echo "<a href=pc.php?func=checkoutpc style=\"padding:3px;\" class=\"linkbuttonsmall linkbuttonopaque radiusall floatright\">
<i class=\"fa fa-chevron-right fa-lg\"></i></a>";
} else {
echo "<a href=pc.php?func=viewassetstatus&pcstatus=$statusid  style=\"float:right;padding:2px; margin-top:0px;\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline ui-mini\"  data-ajax=\"false\">
 <i class=\"fa fa-chevron-right fa-lg\"></i> </a>";
}

echo "</div>\n";
}



function stop_status_box() {
        echo "</div>\n";
}

function dheader($title) {
echo "<div data-role=\"header\" data-theme=\"b\"><h2>$title</h2></div>";
echo "<div class=\"ui-content\" role=\"main\">";
}

function dfooter() {
        echo "</div>\n";
}


function start_box() {
        echo "<div class=startbox>\n";
}

function start_box_nested() {
        echo "<div class=startbox_nested>\n";
}

function start_repaircartitem() {
        echo "<div class=repaircartitem>\n";
}


function start_box_cb($bgcolor) {
        echo "<div style=\"background:#$bgcolor;\" class=colorbox>\n";
}

function start_box_touch($bgcolor) {
        echo "<div style=\"border:#$bgcolor 7px solid;\" class=touchbox>\n";
}


function start_box_sn($bgcolor,$bgcolor2,$bordercolor) {
        echo "<div style=\"padding:4px; border:2px solid #$bordercolor; background:#$bgcolor; background: linear-gradient(to bottom, #$bgcolor 0%, #$bgcolor2 100%); border-radius:3px;\"  class=colorboxsn>\n";
}


function start_box_cb_nested($bgcolor) {
        echo "<div style=\"background:#$bgcolor\" class=colorbox_nested>\n";
}


function stop_box() {
        echo "</div>\n";
}

function start_moneybox() {
        echo "<div class=moneybox>\n";
}

function start_moneybox_nested() {
        echo "<div class=moneybox_nested>\n";
}


function customerstatuscheck($woid,$statusid) {
require("deps.php");




$checkcustlook = "SELECT refid FROM userlog WHERE actionid = '23' AND refid = '$woid'";
$checkcustlookq = mysqli_query($rs_connect, $checkcustlook);
$totalcustchecks = mysqli_num_rows($checkcustlookq);

$checkarray = array();

if($totalcustchecks > 0) {

$checkcustlooklast = "SELECT thedatetime FROM userlog WHERE actionid = '23' AND refid = '$woid' ORDER BY thedatetime DESC LIMIT 1";
$checkcustlookqlast = mysqli_query($rs_connect, $checkcustlooklast);
$custlookfetch = mysqli_fetch_object($checkcustlookqlast);
$lasttime = "$custlookfetch->thedatetime";
$checkarray['lasttime'] = date("F j, Y, g:i a", strtotime($lasttime));
$checkarray['thetimes'] = $totalcustchecks;


}

return $checkarray;

}




function pclogo($pcmake) {
if (preg_match('/dell/i', $pcmake)) {
   echo "<img src=images/pcs/dell.png border=0>";
} elseif (preg_match('/compaq/i', $pcmake)) {
echo "<img src=images/pcs/compaq.png border=0>";
} elseif (preg_match('/hp/i', $pcmake)) {
echo "<img src=images/pcs/hp.png border=0>";
} elseif (preg_match('/toshiba/i', $pcmake)) {
echo "<img src=images/pcs/toshiba.png border=0>";
} elseif (preg_match('/emachine/i', $pcmake) | preg_match('/e-machine/i', $pcmake) | preg_match('/etower/i', $pcmake)) {
echo "<img src=images/pcs/emachine.png border=0>";
} elseif (preg_match('/gateway/i', $pcmake)) {
echo "<img src=images/pcs/gateway.png border=0>";
} elseif (preg_match('/ibm/i', $pcmake)) {
echo "<img src=images/pcs/ibm.jpg border=0>";
} elseif (preg_match('/micron/i', $pcmake)) {
echo "<img src=images/pcs/micron.jpg border=0>";
} elseif (preg_match('/sony/i', $pcmake)) {
echo "<img src=images/pcs/sony.jpg border=0>";
} elseif (preg_match('/packard/i', $pcmake)) {
echo "<img src=images/pcs/packbell.jpg border=0>";
} elseif (preg_match('/acer/i', $pcmake)) {
echo "<img src=images/pcs/acer.png border=0>";
} elseif (preg_match('/custom/i', $pcmake)) {
echo "<img src=images/pcs/custom.jpg border=0>";
} elseif (preg_match('/riverside/i', $pcmake)) {
echo "<img src=images/pcs/riverside.png border=0>";
} elseif (preg_match('/lenovo/i', $pcmake)) {
echo "<img src=images/pcs/lenovo.jpg border=0>";
} elseif (preg_match('/apple/i', $pcmake)) {
echo "<img src=images/pcs/apple.png border=0>";
} else {
echo "<img src=images/pcs/unknown.jpg border=0>";
}
}


function getassettypename($mainassettypeid) {
require("deps.php");




$rs_findassettypes = "SELECT * FROM mainassettypes WHERE mainassettypeid = '$mainassettypeid'";
$rs_resultfat = mysqli_query($rs_connect, $rs_findassettypes);
$rs_result_qfat = mysqli_fetch_object($rs_resultfat);
$mainassetname = "$rs_result_qfat->mainassetname";
return $mainassetname;
}



function showpcs($showbuttons) {
require("deps.php");

if(!isset($statusassetlimit)) {
$statusassetlimit = 12;
}


$rs_ql = "SELECT defaultstore,statusview,promiseview FROM users WHERE username = '$ipofpc'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$defaultuserstore = "$rs_result_q1->defaultstore";
$statusview = "$rs_result_q1->statusview";
$promiseview = "$rs_result_q1->promiseview";


$storeinfoarray = getstoreinfo($defaultuserstore);

$chksclog = "SELECT refid FROM userlog WHERE reftype = 'woid' AND actionid = '23' ORDER BY thedatetime DESC LIMIT 25";
$rs_result_sclog = mysqli_query($rs_connect, $chksclog);
if (mysqli_num_rows($rs_result_sclog) != "0") {
while($rs_result_item_sclogq = mysqli_fetch_object($rs_result_sclog)) {
$cscarray[] = "$rs_result_item_sclogq->refid";
}
} else {
$cscarray = array();
}


if ($statusview == 0) {
$viewdisabled0 = "disabled class=progbuttonoff";
$viewdisabled1 = "class=progbutton";
$viewdisabled2 = "class=progbutton";
$viewdisabled3 = "class=progbutton";
} elseif ($statusview == 1) {
$viewdisabled0 = "class=progbutton";
$viewdisabled1 = "disabled class=progbuttonoff";
$viewdisabled2 = "class=progbutton";
$viewdisabled3 = "class=progbutton";
} elseif ($statusview == 2) {
$viewdisabled0 = "class=progbutton";
$viewdisabled1 = "class=progbutton";
$viewdisabled2 = "disabled class=progbuttonoff";
$viewdisabled3 = "class=progbutton";
} else {
$viewdisabled0 = "class=progbutton";
$viewdisabled1 = "class=progbutton";
$viewdisabled2 = "class=progbutton";
$viewdisabled3 = "disabled class=progbuttonoff";
}

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}

$daystart = date('Y-m-d')." 00:00:00";

$excludedcollapsed = "";
$rs_findstatiic = "SELECT * FROM boxstyles WHERE displayedstatus = '1' AND collapsedstatus = '1'";
$rs_result_stc = mysqli_query($rs_connect, $rs_findstatiic);
while($rs_result_stqc = mysqli_fetch_object($rs_result_stc)) {
$statusidcol = "$rs_result_stqc->statusid";
$excludedcollapsed .= " AND pcstatus != '$statusidcol'";
}

$thenow = date('Y-m-d H:i:s');
$daystart = date('Y-m-d')." 00:00:00";
$dayend = date('Y-m-d')." 23:59:59";
$tomorrowend = date('Y-m-d', strtotime("+1 day"))." 23.59.59";
$day7end  = date('Y-m-d', strtotime("+7 day"))." 23.59.59";
#wip
if($promiseview == 1) {
$promisediff = "AND servicepromiseid != '0' AND (promisedtime LIKE '".date('Y-m-d')."%')";
} elseif($promiseview == 2) {
$promisediff = "AND servicepromiseid != '0' AND promisedtime > '$dayend' AND promisedtime < '$tomorrowend'";
} elseif($promiseview == 3) {
$promisediff = "AND servicepromiseid != '0' AND promisedtime > '$tomorrowend' AND promisedtime < '$day7end'";
} elseif($promiseview == 4) {
$promisediff = "AND servicepromiseid != '0' AND (promisedtime LIKE '".date('Y-m-d')."%' OR promisedtime < '$thenow')";
} elseif($promiseview == 5) {
$promisediff = "AND servicepromiseid != '0' AND promisedtime > '$daystart' AND promisedtime < '$tomorrowend'";
} elseif($promiseview == 6) {
$promisediff = "AND servicepromiseid != '0' AND promisedtime < '$thenow'";
} else {
$promisediff = "";
}


$rs_findtotalpcs = "SELECT * FROM pc_wo WHERE storeid = '$defaultuserstore'  $promisediff AND pcstatus != '0' AND 
((sked = '0' AND pcstatus != '5' AND pcstatus != '7' AND pcstatus != '4' AND pcstatus != '6' $excludedcollapsed) OR 
(sked = '1' AND pcstatus != '5' AND pcstatus != '7'  AND pcstatus != '4' $excludedcollapsed AND DATE_ADD('$daystart', INTERVAL 2 DAY) > skeddate) OR
(pcstatus = '4' AND DATE_SUB(NOW(), INTERVAL 1 MONTH) < dropdate) OR (pcstatus = '6'))";

$rs_findtotalpcsuser = "SELECT * FROM pc_wo WHERE storeid = '$defaultuserstore' $promisediff AND pcstatus != '0' AND assigneduser = '$ipofpc' AND
((sked = '0' AND pcstatus != '5' AND pcstatus != '7' AND pcstatus != '4' AND pcstatus != '6' $excludedcollapsed) OR
(sked = '1' AND pcstatus != '5' AND pcstatus != '7' $excludedcollapsed AND DATE_SUB('$daystart', INTERVAL 1 DAY) > skeddate) OR
(pcstatus = '4' AND DATE_SUB(NOW(), INTERVAL 1 MONTH) < dropdate) OR (pcstatus = '6'))";

$rs_findtotalpcs_sked = "SELECT * FROM pc_wo WHERE storeid = '$defaultuserstore' $promisediff AND sked = '1' AND pcstatus != '5' AND pcstatus != '7' AND pcstatus != '4' AND pcstatus != '0' $excludedcollapsed";

$rs_findtotalpcsuser_sked = "SELECT * FROM pc_wo WHERE storeid = '$defaultuserstore' $promisediff AND assigneduser = '$ipofpc' AND sked = '1' AND pcstatus != '5' AND pcstatus != '7' AND pcstatus != '4' AND pcstatus != '0' $excludedcollapsed";


$rs_result_tot = mysqli_query($rs_connect, $rs_findtotalpcs);
$totalpcss_total = mysqli_num_rows($rs_result_tot);

$rs_result_tot_user = mysqli_query($rs_connect, $rs_findtotalpcsuser);
$totalpcssu_total = mysqli_num_rows($rs_result_tot_user);

$rs_result_tot_sked = mysqli_query($rs_connect, $rs_findtotalpcs_sked);
$totalpcss_sked_total = mysqli_num_rows($rs_result_tot_sked);

$rs_result_tot_user_sked = mysqli_query($rs_connect, $rs_findtotalpcsuser_sked);
$totalpcssu_sked_total = mysqli_num_rows($rs_result_tot_user_sked);

if($showbuttons == "yes") {

echo "<div style=\"text-align:center; width:100%; margin-right:auto; margin-left:auto; padding:4px; white-space:nowrap;\">\n";
echo "<button $viewdisabled0 onClick=\"parent.location='pc.php?func=changestatusview&view=0'\" data-inline=\"true\"><img src=../repair/images/prog_store.png style=\"vertical-align:middle;\"> $totalpcss_total</button>\n ";
echo "<button $viewdisabled1 onClick=\"parent.location='pc.php?func=changestatusview&view=1'\" data-inline=\"true\"><img src=../repair/images/prog_user.png style=\"vertical-align:middle;\"> $totalpcssu_total</button><br>\n ";
echo "<button $viewdisabled2 onClick=\"parent.location='pc.php?func=changestatusview&view=2'\" data-inline=\"true\"><img src=../repair/images/prog_store_sked.png style=\"vertical-align:middle;\"> $totalpcss_sked_total</button>\n ";
echo "<button $viewdisabled3 onClick=\"parent.location='pc.php?func=changestatusview&view=3'\" data-inline=\"true\"><img src=../repair/images/prog_user_sked.png style=\"vertical-align:middle;\"> $totalpcssu_sked_total</button>\n";
echo "</div>";

echo "<div data-role=\"collapsible\" data-theme=\"b\">";
echo "<h3>";
echo "<i class=\"fa fa-stopwatch fa-lg\"></i> ";
if($promiseview == "0") {
echo pcrtlang("All");
} elseif($promiseview == "6") {
echo pcrtlang("Overdue");
} elseif($promiseview == "1") {
echo pcrtlang("Today");
} elseif($promiseview == "4") {
echo pcrtlang("Today/Overdue");
} elseif($promiseview == "5") {
echo pcrtlang("Today/Tomorrow");
} elseif($promiseview == "2") {
echo pcrtlang("Tomorrow");
} else {
echo pcrtlang("Soon");
}

echo "</h3>";
echo "<button type=button onClick=\"parent.location='pc.php?func=changepromiseview&view=0'\" class=\"ui-btn ui-corner-all ui-shadow ui-mini\"><i class=\"fa fa-stopwatch fa-2x menuicon2x\" style=\"color:#777777\"></i> ".pcrtlang("Show All")."</button>";
echo "<button type=button onClick=\"parent.location='pc.php?func=changepromiseview&view=6'\" class=\"ui-btn ui-corner-all ui-shadow ui-mini\"><i class=\"fa fa-stopwatch fa-2x menuicon2x\" style=\"color:#ff0000\"></i> ".pcrtlang("Overdue")."</button>";
echo "<button type=button onClick=\"parent.location='pc.php?func=changepromiseview&view=1'\" class=\"ui-btn ui-corner-all ui-shadow ui-mini\"><i class=\"fa fa-stopwatch fa-2x menuicon2x\" style=\"color:#ff0000\"></i> ".pcrtlang("Today")."</button>";
echo "<button type=button onClick=\"parent.location='pc.php?func=changepromiseview&view=4'\" class=\"ui-btn ui-corner-all ui-shadow ui-mini\"><i class=\"fa fa-stopwatch fa-2x menuicon2x\" style=\"color:#ff0000\"></i> ".pcrtlang("Today/Overdue")."</button>";
echo "<button type=button onClick=\"parent.location='pc.php?func=changepromiseview&view=5'\" class=\"ui-btn ui-corner-all ui-shadow ui-mini\"><i class=\"fa fa-stopwatch fa-2x menuicon2x\" style=\"color:#ff0000\"></i> ".pcrtlang("Today/Tomorrow")."</button>";
echo "<button type=button onClick=\"parent.location='pc.php?func=changepromiseview&view=2'\" class=\"ui-btn ui-corner-all ui-shadow ui-mini\"><i class=\"fa fa-stopwatch fa-2x menuicon2x\" style=\"color:#f9aa00\"></i> ".pcrtlang("Tomorrow")."</button>";
echo "<button type=button onClick=\"parent.location='pc.php?func=changepromiseview&view=3'\" class=\"ui-btn ui-corner-all ui-shadow ui-mini\"><i class=\"fa fa-stopwatch fa-2x menuicon2x\" style=\"color:#ead300\"></i> ".pcrtlang("Soon")."</button>";


echo "</div>";


}



#############################################################


$rs_findstatii = "SELECT * FROM boxstyles WHERE displayedstatus = '1' ORDER BY displayedorder ASC";
$rs_result_st = mysqli_query($rs_connect, $rs_findstatii);
while($rs_result_stq = mysqli_fetch_object($rs_result_st)) {
$statusids[] = "$rs_result_stq->statusid";
$statusoptions[$rs_result_stq->statusid] = serializedarraytest("$rs_result_stq->statusoptions");
$statuscollapsed[$rs_result_stq->statusid] = "$rs_result_stq->collapsedstatus";
}

$prevstatus = "nothing";

foreach($statusids as $key => $statusid) {

$yep = 0;
foreach($statusoptions[$statusid] as $key => $option) {
if ($option[0] == "e") {
$yep++;
}
}

if (in_array("workbench", $statusoptions[$statusid])) {
if($statusview < 2) {
$statsort = "workarea, dropdate";
} else {
$statsort = "workarea, skeddate";
}
} else {
if($statusview < 2) {
$statsort = "dropdate";
} else {
$statsort = "skeddate";
}
}




reset($statusoptions[$statusid]);

$boxstyle = getboxstyle($statusid);
$theprev = "nothing";

if($statusview == 0) {
$rs_findpcs = "SELECT * FROM pc_wo WHERE pcstatus = '$statusid' AND storeid = '$defaultuserstore' $promisediff AND ((sked = '0') OR (sked = '1' AND DATE_ADD('$daystart', INTERVAL 2 DAY) > skeddate)) ORDER BY $statsort ASC";
} elseif($statusview == 1) {
$rs_findpcs = "SELECT * FROM pc_wo WHERE pcstatus = '$statusid' AND storeid = '$defaultuserstore' $promisediff AND assigneduser = '$ipofpc' AND ((sked = '0') OR (sked = '1' AND DATE_ADD('$daystart', INTERVAL 2 DAY) > skeddate)) ORDER BY  $statsort ASC";
} elseif($statusview == 2) {
$rs_findpcs = "SELECT * FROM pc_wo WHERE pcstatus = '$statusid' AND storeid = '$defaultuserstore' $promisediff AND sked = '1' ORDER BY $statsort ASC";
} else {
$rs_findpcs = "SELECT * FROM pc_wo WHERE pcstatus = '$statusid' AND storeid = '$defaultuserstore' $promisediff AND assigneduser = '$ipofpc' AND sked = '1' ORDER BY $statsort ASC";
}

if($statusid != '4') {
$limiter = " LIMIT $statusassetlimit";
} else {
$limiter = "";
}

$rs_result = mysqli_query($rs_connect, "$rs_findpcs $limiter");
$totalworkorders = mysqli_num_rows($rs_result);

$rs_resultoverall = mysqli_query($rs_connect, $rs_findpcs);
$totalworkordersoverall = mysqli_num_rows($rs_resultoverall);

if ($totalworkorders != 0) {

if ($statuscollapsed[$statusid] == 0) {

start_status_box("$statusid","$boxstyle[boxtitle]");

$theworkordercount = 0;


while($rs_result_q = mysqli_fetch_object($rs_result)) {

$pcid = "$rs_result_q->pcid";
$woid = "$rs_result_q->woid";
$dropdate = "$rs_result_q->dropdate";
$workarea = "$rs_result_q->workarea";
$pcpriorityindb = "$rs_result_q->pcpriority";
$thepass = "$rs_result_q->thepass";
$probdesc = "$rs_result_q->probdesc";
$commonproblems = "$rs_result_q->commonproblems";
$assigneduser = "$rs_result_q->assigneduser";
$skeddate = "$rs_result_q->skeddate";
$sked = "$rs_result_q->sked";
$servicepromiseid = "$rs_result_q->servicepromiseid";
$promisedtime = "$rs_result_q->promisedtime";


$dropdatestring = strtotime($dropdate);
$dropdatestringdiff = time() - $dropdatestring;
if(($dropdatestringdiff < 2592000) || ($statusid != 4)) {

$theworkordercount++;



if ($pcpriorityindb != "") {
$picon = "$pcpriority[$pcpriorityindb]";
} else {
$picon = "";
}



$storeworkareas = array();
$rs_qb = "SELECT * FROM benches WHERE storeid = '$defaultuserstore'";
$rs_resultb = mysqli_query($rs_connect, $rs_qb);
while($rs_result_qb = mysqli_fetch_object($rs_resultb)) {
$benchid = "$rs_result_qb->benchid";
$benchname = "$rs_result_qb->benchname";
$benchcolor = "$rs_result_qb->benchcolor";
$storeworkareas[$benchname] = $benchcolor;
}


$rs_findowner = "SELECT pcname,pcmake,pccompany,mainassettypeid,prefcontact,pcphone,pcemail,pccellphone,pcworkphone,scid FROM pc_owner WHERE pcid = '$pcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);

while($rs_result_q2 = mysqli_fetch_object($rs_result2)) {
$pcname = "$rs_result_q2->pcname";
$pcmake = "$rs_result_q2->pcmake";
$pccompany = "$rs_result_q2->pccompany";
$mainassettypeidindb = "$rs_result_q2->mainassettypeid";
$prefcontact = "$rs_result_q2->prefcontact";
$pcphone = "$rs_result_q2->pcphone";
$pcemail = "$rs_result_q2->pcemail";
$pccellphone = "$rs_result_q2->pccellphone";
$pcworkphone = "$rs_result_q2->pcworkphone";
$scid = "$rs_result_q2->scid";


if (in_array("workbench", $statusoptions[$statusid])) {
if (($workarea == "") || !array_key_exists("$workarea", $storeworkareas)) {
$workarea2 = pcrtlang("Unassigned");
$bgstyle = "style=\"background: #ffffff;padding:3px;\"";
$bgstyle2 = "style=\"background: #cccccc;padding:2px;border-radius:3px;\"";
} else {
$workarea2 = "$workarea";
$bgcolor = $storeworkareas[$workarea];
$bgstyle2 = "style=\"background: #$bgcolor;padding:2px;border-radius:3px;\"";
}

if (($workarea != $theprev) && (!empty($storeworkareas)))  {
if($theprev != "nothing") {
echo "</ul>";
}
echo "<div $bgstyle2><i class=\"fa fa-plug\"></i> <font class=smallerb>$workarea2</font></div>";
echo "<ul data-role=\"listview\" data-inset=\"true\">";
}

$theprev = "$workarea";

} else {
if($prevstatus != "$statusid") {
echo "<ul data-role=\"listview\" data-inset=\"true\">";
}
}

$prevstatus = $statusid;


#####
echo "<li>";
echo "<a href=\"index.php?pcwo=$woid#workorderinfo\"  data-ajax=\"false\"><font class=em90>$pcname</font>";


if (in_array("mcompany", $statusoptions[$statusid])) {
if($pccompany != "") {
echo "<br><font class=em75><i class=\"fa fa-building fa-fw\"></i> $pccompany</font>";
}
}

if (in_array("mwoids", $statusoptions[$statusid])) {
echo "<br><font class=em75><i class=\"fa fa-tag\"></i> AS $pcid  &nbsp;&nbsp;&nbsp;<i class=\"fa fa-clipboard\"></i> WO $woid</font>";
}

if (in_array("massettype", $statusoptions[$statusid])) {
$mainassettype = getassettypename($mainassettypeidindb);
echo "<br><font class=em75><i class=\"fa fa-cog\"></i> $mainassettype: $pcmake</font>";
}

if (in_array("mmsp", $statusoptions[$statusid])) {
if($scid == 1) {
echo "<br><font class=em75><i class=\"fa fa-file-text\"></i> ".pcrtlang("Service Contract").": $scid</font> ";
}
}


if (in_array("mskedjobs", $statusoptions[$statusid])) {
if($sked == 1) {
echo "<br><font class=em75><i class=\"fa fa-clock-o\"></i> ";
skedwhen("$skeddate");
echo "</font>";
}
}


if (in_array("mpassword", $statusoptions[$statusid])) {
$rs_findcreds = "SELECT * FROM creds WHERE pcid = '$pcid' AND credtype < '3' ORDER BY creddate DESC";
$rs_result_creds = mysqli_query($rs_connect, $rs_findcreds);
while($rs_result_qcreds = mysqli_fetch_object($rs_result_creds)) {
$creddesc = "$rs_result_qcreds->creddesc";
$creduser = "$rs_result_qcreds->creduser";
$credpass = "$rs_result_qcreds->credpass";
$credtype = "$rs_result_qcreds->credtype";
$patterndata = "$rs_result_qcreds->patterndata";
if($credtype == 1) {
echo "<br>$creddesc: <i class=\"fa fa-user\"></i> $creduser <i class=\"fa fa-key\"></i> $credpass";
} else {
echo "<br>$creddesc: <i class=\"fa fa-thumb-tack\"></i> $credpass";
}
}
}


if (in_array("mdaysinshop", $statusoptions[$statusid])) {
$elapse = elaps($dropdate);
echo "<br><font class=em75><i class=\"fa fa-history\"></i> $elapse ".pcrtlang("in the shop")."</font>";
}

if (in_array("massigneduser", $statusoptions[$statusid])) {
if($assigneduser != "") {
echo "<br><font class=em75><i class=\"fa fa-user\"></i> ".pcrtlang("Assigned User").": $assigneduser</font>";
}
}


if (in_array("mrepaircart", $statusoptions[$statusid])) {
$rs_findbill = "SELECT * FROM repaircart WHERE pcwo = '$woid'";
$rs_findbill2 = mysqli_query($rs_connect, $rs_findbill);
$numite = mysqli_num_rows($rs_findbill2);

if($numite != 0) {
$rs_findsum = "SELECT (SUM(cart_price) + SUM(itemtax)) as checkcartsum FROM repaircart WHERE pcwo = '$woid'";
$rs_findsum2 = @mysqli_query($rs_connect, $rs_findsum);
$rs_findsum3 = mysqli_fetch_object($rs_findsum2);
$cartsum = "$rs_findsum3->checkcartsum";

if($cartsum == 0) {
echo "<br><font class=\"em75\"><i class=\"fa fa-money\"></i> $money ".pcrtlang("NO CHARGE")."</font> ";
} else {
echo "<br><font class=\"em75\"><i class=\"fa fa-money\"></i> $money".mf("$cartsum")."</font> ";
}

}
}




if (in_array("mstatuscheck", $statusoptions[$statusid])) {
if(in_array("$woid", $cscarray)) {
$thecheckarray = customerstatuscheck($woid,2);
echo "<br><font class=em75><i class=\"fa fa-eye fa-lg\" style=\"color:#0000ff\"></i> $thecheckarray[thetimes] ".pcrtlang("time(s)")."</font>";
}
}



#pc owner while
}


echo "</a></li>";


#wo while
}



#not over month while
}


if ($statusid == 4) {
if ($totalworkorders > $theworkordercount) {
$remainingwo = $totalworkorders - $theworkordercount;

if ($theworkordercount == 0) {
echo "\n\n<ul data-role=\"listview\" data-inset=\"true\">";
}

echo "<li><a href=\"pc.php?func=checkoutpc\" data-ajax=\"false\"><font class=em75>".pcrtlang("View All Ready For Pickup")."<br>";
echo "$remainingwo ".pcrtlang("over 1 month old")."</font></a></li>";
echo "";
}
} else {
if($totalworkordersoverall > $statusassetlimit) {
echo "<li><a href=\"pc.php?func=viewassetstatus&pcstatus=$statusid\" data-ajax=\"false\">".pcrtlang("View All")."</a></li>";
}
}

#between statii
echo "</ul><br>\n";


} else {
start_status_box_collapsed("$statusid","$boxstyle[boxtitle]");
echo "<br>";
}

#if not empty
}


#end status id while
}


#function end
}                                                                                                                                               


function recentwork() {
require("deps.php");
require_once("common.php");

$rs_ql = "SELECT defaultstore,statusview,gomodal FROM users WHERE username = '$ipofpc'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$defaultuserstore = "$rs_result_q1->defaultstore";
$statusview = "$rs_result_q1->statusview";
$gomodal = "$rs_result_q1->gomodal";

if (!isset($showrecentjobs)) {
$showrecentjobs = 15;
}

if ($gomodal == 1) {
$therel = "rel=facebox";
} else {
$therel = "";
}

$showrecentjobs2 = $showrecentjobs + 10;

if($statusview == 0) {
$rs_find_pc = "SELECT pc_wo.pcid, pc_wo.woid, pc_owner.pcname, pc_owner.pcemail FROM pc_wo,pc_owner WHERE pc_wo.pcstatus ='5' AND pc_wo.pcid = pc_owner.pcid ORDER BY pc_wo.pickupdate DESC LIMIT $showrecentjobs";
$chktelog = "SELECT refid FROM userlog WHERE reftype = 'woid' AND actionid = '25' ORDER BY thedatetime DESC LIMIT $showrecentjobs2";
} else {
$rs_find_pc = "SELECT pc_wo.pcid, pc_wo.woid, pc_owner.pcname,pc_owner.pcemail FROM pc_wo,pc_owner WHERE pc_wo.assigneduser = '$ipofpc' AND pc_wo.pcstatus ='5' AND pc_wo.pcid = pc_owner.pcid ORDER BY pc_wo.pickupdate DESC LIMIT $showrecentjobs";
$chktelog = "SELECT refid FROM userlog WHERE reftype = 'woid' AND actionid = '25' AND loggeduser = '$ipofpc' ORDER BY thedatetime DESC LIMIT $showrecentjobs2";
}
$rs_result_item = mysqli_query($rs_connect, $rs_find_pc);


$rs_result_telog = mysqli_query($rs_connect, $chktelog);

if (mysqli_num_rows($rs_result_telog) != "0") {
while($rs_result_item_telogq = mysqli_fetch_object($rs_result_telog)) {
$thankyouarray[] = "$rs_result_item_telogq->refid";
}
} else {
$thankyouarray = array();
}


$lang_PC = pcrtlang("AS");
$lang_WO = pcrtlang("WO");
$lang_TY = pcrtlang("TY");
$lang_sendTY = pcrtlang("Send TY");
$lang_edit = pcrtlang("edit");

echo "<table border=0>";
while($rs_result_item_q = mysqli_fetch_object($rs_result_item)) {
$pcid = "$rs_result_item_q->pcid";
$woid = "$rs_result_item_q->woid";
$pcowner = "$rs_result_item_q->pcname";
$pcemail = "$rs_result_item_q->pcemail";


echo "<tr><td style=\"white-space:nowrap;\"><font class=bpcid10>$lang_PC</font><font class=apcid10>$pcid</font> <font class=bwoid10>$lang_WO</font><font class=awoid10>$woid</font></td><td><a href=pc.php?func=showpc&pcid=$pcid class=boldlink>$pcowner</a> <br> <a href=index.php?pcwo=$woid>$lang_edit</a>";
if(in_array("$woid", $thankyouarray)) {
echo " <font class=text10>|</font> <font class=thankyou>$lang_TY</font>";
} else {
if($pcemail != "") {
echo " <font class=text10>|</font> <font class=textred12b><i class=\"fa fa-exclamation-circle fa-lg\"></i></font> <a href=\"pc.php?func=emailthankyou&woid=$woid&email=$pcemail\" $therel>$lang_sendTY</a>";
}
}

echo "</td></tr>";
}

echo "</table>";

}



function elaps($dropdate) {
require("deps.php");
if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}

$thenum = strtotime($dropdate);
$thediff = time() - $thenum;
if($thediff > 259200) {
$daydiff = number_format($thediff / 86400,0)." ".pcrtlang("days");
} elseif($thediff > 86400) {
$daydiff = number_format($thediff / 84600,1)." ".pcrtlang("days");
} elseif($thediff > 3600) {
$daydiff = number_format($thediff / 3600,1)." ".pcrtlang("hours");
} else {
$daydiff = number_format($thediff / 60,0)." ".pcrtlang("min");
}


return "$daydiff";

}

function getsalestaxrate($taxid) {
require("deps.php");

$findtaxsql = "SELECT * FROM taxes WHERE taxid = $taxid";
$findtaxq = @mysqli_query($rs_connect, $findtaxsql);
$findtaxa = mysqli_fetch_object($findtaxq);
$taxrate = "$findtaxa->taxrategoods";
return $taxrate;
}

function getservicetaxrate($taxid) {
require("deps.php");

$findtaxsql = "SELECT * FROM taxes WHERE taxid = $taxid";
$findtaxq = @mysqli_query($rs_connect, $findtaxsql);
$findtaxa = mysqli_fetch_object($findtaxq);
$taxrate = "$findtaxa->taxrateservice";
return $taxrate;
}

function gettaxname($taxid) {
require("deps.php");

$findtaxsql = "SELECT * FROM taxes WHERE taxid = $taxid";
$findtaxq = @mysqli_query($rs_connect, $findtaxsql);
$findtaxa = mysqli_fetch_object($findtaxq);
$taxname = "$findtaxa->taxname";
return $taxname;
}

function getusertaxid() {
require("deps.php");
$usernamechk = $ipofpc;

$findtaxsql = "SELECT * FROM users WHERE username = '$usernamechk'";
$findtaxq = @mysqli_query($rs_connect, $findtaxsql);
$findtaxa = mysqli_fetch_object($findtaxq);
$usertaxid = "$findtaxa->currenttaxid";
return $usertaxid;
}

function pv($value) {
require("deps.php");
$value2 = trim($value);
   return mysqli_real_escape_string($rs_connect, $value2);
}

function pf($value) {
$value2 = trim($value);
   return htmlspecialchars($value2);
}
function pfnotrim($value) {
   return htmlspecialchars($value);
}

function mf($value) {
if(empty($value)) {
return "0.00";
} else {
return number_format($value, 2, '.', '');
}
}

function qf($value) {
if(empty($value)) {
return "0";
} else {
return $value + 0;
}
}


function mfexp($number) {
if(empty($number)) {
return "0.00";
} else {
        if (($number * pow(10 , 2 + 1) % 10 ) == 5)  //if next not significant digit is 5
            $number -= pow(10 , -(2+1));
       return number_format($number, 2, '.', '');
}
}

function ii($value) {
if(($value % 1) == 0) {
return "true";
} else {
return "false";
}
}



function parseforlinks($text) {
  $text= preg_replace("/(^|[\n ])([\w]*?)((ht|f)tp(s)?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is", "$1$2<a href=\"$3\" >$3</a>", $text);
    $text= preg_replace("/(^|[\n ])([\w]*?)((www|ftp)\.[^ \,\"\t\n\r<]*)/is", "$1$2<a href=\"http://$3\" >$3</a>", $text);
    $text= preg_replace("/(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/i", "$1<a href=\"mailto:$2@$3\">$2@$3</a>", $text);
    return($text);

}





$themasterperms = array(
"1" => pcrtlang("Manage Scans, Installs, Actions, Notes"),
"2" => pcrtlang("Manage Quick Labor"),
"4" => pcrtlang("Delete Receipts"),
"5" => pcrtlang("Run Monthly, Quarterly, Yearly Sales Reports"),
"6" => pcrtlang("Manage Inventory"),
"7" => pcrtlang("View User Activity Reports"),
"8" => pcrtlang("Manage Customer Sources"),
"9" => pcrtlang("View Customer Source Reports"),
"10" => pcrtlang("View Customer Email/CSV Lists"),
"11" => pcrtlang("Manage Common Problems/Requests"),
"12" => pcrtlang("Manage Sticky Note Types"),
"13" => pcrtlang("Manage SMS Default Texts"),
"14" => pcrtlang("Process Recurring Invoices"),
"15" => pcrtlang("Delete Recent Invoices"),
"16" => pcrtlang("Manage Service Reminder Messages"),
"17" => pcrtlang("Send/Process Service Reminders"),
"18" => pcrtlang("Manage On Call Users"),
"19" => pcrtlang("Delete Sticky Notes Assigned to other Techs"),
"20" => pcrtlang("Edit Sticky Notes Assigned to other Techs"),
"21" => pcrtlang("Move Receipts Between Stores"),
"22" => pcrtlang("Refund Labor"),
"23" => pcrtlang("Browse Supplier Info"),
"24" => pcrtlang("Edit Supplier Info"),
"25" => pcrtlang("Browse Receipts"),
"26" => pcrtlang("View the Day Reports"),
"27" => pcrtlang("Manage Service Contract Pricing"),
"28" => pcrtlang("Process Recurring Work Orders"),
"29" => pcrtlang("Create Backups and Send to Dropbox"),
"30" => pcrtlang("Close Registers/Switch Receipt Register"),
"31" => pcrtlang("Manage Storage Locations"),
"32" => pcrtlang("Manage Portal Downloads"),
"33" => pcrtlang("Delete Messages (SMS,Email,Call Log,Portal Messages)"),
"34" => pcrtlang("View Group Customer Credentials"),
"35" => pcrtlang("Edit Customer Tags"),
"36" => pcrtlang("Mark or Unmark Stock Items as Discontinued"),
"37" => pcrtlang("View All Tech Message Conversations"),
"38" => pcrtlang("Manage Service Promises")
);



function perm_check($permid) {

include("deps.php");

$pcrt_select_parms_q = "SELECT theperms FROM users WHERE username = '$ipofpc'";
$frc_result_parms = @mysqli_query($rs_connect, $pcrt_select_parms_q);

$parmsa = mysqli_fetch_array($frc_result_parms);
$frc_perms = "$parmsa[theperms]";


if ($frc_perms != "") {
$theperms3 = unserialize($frc_perms);
} else {
$theperms3 = array();
}

if(is_array($theperms3)) {
$theperms = $theperms3;
} else {
$theperms = array();
}


if ("$ipofpc" == "admin") {
return true;
} else {
        if (in_array($permid, $theperms)) {
                return true;
        } else {
                return false;
        }
}
}





function perm_boot($permid) {

include("deps.php");

$pcrt_select_parms_q = "SELECT theperms FROM users WHERE username = '$ipofpc'";
$frc_result_parms = @mysqli_query($rs_connect, $pcrt_select_parms_q);

$parmsa = mysqli_fetch_array($frc_result_parms);
$frc_perms = "$parmsa[theperms]";


if ($frc_perms != "") {
$theperms3 = unserialize($frc_perms);
} else {
$theperms3 = array();
}

if(is_array($theperms3)) {
$theperms = $theperms3;
} else {
$theperms = array();
}

if (!in_array($permid, $theperms) && ("$ipofpc" != "admin")) {
       die("Access Denied - Please ask your admin for access to this function $permid");
}
}


$loggedactions = array(
"1" => pcrtlang("Created a New Work Order"),
"2" => pcrtlang("Checked Out a Work Order"),
"3" => pcrtlang("Recorded a Scan, Install, Action, or Note"),
"4" => pcrtlang("Saved Customer or Technician Notes"),
"5" => pcrtlang("Printed Customer Repair Sheet"),
"6" => pcrtlang("Emailed Customer Repair Sheet"),
"7" => pcrtlang("Uploaded Asset Photo"),
"8" => pcrtlang("Created Repair Invoice"),
"9" => pcrtlang("Completed Sale"),
"10" => pcrtlang("Created Invoice"),
"11" => pcrtlang("Changed Customer Call Status"),
"12" => pcrtlang("Emailed Claim Ticket"),
"13" => pcrtlang("Printed Claim Ticket"),
"14" => pcrtlang("Sent SMS Message"),
"15" => pcrtlang("Emailed Invoice"),
"16" => pcrtlang("Edited Invoice"),
"17" => pcrtlang("Created Quote"),
"18" => pcrtlang("Edited Quote"),
"19" => pcrtlang("Emailed Quote"),
"20" => pcrtlang("Created Repair Quote"),
"21" => pcrtlang("Printed or Viewed Invoice"),
"22" => pcrtlang("Printed Quote"),
"23" => pcrtlang("Customer Status Check"),
"24" => pcrtlang("Printed Thank You Letter"),
"25" => pcrtlang("Emailed Thank You Letter"),
"26" => pcrtlang("Uploaded an Attachment"),
"27" => pcrtlang("Emailed Receipt"),
"28" => pcrtlang("Viewed or Printed Receipt"),
"29" => pcrtlang("Created Recurring Invoice"),
"30" => pcrtlang("Logged In"),
"31" => pcrtlang("Logged Out"),
"32" => pcrtlang("Changed Work Order Status"),
"33" => pcrtlang("Added Service Reminder"),
"34" => pcrtlang("Emailed Service Reminder"),
"35" => pcrtlang("Printed Service Reminder")
);

function userlog($actionid,$refid,$reftype,$mensaje) {
require("deps.php");
if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}

$thenow = date('Y-m-d H:i:s');

$usernamechk = $ipofpc;
$mensaje2 = pv($mensaje);

$logactionsql = "INSERT INTO userlog (actionid,thedatetime,refid,reftype,loggeduser,mensaje) VALUES ('$actionid','$thenow','$refid','$reftype','$usernamechk','$mensaje2')";
@mysqli_query($rs_connect, $logactionsql);
}


function get_paged_nav($num_results, $num_per_page=40, $show=false)
{
    // Set this value to true if you want all pages to be shown,
    // otherwise the page list will be shortened.
    $full_page_list = false;

    // Get the original URL from the server.
    $url = $_SERVER['REQUEST_URI'];

    // Initialize the output string.
    $output = '';

    // Remove query vars from the original URL.
    if(preg_match('#^([^\?]+)(.*)$#isu', $url, $regs))
        $url = $regs[1];

    // Shorten the get variable.
    $q = $_GET;

    // Determine which page we're on, or set to the first page.
    if(isset($q['pageNumber']) AND is_numeric($q['pageNumber'])) $page = $q['pageNumber'];
    else $page = 1;

    // Determine the total number of pages to be shown.
    $total_pages = ceil($num_results / $num_per_page);
    // Begin to loop through the pages creating the HTML code.
    for($i=1; $i<=$total_pages; $i++)
    {
        // Assign a new page number value to the pageNumber query variable.
        $q['pageNumber'] = $i;

        // Initialize a new array for storage of the query variables.
        $tmp = array();
        foreach($q as $key=>$value)
            $tmp[] = "$key=$value";

        // Create a new query string for the URL of the page to look at.
        $qvars = implode("&amp;", $tmp);

        // Create the new URL for this page.
        $new_url = $url . '?' . $qvars;

        // Determine whether or not we're looking at this page.
        if($i != $page)
        {
            // Determine whether or not the page is worth showing a link for.
            // Allows us to shorten the list of pages.
            if($full_page_list == true
            OR $i == $page-5
            OR $i == $page-4
            OR $i == $page-3
            OR $i == $page-2       
         OR $i == $page-1
                OR $i == $page+1
                OR $i == 1
                OR $i == $total_pages
                OR $i == floor($total_pages/2)
                OR $i == floor($total_pages/2)+1
           OR $i == floor($total_pages/2)+2
           OR $i == floor($total_pages/2)+3
           OR $i == floor($total_pages/2)+4
           OR $i == floor($total_pages/2)+5
                )
                {
                    $output .= "<a href='$new_url' class=\"ui-btn ui-btn-inline ui-corner-all ui-shadow\">$i</a> ";
                }
                else
                    $output .= '. ';
        }
        else
        {
            // This is the page we're looking at.
            $output .= "&nbsp;&nbsp; $i &nbsp;&nbsp;";
        }
    }

    // Remove extra dots from the list of pages, allowing it to be shortened.
#    $output = ereg_replace('(\. ){2,}', ' .. ', $output);
 $output = preg_replace('#(\. ){2,}#', ' .. ', $output); 
   // Determine whether to show the HTML, or just return it.
    if($show) echo $output;

    return($output);
}





if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$thenow = date('Y-m-d H:i:s');
$rs_insert_time = "UPDATE users SET lastseen = '$thenow' WHERE username = '$ipofpc'";
@mysqli_query($rs_connect, $rs_insert_time);


$rs_qmultistore = "SELECT storeid FROM stores WHERE storedefault = '1'";
$rs_result_multistore = mysqli_query($rs_connect, $rs_qmultistore);
$rs_result_q1 = mysqli_fetch_object($rs_result_multistore);
$defaultstore = "$rs_result_q1->storeid";

$rs_multistorecheck = "SELECT * FROM stores WHERE storeenabled = '1'";
$rs_multistorecheckresult = mysqli_query($rs_connect, $rs_multistorecheck);
$activestorecount = mysqli_num_rows($rs_multistorecheckresult);

function getstoreinfo($storetoget) {

include("deps.php");



$rs_ql = "SELECT * FROM stores WHERE storeid = '$storetoget'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$storesname = "$rs_result_q1->storesname";
$storename = "$rs_result_q1->storename";
$storeaddy1 = "$rs_result_q1->storeaddy1";
$storeaddy2 = "$rs_result_q1->storeaddy2";
$storecity = "$rs_result_q1->storecity";
$storestate = "$rs_result_q1->storestate";
$storezip = "$rs_result_q1->storezip";
$storeemail = "$rs_result_q1->storeemail";
$storeccemail = "$rs_result_q1->ccemail";
$storephone = "$rs_result_q1->storephone";
$quotefooter = "$rs_result_q1->quotefooter";
$invoicefooter = "$rs_result_q1->invoicefooter";
$repairsheetfooter = "$rs_result_q1->repairsheetfooter";
$returnpolicy = "$rs_result_q1->returnpolicy";
$depositfooter = "$rs_result_q1->depositfooter";
$thankyouletter = "$rs_result_q1->thankyouletter";
$claimticket = "$rs_result_q1->claimticket";
$checkoutreceipt = "$rs_result_q1->checkoutreceipt";
$linecolor1 = "$rs_result_q1->linecolor1";
$linecolor2 = "$rs_result_q1->linecolor2";
$bgcolor1 = "$rs_result_q1->bgcolor1";
$bgcolor2 = "$rs_result_q1->bgcolor2";
$storehash = "$rs_result_q1->storehash";


$interfacestyle = "background: #$bgcolor2;
background: linear-gradient(to right, #$bgcolor1 0%,#$bgcolor2 100%);";

$linestyle = "background: #$linecolor2;
background: linear-gradient(to bottom, #$linecolor1 0%,#$linecolor2 100%);";


$storeinfo = array("storesname" => "$storesname", "storename" => "$storename", "storeaddy1" => "$storeaddy1", "storeaddy2" => "$storeaddy2", "storecity" => "$storecity", "storestate" => "$storestate", "storezip" => "$storezip", "storeemail" => "$storeemail", "storephone" => "$storephone", "quotefooter" => "$quotefooter", "invoicefooter" => "$invoicefooter", "repairsheetfooter" => "$repairsheetfooter", "returnpolicy" => "$returnpolicy", "depositfooter" => "$depositfooter", "thankyouletter" => "$thankyouletter", "claimticket" => "$claimticket", "checkoutreceipt" => "$checkoutreceipt", "interfacestyle" => "$interfacestyle", "linestyle" => "$linestyle", "storehash" => "$storehash","storeccemail" => "$storeccemail");
return $storeinfo;
}

function getourprice($stockid) {
require("deps.php");



$rs_qop = "SELECT inv_price FROM inventory WHERE stock_id = $stockid ORDER BY inv_date DESC LIMIT 1";
$rs_result1 = mysqli_query($rs_connect, $rs_qop);
$rs_result_q1 = mysqli_fetch_object($rs_result1);

$rs_qop2 = "SELECT avg_cost FROM stock WHERE stock_id = '$stockid'";
$rs_result2 = mysqli_query($rs_connect, $rs_qop2);
$rs_result_q2 = mysqli_fetch_object($rs_result2);

$avg_cost = "$rs_result_q2->avg_cost";
if ($avg_cost != "0") {
$ourprice = "$avg_cost";
} else {
$ourprice = "$rs_result_q1->inv_price";
}
return $ourprice;
}



function invoiceorquote($invoiceid) {
require("deps.php");
$rs_iorqq = "SELECT iorq FROM invoices WHERE invoice_id = $invoiceid";
$rs_result1 = mysqli_query($rs_connect, $rs_iorqq);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$iorq2 = "$rs_result_q1->iorq";
if ($iorq2 == "quote") {
$iorq = "quote";
} else {
$iorq = "invoice";
}
return $iorq;
}

function getusersmsnumber($uname) {
require("deps.php");
$rs_gus = "SELECT usermobile FROM users WHERE username = '$uname'";
$rs_result1 = mysqli_query($rs_connect, $rs_gus);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$usermobile = "$rs_result_q1->usermobile";
return $usermobile;
}

function getuseremail($uname) {
require("deps.php");
$rs_gue = "SELECT useremail FROM users WHERE username = '$uname'";
$rs_result1 = mysqli_query($rs_connect, $rs_gue);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$useremail = "$rs_result_q1->useremail";
return $useremail;
}


function formatBytes($bytes, $precision = 1) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);

    $bytes /= pow(1024, $pow);

    return round($bytes, $precision) . ' ' . $units[$pow];
}

function trim_value(&$value)
{
    $value = trim($value);
}


function available_serials($stockid) {

require("deps.php");

$itemserialblob = "";
$itemserialblob_sold = "";
$itemserialblob_return = "";

$rs_find_serial = "SELECT * FROM inventory WHERE stock_id = '$stockid' AND itemserial != ''";
$rs_find_serial_q = @mysqli_query($rs_connect, $rs_find_serial);
while($rs_find_result_q = mysqli_fetch_object($rs_find_serial_q)) {
$itemserials = "$rs_find_result_q->itemserial";
$itemserialblob .= "$itemserials\n";
}
if(mysqli_num_rows($rs_find_serial_q) > 0) {
$itemserialarray = explode("\n", trim($itemserialblob));
} else {
$itemserialarray = array();
}


$rs_find_serial_sold = "SELECT * FROM sold_items WHERE stockid = '$stockid' AND itemserial != '' AND sold_type != 'refund'";
$rs_find_serial_q_sold = @mysqli_query($rs_connect, $rs_find_serial_sold);
while($rs_find_result_q_sold = mysqli_fetch_object($rs_find_serial_q_sold)) {
$itemserials_sold = "$rs_find_result_q_sold->itemserial";
$itemserialblob_sold .= "$itemserials_sold\n";
}
if(mysqli_num_rows($rs_find_serial_q_sold) > 0) {
$itemserialarray_sold = explode("\n", trim($itemserialblob_sold));
} else {
$itemserialarray_sold = array();
}

####
$rs_find_serial_repaircart = "SELECT * FROM pc_wo WHERE pcstatus != '5'";
$rs_find_serial_q_repaircart = @mysqli_query($rs_connect, $rs_find_serial_repaircart);
while($rs_find_result_q_repaircart = mysqli_fetch_object($rs_find_serial_q_repaircart)) {
$activeworkorders = "$rs_find_result_q_repaircart->woid";
$rs_find_serial_repaircart_items = "SELECT * FROM repaircart WHERE pcwo = '$activeworkorders'";
$rs_find_serial_q_repaircart_items = @mysqli_query($rs_connect, $rs_find_serial_repaircart_items);
while($rs_find_result_q_repaircart_items = mysqli_fetch_object($rs_find_serial_q_repaircart_items)) {
$activeworkorderserial = "$rs_find_result_q_repaircart_items->itemserial";
$itemserialarray_sold[] = "$activeworkorderserial";
}
}

$rs_find_serial_cart_items = "SELECT * FROM cart";
$rs_find_serial_q_cart_items = @mysqli_query($rs_connect, $rs_find_serial_cart_items);
while($rs_find_result_q_cart_items = mysqli_fetch_object($rs_find_serial_q_cart_items)) {
$activeworkorderserial = "$rs_find_result_q_cart_items->itemserial";
$itemserialarray_sold[] = "$activeworkorderserial";
}


$rs_find_serial_openinvoice = "SELECT * FROM invoices WHERE invstatus = '1'";
$rs_find_serial_q_openinvoice = @mysqli_query($rs_connect, $rs_find_serial_openinvoice);
while($rs_find_result_q_openinvoice = mysqli_fetch_object($rs_find_serial_q_openinvoice)) {
$activeinvoices = "$rs_find_result_q_openinvoice->invoice_id";
$rs_find_serial_invoice_items = "SELECT * FROM invoice_items WHERE invoice_id = '$activeinvoices'";
$rs_find_serial_q_invoice_items = @mysqli_query($rs_connect, $rs_find_serial_invoice_items);
while($rs_find_result_q_invoice_items = mysqli_fetch_object($rs_find_serial_q_invoice_items)) {
$activeinvoiceserial = "$rs_find_result_q_invoice_items->itemserial";
$itemserialarray_sold[] = "$activeinvoiceserial";
}
}



####


$rs_find_serial_return = "SELECT * FROM sold_items WHERE stockid = '$stockid' AND itemserial != '' AND sold_type = 'refund'";
$rs_find_serial_q_return = @mysqli_query($rs_connect, $rs_find_serial_return);
while($rs_find_result_q_return = mysqli_fetch_object($rs_find_serial_q_return)) {
$itemserials_return = "$rs_find_result_q_return->itemserial";
$itemserialblob_return .= "$itemserials_return\n";
}
if(mysqli_num_rows($rs_find_serial_q_return) > 0) {
$itemserialarray_return = explode("\n", trim($itemserialblob_return));
} else {
$itemserialarray_return = array();
}

foreach($itemserialarray_return as $remove){
        foreach($itemserialarray_sold as $k=>$v){
            if((string)$v === (string)$remove){
                unset($itemserialarray_sold[$k]);
                break;
            }
        }
    }


array_walk($itemserialarray, 'trim_value');
array_walk($itemserialarray_sold, 'trim_value');


$availser = array_diff($itemserialarray, $itemserialarray_sold);

sort($availser);

return $availser;

}

function getboxstyle($statusid) {
require("deps.php");



$rs_qc = "SELECT * FROM boxstyles WHERE statusid = '$statusid'";
$rs_result1 = mysqli_query($rs_connect, $rs_qc);
$rs_result_q1 = mysqli_fetch_object($rs_result1);

$boxstyle = array();
$boxstyle['selectorcolor'] = "$rs_result_q1->selectorcolor";
$boxstyle['boxtitle'] = "$rs_result_q1->boxtitle";

return $boxstyle;

}

function getstatusselectorcolors() {
require("deps.php");



$rs_qc = "SELECT statusid,selectorcolor FROM boxstyles";
$rs_result1 = mysqli_query($rs_connect, $rs_qc);
$statusselectorcolors = array();
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$statusid = "$rs_result_q1->statusid";
$statuscolor = "$rs_result_q1->selectorcolor";
$statusselectorcolors[$statusid] = $statuscolor;

}
return $statusselectorcolors;

}

function getboxtitles() {
require("deps.php");



$rs_qc = "SELECT statusid,boxtitle FROM boxstyles";
$rs_result1 = mysqli_query($rs_connect, $rs_qc);
$boxtitles = array();
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$statusid = "$rs_result_q1->statusid";
$boxtitle = "$rs_result_q1->boxtitle";
$boxtitles[$statusid] = $boxtitle;

}
return $boxtitles;

}



function pcrtnotify() {
require("deps.php");

$pcrtnotify2 = "";
$pcrtnotify3 = "<br>";
$pcrtnotify = "";
if (perm_check("14")) {
$findrinvsql = "SELECT * FROM rinvoices WHERE reinvoicedate < NOW() AND invactive = '1'";
$findrinvq = @mysqli_query($rs_connect, $findrinvsql);
$totalready = mysqli_num_rows($findrinvq);
if($totalready > 0) {
$pcrtnotify .= "<button type=button  data-theme=\"b\"  data-mini=\"true\" onClick=\"parent.location='../storemobile/rinvoice.php?func=runinvoices'\"><i class=\"fa fa-bell faa-ring animated fa-lg\"></i> ".pcrtlang("Recurring Invoices")."</button>";
}

}

if (perm_check("17")) {
$findsrsql = "SELECT * FROM servicereminders WHERE srdate < NOW() AND srsent != '1'";
$findsrq = @mysqli_query($rs_connect, $findsrsql);
$totalsr = mysqli_num_rows($findsrq);
if($totalsr > 0) {
$pcrtnotify .= "<button type=button  data-theme=\"b\"  data-mini=\"true\" onClick=\"parent.location='../repairmobile/servicereminder.php?func=runsr'\"><i class=\"fa fa-bell faa-ring animated fa-lg\"></i> ".pcrtlang("Service Reminders")."</button>";
}
}

$findsreqsql = "SELECT * FROM servicerequests WHERE sreq_processed = '0'";
$findsreqq = @mysqli_query($rs_connect, $findsreqsql);
$totalsreq = mysqli_num_rows($findsreqq);
if($totalsreq > 0) {
$pcrtnotify .= "<button type=button  data-theme=\"b\"  data-mini=\"true\" onClick=\"parent.location='../repairmobile/servicerequests.php?func=runsreq'\"><i class=\"fa fa-bell faa-ring animated fa-lg\"></i> ".pcrtlang("Service Requests")."</button>";
}

if (perm_check("28")) {
$findrwosql = "SELECT * FROM rwo WHERE rwodate < NOW()";
$findrwoq = @mysqli_query($rs_connect, $findrwosql);
$totalrwo = mysqli_num_rows($findrwoq);
if($totalrwo > 0) {
$pcrtnotify .= "<button type=button  data-theme=\"b\"  data-mini=\"true\" onClick=\"parent.location='../repairmobile/rwo.php?func=runrwo'\"><i class=\"fa fa-bell faa-ring animated fa-lg\"></i> ".pcrtlang("Recurring Work Orders")."</button>";
}
}


if (isset($d7_report_upload_directory)) {
if (file_exists($d7_report_upload_directory)) {
$filesd7 = scandir($d7_report_upload_directory);
function validate_file2($v_filename) {
   return preg_match('/^[a-z0-9_-]+\.(pdf|html|htm|txt|rtf|csv|gz|tar|zip)$/i', $v_filename) ? '1' : '0';
}

foreach($filesd7 as $key => $val) {
if (validate_file2($val) == '1') {
$pcrtnotify .= "<button type=button  data-theme=\"b\"  data-mini=\"true\" onClick=\"parent.location='../repairmobile/d7.php'\"><i class=\"fa fa-bell faa-ring animated fa-lg\"></i> ".pcrtlang("d7 Reports").".</button>";
break;
}
}
}
}

if (isset($uvk_report_upload_directory)) {
if (file_exists($uvk_report_upload_directory)) {
$filesuvk = scandir($uvk_report_upload_directory);
function validate_file2uvk($v_filename) {
   return preg_match('/^[a-z0-9_-]+\.(pdf|html|htm|txt|rtf|csv|gz|tar|zip)$/i', $v_filename) ? '1' : '0';
}

foreach($filesuvk as $key => $val) {
if (validate_file2uvk($val) == '1') {
$pcrtnotify .= "<button type=button  data-theme=\"b\"  data-mini=\"true\" onClick=\"parent.location='../repairmobile/uvk.php'\"><i class=\"fa fa-bell faa-ring animated fa-lg\"></i> ".pcrtlang("UVK Reports are ready")."</button>";
break;
}
}
}
}



if ($pcrtnotify != "") {
$pcrtnotifyout = $pcrtnotify2;
$pcrtnotifyout .= $pcrtnotify;
$pcrtnotifyout .= $pcrtnotify3;
} else {
$pcrtnotifyout = "";
}



return $pcrtnotifyout;
}



function buildlangblob() {
require("deps.php");
$findstring = "SELECT languagestring,basestring FROM languages WHERE language = '$mypcrtlanguage'";
$findstringq = @mysqli_query($rs_connect, $findstring);
$langblobmain = array();
while ($rs_result_qs = mysqli_fetch_object($findstringq)) {
$langstring = "$rs_result_qs->languagestring";
$basestring = "$rs_result_qs->basestring";
$langblobmain[$basestring] = $langstring;
}
return $langblobmain;
}

function pcrtlang($string) {
require("deps.php");
static $langblobmain = false;
if(!$langblobmain) {
$langblob = buildlangblob();
$langblobmain = $langblob;
}
if (array_key_exists($string, $langblobmain)) {
return $langblobmain[$string];
} else {
$safestring = pv($string);
$addstring = "INSERT INTO languages (language,languagestring,basestring) VALUES ('$mypcrtlanguage','$safestring','$safestring')";
@mysqli_query($rs_connect, $addstring);
$langblobmain[$string] = $string;
return "$string";
}
}





function checkstorecount($stock_id) {
require("deps.php");



$rs_find_stores = "SELECT * FROM stores WHERE storeenabled = '1'";
$rs_result_stores = mysqli_query($rs_connect, $rs_find_stores);
        while($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
        $rs_storeid = "$rs_result_storeq->storeid";
        $rs_checkstockcounts = "SELECT * FROM stockcounts WHERE storeid = '$rs_storeid' AND stockid = '$stock_id'";
        $rs_result_sc = mysqli_query($rs_connect, $rs_checkstockcounts);
        $sc_result = mysqli_num_rows($rs_result_sc);
                if ($sc_result == 0) {
                $insertstore = "INSERT INTO stockcounts (stockid, storeid, quantity) VALUES ('$stock_id','$rs_storeid','0')";
                @mysqli_query($rs_connect, $insertstore);
                }
        }
}


function picktime($selectname,$pretime) {
echo "<select name=$selectname>";
$hours = array(12,1,2,3,4,5,6,7,8,9,10,11);
$ampms = array('AM','PM');

if (preg_match('/AM/i', $pretime)) {
$amorpm = "AM";
} else {
$amorpm = "PM";
}

$gettime2 = explode(" ", $pretime);
$gettime = $gettime2[0];
$thehourarray = explode(":", $gettime);

$thehour = $thehourarray[0]; 
$theminute = $thehourarray[1];

foreach($ampms as $key => $ampm) {
foreach($hours as $key => $hour) {
if($pretime == "$hour:00 $ampm") {
echo "<option selected value=\"$hour:00 $ampm\" style=\"background:#cccccc;\">$hour:00 $ampm</option>";
} else {
echo "<option value=\"$hour:00 $ampm\" style=\"background:#cccccc;\">$hour:00 $ampm</option>";
}

if(("$amorpm" == "$ampm") && ($thehour == $hour) && (($theminute > 0) && ($theminute < 15))) {
echo "<option selected value=\"$pretime\" style=\"background:#ffcccc;\">$pretime</option>";
}

if($pretime == "$hour:15 $ampm") {
echo "<option selected value=\"$hour:15 $ampm\" class=selecttimepickeroption>$hour:15 $ampm</option>";
} else {
echo "<option value=\"$hour:15 $ampm\" class=selecttimepickeroption>$hour:15 $ampm</option>";
}

if(("$amorpm" == "$ampm") && ($thehour == $hour) && (($theminute > 15) && ($theminute < 30))) {
echo "<option selected value=\"$pretime\" style=\"background:#ffcccc;\">$pretime</option>";
}

if($pretime == "$hour:30 $ampm") {
echo "<option selected value=\"$hour:30 $ampm\" class=selecttimepickeroption>$hour:30 $ampm</option>";
} else {
echo "<option value=\"$hour:30 $ampm\" class=selecttimepickeroption>$hour:30 $ampm</option>";
}

if(("$amorpm" == "$ampm") && ($thehour == $hour) && (($theminute > 30) && ($theminute < 45))) {
echo "<option selected value=\"$pretime\" style=\"background:#ffcccc;\">$pretime</option>";
}


if($pretime == "$hour:45 $ampm") {
echo "<option selected value=\"$hour:45 $ampm\" class=selecttimepickeroption>$hour:45 $ampm</option>";
} else {
echo "<option value=\"$hour:45 $ampm\" class=selecttimepickeroption>$hour:45 $ampm</option>";
}

if(("$amorpm" == "$ampm") && ($thehour == $hour) && (($theminute > 45) && ($theminute <= 59))) {
echo "<option selected value=\"$pretime\" style=\"background:#ffcccc;\">$pretime</option>";
}

}
reset($hours);
}


echo "</select>";

}



function serializedarraytest($array) {
if ($array != "") {
$arrayout2 = unserialize($array);
if (is_array($arrayout2)) {
$arrayout = $arrayout2;
} else {
$arrayout = array();
}
} else {
$arrayout = array();
}

return $arrayout;
}



function updatehours($blockid) {
require("deps.php");





$runningblockhours = 0;
$rs_findblockhours = "SELECT * FROM blockcontracthours WHERE blockcontractid = '$blockid'";
$rs_result_bh = mysqli_query($rs_connect, $rs_findblockhours);
while($rs_result_qbh = mysqli_fetch_object($rs_result_bh)) {
$blockhours = "$rs_result_qbh->blockhours";
$runningblockhours = $runningblockhours + $blockhours;
}

$runningtime = 0;
$rs_findtimers = "SELECT * FROM timers WHERE blockcontractid = '$blockid' AND timerstop != '0000-00-00 00:00:00'";
$rs_result_t = mysqli_query($rs_connect, $rs_findtimers);
while($rs_result_qt = mysqli_fetch_object($rs_result_t)) {
$timerstart = "$rs_result_qt->timerstart";
$timerstop = "$rs_result_qt->timerstop";
$savedround = "$rs_result_qt->savedround";

$startepoch = strtotime($timerstart);
$stopepoch = strtotime($timerstop);
$elapsedtime = $stopepoch - $startepoch;

if($savedround == 15) {
$elapsedtime2 = ($elapsedtime - ($elapsedtime % 900)) + 900;
$runningtime = $runningtime + $elapsedtime2;
} elseif($savedround == 30) {
$elapsedtime2 = ($elapsedtime - ($elapsedtime % 1800)) + 1800;
$runningtime = $runningtime + $elapsedtime2;
} elseif($savedround == 60) {
$elapsedtime2 = ($elapsedtime - ($elapsedtime % 3600)) + 3600;
$runningtime = $runningtime + $elapsedtime2;
} else {
$elapsedtime2 = $elapsedtime;
$runningtime = $runningtime + $elapsedtime2;
}

}

$runningblockhours = $runningblockhours * 3600;

$remainingtime = $runningblockhours - $runningtime;
$remaininghours =  mf($remainingtime / 3600);

$rs_update_h = "UPDATE blockcontract SET hourscache = '$remaininghours' WHERE blockid = '$blockid'";
@mysqli_query($rs_connect, $rs_update_h);
}


######



function pcrtdate($timestring,$timestamp) {

require("deps.php");
if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}


if(!is_numeric($timestamp)) {
$timestamp = strtotime($timestamp);
}

$dateconv = str_replace(
  array('FULL_MONTH_NAME','ABBR_MONTH_NAME','NUMERIC_MONTH_LEADING_ZERO','NUMERIC_MONTH_NO_LEADING_ZERO','NUMERIC_DAY_LEADING_ZERO','NUMERIC_DAY_NO_LEADING_ZERO', 'DAY_OF_WEEK_ABBR','DAY_OF_WEEK_FULL','ENGLISH_SUFFIX','4_DIGIT_YEAR','2_DIGIT_YEAR','24_HOURS_NO_LEADING_ZERO','24_HOURS_LEADING_ZERO','HOURS_NO_LEADING_ZERO','HOURS_LEADING_ZERO','MINUTES','SECONDS','AM_PM_LOWERCASE','AM_PM_UPPERCASE'),
  array(pcrtlang(date("F",$timestamp)),pcrtlang(date("M",$timestamp)),date("m",$timestamp),date("n",$timestamp),date("d",$timestamp),date("j",$timestamp),pcrtlang(date("D",$timestamp)),pcrtlang(date("l",$timestamp)),date("S",$timestamp),date("Y",$timestamp),date("y",$timestamp),date("G",$timestamp),date("H",$timestamp),date("g",$timestamp),date("h",$timestamp),date("i",$timestamp),date("s",$timestamp),date("a",$timestamp),date("A",$timestamp)),
  $timestring
);

return $dateconv;

}


function implode_list($value) {
if(is_array($value)) {
$newvalue = "_";
foreach($value as $key => $valueitem) {
$newvalue .= "$valueitem"."_";
}
} else {
$newvalue = "$value";
}
return $newvalue;
}

function explode_list($value) {
if (strpos($value, '_') === false) {
return array_filter(array($value));
} else {
return array_values(array_filter(explode("_", "$value")));
}
}


function implode_list_email($value) {
if(is_array($value)) {
$newvalue = "_pcrtemail_";
foreach($value as $key => $valueitem) {
$newvalue .= "$valueitem"."_pcrtemail_";
}
} else {
$newvalue = "$value";
}
return $newvalue;
}

function explode_list_email($value) {
if (strpos($value, '_pcrtemail_') === false) {
return array($value);
} else {
return array_filter(explode("_pcrtemail_", $value));
}
}


function addhttp($url) {
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://" . $url;
    }
    return $url;
}


function overduerinvoice($rinvoice_id) {
require("deps.php");
$rs_invoices = "SELECT * FROM invoices WHERE iorq != 'quote' AND invdate < (DATE_SUB(NOW(),INTERVAL $invoiceoverduedays DAY))
AND invstatus = '1' AND rinvoice_id = '$rinvoice_id'";
$rs_find_invoices = @mysqli_query($rs_connect, $rs_invoices);
$totalinv = mysqli_num_rows($rs_find_invoices);
if ($totalinv != "0") {
return 1;
} else {
return 0;
}
}


function invoicetotal($pcgroupid,$invstatus) {

$invoicegrandtotal = 0;

require("deps.php");

$invoicetotalids = "(SELECT DISTINCT(invoices.invoice_id) FROM invoices, pc_wo, pc_owner WHERE pc_owner.pcgroupid = '$pcgroupid' AND pc_owner.pcid = pc_wo.pcid
AND invoices.iorq != 'quote' AND invoices.invstatus = '$invstatus' AND (pc_wo.woid = invoices.woid OR invoices.woid LIKE CONCAT('%\_',pc_wo.woid,'\_%')))
UNION (SELECT invoices.invoice_id FROM invoices,rinvoices WHERE invoices.rinvoice_id = rinvoices.rinvoice_id AND rinvoices.pcgroupid = '$pcgroupid'
AND invoices.invstatus = '$invstatus')
UNION (SELECT invoice_id FROM invoices WHERE pcgroupid = '$pcgroupid' AND invoices.invstatus = '$invstatus')";

$rs_resultit = mysqli_query($rs_connect, $invoicetotalids);
while($rs_result_it = mysqli_fetch_object($rs_resultit)) {
$invoicetotalidarray[] = "$rs_result_it->invoice_id";

foreach($invoicetotalidarray as $key => $iids) {
$findinvtotal = "SELECT SUM(cart_price) AS invsubtotal, SUM(itemtax) AS invtax FROM invoice_items WHERE invoice_id = '$iids'";
$findinvq = @mysqli_query($rs_connect, $findinvtotal);
$findinva = mysqli_fetch_object($findinvq);
$invtax = "$findinva->invtax";
$invsubtotal = "$findinva->invsubtotal";
$invoicegrandtotal = $invtax + $invsubtotal + $invoicegrandtotal;
}
}

return mf($invoicegrandtotal);

}


function printableheader($title) {

global $autoprint;

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php
echo "<title>$title</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../repair/printstyle.css\">";
echo "<link rel=\"stylesheet\" href=\"../repair/fa/css/font-awesome.min.css\">";
echo "<link rel=\"stylesheet\" href=\"../repair/fa/font-awesome-animation.min.css\">";
echo "</head>";

if($autoprint == 1) {
echo "<body class=printpagebg onLoad=\"window.print()\">";
} else {
echo "<body class=printpagebg>";
}
echo "<div class=printbar>";
echo "<button onClick=\"window.history.back()\" class=bigbutton><img src=../repair/images/left.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Return")."</button>";
echo "<font class=text30b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>";
echo "<button onClick=\"print();\" class=bigbutton><img src=../repair/images/print.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Print")."</button>";
echo "</div>";
echo "<div class=printpage>";

}



function printablefooter() {
echo "</div>";
echo "</body></html>";
}


function getcurrentregister() {
if (array_key_exists("registerid", $_COOKIE)) {
$registerid = $_COOKIE['registerid'];
} else {
$registerid = 0;
}
return $registerid;
}

function fetchtagdata() {
require("deps.php");
$rs_sq = "SELECT * FROM custtags ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_sq);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$tagid = "$rs_result_q1->tagid";
$thetag = "$rs_result_q1->thetag";
$tagicon = "$rs_result_q1->tagicon";
$tagenabled = "$rs_result_q1->tagenabled";
$theorder = "$rs_result_q1->theorder";
$primero = mb_substr("$thetag", 0, 1);

if("$primero" != "-") {
$tagdata[$tagid] = array('tagid' => "$tagid",'thetag' => "$thetag",'tagicon' => "$tagicon",'tagenabled' => "$tagenabled");
}
}
return $tagdata;
}


function displaytags($pcid,$groupid,$size) {
require("deps.php");

if($pcid != "0") {
$rs_tq = "SELECT tags FROM pc_owner WHERE pcid = '$pcid'";
$rs_result1 = mysqli_query($rs_connect, $rs_tq);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$tags = "$rs_result_q1->tags";
$tagsarray = explode_list($tags);
} else {
$tagsarray = array();
}

if($groupid != "0") {
$rs_tq = "SELECT tags FROM pc_group WHERE pcgroupid = '$groupid'";
$rs_result1 = mysqli_query($rs_connect, $rs_tq);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$tagsgroup = "$rs_result_q1->tags";
$tagsgrouparray = explode_list($tagsgroup);
} else {
$tagsgrouparray = array();
}

$combinedtagsarray = array_unique(array_merge($tagsarray,$tagsgrouparray));

if(!empty($combinedtagsarray)) {
static $tagdata = false;
if(!$tagdata) {
$tagdata2 = fetchtagdata();
$tagdata = $tagdata2;
}
foreach($combinedtagsarray as $tagkey => $tagval) {
        if(!empty($tagval)) {
        echo "<img src=../repair/images/tags/".$tagdata[$tagval]['tagicon']." width=\"$size\"> ";
        }
}
} else {
}


}




function findreturnreceipts($receipt) {
require("deps.php");
$addit_idsa = array();
$find_r_receipts = "SELECT * FROM sold_items WHERE receipt = '$receipt' AND return_receipt != ''";
$rs_resultfrr = mysqli_query($rs_connect, $find_r_receipts);
while($rs_resultfrr_q = mysqli_fetch_object($rs_resultfrr)) {
$return_receipt = "$rs_resultfrr_q->return_receipt";
$addit_ids = explode_list($return_receipt);
$addit_idsa = array_merge($addit_idsa, $addit_ids);

if(count($addit_ids) != 0) {
foreach($addit_ids as $key => $receipt2) {
$moreids = findreturnreceipts($receipt2);
$addit_idsa = array_merge($moreids, $addit_idsa);
}
}

}
return $addit_idsa;
}


function tnv($value) {
if(!is_numeric($value)) {
return 0;	
} else {
return "$value";	
}
}


function checkssl() {
    if (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) === 'on') {
      return TRUE;
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
      return TRUE;
    } elseif (isset($_SERVER['HTTP_FRONT_END_HTTPS']) && $_SERVER['HTTP_FRONT_END_HTTPS'] === 'on') {
      return TRUE;
    }
    return FALSE;
}

function filtersmsnumber($value) {
require("deps.php");
if(!isset($smsnumberfilter)) {
return "$value";
} else {
if($smsnumberfilter == "0") {
return "$value";
} elseif ($smsnumberfilter == "1") {
return substr("$value", 1);
} else {
return "$value";
}
}
}


function servicepromiseicon($time,$label) {
require("deps.php");
if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}

$day = date('Y-m-d', strtotime($time));
$daytomorrow = date('Y-m-d', strtotime("+1 day"));
$dayendofweek = strtotime("+7 day");
$timenewtoendofweek = $dayendofweek - strtotime($time);
$exacttime = strtotime($time);

if($exacttime < time()) {
$animated = "faa-flash animated";
} else {
$animated = "";
}

if($day == date('Y-m-d')) {
$icon = "<i class=\"fa fa-stopwatch fa-2x menuicon2x $animated\" style=\"color:#ff0000\"></i>";
if ($label == "label") {
$icon .= "<span class=\"sizemelarger boldme\" style=\"color:#ff0000\"> ".pcrtlang("Today")."</span>";
}

} elseif ($day == $daytomorrow) {
$icon = "<i class=\"fa fa-stopwatch fa-2x menuicon2x\" style=\"color:#f9aa00\"></i>";
if ($label == "label") {
$icon .= "<span class=\"sizemelarger boldme\" style=\"color:#f9aa00\"> ".pcrtlang("Tomorrow")."</span>";
}
} elseif ($timenewtoendofweek < 604800) {
$icon = "<i class=\"fa fa-stopwatch fa-2x menuicon2x\" style=\"color:#ead300\"></i>";
if ($label == "label") {
$icon .= "<span class=\"sizemelarger boldme\" style=\"color:#ead300\"> ".pcrtlang("Soon")."</span>";
}
} elseif($exacttime < time()) {
$icon = "<i class=\"fa fa-stopwatch fa-2x menuicon2x $animated\" style=\"color:#ff0000\"></i>";
if ($label == "label") {
$icon .= "<span class=\"sizemelarger boldme\" style=\"color:#ff0000\"> ".pcrtlang("Overdue")."</span>";
}
} else {
$icon = "";
}

return "$icon";

}

function getinvoicetermstitle($invoicetermsid) {
require("deps.php");
$rs_sl = "SELECT * FROM invoiceterms WHERE invoicetermsid = '$invoicetermsid'";
$rs_result1 = mysqli_query($rs_connect, $rs_sl);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$invoicetermstitle = "$rs_result_q1->invoicetermstitle";
return "$invoicetermstitle";
}

function getinvoicetermsdefault() {
require("deps.php");
$rs_sl = "SELECT * FROM invoiceterms WHERE invoicetermsdefault = '1' LIMIT 1";
$rs_result1 = mysqli_query($rs_connect, $rs_sl);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$invoicetermsid = "$rs_result_q1->invoicetermsid";
return "$invoicetermsid";
}

