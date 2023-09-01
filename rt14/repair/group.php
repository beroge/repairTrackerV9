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
require_once("header.php");
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


start_blue_box(pcrtlang("Create New Asset/Device/Customer Group"));

echo "<form action=group.php?func=addtogroupnew2 method=post>";
echo "<table>";
echo "<tr><td>".pcrtlang("Group Name").":</td><td><input size=35 class=textbox type=text name=pcgroupname value=\"$groupname\" required=required onFocus=\"this.form.submitbutton.disabled=false;this.form.submitbutton.value='".pcrtlang("Create New Group")."';\">";
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
<input type=hidden name=pcemail value=\"$pcemail\">
</td></tr>";


echo "<tr><td>&nbsp;</td><td><input class=ibutton type=submit id=submitbutton value=\"".pcrtlang("Create New Group")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Creating Group")."...'; this.form.submit();\"></td></tr>";
echo "</table>";

stop_blue_box();

require_once("footer.php");
                                                                                                    
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

if ($woid != "0") {
$rs_set_group = "UPDATE pc_owner SET pcgroupid = '$pcgroupid' WHERE pcid = '$pcid'";
@mysqli_query($rs_connect, $rs_set_group);
header("Location: index.php?pcwo=$woid");
} else {
header("Location: group.php?func=editgroup&pcgroupid=$pcgroupid&nomodal=0");
}

}



function viewgroup() {

$pcgroupid = $_REQUEST['pcgroupid'];


if($pcgroupid == "") {
die("Missing groupid");
}

require("header.php");
require("deps.php");

if ($gomodal == 1) {
$therel = "rel=facebox";
} else {
$therel = "";
}






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

echo "<script>document.title = \"".pcrtlang("Group").": ".addslashes("$pcgroupname")."\";</script>";

start_box();
echo "<table style=\"width:100%\"><tr><td style=\"width:50%\">";

if("$grpcompany" == "") {
echo "<h4>$pcgroupname</h4>";
} else {
echo "<h4>$pcgroupname &bull; $grpcompany</h4>";
}

if($grpnotes !=	"") {
echo "<br><br>".pcrtlang("Notes").":<br>$grpnotes";
}


echo "<br><br><a href=\"group.php?func=editgroup&pcgroupid=$pcgroupid\" $therel class=\"linkbuttonsmall linkbuttongray\"><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("Edit Group")."</a>";

echo "<a href=attachment.php?func=add&attachtowhat=groupid&groupid=$pcgroupid $therel class=\"linkbuttonsmall linkbuttongray\"><i class=\"fa fa-paperclip fa-lg\"></i> ".pcrtlang("Add Attachment")."</a>";

if ($ipofpc == "admin") {
$rs_findpc = "SELECT * FROM pc_owner WHERE pcgroupid = '$pcgroupid'";
$rs_resultpc2 = mysqli_query($rs_connect, $rs_findpc);

$totalpc = mysqli_num_rows($rs_resultpc2);
if ($totalpc == 0) {
echo "<a href=admin.php?func=admindeletegroup&pcgroupid=$pcgroupid class=\"linkbuttonsmall linkbuttongray\" onClick=\"return confirm('".pcrtlang("Are you sure you wish to permanently delete this Group!!!?")."');\"><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete this Group")."</a>";
}
}

echo "<br><br><i class=\"fa fa-group fa-lg\"></i> <strong>$pcgroupid</strong><br>";

echo "</td><td style=\"width:25%;vertical-align:top\">";

echo "<table border=0 cellspacing=0 cellpadding=2><tr><td bgcolor=#777777><i class=\"fa fa-phone fa-lg\" style=\"padding:20px 3px;color:white;\"></i></td><td>";

if($grpphone != "") {
if($grpprefcontact == "home") {
echo "<span class=\"boldme colormegraydark\">&bull;</span>";
} 
echo "&nbsp;".pcrtlang("Home").": $grpphone<br>";
}

if($grpcellphone != "") {
if($grpprefcontact == "cellphone") {
echo "<span class=\"boldme colormegraydark\">&bull;</span>";
}
echo "&nbsp;".pcrtlang("Mobile").": $grpcellphone<br>";
}

if($grpworkphone != "") {
if($grpprefcontact == "workphone") {
echo "<span class=\"boldme colormegraydark\">&bull;</span>";
}
echo "&nbsp;".pcrtlang("Work").": <span class=\"boldme colormegraydark\">$grpworkphone</span>";
}

echo "</td></tr></table>";


echo "</td><td style=\"width:25%;vertical-align:top\">";

if($grpaddress != "") {
$grpaddressbr = nl2br($grpaddress);
echo "<table cellpadding=2 cellspacing=0 border=0><tr><td bgcolor=#777777><i class=\"fa fa-map-marker fa-lg\" style=\"padding:20px 5px;color:white;\"></i></td><td><span class=\"boldme\">$grpaddressbr</span><br>";
if($grpaddress2 != "") {
echo "<span class=\"boldme\">$grpaddress2</span><br>";
}
if(($grpcity != "") && ($grpstate != "") && ($grpzip != "")) {
echo "<span class=\"boldme\">$grpcity, $grpstate $grpzip</span>";
}
echo "</td></tr></table>";

}


echo "</td></tr><tr><td style=\"padding:10px 10px 10px 0px;\">";

echo "<a href=group.php?func=synctoallpc&pcgroupid=$pcgroupid onClick=\"return confirm('".pcrtlang("Are you sure you wish to do this?")."');\" class=\"linkbuttonsmall linkbuttongray displayblock\"><img src=images/syncright.png class=iconsmall> ".pcrtlang("Sync the Contact Info to all Assets/Devices in this Group")."</a>";


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

$backurl = urlencode("group.php?func=viewgroup&pcgroupid=$pcgroupid");

echo "<a href=pc.php?func=addpc&pcname=$ue_pcgroupname&pccompany=$ue_grpcompany&pcphone=$ue_grpphone&pccellphone=$ue_grpcellphone&pcworkphone=$ue_grpworkphone&pcemail=$ue_grpemail&pcaddress=$ue_grpaddress&pcaddress2=$ue_grpaddress2&pccity=$ue_grpcity&pcstate=$ue_grpstate&pczip=$ue_grpzip&prefcontact=$ue_grpprefcontact&pcgroupid=$pcgroupid&custsourceid=$ue_grpcustsourceid class=\"linkbuttonsmall linkbuttongray displayblock\"><img src=images/new.png class=iconsmall> ".pcrtlang("Add New Asset/Device to this Group")."</a>"; 
echo "<a href=\"addresslabel.php?pcname=$ue_pcgroupname&pccompany=$ue_grpcompany&pcaddress1=$ue_grpaddress&pcaddress2=$ue_grpaddress2&pccity=$ue_grpcity&pcstate=$ue_grpstate&backurl=$backurl&pczip=$ue_grpzip&dymojsapi=html\" class=\"linkbuttonsmall linkbuttongray displayblock\"><img src=images/labelprinter.png class=iconsmall> ".pcrtlang("Print Address Label")."</a>";

echo "<a href=\"../store/cart.php?func=pickcustomer2&personname=$ue_pcgroupname&company=$ue_grpcompany&address1=$ue_grpaddress&address2=$ue_grpaddress2&city=$ue_grpcity&state=$ue_grpstate&zip=$ue_grpzip&email=$ue_grpemail&phone=$ue_grpphone&pcgroupid=$pcgroupid\" class=\"linkbuttonsmall linkbuttongray displayblock\"><img src=../store/images/rinvoice.png class=iconsmall> ".pcrtlang("Create Invoice/Recurring Invoice")."</a>";

echo "<a href=\"msp.php?func=newservicecontract&personname=$ue_pcgroupname&pcgroupid=$pcgroupid\" class=\"linkbuttonsmall linkbuttongray displayblock\"><img src=images/contract.png class=iconsmall> ".pcrtlang("Create Service Contract")."</a>";



echo "<a href=\"sticky.php?func=addsticky&stickyname=$ue_pcgroupname&stickycompany=$ue_grpcompany&stickyaddy1=$ue_grpaddress&stickyaddy2=$ue_grpaddress2&stickycity=$ue_grpcity&stickystate=$ue_grpstate&stickyzip=$ue_grpzip&stickyemail=$ue_grpemail&stickyphone=$ue_grpphone&stickyrefid=$pcgroupid&stickyreftype=groupid\" $therel class=\"linkbuttonsmall linkbuttongray displayblock\"><img src=images/sticky.png class=iconsmall> ".pcrtlang("Create Sticky Note")."</a>";

$invgrandtotal = invoicetotal($pcgroupid, 1);
$invgrandtotalclosed = invoicetotal($pcgroupid, 2);

if($invgrandtotal > 0) {
echo "<a href=\"group.php?func=openinvoicestatement&name=$ue_pcgroupname&company=$ue_grpcompany&addy1=$ue_grpaddress&addy2=$ue_grpaddress2&city=$ue_grpcity&state=$ue_grpstate&zip=$ue_grpzip&email=$ue_grpemail&phone=$ue_grpphone&pcgroupid=$pcgroupid\" class=\"linkbuttonsmall linkbuttongray displayblock\">
<img src=images/invoice.png class=iconsmall> ".pcrtlang("Print Open Invoice Statement")."</a>";

if($grpemail != "") {
echo "<a href=\"group.php?func=emailopeninvoicestatement&name=$ue_pcgroupname&company=$ue_grpcompany&addy1=$ue_grpaddress&addy2=$ue_grpaddress2&city=$ue_grpcity&state=$ue_grpstate&zip=$ue_grpzip&email=$ue_grpemail&phone=$ue_grpphone&pcgroupid=$pcgroupid\" class=\"linkbuttonsmall linkbuttongray displayblock\">
<img src=images/invoice.png class=iconsmall> ".pcrtlang("Email Open Invoice Statement")."</a>";
}
}


if (filter_var($grpemail, FILTER_VALIDATE_EMAIL)) {
echo "<a href=\"group.php?func=viewportal&pcgroupid=$pcgroupid&groupemail=$grpemail\" target=\"_blank\" class=\"linkbuttonsmall linkbuttongray displayblock\">
<img src=images/groups.png class=iconsmall> ".pcrtlang("View Customer Portal")."</a>";
echo "<a href=\"../portal/account.php?func=register2&username=$grpemail\" target=\"_blank\" class=\"linkbuttonsmall linkbuttongray displayblock reglink\">
<i class=\"fa fa-key fa-lg\"></i> ".pcrtlang("Send/Reset Portal Password")."</a>";
echo "<div id=regloader class=\"startbox boldme\" style=\"text-align:center;display:none\"></div>";
?>

<script>
$('.reglink').click(function(e){
  e.preventDefault(); // Prevents default link action
$('#regloader').html('<i class="fa fa-spinner fa-lg faa-spin animated"></i> <?php echo pcrtlang("Please wait"); ?>...').fadeIn().delay(50);
  $.ajax({
     url: $(this).attr('href'),
     success: function(data){
	$('#regloader').html('<i class="fa fa-check fa-lg"></i> <?php echo pcrtlang("Done"); ?>').delay(1000).fadeOut();
     }
  });
});
</script>


<?php


}

echo "</td><td colspan=2>";

if($grpemail != "") {
if($grpprefcontact == "email") {
echo "<a href=mailto:$grpemail class=\"linkbuttonmedium linkbuttongray\"><i class=\"fa fa-envelope fa-lg\" style=\"color:#ff0000;\"></i> $grpemail</a><br><br>";
} else {
echo "<a href=mailto:$grpemail class=\"linkbuttonmedium linkbuttongray radiusright radiusleft\"><i class=\"fa fa-envelope fa-lg\"></i> $grpemail</a><br><br>";
}
}




if($grpcustsourceid != "0") {
$rs_cssq = "SELECT * FROM custsource WHERE custsourceid='$grpcustsourceid'";
$rs_result1cs = mysqli_query($rs_connect, $rs_cssq);
while($rs_result_qcs1 = mysqli_fetch_object($rs_result1cs)) {
$thesource = "$rs_result_qcs1->thesource";
$sourceicon = "$rs_result_qcs1->sourceicon";
echo "<img src=images/custsources/$sourceicon align=absmiddle> ".pcrtlang("Customer Source").": <span class=\"boldme\">$thesource</span><br>";
}

}


########

echo "<br><table class=standard><tr><th><i class=\"fa fa-tags fa-lg fa-fw\"></i> ".pcrtlang("Tags")."</th></tr><tr><td>";


displaytags(0,$pcgroupid,32);

echo "<a href=\"javascript:void(0);\" class=\"linkbuttonsmall linkbuttongray radiusall floatright\" id=tagchange>
<i class=\"fa fa-chevron-down\"></i></a>";

echo "<div id=tagselectorbox style=\"display:none;\"><br>";

echo "<form method=post action=\"group.php?func=tagsave\"><input type=hidden name=groupid value=\"$pcgroupid\">";

echo "<div class=\"checkbox\">";

$pcgrouptagsarray = explode_list($pcgrouptags);

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
<label for=\"$tagid\"><img src=images/tags/$tagicon width=16> $thetag</input></label><br>";
}
}

echo "<br><input class=button type=submit value=\"".pcrtlang("Save Tags")."\"></form>";

echo "</div></div>";

?>
<script type='text/javascript'>
$('#tagchange').click(function(){
  $('#tagselectorbox').toggle('1000');
  $("i",this).toggleClass("fa-chevron-up fa-chevron-down");
});
</script>
<?php


echo "</td></tr></table><br>";


########


$rs_asql = "SELECT * FROM attachments WHERE groupid = '$pcgroupid'";
$rs_result1asql = mysqli_query($rs_connect, $rs_asql);
$total_attachments = mysqli_num_rows($rs_result1asql);

if ($total_attachments > 0) {
echo "<br><table class=\"standard pad10\">";
echo "<tr><th colspan=4>".pcrtlang("Group Attachments")."</th></tr>";
while($rs_result_asql1 = mysqli_fetch_object($rs_result1asql)) {
$attach_id = "$rs_result_asql1->attach_id";
$attach_title = "$rs_result_asql1->attach_title";
$attach_size = "$rs_result_asql1->attach_size";
$attach_filename = "$rs_result_asql1->attach_filename";
$fileextpc = strtolower(substr(strrchr($attach_filename, "."), 1));

$thebytes = formatBytes($attach_size);

echo "<tr><td style=\"text-align:right\"><i class=\"fa fa-paperclip fa-lg\"></i> $fileextpc</td><td>";
echo "<a href=attachment.php?func=get&attach_id=$attach_id class=\"linkbuttonsmall linkbuttongray radiusleft radiusright\"><i class=\"fa fa-download fa-lg\"></i> $attach_title &bull; $thebytes</a></td>";
echo "<td>&nbsp;&nbsp;&nbsp;<a href=\"attachment.php?func=editattach&groupid=$pcgroupid&attach_id=$attach_id\" class=\"linkbuttonsmall linkbuttongray radiusleft\" $therel><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("edit")."</a>";
echo "<a href=\"attachment.php?func=deleteattach&groupid=$pcgroupid&attach_id=$attach_id&attachfilename=$attach_filename\"  class=\"linkbuttonsmall linkbuttongray radiusright\" onClick=\"return confirm('".pcrtlang("Are you sure you wish to permanently delete this Attachment!!!?")."');\"><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("delete")."</a></td></tr>";
}
echo "</table>";
}




echo "</td></tr></table>";


echo "</div>";


echo "<br>";

start_box();


echo "<span class=sizeme20>".pcrtlang("Open Invoice Total").": $money$invgrandtotal</span>";
echo "<span class=sizeme20 style=\"float:right\">".pcrtlang("Closed Invoice Total").": $money$invgrandtotalclosed</span>";

stop_box();
echo "<br>";


