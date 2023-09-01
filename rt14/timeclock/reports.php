<?php

/***************************************************************************
 *   copyright            : (C) 2010 PCRepairTracker.com
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






function timereport() {

$dayfrom = $_REQUEST['dayfrom'];
$dayto = $_REQUEST['dayto'];
$location = $_REQUEST['location'];
$employee = $_REQUEST['employee'];
$deptid = $_REQUEST['department'];
$active = $_REQUEST['active'];

if (array_key_exists('detailed',$_REQUEST)) {
$detailed = $_REQUEST['detailed'];
} else {
$detailed = "no";
}

if (array_key_exists('paginate',$_REQUEST)) {
$paginate = $_REQUEST['paginate'];
} else {
$paginate = "0";
}
         


if(!isset($_REQUEST['printable'])) {                                                                                                                                      
require_once("header.php");
} else {
require_once("common.php");
echo "<!DOCTYPE html>";
echo "<html><head><title>".pcrtlang("Time Report for")." $dayto - $dayfrom</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../repair/printstyle.css\">";
echo "<link rel=\"stylesheet\" href=\"fa/css/font-awesome.min.css\">";

echo "</head><body class=printpagebg>";
echo "<div class=printbar>";
echo "<button onClick=\"parent.location='reports.php?func=timereport&dayto=$dayto&dayfrom=$dayfrom&location=$location&detailed=$detailed&employee=$employee&department=$deptid&active=$active'\" class=bigbutton><img src=images/left.png style=\"vertical-align:middle;margin-bottom: .25em;\"> Return</button><font class=text30b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font><button onClick=\"print();\" class=bigbutton><img src=images/print.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Print")."</button>";
echo "</div>";
echo "<div class=printpage><table style=\"width: 90%;padding:5px;\"><tr><td>";
}



perm_boot("2");

if(isset($_REQUEST['printable'])) {
// echo "<a href=reports.php?func=timereport&dayto=$dayto&dayfrom=$dayfrom&location=$location&detailed=$detailed&employee=$employee&department=$deptid&active=$active>Non-Printable</a>";
} else {
start_box();
echo "<a href=reports.php?func=timereport&dayto=$dayto&dayfrom=$dayfrom&location=$location&printable=yes&detailed=$detailed&employee=$employee&department=$deptid&active=$active  class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Printable")."</a>";
}

echo "<br><br><font class=text20b>".pcrtlang("Time Report for")." ".pcrtdate("$pcrt_shortdate", "$dayfrom")." - ".pcrtdate("$pcrt_shortdate", "$dayto")."</font>";

if ($deptid != 0) {
$rs_fd = "SELECT * FROM departments WHERE deptid = '$deptid'";
$rs_resultfd = mysqli_query($rs_connect, $rs_fd);
$rs_result_fdd = mysqli_fetch_object($rs_resultfd);
$deptname = "$rs_result_fdd->deptname";
$deptcode = "$rs_result_fdd->deptcode";

echo "<br><br><font class=text12b>".pcrtlang("Department").": $deptcode - $deptname</font>";
}

echo "<br><br>";

require("deps.php");



echo "<table class=standard>";

if($deptid == 0) {
if ($employee == "all") {
$findemployees = "SELECT * FROM employees WHERE isactive = '$active' AND location = '$location' ORDER BY employeename ASC";
} else {
$findemployees = "SELECT * FROM employees WHERE isactive = '$active' AND location = '$location' AND clocknumber = '$employee' ORDER BY employeename ASC";
}
} else {
if ($employee == "all") {
$findemployees = "SELECT * FROM employees WHERE isactive = '$active' AND location = '$location' AND deptid = '$deptid' ORDER BY employeename ASC";
} else {
$findemployees = "SELECT * FROM employees WHERE isactive = '$active' AND location = '$location' AND clocknumber = '$employee' AND deptid = '$deptid' ORDER BY employeename ASC";
}
}


$findemployee_result = mysqli_query($rs_connect, $findemployees);
while($findemployee_result_q = mysqli_fetch_object($findemployee_result)) {
$eid = "$findemployee_result_q->employeeid";
$ename = "$findemployee_result_q->employeename";
$cn = "$findemployee_result_q->clocknumber";
$locationid2 = "$findemployee_result_q->location";
$deptid2 = "$findemployee_result_q->deptid";
$fulltime = "$findemployee_result_q->fulltime";

if(in_array("$locationid2", $locpermsthisuser)) {
if(in_array("$deptid2", $deptpermsthisuser)) {


$findtime = "SELECT SUM(TIMESTAMPDIFF(SECOND,punchin,punchout)) AS totalhours FROM punches 
WHERE punchin <= '$dayto 23:59:59' AND punchin  >= '$dayfrom 00:00:00' AND employeeid = '$cn' AND punchstatus = 'out'";


$findtime_result = mysqli_query($rs_connect, $findtime);
while($findtime_result_q = mysqli_fetch_object($findtime_result)) {
$totalhours = "$findtime_result_q->totalhours";

$totalhours2 = $totalhours / 3600;
$totalhours3 = number_format($totalhours2, 2, '.', '');


if (perm_check("1")) {
echo "<tr><td colspan=3><font class=text14b>#$cn <a href=employee.php?func=viewemployee&eid=$eid&cn=$cn>$ename:</a></font></td>";
echo "<td align=right colspan=4><font class=text12>".pcrtlang("Total").":</font> <font class=text12b>$totalhours3</font></td></tr>";
} else {
echo "<tr><td colspan=3><font class=text12b>#$cn $ename:</font></td>";
echo "<td align=right colspan=4><font class=text12>".pcrtlang("Total").":</font> <font class=text12b>$totalhours3</font></td></tr>";
}


if($detailed == "yes") {

$weeklyhours = 0;
$previousweekindate = "";
$previousday = "";
$previousdayhours = 0;

$querytimes = "SELECT punchid,punchstatus,punchin,punchout,medit,editnote, TIMESTAMPDIFF(SECOND,punchin,punchout) AS totalhours FROM punches WHERE punchin <= '$dayto 23:59:59' AND punchin  >= '$dayfrom 00:00:00' AND employeeid = '$cn' AND punchstatus = 'out' ORDER BY punchin ASC";
$findtimes_result = mysqli_query($rs_connect, $querytimes);
while($findtimes_result_q = mysqli_fetch_object($findtimes_result)) {
$totalhours21 = "$findtimes_result_q->totalhours";
$punchin = "$findtimes_result_q->punchin";
$punchout = "$findtimes_result_q->punchout";
$medit = "$findtimes_result_q->medit";
$editnote = "$findtimes_result_q->editnote";

$punchin2 = pcrtdate("$pcrt_mediumdate", "$punchin")." ".pcrtdate("$pcrt_time", "$punchin");
$punchout2 = pcrtdate("$pcrt_mediumdate", "$punchout")." ".pcrtdate("$pcrt_time", "$punchout");

if(!isset($pcrt_workweekstart)) {
$pcrt_weekstart = "Sunday";
}
if ($pcrt_workweekstart == "Sunday") {
$weekindate = date("W", (strtotime($punchout) + 86400));
} else {
$weekindate = date("W", (strtotime($punchout) + 0));
}

$totalhours22 = $totalhours21 / 3600;
$totalhours23 = number_format($totalhours22, 2, '.', '');

$currentday = date("l", strtotime($punchin));
if(($previousday != $currentday) && ($previousday != "")) {
if($previousdayhours != 0) {
echo "<tr><td align=right colspan=4 style=\"border-top: 1px solid black\"><font class=text12b>$previousday: ". number_format($previousdayhours, 2, '.', '')."</font><br><br></td></tr>";
}
$previousdayhours = $totalhours23;
} else {
$previousdayhours = $totalhours23 + $previousdayhours;
}





if($weekindate == $previousweekindate) {
$weeklyhours = $weeklyhours + $totalhours22;
} else {
if($previousweekindate != "") {
echo "<tr><td align=right colspan=4 style=\"border: 1px solid black\">";

if($fulltime == "0") {
echo "<font class=text12b><i class=\"fa fa-star fa-fw\"></i></font>";
} else {
if ($weeklyhours > 24) {
echo "<font class=textred12b><i class=\"fa fa-star-half-o fa-lg fa-fw\"></i></font>";
} else {
echo "<font class=text12b><i class=\"fa fa-star-half-o fa-fw\"></i></font>";
}
}



echo "<font class=text12b>".pcrtlang("Week Total").": ". number_format($weeklyhours, 2, '.', '')."</font></td></tr>";
echo "<tr><td align=right colspan=4>&nbsp;</td></tr>";
}
$weeklyhours = $totalhours22;
}



echo "<tr><td><font class=text12>$punchin2 </font></td><td><i class=\"fa fa-arrows-h fa-lg\"></i></td><td><font class=text12> $punchout2</font>";

echo "</td><td align=right colspan=4><font class=text12b>$totalhours23</font></td>";



echo "</tr>";



if($editnote != "") {
echo "<tr><td colspan=4><font class=textred12b>$editnote</font></td></tr>";
}


$previousweekindate = $weekindate;
$previousday = $currentday;

}   // End Loop

if($previousdayhours != 0) {
echo "<tr><td align=right colspan=4 style=\"border-top: 1px solid black\"><font class=text12b>$previousday: ". number_format($previousdayhours, 2, '.', '')."</font><br><br></td></tr>";
}

echo "<tr><td align=right colspan=4 style=\"border: 1px solid black\">";

if($fulltime == "0") {
echo "<font class=text12b><i class=\"fa fa-star fa-fw\"></i></font>";
} else {
if ($weeklyhours > 24) {
echo "<font class=textred12b><i class=\"fa fa-star-half-o fa-2x fa-fw\"></i></font>";
} else {
echo "<font class=text12b><i class=\"fa fa-star-half-o fa-fw\"></i></font>";
}
}


echo "<font class=text12b>".pcrtlang("Week Total").": ". number_format($weeklyhours, 2, '.', '')."</font></td></tr>";
echo "<tr><td align=right colspan=4>&nbsp;</td></tr>";

echo "<tr><td colspan=4>&nbsp;</td></tr>";
}





}
}

}
}

echo "</table>";


if(!isset($_REQUEST['printable'])) {
stop_box();
require("footer.php");
} else {
echo "</td></tr></table></div></body></html>";
}


}


##########################

function clocklist() {


require_once("common.php");
echo "<!DOCTYPE html>";
echo "<html><head><title>".pcrtlang("Clock Number List")."</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\">";
echo "</head><body style=\"background:#ffffff\">";



$location = $_REQUEST['location'];
$deptid = $_REQUEST['department'];

perm_boot("2");


$rs_find_tax = "SELECT * FROM locations WHERE locid = '$location'";
$rs_result_tax = mysqli_query($rs_connect, $rs_find_tax);

$rs_result_tq = mysqli_fetch_object($rs_result_tax);
$locname = "$rs_result_tq->locname";

echo "<font class=text20b>".pcrtlang("Clock Number List for")." $locname</font><br>";

if ($deptid != 0) {
$rs_fd = "SELECT * FROM departments WHERE deptid = '$deptid'";
$rs_resultfd = mysqli_query($rs_connect, $rs_fd);
$rs_result_fdd = mysqli_fetch_object($rs_resultfd);
$deptname = "$rs_result_fdd->deptname";
$deptcode = "$rs_result_fdd->deptcode";

echo "<br><br><font class=text12b>".pcrtlang("Department").": $deptcode - $deptname</font>";
}


if($deptid == 0) {
$findemployees = "SELECT * FROM employees WHERE isactive = 1 AND location = '$location' ORDER BY employeename ASC";
} else {
$findemployees = "SELECT * FROM employees WHERE isactive = 1 AND location = '$location' AND deptid = '$deptid' ORDER BY employeename ASC";
}

echo "<table style=\"width: 90%;padding:5px;\"><tr><td><table>";

echo "<tr><td colspan=2><font class=text14b>".pcrtlang("Order By Name")."</font></td></tr>";

$findemployee_result = mysqli_query($rs_connect, $findemployees);
while($findemployee_result_q = mysqli_fetch_object($findemployee_result)) {
$eid = "$findemployee_result_q->employeeid";
$ename = "$findemployee_result_q->employeename";
$cn = "$findemployee_result_q->clocknumber";

echo "<tr><td align=right><font class=text12b>$cn</font></td><td><font class=text12>$ename</font></td></tr>";

}

echo "</table></td><td><table>";

if($deptid == 0) {
$findemployees = "SELECT * FROM employees WHERE isactive = 1 AND location = '$location' ORDER BY clocknumber ASC";
} else {
$findemployees = "SELECT * FROM employees WHERE isactive = 1 AND location = '$location' AND deptid = '$deptid' ORDER BY clocknumber ASC";
}

echo "<table style=\"width: 90%;padding:5px;\"><tr><td><table>";

echo "<tr><td colspan=2><font class=text14b>".pcrtlang("Order By Clock Number")."</font></td></tr>";

$findemployee_result = mysqli_query($rs_connect, $findemployees);
while($findemployee_result_q = mysqli_fetch_object($findemployee_result)) {
$eid = "$findemployee_result_q->employeeid";
$ename = "$findemployee_result_q->employeename";
$cn = "$findemployee_result_q->clocknumber";

echo "<tr><td align=right><font class=text12b>$cn</font></td><td><font class=text12>$ename</font></td></tr>";

}


echo "</table></td></tr></table></body></html>";

}





#######################









######

switch($func) {
                                                                                                    
    default:
    reportlist();
    break;
                                
    case "prreport":
    prreport();
    break;

    case "timereport":
    timereport();
    break;

  case "clocklist":
    clocklist();
    break;




}

?>

