<?php
                                                                                                    
/***************************************************************************
 *   copyright            : (C) 2020 PCRepairTracker.com
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

echo "<script type=\"text/javascript\">document.title = \"".pcrtlang("Messages")."\";</script>";

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

$numberstosearch = "";

foreach ($phnumbers as $key=>&$value) {
    if (strlen($value) < 7) {
        unset($phnumbers[$key]);
    }
}


reset($phnumbers);

foreach($phnumbers as $key => $val) {
$numberstosearch .= " OR messagefrom LIKE '%".substr("$val", -7)."'";
}

foreach($emailsexploded as $key => $val) {
if (filter_var($val, FILTER_VALIDATE_EMAIL)) {
$numberstosearch .= " OR messagefrom = '$val'";
}
}

if($woid != 0) {
$numberstosearch .= " OR woid = '$woid'";
}

foreach($searchworkorders as $key => $val) {
$numberstosearch .= " OR woid = '$val'";
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

start_box();

echo "<table style=\"width:100%\"><tr><td><span class=sizeme20>".pcrtlang("Messages")."</span></td>";

echo "<td style=\"text-align:right\"><a href=messages.php?func=smschat class=\"linkbuttongray linkbuttonmedium radiusall\"><i class=\"fa fa-mobile fa-lg\"></i> ".pcrtlang("SMS Chat")."</a>";
echo "</td></tr></table>";


if($woid != "0") {
echo "<br><a href=index.php?pcwo=$woid&scrollto=messages class=\"linkbuttonsmall linkbuttongray radiusall\">
<i class=\"fa fa-arrow-circle-left fa-lg\"></i> ".pcrtlang("Back to Work Order")."</a>";
}

if($pcid != "0") {
echo "<br><a href=pc.php?func=showpc&pcid=$pcid class=\"linkbuttonsmall linkbuttongray radiusall\">
<i class=\"fa fa-arrow-circle-left fa-lg\"></i> ".pcrtlang("Back to Asset #$pcid")."</a>";
}

stop_box();

echo "<br><table class=standard>";

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

$messagebody = wordwrap($messagebody, 100, "<br />\n", true);

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
echo "<tr><td><i class=\"fa fa-reply fa-lg colormeblue\"></i> $viaicon <span>$messagefrom</span> <br>";
echo "<i class=\"fa fa-clock-o fa-lg\"></i> <span>$messagedatetime</span> </td>";
echo "<td style=\"width:30%;vertical-align:top\"><div style=\"max-height:200px;overflow-y:auto;scrollbar-width:thin;\"><i class=\"fa fa-comment fa-lg\"></i> $messagebody</div>$imageatt</td><td>";
echo "</td>";
} elseif($messagedirection == "out") {
echo "<tr><td>$viaicon <i class=\"fa fa-share fa-lg\"></i> <span>$messagefrom</span> <br>";
echo "<i class=\"fa fa-clock-o fa-lg\"></i> <span>$messagedatetime</span> </td>";
echo "<td style=\"width:30%;vertical-align:top\"><div style=\"max-height:200px;overflow-y:auto;scrollbar-width:thin;\"><i class=\"fa fa-comment fa-lg\"></i> $messagebody</div>$imageatt</td><td>";
echo "</td>";
} else {
echo "<tr><td><i class=\"fa fa-user-md fa-lg\"></i> $viaicon <span>$messagefrom</span> <br>";
echo "<i class=\"fa fa-clock-o fa-lg\"></i> <span>$messagedatetime</span> </td>";
echo "<td style=\"width:30%;vertical-align:top\"><div style=\"max-height:200px;overflow-y:auto;scrollbar-width:thin;\"><i class=\"fa fa-comment fa-lg\"></i> $messagebody</div> </td><td>";
echo "</td>";
}

echo "<td>";

if(perm_check("33")) {
$requri = urlencode($_SERVER['REQUEST_URI']);
echo "<a href=\"messages.php?func=deletemessage&messageid=$messageid&requri=$requri\" 
class=\"linkbuttontiny linkbuttonred radiusall\" style=\"margin:3px;\" onClick=\"return confirm('".pcrtlang("Are you sure you want to delete this message?")."')\">";
echo "<i class=\"fa fa-times\"></i> ".pcrtlang("Delete Message")."</a><br>";
}

if($messagevia == "sms") {
if($messagedirection == "in") {
$thesmsnum = "$messagefrom";
} else {
$thesmsnum = "$messageto";
}
if($thesmsnum != "") {
echo "<a href=\"messages.php?func=smschat&phnumber=$thesmsnum\" class=\"linkbuttontiny linkbuttongray radiusall\" style=\"margin:3px;\">";
echo "<i class=\"fa fa-mobile\"></i> ".pcrtlang("SMS Chat")."</a><br>";
}
}

if($mwoid != 0) {
$rs_pfindpc = "SELECT * FROM pc_wo WHERE woid = '$mwoid'";
$rs_presult = mysqli_query($rs_connect, $rs_pfindpc);
$rs_presult_q = mysqli_fetch_object($rs_presult);
$fpcid = "$rs_presult_q->pcid";
$rs_findowner = "SELECT * FROM pc_owner WHERE pcid = '$fpcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
$rs_result_q2 = mysqli_fetch_object($rs_result2);
$fpcname = "$rs_result_q2->pcname";
echo "<a href=\"index.php?pcwo=$mwoid&scrollto=messages\" class=\"linkbuttontiny linkbuttongray radiusall\" style=\"margin:3px;\">";
echo "<i class=\"fa fa-clipboard fa-lg\"></i> $mwoid $fpcname</a><br>";
$foundmatch = "";
}

if($mgroupid != 0) {
$rs_findgname = "SELECT * FROM pc_group WHERE pcgroupid = '$mgroupid'";
$rs_findgname2 = @mysqli_query($rs_connect, $rs_findgname);
$rs_findgname3 = mysqli_fetch_object($rs_findgname2);
$pcgroupname = "$rs_findgname3->pcgroupname";
echo "<a href=\"group.php?func=viewgroup&pcgroupid=$mgroupid\" class=\"linkbuttontiny linkbuttongray radiusall\" style=\"margin:3px;\">";
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
echo "<a href=\"pc.php?func=showpc&pcid=$fpcid\" class=\"linkbuttontiny linkbuttongray radiusall\" style=\"margin:3px;\">";
echo "<i class=\"fa fa-user fa-lg\"></i> $fpcid $fpcname</a>";
echo "<a href=\"pc.php?func=returnpc2&pcid=$fpcid&merge_custcellphone=$thecell&merge_probdesc=$messagebody2\" class=\"linkbuttontiny linkbuttongray radiusall\" style=\"margin:1px;\">";
echo "<img src=\"images/new.png\" style=\"width:10px;\"></a><br>";

$foundmatch = "";

$rs_findpc = "SELECT * FROM pc_wo WHERE pcid = '$fpcid' AND pcstatus != '5' AND pcstatus != '7'";
$rs_result = mysqli_query($rs_connect, $rs_findpc);
while($rs_result_q = mysqli_fetch_object($rs_result)) {
$mwoid = "$rs_result_q->woid";
$pcstatus = "$rs_result_q->pcstatus";
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
$boxstyles = getboxstyle("$pcstatus");
echo "<i class=\"fa fa-bookmark fa-lg\" style=\"color:#$boxstyles[selectorcolor]\"></i><a href=\"index.php?pcwo=$mwoid\" class=\"linkbuttontiny linkbuttongray radiusall\" style=\"margin:3px;\">";
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
echo "<a href=\"group.php?func=viewgroup&pcgroupid=$fgid\" class=\"linkbuttontiny linkbuttonblack radiusall\" style=\"margin:3px;\">";
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
class=\"linkbuttontiny linkbuttongray radiusall\" style=\"margin:1px;\">";
echo "<img src=\"images/new.png\" style=\"width:10px;\"> ".pcrtlang("New Asset")."</a><br>";
#wip
echo "<a href=\"group.php?func=addtogroupnew&pcemail=$theemail&pccellphone=$thecell\"
class=\"linkbuttontiny linkbuttongray radiusall\" style=\"margin:1px;\">";
echo "<img src=\"images/groups.png\" style=\"width:10px;\"> ".pcrtlang("New Group")."</a><br>";
}


echo "</td></tr>";

}

echo "</table><br>";

if($totalentries != "0") {

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
}


require("footer.php");


}


function deletemessage() {
require_once("validate.php");
require("deps.php");
require("common.php");

$messageid = $_REQUEST['messageid'];
$requri = $_REQUEST['requri'];

if(perm_check("33")) {
$rs_del_message = "DELETE FROM messages WHERE messageid = '$messageid'";
@mysqli_query($rs_connect, $rs_del_message);
}

header("Location: $requri");
}


function markread() {
require_once("validate.php");
require("deps.php");
require("common.php");

$datetime = $_REQUEST['datetime'];

$rs_markread = "UPDATE users SET notifytime = '$datetime' WHERE username = '$ipofpc'";
@mysqli_query($rs_connect, $rs_markread);

echo "<i class=\"fa fa-thumbs-up fa-lg\"></i>";

}



function smschat() {

require("deps.php");
require_once("common.php");
require("header.php");


echo "<script type=\"text/javascript\">document.title = \"".pcrtlang("SMS Chat")."\";</script>";

if (array_key_exists('phnumber',$_REQUEST)) {
$phnumber = $_REQUEST['phnumber'];
$smsname = findsmsname($phnumber);
} else {
$phnumber = "";
$smsname = "SMS";
}

echo "<div class=\"colormewhite radiustop sizeme16 boldme\" style=\"padding:10px;background:#333333\">";
if($smsname != "") {
echo "$smsname";
echo "<script type=\"text/javascript\">document.title = \"".pcrtlang("SMS").": ".addslashes($smsname)."\";</script>";
} else {
echo "$phnumber";
echo "<script type=\"text/javascript\">document.title = \"".pcrtlang("SMS").": ".addslashes($phnumber)."\";</script>";
}


echo "</div><div style=\"background:#ffffff\">";
##############

echo "<table style=\"width:100%;border-collapse:collapse\"><tr><td style=\"width:70%;padding:10px 20px;\">";

if ($mysmsgateway != "none") {

start_box();

if($phnumber != "") {

echo "<form action=sms.php?func=smssend2 method=post id=smsform>";

echo "<input type=hidden name=smsnumber value=\"$phnumber\">";
echo "<input type=hidden name=singlemessage value=\"yes\">";


$storeinfoarray = getstoreinfo($defaultuserstore);

echo "<select name=myoptions onchange='document.getElementById(\"smsmessage\").value=this.options[this.selectedIndex].value' style=\"width:300px;\">";
$rs_ql = "SELECT * FROM smstext ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
echo "<option value=\"\">".pcrtlang("choose a message or write your own below")."</option>";
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$smstextid = "$rs_result_q1->smstextid";
$smstext = "$rs_result_q1->smstext";
$theorder = "$rs_result_q1->theorder";
if (strlen($smstext) > 80) {
$smstextshort = substr("$smstext", 0, 80)."...";
} else {
$smstextshort = $smstext;
}
echo "<option value=\"$smstext\">$smstextshort</option>";
}
echo "</select>";


echo "<textarea style=\"width:95%;height:25px;\" name=smsmessage id=smsmessage class=textbox name=smsbox></textarea>";

echo "<br><span class=colormegreen>".pcrtlang("Characters Remaining").": <span id=\"charsLeft\"></span></span>";


echo "<br><button type=submit class=\"linkbuttongray linkbuttonmedium radiusall\"><i class=\"fa fa-paper-plane fa-lg\"></i> ".pcrtlang("Send SMS")."</button>";

?>
<script src="jq/jquery.limit-1.2.js" type="text/javascript"></script>
<?php

if ($mysmsgateway == "smsglobal") {
?>
<script type="text/javascript">
$('#smsmessage').limit('600','#charsLeft');
</script>
<?php

} elseif ($mysmsgateway == "twilio") {
?>
<script type="text/javascript">
$('#smsmessage').limit('1600','#charsLeft');
</script>
<?php


} else {


?>
<script type="text/javascript">
$('#smsmessage').limit('150','#charsLeft');
</script>
<?php

}

echo "</form>";

#end form if no number
} else {
echo "<span class=\"sizeme16\">".pcrtlang("Please select a mobile SMS number")."</span> <i class=\"fa fa-chevron-right fa-lg\"></i>";
}

stop_box();

} else {
echo "<i class=\"fa fa-warning fa-lg colormered\"></i> ".pcrtlang("No SMS Gateway Service Configured")."...";
}

$theform = "<form action=messages.php?func=smschat method=post>";
$theform .= "<input type=text name=phnumber id=autosmssearchbox class=textbox placeholder=\"".pcrtlang("Enter Contact Name")."\">";
$theform .= "<div id=\"autosmssearch\"></div>";
$theform .= "<button class=\"button\" type=submit><i class=\"fa fa-mobile fa-lg\"></i> ".pcrtlang("Switch SMS Number")."</button>";
$theform .= "</form>";

echo "</td><td style=\"text-align:center;padding:10px 20px;background:#333333\">";
start_box();
echo "<table><tr><td style=\"padding:20px;\"><i class=\"fa fa-mobile fa-3x\"></i></td><td>";
echo "$theform";
stop_box();
echo "</td></tr></table></td></tr></table>";

?>
<script type='text/javascript'>
$(document).ready(function(){
$('#smsform').submit(function(e) { // catch the form's submit event
        e.preventDefault();
        $.ajax({ // create an AJAX call...
        data: $(this).serialize(), // get the form data
        type: $(this).attr('method'), // GET or POST
        url: $(this).attr('action'), // the file to call
        success: function(response) { // on success..
            $('#messagearea').html(response); // update the DIV
        $('#smsform').each (function(){
          this.reset();
        });
        $('#messagesdiv').slideToggle(1000, function() {
        });
    }
    });
});
});

$(document).ready(function () {
        setInterval(function() {
                $.get('sms.php?func=smsloadsinglenumber&phnumber=<?php echo "$phnumber"; ?>', function(data) {
                $('#messagearea').html(data);
                });
        }, 60000);
});

$(document).ready(function(){
  $("input#autosmssearchbox").keyup(function(){
    if(this.value.length<3) {
      $("div#autosmssearch").slideUp(200,function(){
        return false;
      });
    }else{
        var encodedinv = encodeURIComponent(this.value);
        $('div#autosmssearch').load('autosearch.php?func=sms&search='+encodedinv).slideDown(200);
    }
  });
});


</script>
<?php

require_once("ajaxcalls.php");
echo "<div id=messagearea>";
displaymessagessinglenumber("$phnumber");
echo "</div>";

stop_blue_box();

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

case "deletemessage":
    deletemessage();
    break;

case "markread":
    markread();
    break;

case "smschat":
    smschat();
    break;


}