if (array_key_exists('groupview', $_REQUEST)) {
$groupview = $_REQUEST['groupview'];
} else {
$groupview = "computers";
}


start_box();
echo "<center><div class=\"linkbuttongraycontainer radiusall\">";
if($groupview == "computers") {
echo "<span class=\"linkbuttongrayselected linkbuttonmedium\"><i class=\"fa fa-gear fa-lg\"></i> ".pcrtlang("Assets/Devices")."</span>";
} else {
echo "<a href=\"group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=computers\" class=\"linkbuttongray linkbuttonmedium\"><i class=\"fa fa-gear fa-lg\"></i> ".pcrtlang("Assets/Devices")."</a>";
}

if($groupview == "wo") {
echo "<span class=\"linkbuttongrayselected linkbuttonmedium\"><i class=\"fa fa-gear fa-lg\"></i> ".pcrtlang("Work Orders")."</span>";
} else {
echo "<a href=\"group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=wo\" class=\"linkbuttongray linkbuttonmedium\"><i class=\"fa fa-clipboard fa-lg\"></i> ".pcrtlang("Work Orders")."</a>";
}

if($groupview == "invoices") {
echo "<span class=\"linkbuttongrayselected linkbuttonmedium\"><i class=\"fa fa-gear fa-lg\"></i> ".pcrtlang("Invoices")."</span>";
} else {
echo "<a href=\"group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=invoices\" class=\"linkbuttongray linkbuttonmedium\"><i class=\"fa fa-file-text fa-lg\"></i> ".pcrtlang("Invoices")."</a>";
}

if($groupview == "receipts") {
echo "<span class=\"linkbuttongrayselected linkbuttonmedium\"><i class=\"fa fa-gear fa-lg\"></i> ".pcrtlang("Receipts")."</span>";
} else {
echo "<a href=\"group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=receipts\" class=\"linkbuttongray linkbuttonmedium\"><i class=\"fa fa-file-text fa-lg\"></i> ".pcrtlang("Receipts")."</a>";
}

if($groupview == "sticky") {
echo "<span class=\"linkbuttongrayselected linkbuttonmedium\"><i class=\"fa fa-gear fa-lg\"></i> ".pcrtlang("Sticky Notes")."</span>";
} else {
echo "<a href=\"group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=sticky\" class=\"linkbuttongray linkbuttonmedium\"><i class=\"fa fa-file-o fa-lg\"></i> ".pcrtlang("Sticky Notes")."</a>";
}

if($groupview == "sms") {
echo "<span class=\"linkbuttongrayselected linkbuttonmedium\"><i class=\"fa fa-mobile fa-lg\"></i> ".pcrtlang("Messages")."</span>";
} else {
echo "<a href=\"group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=sms\" class=\"linkbuttongray linkbuttonmedium\"><i class=\"fa fa-mobile fa-lg\"></i> ".pcrtlang("Messages")."</a>";
}

if($groupview == "forms") {
echo "<span class=\"linkbuttongrayselected linkbuttonmedium\"><i class=\"fa fa-file-alt fa-lg\"></i> ".pcrtlang("Forms")."</span>";
} else {
echo "<a href=\"group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=forms\" class=\"linkbuttongray linkbuttonmedium\"><i class=\"fa fa-file-alt fa-lg\"></i> ".pcrtlang("Forms")."</a>";
}



if(perm_check("34")) {
if($groupview == "credentials") {
echo "<span class=\"linkbuttongrayselected linkbuttonmedium\"><i class=\"fa fa-key fa-lg\"></i> ".pcrtlang("Credentials")."</span><br>";
} else {
echo "<a href=\"group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=credentials\" class=\"linkbuttongray linkbuttonmedium\"><i class=\"fa fa-key fa-lg\"></i> ".pcrtlang("Credentials")."</a><br>";
}
}


if($groupview == "recurringinvoices") {
echo "<span class=\"linkbuttongrayselected linkbuttonmedium\"><i class=\"fa fa-repeat fa-lg\"></i> ".pcrtlang("Recurring Invoices")."</span>";
} else {
echo "<a href=\"group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=recurringinvoices\" class=\"linkbuttongray linkbuttonmedium\"><i class=\"fa fa-repeat fa-lg\"></i> ".pcrtlang("Recurring Invoices")."</a>";
}

if($groupview == "blockcontract") {
echo "<span class=\"linkbuttongrayselected linkbuttonmedium\"><i class=\"fa fa-gear fa-lg\"></i> ".pcrtlang("Block of Time Contracts")."</span>";
} else {
echo "<a href=\"group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=blockcontract\" class=\"linkbuttongray linkbuttonmedium\"><i class=\"fa fa-clock-o fa-lg\"></i> ".pcrtlang("Block of Time Contracts")."</a>";
}

if($groupview == "servicecontracts") {
echo "<span class=\"linkbuttongrayselected linkbuttonmedium\"><i class=\"fa fa-gear fa-lg\"></i> ".pcrtlang("Service Contracts")."</span>";
} else {
echo "<a href=\"group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=servicecontracts\" class=\"linkbuttongray linkbuttonmedium\"><i class=\"fa fa-file fa-lg\"></i> ".pcrtlang("Service Contracts")."</a>";
}

if($groupview == "savedcards") {
echo "<span class=\"linkbuttongrayselected linkbuttonmedium\"><i class=\"fa fa-gear fa-lg\"></i> ".pcrtlang("Saved Credit Cards")."</span>";
} else {
echo "<a href=\"group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=savedcards\" class=\"linkbuttongray linkbuttonmedium\"><i class=\"fa fa-credit-card fa-lg\"></i> ".pcrtlang("Saved Credit Cards")."</a>";
}

if($groupview == "portaldownloads") {
echo "<span class=\"linkbuttongrayselected linkbuttonmedium\"><i class=\"fa fa-download fa-lg\"></i> ".pcrtlang("Portal Downloads")."</span>";
} else {
echo "<a href=\"group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=portaldownloads\" class=\"linkbuttongray linkbuttonmedium\"><i class=\"fa fa-download fa-lg\"></i> ".pcrtlang("Portal Downloads")."</a>";
}


echo "</div></center>";
stop_box();
echo "<br>";



if ($groupview == "computers") {

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
start_blue_box("<i class=\"fa fa-tag fa-lg\"></i> $pcid $pcname 
<a href=\"javascript:void(0);\" class=\"linkbuttontiny linkbuttonopaque radiusall floatright\" id=pcboxbutton$pcid><i class=\"fa fa-chevron-down\"></i></a>");
} else {
start_blue_box("<i class=\"fa fa-tag fa-lg\"></i> $pcid $pcname &bull; $pccompany 
<a href=\"javascript:void(0);\" class=\"linkbuttontiny linkbuttonopaque radiusall floatright\" id=pcboxbutton$pcid><i class=\"fa fa-chevron-down\"></i></a>");
}

echo "<span class=\"boldme sizemelarger\">";
echo pclogo("$pcmake");
echo " $pcmake</span><br>";
#wip
if (mysqli_num_rows($rs_result2) > "10") {
echo "<div id=pcbox$pcid style=\"display:none;\">";
} else {
echo "<div id=pcbox$pcid>";
}


echo "<table width=100%><tr><td width=34% valign=top>";

$rs_findpic = "SELECT * FROM assetphotos WHERE pcid = '$pcid' AND highlight='1'";
$rs_resultpic2 = mysqli_query($rs_connect, $rs_findpic);

if (mysqli_num_rows($rs_resultpic2) != "0") {
$rs_resultpic_q2 = mysqli_fetch_object($rs_resultpic2);
$assetphotoid = "$rs_resultpic_q2->assetphotoid";
echo "<img src=pc.php?func=getpcimage&photoid=$assetphotoid border=1 width=100><br>";
}



echo "</td><td width=26% valign=top>";

echo "<table border=0 cellspacing=0 cellpadding=2><tr><td bgcolor=#777777><i class=\"fa fa-phone fa-lg\" style=\"padding:20px 3px;color:white;\"></i></td><td>";

if($pcphone != "") {
echo "<i class=\"fa fa-home fa-lg fa-fw\"></i> <span class=\"boldme\">$pcphone</span><br>";
}

if($pccellphone != "") {
echo "<i class=\"fa fa-mobile fa-lg fa-fw\"></i>  <span class=\"boldme\">$pccellphone</span><br>";
}

if($pcworkphone != "") {
echo "<i class=\"fa fa-briefcase fa-lg fa-fw\"></i>  <span class=\"boldme\">$pcworkphone</span>";
}

echo "</td></tr></table><br>";



if($pcaddress != "") {
$pcaddressbr = nl2br($pcaddress);
echo "<table cellpadding=2 cellspacing=0 border=0><tr><td bgcolor=#777777><i class=\"fa fa-map-marker fa-lg\" style=\"padding:20px 5px;color:white;\"></i></td><td><span class=\"boldme\">$pcaddressbr</span><br>";
if($pcaddress2 != "") {
echo "<span class=\"boldme\">$pcaddress2</span><br>";
}
if(($pccity != "") && ($pcstate != "") && ($pczip != "")) {
echo "<span class=\"boldme\">$pccity, $pcstate $pczip</span>";
}
echo "</td></tr></table>";
}



if($pcemail != "") {
echo "<br><a href=mailto:$pcemail class=\"linkbuttonmedium linkbuttongray radiusright radiusleft\"><i class=\"fa fa-envelope fa-lg\"></i> $pcemail</a><br>";
}


echo "</td><td width=40% valign=top>";

echo "<a href=pc.php?func=showpc&pcid=$pcid class=\"linkbuttonsmall linkbuttongray displayblock\"><img src=images/right.png class=iconsmall> ".pcrtlang("View Work Order History for this Asset/Device")."</a>";

echo "<a href=group.php?func=removefromgroup&pcgroupid=$pcgroupid&pcid=$pcid onClick=\"return confirm('".pcrtlang("Are you sure you wish to remove this Asset/Customer from this Group?")."');\" class=\"linkbuttonsmall linkbuttongray displayblock\"><img src=images/del.png class=iconsmall> ".pcrtlang("Remove From This Group")."</a>";

echo "<a href=pc.php?func=returnpc2&pcid=$pcid class=\"linkbuttonsmall linkbuttongray displayblock\"><img src=images/return.png class=iconsmall> ".pcrtlang("Create New Work Order for this Asset/Device")."</a>";

echo "<a href=pc.php?func=addpc&copypcid=$pcid class=\"linkbuttonsmall linkbuttongray displayblock\"><img src=images/new.png class=iconsmall> ".pcrtlang("Check in new Asset/Device using Contact Info from this Asset/Device")."</a>";


echo "<a href=group.php?func=syncpctogroup&pcgroupid=$pcgroupid&pcid=$pcid onClick=\"return confirm('".pcrtlang("Are you sure you wish to do this?")."');\" class=\"linkbuttonsmall linkbuttongray displayblock\"><img src=images/syncleft.png class=iconsmall> ".pcrtlang("Sync the Address, Phone, &amp; Email to Group Contact")."</a>";

echo "<a href=group.php?func=syncpcfromgroup&pcgroupid=$pcgroupid&pcid=$pcid onClick=\"return confirm('".pcrtlang("Are you sure you wish to do this?")."');\" class=\"linkbuttonsmall linkbuttongray displayblock\"><img src=images/syncright.png class=iconsmall> ".pcrtlang("Sync the Address, Phone, &amp; Email from Group Contact to this Asset/Device.")."</a>";

echo "</td></tr></table>";

echo "</div>";

?>
<script type='text/javascript'>
$('#pcboxbutton<?php echo "$pcid"; ?>').click(function(){
  $('#pcbox<?php echo "$pcid"; ?>').toggle('1000');
  $("i",this).toggleClass("fa-chevron-up fa-chevron-down");
});
</script>
<?php

stop_blue_box();
echo "<br><br>";

}
start_box();
echo "<h4>".pcrtlang("Add More Customer Assets/Devices to this Group")."</h4><br><br>";
echo "<form action=group.php?func=searchpcaddtogroup method=post>";
echo "<input size=35 class=textbox type=text name=searchterm placeholder=\"".pcrtlang("Enter Part of Customer Name")."\">";
echo "<input type=hidden name=pcgroupid value=$pcgroupid><input type=hidden name=pcname value=\"$pcgroupname\">";
echo "<input class=button type=submit value=\"".pcrtlang("Search for Assets/Devices")."\"></form>";


$assetoptions = "";
$rs_findassettypes = "SELECT * FROM mainassettypes ORDER BY mainassetname ASC";
$rs_resultfat = mysqli_query($rs_connect, $rs_findassettypes);
while($rs_result_qfat = mysqli_fetch_object($rs_resultfat)) {
$mainassettypeidid = "$rs_result_qfat->mainassettypeid";
$mainassetname = "$rs_result_qfat->mainassetname";
$mainassetdefault = "$rs_result_qfat->mainassetdefault";
if($mainassetdefault == "1") {
$assetoptions .= "<option selected value=$mainassettypeidid>$mainassetname</option>";
$mainassettypedefaultid = $mainassettypeidid;
} else {
$assetoptions .= "<option value=$mainassettypeidid>$mainassetname</option>";
}
}





echo "<br><h4>".pcrtlang("Mass Add Assets/Devices")."</h4>";
echo "<form action=group.php?func=massaddtogroup method=post>";
echo "<table class=standard id=assettable><tr><th>".pcrtlang("Customer Name")."</th><th>".pcrtlang("Asset/Device Make/Model")."</th><th>".pcrtlang("Asset/Device Type")."</th><th>".pcrtlang("Asset/Device Notes")."</th><th><a id=\"add\" href=\"javascript:void(0)\" class=\"linkbuttongray linkbuttonmedium radiusall floatright\"><i class=\"fa fa-plus fa-lg\"></i></a></th></tr>";

echo "<tr class=asset><td><input size=35 class=textbox type=text name=customername[]></td>";
echo "<td><input size=20 class=textbox type=text name=assetmake[]></td>";
echo "<td><select name=assettype[] id=assettype>$assetoptions</select></td>";
echo "<td colspan=2><input size=35 class=textbox type=text name=assetnotes[]></td></tr>";

?>

<script type="text/javascript">
    $(document).ready(function() {
        $("#add").click(function() {
          $('#assettable tbody>tr:last').clone(true).insertAfter('#assettable tbody>tr:last');
          return false;
        });
    });
</script>

<?php


echo "</table><input type=hidden name=pcgroupid value=$pcgroupid>";
echo "<input type=hidden name=pccompany value=\"$grpcompany\">";
echo "<input type=hidden name=pcphone value=\"$grpphone\">";
echo "<input type=hidden name=pccellphone value=\"$grpcellphone\">";
echo "<input type=hidden name=pcworkphone value=\"$grpworkphone\">";
echo "<input type=hidden name=pcaddress value=\"$grpaddress\">";
echo "<input type=hidden name=pcaddress2 value=\"$grpaddress2\">";
echo "<input type=hidden name=pccity value=\"$grpcity\">";
echo "<input type=hidden name=pcstate value=\"$grpstate\">";
echo "<input type=hidden name=pczip value=\"$grpzip\">";
echo "<input type=hidden name=pcemail value=\"$grpemail\">";

echo "<input class=button type=submit value=\"".pcrtlang("Add Assets/Devices")."\"></form>";



stop_box();

} elseif ($groupview == "receipts") {


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

#wip


start_blue_box(pcrtlang("Receipts"));
echo "<table class=\"standard pad10\">";
echo "<tr><th>".pcrtlang("Receipt Number")."</th><th>".pcrtlang("Date")."</th><th>".pcrtlang("Sold To")."</th>";
echo "<th>".pcrtlang("Total")."</th></tr>";


$receipt_ids = array();

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

echo "<tr><td><a href=../store/receipt.php?func=show_receipt&receipt=$rs_receipt_id class=\"linkbuttonsmall linkbuttongray radiusall\">#$rs_receipt_id</a></td>";
$rs_date2 = date("n-j-y, g:i a", strtotime($rs_date));
echo "<td>$rs_date2</td>";

echo "<td><span class=\"boldme\">$rs_name</span></td>";

if ($rs_gt < 0) {
echo "<td><span class=\"boldme colormered\">$money$rs_gt</span></td>";
} else {
echo "<td><span class=\"boldme\">$money$rs_gt</span></td>";
}



echo "</tr>";
}
}

