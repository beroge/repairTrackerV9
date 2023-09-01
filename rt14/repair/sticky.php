<?php
                                                                                                    
/***************************************************************************
 *   copyright            : (C) 2016 PCRepairTracker.com
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

                                                                                                    
function nothing() {
require_once("header.php");
require_once("footer.php");

}



##########

function addsticky() {


require_once("common.php");

if (array_key_exists("nomodal", $_REQUEST)) {
$nomodal = $_REQUEST['nomodal'];
} else {
$nomodal = 1;
}

if(($gomodal != 1) || ($nomodal != 1)) {
require("header.php");
} else {
require_once("validate.php");
}



if(($gomodal != 1) || ($nomodal != 1)) {
start_blue_box(pcrtlang("Create New Sticky Note"));
} else {
echo "<h4>".pcrtlang("Create New Sticky Note")."</h4><br><br>";
}

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

if (array_key_exists('stickyname',$_REQUEST)) {
$stickyname = urldecode($_REQUEST['stickyname']);
} else {
$stickyname = "";
}

if (array_key_exists('stickycompany',$_REQUEST)) {
$stickycompany = urldecode($_REQUEST['stickycompany']);
} else {
$stickycompany = "";
}

if (array_key_exists('stickyaddy1',$_REQUEST)) {
$stickyaddy1 = urldecode($_REQUEST['stickyaddy1']);
} else {
$stickyaddy1 = "";
}

if (array_key_exists('stickyaddy2',$_REQUEST)) {
$stickyaddy2 = urldecode($_REQUEST['stickyaddy2']);
} else {
$stickyaddy2 = "";
}

if (array_key_exists('stickycity',$_REQUEST)) {
$stickycity = urldecode($_REQUEST['stickycity']);
} else {
$stickycity = "";
}

if (array_key_exists('stickystate',$_REQUEST)) {
$stickystate = urldecode($_REQUEST['stickystate']);
} else {
$stickystate = "";
}

if (array_key_exists('stickyzip',$_REQUEST)) {
$stickyzip = urldecode($_REQUEST['stickyzip']);
} else {
$stickyzip = "";
}

if (array_key_exists('stickyemail',$_REQUEST)) {
$stickyemail = urldecode($_REQUEST['stickyemail']);
} else {
$stickyemail = "";
}

if (array_key_exists('stickyphone',$_REQUEST)) {
$stickyphone = urldecode($_REQUEST['stickyphone']);
} else {
$stickyphone = "";
}

if (array_key_exists('stickyrefid',$_REQUEST)) {
$stickyrefid = $_REQUEST['stickyrefid'];
} else {
$stickyrefid = "";
}

if (array_key_exists('stickyreftype',$_REQUEST)) {
$stickyreftype = $_REQUEST['stickyreftype'];
} else {
$stickyreftype = "";
}

if (array_key_exists('showwhat',$_REQUEST)) {
$showwhat = $_REQUEST['showwhat'];
} else {
$showwhat = "";
}

if (array_key_exists('month',$_REQUEST)) {
$month = $_REQUEST['month'];
} else {
$month = "";
}

if (array_key_exists('year',$_REQUEST)) {
$year = $_REQUEST['year'];
} else {
$year = "";
}

if (array_key_exists('setmonth',$_REQUEST)) {
$setmonth = $_REQUEST['setmonth'];
} else {
$setmonth = date('m');
}

if (array_key_exists('setday',$_REQUEST)) {
$setday = $_REQUEST['setday'];
} else {
$setday = date('d');
}

if (array_key_exists('setyear',$_REQUEST)) {
$setyear = $_REQUEST['setyear'];
} else {
$setyear = date('Y');
}

if (array_key_exists('stickynote',$_REQUEST)) {
$stickynote = $_REQUEST['stickynote'];
} else {
$stickynote = "";
}

if (array_key_exists('storeid',$_REQUEST)) {
$storeid2 = $_REQUEST['storeid'];
if($storeid2 == 0) {
$storeid = "$defaultuserstore";
} else {
$storeid = $storeid2;
}
} else {
$storeid = "$defaultuserstore";
}

if (array_key_exists('sreq_id',$_REQUEST)) {
$sreq_id = $_REQUEST['sreq_id'];
} else {
$sreq_id = "$defaultuserstore";
}


echo "<form action=sticky.php?func=addsticky2 method=post name=stickynote><input type=hidden name=stickyrefid value=\"$stickyrefid\">";
echo "<input type=hidden name=stickyreftype value=\"$stickyreftype\"><input type=hidden name=month value=\"$month\">";
echo "<input type=hidden name=showwhat value=\"$showwhat\"><input type=hidden name=year value=\"$year\"><table>";
echo "<tr><td>".pcrtlang("Customer Name").":</td><td><input autofocus size=25 class=textboxw type=text name=stickyname value=\"$stickyname\"></td>";
echo "<td rowspan=10>&nbsp;&nbsp;</td>";
echo "<td rowspan=10 valign=top>".pcrtlang("Note").":<br><textarea name=stickynote class=textboxw rows=10 cols=30>$stickynote</textarea></td>";

echo "</tr>";
echo "<tr><td>".pcrtlang("Company").":</td><td><input size=25 type=text class=textboxw name=stickycompany value=\"$stickycompany\"></td></tr>";
echo "<tr><td>$pcrt_address1:</td><td><input size=25 type=text class=textboxw name=stickyaddy1 value=\"$stickyaddy1\"></td></tr>";
echo "<tr><td>$pcrt_address2:</td><td><input size=25 type=text class=textboxw name=stickyaddy2 value=\"$stickyaddy2\"></td></tr>";
echo "<tr><td>$pcrt_city, $pcrt_state $pcrt_zip:</td><td><input size=8 type=text class=textboxw name=stickycity value=\"$stickycity\">";
echo "<input size=4 type=text class=textboxw name=stickystate value=\"$stickystate\">";
echo "<input size=7 type=text class=textboxw name=stickyzip value=\"$stickyzip\"></td></tr>";
echo "<tr><td>".pcrtlang("Customer Phone").":</td><td><input size=25 type=text class=textboxw name=stickyphone value=\"$stickyphone\"></td></tr>";
echo "<tr><td>".pcrtlang("Customer Email").":</td><td><input size=25 type=text class=textboxw name=stickyemail value=\"$stickyemail\"></td></tr>";
$thetime = date("g:i A");

echo "<tr><td>".pcrtlang("Date/Due Date").":</td><td>";
echo "<input id=stickyduedate size=11 type=text name=stickyduedate class=textboxw value=\"$setyear-$setmonth-$setday\">";

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
new datepickr('stickyduedate', { dateFormat: 'Y-m-d', theCurrentDate: document.getElementById("stickyduedate").value });
</script>
<?php

picktime('stickyduetime',"$thetime");


echo "</td></tr>";

echo "<tr><td>".pcrtlang("Sticky Note Type").":</td><td>";
$rs_find_stickytypes = "SELECT * FROM stickytypes";
$rs_result_stickytypes = mysqli_query($rs_connect, $rs_find_stickytypes);
echo "<select name=stickytypeid>";
while($rs_result_sq = mysqli_fetch_object($rs_result_stickytypes)) {
$rs_stname = "$rs_result_sq->stickytypename";
$rs_stid = "$rs_result_sq->stickytypeid";
echo "<option value=$rs_stid>$rs_stname</option>";
}
echo "</select>";
echo "</td></tr>";

echo "<tr><td>".pcrtlang("Assign to User").":</td><td>";
$rs_find_users = "SELECT * FROM users WHERE username != 'admin'";
$rs_result_users = mysqli_query($rs_connect, $rs_find_users);
echo "<select name=uname>";
echo "<option value=\"none\">".pcrtlang("none")."</option>";
while($rs_result_uq = mysqli_fetch_object($rs_result_users)) {
$rs_uname = "$rs_result_uq->username";

if($rs_uname == "$ipofpc") {
echo "<option value=$rs_uname selected>$rs_uname</option>";
} else {
echo "<option value=$rs_uname>$rs_uname</option>";
}
}
echo "</select>";

echo "&nbsp;&nbsp;&nbsp;".pcrtlang("Notify").": <input type=checkbox name=notifyuseremail> ".pcrtlang("Email")." &nbsp;&nbsp;&nbsp; ";
if ($mysmsgateway != "none") {
echo "<input type=checkbox name=notifyusersms> SMS";
}


echo "</td></tr>";


$storeoptions = "";
if ($activestorecount > 1) {
$rs_find_stores = "SELECT * FROM stores WHERE storeenabled = '1' ORDER BY storesname ASC";
$rs_result_stores = mysqli_query($rs_connect, $rs_find_stores);
$storeoptions .= "<tr><td>".pcrtlang("Store").":</td><td><select name=stickystoreid>";
while($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
$rs_storesname = "$rs_result_storeq->storesname";
$rs_storeid = "$rs_result_storeq->storeid";
if ($rs_storeid == $storeid) {
$storeoptions .= "<option selected value=$rs_storeid>$rs_storesname</option>";
} else {
$storeoptions .= "<option value=$rs_storeid>$rs_storesname</option>";
}
}
$storeoptions .= "</select></td></tr>";
} else {
$storeoptions = "<tr><td></td><td><input type=hidden name=stickystoreid value=\"$storeid\"></td></tr>";
}

echo $storeoptions;

echo "<tr><td></td><td>";
echo "<input type=hidden name=sreq_id value=$sreq_id>";
echo "<input type=submit class=ibutton value=\"".pcrtlang("Create Sticky Note")."\"></form></td></tr>";

echo "</table>";

if(($gomodal != 1) || ($nomodal != 1)) {
stop_blue_box();
require_once("footer.php");
}


}


function addsticky2() {
require_once("validate.php");
require("deps.php");
require("common.php");

$stickyname = pv($_REQUEST['stickyname']);
$stickycompany = pv($_REQUEST['stickycompany']);
$stickyaddy1 = pv($_REQUEST['stickyaddy1']);
$stickyaddy2 = pv($_REQUEST['stickyaddy2']);
$stickycity = pv($_REQUEST['stickycity']);
$stickystate = pv($_REQUEST['stickystate']);
$stickyzip = pv($_REQUEST['stickyzip']);
$stickyphone = pv($_REQUEST['stickyphone']);
$stickyemail = pv($_REQUEST['stickyemail']);
$stickyuser = $_REQUEST['uname'];
$stickytypeid = $_REQUEST['stickytypeid'];
$stickystoreid = $_REQUEST['stickystoreid'];
$sreq_id = $_REQUEST['sreq_id'];

$stickyduedate = $_REQUEST['stickyduedate']." ".$_REQUEST['stickyduetime'];

if (($stickyduedate2 = strtotime($stickyduedate)) === false) {
$stickyduedate3 = date('Y-m-d H:i:s');
} else {
$stickyduedate3 = date('Y-m-d H:i:s', $stickyduedate2);
}

$stickynote = pv($_REQUEST['stickynote']);
$stickyrefid = $_REQUEST['stickyrefid'];
$stickyreftype = $_REQUEST['stickyreftype'];





$rs_insert_cart = "INSERT INTO stickynotes (stickyname,stickycompany,stickyaddy1,stickyaddy2,stickycity,stickystate,stickyzip,stickyphone,stickyemail,stickyuser,stickytypeid,
stickyduedate,stickynote,refid,reftype,storeid) VALUES  ('$stickyname','$stickycompany','$stickyaddy1','$stickyaddy2','$stickycity','$stickystate','$stickyzip'
,'$stickyphone','$stickyemail','$stickyuser','$stickytypeid','$stickyduedate3','$stickynote','$stickyrefid','$stickyreftype','$stickystoreid')";
@mysqli_query($rs_connect, $rs_insert_cart);

$stickyid = mysqli_insert_id($rs_connect);


if($sreq_id != 0) {
$rs_close_req = "UPDATE servicerequests SET sreq_processed = '1' WHERE sreq_id = '$sreq_id'";
@mysqli_query($rs_connect, $rs_close_req);
}

if($stickyuser != "") {
if(array_key_exists('notifyusersms', $_REQUEST)) {
require_once("smsnotify.php");
$usermobile = getusersmsnumber("$stickyuser");
if($usermobile != "") {
$nsnass = pcrtlang("New Sticky Note Assignment");
smssend("$usermobile","$nsnass - $stickyname - $stickyduedate3");
}
}


if(array_key_exists('notifyuseremail', $_REQUEST)) {
require_once("sendenotify.php");
$from = getuseremail("$stickyuser");
$to = $from;
if ($from != "") {
$subject = pcrtlang("New Sticky Note Assignment");
$plaintext ="$stickyname\n$stickyaddy1\n$stickyaddy2\n$stickycity, $stickystate $stickyzip\n\n".pcrtlang("Phone").":\t$stickyphone\n";
$plaintext .= "\n\n".pcrtlang("Email").": $stickyemail\n\n".pcrtlang("Note").":\n$stickynote\n";
$stickynote2 = nl2br($_REQUEST['stickynote']);
$htmltext ="<b>$stickyname</b><br>$stickyaddy1<br>$stickyaddy2<br>$stickycity, $stickystate $stickyzip<br><br><b>".pcrtlang("Phone").":</b>$stickyphone";
$htmltext .= "<br><br><b>".pcrtlang("Email")."</b>:$stickyemail<br><br><b>".pcrtlang("Note").":</b><br>$stickynote2<br><br>";
sendenotify("$from","$to","$subject","$plaintext","$htmltext");
}
}
}


if ($stickyreftype == "woid") {
header("Location: index.php?pcwo=$stickyrefid");
} elseif ($stickyreftype == "groupid") {
header("Location: group.php?func=viewgroup&pcgroupid=$stickyrefid&groupview=sticky");
} else {
if (array_key_exists('showwhat', $_REQUEST)) {
$showwhat = $_REQUEST['showwhat'];
$month = $_REQUEST['month'];
$year = $_REQUEST['year'];
if ("$showwhat" == "calendar") {
header("Location: stickydisplay.php?showwhat=calendar&month=$month&year=$year");
} else {
header("Location: stickydisplay.php");
}

} else {
header("Location: stickydisplay.php");
}
}


}


function deletesticky() {
require_once("validate.php");

require("deps.php");
require("common.php");

$stickyid = $_REQUEST['stickyid'];

if (array_key_exists('showwhat',$_REQUEST)) {
$showwhat = $_REQUEST['showwhat'];
} else {
$showwhat = "";
}

if (array_key_exists('month',$_REQUEST)) {
$month = $_REQUEST['month'];
} else {
$month = "";
}

if (array_key_exists('year',$_REQUEST)) {
$year = $_REQUEST['year'];
} else {
$year = "";
}

if (array_key_exists('returnurl', $_REQUEST)) {
$returnurl = $_REQUEST['returnurl'];
} else {
$returnurl = "";
}

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}





$rs_insert_scan = "DELETE FROM stickynotes WHERE stickyid = '$stickyid'";
@mysqli_query($rs_connect, $rs_insert_scan);


#wip

if($returnurl == "") {
if (array_key_exists('showwhat', $_REQUEST)) {
$showwhat = $_REQUEST['showwhat'];
$month = $_REQUEST['month'];
$year = $_REQUEST['year'];
if ("$showwhat" == "calendar") {
header("Location: stickydisplay.php?showwhat=calendar&month=$month&year=$year");
} else {
header("Location: stickydisplay.php");
}

} else {
header("Location: stickydisplay.php");
}
} else {
header("Location: $returnurl");
}





}





function editsticky() {


require_once("common.php");
if($gomodal != "1") {
require("header.php");
} else {
require_once("validate.php");
}



if (array_key_exists('showwhat',$_REQUEST)) {
$showwhat = $_REQUEST['showwhat'];
} else {
$showwhat = "";
}

if (array_key_exists('month',$_REQUEST)) {
$month = $_REQUEST['month'];
} else {
$month = "";
}

if (array_key_exists('year',$_REQUEST)) {
$year = $_REQUEST['year'];
} else {
$year = "";
}

if (array_key_exists('returnurl', $_REQUEST)) {
$returnurl = $_REQUEST['returnurl'];
} else {
$returnurl = "";
}

if($gomodal != "1") {
start_blue_box(pcrtlang("Edit Sticky Note"));
} else {
echo "<h4>".pcrtlang("Edit Sticky Note")."</h4><br><br>";
}

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

$stickyid = $_REQUEST['stickyid'];




$rs_findnotes5 = "SELECT * FROM stickynotes WHERE stickyid = '$stickyid'";
$rs_result_n5 = mysqli_query($rs_connect, $rs_findnotes5);


$rs_result_qn5 = mysqli_fetch_object($rs_result_n5);
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
$stickynote = "$rs_result_qn5->stickynote";
$stickyname = "$rs_result_qn5->stickyname";
$stickycompany = "$rs_result_qn5->stickycompany";
$stickystoreid = "$rs_result_qn5->storeid";


echo "<form action=sticky.php?func=editsticky2 method=post>";
echo "<table>";
echo "<tr><td>".pcrtlang("Customer Name").":</td><td><input size=35 class=textboxw type=text name=stickyname value=\"$stickyname\"><input type=hidden name=stickyid value=\"$stickyid\">";

echo "<input type=hidden name=month value=\"$month\">";
echo "<input type=hidden name=returnurl value=\"$returnurl\">";
echo "<input type=hidden name=showwhat value=\"$showwhat\"><input type=hidden name=year value=\"$year\">";

echo "</td>";
echo "<td rowspan=10>&nbsp;&nbsp;</td>";
echo "<td rowspan=10 valign=top>".pcrtlang("Note").":<br><textarea name=stickynote class=textboxw rows=10 cols=30>$stickynote</textarea></td>";

echo "</tr>";
echo "<tr><td>".pcrtlang("Company").":</td><td><input size=35 type=text class=textboxw name=stickycompany value=\"$stickycompany\"></td></tr>";
echo "<tr><td>$pcrt_address1:</td><td><input size=35 type=text class=textboxw name=stickyaddy1 value=\"$stickyaddy1\"></td></tr>";
echo "<tr><td>$pcrt_address2:</td><td><input size=35 type=text class=textboxw name=stickyaddy2 value=\"$stickyaddy2\"></td></tr>";
echo "<tr><td>$pcrt_city, $pcrt_state $pcrt_zip:</td><td><input size=10 type=text class=textboxw name=stickycity value=\"$stickycity\">";
echo "<input size=5 type=text class=textboxw name=stickystate value=\"$stickystate\">";
echo "<input size=9 type=text class=textboxw name=stickyzip value=\"$stickyzip\"></td></tr>";
echo "<tr><td>".pcrtlang("Customer Phone").":</td><td><input size=35 type=text class=textboxw name=stickyphone value=\"$stickyphone\"></td></tr>";
echo "<tr><td>".pcrtlang("Customer Email").":</td><td><input size=35 type=text class=textboxw name=stickyemail value=\"$stickyemail\"></td></tr>";





echo "<tr><td>".pcrtlang("Date/Due Date").":</td><td>";


$stickyduedatedate = date("Y-m-d", strtotime($stickyduedate));
$stickyduedatetime = date("g:i A", strtotime($stickyduedate));
$currentmonth = date("Y-m-d", strtotime($stickyduedate));

echo "<input id=stickyduedate size=11 type=text name=stickyduedate class=textboxw value=\"$stickyduedatedate\">";

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
new datepickr('stickyduedate', { dateFormat: 'Y-m-d', theCurrentDate: document.getElementById("stickyduedate").value });
</script>

<?php


picktime('stickyduetime', "$stickyduedatetime");

#echo "<input size=7 type=text class=textboxw name=stickyduetime value=\"$stickyduedatetime\">

echo "</td></tr>";

echo "<tr><td>".pcrtlang("Sticky Note Type").":</td><td>";
$rs_find_stickytypes = "SELECT * FROM stickytypes";
$rs_result_stickytypes = mysqli_query($rs_connect, $rs_find_stickytypes);
echo "<select name=stickytypeid>";
while($rs_result_sq = mysqli_fetch_object($rs_result_stickytypes)) {
$rs_stname = "$rs_result_sq->stickytypename";
$rs_stid = "$rs_result_sq->stickytypeid";
if($stickytypeid == $rs_stid) {
echo "<option value=$rs_stid selected>$rs_stname</option>";
} else {
echo "<option value=$rs_stid>$rs_stname</option>";
}
}


echo "</select>";
echo "</td></tr>";

if ((perm_check("19")) || ("$stickyuser" == "$ipofpc") || ("$stickyuser" == "none")) {

echo "<tr><td>".pcrtlang("Assign to User").":</td><td>";
$rs_find_users = "SELECT * FROM users WHERE username != 'admin'";
$rs_result_users = mysqli_query($rs_connect, $rs_find_users);
echo "<select name=uname>";
echo "<option value=\"none\">".pcrtlang("none")."</option>";
while($rs_result_uq = mysqli_fetch_object($rs_result_users)) {
$rs_uname = "$rs_result_uq->username";

if($rs_uname == "$stickyuser") {
echo "<option value=$rs_uname selected>$rs_uname</option>";
} else {
echo "<option value=$rs_uname>$rs_uname</option>";
}
}
echo "</select>";
echo "</td></tr>";

} else {
echo "<input type=hidden name=uname value=\"$stickyuser\">";
}



$storeoptions = "";
if ($activestorecount > 1) {
$rs_find_stores = "SELECT * FROM stores WHERE storeenabled = '1' ORDER BY storesname ASC";
$rs_result_stores = mysqli_query($rs_connect, $rs_find_stores);
$storeoptions .= "<tr><td>".pcrtlang("Store").":</td><td><select name=stickystoreid>";
while($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
$rs_storesname = "$rs_result_storeq->storesname";
$rs_storeid = "$rs_result_storeq->storeid";
if ($rs_storeid == $stickystoreid) {
$storeoptions .= "<option selected value=$rs_storeid>$rs_storesname</option>";
} else {
$storeoptions .= "<option value=$rs_storeid>$rs_storesname</option>";
}
}
$storeoptions .= "</select></td></tr>";
} else {
$storeoptions = "<tr><td></td><td><input type=hidden name=stickystoreid value=\"$stickystoreid\"></td></tr>";
}

echo $storeoptions;



echo "<tr><td></td><td><input type=submit class=ibutton value=\"".pcrtlang("Save Sticky Note")."\"></td></tr>";

echo "</table>";

if($gomodal != 1) {
stop_blue_box();
}

if($gomodal != 1) {
require_once("footer.php");
}


}




function editsticky2() {
require_once("validate.php");
require("deps.php");
require("common.php");

$stickyid = $_REQUEST['stickyid'];
$stickyname = pv($_REQUEST['stickyname']);
$stickycompany = pv($_REQUEST['stickycompany']);
$stickyaddy1 = pv($_REQUEST['stickyaddy1']);
$stickyaddy2 = pv($_REQUEST['stickyaddy2']);
$stickycity = pv($_REQUEST['stickycity']);
$stickystate = pv($_REQUEST['stickystate']);
$stickyzip = pv($_REQUEST['stickyzip']);
$stickyphone = pv($_REQUEST['stickyphone']);
$stickyemail = pv($_REQUEST['stickyemail']);
$stickyuser = $_REQUEST['uname'];
$stickytypeid = $_REQUEST['stickytypeid'];
$stickyduedate = $_REQUEST['stickyduedate']." ".$_REQUEST['stickyduetime'];
$stickystoreid = $_REQUEST['stickystoreid'];

if (array_key_exists('returnurl', $_REQUEST)) {
$returnurl = $_REQUEST['returnurl'];
} else {
$returnurl = "";
}


if (($stickyduedate2 = strtotime($stickyduedate)) === false) {
$stickyduedate3 = date('Y-m-d H:i:s');
} else {
$stickyduedate3 = date('Y-m-d H:i:s', $stickyduedate2);
}


$stickynote = pv($_REQUEST['stickynote']);

$rs_insert_cart = "UPDATE stickynotes SET stickyname = '$stickyname', stickycompany = '$stickycompany', stickyaddy1 = '$stickyaddy1', stickyaddy2 = '$stickyaddy2', stickycity = '$stickycity', stickystate = '$stickystate', stickyzip = '$stickyzip', stickyphone = '$stickyphone', stickyemail = '$stickyemail', stickyuser = '$stickyuser', stickytypeid = '$stickytypeid', stickyduedate = '$stickyduedate3', stickynote = '$stickynote', storeid = '$stickystoreid' WHERE stickyid = '$stickyid'";
@mysqli_query($rs_connect, $rs_insert_cart);

if($returnurl == "") {
if (array_key_exists('showwhat', $_REQUEST)) {
$showwhat = $_REQUEST['showwhat'];
$month = $_REQUEST['month'];
$year = $_REQUEST['year'];
if ("$showwhat" == "calendar") {
header("Location: stickydisplay.php?showwhat=calendar&month=$month&year=$year");
} else {
header("Location: stickydisplay.php");
}

} else {
header("Location: stickydisplay.php");
}
} else {
header("Location: $returnurl");
}

}



function changewall() {
require_once("validate.php");
require("deps.php");
require("common.php");

$stickyid = $_REQUEST['stickyid'];
$showonwall = $_REQUEST['showonwall'];

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}






$rs_insert_cart = "UPDATE stickynotes SET showonwall = '$showonwall' WHERE stickyid = '$stickyid'";
@mysqli_query($rs_connect, $rs_insert_cart);

header("Location: stickydisplay.php");

}


##########

function printsticky() {

require("headerempty.php");
require("deps.php");
require_once("common.php");

$stickyid = $_REQUEST['stickyid'];

$rs_findnotes52 = "SELECT * FROM stickynotes WHERE stickyid = '$stickyid'";

$rs_result_n5 = mysqli_query($rs_connect, $rs_findnotes52);


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
$stickynote = "$rs_result_qn5->stickynote";
$stickyname = "$rs_result_qn5->stickyname";
$stickycompany = "$rs_result_qn5->stickycompany";
$refid = "$rs_result_qn5->refid";
$reftype = "$rs_result_qn5->reftype";
$showonwall = "$rs_result_qn5->showonwall";

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

$storeinfoarray = getstoreinfo($defaultuserstore);
$storelocation = "$storeinfoarray[storeaddy1] $storeinfoarray[storecity] $storeinfoarray[storestate]";

printableheader(pcrtlang("Print Sticky Note"));

echo "<table style=\"width:400px;margin-left:auto; margin-right:auto;\" align=center><tr><td>";
start_box_sn($stickynotecolor,$stickynotecolor2,$stickybordercolor);
echo "<div style=\"margin:-3px; box-shadow: inset 0 0 0 1000px #$stickynotecolor2;padding:4px;\">";
echo "<div style=\"padding:5px;margin:-5px; box-shadow: inset 0 0 0 1000px #$stickynotecolor2;padding:4px;\" class=\"sizeme16 boldme\">$stickytypename<br>$stickyname</div>";

if("$stickycompany" != "") {
echo "<br><span style=\"color:#$stickybordercolor\">$stickycompany</span>";
}

echo "<br><br>$stickynote<br>";

$stickyduedate2 = date("M j, Y, g:i a",strtotime($stickyduedate));
echo "<br><span class=\"sizemesmaller\">".pcrtlang("Date/Due Date").": $stickyduedate2</span>";

if ($stickyuser != "none") {
echo "<br><span class=\"sizemesmaller\">".pcrtlang("Assigned To").": $stickyuser</span>";
}

if ($stickyaddy1 != "") {
echo "<br><span class=\"sizemesmaller\">$stickyaddy1</span>";
}

if ($stickyaddy2 != "") {
echo "<br><span class=\"sizemesmaller\">$stickyaddy2</span>";
}

if (($stickycity != "") || ($stickystate != "") || ($stickyzip != "")){
echo "<br><span class=\"sizemesmaller\">$stickycity, $stickystate $stickyzip</span>";
}

if ($stickyphone != "") {
echo "<br><span class=\"sizemesmaller\">$stickyphone</span>";
}
if ($stickyemail != "") {
echo "<br><a href=\"mailto:$stickyemail\">$stickyemail</a>";
}

if ($refid != "0") {
if ($reftype == "woid") {
echo "<br><a href=\"index.php?pcwo=$refid\">".pcrtlang("Work Order")." #$refid</a>";
} elseif ($reftype == "pcid") {
echo "<br><a href=\"pc.php?func=showpc&pcid=$refid\">PCID #$refid</a>";
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

echo "</div>";

stop_box();

if (($stickycity != "") && ($stickystate != "")) {

#gmap
?>

<script type="text/javascript">
$(function()
        {

$("#map1").gMap({ maptype: 'ROADMAP', markers: [{ address: "<?php echo "$stickyaddy1, $stickycity, $stickystate"; ?>",
                              html: "<?php echo "$stickyname $stickycompany<br>$stickyaddy1<br>$stickyaddy2<br>$stickycity, $stickystate"; ?>" }],
                  address: "<?php echo "$stickyaddy1, $stickycity, $stickystate"; ?>",
                  zoom: 15 });

});
</script>




<br><br>

<div id="map1" style="width: 600px; height: 400px; border: 1px solid #777; overflow: hidden;"></div>



<br>
<div id="test" style="width: 600px; height: 400px; border: 1px solid #777; overflow: hidden;"></div>

<br>
<div id=test2></div>

<script type="text/javascript">
$("#test2").gmap3({
  getroute:{
    options:{
        origin:"<?php echo "$storelocation"; ?>",
        destination:"<?php echo "$stickyaddy1, $stickycity, $stickystate"; ?>",
        travelMode: google.maps.DirectionsTravelMode.DRIVING
    },
    callback: function(results){
      if (!results) return;
      $(this).gmap3({
        map:{
          options:{
            zoom: 13,
            center: [-33.879, 151.235]
          }
        },
        directionsrenderer:{
          container: $(document.createElement("div")).addClass("googlemap").insertAfter($("#test2")),
          options:{
            directions:results
          }
        }
      });
    }
  }
});

</script>
<br>
<div id=test></div>

<script type="text/javascript">

$("#test").gmap3({
  getroute:{
    options:{
        origin:"<?php echo "$storelocation"; ?>",
        destination:"<?php echo "$stickyaddy1, $stickycity, $stickystate"; ?>",
        travelMode: google.maps.DirectionsTravelMode.DRIVING
    },
    callback: function(results){
      if (!results) return;
      $(this).gmap3({
        map:{
          options:{
            zoom: 13,
            center: [-33.879, 151.235]
          }
        },
        directionsrenderer:{
          options:{
            directions:results
          }
        }
      });
    }
  }
});

</script>




<?php

}

echo "</div></td></tr></table>";

printablefooter();

}



}


function ical() {

require("deps.php");
require_once("common.php");

$stickyid = $_REQUEST['stickyid'];

$stickyaddy1 = $_REQUEST['stickyaddy1'];
$stickyaddy2 = $_REQUEST['stickyaddy2'];
$stickycity = $_REQUEST['stickycity'];
$stickystate = $_REQUEST['stickystate'];
$stickyzip = $_REQUEST['stickyzip'];
$stickyphone = $_REQUEST['stickyphone'];
$stickyemail = $_REQUEST['stickyemail'];
$stickyduedate = $_REQUEST['stickyduedate'];
$stickyuser = $_REQUEST['stickyuser'];
$stickynote = $_REQUEST['stickynote'];
$stickyname = $_REQUEST['stickyname'];
$stickycompany = $_REQUEST['stickycompany'];

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}

function geticaldate($time, $incl_time = true) {
    return $incl_time ? date('Ymd\THis', $time) : date('Ymd', $time);
}

$getstart = strtotime($stickyduedate);
$stickytime_st = geticaldate($getstart);

$getend = (strtotime($stickyduedate) + 3600);;
$stickytime_end = geticaldate($getend);

$seq = time();

$stickytime_stamp = geticaldate(time());

if ($stickyemail == "") {
$stickyemail2 = "unknown";
} else {
$stickyemail2 = "$stickyemail";
}

$icsfile = "BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:PCRT\r\nX-WR-TIMEZONE:$pcrt_timezone\r\n";

$icsfile .= "BEGIN:VEVENT\r\nUID:$stickyid\r\nSEQUENCE:$seq\r\nDTSTAMP:$stickytime_stamp\r\nORGANIZER;CN=$stickyname:MAILTO:$stickyemail2\r\nDTSTART;TZID=$pcrt_timezone:$stickytime_st\r\nDTEND;TZID=$pcrt_timezone:$stickytime_end\r\nSUMMARY:$stickyname\r\nLOCATION:$stickyaddy1\, $stickyaddy2\, $stickycity\, $stickystate $stickyzip\r\nDESCRIPTION:$stickyphone\\n$stickynote\r\nEND:VEVENT\r\n";

$icsfile .= "END:VCALENDAR\r\n";

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"$stickyid.ics\"");
echo $icsfile;


}

#####


function stickybrowse() {

require("deps.php");
require_once("common.php");

require_once("header.php");

if (array_key_exists("pageNumber", $_REQUEST)) {
$pageNumber = $_REQUEST['pageNumber'];
} else {
$pageNumber = 1;
}

if (array_key_exists("sortby", $_REQUEST)) {
$sortby = $_REQUEST['sortby'];
} else {
$sortby = "date_asc";
}

if (array_key_exists("search", $_REQUEST)) {
$search = $_REQUEST['search'];
} else {
$search = "";
}

$search_ue = urlencode($search);


start_box();
echo "<table style=\"width:100%\"><tr><td>";

echo "<a href=stickydisplay.php?showwhat=stickywall class=\"linkbuttonmedium linkbuttongray radiusleft\"><img src=images/sticky.png class=iconmedium> ".pcrtlang("Sticky Wall")."</a>";
echo "<a href=stickydisplay.php?showwhat=stickycalendar class=\"linkbuttonmedium linkbuttongray radiusright\"><img src=images/sticky.png class=iconmedium> ".pcrtlang("Sticky Calendar")."</a>";

echo "</td><td style=\"text-align:right\">";

echo "<span class=\"sizeme16 boldme\">".pcrtlang("All Sticky Notes")."</span><br><br>";

echo "<i class=\"fa fa-search fa-lg\"></i> <input type=text class=\"textbox\" id=searchbox placeholder=\"Enter Search Text\" value=\"$search\"></td></tr></table>";
stop_box();
echo "<br>";




echo "<div id=themain>";

echo "</div>";

?>
<script type="text/javascript">
$(document).ready(function () {
     $.get('sticky.php?func=stickybrowseajax&pageNumber=<?php echo $pageNumber; ?>&sortby=<?php echo $sortby; ?>&search=<?php echo $search_ue; ?>', function(data) {
     $('#themain').html(data);
     });
});
</script>


<script type="text/javascript">
$(document).ready(function(){
  var globalTimeoutrs = null;
  $("input#searchbox").keyup(function(){
                        if (globalTimeoutrs != null) {
                        clearTimeout(globalTimeoutrs);
                        }
                        var encodedinv = encodeURIComponent(this.value);
                        var searchlength = this.value.length;
                        globalTimeoutrs = setTimeout(function() {
                        globalTimeoutrs = null;
                                if(searchlength<3) {
                                        $('div#themain').load('sticky.php?func=stickybrowseajax&pageNumber=<?php echo $pageNumber; ?>&sortby=<?php echo $sortby; ?>').slideDown(200,function(){
                                        return false;
                                        });
                                }else{
                                        $('div#themain').load('sticky.php?func=stickybrowseajax&pageNumber=<?php echo $pageNumber; ?>&sortby=<?php echo $sortby; ?>&search='+encodedinv).slideDown(200);
                                }
                        }, 500);
  });
});
</script>


<?php


require("footer.php");

}





function stickybrowseajax() {

require("deps.php");
require_once("common.php");

if (array_key_exists("pageNumber", $_REQUEST)) {
$pageNumber = $_REQUEST['pageNumber'];
} else {
$pageNumber = 1;
}

if (array_key_exists("sortby", $_REQUEST)) {
$sortby = $_REQUEST['sortby'];
} else {
$sortby = "date_asc";
}

if ($gomodal == 1) {
$therel = "rel=facebox";
} else {
$therel = "";
}


$results_per_page = 12;

if ($pageNumber == "") {
$offset = "0";
} else {
$offset = ($pageNumber * $results_per_page) - $results_per_page;
}

if (array_key_exists("search", $_REQUEST)) {
$search = $_REQUEST['search'];
if($search != "") {
$searchsql = "AND (stickyname LIKE '%$search%' OR stickynote LIKE '%$search%' OR stickycompany LIKE '%$search%' OR stickyphone LIKE '%$search%' OR stickyemail LIKE '%$search%')";
} else {
$searchsql = "";
$search = "";
}
} else {
$searchsql = "";
$search = "";
}

$search_ue = urlencode($search);


$phpself = $_SERVER['PHP_SELF'];


####################################


$rs_ql = "SELECT stickywide FROM users WHERE username = '$ipofpc'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$touchwide = "$rs_result_q1->stickywide";




$rs_find_sn_total = "SELECT * FROM stickynotes WHERE 1 $searchsql";
$rs_result_total = mysqli_query($rs_connect, $rs_find_sn_total);

$totalentries = mysqli_num_rows($rs_result_total);
$lastpage = $totalentries / $results_per_page;
if($lastpage != floor($lastpage)) {
$lastpage = floor($lastpage) + 1;
}

if($pageNumber > $lastpage) {
$pageNumber = 1;
$offset = 0;
}

$returnurl = urlencode("sticky.php?func=stickybrowse&pageNumber=$pageNumber&sortby=$sortby&search=$search");


#############
$rs_findnotes52 = "SELECT * FROM stickynotes WHERE 1 $searchsql ORDER BY stickyduedate ASC LIMIT $offset,$results_per_page";



$rs_result_n5 = mysqli_query($rs_connect, $rs_findnotes52);
$totalpcsonbench = mysqli_num_rows($rs_result_n5);

$cellwide = floor((100 / $touchwide));



$a = $touchwide;
echo "<table style=\"width:100%; margin-left:auto;margin-right:auto;\">";

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


if (($a % $touchwide) == 0) {
echo "<tr>";
}


echo "<td style=\"width:$cellwide%; padding:10px;vertical-align:top\">";
start_box_sn($stickynotecolor,$stickynotecolor2,$stickybordercolor);

echo "<div style=\"background:#$stickybordercolor;padding:5px;margin:-5px;\" class=\"colormewhite sizeme16 boldme\">$stickytypename<br>$stickyname</div>";

if("$stickycompany" != "") {
echo "<br><span style=\"color:#$stickybordercolor;\">$stickycompany</span>";
}

$stickynote2 = preg_replace('/([a-zA-Z]{30})(?![^a-zA-Z])/', '$1 ', $stickynote);

echo "<br><br>$stickynote2<br>";

$stickyduedate2 = date("M j, Y, g:i a",strtotime($stickyduedate));
echo "<br><span class=\"sizemesmaller\">".pcrtlang("Date/Due Date").": $stickyduedate2</span>";

if ($stickyuser != "none") {
echo "<br><span class=\"sizemesmaller\">".pcrtlang("Assigned To").": $stickyuser</span>";
}

if ($stickyaddy1 != "") {
echo "<br><span class=\"sizemesmaller\">$stickyaddy1</span>";
}

if ($stickyaddy2 != "") {
echo "<br><span class=\"sizemesmaller\">$stickyaddy2</span>";
}

if (($stickycity != "") || ($stickystate != "") || ($stickyzip != "")){
echo "<br><span class=\"sizemesmaller\">$stickycity, $stickystate $stickyzip</span>";
}

if ($stickyphone != "") {
echo "<br><span class=\"sizemesmaller\">$stickyphone</span>";
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
<button class=button style=\"padding:0px;font-size:10px;float:right;\">New Check-in</button></form>";



if ((perm_check("19")) || ("$stickyuser" == "$ipofpc") || ("$stickyuser" == "none")) {
echo "<a href=sticky.php?func=deletesticky&stickyid=$stickyid&showwhat=stickywall&returnurl=$returnurl  onClick=\"return confirm('".pcrtlang("Are you sure you wish to permanently delete this Sticky Note!!!?")."');\" class=\"linkbuttontiny linkbuttonopaque radiusleft\"><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")."</a>";
}

if ((perm_check("20")) || ("$stickyuser" == "$ipofpc") || ("$stickyuser" == "none")) {
echo "<a href=sticky.php?func=editsticky&stickyid=$stickyid&showwhat=stickywall&returnurl=$returnurl $therel class=\"linkbuttontiny linkbuttonopaque\"><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("Edit")."</a>";
}

echo "<a href=sticky.php?func=printsticky&stickyid=$stickyid class=\"linkbuttontiny linkbuttonopaque radiusright\"><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Print")."</a>";


stop_box();

echo "</td>";


$a++;

if (($a % $touchwide) == 0) {
echo "</tr>";
}



}

$startwhile = ($touchwide - ($totalpcsonbench % $touchwide));
if (($totalpcsonbench % $touchwide) >= "1") {
$endwhile = 0;
while($startwhile > $endwhile) {
echo "<td width=$cellwide%>&nbsp;</td>";
$endwhile++;
}
}


if ($startwhile != "0") {
echo "</tr>";
}

echo "</table>";


#browse here

echo "<center>";

if($pageNumber != 1) {
$prevpage = $pageNumber - 1;
echo "<a href=sticky.php?func=stickybrowse&pageNumber=$prevpage&sortby=$sortby&search=$search_ue class=\"linkbuttonmedium linkbuttongray radiusall\">
<i class=\"fa fa-chevron-left fa-lg\"></i></a> ";
}

$html = get_paged_nav($totalentries, $results_per_page, false);
$html = str_replace("stickybrowseajax", "stickybrowse", "$html");
echo "$html";

if($lastpage != $pageNumber) {
$nextpage = $pageNumber + 1;
echo "<a href=sticky.php?func=stickybrowse&pageNumber=$nextpage&sortby=$sortby&search=$search_ue class=\"linkbuttonmedium linkbuttongray radiusall\">
<i class=\"fa fa-chevron-right fa-lg\"></i></a>";
}

echo "</center>";

?>

<script>
function reinit() {
   $('a[rel*=facebox]').facebox() ;
}
reinit();
</script>

<?php


}



switch($func) {
                                                                                                    
    default:
    nothing();
    break;
                                
    case "addsticky":
    addsticky();
    break;

  case "addsticky2":
    addsticky2();
    break;

case "deletesticky":
    deletesticky();
    break;


 case "editsticky":
    editsticky();
    break;

 case "editsticky2":
    editsticky2();
    break;

 case "changewall":
    changewall();
    break;

case "printsticky":
    printsticky();
    break;

case "ical":
    ical();
    break;

case "stickybrowse":
    stickybrowse();
    break;

case "stickybrowseajax":
    stickybrowseajax();
    break;


}

?>
