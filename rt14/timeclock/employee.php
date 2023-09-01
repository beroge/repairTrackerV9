<?php

/***************************************************************************
 *   copyright            : (C) 2018 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/

if (array_key_exists('func',$_REQUEST)) {
$func = "$_REQUEST[func]";
} else {
$func = "";
}

                                                                                                    
function viewemployee() {
require("header.php");
require_once("common.php");
require("deps.php");






$eid = "$_REQUEST[eid]";
start_blue_box("View Employee");
$rs_ql = "SELECT * FROM employees WHERE employeeid = '$eid'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
echo "<table style=\"width:100%\"><tr><td><table class=standard>";
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$eid = "$rs_result_q1->employeeid";
$cn = "$rs_result_q1->clocknumber";
$employeename = "$rs_result_q1->employeename";
$isactive = "$rs_result_q1->isactive";
$location = "$rs_result_q1->location";
$deptid = "$rs_result_q1->deptid";
$fulltime = "$rs_result_q1->fulltime";
$wage = "$rs_result_q1->wage";


echo "<tr><td>".pcrtlang("Employee Name").":</td><td><span class=boldme>$employeename</span></td></tr>";
echo "<tr><td>".pcrtlang("Clock Number").":</td><td><span class=boldme>#$cn</span></td></tr>";

if ($isactive == 1) {
echo "<tr><td>".pcrtlang("Active").":</td><td><span class=textgreen12b>".pcrtlang("Yes")."</span></td></tr>";
} else {
echo "<tr><td>".pcrtlang("Active").":</td><td><span class=textred12b>".pcrtlang("No")."</span></td></tr>";
}

if ($fulltime == 0) {
echo "<tr><td>".pcrtlang("Fulltime").":</td><td><span class=textgreen12b>".pcrtlang("Yes")."</span></td></tr>";
} else {
echo "<tr><td>".pcrtlang("Fulltime").":</td><td><span class=textred12b>".pcrtlang("No")."</span></td></tr>";
}


$rs_fl = "SELECT * FROM locations WHERE locid = '$location'";
$rs_resultfl = mysqli_query($rs_connect, $rs_fl);
$rs_result_fl1 = mysqli_fetch_object($rs_resultfl);
$locname = "$rs_result_fl1->locname";

echo "<tr><td>".pcrtlang("Location").":</td><td><span class=boldme>$locname</span></td></tr>";

if ($deptid == 0) {
echo "<tr><td>".pcrtlang("Department").":</td><td><span class=boldme>".pcrtlang("Unassigned")."</span></td></tr>";
} else {

$rs_fd = "SELECT * FROM departments WHERE deptid = '$deptid'";
$rs_resultfd = mysqli_query($rs_connect, $rs_fd);
$rs_result_fdd = mysqli_fetch_object($rs_resultfd);
$deptname = "$rs_result_fdd->deptname";
$deptcode = "$rs_result_fdd->deptcode";

echo "<tr><td>".pcrtlang("Department").":</td><td><span class=boldme>$deptcode - $deptname</span></td></tr>";
}


if(perm_check("16")) {
echo "<tr><td>".pcrtlang("Hourly Wage").":</td><td><form action=employee.php?func=savewage method=post><input type=hidden name=eid value=\"$eid\"><input type=hidden name=cn value=\"$cn\">";
echo "<input type=text class=textbox name=wage style=\"width:50px;\" value=\"$wage\"><button class=button type=submit><i class=\"fa fa-save fa-lg\"></i></button></form></td></tr>";
}


$backurl = urlencode("employee.php?func=viewemployee&eid=$eid&cn=$cn");

$employeename2 = urlencode("$employeename");


if(perm_check("1")) {
echo "<tr><td colspan=2>";
echo "<button value=\"Edit Employee\" onClick=\"parent.location='employee.php?func=editemployee&eid=$eid'\" class=\"linkbutton linkbuttongray linkbuttonsmall radiusleft\">
<i class=\"fa fa-user fa-lg\"></i> Edit Employee</button>";

echo "<a href=employee.php?func=browseemployeetimes&eid=$eid  class=\"linkbuttonsmall linkbuttongray\"><i class=\"fa fa-search fa-lg\"></i> Browse All Times</a>";

echo "<button value=\"Edit Employee\" onClick=\"parent.location='badge.php?name=$employeename2&dymojsapi=html&backurl=$backurl&clocknumber=$cn&eid=$eid'\"
class=\"linkbutton linkbuttongray linkbuttonsmall radiusright\">
<i class=\"fa fa-tag fa-lg\"></i> Print Badge</button>";
}

echo "</td></tr>";


$backurl = urlencode("employee.php?func=viewemployee&eid=$eid&cn=$cn");

$employeename2 = urlencode("$employeename");



}
echo "</table></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td style=\"vertical-align:top;width:25%\">";

$chkdpunch = "SELECT * FROM punches WHERE employeeid = '$cn'";
$chkdpunch2 = mysqli_query($rs_connect, $chkdpunch);
$chkdpunch3 = mysqli_num_rows($chkdpunch2);

if ($chkdpunch3 == 0) {
if(perm_check("1")) {
echo "<INPUT TYPE=button value=\"".pcrtlang("Delete Employee")."\" onClick=\"parent.location='employee.php?func=deleteemployee&eid=$eid'\" class=ibutton><br><br>";
}
}


##########################################


echo "<table class=doublestandard style=\"vertical-align:top;\">";
echo "<tr><th>Absences</th><th style=\"text-align:right\">";

if(perm_check("1")) {
echo "<a href=\"#addab\" rel=\"facebox\" class=\"linkbuttongray linkbutton radiusall linkbuttontiny\"><i class=\"fa fa-plus\"></i></a>";
}

echo "</th></tr>";
$rs_qar = "SELECT * FROM absenses WHERE eid = '$eid' ORDER BY abdate DESC LIMIT 4";
$rs_resultqar = mysqli_query($rs_connect, $rs_qar);

$acount = mysqli_num_rows($rs_resultqar);
if($acount > 0) {
while($rs_result_aq = mysqli_fetch_object($rs_resultqar)) {
$abid = "$rs_result_aq->abid";
$abreason = "$rs_result_aq->abreason";
$abdate2 = "$rs_result_aq->abdate";
$abnotes = "$rs_result_aq->abnotes";
$abdate = date('Y-m-d', strtotime($abdate2));
echo "<tr><td style=\"width:40%\"><i class=\"fa fa-fw faa-tada animated fa-".$abreasonicons["$abreason"]."\"></i> &nbsp;$abreasons[$abreason] </td><td style=\"text-align:right\">$abdate";

if(perm_check("1")) {
echo " <a href=employee.php?func=abdel&abid=$abid&eid=$eid&cn=$cn class=\"linkbuttonred linkbuttontiny radiusall\"><i class=\"fa fa-times fa-lg\"></i></a>";
}

echo "</td></tr>";
echo "<tr><td>Notes:</td><td>$abnotes</td></tr>";
}
}

echo "</table><br>";

if(perm_check("1")) {
echo " <a href=employee.php?func=aball&eid=$eid&cn=$cn class=\"linkbuttongray linkbuttontiny radiusall\"><i class=\"fa fa-search fa-lg\"></i> View All</a>";
}



echo "<div id=addab style=\"display:none\">";
echo "<form action=employee.php?func=absave method=post><table class=standard style=\"width:75%\">";
echo "<tr><th colspan=2>Add Absence</th></tr>";
echo "<tr><td>Absense Reason:</td><td><select name=abreason>";

foreach($abreasons as $key=>$value) {
echo "<option value=$key>$value</option>";
}
echo "</select></td></tr>";

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}


$currentdatetime = date('Y-m-d H:i:s');


echo "<tr><td>Date: </td><td><input type=text name=abdate class=textbox value=\"$currentdatetime\"><input type=hidden name=eid value=$eid><input type=hidden name=cn value=$cn>";
echo "<tr><td>Notes:</td><td><textarea name=abnotes style=\"width:95%\"></textarea></td></tr>";
echo "<tr><td></td><td><button type=submit class=button>Save</button></td></tr>";
echo "</table></form><div>";



###########################################




echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

$rs_assetphotos = "SELECT * FROM ephotos WHERE eid = '$eid' ORDER BY addtime DESC LIMIT 1";
$rs_result_aset = mysqli_query($rs_connect, $rs_assetphotos);

$prows = mysqli_num_rows($rs_result_aset);

if ($prows != 0) {
$rs_result_aset2 = mysqli_fetch_object($rs_result_aset);
$ephotoid = "$rs_result_aset2->ephotoid";
#echo "<img src=ephotos/$photofilename width=200 class=eimage>";
echo "<img src=\"badgephoto.php?func=getimage&ephotoid=$ephotoid\" width=200 class=eimage>";
} else {
echo "<img src=nophoto.png width=200 class=eimage>";
}



echo "</td></tr></table>";
stop_blue_box();


echo "<br><br>";

$currentdatetime = date('Y-m-d H:i:s');

#$querythisweek = "SELECT punchid,punchstatus,punchin,punchout,medit, TIMEDIFF(punchout,punchin) AS totalhours FROM punches WHERE employeeid = '$cn' 
#AND (WEEK(punchin)) = (WEEK('$currentdatetime')) 
#AND (YEAR(punchin)) = (YEAR('$currentdatetime'))
#ORDER BY punchin ASC";
#showweek("$querythisweek","This Week Hours","asc","1");

$thedate = date("Y-m-d");

if(!isset($pcrt_workweekstart)) {
$pcrt_weekstart = "Sunday";
}
if ($pcrt_workweekstart == "Sunday") {
if(date("w") == 0) {
$thedate2 = date("Y-m-d");
} else {
$thedate2 = date("Y-m-d",strtotime("last Sunday"));
}
} else {
if(date("N") == 1) {
$thedate2 = date("Y-m-d");
} else {
$thedate2 = date("Y-m-d",strtotime("last Monday"));
}
}



$querythisweek = "SELECT punchid,punchstatus,punchin,punchout,medit,editnote,punchtype,punchtypeout, TIMEDIFF(punchout,punchin) AS totalhours FROM punches WHERE employeeid = '$cn'
AND punchin >= '$thedate2 00:00:00'
ORDER BY punchin ASC";
showweek("$querythisweek",pcrtlang("This Week Hours"),"asc","1");


#$querylastweek = "SELECT punchid,punchstatus,punchin,punchout,medit,editnote, TIMEDIFF(punchout,punchin) AS totalhours FROM punches WHERE employeeid = '$cn' 
#AND (WEEK(punchin)) = (WEEK(DATE_SUB('$currentdatetime', INTERVAL 1 WEEK))) 
#AND (YEAR(punchin)) = (YEAR('$currentdatetime'))
#ORDER BY punchin ASC";
#showweek("$querylastweek","Last Week Hours","asc","1");

if ($pcrt_workweekstart == "Sunday") {
$lthedate = date("Y-m-d",strtotime("last Saturday"));
$lthedate2 = date("Y-m-d",strtotime("last Saturday") - 518400);
} else {
$lthedate = date("Y-m-d",strtotime("last Sunday"));
$lthedate2 = date("Y-m-d",strtotime("last Sunday") - 518400);
}


$querylastweek = "SELECT punchid,punchstatus,punchin,punchout,medit,editnote,punchtype,punchtypeout, TIMEDIFF(punchout,punchin) AS totalhours FROM punches WHERE employeeid = '$cn'
AND punchin <= '$lthedate 23:59:59'
AND punchin >= '$lthedate2 00:00:00'
ORDER BY punchin ASC";
showweek("$querylastweek",pcrtlang("Last Weeks Hours"),"asc","1");


if(perm_check("1")) {
start_blue_box(pcrtlang("Add Time"));
echo "<table>";
echo "<tr><td><span class=boldme>".pcrtlang("Clock In (m/d/y)")."</span></td><td>&nbsp;&nbsp;</td>";
echo "<td><span class=boldme>".pcrtlang("Clock Out (m/d/y)")."</span></td><td>";
echo "&nbsp;</td><td colspan=2></td></tr>";

if(!isset($pcrt_hours24)) {
$pcrt_hours24 = "12";
}

if($pcrt_hours24 == 12) {
$punchin = date("n/j/Y g:i A");
$punchout = date("n/j/Y g:i A");
} else {
$punchin = date("n/j/Y H:i");
$punchout = date("n/j/Y H:i");
}


$theday = date("l", strtotime($punchin));

echo "<tr><td><form action=employee.php?func=addtime method=post><input type=hidden name=eid value=$cn>";
echo "<input type=text name=punchin value=\"$punchin\" size=21 class=textbox></td>";
echo "<td>&nbsp;&nbsp;</td>";
echo "<td><input type=text name=punchout value=\"$punchout\" size=21 class=textbox></td>";
echo "<td align=right></td><td><input type=submit class=button value=\"&lt;-".pcrtlang("Add Time")."\"></form>";
echo "</td><td>&nbsp;";
echo "</td></tr></table>";
stop_blue_box();
}


require_once("footer.php");
                                                                                                    
}


function editemployee() {
require("header.php");
require_once("common.php");
require("deps.php");

perm_boot("1");





$eid = "$_REQUEST[eid]";
start_blue_box(pcrtlang("Edit Employee"));
$rs_ql = "SELECT * FROM employees WHERE employeeid = '$eid'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
echo "<table><tr><td><table>";
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$eid = "$rs_result_q1->employeeid";
$cn = "$rs_result_q1->clocknumber";
$employeename = "$rs_result_q1->employeename";
$isactive = "$rs_result_q1->isactive";
$location = "$rs_result_q1->location";
$edeptid = "$rs_result_q1->deptid";
$fulltime = "$rs_result_q1->fulltime";
$linkeduser = "$rs_result_q1->linkeduser";

echo "<form action=employee.php?func=editemployee2 method=post><input type=hidden name=eid value=$eid>";
echo "<tr><td><span class=text12>".pcrtlang("Employee Name").":</span></td><td><span class=boldme>";
echo "<input type=text name=employeename value=\"$employeename\" class=textbox size=25></span></td></tr>";
echo "<tr><td><span class=text12>".pcrtlang("Clock Number").":</span></td><td><span class=boldme>";
echo "<input type=text name=clocknumber value=\"$cn\" class=textbox size=25></span></td></tr>";

echo "<tr><td><span class=text12>".pcrtlang("Active").":</span></td><td>";


echo "<div class=\"radiobox\">";
if($isactive == 0) {
echo "<input type=radio id=\"active\" value=\"1\" name=\"isactive\"><label for=\"active\"><i class=\"fa fa-play fa-lg\"></i> ".pcrtlang("Active")."</input></label>";
echo "<input type=radio id=\"inactive\" value=\"0\" name=\"isactive\" checked><label for=\"inactive\"><i class=\"fa fa-pause fa-lg\"></i> ".pcrtlang("Inactive")."</input></label></div>";
} else {
echo "<input type=radio id=\"active\" value=\"1\" name=\"isactive\" checked><label for=\"active\"><i class=\"fa fa-play fa-lg\"></i> ".pcrtlang("Active")."</input></label>";
echo "<input type=radio id=\"inactive\" value=\"0\" name=\"isactive\"><label for=\"inactive\"><i class=\"fa fa-pause fa-lg\"></i> ".pcrtlang("Inactive")."</input></label></div>";
}

echo "</div>";

echo "</td></tr>";

echo "<tr><td><span class=text12>".pcrtlang("Fulltime").":</span></td><td>";


echo "<div class=\"radiobox\">";
if($fulltime == 0) {
echo "<input type=radio id=\"fulltime\" value=\"1\" name=\"fulltime\"><label for=\"fulltime\"><i class=\"fa fa-hourglass-half fa-lg fa-fw\"></i> ".pcrtlang("Part Time")."</input></label>";
echo "<input type=radio id=\"parttime\" value=\"0\" name=\"fulltime\" checked><label for=\"parttime\"><i class=\"fa fa-hourglass fa-lg fa-fw\"></i> ".pcrtlang("Fulltime")."</input></label>";
} else {
echo "<input type=radio id=\"fulltime\" value=\"1\" name=\"fulltime\" checked><label for=\"fulltime\"><i class=\"fa fa-hourglass-half fa-lg fa-fw\"></i> ".pcrtlang("Part Time")."</input></label>";
echo "<input type=radio id=\"parttime\" value=\"0\" name=\"fulltime\"><label for=\"parttime\"><i class=\"fa fa-hourglass fa-lg fa-fw\"></i> ".pcrtlang("Fulltime")."</input></label>";
}

echo "</div>";

echo "</td></tr>";



echo "<tr><td><span class=text12>".pcrtlang("Location").":</span></td><td><select name=location>";

$rs_fl = "SELECT * FROM locations";
$rs_resultfl = mysqli_query($rs_connect, $rs_fl);
while ($rs_result_fl1 = mysqli_fetch_object($rs_resultfl)) {
$locname = "$rs_result_fl1->locname";
$locid = "$rs_result_fl1->locid";

if ($locid == $location) {
echo "<option selected value=$locid>$locname</option>";
} else {
echo "<option value=$locid>$locname</option>";
}


}

echo "</select></td></tr>";

#####

echo "<tr><td><span class=text12>".pcrtlang("Department").":</span></td><td><select name=department>";

$rs_fd = "SELECT * FROM departments";
$rs_resultfd = mysqli_query($rs_connect, $rs_fd);
while ($rs_result_fdd = mysqli_fetch_object($rs_resultfd)) {
$deptname = "$rs_result_fdd->deptname";
$deptid = "$rs_result_fdd->deptid";
$deptcode = "$rs_result_fdd->deptcode";

if ($edeptid == $deptid) {
echo "<option selected value=$deptid>$deptcode - $deptname</option>";
} else {
echo "<option value=$deptid>$deptcode - $deptname</option>";
}


}

if ($edeptid == 0) {
echo "<option selected value=0>".pcrtlang("Unassigned")."</option>";
} else {
echo "<option value=0>".pcrtlang("Unassigned")."</option>";
}


echo "</select></td></tr>";


echo "<tr><td><span class=text12>".pcrtlang("Linked User").":</span></td><td><select name=linkeduser>";

$rs_fu = "SELECT * FROM users";
$rs_resultfu = mysqli_query($rs_connect, $rs_fu);
while ($rs_result_fud = mysqli_fetch_object($rs_resultfu)) {
$username = "$rs_result_fud->username";


$rs_checkdup = "SELECT * FROM employees WHERE employeeid != '$eid' AND linkeduser = '$username'";
$rs_resultcheckdup = mysqli_query($rs_connect, $rs_checkdup);

$dupcount = mysqli_num_rows($rs_resultcheckdup);

if($dupcount == 0) {

if ($linkeduser == $username) {
echo "<option selected value=$username>$username</option>";
} else {
echo "<option value=$username>$username</option>";
}

}


}

if ($linkeduser == "") {
echo "<option selected value=\"\">".pcrtlang("Unassigned")."</option>";
} else {
echo "<option value=\"\">".pcrtlang("Unassigned")."</option>";
}


echo "</select></td></tr>";




#####


echo "<tr><td colspan=2><input type=submit value=\"".pcrtlang("Save")."\" class=button></form></td></tr>";

echo "</table></td><td>";


echo "</td></tr></table>";

}

stop_blue_box();





require_once("footer.php");

}



function editemployee2() {
require_once("validate.php");

require("deps.php");
require("common.php");

perm_boot("1");

$eid = $_REQUEST['eid'];
$employeename = pv($_REQUEST['employeename']);
$clocknumber = $_REQUEST['clocknumber'];
$location = $_REQUEST['location'];
$isactive = $_REQUEST['isactive'];
$deptid = $_REQUEST['department'];
$fulltime = $_REQUEST['fulltime'];
$linkeduser = $_REQUEST['linkeduser'];




$chkclock = "SELECT * FROM employees WHERE clocknumber = '$clocknumber' AND employeeid != '$eid'";
$chkclockq = mysqli_query($rs_connect, $chkclock);

$rows = mysqli_num_rows($chkclockq);

if ($rows != 0) {
die ("Sorry this clock number is already in use");
}

$rs_insert_scan = "UPDATE employees SET employeename = '$employeename', clocknumber = '$clocknumber', isactive = '$isactive', 
location = '$location', deptid = '$deptid', fulltime = '$fulltime', linkeduser = '$linkeduser' WHERE employeeid = '$eid'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: employee.php?func=viewemployee&eid=$eid");


}


function addemployee() {
require("header.php");
require_once("common.php");
require("deps.php");

perm_boot("1");





start_blue_box(pcrtlang("Add New Employee"));
echo "<table><tr><td><table>";
echo "<form action=employee.php?func=addemployee2 method=post>";
echo "<tr><td><span class=text12>".pcrtlang("Employee Name").":</span></td><td><span class=boldme>";
echo "<input type=text name=employeename class=textbox size=25></span></td></tr>";
echo "<tr><td><span class=text12>".pcrtlang("Clock Number").":</span></td><td><span class=boldme>";
echo "<input type=text name=clocknumber class=textbox size=25></span></td></tr>";

echo "<tr><td><span class=text12>Active:</span></td><td>";

echo "<input type=radio name=isactive value=1 checked><span class=boldme>".pcrtlang("Yes")."</span> ";
echo "<input type=radio name=isactive value=0><span class=boldme>".pcrtlang("No")."</span> ";

echo "</td></tr>";

echo "<tr><td><span class=text12>".pcrtlang("Fulltime").":</span></td><td>";

echo "<input type=radio name=fulltime value=0><span class=boldme>".pcrtlang("Yes")."</span> ";
echo "<input type=radio name=fulltime value=1 checked><span class=boldme>".pcrtlang("No")."</span> ";

echo "</td></tr>";




echo "<tr><td><span class=text12>".pcrtlang("Location").":</span></td><td><select name=location>";

$rs_fl = "SELECT * FROM locations";
$rs_resultfl = mysqli_query($rs_connect, $rs_fl);
while ($rs_result_fl1 = mysqli_fetch_object($rs_resultfl)) {
$locname = "$rs_result_fl1->locname";
$locid = "$rs_result_fl1->locid";

echo "<option value=$locid>$locname</option>";
}

echo "</select></td></tr>";

echo "<tr><td><span class=text12>".pcrtlang("Department").":</span></td><td><select name=department>";
echo "<option selected value=0>".pcrtlang("Unassigned")."</option>";
$rs_fd = "SELECT * FROM departments";
$rs_resultfd = mysqli_query($rs_connect, $rs_fd);
while ($rs_result_fdd = mysqli_fetch_object($rs_resultfd)) {
$deptname = "$rs_result_fdd->deptname";
$deptcode = "$rs_result_fdd->deptcode";
$deptid = "$rs_result_fdd->deptid";

echo "<option value=$deptid>$deptcode - $deptname</option>";
}

echo "</select></td></tr>";



echo "<tr><td colspan=2><input type=submit value=\"".pcrtlang("Save")."\" class=button></form></td></tr>";

echo "</table></td><td>";


echo "</td></tr></table>";
stop_blue_box();



require_once("footer.php");

}


function addemployee2() {
require_once("validate.php");

require("deps.php");
require("common.php");

perm_boot("1");

$employeename = pv($_REQUEST['employeename']);
$clocknumber = $_REQUEST['clocknumber'];
$location = $_REQUEST['location'];
$isactive = $_REQUEST['isactive'];
$deptid = $_REQUEST['department'];
$fulltime = $_REQUEST['fulltime'];





$chkclock = "SELECT * FROM employees WHERE clocknumber = '$clocknumber'";
$chkclockq = mysqli_query($rs_connect, $chkclock);
$rows = mysqli_num_rows($chkclockq);

if ($rows != 0) {
die (pcrtlang("Sorry this clock number is already in use"));
}

$rs_insert_scan = "INSERT INTO employees  (employeename,clocknumber,isactive,location,deptid,fulltime) VALUES ('$employeename','$clocknumber','$isactive','$location','$deptid','$fulltime')";
@mysqli_query($rs_connect, $rs_insert_scan);

$eid = mysqli_insert_id($rs_connect);

header("Location: employee.php?func=viewemployee&eid=$eid");


}

function deleteemployee() {
require_once("validate.php");

require("deps.php");
require("common.php");

perm_boot("1");

$eid = $_REQUEST['eid'];





$rs_insert_scan = "DELETE FROM employees WHERE employeeid = '$eid'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: clock.php");


}


function edittime() {
require_once("validate.php");

require("deps.php");
require("common.php");

perm_boot("1");

$punchid = $_REQUEST['punchid'];
$punchin = $_REQUEST['punchin'];
$punchout = $_REQUEST['punchout'];
$editnote = pv($_REQUEST['editnote']);
$gourl = $_SERVER['HTTP_REFERER'];

$punchin2 = date('Y-m-d H:i:s', strtotime($punchin));
$punchout2 = date('Y-m-d H:i:s', strtotime($punchout));

$punchin2c = strtotime($punchin);
$punchout2c = strtotime($punchout);

$checkdiff = abs($punchin2c - $punchout2c);

if($checkdiff > 86400) {
die(pcrtlang("Please go back and check the value, there is more than a 24 hour difference between the clockin and clockout time."));
}

if($punchin2c > $punchout2c) {
die(pcrtlang("Please go back and check the value, the clockin time is newer than the clockout time."));
}








$rs_insert_scan = "UPDATE punches SET punchin = '$punchin2', punchout = '$punchout2', medit = '$ipofpc', punchtypeout = '2',  punchtype = '2', editnote = CONCAT(editnote, '$ipofpc: $editnote<br>') WHERE punchid = '$punchid'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: $gourl");


}

function editopentime() {
require_once("validate.php");

require("deps.php");
require("common.php");

perm_boot("1");

$punchid = $_REQUEST['punchid'];
$punchin = $_REQUEST['punchin'];
$gourl = $_SERVER['HTTP_REFERER'];
$editnote = $_REQUEST['editnote'];

$punchin2 = date('Y-m-d H:i:s', strtotime($punchin));





$rs_insert_scan = "UPDATE punches SET punchin = '$punchin2', medit = '$ipofpc', editnote = '$editnote', punchtype = '2' WHERE punchid = '$punchid'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: $gourl");


}


function removebreak() {
require_once("validate.php");

require("deps.php");
require("common.php");

perm_boot("1");

$punchid = $_REQUEST['punchid'];
$previouspunchid = $_REQUEST['previouspunchid'];
$gourl = $_SERVER['HTTP_REFERER'];





$getout = "SELECT * FROM punches WHERE punchid = '$punchid'";
$rs_times1 = mysqli_query($rs_connect, $getout);
$rs_result_times1 = mysqli_fetch_object($rs_times1);
$punchout = "$rs_result_times1->punchout";
$punchin = "$rs_result_times1->punchin";

$pgetout = "SELECT * FROM punches WHERE punchid = '$previouspunchid'";
$prs_times1 = mysqli_query($rs_connect, $pgetout);
$prs_result_times1 = mysqli_fetch_object($prs_times1);
$ppunchout = "$prs_result_times1->punchout";
$ppunchin = "$prs_result_times1->punchin";


$rs_insert_scan = "UPDATE punches SET punchout = '$punchout', breakin = '$ppunchout', breakout = '$punchin' WHERE punchid = '$previouspunchid'";
@mysqli_query($rs_connect, $rs_insert_scan);

$rs_insert_scan = "DELETE FROM punches WHERE punchid = '$punchid'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: $gourl");


}

function deletetime() {
require_once("validate.php");

require("deps.php");
require("common.php");

perm_boot("1");

$punchid = $_REQUEST['punchid'];
$gourl = $_SERVER['HTTP_REFERER'];




$rs_insert_scan = "DELETE FROM punches WHERE punchid = '$punchid'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: $gourl");

}



function browseemployeetimes() {
require("header.php");
require_once("common.php");
require("deps.php");

perm_boot("1");
$eid = $_REQUEST['eid'];
if (array_key_exists("pageNumber", $_REQUEST)) {
$pageNumber = $_REQUEST[pageNumber];
} else {
$pageNumber = 1;
}

$results_per_page = 40;

if ($pageNumber == "") {
$offset = "0";
} else {
$offset = ($pageNumber * $results_per_page) - $results_per_page;
}





$employeenq = "SELECT * FROM employees WHERE employeeid = '$eid'";
$rs_times1 = mysqli_query($rs_connect, $employeenq);
$rs_result_times1 = mysqli_fetch_object($rs_times1);
$employeename = "$rs_result_times1->employeename";
$cn = "$rs_result_times1->clocknumber";

$querythisweek = "SELECT punchid,punchstatus,punchin,punchout,medit,editnote,punchtype,punchtypeout, TIMEDIFF(punchout,punchin) AS totalhours FROM punches WHERE employeeid = '$cn' ORDER BY punchin DESC LIMIT $offset,$results_per_page";
$findtotal = "SELECT punchid FROM punches WHERE employeeid = '$cn'";
$rs_result_total = mysqli_query($rs_connect, $findtotal);
showweek("$querythisweek",pcrtlang("Browsing Times (Newest to Oldest) for")." $employeename","desc","0");


echo "<br>";

#browse here
$totalentry = mysqli_num_rows($rs_result_total);
$prevpage = $pageNumber - 1;
$nextpage = $pageNumber + 1;

if ($pageNumber > 1) {
echo "<a href=employee.php?func=browseemployeetimes&pageNumber=$prevpage&eid=$eid class=imagelink><img src=images/left.png border=0 align=absmiddle";
echo " alt=\"".pcrtlang("Show Previous Page")."\"></a>&nbsp;";
}

$total_results = $totalentry;
$results_per_page = $results_per_page;
$html = get_paged_nav($total_results, $results_per_page, false);
echo "$html";

if (($totalentry / $results_per_page) > $pageNumber) {
echo "<a href=employee.php?func=browseemployeetimes&pageNumber=$nextpage&eid=$eid class=imagelink><img src=images/right.png border=0 ";
echo "align=absmiddle alt=\"".pcrtlang("Show Next Page")."\"></a>";
}





require_once("footer.php");

}


function searchemployee() {
require("header.php");
require_once("common.php");
require("deps.php");

perm_boot("1");




$searchterm = $_REQUEST['searchterm'];

start_blue_box(pcrtlang("Employee Search Results"));

$rs_fl = "SELECT * FROM employees WHERE employeename LIKE '%$searchterm%'";
$rs_resultfl = mysqli_query($rs_connect, $rs_fl);
while ($rs_result_fl1 = mysqli_fetch_object($rs_resultfl)) {
$ename = "$rs_result_fl1->employeename";
$eid = "$rs_result_fl1->employeeid";
$cn = "$rs_result_fl1->clocknumber";

echo "<span class=boldme>&bull;</span> <a href=employee.php?func=viewemployee&eid=$eid&cn=$cn>$ename</a><br>";

}

stop_blue_box();



require_once("footer.php");

}



function addtime() {
require_once("validate.php");

require("deps.php");
require("common.php");

perm_boot("1");

$cn = $_REQUEST['eid'];
$punchin = $_REQUEST['punchin'];
$punchout = $_REQUEST['punchout'];
$gourl = $_SERVER['HTTP_REFERER'];



$punchin2 = date('Y-m-d H:i:s', strtotime($punchin));
$punchout2 = date('Y-m-d H:i:s', strtotime($punchout));

$punchin2c = strtotime($punchin);
$punchout2c = strtotime($punchout);

$checkdiff = abs($punchin2c - $punchout2c);

if("$punchin" == "$punchout") {
die("The punchin and punchout times cannot be the same");
}


if($checkdiff > 86400) {
die(pcrtlang("Please go back and check the value, there is more than a 24 hour difference between the clockin and clockout time."));
}

if($punchin2c > $punchout2c) {
die(pcrtlang("Please go back and check the value, the clockin time is newer than the clockout time."));
}





$checkintimeinsql = "SELECT * FROM punches WHERE employeeid = '$cn' AND punchin <= '$punchin2' AND punchout >= '$punchin2'";
$checkintimeoutsql = "SELECT * FROM punches WHERE employeeid = '$cn' AND punchin <= '$punchout2' AND punchout >= '$punchout2'";
$checkintimespansql = "SELECT * FROM punches WHERE employeeid = '$cn' AND punchin >= '$punchin2' AND punchout <= '$punchout2'";


$incheck = mysqli_query($rs_connect, $checkintimeinsql);
$outcheck = mysqli_query($rs_connect, $checkintimeoutsql);
$spancheck = mysqli_query($rs_connect, $checkintimespansql);

$incheck2 = mysqli_num_rows($incheck);
$outcheck2 = mysqli_num_rows($outcheck);
$spancheck2 = mysqli_num_rows($spancheck);

if ($incheck2 != 0) {
die(pcrtlang("Your PUNCHIN time falls inside of a existing punch"));
}

if ($outcheck2 != 0) {
die(pcrtlang("Your PUNCHOUT time falls inside of a existing punch"));
}

if ($spancheck2 != 0) {
die(pcrtlang("Another existing punch time falls inside of this time. Timeclock user must not be punched in to add manual time."));
}

$editnote = "$ipofpc: ".pcrtlang("Manual time entry");

$rs_insert_scan = "INSERT INTO punches (punchin,punchout,employeeid,punchstatus,medit,editnote,punchtype,punchtypeout) VALUES ('$punchin2', '$punchout2', '$cn','out','$ipofpc', '$editnote<br>','2','2')";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: $gourl");


}


function gotoclocknumber() {
require_once("validate.php");

require("deps.php");
require("common.php");

perm_boot("1");


$cn = "$_REQUEST[cn]";
$rs_ql = "SELECT * FROM employees WHERE clocknumber = '$cn'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$eid = "$rs_result_q1->employeeid";

$gourl = "employee.php?func=viewemployee&eid=$eid&cn=$cn";

header("Location: $gourl");

}


function punchout() {
require_once("validate.php");

require("deps.php");
require("common.php");

perm_boot("1");

$punchid = "$_REQUEST[punchid]";

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}



$rs_find_punch = "SELECT * FROM punches WHERE punchid = '$punchid'";
$punchentry = mysqli_query($rs_connect, $rs_find_punch);
$rs_result_q1 = mysqli_fetch_object($punchentry);
$punchin = "$rs_result_q1->punchin";
$servertime = "$rs_result_q1->servertime";
$cn = "$rs_result_q1->employeeid";

$rs_find_eid = "SELECT * FROM employees WHERE clocknumber = '$cn'";
$eidq = mysqli_query($rs_connect, $rs_find_eid);
$rs_result_qeid1 = mysqli_fetch_object($eidq);
$eid = "$rs_result_qeid1->employeeid";


$punchin_stamp = strtotime($punchin);
$servertime_stamp = strtotime($servertime);
$currentservertime2 = date('Y-m-d H:i:s');
$currentservertime = strtotime($currentservertime2);

$diff = $punchin_stamp - $servertime_stamp;

$thepunch = (($currentservertime) + ($diff)); 

$thepunch2 =  date('Y-m-d H:i:s', $thepunch);

$editnote = "$ipofpc: ".pcrtlang("Manual punch out");

$rs_update_punch = "UPDATE punches SET punchstatus = 'out', punchout = '$thepunch2', theout = 'manual', medit = '$ipofpc', punchtypeout = '2', editnote = CONCAT(editnote, '$editnote<br>') WHERE punchid = '$punchid'";
@mysqli_query($rs_connect, $rs_update_punch);




$gourl = "employee.php?func=viewemployee&eid=$eid&cn=$cn";

header("Location: $gourl");

}


function savewage() {
require_once("validate.php");

require("deps.php");
require("common.php");

$cn = $_REQUEST['cn'];
$eid = $_REQUEST['eid'];
$wage = $_REQUEST['wage'];

$rs_insert_scan = "UPDATE employees SET wage = '$wage' WHERE employeeid = '$eid'";
@mysqli_query($rs_connect,$rs_insert_scan);

header("Location: employee.php?func=viewemployee&eid=$eid&cn=$cn");

}


function absave() {
require_once("validate.php");

require("deps.php");
require("common.php");

$cn = $_REQUEST['cn'];
$eid = $_REQUEST['eid'];
$abreason = $_REQUEST['abreason'];
$abdate = $_REQUEST['abdate'];
$abnotes = pv($_REQUEST['abnotes']);

$rs_insert_ab = "INSERT INTO absenses (abdate,abreason,eid,abnotes) VALUES ('$abdate','$abreason','$eid','$abnotes')";
@mysqli_query($rs_connect,$rs_insert_ab);

header("Location: employee.php?func=viewemployee&eid=$eid&cn=$cn");

}
function abdel() {
require_once("validate.php");

require("deps.php");
require("common.php");

$cn = $_REQUEST['cn'];
$eid = $_REQUEST['eid'];
$abid = pv($_REQUEST['abid']);

$rs_insert_ab = "DELETE FROM absenses WHERE abid = '$abid'";
@mysqli_query($rs_connect,$rs_insert_ab);

header("Location: employee.php?func=viewemployee&eid=$eid&cn=$cn");

}

function aball() {

require_once("common.php");
printableheader("Absence Report");

$cn = $_REQUEST['cn'];
$eid = $_REQUEST['eid'];

echo "<h4><center>".pcrtlang("Absence Report")."<center></h4>";

echo "<table class=doublestandard>";
echo "<tr><th>".pcrtlang("Absences")."</th><th style=\"text-align:right\">";

echo "</th></tr>";
$rs_qar = "SELECT * FROM absenses WHERE eid = '$eid' ORDER BY abdate DESC";
$rs_resultqar = mysqli_query($rs_connect, $rs_qar);

$acount = mysqli_num_rows($rs_resultqar);
if($acount > 0) {
while($rs_result_aq = mysqli_fetch_object($rs_resultqar)) {
$abid = "$rs_result_aq->abid";
$abreason = "$rs_result_aq->abreason";
$abdate2 = "$rs_result_aq->abdate";
$abnotes = "$rs_result_aq->abnotes";
$abdate = date('Y-m-d', strtotime($abdate2));
echo "<tr><td style=\"width:40%\"><i class=\"fa fa-fw faa-tada animated fa-".$abreasonicons["$abreason"]."\"></i> &nbsp;$abreasons[$abreason] </td><td style=\"text-align:right\">$abdate";


echo "</td></tr>";
echo "<tr><td>Notes:</td><td>$abnotes</td></tr>";
}
}

echo "</table><br>";

printablefooter();

}


#####

switch($func) {
                                                                                                    
    default:
    viewemployee();
    break;
                                
    case "viewemployee":
    viewemployee();
    break;

    case "editemployee":
    editemployee();
    break;

 case "editemployee2":
    editemployee2();
    break;

    case "addemployee":
    addemployee();
    break;

 case "addemployee2":
    addemployee2();
    break;

 case "deleteemployee":
    deleteemployee();
    break;

 case "edittime":
    edittime();
    break;

 case "editopentime":
    editopentime();
    break;

 case "removebreak":
    removebreak();
    break;

 case "deletetime":
    deletetime();
    break;


 case "browseemployeetimes":
    browseemployeetimes();
    break;

 case "searchemployee":
    searchemployee();
    break;

 case "addtime":
    addtime();
    break;

 case "gotoclocknumber":
    gotoclocknumber();
    break;

 case "punchout":
    punchout();
    break;

 case "savewage":
    savewage();
    break;

 case "absave":
    absave();
    break;

 case "abdel":
    abdel();
    break;

 case "aball":
    aball();
    break;

}

?>


