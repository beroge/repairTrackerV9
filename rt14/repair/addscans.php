<?php

/***************************************************************************
 *   copyright            : (C) 2018 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/

require("validate2.php");


require("deps.php");
require_once("common.php");

$pcwo = $_REQUEST['pcwo'];

if ($gomodal == 1) {
$therel = "rel=facebox";
} else {
$therel = "";
}


start_box();

$rs_find_user_view = "SELECT * FROM users WHERE username = '$ipofpc'";
$rs_result_view = mysqli_query($rs_connect, $rs_find_user_view);
$rs_result_viewq = mysqli_fetch_object($rs_result_view);
$scanview = "$rs_result_viewq->scanrecordview";

if ($scanview == '0') {
$vsize1 = "6";
$vsize2 = "20";
$multiselect = "";
$multiselecton = "multiple=\"multiple\"";
} else {
$vsize1 = "1";
$vsize2 = "1";
$multiselect = "";
#$multiselect = "onchange='this.form.submit()'";
$multiselecton = "";
}


echo "<table><tr><td width=60% valign=top><form action=pc.php?func=add_scan method=post><input type=text class=\"textboxw\" name=thecount size=6> <i class=\"fa fa-arrow-circle-left fa-lg\"></i> <span class=\"boldme\">".pcrtlang("Scan Items Found")."</span>";

echo "<br><select class=\"icon-menu\" size=\"$vsize1\" STYLE=\"width: 250px\" name=\"scanprog[]\">";


$rs_findscans = "SELECT * FROM pc_scans  WHERE scantype = '0' AND active = '1' ORDER BY theorder DESC";
$rs_result_s = mysqli_query($rs_connect, $rs_findscans);

$scanarray = array();
$rs_chkscans = "SELECT scantype FROM pc_scan WHERE woid = '$pcwo'";
$rs_chkresult_s = mysqli_query($rs_connect, $rs_chkscans);
while($rs_chkresult_q_s = mysqli_fetch_object($rs_chkresult_s)) {
$scantype = "$rs_chkresult_q_s->scantype";
$scanarray[] = "$scantype";
}


while($rs_result_q_s = mysqli_fetch_object($rs_result_s)) {
$scanid = "$rs_result_q_s->scanid";
$progname = "$rs_result_q_s->progname";
$icon = "$rs_result_q_s->progicon";


if (!in_array("$scanid", $scanarray)) {
echo "<option value=$scanid style=\"background-image:url(images/scans/$icon)\">$progname</option>";
} else {
echo "<option class=one value=$scanid style=\"background-image:url(images/scans/$icon)\">$progname</option>";
}

}

echo "</select><input type=hidden value=$pcwo name=woid><button type=submit class=button style=\"width:140px;\"><i class=\"fa fa-arrow-circle-left\"></i> ".pcrtlang("Add Scan")."</button></form>";

#2 here
echo "<form action=pc.php?func=add_scan method=post><input type=hidden name=thecount size=6><select class=icon-menu name=\"scanprog[]\" $multiselecton STYLE=\"width: 250px\" size=$vsize1 $multiselect>";
                                                                                                                             
$rs_findscans2 = "SELECT * FROM pc_scans  WHERE scantype = '1' AND  active = '1' ORDER BY theorder DESC";
$rs_result_s2 = mysqli_query($rs_connect, $rs_findscans2);


while($rs_result_q_s2 = mysqli_fetch_object($rs_result_s2)) {
$scanid2 = "$rs_result_q_s2->scanid";
$progname2 = "$rs_result_q_s2->progname";
$icon2 = "$rs_result_q_s2->progicon";

if (!in_array("$scanid2", $scanarray)) {
echo "<option value=$scanid2 style=\"background-image:url(images/scans/$icon2)\">$progname2</option>";
}
}                                                                                                                            
echo "</select><input type=hidden value=$pcwo name=woid><button type=submit class=button style=\"width:140px;\"><i class=\"fa fa-arrow-circle-left\"></i> ".pcrtlang("Add Action")."</button></form>";


#3 here

echo "<form action=pc.php?func=add_scan method=post><input type=hidden name=thecount size=6><select class=icon-menu name=\"scanprog[]\" size=$vsize1  STYLE=\"width: 250px\" $multiselecton $multiselect>";
                                                                                                                             
$rs_findscans3 = "SELECT * FROM pc_scans WHERE scantype = '2' AND  active = '1' ORDER BY theorder DESC";
$rs_result_s3 = mysqli_query($rs_connect, $rs_findscans3);

while($rs_result_q_s3 = mysqli_fetch_object($rs_result_s3)) {
$scanid3 = "$rs_result_q_s3->scanid";
$progname3 = "$rs_result_q_s3->progname";
$icon3 = "$rs_result_q_s3->progicon";

if (!in_array("$scanid3", $scanarray)) {
echo "<option value=$scanid3 style=\"background-image:url(images/scans/$icon3)\">$progname3</option>";
}


}
                                                                                                                             
echo "</select><input type=hidden value=$pcwo name=woid><button type=submit class=button style=\"width:140px;\"><i class=\"fa fa-arrow-circle-left\"></i> ".pcrtlang("Add Install")."</button></form>";


echo "<br><span class=\"linkbuttonmedium linkbuttongraylabel radiusleft\"><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Add Custom").": </span>";


echo "<a href=pc.php?func=addcustomscan&scantype=0&woid=$pcwo class=\"linkbuttonmedium linkbuttongray\" $therel><i class=\"fa fa-bug fa-lg\"></i> ".pcrtlang("Scan")."</a>";
echo "<a href=pc.php?func=addcustomscan&scantype=1&woid=$pcwo class=\"linkbuttonmedium linkbuttongray\" $therel><i class=\"fa fa-wrench fa-lg\"></i> ".pcrtlang("Action")."</a>";
echo "<a href=pc.php?func=addcustomscan&scantype=2&woid=$pcwo class=\"linkbuttonmedium linkbuttongray\" $therel><i class=\"fa fa-download fa-lg\"></i> ".pcrtlang("Install")."</a>";
echo "<a href=pc.php?func=addcustomscan&scantype=3&woid=$pcwo class=\"linkbuttonmedium linkbuttongray radiusright\" $therel><i class=\"fa fa-comment fa-lg\"></i> ".pcrtlang("Note")."</a>";


################
echo "</td><td width=40% valign=top><form action=pc.php?func=add_scan method=post><input type=hidden name=thecount><select class=icon-menu size=$vsize2  STYLE=\"width: 300px\" name=\"scanprog[]\" $multiselecton $multiselect>";

$rs_findscans4 = "SELECT * FROM pc_scans WHERE scantype = '3' AND active = '1' ORDER BY theorder DESC";
$rs_result_s4 = mysqli_query($rs_connect, $rs_findscans4);
while($rs_result_q_s4 = mysqli_fetch_object($rs_result_s4)) {
$scanid4 = "$rs_result_q_s4->scanid";
$progname4 = "$rs_result_q_s4->progname";
$icon4 = "$rs_result_q_s4->progicon";

if (!in_array("$scanid4", $scanarray)) {
echo "<option value=$scanid4 style=\"background-image:url(images/scans/$icon4)\">$progname4</option>";
}


}

echo "</select><input type=hidden value=$pcwo name=woid><br><button type=submit class=button><i class=\"fa fa-chevron-up\"></i> ".pcrtlang("Add Note")."</button></form><br>";


echo "<span class=\"linkbuttonmedium linkbuttongraylabel radiusleft\"><i class=\"fa fa-eye fa-lg\"></i> ".pcrtlang("View").":</span>";
if ($scanview == "0") {
echo "<span class=\"linkbuttonmedium linkbuttongraydisabled\">".pcrtlang("Expanded")."</span>";
echo "<a href=admin.php?func=setscanrecordview&pcwo=$pcwo&view=1 class=\"linkbuttonmedium linkbuttongray radiusright\">".pcrtlang("Compact View")."</a>";
} else {
echo "<a href=admin.php?func=setscanrecordview&pcwo=$pcwo&view=0 class=\"linkbuttonmedium linkbuttongray\">".pcrtlang("Expanded View")."</a>";
echo "<span class=\"linkbuttonmedium linkbuttongraydisabled radiusright\">".pcrtlang("Compact")."</span>";
}


echo "</td></tr></table>";


##################




stop_box();


?>

