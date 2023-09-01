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

                                                                                                    
function nothing() {
require_once("header.php");
require_once("footer.php");

}



##########

function addsticky() {


require_once("common.php");
require("dheader.php");


echo "<div data-role=\"header\" data-theme=\"b\"><h2>".pcrtlang("Add Sticky")."</h2></div>";
echo "<div class=\"ui-content\" role=\"main\">";


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


echo "<form action=sticky.php?func=addsticky2 method=post name=stickynote data-ajax=\"false\"><input type=hidden name=stickyrefid value=\"$stickyrefid\">";
echo "<input type=hidden name=stickyreftype value=\"$stickyreftype\"><input type=hidden name=month value=\"$month\">";
echo "<input type=hidden name=showwhat value=\"$showwhat\"><input type=hidden name=year value=\"$year\">";
echo pcrtlang("Customer Name").":<input autofocus size=25 type=text name=stickyname value=\"$stickyname\">";
echo pcrtlang("Note").":<br><textarea name=stickynote>$stickynote</textarea>";

echo pcrtlang("Company").":<input type=text name=stickycompany value=\"$stickycompany\">";
echo "$pcrt_address1:<input type=text name=stickyaddy1 value=\"$stickyaddy1\">";
echo "$pcrt_address2:<input type=text name=stickyaddy2 value=\"$stickyaddy2\">";
echo "$pcrt_city<input type=text name=stickycity value=\"$stickycity\">";
echo "$pcrt_state<input type=text name=stickystate value=\"$stickystate\">";
echo "$pcrt_zip<input type=text name=stickyzip value=\"$stickyzip\">";
echo pcrtlang("Customer Phone").":<input type=text name=stickyphone value=\"$stickyphone\">";
echo pcrtlang("Customer Email").":<input type=text name=stickyemail value=\"$stickyemail\">";
$thetime = date("g:i A");

echo pcrtlang("Date/Due Date").":";
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



echo pcrtlang("Sticky Note Type").":";
$rs_find_stickytypes = "SELECT * FROM stickytypes";
$rs_result_stickytypes = mysqli_query($rs_connect, $rs_find_stickytypes);
echo "<select name=stickytypeid data-native-menu=\"false\">";
while($rs_result_sq = mysqli_fetch_object($rs_result_stickytypes)) {
$rs_stname = "$rs_result_sq->stickytypename";
$rs_stid = "$rs_result_sq->stickytypeid";
echo "<option value=$rs_stid>$rs_stname</option>";
}
echo "</select>";

echo pcrtlang("Assign to User").":";
$rs_find_users = "SELECT * FROM users WHERE username != 'admin'";
$rs_result_users = mysqli_query($rs_connect, $rs_find_users);
echo "<select name=uname data-native-menu=\"false\">";
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

echo pcrtlang("Notify User")."?";
echo "<div class=\"ui-field-contain\">";
echo "<fieldset data-role=\"controlgroup\">";
echo "<input type=\"checkbox\" name=\"notifyuseremail\" id=\"notifyuseremail\">";
echo "<label for=\"notifyuseremail\">".pcrtlang("Email")."</label>";
if ($mysmsgateway != "none") {
echo "<input type=checkbox name=notifyusersms id=\"notifyusersms\">";
echo "<label for=\"notifyusersms\">".pcrtlang("SMS")."</label>";
}
echo "</fieldset>";
echo "</div>";



$storeoptions = "";
if ($activestorecount > 1) {
$rs_find_stores = "SELECT * FROM stores WHERE storeenabled = '1' ORDER BY storesname ASC";
$rs_result_stores = mysqli_query($rs_connect, $rs_find_stores);
$storeoptions .= pcrtlang("Store").":<select name=stickystoreid data-native-menu=\"false\">";
while($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
$rs_storesname = "$rs_result_storeq->storesname";
$rs_storeid = "$rs_result_storeq->storeid";
if ($rs_storeid == $storeid) {
$storeoptions .= "<option selected value=$rs_storeid>$rs_storesname</option>";
} else {
$storeoptions .= "<option value=$rs_storeid>$rs_storesname</option>";
}
}
$storeoptions .= "</select>";
} else {
$storeoptions = "<input type=hidden name=stickystoreid value=\"$storeid\">";
}

echo $storeoptions;

echo "<input type=hidden name=sreq_id value=$sreq_id>";
echo "<input type=submit value=\"".pcrtlang("Create Sticky Note")."\" data-theme=\"b\"></form>";


echo "</div>";

require_once("dfooter.php");


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
header("Location: index.php?showwhat=calendar&month=$month&year=$year");
} else {
header("Location: index.php");
}

} else {
header("Location: index.php");
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


if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}





$rs_insert_scan = "DELETE FROM stickynotes WHERE stickyid = '$stickyid'";
@mysqli_query($rs_connect, $rs_insert_scan);

if (array_key_exists('showwhat', $_REQUEST)) {
$showwhat = $_REQUEST['showwhat'];
$month = $_REQUEST['month'];
$year = $_REQUEST['year'];
if ("$showwhat" == "calendar") {
header("Location: index.php?showwhat=calendar&month=$month&year=$year");
} else {
header("Location: index.php");
}

} else {
header("Location: index.php");
}


}





