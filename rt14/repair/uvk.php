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


function view() {

require("deps.php");

require_once("common.php");

require("header.php");

start_blue_box(pcrtlang("Attach UVK Report"));

if (file_exists($uvk_report_upload_directory)) {

echo "<form action=uvk.php?func=move method=post enctype=\"multipart/form-data\">";
echo "<table>";

echo "<tr><td>".pcrtlang("Choose Open Work Order").":</td><td>";






echo "<select name=openworkorders>";
echo "<option value=\"\">".pcrtlang("Choose Work Order").":</option>";
$rs_findtdc = "SELECT * FROM pc_wo WHERE pcstatus != '5' AND pcstatus != '7' ORDER BY pcid ASC";
$rs_resultcs = mysqli_query($rs_connect, $rs_findtdc);
while($rs_result_qcs = mysqli_fetch_object($rs_resultcs)) {
$woid = "$rs_result_qcs->woid";
$pcid = "$rs_result_qcs->pcid";

$rs_findowner = "SELECT * FROM pc_owner WHERE pcid = '$pcid'";
$rs_result2sr = mysqli_query($rs_connect, $rs_findowner);
$rs_result_q2sr = mysqli_fetch_object($rs_result2sr);
$pcname = "$rs_result_q2sr->pcname";
$pcmake = "$rs_result_q2sr->pcmake";



echo "<option value=$woid>".pcrtlang("PC")."$pcid &bull; ".pcrtlang("WO")."$woid &bull; $pcname &bull; $pcmake</option>";
}
echo "</select></td></tr>";

$filesuvk = scandir($uvk_report_upload_directory);

function validate_file($v_filename) {
   return preg_match('/^[a-z0-9_ -\.]+\.(pdf|html|htm|txt|rtf|csv|gz|tar|zip)$/i', $v_filename) ? '1' : '0';
}


echo "<tr><td>".pcrtlang("File to Attach").":</td><td>";
echo "<select name=filename>";
echo "<option value=\"\">".pcrtlang("Choose File").":</option>";
foreach($filesuvk as $key => $val) {
if (validate_file("$val") == '1') {

$attach_size = formatBytes(filesize("$uvk_report_upload_directory"."$val"));
$attach_date = date("F d Y H:i:s", filemtime("$uvk_report_upload_directory"."$val"));

echo "<option value=\"$val\">$val &bull; $attach_date &bull; $attach_size</option>";
}
}
echo "</select></td></tr>";
echo "<tr><td>&nbsp;</td><td><input type=submit class=button value=\"".pcrtlang("Attach UVK Report")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Attaching UVK Report")."...'; this.form.submit();\"></form></td></tr>";
echo "</table>";

} else {

echo pcrtlang("Error: Sorry, the UVK folder you have configured is not present or readable.");

}

stop_blue_box();

echo "<br><br>";



#############################

start_blue_box(pcrtlang("Delete Report ZIP Files....."));

echo "<table>";
echo "<tr><td>&nbsp;</td><td>".pcrtlang("Filename")."&nbsp;&nbsp;&nbsp;</td><td>".pcrtlang("File Last Modified")."
&nbsp;&nbsp;&nbsp;</td><td>".pcrtlang("Filesize")."</td></tr>";
reset($filesuvk);

foreach($filesuvk as $key => $val) {
if (validate_file($val) == '1') {
$attach_size = formatBytes(filesize("$uvk_report_upload_directory"."$val"));
$attach_date = date("F d Y H:i", filemtime("$uvk_report_upload_directory"."$val"));
$filename_ue = urlencode("$val");
echo "<tr><td><a href=\"uvk.php?func=del&filename=$filename_ue\" onClick=\"return confirm('".pcrtlang("Are you sure you wish to permanently delete this file?").": $val');\"><img src=\"images/del.png\" class=imagelink style=\"width:16px;\"></a></td><td>$val&nbsp;&nbsp;&nbsp;&nbsp;</td><td>$attach_date&nbsp;&nbsp;&nbsp;&nbsp;</td><td>$attach_size</td></tr>";
$filesfound = "yes";
}
}
echo "</table>";

if(!isset($filesfound)) {
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class=\"colormegray italme\">".pcrtlang("No files found").".</span>";
}

stop_blue_box();



require_once("footer.php");

}






