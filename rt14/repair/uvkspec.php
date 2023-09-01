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
   return preg_match('/^[a-z0-9_-]+\.(zipfile|zip)$/i', $v_filename) ? '1' : '0';
}

if (validate_zipfile($filename) == '1') {

while ($zipres2 = zip_read($zipres)) {
$fileentry = zip_entry_name($zipres2);
if(($fileentry == "SystemInfo.ini") || ($fileentry == "systeminfo.ini")) {

$filesize = zip_entry_filesize($zipres2);

$filecont = zip_entry_read($zipres2, $filesize);

$valuestopull = array(
"model" => "Computer=",
"motherboard" => "Motherboard=",
"bios" => "Bios=",
"ram" => "Total physical memory=",
"operatingsystem" => "Operating system=",
"windowsproductkey" => "Windows product key=",
"serial" => "Serial and SNID/Service tag=",
"partition" => "Local Disk (C:)=",
"computername" => "PC Info=",
"cpu" => "PC owner info="
);

$valuestopull2 = array(
"cpu" => "[Processors]",
"networkinterfacecard" => "[Network adapters]",
"ipaddress" => "[Internet connection and external IP]",
"antivirus" => "[Security software and settings]",
"videocard" => "[Video adapters]"
);


$filecont = mb_convert_encoding("$filecont", "UTF-8", "UCS-2LE");


function parse_ini_string_m($str) {
   
    if(empty($str)) return false;

    $lines = explode("\n", $str);
    $ret = Array();
    $inside_section = false;

    foreach($lines as $line) {
       
        $line = trim($line);

        if(!$line || $line[0] == "#" || $line[0] == ";") continue;
       
        if($line[0] == "[" && $endIdx = strpos($line, "]")){
            $inside_section = substr($line, 1, $endIdx-1);
            continue;
        }

        if(!strpos($line, '=')) continue;

        $tmp = explode("=", $line, 2);

        if($inside_section) {
           
            $key = rtrim($tmp[0]);
            $value = ltrim($tmp[1]);

            if(preg_match("/^\".*\"$/", $value) || preg_match("/^'.*'$/", $value)) {
                $value = mb_substr($value, 1, mb_strlen($value) - 2);
            }

            $t = preg_match("^\[(.*?)\]^", $key, $matches);
            if(!empty($matches) && isset($matches[0])) {

                $arr_name = preg_replace('#\[(.*?)\]#is', '', $key);

                if(!isset($ret[$inside_section][$arr_name]) || !is_array($ret[$inside_section][$arr_name])) {
                    $ret[$inside_section][$arr_name] = array();
                }

                if(isset($matches[1]) && !empty($matches[1])) {
                    $ret[$inside_section][$arr_name][$matches[1]] = $value;
                } else {
                    $ret[$inside_section][$arr_name][] = $value;
                }

            } else {
                $ret[$inside_section][trim($tmp[0])] = $value;
            }           

        } else {
           
            $ret[trim($tmp[0])] = ltrim($tmp[1]);

        }
    }
    return $ret;
}


####


foreach($valuestopull as $key => $val) {
if (strpos($filecont, $val) !== false) {
$startpos = strpos($filecont, $val);
$rest = substr("$filecont", $startpos);
$endpos = strpos($rest, "\r\n");
$rest2 = substr("$rest", 0, "$endpos");
$specarray = explode("=", $rest2, 2);
$spec = trim($specarray[1]);
$specarrayreturn[$key] = "$spec";
}
}

foreach($valuestopull2 as $key => $val) {
if (strpos($filecont, $val) !== false) {
$startpos = strpos($filecont, $val);
$rest = substr("$filecont", $startpos);
$endpos = strpos($rest, "[");
$endpos2 = strpos($rest, "[", $endpos + strlen("["));
$rest2 = substr("$rest", 0, "$endpos2");
$specarray = explode("]", $rest2, 2);
$spec = trim($specarray[1]);
$spec = str_replace("\r\n", " &bull; ", "$spec");
$specarrayreturn[$key] = "$spec";
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




?>
