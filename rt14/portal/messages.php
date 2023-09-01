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



##########

function messages() {
require_once("validate.php");

include("deps.php");
include("common.php");

require("header.php");

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


$phnumbers = array();
$numberstosearch2 = "";
$emails = array();

$rs_pull_group = "SELECT * FROM pc_group WHERE pcgroupid = '$portalgroupid'";
$rs_pull_groupq = @mysqli_query($rs_connect, $rs_pull_group);
while ($rs_resultgroup_q = mysqli_fetch_object($rs_pull_groupq)) {
$grpemail = "$rs_resultgroup_q->grpemail";
$phnumbers[] = "$rs_resultgroup_q->grpphone";
$phnumbers[] = "$rs_resultgroup_q->grpcellphone";
$phnumbers[] = "$rs_resultgroup_q->grpworkphone";
if (filter_var($grpemail, FILTER_VALIDATE_EMAIL)) {
$emails[] = "$grpemail";
}
}

$rs_findowner = "SELECT * FROM pc_owner WHERE pcgroupid = '$portalgroupid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
while ($rs_result_q2 = mysqli_fetch_object($rs_result2)) {
$pcid = "$rs_result_q2->pcid";
$pcphone = "$rs_result_q2->pcphone";
$pccellphone = "$rs_result_q2->pccellphone";
$pcworkphone = "$rs_result_q2->pcworkphone";
$pcemail = "$rs_result_q2->pcemail";
if(!in_array($pcphone, $phnumbers)) {
$phnumbers[] = "$pcphone";
}
if(!in_array($pcworkphone, $phnumbers)) {
$phnumbers[] = "$pcworkphone";
}
if(!in_array($pccellphone, $phnumbers)) {
$phnumbers[] = "$pccellphone";
}

if (filter_var($pcemail, FILTER_VALIDATE_EMAIL)) {
if (!in_array($pcemail, $emails)) {
$emails[] = "$pcemail";
}
}

$rs_findwo = "SELECT * FROM pc_wo WHERE pcid = '$pcid'";
$rs_resultwo2 = mysqli_query($rs_connect, $rs_findwo);
while ($rs_resultwo_q2 = mysqli_fetch_object($rs_resultwo2)) {
$woid = "$rs_resultwo_q2->woid";
$numberstosearch2 .= " OR woid = '$woid'";
}

}

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

foreach ($phnumbers as $key=>&$value) {
    if (strlen($value) < 7) {
        unset($phnumbers[$key]);
    }
}


$phnumbers = array_filter($phnumbers);

$numberstosearch = "";

foreach($phnumbers as $key => $val) {
$numberstosearch .= " OR  TRIM(REPLACE(REPLACE(messagefrom,'-',''),' ',''))  LIKE '%".substr("$val", -7)."'";
}


foreach($emails as $key => $val) {
$numberstosearch .= " OR messagefrom = '$val'";
}


$rs_findmessages_total = "SELECT * FROM messages WHERE (messagevia = 'im' OR messagevia = 'sms' OR messagevia = 'email') AND (1=2 $numberstosearch $numberstosearch2
OR groupid = '$portalgroupid') ORDER BY messagedatetime DESC LIMIT $offset,$results_per_page";
$rs_result_total = mysqli_query($rs_connect, $rs_findmessages_total);

$totalentries = mysqli_num_rows($rs_result_total);
$lastpage = $totalentries / $results_per_page;
if($lastpage != floor($lastpage)) {
$lastpage = floor($lastpage) + 1;
}

if($pageNumber > $lastpage) {
$pageNumber = 1;
$offset = 0;
}


$rs_findmessages = "SELECT * FROM messages WHERE (messagevia = 'im' OR messagevia = 'sms' OR messagevia = 'email') AND (1=2 $numberstosearch $numberstosearch2
OR groupid = '$portalgroupid') ORDER BY messagedatetime DESC LIMIT $offset,$results_per_page";
$rs_result_n = mysqli_query($rs_connect, $rs_findmessages);


echo "<br><h3>".pcrtlang("Browse Messages")."</h3><br>";

echo "<div class=\"table-responsive\">";
echo "<table class=\"table table-striped table-condensed\">";

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

if($messagevia == "call") {
$viaicon = "<i class=\"fa fa-phone fa-fw fa-lg\"></i>";
} elseif($messagevia == "sms") {
$viaicon = "<i class=\"fa fa-mobile fa-fw fa-lg\"></i>";
} elseif($messagevia == "im") {
$viaicon = "<i class=\"fa fa-comment fa-fw fa-lg\"></i>";
} else {
$viaicon = "";
}


$messagedatetime = pcrtdate("$pcrt_time", "$messagedatetime2")." ".pcrtdate("$pcrt_shortdate", "$messagedatetime2");

$messagedirection = "$rs_result_qn->messagedirection";
if($messagedirection == "in") {
echo "<tr><td><i class=\"fa fa-reply fa-fw fa-lg colormeblue\"></i> $viaicon <span>$messagefrom</span> </td>";
echo "<td><i class=\"fa fa-clock-o fa-fw fa-lg\"></i> <span>$messagedatetime</span> </td>";
echo "<td style=\"width:50%\"><div class=showmoreless><i class=\"fa fa-comment fa-fw fa-lg\"></i> $messagebody</div> </td><td>";
echo "</td>";
} elseif($messagedirection == "out") {
echo "<tr><td>$viaicon <i class=\"fa fa-share fa-fw fa-lg\"></i> <span>$messagefrom</span> </td>";
echo "<td><i class=\"fa fa-clock-o fa-fw fa-lg\"></i> <span>$messagedatetime</span> </td>";
echo "<td style=\"width:50%\"><div class=showmoreless><i class=\"fa fa-comment fa-fw fa-lg\"></i> $messagebody</div> </td><td>";
echo "</td>";
} else {
echo "<tr><td><i class=\"fa fa-user-md fa-fw fa-lg\"></i> <span>$messagefrom</span> </td>";
echo "<td><i class=\"fa fa-clock-o fa-fw fa-lg\"></i> <span>$messagedatetime</span> </td>";
echo "<td style=\"width:50%\"><div class=showmoreless><i class=\"fa fa-comment fa-fw fa-lg\"></i> $messagebody</div> </td><td>";
echo "</td>";
}

echo "<td>";

echo "</td></tr>";

}

echo "</table></div><br>";

echo "<center>";
#browse here

if($pageNumber != 1) {
$prevpage = $pageNumber - 1;
echo "<a href=messages.php?pageNumber=$prevpage
class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-left fa-lg\"></i></a> ";
}

$results_per_page = $results_per_page;
$html = get_paged_nav($totalentries, $results_per_page, false);
echo "$html";

if($lastpage != $pageNumber) {
$nextpage = $pageNumber + 1;
echo "<a href=group.php?pageNumber=$nextpage
class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-right fa-lg\"></i></a>";
}

echo "</center><br><br>";


?>
<script src="bs/readmore.js"></script>
<script>
$('.showmoreless').readmore({
  speed: 250,
  collapsedHeight: 40,
  lessLink: '<a href="#"><i class=\"fa fa-minus-circle fa-lg\"></i> <?php echo pcrtlang("Show Less"); ?></a>',
  moreLink: '<a href="#"><i class=\"fa fa-plus-circle fa-lg\"></i>  <?php echo pcrtlang("Show More"); ?></a>'
});
</script>
<?php


require("footer.php");


}



switch($func) {
                                                                                                    
    default:
    messages();
    break;
                                


}

