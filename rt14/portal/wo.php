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


function nothing() {

echo "Nothing to see here";

}



##########


function browseworkorders() {

require("deps.php");
require("common.php");
require("header.php");


if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}


if (array_key_exists('pageNumber',$_REQUEST)) {
$pageNumber = $_REQUEST[pageNumber];
} else {
$pageNumber = 1;
}

$results_per_page = 40;

$offset = ($pageNumber * $results_per_page) - $results_per_page;





echo "<h3>".pcrtlang("Browse Work Orders")."</h3>";

#echo "<div class=\"table-responsive\">";
echo "<table id=wotable class=\"table table-striped\"><thead>";


echo "<tr><th><strong>".pcrtlang("WO ID")."#&nbsp;&nbsp;</strong></th><th>".pcrtlang("Name")."&nbsp;&nbsp;</th><th>WO Date&nbsp;&nbsp;</th>";
echo "<th> ".pcrtlang("Make")." &nbsp;&nbsp;</th><th>".pcrtlang("Problem/Task")."</th><th>".pcrtlang("Actions")."</th></tr></thead></tbody>";

$rs_wot = "SELECT pc_wo.woid FROM pc_wo, pc_owner WHERE pc_owner.pcgroupid = '$portalgroupid' AND pc_owner.pcid = pc_wo.pcid";
$rs_find_wot = @mysqli_query($rs_connect, $rs_wot);

$rs_wo = "SELECT pc_wo.woid,pc_wo.probdesc,pc_wo.dropdate,pc_wo.pcid FROM pc_wo, pc_owner WHERE pc_owner.pcgroupid = '$portalgroupid' AND pc_owner.pcid = pc_wo.pcid ORDER BY pc_wo.dropdate DESC LIMIT $offset,$results_per_page";

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


echo "<tr><td><strong>#$woid</strong></td><td>$compname</td><td>$dropdate2</td><td>$compmake";
if("$compcompany" != "") {
echo "<br>$compcompany";
}
echo "</td><td>$probdesc</td>";

echo "<td><a href=wo.php?func=printrepairreport&woid=$woid><i class=\"fa fa-print\"></i> ".pcrtlang("Repair Report")."</a></td>";

echo "</tr>";



}
echo "</tbody></table>";

#echo "</div>";

echo "<br>";

echo "<center>";
#browse here
$totalentry = mysqli_num_rows($rs_find_wot);
$prevpage = $pageNumber - 1;
$nextpage = $pageNumber + 1;

if ($pageNumber > 1) {
echo "<a href=group.php?func=browseworkorders&pageNumber=$prevpage  class=\"btn btn-default\" role=button><i class=\"fa fa-chevron-left fa-lg\"></i></a>";
}

$total_results = $totalentry;
$results_per_page = $results_per_page;
$html = get_paged_nav($total_results, $results_per_page, false);
echo "$html";
if (($totalentry / $results_per_page) > $pageNumber) {
echo "<a href=group.php?func=browseworkorders&pageNumber=$nextpage  class=\"btn btn-default\" role=button><i class=\"fa fa-chevron-right fa-lg\"></i></a>";
}

echo "</center><br><br>";


require("footer.php");

?>
<script>
$(document).ready(function () {
    $('#wotable').resTables();
});
</script>

<?php


}












function printrepairreport() {
require_once("validate.php");
require("deps.php");
require("common.php");

$woid = $_REQUEST['woid'];

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}

$rs_wo_permq = "SELECT pc_wo.woid FROM pc_wo, pc_owner WHERE pc_owner.pcgroupid = '$portalgroupid' AND pc_owner.pcid = pc_wo.pcid";
$rs_wo_perm = @mysqli_query($rs_connect, $rs_wo_permq);
while ($rs_result_perm = mysqli_fetch_object($rs_wo_perm)) {
$wocheck[] = "$rs_result_perm->woid";
}

if(!in_array("$woid", $wocheck)) {
die("Access Denied");
}



