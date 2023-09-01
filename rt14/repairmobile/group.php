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

                                                                                                    
function addtogroupnew() {
require_once("dheader.php");
require("deps.php");


if (array_key_exists('woid',$_REQUEST)) {
$woid = $_REQUEST['woid'];
} else {
$woid = "0";
}

if (array_key_exists('pcid',$_REQUEST)) {
$pcid = $_REQUEST['pcid'];
} else {
$pcid = "0";
}

if (array_key_exists('groupname',$_REQUEST)) {
$groupname = $_REQUEST['groupname'];
} else {
$groupname = "";
}


if (array_key_exists('pccompany',$_REQUEST)) {
$pccompany = $_REQUEST['pccompany'];
} else {
$pccompany = "";
}

if (array_key_exists('pcaddress1',$_REQUEST)) {
$pcaddress1 = $_REQUEST['pcaddress1'];
} else {
$pcaddress1 = "";
}

if (array_key_exists('pcaddress2',$_REQUEST)) {
$pcaddress2 = $_REQUEST['pcaddress2'];
} else {
$pcaddress2 = "";
}

if (array_key_exists('pccity',$_REQUEST)) {
$pccity = $_REQUEST['pccity'];
} else {
$pccity = "";
}

if (array_key_exists('pcstate',$_REQUEST)) {
$pcstate = $_REQUEST['pcstate'];
} else {
$pcstate = "";
}

if (array_key_exists('pczip',$_REQUEST)) {
$pczip = $_REQUEST['pczip'];
} else {
$pczip = "";
}

if (array_key_exists('pcemail',$_REQUEST)) {
$pcemail = $_REQUEST['pcemail'];
} else {
$pcemail = "";
}

if (array_key_exists('pchomephone',$_REQUEST)) {
$pchomephone = $_REQUEST['pchomephone'];
} else {
$pchomephone = "";
}

if (array_key_exists('pccellphone',$_REQUEST)) {
$pccellphone = $_REQUEST['pccellphone'];
} else {
$pccellphone = "";
}

if (array_key_exists('pcworkphone',$_REQUEST)) {
$pcworkphone = $_REQUEST['pcworkphone'];
} else {
$pcworkphone = "";
}


dheader(pcrtlang("New Group"));

echo pcrtlang("Create New Asset/Device/Customer Group")."<br><br>";

echo "<form action=group.php?func=addtogroupnew2 method=post  data-ajax=\"false\">";
echo pcrtlang("Group Name").":<input type=text name=pcgroupname value=\"$groupname\" required=required onFocus=\"this.form.submitbutton.disabled=false;this.form.submitbutton.value='".pcrtlang("Create New Group")."';\">";
echo "<input type=hidden name=woid value=$woid><input type=hidden name=pcid value=$pcid>
<input type=hidden name=pccompany value=\"$pccompany\">
<input type=hidden name=pcaddress1 value=\"$pcaddress1\">
<input type=hidden name=pcaddress2 value=\"$pcaddress2\">
<input type=hidden name=pccity value=\"$pccity\">
<input type=hidden name=pcstate value=\"$pcstate\">
<input type=hidden name=pczip value=\"$pczip\">
<input type=hidden name=pchomephone value=\"$pchomephone\">
<input type=hidden name=pccellphone value=\"$pccellphone\">
<input type=hidden name=pcworkphone value=\"$pcworkphone\">
<input type=hidden name=pcemail value=\"$pcemail\">";


echo "<input type=submit id=submitbutton value=\"".pcrtlang("Create New Group")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Creating Group")."...'; this.form.submit();\"  data-theme=\"b\">";


dfooter();

require_once("dfooter.php");
                                                                                                    
}

function addtogroupnew2() {
require_once("validate.php");
require("deps.php");
require("common.php");       


$pcgroupname = pv($_REQUEST['pcgroupname']);
$woid = $_REQUEST['woid'];
$pcid = $_REQUEST['pcid'];

$pccompany = pv($_REQUEST['pccompany']);
$pcaddress1 = pv($_REQUEST['pcaddress1']);
$pcaddress2 = pv($_REQUEST['pcaddress2']);
$pccity = pv($_REQUEST['pccity']);
$pcstate = pv($_REQUEST['pcstate']);
$pczip = pv($_REQUEST['pczip']);
$pcemail = pv($_REQUEST['pcemail']);
$pchomephone = pv($_REQUEST['pchomephone']);
$pccellphone = pv($_REQUEST['pccellphone']);
$pcworkphone = pv($_REQUEST['pcworkphone']);



if ($pcgroupname == "") { die("Please go back and enter the group name"); }
                                                                




$rs_insert_group = "INSERT INTO pc_group (pcgroupname,grpcompany,grpaddress1,grpaddress2,grpcity,grpstate,grpzip,grpemail,grpphone,grpcellphone,grpworkphone) VALUES ('$pcgroupname','$pccompany','$pcaddress1','$pcaddress2','$pccity','$pcstate','$pczip','$pcemail','$pchomephone','$pccellphone','$pcworkphone')";
@mysqli_query($rs_connect, $rs_insert_group);
                               
$pcgroupid = mysqli_insert_id($rs_connect);

if ($woid != "") {
$rs_set_group = "UPDATE pc_owner SET pcgroupid = '$pcgroupid' WHERE pcid = '$pcid'";
@mysqli_query($rs_connect, $rs_set_group);
header("Location: index.php?pcwo=$woid");
} else {
header("Location: group.php?func=editgroup&pcgroupid=$pcgroupid&nomodal=0");
}

}



function viewgroup() {

$pcgroupid = $_REQUEST['pcgroupid'];

require("header.php");
require("deps.php");






$rs_findpc = "SELECT * FROM pc_group WHERE pcgroupid = '$pcgroupid'";
$rs_result = mysqli_query($rs_connect, $rs_findpc);
$rs_result_q = mysqli_fetch_object($rs_result);
$pcgroupname = "$rs_result_q->pcgroupname";
$grpcompany = "$rs_result_q->grpcompany";
$grpphone = "$rs_result_q->grpphone";
$grpcellphone = "$rs_result_q->grpcellphone";
$grpworkphone = "$rs_result_q->grpworkphone";
$grpaddress = "$rs_result_q->grpaddress1";
$grpaddress2 = "$rs_result_q->grpaddress2";
$grpcity = "$rs_result_q->grpcity";
$grpstate = "$rs_result_q->grpstate";
$grpzip = "$rs_result_q->grpzip";
$grpemail = "$rs_result_q->grpemail";
$grpcustsourceid = "$rs_result_q->grpcustsourceid";
$grpprefcontact = "$rs_result_q->grpprefcontact";
$grpnotes = nl2br("$rs_result_q->grpnotes");
$pcgrouptags = "$rs_result_q->tags";

if("$grpcompany" == "") {
$groupfill = "$pcgroupname";
} else {
$groupfill = "$pcgroupname &bull; $grpcompany";
}

echo "<table class=standard><tr><th>$groupfill</th></tr><tr><td>";

if($grpnotes !=	"") {
echo "<font class=text12b>".pcrtlang("Notes").":</font><br><font class=text12>$grpnotes</font>";
}




echo "<br><br><font class=bgid>".pcrtlang("Group").":</font><font class=agid> $pcgroupid</font><br>";


echo "<table border=0 cellspacing=0 cellpadding=2><tr><td bgcolor=#333333><i class=\"fa fa-phone fa-lg fa-fw\" style=\"color:white;\"></i></td><td>";

if($grpphone != "") {
if($grpprefcontact == "home") {
echo "<font style=\"color: #0000ff;\"><i class=\"fa fa-star fa-lg\"></i></font>";
} 
echo " <i class=\"fa fa-phone fa-lg fa-fw\"></i> $grpphone<br>";
}

if($grpcellphone != "") {
if($grpprefcontact == "cellphone") {
echo "<font style=\"color: #0000ff;\"><i class=\"fa fa-star fa-lg\"></i></font>";
}
echo "<i class=\"fa fa-mobile fa-lg fa-fw\"></i> $grpcellphone<br>";
}

if($grpworkphone != "") {
if($grpprefcontact == "workphone") {
echo "<font style=\"color: #0000ff;\"><i class=\"fa fa-star fa-lg\"></i></font>";
}
echo " <i class=\"fa fa-briefcase fa-lg fa-fw\"></i> $grpworkphone";
}

echo "</td></tr></table>";



if($grpaddress != "") {
$grpaddressbr = nl2br($grpaddress);
echo "<table cellpadding=2 cellspacing=0 border=0><tr><td bgcolor=#333333><i class=\"fa fa-map-marker fa-lg fa-fw\" style=\"color:white;\"></i></td><td>$grpaddressbr<br>";
if($grpaddress2 != "") {
echo "$grpaddress2<br>";
}
if(($grpcity != "") && ($grpstate != "") && ($grpzip != "")) {
echo "$grpcity, $grpstate $grpzip";
}
echo "</td></tr></table>";

}


if($grpemail != "") {
if($grpprefcontact == "email") {
$gpri = "<font style=\"color: #0000ff;\"><i class=\"fa fa-star fa-lg\"></i></font>";
} else {
$gpri = "";
}


echo "<button type=button onClick=\"parent.location='mailto:$grpemail'\">$gpri <i class=\"fa fa-envelope fa-lg\"></i> $grpemail</button>";
}


if($grpcustsourceid != "0") {
$rs_cssq = "SELECT * FROM custsource WHERE custsourceid='$grpcustsourceid'";
$rs_result1cs = mysqli_query($rs_connect, $rs_cssq);
while($rs_result_qcs1 = mysqli_fetch_object($rs_result1cs)) {
$thesource = "$rs_result_qcs1->thesource";
$sourceicon = "$rs_result_qcs1->sourceicon";
echo "<img src=../repair/images/custsources/$sourceicon align=absmiddle> <font class=text12>".pcrtlang("Customer Source").":</font> <font class=text12b>$thesource</font><br>";
}
}




echo "<br><table class=standard><tr><th><i class=\"fa fa-tags fa-lg fa-fw\"></i> ".pcrtlang("Tags")."</th></tr><tr><td>";


displaytags(0,$pcgroupid,32);

echo "<div data-role=\"collapsible\" data-theme=\"b\">";
echo "<h3>".pcrtlang("Add Tags")."</h3>";

echo "<form method=post action=\"group.php?func=tagsave\" data-ajax=\"false\"><input type=hidden name=groupid value=\"$pcgroupid\">";


$pcgrouptagsarray = explode_list($pcgrouptags);

echo "<fieldset data-role=\"controlgroup\">";

$rs_sq = "SELECT * FROM custtags WHERE tagenabled = '1' ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_sq);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$tagid = "$rs_result_q1->tagid";
$thetag = "$rs_result_q1->thetag";
$tagicon = "$rs_result_q1->tagicon";
$tagenabled = "$rs_result_q1->tagenabled";
$theorder = "$rs_result_q1->theorder";
$primero = mb_substr("$thetag", 0, 1);

if("$primero" == "-") {
$thetag = mb_substr("$thetag", 1);
echo "<span class=\"linkbuttontiny linkbuttongraylabel radiusall\">$thetag</span><br>";
} else {
$tagcheck = "";
if(in_array($tagid, $pcgrouptagsarray)) {
$tagcheck = "checked";
}
echo "<input type=checkbox $tagcheck id=\"$tagid\" value=\"$tagid\" name=\"tags[]\">
<label for=\"$tagid\"><img src=../repair/images/tags/$tagicon width=16> $thetag</input></label>";
}
}


echo "</fieldset>";

echo "<br><input type=submit value=\"".pcrtlang("Save Tags")."\"></form>";

echo "</div>";

echo "</td></tr></table><br>";




echo "<div data-role=\"collapsible\" data-theme=\"b\">";
echo "<h3>".pcrtlang("Group Actions")."</h3>";


echo "<button type=button onClick=\"parent.location='group.php?func=editgroup&pcgroupid=$pcgroupid'\"><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button>";


if ($ipofpc == "admin") {
$rs_findpc = "SELECT * FROM pc_owner WHERE pcgroupid = '$pcgroupid'";
$rs_resultpc2 = mysqli_query($rs_connect, $rs_findpc);

$totalpc = mysqli_num_rows($rs_resultpc2);
if ($totalpc == 0) {

echo "<a href=\"#popupdeletegroup\" data-rel=\"popup\" data-position-to=\"window\" data-transition=\"pop\" class=\"ui-btn ui-shadow ui-corner-all\">";
echo "<img src=../repair/images/del.png style=\"width:20px;\" align=absmiddle> ".pcrtlang("Delete this Group")."</a>";
echo "<div data-role=\"popup\" id=\"popupdeletegroup\" data-overlay-theme=\"b\"  data-theme=\"a\" data-dismissible=\"false\">";
echo "<div data-role=\"header\" data-theme=\"b\">";
echo "<h1>".pcrtlang("Delete this Group")."?</h1>";
echo "</div>";
echo "<div role=\"main\" class=\"ui-content\">";
echo "<p>".pcrtlang("Are you sure you wish to permanently delete this Group!!!?")."</p>";
echo "<div align=\"right\"><a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\" data-inline=\"true\">";
echo "<i class=\"fa fa-ban fa-lg\"></i>  ".pcrtlang("Cancel")."</a>";
echo "<button onClick=\"parent.location='admin.php?func=admindeletegroup&pcgroupid=$pcgroupid'\" data-inline=\"true\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete Group")." </button></div>";
echo "</div>";
echo "</div>";


}
}




echo "<button type=button onClick=\"parent.location='attachment.php?func=add&attachtowhat=groupid&groupid=$pcgroupid'\"><i class=\"fa fa-paperclip fa-lg\"></i> ".pcrtlang("Add Attachment to Group")."</button>";



echo "<a href=\"#popupsynctopc\" data-rel=\"popup\" data-position-to=\"window\" data-transition=\"pop\" class=\"ui-btn ui-shadow ui-corner-all\">";
echo "<img src=../repair/images/syncright.png style=\"width:20px;\" align=absmiddle> ".pcrtlang("Sync to Devices")."</a>";
echo "<div data-role=\"popup\" id=\"popupsynctopc\" data-overlay-theme=\"b\"  data-theme=\"a\" data-dismissible=\"false\">";
echo "<div data-role=\"header\" data-theme=\"b\">";
echo "<h1>".pcrtlang("Sync to Devices")."?</h1>";
echo "</div>";
echo "<div role=\"main\" class=\"ui-content\">";
echo "<p>".pcrtlang("Sync the Address, Phone, &amp; Email to all PC's in this Group?")."</p>";
echo "<div align=\"right\"><a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\" data-inline=\"true\">";
echo "<i class=\"fa fa-ban fa-lg\"></i>  ".pcrtlang("Cancel")."</a>";
echo "<button onClick=\"parent.location='group.php?func=synctoallpc&pcgroupid=$pcgroupid'\" data-inline=\"true\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Sync to Devices")." </button></div>";
echo "</div>";
echo "</div>";



$ue_pcgroupname = urlencode($pcgroupname);
$ue_grpcompany = urlencode($grpcompany);
$ue_grpphone = urlencode($grpphone);
$ue_grpcellphone = urlencode($grpcellphone);
$ue_grpworkphone = urlencode($grpworkphone);
$ue_grpaddress = urlencode($grpaddress);
$ue_grpaddress2 = urlencode($grpaddress2);
$ue_grpcity = urlencode($grpcity);
$ue_grpstate = urlencode($grpstate);
$ue_grpzip = urlencode($grpzip);
$ue_grpemail = urlencode($grpemail);
$ue_grpcustsourceid = urlencode($grpcustsourceid);
$ue_grpprefcontact = urlencode($grpprefcontact);


echo "<button type=button onClick=\"parent.location='pc.php?func=addpc&pcname=$ue_pcgroupname&pccompany=$ue_grpcompany&pcphone=$ue_grpphone&pccellphone=$ue_grpcellphone&pcworkphone=$ue_grpworkphone&pcemail=$ue_grpemail&pcaddress=$ue_grpaddress&pcaddress2=$ue_grpaddress2&pccity=$ue_grpcity&pcstate=$ue_grpstate&pczip=$ue_grpzip&prefcontact=$ue_grpprefcontact&pcgroupid=$pcgroupid&custsourceid=$ue_grpcustsourceid'\"><img src=../repair/images/new.png border=0 align=absmiddle width=24> ".pcrtlang("Add New Device to Group")."</button>"; 

echo "<button type=button onClick=\"parent.location='../storemobile/cart.php?func=pickcustomer2&personname=$ue_pcgroupname&company=$ue_grpcompany&address1=$ue_grpaddress&address2=$ue_grpaddress2&city=$ue_grpcity&state=$ue_grpstate&zip=$ue_grpzip&email=$ue_grpemail&phone=$ue_grpphone&pcgroupid=$pcgroupid'\"><img src=../store/images/rinvoice.png border=0 align=absmiddle width=24> ".pcrtlang("Create Invoice/Recurring Invoice")."</button>";

echo "<button type=button onClick=\"parent.location='sticky.php?func=addsticky&stickyname=$ue_pcgroupname&stickycompany=$ue_grpcompany&stickyaddy1=$ue_grpaddress&stickyaddy2=$ue_grpaddress2&stickycity=$ue_grpcity&stickystate=$ue_grpstate&stickyzip=$ue_grpzip&stickyemail=$ue_grpemail&stickyphone=$ue_grpphone&stickyrefid=$pcgroupid&stickyreftype=groupid'\"><img src=../repair/images/sticky.png border=0 align=absmiddle width=24> ".pcrtlang("Create Sticky Note")."</button>";

$invgrandtotal = invoicetotal($pcgroupid, 1);
$invgrandtotalclosed = invoicetotal($pcgroupid, 2);


if($invgrandtotal > 0) {
echo "<button type=button onClick=\"parent.location='group.php?func=openinvoicestatement&name=$ue_pcgroupname&company=$ue_grpcompany&addy1=$ue_grpaddress&addy2=$ue_grpaddress2&city=$ue_grpcity&state=$ue_grpstate&zip=$ue_grpzip&email=$ue_grpemail&phone=$ue_grpphone&pcgroupid=$pcgroupid'\">
<img src=../repair/images/invoice.png border=0 align=absmiddle width=24> ".pcrtlang("Print Open Invoice Statement")."</button>";

if($grpemail != "") {
echo "<button type=button onClick=\"parent.location='group.php?func=emailopeninvoicestatement&name=$ue_pcgroupname&company=$ue_grpcompany&addy1=$ue_grpaddress&addy2=$ue_grpaddress2&city=$ue_grpcity&state=$ue_grpstate&zip=$ue_grpzip&email=$ue_grpemail&phone=$ue_grpphone&pcgroupid=$pcgroupid'\">
<img src=../repair/images/invoice.png border=0 align=absmiddle width=24> ".pcrtlang("Email Open Invoice Statement")."</button>";
}
}




echo "</div>";




echo "</td></tr></table><br>";

echo "<table class=standard><tr><th>".pcrtlang("Totals")."</th></tr><tr><td>";


echo pcrtlang("Open Invoice Total").":  <span style=\"float:right\">$money$invgrandtotal</span></td></tr>";
echo "<tr><td>".pcrtlang("Closed Invoice Total").": <span style=\"float:right\">$money$invgrandtotalclosed</span></td></tr></table>";

echo "<br>";



$rs_asql = "SELECT * FROM attachments WHERE groupid = '$pcgroupid'";
$rs_result1asql = mysqli_query($rs_connect, $rs_asql);
$total_attachments = mysqli_num_rows($rs_result1asql);

if ($total_attachments > 0) {
echo "<br><table class=standard><tr><th>".pcrtlang("Group Attachments").":</th></tr>";
while($rs_result_asql1 = mysqli_fetch_object($rs_result1asql)) {
$attach_id = "$rs_result_asql1->attach_id";
$attach_title = "$rs_result_asql1->attach_title";
$attach_size = "$rs_result_asql1->attach_size";
$attach_filename = "$rs_result_asql1->attach_filename";
$fileextpc = strtolower(substr(strrchr($attach_filename, "."), 1));

$thebytes = formatBytes($attach_size);

echo "<tr><td>";
echo "<button type=button onClick=\"parent.location='attachment.php?func=get&attach_id=$attach_id'\">$attach_title</button>";
echo "<center><i class=\"fa fa-paperclip fa-lg\"></i> $fileextpc $thebytes</center>";

echo "<button type=button onClick=\"parent.location='attachment.php?func=editattach&groupid=$pcgroupid&attach_id=$attach_id'\"><i class=\"fa fa-edit\"></i> ".pcrtlang("edit")."</button>";

echo "<a href=\"#popupdeleteat_$attach_id\" data-rel=\"popup\" data-position-to=\"window\" data-transition=\"pop\" class=\"ui-btn ui-shadow ui-corner-all\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete Attachment")."</a>";
echo "<div data-role=\"popup\" id=\"popupdeleteat_$attach_id\" data-overlay-theme=\"b\"  data-theme=\"a\" data-dismissible=\"false\">";
echo "<div data-role=\"header\" data-theme=\"b\">";
echo "<h1>".pcrtlang("Delete Attachment")."?</h1>";
echo "</div>";
echo "<div role=\"main\" class=\"ui-content\">";
echo "<p>".pcrtlang("Are you sure you wish to permanently delete this Attachment!!!?")."</p>";
echo "<div align=\"right\"><a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\" data-inline=\"true\"><i class=\"fa fa-ban fa-lg\"></i> Cancel</a>";
echo "<button onClick=\"parent.location='attachment.php?func=deleteattach&groupid=$pcgroupid&attach_id=$attach_id&attachfilename=$attach_filename'\" data-inline=\"true\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")." </button></div>";
echo "</div>";
echo "</div>";

echo "</td></tr>";
}
echo "</table>";
}






echo "<br>";



echo "<div data-role=\"tabs\" id=\"tabs\">";
echo "<div data-role=\"navbar\">";
echo "<ul>";
echo "<li><a href=\"#assetsdevices\" data-ajax=\"false\">".pcrtlang("Assets/Devices")."</a></li>";
echo "<li><a href=\"#workorders\" data-ajax=\"false\">".pcrtlang("Work Orders")."</a></li>";
echo "<li><a href=\"#invoicing\" data-ajax=\"false\">".pcrtlang("Invoices")."</a></li>";
echo "<li><a href=\"#recurringinvoices\" data-ajax=\"false\">".pcrtlang("Recurring Invoices")."</a></li>";
echo "<li><a href=\"#receipts\" data-ajax=\"false\">".pcrtlang("Receipts")."</a></li>";
echo "<li><a href=\"#botc\" data-ajax=\"false\">".pcrtlang("Block of Time Contracts")."</a></li>";
echo "<li><a href=\"#stickynotes\" data-ajax=\"false\">".pcrtlang("Sticky Notes")."</a></li>";
echo "<li><a href=\"#smslog\" data-ajax=\"false\">".pcrtlang("Messages")."</a></li>";
echo "<li><a href=\"#servicecontracts\" data-ajax=\"false\">".pcrtlang("Service Contracts")."</a></li>";
echo "<li><a href=\"#savedcards\" data-ajax=\"false\">".pcrtlang("Saved Cards")."</a></li>";
if(perm_check("34")) {
echo "<li><a href=\"#credentials\" data-ajax=\"false\">".pcrtlang("Credentials")."</a></li>";
}
echo "</ul>";
echo "</div>";
echo "<div id=\"assetsdevices\" class=\"ui-body-d ui-content\" style=\"padding:2px;\">";


echo "<h3>".pcrtlang("Assets/Devices")."</h3>";


