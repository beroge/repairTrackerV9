<?php
                                                                                                    
/***************************************************************************
 *   copyright            : (C) 2013 PCRepairTracker.com
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




function submitsq() {
require_once("header.php");

require_once("deps.php");


$rs_connect = mysqli_connect($dbhost, $dbuname, $dbpass, $dbname) or die("Couldn't connect the db");
mysqli_query($rs_connect, "SET NAMES utf8");
mysqli_query($rs_connect, "SET SESSION sql_mode=''");


require_once("common.php");
if (array_key_exists('sent',$_REQUEST)) {
$sent = pv($_REQUEST['sent']);
if($sent == 1) {
echo "<br><div class=noticebox><font class=text16b>".pcrtlang("Thank You for contacting us. We will contact you as soon as possible").".<br><br>";
echo pcrtlang("If you have any other Service Requests, you may submit them below").".";
echo "</font></div><br>";
} else {
echo "<br><div class=noticebox><font class=text16b>".pcrtlang("Service Request Not Sent").".<br><br>";
echo "</font></div><br>";
}
}

$sreq_ip = $_SERVER['REMOTE_ADDR'];

$rs_chkip = "SELECT * FROM servicerequests WHERE sreq_ip = '$sreq_ip' AND sreq_datetime > (DATE_SUB(NOW(),INTERVAL $withindays DAY))";
$rs_result = mysqli_query($rs_connect, $rs_chkip);
$totalsubs = mysqli_num_rows($rs_result);

if($totalsubs < $maxcount) {
echo "<br><div class=box><font class=text16b>".pcrtlang("Submit Service Requests")."</font><br><br>";

echo "<form action=index.php?func=submitsq2 method=post>";
echo "<table><tr><td style=\"vertical-align:top;width:50%;\"\"><table>";
echo "<tr><td><font class=text14>".pcrtlang("Your Name").":</font></td><td><input type=\"text\" required=required  name=\"sreq_name\" onFocus=\"this.form.submitbutton.disabled=false;this.form.submitbutton.value='".pcrtlang("Submit Service Request")."';\"></td></tr>";
echo "<tr><td><font class=text14>".pcrtlang("Company").":</font></td><td><input type=text name=sreq_company></td></tr>";
echo "<tr><td colspan=2><font class=text10i><br>".pcrtlang("Please enter at least one phone number").".</font></td></tr>";
echo "<tr><td><font class=text14>".pcrtlang("Home Phone Number").":</font></td><td><input size=18 type=text name=sreq_phone></td></tr>";
echo "<tr><td><font class=text14>".pcrtlang("Mobile Phone Number").":</font></td><td><input size=18 type=text name=sreq_cellphone></td></tr>";
echo "<tr><td><font class=text14>".pcrtlang("Work Phone Number").":</font></td><td><input size=18 type=text name=sreq_workphone></td></tr>";

echo "<tr><td><font class=text14>".pcrtlang("Email Address").":</font></td><td><input size=18 type=text name=sreq_email></td></tr>";

echo "<tr><td><font class=text14>$pcrt_address1:</font></td><td><input type=text name=sreq_addy1></td></tr>";
echo "<tr><td><font class=text14>$pcrt_address2:</font></td><td><input type=text name=sreq_addy2></td></tr>";
echo "<tr><td><font class=text14>$pcrt_city:</font></td><td><input size=18 type=text name=sreq_city></td></tr>";
echo "<tr><td><font class=text14>$pcrt_state:</font></td><td><input size=6 type=text name=sreq_state></td></tr>";
echo "<tr><td><font class=text14>$pcrt_zip:</font></td><td><input size=10 type=text name=sreq_zip></td></tr>";

echo "</table></td></tr><tr><td style=\"vertical-align:top\">";


echo "<font class=text14>".pcrtlang("Service Requested/Problem").":</font><br><textarea name=sreq_problem required rows=10 style=\"width:90%\" onFocus=\"this.form.submitbutton.disabled=false;this.form.submitbutton.value='".pcrtlang("Submit Service Request")."';\"></textarea>";
echo "<br><br><font class=text14>".pcrtlang("Device Brand: ie. Dell, Apple, HP, etc")."</font><br><input size=36 type=text name=sreq_model>";
echo "<br><br><font class=text14>".pcrtlang("Device Type: ie. Laptop, PC, Tablet, etc")."</font><br><input size=36 type=text name=sreq_type>";

echo "<br><br><font class=text14>".pcrtlang("Computer/Device ID Number")."</font><br><font class=text10i>".pcrtlang("If you have previously had your computer/device serviced with us, it may have a tag with an ID number on it. Please enter it here if you have one.")."</font><br><input size=36 type=text name=sreq_pcid>";


if($allowusertochoosestore == "yes") {
echo "<br><br><font class=text14>".pcrtlang("Preferred Store/Location").":</font><br><select name=storeid>";
echo "<option selected value=\"0\">".pcrtlang("No Preference")."</option>";
$rs_ql = "SELECT * FROM stores WHERE storeenabled = '1'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$storeid = "$rs_result_q1->storeid";
$storename = "$rs_result_q1->storename";
$storesname = "$rs_result_q1->storesname";
echo "<option value=\"$storeid\">$storename - &lt;$storesname&gt;</option>";
}
echo "</select>";
} else {
echo "<input type=hidden name=storeid value=0>";
}


echo "<br><br><font class=text14>".pcrtlang("How did you hear about us?")."</font><br>";

echo "<select name=custsourceid>";
echo "<option value=0>".pcrtlang("Please Select an Option")."</option>";
$rs_findsource = "SELECT * FROM custsource WHERE sourceenabled != '0' ORDER BY thesource ASC";
$rs_resultcs = mysqli_query($rs_connect, $rs_findsource);
while($rs_result_qcs = mysqli_fetch_object($rs_resultcs)) {
$custsourceid = "$rs_result_qcs->custsourceid";
$thesource = "$rs_result_qcs->thesource";
$sourceicon = "$rs_result_qcs->sourceicon";
echo "<option value=$custsourceid>$thesource</option>";
}
echo "</select><br>";


if($recaptcha_enable == "yes") {

echo "<br><div class=\"g-recaptcha\" data-sitekey=\"$recaptcha_public_key\"></div>";
echo "<font class=text10>".pcrtlang("This little test is just to make sure you are a real person and not a spammer so that our oncall technician only receives mobile phone notifications for genuine service requests").".</font>";

}



echo "<br><br><input class=button id=submitbutton type=submit value=\"".pcrtlang("Submit Service Request")."\" onclick=\"this.value='".pcrtlang("Sending Request")."...'; this.form.submit();\">";

echo "</td></tr></table></div></form>";
} else {
echo "<br><div class=noticebox><font class=text16b>".pcrtlang("Sorry, the maximum number of requests has been reached").".<br><br>";
echo "</font></div><br>";

}

require_once("footer.php");
                                                                                                    
}


function submitsq2() {
require("deps.php");

$rs_connect = mysqli_connect($dbhost, $dbuname, $dbpass, $dbname) or die("Couldn't connect the db");
mysqli_query($rs_connect, "SET NAMES utf8");
mysqli_query($rs_connect, "SET SESSION sql_mode=''");


if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

require("common.php");

$sreq_name = pv($_REQUEST['sreq_name']);
$sreq_company = pv($_REQUEST['sreq_company']);
$sreq_phone = pv($_REQUEST['sreq_phone']);
$sreq_cellphone = pv($_REQUEST['sreq_cellphone']);
$sreq_workphone = pv($_REQUEST['sreq_workphone']);
$sreq_model = pv($_REQUEST['sreq_model']);
$sreq_type = pv($_REQUEST['sreq_type']);
$sreq_email = pv($_REQUEST['sreq_email']);
$sreq_addy1 = pv($_REQUEST['sreq_addy1']);
$sreq_addy2 = pv($_REQUEST['sreq_addy2']);
$sreq_city = pv($_REQUEST['sreq_city']);
$sreq_state = pv($_REQUEST['sreq_state']);
$sreq_zip = pv($_REQUEST['sreq_zip']);
$sreq_problem = pv($_REQUEST['sreq_problem']);
$sreq_storeid = pv($_REQUEST['storeid']);
$sreq_custsourceid = pv($_REQUEST['custsourceid']);
$sreq_pcid = pv($_REQUEST['sreq_pcid']);

$sreq_ip = $_SERVER['REMOTE_ADDR'];
$sreq_agent = $_SERVER['HTTP_USER_AGENT'];


if($recaptcha_enable == "yes") {

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => array(
        'secret' => "$recaptcha_private_key",
        'response' => $_POST['g-recaptcha-response']
    )
));
$resp = curl_exec($curl);
curl_close($curl);
if(strpos($resp, '"success": true') !== FALSE) {
} else {
	die (pcrtlang("The puzzle was not solved correctly. Please go back and try it again."));
}



}




$rs_chkip = "SELECT * FROM servicerequests WHERE sreq_ip = '$sreq_ip' AND sreq_datetime > (DATE_SUB(NOW(),INTERVAL $withindays DAY))";
$rs_result = mysqli_query($rs_connect, $rs_chkip);
$totalsubs = mysqli_num_rows($rs_result);

if($totalsubs >= $maxcount) {
header("Location: index.php?sent=0");
} else {

$rs_insert_sq = "INSERT INTO servicerequests (sreq_ip,sreq_agent,sreq_name,sreq_company,sreq_homephone,sreq_cellphone,sreq_workphone,sreq_addy1,sreq_addy2,sreq_city,sreq_state,sreq_zip,sreq_email,sreq_problem,sreq_model,sreq_datetime,storeid,sreq_custsourceid,sreq_pcid) VALUES ('$sreq_ip','$sreq_agent','$sreq_name','$sreq_company','$sreq_phone','$sreq_cellphone','$sreq_workphone','$sreq_addy1','$sreq_addy2','$sreq_city','$sreq_state','$sreq_zip','$sreq_email','$sreq_problem','$sreq_model $sreq_type','$currentdatetime','$sreq_storeid','$sreq_custsourceid','$sreq_pcid')";
@mysqli_query($rs_connect, $rs_insert_sq);


require_once("sendenotify.php");
require_once("smsnotify.php");

if ($sreq_storeid != "0") {
$rs_qstores = "SELECT * FROM stores WHERE storeid = '$sreq_storeid'";
$rs_result1 = mysqli_query($rs_connect, $rs_qstores);
$rrow = mysqli_fetch_array($rs_result1);
$oncalluser = $rrow['oncalluser'];
} else {
$rs_qstoresid = "SELECT * FROM stores WHERE storedefault = '1'";
$rs_result1id = mysqli_query($rs_connect, $rs_qstoresid);
$rrow = mysqli_fetch_array($rs_result1id);
$oncallstoreid = $rrow['storeid'];
$rs_qstores = "SELECT * FROM stores WHERE storeid = '$oncallstoreid'";
$rs_result1 = mysqli_query($rs_connect, $rs_qstores);
$rrow = mysqli_fetch_array($rs_result1);
$oncalluser = $rrow['oncalluser'];
}

$oncalluser_u = unserialize($oncalluser);

foreach($oncalluser_u as $key => $val) {

$rs_quser = "SELECT * FROM users WHERE username = '$val'";
$rs_resultuser1 = mysqli_query($rs_connect, $rs_quser);
$urow = mysqli_fetch_array($rs_resultuser1);
$useremail = $urow['useremail'];
$usermobile = $urow['usermobile'];


if(($useremail != "") && ($oncallsendemail == "yes")) {
$from = "$sreq_email";
$to = "$useremail";
$subject = pcrtlang("Service Request Submitted");
$plaintext ="$sreq_name\n$sreq_company\n$sreq_addy1\n$sreq_addy2\n$sreq_city, $sreq_state $sreq_zip\n\n".pcrtlang("Home Phone").":\t$sreq_phone\n".pcrtlang("Cell Phone").":\t$sreq_cellphone\n".pcrtlang("Work Phone").":\t$sreq_workphone";
$plaintext .= "\n\n".pcrtlang("Email").": $sreq_email\n\n".pcrtlang("Device").": $sreq_model $sreq_type\n\n".pcrtlang("Problem").":\n$sreq_problem\n";
$sreq_problem2 = nl2br($_REQUEST['sreq_problem']);
$htmltext ="<b>$sreq_name</b><br>$sreq_name<br>$sreq_addy1<br>$sreq_addy2<br>$sreq_city, $sreq_state $sreq_zip<br><br><b>".pcrtlang("Home Phone").":</b>$sreq_phone<br><b>".pcrtlang("Cell Phone").":</b>$sreq_cellphone<br><b>".pcrtlang("Work Phone").":</b>$sreq_workphone";
$htmltext .= "<br><br><b>".pcrtlang("Email")."</b>:$sreq_email<br><br><b>".pcrtlang("Device").":</b> $sreq_model $sreq_type<br><br><b>".pcrtlang("Problem").":</b><br>$sreq_problem2<br><br>";
sendenotify("$from","$to","$subject","$plaintext","$htmltext");
}


if(($usermobile != "") && ($oncallsendsms == "yes")) {
$smsname  = urlencode("$sreq_name");
$sms_cellphone  = urlencode("$sreq_cellphone");
smssend(filtersmsnumber("$usermobile"),pcrtlang("A Service Request has been submitted by")." $smsname - $sms_cellphone.");
}

}

header("Location: index.php?sent=1");

}
}


##################################################################################################

switch($func) {
                                                                                                    
    default:
    submitsq();
    break;
                                
    case "submitsq2":
    submitsq2();
    break;

}

?>
