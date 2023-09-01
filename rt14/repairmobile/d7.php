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

echo "<table class=standard><tr><th>";
echo pcrtlang("Attach Single d7 Report");
echo "</th></tr><tr><td>";


if (file_exists($d7_report_upload_directory)) {

echo "<form action=d7.php?func=move method=post enctype=\"multipart/form-data\" data-ajax=\"false\">";






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
echo "</select>";

$filesd7 = scandir($d7_report_upload_directory);


function validate_zipfile2($v_filename) {
   return preg_match('/^[a-z0-9_ -\.]+\.(zipfile|zip)$/i', $v_filename) ? '1' : '0';
}


echo "<select name=filename>";
echo "<option value=\"\">".pcrtlang("Choose File").":</option>";
foreach($filesd7 as $key => $val) {
if (validate_file($val) == '1') {

$attach_size = formatBytes(filesize("$d7_report_upload_directory"."$val"));
$attach_date = date("F d Y H:i:s", filemtime("$d7_report_upload_directory"."$val"));

echo "<option value=\"$val\">$val &bull; $attach_date &bull; $attach_size</option>";
}
}
echo "</select>";
echo "<input type=submit class=button value=\"".pcrtlang("Attach d7 Report")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Attaching d7 Report")."...'; this.form.submit();\" data-theme=\"b\"></form>";

} else {

echo "<font class=text12>".pcrtlang("Error: Sorry, the d7 folder you have configured is not present or readable.")."</font>";

}

echo "</td></tr></table>";

echo "<br><br>";


if (file_exists($d7_report_upload_directory)) {

###########################


echo "<table class=standard><tr><th colspan=2>".pcrtlang("Transfer Multiple d7 Reports.....")."</th></tr>";

echo "<form action=d7.php?func=multipled7 method=post data-ajax=\"false\">";
reset($filesd7);

foreach($filesd7 as $key => $val) {
if (validate_file($val) == '1') {
$attach_size = formatBytes(filesize("$d7_report_upload_directory"."$val"));
$attach_date = date("F d Y H:i", filemtime("$d7_report_upload_directory"."$val"));
$filename_ue = urlencode("$val");

$dropext = explode(".", $val);
if(is_numeric("$dropext[0]")) {
$pcidmatch = $dropext[0];
} else {
$dropext2 = explode("_", $val);
if(is_numeric("$dropext2[0]")) {
$pcidmatch = $dropext2[0];
} else {
$pcidmatch = "0";
}
}

if($pcidmatch != 0) {

$rs_findowner = "SELECT * FROM pc_owner WHERE pcid = '$pcidmatch'";
$rs_result2sr = mysqli_query($rs_connect, $rs_findowner);
while($rs_result_q2sr = mysqli_fetch_object($rs_result2sr)) {
$pcname = "$rs_result_q2sr->pcname";
$pcmake = "$rs_result_q2sr->pcmake";

$filesfound2 = "yes";

echo "<tr><th>".pcrtlang("Filename")."</td><td><label><input type=checkbox name=\"filenames[]\" value=\"$filename_ue\" checked>";
echo "$val</label></td></tr>";

echo "<tr><td>".pcrtlang("Target PC")."</td><td>$pcname ".pcrtlang("PC")."</td></tr>";
echo "<tr><td>".pcrtlang("Target Make")."</td><td>$pcidmatch $pcmake</td></tr>";

echo "<tr><td>".pcrtlang("File Last Modified")."</td><td>$attach_date </td></tr>";
echo "<tr><td>".pcrtlang("File Size")."</td><td>$attach_size</td></tr>";

}
}
}
}
echo "</table>";

if(!isset($filesfound2)) {
echo pcrtlang("No files with identifiable PCIDs found").".";
} else {
echo "<input type=submit value=\"".pcrtlang("Attach d7 Reports")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Attaching d7 Reports")."...'; this.form.submit();\" data-theme=\"b\">";
}

echo "</form>";


echo "<br><br>";

#############################

echo "<table class=standard><tr><th>".pcrtlang("Delete Report ZIP Files.....")."</th></tr>";

reset($filesd7);

foreach($filesd7 as $key => $val) {
if (validate_file($val) == '1') {
$attach_size = formatBytes(filesize("$d7_report_upload_directory"."$val"));
$attach_date = date("F d Y H:i", filemtime("$d7_report_upload_directory"."$val"));
$filename_ue = urlencode("$val");
echo "<tr><th><a href=\"d7.php?func=del&filename=$filename_ue\"  data-ajax=\"false\"  class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" onClick=\"return confirm('".pcrtlang("Are you sure you wish to permanently delete this file?").": $val');\"> <i class=\"fa fa-times\"></i> $val</th><tr><tr><td>$attach_date</td></tr><tr><td>$attach_size</td></tr>";
$filesfound = "yes";
}
}
echo "</table>";

if(!isset($filesfound)) {
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font class=textgray12i>".pcrtlang("No files found").".</font>";
}



echo "<br><br>";



# end d7 dir exists if
}


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
if (rename("$d7_report_upload_directory"."$filename", "$uploadfile")) {
} else {
    echo "Unable to move file!\n";
}


