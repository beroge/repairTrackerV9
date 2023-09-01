<?php

/***************************************************************************
 *   copyright            : (C) 2010 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/

if (array_key_exists('func',$_REQUEST)) {
$func = "$_REQUEST[func]";
} else {
$func = "";
}

                                                                                                    
function quicklabor() {
require("header.php");
require_once("common.php");
require("deps.php");

perm_boot("2");




mysqli_query($rs_connect, "SET CHARACTER SET utf8");

start_blue_box(pcrtlang("Quick Labor"));
echo "<table>";
$rs_ql = "SELECT * FROM quicklabor ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$qlid = "$rs_result_q1->quickid";
$labordesc = "$rs_result_q1->labordesc";
$laborprice = "$rs_result_q1->laborprice";
$theorder = "$rs_result_q1->theorder";

$primero = mb_substr("$labordesc", 0, 1);

if("$primero" != "-") {
echo "<tr><td valign=top><form action=admin.php?func=quicklaborsave method=post><input type=hidden name=quickid value=$qlid>";
echo "<a href=admin.php?func=reorderquicklabor&qlid=$qlid&dir=up&theorder=$theorder class=imagelink><img src=images/up.png border=0></a>";
echo " <a href=admin.php?func=reorderquicklabor&qlid=$qlid&dir=down&theorder=$theorder class=imagelink><img src=images/down.png border=0></a>";
echo "</td>";
echo "<td><input type=text name=labordesc size=30 value=\"$labordesc\" class=textbox><input type=text name=laborprice size=8 value=\"$laborprice\" class=textbox>";
echo "</td><td valign=top><input type=submit value=\"&laquo;".pcrtlang("Save")."\" class=button></form></td><td valign=top><form action=admin.php?func=quicklabordelete method=post>";
echo "<input type=hidden name=quickid value=$qlid>";
echo "<input type=submit value=\"&laquo;".pcrtlang("Delete")."\" class=button></form>";
} else {
$labordesc2 = mb_substr("$labordesc", 1);
echo "<tr><td valign=top><input type=hidden name=quickid value=$qlid>";
echo "<a href=admin.php?func=reorderquicklabor&qlid=$qlid&dir=up&theorder=$theorder class=imagelink><img src=images/up.png border=0></a>";
echo " <a href=admin.php?func=reorderquicklabor&qlid=$qlid&dir=down&theorder=$theorder class=imagelink><img src=images/down.png border=0></a>";
echo "</td>";
echo "<td><font class=\"quickdivider\">$labordesc2</font>";
echo "</td><td valign=top></td><td valign=top><form action=admin.php?func=quicklabordelete method=post>";
echo "<input type=hidden name=quickid value=$qlid>";
echo "<input type=submit value=\"&laquo;".pcrtlang("Delete")."\" class=button></form>";
}


echo "</td></tr>";

}

echo "</table>";

echo "<font class=text14b>".pcrtlang("Add").":</font><br>";
echo "<form action=admin.php?func=quicklaboradd method=post>";
echo "<input type=text name=labordesc size=30 value=\"\" class=textbox><input type=text name=laborprice size=8 value=\"\" class=textbox class=textbox>";
echo "<input type=submit value=\"&laquo;".pcrtlang("Add")."\" class=ibutton></form>";
echo "<font class=text10i>".pcrtlang("Start Labor Description with a - to create a title spacer.")."</font>";
stop_blue_box();

require_once("footer.php");
                                                                                                    
}


function quicklaborsave() {
require_once("validate.php");

require("deps.php");
require("common.php");

perm_boot("2");

$quickid = $_REQUEST['quickid'];
$labordesc = pv($_REQUEST['labordesc']);
$laborprice = $_REQUEST['laborprice'];



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "UPDATE quicklabor SET labordesc = '$labordesc', laborprice = '$laborprice' WHERE quickid = '$quickid'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=quicklabor");


}

function quicklabordelete() {
require_once("validate.php");

require("deps.php");
require("common.php");

$quickid = $_REQUEST['quickid'];

perm_boot("2");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_find_ql = "SELECT * FROM quicklabor WHERE quickid = '$quickid'";
$rs_find_qlq = mysqli_query($rs_connect, $rs_find_ql);

$totresult = mysqli_num_rows($rs_find_qlq);

if ($totresult == "1") {
$rs_insert_scan = "DELETE FROM quicklabor WHERE quickid = '$quickid'";
@mysqli_query($rs_connect, $rs_insert_scan);
header("Location: admin.php?func=quicklabor");
} else {
die("Protection Error");
}

}



function quicklaboradd() {
require_once("validate.php");

require("deps.php");
require("common.php");

perm_boot("2");

$labordesc = pv($_REQUEST['labordesc']);
$laborprice = $_REQUEST['laborprice'];



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "INSERT INTO quicklabor (labordesc,laborprice) VALUES ('$labordesc','$laborprice')";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=quicklabor");


}



function showscans() {

$scantype = $_REQUEST['scantype'];

require("header.php");
require_once("common.php");
require("deps.php");

perm_boot("1");



mysqli_query($rs_connect, "SET NAMES 'utf8'");

if ($scantype == "0") {
$boxtitle = pcrtlang("Scans");
} elseif ($scantype == "1") {
$boxtitle = pcrtlang("Actions");
} elseif ($scantype == "2") {
$boxtitle = pcrtlang("Installs");
} elseif ($scantype == "3") {
$boxtitle = pcrtlang("Notes &amp; Recommendations");
} else {
$boxtitle = "-";
}


start_blue_box("$boxtitle");


$folderperms = mb_substr(sprintf('%o', fileperms('images/scans')), -3);

if($folderperms < "766") {
echo "<font class=textred12>".pcrtlang("It appears your repair/images/scans folder might not be writeable. You may not be able to upload new icons.")." $folderperms</font>";
}

echo "<table width=100%>";

echo "<tr><td width=30%><font class=text14b>".pcrtlang("Name")."</font></td><td width=10%><font class=text14b>".pcrtlang("Active?")."</font></td><td width=20%></td><td width=20%><font class=text14b>".pcrtlang("Total Recorded")."</font></td><td width=20%><font class=text14b>".pcrtlang("Re-order")."</font></td></tr>";

$rs_sq = "SELECT * FROM pc_scans WHERE scantype='$scantype' ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_sq);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$scanid = "$rs_result_q1->scanid";
$progname = "$rs_result_q1->progname";
$progword = "$rs_result_q1->progword";
$progicon = "$rs_result_q1->progicon";
$hasinfo = "$rs_result_q1->hasinfo";
$printinfo = "$rs_result_q1->printinfo";
$theorder = "$rs_result_q1->theorder";
$scantype = "$rs_result_q1->scantype";
$active = "$rs_result_q1->active";

$checkscans =  "SELECT * FROM pc_scan WHERE scantype='$scanid'";
$rs_result_chk = mysqli_query($rs_connect, $checkscans);
$totalscans = mysqli_num_rows($rs_result_chk);

if ($active == 1) {
echo "<tr><td>";
if ($progicon != "") {
echo "<img src=images/scans/$progicon align=absmiddle>";
}
echo "<font class=text12b> $progname </font></td><td>&nbsp;</td><td><a href=admin.php?func=editscan&scanid=$scanid>".pcrtlang("edit")."</a><font class=text12b> | </font>";
if ($totalscans == "0") {
echo "<a href=admin.php?func=deletescan&scanid=$scanid&scantype=$scantype>".pcrtlang("delete")."</a><font class=text12b> | </font>";
}

if ($progicon != "") {
echo "<a href=admin.php?func=scanpic&scanid=$scanid&existing=yes&progicon=$progicon&scantype=$scantype>".pcrtlang("change icon")."</a>";
} else {
echo "<a href=admin.php?func=scanpic&scanid=$scanid&existing=no&progicon=$progicon&scantype=$scantype>".pcrtlang("add icon")."</a>";
}
echo "</td><td align=right><font class=text12>$totalscans</font></td><td>";

echo "&nbsp;&nbsp;<a href=admin.php?func=reorderscan&scanid=$scanid&dir=up&scantype=$scantype&theorder=$theorder class=imagelink><img src=images/up.png border=0></a>";
echo " <a href=admin.php?func=reorderscan&scanid=$scanid&dir=down&scantype=$scantype&theorder=$theorder class=imagelink><img src=images/down.png border=0></a><br>";
} else {
echo "<tr><td>";
if ($progicon != "") {
echo "<img src=images/scans/$progicon align=absmiddle>"; 
}

echo " <font class=textgray12b>$progname</font></td><td><font class=textgray12b>".pcrtlang("disabled")."</font></td><td>";
echo "<a href=admin.php?func=editscan&scanid=$scanid>".pcrtlang("edit")."</a>";

if ($totalscans == "0") {
echo "<font class=text12b> | </font><a href=admin.php?func=deletescan&scanid=$scanid&scantype=$scantype>".pcrtlang("delete")."</a>";
}


echo "</td><td align=right><font class=text12>$totalscans</font></td><td>";
$up = $theorder + 1;
$down = $theorder - 1;
echo "&nbsp;&nbsp;<a href=admin.php?func=reorderscan&scanid=$scanid&dir=$up&scantype=$scantype class=imagelink><img src=images/up.png border=0></a>";
echo " <a href=admin.php?func=reorderscan&scanid=$scanid&dir=$down&scantype=$scantype class=imagelink><img src=images/down.png border=0></a><br>";
}
echo "</td></tr>";
}
echo "</table>";
echo "<br><br><a href=admin.php?func=addscan&scantype=$scantype>".pcrtlang("Add new")." $boxtitle</a>";

stop_blue_box();
echo "<br><br>";


require_once("footer.php");



}

function reorderscan() {
require_once("validate.php");

$scanid = $_REQUEST['scanid'];
$dir = $_REQUEST['dir'];
$scantype = $_REQUEST['scantype'];
$theorder = $_REQUEST['theorder'];

require("deps.php");
require_once("common.php");
perm_boot("1");



mysqli_query($rs_connect, "SET NAMES 'utf8'");

if ($dir == "up") {
$rs_sq = "SELECT * FROM pc_scans WHERE scantype='$scantype' AND theorder > '$theorder' ORDER BY theorder ASC LIMIT 1";
} else {
$rs_sq = "SELECT * FROM pc_scans WHERE scantype='$scantype' AND theorder < '$theorder' ORDER BY theorder DESC LIMIT 1";
}

$rs_result1 = mysqli_query($rs_connect, $rs_sq);
$rs_result_q1 = mysqli_fetch_object($rs_result1);

if(mysqli_num_rows($rs_result1) == "0") {
$nextorder = "$theorder";
} else {
$nextorder = "$rs_result_q1->theorder";
}


if ($dir == "up") {
$neworder = $nextorder + 1;
} else {
$neworder = $nextorder -1;
}

$rs_insert_scan = "UPDATE pc_scans SET theorder = '$neworder' WHERE scanid = $scanid";
@mysqli_query($rs_connect, $rs_insert_scan);


$rs_resetorder = "SELECT * FROM pc_scans WHERE scantype='$scantype' ORDER BY theorder ASC";
$rs_resultreset = mysqli_query($rs_connect, $rs_resetorder);
$a = 0;
while($rs_result_r1 = mysqli_fetch_object($rs_resultreset)) {
$scanid = "$rs_result_r1->scanid";
$rs_set_order = "UPDATE pc_scans SET theorder = '$a' WHERE scanid = $scanid";
@mysqli_query($rs_connect, $rs_set_order);
$a = $a + 5;
}



header("Location: admin.php?func=showscans&scantype=$scantype");


}



function editscan() {

$scanid = $_REQUEST['scanid'];

require("header.php");
require_once("common.php");
require("deps.php");

perm_boot("1");

start_blue_box(pcrtlang("Edit Scan"));
echo "<form action=admin.php?func=editscan2 method=post>";
echo "<table>";


mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_sq = "SELECT * FROM pc_scans WHERE scanid='$scanid'";
$rs_result1 = mysqli_query($rs_connect, $rs_sq);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$scanid = "$rs_result_q1->scanid";
$progname2 = "$rs_result_q1->progname";
$progword2 = "$rs_result_q1->progword";
$progicon = "$rs_result_q1->progicon";
$hasinfo = "$rs_result_q1->hasinfo";
$printinfo2 = "$rs_result_q1->printinfo";
$theorder = "$rs_result_q1->theorder";
$scantype = "$rs_result_q1->scantype";
$active = "$rs_result_q1->active";

$printinfo = htmlspecialchars($printinfo2);
$progname = htmlspecialchars($progname2);
$progword = htmlspecialchars($progword2);


echo "<tr><td><font class=text12b>".pcrtlang("Technical Title").":</font></td>";
echo "<td><input type=hidden name=scanid value=$scanid><input type=hidden name=scantype value=$scantype><input type=text size=35 name=progname value=\"$progname\" class=textbox></td></tr>";
echo "<tr><td><font class=text12b>".pcrtlang("Customer Viewable Title").":</font></td>";
echo "<td><input type=text size=35 name=progword value=\"$progword\" class=textbox></td></tr>";
echo "<tr><td><font class=text12b>".pcrtlang("Icon File Name").":</b><br><font class=textgray10i>".pcrtlang("only change here if not<br>using image upload feature")."</font></td>";
echo "<td><input type=text size=25 name=progicon value=\"$progicon\" class=textbox></td></tr>";
if ($scantype != '0') {
echo "<tr><td><font class=text12b>".pcrtlang("Printable Info").":</font></td>";
echo "<td><textarea cols=60 rows=20 name=printinfo class=textbox>$printinfo</textarea></td></tr>";
} else {
echo "<input type=hidden name=printinfo value=\"$printinfo\">";
}
echo "<tr><td><font class=text12b>".pcrtlang("Active").":</font></td>";
echo "<td>";
if ($active == '1') {
echo "<font class=text12b>".pcrtlang("Yes").":</font><input type=radio name=active checked value=on><br>";
echo "<font class=text12b>".pcrtlang("No").":</font><input type=radio name=active value=off>";
} else {
echo "<font class=text12b>".pcrtlang("Yes").":</font><input type=radio name=active value=on><br>";
echo "<font class=text12b>".pcrtlang("No").":</font><input type=radio name=active checked value=off>";
}

echo "</td></tr>";
echo "<tr><td><input type=submit value=\"".pcrtlang("Save")."\" class=ibutton></td><td></td></tr>";

}

echo "</form></table>";

stop_blue_box();
require("footer.php");

}


function editscan2() {
require_once("validate.php");

require("deps.php");
require("common.php");

perm_boot("1");

$scanid = $_REQUEST['scanid'];
$progname = pv($_REQUEST['progname']);
$progword = pv($_REQUEST['progword']);
$progicon = $_REQUEST['progicon'];
$printinfo = pv($_REQUEST['printinfo']);
$active = $_REQUEST['active'];
$scantype = $_REQUEST['scantype'];

if ($active == 'on') {
$active2 = 1;
} else {
$active2 = 0;
}



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "UPDATE pc_scans SET progname = '$progname', progword = '$progword', progicon = '$progicon', printinfo = '$printinfo', active = '$active2' WHERE scanid = '$scanid'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=showscans&scantype=$scantype");

}


function addscan() {

$scantype = $_REQUEST['scantype'];

require("header.php");
require_once("common.php");
require("deps.php");

perm_boot("1");

if ($demo == "yes") {
die("Sorry this feature is disabled in demo mode");
}


if ($scantype == "0") {
$boxtitle = pcrtlang("Scans");
} elseif ($scantype == "1") {
$boxtitle = pcrtlang("Actions");
} elseif ($scantype == "2") {
$boxtitle = pcrtlang("Installs");
} elseif ($scantype == "3") {
$boxtitle = pcrtlang("Notes &amp; Recommendations");
} else {
$boxtitle = "-";
}


start_blue_box("$boxtitle");
echo "<form action=admin.php?func=addscan2 method=post>";
echo "<table>";

echo "<tr><td><font class=text12b>".pcrtlang("Technical Title").":</font></td>";
echo "<td><input type=hidden name=scantype value=$scantype><input type=text size=35 name=progname value=\"\"></td></tr>";
echo "<tr><td><font class=text12b>".pcrtlang("Customer Viewable Title").":</font></td>";
echo "<td><input type=text size=35 name=progword value=\"\"></td></tr>";
echo "<tr><td><font class=text12b>".pcrtlang("Icon File Name").":</font><br><font class=textgray10i>".pcrtlang("only enter here if not<br>using image upload feature")."</font></td>";
echo "<td><input type=text size=25 name=progicon value=\"\"></td></tr>";
if ($scantype != '0') {
echo "<tr><td><font class=text12b>".pcrtlang("Printable Info").":</font></td>";
echo "<td><textarea cols=60 rows=20 name=printinfo></textarea></td></tr>";
} else {
echo "<input type=hidden name=printinfo value=\"\">";
}
echo "<tr><td><font class=text12b>".pcrtlang("Active").":</font></td>";
echo "<td>";
echo "<font class=text12b>".pcrtlang("Yes").":</font><input type=radio name=active checked value=on><br>";
echo "<font class=text12b>".pcrtlang("No").":</font><input type=radio name=active value=off>";

echo "</td></tr>";
echo "<tr><td><input type=submit value=\"".pcrtlang("Save")."\" class=ibutton></td><td></td></tr>";


echo "</form></table>";

stop_blue_box();
require("footer.php");

}


function addscan2() {

require("deps.php");
require("common.php");

perm_boot("1");

$progname = pv($_REQUEST['progname']);
$progword = pv($_REQUEST['progword']);
$progicon = $_REQUEST['progicon'];
$printinfo = pv($_REQUEST['printinfo']);
$active = $_REQUEST['active'];
$scantype = $_REQUEST['scantype'];

require_once("validate.php");

if ($demo == "yes") {
die("Sorry this feature is disabled in demo mode");
}


if ($active == 'on') {
$active2 = 1;
} else {
$active2 = 0;
}

if ($scantype != 0) {
$hasinfo = 1;
}




mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "INSERT INTO pc_scans (progname, progword, progicon, hasinfo, printinfo, active, scantype) VALUES ('$progname','$progword','$progicon','$hasinfo','$printinfo','$active2','$scantype')";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=showscans&scantype=$scantype");

}



function scanpic() {

$scanid = $_REQUEST['scanid'];
$existing = $_REQUEST['existing'];
$progicon = $_REQUEST['progicon'];
$scantype = $_REQUEST['scantype'];

require("header.php");
require("deps.php");

require_once("common.php");
perm_boot("1");

start_blue_box(pcrtlang("Add Icon"));

echo "<form action=admin.php?func=scanpic2 method=post enctype=\"multipart/form-data\">";
echo "<table width=100%>";
echo "<tr><td><font class=text12b>".pcrtlang("Icon to Upload").":</font></td><td><input type=file name=icon><input type=hidden name=scanid value=$scanid><input type=hidden name=existing value=$existing></td></tr>";
echo "<tr><td>&nbsp;</td><td><input type=hidden name=progicon value=\"$progicon\"><input type=hidden name=scantype value=\"$scantype\"><input type=submit value=\"".pcrtlang("Upload Icon")."\" class=button></form></td></tr>";
echo "</table>";

stop_blue_box();

}




function scanpic2() {

$scanid = $_REQUEST['scanid'];
$existing = $_REQUEST['existing'];
$progicon = $_REQUEST['progicon'];
$scantype = $_REQUEST['scantype'];

require_once("validate.php");
require("deps.php");

require_once("common.php");
perm_boot("1");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}


$iconfilename = basename($_FILES['icon']['name']);

function validate_conn($v_filename) {
   return preg_match('/^[a-z0-9]+\.(jpg|png)$/i', $v_filename) ? '1' : '0';
}

if (validate_conn($iconfilename) == '0') {
die(pcrtlang("Please rename the filename so that it contains only underscores, dashes, periods, and alphanumeric charachers<br><br>File must also be a jpg or png"));
}

$uploaddir = "images/scans/";
$uploadfile = $uploaddir . basename($_FILES['icon']['name']);
if (move_uploaded_file($_FILES['icon']['tmp_name'], $uploadfile)) {
} else {
    echo pcrtlang("Unknown file upload error!")."\n";
}


if($existing == "yes") {

if (file_exists("images/scans/$progicon")) { 
unlink("images/scans/$progicon");
}
if (file_exists("images/scans/l_$progicon")) {
unlink("images/scans/l_$progicon");
}
if (file_exists("images/scans/gl_$progicon")) {
unlink("images/scans/gl_$progicon");
}
}

exec("convert -resize '84>x84>' images/scans/$iconfilename images/scans/l_$scanid$iconfilename");
exec("convert -resize '24>x24>' images/scans/$iconfilename images/scans/$scanid$iconfilename");
exec("convert -resize '84>x84>' -modulate 100,0 images/scans/$iconfilename images/scans/glt_$scanid$iconfilename");
exec("convert  -level 0%,100%,2 images/scans/glt_$scanid$iconfilename images/scans/gl_$scanid$iconfilename");

if (!file_exists("images/scans/l_$scanid$iconfilename")) {

  $img = new Imagick(); 
  $img->readImage("images/scans/$iconfilename"); 
  $img->scaleImage(84,84,true);
  $img->writeImage("images/scans/l_$scanid$iconfilename");

  $img->scaleImage(24,24,true);
  $img->writeImage("images/scans/$scanid$iconfilename");

  $img->modulateImage(100, 0, 100);
  $img->levelImage (0, 100, 2); 
  $img->writeImage("images/scans/gl_$scanid$iconfilename"); 
  $img->clear(); 
  $img->destroy(); 
}

if (file_exists("images/scans/$iconfilename")) {
unlink("images/scans/$iconfilename");
}
if (file_exists("images/scans/glt_$scanid$iconfilename")) {
unlink("images/scans/glt_$scanid$iconfilename");
}



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_stock = "UPDATE pc_scans SET progicon = '$scanid$iconfilename' WHERE scanid = '$scanid'";
@mysqli_query($rs_connect, $rs_insert_stock);

header("Location: admin.php?func=showscans&scantype=$scantype");


}


function deletescan() {
require_once("validate.php");

require("deps.php");
require("common.php");

perm_boot("1");

$scanid = $_REQUEST['scanid'];
$scantype = $_REQUEST['scantype'];



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_find_scan = "SELECT * FROM pc_scans WHERE scanid = '$scanid'";
$rs_find_scanq = mysqli_query($rs_connect, $rs_find_scan);

$totresult = mysqli_num_rows($rs_find_scanq);

if ($totresult == "1") {
$rs_insert_scan = "DELETE FROM pc_scans WHERE scanid = '$scanid'";
@mysqli_query($rs_connect, $rs_insert_scan);
header("Location: admin.php?func=showscans&scantype=$scantype");
} else {
die("Protection Error");
}

}



function useraccounts() {

if ($_COOKIE['username'] != "admin") {
die("admins only");
}

if (array_key_exists('showuser',$_REQUEST)) {
$showuser = "$_REQUEST[showuser]";
} else {
$showuser = "";
}


require("header.php");
require_once("common.php");
require("deps.php");


mysqli_query($rs_connect, "SET NAMES 'utf8'");

start_blue_box(pcrtlang("Users"));

$rs_ql = "SELECT * FROM users";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$userid = "$rs_result_q1->userid";
$uname = "$rs_result_q1->username";
$userpass = "$rs_result_q1->userpass";
$theperms2 = "$rs_result_q1->theperms";
$lastseen2 = "$rs_result_q1->lastseen";
$useremail = "$rs_result_q1->useremail";
$usermobile = "$rs_result_q1->usermobile";

$lastseen = date("n-j-y, g:i a", strtotime($lastseen2));

$theperms3 = unserialize($theperms2);
if(is_array($theperms3)) {
$theperms = $theperms3;
} else {
$theperms = array();
}

echo "<a name=$uname></a>";
start_box_nested();
echo "<table><tr><td valign=top>";
if("$uname" == "$showuser") {
echo "<br><br><br>";
echo "<form action=admin.php?func=useraccounts2 method=post><input type=hidden name=userid value=$userid><input type=hidden name=showuser value=$uname>";
}
echo "<a href=\"admin.php?func=useraccounts&showuser=$uname#$uname\" class=boldlink>$uname</a><br><font class=text10>".pcrtlang("Last Seen").": $lastseen";
echo "</font></td>";
if("$uname" == "$showuser") {
echo "<td valign=top><br><br><br><input type=text name=setuserpass size=15 class=textbox><input type=hidden name=uname value=\"$uname\">";
echo "</td><td valign=top><br><br><br><input type=submit value=\"&laquo;".pcrtlang("Save New Password")."\" class=button></form></td><td valign=top><br><br><br>";

if ("$uname" != "admin") {
echo "<form action=admin.php?func=useraccountsdel method=post><input type=hidden name=userid value=$userid><input type=hidden name=showuser value=$uname>";
echo "<input type=hidden name=uname value=\"$uname\" class=textbox>";
echo "<input type=submit value=\"&laquo;".pcrtlang("Delete User")."\" class=button onClick=\"return confirm('".pcrtlang("Are you sure you wish to delete user").": $uname?')\"></form>";
}
}
echo "</td></tr><tr><td style=\"padding:20px;\">";

if("$uname" == "$showuser") {
echo "<font class=text14b>".pcrtlang("User Permissions").":</font><form action=admin.php?func=saveperms method=post><input type=hidden name=showuser value=$uname><br>";

reset($theperms);
reset($themasterperms);
foreach($themasterperms as $key => $val) {
if (in_array($key, $theperms)) {
echo "<input type=checkbox checked value=\"$key\" name=\"permar[]\"><font class=text12>$val</font></input><br>";
} else {
echo "<input type=checkbox value=\"$key\" name=\"permar[]\"><font class=text12>$val</font></input><br>";
}
}


echo "<input type=hidden name=usertochange value=\"$uname\"><input type=submit value=\"".pcrtlang("Save Permissions")."\" class=button></form>";


echo "</td><td colspan=2 valign=top style=\"padding:20px;\">";

echo "<font class=text14b>".pcrtlang("User Contact Info").":</font><form action=admin.php?func=saveusercontactinfo method=post><input type=hidden name=userid value=$userid><br>";

echo "<font class=text12b>".pcrtlang("Email Address").":</font> <input type=text class=textbox name=useremail value=\"$useremail\">";
echo "<br><br><font class=text12b>".pcrtlang("Mobile Phone").":</font> <input type=text class=textbox name=usermobile value=\"$usermobile\">";

echo "<br><input type=hidden name=usertochange value=\"$uname\"><input type=submit value=\"".pcrtlang("Save User Contact Info")."\" class=button></form>";


}
echo "</td></tr></table>";
stop_box();
echo "<br>";
}



echo "<br><font class=text14b>".pcrtlang("Add User: username/password")."</font><br>";
echo "<form action=admin.php?func=useraccountsnew method=post>";
echo "<input type=text name=uname size=30 value=\"\" class=textbox> / <input type=text name=userpass size=15 value=\"\" class=textbox>";
echo "<input type=submit value=\"&laquo;".pcrtlang("Add User")."\" class=ibutton></form>";

stop_blue_box();

require_once("footer.php");

}


function useraccountsnew() {
require_once("validate.php");

if ($_COOKIE['username'] != "admin") {
die("admins only");
}

require("deps.php");
require("common.php");


$uname = $_REQUEST['uname'];
$userpass = md5($_REQUEST['userpass']);

if (($uname == "") || ($_REQUEST['userpass'] == "")) {
die(pcrtlang("please go back and fill both fields"));
}
 

if ($uname == "admin") {
die(pcrtlang("Cannot create account named admin"));
}

function validate_uname($uname2) {
return preg_match('/[^a-z0-9_\-.]/i', $uname2) ? '0' : '1';
}


if (validate_uname($uname) == '0') {
die(pcrtlang("Please choose a username that contains only underscores, dashes, and alphanumeric charachers"));
}





mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_check = "SELECT * FROM users WHERE username = '$uname'";
$rs_resultchk = mysqli_query($rs_connect, $rs_check);
$exuser = mysqli_num_rows($rs_resultchk);

if ($exuser == 0) {

$rs_insert_scan = "INSERT INTO users (username,userpass,defaultstore) VALUES ('$uname','$userpass','$defaultstore')";
@mysqli_query($rs_connect, $rs_insert_scan);

$rs_ql = "SELECT * FROM taxes WHERE taxenabled = '1' LIMIT 1";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$taxid_indb = "$rs_result_q1->taxid";
$updateuser = "UPDATE users SET currenttaxid = '$taxid_indb' WHERE username = '$uname'";
@mysqli_query($rs_connect, $updateuser);
}


header("Location: admin.php?func=useraccounts&showuser=$uname#$uname");

} else {
die(pcrtlang("Username already exists"));
}


}


function useraccounts2() {
require_once("validate.php");

if ($_COOKIE['username'] != "admin") {
die("admins only");
}


$userid = $_REQUEST['userid'];
$userpass = md5($_REQUEST['setuserpass']);
$uname = $_REQUEST['uname'];

if ($_REQUEST['setuserpass'] == "") {
die(pcrtlang("please go back and enter a password"));
}


require("deps.php");



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "UPDATE users SET userpass = '$userpass' WHERE userid = '$userid' AND username = '$uname'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=useraccounts&showuser=$uname#$uname");


}


function useraccountsdel() {
require_once("validate.php");

if ($_COOKIE['username'] != "admin") {
die("admins only");
}


$userid = $_REQUEST['userid'];
$uname = $_REQUEST['uname'];

require("deps.php");



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "DELETE FROM users WHERE userid = '$userid' AND username != 'admin' AND username = '$uname'";
@mysqli_query($rs_connect, $rs_insert_scan);
header("Location: admin.php?func=useraccounts");

}



function saveusercontactinfo() {
require_once("validate.php");

if ($_COOKIE['username'] != "admin") {
die("admins only");
}


require_once("deps.php");
require_once("common.php");

$userid = $_REQUEST['userid'];
$uname = $_REQUEST['usertochange'];
$useremail = pv($_REQUEST['useremail']);
$usermobile = pv($_REQUEST['usermobile']);



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "UPDATE users SET useremail = '$useremail', usermobile = '$usermobile' WHERE userid = '$userid' AND username = '$uname'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=useraccounts&showuser=$uname#$uname");


}



function admin() {
require_once("header.php");
require_once("common.php");

start_blue_box(pcrtlang("Personal Settings"));



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_ql = "SELECT * FROM users WHERE username = '$ipofpc'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$touchrefresh = "$rs_result_q1->touchrefresh";
$gomodalindb = "$rs_result_q1->gomodal";
$touchwide = "$rs_result_q1->touchwide";
$stickywide = "$rs_result_q1->stickywide";
$autoprintindb = "$rs_result_q1->autoprint";
$floatbarindb = "$rs_result_q1->floatbar";

echo "<form action=admin.php?func=settouch method=post><input type=text value=\"$touchrefresh\" name=touchrefresh class=textboxw size=6>";
echo "<input type=submit value=\"".pcrtlang("Set Touchscreen Refresh Timeout (in seconds)")."\" class=button></form>";

echo "<br><form action=admin.php?func=settouchwide method=post><input type=text value=\"$touchwide\" name=touchwide class=textboxw size=6>";
echo "<input type=submit value=\"".pcrtlang("Set Touchscreen Tile Number Width")."\" class=button></form>";

echo "<br><form action=admin.php?func=setstickywide method=post><input type=text value=\"$stickywide\" name=stickywide class=textboxw size=6>";
echo "<input type=submit value=\"".pcrtlang("Set Sticky Note Tile Number Width")."\" class=button></form>";

echo "<br><form action=admin.php?func=setmodal method=post><font class=text12b>".pcrtlang("Use Modal Windows?").":</font> ";

if($gomodalindb == 0) {
echo "<input type=radio name=modal value=1><font class=text12>".pcrtlang("Yes")."</font> ";
echo "<input type=radio name=modal value=0 checked><font class=text12>".pcrtlang("No")."</font> ";
} else {
echo "<input type=radio name=modal value=1 checked><font class=text12>".pcrtlang("Yes")."</font> ";
echo "<input type=radio name=modal value=0><font class=text12>".pcrtlang("No")."</font> ";
}

echo "<input type=submit value=\"&laquo;".pcrtlang("Save Setting")."\" class=button></form><br>";

echo "<form action=admin.php?func=setautoprint method=post><font class=text12b>".pcrtlang("Auto Fire Print Dialogs?").":</font> ";
if($autoprintindb == 0) {
echo "<input type=radio name=autoprint value=1><font class=text12>".pcrtlang("Yes")."</font> ";
echo "<input type=radio name=autoprint value=0 checked><font class=text12>".pcrtlang("No")."</font> ";
} else {
echo "<input type=radio name=autoprint value=1 checked><font class=text12>".pcrtlang("Yes")."</font> ";
echo "<input type=radio name=autoprint value=0><font class=text12>".pcrtlang("No")."</font> ";
}

echo "<input type=submit value=\"&laquo;".pcrtlang("Save Setting")."\" class=button></form><br>";


echo "<form action=admin.php?func=setfloatbar method=post><font class=text12b>".pcrtlang("Show Floating Bars on WO Screens?").":</font> ";
if($floatbarindb == 0) {
echo "<input type=radio name=floatbar value=1><font class=text12>".pcrtlang("Yes")."</font> ";
echo "<input type=radio name=floatbar value=0 checked><font class=text12>".pcrtlang("No")."</font> ";
} else {
echo "<input type=radio name=floatbar value=1 checked><font class=text12>".pcrtlang("Yes")."</font> ";
echo "<input type=radio name=floatbar value=0><font class=text12>".pcrtlang("No")."</font> ";
}

echo "<input type=submit value=\"&laquo;".pcrtlang("Save Setting")."\" class=button></form><br>";



$rs_find_tax = "SELECT * FROM taxes WHERE taxenabled = '1' ORDER BY taxname ASC";
$rs_result_tax = mysqli_query($rs_connect, $rs_find_tax);
$usertaxid = getusertaxid();
echo "<form method=post action=admin.php?func=setusertax><font class=text12b>".pcrtlang("Default Tax Rate").":</font> <select name=settaxname class=selects onchange='this.form.submit()'>";

while($rs_result_tq = mysqli_fetch_object($rs_result_tax)) {
$rs_taxname = "$rs_result_tq->taxname";
$rs_taxid = "$rs_result_tq->taxid";

if ($rs_taxid == $usertaxid) {
echo "<option selected value=$rs_taxid>$rs_taxname</option>";
} else {
echo "<option value=$rs_taxid>$rs_taxname</option>";
}
}
echo "</select><input type=submit class=ibutton value=\"&laquo;\"></form>";


if ($activestorecount > "1") {
$rs_find_stores = "SELECT * FROM stores WHERE storeenabled = '1' ORDER BY storesname ASC";
$rs_result_stores = mysqli_query($rs_connect, $rs_find_stores);

echo "<br><form method=post action=admin.php?func=setuserdefaultstore><font class=text12b>".pcrtlang("Default Store").":</font>";
echo "<select name=setuserdefaultstore onchange='this.form.submit()'>";

while($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
$rs_storesname = "$rs_result_storeq->storesname";
$rs_storeid = "$rs_result_storeq->storeid";

if ($rs_storeid == $defaultuserstore) {
echo "<option selected value=$rs_storeid>$rs_storesname</option>";
} else {
echo "<option value=$rs_storeid>$rs_storesname</option>";
}
}
echo "</select><input type=submit class=button value=\"&laquo;\"></form>";
}

echo "<br><font class=text12b>".pcrtlang("Calendar Sync Links for Sticky Notes").":</font><br>";

$storeinfoarray = getstoreinfo($defaultuserstore);
if ($storeinfoarray['storehash'] == "") {
echo "<font class=text10i>".pcrtlang("Please have your admin generate a calendar hash for the store").": $storeinfoarray[storesname]</font>";
} else {
echo "<font class=text10b>".pcrtlang("Whole Store").":</font> <a href=$domain/ics.php?download=yes&user=all&storeid=$defaultuserstore&hash=$storeinfoarray[storehash]>link</a><br>";
echo "<font class=text10>$domain/ics.php?download=yes&user=all&storeid=$defaultuserstore&hash=$storeinfoarray[storehash]</font><br><br>";
echo "<font class=text10b>".pcrtlang("Your User Only").":</font> <a href=$domain/ics.php?download=yes&user=$ipofpc&storeid=$defaultuserstore&hash=$storeinfoarray[storehash]>link</a><br>";
echo "<font class=text10>$domain/ics.php?download=yes&user=$ipofpc&storeid=$defaultuserstore&hash=$storeinfoarray[storehash]</font><br><br>";
}



stop_blue_box();

echo "<br><br>";

start_blue_box(pcrtlang("Manage"));

if (perm_check("2")) {
echo "<br><a href=admin.php?func=quicklabor>".pcrtlang("Manage Quick Labor Prices")."</a><br><br>";
}

if (perm_check("11")) {
echo "<a href=admin.php?func=commonproblems>".pcrtlang("Manage Common Problems/Requests")."</a><br><br>";
}

if (perm_check("12")) {
echo "<a href=admin.php?func=showstickynotetypes>".pcrtlang("Manage Sticky Note Types")."</a><br><br>";
}


if (perm_check("1")) {
echo "<a href=admin.php?func=showscans&scantype=0>".pcrtlang("Manage Scans")."</a><br><br>";
echo "<a href=admin.php?func=showscans&scantype=1>".pcrtlang("Manage Actions")."</a><br><br>";
echo "<a href=admin.php?func=showscans&scantype=2>".pcrtlang("Manage Installs")."</a><br><br>";
echo "<a href=admin.php?func=showscans&scantype=3>".pcrtlang("Manage Notes &amp; Recommendations")."</a><br><br>";
}

if (perm_check("8")) {
echo "<a href=admin.php?func=showcustsources>".pcrtlang("Manage Customer Sources")."</a><br><br>";
}

if (perm_check("13")) {
echo "<a href=admin.php?func=smstext>".pcrtlang("Manage SMS Default Texts")."</a><br><br>";
}

if (perm_check("16")) {
echo "<a href=admin.php?func=servicereminders>".pcrtlang("Manage Service Reminder Messages")."</a><br><br>";
}

if (perm_check("18")) {
echo "<a href=admin.php?func=oncallusers>".pcrtlang("Manage/Set On Call Users")."</a><br><br>";
}


stop_blue_box();

echo "<br><br>";

if ($_COOKIE['username'] == "admin") {
start_blue_box(pcrtlang("Admin Only Settings"));
echo "<a href=admin.php?func=useraccounts>".pcrtlang("Manage Users")."</a><br><br>";
echo "<a href=languages.php?langtoedit=$mypcrtlanguage&sortby=basestring_asc>".pcrtlang("Language and Strings Editor")."</a><br><br>";
echo "<a href=admin.php?func=taxrates>".pcrtlang("Manage Tax Rates")."</a><br><br>";
echo "<a href=admin.php?func=showphpinfo>".pcrtlang("Show PHP Info")."</a><br><br>";
echo "<a href=admin.php?func=backupdatabase>".pcrtlang("Download Database Backup File")."</a><br><br>";
echo "<a href=admin.php?func=stores>".pcrtlang("Admin Stores")."</a><br><br>";
echo "<a href=admin.php?func=frameit>".pcrtlang("Manage External Framed Tools")."</a><br><br>";
echo "<a href=admin.php?func=showtechdoccats>".pcrtlang("Edit Technical Document Categories")."</a><br><br>";
echo "<a href=admin.php?func=makehash>".pcrtlang("Create New Calendar Hash")."</a><br><br>";
echo "<a href=admin.php?func=statusstyles>".pcrtlang("Box/Status Box Color Styles")."</a><br><br>";
echo "<a href=admin.php?func=customstatusstyles>".pcrtlang("Custom Status Box Color Styles")."</a><br><br>";
echo "<a href=admin.php?func=mainassets>".pcrtlang("Main Device/Asset Type Definitions")."</a><br><br>";


$phpver =  phpversion();

echo "<a href=import.php>".pcrtlang("Import CSV Contacts")."</a> <font class=text10>(".pcrtlang("Requires PHP version >= 5.3").". Your Version: $phpver)</font><br><br>";


stop_blue_box();
}
require("footer.php");
}



function taxrates() {

if ($_COOKIE['username'] != "admin") {
die("admins only");
}


require("header.php");
require_once("common.php");
require("deps.php");


mysqli_query($rs_connect, "SET NAMES 'utf8'");

$checkratessql = "SELECT * FROM taxes WHERE taxenabled = '1'";
$rs_results_c = mysqli_query($rs_connect, $checkratessql);

$totalrates = mysqli_num_rows($rs_results_c);

start_blue_box(pcrtlang("Tax Rates"));

echo "<font class=text12b>".pcrtlang("Manage Tax Rates")."</font><br>";

echo "<font class=textgray10i>".pcrtlang("Note: You cannot modify tax rates once they have been used to process a sale. If your taxrate changes, disable the old one and add a new one.")."</font><br>";

echo "<br><font class=textgray10i>".pcrtlang("Note: You cannot modify the tax rate of a group rate. This rate is set by the sum of the individual rates.")."</font><br>";

echo "<br><font class=textgray10i>".pcrtlang("Note: Once and individual rate is part of a group rate, you cannot edit the individual rate values, even if it has not been used to process a sale.")."</font><br>";

echo "<table cellspacing=0 cellpadding=3 border=0>";

echo "<tr><td><font class=text12bu>".pcrtlang("ID")."</font></td><td><font class=text12bu>".pcrtlang("Rate Type")."</font></td><td><font class=text12bu>".pcrtlang("Name")."</font></td><td><font class=text12bu>".pcrtlang("Short Tax Name")."</font></td><td><font class=text12bu>".pcrtlang("Service/Labor Rate")."</font></td>";
echo "<td><font class=text12bu>".pcrtlang("Sales Tax")."</font></td><td colspan=3>&nbsp;</td></tr>";

$belongstogroup = array();
$rs_ql_isingroup = "SELECT * FROM taxes WHERE isgrouprate = '1'";
$rs_result1_isingroup = mysqli_query($rs_connect, $rs_ql_isingroup);
while($rs_result_q1_isingroup = mysqli_fetch_object($rs_result1_isingroup)) {
$compositerate = "$rs_result_q1_isingroup->compositerate";
$subarray = unserialize($compositerate);
foreach($subarray as $key => $val) {
if (!in_array($val,$belongstogroup)) {
$belongstogroup[] = $val;
}
}
}


$rs_ql = "SELECT * FROM taxes";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$taxid = "$rs_result_q1->taxid";
$taxname = "$rs_result_q1->taxname";
$taxrateservice = "$rs_result_q1->taxrateservice";
$taxrategoods = "$rs_result_q1->taxrategoods";
$taxenabled = "$rs_result_q1->taxenabled";
$shorttaxname = "$rs_result_q1->shortname";
$isgrouprate = "$rs_result_q1->isgrouprate";
$compositerate2 = "$rs_result_q1->compositerate";

if ($isgrouprate == 1) {
$ratetype = pcrtlang("Group");
$ratetype .= "(";
$compositearray = unserialize($compositerate2);
foreach($compositearray as $key => $val) {
$ratetype .= "$val+";
}
$ratetype = substr("$ratetype", 0, -1);
$ratetype .= ")";
} else {
$ratetype = pcrtlang("Individual");
}



$rs_qsi = "SELECT * FROM sold_items WHERE taxex = '$taxid'";
$rs_resultsi = mysqli_query($rs_connect, $rs_qsi);
$totalcount = mysqli_num_rows($rs_resultsi);




#redo
if ($totalrates == 1) {
$setuserrate = "UPDATE users SET currenttaxid = '$taxid'";
@mysqli_query($rs_connect, $setuserrate);
}



if (($totalcount == '0') && (!in_array($taxid,$belongstogroup)) && ($isgrouprate != 1)) {
$readonly = "class=textbox";
} else {
$readonly = "readonly=readonly class=textboxnoborder";
}

if ($taxenabled == 1) {
$rowcolor = "border-left: #32FF39 8px solid;";
} else {
$rowcolor = "border-left: #ff0000 8px solid;";
}



echo "<tr><td style=\"$rowcolor\"><font class=text12>$taxid</font></td><td><font class=text12>$ratetype</font></td><td><form action=admin.php?func=taxratesedit method=post>
<input type=text class=textbox size=10 value=\"$taxname\" name=taxname></td><td><input type=text class=textbox size=10 value=\"$shorttaxname\" name=shorttaxname>
</td><td><input type=text size=10 value=$taxrateservice name=taxrateservice $readonly></td>";
echo "<td><input type=text size=10 value=$taxrategoods name=taxrategoods $readonly>
<input type=hidden name=taxid value=$taxid></td>
<td><input type=submit class=button value=\"&laquo;".pcrtlang("Edit")."\"></form></td>";



if ($taxenabled == 1) {
echo "<td><form action=admin.php?func=taxratesed method=post><input type=hidden name=taxid value=$taxid><input type=hidden name=enabled value=0><input type=submit class=button value=\"&laquo;".pcrtlang("Disable")."\"></form></td>";
} else {
echo "<td><form action=admin.php?func=taxratesed method=post><input type=hidden name=taxid value=$taxid><input type=hidden name=enabled value=1>
<input type=submit class=button value=\"&laquo;".pcrtlang("Enable")."\"></form></td>";
}

if (($totalcount == '0') && (!in_array($taxid,$belongstogroup)) && ($totalrates > '1')) {
echo "<td><form action=admin.php?func=taxratesdel method=post><input type=hidden name=taxid value=$taxid><input type=hidden name=enabled value=1>
<input type=submit class=button value=\"&laquo;".pcrtlang("Delete")."\"></form></td>";
} else {
echo "<td></td>";
}
echo "</tr>";

}

#redo






echo "</table><table>";

echo "<tr><td colspan=5><br><br><font class=text12b>".pcrtlang("Add Tax Rate").":</font></td></tr>";

echo "<tr><td><font class=text12bu>".pcrtlang("Name").":</font></td><td><font class=text12bu>".pcrtlang("Shortname").":</font></td><td><font class=text12b>".pcrtlang("Service/Labor Rate").":</font></td>";
echo "<td><font class=text12b>".pcrtlang("Sales Tax Rate").":</font></td><td colspan=2>&nbsp;</td></tr>";

echo "<tr><td><form action=admin.php?func=taxratesadd method=post><input type=text size=20 name=taxname class=textbox></td><td><input type=text size=5 name=shorttaxname class=textbox></td><td valign=top><input type=text size=12 name=taxrateservice class=textbox></td><td valign=top><input type=text size=12 name=taxrategoods class=textbox></td><td valign=top><input class=button type=submit value=\"&laquo;".pcrtlang("Add")."\"></form></td><td></td></tr>";



echo "</table>";


stop_blue_box();

echo "<br><br>";

start_blue_box(pcrtlang("Create Tax Group"));
echo "<form action=admin.php?func=createtaxgroup method=post>";
echo "<div class=\"checkbox\">";
$rs_ql = "SELECT * FROM taxes WHERE isgrouprate != '1' AND taxenabled = '1'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$taxid = "$rs_result_q1->taxid";
$taxname = "$rs_result_q1->taxname";
$shorttaxname = "$rs_result_q1->shortname";


echo "<input type=checkbox id=\"$taxid\" value=\"$taxid\" name=\"taxestogroup[]\"><label for=\"$taxid\">$taxname ($shorttaxname)</input></label><br>";
}
echo "</div><input class=button type=submit value=\"".pcrtlang("Create Tax Group")."\"></form>";

stop_blue_box();

require_once("footer.php");

}


function taxratesadd() {
require_once("validate.php");

require("deps.php");
require("common.php");

$taxrateservice = $_REQUEST['taxrateservice'];
$taxrategoods = $_REQUEST['taxrategoods'];
$taxname = pv($_REQUEST['taxname']);
$shorttaxname = pv($_REQUEST['shorttaxname']);

if ($_COOKIE['username'] != "admin") {
die("admins only");
}

if ($taxname == "") {
die(pcrtlang("Go back and enter a tax name"));
}



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "INSERT INTO taxes (taxname,taxrateservice,taxrategoods,taxenabled,shortname) VALUES ('$taxname','$taxrateservice','$taxrategoods','1','$shorttaxname')";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=taxrates");


}


function taxratesedit() {
require_once("validate.php");

require("deps.php");
require("common.php");

$taxrateservice = $_REQUEST['taxrateservice'];
$taxrategoods = $_REQUEST['taxrategoods'];
$taxname = pv($_REQUEST['taxname']);
$shorttaxname = pv($_REQUEST['shorttaxname']);
$taxid = $_REQUEST['taxid'];

if ($_COOKIE['username'] != "admin") {
die("admins only");
}

if ($taxname == "") {
die(pcrtlang("Go back and enter a tax name"));
}



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "UPDATE taxes SET taxname = '$taxname', taxrateservice = '$taxrateservice', taxrategoods = '$taxrategoods', shortname = '$shorttaxname' WHERE taxid = '$taxid'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=taxrates");


}



function taxratesed() {
require_once("validate.php");

$enabled = $_REQUEST['enabled'];
$taxid = $_REQUEST['taxid'];

if ($_COOKIE['username'] != "admin") {
die("admins only");
}

require("deps.php");



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "UPDATE taxes SET taxenabled = '$enabled' WHERE taxid = '$taxid'";
@mysqli_query($rs_connect, $rs_insert_scan);

if ($enabled == 0) {
$rs_ql = "SELECT * FROM taxes WHERE taxenabled = '1' LIMIT 1";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$taxid_indb = "$rs_result_q1->taxid";
$updateuser = "UPDATE users SET currenttaxid = '$taxid_indb' WHERE currenttaxid = '$taxid'";
@mysqli_query($rs_connect, $updateuser);
}
}

header("Location: admin.php?func=taxrates");


}

function taxratesdel() {
require_once("validate.php");
require_once("common.php");

$taxid = $_REQUEST['taxid'];

if ($_COOKIE['username'] != "admin") {
die("admins only");
}

require("deps.php");



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$usertaxid = getusertaxid();

if ($taxid == $currentusertaxid) {
$rs_ql = "SELECT * FROM taxes WHERE taxenabled = '1' AND taxid != '$usertaxid' LIMIT 1";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$taxid_indb = "$rs_result_q1->taxid";
$updateuser = "UPDATE users SET currenttaxid = '$taxid_indb' WHERE currenttaxid = '$taxid'";
@mysqli_query($rs_connect, $updateuser);
}
}


$rs_insert_scan = "DELETE FROM taxes WHERE taxid = '$taxid'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=taxrates");

}


function createtaxgroup() {
require_once("validate.php");

require("deps.php");
require("common.php");

$taxestogroup = $_REQUEST['taxestogroup'];

if ($_COOKIE['username'] != "admin") {
die("admins only");
}

if (count($taxestogroup) <= 1) {
die("You must select at lease 2 or more taxes rates to group");
}




mysqli_query($rs_connect, "SET NAMES 'utf8'");

$totalservice = 0;
$totalgoods = 0;
$nameservice = "";
$namegoods = "";

foreach($taxestogroup as $key => $val) {
$rs_ql = "SELECT * FROM taxes WHERE taxid = '$val'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$taxid = "$rs_result_q1->taxid";
$taxname = "$rs_result_q1->taxname";
$taxrateservice = "$rs_result_q1->taxrateservice";
$taxrategoods = "$rs_result_q1->taxrategoods";
$taxenabled = "$rs_result_q1->taxenabled";
$shorttaxname = "$rs_result_q1->shortname";

$totalservice = $totalservice + $taxrateservice;
$totalgoods = $totalgoods + $taxrategoods;

$groupname .= "$shorttaxname+";

$composite[] = $taxid;

}
}

$compositerate = pv(serialize($composite));

$groupname = substr("$groupname", 0, -1);


$rs_insert_scan = "INSERT INTO taxes (taxname,taxrateservice,taxrategoods,taxenabled,shortname,isgrouprate,compositerate) VALUES ('$groupname','$totalservice','$totalgoods','1','$groupname','1','$compositerate')";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=taxrates");


}


function setscanrecordview() {
require_once("validate.php");

$view = $_REQUEST['view'];
$pcwo = $_REQUEST['pcwo'];
$usertochange = $_COOKIE['username'];

require("deps.php");



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "UPDATE users SET scanrecordview = '$view' WHERE username = '$usertochange'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: index.php?pcwo=$pcwo");


}

function settouch() {
require_once("validate.php");

$touchrefresh = $_REQUEST['touchrefresh'];

require("deps.php");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "UPDATE users SET touchrefresh = '$touchrefresh' WHERE username = '$ipofpc'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php");

}

function settouchwide() {
require_once("validate.php");

$touchwide = $_REQUEST['touchwide'];

require("deps.php");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}

if (($touchwide > "20") || ($touchwide < "2")) {
die(pcrtlang("Sorry, value out of range"));
}




mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "UPDATE users SET touchwide = '$touchwide' WHERE username = '$ipofpc'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php");

}

function setstickywide() {
require_once("validate.php");

$stickywide = $_REQUEST['stickywide'];

require("deps.php");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}

if (($stickywide > "20") || ($stickywide < "2")) {
die("Sorry, value out of range");
}




mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "UPDATE users SET stickywide = '$stickywide' WHERE username = '$ipofpc'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php");

}



function setmodal() {
require_once("validate.php");

$setmodal = $_REQUEST['modal'];

require("deps.php");



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "UPDATE users SET gomodal = '$setmodal' WHERE username = '$ipofpc'";
@mysqli_query($rs_connect, $rs_insert_scan);
header("Location: admin.php");

}



function setfloatbar() {
require_once("validate.php");

$setfloatbar = $_REQUEST['floatbar'];

require("deps.php");



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "UPDATE users SET floatbar = '$setfloatbar' WHERE username = '$ipofpc'";
@mysqli_query($rs_connect, $rs_insert_scan);
header("Location: admin.php");

}


function setautoprint() {
require_once("validate.php");

$setautoprint = $_REQUEST['autoprint'];

require("deps.php");



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "UPDATE users SET autoprint = '$setautoprint' WHERE username = '$ipofpc'";
@mysqli_query($rs_connect, $rs_insert_scan);
header("Location: admin.php");

}


function saveperms() {
require_once("validate.php");

if (array_key_exists('permar', $_REQUEST)) {
$permar = $_REQUEST['permar'];
} else {
$permar = array();
}

$usertochange = $_REQUEST['usertochange'];

if ($_COOKIE['username'] != "admin") {
die("admins only");
}

$theperms2 = serialize($permar);

require("deps.php");



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "UPDATE users SET theperms = '$theperms2' WHERE username = '$usertochange'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=useraccounts&showuser=$usertochange#$usertochange");


}


function showphpinfo() {
require_once("validate.php");

phpinfo();

}


function admindeletewo() {
require_once("validate.php");

require("deps.php");

$pcwoid = $_REQUEST['pcwoid'];

if ($_COOKIE['username'] != "admin") {
die("admins only");
}



mysqli_query($rs_connect, "SET NAMES 'utf8'");


$rs_dcs = "SELECT * FROM attachments WHERE woid = '$pcwoid'";
$resultd = mysqli_query($rs_connect, $rs_dcs);
while ($filea = mysqli_fetch_object($resultd)) {
		$filed = $filea->attach_filename;
		if (file_exists("../attachments/$filed")) {
			unlink("../attachments/$filed");
		}
}
$rs_dcs = "DELETE FROM attachments WHERE woid = '$pcwoid'";
@mysqli_query($rs_connect, $rs_dcs);

$rs_dcs = "DELETE FROM pc_scan WHERE woid = '$pcwoid'";
@mysqli_query($rs_connect, $rs_dcs);

$rs_dcs = "DELETE FROM repaircart WHERE pcwo = '$pcwoid'";
@mysqli_query($rs_connect, $rs_dcs);

$rs_dcs = "DELETE FROM timers WHERE woid = '$pcwoid'";
@mysqli_query($rs_connect, $rs_dcs);

$rs_dcs = "DELETE FROM travellog WHERE tlwo = '$pcwoid'";
@mysqli_query($rs_connect, $rs_dcs);

$rs_dcs = "DELETE FROM userlog WHERE refid = '$pcwoid' AND reftype='woid'";
@mysqli_query($rs_connect, $rs_dcs);

$rs_dcs = "DELETE FROM wonotes WHERE woid = '$pcwoid'";
@mysqli_query($rs_connect, $rs_dcs);

$rs_insert_scan = "DELETE FROM pc_wo WHERE woid = '$pcwoid'";
@mysqli_query($rs_connect, $rs_insert_scan);

$rs_dcs = "DELETE FROM claimsigtext WHERE woid = '$pcwoid'";
@mysqli_query($rs_connect, $rs_dcs);

header("Location: index.php");


}

function admindeletepc() {
require_once("validate.php");

require("deps.php");

$pcid = $_REQUEST['pcid'];
if ($_COOKIE['username'] != "admin") {
die("admins only");
}



mysqli_query($rs_connect, "SET NAMES 'utf8'");


$rs_dcs = "SELECT * FROM assetphotos WHERE pcid = '$pcid'";
$resultd = mysqli_query($rs_connect, $rs_dcs);
while ($filea = mysqli_fetch_object($resultd)) {
	$file = $filea->photofilename;
	if (file_exists("../pcphotos/$file")) {
		unlink("../pcphotos/$file");
	}
}
$rs_dcs = "DELETE FROM assetphotos WHERE pcid = '$pcid'";
@mysqli_query($rs_connect, $rs_dcs);

$rs_findwo = "SELECT * FROM pc_wo WHERE pcid = '$pcid'";
$resultdwo = mysqli_query($rs_connect, $rs_findwo);
while ($filedwof = mysqli_fetch_object($resultdwo)) {
                $filedwoid = $filedwof->woid;

$rs_dcs = "SELECT * FROM attachments WHERE woid = '$filedwoid'";
$resultd = mysqli_query($rs_connect, $rs_dcs);
while ($filea = mysqli_fetch_object($resultd)) {
		$filed = $filea->attach_filename;
		if (file_exists("../attachments/$filed")) {
			unlink("../attachments/$filed");
		}
}
$rs_dcs = "DELETE FROM attachments WHERE woid = '$filedwoid'";
@mysqli_query($rs_connect, $rs_dcs);

$rs_dcs = "DELETE FROM pc_scan WHERE woid = '$filedwoid'";
@mysqli_query($rs_connect, $rs_dcs);

$rs_dcs = "DELETE FROM repaircart WHERE pcwo = '$filedwoid'";
@mysqli_query($rs_connect, $rs_dcs);

$rs_dcs = "DELETE FROM timers WHERE woid = '$filedwoid'";
@mysqli_query($rs_connect, $rs_dcs);

$rs_dcs = "DELETE FROM travellog WHERE tlwo = '$filedwoid'";
@mysqli_query($rs_connect, $rs_dcs);

$rs_dcs = "DELETE FROM userlog WHERE refid = '$filedwoid' AND reftype='woid'";
@mysqli_query($rs_connect, $rs_dcs);

$rs_dcs = "DELETE FROM wonotes WHERE woid = '$filedwoid'";
@mysqli_query($rs_connect, $rs_dcs);



}


$rs_dcs = "SELECT * FROM attachments WHERE pcid = '$pcid'";
$resultd = mysqli_query($rs_connect, $rs_dcs);
while ($filea = mysqli_fetch_object($resultd)) {
                $filed = $filea->attach_filename;
                if (file_exists("../attachments/$filed")) {
                        unlink("../attachments/$filed");
                }
}
$rs_dcs = "DELETE FROM attachments WHERE pcid = '$pcid'";
@mysqli_query($rs_connect, $rs_dcs);





$rs_deletepc1 = "DELETE FROM pc_owner WHERE pcid = '$pcid'";
@mysqli_query($rs_connect, $rs_deletepc1);

$rs_deletepc2 = "DELETE FROM pc_wo WHERE pcid = '$pcid'";
@mysqli_query($rs_connect, $rs_deletepc2);

$rs_deletepc3 = "DELETE FROM rwo WHERE pcid = '$pcid'";
@mysqli_query($rs_connect, $rs_deletepc3);

$rs_dcs = "DELETE FROM claimsigtext WHERE woid = '$pcwoid'";
@mysqli_query($rs_connect, $rs_dcs);





header("Location: index.php");

}

function admindeletegroup() {
require_once("validate.php");

require("deps.php");

$pcgroupid = $_REQUEST['pcgroupid'];
if ($_COOKIE['username'] != "admin") {
die("admins only");
}



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_deletepc1 = "DELETE FROM pc_group WHERE pcgroupid = '$pcgroupid'";
@mysqli_query($rs_connect, $rs_deletepc1);
header("Location: group.php");

}



#######


function showcustsources() {

require("header.php");
require_once("common.php");
require("deps.php");

perm_boot("8");



mysqli_query($rs_connect, "SET NAMES 'utf8'");

start_blue_box(pcrtlang("Manage Customer Sources"));


echo "<table width=100%>";

echo "<tr><td width=30%><font class=text14b>".pcrtlang("Name")."</font></td><td width=30%><font class=text14b>".pcrtlang("Active?/Show on Reports")."</font></td><td width=20%></td><td width=20%><font class=text14b>".pcrtlang("Total Recorded")."</font></td></tr>";

$rs_sq = "SELECT * FROM custsource";
$rs_result1 = mysqli_query($rs_connect, $rs_sq);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$custsourceid = "$rs_result_q1->custsourceid";
$thesource = "$rs_result_q1->thesource";
$sourceenabled = "$rs_result_q1->sourceenabled";
$sourceicon = "$rs_result_q1->sourceicon";
$showonreport = "$rs_result_q1->showonreport";

$checksources =  "SELECT * FROM pc_owner WHERE custsourceid='$custsourceid'";
$rs_result_chk = mysqli_query($rs_connect, $checksources);
$totalsources = mysqli_num_rows($rs_result_chk);

if ($sourceenabled == 1) {
echo "<tr><td>";
if ($sourceicon != "") {
echo "<img src=images/custsources/$sourceicon align=absmiddle>";
}
echo "<font class=text12b> $thesource </font></td><td><font class=text12>".pcrtlang("enabled");

if($showonreport == 1) {
echo " / ".pcrtlang("yes");
} else {
echo " / ".pcrtlang("no");
}


echo "</font></td><td><a href=admin.php?func=editcustsource&custsourceid=$custsourceid>".pcrtlang("edit")."</a><font class=text12b> | </font>";
if ($totalsources == "0") {
echo "<a href=admin.php?func=deletecustsource&custsourceid=$custsourceid>".pcrtlang("delete")."</a>";
}

echo "</td><td align=left><font class=text12>$totalsources</font></td></tr>";

} else {
echo "<tr><td>";
if ($sourceicon != "") {
echo "<img src=images/custsources/$sourceicon align=absmiddle>"; 
}

echo " <font class=textgray12b>$thesource</font></td><td><font class=textgray12b>".pcrtlang("disabled")."";

if($showonreport == 1) {
echo " / ".pcrtlang("yes")."";
} else {
echo " / ".pcrtlang("no")."";
}

echo "</font></td><td>";
echo "<a href=admin.php?func=editcustsource&custsourceid=$custsourceid>".pcrtlang("edit")."</a>";

if ($totalsources == "0") {
echo "<font class=text12b> | </font><a href=admin.php?func=deletecustsource&custsourceid=$custsourceid>".pcrtlang("delete")."</a>";
}


echo "</td><td align=left><font class=text12>$totalsources</font></td><td>";
}
echo "</td></tr>";
}
echo "</table>";
echo "<br><br><a href=admin.php?func=addcustsource>".pcrtlang("Add new Customer Source")."</a>";

stop_blue_box();
echo "<br><br>";


require_once("footer.php");



}

function addcustsource() {

require("header.php");
require_once("common.php");
require("deps.php");

perm_boot("8");


start_blue_box(pcrtlang("Add Customer Source"));
echo "<form action=admin.php?func=addcustsource2 method=post>";
echo "<table>";

echo "<tr><td><font class=text12b>".pcrtlang("Customer Source").":</font></td>";
echo "<td><input type=text size=35 name=thesource value=\"\"></td></tr>";
echo "<tr><td><font class=text12b>".pcrtlang("Enabled").":</font></td>";
echo "<td>";
echo "<font class=text12b>".pcrtlang("Yes").":</font><input type=radio name=sourceenabled checked value=on><br>";
echo "<font class=text12b>".pcrtlang("No").":</font><input type=radio name=sourceenabled value=off>";
echo "</td></tr>";

echo "<tr><td><font class=text12b>".pcrtlang("Show on Report").":</font></td>";
echo "<td>";
echo "<font class=text12b>".pcrtlang("Yes").":</font><input type=radio name=showonreport checked value=on><br>";
echo "<font class=text12b>".pcrtlang("No").":</font><input type=radio name=showonreport value=off>";
echo "</td></tr>";

echo "<tr><td colspan=2><font class=text12b>".pcrtlang("Choose Icon").":</font><br>";

reset($custsourceicons);
foreach($custsourceicons as $key => $val) {

echo "<input type=radio id=$key name=custsourceicon value=\"$val\"><label for=$key><img src=images/custsources/$val></label>";

}

echo "<br><br></td></tr>";


echo "<tr><td><input type=submit value=\"".pcrtlang("Add Customer Source")."\" class=ibutton></td><td></td></tr>";


echo "</form></table>";

stop_blue_box();
require("footer.php");

}


function addcustsource2() {

require("deps.php");
require("common.php");

perm_boot("8");

$thesource = pv($_REQUEST['thesource']);
$custsourceicon = $_REQUEST['custsourceicon'];
$sourceenabled = $_REQUEST['sourceenabled'];
$showonreport = $_REQUEST['showonreport'];

require_once("validate.php");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}


if ($sourceenabled == 'on') {
$sourceenabled2 = 1;
} else {
$sourceenabled2 = 0;
}

if ($showonreport == 'on') {
$showonreport2 = 1;
} else {
$showonreport2 = 0;
}




mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "INSERT INTO custsource (thesource, sourceicon, sourceenabled, showonreport) VALUES ('$thesource','$custsourceicon','$sourceenabled2','$showonreport2')";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=showcustsources");

}

function deletecustsource() {
require_once("validate.php");

require("deps.php");
require("common.php");

perm_boot("8");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}


$custsourceid = $_REQUEST['custsourceid'];



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "DELETE FROM custsource WHERE custsourceid = '$custsourceid'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=showcustsources");

}

function editcustsource() {

require("header.php");
require_once("common.php");
require("deps.php");

perm_boot("8");


if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}


$custsourceid = $_REQUEST['custsourceid'];



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_ql = "SELECT * FROM custsource WHERE custsourceid = '$custsourceid'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$thesource = "$rs_result_q1->thesource";
$sourceenabled = "$rs_result_q1->sourceenabled";
$showonreport = "$rs_result_q1->showonreport";
$custsourceicon = "$rs_result_q1->sourceicon";


start_blue_box(pcrtlang("Edit Customer Source"));
echo "<form action=admin.php?func=editcustsource2 method=post>";
echo "<table>";

echo "<tr><td><font class=text12b>".pcrtlang("Customer Source").":</font></td>";
echo "<td><input type=text size=35 name=thesource value=\"$thesource\" class=textbox></td></tr>";
echo "<tr><td><font class=text12b>".pcrtlang("Enabled").":</font></td>";
echo "<td>";
if($sourceenabled == 1) {
echo "<font class=text12b>".pcrtlang("Yes").":</font><input type=radio name=sourceenabled checked value=on><br>";
echo "<font class=text12b>".pcrtlang("No").":</font><input type=radio name=sourceenabled value=off>";
} else {
echo "<font class=text12b>".pcrtlang("Yes").":</font><input type=radio name=sourceenabled value=on><br>";
echo "<font class=text12b>".pcrtlang("No").":</font><input type=radio name=sourceenabled checked value=off>";
}
echo "</td></tr>";

echo "<tr><td><font class=text12b>".pcrtlang("Show on Report").":</font></td>";
echo "<td>";
if($showonreport == 1) {
echo "<font class=text12b>".pcrtlang("Yes").":</font><input type=radio name=showonreport checked value=on><br>";
echo "<font class=text12b>".pcrtlang("No").":</font><input type=radio name=showonreport value=off>";
} else {
echo "<font class=text12b>".pcrtlang("Yes").":</font><input type=radio name=showonreport value=on><br>";
echo "<font class=text12b>".pcrtlang("No").":</font><input type=radio name=showonreport checked value=off>";
}

echo "<input type=hidden value=\"$custsourceid\" name=custsourceid></td></tr>";

echo "<tr><td colspan=2><font class=text12b>".pcrtlang("Choose Icon").":</font><br>";

reset($custsourceicons);
foreach($custsourceicons as $key => $val) {
if ($custsourceicon == "$val") {
echo "<input type=radio id=$key name=custsourceicon value=\"$val\" checked><label for=$key><img src=images/custsources/$val></label>";
} else {
echo "<input type=radio id=$key name=custsourceicon value=\"$val\"><label for=$key><img src=images/custsources/$val></label>";
}

}

echo "<br><br></td></tr>";


echo "<tr><td><input type=submit value=\"".pcrtlang("Save")."\" class=ibutton></td><td></td></tr>";


echo "</form></table>";

stop_blue_box();
require("footer.php");

}


function editcustsource2() {

require("deps.php");
require("common.php");

perm_boot("8");

$thesource = pv($_REQUEST['thesource']);
$custsourceicon = $_REQUEST['custsourceicon'];
$sourceenabled = $_REQUEST['sourceenabled'];
$showonreport = $_REQUEST['showonreport'];
$custsourceid = $_REQUEST['custsourceid'];

require_once("validate.php");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}


if ($sourceenabled == 'on') {
$sourceenabled2 = 1;
} else {
$sourceenabled2 = 0;
}

if ($showonreport == 'on') {
$showonreport2 = 1;
} else {
$showonreport2 = 0;
}




mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "UPDATE custsource SET thesource = '$thesource',  sourceicon = '$custsourceicon',  sourceenabled = '$sourceenabled2', showonreport = '$showonreport2' WHERE custsourceid = '$custsourceid'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=showcustsources");
}

######

function commonproblems() {
require("header.php");
require_once("common.php");
require("deps.php");

perm_boot("11");



mysqli_query($rs_connect, "SET NAMES 'utf8'");

start_blue_box(pcrtlang("Common Problems or Requests"));
echo "<table>";
$rs_ql = "SELECT * FROM commonproblems";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);

echo "<tr><td><font class=text12b>".pcrtlang("Customer Viewable")."?</font></td><td align=center><font class=text12b>".pcrtlang("Description")."</font></td><td></td><td></td></tr>";

while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$probid = "$rs_result_q1->probid";
$theprob = "$rs_result_q1->theproblem";
$custviewable = "$rs_result_q1->custviewable";

echo "<tr><td valign=top><form action=admin.php?func=comprobsave method=post><input type=hidden name=probid value=$probid>";

if ($custviewable == '1') {
echo "<font class=text12b>".pcrtlang("Yes").":</font><input type=radio name=active checked value=on>";
echo "<font class=text12b>".pcrtlang("No").":</font><input type=radio name=active value=off>";
} else {
echo "<font class=text12b>".pcrtlang("Yes").":</font><input type=radio name=active value=on>";
echo "<font class=text12b>".pcrtlang("No").":</font><input type=radio name=active checked value=off>";
}


echo "</td><td><input type=text name=theprob size=40 class=textbox value=\"$theprob\">";
echo "</td><td valign=top><input type=submit value=\"&laquo;".pcrtlang("Save")."\" class=button></form></td><td valign=top><form action=admin.php?func=comprobdelete method=post><input type=hidden name=probid value=$probid>";
echo "<input type=submit value=\"&laquo;".pcrtlang("Delete")."\" class=button></form></td></tr>";

}

echo "</table>";

echo "<font class=text14b>".pcrtlang("Add").":</font><br>";
echo "<form action=admin.php?func=comprobadd method=post>";
echo "<input type=text name=theprob class=textbox size=40 value=\"\">";
echo "<input type=submit value=\"&laquo;".pcrtlang("Add")."\" class=ibutton></form>";

stop_blue_box();

require_once("footer.php");
                                                                                                    
}


function comprobsave() {
require_once("validate.php");

require("deps.php");
require("common.php");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}


perm_boot("11");

$probid = $_REQUEST['probid'];
$theprob = pv($_REQUEST['theprob']);
$active = $_REQUEST['active'];

if($active == "on") {
$custviewable = 1;
} else {
$custviewable = 0;
}



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "UPDATE commonproblems SET theproblem = '$theprob', custviewable = '$custviewable' WHERE probid = '$probid'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=commonproblems");


}

function comprobdelete() {
require_once("validate.php");

require("deps.php");
require("common.php");

$probid = $_REQUEST['probid'];

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}


perm_boot("11");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "DELETE FROM commonproblems WHERE probid = '$probid'";
@mysqli_query($rs_connect, $rs_insert_scan);
header("Location: admin.php?func=commonproblems");

}



function comprobadd() {
require_once("validate.php");

require("deps.php");
require("common.php");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}


perm_boot("11");

$theprob = pv($_REQUEST['theprob']);



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "INSERT INTO commonproblems (theproblem) VALUES ('$theprob')";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=commonproblems");


}



function setusertax() {
require_once("validate.php");
require("deps.php");
require("common.php");

$setusername = $_COOKIE['username'];
$settaxname = $_REQUEST['settaxname'];



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_rm_cart = "UPDATE users SET currenttaxid = '$settaxname' WHERE username = '$setusername'";
@mysqli_query($rs_connect, $rs_rm_cart);

header("Location: admin.php");

}



###
function showstickynotetypes() {
require("header.php");
require_once("common.php");
require("deps.php");

perm_boot("12");



mysqli_query($rs_connect, "SET NAMES 'utf8'");

start_blue_box(pcrtlang("Manage Sticky Note Types"));
echo "<table>";

echo "<tr><td valign=top><font class=text12b>".pcrtlang("Sticky Type Name")."</font></td><td valign=top><font class=text12b>".pcrtlang("Border Color")."&nbsp;&nbsp;</font></td>";
echo "<td valign=top><font class=text12b>".pcrtlang("Note Color 1")."&nbsp;&nbsp;</font></td><td valign=top><font class=text12b>".pcrtlang("Note Color 2")."&nbsp;&nbsp;</font></td>";
echo "<td valign=top></td></tr>";


$rs_ql = "SELECT * FROM stickytypes";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$stickytypeid = "$rs_result_q1->stickytypeid";
$stickytypename = "$rs_result_q1->stickytypename";
$bordercolor = "$rs_result_q1->bordercolor";
$notecolor = "$rs_result_q1->notecolor";
$notecolor2 = "$rs_result_q1->notecolor2";

echo "<tr><td valign=top><form action=admin.php?func=stickynotetypesave method=post><input type=hidden name=stickytypeid value=$stickytypeid>";
echo "<input type=text name=stickytypename size=30 class=textbox value=\"$stickytypename\"></td><td>";
echo "<input type=text name=bordercolor size=6 class=textbox value=\"$bordercolor\" style=\"background: #$bordercolor;color:#FFFFFF\"></td><td>";
echo "<input type=text name=notecolor size=6 class=textbox value=\"$notecolor\" style=\"background: #$notecolor\"></td><td>";
echo "<input type=text name=notecolor2 size=6 class=textbox value=\"$notecolor2\" style=\"background: #$notecolor2\"></td><td>";
echo "</td><td valign=top><input type=submit value=\"&laquo;".pcrtlang("Save")."\" class=button></form></td><td valign=top>";
echo "<form action=admin.php?func=stickynotetypedelete method=post><input type=hidden name=stickytypeid value=$stickytypeid>";
echo "<input type=submit value=\"&laquo;".pcrtlang("Delete")."\" class=button></form></td></tr>";

}

echo "</table>";
echo "<font class=text14b>".pcrtlang("Add").":</font><br>";

echo "<table>";
echo "<tr><td valign=top><font class=text12b>".pcrtlang("Sticky Type Name")."</font></td><td valign=top><font class=text12b>".pcrtlang("Border Color")."&nbsp;&nbsp;</font></td>";
echo "<td valign=top><font class=text12b>".pcrtlang("Note Color 1")."&nbsp;&nbsp;</font></td><td valign=top><font class=text12b>".pcrtlang("Note Color 2")."&nbsp;&nbsp;</font></td>";
echo "<td valign=top></td></tr>";

echo "<tr><td valign=top>";
echo "<form action=admin.php?func=stickynotetypeadd method=post>";
echo "<input type=text name=stickytypename class=textbox size=30 value=\"\"></td><td>";
echo "<input type=text name=bordercolor size=6 class=textbox value=\"\"></td><td>";
echo "<input type=text name=notecolor size=6 class=textbox value=\"\"></td><td>";
echo "<input type=text name=notecolor2 size=6 class=textbox value=\"\"></td><td>";
echo "<input type=submit value=\"&laquo;".pcrtlang("Add")."\" class=ibutton></form></td><td>";
echo "</tr></table>";
stop_blue_box();

require_once("footer.php");

}


function stickynotetypesave() {
require_once("validate.php");

require("deps.php");
require("common.php");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}


perm_boot("12");

$stickytypeid = $_REQUEST['stickytypeid'];
$stickytypename = pv($_REQUEST['stickytypename']);
$bordercolor = pv($_REQUEST['bordercolor']);
$notecolor = pv($_REQUEST['notecolor']);
$notecolor2 = pv($_REQUEST['notecolor2']);



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "UPDATE stickytypes SET stickytypename = '$stickytypename', bordercolor = '$bordercolor', notecolor = '$notecolor', notecolor2 = '$notecolor2' WHERE stickytypeid = '$stickytypeid'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=showstickynotetypes");

}

function stickynotetypedelete() {
require_once("validate.php");

require("deps.php");
require("common.php");

$stickytypeid = $_REQUEST['stickytypeid'];

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}


perm_boot("12");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "DELETE FROM stickytypes WHERE stickytypeid = '$stickytypeid'";
@mysqli_query($rs_connect, $rs_insert_scan);
header("Location: admin.php?func=showstickynotetypes");

}

function stickynotetypeadd() {
require_once("validate.php");

require("deps.php");
require("common.php");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}


perm_boot("12");

$stickytypename = pv($_REQUEST['stickytypename']);
$bordercolor = pv($_REQUEST['bordercolor']);
$notecolor = pv($_REQUEST['notecolor']);
$notecolor2 = pv($_REQUEST['notecolor2']);



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "INSERT INTO stickytypes (stickytypename,bordercolor,notecolor,notecolor2) VALUES ('$stickytypename','$bordercolor','$notecolor','$notecolor2')";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=showstickynotetypes");


}



function backupdatabase() {
require_once("validate.php");

require("deps.php");
require("common.php");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature can only be used by the admin user");
}



function mysql_dump() {
require("deps.php");


mysqli_query($rs_connect, "SET NAMES 'utf8'");

$database = $dbname;
define("lnbr", "\n"); 
$query = '';

$databasesql = "SHOW TABLES FROM $database";
$tables = @mysqli_query($rs_connect, $databasesql);
while ($row = @mysqli_fetch_row($tables)) { $table_list[] = $row[0]; }
 
for ($i = 0; $i < @count($table_list); $i++) {
 
$query .= 'DROP TABLE IF EXISTS `' . $table_list[$i] . '`;' . lnbr;
 
$results = mysqli_query($rs_connect, "SHOW CREATE TABLE $table_list[$i]");
while ($row = @mysqli_fetch_assoc($results)) {
$query .= $row['Create Table'];
}

 
$query .= ';' . str_repeat(lnbr, 2);
 
$results = mysqli_query($rs_connect, 'SELECT * FROM ' . $table_list[$i]);
 
while ($row = @mysqli_fetch_assoc($results)) {
 
$query .= 'INSERT INTO `' . $table_list[$i] .'` (';
 
$data = Array();
 
foreach($row as $key => $val) { $data['keys'][] = $key; $data['values'][] = addslashes($value); }
 
$query .= join($data['keys'], ', ') . ')' . lnbr . 'VALUES (\'' . join($data['values'], '\', \'') . '\');' . lnbr;
 
}
 
$query .= str_repeat(lnbr, 2);
 
}
 
return $query;
 
}
     
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"pcrt.sql\"");
echo mysql_dump();

}


function stores() {
require("header.php");
require_once("common.php");
require("deps.php");

if ($_COOKIE['username'] != "admin") {
die("admins only");
}



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_ql = "SELECT * FROM stores";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$storeid = "$rs_result_q1->storeid";
$storesname = "$rs_result_q1->storesname";
$storename = "$rs_result_q1->storename";
$storeaddy1 = "$rs_result_q1->storeaddy1";
$storeaddy2 = "$rs_result_q1->storeaddy2";
$storecity = "$rs_result_q1->storecity";
$storestate = "$rs_result_q1->storestate";
$storezip = "$rs_result_q1->storezip";
$storeemail = "$rs_result_q1->storeemail";
$storephone = "$rs_result_q1->storephone";
$storeenabled = "$rs_result_q1->storeenabled";
$storedefault = "$rs_result_q1->storedefault";
$linecolor1 = "$rs_result_q1->linecolor1";
$linecolor2 = "$rs_result_q1->linecolor2";
$bgcolor1 = "$rs_result_q1->bgcolor1";
$bgcolor2 = "$rs_result_q1->bgcolor2";
$storeccemail = "$rs_result_q1->ccemail";


if ($storedefault == 0) {
start_blue_box("$storesname: $storename");
} else {
start_blue_box("$storesname: $storename (".pcrtlang("Default Store").")");
}
echo "<table><tr><td style=\"vertical-align:top\"><table>";
if ($storeenabled == 1) {
echo "<tr><td valign=top><form action=admin.php?func=savestore method=post><input type=hidden name=storeid value=$storeid>";
echo "<font class=text12b>".pcrtlang("Store Short Name").":</font></td><td><input type=text name=storesname size=10 value=\"$storesname\" class=textbox></td></tr>";
echo "<tr><td><font class=text12b>".pcrtlang("Store/Business Name")."</font></td><td><input type=text name=storename size=25 value=\"$storename\" class=textbox></td></tr>";
echo "<tr><td><font class=text12b>$pcrt_address1</font></td><td><input type=text name=storeaddy1 size=20 value=\"$storeaddy1\" class=textbox></td></tr>";
echo "<tr><td><font class=text12b>$pcrt_address2</font></td><td><input type=text name=storeaddy2 size=20 value=\"$storeaddy2\" class=textbox></td></tr>";
echo "<tr><td><font class=text12b>$pcrt_city</font></td><td><input type=text name=storecity size=10 value=\"$storecity\" class=textbox></td></tr>";
echo "<tr><td><font class=text12b>$pcrt_state</font></td><td><input type=text name=storestate size=10 value=\"$storestate\" class=textbox></td></tr>";
echo "<tr><td><font class=text12b>$pcrt_zip</font></td><td><input type=text name=storezip size=12 value=\"$storezip\" class=textbox></td></tr>";
echo "<tr><td><font class=text12b>".pcrtlang("Email")."</font></td><td><input type=text name=storeemail size=20 value=\"$storeemail\" class=textbox></td></tr>";
echo "<tr><td><font class=text12b>".pcrtlang("Phone")."</font></td><td><input type=text name=storephone size=15 value=\"$storephone\" class=textbox></td></tr>";
echo "<tr><td><font class=text12b>".pcrtlang("CC Email")."</font><br><font class=text10i>".pcrtlang("enter email address to have a copy of all emailed invoices, receipts, reports sent to or leave blank for none.")."</font></td><td><input type=text name=storeccemail size=15 value=\"$storeccemail\" class=textbox></td></tr>";
echo "<tr><td valign=top colspan=2><input type=submit value=\"".pcrtlang("Save Store")."\" class=button></form></td></tr>";
if ($storedefault != 1) {
echo "<tr><td valign=top colspan=2><form action=admin.php?func=storedisable method=post>";
echo "<input type=hidden name=storeid value=$storeid><input type=hidden name=storeenabled value=0>";
echo "<input type=submit value=\"".pcrtlang("Disable Store")."\" class=button></form></td></tr>";
}

if ($storedefault == 0) {
echo "<tr><td valign=top colspan=2><form action=admin.php?func=storesetdefault method=post>";
echo "<input type=hidden name=storeid value=$storeid>";
echo "<input type=submit value=\"".pcrtlang("Set as Default Store")."\" class=button></form></td></tr>";
}

} else {
echo "<tr><td valign=top colspan=2><form action=admin.php?func=storedisable method=post>";
echo "<input type=hidden name=storeid value=$storeid><input type=hidden name=storeenabled value=1>";
echo "<input type=submit value=\"".pcrtlang("Enable Store")."\" class=button></form></td></tr>";
}



echo "</table></td><td valign=top>";

start_box_nested();

if ($storeenabled == 1) {
echo "<table>";
echo "<tr><td valign=top><font class=text14b>".pcrtlang("Current Workareas").":</font></td><td><font class=text14b>".pcrtlang("Workarea Color")."</font></td><td colspan=2></td></tr>";
$rs_qb = "SELECT * FROM benches WHERE storeid = '$storeid'";
$rs_resultb = mysqli_query($rs_connect, $rs_qb);
while($rs_result_qb = mysqli_fetch_object($rs_resultb)) {
$benchid = "$rs_result_qb->benchid";
$benchname = "$rs_result_qb->benchname";
$benchcolor = "$rs_result_qb->benchcolor";


echo "<tr><td valign=top>";


echo "<form action=admin.php?func=benchsave method=post><input type=hidden name=benchid value=$benchid>";
echo "<input type=text name=benchname size=15 value=\"$benchname\" class=textbox></td><td><input type=text name=benchcolor size=6 value=\"$benchcolor\" 
class=\"textbox statusdrop\" style=\"background: #$benchcolor\">";
echo "</td><td valign=top><input type=submit value=\"&laquo;".pcrtlang("Save")."\" class=button></form></td><td valign=top><form action=admin.php?func=benchdelete method=post>";
echo "<input type=hidden name=benchid value=$benchid>";
echo "<input type=submit value=\"&laquo;".pcrtlang("Delete")."\" class=button></form></td></tr>";

}
echo "<tr><td colspan=4>&nbsp;</td></tr>";

echo "<tr><td valign=top><font class=text14b>".pcrtlang("Add Workarea").":</font></td><td><font class=text14b>".pcrtlang("Workarea Color")."</font></td><td colspan=2></td></tr>";
echo "<tr><td><form action=admin.php?func=benchadd method=post><input type=hidden name=benchstoreid value=$storeid>";
echo "<input type=text name=benchname size=15 value=\"\" class=textbox></td><td><input type=text name=benchcolor size=6 value=\"efefef\" class=\"textbox statusdrop\" style=\"background: #efefef;\">";
echo "</td><td><input type=submit value=\"&laquo;".pcrtlang("Add")."\" class=ibutton></form></td><td></td></tr>";
echo "</table>";
}

stop_box();
echo "<br><br>";
start_box_nested();
echo "<font class=text14b>".pcrtlang("Invoice Footer, Return Policy, Deposit Footer, Repair Report Footer, Quote Footer, Thank You Letter Text, Checkout Receipt")."</font><br><br>";
echo "<button onClick=\"parent.location='admin.php?func=editfootertext&storeid=$storeid'\" class=button>".pcrtlang("Manage")."</button><br>";
stop_box();

echo "<br><br>";
start_box_nested();
echo "<font class=text14b>".pcrtlang("Dymo Label Templates")."</font><br><br>";
echo "<button onClick=\"parent.location='admin.php?func=editdymotemp&storeid=$storeid'\" class=button>".pcrtlang("Manage")."</button><br>";
stop_box();


echo "<br><br>";
start_box_nested();
echo "<table><tr><td><font class=text12b>".pcrtlang("Menu Button").":</font></td><td><form action=admin.php?func=colorssave method=post><input type=hidden name=storeid value=$storeid>";
echo "<font style=\"background: #$linecolor1;width:30px;height:30px;\">&nbsp;&nbsp;&nbsp;&nbsp;</font><input type=text name=linecolor1 size=6 value=\"$linecolor1\" class=textbox \">";
echo "</td><td><font style=\"background: #$linecolor2;width:30px;height:30px;\">&nbsp;&nbsp;&nbsp;&nbsp;</font><input type=text name=linecolor2 size=6 value=\"$linecolor2\" class=textbox \"></td></tr>";
echo "<tr><td><font class=text12b>".pcrtlang("Background").":</font></td><td><font style=\"background: #$bgcolor1;width:30px;height:30px;\">&nbsp;&nbsp;&nbsp;&nbsp;</font><input type=text name=bgcolor1 size=6 value=\"$bgcolor1\" class=textbox \">";
echo "</td><td><font style=\"background: #$bgcolor2;width:30px;height:30px;\">&nbsp;&nbsp;&nbsp;&nbsp;</font><input type=text name=bgcolor2 size=6 value=\"$bgcolor2\" class=textbox \"></td></tr>";
echo "<tr><td></td><td valign=top colspan=2><input type=submit value=\"".pcrtlang("Save Interface Colors")."\" class=button></form>";
echo "<br><a href=\"admin.php?func=colorssave&storeid=$storeid&linecolor1=65FF00&linecolor2=439600&bgcolor1=b5bdc8&bgcolor2=28343b\">".pcrtlang("Default Colors")."</a> | ";
echo "<a href=\"admin.php?func=colorssave&storeid=$storeid&linecolor1=FF0000&linecolor2=6B0000&bgcolor1=ffffff&bgcolor2=28343b\">".pcrtlang("Red&Gray")."</a> | ";
echo "<a href=\"admin.php?func=colorssave&storeid=$storeid&linecolor1=898989&linecolor2=3D3D3D&bgcolor1=c8bc8d&bgcolor2=6D604D\">".pcrtlang("Black&Tan")."</a>";

echo "<br><a href=\"admin.php?func=colorssave&storeid=$storeid&linecolor1=e1a8ff&linecolor2=51007b&bgcolor1=ffc3fe&bgcolor2=ff39ce\">".pcrtlang("Purple&Pink")."</a> | ";
echo "<a href=\"admin.php?func=colorssave&storeid=$storeid&linecolor1=008aff&linecolor2=003e72&bgcolor1=c8bc8d&bgcolor2=6D604D\">".pcrtlang("Navy&Tan")."</a> | ";
echo "<a href=\"admin.php?func=colorssave&storeid=$storeid&linecolor1=ffde6c&linecolor2=ff9c00&bgcolor1=008aff&bgcolor2=003e72\">".pcrtlang("Orange&Blue")."</a>";

echo "<br><a href=\"admin.php?func=colorssave&storeid=$storeid&linecolor1=e5ff97&linecolor2=6f9300&bgcolor1=727272&bgcolor2=000000\">".pcrtlang("Lime&Black")."</a> | ";
echo "<a href=\"admin.php?func=colorssave&storeid=$storeid&linecolor1=ff97e0&linecolor2=ab0279&bgcolor1=fff6c3&bgcolor2=bcad5c\">".pcrtlang("Violet&Cream")."</a> | ";
echo "<a href=\"admin.php?func=colorssave&storeid=$storeid&linecolor1=e8e4d0&linecolor2=a6a081&bgcolor1=a69f7a&bgcolor2=473f13\">".pcrtlang("Tan&Brown")."</a>";

echo "<br><a href=\"admin.php?func=colorssave&storeid=$storeid&linecolor1=222222&linecolor2=222222&bgcolor1=999999&bgcolor2=999999\">".pcrtlang("Black&Gray")."</a> | ";
echo "<a href=\"admin.php?func=colorssave&storeid=$storeid&linecolor1=cccccc&linecolor2=cccccc&bgcolor1=ffffff&bgcolor2=ffffff\">".pcrtlang("Grey&White")."</a> | ";
echo "<a href=\"admin.php?func=colorssave&storeid=$storeid&linecolor1=aaaaaa&linecolor2=aaaaaa&bgcolor1=eeeeee&bgcolor2=eeeeee\">".pcrtlang("Dark Gray&Lt Gray")."</a>";

echo "<br><a href=\"admin.php?func=colorssave&storeid=$storeid&linecolor1=777777&linecolor2=777777&bgcolor1=222222&bgcolor2=222222\">".pcrtlang("Gray&Black")."</a> | ";
echo "<a href=\"admin.php?func=colorssave&storeid=$storeid&linecolor1=325FFF&linecolor2=325FFF&bgcolor1=222222&bgcolor2=222222\">".pcrtlang("Blue&Black")."</a> | ";
echo "<a href=\"admin.php?func=colorssave&storeid=$storeid&linecolor1=FF8132&linecolor2=FF8132&bgcolor1=222222&bgcolor2=222222\">".pcrtlang("Orange&Black")."</a>";

echo "<br><a href=\"admin.php?func=colorssave&storeid=$storeid&linecolor1=A4C400&linecolor2=A4C400&bgcolor1=8f8f8f&bgcolor2=8f8f8f\">".pcrtlang("Lime")."</a> | ";
echo "<a href=\"admin.php?func=colorssave&storeid=$storeid&linecolor1=0050EF&linecolor2=0050EF&bgcolor1=8f8f8f&bgcolor2=8f8f8f\">".pcrtlang("Blue")."</a> | ";
echo "<a href=\"admin.php?func=colorssave&storeid=$storeid&linecolor1=E3C800&linecolor2=E3C800&bgcolor1=8f8f8f&bgcolor2=8f8f8f\">".pcrtlang("Yellow")."</a>";

echo "</td></tr></table>";
stop_box();


echo "</td></tr></table>";
stop_blue_box();
echo "<br>";


}

start_blue_box(pcrtlang("Add New Store"));

echo "<table>";
echo "<tr><td valign=top><form action=admin.php?func=addstore method=post>";
echo "<font class=text12b>".pcrtlang("Store Short Name").":</font></td><td><input type=text name=storesname size=10 class=textbox></td></tr>";
echo "<tr><td><font class=text12b>".pcrtlang("Store/Business Name")."</font></td><td><input type=text name=storename size=25 class=textbox></td></tr>";
echo "<tr><td><font class=text12b>$pcrt_address1</font></td><td><input type=text name=storeaddy1 size=20 class=textbox></td></tr>";
echo "<tr><td><font class=text12b>$pcrt_address2</font></td><td><input type=text name=storeaddy2 size=20 class=textbox></td></tr>";
echo "<tr><td><font class=text12b>$pcrt_city</font></td><td><input type=text name=storecity size=10 class=textbox></td></tr>";
echo "<tr><td><font class=text12b>$pcrt_state</font></td><td><input type=text name=storestate size=10 class=textbox></td></tr>";
echo "<tr><td><font class=text12b>$pcrt_zip</font></td><td><input type=text name=storezip size=12 class=textbox></td></tr>";
echo "<tr><td><font class=text12b>".pcrtlang("Email")."</font></td><td><input type=text name=storeemail size=30 class=textbox></td></tr>";
echo "<tr><td><font class=text12b>".pcrtlang("Phone")."</font></td><td><input type=text name=storephone size=15 class=textbox></td></tr>";
echo "<tr><td valign=top colspan=2><input type=submit value=\"".pcrtlang("Add New Store")."\" class=button></form></td></tr>";
echo "</table>";

stop_blue_box();

require_once("footer.php");

}


function savestore() {
require_once("validate.php");

require_once("common.php");
require("deps.php");

if ($_COOKIE['username'] != "admin") {
die("admins only");
}


$storeid = $_REQUEST['storeid'];
$storesname = pv($_REQUEST['storesname']);
$storename = pv($_REQUEST['storename']);
$storeaddy1 = pv($_REQUEST['storeaddy1']);
$storeaddy2 = pv($_REQUEST['storeaddy2']);
$storecity = pv($_REQUEST['storecity']);
$storestate = pv($_REQUEST['storestate']);
$storezip = pv($_REQUEST['storezip']);
$storeemail = pv($_REQUEST['storeemail']);
$storeccemail = pv($_REQUEST['storeccemail']);
$storephone = pv($_REQUEST['storephone']);




mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "UPDATE stores SET storesname = '$storesname', storename = '$storename', storeaddy1 = '$storeaddy1', storeaddy2 = '$storeaddy2', storecity = '$storecity', storestate = '$storestate', storezip = '$storezip', storeemail = '$storeemail', storephone = '$storephone', ccemail = '$storeccemail'  WHERE storeid = '$storeid'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=stores");


}


function addstore() {
require_once("validate.php");

require_once("common.php");
require("deps.php");

if ($_COOKIE['username'] != "admin") {
die("admins only");
}

$storesname = pv($_REQUEST['storesname']);
$storename = pv($_REQUEST['storename']);
$storeaddy1 = pv($_REQUEST['storeaddy1']);
$storeaddy2 = pv($_REQUEST['storeaddy2']);
$storecity = pv($_REQUEST['storecity']);
$storestate = pv($_REQUEST['storestate']);
$storezip = pv($_REQUEST['storezip']);
$storeemail = pv($_REQUEST['storeemail']);
$storephone = pv($_REQUEST['storephone']);
$storeccemail = pv($_REQUEST['storeccemail']);



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "INSERT INTO stores (storesname,storename,storeaddy1,storeaddy2,storecity,storestate,storezip,storeemail,storephone,ccemail) VALUES ('$storesname', '$storename', '$storeaddy1', '$storeaddy2', '$storecity', '$storestate', '$storezip', '$storeemail', '$storephone','$storeccemail')";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=stores");


}



function storesetdefault() {
require_once("validate.php");

require_once("common.php");
require("deps.php");

if ($_COOKIE['username'] != "admin") {
die("admins only");
}

$storeid = $_REQUEST['storeid'];

require("deps.php");



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan2 = "UPDATE stores SET storedefault = '0'";
@mysqli_query($rs_connect, $rs_insert_scan2);
$rs_insert_scan = "UPDATE stores SET storedefault = '1' WHERE storeid = '$storeid'";
@mysqli_query($rs_connect, $rs_insert_scan);
header("Location: admin.php?func=stores");


}


function storedisable() {
require_once("validate.php");

require_once("common.php");
require("deps.php");

if ($_COOKIE['username'] != "admin") {
die("admins only");
}

$storeid = $_REQUEST['storeid'];
$storeenabled = $_REQUEST['storeenabled'];

require("deps.php");



mysqli_query($rs_connect, "SET NAMES 'utf8'");

if ($storeenabled == 0) {
$checkstoresql = "SELECT * FROM stores WHERE storeenabled = '1' AND storeid != '$storeid'";
$rs_results_c = mysqli_query($rs_connect, $checkstoresql);
$totalstores = mysqli_num_rows($rs_results_c);
if ($totalstores == "0") {
die("Sorry, you cannot disable the only active store");
}

$findactivestore = "SELECT * FROM stores WHERE storeenabled = '1' AND storeid != '$storeid' LIMIT 1";
$rs_results_fa = mysqli_query($rs_connect, $findactivestore);
$rs_result_fa1 = mysqli_fetch_object($rs_results_fa);
$fstoreid = "$rs_result_fa1->storeid";
$rs_update_users = "UPDATE users SET defaultstore = '$fstoreid' WHERE defaultstore = '$storeid'";
@mysqli_query($rs_connect, $rs_update_users);

}

$rs_insert_scan = "UPDATE stores SET storeenabled = '$storeenabled' WHERE storeid = '$storeid'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=stores");


}


function setuserdefaultstore() {
require_once("validate.php");

$setuserdefaultstore = $_REQUEST['setuserdefaultstore'];

$ruri = $_SERVER['HTTP_REFERER'];
if ($ruri == "") {
$ruri2 = "../repairmobile/admin.php";
} elseif (preg_match("/repair\//i", $ruri)) {
$ruri2 = "../repairmobile";
} else {
$ruri2 = "../storemobile";
}


require("deps.php");



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "UPDATE users SET defaultstore = '$setuserdefaultstore' WHERE username = '$ipofpc'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: $ruri2");

}


function benchsave() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ($_COOKIE['username'] != "admin") {
die("admins only");
}

$benchid = $_REQUEST['benchid'];
$benchname = pv($_REQUEST['benchname']);
$benchcolor = $_REQUEST['benchcolor'];



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "UPDATE benches SET benchname = '$benchname', benchcolor = '$benchcolor' WHERE benchid = '$benchid'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=stores");

}


function benchdelete() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ($_COOKIE['username'] != "admin") {
die("admins only");
}

$benchid = $_REQUEST['benchid'];



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "DELETE FROM benches WHERE benchid = '$benchid'";
@mysqli_query($rs_connect, $rs_insert_scan);
header("Location: admin.php?func=stores");

}

function benchadd() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ($_COOKIE['username'] != "admin") {
die("admins only");
}


$benchstoreid = pv($_REQUEST['benchstoreid']);
$benchname = pv($_REQUEST['benchname']);
$benchcolor = pv($_REQUEST['benchcolor']);



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "INSERT INTO benches (benchname,benchcolor,storeid) VALUES ('$benchname','$benchcolor','$benchstoreid')";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=stores");

}


function reorderquicklabor() {
require_once("validate.php");

$qlid = $_REQUEST['qlid'];
$dir = $_REQUEST['dir'];
$theorder = $_REQUEST['theorder'];

require("deps.php");
require_once("common.php");
perm_boot("2");



mysqli_query($rs_connect, "SET NAMES 'utf8'");

if ($dir == "up") {
$rs_sq = "SELECT * FROM quicklabor WHERE theorder > '$theorder' ORDER BY theorder ASC LIMIT 1";
} else {
$rs_sq = "SELECT * FROM quicklabor WHERE theorder < '$theorder' ORDER BY theorder DESC LIMIT 1";
}

$rs_result1 = mysqli_query($rs_connect, $rs_sq);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
if(mysqli_num_rows($rs_result1) == "0") {
$nextorder = "$theorder";
} else {
$nextorder = "$rs_result_q1->theorder";
}


if ($dir == "up") {
$neworder = $nextorder + 1;
} else {
$neworder = $nextorder -1;
}

$rs_insert_scan = "UPDATE quicklabor SET theorder = '$neworder' WHERE quickid = $qlid";
@mysqli_query($rs_connect, $rs_insert_scan);


$rs_resetorder = "SELECT * FROM quicklabor ORDER BY theorder ASC";
$rs_resultreset = mysqli_query($rs_connect, $rs_resetorder);
$a = 0;
while($rs_result_r1 = mysqli_fetch_object($rs_resultreset)) {
$qlid = "$rs_result_r1->quickid";
$rs_set_order = "UPDATE quicklabor SET theorder = '$a' WHERE quickid = $qlid";
@mysqli_query($rs_connect, $rs_set_order);
$a = $a + 5;
}


header("Location: admin.php?func=quicklabor");


}


function editfootertext() {
require("header.php");
require_once("common.php");
require("deps.php");

if ($_COOKIE['username'] != "admin") {
die("admins only");
}

$rs_storeid = $_REQUEST['storeid'];


$storeinfoarray = getstoreinfo($rs_storeid);
echo "<form action=admin.php?func=editfootertext2 method=post><input type=hidden name=storeid value=\"$rs_storeid\">";

echo "<font class=text16bu>".pcrtlang("Edit Footer Texts for Store").": $storeinfoarray[storesname]</font><br><br>";

start_box();
echo "<a href=admin.php?func=stores>".pcrtlang("Return to Store Admin")."</a>";
stop_box();

echo "<br><br>";

start_blue_box(pcrtlang("Quote Footer Text"));
echo "<textarea name=quotefooter class=textboxw style=\"width:97%\" rows=1>$storeinfoarray[quotefooter]</textarea>";
stop_blue_box();
echo "<br><br>";

start_blue_box(pcrtlang("Invoice Footer Text"));
echo "<textarea name=invoicefooter class=textboxw style=\"width:97%\" rows=1>$storeinfoarray[invoicefooter]</textarea>";
stop_blue_box();
echo "<br><br>";

start_blue_box(pcrtlang("Repair Report Footer Text"));
echo "<textarea name=repairsheetfooter class=textboxw style=\"width:97%\" rows=1>$storeinfoarray[repairsheetfooter]</textarea>";
stop_blue_box();
echo "<br><br>";

start_blue_box(pcrtlang("Return Policy/Receipt Footer Text"));
echo "<textarea name=returnpolicy class=textboxw style=\"width:97%\" rows=1>$storeinfoarray[returnpolicy]</textarea>";
stop_blue_box();
echo "<br><br>";

start_blue_box(pcrtlang("Deposit Footer Text"));
echo "<textarea name=depositfooter class=textboxw style=\"width:97%\" rows=1>$storeinfoarray[depositfooter]</textarea>";
stop_blue_box();
echo "<br><br>";

start_blue_box(pcrtlang("Thank You Letter Text"));
echo "<textarea name=thankyouletter class=textboxw style=\"width:97%\" rows=1>$storeinfoarray[thankyouletter]</textarea>";
stop_blue_box();
echo "<br><br>";

start_blue_box(pcrtlang("Claim Ticket Text"));
echo "<textarea name=claimticket class=textboxw style=\"width:97%\" rows=1>$storeinfoarray[claimticket]</textarea>";
stop_blue_box();
echo "<br><br>";

start_blue_box(pcrtlang("Checkout Receipt Text"));
echo "<textarea name=checkoutreceipt class=textboxw style=\"width:97%\" rows=1>$storeinfoarray[checkoutreceipt]</textarea>";
stop_blue_box();
echo "<br><br>";


?>

<script type='text/javascript' src='jq/jquery.autogrow-textarea.js'></script>
<script type='text/javascript'>
  $(function() {
    $('textarea').autogrow();
  });
</script>
<?php

echo "<input type=submit value=\"".pcrtlang("Save")."\" class=button></form><br><br>";

start_box();
echo "<font class=text12>".pcrtlang("Feel free to use html markup or any styles from the style.css stylesheet. Common stock styles are text10, text10b, text10i, text12 and text12b")."</font>";

echo "<br><br><font class=text12>".pcrtlang("You can also surround areas of text with a div tag and adjusted line-height to cram more text onto the page like this:")."</font><br><br>";
echo "<font class=text12>".htmlentities("<div style=\"line-height:70%;\">My Text</div>")."</font>";

stop_box();
require_once("footer.php");

}


function editfootertext2() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ($_COOKIE['username'] != "admin") {
die("admins only");
}

$storeid = $_REQUEST['storeid'];
$quotefooter = pv($_REQUEST['quotefooter']);
$invoicefooter = pv($_REQUEST['invoicefooter']);
$repairsheetfooter = pv($_REQUEST['repairsheetfooter']);
$returnpolicy = pv($_REQUEST['returnpolicy']);
$depositfooter = pv($_REQUEST['depositfooter']);
$thankyouletter = pv($_REQUEST['thankyouletter']);
$claimticket = pv($_REQUEST['claimticket']);
$checkoutreceipt = pv($_REQUEST['checkoutreceipt']);



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_text = "UPDATE stores SET quotefooter = '$quotefooter', invoicefooter = '$invoicefooter', repairsheetfooter = '$repairsheetfooter', returnpolicy = '$returnpolicy', depositfooter = '$depositfooter', thankyouletter = '$thankyouletter', claimticket = '$claimticket', checkoutreceipt = '$checkoutreceipt' WHERE storeid = '$storeid'";
@mysqli_query($rs_connect, $rs_insert_text);

header("Location: admin.php?func=editfootertext&storeid=$storeid");

}


function frameit() {
require("header.php");
require_once("common.php");
require("deps.php");



mysqli_query($rs_connect, "SET NAMES 'utf8'");

start_blue_box(pcrtlang("Manage External Framed Tools"));
echo "<table>";
$rs_ql = "SELECT * FROM frameit";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$frameitid = "$rs_result_q1->frameitid";
$frameitname = "$rs_result_q1->frameitname";
$frameiturl = "$rs_result_q1->frameiturl";

echo "<tr><td valign=top><form action=admin.php?func=frameitsave method=post><input type=hidden name=frameitid value=$frameitid>";

echo "<input type=text name=frameitname size=30 value=\"$frameitname\" class=textbox><input type=text name=frameiturl size=30 value=\"$frameiturl\" class=textbox>";
echo "</td><td valign=top><input type=submit value=\"&laquo;".pcrtlang("Save")."\" class=button></form></td><td valign=top><form action=admin.php?func=frameitdelete method=post>";
echo "<input type=hidden name=frameitid value=$frameitid>";
echo "<input type=submit value=\"&laquo;".pcrtlang("Delete")."\" class=button></form></td></tr>";

}
echo "</table>";

echo "<font class=text14b>".pcrtlang("Add").":</font><br>";
echo "<form action=admin.php?func=frameitadd method=post>";
echo "<input type=text name=frameitname size=30 value=\"\" class=textbox><input type=text name=frameiturl size=30 value=\"\" class=textbox class=textbox>";
echo "<input type=submit value=\"&laquo;".pcrtlang("Add")."\" class=ibutton></form>";

stop_blue_box();

require_once("footer.php");

}


function frameitsave() {
require_once("validate.php");

require("deps.php");
require("common.php");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}

$frameitid = $_REQUEST['frameitid'];
$frameitname = pv($_REQUEST['frameitname']);
$frameiturl = pv($_REQUEST['frameiturl']);



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "UPDATE frameit SET frameitname = '$frameitname', frameiturl = '$frameiturl' WHERE frameitid = '$frameitid'";
@mysqli_query($rs_connect, $rs_insert_scan);
header("Location: admin.php?func=frameit");


}

function frameitdelete() {
require_once("validate.php");

require("deps.php");
require("common.php");

$frameitid = $_REQUEST['frameitid'];

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "DELETE FROM frameit WHERE frameitid = '$frameitid'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=frameit");

}



function frameitadd() {
require_once("validate.php");

require("deps.php");
require("common.php");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}

$frameitname = pv($_REQUEST['frameitname']);
$frameiturl = pv($_REQUEST['frameiturl']);



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "INSERT INTO frameit (frameitname,frameiturl) VALUES ('$frameitname','$frameiturl')";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=frameit");


}



function colorssave() {
require_once("validate.php");

require("deps.php");
require("common.php");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}

$storeid = $_REQUEST['storeid'];
$linecolor1 = pv($_REQUEST['linecolor1']);
$linecolor2 = pv($_REQUEST['linecolor2']);
$bgcolor1 = pv($_REQUEST['bgcolor1']);
$bgcolor2 = pv($_REQUEST['bgcolor2']);



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "UPDATE stores SET linecolor1 = '$linecolor1', linecolor2 = '$linecolor2', bgcolor1 = '$bgcolor1', bgcolor2 = '$bgcolor2' 
WHERE storeid = '$storeid'";
@mysqli_query($rs_connect, $rs_insert_scan);
header("Location: admin.php?func=stores");


}



function showtechdoccats() {

require("header.php");
require_once("common.php");
require("deps.php");


if ($_COOKIE['username'] != "admin") {
die("admins only");
}




mysqli_query($rs_connect, "SET NAMES 'utf8'");

$boxtitle = pcrtlang("Technical Document Categories");

start_blue_box("$boxtitle");


echo "<table>";

echo "<tr><td><font class=text14bu>".pcrtlang("Category Name")."</font></td><td></td></tr>";

$rs_sq = "SELECT * FROM techdocs ORDER BY techdoccatname ASC";
$rs_result1 = mysqli_query($rs_connect, $rs_sq);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$techdoccatid = "$rs_result_q1->techdoccatid";
$techdoccatname = "$rs_result_q1->techdoccatname";

$checkdocs =  "SELECT * FROM attachments WHERE attach_cat='$techdoccatid'";
$rs_result_chk = mysqli_query($rs_connect, $checkdocs);
$totaldocs = mysqli_num_rows($rs_result_chk);

$techdoccatname2 = urlencode("$techdoccatname");

echo "<tr><td>";
echo "<font class=text12b> $techdoccatname </font></td><td><a href=admin.php?func=edittechdoccat&techdoccatid=$techdoccatid&techdoccatname=$techdoccatname2>".pcrtlang("edit")."</a> <font class=text12b>|</font> ";
if ($totaldocs == "0") {
echo "<a href=admin.php?func=deletetechdoccat&techdoccatid=$techdoccatid>".pcrtlang("delete")."</a>";
} 

echo "</td></tr>";
}
echo "</table>";

echo "<br><font class=text12b>".pcrtlang("Add New Technical Document Category")."</font><br>";

echo "<form method=post action=\"admin.php?func=addtechdoccat\"><input type=text class=textbox name=techdoccatname size=30><input class=button type=submit value=\"".pcrtlang("Add")."\"></form>";

stop_blue_box();
echo "<br><br>";

require_once("footer.php");

}



function addtechdoccat() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ($_COOKIE['username'] != "admin") {
die("admins only");
}

$techdoccatname = pv($_REQUEST['techdoccatname']);



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_tdc = "INSERT INTO techdocs (techdoccatname) VALUES ('$techdoccatname')";
@mysqli_query($rs_connect, $rs_insert_tdc);

header("Location: admin.php?func=showtechdoccats");


}


function deletetechdoccat() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ($_COOKIE['username'] != "admin") {
die("admins only");
}

$techdoccatid = $_REQUEST['techdoccatid'];



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_delete_tdc = "DELETE FROM techdocs WHERE techdoccatid = '$techdoccatid'";
@mysqli_query($rs_connect, $rs_delete_tdc);

header("Location: admin.php?func=showtechdoccats");


}


function edittechdoccat() {
require("header.php");
require_once("common.php");
require("deps.php");

if ($_COOKIE['username'] != "admin") {
die("admins only");
}

$techdoccatid = $_REQUEST['techdoccatid'];
$techdoccatname = $_REQUEST['techdoccatname'];

echo "<form action=admin.php?func=edittechdoccat2 method=post><input type=hidden name=techdoccatid value=\"$techdoccatid\">";

start_blue_box(pcrtlang("Edit Technical Document Category Name"));
echo ": <input type=text name=techdoccatname class=textbox cols=40 value=\"$techdoccatname\"><input type=submit class=button value=\"".pcrtlang("Save")."\"></form>";
stop_blue_box();
echo "<br><br>";

require_once("footer.php");

}

function edittechdoccat2() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ($_COOKIE['username'] != "admin") {
die("admins only");
}

$techdoccatname = pv($_REQUEST['techdoccatname']);
$techdoccatid = $_REQUEST['techdoccatid'];



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_update_tdc = "UPDATE techdocs SET techdoccatname = '$techdoccatname' WHERE techdoccatid = '$techdoccatid'";
@mysqli_query($rs_connect, $rs_update_tdc);


header("Location: admin.php?func=showtechdoccats");


}

function smstext() {
require("header.php");
require_once("common.php");
require("deps.php");

perm_boot("13");



mysqli_query($rs_connect, "SET NAMES 'utf8'");

start_blue_box(pcrtlang("Manage SMS Default Texts"));
echo "<table>";
$rs_ql = "SELECT * FROM smstext ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$smstextid = "$rs_result_q1->smstextid";
$smstext = "$rs_result_q1->smstext";
$theorder = "$rs_result_q1->theorder";

echo "<tr><td><form action=admin.php?func=smstextsave method=post><input type=hidden name=smstextid value=$smstextid>";

echo "<a href=admin.php?func=reordersmstext&stid=$smstextid&dir=up&theorder=$theorder class=imagelink><img src=images/up.png border=0></a>";
echo " <a href=admin.php?func=reordersmstext&stid=$smstextid&dir=down&theorder=$theorder class=imagelink><img src=images/down.png border=0></a>";
echo "</td><td><textarea name=smstext rows=3 cols=50 class=textbox>$smstext</textarea>";
echo "</td><td><input type=submit value=\"&laquo;".pcrtlang("Save")."\" class=button></form></td><td><form action=admin.php?func=smstextdelete method=post>";
echo "<input type=hidden name=smstextid value=$smstextid>";
echo "<input type=submit value=\"&laquo;".pcrtlang("Delete")."\" class=button></form></td></tr>";
 
} 
 
echo "</table>";

echo "<font class=text14b>".pcrtlang("Add").":</font><br>";
echo "<form action=admin.php?func=smstextadd method=post>";
echo "<textarea name=smstext rows=3 cols=50 value=\"\" class=textbox></textarea>";
echo "<input type=submit value=\"&laquo;".pcrtlang("Add")."\" class=ibutton></form>";

stop_blue_box();

require_once("footer.php");

}


function smstextsave() {
require_once("validate.php");

require("deps.php");
require("common.php");

perm_boot("13");

$smstextid = $_REQUEST['smstextid'];
$smstext = pv($_REQUEST['smstext']);



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_sms = "UPDATE smstext SET smstext = '$smstext' WHERE smstextid = '$smstextid'";
@mysqli_query($rs_connect, $rs_insert_sms);

header("Location: admin.php?func=smstext");
}

function smstextdelete() {
require_once("validate.php");
  
require("deps.php");
require("common.php");

$smstextid = $_REQUEST['smstextid'];

perm_boot("13");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_find_st = "SELECT * FROM smstext WHERE smstextid = '$smstextid'";
$rs_find_stq = mysqli_query($rs_connect, $rs_find_st);

$totresult = mysqli_num_rows($rs_find_stq);

if ($totresult == "1") {
$rs_dst = "DELETE FROM smstext WHERE smstextid = '$smstextid'";
@mysqli_query($rs_connect, $rs_dst);
header("Location: admin.php?func=smstext");
} else {
die("Protection Error");
}

}



function smstextadd() {
require_once("validate.php");
require("deps.php");
require("common.php");

perm_boot("13");

$smstext = pv($_REQUEST['smstext']);



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_sms = "INSERT INTO smstext (smstext) VALUES ('$smstext')";
@mysqli_query($rs_connect, $rs_insert_sms);

header("Location: admin.php?func=smstext"); 

 
}

function reordersmstext() {
require_once("validate.php");

$stid = $_REQUEST['stid'];
$dir = $_REQUEST['dir'];
$theorder = $_REQUEST['theorder'];

require("deps.php");
require_once("common.php");
perm_boot("13");



mysqli_query($rs_connect, "SET NAMES 'utf8'");

if ($dir == "up") {
$rs_sq = "SELECT * FROM smstext WHERE theorder > '$theorder' ORDER BY theorder ASC LIMIT 1";
} else {
$rs_sq = "SELECT * FROM smstext WHERE theorder < '$theorder' ORDER BY theorder DESC LIMIT 1";
}

$rs_result1 = mysqli_query($rs_connect, $rs_sq);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
if(mysqli_num_rows($rs_result1) == "0") {
$nextorder = "$theorder";
} else {
$nextorder = "$rs_result_q1->theorder";
}


if ($dir == "up") {
$neworder = $nextorder + 1;
} else {
$neworder = $nextorder -1;
}

$rs_change_order = "UPDATE smstext SET theorder = '$neworder' WHERE smstextid = $stid";
@mysqli_query($rs_connect, $rs_change_order);
 

$rs_resetorder = "SELECT * FROM smstext ORDER BY theorder ASC";
$rs_resultreset = mysqli_query($rs_connect, $rs_resetorder);
$a = 0;
while($rs_result_r1 = mysqli_fetch_object($rs_resultreset)) {
$smstid = "$rs_result_r1->smstextid";
$rs_set_order = "UPDATE smstext SET theorder = '$a' WHERE smstextid = $smstid";
@mysqli_query($rs_connect, $rs_set_order);
$a = $a + 5;
}


header("Location: admin.php?func=smstext");


}


function makehash() {
require_once("validate.php");
require("deps.php");
require("common.php");

if ($_COOKIE['username'] != "admin") {
die("admins only");
}

$storehash = sha1(time().mt_rand());



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_sms = "UPDATE stores SET storehash ='$storehash' WHERE storeid = '$defaultuserstore'";
@mysqli_query($rs_connect, $rs_insert_sms);

header("Location: admin.php");

}


function statusstyles() {
require("header.php");
require_once("common.php");
require("deps.php");

if ($_COOKIE['username'] != "admin") {
die("admins only");
}

require("defaultstyles.php");



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$thestatii = array("1" => "Waiting for Bench", "2" => "On the Bench", "3" => "Pending / On Hold", "4" => "Completed/Ready for Pickup", "5" => "Picked up by Customer", "6" => "Waiting for Payment", "7" => "Ready to Sell", "8" => "On Service Call", "9" => "Remote Support Sessions", "50" => "Standard Title Boxes", "51" => "Standard Inventory Title Boxes", "52" => "Invoice List Box", "53" => "Overdue Invoice Box");

start_box();
echo "<center><font class=text12b>".pcrtlang("Standard Status Styles")."</font> | <a href=admin.php?func=customstatusstyles class=boldlink>".pcrtlang("Go to Custom Status Styles")."</a></center>";
stop_box();

foreach($thestatii as $k => $v) {

$rs_gets2 = "SELECT * FROM boxstyles WHERE statusid = '$k'";
$rs_results2 = mysqli_query($rs_connect, $rs_gets2);
$rs_result_qs2 = mysqli_fetch_object($rs_results2);
$headerstyle2 = "$rs_result_qs2->headerstyle";
$bodystyle2 = "$rs_result_qs2->bodystyle";
$selectorcolor2 = "$rs_result_qs2->selectorcolor";
$floaterstyle2 = "$rs_result_qs2->floaterstyle";
$boxtitle2 = "$rs_result_qs2->boxtitle";

echo "<a name=g$k></a><br><br><br><div class=\"colortitletopround\" style=\"$headerstyle2\"><font class=textwhite16b>$v</font></div>";
echo "<div class=\"whitebottom\" style=\"$bodystyle2\">";

echo "<table style=\"width:100%\"><tr><td><font class=text12b>".pcrtlang("For Light Stylesheets").":</font></td><td>";
echo "<form action=admin.php?func=statusstylessave method=post><input type=hidden name=statusid value=$k><input type=hidden name=headerstyle value=\"$origheaderstyle[$k]\">";
echo "<input type=hidden name=bodystyle value=\"$origbodystyle[$k]\"><input type=hidden name=floaterstyle value=\"$origfloaterstyle[$k]\">";
echo "<input type=hidden name=boxtitle value=\"$boxtitle2\"><input type=hidden name=selectorcolor value=\"$origselectorcolor[$k]\">";
echo "<input type=submit class=button value=\" ".pcrtlang("Original")." \" style=\"padding:2px;\"></form>";
echo "</td><td>";
echo "<form action=admin.php?func=statusstylessave method=post><input type=hidden name=statusid value=$k><input type=hidden name=headerstyle value=\"$pdheaderstyle[$k]\">";
echo "<input type=hidden name=bodystyle value=\"$pdbodystyle[$k]\"><input type=hidden name=floaterstyle value=\"$pdfloaterstyle[$k]\">";
echo "<input type=hidden name=boxtitle value=\"$boxtitle2\"><input type=hidden name=selectorcolor value=\"$pdselectorcolor[$k]\">";
echo "<input type=submit class=button value=\" ".pcrtlang("Dk Simple")." \" style=\"padding:2px;\"></form>";
echo "</td>";
echo "<td><form action=admin.php?func=statusstylessave method=post><input type=hidden name=statusid value=$k><input type=hidden name=headerstyle value=\"$plheaderstyle[$k]\">";
echo "<input type=hidden name=bodystyle value=\"$plbodystyle[$k]\"><input type=hidden name=floaterstyle value=\"$plfloaterstyle[$k]\">";
echo "<input type=hidden name=boxtitle value=\"$boxtitle2\"><input type=hidden name=selectorcolor value=\"$plselectorcolor[$k]\">";
echo "<input type=submit class=button value=\" ".pcrtlang("Lt Simple")." \" style=\"padding:2px;\"></form></td>";

echo "<td><form action=admin.php?func=statusstylessave method=post><input type=hidden name=statusid value=$k><input type=hidden name=headerstyle value=\"$barheaderstyle[$k]\">";
echo "<input type=hidden name=bodystyle value=\"$barbodystyle[$k]\"><input type=hidden name=floaterstyle value=\"$barfloaterstyle[$k]\">";
echo "<input type=hidden name=boxtitle value=\"$boxtitle2\"><input type=hidden name=selectorcolor value=\"$barselectorcolor[$k]\">";
echo "<input type=submit class=button value=\" ".pcrtlang("Bar")." \" style=\"padding:2px;\"></form></td>";

echo "<td><form action=admin.php?func=statusstylessave method=post><input type=hidden name=statusid value=$k><input type=hidden name=headerstyle value=\"$glowheaderstyle[$k]\">";
echo "<input type=hidden name=bodystyle value=\"$glowbodystyle[$k]\"><input type=hidden name=floaterstyle value=\"$glowfloaterstyle[$k]\">";
echo "<input type=hidden name=boxtitle value=\"$boxtitle2\"><input type=hidden name=selectorcolor value=\"$glowselectorcolor[$k]\">";
echo "<input type=submit class=button value=\" ".pcrtlang("Glow")." \" style=\"padding:2px;\"></form></td>";

echo "<td><form action=admin.php?func=statusstylessave method=post><input type=hidden name=statusid value=$k><input type=hidden name=headerstyle value=\"$gradheaderstyle[$k]\">";
echo "<input type=hidden name=bodystyle value=\"$gradbodystyle[$k]\"><input type=hidden name=floaterstyle value=\"$gradfloaterstyle[$k]\">";
echo "<input type=hidden name=boxtitle value=\"$boxtitle2\"><input type=hidden name=selectorcolor value=\"$gradselectorcolor[$k]\">";
echo "<input type=submit class=button value=\" ".pcrtlang("Gradient")." \" style=\"padding:2px;\"></form></td>";

echo "<td><form action=admin.php?func=statusstylessave method=post><input type=hidden name=statusid value=$k><input type=hidden name=headerstyle value=\"$flatheaderstyle[$k]\">";
echo "<input type=hidden name=bodystyle value=\"$flatbodystyle[$k]\"><input type=hidden name=floaterstyle value=\"$flatfloaterstyle[$k]\">";
echo "<input type=hidden name=boxtitle value=\"$boxtitle2\"><input type=hidden name=selectorcolor value=\"$flatselectorcolor[$k]\">";
echo "<input type=submit class=button value=\" ".pcrtlang("Flat")." \" style=\"padding:2px;\"></form></td>";
echo "</tr></table>";


echo "<table style=\"width:100%\"><tr><td><font class=text12b>".pcrtlang("For Dark Stylesheets").":</font></td><td>";
echo "<form action=admin.php?func=statusstylessave method=post><input type=hidden name=statusid value=$k><input type=hidden name=headerstyle value=\"$origondarkheaderstyle[$k]\">";
echo "<input type=hidden name=bodystyle value=\"$origondarkbodystyle[$k]\"><input type=hidden name=floaterstyle value=\"$origondarkfloaterstyle[$k]\">";
echo "<input type=hidden name=boxtitle value=\"$boxtitle2\"><input type=hidden name=selectorcolor value=\"$origondarkselectorcolor[$k]\">";
echo "<input type=submit class=button value=\" ".pcrtlang("Original")." \" style=\"padding:2px;\"></form>";
echo "</td><td>";
echo "<form action=admin.php?func=statusstylessave method=post><input type=hidden name=statusid value=$k><input type=hidden name=headerstyle value=\"$pdondarkheaderstyle[$k]\">";
echo "<input type=hidden name=bodystyle value=\"$pdondarkbodystyle[$k]\"><input type=hidden name=floaterstyle value=\"$pdondarkfloaterstyle[$k]\">";
echo "<input type=hidden name=boxtitle value=\"$boxtitle2\"><input type=hidden name=selectorcolor value=\"$pdondarkselectorcolor[$k]\">";
echo "<input type=submit class=button value=\" ".pcrtlang("Dk Simple")." \" style=\"padding:2px;\"></form>";
echo "</td>";
echo "<td><form action=admin.php?func=statusstylessave method=post><input type=hidden name=statusid value=$k><input type=hidden name=headerstyle value=\"$plondarkheaderstyle[$k]\">";
echo "<input type=hidden name=bodystyle value=\"$plondarkbodystyle[$k]\"><input type=hidden name=floaterstyle value=\"$plondarkfloaterstyle[$k]\">";
echo "<input type=hidden name=boxtitle value=\"$boxtitle2\"><input type=hidden name=selectorcolor value=\"$plondarkselectorcolor[$k]\">";
echo "<input type=submit class=button value=\" ".pcrtlang("Lt Simple")." \" style=\"padding:2px;\"></form></td>";

echo "<td><form action=admin.php?func=statusstylessave method=post><input type=hidden name=statusid value=$k><input type=hidden name=headerstyle value=\"$barondarkheaderstyle[$k]\">";
echo "<input type=hidden name=bodystyle value=\"$barondarkbodystyle[$k]\"><input type=hidden name=floaterstyle value=\"$barondarkfloaterstyle[$k]\">";
echo "<input type=hidden name=boxtitle value=\"$boxtitle2\"><input type=hidden name=selectorcolor value=\"$barondarkselectorcolor[$k]\">";
echo "<input type=submit class=button value=\" ".pcrtlang("Bar")." \" style=\"padding:2px;\"></form></td>";

echo "<td><form action=admin.php?func=statusstylessave method=post><input type=hidden name=statusid value=$k><input type=hidden name=headerstyle value=\"$glowondarkheaderstyle[$k]\">";
echo "<input type=hidden name=bodystyle value=\"$glowondarkbodystyle[$k]\"><input type=hidden name=floaterstyle value=\"$glowondarkfloaterstyle[$k]\">";
echo "<input type=hidden name=boxtitle value=\"$boxtitle2\"><input type=hidden name=selectorcolor value=\"$glowondarkselectorcolor[$k]\">";
echo "<input type=submit class=button value=\" ".pcrtlang("Glow")." \" style=\"padding:2px;\"></form></td>";

echo "<td><form action=admin.php?func=statusstylessave method=post><input type=hidden name=statusid value=$k><input type=hidden name=headerstyle value=\"$gradondarkheaderstyle[$k]\">";
echo "<input type=hidden name=bodystyle value=\"$gradondarkbodystyle[$k]\"><input type=hidden name=floaterstyle value=\"$gradondarkfloaterstyle[$k]\">";
echo "<input type=hidden name=boxtitle value=\"$boxtitle2\"><input type=hidden name=selectorcolor value=\"$gradondarkselectorcolor[$k]\">";
echo "<input type=submit class=button value=\" ".pcrtlang("Gradient")." \" style=\"padding:2px;\"></form></td>";

echo "<td><form action=admin.php?func=statusstylessave method=post><input type=hidden name=statusid value=$k><input type=hidden name=headerstyle value=\"$flatondarkheaderstyle[$k]\">";
echo "<input type=hidden name=bodystyle value=\"$flatondarkbodystyle[$k]\"><input type=hidden name=floaterstyle value=\"$flatondarkfloaterstyle[$k]\">";
echo "<input type=hidden name=boxtitle value=\"$boxtitle2\"><input type=hidden name=selectorcolor value=\"$flatondarkselectorcolor[$k]\">";
echo "<input type=submit class=button value=\" ".pcrtlang("Flat")." \" style=\"padding:2px;\"></form></td>";
echo "</tr></table>";




echo "<table style=\"width:100%\">";
echo "<tr><td valign=top colspan=2><form action=admin.php?func=statusstylessave method=post><input type=hidden name=statusid value=$k>";
echo "<font class=text12b>".pcrtlang("Status Header Style").":</font></td></tr><tr><td colspan=2><textarea name=headerstyle rows=1 style=\"width:97%\" class=textbox>$headerstyle2</textarea></td></tr>";
echo "<tr><td colspan=2><font class=text12b>".pcrtlang("Status Body Style").":</font></td></tr><tr><td colspan=2><textarea name=bodystyle rows=1 style=\"width:97%\" class=textbox>$bodystyle2</textarea></td></tr>";
echo "<tr><td colspan=2><font class=text12b>".pcrtlang("Hover Info Style").":</font>";
echo "<a href=# class=\"hover$k statuslink\">".pcrtlang("Example")."<span><font class=text12heading style=\"background:#$selectorcolor2\">".pcrtlang("Example").":</font><br><br>".pcrtlang("Please save changes to see updated look")."</span></a>";
echo "</td></tr><tr><td colspan=2><textarea name=floaterstyle rows=1 style=\"width:97%\" class=textbox>$floaterstyle2</textarea>";

echo "</td></tr>";

if ($k < 50) {
echo "<tr><td><font class=text12b>".pcrtlang("Custom Box Title").":</font></td><td>";
echo "<input type=text name=boxtitle class=textbox value=\"$boxtitle2\"></td></tr>";
echo "<tr><td><font class=text12b>".pcrtlang("Selector Background Color").":</font></td><td><font style=\"background: #$selectorcolor2;width:30px;height:30px;\">&nbsp;&nbsp;&nbsp;&nbsp;</font><input type=text name=selectorcolor value=\"$selectorcolor2\" class=textbox></td></tr>";
} else {
echo "<input type=hidden name=boxtitle value=\"$boxtitle2\"><input type=hidden name=selectorcolor value=\"$selectorcolor2\">";
}

echo "<tr><td><input type=submit value=\"^".pcrtlang("Save")."^\" class=button></form></td><td>";

echo "</td></tr>";
echo "</table></div>";

echo "<br><br>";

}

?>
<script type='text/javascript' src='jq/jquery.autogrow-textarea.js'></script>
<script type='text/javascript'>
  $(function() {
    $('textarea').autogrow();
  });
</script>
<?php



require_once("footer.php");

}


function statusstylessave() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ($ipofpc != "admin") {
die("Admins Only");
}

$statusid = $_REQUEST['statusid'];
$headerstyle = pv($_REQUEST['headerstyle']);
$bodystyle = pv($_REQUEST['bodystyle']);
$selectorcolor = pv($_REQUEST['selectorcolor']);
$floaterstyle = pv($_REQUEST['floaterstyle']);
$boxtitle = pv($_REQUEST['boxtitle']);



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "UPDATE boxstyles SET headerstyle = '$headerstyle', bodystyle = '$bodystyle', selectorcolor = '$selectorcolor', floaterstyle = '$floaterstyle', boxtitle = '$boxtitle' WHERE statusid = '$statusid'";
@mysqli_query($rs_connect, $rs_insert_scan);
header("Location: admin.php?func=statusstyles#g$statusid");


}



function customstatusstyles() {
require("header.php");
require_once("common.php");
require("deps.php");

if ($_COOKIE['username'] != "admin") {
die("admins only");
}

require("defaultstyles.php");



mysqli_query($rs_connect, "SET NAMES 'utf8'");

start_box();
echo "<center><a href=admin.php?func=statusstyles class=boldlink>".pcrtlang("Go to Standard Status Styles")."</a> | <font class=text12b>".pcrtlang("Custom Status Styles")."</font></center>";
stop_box();
echo "<br>";


start_box();
echo "<table><tr><td><form action=admin.php?func=customstatusstylesnew method=post><font class=text12b>".pcrtlang("Status ID Number").":</font></td><td><input type=text name=statusid class=textbox> <font class=text10i>".pcrtlang("Choose any number 100 or larger.")."</font><input type=hidden name=headerstyle value=\"$origheaderstyle[25]\">";
echo "<input type=hidden name=bodystyle value=\"$origbodystyle[25]\"><input type=hidden name=floaterstyle value=\"$origfloaterstyle[25]\">";
echo "</td></tr><tr><td><font class=text12b>".pcrtlang("Status Title").":</font></td><td><input type=text name=boxtitle class=textbox><input type=hidden name=selectorcolor value=\"$origselectorcolor[25]\"></td></tr></table>";
echo "<input type=submit class=button value=\" ".pcrtlang("Add Custom Status")." \"></form>";
stop_box();

$rs_qc = "SELECT * FROM boxstyles WHERE statusid > 99";
$rs_result1 = mysqli_query($rs_connect, $rs_qc);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$statusid = "$rs_result_q1->statusid";
$headerstyle2 = "$rs_result_q1->headerstyle";
$bodystyle2 = "$rs_result_q1->bodystyle";
$floaterstyle2 = "$rs_result_q1->floaterstyle";
$selectorcolor2 = "$rs_result_q1->selectorcolor";
$boxtitle2 = "$rs_result_q1->boxtitle";


echo "<a name=g$statusid></a><br><div class=\"colortitletopround\" style=\"$headerstyle2\">";

echo "<font class=textwhite16b>$boxtitle2</font>";
echo "</div>";
echo "<div class=\"whitebottom\" style=\"$bodystyle2\">";


echo "<table style=\"width:100%\"><tr><td><font class=text12b>".pcrtlang("For Light Stylesheets").":</font></td><td>";
echo "<form action=admin.php?func=customstatusstylessave method=post><input type=hidden name=statusid value=$statusid><input type=hidden name=headerstyle value=\"$origheaderstyle[25]\">";
echo "<input type=hidden name=bodystyle value=\"$origbodystyle[25]\"><input type=hidden name=floaterstyle value=\"$origfloaterstyle[25]\">";
echo "<input type=hidden name=boxtitle value=\"$boxtitle2\"><input type=hidden name=selectorcolor value=\"$origselectorcolor[25]\">";
echo "<input type=submit class=button value=\" ".pcrtlang("Original")." \" style=\"padding:2px;\"></form>";
echo "</td><td>";
echo "<form action=admin.php?func=customstatusstylessave method=post><input type=hidden name=statusid value=$statusid><input type=hidden name=headerstyle value=\"$pdheaderstyle[25]\">";
echo "<input type=hidden name=bodystyle value=\"$pdbodystyle[25]\"><input type=hidden name=floaterstyle value=\"$pdfloaterstyle[25]\">";
echo "<input type=hidden name=boxtitle value=\"$boxtitle2\"><input type=hidden name=selectorcolor value=\"$pdselectorcolor[25]\">";
echo "<input type=submit class=button value=\" ".pcrtlang("Dk Simple")." \" style=\"padding:2px;\"></form>";
echo "</td><td>";
echo "<form action=admin.php?func=customstatusstylessave method=post><input type=hidden name=statusid value=$statusid><input type=hidden name=headerstyle value=\"$plheaderstyle[25]\">";
echo "<input type=hidden name=bodystyle value=\"$plbodystyle[25]\"><input type=hidden name=floaterstyle value=\"$plfloaterstyle[25]\">";
echo "<input type=hidden name=boxtitle value=\"$boxtitle2\"><input type=hidden name=selectorcolor value=\"$plselectorcolor[25]\">";
echo "<input type=submit class=button value=\" ".pcrtlang("Lt Simple")." \" style=\"padding:2px;\"></form></td>";

echo "<td><form action=admin.php?func=customstatusstylessave method=post><input type=hidden name=statusid value=$statusid><input type=hidden name=headerstyle value=\"$barheaderstyle[25]\">";
echo "<input type=hidden name=bodystyle value=\"$barbodystyle[25]\"><input type=hidden name=floaterstyle value=\"$barfloaterstyle[25]\">";
echo "<input type=hidden name=boxtitle value=\"$boxtitle2\"><input type=hidden name=selectorcolor value=\"$barselectorcolor[25]\">";
echo "<input type=submit class=button value=\" ".pcrtlang("Bar")." \" style=\"padding:2px;\"></form></td>";

echo "<td><form action=admin.php?func=customstatusstylessave method=post><input type=hidden name=statusid value=$statusid><input type=hidden name=headerstyle value=\"$glowheaderstyle[25]\">";
echo "<input type=hidden name=bodystyle value=\"$glowbodystyle[25]\"><input type=hidden name=floaterstyle value=\"$glowfloaterstyle[25]\">";
echo "<input type=hidden name=boxtitle value=\"$boxtitle2\"><input type=hidden name=selectorcolor value=\"$glowselectorcolor[25]\">";
echo "<input type=submit class=button value=\" ".pcrtlang("Glow")." \" style=\"padding:2px;\"></form></td>";

echo "<td><form action=admin.php?func=customstatusstylessave method=post><input type=hidden name=statusid value=$statusid><input type=hidden name=headerstyle value=\"$gradheaderstyle[25]\">";
echo "<input type=hidden name=bodystyle value=\"$gradbodystyle[25]\"><input type=hidden name=floaterstyle value=\"$gradfloaterstyle[25]\">";
echo "<input type=hidden name=boxtitle value=\"$boxtitle2\"><input type=hidden name=selectorcolor value=\"$gradselectorcolor[25]\">";
echo "<input type=submit class=button value=\" ".pcrtlang("Grad")." \" style=\"padding:2px;\"></form></td>";

echo "<td><form action=admin.php?func=customstatusstylessave method=post><input type=hidden name=statusid value=$statusid><input type=hidden name=headerstyle value=\"$flatheaderstyle[25]\">";
echo "<input type=hidden name=bodystyle value=\"$flatbodystyle[25]\"><input type=hidden name=floaterstyle value=\"$flatfloaterstyle[25]\">";
echo "<input type=hidden name=boxtitle value=\"$boxtitle2\"><input type=hidden name=selectorcolor value=\"$flatselectorcolor[25]\">";
echo "<input type=submit class=button value=\" ".pcrtlang("Flat")." \" style=\"padding:2px;\"></form></td>";
echo "</tr></table>";

echo "<table style=\"width:100%\"><tr><td><font class=text12b>For Dark Stylesheets:</font></td><td>";
echo "<form action=admin.php?func=customstatusstylessave method=post><input type=hidden name=statusid value=$statusid><input type=hidden name=headerstyle value=\"$origondarkheaderstyle[25]\">";
echo "<input type=hidden name=bodystyle value=\"$origondarkbodystyle[25]\"><input type=hidden name=floaterstyle value=\"$origondarkfloaterstyle[25]\">";
echo "<input type=hidden name=boxtitle value=\"$boxtitle2\"><input type=hidden name=selectorcolor value=\"$origondarkselectorcolor[25]\">";
echo "<input type=submit class=button value=\" ".pcrtlang("Original")." \" style=\"padding:2px;\"></form>";
echo "</td><td>";
echo "<form action=admin.php?func=customstatusstylessave method=post><input type=hidden name=statusid value=$statusid><input type=hidden name=headerstyle value=\"$pdondarkheaderstyle[25]\">";
echo "<input type=hidden name=bodystyle value=\"$pdondarkbodystyle[25]\"><input type=hidden name=floaterstyle value=\"$pdondarkfloaterstyle[25]\">";
echo "<input type=hidden name=boxtitle value=\"$boxtitle2\"><input type=hidden name=selectorcolor value=\"$pdondarkselectorcolor[25]\">";
echo "<input type=submit class=button value=\" ".pcrtlang("Dk Simple")." \" style=\"padding:2px;\"></form>";
echo "</td><td>";
echo "<form action=admin.php?func=customstatusstylessave method=post><input type=hidden name=statusid value=$statusid><input type=hidden name=headerstyle value=\"$plondarkheaderstyle[25]\">";
echo "<input type=hidden name=bodystyle value=\"$plondarkbodystyle[25]\"><input type=hidden name=floaterstyle value=\"$plondarkfloaterstyle[25]\">";
echo "<input type=hidden name=boxtitle value=\"$boxtitle2\"><input type=hidden name=selectorcolor value=\"$plondarkselectorcolor[25]\">";
echo "<input type=submit class=button value=\" ".pcrtlang("Lt Simple")." \" style=\"padding:2px;\"></form></td>";

echo "<td><form action=admin.php?func=customstatusstylessave method=post><input type=hidden name=statusid value=$statusid><input type=hidden name=headerstyle value=\"$barondarkheaderstyle[25]\">";
echo "<input type=hidden name=bodystyle value=\"$barondarkbodystyle[25]\"><input type=hidden name=floaterstyle value=\"$barondarkfloaterstyle[25]\">";
echo "<input type=hidden name=boxtitle value=\"$boxtitle2\"><input type=hidden name=selectorcolor value=\"$barondarkselectorcolor[25]\">";
echo "<input type=submit class=button value=\" ".pcrtlang("Bar")." \" style=\"padding:2px;\"></form></td>";

echo "<td><form action=admin.php?func=customstatusstylessave method=post><input type=hidden name=statusid value=$statusid><input type=hidden name=headerstyle value=\"$glowondarkheaderstyle[25]\">";
echo "<input type=hidden name=bodystyle value=\"$glowondarkbodystyle[25]\"><input type=hidden name=floaterstyle value=\"$glowondarkfloaterstyle[25]\">";
echo "<input type=hidden name=boxtitle value=\"$boxtitle2\"><input type=hidden name=selectorcolor value=\"$glowondarkselectorcolor[25]\">";
echo "<input type=submit class=button value=\" ".pcrtlang("Glow")." \" style=\"padding:2px;\"></form></td>";

echo "<td><form action=admin.php?func=customstatusstylessave method=post><input type=hidden name=statusid value=$statusid><input type=hidden name=headerstyle value=\"$gradondarkheaderstyle[25]\">";
echo "<input type=hidden name=bodystyle value=\"$gradondarkbodystyle[25]\"><input type=hidden name=floaterstyle value=\"$gradondarkfloaterstyle[25]\">";
echo "<input type=hidden name=boxtitle value=\"$boxtitle2\"><input type=hidden name=selectorcolor value=\"$gradondarkselectorcolor[25]\">";
echo "<input type=submit class=button value=\" ".pcrtlang("Grad")." \" style=\"padding:2px;\"></form></td>";

echo "<td><form action=admin.php?func=customstatusstylessave method=post><input type=hidden name=statusid value=$statusid><input type=hidden name=headerstyle value=\"$flatondarkheaderstyle[25]\">";
echo "<input type=hidden name=bodystyle value=\"$flatondarkbodystyle[25]\"><input type=hidden name=floaterstyle value=\"$flatondarkfloaterstyle[25]\">";
echo "<input type=hidden name=boxtitle value=\"$boxtitle2\"><input type=hidden name=selectorcolor value=\"$flatondarkselectorcolor[25]\">";
echo "<input type=submit class=button value=\" ".pcrtlang("Flat")." \" style=\"padding:2px;\"></form></td>";
echo "</tr></table>";


echo "<table style=\"width:100%\">";
echo "<tr><td valign=top colspan=2><form action=admin.php?func=customstatusstylessave method=post><input type=hidden name=statusid value=$statusid>";
echo "<font class=text12b>".pcrtlang("Status Header Style").":</font></td></tr><tr><td colspan=2><textarea name=headerstyle rows=1 style=\"width:97%\" class=textbox>$headerstyle2</textarea></td></tr>";
echo "<tr><td colspan=2><font class=text12b>".pcrtlang("Status Body Style").":</font></td></tr><tr><td colspan=2><textarea name=bodystyle rows=1 style=\"width:97%\" class=textbox>$bodystyle2</textarea></td></tr>";
echo "<tr><td colspan=2><font class=text12b>".pcrtlang("Hover Info Style").":</font>";
echo "<a href=# class=\"hover$statusid statuslink\">".pcrtlang("Example")."<span><font class=text12heading style=\"background:#$selectorcolor2\">".pcrtlang("Example").":</font><br><br>".pcrtlang("Please save changes to see updated look")."</span></a>";
echo "</td></tr><tr><td colspan=2><textarea name=floaterstyle rows=1 style=\"width:97%\" class=textbox>$floaterstyle2</textarea>";

echo "</td></tr>";

echo "<tr><td><font class=text12b>".pcrtlang("Custom Box Title").":</font></td><td>";
echo "<input type=text name=boxtitle class=textbox value=\"$boxtitle2\"></td></tr>";
echo "<tr><td><font class=text12b>".pcrtlang("Selector Background Color").":</font></td><td><font style=\"background: #$selectorcolor2;width:30px;height:30px;\">&nbsp;&nbsp;&nbsp;&nbsp;</font><input type=text name=selectorcolor value=\"$selectorcolor2\" class=textbox></td></tr>";

echo "<tr><td><input type=submit value=\"^".pcrtlang("Save")."^\" class=button></form></td><td>";

echo "<a href=\"admin.php?func=cstatusdelete&cstatusid=$statusid\"  onClick=\"return confirm('".pcrtlang("Are you sure you wish to delete this custom status?")."')\">".pcrtlang("Delete this Custom Status")."</a></td></tr>";
echo "</table></div>";

echo "<br><br>";

}

?>
<script type='text/javascript' src='jq/jquery.autogrow-textarea.js'></script>
<script type='text/javascript'>
  $(function() {
    $('textarea').autogrow();
  });
</script>
<?php



require_once("footer.php");

}


function customstatusstylessave() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ($ipofpc != "admin") {
die("Admins Only");
}

$statusid = $_REQUEST['statusid'];
$headerstyle = pv($_REQUEST['headerstyle']);
$bodystyle = pv($_REQUEST['bodystyle']);
$selectorcolor = pv($_REQUEST['selectorcolor']);
$floaterstyle = pv($_REQUEST['floaterstyle']);
$boxtitle = pv($_REQUEST['boxtitle']);



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "UPDATE boxstyles SET headerstyle = '$headerstyle', bodystyle = '$bodystyle', selectorcolor = '$selectorcolor', floaterstyle = '$floaterstyle', boxtitle = '$boxtitle' WHERE statusid = '$statusid'";
@mysqli_query($rs_connect, $rs_insert_scan);
header("Location: admin.php?func=customstatusstyles#g$statusid");


}


function customstatusstylesnew() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ($ipofpc != "admin") {
die("Admins Only");
}


$statusid = $_REQUEST['statusid'];

if ($statusid < "100") {
die(pcrtlang("Status number must be 100 or greater"));
}



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$sqlcheck = "SELECT * FROM boxstyles WHERE statusid = '$statusid'";
$exs = mysqli_query($rs_connect, $sqlcheck);

$totresult = mysqli_num_rows($exs);

if ($totresult != 0) {
die("Status number already exists");
}

$headerstyle = pv($_REQUEST['headerstyle']);
$bodystyle = pv($_REQUEST['bodystyle']);
$selectorcolor = pv($_REQUEST['selectorcolor']);
$floaterstyle = pv($_REQUEST['floaterstyle']);
$boxtitle = pv($_REQUEST['boxtitle']);

$rs_insert_scan = "INSERT INTO boxstyles (statusid, headerstyle, bodystyle, selectorcolor, floaterstyle, boxtitle) VALUES ('$statusid','$headerstyle', '$bodystyle', '$selectorcolor', '$floaterstyle', '$boxtitle')";
@mysqli_query($rs_connect, $rs_insert_scan);
header("Location: admin.php?func=customstatusstyles#g$statusid");


}


function cstatusdelete() {
require_once("validate.php");

require("deps.php");
require("common.php");

$cstatusid = $_REQUEST['cstatusid'];

if ($ipofpc != "admin") {
die("Admins Only");
}




mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_move_wo = "UPDATE pc_wo SET pcstatus = '1' WHERE pcstatus = '$cstatusid'";
@mysqli_query($rs_connect, $rs_move_wo);

$rs_delete_boxstyle = "DELETE FROM boxstyles WHERE statusid = '$cstatusid'";
@mysqli_query($rs_connect, $rs_delete_boxstyle);
header("Location: admin.php?func=customstatusstyles");

}


function servicereminders() {
require("header.php");
require_once("common.php");
require("deps.php");

perm_boot("16");



mysqli_query($rs_connect, "SET NAMES 'utf8'");

start_blue_box(pcrtlang("Manage Service Reminder Messages"));

$rs_ql = "SELECT * FROM serviceremindercanned ORDER BY srorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$srid = "$rs_result_q1->srid";
$srtitle = "$rs_result_q1->srtitle";
$srtext = "$rs_result_q1->srtext";
$theorder = "$rs_result_q1->srorder";


start_box_nested();
echo "<table>";

echo "<tr><td><form action=admin.php?func=serviceremindersave method=post><input type=hidden name=srid value=$srid>";

echo "<a href=admin.php?func=reorderservicereminder&srid=$srid&dir=up&theorder=$theorder class=imagelink><img src=images/up.png border=0></a>";
echo " <a href=admin.php?func=reorderservicereminder&srid=$srid&dir=down&theorder=$theorder class=imagelink><img src=images/down.png border=0></a>";
echo "</td>";
echo "<td><font class=text12b>".pcrtlang("Title")."</font><br><input type=text class=textbox name=srtitle size=40 value=\"$srtitle\"></td><td></td></tr>";
echo "<tr><td colspan=2><font class=text12b>".pcrtlang("Message")."</font><br><textarea name=srtext rows=4 cols=70 class=textbox>$srtext</textarea>";
echo "<td><input type=submit value=\"&laquo;".pcrtlang("Save")."\" class=button></form></td>";
echo "<td><form action=admin.php?func=servicereminderdelete method=post>";
echo "<input type=hidden name=srid value=$srid>";
echo "<input type=submit value=\"&laquo;".pcrtlang("Delete")."\" class=button></form></td>";
echo "</tr>";
echo "</table>";
stop_box();
echo "<br>";
}

echo "<br><font class=text16heading>".pcrtlang("Add Service Reminder").":</font><br><br>";
echo "<form action=admin.php?func=servicereminderadd method=post>";
echo "<font class=text12b>".pcrtlang("Title")."</font><br><input type=text class=textbox name=srtitle size=50><br>";
echo "<font class=text12b>".pcrtlang("Message")."</font><br><textarea name=srtext rows=4 cols=70 value=\"\" class=textbox></textarea>";
echo "<input type=submit value=\"&laquo;".pcrtlang("Add")."\" class=ibutton></form>";

stop_blue_box();

require_once("footer.php");

}

function serviceremindersave() {
require_once("validate.php");

require("deps.php");
require("common.php");

perm_boot("16");

$srid = $_REQUEST['srid'];
$srtext = pv($_REQUEST['srtext']);
$srtitle = pv($_REQUEST['srtitle']);



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_sms = "UPDATE serviceremindercanned SET srtext = '$srtext', srtitle = '$srtitle' WHERE srid = '$srid'";
@mysqli_query($rs_connect, $rs_insert_sms);

header("Location: admin.php?func=servicereminders");
}

function servicereminderdelete() {
require_once("validate.php");

require("deps.php");
require("common.php");

$srid = $_REQUEST['srid'];

perm_boot("16");
if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_dst = "DELETE FROM serviceremindercanned WHERE srid = '$srid'";
@mysqli_query($rs_connect, $rs_dst);
header("Location: admin.php?func=servicereminders");


}



function servicereminderadd() {
require_once("validate.php");
require("deps.php");
require("common.php");

perm_boot("16");

$srtitle = pv($_REQUEST['srtitle']);
$srtext = pv($_REQUEST['srtext']);



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_sr = "INSERT INTO serviceremindercanned (srtitle,srtext) VALUES ('$srtitle','$srtext')";
@mysqli_query($rs_connect, $rs_insert_sr);

header("Location: admin.php?func=servicereminders");


}

function reorderservicereminder() {
require_once("validate.php");

$srid = $_REQUEST['srid'];
$dir = $_REQUEST['dir'];
$theorder = $_REQUEST['theorder'];

require("deps.php");
require_once("common.php");
perm_boot("16");



mysqli_query($rs_connect, "SET NAMES 'utf8'");

if ($dir == "up") {
$rs_sq = "SELECT * FROM serviceremindercanned WHERE srorder > '$theorder' ORDER BY srorder ASC LIMIT 1";
} else {
$rs_sq = "SELECT * FROM serviceremindercanned WHERE srorder < '$theorder' ORDER BY srorder DESC LIMIT 1";
}

$rs_result1 = mysqli_query($rs_connect, $rs_sq);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
if(mysqli_num_rows($rs_result1) == "0") {
$nextorder = "$srorder";
} else {
$nextorder = "$rs_result_q1->srorder";
}


if ($dir == "up") {
$neworder = $nextorder + 1;
} else {
$neworder = $nextorder -1;
}

$rs_change_order = "UPDATE serviceremindercanned SET srorder = '$neworder' WHERE srid = $srid";
@mysqli_query($rs_connect, $rs_change_order);


$rs_resetorder = "SELECT * FROM serviceremindercanned ORDER BY srorder ASC";
$rs_resultreset = mysqli_query($rs_connect, $rs_resetorder);
$a = 0;
while($rs_result_r1 = mysqli_fetch_object($rs_resultreset)) {
$srid2 = "$rs_result_r1->srid";
$rs_set_order = "UPDATE serviceremindercanned SET srorder = '$a' WHERE srid = $srid2";
@mysqli_query($rs_connect, $rs_set_order);
$a = $a + 5;
}


header("Location: admin.php?func=servicereminders");


}


function oncallusers() {
require("header.php");
require_once("common.php");
require("deps.php");

perm_boot("18");



mysqli_query($rs_connect, "SET NAMES 'utf8'");

start_blue_box(pcrtlang("On Call Users"));
echo "<form action=\"admin.php?func=oncallusers_save\" method=post>";
echo "<table>";
$rs_ql = "SELECT * FROM stores WHERE storeenabled = '1'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$storeid = "$rs_result_q1->storeid";
$storesname = "$rs_result_q1->storesname";
$oncalluser = "$rs_result_q1->oncalluser";

echo "<tr><td><font class=text12b>".pcrtlang("Store").": $storesname</font></td><td>";
echo "<select name=store$storeid>";

if($oncalluser == "") {
echo "<option selected value=\"\">".pcrtlang("Un-Assigned")."</option>";
} else {
echo "<option value=\"\">".pcrtlang("Un-Assigned")."</option>";
}

$rs_qu = "SELECT * FROM users";
$rs_resultqu1 = mysqli_query($rs_connect, $rs_qu);
while($rs_result_qu2 = mysqli_fetch_object($rs_resultqu1)) {
$theusername = "$rs_result_qu2->username";
if($oncalluser == "$theusername") {
echo "<option selected value=\"$theusername\">$theusername</option>";
} else {
echo "<option value=\"$theusername\">$theusername</option>";
}
}


echo "</select></td></tr>";

}

echo "</table><br><input type=submit class=button value=\"".pcrtlang("Save Settings")."\"></form>";
stop_blue_box();

require_once("footer.php");

}


function oncallusers_save() {
require_once("validate.php");

require("deps.php");
require("common.php");

perm_boot("18");



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_ql = "SELECT * FROM stores WHERE storeenabled = '1'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$storeid = "$rs_result_q1->storeid";

$cstore = "store$storeid";

$storeiduser = $_REQUEST["$cstore"];

$rs_update_oc = "UPDATE stores SET oncalluser = '$storeiduser' WHERE storeid = '$storeid'";
@mysqli_query($rs_connect, $rs_update_oc);
}

header("Location: admin.php?func=oncallusers");
}



function editdymotemp() {
require("header.php");
require_once("common.php");
require("deps.php");

if ($_COOKIE['username'] != "admin") {
die("admins only");
}

$rs_storeid = $_REQUEST['storeid'];




mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_ql = "SELECT * FROM stores WHERE storeid = '$rs_storeid'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$tempasset = "$rs_result_q1->tempasset";
$tempaddress = "$rs_result_q1->tempaddress";
$temppricetag = "$rs_result_q1->temppricetag";
$temppricetagserial = "$rs_result_q1->temppricetagserial";

$storeinfoarray = getstoreinfo($rs_storeid);
echo "<form action=admin.php?func=editdymotemp2 method=post><input type=hidden name=storeid value=\"$rs_storeid\">";

echo "<font class=text16bu>".pcrtlang("Edit Dymo Label Templates for Store").": $storeinfoarray[storesname]</font><br><br>";

start_box();
echo "<a href=admin.php?func=stores>".pcrtlang("Return to Store Admin")."</a>";
stop_box();
echo "<br><br>";

start_blue_box(pcrtlang("Asset Label Template"));
echo "<textarea name=asset class=textboxw style=\"width:97%\" rows=1>$tempasset</textarea>";
echo "<font class=text12>".pcrtlang("Available Variables").":<br>
".pcrtlang("Customer Name").": PCRT_CUSTOMER_NAME<br>
".pcrtlang("PC ID").": PCRTPCID<br>
".pcrtlang("Store Name").": PCRT_YOUR_STORE_NAME<br>
".pcrtlang("Store Phone").": PCRT_STORE_PHONE<br>
".pcrtlang("Work Order ID").": PCRTWOID<br>
".pcrtlang("PC Make").": PCRT_MAKE<br>
".pcrtlang("Customer Phone").": PCRT_CUSTOMER_PHONE<br>
".pcrtlang("Customer Company Name").": PCRT_CUSTOMER_COMPANY
</font>";


stop_blue_box();
echo "<br><br>";

start_blue_box(pcrtlang("Address Label Template"));
echo "<textarea name=address class=textboxw style=\"width:97%\" rows=1>$tempaddress</textarea>";
echo "<font class=text12>".pcrtlang("Available Variables").":<br>
".pcrtlang("Customer Name").": PCRT_CUSTOMER_NAME<br>
".pcrtlang("Address Line 1").": PCRTADDRESS1<br>
".pcrtlang("Address Line 2").": PCRTADDRESS2<br>
".pcrtlang("Address Line 3").": PCRTADDRESS3<br>
</font>";
stop_blue_box();
echo "<br><br>";

start_blue_box(pcrtlang("Price Tag Template"));
echo "<textarea name=pricetag class=textboxw style=\"width:97%\" rows=1>$temppricetag</textarea>";
echo "<font class=text12>".pcrtlang("Available Variables").":<br>
".pcrtlang("Stock Name").": PCRT_STOCK_NAME<br>
".pcrtlang("Price").": PCRT_PRICE<br>
".pcrtlang("Stock ID").": PCRTSTOCKID<br>
".pcrtlang("Store Name").": PCRT_STORE_NAME<br>
".pcrtlang("Store Phone").": PCRT_STORE_PHONE<br>
".pcrtlang("Stock UPC").": PCRTUPC<br>
</font>";
stop_blue_box();
echo "<br><br>";

start_blue_box(pcrtlang("Price Tag Template with Serial"));
echo "<textarea name=pricetagserial class=textboxw style=\"width:97%\" rows=1>$temppricetagserial</textarea>";
echo "<font class=text12>".pcrtlang("Available Variables").":<br>
".pcrtlang("Stock Name").": PCRT_STOCK_NAME<br>
".pcrtlang("Price").": PCRT_PRICE<br>
".pcrtlang("Stock ID").": PCRTSTOCKID<br>
".pcrtlang("Serial Number").": PCRT_SERIAL_NUMBER<br>
".pcrtlang("Store Name").": PCRT_STORE_NAME<br>
".pcrtlang("Store Phone").": PCRT_STORE_PHONE<br>
".pcrtlang("Stock UPC").": PCRTUPC<br>
</font>";
stop_blue_box();
echo "<br><br>";

?>

<script type='text/javascript' src='jq/jquery.autogrow-textarea.js'></script>
<script type='text/javascript'>
  $(function() {
    $('textarea').autogrow();
  });
</script>
<?php

echo "<input type=submit value=\"".pcrtlang("Save")."\" class=button></form><br><br>";

start_box();
echo "<font class=text12>".pcrtlang("Create your label with the Dymo Label Designer software placing the variables shown here as placeholders for fields in the label, save the file, and then open it with a text editor and paste the template text here.")."</font>";

stop_box();
require_once("footer.php");

}


function editdymotemp2() {
require_once("validate.php");


require("deps.php");
require("common.php");

if ($_COOKIE['username'] != "admin") {
die("admins only");
}
$storeid = $_REQUEST['storeid'];
$asset = pv($_REQUEST['asset']);
$address = pv($_REQUEST['address']);
$pricetag = pv($_REQUEST['pricetag']);
$pricetagserial = pv($_REQUEST['pricetagserial']);



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_text = "UPDATE stores SET tempasset = '$asset', tempaddress = '$address', temppricetag = '$pricetag', temppricetagserial = '$pricetagserial' WHERE storeid = '$storeid'";
@mysqli_query($rs_connect, $rs_insert_text);

header("Location: admin.php?func=editdymotemp&storeid=$storeid");

}



function mainassets() {

require("header.php");
require_once("common.php");
require("deps.php");


if ($_COOKIE['username'] != "admin") {
die("admins only");
}




mysqli_query($rs_connect, "SET NAMES 'utf8'");

$boxtitle = pcrtlang("Main Asset/Device Definitions");

start_blue_box("$boxtitle");


echo "<table>";


$rs_sq = "SELECT * FROM mainassettypes ORDER BY mainassetname ASC";
$rs_result1 = mysqli_query($rs_connect, $rs_sq);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$mainassettypeid = "$rs_result_q1->mainassettypeid";
$mainassetname = "$rs_result_q1->mainassetname";
$mainassetdefault = "$rs_result_q1->mainassetdefault";

$checkmainassets =  "SELECT * FROM pc_owner WHERE mainassettypeid='$mainassettypeid'";
$rs_result_chk = mysqli_query($rs_connect, $checkmainassets);
$totalassets = mysqli_num_rows($rs_result_chk);

$mainassettypename2 = urlencode("$mainassetname");

echo "<tr><td>";

if($mainassetdefault != 1) {
echo "<a href=admin.php?func=setmainassetdefault&mainassettypeid=$mainassettypeid>".pcrtlang("set default")."&raquo;</a>&nbsp;&nbsp;&nbsp;";
} else {
echo "<font class=text12b> ".pcrtlang("Default")."&raquo; </font> ";
}


echo "</td><td>";
echo "<font class=text12b> $mainassetname </font></td><td>&nbsp;&nbsp;&nbsp;&nbsp;<a href=admin.php?func=editmainassettype&mainassettypeid=$mainassettypeid&mainassetname=$mainassettypename2>".pcrtlang("edit")."</a> </td><td> <font class=text12b>|</font>";
if ($totalassets == "0") {
echo " <a href=admin.php?func=deletemainassettype&mainassettypeid=$mainassettypeid>".pcrtlang("delete")."</a>";
}

echo "</td><td><font class=text12b>|</font> <a href=admin.php?func=mainassetfields&mainassettypeid=$mainassettypeid&mainassettypename=$mainassettypename2>".pcrtlang("asset/device fields")."</a></td><td>";

echo " <font class=text12b>|</font> <a href=admin.php?func=mainassetsubassets&mainassettypeid=$mainassettypeid&mainassettypename=$mainassettypename2>".pcrtlang("asset accessories")."</a>";

echo "</td></tr>";
}
echo "</table>";

echo "<br><font class=text12b>".pcrtlang("Add New Main Asset/Device Type")."</font><br>";

echo "<form method=post action=\"admin.php?func=addmainassettype\"><input type=text class=textbox name=mainassetname size=30>
<input class=button type=submit value=\"".pcrtlang("Add")."\"></form>";

stop_blue_box();
echo "<br><br>";

#################

$boxtitle2 = pcrtlang("Main Asset/Device Info Field Options");

start_blue_box("$boxtitle2");


echo "<table>";

echo "<tr><td colspan=2></td><td colspan=5><font class=text12b>".pcrtlang("Show On").":</font></td></tr>";
echo "<tr><td></td><td><font class=text12b>".pcrtlang("Field Keyword")."</font>&nbsp;&nbsp;&nbsp;</td><td><font class=text12>".pcrtlang("Claim Ticket")."</font>&nbsp;&nbsp;&nbsp;</td><td><font class=text12>".pcrtlang("Repair Report")."</font>&nbsp;&nbsp;&nbsp;</td><td><font class=text12>".pcrtlang("Checkout Receipt")."<font>&nbsp;&nbsp;&nbsp;</td><td><font class=text12>".pcrtlang("Price Card")."</font></td></tr>";

$rs_sq = "SELECT * FROM mainassetinfofields ORDER BY mainassetfieldname ASC";
$rs_result1 = mysqli_query($rs_connect, $rs_sq);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$mainassetfieldid = "$rs_result_q1->mainassetfieldid";
$mainassetfieldname = "$rs_result_q1->mainassetfieldname";
$matchword = "$rs_result_q1->matchword";
$showonclaim = "$rs_result_q1->showonclaim";
$showonrepair = "$rs_result_q1->showonrepair";
$showoncheckout = "$rs_result_q1->showoncheckout";
$showonpricecard = "$rs_result_q1->showonpricecard";

if($showonclaim == 1) {
$showonclaima = pcrtlang("yes");
} else {
$showonclaima = "";
}

if($showonrepair == 1) {
$showonrepaira = pcrtlang("yes");
} else {
$showonrepaira = "";
}

if($showoncheckout == 1) {
$showoncheckouta = pcrtlang("yes");
} else {
$showoncheckouta = "";
}

if($showonpricecard == 1) {
$showonpricecarda = pcrtlang("yes");
} else {
$showonpricecarda = "";
}


$mainassetfieldname2 = urlencode("$mainassetfieldname");
$matchword2 = urlencode("$matchword");

echo "<tr><td><font class=text12b> $mainassetfieldname</font></td><td><font class=text12>$matchword</font></td><td><font class=text12>$showonclaima</font></td><td><font class=text12>$showonrepaira</font></td><td><font class=text12>$showoncheckouta</font></td><td><font class=text12>$showonpricecarda</font></td><td>&nbsp;&nbsp;&nbsp;&nbsp;<a href=admin.php?func=editmainassetfield&mainassetfieldid=$mainassetfieldid&mainassetfieldname=$mainassetfieldname2&matchword=$matchword2>".pcrtlang("edit")."</a> ";

echo "</td></tr>";
}
echo "</table>";

echo "<br><font class=text12bub>".pcrtlang("Add New Main Asset/Device Info Field")."</font><br>";
echo "<table><tr><td><font class=text12b>".pcrtlang("Field Name")."</font></td><td><font class=text12b>".pcrtlang("Field Keyword (optional)")."</font></td></tr>";
echo "<tr><td><form method=post action=\"admin.php?func=addmainassetfield\"><input type=text class=textbox name=mainassetfieldname size=30>";
echo "</td><td><input type=text class=textbox name=matchword size=30>";
echo "</td></tr>";
echo "<tr><td colspan=2><input class=button type=submit value=\"".pcrtlang("Add")."\"></form></td></tr></table>";

echo "<br><br><br><font class=text12b>".pcrtlang("Available d7 Field Keywords").":</font> <font class=text12i>(".pcrtlang("these are the values that can be imported from d7 and mapped to PCRT fields").")</font><br>";
echo "<pre>";

$valuestopull = array(
"model" => "Mfgr / Model:",
"motherboard" => "MB:",
"bios" => "BIOS:",
"partitiontype" => "Partition Type:",
"cpu" => "CPU String:",
"ram" => "RAM:",
"operatingsystem" => " OS:",
"windowsproductkey" => "Product Key:",
"serial" => "Serial#:",
"videocard" => "Video Card:",
"partition" => "Partition Space:",
"antivirus" => "Anti-Virus:",
"antispyware" => "Anti-Spyware:",
"internetexplorer" => "Internet Explorer:",
"firewall" => "Firewall:",
"computername" => "Computer Name:",
"ipaddress" => "IP Address:",
"username" => "User Name:",
"domain" => "Domain:",
"ipaddress" => "IP Address:",
"computername" => "Computer Name:",
"gateway" => "Gateway:",
"dns" => "DNS:",
"networkinterfacecard" => "NIC:",
"macaddress" => "MAC:",
"installedon" => "Installed on:"
);


print_r($valuestopull);
echo "</pre>";


stop_blue_box();
echo "<br><br>";





require_once("footer.php");

}


function addmainassettype() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ($_COOKIE['username'] != "admin") {
die("admins only");
}

$mainassetname = pv($_REQUEST['mainassetname']);



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_mat = "INSERT INTO mainassettypes (mainassetname) VALUES ('$mainassetname')";
@mysqli_query($rs_connect, $rs_insert_mat);

header("Location: admin.php?func=mainassets");


}


function deletemainassettype() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ($_COOKIE['username'] != "admin") {
die("admins only");
}

$mainassettypeid = $_REQUEST['mainassettypeid'];



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_delete_mat = "DELETE FROM mainassettypes WHERE mainassettypeid = '$mainassettypeid'";
@mysqli_query($rs_connect, $rs_delete_mat);

header("Location: admin.php?func=mainassets");


}


function editmainassettype() {
require("header.php");
require_once("common.php");
require("deps.php");

if ($_COOKIE['username'] != "admin") {
die("admins only");
}

$mainassettypeid = $_REQUEST['mainassettypeid'];
$mainassetname = $_REQUEST['mainassetname'];


echo "<form action=admin.php?func=editmainassettype2 method=post><input type=hidden name=mainassettypeid value=\"$mainassettypeid\">";

start_blue_box(pcrtlang("Edit Main Asset Name"));
echo "<font class=text12b>".pcrtlang("Main Asset Name").":</font> <input type=text name=mainassetname class=textbox cols=40 value=\"$mainassetname\"><input type=submit class=button value=\"".pcrtlang("Save")."\"></form>";
stop_blue_box();
echo "<br><br>";

require_once("footer.php");

}

function editmainassettype2() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ($_COOKIE['username'] != "admin") {
die("admins only");
}

$mainassetname = pv($_REQUEST['mainassetname']);
$mainassettypeid = $_REQUEST['mainassettypeid'];



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_update_tdc = "UPDATE mainassettypes SET mainassetname = '$mainassetname' WHERE mainassettypeid = '$mainassettypeid'";
@mysqli_query($rs_connect, $rs_update_tdc);


header("Location: admin.php?func=mainassets");


}

function setmainassetdefault() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ($_COOKIE['username'] != "admin") {
die("admins only");
}

$mainassettypeid = $_REQUEST['mainassettypeid'];



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_update_tdc = "UPDATE mainassettypes SET mainassetdefault = '0'";
@mysqli_query($rs_connect, $rs_update_tdc);
$rs_update_tdc2 = "UPDATE mainassettypes SET mainassetdefault = '1' WHERE mainassettypeid = '$mainassettypeid'";
@mysqli_query($rs_connect, $rs_update_tdc2);



header("Location: admin.php?func=mainassets");


}


function mainassetsubassets() {

require("header.php");
require_once("common.php");
require("deps.php");


if ($_COOKIE['username'] != "admin") {
die("admins only");
}

$mainassettypename = $_REQUEST['mainassettypename'];
$mainassettypeid = $_REQUEST['mainassettypeid'];



mysqli_query($rs_connect, "SET NAMES 'utf8'");


$rs_sq = "SELECT * FROM mainassettypes WHERE mainassettypeid = '$mainassettypeid'";
$rs_result1 = mysqli_query($rs_connect, $rs_sq);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$subassetlistindb2 = "$rs_result_q1->subassetlist";

if ($subassetlistindb2 != "") {
$subassetlistindb3 = unserialize($subassetlistindb2);
} else {
$subassetlistindb3 = array();
}

if(is_array($subassetlistindb3)) {
$subassetlistindb = $subassetlistindb3;
} else {
$subassetlistindb = array();
}


$boxtitle = pcrtlang("Asset Accessories for Main Asset/Device Type").": $mainassettypename";

start_blue_box("$boxtitle");

echo "<font class=text12b>".pcrtlang("Pick Asset Accessories for this Main Asset/Device ").":</font><br>";

echo "<form method=post action=\"admin.php?func=mainassetsubassetssave\"><input type=hidden name=mainassettypeid value=\"$mainassettypeid\">";

echo "<table width=100%><tr><td valign=top>";

reset($custassets);
$total_asset_types = count($custassets);
$div2 = ($total_asset_types / 2);
$div3 = $div2 + 1;

$a = 1;
echo "<div class=\"checkbox\">";
while (list($key, $val) = each($custassets)) {

if (in_array($key,$subassetlistindb)) {
echo "<input type=checkbox checked id=\"$key\" value=\"$key\" name=\"assets[]\"><label for=\"$key\">
<img src=images/assets/$val align=absmiddle> ".pcrtlang("$key")."</input></label><br>";
} else {
echo "<input type=checkbox value=\"$key\" id=\"$key\" name=\"assets[]\"><label for=\"$key\"><img src=images/assets/$val align=absmiddle> ".pcrtlang("$key")."</input></label><br>";
}

if (($a >= $div2) && ($a < $div3)) {
echo "</div></td><td valign=top><div class=\"checkbox\">";
}
$a++;

}



echo "</div>";


echo "</td></tr></table>";
echo "<br><input class=button type=submit value=\"".pcrtlang("Save")."\"></form>";


stop_blue_box();
echo "<br><br>";

require_once("footer.php");

}


function mainassetsubassetssave() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ($_COOKIE['username'] != "admin") {
die("admins only");
}

$mainassettypeid = $_REQUEST['mainassettypeid'];

if (array_key_exists('assets',$_REQUEST)) {
$assets = $_REQUEST['assets'];
} else {
$assets = array();
}

$assets3 = array_filter($assets);
$assets2 = pv(serialize($assets3));



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_update_sal = "UPDATE mainassettypes SET subassetlist = '$assets2' WHERE mainassettypeid = '$mainassettypeid'";
@mysqli_query($rs_connect, $rs_update_sal);


header("Location: admin.php?func=mainassets");


}



function addmainassetfield() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ($_COOKIE['username'] != "admin") {
die("admins only");
}

$mainassetfieldname = pv($_REQUEST['mainassetfieldname']);
$matchword = pv($_REQUEST['matchword']);



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_mat = "INSERT INTO mainassetinfofields (mainassetfieldname,matchword) VALUES ('$mainassetfieldname','$matchword')";
@mysqli_query($rs_connect, $rs_insert_mat);

header("Location: admin.php?func=mainassets");


}




function editmainassetfield() {
require("header.php");
require_once("common.php");
require("deps.php");

if ($_COOKIE['username'] != "admin") {
die("admins only");
}

$mainassetfieldid = $_REQUEST['mainassetfieldid'];
$mainassetfieldname = $_REQUEST['mainassetfieldname'];
$matchword = $_REQUEST['matchword'];

$rs_sq = "SELECT * FROM mainassetinfofields WHERE mainassetfieldid = '$mainassetfieldid'";
$rs_result1 = mysqli_query($rs_connect, $rs_sq);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$showonclaim = "$rs_result_q1->showonclaim";
$showonrepair = "$rs_result_q1->showonrepair";
$showoncheckout = "$rs_result_q1->showoncheckout";
$showonpricecard = "$rs_result_q1->showonpricecard";

if($showonclaim == 1) {
$checked1 = "checked";
} else {
$checked1 = "";
}

if($showonrepair == 1) {
$checked2 = "checked";
} else {
$checked2 = "";
}

if($showoncheckout == 1) {
$checked3 = "checked";
} else {
$checked3 = "";
}

if($showonpricecard == 1) {
$checked4 = "checked";
} else {
$checked4 = "";
}



echo "<form action=admin.php?func=editmainassetfield2 method=post><input type=hidden name=mainassetfieldid value=\"$mainassetfieldid\">";

start_blue_box(pcrtlang("Edit Main Asset/Device Info Field Name"));
echo "<table>";
echo "<tr><td><font class=text12b>".pcrtlang("Asset/Device Info Field Name").":</font> </td><td><input type=text name=mainassetfieldname class=textbox cols=40 value=\"$mainassetfieldname\"></td></tr>";
echo "<tr><td><font class=text12b>".pcrtlang("Field Keyword").":</font> </td><td><input type=text name=matchword class=textbox cols=40 value=\"$matchword\"></td></tr>";


echo "<tr><td><font class=text12b>".pcrtlang("Show on Claim Ticket").":</font> </td><td><input type=checkbox name=showonclaim $checked1></td></tr>";
echo "<tr><td><font class=text12b>".pcrtlang("Show on Repair Report").":</font> </td><td><input type=checkbox name=showonrepair $checked2></td></tr>";
echo "<tr><td><font class=text12b>".pcrtlang("Show on Checkout Receipt").":</font> </td><td><input type=checkbox name=showoncheckout $checked3></td></tr>";
echo "<tr><td><font class=text12b>".pcrtlang("Show on Price Card").":</font> </td><td><input type=checkbox name=showonpricecard $checked4></td></tr>";


echo "<tr><td colspan=2><input type=submit class=button value=\"".pcrtlang("Save")."\"></form></td></tr>";
echo "</table>";
stop_blue_box();
echo "<br><br>";

require_once("footer.php");

}

function editmainassetfield2() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ($_COOKIE['username'] != "admin") {
die("admins only");
}

$mainassetfieldname = pv($_REQUEST['mainassetfieldname']);
$mainassetfieldid = $_REQUEST['mainassetfieldid'];
$matchword = pv($_REQUEST['matchword']);

$showonclaim = $_REQUEST['showonclaim'];
$showonrepair = $_REQUEST['showonrepair'];
$showoncheckout = $_REQUEST['showoncheckout'];
$showonpricecard = $_REQUEST['showonpricecard'];

if($showonclaim == "on") {
$showonclaim2 = 1;
} else {
$showonclaim2 = 0;
}

if($showonrepair == "on") {
$showonrepair2 = 1;
} else {
$showonrepair2 = 0;
}

if($showoncheckout == "on") {
$showoncheckout2 = 1;
} else {
$showoncheckout2 = 0;
}

if($showonpricecard == "on") {
$showonpricecard2 = 1;
} else {
$showonpricecard2 = 0;
}





mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_update_tdc = "UPDATE mainassetinfofields SET mainassetfieldname = '$mainassetfieldname', matchword = '$matchword', showonclaim = '$showonclaim2', showonrepair = '$showonrepair2', showoncheckout = '$showoncheckout2', showonpricecard = '$showonpricecard2' WHERE mainassetfieldid = '$mainassetfieldid'";
@mysqli_query($rs_connect, $rs_update_tdc);


header("Location: admin.php?func=mainassets");

}


function mainassetfields() {

require("header.php");
require_once("common.php");
require("deps.php");


if ($_COOKIE['username'] != "admin") {
die("admins only");
}

$mainassettypename = $_REQUEST['mainassettypename'];
$mainassettypeid = $_REQUEST['mainassettypeid'];



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_ff = "SELECT * FROM mainassetinfofields";
$rs_resultff = mysqli_query($rs_connect, $rs_ff);
while ($rs_result_qff = mysqli_fetch_object($rs_resultff)) {
$fieldidnum = "$rs_result_qff->mainassetfieldid";
$fieldname = "$rs_result_qff->mainassetfieldname";
$fieldsarray[$fieldidnum] = $fieldname;
}


$rs_sq = "SELECT * FROM mainassettypes WHERE mainassettypeid = '$mainassettypeid'";
$rs_result1 = mysqli_query($rs_connect, $rs_sq);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$assetinfolistindb2 = "$rs_result_q1->assetinfofields";
if ($assetinfolistindb2 != "") {
$assetinfolistindb3 = unserialize($assetinfolistindb2);
} else {
$assetinfolistindb3 = array();
}

if(is_array($assetinfolistindb3)) {
$assetinfolistindb = $assetinfolistindb3;
} else {
$assetinfolistindb = array();
}


$boxtitle = pcrtlang("Asset/Device Info Fields for Main Asset").": $mainassettypename";

start_blue_box("$boxtitle");

echo "<font class=text12b>".pcrtlang("Pick Info Fields for this Main Asset ").":</font><br>";

echo "<form method=post action=\"admin.php?func=mainassetfieldssave\"><input type=hidden name=mainassettypeid value=\"$mainassettypeid\">";
echo "<input type=hidden name=mainassettypename value=\"$mainassettypename\">";

echo "<table width=100%><tr><td valign=top>";

reset($fieldsarray);

echo "<div class=\"checkbox\">";

$totalfields = count($assetinfolistindb) -1;

foreach($assetinfolistindb as $key => $val) {

if ($key != 0) {
echo "<a href=admin.php?func=reorderinfofields&fid=$val&dir=up&mainassetinfofieldid=$val&mainassettypename=$mainassettypename&mainassettypeid=$mainassettypeid class=imagelink><img src=images/up.png border=0></a>";
} else {
echo "&nbsp;&nbsp;&nbsp;";
}
if ($key != $totalfields) {
echo " <a href=admin.php?func=reorderinfofields&fid=$val&dir=down&mainassetinfofieldid=$val&mainassettypename=$mainassettypename&mainassettypeid=$mainassettypeid class=imagelink><img src=images/down.png border=0></a>";
} else {
echo "&nbsp;&nbsp;&nbsp;&nbsp;";
}



echo "<input type=checkbox checked id=\"$val\" value=\"$val\" name=\"assets[]\"><label for=\"$val\"> $fieldsarray[$val]</input></label><br>";
}


foreach($fieldsarray as $key => $val) {

if (!in_array($key,$assetinfolistindb)) {
echo "<input type=checkbox value=\"$key\" id=\"$key\" name=\"assets[]\"><label for=\"$key\"> $val</input></label><br>";
}
}


echo "</div>";


echo "</td></tr></table>";
echo "<br><input class=button type=submit value=\"".pcrtlang("Save")."\"></form>";


echo "<br><br><a href=admin.php?func=mainassets>".pcrtlang("Return to Main Device/Asset Type Definitions")."</a><br><br>";

stop_blue_box();
echo "<br><br>";

require_once("footer.php");

}



function mainassetfieldssave() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ($_COOKIE['username'] != "admin") {
die("admins only");
}

$mainassettypeid = $_REQUEST['mainassettypeid'];
$mainassettypename = $_REQUEST['mainassettypename'];

if (array_key_exists('assets',$_REQUEST)) {
$assets = $_REQUEST['assets'];
} else {
$assets = array();
}

$assets3 = array_filter($assets);
$assets2 = pv(serialize($assets3));


mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_update_sal = "UPDATE mainassettypes SET assetinfofields = '$assets2' WHERE mainassettypeid = '$mainassettypeid'";
@mysqli_query($rs_connect, $rs_update_sal);


header("Location: admin.php?func=mainassetfields&mainassettypeid=$mainassettypeid&mainassettypename=$mainassettypename");


}


function reorderinfofields() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ($_COOKIE['username'] != "admin") {
die("admins only");
}

$mainassetinfofieldid = $_REQUEST['mainassetinfofieldid'];
$dir = $_REQUEST['dir'];
$fid = $_REQUEST['fid'];
$mainassettypename = $_REQUEST['mainassettypename'];
$mainassettypeid = $_REQUEST['mainassettypeid'];

if (array_key_exists('assets',$_REQUEST)) {
$assets = $_REQUEST['assets'];
} else {
$assets = array();
}



mysqli_query($rs_connect, "SET NAMES 'utf8'");


$rs_sq = "SELECT * FROM mainassettypes WHERE mainassettypeid = '$mainassettypeid'";
$rs_result1 = mysqli_query($rs_connect, $rs_sq);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$assetinfolistindb2 = "$rs_result_q1->assetinfofields";
if ($assetinfolistindb2 != "") {
$assetinfolistindb3 = unserialize($assetinfolistindb2);
} else {
$assetinfolistindb3 = array();
}

if(is_array($assetinfolistindb3)) {
$assetinfolistindb = $assetinfolistindb3;
} else {
$assetinfolistindb = array();
}

$origposition = array_search("$fid", $assetinfolistindb);

if($dir == "up") {
$thewhere = $origposition - 1;
} else {
$thewhere = $origposition + 1;
}

#echo "<pre>orig in db \n\n";
#print_r($assetinfolistindb);
#echo "</pre><br><br>";

if(($key = array_search($fid, $assetinfolistindb)) !== false) {
    unset($assetinfolistindb[$key]);
}


$inserted[] = $fid;
array_splice($assetinfolistindb, $thewhere, 0, $inserted );



$assets3 = array_filter($assetinfolistindb);
$assets2 = pv(serialize($assets3));

#echo "Number that should move:$fid - $dir<br><pre>";
#print_r($assetinfolistindb);
#echo "</pre>";
#die();


$rs_update_sal = "UPDATE mainassettypes SET assetinfofields = '$assets2' WHERE mainassettypeid = '$mainassettypeid'";
@mysqli_query($rs_connect, $rs_update_sal);

header("Location: admin.php?func=mainassetfields&mainassettypeid=$mainassettypeid&mainassettypename=$mainassettypename");


}



function switch_receipt() {
require_once("validate.php");

$switch = $_REQUEST['switch'];
$receipt = $_REQUEST['receipt'];

require("deps.php");



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_narrow = "UPDATE users SET narrow = '$switch' WHERE username = '$ipofpc'";
@mysqli_query($rs_connect, $rs_insert_narrow);

header("Location: $receipt");

}

function switch_ct() {
require_once("validate.php");

$switch = $_REQUEST['switch'];
$ticket = $_REQUEST['ticket'];

require("deps.php");



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_narrow = "UPDATE users SET narrowct = '$switch' WHERE username = '$ipofpc'";
@mysqli_query($rs_connect, $rs_insert_narrow);

header("Location: $ticket");

}


#####

switch($func) {
                                                                                                    
    default:
    admin();
    break;
                                
    case "quicklabor":
    quicklabor();
    break;

    case "quicklaborsave":
    quicklaborsave();
    break;

    case "quicklabordelete":
    quicklabordelete();
    break;
                                   
    case "quicklaboradd":
    quicklaboradd();
    break;

    case "showscans":
    showscans();
    break;

case "addscan":
    addscan();
    break;

case "addscan2":
    addscan2();
    break;


    case "recordscan2":
    recordscan2();
    break;

  case "reorderscan":
    reorderscan();
    break;

    case "editscan":
    editscan();
    break;

 case "editscan2":
    editscan2();
    break;

case "deletescan":
    deletescan();
    break;

   case "scanpic":
    scanpic();
    break;

    case "scanpic2":
    scanpic2();
    break;

   case "useraccounts":
    useraccounts();
    break;

  case "useraccountsnew":
    useraccountsnew();
    break;

 case "useraccounts2":
    useraccounts2();
    break;

 case "useraccountsdel":
    useraccountsdel();
    break;

    case "status":
    status();
    break;

 case "taxrates":
    taxrates();
    break;

 case "taxratesadd":
    taxratesadd();
    break;

 case "taxratesed":
    taxratesed();
    break;

 case "taxratesdel":
    taxratesdel();
    break;


 case "taxratesedit":
    taxratesedit();
    break;

 case "createtaxgroup":
    createtaxgroup();
    break;


case "setscanrecordview":
    setscanrecordview();
    break;

case "saveperms":
    saveperms();
    break;

case "showphpinfo":
    showphpinfo();
    break;

case "settouch":
    settouch();
    break;

case "settouchwide":
    settouchwide();
    break;

case "setstickywide":
    setstickywide();
    break;


case "setmodal":
    setmodal();
    break;

case "admindeletepc":
    admindeletepc();
    break;

case "admindeletewo":
    admindeletewo();
    break;

case "showcustsources":
    showcustsources();
    break;

case "addcustsource":
    addcustsource();
    break;

case "addcustsource2":
    addcustsource2();
    break;

case "deletecustsource":
    deletecustsource();
    break;

case "editcustsource":
    editcustsource();
    break;

case "editcustsource2":
    editcustsource2();
    break;

   case "commonproblems":
    commonproblems();
    break;

    case "comprobsave":
    comprobsave();
    break;

    case "comprobdelete":
    comprobdelete();
    break;

    case "comprobadd":
    comprobadd();
    break;

   case "setusertax":
    setusertax();
    break;

    case "showstickynotetypes":
    showstickynotetypes();
    break;

    case "stickynotetypesave":
    stickynotetypesave();
    break;

  case "stickynotetypedelete":
    stickynotetypedelete();
    break;

  case "stickynotetypeadd":
    stickynotetypeadd();
    break;

   case "setautoprint":
    setautoprint();
    break;

   case "backupdatabase":
    backupdatabase();
    break;

   case "setfloatbar":
    setfloatbar();
    break;

   case "admindeletegroup":
    admindeletegroup();
    break;

   case "stores":
    stores();
    break;

   case "savestore":
    savestore();
    break;

   case "addstore":
    addstore();
    break;

   case "storesetdefault":
    storesetdefault();
    break;

   case "storedisable":
    storedisable();
    break;

   case "setuserdefaultstore":
    setuserdefaultstore();
    break;

   case "benchsave":
    benchsave();
    break;

   case "benchadd":
    benchadd();
    break;

   case "benchdelete":
    benchdelete();
    break;

  case "reorderquicklabor":
    reorderquicklabor();
    break;

  case "editfootertext":
    editfootertext();
    break;

  case "editfootertext2":
    editfootertext2();
    break;

 case "frameit":
    frameit();
    break;

 case "frameitsave":
    frameitsave();
    break;

 case "frameitdelete":
    frameitdelete();
    break;

 case "frameitadd":
    frameitadd();
    break;

 case "colorssave":
    colorssave();
    break;

case "showtechdoccats":
    showtechdoccats();
    break;

case "deletetechdoccat":
    deletetechdoccat();
    break;

case "edittechdoccat":
    edittechdoccat();
    break;

case "edittechdoccat2":
    edittechdoccat2();
    break;

case "addtechdoccat":
    addtechdoccat();
    break;

    case "smstext":
    smstext();
    break;

    case "smstextsave":
    smstextsave();
    break;

    case "smstextdelete":
    smstextdelete();
    break;

    case "smstextadd":
    smstextadd();
    break;

 case "reordersmstext":
    reordersmstext();
    break;

case "makehash":
    makehash();
    break;

case "statusstyles":
    statusstyles();
    break;

case "statusstylessave":
    statusstylessave();
    break;


case "customstatusstyles":
    customstatusstyles();
    break;

case "customstatusstylessave":
    customstatusstylessave();
    break;

case "customstatusstylesnew":
    customstatusstylesnew();
    break;

case "cstatusdelete":
    cstatusdelete();
    break;

    case "servicereminders":
    servicereminders();
    break;

    case "serviceremindersave":
    serviceremindersave();
    break;

    case "servicereminderdelete":
    servicereminderdelete();
    break;

    case "servicereminderadd":
    servicereminderadd();
    break;

 case "reorderservicereminder":
    reorderservicereminder();
    break;

 case "saveusercontactinfo":
    saveusercontactinfo();
    break;

 case "oncallusers":
    oncallusers();
    break;

 case "oncallusers_save":
    oncallusers_save();
    break;

 case "editdymotemp":
    editdymotemp();
    break;

 case "editdymotemp2":
    editdymotemp2();
    break;

 case "mainassets":
    mainassets();
    break;

 case "addmainassettype":
    addmainassettype();
    break;

 case "deletemainassettype":
    deletemainassettype();
    break;

 case "editmainassettype":
    editmainassettype();
    break;

 case "editmainassettype2":
    editmainassettype2();
    break;

 case "setmainassetdefault":
    setmainassetdefault();
    break;

 case "mainassetfields":
    mainassetfields();
    break;

 case "mainassetfieldssave":
    mainassetfieldssave();
    break;


 case "mainassetsubassets":
    mainassetsubassets();
    break;

 case "mainassetsubassetssave":
    mainassetsubassetssave();
    break;

 case "addmainassetfield":
    addmainassetfield();
    break;

 case "deletemainassetfield":
    deletemainassetfield();
    break;

 case "editmainassetfield":
    editmainassetfield();
    break;

 case "editmainassetfield2":
    editmainassetfield2();
    break;


 case "reorderinfofields":
    reorderinfofields();
    break;

 case "switch_receipt":
    switch_receipt();
    break;

 case "switch_ct":
    switch_ct();
    break;


}

?>
