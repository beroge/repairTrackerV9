<?php 

/***************************************************************************
 *   copyright            : (C) 2015 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/

require("validate2.php");
require("common.php");

$pcwo = $_REQUEST['pcwo'];
$addystring = $_REQUEST['addystring'];
$pcmake = $_REQUEST['pcmake'];
$pcstatus = $_REQUEST['pcstatus'];
$mainassettypeidindb = $_REQUEST['mainassettypeidindb'];
$custompcinfoindb = unserialize($_REQUEST['custompcinfoindb']);
$pcid = $_REQUEST['pcid'];

#######################
$mainassettype = getassettypename($mainassettypeidindb);
start_status_box("$pcstatus","$mainassettype: $pcmake");

echo "<table class=standard>";


$rs_allfindassets = "SELECT * FROM mainassetinfofields";
$rs_result2all = mysqli_query($rs_connect, $rs_allfindassets);
while ($rs_result_q2all = mysqli_fetch_object($rs_result2all)) {
$mainassetfieldid = "$rs_result_q2all->mainassetfieldid";
$mainassetfieldname = "$rs_result_q2all->mainassetfieldname";
$allassetinfofields[$mainassetfieldid] = "$mainassetfieldname";
}

$custompcinfoindb = array_filter($custompcinfoindb);

foreach($custompcinfoindb as $key => $val) {
if(array_key_exists("$key", $allassetinfofields)) {
echo "<tr><th>$allassetinfofields[$key]:</th><td>$val</td></tr>";
}

}

echo "</td></tr></table>";



if (!empty($custassetsindb)) {
echo "<br><table class=standard><tr><th>".pcrtlang("Accessory Assets").":</th></tr>";
foreach($custassetsindb as $key => $val) {

if (!array_key_exists("$val", $custassets)) {
echo "<tr><td><img src=../repair/images/admin.png border=0 align=absmiddle class=assetimage> $val</td></tr>";
} else {
echo "<tr><td><img src=../repair/images/assets/$custassets[$val] border=0 align=absmiddle> $val</td><tr>";
}
}
echo "</table>";
}

$rs_assetphotos = "SELECT * FROM assetphotos WHERE pcid = '$pcid'";
$rs_result_aset = mysqli_query($rs_connect, $rs_assetphotos);


$totalassetphotos = mysqli_num_rows($rs_result_aset);

if ($totalassetphotos != "0") {

echo "<br><center>";

while($rs_result_aset2 = mysqli_fetch_object($rs_result_aset)) {
$photofilename = "$rs_result_aset2->photofilename";
$assetphotoid = "$rs_result_aset2->assetphotoid";
$highlight = "$rs_result_aset2->highlight";

echo "<a href=\"pc.php?func=getpcimage&photoid=$assetphotoid\"><img src=\"pc.php?func=getpcimage&photoid=$assetphotoid\" width=200></a>";



echo "<a href=\"#popupdeleteap$assetphotoid\" data-rel=\"popup\" data-position-to=\"window\" data-transition=\"pop\" class=\"ui-btn ui-shadow ui-corner-all\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("delete")."</a>";
echo "<div data-role=\"popup\" id=\"popupdeleteap$assetphotoid\" data-overlay-theme=\"b\"  data-theme=\"a\" data-dismissible=\"false\">";
echo "<div data-role=\"header\" data-theme=\"b\">";
echo "<h1>".pcrtlang("Delete Photo")."?</h1>";
echo "</div>";
echo "<div role=\"main\" class=\"ui-content\">";
echo "<p>".pcrtlang("Are you sure you wish to permanently delete this photo?")."</p>";
echo "<img src=\"pc.php?func=getpcimage&photoid=$assetphotoid\" width=100>";
echo "<div align=\"right\"><a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\" data-inline=\"true\"><i class=\"fa fa-ban fa-lg\"></i> Cancel</a>";
echo "<button onClick=\"parent.location='pc.php?func=removephoto&woid=$pcwo&pcid=$pcid&photoid=$assetphotoid&photofilename=$photofilename'\" data-inline=\"true\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")." </button></div>";
echo "</div>";
echo "</div>";



if ($highlight == "0") {
echo "<button type=button style=\"padding:2px;\" onClick=\"parent.location='pc.php?func=highlightphoto&woid=$pcwo&pcid=$pcid&photoid=$assetphotoid'\">".pcrtlang("highlight")."</button>";
} else {
echo pcrtlang("highlighted")."<button type=button style=\"padding:2px;\" onClick=\"parent.location='pc.php?func=remhighlightphoto&woid=$pcwo&pcid=$pcid&photoid=$assetphotoid'\">".pcrtlang("remove highlight")."</button>";
}

echo "<br><br>";

}

echo "</center>";

}

echo "<button type=button onClick=\"parent.location='pc.php?func=addassetphoto&pcid=$pcid&woid=$pcwo'\" data-theme=\"b\"><i class=\"fa fa-camera fa-lg\"></i> ".pcrtlang("Upload Asset Photos")."</button>";




?>
