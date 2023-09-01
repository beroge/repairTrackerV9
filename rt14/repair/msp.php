<?php
                                                                                                    
/***************************************************************************
 *   copyright            : (C) 2015 PCRepairTracker.com
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
require_once("header.php");
echo "###";
require_once("footer.php");

}


function viewservicecontract() {

$scid = $_REQUEST['scid'];

require("header.php");
require("deps.php");

$rs_findsc = "SELECT * FROM servicecontracts WHERE scid = '$scid'";
$rs_resultsc = mysqli_query($rs_connect, $rs_findsc);
$rs_resultsc_q = mysqli_fetch_object($rs_resultsc);
$pcgroupid = "$rs_resultsc_q->groupid";
$scstartdate2 = "$rs_resultsc_q->scstartdate";
$scexpdate2 = "$rs_resultsc_q->scexpdate";
$scname = "$rs_resultsc_q->scname";
$sccontactperson = "$rs_resultsc_q->sccontactperson";
$scnotes = "$rs_resultsc_q->scdesc";
$scperusercharge = "$rs_resultsc_q->scperusercharge";
$scusers = serializedarraytest("$rs_resultsc_q->scusers");
$scactive = "$rs_resultsc_q->scactive";
$rinvoice = "$rs_resultsc_q->rinvoice";

$scstartdate = pcrtdate("$pcrt_longdate", "$scstartdate2");
$scexpdate = pcrtdate("$pcrt_longdate", "$scexpdate2");


$rs_findpc = "SELECT * FROM pc_group WHERE pcgroupid = '$pcgroupid'";
$rs_result = mysqli_query($rs_connect, $rs_findpc);
$rs_result_q = mysqli_fetch_object($rs_result);
$pcgroupid = "$rs_result_q->pcgroupid";
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

echo "<div class=\"groupbox colorbox\">";
echo "<table style=\"width:100%\"><tr><td style=\"width:50%\">";

if("$grpcompany" == "") {
echo "<h4>$pcgroupname</h4>";
} else {
echo "<h4>$pcgroupname &bull; $grpcompany</h4>";
}

if($grpnotes != "") {
echo "<br><br><span class=\"boldme\">".pcrtlang("Notes").":</span><br>$grpnotes";
}




echo "<br><br>".pcrtlang("Group").":  <a href=\"group.php?func=viewgroup&pcgroupid=$pcgroupid\"class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-group\"></i> $pcgroupid</a>";



echo "</td><td style=\"width:25%;vertical-align:top\">";

echo "<table border=0 cellspacing=0 cellpadding=2><tr><td bgcolor=#777777><i class=\"fa fa-phone fa-lg\" style=\"padding:20px 3px;color:white;\"></i></td><td>";

if($grpphone != "") {
if($grpprefcontact == "home") {
echo "<span class=\"boldme colormegraydark\">&bull;</span>";
}
echo "&nbsp;".pcrtlang("Home").": <span class=\"boldme\">$grpphone</span><br>";
}

if($grpcellphone != "") {
if($grpprefcontact == "cellphone") {
echo "<span class=\"boldme colormegraydark\">&bull;</span>";
}
echo "&nbsp;".pcrtlang("Cell").": <span class=\"boldme\">$grpcellphone</span><br>";
}

if($grpworkphone != "") {
if($grpprefcontact == "workphone") {
echo "<span class=\"boldme\">&bull;</span>";
}
echo "&nbsp;".pcrtlang("Work").": <span class=\"boldme\">$grpworkphone</span>";
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

echo "</td></tr><table></td></tr></table>";

echo "<br>";

echo "<table class=standard>";

echo "<tr><th colspan=2>$scname</th></tr>";

echo "<tr><td style=\"width:25%\">".pcrtlang("Contact Person").":</td><td>$sccontactperson</td></tr>";
echo "<tr><td style=\"width:25%\">".pcrtlang("Start Date").":</td><td>$scstartdate</td></tr>";
echo "<tr><td style=\"width:25%\">".pcrtlang("Expiration Date").":</td><td>$scexpdate</td></tr>";
echo "<tr><td style=\"width:25%\">".pcrtlang("Contract Notes").":</td><td>$scnotes</td></tr>";


echo "<tr><td style=\"width:25%\">".pcrtlang("Contract Status").":</td><td>";

if($scactive == 1) {
echo "Active <a href=msp.php?func=scactive&scid=$scid&rinvoice=$rinvoice&groupid=$pcgroupid&scactive=0 class=\"linkbuttonsmall linkbuttongray radiusall\">".pcrtlang("Deactivate")."</a>";
} else {
echo "<span class=\"colormered\">Inactive</span>&nbsp;<a href=msp.php?func=scactive&scid=$scid&rinvoice=$rinvoice&groupid=$pcgroupid&scactive=1 class=\"linkbuttonsmall linkbuttongray radiusall\">".pcrtlang("Activate")."</a> ";
}


echo "</td></tr>";



echo "<tr><td colspan=2>";


if ($gomodal == 1) {
$therel = "rel=facebox";
} else {
$therel = "";
}



$rs_asql = "SELECT * FROM attachments WHERE scid = '$scid'";
$rs_result1asql = mysqli_query($rs_connect, $rs_asql);
$total_attachments = mysqli_num_rows($rs_result1asql);

if ($total_attachments > 0) {
echo "<span class=\"boldme\">".pcrtlang("Contract Attachments").":</span><table>";
while($rs_result_asql1 = mysqli_fetch_object($rs_result1asql)) {
$attach_id = "$rs_result_asql1->attach_id";
$attach_title = "$rs_result_asql1->attach_title";
$attach_size = "$rs_result_asql1->attach_size";
$attach_filename = "$rs_result_asql1->attach_filename";
$fileextpc = strtolower(substr(strrchr($attach_filename, "."), 1));

$fileicon = getfileicon($fileextpc);

$thebytes = formatBytes($attach_size);

echo "<tr><td>";
echo "<a href=attachment.php?func=get&attach_id=$attach_id class=\"linkbuttonsmall linkbuttongray radiusall\">$fileicon $attach_title<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$thebytes</a></td>";
echo "<td>&nbsp;&nbsp;&nbsp;<a href=\"attachment.php?func=editattach&scid=$scid&attach_id=$attach_id\" class=\"linkbuttonsmall linkbuttongray radiusleft\" $therel><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("edit")."</a>";
echo "<a href=\"attachment.php?func=deleteattach&scid=$scid&attach_id=$attach_id&attachfilename=$attach_filename\" class=\"linkbuttonsmall linkbuttongray radiusright\" onClick=\"return confirm('".pcrtlang("Are you sure you wish to permanently delete this Attachment!!!?")."');\"><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("delete")."</a></td></tr>";
}
echo "</table>";
}


echo "<br><a href=attachment.php?func=add&attachtowhat=scid&scid=$scid $therel class=\"linkbuttonsmall linkbuttongray radiusall\"><i class=\"fa fa-paperclip fa-lg\"></i> ".pcrtlang("Add Attachment to Service Contract")."</a>";



echo "</td></tr>";
echo "<tr><td style=\"width:25%\" colspan=2>";
echo "<button class=button type=button onClick=\"parent.location='msp.php?func=editservicecontract&scid=$scid'\">
<i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("Edit Contract")."</button>";

echo "</td></tr>";

echo "</table>";

echo "</div>";


#start forms


$rs_dsql = "SELECT * FROM documents WHERE scid = '$scid' ORDER BY documentname ASC";
$rs_result1dsql = mysqli_query($rs_connect, $rs_dsql);
$total_documents = mysqli_num_rows($rs_result1dsql);

echo "<br><table class=standard><tr><th colspan=1>";
echo "<i class=\"fa fa-file-alt fa-lg fa-fw\"></i> ".pcrtlang("Forms")."</th>
<th><a href=documents.php?func=chooseform&scid=$scid $therel class=\"linkbuttontiny linkbuttongray radiusall floatright\" $therel><i class=\"fa fa-plus\"></i></a></th></tr>";
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
echo "<a href=\"documents.php?func=editform&documentid=$documentid&scid=$scid\" class=\"linkbuttonsmall linkbuttongray radiusleft\"><i class=\"fa fa-edit fa-lg\">
</i> ".pcrtlang("edit")."</a>";
}
echo "<a href=\"documents.php?func=deleteform&documentid=$documentid&scid=$scid\" onClick=\"return confirm('".pcrtlang("Are you sure you wish to permanently delete this document!!!?")."');\" class=\"linkbuttonsmall linkbuttonred\"><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("delete")."</a>";

if($documentshowinportal == 0) {
echo "<a href=\"documents.php?func=portalswitch&documentid=$documentid&scid=$scid&showinportal=1\" class=\"linkbuttonsmall linkbuttonred\"><i class=\"fa fa-eye-slash fa-lg\">
</i> ".pcrtlang("portal")."</a>";
} else {
echo "<a href=\"documents.php?func=portalswitch&documentid=$documentid&scid=$scid&showinportal=0\" class=\"linkbuttonsmall linkbuttongreen\"><i class=\"fa fa-eye fa-lg\">
</i> ".pcrtlang("portal")."</a>";
}


echo "<a href=\"documents.php?func=printform&documentid=$documentid&scid=$scid\" class=\"linkbuttonsmall linkbuttongray radiusright\"><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("print")."</a>";

echo "</td></tr>";
}
echo "</table>";


# end forms


echo "<br><br>";

echo "<a href=\"javascript:void(0);\" class=\"linkbuttongray linkbuttonmedium radiusall displayblock\" id=peruserselector>".pcrtlang("Per User Charges")."<i class=\"fa fa-chevron-down fa-lg\"></i></a>";

$userdisplay = "display:none";

echo "<div id=peruserbox style=\"$userdisplay;border:#777777 1px solid;padding:10px;background:#ffffff;\"><br>";

echo "<table class=standard>";

echo "<tr><th></th><th>".pcrtlang("Users")."</th></tr>";

echo "<tr><td style=\"width:50%\">";

echo "<form method=post action=\"msp.php?func=adduser&scid=$scid\"><input type=text name=mspuser class=textbox>";
echo "<input type=submit class=button value=\"".pcrtlang("Add User")."\"></form>";

echo "</td><td rowspan=2>";

foreach($scusers as $key => $val) {

$mspusertodel = urlencode("$val[user]");

echo "<a href=\"msp.php?func=deluser&scid=$scid&mspuser=$key\"><i class=\"fa fa-times fa-lg\"></a></i> $val[user]<br>";

}

echo "</td></tr>";
echo "<tr><td style=\"width:50%\">";

echo "<form method=post action=\"msp.php?func=setusercharge&scid=$scid\"><input type=text name=usercharge class=textbox value=\"".mf("$scperusercharge")."\">";
echo "<input type=submit class=button value=\"".pcrtlang("Set Per User Charge")."\"></form>";

echo "</td></tr>";

echo "<tr><td colspan=2>";

$totalusercharges = mf(count($scusers) * $scperusercharge);

echo "".pcrtlang("Total User Charges").": <span class=colormegreen>$money$totalusercharges</span>";

echo "</td></tr>";


echo "</table>";



echo "</div>";

?>
<script type='text/javascript'>
$('#peruserselector').click(function(){
  $('#peruserbox').slideToggle('1000');
  $("i",this).toggleClass("fa-chevron-up fa-chevron-down");
});
</script>
<?php



echo "<br>";

$rs_findownerc = "SELECT * FROM pc_owner WHERE pcgroupid = '$pcgroupid' AND scid = '$scid'";
$rs_result2c = mysqli_query($rs_connect, $rs_findownerc);


if(mysqli_num_rows($rs_result2c) != 0) {
echo "<a href=\"javascript:void(0);\" class=\"linkbuttongray linkbuttonmedium radiusall displayblock\" id=permachineselector>".pcrtlang("Per Asset/Device Charges")."<i class=\"fa fa-chevron-up fa-lg\"></i></a>";
echo "<div id=permachinebox style=\"display:block;border:#777777 1px solid;padding:10px;background:#ffffff;\"><br>";
} else {
echo "<a href=\"javascript:void(0);\" class=\"linkbuttongray linkbuttonmedium radiusall displayblock\" id=permachineselector>".pcrtlang("Per Asset/Device Charges")."<i class=\"fa fa-chevron-down fa-lg\"></i></a>";
echo "<div id=permachinebox style=\"display:none;border:#777777 1px solid;padding:10px;background:#ffffff;\"><br>";
}


echo "<table class=standard>";

echo "<tr><th>".pcrtlang("Assets/Devices")."</th></tr>";

echo "<tr><td>";

$machinestocharge = array();
$pcids = "";

echo "<table class=standard>";
$rs_findowner = "SELECT * FROM pc_owner WHERE pcgroupid = '$pcgroupid' AND (scid = '0' OR scid = '$scid')";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
while($rs_result_q2 = mysqli_fetch_object($rs_result2)) {
$pcid = "$rs_result_q2->pcid";
$pcname = "$rs_result_q2->pcname";
$pccompany = "$rs_result_q2->pccompany";
$pcmake = "$rs_result_q2->pcmake";
$scid5 = "$rs_result_q2->scid";
$scpriceid5 = "$rs_result_q2->scpriceid";
$mainassettypeid5 = "$rs_result_q2->mainassettypeid";
$mainassettypename5 = getassettypename($mainassettypeid5);

if($scid5 == 0) {
$pcids .=  "<option value=$pcid>$mainassettypename5 $pcid: $pcmake &bull; $pcname</option>";
} else {
echo "<tr><td>$mainassettypename5</td><td>$pcmake</td><td><i class=\"fa fa-tag fa-lg\"></i>$pcid &nbsp; $pcname</td>";

if($scpriceid5 != 0) {
if(!array_key_exists("$scpriceid5", $machinestocharge)) {
$machinestocharge[$scpriceid5] = 0;
}
$machinestocharge[$scpriceid5] = $machinestocharge[$scpriceid5] + 1;
}

####

echo "<td><form method=post action=\"msp.php?func=setmachineprice\"><input type=hidden name=pcid value=$pcid><input type=hidden name=scid value=$scid><select name=scpriceoption onchange='this.form.submit()'>";

if($scpriceid5 == 0) {
echo "<option selected value=0>".pcrtlang("No Pricing Option Selected")."</option>";
} else {
echo "<option value=0>".pcrtlang("No Pricing Option Selected")."</option>";
}

$rs_ql = "SELECT * FROM scprices WHERE mainassettypeid = '$mainassettypeid5' ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$scpriceid = "$rs_result_q1->scpriceid";
$labordesc = "$rs_result_q1->labordesc";
$laborprice = "$rs_result_q1->laborprice";
$theorder = "$rs_result_q1->theorder";
$scpmainassettypeid = "$rs_result_q1->mainassettypeid";

$primero = mb_substr("$labordesc", 0, 1);
if("$primero" != "-") {
if($scpriceid5 == $scpriceid) {
echo "<option selected value=$scpriceid>$labordesc - $laborprice</option>";
} else {
echo "<option value=$scpriceid>$labordesc - $laborprice</option>";
}

} else {
echo "<option value=\"\" disabled>$labordesc</option>";
}

}
echo "</select></form></td>";



####




echo "<td style=\"text-align:right\"><button class=ibutton type=button onClick=\"parent.location='msp.php?func=delmachine&scid=$scid&pcid=$pcid'\">
<i class=\"fa fa-times fa-lg\"></i></button>";
echo "<button class=button type=button onClick=\"parent.location='pc.php?func=showpc&pcid=$pcid'\">".pcrtlang("View")."</button>";

echo "<a href=rwo.php?func=addrwo&pcid=$pcid&scid=$scid $therel class=linkbutton><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Recurring WO")."</a>";

echo "</td></tr>";

###############

$rs_rwosql = "SELECT * FROM rwo WHERE pcid = '$pcid' ORDER BY rwodate ASC";
$rs_result1rwosql = mysqli_query($rs_connect, $rs_rwosql);
$total_rwo = mysqli_num_rows($rs_result1rwosql);

if ($total_rwo > 0) {

echo "<tr><td style=\"border:none;background:none;\" colspan=3></td><th colspan=2><i class=\"fa fa-clipboard fa-lg\"></i> ".pcrtlang("Recurring Work Orders for Asset").": #$pcid</th></tr>";

while($rs_result_rwosql1 = mysqli_fetch_object($rs_result1rwosql)) {
$rwoid = "$rs_result_rwosql1->rwoid";
$rwodate = "$rs_result_rwosql1->rwodate";
$rwointerval = "$rs_result_rwosql1->rwointerval";
$rwotask = nl2br("$rs_result_rwosql1->rwotask");
$tasksummary = "$rs_result_rwosql1->tasksummary";

echo "<tr><td style=\"border:none;background:none;\" colspan=3></td><td>$tasksummary<br><span class=sizeme10>".pcrtlang("Next Recurrence").": $rwodate</span></td><td style=\"text-align:right\">";

echo "<a href=\"rwo.php?func=editrwo&scid=$scid&pcid=$pcid&rwoid=$rwoid\" class=\"linkbuttonsmall linkbuttongray\" $therel>
<i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("edit")."</a>";
echo "<a href=\"rwo.php?func=deleterwo&scid=$scid&rwoid=$rwoid\" class=\"linkbuttonsmall linkbuttongray radiusright\"
onClick=\"return confirm('".pcrtlang("Are you sure you want to delete this recurring work order")."')\">
<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("delete")."</a></td></tr>";

}

}





###############

}

}

echo "</table>";

echo "<br><br>";

$rs_findownerc3 = "SELECT * FROM pc_owner WHERE pcgroupid = '$pcgroupid' AND scid = '0'";
$rs_result2c3 = mysqli_query($rs_connect, $rs_findownerc3);

if(mysqli_num_rows($rs_result2c3) != 0) {


echo "<form method=post action=\"msp.php?func=addmachine&scid=$scid\">";
echo "<select name=pcid>";
echo "$pcids";
echo "</select>";
echo "<input type=submit class=button value=\"".pcrtlang("Add Group Asset/Device to Contract")."\"></form>";

}


echo "</tr>";

echo "<tr><td>";

$totalmachinecharges = 0;


foreach($machinestocharge as $key => $val) {

$rs_ql = "SELECT * FROM scprices WHERE scpriceid = '$key'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$laborprice = "$rs_result_q1->laborprice";

$totalmachinecharges = $totalmachinecharges + ($laborprice * $val);

}

echo "".pcrtlang("Total Machine Charges").": <span class=colormegreen>$money".mf("$totalmachinecharges")."</span>";

echo "</td></tr>";

echo "</table>";



echo "</div>";

?>
<script type='text/javascript'>
$('#permachineselector').click(function(){
  $('#permachinebox').slideToggle('1000');
  $("i",this).toggleClass("fa-chevron-up fa-chevron-down");
});
</script>
<?php

echo "<br>";
echo "<table class=standard><tr><th colspan=2>".pcrtlang("Recurring Invoice")."</th></tr>";

if($rinvoice == 0 ) {
echo "<tr><td>";

echo "<form action=msp.php?func=createrinvoice method=post>";
echo "<input type=hidden value=\"$pcgroupname\" name=cfirstname>";
echo "<input type=hidden value=\"$grpcompany\" name=ccompany>";
echo "<input type=hidden value=\"$grpaddress\" name=caddress1>";
echo "<input type=hidden value=\"$grpaddress2\" name=caddress2>";
echo "<input type=hidden value=\"$grpcity\" name=ccity>";
echo "<input type=hidden value=\"$grpstate\" name=cstate>";
echo "<input type=hidden value=\"$grpzip\" name=czip>";
echo "<input type=hidden value=\"$grpphone\" name=cphone>";
echo "<input type=hidden value=\"$grpemail\" name=cemail>";
echo "<input type=hidden value=\"$pcgroupid\" name=pcgroupid>"; 
echo "<input type=hidden value=\"$scid\" name=scid>";


echo "<button class=button type=submit>
<i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Create New Recurring Invoice")."</button></form>";

echo "</td><td>";


$rs_find_ri = "SELECT * FROM rinvoices WHERE pcgroupid = '$pcgroupid'";
$rs_result_ri = mysqli_query($rs_connect, $rs_find_ri);

$rinvoiceoptions = "";

while ($rs_result_ri_q = mysqli_fetch_object($rs_result_ri)) {
$rinvoice_id = "$rs_result_ri_q->rinvoice_id";
$rs_soldto = "$rs_result_ri_q->invname";
$rs_company = "$rs_result_ri_q->invcompany";
$invnotes = "$rs_result_ri_q->invnotes";
$rs_rinvoicedate = "$rs_result_ri_q->reinvoicedate";
$blockcontractid = "$rs_result_ri_q->blockcontractid";

if($blockcontractid != 0) {

$rs_bcs = "SELECT * FROM blockcontract WHERE blockid = '$blockcontractid'";
$rs_find_bcs = @mysqli_query($rs_connect, $rs_bcs);

$rs_find_bcs_q = mysqli_fetch_object($rs_find_bcs);
$blocktitle = "$rs_find_bcs_q->blocktitle";
$blocklabel = " &bull; ".pcrtlang("Block of Time").": $blocktitle";
} else {
$blocklabel = "";
}

$rs_find_ri22 = "SELECT * FROM servicecontracts WHERE rinvoice = '$rinvoice_id'";
$rs_result_ri22 = mysqli_query($rs_connect, $rs_find_ri22);
if(mysqli_num_rows($rs_result_ri22) == 0) {
$rinvoiceoptions .= "<option value=$rinvoice_id>$rs_soldto $blocklabel</option>";
}
}

if(mysqli_num_rows($rs_result_ri) != 0) {
echo "<form method=post action=\"msp.php?func=addexistingrinvoice&scid=$scid\">";
echo "<select name=rinvoice_id>";
echo "$rinvoiceoptions";
echo "</select><br>";
echo "<input type=submit class=button value=\"".pcrtlang("Add Recurring Invoice to Contract")."\"></form>";

echo "<br><span class=\"sizemesmaller italme\">".pcrtlang("Note: To add block of hours to this contract, first create the block of time contract with a recurring invoice, then add the recurring invoice here.")."</span>";


}


echo "</td></tr>";
}

##############

if($rinvoice != 0 ) {

$rs_find_name = "SELECT * FROM rinvoices WHERE rinvoice_id = '$rinvoice'";
$rs_result_name = mysqli_query($rs_connect, $rs_find_name);

$rs_result_name_q = mysqli_fetch_object($rs_result_name);
$rs_soldto = "$rs_result_name_q->invname";
$rs_company = "$rs_result_name_q->invcompany";
$rs_ad1 = "$rs_result_name_q->invaddy1";
$rs_ad2 = "$rs_result_name_q->invaddy2";
$rs_city = "$rs_result_name_q->invcity";
$rs_state = "$rs_result_name_q->invstate";
$rs_zip = "$rs_result_name_q->invzip";
$rs_ph = "$rs_result_name_q->invphone";
$rs_invthrudate = "$rs_result_name_q->invthrudate";
$rs_pcgroupid = "$rs_result_name_q->pcgroupid";
$invnotes = "$rs_result_name_q->invnotes";
$rs_storeid = "$rs_result_name_q->storeid";
$rs_email = "$rs_result_name_q->invemail";
$rs_rinvoicedate = "$rs_result_name_q->reinvoicedate";
$rs_invterms = "$rs_result_name_q->invterms";
$rs_invinterval = "$rs_result_name_q->invinterval";
$rs_invactive = "$rs_result_name_q->invactive";
$blockhours = "$rs_result_name_q->blockhours";
$blockcontractid = "$rs_result_name_q->blockcontractid";

$rs_invthrudate2 = pcrtdate("$pcrt_longdate", "$rs_invthrudate");
$rs_rinvoicedate2 = pcrtdate("$pcrt_longdate", "$rs_rinvoicedate");

echo "<tr><td style=\"width:30%;vertical-align:top;\">";


echo "<table class=standard>";
echo "<tr><td>".pcrtlang("Recurring Invoice").":</td><td> #$rinvoice</td></tr>";

$findinvtotal = "SELECT SUM(cart_price) AS invsubtotal, SUM(itemtax) AS invtax FROM rinvoice_items WHERE rinvoice_id = '$rinvoice'";
$findinvq = @mysqli_query($rs_connect, $findinvtotal);
$findinva = mysqli_fetch_object($findinvq);
$invtax = "$findinva->invtax";
$invsubtotal = "$findinva->invsubtotal";
$invtotal2 = $invtax + $invsubtotal;
$invtotal = number_format($invtotal2, 2, '.', '');

echo "<tr><td>".pcrtlang("Invoice Total").":</td><td> $money$invtotal</td></tr>";
echo "<tr><td>".pcrtlang("Invoiced Thru").":</td><td> $rs_invthrudate2</td></tr>";
echo "<tr><td>".pcrtlang("Re-Invoice After").":</td><td> $rs_rinvoicedate2</td></tr>";
echo "<tr><td>".pcrtlang("Invoice Terms").":</td><td> $rs_invterms</td></tr>";
echo "<tr><td>".pcrtlang("Invoice Interval").":</td><td> $rs_invinterval</td></tr>";
echo "<tr><td>".pcrtlang("Invoice Status").":</td><td>";

if ($rs_invactive != 1) {
echo "<span class=colormered><i class=\"fa fa-warning faa-flash animated fa-lg\"></i> ".pcrtlang("Inactive")."</span>";
} else {
echo "".pcrtlang("Active")."";
}

echo "</td></tr>";


if($rinvoice !=	0) {
if(overduerinvoice($rinvoice) == 1) {
echo "<tr><td colspan=2>";
echo "<span class=colormered><i class=\"fa fa-warning fa-lg faa-flash animated\"></i> Service Contract has Overdue Invoices!</span>";
echo "</td></tr>";
}
}


echo "</td></tr>";




if($blockcontractid != 0) {

$rs_bcsb = "SELECT * FROM blockcontract WHERE blockid = '$blockcontractid'";
$rs_find_bcsb = @mysqli_query($rs_connect, $rs_bcsb);
$rs_find_bcsb_q = mysqli_fetch_object($rs_find_bcsb);
$hoursbalance = "$rs_find_bcsb_q->hourscache";



echo "<tr><td>".pcrtlang("Block Hours per Invoice Cycle").":</td><td> $blockhours</td></tr>";
echo "<tr><td>".pcrtlang("Block Hours Remaining").":</td><td> $hoursbalance</td></tr>";

$rs_bcs = "SELECT * FROM blockcontract WHERE blockid = '$blockcontractid'";
$rs_find_bcs = @mysqli_query($rs_connect, $rs_bcs);
$rs_find_bcs_q = mysqli_fetch_object($rs_find_bcs);
$blocktitle = "$rs_find_bcs_q->blocktitle";

echo "<tr><td>".pcrtlang("Block of Time Contract").":</td><td><a href=\"group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=blockcontract\" class=\"linkbuttonsmall linkbuttongray radiusall\">$blocktitle</a></td></tr>";

}


echo "<tr><td colspan=2>";

$returnurl = urlencode("../repair/msp.php?func=viewservicecontract&scid=$scid");

echo "<button class=button type=button onClick=\"parent.location='../store/rinvoice.php?func=viewrinvoice&rinvoice_id=$rinvoice&returnurl=$returnurl'\">
<i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("View/Edit Recurring Invoice")."</button>";


echo "<button class=button type=button onClick=\"parent.location='msp.php?func=removerinvoice&scid=$scid'\">
<i class=\"fa fa-times fa-lg\"></i> ".pcrtlang("Remove Recurring Invoice from Contract")."</button>";
echo "<br><span class=\"sizemesmaller italme\">".pcrtlang("Does not delete recurring invoice...")."</span>";

echo "</td></tr></table></td><td style=\"width:70%;vertical-align:top;\">";


echo "<table class=standard><tr><th colspan=3>".pcrtlang("Quick Edit - Recurring Invoice Labor Items")."</th></tr>";

$rs_find_cart_labor = "SELECT * FROM rinvoice_items WHERE cart_type = 'labor' AND rinvoice_id = '$rinvoice' ORDER BY addtime ASC";
$rs_result_labor = mysqli_query($rs_connect, $rs_find_cart_labor);

if(mysqli_num_rows($rs_result_labor) == "0") {
echo "<tr><td><span class=\"sizemesmaller italme\">".pcrtlang("No Labor Items")."</span></td></tr>";
}

while($rs_result_labor_q = mysqli_fetch_object($rs_result_labor)) {
$rs_cart_labor_id = "$rs_result_labor_q->cart_item_id";
$rs_cart_labor_price = "$rs_result_labor_q->cart_price";
$rs_cart_labor_desc = "$rs_result_labor_q->labor_desc";
$lorigprice = "$rs_result_labor_q->origprice";
$ldiscounttype = "$rs_result_labor_q->discounttype";
$lprice_alt = "$rs_result_labor_q->price_alt";
$ltaxex = "$rs_result_labor_q->taxex";

echo "<tr><td style=\"width:60%\">$rs_cart_labor_desc</td><td>$".mf("$rs_cart_labor_price")."</td><td>";

echo "<button class=ibutton type=button onClick=\"parent.location='msp.php?func=deleterinvoiceitem&rinvoiceitemid=$rs_cart_labor_id&scid=$scid'\">
<i class=\"fa fa-times fa-lg\"></i></button>";

echo "</td></tr>";

}


echo "<tr><td colspan=3></td></tr>";
echo "<tr><th colspan=3>".pcrtlang("Add Items:")."</th></tr>";


if(count($scusers) > 0) {

$totalusers = count($scusers);

$li_entry = pcrtlang("Managed Service")." - ".pcrtlang("Users").": ($totalusers) @ ".mf($scperusercharge)." ".pcrtlang("each");

echo "<tr><td style=\"width:60%\"><form action=\"msp.php?func=addlaboritem&scid=$scid&rinvoice_id=$rinvoice\" method=post><input type=text class=textbox style=\"width:400px;\" name=labordesc value=\"$li_entry\"></td>";
echo "<td>$money<input type=text class=textbox style=\"width:50px;\" name=laborprice value=\"".mf("$totalusercharges")."\"></td>";
echo "<td><button type=submit class=button><i class=\"fa fa-plus fa-lg\"></i></button></form></td></tr>";


}




if($totalmachinecharges > 0) {
reset($machinestocharge);
foreach($machinestocharge as $key => $val) {
$rs_ql = "SELECT * FROM scprices WHERE scpriceid = '$key'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$labordesc = "$rs_result_q1->labordesc";
$laborprice = "$rs_result_q1->laborprice";
$mainassettypeid = "$rs_result_q1->mainassettypeid";

$totalassetcharge = $val * $laborprice;
$assettypename = getassettypename($mainassettypeid);

$li_entry = "$labordesc - $assettypename: $val@$money$laborprice ".pcrtlang("each");

echo "<tr><td><form action=\"msp.php?func=addlaboritem&scid=$scid&rinvoice_id=$rinvoice\" method=post>";
echo "<input type=text class=textbox style=\"width:400px;\" name=labordesc value=\"$li_entry\"></td>";
echo "<td>$money<input type=text style=\"width:50px;\" class=textbox name=laborprice value=\"".mf("$totalassetcharge")."\"></td>";
echo "<td><button type=submit class=button><i class=\"fa fa-plus fa-lg\"></i></button></form></td></tr>";
}

}

echo "<tr><td style=\"width:60%\"><form action=\"msp.php?func=addlaboritem&scid=$scid&rinvoice_id=$rinvoice\" method=post>";
echo "<input type=text class=textbox style=\"width:400px;\" name=labordesc placeholder=\"".pcrtlang("Enter Custom Charge")."\"></td>";
echo "<td>$money<input type=text class=textbox style=\"width:50px;\" name=laborprice value=0></td>";
echo "<td><button type=submit class=button><i class=\"fa fa-plus fa-lg\"></i></button></form></td></tr>";


echo "</table>";
echo "</td></tr>";

}


echo "</table>";



require_once("footer.php");


}




function newservicecontract() {


require_once("common.php");
require("header.php");


$groupid = $_REQUEST['pcgroupid'];
$personname = $_REQUEST['personname'];


start_blue_box(pcrtlang("New Service Contract"));

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}

$thedate = date("Y-m-d");


echo "<form action=msp.php?func=savenewservicecontract method=post><input type=hidden name=groupid value=$groupid>";
echo "<table>";
echo "<tr><td>".pcrtlang("Contract Name").":</td><td><input size=35 class=textboxw type=text name=scname></td></tr>";
echo "<tr><td>".pcrtlang("Contact Person").":</td><td><input size=35 class=textboxw type=text name=sccontactperson value=\"$personname\"></td></tr>";
echo "<tr><td>".pcrtlang("Start Date").":</td><td><input size=35 id=stday type=text class=textboxw name=scstartdate value=\"$thedate\"></td></tr>";


if(!isset($pcrt_weekstart)) {
$pcrt_weekstart = "Sunday";
}
if ($pcrt_weekstart == "Sunday") {
echo "<script type=\"text/javascript\" src=\"jq/datepickr.js\"></script>";
} else {
echo "<script type=\"text/javascript\" src=\"jq/datepickr2.js\"></script>";
}

?>
<script type="text/javascript">
new datepickr('stday', { dateFormat: 'Y-m-d', theCurrentDate: document.getElementById("stday").value });
</script>
<?php


echo "<tr><td>".pcrtlang("Expiration Date").":</td><td><input size=35 type=text class=textboxw id=expday name=scexpdate value=\"$thedate\"></td></tr>";

?>
<script type="text/javascript">
new datepickr('expday', { dateFormat: 'Y-m-d', theCurrentDate: document.getElementById("expday").value });
</script>
<?php


echo "<tr><td>".pcrtlang("Notes").":</td><td><textarea class=textboxw name=scnotes style=\"width:350px\"></textarea></td></tr>";

echo "<tr><td></td><td><input type=submit class=button value=\"".pcrtlang("Create Service Contract")."\"></td></tr>";

echo "</table>";

stop_blue_box();

require_once("footer.php");


}


function savenewservicecontract() {
require_once("validate.php");
require("deps.php");
require("common.php");

$groupid = pv($_REQUEST['groupid']);
$scname = pv($_REQUEST['scname']);
$sccontactperson = pv($_REQUEST['sccontactperson']);
$scstartdate = pv($_REQUEST['scstartdate']);
$scexpdate = pv($_REQUEST['scexpdate']);
$scnotes = pv($_REQUEST['scnotes']);





$rs_insert_cart = "INSERT INTO servicecontracts (scstartdate,scexpdate,scname,sccontactperson,scdesc,groupid) VALUES  ('$scstartdate','$scexpdate','$scname','$sccontactperson','$scnotes','$groupid')";
@mysqli_query($rs_connect, $rs_insert_cart);

$scid = mysqli_insert_id($rs_connect);

header("Location: msp.php?func=viewservicecontract&scid=$scid");

}


function editservicecontract() {


require_once("common.php");
require("header.php");


$scid = $_REQUEST['scid'];

start_blue_box(pcrtlang("Edit Service Contract"));

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}

$thedate = date("Y-m-d");


$rs_findsc = "SELECT * FROM servicecontracts WHERE scid = '$scid'";
$rs_resultsc = mysqli_query($rs_connect, $rs_findsc);
$rs_resultsc_q = mysqli_fetch_object($rs_resultsc);
$scstartdate2 = "$rs_resultsc_q->scstartdate";
$scexpdate2 = "$rs_resultsc_q->scexpdate";
$scname = "$rs_resultsc_q->scname";
$sccontactperson = "$rs_resultsc_q->sccontactperson";
$scnotes = "$rs_resultsc_q->scdesc";



echo "<form action=msp.php?func=editservicecontract2&scid=$scid method=post>";
echo "<table>";
echo "<tr><td>".pcrtlang("Contract Name").":</td><td><input size=35 class=textboxw type=text name=scname value=\"$scname\"></td></tr>";
echo "<tr><td>".pcrtlang("Contact Person").":</td><td><input size=35 class=textboxw type=text name=sccontactperson value=\"$sccontactperson\"></td></tr>";
echo "<tr><td>".pcrtlang("Start Date").":</td><td><input size=35 id=stday type=text class=textboxw name=scstartdate value=\"$scstartdate2\"></td></tr>";


if(!isset($pcrt_weekstart)) {
$pcrt_weekstart = "Sunday";
}
if ($pcrt_weekstart == "Sunday") {
echo "<script type=\"text/javascript\" src=\"jq/datepickr.js\"></script>";
} else {
echo "<script type=\"text/javascript\" src=\"jq/datepickr2.js\"></script>";
}

?>
<script type="text/javascript">
new datepickr('stday', { dateFormat: 'Y-m-d', theCurrentDate: document.getElementById("stday").value });
</script>
<?php


echo "<tr><td>".pcrtlang("Expiration Date").":</td><td><input size=35 type=text class=textboxw id=expday name=scexpdate value=\"$scexpdate2\"></td></tr>";

?>
<script type="text/javascript">
new datepickr('expday', { dateFormat: 'Y-m-d', theCurrentDate: document.getElementById("expday").value });
</script>
<?php


echo "<tr><td>".pcrtlang("Notes").":</td><td><textarea class=textboxw name=scnotes style=\"width:350px\">$scnotes</textarea></td></tr>";

echo "<tr><td></td><td><input type=submit class=button value=\"".pcrtlang("Save")."\"></td></tr>";

echo "</table>";

stop_blue_box();

require_once("footer.php");


}


function editservicecontract2() {
require_once("validate.php");
require("deps.php");
require("common.php");

$scid = pv($_REQUEST['scid']);
$scname = pv($_REQUEST['scname']);
$sccontactperson = pv($_REQUEST['sccontactperson']);
$scstartdate = pv($_REQUEST['scstartdate']);
$scexpdate = pv($_REQUEST['scexpdate']);
$scnotes = pv($_REQUEST['scnotes']);





$rs_insert_cart = "UPDATE servicecontracts SET scstartdate = '$scstartdate', scexpdate = '$scexpdate', scname = '$scname', sccontactperson = '$sccontactperson', scdesc = '$scnotes' WHERE scid = '$scid'";
@mysqli_query($rs_connect, $rs_insert_cart);


header("Location: msp.php?func=viewservicecontract&scid=$scid");

}



function adduser() {
require_once("validate.php");
require("deps.php");
require("common.php");

$scid = $_REQUEST['scid'];
$mspuser = $_REQUEST['mspuser'];





$rs_findsc = "SELECT * FROM servicecontracts WHERE scid = '$scid'";
$rs_resultsc = mysqli_query($rs_connect, $rs_findsc);
$rs_resultsc_q = mysqli_fetch_object($rs_resultsc);
$scusers = "$rs_resultsc_q->scusers";

$scuserarray = serializedarraytest($scusers);

$scuserarraynew[] = array('user' => "$mspuser");

$scuserinsert = pv(serialize(array_merge($scuserarraynew, $scuserarray))); 

$rs_insert_adduser = "UPDATE servicecontracts SET scusers ='$scuserinsert' WHERE scid = '$scid'";
@mysqli_query($rs_connect, $rs_insert_adduser);

header("Location: msp.php?func=viewservicecontract&scid=$scid");
}

function deluser() {
require_once("validate.php");
require("deps.php");
require("common.php");

$scid = $_REQUEST['scid'];
$mspuser = $_REQUEST['mspuser'];





$rs_findsc = "SELECT * FROM servicecontracts WHERE scid = '$scid'";
$rs_resultsc = mysqli_query($rs_connect, $rs_findsc);
$rs_resultsc_q = mysqli_fetch_object($rs_resultsc);
$scusers = "$rs_resultsc_q->scusers";

$scuserarray = serializedarraytest($scusers);


foreach($scuserarray as $key => $val) {
if ($key != "$mspuser") {
$scuserarraynew[] = array('user' => "$val[user]");
}
}

$scuserinsert = serialize($scuserarraynew);

$rs_insert_adduser = "UPDATE servicecontracts SET scusers ='$scuserinsert'";
@mysqli_query($rs_connect, $rs_insert_adduser);

header("Location: msp.php?func=viewservicecontract&scid=$scid");
}


function setusercharge() {
require_once("validate.php");
require("deps.php");
require("common.php");

$scid = $_REQUEST['scid'];
$usercharge = $_REQUEST['usercharge'];





$rs_setcharge = "UPDATE servicecontracts SET scperusercharge ='$usercharge' WHERE scid = '$scid'";
@mysqli_query($rs_connect, $rs_setcharge);

header("Location: msp.php?func=viewservicecontract&scid=$scid");
}



function savemachineprices() {
require_once("validate.php");
require("deps.php");
require("common.php");

$scid = $_REQUEST['scid'];
$mspassettypes = $_REQUEST['mainassettypes'];





$pointer = 0;

$rs_findassettypes = "SELECT * FROM mainassettypes WHERE mspdevice = '1' ORDER BY mainassetname ASC";
$rs_resultfat = mysqli_query($rs_connect, $rs_findassettypes);
while($rs_result_qfat = mysqli_fetch_object($rs_resultfat)) {
$mainassettypeidid = "$rs_result_qfat->mainassettypeid";
$mainassetname = "$rs_result_qfat->mainassetname";

$pricesinsert[$mainassettypeidid] = $mspassettypes[$pointer];
$pointer++;
}


$pricesinsert2 = pv(serialize($pricesinsert));

$rs_insert_addmc = "UPDATE servicecontracts SET scpermachinecharges ='$pricesinsert2'";
@mysqli_query($rs_connect, $rs_insert_addmc);

header("Location: msp.php?func=viewservicecontract&scid=$scid");
}



function addmachine() {
require_once("validate.php");
require("deps.php");
require("common.php");

$scid = $_REQUEST['scid'];
$pcid = $_REQUEST['pcid'];





$rs_insert_addmachine = "UPDATE pc_owner SET scid ='$scid' WHERE pcid = '$pcid'";
@mysqli_query($rs_connect, $rs_insert_addmachine);

header("Location: msp.php?func=viewservicecontract&scid=$scid");
}


function delmachine() {
require_once("validate.php");
require("deps.php");
require("common.php");

$scid = $_REQUEST['scid'];
$pcid = $_REQUEST['pcid'];





$rs_insert_delmachine = "UPDATE pc_owner SET scid ='0' WHERE pcid = '$pcid'";
@mysqli_query($rs_connect, $rs_insert_delmachine);

header("Location: msp.php?func=viewservicecontract&scid=$scid");
}



function addexistingrinvoice() {
require_once("validate.php");
require("deps.php");
require("common.php");

$scid = $_REQUEST['scid'];
$rinvoice_id = $_REQUEST['rinvoice_id'];





$rs_insert_xri = "UPDATE servicecontracts SET rinvoice ='$rinvoice_id' WHERE scid = '$scid'";
@mysqli_query($rs_connect, $rs_insert_xri);

header("Location: msp.php?func=viewservicecontract&scid=$scid");
}

###############

function createrinvoice() {

require_once("common.php");
require("header.php");


start_blue_box(pcrtlang("Create Recurring Invoice"));

$cfirstname = $_REQUEST['cfirstname'];
$ccompany = $_REQUEST['ccompany'];
$caddress1 = $_REQUEST['caddress1'];
$caddress2 = $_REQUEST['caddress2'];
$ccity = $_REQUEST['ccity'];
$cstate = $_REQUEST['cstate'];
$czip = $_REQUEST['czip'];
$cphone =  $_REQUEST['cphone'];
$cemail =  $_REQUEST['cemail'];
$pcgroupid = $_REQUEST['pcgroupid'];
$scid = $_REQUEST['scid'];

$invoiceintervals = array('1W' => pcrtlang('Weekly'),'2W' => pcrtlang('Every 2 Weeks'),'1M' => pcrtlang('Monthly'),'2M' => pcrtlang('Every 2 Months'),'3M' => pcrtlang('Quarterly'),'6M' => pcrtlang('Every 6 Months'),'1Y' => pcrtlang('Yearly'),'2Y' => pcrtlang('2 Years'));

if (isset($defaultinvoiceterms)) {
$invoiceterms = $defaultinvoiceterms;
} else {
$invoiceterms = 14;
}
if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdate = date('Y-m-d');
$invthrudate = $currentdate;

if (isset($recurringinvoiceinterval)) {
$invoiceinterval = $recurringinvoiceinterval;
} else {
$invoiceinterval = "1M";
}

if (isset($invoicetermsid)) {
$invoicetermsid = $invoicetermsid;
} else {
$invoicetermsid = getinvoicetermsdefault();
}

$invoiceactive = 1;
$invoicenotes = "";


echo "<form action=msp.php?func=createrinvoice2 method=post>";
echo "<table width=100%><tr><td><table>";
echo "<tr><td>".pcrtlang("Customer Name").":</td><td><input size=35 class=textbox type=text name=invname value=\"$cfirstname\"></td></tr>";
echo "<tr><td>".pcrtlang("Company").":</td><td><input size=35 class=textbox type=text name=invcompany value=\"$ccompany\"></td></tr>";
echo "<tr><td>$pcrt_address1:</td><td><input size=35 type=text class=textbox name=invaddy1 value=\"$caddress1\"></td></tr>";
echo "<tr><td>$pcrt_address2:</td><td><input size=35 type=text class=textbox name=invaddy2 value=\"$caddress2\"></td></tr>";
echo "<tr><td>$pcrt_city, $pcrt_state $pcrt_zip</td><td><input size=13 type=text class=textbox name=invcity value=\"$ccity\">";
echo "<input size=7 type=text class=textbox name=invstate value=\"$cstate\">";
echo "<input size=8 type=text class=textbox name=invzip value=\"$czip\"></td></tr>";
echo "<tr><td>".pcrtlang("Customer Phone").":</td><td><input size=35 type=text class=textbox name=invphone value=\"$cphone\"></td></tr>";
echo "<tr><td>".pcrtlang("Customer Email").":</td><td><input size=35 type=text class=textbox name=invemail value=\"$cemail\"></td></tr>";

echo "<tr><td>".pcrtlang("Invoiced Thru Date").":</td><td><input size=35 type=text id=invthrudate class=textbox name=invthrudate value=\"$invthrudate\"></td></tr>";

?>
<script type="text/javascript" src="../repair/jq/datepickr.js"></script>
<script type="text/javascript">
new datepickr('invthrudate', { dateFormat: 'Y-m-d', theCurrentDate: document.getElementById("invthrudate").value });
</script>
<?php

echo "<tr><td>".pcrtlang("Invoice Inverval").":</td><td><select name=invinterval>";


foreach($invoiceintervals as $k => $v) {
if ($k == "$invoiceinterval") {
echo "<option selected value=$k>$v</option>";
} else {
echo "<option value=$k>$v</option>";
}
}



echo "</select></td></tr>";

echo "<tr><td>".pcrtlang("Recurring Invoice Active").":</td><td><select name=invactive>";
if ($invoiceactive == "1") {
echo "<option selected value=1>".pcrtlang("Yes")."</option>";
echo "<option value=0>".pcrtlang("No")."</option>";
} else {
echo "<option value=1>".pcrtlang("Yes")."</option>";
echo "<option selected value=0>".pcrtlang("No")."</option>";
}
echo "</select></td></tr>";

echo "<tr><td>".pcrtlang("Create Invoice in Advance").":<br><span class=\"sizemesmaller italme\">".pcrtlang("days prior to invoice thru date to re-invoice").".</span></td><td><input size=35 type=text class=textbox name=invterms value=\"$invoiceterms\"></td></tr>";


echo "<tr><td>".pcrtlang("Invoice Terms?").":</td><td><select name=invoicetermsid>";

$rs_sl = "SELECT * FROM invoiceterms ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_sl);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$invoicetermsidoptions = "$rs_result_q1->invoicetermsid";
$invoicetermstitle = "$rs_result_q1->invoicetermstitle";
$invoicetermsdays = "$rs_result_q1->invoicetermsdays";
$invoicetermslatefee = "$rs_result_q1->invoicetermslatefee";
$invoicetermsdefault = "$rs_result_q1->invoicetermsdefault";

if ($invoicetermsidoptions == "$invoicetermsid") {
echo "<option selected value=$invoicetermsidoptions>$invoicetermstitle ($invoicetermslatefee% ".pcrtlang("Late Fee").")</option>";
} else {
echo "<option value=$invoicetermsidoptions>$invoicetermstitle ($invoicetermslatefee% ".pcrtlang("Late Fee").")</option>";
}

}

echo "</select></td></tr>";

echo "<tr><td></td><td><input type=hidden name=scid value=\"$scid\"><input type=hidden name=pcgroupid value=\"$pcgroupid\"><input type=submit class=ibutton value=\"".pcrtlang("Save Recurring Invoice")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Saving")."...'; this.form.submit();\"></td></tr>";

echo "</table></td><td>";
echo "<td valign=top>".pcrtlang("Notes").":<br><textarea name=invnotes class=textboxw rows=10 cols=30>$invoicenotes</textarea></form></td></tr></table>";

stop_blue_box();

require_once("footer.php");

}



function createrinvoice2() {
require_once("validate.php");
require("deps.php");
require("common.php");


$invname = pv($_REQUEST['invname']);
$invcompany = pv($_REQUEST['invcompany']);
$invaddy1 = pv($_REQUEST['invaddy1']);
$invaddy2 = pv($_REQUEST['invaddy2']);
$invphone = pv($_REQUEST['invphone']);
$invemail = pv($_REQUEST['invemail']);
$invcity = pv($_REQUEST['invcity']);
$invstate = pv($_REQUEST['invstate']);
$invzip = pv($_REQUEST['invzip']);
$invnotes = pv($_REQUEST['invnotes']);
$crinvoiceid = $_REQUEST['crinvoiceid'];
$pcgroupid = $_REQUEST['pcgroupid'];
$invterms = $_REQUEST['invterms'];
$invinterval = $_REQUEST['invinterval'];
$invthrudate = $_REQUEST['invthrudate'];
$invactive = $_REQUEST['invactive'];
$scid = $_REQUEST['scid'];
$invoicetermsid = $_REQUEST['invoicetermsid'];

$reinvoicedate = date("Y-m-d", (strtotime($invthrudate) - ($invterms * 86400)));






$rs_insert_cart = "INSERT INTO rinvoices (invname,invcompany,invaddy1,invaddy2,invphone,invemail,invthrudate,invinterval,invterms,reinvoicedate,invcity,invstate,invzip,byuser,invnotes,storeid,pcgroupid,invactive,invoicetermsid) VALUES  ('$invname','$invcompany','$invaddy1','$invaddy2','$invphone','$invemail','$invthrudate','$invinterval','$invterms','$reinvoicedate','$invcity','$invstate','$invzip','$ipofpc','$invnotes','$defaultuserstore','$pcgroupid','$invactive','$invoicetermsid')";
@mysqli_query($rs_connect, $rs_insert_cart);
$rinvoiceid = mysqli_insert_id($rs_connect);


$rs_insert_xri = "UPDATE servicecontracts SET rinvoice ='$rinvoiceid' WHERE scid = '$scid'";
@mysqli_query($rs_connect, $rs_insert_xri);



userlog(29,$rinvoiceid,'rinvoiceid','');

header("Location: msp.php?func=viewservicecontract&scid=$scid");

}




function addlaboritem() {
require_once("validate.php");
require("deps.php");
require("common.php");

$laborprice = $_REQUEST['laborprice'];
$labordesc = $_REQUEST['labordesc'];
$scid = $_REQUEST['scid'];
$rinvoice_id = $_REQUEST['rinvoice_id'];

$usertaxid = getusertaxid();
$taxrate = getservicetaxrate($usertaxid);

$itemtax = $taxrate * $laborprice;
$labordescins = pv($labordesc);

$addtime = time();
$rs_insert_cart = "INSERT INTO rinvoice_items (cart_price,cart_type,labor_desc,rinvoice_id,taxex,itemtax,addtime,unit_price,quantity) VALUES ('$laborprice','labor','$labordescins','$rinvoice_id','$usertaxid','$itemtax','$addtime','$laborprice','1')";
@mysqli_query($rs_connect, $rs_insert_cart);

header("Location: msp.php?func=viewservicecontract&scid=$scid");

}



function deleterinvoiceitem() {
require_once("validate.php");
require("deps.php");
require("common.php");

$scid = $_REQUEST['scid'];
$rinvoiceitemid = $_REQUEST['rinvoiceitemid'];






$rs_insert_xri = "DELETE FROM rinvoice_items WHERE cart_item_id = '$rinvoiceitemid'";
@mysqli_query($rs_connect, $rs_insert_xri);

header("Location: msp.php?func=viewservicecontract&scid=$scid");
}


function removerinvoice() {
require_once("validate.php");
require("deps.php");
require("common.php");

$scid = $_REQUEST['scid'];






$rs_insert_xri = "UPDATE servicecontracts SET rinvoice = '0' WHERE scid = '$scid'";
@mysqli_query($rs_connect, $rs_insert_xri);

header("Location: msp.php?func=viewservicecontract&scid=$scid");
}


##########

function scpricing() {
require("header.php");
require_once("common.php");
require("deps.php");

perm_boot("27");






start_blue_box(pcrtlang("Service Contract Pricing"));
echo "<a href=../repair/admin.php class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-circle-left fa-lg\"></i> ".pcrtlang("Go Back to Settings")."</a><br><br>";
echo "<table>";
$rs_ql = "SELECT * FROM scprices ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$scpriceid = "$rs_result_q1->scpriceid";
$labordesc = "$rs_result_q1->labordesc";
$laborprice = "$rs_result_q1->laborprice";
$theorder = "$rs_result_q1->theorder";
$scpmainassettypeid = "$rs_result_q1->mainassettypeid";

$primero = mb_substr("$labordesc", 0, 1);
if("$primero" != "-") {
echo "<tr><td valign=top><form action=msp.php?func=scpricingsave method=post><input type=hidden name=scpriceid value=$scpriceid>";
echo "<a href=msp.php?func=reorderscpricing&scpriceid=$scpriceid&dir=up&theorder=$theorder class=\"linkbuttonsmall linkbuttongray radiusleft\"><i class=\"fa fa-chevron-up fa-lg\"></i></a>";
echo "<a href=msp.php?func=reorderscpricing&scpriceid=$scpriceid&dir=down&theorder=$theorder class=\"linkbuttonsmall linkbuttongray radiusright\"><i class=\"fa fa-chevron-down fa-lg\"></i></a>";
echo "</td>";
echo "<td><input type=text name=labordesc size=30 value=\"$labordesc\" class=textbox><input type=text name=laborprice id=laborprice"."$scpriceid size=8 value=\"$laborprice\" class=textbox>";

$usertaxid = getusertaxid();
$servicetaxrateremain = (1 + getservicetaxrate($usertaxid));

if($servicetaxrateremain != 1) {
echo "<button class=button type=button
onclick='document.getElementById(\"laborprice"."$scpriceid\").value=(document.getElementById(\"laborprice"."$scpriceid\").value / $servicetaxrateremain).toFixed(5);this.disabled=true;'>
<i class=\"fa fa-calculator\"></i> ".pcrtlang("Pre-tax")."</button>";
}

echo "</td>";

echo "<td><select name=mainassettypeid>";
$rs_findassettypes = "SELECT * FROM mainassettypes WHERE mspdevice = '1' ORDER BY mainassetname ASC";
$rs_resultfat = mysqli_query($rs_connect, $rs_findassettypes);
while($rs_result_qfat = mysqli_fetch_object($rs_resultfat)) {
$mainassettypeid = "$rs_result_qfat->mainassettypeid";
$mainassetname = "$rs_result_qfat->mainassetname";
if($scpmainassettypeid == $mainassettypeid) {
echo "<option selected value=$mainassettypeid>$mainassetname</option>";
} else {
echo "<option value=$mainassettypeid>$mainassetname</option>";
}


}
echo "</select></td>";



echo "<td valign=top><button type=submit class=sbutton><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button></form></td><td valign=top>";

$rs_finduse = "SELECT * FROM pc_owner WHERE scpriceid = '$scpriceid'";
$rs_resultuseq = mysqli_query($rs_connect, $rs_finduse);
if(mysqli_num_rows($rs_resultuseq) == 0) {
echo "<form action=msp.php?func=scpricingdelete method=post>";
echo "<input type=hidden name=scpriceid value=$scpriceid>";
echo "<button type=submit class=ibutton><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")."</button></form>";
}


} else {
$labordesc2 = mb_substr("$labordesc", 1);
echo "<tr><td valign=top><input type=hidden name=scpriceid value=$scpriceid>";
echo "<a href=msp.php?func=reorderscpricing&scpriceid=$scpriceid&dir=up&theorder=$theorder class=\"linkbuttonsmall linkbuttongray radiusleft\"><i class=\"fa fa-chevron-up fa-lg\"></i></a>";
echo "<a href=msp.php?func=reorderscpricing&scpriceid=$scpriceid&dir=down&theorder=$theorder class=\"linkbuttonsmall linkbuttongray radiusright\"><i class=\"fa fa-chevron-down fa-lg\"></i></a>";
echo "</td>";
echo "<td><span class=\"linkbuttongraylabel linkbuttonmedium radiusall\">$labordesc2</span>";
echo "</td><td valign=top></td><td valign=top><form action=msp.php?func=scpricingdelete method=post>";
echo "<input type=hidden name=scpriceid value=$scpriceid>";
echo "<button type=submit class=ibutton><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")."</button></form>";
}


echo "</td></tr>";

}

echo "</table>";

echo "<span class=\"sizemesmaller italme\">".pcrtlang("Note: You cannot delete a entry if it is currently in use on a asset.")."</span><br><br>";

echo "<span class=\"sizemesmaller italme\">".pcrtlang("Note: Changing pricing here will not change the prices on your Service Contract Recurring Invoices.")."</span><br><br>";

echo "<form action=msp.php?func=scpricingadd method=post>";
echo "<br><table class=standard><tr><th colspan=4>";
echo pcrtlang("Add Service Contract Price").":</th></td>";
echo "<tr><td><input type=text name=labordesc size=50 value=\"\" class=textbox placeholder=\"".pcrtlang("Enter Description")."\"></td><td><input type=text id=laborprice name=laborprice size=8 value=\"\" class=textbox placeholder=\"".pcrtlang("Enter Price")."\">";

$usertaxid = getusertaxid();
$servicetaxrateremain = (1 + getservicetaxrate($usertaxid));

if($servicetaxrateremain != 1) {
echo "<button class=button type=button
onclick='document.getElementById(\"laborprice\").value=(document.getElementById(\"laborprice\").value / $servicetaxrateremain).toFixed(5);this.disabled=true;'>
<i class=\"fa fa-calculator\"></i> ".pcrtlang("Pre-tax")."</button>";
}

echo "</td>";

echo "<td><select name=mainassettypeid>";
$rs_findassettypes = "SELECT * FROM mainassettypes WHERE mspdevice = '1' ORDER BY mainassetname ASC";
$rs_resultfat = mysqli_query($rs_connect, $rs_findassettypes);
while($rs_result_qfat = mysqli_fetch_object($rs_resultfat)) {
$mainassettypeidid = "$rs_result_qfat->mainassettypeid";
$mainassetname = "$rs_result_qfat->mainassetname";

echo "<option value=$mainassettypeidid>$mainassetname</option>";

}
echo "</select></td>";

echo "<td><button type=submit class=sbutton><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Add")."</button></form></td></table>";
echo "<span class=\"sizemesmaller italme\">".pcrtlang("Start Description with a - to create a title spacer.")."</span>";
stop_blue_box();

require_once("footer.php");
}


function scpricingsave() {
require_once("validate.php");

require("deps.php");
require("common.php");

perm_boot("27");

$scpriceid = $_REQUEST['scpriceid'];
$labordesc = pv($_REQUEST['labordesc']);
$laborprice = $_REQUEST['laborprice'];
$mainassettypeid = $_REQUEST['mainassettypeid'];



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "UPDATE scprices SET labordesc = '$labordesc', laborprice = '$laborprice', mainassettypeid = '$mainassettypeid' WHERE scpriceid = '$scpriceid'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: msp.php?func=scpricing");


}

function scpricingdelete() {
require_once("validate.php");

require("deps.php");
require("common.php");

$scpriceid = $_REQUEST['scpriceid'];

perm_boot("27");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "DELETE FROM scprices WHERE scpriceid = '$scpriceid'";
@mysqli_query($rs_connect, $rs_insert_scan);
header("Location: msp.php?func=scpricing");

}



function scpricingadd() {
require_once("validate.php");

require("deps.php");
require("common.php");

perm_boot("27");

$labordesc = pv($_REQUEST['labordesc']);
$laborprice = $_REQUEST['laborprice'];
$mainassettypeid = $_REQUEST['mainassettypeid'];



mysqli_query($rs_connect, "SET NAMES 'utf8'");
$rs_insert_scan = "INSERT INTO scprices (labordesc,laborprice,mainassettypeid) VALUES ('$labordesc','$laborprice','$mainassettypeid')";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: msp.php?func=scpricing");


}




##########



function reorderscpricing() {
require_once("validate.php");

$scpriceid = $_REQUEST['scpriceid'];
$dir = $_REQUEST['dir'];
$theorder = $_REQUEST['theorder'];

require("deps.php");
require_once("common.php");
perm_boot("2");



mysqli_query($rs_connect, "SET NAMES 'utf8'");


if ($dir == "up") {
$rs_insert_scan = "UPDATE scprices SET theorder = theorder + 6 WHERE scpriceid = $scpriceid";
} else {
$rs_insert_scan = "UPDATE scprices SET theorder = theorder - 6 WHERE scpriceid = $scpriceid";
}

@mysqli_query($rs_connect, $rs_insert_scan);


$rs_resetorder = "SELECT * FROM scprices ORDER BY theorder ASC";
$rs_resultreset = mysqli_query($rs_connect, $rs_resetorder);
$a = 10;
while($rs_result_r1 = mysqli_fetch_object($rs_resultreset)) {
$scpriceid = "$rs_result_r1->scpriceid";
$rs_set_order = "UPDATE scprices SET theorder = '$a' WHERE scpriceid = $scpriceid";
@mysqli_query($rs_connect, $rs_set_order);
$a = $a + 5;
}


header("Location: msp.php?func=scpricing");


}


function setmachineprice() {
require_once("validate.php");
require("deps.php");
require("common.php");

$scid = $_REQUEST['scid'];
$pcid = $_REQUEST['pcid'];
$scpriceid = $_REQUEST['scpriceoption'];





$rs_insert_addmachine = "UPDATE pc_owner SET scpriceid = '$scpriceid' WHERE pcid = '$pcid'";

@mysqli_query($rs_connect, $rs_insert_addmachine);

header("Location: msp.php?func=viewservicecontract&scid=$scid");
}



function contractlist() {

require("deps.php");
require_once("common.php");

require_once("header.php");

echo "<script type=\"text/javascript\">document.title = \"".pcrtlang("Service Contracts")."\";</script>";

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

if (array_key_exists("scactive", $_REQUEST)) {
$scactive = $_REQUEST['scactive'];
} else {
$scactive = "1";
}


if (array_key_exists("search", $_REQUEST)) {
$search = $_REQUEST['search'];
} else {
$search = "";
}

$search_ue = urlencode($search);


start_blue_box(pcrtlang("Browse Service Contracts"));


echo "<table style=\"width:100%\"><tr><td>";
if($scactive == 1) {
echo "<a href=msp.php?func=contractlist&scactive=0&search=$search_ue&sortby=$sortby class=\"linkbuttonmedium linkbuttongray radiusall\">".pcrtlang("Show Inactive Contracts")."</a>";
} else {
echo "<a href=msp.php?func=contractlist&scactive=1&search=$search_ue&sortby=$sortby class=\"linkbuttonmedium linkbuttongray radiusall\">".pcrtlang("Show Active Contracts")."</a>";
}


echo "</td><td style=\"text-align:right\"><i class=\"fa fa-search fa-lg\"></i>";
echo "<input type=text class=\"textbox\" id=searchbox placeholder=\"".pcrtlang("Enter Search Text")."\" value=\"$search\">";
echo "</td></tr></table>";

echo "<div id=themain>";

echo "</div>";

?>
<script type="text/javascript">
$(document).ready(function () {
     $.get('msp.php?func=contractlistajax&pageNumber=<?php echo $pageNumber; ?>&sortby=<?php echo $sortby; ?>&search=<?php echo $search_ue; ?>&scactive=<?php echo $scactive; ?>', function(data) {
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
                                        $('div#themain').load('msp.php?func=contractlistajax&pageNumber=<?php echo $pageNumber; ?>&sortby=<?php echo $sortby; ?>&scactive=<?php echo $scactive; ?>').slideDown(200,function(){
                                        return false;
                                        });
                                }else{
                                        $('div#themain').load('msp.php?func=contractlistajax&pageNumber=<?php echo $pageNumber; ?>&sortby=<?php echo $sortby; ?>&scactive=<?php echo $scactive; ?>&search='+encodedinv).slideDown(200);
                                }
                        }, 500);
  });
});
</script>


<?php

stop_blue_box();

require("footer.php");

}




function contractlistajax() {

if (array_key_exists("pageNumber", $_REQUEST)) {
$pageNumber = $_REQUEST['pageNumber'];
} else {
$pageNumber = 1;
}

if (array_key_exists("scactive", $_REQUEST)) {
$scactive = $_REQUEST['scactive'];
} else {
$scactive = 1;
}


if (array_key_exists("sortby", $_REQUEST)) {
$sortby = $_REQUEST['sortby'];
} else {
$sortby = "name_asc";
}


if (array_key_exists("scactive", $_REQUEST)) {
$scactive = $_REQUEST['scactive'];
} else {
$scactive = "1";
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
$searchsql = "AND (servicecontracts.scname LIKE '%$search%' OR servicecontracts.sccontactperson LIKE '%$search%' OR pc_group.pcgroupname LIKE '%$search%' OR pc_group.grpemail LIKE '%$search%' OR pc_group.grpphone LIKE '%$search%' OR pc_group.grpworkphone LIKE '%$search%' OR pc_group.grpcellphone LIKE '%$search%' OR pc_group.grpcompany LIKE '%$search%')";
} else {
$searchsql = "";
$search = "";
}
} else {
$searchsql = "";
$search = "";
}

$search_ue = urlencode($search);

$rs_find_cart_items_total = "SELECT * FROM servicecontracts,pc_group WHERE servicecontracts.groupid = pc_group.pcgroupid AND servicecontracts.scactive = '$scactive' $searchsql";
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
$rs_find_cart_items = "SELECT servicecontracts.scid AS scid, servicecontracts.scname AS scname, servicecontracts.sccontactperson AS sccontactperson, servicecontracts.scactive AS scactive,
servicecontracts.groupid AS groupid, servicecontracts.scexpdate AS scexpdate, servicecontracts.rinvoice AS rinvoice, pc_group.pcgroupname AS groupname
FROM servicecontracts,pc_group WHERE servicecontracts.groupid = pc_group.pcgroupid AND servicecontracts.scactive = '$scactive' $searchsql ORDER BY servicecontracts.scid ASC LIMIT $offset,$results_per_page";

} elseif ("$sortby" == "id_desc") {
$rs_find_cart_items = "SELECT servicecontracts.scid AS scid, servicecontracts.scname AS scname, servicecontracts.sccontactperson AS sccontactperson, servicecontracts.scactive AS scactive,
servicecontracts.groupid AS groupid, servicecontracts.scexpdate AS scexpdate, servicecontracts.rinvoice AS rinvoice, pc_group.pcgroupname AS groupname
FROM servicecontracts,pc_group WHERE servicecontracts.groupid = pc_group.pcgroupid AND servicecontracts.scactive = '$scactive' $searchsql ORDER BY servicecontracts.scid DESC LIMIT $offset,$results_per_page";

} elseif ("$sortby" == "name_desc") {
$rs_find_cart_items = "SELECT servicecontracts.scid AS scid, servicecontracts.scname AS scname, servicecontracts.sccontactperson AS sccontactperson, servicecontracts.scactive AS scactive,
servicecontracts.groupid AS groupid, servicecontracts.scexpdate AS scexpdate, servicecontracts.rinvoice AS rinvoice, pc_group.pcgroupname AS groupname
FROM servicecontracts,pc_group WHERE servicecontracts.groupid = pc_group.pcgroupid AND servicecontracts.scactive = '$scactive' $searchsql ORDER BY pc_group.pcgroupname DESC LIMIT $offset,$results_per_page";

} elseif ("$sortby" == "name_asc") {
$rs_find_cart_items = "SELECT servicecontracts.scid AS scid, servicecontracts.scname AS scname, servicecontracts.sccontactperson AS sccontactperson, servicecontracts.scactive AS scactive,
servicecontracts.groupid AS groupid, servicecontracts.scexpdate AS scexpdate, servicecontracts.rinvoice AS rinvoice, pc_group.pcgroupname AS groupname
FROM servicecontracts,pc_group WHERE servicecontracts.groupid = pc_group.pcgroupid AND servicecontracts.scactive = '$scactive' $searchsql ORDER BY pc_group.pcgroupname ASC LIMIT $offset,$results_per_page";

} elseif ("$sortby" == "exp_asc") {
$rs_find_cart_items = "SELECT servicecontracts.scid AS scid, servicecontracts.scname AS scname, servicecontracts.sccontactperson AS sccontactperson, servicecontracts.scactive AS scactive,
servicecontracts.groupid AS groupid, servicecontracts.scexpdate AS scexpdate, servicecontracts.rinvoice AS rinvoice, pc_group.pcgroupname AS groupname
FROM servicecontracts,pc_group WHERE servicecontracts.groupid = pc_group.pcgroupid AND servicecontracts.scactive = '$scactive' $searchsql ORDER BY servicecontracts.scexpdate ASC LIMIT $offset,$results_per_page";

} else {
$rs_find_cart_items = "SELECT servicecontracts.scid AS scid, servicecontracts.scname AS scname, servicecontracts.sccontactperson AS sccontactperson, servicecontracts.scactive AS scactive,
servicecontracts.groupid AS groupid, servicecontracts.scexpdate AS scexpdate, servicecontracts.rinvoice AS rinvoice, pc_group.pcgroupname AS groupname
FROM servicecontracts,pc_group WHERE servicecontracts.groupid = pc_group.pcgroupid AND servicecontracts.scactive = '$scactive' $searchsql ORDER BY servicecontracts.scexpdate DESC LIMIT $offset,$results_per_page";

}


$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);



echo "<br><table class=standard>";
echo "<tr><th>".pcrtlang("ID#");
echo "</th><th><a href=msp.php?func=contractlist&pageNumber=$pageNumber&sortby=id_asc&scactive=$scactive&search=$search_ue class=\"linkbuttontiny linkbuttongray radiustop\">
<i class=\"fa fa-chevron-up\"></i></a><br>";
echo "<a href=msp.php?func=contractlist&pageNumber=$pageNumber&sortby=id_desc&scactive=$scactive&search=$search_ue class=\"linkbuttontiny linkbuttongray radiusbottom\">
<i class=\"fa fa-chevron-down\"></i></a>";
echo "</th><th>".pcrtlang("Customer");
echo "</th><th><a href=msp.php?func=contractlist&pageNumber=$pageNumber&sortby=name_asc&scactive=$scactive&search=$search_ue class=\"linkbuttontiny linkbuttongray radiustop\">
<i class=\"fa fa-chevron-up\"></i></a><br>";
echo "<a href=msp.php?func=contractlist&pageNumber=$pageNumber&sortby=name_desc&scactive=$scactive&search=$search_ue class=\"linkbuttontiny linkbuttongray radiusbottom\">
<i class=\"fa fa-chevron-down\"></i></a>";
echo "</th>";

echo "<th>".pcrtlang("Contract Name");
echo "</th>";

echo "<th>".pcrtlang("Contact Person")."</th><th>".pcrtlang("Expiration");
echo "</th><th><a href=msp.php?func=contractlist&pageNumber=$pageNumber&sortby=exp_asc&scactive=$scactive&search=$search_ue class=\"linkbuttontiny linkbuttongray radiustop\">
<i class=\"fa fa-chevron-up\"></i></a><br>";
echo "<a href=msp.php?func=contractlist&pageNumber=$pageNumber&sortby=exp_desc&scactive=$scactive&search=$search_ue class=\"linkbuttontiny linkbuttongray radiusbottom\">
<i class=\"fa fa-chevron-down\"></i></a>";
echo "</th></tr>";

while($rs_result_q = mysqli_fetch_object($rs_result)) {
$scid = "$rs_result_q->scid";
$scname = "$rs_result_q->scname";
$sccontactperson = "$rs_result_q->sccontactperson";
$scexpdate = "$rs_result_q->scexpdate";
$rinvoice = "$rs_result_q->rinvoice";
$groupname = "$rs_result_q->groupname";
$scactive2 = "$rs_result_q->scactive";
$groupid = "$rs_result_q->groupid";


echo "<tr><td colspan=2>#$scid</td>";
echo "<td colspan=2><a href=group.php?func=viewgroup&pcgroupid=$groupid&groupview=servicecontracts class=\"linkbuttonsmall linkbuttongray radiusall\">$groupname</a></td>";
echo "<td><a href=\"msp.php?func=viewservicecontract&scid=$scid\" class=\"linkbuttonsmall linkbuttongray radiusall\">$scname</a>";

if($rinvoice !=	0) {
if(overduerinvoice($rinvoice) == 1) {
echo "<br><br><span class=colormered><i class=\"fa fa-warning fa-lg faa-flash animated\"></i> ".pcrtlang("Service Contract has Overdue Invoices!")."</span>";
}
}


echo "</td>";

echo "<td>$sccontactperson</td>";


echo "<td colspan=2>$scexpdate</td>";

echo "</tr>";

}

echo "</table>";

stop_blue_box();

echo "<br>";

start_box();
#browse here

echo "<center>";

if($pageNumber != 1) {
$prevpage = $pageNumber - 1;
echo "<a href=msp.php?func=contractlist&pageNumber=$prevpage&sortby=$sortby&scactive=$scactive&search=$search_ue class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-left fa-lg\"></i></a>";
}

$html = get_paged_nav($totalentries, $results_per_page, false);

$html = str_replace("contractlistajax", "contractlist", "$html");
echo "$html";

if($lastpage != $pageNumber) {
$nextpage = $pageNumber + 1;
echo "<a href=msp.php?func=contractlist&pageNumber=$nextpage&sortby=$sortby&scactive=$scactive&search=$search_ue class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-right fa-lg\"></i></a>";
}

echo "</center>";


}



function scactive() {
require_once("validate.php");
require("deps.php");
require("common.php");

$scid = $_REQUEST['scid'];
$scactive = $_REQUEST['scactive'];
$pcgroupid = $_REQUEST['groupid'];
$rinvoice_id = $_REQUEST['rinvoice'];





if($scactive == 0) {
$rs_insert_xri = "UPDATE servicecontracts SET scactive ='0' WHERE scid = '$scid'";
@mysqli_query($rs_connect, $rs_insert_xri);

$rs_rm_rinv = "UPDATE rinvoices SET invactive = '0' WHERE rinvoice_id = '$rinvoice_id'";
@mysqli_query($rs_connect, $rs_rm_rinv);
header("Location: group.php?func=viewgroup&groupview=servicecontracts&pcgroupid=$pcgroupid");
} else {
$rs_insert_xri = "UPDATE servicecontracts SET scactive ='1' WHERE scid = '$scid'";
@mysqli_query($rs_connect, $rs_insert_xri);
header("Location: msp.php?func=viewservicecontract&scid=$scid");
}

}




switch($func) {
                                                                                                    
    default:
    nothing();
    break;

    case "viewservicecontract":
    viewservicecontract();
    break;

                                
    case "newservicecontract":
    newservicecontract();
    break;

  case "savenewservicecontract":
    savenewservicecontract();
    break;

 case "editservicecontract":
    editservicecontract();
    break;

 case "editservicecontract2":
    editservicecontract2();
    break;

 case "adduser":
    adduser();
    break;

 case "deluser":
    deluser();
    break;

 case "setusercharge":
    setusercharge();
    break;

 case "addmachine":
    addmachine();
    break;

 case "delmachine":
    delmachine();
    break;

 case "addexistingrinvoice":
    addexistingrinvoice();
    break;

 case "createrinvoice":
    createrinvoice();
    break;

 case "createrinvoice2":
    createrinvoice2();
    break;

 case "addlaboritem":
    addlaboritem();
    break;

 case "deleterinvoiceitem":
    deleterinvoiceitem();
    break;

 case "removerinvoice":
    removerinvoice();
    break;

 case "scpricing":
    scpricing();
    break;

 case "scpricingsave":
    scpricingsave();
    break;

 case "scpricingdelete":
    scpricingdelete();
    break;

 case "scpricingadd":
    scpricingadd();
    break;

 case "reorderscpricing":
    reorderscpricing();
    break;

 case "setmachineprice":
    setmachineprice();
    break;

 case "contractlist":
    contractlist();
    break;

 case "contractlistajax":
    contractlistajax();
    break;


 case "scactive":
    scactive();
    break;


}