function move() {

require("deps.php");
require_once("validate.php");
require("common.php");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}


$woid = $_REQUEST['openworkorders'];
$filename = $_REQUEST['filename'];

if($filename == "") {
die("Error: No filename selected.");
}






$rs_findtdc = "SELECT pcid FROM pc_wo WHERE woid = '$woid'";
$rs_resultcs = mysqli_query($rs_connect, $rs_findtdc);
$rs_result_qcs = mysqli_fetch_object($rs_resultcs);
$pcid = "$rs_result_qcs->pcid";




$uploaddir = "../attachments/";
$uploadfile = "$uploaddir".time()."_"."$filename";
if (rename("$uvk_report_upload_directory"."$filename", "$uploadfile")) {
} else {
    echo "Unable to move file!\n";
}


$attach_size = filesize("$uploadfile");

$filename2 = time()."_"."$filename";

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$thenow = date('Y-m-d H:i:s');



$rs_insert_pic = "INSERT INTO attachments (attach_title,attach_filename,attach_size,pcid,woid,attach_date) VALUES ('".pcrtlang("UVK Report")."','$filename2','$attach_size','$pcid','0','$thenow')";
@mysqli_query($rs_connect, $rs_insert_pic);


userlog(26,$pcid,'pcid','');
header("Location: index.php?pcwo=$woid");

}

function del() {

require("deps.php");
require_once("validate.php");
require("common.php");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}

$filename = $_REQUEST['filename'];

if($filename == "") {
die("Error: No filename selected.");
}

unlink("$uvk_report_upload_directory"."$filename");

header("Location: uvk.php");

}


function readsystemreport() {

require("deps.php");
require_once("validate.php");
require("common.php");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}


$filename = $_REQUEST['filename'];

$zipres = zip_open("../attachments/$filename");

while ($zipres2 = zip_read($zipres)) {
$fileentry = zip_entry_name($zipres2);
if($fileentry == "System Info.htm") {

$filesize = zip_entry_filesize($zipres2);

$filecont = zip_entry_read($zipres2, $filesize);


header("Content-Type: text/html; Content-Disposition: inline; filename=\"SystemInfoReport.html\"");
echo "$filecont";
}
}

}


function wouvklinks() {

require("deps.php");
require("common.php");

$filename = $_REQUEST['filename'];
$woid = $_REQUEST['woid'];
$pcid = $_REQUEST['pcid'];
$ue_filename = urlencode("$filename");

?>
  <script src="jq/facebox.js" type="text/javascript"></script>
  <script type="text/javascript">
    jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        loadingImage : 'jq/loading.gif',
        closeImage : 'jq/closelabel.png'
      })
    })
  </script>


<?php

if ($gomodal == 1) {
$therel = "rel=facebox";
} else {
$therel = "";
}

echo "<br>&nbsp;&nbsp;&nbsp;<span class=\"linkbuttonsmall linkbuttongraylabel radiusleft\">".pcrtlang("UVK").": </span><a href=\"uvk.php?func=readsystemreport&filename=$filename\" class=\"linkbuttonsmall linkbuttongray\">".pcrtlang("system info")."</a>";
echo "<a href=\"pc.php?func=editowner&woid=$woid&pcid=$pcid&attach_filenameuvk=$ue_filename\" class=\"linkbuttonsmall linkbuttongray radiusright\" $therel>".pcrtlang("import specs")."</a>";

}


switch($func) {
                                                                                                    
    default:
    view();
    break;
                                
    case "move":
    move();
    break;

    case "del":
    del();
    break;

    case "readsystemreport":
    readsystemreport();
    break;

    case "wouvklinks":
    wouvklinks();
    break;


}