echo "</table>";

stop_blue_box();

echo "<br>";

start_box();
echo "<center>";
#browse here
$prevpage = $pageNumber - 1;
$nextpage = $pageNumber + 1;

if ($pageNumber > 1) {
echo "<a href=group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=receipts&pageNumber=$prevpage class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-left fa-lg\"></i></a>";
}

$total_results = $totalentry;
$results_per_page = $results_per_page;
$html = get_paged_nav($total_results, $results_per_page, false);
echo "$html";

if (($totalentry / $results_per_page) > $pageNumber) {
echo "<a href=group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=receipts&pageNumber=$nextpage class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-right fa-lg\"></i></a>";
}

echo "</center>";

stop_box();




} else if ("$groupview" == "invoices") {
/* Start of Invoices  */

if (array_key_exists('pageNumber',$_REQUEST)) {
$pageNumber = $_REQUEST['pageNumber'];
} else {
$pageNumber = 1;
}

$results_per_page = 40;

$offset = ($pageNumber * $results_per_page) - $results_per_page;




start_box();
echo "<h4>".pcrtlang("Add Invoices to this Group")."</h4>";
echo "<form action=group.php?func=searchinvoiceaddtogroup method=post>";
echo "<input size=35 class=textbox type=text name=searchterm placeholder=\"".pcrtlang("Enter Part of Customer Name")."\">";
echo "<input type=hidden name=pcgroupid value=$pcgroupid><input type=hidden name=pcname value=\"$pcgroupname\">";
echo "<input class=button type=submit value=\"".pcrtlang("Search for Invoices")."\"></form>";
stop_box();
echo "<br>";

start_blue_box(pcrtlang("Invoices"));
echo "<table class=\"standard pad10\">";
echo "<tr><th>".pcrtlang("Inv")."#&nbsp;&nbsp;</th><th>".pcrtlang("Customer Name")."&nbsp;&nbsp;</th><th>".pcrtlang("Invoice Date")."&nbsp;&nbsp;</th>";
echo "<th> ".pcrtlang("Total")." &nbsp;&nbsp;</th><th>".pcrtlang("Status")."</th><th>".pcrtlang("Actions")."&nbsp;&nbsp;</th></tr>";

$rs_invoicest = "(SELECT DISTINCT(invoices.invoice_id) FROM invoices, pc_wo, pc_owner WHERE pc_owner.pcgroupid = '$pcgroupid' AND pc_owner.pcid = pc_wo.pcid 
AND invoices.iorq != 'quote' AND (pc_wo.woid = invoices.woid OR invoices.woid LIKE CONCAT('%\_',pc_wo.woid,'\_%'))) 
UNION (SELECT invoices.invoice_id FROM invoices,rinvoices WHERE invoices.rinvoice_id = rinvoices.rinvoice_id AND rinvoices.pcgroupid = '$pcgroupid') 
UNION (SELECT invoice_id FROM invoices WHERE pcgroupid = '$pcgroupid')
UNION (SELECT invoices.invoice_id
FROM invoices,blockcontracthours,blockcontract WHERE blockcontracthours.invoiceid = invoices.invoice_id
AND blockcontract.pcgroupid = '$pcgroupid' AND blockcontract.blockid = blockcontracthours.blockcontractid)";

$rs_find_invoicest = @mysqli_query($rs_connect, $rs_invoicest);
$rs_invoices = "(SELECT DISTINCT(invoices.invoice_id),invoices.invname,invoices.invstatus,invoices.invemail,invoices.woid,invoices.receipt_id,invoices.invdate,
invoices.invcompany,invoices.pcgroupid,invoices.invphone,invoices.invaddy1,invoices.invaddy2,invoices.invcity,invoices.invstate,invoices.invzip FROM invoices, pc_wo, pc_owner WHERE pc_owner.pcgroupid = '$pcgroupid' AND pc_owner.pcid = pc_wo.pcid AND invoices.iorq != 'quote' 
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

echo "<tr><td>$invoice_id</td><td><span class=boldme>$invname</span>";
if ("$invcompany" != "") {
echo "<br>$invcompany";
}
echo "</td><td>$invdate2</td><td><span class=\"boldme\">$money$invtotal</span></td><td>".pcrtlang("$thestatus")."</td>";
echo "<td><a href=../store/invoice.php?func=printinv&invoice_id=$invoice_id class=\"linkbuttonsmall linkbuttongray\"><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Print")."</a>";
echo "<a href=../store/invoice.php?func=emailinv2&invoice_id=$invoice_id&emailaddy=$invemail class=\"linkbuttonsmall linkbuttongray\"><i class=\"fa fa-envelope fa-lg\"></i> ".pcrtlang("Email")."</a>";
if ($invstatus == "1") {
echo "<a href=../store/invoice.php?func=checkoutinv&invoice_id=$invoice_id&woid=$invwoid&custname=$invname_ue&company=$invcompany_ue&custaddy1=$invaddy1_ue&custaddy2=$invaddy2_ue&custcity=$invcity_ue&custstate=$invstate_ue&custzip=$invzip_ue&custphone=$invphone_ue&custemail=$invemail_ue&pcgroupid=$invpcgroupid class=\"linkbuttonsmall linkbuttongray\"><i class=\"fa fa-sign-out fa-lg\"></i> ".pcrtlang("Checkout")."</a>";
echo "<a href=../store/invoice.php?func=changeinvoicestatus&invstatus=3&invoice_id=$invoice_id&returnurl=$returnurl  onClick=\"return confirm('".pcrtlang("Are you sure you wish to void this invoice?")."');\" class=\"linkbuttonsmall linkbuttongray\"><i class=\"fa fa-ban fa-lg\"></i> ".pcrtlang("Void")."</a>";
echo "<a href=../store/invoice.php?func=changeinvoicestatus&invstatus=2&invoice_id=$invoice_id&returnurl=$returnurl  onClick=\"return confirm('".pcrtlang("Are you sure you wish to close this invoice? Usually you want to checkout an invoice so that the invoice gets marked as paid.")."');\" class=\"linkbuttonsmall linkbuttongray\"><i class=\"fa fa-check-square fa-lg\"></i> ".pcrtlang("Close")."</a>";
} else {
if($invrec == "0") {
echo "<a href=../store/invoice.php?func=changeinvoicestatus&invstatus=1&invoice_id=$invoice_id&returnurl=$returnurl  onClick=\"return confirm('".pcrtlang("Are you sure you wish to re-open this invoice?")."');\" class=\"linkbuttonsmall linkbuttongray\"><i class=\"fa fa-repeat fa-lg\"></i> ".pcrtlang("Re-Open this Invoice")."</a>";
}
}
echo "<br>";
if($invwoid != "") {
echo "<br><span class=\"linkbuttonsmall linkbuttongraylabel radiusleft\">".pcrtlang("Work Orders").":</span>";
$invoicestolist = explode_list($invwoid);
foreach($invoicestolist as $key => $woids) {
echo "<a href=../repair/pc.php?func=view&woid=$woids class=\"linkbuttonsmall linkbuttongray\">#$woids</a>";
}
}
if($invrec != "0") {
echo "<br><br><span class=\"linkbuttonsmall linkbuttongraylabel radiusleft\">".pcrtlang("Receipt").":</span>";
echo "<a href=../store/receipt.php?func=show_receipt&receipt=$invrec class=\"linkbuttonsmall linkbuttongray\">#$invrec</a>";
}
echo "</td></tr>";
}
echo "</table>";


stop_blue_box();

echo "<br>";

start_box();
echo "<center>";
#browse here
$totalentry = mysqli_num_rows($rs_find_invoicest);
$prevpage = $pageNumber - 1;
$nextpage = $pageNumber + 1;

if ($pageNumber > 1) {
echo "<a href=group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=invoices&pageNumber=$prevpage class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-left fa-lg\"></i></a>";
}

$total_results = $totalentry;
$results_per_page = $results_per_page;
$html = get_paged_nav($total_results, $results_per_page, false);
echo "$html";
if (($totalentry / $results_per_page) > $pageNumber) {
echo "<a href=group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=invoices&pageNumber=$nextpage class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-right fa-lg\"></i></a>";
}

echo "</center>";
stop_box();


} else if ("$groupview" == "recurringinvoices") {



start_box();
echo "<h4>".pcrtlang("Add Existing Recurring Invoices to this Group")."</h4>";
echo "<form action=group.php?func=searchrinvoiceaddtogroup method=post>";
echo "<input size=35 class=textbox type=text name=searchterm placeholder=\"".pcrtlang("Enter Part of Customer Name")."\">";
echo "<input type=hidden name=pcgroupid value=$pcgroupid><input type=hidden name=pcname value=\"$pcgroupname\">";
echo "<input class=button type=submit value=\"".pcrtlang("Search for Recurring Invoices")."\"></form>";
stop_box();
echo "<br>";



start_color_box("50",pcrtlang("All Recurring Invoices"));
echo "<table class=\"standard pad10\">";
echo "<tr><th>".pcrtlang("Inv ID")."#&nbsp;&nbsp;</th><th>".pcrtlang("Customer Name")."&nbsp;&nbsp;</th>";

if ($activestorecount > 1) {
echo "<th>".pcrtlang("Store")."</th>";
}

echo "<th>".pcrtlang("Invoiced Thru Date")."&nbsp;&nbsp;</th>";
echo "<th> ".pcrtlang("Total")." &nbsp;&nbsp;</th><th>".pcrtlang("Status")."</th><th>".pcrtlang("Actions")."&nbsp;&nbsp;</th></tr>";

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

echo "<tr><td>$rinvoice_id</td><td><span class=\"boldme\">$invname</span>";
if("$invcompany" != "") {
echo "<br>$invcompany";
}


echo "</td>";

if ($activestorecount > 1) {
echo "<td><span class=\"boldme\">$storeinfoarray[storesname]</span></td>";
}

$returnurl = urlencode("../repair/group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=recurringinvoices");

echo "<td>$invthrudate2</td><td><span class=\"boldme\">$money$invtotal</span></td>
<td>".pcrtlang("$thestatus")."</td>";
echo "<td><a href=../store/rinvoice.php?func=viewrinvoice&rinvoice_id=$rinvoice_id&returnurl=$returnurl class=\"linkbuttonsmall linkbuttongray radiusall\">".pcrtlang("View")."</a> ";

echo "</td></tr>";
}
echo "</table>";
stop_color_box();




} else if ("$groupview" == "sticky") {
$rs_ql = "SELECT stickywide FROM users WHERE username = '$ipofpc'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$touchwide = "$rs_result_q1->stickywide";



$rs_findnotes52 = "SELECT stickynotes.stickyid,stickynotes.stickytypeid,stickynotes.stickyaddy1,stickynotes.stickyaddy2,stickynotes.stickycity,
stickynotes.stickystate,stickynotes.stickyzip,stickynotes.stickyphone,stickynotes.stickyemail,stickynotes.stickyduedate,stickynotes.stickyuser,
stickynotes.stickynote,stickynotes.stickyname,stickynotes.refid,stickynotes.reftype,stickynotes.stickycompany FROM stickynotes, pc_wo, pc_owner
WHERE pc_owner.pcgroupid = '$pcgroupid'  AND pc_owner.pcid = pc_wo.pcid AND pc_wo.woid = stickynotes.refid AND stickynotes.reftype = 'woid' UNION
SELECT stickynotes.stickyid,stickynotes.stickytypeid,stickynotes.stickyaddy1,stickynotes.stickyaddy2,stickynotes.stickycity,
stickynotes.stickystate,stickynotes.stickyzip,stickynotes.stickyphone,stickynotes.stickyemail,stickynotes.stickyduedate,stickynotes.stickyuser,
stickynotes.stickynote,stickynotes.stickyname,stickynotes.refid,stickynotes.reftype,stickynotes.stickycompany FROM stickynotes WHERE stickynotes.reftype = 'groupid' AND stickynotes.refid = '$pcgroupid'";


$rs_result_n5 = mysqli_query($rs_connect, $rs_findnotes52);
$totalpcsonbench = mysqli_num_rows($rs_result_n5);

$cellwide = floor((100 / $touchwide));


$a = $touchwide;
echo "<table style=\"width:99%; margin-left:auto;margin-right:auto;\">";

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


if (($a % $touchwide) == 0) {
echo "<tr>";
}


echo "<td style=\"width:$cellwide%; padding:10px;\" valign=top>";
start_box_sn($stickynotecolor,$stickynotecolor2,$stickybordercolor);

echo "<div style=\"background:#$stickybordercolor;padding:5px;margin:-5px;\" class=\"colormewhite sizeme16 boldme\">$stickytypename<br>$stickyname</div>";


if ("$stickycompany" != "") {
echo "<br><span style=\"color:#$stickybordercolor\">$stickycompany</span>";
}

echo "<br><br>$stickynote<br>";

$stickyduedate2 = date("M j, Y, g:i a",strtotime($stickyduedate));
echo "<br><span class=\"sizemesmaller\">".pcrtlang("Date/Due Date").": $stickyduedate2</span>";

if ($stickyuser != "none") {
echo "<br><span class=\"sizemesmaller\">".pcrtlang("Assigned To").": $stickyuser</span>";
}

if ($stickyaddy1 != "") {
echo "<br><span class=\"sizemesmaller\">$stickyaddy1</span>";
}

if ($stickyaddy2 != "") {
echo "<br><span class=\"sizemesmaller\">$stickyaddy2</span>";
}
if (($stickycity != "") || ($stickystate != "") || ($stickyzip != "")){
echo "<br><span class=\"sizemesmaller\">$stickycity, $stickystate $stickyzip</span>";
}

if ($stickyphone != "") {
echo "<br><span class=\"sizemesmaller\">$stickyphone</span>";
}

if ($stickyemail != "") {
echo "<br><br><a href=\"mailto:$stickyemail\" class=\"linkbuttonsmall linkbuttonopaque radiusall\"><i class=\"fa fa-envelope fa-lg\"></i> $stickyemail</a>";
}

if ($refid != "0") {
if ($reftype == "woid") {
echo "<br><br><a href=\"index.php?pcwo=$refid\" class=\"linkbuttonsmall linkbuttonopaque radiusall\">".pcrtlang("Work Order")." #$refid</a>";
} elseif ($reftype == "pcid") {
echo "<br><br><a href=\"pc.php?func=showpc&pcid=$refid\" class=\"linkbuttonsmall linkbuttonopaque radiusall\">".pcrtlang("PCID")." #$refid</a>";
}
}
echo "<br><br><a href=sticky.php?func=printsticky&stickyid=$stickyid class=\"linkbuttonsmall linkbuttonopaque radiusall\"><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Print")."</a><br><br>";


stop_box();

echo "</td>";


$a++;

if (($a % $touchwide) == 0) {
echo "</tr>";
}



}

$startwhile = ($touchwide - ($totalpcsonbench % $touchwide));
if (($totalpcsonbench % $touchwide) >= "1") {
$endwhile = 0;
while($startwhile > $endwhile) {
echo "<td width=$cellwide%>&nbsp;</td>";
$endwhile++;
}
}


if ($startwhile != "0") {
echo "</tr>";
}

echo "</table>";



