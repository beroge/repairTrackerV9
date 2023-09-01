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

$pcwo = $_REQUEST['pcwo'];

if ($gomodal == 1) {
$therel = "rel=facebox";
} else {
$therel = "";
}


echo "<br>";
start_box();
echo "<table><tr><td width=50% valign=top><h4>&nbsp;<img src=images/scan.png border=0 align=absmiddle> ".pcrtlang("Scans")."&nbsp;</h4>";


echo "<table class=scanlist>";
$rs_foundscan = "SELECT * FROM pc_scan WHERE woid = '$pcwo' ORDER BY scantime ASC";
$rs_result_fs = mysqli_query($rs_connect, $rs_foundscan);
$bgswitch=2;
while($rs_result_fsr = mysqli_fetch_object($rs_result_fs)) {
$scanid = "$rs_result_fsr->scanid";
$scantype = "$rs_result_fsr->scantype";
$scannum = "$rs_result_fsr->scannum";
$scantime = "$rs_result_fsr->scantime";
$customprogname = "$rs_result_fsr->customprogname";
$customprintinfo = "$rs_result_fsr->customprintinfo";
$customscantype = "$rs_result_fsr->customscantype";
$byuser = "$rs_result_fsr->byuser";

$scantime2 = pcrtdate("$pcrt_time", "$scantime")." ".pcrtdate("$pcrt_shortdate", "$scantime");


$rs_foundscan_name = "SELECT * FROM pc_scans WHERE scanid = '$scantype'";
$rs_result_fs_name = mysqli_query($rs_connect, $rs_foundscan_name);
if ($scantype != "0") {
$rs_result_fsr_name = mysqli_fetch_object($rs_result_fs_name);
$scantypeid = "$rs_result_fsr_name->scanid";
$scantypeprogname = "$rs_result_fsr_name->progname";
$scantypeicon = "$rs_result_fsr_name->progicon";
$scantypetype = "$rs_result_fsr_name->scantype";
} else {
$scantypetype = $customscantype;
}



if (($scantypetype == 0) || ($customscantype == 0)){
echo "<tr><td>";

if ($scantype == 0) {
echo "<img src=images/hand.png>";
} else {
echo "<img src=images/scans/$scantypeicon>";
}

echo "</td><td>";

if ($customprogname != "") {
echo "<span class=\"boldme\">$customprogname</span>";
} else {
echo "<span class=\"boldme\">$scantypeprogname</span>";
}

if ($customprintinfo == "") {
$alreadycustom = 0;
} else {
$alreadycustom = 1;
}

if ($scannum != 0) {
echo "<br><span class=\"colormered sizemesmaller\"><i class=\"fa fa-bug\"></i> $scannum ".pcrtlang("item(s) found")."</span>";
} else {
echo "<br><span class=\"colormeblue sizemesmaller\">".pcrtlang("no items found")."</span>";
}

echo "<span class=\"sizemesmaller\"><br>$scantime2";

if ($byuser != "") {
echo " ".pcrtlang("by")." $byuser";
}

echo "</span>";
echo "<br><a href=pc.php?func=rm_scan&scanid=$scanid&woid=$pcwo class=\"linkbuttontiny linkbuttongray removescan\"><i class=\"fa fa-trash\"></i> ".pcrtlang("remove")."</a>";

if ($scantype == "0") {
echo "<a href=pc.php?func=editcustominfo&scanid=$scanid&woid=$pcwo $therel class=\"linkbuttontiny linkbuttongray\"><i class=\"fa fa-edit\"></i> ".pcrtlang("edit custom scan")."</a>";
}

echo "</td></tr>";
$bgswitch++;
}
}


echo "</table><br>";

