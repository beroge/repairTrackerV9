<?php
                                                                                                    
/***************************************************************************
 *   copyright            : (C) 2012 PCRepairTracker.com
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


require_once("footer.php");
                                                                                                    
}


function add() {

if (array_key_exists('attachtowhat',$_REQUEST)) {
$attachtowhat = $_REQUEST['attachtowhat'];
}

if (!isset($attachtowhat)) {
die ("Unknown Attachment Type");
}

if (array_key_exists('pcid',$_REQUEST)) {
$pcid = $_REQUEST['pcid'];
} else {
$pcid = "0";
}

if (array_key_exists('woid',$_REQUEST)) {
$woid = $_REQUEST['woid'];
} else {
$woid = "0";
}

if (array_key_exists('pcwo',$_REQUEST)) {
$pcwo = $_REQUEST['pcwo'];
} else {
$pcwo = "0";
}


if (array_key_exists('groupid',$_REQUEST)) {
$groupid = $_REQUEST['groupid'];
} else {
$groupid = "0";
}

if (array_key_exists('doccatid',$_REQUEST)) {
$doccatid = $_REQUEST['doccatid'];
} else {
$doccatid = "0";
}

if (array_key_exists('scid',$_REQUEST)) {
$scid = $_REQUEST['scid'];
} else {
$scid = "0";
}


require("deps.php");

require_once("common.php");

require("dheader.php");

echo "<div data-role=\"header\" data-theme=\"b\"><h2>".pcrtlang("Upload Attachment")."</h2></div>";
echo "<div class=\"ui-content\" role=\"main\">";


$folderperms = mb_substr(sprintf('%o', fileperms('../attachments')), -3);

if($folderperms < "766") {
echo "<font class=textred12>".pcrtlang("It appears your attachment folder might not be writeable. You may not be able to upload attachments.")." $folderperms</font><br><br>";
}

$maxupload = ini_get('upload_max_filesize');



echo "<form action=attachment.php?func=add2 method=post enctype=\"multipart/form-data\" data-ajax=\"false\">";

echo pcrtlang("Title/Name").":<input type=text class=textbox name=attach_title>";

if ($attachtowhat == "techdoc") {
echo pcrtlang("Keywords").":<input type=text name=attach_keywords>";

echo pcrtlang("Category").":";





echo "<select name=techdoccatid data-native-menu=\"false\">";
$rs_findtdc = "SELECT * FROM techdocs ORDER BY techdoccatname ASC";
$rs_resultcs = mysqli_query($rs_connect, $rs_findtdc);
while($rs_result_qcs = mysqli_fetch_object($rs_resultcs)) {
$techdoccatid = "$rs_result_qcs->techdoccatid";
$techdoccatname = "$rs_result_qcs->techdoccatname";
echo "<option value=$techdoccatid>$techdoccatname</option>";
}
echo "</select>";




} else {
echo "<input type=hidden name=attach_keywords value=\"\"><input type=hidden name=techdoccatid value=\"0\">";
}


echo pcrtlang("File to Upload").":<input type=file name=attach><br>".pcrtlang("Max Filesize").": <font style=\"color:#ff0000;\">$maxupload</font>";
echo "<input type=hidden name=scid value=\"$scid\"><input type=hidden name=woid value=$woid><input type=hidden name=pcwo value=$pcwo><input type=hidden name=pcid value=$pcid><input type=hidden name=groupid value=$groupid>";
echo "<input type=hidden name=doccatid value=$doccatid><input type=hidden name=attachtowhat value=$attachtowhat>";
echo "<input type=submit class=button value=\"".pcrtlang("Upload Attachment")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Uploading Attachment")."...'; this.form.submit();\" data-theme=\"b\"></form>";

echo "</div>";
require_once("dfooter.php");

}






function add2() {

require("deps.php");
require_once("validate.php");
require("common.php");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}


$pcid = $_REQUEST['pcid'];
$woid = $_REQUEST['woid'];
$pcwo = $_REQUEST['pcwo'];
$groupid = $_REQUEST['groupid'];
$techdoccatid = $_REQUEST['techdoccatid'];
$attach_keywords = $_REQUEST['attach_keywords'];
$attach_title = $_REQUEST['attach_title'];
$scid = $_REQUEST['scid'];

$attachtowhat = $_REQUEST['attachtowhat'];

$origattachfilename = basename($_FILES['attach']['name']);

$attach_filename = time() . "_" . "$attachtowhat" . "_" . "$origattachfilename";


function validate_conn($v_filename) {
   return preg_match('/^[a-z0-9_-]+\.(jpg|png|gif|bin|doc|docx|pdf|xls|xlsx|ppt|pptx|odt|ods|odp|speccy|html|htm|txt|rtf|chm|ncd|csv|exe|xml|zip|rar|msi|wav|mp3)$/i', $v_filename) ? '1' : '0';
}



if (validate_conn($origattachfilename) == '0') {
die(pcrtlang("File must be a allowed document type. File must not contain spaces or other special characters."));
}

$uploaddir = "../attachments/";
$uploadfile = "$uploaddir"."$attach_filename";
if (move_uploaded_file($_FILES['attach']['tmp_name'], $uploadfile)) {
} else {
    echo "Possible file upload attack!\n";
}






$attach_size = $_FILES['attach']['size'];

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$thenow = date('Y-m-d H:i:s');


$rs_insert_pic = "INSERT INTO attachments (attach_title,attach_keywords,attach_filename,attach_size,pcid,woid,groupid,attach_cat,attach_date) VALUES ('$attach_title','$attach_keywords','$attach_filename','$attach_size','$pcid','$woid','$groupid','$techdoccatid','$thenow')";
@mysqli_query($rs_connect, $rs_insert_pic);

if ($attachtowhat == "woid") {
userlog(26,$woid,'woid','');
header("Location: index.php?pcwo=$pcwo");
} elseif ($attachtowhat == "pcid") {
userlog(26,$pcid,'pcid','');
if ($pcwo != 0) {
header("Location: index.php?pcwo=$pcwo");
} else {
header("Location: pc.php?func=showpc&pcid=$pcid");
}
} elseif ($attachtowhat == "groupid") {
userlog(26,$groupid,'groupid','');
header("Location: group.php?func=viewgroup&pcgroupid=$groupid");
} elseif ($attachtowhat == "scid") {
header("Location: msp.php?func=viewservicecontract&scid=$scid");
} elseif ($attachtowhat == "techdoc") {
header("Location: pc.php?func=frameit");
} else {
header("Location: index.php");
}

}


function deleteattach() {

require("deps.php");
require("common.php");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
} 

$attachfilename = $_REQUEST['attachfilename'];
$attach_id = $_REQUEST['attach_id'];

if($attachfilename == "") {
die("No File name specified");
}

if($attach_id == "") {
die("No Attachment ID");
}


if (array_key_exists('pcid',$_REQUEST)) {
$pcid = $_REQUEST['pcid'];
} else {
$pcid = "0";
}

if (array_key_exists('woid',$_REQUEST)) {
$woid = $_REQUEST['woid'];
} else {
$woid = "0";
}

if (array_key_exists('pcwo',$_REQUEST)) {
$pcwo = $_REQUEST['pcwo'];
} else {
$pcwo = "0";
}


if (array_key_exists('groupid',$_REQUEST)) {
$groupid = $_REQUEST['groupid'];
} else {
$groupid = "0";
}

if (array_key_exists('techdoccatid',$_REQUEST)) {
$techdoccatid = $_REQUEST['techdoccatid'];
} else {
$techdoccatid = "0";
}

if (array_key_exists('scid',$_REQUEST)) {
$scid = $_REQUEST['scid'];
} else {
$scid = "0";
}


require_once("validate.php");




$rs_set_p = "DELETE FROM attachments WHERE attach_id = '$attach_id'";
@mysqli_query($rs_connect, $rs_set_p);

if(!filter_var($attach_filename, FILTER_VALIDATE_URL)) {
if (file_exists("../attachments/$attachfilename")) {
unlink("../attachments/$attachfilename");
}
}

if($woid != '0') {
header("Location: index.php?pcwo=$woid");
} elseif ($pcwo != '0') {
header("Location: index.php?pcwo=$woid");
} elseif ($pcid != '0') {
header("Location: pc.php?func=showpc&pcid=$pcid");
} elseif ($groupid != '0')	{
header("Location: group.php?func=viewgroup&pcgroupid=$groupid");
} elseif ($techdoccatid != '0')     {
header("Location: attachment.php?func=showdocs");
} elseif ($scid != '0') {
header("Location: msp.php?func=viewservicecontract&scid=$scid");
} else {
die("Unknown Attachment Location");
}


}


function editattach() {

$attach_id = $_REQUEST['attach_id'];

require_once("common.php");
require("dheader.php");


require("deps.php");

if (array_key_exists('pcid',$_REQUEST)) {
$pcid = $_REQUEST['pcid'];
} else {
$pcid = "0";
}

if (array_key_exists('woid',$_REQUEST)) {
$woid = $_REQUEST['woid'];
} else {
$woid = "0";
}

if (array_key_exists('pcwo',$_REQUEST)) {
$pcwo = $_REQUEST['pcwo'];
} else {
$pcwo = "0";
}


if (array_key_exists('groupid',$_REQUEST)) {
$groupid = $_REQUEST['groupid'];
} else {
$groupid = "0";
}

if (array_key_exists('techdoccatid',$_REQUEST)) {
$techdoccatid = $_REQUEST['techdoccatid'];
} else {
$techdoccatid = "0";
}

if (array_key_exists('scid',$_REQUEST)) {
$scid = $_REQUEST['scid'];
} else {
$scid = "0";
}



$rs_foundattach = "SELECT * FROM attachments WHERE attach_id = '$attach_id'";
$rs_result_fs = mysqli_query($rs_connect, $rs_foundattach);
$rs_result_fsr = mysqli_fetch_object($rs_result_fs);
$attach_title = "$rs_result_fsr->attach_title";
$attach_keywords = "$rs_result_fsr->attach_keywords";
$attach_cat = "$rs_result_fsr->attach_cat";

$boxtitle = pcrtlang("Edit Attachment");

echo "<div data-role=\"header\" data-theme=\"b\"><h2>$boxtitle</h2></div>";
echo "<div class=\"ui-content\" role=\"main\">";


echo "<form action=attachment.php?func=editattach2 method=post data-ajax=\"false\">";



echo pcrtlang("Attachment Title").":";
echo "<input type=hidden name=attach_id class=textbox value=$attach_id><input type=text name=attach_title value=\"$attach_title\">";

if ($techdoccatid != '0') {

echo pcrtlang("Category").":";

echo "<select name=techdoccatid data-native-menu=\"false\">";
$rs_findtdc = "SELECT * FROM techdocs ORDER BY techdoccatname ASC";
$rs_resultcs = mysqli_query($rs_connect, $rs_findtdc);
while($rs_result_qcs = mysqli_fetch_object($rs_resultcs)) {
$techdoccatid2 = "$rs_result_qcs->techdoccatid";
$techdoccatname = "$rs_result_qcs->techdoccatname";
if ($attach_cat == $techdoccatid2) {
echo "<option selected value=$techdoccatid2>$techdoccatname</option>";
} else {
echo "<option value=$techdoccatid2>$techdoccatname</option>";
}
}
echo "</select>";



echo pcrtlang("Attachment Keywords").":";
echo "<input type=text name=attach_keywords value=\"$attach_keywords\">";
}

echo "<input type=hidden name=scid value=\"$scid\"><input type=hidden name=pcid value=\"$pcid\"><input type=hidden name=woid value=\"$woid\"><input type=hidden name=pcwo value=\"$pcwo\"><input type=hidden name=groupid value=\"$groupid\"><input data-theme=\"b\" type=submit value=\"".pcrtlang("Save")."\">";


echo "</form>";
echo "</div>";
require_once("dfooter.php");



} 


function editattach2() {

require("deps.php");
require("common.php");

$attach_title = pv($_REQUEST['attach_title']);
$attach_keywords = pv($_REQUEST['attach_keywords']);
$attach_id = pv($_REQUEST['attach_id']);

if (array_key_exists('pcid',$_REQUEST)) {
$pcid = $_REQUEST['pcid'];
} else {
$pcid = "0";
}

if (array_key_exists('woid',$_REQUEST)) {
$woid = $_REQUEST['woid'];
} else {
$woid = "0";
}

if (array_key_exists('pcwo',$_REQUEST)) {
$pcwo = $_REQUEST['pcwo'];
} else {
$pcwo = "0";
}


if (array_key_exists('groupid',$_REQUEST)) {
$groupid = $_REQUEST['groupid'];
} else {
$groupid = "0";
}

if (array_key_exists('techdoccatid',$_REQUEST)) {
$techdoccatid = $_REQUEST['techdoccatid'];
} else {
$techdoccatid = "0";
}

if (array_key_exists('scid',$_REQUEST)) {
$scid = $_REQUEST['scid'];
} else {
$scid = "0";
}


require_once("validate.php");




$rs_update_attach = "UPDATE attachments SET attach_title = '$attach_title', attach_keywords = '$attach_keywords', attach_cat = '$techdoccatid' WHERE attach_id = '$attach_id'";
@mysqli_query($rs_connect, $rs_update_attach);

if($woid != '0') {
header("Location: index.php?pcwo=$woid");
} elseif ($pcwo != '0') {
header("Location: index.php?pcwo=$woid");
} elseif ($pcid != '0') {
header("Location: pc.php?func=showpc&pcid=$pcid");
} elseif ($groupid != '0')	{
header("Location: group.php?func=viewgroup&pcgroupid=$groupid");
} elseif ($scid != '0') {
header("Location: msp.php?func=viewservicecontract&scid=$scid");
} elseif ($techdoccatid != '0')     {
header("Location: pc.php?func=frameit");
} else {
die("Unkown Attachment Location");
}


}



function get() {

require("deps.php");
require("common.php");

$attach_id = $_REQUEST['attach_id'];




$rs_findfileid = "SELECT * FROM attachments WHERE attach_id = '$attach_id'";
$rs_resultfid = mysqli_query($rs_connect, $rs_findfileid);
$rs_result_qfid = mysqli_fetch_object($rs_resultfid);
$attach_filename = "$rs_result_qfid->attach_filename";

$rs_update_attach = "UPDATE attachments SET attach_dcount = attach_dcount+1 WHERE attach_id = '$attach_id'";
@mysqli_query($rs_connect, $rs_update_attach);

$pathinfo = pathinfo("$attach_filename");

$ext = mb_strtolower($pathinfo['extension']);

$inlinefiles = array("gif" => "image/gif","jpg" => "image/jpg","jpeg" => "image/jpg","png" => "image/png","htm" => "text/html","html" => "text/html","txt" => "text/plain","speccy" => "text/plain");
$specialfiles = array("pdf" => "application/pdf");


if (array_key_exists("$ext", $inlinefiles)) {
header("Content-Type: $inlinefiles[$ext]; Content-Disposition: inline; filename=\"$attach_filename\"");
readfile("../attachments/$attach_filename");
} elseif (array_key_exists("$ext", $specialfiles)) {
header("Content-Type: $specialfiles[$ext]; Content-Disposition: attachment; filename=\"$attach_filename\"");
readfile("../attachments/$attach_filename");
} else {
header("Content-Disposition: attachment; filename=\"$attach_filename\"");
readfile("../attachments/$attach_filename");
}


}


function search() {

$searchterm = $_REQUEST['searchterm'];

require_once("common.php");
require("header.php");

require("deps.php");

if ($gomodal == 1) {
$therel = "rel=facebox";
} else {
$therel = "";
}


start_box();
echo "<table style=\"width:100%\"><tr><td>";
echo "<font class=text16heading>".pcrtlang("Technical Documents")."</font>";
echo "</td><td>";
echo "<br><img src=images/attachment.png align=absmiddle> <a href=attachment.php?func=add&attachtowhat=techdoc $therel>".pcrtlang("Attach New Document")."</a><br><br><img src=images/attachments.png align=absmiddle> <a href=pc.php?func=frameit>".pcrtlang("View All Tech Docs")."</a><br><br>";

echo "</td><td>";

echo "<form action=attachment.php?func=search method=post><input type=text class=textbox name=searchterm size=20 required=required value=\"$searchterm\"><input type=submit value=\"".pcrtlang("Search")."\" class=button></form>";
echo "</td></tr></table>";
stop_box();
echo "<br>";

$boxfill = pcrtlang("Searched for").": $searchterm";

start_blue_box("$boxfill");

echo "<table>";



$rs_find_techdocs = "SELECT * FROM attachments WHERE attach_cat != '0' AND attach_keywords LIKE '%$searchterm%' OR attach_title LIKE '%$searchterm%' ORDER BY attach_title ASC";
$rs_result_td = mysqli_query($rs_connect, $rs_find_techdocs);

$totaldocsincat = mysqli_num_rows($rs_result_td);

while($rs_result_qtd = mysqli_fetch_object($rs_result_td)) {
$attach_id = "$rs_result_qtd->attach_id";
$attach_title = "$rs_result_qtd->attach_title";
$attach_size = "$rs_result_qtd->attach_size";
$attach_filename = "$rs_result_qtd->attach_filename";
$attach_dcount = "$rs_result_qtd->attach_dcount";
$techdoccatid = "$rs_result_qtd->attach_cat";
$fileextpc = mb_strtolower(mb_substr(mb_strrchr($attach_filename, "."), 1));

$thebytes = formatBytes($attach_size);

$attach_filename_ue = urlencode($attach_filename);

echo "<tr><td style=\"text-align:right\"><font class=attachext style=\"border-right: 7px solid #0000FF\">$fileextpc</font></td><td>";
echo "<a href=attachment.php?func=get&dfile=$attach_filename_ue&attach_id=$attach_id>$attach_title</a><br><font class=text10b>".pcrtlang("Size").": </font><font class=text10>$thebytes</font>&nbsp;&nbsp;";
echo "<font class=text10b>".pcrtlang("Downloads").": </font><font class=text10>$attach_dcount</font>";
echo "&nbsp;&nbsp;<a href=\"attachment.php?func=editattach&techdoccatid=$techdoccatid&attach_id=$attach_id\" class=smalllink $therel>".pcrtlang("edit")."</a> <font class=text10>/</font> ";
echo "<a href=\"attachment.php?func=deleteattach&techdoccatid=$techdoccatid&attach_id=$attach_id&attachfilename=$attach_filename\" class=smalllink onClick=\"return confirm('".pcrtlang("Are you sure you wish to permanently delete this Attachment!!!?")."');\">".pcrtlang("delete")."</a></td></tr>";
}

echo "</table>";

stop_blue_box();

require_once("footer.php");

}



function moveattach() {

require("deps.php");
require("common.php");

$attach_id = pv($_REQUEST['attach_id']);

$pcid = $_REQUEST['pcid'];
$woid = $_REQUEST['woid'];
$moveto = $_REQUEST['moveto'];

require_once("validate.php");





if ($moveto == "wo") {
$rs_update_attach = "UPDATE attachments SET pcid = '0', woid = '$woid' WHERE attach_id = '$attach_id'";
} else {
$rs_update_attach = "UPDATE attachments SET pcid = '$pcid', woid = '0' WHERE attach_id = '$attach_id'";
}


@mysqli_query($rs_connect, $rs_update_attach);

header("Location: index.php?pcwo=$woid");


}





switch($func) {
                                                                                                    
    default:
    nothing();
    break;
                                
    case "add":
    add();
    break;

    case "add2":
    add2();
    break;

   case "deleteattach":
    deleteattach();
    break;

  case "editattach":
    editattach();
    break;

  case "editattach2":
    editattach2();
    break;

 case "get":
    get();
    break;

 case "search":
    search();
    break;

 case "moveattach":
    moveattach();
    break;
                                   

}

?>