$rs_findowner = "SELECT * FROM pc_owner WHERE pcgroupid = '$pcgroupid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
while($rs_result_q2 = mysqli_fetch_object($rs_result2)) {
$pcid = "$rs_result_q2->pcid";
$pcname = "$rs_result_q2->pcname";
$pccompany = "$rs_result_q2->pccompany";
$pcphone = "$rs_result_q2->pcphone";
$pccellphone = "$rs_result_q2->pccellphone";
$pcworkphone = "$rs_result_q2->pcworkphone";
$pcmake = "$rs_result_q2->pcmake";
$pcemail = "$rs_result_q2->pcemail";
$pcaddress = "$rs_result_q2->pcaddress";
$pcaddress2 = "$rs_result_q2->pcaddress2";
$pccity = "$rs_result_q2->pccity";
$pcstate = "$rs_result_q2->pcstate";
$pczip = "$rs_result_q2->pczip";


if("$pccompany" == "") {
$pcboxfill = "#$pcid $pcname";
} else {
$pcboxfill = "#$pcid $pcname &bull; $pccompany";
}

echo "<div data-role=\"collapsible\" data-theme=\"b\">";
echo "<h3>$pcboxfill</h3>";


echo "<font class=text12>".pcrtlang("Make/Model").":</font> <font class=text12b>$pcmake</font><br>";

$rs_findpic = "SELECT * FROM assetphotos WHERE pcid = '$pcid' AND highlight='1'";
$rs_resultpic2 = mysqli_query($rs_connect, $rs_findpic);

if (mysqli_num_rows($rs_resultpic2) != "0") {
$rs_resultpic_q2 = mysqli_fetch_object($rs_resultpic2);
$assetphotoid = "$rs_resultpic_q2->assetphotoid";
echo "<img src=pc.php?func=getpcimage&photoid=$assetphotoid border=1 width=100><br>";
}




echo "<table border=0 cellspacing=0 cellpadding=2><tr><td bgcolor=#333333><i class=\"fa fa-phone fa-lg\" style=\"padding:20px 3px;color:white;\"></i></td><td>";

if($pcphone != "") {
echo "<font class=text12>&nbsp;".pcrtlang("Home").":</font> <font class=text12b>$pcphone</font><br>";
}

if($pccellphone != "") {
echo "<font class=text12>&nbsp;".pcrtlang("Cell").":</font> <font class=text12b>$pccellphone</font><br>";
}

if($pcworkphone != "") {
echo "<font class=text12>&nbsp;".pcrtlang("Work").":</font> <font class=text12b>$pcworkphone</font>";
}

echo "</td></tr></table><br>";



if($pcaddress != "") {
$pcaddressbr = nl2br($pcaddress);
echo "<table cellpadding=2 cellspacing=0 border=0><tr><td bgcolor=#333333><i class=\"fa fa-map-marker fa-lg\" style=\"padding:20px 5px;color:white;\"></i></td><td><font class=text12b>$pcaddressbr</font><br>";
if($pcaddress2 != "") {
echo "<font class=text12b>$pcaddress2</font><br>";
}
if(($pccity != "") && ($pcstate != "") && ($pczip != "")) {
echo "<font class=text12b>$pccity, $pcstate $pczip</font>";
}
echo "</td></tr></table>";
}



if($pcemail != "") {
echo "<button type=button onClick=\"parent.location='mailto:$pcemail'\" data-mini=\"true\"><i class=\"fa fa-envelope\"></i> $pcemail</button><br>";
}



echo "<button type=button onClick=\"parent.location='pc.php?func=showpc&pcid=$pcid'\"><img src=../repair/images/wohistory.png border=0 align=absmiddle width=24> ".pcrtlang("View Work Order History for this PC")."</button>";


echo "<a href=\"#popupremovepcfromgroup$pcid\" data-rel=\"popup\" data-position-to=\"window\" data-transition=\"pop\" class=\"ui-btn ui-shadow ui-corner-all\">";
echo "<img src=../repair/images/del.png border=0 align=absmiddle width=24> ".pcrtlang("Remove From This Group")."</a>";
echo "<div data-role=\"popup\" id=\"popupreomvepcfromgroup$pcid\" data-overlay-theme=\"b\"  data-theme=\"a\" data-dismissible=\"false\">";
echo "<div data-role=\"header\" data-theme=\"b\">";
echo "<h1>".pcrtlang("Remove From This Group")."?</h1>";
echo "</div>";
echo "<div role=\"main\" class=\"ui-content\">";
echo "<p>".pcrtlang("Are you sure you wish to remove this Asset/Customer from this Group?")."</p>";
echo "<div align=\"right\"><a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\" data-inline=\"true\">";
echo "<i class=\"fa fa-ban fa-lg\"></i>  ".pcrtlang("Cancel")."</a>";
echo "<button onClick=\"group.php?func=removefromgroup&pcgroupid=$pcgroupid&pcid=$pcid'\" data-inline=\"true\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Remove from Group")." </button></div>";
echo "</div>";
echo "</div>";


echo "<button type=button onClick=\"parent.location='pc.php?func=returnpc2&pcid=$pcid'\"><img src=../repair/images/return.png border=0 align=absmiddle width=24> ".pcrtlang("Create New Work Order for this PC")."</button>";

echo "<button type=button onClick=\"parent.location='pc.php?func=addpc&copypcid=$pcid'\"><img src=../repair/images/new.png border=0 align=absmiddle width=24> ".pcrtlang("Checkin New PC/Same Contact")."</button>";



echo "<a href=\"#popupsynctogroup$pcid\" data-rel=\"popup\" data-position-to=\"window\" data-transition=\"pop\" class=\"ui-btn ui-shadow ui-corner-all\">";
echo "<img src=../repair/images/syncleft.png style=\"width:20px;\" align=absmiddle> ".pcrtlang("Sync to Group")."</a>";
echo "<div data-role=\"popup\" id=\"popupsynctogroup$pcid\" data-overlay-theme=\"b\"  data-theme=\"a\" data-dismissible=\"false\">";
echo "<div data-role=\"header\" data-theme=\"b\">";
echo "<h1>".pcrtlang("Sync to Group")."?</h1>";
echo "</div>";
echo "<div role=\"main\" class=\"ui-content\">";
echo "<p>".pcrtlang("Are you sure you want to sync this contact info to the group contact?")."</p>";
echo "<div align=\"right\"><a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\" data-inline=\"true\">";
echo "<i class=\"fa fa-ban fa-lg\"></i>  ".pcrtlang("Cancel")."</a>";
echo "<button onClick=\"parent.location='group.php?func=syncpctogroup&pcgroupid=$pcgroupid&pcid=$pcid'\" data-inline=\"true\">";
echo "<img src=../repair/images/syncleft.png style=\"width:20px;\" align=absmiddle> ".pcrtlang("Sync to Group")." </button></div>";
echo "</div>";
echo "</div>";

echo "<a href=\"#popupsyncfromgroup$pcid\" data-rel=\"popup\" data-position-to=\"window\" data-transition=\"pop\" class=\"ui-btn ui-shadow ui-corner-all\">";
echo "<img src=../repair/images/syncright.png style=\"width:20px;\" align=absmiddle> ".pcrtlang("Sync from Group")."</a>";
echo "<div data-role=\"popup\" id=\"popupsyncfromgroup$pcid\" data-overlay-theme=\"b\"  data-theme=\"a\" data-dismissible=\"false\">";
echo "<div data-role=\"header\" data-theme=\"b\">";
echo "<h1>".pcrtlang("Sync from Group")."?</h1>";
echo "</div>";
echo "<div role=\"main\" class=\"ui-content\">";
echo "<p>".pcrtlang("Are you sure you want to sync the Address, Phone, &amp; Email from Group Contact to this PC.?")."</p>";
echo "<div align=\"right\"><a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\" data-inline=\"true\">";
echo "<i class=\"fa fa-ban fa-lg\"></i>  ".pcrtlang("Cancel")."</a>";
echo "<button onClick=\"parent.location='group.php?func=syncpcfromgroup&pcgroupid=$pcgroupid&pcid=$pcid'\" data-inline=\"true\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Sync from Group")." </button></div>";
echo "</div>";
echo "</div>";



echo "</div>";


}

echo "<br><table class=standard><tr><th>";
echo pcrtlang("Add More Customer Assets/Devices to this Group")."</th></tr><tr><td>";
echo "<form action=group.php?func=searchpcaddtogroup method=post>";
echo "<font class=text12b>".pcrtlang("Enter Part of Customer Name").":</font><input size=35 class=textbox type=text name=searchterm>";
echo "<input type=hidden name=pcgroupid value=$pcgroupid><input type=hidden name=pcname value=\"$pcgroupname\">";
echo "<input class=button type=submit value=\"".pcrtlang("Search for Assets/Customers")."\"></form>";
echo "</td></tr></table>";

echo "</div>";
echo "<div id=\"receipts\" class=\"ui-body-d ui-content\" style=\"padding:2px;\">";

echo "<h3>".pcrtlang("Receipts")."</h3>";

if (array_key_exists("pageNumber", $_REQUEST)) {
$pageNumber = $_REQUEST[pageNumber];
} else {
$pageNumber = 1;
}

$results_per_page = 40;

if ($pageNumber == "") {
$offset = "0";
} else {
$offset = ($pageNumber * $results_per_page) - $results_per_page;
}



$rs_find_cart_items = "(SELECT DISTINCT(receipts.receipt_id),receipts.person_name,receipts.grandtotal,receipts.date_sold FROM receipts, pc_wo, pc_owner
WHERE pc_owner.pcgroupid = '$pcgroupid' AND pc_owner.pcid = pc_wo.pcid AND (pc_wo.woid = receipts.woid OR receipts.woid LIKE CONCAT('%\_',pc_wo.woid,'\_%')))
UNION (SELECT DISTINCT(receipts.receipt_id),receipts.person_name,receipts.grandtotal,receipts.date_sold FROM receipts, invoices
WHERE invoices.pcgroupid = '$pcgroupid' AND receipts.receipt_id = invoices.receipt_id)
UNION (SELECT DISTINCT(receipts.receipt_id),receipts.person_name,receipts.grandtotal,receipts.date_sold FROM receipts, invoices, rinvoices
WHERE invoices.rinvoice_id = rinvoices.rinvoice_id AND rinvoices.pcgroupid = '$pcgroupid'
AND (invoices.invoice_id = receipts.invoice_id OR invoices.invoice_id LIKE CONCAT('%\_',receipts.invoice_id,'\_%')))

UNION (SELECT DISTINCT(receipts.receipt_id),receipts.person_name,receipts.grandtotal,receipts.date_sold FROM receipts, invoices, blockcontract, blockcontracthours
WHERE blockcontracthours.invoiceid = invoices.invoice_id
AND blockcontract.pcgroupid = '$pcgroupid' AND blockcontract.blockid = blockcontracthours.blockcontractid
AND (invoices.invoice_id = receipts.invoice_id OR invoices.invoice_id LIKE CONCAT('%\_',receipts.invoice_id,'\_%')))

ORDER BY date_sold DESC LIMIT $offset,$results_per_page";


$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);


while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_receipt_id = "$rs_result_q->receipt_id";
$receipt_ids[] = $rs_receipt_id;

$addit_ids = findreturnreceipts($rs_receipt_id);
$receipt_ids = array_merge($receipt_ids, $addit_ids);

}

$totalentry = count($receipt_ids);

foreach($receipt_ids as $key => $receipt) {
$rs_find_indrecq = "SELECT * FROM receipts WHERE receipt_id = '$receipt'";
$rs_find_indrec = mysqli_query($rs_connect, $rs_find_indrecq);
while($rs_result_q = mysqli_fetch_object($rs_find_indrec)) {
$rs_receipt_id = "$rs_result_q->receipt_id";
$rs_name = "$rs_result_q->person_name";
$rs_gt2 = "$rs_result_q->grandtotal";
$rs_gt = number_format($rs_gt2, 2, '.', '');
$rs_date = "$rs_result_q->date_sold";

echo "<table class=standard><tr><td>$rs_name</td></tr>";
$rs_date2 = date("n-j-y, g:i a", strtotime($rs_date));
echo "<tr><td><font class=text12>$rs_date2</font></td></tr>";


if ($rs_gt < 0) {
echo "<tr><td><font style=\"color:#ff0000;\">$money$rs_gt</font></td></tr>";
} else {
echo "<tr><td>$money$rs_gt</td></tr>";
}

echo "<tr><td><button type=button onClick=\"parent.location='../storemobile/receipt.php?func=show_receipt&receipt=$rs_receipt_id'\">".pcrtlang("View Receipt")." #$rs_receipt_id</button></td></tr>";

echo "</table><br>";
}
}


echo "<br>";

#browse here
$prevpage = $pageNumber - 1;
$nextpage = $pageNumber + 1;

echo "<center>";

if ($pageNumber > 1) {
echo "<button type=button onClick=\"parent.location='group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=receipts&pageNumber=$prevpage'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\">";
echo "<i class=\"fa fa-chevron-left fa-lg\"></i></button>";
}

$total_results = $totalentry;
$results_per_page = $results_per_page;
$html = get_paged_nav($total_results, $results_per_page, false);
echo "$html";

if (($totalentry / $results_per_page) > $pageNumber) {
echo "<button type=button onClick=\"parent.location='group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=receipts&pageNumber=$nextpage'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\">";
echo "<i class=\"fa fa-chevron-right fa-lg\"></i></button>";
}

echo "</center>";

echo "</div>";
echo "<div id=\"invoicing\" class=\"ui-body-d ui-content\" style=\"padding:2px;\">";

/* Start of Invoices  */

if (array_key_exists('pageNumber',$_REQUEST)) {
$pageNumber = $_REQUEST['pageNumber'];
} else {
$pageNumber = 1;
}

$results_per_page = 40;

$offset = ($pageNumber * $results_per_page) - $results_per_page;







echo "<h3>".pcrtlang("Invoices")."</h3>";
#echo "<table border=0 cellspacing=3 cellpadding=2>";
#echo "<tr class=troweven><td><font class=text12b>".pcrtlang("Inv")."#&nbsp;&nbsp;</font></td><td><font class=text12b>".pcrtlang("Customer Name")."&nbsp;&nbsp;</font></td><td><font class=text12b>".pcrtlang("Invoice Date")."&nbsp;&nbsp;</font></td>";
#echo "<td><font class=text12b> ".pcrtlang("Total")." </font>&nbsp;&nbsp;</td><td><font class=text12b>".pcrtlang("Status")."</font></td><td><font class=text12b>".pcrtlang("Actions")."</font>&nbsp;&nbsp;</td></tr>";

$rs_invoicest = "(SELECT DISTINCT(invoices.invoice_id) FROM invoices, pc_wo, pc_owner 
WHERE pc_owner.pcgroupid = '$pcgroupid' AND pc_owner.pcid = pc_wo.pcid AND invoices.iorq != 'quote' 
AND (pc_wo.woid = invoices.woid OR invoices.woid LIKE CONCAT('%\_',pc_wo.woid,'\_%')))
UNION (SELECT invoices.invoice_id FROM invoices,rinvoices WHERE invoices.rinvoice_id = rinvoices.rinvoice_id AND rinvoices.pcgroupid = '$pcgroupid')
UNION (SELECT invoice_id FROM invoices WHERE pcgroupid = '$pcgroupid')
UNION (SELECT invoices.invoice_id
FROM invoices,blockcontracthours,blockcontract WHERE blockcontracthours.invoiceid = invoices.invoice_id
AND blockcontract.pcgroupid = '$pcgroupid' AND blockcontract.blockid = blockcontracthours.blockcontractid)";

$rs_find_invoicest = @mysqli_query($rs_connect, $rs_invoicest);
$rs_invoices = "(SELECT DISTINCT(invoices.invoice_id),invoices.invname,invoices.invstatus,invoices.invemail,invoices.woid,invoices.receipt_id,invoices.invdate,invoices.invcompany,invoices.pcgroupid,invoices.invphone,invoices.invaddy1,invoices.invaddy2,invoices.invcity,invoices.invstate,invoices.invzip FROM invoices, pc_wo, pc_owner WHERE pc_owner.pcgroupid = '$pcgroupid' AND pc_owner.pcid = pc_wo.pcid AND invoices.iorq != 'quote'
AND (pc_wo.woid = invoices.woid OR invoices.woid LIKE CONCAT('%\_',pc_wo.woid,'\_%')))
UNION (SELECT invoices.invoice_id,invoices.invname,invoices.invstatus,invoices.invemail,invoices.woid,invoices.receipt_id,invoices.invdate,invoices.invcompany,invoices.pcgroupid,invoices.invphone,invoices.invaddy1,invoices.invaddy2,invoices.invcity,invoices.invstate,invoices.invzip
FROM invoices,rinvoices WHERE invoices.rinvoice_id = rinvoices.rinvoice_id AND rinvoices.pcgroupid = '$pcgroupid')
UNION (SELECT invoices.invoice_id,invoices.invname,invoices.invstatus,invoices.invemail,invoices.woid,invoices.receipt_id,invoices.invdate,invoices.invcompany,invoices.pcgroupid,invoices.invphone,invoices.invaddy1,invoices.invaddy2,invoices.invcity,invoices.invstate,invoices.invzip
FROM invoices WHERE invoices.pcgroupid = '$pcgroupid')
UNION (SELECT invoices.invoice_id,invoices.invname,invoices.invstatus,invoices.invemail,invoices.woid,invoices.receipt_id,invoices.invdate,invoices.invcompany,
invoices.pcgroupid,invoices.invphone,invoices.invaddy1,invoices.invaddy2,invoices.invcity,invoices.invstate,invoices.invzip
FROM invoices,blockcontracthours,blockcontract WHERE blockcontracthours.invoiceid = invoices.invoice_id
AND blockcontract.pcgroupid = '$pcgroupid' AND blockcontract.blockid = blockcontracthours.blockcontractid)
ORDER BY invdate DESC LIMIT $offset,$results_per_page";



$rs_find_invoices = @mysqli_query($rs_connect, $rs_invoices);
while($rs_find_invoices_q = mysqli_fetch_object($rs_find_invoices)) {
$invoice_id = "$rs_find_invoices_q->invoice_id";
$invname = "$rs_find_invoices_q->invname";
$invcompany = "$rs_find_invoices_q->invcompany";
$invstatus = "$rs_find_invoices_q->invstatus";
$invemail = "$rs_find_invoices_q->invemail";
$invphone = "$rs_find_invoices_q->invphone";
$invaddy1 = "$rs_find_invoices_q->invaddy1";
$invaddy2 = "$rs_find_invoices_q->invaddy2";
$invcity = "$rs_find_invoices_q->invcity";
$invstate = "$rs_find_invoices_q->invstate";
$invzip = "$rs_find_invoices_q->invzip";
$invwoid = "$rs_find_invoices_q->woid";
$invpcgroupid = "$rs_find_invoices_q->pcgroupid";
$invrec = "$rs_find_invoices_q->receipt_id";
$invdate = "$rs_find_invoices_q->invdate";
$invdate2 = date("F j, Y", strtotime($invdate));
$findinvtotal = "SELECT SUM(cart_price) AS invsubtotal, SUM(itemtax) AS invtax FROM invoice_items WHERE invoice_id = '$invoice_id'";
$findinvq = @mysqli_query($rs_connect, $findinvtotal);
$findinva = mysqli_fetch_object($findinvq);
$invtax = "$findinva->invtax";
$invsubtotal = "$findinva->invsubtotal";
$invtotal2 = $invtax + $invsubtotal;
$invtotal = number_format($invtotal2, 2, '.', '');

$invname_ue = urlencode($invname);
$invcompany_ue = urlencode($invcompany);
$invemail_ue = urlencode($invemail);
$invphone_ue = urlencode($invphone);
$invaddy1_ue = urlencode($invaddy1);
$invaddy2_ue = urlencode($invaddy2);
$invcity_ue = urlencode($invcity);
$invstate_ue = urlencode($invstate);
$invzip_ue = urlencode($invzip);

if ($invstatus == 1) {
$thestatus = "Open";
} elseif ($invstatus == 2) {
$thestatus = "Closed/Paid";
} else {
$thestatus = "Voided";
}

$returnurl = urlencode("../repair/group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=invoices&pageNumber=$pageNumber");

echo "<table class=standard><tr><th>".pcrtlang("Invoice")."# $invoice_id</th></tr><tr><td>$invname</td></tr>";
if ("$invcompany" != "") {
echo "<tr><td>$invcompany</td></tr>";
}
echo "</td><td>$invdate2</td></tr><tr><td>$money$invtotal</td></tr><tr><td>".pcrtlang("Status").": ".pcrtlang("$thestatus")."</td></tr>";
echo "<tr><td>";

echo "<div data-role=\"collapsible\" data-theme=\"b\">";
echo "<h3>".pcrtlang("Invoice Actions")."</h3>";

echo "<button type=button onClick=\"parent.location='../store/invoice.php?func=printinv&invoice_id=$invoice_id'\"><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Print")."</button>";
echo "<button type=button onClick=\"parent.location='../store/invoice.php?func=emailinv2&invoice_id=$invoice_id&emailaddy=$invemail'\"><i class=\"fa fa-envelope fa-lg\"></i> ".pcrtlang("Email")."</button>";
if ($invstatus == "1") {
echo "<button type=button onClick=\"parent.location='../store/invoice.php?func=checkoutinv&invoice_id=$invoice_id&woid=$invwoid&custname=$invname_ue&company=$invcompany_ue&custaddy1=$invaddy1_ue&custaddy2=$invaddy2_ue&custcity=$invcity_ue&custstate=$invstate_ue&custzip=$invzip_ue&custphone=$invphone_ue&custemail=$invemail_ue&pcgroupid=$pcgroupid'\"><i class=\"fa fa-shopping-cart fa-lg\"></i> ".pcrtlang("Checkout")."</button>";

echo "<a href=\"#popupvoidinv$invoice_id\" data-rel=\"popup\" data-position-to=\"window\" data-transition=\"pop\" class=\"ui-btn ui-shadow ui-corner-all\">";
echo "<i class=\"fa fa-ban fa-lg\"></i> ".pcrtlang("Void this Invoice")."</a>";
echo "<div data-role=\"popup\" id=\"popupvoidinv$invoice_id\" data-overlay-theme=\"b\"  data-theme=\"a\" data-dismissible=\"false\">";
echo "<div data-role=\"header\" data-theme=\"b\">";
echo "<h1>".pcrtlang("Void this Invoice")."?</h1>";
echo "</div>";
echo "<div role=\"main\" class=\"ui-content\">";
echo "<p>".pcrtlang("Are you sure you wish to void this invoice?")."</p>";
echo "<div align=\"right\"><a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\" data-inline=\"true\">";
echo "<i class=\"fa fa-ban fa-lg\"></i>  ".pcrtlang("Cancel")."</a>";
echo "<button onClick=\"../store/invoice.php?func=changeinvoicestatus&invstatus=3&invoice_id=$invoice_id&returnurl=$returnurl'\" data-inline=\"true\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Void Invoice")." </button></div>";
echo "</div>";
echo "</div>";



