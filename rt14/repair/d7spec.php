<?php

function pullspec($filename) {

require("deps.php");
require_once("validate.php");
require_once("common.php");


if (!function_exists('zip_open'))  {
echo "<div style=\"border: #ff0000 2px solid; background:#FFBCBC; color:#ff0000; margin: 20px; padding:20px;\">";
echo "
Sorry you server does not have support for opening zip files. Please see your administrator about adding support for the php zip functions
";
echo "</div>";
exit;
}

$zipres = zip_open("../attachments/$filename");

function validate_zipfile($v_filename) {
   return preg_match('/^[a-z0-9_ -\.]+\.(zipfile|zip)$/i', $v_filename) ? '1' : '0';
}

if (validate_zipfile($filename) == '1') {

while ($zipres2 = zip_read($zipres)) {
$fileentry = zip_entry_name($zipres2);
if(($fileentry == "info_report.html") || ($fileentry == "Info_Report.html") || ($fileentry == "Info Report.html") || ($fileentry == "info report.html")) {

$filesize = zip_entry_filesize($zipres2);

$filecont = zip_entry_read($zipres2, $filesize);

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


foreach($valuestopull as $key => $val) {
$startpos = strpos($filecont, "$val");
$rest = substr("$filecont", $startpos);
$endpos = strpos($rest, "\r\n");
$rest2 = substr("$rest", 0, "$endpos");
$specarray = explode(":", $rest2, 2);
$spec = trim($specarray[1]);

if (strlen($spec) < 100) {
if("$spec" != "System Serial Number") {
$specarrayreturn[$key] = "$spec";
}

if("$key" == "installedon") {
$specio = explode("-", $spec);
$specarrayreturn[$key] = "$specio[0]";
}

}


}

}

}

zip_close($zipres);

}

if(!isset($specarrayreturn)) {
$specarrayreturn = array();
}
return $specarrayreturn;

}



function pullactivity($filename) {

require("deps.php");
require_once("validate.php");
require_once("common.php");


if (!function_exists('zip_open'))  {
echo "<div style=\"border: #ff0000 2px solid; background:#FFBCBC; color:#ff0000; margin: 20px; padding:20px;\">";
echo "
Sorry you server does not have support for opening zip files. Please see your administrator about adding support for the php zip functions
";
echo "</div>";
exit;
}

$zipres = zip_open("../attachments/$filename");

function validate_zipfile($v_filename) {
   return preg_match('/^[a-z0-9_ -\.]+\.(zipfile|zip)$/i', $v_filename) ? '1' : '0';
}

if (validate_zipfile($filename) == '1') {

while ($zipres2 = zip_read($zipres)) {
$fileentry = zip_entry_name($zipres2);
if(($fileentry == "activity_log.html") || ($fileentry == "Activity_Log.html") || ($fileentry == "activitylog.html") || ($fileentry == "ActivityLog.html")  || ($fileentry == "work report.html")  || ($fileentry == "Work Report.html")) {

$filesize = zip_entry_filesize($zipres2);

$filecont = zip_entry_read($zipres2, $filesize);


$startpos = strpos($filecont, "<hr>") + 4;
$rest = substr("$filecont", $startpos);
$endpos = strpos($rest, "<hr>");
$logbodycut = substr("$rest", 0, "$endpos");

$logbodystring = str_replace("<pre>", "", "$logbodycut");
$logbodystring = str_replace("</pre>", "", "$logbodystring");
$logbodyarray = explode("\r\n", $logbodystring);
$logbody = "";
$logbodyfiltered = array_filter($logbodyarray);
foreach($logbodyfiltered as $key => $val) {
if ((!preg_match("/-- St/i", "$val")) && (!preg_match("/ReportGenerated/i", "$val"))){
$logbody .= "$val\n";
}
}

break;

}
}

zip_close($zipres);

} 

if(!isset($logbody)) {
$logbody = "";
}


return $logbody;

}





?>
