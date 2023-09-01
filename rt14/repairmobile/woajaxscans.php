<?php 

/***************************************************************************
 *   copyright            : (C) 2010 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/

require("validate2.php");
require("common.php");

$pcwo = $_REQUEST['pcwo'];
$woid = $pcwo;

$rs_findpcid = "SELECT * FROM pc_wo WHERE woid = '$woid'";
$rs_result1 = mysqli_query($rs_connect, $rs_findpcid);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$pcid = "$rs_result_q1->pcid";
$wochecks = "$rs_result_q1->wochecks";



$rs_findowner = "SELECT * FROM pc_owner WHERE pcid = '$pcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
$rs_result_q2 = mysqli_fetch_object($rs_result2);
$mainassettypeidindb = "$rs_result_q2->mainassettypeid";



$rs_sq = "SELECT * FROM mainassettypes WHERE mainassettypeid = '$mainassettypeidindb'";
$rs_result1 = mysqli_query($rs_connect, $rs_sq);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$mainassetchecksindb = serializedarraytest("$rs_result_q1->mainassetchecks");


if(count($mainassetchecksindb) > 0) {


$wochecks = serializedarraytest("$wochecks");


echo "<br><table class=standard>";

echo "<tr><th colspan=2>".pcrtlang("Pre Checks")."</th><th colspan=2>".pcrtlang("Post Checks")."</th></tr>";

#wip

foreach($mainassetchecksindb as $key => $val) {

$rs_checks = "SELECT * FROM checks WHERE checkid = '$val'";
$rs_checksq = mysqli_query($rs_connect, $rs_checks);
$rs_result_cq = mysqli_fetch_object($rs_checksq);
$checkid = "$rs_result_cq->checkid";
$checkname = "$rs_result_cq->checkname";

if (in_array($checkid, $mainassetchecksindb)) {

if(array_key_exists("$checkid", $wochecks)) {
if(isset($wochecks[$checkid][0])) {
$precheck = $wochecks[$checkid][0];
} else {
$precheck = 0;
}

if(isset($wochecks[$checkid][1])) {
$postcheck = $wochecks[$checkid][1];
} else {
$postcheck = 0;
}
} else {
$precheck = 0;
$postcheck = 0;
}

# not checked = 0, not applicable = 1, pass = 2, fail = 3

echo "<tr><td>$checkname</td><td>";
if($precheck == 0) {
echo "<div data-role=\"controlgroup\">";
echo "<a href=pc.php?func=setcheck&checktype=0&checkvalue=0&woid=$pcwo&checkid=$checkid  class=\"ui-btn ui-corner-all ui-shadow nopointerevents\" style=\"padding:2px\"
data-ajax=\"false\" title=\"".pcrtlang("not checked")."\"><i class=\"fa fa-square-o fa-lg colormeblue\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=0&checkvalue=1&woid=$pcwo&checkid=$checkid  class=\"ui-btn ui-corner-all ui-shadow\" style=\"padding:2px\"
data-ajax=\"false\" title=\"".pcrtlang("does not apply")."\"><i class=\"fa fa-minus fa-lg\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=0&checkvalue=2&woid=$pcwo&checkid=$checkid  class=\"ui-btn ui-corner-all ui-shadow\" style=\"padding:2px\"
data-ajax=\"false\" title=\"".pcrtlang("pass")."\"><i class=\"fa fa-check fa-lg\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=0&checkvalue=3&woid=$pcwo&checkid=$checkid  class=\"ui-btn ui-corner-all ui-shadow\" style=\"padding:2px\"
data-ajax=\"false\" title=\"".pcrtlang("fail")."\"><i class=\"fa fa-warning fa-lg\"></i></a>";
echo "</div>";
} elseif($precheck == 1) {
echo "<div data-role=\"controlgroup\">";
echo "<a href=pc.php?func=setcheck&checktype=0&checkvalue=0&woid=$pcwo&checkid=$checkid  class=\"ui-btn ui-corner-all ui-shadow\" style=\"padding:2px\"
data-ajax=\"false\" title=\"".pcrtlang("not checked")."\"><i class=\"fa fa-square-o fa-lg\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=0&checkvalue=1&woid=$pcwo&checkid=$checkid  class=\"ui-btn ui-corner-all ui-shadow nopointerevents\" style=\"padding:2px\"
data-ajax=\"false\" title=\"".pcrtlang("does not apply")."\"><i class=\"fa fa-minus fa-lg colormeblue\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=0&checkvalue=2&woid=$pcwo&checkid=$checkid  class=\"ui-btn ui-corner-all ui-shadow\" style=\"padding:2px\"
data-ajax=\"false\" title=\"".pcrtlang("pass")."\"><i class=\"fa fa-check fa-lg\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=0&checkvalue=3&woid=$pcwo&checkid=$checkid  class=\"ui-btn ui-corner-all ui-shadow\" style=\"padding:2px\"
data-ajax=\"false\" title=\"".pcrtlang("fail")."\"><i class=\"fa fa-warning fa-lg\"></i></a>";
echo "</div>";
} elseif($precheck == 2) {
echo "<div data-role=\"controlgroup\">";
echo "<a href=pc.php?func=setcheck&checktype=0&checkvalue=0&woid=$pcwo&checkid=$checkid  class=\"ui-btn ui-corner-all ui-shadow\" style=\"padding:2px\"
data-ajax=\"false\" title=\"".pcrtlang("not checked")."\"><i class=\"fa fa-square-o  fa-lg\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=0&checkvalue=1&woid=$pcwo&checkid=$checkid class=\"ui-btn ui-corner-all ui-shadow\" style=\"padding:2px\"
data-ajax=\"false\" title=\"".pcrtlang("does not apply")."\"><i class=\"fa fa-minus fa-lg\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=0&checkvalue=2&woid=$pcwo&checkid=$checkid class=\"ui-btn ui-corner-all ui-shadow nopointerevents\" style=\"padding:2px\"
data-ajax=\"false\" title=\"".pcrtlang("pass")."\"><i class=\"fa fa-check fa-lg colormegreen\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=0&checkvalue=3&woid=$pcwo&checkid=$checkid class=\"ui-btn ui-corner-all ui-shadow\" style=\"padding:2px\"
data-ajax=\"false\" title=\"".pcrtlang("fail")."\"><i class=\"fa fa-warning fa-lg\"></i></a>";
echo "</div>";
} elseif($precheck == 3) {
echo "<div data-role=\"controlgroup\">";
echo "<a href=pc.php?func=setcheck&checktype=0&checkvalue=0&woid=$pcwo&checkid=$checkid class=\"ui-btn ui-corner-all ui-shadow\" style=\"padding:2px\"
data-ajax=\"false\" title=\"".pcrtlang("not checked")."\"><i class=\"fa fa-square-o fa-lg\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=0&checkvalue=1&woid=$pcwo&checkid=$checkid class=\"ui-btn ui-corner-all ui-shadow\" style=\"padding:2px\"
data-ajax=\"false\" title=\"".pcrtlang("does not apply")."\"><i class=\"fa fa-minus fa-lg\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=0&checkvalue=2&woid=$pcwo&checkid=$checkid class=\"ui-btn ui-corner-all ui-shadow\" style=\"padding:2px\"
data-ajax=\"false\" title=\"".pcrtlang("pass")."\"><i class=\"fa fa-check fa-lg\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=0&checkvalue=3&woid=$pcwo&checkid=$checkid class=\"ui-btn ui-corner-all ui-shadow nopointerevents\" style=\"padding:2px\"
data-ajax=\"false\" title=\"".pcrtlang("fail")."\"><i class=\"fa fa-warning fa-lg colormered\"></i></a>";
echo "</div>";
} else {
}


echo "</td><td>$checkname</td><td>";

if($postcheck == 0) {
echo "<div data-role=\"controlgroup\">";
echo "<a href=pc.php?func=setcheck&checktype=1&checkvalue=0&woid=$pcwo&checkid=$checkid class=\"ui-btn ui-corner-all ui-shadow nopointerevents\" style=\"padding:2px\"
data-ajax=\"false\" title=\"".pcrtlang("not checked")."\"><i class=\"fa fa-square-o  fa-lg colormeblue\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=1&checkvalue=1&woid=$pcwo&checkid=$checkid class=\"ui-btn ui-corner-all ui-shadow\" style=\"padding:2px\"
data-ajax=\"false\" title=\"".pcrtlang("does not apply")."\"><i class=\"fa fa-minus fa-lg\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=1&checkvalue=2&woid=$pcwo&checkid=$checkid class=\"ui-btn ui-corner-all ui-shadow\" style=\"padding:2px\"
data-ajax=\"false\" title=\"".pcrtlang("pass")."\"><i class=\"fa fa-check fa-lg\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=1&checkvalue=3&woid=$pcwo&checkid=$checkid class=\"ui-btn ui-corner-all ui-shadow\" style=\"padding:2px\"
data-ajax=\"false\" title=\"".pcrtlang("fail")."\"><i class=\"fa fa-warning fa-lg\"></i></a>";
echo "</div>";
} elseif($postcheck == 1) {
echo "<div data-role=\"controlgroup\">";
echo "<a href=pc.php?func=setcheck&checktype=1&checkvalue=0&woid=$pcwo&checkid=$checkid class=\"ui-btn ui-corner-all ui-shadow\" style=\"padding:2px\"
data-ajax=\"false\" title=\"".pcrtlang("not checked")."\"><i class=\"fa fa-square-o  fa-lg\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=1&checkvalue=1&woid=$pcwo&checkid=$checkid class=\"ui-btn ui-corner-all ui-shadow nopointerevents\" style=\"padding:2px\"
data-ajax=\"false\" title=\"".pcrtlang("does not apply")."\"><i class=\"fa fa-minus fa-lg colormeblue\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=1&checkvalue=2&woid=$pcwo&checkid=$checkid class=\"ui-btn ui-corner-all ui-shadow\" style=\"padding:2px\"
data-ajax=\"false\" title=\"".pcrtlang("pass")."\"><i class=\"fa fa-check fa-lg\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=1&checkvalue=3&woid=$pcwo&checkid=$checkid class=\"ui-btn ui-corner-all ui-shadow\" style=\"padding:2px\"
data-ajax=\"false\" title=\"".pcrtlang("fail")."\"><i class=\"fa fa-warning fa-lg\"></i></a>";
echo "</div>";
} elseif($postcheck == 2) {
echo "<div data-role=\"controlgroup\">";
echo "<a href=pc.php?func=setcheck&checktype=1&checkvalue=0&woid=$pcwo&checkid=$checkid class=\"ui-btn ui-corner-all ui-shadow\" style=\"padding:2px\"
data-ajax=\"false\" title=\"".pcrtlang("not checked")."\"><i class=\"fa fa-square-o  fa-lg\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=1&checkvalue=1&woid=$pcwo&checkid=$checkid class=\"ui-btn ui-corner-all ui-shadow\" style=\"padding:2px\"
data-ajax=\"false\" title=\"".pcrtlang("does not apply")."\"><i class=\"fa fa-minus fa-lg\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=1&checkvalue=2&woid=$pcwo&checkid=$checkid class=\"ui-btn ui-corner-all ui-shadow nopointerevents\" style=\"padding:2px\"
data-ajax=\"false\" title=\"".pcrtlang("pass")."\"><i class=\"fa fa-check fa-lg colormegreen\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=1&checkvalue=3&woid=$pcwo&checkid=$checkid class=\"ui-btn ui-corner-all ui-shadow\" style=\"padding:2px\"
data-ajax=\"false\" title=\"".pcrtlang("fail")."\"><i class=\"fa fa-warning fa-lg\"></i></a>";
echo "</div>";
} elseif($postcheck == 3) {
echo "<div data-role=\"controlgroup\">";
echo "<a href=pc.php?func=setcheck&checktype=1&checkvalue=0&woid=$pcwo&checkid=$checkid class=\"ui-btn ui-corner-all ui-shadow\" style=\"padding:2px\"
data-ajax=\"false\" title=\"".pcrtlang("not checked")."\"><i class=\"fa fa-square-o fa-lg\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=1&checkvalue=1&woid=$pcwo&checkid=$checkid class=\"ui-btn ui-corner-all ui-shadow\" style=\"padding:2px\"
data-ajax=\"false\" title=\"".pcrtlang("does not apply")."\"><i class=\"fa fa-minus fa-lg\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=1&checkvalue=2&woid=$pcwo&checkid=$checkid class=\"ui-btn ui-corner-all ui-shadow\" style=\"padding:2px\" 
data-ajax=\"false\" title=\"".pcrtlang("pass")."\"><i class=\"fa fa-check fa-lg\"></i></a>";
echo "<a href=pc.php?func=setcheck&checktype=1&checkvalue=3&woid=$pcwo&checkid=$checkid class=\"ui-btn ui-corner-all ui-shadow nopointerevents\"
style=\"padding:2px\"  data-ajax=\"false\" title=\"".pcrtlang("fail")."\"><i class=\"fa fa-warning fa-lg colormered\"></i></a>";
echo "</div>";
} else {

}


echo "</td></tr>";
}

}


echo "</table>";

echo "<br>";

}


##########################start scans




$multiselect = "onchange='this.form.submit()'";

echo "<form action=pc.php?func=add_scan method=post data-ajax=\"false\">";

echo "<div class=\"ui-field-contain\">";
echo "<label for=\"thecount\">".pcrtlang("Items Found").":</label>";
echo "<input type=\"number\" name=\"thecount\" id=\"thecount\" value=\"\">";
echo "</div>";


echo "<select name=\"scanprog[]\" onchange='this.form.submit()'>";

echo "<option>".pcrtlang("Add Scan")."</option>";

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
echo "<option value=$scanid>$progname</option>";
} else {
echo "<option value=$scanid>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$progname</option>";
}

}

echo "</select><input type=hidden value=$pcwo name=woid></form><br><br>";

#2 here

echo "<div data-role=\"collapsible\">";
echo "<h3>".pcrtlang("Add Action")."</h3>";

echo "<form action=pc.php?func=add_scan method=post data-ajax=\"false\"><input type=hidden name=thecount>";

echo "<fieldset data-role=\"controlgroup\">";
                                                                                                                             
$rs_findscans2 = "SELECT * FROM pc_scans  WHERE scantype = '1' AND  active = '1' ORDER BY theorder DESC";
$rs_result_s2 = mysqli_query($rs_connect, $rs_findscans2);


while($rs_result_q_s2 = mysqli_fetch_object($rs_result_s2)) {
$scanid2 = "$rs_result_q_s2->scanid";
$progname2 = "$rs_result_q_s2->progname";
$icon2 = "$rs_result_q_s2->progicon";

if (!in_array("$scanid2", $scanarray)) {
echo "<label><input type=checkbox name=scanprog[] value=$scanid2><img src=../repair/images/scans/$icon2> $progname2</label>";
}
}                                                                                                                            
echo "</fieldset><button type=submit data-theme=\"b\"><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button><input type=hidden value=$pcwo name=woid></form>";

echo "</div>";

#3 here
echo "<div data-role=\"collapsible\">";
echo "<h3>".pcrtlang("Add Install")."</h3>";

echo "<form action=pc.php?func=add_scan method=post data-ajax=\"false\"><input type=hidden name=thecount>";
echo "<fieldset data-role=\"controlgroup\">";

                                                                                                                             
$rs_findscans3 = "SELECT * FROM pc_scans WHERE scantype = '2' AND  active = '1' ORDER BY theorder DESC";
$rs_result_s3 = mysqli_query($rs_connect, $rs_findscans3);

while($rs_result_q_s3 = mysqli_fetch_object($rs_result_s3)) {
$scanid3 = "$rs_result_q_s3->scanid";
$progname3 = "$rs_result_q_s3->progname";
$icon3 = "$rs_result_q_s3->progicon";

if (!in_array("$scanid3", $scanarray)) {
echo "<label><input type=checkbox name=scanprog[] value=$scanid3><img src=../repair/images/scans/$icon3> $progname3</label>";
}


}
                                                                                                                             
echo "</fieldset><button type=submit data-theme=\"b\"><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button><input type=hidden value=$pcwo name=woid></form>";

echo "</div>";

################
echo "<div data-role=\"collapsible\">";
echo "<h3>".pcrtlang("Add Note")."</h3>";
echo "<form action=pc.php?func=add_scan method=post data-ajax=\"false\"><input type=hidden name=thecount>";

echo "<fieldset data-role=\"controlgroup\">";

$rs_findscans4 = "SELECT * FROM pc_scans WHERE scantype = '3' AND active = '1' ORDER BY theorder DESC";
$rs_result_s4 = mysqli_query($rs_connect, $rs_findscans4);
while($rs_result_q_s4 = mysqli_fetch_object($rs_result_s4)) {
$scanid4 = "$rs_result_q_s4->scanid";
$progname4 = "$rs_result_q_s4->progname";
$icon4 = "$rs_result_q_s4->progicon";

if (!in_array("$scanid4", $scanarray)) {
echo "<label><input type=checkbox name=scanprog[] value=$scanid4><img src=../repair/images/scans/$icon4> $progname4</label>";
}


}

echo "</fieldset><button type=submit data-theme=\"b\"><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button><input type=hidden value=$pcwo name=woid></form>";

echo "</div>";

echo "<div data-role=\"collapsible\">";
echo "<h3>".pcrtlang("Add Custom")."</h3>";


echo "<button type=button onClick=\"parent.location='pc.php?func=addcustomscan&scantype=0&woid=$pcwo'\"><img src=../repair/images/scan.png align=absmiddle> ".pcrtlang("Scan")."</button>";
echo "<button type=button onClick=\"parent.location='pc.php?func=addcustomscan&scantype=1&woid=$pcwo'\"><img src=../repair/images/actionicon.png align=absmiddle> ".pcrtlang("Action")."</button>";
echo "<button type=button onClick=\"parent.location='pc.php?func=addcustomscan&scantype=2&woid=$pcwo'\"><img src=../repair/images/installicon.png align=absmiddle> ".pcrtlang("Install")."</button>";
echo "<button type=button onClick=\"parent.location='pc.php?func=addcustomscan&scantype=3&woid=$pcwo'\"><img src=../repair/images/notesicon.png align=absmiddle> ".pcrtlang("Note")."</button>";

echo "</div>";


echo "</td></tr></table><br>";

##################






echo "<table class=standard><tr><th>";
echo "<img src=../repair/images/scan.png border=0 align=absmiddle> ".pcrtlang("Scans");
echo "</th></tr><tr><td>";
$rs_foundscan = "SELECT * FROM pc_scan WHERE woid = '$pcwo' ORDER BY scantime ASC";
$rs_result_fs = mysqli_query($rs_connect, $rs_foundscan);
$bgswitch=2;
while($rs_result_fsr = mysqli_fetch_object($rs_result_fs)) {
$scanid = "$rs_result_fsr->scanid";
$scantype = "$rs_result_fsr->scantype";
$scannum = "$rs_result_fsr->scannum";
$scantime = "$rs_result_fsr->scantime";
$customprogname = "$rs_result_fsr->customprogname";
$customprintinfo = "$rs_result_fsr->customprintinfo";
$customscantype = "$rs_result_fsr->customscantype";
$byuser = "$rs_result_fsr->byuser";

$scantime2 = pcrtdate("$pcrt_time", "$scantime")." ".pcrtdate("$pcrt_shortdate", "$scantime");


$rs_foundscan_name = "SELECT * FROM pc_scans WHERE scanid = '$scantype'";
$rs_result_fs_name = mysqli_query($rs_connect, $rs_foundscan_name);
if ($scantype != "0") {
$rs_result_fsr_name = mysqli_fetch_object($rs_result_fs_name);
$scantypeid = "$rs_result_fsr_name->scanid";
$scantypeprogname = "$rs_result_fsr_name->progname";
$scantypeicon = "$rs_result_fsr_name->progicon";
$scantypetype = "$rs_result_fsr_name->scantype";
} else {
$scantypetype = $customscantype;
}



if (($scantypetype == 0) || ($customscantype == 0)){

if ($scantype == 0) {
$icon1 = "<img src=../repair/images/hand.png>";
} else {
$icon1 = "<img src=../repair/images/scans/$scantypeicon>";
}


if ($customprogname != "") {
echo "<strong>$icon1 $customprogname</strong>";
} else {
echo "<strong>$icon1 $scantypeprogname</strong>";
}

if ($customprintinfo == "") {
$alreadycustom = 0;
} else {
$alreadycustom = 1;
}

echo "</font>";
if ($scannum != 0) {
echo "<br>$scannum ".pcrtlang("item(s) found");
} else {
echo "<br>".pcrtlang("no items found");
}

echo "<br>$scantime2";

if ($byuser != "") {
echo " ".pcrtlang("by")." $byuser";
}

echo "<br><a href=pc.php?func=rm_scan&scanid=$scanid&woid=$pcwo style=\"padding:2px;\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" data-ajax=\"false\">".pcrtlang("remove")."</a>";

if ($scantype == "0") {
echo "<a href=pc.php?func=editcustominfo&scanid=$scanid&woid=$pcwo  style=\"padding:2px;\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" data-ajax=\"false\">".pcrtlang("edit custom scan")."</a>";
}

echo "<br>";
}
}

echo "</td></tr></table><br>";

echo "<br>";

#############2
echo "<table class=standard><tr><th>";
echo "<img src=../repair/images/actionicon.png border=0 align=absmiddle> ".pcrtlang("Actions");
echo "</th></tr><tr><td>";
$rs_foundscan1d = "SELECT * FROM pc_scan WHERE woid = '$pcwo' ORDER BY scantime ASC";
$rs_result_fs1d = mysqli_query($rs_connect, $rs_foundscan1d);
while($rs_result_fsr1d = mysqli_fetch_object($rs_result_fs1d)) {
$scanid1d = "$rs_result_fsr1d->scanid";
$scantype1d = "$rs_result_fsr1d->scantype";
$scannum1d = "$rs_result_fsr1d->scannum";
$scantime1d = "$rs_result_fsr1d->scantime";
$customprogname1d = "$rs_result_fsr1d->customprogname";
$customprintinfo1d = "$rs_result_fsr1d->customprintinfo";
$customscantype1d = "$rs_result_fsr1d->customscantype";
$byuser1d = "$rs_result_fsr1d->byuser";

if ($scantype1d != "0") {
$rs_foundscan_name1d = "SELECT * FROM pc_scans WHERE scanid = '$scantype1d'";
$rs_result_fs_name1d = mysqli_query($rs_connect, $rs_foundscan_name1d);
$rs_result_fsr_name1d = mysqli_fetch_object($rs_result_fs_name1d);
$scantypeid1d = "$rs_result_fsr_name1d->scanid";
$scantypeprogname1d = "$rs_result_fsr_name1d->progname";
$scantypeprintinfo1d = "$rs_result_fsr_name1d->printinfo";
$scantypeicon1d = "$rs_result_fsr_name1d->progicon";
$scantypetype1d = "$rs_result_fsr_name1d->scantype";
} else {
$scantypetype1d = $customscantype1d;
}



if (($scantypetype1d == 1) || ($customscantype1d == 1)) {

if ($scantype1d == 0) {
$theicon2 = "<img src=../repair/images/hand.png>";
} else {
$theicon2 = "<img src=../repair/images/scans/$scantypeicon1d>";
}

if ($customprintinfo1d == "") {
$alreadycustom1d = 0;
} else {
$alreadycustom1d = 1;
}

$thetext2 = "";

if ($scannum1d != 0) {
$thetext2 .= " - $scannum1d ".pcrtlang("item(s) found");
}
$scantime1d2 = pcrtdate("$pcrt_time", "$scantime1d")." ".pcrtdate("$pcrt_shortdate", "$scantime1d");

$thetext2 .= "$scantime1d2";

if ($byuser1d != "") {
$thetext2 .= " ".pcrtlang("by")." $byuser1d";
}



if ($customprogname1d != "") {
echo "<strong>$theicon2 $customprogname1d</strong><br>";
echo "$thetext2<br>";
echo "<a href=\"#scan$scanid1d\" data-rel=\"popup\" style=\"padding:2px;\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" data-transition=\"pop\"><i class=\"fa fa-eye\"></i> ".pcrtlang("message")."</a>";
echo "<div data-role=\"popup\" id=\"scan$scanid1d\">";
echo "<a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-corner-all ui-shadow ui-btn ui-icon-delete ui-btn-icon-notext ui-btn-right\">Close</a>";
echo "<p>$customprintinfo1d</p>";
echo "</div>";

} else {
if ($customprintinfo1d == "") {
echo "<strong>$theicon2 $scantypeprogname1d</strong><br>";
echo "$thetext2<br>";
echo "<a href=\"#scan$scanid1d\" data-rel=\"popup\" style=\"padding:2px;\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" data-transition=\"pop\"><i class=\"fa fa-eye\"></i> ".pcrtlang("message")."</a>";
echo "<div data-role=\"popup\" id=\"scan$scanid1d\">";
echo "<a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-corner-all ui-shadow ui-btn ui-icon-delete ui-btn-icon-notext ui-btn-right\">Close</a>";
echo "<p>$scantypeprintinfo1d</p>";
echo "</div>";

} else {
echo "<strong>$theicon2 $scantypeprogname1d</strong>";
echo "$thetext2<br>";
echo "<a href=\"#scan$scanid1d\" data-rel=\"popup\" style=\"padding:2px;\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" data-transition=\"pop\"><i class=\"fa fa-eye\"></i> ".pcrtlang("message")."</a>";
echo "<div data-role=\"popup\" id=\"scan$scanid1d\">";
echo "<a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-corner-all ui-shadow ui-btn ui-icon-delete ui-btn-icon-notext ui-btn-right\">Close</a>";
echo "<p>$customprintinfo1d</p>";
echo "</div>";


}
}



echo " <a href=pc.php?func=rm_scan&scanid=$scanid1d&woid=$pcwo style=\"padding:2px;\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" data-ajax=\"false\"><i class=\"fa fa-trash\"></i> ".pcrtlang("remove")."</a>";

if ($scantype1d != "0") {
echo "<a href=pc.php?func=custominfocreate&scanid=$scanid1d&scantypeid=$scantypeid1d&woid=$pcwo&alreadycustom=$alreadycustom1d style=\"padding:2px;\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" data-ajax=\"false\"><i class=\"fa fa-edit\"></i> ".pcrtlang("customize message")."</a>";
}

if (($alreadycustom1d == "1") && ($scantype1d != "0")) {
echo "<a href=pc.php?func=custominforevert&scanid=$scanid1d&scantypeid=$scantypeid1d&woid=$pcwo&alreadycustom=$alreadycustom1d style=\"padding:2px;\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"><i class=\"fa fa-reply\" data-ajax=\"false\"></i> ".pcrtlang("revert to default message")."</a>";
}

if ($scantype1d == "0") {
echo "<a href=pc.php?func=editcustominfo&scanid=$scanid1d&woid=$pcwo style=\"padding:2px;\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"><i class=\"fa fa-edit\" data-ajax=\"false\"></i> ".pcrtlang("edit custom message")."</a>";
}

echo "<br>";

}
}


echo "</td></tr></table><br>";

###############3
echo "<table class=standard><tr><th>";
echo "<img src=../repair/images/installicon.png border=0 align=absmiddle> ".pcrtlang("Installs");
echo "</th></tr><tr><td>";
$rs_foundscan2d = "SELECT * FROM pc_scan WHERE woid = '$pcwo' ORDER BY scantime ASC";
$rs_result_fs2d = mysqli_query($rs_connect, $rs_foundscan2d);
while($rs_result_fsr2d = mysqli_fetch_object($rs_result_fs2d)) {
$scanid2d = "$rs_result_fsr2d->scanid";
$scantype2d = "$rs_result_fsr2d->scantype";
$scannum2d = "$rs_result_fsr2d->scannum";
$scantime2d = "$rs_result_fsr2d->scantime";
$customprogname2d = "$rs_result_fsr2d->customprogname";
$customprintinfo2d = "$rs_result_fsr2d->customprintinfo";
$customscantype2d = "$rs_result_fsr2d->customscantype";
$byuser2d = "$rs_result_fsr2d->byuser";

$rs_foundscan_name2d = "SELECT * FROM pc_scans WHERE scanid = '$scantype2d'";
$rs_result_fs_name2d = mysqli_query($rs_connect, $rs_foundscan_name2d);
if ($scantype2d != "0") {
$rs_result_fsr_name2d = mysqli_fetch_object($rs_result_fs_name2d);
$scantypeid2d = "$rs_result_fsr_name2d->scanid";
$scantypeprogname2d = "$rs_result_fsr_name2d->progname";
$scantypeprintinfo2d = "$rs_result_fsr_name2d->printinfo";
$scantypeicon2d = "$rs_result_fsr_name2d->progicon";
$scantypetype2d = "$rs_result_fsr_name2d->scantype";
} else {
$scantypetype2d = $customscantype2d;
}

if (($scantypetype2d == 2) || ($customscantype2d == 2)) {

$theicon23 = "";

if ($scantype2d == 0) {
$theicon23 .= "<img src=../repair/images/hand.png>";
} else {
$theicon23 .= "<img src=../repair/images/scans/$scantypeicon2d>";
}

if ($customprintinfo2d == "") {
$alreadycustom2d = 0;
} else {
$alreadycustom2d = 1;
}

$thetext23 = "";

if ($scannum2d != 0) {
$thetext23 .= " - $scannum2d ".pcrtlang("item(s) found");
}

$scantime1d2 = pcrtdate("$pcrt_time", "$scantime2d")." ".pcrtdate("$pcrt_shortdate", "$scantime2d");

$thetext23 .= "$scantime1d2";

if ($byuser2d != "") {
$thetext23 .= " ".pcrtlang("by")." $byuser2d";
}




if ($customprogname2d != "") {
echo "<strong>$theicon23 $customprogname2d</strong><br>";
echo "$thetext23<br>";
echo "<a href=\"#scan$scanid2d\" data-rel=\"popup\" style=\"padding:2px;\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" data-transition=\"pop\"><i class=\"fa fa-eye\"></i> ".pcrtlang("message")."</a>";
echo "<div data-role=\"popup\" id=\"scan$scanid2d\">";
echo "<a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-corner-all ui-shadow ui-btn ui-icon-delete ui-btn-icon-notext ui-btn-right\">Close</a>";
echo "<p>$customprintinfo2d</p>";
echo "</div>";

} else {
if ($customprintinfo2d == "") {
echo "<strong>$theicon23 $scantypeprogname2d</strong><br>";
echo "$thetext23<br>";
echo "<a href=\"#scan$scanid2d\" data-rel=\"popup\" style=\"padding:2px;\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" data-transition=\"pop\"><i class=\"fa fa-eye\"></i> ".pcrtlang("message")."</a>";
echo "<div data-role=\"popup\" id=\"scan$scanid2d\">";
echo "<a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-corner-all ui-shadow ui-btn ui-icon-delete ui-btn-icon-notext ui-btn-right\">Close</a>";
echo "<p>$scantypeprintinfo2d</p>";
echo "</div>";

} else {
echo "<strong>$theicon23 $scantypeprogname2d</strong><br>";
echo "$thetext23<br>";
echo "<a href=\"#scan$scanid2d\" data-rel=\"popup\" style=\"padding:2px;\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" data-transition=\"pop\"><i class=\"fa fa-eye\"></i> ".pcrtlang("message")."</a>";
echo "<div data-role=\"popup\" id=\"scan$scanid2d\">";
echo "<a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-corner-all ui-shadow ui-btn ui-icon-delete ui-btn-icon-notext ui-btn-right\">Close</a>";
echo "<p>$customprintinfo2d</p>";
echo "</div>";

}
}


echo "<a href=pc.php?func=rm_scan&scanid=$scanid2d&woid=$pcwo style=\"padding:2px;\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" data-ajax=\"false\"><i class=\"fa fa-trash\"></i> ".pcrtlang("remove")."</a>";

if ($scantype2d != "0") {
echo "<a href=pc.php?func=custominfocreate&scanid=$scanid2d&scantypeid=$scantypeid2d&woid=$pcwo&alreadycustom=$alreadycustom2d style=\"padding:2px;\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" data-ajax=\"false\"><i class=\"fa fa-edit\"></i> ".pcrtlang("customize message")."</a>";
}
if (($alreadycustom2d == "1") && ($scantype2d != "0")) {
echo "<a href=pc.php?func=custominforevert&scanid=$scanid2d&scantypeid=$scantypeid2d&woid=$pcwo&alreadycustom=$alreadycustom2d style=\"padding:2px;\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" data-ajax=\"false\"><i class=\"fa fa-reply\"></i> ".pcrtlang("revert to default message")."</a>";
}

if ($scantype2d == "0") {
echo "<a href=pc.php?func=editcustominfo&scanid=$scanid2d&woid=$pcwo style=\"padding:2px;\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" data-ajax=\"false\"><i class=\"fa fa-edit\"></i> ".pcrtlang("edit custom message")."</a>";
}

echo "<br>";

}
}


echo "</td></tr></table><br>";

###################4
echo "<table class=standard><tr><th>";
echo "<img src=../repair/images/notesicon.png border=0 align=absmiddle> ".pcrtlang("Notes");
echo "</th></tr><tr><td>";
$rs_foundscan3d = "SELECT * FROM pc_scan WHERE woid = '$pcwo' ORDER BY scantime ASC";
$rs_result_fs3d  = mysqli_query($rs_connect, $rs_foundscan3d);
while($rs_result_fsr3d = mysqli_fetch_object($rs_result_fs3d)) {
$scanid3d = "$rs_result_fsr3d->scanid";
$scantype3d = "$rs_result_fsr3d->scantype";
$scannum3d = "$rs_result_fsr3d->scannum";
$scantime3d = "$rs_result_fsr3d->scantime";
$customprogname3d = "$rs_result_fsr3d->customprogname";
$customprintinfo3d = "$rs_result_fsr3d->customprintinfo";
$customscantype3d = "$rs_result_fsr3d->customscantype";
$byuser3d = "$rs_result_fsr3d->byuser";

$rs_foundscan_name3d = "SELECT * FROM pc_scans WHERE scanid = '$scantype3d'";
$rs_result_fs_name3d = mysqli_query($rs_connect, $rs_foundscan_name3d);

if ($scantype3d != "0") {
$rs_result_fsr_name3d = mysqli_fetch_object($rs_result_fs_name3d);
$scantypeid3d = "$rs_result_fsr_name3d->scanid";
$scantypeprogname3d = "$rs_result_fsr_name3d->progname";
$scantypeprintinfo3d = "$rs_result_fsr_name3d->printinfo";
$scantypeicon3d = "$rs_result_fsr_name3d->progicon";
$scantypetype3d = "$rs_result_fsr_name3d->scantype";
} else {
$scantypetype3d = $customscantype3d;
}


if (($scantypetype3d == 3) || ($customscantype3d == 3)){

if ($scantype3d == 0) {
$theicon24 = "<img src=../repair/images/hand.png>";
} else {
$theicon24 = "<img src=../repair/images/scans/$scantypeicon3d>";
}

if ($customprintinfo3d == "") {
$alreadycustom3d = 0;
} else {
$alreadycustom3d = 1;
}

$thetext24 = "";

if ($scannum3d != 0) {
$thetext24 .= " - $scannum3d ".pcrtlang("item(s) found");
}

$scantime1d3 = pcrtdate("$pcrt_time", "$scantime3d")." ".pcrtdate("$pcrt_shortdate", "$scantime3d");

$thetext24 .= "$scantime1d3";

if ($byuser3d != "") {
$thetext24 .= " ".pcrtlang("by")." $byuser3d";
}


if ($customprogname3d != "") {
echo "<strong>$theicon24 $customprogname3d</strong><br>";
echo "$thetext24<br>";
echo "<a href=\"#scan$scanid3d\" data-rel=\"popup\" style=\"padding:2px;\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" data-transition=\"pop\"><i class=\"fa fa-eye\"></i> ".pcrtlang("message")."</a>";
echo "<div data-role=\"popup\" id=\"scan$scanid3d\">";
echo "<a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-corner-all ui-shadow ui-btn ui-icon-delete ui-btn-icon-notext ui-btn-right\">Close</a>";
echo "<p>$customprintinfo3d</p>";
echo "</div>";

} else {
if ($customprintinfo3d == "") {
echo "<strong>$theicon24 $scantypeprogname3d</strong><br>";
echo "$thetext24<br>";
echo "<a href=\"#scan$scanid3d\" data-rel=\"popup\" style=\"padding:2px;\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" data-transition=\"pop\"><i class=\"fa fa-eye\"></i> ".pcrtlang("message")."</a>";
echo "<div data-role=\"popup\" id=\"scan$scanid3d\">";
echo "<a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-corner-all ui-shadow ui-btn ui-icon-delete ui-btn-icon-notext ui-btn-right\">Close</a>";
echo "<p>$scantypeprintinfo3d</p>";
echo "</div>";

} else {
echo "<strong>$theicon24 $scantypeprogname3d</strong><br>";
echo "$thetext24<br>";
echo "<a href=\"#scan$scanid3d\" data-rel=\"popup\" style=\"padding:2px;\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" data-transition=\"pop\"><i class=\"fa fa-eye\"></i> ".pcrtlang("message")."</a>";
echo "<div data-role=\"popup\" id=\"scan$scanid3d\">";
echo "<a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-corner-all ui-shadow ui-btn ui-icon-delete ui-btn-icon-notext ui-btn-right\">Close</a>";
echo "<p>$customprintinfo3d</p>";
echo "</div>";

}
}



echo "<a href=pc.php?func=rm_scan&scanid=$scanid3d&woid=$pcwo style=\"padding:2px;\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" data-ajax=\"false\"><i class=\"fa fa-trash\"></i> ".pcrtlang("remove")."</a>";

if ($scantype3d != "0") {
echo "<a href=pc.php?func=custominfocreate&scanid=$scanid3d&scantypeid=$scantypeid3d&woid=$pcwo&alreadycustom=$alreadycustom3d style=\"padding:2px;\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" data-ajax=\"false\"><i class=\"fa fa-edit\"></i> ".pcrtlang("customize message")."</a>";
}
if (($alreadycustom3d == "1") && ($scantype3d != "0")) {
echo "<a href=pc.php?func=custominforevert&scanid=$scanid3d&scantypeid=$scantypeid3d&woid=$pcwo&alreadycustom=$alreadycustom3d style=\"padding:2px;\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" data-ajax=\"false\"><i class=\"fa fa-reply\"></i> ".pcrtlang("revert to default message")."</a>";
}

if ($scantype3d == "0") {
echo "<a href=pc.php?func=editcustominfo&scanid=$scanid3d&woid=$pcwo style=\"padding:2px;\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" data-ajax=\"false\"><i class=\"fa fa-edit\"></i> ".pcrtlang("edit custom note")."</a>";
}

echo "<br>";

}
}


echo "</td></tr></table><br>";

################### 


?>
