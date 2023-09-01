<?php

require("validate.php");

require("deps.php");
require_once("common.php");

require_once("header.php");


if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}


if ($gomodal == 1) {
$therel = "rel=facebox";
} else {
$therel = "";
}

if(array_key_exists('uname',$_REQUEST)) {
$uname = $_REQUEST['uname'];
} else {
$uname = "";
}

if(array_key_exists('stickytypeid',$_REQUEST)) {
$stickytypeid = $_REQUEST['stickytypeid'];
} else {
$stickytypeid = "";
}

if(array_key_exists('thewhen',$_REQUEST)) {
$thewhen = $_REQUEST['thewhen'];
} else {
$thewhen = "";
}

if(array_key_exists('showwhat',$_REQUEST)) {
$showwhat = $_REQUEST['showwhat'];
} else {
$showwhat = "stickywall";
}

if(array_key_exists('stickystoreid',$_REQUEST)) {
$stickystoreid = $_REQUEST['stickystoreid'];
} else {
$stickystoreid = "$defaultuserstore";
}

if ("$stickystoreid" == "all") {
$storeidsql = "";
} else {
$storeidsql = "storeid = '$stickystoreid' AND";
}





$storeoptions = "";
if ($activestorecount > 1) {
$rs_find_stores = "SELECT * FROM stores WHERE storeenabled = '1' ORDER BY storesname ASC";
$rs_result_stores = mysqli_query($rs_connect, $rs_find_stores);
$storeoptions .= "<select name=stickystoreid>";
while($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
$rs_storesname = "$rs_result_storeq->storesname";
$rs_storeid = "$rs_result_storeq->storeid";
if ($rs_storeid == $stickystoreid) {
$storeoptions .= "<option selected value=$rs_storeid>$rs_storesname</option>";
} else {
$storeoptions .= "<option value=$rs_storeid>$rs_storesname</option>";
}
}

if("$stickystoreid" == "all") {
$storeoptions .= "<option selected value=all>".pcrtlang("All Stores")."</option>";
} else {
$storeoptions .= "<option value=all>".pcrtlang("All Stores")."</option>";
}

$storeoptions .= "</select><br>";
} else {
$storeoptions = "<input type=hidden name=stickystoreid value=\"$defaultuserstore\">";
}



