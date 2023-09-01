<?php 

/***************************************************************************
 *   copyright            : (C) 2020 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/

require("validate2.php");

require("deps.php");
require_once("common.php");

$startpagetimewo = microtime(true);

if (isset($_REQUEST['pcwo'])) {
$pcwo = $_REQUEST['pcwo'];
} else {
$pcwo = "";
}

if (isset($_REQUEST['scrollto'])) {
$scrollto = $_REQUEST['scrollto'];
} else {
$scrollto = "top";
}

if ($gomodal == 1) {
$therel = "rel=facebox";
} else {
$therel = "";
}

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


$storeinfoarray = getstoreinfo($wostoreid);

if ($custassetsindb2 != "") {
$custassetsindb3 = unserialize($custassetsindb2);
} else {
$custassetsindb3 = array();
}

if(is_array($custassetsindb3)) {
$custassetsindb = $custassetsindb3;
} else {
$custassetsindb = array();
}

if ($theprobsindb2 != "") {
$theprobsindb3 = unserialize($theprobsindb2);
} else {
$theprobsindb3 = array();
}

if (is_array($theprobsindb3)) {
$theprobsindb = $theprobsindb3;
} else {
$theprobsindb = array();
}


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

$custompcinfoindb = serializedarraytest($pcextra);


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
$probdesc2 = urlencode($probdesc);


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

$rs_qce = "SELECT actionid FROM userlog WHERE reftype = 'woid' AND refid = '$pcwo'";
$rs_resultce1 = mysqli_query($rs_connect, $rs_qce);
$actionids = array();
while($rs_result_qce1 = mysqli_fetch_object($rs_resultce1)) {
$actionids[] = "$rs_result_qce1->actionid";
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


echo "<script>document.title = \"".addslashes("$pcname")." #$pcwo\";</script>";


if("$pccompany" == "") {
$titlefill = "<span class=\"colormewhite sizemelarger textoutline\">$pcname &bull; $pcmake</span><span class=\"colormewhite sizemelarger textoutline\" style=\"float:right;\"><i class=\"fa fa-tag fa-lg\"></i> $pcid</span>";
} else {
$titlefill = "<span class=\"colormewhite sizemelarger textoutline\">$pcname &bull; $pccompany &bull; $pcmake</span><span  class=\"colormewhite sizemelarger textoutline\"  style=\"float:right;\"><i class=\"fa fa-tag fa-lg\"></i> $pcid</span>";
}


$boxstyles = getboxstyle("$pcstatus");

echo "<div id=toparea></div>";

start_color_boxnobottomround("$pcstatus","$titlefill");

$rs_find_items = "SELECT * FROM repaircart WHERE pcwo = '$pcwo' ORDER BY addtime ASC";
$rs_find_result = mysqli_query($rs_connect, $rs_find_items);
$rs_chargewhatcount = mysqli_num_rows($rs_find_result);

echo "<div class=\"nvbar\" style=\"margin:-10px\">";

echo "<div class=\"nvdropdown\">";
echo "<button class=\"nvdropbtn\"><i class=\"fa fa-user fa-lg\"></i> ".pcrtlang("Owner/Device");
echo " <i class=\"fa fa-caret-down\"></i>";
echo "</button>";
echo "<div class=\"nvdropdown-content\">";

echo "<a href=pc.php?func=editowner&pcid=$pcid&woid=$pcwo rel=facebox><img src=images/customeredit.png class=menuicon> ".pcrtlang("Edit Owner/Device Info")."</a>";
if ($ipofpc == "admin") {
echo "<a href=admin.php?func=admindeletepc&pcid=$pcid onClick=\"return confirm('".pcrtlang("Are you sure you wish to permanently delete this Customer/Device and all associated Work Orders!!!?")."');\"><img src=images/trash.png class=menuicon> ".pcrtlang("Delete this Customer/Device")." </a>";
}
if ($pcgroupid != "0") {
echo "<a href=group.php?func=removefromgroup&pcid=$pcid&woid=$pcwo onClick=\"return confirm('".pcrtlang("Are you sure you wish to remove this PC/Customer from this Group?")."');\"><img src=images/groupremove.png class=menuicon> ".pcrtlang("Remove From Group")."</a>";
echo "<a href=group.php?func=viewgroup&pcgroupid=$pcgroupid><img src=images/groups.png class=menuicon> ".pcrtlang("View Group")."</a>";
} else {
echo "<a href=group.php?func=addtogroup&pcid=$pcid&woid=$pcwo&pcname=$pcname2><img src=images/groupadd.png class=menuicon> ".pcrtlang("Add to Group")."</a>";
echo "<a href=group.php?func=addtogroupnew&pcid=$pcid&woid=$pcwo&groupname=$pcname2&grpcompany=$pccompany2&pccompany=$pccompany2&pcaddress1=$pcaddress12&pcaddress2=$pcaddress22&pccity=$pccity2&pcstate=$pcstate2&pczip=$pczip2&pcemail=$pcemail2&pchomephone=$pchomephone2&pccellphone=$pccellphone2&pcworkphone=$pcworkphone2><img src=images/groupadd.png class=menuicon> ".pcrtlang("Add to New Group")."</a>";
}
echo "<a href=attachment.php?func=add&pcid=$pcid&attachtowhat=pcid&pcwo=$pcwo $therel><img src=images/attachment.png class=menuicon> ".pcrtlang("Add Attachment to Device")."</a>";
echo "<a href=servicereminder.php?func=addsr&pcid=$pcid&pcwo=$pcwo $therel><img src=images/reminder.png class=menuicon> ".pcrtlang("Add Service Reminder")."</a>";
echo "<a href=rwo.php?func=addrwo&pcid=$pcid&woid=$pcwo $therel><img src=images/return.png class=menuicon $therel> ".pcrtlang("Add Recurring Work Order")."</a>";
echo "<a href=documents.php?func=chooseform&pcid=$pcid&woid=$pcwo $therel><img src=images/reports.png class=menuicon $therel> ".pcrtlang("Add Form")."</a>";
echo "</div>";
echo "</div>";


echo "<div class=\"nvdropdown\">";
echo "<button class=\"nvdropbtn\"><i class=\"fa fa-clipboard fa-lg\"></i> ".pcrtlang("Work Order")." ";
echo "<i class=\"fa fa-caret-down\"></i>";
echo "</button>";
echo "<div class=\"nvdropdown-content\">";
echo "<a href=\"pc.php?func=editproblem&woid=$pcwo&custname=$pcname2\" $therel><img src=images/woedit.png class=menuicon> ".pcrtlang("Edit Work Order")."</a>";
echo "<a href=\"pc.php?func=movewo&woid=$pcwo&pcid=$pcid&custname=$pcname\"><img src=images/womove.png class=menuicon> ".pcrtlang("Move Work Order")."</a>";
if ($ipofpc == "admin") {
echo "<a href=admin.php?func=admindeletewo&pcwoid=$pcwo onClick=\"return confirm('".pcrtlang("Are you sure you wish to permanently delete this Work Order!!!?")."');\"><img src=images/trash.png class=menuicon> ".pcrtlang("Delete this Work Order")."</a>";
}
echo "<a href=pc.php?func=showpc&pcid=$pcid><img src=images/wohistory.png class=menuicon> ".pcrtlang("View Work Order History")."</a>";
echo "<a href=pc.php?func=workorderaction&woid=$pcwo><img src=images/woaction.png class=menuicon> ".pcrtlang("View Work Order Action Log")."</a>";
echo "<a href=attachment.php?func=add&woid=$pcwo&attachtowhat=woid&pcwo=$pcwo $therel><img src=images/attachment.png class=menuicon> ".pcrtlang("Add Attachment to Work Order")."</a>";
echo "<a href=\"sticky.php?func=addsticky&stickyname=$pcname2&stickycompany=$pccompany2&stickyaddy1=$pcaddress12&stickyaddy2=$pcaddress22&stickycity=$pccity2&stickystate=$pcstate2&stickyzip=$pczip2&stickyemail=$pcemail2&stickyphone=$pcphone2&stickyrefid=$pcwo&stickyreftype=woid&stickynote=$probdesc2\" $therel><img src=images/sticky.png class=menuicon> ".pcrtlang("Create a Sticky Note")."</a>";

if($rs_chargewhatcount == "0") {
echo "<a href=pc.php?func=checkout&woid=$pcwo  class=catchstatuschange><img src=images/logout.png class=menuicon> ".pcrtlang("Close Work Order")."</a>";
} else {
echo "<a href=pc.php?func=checkout&woid=$pcwo onClick=\"return confirm('".pcrtlang("This Work Order has charges or invoices specified. Are you sure you want to checkout WITHOUT FINALIZING A SALE?")."');\"><img src=images/logout.png class=menuicon> ".pcrtlang("Close Work Order")."</a>";
}

echo "</div>";
echo "</div>";


echo "<div class=\"nvdropdown\">";
echo "<button class=\"nvdropbtn\"><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Print")." ";
echo "<i class=\"fa fa-caret-down\"></i>";
echo "</button>";
echo "<div class=\"nvdropdown-content\">";
echo "<a href=\"pc.php?func=printclaimticket&woid=$pcwo\"><i class=\"fa fa-ticket fa-lg fa-fw\"></i> ".pcrtlang("Claim Ticket")."</a>";
echo "<a href=\"pc.php?func=printthankyou&woid=$pcwo&pcname=$pcname2\"><i class=\"fa fa-star fa-lg fa-fw\"></i> ".pcrtlang("Thank You Letter")."</a>";
$probdesc_ss = addslashes($probdesc);
echo "<a href=\"pc.php?func=printit&woid=$pcwo\" onClick=\"return confirm('".pcrtlang("Did you repair the following").":\\n $probdesc_ss \\n \\n ".pcrtlang("REMOVE ANY CDS OR FLASH DRIVES FROM THE DEVICE! DO IT NOW!!! DO NOT WAIT!!!!!!")."');\"><i class=\"fa fa-file fa-lg fa-fw\"></i> ".pcrtlang("Repair Report")."</a>";
echo "<a href=\"printpricecard.php?func=printpricecard&woid=$pcwo\"><i class=\"fa fa-money fa-lg fa-fw\"></i> ".pcrtlang("Price Tent")."</a>";
echo "<a href=\"pc.php?func=printcheckoutreceipt&woid=$pcwo\"><i class=\"fa fa-sign-out fa-lg fa-fw\"></i> ".pcrtlang("Checkout Receipt")."</a>";
echo "<a href=\"pc.php?func=benchsheet&woid=$pcwo\"><i class=\"fa fa-plug fa-lg fa-fw\"></i> ".pcrtlang("Bench Sheet")."</a>";
echo "<li><i class=\"fa fa-tags fa-lg\"></i> ".pcrtlang("Labels")."</li>";
$backurl = urlencode("index.php?pcwo=$pcwo");
echo "<a href=\"repairlabel.php?pcid=$pcid&name=$pcname2&company=$pccompany2&woid=$pcwo&pcmake=$pcmake2&pcphone=$pcphone2&dymojsapi=html&backurl=$backurl\"><i class=\"fa fa-tag fa-lg fa-fw\"></i> ".pcrtlang("Asset Label")."</a>";
echo "<a href=\"addresslabel.php?pcname=$pcname2&pccompany=$pccompany2&pcaddress1=$pcaddress12&pcaddress2=$pcaddress2&pccity=$pccity2&pcstate=$pcstate2&pczip=$pczip2&dymojsapi=html&backurl=$backurl\"><i class=\"fa fa-envelope fa-lg fa-fw\"></i> ".pcrtlang("Address Label")."</a>";

echo "</div>";
echo "</div>";


echo "<div class=\"nvdropdown\">";
echo "<button class=\"nvdropbtn\"><i class=\"fa fa-envelope fa-lg\"></i> ".pcrtlang("Email")." ";
echo "<i class=\"fa fa-caret-down\"></i>";
echo "</button>";
echo "<div class=\"nvdropdown-content\">";
echo "<a href=\"pc.php?func=emailclaimticket&woid=$pcwo&email=$pcemail2\" $therel><i class=\"fa fa-ticket fa-lg fa-fw\"></i> ";
echo pcrtlang("Claim Ticket");
if (in_array(12, $actionids)) {
echo "<span class=colormegreen> <i class=\"fa fa-check-circle fa-lg\"></i></span>";
}
echo "</a>";
echo "<a href=\"pc.php?func=emailthankyou&woid=$pcwo&email=$pcemail2&pcname=$pcname2\" rel=\"facebox\"><i class=\"fa fa-star fa-lg fa-fw\"></i> ";
echo pcrtlang("Thank You Letter");
if (in_array(25, $actionids)) {
echo "<span class=colormegreen> <i class=\"fa fa-check-circle fa-lg\"></i></span>";
}
echo "</a>";
echo "<a href=\"pc.php?func=emailit&woid=$pcwo&email=$pcemail2\" $therel onClick=\"return confirm('".pcrtlang("Did you repair the following:")." $probdesc.  ".pcrtlang("CHECK THE OPTICAL DRIVE FOR BENCH CDS! DO IT NOW!!! DO NOT WAIT!!!!!!")."');\"><i class=\"fa fa-file fa-lg fa-fw\"></i> ";
echo pcrtlang("Repair Report");
if (in_array(6, $actionids)) {
echo "<span class=colormegreen> <i class=\"fa fa-check-circle fa-lg\"></i></span>";
}
echo "</a>";
echo "</div>";
echo "</div>";


$rs_findstatii = "SELECT * FROM boxstyles WHERE selectablestatus = '1' ORDER BY displayedorder ASC";
$rs_result_st = mysqli_query($rs_connect, $rs_findstatii);
while($rs_result_stq = mysqli_fetch_object($rs_result_st)) {
$thestatii[] = "$rs_result_stq->statusid";
}
$thestaticstatii = $thestatii;
#if ($rs_chargewhatcount == 0) {
#$thestatiisub = array(4,6,7);
#$thestatii = array_diff($thestatii, $thestatiisub);
#}

if(count($thestaticstatii) <= 200) {
echo "<div class=\"nvdropdown\">";
$lighter = adjustBrightness("$boxstyles[selectorcolor]", 75);
echo "<button class=\"nvdropbtn\"><i class=\"fa fa-window-maximize fa-lg\"  style=\"color:$lighter;\"></i> ".pcrtlang("Status").": $boxstyles[boxtitle] ";
echo "<i class=\"fa fa-caret-down\"></i>";
echo "</button>";
echo "<div class=\"nvdropdown-content\">";

$countthestatus = 0;
echo "<table style=\"border-collapse:collapse;padding:0;\"><tr><td style=\"vertical-align:top;padding:0px;\">";
reset($thestatii);
foreach($thestatii as $k => $v) {
$rs_gets2 = "SELECT * FROM boxstyles WHERE statusid = '$v'";
$rs_results2 = mysqli_query($rs_connect, $rs_gets2);
$rs_result_qs2 = mysqli_fetch_object($rs_results2);
$selectorcolor2 = "$rs_result_qs2->selectorcolor";
$boxtitle2 = "$rs_result_qs2->boxtitle";
if($pcstatus != $v) {
$countthestatus++;
echo "<a href=\"pc.php?func=stat_change&woid=$pcwo&statnum=$v\" class=catchstatuschange><i class=\"fa fa-window-maximize fa-lg\"  style=\"color:#$selectorcolor2;\"></i> $boxtitle2</a>";
}

if(($countthestatus % 15) == 0) {
echo "</td><td style=\"vertical-align:top;padding:0px;\">";
}

}

echo "</td></tr></table>";
echo "</div>";
echo "</div>";
}


if($pcgroupid != "0") {
echo "<a href=\"group.php?func=viewgroup&pcgroupid=$pcgroupid\" style=\"float:right;\" class=boldme><i class=\"fa fa-group fa-lg\"></i> $pcgroupname</a>";
}


echo "</div><br>";








echo "<table style=\"border-collapse:collapse;margin:0px;padding:0px;width:100%;\"><tr width=100%><td style=\"padding:10px 20px 0px 0px;width:50%;vertical-align:top;\">";


$boxstyles = getboxstyle("$pcstatus");
echo "<table style=\"border-collapse:collapse;margin:0px;padding:0px;\"><tr><td valign=top>";

if (($pcphone != "") || ($pcworkphone != "") || ($pccellphone != "")) {

echo "<table style=\"border-collapse:collapse;margin:0px;padding:0px;width:100%;\"><tr><td bgcolor=#$boxstyles[selectorcolor] style=\"border-radius:3px;\"><i class=\"fa fa-phone fa-lg\" style=\"color:#ffffff;padding:20px 3px;\"></i></td><td>";

echo "<table style=\"border-collapse:collapse;margin:0px;padding:0px;width:100%;\">";

if($pcphone != "") {
echo "<tr><td style=\"text-align:right\">";
if($prefcontact == "home") {
echo "<span style=\"color: #$boxstyles[selectorcolor];\"><i class=\"fa fa-home fa-lg fa-fw\"></i></span>";
} else {
echo "<i class=\"fa fa-home fa-lg fa-fw\"></i>";
}
echo "</td><td><strong>$pcphone</strong></td></tr>";
}

if($pccellphone != "") {
echo "<tr><td style=\"text-align:right\">";
if($prefcontact == "mobile") {
echo "<span style=\"color: #$boxstyles[selectorcolor];\"><i class=\"fa fa-mobile fa-lg fa-fw\"></i></span>";
} else {
echo "<i class=\"fa fa-mobile fa-lg fa-fw\"></i>";
}

echo "</td><td><strong>$pccellphone</strong>";

echo "</td></tr>";
}

if($pcworkphone != "") {
echo "</td><td style=\"text-align:right\">";
if($prefcontact == "work") {
echo "<span style=\"color: #$boxstyles[selectorcolor];\"><i class=\"fa fa-suitcase fa-lg fa-fw\"></i></span>";
} else {
echo "<i class=\"fa fa-suitcase fa-lg fa-fw\"></i>";
}

echo "</td><td><strong>$pcworkphone</strong>";
echo "</td></tr>";
}
echo "</table>";
echo "</td></tr></table>";
}

echo "</td><td>&nbsp;&nbsp;</td><td valign=top>";

if($pcaddress != "") {
$pcaddressbr = nl2br($pcaddress);
echo "<table cellpadding=2 cellspacing=0 border=0><tr><td bgcolor=#$boxstyles[selectorcolor] style=\"border-radius:3px;\"><i class=\"fa fa-map-marker fa-lg\"  style=\"padding:20px 5px; color:#ffffff;\"></i></td><td style=\"padding:5px;\"><strong>$pcaddressbr</strong><br>";
if($pcaddress2 != "") {
echo "<strong>$pcaddress2</strong><br>";
}

$addystring = urlencode("$pcaddress $pccity $pcstate $pczip");
echo "<strong>$pccity, $pcstate $pczip</strong>";
echo "<br><a href=pc.php?func=callmap&woid=$pcwo&pcid=$pcid class=\"linkbuttonsmall linkbuttongray radiusleft\"><i class=\"fa fa-map fa-lg\"></i> ".pcrtlang("map")."</a>";
echo "<a href=pc.php?func=addmiles&woid=$pcwo&addystring=$addystring rel=facebox class=\"linkbuttonsmall linkbuttongray radiusright\"><i class=\"fa fa-car fa-lg\"></i> ".pcrtlang("add mileage")."</a>";
echo "</td></tr></table>";
}

echo "</td></tr></table>";


if($pcemail != "") {
echo "<br>";
if($prefcontact == "email") {
echo "<a href=mailto:$pcemail class=\"linkbuttonsmall linkbuttongray radiusall\"><span style=\"color: #$boxstyles[selectorcolor];\"><i class=\"fa fa-envelope\"></i></span> $pcemail</a>";
} else {
echo "<a href=mailto:$pcemail class=\"linkbuttonsmall linkbuttongray radiusall\"><i class=\"fa fa-envelope\"></i> $pcemail</a>";
}
echo "<br>";
}


if($custsourceid != "0") {
$rs_cssq = "SELECT * FROM custsource WHERE custsourceid='$custsourceid'";
$rs_result1cs = mysqli_query($rs_connect, $rs_cssq);
while($rs_result_qcs1 = mysqli_fetch_object($rs_result1cs)) {
$thesource = "$rs_result_qcs1->thesource";
$sourceicon = "$rs_result_qcs1->sourceicon";
echo "<br><img src=images/custsources/$sourceicon align=absmiddle> ".pcrtlang("Customer Source").": <strong>$thesource</strong><br>";
}
}



echo "<br><table class=standard><tr><th><i class=\"fa fa-comment-o fa-lg fa-fw\"></i> ".pcrtlang("Notes")."</th></tr>";
echo "<tr><td>".parseforlinks($pcnotes)."</td></tr></table><br>";

###################
# Tags Area
echo "<br><table class=standard><tr><th><i class=\"fa fa-tags fa-lg fa-fw\"></i> ".pcrtlang("Tags")."</th></tr><tr><td>";
echo "<div id=tagsarea><table class=standard><tr><td>&nbsp;</td></tr></table></div>";
echo "</td></tr></table><br>";

?>
<script type="text/javascript">
$(document).ready(function () {
                $.get('ajaxhelpers.php?func=tagsarea&pcwo=<?php echo "$pcwo"; ?>&pcid=<?php echo "$pcid"; ?>&pcgroupid=<?php echo "$pcgroupid"; ?>', function(data) {
                $('#tagsarea').html(data);
                });
});
</script>
<?php


###############

echo "<table class=standard><tr><th>";

echo "<i class=\"fa fa-key fa-lg fa-fw\"></i> ".pcrtlang("Credentials")."</th>";
echo "<th style=\"text-align:right;\">";

echo "&nbsp;&nbsp;&nbsp;<a href=\"javascript:void(0);\" class=\"linkbuttontiny linkbuttongray radiusall\" id=pass1change>
<i class=\"fa fa-lock\"></i></a> ";

echo "&nbsp;&nbsp;&nbsp;<a href=\"javascript:void(0);\" class=\"linkbuttontiny linkbuttongray radiusall\" id=pass2change>
<i class=\"fa fa-thumb-tack\"></i></a> ";

echo "&nbsp;&nbsp;&nbsp;<a href=\"javascript:void(0);\" class=\"linkbuttontiny linkbuttongray radiusall\" id=pass3change>
<i class=\"fa fa-th\"></i></a>";

echo "&nbsp;&nbsp;&nbsp;<a href=\"javascript:void(0);\" class=\"linkbuttontiny linkbuttongray radiusall\" id=pass5change>
<i class=\"fa fa-question-circle\"></i></a>";


echo "</th>";
echo "</tr><tr><td colspan=2>";

echo "<div id=pass1box style=\"display:none;border:2px #cccccc solid;padding:5px;border-radius:3px;\">";
echo "<form action=pc.php?func=newpass method=post class=catchcredareaform><input type=hidden name=woid value=$pcwo><input type=hidden name=pcid value=$pcid><input type=hidden name=credtype value=1><input type=hidden name=returnto value=wo>";

$rs_cd = "SELECT * FROM creddesc ORDER BY creddescorder DESC";
$rs_resultcd1 = mysqli_query($rs_connect, $rs_cd);
$creddescoptions = "<option value=\"\">".pcrtlang("pick one or write your own below")."</option>";
while($rs_result_cdq1 = mysqli_fetch_object($rs_resultcd1)) {
$credtitle = "$rs_result_cdq1->credtitle";
$creddescoptions .= "<option value=\"$credtitle\">$credtitle</option>";
}

echo "<select name=creddesc class=credselect1 onchange='document.getElementById(\"creddesc1box\").value=this.options[this.selectedIndex].value '>";
echo "$creddescoptions";
echo "</select><br><br>";
echo "<input type=text class=textbox id=creddesc1box name=creddesc style=\"width:250px\" placeholder=\"".pcrtlang("Description")."\"><br><br>";

echo "<input type=text class=textbox name=username placeholder=\"".pcrtlang("Enter Username")."\"><br><br>";
echo "<input type=text class=textbox name=password placeholder=\"".pcrtlang("Enter Password")."\">";
echo "<button type=submit class=sbutton><i class=\"fa fa-save\"></i></button>";


echo "</form></div>";

echo "<div id=pass2box style=\"display:none;border:2px #cccccc solid;padding:5px;border-radius:3px;\">";
echo "<form action=pc.php?func=newpass method=post class=catchcredareaform><input type=hidden name=woid value=$pcwo><input type=hidden name=pcid value=$pcid><input type=hidden name=credtype value=2><input type=hidden name=returnto value=wo>";
echo "<select name=creddesc class=credselect2 onchange='document.getElementById(\"creddesc2box\").value=this.options[this.selectedIndex].value '>";
echo "$creddescoptions";
echo "</select><br><br>";
echo "<input type=text class=textbox id=creddesc2box name=creddesc placeholder=\"".pcrtlang("Description")."\"><br><br>";
echo "<input type=text class=textbox name=password placeholder=\"".pcrtlang("Enter Pin")."\"> ";
echo "<button type=submit class=sbutton><i class=\"fa fa-save\"></i></button>";
echo "</form></div>";


echo "<div id=pass3box style=\"display:none;border:2px #cccccc solid;padding:5px;border-radius:3px;\">";
echo "<div id=patternmain></div>";
echo "<form action=pc.php?func=newpass method=post class=catchcredareaform><input type=hidden name=woid value=$pcwo><input type=hidden name=pcid value=$pcid><input type=hidden name=credtype value=3><input type=hidden name=returnto value=wo>";
echo "<select name=creddesc1 class=credselect3 onchange='document.getElementById(\"creddesc3box\").value=this.options[this.selectedIndex].value '>";
echo "$creddescoptions";
echo "</select><br><br>";
echo "<input type=text class=textbox id=creddesc3box name=creddesc style=\"width:250px\" placeholder=\"".pcrtlang("Description")."\">";
echo "<input type=hidden class=textbox name=newpattern id=patterntextbox> ";
echo "<button type=submit class=sbutton><i class=\"fa fa-save\"></i></button>";
echo "</form>";
echo "</div>";


echo "<div id=pass5box style=\"display:none;border:2px #cccccc solid;padding:5px;border-radius:3px;\">";
echo "<form action=pc.php?func=newpass method=post class=catchcredareaform><input type=hidden name=woid value=$pcwo><input type=hidden name=pcid value=$pcid><input type=hidden name=credtype value=5><input type=hidden name=returnto value=wo>";

echo "<select name=creddesc class=credselect4 onchange='document.getElementById(\"creddesc5box\").value=this.options[this.selectedIndex].value '>";
echo "$creddescoptions";
echo "</select><br><br>";
echo "<input type=text class=textbox id=creddesc5box name=creddesc style=\"width:350px\" placeholder=\"".pcrtlang("Description")."\"><br><br>";

echo "<input type=text class=textbox name=username style=\"width:350px\" placeholder=\"".pcrtlang("Enter Security Question")."\"><br><br>";
echo "<input type=text class=textbox name=password style=\"width:320px\" placeholder=\"".pcrtlang("Enter Answer")."\">";
echo " <button type=submit class=sbutton> <i class=\"fa fa-save\"></i> </button>";


echo "</form></div>";


?>
<link href="jq/patternLock.css"  rel="stylesheet" type="text/css">
<script src="jq/patternLock.js"></script>
<script type='text/javascript'>
var lock = new PatternLock("#patternmain", {
   onDraw:function(pattern){
	$('#patterntextbox').val(pattern);	
    }
});
</script>



<script type='text/javascript'>
$('#pass1change').click(function(){
  $('#pass1box').toggle('1000');
  $('#pass2box').hide('1000');
  $('#pass3box').hide('1000');
  $('#pass5box').hide('1000');
});

$('#pass2change').click(function(){
  $('#pass2box').toggle('1000');
  $('#pass1box').hide('1000');
  $('#pass3box').hide('1000');
  $('#pass5box').hide('1000');
});

$('#pass3change').click(function(){
  $('#pass3box').toggle('1000');
  $('#pass1box').hide('1000');
  $('#pass2box').hide('1000');
  $('#pass5box').hide('1000');
});

$('#pass5change').click(function(){
  $('#pass5box').toggle('1000');
  $('#pass1box').hide('1000');
  $('#pass2box').hide('1000');
  $('#pass3box').hide('1000');
});


</script>

<script src="../repair/jq/select2.min.js"></script>
<link rel="stylesheet" href="../repair/jq/select2.min.css">

<script>
$(document).ready(function() {
    $('.credselect1').select2();
    $('.credselect2').select2();
    $('.credselect3').select2();
    $('.credselect4').select2();
});
</script>

<?php


##################
# Credentials Area

echo "<div id=credarea></div>";

?>
<script type="text/javascript">
$(document).ready(function () {
                $.get('ajaxhelpers.php?func=credarea&pcwo=<?php echo "$pcwo"; ?>&pcid=<?php echo "$pcid"; ?>&pcgroupid=<?php echo "$pcgroupid"; ?>', function(data) {
                $('#credarea').html(data);
                });
});
</script>

<script type='text/javascript'>
$(document).ready(function(){
$('.catchcredareaform').submit(function(e) { // catch the form's submit event
        e.preventDefault();
	 $('.ajaxspinner').toggle();
        $.ajax({ // create an AJAX call...
        data: $(this).serialize(), // get the form data
        type: $(this).attr('method'), // GET or POST
        url: $(this).attr('action'), // the file to call
        success: function(response) { // on success..
                $.get('ajaxhelpers.php?func=credarea&pcwo=<?php echo "$pcwo"; ?>&pcid=<?php echo "$pcid"; ?>&pcgroupid=<?php echo "$pcgroupid"; ?>', function(data) {
                $('#credarea').html(data);
		 $('.ajaxspinner').toggle();
                });
                $('.catchcredareaform').each (function(){
                  this.reset();
                });
                $('#pass5box').hide('1000');
                $('#pass1box').hide('1000');
                $('#pass2box').hide('1000');
                $('#pass3box').hide('1000');
    }
    });
});
});
</script>


<?php


########################

echo "</td></tr></table><br>";

##################
# Service Reminders Area

echo "<div id=srarea></div>";

?>
<script type="text/javascript">
$(document).ready(function () {
                $.get('ajaxhelpers.php?func=srarea&pcwo=<?php echo "$pcwo"; ?>&pcid=<?php echo "$pcid"; ?>&pcgroupid=<?php echo "$pcgroupid"; ?>', function(data) {
                $('#srarea').html(data);
                });
});
</script>

<?php

#####################

##################
# Recurring Work Orders Area

echo "<div id=rwoarea></div>";

?>
<script type="text/javascript">
$(document).ready(function () {
                $.get('ajaxhelpers.php?func=rwoarea&pcwo=<?php echo "$pcwo"; ?>&pcid=<?php echo "$pcid"; ?>&pcgroupid=<?php echo "$pcgroupid"; ?>', function(data) {
                $('#rwoarea').html(data);
                });
});
</script>

<?php
#############################
# Asset Attachments Area

echo "<div id=attarea></div>";

?>
<script type="text/javascript">
$(document).ready(function () {
                $.get('ajaxhelpers.php?func=attarea&pcwo=<?php echo "$pcwo"; ?>&pcid=<?php echo "$pcid"; ?>&pcgroupid=<?php echo "$pcgroupid"; ?>', function(data) {
                $('#attarea').html(data);
                });
});
</script>

<?php



#####################
# Forms Area

echo "<div id=formsarea></div>";

?>
<script type="text/javascript">
$(document).ready(function () {
                $.get('ajaxhelpers.php?func=formsarea&pcwo=<?php echo "$pcwo"; ?>&pcid=<?php echo "$pcid"; ?>&pcgroupid=<?php echo "$pcgroupid"; ?>', function(data) {
                $('#formsarea').html(data);
                });
});
</script>

<?php

#####################



echo "</td>";
echo "<td style=\"padding:10px 0px 0px 20px; width:50%;vertical-align:top;\">";
$probdesc2 = nl2br($probdesc);

echo "<table class=standard><tr><th><i class=\"fa fa-wrench fa-lg fa-fw\"></i> ".pcrtlang("Problem/Task")."</td></th>";

echo "<tr><td>";


echo "$probdesc2<br>";

foreach($theprobsindb as $key => $val) {
echo "<strong>&bull;</strong> $val<br>";
}

echo "</td></tr></table><br>";

####################################
$rs_asql2 = "SELECT * FROM attachments WHERE woid = '$pcwo'";
$rs_result1asql2 = mysqli_query($rs_connect, $rs_asql2);
$total_attachments2 = mysqli_num_rows($rs_result1asql2);
if ($total_attachments2 > 0) {
$woattfiller = "<table class=standard><tr><th colspan=3><i class=\"fa fa-paperclip fa-lg fa-fw\"></i> ".pcrtlang("Work Order Attachments")."</th></tr><tr><td colspan=3>&nbsp;<br>&nbsp;</td></tr></table><br>";
} else {
$woattfiller = "";
}

echo "<div id=woattarea>$woattfiller</div>";
#wip
?>
<script type="text/javascript">
$(document).ready(function () {
                $.get('ajaxhelpers.php?func=woattarea&pcwo=<?php echo "$pcwo"; ?>&pcid=<?php echo "$pcid"; ?>&pcgroupid=<?php echo "$pcgroupid"; ?>', function(data) {
                $('#woattarea').html(data);
                });
});
</script>

<?php
################################


#start of other work order info div wip

echo "<table class=standard><tr><th colspan=2><i class=\"fa fa-info fa-lg fa-fw\"></i> ".pcrtlang("Other Work Order Info")."</th></tr>";

$pickdate = pcrtdate("$pcrt_mediumdate", "$pickup")." ".pcrtdate("$pcrt_time", "$pickup");

$dropdate = pcrtdate("$pcrt_mediumdate", "$dropoff")." ".pcrtdate("$pcrt_time", "$dropoff");


echo "<tr><td style=\"width:33%;\">".pcrtlang("Work Order ID").":</td><td><strong>$pcwo</strong></td></tr>";

echo "<tr><td style=\"width:33%;\">".pcrtlang("Opened On").": </td><td><strong>$dropdate</strong></td></tr>";

if ($cibyuser != "") {
echo "<tr><td>".pcrtlang("Opened By").": </td><td><strong>$cibyuser</strong></td></tr>";
}

if(($sked == 1) && ($pcstatus != 5)) {
echo "<tr><td><strong>".pcrtlang("Scheduled").":</strong></td><td>";
skedwhen("$skeddate");
echo "</td></tr>";
}

if($servicepromiseid != 0) {
echo "<tr><td><strong>".pcrtlang("Promised").":</strong></td><td style=\"vertical-align:middle;\">";
$promisedtimedisplay = pcrtdate("$pcrt_mediumdate", "$promisedtime")." ".pcrtdate("$pcrt_time", "$promisedtime");
if($pickup == "0000-00-00 00:00:00") {
echo servicepromiseicon("$promisedtime","label")."<br>";
}
echo "$promisedtimedisplay";
echo "</td></tr>";
}

if ($scid != "0") {

$rs_scn = "SELECT * FROM servicecontracts WHERE scid = '$scid'";
$rs_resultscn = mysqli_query($rs_connect, $rs_scn);
$rs_result_scn = mysqli_fetch_object($rs_resultscn);
$scname = "$rs_result_scn->scname";
$chkrinvoice = "$rs_result_scn->rinvoice";

echo "<tr><td>".pcrtlang("Service Contract").": </td><td><a href=\"msp.php?func=viewservicecontract&scid=$scid\" class=\"linkbuttonmedium linkbuttonblack radiusall\">";
echo "<i class=\"fa fa-file-text\"></i> $scname #$scid</a>";


if($scpriceid != 0) {
$rs_ql = "SELECT * FROM scprices WHERE scpriceid = '$scpriceid'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$scpriceid = "$rs_result_q1->scpriceid";
$labordesc = "$rs_result_q1->labordesc";
echo "<br><br>$labordesc";
}

if($chkrinvoice != 0) {
if(overduerinvoice($chkrinvoice) == 1) {
echo "<br><br><span class=\"colormered\"><i class=\"fa fa-warning faa-flash animated fa-lg\"></i> Service Contract has Overdue Invoices!</span>";
}
}

echo "</td></tr>";
}
echo "</table>";


echo "<div id=otherworkorderinfo>";
echo "<table class=standard><tr><td>&nbsp;<br><br></td><td>&nbsp;<br><br></td></tr><tr><td>&nbsp;</td><td>&nbsp;<br><br></td></tr><tr><td>&nbsp;<br><br></td><td>&nbsp;</td></tr><tr><td>&nbsp;<br><br></td><td>&nbsp;<br><br></td></tr><tr><td>&nbsp;<br><br></td><td>&nbsp;<br><br></td></tr><tr><td>&nbsp;<br><br></td><td>&nbsp;<br><br></td></tr></table>";
echo "</div>";

?>
<script type="text/javascript">
$(document).ready(function () {
                $.get('ajaxhelpers.php?func=otherworkorderinfo&pcwo=<?php echo "$pcwo"; ?>', function(data) {
                $('#otherworkorderinfo').html(data);
                });
                $.get('ajaxhelpers.php?func=otherworkorderinfo&pcwo=<?php echo "$pcwo"; ?>', function(data) {
                $('#otherworkorderinfo').html(data);
                });
});
</script>
<?php

echo "</td></tr></table><br>";

echo "<div id=assetinfoarea></div>";



stop_color_box();
#######################
$mainassettype = getassettypename($mainassettypeidindb);
$mainassettypeshowscans = getassettypeshowscans($mainassettypeidindb);

start_color_boxnoround("$pcstatus","$mainassettype: $pcmake");



echo "<table style=\"width:100%\"><tr><td style=\"width:50%;vertical-align:top\">";


$rs_allfindassets = "SELECT * FROM mainassetinfofields";
$rs_result2all = mysqli_query($rs_connect, $rs_allfindassets);
while ($rs_result_q2all = mysqli_fetch_object($rs_result2all)) {
$mainassetfieldid = "$rs_result_q2all->mainassetfieldid";
$mainassetfieldname = "$rs_result_q2all->mainassetfieldname";
$allassetinfofields[$mainassetfieldid] = "$mainassetfieldname";
}

$custompcinfoindb = array_filter($custompcinfoindb);

$a = 1;
$countitems = (count($custompcinfoindb) / 2);

foreach($custompcinfoindb as $key => $val) {
if(array_key_exists("$key", $allassetinfofields)) {
echo "<p class=\"assetlist\"><i class=\"fa fa-cogs fa-lg\"></i> <strong>$allassetinfofields[$key] </strong><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$val</p>";
}

if(($a >= $countitems) && ($a < ($countitems + 1))) {
echo "</td><td style=\"width:50%;vertical-align:top\">";
}

$a++;
}



echo "</td></tr></table><table width=100%><tr><td>";
if (!empty($custassetsindb)) {
echo "<span class=boldme style=\"padding-right:10px\">".pcrtlang("Accessory Assets").":</span> ";

foreach($custassetsindb as $key => $val) {

if (!array_key_exists("$val", $custassets)) {
echo "<img src=images/admin.png align=absmiddle class=assetimage style=\"border: 1px #$boxstyles[selectorcolor] solid;\"><span class=\"linkbuttongraylabel linkbuttonsmall radiusleft\" style=\"background: #$boxstyles[selectorcolor];\"> ".pcrtlang("$val")." </span>&nbsp;&nbsp;&nbsp;";
} else {
echo "<img src=images/assets/$custassets[$val] align=absmiddle class=assetimage style=\"border: 1px #$boxstyles[selectorcolor] solid;\"><span class=\"linkbuttonsmall radiusright linkbuttongraylabel\" style=\"background: #$boxstyles[selectorcolor];\"> ".pcrtlang("$val")." </span>&nbsp;&nbsp;&nbsp;";
}
}
}
echo "</span></td></tr></table>";

###############################
# Asset Photo Area
echo "<div id=aparea></div>";
?>
<script type="text/javascript">
$(document).ready(function () {
                $.get('ajaxhelpers.php?func=aparea&pcwo=<?php echo "$pcwo"; ?>&pcid=<?php echo "$pcid"; ?>', function(data) {
                $('#aparea').html(data);
                });
});
</script>
<?php
###############################

stop_color_box();
#######################################################################

$rs_findsinv_t = "SELECT * FROM invoices WHERE woid = '$pcwo' AND invstatus != '3'";
$rs_findsinv2_t = @mysqli_query($rs_connect, $rs_findsinv_t);
$rs_invoicecount = mysqli_num_rows($rs_findsinv2_t);

echo "<div id=repaircartarea></div>";
echo "<br>";
start_moneybox();




########################### Cart and Invoice Area
echo "<div id=repaircartitemsandinvoices>";
echo "</div>";
#if (($rs_chargewhatcount != 0) || ($rs_invoicecount != 0)) {

?>
<script type="text/javascript">
$(document).ready(function () {
                $.get('ajaxhelpers.php?func=cartitemsandinvoices&pcwo=<?php echo "$pcwo"; ?>', function(data) {
                $('#repaircartitemsandinvoices').html(data);
                });
});
</script>
<?php

#}

###############################

echo "<div id=addrepaircartarea></div>";

echo "<a href=\"javascript:void(0);\" class=\"linkbuttonmoney linkbuttonmedium radiusall displayblock\" id=repaircartadd>".pcrtlang("Add Labor, Items, or Deposits to Repair Cart")."
<i class=\"fa fa-chevron-down\" style=\"float:right\"></i></a>";

echo "<div id=repaircartbox style=\"display:none;\">";
echo "<div id=repaircartbox2></div>";


echo "<br><table class=moneylist><tr><th colspan=2><strong>".pcrtlang("Add Deposit")."</strong></th></tr><tr><td>";
if ($pcgroupid == 0) {
echo "<a href=\"../store/deposits.php?woid=$pcwo&cfirstname=$pcname2&ccompany=$pccompany2&caddress=$pcaddress12&caddress2=$pcaddress22&ccity=$pccity2&cstate=$pcstate2&czip=$pczip2&cphone=$pcphone2&cemail=$pcemail2\" class=\"linkbuttonmoney linkbuttonmedium radiusall\"><img src=images/deposits.png class=iconmedium> ".pcrtlang("Add a Deposit to this Work Order")."</a>";
} else {
echo "<a href=\"../store/deposits.php?woid=$pcwo&cfirstname=$ue_pcgroupname&ccompany=$ue_grpcompany&caddress=$ue_grpaddress&caddress2=$ue_grpaddress2&ccity=$ue_grpcity&cstate=$ue_grpstate&czip=$ue_grpzip&cphone=$ue_grpphone&cemail=$ue_grpemail\" class=\"linkbuttonmoney linkbuttonmedium radiusall\"><img src=images/deposits.png align=absmiddle border=0> ".pcrtlang("Add a Deposit to this Work Order")."</a>";
}

echo "</td><td>";

$finduadeposits = "SELECT * FROM deposits WHERE woid = '0' AND invoiceid = '0' AND dstatus = 'open'";
$finduadepositsq = @mysqli_query($rs_connect, $finduadeposits);

if(mysqli_num_rows($finduadepositsq) > 0) {

echo "<span class=boldme>".pcrtlang("Add Un-Attached Deposit to Work Order").": </span>";

echo "<form method=post action=\"pc.php?func=adddeposittowo\"><input type=hidden name=woid value=\"$pcwo\"><select name=depositid class=add-deposit>";

while ($finduadepositsa = mysqli_fetch_object($finduadepositsq)) {
$depositid = "$finduadepositsa->depositid";
$depositfname = "$finduadepositsa->pfirstname";
$depositlname = "$finduadepositsa->plastname";
$depositamount = "$finduadepositsa->amount";

echo "<option value=\"$depositid\">#$depositid $depositfname $depositlname - $money".mf("$depositamount")."</option>";

}
echo "</select><button type=submit class=\"button\"><i class=\"fa fa-plus fa-lg\"></i></button></form>";
}

?>
<script>
$(document).ready(function() {
    $('.add-deposit').select2();
});
</script>
<?php

echo "</td></tr></table>";

echo "</div>";

?>
<script type="text/javascript">
  $.get('addlabor.php?pcwo=<?php echo "$pcwo"; ?>', function(data) {
    $('#repaircartbox2').html(data);
  });
</script>

<script type='text/javascript'>

$('#repaircartadd').click(function(){
  $('#repaircartbox').toggle('1000');
  $("i",this).toggleClass("fa-chevron-up fa-chevron-down");
});



</script>
<?php

stop_box();


########################### Special Orders Area
echo "<div id=soarea>";
echo "</div>";

?>
<script type="text/javascript">
$(document).ready(function () {
                $.get('ajaxhelpers.php?func=soarea&pcwo=<?php echo "$pcwo"; ?>', function(data) {
                $('#soarea').html(data);
                });
});
</script>
<?php


###############################






#anchor
echo "<div id=travellogarea></div>";
echo "<br>";

####################
# Travel Log Area
####################
echo "<div id=tlarea>";
echo "</div>";

?>
<script type="text/javascript">
$(document).ready(function () {
                $.get('ajaxhelpers.php?func=tlarea&pcwo=<?php echo "$pcwo"; ?>', function(data) {
                $('#tlarea').html(data);
                });
});
</script>
<?php
#####################



echo "<a name=timers id=timers></a>";


if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}


###################################
# Timer Start
start_box();

echo "<div id=timersarea></div>";

?>
<script type="text/javascript">
$(document).ready(function () {
                $.get('ajaxhelpers.php?func=timersarea&pcwo=<?php echo "$pcwo"; ?>&pcid=<?php echo "$pcid"; ?>', function(data) {
                $('#timersarea').html(data);
                });
});
</script>
<?php

stop_box();
# Timer End
#################################
echo "<a name=pcnotes0 id=pcnotes0></a>";

echo "<br>";

echo "<div id=notesarea></div>";

start_box();

echo "<table style=\"width:100%\"><tr><td><span class=\"sizemelarge boldme\">&nbsp;".pcrtlang("Notes for Customer")."</span></td><td>";


######

echo "<a href=\"javascript:void(0);\" id=addcnote class=\"linkbutton floatright\"><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Add Customer Note")."</a></td></tr></table>";

?>
<script type='text/javascript'>
$('#addcnote').click(function() {
  $('#custnote').slideToggle(500, function() {
	$( "#custnoteta" ).focus();
  });
});
</script>
<?php

echo "<div id=custnote style=\"display:none;\">";

?>
<script type='text/javascript' src='jq/jquery.autogrow-textarea.js'></script>
<?php

echo "<form id=custnoteform action=pc.php?func=addnote2 method=post>";
echo "<div style=\"padding:10px;\"><table class=pillbox><tr><td>";
echo "<textarea id=custnoteta name=thenote required=required rows=1 class=textboxw style=\"width:98%\"></textarea>";

?>

<script type='text/javascript'>
  $(function() {
    $('textarea').autogrow();
  });
</script>

<?php

echo "</td>";
echo "<td style=\"width:125px;text-align:center;vertical-align:top;\">";
echo "<input type=hidden name=woid value=$pcwo><input type=hidden name=ajaxcall value=yes><input type=hidden name=notetype value=0>";
echo "<input type=hidden name=touch value=\"\">";
echo "<button type=submit  class=\"linkbuttongreen radiusall linkbuttonsmall\"><i class=\"fa fa-save fa-lg\"></i><br>".pcrtlang("Save")."</button></td></tr></table></div></form>";
echo "</div>";

?>
<script type='text/javascript'>
$(document).ready(function(){
$('#custnoteform').submit(function(e) { // catch the form's submit event
        e.preventDefault();
        $.ajax({ // create an AJAX call...
        data: $(this).serialize(), // get the form data
        type: $(this).attr('method'), // GET or POST
        url: $(this).attr('action'), // the file to call
        success: function(response) { // on success..
            $('#custnotearea').html(response); // update the DIV
	$('#custnoteform').each (function(){
	  this.reset();
	});
  	$('#custnote').slideToggle(1000, function() {
	});
    }
    });
});
});
</script>
<?php



###

echo "<div id=custnotearea>";

require("ajaxcalls.php");
loadwonotes("$pcwo","0");


echo "</div>";




stop_box();
echo "<a name=pcnotes1 id=pcnotes1></a>";
echo "<br>";
start_box();
#######tech notes

echo "<table style=\"width:100%\"><tr><td><span class=\"sizemelarge boldme\">&nbsp;".pcrtlang("Private Notes/Billing Instructions")."</span></td><td>";
echo "<a href=\"javascript:void(0);\" id=addtnote class=linkbutton style=\"float:right\"><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Add Private Note")."</a></td>
</tr></table>\n";


?>
<script type='text/javascript'>
$('#addtnote').click(function() {
  $('#technote').slideToggle(500, function() {
        $( "#technoteta" ).focus();
  });
});
</script>
<?php

echo "<div id=technote style=\"display:none;\">";

?>
<script type='text/javascript' src='jq/jquery.autogrow-textarea.js'></script>
<?php

echo "<form id=technoteform action=pc.php?func=addnote2 method=post>";
echo "<div style=\"padding:10px;\"><table class=pillbox><tr><td>";
echo "<textarea id=technoteta name=thenote required=required rows=1 class=textboxw style=\"width:98%\"></textarea>";

?>

<script type='text/javascript'>
  $(function() {
    $('textarea').autogrow();
  });
</script>

<?php

#echo "</div>";

echo "</td>";
echo "<td style=\"width:125px;text-align:center;vertical-align:top;\">";
echo "<input type=hidden name=woid value=$pcwo><input type=hidden name=ajaxcall value=yes><input type=hidden name=notetype value=1>";
echo "<input type=hidden name=touch value=\"\">";
echo "<button type=submit class=\"linkbuttongreen radiusall linkbuttonsmall\"><i class=\"fa fa-save fa-lg\"></i><br>".pcrtlang("Save")."</button></td></tr></table></div></form>";
echo "</div>";
?>
<script type='text/javascript'>
$(document).ready(function(){
$('#technoteform').submit(function(e) { // catch the form's submit event
        e.preventDefault();
        $.ajax({ // create an AJAX call...
        data: $(this).serialize(), // get the form data
        type: $(this).attr('method'), // GET or POST
        url: $(this).attr('action'), // the file to call
        success: function(response) { // on success..
            $('#technotearea').html(response); // update the DIV
        $('#technoteform').each (function(){
          this.reset();
        });
        $('#technote').slideToggle(1000, function() {
        });
    }
    });
});
});
</script>
<?php


echo "<div id=technotearea>";
loadwonotes("$pcwo","1");
echo "</div>";
stop_box();
echo "<br>";

echo "<a name=messages id=messages></a>";
echo "<div id=messagesarea></div>";
start_box();
####### messages

$emails = array();
if(isset($grpemail)) {
if (filter_var($grpemail, FILTER_VALIDATE_EMAIL)) {
$emails[] = "$grpemail";
}
}
if (filter_var($pcemail, FILTER_VALIDATE_EMAIL)) {
if (!in_array($pcemail, $emails)) {
$emails[] = "$pcemail";
}
}

$emailsimploded = implode_list_email($emails);



$phnumbers = array();
$smsphonenumberoptions = "";

if($pcphone != "") {
$pcphonestripped = preg_replace("/[^0-9,.]/", "", "$pcphone" );
$phnumbers[] = "$pcphonestripped";
$smsphonenumberoptions .= "<option value=\"$mysmsprefix".filtersmsnumber("$pcphone")."\">".pcrtlang("Home").": $pcphone</option>";
}

if($pccellphone != "") {
$pccellphonestripped = preg_replace("/[^0-9,.]/", "", "$pccellphone");
if (!in_array($pccellphonestripped, $phnumbers)) {
$phnumbers[] = "$pccellphonestripped";
}
$smsphonenumberoptions .= "<option selected value=\"$mysmsprefix".filtersmsnumber("$pccellphone")."\">".pcrtlang("Mobile").": $pccellphone</option>";
$smsprefill = "$mysmsprefix".filtersmsnumber("$pccellphone");
} else {
$smsprefill = "$mysmsprefix";
}

if($pcworkphone != "") {
$pcworkphonestripped = preg_replace("/[^0-9,.]/", "", "$pcworkphone");
if (!in_array($pcworkphonestripped, $phnumbers)) {
$phnumbers[] = "$pcworkphonestripped";
}
$smsphonenumberoptions .= "<option value=\"$mysmsprefix".filtersmsnumber("$pcworkphone")."\">".pcrtlang("Work").": $pcworkphone</option>";
}

if($pcgroupid != 0) {

if($grpphone != "") {
$grpphonestripped = preg_replace("/[^0-9,.]/", "", "$grpphone");
if (!in_array($grpphonestripped, $phnumbers)) {
$phnumbers[] = "$grpphonestripped";
}
$smsphonenumberoptions .= "<option value=\"$mysmsprefix".filtersmsnumber("$grpphone")."\">".pcrtlang("Home from Group").": $grpphone</option>";
}

if($grpcellphone != "") {
$grpcellphonestripped = preg_replace("/[^0-9,.]/", "", "$grpcellphone");
if (!in_array($grpcellphonestripped, $phnumbers)) {
$phnumbers[] = "$grpcellphonestripped";
}
$smsphonenumberoptions .= "<option value=\"$mysmsprefix".filtersmsnumber("$grpcellphone")."\">".pcrtlang("Mobile from Group").": $grpcellphone</option>";
}

if($grpworkphone != "") {
$grpworkphonestripped = preg_replace("/[^0-9,.]/", "", "$grpworkphone");
if (!in_array($grpworkphonestripped, $phnumbers)) {
$phnumbers[] = "$grpworkphonestripped";
}
$smsphonenumberoptions .= "<option value=\"$mysmsprefix".filtersmsnumber("$grpworkphone")."\">".pcrtlang("Work from Group").": $grpworkphone</option>";
}

}


$phnumbers_il = implode_list($phnumbers);


echo "<table style=\"width:100%\"><tr><td><span class=\"sizemelarge boldme\">&nbsp;".pcrtlang("Messages")." </span></td><td>";
echo "<a href=\"javascript:void(0);\" id=addmessage class=linkbutton style=\"float:right\"><i class=\"fa fa-paper-plane fa-lg\"></i> ".pcrtlang("Send Message")."</a></td>
</tr></table>\n";


?>
<script type='text/javascript'>
$('#addmessage').click(function() {
  $('#messagesdiv').slideToggle(500, function() {
        $( "#messagea" ).focus();
  });
});
</script>
<?php

echo "<div id=messagesdiv style=\"display:none;\">";

echo "<table class=standard>";

#echo "<tr><th>".pcrtlang("Send SMS")." ($mysmsgateway)</th><th>".pcrtlang("Call Log/Send Message")."</th></tr>";

echo "<tr><td style=\"width:50%;vertical-align:top\">";

echo "<table class=standard><tr><th>".pcrtlang("Send SMS")." ($mysmsgateway)</th></tr></table>";

##############

start_box();

if ($mysmsgateway != "none") {

echo "<form action=sms.php?func=smssend2 method=post id=smsform>";

echo "<input type=hidden name=woid value=$pcwo>";

echo "<input type=text name=smsnumber id=smsnumber class=textbox value=\"$smsprefill\" placeholder=\"".pcrtlang("Enter Mobile Number")."\">&nbsp;&nbsp;";
echo "<select name=myoptions onchange='document.getElementById(\"smsnumber\").value=this.options[this.selectedIndex].value'><option value=\"$mysmsprefix\">".pcrtlang("Select SMS Number")."</option>$smsphonenumberoptions</select><br><br>";

$storeinfoarray = getstoreinfo($defaultuserstore);

echo "<select name=myoptions onchange='document.getElementById(\"smsmessage\").value=this.options[this.selectedIndex].value' style=\"width:95%\">";
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
echo "</select><br><br>";


echo "<input type=hidden name=woid value=$pcwo>";

echo "<table style=\"width:100%;\"><tr><td><textarea style=\"width:100%;height:160px;box-sizing:border-box;\" rows=4 name=smsmessage id=smsmessage class=textbox name=smsbox></textarea>";
echo "<input type=hidden name=phonenumbers value=$phnumbers_il>";
echo "<input type=hidden name=emails value=$emailsimploded>";
echo "<input type=hidden name=pickup value=\"$pickup\">";
echo "<input type=hidden name=dropoff value=\"$dropoff\">";

echo "<br><span class=colormegreen>".pcrtlang("Characters Remaining").": <span id=\"charsLeft\"></span></span>";

echo "</td>";

###
if ($mysmsgateway == "twilio") {
$rs_assetphotos = "SELECT * FROM assetphotos WHERE pcid = '$pcid'";
$rs_result_aset = mysqli_query($rs_connect, $rs_assetphotos);
$totalsmspics = mysqli_num_rows($rs_result_aset);
if($totalsmspics > 0) {
echo "<td style=\"width:75px;vertical-align:top\">";
echo "<select size=2 name=assetphotoid class=\"attach-menu\">";
echo "<option selected value=0 style=\"background-image:url(images/del.png)\"> </option>";
while($rs_result_aset2 = mysqli_fetch_object($rs_result_aset)) {
$photofilename = "$rs_result_aset2->photofilename";
$assetphotoid = "$rs_result_aset2->assetphotoid";
$highlight = "$rs_result_aset2->highlight";

echo "<option value=$assetphotoid style=\"background-image:url(pc.php?func=getpcimage&photoid=$assetphotoid);\"> </option>";
}
echo "</select></td>";
}
}
###

echo "</tr></table>";

echo "<br><div style=\"text-align:center\"><button type=submit class=\"linkbuttonmedium linkbuttongreen radiusall\" style=\"width:200px\"><i class=\"fa fa-sms fa-2x\"></i><br>".pcrtlang("Send SMS")."</button></div>";

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

} else {
echo "<i class=\"fa fa-warning fa-lg colormered\"></i> ".pcrtlang("No SMS Gateway Service Configured")."...";
}

stop_box();




##############

echo "</td><td style=\"vertical-align:top;\">";

echo "<table class=standard><tr><th>".pcrtlang("Call Log/Send Message")."</th></tr></table>";
start_box();
echo "<form action=pc.php?func=addmessage method=post id=calllogform><input type=hidden name=woid value=$pcwo>";
echo "<input type=hidden name=phonenumbers value=$phnumbers_il>";
echo "<input type=hidden name=emails value=$emailsimploded>";
echo "<input type=hidden name=pickup value=\"$pickup\">";
echo "<input type=hidden name=dropoff value=\"$dropoff\">";
echo "<textarea name=themessage required=required class=textboxw style=\"width:100%;height:70px;box-sizing:border-box\" placeholder=\"".pcrtlang("Enter Call Notes")."\"></textarea>";
echo "<div class=\"radiobox\">";
echo "<input type=radio name=type value=1 id=mess1 checked><label for=mess1><i class=\"fa fa-sticky-note fa-lg fa-fw\"></i> ".pcrtlang("Call Log Note")."</input></label><br>";
echo "<input type=radio name=type value=2 id=mess2><label for=mess2><i class=\"fa fa-comment fa-lg fa-fw\"></i> ".pcrtlang("Portal Message")."</input></label><br>";
echo "<input type=radio name=type value=3 id=mess3><label for=mess3><i class=\"fa fa-envelope fa-lg fa-fw\"></i> ".pcrtlang("Send Email")."</input><br><br>";
echo pcrtlang("From").": <select name=fromemail>";
$storeinfoarray = getstoreinfo($defaultuserstore);
if("$storeinfoarray[storeemail]" != "") {
echo "<option value=\"$storeinfoarray[storeemail]\">".pcrtlang("Store").": $storeinfoarray[storeemail]</option>";
}
$techemail = getuseremail("$ipofpc");
if("$techemail" != "") {
echo "<option value=\"$techemail\">".pcrtlang("Tech").": $techemail</option>";
}
echo "</select><br><br>";

echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".pcrtlang("To").": <select name=toemail>";
if("$pcemail" != "") {
echo "<option value=\"$pcemail\">$pcemail</option>";
}
if(isset($grpemail)) {
if("$grpemail" != "") {
echo "<option value=\"$grpemail\">$grpemail</option>";
}
}

echo "</select></label></div>";

echo "<br><div style=\"text-align:center\"><button type=submit class=\"linkbuttonmedium linkbuttongreen radiusall\" style=\"width:200px\">
<i class=\"fa fa-envelope fa-2x\"></i><br>".pcrtlang("Save/Send")."</button></div>";

#echo "</div>";



echo "</form>";
stop_box();
echo "</td></tr></table><br>";
echo "</div>";




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

$(document).ready(function(){
$('#calllogform').submit(function(e) { // catch the form's submit event
        e.preventDefault();
        $.ajax({ // create an AJAX call...
        data: $(this).serialize(), // get the form data
        type: $(this).attr('method'), // GET or POST
        url: $(this).attr('action'), // the file to call
        success: function(response) { // on success..
            $('#messagearea').html(response); // update the DIV
        $('#calllogform').each (function(){
          this.reset();
        });
        $('#messagesdiv').slideToggle(1000, function() {
        });
    }
    });
});
});


if (typeof messagesInterval !== 'undefined') {
        clearInterval(messagesInterval);
}


$(document).ready(function () {
        window.messagesInterval = setInterval(function() {
                $.get('sms.php?func=smsload&phonenumbers=<?php echo "$phnumbers_il"; ?>&emails=<?php echo "$emailsimploded"; ?>&woid=<?php echo "$pcwo"; ?>&pickup=<?php echo "$pickup"; ?>&dropoff=<?php echo "$dropoff"; ?>', function(data) {
                $('#messagearea').html(data);
                });
        }, 60000);
});


</script>
<?php

echo "<div id=messagearea>";
displaymessages("$phnumbers_il","$emailsimploded","$pcwo","$pickup","$dropoff");
echo "</div>";

echo "<br><a href=messages.php?func=browsemessages&woid=$pcwo&phonenumbers=$phnumbers_il&emails=$emailsimploded class=\"linkbuttonsmall linkbuttongray radiusall\">
<i class=\"fa fa-comments fa-lg\"></i> ".pcrtlang("Browse all Messages")."</a>";

echo "<a name=wochecks id=wochecks></a>";
stop_box();
echo "<br>";





$rs_sq = "SELECT * FROM mainassettypes WHERE mainassettypeid = '$mainassettypeidindb'";
$rs_result1 = mysqli_query($rs_connect, $rs_sq);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$mainassetchecksindb = serializedarraytest("$rs_result_q1->mainassetchecks");


if(count($mainassetchecksindb) > 0) {


echo "<div id=checksarea>";

loadchecks($pcwo);

echo "</div>";

?>
<script type="text/javascript">
$(document).ready(function(){
$('#checksarea').on('click', 'a', function(e) {
  		e.preventDefault(); // stop the browser from following the link
  		var url = $(this).attr('href');
              	$('div#checksarea').load(url); // load the html response into a DOM element
	});
});
</script>
<?php




echo "<br>";

}

#$totalpagetimewo = microtime(true) - $startpagetimewo;
#echo "<div style=\"text-align:right\"><span class=text12eng>$totalpagetimewo</span></div>";

echo "<div id=scansarea></div>";
echo "<a name=addscan id=addscan></a>";

if ($mainassettypeshowscans == 1) {

echo "<div id=scansadd></div>";


?>
<script type="text/javascript">
  $.get('addscans.php?pcwo=<?php echo "$pcwo"; ?>', function(data) {
    $('#scansadd').html(data);
  });
</script>
<?php


#$totalpagetimewo = microtime(true) - $startpagetimewo;
#echo "<div style=\"text-align:right\"><span class=text12eng>$totalpagetimewo</span></div>";


echo "<div id=showscans></div>";

?>
<script type="text/javascript">
  $.get('showscans.php?pcwo=<?php echo "$pcwo"; ?>', function(data) {
    $('#showscans').html(data);
  });
</script>


<script type="text/javascript">
$('#scansadd').on('submit', 'form', function (e) {
        e.preventDefault();
	$(this).find("button").text('<?php echo pcrtlang("Wait..."); ?>').attr("disabled",true);
        $.ajax({ // create an AJAX call...
        data: $(this).serialize(), // get the form data
        type: $(this).attr('method'), // GET or POST
        url: $(this).attr('action'), // the file to call
        success: function(response) { // on success..
		$.get('addscans.php?pcwo=<?php echo "$pcwo"; ?>', function(data) {
    		$('#scansadd').html(data);
		});
               	$.get('showscans.php?pcwo=<?php echo "$pcwo"; ?>', function(data) {
               	$('#showscans').html(data);
               	});
    	}
    });
});

</script>


<script type="text/javascript">
$('#showscans').on('click', '.removescan', function (e) {
        	e.preventDefault();
		 $('.ajaxspinner').toggle();
                var url = $(this).attr('href');
		$.get(url, function () {	
                $.get('showscans.php?pcwo=<?php echo "$pcwo"; ?>', function(data) {
                $('#showscans').html(data);
                });
		$.get('addscans.php?pcwo=<?php echo "$pcwo"; ?>', function(data) {
    		$('#scansadd').html(data);
		 $('.ajaxspinner').toggle();
		});
		});
    });
</script>


<?php

#################################################
#End if scan
}
######



echo "<br>";


#$totalpagetimewo = microtime(true) - $startpagetimewo;
#echo "<div style=\"text-align:right\"><span class=text12eng>$totalpagetimewo</span></div>";


##################################################








?>





</td></tr></table>

<script type='text/javascript'>
scrollToElement($('#<?php echo "$scrollto"; ?>'));
</script>

<div id=bottomnavbarfixed>
<table style="width:100%;border-collapse:collapse;padding:0px;"><tr><td style="text-align:left;padding-left:10px;">
<span class="colormewhite sizemelarger boldme">

<?php
echo "<i class=\"fa fa-user\"></i> $pcname";
echo "&nbsp;&nbsp;&nbsp;&nbsp;<i class=\"fa fa-desktop\"></i> $pcmake";

?>
</span>

</td><td style="text-align:right;">

<button id=topbutton class="linkbuttonsmall radiusall buttonopaque" style="background:none;color:white;"><i class="fa fa-user fa-2x"></i></button>
<button id=assetinfobutton class="linkbuttonsmall radiusall buttonopaque" style="background:none;color:#03a9f4;"><i class="fa fa-desktop fa-2x"></i></button>
<?php
if (($rs_chargewhatcount != 0) || ($rs_invoicecount != 0)) {
echo "<button id=repaircartbutton class=\"linkbuttonsmall radiusall buttonopaque\" style=\"background:none;color:#cddc39;\"><i class=\"fa fa-shopping-cart fa-2x\"></i></button>";
}
?>
<button id=addrepaircartbutton class="linkbuttonsmall radiusall buttonopaque" style="background:none;color:#cddc39;"><i class="fa fa-money fa-2x"></i></button>
<button id=timersbutton class="linkbuttonsmall radiusall buttonopaque" style="background:none;color:yellow;"><i class="fa fa-clock-o fa-2x"></i></button>
<button id=notesbutton class="linkbuttonsmall radiusall buttonopaque" style="background:none;color:#e040fb;"><i class="fa fa-pencil-square fa-2x"></i></button>
<button id=messagesbutton class="linkbuttonsmall radiusall buttonopaque" style="background:none;color:#81d4fa;"><i class="fa fa-comment fa-2x"></i></button>
<?php
if(count($mainassetchecksindb) > 0) {
echo "<button id=checksbutton class=\"linkbuttonsmall radiusall buttonopaque\" style=\"background:none;color:#ff1744;\"><i class=\"fa fa-check-circle fa-2x\"></i></button>";
}
if ($mainassettypeshowscans == 1) {
echo "<button id=scansbutton class=\"linkbuttonsmall radiusall buttonopaque\" style=\"background:none;color:#ff9800;\"><i class=\"fa fa-bug fa-2x\"></i></button>";
}
?>

</td></tr></table>
</div>


<script type="text/javascript">
$(document).ready(function(){
$('.catchstatuschange').on('click', function (e) {
                e.preventDefault();
		 $('.ajaxspinner').toggle();
                var url = $(this).attr('href');
                $.get(url, function () {
                $.get('wo.php?pcwo=<?php echo "$pcwo"; ?>', function(data) {
                $('#mainworkorder').html(data);
		 $('.ajaxspinner').toggle();
                });
                $.get('sidemenu.php', function(data) {
                $('#sidemenu').html(data);
                });
                });
                });
});
</script>



<script>
$("#messagesbutton").click(function() {
    $('html, body').animate({
        scrollTop: $("#messagesarea").offset().top-50
    }, 250);
  $('#messagesdiv').slideToggle(500, function() {
        $( "#messagea" ).focus();
  });
});


$("#topbutton").click(function() {
    $('html, body').animate({
        scrollTop: $("#toparea").offset().top-70
    }, 250);
});

$("#assetinfobutton").click(function() {
    $('html, body').animate({
        scrollTop: $("#assetinfoarea").offset().top-70
    }, 250);
});

$("#addrepaircartbutton").click(function() {
    $('html, body').animate({
        scrollTop: $("#addrepaircartarea").offset().top-70
    }, 250);

  $('#repaircartbox').toggle('1000');
  $("i",this).toggleClass("fa-chevron-up fa-chevron-down");

});


$("#repaircartbutton").click(function() {
    $('html, body').animate({
        scrollTop: $("#repaircartarea").offset().top-70
    }, 250);
});

$("#timersbutton").click(function() {
    $('html, body').animate({
        scrollTop: $("#timersarea").offset().top-70
    }, 250);
});

$("#notesbutton").click(function() {
    $('html, body').animate({
        scrollTop: $("#notesarea").offset().top-70
    }, 250);
});

$("#checksbutton").click(function() {
    $('html, body').animate({
        scrollTop: $("#checksarea").offset().top-70
    }, 250);
});

$("#scansbutton").click(function() {
    $('html, body').animate({
        scrollTop: $("#scansarea").offset().top-70
    }, 250);
});
</script>


<script type='text/javascript'>
$(document).ready(function(){
$('#sidemenu').off('click','.catchloadworkorder');
$('#sidemenu').on('click','.catchloadworkorder',function(e) { // catch the form's submit event
if (typeof messagesInterval != 'undefined') clearInterval(messagesInterval);
        e.preventDefault();
                var url = $(this).attr('href');
                var urlf = url.replace("index", "wo");
                $('html, body').animate({scrollTop: $("#toparea").offset().top-90}, 10);
                $("#mainworkorder").html("<br><br><br><center><i class=\"fas fa-spinner fa-pulse fa-10x colormegray\"></i></center>");
                $.get(urlf, function (data) {
                $('#mainworkorder').html(data);
                });
});
});
</script>