##############################################################################################################################################
} else if ("$groupview" == "sms") {

if (isset($_REQUEST['scrollto'])) {
$scrollto = $_REQUEST['scrollto'];
} else {
$scrollto = "top";
}


$smsphonenumberoptions = "";
$phnumbers = array();
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

$emails = array();
if (filter_var($grpemail, FILTER_VALIDATE_EMAIL)) {
$emails[] = "$grpemail";
}

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

foreach($emails as $key => $val) {
$numberstosearch .= " OR messagefrom = '$val'";
}

foreach($phnumbers as $key => $val) {
$numberstosearch .= " OR messagefrom LIKE '%".substr("$val", -7)."'";
$numberstosearch .= " OR TRIM(REPLACE(REPLACE(messagefrom,'-',''),' ','')) LIKE '%".substr("$val", -7)."'";
$numberstosearch .= " OR  TRIM(REPLACE(REPLACE(messageto,'-',''),' ',''))  LIKE '%".substr("$val", -7)."'";
$numberstosearch .= " OR messageto LIKE '%".substr("$val", -7)."'";
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

echo "<div id=messages></div>";

echo "<table style=\"width:100%\"><tr><td><span class=\"sizeme16 boldme\">&nbsp;".pcrtlang("Messages").": </span><span class=\"sizeme16\">($pcgroupname)</span> 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=sms&scrollto=messages\" class=\"linkbuttonsmall linkbuttongray radiusall\"><i class=\"fa fa-refresh fa-lg\"></i> ".pcrtlang("Refresh")."</a>
</td><td>";
echo "<a href=\"javascript:void(0);\" id=addmessage class=linkbutton style=\"float:right\">
<i class=\"fa fa-paper-plane fa-lg\"></i> ".pcrtlang("Send Message")."</a></td>
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

echo "<table class=standard><tr>";

echo "<tr><th>".pcrtlang("Send SMS")." ($mysmsgateway)</th><th>".pcrtlang("Call Log/Send Message")."</th></tr>";

echo "<td style=\"width:50%\">";

start_box();

if ($mysmsgateway != "none") {

echo "<form action=sms.php?func=smssend2 method=post name=theform>";

echo "<input type=hidden name=groupid value=$pcgroupid>";
echo "<input type=hidden name=noajax value=no>";

if($smsphonenumberoptions != "") {
echo "<select name=smsnumber>$smsphonenumberoptions</select><br>";
} else {
echo "<input type=text name=smsnumber class=textbox placeholder=\"Enter Mobile Number\"><br>";
}

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
echo "<input type=hidden name=groupid value=$pcgroupid><textarea style=\"width:300px;\" rows=2 name=smsmessage id=smsmessage class=textbox name=smsbox></textarea>";

echo "<br><span class=colormegreen>".pcrtlang("Characters Remaining").": <span id=\"charsLeft\"></span></span>";
echo "<br><input type=submit value=\"".pcrtlang("Send SMS")."\" class=ibutton>";

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


echo "</td><td style=\"vertical-align:top;\">";
start_box();
echo "<form action=group.php?func=addmessage method=post><input type=hidden name=groupid value=$pcgroupid>";
echo "<textarea name=themessage required=required class=textboxw style=\"width:95%;height:90px;\" placeholder=\"".pcrtlang("Enter Call Notes")."\"></textarea>";
echo "<div class=startbox><input type=radio name=type value=1 checked> ".pcrtlang("Call Log Note")."</div>";
echo "<div class=startbox><input type=radio name=type value=2> ".pcrtlang("Portal Message")."</div>";
echo "<div class=startbox><input type=radio name=type value=3> ".pcrtlang("Send Email")."<br>";
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

echo "</select>";
echo "</div>";



echo "<br><button type=submit class=sbutton><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button>";
echo "</form>";
stop_box();
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
echo "<tr><td><i class=\"fa fa-reply fa-fw fa-lg colormeblue\"></i> $viaicon <span>$messagefrom</span> </td>";
echo "<td><i class=\"fa fa-clock-o fa-lg\"></i> <span>$messagedatetime</span> </td>";
echo "<td style=\"width:50%\"><div class=\"max-height:200px;overflow-y:auto;scrollbar-width: thin;\"><i class=\"fa fa-comment fa-fw fa-lg\"></i> $messagebody</div> $imageatt</td><td>";
echo "</td>";
} elseif($messagedirection == "out") {
echo "<tr><td>$viaicon <i class=\"fa fa-share fa-fw fa-lg\"></i> <span>$messagefrom</span> </td>";
echo "<td><i class=\"fa fa-clock-o fa-lg\"></i> <span>$messagedatetime</span> </td>";
echo "<td style=\"width:50%\"><div class=\"max-height:200px;overflow-y:auto;scrollbar-width: thin;\"><i class=\"fa fa-comment fa-fw fa-lg\"></i> $messagebody</div> </td><td>";
echo "</td>";
} else {
echo "<tr><td><i class=\"fa fa-user-md fa-fw fa-lg\"></i> <span>$messagefrom</span> </td>";
echo "<td><i class=\"fa fa-clock-o fa-lg\"></i> <span>$messagedatetime</span> </td>";
echo "<td style=\"width:50%\"><div class=\"max-height:200px;overflow-y:auto;scrollbar-width: thin;\"><i class=\"fa fa-comment fa-fw fa-lg\"></i> $messagebody</div> </td><td>";
echo "</td>";
}

echo "<td>";

if(perm_check("33")) {
$requri = urlencode($_SERVER['REQUEST_URI']);
echo "<a href=\"messages.php?func=deletemessage&messageid=$messageid&requri=$requri\"
class=\"linkbuttontiny linkbuttonred radiusall\" style=\"margin:3px;\" onClick=\"return confirm('".pcrtlang("Are you sure you want to delete this message?")."')\">";
echo "<i class=\"fa fa-times\"></i></a><br>";
}


echo "</td></tr>";

}

echo "</table><br>";

echo "<center>";
#browse here

if($pageNumber != 1) {
$prevpage = $pageNumber - 1;
echo "<a href=group.php?func=viewgroup&groupview=sms&pageNumber=$prevpage&pcgroupid=$pcgroupid
class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-left fa-lg\"></i></a> ";
}

$results_per_page = $results_per_page;
$html = get_paged_nav($totalentries, $results_per_page, false);
echo "$html";

if($lastpage != $pageNumber) {
$nextpage = $pageNumber + 1;
echo "<a href=group.php?func=viewgroup&groupview=sms&pageNumber=$nextpage&pcgroupid=$pcgroupid
class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-right fa-lg\"></i></a>";
}

echo "</center>";



?>

<script type='text/javascript'>
function scrollToElement(ele) {
    $(window).scrollTop(ele.offset().top-50).scrollLeft(ele.offset().left);
}

scrollToElement($('#<?php echo "$scrollto"; ?>'));
</script>

<?php


###############################################################################################################################################
} else if ("$groupview" == "wo") {
/* Start of Work Orders  */

if (array_key_exists('pageNumber',$_REQUEST)) {
$pageNumber = $_REQUEST[pageNumber];
} else {
$pageNumber = 1;
}

$results_per_page = 40;

$offset = ($pageNumber * $results_per_page) - $results_per_page;







start_blue_box(pcrtlang("Work Orders"));
echo "<table class=standard>";
echo "<tr><th>".pcrtlang("WO ID")."#&nbsp;&nbsp;</th><th>".pcrtlang("Name")."&nbsp;&nbsp;</th><th>WO Date&nbsp;&nbsp;</th>";
echo "<th> ".pcrtlang("Make")." &nbsp;&nbsp;</th><th>".pcrtlang("Problem/Task")."</th></tr>";

$rs_wot = "SELECT pc_wo.woid FROM pc_wo, pc_owner WHERE pc_owner.pcgroupid = '$pcgroupid' AND pc_owner.pcid = pc_wo.pcid";
$rs_find_wot = @mysqli_query($rs_connect, $rs_wot);

$rs_wo = "SELECT pc_wo.woid,pc_wo.probdesc,pc_wo.dropdate,pc_wo.pcid,pc_wo.pcstatus FROM pc_wo, pc_owner WHERE pc_owner.pcgroupid = '$pcgroupid' AND pc_owner.pcid = pc_wo.pcid ORDER BY pc_wo.dropdate DESC LIMIT $offset,$results_per_page";

$rs_find_wo = @mysqli_query($rs_connect, $rs_wo);
while($rs_find_wo_q = mysqli_fetch_object($rs_find_wo)) {
$woid = "$rs_find_wo_q->woid";
$probdesc = "$rs_find_wo_q->probdesc";
$dropdate = "$rs_find_wo_q->dropdate";
$pcid = "$rs_find_wo_q->pcid";
$dropdate2 = date("F j, Y", strtotime($dropdate));
$pcstatus = "$rs_find_wo_q->pcstatus";

$boxstyles = getboxstyle("$pcstatus");



$findcompname = "SELECT * FROM pc_owner WHERE pcid = '$pcid'";
$findcompq = @mysqli_query($rs_connect, $findcompname);
$findcompa = mysqli_fetch_object($findcompq);
$compname = "$findcompa->pcname";
$compcompany = "$findcompa->pccompany";
$compmake = "$findcompa->pcmake";


echo "<tr><td class=nowrap><i class=\"fa fa-bookmark fa-lg\" style=\"color:#$boxstyles[selectorcolor]\"></i> <a href=\"index.php?pcwo=$woid\" class=\"linkbuttonsmall linkbuttongray radiusright radiusleft\">#$woid</a></td><td><span class=\"boldme\">$compname</span></td><td>$dropdate2</td><td><span class=\"boldme\">$compmake</span>";
if("$compcompany" != "") {
echo "<br>$compcompany";
}
echo "</td><td>$probdesc</td></tr>";
}
echo "</table>";


stop_blue_box();

echo "<br>";

start_box();
echo "<center>";
#browse here
$totalentry = mysqli_num_rows($rs_find_wot);
$prevpage = $pageNumber - 1;
$nextpage = $pageNumber + 1;

if ($pageNumber > 1) {
echo "<a href=group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=wo&pageNumber=$prevpage class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-left fa-lg\"></i></a>";
}

$total_results = $totalentry;
$results_per_page = $results_per_page;
$html = get_paged_nav($total_results, $results_per_page, false);
echo "$html";
if (($totalentry / $results_per_page) > $pageNumber) {
echo "<a href=group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=wo&pageNumber=$nextpage class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-right fa-lg\"></i></a>";
}

echo "</center>";
stop_box();

#blockoftime

} else if ("$groupview" == "blockcontract") {

start_box();

echo "<a href=blockcontract.php?func=newcontract&pcgroupid=$pcgroupid $therel class=linkbutton><img src=images/wohistory.png class=iconregular> ".pcrtlang("New Block of Time Contract")."</a>&nbsp;";

stop_box();

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

start_blue_box("$blocktitle");
echo "<table style=\"width:100%\">";
echo "<tr><td style=\"vertical-align:top;width:20%\"><span class=boldme>".pcrtlang("Start Date").":</span></td><td style=\"vertical-align:top;width:50%\">$blockstart</td>";

echo "<td rowspan=2>";

$rs_checkrinvoice2 = "SELECT * FROM rinvoices WHERE blockcontractid = '$blockid'";
$rs_result_rci2 = mysqli_query($rs_connect, $rs_checkrinvoice2);


if($contractclosed == 0) {
echo "<a href=blockcontract.php?func=starttimerbc&pcgroupid=$pcgroupid&blockcontractid=$blockid $therel class=\"linkbuttonsmall linkbuttongray displayblock\"><img src=images/clock.png class=iconsmall> ".pcrtlang("Start New Timer")."</a>";
echo "<a href=pc.php?func=timerstartmanual&pcgroupid=$pcgroupid&blockcontractid=$blockid class=\"linkbuttonsmall linkbuttongray displayblock\"><img src=images/clock.png class=iconsmall> ".pcrtlang("Add Manual Time")."</a>";
echo "<a href=blockcontract.php?func=addhourssingle&pcgroupid=$pcgroupid&blockcontractid=$blockid&blocktitle=$blocktitle_ue $therel class=\"linkbuttonsmall linkbuttongray displayblock\"><img src=images/invoice.png class=iconsmall> ".pcrtlang("Add Hours/Invoice")."</a>";
if (mysqli_num_rows($rs_result_rci2) == "0") {
echo "<a href=blockcontract.php?func=addhoursrecurring&pcgroupid=$pcgroupid&blockcontractid=$blockid&blocktitle=$blocktitle_ue $therel class=\"linkbuttonsmall linkbuttongray displayblock\">
<img src=../store/images/rinvoice.png class=iconsmall> ".pcrtlang("Add Recurring Hours/Invoice")."</a>";
} else {
$rs_result_qrci2 = mysqli_fetch_object($rs_result_rci2);
$rinvoice_id2 = "$rs_result_qrci2->rinvoice_id";
echo "<a href=../store/rinvoice.php?func=viewrinvoice&rinvoice_id=$rinvoice_id2 class=\"linkbuttonsmall linkbuttongray displayblock\"><img src=../store/images/rinvoice.png class=iconsmall> ".pcrtlang("Recurring Invoice")." #$rinvoice_id2</a>";

$rs_findsc = "SELECT * FROM servicecontracts WHERE rinvoice = '$rinvoice_id2'";
$rs_resultsc = mysqli_query($rs_connect, $rs_findsc);

if(mysqli_num_rows($rs_resultsc) != 0) {
$rs_resultsc_q = mysqli_fetch_object($rs_resultsc);
$scid = "$rs_resultsc_q->scid";
$scname = "$rs_resultsc_q->scname";

echo  "<a href=msp.php?func=viewservicecontract&scid=$scid class=\"linkbuttonsmall linkbuttongray displayblock\"><img src=images/contract.png class=iconsmall> ".pcrtlang("Service Contract").": $scname</a>";


}


}
echo "<a href=blockcontract.php?func=contractclosed&contractclosed=1&pcgroupid=$pcgroupid&blockcontractid=$blockid class=\"linkbuttonsmall linkbuttongray displayblock\">
<img src=../store/images/right.png class=iconsmall> ".pcrtlang("Close this Contract")."</a>";
echo "<a href=blockcontract.php?func=editcontract&pcgroupid=$pcgroupid&blockcontractid=$blockid $therel class=\"linkbuttonsmall linkbuttongray displayblock\">
<img src=images/woedit.png class=iconsmall> ".pcrtlang("Edit this Contract")."</a>";
} else {
echo "<a href=blockcontract.php?func=contractclosed&contractclosed=0&pcgroupid=$pcgroupid&blockcontractid=$blockid class=\"linkbuttonsmall linkbuttongray displayblock\">
<img src=images/right.png class=iconsmall> ".pcrtlang("Re-Open this Contract")."</a>";
}

echo "<a href=group.php?func=bcreport&blockid=$blockid class=\"linkbuttonsmall linkbuttongray displayblock\">
<img src=images/print.png class=iconsmall> ".pcrtlang("Print Report")."</a>";

if (!filter_var($grpemail, FILTER_VALIDATE_EMAIL) === false) {
echo "<a href=group.php?func=bcreportemail&blockid=$blockid&pcgroupid=$pcgroupid&to=$grpemail class=\"linkbuttonsmall linkbuttongray displayblock\">
<img src=images/email.png class=iconsmall> ".pcrtlang("Email Report")."</a>";
}

echo "</td>";

echo "</tr>";
echo "<tr><td style=\"vertical-align:top\"><span class=\"boldme\">".pcrtlang("Notes").":</span></td><td style=\"vertical-align:top\">$blocknote</td></tr>";
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

echo "<table class=\"standard pad10\">";
echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><th style=\"text-align:right;\">".pcrtlang("Actual")."</th><th style=\"text-align:right;\">".pcrtlang("Applied")."</th><th style=\"text-align:right;\">".pcrtlang("Totals")."</th></tr>";


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
echo "<tr><td style=\"border-left: #F2AD0E 10px solid;\"><span class=\"boldme\">$timername</span>";
if($woid != "0") {
echo "<a href=\"index.php?pcwo=$woid\" class=\"linkbuttonsmall linkbuttongray\">WO #$woid</a><a href=\"blockcontract.php?func=removefromcontract&timer=$timerid&pcgroupid=$pcgroupid\" class=\"linkbuttonsmall linkbuttongray\">remove from contract</a>";
}

echo "</td><td><span class=\"boldme\">$timerbyuser</span> </td>
<td><span class=colormegreen>$timerstartdate2 $timerstarttime2</span></td>
<td>";

?>
 <span class=colormered><i class="fa fa-spinner fa-lg fa-spin"></i></span> 
<label id="<?php echo "$timerid"; ?>hours" class="textred12b">0</label><span class=colormered>:</span><label id="<?php echo "$timerid"; ?>minutes" class="textred12b">00</label><span class=colormered>:</span><label id="<?php echo "$timerid"; ?>seconds" class="textred12b">00</label>
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


echo "</td><td colspan=2>";
if($contractclosed == 0) {
echo "<form class=displayinline action=pc.php?func=timereditprog&pcgroupid=$pcgroupid&blockcontractid=$blockid&timerid=$timerid method=post><button type=submit class=\"linkbuttonsmall linkbuttongray radiusleft displayinline\" ><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("Edit")."</button></form>";
echo "<form class=displayinline action=pc.php?func=timerstop&pcgroupid=$pcgroupid&blockcontractid=$blockid&timerid=$timerid method=post><button type=submit class=\"linkbuttonsmall linkbuttonred radiusright displayinline\"><i class=\"fa fa-stop fa-lg\"></i> ".pcrtlang("Stop")."</form>";
}
echo "</td><td></td><td></td><td></td><td></td><td></td></tr>";

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



echo "<tr><td style=\"vertical-align:top; border-left: #FF4938 10px solid;\"><span class=\"boldme\">$timername</span>";

if($woid != "0") {
echo "<br><a href=\"index.php?pcwo=$woid\" class=\"linkbuttonsmall linkbuttongray\">WO #$woid</a><a href=\"blockcontract.php?func=removefromcontract&timer=$timerid&pcgroupid=$pcgroupid\" class=\"linkbuttonsmall linkbuttongray\">remove from contract</a>";
}


echo "</td><td><span class=\"boldme\">$timerbyuser</span></td>
<td><span class=colormegreen>$timerstartdate2 $timerstarttime2</span></td>
<td><span class=colormered>$timerstoptime2</span></td><td colspan=4>";
if($contractclosed == 0) {
echo "<form class=displayinline action=pc.php?func=timerdelete&pcgroupid=$pcgroupid&blockcontractid=$blockid&timerid=$timerid method=post><button type=submit class=\"linkbuttonsmall linkbuttonred radiusleft displayinline\"><i class=\"fa fa-times fa-lg\"></i> ".pcrtlang("Delete")."</button></form>";
echo "<form class=displayinline action=pc.php?func=timeredit&pcgroupid=$pcgroupid&blockcontractid=$blockid&timerid=$timerid method=post><button type=submit class=\"linkbuttonsmall linkbuttongray displayinline\"><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("Edit")."</button></form>";
echo "<form class=displayinline action=pc.php?func=timerstart&pcgroupid=$pcgroupid&blockcontractid=$blockid method=post><input type=hidden name=timername value=\"$timername\"><button type=submit class=\"linkbuttonsmall linkbuttongreen displayinline\"><i class=\"fa fa-play fa-lg\"></i> ".pcrtlang("Resume")."</button></form>";
echo "<button class=\"linkbuttonsmall linkbuttongray radiusright displayinline\" onClick=\"parent.location='blockcontract.php?func=roundblock&pcgroupid=$pcgroupid&timerid=$timerid'\"><i class=\"fa fa-circle-o fa-lg\"></i> ".pcrtlang("Round")."</button>";
}

echo "</td><td style=\"text-align:right;\"><span class=\"boldme\">$timeusedact</span></td><td style=\"text-align:right;\"><span class=\"boldme\">-$timeused</span></td><td style=\"text-align:right;\">$timebalance</td></tr>";

}





} else {
#timercode stop
#line item start


$blockhours = $subarray['blockhours'];
$thedateonly = $subarray['thedateonly'];
$invoiceid = $subarray['invoiceid'];

$rs_checkinvoice = "SELECT invstatus FROM invoices WHERE invoice_id = '$invoiceid'";
$rs_result_ci = mysqli_query($rs_connect, $rs_checkinvoice);
$rs_result_qci = mysqli_fetch_object($rs_result_ci);
$invstatus = "$rs_result_qci->invstatus";


if($invstatus == 2) {
$runningtime = $runningtime + (3600 * $blockhours);
} else {
$runningtime = $runningtime;
}

$timebalance = mf($runningtime / 3600);

echo "<tr><td colspan=2 style=\"vertical-align:top; border-left: #98D25F 10px solid;\"><span class=\"boldme\">".pcrtlang("Purchased Hours")."</span>";



if(($invstatus == 3) && ($contractclosed == 0)) {
echo "<a href=blockcontract.php?func=deletehoursinvoice&pcgroupid=$pcgroupid&blockcontracthoursid=$blockcontracthoursid class=\"linkbuttonsmall linkbuttongray\">delete</a>";
}

echo "</td><td><span class=\"boldme\">$thedateonly</span></td>";
echo "<td colspan=5><a href=../store/invoice.php?func=printinv&invoice_id=$invoiceid class=\"linkbuttonsmall linkbuttongray\">".pcrtlang("Invoice")." #$invoiceid</a>";

if($invstatus != 2) {
echo " (".pcrtlang("Unpaid").")";
}

$rs_checkrinvoice = "SELECT * FROM rinvoices WHERE blockcontractid = '$blockid'";
$rs_result_rci = mysqli_query($rs_connect, $rs_checkrinvoice);

if (mysqli_num_rows($rs_result_rci) == "1") {
$rs_result_qrci = mysqli_fetch_object($rs_result_rci);
$rinvoice_id = "$rs_result_qrci->rinvoice_id";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=../store/rinvoice.php?func=viewrinvoice&rinvoice_id=$rinvoice_id class=\"linkbuttonsmall linkbuttongray\">".pcrtlang("Recurring Invoice")." #$rinvoice_id</a>";
}


echo "</td>";

echo "<td style=\"text-align:right;\"><span class=\"boldme\">+".mf("$blockhours")."</span></td>";

if($invstatus != 2) {
echo "<td style=\"text-align:right;\"><span class=\"boldme\">+".mf("0")."</span></td>";
} else {
echo "<td style=\"text-align:right;\"><span class=\"boldme\">+".mf("$blockhours")."</span></td>";
}

echo "<td style=\"text-align:right;\">$timebalance</td></tr>";


}


}


