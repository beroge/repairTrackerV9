<?php

/***************************************************************************
 *   copyright            : (C) 2020 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/


function loadwonotes($woid, $notetype) {

require("deps.php");
require_once("common.php");

echo "<div style=\"padding:10px;\"><table class=pillbox>";

$rs_findnotes = "SELECT * FROM wonotes WHERE woid = '$woid' AND notetype = '$notetype' ORDER BY notetime ASC";
$rs_result_n = mysqli_query($rs_connect, $rs_findnotes);
$usercomm = array();
while($rs_result_qn = mysqli_fetch_object($rs_result_n)) {
$thenote = parseforlinks(nl2br("$rs_result_qn->thenote"));
$noteuser = "$rs_result_qn->noteuser";
$notetype = "$rs_result_qn->notetype";
$noteid = "$rs_result_qn->noteid";
$notetime2 = "$rs_result_qn->notetime";

if ($notetype == 1) {
$switchnotetype = 0;
$thenotearea = "technotearea";
} else {
$switchnotetype = 1;
$thenotearea = "custnotearea";
}


$notetime = pcrtdate("$pcrt_time", "$notetime2")." ".pcrtdate("$pcrt_shortdate", "$notetime2");


echo "<tr><td style=\"width:100px;text-align:center;\">";
echo "<i class=\"fa fa-user-circle fa-2x\"></i><br><span class=\"boldme\">$noteuser</span>";
echo "</td><td>$thenote<br><span class=\"italme sizemesmaller\">$notetime</span>";

echo "</td><td style=\"width:150px;text-align:center\">";
echo "<a href=\"pc.php?func=editnote&woid=$woid&noteid=$noteid\" rel=facebox class=\"linkbuttongray linkbuttontiny radiusleft\"><i class=\"fa fa-edit fa-lg\"></i><br>".pcrtlang("edit")."</a>";
echo "<a href=\"confirm.php?func=confirmdeletenote&url=".urlencode("pc.php?func=deletenote&woid=$woid&noteid=$noteid&notetype=$notetype")."&woid=$woid&question=".urlencode("Are you sure you wish to delete this note?")."\" rel=facebox class=\"linkbuttontiny linkbuttonred\"><i class=\"fa fa-times fa-lg\"></i><br>".pcrtlang("delete")."</a>";
echo "<a href=\"pc.php?func=convertnote&woid=$woid&noteid=$noteid&notetype=$switchnotetype&touch=no\" class=\"linkbuttongray linkbuttontiny radiusright catchswitchnote\"><i class=\"fa fa-exchange fa-lg\"></i><br>".pcrtlang("switch")."</a>";

echo "</td></tr>";

}

echo "</table></div>";

?>

<script type="text/javascript">
$(document).ready(function(){
$('.catchswitchnote').on('click', function(e) {
                e.preventDefault(); 
		$('.ajaxspinner').toggle();
                var url = $(this).attr('href');
                $.get(url, function () {
                $.get('ajaxhelpers.php?func=wonotesarea&pcwo=<?php echo "$woid"; ?>&notetype=0', function(data) {
                $('#custnotearea').html(data);
                });
                $.get('ajaxhelpers.php?func=wonotesarea&pcwo=<?php echo "$woid"; ?>&notetype=1', function(data) {
                $('#technotearea').html(data);
		$('.ajaxspinner').toggle();
                });
		});
        });
});
</script>

  <script type="text/javascript">
    jQuery(document).ready(function($) {
         $('a[rel*=facebox]').off();
         $('a[rel*=facebox]').facebox({
        loadingImage : 'jq/loading.gif',
        closeImage : 'jq/closelabel.png'
      })
    })
  </script>


<?php

}

#####################################


function displaymessages($phonenumbers,$emails,$woid,$pickup,$dropoff) {

require("deps.php");
require_once("common.php");

$phnumbers = explode_list($phonenumbers);
$emailsexploded = explode_list_email($emails);

foreach ($phnumbers as $key=>&$value) {
    if (strlen($value) < 7) {
        unset($phnumbers[$key]);
    }
}

reset($phnumbers);

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');


if($pickup == "0000-00-00 00:00:00") {
$pickup2 =  date('Y-m-d H:i:s', (strtotime($currentdatetime) + 86400));
} else {
$pickup2 =  date('Y-m-d H:i:s', (strtotime($pickup) + 604800));
}

$dropoff2 =  date('Y-m-d H:i:s', (strtotime($dropoff) - 604800));

$numberstosearch = "";

foreach($phnumbers as $key => $val) {
$val = preg_replace('/\D+/', '', $val);
$numberstosearch .= " OR  TRIM(REPLACE(REPLACE(messagefrom,'-',''),' ',''))  LIKE '%".substr("$val", -7)."'";
$numberstosearch .= " OR messagefrom LIKE '%".substr("$val", -7)."'";
$numberstosearch .= " OR  TRIM(REPLACE(REPLACE(messageto,'-',''),' ',''))  LIKE '%".substr("$val", -7)."'";
$numberstosearch .= " OR messageto LIKE '%".substr("$val", -7)."'";
}

if($woid != 0) {
$numberstosearch .= " OR woid = '$woid'";
}

$rs_findowner = "SELECT * FROM pc_wo WHERE woid = '$woid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
$rs_result_q2 = mysqli_fetch_object($rs_result2);
$pcid = "$rs_result_q2->pcid";

$rs_findgroup = "SELECT * FROM pc_owner WHERE pcid = '$pcid'";
$rs_resultg2 = mysqli_query($rs_connect, $rs_findgroup);
$rs_resultg_q2 = mysqli_fetch_object($rs_resultg2);
$pcgroupid = "$rs_resultg_q2->pcgroupid";

if($pcgroupid != 0) {
$numberstosearch .= " OR groupid = '$pcgroupid'";
}


foreach($emailsexploded as $key => $val) {
if (filter_var($val, FILTER_VALIDATE_EMAIL)) {
$numberstosearch .= " OR messagefrom = '$val'";
}
}

$rs_findmessages = "SELECT * FROM messages WHERE 1=2 $numberstosearch AND messagedatetime > '$dropoff2' AND messagedatetime < '$pickup2' 
ORDER BY messagedatetime DESC";


$rs_result_n = mysqli_query($rs_connect, $rs_findmessages);

echo "<div style=\"max-height:400px;overflow-y:auto;scrollbar-width: thin;\">";

echo "<table class=standard>";

while($rs_result_qn = mysqli_fetch_object($rs_result_n)) {
$messageid = "$rs_result_qn->messageid";
$messagebody = "$rs_result_qn->messagebody";
$messagefrom = "$rs_result_qn->messagefrom";
$messagevia = "$rs_result_qn->messagevia";
$messagedatetime2 = "$rs_result_qn->messagedatetime";
$mediaurls = serializedarraytest("$rs_result_qn->mediaurls");

$imageatt = "";
foreach($mediaurls as $key => $val) {
$imageatt .= "<a href=\"$val\" class=\"assetpreview\"><img src=$val height=50 class=\"assetimage\"></a> ";
}

if($messagevia == "call") {
$viaicon = "<i class=\"fa fa-phone fa-lg fa-fw\"></i>";
} elseif($messagevia == "sms") {
$viaicon = "<i class=\"fa fa-mobile fa-lg fa-fw\"></i>";
} elseif($messagevia == "im") {
$viaicon = "<i class=\"fa fa-comment fa-lg fa-fw\"></i>";
} elseif($messagevia == "email") {
$viaicon = "<i class=\"fa fa-envelope-o fa-lg\"></i>";
} else {
$viaicon = "";
}


$messagedatetime = pcrtdate("$pcrt_time", "$messagedatetime2")." ".pcrtdate("$pcrt_shortdate", "$messagedatetime2");

$messagedirection = "$rs_result_qn->messagedirection";
if($messagedirection == "in") {
echo "<tr><td><i class=\"fa fa-reply fa-lg colormeblue\"></i> $viaicon <span>$messagefrom</span> </td>";
echo "<td><i class=\"fa fa-clock-o fa-fw fa-lg\"></i> <span>$messagedatetime</span> </td>";
echo "<td style=\"width:60%\"><i class=\"fa fa-comment fa-lg\"></i> $messagebody $imageatt</td><td>";
if($messagevia == "call") {
echo "<a href=\"pc.php?func=deletemessage&woid=$woid&messageid=$messageid\" class=\"linkbuttonsmall linkbuttonred radiusall\" onClick=\"return confirm('".pcrtlang("Are you sure you wish to delete this message?")."');\"><i class=\"fa fa-trash fa-lg\"></i></a>";
}
echo "</td></tr>";
} elseif($messagedirection == "out") {
echo "<tr><td>$viaicon <i class=\"fa fa-share fa-fw fa-lg\"></i> <span>$messagefrom</span> </td>";
echo "<td><i class=\"fa fa-clock-o fa-lg\"></i> <span>$messagedatetime</span> </td>";
echo "<td style=\"width:60%\"><i class=\"fa fa-comment fa-lg\"></i> $messagebody $imageatt</td><td>";
if($messagevia == "call") {
echo "<a href=\"pc.php?func=deletemessage&woid=$woid&messageid=$messageid\" class=\"linkbuttonsmall linkbuttonred radiusall\" onClick=\"return confirm('".pcrtlang("Are you sure you wish to delete this message?")."');\" ><i class=\"fa fa-trash fa-lg\"></i></a>";
}
echo "</td></tr>";
} else {
echo "<tr><td><i class=\"fa fa-user-md fa-lg\"></i> <span>$messagefrom</span> </td>";
echo "<td><i class=\"fa fa-clock-o fa-fw fa-lg\"></i> <span>$messagedatetime</span> </td>";
echo "<td style=\"width:60%\"><i class=\"fa fa-comment fa-lg\"></i> $messagebody </td><td>";
if($messagevia == "call") {
echo "<a href=\"pc.php?func=deletemessage&woid=$woid&messageid=$messageid\" class=\"linkbuttonsmall linkbuttonred radiusall\" onClick=\"return confirm('".pcrtlang("Are you sure you wish to delete this message?")."');\" ><i class=\"fa fa-trash fa-lg\"></i></a>";
}
echo "</td></tr>";
}

}

echo "</table>";
echo "</div>";
?>
<script src="jq/facebox.js" type="text/javascript"></script>
<?php


}


################################################

function loadchecks($woid) {

require("deps.php");
require_once("common.php");

$pcwo = $woid;

$rs_findwo = "SELECT * FROM pc_wo WHERE woid = '$woid'";
$rs_resultw = mysqli_query($rs_connect, $rs_findwo);
$rs_resultw_q = mysqli_fetch_object($rs_resultw);
$wochecks = "$rs_resultw_q->wochecks";
$pcid = "$rs_resultw_q->pcid";

$rs_findpc = "SELECT * FROM pc_owner WHERE pcid = '$pcid'";
$rs_result = mysqli_query($rs_connect, $rs_findpc);
$rs_result_q = mysqli_fetch_object($rs_result);
$mainassettypeidindb = "$rs_result_q->mainassettypeid";


$rs_sq = "SELECT * FROM mainassettypes WHERE mainassettypeid = '$mainassettypeidindb'";
$rs_result1 = mysqli_query($rs_connect, $rs_sq);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$mainassetchecksindb = serializedarraytest("$rs_result_q1->mainassetchecks");

start_box();



$wochecks = serializedarraytest("$wochecks");


echo "<table class=standard>";

echo "<tr><th colspan=2>".pcrtlang("Pre Checks")."</th><th colspan=2>".pcrtlang("Post Checks")."</th></tr>";

foreach($mainassetchecksindb as $key => $val) {

$rs_checks = "SELECT * FROM checks WHERE checkid = '$val'";
$rs_checksq = mysqli_query($rs_connect, $rs_checks);
$rs_result_cq = mysqli_fetch_object($rs_checksq);
$checkid = "$rs_result_cq->checkid";
$checkname = "$rs_result_cq->checkname";


if (in_array($checkid, $mainassetchecksindb)) {

if(array_key_exists("$checkid", $wochecks)) {
if(isset($wochecks[$checkid][0])) {
$precheck = $wochecks[$checkid][0];
} else {
$precheck = 0;
}

if(isset($wochecks[$checkid][1])) {
$postcheck = $wochecks[$checkid][1];
} else {
$postcheck = 0;
}
} else {
$precheck = 0;
$postcheck = 0;
}

# not checked = 0, not applicable = 1, pass = 2, fail = 3

echo "<tr><td>$checkname</td><td>";
if($precheck == 0) {
echo "<a href=pc.php?func=setcheck&checktype=0&checkvalue=0&woid=$pcwo&checkid=$checkid class=\"linkbuttonsmall linkbuttonblack radiusleft nopointerevents\"
title=\"".pcrtlang("not checked")."\"><i class=\"fa fa-square-o  fa-lg\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=0&checkvalue=1&woid=$pcwo&checkid=$checkid class=\"linkbuttonsmall linkbuttongray\"
title=\"".pcrtlang("does not apply")."\"><i class=\"fa fa-minus fa-lg\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=0&checkvalue=2&woid=$pcwo&checkid=$checkid class=\"linkbuttonsmall linkbuttongray\"
title=\"".pcrtlang("pass")."\"><i class=\"fa fa-check fa-lg\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=0&checkvalue=3&woid=$pcwo&checkid=$checkid class=\"linkbuttonsmall linkbuttongray radiusright\"
title=\"".pcrtlang("fail")."\"><i class=\"fa fa-warning fa-lg\"></i></a>";
} elseif($precheck == 1) {
echo "<a href=pc.php?func=setcheck&checktype=0&checkvalue=0&woid=$pcwo&checkid=$checkid class=\"linkbuttonsmall linkbuttongray radiusleft\"
title=\"".pcrtlang("not checked")."\"><i class=\"fa fa-square-o  fa-lg\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=0&checkvalue=1&woid=$pcwo&checkid=$checkid class=\"linkbuttonsmall linkbuttonblack nopointerevents\"
title=\"".pcrtlang("does not apply")."\"><i class=\"fa fa-minus fa-lg\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=0&checkvalue=2&woid=$pcwo&checkid=$checkid class=\"linkbuttonsmall linkbuttongray\"
title=\"".pcrtlang("pass")."\"><i class=\"fa fa-check fa-lg\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=0&checkvalue=3&woid=$pcwo&checkid=$checkid class=\"linkbuttonsmall linkbuttongray radiusright\"
title=\"".pcrtlang("fail")."\"><i class=\"fa fa-warning fa-lg\"></i></a>";
} elseif($precheck == 2) {
echo "<a href=pc.php?func=setcheck&checktype=0&checkvalue=0&woid=$pcwo&checkid=$checkid class=\"linkbuttonsmall linkbuttongray radiusleft\"
title=\"".pcrtlang("not checked")."\"><i class=\"fa fa-square-o  fa-lg\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=0&checkvalue=1&woid=$pcwo&checkid=$checkid class=\"linkbuttonsmall linkbuttongray\"
title=\"".pcrtlang("does not apply")."\"><i class=\"fa fa-minus fa-lg\"></i></a>";
echo "<span class=\"linkbuttonsmall linkbuttongreenlabel\"
title=\"".pcrtlang("pass")."\"><i class=\"fa fa-check fa-lg\"></i></span>";
echo "<a href=pc.php?func=setcheck&checktype=0&checkvalue=3&woid=$pcwo&checkid=$checkid class=\"linkbuttonsmall linkbuttongray radiusright\"
title=\"".pcrtlang("fail")."\"><i class=\"fa fa-warning fa-lg\"></i></a>";
} elseif($precheck == 3) {
echo "<a href=pc.php?func=setcheck&checktype=0&checkvalue=0&woid=$pcwo&checkid=$checkid class=\"linkbuttonsmall linkbuttongray radiusleft\"
title=\"".pcrtlang("not checked")."\"><i class=\"fa fa-square-o fa-lg\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=0&checkvalue=1&woid=$pcwo&checkid=$checkid class=\"linkbuttonsmall linkbuttongray\"
title=\"".pcrtlang("does not apply")."\"><i class=\"fa fa-minus fa-lg\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=0&checkvalue=2&woid=$pcwo&checkid=$checkid class=\"linkbuttonsmall linkbuttongray\"
title=\"".pcrtlang("pass")."\"><i class=\"fa fa-check fa-lg\"></i></a>";
echo "<span class=\"linkbuttonsmall linkbuttonredlabel radiusright\"
title=\"".pcrtlang("fail")."\"><i class=\"fa fa-warning fa-lg\"></i></span>";
} else {
}


echo "</td><td>$checkname</td><td>";

if($postcheck == 0) {
echo "<a href=pc.php?func=setcheck&checktype=1&checkvalue=0&woid=$pcwo&checkid=$checkid class=\"linkbuttonsmall linkbuttonblack radiusleft nopointerevents\"
title=\"".pcrtlang("not checked")."\"><i class=\"fa fa-square-o  fa-lg\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=1&checkvalue=1&woid=$pcwo&checkid=$checkid class=\"linkbuttonsmall linkbuttongray\"
title=\"".pcrtlang("does not apply")."\"><i class=\"fa fa-minus fa-lg\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=1&checkvalue=2&woid=$pcwo&checkid=$checkid class=\"linkbuttonsmall linkbuttongray\"
title=\"".pcrtlang("pass")."\"><i class=\"fa fa-check fa-lg\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=1&checkvalue=3&woid=$pcwo&checkid=$checkid class=\"linkbuttonsmall linkbuttongray radiusright\"
title=\"".pcrtlang("fail")."\"><i class=\"fa fa-warning fa-lg\"></i></a>";
} elseif($postcheck == 1) {
echo "<a href=pc.php?func=setcheck&checktype=1&checkvalue=0&woid=$pcwo&checkid=$checkid class=\"linkbuttonsmall linkbuttongray radiusleft\"
title=\"".pcrtlang("not checked")."\"><i class=\"fa fa-square-o  fa-lg\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=1&checkvalue=1&woid=$pcwo&checkid=$checkid class=\"linkbuttonsmall linkbuttonblack nopointerevents\"
title=\"".pcrtlang("does not apply")."\"><i class=\"fa fa-minus fa-lg\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=1&checkvalue=2&woid=$pcwo&checkid=$checkid class=\"linkbuttonsmall linkbuttongray\"
title=\"".pcrtlang("pass")."\"><i class=\"fa fa-check fa-lg\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=1&checkvalue=3&woid=$pcwo&checkid=$checkid class=\"linkbuttonsmall linkbuttongray radiusright\"
title=\"".pcrtlang("fail")."\"><i class=\"fa fa-warning fa-lg\"></i></a>";
} elseif($postcheck == 2) {
echo "<a href=pc.php?func=setcheck&checktype=1&checkvalue=0&woid=$pcwo&checkid=$checkid class=\"linkbuttonsmall linkbuttongray radiusleft\"
title=\"".pcrtlang("not checked")."\"><i class=\"fa fa-square-o  fa-lg\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=1&checkvalue=1&woid=$pcwo&checkid=$checkid class=\"linkbuttonsmall linkbuttongray\"
title=\"".pcrtlang("does not apply")."\"><i class=\"fa fa-minus fa-lg\"></i></a>";
echo "<span class=\"linkbuttonsmall linkbuttongreenlabel\"
title=\"".pcrtlang("pass")."\"><i class=\"fa fa-check fa-lg\"></i></span>";
echo "<a href=pc.php?func=setcheck&checktype=1&checkvalue=3&woid=$pcwo&checkid=$checkid class=\"linkbuttonsmall linkbuttongray radiusright\"
title=\"".pcrtlang("fail")."\"><i class=\"fa fa-warning fa-lg\"></i></a>";
} elseif($postcheck == 3) {
echo "<a href=pc.php?func=setcheck&checktype=1&checkvalue=0&woid=$pcwo&checkid=$checkid class=\"linkbuttonsmall linkbuttongray radiusleft\"
title=\"".pcrtlang("not checked")."\"><i class=\"fa fa-square-o fa-lg\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=1&checkvalue=1&woid=$pcwo&checkid=$checkid class=\"linkbuttonsmall linkbuttongray\"
title=\"".pcrtlang("does not apply")."\"><i class=\"fa fa-minus fa-lg\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=1&checkvalue=2&woid=$pcwo&checkid=$checkid class=\"linkbuttonsmall linkbuttongray\"
title=\"".pcrtlang("pass")."\"><i class=\"fa fa-check fa-lg\"></i></a>";
echo "<span class=\"linkbuttonsmall linkbuttonredlabel radiusright\"
title=\"".pcrtlang("fail")."\"><i class=\"fa fa-warning fa-lg\"></i></span>";
} else {

}


echo "</td></tr>";
}

}


echo "</table>";

stop_box();
}


# Service Requests Panel
###################################################################################################################

function loadservicerequests() {

require("deps.php");

$rs_ql = "SELECT defaultstore,statusview,promiseview,gomodal FROM users WHERE username = '$ipofpc'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$defaultuserstore = "$rs_result_q1->defaultstore";
$statusview = "$rs_result_q1->statusview";
$promiseview = "$rs_result_q1->promiseview";
$gomodal = "$rs_result_q1->gomodal";

if ($gomodal == 1) {
$therel = "rel=facebox";
} else {
$therel = "";
}

if(!isset($statusassetlimit)) {
$statusassetlimit = 12;
}

$rs_sr = "SELECT * FROM servicerequests WHERE sreq_processed = '0' AND (storeid = '$defaultuserstore' OR storeid = '0') ORDER BY storeid DESC, sreq_datetime DESC LIMIT $statusassetlimit";
$rs_find_sr = @mysqli_query($rs_connect, $rs_sr);

$rs_srtotal = "SELECT * FROM servicerequests WHERE sreq_processed = '0' AND (storeid = '$defaultuserstore' OR storeid = '0')";
$rs_find_srtotal = @mysqli_query($rs_connect, $rs_srtotal);
$totalsreq = mysqli_num_rows($rs_find_srtotal);

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdate = date('Y-m-d');

$rs_srtotaltoday = "SELECT * FROM servicerequests WHERE sreq_processed = '0' AND sreq_datetime LIKE '$currentdate%' AND (storeid = '$defaultuserstore' OR storeid = '0')";
$rs_find_srtotaltoday = @mysqli_query($rs_connect, $rs_srtotaltoday);
$totalsreqtoday = mysqli_num_rows($rs_find_srtotaltoday);


if ($totalsreq != "0") {
echo "<a href=\"javascript:void(0);\" class=\"linkbuttonmedium linkbuttongray radiusall\" id=swholeclick style=\"display:block;\"><i class=\"fa fa-chevron-down\"></i> ";
echo "<span class=\"sizeme16 boldme\">&nbsp;".pcrtlang("Service Requests")."</span>";
echo "<span style=\"padding:1px;border-radius:50%;float:right;\" class=sizeme16>";
if($totalsreqtoday != 0) {
echo "$totalsreqtoday ".pcrtlang("Today")."&nbsp;&bull;&nbsp;";
}
echo "$totalsreq ".pcrtlang("Total")."</span>";
echo "</a>";

echo "<div style=\"display:none\" id=swholenote>";
$previousstoreid = $defaultuserstore;
while($rs_find_sr_q = mysqli_fetch_object($rs_find_sr)) {
$sreq_id = "$rs_find_sr_q->sreq_id";
$sreq_ip = "$rs_find_sr_q->sreq_ip";
$sreq_agent = "$rs_find_sr_q->sreq_agent";
$sreq_name = "$rs_find_sr_q->sreq_name";
$sreq_company = "$rs_find_sr_q->sreq_company";
$sreq_homephone = "$rs_find_sr_q->sreq_homephone";
$sreq_cellphone = "$rs_find_sr_q->sreq_cellphone";
$sreq_workphone = "$rs_find_sr_q->sreq_workphone";
$sreq_addy1 = "$rs_find_sr_q->sreq_addy1";
$sreq_addy2 = "$rs_find_sr_q->sreq_addy2";
$sreq_city = "$rs_find_sr_q->sreq_city";
$sreq_state = "$rs_find_sr_q->sreq_state";
$sreq_zip = "$rs_find_sr_q->sreq_zip";
$sreq_email = "$rs_find_sr_q->sreq_email";
$sreq_problem = "$rs_find_sr_q->sreq_problem";
$sreq_model = "$rs_find_sr_q->sreq_model";
$sreq_datetime = "$rs_find_sr_q->sreq_datetime";
$sreq_custsourceid = "$rs_find_sr_q->sreq_custsourceid";
$sreq_pcid = "$rs_find_sr_q->sreq_pcid";
$sreq_storeid = "$rs_find_sr_q->storeid";

$sreq_date2 =  elapsfriendly($sreq_datetime);

if($sreq_storeid != "$previousstoreid") {
echo "<div class=\"boldme\" style=\"background:#cccccc;padding:3px;text-align:center;\"><i class=\"fa fa-store\"></i> ".pcrtlang("Unassigned Store")."</div>";
}

$previousstoreid = "$sreq_storeid";

echo "<a href=\"javascript:void(0);\" class=\"linkbuttonsmall linkbuttongray s_toggle\" id=sclick$sreq_id style=\"display:block;border-bottom:#cccccc 1px solid\"><i class=\"fa fa-chevron-down\"></i> ";
echo "<span class=boldme>$sreq_name</span> <span class=\"floatright boldme\">$sreq_date2</span></a>";
echo "<div style=\"display:none;\" class=\"closeall s_content\" id=\"snote$sreq_id\">";
echo "<table class=\"standard\" style=\"border-bottom:2px #333333 solid\">";
$sqlwhere = "";
if("$sreq_company" != "") {
echo "<tr><td style=\"\"><i class=\"fa fa-briefcase fa-lg fa-fw\"></i></td><td>$sreq_company</td></tr>";
$sqlwhere .= " OR pccompany LIKE '%".pv("$sreq_company")."%'";
}
echo "<tr><td><i class=\"fa fa-map-marker fa-lg fa-fw\"></i></td><td>";
if($sreq_addy1 != "") {
echo "$sreq_addy1";
}
if($sreq_addy2 != "") {
echo "<br>$sreq_addy2";
}
if(($sreq_city != "") || ($sreq_state != "") || ($sreq_zip != "")){
echo "<br>$sreq_city, $sreq_state $sreq_zip";
}
echo "</td></tr>";
if($sreq_homephone != "") {
echo "<tr><td><i class=\"fa fa-home fa-lg fa-fw\"></i></td><td>$sreq_homephone</td></tr>";
$sqlwhere .= " OR pcphone LIKE '%".pv("$sreq_homephone")."%'";
}
if($sreq_cellphone != "") {
echo "<tr><td><i class=\"fa fa-mobile fa-lg fa-fw\"></i></td><td>$sreq_cellphone</td></tr>";
$sqlwhere .= "OR pccellphone LIKE '%".pv("$sreq_cellphone")."%' ";
}
if($sreq_workphone != "") {
echo "<tr><td><i class=\"fa fa-briefcase fa-lg fa-fw\"></i></td><td>$sreq_workphone</td></tr>";
$sqlwhere .= " OR pcworkphone LIKE '%".pv("$sreq_homephone")."%'";
}
if($sreq_email != "") {
echo "<tr><td><i class=\"fa fa-envelope fa-lg fa-fw\"></i></td><td>$sreq_email</td></tr>";
$sqlwhere .= " OR pcemail LIKE '%".pv("$sreq_email")."%'";
}
if($sreq_model != "") {
echo "<tr><td><i class=\"fa fa-cog fa-lg fa-fw\"></i></td><td>$sreq_model</td></tr>";
}
if($sreq_pcid != "") {
$sqlwhere .= " OR pcid = '".pv("$sreq_pcid")."'";
}
if($sreq_name != "") {
$sqlwhere .= " OR pcname LIKE '".pv("$sreq_name")."'";
}
echo "<tr><td><i class=\"fa fa-wrench fa-lg fa-fw\"></i></td><td>$sreq_problem</td></tr>";
echo "<tr><td colspan=2><table class=standard>";
$rs_find_pc = "SELECT * FROM pc_owner WHERE 1=2 $sqlwhere LIMIT 50";
$rs_result_item = mysqli_query($rs_connect, $rs_find_pc);
while($rs_result_item_q = mysqli_fetch_object($rs_result_item)) {
$pcname = "$rs_result_item_q->pcname";
$pccompany = "$rs_result_item_q->pccompany";
$pcid2 = "$rs_result_item_q->pcid";
$pcmake = "$rs_result_item_q->pcmake";
echo "<tr><td>";
if($pcid2 == $sreq_pcid) {
echo "<i class=\"fa fa-tag colormered\"></i>";
}
echo "</td>";
echo "<td><i class=\"fa fa-user\"></i>$pcid2 $pcname</td><td><i class=\"fa fa-cog\"></i> $pcmake</td><td>";
echo "<form action=pc.php?func=returnpc2 method=post>";
echo "<input type=hidden name=pcid value=\"$pcid2\">";
echo "<input type=hidden name=merge_custname value=\"$sreq_name\">";
echo "<input type=hidden name=merge_custcompany value=\"$sreq_company\">";
echo "<input type=hidden name=merge_custphone value=\"$sreq_homephone\">";
echo "<input type=hidden name=merge_custemail value=\"$sreq_email\">";
echo "<input type=hidden name=merge_custworkphone value=\"$sreq_workphone\">";
echo "<input type=hidden name=merge_custcellphone value=\"$sreq_cellphone\">";
echo "<input type=hidden name=merge_custaddress1 value=\"$sreq_addy1\">";
echo "<input type=hidden name=merge_custaddress2 value=\"$sreq_addy2\">";
echo "<input type=hidden name=merge_custcity value=\"$sreq_city\">";
echo "<input type=hidden name=merge_custstate value=\"$sreq_state\">";
echo "<input type=hidden name=merge_custzip value=\"$sreq_zip\">";
echo "<input type=hidden name=merge_probdesc value=\"$sreq_problem\">";
echo "<input type=hidden name=merge_pcmake value=\"$sreq_model\">";
echo "<input type=hidden name=sreq_id value=\"$sreq_id\">";
echo "<button type=submit class=\"linkbuttonsmall linkbuttongray radiusall\"><img src=images/return.png style=\"height:16px;\"></button>";
echo "</form>";
echo "</td></tr>";
}

$pcname = urlencode("$sreq_name");
$pccompany = urlencode("$sreq_company");
$pcphone = urlencode("$sreq_homephone");
$pcemail = urlencode("$sreq_email");
$pcaddress = urlencode("$sreq_addy1");
$pcaddress2 = urlencode("$sreq_addy2");
$pccity = urlencode("$sreq_city");
$pcstate = urlencode("$sreq_state");
$pczip = urlencode("$sreq_zip");
$pccellphone = urlencode("$sreq_cellphone");
$pcworkphone = urlencode("$sreq_workphone");
$pcproblem = urlencode("$sreq_problem");
$pcmake = urlencode("$sreq_model");



echo "<tr><td colspan=4 style=\"text-align:center\">";
echo "<span class=\"linkbuttongraylabel linkbuttontiny radiusleft\">".pcrtlang("New")."</span>";
echo "<a href=pc.php?func=addpc&pcname=$pcname&pccompany=$pccompany&pcphone=$pcphone&pcemail=$pcemail&pcaddress=$pcaddress&pcaddress2=$pcaddress2&pccity=$pccity&pcstate=$pcstate&pczip=$pczip&pccellphone=$pccellphone&pcworkphone=$pcworkphone&pcproblem=$pcproblem&pcmake=$pcmake&sreq_id=$sreq_id&custsourceid=$sreq_custsourceid
class=\"linkbuttontiny linkbuttongray\"><img src=images/new.png align=absmiddle border=0 height=14> ".pcrtlang("Work Order")."</a>";

echo "<a href=pc.php?func=addassetonly&pcname=$pcname&pccompany=$pccompany&pcphone=$pcphone&pcemail=$pcemail&pcaddress=$pcaddress&pcaddress2=$pcaddress2&pccity=$pccity&pcstate=$pcstate&pczip=$pczip&pccellphone=$pccellphone&pcworkphone=$pcworkphone&pcmake=$pcmake
class=\"linkbuttontiny linkbuttongray\"><img src=images/customers.png align=absmiddle border=0 height=14> ".pcrtlang("Asset/Device")."</a>";

echo "<a href=group.php?func=addtogroupnew&groupname=$pcname&pccompany=$pccompany&pchomephone=$pcphone&pcemail=$pcemail&pcaddress1=$pcaddress&pcaddress2=$pcaddress2&pccity=$pccity&pcstate=$pcstate&pczip=$pczip&pccellphone=$pccellphone&pcworkphone=$pcworkphone class=\"linkbuttontiny linkbuttongray\">
<img src=images/groups.png align=absmiddle border=0 height=14> ".pcrtlang("Group")."</a>";


echo "<a href=sticky.php?func=addsticky&stickyname=$pcname&stickycompany=$pccompany&stickyphone=$pcphone&stickyemail=$pcemail&stickyaddy1=$pcaddress&stickyaddy2=$pcaddress2&stickycity=$pccity&stickystate=$pcstate&stickyzip=$pczip&stickynote=$pcproblem&sreq_id=$sreq_id&nomodal=nomodal class=\"linkbuttontiny linkbuttongray radiusright\">
<img src=images/sticky.png align=absmiddle border=0 height=14> ".pcrtlang("Sticky")."</a><br>";

echo "<br><span class=\"linkbuttongraylabel linkbuttontiny radiusleft\">".pcrtlang("Actions")."</span>";
echo "<a href=servicerequests.php?func=proreq&sreq_id=$sreq_id&showstore=$defaultuserstore class=\"catchsrlink linkbuttontiny linkbuttongray\">
<img src=images/right.png align=absmiddle border=0 height=14> ".pcrtlang("Mark as Processed")."</a>";
echo "<a href=servicerequests.php?func=delreq&sreq_id=$sreq_id&showstore=$defaultuserstore class=\"catchsrlink linkbuttontiny linkbuttongray radiusright\"><img src=images/del.png align=absmiddle border=0 height=14> ".pcrtlang("Delete")."</a>";

echo "</td></tr>";
echo "</table></td></tr>";
echo "</table>";
echo "</div>";

}

echo "</div>";

?>
<script type='text/javascript'>
$('#swholeclick').click(function(){
$('#swholenote').toggle('1000');
$("i",this).toggleClass("fa-chevron-up fa-chevron-down");
$('#swholeclick').toggleClass("radiusall radiustop");
});


$('a.s_toggle').click(function(){
if ( $(this).next().is(":visible")){
$(this).next().hide('fast');
}
else{
$('div.s_content:visible').hide('fast');
$(this).next().show('fast');
}
});
</script>

<script type='text/javascript'>
$(document).ready(function(){
$('.catchsrlink').click(function(e) { // catch the form's submit event
        e.preventDefault();
		$('.ajaxspinner').toggle();
                var url = $(this).attr('href');
                $.get(url, function () {
                $.get('srmenu.php', function(data) {
                $('#servicerequests').html(data);
		$('.ajaxspinner').toggle();
                });
        });
});
});
</script>


<?php

echo "<br>";
}
}


#########################################


function displaymessagessinglenumber($phnumber) {

require("deps.php");
require_once("common.php");

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

echo "<table style=\"width:100%;border-collapse:collapse;\"><tr><td style=\"width:70%;vertical-align:top;padding:20px;\"><table class=standard>";

if($phnumber != "") {

$phnumbers[] = "$phnumber";

$numberstosearch = "";

foreach($phnumbers as $key => $val) {
$val = preg_replace('/\D+/', '', $val);
$numberstosearch .= " OR  TRIM(REPLACE(REPLACE(messagefrom,'-',''),' ',''))  LIKE '%".substr("$val", -7)."'";
$numberstosearch .= " OR messagefrom LIKE '%".substr("$val", -7)."'";
$numberstosearch .= " OR  TRIM(REPLACE(REPLACE(messageto,'-',''),' ',''))  LIKE '%".substr("$val", -7)."'";
$numberstosearch .= " OR messageto LIKE '%".substr("$val", -7)."'";
}


$rs_findmessages = "SELECT * FROM messages WHERE 1=2 $numberstosearch ORDER BY messagedatetime DESC LIMIT 40";
$rs_result_n = mysqli_query($rs_connect, $rs_findmessages);



while($rs_result_qn = mysqli_fetch_object($rs_result_n)) {
$messageid = "$rs_result_qn->messageid";
$messagebody = "$rs_result_qn->messagebody";
$messagefrom = "$rs_result_qn->messagefrom";
$messagevia = "$rs_result_qn->messagevia";
$messagedatetime2 = "$rs_result_qn->messagedatetime";
$mediaurls = serializedarraytest("$rs_result_qn->mediaurls");

$imageatt = "";
foreach($mediaurls as $key => $val) {
$imageatt .= "<a href=\"$val\" class=\"assetpreview\"><img src=$val height=50 class=\"assetimage\"></a> ";
}

if($messagevia == "call") {
$viaicon = "<i class=\"fa fa-phone fa-lg fa-fw\"></i>";
} elseif($messagevia == "sms") {
$viaicon = "<i class=\"fa fa-mobile fa-lg fa-fw\"></i>";
} elseif($messagevia == "im") {
$viaicon = "<i class=\"fa fa-comment fa-lg fa-fw\"></i>";
} elseif($messagevia == "email") {
$viaicon = "<i class=\"fa fa-envelope-o fa-lg\"></i>";
} else {
$viaicon = "";
}


$messagedatetime = pcrtdate("$pcrt_time", "$messagedatetime2")." ".pcrtdate("$pcrt_shortdate", "$messagedatetime2");
$messagedatetime = pcrtdate("$pcrt_time", "$messagedatetime2")." ".pcrtdate("$pcrt_shortdate", "$messagedatetime2");

$messagedirection = "$rs_result_qn->messagedirection";
if($messagedirection == "in") {
echo "<tr><td><i class=\"fa fa-reply fa-lg colormeblue\"></i> $viaicon <span>$messagefrom</span> </td>";
echo "<td><i class=\"fa fa-clock-o fa-fw fa-lg\"></i> <span>$messagedatetime</span> </td>";
echo "<td style=\"width:60%\"><i class=\"fa fa-comment fa-lg\"></i> $messagebody$imageatt</td><td>";
echo "</td></tr>";
} elseif($messagedirection == "out") {
echo "<tr><td>$viaicon <i class=\"fa fa-share fa-fw fa-lg\"></i> <span>$messagefrom</span> </td>";
echo "<td><i class=\"fa fa-clock-o fa-lg\"></i> <span>$messagedatetime</span> </td>";
echo "<td style=\"width:60%\"><i class=\"fa fa-comment fa-lg\"></i> $messagebody$imageatt</td><td>";
echo "</td></tr>";
} else {
echo "<tr><td><i class=\"fa fa-user-md fa-lg\"></i> <span>$messagefrom</span> </td>";
echo "<td><i class=\"fa fa-clock-o fa-fw fa-lg\"></i> <span>$messagedatetime</span> </td>";
echo "<td style=\"width:60%\"><i class=\"fa fa-comment fa-lg\"></i> $messagebody </td><td>";
echo "</td></tr>";
}

}


}
#end message display

echo "</table></td>";
echo "<td style=\"vertical-align:top;background:#333333;padding:10px 20px;\">";

echo "<div class=\"sizeme16 colormewhite\" style=\"text-align:center\"><i class=\"fas fa-comment fa-lg\"></i> ".pcrtlang("Recent Conversations")."</div><br>";

##

function in_array_r($item , $array){
    return preg_match('/"'.preg_quote($item, '/').'"/i' , json_encode($array));
}

$recentnumbers = array();
$rs_findnumbers = "SELECT * FROM messages WHERE messagevia = 'sms' AND messagedatetime > DATE_SUB(NOW(), INTERVAL 5 YEAR) ORDER BY messagedatetime DESC LIMIT 50"; 
$rs_result_numbers = mysqli_query($rs_connect, $rs_findnumbers);
while($rs_result_qns = mysqli_fetch_object($rs_result_numbers)) {
$messagefrom = "$rs_result_qns->messagefrom";
$messageto = "$rs_result_qns->messageto";
$messagedatetime = "$rs_result_qns->messagedatetime";
$messagedirection = "$rs_result_qns->messagedirection";

$messagefroms = preg_replace('/\D+/', '', $messagefrom);
$messagetos = preg_replace('/\D+/', '', $messageto);

$messagefromm8 = substr("$messagefroms", -8);
$messagetom8 = substr("$messagetos", -8);

if($messagedirection == "in") {
	if($messagefrom != "") {
		if(!array_key_exists("$messagefromm8", $recentnumbers)) {
			$recentnumbers[$messagefromm8]['number'] = "$messagefrom";
			$recentnumbers[$messagefromm8]['datetime'] = "$messagedatetime";
		}
	}
} else {
	if($messageto != "") {
		if(!array_key_exists("$messagetom8", $recentnumbers)) {
		$recentnumbers[$messagetom8]['number'] = "$messageto";
		$recentnumbers[$messagetom8]['datetime'] = "$messagedatetime";
		}
	}
}
}

$phnumberstripped = preg_replace('/\D+/', '', $phnumber);
$phnumberm8 = substr("$phnumberstripped", -8);


$breakout = 0;
foreach ($recentnumbers as $key=>&$value) {

$smsname = findsmsname($value['number']);

if ($smsname != "") {
$smsname2 = "$smsname<br>";
} else {
$smsname2 = "";
}

$smstime = pcrtdate("$pcrt_time", "$value[datetime]")." ".pcrtdate("$pcrt_shortdate", "$value[datetime]");
if($key == $phnumberm8) {
echo "<div class=linkbuttonmedium style=\"display:block;background:#0090ff;padding:5px 10px;border-radius:10px;\">";
echo "<table><tr><td style=\"padding:10px;\">";
if($smsname2 == "") {
echo "<i class=\"fa fa-user-circle fa-3x colormewhite\"></i>";
} else {
$firstletter = substr("$smsname2", 0,1);
echo "<span style=\"color:#0090ff;background:#ffffff;font-size:24px;font-weight:bold;border-radius:50%;padding:5px 13px\"> $firstletter </span>";
}
echo "</td><td><span class=\"sizeme16 boldme colormewhite\">$smsname2"."$value[number]</span><br><span class=colormewhite>$smstime</span></td></tr></table></div><br>";
} else {

$phnumber = trim($value['number']);

echo "<a href=\"messages.php?func=smschat&phnumber=$phnumber\" class=\"linkbuttonmedium linkbuttongray\" style=\"display:block;padding:5px 10px;border-radius:10px;\">";
echo "<table><tr><td style=\"padding:10px;\">";
if($smsname2 == "") {
echo "<i class=\"fa fa-user-circle fa-3x\"></i>";
} else {
$firstletter = substr("$smsname2", 0,1);
echo "<span style=\"background:#333333;color:#f1f1f1;font-size:24px;font-weight:bold;border-radius:50%;padding:5px 13px\"> $firstletter </span>";
}
echo "</td><td><span class=\"sizeme16 boldme\">$smsname2"."$value[number]</span><br>$smstime</td></tr></table></a><br>";
}

$breakout++;
if($breakout > 10) {
break;
}
}





##
#echo "<pre>";
#print_r($recentnumbers);
#echo "</pre>";
echo "</td></tr></table>";

}





?>