echo "<a href=\"#popupcloseinv$invoice_id\" data-rel=\"popup\" data-position-to=\"window\" data-transition=\"pop\" class=\"ui-btn ui-shadow ui-corner-all\">";
echo "<i class=\"fa fa-check fa-lg\"></i> ".pcrtlang("Close this Invoice")."</a>";
echo "<div data-role=\"popup\" id=\"popupcloseinv$invoice_id\" data-overlay-theme=\"b\"  data-theme=\"a\" data-dismissible=\"false\">";
echo "<div data-role=\"header\" data-theme=\"b\">";
echo "<h1>".pcrtlang("Close this Invoice")."?</h1>";
echo "</div>";
echo "<div role=\"main\" class=\"ui-content\">";
echo "<p>".pcrtlang("Are you sure you wish to close this invoice? Usually you want to checkout an invoice so that the invoice gets marked as paid.")."</p>";
echo "<div align=\"right\"><a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\" data-inline=\"true\">";
echo "<i class=\"fa fa-ban fa-lg\"></i>  ".pcrtlang("Cancel")."</a>";
echo "<button onClick=\"parent.location='../store/invoice.php?func=changeinvoicestatus&invstatus=2&invoice_id=$invoice_id&returnurl=$returnurl'\" data-inline=\"true\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Close Invoice")." </button></div>";
echo "</div>";
echo "</div>";


} else {

echo "<a href=\"#popupreopeninv$invoice_id\" data-rel=\"popup\" data-position-to=\"window\" data-transition=\"pop\" class=\"ui-btn ui-shadow ui-corner-all\">";
echo "<i class=\"fa fa-retweet fa-lg\"></i> ".pcrtlang("Re-Open this Invoice")."</a>";
echo "<div data-role=\"popup\" id=\"popupreopeninv$invoice_id\" data-overlay-theme=\"b\"  data-theme=\"a\" data-dismissible=\"false\">";
echo "<div data-role=\"header\" data-theme=\"b\">";
echo "<h1>".pcrtlang("Re-open this Invoice")."?</h1>";
echo "</div>";
echo "<div role=\"main\" class=\"ui-content\">";
echo "<p>".pcrtlang("Are you sure you wish to re-open this invoice?")."</p>";
echo "<div align=\"right\"><a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\" data-inline=\"true\">";
echo "<i class=\"fa fa-ban fa-lg\"></i>  ".pcrtlang("Cancel")."</a>";
echo "<button onClick=\"parent.location='../store/invoice.php?func=changeinvoicestatus&invstatus=1&invoice_id=$invoice_id&returnurl=$returnurl'\" data-inline=\"true\">";
echo " ".pcrtlang("Re-open Invoice")." </button></div>";
echo "</div>";
echo "</div>";


}

echo "<br>";
if($invwoid != "") {
$invoicestolist = explode_list($invwoid);
foreach($invoicestolist as $key => $woids) {
echo "<button type=button onClick=\"parent.location='../repair/pc.php?func=view&woid=$woids'\">".pcrtlang("Work Order")." #$woids</button>";
}
}
if($invrec != "0") {
echo "<button type=button onClick=\"parent.location='../store/receipt.php?func=show_receipt&receipt=$invrec'\"><i class=\"fa fa-eye fa-lg\"></i>".pcrtlang("View Receipt")." #$invrec</button>";
}

echo "</div>";

echo "</td></tr></table><br><br>";

}


echo "<br>";

#browse here
$totalentry = mysqli_num_rows($rs_find_invoicest);
$prevpage = $pageNumber - 1;
$nextpage = $pageNumber + 1;

echo "<center>";

if ($pageNumber > 1) {
echo "<button type=button onClick=\"parent.location='group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=invoices&pageNumber=$prevpage'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\">";
echo "<i class=\"fa fa-chevron-left fa-lg\"></i></button>&nbsp;";
}

$total_results = $totalentry;
$results_per_page = $results_per_page;
$html = get_paged_nav($total_results, $results_per_page, false);
echo "$html";
if (($totalentry / $results_per_page) > $pageNumber) {
echo "<button type=button onClick=\"parent.location='group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=invoices&pageNumber=$nextpage'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\">";
echo "<i class=\"fa fa-chevron-right fa-lg\"></i></button>";
}

echo "</center>";


echo "</div>";
echo "<div id=\"recurringinvoices\" class=\"ui-body-d ui-content\" style=\"padding:2px;\">";






echo "<h3>".pcrtlang("All Recurring Invoices")."</h3>";

$rs_invoices = "SELECT * FROM rinvoices WHERE pcgroupid = '$pcgroupid' ORDER BY invthrudate ASC";
$rs_find_invoices = @mysqli_query($rs_connect, $rs_invoices);
while($rs_find_invoices_q = mysqli_fetch_object($rs_find_invoices)) {
$rinvoice_id = "$rs_find_invoices_q->rinvoice_id";
$invname = "$rs_find_invoices_q->invname";
$invcompany = "$rs_find_invoices_q->invcompany";
$invactive = "$rs_find_invoices_q->invactive";
$invemail = "$rs_find_invoices_q->invemail";
$invphone = "$rs_find_invoices_q->invphone";
$invaddy1 = "$rs_find_invoices_q->invaddy1";
$invaddy2 = "$rs_find_invoices_q->invaddy2";
$invcity = "$rs_find_invoices_q->invcity";
$invstate = "$rs_find_invoices_q->invstate";
$invzip = "$rs_find_invoices_q->invzip";
$invthrudate = "$rs_find_invoices_q->invthrudate";
$invterms = "$rs_find_invoices_q->invterms";
$invinterval = "$rs_find_invoices_q->invinterval";
$invthrudate2 = date("F j, Y", strtotime($invthrudate));
$invstoreid = "$rs_find_invoices_q->storeid";
$pcgroupid = "$rs_find_invoices_q->pcgroupid";

$storeinfoarray = getstoreinfo($invstoreid);

$findinvtotal = "SELECT SUM(cart_price) AS invsubtotal, SUM(itemtax) AS invtax FROM rinvoice_items WHERE rinvoice_id = '$rinvoice_id'";
$findinvq = @mysqli_query($rs_connect, $findinvtotal);
$findinva = mysqli_fetch_object($findinvq);
$invtax = "$findinva->invtax";
$invsubtotal = "$findinva->invsubtotal";
$invtotal2 = $invtax + $invsubtotal;
$invtotal = number_format($invtotal2, 2, '.', '');
if ($invactive == 1) {
$thestatus = "Active";
} else {
$thestatus = "In-Active";
}

echo "<table class=standard><tr><th>#$rinvoice_id $invname</th></tr>";
if("$invcompany" != "") {
echo "<tr><td>$invcompany</td></tr>";
}



if ($activestorecount > 1) {
echo "<tr><td>".pcrtlang("Store").": $storeinfoarray[storesname]</td></tr>";
}

$returnurl = urlencode("../repairmobile/group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=recurringinvoices#recurringinvoices");

echo "<tr><td>$invthrudate2</td></tr><tr><td>$money$invtotal</td></tr>
<tr><td>".pcrtlang("$thestatus")."</td></tr>";
echo "<tr><td><button type=button onClick=\"parent.location='../storemobile/rinvoice.php?func=viewrinvoice&rinvoice_id=$rinvoice_id&returnurl=$returnurl'\"><i class=\"fa fa-eye fa-lg\"></i> ".pcrtlang("View")."</button> ";

echo "</td></tr></table><br>";

}


echo "</div>";
echo "<div id=\"stickynotes\" class=\"ui-body-d ui-content\" style=\"padding:2px;\">";


echo "<h3>".pcrtlang("Sticky Notes")."</h3>";



$rs_findnotes52 = "SELECT stickynotes.stickyid,stickynotes.stickytypeid,stickynotes.stickyaddy1,stickynotes.stickyaddy2,stickynotes.stickycity,
stickynotes.stickystate,stickynotes.stickyzip,stickynotes.stickyphone,stickynotes.stickyemail,stickynotes.stickyduedate,stickynotes.stickyuser,
stickynotes.stickynote,stickynotes.stickyname,stickynotes.refid,stickynotes.reftype,stickynotes.stickycompany FROM stickynotes, pc_wo, pc_owner
WHERE pc_owner.pcgroupid = '$pcgroupid'  AND pc_owner.pcid = pc_wo.pcid AND pc_wo.woid = stickynotes.refid AND stickynotes.reftype = 'woid' UNION
SELECT stickynotes.stickyid,stickynotes.stickytypeid,stickynotes.stickyaddy1,stickynotes.stickyaddy2,stickynotes.stickycity,
stickynotes.stickystate,stickynotes.stickyzip,stickynotes.stickyphone,stickynotes.stickyemail,stickynotes.stickyduedate,stickynotes.stickyuser,
stickynotes.stickynote,stickynotes.stickyname,stickynotes.refid,stickynotes.reftype,stickynotes.stickycompany FROM stickynotes WHERE stickynotes.reftype = 'groupid' AND stickynotes.refid = '$pcgroupid'";


$rs_result_n5 = mysqli_query($rs_connect, $rs_findnotes52);
$totalpcsonbench = mysqli_num_rows($rs_result_n5);

while($rs_result_qn5 = mysqli_fetch_object($rs_result_n5)) {
$stickyid = "$rs_result_qn5->stickyid";
$stickyaddy1 = "$rs_result_qn5->stickyaddy1";
$stickyaddy2 = "$rs_result_qn5->stickyaddy2";
$stickycity = "$rs_result_qn5->stickycity";
$stickystate = "$rs_result_qn5->stickystate";
$stickyzip = "$rs_result_qn5->stickyzip";
$stickyphone = "$rs_result_qn5->stickyphone";
$stickyemail = "$rs_result_qn5->stickyemail";
$stickyduedate = "$rs_result_qn5->stickyduedate";
$stickytypeid = "$rs_result_qn5->stickytypeid";
$stickyuser = "$rs_result_qn5->stickyuser";
$stickynote2 = "$rs_result_qn5->stickynote";
$stickynote = nl2br($stickynote2);
$stickyname = "$rs_result_qn5->stickyname";
$stickycompany = "$rs_result_qn5->stickycompany";
$refid = "$rs_result_qn5->refid";
$reftype = "$rs_result_qn5->reftype";

$rs_qst = "SELECT * FROM stickytypes WHERE stickytypeid = '$stickytypeid'";
$rs_resultst1 = mysqli_query($rs_connect, $rs_qst);
if(mysqli_num_rows($rs_resultst1) == "1") {
$rs_result_stq1 = mysqli_fetch_object($rs_resultst1);
$stickytypename = "$rs_result_stq1->stickytypename";
$stickybordercolor = "$rs_result_stq1->bordercolor";
$stickynotecolor = "$rs_result_stq1->notecolor";
$stickynotecolor2 = "$rs_result_stq1->notecolor2";
} else {
$stickytypename = "Undefined";
$stickybordercolor = "000000";
$stickynotecolor = "ffffff";
$stickynotecolor2 = "cccccc";
}


start_box_sn($stickynotecolor,$stickynotecolor2,$stickybordercolor);

echo "<font style=\"color:#$stickybordercolor\">$stickytypename: $stickyname</font>";

if ("$stickycompany" != "") {
echo "<br><font style=\"color:#$stickybordercolor\">$stickycompany</font>";
}

echo "<br><br>$stickynote<br>";

$stickyduedate2 = date("M j, Y, g:i a",strtotime($stickyduedate));
echo "<br>".pcrtlang("Date/Due Date").": $stickyduedate2";

if ($stickyuser != "none") {
echo "<br>".pcrtlang("Assigned To").": $stickyuser";
}

if ($stickyaddy1 != "") {
echo "<br>$stickyaddy1";
}

if ($stickyaddy2 != "") {
echo "<br>$stickyaddy2";
}
if (($stickycity != "") || ($stickystate != "") || ($stickyzip != "")){
echo "<br>$stickycity, $stickystate $stickyzip";
}

if ($stickyphone != "") {
echo "$stickyphone";
}

if ($stickyemail != "") {
echo "<button type=button onClick=\"parent.location='mailto:$stickyemail'\"> <i class=\"fa fa-envelope fa-lg\"></i> $stickyemail</button>";
}

if ($refid != "0") {
if ($reftype == "woid") {
echo "<button type=button onClick=\"parent.location='index.php?pcwo=$refid'\">".pcrtlang("Work Order")." #$refid</button>";
} elseif ($reftype == "pcid") {
echo "<button type=button onClick=\"parent.location='pc.php?func=showpc&pcid=$refid'\">".pcrtlang("PCID")." #$refid</button>";
}
}
echo "<button type=button onClick=\"parent.location='sticky.php?func=printsticky&stickyid=$stickyid'\"> <i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Print")."</button>";


stop_box();


}





echo "</div>";
echo "<div id=\"smslog\" class=\"ui-body-d ui-content\" style=\"padding:2px;\">";

echo "<h3>".pcrtlang("SMS Log")."</h3>";

#########################################################

$smsphonenumberoptions = "";
$phnumbers = array();

$emails = array();
if (filter_var($grpemail, FILTER_VALIDATE_EMAIL)) {
$emails[] = "$grpemail";
}

if($grpphone != "") {
$grpphonestripped = preg_replace("/[^0-9,.]/", "", "$grpphone");
if (!in_array($grpphonestripped, $phnumbers)) {
$phnumbers[] = "$grpphonestripped";
$smsphonenumberoptions .= "<option value=\"$mysmsprefix".filtersmsnumber("$grpphone")."\">".pcrtlang("Home from Group").": $grpphone</option>";
}
}
if($grpcellphone != "") {
$grpcellphonestripped = preg_replace("/[^0-9,.]/", "", "$grpcellphone");
if (!in_array($grpcellphonestripped, $phnumbers)) {
$phnumbers[] = "$grpcellphonestripped";
}
$smsphonenumberoptions .= "<option selected value=\"$mysmsprefix".filtersmsnumber("$grpcellphone")."\">".pcrtlang("Mobile from Group").": $grpcellphone</option>";
}

if($grpworkphone != "") {
$grpworkphonestripped = preg_replace("/[^0-9,.]/", "", "$grpworkphone");
if (!in_array($grpworkphonestripped, $phnumbers)) {
$phnumbers[] = "$grpworkphonestripped";
}
$smsphonenumberoptions .= "<option value=\"$mysmsprefix".filtersmsnumber("$grpworkphone")."\">".pcrtlang("Work from Group").": $grpworkphone</option>";
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


if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

$numberstosearch = "";

$rs_mwo = "SELECT pc_wo.woid,pc_owner.pcphone,pc_owner.pccellphone,pc_owner.pcworkphone,pc_owner.pcemail FROM pc_wo, pc_owner WHERE pc_owner.pcgroupid = '$pcgroupid' AND pc_owner.pcid = pc_wo.pcid";
$rs_mfind_wo = @mysqli_query($rs_connect, $rs_mwo);
while($rs_mfind_wo_q = mysqli_fetch_object($rs_mfind_wo)) {
$woid = "$rs_mfind_wo_q->woid";
$pcemail = "$rs_mfind_wo_q->pcemail";
$numberstosearch .= " OR woid = '$woid'";
$pcphone = "$rs_mfind_wo_q->pcphone";
$pcphonestripped = preg_replace("/[^0-9,.]/", "", "$pcphone");
if (!in_array($pcphonestripped, $phnumbers)) {
$phnumbers[] = "$pcphonestripped";
}
$pccellphone = "$rs_mfind_wo_q->pccellphone";
$pccellphonestripped = preg_replace("/[^0-9,.]/", "", "$pccellphone");
if (!in_array($pccellphonestripped, $phnumbers)) {
$phnumbers[] = "$pccellphonestripped";
}
$pcworkphone = "$rs_mfind_wo_q->pcworkphone";
$pcworkphonestripped = preg_replace("/[^0-9,.]/", "", "$pcworkphone");
if (!in_array($pcworkphonestripped, $phnumbers)) {
$phnumbers[] = "$pcworkphonestripped";
}

if (filter_var($pcemail, FILTER_VALIDATE_EMAIL)) {
if (!in_array($pcemail, $emails)) {
$emails[] = "$pcemail";
}
}



}

foreach ($phnumbers as $key=>&$value) {
    if (strlen($value) < 7) {
        unset($phnumbers[$key]);
    }
}

reset($phnumbers);


foreach($phnumbers as $key => $val) {
$numberstosearch .= " OR messagefrom LIKE '%".substr("$val", -7)."'";
}

foreach($emails as $key => $val) {
$numberstosearch .= " OR messagefrom = '$val'";
$numberstosearch .= " OR TRIM(REPLACE(REPLACE(messagefrom,'-',''),' ','')) LIKE '%".substr("$val", -7)."'";
}

$numberstosearch .= " OR groupid = '$pcgroupid'";

$whereclause = "1=2";

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

####


echo "<a href=\"group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=sms#smslog\"
 class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"  data-ajax=\"false\"><i class=\"fa fa-refresh fa-lg\"></i> ".pcrtlang("Refresh")."</a>";



echo "<div data-role=\"collapsible\" data-theme=\"b\">";
echo "<h3>".pcrtlang("Send Message")."</h3>";

echo "<table class=standard><tr>";

echo "<tr><th>".pcrtlang("Send SMS")." ($mysmsgateway)</th></tr>";

echo "<td>";


if ($mysmsgateway != "none") {
echo "<form action=sms.php?func=smssend2 method=post name=theform data-ajax=\"false\">";

echo "<input type=hidden name=groupid value=$pcgroupid>";
echo "<input type=hidden name=noajax value=no>";

if($smsphonenumberoptions != "") {
echo "<select name=smsnumber>$smsphonenumberoptions</select><br>";
} else {
echo "<input type=text name=smsnumber placeholder=\"Enter Mobile Number\"><br>";
}

$storeinfoarray = getstoreinfo($defaultuserstore);

echo "<select name=myoptions onchange='document.getElementById(\"smsmessage\").value=this.options[this.selectedIndex].value' style=\"width:300px;\">";
$rs_ql = "SELECT * FROM smstext ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
echo "<option value=\"\">".pcrtlang("Canned Messages")."</option>";
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
echo "<input type=hidden name=groupid value=$pcgroupid><textarea rows=2 name=smsmessage id=smsmessage class=textbox name=smsbox></textarea>";

echo "<br><font class=textgreen12b>".pcrtlang("Characters Remaining").": <span id=\"charsLeft\"></span></font>";
echo "<br><input type=submit value=\"".pcrtlang("Send SMS")."\" class=ibutton>";

?>
<script src="../repair/jq/jquery.limit-1.2.js" type="text/javascript"></script>
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


echo "</td></tr><tr><th>".pcrtlang("Log Call/Send Message")."</th></tr><tr><td style=\"vertical-align:top;\">";
echo "<form action=group.php?func=addmessage method=post data-ajax=\"false\"><input type=hidden name=groupid value=$pcgroupid>";
echo "<textarea name=themessage required=required class=textboxw style=\"width:95%;height:90px;\" placeholder=\"".pcrtlang("Enter Call Notes")."\"></textarea>";
echo "<fieldset data-role=\"controlgroup\">";
echo "<input type=radio name=type value=1 checked id=radio-choice-1><label for=\"radio-choice-1\">".pcrtlang("Call Log Note")."</label>";
echo "<input type=radio name=type value=2 id=radio-choice-2><label for=\"radio-choice-2\">".pcrtlang("Portal Message")."</label>";
echo "<input type=radio name=type value=3 id=radio-choice-3><label for=\"radio-choice-3\">".pcrtlang("Send Email")."<br>";
echo pcrtlang("From").": <select name=fromemail>";
$storeinfoarray = getstoreinfo($defaultuserstore);
if("$storeinfoarray[storeemail]" != "") {
echo "<option value=\"$storeinfoarray[storeemail]\">".pcrtlang("Store").": $storeinfoarray[storeemail]</option>";
}
$techemail = getuseremail("$ipofpc");
if("$techemail" != "") {
echo "<option value=\"$techemail\">".pcrtlang("Tech").": $techemail</option>";
}
echo "</select><br>";

echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".pcrtlang("To").": <select name=toemail>";
if(isset($grpemail)) {
if("$grpemail" != "") {
echo "<option value=\"$grpemail\">$grpemail</option>";
}
}
echo "</select></label>";
echo "</fieldset>";
echo "<button type=submit class=sbutton><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save/Send")."</button></form>";
echo "</td></tr></table><br>";
echo "</div>";



####


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

echo "<tr><td>";
$messagedatetime = pcrtdate("$pcrt_time", "$messagedatetime2")." ".pcrtdate("$pcrt_shortdate", "$messagedatetime2");
$messagedirection = "$rs_result_qn->messagedirection";
if($messagedirection == "in") {
echo "<i class=\"fa fa-reply fa-lg colormeblue\"></i> $viaicon <span>$messagefrom</span><br>";
echo "<i class=\"fa fa-clock-o fa-lg\"></i> <span>$messagedatetime</span><br>";
echo "<i class=\"fa fa-comment fa-lg\"></i> <span>$messagebody</span>";
} elseif($messagedirection == "out") {
echo "$viaicon <i class=\"fa fa-share fa-lg\"></i> <span>$messagefrom</span><br>";
echo "<i class=\"fa fa-clock-o fa-lg\"></i> <span>$messagedatetime</span><br>";
echo "<i class=\"fa fa-comment fa-lg\"></i> <span>$messagebody</span>";
} else {
echo "<i class=\"fa fa-user-md fa-lg\"></i> <span>$messagefrom</span><br>";
echo "<i class=\"fa fa-clock-o fa-lg\"></i> <span>$messagedatetime</span><br>";
echo "<i class=\"fa fa-comment fa-lg\"></i> <span>$messagebody</span>";
}


echo "</td></tr>";

}

echo "</table><br>";

echo "<center>";
#browse here

if($pageNumber != 1) {
$prevpage = $pageNumber - 1;
echo "<a href=group.php?func=viewgroup&pageNumber=$prevpage&pcgroupid=$pcgroupid#smslog
 class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"  data-ajax=\"false\"><i class=\"fa fa-chevron-left fa-lg\"></i></a> ";
}

$results_per_page = $results_per_page;
$html = get_paged_nav($totalentries, $results_per_page, false);
echo "$html";

if($lastpage != $pageNumber) {
$nextpage = $pageNumber + 1;
echo "<a href=group.php?func=viewgroup&pageNumber=$nextpage&pcgroupid=$pcgroupid#smslog
 class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"  data-ajax=\"false\"><i class=\"fa fa-chevron-right fa-lg\"></i></a>";
}

echo "</center>";





#########################################################

echo "</div>";
echo "<div id=\"workorders\" class=\"ui-body-d ui-content\" style=\"padding:2px;\">";


/* Start of Work Orders  */

if (array_key_exists('pageNumber',$_REQUEST)) {
$pageNumber = $_REQUEST[pageNumber];
} else {
$pageNumber = 1;
}

$results_per_page = 40;

$offset = ($pageNumber * $results_per_page) - $results_per_page;







echo "<h3>".pcrtlang("Work Orders")."</h3>";

$rs_wot = "SELECT pc_wo.woid FROM pc_wo, pc_owner WHERE pc_owner.pcgroupid = '$pcgroupid' AND pc_owner.pcid = pc_wo.pcid";
$rs_find_wot = @mysqli_query($rs_connect, $rs_wot);

$rs_wo = "SELECT pc_wo.woid,pc_wo.probdesc,pc_wo.dropdate,pc_wo.pcid FROM pc_wo, pc_owner WHERE pc_owner.pcgroupid = '$pcgroupid' AND pc_owner.pcid = pc_wo.pcid ORDER BY pc_wo.dropdate DESC LIMIT $offset,$results_per_page";

$rs_find_wo = @mysqli_query($rs_connect, $rs_wo);
while($rs_find_wo_q = mysqli_fetch_object($rs_find_wo)) {
$woid = "$rs_find_wo_q->woid";
$probdesc = "$rs_find_wo_q->probdesc";
$dropdate = "$rs_find_wo_q->dropdate";
$pcid = "$rs_find_wo_q->pcid";
$dropdate2 = date("F j, Y", strtotime($dropdate));

$findcompname = "SELECT * FROM pc_owner WHERE pcid = '$pcid'";
$findcompq = @mysqli_query($rs_connect, $findcompname);
$findcompa = mysqli_fetch_object($findcompq);
$compname = "$findcompa->pcname";
$compcompany = "$findcompa->pccompany";
$compmake = "$findcompa->pcmake";


echo "<table class=standard><tr><th><button type=button onClick=\"parent.location='index.php?pcwo=$woid'\">".pcrtlang("Work Order")." #$woid</button></th></tr><tr><td>$compname</td></tr><tr><td>$dropdate2</td></tr>";
echo "<tr><td>$compmake</td></tr>";
if("$compcompany" != "") {
echo "<tr><td>$compcompany</td></tr>";
}
echo "<tr><td>$probdesc</td></tr></table><br>";
}

