<?php

/***************************************************************************
 *   copyright            : (C) 2018 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/

require_once("deps.php");


function start_blue_box($blue_title) {
        $boxstyle = getboxstyle(50);
        echo "<div class=colortitletopround style=\"background:#$boxstyle[selectorcolor]\"><span class=\"colormewhite sizemelarge textoutline boldme\">$blue_title</font></div><div class=whitebottom>";
}



function stop_blue_box() {
        echo "</div>\n";
}

function start_color_box($title,$color) {
        echo "<div class=\"colortitletopround_$color\">\n";
        echo "<span class=\"colormewhite boldme\">$title</span></div>\n";
        echo "<div class=whitebottom style=\"border-color: #$color;\">\n";
}

function start_color_boxnobottomround($title,$color) {
        echo "<div class=\"colortitletopround_$color\">\n";
        echo "<span class=\"colormewhite boldme\">$title</font></span>\n";
        echo "<div class=whitemiddle style=\"border-color: #$color;\">\n";
}

function start_color_boxnoround($title,$color) {
     	echo "<div class=\"colortitle_$color\">\n";
        echo "<span class=\"colormewhite boldme\">$title</span></div>\n";
        echo "<div class=whitebottom style=\"border-color: #$color;\">\n";
}

function stop_color_box() {
        echo "</div>\n";
}

function start_box() {
        echo "<div class=startbox>\n";
}

function start_box_nested() {
        echo "<div class=startbox_nested>\n";
}

function start_box_cb($bgcolor) {
        echo "<div style=\"background:#$bgcolor\" class=colorbox>\n";
}

function start_box_sn($bgcolor,$bgcolor2,$bordercolor) {
        echo "<div style=\"background:#$bgcolor; border:1px solid #$bordercolor; background: -moz-linear-gradient(top, #$bgcolor 0%, #$bgcolor2 100%); background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#$bgcolor), color-stop(100%,#$bgcolor2)); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#$bgcolor', endColorstr='#$bgcolor2',GradientType=0 );\" class=colorboxsn>\n";
}


function start_box_cb_nested($bgcolor) {
        echo "<div style=\"background:#$bgcolor\" class=colorbox_nested>\n";
}


function stop_box() {
        echo "</div>\n";
}



function employee_list() {
include("deps.php");


$rs_findpcs3 = "SELECT * FROM employees WHERE isactive = '1' ORDER BY employeename ASC";
$rs_result3 = mysqli_query($rs_connect, $rs_findpcs3);
start_blue_box("Employee List");
echo "<table>";
while($rs_result_q3 = mysqli_fetch_object($rs_result3)) {
$eid = "$rs_result_q3->employeeid";
$cn = "$rs_result_q3->clocknumber";
$ename = "$rs_result_q3->employeename";
$fulltime = "$rs_result_q3->fulltime";

echo "<tr><td align=right><span class=boldme>#$cn</span></td><td><a href=\"employee.php?func=viewemployee&eid=$eid&cn=$cn\">$ename</a></td></tr>";

}
echo "</table>";
stop_blue_box();


                                                                                                                                               
}

function td($time) {
    $timeArr = explode(':', $time);
    $dectime = ($timeArr['0']*60) + ($timeArr['1']) + ($timeArr['2']/3600);
    $dectime2 = ($dectime / 60);
    $dectime3 = number_format($dectime2, 2, '.', '');
    return "$dectime3";
}

function pv($value) {
include("deps.php");
   return mysqli_real_escape_string($rs_connect, $value);
}



$themasterperms = array(
"1" => pcrtlang("Edit Employees"),
"2" => pcrtlang("View Reports"),
"3" => pcrtlang("Manage Users"),
"4" => pcrtlang("View Reports for Inactive Employees"),
"5" => pcrtlang("Access Timeclock Admin Area"),
"6" => pcrtlang("Print Badges"),
"8" => pcrtlang("Manage Departments"),
"9" => pcrtlang("Manage Locations"),
"16" => pcrtlang("View Wage Info")
);





function perm_check($permid) {

include("deps.php");



$pcrt_select_parms_q = "SELECT timeclockperms FROM users WHERE username = '$ipofpc'";
$frc_result_parms = @mysqli_query($rs_connect, $pcrt_select_parms_q);

$parmsa = mysqli_fetch_array($frc_result_parms);
$frc_perms = "$parmsa[timeclockperms]";


if ($frc_perms != "") {
$theperms3 = unserialize($frc_perms);
} else {
$theperms3 = array();
}

if(is_array($theperms3)) {
$theperms = $theperms3;
} else {
$theperms = array();
}


if ("$ipofpc" == "admin") {
return true;
} else {
        if (in_array($permid, $theperms)) {
                return true;
        } else {
                return false;
        }
}
}




function showweek($showquery,$title,$sortorder,$showtotal) {
start_blue_box("$title");
require("deps.php");



echo "<table style=\"border-collapse:collapse\">";
echo "<tr><td><span class=boldme>".pcrtlang("Clock In (m/d/y)")."</span></td><td>&nbsp;&nbsp;</td>";
echo "<td><font class=text12b>".pcrtlang("Clock Out (m/d/y)")."</span></td><td>";
echo "<span class=\"colormegreen boldme\">".pcrtlang("Total Hours")."</span></td><td colspan=2></td></tr>";
$rs_times = "$showquery";
$rs_times1 = mysqli_query($rs_connect, $rs_times);
$prevday = "";
$previouspunchout = "0";
$previouspunchin = "0";
$totaltime = "0";
$a = 2;
while($rs_result_times1 = mysqli_fetch_object($rs_times1)) {
$punchid = "$rs_result_times1->punchid";
$punchstatus = "$rs_result_times1->punchstatus";
$punchin2 = "$rs_result_times1->punchin";
$punchout2 = "$rs_result_times1->punchout";
$totalhours2 = "$rs_result_times1->totalhours";
$medit = "$rs_result_times1->medit";
$editnote = "$rs_result_times1->editnote";
$punchtype = "$rs_result_times1->punchtype";
$punchtypeout = "$rs_result_times1->punchtypeout";

if(($a % 2) == 0) {
$rowcolor = "#ffffff";
} else {
$rowcolor = "#cccccc";
}

if($totalhours2 != "") {
$totalhours = td($totalhours2);
} else {
$totalhours = "";
}

if(!isset($pcrt_hours24)) {
$pcrt_hours24 = "12";
}

if($pcrt_hours24 == 12) {
$punchin = date("n/j/Y g:i A", strtotime($punchin2));
$punchout = date("n/j/Y g:i A", strtotime($punchout2));
} else {
$punchin = date("n/j/Y H:i", strtotime($punchin2));
$punchout = date("n/j/Y H:i", strtotime($punchout2));
}


$theday = date("l", strtotime($punchin2));

$currentpunchin = strtotime($punchin2);
$currentpunchout = strtotime($punchout2);

if ($sortorder == "asc") {
if((($currentpunchin - $previouspunchout) < 1200) && ($punchstatus != "in")) {
$break2 = (($currentpunchin - $previouspunchout) / 60);
$break =  number_format($break2, 1, '.', '');
echo "<tr><td colspan=7 style=\"background:#eeeeee; padding:10px;\">&nbsp;<i class=\"fa fa-coffee fa-lg\"></i> ".pcrtlang("Break Minutes").": $break";

if(perm_check("1")) {
echo " <a href=employee.php?func=removebreak&previouspunchid=$previouspunchid&punchid=$punchid class=\"linkbuttonsmall linkbuttonred radiusall\"><i class=\"fa fa-times fa-lg\"></i> ".pcrtlang("Remove Break")."</a>";
}
echo "</td></tr>";
}
} else {
if((($previouspunchin - $currentpunchout) < 1200) && ($punchstatus != "in") &&(($previouspunchin - $currentpunchout) > 0)) {
$break2 = (($previouspunchin - $currentpunchout) / 60);
$break =  number_format($break2, 1, '.', '');
echo "<tr><td colspan=7  style=\"background:#eeeeee; padding:10px;\">&nbsp;<i class=\"fa fa-coffee fa-lg\"></i> ".pcrtlang("Break Minutes").": $break";
if(perm_check("1")) {
echo " <a href=employee.php?func=removebreak&previouspunchid=$punchid&punchid=$previouspunchid class=\"linkbuttonsmall linkbuttonred radiusall\"><i class=\"fa fa-times fa-lg\"></i> ".pcrtlang("Remove Break")."</a>";
}
echo "</td></tr>";
}
}

if ("$prevday" != "$theday") {
echo "<tr><td colspan=7 style=\"background:#777777;padding:3px;\">&nbsp;<span class=\"boldme colormewhite\">&nbsp;$theday&nbsp;</span></td></tr>";
}


if ($punchstatus == "out") {
echo "<tr><td bgcolor=$rowcolor>";

if($punchtype == 1) {
echo "<span class=\"colormered boldme\"><i class=\"fa fa-hand-o-up fa-lg\"></i></span>";
} elseif($punchtype == 0) {
echo "<span class=\"boldme\"><i class=\"fa fa-credit-card fa-lg\"></i></span>";
} else {
echo "<span class=\"colormeblue boldme\"><i class=\"fa fa-edit fa-lg\"></i></span>";
}


if(perm_check("1")) {
echo "<form action=employee.php?func=edittime method=post style=\"display:inline;\"><input type=hidden name=punchid value=$punchid>";
echo "<input type=text name=punchin value=\"$punchin\" size=21 class=textbox>";
} else {
echo "$punchin";
}
echo "</td>";
echo "<td bgcolor=$rowcolor>&nbsp;&nbsp;</td>";
echo "<td bgcolor=$rowcolor>";

if($punchtypeout == 1) {
echo " <span class=\"colormered boldme\"><i class=\"fa fa-hand-o-up fa-lg\"></i></span>";
} elseif($punchtypeout == 0) {
echo " <span class=boldme><i class=\"fa fa-credit-card fa-lg\"></i></span>";
} else {
echo " <span class=\"colormeblue boldme\"><i class=\"fa fa-edit fa-lg\"></i></span>";
}

if(perm_check("1")) {
echo "<input type=text name=punchout value=\"$punchout\" size=21 class=textbox>";
} else {
echo "$punchout";
}

echo "</td>";
echo "<td style=\"text-align:right\" bgcolor=$rowcolor><span class=\"colormegreen boldme\">$totalhours</span>";
if ($medit != "") {
echo "<span class=\"colormered boldme\"> M</span>";
}

echo "</td><td bgcolor=$rowcolor>";
echo "</td><td bgcolor=$rowcolor>";
echo "</td></tr>";
if(perm_check("1")) {
echo "<tr><td bgcolor=$rowcolor colspan=4>".pcrtlang("Reason for Time Edit").": <input required=required type=text name=editnote class=textbox style=\"width:300px;\"></td>";
echo "<td bgcolor=$rowcolor><button type=submit class=button><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("Edit Time")."</button></form>";
echo "</td><td bgcolor=$rowcolor><form action=employee.php?func=deletetime method=post><input type=hidden name=punchid value=$punchid><button type=submit class=button><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete Time")."</button></form></td></tr>";
}

if($editnote != "") {
echo "<tr><td colspan=7><span class=\"colormered boldme\">$editnote</span></td></tr>";
}

$totaltime = $totaltime + $totalhours;
} else {
echo "<tr><td bgcolor=$rowcolor>";

if($punchtype == 1) {
echo " <span class=\"colormered boldme\"><i class=\"fa fa-hand-o-up fa-lg\"></i></span>";
} elseif($punchtype == 0) {
echo " <span class=boldme><i class=\"fa fa-credit-card fa-lg\"></i></span>";
} else {
echo " <span class=\"colormeblue boldme\"><i class=\"fa fa-edit fa-lg\"></i></span>";
}

if(perm_check("1")) {
echo "<form action=employee.php?func=editopentime method=post style=\"display:inline;\"><input type=hidden value=$punchid>";
}
if ($medit != "") {
echo "<span class=\"colormered boldme\">M</span>";
}
if(perm_check("1")) {
echo "<input type=text name=punchin value=\"$punchin\" size=21 class=textbox>";
} else {
echo "$punchin";
}

echo "</td>";
echo "<td bgcolor=$rowcolor>&nbsp;&nbsp;</td>";
echo "<td bgcolor=$rowcolor><span class=\"colormegreen boldme\">".pcrtlang("Currently Clocked In")."</span>";



echo "</td>";
echo "<td align=right bgcolor=$rowcolor></td><td bgcolor=$rowcolor>";
echo "</td><td bgcolor=$rowcolor colspan=2>";
echo "</td></tr>";

if(perm_check("1")) {
echo "<tr><td bgcolor=$rowcolor colspan=4>".pcrtlang("Reason for Time Edit").": <input required=required type=text name=editnote class=textbox style=\"width:300px;\"></td>";
echo "<td bgcolor=$rowcolor ><button type=submit class=button><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("Edit Time")."</button></form>";
echo "</td><td bgcolor=$rowcolor ><form action=employee.php?func=deletetime method=post><input type=hidden name=punchid value=$punchid><button type=submit class=button><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete Time")."</button></form>";
echo "</td><td bgcolor=$rowcolor><form action=employee.php?func=punchout method=post>";
echo "<input type=hidden name=punchid value=$punchid><button type=submit class=\"linkbuttonred linkbuttonmedium radiusall\"><i class=\"fa fa-exit fa-lg\"></i> ".pcrtlang("Punch Out")."</button></form>";
echo "</td></tr>";
}

}
$prevday = "$theday";
$previouspunchout = strtotime($punchout2);
$previouspunchin = strtotime($punchin2);
$previouspunchid = $punchid;
$a++;
}

echo "</table>";
if ($showtotal == 1) {
echo "<br><span class=\"linkbuttonsmall linkbuttongraylabel radiusleft\">&nbsp;".pcrtlang("Total Hours").":&nbsp;</span><span class=\"linkbuttongreenlabel linkbuttonsmall\">$totaltime</span>";
}
stop_blue_box();

echo "<br><br>";

}



function perm_boot($permid) {

include("deps.php");

$pcrt_select_parms_q = "SELECT timeclockperms FROM users WHERE username = '$ipofpc'";
$frc_result_parms = @mysqli_query($rs_connect, $pcrt_select_parms_q);

$parmsa = mysqli_fetch_array($frc_result_parms);
$frc_perms = "$parmsa[timeclockperms]";


if ($frc_perms != "") {
$theperms3 = unserialize($frc_perms);
} else {
$theperms3 = array();
}

if(is_array($theperms3)) {
$theperms = $theperms3;
} else {
$theperms = array();
}


if (!in_array($permid, $theperms) && ("$ipofpc" != "admin")) {
       die("Access Denied - Please ask your admin for access to this function $permid");
}
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
                    $output .= "<a href='$new_url' class=rnumbers>$i</a> ";
                }
                else
                    $output .= '. ';
        }
        else
        {
            // This is the page we're looking at.
            $output .= "<font class=rnumbers>$i</font> ";
        }
    }

    // Remove extra dots from the list of pages, allowing it to be shortened.
#    $output = ereg_replace('(\. ){2,}', ' .. ', $output);
 $output = preg_replace('#(\. ){2,}#', ' .. ', $output); 
   // Determine whether to show the HTML, or just return it.
    if($show) echo $output;

    return($output);
}


###############################################################################
#Base vars


if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}

if(isset($ipofpc)) {

$thenow = date('Y-m-d H:i:s');
$rs_insert_time = "UPDATE users SET lastseen = '$thenow' WHERE username = '$ipofpc'";
@mysqli_query($rs_connect, $rs_insert_time);




$rs_ql = "SELECT gomodal,defloc,deptperms,locperms FROM users WHERE username = '$ipofpc'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$gomodal = "$rs_result_q1->gomodal";
$defloc = "$rs_result_q1->defloc";
$thisdeptperms = "$rs_result_q1->deptperms";
$thislocperms = "$rs_result_q1->locperms";

if ($thisdeptperms != "") {
$thisdeptperms3 = unserialize($thisdeptperms);
} else {
$thisdeptperms3 = array();
}
if (is_array($thisdeptperms3)) {
$deptpermsthisuser = $thisdeptperms3;
array_push($deptpermsthisuser, "0");
} else {
$deptpermsthisuser = array();
array_push($deptpermsthisuser, "0");
}

if ($thislocperms != "") {
$thislocperms3 = unserialize($thislocperms);
} else {
$thislocperms3 = array();
}
if (is_array($thislocperms3)) {
$locpermsthisuser = $thislocperms3;
} else {
$locpermsthisuser = array();
}
#####
if ((!in_array($defloc, $locpermsthisuser)) && (count($locpermsthisuser) != 0)) {



$rs_set_defloc = "UPDATE users SET defloc = '$locpermsthisuser[0]' WHERE username = '$ipofpc'";
@mysqli_query($rs_connect, $rs_set_defloc);
}
#####
}




$abreasons = array("0" => pcrtlang("Sick"),"1" => pcrtlang("Medical"),"2" => pcrtlang("Vacation"),"3" => pcrtlang("Running Late"),"4" => pcrtlang("No Show"),"5" => pcrtlang("Family Emergency"),"6" => pcrtlang("Family Medical Leave"),"7" => pcrtlang("Left Early"),"8" => pcrtlang("Doctor/Dentist Appointment"), "9" => pcrtlang("Called In"), "10" => pcrtlang("Funeral"), "11" => pcrtlang("On Holiday"));
$abreasonicons = array("0" => "thermometer-full","1" => "medkit","2" => "plane","3" => "clock-o","4" => "user-times","5" => "ambulance","6" => "group","7" => "sign-out","8" => "user-md", "9" => "phone", "10" => "heart-broken", "11" => "plane");


#######################################################################


function mf($value) {
if(empty($value)) {
return "0.00";
} else {
return number_format($value, 2, '.', '');
}
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




function getdefaultstoreinfo() {

include("deps.php");



$rs_ql = "SELECT * FROM stores WHERE storedefault = '1'";
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


function pcrtdate($timestring,$timestamp) {

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


function pcrtlang($string) {

require("deps.php");

if(!isset($pcrt_translation_off)) {

$safestring = pv($string);

$findstring = "SELECT languagestring FROM languages WHERE basestring LIKE BINARY '$safestring' AND language = '$mypcrtlanguage'";

$findstringq = @mysqli_query($rs_connect, $findstring);
if(mysqli_num_rows($findstringq) == 0) {
$findbasestring = "SELECT basestring FROM languages WHERE basestring LIKE BINARY '$safestring'";
$findbasestringq = @mysqli_query($rs_connect, $findbasestring);
if(mysqli_num_rows($findbasestringq) == 0) {
$addstring = "INSERT INTO languages (language,languagestring,basestring) VALUES ('en-us','$safestring','$safestring')";
@mysqli_query($rs_connect, $addstring);
}
return "$string";
} else {
$rs_result_qs = mysqli_fetch_object($findstringq);
return "$rs_result_qs->languagestring";
}

} else {
return "$string";
}

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
echo "<link rel=\"stylesheet\" href=\"../repair/fa5/css/all.min.css\">";
echo "<link rel=\"stylesheet\" href=\"../repair/fa5/css/v4-shims.min.css\">";
echo "<link rel=\"stylesheet\" href=\"../repair/fa5/font-awesome-animation.min.css\">";

echo "</head>";


if($autoprint == 1) {
echo "<body class=printpagebg onLoad=\"window.print()\">";
} else {
echo "<body class=printpagebg>";
}
echo "<div class=printbar>";
echo "<button onClick=\"window.history.back()\" class=bigbutton><i class=\"fa fa-chevron-left fa-lg\"></i> ".pcrtlang("Return")."</button>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<button onClick=\"print();\" class=bigbutton><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Print")."</button>";
echo "</div>";
echo "<div class=printpage>";

}

function printablefooter() {
echo "</div>";
echo "</body></html>";
}

function userlog($actionid,$refid,$reftype,$mensaje) {
require("deps.php");
if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}

$thenow = date('Y-m-d H:i:s');

$usernamechk = $ipofpc;
$mensaje2 = pv($mensaje);
$logactionsql = "INSERT INTO userlog (actionid,thedatetime,refid,reftype,loggeduser,mensaje) VALUES ('$actionid','$thenow','$refid','$reftype','$usernamechk','$mensaje2')";
@mysqli_query($rs_connect, $logactionsql);
}

