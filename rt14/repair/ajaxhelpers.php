<?php

/***************************************************************************
 *   copyright            : (C) 2021 PCRepairTracker.com
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
}



function refreshnotifications() {
require("deps.php");
require_once("common.php");
echo pcrtnotifynew();
}


function otherworkorderinfo() {
require("deps.php");
require_once("common.php");

$pcwo = $_REQUEST['pcwo'];

$rs_findpc = "SELECT * FROM pc_wo WHERE woid = '$pcwo'";
$rs_result = mysqli_query($rs_connect, $rs_findpc);

$rs_result_q = mysqli_fetch_object($rs_result);
$pcid = "$rs_result_q->pcid";
$probdesc = "$rs_result_q->probdesc";
$dropoff = "$rs_result_q->dropdate";
$pickup = "$rs_result_q->pickupdate";
$pcstatus = "$rs_result_q->pcstatus";
$called = "$rs_result_q->called";
$custassetsindb2 = "$rs_result_q->custassets";
$pcwa = "$rs_result_q->workarea";
$pcpriorityindb = "$rs_result_q->pcpriority";
$cibyuser = "$rs_result_q->cibyuser";
$theprobsindb2 = "$rs_result_q->commonproblems";
$wostoreid = "$rs_result_q->storeid";
$assigneduser = "$rs_result_q->assigneduser";
$skeddate = "$rs_result_q->skeddate";
$sked = "$rs_result_q->sked";
$slid = "$rs_result_q->slid";
$wochecks = "$rs_result_q->wochecks";
$servicepromiseid = "$rs_result_q->servicepromiseid";
$promisedtime = "$rs_result_q->promisedtime";

$rs_findowner = "SELECT * FROM pc_owner WHERE pcid = '$pcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
$rs_result_q2 = mysqli_fetch_object($rs_result2);
$pcname = "$rs_result_q2->pcname";
$pccompany = "$rs_result_q2->pccompany";
$pcphone = "$rs_result_q2->pcphone";
$pcmake = "$rs_result_q2->pcmake";
$pcemail = "$rs_result_q2->pcemail";
$pcaddress = "$rs_result_q2->pcaddress";
$pccellphone = "$rs_result_q2->pccellphone";
$pcworkphone = "$rs_result_q2->pcworkphone";
$pcaddress2 = "$rs_result_q2->pcaddress2";
$pccity = "$rs_result_q2->pccity";
$pcstate = "$rs_result_q2->pcstate";
$pczip = "$rs_result_q2->pczip";
$pcextra = "$rs_result_q2->pcextra";
$pcgroupid = "$rs_result_q2->pcgroupid";
$custsourceid = "$rs_result_q2->custsourceid";
$prefcontact = "$rs_result_q2->prefcontact";
$pcnotes = nl2br($rs_result_q2->pcnotes);
$mainassettypeidindb = "$rs_result_q2->mainassettypeid";
$scid = "$rs_result_q2->scid";
$scpriceid = "$rs_result_q2->scpriceid";
$pcownertags = "$rs_result_q2->tags";

$storeinfoarray = getstoreinfo($wostoreid);

$rs_qce = "SELECT actionid FROM userlog WHERE reftype = 'woid' AND refid = '$pcwo'";
$rs_resultce1 = mysqli_query($rs_connect, $rs_qce);
$actionids = array();
while($rs_result_qce1 = mysqli_fetch_object($rs_resultce1)) {
$actionids[] = "$rs_result_qce1->actionid";
}

?>
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



if ($gomodal == 1) {
$therel = "rel=facebox";
} else {
$therel = "";
}


echo "<table class=standard>";

echo "<tr><td style=\"width:33%;\">".pcrtlang("Assign to User").":</td><td>";
$rs_find_users = "SELECT * FROM users";
$rs_result_users = mysqli_query($rs_connect, $rs_find_users);
echo "<form action=pc.php?func=reassignuser&woid=$pcwo method=post id=reassignuser><select name=user>";

if($assigneduser == "") {
echo "<option selected value=\"\">".pcrtlang("No Assigned User")."</option>";
} else {
echo "<option value=\"\">".pcrtlang("No Assigned User")."</option>";
}

while($rs_result_uq = mysqli_fetch_object($rs_result_users)) {
$rs_uname = "$rs_result_uq->username";

if($rs_uname == "$assigneduser") {
echo "<option selected value=$rs_uname selected>$rs_uname</option>";
} else {
echo "<option value=$rs_uname>$rs_uname</option>";
}
}

echo "</select></form></td></tr>";

?>
<script type='text/javascript'>
$(document).ready(function(){
$('#reassignuser').change(function(e) {
        e.preventDefault();
        $.ajax({
        data: $(this).serialize(), // get the form data
        type: $(this).attr('method'), // GET or POST
        url: $(this).attr('action'), // the file to call
        success: function(response) {
		$.get('ajaxhelpers.php?func=otherworkorderinfo&pcwo=<?php echo "$pcwo"; ?>', function(data) {
                $('#otherworkorderinfo').html(data);
                });
	}
    });
});
});
</script>
<?php


if ($assigneduser != "") {
echo "<tr><td>".pcrtlang("Assigned To").": </td><td><strong>$assigneduser</strong>";
echo "&nbsp;&nbsp;&nbsp;<span class=\"linkbuttonsmall linkbuttongraylabel radiusleft\">".pcrtlang("Renotify?")."</span><a href=pc.php?func=worenotify&woid=$pcwo&notifyuseremail=yes class=\"renotify linkbuttonsmall linkbuttongray\">".pcrtlang("email")."</a><a href=pc.php?func=worenotify&woid=$pcwo&notifyusersms=yes class=\"renotify linkbuttonsmall linkbuttongray\">".pcrtlang("sms")."</a><a href=pc.php?func=worenotify&woid=$pcwo&notifyuseremail=yes&notifyusersms=yes class=\"renotify linkbuttonsmall linkbuttongray radiusright\">".pcrtlang("both")."</a> <span id=renotifyspinner style=\"display:none\" class=\"linkbuttonsmall linkbuttongraylabel radiusall\"><i class=\"fa fa-spinner fa-spin fa-lg\"></i></span>";
echo "</td></tr>";
}

?>
<script type="text/javascript">
$(document).ready(function(){
$('.renotify').on('click', function (e) {
                e.preventDefault();
		$('#renotifyspinner').toggle();
                var url = $(this).attr('href');
                $.get(url, function () {
                $.get('ajaxhelpers.php?func=otherworkorderinfo&pcwo=<?php echo "$pcwo"; ?>', function(data) {
                $('#otherworkorderinfo').html(data);
                });
                });
                });
});
</script>
<?php

$pickdate = pcrtdate("$pcrt_mediumdate", "$pickup")." ".pcrtdate("$pcrt_time", "$pickup");
$dropdate = pcrtdate("$pcrt_mediumdate", "$dropoff")." ".pcrtdate("$pcrt_time", "$dropoff");


if ($activestorecount > "1") {
echo "<tr><td>".pcrtlang("Store").": </td><td><strong>$storeinfoarray[storesname]</strong></td></tr>";
}


if ($pickup != "0000-00-00 00:00:00") {
echo "<tr><td>".pcrtlang("Closed On").": </td><td><strong>$pickdate</strong>";
if ((time() - strtotime($pickup)) < 1209600) {
echo " <a href=pc.php?func=reopenwo&woid=$pcwo class=\"linkbuttonsmall linkbuttongray radiusall floatright\" style=\"padding:3px;\"><i class=\"fa fa-undo\"></i> ".pcrtlang("re-open")."</a>";
}
echo "</td></tr>";
}


if (in_array(23, $actionids)) {

$totalcustchecks = count(array_keys($actionids, 23));


$checkcustlooklast = "SELECT thedatetime FROM userlog WHERE actionid = '23' AND refid = '$pcwo' ORDER BY thedatetime DESC LIMIT 1";
$checkcustlookqlast = mysqli_query($rs_connect, $checkcustlooklast);
$custlookfetch = mysqli_fetch_object($checkcustlookqlast);
$lasttime = "$custlookfetch->thedatetime";

$lasttimef = pcrtdate("$pcrt_mediumdate", "$lasttime")." ".pcrtdate("$pcrt_time", "$lasttime");

$thetimes = ($totalcustchecks > 1 ? "times" : "time");

echo "<tr><td><strong>".pcrtlang("Customer Status Check").": </strong></td><td><span class=\"colormered boldme\"><i class=\"fa fa-eye fa-lg\"></i> $totalcustchecks $thetimes</span><br>".pcrtlang("Last Check").": $lasttimef</td></tr>";

}



echo "<tr><td>".pcrtlang("Priority").": </td><td>";

if (($pcpriorityindb == "") || (!array_key_exists($pcpriorityindb, $pcpriority))) {
$pcpriorityindb = "Not Set";
}


if ($pcpriorityindb != "Not Set") {
$icon = $pcpriority[$pcpriorityindb];
} else {
$icon = "";
}
if($icon != "") {
echo "<img src=images/$icon class=menuicon>&nbsp;&nbsp;&nbsp;";
} else {
echo "<i class=\"fa fa-hourglass fa-2x vam fa-fw\"></i>&nbsp;&nbsp;&nbsp;";
}
echo pcrtlang("$pcpriorityindb");

echo "&nbsp;&nbsp;&nbsp;<a href=\"javascript:void(0);\" class=\"linkbuttonsmall linkbuttongray radiusall floatright\" id=prioritychange><i class=\"fa fa-chevron-down\"></i></a>";


echo "<div id=priorityselectorbox style=\"display:none;\"><br>";
foreach($pcpriority as $key => $val) {
if("$pcpriorityindb" != "$key") {
$key2 = urlencode($key);
echo " <a href=pc.php?func=setpriority&woid=$pcwo&setpriority=$key2 class=\"menulinksm prioritychange\" style=\"display:block;\">";
if($val != "") {
echo "<img src=images/$val class=menuicon>";
}
echo " ".pcrtlang("$key")."</a>";
}
}

if ($pcpriorityindb != "Not Set") {
echo "<a href=\"pc.php?func=setpriority&woid=$pcwo&setpriority=\" class=\"menulinksm prioritychange\" style=\"display:block;\"><img src=images/del.png class=menuicon style=\"width:20px;\"> ".pcrtlang("Unset Priority")."</a>";
}
echo "</div>";

?>
<script type="text/javascript">
$(document).ready(function(){
$('.prioritychange').on('click', function (e) {
                e.preventDefault();
		 $('.ajaxspinner').toggle();
                var url = $(this).attr('href');
                $.get(url, function () {
                $.get('ajaxhelpers.php?func=otherworkorderinfo&pcwo=<?php echo "$pcwo"; ?>', function(data) {
                $('#otherworkorderinfo').html(data);
                });
		 $('.ajaxspinner').toggle();
                });
                });
});
</script>

<script type='text/javascript'>
$('#prioritychange').click(function(){
  $('#priorityselectorbox').toggle('1000');
  $("i",this).toggleClass("fa-chevron-up fa-chevron-down");
});
</script>
<?php
echo "</td></tr>";


echo "<tr><td>".pcrtlang("Call/Contact Status for Pickup/Collection").": </td><td>";

if ($called == 1) {
$calledtext = pcrtlang("Not Called");
$calledicon = "<i class=\"fa fa-phone-square fa-2x fa-fw colormered\"></i>";
} elseif ($called == 2){
$calledtext = pcrtlang("Called");
$calledicon = "<i class=\"fa fa-phone-square fa-2x fa-fw colormegreen\"></i>";
} elseif  ($called == 3){
$calledtext = pcrtlang("Called - No Answer");
$calledicon = "<i class=\"fa fa-phone-square fa-2x fa-fw colormeyellow\"></i>";
} elseif  ($called == 7){
$calledtext = pcrtlang("Called - Left Voice Message");
$calledicon = "<i class=\"fa fa-phone-square fa-2x fa-fw colormegreen\"></i>";
} elseif  ($called == 5){
$calledtext = pcrtlang("Sent SMS");
$calledtext = pcrtlang("Sent SMS");
$calledicon = "<i class=\"fa fa-mobile fa-2x fa-fw colormegreen vam\"></i>";
} elseif  ($called == 6){
$calledtext = pcrtlang("Sent Email");
$calledicon = "<i class=\"fa fa-envelope fa-2x fa-fw colormegreen\"></i>";
} else {
$calledtext = pcrtlang("Called - Waiting for Call Back");
$calledicon = "<i class=\"fa fa-phone-square fa-2x fa-fw colormeblue\"></i>";
}


echo "$calledicon <strong>$calledtext</strong>";

echo "&nbsp;&nbsp;&nbsp;<a href=\"javascript:void(0);\" class=\"linkbuttonsmall linkbuttongray radiusall floatright\" id=callstatuschange><i class=\"fa fa-chevron-down\"></i></a>";

echo "<div id=callstatusselectorbox style=\"display:none;\"><br>";
echo "<a href=pc.php?func=precalled&woid=$pcwo&status=1 class=menulinksm rel=facebox><i class=\"fa fa-phone-square fa-2x fa-fw colormered vam\"></i> ".pcrtlang("Not Called")."</a>";
echo "<a href=pc.php?func=precalled&woid=$pcwo&status=2 class=menulinksm rel=facebox><i class=\"fa fa-phone-square fa-2x fa-fw colormegreen vam\"></i> ".pcrtlang("Called")."</a>";
echo "<a href=pc.php?func=precalled&woid=$pcwo&status=7 class=menulinksm rel=facebox><i class=\"fa fa-phone-square fa-2x fa-fw colormegreen vam\"></i> ".pcrtlang("Left Voice Message")."</a>";
echo "<a href=pc.php?func=precalled&woid=$pcwo&status=5 class=menulinksm rel=facebox><i class=\"fa fa-mobile fa-2x fa-fw colormegreen vam\"></i> ".pcrtlang("Sent SMS")."</a>";
echo "<a href=pc.php?func=precalled&woid=$pcwo&status=6 class=menulinksm rel=facebox><i class=\"fa fa-envelope fa-2x fa-fw colormegreen vam\"></i> ".pcrtlang("Sent Email")."</a>";
echo "<a href=pc.php?func=precalled&woid=$pcwo&status=3 class=menulinksm rel=facebox><i class=\"fa fa-phone-square fa-2x fa-fw colormeyellow vam\"></i> ".pcrtlang("No Answer")."</a>";
echo "<a href=pc.php?func=precalled&woid=$pcwo&status=4 class=menulinksm rel=facebox><i class=\"fa fa-phone-square fa-2x fa-fw colormeblue vam\"></i> ".pcrtlang("Awaiting Call Back")."</a>";
echo "</div>";

?>
<script type='text/javascript'>
$('#callstatuschange').click(function(){
  $('#callstatusselectorbox').toggle('1000');
  $("i",this).toggleClass("fa-chevron-up fa-chevron-down");
});
</script>
<?php


echo "</td></tr>";


if($slid != 0) {
$rs_sls = "SELECT * FROM storagelocations WHERE slid = '$slid'";
$rs_result1s = mysqli_query($rs_connect, $rs_sls);
if(mysqli_num_rows($rs_result1s) != 0) {
$rs_result_q1s = mysqli_fetch_object($rs_result1s);
$slnames = "$rs_result_q1s->slname";
} else {
$slnames = pcrtlang("Not Set");
}
} else {
$slnames = pcrtlang("Not Set");
}



echo "<tr><td>".pcrtlang("Storage Location").":</td><td><i class=\"fa fa-archive fa-2x fa-fw vam\"></i>&nbsp;&nbsp;&nbsp;$slnames";
echo "<a href=\"javascript:void(0);\" class=\"linkbuttonsmall linkbuttongray radiusall floatright\" id=storagechange><i class=\"fa fa-chevron-down\"></i></a>";

echo "<div id=storageselectorbox style=\"display:none;\"><br>";

$rs_sl = "SELECT * FROM storagelocations ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_sl);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$slidtoset = "$rs_result_q1->slid";
$slname = "$rs_result_q1->slname";
$theorder = "$rs_result_q1->theorder";
if($slid != $slidtoset) {
echo "<a href=pc.php?func=setsl&woid=$pcwo&slid=$slidtoset  class=\"linkbuttonsmall linkbuttongray radiusall floatright setstoragelocation\" style=\"margin:3px;\">$slname</a>";
}
}
if($slid != "0") {
echo "<a href=pc.php?func=setsl&woid=$pcwo&slid=0  class=\"linkbuttonsmall linkbuttonred radiusall floatright setstoragelocation\" style=\"margin:3px;\">".pcrtlang("Unset")."</a>";
}

echo "</div>";


?>

<script type="text/javascript">
$(document).ready(function(){
$('.setstoragelocation').on('click', function (e) {
                e.preventDefault();
		 $('.ajaxspinner').toggle();
                var url = $(this).attr('href');
                $.get(url, function () {
                $.get('ajaxhelpers.php?func=otherworkorderinfo&pcwo=<?php echo "$pcwo"; ?>', function(data) {
                $('#otherworkorderinfo').html(data);
                });
		 $('.ajaxspinner').toggle();
                });
                });
});
</script>


<script type='text/javascript'>
$('#storagechange').click(function(){
  $('#storageselectorbox').toggle('1000');
  $("i",this).toggleClass("fa-chevron-up fa-chevron-down");
});
</script>
<?php

echo "</td></tr>";

#################################################################

$rs_findstatii = "SELECT * FROM boxstyles ORDER BY displayedorder ASC";
$rs_result_st = mysqli_query($rs_connect, $rs_findstatii);
while($rs_result_stq = mysqli_fetch_object($rs_result_st)) {
$statusoptions[$rs_result_stq->statusid] = serializedarraytest("$rs_result_stq->statusoptions");
}

if (is_array($statusoptions[$pcstatus])) {
if (in_array("workbench", $statusoptions[$pcstatus])) {

echo "<tr><td>".pcrtlang("Workarea").":</td><td>";

$storeworkareas = array();

$rs_ql = "SELECT * FROM benches WHERE storeid = '$wostoreid'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);

if(mysqli_num_rows($rs_result1) != 0) {

while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$benchid = "$rs_result_q1->benchid";
$benchname = "$rs_result_q1->benchname";
$benchcolor = "$rs_result_q1->benchcolor";
$storeworkareas[$benchname] = $benchcolor;
}


if ($pcwa != "") {
$wacolor = "$storeworkareas[$pcwa]";
$watitle = "$pcwa";
} else {
$wacolor = "f1f1f1";
$watitle = pcrtlang("Unassigned");
}

echo "<a href=\"javascript:void(0);\" class=\"linkbuttonmedium linkbuttongray radiusall\" id=workareachange><i class=\"fa fa-plug fa-lg\" style=\"color:#$wacolor\"></i> $watitle <i class=\"fa fa-chevron-down fa-lg\"></i></a> <span id=workareaspinner style=\"display:none\" class=\"linkbuttonsmall linkbuttongraylabel radiusall\"><i class=\"fa fa-spinner fa-spin fa-lg\"></i></span>";

echo "<div id=workareaselectorbox style=\"display:none;\">";

if ($pcwa != "") {
echo "<a href=\"pc.php?func=changewa&woid=$pcwo&workarea=\" class=\"changeworkarea linkbuttonmedium linkbuttongray displayblock\">
<i class=\"fa fa-plug fa-lg\" style=\"color:$wacolor\"></i> ".pcrtlang("Not Assigned")."</a>";
}
foreach($storeworkareas as $key => $val) {
if ($key == "$pcwa") {
echo "<a href=\"pc.php?func=changewa&woid=$pcwo&workarea=$key\" class=\"changeworkarea linkbuttonmedium linkbuttongray displayblock\">
<i class=\"fa fa-plug fa-lg\" style=\"color:#$storeworkareas[$key]\"></i> $key</a>";
} else {
echo "<a href=\"pc.php?func=changewa&woid=$pcwo&workarea=$key\" class=\"changeworkarea linkbuttonmedium linkbuttongray displayblock\">
<i class=\"fa fa-plug fa-lg\" style=\"color:#$storeworkareas[$key]\"></i> $key</a>";
}
}


echo "</div>";

?>
<script type="text/javascript">
$(document).ready(function(){
$('.changeworkarea').on('click', function (e) {
                e.preventDefault();
		 $('.ajaxspinner').toggle();
                var url = $(this).attr('href');
                $.get(url, function () {
                $.get('ajaxhelpers.php?func=otherworkorderinfo&pcwo=<?php echo "$pcwo"; ?>', function(data) {
                $('#otherworkorderinfo').html(data);
                });
                $.get('sidemenu.php', function(data) {
                $('#sidemenu').html(data);
                });
		 $('.ajaxspinner').toggle();
                });
                });
});
</script>

<script type='text/javascript'>
$('#workareachange').click(function(){
  $('#workareaselectorbox').toggle('1000');
  $("i",this).toggleClass("fa-chevron-up fa-chevron-down");
});
</script>
<?php

}
}
echo "</td></tr>";
}


echo "</table>";

}



##################################################################################################

function cartitemsandinvoices() {
require("deps.php");
require_once("common.php");

$pcwo = $_REQUEST['pcwo'];

$rs_findpc = "SELECT * FROM pc_wo WHERE woid = '$pcwo'";
$rs_result = mysqli_query($rs_connect, $rs_findpc);

$rs_result_q = mysqli_fetch_object($rs_result);
$pcid = "$rs_result_q->pcid";
$probdesc = "$rs_result_q->probdesc";
$dropoff = "$rs_result_q->dropdate";
$pickup = "$rs_result_q->pickupdate";
$pcstatus = "$rs_result_q->pcstatus";
$called = "$rs_result_q->called";
$custassetsindb2 = "$rs_result_q->custassets";
$pcwa = "$rs_result_q->workarea";
$pcpriorityindb = "$rs_result_q->pcpriority";
$cibyuser = "$rs_result_q->cibyuser";
$theprobsindb2 = "$rs_result_q->commonproblems";
$wostoreid = "$rs_result_q->storeid";
$assigneduser = "$rs_result_q->assigneduser";
$skeddate = "$rs_result_q->skeddate";
$sked = "$rs_result_q->sked";
$slid = "$rs_result_q->slid";
$wochecks = "$rs_result_q->wochecks";
$servicepromiseid = "$rs_result_q->servicepromiseid";
$promisedtime = "$rs_result_q->promisedtime";

$rs_findowner = "SELECT * FROM pc_owner WHERE pcid = '$pcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
$rs_result_q2 = mysqli_fetch_object($rs_result2);
$pcname = "$rs_result_q2->pcname";
$pccompany = "$rs_result_q2->pccompany";
$pcphone = "$rs_result_q2->pcphone";
$pcmake = "$rs_result_q2->pcmake";
$pcemail = "$rs_result_q2->pcemail";
$pcaddress = "$rs_result_q2->pcaddress";
$pccellphone = "$rs_result_q2->pccellphone";
$pcworkphone = "$rs_result_q2->pcworkphone";
$pcaddress2 = "$rs_result_q2->pcaddress2";
$pccity = "$rs_result_q2->pccity";
$pcstate = "$rs_result_q2->pcstate";
$pczip = "$rs_result_q2->pczip";
$pcextra = "$rs_result_q2->pcextra";
$pcgroupid = "$rs_result_q2->pcgroupid";
$custsourceid = "$rs_result_q2->custsourceid";
$prefcontact = "$rs_result_q2->prefcontact";
$pcnotes = nl2br($rs_result_q2->pcnotes);
$mainassettypeidindb = "$rs_result_q2->mainassettypeid";
$scid = "$rs_result_q2->scid";
$scpriceid = "$rs_result_q2->scpriceid";
$pcownertags = "$rs_result_q2->tags";


$pcname2 = urlencode($pcname);
$pccompany2 = urlencode($pccompany);
$pcaddress12 = urlencode($pcaddress);
$pcaddress22 = urlencode($pcaddress2);
$pccity2 = urlencode($pccity);
$pcstate2 = urlencode($pcstate);
$pczip2 = urlencode($pczip);
$pcemail2 = urlencode($pcemail);
$pcmake2 = urlencode($pcmake);
$pchomephone2 = urlencode($pcphone);
$pccellphone2 = urlencode($pccellphone);
$pcworkphone2 = urlencode($pcworkphone);

if($prefcontact == "home") {
$pcphone2 = urlencode($pcphone);
} else if ($prefcontact == "mobile") {
$pcphone2 = urlencode($pccellphone);
} else if ($prefcontact == "work") {
$pcphone2 = urlencode($pcworkphone);
} else {
if($pcphone != "") {
$pcphone2 = urlencode($pcphone);
} else if ($pccellphone != "") {
$pcphone2 = urlencode($pccellphone);
} else {
$pcphone2 = urlencode($pcworkphone);
}
}



if($pcgroupid != "0") {
$rs_findgname = "SELECT * FROM pc_group WHERE pcgroupid = '$pcgroupid'";
$rs_findgname2 = @mysqli_query($rs_connect, $rs_findgname);
$rs_findgname3 = mysqli_fetch_object($rs_findgname2);
$pcgroupname = "$rs_findgname3->pcgroupname";
$grpcompany = "$rs_findgname3->grpcompany";
$grpphone = "$rs_findgname3->grpphone";
$grpcellphone = "$rs_findgname3->grpcellphone";
$grpworkphone = "$rs_findgname3->grpworkphone";
$grpaddress = "$rs_findgname3->grpaddress1";
$grpaddress2 = "$rs_findgname3->grpaddress2";
$grpcity = "$rs_findgname3->grpcity";
$grpstate = "$rs_findgname3->grpstate";
$grpzip = "$rs_findgname3->grpzip";
$grpemail = "$rs_findgname3->grpemail";
$grpnotes = nl2br("$rs_findgname3->grpnotes");

$ue_pcgroupname = urlencode($pcgroupname);
$ue_grpcompany = urlencode($grpcompany);
$ue_grpphone = urlencode($grpphone);
$ue_grpcellphone = urlencode($grpcellphone);
$ue_grpworkphone = urlencode($grpworkphone );
$ue_grpaddress = urlencode($grpaddress);
$ue_grpaddress2 = urlencode($grpaddress2);
$ue_grpcity = urlencode($grpcity);
$ue_grpstate = urlencode($grpstate);
$ue_grpzip = urlencode($grpzip);
$ue_grpemail = urlencode($grpemail);

######

}



$storeinfoarray = getstoreinfo($wostoreid);

$rs_qce = "SELECT actionid FROM userlog WHERE reftype = 'woid' AND refid = '$pcwo'";
$rs_resultce1 = mysqli_query($rs_connect, $rs_qce);
$actionids = array();
while($rs_result_qce1 = mysqli_fetch_object($rs_resultce1)) {
$actionids[] = "$rs_result_qce1->actionid";
}

?>
  <script type="text/javascript">
    jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        loadingImage : 'jq/loading.gif',
        closeImage : 'jq/closelabel.png'
      })
    })
  </script>
<?php

if ($gomodal == 1) {
$therel = "rel=facebox";
} else {
$therel = "";
}

$rs_find_items = "SELECT * FROM repaircart WHERE pcwo = '$pcwo' ORDER BY addtime ASC";
$rs_find_result = mysqli_query($rs_connect, $rs_find_items);
$rs_chargewhatcount = mysqli_num_rows($rs_find_result);
$rs_findsinv_t = "SELECT * FROM invoices WHERE woid = '$pcwo' AND invstatus != '3'";
$rs_findsinv2_t = @mysqli_query($rs_connect, $rs_findsinv_t);
$rs_invoicecount = mysqli_num_rows($rs_findsinv2_t);
$invoicelist = array();

if (($rs_chargewhatcount != 0) || ($rs_invoicecount != 0)) {

echo "<table style=\"width:100%;box-sizing:border-box;\"><tr><td style=\"width:45%; vertical-align:top; \">";
echo "<span class=\"colormemoney sizemelarge boldme\">&nbsp;".pcrtlang("Repair Cart")."&nbsp;</span><br><br>";

echo "<table class=\"moneylist lastalignright3\">";

echo "<tr><th colspan=4>".pcrtlang("Cart Items");

if($rs_chargewhatcount != 0) {
echo "<span class=floatright><a href=\"confirm.php?url=".urlencode("repcart.php?func=emptycart&woid=$pcwo")."&divload=repaircartitemsandinvoices&divloadcontentlink=".urlencode("ajaxhelpers.php?func=cartitemsandinvoices&pcwo=$pcwo")."&question=".urlencode("Are you sure you wish to empty the cart?")."\" rel=facebox class=\"linkbuttonmoney linkbuttontiny radiusall\"><i class=\"fa fa-trash\"></i> ".pcrtlang("Empty Cart")."</a></span>";
}
echo "</th></tr>";
echo "<tr><td class=subhead>".pcrtlang("Description")."</td><td class=subhead>".pcrtlang("Qty")."</td><td class=subhead>".pcrtlang("Unit")."</td><td class=\"subhead\" style=\"text-align:right;\">".pcrtlang("Total")."</td></tr>";

while($rs_find_result_q = mysqli_fetch_object($rs_find_result)) {
$rs_stock_id = "$rs_find_result_q->cart_stock_id";
$cart_item_id = "$rs_find_result_q->cart_item_id";
$rs_cart_price = "$rs_find_result_q->cart_price";
$rs_labor_desc = "$rs_find_result_q->labor_desc";
$rs_labor_pdesc = "$rs_find_result_q->printdesc";
$rs_cart_type = "$rs_find_result_q->cart_type";
$rs_taxex = "$rs_find_result_q->taxex";
$rs_cart_addtime = "$rs_find_result_q->addtime";
$rs_itemserial = "$rs_find_result_q->itemserial";
$price_alt = "$rs_find_result_q->price_alt";
$origprice = mf("$rs_find_result_q->origprice");
$ourprice = "$rs_find_result_q->ourprice";
$unit_price = "$rs_find_result_q->unit_price";
$quantity = "$rs_find_result_q->quantity";
$discountname = "$rs_find_result_q->discountname";


$rs_labor_desc2 = urlencode($rs_labor_desc);
$rs_labor_pdesc2 = urlencode($rs_labor_pdesc);
$rs_cart_unit_price2 = urlencode($unit_price);
$rs_itemserial2 = urlencode($rs_itemserial);

if($ourprice == 0 ) {
$ourprice_ue = 0;
} else {
$ourprice_ue = urlencode($ourprice / $quantity);
}



if ($rs_stock_id == '0') {
echo "<tr><td style=\"width:60%\">";

echo "<a href=\"javascript:void(0);\" class=\"linkbuttonmoney linkbuttonmedium radiusall\" style=\"text-align:center;\" id=cartitemlink$cart_item_id><i class=\"fa fa-chevron-down\"></i></a> ";


echo "<span class=boldme>$rs_labor_desc</span>";

if ($rs_itemserial != "") {
echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class=\"sizemesmaller boldme\">".pcrtlang("Serial/Code").":</span> <span class=sizemesmaller>$rs_itemserial</span>";
}



echo "<div id=cartitem$cart_item_id style=\"display:none;\"><br>";

echo "<a href=repcart.php?func=remove_cart_item&pcwo=$pcwo&cart_item_id=$cart_item_id class=\"catchrepaircartlink linkbuttontiny linkbuttonmoney radiusleft\"><img src=images/del.png class=iconsmall> ".pcrtlang("remove")."</a>";

echo "<a href=repcart.php?func=edit&woid=$pcwo&cart_item_id=$cart_item_id&rs_cart_price=$rs_cart_unit_price2&rs_taxex=$rs_taxex&rs_cart_type=$rs_cart_type&itemdesc=$rs_labor_desc2&itempdesc=$rs_labor_pdesc2&price_alt=$price_alt&serial=$rs_itemserial2&cost=$ourprice_ue&qty=$quantity rel=facebox class=\"linkbuttontiny linkbuttonmoney\"><img src=../store/images/invedit.png class=iconsmall> ".pcrtlang("edit")."</a>";

if ($price_alt != 1) {
echo "<a href=repcart.php?func=add_discount&woid=$pcwo&cart_item_id=$cart_item_id&rs_cart_price=$unit_price&rs_taxex=$rs_taxex&rs_cart_type=$rs_cart_type&itemdesc=$rs_labor_desc2&qty=$quantity rel=facebox class=\"linkbuttontiny linkbuttonmoney radiusright\"><img src=../store/images/discount.png class=iconsmall> ".pcrtlang("add discount")."</a>";
} else {
echo "<a href=\"repcart.php?func=removediscount&cart_item_id=$cart_item_id&woid=$pcwo\" class=\"catchrepaircartlink linkbuttontiny linkbuttonmoney radiusright\"><img src=../store/images/remdiscount.png class=iconsmall> ".pcrtlang("remove discount")."</a><br><span class=\"sizemesmaller colormered\">".pcrtlang("Discount").": $discountname - ".pcrtlang("was")." $money$origprice</span>";
}


###
$rs_find_tax = "SELECT * FROM taxes WHERE taxenabled = '1' ORDER BY taxname ASC";
$rs_result_tax = mysqli_query($rs_connect, $rs_find_tax);
echo "<form method=post action=repcart.php?func=setitemtax class=catchrepaircartformonchange><input type=hidden name=cart_item_id value=$cart_item_id><select name=settaxid class=selects>";

while($rs_result_tq = mysqli_fetch_object($rs_result_tax)) {
$rs_taxname = "$rs_result_tq->taxname";
$rs_taxid = "$rs_result_tq->taxid";

if ($rs_taxid == $rs_taxex) {
echo "<option selected value=$rs_taxid>$rs_taxname</option>";
} else {
echo "<option value=$rs_taxid>$rs_taxname</option>";
}
}
echo "</select><input type=hidden name=cartitemtype value=$rs_cart_type><input type=hidden name=woid value=$pcwo><button type=submit class=ibutton style=\"padding:1px 5px;\"><i class=\"fa fa-arrow-circle-left\"></i> ".pcrtlang("Tax")."</button></form>";

echo "</div></td>";


echo "<td>".qf("$quantity")." </td><td> $money".mf("$unit_price")."</td><td>";

echo "<span class=\"boldme nowrap\">";

if ($price_alt == 1) {
echo "<img src=../store/images/discount.png border=0 align=absmiddle width=14> ";
}

echo "$money".mf("$rs_cart_price")."</span>";

?>
<script type='text/javascript'>
$('#cartitemlink<?php echo "$cart_item_id"; ?>').click(function(){
  $('#cartitem<?php echo "$cart_item_id"; ?>').toggle('1000');
  $("i",this).toggleClass("fa-chevron-up fa-chevron-down");
});
</script>
<?php


echo "</td></tr>";

###



} else {
$rs_find_item_detail = "SELECT * FROM stock WHERE stock_id = '$rs_stock_id'";
$rs_find_result_detail = mysqli_query($rs_connect, $rs_find_item_detail);

echo "<tr><td style=\"width:60%\">";

while($rs_find_result_detail_q = mysqli_fetch_object($rs_find_result_detail)) {
$rs_stocktitle = "$rs_find_result_detail_q->stock_title";

$rs_stocktitle2 = urlencode($rs_stocktitle);


echo "<a href=\"javascript:void(0);\" class=\"linkbuttonmoney linkbuttonmedium radiusall\" style=\"text-align:center;\"  id=cartitemlink$cart_item_id><i class=\"fa fa-chevron-down\"></i></a> ";

echo "<span class=boldme>$rs_stocktitle</span>";

if ($rs_itemserial != "") {
echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class=\"sizemesmaller boldme\">".pcrtlang("Serial/Code").":</span> <span class=sizemesmaller>$rs_itemserial</span>";
}

if (($rs_itemserial == "") && ($quantity == 1)) {
if (count(available_serials($rs_stock_id)) > 0) {
echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class=\"sizemesmaller boldme\"><i class=\"fa fa-info-circle faa-flash animated\"></i> ".pcrtlang("Serials Available")."</span>";
echo " <a href=repcart.php?func=addserialafter&pcwo=$pcwo&cart_item_id=$cart_item_id&stockid=$rs_stock_id class=\"linkbuttontiny linkbuttonmoney radiusall\" style=\"padding:2px;\"><i class=\"fa fa-plus\"></i></a>";
}
}

echo "<div id=cartitem$cart_item_id style=\"display:none;\">";

echo "<a href=repcart.php?func=remove_cart_item&pcwo=$pcwo&cart_item_id=$cart_item_id class=\"catchrepaircartlink linkbuttontiny linkbuttonmoney radiusleft\"><img src=images/del.png class=iconsmall> ".pcrtlang("remove")."</a>";

if($rs_itemserial == "") {
$rs_cart_unit_price_ue = urlencode("$unit_price");
$rs_quantity_ue = urlencode("$quantity");

if($ourprice == 0 ) {
$ourprice_ue = 0;
} else {
$ourprice_ue = urlencode($ourprice / $quantity);
}

echo "<a href=repcart.php?func=editinvitem&cart_item_id=$cart_item_id&rs_cart_price=$rs_cart_unit_price_ue&rs_taxex=$rs_taxex&price_alt=$price_alt&cost=$ourprice_ue&qty=$rs_quantity_ue&woid=$pcwo&stock_id=$rs_stock_id rel=facebox class=\"linkbuttontiny linkbuttonmoney\"><img src=\"../store/images/invedit.png\" class=iconsmall> ".pcrtlang("edit")."</a><br>";
}

if ($price_alt != 1) {
echo "<a href=repcart.php?func=add_discount&woid=$pcwo&cart_item_id=$cart_item_id&rs_cart_price=$unit_price&rs_taxex=$rs_taxex&rs_cart_type=$rs_cart_type&itemdesc=$rs_stocktitle2&qty=$quantity rel=facebox class=\"linkbuttontiny linkbuttonmoney radiusright\"><img src=../store/images/discount.png class=iconsmall> ".pcrtlang("add discount")."</a>";
} else {
echo "<a href=\"repcart.php?func=removediscount&cart_item_id=$cart_item_id&woid=$pcwo\" class=\"catchrepaircartlink linkbuttontiny linkbuttonmoney radiusright\"><img src=../store/images/remdiscount.png border=0 align=absmiddle width=16> ".pcrtlang("remove discount")."</a><br><span class=\"sizemesmaller colormered\">".pcrtlang("Discount").": $discountname</span>";
}


###
$rs_find_tax = "SELECT * FROM taxes WHERE taxenabled = '1' ORDER BY taxname ASC";
$rs_result_tax = mysqli_query($rs_connect, $rs_find_tax);
echo "<form method=post action=repcart.php?func=setitemtax class=catchrepaircartformonchange><input type=hidden name=cart_item_id value=$cart_item_id><select name=settaxid class=selects>";

while($rs_result_tq = mysqli_fetch_object($rs_result_tax)) {
$rs_taxname = "$rs_result_tq->taxname";
$rs_taxid = "$rs_result_tq->taxid";

if ($rs_taxid == $rs_taxex) {
echo "<option selected value=$rs_taxid>$rs_taxname</option>";
} else {
echo "<option value=$rs_taxid>$rs_taxname</option>";
}
}
echo "</select><input type=hidden name=cartitemtype value=$rs_cart_type><input type=hidden name=woid value=$pcwo><button type=submit class=ibutton style=\"padding:1px 5px;\"><i class=\"fa fa-arrow-circle-left\"></i> ".pcrtlang("Tax")."</button></form>";
###

echo "</div>";

$rs_find_stock = "SELECT * FROM stockcounts WHERE storeid = '$defaultuserstore' AND stockid = '$rs_stock_id'";
$rs_result_stock = mysqli_query($rs_connect, $rs_find_stock);
$rs_result_stockq = mysqli_fetch_object($rs_result_stock);
$stockqty = "$rs_result_stockq->quantity";

$rs_cart_addtime_menosuno = $rs_cart_addtime + 86400;
$rs_cart_addtime_ahora = time();


if(($stockqty < 1) && ($rs_cart_addtime_menosuno > $rs_cart_addtime_ahora)) {
echo "<br><span class=\"sizemesmaller colormered\"><i class=\"fa fa-exclamation-triangle fa-lg faa-flash animated\"></i> ".pcrtlang("Inventory has non-sufficient quantity")." ($stockqty)</span><br><a href=../store/stock.php?func=show_stock_detail&stockid=$rs_stock_id class=\"linkbuttontiny linkbuttonred radiusall\">".pcrtlang("check qty")."</a>";
}



echo "</td>";
echo "<td>".qf("$quantity")." </td><td> $money".mf("$unit_price")."</td><td>";

echo "<span class=\"boldme floatright\">";
if ($price_alt == 1) {
echo "<img src=../store/images/discount.png border=0 align=absmiddle width=14> ";
}
echo "$money".mf("$rs_cart_price")."</span>";



?>
<script type='text/javascript'>
$('#cartitemlink<?php echo "$cart_item_id"; ?>').click(function(){
  $('#cartitem<?php echo "$cart_item_id"; ?>').toggle('1000');
  $("i",this).toggleClass("fa-chevron-up fa-chevron-down");
});
</script>
<?php

}

echo "</td></tr>";
}
}

echo "</table>";

$rs_findsinv = "SELECT * FROM invoices WHERE invstatus != '3' AND preinvoice != '1' AND (woid = '$pcwo' OR woid LIKE '%"."\_"."$pcwo"."\_"."%')";
$rs_findsinv2 = @mysqli_query($rs_connect, $rs_findsinv);
$invcount = mysqli_num_rows($rs_findsinv2);


$rs_findtsum = "SELECT (SUM(cart_price) + SUM(itemtax)) as checkcarttsum FROM repaircart WHERE pcwo = '$pcwo'";
$rs_findtsum2 = @mysqli_query($rs_connect, $rs_findtsum);
$rs_findtsum3 = mysqli_fetch_object($rs_findtsum2);
$checkcarttsum2 = "$rs_findtsum3->checkcarttsum";

if(is_numeric($checkcarttsum2)) {
$checkcarttsum = mf($checkcarttsum2, 2, '.', '');

if ($rs_chargewhatcount != 0) {
echo "<div class=\"moneybox\" style=\"border-radius: 0px 0px 3px 3px; border-top:none\">";
echo "<table style=\"width:100%\"><tr><td>";

echo "<form action=repcart.php?func=loadsavecartout&pcwo=$pcwo method=post>";

if ($pcgroupid == 0) {
echo "<input type=hidden name=cfirstname value=\"$pcname\">";
echo "<input type=hidden name=ccompany value=\"$pccompany\">";
echo "<input type=hidden name=caddress value=\"$pcaddress\">";
echo "<input type=hidden name=caddress2 value=\"$pcaddress2\">";
echo "<input type=hidden name=ccity value=\"$pccity\">";
echo "<input type=hidden name=cstate value=\"$pcstate\">";
echo "<input type=hidden name=czip value=\"$pczip\">";

if ($pcphone != "") {
echo "<input type=hidden name=cphone value=\"$pcphone\">";
} elseif ($pccellphone != "") {
echo "<input type=hidden name=cphone value=\"$pccellphone\">";
} else {
echo "<input type=hidden name=cphone value=\"$pcworkphone\">";
}

echo "<input type=hidden name=cemail value=\"$pcemail\">";

} else {

echo "<input type=hidden name=cfirstname value=\"$pcgroupname\">";
echo "<input type=hidden name=ccompany value=\"$grpcompany\">";

if ($grpaddress == "") {
echo "<input type=hidden name=caddress value=\"$pcaddress\">";
} else {
echo "<input type=hidden name=caddress value=\"$grpaddress\">";
}
if ($grpaddress2 == "") {
echo "<input type=hidden name=caddress2 value=\"$pcaddress2\">";
} else {
echo "<input type=hidden name=caddress2 value=\"$grpaddress2\">";
}
if ($grpcity == "") {
echo "<input type=hidden name=ccity value=\"$pccity\">";
} else {
echo "<input type=hidden name=ccity value=\"$grpcity\">";
}
if ($grpstate == "") {
echo "<input type=hidden name=cstate value=\"$pcstate\">";
} else {
echo "<input type=hidden name=cstate value=\"$grpstate\">";
}
if ($grpzip == "") {
echo "<input type=hidden name=czip value=\"$pczip\">";
} else {
echo "<input type=hidden name=czip value=\"$grpzip\">";
}

if ($grpphone != "") {
echo "<input type=hidden name=cphone value=\"$grpphone\">";
} elseif ($grpcellphone != "") {
echo "<input type=hidden name=cphone value=\"$grpcellphone\">";
} else {
echo "<input type=hidden name=cphone value=\"$grpworkphone\">";
}
echo "<input type=hidden name=cemail value=\"$grpemail\">";
}
echo "<input type=hidden name=cwoid value=\"$pcwo\">";

echo "<input type=hidden name=cpcgroupid value=\"$pcgroupid\">";

if($invcount > "0") {
echo "<button type=button class=button onclick=\"javascript: if(confirm('".pcrtlang("This Work Order has invoices specified. Are you sure your want to continue checking out THE CART, AND NOT THE INVOICE?")."')) this.form.submit();\"><i class=\"fa fa-shopping-cart fa-lg\"></i> ".pcrtlang("CHECKOUT")."</button></form>";
} else {
echo "<button type=button class=button onclick=\"this.disabled=true; this.form.submit();\"><i class=\"fa fa-shopping-cart fa-lg\"></i> ".pcrtlang("CHECKOUT")."</button></form>";
}


echo "</td><th style=\"text-align:right;\">";
echo "<span class=\"sizemelarge boldme colormemoney floatright\">".pcrtlang("Repair Cart Total").": $money$checkcarttsum</span>";
echo "</th></tr></table></div>";
}
}


$rs_find_cart_items = "SELECT * FROM receipts WHERE (woid LIKE '%_$pcwo"."_%' OR woid = '$pcwo') AND (invoice_id = '' OR invoice_id = '0')";
$rs_resultrec = mysqli_query($rs_connect, $rs_find_cart_items);

if(mysqli_num_rows($rs_resultrec) > 0) {

echo "<br><span class=text16bu-ongreen>&nbsp;".pcrtlang("Receipts")."&nbsp;</span><br>";

while($rs_result_q = mysqli_fetch_object($rs_resultrec)) {
$rs_receipt_id = "$rs_result_q->receipt_id";
$rs_pay_type = "$rs_result_q->pay_type";
$rs_name = "$rs_result_q->person_name";
$rs_company = "$rs_result_q->company";
$rs_pay_type = "$rs_result_q->pay_type";
$rs_checkno = "$rs_result_q->check_number";
$rs_gt = "$rs_result_q->grandtotal";
$rs_date = "$rs_result_q->date_sold";

echo " <a href=../store/receipt.php?func=show_receipt&receipt=$rs_receipt_id class=\"linkbuttonmedium linkbuttonmoney radiusall\"><img src=../store/images/receipts.png style=\"width:24px;\" align=absmiddle> ".pcrtlang("Receipt").": #$rs_receipt_id</a><br>";

}
}



echo "</td>";

$rs_findsum = "SELECT SUM(cart_price) as checkcartsum FROM repaircart WHERE pcwo = '$pcwo'";
$rs_findsum2 = @mysqli_query($rs_connect, $rs_findsum);
$rs_findsum3 = mysqli_fetch_object($rs_findsum2);
$checkcartsum = "$rs_findsum3->checkcartsum";

$rs_findcont = "SELECT * FROM repaircart WHERE pcwo = '$pcwo'";
$rs_findcont2 = @mysqli_query($rs_connect, $rs_findsum);
$checkcartcontents = mysqli_num_rows($rs_findcont2);

echo "<td style=\"width:5%; vertical-align:top;\">";
echo "<td style=\"width:50%; vertical-align:top;\">";

echo "<span class=\"colormemoney sizemelarge boldme\">&nbsp;".pcrtlang("Invoicing")."&nbsp;</span><br>";

if (($invcount < 1) && ($checkcartcontents > 0)) {
if($pcgroupid == 0) {
echo "<br><a href=repinvoice.php?func=createinvoice&woid=$pcwo&pcname=$pcname2&pccompany=$pccompany2&pcphone=$pcphone2&pcemail=$pcemail2&pcaddress=$pcaddress12&pcaddress2=$pcaddress22&pccity=$pccity2&pcstate=$pcstate2&pczip=$pczip2&preinvoice=0 $therel class=\"linkbuttoninv linkbuttonmedium radiusall\" style=\"width:250px;margin-bottom:5px\"><img src=images/invoice.png style=\"vertical-align:middle;\"> ".pcrtlang("Create Invoice (Final) or Quote")."</a>";
} else {
echo "<br><a href=repinvoice.php?func=createinvoice&woid=$pcwo&pcname=$ue_pcgroupname&pccompany=$ue_grpcompany&pcphone=$ue_grpphone&pcemail=$ue_grpemail&pcaddress=$ue_grpaddress&pcaddress2=$ue_grpaddress2&pccity=$ue_grpcity&pcstate=$ue_grpstate&pczip=$ue_grpzip&preinvoice=0 $therel class=\"linkbuttoninv linkbuttonmedium radiusall\" style=\"width:250px;margin-bottom:5px\"><img src=images/invoice.png style=\"vertical-align:middle;\"> ".pcrtlang("Create Invoice (Final) or Quote")."</a>";
}
}

$rs_findsinv_2 = "SELECT * FROM invoices WHERE woid = '$pcwo' AND invstatus != '3' AND preinvoice != '0'";
$rs_findsinv2_2 = @mysqli_query($rs_connect, $rs_findsinv_2);
$invcount_2 = mysqli_num_rows($rs_findsinv2_2);
if ($checkcartcontents > 0) {
if($pcgroupid == 0) {
echo "<br><a href=repinvoice.php?func=createinvoice&woid=$pcwo&pcname=$pcname2&pccompany=$pccompany2&pcphone=$pcphone2&pcemail=$pcemail2&pcaddress=$pcaddress12&pcaddress2=$pcaddress22&pccity=$pccity2&pcstate=$pcstate2&pczip=$pczip2&preinvoice=1 $therel class=\"linkbuttoninv linkbuttonmedium radiusall\" style=\"width:250px;margin-bottom:5px;\"><img src=images/invoice.png style=\"vertical-align:middle;\"> ".pcrtlang("Create Invoice (Prepaid)")."</a><br>";
} else {
echo "<br><a href=repinvoice.php?func=createinvoice&woid=$pcwo&pcname=$ue_pcgroupname&pccompany=$ue_grpcompany&pcphone=$ue_grpphone&pcemail=$ue_grpemail&pcaddress=$ue_grpaddress&pcaddress2=$ue_grpaddress2&pccity=$ue_grpcity&pcstate=$ue_grpstate&pczip=$ue_grpzip&preinvoice=1 $therel class=\"linkbuttoninv linkbuttonmedium radiusall\" style=\"width:250px;margin-bottom:5px;\"><img src=images/invoice.png style=\"vertical-align:middle;\"> ".pcrtlang("Create Invoice (Prepaid)")."</a><br>";
}

}


##
if($pcgroupid != 0) {
$otherinvoicearray = array();
$rs_findotherpcs = "SELECT * FROM pc_owner WHERE pcgroupid = '$pcgroupid'";
$rs_findotherpcs_2 = @mysqli_query($rs_connect, $rs_findotherpcs);
while($rs_find_otherpcs_q = mysqli_fetch_object($rs_findotherpcs_2)) {
$otherpcid = "$rs_find_otherpcs_q->pcid";

$rs_findotherwo = "SELECT * FROM pc_wo WHERE pcid = '$otherpcid' AND woid != '$pcwo'";
$rs_findotherwo_2 = @mysqli_query($rs_connect, $rs_findotherwo);
while($rs_find_otherwo_q = mysqli_fetch_object($rs_findotherwo_2)) {
$otherwoid = "$rs_find_otherwo_q->woid";

$rs_findotherinv = "SELECT * FROM invoices WHERE preinvoice != '1' AND invstatus = '1' AND (woid = '$otherwoid' OR woid LIKE '%_"."$otherwoid"."_%')";
$rs_findotherinv_2 = @mysqli_query($rs_connect, $rs_findotherinv);
while($rs_find_otherinv_q = mysqli_fetch_object($rs_findotherinv_2)) {
$otherinv = "$rs_find_otherinv_q->invoice_id";
$thisinvwoid = "$rs_find_otherinv_q->woid";
$woidsinthisinvoice = explode_list($thisinvwoid);
if (!in_array($pcwo, $woidsinthisinvoice)) {
$itemtoadd = explode_list($otherinv);
$otherinvoicearray = array_merge($itemtoadd, $otherinvoicearray);
}
}
}
}

$otherinvoicearray = array_unique($otherinvoicearray);

if (($invcount < 1) && ($checkcartcontents > 0)) {
if(count($otherinvoicearray) > 0 ) {
foreach($otherinvoicearray as $key => $otherinvoiceid) {
echo "<a href=repinvoice.php?func=addtoexistinginvoice&woid=$pcwo&invoice_id=$otherinvoiceid class=\"linkbuttoninv linkbuttonmedium radiusleft\" style=\"width:250px;margin-bottom:5px;\"><img src=images/invoice.png style=\"vertical-align:middle;\"> ".pcrtlang("Add to Invoice")." #$otherinvoiceid</a>";
echo "<a href=../store/invoice.php?func=printinv&invoice_id=$otherinvoiceid target=_new class=\"linkbuttoninv linkbuttonmedium radiusright\" style=\"margin-bottom:5px;\"><i class=\"fa fa-eye fa-2x\" style=\"vertical-align:middle;height:32px;\"></i> ".pcrtlang("view")."</a><br>";
}
}
}
}
##


$depositinvoicearray = array();

if (($invcount + $invcount_2) == 1) {
echo "<br>";
}

while($rs_find_invoices_q = mysqli_fetch_object($rs_findsinv2)) {
$invoice_id = "$rs_find_invoices_q->invoice_id";
$invname = "$rs_find_invoices_q->invname";
$invcompany = "$rs_find_invoices_q->invcompany";
$invstatus = "$rs_find_invoices_q->invstatus";
$invemail = "$rs_find_invoices_q->invemail";
$invaddy1 = "$rs_find_invoices_q->invaddy1";
$invaddy2 = "$rs_find_invoices_q->invaddy2";
$invcity = "$rs_find_invoices_q->invcity";
$invstate = "$rs_find_invoices_q->invstate";
$invzip = "$rs_find_invoices_q->invzip";
$invphone = "$rs_find_invoices_q->invphone";
$invemail = "$rs_find_invoices_q->invemail";
$invwoid = "$rs_find_invoices_q->woid";
$invrec = "$rs_find_invoices_q->receipt_id";
$invdate = "$rs_find_invoices_q->invdate";
$invdate2 = pcrtdate("$pcrt_shortdate", "$invdate");
$invbyuser = "$rs_find_invoices_q->byuser";
$findinvtotal = "SELECT SUM(cart_price) AS invsubtotal, SUM(itemtax) AS invtax FROM invoice_items WHERE invoice_id = '$invoice_id'";
$findinvq = @mysqli_query($rs_connect, $findinvtotal);
$findinva = mysqli_fetch_object($findinvq);
$invtax = "$findinva->invtax";
$invsubtotal = "$findinva->invsubtotal";
$invtotal2 = $invtax + $invsubtotal;
$invtotal = number_format($invtotal2, 2, '.', '');

$invoicelist[] = $invoice_id;


$chkinvoicesql = "SELECT * FROM userlog WHERE reftype = 'invoiceid' AND refid = '$invoice_id' AND actionid = '15'";
$chkinvoice = mysqli_num_rows(mysqli_query($rs_connect, $chkinvoicesql));


echo "<br><div class=\"invoicebox colorbox\">";

$custname = urlencode("$invname");
$custcompany = urlencode("$invcompany");
$custaddy1 = urlencode("$invaddy1");
$custaddy2 = urlencode("$invaddy2");
$custcity = urlencode("$invcity");
$custstate = urlencode("$invstate");
$custzip = urlencode("$invzip");
$custphone = urlencode("$invphone");
$custemail = urlencode("$invemail");

$iorq = invoiceorquote($invoice_id);
if ($iorq == "quote") {
$ilabel = pcrtlang("Quote")." #$invoice_id";
} else {
$ilabel = pcrtlang("Invoice")." #$invoice_id ".pcrtlang("(Final)");
}


$finddeposits = "SELECT SUM(amount) AS deposittotal FROM deposits WHERE invoiceid = '$invoice_id'";
$finddepositsq = @mysqli_query($rs_connect, $finddeposits);
$finddepositsa = mysqli_fetch_object($finddepositsq);
$deposittotal = "$finddepositsa->deposittotal";
$depositbalance = tnv($invtotal) - tnv($deposittotal);


echo "<span class=\"sizemelarge boldme\"><img src=images/invoice.png border=0 align=absmiddle width=24> $ilabel</span>";
echo "<span class=\"sizemelarge boldme\" style=\"float:right;\">$money$invtotal</span><br>";
if(($deposittotal > 0) && ($invstatus == 1)) {
echo "<span class=\"sizemesmaller boldme\" style=\"float:right;\">".pcrtlang("Deposit Total:")." $money".mf($deposittotal)."</span><br>";
echo "<span class=\"sizemesmaller boldme\" style=\"float:right;\">".pcrtlang("Invoice Balance:")." $money".mf($depositbalance)."</span>";
}

if ($invstatus == 1) {

$depositinvoicearray[] = $invoice_id;

echo "$invdate2 | ";
if ($iorq != "quote") {
echo pcrtlang("Status: Open");
}
if ($invbyuser != "") {
echo " | ".pcrtlang("Created By").": $invbyuser";
}

$invoicewoids = explode_list($invwoid);


if(count($invoicewoids) > 1) {

echo "<br>".pcrtlang("Other Work Orders on this Invoice").":";
foreach($invoicewoids as $key => $thiswoids) {
if($thiswoids != $pcwo) {
echo "<a href=\"index.php?pcwo=$thiswoids\" class=\"linkbuttontiny linkbuttoninv radiusall\">#$thiswoids</a> ";
}
}

}

$returnurli2 = urlencode("../repair/index.php?pcwo=$pcwo");

echo "</span><br><br>";
echo "<a href=../store/invoice.php?func=printinv&invoice_id=$invoice_id&returnurl=$returnurli2 class=\"linkbuttoninv linkbuttonsmall\"><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Print")."</a>";
echo "<a href=../store/invoice.php?func=emailinv2&invoice_id=$invoice_id&emailaddy=$invemail&returnurl=$returnurli2 class=\"linkbuttoninv linkbuttonsmall\"><i class=\"fa fa-envelope fa-lg\"></i> ".pcrtlang("Email")." ";
if ($chkinvoice >= 1) {
echo "<span class=colormegreen> <i class=\"fa fa-check-circle\"></i> </span>";
}

echo "</a>";

echo "<a href=../store/invoice.php?func=editinvoice&invoice_id=$invoice_id&returnurl=$returnurli2&woid=$pcwo $therel class=\"linkbuttoninv linkbuttonsmall\"><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("Edit")."</a>";
if ($iorq != "quote") {
echo "<a href=repinvoice.php?func=checkout&invoice_id=$invoice_id&woid=$pcwo&custname=$custname&custcompany=$custcompany&custaddy1=$custaddy1&custaddy2=$custaddy2&custcity=$custcity&custstate=$custstate&custzip=$custzip&custphone=$custphone&custemail=$custemail class=\"linkbuttoninv linkbuttonsmall\">
<i class=\"fa fa-sign-out fa-lg\"></i> ".pcrtlang("Checkout")."</a>";

echo "<a href=../store/invoice.php?func=changeinvoicestatus&invstatus=3&invoice_id=$invoice_id&returnurl=$returnurli2  class=\"linkbuttoninv linkbuttonsmall\"><i class=\"fa fa-times-circle fa-lg\"></i> ".pcrtlang("Void")."</a>";
echo "<a href=../store/invoice.php?func=changeinvoicestatus&invstatus=2&invoice_id=$invoice_id&returnurl=$returnurli2 class=\"linkbuttoninv linkbuttonsmall\" onClick=\"return confirm('".pcrtlang("Are you sure you wish to close this invoice? Usually you want to checkout an invoice so that the invoice gets marked as paid.")."');\"> <i class=\"fa fa-check-circle fa-lg\"></i> ".pcrtlang("Close")."</a>";


### add deposit

if ($depositbalance > 0) {
if ($pcgroupid == 0) {
echo "<a href=\"../store/deposits.php?woid=$pcwo&invoiceid=$invoice_id&cfirstname=$pcname2&ccompany=$pccompany2&caddress=$pcaddress12&caddress2=$pcaddress22&ccity=$pccity2&cstate=$pcstate2&czip=$pczip2&cphone=$pcphone2&cemail=$pcemail2&depamount=$depositbalance\" class=\"linkbuttoninv linkbuttonsmall\"><i class=\"fa fa-money fa-lg\"></i> ".pcrtlang("Add Deposit")."</a>";
} else {
echo "<a href=\"../store/deposits.php?woid=$pcwo&invoiceid=$invoice_id&cfirstname=$ue_pcgroupname&ccompany=$ue_grpcompany&caddress=$ue_grpaddress&caddress2=$ue_grpaddress2&ccity=$ue_grpcity&cstate=$ue_grpstate&czip=$ue_grpzip&cphone=$ue_grpphone&cemail=$ue_grpemail&depamount=$depositbalance\" class=\"linkbuttoninv linkbuttonsmall\"><i class=\"fa fa-money fa-lg\"></i> ".pcrtlang("Add Deposit")."</a>";
}
}

###


} else {
echo "<a href=../store/invoice.php?func=deletequote&invoice_id=$invoice_id&returnurl=$returnurli2 class=\"linkbuttoninv linkbuttonsmall\" onClick=\"return confirm('".pcrtlang("Are you sure you wish to delete this quote?")."');\"><i class=\"fa fa-times-circle fa-lg\"></i> ".pcrtlang("Delete Quote")."</a>";
echo "<a href=repinvoice.php?func=checkout&invoice_id=$invoice_id&woid=$pcwo&custname=$custname&custcompany=$custcompany&custaddy1=$custaddy1&custaddy2=$custaddy2&custcity=$custcity&custstate=$custstate&custzip=$custzip&custphone=$custphone&custemail=$custemail&checkout=no class=\"linkbuttoninv linkbuttonsmall\"><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("Edit Items")."</a>";

}

} else {

echo "$invname | $invdate2 | $money$invtotal<br>";
if ($iorq != "quote") {
echo pcrtlang("Status: Closed/Paid");
}
if ($invbyuser != "") {
echo " | ".pcrtlang("Created By").": $invbyuser";
}
echo "<br>";
$invoicewoids = explode_list("$invwoid");

if(count($invoicewoids) > 1) {

echo pcrtlang("Other Work Orders on this Invoice").":";
foreach($invoicewoids as $key => $thiswoids) {
echo "<strong>#</strong><a href=\"index.php?pcwo=$thiswoids\">$thiswoids</a> ";
}
echo "<br><br>";
}


$returnurli2 = urlencode("../repair/index.php?pcwo=$pcwo");

echo "<a href=../store/invoice.php?func=printinv&invoice_id=$invoice_id&returnurl=$returnurli2 class=\"linkbuttoninv linkbuttonsmall\"><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Print")."</a>";
echo "<a href=../store/invoice.php?func=emailinv2&invoice_id=$invoice_id&emailaddy=$invemail&returnurl=$returnurli2 class=\"linkbuttoninv linkbuttonsmall\"><i class=\"fa fa-envelope fa-lg\"></i> ".pcrtlang("Email")." ";
if ($chkinvoice >= 1) {
echo "<span class=colormegreen> <i class=\"fa fa-check-circle\"></i></span>";
}
echo "</a>";

if ($iorq != "quote") {
echo "<a href=../store/invoice.php?func=changeinvoicestatus&invstatus=3&invoice_id=$invoice_id&returnurl=$returnurli2 class=\"linkbuttoninv linkbuttonsmall\" onClick=\"return confirm('".pcrtlang("Are you sure you wish to void this invoice?")."');\"><i class=\"fa fa-check-circle fa-lg\"></i> ".pcrtlang("Void")."</a>";
}

if (($invrec != '0') && ($iorq != "quote")) {
echo "<a href=../store/receipt.php?func=show_receipt&receipt=$invrec class=\"linkbuttoninv linkbuttonsmall\"><i class=\"fa fa-file-text fa-lg\"></i> ".pcrtlang("View Receipt")." #$invrec</a>";
}

}


}




echo "</div>";

#######################################################

while($rs_find_invoices_q_2 = mysqli_fetch_object($rs_findsinv2_2)) {
$invoice_id_2 = "$rs_find_invoices_q_2->invoice_id";
$invname_2 = "$rs_find_invoices_q_2->invname";
$invcompany_2 = "$rs_find_invoices_q_2->invcompany";
$invstatus_2 = "$rs_find_invoices_q_2->invstatus";
$invemail_2 = "$rs_find_invoices_q_2->invemail";
$invaddy1_2 = "$rs_find_invoices_q_2->invaddy1";
$invaddy2_2 = "$rs_find_invoices_q_2->invaddy2";
$invcity_2 = "$rs_find_invoices_q_2->invcity";
$invstate_2 = "$rs_find_invoices_q_2->invstate";
$invzip_2 = "$rs_find_invoices_q_2->invzip";
$invphone_2 = "$rs_find_invoices_q_2->invphone";
$invemail_2 = "$rs_find_invoices_q_2->invemail";
$invwoid_2 = "$rs_find_invoices_q_2->woid";
$invrec_2 = "$rs_find_invoices_q_2->receipt_id";
$invdate_2 = "$rs_find_invoices_q_2->invdate";
$invdate2_2 = pcrtdate("$pcrt_mediumdate", "$invdate_2");
$invbyuser_2 = "$rs_find_invoices_q_2->byuser";
$findinvtotal_2 = "SELECT SUM(cart_price) AS invsubtotal, SUM(itemtax) AS invtax FROM invoice_items WHERE invoice_id = '$invoice_id_2'";
$findinvq_2 = @mysqli_query($rs_connect, $findinvtotal_2);
$findinva_2 = mysqli_fetch_object($findinvq_2);
$invtax_2 = "$findinva_2->invtax";
$invsubtotal_2 = "$findinva_2->invsubtotal";
$invtotal2_2 = $invtax_2 + $invsubtotal_2;
$invtotal_2 = number_format($invtotal2_2, 2, '.', '');

$invoicelist[] = $invoice_id_2;


$chkinvoicesql2 = "SELECT * FROM userlog WHERE reftype = 'invoiceid' AND refid = '$invoice_id_2' AND actionid = '15'";
$chkinvoice2 = mysqli_num_rows(mysqli_query($rs_connect, $chkinvoicesql2));



echo "<br>";

echo "<div class=\"invoiceprebox colorbox\">";


$custname_2 = urlencode("$invname_2");
$custcompany_2 = urlencode("$invcompany_2");
$custaddy1_2 = urlencode("$invaddy1_2");
$custaddy2_2 = urlencode("$invaddy2_2");
$custcity_2 = urlencode("$invcity_2");
$custstate_2 = urlencode("$invstate_2");
$custzip_2 = urlencode("$invzip_2");
$custphone_2 = urlencode("$invphone_2");
$custemail_2 = urlencode("$invemail_2");

$iorq_2 = invoiceorquote($invoice_id_2);
if ($iorq_2 == "quote") {
$ilabel_2 = pcrtlang("Quote")." #$invoice_id_2";
} else {
$ilabel_2 = pcrtlang("Invoice")." #$invoice_id_2 ".pcrtlang("(Prepaid)");
}


$finddeposits_2 = "SELECT SUM(amount) AS deposittotal FROM deposits WHERE invoiceid = '$invoice_id_2'";
$finddepositsq_2 = @mysqli_query($rs_connect, $finddeposits_2);
$finddepositsa_2 = mysqli_fetch_object($finddepositsq_2);
$deposittotal_2 = "$finddepositsa_2->deposittotal";
$depositbalance_2 = tnv($invtotal_2) - tnv($deposittotal_2);


echo "<span class=\"sizemelarge boldme\"><img src=images/invoice.png border=0 align=absmiddle width=24> $ilabel_2</span>";
echo "<span class=\"sizemelarge boldme\" style=\"float:right;\">$money$invtotal_2</span><br>";
if(($deposittotal_2 > 0) && ($invstatus_2 == 1)) {
echo "<span class=\"sizemesmaller boldme\" style=\"float:right;\">".pcrtlang("Deposit Total:")." $money".mf($deposittotal_2)."</span><br>";
echo "<span class=\"sizemesmaller boldme\" style=\"float:right;\">".pcrtlang("Invoice Balance:")." $money".mf($depositbalance_2)."</span>";
}


if ($invstatus_2 == 1) {

$depositinvoicearray[] = $invoice_id_2;

echo "$invdate2_2 | ";
if ("$iorq_2" != "quote") {
echo pcrtlang("Status: Open");
}
if ($invbyuser_2 != "") {
echo " | ".pcrtlang("Created By").": $invbyuser_2";
}

$returnurli2 = urlencode("../repair/index.php?pcwo=$pcwo");

echo "<br><br>";
echo "<a href=../store/invoice.php?func=printinv&invoice_id=$invoice_id_2&returnurl=$returnurli2 class=\"linkbuttoninv linkbuttonsmall\"><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Print")."</a>";
echo "<a href=../store/invoice.php?func=emailinv2&invoice_id=$invoice_id_2&emailaddy=$invemail_2&returnurl=$returnurli2 class=\"linkbuttoninv linkbuttonsmall\"><i class=\"fa fa-envelope fa-lg\"></i> ".pcrtlang("Email")." ";
if ($chkinvoice2 >= 1) {
echo "<span class=colormegreen> <i class=\"fa fa-check-circle\"></i> </span>";
}
echo "</a>";
echo "<a href=../store/invoice.php?func=editinvoice&invoice_id=$invoice_id_2&returnurl=$returnurli2&woid=$pcwo class=\"linkbuttoninv linkbuttonsmall\" $therel><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("Edit")."</a>";
if ($iorq_2 != "quote") {
echo "<a href=repinvoice.php?func=checkout&invoice_id=$invoice_id_2&woid=$pcwo&custname=$custname_2&custcompany=$custcompany_2&custaddy1=$custaddy1_2&custaddy2=$custaddy2_2&custcity=$custcity_2&custstate=$custstate_2&custzip=$custzip_2&custphone=$custphone_2&custemail=$custemail_2&prepaid=yes class=\"linkbuttoninv linkbuttonsmall\"><i class=\"fa fa-sign-out fa-lg\"></i> ".pcrtlang("Checkout")."</a>";
echo "<a href=../store/invoice.php?func=changeinvoicestatus&invstatus=3&invoice_id=$invoice_id_2&returnurl=$returnurli2 class=\"linkbuttoninv linkbuttonsmall\" onClick=\"return confirm('".pcrtlang("Are you sure you wish to void this invoice?")."');\"><i class=\"fa fa-times-circle fa-lg\"></i> ".pcrtlang("Void")."</a>";
echo "<a href=../store/invoice.php?func=changeinvoicestatus&invstatus=2&invoice_id=$invoice_id_2&returnurl=$returnurli2 class=\"linkbuttoninv linkbuttonsmall\" onClick=\"return confirm('".pcrtlang("Are you sure you wish to close this invoice? Usually you want to checkout an invoice so that the invoice gets marked as paid.")."');\"><i class=\"fa fa-check-circle fa-lg\"></i> ".pcrtlang("Close")."</a>";

if ($depositbalance_2 > 0) {
if ($pcgroupid == 0) {
echo "<a href=\"../store/deposits.php?woid=$pcwo&invoiceid=$invoice_id_2&cfirstname=$pcname2&ccompany=$pccompany2&caddress=$pcaddress12&caddress2=$pcaddress22&ccity=$pccity2&cstate=$pcstate2&czip=$pczip2&cphone=$pcphone2&cemail=$pcemail2&depamount=$depositbalance_2\" class=\"linkbuttoninv linkbuttonsmall\"><i class=\"fa fa-money fa-lg\"></i> ".pcrtlang("Add Deposit")."</a>";
} else {
echo "<a href=\"../store/deposits.php?woid=$pcwo&invoiceid=$invoice_id_2&cfirstname=$ue_pcgroupname&ccompany=$ue_grpcompany&caddress=$ue_grpaddress&caddress2=$ue_grpaddress2&ccity=$ue_grpcity&cstate=$ue_grpstate&czip=$ue_grpzip&cphone=$ue_grpphone&cemail=$ue_grpemail&depamount=$depositbalance_2\" class=\"linkbuttoninv linkbuttonsmall\"><i class=\"fa fa-money fa-lg\"></i> ".pcrtlang("Add Deposit")."</a>";
}
}


} else {
echo "<a href=../store/invoice.php?func=deletequote&invoice_id=$invoice_id_2&returnurl=$returnurli2 class=\"linkbuttoninv linkbuttonsmall\" onClick=\"return confirm('".pcrtlang("Are you sure you wish to delete this quote?")."');\"><i class=\"fa fa-times-circle fa-lg\"></i> ".pcrtlang("Delete Quote")."</a>";
echo "<a href=repinvoice.php?func=checkout&invoice_id=$invoice_id_2&woid=$pcwo&custname=$custname_2&custcompany=$custcompany_2&custaddy1=$custaddy1_2&custaddy2=$custaddy2_2&custcity=$custcity_2&custstate=$custstate_2&custzip=$custzip_2&custphone=$custphone_2&custemail=$custemail_2&checkout=no class=\"linkbuttoninv linkbuttonsmall\"><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("Edit Items")."</a>";
}



} else {

echo "$invname_2 | $invdate2_2 | $money$invtotal_2<br>";
if ($iorq_2 != "quote") {
echo pcrtlang("Status: Closed/Paid");
}
if ($invbyuser_2 != "") {
echo " | ".pcrtlang("Created By").": $invbyuser_2";
}

$returnurli2 = urlencode("../repair/index.php?pcwo=$pcwo");

echo "<br>";
echo "<a href=../store/invoice.php?func=printinv&invoice_id=$invoice_id_2&returnurl=$returnurli2 class=\"linkbuttoninv linkbuttonsmall\"><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Print")."</a>";
echo "<a href=../store/invoice.php?func=emailinv2&invoice_id=$invoice_id_2&emailaddy=$invemail_2&returnurl=$returnurli2 class=\"linkbuttoninv linkbuttonsmall\"><i class=\"fa fa-envelope fa-lg\"></i> ".pcrtlang("Email")." ";
if ($chkinvoice2 >= 1) {
echo "<span class=colormegreen> <i class=\"fa fa-check-circle\"></i> </span>";
}
echo "</a>";

if ($iorq_2 != "quote") {
echo "<a href=../store/invoice.php?func=changeinvoicestatus&invstatus=3&invoice_id=$invoice_id_2&returnurl=$returnurli2 class=\"linkbuttoninv linkbuttonsmall\" onClick=\"return confirm('".pcrtlang("Are you sure you wish to void this invoice?")."');\"><i class=\"fa fa-times-circle fa-lg\"></i> ".pcrtlang("Void")."</a></span>";
}

if (($invrec_2 != '0') && ($iorq_2 != "quote")) {
echo "<a href=../store/receipt.php?func=show_receipt&receipt=$invrec_2 class=\"linkbuttoninv linkbuttonsmall\"><i class=\"fa fa-file-text fa-lg\"></i> ".pcrtlang("View Receipt")." #$invrec_2</a>";
}

}

echo "</div>";

}


echo "<br>";

#######################################################

}

echo "</td></tr></table>";



############Deposits
$addywoids = "";
if(isset($invoicewoids)) {
if(count($invoicewoids) != 0) {
reset($invoicewoids);
foreach($invoicewoids as $key => $thiswoid) {
$addywoids .= " OR woid = '$thiswoid'";
}
}
}


if(count($invoicelist) > 0) {
foreach($invoicelist as $key => $thisinvid) {
$addywoids .= " OR invoiceid = '$thisinvid'";
}
}



$finddeposits = "SELECT * FROM deposits WHERE woid = '$pcwo'$addywoids";

$finddepositsq = @mysqli_query($rs_connect, $finddeposits);

if(mysqli_num_rows($finddepositsq) > 0) {

echo "<br><table class=moneylist>";
echo "<tr><th colspan=7>".pcrtlang("Deposits")."</th></tr>";
while ($finddepositsa = mysqli_fetch_object($finddepositsq)) {
$depositid = "$finddepositsa->depositid";
$depamount2 = "$finddepositsa->amount";
$depamount = mf($depamount2);
$depfirstname = "$finddepositsa->pfirstname";
$depplugin = "$finddepositsa->paymentplugin";
$dstatus = "$finddepositsa->dstatus";
$dwoid = "$finddepositsa->woid";
$dinvoiceid = "$finddepositsa->invoiceid";

echo "<tr><td><strong>".pcrtlang("Deposit")." #$depositid </strong></td><td><strong> $money$depamount </strong></td><td><strong> $depplugin </strong></td><td><strong> ";
echo "$depfirstname </strong></td><td><strong> ";
echo pcrtlang("Status").": ".pcrtlang("$dstatus")."</strong>";
echo "</td><td><strong>";

if(($dwoid != 0) && ($dinvoiceid == 0)) {
echo pcrtlang("Attached to Work Order");
} elseif ($dinvoiceid != 0) {
echo pcrtlang("Attached to Invoice").": $dinvoiceid";
} else {

}

echo "</strong></td><td style=\"width:15%\">";

if($dstatus == "open") {
#if(!empty($depositinvoicearray) || ($dinvoiceid != 0)) {
echo "<a href=\"javascript:void(0);\" class=\"linkbuttonmoney linkbuttonmedium\" style=\"display:inline;border-radius:3px;padding:2px;text-align:center;float:right;\" id=depitemlink$depositid><i class=\"fa fa-chevron-right fa-lg\"></i></a> ";

echo "<div id=depitem$depositid style=\"display:none;\"><br><br>";

if($dinvoiceid != 0) {
echo "<a href=\"pc.php?func=switchdeposit&towhat=woid&woid=$pcwo&depositid=$depositid\" class=\"catchrepaircartlink linkbuttonmoney linkbuttontiny radiusall\" style=\"display:block\">".pcrtlang("Work Order")." #$pcwo</a>";
}


if(!empty($depositinvoicearray)) {
reset($depositinvoicearray);
foreach($depositinvoicearray as $key => $thisinv) {
if($dinvoiceid != $thisinv) {

$rs_findsumdi = "SELECT SUM(amount) as invdsum FROM deposits WHERE invoiceid = '$thisinv'";
$rs_findsum2di = @mysqli_query($rs_connect, $rs_findsumdi);
$rs_findsum3di = mysqli_fetch_object($rs_findsum2di);
$invdsum = "$rs_findsum3di->invdsum";

$rs_findsumi = "SELECT SUM(cart_price) AS invsubtotal, SUM(itemtax) AS invtax FROM invoice_items WHERE invoice_id = '$thisinv'";
$rs_findsum2i = @mysqli_query($rs_connect, $rs_findsumi);
$rs_findsum3i = mysqli_fetch_object($rs_findsum2i);
$invdsumd = "$rs_findsum3i->invsubtotal";
$invdsumtax = "$rs_findsum3i->invtax";
$invdtotal = mf(tnv($invdsumd) + tnv($invdsumtax));

if((tnv($invdsum) + tnv($depamount)) <= $invdtotal) {
echo "<a href=\"pc.php?func=switchdeposit&towhat=invoice&invoiceid=$thisinv&depositid=$depositid&woid=$pcwo\" class=\"catchrepaircartlink linkbuttonmoney linkbuttontiny radiusall\" style=\"display:block\">".pcrtlang("Attach to Invoice")." #$thisinv</a>";
} else {
$invbal = mf(tnv($invdtotal) - tnv($invdsum));
if($invbal > 0) {
echo "<a href=\"repcart.php?func=splitdeposit&towhat=invoice&invoiceid=$thisinv&depositid=$depositid&woid=$pcwo&invbal=$invbal\" class=\"catchrepaircartlink linkbuttonmoney linkbuttontiny radiusall\" style=\"display:block\">".pcrtlang("Split and Attach")." ".pcrtlang("Invoice")." #$thisinv</a>";
}
echo "<span class=\"linkbuttonmoneydisabled linkbuttontiny radiusall\"  style=\"display:block\">".pcrtlang("Attach to Invoice")."#$thisinv</span>";
}

}
}
}

if(($dwoid != 0) && ($dinvoiceid == 0)) {
echo "<a href=\"pc.php?func=removedepositfromwo&depositid=$depositid&woid=$pcwo\" class=\"catchrepaircartlink linkbuttonmoney linkbuttontiny radiusall\" style=\"display:block\">".pcrtlang("Remove from WO")."</a>";
}

echo "<a href=\"../store/deposits.php?func=deposit_receipt&depositid=$depositid&depemail=$pcemail&woid=$pcwo\" class=\"linkbuttonmoney linkbuttontiny radiusall\" style=\"display:block\">".pcrtlang("Print")."</a>";

echo "</div>";


?>
<script type='text/javascript'>
$('#depitemlink<?php echo "$depositid"; ?>').click(function(){
  $('#depitem<?php echo "$depositid"; ?>').toggle('1000');
  $("i",this).toggleClass("fa-chevron-up fa-chevron-down");
});
</script>
<?php

}

echo "</td></tr>";
}
echo "</table><br>";

}

?>
<script type="text/javascript">
$(document).ready(function(){
$('.catchrepaircartlink').click(function (e) {
                e.preventDefault();
		 $('.ajaxspinner').toggle();
                var url = $(this).attr('href');
                $.get(url, function () {
                $.get('ajaxhelpers.php?func=cartitemsandinvoices&pcwo=<?php echo "$pcwo"; ?>', function(data) {
                $('#repaircartitemsandinvoices').html(data);
                });
		 $('.ajaxspinner').toggle();
                });
                });
});
</script>


<script type='text/javascript'>
$(document).ready(function(){
$('.catchrepaircartformonchange').change(function(e) { // catch the form's submit event
        e.preventDefault();
	$('.ajaxspinner').toggle();
        $.ajax({ // create an AJAX call...
        data: $(this).serialize(), // get the form data
        type: $(this).attr('method'), // GET or POST
        url: $(this).attr('action'), // the file to call
        success: function(response) { // on success..
                $.get('ajaxhelpers.php?func=cartitemsandinvoices&pcwo=<?php echo "$pcwo"; ?>', function(data) {
                $('#repaircartitemsandinvoices').html(data);
                 $('.ajaxspinner').toggle();
		});
    }
    });
});
});
</script>

<?php

}


function timersarea() {
require("deps.php");
require_once("common.php");

$pcwo = $_REQUEST['pcwo'];

$rs_findowner = "SELECT pcid FROM pc_wo WHERE woid = '$pcwo'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
$rs_result_q2 = mysqli_fetch_object($rs_result2);
$pcid = "$rs_result_q2->pcid";



$rs_findowner = "SELECT pcgroupid FROM pc_owner WHERE pcid = '$pcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
$rs_result_q2 = mysqli_fetch_object($rs_result2);
$pcgroupid = "$rs_result_q2->pcgroupid";

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}

?>
<script type='text/javascript'>
   function pad(val)
        {
            var valString = val + "";
            if(valString.length < 2)
            {
                return "0" + valString;
            }
            else
            {
                return valString;
            }
        }
</script>
<?php

echo "<table style=\"width:100%\"><tr><td><form action=pc.php?func=timerstart&woid=$pcwo method=post class=catchtimersareaform>";
echo "<input name=timername size=20 class=textbox placeholder=\"".pcrtlang("Enter Task Description")."\"> <button type=submit class=\"linkbuttonmedium linkbuttongreen radiusall\"><i class=\"fa fa-clock-o fa-lg\"></i> ".pcrtlang("Start New Timer")."</button></form>";
echo "</td>";

echo "<td rowspan=2 style=\"text-align:right\">";

echo "<a href=pc.php?func=timerstartmanual&woid=$pcwo class=\"catchmanualtimer linkbuttonmedium linkbuttongreen radiusleft\">".pcrtlang("Manual Timer")."</a>";

if($pcgroupid != 0) {
echo "<a href=\"group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=blockcontract\" class=\"linkbuttonmedium linkbuttongray radiusright\">".pcrtlang("Block of Time Contracts")."</a>";
}


echo "</td></tr></table>";

function time_elapsed($secs){

    $bit = array(
        'y' => $secs / 31556926 % 12,
        'w' => $secs / 604800 % 52,
        'd' => $secs / 86400 % 7,
        'h' => $secs / 3600 % 24,
        'm' => $secs / 60 % 60,
 #       's' => $secs % 60
        );

    foreach($bit as $k => $v)
        if($v > 0)$ret[] = $v . $k;

if(!isset($ret)) {
$ret[] = "0m";
}

    return join(' ', $ret);
    }


$totalelapsed = 0;

$rs_findtimers = "SELECT * FROM timers WHERE woid = '$pcwo' ORDER BY timerstart ASC";
$rs_result_t = mysqli_query($rs_connect, $rs_findtimers);
while($rs_result_qt = mysqli_fetch_object($rs_result_t)) {
$timername = "$rs_result_qt->timerdesc";
$timerstart = "$rs_result_qt->timerstart";
$timerstop = "$rs_result_qt->timerstop";
$timertotal = "$rs_result_qt->timertotal";
$timerid = "$rs_result_qt->timerid";
$billedout = "$rs_result_qt->billedout";
$timerbyuser = "$rs_result_qt->byuser";
$blockcontractid = "$rs_result_qt->blockcontractid";

$timerstart_2822 = date('r', strtotime("$timerstart"));


$timerstartdate2 = pcrtdate("$pcrt_shortdate", "$timerstart");
$timerstarttime2 = pcrtdate("$pcrt_time", "$timerstart");
$timerstoptime2 = pcrtdate("$pcrt_time", "$timerstop");


$startepoch = strtotime($timerstart);
$stopepoch = time();
$startseconds = $stopepoch - $startepoch;

if($timerstop == "0000-00-00 00:00:00") {
echo "<div class=timeritemactive><table style=\"width:100%\" class=pad5><tr><td colspan=2><span class=\"sizemelarge boldme\">$timername</span></td><td colspan=2 style=\"text-align:right;\">";

echo "<span class=\"colormegreen sizemelarge boldme\">".pcrtlang("Time Elapsed").": <i class=\"fa fa-spinner fa-lg fa-spin\"></i></span>";

?>

<label id="<?php echo "$timerid"; ?>hours" class="colormegreen sizemelarge boldme">0</label><span class="colormegreen sizemelarge boldme">:</span><label id="<?php echo "$timerid"; ?>minutes" class="colormegreen sizemelarge boldme">00</label><span class="colormegreen sizemelarge boldme">:</span><label id="<?php echo "$timerid"; ?>seconds" class="colormegreen sizemelarge boldme">00</label>
    <script type="text/javascript">
        var hoursLabel<?php echo "$timerid"; ?> = document.getElementById("<?php echo "$timerid"; ?>hours");
        var minutesLabel<?php echo "$timerid"; ?> = document.getElementById("<?php echo "$timerid"; ?>minutes");
        var secondsLabel<?php echo "$timerid"; ?> = document.getElementById("<?php echo "$timerid"; ?>seconds");
        var totalSeconds<?php echo "$timerid"; ?> = <?php echo "$startseconds"; ?>;
	if (typeof timeRun<?php echo "$timerid"; ?> !== 'undefined') {
        clearInterval(timeRun<?php echo "$timerid"; ?>);
	}
        var timeRun<?php echo "$timerid"; ?> = setInterval(setTime<?php echo "$timerid"; ?>, 1000);

   function setTime<?php echo "$timerid"; ?>()
        {
            ++totalSeconds<?php echo "$timerid"; ?>;
            secondsLabel<?php echo "$timerid"; ?>.innerHTML = pad(totalSeconds<?php echo "$timerid"; ?>%60);
            minutesLabel<?php echo "$timerid"; ?>.innerHTML = pad(parseInt(totalSeconds<?php echo "$timerid"; ?>/60) %60);
            hoursLabel<?php echo "$timerid"; ?>.innerHTML = parseInt(totalSeconds<?php echo "$timerid"; ?>/3600);
        }

    </script>

                                                                                 
<?php


echo "</td></tr><tr><td style=\"width:100px\"><span class=\"boldme\"><i class=\"fa fa-calendar fa-lg\"></i> $timerstartdate2</span></td><td style=\"width:100px\"><span class=\"colormegreen boldme\"><i class=\"fa fa-clock-o fa-lg\"></i> $timerstarttime2</span></td><td style=\"width:100px\"><span class=\"colormegreen boldme\"><i class=\"fa fa-user fa-lg\"></i> $timerbyuser</span> ";



echo "</td><td style=\"text-align:right\"><a href=pc.php?func=timereditprog&woid=$pcwo&timerid=$timerid class=\"linkbuttonmedium linkbuttongray radiusleft\" rel=facebox><i class=\"fa fa-edit\"></i> ".pcrtlang("Edit")."</a>";
echo "<a href=pc.php?func=timerstop&woid=$pcwo&timerid=$timerid&blockcontractid=$blockcontractid class=\"catchtimersarealink linkbuttonmedium linkbuttonred radiusright\"><i class=\"fa fa-stop\"></i> ".pcrtlang("Stop")."</a></td></tr></table></div>";

} else {

$startstamp = strtotime("$timerstart");
$stopstamp = strtotime("$timerstop");

$elapsedtime = $stopstamp - $startstamp;

$totalelapsed = $totalelapsed + $elapsedtime;


$elapsedhuman = time_elapsed($elapsedtime);

echo "<div class=timeritem><table style=\"width:100%\" class=pad5><tr><td colspan=2 style=\"vertical-align:top;\"><span class=\"sizemelarge boldme\">$timername</span></td><td style=\"text-align:right;vertical-align:top;padding: 10px 0px 0px 0px;\">";
echo "</td><td colspan=1 style=\"text-align:right;\">";

echo "<span class=\"sizemelarge boldme\"><i class=\"fa fa-user fa-lg\"></i> $timerbyuser</span></td><td style=\"text-align:right;width:150px;\">";

echo "<span class=\"colormeblue sizemelarge boldme\">$elapsedhuman</span>";

$timername = urlencode("$timername");

echo "</td></tr><tr><td style=\"width:100px\"><span class=\"boldme\"><i class=\"fa fa-calendar fa-lg\"></i> $timerstartdate2</span></td><td style=\"width:100px\"><span class=\"colormegreen boldme\"><i class=\"fa fa-clock-o fa-lg\"></i> $timerstarttime2</span></td><td style=\"width:100px\"><span class=\"colormered boldme\"><i class=\"fa fa-stop fa-lg\"></i> $timerstoptime2</span></td><td style=\"text-align:right\" colspan=3><a href=\"javascript:void(0);\" class=\"showdeletetimer linkbuttongray linkbuttonmedium radiusleft\"><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")."</a><a href=pc.php?func=timerdelete&woid=$pcwo&timerid=$timerid&blockcontractid=$blockcontractid style=\"display:none;width:70px;text-align:center\" class=\"catchtimersarealink linkbuttonmedium linkbuttonred\"><i class=\"fa fa-check fa-lg\"></i></a>";


echo "<a href=pc.php?func=timeredit&woid=$pcwo&timerid=$timerid&blockcontractid=$blockcontractid rel=facebox class=\"linkbuttonmedium linkbuttongray\"><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("Edit")."</a>";

if($billedout == 0) {
$timername_hsc = urlencode("$timername");
echo "<a href=\"pc.php?func=timerbillfirst&woid=$pcwo&pcgroupid=$pcgroupid&timerid=$timerid&billtime=$elapsedtime&timerdesc=$timername_hsc\" class=\"linkbuttonmedium linkbuttongray\"><i class=\"fa fa-money fa-lg\"></i> ".pcrtlang("Bill Hours")."</a>";

} else {

if($blockcontractid != 0) {
echo "<a href=\"group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=blockcontract\" class=\"linkbuttonmedium linkbuttongray\">Billed to Contract</a>";
}

}


echo "<a href=pc.php?func=timerstart&woid=$pcwo&timername=$timername class=\"catchtimersarealink linkbuttonmedium linkbuttongreen radiusright\"><i class=\"fa fa-clock-o fa-lg\"></i> ".pcrtlang("Resume")."</a></td></tr></table></div>";

}

}

?>

<script type="text/javascript">
    jQuery(document).ready(function($) {
         $('a[rel*=facebox]').off();
         $('a[rel*=facebox]').facebox({
        loadingImage : 'jq/loading.gif',
        closeImage : 'jq/closelabel.png'
      })
    })
</script>

<script type="text/javascript">
$(".showdeletetimer").click(function(){
$(this).next().toggle();
});
</script>


<script type="text/javascript">
$(document).ready(function(){
$('.catchtimersarealink').on('click', function (e) {
                e.preventDefault();
		 $('.ajaxspinner').toggle();
                var url = $(this).attr('href');
                $.get(url, function () {
                $.get('ajaxhelpers.php?func=timersarea&pcwo=<?php echo "$pcwo"; ?>&pcid=<?php echo "$pcid"; ?>', function(data) {
                $('#timersarea').html(data);
		 $('.ajaxspinner').toggle();
                });
                });
                });
});
</script>

<script type="text/javascript">
$(document).ready(function(){
$('.catchmanualtimer').on('click', function (e) {
                e.preventDefault();
		 $('.ajaxspinner').toggle();
                var url = $(this).attr('href');
                $.get(url, function (timerid) {
		jQuery.facebox({ ajax: 'pc.php?func=timeredit&woid=<?php echo "$pcwo"; ?>&timerid=' + timerid });
		 $('.ajaxspinner').toggle();
                });
                });
});
</script>



<script type='text/javascript'>
$(document).ready(function(){
$('.catchtimersareaform').submit(function(e) { // catch the form's submit event
        e.preventDefault();
	 $('.ajaxspinner').toggle();
        $.ajax({ // create an AJAX call...
        data: $(this).serialize(), // get the form data
        type: $(this).attr('method'), // GET or POST
        url: $(this).attr('action'), // the file to call
        success: function(response) { // on success..
                $.get('ajaxhelpers.php?func=timersarea&pcwo=<?php echo "$pcwo"; ?>&pcid=<?php echo "$pcid"; ?>', function(data) {
                $('#timersarea').html(data);
		 $('.ajaxspinner').toggle();
                });
                $('.catchtimersareaform').each (function(){
                  this.reset();
                });
    }
    });
});
});
</script>
<?php

}


function tagsarea() {
require("deps.php");
require_once("common.php");

$pcwo = $_REQUEST['pcwo'];
$pcid = $_REQUEST['pcid'];

$rs_findowner = "SELECT pcgroupid,tags FROM pc_owner WHERE pcid = '$pcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
$rs_result_q2 = mysqli_fetch_object($rs_result2);
$pcownertags = "$rs_result_q2->tags";
$pcgroupid = "$rs_result_q2->pcgroupid";


displaytags($pcid,$pcgroupid,32);


echo "<a href=\"javascript:void(0);\" class=\"linkbuttonsmall linkbuttongray radiusall floatright\" id=tagchange><i class=\"fa fa-chevron-down\"></i></a>";

echo "<div id=tagselectorbox style=\"display:none;\"><br>";

echo "<form method=post action=\"pc.php?func=tagsave\" class=catchtagsareaform><input type=hidden name=woid value=\"$pcwo\"><input type=hidden name=pcid value=\"$pcid\">";

echo "<div class=\"checkbox\">";

$pcownertagsarray = explode_list($pcownertags);

echo "<table><tr><td style=\"vertical-align:top\">";

$rs_sq = "SELECT * FROM custtags WHERE tagenabled = '1' ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_sq);

$totaltags = mysqli_num_rows($rs_result1);
$halftags = ceil($totaltags / 2) + 1;
$tagcounter = 0;

while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$tagid = "$rs_result_q1->tagid";
$thetag = "$rs_result_q1->thetag";
$tagicon = "$rs_result_q1->tagicon";
$tagenabled = "$rs_result_q1->tagenabled";
$theorder = "$rs_result_q1->theorder";
$primero = mb_substr("$thetag", 0, 1);
$tagcounter++;

if($tagcounter == $halftags) {
echo "</td><td style=\"vertical-align:top\">";
}

if("$primero" == "-") {
$thetag = mb_substr("$thetag", 1);
echo "<span class=\"linkbuttontiny linkbuttongraylabel radiusall\">$thetag</span><br>";
} else {
$tagcheck = "";
if(in_array($tagid, $pcownertagsarray)) {
$tagcheck = "checked";
}
echo "<input type=checkbox $tagcheck id=\"$tagid\" value=\"$tagid\" name=\"tags[]\">
<label for=\"$tagid\"><img src=images/tags/$tagicon width=16> $thetag</input></label><br>";
}
}

echo "<br><input class=button type=submit value=\"".pcrtlang("Save Tags")."\"></form>";

echo "</td></tr></table>";

echo "</div></div>";

?>
<script type='text/javascript'>
$('#tagchange').click(function(){
  $('#tagselectorbox').toggle('1000');
  $("i",this).toggleClass("fa-chevron-up fa-chevron-down");
});
</script>

<script type='text/javascript'>
$(document).ready(function(){
$('.catchtagsareaform').submit(function(e) { // catch the form's submit event
        e.preventDefault();
        $.ajax({ // create an AJAX call...
        data: $(this).serialize(), // get the form data
        type: $(this).attr('method'), // GET or POST
        url: $(this).attr('action'), // the file to call
        success: function(response) { // on success..
                $.get('ajaxhelpers.php?func=tagsarea&pcwo=<?php echo "$pcwo"; ?>&pcid=<?php echo "$pcid"; ?>', function(data) {
                $('#tagsarea').html(data);
                });
    }
    });
});
});
</script>


<?php


}




function credarea() { 
require("deps.php");
require_once("common.php");

$pcwo = $_REQUEST['pcwo'];
$pcid = $_REQUEST['pcid'];
$pcgroupid = $_REQUEST['pcgroupid'];


?>
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



if ($gomodal == 1) {
$therel = "rel=facebox";
} else {
$therel = "";
}


require("patterns.php");

if(perm_check("34")) {
if($pcgroupid != 0) {
$credgroupsql = " OR groupid = '$pcgroupid' ";
} else {
$credgroupsql = "";
}
} else {
$credgroupsql = "";
}

$rs_findcreds = "SELECT * FROM creds WHERE pcid = '$pcid' $credgroupsql ORDER BY groupid,creddate DESC";
$rs_result_creds = mysqli_query($rs_connect, $rs_findcreds);
while($rs_result_qcreds = mysqli_fetch_object($rs_result_creds)) {
$credid = "$rs_result_qcreds->credid";
$creddesc = "$rs_result_qcreds->creddesc";
$creduser = "$rs_result_qcreds->creduser";
$credpass = "$rs_result_qcreds->credpass";
$patterndata = "$rs_result_qcreds->patterndata";
$credtype = "$rs_result_qcreds->credtype";
$creddate2 = "$rs_result_qcreds->creddate";
$credgroupid = "$rs_result_qcreds->groupid";

if($credgroupid == 0) {
$badgestyle = "passbadge";
} else {
$badgestyle = "passbadge2";
}


$creddate = pcrtdate("$pcrt_mediumdate", "$creddate2");

if($credtype == 1) {
echo "<table class=\"$badgestyle\"><tr><td><i class=\"fa fa-lock fa-2x\"></i></td>";
echo "<td><strong>$creddesc</strong> &bull; <span class=sizemesmaller>$creddate</span>";
echo "<span class=floatright>";

if (($pcgroupid != 0) && ($credgroupid == 0)) {
echo "<a href=\"pc.php?func=movecred&woid=$pcwo&groupid=$pcgroupid&credid=$credid&moveto=group&pcid=$pcid\" class=\"catchcredarealink linkbuttonsmall linkbuttongray radiusall\">
<i class=\"fa fa-group fa-lg\"></i></a>";
} elseif ($pcgroupid != 0) {
echo "<a href=\"pc.php?func=movecred&woid=$pcwo&groupid=$pcgroupid&credid=$credid&moveto=wo&pcid=$pcid\" class=\"catchcredarealink linkbuttonsmall linkbuttongray radiusall\">
<i class=\"fa fa-clipboard fa-lg\"></i></a>";
}


echo "<a href=\"pc.php?func=editcred&woid=$pcwo&credid=$credid&credtype=$credtype&returnto=wo&pcid=$pcid\" class=\"linkbuttonsmall linkbuttongray radiusleft\" rel=facebox>
<i class=\"fa fa-edit fa-lg\"></i></a>";

echo "<a href=\"javascript:void(0);\" class=\"showdeletecred linkbuttongray linkbuttonsmall\"><i class=\"fa fa-trash fa-lg\"></i>
</a><a href=\"pc.php?func=deletecred&woid=$pcwo&credid=$credid&returnto=wo&pcid=$pcid\"
class=\"linkbuttonred linkbuttonsmall catchcredarealink radiusright\" style=\"display:none\"><i class=\"fa fa-check fa-lg\"></i> ".pcrtlang("Are you sure?")."</a>";

echo "</span>";

echo "<br><i class=\"fa fa-user\"></i> $creduser
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class=\"fa fa-key\"></i> $credpass";
echo "</td></tr></table>";
}

if($credtype == 2) {
echo "<table class=\"$badgestyle\"><tr><td><i class=\"fa fa-thumb-tack fa-2x\"></i></td>";
echo "<td><strong>$creddesc</strong> &bull; <span class=sizemesmaller>$creddate</span>";
echo "<span class=floatright>";

if (($pcgroupid != 0) && ($credgroupid == 0)) {
echo "<a href=\"pc.php?func=movecred&woid=$pcwo&groupid=$pcgroupid&credid=$credid&moveto=group&pcid=$pcid\" class=\"catchcredarealink linkbuttonsmall linkbuttongray radiusall\">
<i class=\"fa fa-group fa-lg\"></i></a>";
} elseif ($pcgroupid != 0) {
echo "<a href=\"pc.php?func=movecred&woid=$pcwo&groupid=$pcgroupid&credid=$credid&moveto=wo&pcid=$pcid\" class=\"catchcredarealink linkbuttonsmall linkbuttongray radiusall\">
<i class=\"fa fa-clipboard fa-lg\"></i></a>";
}


echo "<a href=\"pc.php?func=editcred&woid=$pcwo&credid=$credid&credtype=$credtype&returnto=wo&pcid=$pcid\" class=\"linkbuttonsmall linkbuttongray radiusall\" rel=facebox>
<i class=\"fa fa-edit fa-lg\"></i></a>";
echo "<a href=\"javascript:void(0);\" class=\"showdeletecred linkbuttongray linkbuttonsmall\"><i class=\"fa fa-trash fa-lg\"></i>
</a><a href=\"pc.php?func=deletecred&woid=$pcwo&credid=$credid&returnto=wo&pcid=$pcid\"
class=\"linkbuttonred linkbuttonsmall catchcredarealink radiusright\" style=\"display:none\"><i class=\"fa fa-check fa-lg\"></i> ".pcrtlang("Are you sure?")."</a>";
echo "</span>";
echo "<br><i class=\"fa fa-thumb-tack\"></i> $credpass";
echo "</td></tr></table>";
}

if($credtype == 3) {
echo "<table class=\"$badgestyle\"><tr><td><i class=\"fa fa-th fa-2x\"></i></td>";
echo "<td><strong>$creddesc</strong> &bull; <span class=sizemesmaller>$creddate</span>";
echo "<span class=floatright>";

if (($pcgroupid != 0) && ($credgroupid == 0)) {
echo "<a href=\"pc.php?func=movecred&woid=$pcwo&groupid=$pcgroupid&credid=$credid&moveto=group&pcid=$pcid\" class=\"catchcredarealink linkbuttonsmall linkbuttongray radiusall\">
<i class=\"fa fa-group fa-lg\"></i></a>";
} elseif ($pcgroupid != 0) {
echo "<a href=\"pc.php?func=movecred&woid=$pcwo&groupid=$pcgroupid&credid=$credid&moveto=wo&pcid=$pcid\" class=\"catchcredarealink linkbuttonsmall linkbuttongray radiusall\">
<i class=\"fa fa-clipboard fa-lg\"></i></a>";
}


echo "<a href=\"javascript:void(0);\" class=\"showdeletecred linkbuttongray linkbuttonsmall\"><i class=\"fa fa-trash fa-lg\"></i>
</a><a href=\"pc.php?func=deletecred&woid=$pcwo&credid=$credid&returnto=wo&pcid=$pcid\"
class=\"linkbuttonred linkbuttonsmall catchcredarealink radiusall\" style=\"display:none\"><i class=\"fa fa-check fa-lg\"></i> ".pcrtlang("Are you sure?")."</a>";
echo "</span><br>";
echo draw3x3("$patterndata","small");
echo "</td></tr></table>";
}

if($credtype == 5) {
echo "<table class=\"$badgestyle\"><tr><td><i class=\"fa fa-question-circle fa-2x\"></i></td>";
echo "<td><strong>$creddesc</strong> &bull; <span class=sizemesmaller>$creddate</span>";
echo "<span class=floatright>";

if (($pcgroupid != 0) && ($credgroupid == 0)) {
echo "<a href=\"pc.php?func=movecred&woid=$pcwo&groupid=$pcgroupid&credid=$credid&moveto=group&pcid=$pcid\" class=\"catchcredarealink linkbuttonsmall linkbuttongray radiusall\">
<i class=\"fa fa-group fa-lg\"></i></a>";
} elseif ($pcgroupid != 0) {
echo "<a href=\"pc.php?func=movecred&woid=$pcwo&groupid=$pcgroupid&credid=$credid&moveto=wo&pcid=$pcid\" class=\"catchcredarealink linkbuttonsmall linkbuttongray radiusall\">
<i class=\"fa fa-clipboard fa-lg\"></i></a>";
}

echo "<a href=\"pc.php?func=editcred&woid=$pcwo&credid=$credid&credtype=$credtype&returnto=wo&pcid=$pcid\" class=\"linkbuttonsmall linkbuttongray radiusall\" rel=facebox>
<i class=\"fa fa-edit fa-lg\"></i></a>";
echo "<a href=\"javascript:void(0);\" class=\"showdeletecred linkbuttongray linkbuttonsmall\"><i class=\"fa fa-trash fa-lg\"></i>
</a><a href=\"pc.php?func=deletecred&woid=$pcwo&credid=$credid&returnto=wo&pcid=$pcid\"
class=\"linkbuttonred linkbuttonsmall catchcredarealink radiusright\" style=\"display:none\"><i class=\"fa fa-check fa-lg\"></i> ".pcrtlang("Are you sure?")."</a>";
echo "</span>";

echo "<br><i class=\"fa fa-question\"></i> $creduser<br><i class=\"fa fa-commenting-o\"></i> $credpass";
echo "</td></tr></table>";
}



}


?>


<script type="text/javascript">
$(document).ready(function(){
$('.catchcredarealink').on('click', function (e) {
                e.preventDefault();
		 $('.ajaxspinner').toggle();
                var url = $(this).attr('href');
                $.get(url, function () {
                $.get('ajaxhelpers.php?func=credarea&pcwo=<?php echo "$pcwo"; ?>&pcid=<?php echo "$pcid"; ?>&pcgroupid=<?php echo "$pcgroupid"; ?>', function(data) {
                $('#credarea').html(data);
		 $('.ajaxspinner').toggle();
                });
                });
                });	
});
</script>


<script type="text/javascript">
$(".showdeletecred").click(function(){
$(this).next().toggle();
});
</script>


<?php



}



function wonotesarea() {
require("deps.php");
require_once("common.php");

$pcwo = $_REQUEST['pcwo'];
$notetype = $_REQUEST['notetype'];

require("ajaxcalls.php");
loadwonotes("$pcwo","$notetype");

?>
  <script type="text/javascript">
    jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        loadingImage : '../repair/jq/loading.gif',
        closeImage : '../repair/jq/closelabel.png'
      })
    })
  </script>

<?php

}


function soarea() {
require("deps.php");
require_once("common.php");

$pcwo = $_REQUEST['pcwo'];

$rs_find_so = "SELECT * FROM specialorders WHERE spowoid = '$pcwo'";
$rs_result_so = mysqli_query($rs_connect, $rs_find_so);

if(mysqli_num_rows($rs_result_so) > 0) {

echo "<br>";

start_moneybox();

echo "<span class=\"sizemelarge colormemoney boldme\">&nbsp;".pcrtlang("Special Order Parts")."&nbsp;</span><br><br>";

echo "<table style=\"padding-left:10px;padding-right:10px;\" class=moneylist>";
echo "<tr><th>".pcrtlang("Part Name")."</th><th>".pcrtlang("Qty")."</th><th>".pcrtlang("Price")."</th>";
echo "<th style=\"padding-left:10px;padding-right:10px;text-align:right;\">".pcrtlang("Supplier")."</th>";
echo "<th style=\"padding-left:10px;padding-right:10px;\">".pcrtlang("Supplier PN")."</th>";
echo "<th>".pcrtlang("Url")."</th><th>".pcrtlang("Tracking No.")."</th>";
echo "<th>".pcrtlang("Date")."</td><th>".pcrtlang("Status")."</th>";
echo "<th>&nbsp;</th></tr>";

$statii = array(
0 => pcrtlang("Awaiting Customer Approval"),
8 => pcrtlang("Order Part"),
1 => pcrtlang("On Order"),
2 => pcrtlang("Received"),
3 => pcrtlang("Installed"),
4 => pcrtlang("Wrong Part"),
5 => pcrtlang("Bad/Damaged Part"),
6 => pcrtlang("Abandoned Part"),
7 => pcrtlang("Unable to Locate Part"),
9 => pcrtlang("Shipped")
);

while($rs_result_item_q = mysqli_fetch_object($rs_result_so)) {
$spoid = "$rs_result_item_q->spoid";
$spopartname = "$rs_result_item_q->spopartname";
$spoprice = "$rs_result_item_q->spoprice";
$spocost = "$rs_result_item_q->spocost";
$spowoid = "$rs_result_item_q->spowoid";
$sposupplierid = "$rs_result_item_q->sposupplierid";
$sposuppliername = "$rs_result_item_q->sposuppliername";
$spopartnumber = "$rs_result_item_q->spopartnumber";
$spoparturl = "$rs_result_item_q->spoparturl";
$spotracking = "$rs_result_item_q->spotracking";
$spostatus = "$rs_result_item_q->spostatus";
$spodate2 = "$rs_result_item_q->spodate";
$sponotes = "$rs_result_item_q->sponotes";
$spoquantity = "$rs_result_item_q->quantity";
$spounit_price = "$rs_result_item_q->unit_price";

$spodate = pcrtdate("$pcrt_shortdate", "$spodate2");

echo "<tr><td>".pf("$spopartname")."</td><td align=right>".qf("$spoquantity")."</td><td align=right>$money".mf("$spounit_price")."<br>$money".mf("$spoprice")."</td>";

if($sposupplierid != 0) {
$rs_find_suppliers = "SELECT * FROM suppliers WHERE supplierid = $sposupplierid";
$rs_result_supp = mysqli_query($rs_connect, $rs_find_suppliers);
$rs_result_suppq = mysqli_fetch_object($rs_result_supp);
$suppliername2 = "$rs_result_suppq->suppliername";
} else {
$suppliername2 = "$sposuppliername";
}


if(perm_check("23") && ($sposupplierid != 0)) {
echo "<td><a href=\"../store/suppliers.php?func=viewsupplier&supplierid=$sposupplierid\" class=\"linkbuttonmoney linkbuttontiny radiusall\">$suppliername2</a></td>";
} else {
echo "<td><span class=\"sizemesmaller\">".pf("$suppliername2")."</span></td>";
}

echo "<td><span class=\"sizemesmaller\">".pcrtlang("$spopartnumber")."</span></td>";
echo "<td>";
if($spoparturl != "") {
$parturl2 = addhttp("$spoparturl");
echo "<a href=\"$parturl2\" target=\"_blank\" class=\"linkbuttonmoney linkbuttontiny radiusall\"><i class=\"fa fa-external-link fa-lg\"></i></a>";
}
echo "</td>";


echo "<td>";

if($spotracking != "") {
echo "<a href=\"http://google.com/#q=".urlencode("$spotracking")."\" target=\"_blank\" class=\"linkbuttonmoney linkbuttontiny radiusall\">".pf("$spotracking")."</a></span>";
}

echo "</td>";

echo "<td><span class=\"sizemesmaller\">$spodate</span></td>";

echo "<td><span class=\"sizemesmaller boldme\">$statii[$spostatus]</span><br><span class=\"sizemesmaller\">".pf("$sponotes")."</span></td>";


echo "<td>";

echo "<a href=\"javascript:void(0);\" class=\"showdeleteso linkbuttonmoney linkbuttontiny radiusleft\"><i class=\"fa fa-trash-o fa-lg\"></i> ".pcrtlang("delete")."</a><a href=\"pc.php?func=deletespo&spoid=$spoid&spowoid=$pcwo\" class=\"catchsoarealinkdelete linkbuttonred2 linkbuttontiny\" style=\"white-space: nowrap; display:none\">".pcrtlang("Are you sure?")."</a>";
echo "<a href=\"pc.php?func=editspo&spoid=$spoid&spowoid=$pcwo\" rel=facebox class=\"linkbuttonmoney linkbuttontiny\"  style=\"white-space: nowrap\"><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("edit")."</a>";
echo "<a href=\"repcart.php?func=spoaddcart&spoid=$spoid&spowoid=$pcwo\" class=\"catchsoarealink linkbuttonmoney linkbuttontiny radiusright\" style=\"white-space: nowrap;\"><i class=\"fa fa-shopping-cart fa-lg\"></i> ".pcrtlang("Add to cart")."</a>";

echo "</td>";

echo "</tr>";


}

echo "</table>";

stop_box();

?>

<script type="text/javascript">
$(document).ready(function(){
$('.catchsoarealink').on('click', function (e) {
                e.preventDefault();
		$('.ajaxspinner').toggle();
                var url = $(this).attr('href');
                $.get(url, function () {
                $.get('ajaxhelpers.php?func=soarea&pcwo=<?php echo "$pcwo"; ?>', function(data) {
                $('#soarea').html(data);
                });
		$.get('ajaxhelpers.php?func=cartitemsandinvoices&pcwo=<?php echo "$pcwo"; ?>', function(data) {
                $('#repaircartitemsandinvoices').html(data);
		 $('.ajaxspinner').toggle();
                });
		$('html, body').animate({
        		scrollTop: $("#repaircartarea").offset().top-70
		}, 250);
                });
                });
});
</script>

<script>
$(document).ready(function(){
$('.catchsoarealinkdelete').on('click', function (e) {
                e.preventDefault();
                $('.ajaxspinner').toggle();
                var url = $(this).attr('href');
                $.get(url, function () {
                $.get('ajaxhelpers.php?func=soarea&pcwo=<?php echo "$pcwo"; ?>', function(data) {
                $('#soarea').html(data);
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


<script type="text/javascript">
$(".showdeleteso").click(function(){
$(this).next().toggle();
});
</script>


<?php


}

}


function tlarea() {
require("deps.php");
require_once("common.php");

$pcwo = $_REQUEST['pcwo'];

$rs_find_tl = "SELECT * FROM travellog WHERE tlwo = '$pcwo'";
$rs_result_tl = mysqli_query($rs_connect, $rs_find_tl);

if(mysqli_num_rows($rs_result_tl) > 0) {
echo "<br>";
start_moneybox();

echo "<span class=\"colormemoney sizemelarge boldme\">&nbsp;".pcrtlang("Mileage Log")."&nbsp;</span><br><br>";

echo "<form action=repcart.php?func=addmiles method=post id=catchtlform><table style=\"padding-left:10px;padding-right:10px;\" class=moneylist>";
echo "<tr><th><strong>".pcrtlang("Technician")."</strong></th><th><strong>".pcrtlang("Distance")."</strong></th>";
echo "<th style=\"padding-left:10px;padding-right:10px;\"><strong>".pcrtlang("Date")."</strong></th><th> </th>";
echo "</tr>";

$totaldist = 0;

while($rs_result_item_q = mysqli_fetch_object($rs_result_tl)) {
$tlid = "$rs_result_item_q->tlid";
$tlwo = "$rs_result_item_q->tlwo";
$tldate2 = "$rs_result_item_q->tldate";
$tlmiles = "$rs_result_item_q->tlmiles";
$traveluser = "$rs_result_item_q->traveluser";

$totaldist = $totaldist + $tlmiles;

$tldate = pcrtdate("$pcrt_shortdate", "$tldate2")." ".pcrtdate("$pcrt_time", "$tldate2");

echo "<tr><td>$traveluser</td><td>$tlmiles";

if("$pcrt_units" == "METRIC") {
echo pcrtlang("km");
} else {
echo " ".pcrtlang("miles");
}

echo "</td><td>$tldate</td><td><a href=pc.php?func=deletetl&tlid=$tlid&woid=$pcwo class=\"catchtllink linkbuttonmoney linkbuttontiny radiusall\"><i class=\"fa fa-trash-o fa-lg\"></i> ".pcrtlang("remove")."</a></td></tr>";

}

echo "<tr><td><strong>".pcrtlang("Total")."</strong></td><td><input type=text class=textbox size=4 name=miles value=\"$totaldist\"></td>";
echo "<td><strong>$money</strong><input type=text class=textbox size=4 name=permile> <input type=hidden name=pcwo value=$pcwo>";

if("$pcrt_units" == "METRIC") {
echo pcrtlang("per km");
} else {
echo " ".pcrtlang("per mile");
}


echo "&nbsp;&nbsp;<button class=button type=submit><i class=\"fa fa-cart-plus fa-lg\"></i> ".pcrtlang("Add to Cart")."</button></td><td></td></tr>";

echo "</table></form>";

stop_box();
echo "<br>";
}

?>

<script type='text/javascript'>
$(document).ready(function(){
$('#catchtlform').submit(function(e) { // catch the form's submit event
        e.preventDefault();
	$('.ajaxspinner').toggle();
        $.ajax({ // create an AJAX call...
        data: $(this).serialize(), // get the form data
        type: $(this).attr('method'), // GET or POST
        url: $(this).attr('action'), // the file to call
        success: function(response) { // on success..
                $.get('ajaxhelpers.php?func=cartitemsandinvoices&pcwo=<?php echo "$pcwo"; ?>', function(data) {
                $('#repaircartitemsandinvoices').html(data);
		$('html, body').animate({
                        scrollTop: $("#repaircartarea").offset().top-70
                }, 250);
		$('.ajaxspinner').toggle();
                });
                $('#catchtlform').each (function(){
                  this.reset();
                });
    }
    });
});
});
</script>

<script>
$(document).ready(function(){
$('.catchtllink').on('click', function (e) {
                e.preventDefault();
                $('.ajaxspinner').toggle();
                var url = $(this).attr('href');
                $.get(url, function () {
                $.get('ajaxhelpers.php?func=tlarea&pcwo=<?php echo "$pcwo"; ?>', function(data) {
                $('#tlarea').html(data);
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


function aparea() {
require("deps.php");
require_once("common.php");

$pcwo = $_REQUEST['pcwo'];
$pcid = $_REQUEST['pcid'];

$rs_assetphotos = "SELECT * FROM assetphotos WHERE pcid = '$pcid'";
$rs_result_aset = mysqli_query($rs_connect, $rs_assetphotos);

$assetcount = 0;

$totalassetphotos = mysqli_num_rows($rs_result_aset);

if ($totalassetphotos != "0") {

echo "<div class=\"flexassets-container\">";

while($rs_result_aset2 = mysqli_fetch_object($rs_result_aset)) {
$photofilename = "$rs_result_aset2->photofilename";
$assetphotoid = "$rs_result_aset2->assetphotoid";
$highlight = "$rs_result_aset2->highlight";

echo "<div class=\"flexassets-item\">";

if ($highlight == "0") {
$highlightstyle = "";
} else {
$highlightstyle = "style=\"background:yellow\"";
}


echo "<a href=\"pc.php?func=getpcimage&photoid=$assetphotoid\" class=\"assetpreview\"><img src=\"pc.php?func=getpcimage&photoid=$assetphotoid\" $highlightstyle class=\"assetimage\" height=75></a>";

echo "<br><a href=\"confirm.php?url=".urlencode("pc.php?func=removephoto&woid=$pcwo&pcid=$pcid&photoid=$assetphotoid&photofilename=$photofilename")."&divload=aparea&divloadcontentlink=".urlencode("ajaxhelpers.php?func=aparea&pcwo=$pcwo&pcid=$pcid")."&question=".urlencode("Are you sure you wish to delete this photo?")."\" rel=facebox class=\"linkbutton\"><i class=\"fa fa-trash fa-lg\"></i></a>";
if ($highlight == "0") {
echo "<a href=pc.php?func=highlightphoto&woid=$pcwo&pcid=$pcid&photoid=$assetphotoid class=\"linkbutton catchaplink\"><i class=\"fa fa-lightbulb-o fa-lg\"></i></a>";
} else {
echo "<a href=pc.php?func=remhighlightphoto&woid=$pcwo&pcid=$pcid&photoid=$assetphotoid class=\"linkbutton catchaplink\"><i class=\"fa fa-times fa-lg\">
</i> <i class=\"fa fa-lightbulb-o fa-lg\"></i></a>";
}

echo "</div>";
}


echo "</div>";
}

echo "<script type=\"text/javascript\" src=\"tooltip2.js\"></script>\n";

echo "<a href=pc.php?func=takepicture&pcid=$pcid&woid=$pcwo class=\"linkbuttonmedium linkbuttonblack radiusleft\"><i class=\"fa fa-camera fa-lg\"></i> ".pcrtlang("Take Asset Photos")."</a><a href=pc.php?func=addassetphoto&pcid=$pcid&woid=$pcwo rel=facebox class=\"linkbuttonblack linkbuttonmedium radiusright\"><i class=\"fa fa-upload fa-lg\"></i> ".pcrtlang("Upload Asset Photos")."</a><a name=items id=items></a>";

?>
<script>
$(document).ready(function(){
$('.catchaplink').on('click', function (e) {
                e.preventDefault();
                $('.ajaxspinner').toggle();
                var url = $(this).attr('href');
                $.get(url, function () {
                $.get('ajaxhelpers.php?func=aparea&pcwo=<?php echo "$pcwo"; ?>&pcid=<?php echo "$pcid"; ?>', function(data) {
                $('#aparea').html(data);
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


function srarea() {
require("deps.php");
require_once("common.php");

$pcwo = $_REQUEST['pcwo'];
$pcid = $_REQUEST['pcid'];

$rs_srsql = "SELECT * FROM servicereminders WHERE srpcid = '$pcid' ORDER BY srdate ASC";
$rs_result1srsql = mysqli_query($rs_connect, $rs_srsql);
$total_sr = mysqli_num_rows($rs_result1srsql);

if ($total_sr > 0) {
echo "<table class=standard><tr><th colspan=4>";
echo "<i class=\"fa fa-bell-o fa-lg fa-fw\"></i> ".pcrtlang("Service Reminders")."</th></tr>";
while($rs_result_srsql1 = mysqli_fetch_object($rs_result1srsql)) {
$srid = "$rs_result_srsql1->srid";
$srdate = "$rs_result_srsql1->srdate";
$srsent = "$rs_result_srsql1->srsent";
$srnote = nl2br("$rs_result_srsql1->srnote");
$srcanned = "$rs_result_srsql1->srcanned";

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

$srcanned4 = "";

foreach($srcanned3 as $srkey => $srval) {
$rs_srsqlc = "SELECT * FROM serviceremindercanned WHERE srid = '$srval'";
$rs_result1srsqlc = mysqli_query($rs_connect, $rs_srsqlc);
while($rs_result_srsql1c = mysqli_fetch_object($rs_result1srsqlc)) {
$srtitle = "$rs_result_srsql1c->srtitle";
$srtext = nl2br("$rs_result_srsql1c->srtext");
$srcanned4 .= "<strong>$srtitle</strong><br>$srtext<br><br>";
}
}


$srboxfill = "<strong>".pcrtlang("Service Reminder Message").":</strong><br><br>$srnote<br><br>";
$srboxfill .= "<strong>".pcrtlang("Service Reminder Standard Messages").":</strong><br><br>$srcanned4";

echo "<tr><td style=\"text-align:right\"><img src=images/reminder.png style=\"height:16px;\"></td><td>";
echo "<span class=\"sizemesmaller boldme\">$srdate</span></td>";
if ($srsent == 0) {
echo "<td style=\"vertical-align:middle;\"><span class=\"sizemesmaller boldme\">".pcrtlang("Status").": </span><span class=\"colormered sizemesmaller\">".pcrtlang("Unsent")."</span></td>";
} elseif($srsent == 1) {
echo "<td style=\"vertical-align:middle;\"><span class=\"sizemesmaller boldme\">".pcrtlang("Status").": </span><span class=\"colormeblue sizemesmaller\">".pcrtlang("Sent")."</span></td>";
} else {
echo "<td style=\"vertical-align:middle;\"><span class=\"sizemesmaller boldme\">".pcrtlang("Status").": </span><span class=\"colormeblue sizemesmaller\">".pcrtlang("Recurring")."</span></td>";
}

echo "<td style=\"vertical-align:middle;text-align:right\">&nbsp;&nbsp;&nbsp;<a href=\"javascript:void(0)\" class=\"infotext linkbuttonsmall linkbuttongray radiusleft\"><i class=\"fa fa-eye fa-lg\"></i> ".pcrtlang("view")."<span>$srboxfill</span></a>";
echo "<a href=\"servicereminder.php?func=editsr&woid=$pcwo&pcid=$pcid&srid=$srid\" class=\"linkbuttonsmall linkbuttongray\" rel=facebox><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("edit")."</a>";
echo "<a href=\"confirm.php?url=".urlencode("servicereminder.php?func=deletesr&woid=$pcwo&srid=$srid")."&divload=srarea&divloadcontentlink=".urlencode("ajaxhelpers.php?func=srarea&pcwo=$pcwo&pcid=$pcid")."&question=".urlencode("Are you sure you want to delete this Service Reminder?")."\" rel=facebox class=\"linkbuttonsmall linkbuttongray radiusright\"><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("delete")."</a></td></tr>";
}
echo "</table>";
}

?>
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

function rwoarea() {
require("deps.php");
require_once("common.php");

$pcwo = $_REQUEST['pcwo'];
$pcid = $_REQUEST['pcid'];

$rs_rwosql = "SELECT * FROM rwo WHERE pcid = '$pcid' ORDER BY rwodate ASC";
$rs_result1rwosql = mysqli_query($rs_connect, $rs_rwosql);
$total_rwo = mysqli_num_rows($rs_result1rwosql);

if ($total_rwo > 0) {
echo "<br><table class=standard><tr><th colspan=4>";
echo "<i class=\"fa fa-retweet fa-lg fa-fw\"></i> ".pcrtlang("Recurring Work Orders")."</th></tr>";
while($rs_result_rwosql1 = mysqli_fetch_object($rs_result1rwosql)) {
$rwoid = "$rs_result_rwosql1->rwoid";
$rwodate = "$rs_result_rwosql1->rwodate";
$rwointerval = "$rs_result_rwosql1->rwointerval";
$rwotask = nl2br("$rs_result_rwosql1->rwotask");
$tasksummary = "$rs_result_rwosql1->tasksummary";

echo "<td>$tasksummary<br><span class=sizemesmaller>".pcrtlang("Next Recurrence").": $rwodate</span></td><td style=\"text-align:right\">";

echo "<a href=\"rwo.php?func=editrwo&woid=$pcwo&pcid=$pcid&rwoid=$rwoid\" class=\"linkbuttonsmall linkbuttongray\" rel=facebox><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("edit")."</a>";
echo "<a href=\"confirm.php?url=".urlencode("rwo.php?func=deleterwo&woid=$pcwo&rwoid=$rwoid")."&divload=rwoarea&divloadcontentlink=".urlencode("ajaxhelpers.php?func=rwoarea&pcwo=$pcwo&pcid=$pcid")."&question=".urlencode("Are you sure you want to delete this Recurring Work Order?")."\" rel=facebox class=\"linkbuttonsmall linkbuttongray radiusright\"><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("delete")."</a></td></tr>";

}

echo "</table>";

}

?>
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



function formsarea() {
require("deps.php");
require_once("common.php");

$pcwo = $_REQUEST['pcwo'];
$pcid = $_REQUEST['pcid'];


$rs_dsql = "SELECT * FROM documents WHERE pcid = '$pcid' ORDER BY documentname ASC";
$rs_result1dsql = mysqli_query($rs_connect, $rs_dsql);
$total_documents = mysqli_num_rows($rs_result1dsql);

if ($total_documents > 0) {
echo "<br><table class=standard><tr><th colspan=1>";
echo "<i class=\"fa fa-file-alt fa-lg fa-fw\"></i> ".pcrtlang("Forms")."</th>
<th><a href=documents.php?func=chooseform&pcid=$pcid&woid=$pcwo rel=facebox class=\"linkbuttontiny linkbuttongray radiusall floatright\"><i class=\"fa fa-plus\"></i></a></th></tr>";
while($rs_result_dsql1 = mysqli_fetch_object($rs_result1dsql)) {
$documentid = "$rs_result_dsql1->documentid";
$documentname = "$rs_result_dsql1->documentname";
$documentgroupid = "$rs_result_dsql1->groupid";
$documentpcid = "$rs_result_dsql1->pcid";
$documentthesig = "$rs_result_dsql1->thesig";
$documentthesigtopaz = "$rs_result_dsql1->thesigtopaz";
$documentshowinportal = "$rs_result_dsql1->showinportal";


if(($documentthesig != "") || ($documentthesigtopaz != "")) {
$signatureexists = "yes";
} else {
$signatureexists = "no";
}


echo "<tr><td style=\"vertical-align:top\">";
echo "$documentname";

if($signatureexists == "yes") {
echo " &nbsp;<i class=\"fa fa-signature fa-lg\"></i>";
}

echo "</td>";
echo "<td>&nbsp;&nbsp;&nbsp;";
if($signatureexists != "yes") {
echo "<a href=\"documents.php?func=editform&documentid=$documentid&pcid=$pcid&woid=$pcwo\" class=\"linkbuttonsmall linkbuttongray radiusleft\"><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("edit")."</a>";
} else {
echo "<span class=\"linkbuttonsmall linkbuttongraydisabled radiusleft\" style=\"opacity:50%\"><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("edit")."</span>";
}
echo "<a href=\"confirm.php?url=".urlencode("documents.php?func=deleteform&documentid=$documentid&pcid=$pcid&woid=$pcwo")."&divload=formsarea&divloadcontentlink=".urlencode("ajaxhelpers.php?func=formsarea&pcwo=&pcid=$pcid")."&question=".urlencode("Are you sure you wish to delete this form?")."\" rel=facebox class=\"linkbuttonsmall linkbuttonred\"><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("delete")."</a>";
if($documentshowinportal == 0) {
echo "<a href=\"documents.php?func=portalswitch&documentid=$documentid&pcid=$pcid&woid=$pcwo&showinportal=1\" class=\"catchformlink linkbuttonsmall linkbuttonred\"><i class=\"fa fa-eye-slash fa-lg\"></i> ".pcrtlang("portal")."</a>";
} else {
echo "<a href=\"documents.php?func=portalswitch&documentid=$documentid&pcid=$pcid&woid=$pcwo&showinportal=0\" class=\"catchformlink linkbuttonsmall linkbuttongreen\"><i class=\"fa fa-eye fa-lg\"></i> ".pcrtlang("portal")."</a>";
}

echo "<a href=\"documents.php?func=printform&documentid=$documentid&pcid=$pcid&woid=$pcwo\" class=\"linkbuttonsmall linkbuttongray radiusright\"><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("print")."</a>";

echo "</td></tr>";
}
echo "</table>";
}

?>
<script>
$(document).ready(function(){
$('.catchformlink').on('click', function (e) {
                e.preventDefault();
                $('.ajaxspinner').toggle();
                var url = $(this).attr('href');
                $.get(url, function () {
                $.get('ajaxhelpers.php?func=formsarea&pcwo=<?php echo "$pcwo"; ?>&pcid=<?php echo "$pcid"; ?>', function(data) {
                $('#formsarea').html(data);
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


function attarea() {
require("deps.php");
require_once("common.php");

$pcwo = $_REQUEST['pcwo'];
$pcid = $_REQUEST['pcid'];

function validate_zipfile2($v_filename) {
   return preg_match('/^[a-z0-9_ -\.]+\.(zipfile|zip)$/i', $v_filename) ? '1' : '0';
}


$rs_asql = "SELECT * FROM attachments WHERE pcid = '$pcid' ORDER BY attach_date ASC";
$rs_result1asql = mysqli_query($rs_connect, $rs_asql);
$total_attachments = mysqli_num_rows($rs_result1asql);

if ($total_attachments > 0) {
echo "<br><table class=standard><tr><th colspan=3>";
echo "<i class=\"fa fa-paperclip fa-lg fa-fw\"></i> ".pcrtlang("Asset Attachments")."</th></tr>";
while($rs_result_asql1 = mysqli_fetch_object($rs_result1asql)) {
$attach_id = "$rs_result_asql1->attach_id";
$attach_title = "$rs_result_asql1->attach_title";
$attach_size = "$rs_result_asql1->attach_size";
$attach_filename = "$rs_result_asql1->attach_filename";
$attach_date = "$rs_result_asql1->attach_date";
$fileextpc = strtolower(substr(strrchr($attach_filename, "."), 1));

$fileicon = getfileicon($fileextpc);

if($attach_size == 0) {
$thebytes = "";
} else {
$thebytes = formatBytes($attach_size);
}

if(filter_var($attach_filename, FILTER_VALIDATE_URL)) {
	$fileextpc = 'url';
	$attach_link = $attach_filename.' target=_blank';
} else {
	$attach_link = "attachment.php?func=get&attach_id=$attach_id";
}

echo "<tr><td style=\"vertical-align:top\">";
echo "<a href=$attach_link title=\"$attach_date\" class=\"linkbuttonsmall linkbuttongray radiusall displayblock\">$fileicon $attach_title<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $thebytes</a></td>";
echo "<td>&nbsp;&nbsp;&nbsp;<a href=\"attachment.php?func=editattach&woid=$pcwo&attach_id=$attach_id\" class=\"linkbuttonsmall linkbuttongray radiusleft\" rel=facebox><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("edit")."</a>";
echo "<a href=\"confirm.php?url=".urlencode("attachment.php?func=deleteattach&woid=$pcwo&attach_id=$attach_id&attachfilename=$attach_filename")."&divload=attarea&divloadcontentlink=".urlencode("ajaxhelpers.php?func=attarea&pcwo=$pcwo&pcid=$pcid")."&question=".urlencode("Are you sure you wish to delete this Attachment?")."\" rel=facebox class=\"linkbuttonsmall linkbuttongray\"><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("delete")."</a>";
echo "<a href=\"attachment.php?func=moveattach&woid=$pcwo&attach_id=$attach_id&pcid=$pcid&moveto=wo\" class=\"catchattlink linkbuttonsmall linkbuttongray radiusright\"><i class=\"fa fa-arrow-right fa-lg\"></i> ".pcrtlang("move to wo")."</a>";

if (validate_zipfile2($attach_filename) == '1') {

$attach_filename_ue = urlencode($attach_filename);

if (preg_match("/d7/i", "$attach_title")) {
echo "<br><br>&nbsp;&nbsp;&nbsp;<span class=\"linkbuttonsmall linkbuttongraylabel radiusleft\">".pcrtlang("d7 import").": </span><a href=\"pc.php?func=editowner&woid=$pcwo&pcid=$pcid&attach_filename=$attach_filename\" class=\"linkbuttonsmall linkbuttongray\" rel=facebox>".pcrtlang("machine specs")."</a>";
echo "<a href=\"pc.php?func=addd7note&woid=$pcwo&pcid=$pcid&attach_filename=$attach_filename_ue\" class=\"linkbuttonsmall linkbuttongray radiusright\">".pcrtlang("notes")."</a>";
}

if (preg_match("/uvk/i", "$attach_title")) {
echo "<div id=wouvklinks></div>";
?>
<script type="text/javascript">
  $.get('uvk.php?func=wouvklinks&woid=<?php echo "$pcwo"; ?>&filename=<?php echo "$attach_filename_ue"; ?>&pcid=<?php echo "$pcid"; ?>', function(data) {
    $('#wouvklinks').html(data);
  });
</script>
<?php
}


}

echo "</td></tr>";
}
echo "</table>";
}

?>
<script>
$(document).ready(function(){
$('.catchattlink').on('click', function (e) {
                e.preventDefault();
                $('.ajaxspinner').toggle();
                var url = $(this).attr('href');
                $.get(url, function () {
                $.get('ajaxhelpers.php?func=attarea&pcwo=<?php echo "$pcwo"; ?>&pcid=<?php echo "$pcid"; ?>', function(data) {
                $('#attarea').html(data);
                });
		$.get('ajaxhelpers.php?func=woattarea&pcwo=<?php echo "$pcwo"; ?>&pcid=<?php echo "$pcid"; ?>', function(data) {
                $('#woattarea').html(data);
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


function woattarea() {
require("deps.php");
require_once("common.php");

$pcwo = $_REQUEST['pcwo'];
$pcid = $_REQUEST['pcid'];

$rs_asql2 = "SELECT * FROM attachments WHERE woid = '$pcwo'";
$rs_result1asql2 = mysqli_query($rs_connect, $rs_asql2);
$total_attachments2 = mysqli_num_rows($rs_result1asql2);

if ($total_attachments2 > 0) {
echo "<table class=standard><tr><th colspan=3>";
echo "<i class=\"fa fa-paperclip fa-lg fa-fw\"></i> ".pcrtlang("Work Order Attachments")."</td></th>";
while($rs_result_asql12 = mysqli_fetch_object($rs_result1asql2)) {
$attach_id2 = "$rs_result_asql12->attach_id";
$attach_title2 = "$rs_result_asql12->attach_title";
$attach_size2 = "$rs_result_asql12->attach_size";
$attach_filename2 = "$rs_result_asql12->attach_filename";
$fileextpc2 = strtolower(substr(strrchr($attach_filename2, "."), 1));

if($attach_size2 == 0) {
$thebytes2 = "";
} else {
$thebytes2 = formatBytes($attach_size2);
}

$fileicon2 = getfileicon($fileextpc2);


if(filter_var($attach_filename2, FILTER_VALIDATE_URL)) {
        $fileextpc2 = 'url';
        $attach_link2 = $attach_filename2.' target=_blank';
} else {
        $attach_link2 = "attachment.php?func=get&attach_id=$attach_id2";
}

echo "<tr><td>";
echo "<a href=$attach_link2 class=\"linkbuttonsmall linkbuttongray radiusall displayblock\">$fileicon2 $attach_title2<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $thebytes2</a></td>";
echo "<td>&nbsp;&nbsp;&nbsp;<a href=\"attachment.php?func=editattach&woid=$pcwo&attach_id=$attach_id2\" class=\"linkbuttonsmall linkbuttongray radiusleft\" rel=facebox><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("edit")."</a>";
echo "<a href=\"confirm.php?url=".urlencode("attachment.php?func=deleteattach&woid=$pcwo&attach_id=$attach_id2&attachfilename=$attach_filename2")."&divload=woattarea&divloadcontentlink=".urlencode("ajaxhelpers.php?func=woattarea&pcwo=$pcwo&pcid=$pcid")."&question=".urlencode("Are you sure you wish to delete this Attachment?")."\" rel=facebox class=\"linkbuttonsmall linkbuttongray\"><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("delete")."</a>";
echo "<a href=\"attachment.php?func=moveattach&woid=$pcwo&attach_id=$attach_id2&pcid=$pcid&moveto=asset\" class=\"catchwoattlink linkbuttonsmall linkbuttongray radiusright\"><i class=\"fa fa-arrow-left fa-lg\"></i> ".pcrtlang("move to asset")."</a>";
echo "</td></tr>";
}
echo "</table><br>";
}

?>
<script>
$(document).ready(function(){
$('.catchwoattlink').on('click', function (e) {
                e.preventDefault();
                $('.ajaxspinner').toggle();
                var url = $(this).attr('href');
                $.get(url, function () {
                $.get('ajaxhelpers.php?func=woattarea&pcwo=<?php echo "$pcwo"; ?>&pcid=<?php echo "$pcid"; ?>', function(data) {
                $('#woattarea').html(data);
                });
		$.get('ajaxhelpers.php?func=attarea&pcwo=<?php echo "$pcwo"; ?>&pcid=<?php echo "$pcid"; ?>', function(data) {
                $('#attarea').html(data);
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



switch($func) {

    default:
    nothing();
    break;

    case "refreshnotifications":
    refreshnotifications();
    break;

    case "otherworkorderinfo":
    otherworkorderinfo();
    break;

    case "cartitemsandinvoices":
    cartitemsandinvoices();
    break;

    case "timersarea":
    timersarea();
    break;

    case "tagsarea":
    tagsarea();
    break;

    case "credarea":
    credarea();
    break;

    case "wonotesarea":
    wonotesarea();
    break;

    case "soarea":
    soarea();
    break;

    case "tlarea":
    tlarea();
    break;

    case "aparea":
    aparea();
    break;

    case "srarea":
    srarea();
    break;

    case "rwoarea":
    rwoarea();
    break;

    case "formsarea":
    formsarea();
    break;

    case "attarea":
    attarea();
    break;

    case "woattarea":
    woattarea();
    break;


}