echo "<tr><td colspan=11 style=\"text-align:right;\"><span class=\"boldme\">".pcrtlang("Remaining Time").": $timebalance</span></td></tr>";

$rs_update_h = "UPDATE blockcontract SET hourscache = '$timebalance' WHERE blockid = '$blockid'";
@mysqli_query($rs_connect, $rs_update_h);


echo "</table>";


stop_blue_box();

echo "<br>";

}



} else if ("$groupview" == "servicecontracts") {






start_color_box("50",pcrtlang("Managed Service Contracts"));

echo "<a href=\"msp.php?func=newservicecontract&personname=$ue_pcgroupname&pcgroupid=$pcgroupid\" class=linkbutton><img src=images/contract.png class=iconregular> ".pcrtlang("Create Service Contract")."</a><br><br>";


echo "<table class=\"standard pad10\">";
echo "<tr><th>".pcrtlang("ID")."#&nbsp;&nbsp;</th><th>".pcrtlang("Contact Name")."&nbsp;&nbsp;</th>";

echo "<th>".pcrtlang("Contact Person")."</th>";

echo "<th>".pcrtlang("Start Date")."&nbsp;&nbsp;</th>";
echo "<th>".pcrtlang("Expiration Date")."&nbsp;&nbsp;</th>";
echo "<th>".pcrtlang("Status")."&nbsp;&nbsp;</th>";
echo "<th>".pcrtlang("Actions")."&nbsp;&nbsp;</th></tr>";


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
$thestatus = "Active";
} else {
$thestatus = "<span class=colormered>Inactive</span>";
}

echo "<tr><td>$scid</td><td><span class=\"boldme\">$scname</span>";

if($rinvoice != 0) {
if(overduerinvoice($rinvoice) == 1) {
echo "<br><span class=colormered><i class=\"fa fa-warning fa-lg\"></i> Service Contract has Overdue Invoices!</span>";
}
}



echo "</td>";

echo "<td><span class=\"boldme\">$sccontactperson</span></td>";

$returnurl = urlencode("../repair/group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=servicecontracts");

echo "<td>$scstartdate</td><td><span class=\"boldme\">$scexpdate</span></td>";

echo "<td>$thestatus</td>";

echo "<td><a href=msp.php?func=viewservicecontract&scid=$scid&returnurl=$returnurl class=\"linkbuttonsmall linkbuttongray radiusleft\">".pcrtlang("View")."</a>";

if($scactive == 1) {
echo "<a href=msp.php?func=scactive&scid=$scid&rinvoice=$rinvoice&groupid=$pcgroupid&scactive=0 class=\"linkbuttonsmall linkbuttongray radiusright\">".pcrtlang("Deactivate")."</a>";
} else {
echo "<a href=msp.php?func=scactive&scid=$scid&rinvoice=$rinvoice&groupid=$pcgroupid&scactive=1 class=\"linkbuttonsmall linkbuttongray radiusright\">".pcrtlang("Activate")."</a>";
}


echo "</td></tr>";
}
echo "</table>";


} else if ("$groupview" == "savedcards") {

if(isset($storedpaymentplugins)) {

foreach($storedpaymentplugins as $key => $val) {

echo "<div class=\"groupbox colorbox\">";

echo "<h4>$val</font></h4>";

?>

<script type="text/javascript">
  $.get('../store/<?php echo "$val"; ?>_stored.php?func=view&groupid=<?php echo "$pcgroupid"; ?>', function(data) {
    $('#plugin<?php echo "$key"; ?>').html(data);
  });
</script>
<div id="plugin<?php echo "$key"; ?>"></div>

<?php




echo "</div><br>";

}

} else {
echo pcrtlang("No stored cards defined...");
}



} else if ("$groupview" == "credentials") {

if(perm_check("34")) {

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
echo "<form action=pc.php?func=newpass method=post><input type=hidden name=groupid value=$pcgroupid><input type=hidden name=credtype value=1><input type=hidden name=returnto value=group>";

$rs_cd = "SELECT * FROM creddesc ORDER BY creddescorder DESC";
$rs_resultcd1 = mysqli_query($rs_connect, $rs_cd);
$creddescoptions = "<option value=\"\">".pcrtlang("pick one or write your own below")."</option>";
while($rs_result_cdq1 = mysqli_fetch_object($rs_resultcd1)) {
$credtitle = "$rs_result_cdq1->credtitle";
$creddescoptions .= "<option value=\"$credtitle\">$credtitle</option>";
}

echo "<select name=creddesc onchange='document.getElementById(\"creddesc1box\").value=this.options[this.selectedIndex].value '>";
echo "$creddescoptions";
echo "</select><br>";
echo "<input type=text class=textbox id=creddesc1box name=creddesc style=\"width:250px\" placeholder=\"".pcrtlang("Description")."\"><br>";

echo "<input type=text class=textbox name=username placeholder=\"".pcrtlang("Enter Username")."\"> ";
echo "<input type=text class=textbox name=password placeholder=\"".pcrtlang("Enter Password")."\">";
echo "<button type=submit class=sbutton><i class=\"fa fa-save\"></i></button>";


echo "</form></div>";

echo "<div id=pass2box style=\"display:none;border:2px #cccccc solid;padding:5px;border-radius:3px;\">";
echo "<form action=pc.php?func=newpass method=post><input type=hidden name=groupid value=$pcgroupid><input type=hidden name=credtype value=2><input type=hidden name=returnto value=group>";
echo "<select name=creddesc onchange='document.getElementById(\"creddesc2box\").value=this.options[this.selectedIndex].value '>";
echo "$creddescoptions";
echo "</select><br>";
echo "<input type=text class=textbox id=creddesc2box name=creddesc placeholder=\"".pcrtlang("Description")."\"><br>";
echo "<input type=text class=textbox name=password placeholder=\"".pcrtlang("Enter Pin")."\"> ";
echo "<button type=submit class=sbutton><i class=\"fa fa-save\"></i></button>";
echo "</form></div>";


echo "<div id=pass3box style=\"display:none;border:2px #cccccc solid;padding:5px;border-radius:3px;\">";
echo "<div id=patternmain></div>";
echo "<form action=pc.php?func=newpass method=post><input type=hidden name=groupid value=$pcgroupid><input type=hidden name=credtype value=3><input type=hidden name=returnto value=group>";
echo "<select name=creddesc1 onchange='document.getElementById(\"creddesc3box\").value=this.options[this.selectedIndex].value '>";
echo "$creddescoptions";
echo "</select><br>";
echo "<input type=text class=textbox id=creddesc3box name=creddesc style=\"width:250px\" placeholder=\"".pcrtlang("Description")."\">";
echo "<input type=hidden class=textbox name=newpattern id=patterntextbox> ";
echo "<button type=submit class=sbutton><i class=\"fa fa-save\"></i></button>";
echo "</form>";
echo "</div>";


echo "<div id=pass5box style=\"display:none;border:2px #cccccc solid;padding:5px;border-radius:3px;\">";
echo "<form action=pc.php?func=newpass method=post><input type=hidden name=groupid value=$pcgroupid><input type=hidden name=credtype value=5><input type=hidden name=returnto value=group>";

echo "<select name=creddesc onchange='document.getElementById(\"creddesc5box\").value=this.options[this.selectedIndex].value '>";
echo "$creddescoptions";
echo "</select><br>";
echo "<input type=text class=textbox id=creddesc5box name=creddesc style=\"width:250px\" placeholder=\"".pcrtlang("Description")."\"><br>";

echo "<input type=text class=textbox name=username style=\"width:350px\" placeholder=\"".pcrtlang("Enter Security Question")."\"><br>";
echo "<input type=text class=textbox name=password style=\"width:320px\" placeholder=\"".pcrtlang("Enter Answer")."\">";
echo "<button type=submit class=sbutton><i class=\"fa fa-save\"></i></button>";


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
echo "<table class=\"$badgestyle\"><tr><td><i class=\"fa fa-lock fa-2x\"></i></td>";
echo "<td><strong>$creddesc</strong><span class=floatright>$creddate</span><br><i class=\"fa fa-user\"></i> $creduser
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class=\"fa fa-key\"></i> $credpass";
echo "<br><span class=floatright>";

echo "<a href=\"pc.php?func=editcred&credid=$credid&credtype=$credtype&groupid=$pcgroupid&returnto=group\" class=\"linkbuttonsmall linkbuttongray radiusleft\" rel=facebox>
<i class=\"fa fa-edit fa-lg\"></i></a>";
echo "<a href=\"pc.php?func=deletecred&credid=$credid&groupid=$pcgroupid&returnto=group\" class=\"linkbuttonsmall linkbuttongray radiusall\"
onClick=\"return confirm('".pcrtlang("Are you sure you want to delete this credential?")."')\"><i class=\"fa fa-trash fa-lg\"></i></a>";
echo "</span></td></tr></table>";
}

if($credtype == 2) {
echo "<table class=\"$badgestyle\"><tr><td><i class=\"fa fa-thumb-tack fa-2x\"></i></td>";
echo "<td><strong>$creddesc</strong><span class=floatright>$creddate</span><br><i class=\"fa fa-thumb-tack\"></i> $credpass";
echo "<br><span class=floatright>";

echo "<a href=\"pc.php?func=editcred&credid=$credid&credtype=$credtype&groupid=$pcgroupid&returnto=group\" class=\"linkbuttonsmall linkbuttongray radiusall\" rel=facebox>
<i class=\"fa fa-edit fa-lg\"></i></a>";
echo "<a href=\"pc.php?func=deletecred&credid=$credid&groupid=$pcgroupid&returnto=group\" class=\"linkbuttonsmall linkbuttongray radiusall\"
onClick=\"return confirm('".pcrtlang("Are you sure you want to delete this PIN?")."')\"><i class=\"fa fa-trash fa-lg\"></i></a>";
echo "</span></td></tr></table>";
}
if($credtype == 3) {
echo "<table class=\"$badgestyle\"><tr><td><i class=\"fa fa-th fa-2x\"></i></td>";
echo "<td><strong>$creddesc</strong><span class=floatright>$creddate</span><br>";
echo draw3x3("$patterndata","normal");
echo "<br><span class=floatright>";

echo "<a href=\"pc.php?func=deletecred&credid=$credid&groupid=$pcgroupid&returnto=group\" class=\"linkbuttonsmall linkbuttongray radiusall\"
onClick=\"return confirm('".pcrtlang("Are you sure you want to delete this pattern?")."')\"><i class=\"fa fa-trash fa-lg\"></i></a>";
echo "</td></tr></table>";
}

if($credtype == 5) {
echo "<table class=\"$badgestyle\"><tr><td><i class=\"fa fa-question-circle fa-2x\"></i></td>";
echo "<td><strong>$creddesc</strong><span class=floatright>$creddate</span><br><i class=\"fa fa-question\"></i> $creduser<br><i class=\"fa fa-commenting-o\">
</i> $credpass";
echo "<br><span class=floatright>";

echo "<a href=\"pc.php?func=editcred&credid=$credid&credtype=$credtype&groupid=$pcgroupid&returnto=group\" class=\"linkbuttonsmall linkbuttongray radiusall\" rel=facebox>
<i class=\"fa fa-edit fa-lg\"></i></a>";
echo "<a href=\"pc.php?func=deletecred&credid=$credid&groupid=$pcgroupid&returnto=group\" class=\"linkbuttonsmall linkbuttongray radiusall\"
onClick=\"return confirm('".pcrtlang("Are you sure you want to delete this security question?")."')\"><i class=\"fa fa-trash fa-lg\"></i></a>";
echo "</span></td></tr></table>";
}



}