#############2
echo "<h4>&nbsp;<img src=images/actionicon.png border=0 align=absmiddle> ".pcrtlang("Actions")."&nbsp;</h4><br><table class=scanlist>";
$rs_foundscan1d = "SELECT * FROM pc_scan WHERE woid = '$pcwo' ORDER BY scantime ASC";
$rs_result_fs1d = mysqli_query($rs_connect, $rs_foundscan1d);
while($rs_result_fsr1d = mysqli_fetch_object($rs_result_fs1d)) {
$scanid1d = "$rs_result_fsr1d->scanid";
$scantype1d = "$rs_result_fsr1d->scantype";
$scannum1d = "$rs_result_fsr1d->scannum";
$scantime1d = "$rs_result_fsr1d->scantime";
$customprogname1d = "$rs_result_fsr1d->customprogname";
$customprintinfo1d = "$rs_result_fsr1d->customprintinfo";
$customscantype1d = "$rs_result_fsr1d->customscantype";
$byuser1d = "$rs_result_fsr1d->byuser";

if ($scantype1d != "0") {
$rs_foundscan_name1d = "SELECT * FROM pc_scans WHERE scanid = '$scantype1d'";
$rs_result_fs_name1d = mysqli_query($rs_connect, $rs_foundscan_name1d);
$rs_result_fsr_name1d = mysqli_fetch_object($rs_result_fs_name1d);
$scantypeid1d = "$rs_result_fsr_name1d->scanid";
$scantypeprogname1d = "$rs_result_fsr_name1d->progname";
$scantypeprintinfo1d = "$rs_result_fsr_name1d->printinfo";
$scantypeicon1d = "$rs_result_fsr_name1d->progicon";
$scantypetype1d = "$rs_result_fsr_name1d->scantype";
} else {
$scantypetype1d = $customscantype1d;
}



if (($scantypetype1d == 1) || ($customscantype1d == 1)) {
echo "<tr><td>";

if ($scantype1d == 0) {
echo "<img src=images/hand.png>";
} else {
echo "<img src=images/scans/$scantypeicon1d>";
}


echo "</td><td>";

if ($customprogname1d != "") {
echo "<a href=\"javascript:void(0)\" class=infotext>$customprogname1d<span>$customprintinfo1d</span></a>";
} else {
if ($customprintinfo1d == "") {
echo "<a href=\"javascript:void(0)\" class=infotext>$scantypeprogname1d<span>$scantypeprintinfo1d</span></a>";
} else {
echo "<a href=\"javascript:void(0)\" class=infotext>$scantypeprogname1d<span>$customprintinfo1d</span></a>";
}
}


if ($customprintinfo1d == "") {
$alreadycustom1d = 0;
} else {
$alreadycustom1d = 1;
}

if ($scannum1d != 0) {
echo " - <span class=\"colormered sizemesmaller\">$scannum1d ".pcrtlang("item(s) found")."</span>";
}
$scantime1d2 = pcrtdate("$pcrt_time", "$scantime1d")." ".pcrtdate("$pcrt_shortdate", "$scantime1d");

echo "<span class=\"sizemesmaller\"><br>$scantime1d2";

if ($byuser1d != "") {
echo " ".pcrtlang("by")." $byuser1d";
}

echo "</span>";
echo "<br><a href=pc.php?func=rm_scan&scanid=$scanid1d&woid=$pcwo class=\"linkbuttontiny linkbuttongray removescan\"><i class=\"fa fa-trash\"></i> ".pcrtlang("remove")."</a>";

if ($scantype1d != "0") {
echo "<a href=pc.php?func=custominfocreate&scanid=$scanid1d&scantypeid=$scantypeid1d&woid=$pcwo&alreadycustom=$alreadycustom1d $therel  class=\"linkbuttontiny linkbuttongray\"><i class=\"fa fa-edit\"></i> ".pcrtlang("customize printed info")."</a>";
}

if (($alreadycustom1d == "1") && ($scantype1d != "0")) {
echo "<a href=pc.php?func=custominforevert&scanid=$scanid1d&scantypeid=$scantypeid1d&woid=$pcwo&alreadycustom=$alreadycustom1d  class=\"linkbuttontiny linkbuttongray removescan\"><i class=\"fa fa-undo\"></i> ".pcrtlang("revert to default printed info")."</a>";
}

if ($scantype1d == "0") {
echo "<a href=pc.php?func=editcustominfo&scanid=$scanid1d&woid=$pcwo $therel  class=\"linkbuttontiny linkbuttongray\"><i class=\"fa fa-edit\"></i> ".pcrtlang("edit custom action")."</a>";
}


echo "</td></tr>";
}
}
echo "</table><br></td><td width=50% valign=top>";