$attach_size = filesize("$uploadfile");

$filename2 = time()."_"."$filename";

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$thenow = date('Y-m-d H:i:s');



$rs_insert_pic = "INSERT INTO attachments (attach_title,attach_filename,attach_size,pcid,woid,attach_date) VALUES ('".pcrtlang("d7 Report")."','$filename2','$attach_size','$pcid','0','$thenow')";
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

unlink("$d7_report_upload_directory"."$filename");

header("Location: d7.php");

}



function multipled7() {

require("deps.php");
require_once("validate.php");
require("common.php");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}


$filenames = $_REQUEST['filenames'];

foreach($filenames as $key => $filename) {

$dropext = explode(".", $filename);
if(is_numeric("$dropext[0]")) {
$pcidmatch = $dropext[0];
} else {
$dropext2 = explode("_", $filename);
if(is_numeric("$dropext2[0]")) {
$pcidmatch = $dropext2[0];
} else {
$pcidmatch = "0";
}
}


$uploaddir = "../attachments/";
$uploadfile = "$uploaddir".time()."_"."$filename";
if (rename("$d7_report_upload_directory"."$filename", "$uploadfile")) {
} else {
    echo "Unable to move file!\n";
}

$filename2 = time()."_"."$filename";

$attach_size = filesize("$uploadfile");
if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$thenow = date('Y-m-d H:i:s');


$rs_insert_pic = "INSERT INTO attachments (attach_title,attach_filename,attach_size,pcid,woid,attach_date) VALUES ('".pcrtlang("d7 Report")."','$filename2','$attach_size','$pcidmatch','0','$thenow')";
@mysqli_query($rs_connect, $rs_insert_pic);


userlog(26,$pcidmatch,'pcid','');

}

header("Location: d7.php");



}


function zipit() {

require("deps.php");
require_once("validate.php");
require("common.php");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}


$filename = $_REQUEST['filename'];
$folder = $_REQUEST['folder'];

require("zip.php");

Zip("$d7_report_upload_directory/$folder/", "$d7_report_upload_directory/$filename");

header("Location: d7.php");

}

function read() {

require("deps.php");
require_once("validate.php");
require("common.php");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}


$filename = $_REQUEST['filename'];

$zipres = zip_open("$d7_report_upload_directory/$filename");

while ($zipres2 = zip_read($zipres)) {
$fileentry = zip_entry_name($zipres2);
if($fileentry == "info_report.html") {

$filesize = zip_entry_filesize($zipres2);

$filecont = zip_entry_read($zipres2, $filesize);

$valuestopull = array("cpu" => "CPU String:","ram" => "RAM:","os" => " OS:","productkey" => "Product Key:","serial" => "Serial#:",
"videocard" => "Video Card:","partition" => "Partition Space:");


foreach($valuestopull as $key => $val) {
$startpos = strpos($filecont, "$val");
$rest = substr("$filecont", $startpos);
$endpos = strpos($rest, "\r\n");
$rest2 = substr("$rest", 0, "$endpos"); 
$specarray = explode(":", $rest2);
$spec = $specarray[1];

if (strlen($spec) < 100) {
echo "$key: $spec<br>";
$specarrayreturn[$key] = "$spec";
}

}
}
}

print_r($specarrayreturn);


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

    case "multipled7":
    multipled7();
    break;

    case "zipit":
    zipit();
    break;

    case "read":
    read();
    break;


}

?>
