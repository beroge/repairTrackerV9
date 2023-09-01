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

require_once("common.php");
if (array_key_exists('sent',$_REQUEST)) {
$sent = pv($_REQUEST['sent']);
if($sent == 1) {

echo "<div class=\"bg-success text-center\">";
echo "<br><h3 class=\"text-success\"><i class=\"fa fa-info fa-lg\"></i> ".pcrtlang("Thank You for contacting us. We will contact you as soon as possible.")."</h3><br><br>";
echo pcrtlang("If you have any other Service Requests, you may submit them below.")."<br><br>";
echo "</div><br>";
} else {
echo "<br><div class=noticebox>".pcrtlang("Service Request Not Sent").".<br><br>";
echo "</div><br>";
}
}

echo "<br><h3>".pcrtlang("Submit Service Requests")."</h3><br><br>";

$rs_findpc = "SELECT * FROM pc_group WHERE pcgroupid = '$portalgroupid'";
$rs_result = mysqli_query($rs_connect, $rs_findpc);
$rs_result_q = mysqli_fetch_object($rs_result);
$pcgroupname = "$rs_result_q->pcgroupname";
$grpcompany = "$rs_result_q->grpcompany";
$grpphone = "$rs_result_q->grpphone";
$grpcellphone = "$rs_result_q->grpcellphone";
$grpworkphone = "$rs_result_q->grpworkphone";
$grpaddress = "$rs_result_q->grpaddress1";
$grpaddress2 = "$rs_result_q->grpaddress2";
$grpcity = "$rs_result_q->grpcity";
$grpstate = "$rs_result_q->grpstate";
$grpzip = "$rs_result_q->grpzip";
$grpemail = "$rs_result_q->grpemail";


echo "<form action=sr.php?func=submitsq2 method=post>";
echo "<table><tr><td style=\"vertical-align:top;width:50%;\"\"><table>";
echo "<tr><td>".pcrtlang("Your Name").":</td><td><input type=\"text\" class=\"form-control\" value=\"$pcgroupname\" required=required  name=\"sreq_name\" onFocus=\"this.form.submitbutton.disabled=false;this.form.submitbutton.value='".pcrtlang("Submit Service Request")."';\"></td></tr>";
echo "<tr><td>".pcrtlang("Company").":</td><td><input class=\"form-control\" type=text name=sreq_company value=\"$grpcompany\" ></td></tr>";
echo "<tr><td colspan=2><br>".pcrtlang("Please enter at least one phone number").".</td></tr>";
echo "<tr><td>".pcrtlang("Home Phone Number").":</td><td><input class=\"form-control\" size=18 type=text name=sreq_phone value=\"$grpphone\"></td></tr>";
echo "<tr><td>".pcrtlang("Mobile Phone Number").":</td><td><input class=\"form-control\" size=18 type=text name=sreq_cellphone value=\"$grpcellphone\" ></td></tr>";
echo "<tr><td>".pcrtlang("Work Phone Number").":</td><td><input class=\"form-control\"  size=18 type=text name=sreq_workphone value=\"$grpworkphone\" ></td></tr>";

echo "<tr><td>".pcrtlang("Email Address").":</td><td><input class=\"form-control\"  size=30 type=text name=sreq_email value=\"$grpemail\" ></td></tr>";

echo "<tr><td>$pcrt_address1:</td><td><input class=\"form-control\" type=text name=sreq_addy1 value=\"$grpaddress\" ></td></tr>";
echo "<tr><td>$pcrt_address2:</td><td><input class=\"form-control\"  type=text name=sreq_addy2 value=\"$grpaddress2\" ></td></tr>";
echo "<tr><td>$pcrt_city:</td><td><input class=\"form-control\"  size=18 type=text name=sreq_city value=\"$grpcity\" ></td></tr>";
echo "<tr><td>$pcrt_state:</td><td><input class=\"form-control\"  size=6 type=text name=sreq_state value=\"$grpstate\" ></td></tr>";
echo "<tr><td>$pcrt_zip:</td><td><input class=\"form-control\"  size=10 type=text name=sreq_zip value=\"$grpzip\" ></td></tr>";

echo "</table></td></tr><tr><td style=\"vertical-align:top\">";


echo pcrtlang("Service Requested/Problem").":<br><textarea class=\"form-control\"  name=sreq_problem required rows=10 style=\"width:90%\" onFocus=\"this.form.submitbutton.disabled=false;this.form.submitbutton.value='".pcrtlang("Submit Service Request")."';\"></textarea>";
echo "<br><br>".pcrtlang("Device Brand: ie. Dell, Apple, HP, etc")."<br><input class=\"form-control\"  size=36 type=text name=sreq_model>";
echo "<br><br>".pcrtlang("Device Type: ie. Laptop, PC, Tablet, etc")."<br><input class=\"form-control\"  size=36 type=text name=sreq_type>";

echo "<br><br>".pcrtlang("Computer/Device ID Number")."<br>".pcrtlang("If you have previously had your computer/device serviced with us, it may have a tag with an ID number on it. Please enter it here if you have one.")."<br><input class=\"form-control\"  size=36 type=text name=sreq_pcid>";


echo "<br><br><input class=\"btn btn-primary\" id=submitbutton type=submit value=\"".pcrtlang("Submit Service Request")."\" onclick=\"this.value='".pcrtlang("Sending Request")."...'; this.form.submit();\">";

echo "</td></tr></table></form>";

require_once("footer.php");
                                                                                                    
}


function submitsq2() {
require("deps.php");

require("common.php");
if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');


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
$sreq_pcid = pv($_REQUEST['sreq_pcid']);

$sreq_ip = $_SERVER['REMOTE_ADDR'];
$sreq_agent = $_SERVER['HTTP_USER_AGENT'];

$rs_insert_sq = "INSERT INTO servicerequests (sreq_ip,sreq_agent,sreq_name,sreq_company,sreq_homephone,sreq_cellphone,sreq_workphone,sreq_addy1,sreq_addy2,sreq_city,sreq_state,sreq_zip,sreq_email,sreq_problem,sreq_model,sreq_datetime,sreq_pcid) VALUES ('$sreq_ip','$sreq_agent','$sreq_name','$sreq_company','$sreq_phone','$sreq_cellphone','$sreq_workphone','$sreq_addy1','$sreq_addy2','$sreq_city','$sreq_state','$sreq_zip','$sreq_email','$sreq_problem','$sreq_model $sreq_type','$currentdatetime','$sreq_pcid')";
@mysqli_query($rs_connect, $rs_insert_sq);

header("Location: sr.php?sent=1");

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