echo "</td></tr></table><br>";

#end perm
}

} elseif ("$groupview" == "portaldownloads") {

start_blue_box(pcrtlang("Customer Portal Downloads"));
echo "<table class=standard>";

echo "<tr><th>".pcrtlang("Title")."</th><th>".pcrtlang("Filename")."</th><th></th></tr>";

$rs_df = "SELECT * FROM portaldownloads WHERE groupid = '$pcgroupid' ORDER BY downloadfiletitle DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_df);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$downloadid = "$rs_result_q1->downloadid";
$downloadfilename = "$rs_result_q1->downloadfilename";
$downloadfiletitle = "$rs_result_q1->downloadfiletitle";

echo "<tr><td>$downloadfiletitle</td><td><a href=\"group.php?func=getfile&downloadid=$downloadid\"><i class=\"fa fa-download fa-lg\"></i> $downloadfilename</a></td><td>";
echo "<a href=\"group.php?func=deleteportaldownload&downloadid=$downloadid&downloadfilename=$downloadfilename&pcgroupid=$pcgroupid\"
class=\"linkbuttonsmall linkbuttonred radiusleft\"><i class=\"fa fa-times fa-lg\"></i> ".pcrtlang("Delete")."</a>";
echo "</td></tr>";

}

echo "</table>";
stop_blue_box();


start_blue_box(pcrtlang("Upload Customer Portal Download"));
echo "<form action=group.php?func=uploadportaldownload method=post enctype=\"multipart/form-data\"><input type=hidden name=pcgroupid value=\"$pcgroupid\">";
echo "<table width=100%>";
echo "<tr><td>".pcrtlang("Pick File").":</td><td><input type=file name=downloadfilename>";
echo "</td></tr>";
echo "<tr><td>".pcrtlang("Download Title")."</td><td><input type=text name=downloadfiletitle class=textbox></td></tr>";
echo "<tr><td>&nbsp;</td><td><input type=submit class=button value=\"".pcrtlang("Upload File")."\"></form></td></tr>";
echo "</table>";


stop_blue_box();


} elseif ("$groupview" == "forms") {

start_blue_box(pcrtlang("Customer Forms"));

$rs_dsql = "SELECT * FROM documents WHERE groupid = '$pcgroupid' ORDER BY documentname ASC";
$rs_result1dsql = mysqli_query($rs_connect, $rs_dsql);
$total_documents = mysqli_num_rows($rs_result1dsql);

echo "<br><table class=standard><tr><th colspan=1>";
echo "<i class=\"fa fa-file-alt fa-lg fa-fw\"></i> ".pcrtlang("Forms")."</th>
<th><a href=documents.php?func=chooseform&groupid=$pcgroupid $therel class=\"linkbuttontiny linkbuttongray radiusall floatright\" $therel><i class=\"fa fa-plus\"></i></a></th></tr>";
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
echo "<a href=\"documents.php?func=editform&documentid=$documentid&groupid=$pcgroupid\" class=\"linkbuttonsmall linkbuttongray radiusleft\"><i class=\"fa fa-edit fa-lg\">
</i> ".pcrtlang("edit")."</a>";
}
echo "<a href=\"documents.php?func=deleteform&documentid=$documentid&groupid=$pcgroupid\" onClick=\"return confirm('".pcrtlang("Are you sure you wish to permanently delete this document!!!?")."');\" class=\"linkbuttonsmall linkbuttonred\"><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("delete")."</a>";

if($documentshowinportal == 0) {
echo "<a href=\"documents.php?func=portalswitch&documentid=$documentid&groupid=$pcgroupid&showinportal=1\" class=\"linkbuttonsmall linkbuttonred\"><i class=\"fa fa-eye-slash fa-lg\">
</i> ".pcrtlang("portal")."</a>";
} else {
echo "<a href=\"documents.php?func=portalswitch&documentid=$documentid&groupid=$pcgroupid&showinportal=0\" class=\"linkbuttonsmall linkbuttongreen\"><i class=\"fa fa-eye fa-lg\">
</i> ".pcrtlang("portal")."</a>";
}



echo "<a href=\"documents.php?func=printform&documentid=$documentid&groupid=$pcgroupid\" class=\"linkbuttonsmall linkbuttongray radiusright\"><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("print")."</a>";

echo "</td></tr>";
}
echo "</table>";


stop_blue_box();

} else {
echo "non existent view";

}






require("footer.php");
 
}                                                                                                                             
                                                                                                                                               


function addtogroup() {
require_once("header.php");
require("deps.php");

$woid = $_REQUEST['woid'];
$pcid = $_REQUEST['pcid'];
$pcname = $_REQUEST['pcname'];

start_box();
echo "<h4>#$pcid $pcname</h4><br>";
stop_box();
echo "<br>";
start_blue_box(pcrtlang("Add to Group"));

echo "<form action=group.php?func=addtogroup2 method=post>";
echo "<table>";
echo "<tr><td>".pcrtlang("Enter Group Number").":</td><td><input size=35 class=textbox type=text name=pcgroupid required=required onFocus=\"this.form.submitbutton.disabled=false;this.form.submitbutton.value='".pcrtlang("Add to Group")."';\">";
echo "<input type=hidden name=woid value=$woid><input type=hidden name=pcid value=$pcid> </td></tr>";
echo "<tr><td>&nbsp;</td><td><input class=button id=submitbutton type=submit value=\"".pcrtlang("Add to Group")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Adding to Group")."...'; this.form.submit();\"></form></td></tr>";
echo "</table>";

stop_blue_box();

echo "<br><br>";

start_blue_box(pcrtlang("Or Search for Group"));

echo "<form action=group.php?func=searchaddtogroup method=post>";
echo "<table>";
echo "<tr><td>".pcrtlang("Enter Part of Group Name").":</td><td><input size=35 class=textbox type=text name=pcgroupsearch required=required>";
echo "<input type=hidden name=woid value=$woid><input type=hidden name=pcid value=$pcid><input type=hidden name=pcname value=\"$pcname\"> </td></tr>";
echo "<tr><td>&nbsp;</td><td><input class=button type=submit value=\"".pcrtlang("Search for Group")."\"></form></td></tr>";
echo "</table>";

stop_blue_box();

require_once("footer.php");

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
require("header.php");


start_blue_box(pcrtlang("Search Again"));

echo "<form action=group.php?func=searchaddtogroup method=post>";
echo "<table width=100%>";
echo "<tr><td>".pcrtlang("Enter Part of Group Name").":</td><td><input size=35 class=textbox type=text name=pcgroupsearch value=\"$pcgroupsearch\" required=required>";
echo "<input type=hidden name=woid value=$woid><input type=hidden name=pcid value=$pcid><input type=hidden name=pcname value=\"$pcname\"> </td></tr>";
echo "<tr><td>&nbsp;</td><td><input class=button type=submit value=\"".pcrtlang("Search for Group")."\"></form></td></tr>";
echo "</table>";

stop_blue_box();

echo "<br>";
start_box();
echo pcrtlang("Group Search Results for").": <span class=\"boldme colormeblue\">$pcgroupsearch</span><br><br> ";
stop_box();
echo "<br>";




$rs_findpc = "SELECT * FROM pc_group WHERE pcgroupname LIKE '%$pcgroupsearch%' OR grpcompany LIKE '%$pcgroupsearch%'";
$rs_result = mysqli_query($rs_connect, $rs_findpc);
while ($rs_result_q = mysqli_fetch_object($rs_result)) {
$pcgroupname = "$rs_result_q->pcgroupname";
$grpcompany = "$rs_result_q->grpcompany";
$pcgroupid = "$rs_result_q->pcgroupid";

start_box();

if("$grpcompany" == "") {
echo "<h4>".pcrtlang("Group").": #$pcgroupid $pcgroupname</h4><br><br>".pcrtlang("Assets/Devices/Customers in this Group").":<br>";
} else {
echo "<h4>".pcrtlang("Group").": #$pcgroupid $pcgroupname &bull; $grpcompany</h4>".pcrtlang("Assets/Devices/Customers in this Group").":<br>";
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

echo "<br><a href=group.php?func=addtogroup2&pcgroupid=$pcgroupid&pcid=$pcid&woid=$woid class=boldlink>".pcrtlang("Add to this Group")."</a><br><br>";

stop_box();
echo "<br>";
}

require("footer.php");

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






$rs_set_group = "UPDATE pc_owner SET pcgroupid = '0', scid = '0' WHERE pcid = '$pcid'";
@mysqli_query($rs_connect, $rs_set_group);

if ($woid != "") {
header("Location: index.php?pcwo=$woid");
} else {
header("Location: group.php?func=viewgroup&pcgroupid=$pcgroupid");
}

}




function searchpcaddtogroup() {
require_once("header.php");
require("deps.php");

$searchterm = $_REQUEST['searchterm'];
$pcgroupid = $_REQUEST['pcgroupid'];

$rs_findpc = "SELECT * FROM pc_group WHERE pcgroupid = '$pcgroupid'";
$rs_result = mysqli_query($rs_connect, $rs_findpc);
$rs_result_q = mysqli_fetch_object($rs_result);
$pcgroupname = "$rs_result_q->pcgroupname";

$rs_findowner = "SELECT * FROM pc_owner WHERE pcname LIKE '%$searchterm%' AND pcgroupid != '$pcgroupid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);

if(mysqli_num_rows($rs_result2) != "0") {

echo "<form action=group.php?func=searchpcaddtogroup2 method=post>";
start_blue_box(pcrtlang("Add Asset/Customers to Group"));
echo "<table class=standard><tr><th></th><th>".pcrtlang("Asset/Device ID")."</th><th>".pcrtlang("Customer Name")."&nbsp;&nbsp;&nbsp;</th>
<th>".pcrtlang("Make/Model")."&nbsp;&nbsp;&nbsp;</th></tr>";

while($rs_result_q2 = mysqli_fetch_object($rs_result2)) {
$pcid2 = "$rs_result_q2->pcid";
$pcname2 = "$rs_result_q2->pcname";
$pccompany2 = "$rs_result_q2->pccompany";
$pcmake2 = "$rs_result_q2->pcmake";

echo "<tr><td><input type=checkbox name=pcids[] value=$pcid2></td><td><i class=\"fa fa-tag fa-lg\"></i> $pcid2</td><td>$pcname2 ";
if ("$pccompany2" != "") {
echo "&bull; $pccompany2";
}
echo "</td><td> $pcmake2</td></tr>";
}

echo "</table>";
echo "<input type=hidden name=pcgroupid value=$pcgroupid><br><input class=button type=submit value=\"".pcrtlang("Add to Group")."\" 
onclick=\"this.disabled=true;this.value='".pcrtlang("Adding to Group")."...'; this.form.submit();\"></form>";

stop_blue_box();

} else {

start_box();

echo "".pcrtlang("Sorry, no search results found.")."<br><br><a href=group.php?func=viewgroup&pcgroupid=$pcgroupid>
".pcrtlang("Go Back")."</a>";

stop_box();

}


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

if (array_key_exists("nomodal", $_REQUEST)) {
$nomodal = $_REQUEST['nomodal'];
} else {
$nomodal = 1;
}


if(($gomodal != 1) || ($nomodal != 1)) {
require("header.php");
} else {
require_once("validate.php");
}


$pcgroupid = $_REQUEST['pcgroupid'];


if(($gomodal != 1) || ($nomodal != 1)) {
start_blue_box(pcrtlang("Edit Group"));
} else {
echo "<h4>".pcrtlang("Edit Group")."</h4>";
}






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


echo "<form action=group.php?func=editgroup2 method=post>";
echo "<table width=100%>";
echo "<tr><td>".pcrtlang("Customer Name").":</td><td><input size=35 type=text value=\"$pcname\" name=pcgroupname class=textbox required=required></td></tr>";
echo "<tr><td>".pcrtlang("Company").":</td><td><input size=35 type=text value=\"$pccompany\" name=grpcompany class=textbox></td></tr>";
echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
echo "<tr><td>".pcrtlang("Customer Phone").":</td><td><input size=35 type=text value=\"$pcphone\" name=grpphone class=textbox></td></tr>";
echo "<tr><td>".pcrtlang("Customer Mobile Phone").":</td><td><input size=35 type=text value=\"$pccellphone\" name=grpcellphone class=textbox></td></tr>";
echo "<tr><td>".pcrtlang("Customer Work Phone").":</td><td><input size=35 type=text value=\"$pcworkphone\" name=grpworkphone class=textbox></td></tr>";


echo "<tr><td>".pcrtlang("Preferred Contact Method").":</td><td>";

if(($prefcontact == "none") || ($prefcontact == "")) {
echo "<input checked type=radio id=none name=grpprefcontact value=\"none\"><label for=home>".pcrtlang("none")."</label>&nbsp;&nbsp;";
} else {
echo "<input type=radio id=none name=grpprefcontact value=\"none\"><label for=home>".pcrtlang("none")."</label>&nbsp;&nbsp;";
}

if($prefcontact == "home") {
echo "<input checked type=radio id=home name=grpprefcontact value=\"home\"><label for=home>".pcrtlang("Home Phone")."</label>&nbsp;&nbsp;";
} else {
echo "<input type=radio id=home name=grpprefcontact value=\"home\"><label for=home>".pcrtlang("Home Phone")."</label>&nbsp;&nbsp;";
}

if($prefcontact == "mobile") {
echo "<input checked type=radio id=mobile name=grpprefcontact value=\"mobile\"><label for=mobile>".pcrtlang("Mobile Phone")."</label>&nbsp;&nbsp;";
} else {
echo "<input type=radio id=mobile name=grpprefcontact value=\"mobile\"><label for=mobile>".pcrtlang("Mobile Phone")."</label>&nbsp;&nbsp;";
}

if($prefcontact == "work") {
echo "<input checked type=radio id=work name=grpprefcontact value=\"work\"><label for=work>".pcrtlang("Work Phone")."</label>&nbsp;&nbsp;";
} else {
echo "<input type=radio id=work name=grpprefcontact value=\"work\"><label for=work>".pcrtlang("Work Phone")."</label>&nbsp;&nbsp;";
}

if($prefcontact == "sms") {
echo "<input checked type=radio id=sms name=grpprefcontact value=\"sms\"><label for=sms>".pcrtlang("SMS")."</label>&nbsp;&nbsp;";
} else {
echo "<input type=radio id=sms name=grpprefcontact value=\"sms\"><label for=sms>".pcrtlang("SMS")."</label>&nbsp;&nbsp;";
}

if($prefcontact == "email") {
echo "<input checked type=radio id=email name=grpprefcontact value=\"email\"><label for=sms>".pcrtlang("Email")."</label>&nbsp;&nbsp;";
} else {
echo "<input type=radio id=email name=grpprefcontact value=\"email\"><label for=email>".pcrtlang("Email")."</label>&nbsp;&nbsp;";
}


echo "</td></tr>";


echo "<input type=hidden name=pcgroupid value=$pcgroupid></td></tr>";

echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
echo "<tr><td>".pcrtlang("Customer Source").":</td><td>";

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
echo "</select></td></tr>";



echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
echo "<tr><td>".pcrtlang("Email Address").":</td><td><input size=35 type=text class=textbox name=grpemail value=\"$pcemail\"></td></tr>";

echo "<tr><td>$pcrt_address1</td><td><input type=text class=textbox name=grpaddress1 size=35 value=\"$pcaddress\"></td></tr>";
echo "<tr><td>$pcrt_address2</td><td><input size=25 type=text class=textbox name=grpaddress2 value=\"$pcaddress2\"></td></tr>";
echo "<tr><td>$pcrt_city, $pcrt_state, $pcrt_zip</td><td><input size=16 type=text class=textbox name=grpcity value=\"$pccity\"><input size=5 type=text class=textbox name=grpstate value=\"$pcstate\"><input size=10 type=text class=textbox name=grpzip value=\"$pczip\"></td></tr>";

echo "<tr><td>".pcrtlang("Notes").":</td><td><textarea class=textbox name=grpnotes cols=40 rows=5>$grpnotes</textarea></td></tr>";


echo "<tr><td>&nbsp;</td><td><input class=button type=submit value=\"".pcrtlang("Save")."\"></form></td></tr>";
echo "</table>";

if(($gomodal != 1) || ($nomodal != 1)) {
stop_blue_box();
}
}
if(($gomodal != 1) || ($nomodal != 1)) {
require_once("footer.php");
}



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

require("deps.php");
require_once("common.php");

require_once("header.php");


echo "<script type=\"text/javascript\">document.title = \"".pcrtlang("Groups")."\";</script>";

if (array_key_exists("pageNumber", $_REQUEST)) {
$pageNumber = $_REQUEST['pageNumber'];
} else {
$pageNumber = 1;
}

if (array_key_exists("sortby", $_REQUEST)) {
$sortby = $_REQUEST['sortby'];
} else {
$sortby = "date_asc";
}

if (array_key_exists("search", $_REQUEST)) {
$search = $_REQUEST['search'];
} else {
$search = "";
}

$search_ue = urlencode($search);

start_blue_box(pcrtlang("Browse Customer Groups"));

echo "<table style=\"width:100%\"><tr><td>";
echo "<a href=\"group.php?func=addtogroupnew\" class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Create New Group")."</a>";

