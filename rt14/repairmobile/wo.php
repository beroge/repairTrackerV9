<?php 

/***************************************************************************
 *   copyright            : (C) 2017 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/

require("validate2.php");

?>

<?php


require("deps.php");
require_once("common.php");

$startpagetimewo = microtime(true);

if (isset($_REQUEST['pcwo'])) {
$pcwo = $_REQUEST['pcwo'];
} else {
$pcwo = "";
}






$rs_findpc = "SELECT * FROM pc_wo WHERE woid = '$pcwo'";
$rs_result = mysqli_query($rs_connect, $rs_findpc);



while($rs_result_q = mysqli_fetch_object($rs_result)) {
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
while($rs_result_q2 = mysqli_fetch_object($rs_result2)) {
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

if ($pcextra != "") {
$custompcinfoindb3 = unserialize($pcextra);
} else {
$custompcinfoindb3 = array();
}
if(is_array($custompcinfoindb3)) {
$custompcinfoindb = $custompcinfoindb3;
} else {
$custompcinfoindb = array();
}


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

$rs_qce = "SELECT actionid FROM userlog WHERE reftype = 'woid' AND refid = '$pcwo'";
$rs_resultce1 = mysqli_query($rs_connect, $rs_qce);
$actionids = array();
while($rs_result_qce1 = mysqli_fetch_object($rs_resultce1)) {
$actionids[] = "$rs_result_qce1->actionid";
}

if("$pccompany" == "") {
$boxfill = "<font class=textwhite16b>$pcname &bull; $pcmake</font></td>";
} else {
$boxfill = "<font class=textwhite16b>$pcname &bull; $pccompany &bull; $pcmake</font></td>";
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

$groupfill = "<button type=button onClick=\"parent.location='group.php?func=viewgroup&pcgroupid=$pcgroupid'\"><i class=\"fa fa-group fa-lg\"></i> $pcgroupname</button>";
######
$groupfill .= "<center><table><tr><td style=\"background:#333333;border-radius:3px;\"><i style=\"color:#ffffff\" class=\"fa fa-phone fa-lg fa-fw\"></i></td><td>";
if($grpphone != "") {
$groupfill .= "<i class=\"fa fa-home fa-lg fa-fw\"></i> $grpphone<br>";
}
if($grpcellphone != "") {
$groupfill .= "<i class=\"fa fa-mobile fa-lg fa-fw\"></i> $grpcellphone<br>";
}
if($grpworkphone != "") {
$groupfill .= "<i class=\"fa fa-briefcase fa-lg fa-fw\"></i> $grpworkphone";
}
$groupfill .= "</td></tr></table></center><br>";
if($grpaddress != "") {
$grpaddressbr = nl2br($grpaddress);
$groupfill .= "<center><table><tr><td style=\"background:#333333;border-radius:3px;\"><i style=\"color:#ffffff\" class=\"fa fa-map-marker fa-lg fa-fw\"></i></td><td>$grpaddressbr<br>";
if($grpaddress2 != "") {
$groupfill .= "$grpaddress2<br>";
}
if(($grpcity != "") && ($grpstate != "") && ($grpzip != "")) {
$groupfill .= "$grpcity, $grpstate $grpzip";
}
$groupfill .= "</td></tr></table></center>";
}
if($grpemail != "") {
$groupfill .= "<button type=button onClick=\"parent.location='mailto:$grpemail'\"><i class=\"fa fa-envelope-o fa-lg fa-fw\"></i> $grpemail</button>";
}
if($grpnotes != "") {
$groupfill .= "<center><table class=standard><tr><td>".pcrtlang("Notes").":</td></tr><tr><td>$grpnotes</td></tr></table></center><br>";
}

}

$boxstyles = getboxstyle("$pcstatus");
start_status_box("$pcstatus","$boxfill");

echo "<div data-role=\"tabs\" id=\"tabs\">";
echo "<div data-role=\"navbar\">";
echo "<ul>";
echo "<li><a href=\"#ownerinfo\" data-ajax=\"false\">".pcrtlang("Customer Info")."</a></li>";
echo "<li><a href=\"#workorderinfo\" data-ajax=\"false\">".pcrtlang("Work Order Info")."</a></li>";
echo "<li><a href=\"#assetinfo\" data-ajax=\"false\">".pcrtlang("Asset Info")."</a></li>";
echo "<li><a href=\"#scans\" data-ajax=\"false\">".pcrtlang("Checks, Scans, Actions")."</a></li>";
echo "<li><a href=\"#notes\" data-ajax=\"false\">".pcrtlang("Work Order Notes")."</a></li>";
echo "<li><a href=\"#travellog\" data-ajax=\"false\">".pcrtlang("Travel Log")."</a></li>";
echo "<li><a href=\"#timer\" data-ajax=\"false\">".pcrtlang("Timers")."</a></li>";
echo "<li><a href=\"#repaircart\" data-ajax=\"false\">".pcrtlang("Repair Cart")."</a></li>";
echo "<li><a href=\"#specialorders\" data-ajax=\"false\">".pcrtlang("Special Orders")."</a></li>";
echo "<li><a href=\"#invoicing\" data-ajax=\"false\">".pcrtlang("Invoices")."</a></li>";
echo "</ul>";
echo "</div>";

echo "<div id=\"ownerinfo\" class=\"ui-body-d ui-content\" style=\"padding:2px;\">";




if($pcgroupid != "0") {
echo "<div data-role=\"collapsible\" data-theme=\"b\">";
echo "<h3>".pcrtlang("Group").": $pcgroupname</h3>";
echo "$groupfill";
echo "</div>";
}




echo "<center><h3>".pcrtlang("Asset/Customer ID").": $pcid</h3></center><br>";

if($custsourceid != "0") {
$rs_cssq = "SELECT * FROM custsource WHERE custsourceid='$custsourceid'";
$rs_result1cs = mysqli_query($rs_connect, $rs_cssq);
while($rs_result_qcs1 = mysqli_fetch_object($rs_result1cs)) {
$thesource = "$rs_result_qcs1->thesource";
$sourceicon = "$rs_result_qcs1->sourceicon";
echo "<img src=../repair/images/custsources/$sourceicon align=absmiddle> ".pcrtlang("Customer Source").": $thesource<br><br>";
}

}

$boxstyles = getboxstyle("$pcstatus");
echo "<center><table style=\"border-collapse:collapse;margin:0px;padding0px;\"><tr><td valign=top>";

if (($pcphone != "") || ($pcworkphone != "") || ($pccellphone != "")) {

echo "<table style=\"border-collapse:collapse;margin:0px;padding:0px;width:100%;\"><tr><td bgcolor=#$boxstyles[selectorcolor] style=\"border-radius:3px;\"><i class=\"fa fa-phone fa-lg fa-fw\" style=\"color:#ffffff;\"></i></td><td>";

echo "<table style=\"border-collapse:collapse;margin:0px;padding:0px;width:100%;\">";

if($pcphone != "") {
echo "<tr><td style=\"text-align:right\">";
if($prefcontact == "home") {
echo "<font style=\"color: #$boxstyles[selectorcolor];\"><i class=\"fa fa-star\"></i></font>";
}
echo "<i class=\"fa fa-home fa-lg fa-fw\"></i></td><td><a href=\"tel:$pcphone\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" style=\"padding:3px;\">$pcphone</a></td></tr>";
}

if($pccellphone != "") {
echo "<tr><td style=\"text-align:right\">";


echo "</td><td>";

echo "<a href=\"tel:$pccellphone\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" style=\"padding:3px;\">";

if($prefcontact == "sms") {
echo "<font style=\"color: #$boxstyles[selectorcolor];\"><i class=\"fa fa-star\"></i></font> ";
}


echo "$pccellphone</a>";


echo "</td></tr>";
}

if($pcworkphone != "") {
echo "<tr><td style=\"text-align:right\">";
if($prefcontact == "work") {
echo "<font style=\"color: #$boxstyles[selectorcolor];\"><i class=\"fa fa-star\"></i></font>";
}

echo "<i class=\"fa fa-briefcase fa-lg fa-fw \"></i> </td><td><a href=\"tel:$pcworkphone\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" style=\"padding:3px;\">$pcworkphone</a>";
echo "</td></tr>";
}
echo "</table>";
echo "</td></tr></table>";
}

echo "</td></tr><tr><td valign=top><br>";

$addystring = urlencode("$pcaddress $pccity $pcstate $pczip");

if($pcaddress != "") {
$pcaddressbr = nl2br($pcaddress);
echo "<table><tr><td bgcolor=#$boxstyles[selectorcolor] style=\"border-radius:3px;\"><i class=\"fa fa-map-marker fa-lg fa-fw\" style=\"color:#ffffff;\"></i></td><td>$pcaddressbr<br>";
if($pcaddress2 != "") {
echo "<font class=text12b>$pcaddress2</font><br>";
}

echo "<font class=text12b>$pccity, $pcstate $pczip</font>";
echo "<br><button  type=button style=\"padding:2px;\" onClick=\"parent.location='pc.php?func=callmap&woid=$pcwo&pcid=$pcid'\"><i class=\"fa fa-map-marker\"></i> ".pcrtlang("map")."</button>";
echo "<button  type=button style=\"padding:2px;\" onClick=\"parent.location='pc.php?func=addmiles&woid=$pcwo&addystring=$addystring'\"><i class=\"fa fa-car\"></i> ".pcrtlang("add mileage")."</button>";
echo "</td></tr></table>";
}

echo "</td></tr></table></center>";


if($pcemail != "") {
echo "<br>";
echo " <button  type=button style=\"padding:2px;\" onClick=\"parent.location='mailto:$pcemail'\">";
if($prefcontact == "email") {
echo "<font style=\"color: #$boxstyles[selectorcolor];\"><i class=\"fa fa-star\"></i></font> ";
} 
echo "<i class=\"fa fa-envelope-o\"></i> $pcemail</button>";
}


echo "<br><center><table class=standard><tr><th>".pcrtlang("Notes").":</th></tr><tr><td>$pcnotes</td></tr></table></center><br>";

######
#wip
echo "<br><table class=standard><tr><th><i class=\"fa fa-tags fa-lg fa-fw\"></i> ".pcrtlang("Tags")."</th></tr><tr><td>";


displaytags($pcid,$pcgroupid,32);


echo "<div data-role=\"collapsible\" data-theme=\"b\">";
echo "<h3>".pcrtlang("Add Tags")."</h3>";

#wip

echo "<form method=post action=\"pc.php?func=tagsave\" data-ajax=\"false\"><input type=hidden name=woid value=\"$pcwo\"><input type=hidden name=pcid value=\"$pcid\">";

echo "<fieldset data-role=\"controlgroup\">";

$pcownertagsarray = explode_list($pcownertags);

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
if(in_array($tagid, $pcownertagsarray)) {
$tagcheck = "checked";
}
echo "<input type=checkbox $tagcheck id=\"$tagid\" value=\"$tagid\" name=\"tags[]\">
<label for=\"$tagid\"><img src=../repair/images/tags/$tagicon width=16> $thetag</input></label>";
}
}

echo "</fieldset>";

echo "<br><input class=button type=submit value=\"".pcrtlang("Save Tags")."\"></form>";

echo "</div>";


echo "</td></tr></table><br>";



#############################
# Start Passwords

echo "<table class=standard><tr><th colspan=2>";


echo "<i class=\"fa fa-key fa-lg fa-fw\"></i> ".pcrtlang("Credentials")."<br>";
echo "<fieldset data-role=\"controlgroup\" data-type=\"horizontal\" class=floatright>";
echo "<a href=\"javascript:void(0);\"  class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" id=pass1change>
<i class=\"fa fa-lock\"></i></a>";

echo "<a href=\"javascript:void(0);\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" id=pass2change>
<i class=\"fa fa-thumb-tack\"></i></a>";

echo "<a href=\"javascript:void(0);\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" id=pass3change>
<i class=\"fa fa-th\"></i></a>";

echo "<a href=\"javascript:void(0);\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" id=pass5change>
<i class=\"fa fa-question-circle\"></i></a>";

echo "</fieldset>";

echo "</th>";
echo "</tr><tr><td colspan=2>";

echo "<div id=pass1box style=\"display:none;border:2px #cccccc solid;padding:5px;border-radius:3px;\">";
echo "<form action=pc.php?func=newpass method=post data-ajax=\"false\"><input type=hidden name=pcid value=$pcid><input type=hidden name=woid value=$pcwo><input type=hidden name=credtype value=1>
<input type=hidden name=returnto value=wo>";

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
echo "<input type=text class=textbox name=username placeholder=\"".pcrtlang("Enter Username")."\">";
echo "<input type=text class=textbox name=password placeholder=\"".pcrtlang("Enter Password")."\">";
echo "<button type=submit data-theme=\"b\"><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button>";
echo "</form></div>";

echo "<div id=pass2box style=\"display:none;border:2px #cccccc solid;padding:5px;border-radius:3px;\">";
echo "<form action=pc.php?func=newpass method=post data-ajax=\"false\"><input type=hidden name=pcid value=$pcid><input type=hidden name=woid value=$pcwo><input type=hidden name=credtype value=2>
<input type=hidden name=returnto value=wo>";
echo "<select name=creddesc onchange='document.getElementById(\"creddesc2box\").value=this.options[this.selectedIndex].value '>";
echo "$creddescoptions";
echo "</select>";
echo "<input type=text class=textbox id=creddesc2box name=creddesc placeholder=\"".pcrtlang("Description")."\">";
echo "<input type=text class=textbox name=password placeholder=\"".pcrtlang("Enter Pin")."\"> ";
echo "<button type=submit data-theme=\"b\"><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button>";
echo "</form></div>";


echo "<div id=pass3box style=\"display:none;border:2px #cccccc solid;padding:5px;border-radius:3px;\">";
echo "<div id=patternmain></div>";
echo "<form action=pc.php?func=newpass method=post data-ajax=\"false\"><input type=hidden name=pcid value=$pcid><input type=hidden name=woid value=$pcwo><input type=hidden name=credtype value=3>
<input type=hidden name=returnto value=wo>";
echo "<select name=creddesc1 onchange='document.getElementById(\"creddesc3box\").value=this.options[this.selectedIndex].value '>";
echo "$creddescoptions";
echo "</select>";
echo "<input type=text class=textbox id=creddesc3box name=creddesc style=\"width:250px\" placeholder=\"".pcrtlang("Description")."\">";
echo "<input type=hidden class=textbox name=newpattern id=patterntextbox> ";
echo "<button type=submit data-theme=\"b\"><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button>";
echo "</form>";
echo "</div>";


echo "<div id=pass5box style=\"display:none;border:2px #cccccc solid;padding:5px;border-radius:3px;\">";
echo "<form action=pc.php?func=newpass method=post data-ajax=\"false\"><input type=hidden name=pcid value=$pcid><input type=hidden name=woid value=$pcwo><input type=hidden name=credtype value=5><input type=hidden name=returnto value=wo>";
echo "<select name=creddesc onchange='document.getElementById(\"creddesc5box\").value=this.options[this.selectedIndex].value '>";
echo "$creddescoptions";
echo "</select>";
echo "<input type=text class=textbox id=creddesc5box name=creddesc placeholder=\"".pcrtlang("Description")."\">";
echo "<input type=text class=textbox name=username placeholder=\"".pcrtlang("Enter Security Question")."\">";
echo "<input type=text class=textbox name=password placeholder=\"".pcrtlang("Enter Answer")."\">";
echo " <button type=submit data-theme=\"b\"> <i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button>";
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
echo "<table class=\"$badgestyle\"><tr><td><i class=\"fa fa-lock fa-lg fa-fw\"></i></td>";
echo "<td><strong>$creddesc</strong>";

echo "<br><i class=\"fa fa-user\"></i> $creduser
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class=\"fa fa-key\"></i> $credpass<br>";

if (($pcgroupid != 0) && ($credgroupid == 0)) {
echo "<a href=\"pc.php?func=movecred&woid=$pcwo&groupid=$pcgroupid&credid=$credid&moveto=group&pcid=$pcid\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"  data-ajax=\"false\" style=\"padding:2px;\">
<i class=\"fa fa-group fa-lg\"></i></a>";
} elseif ($pcgroupid != 0) {
echo "<a href=\"pc.php?func=movecred&woid=$pcwo&groupid=$pcgroupid&credid=$credid&moveto=wo&pcid=$pcid\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"  data-ajax=\"false\" style=\"padding:2px;\">
<i class=\"fa fa-clipboard fa-lg\"></i></a>";
}


echo "<a href=\"pc.php?func=editcred&woid=$pcwo&credid=$credid&credtype=$credtype&returnto=wo&pcid=$pcid\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"  data-ajax=\"false\" style=\"padding:2px;\">
<i class=\"fa fa-edit fa-lg\"></i></a>";
echo "<a href=\"pc.php?func=deletecred&woid=$pcwo&credid=$credid&returnto=wo&pcid=$pcid\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"  data-ajax=\"false\" style=\"padding:2px;\"
onClick=\"return confirm('".pcrtlang("Are you sure you want to delete this credential?")."')\"><i class=\"fa fa-trash fa-lg\"></i></a>";

echo "</td></tr></table>";
}

if($credtype == 2) {
echo "<table class=\"$badgestyle\"><tr><td><i class=\"fa fa-thumb-tack fa-lg fa-fw\"></i></td>";
echo "<td><strong>$creddesc</strong>";

echo "<br><i class=\"fa fa-thumb-tack\"></i> $credpass<br>";

if (($pcgroupid != 0) && ($credgroupid == 0)) {
echo "<a href=\"pc.php?func=movecred&woid=$pcwo&groupid=$pcgroupid&credid=$credid&moveto=group&pcid=$pcid\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"  data-ajax=\"false\" style=\"padding:2px;\">
<i class=\"fa fa-group fa-lg\"></i></a>";
} elseif ($pcgroupid != 0) {
echo "<a href=\"pc.php?func=movecred&woid=$pcwo&groupid=$pcgroupid&credid=$credid&moveto=wo&pcid=$pcid\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"  data-ajax=\"false\" style=\"padding:2px;\">
<i class=\"fa fa-clipboard fa-lg\"></i></a>";
}

echo "<a href=\"pc.php?func=editcred&woid=$pcwo&credid=$credid&credtype=$credtype&returnto=wo&pcid=$pcid\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"  data-ajax=\"false\" style=\"padding:2px;\">
<i class=\"fa fa-edit fa-lg\"></i></a>";
echo "<a href=\"pc.php?func=deletecred&woid=$pcwo&credid=$credid&returnto=wo\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"  data-ajax=\"false\" style=\"padding:2px;\"
onClick=\"return confirm('".pcrtlang("Are you sure you want to delete this PIN?")."')\"><i class=\"fa fa-trash fa-lg\"></i></a>";
echo "</td></tr></table>";
}

if($credtype == 3) {
echo "<table class=\"$badgestyle\"><tr><td><i class=\"fa fa-th fa-lg fa-fw\"></i></td>";
echo "<td><strong>$creddesc</strong><br>";

echo draw3x3("$patterndata","small");
echo "<br>";

if (($pcgroupid != 0) && ($credgroupid == 0)) {
echo "<a href=\"pc.php?func=movecred&woid=$pcwo&groupid=$pcgroupid&credid=$credid&moveto=group&pcid=$pcid\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"  data-ajax=\"false\" style=\"padding:2px;\">
<i class=\"fa fa-group fa-lg\"></i></a>";
} elseif ($pcgroupid != 0) {
echo "<a href=\"pc.php?func=movecred&woid=$pcwo&groupid=$pcgroupid&credid=$credid&moveto=wo&pcid=$pcid\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"  data-ajax=\"false\" style=\"padding:2px;\">
<i class=\"fa fa-clipboard fa-lg\"></i></a>";
}


echo "<a href=\"pc.php?func=deletecred&woid=$pcwo&credid=$credid&returnto=wo&pcid=$pcid\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"  data-ajax=\"false\" style=\"padding:2px;\"
onClick=\"return confirm('".pcrtlang("Are you sure you want to delete this pattern?")."')\"><i class=\"fa fa-trash fa-lg\"></i></a><br>";
echo "</td></tr></table>";
}

if($credtype == 5) {
echo "<table class=\"$badgestyle\"><tr><td><i class=\"fa fa-question-circle fa-lg fa-fw\"></i></td>";
echo "<td><strong>$creddesc</strong>";
echo "<br><i class=\"fa fa-question\"></i> $creduser<br><i class=\"fa fa-commenting-o\"></i> $credpass<br>";

if (($pcgroupid != 0) && ($credgroupid == 0)) {
echo "<a href=\"pc.php?func=movecred&woid=$pcwo&groupid=$pcgroupid&credid=$credid&moveto=group&pcid=$pcid\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"  data-ajax=\"false\" style=\"padding:2px;\">
<i class=\"fa fa-group fa-lg\"></i></a>";
} elseif ($pcgroupid != 0) {
echo "<a href=\"pc.php?func=movecred&woid=$pcwo&groupid=$pcgroupid&credid=$credid&moveto=wo&pcid=$pcid\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"  data-ajax=\"false\" style=\"padding:2px;\" >
<i class=\"fa fa-clipboard fa-lg\"></i></a>";
}

echo "<a href=\"pc.php?func=editcred&woid=$pcwo&credid=$credid&credtype=$credtype&returnto=wo&pcid=$pcid\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"  data-ajax=\"false\" style=\"padding:2px;\" >
<i class=\"fa fa-edit fa-lg\"></i></a>";
echo "<a href=\"pc.php?func=deletecred&woid=$pcwo&credid=$credid&returnto=wo&pcid=$pcid\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" data-ajax=\"false\"  style=\"padding:2px;\" 
onClick=\"return confirm('".pcrtlang("Are you sure you want to delete this security question?")."')\"><i class=\"fa fa-trash fa-lg\"></i></a>";

echo "</td></tr></table>";
}



}


echo "</td></tr></table><br>";



# End Passwords
###############################



####
$rs_srsql = "SELECT * FROM servicereminders WHERE srpcid = '$pcid' ORDER BY srdate ASC";
$rs_result1srsql = mysqli_query($rs_connect, $rs_srsql);
$total_sr = mysqli_num_rows($rs_result1srsql);

if ($total_sr > 0) {
echo "<table class=doublestandard><tr><th colspan=2>";
echo pcrtlang("Service Reminders")."</th></tr>";
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
$srcanned4 .= "<h5>$srtitle</h5>$srtext";
}
}


$srboxfill = "<h3>".pcrtlang("Service Reminder Message").":</h3>$srnote<br><br>";
$srboxfill .= "<h3>".pcrtlang("Service Reminder Standard Messages").":</h3>$srcanned4";


echo "<div data-role=\"popup\" id=srpop$srid>";
echo "<a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-corner-all ui-shadow ui-btn ui-icon-delete ui-btn-icon-notext ui-btn-right\">Close</a>";
echo "$srboxfill";
echo "</div>";


echo "<tr><td>";
echo "<a href=\"#srpop$srid\" data-rel=\"popup\" style=\"padding:2px;\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" data-transition=\"pop\"><img src=../repair/images/reminder.png style=\"height:16px;\"> ".pcrtlang("View Reminder")."</a>";
echo "</td><td>";
echo "<font class=text10b>$srdate</font></td></tr><tr>";
if ($srsent == 0) {
echo "<td style=\"vertical-align:middle;\"><font class=text10b>".pcrtlang("Status").": </font><font class=textred10>".pcrtlang("Unsent")."</font></td>";
} elseif ($srsent == 1) {
echo "<td style=\"vertical-align:middle;\"><font class=text10b>".pcrtlang("Status").": </font><font class=textblue10>".pcrtlang("Sent")."</font></td>";
} else {
echo "<td style=\"vertical-align:middle;\"><font class=text10b>".pcrtlang("Status").": </font><font class=textblue10>".pcrtlang("Recurring")."</font></td>";
}
echo "<td style=\"vertical-align:middle;\">";
echo "<button  type=button style=\"padding:2px;\" onClick=\"parent.location='servicereminder.php?func=editsr&woid=$pcwo&pcid=$pcid&srid=$srid'\"><i class=\"fa fa-edit\"></i> ".pcrtlang("edit")."</a>";
echo "<button  type=button style=\"padding:2px;\" onClick=\"parent.location='servicereminder.php?func=deletesr&woid=$pcwo&srid=$srid\" onClick=\"return confirm('".pcrtlang("Are you sure you want to delete this service reminder")."')\"><i class=\"fa fa-trash-o\"></i> ".pcrtlang("delete")."</a></td></tr>";
}
echo "</table><br>";
}


##

$rs_rwosql = "SELECT * FROM rwo WHERE pcid = '$pcid' ORDER BY rwodate ASC";
$rs_result1rwosql = mysqli_query($rs_connect, $rs_rwosql);
$total_rwo = mysqli_num_rows($rs_result1rwosql);

if ($total_rwo > 0) {
echo "<br><table class=standard><tr><th colspan=4>";
echo pcrtlang("Recurring Work Orders")."</th></tr>";
while($rs_result_rwosql1 = mysqli_fetch_object($rs_result1rwosql)) {
$rwoid = "$rs_result_rwosql1->rwoid";
$rwodate = "$rs_result_rwosql1->rwodate";
$rwointerval = "$rs_result_rwosql1->rwointerval";
$rwotask = nl2br("$rs_result_rwosql1->rwotask");
$tasksummary = "$rs_result_rwosql1->tasksummary";

echo "<td>$tasksummary<br><span class=sizeme10>".pcrtlang("Next Recurrence").": $rwodate</span></td><td style=\"text-align:right\">";

echo "<button type=button onClick=\"parent.location='rwo.php?func=editrwo&woid=$pcwo&pcid=$pcid&rwoid=$rwoid'\" class=\"ui-btn-inline ui-btn ui-shadow ui-corner-all\"><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("edit")."</button>";




echo "<a href=\"#popupdeleterwo$rwoid\" data-rel=\"popup\" data-position-to=\"window\" data-transition=\"pop\"
class=\"ui-btn-inline ui-btn ui-shadow ui-corner-all\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> remove</a>";
echo "<div data-role=\"popup\" id=\"popupdeleterwo$rwoid\" data-overlay-theme=\"b\"  data-theme=\"a\" data-dismissible=\"false\">";
echo "<div data-role=\"header\" data-theme=\"b\">";
echo "<h1>".pcrtlang("Delete")."?</h1>";
echo "</div>";
echo "<div role=\"main\" class=\"ui-content\">";
echo "<p>".pcrtlang("Are you sure you wish to delete this recurring work order?")."</p>";
echo "<div align=\"right\"><a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\" data-inline=\"true\">
<i class=\"fa fa-ban fa-lg\"></i> ".pcrtlang("Cancel")."</a>";
echo "<button onClick=\"parent.location='rwo.php?func=deleterwo&woid=$pcwo&rwoid=$rwoid'\" data-inline=\"true\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")." </button></div>";
echo "</div>";
echo "</div>";

echo "</td></tr>";

}

echo "</table><br><br>";
}





####



function validate_zipfile2($v_filename) {
   return preg_match('/^[a-z0-9_-]+\.(zipfile|zip)$/i', $v_filename) ? '1' : '0';
}


$rs_asql = "SELECT * FROM attachments WHERE pcid = '$pcid' ORDER BY attach_date ASC";
$rs_result1asql = mysqli_query($rs_connect, $rs_asql);
$total_attachments = mysqli_num_rows($rs_result1asql);

if ($total_attachments > 0) {
echo "<table class=doublestandard><tr><th colspan=3>";
echo pcrtlang("Asset Attachments")."</th></tr>";
while($rs_result_asql1 = mysqli_fetch_object($rs_result1asql)) {
$attach_id = "$rs_result_asql1->attach_id";
$attach_title = "$rs_result_asql1->attach_title";
$attach_size = "$rs_result_asql1->attach_size";
$attach_filename = "$rs_result_asql1->attach_filename";
$attach_date = "$rs_result_asql1->attach_date";
$fileextpc = strtolower(substr(strrchr($attach_filename, "."), 1));


if($attach_size == 0) {
$thebytes = "";
} else {
$thebytes = formatBytes($attach_size);
}

if(filter_var($attach_filename, FILTER_VALIDATE_URL)) {
        $fileextpc = 'url';
        $attach_link = "$attach_filename";
} else {
        $attach_link = "attachment.php?func=get&attach_id=$attach_id";
}


echo "<tr><td>";
echo "<button type=button onClick=\"parent.location='$attach_link'\" ><i class=\"fa fa-download fa-lg\"></i> $attach_title</button>";


echo "<center><i class=\"fa fa-paperclip fa-lg\"></i> $fileextpc $thebytes</center>";
echo "</td></tr>";
echo "<tr><td>";

echo "<div data-role=\"collapsible\">";
echo "<h3>".pcrtlang("Attachment Actions")."</h3>";

echo "<button type=button style=\"padding:2px;\" onClick=\"parent.location='attachment.php?func=editattach&woid=$pcwo&attach_id=$attach_id'\"><i class=\"fa fa-edit\"></i> ".pcrtlang("edit")."</button>";


echo "<a href=\"#popupdeleteattach$attach_id\" data-rel=\"popup\" data-position-to=\"window\" data-transition=\"pop\" class=\"ui-btn ui-shadow ui-corner-all\">";
echo "<i class=\"fa fa-trash\"></i> ".pcrtlang("delete")."</a>";
echo "<div data-role=\"popup\" id=\"popupdeleteattach$attach_id\" data-overlay-theme=\"b\"  data-theme=\"a\" data-dismissible=\"false\">";
echo "<div data-role=\"header\" data-theme=\"b\">";
echo "<h1>".pcrtlang("Delete Attachment")."?</h1>";
echo "</div>";
echo "<div role=\"main\" class=\"ui-content\">";
echo "<p>".pcrtlang("Are you sure you wish to permanently delete this Attachment!!!?")."</p>";
echo "<div align=\"right\"><a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\" data-inline=\"true\"><i class=\"fa fa-ban fa-lg\"></i>  ".pcrtlang("Cancel")."</a>";
echo "<button onClick=\"parent.location='attachment.php?func=deleteattach&woid=$pcwo&attach_id=$attach_id&attachfilename=$attach_filename'\" data-inline=\"true\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")." </button></div>";
echo "</div>";
echo "</div>";


echo "<button  type=button style=\"padding:2px;\" onClick=\"parent.location='attachment.php?func=moveattach&woid=$pcwo&attach_id=$attach_id&pcid=$pcid&moveto=wo'\"><i class=\"fa fa-arrows-h\"></i> ".pcrtlang("move to wo")."</button>";

if (validate_zipfile2($attach_filename) == '1') {
if (preg_match("/d7/i", "$attach_title")) {
echo "<button  type=button style=\"padding:2px;\" onClick=\"parent.location='pc.php?func=editowner&woid=$pcwo&pcid=$pcid&attach_filename=$attach_filename'\"><img src=../repair/images/d7.png> ".pcrtlang("import specs")."</button>";
echo "<button  type=button style=\"padding:2px;\" onClick=\"parent.location='pc.php?func=addd7note&woid=$pcwo&pcid=$pcid&attach_filename=$attach_filename'\"><img src=../repair/images/d7.png> ".pcrtlang("import notes")."</button>";
}

if (preg_match("/uvk/i", "$attach_title")) {
echo "<button  type=button style=\"padding:2px;\" onClick=\"parent.location='uvk.php?func=readsystemreport&filename=$attach_filename'\"><img src=../repair/images/uvk.png> ".pcrtlang("view system info")."</button>";
echo "<button  type=button style=\"padding:2px;\" onClick=\"parent.location='pc.php?func=editowner&woid=$pcwo&pcid=$pcid&attach_filenameuvk=$attach_filename'\"><img src=../repair/images/uvk.png> ".pcrtlang("import specs")."</button>";
}


}

echo "</div>";

echo "</td></tr>";
}
echo "</table>";
}


echo "<div data-role=\"collapsible\" data-theme=\"b\">";
echo "<h3>".pcrtlang("Owner/Device Actions")."</h3>";

echo "<button onClick=\"parent.location='pc.php?func=editowner&pcid=$pcid&woid=$pcwo'\"><img src=../repair/images/customeredit.png style=\"width:20px;\" align=absmiddle> ".pcrtlang("Edit Owner/Device")."</button>";

if ($ipofpc == "admin") {

echo "<a href=\"#popupdeletepc\" data-rel=\"popup\" data-position-to=\"window\" data-transition=\"pop\" class=\"ui-btn ui-shadow ui-corner-all\">";
echo "<img src=../repair/images/del.png style=\"width:20px;\" align=absmiddle> ".pcrtlang("Delete Customer/Device")."</a>";
echo "<div data-role=\"popup\" id=\"popupdeletepc\" data-overlay-theme=\"b\"  data-theme=\"a\" data-dismissible=\"false\">";
echo "<div data-role=\"header\" data-theme=\"b\">";
echo "<h1>".pcrtlang("Delete Customer/Device")."?</h1>";
echo "</div>";
echo "<div role=\"main\" class=\"ui-content\">";
echo "<p>".pcrtlang("Are you sure you wish to permanently delete this Customer/Device and all associated Work Orders!!!?")."</p>";
echo "<div align=\"right\"><a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\" data-inline=\"true\">";
echo "<i class=\"fa fa-ban fa-lg\"></i>  ".pcrtlang("Cancel")."</a>";
echo "<button onClick=\"parent.location='admin.php?func=admindeletepc&pcid=$pcid'\" data-inline=\"true\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")." </button></div>";
echo "</div>";
echo "</div>";

}


if ($pcgroupid != "0") {


echo "<a href=\"#popupremovefromgroup\" data-rel=\"popup\" data-position-to=\"window\" data-transition=\"pop\" class=\"ui-btn ui-shadow ui-corner-all\">";
echo "<img src=../repair/images/groupremove.png style=\"width:20px;\"> ".pcrtlang("Remove From Group")."</a>";
echo "<div data-role=\"popup\" id=\"popupremovefromgroup\" data-overlay-theme=\"b\"  data-theme=\"a\" data-dismissible=\"false\">";
echo "<div data-role=\"header\" data-theme=\"b\">";
echo "<h1>".pcrtlang("Remove From Group")."?</h1>";
echo "</div>";
echo "<div role=\"main\" class=\"ui-content\">";
echo "<p>".pcrtlang("Are you sure you wish to remove this PC/Customer from the group").": $pcgroupname?</p>";
echo "<div align=\"right\"><a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\" data-inline=\"true\"><i class=\"fa fa-ban fa-lg\"></i>  ".pcrtlang("Cancel")."</a>";
echo "<button onClick=\"parent.location='group.php?func=removefromgroup&pcid=$pcid&woid=$pcwo'\" data-inline=\"true\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Remove")." </button></div>";
echo "</div>";
echo "</div>";

echo "<button onClick=\"parent.location='group.php?func=viewgroup&pcgroupid=$pcgroupid'\"><img src=../repair/images/groups.png style=\"width:20px;\"> ".pcrtlang("View Group")."</button>";
} else {

echo "<button onClick=\"parent.location='group.php?func=addtogroup&pcid=$pcid&woid=$pcwo&pcname=$pcname2'\"><img src=../repair/images/groupadd.png style=\"width:20px;\"> ".pcrtlang("Add to Group")."</button>";
echo "<button onClick=\"parent.location='group.php?func=addtogroupnew&pcid=$pcid&woid=$pcwo&groupname=$pcname2&grpcompany=$pccompany2&pccompany=$pccompany2&pcaddress1=$pcaddress12&pcaddress2=$pcaddress22&pccity=$pccity2&pcstate=$pcstate2&pczip=$pczip2&pcemail=$pcemail2&pchomephone=$pchomephone2&pccellphone=$pccellphone2&pcworkphone=$pcworkphone2'\"><img src=../repair/images/groupadd.png style=\"width:20px;\"> ".pcrtlang("Add to New Group")."</button>";
}

echo "<button onClick=\"parent.location='attachment.php?func=add&pcid=$pcid&attachtowhat=pcid&pcwo=$pcwo'\"><img src=../repair/images/attachment.png style=\"width:20px;\"> ".pcrtlang("Add Attachment")."</button>";

echo "<button onClick=\"parent.location='servicereminder.php?func=addsr&pcid=$pcid&pcwo=$pcwo'\"><img src=../repair/images/reminder.png style=\"width:20px;\"> ".pcrtlang("Add Service Reminder")."</button>";

echo "<button onClick=\"parent.location='rwo.php?func=addrwo&pcid=$pcid&woid=$pcwo'\"><img src=../repair/images/return.png style=\"width:24px;\" align=absmiddle> ".pcrtlang("Add Recurring Work Order")."</button>";


echo "</div>";



$rs_find_items = "SELECT * FROM repaircart WHERE pcwo = '$pcwo' ORDER BY addtime ASC";
$rs_find_result = mysqli_query($rs_connect, $rs_find_items); 
$rs_chargewhatcount = mysqli_num_rows($rs_find_result);



echo "</div>\n";

#start of work order pane
echo "<div id=\"workorderinfo\" class=\"ui-body-d ui-content\" style=\"padding:2px;\">\n";



$probdesc2 = nl2br($probdesc);

echo "<center><h3>".pcrtlang("Work Order ID").": $pcwo</h3></center>";

echo "<br><center><table class=standard><tr><th style=\"vertical-align:top;\">".pcrtlang("Problem/Task").":";

echo "</th></tr><tr><td>";


echo "$probdesc2<br>";

foreach($theprobsindb as $key => $val) {
echo "&bull; $val<br>";
}

echo "</td></tr></table></center><br>";

$rs_asql2 = "SELECT * FROM attachments WHERE woid = '$pcwo'";
$rs_result1asql2 = mysqli_query($rs_connect, $rs_asql2);
$total_attachments2 = mysqli_num_rows($rs_result1asql2);

if ($total_attachments2 > 0) {
echo "<center><table class=doublestandard><tr><th colspan=3>";
echo "Work Order Attachments</th></tr>";
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

if(filter_var($attach_filename2, FILTER_VALIDATE_URL)) {
        $fileextpc2 = 'url';
        $attach_link2 = "$attach_filename2";
} else {
        $attach_link2 = "attachment.php?func=get&attach_id=$attach_id2";
}


echo "<tr><td>";
echo "<button type=button onClick=\"parent.location='$attach_link2'\"><i class=\"fa fa-download\"></i> $attach_title2</button>";

echo "<center><i class=\"fa fa-paperclip fa-lg\"></i> $fileextpc2 $thebytes2</center>";

echo "</td></tr>";

echo "<tr><td>";

echo "<div data-role=\"collapsible\">";
echo "<h3>".pcrtlang("Attachment Actions")."</h3>";
echo "<button  type=button style=\"padding:2px;\" onClick=\"parent.location='attachment.php?func=editattach&woid=$pcwo&attach_id=$attach_id2'\"><i class=\"fa fa-edit\"></i> ".pcrtlang("edit")."</button>";
echo "<button  type=button style=\"padding:2px;\" onClick=\"parent.location='attachment.php?func=deleteattach&woid=$pcwo&attach_id=$attach_id2&attachfilename=$attach_filename2'\" onClick=\"return confirm('".pcrtlang("Are you sure you wish to permanently delete this Attachment!!!?")."');\"><i class=\"fa fa-trash-o\"></i> ".pcrtlang("delete")."</button>";
echo "<button  type=button style=\"padding:2px;\" onClick=\"parent.location='attachment.php?func=moveattach&woid=$pcwo&attach_id=$attach_id2&pcid=$pcid&moveto=asset'\"><i class=\"fa fa-arrows-h\"></i> ".pcrtlang("move to asset")."</button>";
echo "</div>";

echo "</td></tr>";
}
echo "</table></center><br>";
}



echo "<table class=standard>";
echo "<tr><th>".pcrtlang("Current Status").": </th><td>$boxstyles[boxtitle]</td></tr>";



$pickdate = pcrtdate("$pcrt_mediumdate", "$pickup")." ".pcrtdate("$pcrt_time", "$pickup");

$dropdate = pcrtdate("$pcrt_mediumdate", "$dropoff")." ".pcrtdate("$pcrt_time", "$dropoff"); 


echo "<tr><th><font class=text12>".pcrtlang("Opened On").": </font></th><td><font class=textblue12b>$dropdate</font></td></tr>";

if ($cibyuser != "") {
echo "<tr><th><font class=text12>".pcrtlang("Opened By").": </font></th><td><font class=textblue12b>$cibyuser</font></td></tr>";
}

if(($sked == 1) && ($pcstatus != 5)) {
echo "<tr><th><font class=text12b>".pcrtlang("Scheduled").":</font></th><td>";
skedwhen("$skeddate");
echo "</td></tr>";
}

if($servicepromiseid != 0) {
echo "<tr><td><strong>".pcrtlang("Promised").":</strong></td><td style=\"vertical-align:middle;\">";
$promisedtimedisplay = pcrtdate("$pcrt_mediumdate", "$promisedtime")." ".pcrtdate("$pcrt_time", "$promisedtime");
if($pickup == "0000-00-00 00:00:00") {
echo servicepromiseicon("$promisedtime","label");
}
echo "<br>$promisedtimedisplay";
echo "</td></tr>";
}



if ($scid != "0") {

$rs_scn = "SELECT * FROM servicecontracts WHERE scid = '$scid'";
$rs_resultscn = mysqli_query($rs_connect, $rs_scn);
$rs_result_scn = mysqli_fetch_object($rs_resultscn);
$scname = "$rs_result_scn->scname";
$chkrinvoice = "$rs_result_scn->rinvoice";

echo "<tr><th colspan=2>".pcrtlang("Service Contract").": </th></tr><tr><td colspan=2>";
echo "<button type=button onClick=\"parent.location='msp.php?func=viewservicecontract&scid=$scid'\" data-mini=\"true\">";
echo "$scname</button>";


if($scpriceid != 0) {
$rs_ql = "SELECT * FROM scprices WHERE scpriceid = '$scpriceid'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$scpriceid = "$rs_result_q1->scpriceid";
$labordesc = "$rs_result_q1->labordesc";
echo "<br><font class=text12>$labordesc</font>";
}

if($chkrinvoice != 0) {
if(overduerinvoice($chkrinvoice) == 1) {
echo "<br><font style=\"color:red;\"><i class=\"fa fa-warning fa-lg\"></i> Service Contract has Overdue Invoices!</font>";
}
}

echo "</td></tr>";
}



if ($assigneduser != "") {
echo "<tr><th>".pcrtlang("Assigned To").": </th><td><i class=\"fa fa-user\"></i> $assigneduser<br>";
echo pcrtlang("Renotify?")."<button  type=button style=\"padding:2px;\" onClick=\"parent.location='pc.php?func=worenotify&woid=$pcwo&notifyuseremail=yes'\"><i class=\"fa fa-envelope-o\"></i> ".pcrtlang("email")."</button>";
echo "<button type=button style=\"padding:2px;\" onClick=\"parent.location='pc.php?func=worenotify&woid=$pcwo&notifyusersms=yes>'\"><i class=\"fa fa-mobile-phone\"></i> ".pcrtlang("sms")."</button>";
echo "<button type=button style=\"padding:2px;\" onClick=\"parent.location='pc.php?func=worenotify&woid=$pcwo&notifyuseremail=yes&notifyusersms=yes'\"><i class=\"fa fa-bell-o\"></i> ".pcrtlang("both")."</button>";
echo "</td></tr>";
}

if ($activestorecount > "1") {
echo "<tr><th>".pcrtlang("Store").": </th><td>$storeinfoarray[storesname]</td></tr>";
}


if ($pickdate != "0000-00-00 00:00:00") {
echo "<tr><th>".pcrtlang("Closed On").": </th><td>$pickdate</td></tr>";
}


if (in_array(23, $actionids)) {

$totalcustchecks = count(array_keys($actionids, 23));

$checkcustlooklast = "SELECT thedatetime FROM userlog WHERE actionid = '23' AND refid = '$pcwo' ORDER BY thedatetime DESC LIMIT 1";
$checkcustlookqlast = mysqli_query($rs_connect, $checkcustlooklast);
$custlookfetch = mysqli_fetch_object($checkcustlookqlast);
$lasttime = "$custlookfetch->thedatetime";

$lasttimef = pcrtdate("$pcrt_mediumdate", "$lasttime")." ".pcrtdate("$pcrt_time", "$lasttime");

$thetimes = ($totalcustchecks > 1 ? "times" : "time");

echo "<tr><th>".pcrtlang("Customer Status Check").": </th><td><i style=\"color:#ff0000\" class=\"fa fa-eye fa-lg fa-fw\"></i> $totalcustchecks ".pcrtlang("$thetimes")." &bull; ".pcrtlang("Last Check").": $lasttimef</td></tr>";

}

if (($pcpriorityindb == "") || (!array_key_exists($pcpriorityindb, $pcpriority))) {
$pcpriorityindb = "Not Set";
}


if ($pcpriorityindb != "Not Set") {
$icon = $pcpriority[$pcpriorityindb];
} else {
$icon = "";
}



echo "<tr><th>".pcrtlang("Current Priority").":</th><td>";
if($icon != "") {
echo "<img src=../repair/images/$icon class=menuicon>&nbsp;&nbsp;&nbsp;";
}
echo pcrtlang("$pcpriorityindb");

echo "</td></tr>";


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
$calledicon = "<i class=\"fa fa-mobile fa-2x fa-fw colormegreen vam\"></i>";
} elseif  ($called == 6){
$calledtext = pcrtlang("Sent Email");
$calledicon = "<i class=\"fa fa-envelope fa-2x fa-fw colormegreen\"></i>";
} else {
$calledtext = pcrtlang("Called - Waiting for Call Back");
$calledicon = "<i class=\"fa fa-phone-square fa-2x fa-fw colormeblue\"></i>";
}


echo "<tr><th>".pcrtlang("Current Call Status").": </th><td>$calledicon $calledtext</td></tr>";

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

echo "<tr><th>".pcrtlang("Storage Location").": </th><td><i class=\"fa fa-archive\"></i> $slnames</td></tr>";



echo "</table>\n";


$statuscolors = getstatusselectorcolors();
$boxtitles = getboxtitles();

$coptions = "";
$rs_qc = "SELECT * FROM boxstyles WHERE statusid > 99";
$rs_result1 = mysqli_query($rs_connect, $rs_qc);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$statusid = "$rs_result_q1->statusid";
$selectorcolor2 = "$rs_result_q1->selectorcolor";
$boxtitle2 = "$rs_result_q1->boxtitle";
$coptions .= "<option value=\"$statusid\">$boxtitle2</option>";
}


if ($rs_chargewhatcount > 0) {
echo "<form action=pc.php?func=stat_change method=post data-ajax=\"false\"><input type=hidden value=$pcwo name=woid><select name=statnum onchange='this.form.submit()'>";
echo "<option>".pcrtlang("Switch Status")."</option>";
echo "<option value=1>$boxtitles[1]</option><option value=2>$boxtitles[2]</option><option value=8>$boxtitles[8]</option><option value=9>$boxtitles[9]</option><option value=3>$boxtitles[3]</option><option value=4>$boxtitles[4]</option><option value=6>$boxtitles[6]</option><option value=7>$boxtitles[7]</option>";

echo "$coptions";

echo "</select></form>";
} else {
echo "<form action=pc.php?func=stat_change method=post data-ajax=\"false\"><input type=hidden value=$pcwo name=woid><select name=statnum onchange='this.form.submit()'>";
echo "<option>".pcrtlang("Switch Status")."</option>";
echo "<option value=1>$boxtitles[1]</option><option value=2>$boxtitles[2]</option><option value=8>$boxtitles[8]</option><option value=9>$boxtitles[9]</option><option value=3>$boxtitles[3]</option>";

echo "$coptions";

echo "</select></form>";
}





###############################

$rs_findstatii = "SELECT * FROM boxstyles ORDER BY displayedorder ASC";
$rs_result_st = mysqli_query($rs_connect, $rs_findstatii);
while($rs_result_stq = mysqli_fetch_object($rs_result_st)) {
$statusoptions[$rs_result_stq->statusid] = serializedarraytest("$rs_result_stq->statusoptions");
}

if (is_array($statusoptions[$pcstatus])) {
if (in_array("workbench", $statusoptions[$pcstatus])) {


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
$wacolor = "ffffff";
$watitle = pcrtlang("Unassigned");
}


echo "<div data-role=\"collapsible\" data-theme=\"a\">";
echo "<h3>".pcrtlang("Workarea").": $watitle</h3>";

if ($pcwa != "") {
echo "<button type=button onClick=\"parent.location='pc.php?func=changewa&woid=$pcwo&workarea='\">".pcrtlang("Not Assigned")."</button>";
}
foreach($storeworkareas as $key => $val) {
if ($key == "$pcwa") {
echo "<button type=button onClick=\"parent.location='pc.php?func=changewa&woid=$pcwo&workarea=$key'\">$key</button>";
} else {
echo "<button type=button onClick=\"parent.location='pc.php?func=changewa&woid=$pcwo&workarea=$key'\">$key</button>";
}
}


echo "</div>";

}
}
}


###################################







#




echo "<form action=pc.php?func=checkout method=post data-ajax=\"false\"><input type=hidden name=woid value=$pcwo>";
if($rs_chargewhatcount == "0") {

echo "<button type=button onclick=\"this.disabled=true; this.form.submit();\"><i class=\"fa fa-sign-out fa-lg\"></i> ".pcrtlang("Close Work Order")."</button>";
} else {
echo "<button type=button onclick=\"javascript: if(confirm('".pcrtlang("This Work Order has charges or invoices specified. Are you sure you want to checkout WITHOUT FINALIZING A SALE?")."')) this.form.submit();\"><i class=\"fa fa-sign-out fa-lg\"></i> ".pcrtlang("Close Work Order")."</button>";
}
echo "</form>";



echo "<div data-role=\"collapsible\">";
echo "<h3><i class=\"fa fa-print\"></i> ".pcrtlang("Print")."</h3>";

echo "<button type=button onClick=\"parent.location='pc.php?func=printclaimticket&woid=$pcwo'\"><i class=\"fa fa-ticket\"></i> ".pcrtlang("Claim Ticket")."</button>";


echo "<button type=button onClick=\"parent.location='pc.php?func=printthankyou&woid=$pcwo&pcname=$pcname2'\"><i class=\"fa fa-envelope-o\"></i> ".pcrtlang("Thank You Letter")."</button>";


$probdesc_ss = addslashes($probdesc);
echo "<button type=button onClick=\"parent.location='pc.php?func=printit&woid=$pcwo'\" onClick=\"return confirm('".pcrtlang("Did you repair the following").":\\n $probdesc_ss \\n \\n ".pcrtlang("CHECK THE OPTICAL DRIVE FOR BENCH CDS! DO IT NOW!!! DO NOT WAIT!!!!!!")."');\"><i class=\"fa fa-clipboard\"></i> ".pcrtlang("Repair Report")."</button>";


echo "<button type=button onClick=\"parent.location='printpricecard.php?func=printpricecard&woid=$pcwo'\"><i class=\"fa fa-barcode\"></i> ".pcrtlang("Price Card")."</button>";

echo "<button type=button onClick=\"parent.location='pc.php?func=printcheckoutreceipt&woid=$pcwo'\"><i class=\"fa fa-file-text\">
</i> ".pcrtlang("Checkout Receipt")."</button>";

echo "<button type=button onClick=\"parent.location='pc.php?func=benchsheet&woid=$pcwo'\"><i class=\"fa fa-plug\"></i> ".pcrtlang("Bench Sheet")."</button>";

echo "</div>";


echo "<div data-role=\"collapsible\">";
echo "<h3><i class=\"fa fa-print\"></i> ".pcrtlang("Labels")."</h3>";
$backurl = urlencode("index.php?pcwo=$pcwo");

echo "<button type=button onClick=\"parent.location='repairlabel.php?pcid=$pcid&name=$pcname2&company=$pccompany2&woid=$pcwo&pcmake=$pcmake2&pcphone=$pcphone2&dymojsapi=html&backurl=$backurl'\">".pcrtlang("Asset Label")."</button>";
echo "<button type=button onClick=\"parent.location='addresslabel.php?pcname=$pcname2&pccompany=$pccompany2&pcaddress1=$pcaddress12&pcaddress2=$pcaddress2&pccity=$pccity2&pcstate=$pcstate2&pczip=$pczip2&dymojsapi=html&backurl=$backurl'\">".pcrtlang("Address Label")."</button>";

echo "</div>";

echo "<div data-role=\"collapsible\">";
echo "<h3><i class=\"fa fa-envelope-o\"></i> ".pcrtlang("Email")."</h3>";



echo "<button type=button onClick=\"parent.location='pc.php?func=emailclaimticket&woid=$pcwo&email=$pcemail2'\"><i class=\"fa fa-ticket\"></i> ";
echo pcrtlang("Claim Ticket");

if (in_array(12, $actionids)) {
echo " <font style=\"color:#00c403\"><i class=\"fa fa-check-circle fa-lg\"></i></font>";
}
echo "</button>";


echo "<button type=button onClick=\"parent.location='pc.php?func=emailthankyou&woid=$pcwo&email=$pcemail2&pcname=$pcname2'\"><i class=\"fa fa-envelope-o\"></i> ";
echo "".pcrtlang("Thank You Letter");

if (in_array(25, $actionids)) {
echo " <font style=\"color:#00c403\"><i class=\"fa fa-check-circle fa-lg\"></i></font>";
}

echo "</button>";

echo "<button type=button onClick=\"parent.location='pc.php?func=emailit&woid=$pcwo&email=$pcemail2'\"  onClick=\"return confirm('".pcrtlang("Did you repair the following:")." $probdesc.  ".pcrtlang("CHECK THE OPTICAL DRIVE FOR BENCH CDS! DO IT NOW!!! DO NOT WAIT!!!!!!")."');\" class=boldlink><i class=\"fa fa-clipboard\"></i> ";
echo pcrtlang("Repair Report");

if (in_array(6, $actionids)) {
echo " <font style=\"color:#00c403\"><i class=\"fa fa-check-circle fa-lg\"></i></font>";
}

echo "</button>";

echo "</div>";

### Priority here

if (($pcpriorityindb == "") || (!array_key_exists($pcpriorityindb, $pcpriority))) {
$pcpriorityindb = "Not Set";
}


if ($pcpriorityindb != "Not Set") {
$icon = $pcpriority[$pcpriorityindb];
} else {
$icon = "";
}


echo "<div data-role=\"collapsible\">";
echo "<h3><i class=\"fa fa-exclamation\"></i> ".pcrtlang("Set Priority")."</h3>";

echo "<center>";
if($icon != "") {
echo pcrtlang("Current Priority").": <img src=../repair/images/$icon class=menuicon>&nbsp;&nbsp;&nbsp;";
}
echo pcrtlang("$pcpriorityindb");
echo "</center>";

foreach($pcpriority as $key => $val) {
if("$pcpriorityindb" != "$key") {
$key2 = urlencode($key);
echo "<button type=button onClick=\"parent.location='pc.php?func=setpriority&woid=$pcwo&setpriority=$key2'\">";
if($val != "") {
echo "<img src=../repair/images/$val class=menuicon>";
}
echo " ".pcrtlang("$key")."</a>";
}
}

if ($pcpriorityindb != "Not Set") {
echo "<button type=button onClick=\"parent.location='pc.php?func=setpriority&woid=$pcwo&setpriority='\"><img src=../repair/images/del.png style=\"width:20px;\"> ".pcrtlang("Unset Priority")."</button>";
}


#####

echo "</div>";


echo "<div data-role=\"collapsible\">";
echo "<h3><i class=\"fa fa-phone\"></i> ".pcrtlang("Call Status")."</h3>";

echo "<center>".pcrtlang("Current Call Status").": $calledicon $calledtext</center>";

echo "<button type=button style=\"padding:2px;\" onClick=\"parent.location='pc.php?func=precalled&woid=$pcwo&status=1'\">
<i class=\"fa fa-phone-square fa-2x fa-fw colormered vam\"></i> ".pcrtlang("Not Called")."</button>";
echo "<button type=button style=\"padding:2px;\" onClick=\"parent.location='pc.php?func=precalled&woid=$pcwo&status=2'\">
<i class=\"fa fa-phone-square fa-2x fa-fw colormegreen vam\"></i> ".pcrtlang("Called")."</button>";
echo "<button type=button style=\"padding:2px;\" onClick=\"parent.location='pc.php?func=precalled&woid=$pcwo&status=5'\">
<i class=\"fa fa-phone-square fa-2x fa-fw colormegreen vam\"></i> ".pcrtlang("Left Voice Message")."</button>";
echo "<button type=button style=\"padding:2px;\" onClick=\"parent.location='pc.php?func=precalled&woid=$pcwo&status=7'\">
<i class=\"fa fa-mobile fa-2x fa-fw colormegreen vam\"></i> ".pcrtlang("Sent SMS")."</button>";
echo "<button type=button style=\"padding:2px;\" onClick=\"parent.location='pc.php?func=precalled&woid=$pcwo&status=6'\">
<i class=\"fa fa-envelope fa-2x fa-fw colormegreen vam\"></i> ".pcrtlang("Sent Email")."</button>";
echo "<button type=button style=\"padding:2px;\" onClick=\"parent.location='pc.php?func=precalled&woid=$pcwo&status=3'\">
<i class=\"fa fa-phone-square fa-2x fa-fw colormeyellow vam\"></i> ".pcrtlang("No Answer")."</button>";
echo "<button type=button style=\"padding:2px;\" onClick=\"parent.location='pc.php?func=precalled&woid=$pcwo&status=4'\">
<i class=\"fa fa-phone-square fa-2x fa-fw colormeblue vam\"></i> ".pcrtlang("Awaiting Call Back")."</button>";

echo "<button type=button style=\"padding:2px;\" onClick=\"parent.location='pc.php?func=workorderaction&woid=$pcwo&contactonly=yes'\"><i class=\"fa fa-history fa-2x vam\"></i> ".pcrtlang("History")."</button>";


echo "</div>";


echo "<div data-role=\"collapsible\">";
echo "<h3><i class=\"fa fa-archive\"></i> ".pcrtlang("Storage Location")."</h3>";

echo "<center>".pcrtlang("Current Storage Location").": $slnames</center>";

$rs_sl = "SELECT * FROM storagelocations ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_sl);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$slidtoset = "$rs_result_q1->slid";
$slname = "$rs_result_q1->slname";
$theorder = "$rs_result_q1->theorder";
if($slid != $slidtoset) {
echo "<a href=pc.php?func=setsl&woid=$pcwo&slid=$slidtoset class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" data-ajax=\"false\">$slname</a>";
}
}


echo "</div>";






echo "<div data-role=\"collapsible\" data-theme=\"b\">";
echo "<h3>".pcrtlang("Work Order Actions")."</h3>";

echo "<button onClick=\"parent.location='pc.php?func=editproblem&woid=$pcwo&custname=$pcname2'\"><img src=../repair/images/woedit.png  style=\"width:24px;\" align=absmiddle> ".pcrtlang("Edit Work Order")."</button>";
echo "<button onClick=\"parent.location='pc.php?func=movewo&woid=$pcwo&pcid=$pcid&custname=$pcname'\"><img src=../repair/images/womove.png  style=\"width:24px;\" align=absmiddle> ".pcrtlang("Move Work Order")."</button>";


if ($ipofpc == "admin") {
echo "<a href=\"#popupdeletewo\" data-rel=\"popup\" data-position-to=\"window\" data-transition=\"pop\" class=\"ui-btn ui-shadow ui-corner-all\">";
echo "<img src=../repair/images/del.png style=\"width:24px;\" align=absmiddle> ".pcrtlang("Delete Work Order")."</a>";
echo "<div data-role=\"popup\" id=\"popupdeletewo\" data-overlay-theme=\"b\"  data-theme=\"a\" data-dismissible=\"false\">";
echo "<div data-role=\"header\" data-theme=\"b\">";
echo "<h1>".pcrtlang("Delete Work Order")."?</h1>";
echo "</div>";
echo "<div role=\"main\" class=\"ui-content\">";
echo "<p>".pcrtlang("Are you sure you wish to permanently delete this Work Order!!!?")."</p>";
echo "<div align=\"right\"><a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\" data-inline=\"true\">";
echo "<i class=\"fa fa-ban fa-lg\"></i>  ".pcrtlang("Cancel")."</a>";
echo "<button onClick=\"parent.location='admin.php?func=admindeletewo&pcwoid=$pcwo'\" data-inline=\"true\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")." </button></div>";
echo "</div>";
echo "</div>";
}

echo "<button onClick=\"parent.location='pc.php?func=showpc&pcid=$pcid'\"><img src=../repair/images/wohistory.png style=\"width:24px;\" align=absmiddle> ".pcrtlang("Work Order History")."</button>";

echo "<button onClick=\"parent.location='pc.php?func=workorderaction&woid=$pcwo'\"><img src=../repair/images/woaction.png style=\"width:24px;\" align=absmiddle> ".pcrtlang("Action Log")."</button>";

echo "<button onClick=\"parent.location='attachment.php?func=add&woid=$pcwo&attachtowhat=woid&pcwo=$pcwo'\"><img src=../repair/images/attachment.png style=\"width:24px;\" align=absmiddle> ".pcrtlang("Add Attachment")."</button>";

$probdesc2 = urlencode("$probdesc");

echo "<button onClick=\"parent.location='sticky.php?func=addsticky&stickyname=$pcname2&stickycompany=$pccompany2&stickyaddy1=$pcaddress12&stickyaddy2=$pcaddress22&stickycity=$pccity2&stickystate=$pcstate2&stickyzip=$pczip2&stickyemail=$pcemail2&stickyphone=$pcphone2&stickyrefid=$pcwo&stickyreftype=woid&stickynote=$probdesc2'\"><img src=../repair/images/sticky.png style=\"width:24px;\" align=absmiddle> ".pcrtlang("New Sticky Note")."</button>";


echo "</div>";


echo "</div>\n";
#end of 2nd pane
echo "<div id=\"assetinfo\" class=\"ui-body-d ui-content\" style=\"padding:2px;\">";



?>
<script type="text/javascript">
$.get('woajaxassetinfo.php?pcwo=<?php echo $pcwo; ?>&addystring=<?php echo "$addystring"; ?>&pcmake=<?php echo "$pcmake"; ?>&pcstatus=<?php echo "$pcstatus"; ?>&mainassettypeidindb=<?php echo "$mainassettypeidindb"; ?>&custompcinfoindb=<?php echo serialize($custompcinfoindb); ?>&pcid=<?php echo $pcid; ?>', function(data) {
    $('#woajaxassetinfo').html(data).enhanceWithin('create');
  });
</script>
<div id="woajaxassetinfo"></div>

<?php



echo "</div>\n";
#end of 3nd pane




#######################################################################

$invoicelist = array();

$rs_findsinv_t = "SELECT * FROM invoices WHERE woid = '$pcwo' AND invstatus != '3'";
$rs_findsinv2_t = @mysqli_query($rs_connect, $rs_findsinv_t);
$rs_invoicecount = mysqli_num_rows($rs_findsinv2_t);

$rs_findsinv = "SELECT * FROM invoices WHERE invstatus != '3' AND preinvoice != '1' AND (woid = '$pcwo' OR woid LIKE '%"."\_"."$pcwo"."\_"."%')";
$rs_findsinv2 = @mysqli_query($rs_connect, $rs_findsinv);
$invcount = mysqli_num_rows($rs_findsinv2);



# start of invoicing pane
echo "<div id=\"invoicing\" class=\"ui-body-d ui-content\" style=\"padding:2px;\">";

$depositinvoicearray = array();

$rs_findsum = "SELECT SUM(cart_price) as checkcartsum FROM repaircart WHERE pcwo = '$pcwo'";
$rs_findsum2 = @mysqli_query($rs_connect, $rs_findsum);  
$rs_findsum3 = mysqli_fetch_object($rs_findsum2);
$checkcartsum = "$rs_findsum3->checkcartsum";

$rs_findcont = "SELECT * FROM repaircart WHERE pcwo = '$pcwo'";
$rs_findcont2 = @mysqli_query($rs_connect, $rs_findcont);
$checkcartcontents = mysqli_num_rows($rs_findcont2);

if ($checkcartcontents == 0) {
echo "<center><i class=\"fa fa-warning fa-lg\"></i> ".pcrtlang("No items are in the repair cart to add to an invoice....")."</center>";
}

if (($invcount < 1) && ($checkcartcontents > 0)) {
if($pcgroupid == 0) {
echo "<button type=button onClick=\"parent.location='repinvoice.php?func=createinvoice&woid=$pcwo&pcname=$pcname2&pccompany=$pccompany2&pcphone=$pcphone2&pcemail=$pcemail2&pcaddress=$pcaddress12&pcaddress2=$pcaddress22&pccity=$pccity2&pcstate=$pcstate2&pczip=$pczip2&preinvoice=0'\" data-theme=\"b\"> ".pcrtlang("Create Invoice (Final) or Quote")."</button>";
} else {
echo "<button type=button onClick=\"parent.location='repinvoice.php?func=createinvoice&woid=$pcwo&pcname=$ue_pcgroupname&pccompany=$ue_grpcompany&pcphone=$ue_grpphone&pcemail=$ue_grpemail&pcaddress=$ue_grpaddress&pcaddress2=$ue_grpaddress2&pccity=$ue_grpcity&pcstate=$ue_grpstate&pczip=$ue_grpzip&preinvoice=0'\" data-theme=\"b\"> ".pcrtlang("Create Invoice (Final) or Quote")."</a>";
}
}

$rs_findsinv_2 = "SELECT * FROM invoices WHERE woid = '$pcwo' AND invstatus != '3' AND preinvoice != '0'";
$rs_findsinv2_2 = @mysqli_query($rs_connect, $rs_findsinv_2);
$invcount_2 = mysqli_num_rows($rs_findsinv2_2);
if ($checkcartcontents > 0) {
if($pcgroupid == 0) {
echo "<button type=button onClick=\"parent.location='repinvoice.php?func=createinvoice&woid=$pcwo&pcname=$pcname2&pccompany=$pccompany2&pcphone=$pcphone2&pcemail=$pcemail2&pcaddress=$pcaddress12&pcaddress2=$pcaddress22&pccity=$pccity2&pcstate=$pcstate2&pczip=$pczip2&preinvoice=1'\" data-theme=\"b\">".pcrtlang("Create Invoice (Prepaid)")."</button>";
} else {
echo "<button type=button onClick=\"parent.location='repinvoice.php?func=createinvoice&woid=$pcwo&pcname=$ue_pcgroupname&pccompany=$ue_grpcompany&pcphone=$ue_grpphone&pcemail=$ue_grpemail&pcaddress=$ue_grpaddress&pcaddress2=$ue_grpaddress2&pccity=$ue_grpcity&pcstate=$ue_grpstate&pczip=$ue_grpzip&preinvoice=1'\" data-theme=\"b\">".pcrtlang("Create Invoice (Prepaid)")."</button>";
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
echo "<button type=button onClick=\"parent.location='repinvoice.php?func=addtoexistinginvoice&woid=$pcwo&invoice_id=$otherinvoiceid'\">".pcrtlang("Add to Invoice")." #$otherinvoiceid</button>";
echo "<button type=button onClick=\"parent.location='../store/invoice.php?func=printinv&invoice_id=$otherinvoiceid'\">".pcrtlang("View Invoice")." #$otherinvoiceid</button>";
}
}
}
}
##




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

echo "<table class=standard><tr><th>$ilabel</th></tr>";

if ($invstatus == 1) {

$depositinvoicearray[] = $invoice_id;

echo "<tr><td>$invname</td></tr><tr><td>$invdate2</td></tr><tr><td>".pcrtlang("Invoice Total").": <span class=floatright>$money$invtotal</span></td></tr>";

if(($deposittotal > 0) && ($invstatus == 1)) {
echo "<tr><td>".pcrtlang("Deposit Total:")." <span class=floatright>$money".mf($deposittotal)."</span></td></tr>";
echo "<tr><td>".pcrtlang("Invoice Balance:")."<span class=floatright> $money".mf($depositbalance)."</span></td></tr>";
}


if ($iorq != "quote") {
echo "<tr><td>".pcrtlang("Status: Open"."</span></td></tr>");
}
if ($invbyuser != "") {
echo "<tr><td>".pcrtlang("Created By").": $invbyuser</td></tr>";
}


$invoicewoids = explode_list($invwoid);

if(count($invoicewoids) > 1) {

echo "<tr><td>".pcrtlang("Other Work Orders on this Invoice").":</td></tr>";
foreach($invoicewoids as $key => $thiswoids) {
if($thiswoids != $pcwo) {
echo "<tr><td>#<a href=\"index.php?pcwo=$thiswoids\">$thiswoids</a></td></tr>";
}
}

}

$returnurli2 = urlencode("../repairmobile/index.php?pcwo=$pcwo#invoicing");

echo "</td></tr>";
echo "<tr><td>";

echo "<div data-role=\"collapsible\">";
echo "<h3>".pcrtlang("Invoice Actions")."</h3>";


echo "<button type=button onClick=\"parent.location='../storemobile/invoice.php?func=printinv&invoice_id=$invoice_id&returnurl=$returnurli2'\"><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Print")."</button>";
echo "<button type=button onClick=\"parent.location='../storemobile/invoice.php?func=emailinv2&invoice_id=$invoice_id&emailaddy=$invemail&returnurl=$returnurli2'\"><i class=\"fa fa-envelope fa-lg\"></i> ".pcrtlang("Email");
if ($chkinvoice >= 1) {
echo " <i style=\"color:#003300;\" class=\"fa fa-check-circle fa-lg\"></i> ";
}
echo "</button>";

echo "<button type=button onClick=\"parent.location='../storemobile/invoice.php?func=editinvoice&invoice_id=$invoice_id&returnurl=$returnurli2'\"><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("Edit")."</button>";
if ($iorq != "quote") {
echo "<button type=button onClick=\"parent.location='repinvoice.php?func=checkout&invoice_id=$invoice_id&woid=$pcwo&custname=$custname&custcompany=$custcompany&custaddy1=$custaddy1&custaddy2=$custaddy2&custcity=$custcity&custstate=$custstate&custzip=$custzip&custphone=$custphone&custemail=$custemail'\"><i class=\"fa fa-sign-out fa-lg\"></i> ".pcrtlang("Checkout")."</button> ";
echo "<button type=button onClick=\"parent.location='../storemobile/invoice.php?func=changeinvoicestatus&invstatus=3&invoice_id=$invoice_id&returnurl=$returnurli2'\" onClick=\"return confirm('".pcrtlang("Are you sure you wish to void this invoice?")."');\"><i class=\"fa fa-times-circle fa-lg\"></i> ".pcrtlang("Void")."</a> ";
echo "<button type=button onClick=\"parent.location='../storemobile/invoice.php?func=changeinvoicestatus&invstatus=2&invoice_id=$invoice_id&returnurl=$returnurli2'\" onClick=\"return confirm('".pcrtlang("Are you sure you wish to close this invoice? Usually you want to checkout an invoice so that the invoice gets marked as paid.")."');\"><i class=\"fa fa-check-circle fa-lg\"></i> ".pcrtlang("Close")."</button>";

if ($depositbalance > 0) {
if ($pcgroupid == 0) {
echo "<button type=button onClick=\"parent.location='../storemobile/deposits.php?woid=$pcwo&invoiceid=$invoice_id&cfirstname=$pcname2&ccompany=$pccompany2&caddress=$pcaddress12&caddress2=$pcaddress22&ccity=$pccity2&cstate=$pcstate2&czip=$pczip2&cphone=$pcphone2&cemail=$pcemail2&depamount=$depositbalance'\"><i class=\"fa fa-money fa-lg\"></i> ".pcrtlang("Add Deposit")."</button>";
} else {
echo "<button type=button onClick=\"parent.location='../storemobile/deposits.php?woid=$pcwo&invoiceid=$invoice_id&cfirstname=$ue_pcgroupname&ccompany=$ue_grpcompany&caddress=$ue_grpaddress&caddress2=$ue_grpaddress2&ccity=$ue_grpcity&cstate=$ue_grpstate&czip=$ue_grpzip&cphone=$ue_grpphone&cemail=$ue_grpemail&depamount=$depositbalance'\"><i class=\"fa fa-money fa-lg\"></i> ".pcrtlang("Add Deposit")."</button>";
}
}

} else {
echo "<button type=button onClick=\"parent.location='../storemobile/invoice.php?func=deletequote&invoice_id=$invoice_id&returnurl=$returnurli2'\" onClick=\"return confirm('".pcrtlang("Are you sure you wish to delete this quote?")."');\"><i class=\"fa fa-times-circle fa-lg\"></i> ".pcrtlang("Delete Quote")."</button> ";
echo "<button type=button onClick=\"parent.location='repinvoice.php?func=checkout&invoice_id=$invoice_id&woid=$pcwo&custname=$custname&custcompany=$custcompany&custaddy1=$custaddy1&custaddy2=$custaddy2&custcity=$custcity&custstate=$custstate&custzip=$custzip&custphone=$custphone&custemail=$custemail&checkout=no'\"><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("Edit Items")."</button> ";

}


echo "</div></td></tr>";

} else {

echo "<tr><td>";
echo "$invname</td></tr><tr><td>$invdate2</td></tr><tr><td>$money$invtotal</td></tr>";
if ($iorq != "quote") {
echo "<tr><td>".pcrtlang("Status: Closed/Paid")."</td></tr>";
}
if ($invbyuser != "") {
echo "<tr><td>".pcrtlang("Created By").": $invbyuser</td></tr>";
}

$invoicewoids = explode_list("$invwoid");

if(count($invoicewoids) > 1) {

echo "<tr><td>".pcrtlang("Other Work Orders on this Invoice").":";
foreach($invoicewoids as $key => $thiswoids) {
echo "<br>#<a href=\"index.php?pcwo=$thiswoids\">$thiswoids</a> ";
}
echo "</td></tr>";


}


$returnurli2 = urlencode("../repairmobile/index.php?pcwo=$pcwo#invoicing");
echo "<tr><td>";


echo "<div data-role=\"collapsible\">";
echo "<h3>".pcrtlang("Invoice Actions")."</h3>";

echo "<button type=button onClick=\"parent.location='../storemobile/invoice.php?func=printinv&invoice_id=$invoice_id&returnurl=$returnurli2'\"><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Print")."</button>";
echo "<button type=button onClick=\"parent.location='../storemobile/invoice.php?func=emailinv2&invoice_id=$invoice_id&emailaddy=$invemail&returnurl=$returnurli2'\"><i class=\"fa fa-envelope fa-lg\"></i> ".pcrtlang("Email");
if ($chkinvoice >= 1) {
echo " <i style=\"color:#003300;\" class=\"fa fa-check-circle fa-lg\"></i> ";
}

echo "</button>";

if ($iorq != "quote") {
echo "<button type=button onClick=\"parent.location='../storemobile/invoice.php?func=changeinvoicestatus&invstatus=3&invoice_id=$invoice_id&returnurl=$returnurli2'\" onClick=\"return confirm('".pcrtlang("Are you sure you wish to void this invoice?")."');\"><i class=\"fa fa-check-circle fa-lg\"></i> ".pcrtlang("Void")."</button>";
}

if (($invrec != '0') && ($iorq != "quote")) {
echo "<button type=button onClick=\"parent.location='../storemobile/receipt.php?func=show_receipt&receipt=$invrec'\"><i class=\"fa fa-file-text fa-lg\"></i> ".pcrtlang("View Receipt")." #$invrec</button>";
}

}

echo "</div></td></tr>";

}



echo "</table>";

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


echo "<table class=standard><tr><th>$ilabel_2</th></tr>";

if ($invstatus_2 == 1) {

$depositinvoicearray[] = $invoice_id_2;

echo "<tr><td>$invname_2</td></tr><tr><td>$invdate2_2</td></tr><tr><td>".pcrtlang("Invoice Total").": <span class=floatright>$money$invtotal_2</span></td></tr>";

if(($deposittotal_2 > 0) && ($invstatus_2 == 1)) {
echo "<tr><td>".pcrtlang("Deposit Total")." <span class=floatright>$money".mf($deposittotal_2)."</span></td></tr>";
echo "<tr><td>".pcrtlang("Invoice Balance")."<span class=floatright> $money".mf($depositbalance_2)."</span></td></tr>";
}


if ("$iorq_2" != "quote") {
echo "<tr><td>".pcrtlang("Status: Open")."</td></tr>";
}
if ($invbyuser_2 != "") {
echo "<tr><td>".pcrtlang("Created By").": $invbyuser_2</td></tr>";
}

$returnurli2 = urlencode("../repairmobile/index.php?pcwo=$pcwo#invoicing");

echo "<tr><td>";

echo "<div data-role=\"collapsible\">";
echo "<h3>".pcrtlang("Invoice Actions")."</h3>";


echo "<button type=button onClick=\"parent.location='../storemobile/invoice.php?func=printinv&invoice_id=$invoice_id_2&returnurl=$returnurli2'\"><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Print")."</button>";
echo "<button type=button onClick=\"parent.location='../storemobile/invoice.php?func=emailinv2&invoice_id=$invoice_id_2&emailaddy=$invemail_2&returnurl=$returnurli2'\"><i class=\"fa fa-envelope fa-lg\"></i> ".pcrtlang("Email")."</button> ";
if ($chkinvoice2 >= 1) {
echo " <i class=\"fa fa-check-circle fa-lg\"></i> ";
}
echo "<button type=button onClick=\"parent.location='../storemobile/invoice.php?func=editinvoice&invoice_id=$invoice_id_2&returnurl=$returnurli2'\"><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("Edit")."</button>";
if ($iorq_2 != "quote") {
echo "<button type=button onClick=\"parent.location='repinvoice.php?func=checkout&invoice_id=$invoice_id_2&woid=$pcwo&custname=$custname_2&custcompany=$custcompany_2&custaddy1=$custaddy1_2&custaddy2=$custaddy2_2&custcity=$custcity_2&custstate=$custstate_2&custzip=$custzip_2&custphone=$custphone_2&custemail=$custemail_2&prepaid=yes'\"><i class=\"fa fa-sign-out fa-lg\"></i> ".pcrtlang("Checkout")."</button> ";
echo "<button type=button onClick=\"parent.location='../storemobile/invoice.php?func=changeinvoicestatus&invstatus=3&invoice_id=$invoice_id_2&returnurl=$returnurli2'\"  onClick=\"return confirm('".pcrtlang("Are you sure you wish to void this invoice?")."');\"><i class=\"fa fa-times-circle fa-lg\"></i> ".pcrtlang("Void")."</button> ";
echo "<button type=button onClick=\"parent.location='../storemobile/invoice.php?func=changeinvoicestatus&invstatus=2&invoice_id=$invoice_id_2&returnurl=$returnurli2'\"  onClick=\"return confirm('".pcrtlang("Are you sure you wish to close this invoice? Usually you want to checkout an invoice so that the invoice gets marked as paid.")."');\"><i class=\"fa fa-check-circle fa-lg\"></i> ".pcrtlang("Close")."</button>";

if ($depositbalance_2 > 0) {
if ($pcgroupid == 0) {
echo "<button type=button onClick=\"parent.location='../storemobile/deposits.php?woid=$pcwo&invoiceid=$invoice_id_2&cfirstname=$pcname2&ccompany=$pccompany2&caddress=$pcaddress12&caddress2=$pcaddress22&ccity=$pccity2&cstate=$pcstate2&czip=$pczip2&cphone=$pcphone2&cemail=$pcemail2&depamount=$depositbalance_2'\"><i class=\"fa fa-money fa-lg\"></i> ".pcrtlang("Add Deposit")."</button>";
} else {
echo "<button type=button onClick=\"parent.location='../store/deposits.php?woid=$pcwo&invoiceid=$invoice_id_2&cfirstname=$ue_pcgroupname&ccompany=$ue_grpcompany&caddress=$ue_grpaddress&caddress2=$ue_grpaddress2&ccity=$ue_grpcity&cstate=$ue_grpstate&czip=$ue_grpzip&cphone=$ue_grpphone&cemail=$ue_grpemail&depamount=$depositbalance_2'\"><i class=\"fa fa-money fa-lg\"></i> ".pcrtlang("Add Deposit")."</button>";
}
}


} else {
echo "<button type=button onClick=\"parent.location='../storemobile/invoice.php?func=deletequote&invoice_id=$invoice_id_2&returnurl=$returnurli2'\" onClick=\"return confirm('".pcrtlang("Are you sure you wish to delete this quote?")."');\"><i class=\"fa fa-times-circle fa-lg\"></i> ".pcrtlang("Delete Quote")."</button> ";
echo "<button type=button onClick=\"parent.location='repinvoice.php?func=checkout&invoice_id=$invoice_id_2&woid=$pcwo&custname=$custname_2&custcompany=$custcompany_2&custaddy1=$custaddy1_2&custaddy2=$custaddy2_2&custcity=$custcity_2&custstate=$custstate_2&custzip=$custzip_2&custphone=$custphone_2&custemail=$custemail_2&checkout=no'\"><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("Edit Items")."</button> ";
}

echo "</div>";


echo "</td></tr>";

} else {

echo "<tr><td>";
echo "$invname_2</td></tr><tr><td>$invdate2_2</td></tr><tr><td>$money$invtotal_2</td></tr>";
if ($iorq_2 != "quote") {
echo "<tr><td>".pcrtlang("Status: Closed/Paid")."</td></tr>";
}
if ($invbyuser_2 != "") {
echo "<tr><td>".pcrtlang("Created By").": $invbyuser_2</td></tr>";
}

$returnurli2 = urlencode("../repairmobile/index.php?pcwo=$pcwo#invoicing");

echo "<tr><td>";

echo "<div data-role=\"collapsible\">";
echo "<h3>".pcrtlang("Invoice Actions")."</h3>";


echo "<button type=button onClick=\"parent.location='../storemobile/invoice.php?func=printinv&invoice_id=$invoice_id_2&returnurl=$returnurli2'\"><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Print")."</button>";
echo "<button type=button onClick=\"parent.location='../storemobile/invoice.php?func=emailinv2&invoice_id=$invoice_id_2&emailaddy=$invemail_2&returnurl=$returnurli2'\"><i class=\"fa fa-envelope fa-lg\"></i> ".pcrtlang("Email")."</button> ";
if ($chkinvoice2 >= 1) {
echo " <i class=\"fa fa-check-circle fa-lg\"></i>";
}

if ($iorq_2 != "quote") {
echo "<button type=button onClick=\"parent.location='../storemobile/invoice.php?func=changeinvoicestatus&invstatus=3&invoice_id=$invoice_id_2&returnurl=$returnurli2'\" onClick=\"return confirm('".pcrtlang("Are you sure you wish to void this invoice?")."');\"><i class=\"fa fa-times-circle fa-lg\"></i> ".pcrtlang("Void")."</button>";
}

if (($invrec_2 != '0') && ($iorq_2 != "quote")) {
echo "<button type=button onClick=\"parent.location='../storemobile/receipt.php?func=show_receipt&receipt=$invrec_2'\"><i class=\"fa fa-file-text fa-lg\"></i> ".pcrtlang("View Receipt")." #$invrec_2</button>";
}

}

echo "</div>";

echo "<br></td></tr>";

}





#######################################################
echo "</table>";


echo "</div>\n";
#end of 5nd pane

#start of #repaircart
echo "<div id=\"repaircart\" class=\"ui-body-d ui-content\" style=\"padding:2px;\">";

echo "<table class=doublestandard><tr><th colspan=2>";
echo pcrtlang("Repair Cart")."</th></tr>";


if (($rs_chargewhatcount != 0) || ($rs_invoicecount != 0)) {


#echo "<table class=doublestandard><tr><th colspan=2>";
#echo pcrtlang("Repair Cart")."</th></tr>";
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


$rs_labor_desc2 = urlencode($rs_labor_desc);
$rs_cart_unit_price2 = urlencode($unit_price);
$rs_itemserial2 = urlencode($rs_itemserial);
$rs_labor_pdesc2 = urlencode($rs_labor_pdesc);

if($ourprice == 0 ) {
$ourprice_ue = 0;
} else {
$ourprice_ue = urlencode($ourprice / $quantity);
}


#wip

if ($rs_stock_id == '0') {
echo "<tr><td>";
echo "$rs_labor_desc";

if ($rs_itemserial != "") {
echo "<br>".pcrtlang("Serial/Code").": $rs_itemserial";
}


echo "</td><td style=\"text-align:right;\">".qf("$quantity")."X$money".mf("$unit_price")."<br>$money".mf("$rs_cart_price")."</td></tr>";
echo "<tr><td>";


echo "<a href=\"#popupdeletercitem$cart_item_id\" data-rel=\"popup\" data-position-to=\"window\" data-transition=\"pop\" class=\"ui-btn-inline ui-btn ui-shadow ui-corner-all\">";
echo "<i class=\"fa fa-trash fa-lg\"></i></a>";
echo "<div data-role=\"popup\" id=\"popupdeletercitem$cart_item_id\" data-overlay-theme=\"b\"  data-theme=\"a\" data-dismissible=\"false\">";
echo "<div data-role=\"header\" data-theme=\"b\">";
echo "<h1>".pcrtlang("Delete Cart Item")."?</h1>";
echo "</div>";
echo "<div role=\"main\" class=\"ui-content\">";
echo "<p>".pcrtlang("Are you sure you wish to delete this item from the cart?")."</p>";
echo "<div align=\"right\"><a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\" data-inline=\"true\">";
echo "<i class=\"fa fa-ban fa-lg\"></i>  ".pcrtlang("Cancel")."</a>";
echo "<button onClick=\"parent.location='repcart.php?func=remove_cart_item&pcwo=$pcwo&cart_item_id=$cart_item_id'\" data-inline=\"true\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")." </button></div>";
echo "</div>";
echo "</div>";


echo "<button type=button onClick=\"parent.location='repcart.php?func=edit&woid=$pcwo&cart_item_id=$cart_item_id&rs_cart_price=$unit_price&rs_taxex=$rs_taxex&rs_cart_type=$rs_cart_type&itemdesc=$rs_labor_desc2&price_alt=$price_alt&serial=$rs_itemserial2&cost=$ourprice_ue&qty=$quantity&itempdesc=$rs_labor_pdesc2'\" data-inline=\"true\"><i class=\"fa fa-edit\"></i></button>";

if ($price_alt != 1) {
echo "<button type=button onClick=\"parent.location='repcart.php?func=add_discount&woid=$pcwo&cart_item_id=$cart_item_id&rs_cart_price=$unit_price&rs_taxex=$rs_taxex&rs_cart_type=$rs_cart_type&itemdesc=$rs_labor_desc2&qty=$quantity'\"  data-inline=\"true\"><i class=\"fa fa-level-down\"></i></button>";
} else {
echo "<button type=button onClick=\"parent.location='repcart.php?func=removediscount&cart_item_id=$cart_item_id&woid=$pcwo'\" data-inline=\"true\"><i class=\"fa fa-money\"> <i class=\"fa fa-level-up\"></i> $money$origprice</button>";
}


###
$rs_find_tax = "SELECT * FROM taxes WHERE taxenabled = '1' ORDER BY taxname ASC";
$rs_result_tax = mysqli_query($rs_connect, $rs_find_tax);
echo "</td><td><form method=post action=repcart.php?func=setitemtax data-ajax=\"false\"><input type=hidden name=cart_item_id value=$cart_item_id><select name=settaxid onchange='this.form.submit()' data-native-menu=\"false\">";

while($rs_result_tq = mysqli_fetch_object($rs_result_tax)) {
$rs_taxname = "$rs_result_tq->shortname";
$rs_taxid = "$rs_result_tq->taxid";

if ($rs_taxid == $rs_taxex) {
echo "<option selected value=$rs_taxid>$rs_taxname</option>";
} else {
echo "<option value=$rs_taxid>$rs_taxname</option>";
}
}
echo "</select><input type=hidden name=cartitemtype value=$rs_cart_type><input type=hidden name=woid value=$pcwo></form></td></tr>";
###



} else {
$rs_find_item_detail = "SELECT * FROM stock WHERE stock_id = '$rs_stock_id'";
$rs_find_result_detail = mysqli_query($rs_connect, $rs_find_item_detail);

while($rs_find_result_detail_q = mysqli_fetch_object($rs_find_result_detail)) {
$rs_stocktitle = "$rs_find_result_detail_q->stock_title";

$rs_stocktitle2 = urlencode($rs_stocktitle);

echo "<tr><td>";
echo "$rs_stocktitle";

if ($rs_itemserial != "") {
echo "<br>".pcrtlang("Serial/Code").": ".pcrtlang("$rs_itemserial")."";
}

if (($rs_itemserial == "") && ($quantity == 1)) {
if (count(available_serials($rs_stock_id)) > 0) {
echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class=\"sizemesmaller boldme\"><i class=\"fa fa-info-circle faa-flash animated\"></i> ".pcrtlang("Serials Available")."</span>";
echo " <button type=button onClick=\"parent.location='repcart.php?func=addserialafter&pcwo=$pcwo&cart_item_id=$cart_item_id&stockid=$rs_stock_id'\" data-inline=\"true\" data-mini=\"true\">
<i class=\"fa fa-plus\"></i></a>";
}
}

$rs_find_stock = "SELECT * FROM stockcounts WHERE storeid = '$defaultuserstore' AND stockid = '$rs_stock_id'";
$rs_result_stock = mysqli_query($rs_connect, $rs_find_stock);
$rs_result_stockq = mysqli_fetch_object($rs_result_stock);
$stockqty = "$rs_result_stockq->quantity";

$rs_cart_addtime_menosuno = $rs_cart_addtime + 86400;
$rs_cart_addtime_ahora = time();


if(($stockqty < 1) && ($rs_cart_addtime_menosuno > $rs_cart_addtime_ahora)) {
echo "<br><font style=\"color:red\"><i class=\"fa fa-exclamation-triangle fa-lg\"></i> ".pcrtlang("Warning: Item showing out of stock quantity")." ($stockqty)</font>
<button type=button onClick=\"parent.location='../store/stock.php?func=show_stock_detail&stockid=$rs_stock_id'\" data-inline=\"true\" data-mini=\"true\">(".pcrtlang("check qty").")</button>";
}



echo "</td><td style=\"text-align:right;\">".qf("$quantity")."X$money".mf("$unit_price")."<br>$money".mf("$rs_cart_price")."</td></tr>";
echo "<tr><td>";

echo "<a href=\"#popupdeletercitem$cart_item_id\" data-rel=\"popup\" data-position-to=\"window\" data-transition=\"pop\" class=\"ui-btn-inline ui-btn ui-shadow ui-corner-all\">";
echo "<i class=\"fa fa-trash fa-lg\"></i></a>";
echo "<div data-role=\"popup\" id=\"popupdeletercitem$cart_item_id\" data-overlay-theme=\"b\"  data-theme=\"a\" data-dismissible=\"false\">";
echo "<div data-role=\"header\" data-theme=\"b\">";
echo "<h1>".pcrtlang("Delete Cart Item")."?</h1>";
echo "</div>";
echo "<div role=\"main\" class=\"ui-content\">";
echo "<p>".pcrtlang("Are you sure you wish to delete this item from the cart?")."</p>";
echo "<div align=\"right\"><a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\" data-inline=\"true\">";
echo "<i class=\"fa fa-ban fa-lg\"></i>  ".pcrtlang("Cancel")."</a>";
echo "<button onClick=\"parent.location='repcart.php?func=remove_cart_item&pcwo=$pcwo&cart_item_id=$cart_item_id'\" data-inline=\"true\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")." </button></div>";
echo "</div>";
echo "</div>";


if($rs_itemserial == "") {
$rs_cart_unit_price_ue = urlencode("$unit_price");
$rs_quantity_ue = urlencode("$quantity");

if($ourprice == 0 ) {
$ourprice_ue = 0;
} else {
$ourprice_ue = urlencode($ourprice / $quantity);
}

echo "<button type=button onClick=\"parent.location='repcart.php?func=editinvitem&cart_item_id=$cart_item_id&rs_cart_price=$rs_cart_unit_price_ue&rs_taxex=$rs_taxex&price_alt=$price_alt&cost=$ourprice_ue&qty=$rs_quantity_ue&woid=$pcwo'\"   data-inline=\"true\" ><i class=\"fa fa-edit\"></i></button>";
}


if ($price_alt != 1) {
echo "<button type=button onClick=\"parent.location='repcart.php?func=add_discount&woid=$pcwo&cart_item_id=$cart_item_id&rs_cart_price=$unit_price&rs_taxex=$rs_taxex&rs_cart_type=$rs_cart_type&itemdesc=$rs_stocktitle2&qty=$quantity'\"  data-inline=\"true\" ><i class=\"fa fa-money\"> <i class=\"fa fa-level-down\"></i></button>";
} else {
echo "<button type=button onClick=\"parent.location='repcart.php?func=removediscount&cart_item_id=$cart_item_id&woid=$pcwo'\" data-inline=\"true\"><i class=\"fa fa-money\"> <i class=\"fa fa-level-up\"></i></button>";
}



###
$rs_find_tax = "SELECT * FROM taxes WHERE taxenabled = '1' ORDER BY taxname ASC";
$rs_result_tax = mysqli_query($rs_connect, $rs_find_tax);
echo "</td><td><form method=post action=repcart.php?func=setitemtax data-ajax=\"false\"><input type=hidden name=cart_item_id value=$cart_item_id><select name=settaxid  onchange='this.form.submit()' data-native-menu=\"false\">";

while($rs_result_tq = mysqli_fetch_object($rs_result_tax)) {
$rs_taxname = "$rs_result_tq->shortname";
$rs_taxid = "$rs_result_tq->taxid";

if ($rs_taxid == $rs_taxex) {
echo "<option selected value=$rs_taxid>$rs_taxname</option>";
} else {
echo "<option value=$rs_taxid>$rs_taxname</option>";
}
}
echo "</select><input type=hidden name=cartitemtype value=$rs_cart_type><input type=hidden name=woid value=$pcwo></form></td></tr>";
###





}
}
}




$rs_findtsum = "SELECT (SUM(cart_price) + SUM(itemtax)) as checkcarttsum FROM repaircart WHERE pcwo = '$pcwo'";
$rs_findtsum2 = @mysqli_query($rs_connect, $rs_findtsum);
$rs_findtsum3 = mysqli_fetch_object($rs_findtsum2);
$checkcarttsum2 = "$rs_findtsum3->checkcarttsum";

if(is_numeric($checkcarttsum2)) {
$checkcarttsum = mf($checkcarttsum2, 2, '.', '');

if ($rs_chargewhatcount != 0) {
echo "<tr><td>";

echo "<form action=repcart.php?func=loadsavecartout&pcwo=$pcwo method=post data-ajax=\"false\">";

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

if($invcount > "0") {
echo "<button data-theme=\"b\" type=button  onclick=\"javascript: if(confirm('".pcrtlang("This Work Order has invoices specified. Are you sure your want to continue checking out THE CART, AND NOT THE INVOICE?")."')) this.form.submit();\"><i class=\"fa fa-shopping-cart fa-lg\"></i> ".pcrtlang("CHECKOUT")."</button></form>";
} else {
echo "<button data-theme=\"b\" type=button  onclick=\"this.disabled=true; this.form.submit();\"><i class=\"fa fa-shopping-cart fa-lg\"></i> ".pcrtlang("CHECKOUT")."</button></form>";
}



echo "</td><td style=\"text-align:right;\">";
echo pcrtlang("Repair Cart Total").": $money$checkcarttsum";
echo "</td></tr>";
}
}


} else {
echo "<tr><td>".pcrtlang("No Items in the Cart")."</td></tr>";
}


$rs_find_cart_items = "SELECT * FROM receipts WHERE woid LIKE '%_$pcwo"."_%' AND (invoice_id = '' OR invoice_id = '0')";
$rs_resultrec = mysqli_query($rs_connect, $rs_find_cart_items);

if(mysqli_num_rows($rs_resultrec) > 0) {


while($rs_result_q = mysqli_fetch_object($rs_resultrec)) {
$rs_receipt_id = "$rs_result_q->receipt_id";
$rs_pay_type = "$rs_result_q->pay_type";
$rs_name = "$rs_result_q->person_name";
$rs_company = "$rs_result_q->company";
$rs_pay_type = "$rs_result_q->pay_type";
$rs_checkno = "$rs_result_q->check_number";
$rs_gt = "$rs_result_q->grandtotal";
$rs_date = "$rs_result_q->date_sold";

echo "<tr><td colspan=2><button type=button onClick=\"parent.location='../store/receipt.php?func=show_receipt&receipt=$rs_receipt_id'\">Receipt: #$rs_receipt_id</button></td></tr>";

}
}




echo "</table>";


echo "<div data-role=\"collapsible\">";
echo "<h3>".pcrtlang("Add Labor")."</h3>";
echo "<table class=standard><tr><td>";
echo "<form action=repcart.php?func=add_labor2 method=post data-ajax=\"false\"><input type=hidden name=pcwo value=$pcwo>";
echo pcrtlang("Qty")."<input type=number name=qty value=1 min=\".01\" step=\".01\">";
echo "<input type=text name=labordesc placeholder=\"".pcrtlang("Enter Labor Description")."\">";
echo "<textarea name=laborpdesc placeholder=\"".pcrtlang("Enter Optional Printed Labor Description")."\"></textarea>";
echo "<input type=text name=laborprice id=laborprice required=required  placeholder=\"".pcrtlang("Enter Labor Rate Charge")."\" onFocus=\"this.form.submitbutton.disabled=false;this.form.submitbutton.value='&laquo;".pcrtlang("Add Labor")."';\">";

$usertaxid = getusertaxid();
$servicetaxrateremain = (1 + getservicetaxrate($usertaxid));
if($servicetaxrateremain != 1) {
echo "<button class=button type=button title=\"".pcrtlang("Pre-Tax Calculator")."\" onclick='document.getElementById(\"laborprice\").value=(document.getElementById(\"laborprice\").value / $servicetaxrateremain).toFixed(5)'>
<i class=\"fa fa-calculator\"></i> ".pcrtlang("Calculate Pre-Tax")."</button>";
}

echo "<button type=button  id=submitbutton onclick=\"this.disabled=true; this.form.submit();\"><i class=\"fa fa-plus\"></i> ".pcrtlang("Add Labor")."</button></form>";
echo "</td></tr></table>";
echo "</div>";


$rs_quicklabor = "SELECT * FROM quicklabor ORDER BY theorder DESC";
$rs_result_ql  = mysqli_query($rs_connect, $rs_quicklabor);


echo "<form action=\"repcart.php?func=add_labor3\" method=post data-ajax=\"false\"><input type=hidden name=pcwo value=$pcwo>";
echo "<select name=qlid data-iconpos=\"left\" onchange='this.form.submit()'>";
echo "<option value=\"\">".pcrtlang("Add Quick Labor")."</option>";
echo "<option value=\"0\">$money"."0.00 ".pcrtlang("No Charge")."</option>";
while($rs_result_qld = mysqli_fetch_object($rs_result_ql)) {
$labordesc = "$rs_result_qld->labordesc";
$laborprice = mf("$rs_result_qld->laborprice");
$qlid = "$rs_result_qld->quickid";
$printdesc = "$rs_result_qld->printdesc";

$labordesc2 = urlencode("$labordesc");

$primero = substr("$labordesc", 0, 1);

if("$primero" != "-") {
echo "<option value=\"$qlid\">$money$laborprice $labordesc</option>";
} else {
$labordesc3 = substr("$labordesc", 1);
echo "<option disabled value=\"divider\">$labordesc3</option>";
}


}

echo "</select></form>";


echo "<div data-role=\"collapsible\">";
echo "<h3>".pcrtlang("Add Stock Item")."</h3>";
echo "<table class=standard><tr><td>";
echo "<form action=repcart.php?func=add_item method=post data-ajax=\"false\"><input type=hidden name=pcwo value=$pcwo>";
echo pcrtlang("Qty")."<input type=number class=textboxw name=qty value=1 min=1 step=1>";
echo "<input type=text autocomplete=off id=autoinvsearchbox name=\"stockid\" placeholder=\"".pcrtlang("Enter Stock Id Numbers")."\">";
echo "<button type=button  onclick=\"this.disabled=true;this.value='".pcrtlang("Adding Item")."...'; this.form.submit();\"><i class=\"fa fa-plus\"></i> ".pcrtlang("Add Inventory Items")."</button></form>";
echo "<div id=\"autoinvsearch\"></div>";
echo "</td></tr></table>";
echo "</div>";

echo "<div data-role=\"collapsible\">";
echo "<h3>".pcrtlang("Non-Inventoried Item")."</h3>";
echo "<table class=standard><tr><td>";
echo "<form action=repcart.php?func=add_noninv name=add_noninv method=post data-ajax=\"false\">";
echo pcrtlang("Qty")."<input type=number name=qty value=1 min=1 step=1>";
echo "<input type=text class=textboxw size=20 name=itemdesc placeholder=\"".pcrtlang("Enter Item Description")."\"> ";
echo "<textarea name=itempdesc placeholder=\"".pcrtlang("Enter Optional Printed Item Description")."\"></textarea>";
echo pcrtlang("Price")."&nbsp;$money<input type=text class=textboxw name=itemprice id=itemprice size=4 required=required onFocus=\"this.form.submitbutton.disabled=false;this.form.submitbutton.value='^ ".pcrtlang("Add Non-Inv. Item")." ^';\">";

$usertaxid = getusertaxid();
$salestaxrateremain = (1 + getsalestaxrate($usertaxid));
if($salestaxrateremain != 1) {
echo "<button class=button type=button title=\"".pcrtlang("Pre-Tax Calculator")."\" onclick='document.getElementById(\"itemprice\").value=(document.getElementById(\"itemprice\").value / $salestaxrateremain).toFixed(5)'>
<i class=\"fa fa-calculator\"></i> ".pcrtlang("Calculate Pre-Tax")."</button>";
}


echo "<br>".pcrtlang("Cost").":&nbsp;$money<input type=text class=textboxw name=ourprice size=4 value=\"0.00\"><input type=hidden name=woid value=$pcwo>";
echo "<br>".pcrtlang("Serial/Code").":&nbsp;(".pcrtlang("optional").") <input type=text name=itemserial>";

?>
<script type="text/javascript">
$(document).ready(function(){
  $("input#autoinvsearchbox").keyup(function(){
    if(this.value.length<3) {
      $("div#autoinvsearch").slideUp(200,function(){
        return false;
      });
    }else{
        var encodedinv = encodeURIComponent(this.value);
        $('div#autoinvsearch').load('autosearch.php?func=inv&search='+encodedinv).slideDown(200);
    }
  });
});
</script>

<script>
function markup() {
var marknum = Math.ceil((document.add_noninv.ourprice.value - 0) * (document.add_noninv.chooser.value - 0)) - document.add_noninv.cents.value;
document.add_noninv.itemprice.value = marknum.toFixed(2);
}
</script>
<?php

echo pcrtlang("Markup").": ";
echo "<select name=chooser onChange=\"markup()\" data-native-menu=\"false\">
<option value=\"1.0\"></option>
<option value=\"1.04\">4%</option>
<option value=\"1.1\">10%</option>
<option value=\"1.2\">20%</option>
<option value=\"1.3\">30%</option>
<option value=\"1.4\">40%</option>
<option value=\"1.5\">50%</option>
<option value=\"1.75\">75%</option>
<option value=\"2\">2X</option>
<option value=\"3\">3X</option>
<option value=\"5\">5X</option>
<option value=\"10\">10X</option>
</select>";

echo "<select name=cents onChange=\"markup()\"  data-native-menu=\"false\">
<option value=\"0.10\">90 cents</option>
<option value=\"0.05\">95 cents</option>
<option value=\"0.01\">99 cents</option>
<option value=\"00\">00 cents</option>
</select>";


echo "<br><button type=button  id=submitbutton onclick=\"this.disabled=true; this.form.submit();\"><i class=\"fa fa-plus\"></i> ".pcrtlang("Add Non-Inv. Item")."</button></form>";

echo "</td></tr></table>";

echo "</div>";

echo "<button onClick=\"parent.location='pc.php?func=addspo&woid=$pcwo'\" >".pcrtlang("Add Special Order Part")."</button>";



echo "<form action=\"../storemobile/cart.php?func=copysavecart\" method=post data-ajax=\"false\"><input type=hidden name=pcwo value=$pcwo><select name=cartname data-iconpos=\"left\" onchange='this.form.submit()'>";
$rs_find_cart_items = "SELECT DISTINCT cartname, savedwhen FROM savedcarts WHERE iskit = '1' ORDER BY cartname ASC";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

echo "<option value=\"\">".pcrtlang("Add Kit to Repair Cart")."</option>";

while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_cart_name = "$rs_result_q->cartname";
$rs_saved_when = "$rs_result_q->savedwhen";


echo "<option value=\"$rs_cart_name\">$rs_cart_name</option>";
}
echo "</select>";

echo "</form>";



echo "<div data-role=\"collapsible\">";
echo "<h3>".pcrtlang("Deposits")."</h3>";

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
while ($finddepositsa = mysqli_fetch_object($finddepositsq)) {
$depositid = "$finddepositsa->depositid";
$depamount2 = "$finddepositsa->amount";
$depamount = number_format($depamount2, 2, '.', '');
$depfirstname = "$finddepositsa->pfirstname";
$depplugin = "$finddepositsa->paymentplugin";
$dstatus = "$finddepositsa->dstatus";
$dwoid = "$finddepositsa->woid";
$dinvoiceid = "$finddepositsa->invoiceid";

echo "<table class=standard>";
echo "<tr><th>".pcrtlang("Deposit").": #$depositid</th><th>$depplugin: $money$depamount</th></tr>";
echo "<tr><td>$depfirstname</td><td>";
echo pcrtlang("Status").": $dstatus</td></tr>";

if(($dwoid != 0) && ($dinvoiceid == 0)) {
echo "<tr><td>".pcrtlang("Attached to Work Order")."</td><td>";
} elseif ($dinvoiceid != 0) {
echo "<tr><td>".pcrtlang("Attached to Invoice").": $dinvoiceid</td><td>";
} else {

}


########

if($dstatus == "open") {
if(!empty($depositinvoicearray) || ($dinvoiceid != 0)) {

if($dinvoiceid != 0) {
echo pcrtlang("Move To").":<br><button onClick=\"parent.location='pc.php?func=switchdeposit&towhat=woid&woid=$pcwo&depositid=$depositid\">".pcrtlang("Work Order")." #$pcwo</button><br>";
}


if(!empty($depositinvoicearray)) {
reset($depositinvoicearray);

echo pcrtlang("Move To").":";
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
$invdtotal = $invdsumd + $invdsumtax;

if(($invdsum + $depamount) <= $invdtotal) {
echo "<button onClick=\"parent.location='pc.php?func=switchdeposit&towhat=invoice&invoiceid=$thisinv&depositid=$depositid&woid=$pcwo\">".pcrtlang("Invoice")." #$thisinv</button>";
} else {
echo "<button disabled>".pcrtlang("Invoice")."#$thisinv</button>";
}

}
}
}
}
}


if(($dwoid != 0) && ($dinvoiceid == 0)) {
echo "<button onClick=\"parent.location='pc.php?func=removedepositfromwo&depositid=$depositid&woid=$pcwo'\">".pcrtlang("Remove from WO")."</button>";
}



########

echo "</td></tr>";


echo "</table>";
echo "<br>";
}


if ($pcgroupid == 0) {
echo "<button type=button onClick=\"parent.location='../storemobile/deposits.php?woid=$pcwo&cfirstname=$pcname2&ccompany=$pccompany2&caddress=$pcaddress12&caddress2=$pcaddress22&ccity=$pccity2&cstate=$pcstate2&czip=$pczip2&cphone=$pcphone2&cemail=$pcemail2'\" data-theme=\"b\"><i class=\"fa fa-plus\"></i> ".pcrtlang("Add New Deposit")."</button>";
} else {
echo "<button type=button onClick=\"parent.location='../storemobile/deposits.php?woid=$pcwo&cfirstname=$ue_pcgroupname&ccompany=$ue_grpcompany&caddress=$ue_grpaddress&caddress2=$ue_grpaddress2&ccity=$ue_grpcity&cstate=$ue_grpstate&czip=$ue_grpzip&cphone=$ue_grpphone&cemail=$ue_grpemail'\" data-theme=\"b\"><i class=\"fa fa-plus\"></i> ".pcrtlang("Add New Deposit")."</button>";
}


$finduadeposits = "SELECT * FROM deposits WHERE woid = '0' AND invoiceid = '0' AND dstatus = 'open'";
$finduadepositsq = @mysqli_query($rs_connect, $finduadeposits);

if(mysqli_num_rows($finduadepositsq) > 0) {

echo "<br>".pcrtlang("Add Un-Attached Deposit to Work Order").": ";

echo "<form method=post action=\"pc.php?func=adddeposittowo\" data-ajax=\"false\"><input type=hidden name=woid value=\"$pcwo\"><select name=depositid>";

while ($finduadepositsa = mysqli_fetch_object($finduadepositsq)) {
$depositid = "$finduadepositsa->depositid";
$depositfname = "$finduadepositsa->pfirstname";
$depositlname = "$finduadepositsa->plastname";
$depositamount = "$finduadepositsa->amount";

echo "<option value=\"$depositid\">$depositfname $depositlname - $money$depositamount</option>";

}
echo "</select><button type=submit data-theme=\"b\"><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Add Selected Deposit")."</button></form>";
}



echo "</div>";


echo "</div>\n";
#end of 4nd pane

#start of special order pane
echo "<div id=\"specialorders\" class=\"ui-body-d ui-content\" style=\"padding:2px;\">";


echo "<br>";
echo "<button onClick=\"parent.location='pc.php?func=addspo&woid=$pcwo'\" ><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Add Special Order Part")."</button>";
echo "<br>";





$rs_find_so = "SELECT * FROM specialorders WHERE spowoid = '$pcwo'";
$rs_result_so = mysqli_query($rs_connect, $rs_find_so);

if(mysqli_num_rows($rs_result_so) > 0) {




$statii = array(
0 => pcrtlang("Awaiting Customer Approval"),
8 => pcrtlang("Order Part"),
1 => pcrtlang("On Order"),
2 => pcrtlang("Received"),
3 => pcrtlang("Installed"),
4 => pcrtlang("Wrong Part"),
5 => pcrtlang("Bad/Damaged Part"),
6 => pcrtlang("Abandoned Part"),
7 => pcrtlang("Unable to Locate")
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

echo "<table class=standard><tr><th>$spopartname</th><th>".qf("$spoquantity")."X$money".mf("$spounit_price")."<br>$money".mf("$spoprice")."</th></tr>";

if($sposupplierid != 0) {
$rs_find_suppliers = "SELECT * FROM suppliers WHERE supplierid = $sposupplierid";
$rs_result_supp = mysqli_query($rs_connect, $rs_find_suppliers);
$rs_result_suppq = mysqli_fetch_object($rs_result_supp);
$suppliername2 = "$rs_result_suppq->suppliername";
} else {
$suppliername2 = "$sposuppliername";
}


if(perm_check("23") && ($sposupplierid != 0)) {
echo "<tr><td><button type=button onClick=\"parent.location='suppliers.php?func=viewsupplier&supplierid=$sposupplierid'\"><i class=\"fa fa-building fa-lg\"></i> $suppliername2</button></td>";
} else {
echo "<tr><td>$suppliername2</td>";
}

echo "<td>$spopartnumber</td></tr>";
echo "<tr><td>";
if($spoparturl != "") {
$parturl2 = addhttp("$spoparturl");
echo "<a href=\"$parturl2\" target=\"_blank\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"><i class=\"fa fa-external-link fa-lg\"></i></button>";
}
echo "</td>";

echo "<td><a href=http://google.com/#q=$spotracking\" target=\"_blank\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"><i class=\"fa fa-truck fa-lg\"></i> $spotracking</a></td></tr>";

echo "<tr><td>$spodate</td>";

echo "<td>$statii[$spostatus]</td></tr><tr><td colspan=2>$sponotes</td></tr>";


echo "<tr><td colspan=2>";

echo "<a href=\"#popupdeletespo$spoid\" data-rel=\"popup\" data-position-to=\"window\" data-transition=\"pop\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\">";
echo "<i class=\"fa fa-trash fa-lg\"></i></a>";
echo "<div data-role=\"popup\" id=\"popupdeletespo$spoid\" data-overlay-theme=\"b\"  data-theme=\"a\" data-dismissible=\"false\">";
echo "<div data-role=\"header\" data-theme=\"b\">";
echo "<h1>".pcrtlang("Delete Special Order")."?</h1>";
echo "</div>";
echo "<div role=\"main\" class=\"ui-content\">";
echo "<p>".pcrtlang("Are you sure you wish to permanently delete this Special Order!!!?")."</p>";
echo "<div align=\"right\"><a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\" data-inline=\"true\"><i class=\"fa fa-ban fa-lg\"></i>  ".pcrtlang("Cancel")."</a>";
echo "<button onClick=\"parent.location='pc.php?func=deletespo&spoid=$spoid&spowoid=$pcwo'\" data-inline=\"true\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")." </button></div>";
echo "</div>";
echo "</div>";



echo "<button class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" type=button onClick=\"parent.location='pc.php?func=editspo&spoid=$spoid&spowoid=$pcwo'\"><i class=\"fa fa-edit fa-lg\"></i></button>";
echo "<button class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" type=button onClick=\"parent.location='repcart.php?func=spoaddcart&spoid=$spoid&spowoid=$pcwo'\"><i class=\"fa fa-cart-plus fa-lg\"></i></button>";

echo "</td>";

echo "</tr></table><br>";


}



}



echo "</div>\n";
#end of 6th pane
echo "<div id=\"travellog\" class=\"ui-body-d ui-content\" style=\"padding:2px;\">";


?>
<script type="text/javascript">
$.get('woajaxtl.php?pcwo=<?php echo $pcwo; ?>&addystring=<?php echo "$addystring;" ?>', function(data) {
    $('#woajaxtl').html(data).enhanceWithin('create');
  });
</script>
<div id="woajaxtl"></div>

<?php





echo "</div>\n";
#end of 7th pane
echo "<div id=\"scans\" class=\"ui-body-d ui-content\" style=\"padding:2px;\">";


?>
<script type="text/javascript">
$.get('woajaxscans.php?pcwo=<?php echo $pcwo; ?>', function(data) {
    $('#woajaxscans').html(data).enhanceWithin('create');
  });
</script>
<div id="woajaxscans"></div>

<?php



################### 
echo "</div>\n";
#end of 8th pane
echo "<div id=\"timer\" class=\"ui-body-d ui-content\" style=\"padding:2px;\">";



echo "<br>";

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






echo "<form action=pc.php?func=timerstart&woid=$pcwo method=post data-ajax=\"false\">".pcrtlang("Task Description");
echo "<input name=timername><button type=submit data-theme=\"b\"><i class=\"fa fa-clock-o fa-lg\"></i> ".pcrtlang("Start New Timer")."</button></form>";


echo "<br><form action=pc.php?func=timerstartmanual&woid=$pcwo method=post data-ajax=\"false\">";
echo "<button type=submit><i class=\"fa fa-clock-o fa-lg\"></i> ".pcrtlang("Manual Timer")."</button></form>";
if($pcgroupid != 0) {
echo "<br><button onClick=\"parent.location='group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=blockcontract'\"><i class=\"fa fa-file-text-o fa-lg\"></i> ".pcrtlang("Block of Time Contracts")."</button>";
}


echo "<br>";

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

$timerstartdate2 = date('n-j-Y', strtotime($timerstart));
$timerstarttime2 = date('g:ia', strtotime($timerstart));
$timerstoptime2 = date('g:ia', strtotime($timerstop));


$startepoch = strtotime($timerstart);
$stopepoch = time();
$startseconds = $stopepoch - $startepoch;

if($timerstop == "0000-00-00 00:00:00") {
echo "<table class=standard><tr><th colspan=2>$timername</th></tr><tr><td>".pcrtlang("Started By").":</td><td>$timerbyuser</td></tr>
<tr><td>".pcrtlang("Start Date").":</td><td>$timerstartdate2</td></tr>
<tr><td>".pcrtlang("Start Time").":</td><td>$timerstarttime2</td></tr>
<tr><td>".pcrtlang("Time Elapsed").":</td><td><i class=\"fa fa-spinner fa-lg fa-spin\"></i></font> ";

?>
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


echo "</td></tr>
<tr><td><form action=pc.php?func=timereditprog&woid=$pcwo&timerid=$timerid method=post data-ajax=\"false\"><button class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" type=submit ><i class=\"fa fa-edit\"></i> ".pcrtlang("Edit")."</button></form></td>
<td><form action=pc.php?func=timerstop&woid=$pcwo&timerid=$timerid&blockcontractid=$blockcontractid method=post data-ajax=\"false\"><button class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" type=submit class=ibutton><i class=\"fa fa-stop\"></i> ".pcrtlang("Stop")."</button></form></td>
</tr></table><br>";

} else {

$startstamp = strtotime("$timerstart");
$stopstamp = strtotime("$timerstop");

$elapsedtime = $stopstamp - $startstamp;


$elapsedhuman = time_elapsed($elapsedtime);

echo "<table class=standard><tr><th colspan=2>$timername: $elapsedhuman</th></tr><td>".pcrtlang("Started By").":</td><td>$timerbyuser</td></tr>";
echo "<tr><td colspan=2>";

if($billedout == 0) {
$timername_hsc = htmlspecialchars("$timername");
echo "<form action=pc.php?func=timerbillfirst&woid=$pcwo&pcgroupid=$pcgroupid&timerid=$timerid&billtime=$elapsedtime method=post data-ajax=\"false\">
<input type=hidden name=timerdesc value=\"$timername_hsc\">
<button type=submit ><i class=\"fa fa-money fa-lg\"></i> ".pcrtlang("Bill Hours")."</button></form>";

} else {

if($blockcontractid != 0) { 
echo "<a href=\"group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=blockcontract\">Billed to Block of Time Contract</a>";
}

}

echo "</td></tr>
<tr><td>Start Date:</td><td>$timerstartdate2</td></tr>
<tr><td>Start Time:</td><td>$timerstarttime2</td></tr>
<tr><td>Stop Time:</td><td>$timerstoptime2</td></tr>
<tr><td colspan=2>";

echo "<a href=\"#popupdeletetimer$timerid\" data-rel=\"popup\" data-position-to=\"window\" data-transition=\"pop\" class=\"ui-btn ui-shadow ui-corner-all\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete Timer")."</a>";
echo "<div data-role=\"popup\" id=\"popupdeletetimer$timerid\" data-overlay-theme=\"b\"  data-theme=\"a\" data-dismissible=\"false\">";
echo "<div data-role=\"header\" data-theme=\"b\">";
echo "<h1>".pcrtlang("Delete Timer")."?</h1>";
echo "</div>";
echo "<div role=\"main\" class=\"ui-content\">";
echo "<p>".pcrtlang("Are you sure you wish to delete this Timer?")."</p>";
echo "<div align=\"right\"><a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\" data-inline=\"true\"><i class=\"fa fa-ban fa-lg\"></i>  ".pcrtlang("Cancel")."</a>";
echo "<button onClick=\"parent.location='pc.php?func=timerdelete&woid=$pcwo&timerid=$timerid&blockcontractid=$blockcontractid'\" data-inline=\"true\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")." </button></div>";
echo "</div>";
echo "</div>";

echo "<form action=pc.php?func=timeredit&woid=$pcwo&timerid=$timerid&blockcontractid=$blockcontractid method=post data-ajax=\"false\"><button type=submit ><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("Edit")."</button></form>
<form action=pc.php?func=timerstart&woid=$pcwo method=post data-ajax=\"false\"><input type=hidden name=timername value=\"$timername\"><button type=submit ><i class=\"fa fa-clock-o fa-lg\"></i> ".pcrtlang("Resume")."</button></form>
</td></tr></table><br>";

}

}


echo "</div>\n";
#end of 8th pane
echo "<div id=\"notes\" class=\"ui-body-d ui-content\" style=\"padding:2px;\">";


echo "<br>";

echo "<table class=standard><tr><th>".pcrtlang("Notes for Customer")."</th>";


######

echo "<th style=\"text-align:right\"><a href=\"javascript:void(0);\" id=addcnote class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" data-theme=\"b\"><i class=\"fa fa-plus\"></i></a></th></tr>";

?>
<script type='text/javascript'>
$('#addcnote').click(function() {
  $('#custnote').slideToggle(500, function() {
	$( "#custnoteta" ).focus();
  });
});
</script>
<?php

echo "<tr><td colspan=2>";

echo "<div id=custnote style=\"display:none;\">";

echo "<form id=custnoteform action=pc.php?func=addnote2 method=post>";
echo "<table style=\"width:100%\"><tr><td>";
echo "<textarea id=custnoteta name=thenote required=required></textarea>";

echo "</td>";
echo "<td style=\"text-align:center;vertical-align:top;\">";
echo "<input type=hidden name=woid value=$pcwo><input type=hidden name=ajaxcall value=yes><input type=hidden name=notetype value=0>";
echo "<input type=hidden name=touch value=\"\">";
echo "<button type=submit ><i class=\"fa fa-save fa-lg\"></i></button></td></tr></table></form>";

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

echo "</table><br>";


#######tech notes



echo "<table class=standard><tr><th>".pcrtlang("Tech Notes")."</th>";
echo "<th style=\"text-align:right\">";
echo "<a href=\"javascript:void(0);\" id=addtnote class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" data-theme=\"b\"><i class=\"fa fa-plus\"></i></a></th></tr>";


?>
<script type='text/javascript'>
$('#addtnote').click(function() {
  $('#technote').slideToggle(500, function() {
        $( "#technoteta" ).focus();
  });
});
</script>
<?php

echo "<tr><td colspan=2>";

echo "<div id=technote style=\"display:none;\">";
echo "<form id=technoteform action=pc.php?func=addnote2 method=post>";
echo "<table style=\"width:100%\"><tr><td>";

echo "<textarea id=technoteta name=thenote required=required></textarea>";


echo "<td style=\"text-align:center;vertical-align:top;\">";
echo "<input type=hidden name=woid value=$pcwo><input type=hidden name=ajaxcall value=yes><input type=hidden name=notetype value=1>";
echo "<input type=hidden name=touch value=\"\">";
echo "<button type=submit ><i class=\"fa fa-save fa-lg\"></i></button></td></tr></table></form>";
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

echo "</td></tr></table>";

####### Messages wip

$emails = array();
$phnumbers = array();
$smsphonenumberoptions = "";

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

$emails_il = implode_list_email($emails);



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
}

if($pcworkphone != "") {
$pcworkphonestripped = preg_replace("/[^0-9,.]/", "", "$pcworkphone");
if (!in_array($pcworkphonestripped, $phnumbers)) {
$phnumbers[] = "$pcworkphonestripped";
}
$smsphonenumberoptions .= "<option value=\"$mysmsprefix".filtersmsnumber("$pcworkphone")."\">".pcrtlang("Work").": $pcworkphone</option>";
}
if($pcgroupid != 0) {

#wip

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


echo "<div data-role=\"collapsible\" data-theme=\"b\">";
echo "<h3><i class=\"fa fa-paper-plane fa-lg\"></i> ".pcrtlang("Send Message")."</h3>";

echo "<table class=standard><tr>";

echo "<tr><th>".pcrtlang("Send SMS")." ($mysmsgateway)</th></tr>";

echo "<tr><td>";

if ($mysmsgateway != "none") {

echo "<form action=sms.php?func=smssend2 method=post id=smsform data-ajax=\"false\">";

echo "<input type=hidden name=woid value=$pcwo>";

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


echo "<input type=hidden name=woid value=$pcwo><textarea rows=2 name=smsmessage id=smsmessage name=smsbox></textarea>";
echo "<input type=hidden name=phonenumbers value=$phnumbers_il>";
echo "<input type=hidden name=emails value=$emails_il>";
echo "<input type=hidden name=pickup value=\"$pickup\">";
echo "<input type=hidden name=dropoff value=\"$dropoff\">";

echo "<br>".pcrtlang("Characters Remaining").": <span id=\"charsLeft\"></span>";

###
if ($mysmsgateway == "twilio") {
$rs_assetphotos = "SELECT * FROM assetphotos WHERE pcid = '$pcid'";
$rs_result_aset = mysqli_query($rs_connect, $rs_assetphotos);
$totalsmspics = mysqli_num_rows($rs_result_aset);
if($totalsmspics > 0) {
echo "<br><br>";
echo "<fieldset data-role=\"controlgroup\"><legend>".pcrtlang("Attach Photo")."</legend>";
echo "<input type=radio name=assetphotoid id=radio-choice-01 value=0 checked>";
echo "<label for=\"radio-choice-01\"><img src=../repair/images/del.png> ".pcrtlang("No Photo")."</label>";
while($rs_result_aset2 = mysqli_fetch_object($rs_result_aset)) {
$photofilename = "$rs_result_aset2->photofilename";
$assetphotoid = "$rs_result_aset2->assetphotoid";
$highlight = "$rs_result_aset2->highlight";

echo "<input type=radio name=assetphotoid  id=\"radio-choice-$assetphotoid\" value=\"$assetphotoid\">";
echo "<label for=\"radio-choice-$assetphotoid\"><img src=pc.php?func=getpcimage&photoid=$assetphotoid style=\"width:100px;\"></label>";
}
echo "</select></fieldset>";
}
}
###



echo "<br><input type=submit value=\"".pcrtlang("Send SMS")."\">";

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



##############

echo "</td></tr><tr><th>".pcrtlang("Call Log/Send Message")."</th></tr><tr><td>";
echo "<form action=pc.php?func=addmessage method=post id=calllogform  data-ajax=\"false\"><input type=hidden name=woid value=$pcwo>";
echo "<input type=hidden name=phonenumbers value=$phnumbers_il>";
echo "<input type=hidden name=emails value=$emails_il>";
echo "<input type=hidden name=pickup value=\"$pickup\">";
echo "<input type=hidden name=dropoff value=\"$dropoff\">";
echo "<textarea name=themessage required=required placeholder=\"".pcrtlang("Enter Call Notes")."\"></textarea>";
echo "<fieldset data-role=\"controlgroup\">";

##
echo "<input type=radio name=type value=1 checked id=\"radio-choice-1\"><label for=\"radio-choice-1\">".pcrtlang("Call Log Note")."</label>";
echo "<input type=radio name=type value=2 id=\"radio-choice-2\"><label for=\"radio-choice-2\">".pcrtlang("Portal Message")."</label>";
echo "<input type=radio name=type value=3 id=\"radio-choice-3\"><label for=\"radio-choice-3\">".pcrtlang("Send Email")."<br>";
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
if("$pcemail" != "") {
echo "<option value=\"$pcemail\">$pcemail</option>";
}
if(isset($grpemail)) {
if("$grpemail" != "") {
echo "<option value=\"$grpemail\">$grpemail</option>";
}
}

echo "</select>";
##

echo "</label></fieldset>";
echo "<button type=submit><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button>";
echo "</form>";
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

$(document).ready(function () {
        setInterval(function() {
                $.get('sms.php?func=smsload&phonenumbers=<?php echo "$phnumbers_il"; ?>&emails=<?php echo "$emails_il"; ?>&woid=<?php echo "$pcwo"; ?>&pickup=<?php echo "$pickup"; ?>&dropoff=<?php echo "$dropoff"; ?>', function(data) {
                $('#messagearea').html(data);
                });
        }, 30000);
});


</script>
<?php


echo "<div id=messagearea>";
displaymessages("$phnumbers_il","$emails_il","$pcwo","$pickup","$dropoff");
echo "</div>";

echo "<br><a href=messages.php?func=browsemessages&woid=$pcwo&phonenumbers=$phnumbers_il&emails=$emails_il data-ajax=\"false\" class=\"ui-btn ui-corner-all ui-shadow\">
<i class=\"fa fa-comments fa-lg\"></i> ".pcrtlang("Browse all Messages")."</a>";

echo "<br>";



##########################################################################################

echo "</div>";
#end of work order notes

echo "</div>";
#end of tabs







} 

}





?>

</td></tr></table>