echo "<br>";

#browse here
$totalentry = mysqli_num_rows($rs_find_wot);
$prevpage = $pageNumber - 1;
$nextpage = $pageNumber + 1;

if ($pageNumber > 1) {
echo "<button type=button onClick=\"parent.location='group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=wo&pageNumber=$prevpage'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\">";
echo "<i class=\"fa fa-chevron-left fa-lg\"></i></button>";
}

$total_results = $totalentry;
$results_per_page = $results_per_page;
$html = get_paged_nav($total_results, $results_per_page, false);
echo "$html";
if (($totalentry / $results_per_page) > $pageNumber) {
echo "<button type=button onClick=\"parent.location='group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=wo&pageNumber=$nextpage'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\">";
echo "<i class=\"fa fa-chevron-left fa-lg\"></i></button>";
}


#blockoftime

echo "</div>";
echo "<div id=\"botc\" class=\"ui-body-d ui-content\" style=\"padding:0px;\">";




echo "<button type=button onClick=\"parent.location='blockcontract.php?func=newcontract&pcgroupid=$pcgroupid'\"><img src=../repair/images/wohistory.png border=0 align=absmiddle width=24> ".pcrtlang("New Block of Time Contract")."</button>";


echo "<br>";

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

function array_sort_by_column(&$array, $column, $direction = SORT_ASC) {
    $reference_array = array();

    foreach($array as $key => $row) {
        $reference_array[$key] = $row[$column];
    }

    array_multisort($reference_array, $direction, $array);
}





$rs_bcs = "SELECT * FROM blockcontract WHERE pcgroupid = '$pcgroupid'";
$rs_find_bcs = @mysqli_query($rs_connect, $rs_bcs);

while($rs_find_bcs_q = mysqli_fetch_object($rs_find_bcs)) {
$blockid = "$rs_find_bcs_q->blockid";
$blocktitle = "$rs_find_bcs_q->blocktitle";
$blocknote = "$rs_find_bcs_q->blocknote";
$blockstart = "$rs_find_bcs_q->blockstart";
$contractclosed = "$rs_find_bcs_q->contractclosed";

$blocktitle_ue = urlencode("$blocktitle");

echo "<table class=standard><tr><th>$blocktitle</th></tr>";
echo "<tr><td>".pcrtlang("Start Date").": $blockstart</td></tr>";

$rs_checkrinvoice2 = "SELECT * FROM rinvoices WHERE blockcontractid = '$blockid'";
$rs_result_rci2 = mysqli_query($rs_connect, $rs_checkrinvoice2);

echo "<tr><td>".pcrtlang("Notes").":<br>$blocknote</td></tr>";

echo "<tr><td>";

echo "<div data-role=\"collapsible\" data-theme=\"b\">";
echo "<h3>".pcrtlang("Actions")."</h3>";

if($contractclosed == 0) {
echo "<button type=button onClick=\"parent.location='blockcontract.php?func=starttimerbc&pcgroupid=$pcgroupid&blockcontractid=$blockid'\"><img src=../repair/images/clock.png border=0 align=absmiddle width=24> ".pcrtlang("Start New Timer")."</button>";
echo "<button type=button onClick=\"parent.location='pc.php?func=timerstartmanual&pcgroupid=$pcgroupid&blockcontractid=$blockid'\"><img src=../repair/images/clock.png border=0 align=absmiddle width=24> ".pcrtlang("Add Manual Time")."</button>";
echo "<button type=button onClick=\"parent.location='blockcontract.php?func=addhourssingle&pcgroupid=$pcgroupid&blockcontractid=$blockid&blocktitle=$blocktitle_ue'\"><img src=../repair/images/invoice.png border=0 align=absmiddle width=24> ".pcrtlang("Add Hours/Invoice")."</button>";
if (mysqli_num_rows($rs_result_rci2) == "0") {
echo "<button type=button onClick=\"parent.location='blockcontract.php?func=addhoursrecurring&pcgroupid=$pcgroupid&blockcontractid=$blockid&blocktitle=$blocktitle_ue'\">
<img src=../store/images/rinvoice.png border=0 align=absmiddle width=24> ".pcrtlang("Add Recurring Hours/Invoice")."</button>";
} else {
$rs_result_qrci2 = mysqli_fetch_object($rs_result_rci2);
$rinvoice_id2 = "$rs_result_qrci2->rinvoice_id";
echo "<button type=button onClick=\"parent.location='../store/rinvoice.php?func=viewrinvoice&rinvoice_id=$rinvoice_id2'\"><img src=../store/images/rinvoice.png border=0 align=absmiddle width=24> ".pcrtlang("Recurring Invoice")." #$rinvoice_id2</button>";

$rs_findsc = "SELECT * FROM servicecontracts WHERE rinvoice = '$rinvoice_id2'";
$rs_resultsc = mysqli_query($rs_connect, $rs_findsc);

if(mysqli_num_rows($rs_resultsc) != 0) {
$rs_resultsc_q = mysqli_fetch_object($rs_resultsc);
$scid = "$rs_resultsc_q->scid";
$scname = "$rs_resultsc_q->scname";
echo  "<button type=button onClick=\"parent.location='msp.php?func=viewservicecontract&scid=$scid'\"><img src=../repair/images/contract.png border=0 align=absmiddle width=24>".pcrtlang("Service Contract").":<br>$scname</button>";
}



}
echo "<button type=button onClick=\"parent.location='blockcontract.php?func=contractclosed&contractclosed=1&pcgroupid=$pcgroupid&blockcontractid=$blockid'\">
<img src=../store/images/right.png border=0 align=absmiddle width=24> ".pcrtlang("Close this Contract")."</button>";
echo "<button type=button onClick=\"parent.location='blockcontract.php?func=editcontract&pcgroupid=$pcgroupid&blockcontractid=$blockid'\">
<img src=../repair/images/woedit.png border=0 align=absmiddle width=24> ".pcrtlang("Edit this Contract")."</button>";
} else {
echo "<button type=button onClick=\"parent.location='blockcontract.php?func=contractclosed&contractclosed=0&pcgroupid=$pcgroupid&blockcontractid=$blockid'\">
<img src=../repair/images/right.png border=0 align=absmiddle width=24> ".pcrtlang("Re-Open this Contract")."</button>";
}

echo "<button type=button onClick=\"parent.location='group.php?func=bcreport&blockid=$blockid'\">
<img src=../repair/images/print.png border=0 align=absmiddle width=24> ".pcrtlang("Print Report")."</button>";


if (!filter_var($grpemail, FILTER_VALIDATE_EMAIL) === false) {
echo "<button type=button onClick=\"parent.location='group.php?func=bcreportemail&blockid=$blockid&pcgroupid=$pcgroupid&to=$grpemail'\">
<img src=../repair/images/email.png border=0 align=absmiddle width=24> ".pcrtlang("Email Report")."</button>";
}

echo "</div>";

echo "</td></tr>";

echo "</table><br><br>";



#lines

$masterlist = array();
$timebalance = 0;

$rs_findblockhours = "SELECT * FROM blockcontracthours WHERE blockcontractid = '$blockid'";
$rs_result_bh = mysqli_query($rs_connect, $rs_findblockhours);
while($rs_result_qbh = mysqli_fetch_object($rs_result_bh)) {
$blockhours = "$rs_result_qbh->blockhours";
$blockcontracthoursid = "$rs_result_qbh->blockcontracthoursid";
$blockhoursdate = "$rs_result_qbh->blockhoursdate";
$invoiceid = "$rs_result_qbh->invoiceid";
$masterlist[] = array("linetype" => "blockhours", "blockhours" => "$blockhours", "thedate" => "$blockhoursdate 0000-00-00 00:00:00", "invoiceid" => "$invoiceid", "thedateonly" => "$blockhoursdate", "blockcontracthoursid" => "$blockcontracthoursid");
}


$rs_findtimers = "SELECT * FROM timers WHERE blockcontractid = '$blockid'";
$rs_result_t = mysqli_query($rs_connect, $rs_findtimers);
while($rs_result_qt = mysqli_fetch_object($rs_result_t)) {
$timername = "$rs_result_qt->timerdesc";
$timerstart = "$rs_result_qt->timerstart";
$timerstop = "$rs_result_qt->timerstop";
$timertotal = "$rs_result_qt->timertotal";
$timerid = "$rs_result_qt->timerid";
$billedout = "$rs_result_qt->billedout";
$timerbyuser = "$rs_result_qt->byuser";
$woid = "$rs_result_qt->woid";
$savedround = "$rs_result_qt->savedround";


$timerstart_2822 = date('r', strtotime("$timerstart"));

$timerstartdate2 = date('n-j-Y', strtotime($timerstart));
$timerstarttime2 = date('g:ia', strtotime($timerstart));
$timerstoptime2 = date('g:ia', strtotime($timerstop));

$startepoch = strtotime($timerstart);
$stopepoch = time();
$startseconds = $stopepoch - $startepoch;

$masterlist[] = array("savedround" => "$savedround", "timerid" => "$timerid", "linetype" => "timer", "timername" => "$timername", "thedate" => "$timerstart", "timerstop" => "$timerstop", "timeruser" => "$timerbyuser", "woid" => "$woid");
}


array_sort_by_column($masterlist, 'thedate');

echo "<table style=\"width:100%\" class=standard>";

$runningtime = 0;

foreach($masterlist as $key => $subarray) {

#timercode start
if($subarray['linetype'] == "timer") {

$timername = $subarray['timername']; 
$timerstart = $subarray['thedate'];
$timerstop = $subarray['timerstop'];
$timerid = $subarray['timerid'];
$timerbyuser = $subarray['timeruser'];
$woid = $subarray['woid'];
$savedround = $subarray['savedround'];

$timerstart_2822 = date('r', strtotime("$timerstart"));

$timerstartdate2 = date('Y-n-j', strtotime($timerstart));
$timerstarttime2 = date('g:ia', strtotime($timerstart));
$timerstoptime2 = date('g:ia', strtotime($timerstop));


$startepoch = strtotime($timerstart);
$stopepoch = time();
$startseconds = $stopepoch - $startepoch;



if($timerstop == "0000-00-00 00:00:00") {
echo "<tr><th colspan=3 style=\"border-left: #F2AD0E 10px solid;\">$timername</td></tr>";
if($woid != "0") {
echo "<tr><td colspan=3 style=\"border-left: #F2AD0E 10px solid;\"><button type=button onClick=\"parent.location='index.php?pcwo=$woid'\">WO #$woid</button></td></tr>";

echo "<tr><td>";
echo "<a href=\"#popupremcontract$timerid\" data-rel=\"popup\" data-position-to=\"window\" data-transition=\"pop\" class=\"ui-btn ui-shadow ui-corner-all\">";
echo "<img src=images/del.png style=\"width:20px;\"> ".pcrtlang("Remove from Contract")."</a>";
echo "<div data-role=\"popup\" id=\"popupremcontract$timerid\" data-overlay-theme=\"b\"  data-theme=\"a\" data-dismissible=\"false\">";
echo "<div data-role=\"header\" data-theme=\"b\">";
echo "<h1>".pcrtlang("Remove from Contract")."?</h1>";
echo "</div>";
echo "<div role=\"main\" class=\"ui-content\">";
echo "<p>".pcrtlang("Are you sure you want to remove this timer from this contract?")."</p>";
echo "<div align=\"right\"><a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\" data-inline=\"true\">";
echo "<i class=\"fa fa-ban fa-lg\"></i>  ".pcrtlang("Cancel")."</a>";
echo "<button onClick=\"parent.location='blockcontract.php?func=removefromcontract&timer=$timerid&pcgroupid=$pcgroupid'\" data-inline=\"true\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Remove from Contract")." </button></div>";
echo "</div>";
echo "</div></td></tr>";

}

echo "<tr><td colspan=3 style=\"border-left: #F2AD0E 10px solid;\">$timerbyuser</td></tr>
<tr><td colspan=3 style=\"border-left: #F2AD0E 10px solid;\">$timerstartdate2 $timerstarttime2</td></tr>
<tr><td colspan=3 style=\"border-left: #F2AD0E 10px solid;\">";

?>
<i class="fa fa-spinner fa-lg fa-spin"></i> 
<span id="<?php echo "$timerid"; ?>hours">0</span>:<span id="<?php echo "$timerid"; ?>minutes">00</span>:<span id="<?php echo "$timerid"; ?>seconds">00</span>
    <script type="text/javascript">
        var hoursLabel<?php echo "$timerid"; ?> = document.getElementById("<?php echo "$timerid"; ?>hours");
        var minutesLabel<?php echo "$timerid"; ?> = document.getElementById("<?php echo "$timerid"; ?>minutes");
        var secondsLabel<?php echo "$timerid"; ?> = document.getElementById("<?php echo "$timerid"; ?>seconds");
        var totalSeconds<?php echo "$timerid"; ?> = <?php echo "$startseconds"; ?>;
        setInterval(setTime<?php echo "$timerid"; ?>, 1000);

   function setTime<?php echo "$timerid"; ?>()
        {
            ++totalSeconds<?php echo "$timerid"; ?>;
            secondsLabel<?php echo "$timerid"; ?>.innerHTML = pad(totalSeconds<?php echo "$timerid"; ?>%60);
            minutesLabel<?php echo "$timerid"; ?>.innerHTML = pad(parseInt(totalSeconds<?php echo "$timerid"; ?>/60) %60);
            hoursLabel<?php echo "$timerid"; ?>.innerHTML = parseInt(totalSeconds<?php echo "$timerid"; ?>/3600);
        }

    </script>

<?php


echo "</td><tr>";
if($contractclosed == 0) {
echo "<tr><td colspan=3 style=\"border-left: #F2AD0E 10px solid;\"><form action=pc.php?func=timereditprog&pcgroupid=$pcgroupid&blockcontractid=$blockid&timerid=$timerid method=post  data-ajax=\"false\"><button type=submit><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("Edit")."</button></form></td></tr>";
}
if($contractclosed == 0) {
echo "<tr><td colspan=3 style=\"border-left: #F2AD0E 10px solid;\"><form action=pc.php?func=timerstop&pcgroupid=$pcgroupid&blockcontractid=$blockid&timerid=$timerid method=post data-ajax=\"false\"><button type=submit><i class=\"fa fa-stop fa-lg\"></i> ".pcrtlang("Stop")."</button></form></td></tr>";
}


} else {

$startstamp = strtotime("$timerstart");
$stopstamp = strtotime("$timerstop");

$elapsedtime = $stopstamp - $startstamp;
$timeusedact =  mf($elapsedtime / 3600);


if($savedround == 15) {
$elapsedtime2 = ($elapsedtime - ($elapsedtime % 900)) + 900; 
$runningtime = $runningtime - $elapsedtime2;
} elseif($savedround == 30) {
$elapsedtime2 = ($elapsedtime - ($elapsedtime % 1800)) + 1800;
$runningtime = $runningtime - $elapsedtime2;
} elseif($savedround == 60) {
$elapsedtime2 = ($elapsedtime - ($elapsedtime % 3600)) + 3600;
$runningtime = $runningtime - $elapsedtime2;
} else {
$elapsedtime2 = $elapsedtime;
$runningtime = $runningtime - $elapsedtime2;
}

$timeused =  mf($elapsedtime2 / 3600);

$timebalance = mf($runningtime / 3600);

$elapsedhuman = time_elapsed($elapsedtime);



echo "<tr><th colspan=3 style=\"vertical-align:top; border-left: #FF4938 10px solid;\">$timername</th></tr>";

if($woid != "0") {
echo "<tr><td colspan=3 style=\"vertical-align:top; border-left: #FF4938 10px solid;\"><button type=button onClick=\"parent.location='index.php?pcwo=$woid'\">WO #$woid</button></td></tr>";

echo "<tr><td colspan=3 style=\"vertical-align:top; border-left: #FF4938 10px solid;\">";
echo "<a href=\"#popupremcontract2$timerid\" data-rel=\"popup\" data-position-to=\"window\" data-transition=\"pop\" class=\"ui-btn ui-shadow ui-corner-all\">";
echo "<img src=images/del.png style=\"width:20px;\"> ".pcrtlang("Remove from Contract")."</a>";
echo "<div data-role=\"popup\" id=\"popupremcontract2$timerid\" data-overlay-theme=\"b\"  data-theme=\"a\" data-dismissible=\"false\">";
echo "<div data-role=\"header\" data-theme=\"b\">";
echo "<h1>".pcrtlang("Remove from Contract")."?</h1>";
echo "</div>";
echo "<div role=\"main\" class=\"ui-content\">";
echo "<p>".pcrtlang("Are you sure you want to remove this timer from this contract?")."</p>";
echo "<div align=\"right\"><a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\" data-inline=\"true\">";
echo "<i class=\"fa fa-ban fa-lg\"></i>  ".pcrtlang("Cancel")."</a>";
echo "<button onClick=\"parent.location='blockcontract.php?func=removefromcontract&timer=$timerid&pcgroupid=$pcgroupid'\" data-inline=\"true\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Remove from Contract")." </button></div>";
echo "</div>";
echo "</div></td></tr>";

}


echo "<tr><td colspan=3 style=\"vertical-align:top; border-left: #FF4938 10px solid;\">$timerbyuser</td></tr>
<tr><td colspan=3 style=\"vertical-align:top; border-left: #FF4938 10px solid;\"><font class=textgreen12b>$timerstartdate2 $timerstarttime2</font></td></tr>
<tr><td colspan=3 style=\"vertical-align:top; border-left: #FF4938 10px solid;\">$timerstoptime2</td></tr>";
if($contractclosed == 0) {

echo "<tr><td colspan=3 style=\"vertical-align:top; border-left: #FF4938 10px solid;\">";
echo "<a href=\"#popupdeletetimer$timerid\" data-rel=\"popup\" data-position-to=\"window\" data-transition=\"pop\" class=\"ui-btn ui-shadow ui-corner-all\">";
echo "<i class=\"fa fa-times fa-lg\"></i> ".pcrtlang("Delete Timer")."</a>";
echo "<div data-role=\"popup\" id=\"popupdeletetimer$timerid\" data-overlay-theme=\"b\"  data-theme=\"a\" data-dismissible=\"false\">";
echo "<div data-role=\"header\" data-theme=\"b\">";
echo "<h1>".pcrtlang("Delete Timer")."?</h1>";
echo "</div>";
echo "<div role=\"main\" class=\"ui-content\">";
echo "<p>".pcrtlang("Are you sure you want to delete this timer?")."</p>";
echo "<div align=\"right\"><a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\" data-inline=\"true\">";
echo "<i class=\"fa fa-ban fa-lg\"></i>  ".pcrtlang("Cancel")."</a>";
echo "<button onClick=\"parent.location='pc.php?func=timerdelete&pcgroupid=$pcgroupid&blockcontractid=$blockid&timerid=$timerid'\" data-inline=\"true\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")." </button></div>";
echo "</div>";
echo "</div></td></tr>";



}
if($contractclosed == 0) {
echo "<tr><td colspan=3 style=\"vertical-align:top; border-left: #FF4938 10px solid;\"><form action=pc.php?func=timeredit&pcgroupid=$pcgroupid&blockcontractid=$blockid&timerid=$timerid method=post data-ajax=\"false\"><button type=submit><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("Edit")."</button></form></td></tr>";
}
if($contractclosed == 0) {
echo "<tr><td colspan=3 style=\"vertical-align:top; border-left: #FF4938 10px solid;\"><form action=pc.php?func=timerstart&pcgroupid=$pcgroupid&blockcontractid=$blockid method=post data-ajax=\"false\"><input type=hidden name=timername value=\"$timername\"><button type=submit><i class=\"fa fa-play fa-lg\"></i> ".pcrtlang("Resume")."</button></form></td></tr>";
}
if($contractclosed == 0) {
echo "<tr><td colspan=3 style=\"vertical-align:top; border-left: #FF4938 10px solid;\"><button class=button onClick=\"parent.location='blockcontract.php?func=roundblock&pcgroupid=$pcgroupid&timerid=$timerid'\"><i class=\"fa fa-arrows-v fa-lg\"></i> ".pcrtlang("Round")."</button></td></tr>";
}

echo "<tr><th style=\"vertical-align:top; border-left: #FF4938 10px solid; border-bottom: #333333 1px solid;\">".pcrtlang("Actual")."<br>$timeusedact</font></th><th style=\"text-align:right; border-bottom: #333333 1px solid;\">".pcrtlang("Applied")."<br>-$timeused</th><th style=\"text-align:right; border-bottom: #333333 1px solid;\">".pcrtlang("Balance")."<br>$timebalance</th></tr>";

}





} else {
#timercode stop
#line item start

$rs_checkinvoice = "SELECT invstatus FROM invoices WHERE invoice_id = '$invoiceid'";
$rs_result_ci = mysqli_query($rs_connect, $rs_checkinvoice);
$rs_result_qci = mysqli_fetch_object($rs_result_ci);
$invstatus = "$rs_result_qci->invstatus";


$blockhours = $subarray['blockhours'];
$thedateonly = $subarray['thedateonly'];
$invoiceid = $subarray['invoiceid'];

if($invstatus == 2) {
$runningtime = $runningtime + (3600 * $blockhours);
} else {
$runningtime = $runningtime;
}

$timebalance = mf($runningtime / 3600);

echo "<tr><th colspan=3 style=\"border-left: #98D25F 10px solid;\">".pcrtlang("Purchased Hours")."</th></tr>";



if(($invstatus == 3) && ($contractclosed == 0)) {

echo "<tr><td colspan=3 style=\"border-left: #98D25F 10px solid;\">";
echo "<a href=\"#popupdeletehours&blockcontracthoursid\" data-rel=\"popup\" data-position-to=\"window\" data-transition=\"pop\" class=\"ui-btn ui-shadow ui-corner-all\">";
echo "<img src=../repair/images/del.png style=\"width:20px;\" align=absmiddle> ".pcrtlang("Delete")."</a>";
echo "<div data-role=\"popup\" id=\"popupdeletehours&blockcontracthoursid\" data-overlay-theme=\"b\"  data-theme=\"a\" data-dismissible=\"false\">";
echo "<div data-role=\"header\" data-theme=\"b\">";
echo "<h1>".pcrtlang("Delete")."?</h1>";
echo "</div>";
echo "<div role=\"main\" class=\"ui-content\">";
echo "<p>".pcrtlang("Are you sure you wish to permanently delete this?")."</p>";
echo "<div align=\"right\"><a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\" data-inline=\"true\">";
echo "<i class=\"fa fa-ban fa-lg\"></i>  ".pcrtlang("Cancel")."</a>";
echo "<button onClick=\"parent.location='blockcontract.php?func=deletehoursinvoice&pcgroupid=$pcgroupid&blockcontracthoursid=$blockcontracthoursid'\" data-inline=\"true\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")." </button></div>";
echo "</div>";
echo "</div>";
echo "</tr></td>";


}

echo "<tr><td colspan=3 style=\"border-left: #98D25F 10px solid;\">$thedateonly</td></tr>";
echo "<tr><td colspan=3 style=\"border-left: #98D25F 10px solid;\"><button type=button onClick=\"parent.location='../store/invoice.php?func=printinv&invoice_id=$invoiceid'\">".pcrtlang("Invoice")." #$invoiceid</button>";

if($invstatus != 2) {
echo " (".pcrtlang("Unpaid").")";
}