echo "</td><td style=\"text-align:right\"><i class=\"fa fa-search fa-lg\"></i> <input type=text class=\"textbox\" id=searchbox placeholder=\"".pcrtlang("Enter Search Text")."\" value=\"$search\"></td></tr></table><br>";



echo "<div id=themain>";

echo "</div>";

?>
<script type="text/javascript">
$(document).ready(function () {
     $.get('group.php?func=browsegroupsajax&pageNumber=<?php echo $pageNumber; ?>&sortby=<?php echo $sortby; ?>&search=<?php echo $search_ue; ?>', function(data) {
     $('#themain').html(data);
     });
});
</script>


<script type="text/javascript">
$(document).ready(function(){
  var globalTimeoutrs = null;
  $("input#searchbox").keyup(function(){
                        if (globalTimeoutrs != null) {
                        clearTimeout(globalTimeoutrs);
                        }
                        var encodedinv = encodeURIComponent(this.value);
                        var searchlength = this.value.length;
                        globalTimeoutrs = setTimeout(function() {
                        globalTimeoutrs = null;
                                if(searchlength<3) {
                                        $('div#themain').load('group.php?func=browsegroupsajax&pageNumber=<?php echo $pageNumber; ?>&sortby=<?php echo $sortby; ?>').slideDown(200,function(){
                                        return false;
                                        });
                                }else{
                                        $('div#themain').load('group.php?func=browsegroupsajax&pageNumber=<?php echo $pageNumber; ?>&sortby=<?php echo $sortby; ?>&search='+encodedinv).slideDown(200);
                                }
                        }, 500);
  });
});
</script>


<?php

stop_blue_box();

require("footer.php");

}




function browsegroupsajax() {

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


$results_per_page = 40;

if ($pageNumber == "") {
$offset = "0";
} else {
$offset = ($pageNumber * $results_per_page) - $results_per_page;
}



require("deps.php");
require_once("common.php");


if (array_key_exists("search", $_REQUEST)) {
$search = $_REQUEST['search'];
if($search != "") {
$searchsql = "AND (pcgroupname LIKE '%$search%' OR grpemail LIKE '%$search%' OR grpnotes LIKE '%$search%' OR grpcompany LIKE '%$search%' OR grpworkphone LIKE '%$search%' OR grpcellphone LIKE '%$search%' OR grpphone LIKE '%$search%' OR grpaddress1 LIKE '%$search%')";
} else {
$searchsql = "";
$search = "";
}
} else {
$searchsql = "";
$search = "";
}


$search_ue = urlencode($search);

$rs_find_cart_items_total = "SELECT * FROM pc_group";
$rs_result_total = mysqli_query($rs_connect, $rs_find_cart_items_total);


$totalentries = mysqli_num_rows($rs_result_total);
$lastpage = $totalentries / $results_per_page;
if($lastpage != floor($lastpage)) {
$lastpage = floor($lastpage) + 1;
}

if($pageNumber > $lastpage) {
$pageNumber = 1;
$offset = 0;
}

if ("$sortby" == "id_asc") {
$rs_find_cart_items = "SELECT * FROM pc_group WHERE 1 $searchsql ORDER BY pcgroupid ASC LIMIT $offset,$results_per_page";
} elseif ("$sortby" == "id_desc") {
$rs_find_cart_items = "SELECT * FROM pc_group WHERE 1 $searchsql ORDER BY pcgroupid DESC LIMIT $offset,$results_per_page";
} elseif ("$sortby" == "name_desc") {
$rs_find_cart_items = "SELECT * FROM pc_group WHERE 1 $searchsql ORDER BY pcgroupname DESC LIMIT $offset,$results_per_page";
} elseif ("$sortby" == "name_asc") {
$rs_find_cart_items = "SELECT * FROM pc_group WHERE 1 $searchsql ORDER BY pcgroupname ASC LIMIT $offset,$results_per_page";
} elseif ("$sortby" == "company_desc") {
$rs_find_cart_items = "SELECT * FROM pc_group WHERE 1 $searchsql ORDER BY grpcompany DESC LIMIT $offset,$results_per_page";
} else {
$rs_find_cart_items = "SELECT * FROM pc_group WHERE 1 $searchsql ORDER BY grpcompany ASC LIMIT $offset,$results_per_page";
}

$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);






echo "<table class=standard>";
echo "<tr><th>".pcrtlang("ID")."#";
echo "</th><th><a href=group.php?func=browsegroups&pageNumber=$pageNumber&sortby=id_asc&search=$search_ue class=\"linkbuttontiny linkbuttongray radiustop\">
<i class=\"fa fa-chevron-up\"></i></a><br>";
echo "<a href=group.php?func=browsegroups&pageNumber=$pageNumber&sortby=id_desc&search=$search_ue class=\"linkbuttontiny linkbuttongray radiusbottom\">
<i class=\"fa fa-chevron-down\"></i></a>";
echo "</td><th>".pcrtlang("Customer Name");
echo "</th><th><a href=group.php?func=browsegroups&pageNumber=$pageNumber&sortby=name_asc&search=$search_ue class=\"linkbuttontiny linkbuttongray radiustop\">
<i class=\"fa fa-chevron-up\"></i></a><br>";
echo "<a href=group.php?func=browsegroups&pageNumber=$pageNumber&sortby=name_desc&search=$search_ue class=\"linkbuttontiny linkbuttongray radiusbottom\">
<i class=\"fa fa-chevron-down\"></i></a>";
echo "</th>";
echo "<th>".pcrtlang("Company");
echo "</th><th><a href=group.php?func=browsegroups&pageNumber=$pageNumber&sortby=company_asc&search=$search_ue class=\"linkbuttontiny linkbuttongray radiustop\">
<i class=\"fa fa-chevron-up\"></i></a><br>";
echo "<a href=group.php?func=browsegroups&pageNumber=$pageNumber&sortby=company_desc&search=$search_ue class=\"linkbuttontiny linkbuttongray radiusbottom\">
<i class=\"fa fa-chevron-down\"></i></a>";
echo "</th>";

echo "<th>".pcrtlang("Customer Phone")."</th><th>".pcrtlang("Customer Email")."</th><th>".pcrtlang("Address")."</th>";
echo "</tr>";

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

echo "<tr><td colspan=2><a href=group.php?func=viewgroup&pcgroupid=$pcgroupid class=\"linkbuttonsmall linkbuttongray radiusall\">#$pcgroupid</a></td>";
echo "<td colspan=2><a href=group.php?func=viewgroup&pcgroupid=$pcgroupid class=\"linkbuttonsmall linkbuttongray radiusall\">$rs_pcname</a></td>";

echo "<td colspan=2>$rs_pccompany</td>";
echo "<td>$rs_pcphone</td>";

echo "<td>";

if($rs_pcemail != "") {
echo "<a href=\"mailto:$rs_pcemail\" class=\"linkbuttonsmall linkbuttongray radiusall\">$rs_pcemail</a>";
}

echo "</td>";

echo "<td><span class=\"sizeme10\">$rs_pcaddress<br>";

if ($rs_pcaddress2 != "") {
echo "$rs_pcaddress2<br>";
}

if($rs_pccity != "") {
echo "$rs_pccity,";
}

echo "$rs_pcstate $rs_pczip</span></td>";


echo "</tr>";

}

echo "</table>";


echo "<br>";

start_box();

echo "<center>";
#browse here

if($pageNumber != 1) {
$prevpage = $pageNumber - 1;
echo "<a href=group.php?func=browsegroups&pageNumber=$prevpage&sortby=$sortby&search=$search_ue class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-left fa-lg\"></i></a>&nbsp;";
}

$html = get_paged_nav($totalentries, $results_per_page, false);
$html = str_replace("browsegroupsajax", "browsegroups", "$html");
echo "$html";

if($lastpage != $pageNumber) {
$nextpage = $pageNumber + 1;
echo "<a href=group.php?func=browsegroups&pageNumber=$nextpage&sortby=$sortby&search=$search_ue class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-right fa-lg\"></i></a>";
}
echo "</center>";
stop_box();


}









function bcreport() {


$blockid = $_REQUEST['blockid'];
require_once("deps.php");

require_once("validate.php");

require_once("common.php");

printableheader(pcrtlang("Block of Time Report"));

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

echo "<span class=sizeme20>$blocktitle</span><br><br>";

echo "<table class=\"standard pad10\">";
echo "<tr><td style=\"vertical-align:top\">".pcrtlang("Start Date").":</td><td style=\"vertical-align:top\">$blockstart</td>";


$rs_checkrinvoice2 = "SELECT * FROM rinvoices WHERE blockcontractid = '$blockid'";
$rs_result_rci2 = mysqli_query($rs_connect, $rs_checkrinvoice2);


echo "</tr>";
echo "<tr><td style=\"vertical-align:top;\">".pcrtlang("Notes").":</td><td style=\"vertical-align:top\">$blocknote</td></tr>";
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

echo "<table class=\"pad10 standard\">";
echo "<tr><td></td><td></td><th><span class=floatright>".pcrtlang("Actual")."</span></th><th><span class=floatright>".pcrtlang("Billed")."</span></th><th><span class=floatright>".pcrtlang("Balance")."</span></th></tr>";


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


echo "<tr><td><i class=\"fa fa-clock-o fa-lg colormered fa-fw\"></i> $timername</td>
<td>$timerstartdate2<br><span class=\"colormegreen\">$timerstarttime2 </span> - <span class=\"colormered\">$timerstoptime2</span></td>";

echo "<td style=\"text-align:right;\">$timeusedact</td><td style=\"text-align:right;\">-$timeused</td><td style=\"text-align:right;\">$timebalance</td></tr>";






} else {
#timercode stop
#line item start

$blockhours = $subarray['blockhours'];
$thedateonly = $subarray['thedateonly'];
$invoiceid = $subarray['invoiceid'];

$runningtime = $runningtime + (3600 * $blockhours);
$timebalance = mf($runningtime / 3600);

echo "<tr><td><i class=\"fa fa-money fa-lg colormegreen fa-fw\"></i> ".pcrtlang("Purchased Hours")."";

echo " &bull; ".pcrtlang("Invoice")." #$invoiceid";


echo "</td><td><span class=colormeblue>$thedateonly</span></td>";
echo "<td colspan=1>";


echo "</td>";
echo "<td style=\"text-align:right;\">+".mf("$blockhours")."</td><td style=\"text-align:right;\">$timebalance</td></tr>";


}


}


echo "<tr><td colspan=11 style=\"text-align:right;\">".pcrtlang("Remaining Time").": $timebalance</td></tr>";

$rs_update_h = "UPDATE blockcontract SET hourscache = '$timebalance' WHERE blockid = '$blockid'";
@mysqli_query($rs_connect, $rs_update_h);


echo "</table>";


echo "<br>";

}

printablefooter();


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
$message .= file_get_contents("printstyle.css");
$message .= "\n</style></head>";
$message .= "<body><table style=\"width:100%\"><tr><td style=\"width:100%\">\n";

$pearhtml .= "<html><head>";
$pearhtml .= "<style>\n";
$pearhtml .= file_get_contents("printstyle.css");
$pearhtml .= "\n</style></head>";
$pearhtml .= "<body><table style=\"width:100%\"><tr><td style=\"width:100%\">\n";



$message .= "<span class=\"sizeme20 boldme\">$storeinfoarray[storename]<br></span>\n\n";
$pearhtml .= "<img src=$logo><br>\n\n";





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

$imagetype = mb_substr("$logo", -3);
if ($imagetype == "gif") { 
$pearmessage2->addHTMLImage("$logo", 'image/gif');
} elseif ($imagetype == "jpg") {
$pearmessage2->addHTMLImage("$logo", 'image/jpeg');
} elseif ($imagetype == "png") {
$pearmessage2->addHTMLImage("$logo", 'image/png');
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
header("Location: group.php?func=viewgroup&pcgroupid=pcgroupid&groupview=blockcontract&fademessage=$fademessage3&fademessagetype=error");

  } else {

$fademessage2 = pcrtlang("Block of Time Contract Report Email Sent Successfully")." $to";
$fademessage3 = urlencode("$fademessage2");
header("Location: group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=blockcontract&fademessage=$fademessage3&fademessagetype=success");

  }

} else {
echo "Error: invalid mailer specified in the deps.php config file";
}






}