if ($showwhat == "stickywall") {

echo "<script type=\"text/javascript\">document.title = \"".pcrtlang("Sticky Wall")."\";</script>";

start_box();
echo "<table style=\"width:100%;\"><tr><td style=\"width:75%\">";

echo "<a href=sticky.php?func=addsticky $therel class=\"linkbuttonmedium linkbuttongray radiusleft\"><img src=images/stickyadd.png class=iconmedium> ".pcrtlang("Add Sticky")."</a>";

$phpself = $_SERVER['PHP_SELF'];

echo "<a href=stickydisplay.php?showwhat=calendar class=\"linkbuttonmedium linkbuttongray\"><img src=images/sticky.png class=iconmedium> ".pcrtlang("Sticky Calendar")."</a>";

echo "<a href=sticky.php?func=stickybrowse class=\"linkbuttonmedium linkbuttongray radiusright\"><img src=images/sticky.png class=iconmedium> ".pcrtlang("Browse All Sticky Notes")."</a>";

echo "</td>";

if ($activestorecount > 1) {
echo "<td>".pcrtlang("Store").":</td>";
}


echo "<td><form action=\"$phpself\" method=post> $storeoptions</td>";

echo "<td style=\"width:25%;text-align:center;\"><span class=\"sizeme16 boldme\">".pcrtlang("Sticky Wall")."</span></td></tr></table>";
echo "<table><tr><td> &nbsp;".pcrtlang("Who").":</td><td>";

$rs_find_users = "SELECT * FROM users WHERE username != 'admin'";
$rs_result_users = mysqli_query($rs_connect, $rs_find_users);
echo "<select name=uname onchange='this.form.submit()'>";
if($uname == "") {
echo "<option value=\"\" selected>".pcrtlang("Show All")."</option>";
} else {
echo "<option value=\"\">".pcrtlang("Show All")."</option>";
}

while($rs_result_uq = mysqli_fetch_object($rs_result_users)) {
$rs_uname = "$rs_result_uq->username";
if($rs_uname == "$uname") {
echo "<option value=$rs_uname selected>$rs_uname</option>";
} else {
echo "<option value=$rs_uname>$rs_uname</option>";
}
}
echo "</select>";

echo "</td><td>&nbsp;&nbsp;".pcrtlang("Note Type").":</td><td>";

$rs_find_stickytypes = "SELECT * FROM stickytypes";
$rs_result_stickytypes = mysqli_query($rs_connect, $rs_find_stickytypes);
echo "<select name=stickytypeid onchange='this.form.submit()'>";
if($stickytypeid == "") {
echo "<option value=\"\" selected>".pcrtlang("Show All")."</option>";
} else {
echo "<option value=\"\">".pcrtlang("Show All")."</option>";
}


while($rs_result_sq = mysqli_fetch_object($rs_result_stickytypes)) {
$rs_stname = "$rs_result_sq->stickytypename";
$rs_stid = "$rs_result_sq->stickytypeid";
if ($stickytypeid == $rs_stid) {
echo "<option value=$rs_stid selected>$rs_stname</option>";
} else {
echo "<option value=$rs_stid>$rs_stname</option>";
}
}
echo "</select>";


echo "</td><td>&nbsp;&nbsp;".pcrtlang("Date").":</td><td>";

echo "<select name=thewhen onchange='this.form.submit()'>";
if($thewhen == "") {
echo "<option value=\"\" selected>".pcrtlang("Show All")."</option>";
} else {
echo "<option value=\"\">".pcrtlang("Show All")."</option>";
} 

if($thewhen == "today") {
echo "<option value=\"today\" selected>".pcrtlang("Today")."</option>";
} else {
echo "<option value=\"today\">".pcrtlang("Today")."</option>";
} 

if($thewhen == "tomorrow") {
echo "<option value=\"tomorrow\" selected>".pcrtlang("Tomorrow")."</option>";
} else {
echo "<option value=\"tomorrow\">".pcrtlang("Tomorrow")."</option>";
} 

if($thewhen == "thisweek") {
echo "<option value=\"thisweek\" selected>".pcrtlang("Next 7 Days")."</option>";
} else {
echo "<option value=\"thisweek\">".pcrtlang("Next 7 Days")."</option>";
} 

if($thewhen == "pastdue") {
echo "<option value=\"pastdue\" selected>".pcrtlang("Past Due")."</option>";
} else {
echo "<option value=\"pastdue\">".pcrtlang("Past Due")."</option>";
}

if($thewhen == "thisweekandpastdue") {
echo "<option value=\"thisweekandpastdue\" selected>".pcrtlang("This Week &amp; Past Due")."</option>";
} else {
echo "<option value=\"thisweekandpastdue\">".pcrtlang("This Week &amp; Past Due")."</option>";
}


echo "</select>";


echo "<input type=submit value=\"".pcrtlang("Go")."\" class=button></form>";

echo "</td></td></tr></table>";

stop_box();

####################################


$rs_ql = "SELECT stickywide FROM users WHERE username = '$ipofpc'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$touchwide = "$rs_result_q1->stickywide";

#############
if (($thewhen == "") && ($stickytypeid == "") && ($uname == "")) {
$rs_findnotes52 = "SELECT * FROM stickynotes WHERE $storeidsql showonwall = '1'";
} else {
$rs_findnotes52 = "SELECT * FROM stickynotes WHERE $storeidsql showonwall = '1' AND ";

if ($stickytypeid != "") {
$rs_findnotes52 .= "stickytypeid = '$stickytypeid'";
}

if (($stickytypeid != "") && ($uname != "")) {
$rs_findnotes52 .= " AND ";
}

if ($uname != "") {
$rs_findnotes52 .= "stickyuser = '$uname'";
}

if (($thewhen != "") && ($uname != "")) {
$rs_findnotes52 .= " AND ";
}

if (($thewhen != "") && ($stickytypeid != "") && ($uname == "")) {
$rs_findnotes52 .= " AND ";
}


if ($thewhen != "") {

if ($thewhen == "today") {
$rs_findnotes52 .= "(DATE(stickyduedate) = DATE('$thenow'))";
} elseif ($thewhen == "tomorrow") {
$rs_findnotes52 .= " (DATE(stickyduedate) = DATE(DATE_ADD('$thenow', INTERVAL 1 DAY)))";
} elseif ($thewhen == "thisweek") {
$rs_findnotes52 .= " (DATE(stickyduedate) <= DATE(DATE_ADD('$thenow', INTERVAL 7 DAY))) AND (DATE(stickyduedate) >= DATE('$thenow'))";
} elseif ($thewhen == "thisweekandpastdue") {
$rs_findnotes52 .= " (DATE(stickyduedate) <= DATE(DATE_ADD('$thenow', INTERVAL 7 DAY)))";
} elseif ($thewhen == "pastdue") {
$rs_findnotes52 .= "(DATE(stickyduedate) < DATE('$thenow'))";
} else {
$rs_findnotes52 .= "";
}

}



}


##############

$rs_findnotes52 .= " ORDER BY stickyduedate ASC";

$rs_result_n5 = mysqli_query($rs_connect, $rs_findnotes52);
$totalpcsonbench = mysqli_num_rows($rs_result_n5);

echo "<div class=flexsticky-container>";

while($rs_result_qn5 = mysqli_fetch_object($rs_result_n5)) {
$stickyid = "$rs_result_qn5->stickyid";
$stickyaddy1 = "$rs_result_qn5->stickyaddy1";
$stickyaddy2 = "$rs_result_qn5->stickyaddy2";
$stickycity = "$rs_result_qn5->stickycity";
$stickystate = "$rs_result_qn5->stickystate";
$stickyzip = "$rs_result_qn5->stickyzip";
$stickyphone = "$rs_result_qn5->stickyphone";
$stickyemail = "$rs_result_qn5->stickyemail";
$stickyduedate = "$rs_result_qn5->stickyduedate";
$stickytypeid = "$rs_result_qn5->stickytypeid";
$stickyuser = "$rs_result_qn5->stickyuser";
$stickynote_orig = "$rs_result_qn5->stickynote";
$stickynote = nl2br($stickynote_orig);
$stickyname = "$rs_result_qn5->stickyname";
$stickycompany = "$rs_result_qn5->stickycompany";
$refid = "$rs_result_qn5->refid";
$reftype = "$rs_result_qn5->reftype";

$stickynote_ical3 = str_replace("\n", "\\n", "$stickynote_orig");
$stickynote_ical = str_replace("\r", "", "$stickynote_ical3");


$stickyaddy1_ue = urlencode($stickyaddy1);
$stickyaddy2_ue = urlencode($stickyaddy2);
$stickycity_ue = urlencode($stickycity);
$stickystate_ue = urlencode($stickystate);
$stickyzip_ue = urlencode($stickyzip);
$stickyphone_ue = urlencode($stickyphone);
$stickyemail_ue = urlencode($stickyemail);
$stickyduedate_ue = urlencode($stickyduedate);
$stickyuser_ue = urlencode($stickyuser);
$stickynote_ue = urlencode($stickynote_ical);
$stickyname_ue = urlencode($stickyname);
$stickycompany_ue = urlencode($stickycompany);

$rs_qst = "SELECT * FROM stickytypes WHERE stickytypeid = '$stickytypeid'";
$rs_resultst1 = mysqli_query($rs_connect, $rs_qst);
if(mysqli_num_rows($rs_resultst1) == "1") {
$rs_result_stq1 = mysqli_fetch_object($rs_resultst1);
$stickytypename = "$rs_result_stq1->stickytypename";
$stickybordercolor = "$rs_result_stq1->bordercolor";
$stickynotecolor = "$rs_result_stq1->notecolor";
$stickynotecolor2 = "$rs_result_stq1->notecolor2";
} else {
$stickytypename = pcrtlang("Undefined");
$stickybordercolor = "000000";
$stickynotecolor = "ffffff";
$stickynotecolor2 = "cccccc";
}

#wip

echo "<div class=\"flexsticky-item\" style=\"border:1px solid #$stickybordercolor; background:#$stickynotecolor; background: linear-gradient(to bottom, #$stickynotecolor 0%, #$stickynotecolor2 100%);\">";

echo "<div style=\"background:#$stickybordercolor;padding:5px;margin:-5px;\"><span class=\"colormewhite sizemelarge boldme\">$stickytypename</span><br><span class=\"colormewhite boldme\">$stickyname<span></div>";


#####

echo "<a href=\"javascript:void(0);\" class=\"linkbuttonsmall linkbuttonopaque radiusall floatright\" id=link$stickyid style=\"margin-top:10px;\"><i class=\"fa fa-chevron-down\"></i></a>";

echo "<div id=stickylinkbox$stickyid style=\"display:none; border-bottom:#$stickybordercolor 2px solid;margin:-5px; text-align:center;\"><br>";

echo "<br><a href=sticky.php?func=ical&stickyid=$stickyid&stickyaddy1=$stickyaddy1_ue&stickyaddy2=$stickyaddy2_ue&stickycity=$stickycity_ue&stickystate=
$stickystate_ue&stickyzip=$stickyzip_ue&stickyphone=$stickyphone_ue&stickyemail=$stickyemail_ue&stickyduedate=$stickyduedate_ue&stickyuser=$stickyuser_ue
&stickynote=$stickynote_ue&stickyname=$stickyname_ue&stickycompany=$stickycompany_ue class=\"linkbuttonsmall linkbuttonopaque radiusall\">
<i class=\"fa fa-calendar-plus-o fa-lg\"></i> ".pcrtlang("iCal")."</a><br>";

if ((perm_check("19")) || ("$stickyuser" == "$ipofpc") || ("$stickyuser" == "none")) {
echo "<a href=sticky.php?func=deletesticky&stickyid=$stickyid&showwhat=stickywall  onClick=\"return confirm('".pcrtlang("Are you sure you wish to permanently
delete this Sticky Note!!!?")."');\" class=\"linkbuttonsmall linkbuttonopaque radiusleft\"><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")."</a>";
}

if ((perm_check("20")) || ("$stickyuser" == "$ipofpc") || ("$stickyuser" == "none")) {
echo "<a href=sticky.php?func=editsticky&stickyid=$stickyid&showwhat=stickywall $therel class=\"linkbuttonsmall linkbuttonopaque radiusright\">
<i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("Edit")."</a>";
}

echo "<br>";
echo "<a href=sticky.php?func=changewall&stickyid=$stickyid&showwhat=stickywall&showonwall=0 class=\"linkbuttonsmall linkbuttonopaque radiusleft\">
<i class=\"fa fa-minus-square fa-lg\"></i> ".pcrtlang("Remove from Wall")."</a>";
echo "<a href=sticky.php?func=printsticky&stickyid=$stickyid class=\"linkbuttonsmall linkbuttonopaque radiusright\"><i class=\"fa fa-print fa-lg\">
</i> ".pcrtlang("Print")."</a><br><br>";

echo "<form action=pc.php?func=addpc method=post>
<input type=hidden name=pcaddress value=\"$stickyaddy1\">
<input type=hidden name=pcaddress2 value=\"$stickyaddy2\">
<input type=hidden name=pccity value=\"$stickycity\">
<input type=hidden name=pcstate value=\"$stickystate\">
<input type=hidden name=pczip value=\"$stickyzip\">
<input type=hidden name=pcphone value=\"$stickyphone\">
<input type=hidden name=pcemail value=\"$stickyemail\">
<input type=hidden name=pcproblem value=\"$stickynote_orig\">
<input type=hidden name=pcname value=\"$stickyname\">
<input type=hidden name=pccompany value=\"$stickycompany\">
<button class=\"linkbuttonopaque linkbuttonsmall radiusall\"><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("New Check-in")."</button></form><br>";


echo "</div>";

?>
<script type='text/javascript'>
$('#link<?php echo $stickyid; ?>').click(function(){
  $('#stickylinkbox<?php echo $stickyid; ?>').toggle('1000');
  $("i",this).toggleClass("fa-chevron-up fa-chevron-down");
});
</script>
<?php

####



if("$stickycompany" != "") {
echo "<br><span style=\"color:#$stickybordercolor;\">$stickycompany</span><br>";
}

$stickynote2 = preg_replace('/([a-zA-Z]{30})(?![^a-zA-Z])/', '$1 ', $stickynote);

echo "<br><span style=\"color:#$stickybordercolor;\">$stickynote2</span><br>";

$stickyduedate2 = date("M j, Y, g:i a",strtotime($stickyduedate));
echo "<br><span class=\"sizemesmaller\" style=\"color:#$stickybordercolor;\">".pcrtlang("Date/Due Date").": $stickyduedate2</span>";

if ($stickyuser != "none") {
echo "<br><span class=\"sizemesmaller\" style=\"color:#$stickybordercolor;\">".pcrtlang("Assigned To").": $stickyuser</span>";
}

if ($stickyaddy1 != "") {
echo "<br><span class=\"sizemesmaller\" style=\"color:#$stickybordercolor;\">$stickyaddy1</span>";
}

if ($stickyaddy2 != "") {
echo "<br><span class=\"sizemesmaller\" style=\"color:#$stickybordercolor;\">$stickyaddy2</span>";
}

if (($stickycity != "") || ($stickystate != "") || ($stickyzip != "")){
echo "<br><span class=\"sizemesmaller\" style=\"color:#$stickybordercolor;\">$stickycity, $stickystate $stickyzip</span>";
}

if ($stickyphone != "") {
echo "<br><span class=\"sizemesmaller\" style=\"color:#$stickybordercolor;\">$stickyphone</span>";
}

if ($stickyemail != "") {
echo "<br><a href=\"mailto:$stickyemail\" class=\"linkbuttontiny linkbuttonopaque radiusall\"><i class=\"fa fa-envelope fa-lg\"></i> $stickyemail</a><br>";
}

if ($refid != "0") {

if ($reftype == "woid") {
echo "<br><a href=\"index.php?pcwo=$refid\" class=\"linkbuttontiny linkbuttonopaque radiusall\"><i class=\"fa fa-clipboard fa-lg\"></i> ".pcrtlang("Work Order")." #$refid</a>";
} elseif ($reftype == "pcid") {
echo "<br><a href=\"pc.php?func=showpc&pcid=$refid\" class=\"linkbuttontiny linkbuttonopaque radiusall\"><i class=\"fa fa-tag fa-lg\"></i> ".pcrtlang("PCID")." #$refid</a>";
} elseif ($reftype == "groupid") {
echo "<br><a href=\"group.php?func=viewgroup&pcgroupid=$refid\" class=\"linkbuttontiny linkbuttonopaque radiusall\"><i class=\"fa fa-group fa-lg\"></i> ".pcrtlang("Group ID")." #$refid</a>";
}



}





echo "</div>";


}

echo "</div>";

#start of calendar
} else {

echo "<script type=\"text/javascript\">document.title = \"".pcrtlang("Sticky Calendar")."\";</script>";

if (array_key_exists('month', $_REQUEST)) {
$month = $_REQUEST['month'];
} else {
$month = date('m');
}

if( array_key_exists('year', $_REQUEST)) {
$year = $_REQUEST['year'];
} else {
$year = date('Y');
}



$date = mktime(12, 0, 0, $month, 1, $year);


$previousmonth = date('m', strtotime("-1 month", $date));
$previousyear = date('Y', strtotime("-1 month", $date));
$nextmonth = date('m', strtotime("1 month", $date));
$nextyear = date('Y', strtotime("1 month", $date));

    $daysInMonth = date("t", $date);

if(!isset($pcrt_weekstart)) {
$pcrt_weekstart = "Sunday";
}

if ($pcrt_weekstart == "Sunday") {
    $offset = date("w", $date);
} else {
    $offset = date("w", $date);  // -1 or +6 
}


    $rows = 1;

start_box();
echo "<table width=100%><tr><td width=70%><a href=sticky.php?func=addsticky&showwhat=calendar&month=$month&year=$year $therel class=\"linkbuttonmedium linkbuttongray radiusleft\"><img src=images/stickyadd.png class=iconmedium> ".pcrtlang("Add Sticky")."</a>";
echo "<a href=stickydisplay.php?showwhat=stickywall class=\"linkbuttonmedium linkbuttongray\"><img src=images/sticky.png class=iconmedium> ".pcrtlang("Sticky Wall")."</a>";

echo "<a href=sticky.php?func=stickybrowse class=\"linkbuttonmedium linkbuttongray radiusright\"><img src=images/sticky.png class=iconmedium> ".pcrtlang("Browse All Sticky Notes")."</a>";


$phpself = $_SERVER['PHP_SELF'];

echo "<form action=\"$phpself\" method=post>";

echo "<br>".pcrtlang("Who").":";

echo "<input type=hidden name=showwhat value=\"calendar\"><input type=hidden name=month value=\"$month\"><input type=hidden name=year value=\"$year\">";
$rs_find_users = "SELECT * FROM users WHERE username != 'admin'";
$rs_result_users = mysqli_query($rs_connect, $rs_find_users);
echo "<select name=uname onchange='this.form.submit()'>";
if($uname == "") {
echo "<option value=\"\" selected>".pcrtlang("Show All")."</option>";
} else {
echo "<option value=\"\">".pcrtlang("Show All")."</option>";
}

while($rs_result_uq = mysqli_fetch_object($rs_result_users)) {
$rs_uname = "$rs_result_uq->username";
if($rs_uname == "$uname") {
echo "<option value=$rs_uname selected>$rs_uname</option>";
} else {
echo "<option value=$rs_uname>$rs_uname</option>";
}
}
echo "</select>";
echo "&nbsp;&nbsp;".pcrtlang("Note Type").":";

$rs_find_stickytypes = "SELECT * FROM stickytypes";
$rs_result_stickytypes = mysqli_query($rs_connect, $rs_find_stickytypes);
echo "<select name=stickytypeid onchange='this.form.submit()'>";
if($stickytypeid == "") {
echo "<option value=\"\" selected>".pcrtlang("Show All")."</option>";
} else {
echo "<option value=\"\">".pcrtlang("Show All")."</option>";
}


while($rs_result_sq = mysqli_fetch_object($rs_result_stickytypes)) {
$rs_stname = "$rs_result_sq->stickytypename";
$rs_stid = "$rs_result_sq->stickytypeid";
if ($stickytypeid == $rs_stid) {
echo "<option value=$rs_stid selected>$rs_stname</option>";
} else {
echo "<option value=$rs_stid>$rs_stname</option>";
}
}
echo "</select>";

$storeoptions2 = "";
if ($activestorecount > 1) {
$rs_find_stores = "SELECT * FROM stores WHERE storeenabled = '1' ORDER BY storesname ASC";
$rs_result_stores = mysqli_query($rs_connect, $rs_find_stores);
$storeoptions2 .= "<select name=stickystoreid onchange='this.form.submit()'>";
while($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
$rs_storesname = "$rs_result_storeq->storesname";
$rs_storeid = "$rs_result_storeq->storeid";
if ($rs_storeid == $stickystoreid) {
$storeoptions2 .= "<option selected value=$rs_storeid>$rs_storesname</option>";
} else {
$storeoptions2 .= "<option value=$rs_storeid>$rs_storesname</option>";
}
} 
if("$stickystoreid" == "all") { 
$storeoptions2 .= "<option selected value=all>".pcrtlang("All Stores")."</option>";
} else {
$storeoptions2 .= "<option value=all>".pcrtlang("All Stores")."</option>";
}
$storeoptions2 .= "</select><br>";
} else {
$storeoptions2 = "<input type=hidden name=stickystoreid value=\"$defaultuserstore\">";
}


if ($activestorecount > 1) {
echo "<br>".pcrtlang("Store").":";
}

echo "$storeoptions2";


echo "</form>";




echo "</td><td width=30%>";
echo "<table style=\"margin:auto;\"><tr><td style=\"text-align:center\">";

echo "<span class=\"sizeme16 boldme\">".pcrtlang("Sticky Calendar")."</span><br><br>";

echo "<a href=stickydisplay.php?showwhat=calendar&month=$previousmonth&year=$previousyear&stickytypeid=$stickytypeid&uname=$uname class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-left fa-lg\"></i></a>";
echo " <span class=sizemelarger>" . pcrtlang(date("F", $date)) . date(" Y", $date) . "</span> ";
echo "<a href=stickydisplay.php?showwhat=calendar&month=$nextmonth&year=$nextyear&stickytypeid=$stickytypeid&uname=$uname class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-right fa-lg\"></i></a>";
echo "<br><br></td></tr></table></td></tr></table>\n";
stop_box();

    echo "<table class=cal>\n";
if ($pcrt_weekstart == "Sunday") {
    echo "\t<tr><th>".pcrtlang("Sunday")."</th><th>".pcrtlang("Monday")."</th><th>".pcrtlang("Tuesday")."</th><th>".pcrtlang("Wednesday")."</th><th>".pcrtlang("Thursday")."</th><th>".pcrtlang("Friday")."</th><th>".pcrtlang("Saturday")."</th></tr>";
} else {
    echo "\t<tr><th>".pcrtlang("Monday")."</th><th>".pcrtlang("Tuesday")."</th><th>".pcrtlang("Wednesday")."</th><th>".pcrtlang("Thursday")."</th><th>".pcrtlang("Friday")."</th><th>".pcrtlang("Saturday")."</th><th>".pcrtlang("Sunday")."</th></tr>";
}

    echo "\n\t<tr>";

if ($pcrt_weekstart == "Sunday") {
    for($i = 1; $i <= $offset; $i++)
    {
        echo "<th style=\"width:14%;\"></th>";
    }
} else {  // monday start
if($offset == 0) {
    for($i = -5; $i <= $offset; $i++)
    {
        echo "<th style=\"width:14%;\"></th>";
    }
} else {
    for($i = 2; $i <= $offset; $i++)
    {
     	echo "<th style=\"width:14%;\"></th>";
    }
}


}


    for($day = 1; $day <= $daysInMonth; $day++)
    {


if ($pcrt_weekstart == "Sunday") {
        if( ($day + $offset - 1) % 7 == 0 && $day != 1)
        {
            echo "</tr>\n\t<tr>";
            $rows++;
        }
} else {  // monday start
if($offset == 0) {
        if( ($day + $offset -2) % 7 == 0 && $day != 1)
        {
            echo "</tr>\n\t<tr>";
            $rows++;
        }
} else {
        if( ($day + $offset - 2) % 7 == 0 && $day != 1)
        {
            echo "</tr>\n\t<tr>";
            $rows++;
        }

}

}


#highlighted date
if (($day == date('j')) && (date('m') == $month) && ($year == date('Y'))) {
        echo "<td style=\"width:14%; box-shadow: 0 0 5px #0090FF; border: 1px solid #0090FF; background:#DDEDFF;\">";
} else {
   echo "<td style=\"width:14%; vertical-align:top;\">";
}


if (strlen($day) == 1) {
$setday = "0$day";
} else {
$setday = $day;
}

$thedatesn = date('Y-m-d H:i:s', strtotime("$year-$month-$day 12:00:00"));
echo "<a href=sticky.php?func=addsticky&setday=$setday&setmonth=$month&setyear=$year&showwhat=calendar&month=$month&year=$year $therel class=\"linkbuttonsmall linkbuttongray radiusall\">$day</a>";

if (($stickytypeid == "") && ($uname == "")) {
$rs_findnotes52 = "SELECT * FROM stickynotes WHERE $storeidsql (DATE(stickyduedate) = DATE('$thedatesn')) ORDER BY stickyduedate";
} else {
$rs_findnotes52 = "SELECT * FROM stickynotes WHERE $storeidsql (DATE(stickyduedate) = DATE('$thedatesn')) AND ";

if ($stickytypeid != "") {
$rs_findnotes52 .= "stickytypeid = '$stickytypeid'";
}

if (($stickytypeid != "") && ($uname != "")) {
$rs_findnotes52 .= " AND ";
}

if ($uname != "") {
$rs_findnotes52 .= "stickyuser = '$uname'";
}

$rs_findnotes52 .= " ORDER BY stickyduedate ASC";
}


$rs_result_n5 = mysqli_query($rs_connect, $rs_findnotes52);
if(mysqli_num_rows($rs_result_n5) == '0') {
echo "";
}

while($rs_result_qn5 = mysqli_fetch_object($rs_result_n5)) {
$stickyid = "$rs_result_qn5->stickyid";
$stickyaddy1 = "$rs_result_qn5->stickyaddy1";
$stickyaddy2 = "$rs_result_qn5->stickyaddy2";
$stickycity = "$rs_result_qn5->stickycity";
$stickystate = "$rs_result_qn5->stickystate";
$stickyzip = "$rs_result_qn5->stickyzip";
$stickyphone = "$rs_result_qn5->stickyphone";
$stickyemail = "$rs_result_qn5->stickyemail";
$stickyduedate = "$rs_result_qn5->stickyduedate";
$stickytypeid2 = "$rs_result_qn5->stickytypeid";
$stickyuser = "$rs_result_qn5->stickyuser";
$stickynote = "$rs_result_qn5->stickynote";
$stickyname = "$rs_result_qn5->stickyname";
$stickycompany = "$rs_result_qn5->stickycompany";
$refid = "$rs_result_qn5->refid";
$reftype = "$rs_result_qn5->reftype";
$showonwall = "$rs_result_qn5->showonwall";

$rs_qst = "SELECT * FROM stickytypes WHERE stickytypeid = '$stickytypeid2'";
$rs_resultst1 = mysqli_query($rs_connect, $rs_qst);
if(mysqli_num_rows($rs_resultst1) == "1") {
$rs_result_stq1 = mysqli_fetch_object($rs_resultst1);
$stickytypename = "$rs_result_stq1->stickytypename";
$stickybordercolor = "$rs_result_stq1->bordercolor";
$stickynotecolor = "$rs_result_stq1->notecolor";
$stickynotecolor2 = "$rs_result_stq1->notecolor2";
} else {
$stickytypename = "Undefined";
$stickybordercolor = "000000";
$stickynotecolor = "ffffff";
$stickynotecolor2 = "cccccc";
}


echo "<div id=\"$stickyid\" style=\"display:none;\"><table style=\"width:400px;margin-left:auto; margin-right:auto;\" align=center><tr><td>";
start_box_sn($stickynotecolor,$stickynotecolor2,$stickybordercolor);

echo "<span class=boldme style=\"color:#$stickybordercolor\">$stickytypename: $stickyname</span>";
if("$stickyname" != "") {
echo "<br><span style=\"color:#$stickybordercolor\">$stickycompany</span>";
}
echo "<br><br><span class=boldme style=\"color:#$stickybordercolor\">$stickynote</span><br>";

$stickyduedate2 = date("M j, Y, g:i a",strtotime($stickyduedate));
echo "<br><span class=\"sizemesmaller\" style=\"color:#$stickybordercolor\">".pcrtlang("Date/Due Date").": $stickyduedate2</span>";

if ($stickyuser != "none") {
echo "<br><span class=\"sizemesmaller\" style=\"color:#$stickybordercolor\">".pcrtlang("Assigned To").": $stickyuser</span>";
}

if ($stickyaddy1 != "") {
echo "<br><span class=\"sizemesmaller\" style=\"color:#$stickybordercolor\">$stickyaddy1</span>";
}

if ($stickyaddy2 != "") {
echo "<br><span class=\"sizemesmaller\" style=\"color:#$stickybordercolor\">$stickyaddy2</span>";
}

if (($stickycity != "") || ($stickystate != "") || ($stickyzip != "")){
echo "<br><span class=\"sizemesmaller\" style=\"color:#$stickybordercolor\">$stickycity, $stickystate $stickyzip</span>";
}

if ($stickyphone != "") {
echo "<br><span class=\"sizemesmaller\" style=\"color:#$stickybordercolor\">$stickyphone</span>";
}
if ($stickyemail != "") {
echo "<br><a href=\"mailto:$stickyemail\" style=\"color:#$stickybordercolor\">$stickyemail</a>";
}

if ($refid != "0") {
if ($reftype == "woid") {
echo "<br><a href=\"index.php?pcwo=$refid\">".pcrtlang("Work Order")." #$refid</a>";
} elseif ($reftype == "pcid") {
echo "<br><a href=\"pc.php?func=showpc&pcid=$refid\">".pcrtlang("PCID")." #$refid</a>";
} elseif ($reftype == "groupid") {
echo "<br><a href=\"group.php?func=viewgroup&pcgroupid=$refid\">".pcrtlang("Group ID")." #$refid</a>";
}




}


$stickyaddy12 = urlencode($stickyaddy1);
$stickyaddy22 = urlencode($stickyaddy2);
$stickycity2 = urlencode($stickycity);
$stickystate2 = urlencode($stickystate);
$stickyzip2 = urlencode($stickyzip);
$stickyphone2 = urlencode($stickyphone);
$stickyemail2 = urlencode($stickyemail);
$stickynote2 = urlencode($stickynote);
$stickyname2 = urlencode($stickyname);
$stickycompany2 = urlencode($stickycompany);

echo "<br><a href=\"pc.php?func=addpc&pcaddress=$stickyaddy12&pcaddress2=$stickyaddy22&pccity=$stickycity2&pcstate=$stickystate2&pczip=$stickyzip2&pcphone=$stickyphone2&pcemail=$stickyemail2&pcproblem=$stickynote2&pcname=$stickyname2&pccompany=$stickycompany2\">".pcrtlang("New Check-in")."</a>";

stop_box();
echo "</td></tr></table>";

echo "</div>";




$duetime = date("g:i a", strtotime($stickyduedate));

start_box_sn($stickynotecolor,$stickynotecolor2,$stickybordercolor);
if(strlen($stickynote) > 40) {
$stickynote2 = mb_substr("$stickynote", 0, 40, "utf-8")." ...";
} else {
$stickynote2 = $stickynote;
}
echo "<a href=#$stickyid rel=facebox class=\"linkbuttontiny linkbuttonopaque radiusall displayblock\">$stickyname</a><br><span class=\"sizemesmaller\" style=\"color:#$stickybordercolor\">$stickynote2<br>$duetime";
if ($stickyuser != "none") {
echo "<br>tech: $stickyuser";
}
echo "</span><br>";

if ((perm_check("19")) || ("$stickyuser" == "$ipofpc") || ("$stickyuser" == "none")) {
echo "<a href=sticky.php?func=deletesticky&stickyid=$stickyid&showwhat=calendar&month=$month&year=$year  onClick=\"return confirm('".pcrtlang("Are you sure you wish to permanently delete this Sticky Note!!!?")."');\" class=\"linkbuttontiny linkbuttonopaque\"><i class=\"fa fa-trash fa-lg\"></i></a>";
}

if ((perm_check("20")) || ("$stickyuser" == "$ipofpc") || ("$stickyuser" == "none")) {
echo "<a href=sticky.php?func=editsticky&stickyid=$stickyid&showwhat=calendar&month=$month&year=$year $therel class=\"linkbuttontiny linkbuttonopaque\"><i class=\"fa fa-edit fa-lg\"></i></a>";
}

echo "<a href=sticky.php?func=printsticky&stickyid=$stickyid class=\"linkbuttontiny linkbuttonopaque\"><i class=\"fa fa-print fa-lg\"></i></a>";

if ($showonwall == 0) {
echo "<br><a href=sticky.php?func=changewall&stickyid=$stickyid&showwhat=stickywall&showonwall=1 class=smalllink>".pcrtlang("Show on Wall")."</a>";
}

stop_box();

}

## wo here

if ($uname == "") {
$rs_findwo = "SELECT * FROM pc_wo WHERE sked = '1' AND pcstatus != '7' AND pcstatus != '6' AND pcstatus != '5' AND pcstatus != '4' AND $storeidsql (DATE(skeddate) = DATE('$thedatesn')) ORDER BY skeddate";
} else {
$rs_findwo = "SELECT * FROM pc_wo WHERE sked = '1' AND pcstatus != '7' AND pcstatus != '6' AND pcstatus != '5' AND pcstatus != '4' AND $storeidsql (DATE(skeddate) = DATE('$thedatesn')) ";

if ($uname != "") {
$rs_findwo .= "AND assigneduser = '$uname'";
}

$rs_findwo .= " ORDER BY skeddate ASC";
}

$rs_result_wo = mysqli_query($rs_connect, $rs_findwo);

if((mysqli_num_rows($rs_result_n5) == '0') && (mysqli_num_rows($rs_result_wo) == '0')) {
echo "<br><br><br>";
}


while($rs_result_q = mysqli_fetch_object($rs_result_wo)) {
$pcid = "$rs_result_q->pcid";
$woid = "$rs_result_q->woid";
$probdesc = mb_substr("$rs_result_q->probdesc", 0, 50, "utf-8")."...";
$pcstatus = "$rs_result_q->pcstatus";
$skeddate = "$rs_result_q->skeddate";

$boxstyle = getboxstyle($pcstatus);

$rs_findowner = "SELECT pcname,pcmake,pccompany FROM pc_owner WHERE pcid = '$pcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
$rs_result_q2 = mysqli_fetch_object($rs_result2);
$pcname = "$rs_result_q2->pcname";
$pcmake = "$rs_result_q2->pcmake";
$pccompany = "$rs_result_q2->pccompany";

$thedatewo = date('g:i A', strtotime("$skeddate"));

echo "<div style=\"background:#$boxstyle[selectorcolor]; text-align:left; padding:2px;\"><span class=\"colormewhite sizemesmaller\">$pcname</span></div>";
echo "<div style=\"background:#ffffff; border-right:#aaaaaa 1px solid;border-left:#aaaaaa 1px solid;border-bottom:#aaaaaa 1px solid;text-align:left;padding:2px;\"><span class=\"sizemesmaller\">$probdesc</span>";

echo "<br><span class=sizemesmaller>$thedatewo</span>";
echo "<br><a href=index.php?pcwo=$woid class=\"linkbuttontiny linkbuttongray radiusall\">WO# $woid</a><br>";
echo "</div>";


}


###






echo "</td>";
    }

if ($pcrt_weekstart == "Sunday") {
    while( ($day + $offset) <= $rows * 7)
    {
        echo "<th style=\"width:14%;\"></th>";
        $day++;
    }
} else {  //monday start
if($offset == 0) {
    while( ($day + $offset + 6) <= $rows * 7)
    {
        echo "<th style=\"width:14%;\"></th>";
        $day++;
    }
} else {
    while( ($day + $offset - 1) <= $rows * 7)
    {
        echo "<th style=\"width:14%;\"></th>";
        $day++;
    }

}



}

    echo "</tr>\n";
    echo "</table>\n";



}


require_once("footer.php");
