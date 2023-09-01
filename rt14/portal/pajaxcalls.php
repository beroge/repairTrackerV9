<?php

function displaymessages() {

require("deps.php");
require_once("common.php");


$phnumbers = array();
$emails = array();
$numberstosearch2 = "";

$rs_pull_group = "SELECT * FROM pc_group WHERE pcgroupid = '$portalgroupid'";
$rs_pull_groupq = @mysqli_query($rs_connect, $rs_pull_group);
while ($rs_resultgroup_q = mysqli_fetch_object($rs_pull_groupq)) {
$phnumbers[] = "$rs_resultgroup_q->grpphone";
$phnumbers[] = "$rs_resultgroup_q->grpcellphone";
$phnumbers[] = "$rs_resultgroup_q->grpworkphone";
$grpemail = "$rs_resultgroup_q->grpemail";
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

foreach ($phnumbers as $key=>&$value) {
    if (strlen($value) < 7) {
        unset($phnumbers[$key]);
    }
}

reset($phnumbers);

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

$phnumbers = array_filter($phnumbers);

$numberstosearch = "";

foreach($phnumbers as $key => $val) {
$numberstosearch .= " OR  TRIM(REPLACE(REPLACE(messagefrom,'-',''),' ',''))  LIKE '%".substr("$val", -7)."'";
}

foreach($emails as $key => $val) {
$numberstosearch .= " OR messagefrom = '$val'";
}


$rs_findmessages = "SELECT * FROM messages WHERE (messagevia = 'im' OR messagevia = 'sms' OR messagevia = 'email') AND (1=2 $numberstosearch $numberstosearch2 
OR groupid = '$portalgroupid') ORDER BY messagedatetime DESC LIMIT 8";

$rs_result_n = mysqli_query($rs_connect, $rs_findmessages);

echo "<br><table id=messagestable class=\"table table-striped table-condensed\">";
echo "<thead><tr><th>".pcrtlang("From")."</th><th>".pcrtlang("Time")."</th><th>".pcrtlang("Message")."</th></tr></thead><tbody>";

while($rs_result_qn = mysqli_fetch_object($rs_result_n)) {
$messageid = "$rs_result_qn->messageid";
$messagebody = "$rs_result_qn->messagebody";
$messagefrom = "$rs_result_qn->messagefrom";
$messagevia = "$rs_result_qn->messagevia";
$messagedatetime2 = "$rs_result_qn->messagedatetime";

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
echo "<tr><td><i class=\"fa fa-reply fa-lg fa-fw colormeblue\"></i> $viaicon <span>$messagefrom</span> </td>";
echo "<td><i class=\"fa fa-clock-o fa-lg\"></i> <span>$messagedatetime</span> </td>";
echo "<td style=\"width:60%\"><div class=showmoreless><i class=\"fa fa-comment fa-lg\"></i> $messagebody</div> </td>";
echo "</tr>";
} elseif($messagedirection == "out") {
echo "<tr><td>$viaicon <i class=\"fa fa-share fa-fw fa-lg\"></i> <span>$messagefrom</span> </td>";
echo "<td><i class=\"fa fa-clock-o fa-lg\"></i> <span>$messagedatetime</span> </td>";
echo "<td style=\"width:60%\"><div class=showmoreless><i class=\"fa fa-comment fa-lg\"></i> $messagebody</div> </td>";
echo "</tr>";
} else {
echo "<tr><td><i class=\"fa fa-user-md fa-fw fa-lg\"></i> <span>$messagefrom</span> </td>";
echo "<td><i class=\"fa fa-clock-o fa-lg\"></i> <span>$messagedatetime</span> </td>";
echo "<td style=\"width:60%\"><div class=showmoreless><i class=\"fa fa-comment fa-lg\"></i> $messagebody</div> </td>";
echo "</tr>";
}

}

echo "</tbody></table>";

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

}



##############################################################