###############3
echo "<h4>&nbsp;<img src=images/installicon.png border=0 align=absmiddle> ".pcrtlang("Installs")."&nbsp;</h4><table class=scanlist>";
$rs_foundscan2d = "SELECT * FROM pc_scan WHERE woid = '$pcwo' ORDER BY scantime ASC";
$rs_result_fs2d = mysqli_query($rs_connect, $rs_foundscan2d);
while($rs_result_fsr2d = mysqli_fetch_object($rs_result_fs2d)) {
$scanid2d = "$rs_result_fsr2d->scanid";
$scantype2d = "$rs_result_fsr2d->scantype";
$scannum2d = "$rs_result_fsr2d->scannum";
$scantime2d = "$rs_result_fsr2d->scantime";
$customprogname2d = "$rs_result_fsr2d->customprogname";
$customprintinfo2d = "$rs_result_fsr2d->customprintinfo";
$customscantype2d = "$rs_result_fsr2d->customscantype";
$byuser2d = "$rs_result_fsr2d->byuser";

$rs_foundscan_name2d = "SELECT * FROM pc_scans WHERE scanid = '$scantype2d'";
$rs_result_fs_name2d = mysqli_query($rs_connect, $rs_foundscan_name2d);
if ($scantype2d != "0") {
$rs_result_fsr_name2d = mysqli_fetch_object($rs_result_fs_name2d);
$scantypeid2d = "$rs_result_fsr_name2d->scanid";
$scantypeprogname2d = "$rs_result_fsr_name2d->progname";
$scantypeprintinfo2d = "$rs_result_fsr_name2d->printinfo";
$scantypeicon2d = "$rs_result_fsr_name2d->progicon";
$scantypetype2d = "$rs_result_fsr_name2d->scantype";
} else {
$scantypetype2d = $customscantype2d;
}

if (($scantypetype2d == 2) || ($customscantype2d == 2)) {
echo "<tr><td>";

if ($scantype2d == 0) {
echo "<img src=images/hand.png>";
} else {
echo "<img src=images/scans/$scantypeicon2d>";
}


echo "</td><td>";

if ($customprogname2d != "") {
echo "<a href=\"javascript:void(0)\" class=infotext>$customprogname2d<span>$customprintinfo2d</span></a>";
} else {
if ($customprintinfo2d == "") {
echo "<a href=\"javascript:void(0)\" class=infotext>$scantypeprogname2d<span>$scantypeprintinfo2d</span></a>";
} else {
echo "<a href=\"javascript:void(0)\" class=infotext>$scantypeprogname2d<span>$customprintinfo2d</span></a>";
}
}


if ($customprintinfo2d == "") {
$alreadycustom2d = 0;
} else {
$alreadycustom2d = 1;
}

if ($scannum2d != 0) {
echo " - <span class=\"colormered sizemesmaller\">$scannum2d ".pcrtlang("item(s) found")."</span>";
}

$scantime1d2 = pcrtdate("$pcrt_time", "$scantime2d")." ".pcrtdate("$pcrt_shortdate", "$scantime2d");

echo "<span class=\"sizemesmaller\"><br>$scantime1d2";

if ($byuser2d != "") {
echo " ".pcrtlang("by")." $byuser2d";
}

echo "</span>";

echo "<br><a href=pc.php?func=rm_scan&scanid=$scanid2d&woid=$pcwo  class=\"linkbuttontiny linkbuttongray removescan\"><i class=\"fa fa-trash\"></i> ".pcrtlang("remove")."</a>";

if ($scantype2d != "0") {
echo "<a href=pc.php?func=custominfocreate&scanid=$scanid2d&scantypeid=$scantypeid2d&woid=$pcwo&alreadycustom=$alreadycustom2d $therel  class=\"linkbuttontiny linkbuttongray\"><i class=\"fa fa-edit\"></i> ".pcrtlang("customize printed info")."</a>";
}
if (($alreadycustom2d == "1") && ($scantype2d != "0")) {
echo "<a href=pc.php?func=custominforevert&scanid=$scanid2d&scantypeid=$scantypeid2d&woid=$pcwo&alreadycustom=$alreadycustom2d  class=\"linkbuttontiny linkbuttongray removescan\"><i class=\"fa fa-undo\"></i> ".pcrtlang("revert to default printed info")."</a>";
}

if ($scantype2d == "0") {
echo "<a href=pc.php?func=editcustominfo&scanid=$scanid2d&woid=$pcwo $therel  class=\"linkbuttontiny linkbuttongray\"><i class=\"fa fa-edit\"></i> ".pcrtlang("edit custom install")."</a>";
}

echo "</td></tr>";
}
}


echo "</table><br>";





