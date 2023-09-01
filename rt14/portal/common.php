<?php

/***************************************************************************
 *   copyright            : (C) 2017 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/

require_once("deps.php");
require_once("validate2.php");


#########################################################

function buildlangblob() {
require("deps.php");
$findstring = "SELECT languagestring,basestring FROM languages WHERE language = '$mypcrtlanguage'";
$findstringq = @mysqli_query($rs_connect, $findstring);
$langblobmain = array();
while ($rs_result_qs = mysqli_fetch_object($findstringq)) {
$langstring = "$rs_result_qs->languagestring";
$basestring = "$rs_result_qs->basestring";
$langblobmain[$basestring] = $langstring;
}
return $langblobmain;
}

function pcrtlang($string) {
require("deps.php");
static $langblobmain = false;
if(!$langblobmain) {
$langblob = buildlangblob();
$langblobmain = $langblob;
}
if (array_key_exists($string, $langblobmain)) {
return $langblobmain[$string];
} else {
$safestring = pv($string);
$addstring = "INSERT INTO languages (language,languagestring,basestring) VALUES ('$mypcrtlanguage','$safestring','$safestring')";
@mysqli_query($rs_connect, $addstring);
$langblobmain[$string] = $string;
return "$string";
}
}


########################################################


function adjustBrightness($hex, $steps) {
    // Steps should be between -255 and 255. Negative = darker, positive = lighter
    $steps = max(-255, min(255, $steps));

    // Normalize into a six character long hex string
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
    }

    // Split into three parts: R, G and B
    $color_parts = str_split($hex, 2);
    $return = '#';

    foreach ($color_parts as $color) {
        $color   = hexdec($color); // Convert to decimal
        $color   = max(0,min(255,$color + $steps)); // Adjust color
        $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
    }

    return $return;
}



##



function getassettypename($mainassettypeid) {
require("deps.php");

$rs_findassettypes = "SELECT * FROM mainassettypes WHERE mainassettypeid = '$mainassettypeid'";
$rs_resultfat = mysqli_query($rs_connect, $rs_findassettypes);
$rs_result_qfat = mysqli_fetch_object($rs_resultfat);
$mainassetname = "$rs_result_qfat->mainassetname";
return $mainassetname;
}

function getassettypeshowscans($mainassettypeid) {
require("deps.php");

$rs_findassettypes = "SELECT * FROM mainassettypes WHERE mainassettypeid = '$mainassettypeid'";
$rs_resultfat = mysqli_query($rs_connect, $rs_findassettypes);
$rs_result_qfat = mysqli_fetch_object($rs_resultfat);
$mainassetshowscans = "$rs_result_qfat->showscans";
return $mainassetshowscans;
}





function getsalestaxrate($taxid) {
require("deps.php");
$findtaxsql = "SELECT * FROM taxes WHERE taxid = $taxid";
$findtaxq = @mysqli_query($rs_connect, $findtaxsql);
$findtaxa = mysqli_fetch_object($findtaxq);
$taxrate = "$findtaxa->taxrategoods";
return $taxrate;
}

function getservicetaxrate($taxid) {
require("deps.php");
$findtaxsql = "SELECT * FROM taxes WHERE taxid = $taxid";
$findtaxq = @mysqli_query($rs_connect, $findtaxsql);
$findtaxa = mysqli_fetch_object($findtaxq);
$taxrate = "$findtaxa->taxrateservice";
return $taxrate;
}

function gettaxname($taxid) {
require("deps.php");
$findtaxsql = "SELECT * FROM taxes WHERE taxid = $taxid";
$findtaxq = @mysqli_query($rs_connect, $findtaxsql);
$findtaxa = mysqli_fetch_object($findtaxq);
$taxname = "$findtaxa->taxname";
return $taxname;
}


function gettaxshortname($taxid) {
require("deps.php");

$findtaxsql = "SELECT * FROM taxes WHERE taxid = $taxid";
$findtaxq = @mysqli_query($rs_connect, $findtaxsql);
$findtaxa = mysqli_fetch_object($findtaxq);
$taxname = "$findtaxa->shortname";
return $taxname;
}




function getusertaxid() {
require("deps.php");
$usernamechk = $ipofpc;
$findtaxsql = "SELECT * FROM users WHERE username = '$usernamechk'";
$findtaxq = @mysqli_query($rs_connect, $findtaxsql);
$findtaxa = mysqli_fetch_object($findtaxq);
$usertaxid = "$findtaxa->currenttaxid";
return $usertaxid;
}



function isgrouprate($taxid) {
require("deps.php");

$findtaxgsql = "SELECT isgrouprate FROM taxes WHERE taxid = $taxid";
$findtaxgq = @mysqli_query($rs_connect, $findtaxgsql);
$findtaxga = mysqli_fetch_object($findtaxgq);
$isgrouprate = "$findtaxga->isgrouprate";
return $isgrouprate;
}

function getgrouprates($taxid) {
require("deps.php");

$findtaxgsql = "SELECT compositerate FROM taxes WHERE taxid = $taxid";
$findtaxgq = @mysqli_query($rs_connect, $findtaxgsql);
$findtaxga = mysqli_fetch_object($findtaxgq);
$compositerate2 = "$findtaxga->compositerate";
$compositerate = unserialize($compositerate2);
return $compositerate;
}



function pv($value) {
require("deps.php");
$value2 = trim($value);
   return mysqli_real_escape_string($rs_connect, $value2);
}

function pf($value) {
$value2 = trim($value);
   return htmlspecialchars($value2);
}


function pfnotrim($value) {
   return htmlspecialchars($value);
}

function dv($value) {
$value2 = trim($value);
return htmlspecialchars("$value2", ENT_QUOTES);
}


function mf($value) {
if(empty($value)) {
return "0.00";
} else {
return number_format($value, 2, '.', '');
}
}

function limf($pretax,$tax) {
require("deps.php");
if(empty($pretax)) {
$pretax = "0.00";
}
if(empty($tax)) {
$tax = "0.00";
}
if(isset($taxinclusive)){
if($taxinclusive == 1) {
$value = $pretax + $tax;
} else {
$value = $pretax;
}
} else {
$value = $pretax;
}
return number_format($value, 2, '.', '');
}


function mfexp($number) {
if(empty($number)) {
return "0.00";
} else {
        if (($number * pow(10 , 2 + 1) % 10 ) == 5)  //if next not significant digit is 5
            $number -= pow(10 , -(2+1));
       return number_format($number, 2, '.', '');
}
}


function qf($value) {
if(empty($value)) {
return "0";
} else {
return $value + 0;
}
}


function ii($value) {
if(($value % 1) == 0) {
return "true";
} else {
return "false";
}
}


function parseforlinks($text) {
  $text= preg_replace("/(^|[\n ])([\w]*?)((ht|f)tp(s)?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is", "$1$2<a href=\"$3\" >$3</a>", $text);
    $text= preg_replace("/(^|[\n ])([\w]*?)((www|ftp)\.[^ \,\"\t\n\r<]*)/is", "$1$2<a href=\"http://$3\" >$3</a>", $text);
    $text= preg_replace("/(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/i", "$1<a href=\"mailto:$2@$3\">$2@$3</a>", $text);
    return($text);

}




function get_paged_nav($num_results, $num_per_page=40, $show=false)
{
    // Set this value to true if you want all pages to be shown,
    // otherwise the page list will be shortened.
    $full_page_list = false;

    // Get the original URL from the server.
    $url = $_SERVER['REQUEST_URI'];

    // Initialize the output string.
    $output = '';

    // Remove query vars from the original URL.
    if(preg_match('#^([^\?]+)(.*)$#isu', $url, $regs))
        $url = $regs[1];

    // Shorten the get variable.
    $q = $_GET;

    // Determine which page we're on, or set to the first page.
    if(isset($q['pageNumber']) AND is_numeric($q['pageNumber'])) $page = $q['pageNumber'];
    else $page = 1;

    // Determine the total number of pages to be shown.
    $total_pages = ceil($num_results / $num_per_page);
    // Begin to loop through the pages creating the HTML code.
    for($i=1; $i<=$total_pages; $i++)
    {
        // Assign a new page number value to the pageNumber query variable.
        $q['pageNumber'] = $i;

        // Initialize a new array for storage of the query variables.
        $tmp = array();
        foreach($q as $key=>$value)
            $tmp[] = "$key=$value";

        // Create a new query string for the URL of the page to look at.
        $qvars = implode("&amp;", $tmp);

        // Create the new URL for this page.
        $new_url = $url . '?' . $qvars;

        // Determine whether or not we're looking at this page.
        if($i != $page)
        {
            // Determine whether or not the page is worth showing a link for.
            // Allows us to shorten the list of pages.
            if($full_page_list == true
            OR $i == $page-5
            OR $i == $page-4
            OR $i == $page-3
            OR $i == $page-2       
         OR $i == $page-1
                OR $i == $page+1
                OR $i == 1
                OR $i == $total_pages
                OR $i == floor($total_pages/2)
                OR $i == floor($total_pages/2)+1
           OR $i == floor($total_pages/2)+2
           OR $i == floor($total_pages/2)+3
           OR $i == floor($total_pages/2)+4
           OR $i == floor($total_pages/2)+5
                )
                {
                    $output .= "<a href='$new_url' class=\"btn btn-default\" role=button>$i</a> ";
                }
                else
                    $output .= '. ';
        }
        else
        {
            // This is the page we're looking at.
            $output .= "<span class=\"btn btn-primary disabled\">$i</span> ";
        }
    }

    // Remove extra dots from the list of pages, allowing it to be shortened.
#    $output = ereg_replace('(\. ){2,}', ' .. ', $output);
 $output = preg_replace('#(\. ){2,}#', ' .. ', $output); 
   // Determine whether to show the HTML, or just return it.
    if($show) echo $output;

    return($output);
}





function getstoreinfo($storetoget) {

include("deps.php");
$rs_ql = "SELECT * FROM stores WHERE storeid = '$storetoget'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$storesname = "$rs_result_q1->storesname";
$storename = "$rs_result_q1->storename";
$storeaddy1 = "$rs_result_q1->storeaddy1";
$storeaddy2 = "$rs_result_q1->storeaddy2";
$storecity = "$rs_result_q1->storecity";
$storestate = "$rs_result_q1->storestate";
$storezip = "$rs_result_q1->storezip";
$storeemail = "$rs_result_q1->storeemail";
$storeccemail = "$rs_result_q1->ccemail";
$storephone = "$rs_result_q1->storephone";
$quotefooter = "$rs_result_q1->quotefooter";
$invoicefooter = "$rs_result_q1->invoicefooter";
$repairsheetfooter = "$rs_result_q1->repairsheetfooter";
$returnpolicy = "$rs_result_q1->returnpolicy";
$depositfooter = "$rs_result_q1->depositfooter";
$thankyouletter = "$rs_result_q1->thankyouletter";
$claimticket = "$rs_result_q1->claimticket";
$checkoutreceipt = "$rs_result_q1->checkoutreceipt";
$linecolor1 = "$rs_result_q1->linecolor1";
$linecolor2 = "$rs_result_q1->linecolor2";
$bgcolor1 = "$rs_result_q1->bgcolor1";
$bgcolor2 = "$rs_result_q1->bgcolor2";
$storehash = "$rs_result_q1->storehash";


$interfacecolor1 = "$bgcolor1;";
$interfacecolor2 = "$bgcolor2;";

$linestyle = "background: #$linecolor2;
background: linear-gradient(to bottom, #$linecolor1 0%,#$linecolor2 100%);";


$storeinfo = array("storesname" => "$storesname", "storename" => "$storename", "storeaddy1" => "$storeaddy1", "storeaddy2" => "$storeaddy2", "storecity" => "$storecity", "storestate" => "$storestate", "storezip" => "$storezip", "storeemail" => "$storeemail", "storephone" => "$storephone", "quotefooter" => "$quotefooter", "invoicefooter" => "$invoicefooter", "repairsheetfooter" => "$repairsheetfooter", "returnpolicy" => "$returnpolicy", "depositfooter" => "$depositfooter", "thankyouletter" => "$thankyouletter", "claimticket" => "$claimticket", "checkoutreceipt" => "$checkoutreceipt", "interfacecolor1" => "$interfacecolor1", "interfacecolor2" => "$interfacecolor2", "linestyle" => "$linestyle", "storehash" => "$storehash","storeccemail" => "$storeccemail");
return $storeinfo;
}


function invoiceorquote($invoiceid) {
require("deps.php");
$rs_iorqq = "SELECT iorq FROM invoices WHERE invoice_id = $invoiceid";
$rs_result1 = mysqli_query($rs_connect, $rs_iorqq);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$iorq2 = "$rs_result_q1->iorq";
if ($iorq2 == "quote") {
$iorq = "quote";
} else {
$iorq = "invoice";
}
return $iorq;
}



function formatBytes($bytes, $precision = 1) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);

    $bytes /= pow(1024, $pow);

    return round($bytes, $precision) . ' ' . $units[$pow];
}


function trim_value(&$value)
{
    $value = trim($value);
}


function getboxstyle($statusid) {
require("deps.php");
$rs_qc = "SELECT * FROM boxstyles WHERE statusid = '$statusid'";
$rs_result1 = mysqli_query($rs_connect, $rs_qc);
$rs_result_q1 = mysqli_fetch_object($rs_result1);

$boxstyle = array();
$boxstyle['selectorcolor'] = "$rs_result_q1->selectorcolor";
$boxstyle['boxtitle'] = "$rs_result_q1->boxtitle";

return $boxstyle;

}

function getstatusselectorcolors() {
require("deps.php");
$rs_qc = "SELECT statusid,selectorcolor FROM boxstyles";
$rs_result1 = mysqli_query($rs_connect, $rs_qc);
$statusselectorcolors = array();
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$statusid = "$rs_result_q1->statusid";
$statuscolor = "$rs_result_q1->selectorcolor";
$statusselectorcolors[$statusid] = $statuscolor;

}
return $statusselectorcolors;

}

function getboxtitles() {
require("deps.php");
$rs_qc = "SELECT statusid,boxtitle FROM boxstyles";
$rs_result1 = mysqli_query($rs_connect, $rs_qc);
$boxtitles = array();
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$statusid = "$rs_result_q1->statusid";
$boxtitle = "$rs_result_q1->boxtitle";
$boxtitles[$statusid] = $boxtitle;

}
return $boxtitles;

}





function picktime($selectname,$pretime) {
echo "<select name=$selectname class=selecttimepicker>";
$hours = array(12,1,2,3,4,5,6,7,8,9,10,11);
$ampms = array('AM','PM');

if (preg_match('/AM/i', $pretime)) {
$amorpm = "AM";
} else {
$amorpm = "PM";
}

$gettime2 = explode(" ", $pretime);
$gettime = $gettime2[0];
$thehourarray = explode(":", $gettime);

$thehour = $thehourarray[0]; 
$theminute = $thehourarray[1];

foreach($ampms as $key => $ampm) {
foreach($hours as $key => $hour) {
if($pretime == "$hour:00 $ampm") {
echo "<option selected value=\"$hour:00 $ampm\" style=\"background:#cccccc;\">$hour:00 $ampm</option>";
} else {
echo "<option value=\"$hour:00 $ampm\" style=\"background:#cccccc;\">$hour:00 $ampm</option>";
}

if(("$amorpm" == "$ampm") && ($thehour == $hour) && (($theminute > 0) && ($theminute < 15))) {
echo "<option selected value=\"$pretime\" style=\"background:#ffcccc;\">$pretime</option>";
}

if($pretime == "$hour:15 $ampm") {
echo "<option selected value=\"$hour:15 $ampm\" class=selecttimepickeroption>$hour:15 $ampm</option>";
} else {
echo "<option value=\"$hour:15 $ampm\" class=selecttimepickeroption>$hour:15 $ampm</option>";
}

if(("$amorpm" == "$ampm") && ($thehour == $hour) && (($theminute > 15) && ($theminute < 30))) {
echo "<option selected value=\"$pretime\" style=\"background:#ffcccc;\">$pretime</option>";
}

if($pretime == "$hour:30 $ampm") {
echo "<option selected value=\"$hour:30 $ampm\" class=selecttimepickeroption>$hour:30 $ampm</option>";
} else {
echo "<option value=\"$hour:30 $ampm\" class=selecttimepickeroption>$hour:30 $ampm</option>";
}

if(("$amorpm" == "$ampm") && ($thehour == $hour) && (($theminute > 30) && ($theminute < 45))) {
echo "<option selected value=\"$pretime\" style=\"background:#ffcccc;\">$pretime</option>";
}


if($pretime == "$hour:45 $ampm") {
echo "<option selected value=\"$hour:45 $ampm\" class=selecttimepickeroption>$hour:45 $ampm</option>";
} else {
echo "<option value=\"$hour:45 $ampm\" class=selecttimepickeroption>$hour:45 $ampm</option>";
}

if(("$amorpm" == "$ampm") && ($thehour == $hour) && (($theminute > 45) && ($theminute <= 59))) {
echo "<option selected value=\"$pretime\" style=\"background:#ffcccc;\">$pretime</option>";
}

}
reset($hours);
}


echo "</select>";

}



function serializedarraytest($array) {
if ($array != "") {
$arrayout2 = unserialize($array);
if (is_array($arrayout2)) {
$arrayout = $arrayout2;
} else {
$arrayout = array();
}
} else {
$arrayout = array();
}

return $arrayout;
}




function pcrtdate($timestring,$timestamp) {

require("deps.php");
if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}


if(!is_numeric($timestamp)) {
$timestamp = strtotime($timestamp);
}

$dateconv = str_replace(
  array('FULL_MONTH_NAME','ABBR_MONTH_NAME','NUMERIC_MONTH_LEADING_ZERO','NUMERIC_MONTH_NO_LEADING_ZERO','NUMERIC_DAY_LEADING_ZERO','NUMERIC_DAY_NO_LEADING_ZERO', 'DAY_OF_WEEK_ABBR','DAY_OF_WEEK_FULL','ENGLISH_SUFFIX','4_DIGIT_YEAR','2_DIGIT_YEAR','24_HOURS_NO_LEADING_ZERO','24_HOURS_LEADING_ZERO','HOURS_NO_LEADING_ZERO','HOURS_LEADING_ZERO','MINUTES','SECONDS','AM_PM_LOWERCASE','AM_PM_UPPERCASE'),
  array(pcrtlang(date("F",$timestamp)),pcrtlang(date("M",$timestamp)),date("m",$timestamp),date("n",$timestamp),date("d",$timestamp),date("j",$timestamp),pcrtlang(date("D",$timestamp)),pcrtlang(date("l",$timestamp)),date("S",$timestamp),date("Y",$timestamp),date("y",$timestamp),date("G",$timestamp),date("H",$timestamp),date("g",$timestamp),date("h",$timestamp),date("i",$timestamp),date("s",$timestamp),date("a",$timestamp),date("A",$timestamp)),
  $timestring
);

return $dateconv;

}


function implode_list($value) {
if(is_array($value)) {
$newvalue = "_";
foreach($value as $key => $valueitem) {
$newvalue .= "$valueitem"."_";
}
} else {
$newvalue = "$value";
}
return $newvalue;
}

function explode_list($value) {
if (strpos($value, '_') === false) {
return array_filter(array($value));
} else {
return array_values(array_filter(explode("_", "$value")));
}
}


function addhttp($url) {
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://" . $url;
    }
    return $url;
}




function getfileicon($ext) {
if($ext == "zip") {
$icon = "<i class=\"fa fa-file-archive-o fa-lg\"></i>";
} elseif($ext == "doc") {
$icon = "<i class=\"fa fa-file-text-o fa-lg\"></i>";
} elseif($ext == "txt") {
$icon = "<i class=\"fa fa-file-archive-o fa-lg\"></i>";
} elseif($ext == "docx") {
$icon = "<i class=\"fa fa-file-word-o fa-lg\"></i>";
} elseif(($ext == "xls") || ($ext == "xlsx")) {
$icon = "<i class=\"fa fa-file-excel-o fa-lg\"></i>";
} elseif(($ext == "ppt") || ($ext == "pptx")) {
$icon = "<i class=\"fa fa-file-powerpoint-o fa-lg\"></i>";
} elseif($ext == "pdf") {
$icon = "<i class=\"fa fa-file-pdf-o fa-lg\"></i>";
} elseif(($ext == "mp3") || ($ext == "ogg") || ($ext == "wav") || ($ext == "wma")) {
$icon = "<i class=\"fa fa-file-audio-o fa-lg\"></i>";
} elseif(($ext == "mp4") || ($ext == "ogv") || ($ext == "flv") || ($ext == "wmv") || ($ext == "mov")) {
$icon = "<i class=\"fa fa-file-video-o fa-lg\"></i>";
} elseif(($ext == "gif") || ($ext == "jpg") || ($ext == "jpeg") || ($ext == "png") || ($ext == "bmp")) {
$icon = "<i class=\"fa fa-file-image-o fa-lg\"></i>";
} elseif($ext == "url") {
$icon = "<i class=\"fa fa-external-link fa-lg\"></i>";

} else {
$icon = "<i class=\"fa fa-file-o fa-lg\"></i>";
}

return $icon;
}


function printableheader($title) {

global $autoprint;

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php
echo "<title>$title</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../repair/printstyle.css\">";
echo "<link rel=\"stylesheet\" href=\"fa/css/font-awesome.min.css\">";
echo "<link rel=\"stylesheet\" href=\"fa/font-awesome-animation.min.css\">";
echo "</head>";

if (preg_match("/printform/i", $_SERVER['REQUEST_URI'])) {
require("signatureincludes.php");
}



if($autoprint == 1) {
echo "<body class=printpagebg onLoad=\"window.print()\">";
} else {
echo "<body class=printpagebg>";
}
echo "<div class=printbar>";
echo "<button onClick=\"window.history.back()\" class=bigbutton><img src=../repair/images/left.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Return")."</button>";
echo "<font class=text30b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>";
echo "<button onClick=\"print();\" class=bigbutton><img src=../repair/images/print.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Print")."</button>";
echo "</div>";
echo "<div class=printpage>";

}



function printablefooter() {
echo "</div>";
echo "</body></html>";
}


function checkssl() {
    if (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) === 'on') {
      return TRUE;
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
      return TRUE;
    } elseif (isset($_SERVER['HTTP_FRONT_END_HTTPS']) && $_SERVER['HTTP_FRONT_END_HTTPS'] === 'on') {
      return TRUE;
    }
    return FALSE;
}


function checkstorecount($stock_id) {
require("deps.php");

$rs_find_stores = "SELECT * FROM stores WHERE storeenabled = '1'";
$rs_result_stores = mysqli_query($rs_connect, $rs_find_stores);
        while($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
        $rs_storeid = "$rs_result_storeq->storeid";
        $rs_checkstockcounts = "SELECT * FROM stockcounts WHERE storeid = '$rs_storeid' AND stockid = '$stock_id'";
        $rs_result_sc = mysqli_query($rs_connect, $rs_checkstockcounts);
        $sc_result = mysqli_num_rows($rs_result_sc);
                if ($sc_result == 0) {
                $insertstore = "INSERT INTO stockcounts (stockid, storeid, quantity) VALUES ('$stock_id','$rs_storeid','0')";
                @mysqli_query($rs_connect, $insertstore);
                }
        }
}



function getourprice($stockid) {
require("deps.php");

$rs_qop = "SELECT inv_price FROM inventory WHERE stock_id = $stockid ORDER BY inv_date DESC LIMIT 1";
$rs_result1 = mysqli_query($rs_connect, $rs_qop);
$rs_result_q1 = mysqli_fetch_object($rs_result1);

$rs_qop2 = "SELECT avg_cost FROM stock WHERE stock_id = '$stockid'";
$rs_result2 = mysqli_query($rs_connect, $rs_qop2);
$rs_result_q2 = mysqli_fetch_object($rs_result2);

$avg_cost = "$rs_result_q2->avg_cost";
if ($avg_cost != "0") {
$ourprice = "$avg_cost";
} else {
$ourprice = "$rs_result_q1->inv_price";
}
return $ourprice;
}


function findreturnreceipts($receipt) {
require("deps.php");
$addit_idsa = array();
$find_r_receipts = "SELECT * FROM sold_items WHERE receipt = '$receipt' AND return_receipt != ''";
$rs_resultfrr = mysqli_query($rs_connect, $find_r_receipts);
while($rs_resultfrr_q = mysqli_fetch_object($rs_resultfrr)) {
$return_receipt = "$rs_resultfrr_q->return_receipt";
$addit_ids = explode_list($return_receipt);
$addit_idsa = array_merge($addit_idsa, $addit_ids);

if(count($addit_ids) != 0) {
foreach($addit_ids as $key => $receipt2) {
$moreids = findreturnreceipts($receipt2);
$addit_idsa = array_merge($moreids, $addit_idsa);
}
}

}
return $addit_idsa;
}

function tnv($value) {
if(!is_numeric($value)) {
return 0;	
} else {
return "$value";	
}
}
