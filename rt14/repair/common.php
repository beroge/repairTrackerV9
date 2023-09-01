<?php

/***************************************************************************
 *   copyright            : (C) 2020 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/

require_once("deps.php");
require_once("validate2.php");

$rs_ql = "SELECT gomodal,autoprint,touchview,promiseview,floatbar,defaultstore,statusview,narrow,narrowct FROM users WHERE username = '$ipofpc'";
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
$promiseview = "$rs_result_q1->promiseview";

#########################################################

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


########################################################


function adjustBrightness($hex, $steps) {
    // Steps should be between -255 and 255. Negative = darker, positive = lighter
    $steps = max(-255, min(255, $steps));

    // Normalize into a six character long hex string
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
    }

    // Split into three parts: R, G and B
    $color_parts = str_split($hex, 2);
    $return = '#';

    foreach ($color_parts as $color) {
        $color   = hexdec($color); // Convert to decimal
        $color   = max(0,min(255,$color + $steps)); // Adjust color
        $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
    }

    return $return;
}



##



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
echo "<span class=colormered>".pcrtlang("Today @")." ";
echo date("g:i a", $thetimestamp)."</span>";
} elseif($thetomorrowday == $thecheckday) {
echo "<span class=colormeblue>".pcrtlang("Tomorrow @")." ";
echo date("g:i a", $thetimestamp)."</span>";
} elseif(time() > $thetimestamp) {
echo "<span class=colormered>".pcrtlang("Past Due").": ";
echo elaps($thetime)."</span>";
} else {
echo "<span class=\"sizemesmaller boldme\">".date("Y-m-d g:i a", $thetimestamp)."</span>";
}
}


function start_blue_box($blue_title) {
	$boxstyle = getboxstyle(50);
	echo "<div class=colortitletopround style=\"background:#$boxstyle[selectorcolor]\"><span class=\"sizemelarger colormewhite textoutline\">$blue_title</span></div><div class=whitebottom>";
}

function stop_blue_box() {
        echo "</div>\n";
}

function start_gray_box($gray_title) {
        echo "<div class=colortitletopround><span class=\"sizemelarger colormewhite textoutline\">$gray_title</span></div><div class=whitebottom>";
}

function stop_gray_box() {
        echo "</div>\n";
}


function start_color_box($statusid,$title) {
	$boxstyle = getboxstyle($statusid);
        echo "<div class=\"colortitletopround\" style=\"background:#$boxstyle[selectorcolor]\">\n";
        echo "<span class=\"sizemelarger colormewhite textoutline\">$title</span></div>\n";
        echo "<div class=whitebottom>\n";
}

function start_color_altbox($statusid,$title,$total) {
        $boxstyle = getboxstyle($statusid);
        echo "<div class=\"colortitletopround\" style=\"background:#$boxstyle[selectorcolor];\">\n";
        echo "<span class=\"sizemelarger colormewhite textoutline\">$title</span><span style=\"background:#ffffff;font-weight:bold;color:#$boxstyle[selectorcolor];
padding:1px;border-radius:50%;float:right;box-sizing:border-box;opacity:.8;\">&nbsp;$total&nbsp;</span></div>\n";
$lighter = adjustBrightness("$boxstyle[selectorcolor]", 75);
        echo "<div class=altbottom style=\"background:$lighter;\">\n";
}


function start_color_altbox_collapsed($statusid,$title,$total) {
        $boxstyle = getboxstyle($statusid);
        echo "<div class=\"colortitletopround\" style=\"background:#$boxstyle[selectorcolor];\">\n";
        echo "<span class=\"sizemelarger colormewhite textoutline\">$title</span>";

if($statusid == "4") {
echo "<a href=pc.php?func=checkoutpc style=\"padding:3px;\" class=\"linkbuttonsmall linkbuttonopaque radiusall floatright\">
$total <i class=\"fa fa-chevron-right fa-lg\"></i></a>";
} else { 
echo "<a href=pc.php?func=viewassetstatus&pcstatus=$statusid style=\"padding:3px;\" class=\"linkbuttonsmall linkbuttonopaque radiusall floatright\">
$total <i class=\"fa fa-chevron-right fa-lg\"></i></a>";
}
echo "</div>\n";

}


function start_color_boxnobottomround($statusid,$title) {
	$boxstyle = getboxstyle($statusid);
        echo "<div class=\"colortitletopround\" style=\"background:#$boxstyle[selectorcolor]\">\n";
        echo "$title</div>\n";
        echo "<div class=whitemiddle>\n";
}

function start_color_boxnoround($statusid,$title) {
	$boxstyle = getboxstyle($statusid);
     	echo "<div class=\"colortitle\" style=\"background:#$boxstyle[selectorcolor]\">\n";
        echo "<span class=\"sizemelarger colormewhite textoutline\">$title</span></div>\n";
        echo "<div class=whitebottom>\n";
}

function stop_color_box() {
        echo "</div>\n";
}

function start_box() {
        echo "<div class=startbox>\n";
}


function start_repaircartitem() {
        echo "<div class=repaircartitem>\n";
}


function start_box_cb($bgcolor) {
        echo "<div style=\"background:#$bgcolor;\" class=colorbox>\n";
}

function start_box_touch($bgcolor) {
        echo "<div style=\"border-bottom:#$bgcolor 7px solid;\" class=touchbox>\n";
}


function start_box_sn($bgcolor,$bgcolor2,$bordercolor) {
        echo "<div style=\"border:1px solid #$bordercolor; background:#$bgcolor; background: linear-gradient(to bottom, #$bgcolor 0%, #$bgcolor2 100%);\"  class=colorboxsn>\n";
}


function stop_box() {
        echo "</div>\n";
}

function start_moneybox() {
        echo "<div class=moneybox>\n";
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
if (preg_match('/dell/i', $pcmake) || preg_match('/latitude/i', $pcmake) || preg_match('/vostro/i', $pcmake) || preg_match('/inspiron/i', $pcmake)) {
   echo "<img src=images/pcs/dell.png border=0>";
} elseif (preg_match('/compaq/i', $pcmake)) {
echo "<img src=images/pcs/compaq.png border=0>";
} elseif (preg_match('/hp/i', $pcmake) || preg_match('/probook/i', $pcmake) || preg_match('/elitebook/i', $pcmake) || preg_match('/pavillion/i', $pcmake)) {
echo "<img src=images/pcs/hp.png border=0>";
} elseif (preg_match('/toshiba/i', $pcmake) || preg_match('/satellite/i', $pcmake) || preg_match('/tecra/i', $pcmake)) {
echo "<img src=images/pcs/toshiba.png border=0>";
} elseif (preg_match('/emachine/i', $pcmake) || preg_match('/e-machine/i', $pcmake) || preg_match('/etower/i', $pcmake)) {
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
} elseif (preg_match('/lenovo/i', $pcmake) || preg_match('/thinkpad/i', $pcmake) || preg_match('/yoga/i', $pcmake)) {
echo "<img src=images/pcs/lenovo.jpg border=0>";
} elseif (preg_match('/apple/i', $pcmake) || preg_match('/macbook/i', $pcmake) || preg_match('/ipad/i', $pcmake) || preg_match('/iphone/i', $pcmake)) {
echo "<img src=images/pcs/apple.png border=0>";
} elseif (preg_match('/google/i', $pcmake) || preg_match('/pixel/i', $pcmake) || preg_match('/nexus/i', $pcmake)) {
echo "<img src=images/pcs/google.png border=0>";
} elseif (preg_match('/htc/i', $pcmake)) {
echo "<img src=images/pcs/htc.png border=0>";
} elseif (preg_match('/huawei/i', $pcmake)) {
echo "<img src=images/pcs/huawei.png border=0>";
} elseif (preg_match('/motorola/i', $pcmake)) {
echo "<img src=images/pcs/motorola.png border=0>";
} elseif (preg_match('/microsoft/i', $pcmake) || preg_match('/surface/i', $pcmake) || preg_match('/lumia/i', $pcmake)) {
echo "<img src=images/pcs/ms.png border=0>";
} elseif (preg_match('/samsung/i', $pcmake)) {
echo "<img src=images/pcs/samsung.png border=0>";
} elseif (preg_match('/xiaomi/i', $pcmake)) {
echo "<img src=images/pcs/xiaomi.png border=0>";
} elseif (preg_match('/zte/i', $pcmake)) {
echo "<img src=images/pcs/zte.png border=0>";
} elseif (preg_match('/lg/i', $pcmake)) {
echo "<img src=images/pcs/lg.png border=0>";
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


function getassettypeshowscans($mainassettypeid) {
require("deps.php");

$rs_findassettypes = "SELECT * FROM mainassettypes WHERE mainassettypeid = '$mainassettypeid'";
$rs_resultfat = mysqli_query($rs_connect, $rs_findassettypes);
$rs_result_qfat = mysqli_fetch_object($rs_resultfat);
$mainassetshowscans = "$rs_result_qfat->showscans";
return $mainassetshowscans;
}



function showpcs() {
require("deps.php");

$rs_ql = "SELECT defaultstore,statusview,promiseview FROM users WHERE username = '$ipofpc'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$defaultuserstore = "$rs_result_q1->defaultstore";
$statusview = "$rs_result_q1->statusview";
$promiseview = "$rs_result_q1->promiseview";

if(!isset($statusassetlimit)) {
$statusassetlimit = 12;
}

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
$viewdisabled0 = "style=\"border-bottom: 3px #0090ff solid\"";
$viewdisabled1 = "style=\"border-bottom: 3px #333333 solid\"";
$viewdisabled2 = "style=\"border-bottom: 3px #333333 solid\"";
$viewdisabled3 = "style=\"border-bottom: 3px #333333 solid\"";
} elseif ($statusview == 1) {
$viewdisabled0 = "style=\"border-bottom: 3px #333333 solid\"";
$viewdisabled1 = "style=\"border-bottom: 3px #0090ff solid\"";
$viewdisabled2 = "style=\"border-bottom: 3px #333333 solid\"";
$viewdisabled3 = "style=\"border-bottom: 3px #333333 solid\"";
} elseif ($statusview == 2) {
$viewdisabled0 = "style=\"border-bottom: 3px #333333 solid\"";
$viewdisabled1 = "style=\"border-bottom: 3px #333333 solid\"";
$viewdisabled2 = "style=\"border-bottom: 3px #0090ff solid\"";
$viewdisabled3 = "style=\"border-bottom: 3px #333333 solid\"";
} else {
$viewdisabled0 = "style=\"border-bottom: 3px #333333 solid\"";
$viewdisabled1 = "style=\"border-bottom: 3px #333333 solid\"";
$viewdisabled2 = "style=\"border-bottom: 3px #333333 solid\"";
$viewdisabled3 = "style=\"border-bottom: 3px #0090ff solid\"";
}

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}

$thenow = date('Y-m-d H:i:s');
$daystart = date('Y-m-d')." 00:00:00";
$dayend = date('Y-m-d')." 23:59:59";
$tomorrowend = date('Y-m-d', strtotime("+1 day"))." 23.59.59";
$day7end  = date('Y-m-d', strtotime("+7 day"))." 23.59.59";

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



$excludedcollapsed = "";
$rs_findstatiic = "SELECT * FROM boxstyles WHERE displayedstatus = '1' AND collapsedstatus = '1'";
$rs_result_stc = mysqli_query($rs_connect, $rs_findstatiic);
while($rs_result_stqc = mysqli_fetch_object($rs_result_stc)) {
$statusidcol = "$rs_result_stqc->statusid";
$excludedcollapsed .= " AND pcstatus != '$statusidcol'";
}


$rs_findtotalpcs = "SELECT * FROM pc_wo WHERE storeid = '$defaultuserstore' $promisediff AND pcstatus != '0' AND 
((sked = '0' AND pcstatus != '5' AND pcstatus != '7' AND pcstatus != '4' AND pcstatus != '6' $excludedcollapsed) OR 
(sked = '1' AND pcstatus != '5' AND pcstatus != '7' AND pcstatus != '4' $excludedcollapsed AND DATE_ADD('$daystart', INTERVAL 2 DAY) > skeddate) OR
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



echo "<div class=\"nvbar2 radiusall\">";
echo "<a href=pc.php?func=changestatusview&view=0 class=catchchangestatus $viewdisabled0><img src=images/prog_store.png class=menuicon2x> $totalpcss_total</a>";
echo "<a href=pc.php?func=changestatusview&view=1 class=catchchangestatus $viewdisabled1><img src=images/prog_user.png class=menuicon2x> $totalpcssu_total</a>";
echo "<a href=pc.php?func=changestatusview&view=2 class=catchchangestatus $viewdisabled2><img src=images/prog_store_sked.png class=menuicon2x> $totalpcss_sked_total</a>";
echo "<a href=pc.php?func=changestatusview&view=3 class=catchchangestatus $viewdisabled3><img src=images/prog_user_sked.png class=menuicon2x> $totalpcssu_sked_total</a>";

echo "<div class=\"nvdropdown2\">";
echo "<button class=\"nvdropbtn2\"><i class=\"fa fa-stopwatch fa-2x menuicon2x\"></i>";
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


echo " <i class=\"fa fa-caret-down\"></i>";
echo "</button>";
echo "<div class=\"nvdropdown-content2\">";


echo "<a href=pc.php?func=changepromiseview&view=0 class=catchchangestatus><i class=\"fa fa-stopwatch fa-2x menuicon2x\" style=\"color:#777777\"></i> ".pcrtlang("Show All")."</a>";
echo "<a href=pc.php?func=changepromiseview&view=6 class=catchchangestatus><i class=\"fa fa-stopwatch fa-2x menuicon2x colormelevel4\"></i> ".pcrtlang("Overdue")."</a>";
echo "<a href=pc.php?func=changepromiseview&view=4 class=catchchangestatus><i class=\"fa fa-stopwatch fa-2x menuicon2x colormelevel4\"></i> ".pcrtlang("Today/Overdue")."</a>";
echo "<a href=pc.php?func=changepromiseview&view=1 class=catchchangestatus><i class=\"fa fa-stopwatch fa-2x menuicon2x colormelevel3\"></i> ".pcrtlang("Today")."</a>";
echo "<a href=pc.php?func=changepromiseview&view=5 class=catchchangestatus><i class=\"fa fa-stopwatch fa-2x menuicon2x colormelevel3\"></i> ".pcrtlang("Today/Tomorrow")."</a>";
echo "<a href=pc.php?func=changepromiseview&view=2 class=catchchangestatus><i class=\"fa fa-stopwatch fa-2x menuicon2x colormelevel2\"></i> ".pcrtlang("Tomorrow")."</a>";
echo "<a href=pc.php?func=changepromiseview&view=3 class=catchchangestatus><i class=\"fa fa-stopwatch fa-2x menuicon2x colormelevel1\"></i> ".pcrtlang("Soon")."</a>";

echo "</div>";
echo "</div>";
echo "</div>";

echo "<br>";


$rs_findstatii = "SELECT * FROM boxstyles WHERE displayedstatus = '1' ORDER BY displayedorder ASC";
$rs_result_st = mysqli_query($rs_connect, $rs_findstatii);
while($rs_result_stq = mysqli_fetch_object($rs_result_st)) {
$statusids[] = "$rs_result_stq->statusid";
$statusoptions[$rs_result_stq->statusid] = serializedarraytest("$rs_result_stq->statusoptions");
$statuscollapsed[$rs_result_stq->statusid] = "$rs_result_stq->collapsedstatus";
}



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
$rs_findpcs = "SELECT * FROM pc_wo WHERE pcstatus = '$statusid' $promisediff AND storeid = '$defaultuserstore' AND ((sked = '0') OR (sked = '1' AND DATE_ADD('$daystart', INTERVAL 2 DAY) > skeddate)) ORDER BY $statsort ASC ";
} elseif($statusview == 1) {
$rs_findpcs = "SELECT * FROM pc_wo WHERE pcstatus = '$statusid' $promisediff AND storeid = '$defaultuserstore' AND assigneduser = '$ipofpc' AND ((sked = '0') OR (sked = '1' AND DATE_ADD('$daystart', INTERVAL 2 DAY) > skeddate)) ORDER BY $statsort ASC";
} elseif($statusview == 2) {
$rs_findpcs = "SELECT * FROM pc_wo WHERE pcstatus = '$statusid' $promisediff AND storeid = '$defaultuserstore' AND sked = '1' ORDER BY $statsort ASC";
} else {
$rs_findpcs = "SELECT * FROM pc_wo WHERE pcstatus = '$statusid' $promisediff AND storeid = '$defaultuserstore' AND assigneduser = '$ipofpc' AND sked = '1' ORDER BY $statsort ASC";
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

if (($totalworkorders != 0) || ($statusid == "1")) {

if ($statuscollapsed[$statusid] == 0) {

start_color_altbox("$statusid","$boxstyle[boxtitle]",$totalworkordersoverall);

#wip

if((($statusview == "1") || ($statusview == "3")) && $statusid == "1") {
$rs_findpcsunass = "SELECT * FROM pc_wo WHERE pcstatus = '1' AND storeid = '$defaultuserstore' AND assigneduser = ''";
$rs_resultunass = mysqli_query($rs_connect, $rs_findpcsunass);
$totalworkordersunass = mysqli_num_rows($rs_resultunass);
echo "<center><a href=\"pc.php?func=viewassetstatus&pcstatus=$statusid&claim=yes\" class=\"linkbuttonmedium linkbuttonblack displayblock radiusall\"
style=\"background:#$boxstyle[selectorcolor];\"><i class=\"fa fa-hands fa-lg\"></i> ".pcrtlang("Claim Job");

echo "<span style=\"background:#ffffff;font-weight:bold;color:#$boxstyle[selectorcolor];padding:2px;border-radius:3px;float:right;box-sizing:border-box;opacity:.8;\">&nbsp;$totalworkordersunass&nbsp;".pcrtlang("Unassigned")."&nbsp;</span>";

echo "</a>";
echo "</center><br>";
}

$theworkordercount = 0;


while($rs_result_q = mysqli_fetch_object($rs_result)) {

$pcid = "$rs_result_q->pcid";
$woid = "$rs_result_q->woid";
$dropdate = "$rs_result_q->dropdate";
$pickupdate = "$rs_result_q->pickupdate";
$workarea = "$rs_result_q->workarea";
$pcpriorityindb = "$rs_result_q->pcpriority";
$thepass = "$rs_result_q->thepass";
$probdesc = "$rs_result_q->probdesc";
$called = "$rs_result_q->called";
$commonproblems = "$rs_result_q->commonproblems";
$assigneduser = "$rs_result_q->assigneduser";
$skeddate = "$rs_result_q->skeddate";
$sked = "$rs_result_q->sked";
$slid = "$rs_result_q->slid";
$servicepromiseid = "$rs_result_q->servicepromiseid";
$promisedtime = "$rs_result_q->promisedtime";

$dropdatestring = strtotime($dropdate);
$dropdatestringdiff = time() - $dropdatestring;
if(($dropdatestringdiff < 2592000) || ($statusid != 4)) {

$theworkordercount++;


$theprobsindb = serializedarraytest($commonproblems);

$commprob = "";
foreach($theprobsindb as $key => $val) {
$commprob .= "<br>&bull; $val";
}


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


$rs_findowner = "SELECT pcname,pcmake,pccompany,mainassettypeid,prefcontact,pcphone,pcemail,pccellphone,pcworkphone,scid,pcgroupid FROM pc_owner WHERE pcid = '$pcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);

$checkthewo = mysqli_num_rows($rs_result2);

if($checkthewo == 0) {
$rs_check = "UPDATE pc_wo SET pcstatus = '5' WHERE woid = '$woid'";
@mysqli_query($rs_connect, $rs_check);
}

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
$pcgroupid = "$rs_result_q2->pcgroupid";

if (in_array("workbench", $statusoptions[$statusid])) {
if (($workarea == "") || !array_key_exists("$workarea", $storeworkareas)) {
$workarea2 = pcrtlang("Unassigned");
$bgstyle2 = "style=\"background: #cccccc;padding:4px;border-radius:3px;\"";
} else {
$workarea2 = "$workarea";
$bgcolor = $storeworkareas[$workarea];
$bgstyle2 = "style=\"background: #$bgcolor;padding:4px;border-radius:3px;\"";
}

if (($workarea != $theprev) && (!empty($storeworkareas)))  {
echo "<div $bgstyle2>&nbsp;<span class=\"linkbuttongraylabel linkbuttonsmall radiusall\"><i class=\"fa fa-plug fa-lg\"></i> $workarea2&nbsp;</span></div>\n";
}

$theprev = "$workarea";
}

#####

if (in_array("bprogresscounters", $statusoptions[$statusid])) {
echo "<table class=\"badgetop\">";
} else {
echo "<table class=\"badge\">";
}

echo "<tr><td style=\"padding:0px;\">";
echo "<table style=\"width:100%;border-collapse:collapse;\">";
echo "<tr>";
echo "<td style=\"width:30px;text-align:center;vertical-align:top;background:#f1f1f1;padding:5px;border-top-left-radius:3px;\">";

if (in_array("bmakeicon", $statusoptions[$statusid])) {
echo pclogo($pcmake);
}

if(($servicepromiseid != 0) && ($pickupdate == "0000-00-00 00:00:00")) {
echo servicepromiseicon("$promisedtime","nolabel");
}


if (in_array("bdevicepriority", $statusoptions[$statusid])) {
if ($picon != "") {
echo "<img src=images/$picon align=absmiddle>";
}
}

if (in_array("bstatuscheck", $statusoptions[$statusid])) {
if(in_array("$woid", $cscarray)) {
$thecheckarray = customerstatuscheck($woid,2);
echo "<br><i class=\"fa fa-eye fa-lg\" style=\"color:#0000ff\"></i>";
}
}


if (in_array("bcalled", $statusoptions[$statusid])) {

if ($called == 1) {
$calledtext = pcrtlang("Not Called");
$calledicon = "<i class=\"fa fa-phone-square fa-lg fa-fw colormered\"></i>";
} elseif ($called == 2){
$calledtext = pcrtlang("Called");
$calledicon = "<i class=\"fa fa-phone-square fa-lg fa-fw colormegreen\"></i>";
} elseif  ($called == 3){
$calledtext = pcrtlang("Called - No Answer");
$calledicon = "<i class=\"fa fa-phone-square fa-lg fa-fw colormeyellow\"></i>";
} elseif  ($called == 7){
$calledtext = pcrtlang("Called - Left Voice Message");
$calledicon = "<i class=\"fa fa-phone-square fa-lg fa-fw colormegreen\"></i>";
} elseif  ($called == 5){
$calledtext = pcrtlang("Sent SMS");
$calledicon = "<i class=\"fa fa-mobile fa-lg fa-fw colormegreen\"></i>";
} elseif  ($called == 6){
$calledtext = pcrtlang("Sent Email");
$calledicon = "<i class=\"fa fa-envelope fa-lg fa-fw colormegreen\"></i>";
} else {
$calledtext = pcrtlang("Called - Waiting for Call Back");
$calledicon = "<i class=\"fa fa-phone-square fa-lg fa-fw colormeblue\"></i>";
}


echo "$calledicon ";
}


if (in_array("bstoragelocation", $statusoptions[$statusid])) {
if($slid != 0) {
$rs_sls = "SELECT * FROM storagelocations WHERE slid = '$slid'";
$rs_result1s = mysqli_query($rs_connect, $rs_sls);
if(mysqli_num_rows($rs_result1s) != 0) {
$rs_result_q1s = mysqli_fetch_object($rs_result1s);
$slname = "$rs_result_q1s->slname";
echo "<span class=\"linkbuttontiny linkbuttongraylabel radiusall\" style=\"margin-top:5px; padding:2px;\"><i class=\"fa fa-map-marker\"></i> $slname</span>";
}
}
}


displaytags($pcid,$pcgroupid,24);


echo "</td>";
echo "<td style=\"padding:5px 5px 5px 20px;text-align:left; vertical-align:top\" rowspan=2>";

echo "<div><span class=\"sizeme16 boldme600\">$pcname</span>";

if (in_array("bwoids", $statusoptions[$statusid])) {
echo "<span class=\"floatright boldme500 sizeme16\"><i class=\"fa fa-tag\"></i>$pcid  &nbsp;&nbsp;<i class=\"fa fa-clipboard\"></i>$woid</span>";
}

echo "</div>";

if (in_array("bcompany", $statusoptions[$statusid])) {
if($pccompany != "") {
echo "<span class=boldme600>$pccompany</span>";
}
}

echo "<span style=\"border-bottom: 2px #$boxstyle[selectorcolor] solid; display:block\"></span>";

###

echo "<table class=standardbadge>";

if (in_array("bassettype", $statusoptions[$statusid])) {
$mainassettype = getassettypename($mainassettypeidindb);
echo "<tr><td style=\"width:30px;\"><i class=\"fa fa-cog\"></i></td><td>$mainassettype: $pcmake</td></tr>";
}


if (in_array("bproblem", $statusoptions[$statusid])) {
if(($probdesc != "") || ($commprob != "")) {
echo "<tr><td style=\"width:30px;\"><i class=\"fa fa-wrench\"></i></td><td>".nl2br("$probdesc")." $commprob</td></tr>";
}
}

if (in_array("bmsp", $statusoptions[$statusid])) {
if($scid == 1) {
echo "<tr><td style=\"width:30px;\"><i class=\"fa fa-file-contract\"></i></td><td>".pcrtlang("Service Contract")." #$scid</td></tr>";
}
}


if (in_array("bskedjobs", $statusoptions[$statusid])) {
if($sked == 1) {
echo "<tr><td style=\"width:30px;\"><i class=\"fa fa-clock-o\"></i></td><td>";
skedwhen("$skeddate");
echo "</td></tr>";
}
}

if (in_array("bpassword", $statusoptions[$statusid])) {
$rs_findcreds = "SELECT * FROM creds WHERE pcid = '$pcid' AND credtype < '3' ORDER BY creddate DESC";
$rs_result_creds = mysqli_query($rs_connect, $rs_findcreds);
while($rs_result_qcreds = mysqli_fetch_object($rs_result_creds)) {
$creddesc = "$rs_result_qcreds->creddesc";
$creduser = "$rs_result_qcreds->creduser";
$credpass = "$rs_result_qcreds->credpass";
$credtype = "$rs_result_qcreds->credtype";
$patterndata = "$rs_result_qcreds->patterndata";
if($credtype == 1) {
echo "<tr><td style=\"width:30px;\"><i class=\"fa fa-user-lock\"></i></td><td>$creddesc: <i class=\"fa fa-user\"></i> $creduser <i class=\"fa fa-key\"></i> $credpass</td></tr>";
} else {
echo "<tr><td style=\"width:30px;\"><i class=\"fa fa-user-lock\"></i></td><td>$creddesc: <i class=\"fa fa-thumb-tack\"></i> $credpass</td></tr>";
}
}
}

if (in_array("bpattern", $statusoptions[$statusid])) {
$rs_findcreds = "SELECT * FROM creds WHERE pcid = '$pcid' AND credtype = '3' ORDER BY creddate DESC";
$rs_result_creds = mysqli_query($rs_connect, $rs_findcreds);
require_once("patterns.php");
while($rs_result_qcreds = mysqli_fetch_object($rs_result_creds)) {
$creddesc = "$rs_result_qcreds->creddesc";
$patterndata = "$rs_result_qcreds->patterndata";
echo "<tr><td style=\"width:30px;\"><i class=\"fa fa-user-lock\"></i></td><td>$creddesc: ";
echo draw3x3("$patterndata","small");
echo "</td></tr>";
}
}


if (in_array("bdaysinshop", $statusoptions[$statusid])) {
$elapse = elaps($dropdate);
echo "<tr><td style=\"width:30px;\"><i class=\"fa fa-history\"></i></td><td>$elapse ".pcrtlang("in the shop")."</span></td></tr>";
}

if (in_array("bassigneduser", $statusoptions[$statusid])) {
if($assigneduser != "") {
echo "<tr><td style=\"width:30px;\"><i class=\"fa fa-user-tag\"></i></td><td>$assigneduser</td></tr>";
}
}


if (in_array("brepaircart", $statusoptions[$statusid])) {
$rs_findbill = "SELECT * FROM repaircart WHERE pcwo = '$woid'";
$rs_findbill2 = mysqli_query($rs_connect, $rs_findbill);
$numite = mysqli_num_rows($rs_findbill2);

if($numite != 0) {
$rs_findsum = "SELECT (SUM(cart_price) + SUM(itemtax)) as checkcartsum FROM repaircart WHERE pcwo = '$woid'";
$rs_findsum2 = @mysqli_query($rs_connect, $rs_findsum);
$rs_findsum3 = mysqli_fetch_object($rs_findsum2);
$cartsum = "$rs_findsum3->checkcartsum";

if($cartsum == 0) {
echo "<tr><td style=\"width:30px;\"><i class=\"fa fa-shopping-cart colormered\"></i></td><td><span class=\"colormered\"><i class=\"fa fa-ban\"></i> ".pcrtlang("NO CHARGE")."</span></td></tr>";
} else {
echo "<tr><td style=\"width:30px;\"><i class=\"fa fa-shopping-cart colormegreen\"></i></td><td><span class=\"colormegreen\">$money".mf("$cartsum")."</span></td></tr>";
}

}
}


if($prefcontact == "home") {
$pcontact = "$pcphone";
} else if ($prefcontact == "mobile") {
$pcontact = "$pccellphone";
} else if ($prefcontact == "work") {
$pcontact = "$pcworkphone";
} elseif ($prefcontact == "email") {
$pcontact = "$pcemail";
} else {
$pcontact = "";
}

if (in_array("bpreferredcontact", $statusoptions[$statusid])) {
if($pcontact != "") {
echo "<tr><td style=\"width:30px;\"><i class=\"fa fa-phone\"></i></td><td>$pcontact</td></tr>";
}
}

echo "</table>";
##
#End of Standard Badge / Start of expanded badge



echo "<div id=note$woid style=\"display:none;border-bottom: 2px #$boxstyle[selectorcolor] solid;;border-top: 2px #$boxstyle[selectorcolor] solid;margin-top:10px;\">";


if (in_array("bstatuscheck", $statusoptions[$statusid])) {
if(in_array("$woid", $cscarray)) {
$thecheckarray = customerstatuscheck($woid,2);
echo "<br><i class=\"fa fa-eye fa-lg\" style=\"color:#0000ff\"></i> $thecheckarray[thetimes] ".pcrtlang("time(s)");
echo "<br>".pcrtlang("Last Check").": $thecheckarray[lasttime]<br>";
}
}


if (in_array("eassettype", $statusoptions[$statusid])) {
$mainassettype = getassettypename($mainassettypeidindb);
echo "<br><span class=\"boldme\">$mainassettype:</span> $pcmake";
}

if (in_array("emsp", $statusoptions[$statusid])) {
if($scid == 1) {
echo "<br><a href=\"msp.php?func=viewservicecontract&scid=$scid\" class=\"linkbuttonsmall linkbuttonblack radiusall\"><i class=\"fa fa-file-text\"></i> ".pcrtlang("Service Contract").": $scid</a>";
}
}


if (in_array("epasswords", $statusoptions[$statusid])) {
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

if (in_array("epasswords", $statusoptions[$statusid])) {
$rs_findcreds = "SELECT * FROM creds WHERE pcid = '$pcid' AND credtype = '3' ORDER BY creddate DESC";
$rs_result_creds = mysqli_query($rs_connect, $rs_findcreds);
require_once("patterns.php");
while($rs_result_qcreds = mysqli_fetch_object($rs_result_creds)) {
$creddesc = "$rs_result_qcreds->creddesc";
$patterndata = "$rs_result_qcreds->patterndata";
echo "<br><span class=sizeme10>$creddesc:</span><br>";
echo draw3x3("$patterndata","small");
}
}




if (in_array("eassigneduser", $statusoptions[$statusid])) {
if($assigneduser != "") {
echo "<br><span class=\"boldme\">".pcrtlang("Assigned User").":</span> $assigneduser";
}
}


if (in_array("erepaircart", $statusoptions[$statusid])) {
$rs_findbill = "SELECT * FROM repaircart WHERE pcwo = '$woid'";
$rs_findbill2 = mysqli_query($rs_connect, $rs_findbill);
$numite = mysqli_num_rows($rs_findbill2);

if($numite != 0) {
$rs_findsum = "SELECT (SUM(cart_price) + SUM(itemtax)) as checkcartsum FROM repaircart WHERE pcwo = '$woid'";
$rs_findsum2 = @mysqli_query($rs_connect, $rs_findsum);
$rs_findsum3 = mysqli_fetch_object($rs_findsum2);
$cartsum = "$rs_findsum3->checkcartsum";

if($cartsum == 0) {
echo "<br><span class=\"boldme\">".pcrtlang("Repair Cart Total").":</span> <span class=colormered>$money ".pcrtlang("NO CHARGE")."</span> ";
} else {
echo "<br><span class=\"boldme\">".pcrtlang("Repair Cart Total").":</span> <span class=colormegreen>$money".mf("$cartsum")."</span> ";
}

}
}


if($prefcontact == "home") {
$pcontact = "$pcphone";
} else if ($prefcontact == "mobile") {
$pcontact = "$pccellphone";
} else if ($prefcontact == "work") {
$pcontact = "$pcworkphone";
} elseif ($prefcontact == "email") {
$pcontact = "$pcemail";
} else {
$pcontact = "";
}

if (in_array("epreferredcontact", $statusoptions[$statusid])) {
if($pcontact != "") {
echo "<br><i class=\"fa fa-phone\"></i> $pcontact";
}
}



if (in_array("eproblem", $statusoptions[$statusid])) {
echo "<br><br><span class=\"boldme\">".pcrtlang("Problem").":</span><br>".nl2br("$probdesc")." $commprob";
}

if (in_array("enotes", $statusoptions[$statusid])) {
$technotes4 = "";
$rs_findnotes = "SELECT * FROM wonotes WHERE woid = '$woid' AND notetype = '1' ORDER BY notetime ASC";
$rs_result_n = mysqli_query($rs_connect, $rs_findnotes);
while($rs_result_qn = mysqli_fetch_object($rs_result_n)) {
$technotes4 .= "$rs_result_qn->thenote"."<br><br>";
}

echo "<br><span class=\"boldme\">".pcrtlang("Tech Only Notes").":</span><br>";
echo parseforlinks("$technotes4");

}

if (in_array("ecnotes", $statusoptions[$statusid])) {
$custnotes4 = "";
$rs_findnotes = "SELECT * FROM wonotes WHERE woid = '$woid' AND notetype = '0' ORDER BY notetime ASC";
$rs_result_n = mysqli_query($rs_connect, $rs_findnotes);
while($rs_result_qn = mysqli_fetch_object($rs_result_n)) {
$custnotes4 .= "$rs_result_qn->thenote"."<br><br>";
}

echo "<br><span class=\"boldme\">".pcrtlang("Customer Notes").":</span><br>";
echo parseforlinks("$custnotes4");

}


echo "</div>";

echo "</td>";
echo "<td style=\"width:30px;text-align:center;padding:5px;\" rowspan=2>";
echo "<a href=\"index.php?pcwo=$woid\" class=\"catchloadworkorder linkbuttonmedium linkbuttonopaque2 radiusall displayblock\" style=\"background:#$boxstyle[selectorcolor];color:#ffffff;\"><i class=\"fa fa-chevron-right\"></i></a>";


#wip

echo "</td>";
echo "</tr>";
echo "<tr><td style=\"width:30px;vertical-align:bottom;background:#f1f1f1;\">";
if($yep != 0) {
$lighter2 = adjustBrightness("$boxstyle[selectorcolor]", 230);
echo "<a href=\"javascript:void(0);\" class=\"linkbuttonsmall linkbuttongray radiusall displayblock\" id=click$woid><i class=\"fa fa-chevron-down\"></i></a>";
}
echo "</td></tr>";

echo "</table>";


echo "</td></tr></table>";

if (in_array("bprogresscounters", $statusoptions[$statusid])) {

$lasttoucharray = array();
$lasttoucharray[] = strtotime("$dropdate");


$rs_findrci = "SELECT addtime FROM repaircart WHERE pcwo = '$woid' ORDER BY addtime DESC";
$rs_result_rci = mysqli_query($rs_connect, $rs_findrci);
$totalrci = mysqli_num_rows($rs_result_rci);
if($totalrci > 0) {
while($rs_result_rciq = mysqli_fetch_object($rs_result_rci)) {
$recent_rci = "$rs_result_rciq->addtime";
break;
}
$rcistyle = lasttouch("$recent_rci");
$lasttoucharray[] = $recent_rci;
}


$rs_findwonote = "SELECT notetime FROM wonotes WHERE woid = '$woid' ORDER BY notetime DESC";
$rs_result_fwn = mysqli_query($rs_connect, $rs_findwonote);
$totalwon = mysqli_num_rows($rs_result_fwn);
if($totalwon > 0) {
while($rs_result_wonq = mysqli_fetch_object($rs_result_fwn)) {
$recent_won = "$rs_result_wonq->notetime";
break;
}
$wonstyle = lasttouch(strtotime("$recent_won"));
$lasttoucharray[] = strtotime("$recent_won");
}




$rs_findmsg = "SELECT messagedatetime FROM messages WHERE woid = '$woid' ORDER BY messagedatetime DESC";
$rs_result_msg = mysqli_query($rs_connect, $rs_findmsg);
$totalmsg = mysqli_num_rows($rs_result_msg);
if($totalmsg > 0) {
while($rs_result_msgq = mysqli_fetch_object($rs_result_msg)) {
$recent_msg = "$rs_result_msgq->messagedatetime";
break;
}
$msgstyle = lasttouch(strtotime("$recent_msg"));
$lasttoucharray[] = strtotime("$recent_msg");
}



$rs_sq = "SELECT * FROM mainassettypes WHERE mainassettypeid = '$mainassettypeidindb'";
$rs_result1 = mysqli_query($rs_connect, $rs_sq);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$mainassetchecksindb = serializedarraytest("$rs_result_q1->mainassetchecks");
if(count($mainassetchecksindb) > 0) {


$rs_findchecks = "SELECT wochecks,wocheckstime FROM pc_wo WHERE woid = '$woid'";
$rs_result_checks = mysqli_query($rs_connect, $rs_findchecks);
$rs_result_checksq = mysqli_fetch_object($rs_result_checks);
$totalwochecksser = "$rs_result_checksq->wochecks";
$totalwocheckstime = "$rs_result_checksq->wocheckstime";
$totalwochecks2 = serializedarraytest($totalwochecksser);

foreach(array_keys($totalwochecks2) as $key) {
   unset($totalwochecks2[$key][0]);
	if(count($totalwochecks2[$key]) == 0) {
   		unset($totalwochecks2[$key]);
	}
	if (array_key_exists("$key", $totalwochecks2)) {
        	if($totalwochecks2[$key][1] == 0) {
                	unset($totalwochecks2[$key]);
        	}
	}

}

$totalwochecks = count($totalwochecks2);
if($totalwochecks > 0) {
$wochecksstyle = lasttouch(strtotime("$totalwocheckstime"));
$lasttoucharray[] = strtotime("$totalwocheckstime");
}

}

if (getassettypeshowscans($mainassettypeidindb) != 0) {

$rs_findscan = "SELECT pc_scan.scantime FROM pc_scan,pc_scans WHERE pc_scan.woid = '$woid' AND pc_scan.scantype = pc_scans.scanid AND pc_scans.scantype = '0' ORDER BY scantime DESC";
$rs_result_fs = mysqli_query($rs_connect, $rs_findscan);
$totalscans0 = mysqli_num_rows($rs_result_fs);
if($totalscans0 > 0) {
while($rs_result_scans0q = mysqli_fetch_object($rs_result_fs)) {
$recent_scans0 = "$rs_result_scans0q->scantime";
break;
}
$scans0style = lasttouch(strtotime("$recent_scans0"));
$lasttoucharray[] = strtotime("$recent_scans0");
}



$rs_findscan = "SELECT pc_scan.scantime FROM pc_scan,pc_scans WHERE pc_scan.woid = '$woid' AND pc_scan.scantype = pc_scans.scanid AND pc_scans.scantype = '1' ORDER BY scantime DESC";
$rs_result_fs = mysqli_query($rs_connect, $rs_findscan);
$totalscans1 = mysqli_num_rows($rs_result_fs);
if($totalscans1 > 0) {
while($rs_result_scans1q = mysqli_fetch_object($rs_result_fs)) {
$recent_scans1 = "$rs_result_scans1q->scantime";
break;
}
$scans1style = lasttouch(strtotime("$recent_scans1"));
$lasttoucharray[] = strtotime("$recent_scans1");
}


$rs_findscan = "SELECT pc_scan.scantime FROM pc_scan,pc_scans WHERE pc_scan.woid = '$woid' AND pc_scan.scantype = pc_scans.scanid AND pc_scans.scantype = '2' ORDER BY scantime DESC";
$rs_result_fs = mysqli_query($rs_connect, $rs_findscan);
$totalscans2 = mysqli_num_rows($rs_result_fs);
if($totalscans2 > 0) {
while($rs_result_scans2q = mysqli_fetch_object($rs_result_fs)) {
$recent_scans2 = "$rs_result_scans2q->scantime";
break;
}
$scans2style = lasttouch(strtotime("$recent_scans2"));
$lasttoucharray[] = strtotime("$recent_scans2");
}


$rs_findscan = "SELECT pc_scan.scantime FROM pc_scan,pc_scans WHERE pc_scan.woid = '$woid' AND pc_scan.scantype = pc_scans.scanid AND pc_scans.scantype = '3' ORDER BY scantime DESC";
$rs_result_fs = mysqli_query($rs_connect, $rs_findscan);
$totalscans3 = mysqli_num_rows($rs_result_fs);
if($totalscans3 > 0) {
while($rs_result_scans3q = mysqli_fetch_object($rs_result_fs)) {
$recent_scans3 = "$rs_result_scans3q->scantime";
break;
}
$scans3style = lasttouch(strtotime("$recent_scans3"));
$lasttoucharray[] = strtotime("$recent_scans3");
}

}

$lasttouch = max($lasttoucharray);
$lasttouchstyle = lasttouch($lasttouch);

#echo "<table style=\"margin-right:auto;margin-left:auto;\"><tr><td style=\"width:100%;text-align:center\">";

echo "<div style=\"background:#f1f1f1;padding:7px;margin-bottom:10px;\" class=radiusbottom>";

echo "<span class=\"$lasttouchstyle boldme\" style=\"display:inline-block;width:50px\"><i class=\"fa fa-fingerprint fa-lg\"></i> ".elapsbrief(date("Y-m-d H:i:s", $lasttouch))."</span> &nbsp;&nbsp;";

if($totalrci > 0) {
echo "<i class=\"fa fa-shopping-cart fa-lg $rcistyle\"></i> <span class=\"$rcistyle\">$totalrci</span>";
} else {
echo "<i class=\"fa fa-shopping-cart fa-lg\" style=\"color:#999999\"></i> <span style=\"color:#999999\">0</span>";
}
echo "&nbsp;&nbsp;";


if($totalwon > 0) {
echo "<i class=\"fa fa-edit fa-lg $wonstyle\"></i> <span class=\"$wonstyle\">$totalwon</span>";
} else {
echo "<i class=\"fa fa-edit fa-lg\" style=\"color:#999999\"></i> <span style=\"color:#999999\">$totalwon</span>";
}
echo "&nbsp;&nbsp;";

if($totalmsg > 0) {
echo "<i class=\"fa fa-comments fa-lg $msgstyle\"></i> <span class=\"$msgstyle\">$totalmsg</span>";
} else {
echo "<i class=\"fa fa-comments fa-lg\" style=\"color:#999999\"></i> <span style=\"color:#999999\">$totalmsg</span>";
}
echo "&nbsp;&nbsp;";


if(count($mainassetchecksindb) > 0) {
if($totalwochecks > 0) {
echo "<i class=\"fa fa-check-circle fa-lg $wochecksstyle\"></i> <span class=\"$wochecksstyle\">$totalwochecks</span>";
} else {
echo "<i class=\"fa fa-check-circle fa-lg\" style=\"color:#999999\"></i> <span style=\"color:#999999\">$totalwochecks</span>";
}
echo "&nbsp;&nbsp;";
}


if (getassettypeshowscans($mainassettypeidindb) != 0) {

if($totalscans0 > 0) {
echo "<i class=\"fa fa-bug fa-lg $scans0style\"></i> <span class=\"$scans0style\">$totalscans0</span>";
} else {
echo "<i class=\"fa fa-bug fa-lg\" style=\"color:#999999\"></i> <span style=\"color:#999999\">$totalscans0</span>";
}
echo "&nbsp;&nbsp;";
if($totalscans1 > 0) {
echo "<i class=\"fa fa-wrench fa-lg $scans1style\"></i> <span class=\"$scans1style\">$totalscans1</span>";
} else {
echo "<i class=\"fa fa-wrench fa-lg\" style=\"color:#999999\"></i> <span style=\"color:#999999\">$totalscans1</span>";
}
echo "&nbsp;&nbsp;";
if($totalscans2 > 0) {
echo "<i class=\"fa fa-download fa-lg $scans2style\"></i> <span class=\"$scans2style\">$totalscans2</span>";
} else {
echo "<i class=\"fa fa-download fa-lg\" style=\"color:#999999\"></i> <span style=\"color:#999999\">$totalscans2</span>";
}
echo "&nbsp;&nbsp;";
if($totalscans3 > 0) {
echo "<i class=\"fa fa-pencil-alt fa-lg $scans3style\"></i> <span class=\"$scans3style\">$totalscans3</span>";
} else {
echo "<i class=\"fa fa-pencil-alt fa-lg\" style=\"color:#999999\"></i> <span style=\"color:#999999\">$totalscans3</span>";
}

}
echo "</div>";

#echo "</td></tr></table>";

#end progress counters
}


#echo "</td></tr></table>";




?>

<script type='text/javascript'>
$('#click<?php echo $woid; ?>').click(function(){
  $('#note<?php echo $woid; ?>').toggle('1000');
  $("i",this).toggleClass("fa-chevron-up fa-chevron-down");
});

</script>
<?php


#####



}
}
}

if ($statusid == 4) {
if ($totalworkorders > $theworkordercount) {
$remainingwo = $totalworkorders - $theworkordercount;
start_box();
echo "<center><a href=\"pc.php?func=checkoutpc\" class=\"linkbuttonmedium linkbuttonblack displayblock radiusall\">".pcrtlang("View All Ready For Pickup")."</a>";
echo "<span class=\"sizeme10 italme\">$remainingwo ".pcrtlang("work orders over 1 month old")."</span></center>";
stop_box();
}
} else {
if($totalworkordersoverall > $statusassetlimit) {
echo "<center><a href=\"pc.php?func=viewassetstatus&pcstatus=$statusid\" class=\"linkbuttonmedium linkbuttonblack displayblock radiusall\" 
style=\"background:#$boxstyle[selectorcolor];\">".pcrtlang("View All")." <i class=\"fa fa-arrow-circle-right fa-lg\"></i></a>";
echo "</center>";
}
}


stop_color_box();

echo "<br>";

#end non collapsed
} else {
start_color_altbox_collapsed("$statusid","$boxstyle[boxtitle]",$totalworkordersoverall);
echo "<br>";
}


}


#end status id while
}

?>

<script type='text/javascript'>
$(document).ready(function(){
$('.catchchangestatus').click(function(e) { // catch the form's submit event
        e.preventDefault();
		$('.ajaxspinner').toggle();
                var url = $(this).attr('href');
                $.get(url, function () {
                $.get('sidemenu.php', function(data) {
                $('#sidemenu').html(data);
		$('.ajaxspinner').toggle();
                });
        });
});
});
</script>


<?php



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
$rs_find_pc = "SELECT pc_wo.pcid, pc_wo.woid, pc_owner.pcname, pc_owner.pcemail, pc_owner.scid FROM pc_wo,pc_owner WHERE pc_wo.pcstatus ='5' AND pc_wo.pcid = pc_owner.pcid ORDER BY pc_wo.pickupdate DESC LIMIT $showrecentjobs";
$chktelog = "SELECT refid FROM userlog WHERE reftype = 'woid' AND actionid = '25' ORDER BY thedatetime DESC LIMIT $showrecentjobs2";
} else {
$rs_find_pc = "SELECT pc_wo.pcid, pc_wo.woid, pc_owner.pcname,pc_owner.pcemail, pc_owner.scid FROM pc_wo,pc_owner WHERE pc_wo.assigneduser = '$ipofpc' AND pc_wo.pcstatus ='5' AND pc_wo.pcid = pc_owner.pcid ORDER BY pc_wo.pickupdate DESC LIMIT $showrecentjobs";
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
$lang_TY = pcrtlang("Thank You Sent");
$lang_sendTY = pcrtlang("Send Thank You");

while($rs_result_item_q = mysqli_fetch_object($rs_result_item)) {
$pcid = "$rs_result_item_q->pcid";
$woid = "$rs_result_item_q->woid";
$pcowner = "$rs_result_item_q->pcname";
$pcemail = "$rs_result_item_q->pcemail";
$scid = "$rs_result_item_q->scid";


echo "<table class=badgeonwhite>";
echo "<tr><td style=\"width:25%\"><i class=\"fa fa-tag fa-lg fa-fw\"></i> $pcid<br><i class=\"fa fa-clipboard fa-lg fa-fw\"></i> $woid</td><td style=\"align:center;\"><span class=\"boldme\">$pcowner</span>";
if(in_array("$woid", $thankyouarray)) {
echo "<br><span class=colormegreen><i class=\"fa fa-check-circle fa-lg\" style=\"margin:3px;\"></i></span> $lang_TY";
} else {
if($pcemail != "") {
echo "<br> <a href=\"pc.php?func=emailthankyou&woid=$woid&email=$pcemail\" $therel class=\"linkbuttontiny linkbuttongray radiusall\" style=\"margin:3px;\"><i class=\"fa fa-exclamation-circle fa-lg colormered\"></i> $lang_sendTY</a>";
}
}



$rs_find_invoices = "SELECT * FROM invoices WHERE (woid LIKE '%_$woid"."_%' OR woid = '$woid') AND iorq = 'invoice' AND invstatus < '3'";
$rs_resultinv = mysqli_query($rs_connect, $rs_find_invoices);
if(mysqli_num_rows($rs_resultinv) > 0) {
echo "<br>";
while($rs_result_qinv = mysqli_fetch_object($rs_resultinv)) {
$invoice_id = "$rs_result_qinv->invoice_id";

$findinvtotal = "SELECT SUM(cart_price) AS invsubtotal, SUM(itemtax) AS invtax FROM invoice_items WHERE invoice_id = '$invoice_id'";
$findinvq = @mysqli_query($rs_connect, $findinvtotal);
$findinva = mysqli_fetch_object($findinvq);
$invtax = "$findinva->invtax";
$invsubtotal = "$findinva->invsubtotal";
$invoicegrandtotal = $invtax + $invsubtotal;

echo " <a href=../store/invoice.php?func=printinv&invoice_id=$invoice_id class=\"linkbuttontiny linkbuttoninv radiusall\" style=\"margin:3px;\">
<i class=\"fa fa-file-invoice\" style=\"margin:3px;\"></i> $money".mf($invoicegrandtotal)."</a> ";
}
}



$rs_find_cart_items = "SELECT * FROM receipts WHERE (woid LIKE '%_$woid"."_%' OR woid = '$woid')";
$rs_resultrec = mysqli_query($rs_connect, $rs_find_cart_items);
if(mysqli_num_rows($rs_resultrec) > 0) {
echo "<br>";
while($rs_result_q = mysqli_fetch_object($rs_resultrec)) {
$rs_receipt_id = "$rs_result_q->receipt_id";
$rs_gt = "$rs_result_q->grandtotal";
echo " <a href=../store/receipt.php?func=show_receipt&receipt=$rs_receipt_id class=\"linkbuttontiny linkbuttonmoney radiusall\" style=\"margin:3px;\">
<i class=\"fa fa-receipt\" style=\"margin:3px;\"></i> $money".mf($rs_gt)."</a> ";
}
}


if ($scid != "0") {

$rs_scn = "SELECT * FROM servicecontracts WHERE scid = '$scid'";
$rs_resultscn = mysqli_query($rs_connect, $rs_scn);
$rs_result_scn = mysqli_fetch_object($rs_resultscn);
$scname = "$rs_result_scn->scname";

echo "<a href=\"msp.php?func=viewservicecontract&scid=$scid\" class=\"linkbuttontiny linkbuttonblack radiusall\" style=\"margin:3px;\">";
echo "<img src=images/contract.png class=icontiny> $scname</a>";

}


echo "</td>";
echo "<td style=\"width:30px;text-align:center;padding:0px;\"><a href=\"index.php?pcwo=$woid\" class=\"linkbuttonmedium linkbuttonopaque2 radiusall\" style=\"background:#000000;\"><i class=\"fa fa-chevron-right\"></i></a></td>";
echo "</tr></table>";
}


echo "<a href=\"workorders.php\" class=\"linkbuttonmedium linkbuttonopaque2 radiusall\" style=\"background:#000000;text-align:center;\" >".pcrtlang("More")." <i class=\"fa fa-chevron-right fa-lg\"></i></a>";

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

function elapsbrief($dropdate) {
require("deps.php");
if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}

$thenum = strtotime($dropdate);
$thediff = time() - $thenum;
if($thediff > 2592000) {
$daydiff = number_format($thediff / 2592000,0)."".pcrtlang("M");
} elseif($thediff > 604800) {
$daydiff = number_format($thediff / 604800,0)."".pcrtlang("w");
} elseif($thediff > 86400) {
$daydiff = number_format($thediff / 84600,0)."".pcrtlang("d");
} elseif($thediff > 3600) {
$daydiff = number_format($thediff / 3600,0)."".pcrtlang("h");
} else {
$daydiff = number_format($thediff / 60,0)."".pcrtlang("m");
}
return "$daydiff";
}

function elapsfriendly($dropdate) {
require("deps.php");
if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$thenum = strtotime($dropdate);
$thediff = time() - $thenum;
if($thediff > 259200) {
$daydiff = number_format($thediff / 86400,0)." ".pcrtlang("days ago");
} elseif($thediff > 97200) {
$daydiff = number_format($thediff / 86400,1)." ".pcrtlang("days ago");
} elseif($thediff > 79200) {
$daydiff = number_format($thediff / 86400,1)." ".pcrtlang("a day ago");
} elseif($thediff > 4800) {
$daydiff = number_format($thediff / 7200,0)." ".pcrtlang("hours ago");
} elseif($thediff > 4800) {
$daydiff = number_format($thediff / 3600,1)." ".pcrtlang("hours ago");
} elseif($thediff > 2400)  {
$daydiff = pcrtlang("an hour ago");
} elseif($thediff > 1200)  {
$daydiff = pcrtlang("half hour ago");
} elseif($thediff > 420)  {
$daydiff = pcrtlang("about 15 minutes ago");
} elseif($thediff > 300)  {
$daydiff = pcrtlang("several minutes ago");
} else {
$daydiff = pcrtlang("a moment ago");
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

function dv($value) {
$value2 = trim($value);
return htmlspecialchars("$value2", ENT_QUOTES);
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
"38" => pcrtlang("Manage Service Promises"),
"39" => pcrtlang("Manage Discounts"),
"40" => pcrtlang("Manage Form Templates"),
"41" => pcrtlang("Access Ledger"),
"42" => pcrtlang("Create New Ledgers"),
"43" => pcrtlang("Manage Invoice Terms")
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
"35" => pcrtlang("Printed Service Reminder"),
"36" => pcrtlang("Added a Special Order Part"),
"37" => pcrtlang("Assigned Work Order")
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
                    $output .= "<a href='$new_url' class=\"linkbuttonmedium linkbuttongray radiusall\">$i</a> ";
                }
                else
                    $output .= '. ';
        }
        else
        {
            // This is the page we're looking at.
            $output .= "<span class=\"linkbuttonmedium linkbuttongraylabel radiusall\">$i</span> ";
        }
    }

    // Remove extra dots from the list of pages, allowing it to be shortened.
#    $output = ereg_replace('(\. ){2,}', ' .. ', $output);
 $output = preg_replace('#(\. ){2,}#', ' .. ', $output); 
   // Determine whether to show the HTML, or just return it.
    if($show) echo $output;

    return($output);
}




if(isset($ipofpc)) {

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

}


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


$interfacecolor1 = "$bgcolor1;";
$interfacecolor2 = "$bgcolor2;";

$linestyle = "background: #$linecolor2;
background: linear-gradient(to bottom, #$linecolor1 0%,#$linecolor2 100%);";


$storeinfo = array("storesname" => "$storesname", "storename" => "$storename", "storeaddy1" => "$storeaddy1", "storeaddy2" => "$storeaddy2", "storecity" => "$storecity", "storestate" => "$storestate", "storezip" => "$storezip", "storeemail" => "$storeemail", "storephone" => "$storephone", "quotefooter" => "$quotefooter", "invoicefooter" => "$invoicefooter", "repairsheetfooter" => "$repairsheetfooter", "returnpolicy" => "$returnpolicy", "depositfooter" => "$depositfooter", "thankyouletter" => "$thankyouletter", "claimticket" => "$claimticket", "checkoutreceipt" => "$checkoutreceipt", "interfacecolor1" => "$interfacecolor1", "interfacecolor2" => "$interfacecolor2", "linestyle" => "$linestyle", "storehash" => "$storehash","storeccemail" => "$storeccemail");
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





function pcrtnotifynew() {
require("deps.php");
require_once("validate.php");

$pcrtnotify2 = "";
$pcrtnotify3 = "";
$pcrtnotify = "";


$rs_qlm = "SELECT lastmessage,defaultstore,notifytime,userid FROM users WHERE username = '$ipofpc'";
$rs_result1m = mysqli_query($rs_connect, $rs_qlm);
$rs_result_qm1 = mysqli_fetch_object($rs_result1m);
$lastmessage = "$rs_result_qm1->lastmessage";
$notifytime = "$rs_result_qm1->notifytime";
$notifytimestamp = strtotime($notifytime);
$defaultuserstore = "$rs_result_qm1->defaultstore";
$userid = "$rs_result_qm1->userid";

$rs_findmessages2 = "SELECT * FROM messages WHERE messagedirection = 'in' ORDER BY messagedatetime DESC LIMIT 1";
$rs_result_n2 = mysqli_query($rs_connect, $rs_findmessages2);


$totalready = mysqli_num_rows($rs_result_n2);

if($totalready != 0) {
$rs_result_qn2 = mysqli_fetch_object($rs_result_n2);
$recentmessagetime2 = "$rs_result_qn2->messagedatetime";
$recentmessagetimestamp = strtotime($recentmessagetime2);
$messageid = "$rs_result_qn2->messageid";
$recentmessagetime = elapsbrief("$recentmessagetime2");
$howold =  strtotime($recentmessagetime2);

if(((time() - $howold) < 604800) && ($recentmessagetimestamp > $notifytimestamp)) { 

$thebubble = "<table class=standard><tr><td>";

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = urlencode(date('Y-m-d H:i:s'));


$thebubble .= "<form id=markread method=post action=\"../repair/messages.php?func=markread&datetime=$currentdatetime\">";
$thebubble .= "<button class=\"button\"><i class=\"fa fa-eraser fa-lg\"></i> ".pcrtlang("Clear Notification")."</button><div id=loader></div></form>";

?>

<script>
$(document).ready(function(){
        $(function(){
        $('#markread').submit(function(e){
                e.preventDefault();
                var form = $(this);
                var post_url = form.attr('action');
                var post_data = form.serialize();
                $('#loader', form).html('Please wait...');
                $.ajax({
                    type: 'POST',
                    url: post_url,
                    data: post_data,
                    success: function(msg) {
                        $(form).fadeOut(100, function(){
                            form.html(msg).fadeIn().delay(200);
			 });
			$.get('../repair/ajaxhelpers.php?func=refreshnotifications', function(data) {
                	$('#notify').html(data);
                        });
                    }
                });
            });
        });
         });

</script>

<?php

$thebubble .= "<td><p class=\"sizemelarge\">".pcrtlang("Recent Incoming Messages")."</p></td>";


$thebubble .= "<td></td></tr>";

$rs_findmessages = "SELECT * FROM messages WHERE messagedirection = 'in' ORDER BY messagedatetime DESC LIMIT 15";
$rs_result_n = mysqli_query($rs_connect, $rs_findmessages);
while($rs_result_qn = mysqli_fetch_object($rs_result_n)) {
$messageid = "$rs_result_qn->messageid";
$messagebody = "$rs_result_qn->messagebody";
$messagefrom = "$rs_result_qn->messagefrom";
$messagedatetime = "$rs_result_qn->messagedatetime";

if(strlen($messagebody) > 150) {
$messagebody = substr("$messagebody", 0, 150)."...";
}


$messagebody = wordwrap($messagebody, 60, "<br />\n", true);

$res_str = array_chunk(explode(" ",$messagebody),9);
foreach( $res_str as &$val){
   $val  = implode(" ",$val);
}
#$messagebody = implode("<br>",$res_str);


$thebubble .= "<tr><td>$messagefrom</td><td style=\"text-align:left;\">$messagebody</td><td>".elaps("$messagedatetime")." ".pcrtlang("ago")."</td></tr>";
}
$thebubble .= "</table>";

$pcrtnotify .= "<a href=../repair/messages.php?func=browsemessages class=\"notifybadge tooltip\" data-badge=\"$recentmessagetime\">
<i class=\"fa fa-mobile faa-tada animated fa-2x\"></i><span>$thebubble</span></a>";

if($messageid > $lastmessage) {
$pcrtnotify .= "
<script>\n
sound.play();\n
</script>\n
";
$resetlm = "UPDATE users SET lastmessage = '$messageid' WHERE username = '$ipofpc'";
@mysqli_query($rs_connect, $resetlm);
}


}
}

##
$countunread = "SELECT imessageid FROM imessages WHERE imessageinvolves LIKE '%\_$userid\_%' AND imessagereadby NOT LIKE '%\_$userid\_%'";
$rs_curesult = mysqli_query($rs_connect, $countunread);
$totalunread = mysqli_num_rows($rs_curesult);
if($totalunread > 0) {
$pcrtnotify .= "<a href=../repair/imessages.php?func=browsemessages class=\"notifybadge tooltip\" data-badge=\"$totalunread\"><i class=\"fa fa-comments-o faa-tada animated fa-2x\"></i><span>".pcrtlang("You have unread messages.")."</span></a>";
}

##



if (perm_check("14")) {
$findrinvsql = "SELECT * FROM rinvoices WHERE reinvoicedate < NOW() AND invactive = '1'";
$findrinvq = @mysqli_query($rs_connect, $findrinvsql);
$totalready = mysqli_num_rows($findrinvq);
if($totalready > 0) {
$pcrtnotify .= "<a href=../store/rinvoice.php?func=runinvoices class=\"notifybadge tooltip\" data-badge=\"$totalready\"><i class=\"fa fa-file-text faa-tada animated fa-2x\"></i><span>".pcrtlang("Recurring Invoices are ready to be created.")."</span></a>";
}
}

if (perm_check("17")) {
$findsrsql = "SELECT * FROM servicereminders WHERE srdate < NOW() AND srsent != '1'";
$findsrq = @mysqli_query($rs_connect, $findsrsql);
$totalsr = mysqli_num_rows($findsrq);
if($totalsr > 0) {
$pcrtnotify .= "<a href=../repair/servicereminder.php?func=runsr class=\"notifybadge tooltip\" data-badge=\"$totalsr\"><i class=\"fa fa-bell faa-ring animated fa-2x\"></i><span>".pcrtlang("Service Reminders are ready to be sent.")."</span></a>";
}
}

if (perm_check("28")) {
$findrwosql = "SELECT * FROM rwo WHERE rwodate < NOW()";
$findrwoq = @mysqli_query($rs_connect, $findrwosql);
$totalrwo = mysqli_num_rows($findrwoq);
if($totalrwo > 0) {
$pcrtnotify .= "<a href=../repair/rwo.php?func=runrwo class=\"notifybadge tooltip\" data-badge=\"$totalrwo\"><i class=\"fa fa-clipboard faa-tada animated fa-2x\"></i><span>".pcrtlang("Recurring Work Orders are due.")."</span></a>";
}
}



$findsreqsql = "SELECT * FROM servicerequests WHERE sreq_processed = '0'";
$findsreqq = @mysqli_query($rs_connect, $findsreqsql);
$totalsreq = mysqli_num_rows($findsreqq);
if($totalsreq > 0) {
$pcrtnotify .= "<a href=../repair/servicerequests.php?func=runsreq class=\"notifybadge tooltip\" data-badge=\"$totalsreq\"><i class=\"fa fa-comment faa-tada animated fa-2x\"></i><span>".pcrtlang("Service Requests are pending.")."</span></a>";
}


$findsosql = "SELECT * FROM specialorders WHERE spoopenclosed = '0' AND spostoreid = '$defaultuserstore' AND (spostatus = '7' OR spostatus = '8')";
$findsoq = @mysqli_query($rs_connect, $findsosql);
$totalso = mysqli_num_rows($findsoq);
if($totalso > 0) {
$pcrtnotify .= "<a href=../store/stock.php?func=specialorders class=\"notifybadge tooltip\" data-badge=\"$totalso\"><i class=\"fa fa-truck faa-passing-reverse animated fa-2x\"></i><span>".pcrtlang("Special Orders items need to be ordered.")."</span></a>";
}



if (isset($d7_report_upload_directory)) {
if (file_exists($d7_report_upload_directory)) {
$filesd7 = scandir($d7_report_upload_directory);
function validate_file3($v_filename) {
   return preg_match('/^[a-z0-9_ -\.]+\.(pdf|html|htm|txt|rtf|csv|gz|tar|zip)$/i', $v_filename) ? '1' : '0';
}

foreach($filesd7 as $key => $val) {
if (validate_file3($val) == '1') {
$filesd7_2[] = $val;
}
}

reset($filesd7);

if(isset($filesd7_2)) {
$d7count = count($filesd7_2);
} else {
$d7count = 0;
}

foreach($filesd7 as $key => $val) {
if (validate_file3($val) == '1') {
$pcrtnotify .= "<a href=../repair/d7.php class=\"notifybadge tooltip\" data-badge=\"$d7count\"><img src=../repair/images/d7.png class=\"faa-tada animated\"><span>&nbsp;&nbsp;&nbsp;".pcrtlang("d7 Reports are ready")."&nbsp;&nbsp;&nbsp;</span></a>";
break;
}
}
}
}


if (isset($uvk_report_upload_directory)) {
if (file_exists($uvk_report_upload_directory)) {
$filesuvk = scandir($uvk_report_upload_directory);
function validate_file3uvk($v_filename) {
   return preg_match('/^[a-z0-9_ -\.]+\.(pdf|html|htm|txt|rtf|csv|gz|tar|zip)$/i', $v_filename) ? '1' : '0';
}

foreach($filesuvk as $key => $val) {
if (validate_file3uvk($val) == '1') {
$filesuvk_2[] = $val;
}
}

reset($filesuvk);

if(isset($filesuvk_2)) {
$uvkcount = count($filesuvk_2);
} else {
$uvkcount = 0;
}


foreach($filesuvk as $key => $val) {
if (validate_file3uvk($val) == '1') {
$pcrtnotify .= "<a href=../repair/uvk.php class=\"notifybadge tooltip\" data-badge=\"$uvkcount\"><img src=../repair/images/uvk.png class=\"faa-tada animated\"><span>&nbsp;&nbsp;&nbsp;".pcrtlang("UVK Reports are ready.")."&nbsp;&nbsp;&nbsp;</span></a>";
break;
}
}
}
}


if (perm_check("29")) {
if(isset($dropboxaccessToken)) {
$lastbackupq = "SELECT lastbackup FROM stores WHERE storedefault = '1' AND lastbackup < (DATE_SUB(NOW(),INTERVAL 22 HOUR))";
$findlb = @mysqli_query($rs_connect, $lastbackupq);
$totallb = mysqli_num_rows($findlb);
if(($totallb > 0) && ($dropboxaccessToken != "")) {
$rs_findlb_q1 = mysqli_fetch_object($findlb);
$lastbackup = "$rs_findlb_q1->lastbackup";
$lastbackup2 = elapsbrief("$lastbackup");
if((time() - strtotime($lastbackup)) > 604800) {
$dbcolor = "red";
$dbanimate = "faa-flash";
} else {
$dbcolor = "blue";
$dbanimate = "faa-tada";
}
$pcrtnotify .= "<a href=../repair/dropboxbackup.php class=\"notifybadge tooltip\" data-badge=\"$lastbackup2\"><i class=\"fa fa-dropbox $dbanimate animated fa-2x\" style=\"color:$dbcolor\"></i><span> ".pcrtlang("Last Backup").": ".elaps($lastbackup)."</span></a>";
}
}
}

if (perm_check("6")) {
$rs_ql = "SELECT defaultstore FROM users WHERE username = '$ipofpc'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$defaultuserstore = "$rs_result_q1->defaultstore";
$findrecountsql = "SELECT * FROM stockcounts WHERE reqcount = '1' AND storeid = '$defaultuserstore'";
$findrecountq = @mysqli_query($rs_connect, $findrecountsql);
$totalsrecount2 = mysqli_num_rows($findrecountq);
if($totalsrecount2 > 0) {
$pcrtnotify .= "<a href=../store/categories.php?func=stockrecount class=\"notifybadge tooltip\" data-badge=\"$totalsrecount2\">
<i class=\"fa fa-cubes faa-tada animated fa-2x\"></i><span>".pcrtlang("Inventory Recount Requested.")."</span></a>";
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
echo "<select name=$selectname class=selecttimepicker>";
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

function implode_list_sorted($value) {
if(is_array($value)) {
sort($value, SORT_NUMERIC);
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
return array($value);
} else {
return array_filter(explode("_", $value));
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
$rs_invoices = "SELECT * FROM invoices WHERE iorq != 'quote' AND duedate < (NOW()) AND invstatus = '1' AND rinvoice_id = '$rinvoice_id'";
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

$invoicetotalidarray = array();

require("deps.php");

$invoicetotalids = "(SELECT DISTINCT(invoices.invoice_id) FROM invoices, pc_wo, pc_owner WHERE pc_owner.pcgroupid = '$pcgroupid' AND pc_owner.pcid = pc_wo.pcid
AND invoices.iorq != 'quote' AND invoices.invstatus = '$invstatus' AND (pc_wo.woid = invoices.woid OR invoices.woid LIKE CONCAT('%\_',pc_wo.woid,'\_%')))
UNION (SELECT invoices.invoice_id FROM invoices,rinvoices WHERE invoices.rinvoice_id = rinvoices.rinvoice_id AND rinvoices.pcgroupid = '$pcgroupid'
AND invoices.invstatus = '$invstatus')
UNION (SELECT invoice_id FROM invoices WHERE pcgroupid = '$pcgroupid' AND invoices.invstatus = '$invstatus')";

$rs_resultit = mysqli_query($rs_connect, $invoicetotalids);
while($rs_result_it = mysqli_fetch_object($rs_resultit)) {
$invoicetotalidarray[] = "$rs_result_it->invoice_id";
}

foreach($invoicetotalidarray as $key => $iids) {
$findinvtotal = "SELECT SUM(cart_price) AS invsubtotal, SUM(itemtax) AS invtax FROM invoice_items WHERE invoice_id = '$iids'";
$findinvq = @mysqli_query($rs_connect, $findinvtotal);
$findinva = mysqli_fetch_object($findinvq);
$invtax = "$findinva->invtax";
$invsubtotal = "$findinva->invsubtotal";
$invoicegrandtotal = $invtax + $invsubtotal + $invoicegrandtotal;
}


return mf($invoicegrandtotal);

}



function getfileicon($ext) {
if($ext == "zip") {
$icon = "<i class=\"fa fa-file-archive-o fa-lg\"></i>";
} elseif($ext == "doc") {
$icon = "<i class=\"fa fa-file-text-o fa-lg\"></i>";
} elseif($ext == "txt") {
$icon = "<i class=\"fa fa-file-archive-o fa-lg\"></i>";
} elseif($ext == "docx") {
$icon = "<i class=\"fa fa-file-word-o fa-lg\"></i>";
} elseif(($ext == "xls") || ($ext == "xlsx")) {
$icon = "<i class=\"fa fa-file-excel-o fa-lg\"></i>";
} elseif(($ext == "ppt") || ($ext == "pptx")) {
$icon = "<i class=\"fa fa-file-powerpoint-o fa-lg\"></i>";
} elseif($ext == "pdf") {
$icon = "<i class=\"fa fa-file-pdf-o fa-lg\"></i>";
} elseif(($ext == "mp3") || ($ext == "ogg") || ($ext == "wav") || ($ext == "wma")) {
$icon = "<i class=\"fa fa-file-audio-o fa-lg\"></i>";
} elseif(($ext == "mp4") || ($ext == "ogv") || ($ext == "flv") || ($ext == "wmv") || ($ext == "mov")) {
$icon = "<i class=\"fa fa-file-video-o fa-lg\"></i>";
} elseif(($ext == "gif") || ($ext == "jpg") || ($ext == "jpeg") || ($ext == "png") || ($ext == "bmp")) {
$icon = "<i class=\"fa fa-file-image-o fa-lg\"></i>";
} elseif($ext == "url") {
$icon = "<i class=\"fa fa-external-link fa-lg\"></i>";

} else {
$icon = "<i class=\"fa fa-file-o fa-lg\"></i>";
}

return $icon;
}


function getcurrentregister() {
if (array_key_exists("registerid", $_COOKIE)) {
$registerid = $_COOKIE['registerid'];
} else {
$registerid = 0;
}
return $registerid;
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
echo "<link rel=\"stylesheet\" href=\"fa5/css/all.min.css\">";
echo "<link rel=\"stylesheet\" href=\"fa5/css/v4-shims.min.css\">";
echo "<link rel=\"stylesheet\" href=\"fa5/font-awesome-animation.min.css\">";

if (preg_match("/printform/i", $_SERVER['REQUEST_URI'])) {
require("signatureincludes.php");
}


echo "</head>";


if($autoprint == 1) {
echo "<body class=printpagebg onLoad=\"window.print()\">";
} else {
echo "<body class=printpagebg>";
}
echo "<div class=printbar>";
echo "<button onClick=\"window.history.back()\" class=bigbutton><img src=images/left.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Return")."</button>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<button onClick=\"print();\" class=bigbutton><img src=images/print.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Print")."</button>";
echo "</div>";
echo "<div class=printpage>";

}



function printablefooter() {
echo "</div>";
echo "</body></html>";
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


function groupbyinvoice($invoice_id) {
require("deps.php");
$rs_invoicest = "(SELECT pc_owner.pcgroupid AS groupid FROM invoices, pc_wo, pc_owner WHERE  pc_owner.pcid = pc_wo.pcid AND pc_owner.pcgroupid != '0'
AND invoices.invoice_id = '$invoice_id' AND (pc_wo.woid = invoices.woid OR invoices.woid LIKE CONCAT('%\_',pc_wo.woid,'\_%')))
UNION (SELECT rinvoices.pcgroupid AS groupid FROM invoices,rinvoices WHERE invoices.rinvoice_id = rinvoices.rinvoice_id
AND invoices.rinvoice_id = '$invoice_id' AND rinvoices.pcgroupid != '0')
UNION (SELECT pcgroupid AS groupid FROM invoices WHERE invoice_id = '$invoice_id' AND pcgroupid != '0')
UNION (SELECT DISTINCT(blockcontract.pcgroupid) AS groupid
FROM invoices,blockcontracthours,blockcontract WHERE blockcontracthours.invoiceid = '$invoice_id'
AND  blockcontract.blockid = blockcontracthours.blockcontractid AND blockcontract.pcgroupid != '0') LIMIT 1";


$findgroupmatch = @mysqli_query($rs_connect, $rs_invoicest);
$totalmatch1 = mysqli_num_rows($findgroupmatch);
if($totalmatch1 != 0) {
$findgroupmatchobj = mysqli_fetch_object($findgroupmatch);
$groupid = "$findgroupmatchobj->groupid";
} else {
$groupid = 0;
}
return $groupid;
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
	echo "<img src=images/tags/".$tagdata[$tagval]['tagicon']." width=\"$size\"> ";
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


function time2hourcount($time) {
    $d = floor($time/86400);
    $_d = ($d < 10 ? '0' : '').$d;

    $h = floor(($time-$d*86400)/3600);
    $_h = ($h < 10 ? '0' : '').$h;

    $m = floor(($time-($d*86400+$h*3600))/60);
    $_m = ($m < 10 ? '0' : '').$m;

    $s = $time-($d*86400+$h*3600+$m*60);
    $_s = ($s < 10 ? '0' : '').$s;

    $time_str = $_d.':'.$_h.':'.$_m;

    return $time_str;
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


if($exacttime < time()) {
$icon = "<i class=\"fa fa-stopwatch fa-2x menuicon2x $animated colormelevel4\"></i>";
if ($label == "label") {
$icon .= "<span class=\"sizemelarger boldme colormelevel4\"> ".pcrtlang("Overdue")."</span>";
}

} elseif($day == date('Y-m-d')) {
$icon = "<i class=\"fa fa-stopwatch fa-2x menuicon2x $animated colormelevel3\"></i>";
if ($label == "label") {
$icon .= "<span class=\"sizemelarger boldme colormelevel3\"> ".pcrtlang("Today")."</span>";
}
} elseif ($day == $daytomorrow) {
$icon = "<i class=\"fa fa-stopwatch fa-2x menuicon2x colormelevel2\"></i>";
if ($label == "label") {
$icon .= "<span class=\"sizemelarger boldme colormelevel2\"> ".pcrtlang("Tomorrow")."</span>";
}
} elseif ($timenewtoendofweek < 604800) {
$icon = "<i class=\"fa fa-stopwatch fa-2x menuicon2x colormelevel1\"></i>";
if ($label == "label") {
$icon .= "<span class=\"sizemelarger boldme colormelevel1\"> ".pcrtlang("Soon")."</span>";
}
} else {
$icon = "";
}

return "$icon";

}



function lasttouch($time) {
require("deps.php");
if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}

if((time() - $time) < 3600) {
$style = "colormelevel1";
} elseif((time() - $time) < 14400) {
$style = "colormelevel2";
} elseif((time() - $time) < 28800) {
$style = "colormelevel3";
} else {
$style = "colormelevel4";
}

return $style;
}



function findsmsname($number) {

require("deps.php");

if($number != "") {
$number = preg_replace('/\D+/', '', $number);

$numberstosearch = "";
$numberstosearch .= " OR  TRIM(REPLACE(REPLACE(pcphone,'-',''),' ',''))  LIKE '%".substr("$number", -7)."'";
$numberstosearch .= " OR pcphone LIKE '%".substr("$number", -7)."'";
$numberstosearch .= " OR  TRIM(REPLACE(REPLACE(pccellphone,'-',''),' ',''))  LIKE '%".substr("$number", -7)."'";
$numberstosearch .= " OR pccellphone LIKE '%".substr("$number", -7)."'";
$numberstosearch .= " OR  TRIM(REPLACE(REPLACE(pcworkphone,'-',''),' ',''))  LIKE '%".substr("$number", -7)."'";
$numberstosearch .= " OR pcworkphone LIKE '%".substr("$number", -7)."'";

$rs_findpc = "SELECT * FROM pc_owner WHERE 1=2 $numberstosearch ORDER BY pcid DESC LIMIT 1";
$rs_resultpc2 = mysqli_query($rs_connect, $rs_findpc);
if(mysqli_num_rows($rs_resultpc2) != 0) {
$rs_resultpc_q2 = mysqli_fetch_object($rs_resultpc2);
$pcname = "$rs_resultpc_q2->pcname";
} 

$numberstosearchg = "";
$numberstosearchg .= " OR  TRIM(REPLACE(REPLACE(grpphone,'-',''),' ',''))  LIKE '%".substr("$number", -7)."'";
$numberstosearchg .= " OR grpphone LIKE '%".substr("$number", -7)."'";
$numberstosearchg .= " OR  TRIM(REPLACE(REPLACE(grpcellphone,'-',''),' ',''))  LIKE '%".substr("$number", -7)."'";
$numberstosearchg .= " OR grpcellphone LIKE '%".substr("$number", -7)."'";
$numberstosearchg .= " OR  TRIM(REPLACE(REPLACE(grpworkphone,'-',''),' ',''))  LIKE '%".substr("$number", -7)."'";
$numberstosearchg .= " OR grpworkphone LIKE '%".substr("$number", -7)."'";

$rs_findg = "SELECT * FROM pc_group WHERE 1=2 $numberstosearchg ORDER BY pcgroupid DESC LIMIT 1";
$rs_resultg2 = mysqli_query($rs_connect, $rs_findg);
if(mysqli_num_rows($rs_resultg2) != 0) {
$rs_resultg_q2 = mysqli_fetch_object($rs_resultg2);
$groupname = "$rs_resultg_q2->pcgroupname";
}

if(isset($pcname)) {
return $pcname;
} elseif (isset($groupname)) {
return $groupname;
} else {
return "";
}

} else {
return "SMS";
}
}




function findopenworkorder($number) {

require("deps.php");

if($number != "") {
$number = preg_replace('/\D+/', '', $number);

$numberstosearch = "";
$numberstosearch .= " OR  TRIM(REPLACE(REPLACE(pcphone,'-',''),' ',''))  LIKE '%".substr("$number", -7)."'";
$numberstosearch .= " OR pcphone LIKE '%".substr("$number", -7)."'";
$numberstosearch .= " OR  TRIM(REPLACE(REPLACE(pccellphone,'-',''),' ',''))  LIKE '%".substr("$number", -7)."'";
$numberstosearch .= " OR pccellphone LIKE '%".substr("$number", -7)."'";
$numberstosearch .= " OR  TRIM(REPLACE(REPLACE(pcworkphone,'-',''),' ',''))  LIKE '%".substr("$number", -7)."'";
$numberstosearch .= " OR pcworkphone LIKE '%".substr("$number", -7)."'";

$rs_findpc = "SELECT * FROM pc_owner WHERE 1=2 $numberstosearch";
$rs_resultpc2 = mysqli_query($rs_connect, $rs_findpc);
if(mysqli_num_rows($rs_resultpc2) != 0) {
while($rs_resultpc_q2 = mysqli_fetch_object($rs_resultpc2)) {
$pcid = "$rs_resultpc_q2->pcid";

$rs_findwo = "SELECT * FROM pc_wo WHERE pcid =  '$pcid' ORDER BY dropdate DESC";
$rs_resultwo2 = mysqli_query($rs_connect, $rs_findwo);
if(mysqli_num_rows($rs_resultwo2) != 0) {
$holder = array();
while($rs_resultpc_q2 = mysqli_fetch_object($rs_resultpc2)) {
$woid = "$rs_resultpc_q2->woid";
$dropdate = "$rs_resultpc_q2->dropdate";
$dropdate2 = strtotime("$dropdate");
$holder[$dropdate2] = $woid;
}
}
}
}

}

if(isset($holder)) {
$maxtime = max(array_keys($holder));
$woid = $holder['$maxtime'];
} else {
$woid = "";
}

return $woid;


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