echo "</td></tr>";

$rs_checkrinvoice = "SELECT * FROM rinvoices WHERE blockcontractid = '$blockid'";
$rs_result_rci = mysqli_query($rs_connect, $rs_checkrinvoice);

if (mysqli_num_rows($rs_result_rci) == "1") {
$rs_result_qrci = mysqli_fetch_object($rs_result_rci);
$rinvoice_id = "$rs_result_qrci->rinvoice_id";
echo "<tr><td colspan=3 style=\"border-left: #98D25F 10px solid;\"><button type=button onClick=\"parent.location='../store/rinvoice.php?func=viewrinvoice&rinvoice_id=$rinvoice_id'\">".pcrtlang("Recurring Invoice")." #$rinvoice_id</button></td></tr>";
}



echo "<tr><td style=\"border-left: #98D25F 10px solid; border-bottom: #333333 1px solid;\">".pcrtlang("Actual")."<br>+".mf("$blockhours")."</td>";

if($invstatus != 2) {
echo "<td style=\"border-bottom: #333333 1px solid;\">".pcrtlang("Applied")."<br>+".mf("0")."</td>";
} else {
echo "<td style=\"border-bottom: #333333 1px solid;\"\">".pcrtlang("Applied")."<br>+".mf("$blockhours")."</td>";
}

echo "<td style=\"border-bottom: #333333 1px solid;\"\">".pcrtlang("Balance")."<br>$timebalance</td></tr>";


}


}


echo "<tr><th colspan=3 style=\"border-left: #333333 10px solid; text-align:right;\">".pcrtlang("Remaining Time").": $timebalance</th></tr>";

$rs_update_h = "UPDATE blockcontract SET hourscache = '$timebalance' WHERE blockid = '$blockid'";
@mysqli_query($rs_connect, $rs_update_h);


echo "</table>";



echo "<br>";

}



echo "</div>";
#start of service contracts
echo "<div id=\"servicecontracts\" class=\"ui-body-d ui-content\" style=\"padding:0px;\">";





echo "<h3>".pcrtlang("Managed Service Contracts")."</h3>";

echo "<br><button type=button onClick=\"parent.location='msp.php?func=newservicecontract&personname=$ue_pcgroupname&pcgroupid=$pcgroupid'\"><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Create Service Contract")."</button><br><br>";



$rs_sc = "SELECT * FROM servicecontracts WHERE groupid = '$pcgroupid' ORDER BY scexpdate DESC";
$rs_find_sc = @mysqli_query($rs_connect, $rs_sc);
while($rs_find_sc_q = mysqli_fetch_object($rs_find_sc)) {
$scid = "$rs_find_sc_q->scid";
$scstartdate = "$rs_find_sc_q->scstartdate";
$scexpdate = "$rs_find_sc_q->scexpdate";
$scname = "$rs_find_sc_q->scname";
$sccontactperson = "$rs_find_sc_q->sccontactperson";
$scdesc = "$rs_find_sc_q->scdesc";
$scactive = "$rs_find_sc_q->scactive";
$rinvoice = "$rs_find_sc_q->rinvoice";

if ($scactive == 1) {
$thestatus = "<font class=text12>Active</font>";
} else {
$thestatus = "<font class=textred12>Inactive</font>";
}

echo "<table class=standard>";

echo "<tr><th>$scname";

if($rinvoice != 0) {
if(overduerinvoice($rinvoice) == 1) {
echo "<br><font style=\"red\"><i class=\"fa fa-warning fa-lg\"></i> Service Contract has Overdue Invoices!</font>";
}
}

echo "</th></tr>";


echo "<tr><td>".pcrtlang("Contact Person").": $sccontactperson</font></td></tr>";
$returnurl = urlencode("../repair/group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=servicecontracts");

echo "<tr><td>".pcrtlang("Start Date").": $scstartdate</td></tr><tr><td>".pcrtlang("Expiration Date").": $scexpdate</td></tr>";

echo "<tr><td>".pcrtlang("Status").": $thestatus</td></tr>";

echo "<tr><td><button type=button onClick=\"parent.location='msp.php?func=viewservicecontract&scid=$scid&returnurl=$returnurl'\">".pcrtlang("View")."</button>";

if($scactive == 1) {
echo "<button type=button onClick=\"parent.location='msp.php?func=scactive&scid=$scid&rinvoice=$rinvoice&groupid=$pcgroupid&scactive=0'\">".pcrtlang("Deactivate")."</button>";
} else {
echo "<button type=button onClick=\"parent.location='msp.php?func=scactive&scid=$scid&rinvoice=$rinvoice&groupid=$pcgroupid&scactive=1'\">".pcrtlang("Activate")."</button>";
}


echo "</td></tr>";
echo "</table><br>";

}


echo "</div>";


echo "<div id=\"savedcards\" class=\"ui-body-d ui-content\" style=\"padding:2px;\">";

echo "<h3>".pcrtlang("Saved Cards")."</h3>";

if(isset($storedpaymentplugins)) {

foreach($storedpaymentplugins as $key => $val) {

echo "<h4>$val</h4>";

?>

<script type="text/javascript">
  $.get('../storemobile/<?php echo "$val"; ?>_stored.php?func=view&groupid=<?php echo "$pcgroupid"; ?>', function(data) {
    $('#plugin<?php echo "$key"; ?>').html(data).enhanceWithin('create');
  });
</script>
<div id="plugin<?php echo "$key"; ?>"></div>

<?php

echo "<br>";


}
} else {
echo pcrtlang("No stored cards defined...");
}






echo "</div>";


echo "<div id=\"credentials\" class=\"ui-body-d ui-content\" style=\"padding:2px;\">";

if(perm_check("34")) {

echo "<br><table class=standard><tr><th colspan=2>";


echo "<i class=\"fa fa-key fa-lg fa-fw\"></i> ".pcrtlang("Credentials")."";

echo "<fieldset data-role=\"controlgroup\" data-type=\"horizontal\">";
echo "<a href=\"javascript:void(0);\" class=\"ui-btn ui-shadow\"  data-ajax=\"false\" id=pass1change>
<i class=\"fa fa-lock\"></i></a> ";

echo "<a href=\"javascript:void(0);\" class=\"ui-btn ui-shadow\"  data-ajax=\"false\" id=pass2change>
<i class=\"fa fa-thumb-tack\"></i></a> ";

echo "<a href=\"javascript:void(0);\" class=\"ui-btn ui-shadow\"  data-ajax=\"false\" id=pass3change>
<i class=\"fa fa-th\"></i></a>";

echo "<a href=\"javascript:void(0);\" class=\"ui-btn ui-shadow\"  data-ajax=\"false\" id=pass5change>
<i class=\"fa fa-question-circle\"></i></a>";
echo "</fieldset>";

echo "</th>";
echo "</tr><tr><td colspan=2>";
echo "<div id=pass1box style=\"display:none;border:2px #cccccc solid;padding:5px;border-radius:3px;\">";
echo "<form action=pc.php?func=newpass method=post data-ajax=\"false\"><input type=hidden name=groupid value=$pcgroupid><input type=hidden name=credtype value=1>
<input type=hidden name=returnto value=group>";

$rs_cd = "SELECT * FROM creddesc ORDER BY creddescorder DESC";
$rs_resultcd1 = mysqli_query($rs_connect, $rs_cd);
$creddescoptions = "<option value=\"\">".pcrtlang("pick one or write your own below")."</option>";
while($rs_result_cdq1 = mysqli_fetch_object($rs_resultcd1)) {
$credtitle = "$rs_result_cdq1->credtitle";
$creddescoptions .= "<option value=\"$credtitle\">$credtitle</option>";
}

echo "<select name=creddesc onchange='document.getElementById(\"creddesc1box\").value=this.options[this.selectedIndex].value '>";
echo "$creddescoptions";
echo "</select>";
echo "<input type=text class=textbox id=creddesc1box name=creddesc placeholder=\"".pcrtlang("Description")."\">";
echo "<input type=text class=textbox name=username placeholder=\"".pcrtlang("Enter Username")."\"> ";
echo "<input type=text class=textbox name=password placeholder=\"".pcrtlang("Enter Password")."\">";
echo "<button type=submit data-theme=\"b\"><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button>";


echo "</form></div>";

echo "<div id=pass2box style=\"display:none;border:2px #cccccc solid;padding:5px;border-radius:3px;\">";
echo "<form action=pc.php?func=newpass method=post data-ajax=\"false\"><input type=hidden name=groupid value=$pcgroupid><input type=hidden name=credtype value=2>
<input type=hidden name=returnto value=group>";
echo "<select name=creddesc onchange='document.getElementById(\"creddesc2box\").value=this.options[this.selectedIndex].value '>";
echo "$creddescoptions";
echo "</select>";
echo "<input type=text class=textbox id=creddesc2box name=creddesc placeholder=\"".pcrtlang("Description")."\">";
echo "<input type=text class=textbox name=password placeholder=\"".pcrtlang("Enter Pin")."\"> ";
echo "<button type=submit data-theme=\"b\"><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button>";
echo "</form></div>";


echo "<div id=pass3box style=\"display:none;border:2px #cccccc solid;padding:5px;border-radius:3px;\">";
echo "<div id=patternmain></div>";
echo "<form action=pc.php?func=newpass method=post data-ajax=\"false\"><input type=hidden name=groupid value=$pcgroupid><input type=hidden name=credtype value=3>
<input type=hidden name=returnto value=group>";
echo "<select name=creddesc1 onchange='document.getElementById(\"creddesc3box\").value=this.options[this.selectedIndex].value '>";
echo "$creddescoptions";
echo "</select>";
echo "<input type=text class=textbox id=creddesc3box name=creddesc placeholder=\"".pcrtlang("Description")."\">";
echo "<input type=hidden class=textbox name=newpattern id=patterntextbox> ";
echo "<button type=submit data-theme=\"b\"><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button>";
echo "</form>";
echo "</div>";


echo "<div id=pass5box style=\"display:none;border:2px #cccccc solid;padding:5px;border-radius:3px;\">";
echo "<form action=pc.php?func=newpass method=post data-ajax=\"false\"><input type=hidden name=groupid value=$pcgroupid><input type=hidden name=credtype value=5>
<input type=hidden name=returnto value=group>";
echo "<select name=creddesc onchange='document.getElementById(\"creddesc5box\").value=this.options[this.selectedIndex].value '>";
echo "$creddescoptions";
echo "</select>";
echo "<input type=text class=textbox id=creddesc5box name=creddesc placeholder=\"".pcrtlang("Description")."\">";

echo "<input type=text class=textbox name=username placeholder=\"".pcrtlang("Enter Security Question")."\">";
echo "<input type=text class=textbox name=password placeholder=\"".pcrtlang("Enter Answer")."\">";
echo "<button type=submit data-theme=\"b\"><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button>";


echo "</form></div>";


?>
<link href="../repair/jq/patternLock.css"  rel="stylesheet" type="text/css">
<script src="../repair/jq/patternLock.js"></script>
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
<?php

require("patterns.php");



$rs_findcreds = "SELECT * FROM creds WHERE groupid = '$pcgroupid' ORDER BY creddate DESC";
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
$badgestyle = "passbadge2";

$creddate = pcrtdate("$pcrt_mediumdate", "$creddate2")." ".pcrtdate("$pcrt_time", "$creddate2");
if($credtype == 1) {
echo "<table class=\"$badgestyle\"><tr><td><i class=\"fa fa-lock fa-lg fa-fw\"></i></td>";
echo "<td><strong>$creddesc</strong><br><i class=\"fa fa-user\"></i> $creduser
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class=\"fa fa-key\"></i> $credpass";
echo "<br><span class=floatright>";

echo "<a href=\"pc.php?func=editcred&credid=$credid&credtype=$credtype&groupid=$pcgroupid&returnto=group\" class=\"ui-btn ui-shadow\"  data-ajax=\"false\">
<i class=\"fa fa-edit fa-lg\"></i></a>";
echo "<a href=\"pc.php?func=deletecred&credid=$credid&groupid=$pcgroupid&returnto=group\" class=\"ui-btn ui-shadow\"  data-ajax=\"false\"
onClick=\"return confirm('".pcrtlang("Are you sure you want to delete this credential?")."')\"><i class=\"fa fa-trash fa-lg\"></i></a>";
echo "</span></td></tr></table>";
}

if($credtype == 2) {
echo "<table class=\"$badgestyle\"><tr><td><i class=\"fa fa-thumb-tack fa-lg fa-fw\"></i></td>";
echo "<td><strong>$creddesc</strong><br><i class=\"fa fa-thumb-tack\"></i> $credpass";
echo "<br><span class=floatright>";

echo "<a href=\"pc.php?func=editcred&credid=$credid&credtype=$credtype&groupid=$pcgroupid&returnto=group\" class=\"ui-btn ui-shadow\"  data-ajax=\"false\">
<i class=\"fa fa-edit fa-lg\"></i></a>";
echo "<a href=\"pc.php?func=deletecred&credid=$credid&groupid=$pcgroupid&returnto=group\" class=\"ui-btn ui-shadow\"  data-ajax=\"false\"
onClick=\"return confirm('".pcrtlang("Are you sure you want to delete this PIN?")."')\"><i class=\"fa fa-trash fa-lg\"></i></a>";
echo "</span></td></tr></table>";
}
if($credtype == 3) {
echo "<table class=\"$badgestyle\"><tr><td><i class=\"fa fa-th fa-lg fa-fw\"></i></td>";
echo "<td><strong>$creddesc</strong><br>";
echo draw3x3("$patterndata","normal");
echo "<br><span class=floatright>";

echo "<a href=\"pc.php?func=deletecred&credid=$credid&groupid=$pcgroupid&returnto=group\" class=\"ui-btn ui-shadow\"  data-ajax=\"false\"
onClick=\"return confirm('".pcrtlang("Are you sure you want to delete this pattern?")."')\"><i class=\"fa fa-trash fa-lg\"></i></a>";
echo "</td></tr></table>";
}

if($credtype == 5) {
echo "<table class=\"$badgestyle\"><tr><td><i class=\"fa fa-question-circle fa-lg fa-fw\"></i></td>";
echo "<td><strong>$creddesc</strong><br><i class=\"fa fa-question\"></i> $creduser<br><i class=\"fa fa-commenting-o\">
</i> $credpass";
echo "<br><span class=floatright>";

echo "<a href=\"pc.php?func=editcred&credid=$credid&credtype=$credtype&groupid=$pcgroupid&returnto=group\" class=\"ui-btn ui-shadow\"  data-ajax=\"false\">
<i class=\"fa fa-edit fa-lg\"></i></a>";
echo "<a href=\"pc.php?func=deletecred&credid=$credid&groupid=$pcgroupid&returnto=group\" class=\"ui-btn ui-shadow\"  data-ajax=\"false\"
onClick=\"return confirm('".pcrtlang("Are you sure you want to delete this security question?")."')\"><i class=\"fa fa-trash fa-lg\"></i></a>";
echo "</span></td></tr></table>";
}



}


echo "</td></tr></table><br>";

#end perm
}

echo "</div>";
echo "</div>";

require("footer.php");
 
}                                                                                                                             
                                                                                                                                               


function addtogroup() {
require_once("dheader.php");
require("deps.php");

$woid = $_REQUEST['woid'];
$pcid = $_REQUEST['pcid'];
$pcname = $_REQUEST['pcname'];


dheader(pcrtlang("Add to Group"));

echo "#$pcid $pcname<br>";
echo "<br>";

echo "<form action=group.php?func=addtogroup2 method=post data-ajax=\"false\">";
echo "<strong>".pcrtlang("Enter Group Number").":</strong><input type=text name=pcgroupid required=required onFocus=\"this.form.submitbutton.disabled=false;this.form.submitbutton.value='".pcrtlang("Add to Group")."';\">";
echo "<input type=hidden name=woid value=$woid><input type=hidden name=pcid value=$pcid>";
echo "<input id=submitbutton type=submit value=\"".pcrtlang("Add to Group")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Adding to Group")."...'; this.form.submit();\"></form>";


echo "<br><br>";

echo "<strong>".pcrtlang("Or Search for Group")."</strong><br>";

echo "<form action=group.php?func=searchaddtogroup method=post data-ajax=\"false\">";
echo pcrtlang("Enter Part of Group Name").":<input type=text name=pcgroupsearch required=required>";
echo "<input type=hidden name=woid value=$woid><input type=hidden name=pcid value=$pcid><input type=hidden name=pcname value=\"$pcname\">";
echo "<input type=submit value=\"".pcrtlang("Search for Group")."\"></form>";


dfooter();

require_once("dfooter.php");

}


function addtogroup2() {
require_once("validate.php");
require("deps.php");
require("common.php");


$woid = $_REQUEST['woid'];
$pcid = $_REQUEST['pcid'];
$pcgroupid = $_REQUEST['pcgroupid'];

if ($pcgroupid == "") { die("Please go back and enter the group id number"); }






$rs_chk_group = "SELECT * FROM pc_group WHERE pcgroupid = '$pcgroupid'";
$checkforgroup = @mysqli_query($rs_connect, $rs_chk_group);

if (mysqli_num_rows($checkforgroup) == "0") {

die("Sorry, but that group ID soesn't exist");

} else {
$rs_set_group = "UPDATE pc_owner SET pcgroupid = '$pcgroupid' WHERE pcid = '$pcid'";
@mysqli_query($rs_connect, $rs_set_group);

header("Location: index.php?pcwo=$woid");

}
}



function searchaddtogroup() {

$woid = $_REQUEST['woid'];
$pcid = $_REQUEST['pcid'];
$pcgroupsearch = $_REQUEST['pcgroupsearch'];
$pcname = $_REQUEST['pcname'];
require("deps.php");
require("dheader.php");

dheader(pcrtlang("Add to Group"));

echo pcrtlang("Search Again");

echo "<form action=group.php?func=searchaddtogroup method=post  data-ajax=\"false\">";
echo pcrtlang("Enter Part of Group Name").":<input type=text name=pcgroupsearch value=\"$pcgroupsearch\" required=required>";
echo "<input type=hidden name=woid value=$woid><input type=hidden name=pcid value=$pcid><input type=hidden name=pcname value=\"$pcname\">";
echo "<input type=submit value=\"".pcrtlang("Search for Group")."\"></form>";


echo "<br>";
echo pcrtlang("Group Search Results for").": $pcgroupsearch<br><br> ";
echo "<br>";




$rs_findpc = "SELECT * FROM pc_group WHERE pcgroupname LIKE '%$pcgroupsearch%' OR grpcompany LIKE '%$pcgroupsearch%'";
$rs_result = mysqli_query($rs_connect, $rs_findpc);
while ($rs_result_q = mysqli_fetch_object($rs_result)) {
$pcgroupname = "$rs_result_q->pcgroupname";
$grpcompany = "$rs_result_q->grpcompany";
$pcgroupid = "$rs_result_q->pcgroupid";

echo "<table class=standard><tr><th>";
if("$grpcompany" == "") {
echo pcrtlang("Group").": #$pcgroupid $pcgroupname</th></tr><tr><td>".pcrtlang("Assets/Devices/Customers in this Group").":<br>";
} else {
echo pcrtlang("Group").": #$pcgroupid $pcgroupname &bull; $grpcompany</th></tr><tr><td>".pcrtlang("Assets/Devices/Customers in this Group").":<br>";
}


$rs_findowner = "SELECT * FROM pc_owner WHERE pcgroupid = '$pcgroupid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
while($rs_result_q2 = mysqli_fetch_object($rs_result2)) {
$pcid2 = "$rs_result_q2->pcid";
$pcname2 = "$rs_result_q2->pcname";
$pccompany2 = "$rs_result_q2->pccompany";
$pcmake2 = "$rs_result_q2->pcmake";

if("$pccompany2" == "") {
echo "#$pcid2 | $pcname2 | $pcmake2<br>";
} else {
echo "#$pcid2 | $pcname2 | $pccompany2 | $pcmake2<br>";
}
}

echo "<br><button type=button onClick=\"parent.location='group.php?func=addtogroup2&pcgroupid=$pcgroupid&pcid=$pcid&woid=$woid'\">".pcrtlang("Add to this Group")."</button><br><br>";

echo "</td></tr></table>";

echo "<br>";
}

dfooter();
require("dfooter.php");

}



function removefromgroup() {
require_once("validate.php");
require("deps.php");
require("common.php");

if (isset($_REQUEST['woid'])) {
$woid = $_REQUEST['woid'];
} else {
$woid = "";
}

if (isset($_REQUEST['pcid'])) {
$pcid = $_REQUEST['pcid'];
} else {
$pcid = "";
}

if (isset($_REQUEST['pcgroupid'])) {
$pcgroupid = $_REQUEST['pcgroupid'];
} else {
$pcgroupid = "";
}



if ($pcid == "") { die("Error"); }






$rs_set_group = "UPDATE pc_owner SET pcgroupid = '0' WHERE pcid = '$pcid'";
@mysqli_query($rs_connect, $rs_set_group);

if ($woid != "") {
header("Location: index.php?pcwo=$woid");
} else {
header("Location: group.php?func=viewgroup&pcgroupid=$pcgroupid");
}

}




function searchpcaddtogroup() {
require_once("dheader.php");
require("deps.php");

$searchterm = $_REQUEST['searchterm'];
$pcgroupid = $_REQUEST['pcgroupid'];

$rs_findpc = "SELECT * FROM pc_group WHERE pcgroupid = '$pcgroupid'";
$rs_result = mysqli_query($rs_connect, $rs_findpc);
$rs_result_q = mysqli_fetch_object($rs_result);
$pcgroupname = "$rs_result_q->pcgroupname";

$rs_findowner = "SELECT * FROM pc_owner WHERE pcname LIKE '%$searchterm%' AND pcgroupid != '$pcgroupid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);

dheader(pcrtlang("Add to Group"));

if(mysqli_num_rows($rs_result2) != "0") {

echo "<form action=group.php?func=searchpcaddtogroup2 method=post  data-ajax=\"false\">";

while($rs_result_q2 = mysqli_fetch_object($rs_result2)) {
$pcid2 = "$rs_result_q2->pcid";
$pcname2 = "$rs_result_q2->pcname";
$pccompany2 = "$rs_result_q2->pccompany";
$pcmake2 = "$rs_result_q2->pcmake";

echo "<label><input type=checkbox name=pcids[] value=$pcid2> #$pcid2 $pcname2 ";
if ("$pccompany2" != "") {
echo "<br>$pccompany2";
}
echo "<br>$pcmake2</label>";
}

echo "<input type=hidden name=pcgroupid value=$pcgroupid><br><input type=submit value=\"".pcrtlang("Add to Group")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Adding to Group")."...'; this.form.submit();\"></form>";


} else {


echo pcrtlang("Sorry, no search results found.")."<br><br><a href=group.php?func=viewgroup&pcgroupid=$pcgroupid>".pcrtlang("Go Back")."</a>";


}

dfooter();

require_once("footer.php");
}


function searchpcaddtogroup2() {
require_once("validate.php");
require("deps.php");
require("common.php");


$pcids = $_REQUEST['pcids'];
$pcgroupid = $_REQUEST['pcgroupid'];






foreach($pcids as $key => $val) {
$rs_set_group = "UPDATE pc_owner SET pcgroupid = '$pcgroupid' WHERE pcid = '$val'";
@mysqli_query($rs_connect, $rs_set_group);

}

header("Location: group.php?func=viewgroup&pcgroupid=$pcgroupid");

}



