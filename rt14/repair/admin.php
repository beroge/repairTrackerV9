<?php

/***************************************************************************
 *   copyright            : (C) 2021 PCRepairTracker.com
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

echo "<a href=admin.php class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-circle-left fa-lg\"></i> ".pcrtlang("Go Back to Settings")."</a><br><br>";

echo "<table class=standard>";
$rs_ql = "SELECT * FROM quicklabor ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$qlid = "$rs_result_q1->quickid";
$labordesc = "$rs_result_q1->labordesc";
$laborprice = "$rs_result_q1->laborprice";
$theorder = "$rs_result_q1->theorder";
$printdesc = "$rs_result_q1->printdesc";

$primero = mb_substr("$labordesc", 0, 1);

if("$primero" != "-") {
echo "<tr><td valign=top><form action=admin.php?func=quicklaborsave method=post><input type=hidden name=quickid value=$qlid>";
echo "<a href=admin.php?func=reorderquicklabor&qlid=$qlid&dir=up&theorder=$theorder class=\"linkbuttonsmall linkbuttongray radiusleft\"><i class=\"fa fa-chevron-up fa-lg\"></i></a>";
echo "<a href=admin.php?func=reorderquicklabor&qlid=$qlid&dir=down&theorder=$theorder class=\"linkbuttonsmall linkbuttongray radiusright\"><i class=\"fa fa-chevron-down fa-lg\"></i></a>";
echo "</td>";
echo "<td><input type=text name=labordesc size=40 value=\"".htmlentities("$labordesc")."\" class=textbox>&nbsp;&nbsp; $money<input type=text name=laborprice id=laborprice"."$qlid size=8 value=\"".mf($laborprice)."\" class=textbox>";

$usertaxid = getusertaxid();
$servicetaxrateremain = (1 + getservicetaxrate($usertaxid));

if($servicetaxrateremain != 1) {
echo "<button class=button type=button
onclick='document.getElementById(\"laborprice"."$qlid\").value=(document.getElementById(\"laborprice"."$qlid\").value / $servicetaxrateremain).toFixed(5);this.disabled=true;'>
<i class=\"fa fa-calculator\"></i> ".pcrtlang("Pre-tax")."</button>";
}

echo "<br><textarea name=printdesc cols=50 value=\"$printdesc\" class=textbox placeholder=\"".pcrtlang("Enter Optional Printed Description")."\">".htmlentities("$printdesc")."</textarea>";
echo "</td><td valign=top><button type=submit class=sbutton><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button></form></td><td valign=top><form action=admin.php?func=quicklabordelete method=post>";
echo "<input type=hidden name=quickid value=$qlid>";
echo "<button type=submit class=ibutton><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")."</button></form>";
} else {
$labordesc2 = mb_substr("$labordesc", 1);
echo "<tr><td valign=top><input type=hidden name=quickid value=$qlid>";
echo "<a href=admin.php?func=reorderquicklabor&qlid=$qlid&dir=up&theorder=$theorder class=\"linkbuttonsmall linkbuttongray radiusleft\"><i class=\"fa fa-chevron-up fa-lg\"></i></a>";
echo "<a href=admin.php?func=reorderquicklabor&qlid=$qlid&dir=down&theorder=$theorder class=\"linkbuttonsmall linkbuttongray radiusright\"><i class=\"fa fa-chevron-down fa-lg\"></i></a>";
echo "</td>";
echo "<td><span class=\"linkbuttongraylabel linkbuttonsmall radiusall\">$labordesc2</span>";
echo "</td><td valign=top></td><td valign=top><form action=admin.php?func=quicklabordelete method=post>";
echo "<input type=hidden name=quickid value=$qlid>";
echo "<button type=submit class=ibutton><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")."</button></form>";
}


echo "</td></tr>";

}

echo "</table>";

echo "<br><br><span class=\"sizeme16 boldme\">".pcrtlang("Add").":</span><br>";
echo "<form action=admin.php?func=quicklaboradd method=post>";
echo "<input type=text name=labordesc size=30 value=\"\" class=textbox placeholder=\"".pcrtlang("Enter Labor Title")."\">&nbsp;&nbsp; $money<input type=text name=laborprice id=laborprice size=8 value=\"\" class=textbox class=textbox>";

$usertaxid = getusertaxid();
$servicetaxrateremain = (1 + getservicetaxrate($usertaxid));
if($servicetaxrateremain != 1) {
echo "<button class=button type=button onclick='document.getElementById(\"laborprice\").value=(document.getElementById(\"laborprice\").value / $servicetaxrateremain).toFixed(5);this.disabled=true;'>
<i class=\"fa fa-calculator\"></i> ".pcrtlang("Pre-tax")."</button>";
}


echo "<br><textarea name=printdesc cols=50 class=textbox placeholder=\"".pcrtlang("Enter Optional Printed Description")."\"></textarea>";
echo "<button type=submit class=sbutton><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Add")."</button></form>";
echo "<span class=italme>".pcrtlang("Start Labor Description with a - to create a title spacer.")."</span>";
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
$printdesc = pv($_REQUEST['printdesc']);


mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "UPDATE quicklabor SET labordesc = '$labordesc', laborprice = '$laborprice', printdesc = '$printdesc' WHERE quickid = '$quickid'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=quicklabor");


}

function quicklabordelete() {
require_once("validate.php");

require("deps.php");
require("common.php");

$quickid = $_REQUEST['quickid'];

perm_boot("2");

if (($demo == "yes") && ("$ipofpc" != "admin")) {
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
$printdesc = pv($_REQUEST['printdesc']);


mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "INSERT INTO quicklabor (labordesc,laborprice,printdesc) VALUES ('$labordesc','$laborprice','$printdesc')";
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
echo "<a href=../repair/admin.php class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-circle-left fa-lg\"></i> ".pcrtlang("Go Back to Settings")."</a><br><br>";

$folderperms = mb_substr(sprintf('%o', fileperms('images/scans')), -3);

if($folderperms < "766") {
echo "<span class=colormered>".pcrtlang("It appears your repair/images/scans folder might not be writeable. You may not be able to upload new icons.")." $folderperms</span>";
}

echo "<table class=standard>";

echo "<tr><th width=30%>".pcrtlang("Name")."</th><th width=10%>".pcrtlang("Active?")."</th><th width=25%></th><th width=15%>".pcrtlang("Total Recorded")."</th><th width=20%>".pcrtlang("Re-order")."</th></tr>";

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
echo "<span class=boldme> $progname </span></td><td>&nbsp;</td><td><a href=admin.php?func=editscan&scanid=$scanid class=\"linkbuttonsmall linkbuttongray radiusleft\">".pcrtlang("edit")."</a>";
if ($totalscans == "0") {
echo "<a href=admin.php?func=deletescan&scanid=$scanid&scantype=$scantype class=\"linkbuttonsmall linkbuttongray\">".pcrtlang("delete")."</a>";
}

if ($progicon != "") {
echo "<a href=admin.php?func=scanpic&scanid=$scanid&existing=yes&progicon=$progicon&scantype=$scantype class=\"linkbuttonsmall linkbuttongray radiusright\">".pcrtlang("change icon")."</a>";
} else {
echo "<a href=admin.php?func=scanpic&scanid=$scanid&existing=no&progicon=$progicon&scantype=$scantype class=\"linkbuttonsmall linkbuttongray radiusright\">".pcrtlang("add icon")."</a>";
}
echo "</td><td align=right>$totalscans</td><td>";

echo "&nbsp;&nbsp;<a href=admin.php?func=reorderscan&scanid=$scanid&dir=up&scantype=$scantype&theorder=$theorder class=\"linkbuttonsmall linkbuttongray radiusleft\"><i class=\"fa fa-chevron-up fa-lg\"></i></a>";
echo "<a href=admin.php?func=reorderscan&scanid=$scanid&dir=down&scantype=$scantype&theorder=$theorder class=\"linkbuttonsmall linkbuttongray radiusright\"><i class=\"fa fa-chevron-down fa-lg\"></i></a><br>";
} else {
echo "<tr><td>";
if ($progicon != "") {
echo "<img src=images/scans/$progicon align=absmiddle>"; 
}

echo " <span class=textgray12b>$progname</span></td><td><span class=textgray12b>".pcrtlang("disabled")."</span></td><td>";
echo "<a href=admin.php?func=editscan&scanid=$scanid class=\"linkbuttonsmall linkbuttongray radiusleft\">".pcrtlang("edit")."</a>";

if ($totalscans == "0") {
echo "<a href=admin.php?func=deletescan&scanid=$scanid&scantype=$scantype class=\"linkbuttonsmall linkbuttongray radiusright\">".pcrtlang("delete")."</a>";
}


echo "</td><td align=right>$totalscans</td><td>";
$up = $theorder + 1;
$down = $theorder - 1;
echo "&nbsp;&nbsp;<a href=admin.php?func=reorderscan&scanid=$scanid&dir=$up&scantype=$scantype class=\"linkbuttonsmall linkbuttongray radiusleft\"><i class=\"fa fa-chevron-up fa-lg\"></i></a>";
echo "<a href=admin.php?func=reorderscan&scanid=$scanid&dir=$down&scantype=$scantype class=\"linkbuttonsmall linkbuttongray radiusright\"><i class=\"fa fa-chevron-down fa-lg\"></i></a><br>";
}
echo "</td></tr>";
}
echo "</table>";
echo "<br><br><a href=admin.php?func=addscan&scantype=$scantype class=\"linkbuttonmedium linkbuttongray radiusall\">".pcrtlang("Add New")." $boxtitle</a>";

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


echo "<tr><td><span class=boldme>".pcrtlang("Technical Title").":</span></td>";
echo "<td><input type=hidden name=scanid value=$scanid><input type=hidden name=scantype value=$scantype><input type=text size=35 name=progname value=\"$progname\" class=textbox></td></tr>";
echo "<tr><td><span class=boldme>".pcrtlang("Customer Viewable Title").":</span></td>";
echo "<td><input type=text size=35 name=progword value=\"$progword\" class=textbox></td></tr>";
echo "<tr><td><span class=boldme>".pcrtlang("Icon File Name").":</b><br><span class=textgray10i>".pcrtlang("only change here if not<br>using image upload feature")."</span></td>";
echo "<td><input type=text size=25 name=progicon value=\"$progicon\" class=textbox></td></tr>";
if ($scantype != '0') {
echo "<tr><td><span class=boldme>".pcrtlang("Printable Info").":</span></td>";
echo "<td><textarea cols=60 rows=20 name=printinfo class=textbox>$printinfo</textarea></td></tr>";
} else {
echo "<input type=hidden name=printinfo value=\"$printinfo\">";
}
echo "<tr><td><span class=boldme>".pcrtlang("Active").":</span></td>";
echo "<td>";
if ($active == '1') {
echo "<span class=boldme>".pcrtlang("Yes").":</span><input type=radio name=active checked value=on><br>";
echo "<span class=boldme>".pcrtlang("No").":</span><input type=radio name=active value=off>";
} else {
echo "<span class=boldme>".pcrtlang("Yes").":</span><input type=radio name=active value=on><br>";
echo "<span class=boldme>".pcrtlang("No").":</span><input type=radio name=active checked value=off>";
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

echo "<tr><td><span class=boldme>".pcrtlang("Technical Title").":</span></td>";
echo "<td><input type=hidden name=scantype value=$scantype><input type=text size=35 name=progname value=\"\" class=textbox></td></tr>";
echo "<tr><td><span class=boldme>".pcrtlang("Customer Viewable Title").":</span></td>";
echo "<td><input type=text size=35 name=progword value=\"\" class=textbox></td></tr>";
echo "<tr><td><span class=boldme>".pcrtlang("Icon File Name").":</span><br><span class=textgray10i>".pcrtlang("only enter here if not<br>using image upload feature")."</span></td>";
echo "<td><input type=text size=25 name=progicon value=\"\" class=textbox></td></tr>";
if ($scantype != '0') {
echo "<tr><td><span class=boldme>".pcrtlang("Printable Info").":</span></td>";
echo "<td><textarea cols=60 rows=20 name=printinfo class=textbox></textarea></td></tr>";
} else {
echo "<input type=hidden name=printinfo value=\"\">";
}
echo "<tr><td><span class=boldme>".pcrtlang("Active").":</span></td>";
echo "<td>";
echo "<span class=boldme>".pcrtlang("Yes").":</span><input type=radio name=active checked value=on><br>";
echo "<span class=boldme>".pcrtlang("No").":</span><input type=radio name=active value=off>";

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
echo "<tr><td><span class=boldme>".pcrtlang("Icon to Upload").":</span></td><td><input type=file name=icon><input type=hidden name=scanid value=$scanid><input type=hidden name=existing value=$existing></td></tr>";
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

if (($demo == "yes") && ("$ipofpc" != "admin")) {
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

require("deps.php");

require_once("validate.php");

if ("$ipofpc" != "admin") {
die("admins only");
}

if (array_key_exists('showuser',$_REQUEST)) {
$showuser = "$_REQUEST[showuser]";
} else {
$showuser = "";
}


require("header.php");
require_once("common.php");

echo "<a href=../repair/admin.php class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-circle-left fa-lg\"></i> ".pcrtlang("Go Back to Settings")."</a><br><br>";

mysqli_query($rs_connect, "SET NAMES 'utf8'");


$ipaddress = $_SERVER['REMOTE_ADDR'];
if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');
#Set time here for how many minutes before login attempts are expired.
$loginattempts_expiretime_minutes = 60;
$lesshourstamp = (strtotime($currentdatetime) - (60 * $loginattempts_expiretime_minutes));
$lesshour = date('Y-m-d H:i:s', $lesshourstamp);
$rs_clear_ip = "DELETE FROM loginattempts WHERE attempttime < '$lesshour'";
$rs_result = mysqli_query($rs_connect, $rs_clear_ip);
#Set max login attempts here
$maxloginattempts = 4;

start_blue_box(pcrtlang("Users"));

$rs_ql = "SELECT * FROM users";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$userid = "$rs_result_q1->userid";
$uname = "$rs_result_q1->username";
$userpass = "$rs_result_q1->userpass";
$pin = "$rs_result_q1->pin";
$theperms2 = "$rs_result_q1->theperms";
$lastseen2 = "$rs_result_q1->lastseen";
$useremail = "$rs_result_q1->useremail";
$usermobile = "$rs_result_q1->usermobile";
$enabled = "$rs_result_q1->enabled";
$twofactor = "$rs_result_q1->twofactor";

$lastseen = date("n-j-y, g:i a", strtotime($lastseen2));

$theperms3 = unserialize($theperms2);
if(is_array($theperms3)) {
$theperms = $theperms3;
} else {
$theperms = array();
}

echo "<a name=$uname></a>";
start_box();
echo "<table><tr><td valign=top>";
if("$uname" == "$showuser") {
echo "<br><br><br>";
echo "<form action=admin.php?func=useraccounts2 method=post><input type=hidden name=userid value=$userid><input type=hidden name=showuser value=$uname>";
}
echo "<a href=\"admin.php?func=useraccounts&showuser=$uname#$uname\" class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-user-md fa-lg\"></i> $uname</a>";

if($twofactor == 0) {
echo " <i class=\"fa fa-lock fa-lg colormered\"></i> <span class=\"colormered boldme\">2FA</span>";
} else {
echo " <i class=\"fa fa-lock fa-lg colormegreen\"></i> <span class=\"colormegreen boldme\">2FA</span>";
}

echo "<br><span class=\"sizemesmaller\">".pcrtlang("Last Seen").": $lastseen";
echo "</span>";

$rs_find_ip = "SELECT * FROM loginattempts WHERE username = '$uname'";
$rsfind_result = mysqli_query($rs_connect, $rs_find_ip);
$userloginattempts = mysqli_num_rows($rsfind_result);
if($userloginattempts > $maxloginattempts) {
echo "<br><i class=\"fa fa-warning fa-lg colormered\"></i><span class=colormered> ".pcrtlang("Locked: Exceded Login Attempts")."</span> ";
$cusername = urlencode("$uname");
echo "<a href=\"admin.php?func=clearlogins&username=$cusername\" class=\"linkbuttonmedium linkbuttonred radiusall\"><i class=\"fa fa-times fa-lg\"></i> ".pcrtlang("Clear")."</a>";
}


echo "</td>";
if("$uname" == "$showuser") {
echo "<td valign=top><br><br><br><input type=text name=setuserpass size=15 class=textbox><input type=hidden name=uname value=\"$uname\">";
echo "</td><td valign=top><br><br><br><input type=submit value=\"&laquo;".pcrtlang("Save New Password")."\" class=button></form></td></tr>";




echo "<tr><td></td><td valign=top>";
echo "<form action=admin.php?func=savepin method=post><input type=hidden name=userid value=$userid><input type=hidden name=showuser value=$uname>";
echo "<input type=text name=pin size=6 class=textbox maxlength=4 minlength=4><input type=hidden name=uname value=\"$uname\">";
echo "</td><td valign=top><input type=submit value=\"&laquo;".pcrtlang("Save Pin")."\" class=button></form>";

if($pin == "") {
echo "&nbsp;&nbsp;<span class=\"colormered boldme\"><i class=\"fa fa-warning fa-lg\"></i> ".pcrtlang("Pin is not set")."</span>";
}

echo "</td></tr>";

}

echo "<tr><td style=\"padding:20px;\">";

if("$uname" == "$showuser") {

if("$uname" != "admin") {

echo "<span class=\"sizemelarge boldme\">".pcrtlang("User Permissions").":</span><form action=admin.php?func=saveperms method=post><input type=hidden name=showuser value=$uname><br>";

reset($theperms);
reset($themasterperms);
foreach($themasterperms as $key => $val) {
if (in_array($key, $theperms)) {
echo "<input type=checkbox checked value=\"$key\" name=\"permar[]\">$val</input><br>";
} else {
echo "<input type=checkbox value=\"$key\" name=\"permar[]\">$val</input><br>";
}
}


echo "<input type=hidden name=usertochange value=\"$uname\"><input type=submit value=\"".pcrtlang("Save Permissions")."\" class=button></form>";

}

echo "</td><td colspan=2 valign=top style=\"padding:20px;\">";

echo "<form action=admin.php?func=saveusercontactinfo method=post><input type=hidden name=userid value=$userid>";
echo "<table class=standard><tr><th colspan=2><span class=\"sizemelarge boldme\">".pcrtlang("User Contact Info")."</span></th></tr>";

echo "<tr><td><span class=boldme>".pcrtlang("Email Address").":</span></td><td><input type=text class=textbox name=useremail value=\"$useremail\"></td></tr>";
echo "<tr><td><span class=boldme>".pcrtlang("Mobile Phone").":</span></td><td><input type=text class=textbox name=usermobile value=\"$usermobile\"></td></tr>";



if($mysmsgateway != "none") {


if($twofactor == 0) {
$twofactorchecked0 = "checked";
$twofactorchecked1 = "";
$twofactorchecked2 = "";
} elseif($twofactor == 1) {
$twofactorchecked0 = "";
$twofactorchecked1 = "checked";
$twofactorchecked2 = "";
} else {
$twofactorchecked0 = "";
$twofactorchecked1 = "";
$twofactorchecked2 = "checked";
}


echo "<tr><td><span class=boldme>".pcrtlang("Enable 2FA").":</span></td><td>";

echo "<input type=radio name=twofactor value=0 $twofactorchecked0> ".pcrtlang("Off")."<br>";
echo "<input type=radio name=twofactor value=1 $twofactorchecked1> ".pcrtlang("Every Login")."<br>";
echo "<input type=radio name=twofactor value=2 $twofactorchecked2> ".pcrtlang("Logins From Previously Unseen IP Addresses")."<br>";
} else {
echo "<tr><td><span class=colormered>(".pcrtlang("No SMS Gateway Configured").")</span></td></tr>";
}

echo "<tr><td colspan=2><input type=hidden name=usertochange value=\"$uname\"><input type=submit value=\"".pcrtlang("Save User Contact Info")."\" class=button></td></tr>";

echo "</table>";
echo "</form>";


if ("$uname" != "admin") {
echo "<br><br><form action=admin.php?func=useraccountsdel method=post><input type=hidden name=userid value=$userid><input type=hidden name=showuser value=$uname>";
echo "<input type=hidden name=uname value=\"$uname\" class=textbox>";
echo "<input type=submit class=\"linkbuttonred linkbuttonmedium radiusall\" value=\"X ".pcrtlang("Delete User")."\"
onClick=\"return confirm('".pcrtlang("Are you sure you wish to delete user").": $uname?')\"></form><br>";
if($enabled == 1) {
echo "<a href=\"admin.php?func=enableuser&username=$uname&enabled=0\" class=\"linkbuttonmedium linkbuttonred radiusall\"><i class=\"fa fa-user-times fa-lg\">
</i> ".pcrtlang("Disable User")."</a>";
} else {
echo "<a href=\"admin.php?func=enableuser&username=$uname&enabled=1\" class=\"linkbuttonmedium linkbuttongreen radiusall\"><i class=\"fa fa-user-times fa-lg\">
</i> ".pcrtlang("Enable User")."</a>";
}
}




}
echo "</td></tr></table>";
stop_box();
echo "<br>";
}



echo "<br><span class=\"sizemelarge boldme\">".pcrtlang("Add User: username/password")."</span><br>";
echo "<form action=admin.php?func=useraccountsnew method=post>";
echo "<input type=text name=uname size=30 value=\"\" class=textbox> / <input type=text name=userpass size=15 value=\"\" class=textbox>";
echo "<input type=submit value=\"&laquo;".pcrtlang("Add User")."\" class=ibutton></form>";

stop_blue_box();

require_once("footer.php");

}


function useraccountsnew() {
require_once("validate.php");

if ("$ipofpc" != "admin") {
die("admins only");
}

require("deps.php");
require("common.php");


$uname = $_REQUEST['uname'];
$userpass = password_hash($_REQUEST['userpass'], PASSWORD_DEFAULT);

if (($uname == "") || ($_REQUEST['userpass'] == "")) {
die(pcrtlang("please go back and fill both fields"));
}
 

if ($uname == "admin") {
die(pcrtlang("Cannot create account named admin"));
}

function validate_uname($uname2) {
return preg_match('/[^a-z0-9_\-]/i', $uname2) ? '0' : '1';
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

if ("$ipofpc" != "admin") {
die("admins only");
}


$userid = $_REQUEST['userid'];
$userpass = password_hash($_REQUEST['setuserpass'], PASSWORD_DEFAULT);
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

if ("$ipofpc" != "admin") {
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

if ("$ipofpc" != "admin") {
die("admins only");
}


require_once("deps.php");
require_once("common.php");

$userid = $_REQUEST['userid'];
$uname = $_REQUEST['usertochange'];
$useremail = pv($_REQUEST['useremail']);
$usermobile = pv($_REQUEST['usermobile']);
$twofactor = pv($_REQUEST['twofactor']);

mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "UPDATE users SET useremail = '$useremail', usermobile = '$usermobile', twofactor = '$twofactor' WHERE userid = '$userid' AND username = '$uname'";
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
echo "<button type=submit class=button><i class=\"fa fa-clock-o fa-lg\"></i> ".pcrtlang("Set Touchscreen Refresh Timeout (in seconds)")."</button></form>";

echo "<table>";

echo "<tr><td><form action=admin.php?func=setautoprint method=post><span class=boldme>".pcrtlang("Auto Fire Print Dialogs?").":</span></td><td>";
if($autoprintindb == 0) {
echo "<input type=radio name=autoprint value=1>".pcrtlang("Yes")." ";
echo "<input type=radio name=autoprint value=0 checked>".pcrtlang("No")." ";
} else {
echo "<input type=radio name=autoprint value=1 checked>".pcrtlang("Yes")." ";
echo "<input type=radio name=autoprint value=0>".pcrtlang("No")." ";
}

echo "<button type=submit class=button><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save Setting")."</button></form></td></tr>";

$rs_find_tax = "SELECT * FROM taxes WHERE taxenabled = '1' ORDER BY taxname ASC";
$rs_result_tax = mysqli_query($rs_connect, $rs_find_tax);
$usertaxid = getusertaxid();
echo "<tr><td><span class=boldme>".pcrtlang("Default Tax Rate").":</span></td><td>";

echo "<form method=post action=admin.php?func=setusertax>";
echo "<select name=settaxname class=selects onchange='this.form.submit()'>";

while($rs_result_tq = mysqli_fetch_object($rs_result_tax)) {
$rs_taxname = "$rs_result_tq->taxname";
$rs_taxid = "$rs_result_tq->taxid";

if ($rs_taxid == $usertaxid) {
echo "<option selected value=$rs_taxid>$rs_taxname</option>";
} else {
echo "<option value=$rs_taxid>$rs_taxname</option>";
}
}
echo "</select></form></td></tr>";


if ($activestorecount > "1") {
$rs_find_stores = "SELECT * FROM stores WHERE storeenabled = '1' ORDER BY storesname ASC";
$rs_result_stores = mysqli_query($rs_connect, $rs_find_stores);

echo "<tr><td><span class=boldme>".pcrtlang("Default Store").":</span></td><td>";
echo "<form method=post action=admin.php?func=setuserdefaultstore>";
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
echo "</select></form>";
}

echo "</td></tr>";

$registerid = getcurrentregister();

$rs_find_registers = "SELECT * FROM registers WHERE registerstoreid = '$defaultuserstore' ORDER BY registername ASC";
$rs_result_registers = mysqli_query($rs_connect, $rs_find_registers);

$rs_find_register = "SELECT * FROM registers WHERE registerid = '$registerid'";
$rs_result_register = mysqli_query($rs_connect, $rs_find_register);

$registerexists = mysqli_num_rows($rs_result_register);

echo "<tr><td><span class=boldme>".pcrtlang("Set Register").":</span></td><td>";
echo "<form method=post action=admin.php?func=setregister>";
echo "<select name=setregisterid onchange='this.form.submit()'>";

if (($registerexists == 0) && ($registerid != 0)) {
echo "<option value=$registerid selected>".pcrtlang("Deleted Register")."</option>";
}


if ($registerid == 0) {
echo "<option value=0 selected>".pcrtlang("Unset")."</option>";
} else {
echo "<option value=0>".pcrtlang("Unset")."</option>";
}


while($rs_result_registerq = mysqli_fetch_object($rs_result_registers)) {
$rs_registername = "$rs_result_registerq->registername";
$rs_registerid = "$rs_result_registerq->registerid";


if ($rs_registerid == $registerid) {
echo "<option selected value=$rs_registerid>$rs_registername</option>";
} else {
echo "<option value=$rs_registerid>$rs_registername</option>";
}


}
echo "</select></form>";


echo "</td></tr>";


echo "</table>";

#echo "<br><table class=standard><tr><th>".pcrtlang("Calendar Sync Links for Sticky Notes").":</th></tr>";

$storeinfoarray = getstoreinfo($defaultuserstore);
if ($storeinfoarray['storehash'] == "") {
#echo "<tr><td>".pcrtlang("Please have your admin generate a calendar hash for the store").": $storeinfoarray[storesname]</td></tr>";
} else {
#echo "<tr><td><strong>".pcrtlang("Whole Store").":</strong> <a href=$domain/ics.php?download=yes&user=all&storeid=$defaultuserstore&hash=$storeinfoarray[storehash] class=\"linkbuttontiny linkbuttongray radiusall\"><i class=\"fa fa-link fa-lg\"></i> link</a></tr></td>";
#echo "<tr><td>$domain/ics.php?download=yes&user=all&storeid=$defaultuserstore&hash=$storeinfoarray[storehash]</tr></td>";
#echo "<tr><td><strong>".pcrtlang("Your User Only").":</strong> <a href=$domain/ics.php?download=yes&user=$ipofpc&storeid=$defaultuserstore&hash=$storeinfoarray[storehash] class=\"linkbuttontiny linkbuttongray radiusall\"><i class=\"fa fa-link fa-lg\"></i> link</a></tr></td>";
#echo "<tr><td>$domain/ics.php?download=yes&user=$ipofpc&storeid=$defaultuserstore&hash=$storeinfoarray[storehash]</tr></td>";

#echo "<tr><td><strong>".pcrtlang("Store Hash").":</strong> $storeinfoarray[storehash]</td></tr>";
}

#echo "</table>";

stop_blue_box();

echo "<br><br>";

start_blue_box(pcrtlang("Manage"));

echo "<table style=\"width:100%\"><tr><td>";

if (perm_check("2")) {
echo "<a href=admin.php?func=quicklabor class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-money fa-lg fa-fw\"></i> ".pcrtlang("Manage Quick Labor Prices")."</a><br><br>";
}

if (perm_check("6")) {
echo "<a href=../store/stock.php?func=noninventory class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-box-open fa-lg fa-fw\"></i> ".pcrtlang("Manage Non-Inventoried Items")."</a><br><br>";
}


if (perm_check("27")) {
echo "<a href=msp.php?func=scpricing class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-money fa-lg fa-fw\"></i> ".pcrtlang("Manage Service Contract Prices")."</a><br><br>";
}

if (perm_check("11")) {
echo "<a href=admin.php?func=commonproblems class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-wrench fa-lg fa-fw\"></i> ".pcrtlang("Manage Common Problems/Requests")."</a><br><br>";
}

if (perm_check("12")) {
echo "<a href=admin.php?func=showstickynotetypes class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-sticky-note fa-lg fa-fw\"></i> ".pcrtlang("Manage Sticky Note Types")."</a><br><br>";
}


if (perm_check("1")) {
echo "<a href=admin.php?func=showscans&scantype=0 class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-bug fa-lg fa-fw\"></i> ".pcrtlang("Manage Scans")."</a><br><br>";
echo "<a href=admin.php?func=showscans&scantype=1 class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-wrench fa-lg fa-fw\"></i> ".pcrtlang("Manage Actions")."</a><br><br>";
echo "<a href=admin.php?func=showscans&scantype=2 class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-download fa-lg fa-fw\"></i> ".pcrtlang("Manage Installs")."</a><br><br>";
echo "<a href=admin.php?func=showscans&scantype=3 class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-comment fa-lg fa-fw\"></i> ".pcrtlang("Manage Notes &amp; Recommendations")."</a><br><br>";
}

if (perm_check("39")) {
echo "<a href=admin.php?func=discounts class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-comment fa-lg fa-fw\"></i> ".pcrtlang("Manage Discounts")."</a><br><br>";
}

echo "</td><td style=\"vertical-align:top\">";

if (perm_check("8")) {
echo "<a href=admin.php?func=showcustsources class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-television fa-lg fa-fw\"></i> ".pcrtlang("Manage Customer Sources")."</a><br><br>";
}

if (perm_check("13")) {
echo "<a href=admin.php?func=smstext class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-mobile fa-lg fa-fw\"></i> ".pcrtlang("Manage SMS Default Texts")."</a><br><br>";
}

if (perm_check("16")) {
echo "<a href=admin.php?func=servicereminders class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-bell-o fa-lg fa-fw\"></i> ".pcrtlang("Manage Service Reminder Messages")."</a><br><br>";
}

if (perm_check("18")) {
echo "<a href=admin.php?func=oncallusers class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-user-md fa-lg fa-fw\"></i> ".pcrtlang("Manage/Set On Call Users")."</a><br><br>";
}

if (perm_check("31")) {
echo "<a href=admin.php?func=storagelocations class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-archive fa-lg fa-fw\"></i> ".pcrtlang("Manage Storage Locations")."</a><br><br>";
}

if (perm_check("13")) {
echo "<a href=admin.php?func=creddesc class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-key fa-lg fa-fw\"></i> ".pcrtlang("Manage Credential Descriptions")."</a><br><br>";
}

if (perm_check("32")) {
echo "<a href=admin.php?func=manageportaldownloads class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-download fa-lg fa-fw\"></i> ".pcrtlang("Manage Customer Portal Downloads")."</a><br><br>";
}

if (perm_check("35")) {
echo "<a href=admin.php?func=showtags class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-tag fa-lg fa-fw\"></i> ".pcrtlang("Manage Customer Tags")."</a><br><br>";
}

if (perm_check("38")) {
echo "<a href=admin.php?func=servicepromises class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-stopwatch fa-lg fa-fw\"></i>
 ".pcrtlang("Manage Service Promises")."</a><br><br>";
}

if (perm_check("40")) {
echo "<a href=documents.php class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-file-alt fa-lg fa-fw\"></i> ".pcrtlang("Manage Form Templates")."</a><br><br>";
}

if (perm_check("43")) {
echo "<a href=admin.php?func=invoiceterms class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-file-invoice fa-lg fa-fw\"></i> ".pcrtlang("Manage Invoice Terms")."</a><br><br>";
}



echo "</td></tr></table>";

stop_blue_box();

echo "<br><br>";

if ("$ipofpc" == "admin") {
start_blue_box(pcrtlang("Admin Only Settings"));


echo "<table style=\"width:100%;\" class=pad10><tr><td style=\"width:50%;\">";


start_box();
echo "<table style=\"width:100%;\"><tr><td>";
echo "<span class=\"sizeme16 boldme\">".pcrtlang("Store Admin")."</span>";
echo "<ul>";
echo "<li>".pcrtlang("Add New Store Locations")."</li>";
echo "<li>".pcrtlang("Edit Invoice and Receipt Footer Messages")."</li>";
echo "<li>".pcrtlang("Edit Dymo Label Templates")."</li>";
echo "<li>".pcrtlang("Edit and Add Workareas")."</li>";
echo "<li>".pcrtlang("Change Main Interface Colors")."</li>";
echo "<li>".pcrtlang("Define Registers")."</li>";
echo "</ul>";
echo "</td><td>";
echo "<a href=admin.php?func=stores class=\"linkbuttonmedium linkbuttonblack radiusall floatright nowrap\">".pcrtlang("Go")."
<i class=\"fa fa-chevron-right fa-lg\"></i></a>";
echo "</td></tr></table>";
stop_box();
echo "<br>";

start_box();
echo "<table style=\"width:100%;\"><tr><td>";
echo "<span class=\"sizeme16 boldme\">".pcrtlang("Status Configuration")."</span>";
echo "<ul>";
echo "<li>".pcrtlang("Add New Work Order Statuses")."</li>";
echo "<li>".pcrtlang("Change Status Colors")."</li>";
echo "<li>".pcrtlang("Reorder Statuses")."</li>";
echo "<li>".pcrtlang("Edit Badge Display Options")."</li>";
echo "</ul>";
echo "</td><td>";
echo "<a href=admin.php?func=statusstyles class=\"linkbuttonmedium linkbuttonblack radiusall floatright nowrap\">".pcrtlang("Go")."
<i class=\"fa fa-chevron-right fa-lg\"></i></a>";
echo "</td></tr></table>";
stop_box();
echo "<br>";



start_box();
echo "<table style=\"width:100%;\"><tr><td>";
echo "<span class=\"sizeme16 boldme\">".pcrtlang("Manage Users")."</span>";
echo "<ul>";
echo "<li>".pcrtlang("Add New Users")."</li>";
echo "<li>".pcrtlang("Edit User Passwords")."</li>";
echo "</ul>";
echo "</td><td>";
echo "<a href=admin.php?func=useraccounts class=\"linkbuttonmedium linkbuttonblack radiusall floatright nowrap\">".pcrtlang("Go")." 
<i class=\"fa fa-chevron-right fa-lg\"></i></a>";
echo "</td></tr></table>";
stop_box();
echo "<br>";

start_box();
echo "<table style=\"width:100%;\"><tr><td>";
echo "<span class=\"sizeme16 boldme\">".pcrtlang("Language and Strings Editor")."</span>";
echo "<ul>";
echo "<li>".pcrtlang("Translate Into Different Languages")."</li>";
echo "<li>".pcrtlang("Customize Existing Strings")."</li>";
echo "</ul>";
echo "</td><td>";
echo "<a href=languages.php?langtoedit=$mypcrtlanguage&sortby=basestring_asc class=\"linkbuttonmedium linkbuttonblack radiusall floatright nowrap\">".pcrtlang("Go")."
<i class=\"fa fa-chevron-right fa-lg\"></i></a>";
echo "</td></tr></table>";
stop_box();
echo "<br>";

start_box();
echo "<table style=\"width:100%;\"><tr><td>";
echo "<span class=\"sizeme16 boldme\">".pcrtlang("Manage Tax Rates")."</span>";
echo "<ul>";
echo "<li>".pcrtlang("Configure Tax Rates")."</li>";
echo "<li>".pcrtlang("Create Tax Group")."</li>";
echo "</ul>";
echo "</td><td>";
echo "<a href=admin.php?func=taxrates class=\"linkbuttonmedium linkbuttonblack radiusall floatright nowrap\">".pcrtlang("Go")."
<i class=\"fa fa-chevron-right fa-lg\"></i></a>";
echo "</td><tr></table>";
stop_box();
echo "<br>";

start_box();
echo "<table style=\"width:100%;\"><tr><td>";
echo "<span class=\"sizeme16 boldme\">".pcrtlang("Manage External Framed Tools")."</span>";
echo "<ul>";
echo "<li>".pcrtlang("Create Links to Common Warranty Sites")."</li>";
echo "<li>".pcrtlang("Create Links to Driver Sites")."</li>";
echo "</ul>";
echo "</td><td>";
echo "<a href=admin.php?func=frameit class=\"linkbuttonmedium linkbuttonblack radiusall floatright nowrap\">".pcrtlang("Go")."
<i class=\"fa fa-chevron-right fa-lg\"></i></a>";
echo "</td><tr></table>";
stop_box();
echo "<br>";


start_box();
echo "<table style=\"width:100%;\"><tr><td>";
echo "<span class=\"sizeme16 boldme\">".pcrtlang("Edit Technical Document Categories")."</span>";
echo "<ul>";
echo "<li>".pcrtlang("Used for Cataloging Attachments")."</li>";
echo "<br>";
echo "</ul>";
echo "</td><td>";
echo "<a href=admin.php?func=showtechdoccats class=\"linkbuttonmedium linkbuttonblack radiusall floatright nowrap\">".pcrtlang("Go")."
<i class=\"fa fa-chevron-right fa-lg\"></i></a>";
echo "</td><tr></table>";
stop_box();
echo "<br>";


start_box();
echo "<table style=\"width:100%;\"><tr><td>";
echo "<span class=\"sizeme16 boldme\">".pcrtlang("Main Device/Asset Type Definitions")."</span>";
echo "<ul>";
echo "<li>".pcrtlang("Define Asset Types")."</li>";
echo "<li>".pcrtlang("Configure Custom Asset Fields")."</li>";
echo "<li>".pcrtlang("Specify Asset Accessories")."</li>";
echo "</ul>";
echo "</td><td>";
echo "<a href=admin.php?func=mainassets class=\"linkbuttonmedium linkbuttonblack radiusall floatright nowrap\">".pcrtlang("Go")."
<i class=\"fa fa-chevron-right fa-lg\"></i></a>";
echo "</td><tr></table>";
stop_box();
echo "<br>";

start_box();
echo "<table style=\"width:100%;\"><tr><td>";
echo "<span class=\"sizeme16 boldme\">".pcrtlang("Currency")."</span>";
echo "<ul>";
echo "<li>".pcrtlang("Define Currency Denominations")."</li>";
echo "</ul>";
echo "</td><td>";
echo "<a href=admin.php?func=denoms class=\"linkbuttonmedium linkbuttonblack radiusall floatright nowrap\">".pcrtlang("Go")."
<i class=\"fa fa-chevron-right fa-lg\"></i></a>";
echo "</td><tr></table>";
stop_box();
echo "<br>";



echo "</td><td style=\"width:50%;vertical-align:top\">";


start_box();
echo "<table style=\"width:100%;\"><tr><td>";
echo "<span class=\"sizeme16 boldme\">".pcrtlang("Download Database Backup File")."</span>";
echo "<ul>";
echo "<li>".pcrtlang("Export Your MySQL Database")."</li>";
echo "<li>".pcrtlang("Note: Does Not Include File Attachments")."</li>";
echo "<li>".pcrtlang("You can also send a backup to Dropbox")."</li>";
echo "</ul><br><br>";
echo "</td><td>";
echo "<a href=admin.php?func=backupdatabase class=\"linkbuttonmedium linkbuttonblack radiusall floatright nowrap\">".pcrtlang("Go")."
<i class=\"fa fa-chevron-right fa-lg\"></i></a>";

if (isset($dropboxappname)) {
if ($dropboxappname != "") {
echo "<br><br><br><a href=dropboxbackup.php class=\"linkbuttonmedium linkbuttonblack radiusall floatright nowrap\"><i class=\"fa fa-chevron-right fa-lg\"></i><i class=\"fa fa-dropbox fa-lg\"></i></a>";
}
}

echo "</td><tr></table>";
stop_box();
echo "<br>";

start_box();
echo "<table style=\"width:100%;\"><tr><td>";
echo "<span class=\"sizeme16 boldme\">".pcrtlang("Show PHP Info")."</span>";
echo "<ul>";
echo "<li>".pcrtlang("Show PHP Configuration Information")."</li>";
echo "<li>".pcrtlang("Troubleshooting Info")."</li>";
echo "</ul><br><br>";
echo "</td><td>";
echo "<a href=admin.php?func=showphpinfo class=\"linkbuttonmedium linkbuttonblack radiusall floatright nowrap\">".pcrtlang("Go")."
<i class=\"fa fa-chevron-right fa-lg\"></i></a>";
echo "</td></tr></table>";
stop_box();

echo "<br>";

start_box();
echo "<table style=\"width:100%;\"><tr><td>";
echo "<span class=\"sizeme16 boldme\">".pcrtlang("Server Stats")."</span><br><br>";

if (function_exists('sys_getloadavg')) {
$loadavg = sys_getloadavg();

echo "<span class=\"boldme\">".pcrtlang("Server Load").":</span> $loadavg[0], $loadavg[1], $loadavg[2]";

}

function get_processor_cores_number() {
    $command = "cat /proc/cpuinfo | grep processor | wc -l";
    return  (int) shell_exec($command);
}
function get_processor_model() {
    $command = "cat /proc/cpuinfo | grep \"model name\" | head -1";
    $result = (string) shell_exec($command);
    $result2 = explode(":", $result);
    return trim($result2[1]);
}


if (is_readable("/proc/cpuinfo")) {
$cores = get_processor_cores_number();
$model = get_processor_model();
echo "<br><span class=\"boldme\">".pcrtlang("CPU").":</span> $model"; 
echo "<br><span class=\"boldme\">".pcrtlang("CPU Cores").":</span> $cores";
}

function _getServerLoadLinuxData()
    {
        if (is_readable("/proc/stat"))
        {
            $stats = @file_get_contents("/proc/stat");

            if ($stats !== false)
            {
                // Remove double spaces to make it easier to extract values with explode()
                $stats = preg_replace("/[[:blank:]]+/", " ", $stats);

                // Separate lines
                $stats = str_replace(array("\r\n", "\n\r", "\r"), "\n", $stats);
                $stats = explode("\n", $stats);

                // Separate values and find line for main CPU load
                foreach ($stats as $statLine)
                {
                    $statLineData = explode(" ", trim($statLine));

                    // Found!
                    if
                    (
                        (count($statLineData) >= 5) &&
                        ($statLineData[0] == "cpu")
                    )
                    {
                        return array(
                            $statLineData[1],
                            $statLineData[2],
                            $statLineData[3],
                            $statLineData[4],
                        );
                    }
                }
            }
        }

        return null;
    }

    // Returns server load in percent (just number, without percent sign)
    function getServerLoad()
    {
        $load = null;

        if (stristr(PHP_OS, "win"))
        {
            $cmd = "wmic cpu get loadpercentage /all";
            @exec($cmd, $output);

            if ($output)
            {
                foreach ($output as $line)
                {
                    if ($line && preg_match("/^[0-9]+\$/", $line))
                    {
                        $load = $line;
                        break;
                    }
                }
            }
        }
        else
        {
            if (is_readable("/proc/stat"))
            {
                // Collect 2 samples - each with 1 second period
                // See: https://de.wikipedia.org/wiki/Load#Der_Load_Average_auf_Unix-Systemen
                $statData1 = _getServerLoadLinuxData();
                sleep(1);
                $statData2 = _getServerLoadLinuxData();

                if
                (
                    (!is_null($statData1)) &&
                    (!is_null($statData2))
                )
                {
                    // Get difference
                    $statData2[0] -= $statData1[0];
                    $statData2[1] -= $statData1[1];
                    $statData2[2] -= $statData1[2];
                    $statData2[3] -= $statData1[3];

                    // Sum up the 4 values for User, Nice, System and Idle and calculate
                    // the percentage of idle time (which is part of the 4 values!)
                    $cpuTime = $statData2[0] + $statData2[1] + $statData2[2] + $statData2[3];

                    // Invert percentage to get CPU time, not idle time
                    $load = 100 - ($statData2[3] * 100 / $cpuTime);
                }
            }
        }

        return $load;
    }

    //----------------------------

    $cpuLoad = getServerLoad();
    if (is_null($cpuLoad)) {
        echo "<br><span class=boldme>".pcrtlang("CPU Load").": ".pcrtlang("Estimate Not Available");
    }
    else {
        echo "<br><span class=boldme>".pcrtlang("CPU Load").":</span> ". mf("$cpuLoad") . "%";
    }


if(($dbhost != "localhost") && ($dbhost != "127.0.0.1")) {
echo "<br><br><span class=\"colormered boldme\"><i class=\"fa fa-warning fa-lg\"></i> ".pcrtlang("Warning: Your Server appears to be using a networked database server. This can result in slow performance.")."</span>";
}

echo "</td></tr></table>";
stop_box();
echo "<br>";

start_box();
echo "<table style=\"width:100%;\"><tr><td>";
echo "<span class=\"sizeme16 boldme\">".pcrtlang("Show Server Response Headers")."</span>";
echo "<ul>";
echo "<li>".pcrtlang("Use this to look for signs of your webhost using caching that can cause refresh problems")."</li>";
echo "</ul><br><br>";
echo "</td><td>";
echo "<a href=admin.php?func=viewheaders class=\"linkbuttonmedium linkbuttonblack radiusall floatright nowrap\">".pcrtlang("Go")."
<i class=\"fa fa-chevron-right fa-lg\"></i></a>";
echo "</td></tr></table>";
stop_box();
echo "<br>";



$phpver =  phpversion();

start_box();
echo "<table style=\"width:100%;\"><tr><td>";
echo "<span class=\"sizeme16 boldme\">".pcrtlang("Import Contacts")."</span>";
echo "<ul>";
echo "<li>".pcrtlang("Import Customer Contact Info From CSV")."</li>";
echo "<li>".pcrtlang("Requires PHP >= 5.3")." ".pcrtlang("Your Version").": $phpver</li>";
echo "</ul>";
echo "</td><td>";
echo "<a href=import.php class=\"linkbuttonmedium linkbuttonblack radiusall floatright nowrap\">".pcrtlang("Go")."
<i class=\"fa fa-chevron-right fa-lg\"></i></a>";
echo "</td></tr></table>";
stop_box();
echo "<br>";

start_box();
echo "<table style=\"width:100%;\"><tr><td>";
echo "<span class=\"sizeme16 boldme\">".pcrtlang("Import Inventory")."</span>";
echo "<ul>";
echo "<li>".pcrtlang("Import Inventory From CSV File")."</li>";
echo "<li>".pcrtlang("Requires PHP >= 5.3")." ".pcrtlang("Your Version").": $phpver</li>";
echo "</ul>";
echo "</td><td>";
echo "<a href=../store/importinventory.php class=\"linkbuttonmedium linkbuttonblack radiusall floatright nowrap\">".pcrtlang("Go")."
<i class=\"fa fa-chevron-right fa-lg\"></i></a>";
echo "</td></tr></table>";
stop_box();
echo "<br>";

start_box();
echo "<table style=\"width:100%;\"><tr><td>";
echo "<span class=\"sizeme16 boldme\">".pcrtlang("Create New Store Hash")."</span>";
echo "<ul>";
echo "<li>".pcrtlang("Create Hash for Integrations")."</li>";
echo "</ul>";
echo "</td><td>";
echo "<a href=admin.php?func=makehash class=\"linkbuttonmedium linkbuttonblack radiusall floatright nowrap\" onClick=\"return confirm('".pcrtlang("Are you sure you wish to generate a new hash? This will require existing integrations to be reconfigured.")."')\">".pcrtlang("Go")."
<i class=\"fa fa-chevron-right fa-lg\"></i></a>";
echo "</td></tr></table>";
stop_box();
echo "<br>";


start_box();
echo "<table style=\"width:100%;\"><tr><td>";
echo "<span class=\"sizeme16 boldme\">".pcrtlang("Integration Info")."</span>";
echo "<ul>";
echo "<li>".pcrtlang("View Setting Info for Integrations")."</li>";
echo "</ul>";
echo "</td><td>";
echo "<a href=admin.php?func=integrations class=\"linkbuttonmedium linkbuttonblack radiusall floatright nowrap\">".pcrtlang("Go")."
<i class=\"fa fa-chevron-right fa-lg\"></i></a>";
echo "</td></tr></table>";
stop_box();
echo "<br>";



echo "</td></tr></table>";



stop_blue_box();
}
require("footer.php");
}



function taxrates() {

require("header.php");
require_once("common.php");
require("deps.php");

if ("$ipofpc" != "admin") {
die("admins only");
}

echo "<a href=../repair/admin.php class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-circle-left fa-lg\"></i> ".pcrtlang("Go Back to Settings")."</a><br><br>";

$checkratessql = "SELECT * FROM taxes WHERE taxenabled = '1'";
$rs_results_c = mysqli_query($rs_connect, $checkratessql);

$totalrates = mysqli_num_rows($rs_results_c);

start_blue_box(pcrtlang("Tax Rates"));

echo "<span class=boldme>".pcrtlang("Manage Tax Rates")."</span><br><br>";

start_box();
echo "<span class=\"italme\"><i class=\"fa fa-info-circle fa-lg\"></i> ".pcrtlang("Note: You cannot modify tax rates once they have been used to process a sale. If your taxrate changes, disable the old one and add a new one.").pcrtlang("You cannot modify a tax rates while items with that tax rate exist on invoices, repair carts and saved carts").".</span>";
stop_box();
echo "<br>";
start_box();
echo "<span class=\"italme\"><i class=\"fa fa-info-circle fa-lg\"></i> ".pcrtlang("Note: You cannot modify the tax rate of a group rate. This rate is set by the sum of the individual rates.")."</span>";
stop_box();
echo "<br>";
start_box();
echo "<span class=\"italme\"><i class=\"fa fa-info-circle fa-lg\"></i> ".pcrtlang("Note: Once and individual rate is part of a group rate, you cannot edit the individual rate values, even if it has not been used to process a sale.")."</span>";
stop_box();

echo "<br><table class=standard>";

echo "<tr><th>".pcrtlang("ID")."</th><th>".pcrtlang("Rate Type")."</th><th>".pcrtlang("Name")."</th><th>".pcrtlang("Short Tax Name")."</th><th>".pcrtlang("Service/Labor Rate")."</th>";
echo "<th>".pcrtlang("Sales Tax")."</th><th colspan=3>&nbsp;</th></tr>";

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

$rs_qsi2 = "SELECT * FROM repaircart WHERE taxex = '$taxid'";
$rs_resultsi2 = mysqli_query($rs_connect, $rs_qsi2);
$totalcount2 = mysqli_num_rows($rs_resultsi2);
$totalcount = $totalcount + $totalcount2;

$rs_qsi3 = "SELECT * FROM invoice_items WHERE taxex = '$taxid'";
$rs_resultsi3 = mysqli_query($rs_connect, $rs_qsi3);
$totalcount3 = mysqli_num_rows($rs_resultsi3);
$totalcount = $totalcount + $totalcount3;

$rs_qsi4 = "SELECT * FROM rinvoice_items WHERE taxex = '$taxid'";
$rs_resultsi4 = mysqli_query($rs_connect, $rs_qsi4);
$totalcount4 = mysqli_num_rows($rs_resultsi4);
$totalcount = $totalcount + $totalcount4;

$rs_qsi5 = "SELECT * FROM savedcarts WHERE taxex = '$taxid'";
$rs_resultsi5 = mysqli_query($rs_connect, $rs_qsi5);
$totalcount5 = mysqli_num_rows($rs_resultsi5);
$totalcount = $totalcount + $totalcount5;

$rs_qsi6 = "SELECT * FROM cart WHERE taxex = '$taxid'";
$rs_resultsi6 = mysqli_query($rs_connect, $rs_qsi6);
$totalcount6 = mysqli_num_rows($rs_resultsi6);
$totalcount = $totalcount + $totalcount6;



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



echo "<tr><td style=\"$rowcolor\">$taxid</td><td>$ratetype</td><td><form action=admin.php?func=taxratesedit method=post>
<input type=text class=textbox size=10 value=\"$taxname\" name=taxname></td><td><input type=text class=textbox size=10 value=\"$shorttaxname\" name=shorttaxname>
</td><td><input type=text size=10 value=$taxrateservice name=taxrateservice $readonly></td>";
echo "<td><input type=text size=10 value=$taxrategoods name=taxrategoods $readonly>
<input type=hidden name=taxid value=$taxid></td>
<td><button type=submit class=\"linkbuttonmedium linkbuttongreen radiusall\"><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button></form></td>";



if (($taxenabled == 1) && ($totalrates > 1)) {
echo "<td><form action=admin.php?func=taxratesed method=post><input type=hidden name=taxid value=$taxid><input type=hidden name=enabled value=0><button type=submit class=\"linkbuttonmedium linkbuttonred radiusall\"><i class=\"fa fa-toggle-off fa-lg\"></i> ".pcrtlang("Disable")."</button></form></td>";
} else {
if ($taxenabled == 0) {
echo "<td><form action=admin.php?func=taxratesed method=post><input type=hidden name=taxid value=$taxid><input type=hidden name=enabled value=1>
<button type=submit class=\"linkbuttonmedium linkbuttongreen radiusall\"><i class=\"fa fa-toggle-on fa-lg\"></i> ".pcrtlang("Enable")."</button></form></td>";
}
}

if (($totalcount == '0') && (!in_array($taxid,$belongstogroup)) && ($totalrates > '1')) {
echo "<td><form action=admin.php?func=taxratesdel method=post><input type=hidden name=taxid value=$taxid><input type=hidden name=enabled value=1>
<input type=submit class=\"linkbuttonmedium linkbuttonred radiusall\" value=\"&laquo;".pcrtlang("Delete")."\"></form></td>";
} else {
echo "<td></td>";
}
echo "</tr>";

}

#redo






echo "</table><table class=standard>";

echo "<tr><td colspan=5><br><br><span class=sizeme20>".pcrtlang("Add Tax Rate").":</span> <span class=\"italme floatright\">(".pcrtlang("If your tax rate is 6.75%, you would set the rate as .0675").")</span></td></tr>";

echo "<tr><th>".pcrtlang("Name").":</th><th>".pcrtlang("Shortname").":</th><th>".pcrtlang("Service/Labor Rate").":</th>";
echo "<th>".pcrtlang("Sales Tax Rate").":</th><th colspan=2>&nbsp;</th></tr>";

echo "<tr><td><form action=admin.php?func=taxratesadd method=post><input type=text size=20 name=taxname class=textbox></td><td><input type=text size=5 name=shorttaxname class=textbox></td><td valign=top><input type=text size=12 name=taxrateservice class=textbox></td><td valign=top><input type=text size=12 name=taxrategoods class=textbox></td><td valign=top><button class=\"linkbuttonmedium linkbuttongray radiusall\" type=submit><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Add")."</button></form></td><td></td></tr>";



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

if ("$ipofpc" != "admin") {
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

if ("$ipofpc" != "admin") {
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

if ("$ipofpc" != "admin") {
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

if ("$ipofpc" != "admin") {
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

if ("$ipofpc" != "admin") {
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
$usertochange = "$ipofpc";

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

if (($demo == "yes") && ("$ipofpc" != "admin")) {
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
require("common.php");


if (($demo == "yes") && ("$ipofpc" != "admin")) {
die("Sorry this feature is disabled in demo mode");
}

if (($touchwide > "1000") || ($touchwide < "100")) {
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

if (($demo == "yes") && ("$ipofpc" != "admin")) {
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

if ("$ipofpc" != "admin") {
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

if ("$ipofpc" != "admin") {
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
if ("$ipofpc" != "admin") {
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

$rs_dcs = "DELETE FROM claimsigtext WHERE woid = '$filedwoid'";
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

$rs_deletepc4 = "DELETE FROM creds WHERE pcid = '$pcid'";
@mysqli_query($rs_connect, $rs_deletepc4);

header("Location: index.php");

}

function admindeletegroup() {
require_once("validate.php");

require("deps.php");

$pcgroupid = $_REQUEST['pcgroupid'];
if ("$ipofpc" != "admin") {
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
echo "<a href=../repair/admin.php class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-circle-left fa-lg\"></i> ".pcrtlang("Go Back to Settings")."</a><br><br>";

echo "<table class=standard>";

echo "<tr><th width=30%>".pcrtlang("Name")."</th><th width=30%>".pcrtlang("Active?/Show on Reports")."</th><th width=20%></th><th width=20%>".pcrtlang("Total Recorded")."</th></tr>";

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
echo "<span class=boldme> $thesource </span></td><td>".pcrtlang("enabled");

if($showonreport == 1) {
echo " / ".pcrtlang("yes");
} else {
echo " / ".pcrtlang("no");
}


echo "</td><td><a href=admin.php?func=editcustsource&custsourceid=$custsourceid class=\"linkbuttonsmall linkbuttongray radiusleft\">".pcrtlang("edit")."</a>";
if ($totalsources == "0") {
echo "<a href=admin.php?func=deletecustsource&custsourceid=$custsourceid class=\"linkbuttonsmall linkbuttongray radiusright\">".pcrtlang("delete")."</a>";
}

echo "</td><td align=left>$totalsources</td></tr>";

} else {
echo "<tr><td>";
if ($sourceicon != "") {
echo "<img src=images/custsources/$sourceicon align=absmiddle>"; 
}

echo " <span class=textgray12b>$thesource</span></td><td><span class=textgray12b>".pcrtlang("disabled")."";

if($showonreport == 1) {
echo " / ".pcrtlang("yes")."";
} else {
echo " / ".pcrtlang("no")."";
}

echo "</span></td><td>";
echo "<a href=admin.php?func=editcustsource&custsourceid=$custsourceid>".pcrtlang("edit")."</a>";

if ($totalsources == "0") {
echo "<a href=admin.php?func=deletecustsource&custsourceid=$custsourceid class=\"linkbuttonsmall linkbuttongray radiusright\">".pcrtlang("delete")."</a>";
}


echo "</td><td align=left>$totalsources</td><td>";
}
echo "</td></tr>";
}
echo "</table>";
echo "<br><br><a href=admin.php?func=addcustsource class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Add new Customer Source")."</a>";

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

echo "<tr><td><span class=boldme>".pcrtlang("Customer Source").":</span></td>";
echo "<td><input type=text size=35 name=thesource value=\"\"></td></tr>";
echo "<tr><td><span class=boldme>".pcrtlang("Enabled").":</span></td>";
echo "<td>";
echo "<span class=boldme>".pcrtlang("Yes").":</span><input type=radio name=sourceenabled checked value=on><br>";
echo "<span class=boldme>".pcrtlang("No").":</span><input type=radio name=sourceenabled value=off>";
echo "</td></tr>";

echo "<tr><td><span class=boldme>".pcrtlang("Show on Report").":</span></td>";
echo "<td>";
echo "<span class=boldme>".pcrtlang("Yes").":</span><input type=radio name=showonreport checked value=on><br>";
echo "<span class=boldme>".pcrtlang("No").":</span><input type=radio name=showonreport value=off>";
echo "</td></tr>";

echo "<tr><td colspan=2><span class=boldme>".pcrtlang("Choose Icon").":</span><br>";

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

if (($demo == "yes") && ("$ipofpc" != "admin")) {
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

if (($demo == "yes") && ("$ipofpc" != "admin")) {
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


if (($demo == "yes") && ("$ipofpc" != "admin")) {
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

echo "<tr><td><span class=boldme>".pcrtlang("Customer Source").":</span></td>";
echo "<td><input type=text size=35 name=thesource value=\"$thesource\" class=textbox></td></tr>";
echo "<tr><td><span class=boldme>".pcrtlang("Enabled").":</span></td>";
echo "<td>";
if($sourceenabled == 1) {
echo "<span class=boldme>".pcrtlang("Yes").":</span><input type=radio name=sourceenabled checked value=on><br>";
echo "<span class=boldme>".pcrtlang("No").":</span><input type=radio name=sourceenabled value=off>";
} else {
echo "<span class=boldme>".pcrtlang("Yes").":</span><input type=radio name=sourceenabled value=on><br>";
echo "<span class=boldme>".pcrtlang("No").":</span><input type=radio name=sourceenabled checked value=off>";
}
echo "</td></tr>";

echo "<tr><td><span class=boldme>".pcrtlang("Show on Report").":</span></td>";
echo "<td>";
if($showonreport == 1) {
echo "<span class=boldme>".pcrtlang("Yes").":</span><input type=radio name=showonreport checked value=on><br>";
echo "<span class=boldme>".pcrtlang("No").":</span><input type=radio name=showonreport value=off>";
} else {
echo "<span class=boldme>".pcrtlang("Yes").":</span><input type=radio name=showonreport value=on><br>";
echo "<span class=boldme>".pcrtlang("No").":</span><input type=radio name=showonreport checked value=off>";
}

echo "<input type=hidden value=\"$custsourceid\" name=custsourceid></td></tr>";

echo "<tr><td colspan=2><span class=boldme>".pcrtlang("Choose Icon").":</span><br>";

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

if (($demo == "yes") && ("$ipofpc" != "admin")) {
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
echo "<a href=../repair/admin.php class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-circle-left fa-lg\"></i> ".pcrtlang("Go Back to Settings")."</a><br><br>";
echo "<table class=standard>";
$rs_ql = "SELECT * FROM commonproblems";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);

echo "<tr><th>".pcrtlang("Customer Viewable")."?</th><th>".pcrtlang("Description")."</th><th></th><th></th></tr>";

while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$probid = "$rs_result_q1->probid";
$theprob = "$rs_result_q1->theproblem";
$custviewable = "$rs_result_q1->custviewable";

echo "<tr><td valign=top><form action=admin.php?func=comprobsave method=post><input type=hidden name=probid value=$probid>";

if ($custviewable == '1') {
echo "<span class=boldme>".pcrtlang("Yes").":</span><input type=radio name=active checked value=on>";
echo "<span class=boldme>".pcrtlang("No").":</span><input type=radio name=active value=off>";
} else {
echo "<span class=boldme>".pcrtlang("Yes").":</span><input type=radio name=active value=on>";
echo "<span class=boldme>".pcrtlang("No").":</span><input type=radio name=active checked value=off>";
}


echo "</td><td><input type=text name=theprob size=40 class=textbox value=\"$theprob\">";
echo "</td><td valign=top><button type=submit class=sbutton><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button></form></td><td valign=top><form action=admin.php?func=comprobdelete method=post><input type=hidden name=probid value=$probid>";
echo "<button type=submit class=ibutton><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")."</button></form></td></tr>";

}

echo "</table>";

echo "<span class=\"sizemelarge boldme\">".pcrtlang("Add").":</span><br>";
echo "<form action=admin.php?func=comprobadd method=post>";
echo "<input type=text name=theprob class=textbox size=40 value=\"\">";
echo "<button type=submit class=sbutton><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Add")."</button></form>";

stop_blue_box();

require_once("footer.php");
                                                                                                    
}


function comprobsave() {
require_once("validate.php");

require("deps.php");
require("common.php");

if (($demo == "yes") && ("$ipofpc" != "admin")) {
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

if (($demo == "yes") && ("$ipofpc" != "admin")) {
die("Sorry this feature is disabled in demo mode");
}


perm_boot("11");

if (($demo == "yes") && ("$ipofpc" != "admin")) {
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

if (($demo == "yes") && ("$ipofpc" != "admin")) {
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

$setusername = "$ipofpc";
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
echo "<a href=../repair/admin.php class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-circle-left fa-lg\"></i> ".pcrtlang("Go Back to Settings")."</a><br><br>";
echo "<table>";

echo "<tr><td valign=top><span class=boldme>".pcrtlang("Sticky Type Name")."</span></td><td valign=top><span class=boldme>".pcrtlang("Border Color")."&nbsp;&nbsp;</span></td>";
echo "<td valign=top><span class=boldme>".pcrtlang("Note Color 1")."&nbsp;&nbsp;</span></td><td valign=top><span class=boldme>".pcrtlang("Note Color 2")."&nbsp;&nbsp;</span></td>";
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
echo "<input type=color name=bordercolor size=6 value=\"#$bordercolor\"></td><td>";
echo "<input type=color name=notecolor size=6 value=\"#$notecolor\"></td><td>";
echo "<input type=color name=notecolor2 size=6 value=\"#$notecolor2\"></td><td>";
echo "</td><td valign=top><button type=submit class=sbutton><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button></form></td><td valign=top>";
echo "<form action=admin.php?func=stickynotetypedelete method=post><input type=hidden name=stickytypeid value=$stickytypeid>";
echo "<button type=submit class=ibutton><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")."</button></form></td></tr>";

}

echo "</table>";
echo "<span class=\"sizemelarge boldme\">".pcrtlang("Add").":</span><br>";

echo "<table>";
echo "<tr><td valign=top><span class=boldme>".pcrtlang("Sticky Type Name")."</span></td><td valign=top><span class=boldme>".pcrtlang("Border Color")."&nbsp;&nbsp;</span></td>";
echo "<td valign=top><span class=boldme>".pcrtlang("Note Color 1")."&nbsp;&nbsp;</span></td><td valign=top><span class=boldme>".pcrtlang("Note Color 2")."&nbsp;&nbsp;</span></td>";
echo "<td valign=top></td></tr>";

echo "<tr><td valign=top>";
echo "<form action=admin.php?func=stickynotetypeadd method=post>";
echo "<input type=text name=stickytypename class=textbox size=30 value=\"\"></td><td>";
echo "<input type=color name=bordercolor value=\"#697000\"></td><td>";
echo "<input type=color name=notecolor value=\"#f7ff76\"></td><td>";
echo "<input type=color name=notecolor2 value=\"#f7ff76\"></td><td>";
echo "<button type=submit class=sbutton><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Add")."</button></form></td><td>";
echo "</tr></table>";
stop_blue_box();

require_once("footer.php");

}


function stickynotetypesave() {
require_once("validate.php");

require("deps.php");
require("common.php");

if (($demo == "yes") && ("$ipofpc" != "admin")) {
die("Sorry this feature is disabled in demo mode");
}


perm_boot("12");

$stickytypeid = $_REQUEST['stickytypeid'];
$stickytypename = pv($_REQUEST['stickytypename']);

$bordercolor = pv(substr($_REQUEST['bordercolor'], 1));
$notecolor = pv(substr($_REQUEST['notecolor'], 1));
$notecolor2 = pv(substr($_REQUEST['notecolor2'], 1));



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

if (($demo == "yes") && ("$ipofpc" != "admin")) {
die("Sorry this feature is disabled in demo mode");
}


perm_boot("12");

if (($demo == "yes") && ("$ipofpc" != "admin")) {
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

if (($demo == "yes") && ("$ipofpc" != "admin")) {
die("Sorry this feature is disabled in demo mode");
}


perm_boot("12");

$stickytypename = pv($_REQUEST['stickytypename']);

$bordercolor = pv(substr($_REQUEST['bordercolor'], 1));
$notecolor = pv(substr($_REQUEST['notecolor'], 1));
$notecolor2 = pv(substr($_REQUEST['notecolor2'], 1));




mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "INSERT INTO stickytypes (stickytypename,bordercolor,notecolor,notecolor2) VALUES ('$stickytypename','$bordercolor','$notecolor','$notecolor2')";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=showstickynotetypes");


}



function backupdatabase() {
require_once("validate.php");

require("deps.php");
require("common.php");

if (($demo == "yes") && ("$ipofpc" != "admin")) {
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

foreach($row as $key => $value) { $data['keys'][] = $key; $data['values'][] = addslashes($value); }
 
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

if ("$ipofpc" != "admin") {
die("admins only");
}

echo "<a href=../repair/admin.php class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-circle-left fa-lg\"></i> ".pcrtlang("Go Back to Settings")."</a><br><br>";

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
echo "<table><tr><td style=\"vertical-align:top\"><table class=standard style=\"width:90%\">";
if ($storeenabled == 1) {
echo "<tr><td valign=top><form action=admin.php?func=savestore method=post><input type=hidden name=storeid value=$storeid>";
echo "<span class=boldme>".pcrtlang("Store Short Name").":</span></td><td><input type=text name=storesname size=10 value=\"$storesname\" class=textbox></td></tr>";
echo "<tr><td><span class=boldme>".pcrtlang("Store/Business Name")."</span></td><td><input type=text name=storename size=25 value=\"$storename\" class=textbox></td></tr>";
echo "<tr><td><span class=boldme>$pcrt_address1</span></td><td><input type=text name=storeaddy1 size=20 value=\"$storeaddy1\" class=textbox></td></tr>";
echo "<tr><td><span class=boldme>$pcrt_address2</span></td><td><input type=text name=storeaddy2 size=20 value=\"$storeaddy2\" class=textbox></td></tr>";
echo "<tr><td><span class=boldme>$pcrt_city</span></td><td><input type=text name=storecity size=10 value=\"$storecity\" class=textbox></td></tr>";
echo "<tr><td><span class=boldme>$pcrt_state</span></td><td><input type=text name=storestate size=10 value=\"$storestate\" class=textbox></td></tr>";
echo "<tr><td><span class=boldme>$pcrt_zip</span></td><td><input type=text name=storezip size=12 value=\"$storezip\" class=textbox></td></tr>";
echo "<tr><td><span class=boldme>".pcrtlang("Email")."</span></td><td><input type=text name=storeemail size=25 value=\"$storeemail\" class=textbox></td></tr>";
echo "<tr><td><span class=boldme>".pcrtlang("Phone")."</span></td><td><input type=text name=storephone size=15 value=\"$storephone\" class=textbox></td></tr>";
echo "<tr><td><span class=boldme>".pcrtlang("CC Email")."</span><br><span class=\"sizemesmaller italme\">".pcrtlang("enter email address to have a copy of all emailed invoices, receipts, reports sent to or leave blank for none.")."</span></td><td><input type=text name=storeccemail size=15 value=\"$storeccemail\" class=textbox></td></tr>";
echo "<tr><td valign=top colspan=2><button type=submit class=\"button floatright\"><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save Store")."</button></form></td></tr>";
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



echo "</table><br><br>";


if ($storeenabled == 1) {
start_box();

echo "<table>";
echo "<tr><td valign=top><span class=\"sizemelarge boldme\">".pcrtlang("Registers").":</span></td><td colspan=2></td></tr>";
$rs_qb = "SELECT * FROM registers WHERE registerstoreid = '$storeid'";
$rs_resultb = mysqli_query($rs_connect, $rs_qb);
while($rs_result_qb = mysqli_fetch_object($rs_resultb)) {
$registerid = "$rs_result_qb->registerid";
$registername = "$rs_result_qb->registername";


echo "<tr><td valign=top>";


echo "<form action=admin.php?func=registersave method=post><input type=hidden name=registerid value=$registerid>";
echo "<input type=text name=registername size=25 value=\"$registername\" class=textbox placeholder=\"".pcrtlang("Enter Name or ID")."\"></td>";
echo "<td valign=top><input type=submit value=\"&laquo;".pcrtlang("Save")."\" class=button></form></td>";
echo "<td valign=top><form action=admin.php?func=registerdelete method=post>";
echo "<input type=hidden name=registerid value=$registerid>";
echo "<input type=submit value=\"&laquo;".pcrtlang("Delete")."\" class=button></form></td></tr>";

}
echo "<tr><td colspan=4>&nbsp;</td></tr>";

echo "<tr><td valign=top><span class=\"sizemelarge boldme\">".pcrtlang("Add Register").":</span></td>";
echo "<td colspan=2></td></tr>";
echo "<tr><td><form action=admin.php?func=registeradd method=post><input type=hidden name=registerstoreid value=$storeid>";
echo "<input type=text name=registername size=15 value=\"\" class=textbox></td>";
echo "<td colspan=2><button type=submit class=ibutton><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Add")."</button></form></td></tr>";
echo "</table>";


stop_box();
echo "<br><br>";
}



echo "</td><td valign=top>";

if ($storeenabled == 1) {
start_box();

echo "<table>";
echo "<tr><td valign=top><span class=\"sizemelarge boldme\">".pcrtlang("Workareas").":</span></td><td><span class=\"sizemelarge boldme\">".pcrtlang("Color")."</span></td><td colspan=2></td></tr>";
$rs_qb = "SELECT * FROM benches WHERE storeid = '$storeid'";
$rs_resultb = mysqli_query($rs_connect, $rs_qb);
while($rs_result_qb = mysqli_fetch_object($rs_resultb)) {
$benchid = "$rs_result_qb->benchid";
$benchname = "$rs_result_qb->benchname";
$benchcolor = "$rs_result_qb->benchcolor";


echo "<tr><td valign=top>";


echo "<form action=admin.php?func=benchsave method=post><input type=hidden name=benchid value=$benchid>";
echo "<input type=text name=benchname size=15 value=\"$benchname\" class=textbox></td><td><input type=color name=benchcolor value=\"#$benchcolor\">";
echo "</td><td valign=top><input type=submit value=\"&laquo;".pcrtlang("Save")."\" class=button></form></td>";
echo "<td valign=top><form action=admin.php?func=benchdelete method=post>";
echo "<input type=hidden name=benchid value=$benchid>";
echo "<input type=submit value=\"&laquo;".pcrtlang("Delete")."\" class=button></form></td></tr>";

}
echo "<tr><td colspan=4>&nbsp;</td></tr>";

echo "<tr><td valign=top><span class=\"sizemelarge boldme\">".pcrtlang("Add Workarea").":</span></td>";
echo "<td><span class=\"sizemelarge boldme\">".pcrtlang("Color")."</span></td><td colspan=2></td></tr>";
echo "<tr><td><form action=admin.php?func=benchadd method=post><input type=hidden name=benchstoreid value=$storeid>";
echo "<input type=text name=benchname size=15 value=\"\" class=textbox></td><td><input type=color name=benchcolor value=\"#efefef\">";
echo "</td><td colspan=2><button type=submit class=ibutton><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Add")."</button></form></td></tr>";
echo "</table>";

stop_box();
echo "<br><br>";
}


if ($storeenabled == 1) {
start_box();
echo "<table style=\"width:100%\"><tr><td>";
echo "<span class=\"sizeme16 boldme\">".pcrtlang("Edit Terms and Other Texts")."</span>";
echo "<ul><li>".pcrtlang("Invoice Footer")."</li>";
echo "<li>".pcrtlang("Return Policy")."</li>"; 
echo "<li>".pcrtlang("Deposit Footer")."</li>"; 
echo "<li>".pcrtlang("Repair Report Footer")."</li>";
echo "<li>".pcrtlang("Quote Footer")."</li>";
echo "<li>".pcrtlang("Thank You Letter Text")."</li>"; 
echo "<li>".pcrtlang("Checkout Receipt")."</li></ul>";
echo "</td><td><a href=\"admin.php?func=editfootertext&storeid=$storeid\" class=\"linkbuttonmedium linkbuttonblack radiusall floatright\">".pcrtlang("Go")." <i class=\"fa fa-chevron-right fa-lg\"></i></a></td></tr></table>";
stop_box();

echo "<br><br>";
start_box();
echo "<table style=\"width:100%\"><tr><td>";
echo "<span class=\"sizeme16 boldme\">".pcrtlang("Dymo Label Templates")."</span></td><td>";
echo "<a href=\"admin.php?func=editdymotemp&storeid=$storeid\"  class=\"linkbuttonmedium linkbuttonblack radiusall floatright\">".pcrtlang("Go")." <i class=\"fa fa-chevron-right fa-lg\"></i></a>";
echo "</td></tr></table>";
stop_box();

}

echo "</td></tr></table>";

if ($storeenabled == 1) {

echo "<br><br>";
start_box();
echo "<table><tr><td><span class=boldme>".pcrtlang("Menu Button").":</span></td><td><form action=admin.php?func=colorssave method=post><input type=hidden name=storeid value=$storeid>";
echo "<input type=color name=linecolor1 value=\"#$linecolor1\"\">";
echo "</td><td><input type=color name=linecolor2 value=\"#$linecolor2\"\"></td>";
echo "<td rowspan=3 style=\"vertical-align:middle;text-align:center;\">";

echo "<span class=\"sizemelarger boldme\" style=\"margin-left:40px;\">".pcrtlang("Interface Color Swatches")."</span><br>";

echo "<span class=\"sizemelarge\" style=\"margin-left:40px;\">".pcrtlang("Choose a color swatch below or create your own").".</span>";

echo "</td></tr>";
echo "<tr><td><span class=boldme>".pcrtlang("Background Colors").":</span></td><td><input type=color name=bgcolor1 value=\"#$bgcolor1\"\">";
echo "</td><td><input type=color name=bgcolor2 value=\"#$bgcolor2\"\"></td></tr>";
echo "<tr><td>";
echo "<a href=\"admin.php?func=colorssave&storeid=$storeid&linecolor1=cccccc&linecolor2=cccccc&bgcolor1=333333&bgcolor2=ffffff\" class=\"linkbuttonmedium linkbuttongray radiusall\">".pcrtlang("Default Colors")."</a>";
echo "</td><td valign=top colspan=2><input type=submit value=\"".pcrtlang("Save Interface Colors")."\" class=button></form></table><br>";
 
#####

echo "<table><tr>";
$a = 0;
$rs_sw = "SELECT * FROM swatches";
$rs_resultsw = mysqli_query($rs_connect, $rs_sw);
while($rs_result_sw = mysqli_fetch_object($rs_resultsw)) {
$swatchid = "$rs_result_sw->swatchid";
$sw1 = "$rs_result_sw->sw1";
$sw2 = "$rs_result_sw->sw2";
$sw3 = "$rs_result_sw->sw3";
$sw4 = "$rs_result_sw->sw4";

if($a % 7 == 0) {
echo "</tr><tr>";
}

echo "<td style=\"padding:5px;\">";

echo "<table style=\"border-collapse:collapse;background: #$sw3;\" class=\"addashadow\">";
echo "<tr><td style=\"background: linear-gradient(#$sw1, #$sw2); border-bottom-right-radius:4px;padding:4px;\"><span style=\"color:#ffffff\"><strong>".pcrtlang("menu")."</strong></span></td>";
echo "<td style=\"background: #$sw4;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>";
echo "<tr><td style=\"background: #$sw3;\"><br><br></td><td style=\"background: #$sw4;\">";
echo "<a href=\"admin.php?func=deleteswatch&swatchid=$swatchid\" class=\"linkbuttonsmall linkbuttonopaque\" onClick=\"return confirm('".pcrtlang("Are you sure you wish to delete this color swatch permanently?")."')\"><i class=\"fa fa-times fa-lg\"></i></a>";
echo "<a href=\"admin.php?func=colorssave&storeid=$storeid&linecolor1=$sw1&linecolor2=$sw2&bgcolor2=$sw4&bgcolor1=$sw3\" class=\"linkbuttonsmall linkbuttonopaque\"><i class=\"fa fa-chevron-right fa-lg\"></i></a>";
echo "</td></tr>";
echo "</table></td>";

$a++;

}

echo "</tr></table>";

####



stop_box();

}

#echo "</td></tr></table>";
stop_blue_box();
echo "<br>";


}

start_blue_box(pcrtlang("Add New Store"));

echo "<table>";
echo "<tr><td valign=top><form action=admin.php?func=addstore method=post>";
echo "<span class=boldme>".pcrtlang("Store Short Name").":</span></td><td><input type=text name=storesname size=10 class=textbox></td></tr>";
echo "<tr><td><span class=boldme>".pcrtlang("Store/Business Name")."</span></td><td><input type=text name=storename size=25 class=textbox></td></tr>";
echo "<tr><td><span class=boldme>$pcrt_address1</span></td><td><input type=text name=storeaddy1 size=20 class=textbox></td></tr>";
echo "<tr><td><span class=boldme>$pcrt_address2</span></td><td><input type=text name=storeaddy2 size=20 class=textbox></td></tr>";
echo "<tr><td><span class=boldme>$pcrt_city</span></td><td><input type=text name=storecity size=10 class=textbox></td></tr>";
echo "<tr><td><span class=boldme>$pcrt_state</span></td><td><input type=text name=storestate size=10 class=textbox></td></tr>";
echo "<tr><td><span class=boldme>$pcrt_zip</span></td><td><input type=text name=storezip size=12 class=textbox></td></tr>";
echo "<tr><td><span class=boldme>".pcrtlang("Email")."</span></td><td><input type=text name=storeemail size=30 class=textbox></td></tr>";
echo "<tr><td><span class=boldme>".pcrtlang("Phone")."</span></td><td><input type=text name=storephone size=15 class=textbox></td></tr>";
echo "<tr><td valign=top colspan=2><input type=submit value=\"".pcrtlang("Add New Store")."\" class=button></form></td></tr>";
echo "</table>";

stop_blue_box();

require_once("footer.php");

}


function savestore() {
require_once("validate.php");

require_once("common.php");
require("deps.php");

if ("$ipofpc" != "admin") {
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

if ("$ipofpc" != "admin") {
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

if ("$ipofpc" != "admin") {
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

if ("$ipofpc" != "admin") {
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
$ruri2 = "../repair/admin.php";
} elseif (preg_match("/repair\//i", $ruri)) {
$ruri2 = "../repair";
} else {
$ruri2 = "../store";
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

if ("$ipofpc" != "admin") {
die("admins only");
}

$benchid = $_REQUEST['benchid'];
$benchname = pv($_REQUEST['benchname']);
$benchcolor = pv(substr($_REQUEST['benchcolor'], 1));



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "UPDATE benches SET benchname = '$benchname', benchcolor = '$benchcolor' WHERE benchid = '$benchid'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=stores");

}


function benchdelete() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ("$ipofpc" != "admin") {
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

if ("$ipofpc" != "admin") {
die("admins only");
}


$benchstoreid = pv($_REQUEST['benchstoreid']);
$benchname = pv($_REQUEST['benchname']);
$benchcolor = pv($_REQUEST['benchcolor']);
$benchcolor = pv(substr($_REQUEST['benchcolor'], 1));




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


function reorderstatus() {
require_once("validate.php");

$statusid = $_REQUEST['statusid'];
$dir = $_REQUEST['dir'];
$theorder = $_REQUEST['theorder'];

require("deps.php");
require_once("common.php");



mysqli_query($rs_connect, "SET NAMES 'utf8'");

if ($dir == "up") {
$rs_sq = "SELECT * FROM boxstyles WHERE displayedorder < '$theorder' ORDER BY displayedorder DESC LIMIT 1";
} else {
$rs_sq = "SELECT * FROM boxstyles WHERE displayedorder > '$theorder' ORDER BY displayedorder ASC LIMIT 1";
}
$rs_result1 = mysqli_query($rs_connect, $rs_sq);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
if(mysqli_num_rows($rs_result1) == "0") {
$nextorder = "$theorder";
} else {
$nextorder = "$rs_result_q1->displayedorder";
}


if ($dir == "up") {
$neworder = $nextorder - 1;
} else {
$neworder = $nextorder + 1;
}

$rs_insert_scan = "UPDATE boxstyles SET displayedorder = '$neworder' WHERE statusid = $statusid";
@mysqli_query($rs_connect, $rs_insert_scan);


$rs_resetorder = "SELECT * FROM boxstyles ORDER BY displayedorder ASC";
$rs_resultreset = mysqli_query($rs_connect, $rs_resetorder);
$a = 0;
while($rs_result_r1 = mysqli_fetch_object($rs_resultreset)) {
$statusid2 = "$rs_result_r1->statusid";
$rs_set_order = "UPDATE boxstyles SET displayedorder = '$a' WHERE statusid = $statusid2";
@mysqli_query($rs_connect, $rs_set_order);
$a = $a + 5;
}

$rs_set_order = "UPDATE boxstyles SET displayedorder = '1000' WHERE selectablestatus = '0'";
@mysqli_query($rs_connect, $rs_set_order);



header("Location: admin.php?func=statusstyles#g$statusid");

}




function editfootertext() {
require("header.php");
require_once("common.php");
require("deps.php");

if ("$ipofpc" != "admin") {
die("admins only");
}

$rs_storeid = $_REQUEST['storeid'];


$storeinfoarray = getstoreinfo($rs_storeid);
echo "<form id=mainform action=admin.php?func=editfootertext2 method=post><input type=hidden name=storeid value=\"$rs_storeid\">";

start_box();

echo "<span class=\"sizemelarge boldme\">".pcrtlang("Edit Footer Texts for Store").": $storeinfoarray[storesname]</span><br><br>";

echo "<a href=admin.php?func=stores class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-left fa-lg\"></i> ".pcrtlang("Return to Store Admin")."</a>";
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
echo pcrtlang("Feel free to use html markup or any styles from the style.css stylesheet. Common stock styles are sizemesmaller, boldme, italme");

echo "<br><br>".pcrtlang("You can also surround areas of text with a div tag and adjusted line-height to cram more text onto the page like this:")."<br><br>";
echo htmlentities("<div style=\"line-height:70%;\">My Text</div>");

stop_box();
require_once("footer.php");

}


function editfootertext2() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ("$ipofpc" != "admin") {
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

echo "<a href=../repair/admin.php class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-circle-left fa-lg\"></i> ".pcrtlang("Go Back to Settings")."</a><br><br>";

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

echo "<span class=\"sizemelarge boldme\">".pcrtlang("Add").":</span><br>";
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

if (($demo == "yes") && ("$ipofpc" != "admin")) {
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

if (($demo == "yes") && ("$ipofpc" != "admin")) {
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

if (($demo == "yes") && ("$ipofpc" != "admin")) {
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

if (($demo == "yes") && ("$ipofpc" != "admin")) {
die("Sorry this feature is disabled in demo mode");
}

$storeid = $_REQUEST['storeid'];
$linecolor1 = pv($_REQUEST['linecolor1']);
$linecolor2 = pv($_REQUEST['linecolor2']);
$bgcolor1 = pv($_REQUEST['bgcolor1']);
$bgcolor2 = pv($_REQUEST['bgcolor2']);

if(strlen($bgcolor2) > 6) {
$linecolor1 = pv(substr($_REQUEST['linecolor1'], 1));
$linecolor2 = pv(substr($_REQUEST['linecolor2'], 1));
$bgcolor1 = pv(substr($_REQUEST['bgcolor1'], 1));
$bgcolor2 = pv(substr($_REQUEST['bgcolor2'], 1));
}




mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "UPDATE stores SET linecolor1 = '$linecolor1', linecolor2 = '$linecolor2', bgcolor1 = '$bgcolor1', bgcolor2 = '$bgcolor2' 
WHERE storeid = '$storeid'";
@mysqli_query($rs_connect, $rs_insert_scan);

$checkswatch =  "SELECT * FROM swatches WHERE sw1 = '$linecolor1' AND sw2 = '$linecolor2' AND sw3 = '$bgcolor1' AND sw4 = '$bgcolor2'";
$rs_result_chk = mysqli_query($rs_connect, $checkswatch);
$totalswatch = mysqli_num_rows($rs_result_chk);

if($totalswatch == 0) {
$rs_insert_swatch = "INSERT INTO swatches (sw1,sw2,sw3,sw4) VALUES ('$linecolor1', '$linecolor2', '$bgcolor1', '$bgcolor2')";
@mysqli_query($rs_connect, $rs_insert_swatch);
}

header("Location: admin.php?func=stores");


}



function showtechdoccats() {

require("header.php");
require_once("common.php");
require("deps.php");

echo "<a href=../repair/admin.php class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-circle-left fa-lg\"></i> ".pcrtlang("Go Back to Settings")."</a><br><br>";

if ("$ipofpc" != "admin") {
die("admins only");
}




mysqli_query($rs_connect, "SET NAMES 'utf8'");

$boxtitle = pcrtlang("Technical Document Categories");

start_blue_box("$boxtitle");


echo "<table class=standard>";

echo "<tr><td><span class=\"sizemelarge boldme\"u>".pcrtlang("Category Name")."</span></td><td></td></tr>";

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
echo "<span class=boldme> $techdoccatname </span></td><td><a href=admin.php?func=edittechdoccat&techdoccatid=$techdoccatid&techdoccatname=$techdoccatname2>".pcrtlang("edit")."</a> <span class=boldme>|</span> ";
if ($totaldocs == "0") {
echo "<a href=admin.php?func=deletetechdoccat&techdoccatid=$techdoccatid>".pcrtlang("delete")."</a>";
} 

echo "</td></tr>";
}
echo "</table>";

echo "<br><span class=boldme>".pcrtlang("Add New Technical Document Category")."</span><br>";

echo "<form method=post action=\"admin.php?func=addtechdoccat\"><input type=text class=textbox name=techdoccatname size=30><input class=button type=submit value=\"".pcrtlang("Add")."\"></form>";

stop_blue_box();
echo "<br><br>";

require_once("footer.php");

}



function addtechdoccat() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ("$ipofpc" != "admin") {
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

if ("$ipofpc" != "admin") {
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

if ("$ipofpc" != "admin") {
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

if ("$ipofpc" != "admin") {
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
echo "<a href=../repair/admin.php class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-circle-left fa-lg\"></i> ".pcrtlang("Go Back to Settings")."</a><br><br>";
echo "<table>";
$rs_ql = "SELECT * FROM smstext ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$smstextid = "$rs_result_q1->smstextid";
$smstext = "$rs_result_q1->smstext";
$theorder = "$rs_result_q1->theorder";

echo "<tr><td><form action=admin.php?func=smstextsave method=post><input type=hidden name=smstextid value=$smstextid>";

echo "<a href=admin.php?func=reordersmstext&stid=$smstextid&dir=up&theorder=$theorder class=\"linkbuttonsmall linkbuttongray radiusleft\">
<i class=\"fa fa-chevron-up fa-lg\"></i></a>";
echo "<a href=admin.php?func=reordersmstext&stid=$smstextid&dir=down&theorder=$theorder class=\"linkbuttonsmall linkbuttongray radiusright\">
<i class=\"fa fa-chevron-down fa-lg\"></i></a>";
echo "</td><td><textarea name=smstext rows=3 cols=50 class=textbox>$smstext</textarea>";
echo "</td><td><button type=submit class=sbutton><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button></form></td><td>
<form action=admin.php?func=smstextdelete method=post>";
echo "<input type=hidden name=smstextid value=$smstextid>";
echo "<button type=submit class=ibutton><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")."</button></form></td></tr>";
 
} 
 
echo "</table>";

echo "<span class=\"sizemelarge boldme\">".pcrtlang("Add").":</span><br>";
echo "<form action=admin.php?func=smstextadd method=post>";
echo "<textarea name=smstext rows=3 cols=50 value=\"\" class=textbox></textarea><br>";
echo "<button type=submit class=sbutton><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Add")."</button></form>";

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

if (($demo == "yes") && ("$ipofpc" != "admin")) {
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

if ("$ipofpc" != "admin") {
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

if ("$ipofpc" != "admin") {
die("admins only");
}

echo "<a href=../repair/admin.php class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-circle-left fa-lg\"></i> ".pcrtlang("Go Back to Settings")."</a><br><br>";

mysqli_query($rs_connect, "SET NAMES 'utf8'");

$origthestatii = array("1" => "Waiting for Bench", "2" => "On the Bench", "3" => "Pending / On Hold", "4" => "Completed/Ready for Pickup", "5" => "Picked up by Customer", "6" => "Waiting for Payment", "7" => "Ready to Sell", "8" => "On Service Call", "9" => "Remote Support Sessions", "50" => "Standard Title Boxes", "51" => "Standard Inventory Title Boxes", "52" => "Invoice List Box", "53" => "Overdue Invoice Box");


$rs_findstatii = "SELECT * FROM boxstyles ORDER BY selectablestatus DESC, displayedorder ASC";
$rs_result_st = mysqli_query($rs_connect, $rs_findstatii);
while($rs_result_stq = mysqli_fetch_object($rs_result_st)) {
$thestatii[] = "$rs_result_stq->statusid";
}

start_box();
echo "<span class=\"sizemelarge boldme\">".pcrtlang("Status Configuration")."</span>";
stop_box();
echo "<br><br>";
start_box();
echo "<span class=\"sizemelarge boldme\">".pcrtlang("Add New Custom Status")."</span>";
echo "<table><tr><td><form action=admin.php?func=customstatusstylesnew method=post><span class=boldme>".pcrtlang("Status ID Number").":</span></td>";
echo "<td><input type=text name=statusid class=textbox> <span class=\"sizemesmaller italme\">".pcrtlang("Choose any number 100 or larger not already in use.")."</span>";

echo " <span class=\"sizemesmaller italme\">".pcrtlang("Numbers in use").": ";
reset($thestatii);
foreach($thestatii as $k => $v) {
if($v > 99) {
echo "$v ";
}
}

echo "</span></td></tr><tr><td><span class=boldme>".pcrtlang("Status Title").":</span></td>";
echo "<td><input type=text name=boxtitle class=textbox></td><tr><td><span class=boldme>".pcrtlang("Status Color").":</span></td><td>";
echo "<input type=color name=selectorcolor value=\"#a4c400\"></td></tr></table>";
echo "<input type=submit class=button value=\" ".pcrtlang("Add Custom Status")." \"></form>";
stop_box();

reset($thestatii);


$prevstatustype = 1;

foreach($thestatii as $k => $v) {
$rs_gets2 = "SELECT * FROM boxstyles WHERE statusid = '$v'";
$rs_results2 = mysqli_query($rs_connect, $rs_gets2);
$rs_result_qs2 = mysqli_fetch_object($rs_results2);
$selectorcolor2 = "$rs_result_qs2->selectorcolor";
$boxtitle2 = "$rs_result_qs2->boxtitle";
$statusoptions2 = serializedarraytest("$rs_result_qs2->statusoptions");
$displayedstatus2 = "$rs_result_qs2->displayedstatus";
$theorder = "$rs_result_qs2->displayedorder";
$selectablestatus2 = "$rs_result_qs2->selectablestatus";
$collapsedstatus = "$rs_result_qs2->collapsedstatus";

if($prevstatustype != $selectablestatus2) {

echo "<br><br>";
start_box();
echo "<span class=\"sizemelarge boldme\">Other Color Boxes</span>";
stop_box();
}


$prevstatustype = $selectablestatus2;

echo "<a name=g$v></a><br><br><br><div class=\"colortitletopround\" style=\"background:#$selectorcolor2\"><span class=\"colormewhite sizemelarger textoutline\">$boxtitle2</span>";

if($v == 1) {
$lighter = adjustBrightness("$selectorcolor2]", 200);
echo " <span class=\"floatright radiusall boldme\" style=\"background:$lighter;color:#$selectorcolor2;padding:3px;\">".pcrtlang("Default Landing Status for New Work Orders")."</span>";
} elseif($v == 4) {
$lighter = adjustBrightness("$selectorcolor2]", 200);
echo " <span class=\"floatright radiusall boldme\" style=\"background:$lighter;color:#$selectorcolor2;padding:3px;\">".pcrtlang("Default Resting Status for Completed Work Orders")."</span>";
} elseif($v == 5) {
$lighter = adjustBrightness("$selectorcolor2]", 200);
echo " <span class=\"floatright radiusall boldme\" style=\"background:$lighter;color:#$selectorcolor2;padding:3px;\">".pcrtlang("Default Landing Status for Closed Work Orders")."</span>";
} elseif($v == 7) {
$lighter = adjustBrightness("$selectorcolor2]", 200);
echo " <span class=\"floatright radiusall boldme\" style=\"background:$lighter;color:#$selectorcolor2;padding:3px;\">".pcrtlang("Items Show in Point of Sale Categories")."</span>";
}

echo "</div>";
echo "<div class=\"whitebottom\">";

echo "<table style=\"width:100%\">";
echo "<tr><td valign=top colspan=2><form action=admin.php?func=statusstylessave method=post><input type=hidden name=statusid value=$v>";


if (($v < 50) || ($v > 99)) {
echo "<tr><td style=\"width:50%\"><span class=boldme>".pcrtlang("Custom Box Title").":</span>";

if(array_key_exists($v, $origthestatii)) {
echo " <span class=italme>(".pcrtlang("Default").": $origthestatii[$v])</span>";
}

echo "</td><td>";
echo "<input type=text name=boxtitle class=textbox value=\"$boxtitle2\" style=\"width:200px;\">";
} else {
echo "<input type=hidden name=boxtitle value=\"$boxtitle2\">";
}

echo "</td>";

echo "<td style=\"text-align:center;\">";

if($selectablestatus2 == 1) {
echo "<a href=admin.php?func=reorderstatus&statusid=$v&dir=up&theorder=$theorder class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-up\"></i></a>";
}

echo "</td>";

echo "</tr>";

echo "<tr><td style=\"width:50%\"><span class=boldme>".pcrtlang("Color").":</span></td><td><input type=color name=selectorcolor value=\"#$selectorcolor2\" style=\"border: none;\"></td>";

echo "<td style=\"text-align:center;\">";

if($selectablestatus2 == 1) {
echo "<a href=admin.php?func=reorderstatus&statusid=$v&dir=down&theorder=$theorder class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-down\"></i></a>";
}

echo "</td>";


echo "</tr>";


echo "<tr><td><input type=submit value=\"".pcrtlang("Save")."\" class=button></form>";



echo "</td><td>";

if ($v > 99) {
echo "<a href=\"admin.php?func=cstatusdelete&cstatusid=$v\" onClick=\"return confirm('".pcrtlang("Are you sure you wish to delete this custom status?")."')\" class=\"linkbuttonmedium linkbuttongray radiusall\">".pcrtlang("Delete this Custom Status")."</a>";
}

if($displayedstatus2 == 1) {
if($collapsedstatus == 0) {
echo "<a href=\"admin.php?func=collapsestatus&statusid=$v&collapse=1\" 
class=\"linkbuttonmedium linkbuttongray radiusall\">".pcrtlang("Collapse this Status")."</a>";
} else {
echo "<a href=\"admin.php?func=collapsestatus&statusid=$v&collapse=0\"
class=\"linkbuttonmedium linkbuttongray radiusall\">".pcrtlang("Un-Collapse this Status")."</a>";
}
}

echo "</td></tr>";

if($displayedstatus2 == 1) {

echo "<tr><td colspan=3><br>";

echo "<a href=\"javascript:void(0);\" class=\"linkbuttonmedium linkbuttongray radiusall displayblock\" id=clickstatus$v>".pcrtlang("Status Options")." <i class=\"fa fa-chevron-down\"></i></a>";

echo "<div id=statusbox$v style=\"display:none;border:2px #cccccc solid; padding:5px;\" class=radiusall>";

$statiidispopt = array(
"1" => "Badge Options",
"bcompany" => "Show Company", 
"bwoids" => "Show Asset ID/Work Order Number", 
"bproblem" => "Show Problem Description",
"bskedjobs" => "Show Scheduled Job Info", 
"bassettype" => "Show Asset Type", 
"bdaysinshop" => "Show days in the shop value", 
"bpassword" => "Show Passwords/Pins", 
"bpattern" => "Show Pattern Password",
"bassigneduser" => "Show Assigned User", 
"brepaircart" => "Show Repair Cart Total",
"bpreferredcontact" => "Show Preferred Contact Method",
"bmakeicon" => "Show Device Make Icon",
"bstatuscheck" => "Show Customer Repair Status Check Icon",
"bdevicepriority" => "Show Device Priority Icon",
"bcalled" => "Show Call Status Icon",
"bmsp" => "Show Service Contract",
"bstoragelocation" => "Show Storage Location",
"bprogresscounters" => "Show Progress Counters",
"2" => "Expanded Info Area Options",
"eproblem" => "Show Problem Description",
"enotes" => "Show Technician Notes",
"ecnotes" => "Show Customer Notes",
"epreferredcontact" => "Show Preferred Contact Info",
"epasswords" => "Show Passwords",
"eassigneduser" => "Show Assigned User",
"erepaircart" => "Show Repair Cart Total",
"estatuscheck" => "Show Customer Repair Status Check Info",
"eassettype" => "Show Asset Type",
"emsp" => "Show Service Contract",
"3" => "Work Bench Options",
"workbench" => "Show Work Areas",
"4" => "Mobile Badge Options",
"mcompany" => "Show Company",
"mwoids" => "Show Asset ID/Work Order Number",
"mskedjobs" => "Show Scheduled Job Info",
"massettype" => "Show Asset Type",
"mdaysinshop" => "Show days in the shop value",
"mpassword" => "Show Password",
"massigneduser" => "Show Assigned User",
"mrepaircart" => "Show Repair Cart Total",
"mstatuscheck" => "Show Customer Repair Status Check Icon",
"mmsp" => "Show Service Contract"
);


echo "<form action=admin.php?func=statusoptionssave method=post><input type=hidden name=statusid value=$v>";

foreach($statiidispopt as $key => $val) {
if (is_numeric($key)) {
echo "<br><span class=boldme>".pcrtlang("$val")."</span><br>";
} else {
if(in_array($key, $statusoptions2)) {
echo "<input type=checkbox checked name=statusoptions[] value=\"$key\"> ".pcrtlang("$val")."<br>";
} else {
echo "<input type=checkbox name=statusoptions[] value=\"$key\"> ".pcrtlang("$val")."<br>";
}
}

}

echo "<input type=submit value=\"".pcrtlang("Save Status List Options")."\" class=button>";

echo "</form>";

echo "</div>";

?>
<script type='text/javascript'>

$('#clickstatus<?php echo $v; ?>').click(function(){
  $('#statusbox<?php echo $v; ?>').toggle('1000');
  $("i",this).toggleClass("fa-chevron-up fa-chevron-down");
});

</script>
<?php

echo "</td></tr>";

}

echo "</table></div>";

}

echo "<br><br>";


require_once("footer.php");

}


function statusstylessave() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ("$ipofpc" != "admin") {
die("Admins Only");
}

$statusid = $_REQUEST['statusid'];
$selectorcolor = pv(substr($_REQUEST['selectorcolor'], 1));
$boxtitle = pv($_REQUEST['boxtitle']);




mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "UPDATE boxstyles SET selectorcolor = '$selectorcolor', boxtitle = '$boxtitle' WHERE statusid = '$statusid'";
@mysqli_query($rs_connect, $rs_insert_scan);
header("Location: admin.php?func=statusstyles#g$statusid");


}


function statusoptionssave() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ("$ipofpc" != "admin") {
die("Admins Only");
}

$statusid = $_REQUEST['statusid'];
$statusoptions = serialize($_REQUEST['statusoptions']);



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "UPDATE boxstyles SET statusoptions = '$statusoptions' WHERE statusid = '$statusid'";
@mysqli_query($rs_connect, $rs_insert_scan);
header("Location: admin.php?func=statusstyles#g$statusid");


}



function customstatusstylesnew() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ("$ipofpc" != "admin") {
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

$selectorcolor = pv(substr($_REQUEST['selectorcolor'], 1));
$boxtitle = pv($_REQUEST['boxtitle']);

$rs_insert_scan = "INSERT INTO boxstyles (statusid, selectorcolor, boxtitle) VALUES ('$statusid','$selectorcolor', '$boxtitle')";
@mysqli_query($rs_connect, $rs_insert_scan);
header("Location: admin.php?func=statusstyles#g$statusid");


}


function cstatusdelete() {
require_once("validate.php");

require("deps.php");
require("common.php");

$cstatusid = $_REQUEST['cstatusid'];

if ("$ipofpc" != "admin") {
die("Admins Only");
}




mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_move_wo = "UPDATE pc_wo SET pcstatus = '1' WHERE pcstatus = '$cstatusid'";
@mysqli_query($rs_connect, $rs_move_wo);

$rs_delete_boxstyle = "DELETE FROM boxstyles WHERE statusid = '$cstatusid'";
@mysqli_query($rs_connect, $rs_delete_boxstyle);
header("Location: admin.php?func=statusstyles");

}


function servicereminders() {
require("header.php");
require_once("common.php");
require("deps.php");

perm_boot("16");



mysqli_query($rs_connect, "SET NAMES 'utf8'");

start_blue_box(pcrtlang("Manage Service Reminder Messages"));
echo "<a href=../repair/admin.php class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-circle-left fa-lg\"></i> ".pcrtlang("Go Back to Settings")."</a><br><br>";

$rs_ql = "SELECT * FROM serviceremindercanned ORDER BY srorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$srid = "$rs_result_q1->srid";
$srtitle = "$rs_result_q1->srtitle";
$srtext = "$rs_result_q1->srtext";
$theorder = "$rs_result_q1->srorder";


start_box();
echo "<table>";

echo "<tr><td><form action=admin.php?func=serviceremindersave method=post><input type=hidden name=srid value=$srid>";

echo "<a href=admin.php?func=reorderservicereminder&srid=$srid&dir=up&theorder=$theorder class=\"linkbuttonsmall linkbuttongray radiusleft\"><i class=\"fa fa-chevron-up fa-lg\"></i></a>";
echo "<a href=admin.php?func=reorderservicereminder&srid=$srid&dir=down&theorder=$theorder class=\"linkbuttonsmall linkbuttongray radiusright\"><i class=\"fa fa-chevron-down fa-lg\"></i></a>";
echo "</td>";
echo "<td><span class=boldme>".pcrtlang("Title")."</span><br><input type=text class=textbox name=srtitle size=40 value=\"$srtitle\"></td><td></td></tr>";
echo "<tr><td colspan=2><span class=boldme>".pcrtlang("Message")."</span><br><textarea name=srtext rows=4 cols=70 class=textbox>$srtext</textarea>";
echo "<td><button type=submit class=sbutton><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button></form></td>";
echo "<td><form action=admin.php?func=servicereminderdelete method=post>";
echo "<input type=hidden name=srid value=$srid>";
echo "<button type=submit class=ibutton><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")."</button></form></td>";
echo "</tr>";
echo "</table>";
stop_box();
echo "<br>";
}

echo "<br><span class=\"sizemelarge boldme\">".pcrtlang("Add Service Reminder").":</span><br><br>";
echo "<form action=admin.php?func=servicereminderadd method=post>";
echo "<span class=boldme>".pcrtlang("Title")."</span><br><input type=text class=textbox name=srtitle size=50><br>";
echo "<span class=boldme>".pcrtlang("Message")."</span><br><textarea name=srtext rows=4 cols=70 value=\"\" class=textbox></textarea>";
echo "<br><button type=submit class=sbutton><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Add")."</button></form>";

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
if (($demo == "yes") && ("$ipofpc" != "admin")) {
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
echo "<a href=../repair/admin.php class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-circle-left fa-lg\"></i> ".pcrtlang("Go Back to Settings")."</a><br><br>";

$rs_ql = "SELECT * FROM stores WHERE storeenabled = '1'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$storeid = "$rs_result_q1->storeid";
$storesname = "$rs_result_q1->storesname";
$oncalluser = "$rs_result_q1->oncalluser";

$oncallusertest = serializedarraytest("$oncalluser");

start_box();
echo "<form action=\"admin.php?func=oncallusers_save\" method=post>";

echo "<span class=boldme>".pcrtlang("Store").": $storesname</span><br>";
echo "<input type=hidden name=storeid value=$storeid>";

echo "<div class=\"checkbox\">";


if(count($oncallusertest) == 0) {
#echo "<input type=checkbox checked id=\"$storeid"."notset\" value=\"\" name=\"techs[]\"><label for=\"$storeid"."notset\"><i class=\"fa fa-times\"></i> ".pcrtlang("Not Set")."</input></label>";
} else {
#echo "<input type=checkbox id=\"$storeid"."notset\" value=\"\" name=\"techs[]\"><label for=\"$storeid"."notset\"><i class=\"fa fa-times\"></i> ".pcrtlang("Not Set")."</input></label>";
}


$rs_qu = "SELECT * FROM users";
$rs_resultqu1 = mysqli_query($rs_connect, $rs_qu);
while($rs_result_qu2 = mysqli_fetch_object($rs_resultqu1)) {
$theusername = "$rs_result_qu2->username";

if(in_array($theusername, $oncallusertest)) {
echo "<input type=checkbox checked id=\"$storeid"."$theusername\" value=\"$theusername\" name=\"techs[]\"><label for=\"$storeid"."$theusername\"><i class=\"fa fa-user fa-lg\"></i> $theusername</input></label>";
} else {
echo "<input type=checkbox id=\"$storeid"."$theusername\" value=\"$theusername\" name=\"techs[]\"><label for=\"$storeid"."$theusername\"><i class=\"fa fa-user fa-lg\"></i> $theusername</input></label>";
}
}

echo "</div>";

echo "<br><button type=submit class=sbutton><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button></form>";
stop_box();
echo "<br>";
}

echo "</table>";
stop_blue_box();

require_once("footer.php");

}


function oncallusers_save() {
require_once("validate.php");

require("deps.php");
require("common.php");

perm_boot("18");

#print_r($_REQUEST);
#die();

mysqli_query($rs_connect, "SET NAMES 'utf8'");

$techs = serialize($_REQUEST['techs']);

$storeid = $_REQUEST['storeid'];

$rs_update_oc = "UPDATE stores SET oncalluser = '$techs' WHERE storeid = '$storeid'";
@mysqli_query($rs_connect, $rs_update_oc);


header("Location: admin.php?func=oncallusers");
}



function editdymotemp() {
require("header.php");
require_once("common.php");
require("deps.php");

if ("$ipofpc" != "admin") {
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

start_box();
echo "<span class=\"sizemelarge boldme\">".pcrtlang("Edit Dymo Label Templates for Store").": $storeinfoarray[storesname]</span><br><br>";

echo "<a href=admin.php?func=stores class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-left fa-lg\"></i> ".pcrtlang("Return to Store Admin")."</a>";
stop_box();
echo "<br><br>";

start_blue_box(pcrtlang("Asset Label Template"));
echo "<textarea name=asset class=textboxw style=\"width:97%\" rows=1>$tempasset</textarea>";
echo pcrtlang("Available Variables").":<br>
".pcrtlang("Customer Name").": PCRT_CUSTOMER_NAME<br>
".pcrtlang("PC ID").": PCRTPCID<br>
".pcrtlang("Store Name").": PCRT_YOUR_STORE_NAME<br>
".pcrtlang("Store Phone").": PCRT_STORE_PHONE<br>
".pcrtlang("Work Order ID").": PCRTWOID<br>
".pcrtlang("PC Make").": PCRT_MAKE<br>
".pcrtlang("Customer Phone").": PCRT_CUSTOMER_PHONE<br>
".pcrtlang("Customer Company Name").": PCRT_CUSTOMER_COMPANY";


stop_blue_box();
echo "<br><br>";

start_blue_box(pcrtlang("Address Label Template"));
echo "<textarea name=address class=textboxw style=\"width:97%\" rows=1>$tempaddress</textarea>";
echo pcrtlang("Available Variables").":<br>
".pcrtlang("Customer Name").": PCRT_CUSTOMER_NAME<br>
".pcrtlang("Address Line 1").": PCRT_ADDRESS1<br>
".pcrtlang("Address Line 2").": PCRT_ADDRESS2<br>
".pcrtlang("Address Line 3").": PCRT_ADDRESS3<br>";
stop_blue_box();
echo "<br><br>";

start_blue_box(pcrtlang("Price Tag Template"));
echo "<textarea name=pricetag class=textboxw style=\"width:97%\" rows=1>$temppricetag</textarea>";
echo pcrtlang("Available Variables").":<br>
".pcrtlang("Stock Name").": PCRT_STOCK_NAME<br>
".pcrtlang("Price").": PCRT_PRICE<br>
".pcrtlang("Stock ID").": PCRTSTOCKID<br>
".pcrtlang("Store Name").": PCRT_STORE_NAME<br>
".pcrtlang("Store Phone").": PCRT_STORE_PHONE<br>
".pcrtlang("Stock UPC").": PCRTUPC<br>";
stop_blue_box();
echo "<br><br>";

start_blue_box(pcrtlang("Price Tag Template with Serial"));
echo "<textarea name=pricetagserial class=textboxw style=\"width:97%\" rows=1>$temppricetagserial</textarea>";
echo pcrtlang("Available Variables").":<br>
".pcrtlang("Stock Name").": PCRT_STOCK_NAME<br>
".pcrtlang("Price").": PCRT_PRICE<br>
".pcrtlang("Stock ID").": PCRTSTOCKID<br>
".pcrtlang("Serial Number").": PCRT_SERIAL_NUMBER<br>
".pcrtlang("Store Name").": PCRT_STORE_NAME<br>
".pcrtlang("Store Phone").": PCRT_STORE_PHONE<br>
".pcrtlang("Stock UPC").": PCRTUPC<br>";
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
echo pcrtlang("Create your label with the Dymo Label Designer software placing the variables shown here as placeholders for fields in the label").pcrtlang("Then save the file, and open it with a text editor and paste the template text here.");

stop_box();
require_once("footer.php");

}


function editdymotemp2() {
require_once("validate.php");


require("deps.php");
require("common.php");

if ("$ipofpc" != "admin") {
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


if ("$ipofpc" != "admin") {
die("admins only");
}

echo "<a href=../repair/admin.php class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-circle-left fa-lg\"></i> ".pcrtlang("Go Back to Settings")."</a><br><br>";


mysqli_query($rs_connect, "SET NAMES 'utf8'");

$boxtitle = pcrtlang("Main Asset/Device Definitions");

start_blue_box("$boxtitle");


echo "<table class=standard>";


$rs_sq = "SELECT * FROM mainassettypes ORDER BY mainassetname ASC";
$rs_result1 = mysqli_query($rs_connect, $rs_sq);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$mainassettypeid = "$rs_result_q1->mainassettypeid";
$mainassetname = "$rs_result_q1->mainassetname";
$mainassetdefault = "$rs_result_q1->mainassetdefault";
$showscans = "$rs_result_q1->showscans";
$mspdevice = "$rs_result_q1->mspdevice";

$checkmainassets =  "SELECT * FROM pc_owner WHERE mainassettypeid='$mainassettypeid'";
$rs_result_chk = mysqli_query($rs_connect, $checkmainassets);
$totalassets = mysqli_num_rows($rs_result_chk);

$mainassettypename2 = urlencode("$mainassetname");

echo "<tr><td>";

if($mainassetdefault != 1) {
echo "<a href=admin.php?func=setmainassetdefault&mainassettypeid=$mainassettypeid class=\"linkbuttonsmall linkbuttongray radiusall\">".pcrtlang("set default")." <i class=\"fa fa-chevron-right\"></i></a>&nbsp;&nbsp;&nbsp;";
} else {
echo "<span class=\"linkbuttonsmall linkbuttongraylabel radiusall\"> ".pcrtlang("Default")." </span> ";
}


echo "</td><td>";
echo "<span class=boldme> $mainassetname </span></td><td>&nbsp;&nbsp;&nbsp;&nbsp;<a href=admin.php?func=editmainassettype&mainassettypeid=$mainassettypeid&mainassetname=$mainassettypename2&showscans=$showscans&mspdevice=$mspdevice class=\"linkbuttonsmall linkbuttongray radiusall\"><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("edit")."</a> </td><td>";
if ($totalassets == "0") {
echo " <a href=admin.php?func=deletemainassettype&mainassettypeid=$mainassettypeid class=\"linkbuttonsmall linkbuttongray radiusall\"><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("delete")."</a>";
}

echo "</td><td><a href=admin.php?func=mainassetfields&mainassettypeid=$mainassettypeid&mainassettypename=$mainassettypename2 class=\"linkbuttonsmall linkbuttongray radiusall\"><i class=\"fa fa-info-circle fa-lg\"></i> ".pcrtlang("asset/device fields")."</a></td><td>";

echo "<a href=admin.php?func=mainassetchecks&mainassettypeid=$mainassettypeid&mainassettypename=$mainassettypename2
class=\"linkbuttonsmall linkbuttongray radiusall\"><i class=\"fa fa-check fa-lg\"></i> ".pcrtlang("asset checks")."</a></td><td>";



echo "<a href=admin.php?func=mainassetsubassets&mainassettypeid=$mainassettypeid&mainassettypename=$mainassettypename2 class=\"linkbuttonsmall linkbuttongray radiusall\"><i class=\"fa fa-headphones fa-lg\"></i> ".pcrtlang("asset accessories")."</a>";

echo "</td></tr>";
}
echo "</table>";

echo "<br><span class=boldme>".pcrtlang("Add New Main Asset/Device Type")."</span><br>";

echo "<form method=post action=\"admin.php?func=addmainassettype\"><input type=text class=textbox name=mainassetname size=30>
<input class=button type=submit value=\"".pcrtlang("Add")."\"></form>";

stop_blue_box();
echo "<br><br>";

#################

$boxtitle2 = pcrtlang("Main Asset/Device Info Field Options");

start_blue_box("$boxtitle2");


echo "<table class=standard>";

echo "<tr><td colspan=2></td><th colspan=5 style=\"text-align:center;\">".pcrtlang("Show On").":</th><td colspan=2></td></tr>";
echo "<tr><th></th><th>".pcrtlang("Field Keyword")."&nbsp;&nbsp;&nbsp;</th><th>".pcrtlang("Claim Ticket")."&nbsp;&nbsp;&nbsp;</th><th>".pcrtlang("Repair Report")."&nbsp;&nbsp;&nbsp;</th><th>".pcrtlang("Checkout Receipt")."&nbsp;&nbsp;&nbsp;</th><th>".pcrtlang("Price Card")."</th><th>".pcrtlang("Bench Sheet")."</th><th></th></tr>";

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
$showonbenchsheet = "$rs_result_q1->showonbenchsheet";

if($showonclaim == 1) {
$showonclaima = "<i class=\"fa fa-check fa-lg\"></i>";
} else {
$showonclaima = "";
}

if($showonrepair == 1) {
$showonrepaira = "<i class=\"fa fa-check fa-lg\"></i>";
} else {
$showonrepaira = "";
}

if($showoncheckout == 1) {
$showoncheckouta = "<i class=\"fa fa-check fa-lg\"></i>";
} else {
$showoncheckouta = "";
}

if($showonpricecard == 1) {
$showonpricecarda = "<i class=\"fa fa-check fa-lg\"></i>";
} else {
$showonpricecarda = "";
}

if($showonbenchsheet == 1) {
$showonbenchsheeta = "<i class=\"fa fa-check fa-lg\"></i>";
} else {
$showonbenchsheeta = "";
}


$mainassetfieldname2 = urlencode("$mainassetfieldname");
$matchword2 = urlencode("$matchword");

echo "<tr><td><span class=boldme> $mainassetfieldname</span></td><td>$matchword</td><td>$showonclaima</td><td>$showonrepaira</td><td>$showoncheckouta</td><td>$showonpricecarda</td><td>$showonbenchsheeta</td><td>&nbsp;&nbsp;&nbsp;&nbsp;<a href=admin.php?func=editmainassetfield&mainassetfieldid=$mainassetfieldid&mainassetfieldname=$mainassetfieldname2&matchword=$matchword2 class=\"linkbuttontiny linkbuttongray radiusall\"><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("edit")."</a> ";

echo "</td></tr>";
}
echo "</table>";

echo "<br><span class=\"sizeme16 boldme\">".pcrtlang("Add New Main Asset/Device Info Field")."</span><br>";
echo "<table><tr><td><span class=boldme>".pcrtlang("Field Name")."</span></td><td><span class=boldme>".pcrtlang("Field Keyword (optional)")."</span></td></tr>";
echo "<tr><td><form method=post action=\"admin.php?func=addmainassetfield\"><input type=text class=textbox name=mainassetfieldname size=30>";
echo "</td><td><input type=text class=textbox name=matchword size=30>";
echo "</td></tr>";
echo "<tr><td colspan=2><input class=button type=submit value=\"".pcrtlang("Add")."\"></form></td></tr></table>";

echo "<br><br><br><span class=boldme>".pcrtlang("Available Field Keywords").":</span> <span class=italme>(".pcrtlang("these are the values that can be imported from d7 or UVK and mapped to PCRT fields").")</span><br>";
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
echo "<br><br><a name=checks></a>";


start_blue_box(pcrtlang("Device Checks"));
echo "<table>";
$rs_checks = "SELECT * FROM checks";
$rs_checksq = mysqli_query($rs_connect, $rs_checks);
while($rs_result_cq = mysqli_fetch_object($rs_checksq)) {
$checkid = "$rs_result_cq->checkid";
$checkname = "$rs_result_cq->checkname";


echo "<tr><td valign=top><form action=admin.php?func=checksave method=post><input type=hidden name=checkid value=$checkid>";
echo "<input type=text name=checkname size=30 value=\"$checkname\" class=textbox>";
echo "</td><td valign=top><button type=submit class=sbutton><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button></form></td>
<td valign=top><form action=admin.php?func=checkdelete method=post>";
echo "<input type=hidden name=checkid value=$checkid>";
echo "<button type=submit class=ibutton><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")."</button></form>";

echo "</td></tr>";

}

echo "</table>";

echo "<span class=\"sizemelarge boldme\">".pcrtlang("Add").":</span><br>";
echo "<form action=admin.php?func=checkadd method=post>";
echo "<input type=text name=checkname size=30 value=\"\" class=textbox>";
echo "<button type=submit class=sbutton><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Add")."</button></form>";
stop_blue_box();





require_once("footer.php");

}


function addmainassettype() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ("$ipofpc" != "admin") {
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

if ("$ipofpc" != "admin") {
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

if ("$ipofpc" != "admin") {
die("admins only");
}

$mainassettypeid = $_REQUEST['mainassettypeid'];
$mainassetname = $_REQUEST['mainassetname'];
$showscans = $_REQUEST['showscans'];
$mspdevice = $_REQUEST['mspdevice'];

echo "<form action=admin.php?func=editmainassettype2 method=post><input type=hidden name=mainassettypeid value=\"$mainassettypeid\">";

start_blue_box(pcrtlang("Edit Main Asset/Device Type"));
echo "<table><tr><td><span class=boldme>".pcrtlang("Main Asset Name").":</span></td><td><input type=text name=mainassetname class=textbox cols=40 value=\"$mainassetname\"></td></tr>";

echo "<tr><td><span class=boldme>".pcrtlang("Show Scans, Installs, Actions Module on Work Order?")."</span></td><td>";
echo "<select name=showscans>";

if($showscans == 1) {
echo "<option selected value=1>".pcrtlang("Yes")."</option>";
echo "<option value=0>".pcrtlang("No")."</option>";
} else {
echo "<option value=1>".pcrtlang("Yes")."</option>";
echo "<option selected value=0>".pcrtlang("No")."</option>";
}

echo "</select></td></tr>";

echo "<tr><td><span class=boldme>".pcrtlang("Manageable Device?")."</span></td><td>";
echo "<select name=mspdevice>";

if($mspdevice == 1) {
echo "<option selected value=1>".pcrtlang("Yes")."</option>";
echo "<option value=0>".pcrtlang("No")."</option>";
} else {
echo "<option value=1>".pcrtlang("Yes")."</option>";
echo "<option selected value=0>".pcrtlang("No")."</option>";
}

echo "</select></td></tr>";


echo "<tr><td colspan=1><input type=submit class=button value=\"".pcrtlang("Save")."\"></form></td></tr></table>";
stop_blue_box();
echo "<br><br>";

require_once("footer.php");

}

function editmainassettype2() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ("$ipofpc" != "admin") {
die("admins only");
}

$mainassetname = pv($_REQUEST['mainassetname']);
$mainassettypeid = $_REQUEST['mainassettypeid'];
$showscans = $_REQUEST['showscans'];
$mspdevice = $_REQUEST['mspdevice'];



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_update_tdc = "UPDATE mainassettypes SET mainassetname = '$mainassetname', showscans = '$showscans', mspdevice = '$mspdevice' WHERE mainassettypeid = '$mainassettypeid'";
@mysqli_query($rs_connect, $rs_update_tdc);


header("Location: admin.php?func=mainassets");


}

function setmainassetdefault() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ("$ipofpc" != "admin") {
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


if ("$ipofpc" != "admin") {
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

echo "<span class=boldme>".pcrtlang("Pick Asset Accessories for this Main Asset/Device ").":</span><br>";

echo "<form method=post action=\"admin.php?func=mainassetsubassetssave\"><input type=hidden name=mainassettypeid value=\"$mainassettypeid\">";

echo "<table width=100%><tr><td valign=top>";

reset($custassets);
$total_asset_types = count($custassets);
$div2 = ($total_asset_types / 2);
$div3 = $div2 + 1;

$a = 1;
echo "<div class=\"checkbox\">";
foreach($custassets as $key => $val) {
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

if ("$ipofpc" != "admin") {
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

if ("$ipofpc" != "admin") {
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

if ("$ipofpc" != "admin") {
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
$showonbenchsheet = "$rs_result_q1->showonbenchsheet";

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

if($showonbenchsheet == 1) {
$checked5 = "checked";
} else {
$checked5 = "";
}



echo "<form action=admin.php?func=editmainassetfield2 method=post><input type=hidden name=mainassetfieldid value=\"$mainassetfieldid\">";

start_blue_box(pcrtlang("Edit Main Asset/Device Info Field Name"));
echo "<table>";
echo "<tr><td><span class=boldme>".pcrtlang("Asset/Device Info Field Name").":</span> </td><td><input type=text name=mainassetfieldname class=textbox cols=40 value=\"$mainassetfieldname\"></td></tr>";
echo "<tr><td><span class=boldme>".pcrtlang("Field Keyword").":</span> </td><td><input type=text name=matchword class=textbox cols=40 value=\"$matchword\"></td></tr>";


echo "<tr><td><span class=boldme>".pcrtlang("Show on Claim Ticket").":</span> </td><td><input type=checkbox name=showonclaim $checked1></td></tr>";
echo "<tr><td><span class=boldme>".pcrtlang("Show on Repair Report").":</span> </td><td><input type=checkbox name=showonrepair $checked2></td></tr>";
echo "<tr><td><span class=boldme>".pcrtlang("Show on Checkout Receipt").":</span> </td><td><input type=checkbox name=showoncheckout $checked3></td></tr>";
echo "<tr><td><span class=boldme>".pcrtlang("Show on Price Card").":</span> </td><td><input type=checkbox name=showonpricecard $checked4></td></tr>";
echo "<tr><td><span class=boldme>".pcrtlang("Show on Bench Sheet").":</span> </td><td><input type=checkbox name=showonbenchsheet $checked5></td></tr>";

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

if ("$ipofpc" != "admin") {
die("admins only");
}

$mainassetfieldname = pv($_REQUEST['mainassetfieldname']);
$mainassetfieldid = $_REQUEST['mainassetfieldid'];
$matchword = pv($_REQUEST['matchword']);

$showonclaim = $_REQUEST['showonclaim'];
$showonrepair = $_REQUEST['showonrepair'];
$showoncheckout = $_REQUEST['showoncheckout'];
$showonpricecard = $_REQUEST['showonpricecard'];
$showonbenchsheet = $_REQUEST['showonbenchsheet'];

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

if($showonbenchsheet == "on") {
$showonbenchsheet2 = 1;
} else {
$showonbenchsheet2 = 0;
}





mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_update_tdc = "UPDATE mainassetinfofields SET mainassetfieldname = '$mainassetfieldname', matchword = '$matchword', showonclaim = '$showonclaim2', showonrepair = '$showonrepair2', showoncheckout = '$showoncheckout2', showonpricecard = '$showonpricecard2', showonbenchsheet = '$showonbenchsheet2' WHERE mainassetfieldid = '$mainassetfieldid'";
@mysqli_query($rs_connect, $rs_update_tdc);


header("Location: admin.php?func=mainassets");

}


function mainassetfields() {

require("header.php");
require_once("common.php");
require("deps.php");


if ("$ipofpc" != "admin") {
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

echo "<span class=boldme>".pcrtlang("Pick Info Fields for this Main Asset ").":</span><br>";

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

if ("$ipofpc" != "admin") {
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

if ("$ipofpc" != "admin") {
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


function deleteswatch() {
require_once("validate.php");

$swatchid = $_REQUEST['swatchid'];

require("deps.php");

mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_ds = "DELETE FROM swatches WHERE swatchid = '$swatchid'";
@mysqli_query($rs_connect, $rs_ds);

header("Location: admin.php?func=stores");

}


function switchuser() {
require_once("validate.php");
require("deps.php");
require("common.php");

$ruri = urlencode($_REQUEST['ruri']);

if (array_key_exists('switchuser',$_REQUEST)) {
$switchuser = "$_REQUEST[switchuser]";
} else {
$switchuser = "";
}


?>
<!DOCTYPE html>
<html>
<head>
<?php
if(!isset($pcrt_stylesheet)) {
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../repair/style.css\">";
} else {
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../repair/$pcrt_stylesheet\">";
}
?>
<link rel="stylesheet" href="../repair/fa/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="ani.css">
<title><?php echo pcrtlang("Switch User"); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script src="jq/jquery.js" type="text/javascript"></script>
</head>
<body>
<center><br><br><span class="sizeme20 boldme"><?php echo pcrtlang("Select User / Enter PIN"); ?></span><br><br>

<?php

echo "<table style=\"width:200px;\"><tr><td style=\"text-align:center;\">";

if(isset($_REQUEST['failed'])) {
echo "<span class=\"colormered sizeme16 boldme\"><i class=\"fa fa-warning fa-2x\"></i><br>".pcrtlang("Incorrect Pin")."</span><br><br>";
}

echo "<form action=admin.php?func=switchuser2&ruri=$ruri method=post id=Pinform>";

foreach($_SESSION as $key => $val) {
if (preg_match("/username_/", $key)) {

if($switchuser != "") {
if("$switchuser" == "$val") {
$thechecked = " checked";
} else {
$thechecked = "";
}

} else {

if("$ipofpc" == "$val") {
$thechecked = " checked";
} else {
$thechecked = "";
}

}

echo "<div class=\"radiobox\"><input type=radio value=\"$val\" name=\"switchuser\" id=\"$val\" $thechecked>
<label for=\"$val\" style=\"font-size:20px;\"><i class=\"fa fa-user fa-lg\"></i> $val</input></label></div>";
}
}


echo "<br><br><a href=\"../repair/login.php\" class=\"linkbuttonlarge linkbuttongray radiusall\"><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("New Login")."</a><br><br>";

echo "<br><input name=\"pin\" id=\"Pin\" type=password style=\"font-size:20px;text-align:center;width:150px;\" class=textbox placeholder=\"".pcrtlang("Enter Pin")."\" maxlength=\"4\">";

?>
<SCRIPT language="JavaScript">
$("#Pin").focus();

$("#Pin").blur(function() {
    setTimeout(function() { $("#Pin").focus(); }, 100);
});

$(document).ready(function() {
    $("#Pin").keyup(function() {
        if ($(this).val().length >= 4) {
            $("#Pinform").submit();
        }
    });
});

</script>
<?php


echo "</td></tr></table></form></center></html>";


}


function switchuser2() {
require_once("validate.php");

$switchuser = $_REQUEST['switchuser'];
$ruri = $_REQUEST['ruri'];
$ruri_ue = urlencode($_REQUEST['ruri']);

require("deps.php");
require("common.php");

$rs_connect = mysqli_connect($dbhost, $dbuname, $dbpass, $dbname) or die("Couldn't connect the db");
mysqli_query($rs_connect, "SET NAMES utf8");

$pins = array();

$rs_ql = "SELECT pin,username FROM users";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
while($row = mysqli_fetch_array($rs_result1)) {
$ausername = $row['username'];
$apin = $row['pin'];
$pins[$ausername]=$apin;
}


$pin = md5($_POST["pin"]);
$pinvalidated = false;

if(isset($pins[$switchuser])) if($pins[$switchuser]==$pin) $pinvalidated = true;

if(!$pinvalidated) {
header("Location: admin.php?func=switchuser&ruri=$ruri_ue&failed=1&switchuser=".urlencode("$switchuser"));
} else {

$_SESSION['username'] = "$switchuser";

header("Location: $ruri");
}

}



function savepin() {
require_once("validate.php");

if ("$ipofpc" != "admin") {
die("admins only");
}

require("deps.php");
require("common.php");


$uname = $_REQUEST['uname'];
$pin = md5($_REQUEST['pin']);

if (($_REQUEST['pin'] == "") || (strlen($_REQUEST['pin']) != 4)) {
die(pcrtlang("please go back and enter a 4 digit pin"));
}

mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_pin = "UPDATE users SET pin = '$pin' WHERE username = '$uname'";
@mysqli_query($rs_connect, $rs_insert_pin);

header("Location: admin.php?func=useraccounts&showuser=$uname#$uname");

}



function registersave() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ("$ipofpc" != "admin") {
die("admins only");
}

$registerid = $_REQUEST['registerid'];
$registername = pv($_REQUEST['registername']);



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_save_register = "UPDATE registers SET registername = '$registername' WHERE registerid = '$registerid'";
@mysqli_query($rs_connect, $rs_save_register);

header("Location: admin.php?func=stores");

}


function registerdelete() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ("$ipofpc" != "admin") {
die("admins only");
}

$registerid = $_REQUEST['registerid'];

mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_delete_register = "DELETE FROM registers WHERE registerid = '$registerid'";
@mysqli_query($rs_connect, $rs_delete_register);
header("Location: admin.php?func=stores");

}


function registeradd() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ("$ipofpc" != "admin") {
die("admins only");
}


$registerstoreid = pv($_REQUEST['registerstoreid']);
$registername = pv($_REQUEST['registername']);


mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_register = "INSERT INTO registers (registername,registerstoreid) VALUES ('$registername','$registerstoreid')";
@mysqli_query($rs_connect, $rs_insert_register);

header("Location: admin.php?func=stores");
}




function denomsave() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ("$ipofpc" != "admin") {
die("admins only");
}

$denomid = $_REQUEST['denomid'];
$denomvalue = pv($_REQUEST['denomvalue']);



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_save_denom = "UPDATE denoms SET denomvalue = '$denomvalue' WHERE denomid = '$denomid'";
@mysqli_query($rs_connect, $rs_save_denom);

header("Location: admin.php?func=denoms");

}


function denomdelete() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ("$ipofpc" != "admin") {
die("admins only");
}

$denomid = $_REQUEST['denomid'];



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_delete_denom = "DELETE FROM denoms WHERE denomid = '$denomid'";
@mysqli_query($rs_connect, $rs_delete_denom);
header("Location: admin.php?func=denoms");

}


function denomadd() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ("$ipofpc" != "admin") {
die("admins only");
}


$denomid = pv($_REQUEST['denomid']);
$denomvalue = pv($_REQUEST['denomvalue']);


mysqli_query($rs_connect, "SET NAMES 'utf8'");


$rs_qb = "SELECT * FROM denoms WHERE denomvalue = '$denomvalue'";
$rs_resultb = mysqli_query($rs_connect, $rs_qb);
$totresult = mysqli_num_rows($rs_resultb);

if($totresult == 0) {
$rs_insert_denom = "INSERT INTO denoms (denomvalue) VALUES ('$denomvalue')";
@mysqli_query($rs_connect, $rs_insert_denom);
}


header("Location: admin.php?func=denoms");

}



function denoms() {
require("header.php");
require_once("common.php");
require("deps.php");

if ("$ipofpc" != "admin") {
die("admins only");
}

echo "<a href=../repair/admin.php class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-circle-left fa-lg\"></i> ".pcrtlang("Go Back to Settings")."</a><br><br>";

mysqli_query($rs_connect, "SET CHARACTER SET utf8");

start_box();

echo "<table>";
echo "<tr><td valign=top><span class=\"sizemelarge boldme\">".pcrtlang("Denominations").":</span></td><td colspan=2></td></tr>";
$rs_qb = "SELECT * FROM denoms ORDER BY denomvalue ASC";
$rs_resultb = mysqli_query($rs_connect, $rs_qb);
while($rs_result_qb = mysqli_fetch_object($rs_resultb)) {
$denomid = "$rs_result_qb->denomid";
$denomvalue = "$rs_result_qb->denomvalue";


echo "<tr><td valign=top>";


echo "<form action=admin.php?func=denomsave method=post><input type=hidden name=denomid value=$denomid>";
echo "<input type=text name=denomvalue size=25 value=\"$denomvalue\" class=textbox placeholder=\"".pcrtlang("Enter Value")."\"></td>";
echo "<td valign=top><input type=submit value=\"&laquo;".pcrtlang("Save")."\" class=button></form></td>";
echo "<td valign=top><form action=admin.php?func=denomdelete method=post>";
echo "<input type=hidden name=denomid value=$denomid>";
echo "<input type=submit value=\"&laquo;".pcrtlang("Delete")."\" class=button></form></td></tr>";

}
echo "<tr><td colspan=4>&nbsp;</td></tr>";
echo "<tr><td valign=top><span class=\"sizemelarge boldme\">".pcrtlang("Add Denomination").":</span></td>";
echo "<td colspan=2></td></tr>";
echo "<tr><td><form action=admin.php?func=denomadd method=post>";
echo "<input type=text name=denomvalue size=15 value=\"\" class=textbox placeholder=\"".pcrtlang("Enter Value")."\"></td>";
echo "<td colspan=2><button type=submit class=ibutton><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Add")."</button></form></td></tr>";
echo "</table>";


stop_box();
echo "<br><br>";

require_once("footer.php");

}

function setregister() {
require_once("validate.php");

require("deps.php");
require("common.php");

$setregisterid = $_REQUEST['setregisterid'];

if(isset($cookiedomain)) {
setcookie("registerid", $setregisterid, time()+63072000, "/","$cookiedomain");
} else {
setcookie("registerid", $setregisterid, time()+63072000, "/");
}

header("Location: admin.php");

}


function storagelocations() {
require("header.php");
require_once("common.php");
require("deps.php");

perm_boot("31");

mysqli_query($rs_connect, "SET CHARACTER SET utf8");

start_blue_box(pcrtlang("Storage Locations"));
echo "<a href=../repair/admin.php class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-circle-left fa-lg\"></i> ".pcrtlang("Go Back to Settings")."</a><br><br>";

echo "<table>";


$rs_sl = "SELECT * FROM storagelocations ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_sl);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$slid = "$rs_result_q1->slid";
$slname = "$rs_result_q1->slname";
$theorder = "$rs_result_q1->theorder";


echo "<tr><td valign=top><form action=admin.php?func=slsave method=post><input type=hidden name=slid value=$slid>";
echo "<a href=admin.php?func=reordersl&slid=$slid&dir=up&theorder=$theorder class=\"linkbuttonsmall linkbuttongray radiusleft\">
<i class=\"fa fa-chevron-up fa-lg\"></i></a>";
echo "<a href=admin.php?func=reordersl&slid=$slid&dir=down&theorder=$theorder class=\"linkbuttonsmall linkbuttongray radiusright\">
<i class=\"fa fa-chevron-down fa-lg\"></i></a>";
echo "</td>";
echo "<td><input type=text name=slname size=30 value=\"$slname\" class=textbox>";
echo "</td><td valign=top><button type=submit class=sbutton><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button></form></td>
<td valign=top><form action=admin.php?func=sldelete method=post>";
echo "<input type=hidden name=slid value=$slid>";
echo "<button type=submit class=ibutton><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")."</button></form>";

echo "</td></tr>";

}

echo "</table>";

echo "<span class=\"sizemelarge boldme\">".pcrtlang("Add").":</span><br>";
echo "<form action=admin.php?func=sladd method=post>";
echo "<input type=text name=slname size=30 value=\"\" class=textbox>";
echo "<button type=submit class=sbutton><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Add")."</button></form>";
stop_blue_box();

require_once("footer.php");
                                                                                                    
}


function slsave() {
require_once("validate.php");

require("deps.php");
require("common.php");

perm_boot("31");

$slid = $_REQUEST['slid'];
$slname = pv($_REQUEST['slname']);

mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "UPDATE storagelocations SET slname = '$slname' WHERE slid = '$slid'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=storagelocations");


}

function sldelete() {
require_once("validate.php");

require("deps.php");
require("common.php");

$slid = $_REQUEST['slid'];

perm_boot("31");

if (($demo == "yes") && ("$ipofpc" != "admin")) {
die("Sorry this feature is disabled in demo mode");
}

mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "DELETE FROM storagelocations WHERE slid = '$slid'";
@mysqli_query($rs_connect, $rs_insert_scan);
header("Location: admin.php?func=storagelocations");

}



function sladd() {
require_once("validate.php");

require("deps.php");
require("common.php");

perm_boot("31");

$slname = pv($_REQUEST['slname']);


mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "INSERT INTO storagelocations (slname) VALUES ('$slname')";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=storagelocations");

}

function reordersl() {
require_once("validate.php");

$slid = $_REQUEST['slid'];
$dir = $_REQUEST['dir'];
$theorder = $_REQUEST['theorder'];

require("deps.php");
require_once("common.php");
perm_boot("31");



mysqli_query($rs_connect, "SET NAMES 'utf8'");

if ($dir == "up") {
$rs_sq = "SELECT * FROM storagelocations WHERE theorder > '$theorder' ORDER BY theorder ASC LIMIT 1";
} else {
$rs_sq = "SELECT * FROM storagelocations WHERE theorder < '$theorder' ORDER BY theorder DESC LIMIT 1";
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

$rs_insert_scan = "UPDATE storagelocations SET theorder = '$neworder' WHERE slid = $slid";
@mysqli_query($rs_connect, $rs_insert_scan);


$rs_resetorder = "SELECT * FROM storagelocations ORDER BY theorder ASC";
$rs_resultreset = mysqli_query($rs_connect, $rs_resetorder);
$a = 0;
while($rs_result_r1 = mysqli_fetch_object($rs_resultreset)) {
$slid = "$rs_result_r1->slid";
$rs_set_order = "UPDATE storagelocations SET theorder = '$a' WHERE slid = $slid";
@mysqli_query($rs_connect, $rs_set_order);
$a = $a + 5;
}


header("Location: admin.php?func=storagelocations");

}


function checksave() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ("$ipofpc" != "admin") {
die("admins only");
}

$checkid = $_REQUEST['checkid'];
$checkname = pv($_REQUEST['checkname']);


$rs_save_check = "UPDATE checks SET checkname = '$checkname' WHERE checkid = '$checkid'";
@mysqli_query($rs_connect, $rs_save_check);

header("Location: admin.php?func=mainassets#checks");


}

function checkdelete() {
require_once("validate.php");
require("deps.php");
require("common.php");

$checkid = $_REQUEST['checkid'];

if ("$ipofpc" != "admin") {
die("admins only");
}

$rs_delete_check = "DELETE FROM checks WHERE checkid = '$checkid'";
@mysqli_query($rs_connect, $rs_delete_check);
header("Location: admin.php?func=mainassets#checks");

}



function checkadd() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ("$ipofpc" != "admin") {
die("admins only");
}

$checkname = pv($_REQUEST['checkname']);

$rs_insert_check = "INSERT INTO checks (checkname) VALUES ('$checkname')";

@mysqli_query($rs_connect, $rs_insert_check);
header("Location: admin.php?func=mainassets#checks");

}



function mainassetchecks() {

require("header.php");
require_once("common.php");
require("deps.php");


if ("$ipofpc" != "admin") {
die("admins only");
}

$mainassettypename = $_REQUEST['mainassettypename'];
$mainassettypeid = $_REQUEST['mainassettypeid'];



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_fc = "SELECT * FROM checks";
$rs_resultfc = mysqli_query($rs_connect, $rs_fc);
while ($rs_result_qfc = mysqli_fetch_object($rs_resultfc)) {
$checkidnum = "$rs_result_qfc->checkid";
$checkname = "$rs_result_qfc->checkname";
$checksarray[$checkidnum] = $checkname;
}


$rs_sq = "SELECT * FROM mainassettypes WHERE mainassettypeid = '$mainassettypeid'";
$rs_result1 = mysqli_query($rs_connect, $rs_sq);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$mainassetchecksindb2 = "$rs_result_q1->mainassetchecks";
if ($mainassetchecksindb2 != "") {
$mainassetchecksindb3 = unserialize($mainassetchecksindb2);
} else {
$mainassetchecksindb3 = array();
}

if(is_array($mainassetchecksindb3)) {
$mainassetchecksindb = $mainassetchecksindb3;
} else {
$mainassetchecksindb = array();
}


$boxtitle = pcrtlang("Device Checks").": $mainassettypename";

start_blue_box("$boxtitle");

echo "<span class=boldme>".pcrtlang("Pick Checks for this Main Asset")." :</span><br>";

echo "<form method=post action=\"admin.php?func=mainassetcheckssave\"><input type=hidden name=mainassettypeid value=\"$mainassettypeid\">";
echo "<input type=hidden name=mainassettypename value=\"$mainassettypename\">";

echo "<table width=100%><tr><td valign=top>";

reset($checksarray);
echo "<div class=\"checkbox\">";

$totalchecks = count($mainassetchecksindb) -1;

foreach($mainassetchecksindb as $key => $val) {

if ($key != 0) {
echo "<a href=admin.php?func=reorderchecks&fid=$val&dir=up&mainassetcheckid=$val&mainassettypename=$mainassettypename&mainassettypeid=$mainassettypeid
class=imagelink><img src=images/up.png border=0></a>";
} else {
echo "&nbsp;&nbsp;&nbsp;";
}
if ($key != $totalchecks) {
echo " <a href=admin.php?func=reorderchecks&fid=$val&dir=down&mainassetcheckid=$val&mainassettypename=$mainassettypename&mainassettypeid=$mainassettypeid
class=imagelink><img src=images/down.png border=0></a>";
} else {
echo "&nbsp;&nbsp;&nbsp;&nbsp;";
}



echo "<input type=checkbox checked id=\"$val\" value=\"$val\" name=\"checks[]\"><label for=\"$val\"> $checksarray[$val]</input></label><br>";
}


foreach($checksarray as $key => $val) {
if (!in_array($key,$mainassetchecksindb)) {
echo "<input type=checkbox value=\"$key\" id=\"$key\" name=\"checks[]\"><label for=\"$key\"> $val</input></label><br>";
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



function mainassetcheckssave() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ("$ipofpc" != "admin") {
die("admins only");
}

$mainassettypeid = $_REQUEST['mainassettypeid'];
$mainassettypename = $_REQUEST['mainassettypename'];

if (array_key_exists('checks',$_REQUEST)) {
$checks = $_REQUEST['checks'];
} else {
$checks = array();
}

$checks3 = array_filter($checks);
$checks2 = pv(serialize($checks3));
mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_update_sal = "UPDATE mainassettypes SET mainassetchecks = '$checks2' WHERE mainassettypeid = '$mainassettypeid'";
@mysqli_query($rs_connect, $rs_update_sal);


header("Location: admin.php?func=mainassetchecks&mainassettypeid=$mainassettypeid&mainassettypename=$mainassettypename");


}


function reorderchecks() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ("$ipofpc" != "admin") {
die("admins only");
}

$mainassetcheckid = $_REQUEST['mainassetcheckid'];
$dir = $_REQUEST['dir'];
$fid = $_REQUEST['fid'];
$mainassettypename = $_REQUEST['mainassettypename'];
$mainassettypeid = $_REQUEST['mainassettypeid'];

if (array_key_exists('checks',$_REQUEST)) {
$checks = $_REQUEST['checks'];
} else {
$checks = array();
}
mysqli_query($rs_connect, "SET NAMES 'utf8'");


$rs_sq = "SELECT * FROM mainassettypes WHERE mainassettypeid = '$mainassettypeid'";
$rs_result1 = mysqli_query($rs_connect, $rs_sq);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$mainassetchecksindb2 = "$rs_result_q1->mainassetchecks";
if ($mainassetchecksindb2 != "") {
$mainassetchecksindb3 = unserialize($mainassetchecksindb2);
} else {
$mainassetchecksindb3 = array();
}

if(is_array($mainassetchecksindb3)) {
$mainassetchecksindb = $mainassetchecksindb3;
} else {
$mainassetchecksindb = array();
}

$origposition = array_search("$fid", $mainassetchecksindb);

if($dir == "up") {
$thewhere = $origposition - 1;
} else {
$thewhere = $origposition + 1;
}

#echo "<pre>orig in db \n\n";
#print_r($assetinfolistindb);
#echo "</pre><br><br>";

if(($key = array_search($fid, $mainassetchecksindb)) !== false) {
    unset($mainassetchecksindb[$key]);
}


$inserted[] = $fid;
array_splice($mainassetchecksindb, $thewhere, 0, $inserted );



$checks3 = array_filter($mainassetchecksindb);
$checks2 = pv(serialize($checks3));

#echo "Number that should move:$fid - $dir<br><pre>";
#print_r($assetinfolistindb);
#echo "</pre>";
#die();


$rs_update_sal = "UPDATE mainassettypes SET mainassetchecks = '$checks2' WHERE mainassettypeid = '$mainassettypeid'";
@mysqli_query($rs_connect, $rs_update_sal);

header("Location: admin.php?func=mainassetchecks&mainassettypeid=$mainassettypeid&mainassettypename=$mainassettypename");


}




function integrations() {

require("header.php");
require_once("common.php");
require("deps.php");

if ("$ipofpc" != "admin") {
die("admins only");
}

echo "<a href=../repair/admin.php class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-circle-left fa-lg\"></i> ".pcrtlang("Go Back to Settings")."</a><br><br>";

start_blue_box(pcrtlang("General Integrations"));

start_box();
echo "<span class=\"sizeme16 boldme\">Zapier Integration</span><br><br>";
echo pcrtlang("Zapier Invite URL").": ";

echo "<a href=\"https://zapier.com/developer/invite/53556/18a36bc60de310094f9f8acc4aa0124b/\">https://zapier.com/developer/invite/53556/18a36bc60de310094f9f8acc4aa0124b/</a>";

echo "<br><br>";



    echo "<i class=\"fa fa-key fa-lg\"></i> ".pcrtlang("API Key").": $storeinfoarray[storehash]";

echo "<br><br><span class=boldme>".pcrtlang("Description").": </span> Easy automation for busy people. Zapier moves info between your web apps automatically, so you can focus on your most important work.";

echo "<br><br><table class=standard><tr><th>".pcrtlang("Triggers")."</th><th>".pcrtlang("Actions")."</th></tr>";
echo "<tr><td>".pcrtlang("New Sticky Note")."</td><td>".pcrtlang("Create Group Contact")."</td></tr>";
echo "<tr><td>".pcrtlang("New Customer Group")."</td><td>".pcrtlang("Create Sticky Note")."</td></tr>";
echo "<tr><td>".pcrtlang("New Invoice")."</td><td>".pcrtlang("Create Service Request")."</td></tr>";
echo "<tr><td>".pcrtlang("New Work Order")."</td><td>".pcrtlang("Create a New Message")."</td></tr>";
echo "</table>";




stop_box();
echo "<br>";

start_box();
echo "<span class=\"sizeme16 boldme\">".pcrtlang("Calendar Sync Links for Sticky Notes")."</span><br><br>";
echo "<br><table class=standard>";

$storeinfoarray = getstoreinfo($defaultuserstore);
if ($storeinfoarray['storehash'] == "") {
echo "<tr><td>".pcrtlang("Please have your admin generate a calendar hash for the store").": $storeinfoarray[storesname]</td></tr>";
} else {
echo "<tr><td><strong>".pcrtlang("Whole Store").":</strong> <a href=$domain/ics.php?download=yes&user=all&storeid=$defaultuserstore&hash=$storeinfoarray[storehash] class=\"linkbuttontiny linkbuttongray radiusall\"><i class=\"fa fa-link fa-lg\"></i> link</a></tr></td>";
echo "<tr><td>$domain/ics.php?download=yes&user=all&storeid=$defaultuserstore&hash=$storeinfoarray[storehash]</tr></td>";
echo "<tr><td><strong>".pcrtlang("Your User Only").":</strong> <a href=$domain/ics.php?download=yes&user=$ipofpc&storeid=$defaultuserstore&hash=$storeinfoarray[storehash] class=\"linkbuttontiny linkbuttongray radiusall\"><i class=\"fa fa-link fa-lg\"></i> link</a></tr></td>";
echo "<tr><td>$domain/ics.php?download=yes&user=$ipofpc&storeid=$defaultuserstore&hash=$storeinfoarray[storehash]</tr></td>";

echo "<tr><td><strong>".pcrtlang("Store Hash").":</strong> $storeinfoarray[storehash]</td></tr>";
}

echo "</table>";
stop_box();
echo "<br>";

start_box();
echo "<span class=\"sizeme16 boldme\">".pcrtlang("Test Links for Topaz Sigweb Application")."</span><br><br>";
echo pcrtlang("Click the links below to test that the sigweb app is responding.")."<br>";
echo "<br>".pcrtlang("Non-SSL").": <a href=http://tablet.sigwebtablet.com:47290/SigWeb/>http://tablet.sigwebtablet.com:47290/SigWeb/</a>";
echo "<br>".pcrtlang("SSL").": <a href=https://tablet.sigwebtablet.com:47290/SigWeb/>https://tablet.sigwebtablet.com:47290/SigWeb/</a>";
echo "<br><br><a href=https://topazsystems.com/sdks/sigweb.html>".pcrtlang("SigWeb Download")."</a>";
echo "<br><br><a href=https://topazsystems.com/software/sigwebcertupdater.exe>".pcrtlang("SigWeb Certificate Updater")."</a>";
stop_box();
echo "<br>";

start_box();
echo "<span class=\"sizeme16 boldme\">".pcrtlang("Test Links for Dymo Label Writer Service")."</span><br><br>";
echo pcrtlang("Click the links below to test that the sigweb app is responding.")."<br>";
echo "<br>".pcrtlang("Non-SSL").": <a href=http://127.0.0.1:41951/DYMO/DLS/Printing/Check>http://127.0.0.1:41951/DYMO/DLS/Printing/Check</a>";
echo "<br>".pcrtlang("SSL").": <a href=https://127.0.0.1:41951/DYMO/DLS/Printing/Check>https://127.0.0.1:41951/DYMO/DLS/Printing/Check</a>";
echo "<br><br><a href=https://s3.amazonaws.com/download.dymo.com/dymo/Software/Win/DLS8Setup8.7.4.exe>".pcrtlang("Dymo Label Writer Software Download")."</a>";
stop_box();
echo "<br>";


stop_blue_box();

echo "<br><br>";

start_blue_box(pcrtlang("Repair Tool Integrations"));

start_box();
echo "<span class=\"sizeme16 boldme\">RepairTech TechSuite</span><br><br>";

echo pcrtlang("Integration URL").":<br><br>";

$hash =  "$storeinfoarray[storehash]";

echo "$domain/techsuite.php?hash=$hash";

echo "<br><br><span class=boldme>".pcrtlang("Description").": </span> RepairTech makes automated computer repair software design specifically for IT Professionals. Instead of manually running through every tool on your checklist, simply use TechSuite, select what you want to run ahead of time, click start, and come back to a full HTML report. TechSuite automates over 300 commonly used utilities, and should be on every serious technician's bench.";


echo "<br><br><a href=\"https://www.repairtechsolutions.com/techsuite/\" class=\"linkbuttonmedium linkbuttongray radiusall\">RepairTech TechSuite Website
<i class=\"fa fa-external-link-square fa-lg\"></i></a>";


stop_box();
echo "<br>";


start_box();
echo "<span class=\"sizeme16 boldme\">Carifred UVK</span><br><br>";
echo pcrtlang("Configured UVK Folder").": ";

if(isset($uvk_report_upload_directory)) {
echo "$uvk_report_upload_directory";
} else {
echo pcrtlang("UVK Folder not configured.");
}

echo "<br><br>";

if (file_exists($uvk_report_upload_directory)) {
    echo "<i class=\"fa fa-check fa-lg\"></i> ".pcrtlang("Folder is present");
} else {
    echo "<span class=colormered><i class=\"fa fa-warning fa-lg\"></i> ".pcrtlang("Folder is not present")."</span>";
}

echo "<br><br><span class=boldme>".pcrtlang("Description").": </span> The UVK project aims to create an application that can help anyone to easily remove all types of malware from computers running in the Windows platform, and also repair the damages caused by malware to the system with just a  few clicks. We want to save you lots of time, and ruin the bad guys day.";

echo "<br><br><a href=\"http://www.carifred.com/uvk/\" class=\"linkbuttonmedium linkbuttongray radiusall\">UVK Website
<i class=\"fa fa-external-link-square fa-lg\"></i></a>";


stop_box();
echo "<br>";



start_box();
echo "<span class=\"sizeme16 boldme\">Foolish IT D7II</span><br><br>";
echo pcrtlang("Configured D7II Folder").": ";

if(isset($d7_report_upload_directory)) {
echo "$d7_report_upload_directory";
} else {
echo pcrtlang("D7II Folder not configured.");
}

echo "<br><br>";

if (file_exists($d7_report_upload_directory)) {
    echo "<i class=\"fa fa-check fa-lg\"></i> ".pcrtlang("Folder is present");
} else {
    echo "<span class=colormered><i class=\"fa fa-warning fa-lg\"></i> ".pcrtlang("Folder is not present")."</span>";
}

echo "<br><br><span class=boldme>".pcrtlang("Description").": </span> d7II is a True Professional’s Multi-Tool designed for automation in diagnostic, Windows repair, and malware removal scenarios.";

echo "<br><br><a href=\"https://www.foolishit.com/d7ii/\" class=\"linkbuttonmedium linkbuttongray radiusall\">Foolish IT d7II Website 
<i class=\"fa fa-external-link-square fa-lg\"></i></a>";

stop_box();
echo "<br>";



start_box();
echo "<span class=\"sizeme16 boldme\">Scan Circle Integration</span><br><br>";

echo "<i class=\"fa fa-key fa-lg\"></i> ".pcrtlang("API Key").": $storeinfoarray[storehash]";

echo "<br><br><span class=boldme>".pcrtlang("Description").": </span> 
ScanCircle is a diagnostic tool for Windows computers. It retrieves the computer specs and compares it with similar computers, 
giving advice on how to improve security, stability and performance. With the ScanCircle partner program, you can let your clients 
perform scans from your website and support them if needed. Using this integration, the computer specs and scans can be automatically 
linked to your PC Repair Tracker assets and/or work orders saving you lots to time registering and managing assets.
";

echo "<br><br><a href=\"https://www.scancircle.com/scancircle/partner-program/pcrt\" class=\"linkbuttonmedium linkbuttongray radiusall\">ScanCircle Website <i class=\"fa fa-external-link-square fa-lg\"></i></a>";

stop_box();
echo "<br>";




stop_blue_box();

echo "<br><br>";

start_blue_box(pcrtlang("Messaging"));



start_box();
echo "<span class=\"sizeme16 boldme\">".pcrtlang("Pear Mailer Library")."</span><br><br>";
echo pcrtlang("Current Mailer Setting").": $pcrt_mailer<br>";

echo pcrtlang("PHP Include Path").": ".ini_get("include_path")."<br><br>";

if(($pcrt_mailer == "pearphpmailer") || ($pcrt_mailer == "pearsmtp") || ($pcrt_mailer == "pearsmtpauth")) {
echo "<i class=\"fa fa-check fa-lg\"></i> ".pcrtlang("Pear Enabled")."<br><br>";
echo pcrtlang("Outgoing SMTP Server").": $pcrt_pear_host<br>";
echo pcrtlang("Outgoing SMTP Port").": $pcrt_pear_port<br>";
echo pcrtlang("Outgoing SMTP Username").": $pcrt_pear_username";
} else {
echo "<i class=\"fa fa-times fa-lg\"></i> ".pcrtlang("Pear Not Enabled");
}
stop_box();
echo "<br>";


start_box();
echo "<span class=\"sizeme16 boldme\">".pcrtlang("SMS Setting")."</span><br><br>";
echo pcrtlang("Current SMS Setting").": $mysmsgateway<br><br>";

if("$mysmsgateway" == "twilio") {
echo pcrtlang("Twilio Incoming SMS Webhook").":<br>";
echo "$domain/twilioincoming.php?hash=$hash<br><br>";
echo pcrtlang("Twilio Incoming Voice Webhook").":<br>";
echo "$domain/twiliovoiceresponse.php?hash=$hash";
echo "<br><span class=\"italme sizeme10\">".pcrtlang("If someone calls your twilio number").", ".pcrtlang("it will give them a message and then redirect the call to your store number.")."</span>";

}

if("$mysmsgateway" == "smsglobal") {
echo pcrtlang("SMS Global Incoming SMS Webhook").":<br>";
echo "$domain/smsglobalincoming.php?hash=$hash";
}

if(("$mysmsgateway" == "clickatell") || ($mysmsgateway == "clickatellrest")) {
echo pcrtlang("Clickatell Incoming SMS Webhook").":<br>";
echo "$domain/clickatellincoming.php?hash=$hash";
}

if("$mysmsgateway" == "bulksms") {
echo pcrtlang("BulkSMS Incoming SMS Webhook").":<br>";
echo "$domain/bulksmsincoming.php?hash=$hash";
}


stop_box();
echo "<br>";


stop_blue_box();

echo "<br><br>";



start_blue_box(pcrtlang("Backup"));


start_box();
echo "<span class=\"sizeme16 boldme\">".pcrtlang("Dropbox")."</span><br><br>";

if(!isset($dropboxaccessToken)) {
echo "<span class=colormered><i class=\"fa fa-warning fa-lg\"></i> ".pcrtlang("Settings are not present")."</span>";
} else {

echo pcrtlang("Dropbox App Name").": $dropboxappname";

}

stop_box();
echo "<br>";

stop_blue_box();



require("footer.php");
}




function creddesc() {
require("header.php");
require_once("common.php");
require("deps.php");

perm_boot("13");



mysqli_query($rs_connect, "SET NAMES 'utf8'");

start_blue_box(pcrtlang("Manage Credential Descriptions"));
echo "<a href=../repair/admin.php class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-circle-left fa-lg\"></i> ".pcrtlang("Go Back to Settings")."</a><br><br>";

echo "<table>";
$rs_ql = "SELECT * FROM creddesc ORDER BY creddescorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$creddescid = "$rs_result_q1->creddescid";
$credtitle = "$rs_result_q1->credtitle";
$theorder = "$rs_result_q1->creddescorder";
echo "<tr><td><form action=admin.php?func=creddescsave method=post><input type=hidden name=creddescid value=$creddescid>";

echo "<a href=admin.php?func=reordercreddesc&creddescid=$creddescid&dir=up&theorder=$theorder class=\"linkbuttonsmall linkbuttongray radiusleft\">
<i class=\"fa fa-chevron-up fa-lg\"></i></a>";
echo "<a href=admin.php?func=reordercreddesc&creddescid=$creddescid&dir=down&theorder=$theorder class=\"linkbuttonsmall linkbuttongray radiusright\">
<i class=\"fa fa-chevron-down fa-lg\"></i></a>";
echo "</td><td><input type=text name=credtitle class=textbox value=\"$credtitle\">";
echo "</td><td><button type=submit class=sbutton><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button></form></td><td>
<form action=admin.php?func=creddescdelete method=post>";
echo "<input type=hidden name=creddescid value=$creddescid>";
echo "<button type=submit class=ibutton><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")."</button></form></td></tr>";

}

echo "</table>";

echo "<span class=\"sizemelarge boldme\">".pcrtlang("Add").":</span><br>";
echo "<form action=admin.php?func=creddescadd method=post>";
echo "<input type=text name=credtitle class=textbox><br>";
echo "<button type=submit class=sbutton><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Add")."</button></form>";

stop_blue_box();

require_once("footer.php");

}


function creddescsave() {
require_once("validate.php");

require("deps.php");
require("common.php");

perm_boot("13");

$creddescid = $_REQUEST['creddescid'];
$credtitle = pv($_REQUEST['credtitle']);



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_ct = "UPDATE creddesc SET credtitle = '$credtitle' WHERE creddescid = '$creddescid'";
@mysqli_query($rs_connect, $rs_insert_ct);

header("Location: admin.php?func=creddesc");
}

function creddescdelete() {
require_once("validate.php");

require("deps.php");
require("common.php");

$creddescid = $_REQUEST['creddescid'];

perm_boot("13");

if (($demo == "yes") && ("$ipofpc" != "admin")) {
die("Sorry this feature is disabled in demo mode");
}

mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_dct = "DELETE FROM creddesc WHERE creddescid = '$creddescid'";
@mysqli_query($rs_connect, $rs_dct);
header("Location: admin.php?func=creddesc");

}



function creddescadd() {
require_once("validate.php");
require("deps.php");
require("common.php");

perm_boot("13");

$credtitle = pv($_REQUEST['credtitle']);



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_creddesc = "INSERT INTO creddesc (credtitle) VALUES ('$credtitle')";
@mysqli_query($rs_connect, $rs_insert_creddesc);

header("Location: admin.php?func=creddesc");


}

function reordercreddesc() {
require_once("validate.php");

$creddescid = $_REQUEST['creddescid'];
$dir = $_REQUEST['dir'];
$theorder = $_REQUEST['theorder'];

require("deps.php");
require_once("common.php");
perm_boot("13");



mysqli_query($rs_connect, "SET NAMES 'utf8'");

if ($dir == "up") {
$rs_sq = "SELECT * FROM creddesc WHERE creddescorder > '$theorder' ORDER BY creddescorder ASC LIMIT 1";
} else {
$rs_sq = "SELECT * FROM creddesc WHERE creddescorder < '$theorder' ORDER BY creddescorder DESC LIMIT 1";
}

$rs_result1 = mysqli_query($rs_connect, $rs_sq);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
if(mysqli_num_rows($rs_result1) == "0") {
$nextorder = "$theorder";
} else {
$nextorder = "$rs_result_q1->creddescorder";
}


if ($dir == "up") {
$neworder = $nextorder + 1;
} else {
$neworder = $nextorder -1;
}

$rs_change_order = "UPDATE creddesc SET creddescorder = '$neworder' WHERE creddescid = $creddescid";
@mysqli_query($rs_connect, $rs_change_order);


$rs_resetorder = "SELECT * FROM creddesc ORDER BY creddescorder ASC";
$rs_resultreset = mysqli_query($rs_connect, $rs_resetorder);
$a = 0;
while($rs_result_r1 = mysqli_fetch_object($rs_resultreset)) {
$creddescmid = "$rs_result_r1->creddescid";
$rs_set_order = "UPDATE creddesc SET creddescorder = '$a' WHERE creddescid = $creddescmid";
@mysqli_query($rs_connect, $rs_set_order);
$a = $a + 5;
}


header("Location: admin.php?func=creddesc");


}



function clearlogins() {
require_once("validate.php");

require("deps.php");
require("common.php");

$username = $_REQUEST['username'];

mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_dla = "DELETE FROM loginattempts WHERE username = '$username'";
@mysqli_query($rs_connect, $rs_dla);
header("Location: admin.php?func=useraccounts&showuser=$username");

}

function enableuser() {
require_once("validate.php");

require("deps.php");
require("common.php");

$username = $_REQUEST['username'];
$enabled = $_REQUEST['enabled'];

mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_edu = "UPDATE users SET enabled = '$enabled' WHERE username = '$username'";
@mysqli_query($rs_connect, $rs_edu);
header("Location: admin.php?func=useraccounts&showuser=$username");

}



function manageportaldownloads() {

require("deps.php");
require("header.php");
require_once("common.php");

perm_boot("32");


start_blue_box(pcrtlang("Customer Portal Downloads"));
echo "<a href=../repair/admin.php class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-circle-left fa-lg\"></i> ".pcrtlang("Go Back to Settings")."</a><br><br>";
echo "<table class=standard>";

echo "<tr><th>".pcrtlang("Title")."</th><th>".pcrtlang("Filename")."</th><th></th></tr>";

$rs_df = "SELECT * FROM portaldownloads WHERE groupid = '0' ORDER BY downloadfiletitle DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_df);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$downloadid = "$rs_result_q1->downloadid";
$downloadfilename = "$rs_result_q1->downloadfilename";
$downloadfiletitle = "$rs_result_q1->downloadfiletitle";
$storedas = urlencode("$rs_result_q1->storedas");

echo "<tr><td>$downloadfiletitle</td><td>$downloadfilename</td><td>";
echo "<a href=\"admin.php?func=deleteportaldownload&downloadid=$downloadid&storedas=$storedas\"
class=\"linkbuttonsmall linkbuttonred radiusleft\"><i class=\"fa fa-times fa-lg\"></i> ".pcrtlang("Delete")."</a>";
echo "</td></tr>";

}

echo "</table>";
stop_blue_box();


start_blue_box(pcrtlang("Upload Customer Portal Download"));
echo "<form action=admin.php?func=uploadportaldownload method=post enctype=\"multipart/form-data\">";
echo "<table width=100%>";
echo "<tr><td>".pcrtlang("Pick File").":</td><td><input type=file name=downloadfilename>";
echo "</td></tr>";
echo "<tr><td>".pcrtlang("Download Title")."</td><td><input type=text name=downloadfiletitle class=textbox></td></tr>";
echo "<tr><td>&nbsp;</td><td><input type=submit class=button value=\"".pcrtlang("Upload File")."\"></form></td></tr>";
echo "</table>";


stop_blue_box();

require("footer.php");

}


function uploadportaldownload() {

require("deps.php");
require_once("validate.php");
require("common.php");

perm_boot("32");

$downloadfiletitle = pv($_REQUEST['downloadfiletitle']);

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

$rs_insert_pf = "INSERT INTO portaldownloads (downloadfilename,downloadfiletitle,storedas) VALUES ('$filename','$downloadfiletitle','$storedas')";
@mysqli_query($rs_connect, $rs_insert_pf);

header("Location: admin.php?func=manageportaldownloads");

}



function deleteportaldownload() {

require("deps.php");
require("common.php");

perm_boot("32");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}

$downloadid = pv($_REQUEST['downloadid']);
$storedas = pv($_REQUEST['storedas']);

require_once("validate.php");

$rs_set_p = "DELETE FROM portaldownloads WHERE downloadid = '$downloadid'";
@mysqli_query($rs_connect, $rs_set_p);

if (file_exists("../portal/downloads/$storedas")) {
unlink("../portal/downloads/$storedas");
}

header("Location: admin.php?func=manageportaldownloads");

}


function collapsestatus() {

require("deps.php");
require("common.php");

$collapse = pv($_REQUEST['collapse']);
$statusid = pv($_REQUEST['statusid']);
require_once("validate.php");

$rs_set_p = "UPDATE boxstyles SET collapsedstatus = '$collapse' WHERE statusid = '$statusid'";
@mysqli_query($rs_connect, $rs_set_p);

header("Location: admin.php?func=statusstyles#g$statusid");

}


function viewheaders() {
require("deps.php");
require("header.php");

echo "<a href=../repair/admin.php class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-circle-left fa-lg\"></i> ".pcrtlang("Go Back to Settings")."</a><br><br>";

$problems = "";

echo "<table class=standard>";
echo "<tr><th colspan=3>".pcrtlang("Server Response Headers")."</th></tr>";
$headers =  get_headers("$domain");
foreach($headers as $key=>$val){
$vals = explode(":", $val, 2);
  echo "<tr><td>$key</td><td>$vals[0]</td><td>";

if(isset($vals[1])) {
echo $vals[1];

if (preg_match("/varnish/i", $vals[1])) {
$problems .= "<span class=\"sizeme16 colormered\">Please Disable Unixy Varnish in your Control Panel</span><br>";
}

}

echo "</td></tr>";
}

echo "</table>";

echo "$problems";

require("footer.php");
}


#####


function showtags() {

require("header.php");
require_once("common.php");
require("deps.php");

perm_boot("35");



mysqli_query($rs_connect, "SET NAMES 'utf8'");

start_blue_box(pcrtlang("Manage Customer Tags"));
echo "<a href=../repair/admin.php class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-circle-left fa-lg\"></i> ".pcrtlang("Go Back to Settings")."</a><br><br>";

echo "<table class=standard>";

echo "<tr><th></th><th width=30%>".pcrtlang("Name")."</th><th width=20%></th><th width=20%></th></tr>";

$rs_sq = "SELECT * FROM custtags ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_sq);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$tagid = "$rs_result_q1->tagid";
$thetag = "$rs_result_q1->thetag";
$tagicon = "$rs_result_q1->tagicon";
$tagenabled = "$rs_result_q1->tagenabled";
$theorder = "$rs_result_q1->theorder";

$primero = mb_substr("$thetag", 0, 1);

echo "<tr><td>";

echo "<a href=admin.php?func=reordertags&tagid=$tagid&dir=up&theorder=$theorder class=\"linkbuttonsmall linkbuttongray radiusleft\">
<i class=\"fa fa-chevron-up fa-lg\"></i></a>";
echo "<a href=admin.php?func=reordertags&tagid=$tagid&dir=down&theorder=$theorder class=\"linkbuttonsmall linkbuttongray radiusright\">
<i class=\"fa fa-chevron-down fa-lg\"></i></a></td>";

if("$primero" == "-") {
$thetag = mb_substr("$thetag", 1);

echo "<td><span class=\"linkbuttonmedium linkbuttongraylabel radiusall displayblock\"> $thetag </span></td>";

if ($tagenabled == 1) {
echo "<td>".pcrtlang("enabled")."</td>";
} else {
echo "<td><span class=\"colormegray italme\">".pcrtlang("disabled")."</span></td>";
}


echo "<td><a href=admin.php?func=edittags&tagid=$tagid class=\"linkbuttonsmall linkbuttongray radiusleft\">".pcrtlang("edit")."</a><a href=admin.php?func=deletetags&tagid=$tagid class=\"linkbuttonsmall linkbuttongray radiusright\">".pcrtlang("delete")."</a></td></tr>";


} else {
if ($tagenabled == 1) {
echo "<td>";
if ($tagicon != "") {
echo "<img src=images/tags/$tagicon align=absmiddle width=24>";
}
echo "<span class=boldme> $thetag </span></td><td>".pcrtlang("enabled");

echo "</td><td><a href=admin.php?func=edittags&tagid=$tagid class=\"linkbuttonsmall linkbuttongray radiusleft\">".pcrtlang("edit")."</a>";
#if ($totalsources == "0") {
#echo "<a href=admin.php?func=deletecustsource&custsourceid=$custsourceid class=\"linkbuttonsmall linkbuttongray radiusright\">".pcrtlang("delete")."</a>";
#}

echo "</td></tr>";

} else {
echo "<td>";
if ($tagicon != "") {
echo "<img src=images/tags/$tagicon align=absmiddle width=24>"; 
}

echo " <span class=colormegray> $thetag</span></td><td><span class=\"colormegray italme\">".pcrtlang("disabled")."";

echo "</span></td><td>";
echo "<a href=admin.php?func=edittags&tagid=$tagid class=\"linkbuttonsmall linkbuttongray radiusleft\">".pcrtlang("edit")."</a>";

#if ($totalsources == "0") {
#echo "<a href=admin.php?func=deletetags&tagid=$tagid class=\"linkbuttonsmall linkbuttongray radiusright\">".pcrtlang("delete")."</a>";
#}


echo "</td><td>";
}
echo "</td></tr>";
}
}
echo "</table>";
echo "<br><br><a href=admin.php?func=addtags class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Add New Customer Tag")."</a>";

stop_blue_box();
echo "<br><br>";


require_once("footer.php");



}

function addtags() {

require("header.php");
require_once("common.php");
require("deps.php");

perm_boot("35");


start_blue_box(pcrtlang("Add Customer Tag"));
echo "<form action=admin.php?func=addtags2 method=post>";
echo "<table>";

echo "<tr><td><span class=boldme>".pcrtlang("Tag Name").":</span></td>";
echo "<td><input type=text size=35 class=textbox name=thetag value=\"\">
 <span class=\"sizemesmaller italme\">".pcrtlang("Prefix the name with a - to create a spacer").".</span></td></tr>";
echo "<tr><td><span class=boldme>".pcrtlang("Enabled").":</span></td>";
echo "<td>";
echo "<span class=boldme>".pcrtlang("Yes").":</span><input type=radio name=tagenabled checked value=on><br>";
echo "<span class=boldme>".pcrtlang("No").":</span><input type=radio name=tagenabled value=off>";
echo "</td></tr>";

echo "<tr><td colspan=2><span class=boldme>".pcrtlang("Choose Icon").":</span><br>";

$tagsdirectory = array_diff(scandir("images/tags/"), array('..', '.'));

reset($tagsdirectory);
foreach($tagsdirectory as $key => $val) {
echo "<input type=radio id=$key name=tagicon value=\"$val\"><label for=$key><img src=images/tags/$val></label>";

}

echo "<br><br></td></tr>";


echo "<tr><td><input type=submit value=\"".pcrtlang("Add Customer Tag")."\" class=ibutton></td><td></td></tr>";


echo "</form></table>";

stop_blue_box();
require("footer.php");

}


function addtags2() {

require("deps.php");
require("common.php");

perm_boot("35");

$thetag = pv($_REQUEST['thetag']);
$tagicon = $_REQUEST['tagicon'];
$tagenabled = $_REQUEST['tagenabled'];

require_once("validate.php");

if (($demo == "yes") && ("$ipofpc" != "admin")) {
die("Sorry this feature is disabled in demo mode");
}


if ($tagenabled == 'on') {
$tagenabled2 = 1;
} else {
$tagenabled2 = 0;
}


mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "INSERT INTO custtags (thetag, tagicon, tagenabled) VALUES ('$thetag','$tagicon','$tagenabled2')";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=showtags");

}

function edittags() {

require("header.php");
require_once("common.php");
require("deps.php");

perm_boot("35");

if (($demo == "yes") && ("$ipofpc" != "admin")) {
die("Sorry this feature is disabled in demo mode");
}

$tagid = $_REQUEST['tagid'];

$rs_ql = "SELECT * FROM custtags WHERE tagid = '$tagid'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$thetag = "$rs_result_q1->thetag";
$tagenabled = "$rs_result_q1->tagenabled";
$tagicon = "$rs_result_q1->tagicon";


start_blue_box(pcrtlang("Edit Customer Tag"));
echo "<form action=admin.php?func=edittags2 method=post>";
echo "<table>";

echo "<tr><td><span class=boldme>".pcrtlang("Customer Tag").":</span></td>";
echo "<td><input type=text size=35 name=thetag value=\"$thetag\" class=textbox> <span class=\"sizemesmaller italme\">".pcrtlang("Prefix the name with a - to create a spacer").".</span></td></tr>";
echo "<tr><td><span class=boldme>".pcrtlang("Enabled").":</span></td>";
echo "<td>";
if($tagenabled == 1) {
echo "<span class=boldme>".pcrtlang("Yes").":</span><input type=radio name=tagenabled checked value=on><br>";
echo "<span class=boldme>".pcrtlang("No").":</span><input type=radio name=tagenabled value=off>";
} else {
echo "<span class=boldme>".pcrtlang("Yes").":</span><input type=radio name=tagenabled value=on><br>";
echo "<span class=boldme>".pcrtlang("No").":</span><input type=radio name=tagenabled checked value=off>";
}
echo "</td></tr>";

echo "<input type=hidden value=\"$tagid\" name=tagid></td></tr>";

echo "<tr><td colspan=2><span class=boldme>".pcrtlang("Choose Icon").":</span><br>";

$tagsdirectory = array_diff(scandir("images/tags/"), array('..', '.'));

reset($tagsdirectory);
foreach($tagsdirectory as $key => $val) {
if ($tagicon == "$val") {
echo "<input type=radio id=$key name=tagicon value=\"$val\" checked><label for=$key><img src=images/tags/$val></label>";
} else {
echo "<input type=radio id=$key name=tagicon value=\"$val\"><label for=$key><img src=images/tags/$val></label>";
}

}

echo "<br><br></td></tr>";


echo "<tr><td><input type=submit value=\"".pcrtlang("Save")."\" class=ibutton></td><td></td></tr>";


echo "</form></table>";

stop_blue_box();
require("footer.php");

}


function edittags2() {

require("deps.php");
require("common.php");

perm_boot("35");

$thetag = pv($_REQUEST['thetag']);
$tagicon = $_REQUEST['tagicon'];
$tagenabled = $_REQUEST['tagenabled'];
$tagid = $_REQUEST['tagid'];

require_once("validate.php");

if (($demo == "yes") && ("$ipofpc" != "admin")) {
die("Sorry this feature is disabled in demo mode");
}


if ($tagenabled == 'on') {
$tagenabled2 = 1;
} else {
$tagenabled2 = 0;
}

mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "UPDATE custtags SET thetag = '$thetag',  tagicon = '$tagicon', tagenabled = '$tagenabled2' WHERE tagid = '$tagid'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=showtags");
}


function reordertags() {
require_once("validate.php");

$tagid = $_REQUEST['tagid'];
$dir = $_REQUEST['dir'];
$theorder = $_REQUEST['theorder'];

require("deps.php");
require_once("common.php");
perm_boot("35");

mysqli_query($rs_connect, "SET NAMES 'utf8'");

if ($dir == "up") {
$rs_sq = "SELECT * FROM custtags WHERE theorder > '$theorder' ORDER BY theorder ASC LIMIT 1";
} else {
$rs_sq = "SELECT * FROM custtags WHERE theorder < '$theorder' ORDER BY theorder DESC LIMIT 1";
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

$rs_insert_scan = "UPDATE custtags SET theorder = '$neworder' WHERE tagid = $tagid";
@mysqli_query($rs_connect, $rs_insert_scan);


$rs_resetorder = "SELECT * FROM custtags ORDER BY theorder ASC";
$rs_resultreset = mysqli_query($rs_connect, $rs_resetorder);
$a = 0;
while($rs_result_r1 = mysqli_fetch_object($rs_resultreset)) {
$tagid = "$rs_result_r1->tagid";
$rs_set_order = "UPDATE custtags SET theorder = '$a' WHERE tagid = $tagid";
@mysqli_query($rs_connect, $rs_set_order);
$a = $a + 5;
}


header("Location: admin.php?func=showtags");


}



######


function deletetags() {
require_once("validate.php");

require("deps.php");
require("common.php");

perm_boot("35");

if (($demo == "yes") && ("$ipofpc" != "admin")) {
die("Sorry this feature is disabled in demo mode");
}

$tagid = $_REQUEST['tagid'];

$rs_delete_tag = "DELETE FROM custtags WHERE tagid = '$tagid'";
@mysqli_query($rs_connect, $rs_delete_tag);

header("Location: admin.php?func=showtags");

}


function servicepromises() {
require("header.php");
require_once("common.php");
require("deps.php");

perm_boot("38");

mysqli_query($rs_connect, "SET CHARACTER SET utf8");

start_blue_box(pcrtlang("Service Promises"));
echo "<a href=../repair/admin.php class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-circle-left fa-lg\"></i> ".pcrtlang("Go Back to Settings")."</a><br><br>";

echo "<table class=standard>";

echo "<tr><th></th><th>".pcrtlang("Title")."</th><th>".pcrtlang("Interval")."</th><th>".pcrtlang("Time of Day")."</th><th></th></tr>";
$rs_sl = "SELECT * FROM servicepromises ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_sl);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$servicepromiseid = "$rs_result_q1->servicepromiseid";
$sptitle = "$rs_result_q1->sptitle";
$sptype = "$rs_result_q1->sptype";
$sptime = "$rs_result_q1->sptime";
$sptimeofday = "$rs_result_q1->sptimeofday";
$theorder = "$rs_result_q1->theorder";


echo "<tr><td valign=top>";
echo "<a href=admin.php?func=reordersp&servicepromiseid=$servicepromiseid&dir=up&theorder=$theorder class=\"linkbuttonsmall linkbuttongray radiusleft\">
<i class=\"fa fa-chevron-up fa-lg\"></i></a>";
echo "<a href=admin.php?func=reordersp&servicepromiseid=$servicepromiseid&dir=down&theorder=$theorder class=\"linkbuttonsmall linkbuttongray radiusright\">
<i class=\"fa fa-chevron-down fa-lg\"></i></a>";
echo "</td>";
if($sptype == 1) {
echo "<td><span class=boldme>$sptitle</span></td>";
echo "<td>".time2hourcount($sptime)."</td>";
echo "<td></td>";
} else {
echo "<td><span class=boldme>$sptitle</span></td>";
$sptime = $sptime / 86400;
echo "<td>$sptime ".pcrtlang("day(s)")."</td>";
$sptimeofday = date('g:iA', strtotime("$sptimeofday"));
echo "<td>$sptimeofday</td>";
}
echo "<td valign=top><form action=admin.php?func=spdelete method=post>";
echo "<input type=hidden name=servicepromiseid value=$servicepromiseid>";
echo "<button type=submit class=ibutton><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")."</button></form>";

echo "</td></tr>";

}

echo "</table>";

echo "<form action=admin.php?func=spadd&sptype=1 method=post>";
echo "<input type=hidden name=timepick value=0>";
echo "<table class=standard><tr><th colspan=2>".pcrtlang("Add by Time").":</span></th></tr>";
echo "<tr><td>".pcrtlang("Title")."</td><td><input type=text name=sptitle size=50 value=\"\" class=textbox></td></tr>";
echo "<tr><td>".pcrtlang("Weeks")."</td><td><input type=text name=spweeks size=10 value=\"\" class=textbox></td></tr>";
echo "<tr><td>".pcrtlang("Days")."</td><td><input type=text name=spdays size=10 value=\"\" class=textbox></td></tr>";
echo "<tr><td>".pcrtlang("Hours")."</td><td><input type=text name=sphours size=10 value=\"\" class=textbox></td></tr>";
echo "<tr><td>".pcrtlang("Minutes")."</td><td><input type=text name=spminutes size=10 value=\"\" class=textbox></td></tr>";
echo "<tr><td colspan=2><button type=submit class=sbutton><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Add")."</button></td></tr></table></form>";

echo "<br><br>";

echo "<form action=admin.php?func=spadd&sptype=2 method=post>";
echo "<input type=hidden name=spweeks value=0>";
echo "<input type=hidden name=sphours value=0>";
echo "<input type=hidden name=spminutes value=0>";
echo "<table class=standard><tr><th colspan=2>".pcrtlang("Add by Time of Day").":</span></th></tr>";
echo "<tr><td>".pcrtlang("Title")."</td><td><input type=text name=sptitle size=50 value=\"\" class=textbox></td></tr>";
echo "<tr><td>".pcrtlang("Days")."</td><td><input type=text name=spdays size=10 value=\"\" class=textbox></td></tr>";
echo "<tr><td>".pcrtlang("Time of Day")."</td><td>";
picktime('timepick',"5:00 PM");
echo "</td></tr>";
echo "<tr><td colspan=2><button type=submit class=sbutton><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Add")."</button></td></tr></table></form>";


stop_blue_box();

require_once("footer.php");

}



function spdelete() {
require_once("validate.php");

require("deps.php");
require("common.php");

$servicepromiseid = $_REQUEST['servicepromiseid'];

perm_boot("38");

if (($demo == "yes") && ("$ipofpc" != "admin")) {
die("Sorry this feature is disabled in demo mode");
}

mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "DELETE FROM servicepromises WHERE servicepromiseid = '$servicepromiseid'";
@mysqli_query($rs_connect, $rs_insert_scan);
header("Location: admin.php?func=servicepromises");

}


function spadd() {
require_once("validate.php");

require("deps.php");
require("common.php");

perm_boot("38");

$sptype = pv($_REQUEST['sptype']);
$sptitle = pv($_REQUEST['sptitle']);
$spweeks = pv($_REQUEST['spweeks']);
$spdays = pv($_REQUEST['spdays']);
$sphours = pv($_REQUEST['sphours']);
$spminutes = pv($_REQUEST['spminutes']);
$sptimepick = pv($_REQUEST['timepick']);





mysqli_query($rs_connect, "SET NAMES 'utf8'");

if($sptype == 1) {
$sptime = ($spminutes * 60) + ($sphours * 3600) + ($spdays * 84600) + ($spweeks * 604800);
$rs_insert_scan = "INSERT INTO servicepromises (sptitle,sptype,sptime) VALUES ('$sptitle','$sptype','$sptime')";
} else {
$sptimeofday = date('H:i:s', strtotime("$sptimepick"));
$spdays = number_format($spdays) * 86400;
$rs_insert_scan = "INSERT INTO servicepromises (sptitle,sptype,sptime,sptimeofday) VALUES ('$sptitle','$sptype','$spdays','$sptimeofday')";
}

@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=servicepromises");

}

function reordersp() {
require_once("validate.php");

$servicepromiseid = $_REQUEST['servicepromiseid'];
$dir = $_REQUEST['dir'];
$theorder = $_REQUEST['theorder'];

require("deps.php");
require_once("common.php");
perm_boot("38");



mysqli_query($rs_connect, "SET NAMES 'utf8'");

if ($dir == "up") {
$rs_sq = "SELECT * FROM servicepromises WHERE theorder > '$theorder' ORDER BY theorder ASC LIMIT 1";
} else {
$rs_sq = "SELECT * FROM servicepromises WHERE theorder < '$theorder' ORDER BY theorder DESC LIMIT 1";
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
$rs_insert_scan = "UPDATE servicepromises SET theorder = '$neworder' WHERE servicepromiseid = $servicepromiseid";
@mysqli_query($rs_connect, $rs_insert_scan);


$rs_resetorder = "SELECT * FROM servicepromises ORDER BY theorder ASC";
$rs_resultreset = mysqli_query($rs_connect, $rs_resetorder);
$a = 0;
while($rs_result_r1 = mysqli_fetch_object($rs_resultreset)) {
$servicepromiseid2 = "$rs_result_r1->servicepromiseid";
$rs_set_order = "UPDATE servicepromises SET theorder = '$a' WHERE servicepromiseid = $servicepromiseid2";
@mysqli_query($rs_connect, $rs_set_order);
$a = $a + 5;
}


header("Location: admin.php?func=servicepromises");

}

##


function discounts() {
require("header.php");
require_once("common.php");
require("deps.php");

perm_boot("39");

mysqli_query($rs_connect, "SET CHARACTER SET utf8");

start_blue_box(pcrtlang("Discounts"));
echo "<a href=../repair/admin.php class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-circle-left fa-lg\"></i> ".pcrtlang("Go Back to Settings")."</a><br><br>";
echo "<table class=standard>";

echo "<tr><th></th><th>".pcrtlang("Discount Title")."</th><th>".pcrtlang("Amount")."</th><th></th></tr>";
$rs_sl = "SELECT * FROM discounts ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_sl);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$discountid = "$rs_result_q1->discountid";
$discounttitle = "$rs_result_q1->discounttitle";
$discounttype = "$rs_result_q1->discounttype";
$discountamount = "$rs_result_q1->discountamount";
$theorder = "$rs_result_q1->theorder";


echo "<tr><td valign=top>";
echo "<a href=admin.php?func=reorderdiscounts&discountid=$discountid&dir=up&theorder=$theorder class=\"linkbuttonsmall linkbuttongray radiusleft\">
<i class=\"fa fa-chevron-up fa-lg\"></i></a>";
echo "<a href=admin.php?func=reorderdiscounts&discountid=$discountid&dir=down&theorder=$theorder class=\"linkbuttonsmall linkbuttongray radiusright\">
<i class=\"fa fa-chevron-down fa-lg\"></i></a>";
echo "</td>";
if($discounttype == 1) {
echo "<td><span class=boldme>$discounttitle</span></td>";
echo "<td>".mf("$discountamount")."%</td>";
} else {
echo "<td><span class=boldme>$discounttitle</span></td>";
echo "<td>$money".mf("$discountamount")."</td>";
}
echo "<td valign=top><form action=admin.php?func=discountsdelete method=post>";
echo "<input type=hidden name=discountid value=$discountid>";
echo "<button type=submit class=ibutton><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")."</button></form>";

echo "</td></tr>";

}

echo "</table>";

echo "<form action=admin.php?func=discountsadd&discounttype=1 method=post>";
echo "<input type=hidden name=timepick value=0>";
echo "<table class=standard><tr><th colspan=2>".pcrtlang("Add by Percentage").":</span></th></tr>";
echo "<tr><td>".pcrtlang("Title")."</td><td><input type=text name=discounttitle size=50 value=\"\" class=textbox></td></tr>";
echo "<tr><td>".pcrtlang("Percentage")."</td><td><input type=text name=discountamount size=10 value=\"\" class=textbox>%</td></tr>";
echo "<tr><td colspan=2><button type=submit class=sbutton><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Save")."</button></td></tr></table></form>";

echo "<br><br>";

echo "<form action=admin.php?func=discountsadd&discounttype=2 method=post>";
echo "<table class=standard><tr><th colspan=2>".pcrtlang("Add by Nominal Value").":</span></th></tr>";
echo "<tr><td>".pcrtlang("Title")."</td><td><input type=text name=discounttitle size=50 value=\"\" class=textbox></td></tr>";
echo "<tr><td>".pcrtlang("Nominal Amount")."</td><td>$money<input type=text name=discountamount size=10 value=\"\" class=textbox></td></tr>";
echo "<tr><td colspan=2><button type=submit class=sbutton><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Save")."</button></td></tr></table></form>";


stop_blue_box();

require_once("footer.php");

}


function discountsdelete() {
require_once("validate.php");

require("deps.php");
require("common.php");

$discountid = $_REQUEST['discountid'];

perm_boot("39");

if (($demo == "yes") && ("$ipofpc" != "admin")) {
die("Sorry this feature is disabled in demo mode");
}

mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "DELETE FROM discounts WHERE discountid = '$discountid'";
@mysqli_query($rs_connect, $rs_insert_scan);
header("Location: admin.php?func=discounts");

}


function discountsadd() {
require_once("validate.php");

require("deps.php");
require("common.php");

perm_boot("39");

$discounttype = pv($_REQUEST['discounttype']);
$discounttitle = pv($_REQUEST['discounttitle']);
$discountamount = pv($_REQUEST['discountamount']);

mysqli_query($rs_connect, "SET NAMES 'utf8'");
$rs_insert_scan = "INSERT INTO discounts (discounttitle,discounttype,discountamount) VALUES ('$discounttitle','$discounttype','$discountamount')";

@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=discounts");

}

function reorderdiscounts() {
require_once("validate.php");

$discountid = $_REQUEST['discountid'];
$dir = $_REQUEST['dir'];
$theorder = $_REQUEST['theorder'];

require("deps.php");
require_once("common.php");
perm_boot("39");

mysqli_query($rs_connect, "SET NAMES 'utf8'");

if ($dir == "up") {
$rs_sq = "SELECT * FROM discounts WHERE theorder > '$theorder' ORDER BY theorder ASC LIMIT 1";
} else {
$rs_sq = "SELECT * FROM discounts WHERE theorder < '$theorder' ORDER BY theorder DESC LIMIT 1";
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
$rs_insert_scan = "UPDATE discounts SET theorder = '$neworder' WHERE discountid = $discountid";
@mysqli_query($rs_connect, $rs_insert_scan);


$rs_resetorder = "SELECT * FROM discounts ORDER BY theorder ASC";
$rs_resultreset = mysqli_query($rs_connect, $rs_resetorder);
$a = 0;
while($rs_result_r1 = mysqli_fetch_object($rs_resultreset)) {
$discountid2 = "$rs_result_r1->discountid";
$rs_set_order = "UPDATE discounts SET theorder = '$a' WHERE discountid = $discountid2";
@mysqli_query($rs_connect, $rs_set_order);
$a = $a + 5;
}


header("Location: admin.php?func=discounts");

}


function invoiceterms() {
require("header.php");
require_once("common.php");
require("deps.php");

perm_boot("43");

mysqli_query($rs_connect, "SET CHARACTER SET utf8");

start_blue_box(pcrtlang("Invoice Terms"));
echo "<a href=../repair/admin.php class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-circle-left fa-lg\"></i> ".pcrtlang("Go Back to Settings")."</a><br><br>";

echo "<table class=standard>";

echo "<tr><th></th><th>".pcrtlang("Invoice Terms Title")."</th><th>".pcrtlang("Terms Days")."</th><th>".pcrtlang("Monthly Late Fee")."</th><th>".pcrtlang("Late Fee Tax Rate")."</th><th></th></tr>";
$rs_sl = "SELECT * FROM invoiceterms ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_sl);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$invoicetermsid = "$rs_result_q1->invoicetermsid";
$invoicetermstitle = "$rs_result_q1->invoicetermstitle";
$invoicetermsdays = "$rs_result_q1->invoicetermsdays";
$invoicetermslatefee = "$rs_result_q1->invoicetermslatefee";
$invoicetermsdefault = "$rs_result_q1->invoicetermsdefault";
$theorder = "$rs_result_q1->theorder";
$taxid = "$rs_result_q1->taxid";


echo "<tr><td valign=top>";
echo "<a href=admin.php?func=reorderinvoiceterms&invoicetermsid=$invoicetermsid&dir=up&theorder=$theorder class=\"linkbuttonsmall linkbuttongray radiusleft\">
<i class=\"fa fa-chevron-up fa-lg\"></i></a>";
echo "<a href=admin.php?func=reorderinvoiceterms&invoicetermsid=$invoicetermsid&dir=down&theorder=$theorder class=\"linkbuttonsmall linkbuttongray radiusright\">
<i class=\"fa fa-chevron-down fa-lg\"></i></a>";
echo "</td>";
echo "<td><span class=boldme>$invoicetermstitle</span>";

if($invoicetermsdefault == 1) {
echo "(".pcrtlang("default").")";
}

echo "</td>";
echo "<td>$invoicetermsdays</td>";
echo "<td>".mf("$invoicetermslatefee")."%</td>";

$taxname = gettaxname("$taxid");

echo "<td>$taxname</td>";

echo "<td valign=top>";

$rs_fit = "SELECT * FROM invoices WHERE invoicetermsid = '$invoicetermsid'";
$rs_resultfit = mysqli_query($rs_connect, $rs_fit);
if(mysqli_num_rows($rs_resultfit) == "0") {
echo "<form action=admin.php?func=invoicetermsdelete method=post>";
echo "<input type=hidden name=invoicetermsid value=$invoicetermsid>";
echo "<button type=submit class=ibutton><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")."</button></form>";
}

if($invoicetermsdefault == "0") {
echo "<form action=admin.php?func=invoicetermssetdefault method=post>";
echo "<input type=hidden name=invoicetermsid value=$invoicetermsid>";
echo "<button type=submit class=button><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Set Default")."</button></form>";
}


echo "</td></tr>";

}


echo "</table><br><br>";

echo "<span class=colormeblue><i class=\"fa fa-info-circle fa-lg\"></i> ".pcrtlang("The tax rate used is the service tax rate.")."</span><br><br>";

echo "<form action=admin.php?func=invoicetermsadd method=post>";
echo "<table class=standard><tr><th colspan=2>".pcrtlang("Add Invoice Terms").":</span></th></tr>";
echo "<tr><td>".pcrtlang("Invoice Terms Title")."</td><td><input type=text name=invoicetermstitle size=50 value=\"\" class=textbox></td></tr>";
echo "<tr><td>".pcrtlang("Terms Days")."</td><td><input type=number min=0 max=180 name=invoicetermsdays size=10 value=\"\" class=textbox></td></tr>";
echo "<tr><td>".pcrtlang("Monthly Late Fee")."</td><td><input type=text name=invoicetermslatefee size=10 value=\"\" class=textbox>%</td></tr>";
echo "<tr><td>".pcrtlang("Fee Tax Rate")."</td><td>";

$rs_find_tax = "SELECT * FROM taxes WHERE taxenabled = '1' ORDER BY taxname ASC";
$rs_result_tax = mysqli_query($rs_connect, $rs_find_tax);
$usertaxid = getusertaxid();
echo "<select name=taxid>";
while($rs_result_tq = mysqli_fetch_object($rs_result_tax)) {
$rs_taxname = "$rs_result_tq->taxname";
$rs_taxid = "$rs_result_tq->taxid";
if ($rs_taxid == $usertaxid) {
echo "<option selected value=$rs_taxid>$rs_taxname</option>";
} else {
echo "<option value=$rs_taxid>$rs_taxname</option>";
}
}
echo "</select>";


echo "</td></tr>";





echo "<tr><td colspan=2><button type=submit class=sbutton><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Save")."</button></td></tr></table></form>";

echo "<br><br>";

stop_blue_box();

require_once("footer.php");

}


function invoicetermsdelete() {
require_once("validate.php");

require("deps.php");
require("common.php");

$invoicetermsid = $_REQUEST['invoicetermsid'];

perm_boot("43");

if (($demo == "yes") && ("$ipofpc" != "admin")) {
die("Sorry this feature is disabled in demo mode");
}

mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_scan = "DELETE FROM invoiceterms WHERE invoicetermsid = '$invoicetermsid'";
@mysqli_query($rs_connect, $rs_insert_scan);
header("Location: admin.php?func=invoiceterms");

}


function invoicetermsadd() {
require_once("validate.php");

require("deps.php");
require("common.php");

perm_boot("43");

$invoicetermstitle = pv($_REQUEST['invoicetermstitle']);
$invoicetermsdays = pv($_REQUEST['invoicetermsdays']);
$invoicetermslatefee = pv($_REQUEST['invoicetermslatefee']);
$taxid = pv($_REQUEST['taxid']);

mysqli_query($rs_connect, "SET NAMES 'utf8'");
$rs_insert_scan = "INSERT INTO invoiceterms (invoicetermstitle,invoicetermsdays,invoicetermslatefee,taxid) VALUES ('$invoicetermstitle','$invoicetermsdays','$invoicetermslatefee','$taxid')";

@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=invoiceterms");

}

function reorderinvoiceterms() {
require_once("validate.php");

$invoicetermsid = $_REQUEST['invoicetermsid'];
$dir = $_REQUEST['dir'];
$theorder = $_REQUEST['theorder'];

require("deps.php");
require_once("common.php");
perm_boot("43");

mysqli_query($rs_connect, "SET NAMES 'utf8'");

if ($dir == "up") {
$rs_sq = "SELECT * FROM invoiceterms WHERE theorder > '$theorder' ORDER BY theorder ASC LIMIT 1";
} else {
$rs_sq = "SELECT * FROM invoiceterms WHERE theorder < '$theorder' ORDER BY theorder DESC LIMIT 1";
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
$rs_insert_scan = "UPDATE invoiceterms SET theorder = '$neworder' WHERE invoicetermsid = $invoicetermsid";
@mysqli_query($rs_connect, $rs_insert_scan);


$rs_resetorder = "SELECT * FROM invoiceterms ORDER BY theorder ASC";
$rs_resultreset = mysqli_query($rs_connect, $rs_resetorder);
$a = 0;
while($rs_result_r1 = mysqli_fetch_object($rs_resultreset)) {
$invoicetermsid2 = "$rs_result_r1->invoicetermsid";
$rs_set_order = "UPDATE invoiceterms SET theorder = '$a' WHERE invoicetermsid = $invoicetermsid2";
@mysqli_query($rs_connect, $rs_set_order);
$a = $a + 5;
}


header("Location: admin.php?func=invoiceterms");

}


function invoicetermssetdefault() {
require_once("validate.php");

$invoicetermsid = $_REQUEST['invoicetermsid'];

require("deps.php");
require_once("common.php");
perm_boot("43");

mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_cd = "UPDATE invoiceterms SET invoicetermsdefault = '0'";
@mysqli_query($rs_connect, $rs_insert_cd);

$rs_insert_sd = "UPDATE invoiceterms SET invoicetermsdefault = '1' WHERE invoicetermsid = $invoicetermsid";
@mysqli_query($rs_connect, $rs_insert_sd);

header("Location: admin.php?func=invoiceterms");

}




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

  case "reorderstatus":
    reorderstatus();
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

case "statusoptionssave":
    statusoptionssave();
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

 case "deleteswatch":
    deleteswatch();
    break;

 case "backupdatabasetodropbox":
    backupdatabasetodropbox();
    break;

 case "switchuser":
    switchuser();
    break;

 case "switchuser2":
    switchuser2();
    break;

 case "savepin":
    savepin();
    break;

 case "registersave":
    registersave();
    break;

 case "registeradd":
    registeradd();
    break;

 case "registerdelete":
    registerdelete();
    break;

 case "denomsave":
    denomsave();
    break;

 case "denomadd":
    denomadd();
    break;

 case "denomdelete":
    denomdelete();
    break;

 case "denoms":
    denoms();
    break;

 case "setregister":
    setregister();
    break;

    case "storagelocations":
    storagelocations();
    break;

    case "slsave":
    slsave();
    break;

    case "sldelete":
    sldelete();
    break;

    case "sladd":
    sladd();
    break;

    case "reordersl":
    reordersl();
    break;

    case "checksave":
    checksave();
    break;

    case "checkdelete":
    checkdelete();
    break;

    case "checkadd":
    checkadd();
    break;

    case "mainassetchecks":
    mainassetchecks();
    break;

    case "mainassetcheckssave":
    mainassetcheckssave();
    break;

    case "reorderchecks":
    reorderchecks();
    break;

    case "integrations":
    integrations();
    break;

    case "creddesc":
    creddesc();
    break;

    case "creddescsave":
    creddescsave();
    break;

    case "creddescdelete":
    creddescdelete();
    break;

    case "creddescadd":
    creddescadd();
    break;

    case "reordercreddesc":
    reordercreddesc();
    break;

    case "clearlogins":
    clearlogins();
    break;

    case "enableuser":
    enableuser();
    break;

    case "manageportaldownloads":
    manageportaldownloads();
    break;

    case "uploadportaldownload":
    uploadportaldownload();
    break;

    case "deleteportaldownload":
    deleteportaldownload();
    break;

    case "collapsestatus":
    collapsestatus();
    break;

    case "viewheaders":
    viewheaders();
    break;

case "showtags":
    showtags();
    break;

case "addtags":
    addtags();
    break;

case "addtags2":
    addtags2();
    break;

case "deletetags":
    deletetags();
    break;

case "edittags":
    edittags();
    break;

case "edittags2":
    edittags2();
    break;

case "reordertags":
    reordertags();
    break;

case "deletetags":
    deletetags();
    break;

    case "servicepromises":
    servicepromises();
    break;

    case "spsave":
    spsave();
    break;

    case "spdelete":
    spdelete();
    break;

    case "spadd":
    spadd();
    break;

    case "reordersp":
    reordersp();
    break;

    case "discounts":
    discounts();
    break;

    case "discountssave":
    discountssave();
    break;

    case "discountsdelete":
    discountsdelete();
    break;

    case "discountsadd":
    discountsadd();
    break;

    case "reorderdiscounts":
    reorderdiscounts();
    break;

    case "invoiceterms":
    invoiceterms();
    break;

    case "invoicetermssave":
    invoicetermssave();
    break;

    case "invoicetermsdelete":
    invoicetermsdelete();
    break;

    case "invoicetermsadd":
    invoicetermsadd();
    break;

    case "invoicetermssetdefault":
    invoicetermssetdefault();
    break;

    case "reorderinvoiceterms":
    reorderinvoiceterms();
    break;


}
