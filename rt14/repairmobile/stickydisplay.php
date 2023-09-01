<?php

require("validate.php");

require("deps.php");
require_once("common.php");

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
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

echo "<button type=button onClick=\"parent.location='sticky.php?func=addsticky'\"><img src=../repair/images/stickyadd.png align=absmiddle> ".pcrtlang("Add New Sticky")."</button>";

$phpself = $_SERVER['PHP_SELF'];


echo "<div data-role=\"collapsible\" data-theme=\"b\">";
echo "<h3>".pcrtlang("Switch View")."</h3>";

echo "<form action=\"$phpself\" method=post><input type=hidden name=stickystoreid value=\"$defaultuserstore\">";


$rs_find_users = "SELECT * FROM users WHERE username != 'admin'";
$rs_result_users = mysqli_query($rs_connect, $rs_find_users);
echo "<select name=uname onchange='this.form.submit()'>";
if($uname == "") {
echo "<option value=\"\" selected data-placeholder=\"false\">".pcrtlang("User").": ".pcrtlang("Show All")."</option>";
} else {
echo "<option value=\"\" data-placeholder=\"false\">".pcrtlang("Show All")."</option>";
}

while($rs_result_uq = mysqli_fetch_object($rs_result_users)) {
$rs_uname = "$rs_result_uq->username";
if($rs_uname == "$uname") {
echo "<option value=$rs_uname selected>".pcrtlang("User").": $rs_uname</option>";
} else {
echo "<option value=$rs_uname>$rs_uname</option>";
}
}
echo "</select>";


$rs_find_stickytypes = "SELECT * FROM stickytypes";
$rs_result_stickytypes = mysqli_query($rs_connect, $rs_find_stickytypes);
echo "<select name=stickytypeid onchange='this.form.submit()'>";
if($stickytypeid == "") {
echo "<option value=\"\" selected data-placeholder=\"false\">".pcrtlang("Note Type").": ".pcrtlang("Show All")."</option>";
} else {
echo "<option value=\"\" data-placeholder=\"false\">".pcrtlang("Show All")."</option>";
}


while($rs_result_sq = mysqli_fetch_object($rs_result_stickytypes)) {
$rs_stname = "$rs_result_sq->stickytypename";
$rs_stid = "$rs_result_sq->stickytypeid";
if ($stickytypeid == $rs_stid) {
echo "<option value=$rs_stid selected>".pcrtlang("Note Type").": $rs_stname</option>";
} else {
echo "<option value=$rs_stid>$rs_stname</option>";
}
}
echo "</select>";



echo "<select name=thewhen onchange='this.form.submit()'>";
if($thewhen == "") {
echo "<option value=\"\" selected data-placeholder=\"false\">".pcrtlang("Date").": ".pcrtlang("Show All")."</option>";
} else {
echo "<option value=\"\" data-placeholder=\"false\">".pcrtlang("Show All")."</option>";
} 

if($thewhen == "today") {
echo "<option value=\"today\" selected>".pcrtlang("Date").": ".pcrtlang("Today")."</option>";
} else {
echo "<option value=\"today\">".pcrtlang("Today")."</option>";
} 

if($thewhen == "tomorrow") {
echo "<option value=\"tomorrow\" selected>".pcrtlang("Date").": ".pcrtlang("Tomorrow")."</option>";
} else {
echo "<option value=\"tomorrow\">".pcrtlang("Tomorrow")."</option>";
} 

if($thewhen == "thisweek") {
echo "<option value=\"thisweek\" selected>".pcrtlang("Date").": ".pcrtlang("Next 7 Days")."</option>";
} else {
echo "<option value=\"thisweek\">".pcrtlang("Next 7 Days")."</option>";
} 

if($thewhen == "pastdue") {
echo "<option value=\"pastdue\" selected>".pcrtlang("Date").": ".pcrtlang("Past Due")."</option>";
} else {
echo "<option value=\"pastdue\">".pcrtlang("Past Due")."</option>";
}