function synctoallpc() {
require_once("validate.php");
require("deps.php");
require("common.php");

$pcgroupid = $_REQUEST['pcgroupid'];





$rs_findowner = "SELECT * FROM pc_group WHERE pcgroupid = '$pcgroupid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
$rs_result_q2 = mysqli_fetch_object($rs_result2);
$grpcompany = pv("$rs_result_q2->grpcompany");
$grpphone = pv("$rs_result_q2->grpphone");
$grpemail = pv("$rs_result_q2->grpemail");
$grpaddress1 = pv("$rs_result_q2->grpaddress1");
$grpcellphone = pv("$rs_result_q2->grpcellphone");
$grpworkphone = pv("$rs_result_q2->grpworkphone");
$grpaddress2 = pv("$rs_result_q2->grpaddress2");
$grpcity = pv("$rs_result_q2->grpcity");
$grpstate = pv("$rs_result_q2->grpstate");
$grpzip = pv("$rs_result_q2->grpzip");
$grpprefcontact = pv("$rs_result_q2->grpprefcontact");

$rs_sync_pc = "UPDATE pc_owner SET pcphone = '$grpphone', pccellphone = '$grpcellphone', pcworkphone = '$grpworkphone', pcemail = '$grpemail', pcaddress = '$grpaddress1', pcaddress2 = '$grpaddress2', pccity = '$grpcity', pcstate = '$grpstate', pczip = '$grpzip', prefcontact = '$grpprefcontact', pccompany = '$grpcompany' WHERE pcgroupid = '$pcgroupid'";
@mysqli_query($rs_connect, $rs_sync_pc);

header("Location: group.php?func=viewgroup&pcgroupid=$pcgroupid");

}

function syncpctogroup() {
require_once("validate.php");
require("deps.php");
require("common.php");

$pcgroupid = $_REQUEST['pcgroupid'];
$pcid = $_REQUEST['pcid'];





$rs_findowner = "SELECT * FROM pc_owner WHERE pcid = '$pcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
$rs_result_q2 = mysqli_fetch_object($rs_result2);
$pccompany = pv("$rs_result_q2->pccompany");
$pcphone = pv("$rs_result_q2->pcphone");
$pcemail = pv("$rs_result_q2->pcemail");
$pcaddress = pv("$rs_result_q2->pcaddress");
$pccellphone = pv("$rs_result_q2->pccellphone");
$pcworkphone = pv("$rs_result_q2->pcworkphone");
$pcaddress2 = pv("$rs_result_q2->pcaddress2");
$pccity = pv("$rs_result_q2->pccity");
$pcstate = pv("$rs_result_q2->pcstate");
$pczip = pv("$rs_result_q2->pczip");
$prefcontact = pv("$rs_result_q2->prefcontact");

$rs_sync_pc = "UPDATE pc_group SET grpphone = '$pcphone', grpcellphone = '$pccellphone', grpworkphone = '$pcworkphone', grpemail = '$pcemail', grpaddress1 = '$pcaddress', grpaddress2 = '$pcaddress2', grpcity = '$pccity', grpstate = '$pcstate', grpzip = '$pczip', grpprefcontact = '$prefcontact', grpcompany = '$pccompany' WHERE pcgroupid = '$pcgroupid'";
@mysqli_query($rs_connect, $rs_sync_pc);

header("Location: group.php?func=viewgroup&pcgroupid=$pcgroupid");

}


function syncpcfromgroup() {
require_once("validate.php");
require("deps.php");
require("common.php");

$pcgroupid = $_REQUEST['pcgroupid'];
$pcid = $_REQUEST['pcid'];





$rs_findowner = "SELECT * FROM pc_group WHERE pcgroupid = '$pcgroupid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
$rs_result_q2 = mysqli_fetch_object($rs_result2);
$grpcompany = pv("$rs_result_q2->grpcompany");
$grpphone = pv("$rs_result_q2->grpphone");
$grpemail = pv("$rs_result_q2->grpemail");
$grpaddress1 = pv("$rs_result_q2->grpaddress1");
$grpcellphone = pv("$rs_result_q2->grpcellphone");
$grpworkphone = pv("$rs_result_q2->grpworkphone");
$grpaddress2 = pv("$rs_result_q2->grpaddress2");
$grpcity = pv("$rs_result_q2->grpcity");
$grpstate = pv("$rs_result_q2->grpstate");
$grpzip = pv("$rs_result_q2->grpzip");
$grpprefcontact = pv("$rs_result_q2->grpprefcontact");

$rs_sync_pc = "UPDATE pc_owner SET pcphone = '$grpphone', pccellphone = '$grpcellphone', pcworkphone = '$grpworkphone', pcemail = '$grpemail', pcaddress = '$grpaddress1', pcaddress2 = '$grpaddress2', pccity = '$grpcity', pcstate = '$grpstate', pczip = '$grpzip', prefcontact = '$grpprefcontact', pccompany = '$grpcompany' WHERE pcid = '$pcid'";
@mysqli_query($rs_connect, $rs_sync_pc);

header("Location: group.php?func=viewgroup&pcgroupid=$pcgroupid");

}



function editgroup() {
require_once("common.php");
require("deps.php");

require("dheader.php");


$pcgroupid = $_REQUEST['pcgroupid'];


dheader(pcrtlang("Edit Group"));






$rs_find_pc = "SELECT * FROM pc_group WHERE pcgroupid = '$pcgroupid'";
$rs_result_item = mysqli_query($rs_connect, $rs_find_pc);

while($rs_result_item_q = mysqli_fetch_object($rs_result_item)) {
$pcname = "$rs_result_item_q->pcgroupname";
$pccompany = "$rs_result_item_q->grpcompany";
$pcphone = "$rs_result_item_q->grpphone";
$pccellphone = "$rs_result_item_q->grpcellphone";
$pcworkphone = "$rs_result_item_q->grpworkphone";
$pcemail = "$rs_result_item_q->grpemail";
$pcaddress = "$rs_result_item_q->grpaddress1";
$pcaddress2 = "$rs_result_item_q->grpaddress2";
$pccity = "$rs_result_item_q->grpcity";
$pcstate = "$rs_result_item_q->grpstate";
$pczip = "$rs_result_item_q->grpzip";
$grpnotes = "$rs_result_item_q->grpnotes";

$custsourceidindb = "$rs_result_item_q->grpcustsourceid";
$prefcontact = "$rs_result_item_q->grpprefcontact";


echo "<form action=group.php?func=editgroup2 method=post data-ajax=\"false\">";
echo pcrtlang("Customer Name").":<input type=text value=\"$pcname\" name=pcgroupname required=required>";
echo pcrtlang("Company").":<input type=text value=\"$pccompany\" name=grpcompany>";
echo pcrtlang("Customer Phone").":<input type=text value=\"$pcphone\" name=grpphone>";
echo pcrtlang("Customer Mobile Phone").":<input type=text value=\"$pccellphone\" name=grpcellphone>";
echo pcrtlang("Customer Work Phone").":<input type=text value=\"$pcworkphone\" name=grpworkphone>";


echo pcrtlang("Preferred Contact Method").":";

echo "<fieldset data-role=\"controlgroup\">";

if(($prefcontact == "none") || ($prefcontact == "")) {
echo "<input checked type=radio id=none name=grpprefcontact value=\"none\"><label for=none>".pcrtlang("none")."</label>";
} else {
echo "<input type=radio id=none name=grpprefcontact value=\"none\"><label for=home>".pcrtlang("none")."</label>";
}

if($prefcontact == "home") {
echo "<input checked type=radio id=home name=grpprefcontact value=\"home\"><label for=home>".pcrtlang("Home Phone")."</label>";
} else {
echo "<input type=radio id=home name=grpprefcontact value=\"home\"><label for=home>".pcrtlang("Home Phone")."</label>";
}

if($prefcontact == "mobile") {
echo "<input checked type=radio id=mobile name=grpprefcontact value=\"mobile\"><label for=mobile>".pcrtlang("Mobile Phone")."</label>";
} else {
echo "<input type=radio id=mobile name=grpprefcontact value=\"mobile\"><label for=mobile>".pcrtlang("Mobile Phone")."</label>";
}

if($prefcontact == "work") {
echo "<input checked type=radio id=work name=grpprefcontact value=\"work\"><label for=work>".pcrtlang("Work Phone")."</label>";
} else {
echo "<input type=radio id=work name=grpprefcontact value=\"work\"><label for=work>".pcrtlang("Work Phone")."</label>";
}

if($prefcontact == "sms") {
echo "<input checked type=radio id=sms name=grpprefcontact value=\"sms\"><label for=sms>".pcrtlang("SMS")."</label>";
} else {
echo "<input type=radio id=sms name=grpprefcontact value=\"sms\"><label for=sms>".pcrtlang("SMS")."</label>";
}

if($prefcontact == "email") {
echo "<input checked type=radio id=email name=grpprefcontact value=\"email\"><label for=sms>".pcrtlang("Email")."</label>";
} else {
echo "<input type=radio id=email name=grpprefcontact value=\"email\"><label for=email>".pcrtlang("Email")."</label>";
}


echo "</fieldset>";

echo "<input type=hidden name=pcgroupid value=$pcgroupid>";

echo pcrtlang("Customer Source").":";

echo "<select name=grpcustsourceid>";

if ($custsourceidindb == "0") {
echo "<option value=0 selected>".pcrtlang("Not Set")."</option>";
} else {
echo "<option value=0>".pcrtlang("Not Set")."</option>";
}

$rs_findsource = "SELECT * FROM custsource WHERE sourceenabled != '0' ORDER BY thesource ASC";
$rs_resultcs = mysqli_query($rs_connect, $rs_findsource);
while($rs_result_qcs = mysqli_fetch_object($rs_resultcs)) {
$custsourceid = "$rs_result_qcs->custsourceid";
$thesource = "$rs_result_qcs->thesource";
$sourceicon = "$rs_result_qcs->sourceicon";
if ($custsourceidindb == "$custsourceid") {
echo "<option value=$custsourceid selected>$thesource</option>";
} else {
echo "<option value=$custsourceid>$thesource</option>";
}

}
echo "</select>";



echo pcrtlang("Email Address").":<input type=text name=grpemail value=\"$pcemail\">";

echo "$pcrt_address1<input type=text name=grpaddress1 value=\"$pcaddress\">";
echo "$pcrt_address2<input type=text name=grpaddress2 value=\"$pcaddress2\">";
echo "$pcrt_city<input type=text name=grpcity value=\"$pccity\">$pcrt_state<input type=text name=grpstate value=\"$pcstate\">$pcrt_zip<input type=text name=grpzip value=\"$pczip\">";

echo pcrtlang("Notes").":<textarea name=grpnotes>$grpnotes</textarea>";


echo "<input type=submit value=\"".pcrtlang("Save")."\"  data-theme=\"b\"></form>";

}
dfooter();
require_once("dfooter.php");


}


function editgroup2() {
require_once("validate.php");
require("deps.php");
require("common.php");

$pcgroupname = pv($_REQUEST['pcgroupname']);
$grpcompany = pv($_REQUEST['grpcompany']);
$grpphone = pv($_REQUEST['grpphone']);
$grpcellphone = pv($_REQUEST['grpcellphone']);
$grpworkphone = pv($_REQUEST['grpworkphone']);
$pcgroupid = $_REQUEST['pcgroupid'];

$grpemail = pv($_REQUEST['grpemail']);
$grpaddress1 = pv($_REQUEST['grpaddress1']);
$grpaddress2 = pv($_REQUEST['grpaddress2']);
$grpcity = pv($_REQUEST['grpcity']);
$grpstate = pv($_REQUEST['grpstate']);
$grpzip = pv($_REQUEST['grpzip']);
$grpnotes = pv($_REQUEST['grpnotes']);

$grpcustsourceid = $_REQUEST['grpcustsourceid'];
$grpprefcontact = $_REQUEST['grpprefcontact'];


if ($pcgroupname == "") { die("Please go back and enter the customers name"); }





$rs_insert_pc = "UPDATE pc_group SET pcgroupname = '$pcgroupname', grpcompany = '$grpcompany', grpphone = '$grpphone', grpcellphone = '$grpcellphone', grpworkphone = '$grpworkphone', grpemail = '$grpemail', grpaddress1 = '$grpaddress1', grpaddress2 = '$grpaddress2', grpcity = '$grpcity', grpstate = '$grpstate', grpzip = '$grpzip', grpcustsourceid = '$grpcustsourceid', grpprefcontact = '$grpprefcontact', grpnotes = '$grpnotes' WHERE pcgroupid = '$pcgroupid'";
@mysqli_query($rs_connect, $rs_insert_pc);

header("Location: group.php?func=viewgroup&pcgroupid=$pcgroupid");


}



function browsegroups() {

if (array_key_exists("pageNumber", $_REQUEST)) {
$pageNumber = $_REQUEST['pageNumber'];
} else {
$pageNumber = 1;
}

if (array_key_exists("sortby", $_REQUEST)) {
$sortby = $_REQUEST['sortby'];
} else {
$sortby = "name_asc";
}


require_once("header.php");


$results_per_page = 20;

if ($pageNumber == "") {
$offset = "0";
} else {
$offset = ($pageNumber * $results_per_page) - $results_per_page;
}



require("deps.php");
require_once("common.php");





if ("$sortby" == "id_asc") {
$rs_find_cart_items = "SELECT * FROM pc_group ORDER BY pcgroupid ASC LIMIT $offset,$results_per_page";
} elseif ("$sortby" == "id_desc") {
$rs_find_cart_items = "SELECT * FROM pc_group ORDER BY pcgroupid DESC LIMIT $offset,$results_per_page";
} elseif ("$sortby" == "name_desc") {
$rs_find_cart_items = "SELECT * FROM pc_group ORDER BY pcgroupname DESC LIMIT $offset,$results_per_page";
} elseif ("$sortby" == "name_asc") {
$rs_find_cart_items = "SELECT * FROM pc_group ORDER BY pcgroupname ASC LIMIT $offset,$results_per_page";
} elseif ("$sortby" == "company_desc") {
$rs_find_cart_items = "SELECT * FROM pc_group ORDER BY grpcompany DESC LIMIT $offset,$results_per_page";
} else {
$rs_find_cart_items = "SELECT * FROM pc_group ORDER BY grpcompany ASC LIMIT $offset,$results_per_page";
}

$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

$rs_find_cart_items_total = "SELECT * FROM pc_group";
$rs_result_total = mysqli_query($rs_connect, $rs_find_cart_items_total);



echo "<h3>".pcrtlang("Browse Customer Groups")."</h3>";

echo "<button type=button onClick=\"parent.location='group.php?func=addtogroupnew'\">".pcrtlang("Create New Group")."</button><br><br>";

echo "<div data-role=\"collapsible\">";
echo "<h3>".pcrtlang("Sort By").":</h3>";

echo "<button type=button onClick=\"parent.location='group.php?func=browsegroups&pageNumber=$pageNumber&sortby=id_asc'\"><i class=\"fa fa-sort-numeric-asc fa-lg\"></i> ".pcrtlang("By ID Ascending")."</button>";
echo "<button type=button onClick=\"parent.location='group.php?func=browsegroups&pageNumber=$pageNumber&sortby=id_desc'\"><i class=\"fa fa-sort-numeric-desc fa-lg\"></i> ".pcrtlang("By ID Descending")."</button>";
echo "<button type=button onClick=\"parent.location='group.php?func=browsegroups&pageNumber=$pageNumber&sortby=name_asc'\"><i class=\"fa fa-sort-alpha-asc fa-lg\"></i> ".pcrtlang("By Name Ascending")."</button>";
echo "<button type=button onClick=\"parent.location='group.php?func=browsegroups&pageNumber=$pageNumber&sortby=name_desc'\"><i class=\"fa fa-sort-alpha-desc fa-lg\"></i> ".pcrtlang("By Name Descending")."</button>";
echo "<button type=button onClick=\"parent.location='group.php?func=browsegroups&pageNumber=$pageNumber&sortby=company_asc'\"><i class=\"fa fa-sort-alpha-asc fa-lg\"></i> ".pcrtlang("By Company Ascending")."</button>";
echo "<button type=button onClick=\"parent.location='group.php?func=browsegroups&pageNumber=$pageNumber&sortby=company_desc'\"><i class=\"fa fa-sort-alpha-desc fa-lg\"></i> ".pcrtlang("By Company Descending")."</button>";

echo "</div>";

while($rs_result_q = mysqli_fetch_object($rs_result)) {
$pcgroupid = "$rs_result_q->pcgroupid";
$rs_pcname = "$rs_result_q->pcgroupname";
$rs_pccompany = "$rs_result_q->grpcompany";
$rs_pcphone = "$rs_result_q->grpphone";
$rs_pcemail = "$rs_result_q->grpemail";
$rs_pcaddress = "$rs_result_q->grpaddress1";
$rs_pcaddress2 = "$rs_result_q->grpaddress2";
$rs_pccity = "$rs_result_q->grpcity";
$rs_pcstate = "$rs_result_q->grpstate";
$rs_pczip = "$rs_result_q->grpzip";

echo "<table class=standard><tr><th><button type=button onClick=\"parent.location='group.php?func=viewgroup&pcgroupid=$pcgroupid'\">#$pcgroupid $rs_pcname</button></th></tr>";

if ($rs_pccompany != "") {
echo "<tr><td>$rs_pccompany</td></tr>";
}

echo "<tr><td>$rs_pcphone</td></tr>";

if ($rs_pcemail != "") {
echo "<tr><td>$rs_pcemail</td></tr>";
}

echo "<tr><td>$rs_pcaddress<br>";

if ($rs_pcaddress2 != "") {
echo "$rs_pcaddress2<br>";
}

if ($rs_pccity != "") {
echo "$rs_pccity,";
}

echo "$rs_pcstate $rs_pczip</td></tr>";


echo "</table><br>";

}


echo "<br>";

#browse here
$totalentry = mysqli_num_rows($rs_result_total);
$prevpage = $pageNumber - 1;
$nextpage = $pageNumber + 1;

echo "<center>";

if ($pageNumber > 1) {
echo "<button type=button onClick=\"parent.location='group.php?func=browsegroups&pageNumber=$prevpage&sortby=$sortby'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\">";
echo "<i class=\"fa fa-chevron-left fa-lg\"></i></button>";
}

$total_results = $totalentry;
$results_per_page = $results_per_page;
$html = get_paged_nav($total_results, $results_per_page, false);
echo "$html";

if (($totalentry / $results_per_page) > $pageNumber) {
echo "<button type=button onClick=\"parent.location='group.php?func=browsegroups&pageNumber=$nextpage&sortby=$sortby'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\">";
echo "<i class=\"fa fa-chevron-right fa-lg\"></i></button>";
}

echo "</center>";

require("footer.php");

}









function bcreport() {


$blockid = $_REQUEST['blockid'];
require_once("deps.php");

require_once("validate.php");

require_once("common.php");

?>
<!DOCTYPE html>

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php


echo "<title>".pcrtlang("Block Contract Report")." #$blockid</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../repair/style.css\">";
echo "</head><body>";

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


function array_sort_by_column(&$array, $column, $direction = SORT_ASC) {
    $reference_array = array();

    foreach($array as $key => $row) {
        $reference_array[$key] = $row[$column];
    }

    array_multisort($reference_array, $direction, $array);
}


$rs_bcs = "SELECT * FROM blockcontract WHERE blockid = '$blockid'";
$rs_find_bcs = @mysqli_query($rs_connect, $rs_bcs);

while($rs_find_bcs_q = mysqli_fetch_object($rs_find_bcs)) {
$blockid = "$rs_find_bcs_q->blockid";
$blocktitle = "$rs_find_bcs_q->blocktitle";
$blocknote = "$rs_find_bcs_q->blocknote";
$blockstart = "$rs_find_bcs_q->blockstart";
$contractclosed = "$rs_find_bcs_q->contractclosed";

$blocktitle_ue = urlencode("$blocktitle");

echo "<font class=text20b>$blocktitle</font><br>";

echo "<table>";
echo "<tr><td style=\"vertical-align:top\"><font class=text12b>".pcrtlang("Start Date").":</font></td><td style=\"vertical-align:top\"><font class=text12>$blockstart</font></td>";

echo "<td rowspan=2>";

$rs_checkrinvoice2 = "SELECT * FROM rinvoices WHERE blockcontractid = '$blockid'";
$rs_result_rci2 = mysqli_query($rs_connect, $rs_checkrinvoice2);


echo "</td>";

echo "</tr>";
echo "<tr><td style=\"vertical-align:top;\"><font class=text12b>".pcrtlang("Notes").":</font></td><td style=\"vertical-align:top\"><font class=text12>$blocknote</font></td></tr>";
echo "</table><br>";



#lines

$masterlist = array();
$timebalance = 0;

$rs_findblockhours = "SELECT * FROM blockcontracthours WHERE blockcontractid = '$blockid'";
$rs_result_bh = mysqli_query($rs_connect, $rs_findblockhours);
while($rs_result_qbh = mysqli_fetch_object($rs_result_bh)) {
$blockhours = "$rs_result_qbh->blockhours";
$blockcontracthoursid = "$rs_result_qbh->blockcontracthoursid";
$blockhoursdate = "$rs_result_qbh->blockhoursdate";
$invoiceid = "$rs_result_qbh->invoiceid";
$masterlist[] = array("linetype" => "blockhours", "blockhours" => "$blockhours", "thedate" => "$blockhoursdate 0000-00-00 00:00:00", "invoiceid" => "$invoiceid", "thedateonly" => "$blockhoursdate", "blockcontracthoursid" => "$blockcontracthoursid");
}


$rs_findtimers = "SELECT * FROM timers WHERE blockcontractid = '$blockid' AND timerstop != '0000-00-00 00:00:00'";
$rs_result_t = mysqli_query($rs_connect, $rs_findtimers);
while($rs_result_qt = mysqli_fetch_object($rs_result_t)) {
$timername = "$rs_result_qt->timerdesc";
$timerstart = "$rs_result_qt->timerstart";
$timerstop = "$rs_result_qt->timerstop";
$timertotal = "$rs_result_qt->timertotal";
$timerid = "$rs_result_qt->timerid";
$billedout = "$rs_result_qt->billedout";
$timerbyuser = "$rs_result_qt->byuser";
$woid = "$rs_result_qt->woid";
$savedround = "$rs_result_qt->savedround";


$timerstart_2822 = date('r', strtotime("$timerstart"));

$timerstartdate2 = date('n-j-Y', strtotime($timerstart));
$timerstarttime2 = date('g:ia', strtotime($timerstart));
$timerstoptime2 = date('g:ia', strtotime($timerstop));

$startepoch = strtotime($timerstart);
$stopepoch = time();
$startseconds = $stopepoch - $startepoch;

$masterlist[] = array("savedround" => "$savedround", "timerid" => "$timerid", "linetype" => "timer", "timername" => "$timername", "thedate" => "$timerstart", "timerstop" => "$timerstop", "timeruser" => "$timerbyuser", "woid" => "$woid");
}


array_sort_by_column($masterlist, 'thedate');

echo "<table style=\"width:95%\" class=blockcontract>";
echo "<tr><td></td><td></td><td style=\"text-align:right;\"><font class=text12>".pcrtlang("Actual")."</font></td><td style=\"text-align:right;\"><font class=text12>".pcrtlang("Billed")."</font></td><td style=\"text-align:right;\"><font class=text12>".pcrtlang("Balance")."</font></td></tr>";


$runningtime = 0;

foreach($masterlist as $key => $subarray) {

#timercode start
if($subarray['linetype'] == "timer") {

$timername = $subarray['timername']; 
$timerstart = $subarray['thedate'];
$timerstop = $subarray['timerstop'];
$timerid = $subarray['timerid'];
$timerbyuser = $subarray['timeruser'];
$woid = $subarray['woid'];
$savedround = $subarray['savedround'];

$timerstart_2822 = date('r', strtotime("$timerstart"));

$timerstartdate2 = date('Y-n-j', strtotime($timerstart));
$timerstarttime2 = date('g:ia', strtotime($timerstart));
$timerstoptime2 = date('g:ia', strtotime($timerstop));


$startepoch = strtotime($timerstart);
$stopepoch = time();
$startseconds = $stopepoch - $startepoch;


$startstamp = strtotime("$timerstart");
$stopstamp = strtotime("$timerstop");

$elapsedtime = $stopstamp - $startstamp;
$timeusedact =  mf($elapsedtime / 3600);


if($savedround == 15) {
$elapsedtime2 = ($elapsedtime - ($elapsedtime % 900)) + 900; 
$runningtime = $runningtime - $elapsedtime2;
} elseif($savedround == 30) {
$elapsedtime2 = ($elapsedtime - ($elapsedtime % 1800)) + 1800;
$runningtime = $runningtime - $elapsedtime2;
} elseif($savedround == 60) {
$elapsedtime2 = ($elapsedtime - ($elapsedtime % 3600)) + 3600;
$runningtime = $runningtime - $elapsedtime2;
} else {
$elapsedtime2 = $elapsedtime;
$runningtime = $runningtime - $elapsedtime2;
}

$timeused =  mf($elapsedtime2 / 3600);

$timebalance = mf($runningtime / 3600);

$elapsedhuman = time_elapsed($elapsedtime);



echo "<tr><td style=\"vertical-align:top; border-left: #FF4938 10px solid;\"><font class=text12b>$timername";



echo "</font></td>
<td><font class=text12b>$timerstartdate2</font><br><font class=textgreen12b>$timerstarttime2 </font><font class=text12b>-</font> <font class=textred12b>$timerstoptime2</font></font></td>";

echo "<td style=\"text-align:right;\"><font class=text12>$timeusedact</font></td><td style=\"text-align:right;\"><font class=text12b>-$timeused</font></td><td style=\"text-align:right;\"><font class=text12b>$timebalance</font></td></tr>";






} else {
#timercode stop
#line item start

$blockhours = $subarray['blockhours'];
$thedateonly = $subarray['thedateonly'];
$invoiceid = $subarray['invoiceid'];

$runningtime = $runningtime + (3600 * $blockhours);
$timebalance = mf($runningtime / 3600);

echo "<tr><td colspan=1 style=\"vertical-align:top; border-left: #98D25F 10px solid;\"><font class=text12b>".pcrtlang("Purchased Hours")."</font>";

echo " &bull; <font class=text12b>".pcrtlang("Invoice")." #$invoiceid</font>";


echo "</td><td><font class=textblue12b>$thedateonly</font></td>";
echo "<td colspan=1>";


echo "</td>";
echo "<td style=\"text-align:right;\"><font class=text12b>+".mf("$blockhours")."</font></td><td style=\"text-align:right;\"><font class=text12b>$timebalance</font></td></tr>";


}


}


echo "<tr><td colspan=11 style=\"text-align:right;\"><font class=text12b>".pcrtlang("Remaining Time").": $timebalance</font></td></tr>";

$rs_update_h = "UPDATE blockcontract SET hourscache = '$timebalance' WHERE blockid = '$blockid'";
@mysqli_query($rs_connect, $rs_update_h);


echo "</table>";


echo "<br>";

}

echo "</td></tr></table></body></html>";

}



