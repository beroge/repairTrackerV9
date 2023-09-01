<?php
                                                                                                    
/***************************************************************************
 *   copyright            : (C) 2018 PCRepairTracker.com
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




function repairlookup() {
require("deps.php");
require("headerstatus.php");
require("common.php");

$rs_connect = mysqli_connect($dbhost, $dbuname, $dbpass, $dbname) or die("Couldn't connect the db");
mysqli_query($rs_connect, "SET NAMES utf8");
mysqli_query($rs_connect, "SET SESSION sql_mode=''");

echo "<br><div class=box><font class=text16b>".pcrtlang("Check Repair Status")."</font><br><br>";

echo "<form action=index.php?func=showstatus method=post>";
echo "<table>";
echo "<tr><td><font class=text14>".pcrtlang("Work Order ID Number").":</font></td></tr><tr><td><input size=18 class=textbox type=number name=woid></td></tr>";
echo "<tr><td><font class=text14>".pcrtlang("Last 4 Digits of Phone Number").":</font></td></tr><tr><td><input size=18 class=textbox type=number name=phone></td></tr>";

echo "<tr><td><input class=button type=submit value=\"".pcrtlang("Check Repair Status")."\"><form></td></tr>";
echo "</table></div>";

require_once("footerstatus.php");
                                                                                                    
}

function showstatus() {
require("deps.php");
require("headerstatus.php");
require("common.php");


$rs_connect = mysqli_connect($dbhost, $dbuname, $dbpass, $dbname) or die("Couldn't connect the db");
mysqli_query($rs_connect, "SET NAMES utf8");
mysqli_query($rs_connect, "SET SESSION sql_mode=''");



if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}



echo "<div class=\"boxwidelight\">";


$woid = pv($_REQUEST['woid']);
$phone = pv(str_replace(' ', '', $_REQUEST['phone']));

$woidnumer = "<br><br>".pcrtlang("Please back and enter the correct Work Order ID");

if (!is_numeric($woid)) {
die("$woidnumer");
}

$phonenumer = "<br><br>".pcrtlang("Please back and enter the correct last 4 digits of your phone number");

if (!is_numeric($phone)) {
die("$phonenumer");
}



$phonedigits = strlen($phone);

$phoneerror = "<br><br>".pcrtlang("Please go back and enter the last 4 digits of your phone number");

if ($phonedigits != "4") {
die("$phoneerror");
}


$rs_findpcid = "SELECT * FROM pc_wo WHERE woid = '$woid'";
$rs_findpcid2 = @mysqli_query($rs_connect, $rs_findpcid);
$rs_findpcid3 = mysqli_fetch_object($rs_findpcid2);
$pcid = "$rs_findpcid3->pcid";
$pcstatus = "$rs_findpcid3->pcstatus";


$rs_qc = "SELECT * FROM boxstyles WHERE statusid = '$pcstatus'";
$rs_result1 = mysqli_query($rs_connect, $rs_qc);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$boxtitle = "$rs_result_q1->boxtitle";


$space1 = substr("$phone", 0, 1)." ".substr("$phone", 1, 3);
$space2	= substr("$phone", 0, 2)." ".substr("$phone", 2, 4);
$space3	= substr("$phone", 0, 3)." ".substr("$phone", 3, 1);


$rs_findowner = "SELECT * FROM pc_owner WHERE pcid = '$pcid' AND (pcphone LIKE '%$phone' OR pcworkphone LIKE '%$phone' OR pccellphone LIKE '%$phone' OR pcphone LIKE '%$space1' OR pcworkphone LIKE '%$space1' OR pccellphone LIKE '%$space1' OR pcphone LIKE '%$space2' OR pcworkphone LIKE '%$space2' OR pccellphone LIKE '%$space2' OR pcphone LIKE '%$space3' OR pcworkphone LIKE '%$space3' OR pccellphone LIKE '%$space3')";
$rs_findowner2 = @mysqli_query($rs_connect, $rs_findowner);

$rowcount = mysqli_num_rows($rs_findowner2);
if ($rowcount != "1") {
$rowcountt = "<br><br>".pcrtlang("Please go back and check that your work order number and last 4 digits of your phone are correct");
die("$rowcountt");
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
$theprobsindb2 = "$rs_result_q->commonproblems";

if($custassetsindb2 == "") {
$custassetsindb = array();
} else {
$custassetsindb = unserialize($custassetsindb2);
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
$pcextra = unserialize($pcextra2);

echo "<table width=100%><tr><td width=60% valign=top><font class=text12>".pcrtlang("Customer Name").":</font> <font class=text12b>$pcname</font><br><font class=text12>".pcrtlang("Computer ID").":</font> <font class=textred12b>$pcid</font><br><font class=text20b>".pcrtlang("Status").":</font> <font style=\"color:#0000ff;\" class=text20b>$boxtitle</font>";

if($pcaddress != "") {
$pcaddressbr = nl2br($pcaddress);
echo "<table cellpadding=0 cellspacing=0 border=0><tr><td><font class=text12>".pcrtlang("Address").":&nbsp;&nbsp;</font></td><td><font class=text12b>$pcaddressbr</font></td></tr>";
if($pcaddress2 != "") {
echo "<tr><td></td><td><font class=text12b>$pcaddress2</font></td></tr>";
}
if(($pccity != "") && ($pcstate != "") && ($pczip != "")) {
echo "<tr><td></td><td><font class=text12b>$pccity, $pcstate $pczip</font></td></tr>";
}
echo "</table>";
}

echo "<br><table>";
echo "<tr><td><font class=text12>".pcrtlang("Customer Phone").":</font></td><td><font class=text12b> $pcphone</font></td></tr>";

if($pccellphone != "") {
echo "<tr><td><font class=text12>".pcrtlang("Cell Phone").":</font></td><td><font class=text12b>$pccellphone</font></td></tr>";
}

if($pcworkphone != "") {
echo "<tr><td><font class=text12>".pcrtlang("Work Phone").":</font></td><td><font class=text12b>$pcworkphone</font></td></tr>";
}


if($pcemail != "") {
echo "<tr><td><font class=text12>".pcrtlang("Email").":</font></td><td><font class=text12b>$pcemail</font></td></tr>";
}

echo "<tr><td colspan=2>&nbsp;</td></tr>";

echo "<tr><td><font class=text12>".pcrtlang("Make/Model").":</font></td><td><font class=text12b>$pcmake</font></td></tr>";

echo "<tr><td colspan=2>";
$rs_allfindassets = "SELECT * FROM mainassetinfofields WHERE showonrepair = '1'";
$rs_result2all = mysqli_query($rs_connect, $rs_allfindassets);
while ($rs_result_q2all = mysqli_fetch_object($rs_result2all)) {
$mainassetfieldid = "$rs_result_q2all->mainassetfieldid";
$mainassetfieldname = "$rs_result_q2all->mainassetfieldname";
$allassetinfofields[$mainassetfieldid] = "$mainassetfieldname";
}

if(!is_array($allassetinfofields)) {
$allassetinfofields = array();
}


foreach($pcextra as $key => $val) {
if(array_key_exists("$key", $allassetinfofields)) {
echo "<font class=text10>$allassetinfofields[$key]: </font><font class=text10b>$val</font><br>";
}
}
echo "</td></tr>";



echo "<tr><td><font class=text12>".pcrtlang("Customer Assets").":</font></td><td><font class=text12>";
foreach($custassetsindb as $key => $val) {
echo "$val :";
}


echo "</font></td></tr></table>";


echo "<br><br><font class=text12b>".pcrtlang("Problem as Described by Customer").":</font><br><blockquote><font class=text12>$probdesc</font><br><br>";


foreach($theprobsindb as $key => $val) {
echo "<font class=text12b>&bull;</font><font class=text12> $val</font><br>";
}


echo "</blockquote>";




echo "<br>";



echo "</td><td width=5%>&nbsp;</td><td width=35% valign=top>";

if (($showscans == "yes") || ($showscans == "yes-expanded")) {
$rs_foundscan = "SELECT * FROM pc_scan WHERE woid = '$woid' ORDER BY scantime ASC";
$rs_result_fs = mysqli_query($rs_connect, $rs_foundscan);

if (mysqli_num_rows($rs_result_fs) > 0) {
echo "<div class=box><font class=text14b>".pcrtlang("Scans Performed").":</font><br><table>";
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
$myscantype = "$rs_result_fsr_name->scantype";
} else {
$myscantype = $customscantype;
}

if (($myscantype == 0) || ($customscantype == 0)) {
echo "<tr><td>";

echo "</td><td><font class=text12>";
if($customprogword != "") {
echo "$customprogword";
} else {
echo "$scantypeprog";
}


echo "</font>";
if ($scannum != 0) {
echo " - <font class=textred12b>$scannum ".pcrtlang("item(s) found")."</font>";
} else {
echo "<font class=textblue12b> - ".pcrtlang("no items found")."</font>";
}

}

#hereVVV
}

echo "</td></tr>";


}

echo "</table><br>";



echo "</td></tr>";

echo "</table><br>";









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
echo "<table style=\"width:95%\"><tr><td style=\"width:125px;text-align:center;vertical-align:top;\">";
echo "<br><font class=text12b>$noteuser</font>";
echo "</td><td>";
echo "<div class=\"wonote left\"><font class=text12>$thenote</font></div>";
echo "</td></tr></table>";
$prevuser = "$noteuser";
$thedir = "left";
$thediropp = "right";
} else {
echo "<table style=\"width:95%\"><tr><td>";
echo "<div class=\"wonote right\"><font class=text12>$thenote</font></div></td>";
echo "<td style=\"width:100px;text-align:center;align:top\">";
echo "<br><font class=text12b>$noteuser</font>";
echo "</td></tr></table>";
$prevuser = "$noteuser";
$thedir = "right";
$thediropp = "left";
}

$usercomm[$noteuser] = "$thedir";

}







$switch1 = 0;
$switch2 = 0;
$switch3 = 0;







################ actions

if (($showactions == "yes") || ($showactions =="yes-expanded")) {

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
echo "<div class=boxwide><font class=text16bu>".pcrtlang("Actions")." </font><br><br>";
}

$switch1 = 1;



echo "<font class=text12b>";
if($customprogword5 != "") {
echo "$customprogword5";
} else {
echo "$scantypeprog5";
}


echo "</font><br>";
echo "<font class=text12>";

if($showactions == "yes-expanded") {
if($customprintinfo5 != "") {
echo "$customprintinfo5";
} else {
echo "$printinfo5";
}
}

echo "</font><br><br>";

}
}

echo "</td></tr></table>";
}

#######################
################ installed

if (($showinstalls == "yes") || ($showinstalls =="yes-expanded")) {

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
echo "<br><div class=boxwide><font class=text16bu>".pcrtlang("Installed")." </font><br><br>";
}

$switch2 = 1;


echo "<font class=text12b>";

if($customprogword6 != "") {
echo "$customprogword6";
} else {
echo "$scantypeprog6";
}

echo "</font><br>";
echo "<font class=text12>";

if ($showinstalls == "yes-expanded") {
if($customprintinfo6 != "") {
echo "$customprintinfo6";
} else {
echo "$printinfo6";
}
}

echo "</font><br><br>";

}
}

echo "</td></tr></table>";

}
#######################
################ notes

if (($shownotes == "yes") || ($shownotes =="yes-expanded")) {
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
echo "<br><div class=boxwide><font class=text16bu>".pcrtlang("Notes")."</font><br><br>";
}

$switch3 = 1;


echo "<font class=text12b>";

if($customprogword2 != "") {
echo "$customprogword2";
} else {
echo "$scantypeprog2";
}

echo "</font><br>";
echo "<font class=text12>";

if ($shownotes == "yes-expanded") {
if($customprintinfo2 != "") {
echo "$customprintinfo2";
} else {
echo "$printinfo2";
}
}

echo "</font><br><br>";

}
}

echo "</td></tr></table></div></div>";
}
#######################


}
}

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}

$currentdatetime = date('Y-m-d H:i:s');

$logactionsql = "INSERT INTO userlog (actionid,thedatetime,refid,reftype,loggeduser) VALUES ('23','$currentdatetime','$woid','woid','guest')";
@mysqli_query($rs_connect, $logactionsql);

                                                                                                                                               
require("footerstatus.php");
                                                                                                                                               
}


##################################################################################################

switch($func) {
                                                                                                    
    default:
    repairlookup();
    break;
                                
    case "showstatus":
    showstatus();
    break;

}

?>