if($thewhen == "thisweekandpastdue") {
echo "<option value=\"thisweekandpastdue\" selected>".pcrtlang("Date").": ".pcrtlang("This Week &amp; Past Due")."</option>";
} else {
echo "<option value=\"thisweekandpastdue\">".pcrtlang("This Week &amp; Past Due")."</option>";
}


echo "</select>";


echo "<input type=submit value=\"".pcrtlang("Go")."\" class=button></form>";

echo "</div>";

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



start_box_sn($stickynotecolor,$stickynotecolor2,$stickybordercolor);

echo "<h3 style=\"color:#$stickybordercolor;\">$stickytypename: $stickyname</h3>";
if("$stickycompany" != "") {
echo "<font style=\"color:#$stickybordercolor;\">$stickycompany</font>";
}

$stickynote2 = preg_replace('/([a-zA-Z]{30})(?![^a-zA-Z])/', '$1 ', $stickynote);

echo "<br>$stickynote2<br>";

$stickyduedate2 = date("M j, Y, g:i a",strtotime($stickyduedate));
echo "<br>".pcrtlang("Date/Due Date").": $stickyduedate2";

if ($stickyuser != "none") {
echo "<br>".pcrtlang("Assigned To").": $stickyuser";
}

if ($stickyaddy1 != "") {
echo "<br>$stickyaddy1";
}

if ($stickyaddy2 != "") {
echo "<br>$stickyaddy2";
}

if (($stickycity != "") || ($stickystate != "") || ($stickyzip != "")){
echo "<br>$stickycity, $stickystate $stickyzip";
}

if ($stickyphone != "") {
echo "<br>$stickyphone";
}


echo "<div data-role=\"collapsible\" data-theme=\"a\">";
echo "<h3>".pcrtlang("Note Actions")."</h3>";

if ($stickyemail != "") {
echo "<button type=button onClick=\"parent.location='mailto:$stickyemail'\">$stickyemail</button>";
}

if ($refid != "0") {

if ($reftype == "woid") {
echo "<button type=button onClick=\"parent.location='index.php?pcwo=$refid'\">".pcrtlang("Work Order")." #$refid</button>";
} elseif ($reftype == "pcid") {
echo "<button type=button onClick=\"parent.location='pc.php?func=showpc&pcid=$refid'\">".pcrtlang("PCID")." #$refid</button>";
} elseif ($reftype == "groupid") {
echo "<button type=button onClick=\"parent.location='group.php?func=viewgroup&pcgroupid=$refid\">".pcrtlang("Group ID")." #$refid</button>";
}

}



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
<button type=submit><i class=\"fa fa-reply fa-lg\"></i> New Check-in</button></form>";



if ((perm_check("19")) || ("$stickyuser" == "$ipofpc") || ("$stickyuser" == "none")) {
echo "<a href=\"#popupdeletesn$stickyid\" data-rel=\"popup\" data-position-to=\"window\" data-transition=\"pop\" class=\"ui-btn ui-shadow ui-corner-all\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete Note")."</a>";
echo "<div data-role=\"popup\" id=\"popupdeletesn$stickyid\" data-overlay-theme=\"b\"  data-theme=\"a\" data-dismissible=\"false\">";
echo "<div data-role=\"header\" data-theme=\"b\">";
echo "<h1>".pcrtlang("Delete Note")."?</h1>";
echo "</div>";
echo "<div role=\"main\" class=\"ui-content\">";
echo "<p>".pcrtlang("Are you sure you wish to permanently delete this sticky note?")."</p>";
echo "<div align=\"right\"><a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\" data-inline=\"true\"><i class=\"fa fa-ban fa-lg\"></i>  ".pcrtlang("Cancel")."</a>";
echo "<button onClick=\"parent.location='sticky.php?func=deletesticky&stickyid=$stickyid&showwhat=stickywal'\" data-inline=\"true\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")." </button></div>";
echo "</div>";
echo "</div>";
}


if ((perm_check("20")) || ("$stickyuser" == "$ipofpc") || ("$stickyuser" == "none")) {
echo "<button type=button onClick=\"parent.location='sticky.php?func=editsticky&stickyid=$stickyid&showwhat=stickywall'\"><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("Edit")."</button>";
}