###################4
echo "<h4>&nbsp;<img src=images/notesicon.png border=0 align=absmiddle> ".pcrtlang("Notes")."&nbsp;</h4><table class=scanlist>";
$rs_foundscan3d = "SELECT * FROM pc_scan WHERE woid = '$pcwo' ORDER BY scantime ASC";
$rs_result_fs3d  = mysqli_query($rs_connect, $rs_foundscan3d);
while($rs_result_fsr3d = mysqli_fetch_object($rs_result_fs3d)) {
$scanid3d = "$rs_result_fsr3d->scanid";
$scantype3d = "$rs_result_fsr3d->scantype";
$scannum3d = "$rs_result_fsr3d->scannum";
$scantime3d = "$rs_result_fsr3d->scantime";
$customprogname3d = "$rs_result_fsr3d->customprogname";
$customprintinfo3d = "$rs_result_fsr3d->customprintinfo";
$customscantype3d = "$rs_result_fsr3d->customscantype";
$byuser3d = "$rs_result_fsr3d->byuser";

$rs_foundscan_name3d = "SELECT * FROM pc_scans WHERE scanid = '$scantype3d'";
$rs_result_fs_name3d = mysqli_query($rs_connect, $rs_foundscan_name3d);

if ($scantype3d != "0") {
$rs_result_fsr_name3d = mysqli_fetch_object($rs_result_fs_name3d);
$scantypeid3d = "$rs_result_fsr_name3d->scanid";
$scantypeprogname3d = "$rs_result_fsr_name3d->progname";
$scantypeprintinfo3d = "$rs_result_fsr_name3d->printinfo";
$scantypeicon3d = "$rs_result_fsr_name3d->progicon";
$scantypetype3d = "$rs_result_fsr_name3d->scantype";
} else {
$scantypetype3d = $customscantype3d;
}


if (($scantypetype3d == 3) || ($customscantype3d == 3)){
echo "<tr><td>";

if ($scantype3d == 0) {
echo "<img src=images/hand.png>";
} else {
echo "<img src=images/scans/$scantypeicon3d>";
}

echo "</td><td>";

if ($customprogname3d != "") {
echo "<a href=\"javascript:void(0)\" class=infotext>$customprogname3d<span>$customprintinfo3d</span></a>";
} else {
if ($customprintinfo3d == "") {
echo "<a href=\"javascript:void(0)\" class=infotext>$scantypeprogname3d<span>$scantypeprintinfo3d</span></a>";
} else {
echo "<a href=\"javascript:void(0)\" class=infotext>$scantypeprogname3d<span>$customprintinfo3d</span></a>";
}
}


if ($customprintinfo3d == "") {
$alreadycustom3d = 0;
} else {
$alreadycustom3d = 1;
}


if ($scannum3d != 0) {
echo " - <span class=\"colormered sizemesmaller\">$scannum3d ".pcrtlang("item(s) found")."</span>";
}

$scantime1d3 = pcrtdate("$pcrt_time", "$scantime3d")." ".pcrtdate("$pcrt_shortdate", "$scantime3d");

echo "<span class=\"sizemesmaller\"><br>$scantime1d3";

if ($byuser3d != "") {
echo " ".pcrtlang("by")." $byuser3d";
}

echo "</span>";
echo "<br><a href=pc.php?func=rm_scan&scanid=$scanid3d&woid=$pcwo  class=\"linkbuttontiny linkbuttongray removescan\"><i class=\"fa fa-trash\"></i> ".pcrtlang("remove")."</a>";

if ($scantype3d != "0") {
echo "<a href=pc.php?func=custominfocreate&scanid=$scanid3d&scantypeid=$scantypeid3d&woid=$pcwo&alreadycustom=$alreadycustom3d $therel  class=\"linkbuttontiny linkbuttongray\"><i class=\"fa fa-edit\"></i> ".pcrtlang("customize printed info")."</a>";
}
if (($alreadycustom3d == "1") && ($scantype3d != "0")) {
echo "<a href=pc.php?func=custominforevert&scanid=$scanid3d&scantypeid=$scantypeid3d&woid=$pcwo&alreadycustom=$alreadycustom3d  class=\"linkbuttontiny linkbuttongray removescan\"><i class=\"fa fa-undo\"></i> ".pcrtlang("revert to default printed info")."</a>";
}

if ($scantype3d == "0") {
echo "<a href=pc.php?func=editcustominfo&scanid=$scanid3d&woid=$pcwo $therel  class=\"linkbuttontiny linkbuttongray\"><i class=\"fa fa-edit\"></i> ".pcrtlang("edit custom note")."</a>";
}

echo "</td></tr>";
}
}
echo "</table></td></tr></table><br>";




################### 


stop_box();
#################################################


?>