##########################

function bcreportemail() {


$blockid = $_REQUEST['blockid'];
$pcgroupid = $_REQUEST['pcgroupid'];
$to = $_REQUEST['to'];

require_once("deps.php");

require_once("validate.php");

require_once("common.php");

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


function array_sort_by_column(&$array, $column, $direction = SORT_ASC) {
    $reference_array = array();

    foreach($array as $key => $row) {
        $reference_array[$key] = $row[$column];
    }

    array_multisort($reference_array, $direction, $array);
}




$storeinfoarray = getstoreinfo($defaultuserstore);
$subject = "$storeinfoarray[storename] - ".pcrtlang("Block of Time Contract Report");
$random_hash = md5(date('r', time()));
$headers = "From: $storeinfoarray[storeemail]\nReply-To: $storeinfoarray[storeemail]\nX-Mailer: PHP/".phpversion();
$headers .= "\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
$headers .= "\nMIME-Version: 1.0";

$message = "\n\n--PHP-alt-$random_hash\n";
$message .= "Content-Type: text/plain; charset=\"utf-8\"\n";
$message .= "Content-Transfer-Encoding: 7bit\n\n";

$message .= "Sorry, Your email client does not support html email.\n\n";
$peartext = "Sorry, Your email client does not support html email. Showing plain text instead\n\n";

$message .= "--PHP-alt-$random_hash\n";
$message .= "Content-Type: text/html; charset=\"utf-8\"\n";
$message .= "Content-Transfer-Encoding: 7bit\n\n";

$pearhtml ="";


$message .= "<html><head>";
$message .= "<style>\n";
$message .= file_get_contents("../repair/printstyle.css");
$message .= "\n</style></head>";
$message .= "<body><table style=\"width:100%\"><tr><td style=\"width:100%\">\n";

$pearhtml .= "<html><head>";
$pearhtml .= "<style>\n";
$pearhtml .= file_get_contents("../repair/printstyle.css");
$pearhtml .= "\n</style></head>";
$pearhtml .= "<body><table style=\"width:100%\"><tr><td style=\"width:100%\">\n";



$message .= "<span class=\"sizeme20 boldme\">$storeinfoarray[storename]<br></span>\n\n";
$pearhtml .= "<img src=../repair/$logo><br>\n\n";





$rs_findpc = "SELECT * FROM pc_group WHERE pcgroupid = '$pcgroupid'";
$rs_result = mysqli_query($rs_connect, $rs_findpc);
$rs_result_q = mysqli_fetch_object($rs_result);
$pcgroupname = "$rs_result_q->pcgroupname";
$grpcompany = "$rs_result_q->grpcompany";
$grpaddress = "$rs_result_q->grpaddress1";
$grpaddress2 = "$rs_result_q->grpaddress2";
$grpcity = "$rs_result_q->grpcity";
$grpstate = "$rs_result_q->grpstate";
$grpzip = "$rs_result_q->grpzip";

$message .= "$storeinfoarray[storename]";
$message .= "<br>$storeinfoarray[storeaddy1]";
$pearhtml .= "$storeinfoarray[storename]";
$pearhtml .= "<br>$storeinfoarray[storeaddy1]";
if ("$storeinfoarray[storeaddy2]" != "") {
$message .="<br>$storeinfoarray[storeaddy2]\n";
$pearhtml .="<br>$storeinfoarray[storeaddy2]\n";
}
$message .= "<br>$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]\n";
$message .= "<br><br>".pcrtlang("Phone").": $storeinfoarray[storephone]<br><br>\n";
$pearhtml .= "<br>$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]\n";
$pearhtml .= "<br><br>".pcrtlang("Phone").": $storeinfoarray[storephone]<br><br>\n";

if("$rs_company" != "") {
$customername = "$grpcompany";
} else {
$customername = "$pcgroupname";
}

$message .= "<table><tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>$customername<br>$grpaddress";
$pearhtml .= "<table><tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>$customername<br>$grpaddress";

if ($grpaddress2 != "") {
$message .= "<br>$grpaddress2";
$pearhtml .= "<br>$grpaddress2";
}

$message .= "<br>$grpcity, $grpstate $grpzip</td></tr></table>\n";
$pearhtml .= "<br>$grpcity, $grpstate $grpzip</td></tr></table>\n";


$rs_bcs = "SELECT * FROM blockcontract WHERE blockid = '$blockid'";
$rs_find_bcs = @mysqli_query($rs_connect, $rs_bcs);

while($rs_find_bcs_q = mysqli_fetch_object($rs_find_bcs)) {
$blockid = "$rs_find_bcs_q->blockid";
$blocktitle = "$rs_find_bcs_q->blocktitle";
$blocknote = "$rs_find_bcs_q->blocknote";
$blockstart = "$rs_find_bcs_q->blockstart";
$contractclosed = "$rs_find_bcs_q->contractclosed";

$blocktitle_ue = urlencode("$blocktitle");

$message .= "<center><span class=sizeme20>$blocktitle</span></center><br><br>";
$pearhtml .= "<center><span class=sizeme20>$blocktitle</span></center><br><br>";

$message .= "<table class=\"standard pad10\">";
$message .= "<tr><td style=\"vertical-align:top\">".pcrtlang("Start Date").":</td><td style=\"vertical-align:top\">$blockstart</td>";

$pearhtml .= "<table class=\"standard pad10\">";
$pearhtml .= "<tr><td style=\"vertical-align:top\">".pcrtlang("Start Date").":</td><td style=\"vertical-align:top\">$blockstart</td>";

$rs_checkrinvoice2 = "SELECT * FROM rinvoices WHERE blockcontractid = '$blockid'";
$rs_result_rci2 = mysqli_query($rs_connect, $rs_checkrinvoice2);


$message .= "</tr><tr><td style=\"vertical-align:top;\">".pcrtlang("Notes").":</td><td style=\"vertical-align:top\">$blocknote</td></tr></table><br>";
$pearhtml .= "</tr><tr><td style=\"vertical-align:top;\">".pcrtlang("Notes").":</td><td style=\"vertical-align:top\">$blocknote</td></tr></table><br>";


#lines

$masterlist = array();
$timebalance = 0;

$rs_findblockhours = "SELECT * FROM blockcontracthours WHERE blockcontractid = '$blockid'";
$rs_result_bh = mysqli_query($rs_connect, $rs_findblockhours);
while($rs_result_qbh = mysqli_fetch_object($rs_result_bh)) {
$blockhours = "$rs_result_qbh->blockhours";
$blockcontracthoursid = "$rs_result_qbh->blockcontracthoursid";
$blockhoursdate = "$rs_result_qbh->blockhoursdate";
$invoiceid = "$rs_result_qbh->invoiceid";
$masterlist[] = array("linetype" => "blockhours", "blockhours" => "$blockhours", "thedate" => "$blockhoursdate 0000-00-00 00:00:00", "invoiceid" => "$invoiceid", "thedateonly" => "$blockhoursdate", "blockcontracthoursid" => "$blockcontracthoursid");
}


$rs_findtimers = "SELECT * FROM timers WHERE blockcontractid = '$blockid' AND timerstop != '0000-00-00 00:00:00'";
$rs_result_t = mysqli_query($rs_connect, $rs_findtimers);
while($rs_result_qt = mysqli_fetch_object($rs_result_t)) {
$timername = "$rs_result_qt->timerdesc";
$timerstart = "$rs_result_qt->timerstart";
$timerstop = "$rs_result_qt->timerstop";
$timertotal = "$rs_result_qt->timertotal";
$timerid = "$rs_result_qt->timerid";
$billedout = "$rs_result_qt->billedout";
$timerbyuser = "$rs_result_qt->byuser";
$woid = "$rs_result_qt->woid";
$savedround = "$rs_result_qt->savedround";


$timerstart_2822 = date('r', strtotime("$timerstart"));

$timerstartdate2 = date('n-d-Y', strtotime($timerstart));
$timerstarttime2 = date('g:ia', strtotime($timerstart));
$timerstoptime2 = date('g:ia', strtotime($timerstop));

$startepoch = strtotime($timerstart);
$stopepoch = time();
$startseconds = $stopepoch - $startepoch;

$masterlist[] = array("savedround" => "$savedround", "timerid" => "$timerid", "linetype" => "timer", "timername" => "$timername", "thedate" => "$timerstart", "timerstop" => "$timerstop", "timeruser" => "$timerbyuser", "woid" => "$woid");
}


array_sort_by_column($masterlist, 'thedate');

$message .= "<table class=\"pad10 standard\"><tr><td></td><td></td><th><span class=floatright>".pcrtlang("Actual")."</span></th>";
$message .= "<th><span class=floatright>".pcrtlang("Billed")."</span></th><th><span class=floatright>".pcrtlang("Balance")."</span></th></tr>";

$pearhtml .= "<table class=\"pad10 standard\"><tr><td></td><td></td><th><span class=floatright>".pcrtlang("Actual")."</span></th>";
$pearhtml .= "<th><span class=floatright>".pcrtlang("Billed")."</span></th><th><span class=floatright>".pcrtlang("Balance")."</span></th></tr>";

$runningtime = 0;

foreach($masterlist as $key => $subarray) {

#timercode start
if($subarray['linetype'] == "timer") {

$timername = $subarray['timername']; 
$timerstart = $subarray['thedate'];
$timerstop = $subarray['timerstop'];
$timerid = $subarray['timerid'];
$timerbyuser = $subarray['timeruser'];
$woid = $subarray['woid'];
$savedround = $subarray['savedround'];

$timerstart_2822 = date('r', strtotime("$timerstart"));

$timerstartdate2 = date('Y-n-j', strtotime($timerstart));
$timerstarttime2 = date('g:ia', strtotime($timerstart));
$timerstoptime2 = date('g:ia', strtotime($timerstop));


$startepoch = strtotime($timerstart);
$stopepoch = time();
$startseconds = $stopepoch - $startepoch;


$startstamp = strtotime("$timerstart");
$stopstamp = strtotime("$timerstop");

$elapsedtime = $stopstamp - $startstamp;
$timeusedact =  mf($elapsedtime / 3600);


if($savedround == 15) {
$elapsedtime2 = ($elapsedtime - ($elapsedtime % 900)) + 900; 
$runningtime = $runningtime - $elapsedtime2;
} elseif($savedround == 30) {
$elapsedtime2 = ($elapsedtime - ($elapsedtime % 1800)) + 1800;
$runningtime = $runningtime - $elapsedtime2;
} elseif($savedround == 60) {
$elapsedtime2 = ($elapsedtime - ($elapsedtime % 3600)) + 3600;
$runningtime = $runningtime - $elapsedtime2;
} else {
$elapsedtime2 = $elapsedtime;
$runningtime = $runningtime - $elapsedtime2;
}

$timeused =  mf($elapsedtime2 / 3600);

$timebalance = mf($runningtime / 3600);

$elapsedhuman = time_elapsed($elapsedtime);

$message .= "<tr><td><i class=\"fa fa-clock-o fa-lg colormered fa-fw\"></i> $timername</td>
<td>$timerstartdate2<br><span class=\"colormegreen\">$timerstarttime2 </span> - <span class=\"colormered\">$timerstoptime2</span></td>";
$message .= "<td style=\"text-align:right;\">$timeusedact</td><td style=\"text-align:right;\">-$timeused</td>
<td style=\"text-align:right;\">$timebalance</td></tr>";

$pearhtml .= "<tr><td><i class=\"fa fa-clock-o fa-lg colormered fa-fw\"></i> $timername</td>
<td>$timerstartdate2<br><span class=\"colormegreen\">$timerstarttime2 </span> - <span class=\"colormered\">$timerstoptime2</span></td>";
$pearhtml .= "<td style=\"text-align:right;\">$timeusedact</td><td style=\"text-align:right;\">-$timeused</td>
<td style=\"text-align:right;\">$timebalance</td></tr>";





} else {
#timercode stop
#line item start

$blockhours = $subarray['blockhours'];
$thedateonly = $subarray['thedateonly'];
$invoiceid = $subarray['invoiceid'];

$runningtime = $runningtime + (3600 * $blockhours);
$timebalance = mf($runningtime / 3600);

$message .= "<tr><td>".pcrtlang("Purchased Hours")."";
$message .= " &bull; ".pcrtlang("Invoice")." #$invoiceid";
$message .= "</td><td><span class=colormeblue>$thedateonly</span></td><td colspan=1>";
$message .= "</td><td style=\"text-align:right;\">+".mf("$blockhours")."</td><td style=\"text-align:right;\">$timebalance</td></tr>";

$pearhtml .= "<tr><td>".pcrtlang("Purchased Hours")."";
$pearhtml .= " &bull; ".pcrtlang("Invoice")." #$invoiceid";
$pearhtml .= "</td><td><span class=colormeblue>$thedateonly</span></td><td colspan=1>";
$pearhtml .= "</td><td style=\"text-align:right;\">+".mf("$blockhours")."</td><td style=\"text-align:right;\">$timebalance</td></tr>";


}


}


$message .= "<tr><td colspan=11 style=\"text-align:right;\">".pcrtlang("Remaining Time").": $timebalance</td></tr>";
$pearhtml .= "<tr><td colspan=11 style=\"text-align:right;\">".pcrtlang("Remaining Time").": $timebalance</td></tr>";

$rs_update_h = "UPDATE blockcontract SET hourscache = '$timebalance' WHERE blockid = '$blockid'";
@mysqli_query($rs_connect, $rs_update_h);


$message .= "</table>";
$pearhtml .= "</table>";


}


$message .= "--PHP-alt-$random_hash--\n\n";

if (!isset($pcrt_mailer)) {
$pcrt_mailer = "mail";
}

if ($pcrt_mailer == "mail") {
$mail_sent = @mail( $to, $subject, $message, $headers );
echo $mail_sent ? "<html><head><meta http-equiv=\"refresh\" content=\"2;url=index.php?pcwo=$woid\"></head>
<body>".pcrtlang("Mail sent")."<br><br><a href=group.php?func=viewgroup&groupview=blockcontract&pcgroupid=$pcgroupid>".pcrtlang("Return")."</a></body></html>" : pcrtlang("Mail failed");
} elseif (($pcrt_mailer == "pearsmtp") || ($pcrt_mailer == "pearsmtpauth") || ($pcrt_mailer == "pearphpmailer")) {

if (!@include('Mail.php'))  {
echo "<div style=\"border: #ff0000 2px solid; background:#FFBCBC; color:#ff0000; margin: 20px; padding:20px;\">";
echo "Sorry you server does not have support for the Pear Mail and Pear Mail-Mime library. Check with your host to see if it is supported, or visit go-pear.com to download the pear installer
that can be run from your website to install your own local copy of Pear and the Pear Mail and Pear Mail-Mime modules.<br><br>If you choose to install your own copy, after installing, you
will need to also add the Mail and Mail-Mime packages. You will need to use your host control panel to password protect the directory. You will also need to add a setting to a
php.ini or php5.ini file to specify the runtime path of pear for your server. Quite often you can google your hosting provider name and pear to find a howto for your host.
if you are running your own linux server, quite often your distribution provides ready to install Pear packages.";
echo "</div>";
die();
}


#include('Mail.php');
    include('Mail/mime.php');

    $pearmessage2 = new Mail_mime();

    $pearmessage2->setTXTBody($peartext);
    $pearmessage2->setHTMLBody($pearhtml);

$imagetype = mb_substr("../repair/$logo", -3);
if ($imagetype == "gif") { 
$pearmessage2->addHTMLImage("../repair/$logo", 'image/gif');
} elseif ($imagetype == "jpg") {
$pearmessage2->addHTMLImage("../repair/$logo", 'image/jpeg');
} elseif ($imagetype == "png") {
$pearmessage2->addHTMLImage("../repair/$logo", 'image/png');
} else {
}


$mime_params = array(
  'text_encoding' => '7bit',
  'text_charset'  => 'UTF-8',
  'html_charset'  => 'UTF-8',
  'head_charset'  => 'UTF-8'
);

    $body = $pearmessage2->get($mime_params);
    $extraheaders = array("To"=>"$to","From"=>"$storeinfoarray[storeemail]", "Subject"=>"$subject", "Content-Type"  => "text/html; charset=UTF-8");
    $pearheaders = $pearmessage2->headers($extraheaders);

if ("$pcrt_mailer" == "pearsmtpauth") {
$smtp = Mail::factory('smtp',
   array ('host' => $pcrt_pear_host,
     'auth' => true,
     'port' => $pcrt_pear_port,
     'username' => $pcrt_pear_username,
     'password' => $pcrt_pear_password));
} elseif ("$pcrt_mailer" == "pearphpmailer") {
$smtp = Mail::factory('mail');
} elseif ("$pcrt_mailer" == "pearsmtp")  {
$smtp = Mail::factory('smtp');
} else {
die("Invalid Mailer Chosen");
}



$mailresult = $smtp->send("$to", $pearheaders, $body);

if (PEAR::isError($mailresult)) {
$fademessage = $mailresult->getMessage();
$fademessage2 = pcrtlang("Failed to Block of Time Contract Report... <br><br>Error Message:")."$fademessage";
$fademessage3 = urlencode("$fademessage2");
header("Location: group.php?func=viewgroup&pcgroupid=pcgroupid&groupview=blockcontract&fademessage=$fademessage3&fademessagetype=error#botc");

  } else {

$fademessage2 = pcrtlang("Block of Time Contract Report Email Sent Successfully")." $to";
$fademessage3 = urlencode("$fademessage2");
header("Location: group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=blockcontract&fademessage=$fademessage3&fademessagetype=success#botc");

  }

} else {
echo "Error: invalid mailer specified in the deps.php config file";
}






}





########################################################################




function openinvoicestatement() {
require_once("validate.php");

$pcgroupid = $_REQUEST['pcgroupid'];
$name = $_REQUEST['name'];
$company = $_REQUEST['company'];
$addy1 = $_REQUEST['addy1'];
$addy2 = $_REQUEST['addy2'];
$state = $_REQUEST['state'];
$zip = $_REQUEST['zip'];
$city = $_REQUEST['city'];
$email = $_REQUEST['email'];
$phone = $_REQUEST['phone'];


include("deps.php");
include("common.php");


?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php


echo "<title>".pcrtlang("Print Statement")."</title>";


echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../repair/printstyle.css\">";

echo "</head>";

echo "<body class=printpagebg>";



echo "<div class=printbar>";
echo "<button onClick=\"parent.location='group.php?func=viewgroup&pcgroupid=$pcgroupid'\" class=bigbutton><img src=../repair/images/left.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Return")."</button>";
echo "<font class=text30b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>";
echo "<button onClick=\"print();\" class=bigbutton><img src=../repair/images/print.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Print")."</button>";
echo "<font class=text30b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>";
#echo "<button onClick=\"parent.location='../repair/addresslabel.php?pcname=$rs_soldto_ue&pccompany=$rs_company_ue&pcaddress1=$rs_ad1_ue&pcaddress2=$rs_ad2_ue&pccity=$rs_city_ue&pcstate=$rs_state_ue&pczip=$rs_zip_ue&dymojsapi=html'\" class=bigbutton><img src=../repair/images/labelprinter.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Address Label")."</button>";
#echo "<font class=text30b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>";
#echo "<button  onClick=\"parent.location='../store/invoice.php?func=emailinv2&invoice_id=$invoice_id&emailaddy=$rs_email&returnurl=$rs_returnurl'\" class=bigbutton><img src=images/email.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Email")."</button>";
echo "</div>";


echo "<div class=printpage>";
echo "<table width=100%><tr><td width=55%>";


$storeinfoarray = getstoreinfo($defaultuserstore);

echo "<img src=../repair/$printablelogo><br><br><font class=text12b>";
echo "$storeinfoarray[storename]</font><font class=text12><br>$storeinfoarray[storeaddy1]";
if ("$storeinfoarray[storeaddy2]" != "") {
echo "<br>$storeinfoarray[storeaddy2]";
}
echo "<br>$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]";
echo "</font>";
echo "</font><br><font class=text12>".pcrtlang("Phone").": $storeinfoarray[storephone]</font><br><br><br>";

echo "<table cellpadding=3 cellspacing=0 border=0><tr><td valign=top><font class=text12b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></td><td>";

if ("$company" != "") {
echo "<font class=text12>$company";
} else {
echo "<font class=text12>$name";
}

echo "<br>$addy1";

if ($addy2 != "") {
echo "<br>$addy2";
}

echo "<br>";

if ($city != "") {
echo "$city, ";
}


echo "$state $zip<br><br>";


echo "</font></td></tr></table>";