function editsticky() {


require_once("common.php");
require("dheader.php");


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



echo "<div data-role=\"header\" data-theme=\"b\"><h2>".pcrtlang("Edit Note")."</h2></div>";
echo "<div class=\"ui-content\" role=\"main\">";

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


echo "<form action=sticky.php?func=editsticky2 method=post data-ajax=\"false\">";
echo pcrtlang("Customer Name").":<input type=text name=stickyname value=\"$stickyname\"><input type=hidden name=stickyid value=\"$stickyid\">";

echo "<input type=hidden name=month value=\"$month\">";
echo "<input type=hidden name=showwhat value=\"$showwhat\"><input type=hidden name=year value=\"$year\">";

echo pcrtlang("Note").":<textarea name=stickynote>$stickynote</textarea>";

echo pcrtlang("Company").":<input type=text name=stickycompany value=\"$stickycompany\">";
echo "$pcrt_address1:<input type=text name=stickyaddy1 value=\"$stickyaddy1\">";
echo "$pcrt_address2:<input type=text name=stickyaddy2 value=\"$stickyaddy2\">";
echo "$pcrt_city<input type=text name=stickycity value=\"$stickycity\">";
echo "$pcrt_state<input type=text name=stickystate value=\"$stickystate\">";
echo "$pcrt_zip<input type=text name=stickyzip value=\"$stickyzip\">";
echo pcrtlang("Customer Phone").":<input type=text name=stickyphone value=\"$stickyphone\">";
echo pcrtlang("Customer Email").":<input type=text name=stickyemail value=\"$stickyemail\">";





echo pcrtlang("Date/Due Date").":";


$stickyduedatedate = date("Y-m-d", strtotime($stickyduedate));
$stickyduedatetime = date("g:i A", strtotime($stickyduedate));
$currentmonth = date("Y-m-d", strtotime($stickyduedate));

echo "<input id=stickyduedate size=11 type=text name=stickyduedate value=\"$stickyduedatedate\">";

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


echo pcrtlang("Sticky Note Type").":";
$rs_find_stickytypes = "SELECT * FROM stickytypes";
$rs_result_stickytypes = mysqli_query($rs_connect, $rs_find_stickytypes);
echo "<select name=stickytypeid data-native-menu=\"false\">";
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

if ((perm_check("19")) || ("$stickyuser" == "$ipofpc") || ("$stickyuser" == "none")) {

echo pcrtlang("Assign to User").":";
$rs_find_users = "SELECT * FROM users WHERE username != 'admin'";
$rs_result_users = mysqli_query($rs_connect, $rs_find_users);
echo "<select name=uname data-native-menu=\"false\">";
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

} else {
echo "<input type=hidden name=uname value=\"$stickyuser\">";
}



$storeoptions = "";
if ($activestorecount > 1) {
$rs_find_stores = "SELECT * FROM stores WHERE storeenabled = '1' ORDER BY storesname ASC";
$rs_result_stores = mysqli_query($rs_connect, $rs_find_stores);
$storeoptions .= pcrtlang("Store").":<select name=stickystoreid data-native-menu=\"false\">";
while($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
$rs_storesname = "$rs_result_storeq->storesname";
$rs_storeid = "$rs_result_storeq->storeid";
if ($rs_storeid == $stickystoreid) {
$storeoptions .= "<option selected value=$rs_storeid>$rs_storesname</option>";
} else {
$storeoptions .= "<option value=$rs_storeid>$rs_storesname</option>";
}
}
$storeoptions .= "</select>";
} else {
$storeoptions = "<input type=hidden name=stickystoreid value=\"$stickystoreid\">";
}

echo $storeoptions;



echo "<input type=submit value=\"".pcrtlang("Save Sticky Note")."\" data-theme=\"b\">";


echo "</div>";

require_once("dfooter.php");


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


if (($stickyduedate2 = strtotime($stickyduedate)) === false) {
$stickyduedate3 = date('Y-m-d H:i:s');
} else {
$stickyduedate3 = date('Y-m-d H:i:s', $stickyduedate2);
}


$stickynote = pv($_REQUEST['stickynote']);




$rs_insert_cart = "UPDATE stickynotes SET stickyname = '$stickyname', stickycompany = '$stickycompany', stickyaddy1 = '$stickyaddy1', stickyaddy2 = '$stickyaddy2', stickycity = '$stickycity', stickystate = '$stickystate', stickyzip = '$stickyzip', stickyphone = '$stickyphone', stickyemail = '$stickyemail', stickyuser = '$stickyuser', stickytypeid = '$stickytypeid', stickyduedate = '$stickyduedate3', stickynote = '$stickynote', storeid = '$stickystoreid' WHERE stickyid = '$stickyid'";
@mysqli_query($rs_connect, $rs_insert_cart);

if (array_key_exists('showwhat', $_REQUEST)) {
$showwhat = $_REQUEST['showwhat'];
$month = $_REQUEST['month'];
$year = $_REQUEST['year'];
if ("$showwhat" == "calendar") {
header("Location: index.php?showwhat=calendar&month=$month&year=$year");
} else {
header("Location: index.php");
}

} else {
header("Location: index.php");
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

header("Location: index.php");

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

echo "<div class=printbar>";
echo "<button onClick=\"history.back()\" class=bigbutton><img src=../repair/images/left.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Return")."</button>";
echo "<font class=text30b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>";
echo "<button onClick=\"print();\" class=bigbutton><img src=../repair/images/print.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Print")."</button>";
echo "</div><br>";



echo "<table style=\"width:400px;margin-left:auto; margin-right:auto;\" align=center><tr><td>";
start_box_sn($stickynotecolor,$stickynotecolor2,$stickybordercolor);
echo "<font class=text12b style=\"color:#$stickybordercolor\">$stickytypename: $stickyname</font>";
if("$stickycompany" != "") {
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

echo "</td></tr></table>";

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


}

?>
