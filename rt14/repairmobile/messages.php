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
echo "nothing";
}

function browsemessages() {

require("deps.php");
require_once("common.php");

if (array_key_exists('phonenumbers',$_REQUEST)) {
$phonenumbers2 = $_REQUEST['phonenumbers'];
$phnumbers = explode_list($phonenumbers2);
} else {
$phnumbers = array();
$phonenumbers2 = "";
}

if (array_key_exists('emails',$_REQUEST)) {
$emails2 = $_REQUEST['emails'];
$emailsexploded = explode_list_email($emails2);
} else {
$emailsexploded = array();
}

foreach ($phnumbers as $key=>&$value) {
    if (strlen($value) < 7) {
        unset($phnumbers[$key]);
    }
}

reset($phnumbers);

if (array_key_exists('woid',$_REQUEST)) {
$woid = $_REQUEST['woid'];
} else {
$woid = "0";
}

if (array_key_exists('searchworkorders',$_REQUEST)) {
$searchworkorders2 = $_REQUEST['searchworkorders'];
$searchworkorders = explode_list($searchworkorders2);
} else {
$searchworkorders = array();
$searchworkorders2 = "";
}

if (array_key_exists('groupid',$_REQUEST)) {
$groupid = $_REQUEST['groupid'];
} else {
$groupid = "0";
}

if (array_key_exists('pcid',$_REQUEST)) {
$pcid = $_REQUEST['pcid'];
} else {
$pcid = "0";
}


if (array_key_exists("pageNumber", $_REQUEST)) {
$pageNumber = $_REQUEST['pageNumber'];
} else {
$pageNumber = 1;
}


$results_per_page = 40;

if ($pageNumber == "") {
$offset = "0";
} else {
$offset = ($pageNumber * $results_per_page) - $results_per_page;
}


require("header.php");

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

$numberstosearch = "";

foreach($phnumbers as $key => $val) {
$numberstosearch .= " OR messagefrom LIKE '%".substr("$val", -7)."'";
}

if($woid != 0) {
$numberstosearch .= " OR woid = '$woid'";
}

foreach($searchworkorders as $key => $val) {
$numberstosearch .= " OR woid = '$val'";
}

foreach($emailsexploded as $key => $val) {
if (filter_var($val, FILTER_VALIDATE_EMAIL)) {
$numberstosearch .= " OR messagefrom = '$val'";
}
}


if($numberstosearch == "") {
$whereclause = "1=1";
} else {
$whereclause = "1=2";
}

$rs_find_message_items_total = "SELECT * FROM messages WHERE $whereclause $numberstosearch ORDER BY messagedatetime DESC";
$rs_result_total = mysqli_query($rs_connect, $rs_find_message_items_total);


$totalentries = mysqli_num_rows($rs_result_total);
$lastpage = $totalentries / $results_per_page;
if($lastpage != floor($lastpage)) {
$lastpage = floor($lastpage) + 1;
}

if($pageNumber > $lastpage) {
$pageNumber = 1;
$offset = 0;
}



$rs_findmessages = "SELECT * FROM messages WHERE $whereclause $numberstosearch ORDER BY messagedatetime DESC LIMIT $offset,$results_per_page";
$rs_result_n = mysqli_query($rs_connect, $rs_findmessages);

echo "<span class=sizeme20>".pcrtlang("Messages")."</span>";

if($woid != "0") {
echo "<br><a href=index.php?pcwo=$woid#notes class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline ui-mini\"  data-ajax=\"false\">
<i class=\"fa fa-arrow-circle-left fa-lg\"></i> ".pcrtlang("Back to Work Order")."</a><br><br><br>";
}

if($pcid != "0") {
echo "<br><a href=pc.php?func=showpc&pcid=$pcid class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline ui-mini\"  data-ajax=\"false\">
<i class=\"fa fa-arrow-circle-left fa-lg\"></i> ".pcrtlang("Back to Asset #$pcid")."</a><br><br><br>";
}


echo "<table class=standard>";

while($rs_result_qn = mysqli_fetch_object($rs_result_n)) {
$messageid = "$rs_result_qn->messageid";
$messagebody = "$rs_result_qn->messagebody";
$messagefrom = "$rs_result_qn->messagefrom";
$messageto = "$rs_result_qn->messageto";
$messagevia = "$rs_result_qn->messagevia";
$messagedatetime2 = "$rs_result_qn->messagedatetime";
$mwoid = "$rs_result_qn->woid";
$mgroupid = "$rs_result_qn->groupid";
$messagedirection = "$rs_result_qn->messagedirection";
$messagebody2 = urlencode("$messagebody");
$mediaurls = serializedarraytest("$rs_result_qn->mediaurls");

$imageatt = "";
foreach($mediaurls as $key => $val) {
$imageatt .= "<img src=$val height=50>";
}


$messagedatetime = pcrtdate("$pcrt_time", "$messagedatetime2")." ".pcrtdate("$pcrt_shortdate", "$messagedatetime2");

if($messagevia == "call") {
$viaicon = "<i class=\"fa fa-phone fa-lg\"></i>";
} elseif($messagevia == "sms") {
$viaicon = "<i class=\"fa fa-mobile fa-lg\"></i>";
} elseif($messagevia == "im") {
$viaicon = "<i class=\"fa fa-comment fa-lg fa-fw\"></i>";
} elseif($messagevia == "email") {
$viaicon = "<i class=\"fa fa-envelope-o fa-lg\"></i>";
} else {
$viaicon = "";
}

$messagedirection = "$rs_result_qn->messagedirection";
if($messagedirection == "in") {
echo "<tr><td><i class=\"fa fa-reply fa-lg colormeblue\"></i> $viaicon <span>$messagefrom</span><br>";
echo "<i class=\"fa fa-clock-o fa-lg\"></i> <span>$messagedatetime</span><br>";
echo "<i class=\"fa fa-comment fa-lg\"></i> <span>$messagebody</span><br>$imageatt";
} elseif($messagedirection == "out") {
echo "<tr><td>$viaicon <i class=\"fa fa-share fa-lg\"></i> <span>$messagefrom</span><br>";
echo "<i class=\"fa fa-clock-o fa-lg\"></i> <span>$messagedatetime</span><br>";
echo "<i class=\"fa fa-comment fa-lg\"></i> <span>$messagebody</span><br>$imageatt";
} else {
echo "<i class=\"fa fa-user-md fa-lg\"></i> $viaicon <span>$messagefrom</span><br>";
echo "<i class=\"fa fa-clock-o fa-lg\"></i> <span>$messagedatetime</span><br>";
echo "<i class=\"fa fa-comment fa-lg\"></i> <span>$messagebody</span>";
}


echo "<div data-role=\"collapsible\" data-theme=\"b\">";
echo "<h3>".pcrtlang("Message Matches")."</h3>";

if($mwoid != 0) {
$rs_pfindpc = "SELECT * FROM pc_wo WHERE woid = '$mwoid'";
$rs_presult = mysqli_query($rs_connect, $rs_pfindpc);
$rs_presult_q = mysqli_fetch_object($rs_presult);
$fpcid = "$rs_presult_q->pcid";
$rs_findowner = "SELECT * FROM pc_owner WHERE pcid = '$fpcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
$rs_result_q2 = mysqli_fetch_object($rs_result2);
$fpcname = "$rs_result_q2->pcname";
echo "<a href=\"index.php?pcwo=$mwoid&scrollto=messages\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline ui-mini\"  data-ajax=\"false\">";
echo "<i class=\"fa fa-clipboard fa-lg\"></i> $mwoid $fpcname</a><br>";
$foundmatch = "";
}

if($mgroupid != 0) {
$rs_findgname = "SELECT * FROM pc_group WHERE pcgroupid = '$mgroupid'";
$rs_findgname2 = @mysqli_query($rs_connect, $rs_findgname);
$rs_findgname3 = mysqli_fetch_object($rs_findgname2);
$pcgroupname = "$rs_findgname3->pcgroupname";
echo "<a href=\"group.php?func=viewgroup&pcgroupid=$mgroupid\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline ui-mini\"  data-ajax=\"false\">";
echo "<i class=\"fa fa-group fa-lg\"></i> $mgroupid $pcgroupname</a><br>";
$foundmatch = "";
}

if(($messagedirection == "in") || ($messagedirection == "out")) {
if($messagedirection == "in") {
$ptosearch = substr("$messagefrom", -7);
$thecell = "$messagefrom";
} else {
$ptosearch = substr("$messageto", -7);
$thecell = "$messageto";
}
if($ptosearch != "") {
$rs_findpcowners = "SELECT * FROM pc_owner WHERE TRIM(REPLACE(REPLACE(pcphone,'-',''),' ','')) LIKE '%$ptosearch' 
OR TRIM(REPLACE(REPLACE(pccellphone,'-',''),' ','')) LIKE '%$ptosearch' 
OR TRIM(REPLACE(REPLACE(pcworkphone,'-',''),' ','')) LIKE '%$ptosearch'
OR pcphone LIKE '%$ptosearch'
OR pccellphone LIKE '%$ptosearch'
OR pcworkphone LIKE '%$ptosearch'
OR pcemail = '$thecell'
ORDER BY pcid";
$rs_result_nfpco = mysqli_query($rs_connect, $rs_findpcowners);
while($rs_result_qnfpco = mysqli_fetch_object($rs_result_nfpco)) {
$fpcid = "$rs_result_qnfpco->pcid";
$fpcname = "$rs_result_qnfpco->pcname";
echo "<a href=\"pc.php?func=showpc&pcid=$fpcid\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline ui-mini\"  data-ajax=\"false\">";
echo "<i class=\"fa fa-user fa-lg\"></i> $fpcid $fpcname</a>";
echo "<a href=\"pc.php?func=returnpc2&pcid=$fpcid&merge_custcellphone=$thecell&merge_probdesc=$messagebody2\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline ui-mini\"  data-ajax=\"false\">";
echo "<img src=\"../repair/images/new.png\" style=\"width:10px;\"></a><br>";
$foundmatch = "";

$rs_findpc = "SELECT * FROM pc_wo WHERE pcid = '$fpcid' AND pcstatus != '5' AND pcstatus != '7'";
$rs_result = mysqli_query($rs_connect, $rs_findpc);
while($rs_result_q = mysqli_fetch_object($rs_result)) {
$mwoid = "$rs_result_q->woid";
$pcstatus = "$rs_result_q->pcstatus";
$boxstyles = getboxstyle("$pcstatus");
$dropdate = "$rs_result_q->dropdate";
$pickupdate = "$rs_result_q->pickupdate";

if($pickupdate == "0000-00-00 00:00:00") {
$pickups2 =  strtotime($currentdatetime) + 86400;
} else {
$pickups2 =  strtotime($pickupdate) + 604800;
}
$dropoffs2 =  strtotime($dropdate) - 604800;

$messagetimestamp = strtotime($messagedatetime2);

if(($messagetimestamp > $dropoffs2) && ($messagetimestamp < $pickups2)) {
echo "<i class=\"fa fa-bookmark fa-lg\" style=\"color:#$boxstyles[selectorcolor]\"></i><a href=\"index.php?pcwo=$mwoid\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline ui-mini\"  data-ajax=\"false\">";
echo "<i class=\"fa fa-clipboard fa-lg\"></i> $mwoid $fpcname</a><br>";
}
}

}
}
}

if(($messagedirection == "in") || ($messagedirection == "out")) {
if($messagedirection == "in") {
$ptogsearch = substr("$messagefrom", -7);
$thesearch = "$messagefrom";
} else {
$ptogsearch = substr("$messageto", -7);
$thesearch = "$messageto";
}
if($ptogsearch != "") {
$rs_findpcgroups = "SELECT * FROM pc_group WHERE TRIM(REPLACE(REPLACE(grpphone,'-',''),' ','')) LIKE '%$ptogsearch'
OR TRIM(REPLACE(REPLACE(grpcellphone,'-',''),' ','')) LIKE '%$ptogsearch'
OR TRIM(REPLACE(REPLACE(grpworkphone,'-',''),' ','')) LIKE '%$ptogsearch'
OR grpworkphone LIKE '%$ptogsearch'
OR grpcellphone LIKE '%$ptogsearch'
OR grpphone LIKE '%$ptogsearch'
OR grpemail = '$thesearch'
ORDER BY pcgroupid";
$rs_result_nfgo = mysqli_query($rs_connect, $rs_findpcgroups);
while($rs_result_qnfgo = mysqli_fetch_object($rs_result_nfgo)) {
$fgid = "$rs_result_qnfgo->pcgroupid";
$fgname = "$rs_result_qnfgo->pcgroupname";
echo "<a href=\"group.php?func=viewgroup&pcgroupid=$fgid\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline ui-mini\"  data-ajax=\"false\">";
echo "<i class=\"fa fa-group fa-lg\"></i> $fgid $fgname</a><br>";
$foundmatch = "";
}
}
}


if(!isset($foundmatch)) {
if (filter_var($messagefrom, FILTER_VALIDATE_EMAIL)) {
$theemail = "$messagefrom";
$thecell = "";
} else {
$theemail = "";
$thecell = "$messagefrom";
}

echo "<a href=\"pc.php?func=addpc&pccellphone=$thecell&pcemail=$theemail&pcproblem=$messagebody2\"
 class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline ui-mini\"  data-ajax=\"false\">";
echo "<i class=\"fa fa-user fa-lg\"></i> ".pcrtlang("New Asset")."</a><br>";

echo "<a href=\"group.php?func=addtogroupnew&pcemail=$theemail&pccellphone=$thecell\"
 class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline ui-mini\"  data-ajax=\"false\">";
echo "<i class=\"fa fa-group fa-lg\"></i> ".pcrtlang("New Group")."</a><br>";

}


echo "</div>";

echo "</td></tr>";

}

echo "</table><br>";

echo "<center>";
#browse here

if($pageNumber != 1) {
$prevpage = $pageNumber - 1;
echo "<a href=messages.php?func=browsemessages&pageNumber=$prevpage&phonenumbers=$phonenumbers2&woid=$woid&groupid=$groupid&searchworkorders=$searchworkorders2 class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-left fa-lg\"></i></a> ";
}

$results_per_page = $results_per_page;
$html = get_paged_nav($totalentries, $results_per_page, false);
echo "$html";

if($lastpage != $pageNumber) {
$nextpage = $pageNumber + 1;
echo "<a href=messages.php?func=browsemessages&pageNumber=$nextpage&phonenumbers=$phonenumbers2&woid=$woid&groupid=$groupid&searchworkorders=$searchworkorders2 class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-right fa-lg\"></i></a>";
}

echo "</center>";	




require("footer.php");


}







switch($func) {
                                                                                                    
    default:
    nothing();
    break;
                                

case "browsemessages":
    browsemessages();
    break;

case "smssend2":
    smssend2();
    break;



}

?>