########################################################################



function massaddtogroup() {
require_once("validate.php");
require("deps.php");
require("common.php");

$customernamearray = $_REQUEST['customername'];
$assetmake = $_REQUEST['assetmake'];
$assettype = $_REQUEST['assettype'];
$assetnotes = $_REQUEST['assetnotes'];
$pcgroupid = pv($_REQUEST['pcgroupid']);
$pccompany = pv($_REQUEST['pccompany']);
$pcphone = pv($_REQUEST['pcphone']);
$pccellphone = pv($_REQUEST['pccellphone']);
$pcworkphone = pv($_REQUEST['pcworkphone']);
$pcaddress = pv($_REQUEST['pcaddress']);
$pcaddress2 = pv($_REQUEST['pcaddress2']);
$pccity = pv($_REQUEST['pccity']);
$pcstate = pv($_REQUEST['pcstate']);
$pczip = pv($_REQUEST['pczip']);
$pcemail = pv($_REQUEST['pcemail']);


foreach($customernamearray as $key => $customername) {

$rs_insert_pc = "INSERT INTO pc_owner (pcname,pcphone,pccellphone,pcworkphone,pcmake,pcemail,pcaddress,pcaddress2,pccity,pcstate,pczip,pcgroupid,pcnotes,pccompany,mainassettypeid) VALUES ('".pv("$customername")."','$pcphone','$pccellphone','$pcworkphone','".pv("$assetmake[$key]")."','$pcemail','$pcaddress','$pcaddress2','$pccity','$pcstate','$pczip','$pcgroupid','".pv("$assetnotes[$key]")."','$pccompany','".pv("$assettype[$key]")."')";
@mysqli_query($rs_connect, $rs_insert_pc);

}

header("Location: group.php?func=viewgroup&pcgroupid=$pcgroupid");

}



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
echo "<button onClick=\"parent.location='group.php?func=viewgroup&pcgroupid=$pcgroupid'\" class=bigbutton><img src=images/left.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Return")."</button>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<button onClick=\"print();\" class=bigbutton><img src=images/print.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Print")."</button>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
#echo "<button onClick=\"parent.location='../repair/addresslabel.php?pcname=$rs_soldto_ue&pccompany=$rs_company_ue&pcaddress1=$rs_ad1_ue&pcaddress2=$rs_ad2_ue&pccity=$rs_city_ue&pcstate=$rs_state_ue&pczip=$rs_zip_ue&dymojsapi=html'\" class=bigbutton><img src=../repair/images/labelprinter.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Address Label")."</button>";
#echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
#echo "<button  onClick=\"parent.location='../store/invoice.php?func=emailinv2&invoice_id=$invoice_id&emailaddy=$rs_email&returnurl=$rs_returnurl'\" class=bigbutton><img src=images/email.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Email")."</button>";
echo "</div>";


echo "<div class=printpage>";
echo "<table width=100%><tr><td width=55%>";


$storeinfoarray = getstoreinfo($defaultuserstore);

echo "<img src=$printablelogo><br><br>";
echo "$storeinfoarray[storename]<br>$storeinfoarray[storeaddy1]";
if ("$storeinfoarray[storeaddy2]" != "") {
echo "<br>$storeinfoarray[storeaddy2]";
}
echo "<br>$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]";
echo "";
echo "<br>".pcrtlang("Phone").": $storeinfoarray[storephone]<br><br><br>";

echo "<table cellpadding=3 cellspacing=0 border=0><tr><td valign=top>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>";

if ("$company" != "") {
echo "$company";
} else {
echo "$name";
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


echo "</td></tr></table>";

echo "<br></td><td valign=top><table><tr><td align=right width=45% valign=top>";
echo "<span class=textidnumber>".pcrtlang("STATEMENT")."<br></span>";


if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

$printeddate = pcrtdate("$pcrt_longdate", "$currentdatetime");

echo "<br>".pcrtlang("Date").": $printeddate";

echo "</td></tr><tr><td>";

echo "</td></tr></table></td></tr></table>";



echo "<table class=printables>";


$invoicetotalids = "(SELECT DISTINCT(invoices.invoice_id),invoices.invdate,invoices.invnotes FROM invoices, pc_wo, pc_owner WHERE pc_owner.pcgroupid = '$pcgroupid' AND pc_owner.pcid = pc_wo.pcid
AND invoices.iorq != 'quote' AND invoices.invstatus = '1' AND (pc_wo.woid = invoices.woid OR invoices.woid LIKE CONCAT('%\_',pc_wo.woid,'\_%')))
UNION (SELECT invoices.invoice_id,invoices.invdate,invoices.invnotes FROM invoices,rinvoices WHERE invoices.rinvoice_id = rinvoices.rinvoice_id AND rinvoices.pcgroupid = '$pcgroupid'
AND invoices.invstatus = '1' AND invoices.iorq != 'quote')
UNION (SELECT invoice_id,invdate,invnotes FROM invoices WHERE pcgroupid = '$pcgroupid' AND invoices.invstatus = '1' AND invoices.iorq != 'quote')";

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

$message .= "<img src=$logo><br><br>$storeinfoarray[storename]<br>$storeinfoarray[storeaddy1]";
$pearhtml .= "<img src=$logo><br><br>$storeinfoarray[storename]<br>$storeinfoarray[storeaddy1]";

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
AND invoices.invstatus = '1' AND invoices.iorq != 'quote')
UNION (SELECT invoice_id,invdate,invnotes FROM invoices WHERE pcgroupid = '$pcgroupid' AND invoices.invstatus = '1' AND invoices.iorq != 'quote')";


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

#die("$pearhtml");

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

$imagetype = substr("$logo", -3);
if ($imagetype == "gif") {
$pearmessage2->addHTMLImage("$logo", 'image/gif');
} elseif ($imagetype == "jpg") {
$pearmessage2->addHTMLImage("$logo", 'image/jpeg');
} elseif ($imagetype == "png") {
$pearmessage2->addHTMLImage("$logo", 'image/png');
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



function searchinvoiceaddtogroup() {
require_once("header.php");
require("deps.php");

$searchterm = $_REQUEST['searchterm'];
$pcgroupid = $_REQUEST['pcgroupid'];

$rs_findgn = "SELECT * FROM pc_group WHERE pcgroupid = '$pcgroupid'";
$rs_result = mysqli_query($rs_connect, $rs_findgn);
$rs_result_q = mysqli_fetch_object($rs_result);
$pcgroupname = "$rs_result_q->pcgroupname";

$rs_findinv = "SELECT * FROM invoices WHERE pcgroupid = '0' AND woid = '' AND (invname LIKE '%$searchterm%' OR invcompany LIKE '%$searchterm%' OR invemail LIKE '%$searchterm%')";
$rs_result2 = mysqli_query($rs_connect, $rs_findinv);

if(mysqli_num_rows($rs_result2) != "0") {

echo "<form action=group.php?func=searchinvoiceaddtogroup2 method=post>";
start_blue_box(pcrtlang("Add Invoices to Group"));
echo "<table class=standard><tr><th></th><th>".pcrtlang("Invoice")."#</th><th>".pcrtlang("Customer")."&nbsp;&nbsp;&nbsp;</th></tr>";

while($rs_result_q2 = mysqli_fetch_object($rs_result2)) {
$invoiceid2 = "$rs_result_q2->invoice_id";
$invname2 = "$rs_result_q2->invname";
$invcompany2 = "$rs_result_q2->invcompany";
$invemail2 = "$rs_result_q2->invemail";

$groupidmatch = groupbyinvoice($invoiceid2);
if($groupidmatch == 0) {
echo "<tr><td><input type=checkbox name=invids[] value=$invoiceid2></td><td><i class=\"fa fa-tag fa-lg\"></i> $invoiceid2</td><td>$invname2 ";
if ("$invcompany2" != "") {
echo "&bull; $invcompany2";
}
}
}

echo "</table>";
echo "<input type=hidden name=pcgroupid value=$pcgroupid><br><input class=button type=submit value=\"".pcrtlang("Add to Group")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Adding to Group")."...'; this.form.submit();\"></form>";

stop_blue_box();

} else {

start_box();

echo "".pcrtlang("Sorry, no search results found.")."<br><br><a href=group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=invoices>".pcrtlang("Go Back")."</a>";

stop_box();

}

require_once("footer.php");
}



function searchinvoiceaddtogroup2() {
require_once("validate.php");
require("deps.php");
require("common.php");

$invids = $_REQUEST['invids'];
$pcgroupid = $_REQUEST['pcgroupid'];

foreach($invids as $key => $val) {
$rs_set_group = "UPDATE invoices SET pcgroupid = '$pcgroupid' WHERE invoice_id = '$val'";
@mysqli_query($rs_connect, $rs_set_group);

}

header("Location: group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=invoices");

}



function searchrinvoiceaddtogroup() {
require_once("header.php");
require("deps.php");

$searchterm = $_REQUEST['searchterm'];
$pcgroupid = $_REQUEST['pcgroupid'];

$rs_findgn = "SELECT * FROM pc_group WHERE pcgroupid = '$pcgroupid'";
$rs_result = mysqli_query($rs_connect, $rs_findgn);
$rs_result_q = mysqli_fetch_object($rs_result);
$pcgroupname = "$rs_result_q->pcgroupname";

$rs_findinv = "SELECT * FROM rinvoices WHERE pcgroupid = '0' AND (invname LIKE '%$searchterm%' OR invcompany LIKE '%$searchterm%' OR invemail LIKE '%$searchterm%')";
$rs_result2 = mysqli_query($rs_connect, $rs_findinv);

if(mysqli_num_rows($rs_result2) != "0") {

echo "<form action=group.php?func=searchrinvoiceaddtogroup2 method=post>";
start_blue_box(pcrtlang("Add Recurring Invoices to Group"));
echo "<table class=standard><tr><th></th><th>".pcrtlang("Recurring Invoice")."#</th><th>".pcrtlang("Customer")."&nbsp;&nbsp;&nbsp;</th></tr>";

while($rs_result_q2 = mysqli_fetch_object($rs_result2)) {
$rinvoiceid2 = "$rs_result_q2->rinvoice_id";
$invname2 = "$rs_result_q2->invname";
$invcompany2 = "$rs_result_q2->invcompany";
$invemail2 = "$rs_result_q2->invemail";
echo "<tr><td><input type=checkbox name=rinvids[] value=$rinvoiceid2></td><td><i class=\"fa fa-tag fa-lg\"></i> $rinvoiceid2</td><td>$invname2 ";
if ("$invcompany2" != "") {
echo "&bull; $invcompany2";
}
}

echo "</table>";
echo "<input type=hidden name=pcgroupid value=$pcgroupid><br><input class=button type=submit value=\"".pcrtlang("Add to Group")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Adding to Group")."...'; this.form.submit();\"></form>";

stop_blue_box();

} else {

start_box();

echo "".pcrtlang("Sorry, no search results found.")."<br><br><a href=group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=recurringinvoices>".pcrtlang("Go Back")."</a>";

stop_box();

}

require_once("footer.php");
}



function searchrinvoiceaddtogroup2() {
require_once("validate.php");
require("deps.php");
require("common.php");

$rinvids = $_REQUEST['rinvids'];
$pcgroupid = $_REQUEST['pcgroupid'];

foreach($rinvids as $key => $val) {
$rs_set_group = "UPDATE rinvoices SET pcgroupid = '$pcgroupid' WHERE rinvoice_id = '$val'";
@mysqli_query($rs_connect, $rs_set_group);

}

header("Location: group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=recurringinvoices");

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

header("Location: group.php?func=viewgroup&groupview=sms&pcgroupid=$groupid");

}



function uploadportaldownload() {

require("deps.php");
require_once("validate.php");
require("common.php");

$downloadfiletitle = pv($_REQUEST['downloadfiletitle']);
$pcgroupid = pv($_REQUEST['pcgroupid']);

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}

$filename = $_FILES['downloadfilename']['name'];

$time = time()."_";

$uploaddir = "../portal/downloads/";
$uploadfile = $uploaddir . $time . basename($_FILES['downloadfilename']['name']);
if (move_uploaded_file($_FILES['downloadfilename']['tmp_name'], $uploadfile)) {
} else {
    echo pcrtlang("Unknown file upload error!")."\n";
}

$storedas = "$time"."$filename";

$rs_insert_pf = "INSERT INTO portaldownloads (downloadfilename,downloadfiletitle,storedas,groupid) VALUES ('$filename','$downloadfiletitle','$storedas','$pcgroupid')";
@mysqli_query($rs_connect, $rs_insert_pf);

header("Location: group.php?func=viewgroup&groupview=portaldownloads&pcgroupid=$pcgroupid");

}



function deleteportaldownload() {

require("deps.php");
require("common.php");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}

$pcgroupid = pv($_REQUEST['pcgroupid']);
$downloadid = pv($_REQUEST['downloadid']);
$downloadfilename = pv($_REQUEST['storedas']);

require_once("validate.php");

$rs_set_p = "DELETE FROM portaldownloads WHERE downloadid = '$downloadid'";
@mysqli_query($rs_connect, $rs_set_p);

if (file_exists("../portal/downloads/$downloadfilename")) {
unlink("../portal/downloads/$downloadfilename");
}

header("Location: group.php?func=viewgroup&groupview=portaldownloads&pcgroupid=$pcgroupid");

}


function getfile() {

require("deps.php");
require("common.php");

$downloadid = $_REQUEST['downloadid'];

$rs_findfileid = "SELECT * FROM portaldownloads WHERE downloadid = '$downloadid'";
$rs_resultfid = mysqli_query($rs_connect, $rs_findfileid);
$rs_result_qfid = mysqli_fetch_object($rs_resultfid);
$download_filename = "$rs_result_qfid->downloadfilename";
$storedas = "$rs_result_qfid->storedas";

header('Content-Type: application/octet-stream');
header("Content-Disposition: attachment; filename=\"$download_filename\"");
readfile("../portal/downloads/$storedas");

}


function viewportal() {

require("deps.php");
require("common.php");

$pcgroupid = $_REQUEST['pcgroupid'];
$grpemail = $_REQUEST['groupemail'];

$_SESSION['portallogin'] = "$grpemail";
$_SESSION['groupid'] = "$pcgroupid";


header("Location: ../portal/");

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
mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_update_sal = "UPDATE pc_group SET tags = '$tags2' WHERE pcgroupid = '$groupid'";
@mysqli_query($rs_connect, $rs_update_sal);

header("Location: group.php?func=viewgroup&pcgroupid=$groupid");

}


switch($func) {
                                                                                                    
    default:
    browsegroups();
    break;
    
    case "browsegroupsajax":
    browsegroupsajax();
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


  case "massaddtogroup":
    massaddtogroup();
    break;

  case "openinvoicestatement":
    openinvoicestatement();
    break;

  case "emailopeninvoicestatement":
    emailopeninvoicestatement();
    break;

    case "searchinvoiceaddtogroup":
    searchinvoiceaddtogroup();
    break;

   case "searchinvoiceaddtogroup2":
    searchinvoiceaddtogroup2();
    break;

    case "searchrinvoiceaddtogroup":
    searchrinvoiceaddtogroup();
    break;

   case "searchrinvoiceaddtogroup2":
    searchrinvoiceaddtogroup2();
    break;

   case "addmessage":
    addmessage();
    break;

    case "uploadportaldownload":
    uploadportaldownload();
    break;

    case "deleteportaldownload":
    deleteportaldownload();
    break;

    case "getfile":
    getfile();
    break;

    case "viewportal":
    viewportal();
    break;

    case "tagsave":
    tagsave();
    break;


}