echo "</font><br></td><td valign=top><table><tr><td align=right width=45% valign=top>";
echo "<font class=textidnumber>".pcrtlang("STATEMENT")."<br></font>";


if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

$printeddate = pcrtdate("$pcrt_longdate", "$currentdatetime");

echo "<br><font class=text12>".pcrtlang("Date").": </font><font class=text12b>$printeddate</font>";

echo "</td></tr><tr><td>";

echo "</td></tr></table></td></tr></table>";



echo "<table class=printables>";


$invoicetotalids = "(SELECT DISTINCT(invoices.invoice_id),invoices.invdate,invoices.invnotes FROM invoices, pc_wo, pc_owner WHERE pc_owner.pcgroupid = '$pcgroupid' AND pc_owner.pcid = pc_wo.pcid
AND invoices.iorq != 'quote' AND invoices.invstatus = '1' AND (pc_wo.woid = invoices.woid OR invoices.woid LIKE CONCAT('%\_',pc_wo.woid,'\_%')))
UNION (SELECT invoices.invoice_id,invoices.invdate,invoices.invnotes FROM invoices,rinvoices WHERE invoices.rinvoice_id = rinvoices.rinvoice_id AND rinvoices.pcgroupid = '$pcgroupid'
AND invoices.invstatus = '1')
UNION (SELECT invoice_id,invdate,invnotes FROM invoices WHERE pcgroupid = '$pcgroupid' AND invoices.invstatus = '1')";

$rs_resultit = mysqli_query($rs_connect, $invoicetotalids);


if (mysqli_num_rows($rs_resultit) != 0) {
echo "<tr><th colspan=5 width=100%>".pcrtlang("Invoices")."</th></tr>";

echo "<tr><td width=15% class=subhead>".pcrtlang("Invoice Date")."</td><td width=40% class=subhead>".pcrtlang("Invoice Number")."</td><td width=15% align=right class=subhead>".pcrtlang("Invoice Total")."</td><td width=15% align=right class=subhead>".pcrtlang("Total Deposits");

echo "</td><td width=15% align=right class=subhead>".pcrtlang("Invoice Balance")."</td></tr>";
}


$statementtotal = 0;
$statementdeposittotal = 0;

while($rs_result_it = mysqli_fetch_object($rs_resultit)) {
$invoiceid = "$rs_result_it->invoice_id";
$invdate = "$rs_result_it->invdate";
$invnotes = "$rs_result_it->invnotes";

$invdate = pcrtdate("$pcrt_shortdate", "$invdate");

$findinvtotal = "SELECT SUM(cart_price) AS invsubtotal, SUM(itemtax) AS invtax FROM invoice_items WHERE invoice_id = '$invoiceid'";
$findinvq = @mysqli_query($rs_connect, $findinvtotal);
$findinva = mysqli_fetch_object($findinvq);
$invtax = "$findinva->invtax";
$invsubtotal = "$findinva->invsubtotal";
$invoicetotal = $invtax + $invsubtotal;

$finddeposits = "SELECT SUM(amount) AS deposittotal FROM deposits WHERE invoiceid = '$invoiceid'";
$finddepositsq = @mysqli_query($rs_connect, $finddeposits);
$finddepositsa = mysqli_fetch_object($finddepositsq);
$deposittotal = mf("$finddepositsa->deposittotal");
$depositbalance = mf($invoicetotal - $deposittotal);

$statementtotal = $statementtotal + $invoicetotal;
$statementdeposittotal = $statementdeposittotal + $deposittotal;

echo "<tr><td>$invdate</td><td>".pcrtlang("INVOICE").": #$invoiceid<br><span class=sizeme10>".pcrtlang("Notes").": $invnotes</span></td><td align=right>$money".mf("$invoicetotal")."</td><td align=right>$money".mf("$deposittotal")."</td><td align=right>$money".mf("$depositbalance")."</td></tr>";


}


$statementbalance = $statementtotal - $statementdeposittotal;

echo "<tr><td colspan=5 class=subhead></td></tr>";
echo "<tr><td colspan=5></td></tr>";
echo "<tr><td colspan=2></td><td colspan=2><span class=\"boldme\">".pcrtlang("Invoice Totals")."</span></td><td align=right><span class=\"boldme\">$money".mf("$statementtotal")."</span></td></tr>";
echo "<tr><td colspan=2></td><td colspan=2><span class=\"boldme\">".pcrtlang("Total Deposits")."</span></td><td align=right><span class=\"boldme\">$money".mf($statementdeposittotal)."</span></td></tr>";
echo "<tr><td colspan=2></td><td colspan=2><span class=\"sizeme16 boldme\">".pcrtlang("Balance Due")."</span></td><td align=right><span class=\"sizeme16 boldme\">$money".mf("$statementbalance")."</span></td></tr>";


echo "</table></div>";


echo "</body></html>";


}






function emailopeninvoicestatement() {
require_once("validate.php");
$pcgroupid = $_REQUEST['pcgroupid'];
$name = $_REQUEST['name'];
$company = $_REQUEST['company'];
$addy1 = $_REQUEST['addy1'];
$addy2 = $_REQUEST['addy2'];
$state = $_REQUEST['state'];
$zip = $_REQUEST['zip'];
$city = $_REQUEST['city'];
$email = $_REQUEST['email'];
$phone = $_REQUEST['phone'];



include("deps.php");
include("common.php");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}

require("deps.php");



$storeinfoarray = getstoreinfo($defaultuserstore);

$to = "$email";

if($storeinfoarray['storeccemail'] != "")	{
$to .= ",$storeinfoarray[storeccemail]";
}

$subject = "$storeinfoarray[storename] - ".pcrtlang("Statement");
$random_hash = md5(date('r', time()));
$headers = "From: $storeinfoarray[storeemail]\r\nReply-To: $storeinfoarray[storeemail]\r\nX-Mailer: PHP/".phpversion();
$headers .= "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
$headers .= "\r\nMIME-Version: 1.0";

$message = "--PHP-alt-$random_hash\r";
$message .= "Content-Type: text/plain; charset=\"iso-8859-1\"\r";
$message .= "Content-Transfer-Encoding: 7bit\r";

$message .= pcrtlang("Statement")."\n";
$peartext = pcrtlang("Statement")."\n";

$message .= "--PHP-alt-$random_hash\n";
$message .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
$message .= "Content-Transfer-Encoding: 7bit\n\n";

#######################

$message .= "<html><head><title>".pcrtlang("Statement")."</title></head><body>";
$pearhtml = "<html><head><title>".pcrtlang("Statement")."</title></head><body>";

$message .= "<table width=100%><tr><td width=55%>";
$pearhtml .= "<table width=100%><tr><td width=55%>";

$storeinfoarray = getstoreinfo($defaultuserstore);

$message .= "<img src=../repair/$logo><br><br>$storeinfoarray[storename]<br>$storeinfoarray[storeaddy1]";
$pearhtml .= "<img src=../repair/$logo><br><br>$storeinfoarray[storename]<br>$storeinfoarray[storeaddy1]";

if ("$storeinfoarray[storeaddy2]" != "") {
$message .= "<br>$storeinfoarray[storeaddy2]";
$pearhtml .= "<br>$storeinfoarray[storeaddy2]";
}

$message .= "<br>$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]<br>".pcrtlang("Phone").": $storeinfoarray[storephone]<br><br><br>";
$pearhtml .= "<br>$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]<br>".pcrtlang("Phone").": $storeinfoarray[storephone]<br><br><br>";

$message .= "<table cellpadding=3 cellspacing=0 border=0><tr><td valign=top>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>";
$pearhtml .= "<table cellpadding=3 cellspacing=0 border=0><tr><td valign=top>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>";

if ("$company" != "") {
$message .= "$company";
$pearhtml .= "$company";
} else {
$message .= "$name";
$pearhtml .= "$name";
}

$message .= "<br>$addy1";
$pearhtml .= "<br>$addy1";

if ($addy2 != "") {
$message .= "<br>$addy2";
$pearhtml .= "<br>$addy2";
}

$message .= "<br>";
$pearhtml .= "<br>";

if ($city != "") {
$message .= "$city, ";
$pearhtml .= "$city, ";
}


$message .= "$state $zip<br><br>";
$pearhtml .= "$state $zip<br><br>";

$message .= "</td></tr></table>";
$pearhtml .= "</td></tr></table>";

#

$message .= "<br></td><td valign=top><table><tr><td align=right width=45% valign=top><span style=\"font-size:24px;color:#555555\">".pcrtlang("STATEMENT")."<br></span>";
$pearhtml .= "<br></td><td valign=top><table><tr><td align=right width=45% valign=top><span style=\"font-size:24px;color:#555555\">".pcrtlang("STATEMENT")."<br></span>";


if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

$printeddate = pcrtdate("$pcrt_longdate", "$currentdatetime");

$message .= "<br>".pcrtlang("Date").": $printeddate</td></tr><tr><td></td></tr></table></td></tr></table>";
$pearhtml .= "<br>".pcrtlang("Date").": $printeddate</td></tr><tr><td></td></tr></table></td></tr></table>";


$message .= "<table style=\"width:100%;border-collapse:collapse;cellpadding:4px;\">";
$pearhtml .= "<table style=\"width:100%;border-collapse:collapse;cellpadding:4px;\">";

$invoicetotalids = "(SELECT DISTINCT(invoices.invoice_id),invoices.invdate,invoices.invnotes FROM invoices, pc_wo, pc_owner
WHERE pc_owner.pcgroupid = '$pcgroupid' AND pc_owner.pcid = pc_wo.pcid
AND invoices.iorq != 'quote' AND invoices.invstatus = '1' AND (pc_wo.woid = invoices.woid OR invoices.woid LIKE CONCAT('%\_',pc_wo.woid,'\_%')))
UNION (SELECT invoices.invoice_id,invoices.invdate,invoices.invnotes
FROM invoices,rinvoices WHERE invoices.rinvoice_id = rinvoices.rinvoice_id AND rinvoices.pcgroupid = '$pcgroupid'
AND invoices.invstatus = '1')
UNION (SELECT invoice_id,invdate,invnotes FROM invoices WHERE pcgroupid = '$pcgroupid' AND invoices.invstatus = '1')";


$rs_resultit = mysqli_query($rs_connect, $invoicetotalids);


if (mysqli_num_rows($rs_resultit) != 0) {
$message .= "<tr><th colspan=5 style=\"box-shadow: inset 0 0 0 1000px #dddddd;padding:8px;width:100%\">".pcrtlang("Invoices")."</th></tr>";
$pearhtml .= "<tr><th colspan=5 style=\"box-shadow: inset 0 0 0 1000px #dddddd;padding:8px;width:100%\">".pcrtlang("Invoices")."</th></tr>";

$message .= "<tr><td width=15% style=\"border-bottom: 2px solid #333333;\">".pcrtlang("Invoice Date")."</td><td width=40% style=\"border-bottom: 2px solid #333333;\">".pcrtlang("Invoice Number")."</td><td width=15% align=right  style=\"border-bottom: 2px solid #333333;\">".pcrtlang("Invoice Total")."</td><td width=15% align=right style=\"border-bottom: 2px solid #333333;\">".pcrtlang("Total Deposits");
$pearhtml .= "<tr><td width=15% style=\"border-bottom: 2px solid #333333;\">".pcrtlang("Invoice Date")."</td><td width=40% style=\"border-bottom: 2px solid #333333;\">".pcrtlang("Invoice Number")."</td><td width=15% align=right style=\"border-bottom: 2px solid #333333;\">".pcrtlang("Invoice Total")."</td><td width=15% align=right style=\"border-bottom: 2px solid #333333;\">".pcrtlang("Total Deposits");


$message .= "</td><td width=15% align=right style=\"border-bottom: 2px solid #333333;\">".pcrtlang("Invoice Balance")."</td></tr>";
$pearhtml .= "</td><td width=15% align=right style=\"border-bottom: 2px solid #333333;\">".pcrtlang("Invoice Balance")."</td></tr>";

}


$statementtotal = 0;
$statementdeposittotal = 0;

while($rs_result_it = mysqli_fetch_object($rs_resultit)) {
$invoiceid = "$rs_result_it->invoice_id";
$invdate = "$rs_result_it->invdate";
$invnotes = "$rs_result_it->invnotes";

$invdate = pcrtdate("$pcrt_shortdate", "$invdate");

$findinvtotal = "SELECT SUM(cart_price) AS invsubtotal, SUM(itemtax) AS invtax FROM invoice_items WHERE invoice_id = '$invoiceid'";
$findinvq = @mysqli_query($rs_connect, $findinvtotal);
$findinva = mysqli_fetch_object($findinvq);
$invtax = "$findinva->invtax";
$invsubtotal = "$findinva->invsubtotal";
$invoicetotal = $invtax + $invsubtotal;

$finddeposits = "SELECT SUM(amount) AS deposittotal FROM deposits WHERE invoiceid = '$invoiceid'";
$finddepositsq = @mysqli_query($rs_connect, $finddeposits);
$finddepositsa = mysqli_fetch_object($finddepositsq);
$deposittotal = mf("$finddepositsa->deposittotal");
$depositbalance = mf($invoicetotal - $deposittotal);

$statementtotal = $statementtotal + $invoicetotal;
$statementdeposittotal = $statementdeposittotal + $deposittotal;

$message .= "<tr><td>$invdate</td><td>".pcrtlang("INVOICE").": #$invoiceid<br><span style=\"font-size:10px;\">".pcrtlang("Notes").": $invnotes</span></td><td align=right>$money".mf("$invoicetotal")."</td><td align=right>$money".mf("$deposittotal")."</td><td align=right>$money".mf("$depositbalance")."</td></tr>";
$pearhtml .= "<tr><td>$invdate</td><td>".pcrtlang("INVOICE").": #$invoiceid<br><span style=\"font-size:10px;\">".pcrtlang("Notes").": $invnotes</span></td><td align=right>$money".mf("$invoicetotal")."</td><td align=right>$money".mf("$deposittotal")."</td><td align=right>$money".mf("$depositbalance")."</td></tr>";


}


$statementbalance = $statementtotal - $statementdeposittotal;
$message .= "<tr><td colspan=5 style=\"border-bottom: 2px solid #333333;\"></td></tr><tr><td colspan=5></td></tr>";
$message .= "<tr><td colspan=2></td><td colspan=2><span class=\"boldme\">".pcrtlang("Invoice Totals")."</span></td><td align=right><span class=\"boldme\">$money".mf("$statementtotal")."</span></td></tr>";
$message .= "<tr><td colspan=2></td><td colspan=2><span class=\"boldme\">".pcrtlang("Total Deposits")."</span></td><td align=right><span class=\"boldme\">$money".mf($statementdeposittotal)."</span></td></tr>";
$message .= "<tr><td colspan=2></td><td colspan=2><span class=\"sizeme16 boldme\">".pcrtlang("Balance Due")."</span></td><td align=right><span class=\"sizeme16 boldme\">$money".mf("$statementbalance")."</span></td></tr>";

$pearhtml .= "<tr><td colspan=5 style=\"border-bottom: 2px solid #333333;\"></td></tr><tr><td colspan=5></td></tr>";
$pearhtml .= "<tr><td colspan=2></td><td colspan=2><span class=\"boldme\">".pcrtlang("Invoice Totals")."</span></td><td align=right><span class=\"boldme\">$money".mf("$statementtotal")."</span></td></tr>";
$pearhtml .= "<tr><td colspan=2></td><td colspan=2><span class=\"boldme\">".pcrtlang("Total Deposits")."</span></td><td align=right><span class=\"boldme\">$money".mf($statementdeposittotal)."</span></td></tr>";
$pearhtml .= "<tr><td colspan=2></td><td colspan=2><span class=\"sizeme16 boldme\">".pcrtlang("Balance Due")."</span></td><td align=right><span class=\"sizeme16 boldme\">$money".mf("$statementbalance")."</span></td></tr>";



$message .= "</table></div>";
$pearhtml .= "</table></div>";


$message .= "</body></html>";
$pearhtml .= "</body></html>";


#########################


$message .= "--PHP-alt-$random_hash--\n\n";

$gotourl = "group.php?func=viewgroup&pcgroupid=$pcgroupid";

if (!isset($pcrt_mailer)) {
$pcrt_mailer = "mail";
}

if ($pcrt_mailer == "mail") {
$mail_sent = @mail( $to, $subject, $message, $headers );
echo $mail_sent ? "<html><head><meta http-equiv=\"refresh\" content=\"2;url=$gotourl\"></head><body>".pcrtlang("Mail sent")."<br><br><a href=$gotourl>".pcrtlang("Return")."</a></body></html>" : pcrtlang("Mail failed");
} elseif (($pcrt_mailer == "pearsmtp") || ($pcrt_mailer == "pearsmtpauth") || ($pcrt_mailer == "pearphpmailer")) {

if (!@include('Mail.php'))  {
echo "<div style=\"border: #ff0000 2px solid; background:#FFBCBC; color:#ff0000; margin: 20px; padding:20px;\">";
echo "Sorry you server does not have support for the Pear Mail and Pear Mail-Mime library. Check with your host to see if it is supported, or visit go-pear.com to download the pear installer
that can be run from your website to install your own local copy of Pear and the Pear Mail and Pear Mail-Mime modules.<br><br>If you choose to install your own copy, after installing, you
will need to also add the Mail and Mail-Mime packages. You will need to use your host control panel to password protect the directory. You will also need to add a setting to a
php.ini or php5.ini file to specify the runtime path of pear for your server. Quite often you can google your hosting provider name and pear to find a howto for your host.
if you are running your own linux server, quite often your distribution provides ready to install Pear packages.";
echo "</div>";
die();
}


#include('Mail.php');
    include('Mail/mime.php');

    $pearmessage2 = new Mail_mime();

    $pearmessage2->setTXTBody($peartext);
    $pearmessage2->setHTMLBody($pearhtml);


$imagetype = substr("../repair/$logo", -3);
if ($imagetype == "gif") {
$pearmessage2->addHTMLImage("../repair/$logo", 'image/gif');
} elseif ($imagetype == "jpg") {
$pearmessage2->addHTMLImage("../repair/$logo", 'image/jpeg');
} elseif ($imagetype == "png") {
$pearmessage2->addHTMLImage("../repair/$logo", 'image/png');
} else {
}

$mime_params = array(
  'text_encoding' => '7bit',
  'text_charset'  => 'UTF-8',
  'html_charset'  => 'UTF-8',
  'head_charset'  => 'UTF-8'
);

    $body = $pearmessage2->get($mime_params);
    $extraheaders = array("To"=>"$to","From"=>"$storeinfoarray[storeemail]", "Subject"=>"$subject", "Content-Type"  => "text/html; charset=UTF-8");
    $pearheaders = $pearmessage2->headers($extraheaders);

if ("$pcrt_mailer" == "pearsmtpauth") {
$smtp = Mail::factory('smtp',
   array ('host' => $pcrt_pear_host,
     'auth' => true,
     'port' => $pcrt_pear_port,
     'username' => $pcrt_pear_username,
     'password' => $pcrt_pear_password));
} elseif ("$pcrt_mailer" == "pearphpmailer") {
$smtp = Mail::factory('mail');
} elseif ("$pcrt_mailer" == "pearsmtp")  {
$smtp = Mail::factory('smtp');
} else {
die("Invalid Mailer Chosen");
}


$mailresult = $smtp->send("$to", $pearheaders, $body);

if (PEAR::isError($mailresult)) {
   echo("<p>" . $mailresult->getMessage() . "</p>");
  } else {
   echo "<html><head><meta http-equiv=\"refresh\" content=\"2;url=$gotourl\"></head><body>".pcrtlang("Mail sent")."<br>";
   echo "<br><a href=$gotourl>".pcrtlang("Return")."</a></body></html>";
  }

} else {
echo "Error: invalid mailer specified in the deps.php config file";
}

}



function addmessage() {
require_once("validate.php");
require("deps.php");
require("common.php");

$groupid = $_REQUEST['groupid'];
$themessage = $_REQUEST['themessage'];
$messagetype = $_REQUEST['type'];
$fromemail = $_REQUEST['fromemail'];
$toemail = $_REQUEST['toemail'];


if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');


if ($messagetype == 2) {
$rs_insert_message = "INSERT INTO messages (messagefrom,messagebody,messagedatetime,messagevia,groupid,messagedirection)
VALUES ('$ipofpc','$themessage','$currentdatetime','im','$groupid','out')";
} elseif ($messagetype == 1) {
$rs_insert_message = "INSERT INTO messages (messagefrom,messagebody,messagedatetime,messagevia,groupid,messagedirection)
VALUES ('$ipofpc','$themessage','$currentdatetime','call','$groupid','out')";
} elseif ($messagetype == 3) {
$rs_insert_message = "INSERT INTO messages (messagefrom,messageto,messagebody,messagedatetime,messagevia,groupid,messagedirection)
VALUES ('$fromemail','$toemail','$themessage','$currentdatetime','email','$groupid','out')";
if(($fromemail != "") && ($toemail != "")) {
require_once("sendenotify.php");
$storeinfoarray = getstoreinfo($defaultuserstore);
$subject = pcrtlang("Message from")." $storeinfoarray[storename]";

$plaintextprefix = "##-## ".pcrtlang("Please reply above this line")." ##-##\n\n";
$htmltextprefix = "##-## ".pcrtlang("Please reply above this line")." ##-##<br><br>";

$plaintext = "$plaintextprefix $themessage";
$htmltext = "$htmltextprefix $themessage";

sendenotify("$fromemail","$toemail","$subject","$plaintext","$htmltext");
}
} else {
echo "Unknown Type";
}


@mysqli_query($rs_connect, $rs_insert_message);



header("Location: group.php?func=viewgroup&pcgroupid=$groupid#smslog");

}



function tagsave() {
require_once("validate.php");

require("deps.php");
require("common.php");

$groupid = $_REQUEST['groupid'];

if (array_key_exists('tags',$_REQUEST)) {
$tags = $_REQUEST['tags'];
} else {
$tags = array();
}

$tags3 = array_filter($tags);
$tags2 = implode_list($tags3);

$rs_update_sal = "UPDATE pc_group SET tags = '$tags2' WHERE pcgroupid = '$groupid'";
@mysqli_query($rs_connect, $rs_update_sal);
header("Location: group.php?func=viewgroup&pcgroupid=$groupid#assetsdevices");

}



switch($func) {
                                                                                                    
    default:
    browsegroups();
    break;
                                
    case "addtogroupnew":
    addtogroupnew();
    break;

    case "addtogroupnew2":
    addtogroupnew2();
    break;
                                   
    case "viewgroup":
    viewgroup();
    break;
                                 
    case "addtogroup":
    addtogroup();
    break;

    case "addtogroup2":
    addtogroup2();
    break;

    case "searchaddtogroup":
    searchaddtogroup();
    break;

    case "removefromgroup":
    removefromgroup();
    break;

    case "searchpcaddtogroup":
    searchpcaddtogroup();
    break;

   case "searchpcaddtogroup2":
    searchpcaddtogroup2();
    break;

   case "synctoallpc":
    synctoallpc();
    break;

  case "syncpctogroup":
    syncpctogroup();
    break;

  case "syncpcfromgroup":
    syncpcfromgroup();
    break;

  case "editgroup":
    editgroup();
    break;

  case "editgroup2":
    editgroup2();
    break;

  case "browsegroups":
    browsegroups();
    break;

  case "bcreport":
    bcreport();
    break;

  case "bcreportemail":
    bcreportemail();
    break;


  case "openinvoicestatement":
    openinvoicestatement();
    break;

  case "emailopeninvoicestatement":
    emailopeninvoicestatement();
    break;

  case "addmessage":
    addmessage();
    break;

    case "tagsave":
    tagsave();
    break;


}