$rs_findpc = "SELECT * FROM pc_wo WHERE woid = '$woid'";
$rs_result = mysqli_query($rs_connect, $rs_findpc);
while($rs_result_q = mysqli_fetch_object($rs_result)) {
$pcid = "$rs_result_q->pcid";
$probdesc = "$rs_result_q->probdesc";
$dropoff = "$rs_result_q->dropdate";
$pickup = "$rs_result_q->pickupdate";
$pcstatus = "$rs_result_q->pcstatus";
$custassetsindb2 = "$rs_result_q->custassets";
$rs_storeid = "$rs_result_q->storeid";
$thesigwo = "$rs_result_q->thesigwo";
$showsigrr = "$rs_result_q->showsigrr";
$thesigwotopaz = "$rs_result_q->thesigwotopaz";
$showsigrrtopaz = "$rs_result_q->showsigrrtopaz";
$wochecks = "$rs_result_q->wochecks";

$storeinfoarray = getstoreinfo($rs_storeid);

$theprobsindb2 = "$rs_result_q->commonproblems";

$theprobsindb = serializedarraytest($theprobsindb2);

$comprobarrayv = array();
$rs_chkscansv = "SELECT theproblem FROM commonproblems WHERE custviewable = '1'";
$rs_chkresult_sv = mysqli_query($rs_connect, $rs_chkscansv);
while($rs_chkresult_q_sv = mysqli_fetch_object($rs_chkresult_sv)) {
$theprobv = "$rs_chkresult_q_sv->theproblem";
array_push($comprobarrayv,"$theprobv");
}

$custassetsindb = serializedarraytest($custassetsindb2);

$rs_findowner = "SELECT * FROM pc_owner WHERE pcid = '$pcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
while($rs_result_q2 = mysqli_fetch_object($rs_result2)) {
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
$pcextra2 = "$rs_result_q2->pcextra";
$pcextra = serializedarraytest($pcextra2);
$mainassettypeidindb = "$rs_result_q2->mainassettypeid";

$pcemail2 = urlencode("$pcemail");

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>&nbsp;</title>
<?php

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"printstyle.css\">";

if (!array_key_exists("allasset", $_REQUEST)) {
$allasset = "false";
} else {
$allasset = "true";
}


echo "<link rel=\"stylesheet\" href=\"fa/css/font-awesome.min.css\">";

echo "</head>";



if($autoprint == 1) {
echo "<body class=printpagebg onLoad=\"window.print()\">";
} else {
echo "<body class=printpagebg>";
}

echo "<div class=printbar>";
echo "<button onClick=\"window.history.back()\" class=bigbutton>";
echo "<i class=\"fa fa-reply\"></i> ".pcrtlang("Return")."</button>";
echo "<font class=text30b>&nbsp;&nbsp;</font>";
echo "<button onClick=\"print();\" class=bigbutton><i class=\"fa fa-print\"></i> ".pcrtlang("Print")."</button>";
echo "</div>";



echo "<div class=printpage><table width=100%><tr><td valign=top><img src=$printablelogo></td><td>";

echo "<br><center><font class=claimticketheader><i class=\"fa fa-wrench\"></i>&nbsp;".pcrtlang("Repair Report")."&nbsp;</font>";


echo "<font class=text12b><br><br>";
echo "$storeinfoarray[storename]</font>";
echo "<br><font class=text12>".pcrtlang("Phone").": $storeinfoarray[storephone]</font></center><br>";

echo "</td></tr></table><br>";
echo "<table width=100%><tr><td width=67% valign=top><table class=printables><tr><td><font class=text12>".pcrtlang("Customer Name").":</font></td><td><font class=text12b>$pcname</font></td></tr>";
if("$pccompany" != "") {
echo "<tr><td><font class=text12>".pcrtlang("Company").":</font></td><td><font class=text12b>$pccompany</font></td></tr>";
}
echo "<tr><td><font class=text12>".pcrtlang("Asset/Device ID").":</font></td><td><font class=textred16b>$pcid</font></td></tr><tr><td><font class=text12>".pcrtlang("Work Order ID").":</td><td><font class=text12b>$woid</font></td></tr>";

if($pcaddress != "") {
$pcaddressbr = nl2br($pcaddress);
echo "<tr><td><i class=\"fa fa-map-marker fa-lg fa-fw floatright\"></i></td><td><font class=text12b>$pcaddressbr</font></td></tr>";
if($pcaddress2 != "") {
echo "<tr><td></td><td><font class=text12b>$pcaddress2</font></td></tr>";
}
if(($pccity != "") && ($pcstate != "") && ($pczip != "")) {
echo "<tr><td></td><td><font class=text12b>$pccity, $pcstate $pczip</font></td></tr>";
}
}

echo "<tr><td colspan=2>&nbsp;</td></tr>";

if($pcphone != "") {
echo "<tr><td><i class=\"fa fa-phone fa-lg fa-fw floatright\"></i></td><td><font class=text12b>$pcphone</font></td></tr>";
}

if($pccellphone != "") {
echo "<tr><td><i class=\"fa fa-mobile fa-lg fa-fw floatright\"></i></td><td><font class=text12b>$pccellphone</font></td></tr>";
}

if($pcworkphone != "") {
echo "<tr><td><i class=\"fa fa-briefcase fa-lg fa-fw floatright\"></i></td><td><font class=text12b>$pcworkphone</font></td></tr>";
}


if($pcemail != "") {
echo "<tr><td><i class=\"fa fa-envelope fa-lg fa-fw floatright\"></i></td><td><font class=text12b>$pcemail</font></td></tr>";
}

echo "<tr><td colspan=2>&nbsp;</td></tr>";


echo "<tr><td><font class=text12>".pcrtlang("Make/Model").":</font></td><td><font class=text12b>$pcmake</font></td></tr>";

$allassetinfofields = array();

$rs_allfindassets = "SELECT * FROM mainassetinfofields WHERE showonrepair = '1'";
$rs_result2all = mysqli_query($rs_connect, $rs_allfindassets);
while ($rs_result_q2all = mysqli_fetch_object($rs_result2all)) {
$mainassetfieldid = "$rs_result_q2all->mainassetfieldid";
$mainassetfieldname = "$rs_result_q2all->mainassetfieldname";
$allassetinfofields[$mainassetfieldid] = "$mainassetfieldname";
}

foreach($pcextra as $key => $val) {
if(array_key_exists("$key", $allassetinfofields)) {
echo "<tr><td><font class=text12>$allassetinfofields[$key]: </font></td><td><font class=text12b>$val</font></td></tr>";
}
}

echo "<tr><td><font class=text12>".pcrtlang("Customer Assets").":</font></td><td><font class=text12b>";
foreach($custassetsindb as $key => $val) {
echo pcrtlang("$val")." :";
}


echo "</font></td></tr></table><br>";


echo "<br><br><font class=text12b>".pcrtlang("Problem/Task").":</font><br><blockquote><font class=text12>$probdesc</font><br><br>";


foreach($theprobsindb as $key => $val) {
if(in_array("$val",$comprobarrayv)) {
echo "<font class=text12>&bull; $val</font><br>";
}
}

echo "</blockquote>";




echo "<br>";



echo "</td><td width=25>&nbsp;</td><td width=33% valign=top>";


$rs_findpic = "SELECT * FROM assetphotos WHERE pcid = '$pcid' AND highlight='1'";
$rs_resultpic2 = mysqli_query($rs_connect, $rs_findpic);

if (mysqli_num_rows($rs_resultpic2) != "0") {
$rs_resultpic_q2 = mysqli_fetch_object($rs_resultpic2);
$pcphoto = "$rs_resultpic_q2->photofilename";
$assetphotoid = "$rs_resultpic_q2->assetphotoid";
echo "<img src=wo.php?func=getpcimage&photoid=$assetphotoid border=1 width=256><br><br>";
}





$rs_foundscan = "SELECT * FROM pc_scan WHERE woid = '$woid' ORDER BY scantime ASC";
$rs_result_fs = mysqli_query($rs_connect, $rs_foundscan);

if (mysqli_num_rows($rs_result_fs) > 0) {
echo "<font class=text12b>".pcrtlang("Scans Performed").":</font><br><table>";
}

while($rs_result_fsr = mysqli_fetch_object($rs_result_fs)) {
$scanid = "$rs_result_fsr->scanid";
$scantype = "$rs_result_fsr->scantype";
$scannum = "$rs_result_fsr->scannum";
$customprogword = "$rs_result_fsr->customprogword";
$customprintinfo = "$rs_result_fsr->customprintinfo";
$customscantype = "$rs_result_fsr->customscantype";

if ($scantype != "0") {
$rs_foundscan_name = "SELECT * FROM pc_scans WHERE scanid = '$scantype'";
$rs_result_fs_name = mysqli_query($rs_connect, $rs_foundscan_name);
$rs_result_fsr_name = mysqli_fetch_object($rs_result_fs_name);
$scantypeid = "$rs_result_fsr_name->scanid";
$scantypeprog = "$rs_result_fsr_name->progword";
$scantypeicon = "$rs_result_fsr_name->progicon";
$myscantype = "$rs_result_fsr_name->scantype";
} else {
$myscantype = $customscantype;
}

if (($myscantype == 0) || ($customscantype == 0)) {
echo "<tr><td>";

echo "<i class=\"fa fa-bug\"></i>";


echo "</td><td>";
if($customprogword != "") {
echo "$customprogword";
} else {
echo "$scantypeprog";
}


if ($scannum != 0) {
echo " - $scannum ".pcrtlang("item(s) found")."";
} else {
echo " - ".pcrtlang("no items found")."";
}


echo "</td></tr>";

}
}

echo "</table><br>";



echo "</td></tr>";

echo "</table></td></tr></table>";

$switch1 = 0;
$switch2 = 0;
$switch3 = 0;




##################

echo "<font class=text12b>&nbsp;".pcrtlang("Notes for Customer").":</font><br><br><br>";

$rs_findnotes = "SELECT * FROM wonotes WHERE woid = '$woid' AND notetype = '0' ORDER BY notetime ASC";
$rs_result_n = mysqli_query($rs_connect, $rs_findnotes);
$bubblego = "first";
$usercomm = array();
while($rs_result_qn = mysqli_fetch_object($rs_result_n)) {
$thenote = nl2br("$rs_result_qn->thenote");
$noteuser = "$rs_result_qn->noteuser";
$notetype = "$rs_result_qn->notetype";
$noteid = "$rs_result_qn->noteid";
$notetime2 = "$rs_result_qn->notetime";
$notetime =  date('g:ia n-j-Y', strtotime($notetime2));

if(array_key_exists("$noteuser",$usercomm)) {
$bubblego = $usercomm[$noteuser];
} else {
if($bubblego == "first") {
$bubblego = "left";
} elseif ($prevuser == "noteuser") {
$bubblego = "$thedir";
} else {
$bubblego = "$thediropp";
}
}

if ("$bubblego" == "left") {
echo "<table style=\"width:100%\"><tr><td style=\"width:125px;text-align:center;vertical-align:top;\">";
echo "<br><font class=text12b>$noteuser</font>";
echo "</td><td>";
echo "<div class=\"wonote left\"><font class=text12>$thenote</font></div>";
echo "</td></tr></table>";
$prevuser = "$noteuser";
$thedir = "left";
$thediropp = "right";
} else {
echo "<table style=\"width:100%\"><tr><td>";
echo "<div class=\"wonote right\"><font class=text12>$thenote</font></div></td>";
echo "<td style=\"width:100px;text-align:center;align:top\">";
echo "<font class=text12b>$noteuser</font>";
echo "</td></tr></table>";
$prevuser = "$noteuser";
$thedir = "right";
$thediropp = "left";
}

$usercomm[$noteuser] = "$thedir";

}



################ Checks

$rs_sq = "SELECT * FROM mainassettypes WHERE mainassettypeid = '$mainassettypeidindb'";
$rs_result1 = mysqli_query($rs_connect, $rs_sq);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$mainassetchecksindb = serializedarraytest("$rs_result_q1->mainassetchecks");


$wochecks = serializedarraytest("$wochecks");

if((count($mainassetchecksindb) > 0) && (count($wochecks))) {


echo "<table class=standard>";

echo "<tr><th colspan=2>".pcrtlang("Pre Checks")."</th><th colspan=2>".pcrtlang("Post Checks")."</th></tr>";

$rs_checks = "SELECT * FROM checks";
$rs_checksq = mysqli_query($rs_connect, $rs_checks);
while($rs_result_cq = mysqli_fetch_object($rs_checksq)) {
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

if(($precheck == 2) || ($precheck == 3) || ($postcheck == 2) || ($postcheck == 3)) {
echo "<tr><td>";
if(($precheck == 2) || ($precheck == 3)) {
echo "$checkname";
}
echo "</td><td>";
if($precheck == 2) {
echo "<i class=\"fa fa-check fa-lg colormegreen\"></i> ".pcrtlang("Check Passed");
} elseif($precheck == 3) {
echo "<i class=\"fa fa-warning fa-lg colormered\"></i> ".pcrtlang("Check Failed");
} else {
}


echo "</td><td>";
if(($postcheck == 2) || ($postcheck == 3)) {
echo "$checkname";
}
echo "</td><td>";

if($postcheck == 2) {
echo "<i class=\"fa fa-check fa-lg colormegreen\"></i> ".pcrtlang("Check Passed");
} elseif($postcheck == 3) {
echo "<i class=\"fa fa-warning fa-lg colormered\"></i> ".pcrtlang("Check Failed");
} else {

}

echo "</td></tr>";
}
}


}


echo "</table>";
echo "<br>";

}





################ actions






echo "<table width=100%>";

echo "<tr><td width=100%>";
$rs_foundscan5 = "SELECT * FROM pc_scan WHERE woid = '$woid'";
$rs_result_fs5 = mysqli_query($rs_connect, $rs_foundscan5);



while($rs_result_fsr5 = mysqli_fetch_object($rs_result_fs5)) {
$scanid5 = "$rs_result_fsr5->scanid";
$scantype5 = "$rs_result_fsr5->scantype";
$scannum5 = "$rs_result_fsr5->scannum";
$scantime5 = "$rs_result_fsr5->scantime";
$customprogword5 = "$rs_result_fsr5->customprogword";
$customprintinfo5 = "$rs_result_fsr5->customprintinfo";
$customscantype5 = "$rs_result_fsr5->customscantype";

if ($scantype5 != "0") {
$rs_foundscan_name5 = "SELECT * FROM pc_scans WHERE scanid = '$scantype5'";
$rs_result_fs_name5 = mysqli_query($rs_connect, $rs_foundscan_name5);
$rs_result_fsr_name5 = mysqli_fetch_object($rs_result_fs_name5);
$scantypeid5 = "$rs_result_fsr_name5->scanid";
$scantypeprog5 = "$rs_result_fsr_name5->progword";
$scantypeicon5 = "$rs_result_fsr_name5->progicon";
$printinfo5 = "$rs_result_fsr_name5->printinfo";
$myscantype5 = "$rs_result_fsr_name5->scantype";
} else {
$myscantype5 = $customscantype5;
}

if (($myscantype5 == 1) || ($customscantype5 == 1)) {

if ($switch1 == 0) {
echo "<br><br>";
echo "<font class=scanheading>&nbsp;&nbsp;<i class=\"fa fa-cog\"></i> ".pcrtlang("Actions")."&nbsp;&nbsp;</font><br><br>";
}

$switch1 = 1;


echo "<i class=\"fa fa-cog\"></i> ";

echo "<font class=text12b>";
if($customprogword5 != "") {
echo "$customprogword5";
} else {
echo "$scantypeprog5";
}


echo "</font><br>";
echo "<font class=text12>";

if($customprintinfo5 != "") {
echo "$customprintinfo5";
} else {
echo "$printinfo5";
}

echo "</font><br><br>";

}
}

echo "</td></tr></table>";
#######################
################ installed
echo "<table width=100%>";
echo "<tr><td width=100%>";
$rs_foundscan6 = "SELECT * FROM pc_scan WHERE woid = '$woid'";
$rs_result_fs6 = mysqli_query($rs_connect, $rs_foundscan6);



while($rs_result_fsr6 = mysqli_fetch_object($rs_result_fs6)) {
$scanid6 = "$rs_result_fsr6->scanid";
$scantype6 = "$rs_result_fsr6->scantype";
$scannum6 = "$rs_result_fsr6->scannum";
$scantime6 = "$rs_result_fsr6->scantime";
$customprogword6 = "$rs_result_fsr6->customprogword";
$customprintinfo6 = "$rs_result_fsr6->customprintinfo";
$customscantype6 = "$rs_result_fsr6->customscantype";

if ($scantype6 != "0") {
$rs_foundscan_name6 = "SELECT * FROM pc_scans WHERE scanid = '$scantype6'";
$rs_result_fs_name6 = mysqli_query($rs_connect, $rs_foundscan_name6);
$rs_result_fsr_name6 = mysqli_fetch_object($rs_result_fs_name6);
$scantypeid6 = "$rs_result_fsr_name6->scanid";
$scantypeprog6 = "$rs_result_fsr_name6->progword";
$scantypeicon6 = "$rs_result_fsr_name6->progicon";
$printinfo6 = "$rs_result_fsr_name6->printinfo";
$myscantype6 = "$rs_result_fsr_name6->scantype";
} else {
$myscantype6 = $customscantype6;
}

if (($myscantype6 == 2) || ($customscantype6 == 2)) {

if ($switch2 == 0) {
echo "<br><br>";
echo "<font class=scanheading>&nbsp;&nbsp;<i class=\"fa fa-download\"></i> ".pcrtlang("Installs")."&nbsp;&nbsp;</font><br><br>";
}

$switch2 = 1;


echo "<i class=\"fa fa-download fa-lg\"></i> ";


echo "<font class=text12b>";

if($customprogword6 != "") {
echo "$customprogword6";
} else {
echo "$scantypeprog6";
}

echo "</font><br>";
echo "<font class=text12>";

if($customprintinfo6 != "") {
echo "$customprintinfo6";
} else {
echo "$printinfo6";
}


echo "</font><br><br>";

}
}

echo "</td></tr></table>";
#######################
################ notes
echo "<table width=100%>";
echo "<tr><td width=100%>";
$rs_foundscan2 = "SELECT * FROM pc_scan WHERE woid = '$woid'";
$rs_result_fs2 = mysqli_query($rs_connect, $rs_foundscan2);



while($rs_result_fsr2 = mysqli_fetch_object($rs_result_fs2)) {
$scanid2 = "$rs_result_fsr2->scanid";
$scantype2 = "$rs_result_fsr2->scantype";
$scannum2 = "$rs_result_fsr2->scannum";
$scantime2 = "$rs_result_fsr2->scantime";
$customprogword2 = "$rs_result_fsr2->customprogword";
$customprintinfo2 = "$rs_result_fsr2->customprintinfo";
$customscantype2 = "$rs_result_fsr2->customscantype";

if ($scantype2 != "0") {
$rs_foundscan_name2 = "SELECT * FROM pc_scans WHERE scanid = '$scantype2'";
$rs_result_fs_name2 = mysqli_query($rs_connect, $rs_foundscan_name2);
$rs_result_fsr_name2 = mysqli_fetch_object($rs_result_fs_name2);
$scantypeid2 = "$rs_result_fsr_name2->scanid";
$scantypeprog2 = "$rs_result_fsr_name2->progword";
$scantypeicon2 = "$rs_result_fsr_name2->progicon";
$printinfo2 = "$rs_result_fsr_name2->printinfo";
$myscantype2 = "$rs_result_fsr_name2->scantype";
} else {
$myscantype2 = $customscantype2;
}

if (($myscantype2 == 3) || ($customscantype2 == 3)) {

if ($switch3 == 0) {
echo "<br><br>";
echo "<font class=scanheading>&nbsp;&nbsp;<i class=\"fa fa-sticky-note\"></i> ".pcrtlang("Notes &amp; Recommendations")."&nbsp;&nbsp;</font><br><br>";
}

$switch3 = 1;

echo "<i class=\"fa fa-sticky-note\"></i> ";


echo "<font class=text12b>";

if($customprogword2 != "") {
echo "$customprogword2";
} else {
echo "$scantypeprog2";
}

echo "</font><br>";
echo "<font class=text12>";

if($customprintinfo2 != "") {
echo "$customprintinfo2";
} else {
echo "$printinfo2";
}


echo "</font><br><br>";

}
}

echo "</td></tr></table>";


}
}

echo nl2br($storeinfoarray['repairsheetfooter']);




echo "</div><br><br>";
                                                                                                                                               
}




function getpcimage() {

require("deps.php");
require("common.php");

$photoid = $_REQUEST['photoid'];

$rs_findfileid = "SELECT photofilename FROM assetphotos WHERE assetphotoid = '$photoid'";
$rs_resultfid = mysqli_query($rs_connect, $rs_findfileid);
$rs_result_qfid = mysqli_fetch_object($rs_resultfid);
$photo_filename = "$rs_result_qfid->photofilename";


header("Content-Type: image/jpg; Content-Disposition: inline; filename=\"$photo_filename\"");
readfile("../pcphotos/$photo_filename");

}




switch($func) {
                                                                                                    
    default:
    nothing();
    break;
                                
    case "browseworkorders":
    browseworkorders();
    break;

    case "printrepairreport":
    printrepairreport();
    break;

    case "getpcimage":
    getpcimage();
    break;


}