echo "<button type=button onClick=\"parent.location='sticky.php?func=changewall&stickyid=$stickyid&showwhat=stickywall&showonwall=0'\"><i class=\"fa fa-times fa-lg\"></i> ".pcrtlang("Remove from Wall")."</button>";
echo "<button type=button onClick=\"parent.location='sticky.php?func=printsticky&stickyid=$stickyid'\"><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Print")."</button>";

echo "</div>";

stop_box();
echo "<br>";

}



#start of calendar
} else {


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

echo "<button type=button onClick=\"parent.location='sticky.php?func=addsticky&showwhat=calendar&month=$month&year=$year'\"><img src=../repair/images/stickyadd.png align=absmiddle> ".pcrtlang("Add New Sticky")."</button>";


$phpself = $_SERVER['PHP_SELF'];

echo "<div data-role=\"collapsible\" data-theme=\"b\">";
echo "<h3>".pcrtlang("Switch View")."</h3>";

echo "<form action=\"$phpself\" method=post>";
echo "<input type=hidden name=showwhat value=\"calendar\"><input type=hidden name=month value=\"$month\"><input type=hidden name=year value=\"$year\">";
$rs_find_users = "SELECT * FROM users WHERE username != 'admin'";
$rs_result_users = mysqli_query($rs_connect, $rs_find_users);
echo "<select name=uname onchange='this.form.submit()'>";
if($uname == "") {
echo "<option value=\"\" selected data-placeholder=\"false\">".pcrtlang("User").": ".pcrtlang("Show All")."</option>";
} else {
echo "<option value=\"\" data-placeholder=\"false\">".pcrtlang("Show All")."</option>";
}

while($rs_result_uq = mysqli_fetch_object($rs_result_users)) {
$rs_uname = "$rs_result_uq->username";
if($rs_uname == "$uname") {
echo "<option value=$rs_uname selected>".pcrtlang("User").": $rs_uname</option>";
} else {
echo "<option value=$rs_uname>$rs_uname</option>";
}
}
echo "</select>";

$rs_find_stickytypes = "SELECT * FROM stickytypes";
$rs_result_stickytypes = mysqli_query($rs_connect, $rs_find_stickytypes);
echo "<select name=stickytypeid onchange='this.form.submit()'>";
if($stickytypeid == "") {
echo "<option value=\"\" selected data-placeholder=\"false\">".pcrtlang("Note Type").": ".pcrtlang("Show All")."</option>";
} else {
echo "<option value=\"\" data-placeholder=\"false\">".pcrtlang("Show All")."</option>";
}


while($rs_result_sq = mysqli_fetch_object($rs_result_stickytypes)) {
$rs_stname = "$rs_result_sq->stickytypename";
$rs_stid = "$rs_result_sq->stickytypeid";
if ($stickytypeid == $rs_stid) {
echo "<option value=$rs_stid selected>".pcrtlang("Note Type").": $rs_stname</option>";
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



echo "<input type=hidden name=stickystoreid value=\"$defaultuserstore\">";

echo "<input type=submit value=\"".pcrtlang("Go")."\" class=button>";

echo "</form>";
echo "</div>";



echo "<table style=\"margin:auto;\"><tr><td>";
echo "<button type=button onClick=\"parent.location='index.php?showwhat=calendar&month=$previousmonth&year=$previousyear&stickytypeid=$stickytypeid&uname=$uname'\" class=\"ui-btn-inline\"><i class=\"fa fa-chevron-circle-left fa-lg\"></i></button>";
echo "</td><td>&nbsp;&nbsp;&nbsp;&nbsp;<h3> " . pcrtlang(date("F", $date)) . date(" Y", $date) . " </h3>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>";
echo "<button type=button onClick=\"parent.location='index.php?showwhat=calendar&month=$nextmonth&year=$nextyear&stickytypeid=$stickytypeid&uname=$uname'\" class=\"ui-btn-inline\"><i class=\"fa fa-chevron-circle-right fa-lg\"></i></button>";
echo "</td></tr></table>\n";

    echo "<table style=\"width:100%;\" class=scalendar>\n";
if ($pcrt_weekstart == "Sunday") {
    echo "\t<tr><th><font class=text14b>".pcrtlang("Sun")."</font></th><th><font class=text14b>".pcrtlang("Mon")."</font></th><th><font class=text14b>".pcrtlang("Tue")."</font></th><th><font class=text14b>".pcrtlang("Wed")."</font></th><th><font class=text14b>".pcrtlang("Thur")."</font></th><th><font class=text14b>".pcrtlang("Fri")."</font></th><th><font class=text14b>".pcrtlang("Sat")."</font></th></tr>";
} else {
    echo "\t<tr><th><font class=text14b>".pcrtlang("Mon")."</font></th><th><font class=text14b>".pcrtlang("Tue")."</font></th><th><font class=text14b>".pcrtlang("Wed")."</font></th><th><font class=text14b>".pcrtlang("Thur")."</font></th><th><font class=text14b>".pcrtlang("Fri")."</font></th><th><font class=text14b>".pcrtlang("Sat")."</font></th><th><font class=text14b>".pcrtlang("Sun")."</font></th></tr>";
}

    echo "\n\t<tr>";

if ($pcrt_weekstart == "Sunday") {
    for($i = 1; $i <= $offset; $i++)
    {
        echo "<td style=\"width:14%;background: #cccccc\"></td>";
    }
} else {  // monday start
if($offset == 0) {
    for($i = -5; $i <= $offset; $i++)
    {
        echo "<td style=\"width:14%;background: #cccccc\"></td>";
    }
} else {
    for($i = 2; $i <= $offset; $i++)
    {
     	echo "<td style=\"width:14%;background: #cccccc\"></td>";
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
echo "$day";

echo "<button type=button onClick=\"parent.location='sticky.php?func=addsticky&setday=$setday&setmonth=$month&setyear=$year&showwhat=calendar&month=$month&year=$year'\" style=\"padding:2px;\"><i class=\"fa fa-plus\"></i></button>";

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


echo "<div data-role=\"popup\" id=\"popup$stickyid\">";
echo "<a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-corner-all ui-shadow ui-btn ui-icon-delete ui-btn-icon-notext ui-btn-right\">Close</a>";
echo "<table style=\"max-width:400px;margin-left:auto; margin-right:auto;\" align=center><tr><td>";
start_box_sn($stickynotecolor,$stickynotecolor2,$stickybordercolor);

echo "<font class=text12b style=\"color:#$stickybordercolor\">$stickytypename: $stickyname</font>";
if("$stickyname" != "") {
echo "<br><font class=text12 style=\"color:#$stickybordercolor\">$stickycompany</font>";
}
echo "<br><br><font class=text12>$stickynote<br>";

$stickyduedate2 = date("M j, Y, g:i a",strtotime($stickyduedate));
echo "<br><font class=text10>".pcrtlang("Date/Due Date").": $stickyduedate2</font>";

if ($stickyuser != "none") {
echo "<br><font class=text10>".pcrtlang("Assigned To").": $stickyuser</font>";
}

if ($stickyaddy1 != "") {
echo "<br><font class=text10>$stickyaddy1</font>";
}

if ($stickyaddy2 != "") {
echo "<br><font class=text10>$stickyaddy2</font>";
}

if (($stickycity != "") || ($stickystate != "") || ($stickyzip != "")){
echo "<br><font class=text10>$stickycity, $stickystate $stickyzip</font>";
}

if ($stickyphone != "") {
echo "<br><font class=text10>$stickyphone</font>";
}
if ($stickyemail != "") {
echo "<button type=button onClick=\"parent.location='mailto:$stickyemail'\"><i class=\"fa fa-envelope fa-lg\"></i> $stickyemail</button>";
}

if ($refid != "0") {
if ($reftype == "woid") {
echo "<button type=button onClick=\"parent.location='index.php?pcwo=$refid'\">".pcrtlang("Work Order")." #$refid</button>";
} elseif ($reftype == "pcid") {
echo "<button type=button onClick=\"parent.location='pc.php?func=showpc&pcid=$refid'\">".pcrtlang("PCID")." #$refid</button>";
} elseif ($reftype == "groupid") {
echo "<button type=button onClick=\"parent.location='group.php?func=viewgroup&pcgroupid=$refid'\"><i class=\"fa fa-group fa-lg\"></i> #$refid</button>";
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

echo "<button type=button onClick=\"parent.location='pc.php?func=addpc&pcaddress=$stickyaddy12&pcaddress2=$stickyaddy22&pccity=$stickycity2&pcstate=$stickystate2&pczip=$stickyzip2&pcphone=$stickyphone2&pcemail=$stickyemail2&pcproblem=$stickynote2&pcname=$stickyname2&pccompany=$stickycompany2'\"> <i class=\"fa fa-reply fa-lg\"></i> ".pcrtlang("New Check-in")."</button>";


if ((perm_check("19")) || ("$stickyuser" == "$ipofpc") || ("$stickyuser" == "none")) {
echo "<button type=button onClick=\"parent.location='sticky.php?func=deletesticky&stickyid=$stickyid&showwhat=calendar&month=$month&year=$year'\"><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")."</a>";
}

if ((perm_check("20")) || ("$stickyuser" == "$ipofpc") || ("$stickyuser" == "none")) {
echo "<button type=button onClick=\"parent.location='sticky.php?func=editsticky&stickyid=$stickyid&showwhat=calendar&month=$month&year=$year'\"><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("Edit")."</button>";
}

echo "<button type=button onClick=\"parent.location='sticky.php?func=printsticky&stickyid=$stickyid'\"><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Print")."</button>";

if ($showonwall == 0) {
echo "<button type=button onClick=\"parent.location='sticky.php?func=changewall&stickyid=$stickyid&showwhat=stickywall&showonwall=1'\">".pcrtlang("Show on Wall")."</button>";
}





stop_box();
echo "</td></tr></table>";

echo "</div>";


$duetime = date("g:i a", strtotime($stickyduedate));

echo "<a href=\"#popup$stickyid\" data-rel=\"popup\"><i class=\"fa fa-circle fa-2x\" style=\"color:#$stickybordercolor\"></i></a>";

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
$probdesc = "$rs_result_q->probdesc";
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
echo "<div data-role=\"popup\" id=\"popupwo$woid\">";
echo "<a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-corner-all ui-shadow ui-btn ui-icon-delete ui-btn-icon-notext ui-btn-right\">Close</a>";
echo "<div style=\"background:#$boxstyle[selectorcolor]; text-align:left; padding:6px; max-width:350px;\"><font style=\"color:#ffffff\">$pcname</font></div>";
echo "<div style=\"background:#ffffff; border-right:#aaaaaa 1px solid;border-left:#aaaaaa 1px solid;border-bottom:#aaaaaa 1px solid;text-align:left;padding:5px;\"><font class=text10>$probdesc</font>";

echo "<button type=button onClick=\"parent.location='index.php?pcwo=$woid'\">WO# $woid</button>";
echo "$thedatewo";
echo "</div>";
echo "</div>";

echo "<a href=\"#popupwo$woid\" data-rel=\"popup\"><i class=\"fa fa-square fa-2x\" style=\"color:#$boxstyle[selectorcolor]\"></i></a>";

}


###






echo "</td>";
    }

if ($pcrt_weekstart == "Sunday") {
    while( ($day + $offset) <= $rows * 7)
    {
        echo "<td style=\"width:14%;background: #cccccc\"></td>";
        $day++;
    }
} else {  //monday start
if($offset == 0) {
    while( ($day + $offset + 6) <= $rows * 7)
    {
        echo "<td style=\"width:14%;background: #cccccc\"></td>";
        $day++;
    }
} else {
    while( ($day + $offset - 1) <= $rows * 7)
    {
        echo "<td style=\"width:14%;background: #cccccc\"></td>";
        $day++;
    }

}



}

    echo "</tr>\n";
    echo "</table>\n";



}



?>
