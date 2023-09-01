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

start_blue_box(pcrtlang("Attach Single d7 Report"));

if (file_exists($d7_report_upload_directory)) {

echo "<form action=d7.php?func=move method=post enctype=\"multipart/form-data\">";
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

$filesd7 = scandir($d7_report_upload_directory);

function validate_file($v_filename) {
   return preg_match('/^[a-z0-9_ -\.]+\.(pdf|html|htm|txt|rtf|csv|gz|tar|zip)$/i', $v_filename) ? '1' : '0';
}


echo "<tr><td>".pcrtlang("File to Attach").":</td><td>";
echo "<select name=filename>";
echo "<option value=\"\">".pcrtlang("Choose File").":</option>";
foreach($filesd7 as $key => $val) {
if (validate_file($val) == '1') {

$attach_size = formatBytes(filesize("$d7_report_upload_directory"."$val"));
$attach_date = date("F d Y H:i:s", filemtime("$d7_report_upload_directory"."$val"));

echo "<option value=\"$val\">$val &bull; $attach_date &bull; $attach_size</option>";
}
}
echo "</select></td></tr>";
echo "<tr><td>&nbsp;</td><td><input type=submit class=button value=\"".pcrtlang("Attach d7 Report")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Attaching d7 Report")."...'; this.form.submit();\"></form></td></tr>";
echo "</table>";

} else {

echo pcrtlang("Error: Sorry, the d7 folder you have configured is not present or readable.");

}

stop_blue_box();

echo "<br><br>";


if (file_exists($d7_report_upload_directory)) {

###########################


start_blue_box(pcrtlang("Transfer Multiple d7 Reports....."));

echo "<table>";
echo "<tr><td><form action=d7.php?func=multipled7 method=post> &nbsp;</td><td><span class=boldme>".pcrtlang("Filename")."</span>&nbsp;&nbsp;&nbsp;</td><td><span class=\"boldme underlineme\">".pcrtlang("Target PC ID")."</span>&nbsp;&nbsp;&nbsp;</td>";
echo "<td><span class=\"boldme underlineme\">".pcrtlang("File Last Modified")."</span>&nbsp;&nbsp;&nbsp;</td><td><span class=\"boldme underlineme\">".pcrtlang("Filesize")."</span></td></tr>";
reset($filesd7);

foreach($filesd7 as $key => $val) {
if (validate_file("$val") == '1') {
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

echo "<tr><td style=\"vertical-align:top;\"><input type=checkbox name=\"filenames[]\" value=\"$filename_ue\" checked>";
echo "</td><td style=\"vertical-align:top;\"><span class=\"boldme\">$val</span>&nbsp;&nbsp;&nbsp;&nbsp;</td>";

echo "<td style=\"vertical-align:top;\"><span class=\"boldme\">$pcname</span>&nbsp;&nbsp;&nbsp;&nbsp;<br>".pcrtlang("Asset/Device").": $pcidmatch<br><span class=\"sizemesmaller\">$pcmake</span></td>";

echo "<td style=\"vertical-align:top;\">$attach_date&nbsp;&nbsp;&nbsp;&nbsp;</td><td style=\"vertical-align:top;\">$attach_size</td></tr>";

}
}
}
}
echo "</table>";

if(!isset($filesfound2)) {
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class=\"colormegray italme\">".pcrtlang("No files with identifiable Asset IDs found").".</span>";
} else {
echo "<input type=submit class=button value=\"".pcrtlang("Attach d7 Reports")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Attaching d7 Reports")."...'; this.form.submit();\">";
}

echo "</form>";

stop_blue_box();

echo "<br><br>";

#############################

start_blue_box(pcrtlang("Delete Report ZIP Files....."));

echo "<table>";
echo "<tr><td>&nbsp;</td><td><span class=\"boldme underlineme\">".pcrtlang("Filename")."</span>&nbsp;&nbsp;&nbsp;</td><td><span class=\"boldme underlineme\">".pcrtlang("File Last Modified")."</span>
&nbsp;&nbsp;&nbsp;</td><td><span class=\"boldme underlineme\">".pcrtlang("Filesize")."</span></td></tr>";
reset($filesd7);

foreach($filesd7 as $key => $val) {
if (validate_file($val) == '1') {
$attach_size = formatBytes(filesize("$d7_report_upload_directory"."$val"));
$attach_date = date("F d Y H:i", filemtime("$d7_report_upload_directory"."$val"));
$filename_ue = urlencode("$val");
echo "<tr><td><a href=\"d7.php?func=del&filename=$filename_ue\" onClick=\"return confirm('".pcrtlang("Are you sure you wish to permanently delete this file?").": $val');\"><img src=\"images/del.png\" class=imagelink style=\"width:16px;\"></a></td><td><span class=\"boldme\">$val</span>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>$attach_date&nbsp;&nbsp;&nbsp;&nbsp;</td><td>$attach_size</td></tr>";
$filesfound = "yes";
}
}
echo "</table>";

if(!isset($filesfound)) {
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class=\"colormegray italme\">".pcrtlang("No files found").".</span>";
}

stop_blue_box();


echo "<br><br>";

#start_blue_box(pcrtlang("Zip Report Files....."));

#$dird7 = scandir($d7_report_upload_directory);

#$d7dir = "$d7_report_upload_directory";

#echo "<table>";
#echo "<tr><td>&nbsp;</td><td><span class=\"boldme underlineme\">".pcrtlang("Report Folder")."</span>&nbsp;&nbsp;&nbsp;</td><td></td><td><span class=\"boldme underlineme\">".pcrtlang("ZIP Filename")."</span></td></tr>";


#foreach(glob($d7dir.'*', GLOB_ONLYDIR) as $rpdir) {
#    $rpdir = str_replace($d7dir, '', $rpdir);
#    $maindir[] = "$rpdir";
#
#
#while (list($key, $maindir2) = each($maindir)) {
#$newmain = "$d7dir/$maindir2/";
#	foreach(glob("$newmain".'*', GLOB_ONLYDIR) as $rpsubdir) {
#    	$rpsubdir = str_replace("$d7dir/", '', $rpsubdir);
#$folderpcs = explode("/", $rpsubdir);
#$folderpcs[1] = str_replace(" ", '_', $folderpcs[1]);
#$thetime = time();
#$zipname = "$folderpcs[1]_$folderpcs[0]_$thetime.zip";
#$filesfound3 = "yes";
#    	echo "<tr><td><a href=\"d7.php?func=zipit&filename=$zipname&folder=".urlencode($rpsubdir)."\"><img src=\"../store/images/restock.png\" class=imagelink style=\"width:16px;\"></a> </td><td> $rpsubdir </td><td>  </td><td> <span class=\"boldme\">$zipname</span></td></tr>";
#	}
#}
#
#}
#
#
#
#echo "</table>";
#
#if(!isset($filesfound3)) {
#echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".pcrtlang("No files found");
#}
#
#
#stop_box();
#



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
