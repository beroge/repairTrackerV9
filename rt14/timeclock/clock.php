<?php

/***************************************************************************
 *   copyright            : (C) 2021 PCRepairTracker.com
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


function dailystatus() {
require_once("validate.php");

require("deps.php");

require_once("common.php");

require_once("header.php");

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}


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


echo "<table style=\"width:100%\"><tr><td style=\"width:50%;padding:5px;vertical-align:top\">";

if(perm_check("2")) {

start_blue_box(pcrtlang("Time Reports"));

echo "<form action=reports.php?func=timereport method=post><br><span class=\"sizemelarger\">".pcrtlang("This Week")."&nbsp;</span><br><br>";
echo "<table><tr><td><span class=boldme>".pcrtlang("Location").":</span></td><td><select name=location>";
$rs_fl = "SELECT * FROM locations";
$rs_resultfl = mysqli_query($rs_connect, $rs_fl);
while ($rs_result_fl1 = mysqli_fetch_object($rs_resultfl)) {
$locname = "$rs_result_fl1->locname";
$locid = "$rs_result_fl1->locid";
if(in_array("$locid", $locpermsthisuser)) {
if ($locid == $defloc) {
echo "<option selected value=$locid>$locname</option>";
} else {
echo "<option value=$locid>$locname</option>";
}
}

}
echo "</select></td><td></td></tr>";

###

echo "<tr><td><span class=boldme>".pcrtlang("Employee").":</span></td><td><select name=employee>";
echo "<option selected value=all style=\"font-weight:bold;\">".pcrtlang("All Active Employees")."</option>";
$rs_fe = "SELECT * FROM employees WHERE isactive = '1' AND location = '$defloc' ORDER BY employeename ASC";
$rs_resultfe = mysqli_query($rs_connect, $rs_fe);
while ($rs_result_fee = mysqli_fetch_object($rs_resultfe)) {
$ename2 = "$rs_result_fee->employeename";
$ecn2 = "$rs_result_fee->clocknumber";
$locationid2 = "$rs_result_fee->location";
$deptid2 = "$rs_result_fee->deptid";

if(in_array("$locationid2", $locpermsthisuser)) {
if(in_array("$deptid2", $deptpermsthisuser)) {
echo "<option value=$ecn2>$ename2</option>";
}
}
}
echo "</select></td><td></td></tr>";


###

echo "<tr><td><span class=boldme>".pcrtlang("Department").":</span></td><td><select name=department>";
echo "<option selected value=0>".pcrtlang("All Departments")."</option>";
$rs_fd = "SELECT * FROM departments ORDER BY deptcode";
$rs_resultfd = mysqli_query($rs_connect, $rs_fd);
while ($rs_result_fdd = mysqli_fetch_object($rs_resultfd)) {
$deptname = "$rs_result_fdd->deptname";
$deptid = "$rs_result_fdd->deptid";
$deptcode = "$rs_result_fdd->deptcode";
if(in_array("$deptid", $deptpermsthisuser)) {
echo "<option value=$deptid>$deptcode - $deptname</option>";
}
}
echo "</select></td></tr>";


###

echo "<tr><td><span class=boldme>".pcrtlang("Detailed")."?:</span></td><td><input type=checkbox name=detailed value=\"yes\"></td><td>";

echo "<tr><td><span class=boldme>".pcrtlang("Enter From Date").":</span></td><td><input id=dayfrom type=text class=textbox name=dayfrom value=\"$thedate2\"></td><td></td></tr>";
echo "<tr><td><span class=boldme>".pcrtlang("Enter To Date").":</span></td><td><input id=dayto type=text class=textbox name=dayto value=\"$thedate\"></td><td>";
echo "<input type=hidden name=active value=\"1\"><input class=button type=submit value=\"".pcrtlang("Show Report")."\"></form></td></tr></table>";
echo "<br>";

if(!isset($pcrt_weekstart)) {
$pcrt_weekstart = "Sunday";
}
if ($pcrt_weekstart == "Sunday") {
echo "<script type=\"text/javascript\" src=\"jq/datepickr.js\"></script>";
} else {
echo "<script type=\"text/javascript\" src=\"jq/datepickr2.js\"></script>";
}



?>

<script type="text/javascript">
new datepickr('dayfrom', { dateFormat: 'Y-m-d', theCurrentDate: document.getElementById("dayfrom").value });
</script>

<?php

if(!isset($pcrt_weekstart)) {
$pcrt_weekstart = "Sunday";
}
if ($pcrt_weekstart == "Sunday") {
echo "<script type=\"text/javascript\" src=\"jq/datepickr.js\"></script>";
} else {
echo "<script type=\"text/javascript\" src=\"jq/datepickr2.js\"></script>";
}




?>

<script type="text/javascript">
new datepickr('dayto', { dateFormat: 'Y-m-d', theCurrentDate: document.getElementById("dayto").value });
</script>
<?php


if ($pcrt_workweekstart == "Sunday") {
$lthedate = date("Y-m-d",strtotime("last Saturday"));
$lthedate2 = date("Y-m-d",strtotime("last Saturday") - 518400);
} else {
$lthedate = date("Y-m-d",strtotime("last Sunday"));
$lthedate2 = date("Y-m-d",strtotime("last Sunday") - 518400);
}


echo "<form action=reports.php?func=timereport method=post><span class=sizemelarger>".pcrtlang("Last Week")."&nbsp;</span><br><br>";
echo "<table><tr><td><span class=boldme>".pcrtlang("Location").":</span></td><td><select name=location>";
$lrs_fl = "SELECT * FROM locations";
$lrs_resultfl = mysqli_query($rs_connect, $lrs_fl);
while ($lrs_result_fl1 = mysqli_fetch_object($lrs_resultfl)) {
$llocname = "$lrs_result_fl1->locname";
$llocid = "$lrs_result_fl1->locid";

if(in_array("$llocid", $locpermsthisuser)) {
if ($llocid == $defloc) {
echo "<option selected value=$llocid>$llocname</option>";
} else {
echo "<option value=$llocid>$llocname</option>";
}
}
}
echo "</select></td><td></td></tr>";




echo "<tr><td><span class=boldme>".pcrtlang("Employee").":</span></td><td><select name=employee>";
echo "<option selected value=all style=\"font-weight:bold;\">".pcrtlang("All Active Employees")."</option>";
$rs_fe = "SELECT * FROM employees WHERE isactive = '1' AND location = '$defloc' ORDER BY employeename ASC";
$rs_resultfe = mysqli_query($rs_connect, $rs_fe);
while ($rs_result_fee = mysqli_fetch_object($rs_resultfe)) {
$ename2 = "$rs_result_fee->employeename";
$ecn2 = "$rs_result_fee->clocknumber";
$locationid2 = "$rs_result_fee->location";
$deptid2 = "$rs_result_fee->deptid";

if(in_array("$locationid2", $locpermsthisuser)) {
if(in_array("$deptid2", $deptpermsthisuser)) {
echo "<option value=$ecn2>$ename2</option>";
}
}
}
echo "</select></td><td></td></tr>";

###

echo "<tr><td><span class=boldme>".pcrtlang("Department").":</span></td><td><select name=department>";
echo "<option selected value=0>".pcrtlang("All Departments")."</option>";
$rs_fd = "SELECT * FROM departments ORDER BY deptcode";
$rs_resultfd = mysqli_query($rs_connect, $rs_fd);
while ($rs_result_fdd = mysqli_fetch_object($rs_resultfd)) {
$deptname = "$rs_result_fdd->deptname";
$deptid = "$rs_result_fdd->deptid";
$deptcode = "$rs_result_fdd->deptcode";
if(in_array("$deptid", $deptpermsthisuser)) {
echo "<option value=$deptid>$deptcode - $deptname</option>";
}
}
echo "</select></td></tr>";


###



echo "<tr><td><span class=boldme>".pcrtlang("Detailed")."?:</span></td><td><input type=checkbox name=detailed value=\"yes\"></td><td>";

echo "<tr><td><span class=boldme>".pcrtlang("Enter From Date").":</span></td><td><input id=dayfrom2 type=text class=textbox name=dayfrom value=\"$lthedate2\"></td><td></td></tr>";
echo "<tr><td><span class=boldme>".pcrtlang("Enter To Date").":</span></td><td><input id=dayto2 type=text class=textbox name=dayto value=\"$lthedate\"></td><td>";

echo "<input type=hidden name=active value=\"1\"><input class=button type=submit value=\"".pcrtlang("Show Report")."\"></form></td></tr></table>";

if(!isset($pcrt_weekstart)) {
$pcrt_weekstart = "Sunday";
}
if ($pcrt_weekstart == "Sunday") {
echo "<script type=\"text/javascript\" src=\"jq/datepickr.js\"></script>";
} else {
echo "<script type=\"text/javascript\" src=\"jq/datepickr2.js\"></script>";
}



?>


<script type="text/javascript">
new datepickr('dayfrom2', { dateFormat: 'Y-m-d', theCurrentDate: document.getElementById("dayfrom2").value });
</script>

<?php

if(!isset($pcrt_weekstart)) {
$pcrt_weekstart = "Sunday";
}
if ($pcrt_weekstart == "Sunday") {
echo "<script type=\"text/javascript\" src=\"jq/datepickr.js\"></script>";
} else {
echo "<script type=\"text/javascript\" src=\"jq/datepickr2.js\"></script>";
}

?>


<script type="text/javascript">
new datepickr('dayto2', { dateFormat: 'Y-m-d', theCurrentDate: document.getElementById("dayto2").value });
</script>
<?php



echo "<br>";
######################
if(perm_check("4")) {


echo "<form action=reports.php?func=timereport method=post><br><span class=sizemelarger>".pcrtlang("Inactive Employees")."&nbsp;</span><br><br>";
echo "<table><tr><td><span class=boldme>".pcrtlang("Location").":</span></td><td><select name=location>";
$rs_fl = "SELECT * FROM locations";
$rs_resultfl = mysqli_query($rs_connect, $rs_fl);
while ($rs_result_fl1 = mysqli_fetch_object($rs_resultfl)) {
$locname = "$rs_result_fl1->locname";
$locid = "$rs_result_fl1->locid";
if(in_array("$locid", $locpermsthisuser)) {
if ($locid == $defloc) {
echo "<option selected value=$locid>$locname</option>";
} else {
echo "<option value=$locid>$locname</option>";
}
}

}
echo "</select></td><td></td></tr>";

###

echo "<tr><td><span class=boldme>".pcrtlang("Employee").":</span></td><td><select name=employee>";
echo "<option selected value=all style=\"font-weight:bold;\">".pcrtlang("All Inactive Employees")."</option>";
$rs_fe = "SELECT * FROM employees WHERE isactive = '0' AND location = '$defloc' ORDER BY employeename ASC";
$rs_resultfe = mysqli_query($rs_connect, $rs_fe);
while ($rs_result_fee = mysqli_fetch_object($rs_resultfe)) {
$ename2 = "$rs_result_fee->employeename";
$ecn2 = "$rs_result_fee->clocknumber";
$locationid2 = "$rs_result_fee->location";
$deptid2 = "$rs_result_fee->deptid";

if(in_array("$locationid2", $locpermsthisuser)) {
if(in_array("$deptid2", $deptpermsthisuser)) {
echo "<option value=$ecn2>$ename2</option>";
}
}
}
echo "</select></td><td></td></tr>";


###

echo "<tr><td><span class=boldme>".pcrtlang("Department").":</span></td><td><select name=department>";
echo "<option selected value=0>".pcrtlang("All Departments")."</option>";
$rs_fd = "SELECT * FROM departments ORDER BY deptcode";
$rs_resultfd = mysqli_query($rs_connect, $rs_fd);
while ($rs_result_fdd = mysqli_fetch_object($rs_resultfd)) {
$deptname = "$rs_result_fdd->deptname";
$deptid = "$rs_result_fdd->deptid";
$deptcode = "$rs_result_fdd->deptcode";
if(in_array("$deptid", $deptpermsthisuser)) {
echo "<option value=$deptid>$deptcode - $deptname</option>";
}
}
echo "</select></td></tr>";


###

echo "<tr><td><span class=boldme>".pcrtlang("Detailed")."?:</span></td><td><input type=checkbox name=detailed value=\"yes\"></td><td>";

echo "<tr><td><span class=boldme>".pcrtlang("Enter From Date").":</span></td><td><input id=dayfrom3 type=text class=textbox name=dayfrom value=\"$thedate2\"></td><td></td></tr>";
echo "<tr><td><span class=boldme>".pcrtlang("Enter To Date").":</span></td><td><input id=dayto3 type=text class=textbox name=dayto value=\"$thedate\"></td><td>";
echo "<input type=hidden name=active value=\"0\"><input class=button type=submit value=\"Show Report\"></form></td></tr></table>";


if(!isset($pcrt_weekstart)) {
$pcrt_weekstart = "Sunday";
}
if ($pcrt_weekstart == "Sunday") {
echo "<script type=\"text/javascript\" src=\"jq/datepickr.js\"></script>";
} else {
echo "<script type=\"text/javascript\" src=\"jq/datepickr2.js\"></script>";
}




?>



<script type="text/javascript">
new datepickr('dayfrom3', { dateFormat: 'Y-m-d', theCurrentDate: document.getElementById("dayfrom3").value });
</script>


<script type="text/javascript">
new datepickr('dayto3', { dateFormat: 'Y-m-d', theCurrentDate: document.getElementById("dayto3").value });
</script>
<?php


echo "<br>";


#end non active perm
}

#end report permission
}

####################

stop_blue_box();

echo "</td><td style=\"width:50%;padding:5px;vertical-align:top\">";


#########################

start_blue_box("Today's Absences");

echo "<table class=doublestandard>";
echo "<tr><th>Absences</th><th style=\"text-align:right\">";

echo "</th></tr>";
$rs_qar = "SELECT * FROM absenses WHERE abdate LIKE '$thedate%' ORDER BY abdate DESC LIMIT 20";
$rs_resultqar = mysqli_query($rs_connect, $rs_qar);

$acount = mysqli_num_rows($rs_resultqar);
if($acount > 0) {
while($rs_result_aq = mysqli_fetch_object($rs_resultqar)) {
$abid = "$rs_result_aq->abid";
$abreason = "$rs_result_aq->abreason";
$abdate2 = "$rs_result_aq->abdate";
$abnotes = "$rs_result_aq->abnotes";
$eid = "$rs_result_aq->eid";
$abdate = date('Y-m-d', strtotime($abdate2));

$rs_fe = "SELECT * FROM employees WHERE employeeid = '$eid'";
$rs_resultfe = mysqli_query($rs_connect,$rs_fe);
$rs_result_fee = mysqli_fetch_object($rs_resultfe);
$aename = "$rs_result_fee->employeename";
$alocid = "$rs_result_fee->location";

$rs_fl = "SELECT * FROM locations WHERE locid = '$alocid'";
$rs_resultfl = mysqli_query($rs_connect,$rs_fl);
$rs_result_fl1 = mysqli_fetch_object($rs_resultfl);
$alocname = "$rs_result_fl1->locname";


echo "<tr><td><i class=\"fa fa-fw fa-user\"></i> <span class=boldme>$aename</span></td>";
echo "<td><i class=\"fa fa-fw fa-map-marker\"></i>$alocname <span class=floatright>$abdate</span>";

echo "</td></tr>";
echo "<tr><td>";
echo "<i class=\"fa fa-fw faa-tada animated fa-".$abreasonicons["$abreason"]."\"></i> &nbsp;$abreasons[$abreason]";
echo "</td><td>$abnotes</td></tr>";
}
}

echo "</table><br>";

stop_blue_box();

#################





start_blue_box(pcrtlang("Clock Number List"));

echo "<form action=reports.php?func=clocklist method=post>";
echo "<table><tr><td><span class=boldme>".pcrtlang("Location").":</span></td><td><select name=location>";
$rs_fl = "SELECT * FROM locations";
$rs_resultfl = mysqli_query($rs_connect, $rs_fl);
while ($rs_result_fl1 = mysqli_fetch_object($rs_resultfl)) {
$locname = "$rs_result_fl1->locname";
$locid = "$rs_result_fl1->locid";
if(in_array("$locid", $locpermsthisuser)) {
if ($locid == $defloc) {
echo "<option selected value=$locid>$locname</option>";
} else {
echo "<option value=$locid>$locname</option>";
}
}

}
echo "</select></td><td></td></tr>";
echo "<tr><td><span class=boldme>".pcrtlang("Department").":</span></td><td><select name=department>";
echo "<option selected value=0>".pcrtlang("All Departments")."</option>";
$rs_fd = "SELECT * FROM departments ORDER BY deptcode";
$rs_resultfd = mysqli_query($rs_connect, $rs_fd);
while ($rs_result_fdd = mysqli_fetch_object($rs_resultfd)) {
$deptname = "$rs_result_fdd->deptname";
$deptid = "$rs_result_fdd->deptid";
$deptcode = "$rs_result_fdd->deptcode";
if(in_array("$deptid", $deptpermsthisuser)) {
echo "<option value=$deptid>$deptcode - $deptname</option>";
}
}
echo "</select></td></tr>";
echo "<tr><td><input class=button type=submit value=\"".pcrtlang("Show Report")."\"></form></td></tr></table>";



stop_box();

echo "</td></tr></table>";



require("footer.php");


}



######

switch($func) {
                                                                                                    
    default:
    dailystatus();
    break;
                                
    case "dailystatus":
    dailystatus();
    break;


}

?>

