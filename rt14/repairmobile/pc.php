<?php
                                                                                                    
/***************************************************************************
 *   copyright            : (C) 2019 PCRepairTracker.com
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

                                                                                                    
function addpc() {

require_once("dheader.php");
require("deps.php");
require_once("common.php");




if (array_key_exists('copypcid',$_REQUEST)) {
$rs_findowner = "SELECT * FROM pc_owner WHERE pcid = '$_REQUEST[copypcid]'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
$rs_result_q2 = mysqli_fetch_object($rs_result2);
$pcname = "$rs_result_q2->pcname";
$pccompany = "$rs_result_q2->pccompany";
$pcphone = "$rs_result_q2->pcphone";
$pcemail = "$rs_result_q2->pcemail";
$pcaddress = "$rs_result_q2->pcaddress";
$pccellphone = "$rs_result_q2->pccellphone";
$pcworkphone = "$rs_result_q2->pcworkphone";
$pcaddress2 = "$rs_result_q2->pcaddress2";
$pccity = "$rs_result_q2->pccity";
$pcstate = "$rs_result_q2->pcstate";
$pczip = "$rs_result_q2->pczip";
$pcgroupid = "$rs_result_q2->pcgroupid";
$custsourceid = "$rs_result_q2->custsourceid";
$prefcontact = "$rs_result_q2->prefcontact";
} else {

if (array_key_exists('pcname',$_REQUEST)) {
$pcname = $_REQUEST['pcname'];
} else {
$pcname = "";
}

if (array_key_exists('pccompany',$_REQUEST)) {
$pccompany = $_REQUEST['pccompany'];
} else {
$pccompany = "";
}

if (array_key_exists('pcphone',$_REQUEST)) {
$pcphone = $_REQUEST['pcphone'];
} else {
$pcphone = "";
}

if (array_key_exists('pcemail',$_REQUEST)) {
$pcemail = $_REQUEST['pcemail'];
} else {
$pcemail = "";
}

if (array_key_exists('pcaddress',$_REQUEST)) {
$pcaddress = $_REQUEST['pcaddress'];
} else {
$pcaddress = "";
}

if (array_key_exists('pcaddress2',$_REQUEST)) {
$pcaddress2 = $_REQUEST['pcaddress2'];
} else {
$pcaddress2 = "";
}

if (array_key_exists('pccity',$_REQUEST)) {
$pccity = $_REQUEST['pccity'];
} else {
$pccity = "";
}

if (array_key_exists('pcstate',$_REQUEST)) {
$pcstate = $_REQUEST['pcstate'];
} else {
$pcstate = "";
}

if (array_key_exists('pczip',$_REQUEST)) {
$pczip = $_REQUEST['pczip'];
} else {
$pczip = "";
}

if (array_key_exists('pccellphone',$_REQUEST)) {
$pccellphone = $_REQUEST['pccellphone'];
} else {
$pccellphone = "";
}

if (array_key_exists('pcworkphone',$_REQUEST)) {
$pcworkphone = $_REQUEST['pcworkphone'];
} else {
$pcworkphone = "";
}

if (array_key_exists('pcgroupid',$_REQUEST)) {
$pcgroupid2 = $_REQUEST['pcgroupid'];
if($pcgroupid2 == "") {
$pcgroupid = "0";
} else {
$pcgroupid = $_REQUEST['pcgroupid'];
}
} else {
$pcgroupid = "";
}

if (array_key_exists('custsourceid',$_REQUEST)) {
$custsourceid2 = $_REQUEST['custsourceid'];
if($custsourceid2 == "") {
$custsourceid = "0";
} else {
$custsourceid = $_REQUEST['custsourceid'];
}
} else {
$custsourceid = "";
}

if (array_key_exists('prefcontact',$_REQUEST)) {
$prefcontact2 = $_REQUEST['prefcontact'];
if($prefcontact2 == "") {
$prefcontact = "none";
} else {
$prefcontact = $_REQUEST['prefcontact'];
}
} else {
$prefcontact = "none";
}


}

if (array_key_exists('pcproblem',$_REQUEST)) {
$pcproblem = $_REQUEST['pcproblem'];
} else {
$pcproblem = "";
}

if (array_key_exists('pcmake',$_REQUEST)) {
$pcmake = pf($_REQUEST['pcmake']);
} else {
$pcmake = "";
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
$sreq_id = "0";
}

if (array_key_exists('custsourceid',$_REQUEST)) {
$passedcustsourceid = $_REQUEST['custsourceid'];
} else {
$passedcustsourceid = "0";
}


echo "<div data-role=\"header\" data-theme=\"b\"><h2>".pcrtlang("New Check-In")."</h2></div>";
echo "<div class=\"ui-content\" role=\"main\">";

echo "<form action=pc.php?func=addpc2 method=post>";
echo pcrtlang("Customer Name").":<input autofocus type=text name=custname value=\"$pcname\" required=required onFocus=\"this.form.submitbutton.disabled=false;this.form.submitbutton.value='".pcrtlang("Check in Asset/Device")."';\">";
echo pcrtlang("Company").":<input type=text name=pccompany value=\"$pccompany\">";
echo pcrtlang("Customer Phone").":<input type=text  name=custphone value=\"$pcphone\">";
echo pcrtlang("Customer Mobile Phone").":<input type=text  name=custcellphone value=\"$pccellphone\">";
echo pcrtlang("Customer Work Phone").":<input type=text  name=custworkphone value=\"$pcworkphone\">";

echo pcrtlang("Preferred Contact Method").":";


echo "<fieldset data-role=\"controlgroup\">";

if(($prefcontact == "none") || ($prefcontact == "")) {
echo "<input checked type=radio id=none name=prefcontact value=\"none\"><label for=none>".pcrtlang("none")."</label>";
} else {
echo "<input type=radio id=none name=prefcontact value=\"none\"><label for=none>".pcrtlang("none")."</label>";
}

if($prefcontact == "home") {
echo "<input checked type=radio id=home name=prefcontact value=\"home\"><label for=home>".pcrtlang("Home Phone")."</label>";
} else {
echo "<input type=radio id=home name=prefcontact value=\"home\"><label for=home>".pcrtlang("Home Phone")."</label>";
}

if($prefcontact == "mobile") {
echo "<input checked type=radio id=mobile name=prefcontact value=\"mobile\"><label for=mobile>".pcrtlang("Mobile Phone")."</label>";
} else {
echo "<input type=radio id=mobile name=prefcontact value=\"mobile\"><label for=mobile>".pcrtlang("Mobile Phone")."</label>";
}

if($prefcontact == "work") {
echo "<input checked type=radio id=work name=prefcontact value=\"work\"><label for=work>".pcrtlang("Work Phone")."</label>";
} else {
echo "<input type=radio id=work name=prefcontact value=\"work\"><label for=work>".pcrtlang("Work Phone")."</label>";
}

if($prefcontact == "sms") {
echo "<input checked type=radio id=sms name=prefcontact value=\"sms\"><label for=sms>SMS</label>";
} else {
echo "<input type=radio id=sms name=prefcontact value=\"sms\"><label for=sms>SMS</label>";
}

if($prefcontact == "email") {
echo "<input checked type=radio id=email name=prefcontact value=\"email\"><label for=email>".pcrtlang("Email")."</label>";
} else {
echo "<input type=radio id=email name=prefcontact value=\"email\"><label for=email>".pcrtlang("Email")."</label>";
}

echo "</fieldset>";




echo pcrtlang("Priority").":";

echo "<fieldset data-role=\"controlgroup\">";

echo "<input checked type=radio id=\"Not Set\" name=pcpriority value=\"\"><label for=\"Not Set\">".pcrtlang("Not Set")."</label>";
foreach($pcpriority as $key => $val) {
echo "<input type=radio id=\"$key\" name=pcpriority value=\"$key\"><label for=\"$key\">";
if($val != "") {
echo "<img src=../repair/images/$val align=absmiddle>";
}
echo " $key</label>";
}

echo "</fieldset>";


echo pcrtlang("Asset/Device Make/Model").":<input type=text  name=pcmake value=\"$pcmake\" onFocus=\"this.form.submitbutton.disabled=false;this.form.submitbutton.value='".pcrtlang("Check in Asset/Device")."';\">";

echo pcrtlang("Asset/Device Type").":";
echo "<select name=assettype id=assettype data-native-menu=\"false\">";

$rs_findassettypes = "SELECT * FROM mainassettypes ORDER BY mainassetname ASC";
$rs_resultfat = mysqli_query($rs_connect, $rs_findassettypes);
while($rs_result_qfat = mysqli_fetch_object($rs_resultfat)) {
$mainassettypeidid = "$rs_result_qfat->mainassettypeid";
$mainassetname = "$rs_result_qfat->mainassetname";
$mainassetdefault = "$rs_result_qfat->mainassetdefault";
if($mainassetdefault == "1") {
echo "<option selected value=$mainassettypeidid>$mainassetname</option>";
$mainassettypedefaultid = $mainassettypeidid;
} else {
echo "<option value=$mainassettypeidid>$mainassetname</option>";
}
}


echo "</select>";



echo pcrtlang("Scheduled Job?").":";

echo "<fieldset data-role=\"controlgroup\">";
echo "<input type=radio checked name=sked value=no id=checkbox1sked><label for=\"checkbox1sked\">".pcrtlang("No")."</label>";
echo "<input type=radio name=sked value=yes id=checkbox2sked> <label for=\"checkbox2sked\">".pcrtlang("Yes")."</label>\n";
echo "</fieldset>";

$thedate = date("Y-m-d");
echo pcrtlang("Scheduled Date/Time").":";


echo "<input type=date  name=skedday value=\"$thedate\">";


picktime('timepick',"8:00 AM");


echo pcrtlang("Promised").":";

echo "<select name=servicepromiseid>";
echo "<option selected value=0>".pcrtlang("Not Set")."</option>";
$rs_findpromises = "SELECT * FROM servicepromises ORDER BY theorder DESC";
$rs_resultsp = mysqli_query($rs_connect, $rs_findpromises);
while($rs_result_qsp = mysqli_fetch_object($rs_resultsp)) {
$servicepromiseid = "$rs_result_qsp->servicepromiseid";
$sptitle = "$rs_result_qsp->sptitle";
echo "<option value=$servicepromiseid>$sptitle</option>";
}
echo "</select>";


echo pcrtlang("Notes").":<textarea  name=pcnotes></textarea>";


?>
<script type="text/javascript">
  $.get('pc.php?func=pullsubasset&assettype=<?php echo "$mainassettypedefaultid"; ?>', function(data) {
    $('#subassets').html(data);
  });

  $.get('pc.php?func=pullinfofields&assettype=<?php echo "$mainassettypedefaultid"; ?>', function(data) {
    $('#assetinfofields').html(data);
  });


</script>

<script type="text/javascript">
$('#assettype').change(function() {
    $('#subassets').load('pc.php?func=pullsubasset&', {assettype: $(this).val()});
});

$('#assettype').change(function() {
    $('#assetinfofields').load('pc.php?func=pullinfofields&', {assettype: $(this).val()});
});
</script>

<?php
echo pcrtlang("Asset/Device Accessories").":";
echo "<div id=\"subassets\" class=subassets></div>";




echo pcrtlang("Username").":<input type=text  name=creduser>";
echo pcrtlang("Password").":<input type=text  name=thepass>";
echo pcrtlang("PIN").":<input type=text  name=thepin>";


echo pcrtlang("Description of Problem")."<br>".pcrtlang("Work to be Performed").":";
echo "<textarea name=prob_desc>$pcproblem</textarea>";

#####

$comprobarray = array();
$rs_chkscans = "SELECT theproblem FROM commonproblems";
$rs_chkresult_s = mysqli_query($rs_connect, $rs_chkscans);
while($rs_chkresult_q_s = mysqli_fetch_object($rs_chkresult_s)) {
$theprob = "$rs_chkresult_q_s->theproblem";
array_push($comprobarray,"$theprob");
}

$comprobarraycustv = array();
$rs_chkscansv = "SELECT theproblem FROM commonproblems WHERE custviewable = '1'";
$rs_chkresult_sv = mysqli_query($rs_connect, $rs_chkscansv);
while($rs_chkresult_q_sv = mysqli_fetch_object($rs_chkresult_sv)) {
$theprobv = "$rs_chkresult_q_sv->theproblem";
array_push($comprobarraycustv,"$theprobv");
}


echo pcrtlang("Common Problems or Requests")."<br>".pcrtlang("Items in blue appear on customer printouts");

echo "<fieldset data-role=\"controlgroup\">";

foreach($comprobarray as $key => $val) {
if (in_array("$val",$comprobarraycustv)) {
echo "<input type=checkbox name=\"theprobs[]\" id=\"$key\" value=\"$val\"> <label for=\"$key\"><font style=\"color:#0000ff;\">$val</font></label>";
} else {
echo "<input type=checkbox name=\"theprobs[]\" id=\"$key\" value=\"$val\"> <label for=\"$key\">$val</label>";
}
}

echo "</fieldset>";

echo "<br>";

####


echo pcrtlang("Customer Source");

echo "<select name=custsourceid data-native-menu=\"false\">";
echo "<option value=0>".pcrtlang("Not Set")."</option>";
$rs_findsource = "SELECT * FROM custsource WHERE sourceenabled != '0' ORDER BY thesource ASC";
$rs_resultcs = mysqli_query($rs_connect, $rs_findsource);
while($rs_result_qcs = mysqli_fetch_object($rs_resultcs)) {
$custsourceid = "$rs_result_qcs->custsourceid";
$thesource = "$rs_result_qcs->thesource";
$sourceicon = "$rs_result_qcs->sourceicon";
if($passedcustsourceid == "$custsourceid") {
echo "<option selected value=$custsourceid>$thesource</option>";
} else {
echo "<option value=$custsourceid>$thesource</option>";
}
}
echo "</select>";




echo "<h3>".pcrtlang("Other Contact Info")."</h3>";
echo pcrtlang("Email Address").":<input type=text name=pcemail value=\"$pcemail\">";

echo "$pcrt_address1<input type=text name=pcaddress value=\"$pcaddress\">";

echo "$pcrt_address2<input type=text  name=pcaddress2 value=\"$pcaddress2\">";
echo "$pcrt_city<input type=text  name=pccity value=\"$pccity\">";
echo "$pcrt_state<input type=text  name=pcstate value=\"$pcstate\">";
echo "$pcrt_zip<input type=text  name=pczip value=\"$pczip\">";


echo "<div id=\"assetinfofields\" class=assetsinfofields></div>";


####
echo "<h3>".pcrtlang("Other Options")."</h3>";


echo pcrtlang("Create New Group?").":";

echo "<fieldset data-role=\"controlgroup\">";
echo "<input type=radio checked name=creategroup value=no id=checkbox1> <label for=\"checkbox1\">".pcrtlang("No")."</label>";
echo "<input type=radio name=creategroup value=yes id=checkbox2> <label for=\"checkbox2\">".pcrtlang("Yes")."</label>";

echo "</fieldset>";

echo pcrtlang("Assign to User").":";
if ($ipofpc == "admin") {
$rs_find_users = "SELECT * FROM users";
} else {
$rs_find_users = "SELECT * FROM users WHERE username != 'admin'";
}
$rs_result_users = mysqli_query($rs_connect, $rs_find_users);
echo "<select name=uname>";
echo "<option selected value=\"\">".pcrtlang("Assign User")."?</option>";
echo "<option selected value=\"\" selected>".pcrtlang("No Assigned User")."</option>";
while($rs_result_uq = mysqli_fetch_object($rs_result_users)) {
$rs_uname = "$rs_result_uq->username";
echo "<option value=$rs_uname>$rs_uname</option>";
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




echo "<input type=hidden name=storeid value=$storeid><input type=hidden name=sreq_id value=$sreq_id><input type=hidden name=pcgroupid value=$pcgroupid>";
echo "<button class=ibutton id=submitbutton type=button onclick=\"this.disabled=true;document.getElementById('submitbutton').innerHTML = '".pcrtlang("Saving")."...'; this.form.submit();\" data-theme=\"b\"><i class=\"fa fa-sign-in fa-lg\"></i> ".pcrtlang("Check in Asset/Device")."</button>";

echo "</form>";


echo "</div>";


require_once("dfooter.php");
                                                                                                    
}

function addpc2() {
require_once("validate.php");
require("deps.php");
require("common.php");       


if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

$custname = pv($_REQUEST['custname']);
$pccompany = pv($_REQUEST['pccompany']);
$custphone = pv($_REQUEST['custphone']);
$custcellphone = pv($_REQUEST['custcellphone']);
$custworkphone = pv($_REQUEST['custworkphone']);
$pcmake = pv($_REQUEST['pcmake']);
$prob_desc = pv($_REQUEST['prob_desc']);
$thepass = pv($_REQUEST['thepass']);
$pcpriority = pv($_REQUEST["pcpriority"]);
$creategroup = $_REQUEST['creategroup'];
$assettype = $_REQUEST['assettype'];

if (array_key_exists('assets',$_REQUEST)) {
$assets = $_REQUEST["assets"];
} else {
$assets = array();
}


if (array_key_exists('theprobs',$_REQUEST)) {
$theprobs = $_REQUEST["theprobs"];
} else {
$theprobs = array();
}          

$custompcinfounser = $_REQUEST['custompcinfo'];

$pcemail = pv($_REQUEST['pcemail']);
$pcaddress = pv($_REQUEST['pcaddress']);
$pcaddress2 = pv($_REQUEST['pcaddress2']);
$pccity = pv($_REQUEST['pccity']);
$pcstate = pv($_REQUEST['pcstate']);
$pczip = pv($_REQUEST['pczip']);
$pcgroupid = $_REQUEST['pcgroupid'];
$custsourceid = $_REQUEST['custsourceid'];
$prefcontact = $_REQUEST['prefcontact'];
$uname = pv($_REQUEST["uname"]);
$pcnotes = pv($_REQUEST['pcnotes']);
$storeid = $_REQUEST['storeid'];
$sreq_id = $_REQUEST['sreq_id'];
$skedday = $_REQUEST['skedday'];
$sked_opt = $_REQUEST['sked'];
$servicepromiseid = $_REQUEST['servicepromiseid'];

if($sked_opt == "yes") {
$sked = 1;
$sked_datetime = date('Y-m-d H:i:s', strtotime("$skedday $_REQUEST[timepick]"));
} else {
$sked = 0;
$sked_datetime = "0000-00-00 00:00:00";
}

if ($custname == "") { die(pcrtlang("Please go back and enter the customers name.")); }
                                      
if(!is_array($custompcinfounser)) {
$custompcinfounser = array();
}
                          
$custompcinfo3 = array_filter($custompcinfounser);


$custompcinfo2 = pv(serialize($custompcinfo3));





$rs_insert_pc = "INSERT INTO pc_owner (pcname,pcphone,pccellphone,pcworkphone,pcmake,pcemail,pcaddress,pcaddress2,pccity,pcstate,pczip,pcextra,pcgroupid,custsourceid,prefcontact,pcnotes,pccompany,mainassettypeid) VALUES ('$custname','$custphone','$custcellphone','$custworkphone','$pcmake','$pcemail','$pcaddress','$pcaddress2','$pccity','$pcstate','$pczip','$custompcinfo2','$pcgroupid','$custsourceid','$prefcontact','$pcnotes','$pccompany','$assettype')";
@mysqli_query($rs_connect, $rs_insert_pc);
                               
$lastinsert = mysqli_insert_id($rs_connect);

if(($thepass != "") || ($creduser != "")) {
$set_np = "INSERT INTO creds (creddesc,creduser,credpass,pcid,credtype,creddate)
VALUES ('Login','$creduser','$thepass','$lastinsert','1','$currentdatetime')";
@mysqli_query($rs_connect, $set_np);
}



if($thepin != "") {
$set_np = "INSERT INTO creds (creddesc,credpass,pcid,credtype,creddate)
VALUES ('Pin','$thepin','$lastinsert','2','$currentdatetime')";
@mysqli_query($rs_connect, $set_np);
}



if ($creategroup == "yes") {
$rs_insert_group = "INSERT INTO pc_group (pcgroupname,grpphone,grpcellphone,grpworkphone,grpemail,grpaddress1,grpaddress2,grpcity,grpstate,grpzip,grpcompany) VALUES ('$custname','$custphone','$custcellphone','$custworkphone','$pcemail','$pcaddress','$pcaddress2','$pccity','$pcstate','$pczip','$pccompany')";
@mysqli_query($rs_connect, $rs_insert_group);
$pcgroupid = mysqli_insert_id($rs_connect);
$rs_set_group = "UPDATE pc_owner SET pcgroupid = '$pcgroupid' WHERE pcid = '$lastinsert'";
@mysqli_query($rs_connect, $rs_set_group);
}

if($sreq_id != 0) {
$rs_close_req = "UPDATE servicerequests SET sreq_processed = '1' WHERE sreq_id = '$sreq_id'";
@mysqli_query($rs_connect, $rs_close_req);
}


$assets3 = array_filter($assets);
$assets2 = serialize($assets3);


if (is_array($theprobs)) {
$theprobs4 = $theprobs;
} else {
$theprobs4 = array();
}


if($servicepromiseid != 0) {
$rs_findpromises = "SELECT * FROM servicepromises WHERE servicepromiseid = '$servicepromiseid'";
$rs_resultsp = mysqli_query($rs_connect, $rs_findpromises);
$rs_result_qsp = mysqli_fetch_object($rs_resultsp);
$servicepromiseid = "$rs_result_qsp->servicepromiseid";
$sptitle = "$rs_result_qsp->sptitle";
$sptype = "$rs_result_qsp->sptype";
$sptime = "$rs_result_qsp->sptime";
$sptimeofday = "$rs_result_qsp->sptimeofday";

if($sked == 1) {
$datetimetouse = "$sked_datetime";
} else {
$datetimetouse = "$currentdatetime";
}


if($sptype == 1) {
$promisedtime = date('Y-m-d H:i:s', (strtotime($datetimetouse) + $sptime));
} else {
$promisedtime = date('Y-m-d'." $sptimeofday", (strtotime($datetimetouse) + $sptime));
}
} else {
$promisedtime = "0000-00-00 00:00:00";
}



$theprobs3 = array_filter($theprobs4);
$theprobs2 = pv(serialize($theprobs3));
$rs_insert_wo = "INSERT INTO pc_wo (pcid,probdesc,dropdate,pcstatus,thepass,custassets,cibyuser,commonproblems,pcpriority,storeid,assigneduser,sked,skeddate,servicepromiseid,promisedtime) VALUES ('$lastinsert','$prob_desc','$currentdatetime','1','$thepass','$assets2','$ipofpc','$theprobs2','$pcpriority','$storeid','$uname','$sked','$sked_datetime','$servicepromiseid','$promisedtime')";
@mysqli_query($rs_connect, $rs_insert_wo);

$lastinsert2 = mysqli_insert_id($rs_connect);
userlog(1,$lastinsert2,'woid','');

if ($uname != "") {
if(array_key_exists('notifyuseremail', $_REQUEST)) {
require_once("sendenotify.php");
$from = getuseremail("$uname");
$to = $from;
if ($from != "") {
$subject = pcrtlang("New Work Order Assignment");
$plaintext ="$custname\n$pcaddress\n$pcaddress2\n$pccity, $pcstate $pczip\n\n".pcrtlang("Home Phone").":\t$custphone\n".pcrtlang("Cell Phone").":\t$custcellphone\n".pcrtlang("Work Phone").":\t$custworkphone";
$plaintext .= "\n\n".pcrtlang("Email").": $pcemail\n\n".pcrtlang("Device").": $pcmake\n\n".pcrtlang("Problem").":\n$prob_desc\n".pcrtlang("Work Order")." #$lastinsert2\n";
$sreq_problem2 = nl2br($_REQUEST['prob_desc']);
$htmltext ="<b>$custname</b><br>$pcaddress<br>$pcaddress2<br>$pccity, $pcstate $pczip<br><br><b>".pcrtlang("Home Phone").":</b>$custphone<br><b>".pcrtlang("Cell_Phone").":</b>$custcellphone<br><b>".pcrtlang("Work Phone").":</b>$custworkphone";
$htmltext .= "<br><br><b>".pcrtlang("Email")."</b>:$pcemail<br><br><b>".pcrtlang("Device").":</b> $pcmake<br><br><b>".pcrtlang("Problem").":</b><br>$sreq_problem2<br><br><b>".pcrtlang("Work Order")."</b> #$lastinsert2<br><br>";
sendenotify("$from","$to","$subject","$plaintext","$htmltext");
}
}

if(array_key_exists('notifyusersms', $_REQUEST)) {
require_once("smsnotify.php");
$smsname  = $custname;
$usermobile = getusersmsnumber("$uname");
if($usermobile != "") {
$smsmessage = pcrtlang("New Work Order Assignment")." - $custname - ".pcrtlang("Work Order")." #$lastinsert2";
smssend("$usermobile","$smsmessage");
}
}
}

header("Location: pc.php?func=printclaimticket&woid=$lastinsert2");
                                                                                                                             
}

function stat_change() {
require_once("validate.php");
require("deps.php");
require("common.php");


$statnum = $_REQUEST['statnum'];
$woid = $_REQUEST['woid'];

$boxtitles = getboxtitles();

userlog(32,$woid,'woid',pcrtlang("Switched to")." &lt;$boxtitles[$statnum]&gt;");

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');


$rs_insert = "UPDATE pc_wo SET pcstatus = '$statnum' WHERE woid = '$woid'";
@mysqli_query($rs_connect, $rs_insert);

if (($statnum == 4) || ($statnum == 7) || ($statnum == 6)) {
$rs_update = "UPDATE pc_wo SET readydate = '$currentdatetime' WHERE woid = '$woid'";
@mysqli_query($rs_connect, $rs_update);
}

if ($statnum == 5) {
$rs_check = "UPDATE pc_wo SET pickupdate = '$currentdatetime', cobyuser = '$ipofpc' WHERE woid = '$woid' AND pickupdate = '0000-00-00 00:00:00'";
@mysqli_query($rs_connect, $rs_check);
userlog(2,$woid,'woid','');
}


header("Location: index.php?pcwo=$woid#workorderinfo");
                                                                                                                            
}




function add_scan() {
require_once("validate.php");                                                                                                                                               
require("deps.php");
require("common.php");

$woid = $_REQUEST['woid'];
if (!array_key_exists("scanprog", $_REQUEST)) {
die("You must choose an option before hitting the button");
}

$scanprogarray = $_REQUEST['scanprog'];
$thecount = $_REQUEST['thecount'];




if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

foreach($scanprogarray as $key => $scanprog) {

$findname = "SELECT progname FROM pc_scans WHERE scanid = '$scanprog'";
$findnameq = mysqli_query($rs_connect, $findname);
$rs_result = mysqli_fetch_object($findnameq);
$progname = "$rs_result->progname";


$rs_insert_scan = "INSERT INTO pc_scan (scantype,scannum,woid,scantime,byuser) VALUES ('$scanprog','$thecount','$woid','$currentdatetime','$ipofpc')";
@mysqli_query($rs_connect, $rs_insert_scan);

$findname = "SELECT progname FROM pc_scans WHERE scanid = '$scanprog'";
$findnameq = mysqli_query($rs_connect, $findname);
$rs_result = mysqli_fetch_object($findnameq);
$progname = "$rs_result->progname";


userlog(3,$woid,'woid',"$progname");

}

header("Location: index.php?pcwo=$woid#scans");


}


function rm_scan() {
require_once("validate.php");
require("deps.php");

$woid = $_REQUEST['woid'];
$scanid = $_REQUEST['scanid'];





$rs_del_scan = "DELETE FROM pc_scan WHERE scanid = '$scanid'";
@mysqli_query($rs_connect, $rs_del_scan);
 
header("Location: index.php?pcwo=$woid#scans");
                                                                                                                           
                                                                                                                                               
}

function checkout() {
require_once("validate.php");                                                                                                                                               
require("deps.php");
require("common.php");

$woid = $_REQUEST['woid'];

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');





$rs_check = "UPDATE pc_wo SET pcstatus = '5', pickupdate = '$currentdatetime', cobyuser = '$ipofpc' WHERE woid = '$woid'";
@mysqli_query($rs_connect, $rs_check);

userlog(2,$woid,'woid','');

header("Location: index.php?pcwo=$woid#workorderinfo");

}

function view() {

$woid = $_REQUEST['woid'];


require("header.php");
require("deps.php");






$rs_findpc = "SELECT * FROM pc_wo WHERE woid = '$woid'";
$rs_result = mysqli_query($rs_connect, $rs_findpc);
while($rs_result_q = mysqli_fetch_object($rs_result)) {
$pcid = "$rs_result_q->pcid";
$probdesc = "$rs_result_q->probdesc";
$dropoff = "$rs_result_q->dropdate";
$pickup = "$rs_result_q->pickupdate";
$pcstatus = "$rs_result_q->pcstatus";
$cobyuser = "$rs_result_q->cobyuser";
$cibyuser = "$rs_result_q->cibyuser";
$theprobsindb = serializedarraytest("$rs_result_q->commonproblems");
$assigneduser = "$rs_result_q->assigneduser";



$rs_findowner = "SELECT * FROM pc_owner WHERE pcid = '$pcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
while($rs_result_q2 = mysqli_fetch_object($rs_result2)) {
$pcname = "$rs_result_q2->pcname";
$pccompany = "$rs_result_q2->pccompany";
$pcphone = "$rs_result_q2->pcphone";
$pccellphone = "$rs_result_q2->pccellphone";
$pcworkphone = "$rs_result_q2->pcworkphone";
$pcmake = "$rs_result_q2->pcmake";
$pcaddress = "$rs_result_q2->pcaddress";
$pcaddress2 = "$rs_result_q2->pcaddress2";
$pccity = "$rs_result_q2->pccity";
$pcstate = "$rs_result_q2->pcstate";
$pczip = "$rs_result_q2->pczip";
$pcemail = "$rs_result_q2->pcemail";


if("$pccompany" == "") {
$fillit = "$pcname &bull; $pcmake";
} else {
$fillit = "$pcname &bull; $pccompany &bull; $pcmake";
}


echo "<table class=standard><tr><th>$fillit</th></tr><tr><td>";


echo pcrtlang("Viewing Work Order").": $woid";

echo "<br>".pcrtlang("Make/Model").": $pcmake<br> ";

echo "<table border=0 cellspacing=0 cellpadding=2><tr><td bgcolor=#0000ff><i class=\"fa fa-phone fa-lg\" style=\"padding:20px 3px;color:white;\"></i></td><td>";

if($pcphone != "") {
echo "&nbsp;".pcrtlang("Home").": $pcphone<br>";
}

if($pccellphone != "") {
echo "&nbsp;".pcrtlang("Mobile").": $pccellphone<br>";
}

if($pcworkphone != "") {
echo "&nbsp;".pcrtlang("Work").": $pcworkphone";
}

echo "</td></tr></table><br>";



if($pcaddress != "") {
$pcaddressbr = nl2br($pcaddress);
echo "<table cellpadding=2 cellspacing=0 border=0><tr><td bgcolor=#0000ff><i class=\"fa fa-map-marker fa-lg\" style=\"padding:20px 5px;color:white;\"></i></td><td>$pcaddressbr<br>";
if($pcaddress2 != "") {
echo "$pcaddress2<br>";
}
if(($pccity != "") && ($pcstate != "") && ($pczip != "")) {
echo "$pccity, $pcstate $pczip";
}
echo "</td></tr></table>";
}



if($pcemail != "") {
echo "".pcrtlang("Email").": <a href=mailto:$pcemail>$pcemail</a><br>";
}



$pickdate = date("F j, Y, g:i a", strtotime($pickup));
$dropdate = date("F j, Y, g:i a", strtotime($dropoff));

echo "".pcrtlang("Dropped Off on").": $dropdate<br>";

if ($cibyuser != "") {
echo "".pcrtlang("Checked In By").": $cibyuser<br>";
}

if ($assigneduser != "") {
echo "".pcrtlang("Assigned To").": $assigneduser<br>";
}



if ($pcstatus == 5) {
echo "".pcrtlang("Picked-Up on").": $pickdate<br>";

if ($cobyuser != "") {
echo "".pcrtlang("Checked Out by").": $cobyuser<br>";
}


}


echo "</td></tr></table><br>";

echo "<table class=standard><tr><th>".pcrtlang("Problem as Described by Customer")."</th></tr><tr><td>$probdesc<br><br>";

foreach($theprobsindb as $key => $val) {
echo "&bull; $val<br>";
}

echo "</td></tr></table>";



echo "<br><br>";


########


echo "<table class=standard><tr><th>".pcrtlang("Notes for Customer").":&nbsp;($pcname)</th></tr><tr><td>";

$rs_findnotes = "SELECT * FROM wonotes WHERE woid = '$woid' AND notetype = '0' ORDER BY notetime ASC";
$rs_result_n = mysqli_query($rs_connect, $rs_findnotes);
$bubblego = "first";
$usercomm = array();
while($rs_result_qn = mysqli_fetch_object($rs_result_n)) {
$thenote = nl2br("$rs_result_qn->thenote");
$noteuser = "$rs_result_qn->noteuser";
$notetype = "$rs_result_qn->notetype";
$noteid = "$rs_result_qn->noteid";
$notetime2 = "$rs_result_qn->notetime";
$notetime =  date('g:ia n-j-Y', strtotime($notetime2));

echo "<strong>$noteuser $notetime</strong><br>";
echo "$thenote";

}

echo "</td></tr></table><br>";
#######tech notes

echo "<table class=standard><tr><th>".pcrtlang("Technician Only Notes/Billing Instructions").":&nbsp;($pcname)</th></tr><tr><td>";

$rs_findnotes = "SELECT * FROM wonotes WHERE woid = '$woid' AND notetype = '1' ORDER BY notetime ASC";
$rs_result_n = mysqli_query($rs_connect, $rs_findnotes);
$bubblego = "first";
$usercomm = array();
while($rs_result_qn = mysqli_fetch_object($rs_result_n)) {
$thenote = nl2br("$rs_result_qn->thenote");
$noteuser = "$rs_result_qn->noteuser";
$noteid = "$rs_result_qn->noteid";
$notetype = "$rs_result_qn->notetype";
$notetime2 = "$rs_result_qn->notetime";
$notetime =  date('g:ia n-j-Y', strtotime($notetime2));

echo "<strong>$noteuser $notetime</strong><br>";
echo "$thenote";

}

echo "</td></tr></table>";

######


$rs_asql2 = "SELECT * FROM attachments WHERE woid = '$woid'";
$rs_result1asql2 = mysqli_query($rs_connect, $rs_asql2);
$total_attachments2 = mysqli_num_rows($rs_result1asql2);

if ($total_attachments2 > 0) {
echo "<table>";
echo pcrtlang("Work Order Attachments").":<br>";
while($rs_result_asql12 = mysqli_fetch_object($rs_result1asql2)) {
$attach_id2 = "$rs_result_asql12->attach_id";
$attach_title2 = "$rs_result_asql12->attach_title";
$attach_size2 = "$rs_result_asql12->attach_size";
$attach_filename2 = "$rs_result_asql12->attach_filename";
$fileextpc2 = mb_strtolower(mb_substr(mb_strrchr($attach_filename2, "."), 1));

if($attach_size2 == 0) {
$thebytes2 = "";
} else {
$thebytes2 = " - ".formatBytes($attach_size2);
}

if(filter_var($attach_filename2, FILTER_VALIDATE_URL)) {
        $fileextpc2 = 'url';
        $attach_link2 = $attach_filename2.' target=_blank';
} else {
        $attach_link2 = "attachment.php?func=get&attach_id=$attach_id2";
}


echo "<tr><td style=\"text-align:right\"><font style=\"border-right: 7px solid #0000FF\">$fileextpc2</font></td><td>";
echo "<a href=$attach_link2>$attach_title2</a>$thebytes2</td></tr>";
}
echo "</table><br>";
}




$rs_findpic = "SELECT * FROM assetphotos WHERE pcid = '$pcid' AND highlight='1'";
$rs_resultpic2 = mysqli_query($rs_connect, $rs_findpic);

if (mysqli_num_rows($rs_resultpic2) != "0") {
$rs_resultpic_q2 = mysqli_fetch_object($rs_resultpic2);
$assetphotoid = "$rs_resultpic_q2->assetphotoid";
echo "<br><img src=pc.php?func=getpcimage&photoid=$assetphotoid border=1 width=256><br><br>";
}



echo "<table class=standard><tr><th colspan=2>".pcrtlang("Actions")."</th></tr>";
$rs_foundscan = "SELECT * FROM pc_scan WHERE woid = '$woid' ORDER BY scantime ASC";
$rs_result_fs = mysqli_query($rs_connect, $rs_foundscan);
while($rs_result_fsr = mysqli_fetch_object($rs_result_fs)) {
$scanid = "$rs_result_fsr->scanid";
$scantype = "$rs_result_fsr->scantype";
$scannum = "$rs_result_fsr->scannum";
$scantime = "$rs_result_fsr->scantime";
$customprogname = "$rs_result_fsr->customprogname";
$customprogword = "$rs_result_fsr->customprogword";
$customprintinfo = "$rs_result_fsr->customprintinfo";

if ($scantype != 0) {
$rs_foundscan_name = "SELECT * FROM pc_scans WHERE scanid = '$scantype'";
$rs_result_fs_name = mysqli_query($rs_connect, $rs_foundscan_name);
$rs_result_fsr_name = mysqli_fetch_object($rs_result_fs_name);
$scantypeid = "$rs_result_fsr_name->scanid";
$scantypeprog = "$rs_result_fsr_name->progword";
$scantypeicon = "$rs_result_fsr_name->progicon";
}

echo "<tr><td>";

if ($scantype == 0) {
echo "<img src=../repair/images/hand.png>";
} else {
echo "<img src=../repair/images/scans/$scantypeicon>";
}

echo "</td><td>";
if ($customprogword != "") {
echo "$customprogword";
} else {
echo "$scantypeprog";
}
echo " ";
if ($scannum != 0) {
echo " - $scannum ".pcrtlang("item(s) found")."";
}

echo "</td></tr>";


}
echo "</table>";


}
}
         
echo "<button type=button onClick=\"parent.location='index.php?pcwo=$woid'\"><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("Edit this Work Order")."</button>";
echo "<button type=button onClick=\"parent.location='pc.php?func=printit&woid=$woid&backto=view'\"><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Print Repair Report")."</button>";
echo "<button type=button onClick=\"parent.location='pc.php?func=returnpc2&pcid=$pcid'\"><i class=\"fa fa-reply-all fa-lg\"></i> ".pcrtlang("Create New WO for this Device")."</button>";


require("footer.php");
 
}                                                                                                                             
                                                                                                                                               



function printit() {
require_once("validate.php");
require("deps.php");
require("common.php");

$woid = $_REQUEST['woid'];

userlog(5,$woid,'woid','');





$rs_findpc = "SELECT * FROM pc_wo WHERE woid = '$woid'";
$rs_result = mysqli_query($rs_connect, $rs_findpc);
while($rs_result_q = mysqli_fetch_object($rs_result)) {
$pcid = "$rs_result_q->pcid";
$probdesc = "$rs_result_q->probdesc";
$dropoff = "$rs_result_q->dropdate";
$pickup = "$rs_result_q->pickupdate";
$pcstatus = "$rs_result_q->pcstatus";
$custassetsindb2 = "$rs_result_q->custassets";
$rs_storeid = "$rs_result_q->storeid";
$thesigwo = "$rs_result_q->thesigwo";
$showsigrr = "$rs_result_q->showsigrr";
$thesigwotopaz = "$rs_result_q->thesigwotopaz";
$showsigrrtopaz = "$rs_result_q->showsigrrtopaz";
$wochecks = "$rs_result_q->wochecks";

$storeinfoarray = getstoreinfo($rs_storeid);

$theprobsindb2 = "$rs_result_q->commonproblems";

$theprobsindb = serializedarraytest($theprobsindb2);

$comprobarrayv = array();
$rs_chkscansv = "SELECT theproblem FROM commonproblems WHERE custviewable = '1'";
$rs_chkresult_sv = mysqli_query($rs_connect, $rs_chkscansv);
while($rs_chkresult_q_sv = mysqli_fetch_object($rs_chkresult_sv)) {
$theprobv = "$rs_chkresult_q_sv->theproblem";
array_push($comprobarrayv,"$theprobv");
}

$custassetsindb = serializedarraytest($custassetsindb2);

$rs_findowner = "SELECT * FROM pc_owner WHERE pcid = '$pcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
while($rs_result_q2 = mysqli_fetch_object($rs_result2)) {
$pcname = "$rs_result_q2->pcname";
$pccompany = "$rs_result_q2->pccompany";
$pcphone = "$rs_result_q2->pcphone";
$pccellphone = "$rs_result_q2->pccellphone";
$pcworkphone = "$rs_result_q2->pcworkphone";
$pcmake = "$rs_result_q2->pcmake";
$pcemail = "$rs_result_q2->pcemail";
$pcaddress = "$rs_result_q2->pcaddress";
$pcaddress2 = "$rs_result_q2->pcaddress2";
$pccity = "$rs_result_q2->pccity";
$pcstate = "$rs_result_q2->pcstate";
$pczip = "$rs_result_q2->pczip";
$pcextra2 = "$rs_result_q2->pcextra";
$pcextra = serializedarraytest($pcextra2);
$mainassettypeidindb = "$rs_result_q2->mainassettypeid";

$pcemail2 = urlencode("$pcemail");

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>-</title>
<?php

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../repair/printstyle.css\">";

if (!array_key_exists("allasset", $_REQUEST)) {
$allasset = "false";
} else {
$allasset = "true";
}


if (!isset($enablesignaturepad_repairreport)) {
$enablesignaturepad_repairreport = "no";
}

if ($enablesignaturepad_repairreport == "yes") {
?>
 <link rel="stylesheet" href="../repair/jq/signature/jquery.signaturepad.css">
  <!--[if lt IE 9]><script src="../repair/jq/signature/flashcanvas.js"></script><![endif]-->
  <script src="../repair/jq/jquery.js"></script>

<?php

}

if ($enablesignaturepad_repairreport == "topaz") {
require("../repair/jq/topaz.js");
}


echo "<link rel=\"stylesheet\" href=\"fa5/css/all.min.css\">";
echo "<link rel=\"stylesheet\" href=\"fa5/css/v4-shims.min.css\">";

echo "</head>";



if($autoprint == 1) {
if(($enablesignaturepad_repairreport == "yes") && ($enablesignaturepad_repairreport == "topaz")) {
if($thesigwo != "") {
echo "<body class=printpagebg onLoad=\"window.print()\">";
} else {
echo "<body class=printpagebg>";
}
} else {
echo "<body class=printpagebg onLoad=\"window.print()\">";
}
} else {
echo "<body class=printpagebg>";
}



echo "<div class=printbar>";

if (array_key_exists("backto", $_REQUEST)) {
if ($_REQUEST['backto'] == "view") {
echo "<button onClick=\"parent.location='pc.php?func=view&woid=$woid'\" class=bigbutton>";
} elseif ($_REQUEST['backto'] == "showpc") {
echo "<button onClick=\"parent.location='pc.php?func=showpc&pcid=$pcid'\" class=bigbutton>";
} else {
echo "<button onClick=\"parent.location='index.php?pcwo=$woid'\" class=bigbutton>";
}
} else {
echo "<button onClick=\"parent.location='index.php?pcwo=$woid'\" class=bigbutton>";
}




echo "<img src=../repair/images/left.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Return")."</button>";
echo "<font class=text30b>&nbsp;&nbsp;</font>";
echo "<button onClick=\"print();\" class=bigbutton><img src=../repair/images/print.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Print")."</button>";
echo "<font class=text30b>&nbsp;&nbsp;</font>";
echo "<button onClick=\"parent.location='pc.php?func=emailit&woid=$woid&email=$pcemail2'\" class=bigbutton><img src=../repair/images/email.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Email")."</button>";

if (array_key_exists("backto", $_REQUEST)) {
$backto = $_REQUEST['backto']; 
} else {
$backto = "";
}


if("$allasset" == "false") {
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<button onClick=\"parent.location='pc.php?func=printit&woid=$woid&allasset=yes&backto=$backto'\" class=bigbutton>";
echo "<img src=../repair/images/cam.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Show All Asset Photos")."</button>";
}  


echo "</div>";



echo "<div class=printpage><table width=100%><tr><td valign=top><img src=../repair/$printablelogo></td><td>";

echo "<br><center><font class=claimticketheader><i class=\"fa fa-wrench\"></i>&nbsp;".pcrtlang("Repair Report")."&nbsp;</font>";


echo "<font class=text12b><br><br>";
echo "$storeinfoarray[storename]</font>";
echo "<br><font class=text12>".pcrtlang("Phone").": $storeinfoarray[storephone]</font></center><br>";

echo "</td></tr></table><br>";
echo "<table width=100%><tr><td width=67% valign=top><table class=printables><tr><td><font class=text12>".pcrtlang("Customer Name").":</font></td><td><font class=text12b>$pcname</font></td></tr>";
if("$pccompany" != "") {
echo "<tr><td><font class=text12>".pcrtlang("Company").":</font></td><td><font class=text12b>$pccompany</font></td></tr>";
}
echo "<tr><td><font class=text12>".pcrtlang("Asset/Device ID").":</font></td><td><font class=textred16b>$pcid</font></td></tr><tr><td><font class=text12>".pcrtlang("Work Order ID").":</td><td><font class=text12b>$woid</font></td></tr>";

if($pcaddress != "") {
$pcaddressbr = nl2br($pcaddress);
echo "<tr><td><i class=\"fa fa-map-marker fa-lg fa-fw floatright\"></i></td><td><font class=text12b>$pcaddressbr</font></td></tr>";
if($pcaddress2 != "") {
echo "<tr><td></td><td><font class=text12b>$pcaddress2</font></td></tr>";
}
if(($pccity != "") && ($pcstate != "") && ($pczip != "")) {
echo "<tr><td></td><td><font class=text12b>$pccity, $pcstate $pczip</font></td></tr>";
}
}

echo "<tr><td colspan=2>&nbsp;</td></tr>";

if($pcphone != "") {
echo "<tr><td><i class=\"fa fa-phone fa-lg fa-fw floatright\"></i></td><td><font class=text12b>$pcphone</font></td></tr>";
}

if($pccellphone != "") {
echo "<tr><td><i class=\"fa fa-mobile fa-lg fa-fw floatright\"></i></td><td><font class=text12b>$pccellphone</font></td></tr>";
}

if($pcworkphone != "") {
echo "<tr><td><i class=\"fa fa-briefcase fa-lg fa-fw floatright\"></i></td><td><font class=text12b>$pcworkphone</font></td></tr>";
}


if($pcemail != "") {
echo "<tr><td><i class=\"fa fa-envelope fa-lg fa-fw floatright\"></i></td><td><font class=text12b>$pcemail</font></td></tr>";
}

echo "<tr><td colspan=2>&nbsp;</td></tr>";


echo "<tr><td><font class=text12>".pcrtlang("Make/Model").":</font></td><td><font class=text12b>$pcmake</font></td></tr>";

$allassetinfofields = array();

$rs_allfindassets = "SELECT * FROM mainassetinfofields WHERE showonrepair = '1'";
$rs_result2all = mysqli_query($rs_connect, $rs_allfindassets);
while ($rs_result_q2all = mysqli_fetch_object($rs_result2all)) {
$mainassetfieldid = "$rs_result_q2all->mainassetfieldid";
$mainassetfieldname = "$rs_result_q2all->mainassetfieldname";
$allassetinfofields[$mainassetfieldid] = "$mainassetfieldname";
}

foreach($pcextra as $key => $val) {
if(array_key_exists("$key", $allassetinfofields)) {
if($val != "") {
echo "<tr><td><font class=text12>$allassetinfofields[$key]: </font></td><td><font class=text12b>$val</font></td></tr>";
}
}
}

echo "<tr><td><font class=text12>".pcrtlang("Customer Assets").":</font></td><td><font class=text12b>";
foreach($custassetsindb as $key => $val) {
echo pcrtlang("$val")." :";
}


echo "</font></td></tr></table><br>";


echo "<br><br><h1>".pcrtlang("Problem as Described by Customer").":</h1><br><blockquote>".nl2br("$probdesc")."<br><br>";


foreach($theprobsindb as $key => $val) {
if(in_array("$val",$comprobarrayv)) {
echo "<font class=text12>&bull; $val</font><br>";
}
}

echo "</blockquote>";




echo "<br>";



echo "</td><td width=25>&nbsp;</td><td width=33% valign=top>";


$rs_findpic = "SELECT * FROM assetphotos WHERE pcid = '$pcid' AND highlight='1'";
$rs_resultpic2 = mysqli_query($rs_connect, $rs_findpic);

if (mysqli_num_rows($rs_resultpic2) != "0") {
$rs_resultpic_q2 = mysqli_fetch_object($rs_resultpic2);
$pcphoto = "$rs_resultpic_q2->photofilename";
$assetphotoid = "$rs_resultpic_q2->assetphotoid";
echo "<img src=pc.php?func=getpcimage&photoid=$assetphotoid border=1 width=256><br><br>";
}





$rs_foundscan = "SELECT * FROM pc_scan WHERE woid = '$woid' ORDER BY scantime ASC";
$rs_result_fs = mysqli_query($rs_connect, $rs_foundscan);

if (mysqli_num_rows($rs_result_fs) > 0) {
echo "<font class=text12b>".pcrtlang("Scans Performed").":</font><br><table>";
}

while($rs_result_fsr = mysqli_fetch_object($rs_result_fs)) {
$scanid = "$rs_result_fsr->scanid";
$scantype = "$rs_result_fsr->scantype";
$scannum = "$rs_result_fsr->scannum";
$customprogword = "$rs_result_fsr->customprogword";
$customprintinfo = "$rs_result_fsr->customprintinfo";
$customscantype = "$rs_result_fsr->customscantype";

if ($scantype != "0") {
$rs_foundscan_name = "SELECT * FROM pc_scans WHERE scanid = '$scantype'";
$rs_result_fs_name = mysqli_query($rs_connect, $rs_foundscan_name);
$rs_result_fsr_name = mysqli_fetch_object($rs_result_fs_name);
$scantypeid = "$rs_result_fsr_name->scanid";
$scantypeprog = "$rs_result_fsr_name->progword";
$scantypeicon = "$rs_result_fsr_name->progicon";
$myscantype = "$rs_result_fsr_name->scantype";
} else {
$myscantype = $customscantype;
}

if (($myscantype == 0) || ($customscantype == 0)) {
echo "<tr><td>";

if ($scantype == 0) {
echo "<img src=../repair/images/hand.png align=absmiddle>";
} else {
echo "<img src=../repair/images/scans/$scantypeicon align=absmiddle>";
}


echo "</td><td><font class=text12>";
if($customprogword != "") {
echo "$customprogword";
} else {
echo "$scantypeprog";
}


echo "</font>";
if ($scannum != 0) {
echo " - <font class=textred12>$scannum ".pcrtlang("item(s) found")."</font>";
} else {
echo "<font class=text12> - ".pcrtlang("no items found")."</font>";
}


echo "</td></tr>";

}
}

echo "</table><br>";



echo "</td></tr>";

echo "</table></td></tr></table>";
$switch1 = 0;
$switch2 = 0;
$switch3 = 0;

if("$allasset" == "true") {

echo "<font class=text12b>".pcrtlang("Work Order Photos").":</font><br><br><blockquote>";

$rs_findpic = "SELECT * FROM assetphotos WHERE pcid = '$pcid' AND highlight != '1'";
$rs_resultpic2 = mysqli_query($rs_connect, $rs_findpic);

$a = 2;

if (mysqli_num_rows($rs_resultpic2) != "0") {
while ($rs_resultpic_q2 = mysqli_fetch_object($rs_resultpic2)) {
$pcphoto = "$rs_resultpic_q2->photofilename";
$assetphotoid = "$rs_resultpic_q2->assetphotoid";
echo "<img src=pc.php?func=getpcimage&photoid=$assetphotoid border=1 width=256>&nbsp;";
if (($a % 2) == 1) {
echo "<br>";
}
$a++;
}
}

echo "</blockquote>";

}





##################

echo "<font class=text12b>&nbsp;".pcrtlang("Notes for Customer").":</font><br><br><br>";

$rs_findnotes = "SELECT * FROM wonotes WHERE woid = '$woid' AND notetype = '0' ORDER BY notetime ASC";
$rs_result_n = mysqli_query($rs_connect, $rs_findnotes);
$bubblego = "first";
$usercomm = array();
while($rs_result_qn = mysqli_fetch_object($rs_result_n)) {
$thenote = nl2br("$rs_result_qn->thenote");
$noteuser = "$rs_result_qn->noteuser";
$notetype = "$rs_result_qn->notetype";
$noteid = "$rs_result_qn->noteid";
$notetime2 = "$rs_result_qn->notetime";
$notetime =  date('g:ia n-j-Y', strtotime($notetime2));

if(array_key_exists("$noteuser",$usercomm)) {
$bubblego = $usercomm[$noteuser];
} else {
if($bubblego == "first") {
$bubblego = "left";
} elseif ($prevuser == "noteuser") {
$bubblego = "$thedir";
} else {
$bubblego = "$thediropp";
}
}

if ("$bubblego" == "left") {
echo "<table style=\"width:100%\"><tr><td style=\"width:125px;text-align:center;vertical-align:top;\">";
echo "<br><font class=text12b>$noteuser</font>";
echo "</td><td>";
echo "<div class=\"wonote left\"><font class=text12>$thenote</font></div>";
echo "</td></tr></table>";
$prevuser = "$noteuser";
$thedir = "left";
$thediropp = "right";
} else {
echo "<table style=\"width:100%\"><tr><td>";
echo "<div class=\"wonote right\"><font class=text12>$thenote</font></div></td>";
echo "<td style=\"width:100px;text-align:center;align:top\">";
echo "<font class=text12b>$noteuser</font>";
echo "</td></tr></table>";
$prevuser = "$noteuser";
$thedir = "right";
$thediropp = "left";
}

$usercomm[$noteuser] = "$thedir";

}


######### Checks

################ Checks

$rs_sq = "SELECT * FROM mainassettypes WHERE mainassettypeid = '$mainassettypeidindb'";
$rs_result1 = mysqli_query($rs_connect, $rs_sq);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$mainassetchecksindb = serializedarraytest("$rs_result_q1->mainassetchecks");


$wochecks = serializedarraytest("$wochecks");

if((count($mainassetchecksindb) > 0) && (count($wochecks))) {


echo "<table class=standard>";

echo "<tr><th colspan=2>".pcrtlang("Pre Checks")."</th><th colspan=2>".pcrtlang("Post Checks")."</th></tr>";

$rs_checks = "SELECT * FROM checks";
$rs_checksq = mysqli_query($rs_connect, $rs_checks);
while($rs_result_cq = mysqli_fetch_object($rs_checksq)) {
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

if(($precheck == 2) || ($precheck == 3) || ($postcheck == 2) || ($postcheck == 3)) {
echo "<tr><td>";
if(($precheck == 2) || ($precheck == 3)) {
echo "$checkname";
}
echo "</td><td>";
if($precheck == 2) {
echo "<i class=\"fa fa-check fa-lg colormegreen\"></i> ".pcrtlang("Check Passed");
} elseif($precheck == 3) {
echo "<i class=\"fa fa-warning fa-lg colormered\"></i> ".pcrtlang("Check Failed");
} else {
}


echo "</td><td>";
if(($postcheck == 2) || ($postcheck == 3)) {
echo "$checkname";
}
echo "</td><td>";

if($postcheck == 2) {
echo "<i class=\"fa fa-check fa-lg colormegreen\"></i> ".pcrtlang("Check Passed");
} elseif($postcheck == 3) {
echo "<i class=\"fa fa-warning fa-lg colormered\"></i> ".pcrtlang("Check Failed");
} else {

}

echo "</td></tr>";
}
}


}


echo "</table>";
echo "<br>";

}






################ actions






echo "<table width=100%>";

echo "<tr><td width=100%>";
$rs_foundscan5 = "SELECT * FROM pc_scan WHERE woid = '$woid'";
$rs_result_fs5 = mysqli_query($rs_connect, $rs_foundscan5);



while($rs_result_fsr5 = mysqli_fetch_object($rs_result_fs5)) {
$scanid5 = "$rs_result_fsr5->scanid";
$scantype5 = "$rs_result_fsr5->scantype";
$scannum5 = "$rs_result_fsr5->scannum";
$scantime5 = "$rs_result_fsr5->scantime";
$customprogword5 = "$rs_result_fsr5->customprogword";
$customprintinfo5 = "$rs_result_fsr5->customprintinfo";
$customscantype5 = "$rs_result_fsr5->customscantype";

if ($scantype5 != "0") {
$rs_foundscan_name5 = "SELECT * FROM pc_scans WHERE scanid = '$scantype5'";
$rs_result_fs_name5 = mysqli_query($rs_connect, $rs_foundscan_name5);
$rs_result_fsr_name5 = mysqli_fetch_object($rs_result_fs_name5);
$scantypeid5 = "$rs_result_fsr_name5->scanid";
$scantypeprog5 = "$rs_result_fsr_name5->progword";
$scantypeicon5 = "$rs_result_fsr_name5->progicon";
$printinfo5 = "$rs_result_fsr_name5->printinfo";
$myscantype5 = "$rs_result_fsr_name5->scantype";
} else {
$myscantype5 = $customscantype5;
}

if (($myscantype5 == 1) || ($customscantype5 == 1)) {

if ($switch1 == 0) {
echo "<br><br>";
echo "<font class=scanheading>&nbsp;&nbsp;<img src=\"../repair/images/actionicon.png\"> ".pcrtlang("Actions")."&nbsp;&nbsp;</font><br><br>";
}

$switch1 = 1;


if ($scantype5 == 0) {
echo "<img src=../repair/images/hand.png align=absmiddle> ";
} else {
echo "<img src=../repair/images/scans/$scantypeicon5 align=absmiddle> ";
}


echo "<font class=text12b>";
if($customprogword5 != "") {
echo "$customprogword5";
} else {
echo "$scantypeprog5";
}


echo "</font><br>";
echo "<font class=text12>";

if($customprintinfo5 != "") {
echo "$customprintinfo5";
} else {
echo "$printinfo5";
}

echo "</font><br><br>";

}
}

echo "</td></tr></table>";
#######################
################ installed
echo "<table width=100%>";
echo "<tr><td width=100%>";
$rs_foundscan6 = "SELECT * FROM pc_scan WHERE woid = '$woid'";
$rs_result_fs6 = mysqli_query($rs_connect, $rs_foundscan6);



while($rs_result_fsr6 = mysqli_fetch_object($rs_result_fs6)) {
$scanid6 = "$rs_result_fsr6->scanid";
$scantype6 = "$rs_result_fsr6->scantype";
$scannum6 = "$rs_result_fsr6->scannum";
$scantime6 = "$rs_result_fsr6->scantime";
$customprogword6 = "$rs_result_fsr6->customprogword";
$customprintinfo6 = "$rs_result_fsr6->customprintinfo";
$customscantype6 = "$rs_result_fsr6->customscantype";

if ($scantype6 != "0") {
$rs_foundscan_name6 = "SELECT * FROM pc_scans WHERE scanid = '$scantype6'";
$rs_result_fs_name6 = mysqli_query($rs_connect, $rs_foundscan_name6);
$rs_result_fsr_name6 = mysqli_fetch_object($rs_result_fs_name6);
$scantypeid6 = "$rs_result_fsr_name6->scanid";
$scantypeprog6 = "$rs_result_fsr_name6->progword";
$scantypeicon6 = "$rs_result_fsr_name6->progicon";
$printinfo6 = "$rs_result_fsr_name6->printinfo";
$myscantype6 = "$rs_result_fsr_name6->scantype";
} else {
$myscantype6 = $customscantype6;
}

if (($myscantype6 == 2) || ($customscantype6 == 2)) {

if ($switch2 == 0) {
echo "<br><br>";
echo "<font class=scanheading>&nbsp;&nbsp;<img src=\"../repair/images/installicon.png\"> ".pcrtlang("Installs")."&nbsp;&nbsp;</font><br><br>";
}

$switch2 = 1;


if ($scantype6 == 0) {
echo "<img src=../repair/images/hand.png align=absmiddle> ";
} else {
echo "<img src=../repair/images/scans/$scantypeicon6 align=absmiddle> ";
}


echo "<font class=text12b>";

if($customprogword6 != "") {
echo "$customprogword6";
} else {
echo "$scantypeprog6";
}

echo "</font><br>";
echo "<font class=text12>";

if($customprintinfo6 != "") {
echo "$customprintinfo6";
} else {
echo "$printinfo6";
}


echo "</font><br><br>";

}
}

echo "</td></tr></table>";
#######################
################ notes
echo "<table width=100%>";
echo "<tr><td width=100%>";
$rs_foundscan2 = "SELECT * FROM pc_scan WHERE woid = '$woid'";
$rs_result_fs2 = mysqli_query($rs_connect, $rs_foundscan2);



while($rs_result_fsr2 = mysqli_fetch_object($rs_result_fs2)) {
$scanid2 = "$rs_result_fsr2->scanid";
$scantype2 = "$rs_result_fsr2->scantype";
$scannum2 = "$rs_result_fsr2->scannum";
$scantime2 = "$rs_result_fsr2->scantime";
$customprogword2 = "$rs_result_fsr2->customprogword";
$customprintinfo2 = "$rs_result_fsr2->customprintinfo";
$customscantype2 = "$rs_result_fsr2->customscantype";

if ($scantype2 != "0") {
$rs_foundscan_name2 = "SELECT * FROM pc_scans WHERE scanid = '$scantype2'";
$rs_result_fs_name2 = mysqli_query($rs_connect, $rs_foundscan_name2);
$rs_result_fsr_name2 = mysqli_fetch_object($rs_result_fs_name2);
$scantypeid2 = "$rs_result_fsr_name2->scanid";
$scantypeprog2 = "$rs_result_fsr_name2->progword";
$scantypeicon2 = "$rs_result_fsr_name2->progicon";
$printinfo2 = "$rs_result_fsr_name2->printinfo";
$myscantype2 = "$rs_result_fsr_name2->scantype";
} else {
$myscantype2 = $customscantype2;
}

if (($myscantype2 == 3) || ($customscantype2 == 3)) {

if ($switch3 == 0) {
echo "<br><br>";
echo "<font class=scanheading>&nbsp;&nbsp;<img src=\"../repair/images/notesicon.png\"> ".pcrtlang("Notes &amp; Recommendations")."&nbsp;&nbsp;</font><br><br>";
}

$switch3 = 1;

if ($scantype2 == 0) {
echo "<img src=../repair/images/hand.png align=absmiddle> ";
} else {
echo "<img src=../repair/images/scans/$scantypeicon2 align=absmiddle> ";
}


echo "<font class=text12b>";

if($customprogword2 != "") {
echo "$customprogword2";
} else {
echo "$scantypeprog2";
}

echo "</font><br>";
echo "<font class=text12>";

if($customprintinfo2 != "") {
echo "$customprintinfo2";
} else {
echo "$printinfo2";
}


echo "</font><br><br>";

}
}

echo "</td></tr></table>";


}
}

echo nl2br($storeinfoarray['repairsheetfooter']);


if (($enablesignaturepad_repairreport == "yes") && ($showsigrr == "0")) {
echo "<a href=pc.php?func=hidesigrr&woid=$woid&hidesig=1 class=hideprintedlink><br><br>(".pcrtlang("show signature pad").")</a>";
}

if (($enablesignaturepad_repairreport == "yes") && ($showsigrr == "1")) {

if ($showsigrr == "1") {
echo "<a href=pc.php?func=hidesigrr&woid=$woid&hidesig=0 class=hideprintedlink><br><br>(".pcrtlang("hide signature pad").")</a>";
}

if($thesigwo == "") {

?>
<blockquote>
  <form method="post" action="pc.php?func=savesigwo" class="sigPad"><input type=hidden name=woid value=<?php echo $woid; ?>>
    <p class="drawItDesc"><?php echo pcrtlang("Use Stylus to write your signature"); ?></p>
    <ul class="sigNav">
      <li class="clearButton"><a href="#clear"><?php echo pcrtlang("Clear Signature"); ?></a></li>
    </ul>
    <div class="sig sigWrapper">
      <div class="typed"></div>
      <canvas class="pad" width="446" height="75"></canvas>
      <input type="hidden" name="output" class="output">
    </div>
    <button type="submit"><?php echo pcrtlang("I accept the terms"); ?></button>
  </form>

  <script src="../repair/jq/signature/jquery.signaturepad.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.sigPad').signaturePad({drawOnly:true,lineTop:60});
    });
  </script>
  <script src="../repair/jq/signature/json2.min.js"></script>
</blockquote>
<?php
} else {
echo "<br><br><font class=text16b>".pcrtlang("Signed").":</font> <a href=pc.php?func=clearsigwo&woid=$woid class=hideprintedlink>(".pcrtlang("remove signature").")</a></font><br>";
?>

<div class="sigPad signed">
  <div class="sigWrapper">
    <canvas class="pad" width="450" height="75"></canvas>
  </div>
</div>

<script type="text/javascript" src="../repair/jq/signature/jquery.signaturepad.min.js"></script>
<script>
$(document).ready(function () {
  $('.sigPad').signaturePad({displayOnly:true}).regenerate(<?php echo $thesigwo ?>)
})
</script>
<script type="text/javascript" src="../repair/jq/signature/json2.min.js"></script>
<?php
}

}


#start topaz

if ($enablesignaturepad_repairreport == "topaz") {

if ($showsigrrtopaz == "0") {
echo "<a href=pc.php?func=hidesigrrtopaz&woid=$woid&hidesig=1 class=hideprintedlink><br><br>(".pcrtlang("show signature pad").")</a>";
}

if ($showsigrrtopaz == "1") {
echo "<a href=pc.php?func=hidesigrrtopaz&woid=$woid&hidesig=0 class=hideprintedlink><br><br>(".pcrtlang("hide signature pad").")</a>";
}

if ($showsigrrtopaz == "1") {
if ($thesigwotopaz == "") {


?>

<br>
<canvas id="cnv" name="cnv" width="500" height="100"></canvas>

<form action="pc.php?func=savesigwotopaz" name=FORM1 method=post>
<input id="SignBtn" name="SignBtn" type="button" value="<?php echo pcrtlang("Activate Sig Pad"); ?>"  class=button onclick="javascript:onSign()"/>&nbsp;&nbsp;&nbsp;&nbsp;
<input id="button1" name="ClearBtn" type="button" class=button value="Clear" onclick="javascript:onClear()"/>&nbsp;&nbsp;&nbsp;&nbsp;

<input id="button2" name="DoneBtn" type="button" class=button value="Done" onclick="javascript:onDone()"/>&nbsp;&nbsp;&nbsp;&nbsp;

<input type="submit" class=button value="Save">&nbsp;&nbsp;&nbsp;&nbsp

<INPUT TYPE=HIDDEN NAME="bioSigData">
<INPUT TYPE=HIDDEN NAME="sigImgData">

<input type=hidden name=woid value=<?php echo $woid; ?>>

<input type=hidden NAME="sigImageData" value="">
</form>



<?php

} else {
echo "<br><br><font class=text16b>".pcrtlang("Signed").":</font><a href=pc.php?func=clearsigwotopaz&woid=$woid class=hideprintedlink>(".pcrtlang("remove signature").")</a><br>";

echo '<br><img src="data:image/png;base64,' . $thesigwotopaz . '" />';

}

#end hide
}

}







echo "</div><br><br>";
                                                                                                                                               
}












##################################################################################################

function emailit() {
require_once("validate.php");
require("deps.php");

require_once("common.php");
require("dheader.php");

$email = $_REQUEST['email'];
$woid = $_REQUEST['woid'];


echo "<div data-role=\"header\" data-theme=\"b\"><h2>".pcrtlang("Email Repair Report")."</h2></div>";
echo "<div class=\"ui-content\" role=\"main\">";

echo "<br><form action=pc.php?func=emailit2 method=POST data-ajax=\"false\"><input type=text value=\"$email\" name=email  size=35 required=required onFocus=\"this.form.submitbutton.disabled=false;this.form.submitbutton.value='".pcrtlang("Email Customer Repair Sheet")."';\"><input type=hidden value=$woid name=woid>";
echo "<input type=submit id=submitbutton  value=\"".pcrtlang("Email Customer Repair Sheet")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Sending Email")."...'; this.form.submit();\" data-theme=\"b\"></form><br><br>";

echo "</div>";
require_once("dfooter.php");


}



function emailit2() {
require_once("validate.php");
require("deps.php");
require_once("common.php");
$woid = $_REQUEST['woid'];
$email = $_REQUEST['email'];





userlog(6,$woid,'woid',pcrtlang("Sent Repair Report to")." $email");

$rs_findpc = "SELECT * FROM pc_wo WHERE woid = '$woid'";
$rs_result = mysqli_query($rs_connect, $rs_findpc);
while($rs_result_q = mysqli_fetch_object($rs_result)) {
$pcid = "$rs_result_q->pcid";
$probdesc = "$rs_result_q->probdesc";
$dropoff = "$rs_result_q->dropdate";
$pickup = "$rs_result_q->pickupdate";
$pcstatus = "$rs_result_q->pcstatus";
$custassetsindb = serializedarraytest("$rs_result_q->custassets");
$rs_storeid = "$rs_result_q->storeid";

$theprobsindb = serializedarraytest("$rs_result_q->commonproblems");


$comprobarrayv = array();
$rs_chkscansv = "SELECT theproblem FROM commonproblems WHERE custviewable = '1'";
$rs_chkresult_sv = mysqli_query($rs_connect, $rs_chkscansv);
while($rs_chkresult_q_sv = mysqli_fetch_object($rs_chkresult_sv)) {
$theprobv = "$rs_chkresult_q_sv->theproblem";
array_push($comprobarrayv,"$theprobv");
}


$rs_findowner = "SELECT * FROM pc_owner WHERE pcid = '$pcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
while($rs_result_q2 = mysqli_fetch_object($rs_result2)) {
$pcname = "$rs_result_q2->pcname";
$pccompany = "$rs_result_q2->pccompany";
$pcphone = "$rs_result_q2->pcphone";
$pccellphone = "$rs_result_q2->pccellphone";
$pcworkphone = "$rs_result_q2->pcworkphone";
$pcmake = "$rs_result_q2->pcmake";
$pcemail = "$rs_result_q2->pcemail";
$pcaddress = "$rs_result_q2->pcaddress";
$pcaddress2 = "$rs_result_q2->pcaddress2";
$pccity = "$rs_result_q2->pccity";
$pcstate = "$rs_result_q2->pcstate";
$pczip = "$rs_result_q2->pczip";
$pcextra2 = "$rs_result_q2->pcextra";
$pcextra = serializedarraytest($pcextra2);

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}


$storeinfoarray = getstoreinfo($rs_storeid);


$to = "$email";

if("$storeinfoarray[storeccemail]" != "")	{
$to .= ",$storeinfoarray[storeccemail]";
}

$subject = "$storeinfoarray[storename] - ".pcrtlang("Repair Report")."";
$random_hash = md5(date('r', time()));
$headers = "From: $storeinfoarray[storeemail]\nReply-To: $storeinfoarray[storename]\nX-Mailer: PHP/".phpversion();
$headers .= "\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
$headers .= "\nMIME-Version: 1.0";
$message = "--PHP-alt-$random_hash\n";
$message .= "Content-Type: text/plain; charset=\"utf-8\"\n";
$message .= "Content-Transfer-Encoding: 7bit\n\n";

$message .= "Sorry, Your email client does not support html email.\n\n";
$peartext = "Sorry, Your email client does not support html email.\n\n";

$message .= "--PHP-alt-$random_hash\n";
$message .= "Content-Type: text/html; charset=\"utf-8\"\n";
$message .= "Content-Transfer-Encoding: 7bit\n\n";



$message .= "<html><body><table width=650><tr><td><font style=\"font-weight:bold;font-size:30px;\">$storeinfoarray[storename]</td><td><b>".pcrtlang("Repair Sheet")."<br>$storeinfoarray[storeaddy1]";
if ($storeinfoarray['storeaddy2'] != "") {
$message .= "<br>$storeinfoarray[storeaddy2]";
}
$message .= "<br>$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]<br>$storeinfoarray[storephone]</b></td></tr></table><br>\n";

$pearhtml = "<html><body><table width=650><tr><td><img src=$logo></td><td><b>Repair Report<br><br>$storeinfoarray[storename]<br>$storeinfoarray[storeaddy1]";
if ($storeinfoarray['storeaddy2']	!= "") {
$pearhtml .= "<br>$storeinfoarray[storeaddy2]";
}
$pearhtml .= "<br>$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]<br>$storeinfoarray[storephone]</b></td></tr></table><br>\n";


$message .= "<table width=650><tr><td width=400 valign=top><font size=2>".pcrtlang("Customer Name").": <b>$pcname</b>";
if("$pccompany" != "") {
$message .= "<br><font size=2>".pcrtlang("Company").": <b>$pccompany</b>";
}
$message .= "<br>".pcrtlang("Asset/Device ID").": <font color=red size=2><b>$pcid</b>\n";
$message .= "<br>".pcrtlang("Work Order ID").": <font color=blue size=2><b>$woid</b>\n";

$pearhtml .= "<table width=650><tr><td width=400 valign=top><font size=2>".pcrtlang("Customer Name").": <b>$pcname</b>";
if("$pccompany" != "") {
$pearhtml .= "<br><font size=2>".pcrtlang("Company").": <b>$pccompany</b>";
}
$pearhtml .= "<br>".pcrtlang("Asset/Device ID").": <font color=red size=2><b>$pcid</b>\n";
$pearhtml .= "<br>".pcrtlang("Work Order ID").": <font color=blue size=2><b>$woid</b>\n";

if($pcaddress != "") {
$pcaddressbr = nl2br($pcaddress);
$message .= "<table cellpadding=0 cellspacing=0 border=0><tr><td><font size=2>".pcrtlang("Address").":&nbsp;&nbsp;</td><td><font size=2><b>$pcaddressbr</b></td></tr>\n";
$pearhtml .= "<table cellpadding=0 cellspacing=0 border=0><tr><td><font size=2>".pcrtlang("Address").":&nbsp;&nbsp;</td><td><font size=2><b>$pcaddressbr</b></td></tr>\n";
if($pcaddress2 != "") {
$message .= "<tr><td></td><td><font size=2><b>$pcaddress2</b></td></tr>\n";
$pearhtml .= "<tr><td></td><td><font size=2><b>$pcaddress2</b></td></tr>\n";
}
if(($pccity != "") && ($pcstate != "") && ($pczip != "")) {
$message .= "<tr><td></td><td><font size=2><b>$pccity, $pcstate $pczip</b></td></tr>\n";
$pearhtml .= "<tr><td></td><td><font size=2><b>$pccity, $pcstate $pczip</b></td></tr>\n";
}
$message .= "</table>\n";
$pearhtml .= "</table>\n";
}

$message .= "<br>".pcrtlang("Customer Phone").": <b>$pcphone</b>\n";
$pearhtml .= "<br>".pcrtlang("Customer Phone").": <b>$pcphone</b>\n";

if($pccellphone != "") {
$message .= "<br>".pcrtlang("Mobile Phone").": <b>$pccellphone</b>\n";
$pearhtml .= "<br>".pcrtlang("Mobile Phone").": <b>$pccellphone</b>\n";
}

if($pcworkphone != "") {
$message .= "<br>".pcrtlang("Work Phone").": <b>$pcworkphone</b>\n";
$pearhtml .= "<br>".pcrtlang("Work Phone").": <b>$pcworkphone</b>\n";
}


if($pcemail != "") {
$message .= "<br>".pcrtlang("Email").": <b>$pcemail</b>\n";
$pearhtml .= "<br>".pcrtlang("Email").": <b>$pcemail</b>\n";
}


$message .= "<br><font size=2>".pcrtlang("Make/Model").": <b>$pcmake</b>\n";
$pearhtml .= "<br><font size=2>".pcrtlang("Make/Model").": <b>$pcmake</b>\n";

$allassetinfofields = array();

$rs_allfindassets = "SELECT * FROM mainassetinfofields WHERE showonrepair = '1'";
$rs_result2all = mysqli_query($rs_connect, $rs_allfindassets);
while ($rs_result_q2all = mysqli_fetch_object($rs_result2all)) {
$mainassetfieldid = "$rs_result_q2all->mainassetfieldid";
$mainassetfieldname = "$rs_result_q2all->mainassetfieldname";
$allassetinfofields[$mainassetfieldid] = "$mainassetfieldname";
}

foreach($pcextra as $key => $val) {
if(array_key_exists("$key", $allassetinfofields)) {
$message .= "<br><font size=2>$allassetinfofields[$key]: <b>$val</b>\n";
$pearhtml .= "<br><font size=2>$allassetinfofields[$key]: <b>$val</b>\n";
}
}


$message .= "<br>".pcrtlang("Customer Assets").":<b>\n";
$pearhtml .= "<br>".pcrtlang("Customer Assets").":<b>\n";
foreach($custassetsindb as $key => $val) {
$message .= "$val :\n";
$pearhtml .= "$val :\n";
}


$message .= "</b><br>\n";
$pearhtml .= "</b><br>\n";

$message .= "<br><br><b>".pcrtlang("Problem as Described by Customer").":</b><br><blockquote><font size=2>$probdesc<br><br>";
$pearhtml .= "<br><br><b>".pcrtlang("Problem as Described by Customer").":</b><br><blockquote><font size=2>$probdesc<br><br>";

foreach($theprobsindb as $key => $val) {
if(in_array("$val",$comprobarrayv)) {
$message .= "<font size=2>&bull; $val<br>\n";
$pearhtml .= "<font size=2>&bull; $val<br>\n";
}
}





$message .= "<br>\n";
$pearhtml .= "<br>\n";



$message .= "</td><td width=25>&nbsp;</td><td width=225 valign=top>\n";
$pearhtml .= "</td><td width=25>&nbsp;</td><td width=225 valign=top>\n";


$rs_findpic = "SELECT * FROM assetphotos WHERE pcid = '$pcid' AND highlight='1'";
$rs_resultpic2 = mysqli_query($rs_connect, $rs_findpic);

if (mysqli_num_rows($rs_resultpic2) != "0") {
$rs_resultpic_q2 = mysqli_fetch_object($rs_resultpic2);
$pcphoto = "$rs_resultpic_q2->photofilename";
$pearhtml .= "<img src=\"../pcphotos/$pcphoto\" border=1 width=256><br><br>";
}



$rs_foundscan = "SELECT * FROM pc_scan WHERE woid = '$woid' ORDER BY scantime ASC";
$rs_result_fs = mysqli_query($rs_connect, $rs_foundscan);

if (mysqli_num_rows($rs_result_fs) > 0) {
$message .= "<b>".pcrtlang("Scans Performed").":</b><br><table>\n";
$pearhtml .= "<b>".pcrtlang("Scans Performed").":</b><br><table>\n";
}

while($rs_result_fsr = mysqli_fetch_object($rs_result_fs)) {
$scanid = "$rs_result_fsr->scanid";
$scantype = "$rs_result_fsr->scantype";
$scannum = "$rs_result_fsr->scannum";
$customprogword = "$rs_result_fsr->customprogword";
$customprintinfo = "$rs_result_fsr->customprintinfo";
$customscantype = "$rs_result_fsr->customscantype";

if ($scantype != "0") {
$rs_foundscan_name = "SELECT * FROM pc_scans WHERE scanid = '$scantype'";
$rs_result_fs_name = mysqli_query($rs_connect, $rs_foundscan_name);
$rs_result_fsr_name = mysqli_fetch_object($rs_result_fs_name);
$scantypeid = "$rs_result_fsr_name->scanid";
$scantypeprog = "$rs_result_fsr_name->progword";
$scantypeicon = "$rs_result_fsr_name->progicon";
$myscantype = "$rs_result_fsr_name->scantype";
} else {
$myscantype = $customscantype;
}

if (($myscantype == 0) || ($customscantype == 0)) {
$message .= "<tr><td>\n";
$pearhtml .= "<tr><td>\n";

$message .= "</td><td><font size=2>&bull; \n";
$pearhtml .= "</td><td><font size=2>&bull; \n";
if($customprogword != "") {
$message .= "$customprogword\n";
$pearhtml .= "$customprogword\n";
} else {
$message .= "$scantypeprog\n";
$pearhtml .= "$scantypeprog\n";
}


$message .= "\n";
$pearhtml .= "\n";
if ($scannum != 0) {
$message .= " - <font color=red size=2>$scannum ".pcrtlang("item(s) found")."\n";
$pearhtml .= " - <font color=red size=2>$scannum ".pcrtlang("item(s) found")."\n";
} else {
$message .= "<font color=blue size=2> - ".pcrtlang("no items found")."\n";
$pearhtml .= "<font color=blue size=2> - no items found\n";
}


$message .= "</td></tr>\n";
$pearhtml .= "</td></tr>\n";

}
}

$message .= "</table><br>\n";
$pearhtml .= "</table><br>\n";


$message .= "</td></tr>\n";
$pearhtml .= "</td></tr>\n";

$message .= "</table></td></tr></table>\n";
$pearhtml .= "</table></td></tr></table>\n";
$switch1 = 0;
$switch2 = 0;
$switch3 = 0;




################################


$message .= "<font size=2><b>&nbsp;".pcrtlang("Notes for Customer").":</b><br><br><br>";
$pearhtml .= "<font size=2><b>&nbsp;".pcrtlang("Notes for Customer").":</b><br><br><br>";

$rs_findnotes = "SELECT * FROM wonotes WHERE woid = '$woid' AND notetype = '0' ORDER BY notetime ASC";
$rs_result_n = mysqli_query($rs_connect, $rs_findnotes);
$bubblego = "first";
$usercomm = array();
while($rs_result_qn = mysqli_fetch_object($rs_result_n)) {
$thenote = nl2br("$rs_result_qn->thenote");
$noteuser = "$rs_result_qn->noteuser";
$notetype = "$rs_result_qn->notetype";
$noteid = "$rs_result_qn->noteid";
$notetime2 = "$rs_result_qn->notetime";
$notetime =  date('g:ia n-j-Y', strtotime($notetime2));

if(array_key_exists("$noteuser",$usercomm)) {
$bubblego = $usercomm[$noteuser];
} else {
if($bubblego == "first") {
$bubblego = "left";
} elseif ($prevuser == "noteuser") {
$bubblego = "$thedir";
} else {
$bubblego = "$thediropp";
}
}

if ("$bubblego" == "left") {
$message .= "<table style=\"width:650px\"><tr><td style=\"width:100px;text-align:center;vertical-align:top;\">";
$message .= "<font size=2><b>$noteuser</b>";
$message .= "</td><td>";
$message .= "<div style=\"border: #333333 2px solid;\"><font size=2>$thenote</div>";
$message .= "</td></tr></table>";

$pearhtml .= "<table style=\"width:650px\"><tr><td style=\"width:100px;text-align:center;vertical-align:top;\">";
$pearhtml .= "<font size=2><b>$noteuser</b>";
$pearhtml .= "</td><td>";
$pearhtml .= "<div style=\"border: #333333 2px solid;\"><font size=2>$thenote</div>";
$pearhtml .= "</td></tr></table>";

$prevuser = "$noteuser";
$thedir = "left";
$thediropp = "right";
} else {
$message .= "<table style=\"width:650px\"><tr><td>";
$message .= "<div style=\"border: #333333 2px solid\"><font size=2>$thenote</div></td>";
$message .= "<td style=\"width:100px;text-align:center;align:top\">";
$message .= "<font size=2><b>$noteuser</b>";
$message .= "</td></tr></table>";

$pearhtml .= "<table style=\"width:650px\"><tr><td>";
$pearhtml .= "<div style=\"border: #333333 2px solid\"><font size=2>$thenote</div></td>";
$pearhtml .= "<td style=\"width:100px;text-align:center;align:top\">";
$pearhtml .= "<font size=2><b>$noteuser</b>";
$pearhtml .= "</td></tr></table>";


$prevuser = "$noteuser";
$thedir = "right";
$thediropp = "left";
}

$usercomm[$noteuser] = "$thedir";

}


################ Checks

$rs_sq = "SELECT * FROM mainassettypes WHERE mainassettypeid = '$mainassettypeidindb'";
$rs_result1 = mysqli_query($rs_connect, $rs_sq);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$mainassetchecksindb = serializedarraytest("$rs_result_q1->mainassetchecks");


if(count($mainassetchecksindb) > 0) {

$wochecks = serializedarraytest("$wochecks");

$message .= "<table><tr><th colspan=3>".pcrtlang("Pre Checks")."</th><th colspan=2>".pcrtlang("Post Checks")."</th></tr>";
$pearhtml .= "<table><tr><th colspan=3>".pcrtlang("Pre Checks")."</th><th colspan=2>".pcrtlang("Post Checks")."</th></tr>";

$rs_checks = "SELECT * FROM checks";
$rs_checksq = mysqli_query($rs_connect, $rs_checks);
while($rs_result_cq = mysqli_fetch_object($rs_checksq)) {
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

if(($precheck == 2) || ($precheck == 3) || ($postcheck == 2) || ($postcheck == 3)) {
$message .= "<tr><td>";
$pearhtml .= "<tr><td>";
if(($precheck == 2) || ($precheck == 3)) {
$message .= "$checkname";
$pearhtml .= "$checkname";
}
$message .= "</td><td>";
$pearhtml .= "</td><td>";
if($precheck == 2) {
$message .= pcrtlang("Check Passed");
$pearhtml .= pcrtlang("Check Passed");
} elseif($precheck == 3) {
$message .= pcrtlang("Check Failed");
$pearhtml .= pcrtlang("Check Failed");
} else {
}


$message .= "</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>";
$pearhtml .= "</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>";
if(($postcheck == 2) || ($postcheck == 3)) {
$message .= "$checkname";
$pearhtml .= "$checkname";
}
$message .= "</td><td>";
$pearhtml .= "</td><td>";
if($postcheck == 2) {
$message .= pcrtlang("Check Passed");
$pearhtml .= pcrtlang("Check Passed");
} elseif($postcheck == 3) {
$message .= pcrtlang("Check Failed");
$pearhtml .= pcrtlang("Check Failed");
} else {

}

$message .= "</td></tr>";
$pearhtml .= "</td></tr>";
}
}


}


$message .= "</table><br>";
$pearhtml .= "</table><br>";

}




################ actions

$message .= "<table width=650>\n";
$pearhtml .= "<table width=650>\n";

$message .= "<tr><td width=650>\n";
$pearhtml .= "<tr><td width=650>\n";

$rs_foundscan5 = "SELECT * FROM pc_scan WHERE woid = '$woid'";
$rs_result_fs5 = mysqli_query($rs_connect, $rs_foundscan5);



while($rs_result_fsr5 = mysqli_fetch_object($rs_result_fs5)) {
$scanid5 = "$rs_result_fsr5->scanid";
$scantype5 = "$rs_result_fsr5->scantype";
$scannum5 = "$rs_result_fsr5->scannum";
$scantime5 = "$rs_result_fsr5->scantime";
$customprogword5 = "$rs_result_fsr5->customprogword";
$customprintinfo5 = "$rs_result_fsr5->customprintinfo";
$customscantype5 = "$rs_result_fsr5->customscantype";

if ($scantype5 != "0") {
$rs_foundscan_name5 = "SELECT * FROM pc_scans WHERE scanid = '$scantype5'";
$rs_result_fs_name5 = mysqli_query($rs_connect, $rs_foundscan_name5);
$rs_result_fsr_name5 = mysqli_fetch_object($rs_result_fs_name5);
$scantypeid5 = "$rs_result_fsr_name5->scanid";
$scantypeprog5 = "$rs_result_fsr_name5->progword";
$scantypeicon5 = "$rs_result_fsr_name5->progicon";
$printinfo5 = "$rs_result_fsr_name5->printinfo";
$myscantype5 = "$rs_result_fsr_name5->scantype";
} else {
$myscantype5 = $customscantype5;
}

if (($myscantype5 == 1) || ($customscantype5 == 1)) {

if ($switch1 == 0) {
$message .= "<br><br><div style=\"border: 3px solid #000066; padding:5px;\"><font style=\" COLOR: #000066; FONT-SIZE: 20px; FONT-WEIGHT: normal;\">".pcrtlang("Actions")."</div><br>\n";
$pearhtml .= "<br><br><div style=\"border: 3px solid #000066; padding:5px;\"><font style=\" COLOR: #000066; FONT-SIZE: 20px; FONT-WEIGHT: normal;\">".pcrtlang("Actions")."</div><br>\n";
}

$switch1 = 1;


$message .= "<font size=2><b>&bull; \n";
$pearhtml .= "<font size=2><b>&bull; \n";
if($customprogword5 != "") {
$message .= "$customprogword5\n";
$pearhtml .= "$customprogword5\n";
} else {
$message .= "$scantypeprog5\n";
$pearhtml .= "$scantypeprog5\n";
}


$message .= "</b><br>\n";
$pearhtml .= "</b><br>\n";
$message .= "<font size=2>\n";
$pearhtml .= "<font size=2>\n";

if($customprintinfo5 != "") {
$message .= "$customprintinfo5\n";
$pearhtml .= "$customprintinfo5\n";
} else {
$message .= "$printinfo5\n";
$pearhtml .= "$printinfo5\n";
}

$message .= "<br><br>\n";
$pearhtml .= "<br><br>\n";


}
}

$message .= "</td></tr></table>\n";
$pearhtml .= "</td></tr></table>\n";

#######################
################ installed
$message .= "<table width=650><tr><td width=650>\n";
$pearhtml .= "<table width=650><tr><td width=650>\n";
$rs_foundscan6 = "SELECT * FROM pc_scan WHERE woid = '$woid'";
$rs_result_fs6 = mysqli_query($rs_connect, $rs_foundscan6);



while($rs_result_fsr6 = mysqli_fetch_object($rs_result_fs6)) {
$scanid6 = "$rs_result_fsr6->scanid";
$scantype6 = "$rs_result_fsr6->scantype";
$scannum6 = "$rs_result_fsr6->scannum";
$scantime6 = "$rs_result_fsr6->scantime";
$customprogword6 = "$rs_result_fsr6->customprogword";
$customprintinfo6 = "$rs_result_fsr6->customprintinfo";
$customscantype6 = "$rs_result_fsr6->customscantype";

if ($scantype6 != "0") {
$rs_foundscan_name6 = "SELECT * FROM pc_scans WHERE scanid = '$scantype6'";
$rs_result_fs_name6 = mysqli_query($rs_connect, $rs_foundscan_name6);
$rs_result_fsr_name6 = mysqli_fetch_object($rs_result_fs_name6);
$scantypeid6 = "$rs_result_fsr_name6->scanid";
$scantypeprog6 = "$rs_result_fsr_name6->progword";
$scantypeicon6 = "$rs_result_fsr_name6->progicon";
$printinfo6 = "$rs_result_fsr_name6->printinfo";
$myscantype6 = "$rs_result_fsr_name6->scantype";
} else {
$myscantype6 = $customscantype6;
}

if (($myscantype6 == 2) || ($customscantype6 == 2)) {

if ($switch2 == 0) {
$message .= "<br><br><div style=\"border: 3px solid #000066; padding:5px;\"><font style=\" COLOR: #000066; FONT-SIZE: 20px; FONT-WEIGHT: normal;\">".pcrtlang("Installed")."</div><br>\n";
$pearhtml .= "<br><br><div style=\"border: 3px solid #000066; padding:5px;\"><font style=\" COLOR: #000066; FONT-SIZE: 20px; FONT-WEIGHT: normal;\">".pcrtlang("Installed")."</div><br>\n";
}

$switch2 = 1;


$message .= "<font size=2><b>&bull; \n";
$pearhtml .= "<font size=2><b>&bull; \n";

if($customprogword6 != "") {
$message .= "$customprogword6\n";
$pearhtml .= "$customprogword6\n";
} else {
$message .= "$scantypeprog6\n";
$pearhtml .= "$scantypeprog6\n";
}

$message .= "</b><br><font size=2>\n";
$pearhtml .= "</b><br><font size=2>\n";

if($customprintinfo6 != "") {
$message .= "$customprintinfo6\n";
$pearhtml .= "$customprintinfo6\n";
} else {
$message .= "$printinfo6\n";
$pearhtml .= "$printinfo6\n";
}


$message .= "<br><br>\n";
$pearhtml .= "<br><br>\n";
}
}

$message .= "</td></tr></table>\n";
$pearhtml .= "</td></tr></table>\n";
#######################
################ notes
$message .= "<table width=650><tr><td width=650>\n";
$pearhtml .= "<table width=650><tr><td width=650>\n";
$rs_foundscan2 = "SELECT * FROM pc_scan WHERE woid = '$woid'";
$rs_result_fs2 = mysqli_query($rs_connect, $rs_foundscan2);



while($rs_result_fsr2 = mysqli_fetch_object($rs_result_fs2)) {
$scanid2 = "$rs_result_fsr2->scanid";
$scantype2 = "$rs_result_fsr2->scantype";
$scannum2 = "$rs_result_fsr2->scannum";
$scantime2 = "$rs_result_fsr2->scantime";
$customprogword2 = "$rs_result_fsr2->customprogword";
$customprintinfo2 = "$rs_result_fsr2->customprintinfo";
$customscantype2 = "$rs_result_fsr2->customscantype";

if ($scantype2 != "0") {
$rs_foundscan_name2 = "SELECT * FROM pc_scans WHERE scanid = '$scantype2'";
$rs_result_fs_name2 = mysqli_query($rs_connect, $rs_foundscan_name2);
$rs_result_fsr_name2 = mysqli_fetch_object($rs_result_fs_name2);
$scantypeid2 = "$rs_result_fsr_name2->scanid";
$scantypeprog2 = "$rs_result_fsr_name2->progword";
$scantypeicon2 = "$rs_result_fsr_name2->progicon";
$printinfo2 = "$rs_result_fsr_name2->printinfo";
$myscantype2 = "$rs_result_fsr_name2->scantype";
} else {
$myscantype2 = $customscantype2;
}

if (($myscantype2 == 3) || ($customscantype2 == 3)) {

if ($switch3 == 0) {
$message .= "<br><br><div style=\"border: 3px solid #000066; padding:5px;\"><font style=\" COLOR: #000066; FONT-SIZE: 20px; FONT-WEIGHT: normal;\">".pcrtlang("Notes")."</div><br>\n";
$pearhtml .= "<br><br><div style=\"border: 3px solid #000066; padding:5px;\"><font style=\" COLOR: #000066; FONT-SIZE: 20px; FONT-WEIGHT: normal;\">".pcrtlang("Notes")."</div><br>\n";
}

$switch3 = 1;


$message .= "<font size=2><b>&bull; \n";
$pearhtml .= "<font size=2><b>&bull; \n";

if($customprogword2 != "") {
$message .= "$customprogword2\n";
$pearhtml .= "$customprogword2\n";
} else {
$message .= "$scantypeprog2\n";
$pearhtml .= "$scantypeprog2\n";
}

$message .= "</b><br><font size=2>\n";
$pearhtml .= "</b><br><font size=2>\n";

if($customprintinfo2 != "") {
$message .= "$customprintinfo2\n";
$pearhtml .= "$customprintinfo2\n";
} else {
$message .= "$printinfo2\n";
$pearhtml .= "$printinfo2\n";
}


$message .= "<br><br>\n";
$pearhtml .= "<br><br>\n";

}
}

$message .= "</td></tr></table></body></html>\n\n";
$pearhtml .= "</td></tr></table></body></html>\n\n";
#######################


}
}

$message .= "--PHP-alt-$random_hash--\n\n";


if (!isset($pcrt_mailer)) {
$pcrt_mailer = "mail";
}

if ($pcrt_mailer == "mail") {
$mail_sent = @mail( $to, $subject, $message, $headers );
echo $mail_sent ? "<html><head><meta http-equiv=\"refresh\" content=\"2;url=index.php?pcwo=$woid\"></head><body>".pcrtlang("Mail sent")."<br><br><a href=index.php?pcwo=$woid>".pcrtlang("Return")."</a></body></html>" : pcrtlang("Mail failed");
} elseif (($pcrt_mailer == "pearsmtp") || ($pcrt_mailer == "pearsmtpauth") || ($pcrt_mailer == "pearphpmailer")) {


if (!@include('Mail.php'))  {
echo "<div style=\"border: #ff0000 2px solid; background:#FFBCBC; color:#ff0000; margin: 20px; padding:20px;\">";
echo "Sorry you server does not have support for the Pear Mail and Pear Mail-Mime library. Check with your host to see if it is supported, or visit go-pear.com to download the pear installer
that can be run from your website to install your own local copy of Pear and the Pear Mail and Pear Mail-Mime modules.<br><br>If you choose to install your own copy, after installing, you
will need to also add the Mail and Mail-Mime packages. You will need to use your host control panel to password protect the directory. You will also need to add a setting to a 
php.ini or php5.ini file to specify the runtime path of pear for your server. Quite often you can google your hosting provider name and pear to find a howto for your host. 
if you are running your own linux server, quite often your distribution provides ready to install Pear packages.";
echo "</div>";
die();
}

#include('Mail.php');
    include('Mail/mime.php');

    $pearmessage2 = new Mail_mime();

    $pearmessage2->setTXTBody($peartext);
    $pearmessage2->setHTMLBody($pearhtml);

if (isset($pcphoto)) {
$pearmessage2->addHTMLImage("../pcphotos/$pcphoto", 'image/jpeg');
}


$imagetype = mb_substr("../repair/$logo", -3);
if ($imagetype == "gif") {
$pearmessage2->addHTMLImage("../repair/$logo", 'image/gif');
} elseif ($imagetype == "jpg") {
$pearmessage2->addHTMLImage("../repair/$logo", 'image/jpeg');
} elseif ($imagetype == "png") {
$pearmessage2->addHTMLImage("../repair/$logo", 'image/png');
} else {
}

$mime_params = array(
  'text_encoding' => '7bit',
  'text_charset'  => 'UTF-8',
  'html_charset'  => 'UTF-8',
  'head_charset'  => 'UTF-8'
);

    $body = $pearmessage2->get($mime_params);
    $extraheaders = array("To"=>"$to","From"=>"$storeinfoarray[storeemail]", "Subject"=>"$subject", "Content-Type"  => "text/html; charset=UTF-8");
    $pearheaders = $pearmessage2->headers($extraheaders);


if ("$pcrt_mailer" == "pearsmtpauth") {
$smtp = Mail::factory('smtp',
   array ('host' => $pcrt_pear_host,
     'auth' => true,
     'port' => $pcrt_pear_port,
     'username' => $pcrt_pear_username,
     'password' => $pcrt_pear_password));
} elseif ("$pcrt_mailer" == "pearphpmailer") {
$smtp = Mail::factory('mail');
} elseif ("$pcrt_mailer" == "pearsmtp")  {
$smtp = Mail::factory('smtp');
} else {
die("Invalid Mailer Chosen");
}

$mailresult = $smtp->send("$to", $pearheaders, $body);

if (PEAR::isError($mailresult)) {
   echo("<p>" . $mailresult->getMessage() . "</p>");
  } else {
   echo "<html><head><meta http-equiv=\"refresh\" content=\"2;url=index.php?pcwo=$woid\"></head><body>".pcrtlang("Mail sent")."<br>";
   echo "<br><a href=index.php?pcwo=$woid#workorderinfo>".pcrtlang("Return")."</a></body></html>";
  }

} else {
echo "Error: invalid mailer specified in the deps.php config file";
}


}





##########################################################################################
function printclaimticket() {
require_once("validate.php");
require("deps.php");
require_once("common.php");

$woid = $_REQUEST['woid'];

userlog(13,$woid,'woid','');





$rs_findpc = "SELECT * FROM pc_wo WHERE woid = '$woid'";
$rs_result = mysqli_query($rs_connect, $rs_findpc);
while($rs_result_q = mysqli_fetch_object($rs_result)) {
$pcid = "$rs_result_q->pcid";
$probdesc = "$rs_result_q->probdesc";
$dropoff = "$rs_result_q->dropdate";
$pickup = "$rs_result_q->pickupdate";
$pcstatus = "$rs_result_q->pcstatus";
$custassetsindb = serializedarraytest("$rs_result_q->custassets");
$theprobsindb = serializedarraytest("$rs_result_q->commonproblems");
$rs_storeid = "$rs_result_q->storeid";
$thesig = "$rs_result_q->thesig";
$showsigct = "$rs_result_q->showsigct";
$showsigcttopaz = "$rs_result_q->showsigcttopaz";
$thesigtopaz = "$rs_result_q->thesigtopaz";

$storeinfoarray = getstoreinfo($rs_storeid);


$comprobarrayv = array();
$rs_chkscansv = "SELECT theproblem FROM commonproblems WHERE custviewable = '1'";
$rs_chkresult_sv = mysqli_query($rs_connect, $rs_chkscansv);
while($rs_chkresult_q_sv = mysqli_fetch_object($rs_chkresult_sv)) {
$theprobv = "$rs_chkresult_q_sv->theproblem";
array_push($comprobarrayv,"$theprobv");
}


$rs_findowner = "SELECT * FROM pc_owner WHERE pcid = '$pcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
while($rs_result_q2 = mysqli_fetch_object($rs_result2)) {
$pcname = "$rs_result_q2->pcname";
$pccompany = "$rs_result_q2->pccompany";
$pcphone = "$rs_result_q2->pcphone";
$pcworkphone = "$rs_result_q2->pcworkphone";
$pccellphone = "$rs_result_q2->pccellphone";
$pcmake = "$rs_result_q2->pcmake";
$pcemail = "$rs_result_q2->pcemail";
$pcaddress = "$rs_result_q2->pcaddress";
$pcaddress2 = "$rs_result_q2->pcaddress2";
$pccity = "$rs_result_q2->pccity";
$pcstate = "$rs_result_q2->pcstate";
$pczip = "$rs_result_q2->pczip";
$pcextra = serializedarraytest("$rs_result_q2->pcextra");


if ($pcphone != "") {
$phone2 = mb_substr(preg_replace("/[^\d]/","","$pcphone"), -4);
$phonel = "$pcphone";
} elseif ($pcworkphone != "") {
$phone2 = mb_substr(preg_replace("/[^\d]/","","$pcworkphone"), -4);
$phonel	= "$pcworkphone";
} elseif ($pccellphone != "") {
$phone2 = mb_substr(preg_replace("/[^\d]/","","$pccellphone"), -4);
$phonel	= "$pccellphone";
} else {
$phone2 = "";
$phonel	= "";
}

?>
<!DOCTYPE html>

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>-</title>

<?php

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../repair/printstyle.css\">";

if (!isset($enablesignaturepad_claimticket)) {
$enablesignaturepad_claimticket = "no";
}

if ($enablesignaturepad_claimticket == "yes") {
?>
 <link rel="stylesheet" href="../repair/jq/signature/jquery.signaturepad.css">
  <!--[if lt IE 9]><script src="../repair/jq/signature/flashcanvas.js"></script><![endif]-->
  <script src="../repair/jq/jquery.js"></script>

<?php

}


if ($enablesignaturepad_claimticket == "topaz") {
require("../repair/jq/topaz.js");
}


echo "<link rel=\"stylesheet\" href=\"fa5/css/all.min.css\">";
echo "<link rel=\"stylesheet\" href=\"fa5/css/v4-shims.min.css\">";

echo "</head>";

if($autoprint == 1) {
if(($enablesignaturepad_claimticket == "yes") || ($enablesignaturepad_claimticket == "topaz")) {
if($thesig != "") {
echo "<body class=printpagebg onLoad=\"window.print()\">";
} else {
echo "<body class=printpagebg>";
}
} else {
echo "<body class=printpagebg onLoad=\"window.print()\">";
}
} else {
echo "<body class=printpagebg>";
}

$pcname2 = urlencode($pcname);
$pccompany2 = urlencode($pccompany);
$pcmake2 = urlencode($pcmake);
$phonel2 = urlencode($phonel);

$pcemail_ue = urlencode("$pcemail");
$pcaddress_ue =  urlencode("$pcaddress");
$pcaddress2_ue =  urlencode("$pcaddress2");
$pccity_ue =  urlencode("$pccity");
$pcstate_ue =  urlencode("$pcstate");
$pczip_ue =  urlencode("$pczip");


echo "<div class=printbar>";
echo "<button onClick=\"parent.location='index.php?pcwo=$woid'\" class=bigbutton><img src=../repair/images/left.png style=\"vertical-align:middle;margin-bottom: .25em;\"></button>";
echo "<font class=text30b>&nbsp;&nbsp;&nbsp;</font>";
echo "<button onClick=\"print();\" class=bigbutton><img src=../repair/images/print.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Print")."</button>";
echo "<font class=text30b>&nbsp;&nbsp;&nbsp;</font>";
echo "<button onClick=\"parent.location='pc.php?func=emailclaimticket&woid=$woid&email=$pcemail'\" class=bigbutton><img src=../repair/images/email.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Email")."</button>";
echo "&nbsp;&nbsp;&nbsp;";
$backurl = urlencode("pc.php?func=printclaimticket&woid=$woid");
echo "<button onClick=\"parent.location='repairlabel.php?pcid=$pcid&name=$pcname2&company=$pccompany2&woid=$woid&pcmake=$pcmake2&pcphone=$phonel2&dymojsapi=html&backurl=$backurl'\" class=bigbutton>
<img src=../repair/images/labelprinter.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Asset Label")."</button>";
echo "<font class=text30b>&nbsp;&nbsp;&nbsp;</font>";
echo "<button onClick=\"parent.location='pc.php?func=addassetphoto&pcid=$pcid&woid=$woid'\" class=bigbutton><img src=../repair/images/cam.png style=\"
vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Photo")."</button>";
echo "<font class=text30b>&nbsp;&nbsp;&nbsp;</font>";
echo "<button onClick=\"parent.location='../storemobile/deposits.php?woid=$woid&cfirstname=$pcname2&ccompany=$pccompany2&caddress=$pcaddress_ue&caddress2=$pcaddress2_ue&ccity=$pccity_ue&cstate=$pcstate_ue&czip=$pczip_ue&cphone=$phonel2&cemail=$pcemail_ue'\" class=bigbutton><img src=../repair/images/deposits.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Deposit")."</button>";

echo "<font class=text30b>&nbsp;&nbsp;&nbsp;</font>";
$returnticket = urlencode("pc.php?func=printclaimticket&woid=$woid");
if($narrowct == 0) {
echo "<button onClick=\"parent.location='admin.php?func=switch_ct&ticket=$returnticket&switch=1'\" class=bigbutton><img src=../repair/images/narrowreceipts.png style=\"vertical-align:middle;margin-bottom: .25em;\"></button>";
} else {
echo "<button onClick=\"parent.location='admin.php?func=switch_ct&ticket=$returnticket&switch=0'\" class=bigbutton><img src=../repair/images/widereceipts.png style=\"vertical-align:middle;margin-bottom: .25em;\"></button>";
}


echo "</div>";


if(!$narrowct) {
echo "<div class=printpage>";
} else {
echo "<div class=printpage80>";
}

if(!$narrowct) {
echo "<table style=\"width:100%;\"><tr><td valign=top>";


echo "<table class=printables style=\"width:90%\">";

echo "<tr><th colspan=2><span class=\"sizeme20\"><i class=\"fa fa-user\"></i> $pcname</span></th></tr>";
if ("$pccompany" != "") {
echo "<tr><td>".pcrtlang("Company").": </td><td>$pccompany</td></tr>";
}
echo "<tr><td>".pcrtlang("Asset/Device ID").":</td><td>$pcid</td></tr><tr><td>".pcrtlang("Work Order ID").": </td><td>";
echo "<span class=\"colormeblue boldme\">$woid</span></td></tr><tr><td>".pcrtlang("Make/Model").":</td><td>$pcmake</td></tr>";

$allassetinfofields = array();

$rs_allfindassets = "SELECT * FROM mainassetinfofields WHERE showonclaim = '1'";
$rs_result2all = mysqli_query($rs_connect, $rs_allfindassets);
while ($rs_result_q2all = mysqli_fetch_object($rs_result2all)) {
$mainassetfieldid = "$rs_result_q2all->mainassetfieldid";
$mainassetfieldname = "$rs_result_q2all->mainassetfieldname";
$allassetinfofields[$mainassetfieldid] = "$mainassetfieldname";
}


foreach($pcextra as $key => $val) {
if($val != "") {
if(array_key_exists("$key", $allassetinfofields)) {
echo "<tr><td>$allassetinfofields[$key]: </td><td><span class=\"sizeme10\">$val</span></td></tr>";
}
}
}


$dropdate2 = pcrtdate("$pcrt_longdate", "$dropoff").", ".pcrtdate("$pcrt_time", "$dropoff");


echo "<tr><td>".pcrtlang("Customer Assets").": </td><td>";
foreach($custassetsindb as $key => $val) {
echo "$val :";
}
echo "</td></tr>";

echo "<tr><td><i class=\"fa fa-sign-in fa-lg fa-fw floatright\"></i></td><td>$dropdate2</td></tr>";

if($pcphone != "") {
echo "<tr><td><i class=\"fa fa-phone fa-lg fa-fw floatright\"></i></td><td>$pcphone</td></tr>";
}

if($pccellphone != "") {
echo "<tr><td><i class=\"fa fa-mobile fa-lg fa-fw floatright\"></i></td><td>$pccellphone</td></tr>";
}

if($pcworkphone != "") {
echo "<tr><td><i class=\"fa fa-briefcase fa-lg fa-fw floatright\"></i></td><td>$pcworkphone</td></tr>";
}

if($pcaddress != "") {
echo "<tr><td><i class=\"fa fa-map-marker fa-lg fa-fw floatright\"></i></td><td>$pcaddress";
if ($pcaddress2 != "") {
echo "<br>$pcaddress2";
}
echo "<br>$pccity, $pcstate $pczip</td></tr>";
}




if($pcemail != "") {
echo "<tr><td><i class=\"fa fa-envelope fa-lg fa-fw floatright\"></i></td><td>$pcemail</td></tr>";
}

echo "</table>";

echo "<br><br><font class=text12b>".pcrtlang("Problem as Described by Customer").":</font><br><blockquote><font class=text12>$probdesc</font><br><br>";

foreach($theprobsindb as $key => $val) {
if(in_array("$val",$comprobarrayv)) {
echo "<font class=text12b>&bull;</font><font class=text12> $val</font><br>";
}
}


echo "</blockquote>";

echo "</td><td align=center valign=top>";


echo "<br><font class=claimticketheader><i class=\"fa fa-ticket fa-lg\"></i> ".pcrtlang("Claim Ticket")."</font><br><br><br>";


echo "<img src=../repair/$printablelogo><br>";

echo "<font class=text12b><br><br>";
echo "$storeinfoarray[storename]</font><font class=text12><br>$storeinfoarray[storeaddy1]";
if ("$storeinfoarray[storeaddy2]" != "") {
echo "<br>$storeinfoarray[storeaddy2]";
}
echo "<br>$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]";
echo "</font><br><br><font class=text12>".pcrtlang("Phone").": $storeinfoarray[storephone]</font><br><br>";


echo "<img src=\"../repair/barcode.php?barcode=$woid&width=220&height=40&text=0\"><br>";


if ($pcrt_repairstatusscript != "") {
if ($phone2 != "" ) {
$qrdata2 = "$pcrt_repairstatusscript"."?func=showstatus&phone=$phone2&woid=$woid";
$qrdata = urlencode("$qrdata2");
echo "<br><font class=text10i>".pcrtlang("Check your repair status")."...<br>".pcrtlang("Scan with your Smartphone")."</font><br>";
echo "<img src=\"qr.php?qrdata=$qrdata\">";
}
}



echo "</td></tr></table>";


} else {
#start narrow
echo "<center><br>";
echo "<font class=claimticketheader><i class=\"fa fa-ticket fa-lg\"></i> ".pcrtlang("Claim Ticket")."</font><br><br>";

echo "<img src=\"../repair/barcode.php?barcode=$woid&width=220&height=20&text=0\"><br><br>";

echo "<img src=../repair/$printablelogo style=\"width:200px;\"><br>";

echo "<br><font class=text12b>$pcname</font><br>";
if ("$pccompany" != "") {
echo "<font class=text12b>$pccompany</font><br>";
}


echo "<br>";

if($pcphone != "") {
echo "<i class=\"fa fa-phone fa-lg fa-fw\"></i> $pcphone<br>";
}

if($pccellphone != "") {
echo "<i class=\"fa fa-mobile fa-lg fa-fw\"></i> $pccellphone<br>";
}

if($pcworkphone != "") {
echo "<i class=\"fa fa-briefcase fa-lg fa-fw\"></i> $pcworkphone<br>";
}

echo "<br>";

if($pcaddress != "") {
echo "<i class=\"fa fa-map-marker fa-lg fa-fw\"></i> $pcaddress";
if ($pcaddress2 != "") {
echo "<br>$pcaddress2";
}
echo "<br>$pccity, $pcstate $pczip<br>";
}

if($pcemail != "") {
echo "<br><i class=\"fa fa-envelope fa-lg fa-fw\"></i> $pcemail<br>";
}


echo "<br>";



echo "<font class=text12>".pcrtlang("Asset/Device ID").":</font> <font class=text12b>$pcid</font><br><font class=text12>".pcrtlang("Work Order ID Number").": </font>";
echo "<font class=text12b>$woid</font><font class=text12><br>".pcrtlang("Make/Model").":</font> <font class=text12b>$pcmake</font>";

$allassetinfofields = array();

$rs_allfindassets = "SELECT * FROM mainassetinfofields WHERE showonclaim = '1'";
$rs_result2all = mysqli_query($rs_connect, $rs_allfindassets);
while ($rs_result_q2all = mysqli_fetch_object($rs_result2all)) {
$mainassetfieldid = "$rs_result_q2all->mainassetfieldid";
$mainassetfieldname = "$rs_result_q2all->mainassetfieldname";
$allassetinfofields[$mainassetfieldid] = "$mainassetfieldname";
}


foreach($pcextra as $key => $val) {
if(array_key_exists("$key", $allassetinfofields)) {
if($val != "") {
echo "<br><font class=text10>$allassetinfofields[$key]: </font><font class=text10b>$val</font>";
}
}
}
echo "<br>";


$dropdate2 = date("F j, Y, g:i a", strtotime($dropoff));
echo "<br><font class=text12>".pcrtlang("Check In Date").":</font><br><font class=text12b>$dropdate2</font><br>";


echo "<br><font class=text10>".pcrtlang("Customer Assets").": </font><font class=text10>";
foreach($custassetsindb as $key => $val) {
echo "$val :";
}

if($pcemail != "") {
echo "<br><a href=\"pc.php?func=emailclaimticket&woid=$woid&email=$pcemail\" class=smalllink>".pcrtlang("Email").": $pcemail</a>";
}

echo "<br><br><font class=text10b>".pcrtlang("Problem as Described by Customer").":</font><br><blockquote><font class=text10>$probdesc</font><br>";

foreach($theprobsindb as $key => $val) {
if(in_array("$val",$comprobarrayv)) {
echo "<font class=text10b>&bull;</font><font class=text10> $val</font><br>";
}
}



echo "<font class=text12b><br><br>";
echo "$storeinfoarray[storename]</font><font class=text12><br>$storeinfoarray[storeaddy1]";
if ("$storeinfoarray[storeaddy2]" != "") {
echo "<br>$storeinfoarray[storeaddy2]";
}
echo "<br>$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]";
echo "</font><br><br><font class=text12>".pcrtlang("Phone").": $storeinfoarray[storephone]</font><br>";



if ($pcrt_repairstatusscript != "") {
if ($phone2 != "" ) {
$qrdata2 = "$pcrt_repairstatusscript"."?func=showstatus&phone=$phone2&woid=$woid";
$qrdata = urlencode("$qrdata2");
echo "<br><font class=text10i>".pcrtlang("Check your repair status")."...<br>".pcrtlang("Scan with your Smartphone")."</font><br>";
echo "<img src=\"qr.php?qrdata=$qrdata\">";
}
}


echo "</center>";
}


$rs_ct = "SELECT sigtext FROM claimsigtext WHERE woid = '$woid'";
$rs_result_ct2 = mysqli_query($rs_connect, $rs_ct);
if (mysqli_num_rows($rs_result_ct2) != "0") {
$rs_result_ctq2 = mysqli_fetch_object($rs_result_ct2);
$cttext = "$rs_result_ctq2->sigtext";
echo nl2br($cttext);
} else {
echo nl2br($storeinfoarray['claimticket']);
}


if($narrowct) {
echo "<br><br><br><br><font style=\"color:white;\">.</font>";
}


if (($enablesignaturepad_claimticket == "yes") && ($showsigct == "0") && (!$narrowct)) {
echo "<a href=pc.php?func=hidesigct&woid=$woid&hidesig=1 class=hideprintedlink><br><br>(".pcrtlang("show signature pad").")</a>";
}

if (($enablesignaturepad_claimticket == "yes") && ($showsigct == "1") && (!$narrowct)) {

if ($showsigct == "1") {
echo "<a href=pc.php?func=hidesigct&woid=$woid&hidesig=0 class=hideprintedlink><br><br>(".pcrtlang("hide signature pad").")</a>";
} 

if($thesig == "") {

?>
<blockquote>
  <form method="post" action="pc.php?func=savesig" class="sigPad">
<input type=hidden name=woid value=<?php echo $woid; ?>><input type=hidden name=claimstoreid value=<?php echo $rs_storeid; ?>>
    <p class="drawItDesc"><?php echo pcrtlang("Use Stylus to write your signature"); ?></p>
    <ul class="sigNav">
      <li class="clearButton"><a href="#clear"><?php echo pcrtlang("Clear Signature"); ?></a></li>
    </ul>
    <div class="sig sigWrapper">
      <div class="typed"></div>
      <canvas class="pad" width="446" height="75"></canvas>
      <input type="hidden" name="output" class="output">
    </div>
    <button type="submit"><?php echo pcrtlang("I accept the terms of this agreement."); ?></button>
  </form>

  <script src="../repair/jq/signature/jquery.signaturepad.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.sigPad').signaturePad({drawOnly:true,lineTop:60});
    });
  </script>
  <script src="../repair/jq/signature/json2.min.js"></script>
</blockquote>
<?php
} else {
echo "<br><br><font class=text16b>".pcrtlang("Signed").":</font> <a href=pc.php?func=clearsig&woid=$woid class=hideprintedlink>(".pcrtlang("remove signature").")</a><br>";
?>

<div class="sigPad signed">
  <div class="sigWrapper">
    <canvas class="pad" width="450" height="75"></canvas>
  </div>
</div>

<script type="text/javascript" src="../repair/jq/signature/jquery.signaturepad.min.js"></script>
<script>
$(document).ready(function () {
  $('.sigPad').signaturePad({displayOnly:true}).regenerate(<?php echo $thesig ?>)
})
</script>
<script type="text/javascript" src="../repair/jq/signature/json2.min.js"></script>
<?php
}

}


}

}



#start topaz

if ($enablesignaturepad_claimticket == "topaz") {

if ($showsigcttopaz == "0") {
echo "<a href=pc.php?func=hidesigcttopaz&woid=$woid&hidesig=1 class=hideprintedlink><br><br>(".pcrtlang("show signature pad").")</a>";
}

if ($showsigcttopaz == "1") {
echo "<a href=pc.php?func=hidesigcttopaz&woid=$woid&hidesigtopaz=0 class=hideprintedlink><br><br>(".pcrtlang("hide signature pad").")</a>";
}

if ($showsigcttopaz == "1") {
if ($thesigtopaz == "") {


?>

<br>
<canvas id="cnv" name="cnv" width="500" height="100"></canvas>

<form action="pc.php?func=savesigtopaz" name=FORM1 method=post>
<input id="SignBtn" name="SignBtn" type="button" value="<?php echo pcrtlang("Activate Sig Pad"); ?>"  class=button onclick="javascript:onSign()"/>&nbsp;&nbsp;&nbsp;&nbsp;
<input id="button1" name="ClearBtn" type="button" class=button value="Clear" onclick="javascript:onClear()"/>&nbsp;&nbsp;&nbsp;&nbsp

<input id="button2" name="DoneBtn" type="button" class=button value="Done" onclick="javascript:onDone()"/>&nbsp;&nbsp;&nbsp;&nbsp

<input type="submit" class=button value="Save">&nbsp;&nbsp;&nbsp;&nbsp

<INPUT TYPE=HIDDEN NAME="bioSigData">
<INPUT TYPE=HIDDEN NAME="sigImgData">

<input type=hidden name=woid value=<?php echo $woid; ?>><input type=hidden name=claimstoreid value=<?php echo $rs_storeid; ?>>

<input type=hidden NAME="sigImageData" value="">
</form>

<?php

} else {

echo "<br><br><font class=text16b>".pcrtlang("Signed").":</font><a href=pc.php?func=clearsigtopaz&woid=$woid class=hideprintedlink>(".pcrtlang("remove signature").")</a><br>";

if(!$narrowct) {
echo '<br><img src="data:image/png;base64,' . $thesigtopaz . '" />';
} else {
echo '<br><img src="data:image/png;base64,' . $thesigtopaz . '" width=260/>';
}

}

#end hide
}

}


echo "</div>";

}



####################################################################################################

function emailclaimticket() {
require_once("validate.php");
require("deps.php");

require_once("common.php");
require("dheader.php");


$email = $_REQUEST['email'];
$woid = $_REQUEST['woid'];


echo "<div data-role=\"header\" data-theme=\"b\"><h2>".pcrtlang("Email Claim Ticket")."</h2></div>";
echo "<div class=\"ui-content\" role=\"main\">";

echo "<br><form action=pc.php?func=emailclaimticket2 method=POST data-ajax=\"false\"><input type=text value=\"$email\" name=email>
<input type=hidden value=$woid name=woid>";
echo "<input type=submit  value=\"".pcrtlang("Email Claim Ticket")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Sending Email")."...'; this.form.submit();\" data-theme=\"b\"></form><br><br>";

echo "</div>";
require_once("dfooter.php");


}



function emailclaimticket2() {
require_once("validate.php");
require("deps.php");
require_once("common.php");
$woid = $_REQUEST['woid'];
$email = $_REQUEST['email'];

userlog(12,$woid,'woid',pcrtlang("Sent claim ticket to $email"));





$rs_findpc = "SELECT * FROM pc_wo WHERE woid = '$woid'";
$rs_result = mysqli_query($rs_connect, $rs_findpc);
while($rs_result_q = mysqli_fetch_object($rs_result)) {
$pcid = "$rs_result_q->pcid";
$probdesc = "$rs_result_q->probdesc";
$dropoff = "$rs_result_q->dropdate";
$pickup = "$rs_result_q->pickupdate";
$pcstatus = "$rs_result_q->pcstatus";
$custassetsindb = serializedarraytest("$rs_result_q->custassets");
$theprobsindb = serializedarraytest("$rs_result_q->commonproblems");
$rs_storeid = "$rs_result_q->storeid";
$thesig = "$rs_result_q->thesig";

$storeinfoarray = getstoreinfo($rs_storeid);

if (!isset($enablesignaturepad_claimticket)) {
$enablesignaturepad_claimticket = "no";
}





$comprobarrayv = array();
$rs_chkscansv = "SELECT theproblem FROM commonproblems WHERE custviewable = '1'";
$rs_chkresult_sv = mysqli_query($rs_connect, $rs_chkscansv);
while($rs_chkresult_q_sv = mysqli_fetch_object($rs_chkresult_sv)) {
$theprobv = "$rs_chkresult_q_sv->theproblem";
array_push($comprobarrayv,"$theprobv");
}


$rs_findowner = "SELECT * FROM pc_owner WHERE pcid = '$pcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
while($rs_result_q2 = mysqli_fetch_object($rs_result2)) {
$pcname = "$rs_result_q2->pcname";
$pccompany = "$rs_result_q2->pccompany";
$pcphone = "$rs_result_q2->pcphone";
$pcworkphone = "$rs_result_q2->pcworkphone";
$pccellphone = "$rs_result_q2->pccellphone";
$pcmake = "$rs_result_q2->pcmake";
$pcemail = "$rs_result_q2->pcemail";
$pcaddress = "$rs_result_q2->pcaddress";
$pcextra2 = "$rs_result_q2->pcextra";
$pcextra = serializedarraytest($pcextra2);


if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}



if ($pcphone != "") {
$phone2 = mb_substr("$pcphone", -4);
} elseif ($pcworkphone != "") {
$phone2 = mb_substr("$pcworkphone", -4);
} elseif ($pccellphone != "") {
$phone2 = mb_substr("$pccellphone", -4);
} else {
$phone2 = "";
}



$to = "$email";

if("$storeinfoarray[storeccemail]" != "")	{
$to .= ",$storeinfoarray[storeccemail]";
}

$subject = "$storeinfoarray[storename] - ".pcrtlang("Claim Ticket");
$random_hash = md5(date('r', time()));
$headers = "From: $storeinfoarray[storeemail]\nReply-To: $storeinfoarray[storeemail]\nX-Mailer: PHP/".phpversion();
$headers .= "\nMIME-Version: 1.0";
$headers .= "\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
$headers .= "\nMIME-Version: 1.0";

$message = "--PHP-alt-$random_hash\n";
$message .= "Content-Transfer-Encoding: 7bit\n";
$message .= "Content-Type: text/plain; charset=\"utf-8\"\n\n";

$peartext = "Sorry, Your email client does not support html email.\n\n";
$message .= "Sorry, Your email client does not support html email.\n\n";

$message .= "--PHP-alt-$random_hash\n";
$message .= "Content-Transfer-Encoding: 7bit\n";
$message .= "Content-Type: text/html; charset=\"utf-8\"\n\n";



$message .= "<html><head><title>$sitename</title></head>\n\n";
$pearhtml = "<html><head><title>$sitename</title></head>\n\n";

$message .= "<table width=100%><tr><td valign=top><font size=5>$storeinfoarray[storename]</font></td><td>\n";
$pearhtml .= "<table width=100%><tr><td valign=top><img src=$logo></td><td>\n";

$message .= "<b><font size=4>".pcrtlang("Repair Claim Ticket")."</font><br>$storeinfoarray[storename]<br>$storeinfoarray[storephone]</b><br>\n";
$pearhtml .= "<b><font size=4>".pcrtlang("Repair Claim Ticket")."</font><br>$storeinfoarray[storename]<br>$storeinfoarray[storephone]</b><br>\n";

$message .= "</td></tr></table><br>\n";
$pearhtml .= "</td></tr></table><br>\n";

$message .= "<font size=4>".pcrtlang("Customer Name").": <b>$pcname</b></font>";
if("$pccompany" != "") {
$message .= "<br><font size=4>".pcrtlang("Company").": <b>$pccompany</b></font>";
}
$message .= "<br>".pcrtlang("Asset/Device ID").": <font color=red size=5><b>$pcid</b></font>\n";
$pearhtml .= "<font size=4>".pcrtlang("Customer Name").": <b>$pcname</b></font>";
if("$pccompany" != "") {
$pearhtml .= "<br><font size=4>".pcrtlang("Company").": <b>$pccompany</b></font>";
}
$pearhtml .= "<br>".pcrtlang("Asset/Device ID").": <font color=red size=5><b>$pcid</b></font>\n";

$message .= "<br>".pcrtlang("Work Order ID Number").": <font color=red size=5><b>$woid</b></font><font size=2><br>".pcrtlang("Make/Model").": <b>$pcmake</b></font>\n";
$pearhtml .= "<br>".pcrtlang("Work Order ID Number").": <font color=red size=5><b>$woid</b></font><font size=2><br>".pcrtlang("Make/Model").": <b>$pcmake</b></font>\n";

$allassetinfofields = array();

$rs_allfindassets = "SELECT * FROM mainassetinfofields WHERE showonclaim = '1'";
$rs_result2all = mysqli_query($rs_connect, $rs_allfindassets);
while ($rs_result_q2all = mysqli_fetch_object($rs_result2all)) {
$mainassetfieldid = "$rs_result_q2all->mainassetfieldid";
$mainassetfieldname = "$rs_result_q2all->mainassetfieldname";
$allassetinfofields[$mainassetfieldid] = "$mainassetfieldname";
}

foreach($pcextra as $key => $val) {
if(array_key_exists("$key", $allassetinfofields)) {
$message .= "<br>$allassetinfofields[$key]: <b>$val</b>\n";
$pearhtml .= "<br>$allassetinfofields[$key]: <b>$val</b>\n";
}
}


$message .= "<br>".pcrtlang("Customer Assets").":<b>\n";
$pearhtml .= "<br>".pcrtlang("Customer Assets").":<b>\n";
foreach($custassetsindb as $key => $val) {
$message .= "$val :";
$pearhtml .= "$val :";
}



$message .= "</b><br>".pcrtlang("Customer Phone").": <b>$pcphone</b>\n";
$pearhtml .= "</b><br>".pcrtlang("Customer Phone").": <b>$pcphone</b>\n";

if($pccellphone != "") {
$message .= "<br>".pcrtlang("Customer Mobile Phone").": <b>$pccellphone</b>\n";
$pearhtml .= "<br>".pcrtlang("Customer Mobile Phone").": <b>$pccellphone</b>\n";
}

if($pcworkphone != "") {
$message .= "<br>".pcrtlang("Customer Work Phone").": <b>$pcworkphone</b>\n";
$pearhtml .= "<br>".pcrtlang("Customer Work Phone").": <b>$pcworkphone</b>\n";
}


if($pcemail != "") {
$message .= "<br>".pcrtlang("Email").": <b>$pcemail</b>\n";
$pearhtml .= "<br>".pcrtlang("Email").": <b>$pcemail</b>\n";
}

$message .= "<br><br><b>".pcrtlang("Problem as Described by Customer").":</b><br><blockquote><font size=2>$probdesc<br><br>\n";
$pearhtml .= "<br><br><b>".pcrtlang("Problem as Described by Customer").":</b><br><blockquote><font size=2>$probdesc<br><br>\n";

foreach($theprobsindb as $key => $val) {
if(in_array("$val",$comprobarrayv)) {
$message .= "&bull; $val<br>\n";
$pearhtml .= "&bull; $val<br>\n";
}
}

$message .= "</blockquote>\n";
$pearhtml .= "</blockquote>\n";

$message .= "<br>\n";
$pearhtml .= "<br>\n";

$rs_ct = "SELECT sigtext FROM claimsigtext WHERE woid = '$woid'";
$rs_result_ct2 = mysqli_query($rs_connect, $rs_ct);
if (mysqli_num_rows($rs_result_ct2) != "0") {
$rs_result_ctq2 = mysqli_fetch_object($rs_result_ct2);
$cttext = "$rs_result_ctq2->sigtext";
$message .= nl2br($cttext);
$pearhtml .= nl2br($cttext);
} else {
$message .= nl2br($storeinfoarray['claimticket']);
$pearhtml .= nl2br($storeinfoarray['claimticket']);
}



if (($enablesignaturepad_claimticket == "yes") && ($thesig != "")) {
$pearhtml .= "<br><br>".pcrtlang("Signed").":<br><img src=signature.png>";
}


if ($pcrt_repairstatusscript != "") {
if ($phone2 != "" ) {
$link = "$pcrt_repairstatusscript"."?func=showstatus&phone=$phone2&woid=$woid";
$message .= "<br><br><a href=\"$link\">".pcrtlang("Click here to check repair status")."</a>\n";
$pearhtml .= "<br><br><a href=\"$link\">".pcrtlang("Click here to check repair status")."</a>\n";
}
}

$message .= "</body></html>\n\n";
$pearhtml .= "</body></html>\n\n";

}

}

$message .= "--PHP-alt-$random_hash--\n\n";

if (!isset($pcrt_mailer)) {
$pcrt_mailer = "mail";
}

if ($pcrt_mailer == "mail") {
$mail_sent = @mail( $to, $subject, $message, $headers );
echo $mail_sent ? "<html><head><meta http-equiv=\"refresh\" content=\"2;url=index.php?pcwo=$woid\"></head>
<body>".pcrtlang("Mail sent")."<br><br><a href=index.php?pcwo=$woid>".pcrtlang("Return")."</a></body></html>" : pcrtlang("Mail failed");
} elseif (($pcrt_mailer == "pearsmtp") || ($pcrt_mailer == "pearsmtpauth") || ($pcrt_mailer == "pearphpmailer")) {

if (!@include('Mail.php'))  {
echo "<div style=\"border: #ff0000 2px solid; background:#FFBCBC; color:#ff0000; margin: 20px; padding:20px;\">";
echo "Sorry you server does not have support for the Pear Mail and Pear Mail-Mime library. Check with your host to see if it is supported, or visit go-pear.com to download the pear installer
that can be run from your website to install your own local copy of Pear and the Pear Mail and Pear Mail-Mime modules.<br><br>If you choose to install your own copy, after installing, you
will need to also add the Mail and Mail-Mime packages. You will need to use your host control panel to password protect the directory. You will also need to add a setting to a
php.ini or php5.ini file to specify the runtime path of pear for your server. Quite often you can google your hosting provider name and pear to find a howto for your host.
if you are running your own linux server, quite often your distribution provides ready to install Pear packages.";
echo "</div>";
die();
}


#include('Mail.php');
    include('Mail/mime.php');

    $pearmessage2 = new Mail_mime();

    $pearmessage2->setTXTBody($peartext);
    $pearmessage2->setHTMLBody($pearhtml);

$imagetype = mb_substr("../repair/$logo", -3);
if ($imagetype == "gif") { 
$pearmessage2->addHTMLImage("../repair/$logo", 'image/gif');
} elseif ($imagetype == "jpg") {
$pearmessage2->addHTMLImage("../repair/$logo", 'image/jpeg');
} elseif ($imagetype == "png") {
$pearmessage2->addHTMLImage("../repair/$logo", 'image/png');
} else {
}

if (($enablesignaturepad_claimticket == "yes") && ($thesig != "")) {
require_once("../repair/jq/signature/jsontopng.php");
$sigimgg = sigJsonToImage($thesig, array('imageSize'=>array(450, 75)));
ob_start();
imagepng($sigimgg);
$image_data = ob_get_contents();
ob_end_clean();
$pearmessage2->addHTMLImage("$image_data", 'image/png', 'signature.png', false);
imagedestroy($sigimgg);
}

$mime_params = array(
  'text_encoding' => '7bit',
  'text_charset'  => 'UTF-8',
  'html_charset'  => 'UTF-8',
  'head_charset'  => 'UTF-8'
);

    $body = $pearmessage2->get($mime_params);
    $extraheaders = array("To"=>"$to","From"=>"$storeinfoarray[storeemail]", "Subject"=>"$subject", "Content-Type"  => "text/html; charset=UTF-8");
    $pearheaders = $pearmessage2->headers($extraheaders);

if ("$pcrt_mailer" == "pearsmtpauth") {
$smtp = Mail::factory('smtp',
   array ('host' => $pcrt_pear_host,
     'auth' => true,
     'port' => $pcrt_pear_port,
     'username' => $pcrt_pear_username,
     'password' => $pcrt_pear_password));
} elseif ("$pcrt_mailer" == "pearphpmailer") {
$smtp = Mail::factory('mail');
} elseif ("$pcrt_mailer" == "pearsmtp")  {
$smtp = Mail::factory('smtp');
} else {
die("Invalid Mailer Chosen");
}



$mailresult = $smtp->send("$to", $pearheaders, $body);

if (PEAR::isError($mailresult)) {
$fademessage = $mailresult->getMessage();
$fademessage2 = pcrtlang("Failed to Email Claim Ticket... <br><br>Error Message:")."$fademessage";
$fademessage3 = urlencode("$fademessage2");
header("Location: index.php?pcwo=$woid&fademessage=$fademessage3&fademessagetype=error");

  } else {

$fademessage2 = pcrtlang("Claim Ticket Email Sent Sucessfully to $to");
$fademessage3 = urlencode("$fademessage2");
header("Location: index.php?pcwo=$woid&fademessage=$fademessage3&fademessagetype=success");

  }

} else {
echo "Error: invalid mailer specified in the deps.php config file";
}


}

################################################################



function printcheckoutreceipt() {
require_once("validate.php");
require("deps.php");
require_once("common.php");

$woid = $_REQUEST['woid'];

userlog(13,$woid,'woid','');





$rs_findpc = "SELECT * FROM pc_wo WHERE woid = '$woid'";
$rs_result = mysqli_query($rs_connect, $rs_findpc);
while($rs_result_q = mysqli_fetch_object($rs_result)) {
$pcid = "$rs_result_q->pcid";
$probdesc = "$rs_result_q->probdesc";
$dropoff = "$rs_result_q->dropdate";
$pickup = "$rs_result_q->pickupdate";
$pcstatus = "$rs_result_q->pcstatus";
$custassetsindb = serializedarraytest("$rs_result_q->custassets");
$theprobsindb = serializedarraytest("$rs_result_q->commonproblems");
$rs_storeid = "$rs_result_q->storeid";
$thesigcr = "$rs_result_q->thesigcr";
$showsigcr = "$rs_result_q->showsigcr";
$thesigcrtopaz = "$rs_result_q->thesigcrtopaz";
$showsigcrtopaz = "$rs_result_q->showsigcrtopaz";

$storeinfoarray = getstoreinfo($rs_storeid);


$comprobarrayv = array();
$rs_chkscansv = "SELECT theproblem FROM commonproblems WHERE custviewable = '1'";
$rs_chkresult_sv = mysqli_query($rs_connect, $rs_chkscansv);
while($rs_chkresult_q_sv = mysqli_fetch_object($rs_chkresult_sv)) {
$theprobv = "$rs_chkresult_q_sv->theproblem";
array_push($comprobarrayv,"$theprobv");
}


$rs_findowner = "SELECT * FROM pc_owner WHERE pcid = '$pcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
while($rs_result_q2 = mysqli_fetch_object($rs_result2)) {
$pcname = "$rs_result_q2->pcname";
$pccompany = "$rs_result_q2->pccompany";
$pcphone = "$rs_result_q2->pcphone";
$pcworkphone = "$rs_result_q2->pcworkphone";
$pccellphone = "$rs_result_q2->pccellphone";
$pcmake = "$rs_result_q2->pcmake";
$pcemail = "$rs_result_q2->pcemail";
$pcaddress = "$rs_result_q2->pcaddress";
$pcaddress2 = "$rs_result_q2->pcaddress2";
$pccity = "$rs_result_q2->pccity";
$pcstate = "$rs_result_q2->pcstate";
$pczip = "$rs_result_q2->pczip";
$pcextra2 = "$rs_result_q2->pcextra";
$pcextra = serializedarraytest($pcextra2);

if ($pcphone != "") {
$phone2 = mb_substr("$pcphone", -4);
$phonel = "$pcphone";
} elseif ($pcworkphone != "") {
$phone2 = mb_substr("$pcworkphone", -4);
$phonel = "$pcworkphone";
} elseif ($pccellphone != "") {
$phone2 = mb_substr("$pccellphone", -4);
$phonel = "$pccellphone";
} else {
$phone2 = "";
$phonel = "";
}

?>
<!DOCTYPE html>

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>-</title>

<?php


echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../repair/printstyle.css\">";

if (!isset($enablesignaturepad_checkoutreceipt)) {
$enablesignaturepad_checkoutreceipt = "no";
}

if ($enablesignaturepad_checkoutreceipt == "yes") {
?>
 <link rel="stylesheet" href="../repair/jq/signature/jquery.signaturepad.css">
  <!--[if lt IE 9]><script src="../repair/jq/signature/flashcanvas.js"></script><![endif]-->
  <script src="../repair/jq/jquery.js"></script>

<?php

}

echo "<link rel=\"stylesheet\" href=\"fa5/css/all.min.css\">";
echo "<link rel=\"stylesheet\" href=\"fa5/css/v4-shims.min.css\">";

echo "</head>";

if($autoprint == 1) {
if(($enablesignaturepad_checkoutreceipt == "yes") && ($enablesignaturepad_checkoutreceipt == "topaz")) {
if($thesig != "") {
echo "<body class=printpagebg onLoad=\"window.print()\">";
} else {
echo "<body class=printpagebg>";
}
} else {
echo "<body class=printpagebg onLoad=\"window.print()\">";
}
} else {
echo "<body class=printpagebg>";
}

$pcname2 = urlencode($pcname);
$pccompany2 = urlencode($pccompany);
$pcmake2 = urlencode($pcmake);
$phonel2 = urlencode($phonel);

$pcemail_ue = urlencode("$pcemail");
$pcaddress_ue =  urlencode("$pcaddress");
$pcaddress2_ue =  urlencode("$pcaddress2");
$pccity_ue =  urlencode("$pccity");
$pcstate_ue =  urlencode("$pcstate");
$pczip_ue =  urlencode("$pczip");

echo "<div class=printbar>";
echo "<button onClick=\"parent.location='index.php?pcwo=$woid'\" class=bigbutton><img src=../repair/images/left.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Return")."</button>";
echo "<font class=text30b>&nbsp;&nbsp;&nbsp;</font>";
echo "<button onClick=\"print();\" class=bigbutton><img src=../repair/images/print.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Print")."</button>";
echo "</div>
";


echo "<div class=printpage>";
echo "<table width=100%><tr><td valign=top><table class=printables style=\"width:90%\">";

echo "<tr><th colspan=2><span class=sizeme20><i class=\"fa fa-user fa-lg fa-fw\"></i> $pcname</span></th></tr>";
if ("$pccompany" != "") {
echo "<tr><td>".pcrtlang("Company").": </td><td>$pccompany</td></tr>";
}
echo "<tr><td>".pcrtlang("Asset/Device ID").":</td><td>$pcid</td></tr>";
echo "<tr><td>".pcrtlang("Work Order ID Number").":</td><td>$woid</td></tr>";
echo "<tr><td>".pcrtlang("Make/Model").":</td><td>$pcmake</td></tr>";

$allassetinfofields = array();

$rs_allfindassets = "SELECT * FROM mainassetinfofields WHERE showoncheckout = '1'";
$rs_result2all = mysqli_query($rs_connect, $rs_allfindassets);
while ($rs_result_q2all = mysqli_fetch_object($rs_result2all)) {
$mainassetfieldid = "$rs_result_q2all->mainassetfieldid";
$mainassetfieldname = "$rs_result_q2all->mainassetfieldname";
$allassetinfofields[$mainassetfieldid] = "$mainassetfieldname";
}

foreach($pcextra as $key => $val) {
if(array_key_exists("$key", $allassetinfofields)) {
echo "<tr><td>$allassetinfofields[$key]: </td><td>$val</td></tr>";
}
}


$dropdate2 = pcrtdate("$pcrt_longdate", "$dropoff").", ".pcrtdate("$pcrt_time", "$dropoff");

$pickup2 = pcrtdate("$pcrt_longdate", "$pickup").", ".pcrtdate("$pcrt_time", "$pickup");

echo "<tr><td>".pcrtlang("Check In Date").":</td><td>$dropdate2</td></tr>";

if($pickup != "0000-00-00 00:00:00") {
echo "<tr><td>".pcrtlang("Check Out Date").":</td><td>$pickup2</td></tr>";
}



echo "<tr><td>".pcrtlang("Customer Assets").":</td><td>";
foreach($custassetsindb as $key => $val) {
echo "$val :";
}

echo "</td></tr>";


echo "<tr><td><i class=\"fa fa-phone fa-lg fa-fw floatright\"></i></td><td>$pcphone</td></tr>";

if($pccellphone != "") {
echo "<tr><td><i class=\"fa fa-mobile fa-lg fa-fw floatright\"></i></td><td>$pccellphone</td></tr>";
}

if($pcworkphone != "") {
echo "<tr><td><i class=\"fa fa-briefcase fa-lg fa-fw floatright\"></i></td><td>$pcworkphone</td></tr>";
}

if($pcaddress != "") {
echo "<tr><td><i class=\"fa fa-map-marker fa-lg fa-fw floatright\"></i></td><td>$pcaddress";
if ($pcaddress2 != "") {
echo "<br>$pcaddress2";
}
echo "<br>$pccity, $pcstate $pczip</td></tr>";
}



if($pcemail != "") {
echo "<tr><td><i class=\"fa fa-envelope fa-lg fa-fw floatright\"></i></td><td>$pcemail</td></tr>";
}

echo "</table>";

echo "<br><br><font class=text12b>".pcrtlang("Problem as Described by Customer").":</font><br><blockquote><font class=text12>$probdesc</font><br><br>";

foreach($theprobsindb as $key => $val) {
if(in_array("$val",$comprobarrayv)) {
echo "<font class=text12b>&bull;</font><font class=text12> $val</font><br>";
}
}
echo "</blockquote>";

echo "</td><td align=center valign=top>";

echo "<br><font class=claimticketheader><i class=\"fa fa-sign-out fa-lg\"></i> ".pcrtlang("Checkout Receipt")."</font><br><br><br>";

echo "<img src=../repair/$printablelogo><br>";

echo "<font class=text12b><br><br>";
echo "$storeinfoarray[storename]</font><font class=text12><br>$storeinfoarray[storeaddy1]";
if ("$storeinfoarray[storeaddy2]" != "") {
echo "<br>$storeinfoarray[storeaddy2]";
}
echo "<br>$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]";
echo "</font><br><br><font class=text12>".pcrtlang("Phone").": $storeinfoarray[storephone]</font><br><br>";


echo "<img src=\"barcode.php?barcode=$woid&width=220&height=40&text=0\"><br>";


echo "</td></tr></table>";

echo nl2br($storeinfoarray['checkoutreceipt']);

if (($enablesignaturepad_checkoutreceipt == "yes") && ($showsigcr == "0")) {
echo "<a href=pc.php?func=hidesigcr&woid=$woid&hidesig=1 class=hideprintedlink><br><br>(".pcrtlang("show signature pad").")</a>";
}

if (($enablesignaturepad_checkoutreceipt == "yes") && ($showsigcr == "1")) {

if ($showsigcr == "1") {
echo "<a href=pc.php?func=hidesigcr&woid=$woid&hidesig=0 class=hideprintedlink><br><br>(".pcrtlang("hide signature pad").")</a>";
}

if($thesigcr == "") {

?>
<blockquote>
  <form method="post" action="pc.php?func=savesigcr" class="sigPad"><input type=hidden name=woid value=<?php echo $woid; ?>><input type=hidden name=claimstoreid value=<?php echo $rs_storeid; ?>>
    <p class="drawItDesc"><?php echo pcrtlang("Use Stylus to write your signature"); ?></p>
    <ul class="sigNav">
      <li class="clearButton"><a href="#clear"><?php echo pcrtlang("Clear Signature"); ?></a></li>
    </ul>
    <div class="sig sigWrapper">
      <div class="typed"></div>
      <canvas class="pad" width="446" height="75"></canvas>
      <input type="hidden" name="output" class="output">
    </div>
    <button type="submit"><?php echo pcrtlang("I accept the terms of this agreement."); ?></button>
  </form>

  <script src="../repair/jq/signature/jquery.signaturepad.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.sigPad').signaturePad({drawOnly:true,lineTop:60});
    });
  </script>
  <script src="../repair/jq/signature/json2.min.js"></script>
</blockquote>
<?php
} else {
echo "<br><br><font class=text16b>".pcrtlang("Signed").":</font> <a href=pc.php?func=clearsigcr&woid=$woid class=hideprintedlink>(".pcrtlang("remove signature").")</a><br>";
?>

<div class="sigPad signed">
  <div class="sigWrapper">
    <canvas class="pad" width="450" height="75"></canvas>
  </div>
</div>

<script type="text/javascript" src="../repair/jq/signature/jquery.signaturepad.min.js"></script>
<script>
$(document).ready(function () {
  $('.sigPad').signaturePad({displayOnly:true}).regenerate(<?php echo $thesigcr ?>)
})
</script>
<script type="text/javascript" src="../repair/jq/signature/json2.min.js"></script>
<?php
}

}


}

}



if ($enablesignaturepad_checkoutreceipt == "topaz") {
require("jq/topaz.js");
}






#start topaz

if ($enablesignaturepad_checkoutreceipt == "topaz") {

if ($showsigcrtopaz == "0") {
echo "<a href=pc.php?func=hidesigcrtopaz&woid=$woid&hidesig=1 class=hideprintedlink><br><br>(".pcrtlang("show signature pad").")</a>";
}

if ($showsigcrtopaz == "1") {
echo "<a href=pc.php?func=hidesigcrtopaz&woid=$woid&hidesig=0 class=hideprintedlink><br><br>(".pcrtlang("hide signature pad").")</a>";
}

if ($showsigcrtopaz == "1") {
if ($thesigcrtopaz == "") {


?>

<br>
<canvas id="cnv" name="cnv" width="500" height="100"></canvas>

<form action="pc.php?func=savesigcrtopaz" name=FORM1 method=post>
<input id="SignBtn" name="SignBtn" type="button" value="<?php echo pcrtlang("Activate Sig Pad"); ?>"  class=button onclick="javascript:onSign()"/>&nbsp;&nbsp;&nbsp;&nbsp;
<input id="button1" name="ClearBtn" type="button" class=button value="Clear" onclick="javascript:onClear()"/>&nbsp;&nbsp;&nbsp;&nbsp;
<input id="button2" name="DoneBtn" type="button" class=button value="Done" onclick="javascript:onDone()"/>&nbsp;&nbsp;&nbsp;&nbsp;

<input type="submit" class=button value="Save">&nbsp;&nbsp;&nbsp;&nbsp

<INPUT TYPE=HIDDEN NAME="bioSigData">
<INPUT TYPE=HIDDEN NAME="sigImgData">

<input type=hidden name=woid value=<?php echo $woid; ?>>

<input type=hidden NAME="sigImageData" value="">
</form>



<?php

} else {
echo "<br><br><font class=text16b>".pcrtlang("Signed").":</font><a href=pc.php?func=clearsigcrtopaz&woid=$woid class=hideprintedlink>(".pcrtlang("remove signature").")</a><br>";

echo '<br><img src="data:image/png;base64,' . $thesigcrtopaz . '" />';

}

#end hide
}

}
#end topaz






echo "</div>";

}















##########################

function showpc() {
require("header.php");
require("deps.php");
                                                                                                                                               
$pcid = pv($_REQUEST['pcid']);

                   





$rs_find_pc = "SELECT * FROM pc_owner WHERE pcid = '$pcid'";
$rs_result_item = mysqli_query($rs_connect, $rs_find_pc);

if ((mysqli_num_rows($rs_result_item) != "0") && (is_numeric($pcid))) {


while($rs_result_item_q = mysqli_fetch_object($rs_result_item)) {
$pcname = "$rs_result_item_q->pcname";
$pccompany = "$rs_result_item_q->pccompany";
$pcphone = "$rs_result_item_q->pcphone";
$pccellphone = "$rs_result_item_q->pccellphone";
$pcworkphone = "$rs_result_item_q->pcworkphone";
$pcemail = "$rs_result_item_q->pcemail";
$pcmake = "$rs_result_item_q->pcmake";
$pcaddress = "$rs_result_item_q->pcaddress";
$pcaddress2 = "$rs_result_item_q->pcaddress2";
$pccity = "$rs_result_item_q->pccity";
$pcstate = "$rs_result_item_q->pcstate";
$pczip = "$rs_result_item_q->pczip";
$pcnotes = "$rs_result_item_q->pcnotes";

$custompcinfoindb = serializedarraytest("$rs_result_item_q->pcextra");




if ("$pccompany" != "") {
$boxfill = pcrtlang("Work Order History")."<br> $pcname <br> $pccompany <br> $pcmake";
} else {
$boxfill = pcrtlang("Work Order History")."<br> $pcname <br> $pcmake";
}



echo "<table class=\"standard\">";

echo "<tr><th>$boxfill</th></tr>";

echo "<tr><td valign=top>";

echo pcrtlang("Viewing Asset/Customer ID").": $pcid<br><br>";

echo "<table border=0 cellspacing=0 cellpadding=2><tr><td style=\"background:#0000ff;border-radius:3px;\"><i class=\"fa fa-phone fa-lg\" style=\"padding:20px 3px;color:white;\"></i></td><td>";

if($pcphone != "") {
echo "&nbsp;".pcrtlang("Home").": $pcphone<br>";
}

if($pccellphone != "") {
echo "&nbsp;".pcrtlang("Cell").": $pccellphone<br>";
}

if($pcworkphone != "") {
echo "&nbsp;".pcrtlang("Work").": $pcworkphone";
}

echo "</td></tr></table><br>";



if($pcaddress != "") {
$pcaddressbr = nl2br($pcaddress);
echo "<table cellpadding=2 cellspacing=0 border=0><tr><td style=\"background:#0000ff;border-radius:3px;\"><i class=\"fa fa-map-marker fa-lg\" style=\"padding:20px 5px;color:white;\"></i></td><td>$pcaddressbr<br>";
if($pcaddress2 != "") {
echo "$pcaddress2<br>";
}
echo "$pccity, $pcstate $pczip";
echo "</td></tr></table>";
}



if($pcemail != "") {
echo "<button type=button onClick=\"parent.location='mailto:$pcemail'\"><i class=\"fa fa-envelope fa-lg\"></i> $pcemail</button>";
}

$pcnotes2 = nl2br($pcnotes);

if($pcnotes != "") {
echo "<table class=standard><tr><th>".pcrtlang("Notes")."</th></tr><tr><td>$pcnotes2</td></tr></table>";
}


echo "<button type=button onClick=\"parent.location='pc.php?func=editowner&pcid=$pcid&woid=0'\"><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("Edit Customer Info")."</button>";
echo "<button type=button onClick=\"parent.location='pc.php?func=returnpc2&pcid=$pcid'\"><i class=\"fa fa-reply-all fa-lg\"></i> ".pcrtlang("Create New WO for Device/Asset")."</button>";
echo "<button type=button onClick=\"parent.location='pc.php?func=addpc&copypcid=$pcid'\"><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("New Device for this Customer")."</button>";

$pcname2 = urlencode($pcname);
$pcphone2 = urlencode($pcphone);
$pcemail2 = urlencode($pcemail);
$pcaddress12 = urlencode($pcaddress);
$pcaddress22 = urlencode($pcaddress2);
$pccity2 = urlencode($pccity);
$pcstate2 = urlencode($pcstate);
$pczip2 = urlencode($pczip);



echo "<button type=button onClick=\"parent.location='sticky.php?func=addsticky&stickyname=$pcname2&stickyaddy1=$pcaddress12&stickyaddy2=$pcaddress22&stickycity=$pccity2&stickystate=$pcstate2&stickyzip=$pczip2&stickyemail=$pcemail2&stickyphone=$pcphone2&stickyrefid=$pcid&stickyreftype=pcid'\"\"><img src=../repair/images/sticky.png align=absmiddle> ".pcrtlang("Create Sticky Note")."</button>";

echo "</td></tr></table><br><br><table class=standard><tr><th>".pcrtlang("Asset/Device Info")."</th></tr><tr><td>";

$rs_findpic = "SELECT * FROM assetphotos WHERE pcid = '$pcid' AND highlight='1'";
$rs_resultpic2 = mysqli_query($rs_connect, $rs_findpic);

if (mysqli_num_rows($rs_resultpic2) != "0") {
$rs_resultpic_q2 = mysqli_fetch_object($rs_resultpic2);
$assetphotoid = "$rs_resultpic_q2->assetphotoid";
echo "<img src=pc.php?func=getpcimage&photoid=$assetphotoid border=1 width=256><br>";
}

echo "<table class=standard>";
echo "<tr><th colspan=2>$pcmake</th></tr>";

$allassetinfofields = array();

$rs_allfindassets = "SELECT * FROM mainassetinfofields WHERE showonclaim = '1'";
$rs_result2all = mysqli_query($rs_connect, $rs_allfindassets);
while ($rs_result_q2all = mysqli_fetch_object($rs_result2all)) {
$mainassetfieldid = "$rs_result_q2all->mainassetfieldid";
$mainassetfieldname = "$rs_result_q2all->mainassetfieldname";
$allassetinfofields[$mainassetfieldid] = "$mainassetfieldname";
}

foreach($custompcinfoindb as $key => $val) {
if(array_key_exists("$key", $allassetinfofields)) {
echo "<tr><td>$allassetinfofields[$key]: </td><td>$val</td></tr>";
}
}


echo "</table>";

echo "</td></tr></table>";

$rs_asql = "SELECT * FROM attachments WHERE pcid = '$pcid'";
$rs_result1asql = mysqli_query($rs_connect, $rs_asql);
$total_attachments = mysqli_num_rows($rs_result1asql);

if ($total_attachments > 0) {
echo "<br><br><table class=standard><tr><th>".pcrtlang("Asset/Device Attachments")."</th></tr>";
echo "<tr><td>";
while($rs_result_asql1 = mysqli_fetch_object($rs_result1asql)) {
$attach_id = "$rs_result_asql1->attach_id";
$attach_title = "$rs_result_asql1->attach_title";
$attach_size = "$rs_result_asql1->attach_size";
$attach_filename = "$rs_result_asql1->attach_filename";
$fileextpc = mb_strtolower(mb_substr(mb_strrchr($attach_filename, "."), 1));

if($attach_size == 0) {
$thebytes = "";
} else {
$thebytes = " - ".formatBytes($attach_size);
}

if(filter_var($attach_filename, FILTER_VALIDATE_URL)) {
	$fileextpc = 'url';
	$attach_link = "$attach_filename";
} else {
	$attach_link = "attachment.php?func=get&attach_id=$attach_id";
}

echo "<button type=button onClick=\"parent.location='$attach_link'\"><i class=\"fa fa-paperclip fa-lg\"></i> $attach_title</button>";

}
echo "</td></tr></table>";
}



echo "<h3>".pcrtlang("Work Orders")."</h3>";

$rs_find_wo = "SELECT * FROM pc_wo WHERE pcid = '$pcid' ORDER BY woid DESC";
$rs_result_itemw = mysqli_query($rs_connect, $rs_find_wo);

while($rs_result_item_qw = mysqli_fetch_object($rs_result_itemw)) {
$woid = "$rs_result_item_qw->woid";
$dropdate = "$rs_result_item_qw->dropdate";
$pcstatus = "$rs_result_item_qw->pcstatus";
$dropdate2 = date("F j, Y", strtotime($dropdate));
$probdesc = "$rs_result_item_qw->probdesc";
$cobyuser = "$rs_result_item_qw->cobyuser";
$cibyuser = "$rs_result_item_qw->cibyuser";

$theprobsindb = serializedarraytest("$rs_result_item_qw->commonproblems");

echo "<div data-role=\"collapsible\" data-theme=\"b\">";
echo "<h3>".pcrtlang("WO")." #$woid: $dropdate2</h3>";

echo "$probdesc<br>";

foreach($theprobsindb as $key => $val) {
echo "&bull; $val<br>";
}

if ($cibyuser != "") {
echo "<br>".pcrtlang("Checked In By").": $cibyuser<br>";
}

if ($pcstatus == 5) {
echo pcrtlang("Status").": ".pcrtlang("Picked Up on")." $dropdate2<br>";
if ($cobyuser != "") {
echo pcrtlang("Checked Out by").": $cobyuser<br>";
}
} else {
echo pcrtlang("Status").": ".pcrtlang("Not Yet Picked Up")."<br>";
}
echo "<button type=button onClick=\"parent.location='pc.php?func=view&woid=$woid'\"><i class=\"fa fa-eye fa-lg\"></i> ".pcrtlang("View this Work Order")."</button>";
echo "<button type=button onClick=\"parent.location='index.php?pcwo=$woid'\"><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("Edit this Work Order")."</button>";
echo "<button type=button onClick=\"parent.location='pc.php?func=printit&woid=$woid&backto=showpc'\"><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Print Repair Report")."</button>";

########
echo "<br>";


echo "<table class=standard><tr><th>".pcrtlang("Notes for Customer").":&nbsp;($pcname)</th></tr>";

$rs_findnotes = "SELECT * FROM wonotes WHERE woid = '$woid' AND notetype = '0' ORDER BY notetime ASC";
$rs_result_n = mysqli_query($rs_connect, $rs_findnotes);
while($rs_result_qn = mysqli_fetch_object($rs_result_n)) {
$thenote = nl2br("$rs_result_qn->thenote");
$noteuser = "$rs_result_qn->noteuser";
$notetype = "$rs_result_qn->notetype";
$noteid = "$rs_result_qn->noteid";
$notetime2 = "$rs_result_qn->notetime";
$notetime =  date('g:ia n-j-Y', strtotime($notetime2));


echo "<tr><td><strong>$noteuser &bull; $notetime</strong>";
echo "<br>$thenote";
echo "<br><br></td></tr>";

}

echo "</table>";

echo "<br><br>";
#######tech notes

echo "<table class=standard><tr><th>".pcrtlang("Technician Only Notes/Billing Instructions").":&nbsp;($pcname)</th></tr>";

$rs_findnotes = "SELECT * FROM wonotes WHERE woid = '$woid' AND notetype = '1' ORDER BY notetime ASC";
$rs_result_n = mysqli_query($rs_connect, $rs_findnotes);
$bubblego = "first";
$usercomm = array();
while($rs_result_qn = mysqli_fetch_object($rs_result_n)) {
$thenote = nl2br("$rs_result_qn->thenote");
$noteuser = "$rs_result_qn->noteuser";
$noteid = "$rs_result_qn->noteid";
$notetype = "$rs_result_qn->notetype";
$notetime2 = "$rs_result_qn->notetime";
$notetime =  date('g:ia n-j-Y', strtotime($notetime2));

echo "<tr><td><strong>$noteuser &bull; $notetime</strong>";
echo "<br>$thenote";
echo "<br><br></td></tr>";

}

echo "</table>";


#######



echo "<br><br>";

echo "</div>";

}


}




} else {
#start of split
start_box();
echo "<form action=pc.php?func=showpc method=post><input type=text  name=pcid size=20 required=required value=\"$pcid\">";
echo "<button ><img src=images/search.png width=10> ".pcrtlang("Search Again")."</button></form>";
stop_box();
echo "<br>";
$rs_find_pc = "SELECT * FROM pc_owner WHERE pcname LIKE '%$pcid%' OR pccompany LIKE '%$pcid%' OR pcphone LIKE '%$pcid%' OR pcworkphone LIKE '%$pcid%' OR pccellphone LIKE '%$pcid%' OR pcemail LIKE '%$pcid%' OR pcaddress LIKE '%$pcid%' OR pcaddress2 LIKE '%$pcid%' OR pcextra LIKE '%$pcid%' OR pcmake LIKE '%$pcid%' OR pcnotes LIKE '%$pcid%'";
$rs_result_item = mysqli_query($rs_connect, $rs_find_pc);

echo "<table><tr><td width=48% style=\"vertical-align:top;\">";

start_blue_box(pcrtlang("Device/Asset Search Results"));

if (mysqli_num_rows($rs_result_item) == "0") {
echo "<br>".pcrtlang("No Items Found")."...<br><br>";
} else {
echo "<table>";
}



while($rs_result_item_q = mysqli_fetch_object($rs_result_item)) {
$pcname = "$rs_result_item_q->pcname";
$pccompany = "$rs_result_item_q->pccompany";
$pcid2 = "$rs_result_item_q->pcid";
$pcmake = "$rs_result_item_q->pcmake";

echo "<tr><td style=\"vertical-align:top\">".pcrtlang("PC")." $pcid2 </td><td>$pcname";
if("$pccompany" != "") {
echo "<br>$pccompany";
}
echo "<br>$pcmake<br><a href=pc.php?func=showpc&pcid=$pcid2>".pcrtlang("view")."</a><br><br></td></tr>";
}

if (mysqli_num_rows($rs_result_item) != "0") {
echo "</table>";
}

stop_blue_box();

echo "</td><td width=2%><td><td width=48% style=\"vertical-align:top;\">";

start_blue_box(pcrtlang("Group Search Results"));

$rs_findpc = "SELECT * FROM pc_group WHERE pcgroupname LIKE '%$pcid%' OR grpcompany LIKE '%$pcid%' OR grpphone LIKE '%$pcid%' OR grpcellphone LIKE '%$pcid%' OR grpworkphone LIKE '%$pcid%' OR grpemail LIKE '%$pcid%' OR grpaddress1 LIKE '%$pcid%' OR grpaddress2 LIKE '%$pcid%' OR grpnotes LIKE '%$pcid%'";
$rs_result = mysqli_query($rs_connect, $rs_findpc);

if (mysqli_num_rows($rs_result) == "0") {
echo "<br>".pcrtlang("No Groups Found")."...<br><br>";
}

while ($rs_result_q = mysqli_fetch_object($rs_result)) {
$pcgroupname = "$rs_result_q->pcgroupname";
$pcgroupid = "$rs_result_q->pcgroupid";

start_box_nested();

echo "<a href=group.php?func=viewgroup&pcgroupid=$pcgroupid class=boldlink>#$pcgroupid $pcgroupname</a><br><br><font class=text12b>".pcrtlang("Customer/PCs in this Group").":<br>";

$rs_findowner = "SELECT * FROM pc_owner WHERE pcgroupid = '$pcgroupid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
while($rs_result_q2 = mysqli_fetch_object($rs_result2)) {
$pcid3 = "$rs_result_q2->pcid";
$pcname3 = "$rs_result_q2->pcname";
$pccompany3 = "$rs_result_q2->pccompany";
$pcmake3 = "$rs_result_q2->pcmake";

echo "<a href=pc.php?func=showpc&pcid=$pcid3>".pcrtlang("PC")."#$pcid3</a> | $pcname3 ";
if("$pccompany3" != "") {
echo "| $pccompany3 ";
}
echo "| $pcmake3<br>";
}

stop_box();
echo "<br>";

}

stop_blue_box();

echo "</td><td width=2%></td></tr></table>";

}
                                                                                                                                               
require_once("footer.php");
                                                                                                                                               
}



function returnpc() {


require("dheader.php");
require("deps.php");


echo "<div data-role=\"header\" data-theme=\"b\"><h2>".pcrtlang("Check-in Asset/Device")."</h2></div>";
echo "<div class=\"ui-content\" role=\"main\">";



echo "<table style=\"width:100%\"><tr><td>";
echo "<span class=\"sizeme16 boldme\">Start Check-in</span><br><br>";

echo "<input type=text class=\"textbox\" style=\"width:200px;\" id=searchbox autofocus placeholder=\"Enter Customer Name\">";

echo "<div id=themain>";

echo "</div>";



echo "</td></tr><tr><td>";
echo "<span class=\"sizeme16 boldme\">Or Enter/Scan Asset Tag</span><br><br>";
echo "<form action=pc.php?func=returnpc2 method=post name=returnpc><input type=text class=textbox name=pcid size=20 required=required>
<input class=button type=submit value=\"".pcrtlang("GO")."\"></form>";


echo "</td></tr></table>";

?>
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
                                        $("div#themain").slideUp(200,function(){
                                        return false;
                                        });

                                }else{
                                        $('div#themain').load('pc.php?func=returnpcajax&search='+encodedinv).slideDown(200);
                                }
                        }, 500);
  });
});
</script>

<?php


require("dfooter.php");

}


function returnpcajax() {

require("deps.php");
require("common.php");

$search = $_REQUEST['search'];

echo "<table style=\"width:100%\"><tr><td style=\"width:100%;padding:10px;vertical-align:top\">";

$rs_find_pc = "SELECT * FROM pc_owner WHERE pcname LIKE '%$search%' OR pccompany LIKE '%$search%'  OR pcmake LIKE '%$search%' OR pcphone LIKE '%$search%'
OR pcworkphone LIKE '%$search%' OR pccellphone LIKE '%$search%' OR pcemail LIKE '%$search%' ORDER BY pcid DESC LIMIT 50";
$rs_result_item = mysqli_query($rs_connect, $rs_find_pc);




$search_ue = urlencode("$search");

echo "<a href=\"pc.php?func=addpc&pcname=$search_ue\" class=\"ui-btn ui-corner-all ui-shadow\">";
echo "<div><table style=\"width:100%;\">";
echo "<tr><td style=\"width:20%\"><i class=\"fa fa-plus fa-lg colormegreen\"></i>";
echo " ".pcrtlang("New Check-in").": $search";
echo "</td></tr>";
echo "</table></div></a>";



while($rs_result_item_q = mysqli_fetch_object($rs_result_item)) {
$pcname = "$rs_result_item_q->pcname";
$pccompany = "$rs_result_item_q->pccompany";
$pcid2 = "$rs_result_item_q->pcid";
$pcmake = "$rs_result_item_q->pcmake";

echo "<a href=\"pc.php?func=returnpc2&pcid=$pcid2\" class=\"ui-btn ui-corner-all ui-shadow\">";
echo "<div>";
echo "<i class=\"fa fa-tag fa-lg\"></i> $pcid2";
echo "<br> $pcname";
if("$pccompany" != "") {
echo "<br>$pccompany";
}
echo "<br>$pcmake";
echo "</div></a>";
}


echo "</td></tr><tr><td style=\"width:100%;padding:10px;vertical-align:top;\">";

$rs_findpc = "SELECT * FROM pc_group WHERE pcgroupname LIKE '%$search%' OR grpcompany LIKE '%$search%' OR grpphone LIKE '%$search%' OR grpcellphone LIKE '%$search%'
OR grpworkphone LIKE '%$search%' OR grpemail LIKE '%$search%' ORDER BY pcgroupid DESC LIMIT 50";
$rs_result = mysqli_query($rs_connect, $rs_findpc);

if (mysqli_num_rows($rs_result) == "0") {
echo "<br><span \"class=colormegray italme\">".pcrtlang("No Groups Found")."...<br><br></span>";
}

while ($rs_result_q = mysqli_fetch_object($rs_result)) {
$pcgroupname = "$rs_result_q->pcgroupname";
$pcgroupid = "$rs_result_q->pcgroupid";
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
$grpcustsourceid = "$rs_result_q->grpcustsourceid";
$grpprefcontact = "$rs_result_q->grpprefcontact";

$ue_pcgroupname = urlencode($pcgroupname);
$ue_grpcompany = urlencode($grpcompany);
$ue_grpphone = urlencode($grpphone);
$ue_grpcellphone = urlencode($grpcellphone);
$ue_grpworkphone = urlencode($grpworkphone);
$ue_grpaddress = urlencode($grpaddress);
$ue_grpaddress2 = urlencode($grpaddress2);
$ue_grpcity = urlencode($grpcity);
$ue_grpstate = urlencode($grpstate);
$ue_grpzip = urlencode($grpzip);
$ue_grpemail = urlencode($grpemail);
$ue_grpcustsourceid = urlencode($grpcustsourceid);
$ue_grpprefcontact = urlencode($grpprefcontact);

echo "<table style=\"background:#fcfcfc; width:100%\"><tr><td>";

echo "<button type=button onClick=\"parent.location='group.php?func=viewgroup&pcgroupid=$pcgroupid'\" data-theme=\"b\"><i class=\"fa fa-group\"></i> $pcgroupname";

if("$grpcompany" != "") {
echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$grpcompany";
}

echo "</button><br>";


echo "<a href=\"pc.php?func=addpc&pcname=$ue_pcgroupname&pccompany=$ue_grpcompany&pcphone=$ue_grpphone&pccellphone=$ue_grpcellphone&pcworkphone=$ue_grpworkphone
&pcemail=$ue_grpemail&pcaddress=$ue_grpaddress&pcaddress2=$ue_grpaddress2&pccity=$ue_grpcity&pcstate=$ue_grpstate&pczip=$ue_grpzip&prefcontact=
$ue_grpprefcontact&pcgroupid=$pcgroupid&custsourceid=$ue_grpcustsourceid\" class=\"ui-btn ui-corner-all ui-shadow\">";
echo "<div><table style=\"width:100%;\">";
echo "<tr><td style=\"width:20%\"><i class=\"fa fa-plus fa-2x\"></i>";
echo "</td><td><span class=\"boldme sizeme16\"> ".pcrtlang("Check-in New Asset/Device to Group")."</span>";
echo "</td></tr>";
echo "</table></div></a>";

$rs_findowner = "SELECT * FROM pc_owner WHERE pcgroupid = '$pcgroupid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);

while($rs_result_q2 = mysqli_fetch_object($rs_result2)) {
$pcid3 = "$rs_result_q2->pcid";
$pcname3 = "$rs_result_q2->pcname";
$pccompany3 = "$rs_result_q2->pccompany";
$pcmake3 = "$rs_result_q2->pcmake";

echo "<a href=\"pc.php?func=returnpc2&pcid=$pcid3\" class=\"ui-btn ui-corner-all ui-shadow\">";
echo "<div>";
echo "<i class=\"fa fa-tag fa-lg\"></i> $pcid3";
echo "<br>$pcname3";
if("$pccompany3" != "") {
echo "<br>$pccompany3";
}
echo "<br>$pcmake3</td></tr>";
echo "</div></a>";

}

echo "</td></tr></table>";

}



echo "</td></tr></table>";
?>
<script>
$('#themain').enhanceWithin('create');
</script>
<?php

}




function returnpcold() {

require("dheader.php");
require("deps.php");


echo "<div data-role=\"header\" data-theme=\"b\"><h2>".pcrtlang("Returning Asset/Device")."</h2></div>";
echo "<div class=\"ui-content\" role=\"main\">";

echo pcrtlang("Enter Asset ID Number or Scan Asset Tag").":<form action=pc.php?func=returnpc2 method=post name=returnpc data-ajax=\"false\"><input autofocus type=number name=pcid required=required><input  type=submit value=\"".pcrtlang("GO")."\"></form>";                  

#echo "<br><br>".pcrtlang("Or Search for Customer Asset/Device or Group").":<br>";
#echo "<form action=pc.php?func=showpc method=post><input type=text  name=pcid size=20 required=required><input type=submit value=\"".pcrtlang("Search")."\" >";
#echo "</form>";

echo "</div>";

                                                                                                             
require("dfooter.php");
                                                                                                                                               
}


function returnpc2() {
require("dheader.php");
require("deps.php");


$pcid = $_REQUEST['pcid'];


echo "<div data-role=\"header\" data-theme=\"b\"><h2>".pcrtlang("Return Asset/Device")."</h2></div>";
echo "<div class=\"ui-content\" role=\"main\">";





$rs_find_pc = "SELECT * FROM pc_owner WHERE pcid = '$pcid'";
$rs_result_item = mysqli_query($rs_connect, $rs_find_pc);

if (mysqli_num_rows($rs_result_item) == "0") {
echo pcrtlang("Sorry, pcid $pcid does not exist");
}


while($rs_result_item_q = mysqli_fetch_object($rs_result_item)) {
$pcname = pf("$rs_result_item_q->pcname");
$pccompany = pf("$rs_result_item_q->pccompany");
$pcphone = "$rs_result_item_q->pcphone";
$pccellphone = "$rs_result_item_q->pccellphone";
$pcworkphone = "$rs_result_item_q->pcworkphone";
$pcmake = pf("$rs_result_item_q->pcmake");
$pcemail = "$rs_result_item_q->pcemail";
$pcaddress = "$rs_result_item_q->pcaddress";
$pcaddress2 = "$rs_result_item_q->pcaddress2";
$pccity = "$rs_result_item_q->pccity";
$pcstate = "$rs_result_item_q->pcstate";
$pczip = "$rs_result_item_q->pczip";
$custompcinfoindb = serializedarraytest("$rs_result_item_q->pcextra");
$prefcontact = "$rs_result_item_q->prefcontact";
$pcnotes = "$rs_result_item_q->pcnotes";
$mainassettypeid = "$rs_result_item_q->mainassettypeid";

if (array_key_exists("sreq_id",$_REQUEST)) {
$sreq_id = $_REQUEST['sreq_id'];
} else {
$sreq_id = 0;
}



$mergelabel = pcrtlang("Submitted").":";

echo "<form action=pc.php?func=returnpc3 method=post data-ajax=\"false\">";
echo pcrtlang("Customer Name").":</td><td><input size=25 type=text value=\"$pcname\" id=custname name=custname  required=required onFocus=\"this.form.submitbutton.disabled=false;this.form.submitbutton.value='".pcrtlang("Check in Asset/Device")."';\">";

if (array_key_exists("merge_custname",$_REQUEST)) {
$merge_custname = $_REQUEST['merge_custname'];
if (("$merge_custname" != "") && ("$merge_custname" != "$pcname")) {
echo "<select data-native-menu=\"false\" onchange='document.getElementById(\"custname\").value=this.options[this.selectedIndex].value'>";
echo "<option value=\"$pcname\">".pcrtlang("Original").": $pcname</option>";
echo "<option value=\"$merge_custname\">$mergelabel $merge_custname</option></select>";
}
}

echo pcrtlang("Company").":<input type=text id=company value=\"$pccompany\" name=pccompany>";

if (array_key_exists("merge_custcompany",$_REQUEST)) {
$merge_company = $_REQUEST['merge_custcompany'];
if (("$merge_company" != "") && ("$merge_company" != "$pccompany")) {
echo "<select data-native-menu=\"false\" onchange='document.getElementById(\"company\").value=this.options[this.selectedIndex].value'>";
echo "<option value=\"$pccompany\">".pcrtlang("Original").": $pccompany</option>";
echo "<option value=\"$merge_company\">$mergelabel $merge_company</option></select>";
}
}


echo pcrtlang("Customer Phone").":<input type=text value=\"$pcphone\" id=custphone name=custphone>";

if (array_key_exists("merge_custphone",$_REQUEST)) {
$merge_custphone = $_REQUEST['merge_custphone'];
if (("$merge_custphone" != "") && ("$merge_custphone" != "$pcphone")) {
echo "<select data-native-menu=\"false\" onchange='document.getElementById(\"custphone\").value=this.options[this.selectedIndex].value'>";
echo "<option value=\"$pcphone\">".pcrtlang("Original").": $pcphone</option>";
echo "<option value=\"$merge_custphone\">$mergelabel $merge_custphone</option></select>";
}
}


echo pcrtlang("Customer Mobile Phone").":<input type=text value=\"$pccellphone\" id=custcellphone name=custcellphone>";

if (array_key_exists("merge_custcellphone",$_REQUEST)) {
$merge_custcellphone = $_REQUEST['merge_custcellphone'];
if (("$merge_custcellphone" != "") && ("$merge_custcellphone" != "$pccellphone")) {
echo "<select data-native-menu=\"false\" onchange='document.getElementById(\"custcellphone\").value=this.options[this.selectedIndex].value'>";
echo "<option value=\"$pccellphone\">".pcrtlang("Original").": $pccellphone</option>";
echo "<option value=\"$merge_custcellphone\">$mergelabel $merge_custcellphone</option></select>";
}
}


echo pcrtlang("Customer Work Phone").":<input type=text value=\"$pcworkphone\" id=custworkphone name=custworkphone>";

if (array_key_exists("merge_custworkphone",$_REQUEST)) {
$merge_custworkphone = $_REQUEST['merge_custworkphone'];
if (("$merge_custworkphone" != "") && ("$merge_custworkphone" != "$pcworkphone")) {
echo "<select data-native-menu=\"false\" onchange='document.getElementById(\"custworkphone\").value=this.options[this.selectedIndex].value'>";
echo "<option value=\"$pcworkphone\">".pcrtlang("Original").": $pcworkphone</option>";
echo "<option value=\"$merge_custworkphone\">$mergelabel $merge_custworkphone</option></select>";
}
}



echo pcrtlang("Preferred Contact Method").":";

echo "<fieldset data-role=\"controlgroup\">";
if(($prefcontact == "none") || ($prefcontact == "")) {
echo "<input checked type=radio id=none name=prefcontact value=\"none\"><label for=none>".pcrtlang("none")."</label>";
} else {
echo "<input type=radio id=none name=prefcontact value=\"none\"><label for=none>".pcrtlang("none")."</label>";
}

if($prefcontact == "home") {
echo "<input checked type=radio id=home name=prefcontact value=\"home\"><label for=home>".pcrtlang("Home Phone")."</label>";
} else {
echo "<input type=radio id=home name=prefcontact value=\"home\"><label for=home>".pcrtlang("Home Phone")."</label>";
}

if($prefcontact == "mobile") {
echo "<input checked type=radio id=mobile name=prefcontact value=\"mobile\"><label for=mobile>".pcrtlang("Mobile Phone")."</label>";
} else {
echo "<input type=radio id=mobile name=prefcontact value=\"mobile\"><label for=mobile>".pcrtlang("Mobile Phone")."</label>";
}

if($prefcontact == "work") {
echo "<input checked type=radio id=work name=prefcontact value=\"work\"><label for=work>".pcrtlang("Work Phone")."</label>";
} else {
echo "<input type=radio id=work name=prefcontact value=\"work\"><label for=work>".pcrtlang("Work Phone")."</label>";
}

if($prefcontact == "sms") {
echo "<input checked type=radio id=sms name=prefcontact value=\"sms\"><label for=sms>".pcrtlang("SMS")."</label>";
} else {
echo "<input type=radio id=sms name=prefcontact value=\"sms\"><label for=sms>".pcrtlang("SMS")."</label>";
}

if($prefcontact == "email") {
echo "<input checked type=radio id=email name=prefcontact value=\"email\"><label for=email>".pcrtlang("Email")."</label>";
} else {
echo "<input type=radio id=email name=prefcontact value=\"email\"><label for=email>".pcrtlang("Email")."</label>";
}

echo "</fieldset>";

echo pcrtlang("Priority").":";

echo "<fieldset data-role=\"controlgroup\">";
echo "<input checked type=radio id=\"Not Set\" name=pcpriority value=\"\"><label for=\"Not Set\">".pcrtlang("Not Set")."</label>";
foreach($pcpriority as $key => $val) {
$key2 = urlencode($key);
echo "<input type=radio id=\"$key\" name=pcpriority value=\"$key\"><label for=\"$key\">";
if($val != "") {
echo "<img src=../repair/images/$val align=absmiddle>";
}
echo "$key</label>";
}
echo "</fieldset>";




echo pcrtlang("Asset/Device Make/Model").":<input type=text value=\"$pcmake\" id=pcmake name=pcmake  onFocus=\"this.form.submitbutton.disabled=false;this.form.submitbutton.value='".pcrtlang("Check in Asset/Device")."';\"><input type=hidden name=pcid value=$pcid><input type=hidden name=sreq_id value=$sreq_id>";

if (array_key_exists("merge_pcmake",$_REQUEST)) {
$merge_pcmake = $_REQUEST['merge_pcmake'];
if (("$merge_pcmake" != "") && ("$merge_pcmake" != "$pcmake")) {
echo "<select data-native-menu=\"false\" onchange='document.getElementById(\"pcmake\").value=this.options[this.selectedIndex].value'>";
echo "<option value=\"$pcmake\">".pcrtlang("Original").": $pcmake</option>";
echo "<option value=\"$merge_pcmake\">$mergelabel $merge_pcmake</option></select>";
}
}




echo pcrtlang("Asset/Device Type").":";

echo "<select name=assettype id=assettype data-native-menu=\"false\">";

$rs_findassettypes = "SELECT * FROM mainassettypes ORDER BY mainassetname ASC";
$rs_resultfat = mysqli_query($rs_connect, $rs_findassettypes);
while($rs_result_qfat = mysqli_fetch_object($rs_resultfat)) {
$mainassettypeidid = "$rs_result_qfat->mainassettypeid";
$mainassetname = "$rs_result_qfat->mainassetname";
$mainassetdefault = "$rs_result_qfat->mainassetdefault";
if($mainassettypeidid == "$mainassettypeid") {
echo "<option selected value=$mainassettypeidid>$mainassetname</option>";
$mainassettypedefaultid = $mainassettypeidid;
} else {
echo "<option value=$mainassettypeidid>$mainassetname</option>";
}
}


echo "</select>";




echo pcrtlang("Scheduled Job?").":";

echo "<fieldset data-role=\"controlgroup\">";
echo "<input type=radio checked name=sked value=no id=checkbox1><label for=\"checkbox1\">".pcrtlang("No")."</label>";
echo "<input type=radio name=sked value=yes id=checkbox2> <label for=\"checkbox2\">".pcrtlang("Yes")."</label>\n";
echo "</fieldset>";

$thedate = date("Y-m-d");
echo pcrtlang("Scheduled Date/Time").":";
echo "<input type=date  name=skedday value=\"$thedate\">";

picktime('timepick',"8:00 AM");


echo "<tr><td>".pcrtlang("Promised").":</td><td>";

echo "<select name=servicepromiseid>";
echo "<option selected value=0>".pcrtlang("Not Set")."</option>";
$rs_findpromises = "SELECT * FROM servicepromises ORDER BY theorder DESC";
$rs_resultsp = mysqli_query($rs_connect, $rs_findpromises);
while($rs_result_qsp = mysqli_fetch_object($rs_resultsp)) {
$servicepromiseid = "$rs_result_qsp->servicepromiseid";
$sptitle = "$rs_result_qsp->sptitle";
echo "<option value=$servicepromiseid>$sptitle</option>";
}
echo "</select></td></tr>";


echo pcrtlang("Notes").":<textarea name=pcnotes>$pcnotes</textarea>";

$varpass = "&assettype=$mainassettypedefaultid";

?>

<script type="text/javascript">
  $.get('pc.php?func=pullsubasset&assettype=<?php echo "$mainassettypeid"; ?>', function(data) {
    $('#subassets').html(data);
  });
</script>
<script type="text/javascript">

  $.get('pc.php?func=pullinfofieldsedit<?php echo "$varpass"; ?>&pcid=<?php echo "$pcid"; ?>', function(data) {
    $('#assetinfofields').html(data);
  });

</script>

<script type="text/javascript">
$('#assettype').change(function() {
    $('#subassets').load('pc.php?func=pullsubasset&', {assettype: $(this).val()});
});

</script>

<script type="text/javascript">

$('#assettype').change(function() {
    $('#assetinfofields').load('pc.php?func=pullinfofieldsedit&pcid=<?php echo "$pcid"; ?>', {assettype: $(this).val()});
});
</script>


<?php




echo pcrtlang("Asset/Device Accessories").":";
echo "<div id=\"subassets\" class=subassets></div>";



echo "<br>";
echo pcrtlang("Passwords").":<input type=text name=thepass>";

$rs_findnotes6 = "SELECT * FROM pc_wo WHERE pcid = '$pcid'";
$rs_result_n6 = mysqli_query($rs_connect, $rs_findnotes6);

echo pcrtlang("Previous Passwords").":<br>";

while($rs_result_qn6 = mysqli_fetch_object($rs_result_n6)) {
$thepass6 = "$rs_result_qn6->thepass";

if("$thepass6" != "") {
echo "<i class=\"fa fa-key\"></i>$thepass6<br>";
}
}

echo "<br>";


if (array_key_exists("merge_probdesc",$_REQUEST)) {
$prob_desc = $_REQUEST['merge_probdesc'];
} else {
$prob_desc = "";
}

echo pcrtlang("Description of Problem<br>Work to be Performed").":<textarea name=prob_desc>$prob_desc</textarea>";

#####


$comprobarray = array();
$rs_chkscans = "SELECT theproblem FROM commonproblems";
$rs_chkresult_s = mysqli_query($rs_connect, $rs_chkscans);
while($rs_chkresult_q_s = mysqli_fetch_object($rs_chkresult_s)) {
$theprob = "$rs_chkresult_q_s->theproblem";
array_push($comprobarray,"$theprob");
}

$comprobarrayv = array();
$rs_chkscansv = "SELECT theproblem FROM commonproblems WHERE custviewable = '1'";
$rs_chkresult_sv = mysqli_query($rs_connect, $rs_chkscansv);
while($rs_chkresult_q_sv = mysqli_fetch_object($rs_chkresult_sv)) {
$theprobv = "$rs_chkresult_q_sv->theproblem";
array_push($comprobarrayv,"$theprobv");
}


$totalprobs = count($comprobarray);

$totalprobsh = floor(($totalprobs / 2));

echo pcrtlang("Common Problems or Requests")."<br>".pcrtlang("Items in blue appear on customer printouts");

echo "<fieldset data-role=\"controlgroup\">";
foreach($comprobarray as $key => $val) {
if (in_array("$val",$comprobarrayv)) {
echo "<input type=checkbox name=\"theprobs[]\" id=\"$key\" value=\"$val\"> <label for=\"$key\"><font style=\"color:#0000ff;\">$val</font></label>";
} else {
echo "<input type=checkbox name=\"theprobs[]\" id=\"$key\" value=\"$val\"> <label for=\"$key\">$val</label>";
}
}
echo "</fieldset>";

#####



echo "<h3>".pcrtlang("Other Contact Info")."</h3>";
echo pcrtlang("Email Address").":<input type=text  id=pcemail name=pcemail value=\"$pcemail\">";

if (array_key_exists("merge_custemail",$_REQUEST)) {
$merge_custemail = $_REQUEST['merge_custemail'];
if (("$merge_custemail" != "") && ("$merge_custemail" != "$pcemail")) {
echo "<select data-native-menu=\"false\" onchange='document.getElementById(\"pcemail\").value=this.options[this.selectedIndex].value'>";
echo "<option value=\"$pcemail\">".pcrtlang("Original").": $pcemail</option>";
echo "<option value=\"$merge_custemail\">$mergelabel $merge_custemail</option></select>";
}
}


echo "$pcrt_address1<input name=pcaddress id=pcaddress1 value=\"$pcaddress\">";

if (array_key_exists("merge_custaddress1",$_REQUEST)) {
$merge_custaddress1 = $_REQUEST['merge_custaddress1'];
if (("$merge_custaddress1" != "") && ("$merge_custaddress1" != "$pcaddress")) {
echo "<select data-native-menu=\"false\" onchange='document.getElementById(\"pcaddress1\").value=this.options[this.selectedIndex].value'>";
echo "<option value=\"$pcaddress\">".pcrtlang("Original").": $pcaddress</option>";
echo "<option value=\"$merge_custaddress1\">$mergelabel $merge_custaddress1</option></select>";
}
}

echo "$pcrt_address2<input type=text  id=pcaddress2 name=pcaddress2 value=\"$pcaddress2\">";

if (array_key_exists("merge_custaddress2",$_REQUEST)) {
$merge_custaddress2 = $_REQUEST['merge_custaddress2'];
if (("$merge_custaddress2" != "") && ("$merge_custaddress2" != "$pcaddress2")) {
echo "<select data-native-menu=\"false\" onchange='document.getElementById(\"pcaddress2\").value=this.options[this.selectedIndex].value'>";
echo "<option value=\"$pcaddress2\">".pcrtlang("Original").": $pcaddress2</option>";
echo "<option value=\"$merge_custaddress2\">$mergelabel $merge_custaddress2</option></select>";
}
}

echo "$pcrt_city<input type=text id=pccity name=pccity value=\"$pccity\">";

if (array_key_exists("merge_custcity",$_REQUEST)) {
$merge_custcity = $_REQUEST['merge_custcity'];
if (("$merge_custcity" != "") && ("$merge_custcity" != "$pccity")) {
echo "<select data-native-menu=\"false\" onchange='document.getElementById(\"pccity\").value=this.options[this.selectedIndex].value'>";
echo "<option value=\"$pccity\">".pcrtlang("Original").": $pccity</option>";
echo "<option value=\"$merge_custcity\">$mergelabel $merge_custcity</option></select>";
}
}

echo "$pcrt_state<input type=text id=pcstate name=pcstate value=\"$pcstate\">";

if (array_key_exists("merge_custstate",$_REQUEST)) {
$merge_custstate = $_REQUEST['merge_custstate'];
if (("$merge_custstate" != "") && ("$merge_custstate" != "$pcstate")) {
echo "<select data-native-menu=\"false\" class=selectwarning onchange='document.getElementById(\"pcstate\").value=this.options[this.selectedIndex].value'>";
echo "<option value=\"$pcstate\">".pcrtlang("Original").": $pcstate</option>";
echo "<option value=\"$merge_custstate\">$mergelabel $merge_custstate</option></select>";
}
}

echo "$pcrt_zip<input type=text  id=pczip name=pczip value=\"$pczip\">";

if (array_key_exists("merge_custzip",$_REQUEST)) {
$merge_custzip = $_REQUEST['merge_custzip'];
if (("$merge_custzip" != "") && ("$merge_custzip" != "$pczip")) {
echo "<select  data-native-menu=\"false\" onchange='document.getElementById(\"pczip\").value=this.options[this.selectedIndex].value'>";
echo "<option value=\"$pczip\">".pcrtlang("Original").": $pczip</option>";
echo "<option value=\"$merge_custzip\">$mergelabel $merge_custzip</option></select>";
}
}



echo "<div id=\"assetinfofields\" class=assetinfofields></div>";


echo pcrtlang("Assign to User").":";
if ($ipofpc == "admin")	{
$rs_find_users = "SELECT * FROM users";
} else {
$rs_find_users = "SELECT * FROM users WHERE username != 'admin'";
}
$rs_result_users = mysqli_query($rs_connect, $rs_find_users);
echo "<select name=uname data-native-menu=\"false\">";
echo "<option value=\"\">".pcrtlang("Assigned User")."?</option>";
echo "<option value=\"\" selected>".pcrtlang("No Assigned User")."</option>";
while($rs_result_uq = mysqli_fetch_object($rs_result_users)) {
$rs_uname = "$rs_result_uq->username";

echo "<option value=$rs_uname>$rs_uname</option>";

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





echo "<input class=ibutton id=submitbutton type=submit value=\"".pcrtlang("Check in Asset/Device")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Checking In")."...'; this.form.submit();\" data-theme=\"b\"></form>";

}

echo "</div>";
require_once("dfooter.php");

}



function returnpc3() {
require_once("validate.php");
require("deps.php");
require("common.php");

$custname = pv($_REQUEST['custname']);
$pccompany = pv($_REQUEST['pccompany']);
$custphone = pv($_REQUEST['custphone']);
$custcellphone = pv($_REQUEST['custcellphone']);
$custworkphone = pv($_REQUEST['custworkphone']);
$pcmake = pv($_REQUEST['pcmake']);
$prob_desc = pv($_REQUEST['prob_desc']);
$pcid = $_REQUEST['pcid'];
$thepass = pv($_REQUEST['thepass']);
$assets = $_REQUEST["assets"];
$skedday = $_REQUEST['skedday'];
$sked_opt = $_REQUEST['sked'];
$servicepromiseid = $_REQUEST['servicepromiseid'];

if($sked_opt == "yes") {
$sked = 1;
$sked_datetime = date('Y-m-d H:i:s', strtotime("$skedday $_REQUEST[timepick]"));
} else {
$sked = 0;
$sked_datetime = "0000-00-00 00:00:00";
}



if (array_key_exists('theprobs',$_REQUEST)) {
$theprobs = $_REQUEST["theprobs"];
} else {
$theprobs = array();
}

if (array_key_exists('sreq_id',$_REQUEST)) {
$sreq_id = $_REQUEST["sreq_id"];
} else {
$sreq_id = 0;
}


$pcemail = pv($_REQUEST['pcemail']);
$pcaddress = pv($_REQUEST['pcaddress']);
$pcaddress2 = pv($_REQUEST['pcaddress2']);
$pccity = pv($_REQUEST['pccity']);
$pcstate = pv($_REQUEST['pcstate']);
$pczip = pv($_REQUEST['pczip']);
$pcextra2 = $_REQUEST['custompcinfo'];
$prefcontact = $_REQUEST['prefcontact'];
$pcpriority = pv($_REQUEST['pcpriority']);
$uname = pv($_REQUEST["uname"]);
$pcnotes = pv($_REQUEST['pcnotes']);
$assettype = pv($_REQUEST['assettype']);
$pcextra = pv(serialize($pcextra2));

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

if($servicepromiseid != 0) {
$rs_findpromises = "SELECT * FROM servicepromises WHERE servicepromiseid = '$servicepromiseid'";
$rs_resultsp = mysqli_query($rs_connect, $rs_findpromises);
$rs_result_qsp = mysqli_fetch_object($rs_resultsp);
$servicepromiseid = "$rs_result_qsp->servicepromiseid";
$sptitle = "$rs_result_qsp->sptitle";
$sptype = "$rs_result_qsp->sptype";
$sptime = "$rs_result_qsp->sptime";
$sptimeofday = "$rs_result_qsp->sptimeofday";

if($sked == 1) {
$datetimetouse = "$sked_datetime";
} else {
$datetimetouse = "$currentdatetime";
}


if($sptype == 1) {
$promisedtime = date('Y-m-d H:i:s', (strtotime($datetimetouse) + $sptime));
} else {
$promisedtime = date('Y-m-d'." $sptimeofday", (strtotime($datetimetouse) + $sptime));
}
} else {
$promisedtime = "0000-00-00 00:00:00";
}



$rs_insert_pc = "UPDATE pc_owner SET pcname = '$custname', pccompany = '$pccompany', pcphone = '$custphone', pccellphone = '$custcellphone', pcworkphone = '$custworkphone', pcmake = '$pcmake', pcemail = '$pcemail', pcaddress = '$pcaddress', pcaddress2 = '$pcaddress2', pccity = '$pccity', pcstate = '$pcstate', pczip = '$pczip', pcextra = '$pcextra', prefcontact = '$prefcontact', pcnotes = '$pcnotes', mainassettypeid = '$assettype' WHERE pcid = '$pcid'";
@mysqli_query($rs_connect, $rs_insert_pc);
$assets3 = array_filter($assets);
$assets2 = serialize($assets3);
$theprobs3 = array_filter($theprobs);
$theprobs2 = pv(serialize($theprobs3));
$rs_insert_wo = "INSERT INTO pc_wo (pcid,probdesc,dropdate,pcstatus,thepass,custassets,cibyuser,commonproblems,pcpriority,storeid,assigneduser,sked,skeddate,servicepromiseid,promisedtime) VALUES  ('$pcid','$prob_desc','$currentdatetime','1','$thepass','$assets2','$ipofpc','$theprobs2','$pcpriority','$defaultuserstore','$uname','$sked','$sked_datetime','$servicepromiseid','$promisedtime')";
@mysqli_query($rs_connect, $rs_insert_wo);

$lastinsert2 = mysqli_insert_id($rs_connect);

userlog(1,$lastinsert2,'woid','');

if($sreq_id != 0) {
$rs_close_req = "UPDATE servicerequests SET sreq_processed = '1' WHERE sreq_id = '$sreq_id'";
@mysqli_query($rs_connect, $rs_close_req);
}


if ($uname != "") {
if(array_key_exists('notifyusersms', $_REQUEST)) {
require_once("smsnotify.php");
$smsname  = $custname;
$usermobile = getusersmsnumber("$uname");
if($usermobile != "") {
smssend("$usermobile",pcrtlang("New Work Order Assignment")." - $custname - ".pcrtlang("Work Order")." #$lastinsert2");
}
}


if(array_key_exists('notifyuseremail', $_REQUEST)) {
require_once("sendenotify.php");
$from = getuseremail("$uname");
$to = $from;
if ($from != "") {
$subject = pcrtlang("New Work Order Assignment");
$plaintext ="$custname\n$pcaddress\n$pcaddress2\n$pccity, $pcstate $pczip\n\n".pcrtlang("Home Phone").":\t$custphone\n".pcrtlang("Cell Phone").":\t$custcellphone\n".pcrtlang("Work Phone").":\t$custworkphone";
$plaintext .= "\n\n".pcrtlang("Email").": $pcemail\n\n".pcrtlang("Device").": $pcmake\n\n".pcrtlang("Problem").":\n$prob_desc\n".pcrtlang("Work Order")." #$lastinsert2\n";
$sreq_problem2 = nl2br($_REQUEST['prob_desc']);
$htmltext ="<b>$custname</b><br>$pcaddress<br>$pcaddress2<br>$pccity, $pcstate $pczip<br><br><b>".pcrtlang("Home Phone").":</b>$custphone<br><b>".pcrtlang("Cell_Phone").":</b>$custcellphone<br><b>".pcrtlang("Work Phone").":</b>$custworkphone";
$htmltext .= "<br><br><b>Email</b>:$pcemail<br><br><b>Device:</b> $pcmake<br><br><b>Problem:</b><br>$sreq_problem2<br><br><b>Work Order</b> #$lastinsert2<br><br>";
sendenotify("$from","$to","$subject","$plaintext","$htmltext");
}
}
}

header("Location: pc.php?func=printclaimticket&woid=$lastinsert2");

}

function editowner() {
require_once("common.php");

require("deps.php");
require_once("validate.php");
require("dheader.php");


if (array_key_exists("attach_filename", $_REQUEST)) {
$attach_filename = $_REQUEST['attach_filename'];
require("d7spec.php");
$specarray = pullspec("$attach_filename");
if(count($specarray) == 0) {
$specnotice = pcrtlang("Sorry, machine specs were not found in this d7 report.");
}
}

if (array_key_exists("attach_filenameuvk", $_REQUEST)) {
$attach_filename = $_REQUEST['attach_filenameuvk'];
require("uvkspec.php");
$specarray = pullspec("$attach_filename");
if(count($specarray) == 0) {
$specnotice = pcrtlang("Sorry, machine specs were not found in this UVK report.");
}
}


$pcid = $_REQUEST['pcid'];
$woid = $_REQUEST['woid'];

echo "<div data-role=\"header\" data-theme=\"b\"><h2>".pcrtlang("Edit Owner")."</h2></div>";
echo "<div class=\"ui-content\" role=\"main\">";

if(isset($specnotice)) {
echo "$specnotice";
}






$rs_find_pc = "SELECT * FROM pc_owner WHERE pcid = '$pcid'";
$rs_result_item = mysqli_query($rs_connect, $rs_find_pc);

while($rs_result_item_q = mysqli_fetch_object($rs_result_item)) {
$pcname = pf("$rs_result_item_q->pcname");
$pccompany = pf("$rs_result_item_q->pccompany");
$pcphone = pf("$rs_result_item_q->pcphone");
$pccellphone = pf("$rs_result_item_q->pccellphone");
$pcworkphone = pf("$rs_result_item_q->pcworkphone");


if(isset($specarray)) {
if (array_key_exists("model", $specarray)) {
$pcmake = $specarray['model'];
} else {
$pcmake = pf("$rs_result_item_q->pcmake");
}
} else {
$pcmake = pf("$rs_result_item_q->pcmake");
}

$assettype = "$rs_result_item_q->mainassettypeid";

$pcemail = "$rs_result_item_q->pcemail";
$pcaddress = pf("$rs_result_item_q->pcaddress");
$pcaddress2 = pf("$rs_result_item_q->pcaddress2");
$pccity = pf("$rs_result_item_q->pccity");
$pcstate = pf("$rs_result_item_q->pcstate");
$pczip = pf("$rs_result_item_q->pczip");

$custompcinfoindb = serializedarraytest("$rs_result_item_q->pcextra");
$custsourceidindb = "$rs_result_item_q->custsourceid";
$prefcontact = "$rs_result_item_q->prefcontact";
$pcnotes = "$rs_result_item_q->pcnotes";


echo "<form action=pc.php?func=editowner2 method=post data-ajax=\"false\">";
echo pcrtlang("Customer Name").":<input type=text value=\"$pcname\" name=custname>";
echo pcrtlang("Company").":<input type=text value=\"$pccompany\" name=pccompany>";
echo pcrtlang("Customer Phone").":<input type=text value=\"$pcphone\" name=custphone>";
echo pcrtlang("Customer Mobile Phone").":<input type=text value=\"$pccellphone\" name=custcellphone>";
echo pcrtlang("Customer Work Phone").":<input type=text value=\"$pcworkphone\" name=custworkphone>";

echo pcrtlang("Preferred Contact Method").":";

echo "<fieldset data-role=\"controlgroup\">";

if(($prefcontact == "none") || ($prefcontact == "")) {
echo "<input checked type=radio id=none name=prefcontact value=\"none\"><label for=none>".pcrtlang("none")."</label>";
} else {
echo "<input type=radio id=none name=prefcontact value=\"none\"><label for=none>".pcrtlang("none")."</label>";
}

if($prefcontact == "home") {
echo "<input checked type=radio id=home name=prefcontact value=\"home\"><label for=home>".pcrtlang("Home Phone")."</label>";
} else {
echo "<input type=radio id=home name=prefcontact value=\"home\"><label for=home>".pcrtlang("Home Phone")."</label>";
}

if($prefcontact == "mobile") {
echo "<input checked type=radio id=mobile name=prefcontact value=\"mobile\"><label for=mobile>".pcrtlang("Mobile Phone")."</label>";
} else {
echo "<input type=radio id=mobile name=prefcontact value=\"mobile\"><label for=mobile>".pcrtlang("Mobile Phone")."</label>";
}

if($prefcontact == "work") {
echo "<input checked type=radio id=work name=prefcontact value=\"work\"><label for=work>".pcrtlang("Work Phone")."</label>";
} else {
echo "<input type=radio id=work name=prefcontact value=\"work\"><label for=work>".pcrtlang("Work Phone")."</label>";
}

if($prefcontact == "sms") {
echo "<input checked type=radio id=sms name=prefcontact value=\"sms\"><label for=sms>SMS</label>";
} else {
echo "<input type=radio id=sms name=prefcontact value=\"sms\"><label for=sms>SMS</label>";
}

if($prefcontact == "email") {
echo "<input checked type=radio id=email name=prefcontact value=\"email\"><label for=email>".pcrtlang("Email")."</label>";
} else {
echo "<input type=radio id=email name=prefcontact value=\"email\"><label for=email>".pcrtlang("Email")."</label>";
}

echo "</fieldset>";

echo "<input type=hidden name=woid value=$woid>";
echo pcrtlang("Asset/Device Make/Model").":<input type=text value=\"$pcmake\" name=pcmake ><input type=hidden name=pcid value=$pcid>";


echo pcrtlang("Asset/Device Type").":";
echo "<select name=assettype id=assettype data-native-menu=\"false\">";

$rs_findassettypes = "SELECT * FROM mainassettypes ORDER BY mainassetname ASC";
$rs_resultfat = mysqli_query($rs_connect, $rs_findassettypes);
while($rs_result_qfat = mysqli_fetch_object($rs_resultfat)) {
$mainassettypeidid = "$rs_result_qfat->mainassettypeid";
$mainassetname = "$rs_result_qfat->mainassetname";
if($assettype == "$mainassettypeidid") {
echo "<option selected value=$mainassettypeidid>$mainassetname</option>";
$mainassettypedefaultid = $mainassettypeidid;
} else {
echo "<option value=$mainassettypeidid>$mainassetname</option>";
}
}


echo "</select>";


echo pcrtlang("Customer Source").":";

echo "<select name=custsourceid data-native-menu=\"false\">";

if ($custsourceidindb == "0") {
echo "<option value=0 selected>".pcrtlang("Not Set")."</option>";
} else {
echo "<option value=0>".pcrtlang("Not Set")."</option>";
}

$rs_findsource = "SELECT * FROM custsource WHERE sourceenabled != '0' ORDER BY thesource ASC";
$rs_resultcs = mysqli_query($rs_connect, $rs_findsource);
while($rs_result_qcs = mysqli_fetch_object($rs_resultcs)) {
$custsourceid = "$rs_result_qcs->custsourceid";
$thesource = "$rs_result_qcs->thesource";
$sourceicon = "$rs_result_qcs->sourceicon";
if ($custsourceidindb == "$custsourceid") {
echo "<option value=$custsourceid selected>$thesource</option>";
} else {
echo "<option value=$custsourceid>$thesource</option>";
}

}
echo "</select>";


echo pcrtlang("Notes").":<textarea name=pcnotes>$pcnotes</textarea>";


echo "<h3>".pcrtlang("Other Contact Info").":</h3>";
echo pcrtlang("Email Address").":<input type=text  name=pcemail value=\"$pcemail\">";

echo "$pcrt_address1<input type=text name=pcaddress value=\"$pcaddress\">";
echo "$pcrt_address2<input type=text name=pcaddress2 value=\"$pcaddress2\">";
echo "$pcrt_city<input type=text  name=pccity value=\"$pccity\">$pcrt_state<input type=text  name=pcstate value=\"$pcstate\">$pcrt_zip<input type=text name=pczip value=\"$pczip\">";




if (array_key_exists("attach_filename", $_REQUEST)) {
$attach_filename = $_REQUEST['attach_filename'];
$varpass = "&assettype=$mainassettypedefaultid&attach_filename=$attach_filename";
} elseif (array_key_exists("attach_filenameuvk", $_REQUEST)) {
$attach_filename = $_REQUEST['attach_filenameuvk'];
$varpass = "&assettype=$mainassettypedefaultid&attach_filenameuvk=$attach_filename";
} else {
$varpass = "&assettype=$mainassettypedefaultid";
}


?>
<script type="text/javascript">

  $.get('pc.php?func=pullinfofieldsedit<?php echo "$varpass"; ?>&pcid=<?php echo "$pcid"; ?>', function(data) {
    $('#assetinfofields').html(data);
  });

</script>

<script type="text/javascript">

$('#assettype').change(function() {
    $('#assetinfofields').load('pc.php?func=pullinfofieldsedit&pcid=<?php echo "$pcid"; ?>', {assettype: $(this).val()});
});
</script>

<?php
echo "<div id=\"assetinfofields\" class=assetinfofields></div>";


echo "<input type=submit data-theme=\"b\" value=\"".pcrtlang("Save")."\"></form>";

}

echo "</div>";
require("dfooter.php");

}


function editowner2() {
require_once("validate.php");
require("deps.php");
require("common.php");

$custname = pv($_REQUEST['custname']);
$pccompany = pv($_REQUEST['pccompany']);
$custphone = pv($_REQUEST['custphone']);
$custcellphone = pv($_REQUEST['custcellphone']);
$custworkphone = pv($_REQUEST['custworkphone']);
$pcmake = pv($_REQUEST['pcmake']);
$assettype = $_REQUEST['assettype'];
$pcid = $_REQUEST['pcid'];
$woid = $_REQUEST['woid'];

$pcemail = pv($_REQUEST['pcemail']);
$pcaddress = pv($_REQUEST['pcaddress']);
$pcaddress2 = pv($_REQUEST['pcaddress2']);
$pccity = pv($_REQUEST['pccity']);
$pcstate = pv($_REQUEST['pcstate']);
$pczip = pv($_REQUEST['pczip']);

$pcextra = $_REQUEST['custompcinfo'];
$custsourceid = $_REQUEST['custsourceid'];
$prefcontact = $_REQUEST['prefcontact'];
$pcnotes = pv($_REQUEST['pcnotes']);

$custompcinfoser = pv(serialize($pcextra));

if ($custname == "") { die(pcrtlang("Please go back and enter the customers name")); }




$rs_insert_pc = "UPDATE pc_owner SET pcname = '$custname', pccompany = '$pccompany', pcphone = '$custphone', pccellphone = '$custcellphone', pcworkphone = '$custworkphone', pcmake = '$pcmake', pcemail = '$pcemail', pcaddress = '$pcaddress', pcaddress2 = '$pcaddress2', pccity = '$pccity', pcstate = '$pcstate', pczip = '$pczip', pcextra = '$custompcinfoser', custsourceid = '$custsourceid', prefcontact = '$prefcontact', pcnotes = '$pcnotes', mainassettypeid = '$assettype' WHERE pcid = '$pcid'";
@mysqli_query($rs_connect, $rs_insert_pc);

if ($woid != 0) {
header("Location: index.php?pcwo=$woid");
} else {
header("Location: pc.php?func=showpc&pcid=$pcid");
}


}


function editproblem() {

require("deps.php");

require_once("common.php");

require("dheader.php");



$woid = $_REQUEST['woid'];
$custname = $_REQUEST['custname'];


echo "<div data-role=\"header\" data-theme=\"b\"><h2>".pcrtlang("Edit Work Order")."</h2></div>";
echo "<div class=\"ui-content\" role=\"main\">";






$rs_find_pc = "SELECT * FROM pc_wo WHERE woid = '$woid'";
$rs_result_item = mysqli_query($rs_connect, $rs_find_pc);

while($rs_result_item_q = mysqli_fetch_object($rs_result_item)) {
$pcprob = "$rs_result_item_q->probdesc";
$thepass = "$rs_result_item_q->thepass";
$theprobsindb = serializedarraytest("$rs_result_item_q->commonproblems");
$wostoreid = "$rs_result_item_q->storeid";
$uname = "$rs_result_item_q->assigneduser";
$pcid = "$rs_result_item_q->pcid";
$sked = "$rs_result_item_q->sked";
$skeddate = "$rs_result_item_q->skeddate";
$servicepromiseid = "$rs_result_item_q->servicepromiseid";
$dropdate = "$rs_result_item_q->dropdate";


$rs_find_pc = "SELECT * FROM pc_owner WHERE pcid = '$pcid'";
$rs_result_pc = mysqli_query($rs_connect, $rs_find_pc);
$rs_result_pc_q = mysqli_fetch_object($rs_result_pc);
$assettype = "$rs_result_pc_q->mainassettypeid";

	
echo "<form action=pc.php?func=editproblem2 method=post data-ajax=\"false\">";


echo "<tr><td>".pcrtlang("Promised").":</td><td>";
echo "<input name=dropdate value=\"$dropdate\" type=hidden>";
echo "<select name=servicepromiseid>";
echo "<option value=0>".pcrtlang("Not Set")."</option>";
$rs_findpromises = "SELECT * FROM servicepromises ORDER BY theorder DESC";
$rs_resultsp = mysqli_query($rs_connect, $rs_findpromises);
while($rs_result_qsp = mysqli_fetch_object($rs_resultsp)) {
$servicepromiseidindb = "$rs_result_qsp->servicepromiseid";
$sptitle = "$rs_result_qsp->sptitle";

if("$servicepromiseid" == "$servicepromiseidindb") {
echo "<option selected value=$servicepromiseidindb>$sptitle</option>";
} else {
echo "<option value=$servicepromiseidindb>$sptitle</option>";
}

}
echo "</select></td></tr>";

echo pcrtlang("Scheduled Job?").":";

echo "<fieldset data-role=\"controlgroup\">";
if($sked == 0) {
echo "<input type=radio checked name=sked value=no id=checkbox1>
<label for=\"checkbox1\">".pcrtlang("No")."</label><input type=radio name=sked value=yes id=checkbox2> <label for=\"checkbox2\">".pcrtlang("Yes")."</label>";
} else {
echo "<input type=radio name=sked value=no id=checkbox1>
<label for=\"checkbox1\">".pcrtlang("No")."</label><input checked type=radio name=sked value=yes id=checkbox2> <label for=\"checkbox2\">".pcrtlang("Yes")."</label>";
}
echo "</fieldset>";

if($skeddate != "0000-00-00 00:00:00") {
$thedate = date("Y-m-d", strtotime($skeddate));
$thetime = date("g:i A", strtotime($skeddate));
} else {
$thedate = date("Y-m-d");
$thetime = "8:00 AM";
}

echo pcrtlang("Scheduled Date/Time").":";
echo "<input type=date  name=skedday value=\"$thedate\">";

picktime('timepick',"$thetime");





?>
<script type="text/javascript">
  $.get('pc.php?func=pullsubassetedit&assettype=<?php echo "$assettype"; ?>&woid=<?php echo "$woid"; ?>', function(data) {
    $('#subassets').html(data);
  });
</script>

<?php
echo pcrtlang("Customer Items").":";
echo "<div id=\"subassets\" class=subassets></div>";


echo pcrtlang("Description of Problem<br>Work to be Performed").":<input type=hidden name=woid value=$woid><textarea name=problem>$pcprob</textarea>";


########

$comprobarray = array();
$rs_chkscans = "SELECT theproblem FROM commonproblems";
$rs_chkresult_s = mysqli_query($rs_connect, $rs_chkscans);
while($rs_chkresult_q_s = mysqli_fetch_object($rs_chkresult_s)) {
$theprob = "$rs_chkresult_q_s->theproblem";
array_push($comprobarray,"$theprob");
}

$comprobarrayv = array();
$rs_chkscansv = "SELECT theproblem FROM commonproblems WHERE custviewable = '1'";
$rs_chkresult_sv = mysqli_query($rs_connect, $rs_chkscansv);
while($rs_chkresult_q_sv = mysqli_fetch_object($rs_chkresult_sv)) {
$theprobv = "$rs_chkresult_q_sv->theproblem";
array_push($comprobarrayv,"$theprobv");
}


$comprobarraymerged = array_merge($comprobarray,$theprobsindb);

$comprobarraymergedunique = array_unique($comprobarraymerged);

$totalprobs = count($comprobarraymergedunique);

$totalprobsh = floor(($totalprobs / 2));

$thepstart = 0;

echo pcrtlang("Common Problems or Requests")."<br><i>".pcrtlang("Items in blue appear on customer printouts")."</i>";


echo "<fieldset data-role=\"controlgroup\">";

foreach($comprobarraymergedunique as $key => $val) {
if (in_array("$val",$comprobarrayv)) {
if(in_array("$val", $theprobsindb)) {
echo "<input type=checkbox name=\"theprobs[]\" id=\"$key\" value=\"$val\" checked> <label for=\"$key\"><font style=\"color:#0000ff\">$val</font></label>";
} else {
echo "<input type=checkbox name=\"theprobs[]\" id=\"$key\" value=\"$val\"> <label for=\"$key\"><font style=\"color:#0000ff\">$val</font></label>";
}
} else {
if(in_array("$val", $theprobsindb)) {
echo "<input type=checkbox name=\"theprobs[]\" id=\"$key\" value=\"$val\" checked> <label for=\"$key\">$val</label>";
} else {
echo "<input type=checkbox name=\"theprobs[]\" id=\"$key\" value=\"$val\"> <label for=\"$key\">$val</label>";
}
}


}

echo "</fieldset>";

if ($activestorecount > "1") {
echo pcrtlang("Assigned Store");

$rs_find_stores = "SELECT * FROM stores WHERE storeenabled = '1' ORDER BY storesname ASC";
$rs_result_stores = mysqli_query($rs_connect, $rs_find_stores);

echo "<select name=wostoreid>";

while($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
$rs_storesname = "$rs_result_storeq->storesname";
$rs_storeid = "$rs_result_storeq->storeid";

if ($rs_storeid == $wostoreid) {
echo "<option selected value=$rs_storeid>$rs_storesname</option>";
} else {
echo "<option value=$rs_storeid>$rs_storesname</option>";
}
}

echo "</select>";

} else {

echo "<input type=hidden name=wostoreid value=$wostoreid>";
}


######


echo pcrtlang("Assign to User").":";
$rs_find_users = "SELECT * FROM users";
$rs_result_users = mysqli_query($rs_connect, $rs_find_users);
echo "<select name=uname>";

if($uname == "") {
echo "<option selected value=\"\">".pcrtlang("No Assigned User")."</option>";
} else {
echo "<option value=\"\">".pcrtlang("No Assigned User")."</option>";
}

while($rs_result_uq = mysqli_fetch_object($rs_result_users)) {
$rs_uname = "$rs_result_uq->username";

if($rs_uname == "$uname") {
echo "<option selected value=$rs_uname selected>$rs_uname</option>";
} else {
if(("$rs_uname" != "admin") || ("$ipofpc" == "admin")) {
echo "<option value=$rs_uname>$rs_uname</option>";
}
}



}
echo "</select>";


echo "<input type=submit value=\"".pcrtlang("Save")."\" data-theme=\"b\"></form>";

}

echo "</div>";
require_once("dfooter.php");


}



function editproblem2() {
require_once("validate.php");
require("deps.php");
require("common.php");

$woid = $_REQUEST['woid'];
$wostoreid = $_REQUEST['wostoreid'];
$problem = pv($_REQUEST['problem']);
$assets = $_REQUEST['assets'];
$uname = pv($_REQUEST['uname']);

$skedday = $_REQUEST['skedday'];
$sked_opt = $_REQUEST['sked'];

$dropdate = $_REQUEST['dropdate'];
$servicepromiseid = $_REQUEST['servicepromiseid'];

if($sked_opt == "yes") {
$sked = 1;
$sked_datetime = date('Y-m-d H:i:s', strtotime("$skedday $_REQUEST[timepick]"));
} else {
$sked = 0;
$sked_datetime = "0000-00-00 00:00:00";
}


if (array_key_exists('theprobs',$_REQUEST)) {
$theprobs = $_REQUEST["theprobs"];
} else {
$theprobs = array();
}


if($assets != "") {
$assets3 = array_filter($assets);
$assets2 = pv(serialize($assets3));
} else {
$assets3 = array();
$assets2 = serialize($assets3);
}

if(is_array($theprobs)) {
$theprobs2 = pv(serialize($theprobs));
} else {
$theprobs3 = array();
$theprobs2 = serialize($theprobs3);
}


if($servicepromiseid != 0) {
$rs_findpromises = "SELECT * FROM servicepromises WHERE servicepromiseid = '$servicepromiseid'";
$rs_resultsp = mysqli_query($rs_connect, $rs_findpromises);
$rs_result_qsp = mysqli_fetch_object($rs_resultsp);
$sptitle = "$rs_result_qsp->sptitle";
$sptype = "$rs_result_qsp->sptype";
$sptime = "$rs_result_qsp->sptime";
$sptimeofday = "$rs_result_qsp->sptimeofday";

if($sked == 1) {
$datetimetouse = "$sked_datetime";
} else {
$datetimetouse = "$dropdate";
}


if($sptype == 1) {
$promisedtime = date('Y-m-d H:i:s', (strtotime($datetimetouse) + $sptime));
} else {
$promisedtime = date('Y-m-d'." $sptimeofday", (strtotime($datetimetouse) + $sptime));
}
} else {
$promisedtime = "0000-00-00 00:00:00";
}



$rs_insert_pc = "UPDATE pc_wo SET probdesc = '$problem', custassets = '$assets2', commonproblems = '$theprobs2', storeid = '$wostoreid', assigneduser = '$uname', sked = '$sked', skeddate = '$sked_datetime', servicepromiseid = '$servicepromiseid', promisedtime = '$promisedtime' WHERE woid = '$woid'";
@mysqli_query($rs_connect, $rs_insert_pc);

$syncwo = "UPDATE specialorders SET spostoreid = '$wostoreid' WHERE spowoid = '$woid'";
@mysqli_query($rs_connect, $syncwo);


header("Location: index.php?pcwo=$woid#workorderinfo");

}




function stats() {
require("header.php");
require("deps.php");
                                                                                                                                               
echo "<h3>".("Stats")."</h3>";
                                                                                                                                               


                                                                                                                                               
$rs_find_pc = "SELECT SUM(scannum) AS viruses FROM pc_scan";
$rs_result_item = mysqli_query($rs_connect, $rs_find_pc);
                                                                                                                                               
while($rs_result_item_q = mysqli_fetch_object($rs_result_item)) {
$viruses = "$rs_result_item_q->viruses";

echo pcrtlang("Total Viruses/Spyware Removed").": $viruses<br><br>";
}

echo "<h3>".pcrtlang("Devices worked on by make").":</h3><table>";
$makes = array('HP','Compaq','Dell','Sony','EMachine','Toshiba','Custom','Gateway','IBM','Micron','Packard Bell','NEC','Acer','Vizio','Lenovo','Apple','Microsoft','Samsung');
$thelist = array();
reset($makes);
foreach($makes as $key => $value) {
$rs_find_pc = "SELECT * FROM pc_owner WHERE pcmake LIKE '%$value%'";
$rs_result = mysqli_query($rs_connect, $rs_find_pc);
$total = mysqli_num_rows($rs_result);


if($total != 0) {
array_push($thelist, "$total </td><td> - $value");
}
}


array_multisort($thelist,SORT_NUMERIC,SORT_DESC);
reset($thelist);
foreach($thelist as $thekey => $value) {
echo "<tr><td>$value</td></tr>";
}


echo "</table>";
require_once("footer.php");
                                                                                                                                               
}


function movewo() {

require("dheader.php");
require("deps.php");

$woid = $_REQUEST['woid'];
$pcid = $_REQUEST['pcid'];


echo "<div data-role=\"header\" data-theme=\"b\"><h2>".pcrtlang("Move Work Order")."</h2></div>";
echo "<div class=\"ui-content\" role=\"main\">";

echo pcrtlang("Enter Asset/Customer ID Number").":<form action=pc.php?func=movewo2 method=post data-ajax=\"false\"><input type=hidden name=woid value=$woid><input type=hidden name=pcid value=$pcid><input type=text  name=npcid>";





$rs_foundwo = "SELECT * FROM pc_wo WHERE pcid = '$pcid'";
$rs_result_fs = mysqli_query($rs_connect, $rs_foundwo);

if (mysqli_num_rows($rs_result_fs) == 1) {
echo pcrtlang("This is the last remaining Work Order associated with this Asset/Customer ID Number")."....";
echo "<label><input type=checkbox name=rmpcid>".pcrtlang("Delete this Asset/Customer ID")."?</label>";
}


echo "<input type=submit value=\"".pcrtlang("Move")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Moving")."...'; this.form.submit();\"  data-theme=\"b\">";

echo "</div>";
require("dfooter.php");

}

function movewo2() {
require_once("validate.php");
require("deps.php");
require("common.php");

$woid = $_REQUEST['woid'];
$npcid = $_REQUEST['npcid'];
$rmpcid = $_REQUEST['rmpcid'];
$pcid = $_REQUEST['pcid'];

if ($npcid == "") {
die("Please go back and enter a number");
}




$rs_change_pc = "UPDATE pc_wo SET pcid = '$npcid' WHERE woid = '$woid'";
@mysqli_query($rs_connect, $rs_change_pc);



if ($rmpcid == "on") {
$rs_rm_pcid = "DELETE FROM pc_owner WHERE pcid = '$pcid'";
@mysqli_query($rs_connect, $rs_rm_pcid);
}


header("Location: index.php?pcwo=$woid#workorderinfo");

}


function precalled() {

require("deps.php");
require("common.php");

$woid = $_REQUEST['woid'];
$status = $_REQUEST['status'];

require("dheader.php");



echo "<div data-role=\"header\" data-theme=\"b\"><h2>".pcrtlang("Add Call Note")."</h2></div>";
echo "<div class=\"ui-content\" role=\"main\">";

echo "<form action=pc.php?func=called method=post data-ajax=\"false\"><input type=hidden name=woid value=$woid><input type=hidden name=status value=$status>";

echo pcrtlang("Note (optional)").":<textarea name=thenote></textarea>";

echo "<fieldset data-role=\"controlgroup\">";
echo "<input type=checkbox name=im id=im><label for=im> ".pcrtlang("Customer Viewable in Portal")."</label>";
echo "</fieldset>";

echo "<input type=submit value=\"".pcrtlang("Save/Continue")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Wait")."...'; this.form.submit();\" data-theme=\"b\"></form>";
echo "</div>";
require_once("dfooter.php");

}



function called() {
require_once("validate.php");
require("deps.php");
require("common.php");

$woid = $_REQUEST['woid'];
$status = $_REQUEST['status'];

if ($status == 1) {
$calledtext = pcrtlang("Not Called");
} elseif ($status == 2){
$calledtext = pcrtlang("Called");
} elseif  ($status == 3){
$calledtext = pcrtlang("Called - No Answer");
} elseif  ($status == 4) {
$calledtext = pcrtlang("Called - Waiting for Call Back");
} elseif  ($status == 5) {
$calledtext = pcrtlang("Sent SMS");
} elseif  ($status == 6) {
$calledtext = pcrtlang("Sent Email");
} else {
$calledtext = "";
}


if (array_key_exists('thenote',$_REQUEST)) {
$thenote = $_REQUEST['thenote'];
if ("$thenote" != "") {
$calledtext .= " - $thenote";
} else {
$calledtext .= " - ".pcrtlang("No message notes entered");
} 
}

$calledtext2 = pv("$calledtext");

userlog(11,$woid,'woid',"$calledtext");


if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

if (array_key_exists('im',$_REQUEST)) {
$rs_insert_message = "INSERT INTO messages (messagefrom,messagebody,messagedatetime,messagevia,woid,messagedirection) 
VALUES ('$ipofpc','$calledtext2','$currentdatetime','im','$woid','out')";
} else {
$rs_insert_message = "INSERT INTO messages (messagefrom,messagebody,messagedatetime,messagevia,woid,messagedirection)
VALUES ('$ipofpc','$calledtext2','$currentdatetime','call','$woid','out')";
}


@mysqli_query($rs_connect, $rs_insert_message);


$rs_change_pc = "UPDATE pc_wo SET called = '$status' WHERE woid = '$woid'";
@mysqli_query($rs_connect, $rs_change_pc);


header("Location: index.php?pcwo=$woid#workorderinfo");

}





function changewa() {
require_once("validate.php");
require("deps.php");
require("common.php");


$workarea = pv($_REQUEST['workarea']);
$woid = pv($_REQUEST['woid']);




$rs_change_pc = "UPDATE pc_wo SET workarea = '$workarea' WHERE woid = '$woid'";
@mysqli_query($rs_connect, $rs_change_pc);

header("Location: index.php?pcwo=$woid#workorderinfo");

}


function custominfocreate() {

$scanid = $_REQUEST['scanid'];
$scantypeid = $_REQUEST['scantypeid'];
$woid = $_REQUEST['woid'];
$alreadycustom = $_REQUEST['alreadycustom'];

require_once("common.php");
require("dheader.php");


require("deps.php");





if ($alreadycustom == "0") {
$rs_printinfo = "SELECT * FROM pc_scans WHERE scanid = '$scantypeid'";
} else {
$rs_printinfo = "SELECT * FROM pc_scan WHERE scanid = '$scanid'";
}

$rs_result_item = mysqli_query($rs_connect, $rs_printinfo);

while($rs_result_item_q = mysqli_fetch_object($rs_result_item)) {
if ($alreadycustom == "0") {
$printinfo2 = "$rs_result_item_q->printinfo";
} else {
$printinfo2 = "$rs_result_item_q->customprintinfo";
}

dheader(pcrtlang("Customize Info"));

echo "<form action=pc.php?func=custominfocreate2 method=post data-ajax=\"false\">";

$printinfo = htmlspecialchars($printinfo2);

echo pcrtlang("Printable Info").":";
echo "<textarea name=printinfo >$printinfo</textarea><input type=hidden name=scanid value=$scanid><input type=hidden name=woid value=$woid>";
echo "<button type=button onclick=\"this.disabled=true; this.form.submit();\" data-theme=\"b\"><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button>";


echo "</form>";

}

dfooter();
require_once("dfooter.php");



}


function custominfocreate2() {
require_once("validate.php");
require("deps.php");
require("common.php");

$scanid = $_REQUEST['scanid'];
$woid = $_REQUEST['woid'];
$printinfo = pv($_REQUEST['printinfo']);




$rs_insert = "UPDATE pc_scan SET customprintinfo = '$printinfo' WHERE scanid = '$scanid'";
@mysqli_query($rs_connect, $rs_insert);

header("Location: index.php?pcwo=$woid");

}


function custominforevert() {
require_once("validate.php");
require("deps.php");
require("common.php");

$scanid = $_REQUEST['scanid'];
$woid = $_REQUEST['woid'];




$rs_insert = "UPDATE pc_scan SET customprintinfo = '' WHERE scanid = '$scanid'";
@mysqli_query($rs_connect, $rs_insert);

header("Location: index.php?pcwo=$woid");

}


function addcustomscan() {

$scantype = $_REQUEST['scantype'];
$woid = $_REQUEST['woid'];

require("deps.php");
require_once("common.php");
require("dheader.php");


if ($scantype == "0") {
$boxtitle = pcrtlang("Add Custom Scan");
} elseif ($scantype == "1") {
$boxtitle = pcrtlang("Add Custom Action");
} elseif ($scantype == "2") {
$boxtitle = pcrtlang("Add Custom Install");
} elseif ($scantype == "3") {
$boxtitle = pcrtlang("Add Custom Note");
} else {
$boxtitle = "-";
}



echo "<div data-role=\"header\" data-theme=\"b\"><h2>$boxtitle</h2></div>";
echo "<div class=\"ui-content\" role=\"main\">";



echo "<form action=pc.php?func=addcustomscan2 method=post  data-ajax=\"false\">";
echo "<table>";

if ($scantype == '0') {
echo "<tr><td><font class=text12b>".pcrtlang("Items Found").":</td>";
echo "<td><input type=text size=10 name=thecount value=\"\" ></td></tr>";
}

echo "<tr><td>".pcrtlang("Technical Title").":</td>";
echo "<td><input type=hidden name=scantype value=$scantype ><input type=hidden name=woid value=$woid><input type=text size=35 name=custprogname value=\"\" ></td></tr>";
echo "<tr><td>".pcrtlang("Customer Viewable Title").":</td>";
echo "<td><input type=text size=35 name=custprogword value=\"\" ></td></tr>";
if ($scantype != '0') {
echo "<tr><td>".pcrtlang("Printable Info").":</td>";
echo "<td><textarea cols=60 rows=10 name=custprintinfo ></textarea><input type=hidden name=thecount value=\"\"></td></tr>";
} else {
echo "<input type=hidden name=printinfo value=\"\">";
}
echo "<tr><td><button class=ibutton type=button onclick=\"this.disabled=true; this.form.submit();\"><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button></td><td></td></tr>";


echo "</form></table>";

echo "</div>";
require("dfooter.php");

}


function addcustomscan2() {

require("deps.php");
require("common.php");

$custprogname = pv($_REQUEST['custprogname']);
$custprogword = pv($_REQUEST['custprogword']);

if (array_key_exists('custprintinfo', $_REQUEST)) {
$custprintinfo = pv($_REQUEST['custprintinfo']);
} else {
$custprintinfo = "";
}

$thecount = pv($_REQUEST['thecount']);
$scantype = $_REQUEST['scantype'];
$woid = $_REQUEST['woid'];

if(($custprogname == "") || ($custprogword == "")) {
die(pcrtlang("Error - you must fill out all fields."));
}

require_once("validate.php");

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');





$rs_insert_scan = "INSERT INTO pc_scan (woid,customprogname, customprogword, customprintinfo, customscantype, scannum, scantime, byuser) VALUES ('$woid','$custprogname','$custprogword','$custprintinfo','$scantype','$thecount','$currentdatetime','$ipofpc')";
@mysqli_query($rs_connect, $rs_insert_scan);

userlog(3,$woid,'woid','');

header("Location: index.php?pcwo=$woid#scans");

}


function editcustominfo() {

$scanid = $_REQUEST['scanid'];
$woid = $_REQUEST['woid'];

require("deps.php");

require("dheader.php");



$rs_foundscan = "SELECT * FROM pc_scan WHERE scanid = '$scanid'";
$rs_result_fs = mysqli_query($rs_connect, $rs_foundscan);
$rs_result_fsr = mysqli_fetch_object($rs_result_fs);
$scanid = "$rs_result_fsr->scanid";
$scannum = "$rs_result_fsr->scannum";
$customprogname = "$rs_result_fsr->customprogname";
$customprogword = "$rs_result_fsr->customprogword";
$customprintinfo2 = "$rs_result_fsr->customprintinfo";
$customscantype = "$rs_result_fsr->customscantype";


$customprintinfo = htmlspecialchars($customprintinfo2);

if ($customscantype == "0") {
$boxtitle = pcrtlang("Edit Custom Scan");
} elseif ($customscantype == "1") {
$boxtitle = pcrtlang("Edit Custom Action");
} elseif ($customscantype == "2") {
$boxtitle = pcrtlang("Edit Custom Install");
} elseif ($customscantype == "3") {
$boxtitle = pcrtlang("Edit Custom Note or Recommendation");
} else {
$boxtitle = "-";
}


echo "<div data-role=\"header\" data-theme=\"b\"><h2>$boxtitle</h2></div>";
echo "<div class=\"ui-content\" role=\"main\">";



echo "<form action=pc.php?func=editcustominfo2 method=post>";
echo "<table>";

if ($customscantype == '0') {
echo "<tr><td><font class=text12b>".pcrtlang("Items Found").":</td>";
echo "<td><input type=text size=10  name=thecount value=\"$scannum\"></td></tr>";
}

echo "<tr><td>".pcrtlang("Technical Title").":</td>";
echo "<td><input type=hidden name=woid  value=$woid><input type=hidden name=scanid value=$scanid><input type=text  size=35 name=custprogname value=\"$customprogname\"></td></tr>";
echo "<tr><td>".pcrtlang("Customer Viewable Title").":</td>";
echo "<td><input type=text size=35 name=custprogword  value=\"$customprogword\"></td></tr>";
if ($customscantype != '0') {
echo "<tr><td>".pcrtlang("Printable Info").":</td>";
echo "<td><textarea cols=60 rows=15 name=custprintinfo >$customprintinfo</textarea><input type=hidden name=thecount value=\"\"></td></tr>";
} else {
echo "<input type=hidden name=printinfo value=\"$customprintinfo\">";
}
echo "<tr><td><button class=ibutton type=button onclick=\"this.disabled=true; this.form.submit();\"><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button></td><td></td></tr>";


echo "</form></table>";

echo "</div>";
require("dfooter.php");

}


function editcustominfo2() {

require("deps.php");
require("common.php");

$custprogname = pv($_REQUEST['custprogname']);
$custprogword = pv($_REQUEST['custprogword']);
$custprintinfo = pv($_REQUEST['custprintinfo']);
$thecount = pv($_REQUEST['thecount']);
$woid = $_REQUEST['woid'];
$scanid = $_REQUEST['scanid'];


require_once("validate.php");




$rs_insert_scan = "UPDATE pc_scan SET customprogname = '$custprogname', customprogword = '$custprogword', customprintinfo = '$custprintinfo', scannum = '$thecount' WHERE scanid = '$scanid'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: index.php?pcwo=$woid#scans");

}


function setpriority() {

require("deps.php");
require("common.php");

$setpriority = $_REQUEST['setpriority'];
$woid = $_REQUEST['woid'];


require_once("validate.php");




$rs_set_p = "UPDATE pc_wo SET pcpriority = '$setpriority' WHERE woid = '$woid'";
@mysqli_query($rs_connect, $rs_set_p);

header("Location: index.php?pcwo=$woid#workorderinfo");

}




function removephoto() {

require("deps.php");
require("common.php");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}

$photofilename = $_REQUEST['photofilename'];
$photoid = $_REQUEST['photoid'];
$pcid = $_REQUEST['pcid'];
$woid = $_REQUEST['woid'];

require_once("validate.php");




$rs_set_p = "DELETE FROM assetphotos WHERE pcid = '$pcid' AND assetphotoid = '$photoid'";
@mysqli_query($rs_connect, $rs_set_p);

if (file_exists("../pcphotos/$photofilename")) {
unlink("../pcphotos/$photofilename");
}


header("Location: index.php?pcwo=$woid#assetinfo");

}


function highlightphoto() {

require("deps.php");
require("common.php");

$photoid = $_REQUEST['photoid'];
$pcid = $_REQUEST['pcid'];
$woid = $_REQUEST['woid'];

require_once("validate.php");




$rs_remove_p = "UPDATE assetphotos SET highlight = '0' WHERE pcid = '$pcid'";
@mysqli_query($rs_connect, $rs_remove_p);

$rs_set_p = "UPDATE assetphotos SET highlight = '1' WHERE assetphotoid = '$photoid'";
@mysqli_query($rs_connect, $rs_set_p);

header("Location: index.php?pcwo=$woid");

}

function remhighlightphoto() {

require("deps.php");
require("common.php");

$photoid = $_REQUEST['photoid'];
$pcid = $_REQUEST['pcid'];
$woid = $_REQUEST['woid'];

require_once("validate.php");




$rs_remove_p = "UPDATE assetphotos SET highlight = '0' WHERE pcid = '$pcid'";
@mysqli_query($rs_connect, $rs_remove_p);

$rs_set_p = "UPDATE assetphotos SET highlight = '0' WHERE assetphotoid = '$photoid'";
@mysqli_query($rs_connect, $rs_set_p);

header("Location: index.php?pcwo=$woid");

}


function checkoutpc() {

require("header.php");
require("deps.php");
require("brandicon.php");

echo "<table class=standard><tr><th>".pcrtlang("Checkout Asset/Device")."</th></tr>";
echo "<tr><td>".pcrtlang("Enter Work Order Number or<br>Scan Claim Ticket").":<br><br>";
echo "<form action=pc.php?func=checkoutpc2 method=post name=checkoutpc><input type=text  name=woid size=20><input type=submit value=\"".pcrtlang("Go")."\" >";
echo "</form></td></tr></table>";


echo "<br><br>";




$rs_findpcs5 = "SELECT * FROM pc_wo WHERE pcstatus = '4' AND storeid = '$defaultuserstore' ORDER BY dropdate DESC";
$rs_result5 = mysqli_query($rs_connect, $rs_findpcs5);



if ((mysqli_num_rows($rs_result5)) != 0) {

$boxstyles = getboxstyle("4");

start_status_box("4",pcrtlang("Or Choose Asset/Device from")." $boxstyles[boxtitle]");


echo "<br>";

echo "<form action=repcart.php?func=loadsavecartout_multiple method=post>";

while($rs_result_q5 = mysqli_fetch_object($rs_result5)) {
$pcid5 = "$rs_result_q5->pcid";
$woid5 = "$rs_result_q5->woid";
$called5 = "$rs_result_q5->called";
$pcpriorityindb5 = "$rs_result_q5->pcpriority";
$probdesc = "$rs_result_q5->probdesc";


$rs_chkinv = "SELECT * FROM invoices WHERE woid = '$woid5' OR woid LIKE '%"."_"."$woid5"."_"."%'";
$rs_chkinv2 = mysqli_query($rs_connect, $rs_chkinv);
$invcountonwo = mysqli_num_rows($rs_chkinv2);



if ($pcpriorityindb5 != "") {
$picon5 = "$pcpriority[$pcpriorityindb5]";
} else {
$picon5 = "";
}


$rs_findbill = "SELECT * FROM repaircart WHERE pcwo = '$woid5'";
$rs_findbill2 = mysqli_query($rs_connect, $rs_findbill);

$numite = mysqli_num_rows($rs_findbill2);
$dropdate5 = "$rs_result_q5->dropdate";
$rs_findowner5 = "SELECT * FROM pc_owner WHERE pcid = '$pcid5'";
$rs_result25 = mysqli_query($rs_connect, $rs_findowner5);
while($rs_result_q25 = mysqli_fetch_object($rs_result25)) {
$pcname5 = "$rs_result_q25->pcname";
$pccompany5 = "$rs_result_q25->pccompany";
$pcphone5 = "$rs_result_q25->pcphone";
$pcmake =  "$rs_result_q25->pcmake";

$rs_findsum = "SELECT (SUM(cart_price) + SUM(itemtax)) as checkcartsum FROM repaircart WHERE pcwo = '$woid5'";
$rs_findsum2 = @mysqli_query($rs_connect, $rs_findsum);
$rs_findsum3 = mysqli_fetch_object($rs_findsum2);
$checkcartsum = "$rs_findsum3->checkcartsum";


$rs_findpic = "SELECT * FROM assetphotos WHERE pcid = '$pcid5' AND highlight='1'";
$rs_resultpic2 = mysqli_query($rs_connect, $rs_findpic);
echo "<table class=standard>";


if (($numite > 0) && ($checkcartsum > 0)) {
$cartsum = number_format($checkcartsum, 2, '.', '');
echo "<tr><th>#$pcid5 $pcname5</th></tr>";
if("$pccompany5" != "") {
echo "<tr><td>$pccompany5</td></tr>";
}
echo "<tr><td>$pcmake</td></tr>";
echo "<tr><td>$money$cartsum</td></tr>";
} else {
echo "<tr><th>#$pcid5 $pcname5</th></tr>";
if("$pccompany5" != "") {
echo "<tr><td>$pccompany5</td></tr>";
}
echo "<tr><td>$pcmake</td></tr><tr><td>$money ".pcrtlang("NO CHARGE")."</td></tr>";
}

echo "<tr><td>";
echo elaps($dropdate5);
echo "<br>";
echo "</td></tr><tr><td>";


echo pcrtlang("Problem").":<br>$probdesc";
echo "</td></tr>";

echo "<tr><td>";
if (mysqli_num_rows($rs_resultpic2) != "0") {
$rs_resultpic_q2 = mysqli_fetch_object($rs_resultpic2);
$assetphotoid = "$rs_resultpic_q2->assetphotoid";
echo "<img src=pc.php?func=getpcimage&photoid=$assetphotoid border=0 width=150><br>";
} else {
$medicon = brandicon("$pcmake");
echo "<img src=../repair/images/pcs/$medicon border=0 width=64>";
}
echo "</td></tr>";

echo "<tr><td>";


if($invcountonwo == 0) {
echo "<input type=checkbox name=checkoutwo[] value=\"$woid5\" id=$woid5><label for=$woid5>".pcrtlang("Select for Multiple Checkout")."</label>";
$flagwo = 1;
}

echo "<button type=button onClick=\"parent.location='index.php?pcwo=$woid5'\" data-theme=\"b\">".pcrtlang("View this Work Order")."</button>";

echo "</td></tr></table><br><br>";

}
}

if(isset($flagwo)) {
echo "<br><input type=submit value=\"".pcrtlang("Checkout Selected on one Receipt")."\" data-theme=\"b\"></form>";
echo "<br><br>".pcrtlang("To checkout multiple work orders, check the boxes next to the work orders that you want to process on one receipt. You can also select just one work order, or click on the work order to review it and check it out right the work order using the standard checkout buttons. Work orders that have invoices created on them will not be able to be selected here for multiple checkout.")."";
}
echo "<br>";
}


require("footer.php");

}



function checkoutpc2() {

require("deps.php");
require("common.php");

$woid = $_REQUEST['woid'];

require_once("validate.php");

if(is_numeric("$woid")) {
header("Location: index.php?pcwo=$woid");
} else {
header("Location: pc.php?func=searchwo&searchterm=$woid");
}

}




function workorderaction() {

$woid = $_REQUEST['woid'];
require("deps.php");
require("common.php");

require("dheader.php");


if(!array_key_exists("contactonly",$_REQUEST)) {
$head = pcrtlang("Action Log for Work Order")." #$woid";
} else {
$head = pcrtlang("Contact History")." #$woid";
}

echo "<div data-role=\"header\" data-theme=\"b\"><h2>$head</h2></div>";
echo "<div class=\"ui-content\" role=\"main\">";





if(array_key_exists("contactonly",$_REQUEST)) {
$rs_find_cart_items = "SELECT * FROM userlog WHERE reftype = 'woid' AND refid = '$woid' AND (actionid = '11' OR actionid = '14') ORDER BY thedatetime ASC";
} else {
$rs_find_cart_items = "SELECT * FROM userlog WHERE reftype = 'woid' AND refid = '$woid' ORDER BY thedatetime ASC";
}


$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

if((mysqli_num_rows($rs_result)) == "0") {
echo "<br>".pcrtlang("No Results Found")."";
}

echo "<table class=doublestandard><tr><th></th></tr>";

while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_actionid = "$rs_result_q->actionid";
$rs_thedatetime2 = "$rs_result_q->thedatetime";
$rs_thedatetime = (date("Y-m-d g:i:s A", strtotime("$rs_thedatetime2")));
$rs_refid = "$rs_result_q->refid";
$loggeduser = "$rs_result_q->loggeduser";
$reftype = "$rs_result_q->reftype";
$mensaje = "$rs_result_q->mensaje";

if($reftype == "woid") {
if ($mensaje != "") {
$link = "$mensaje";
} else {
$link = "";
}
} elseif ($reftype == "pcid") {
$link = "<button type=button onClick=\"parent.location='../repair/pc.php?func=showpc&pcid=$rs_refid'\">".pcrtlang("on Asset ID").": #$rs_refid</button>";
} elseif ($reftype == "invoiceid") {
$link = "<button type=button onClick=\"parent.location='../store/invoice.php?func=printinv&invoice_id=$rs_refid'\">".pcrtlang("on Invoice").": #$rs_refid</button>";
} elseif ($reftype == "receiptid") {
$link = "<button type=button onClick=\"parent.location='../store/receipt.php?func=show_receipt&receipt=$rs_refid'\">".pcrtlang("on Receipt").": #$rs_refid</button>";
} elseif ($reftype == "rinvoiceid") {
$link = "<button type=button onClick=\"parent.location='../store/rinvoice.php?func=viewrinvoice&rinvoice_id=$rs_refid'\">".pcrtlang("on Recurring Invoice").": #$rs_refid</button>";
} elseif ($reftype == "groupid") {
$link = "<button type=button onClick=\"parent.location='../repair/group.php?func=viewgroup&pcgroupid=$rs_refid'\">".pcrtlang("on Group").": #$rs_refid</button>";
} else {
$link = "";
}

echo "<tr><td>($loggeduser) $loggedactions[$rs_actionid] $rs_thedatetime</td></tr><tr><td> $link<br><br></td></tr>";

}

echo "</table>";

echo "</div>";
require_once("dfooter.php");


}



function addassetphoto() {

$pcid = $_REQUEST['pcid'];
$woid = $_REQUEST['woid'];

require("deps.php");

require_once("common.php");

require("dheader.php");


echo "<div data-role=\"header\" data-theme=\"b\"><h2>".pcrtlang("Photo Upload")."</h2></div>";
echo "<div class=\"ui-content\" role=\"main\">";


echo "<form action=pc.php?func=addassetphoto2 method=post enctype=\"multipart/form-data\" data-ajax=\"false\">";
echo pcrtlang("Photo to Upload").":<input type=file name=photo>";
echo "<input type=hidden name=woid value=$woid><input type=hidden name=pcid value=$pcid>";
echo "<br><button type=submit id=button2 data-theme=\"b\">".pcrtlang("Upload Photo")."</button></form>";

echo "</div>";


require_once("dfooter.php");


}



##################################

function addassetphoto2() {

require("deps.php");
require_once("validate.php");
require("common.php");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}



$pcid = $_REQUEST['pcid'];
$woid = $_REQUEST['woid'];

$photofilename = "$pcid-" . time() . '.jpg';
$origphotofilename = basename($_FILES['photo']['name']);

function validate_conn($v_filename) {
   return preg_match('/\.jpg$/i', $v_filename) ? '1' : '0';
}


if (validate_conn($origphotofilename) == '0') {
die(pcrtlang("File must also be a jpg"));
}

userlog(7,$pcid,'pcid','');


$uploaddir = "../pcphotos/";
$uploadfile = $uploaddir . basename($_FILES['photo']['name']);
if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile)) {
} else {
    echo "Failed to save your image to the pcphotos directory. Might want to check your permissions.\n";
}

exec("convert -resize '1024>x768>' ../pcphotos/$origphotofilename ../pcphotos/$photofilename");

$problem_message = "";
if (!file_exists("../pcphotos/$photofilename")) {
$problem_message = pcrtlang("Failed to create image using ImageMagick from the command line. Looking for Apache Module...")."<br><br>";

if (class_exists('Imagick')) {
  $img = new Imagick();
  $img->readImage("../pcphotos/$origphotofilename");
  $img->scaleImage(1024,768,true);
  $img->writeImage("../pcphotos/$photofilename");
  $img->clear();
  $img->destroy();
$problem_message = pcrtlang("ImageMagick Apache Module found... Attempting to save image...")."<br><br>";
if (!file_exists("../pcphotos/$photofilename")) {
$problem_message = pcrtlang("Image Save Failed. Trying GD Module...")."<br><br>";
}
} else {
$problem_message = pcrtlang("ImageMagick Apache Module not available... Trying GD Module...")."<br><br>";
}
}

if (!file_exists("../pcphotos/$photofilename")) {

define('THUMBNAIL_IMAGE_MAX_WIDTH', 1024);
define('THUMBNAIL_IMAGE_MAX_HEIGHT', 768);

function generate_image_thumbnail($source_image_path, $thumbnail_image_path)
{
    list($source_image_width, $source_image_height, $source_image_type) = getimagesize($source_image_path);
    switch ($source_image_type) {
        case IMAGETYPE_GIF:
            $source_gd_image = imagecreatefromgif($source_image_path);
            break;
        case IMAGETYPE_JPEG:
            $source_gd_image = imagecreatefromjpeg($source_image_path);
            break;
        case IMAGETYPE_PNG:
            $source_gd_image = imagecreatefrompng($source_image_path);
            break;
    }
    if ($source_gd_image === false) {
        return false;
    }
    $source_aspect_ratio = $source_image_width / $source_image_height;
    $thumbnail_aspect_ratio = THUMBNAIL_IMAGE_MAX_WIDTH / THUMBNAIL_IMAGE_MAX_HEIGHT;
    if ($source_image_width <= THUMBNAIL_IMAGE_MAX_WIDTH && $source_image_height <= THUMBNAIL_IMAGE_MAX_HEIGHT) {
        $thumbnail_image_width = $source_image_width;
        $thumbnail_image_height = $source_image_height;
    } elseif ($thumbnail_aspect_ratio > $source_aspect_ratio) {
        $thumbnail_image_width = (int) (THUMBNAIL_IMAGE_MAX_HEIGHT * $source_aspect_ratio);
        $thumbnail_image_height = THUMBNAIL_IMAGE_MAX_HEIGHT;
    } else {
        $thumbnail_image_width = THUMBNAIL_IMAGE_MAX_WIDTH;
        $thumbnail_image_height = (int) (THUMBNAIL_IMAGE_MAX_WIDTH / $source_aspect_ratio);
    }
    $thumbnail_gd_image = imagecreatetruecolor($thumbnail_image_width, $thumbnail_image_height);
    imagecopyresampled($thumbnail_gd_image, $source_gd_image, 0, 0, 0, 0, $thumbnail_image_width, $thumbnail_image_height, $source_image_width, $source_image_height);
    imagejpeg($thumbnail_gd_image, $thumbnail_image_path, 90);
    imagedestroy($source_gd_image);
    imagedestroy($thumbnail_gd_image);
    return true;
}

generate_image_thumbnail("../pcphotos/$origphotofilename", "../pcphotos/$photofilename");
if (!file_exists("../pcphotos/$photofilename")) {
$problem_message = pcrtlang("Image Save Failed using GD...")."<br><br>";
}
}



if (file_exists("../pcphotos/$origphotofilename")) {
unlink("../pcphotos/$origphotofilename");
}

if (!file_exists("../pcphotos/$photofilename")) {
die("$problem_message");
}







$rs_check_pic = "SELECT * FROM assetphotos WHERE pcid = '$pcid' AND highlight = '1'";
$hicheck = @mysqli_query($rs_connect, $rs_check_pic);

if ((mysqli_num_rows($hicheck)) == "0") {
$highlight = "1";
} else {
$highlight = "0";
}

$rs_insert_pic = "INSERT INTO assetphotos (pcid,photofilename,highlight) VALUES ('$pcid','$photofilename','$highlight')";
@mysqli_query($rs_connect, $rs_insert_pic);


header("Location: index.php?pcwo=$woid#assetinfo");

}

function searchwo() {
require("header.php");
require("deps.php");

$searchterm = pv($_REQUEST['searchterm']);

echo "<form action=pc.php?func=searchwo method=post data-ajax=\"false\"><input type=text  name=searchterm value=\"$searchterm\" required=required>";
echo "<button type=submit data-theme=\"b\"><i class=\"fa fa-search fa-lg\"></i> ".pcrtlang("Search Again")."</button>";
echo "</form>";

echo "<br>";



$woids = array();
$rs_find_pc3 = "SELECT woid FROM pc_wo WHERE probdesc LIKE '%$searchterm%' OR thepass LIKE '%$searchterm%'  LIMIT 50";
$rs_result_item3 = mysqli_query($rs_connect, $rs_find_pc3);

while($rs_result_item_q3 = mysqli_fetch_object($rs_result_item3)) {
$woidq = "$rs_result_item_q3->woid";
$woids[] = $woidq;
}

$rs_find_pc2 = "SELECT woid FROM wonotes WHERE thenote LIKE '%$searchterm%'  LIMIT 50";
$rs_result_item2 = mysqli_query($rs_connect, $rs_find_pc2);

while($rs_result_item_q2 = mysqli_fetch_object($rs_result_item2)) {
$woidq2 = "$rs_result_item_q2->woid";
if(!in_array("$woidq2", $woids)) {
$woids[] = $woidq2;
}
}

echo "<h3>".pcrtlang("Work Order Search Results")."</h3>";

sort($woids);

foreach($woids as $key => $val) {

$rs_find_pc = "SELECT woid,pcid,probdesc FROM pc_wo WHERE woid = '$val'";
$rs_result_item = mysqli_query($rs_connect, $rs_find_pc);

while($rs_result_item_q = mysqli_fetch_object($rs_result_item)) {
$woidq = "$rs_result_item_q->woid";
$pcidq = "$rs_result_item_q->pcid";
$probdesc = "$rs_result_item_q->probdesc";


$rs_find_pcowner = "SELECT pcname,pcmake,pccompany FROM pc_owner WHERE pcid = $pcidq";
$rs_result_item_owner = mysqli_query($rs_connect, $rs_find_pcowner);
$rs_result_item_qo = mysqli_fetch_object($rs_result_item_owner);
$pcmake = "$rs_result_item_qo->pcmake";
$pcname = "$rs_result_item_qo->pcname";
$pccompany = "$rs_result_item_qo->pccompany";

echo "<table class=standard><tr><th><button type=button onClick=\"parent.location='index.php?pcwo=$woidq'\">$pcname</button></th></tr>";
echo "<tr><td>".pcrtlang("Asset/Device ID").": $pcidq</td></tr>";
echo "<tr><td>".pcrtlang("Work Order").": $woidq</td></tr>";
if ("$pccompany" != "") {
echo "<tr><td>".pcrtlang("Company").": $pccompany</td></tr>";
}
echo "<tr><td>".pcrtlang("Device Make").": $pcmake</td></tr>";
echo "<tr><td>";
echo pcrtlang("Problem Description").":<br>$probdesc";
echo "</td></tr>";



######

echo "<tr><td><strong>".pcrtlang("Notes for Customer").":</strong><br>";

$rs_findnotes = "SELECT * FROM wonotes WHERE woid = '$woidq' AND notetype = '0' ORDER BY notetime ASC";
$rs_result_n = mysqli_query($rs_connect, $rs_findnotes);
while($rs_result_qn = mysqli_fetch_object($rs_result_n)) {
$thenote = nl2br("$rs_result_qn->thenote");
$noteuser = "$rs_result_qn->noteuser";
$notetype = "$rs_result_qn->notetype";
$noteid = "$rs_result_qn->noteid";
$notetime2 = "$rs_result_qn->notetime";
$notetime =  date('g:ia n-j-Y', strtotime($notetime2));

echo "$noteuser";
echo "<br>$notetime";
echo "<br>$thenote";

}

echo "</td></tr>";

#######tech notes

echo "<tr><td><strong>".pcrtlang("Technician Only Notes/Billing Instructions").":</strong><br>";

$rs_findnotes = "SELECT * FROM wonotes WHERE woid = '$woidq' AND notetype = '1' ORDER BY notetime ASC";
$rs_result_n = mysqli_query($rs_connect, $rs_findnotes);
$bubblego = "first";
$usercomm = array();
while($rs_result_qn = mysqli_fetch_object($rs_result_n)) {
$thenote = nl2br("$rs_result_qn->thenote");
$noteuser = "$rs_result_qn->noteuser";
$noteid = "$rs_result_qn->noteid";
$notetype = "$rs_result_qn->notetype";
$notetime2 = "$rs_result_qn->notetime";
$notetime =  date('g:ia n-j-Y', strtotime($notetime2));

echo "$noteuser";
echo "<br>$notetime";
echo "<br>$thenote";

}

echo "</td></tr>";

######


}
echo "</table><br>";
}

require("footer.php");

}


function savesig() {

require("deps.php");
require("common.php");

$output = pv($_REQUEST['output']);
$woid = $_REQUEST['woid'];
$claimstoreid = $_REQUEST['claimstoreid'];

require_once("validate.php");




$rs_savesig = "UPDATE pc_wo SET thesig = '$output' WHERE woid = '$woid'";
@mysqli_query($rs_connect, $rs_savesig);

$storeinfoarray = getstoreinfo($claimstoreid);
$sigtext = pv($storeinfoarray['claimticket']);

$rs_delsigt = "DELETE FROM claimsigtext WHERE woid = '$woid'";
@mysqli_query($rs_connect, $rs_delsigt);

$rs_savesigt = "INSERT INTO claimsigtext SET sigtext = '$sigtext', woid = '$woid'";
@mysqli_query($rs_connect, $rs_savesigt);

header("Location: pc.php?func=printclaimticket&woid=$woid");

}


function savesigtopaz() {

require("deps.php");
require("common.php");

$output = pv($_REQUEST['sigImageData']);
$woid = $_REQUEST['woid'];
$claimstoreid = $_REQUEST['claimstoreid'];

require_once("validate.php");




$rs_savesig = "UPDATE pc_wo SET thesigtopaz = '$output' WHERE woid = '$woid'";
@mysqli_query($rs_connect, $rs_savesig);

$storeinfoarray = getstoreinfo($claimstoreid);
$sigtext = pv($storeinfoarray['claimticket']);
$rs_delsigt = "DELETE FROM claimsigtext WHERE woid = '$woid'";
@mysqli_query($rs_connect, $rs_delsigt);

$rs_savesigt = "INSERT INTO claimsigtext SET sigtext = '$sigtext', woid = '$woid'";
@mysqli_query($rs_connect, $rs_savesigt);

header("Location: pc.php?func=printclaimticket&woid=$woid");

}



function clearsig() {

require("deps.php");
require("common.php");

$woid = $_REQUEST['woid'];

require_once("validate.php");




$rs_savesig = "UPDATE pc_wo SET thesig = '' WHERE woid = '$woid'";
@mysqli_query($rs_connect, $rs_savesig);

$rs_delsigt = "DELETE FROM claimsigtext WHERE woid = '$woid'";
@mysqli_query($rs_connect, $rs_delsigt);

header("Location: pc.php?func=printclaimticket&woid=$woid");

}

function clearsigtopaz() {

require("deps.php");
require("common.php");

$woid = $_REQUEST['woid'];

require_once("validate.php");




$rs_savesig = "UPDATE pc_wo SET thesigtopaz = '' WHERE woid = '$woid'";
@mysqli_query($rs_connect, $rs_savesig);

$rs_delsigt = "DELETE FROM claimsigtext WHERE woid = '$woid'";
@mysqli_query($rs_connect, $rs_delsigt);

header("Location: pc.php?func=printclaimticket&woid=$woid");

}


function savesigwo() {

require("deps.php");
require("common.php");

$output = pv($_REQUEST['output']);
$woid = $_REQUEST['woid'];

require_once("validate.php");




$rs_savesig = "UPDATE pc_wo SET thesigwo = '$output' WHERE woid = '$woid'";
@mysqli_query($rs_connect, $rs_savesig);

header("Location: pc.php?func=printit&woid=$woid");

}

function savesigwotopaz() {

require("deps.php");
require("common.php");

$output = pv($_REQUEST['sigImageData']);
$woid = $_REQUEST['woid'];

require_once("validate.php");




$rs_savesig = "UPDATE pc_wo SET thesigwotopaz = '$output' WHERE woid = '$woid'";
@mysqli_query($rs_connect, $rs_savesig);

header("Location: pc.php?func=printit&woid=$woid");

}


function clearsigwo() {
require("deps.php");
require("common.php");

$woid = $_REQUEST['woid'];

require_once("validate.php");




$rs_savesig = "UPDATE pc_wo SET thesigwo = '' WHERE woid = '$woid'";
@mysqli_query($rs_connect, $rs_savesig);

header("Location: pc.php?func=printit&woid=$woid");

}

function clearsigwotopaz() {
require("deps.php");
require("common.php");

$woid = $_REQUEST['woid'];

require_once("validate.php");




$rs_savesig = "UPDATE pc_wo SET thesigwotopaz = '' WHERE woid = '$woid'";
@mysqli_query($rs_connect, $rs_savesig);

header("Location: pc.php?func=printit&woid=$woid");

}



function savesigcr() {

require("deps.php");
require("common.php");

$output = pv($_REQUEST['output']);
$woid = $_REQUEST['woid'];

require_once("validate.php");




$rs_savesig = "UPDATE pc_wo SET thesigcr = '$output' WHERE woid = '$woid'";
@mysqli_query($rs_connect, $rs_savesig);

header("Location: pc.php?func=printcheckoutreceipt&woid=$woid");

}

function savesigcrtopaz() {

require("deps.php");
require("common.php");

$output = pv($_REQUEST['sigImageData']);
$woid = $_REQUEST['woid'];

require_once("validate.php");




$rs_savesig = "UPDATE pc_wo SET thesigcrtopaz = '$output' WHERE woid = '$woid'";
@mysqli_query($rs_connect, $rs_savesig);

header("Location: pc.php?func=printcheckoutreceipt&woid=$woid");

}


function clearsigcr() {
require("deps.php");
require("common.php");

$woid = $_REQUEST['woid'];

require_once("validate.php");




$rs_savesig = "UPDATE pc_wo SET thesigcr = '' WHERE woid = '$woid'";
@mysqli_query($rs_connect, $rs_savesig);

header("Location: pc.php?func=printcheckoutreceipt&woid=$woid");

}

function clearsigcrtopaz() {
require("deps.php");
require("common.php");

$woid = $_REQUEST['woid'];

require_once("validate.php");




$rs_savesig = "UPDATE pc_wo SET thesigcrtopaz = '' WHERE woid = '$woid'";
@mysqli_query($rs_connect, $rs_savesig);

header("Location: pc.php?func=printcheckoutreceipt&woid=$woid");

}




function changestatusview() {

require("deps.php");
require("common.php");

$view = $_REQUEST['view'];

require_once("validate.php");




$rs_cv = "UPDATE users SET statusview = '$view' WHERE username = '$ipofpc'";
@mysqli_query($rs_connect, $rs_cv);

if (!array_key_exists('touch',$_REQUEST)) {
header("Location: ../repairmobile/");
} else {
header("Location: ../repairmboile/touch.php");
}


}


function thankyou() {

require("dheader.php");
require("deps.php");

$woid = $_REQUEST['woid'];
$pcname = pcrtlang("Dear")." ".$_REQUEST['pcname'].",\n\n";

if (array_key_exists('email',$_REQUEST)) {
$email = $_REQUEST['email'];
$formaction = "<form action=pc.php?func=emailthankyou method=post data-ajax=\"false\"><input type=hidden name=email value=\"$email\"><input type=hidden name=woid value=\"$woid\">";
$formaction .= pcrtlang("Email").":<input type=textbox name=email value=\"$email\" >";
} else {
$formaction = "<form action=pc.php?func=printthankyou method=post data-ajax=\"false\"><input type=hidden name=woid value=\"$woid\">";
}

$storeinfoarray = getstoreinfo($defaultuserstore);


echo "<div data-role=\"header\" data-theme=\"b\"><h2>".pcrtlang("Send Thank-You")."</h2></div>";
echo "<div class=\"ui-content\" role=\"main\">";

echo pcrtlang("Thank You Letter Text").":$formaction<textarea  name=thethankyou>$pcname $storeinfoarray[thankyouletter]</textarea>";

if (array_key_exists('email',$_REQUEST)) {
echo "<input  type=submit value=\"".pcrtlang("Send Email")."\" data-theme=\"b\"></form>";
} else {
echo "<input  type=submit value=\"".pcrtlang("Print")."\" data-theme=\"b\"></form>";
}


echo "</div>";

require("dfooter.php");

}


####

function printthankyou() {
require_once("validate.php");
require("deps.php");
require_once("common.php");

$woid = $_REQUEST['woid'];

userlog(24,$woid,'woid','');





$rs_findpc = "SELECT * FROM pc_wo WHERE woid = '$woid'";
$rs_result = mysqli_query($rs_connect, $rs_findpc);
while($rs_result_q = mysqli_fetch_object($rs_result)) {
$pcid = "$rs_result_q->pcid";
$probdesc = "$rs_result_q->probdesc";
$dropoff = "$rs_result_q->dropdate";
$pickup = "$rs_result_q->pickupdate";
$pcstatus = "$rs_result_q->pcstatus";
$rs_storeid = "$rs_result_q->storeid";
$thesig = "$rs_result_q->thesig";
$assigneduser = "$rs_result_q->assigneduser";

$storeinfoarray = getstoreinfo($rs_storeid);




$rs_findowner = "SELECT * FROM pc_owner WHERE pcid = '$pcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
while($rs_result_q2 = mysqli_fetch_object($rs_result2)) {
$pcname = "$rs_result_q2->pcname";
$pccompany = "$rs_result_q2->pccompany";
$pcphone = "$rs_result_q2->pcphone";
$pcworkphone = "$rs_result_q2->pcworkphone";
$pccellphone = "$rs_result_q2->pccellphone";
$pcmake = "$rs_result_q2->pcmake";
$pcemail = "$rs_result_q2->pcemail";
$pcaddress = "$rs_result_q2->pcaddress";
$pcaddress2 = "$rs_result_q2->pcaddress2";
$pccity = "$rs_result_q2->pccity";
$pcstate = "$rs_result_q2->pcstate";
$pczip = "$rs_result_q2->pczip";

$thethankyou = $storeinfoarray['thankyouletter'];
$pcname2 = pcrtlang("Dear")." $pcname,<br><br>";


?>
<!DOCTYPE html>

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>-</title> 

<?php


echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../repair/printstyle.css\">";


echo "</head>";

if($autoprint == 1) {
echo "<body class=printpagebg onLoad=\"window.print()\">";
} else {
echo "<body class=printpagebg>";
}


echo "<div class=printbar>";
echo "<button onClick=\"parent.location='index.php?pcwo=$woid#workorderinfo'\" class=bigbutton><img src=../repair/images/left.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Return")."</button>";
echo "<font class=text30b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>";
echo "<button onClick=\"print();\" class=bigbutton><img src=../repair/images/print.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Print")."</button>";
echo "</div><div class=printpage>";


####

echo "<table width=100%><tr><td width=55%>";
echo "<img src=../repair/$printablelogo><br><br><font class=text12b>";
echo "$storeinfoarray[storename]</font><br><font class=text12b>$storeinfoarray[storeaddy1]";
if ("$storeinfoarray[storeaddy2]" != "") {
echo "<br>$storeinfoarray[storeaddy2]";
}
echo "<br>$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]</font>";
echo "<br><font class=text12>".pcrtlang("Phone").":</font><font class=text12b> $storeinfoarray[storephone]</font><br><br><br>";


echo "<table cellpadding=3 cellspacing=0 border=0><tr><td valign=top>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><font class=text12>$pcname<br>$pcaddress";
if ($pcaddress2 != "") {
echo "<br>$pcaddress2";
}

echo "<br>";
if ($pccity != "") {
echo "$pccity, ";
}
echo "$pcstate $pczip</font><br>";


echo "</td></tr></table>";
echo "<br></td><td align=right width=45% valign=top>";

echo "<font class=textidnumber>".pcrtlang("Thank You")."</font><br>";

$dropoffdate2 = pcrtdate("$pcrt_longdate", "$dropoff").", ".pcrtdate("$pcrt_time", "$dropoff");


echo "<br><font class=text12b>".pcrtlang("Drop Off Date").":</font><font class=textgray12> $dropoffdate2</font>";


if ($woid != "0") {
echo "<br><font class=text12b>".pcrtlang("Work Order")." </font><font class=textgray12>#$woid</font>";
}


if ($assigneduser != "") {
echo "<br><font class=text12b>".pcrtlang("Serviced By").":</font><font class=textgray12> $assigneduser</font>";
}



echo "</td></tr></table>";




####

echo "<br><br>$pcname2";
echo nl2br($thethankyou);

}

}

echo "</div>";

echo "</body></html>";

}


function emailthankyou() {
require_once("validate.php");
require("deps.php");

require_once("common.php");
require("dheader.php");

$email = $_REQUEST['email'];
$woid = $_REQUEST['woid'];

echo "<div data-role=\"header\" data-theme=\"b\"><h2>".pcrtlang("Email Thank-You")."</h2></div>";
echo "<div class=\"ui-content\" role=\"main\">";

echo "<br><form action=pc.php?func=emailthankyou2 method=POST data-ajax=\"false\"><input type=text value=\"$email\" name=email><input type=hidden value=$woid name=woid>";
echo "<input type=submit  value=\"".pcrtlang("Email Thank-You Letter")."\"  data-theme=\"b\"></form><br><br>";

echo "</div>";
require_once("dfooter.php");


}


#####

function emailthankyou2() {
require_once("validate.php");
require("deps.php");
require_once("common.php");

$woid = $_REQUEST['woid'];
$email = $_REQUEST['email'];


if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}


userlog(25,$woid,'woid',pcrtlang("Sent thank-you letter to")." $email");





$rs_findpc = "SELECT * FROM pc_wo WHERE woid = '$woid'";
$rs_result = mysqli_query($rs_connect, $rs_findpc);
while($rs_result_q = mysqli_fetch_object($rs_result)) {
$pcid = "$rs_result_q->pcid";
$probdesc = "$rs_result_q->probdesc";
$dropoff = "$rs_result_q->dropdate";
$pickup = "$rs_result_q->pickupdate";
$pcstatus = "$rs_result_q->pcstatus";
$rs_storeid = "$rs_result_q->storeid";
$thesig = "$rs_result_q->thesig";
$assigneduser = "$rs_result_q->assigneduser";
$storeinfoarray = getstoreinfo($rs_storeid);

$rs_findowner = "SELECT * FROM pc_owner WHERE pcid = '$pcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
while($rs_result_q2 = mysqli_fetch_object($rs_result2)) {
$pcname = "$rs_result_q2->pcname";
$pccompany = "$rs_result_q2->pccompany";
$pcphone = "$rs_result_q2->pcphone";
$pcworkphone = "$rs_result_q2->pcworkphone";
$pccellphone = "$rs_result_q2->pccellphone";
$pcmake = "$rs_result_q2->pcmake";
$pcemail = "$rs_result_q2->pcemail";
$pcaddress = "$rs_result_q2->pcaddress";
$pcaddress2 = "$rs_result_q2->pcaddress2";
$pccity = "$rs_result_q2->pccity";
$pcstate = "$rs_result_q2->pcstate";
$pczip = "$rs_result_q2->pczip";

$to = "$email";

if("$storeinfoarray[storeccemail]" != "")	{
$to .= ",$storeinfoarray[storeccemail]";
}

$subject = "$storeinfoarray[storename] - ".pcrtlang("Thank You");
$random_hash = md5(date('r', time()));
$headers = "From: $storeinfoarray[storeemail]\nReply-To: $storeinfoarray[storeemail]\nX-Mailer: PHP/".phpversion();
$headers .= "\nMIME-Version: 1.0";
$headers .= "\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
$headers .= "\nMIME-Version: 1.0";

$thethankyou = $storeinfoarray['thankyouletter'];
$thethankyounotags = strip_tags(preg_replace('/<a href="(.*)">/', '$1', $thethankyou));

$message = "--PHP-alt-$random_hash\n";
$message .= "Content-Type: text/plain; charset=\"utf-8\"\n";
$message .= "Content-Transfer-Encoding: 7bit\n\n";


$peartext = "$storeinfoarray[storename]\n$storeinfoarray[storeaddy1]\n$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]\n\n".pcrtlang("Phone").": $storeinfoarray[storephone]\n\n".pcrtlang("Dear")." $pcname,\n $thethankyounotags\n\n";
$message .= "$storeinfoarray[storename]\n$storeinfoarray[storeaddy1]\n$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]\n\n".pcrtlang("Phone").": $storeinfoarray[storephone]\n\n".pcrtlang("Dear")." $pcname,\n $thethankyounotags\n\n";

$message .= "--PHP-alt-$random_hash\n";
$message .= "Content-Type: text/html; charset=\"utf-8\"\n";
$message .= "Content-Transfer-Encoding: 7bit\n\n";



$pcname2 = "<font style=\"font-family:Verdana;font-size:12px;font-weight:bold;\">".pcrtlang("Dear")." $pcname,</font><br><br>";

$message .= "<html><head><title>$sitename</title></head>";
$pearhtml = "<html><head><title>$sitename</title></head>";

####

$message .= "<table width=100%><tr><td width=55%>";
$pearhtml .= "<table width=100%><tr><td width=55%>";

$message .= "<font style=\"font-family:Verdana;font-size:25px;font-weight:bold;\">$storeinfoarray[storename]</font><br><br><font style=\"font-size: 12px; font-weight:bold;font-family:Verdana\">";
$pearhtml .= "<img src=$logo><br><br><font style=\"font-size: 12px; font-weight:bold;font-family:Verdana;\">";

$message .= "$storeinfoarray[storename]</font><font style=\"font-size: 12px; font-weight:normal;font-family:Verdana;\"><br>$storeinfoarray[storeaddy1]";
$pearhtml .= "$storeinfoarray[storename]</font><font style=\"font-size: 12px; font-weight:normal;font-family:Verdana;\"><br>$storeinfoarray[storeaddy1]";

if ("$storeinfoarray[storeaddy2]" != "") {
$message .= "<br>$storeinfoarray[storeaddy2]";
$pearhtml .= "<br>$storeinfoarray[storeaddy2]";
}
$message .= "<br>$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]</font>";
$pearhtml .= "<br>$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]</font>";

$message .= "<br><font style=\"font-size: 12px; font-weight:normal;font-family:Verdana;\">".pcrtlang("Phone").": $storeinfoarray[storephone]</font><br><br><br>";
$pearhtml .= "<br><font style=\"font-size: 12px; font-weight:normal;font-family:Verdana;\">".pcrtlang("Phone").": $storeinfoarray[storephone]</font><br><br><br>";

$message .= "<table cellpadding=3 cellspacing=0 border=0><tr><td valign=top>&nbsp;&nbsp;&nbsp;</td><td><font style=\"font-size: 12px; font-weight:normal;font-family:Verdana;\">$pcname<br>$pcaddress";
$pearhtml .= "<table cellpadding=3 cellspacing=0 border=0><tr><td valign=top>&nbsp;&nbsp;&nbsp;</td><td><font style=\"font-size: 12px; font-weight:normal;font-family:Verdana;\">$pcname<br>$pcaddress";

if ($pcaddress2 != "") {
$message .= "<br>$pcaddress2";
$pearhtml .= "<br>$pcaddress2";
}

$message .= "<br>";
$pearhtml .= "<br>";

if ($pccity != "") {
$message .= "$pccity, ";
$pearhtml .= "$pccity, ";
}

$message .= "$pcstate $pczip</font><br>";
$pearhtml .= "$pcstate $pczip</font><br>";

$message .= "</td></tr></table>";
$pearhtml .= "</td></tr></table>";

$message .= "<br></td><td align=right width=45% valign=top>";
$pearhtml .= "<br></td><td align=right width=45% valign=top>";

$message .= "<font style=\"font-family:Verdana;font-size:30px;font-weight:bold;color:#555555\">".pcrtlang("Thank You")."</font><br>";
$pearhtml .= "<font style=\"font-family:Verdana;font-size:30px;font-weight:bold;color:#555555\">".pcrtlang("Thank You")."</font><br>";

$dropoffdate2 = date("F j, Y, g:i a", strtotime($dropoff));

$message .= "<br><font style=\"font-family:Verdana;font-size:12px;font-weight:bold;\">".pcrtlang("Drop Off Date").": $dropoffdate2</font>";
$pearhtml .= "<br><font style=\"font-family:Verdana;font-size:12px;font-weight:bold;\">".pcrtlang("Drop Off Date").": $dropoffdate2</font>";

if ($woid != "0") {
$message .= "<br><font style=\"font-family:Verdana;font-size:12px;font-weight:bold;\">".pcrtlang("Work Order")." #$woid</font>";
$pearhtml .= "<br><font style=\"font-family:Verdana;font-size:12px;font-weight:bold;\">".pcrtlang("Work Order")." <font class=textgray12>#$woid</font>";
}


if ($assigneduser != "") {
$message .= "<br><font style=\"font-family:Verdana;font-size:12px;font-weight:bold;\">".pcrtlang("Serviced By").": $assigneduser</font>";
$pearhtml .= "<br><font style=\"font-family:Verdana;font-size:12px;font-weight:bold;\">".pcrtlang("Serviced By").": $assigneduser</font>";
}



$message .= "</td></tr></table>";
$pearhtml .= "</td></tr></table>";



####

$message .= "<br><br>$pcname2";
$pearhtml .= "<br><br>$pcname2";

$message .= nl2br($thethankyou);
$pearhtml .= nl2br($thethankyou);
}

}



$message .= "</body></html>\n\n";
$pearhtml .= "</body></html>\n\n";

$message .= "--PHP-alt-$random_hash--\n\n";

if (!isset($pcrt_mailer)) {
$pcrt_mailer = "mail";
}

if ($pcrt_mailer == "mail") {
$mail_sent = @mail( $to, $subject, $message, $headers );
echo $mail_sent ? "<html><head><meta http-equiv=\"refresh\" content=\"2;url=index.php?pcwo=$woid\"></head><body>".pcrtlang("Mail sent")."<br><br><a href=index.php?pcwo=$woid>".pcrtlang("Return")."</a></body></html>" : pcrtlang("Mail failed");
} elseif (($pcrt_mailer == "pearsmtp") || ($pcrt_mailer == "pearsmtpauth") || ($pcrt_mailer == "pearphpmailer")) {

if (!@include('Mail.php'))  {
echo "<div style=\"border: #ff0000 2px solid; background:#FFBCBC; color:#ff0000; margin: 20px; padding:20px;\">";
echo "Sorry you server does not have support for the Pear Mail and Pear Mail-Mime library. Check with your host to see if it is supported, or visit go-pear.com to download the pear installer
that can be run from your website to install your own local copy of Pear and the Pear Mail and Pear Mail-Mime modules.<br><br>If you choose to install your own copy, after installing, you
will need to also add the Mail and Mail-Mime packages. You will need to use your host control panel to password protect the directory. You will also need to add a setting to a
php.ini or php5.ini file to specify the runtime path of pear for your server. Quite often you can google your hosting provider name and pear to find a howto for your host.
if you are running your own linux server, quite often your distribution provides ready to install Pear packages.";
echo "</div>";
die();
}


#include('Mail.php');
    include('Mail/mime.php');

    $pearmessage2 = new Mail_mime();

    $pearmessage2->setTXTBody($peartext);
    $pearmessage2->setHTMLBody($pearhtml);

$imagetype = mb_substr("../repair/$logo", -3);
if ($imagetype == "gif") {
$pearmessage2->addHTMLImage("../repair/$logo", 'image/gif');
} elseif ($imagetype == "jpg") {
$pearmessage2->addHTMLImage("../repair/$logo", 'image/jpeg');
} elseif ($imagetype == "png") {
$pearmessage2->addHTMLImage("../repair/$logo", 'image/png');
} else {
}

$mime_params = array(
  'text_encoding' => '7bit',
  'text_charset'  => 'UTF-8',
  'html_charset'  => 'UTF-8',
  'head_charset'  => 'UTF-8'
);

    $body = $pearmessage2->get($mime_params);
    $extraheaders = array("To"=>"$to","From"=>"$storeinfoarray[storeemail]", "Subject"=>"$subject", "Content-Type"  => "text/html; charset=UTF-8");
    $pearheaders = $pearmessage2->headers($extraheaders);

if ("$pcrt_mailer" == "pearsmtpauth") {
$smtp = Mail::factory('smtp',
   array ('host' => $pcrt_pear_host,
     'auth' => true,
     'port' => $pcrt_pear_port,
     'username' => $pcrt_pear_username,
     'password' => $pcrt_pear_password));
} elseif ("$pcrt_mailer" == "pearphpmailer") {
$smtp = Mail::factory('mail');
} elseif ("$pcrt_mailer" == "pearsmtp")  {
$smtp = Mail::factory('smtp');
} else {
die("Invalid Mailer Chosen");
}



$mailresult = $smtp->send("$to", $pearheaders, $body);

if (PEAR::isError($mailresult)) {
   echo("<p>" . $mailresult->getMessage() . "</p>");
  } else {
   echo "<html><head><meta http-equiv=\"refresh\" content=\"2;url=index.php?pcwo=$woid\"></head><body>".pcrtlang("Mail sent")."<br>";
   echo "<br><a href=index.php?pcwo=$woid#workorderinfo>".pcrtlang("Return")."</a></body></html>";
  }

} else {
echo "Error: invalid mailer specified in the deps.php config file";
}



}



function hidesigct() {

require("deps.php");
require("common.php");

$hidesig = pv($_REQUEST['hidesig']);
$woid = $_REQUEST['woid'];

require_once("validate.php");




$rs_hidesig = "UPDATE pc_wo SET showsigct = '$hidesig' WHERE woid = '$woid'";
@mysqli_query($rs_connect, $rs_hidesig);

header("Location: pc.php?func=printclaimticket&woid=$woid");

}


function hidesigcttopaz() {

require("deps.php");
require("common.php");

$hidesig = pv($_REQUEST['hidesig']);
$woid = $_REQUEST['woid'];

require_once("validate.php");




$rs_hidesig = "UPDATE pc_wo SET showsigcttopaz = '$hidesig' WHERE woid = '$woid'";
@mysqli_query($rs_connect, $rs_hidesig);

header("Location: pc.php?func=printclaimticket&woid=$woid");

}


function hidesigcr() {

require("deps.php");
require("common.php");

$hidesig = pv($_REQUEST['hidesig']);
$woid = $_REQUEST['woid'];

require_once("validate.php");




$rs_hidesig = "UPDATE pc_wo SET showsigcr = '$hidesig' WHERE woid = '$woid'";
@mysqli_query($rs_connect, $rs_hidesig);

header("Location: pc.php?func=printcheckoutreceipt&woid=$woid");

}

function hidesigcrtopaz() {

require("deps.php");
require("common.php");

$hidesig = pv($_REQUEST['hidesig']);
$woid = $_REQUEST['woid'];

require_once("validate.php");




$rs_hidesig = "UPDATE pc_wo SET showsigcrtopaz = '$hidesig' WHERE woid = '$woid'";
@mysqli_query($rs_connect, $rs_hidesig);

header("Location: pc.php?func=printcheckoutreceipt&woid=$woid");

}



function hidesigrr() {

require("deps.php");
require("common.php");

$hidesig = pv($_REQUEST['hidesig']);
$woid = $_REQUEST['woid'];

require_once("validate.php");




$rs_hidesig = "UPDATE pc_wo SET showsigrr = '$hidesig' WHERE woid = '$woid'";
@mysqli_query($rs_connect, $rs_hidesig);

header("Location: pc.php?func=printit&woid=$woid");

}

function hidesigrrtopaz() {

require("deps.php");
require("common.php");

$hidesig = pv($_REQUEST['hidesig']);
$woid = $_REQUEST['woid'];

require_once("validate.php");




$rs_hidesig = "UPDATE pc_wo SET showsigrrtopaz = '$hidesig' WHERE woid = '$woid'";
@mysqli_query($rs_connect, $rs_hidesig);

header("Location: pc.php?func=printit&woid=$woid");

}


function getpcimage() {

require("deps.php");
require("common.php");

$photoid = $_REQUEST['photoid'];




$rs_findfileid = "SELECT photofilename FROM assetphotos WHERE assetphotoid = '$photoid'";
$rs_resultfid = mysqli_query($rs_connect, $rs_findfileid);
$rs_result_qfid = mysqli_fetch_object($rs_resultfid);
$photo_filename = "$rs_result_qfid->photofilename";


header("Content-Type: image/jpg; Content-Disposition: inline; filename=\"$photo_filename\"");
readfile("../pcphotos/$photo_filename");

}


function searchreturnpcsreq() {
require("header.php");
require("deps.php");

$searchterm = $_REQUEST['searchterm'];
$merge_custname = $_REQUEST['merge_custname'];
$merge_custcompany = $_REQUEST['merge_custcompany'];
$merge_custphone = $_REQUEST['merge_custphone'];
$merge_custemail = $_REQUEST['merge_custemail'];
$merge_custworkphone = $_REQUEST['merge_custworkphone'];
$merge_custcellphone = $_REQUEST['merge_custcellphone'];
$merge_custaddress1 = $_REQUEST['merge_custaddress1'];
$merge_custaddress2 = $_REQUEST['merge_custaddress2'];
$merge_custcity = $_REQUEST['merge_custcity'];
$merge_custstate = $_REQUEST['merge_custstate'];
$merge_custzip = $_REQUEST['merge_custzip'];
$merge_probdesc = $_REQUEST['merge_probdesc'];
$merge_pcmake = $_REQUEST['merge_pcmake'];
$sreq_id = $_REQUEST['sreq_id'];






$rs_find_pc = "SELECT * FROM pc_owner WHERE pcname LIKE '%$searchterm%' OR pccompany LIKE '%$searchterm%' OR pcemail LIKE '%$searchterm%' OR pcphone LIKE '%$searchterm%' OR pccellphone LIKE '%$searchterm%' OR pcworkphone LIKE '%$searchterm%' LIMIT 25";
$rs_result_item = mysqli_query($rs_connect, $rs_find_pc);

echo "<h3>".pcrtlang("Return PC/Customer Search Results")."</h3>";

echo "<form action=pc.php?func=searchreturnpcsreq method=POST data-ajax=\"false\">";
echo pcrtlang("Return Asset/Device Search").": <input type=text name=searchterm  value=\"$searchterm\">";
echo "<input type=hidden name=merge_custname value=\"$merge_custname\">";
echo "<input type=hidden name=merge_custcompany value=\"$merge_custcompany\">";
echo "<input type=hidden name=merge_custphone value=\"$merge_custphone\">";
echo "<input type=hidden name=merge_custemail value=\"$merge_custemail\">";
echo "<input type=hidden name=merge_custworkphone value=\"$merge_custworkphone\">";
echo "<input type=hidden name=merge_custcellphone value=\"$merge_custcellphone\">";
echo "<input type=hidden name=merge_custaddress1 value=\"$merge_custaddress1\">";
echo "<input type=hidden name=merge_custaddress2 value=\"$merge_custaddress2\">";
echo "<input type=hidden name=merge_custcity value=\"$merge_custcity\">";
echo "<input type=hidden name=merge_custstate value=\"$merge_custstate\">";
echo "<input type=hidden name=merge_custzip value=\"$merge_custzip\">";
echo "<input type=hidden name=merge_probdesc value=\"$merge_probdesc\">";
echo "<input type=hidden name=merge_pcmake value=\"$merge_pcmake\">";
echo "<input type=hidden name=sreq_id value=\"$sreq_id\">";

echo "<input type=submit  value=\"".pcrtlang("Search Again")."\">";
echo "</form>";
echo "<br>";
if (mysqli_num_rows($rs_result_item) == "0") {
echo "<br>".pcrtlang("No Items Found")."...<br><br>";
}

while($rs_result_item_q = mysqli_fetch_object($rs_result_item)) {
$pcname = "$rs_result_item_q->pcname";
$pccompany = "$rs_result_item_q->pccompany";
$pcid2 = "$rs_result_item_q->pcid";
$pcmake = "$rs_result_item_q->pcmake";
$pcphone = "$rs_result_item_q->pcphone";
$pcworkphone = "$rs_result_item_q->pcworkphone";
$pccellphone = "$rs_result_item_q->pccellphone";
$pcemail = "$rs_result_item_q->pcemail";
$pcaddress = "$rs_result_item_q->pcaddress";
$pcaddress2 = "$rs_result_item_q->pcaddress2";
$pccity = "$rs_result_item_q->pccity";
$pcstate = "$rs_result_item_q->pcstate";
$pczip = "$rs_result_item_q->pczip";

echo "<table class=standard>";
echo "<tr><th>".pcrtlang("Customer").": $pcname</th></tr>";

echo "<tr><td>".pcrtlang("Asset/Customer ID").": $pcid2</td></tr>";

if("$pccompany" != "") {
echo "<tr><td>".pcrtlang("Company").": $pccompany</td></tr>";
}

if("$pcemail" != "") {
echo "<tr><td>".pcrtlang("Email").": $pcemail</td></tr>";
}



echo "<tr><td>".pcrtlang("Device").": $pcmake</td></tr>";

echo "<tr><td>";
###
if($pcaddress != "") {
$pcaddressbr = nl2br($pcaddress);
echo "<table><tr><td style=\"border-radius:3px;background:#333333;\"><i class=\"fa fa-map-marker fa-lg fa-fw\" style=\"color:white;\"></i></td><td>$pcaddressbr<br>";
if($pcaddress2 != "") {
echo "$pcaddress2<br>";
}
echo "$pccity, $pcstate $pczip";
echo "</td></tr></table>";
}

echo "<br>";

if (($pcphone != "") || ($pcworkphone != "") || ($pccellphone != "")) {

echo "<table><tr><td style=\"border-radius:3px;background:#333333;\"><i class=\"fa fa-phone fa-lg fa-fw\" style=\"color:white;\"></i></td><td>";

echo "<table style=\"border-collapse:collapse;margin:0px;padding:0px;width:100%;\">";

if($pcphone != "") {
echo "<tr><td style=\"text-align:right\">";
echo "&nbsp;".pcrtlang("Home").": </td><td>$pcphone";
echo "</td></tr>";
}

if($pccellphone != "") {
echo "<tr><td style=\"text-align:right\">";
echo "&nbsp;".pcrtlang("Mobile").": </td><td>$pccellphone";
echo "</td></tr>";
}

if($pcworkphone != "") {
echo "</td><td style=\"text-align:right\">";
echo "&nbsp;".pcrtlang("Work").": </td><td>$pcworkphone";
echo "</td></tr>";
}
echo "</table>";
echo "</td></tr></table>";
}


##

echo "</td></tr></table>";

echo "</td></tr>";
echo "<tr><td>";

echo "<form action=pc.php?func=returnpc2 method=post data-ajax=\"false\">";
echo "<input type=hidden name=pcid value=\"$pcid2\">";
echo "<input type=hidden name=merge_custname value=\"$merge_custname\">";
echo "<input type=hidden name=merge_custcompany value=\"$merge_custcompany\">";
echo "<input type=hidden name=merge_custphone value=\"$merge_custphone\">";
echo "<input type=hidden name=merge_custemail value=\"$merge_custemail\">";
echo "<input type=hidden name=merge_custworkphone value=\"$merge_custworkphone\">";
echo "<input type=hidden name=merge_custcellphone value=\"$merge_custcellphone\">";
echo "<input type=hidden name=merge_custaddress1 value=\"$merge_custaddress1\">";
echo "<input type=hidden name=merge_custaddress2 value=\"$merge_custaddress2\">";
echo "<input type=hidden name=merge_custcity value=\"$merge_custcity\">";
echo "<input type=hidden name=merge_custstate value=\"$merge_custstate\">";
echo "<input type=hidden name=merge_custzip value=\"$merge_custzip\">";
echo "<input type=hidden name=merge_probdesc value=\"$merge_probdesc\">";
echo "<input type=hidden name=merge_pcmake value=\"$merge_pcmake\">";
echo "<input type=hidden name=sreq_id value=\"$sreq_id\">";
echo "<input type=submit  value=\"".pcrtlang("Check-in and Process Service Request")."\">";

echo "</form>";
echo "</td></tr></table><br>";

}



require_once("footer.php");

}




function addd7note() {
require_once("validate.php");
require("deps.php");
require("common.php");
require("d7spec.php");

$woid = $_REQUEST['woid'];
$notetype = 0;
$attach_filename = $_REQUEST['attach_filename'];
$thenote = pv(pullactivity("$attach_filename"));

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

userlog(4,$woid,'woid','');

if("$thenote" != "") {




$rs_insert_group = "INSERT INTO wonotes (notetype,thenote,noteuser,notetime,woid) VALUES ('$notetype','$thenote','$ipofpc','$currentdatetime','$woid')";
@mysqli_query($rs_connect, $rs_insert_group);
$fademessage = urlencode(pcrtlang("Notes found and imported."));
$fademessagetype = "success";
} else {
$fademessagetype = "error";
$fademessage = urlencode(pcrtlang("No Notes could be found."));
}

header("Location: index.php?pcwo=$woid&fademessage=$fademessage&fademessagetype=$fademessagetype");

}



function addnote2() {
require_once("validate.php");
require("deps.php");
require("common.php");


$woid = $_REQUEST['woid'];
$notetype = $_REQUEST['notetype'];
$thenote = pv($_REQUEST['thenote']);
$touch = $_REQUEST['touch'];



if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

userlog(4,$woid,'woid','');





$rs_insert_group = "INSERT INTO wonotes (notetype,thenote,noteuser,notetime,woid) VALUES ('$notetype','$thenote','$ipofpc','$currentdatetime','$woid')";
@mysqli_query($rs_connect, $rs_insert_group);

if(!array_key_exists('ajaxcall', $_REQUEST)) {
if("$touch" != "touch") {
header("Location: index.php?pcwo=$woid&scrollto=pcnotes$notetype");
} else {
header("Location: touch.php?func=notes&woid=$woid");
}
} else {
###

require("ajaxcalls.php");
loadwonotes("$woid","$notetype","$gomodal");

###
}

}


function editnote() {
require_once("validate.php");
require("deps.php");


require_once("common.php");
require("dheader.php");


$woid = $_REQUEST['woid'];
$noteid = $_REQUEST['noteid'];





$rs_findpc = "SELECT * FROM wonotes WHERE noteid = '$noteid'";
$rs_result = mysqli_query($rs_connect, $rs_findpc);
$rs_result_q = mysqli_fetch_object($rs_result);
$thenote = "$rs_result_q->thenote";
$notetype = "$rs_result_q->notetype";


if($notetype == 0) {
$notemsg = "Edit Customer Note";
} else {
$notemsg = "Edit Technician Note";
}

echo "<div data-role=\"header\" data-theme=\"b\"><h2>$notemsg</h2></div>";
echo "<div class=\"ui-content\" role=\"main\">";


echo "<form action=pc.php?func=editnote2 method=post data-ajax=\"false\"><input type=hidden name=noteid value=\"$noteid\">";
echo pcrtlang("Note").":<textarea name=thenote required=required>$thenote</textarea>";

echo "<input type=hidden name=woid value=$woid><input type=hidden name=notetype value=$notetype>";


echo "<br><button type=button onclick=\"this.disabled=true; this.form.submit();\" data-theme=\"b\"><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button>";

echo "</div>";
require_once("dfooter.php");




}


function editnote2() {

require_once("validate.php");
require("deps.php");
require("common.php");


$woid = $_REQUEST['woid'];
$thenote = pv($_REQUEST['thenote']);
$noteid = pv($_REQUEST['noteid']);
$notetype = pv($_REQUEST['notetype']);




$rs_insert_group = "UPDATE wonotes SET thenote = '$thenote' WHERE noteid = '$noteid'";
@mysqli_query($rs_connect, $rs_insert_group);

header("Location: index.php?pcwo=$woid#notes");

}


function deletenote() {
require_once("validate.php");
require("deps.php");
require("common.php");


$woid = $_REQUEST['woid'];
$noteid = $_REQUEST['noteid'];
$notetype = $_REQUEST['notetype'];




$rs_del_note = "DELETE FROM wonotes WHERE noteid = '$noteid'";
@mysqli_query($rs_connect, $rs_del_note);


if(!array_key_exists('ajaxcall', $_REQUEST)) {
header("Location: index.php?pcwo=$woid#notes");
} else {
###

require("ajaxcalls.php");
loadwonotes("$woid","$notetype","$gomodal");

###
}



}


function convertnote() {
require_once("validate.php");
require("deps.php");
require("common.php");


$woid = $_REQUEST['woid'];
$noteid = pv($_REQUEST['noteid']);
$notetype = pv($_REQUEST['notetype']);
$touch = pv($_REQUEST['touch']);




$rs_convert = "UPDATE wonotes SET notetype = '$notetype' WHERE noteid = '$noteid'";
@mysqli_query($rs_connect, $rs_convert);

header("Location: index.php?pcwo=$woid#notes");

}


function worenotify() {
require_once("validate.php");
require("deps.php");
require("common.php");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}


$woid = $_REQUEST['woid'];





$rs_findpc = "SELECT * FROM pc_wo WHERE woid = '$woid'";
$rs_result = mysqli_query($rs_connect, $rs_findpc);
$rs_result_q = mysqli_fetch_object($rs_result);
$pcid = "$rs_result_q->pcid";
$probdesc = "$rs_result_q->probdesc";
$uname = "$rs_result_q->assigneduser";

$rs_findowner = "SELECT * FROM pc_owner WHERE pcid = '$pcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
$rs_result_q2 = mysqli_fetch_object($rs_result2);
$pcname = "$rs_result_q2->pcname";
$pcphone = "$rs_result_q2->pcphone";
$pccellphone = "$rs_result_q2->pccellphone";
$pcworkphone = "$rs_result_q2->pcworkphone";
$pcmake = "$rs_result_q2->pcmake";
$pcemail = "$rs_result_q2->pcemail";
$pcaddress = "$rs_result_q2->pcaddress";
$pcaddress2 = "$rs_result_q2->pcaddress2";
$pccity = "$rs_result_q2->pccity";
$pcstate = "$rs_result_q2->pcstate";
$pczip = "$rs_result_q2->pczip";

if(array_key_exists('notifyuseremail', $_REQUEST)) {
require_once("sendenotify.php");
$from = getuseremail("$uname");
$to = $from;
if ($from != "") {
$subject = pcrtlang("Work Order Assignment Reminder");
$plaintext ="$pcname\n$pcaddress\n$pcaddress2\n$pccity, $pcstate $pczip\n\n".pcrtlang("Home Phone").":\t$pcphone\n".pcrtlang("Cell Phone").":\t$pccellphone\n".pcrtlang("Work Phone").":\t$pcworkphone";$plaintext .= "\n\n".pcrtlang("Email").": $pcemail\n\n".pcrtlang("Device").": $pcmake\n\n".pcrtlang("Problem").":\n$probdesc\n".pcrtlang("Work Order")." #$woid\n";
$sreq_problem2 = nl2br($probdesc);
$htmltext ="<b>$pcname</b><br>$pcaddress<br>$pcaddress2<br>$pccity, $pcstate $pczip<br><br><b>".pcrtlang("Home Phone").":</b>$pcphone<br><b>".pcrtlang("Cell_Phone").":</b>$pccellphone<br><b>".pcrtlang("Work Phone").":</b>$pcworkphone";
$htmltext .= "<br><br><b>".pcrtlang("Email")."</b>:$pcemail<br><br><b>".pcrtlang("Device").":</b> $pcmake<br><br><b>".pcrtlang("Problem").":</b><br>$sreq_problem2<br><br><b>".pcrtlang("Work Order")."</b> #$woid<br><br>";
sendenotify("$from","$to","$subject","$plaintext","$htmltext");
}
}

if(array_key_exists('notifyusersms', $_REQUEST)) {
require_once("smsnotify.php");
$smsname  = $pcname;
$usermobile = getusersmsnumber("$uname");
if($usermobile != "") {
$smsmessage = pcrtlang("Work Order Assignment Reminder")." - $pcname - ".pcrtlang("Work Order")." #$woid";
smssend("$usermobile","$smsmessage");
}
}

header("Location: index.php?pcwo=$woid#workorderinfo");

}




function addassetonly() {
require_once("dheader.php");
require("deps.php");

echo "<div data-role=\"header\" data-theme=\"b\"><h2>".pcrtlang("Add New Asset/Device")."</h2></div>";
echo "<div class=\"ui-content\" role=\"main\">";

echo "<form action=pc.php?func=addassetonly2 method=post data-ajax=\"false\">";
echo pcrtlang("Customer Name")."<input type=text name=pcname required=required onFocus=\"this.form.submitbutton.disabled=false;this.form.submitbutton.value='".pcrtlang("Save")."';\">";


echo "<input type=submit id=submitbutton value=\"".pcrtlang("Save")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Saving")."...'; this.form.submit();\"  data-theme=\"b\">";

echo "</div>";

require_once("dfooter.php");

}

function addassetonly2() {
require_once("validate.php");
require("deps.php");
require("common.php");


$pcname = pv($_REQUEST['pcname']);

if ($pcname == "") { die("Please go back and enter the a name"); }





$rs_insert_group = "INSERT INTO pc_owner (pcname) VALUES ('$pcname')";
@mysqli_query($rs_connect, $rs_insert_group);

$pcid = mysqli_insert_id($rs_connect);

header("Location: pc.php?func=editowner&pcid=$pcid&woid=0&nomodal=0");

}


function pullsubasset() {
require_once("validate.php");
require("deps.php");
require("common.php");

$assettype = $_REQUEST['assettype'];




$rs_findassets = "SELECT * FROM mainassettypes WHERE mainassettypeid = '$assettype'";
$rs_result2 = mysqli_query($rs_connect, $rs_findassets);
$rs_result_q2 = mysqli_fetch_object($rs_result2);
$subassetlist = serializedarraytest("$rs_result_q2->subassetlist");



if(count($subassetlist) > 0) {

reset($subassetlist);

echo "<fieldset data-role=\"controlgroup\">";

foreach($subassetlist as $key => $val) {

$image = $custassets[$val];

echo "<input type=checkbox id=\"$val\" value=\"$val\" name=\"assets[]\"><label for=\"$val\"><img src=../repair/images/assets/$image align=absmiddle> ".pcrtlang("$val")."</input></label>";
}

echo "</fieldset>";

echo "<input type=text placeholder=\"".pcrtlang("Enter Additional Asset Accessory")."\" name=\"assets[]\">";


} else {
echo pcrtlang("not applicable")."<input type=hidden name=\"assets[]\">";
}

?>
<script>
$('#subassets').enhanceWithin('create');
</script>
<?php


}




function pullsubassetedit() {
require_once("validate.php");
require("deps.php");
require("common.php");

$assettype = $_REQUEST['assettype'];
$woid = $_REQUEST['woid'];





$rs_findassets = "SELECT * FROM mainassettypes WHERE mainassettypeid = '$assettype'";
$rs_result2 = mysqli_query($rs_connect, $rs_findassets);
$rs_result_q2 = mysqli_fetch_object($rs_result2);
$subassetlist = serializedarraytest("$rs_result_q2->subassetlist");


$rs_findpc = "SELECT * FROM pc_wo WHERE woid = '$woid'";
$rs_result = mysqli_query($rs_connect, $rs_findpc);
$rs_result_q = mysqli_fetch_object($rs_result);
$custassetsindb = serializedarraytest("$rs_result_q->custassets");



if(count($subassetlist) > 0) {

reset($subassetlist);

echo "<fieldset data-role=\"controlgroup\">";

foreach($subassetlist as $key => $val) {
$image = $custassets[$val];

if (in_array("$val",$custassetsindb)) {
echo "<input type=checkbox id=\"$val\" value=\"$val\" name=\"assets[]\" checked><label for=\"$val\"><img src=../repair/images/assets/$image align=absmiddle> ".pcrtlang("$val")."</label>";
} else {
echo "<input type=checkbox id=\"$val\" value=\"$val\" name=\"assets[]\"><label for=\"$val\"><img src=../repair/images/assets/$image align=absmiddle> ".pcrtlang("$val")."</label>";
}


}

foreach($custassetsindb as $key => $val) {
if (!in_array($val,$subassetlist)) {
echo "<input type=checkbox checked id=\"$key\" value=\"$val\" name=\"assets[]\"><label for=\"$key\"><img src=../repair/images/admin.png align=absmiddle> $val</label>";
}
}

echo "<input type=text name=\"assets[]\" placeholder=\"".pcrtlang("Enter Additional Asset Accessory")."\">";

echo "</fieldset>";

} else {
echo pcrtlang("not applicable")."<input type=hidden name=\"assets[]\">";
}

?>
<script>
$('#subassets').enhanceWithin('create');
</script>
<?php


}




function pullinfofields() {
require_once("validate.php");
require("deps.php");
require("common.php");

$assettype = $_REQUEST['assettype'];








$allassetinfofields = array();

$rs_allfindassets = "SELECT * FROM mainassetinfofields";
$rs_result2all = mysqli_query($rs_connect, $rs_allfindassets);
while ($rs_result_q2all = mysqli_fetch_object($rs_result2all)) {
$mainassetfieldid = "$rs_result_q2all->mainassetfieldid";
$mainassetfieldname = "$rs_result_q2all->mainassetfieldname";
$allassetinfofields[$mainassetfieldid] = "$mainassetfieldname";
}


$rs_findassets = "SELECT * FROM mainassettypes WHERE mainassettypeid = '$assettype'";
$rs_result2 = mysqli_query($rs_connect, $rs_findassets);
$rs_result_q2 = mysqli_fetch_object($rs_result2);
$assetinfofields = serializedarraytest("$rs_result_q2->assetinfofields");


reset($assetinfofields);

if(count($assetinfofields) > 0) {


echo "<h3>".pcrtlang("Other Asset/Device Info")."</h3>";
foreach($assetinfofields as $key => $val) {
echo "$allassetinfofields[$val]:";
echo "<input type=text name=custompcinfo[$val]>";
}

} else {
echo "<input type=hidden name=\"custompcinfo[]\">";
}


?>
<script>
$('#assetinfofields').enhanceWithin('create');
</script>
<?php




}


function pullinfofieldsedit() {
require_once("validate.php");
require("deps.php");
require("common.php");

$assettype = $_REQUEST['assettype'];
$pcid = $_REQUEST['pcid'];

if (array_key_exists("attach_filename", $_REQUEST)) {
$attach_filename = $_REQUEST['attach_filename'];
require("d7spec.php");
$specarray = pullspec("$attach_filename");
}


if (array_key_exists("attach_filenameuvk", $_REQUEST)) {
$attach_filename = $_REQUEST['attach_filenameuvk'];
require("uvkspec.php");
$specarray = pullspec("$attach_filename");
}



$allassetinfofields = array();

$rs_allfindassets = "SELECT * FROM mainassetinfofields";
$rs_result2all = mysqli_query($rs_connect, $rs_allfindassets);
while ($rs_result_q2all = mysqli_fetch_object($rs_result2all)) {
$mainassetfieldid = "$rs_result_q2all->mainassetfieldid";
$mainassetfieldname = "$rs_result_q2all->mainassetfieldname";
$matchword = "$rs_result_q2all->matchword";
$allassetinfofields[$mainassetfieldid] = "$mainassetfieldname";
$matchfields[$mainassetfieldid] = "$matchword"; 
}


$rs_findassets = "SELECT * FROM mainassettypes WHERE mainassettypeid = '$assettype'";
$rs_result2 = mysqli_query($rs_connect, $rs_findassets);
$rs_result_q2 = mysqli_fetch_object($rs_result2);
$assetinfofields = serializedarraytest("$rs_result_q2->assetinfofields");


$rs_pcinfo = "SELECT pcextra FROM pc_owner WHERE pcid = '$pcid'";
$rs_resultpc = mysqli_query($rs_connect, $rs_pcinfo);
$rs_result_pcq = mysqli_fetch_object($rs_resultpc);
$pcextraindb = serializedarraytest("$rs_result_pcq->pcextra");


reset($assetinfofields);

if(count($assetinfofields) > 0) {
echo "<h3>".pcrtlang("Other Asset/Device Info")."</h3>";
foreach($assetinfofields as $key => $val) {
echo "$allassetinfofields[$val]:";

#specarray
if(isset($specarray)) {
if(array_key_exists("$matchfields[$val]", $specarray)) {
#matchfields id> keyword
#specarray = keyword > value
$thekeyword = $matchfields[$val];
echo "<input type=text  name=custompcinfo[$val] value=\"$specarray[$thekeyword]\">";
} elseif (array_key_exists("$val", $pcextraindb)) {
echo "<input type=text  name=custompcinfo[$val] value=\"".pf("$pcextraindb[$val]")."\">";
} else {
echo "<input type=text  name=custompcinfo[$val]>";
}
} else {
if(array_key_exists("$val", $pcextraindb)) {
echo "<input type=text  name=custompcinfo[$val] value=\"".pf("$pcextraindb[$val]")."\">";
} else {
echo "<input type=text  name=custompcinfo[$val]>";
}
}


}

} else {
echo "<input type=hidden name=\"custompcinfo[]\">";
}

?>
<script>
$('#assetinfofields').enhanceWithin('create');
</script>
<?php

}




function timerstart() {
require_once("validate.php");
require("deps.php");
require("common.php");


if (array_key_exists('woid',$_REQUEST)) {
$woid = $_REQUEST['woid'];
} else {
$woid = "0";
}

if (array_key_exists('pcgroupid',$_REQUEST)) {
$pcgroupid = $_REQUEST['pcgroupid'];
} else {
$pcgroupid = "0";
}

if (array_key_exists('blockcontractid',$_REQUEST)) {
$blockcontractid = $_REQUEST['blockcontractid'];
$savedround = $_REQUEST['savedround'];
} else {
$blockcontractid = "0";
$savedround = "0";
}


$woid = pv("$woid");
$pcgroupid = pv("$pcgroupid");
$blockcontractid = pv("$blockcontractid");

$timername = pv($_REQUEST['timername']);

if("$timername" == "") {
$timername = "(".pcrtlang("no description").")";
}

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');




$rs_insert_timer = "INSERT INTO timers (timerdesc,timerstart,woid,byuser,pcgroupid,blockcontractid,savedround) VALUES ('$timername','$currentdatetime','$woid','$ipofpc','$pcgroupid','$blockcontractid','$savedround')";
@mysqli_query($rs_connect, $rs_insert_timer);

if($woid != "0") {
header("Location: index.php?pcwo=$woid#timer");
} else {
header("Location: group.php?func=viewgroup&groupview=blockcontract&pcgroupid=$pcgroupid#botc");
}


}

function timerstartmanual() {
require_once("validate.php");
require("deps.php");
require("common.php");


if (array_key_exists('woid',$_REQUEST)) {
$woid = $_REQUEST['woid'];
} else {
$woid = "0";
}

if (array_key_exists('pcgroupid',$_REQUEST)) {
$pcgroupid = $_REQUEST['pcgroupid'];
} else {
$pcgroupid = "0";
}

if (array_key_exists('blockcontractid',$_REQUEST)) {
$blockcontractid = $_REQUEST['blockcontractid'];
} else {
$blockcontractid = "0";
}


$woid = pv("$woid");
$pcgroupid = pv("$pcgroupid");
$blockcontractid = pv("$blockcontractid");



if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');




$rs_insert_timer = "INSERT INTO timers (timerstart,timerstop,woid,byuser,pcgroupid,blockcontractid,savedround) VALUES ('$currentdatetime','$currentdatetime','$woid','$ipofpc','$pcgroupid','$blockcontractid','$savedround')";
@mysqli_query($rs_connect, $rs_insert_timer);

$timerid = mysqli_insert_id($rs_connect);

header("Location: pc.php?func=timeredit&woid=$woid&timerid=$timerid&pcgroupid=$pcgroupid");
}


function timerstop() {
require_once("validate.php");
require("deps.php");
require("common.php");

if (array_key_exists('woid',$_REQUEST)) {
$woid = $_REQUEST['woid'];
} else {
$woid = "0";
}

if (array_key_exists('pcgroupid',$_REQUEST)) {
$pcgroupid = $_REQUEST['pcgroupid'];
} else {
$pcgroupid = "0";
}

if (array_key_exists('blockcontractid',$_REQUEST)) {
$blockcontractid = $_REQUEST['blockcontractid'];
} else {
$blockcontractid = "0";
}


$woid = pv("$woid");
$pcgroupid = pv("$pcgroupid");
$blockcontractid = pv("$blockcontractid");


$timerid = pv($_REQUEST['timerid']);

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');




$rs_stop_timer = "UPDATE timers SET timerstop = '$currentdatetime' WHERE timerid = '$timerid'";
@mysqli_query($rs_connect, $rs_stop_timer);

if($blockcontractid != 0) {
updatehours($blockcontractid);
}


if($woid != "0") {
header("Location: index.php?pcwo=$woid#timer");
} else {
header("Location: group.php?func=viewgroup&groupview=blockcontract&pcgroupid=$pcgroupid#botc");
}

}



function timerdelete() {
require_once("validate.php");
require("deps.php");
require("common.php");

if (array_key_exists('woid',$_REQUEST)) {
$woid = $_REQUEST['woid'];
} else {
$woid = "0";
}

if (array_key_exists('pcgroupid',$_REQUEST)) {
$pcgroupid = $_REQUEST['pcgroupid'];
} else {
$pcgroupid = "0";
}


if (array_key_exists('blockcontractid',$_REQUEST)) {
$blockcontractid = $_REQUEST['blockcontractid'];
} else {
$blockcontractid = "0";
}


$woid = pv("$woid");
$pcgroupid = pv("$pcgroupid");
$blockcontractid = pv("$blockcontractid");


$timerid = pv($_REQUEST['timerid']);




$rs_delete_timer = "DELETE FROM timers WHERE timerid = '$timerid'";
@mysqli_query($rs_connect, $rs_delete_timer);

if($blockcontractid != 0) {
updatehours($blockcontractid);
}


if($woid != "0") {
header("Location: index.php?pcwo=$woid#timer");
} else {
header("Location: group.php?func=viewgroup&groupview=blockcontract&pcgroupid=$pcgroupid#botc");
}

}



function timerbill() {
require_once("validate.php");
require("deps.php");
require("common.php");


$woid = pv($_REQUEST['woid']);
$timerid = $_REQUEST['timerid'];
$billtime = $_REQUEST['billtime'];
$billrate = $_REQUEST['billrate'];
$timerdesc = urlencode($_REQUEST['timerdesc']);




$rs_bill_timer = "UPDATE timers SET billedout = '1' WHERE timerid = '$timerid'";
@mysqli_query($rs_connect, $rs_bill_timer);

$laborprice = "$billrate";

header("Location: repcart.php?func=add_labor2&labordesc=$timerdesc&laborprice=$laborprice&pcwo=$woid&qty=$billtime");

}



function timerbillfirst() {

require_once("dheader.php");
require("deps.php");

$woid = pv($_REQUEST['woid']);
$timerid = $_REQUEST['timerid'];
$billtime = $_REQUEST['billtime'];
$timerdesc = htmlspecialchars($_REQUEST['timerdesc']);
$pcgroupid = $_REQUEST['pcgroupid'];

$labordec = mf(($billtime / 3600));

$roundarray = explode(".", "$labordec");

if(".$roundarray[1]" == 0) {
$minutes15 = "0";
} elseif((".$roundarray[1]" > 0) && (".$roundarray[1]" <= ".25")) {
$minutes15 = ".25";
} elseif((".$roundarray[1]" > ".25") && (".$roundarray[1]" <= ".5")) {
$minutes15 = ".5";
} elseif((".$roundarray[1]" > ".5") && (".$roundarray[1]" <= ".75")) {
$minutes15 = ".75";
} else {
$minutes15 = "1";
}

if(".$roundarray[1]" == 0) {
$minutes30 = "0";
} elseif((".$roundarray[1]" > 0) && (".$roundarray[1]" <= ".5")) {
$minutes30 = ".5";
} else {
$minutes30 = "1";
}

if(".$roundarray[1]" == 0) {
$minutes60 = "0";
} else {
$minutes60 = "1";
}


$r15 = $minutes15 + $roundarray['0'];
$r30 = $minutes30 + $roundarray['0'];
$r60 = $minutes60 + $roundarray['0'];
$r60d = $roundarray['0'];


echo "<div data-role=\"header\" data-theme=\"b\"><h2>".pcrtlang("Bill Hours")."</h2></div>";
echo "<div class=\"ui-content\" role=\"main\">";


echo pcrtlang("Labor Description").":";
echo "<form action=pc.php?func=timerbill&woid=$woid&timerid=$timerid method=post data-ajax=\"false\"><input type=text id=timerdesc name=timerdesc value=\"$timerdesc\">";

echo pcrtlang("Choose Bill Hours").":";
echo "<fieldset data-role=\"controlgroup\">";
if($r60d != 0) {
echo "<input type=radio id=\"r60d\" value=\"$r60d\" name=\"billtime\"><label for=\"r60d\">".pcrtlang("Round Down (hour)").": $r60d</input></label>";
}
echo "<input type=radio id=\"act\" value=\"$labordec\" name=\"billtime\"><label for=\"act\">".pcrtlang("Actual").": $labordec</input></label>";

if($r15 != $r30) {
echo "<input type=radio id=\"r15\" value=\"$r15\" name=\"billtime\"><label for=\"r15\">".pcrtlang("Round Up (15 min)").": $r15</input></label>";
}
if($r30 != $r60) {
echo "<input type=radio id=\"r30\" value=\"$r30\" name=\"billtime\"><label for=\"r30\">".pcrtlang("Round Up (half hour)").": $r30</input></label>";
}
echo "<input checked type=radio id=\"r60\" value=\"$r60\" name=\"billtime\"><label for=\"r60\">".pcrtlang("Round Up (hour)").": $r60</input></label>";

echo "</fieldset>";

echo "<tr><td>".pcrtlang("Choose Option").":<br>(".pcrtlang("or manually enter hourly rate").")</td><td>";

$rs_quicklabor2 = "SELECT * FROM quicklabor ORDER BY theorder DESC";
$rs_result_ql2  = mysqli_query($rs_connect, $rs_quicklabor2);

echo "<select name=pricepick id=stringall onchange='document.getElementById(\"billrate\").value=this.options[this.selectedIndex].value'>";
echo "<option value=\"0\">".pcrtlang("Choose").":</option>";
while($rs_result_qld2 = mysqli_fetch_object($rs_result_ql2)) {
$labordesc = "$rs_result_qld2->labordesc";
$laborprice = mf("$rs_result_qld2->laborprice");
$primero = substr("$labordesc", 0, 1);
if("$primero" != "-") {
echo "<option value=\"$laborprice\">$money$laborprice - $labordesc</option>";
} else {
$labordesc3 = substr("$labordesc", 1);
echo "<option value=\"0\" style=\"background:#000000;color:#ffffff;padding:1px;\">$labordesc3</option>";
}
}


echo pcrtlang("Hourly Rate").":";
echo "<input type=text id=billrate name=billrate placeholder=\"".pcrtlang("Enter Hourly Rate")."\">";
echo "<input type=submit value=\"".pcrtlang("Bill Hours")."\" data-theme=\"b\"></form>";

if($pcgroupid != 0) {

echo "<br><h3>".pcrtlang("Bill to Block of Time Contract")."</h3>";

$rs_findbc = "SELECT * FROM blockcontract WHERE pcgroupid = '$pcgroupid' AND contractclosed = '0'";
$rs_resultbc = mysqli_query($rs_connect, $rs_findbc);

$total_bc = mysqli_num_rows($rs_resultbc);

#pcrtedit

if($total_bc > 0) {

echo pcrtlang("Hours").": $labordec<br>";

echo "<form action=blockcontract.php?func=billtocontract method=post  data-ajax=\"false\"><input type=hidden name=woid value=\"$woid\">";
echo "<input type=hidden name=pcgroupid value=\"$pcgroupid\"><input type=hidden name=timerid value=\"$timerid\">";
echo "<select name=blockcontractid data-native-menu=\"false\">";

while($rs_result_qbc = mysqli_fetch_object($rs_resultbc)) {
$blockid = "$rs_result_qbc->blockid";
$blocktitle = "$rs_result_qbc->blocktitle";
$hourscache = "$rs_result_qbc->hourscache";
$blockstart = "$rs_result_qbc->blockstart";
echo "<option value=$blockid>$hourscache|$blockstart|$blocktitle</option>";
}
echo "</select>";
echo "<input type=submit value=\"".pcrtlang("Bill Hours")."\" data-theme=\"b\"></form>";


} else {
echo "<a href=blockcontract.php?func=newcontract&pcgroupid=$pcgroupid><img src=../repair/images/wohistory.png border=0 align=absmiddle width=24> ".
pcrtlang("New Block of Time Contract")."</a>&nbsp;";

}



}

echo "</div>";
require_once("dfooter.php");


}


function timeredit() {

require_once("dheader.php");
require("deps.php");

if (array_key_exists('woid',$_REQUEST)) {
$woid = $_REQUEST['woid'];
} else {
$woid = "0";
}

if (array_key_exists('pcgroupid',$_REQUEST)) {
$pcgroupid = $_REQUEST['pcgroupid'];
} else {
$pcgroupid = "0";
}

if (array_key_exists('blockcontractid',$_REQUEST)) {
$blockcontractid = $_REQUEST['blockcontractid'];
} else {
$blockcontractid = "0";
}


$woid = pv("$woid");
$pcgroupid = pv("$pcgroupid");
$blockcontractid = pv("$blockcontractid");


$timerid = $_REQUEST['timerid'];

$rs_findtimers = "SELECT * FROM timers WHERE timerid = '$timerid'";
$rs_result_t = mysqli_query($rs_connect, $rs_findtimers);
$rs_result_qt = mysqli_fetch_object($rs_result_t);
$timerdesc = htmlspecialchars("$rs_result_qt->timerdesc");
$timerstart = "$rs_result_qt->timerstart";
$timerstop = "$rs_result_qt->timerstop";
$timerid = "$rs_result_qt->timerid";


echo "<div data-role=\"header\" data-theme=\"b\"><h2>".pcrtlang("Edit Timer")."</h2></div>";
echo "<div class=\"ui-content\" role=\"main\">";

echo pcrtlang("Labor Description").":";
echo "<form action=pc.php?func=timeredit2&woid=$woid&pcgroupid=$pcgroupid&timerid=$timerid method=post data-ajax=\"false\"><input type=text style=\"width:400px;\" name=timerdesc  value=\"$timerdesc\">";

$thestartdate = date("Y-m-d", strtotime($timerstart));
echo pcrtlang("Start Date/Time").":";
echo "<input type=date  name=startdate value=\"$thestartdate\">";
$starttime = date("g:i A", strtotime($timerstart));
picktime('starttime',"$starttime");

$thestopdate = date("Y-m-d", strtotime($timerstop));
echo pcrtlang("Stop Date/Time").":";
echo "<input id=\"stopday2\" type=date  name=stopdate value=\"$thestopdate\">";
$stoptime = date("g:i A", strtotime($timerstop));
picktime('stoptime',"$stoptime");


echo "<input type=hidden name=blockcontractid value=$blockcontractid><input type=submit value=\"".pcrtlang("Save")."\" data-theme=\"b\" ></form>";
echo "</div>";

require_once("dfooter.php");

}


function timeredit2() {
require_once("validate.php");
require("deps.php");
require("common.php");

if (array_key_exists('woid',$_REQUEST)) {
$woid = $_REQUEST['woid'];
} else {
$woid = "0";
}

if (array_key_exists('pcgroupid',$_REQUEST)) {
$pcgroupid = $_REQUEST['pcgroupid'];
} else {
$pcgroupid = "0";
}

if (array_key_exists('blockcontractid',$_REQUEST)) {
$blockcontractid = $_REQUEST['blockcontractid'];
} else {
$blockcontractid = "0";
}


$woid = pv("$woid");
$pcgroupid = pv("$pcgroupid");
$blockcontractid = pv("$blockcontractid");


$timerid = pv($_REQUEST['timerid']);

$startdate = $_REQUEST['startdate'];
$starttime = $_REQUEST['starttime'];
$stopdate = $_REQUEST['stopdate'];
$stoptime = $_REQUEST['stoptime'];
$timerdesc = pv($_REQUEST['timerdesc']);

$timerstart = date("Y-m-d H:i:s", strtotime("$startdate $starttime"));
$timerstop = date("Y-m-d H:i:s", strtotime("$stopdate $stoptime"));

$timerstart2 = strtotime("$startdate $starttime");
$timerstop2 = strtotime("$stopdate $stoptime");

if($timerstop2 < $timerstart2) {
die(pcrtlang("Error: Stop date cannot be earlier that start date."));
}





$rs_save_timer = "UPDATE timers SET timerdesc = '$timerdesc', timerstop = '$timerstop', timerstart = '$timerstart' WHERE timerid = '$timerid'";

@mysqli_query($rs_connect, $rs_save_timer);
$rs_save_timer2 = "UPDATE timers SET billedout = '0' WHERE timerid = '$timerid' AND blockcontractid = '0'";
@mysqli_query($rs_connect, $rs_save_timer2);

if($blockcontractid != 0) {
updatehours($blockcontractid);
}

if($woid != "0") {
header("Location: index.php?pcwo=$woid#timer");
} else {
header("Location: group.php?func=viewgroup&groupview=blockcontract&pcgroupid=$pcgroupid#botc");
}


}


function timereditprog() {

require_once("dheader.php");
require("deps.php");

if (array_key_exists('woid',$_REQUEST)) {
$woid = $_REQUEST['woid'];
} else {
$woid = "0";
}

if (array_key_exists('pcgroupid',$_REQUEST)) {
$pcgroupid = $_REQUEST['pcgroupid'];
} else {
$pcgroupid = "0";
}

if (array_key_exists('blockcontractid',$_REQUEST)) {
$blockcontractid = $_REQUEST['blockcontractid'];
} else {
$blockcontractid = "0";
}


$woid = pv("$woid");
$pcgroupid = pv("$pcgroupid");
$blockcontractid = pv("$blockcontractid");


$timerid = $_REQUEST['timerid'];

$rs_findtimers = "SELECT * FROM timers WHERE timerid = '$timerid'";
$rs_result_t = mysqli_query($rs_connect, $rs_findtimers);
$rs_result_qt = mysqli_fetch_object($rs_result_t);
$timerdesc = "$rs_result_qt->timerdesc";
$timerstart = "$rs_result_qt->timerstart";
$timerid = "$rs_result_qt->timerid";


echo "<div data-role=\"header\" data-theme=\"b\"><h2>".pcrtlang("Edit Timer")."</h2></div>";
echo "<div class=\"ui-content\" role=\"main\">";

echo pcrtlang("Labor Description").":";
echo "<form action=pc.php?func=timeredit2prog&woid=$woid&pcgroupid=$pcgroupid&timerid=$timerid method=post data-ajax=\"false\"><input type=text name=timerdesc  value=\"$timerdesc\">";

$thestartdate = date("Y-m-d", strtotime($timerstart));
echo pcrtlang("Start Date/Time").":";
echo "<input id=\"startday2\" type=date  name=startdate value=\"$thestartdate\">";
$starttime = date("g:i A", strtotime($timerstart));
picktime('starttime',"$starttime");




echo "<button type=button onclick=\"this.disabled=true; this.form.submit();\"  data-theme=\"b\"><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button></form>";
echo "</div>";

require_once("dfooter.php");

}

function timeredit2prog() {
require_once("validate.php");
require("deps.php");
require("common.php");

if (array_key_exists('woid',$_REQUEST)) {
$woid = $_REQUEST['woid'];
} else {
$woid = "0";
}

if (array_key_exists('pcgroupid',$_REQUEST)) {
$pcgroupid = $_REQUEST['pcgroupid'];
} else {
$pcgroupid = "0";
}

if (array_key_exists('blockcontractid',$_REQUEST)) {
$blockcontractid = $_REQUEST['blockcontractid'];
} else {
$blockcontractid = "0";
}


$woid = pv("$woid");
$pcgroupid = pv("$pcgroupid");
$blockcontractid = pv("$blockcontractid");


$timerid = pv($_REQUEST['timerid']);

$startdate = $_REQUEST['startdate'];
$starttime = $_REQUEST['starttime'];
$timerdesc = $_REQUEST['timerdesc'];

$timerstart = date("Y-m-d H:i:s", strtotime("$startdate $starttime"));




$rs_save_timer = "UPDATE timers SET timerdesc = '$timerdesc', timerstart = '$timerstart', billedout = '0' WHERE timerid = '$timerid'";
@mysqli_query($rs_connect, $rs_save_timer);

if($woid != "0") {
header("Location: index.php?pcwo=$woid#timer");
} else {
header("Location: group.php?func=viewgroup&groupview=blockcontract&pcgroupid=$pcgroupid#botc");
}

}




function callmap() {

require("headerempty.php");
require("deps.php");
require_once("common.php");

$woid = $_REQUEST['woid'];
$pcid = $_REQUEST['pcid'];






$rs_findowner = "SELECT * FROM pc_owner WHERE pcid = '$pcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
$rs_result_q2 = mysqli_fetch_object($rs_result2);
$pcname = "$rs_result_q2->pcname";
$pccompany = "$rs_result_q2->pccompany";
$pcphone = "$rs_result_q2->pcphone";
$pcemail = "$rs_result_q2->pcemail";
$pcaddress = "$rs_result_q2->pcaddress";
$pccellphone = "$rs_result_q2->pccellphone";
$pcworkphone = "$rs_result_q2->pcworkphone";
$pcaddress2 = "$rs_result_q2->pcaddress2";
$pccity = "$rs_result_q2->pccity";
$pcstate = "$rs_result_q2->pcstate";
$pczip = "$rs_result_q2->pczip";
$pcgroupid = "$rs_result_q2->pcgroupid";
$custsourceid = "$rs_result_q2->custsourceid";
$prefcontact = "$rs_result_q2->prefcontact";


$rs_findpc = "SELECT * FROM pc_wo WHERE woid = '$woid'";
$rs_result = mysqli_query($rs_connect, $rs_findpc);
$rs_result_q = mysqli_fetch_object($rs_result);
$probdesc = "$rs_result_q->probdesc";
$assigneduser = "$rs_result_q->assigneduser";
$sked = "$rs_result_q->sked";
$skeddate = "$rs_result_q->skeddate";



echo "<div class=printbar>";
echo "<button onClick=\"history.back()\" class=bigbutton><img src=../repair/images/left.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Return")."</button>";
echo "<font class=text30b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>";
echo "<button onClick=\"print();\" class=bigbutton><img src=../repair/images/print.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Print")."</button>";
echo "</div><br>";



echo "<table style=\"width:400px;margin-left:auto; margin-right:auto;\" align=center><tr><td>";
echo "<div style=\"border:1px #999999 solid; border-radius:5px;padding:5px;\">";
echo "<font class=text12b>$pcname</font>";
if("$pccompany" != "") {
echo "<br><font class=text12>$pccompany</font>";
}

echo "<br><br><font class=text12>$probdesc</font><br>";

if($sked == 1) {
$skeddate2 = date("M j, Y, g:i a",strtotime($skeddate));
echo "<br><font class=text10>".pcrtlang("Scheduled Date").":</font> <font class=text10b>$skeddate2</font>";
}

if ($assigneduser != "none") {
echo "<br><font class=text10>".pcrtlang("Assigned To").":</font><font class=text10b> $assigneduser</font>";
}

if ($pcaddress != "") {
echo "<br><font class=text10>$pcaddress</font>";
}

if ($pcaddress2 != "") {
echo "<br><font class=text10>$pcaddress2</font>";
}

if (($pccity != "") || ($pcstate != "") || ($pczip != "")){
echo "<br><font class=text10>$pccity, $pcstate $pczip</font>";
}

if ($pcphone != "") {
echo "<br><font class=text10>$pcphone</font>";
}
if ($pccellphone != "") {
echo "<br><font class=text10>$pccellphone</font>";
}
if ($pcworkphone != "") {
echo "<br><font class=text10>$pcworkphone</font>";
}

if ($pcemail != "") {
echo "<br><a href=\"mailto:$pcemail\">$pcemail</a>";
}


$pcaddy12 = urlencode($pcaddress);
$pcaddy22 = urlencode($pcaddress2);
$pccity2 = urlencode($pccity);
$pcstate2 = urlencode($pcstate);
$pczip2 = urlencode($pczip);
$pcphone2 = urlencode($pcphone);
$pcemail2 = urlencode($pcemail);
$pcname2 = urlencode($pcname);
$pccompany2 = urlencode($pccompany);

echo "</div>";

$storeinfoarray = getstoreinfo($defaultuserstore);
$storelocation = "$storeinfoarray[storeaddy1] $storeinfoarray[storecity] $storeinfoarray[storestate] $storeinfoarray[storezip]";


if (($pccity != "") && ($pcstate != "")) {

#gmap
?>

<script type="text/javascript">
$(function()
        {

$("#map1").gMap({ maptype: 'ROADMAP', markers: [{ address: "<?php echo "$pcaddress, $pccity, $pcstate $pczip"; ?>",
                              html: "<?php echo "$pcname<br>$pccompany<br>$pcaddress<br>$pcaddress2<br>$pccity, $pcstate $pczip"; ?>" }],
                  address: "<?php echo "$pcaddress, $pccity, $pcstate"; ?>",
                  zoom: 15 });

});
</script>




<br>
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
        destination:"<?php echo "$pcaddress, $pccity, $pcstate $pczip"; ?>",
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
        destination:"<?php echo "$pcaddress, $pccity, $pcstate $pczip"; ?>",
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




function addspo() {
require("deps.php");
require_once("common.php");

require("dheader.php");

$woid = $_REQUEST['woid'];


echo "<div data-role=\"header\" data-theme=\"b\"><h2>".pcrtlang("Add Special Order")."</h2></div>";
echo "<div class=\"ui-content\" role=\"main\">";

echo "<form action=pc.php?func=addspo2 method=post name=newinv data-ajax=\"false\">";
echo pcrtlang("Name of Part/Item").":<input type=text  name=spopartname>";

echo pcrtlang("Optional Printed Description").":<textarea name=spoprintdesc></textarea>";

echo pcrtlang("Quantity").":<input type=number name=spoqty min=1 step=1 value=1>";

?>

<script>
function markup() {
var marknum = Math.ceil((document.newinv.spocost.value - 0) * (document.newinv.chooser.value - 0)) - document.newinv.cents.value;
document.newinv.spoprice.value = marknum.toFixed(2);
}
</script>

<?php
echo pcrtlang("Selling Price").":$money<input size=10 type=text  name=spoprice id=spoprice>";

$usertaxid = getusertaxid();
$salestaxrateremain = (1 + getsalestaxrate($usertaxid));
if($salestaxrateremain != 1) {
echo "<button class=button type=button title=\"".pcrtlang("Pre-Tax Calculator")."\" onclick='document.getElementById(\"spoprice\").value=(document.getElementById(\"spoprice\").value / $salestaxrateremain).toFixed(5)'>
<i class=\"fa fa-calculator\"></i> ".pcrtlang("Calculate Pre-Tax")."</button>";
}


echo pcrtlang("Our Cost").":$money<input type=text  name=spocost>";

echo pcrtlang("Markup").": ";
echo "<select name=chooser onChange=\"markup()\">
<option value=\"1.0\"></option>
<option value=\"1.04\">4%</option>
<option value=\"1.1\">10%</option>
<option value=\"1.2\">20%</option>
<option value=\"1.3\">30%</option>
<option value=\"1.4\">40%</option>
<option value=\"1.5\">50%</option>
<option value=\"1.75\">75%</option>
<option value=\"2\">2X</option>
<option value=\"3\">3X</option>
<option value=\"5\">5X</option>
<option value=\"10\">10X</option>
</select>";

echo "<select name=cents onChange=\"markup()\" data-native-menu=\"false\">
<option value=\"0.10\">90 ".pcrtlang("cents")."</option>
<option value=\"0.05\">95 ".pcrtlang("cents")."</option>
<option selected value=\"0.01\">99 ".pcrtlang("cents")."</option>
<option value=\"00\">00 ".pcrtlang("cents")."</option>
</select>";



echo pcrtlang("Pick Supplier").":<select name=sposupplierid>";

echo "<option value=0>".pcrtlang("Manually Entered Supplier")."</option>";

$rs_find_suppliers = "SELECT * FROM suppliers ORDER BY suppliername ASC";
$rs_result_supp = mysqli_query($rs_connect, $rs_find_suppliers);

while($rs_result_suppq = mysqli_fetch_object($rs_result_supp)) {
$suppliername = "$rs_result_suppq->suppliername";
$supplierid = "$rs_result_suppq->supplierid";

echo "<option value=$supplierid>$suppliername</option>";

}
echo "</select><input type=hidden name=spowoid value=\"$woid\">";

echo pcrtlang("Supplier Name")."<input type=text  name=sposuppliername>";
echo pcrtlang("Supplier Part No.")."<input type=text  name=spopartnumber>";
echo pcrtlang("Part URL")."<input type=text  name=spoparturl>";
echo pcrtlang("Shipping Tracking Number")."<input type=text  name=spotracking>";
echo pcrtlang("Notes")."<input type=text  name=sponotes>";

echo pcrtlang("Status").":<select name=spostatus data-native-menu=\"false\">";
echo "<option value=0 selected>".pcrtlang("Awaiting Customer Approval")."</option>";
echo "<option value=8>".pcrtlang("Order Part")."</option>";
echo "<option value=1>".pcrtlang("On Order")."</option>";
echo "<option value=2>".pcrtlang("Received")."</option>";
echo "<option value=3>".pcrtlang("Installed")."</option>";
echo "<option value=4>".pcrtlang("Wrong Part")."</option>";
echo "<option value=5>".pcrtlang("Bad/Damaged Part")."</option>";
echo "<option value=6>".pcrtlang("Abandonded Part")."</option>";
echo "<option value=7>".pcrtlang("Unable to Locate Part")."</option>";
echo "<option value=9>".pcrtlang("Shipped")."</option>";
echo "</select>";


echo "<input type=submit value=\"".pcrtlang("Save")."\"  onclick=\"this.disabled=true;this.value='".pcrtlang("Saving")."...'; this.form.submit();\"  data-theme=\"b\">";


echo "</div>";
require_once("dfooter.php");


}




function addspo2() {
require_once("validate.php");

require("deps.php");
require("common.php");

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

$spopartname = pv($_REQUEST['spopartname']);
$spoprintdesc = pv($_REQUEST['spoprintdesc']);
$spounitprice = $_REQUEST['spoprice'];
$spounitcost = $_REQUEST['spocost'];
$spowoid = $_REQUEST['spowoid'];
$sposupplierid = pv($_REQUEST['sposupplierid']);
$sposuppliername = pv($_REQUEST['sposuppliername']);
$spopartnumber = pv($_REQUEST['spopartnumber']);
$spoparturl = pv($_REQUEST['spoparturl']);
$spotracking = pv($_REQUEST['spotracking']);
$spostatus = $_REQUEST['spostatus'];
$sponotes = pv($_REQUEST['sponotes']);
$spoqty = $_REQUEST['spoqty'];

userlog(36,$spowoid,'woid','');

$spoprice = $spounitprice * $spoqty;
$spocost = $spounitcost * $spoqty;

$rs_insert_so = "INSERT INTO specialorders (spopartname,spoprice,spocost,spowoid,sposupplierid,sposuppliername,spopartnumber,spoparturl,spotracking,spostatus,spodate,spostoreid,sponotes,unit_price,quantity,printdesc) VALUES ('$spopartname','$spoprice','$spocost','$spowoid','$sposupplierid','$sposuppliername','$spopartnumber','$spoparturl','$spotracking','$spostatus','$currentdatetime','$defaultuserstore','$sponotes','$spounitprice','$spoqty','$spoprintdesc')";
@mysqli_query($rs_connect, $rs_insert_so);
header("Location: index.php?pcwo=$spowoid#specialorders");

}


function editspo() {
require("deps.php");
require_once("common.php");

require("dheader.php");

$woid = $_REQUEST['spowoid'];
$spoid = $_REQUEST['spoid'];

$rs_find_so = "SELECT * FROM specialorders WHERE spoid = '$spoid'";
$rs_result_so = mysqli_query($rs_connect, $rs_find_so);

$rs_result_item_q = mysqli_fetch_object($rs_result_so);
$spoid = "$rs_result_item_q->spoid";
$spopartname = "$rs_result_item_q->spopartname";
$spoprintdesc = qf("$rs_result_item_q->printdesc");
$spoprice = mf("$rs_result_item_q->spoprice");
$spototalcost = mf("$rs_result_item_q->spocost");
$spowoid = "$rs_result_item_q->spowoid";
$sposupplierid = "$rs_result_item_q->sposupplierid";
$sposuppliername = pf("$rs_result_item_q->sposuppliername");
$spopartnumber = pf("$rs_result_item_q->spopartnumber");
$spoparturl = pf("$rs_result_item_q->spoparturl");
$spotracking = pf("$rs_result_item_q->spotracking");
$spostatus = "$rs_result_item_q->spostatus";
$sponotes = pf("$rs_result_item_q->sponotes");
$spounit_price = "$rs_result_item_q->unit_price";
$spoquantity = "$rs_result_item_q->quantity";

dheader(pcrtlang("Edit Special Order"));

echo "<form action=pc.php?func=editspo2 method=post name=newinv data-ajax=\"false\">";
echo pcrtlang("Name of Part/Item").":<input type=text name=spopartname value=\"$spopartname\">";

echo pcrtlang("Optional Printed Description").":<textarea class=textbox name=spoprintdesc>$spoprintdesc</textarea>";

?>

<script>
function markup() {
var marknum = Math.ceil((document.newinv.spocost.value - 0) * (document.newinv.chooser.value - 0)) - document.newinv.cents.value;
document.newinv.spoprice.value = marknum.toFixed(2);
}
</script>

<?php

$spocost = $spototalcost / $spoquantity;


echo pcrtlang("Quantity").":<input type=number name=spoquantity min=1 step=1 value=\"".qf("$spoquantity")."\">";


echo pcrtlang("Selling Price").":<input type=text name=spoprice value=\"$spoprice\">";
echo pcrtlang("Our Cost").":<input type=text name=spocost value=\"$spocost\">";

echo pcrtlang("Markup").":";
echo "<select name=chooser onChange=\"markup()\" data-native-menu=\"false\">
<option value=\"\">".pcrtlang("Choose Percentage")."</option>
<option value=\"1.04\">4%</option>
<option value=\"1.1\">10%</option>
<option value=\"1.2\">20%</option>
<option value=\"1.3\">30%</option>
<option value=\"1.4\">40%</option>
<option value=\"1.5\">50%</option>
<option value=\"1.75\">75%</option>
<option value=\"2\">2X</option>
<option value=\"3\">3X</option>
<option value=\"5\">5X</option>
<option value=\"10\">10X</option>
</select>";

echo "<select name=cents onChange=\"markup()\" data-native-menu=\"false\">
<option value=\"0.10\">90 ".pcrtlang("cents")."</option>
<option value=\"0.05\">95 ".pcrtlang("cents")."</option>
<option selected value=\"0.01\">99 ".pcrtlang("cents")."</option>
<option value=\"00\">00 ".pcrtlang("cents")."</option>
</select>";



echo pcrtlang("Pick Supplier").":<select name=sposupplierid value=\"$sposupplierid\">";

echo "<option value=0>".pcrtlang("Manually Entered Supplier")."</option>";

$rs_find_suppliers = "SELECT * FROM suppliers ORDER BY suppliername ASC";
$rs_result_supp = mysqli_query($rs_connect, $rs_find_suppliers);

while($rs_result_suppq = mysqli_fetch_object($rs_result_supp)) {
$suppliername = "$rs_result_suppq->suppliername";
$supplierid = "$rs_result_suppq->supplierid";

if($sposupplierid == $supplierid) {
echo "<option selected value=$supplierid>$suppliername</option>";
} else {
echo "<option value=$supplierid>$suppliername</option>";
}


}
echo "</select><input type=hidden name=spowoid value=\"$spowoid\"><input type=hidden name=spoid value=\"$spoid\">";

echo pcrtlang("Supplier Name")."<input type=text name=sposuppliername value=\"$sposuppliername\">";
echo pcrtlang("Supplier Part No.")."<input type=text name=spopartnumber value=\"$spopartnumber\">";
echo pcrtlang("Part URL")."<input type=text name=spoparturl value=\"$spoparturl\">";
echo pcrtlang("Shipping Tracking Number")."<input type=text name=spotracking value=\"$spotracking\">";
echo pcrtlang("Notes")."<input type=text name=sponotes value=\"$sponotes\">";

$statii = array(
0 => pcrtlang("Awaiting Customer Approval"),
8 => pcrtlang("Order Part"),
1 => pcrtlang("On Order"),
2 => pcrtlang("Received"),
3 => pcrtlang("Installed"),
4 => pcrtlang("Wrong Part"),
5 => pcrtlang("Bad/Damaged Part"),
6 => pcrtlang("Abandonded Part"),
7 => pcrtlang("Unable to Locate Part"),
9 => pcrtlang("Shipped")
);

echo pcrtlang("Status").":<select name=spostatus value=\"$spostatus\"  data-native-menu=\"false\">";

foreach($statii as $key => $val) {
if($key == $spostatus) {
echo "<option selected value=\"$key\">$val</option>";
} else {
echo "<option value=\"$key\">$val</option>";
}

}

echo "</select>";
echo "<input type=submit value=\"".pcrtlang("Save")."\"  onclick=\"this.disabled=true;this.value='".pcrtlang("Saving")."...'; this.form.submit();\" data-theme=\"b\">";


dfooter();
require_once("dfooter.php");


}




function editspo2() {
require_once("validate.php");

require("deps.php");
require("common.php");

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

$spoid = $_REQUEST['spoid'];
$spopartname = pv($_REQUEST['spopartname']);
$spoprintdesc = pv($_REQUEST['spoprintdesc']);
$spoprice = $_REQUEST['spoprice'];
$spocost = $_REQUEST['spocost'];
$spowoid = $_REQUEST['spowoid'];
$sposupplierid = pv($_REQUEST['sposupplierid']);
$sposuppliername = pv($_REQUEST['sposuppliername']);
$spopartnumber = pv($_REQUEST['spopartnumber']);
$spoparturl = pv($_REQUEST['spoparturl']);
$spotracking = pv($_REQUEST['spotracking']);
$spostatus = $_REQUEST['spostatus'];
$sponotes = pv($_REQUEST['sponotes']);





$rs_update_so = "UPDATE specialorders SET spopartname = '$spopartname', spoprice = '$spoprice', spocost = '$spocost', sposupplierid = '$sposupplierid', sposuppliername = '$sposuppliername', spopartnumber = '$spopartnumber', spoparturl = '$spoparturl', spotracking = '$spotracking', spostatus = '$spostatus', sponotes = '$sponotes', printdesc = '$spoprintdesc' WHERE spoid = '$spoid'";
@mysqli_query($rs_connect, $rs_update_so);
header("Location: index.php?pcwo=$spowoid#specialorders");

}


function deletespo() {
require_once("validate.php");

require("deps.php");
require("common.php");

$spoid = $_REQUEST['spoid'];
$spowoid = $_REQUEST['spowoid'];




$rs_update_so = "DELETE FROM specialorders WHERE spoid = '$spoid'";
@mysqli_query($rs_connect, $rs_update_so);
header("Location: index.php?pcwo=$spowoid#specialorders");
}





function addmiles() {
require_once("dheader.php");
require("deps.php");

$woid = $_REQUEST['woid'];
$addystring = $_REQUEST['addystring'];



echo "<div data-role=\"header\" data-theme=\"b\"><h2>".pcrtlang("Add to Mileage Log")."</h2></div>";
echo "<div class=\"ui-content\" role=\"main\">";

echo "<form action=pc.php?func=addmiles2 method=post data-ajax=\"false\">";
echo pcrtlang("Distance").":<br>";

if($pcrt_units != "METRIC") {
echo " miles";
} else {
echo " km";
}


echo "<input id=dist type=text name=miles required=required onFocus=\"this.form.submitbutton.disabled=false;this.form.submitbutton.value='".pcrtlang("Save")."';\">";


echo "<input type=hidden name=woid value=$woid>";

echo "<label><input type=\"checkbox\" name=\"roundtrip\">".pcrtlang("Round Trip")."</label>";


echo "<input  data-theme=\"b\" type=submit id=submitbutton value=\"".pcrtlang("Save")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Saving")."...'; this.form.submit();\">";


$storeinfoarray = getstoreinfo($defaultuserstore);
$storelocation = "$storeinfoarray[storeaddy1] $storeinfoarray[storecity] $storeinfoarray[storestate] $storeinfoarray[storezip]";


?>


<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script src="../repair/jq/gmap3.js" type="text/javascript"></script>


<script type="text/javascript">

$("#dist").gmap3({
  getdistance:{
    options:{
      origins:"<?php echo "$storelocation"; ?>",
        destinations:"<?php echo "$addystring"; ?>",
      travelMode: google.maps.TravelMode.DRIVING,
      unitSystem: google.maps.UnitSystem.IMPERIAL	
    },
    callback: function(results, status){
      var html = "";
      var html22 = "";
      if (results){
        for (var i = 0; i < results.rows.length; i++){
          var elements = results.rows[i].elements;
          for(var j=0; j<elements.length; j++){
            switch(elements[j].status){
              case "OK":
                html22 += elements[j].distance.value;

<?php 
if($pcrt_units != "METRIC") {
echo "html += (0.000621371 * html22).toFixed(1);"; 
} else {
echo "html += (0.001 * html22).toFixed(1);";
}

?>

                break;
              case "NOT_FOUND":
                html += "";
                break;
              case "ZERO_RESULTS":
                html += "";
                break;
            }
          }
        }
      } else {
        html = "error";
      }
      $("#dist").val( html );
    }
  }
});

</script>

<?php

echo "Map Data &copy; Google.";

echo "</div>";

require_once("dfooter.php");

}



function addmiles2() {
require_once("validate.php");

require("deps.php");
require("common.php");

$woid = $_REQUEST['woid'];
$miles2 = $_REQUEST['miles'];

if (array_key_exists('roundtrip',$_REQUEST)) {
$miles = $miles2 * 2;
} else {
$miles = $miles2;
}

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');




$rs_insert_tl = "INSERT INTO travellog (tlwo,tldate,tlmiles,traveluser) VALUES ('$woid','$currentdatetime','$miles','$ipofpc')";
@mysqli_query($rs_connect, $rs_insert_tl);
header("Location: index.php?pcwo=$woid#travellog");
}



function deletetl() {
require_once("validate.php");

require("deps.php");
require("common.php");

$tlid = $_REQUEST['tlid'];
$woid = $_REQUEST['woid'];




$rs_update_tl = "DELETE FROM travellog WHERE tlid = '$tlid'";
@mysqli_query($rs_connect, $rs_update_tl);
header("Location: index.php?pcwo=$woid#travellog");
}



function showworkorders() {
require_once("dheader.php");
require("deps.php");

dheader(pcrtlang("Work Orders"));

showpcs("no");

dfooter();
require("dfooter.php");
}


function switchdeposit() {

require("deps.php");
require("common.php");

$towhat = $_REQUEST['towhat'];
$depositid = pv($_REQUEST['depositid']);
$woid = pv($_REQUEST['woid']);

require_once("validate.php");

if($towhat == "invoice") {
$invoiceid = $_REQUEST['invoiceid'];
$switchdep = "UPDATE deposits SET invoiceid = '$invoiceid' WHERE depositid = '$depositid'";
@mysqli_query($rs_connect, $switchdep);
} elseif($towhat == "woid") {
$switchdep = "UPDATE deposits SET invoiceid = '0', woid = '$woid' WHERE depositid = '$depositid'";
@mysqli_query($rs_connect, $switchdep);
} else {
}


header("Location: index.php?pcwo=$woid#invoicing");
}




function adddeposittowo() {
require("deps.php");
require("common.php");
$depositid = pv($_REQUEST['depositid']);
$woid = pv($_REQUEST['woid']);
require_once("validate.php");
$switchdep = "UPDATE deposits SET woid = '$woid' WHERE depositid = '$depositid'";
@mysqli_query($rs_connect, $switchdep);
header("Location: index.php?pcwo=$woid#repaircart");
}


function removedepositfromwo() {
require("deps.php");
require("common.php");
$depositid = pv($_REQUEST['depositid']);
$woid = pv($_REQUEST['woid']);
require_once("validate.php");
$switchdep = "UPDATE deposits SET woid = '0' WHERE depositid = '$depositid'";
@mysqli_query($rs_connect, $switchdep);
header("Location: index.php?pcwo=$woid#repaircart");
}



function benchsheet() {
require_once("validate.php");
require("deps.php");
require("common.php");

$woid = $_REQUEST['woid'];

userlog(5,$woid,'woid','');


$rs_findpc = "SELECT * FROM pc_wo WHERE woid = '$woid'";
$rs_result = mysqli_query($rs_connect, $rs_findpc);
$rs_result_q = mysqli_fetch_object($rs_result);
$pcid = "$rs_result_q->pcid";
$probdesc = "$rs_result_q->probdesc";
$dropoff = "$rs_result_q->dropdate";
$pickup = "$rs_result_q->pickupdate";
$pcstatus = "$rs_result_q->pcstatus";
$custassetsindb2 = "$rs_result_q->custassets";
$rs_storeid = "$rs_result_q->storeid";
$thesigwo = "$rs_result_q->thesigwo";
$showsigrr = "$rs_result_q->showsigrr";
$thesigwotopaz = "$rs_result_q->thesigwotopaz";
$showsigrrtopaz = "$rs_result_q->showsigrrtopaz";
$wochecks = "$rs_result_q->wochecks";

$storeinfoarray = getstoreinfo($rs_storeid);
$theprobsindb2 = "$rs_result_q->commonproblems";

$theprobsindb = serializedarraytest($theprobsindb2);

$comprobarrayv = array();
$rs_chkscansv = "SELECT theproblem FROM commonproblems WHERE custviewable = '1'";
$rs_chkresult_sv = mysqli_query($rs_connect, $rs_chkscansv);
while($rs_chkresult_q_sv = mysqli_fetch_object($rs_chkresult_sv)) {
$theprobv = "$rs_chkresult_q_sv->theproblem";
array_push($comprobarrayv,"$theprobv");
}

$custassetsindb = serializedarraytest($custassetsindb2);

$rs_findowner = "SELECT * FROM pc_owner WHERE pcid = '$pcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
$rs_result_q2 = mysqli_fetch_object($rs_result2);
$pcname = "$rs_result_q2->pcname";
$pccompany = "$rs_result_q2->pccompany";
$pcphone = "$rs_result_q2->pcphone";
$pccellphone = "$rs_result_q2->pccellphone";
$pcworkphone = "$rs_result_q2->pcworkphone";
$pcmake = "$rs_result_q2->pcmake";
$pcemail = "$rs_result_q2->pcemail";
$pcaddress = "$rs_result_q2->pcaddress";
$pcaddress2 = "$rs_result_q2->pcaddress2";
$pccity = "$rs_result_q2->pccity";
$pcstate = "$rs_result_q2->pcstate";
$pczip = "$rs_result_q2->pczip";
$pcextra2 = "$rs_result_q2->pcextra";
$pcgroupid = "$rs_result_q2->pcgroupid";
$pcextra = serializedarraytest($pcextra2);
$mainassettypeidindb = "$rs_result_q2->mainassettypeid";

$pcemail2 = urlencode("$pcemail");

printableheader("$pcname");
echo "<table width=100%><tr><td width=60% valign=top><table class=printables><tr><th colspan=2><span class=sizeme20>$pcname</span></th></tr>";
if("$pccompany" != "") {
echo "<tr><td><font class=text12>".pcrtlang("Company").":</font></td><td><font class=text12b>$pccompany</font></td></tr>";
}
echo "<tr><td><font class=text12>".pcrtlang("Asset/Device ID").":</font></td><td><font class=textred16b>$pcid</font></td></tr>";
echo "<tr><td><font class=text12>".pcrtlang("Work Order ID").":</td><td><font class=text12b>$woid</font></td></tr>";

if($pcphone != "") {
echo "<tr><td><i class=\"fa fa-phone fa-lg fa-fw floatright\"></i></td><td><font class=text12b>$pcphone</font></td></tr>";
}

if($pccellphone != "") {
echo "<tr><td><i class=\"fa fa-mobile fa-lg fa-fw floatright\"></i></td><td><font class=text12b>$pccellphone</font></td></tr>";
}

if($pcworkphone != "") {
echo "<tr><td><i class=\"fa fa-briefcase fa-lg fa-fw floatright\"></i></td><td><font class=text12b>$pcworkphone</font></td></tr>";
}


if($pcemail != "") {
echo "<tr><td><i class=\"fa fa-envelope fa-lg fa-fw floatright\"></i></td><td><font class=text12b>$pcemail</font></td></tr>";
}

if($pcaddress != "") {
echo "<tr><td><i class=\"fa fa-map-marker fa-lg fa-fw floatright\"></i></td><td>$pcaddress";
if ($pcaddress2 != "") {
echo "<br>$pcaddress2";
}
echo "<br>$pccity, $pcstate $pczip</td></tr>";
}


echo "<tr><td><font class=text12>".pcrtlang("Make/Model").":</font></td><td><font class=text12b>$pcmake</font></td></tr>";

$allassetinfofields = array();

$rs_allfindassets = "SELECT * FROM mainassetinfofields WHERE showonrepair = '1'";
$rs_result2all = mysqli_query($rs_connect, $rs_allfindassets);
while ($rs_result_q2all = mysqli_fetch_object($rs_result2all)) {
$mainassetfieldid = "$rs_result_q2all->mainassetfieldid";
$mainassetfieldname = "$rs_result_q2all->mainassetfieldname";
$allassetinfofields[$mainassetfieldid] = "$mainassetfieldname";
}
foreach($pcextra as $key => $val) {
if(array_key_exists("$key", $allassetinfofields)) {
echo "<tr><td><font class=text12>$allassetinfofields[$key]: </font></td><td><font class=text12b>$val</font></td></tr>";
}
}



echo "<tr><td><font class=text12>".pcrtlang("Customer Assets").":</font></td><td><font class=text12b>";
foreach($custassetsindb as $key => $val) {
echo pcrtlang("$val")." :";
}


echo "</font></td></tr>";

echo "<tr><td colspan=2>";

require("patterns.php");


if($pcgroupid != 0) {
$credgroupsql = " OR groupid = '$pcgroupid' ";
} else {
$credgroupsql = "";
}


$rs_findcreds = "SELECT * FROM creds WHERE woid = '$woid' $credgroupsql ORDER BY groupid,creddate DESC";
$rs_result_creds = mysqli_query($rs_connect, $rs_findcreds);
while($rs_result_qcreds = mysqli_fetch_object($rs_result_creds)) {
$credid = "$rs_result_qcreds->credid";
$creddesc = "$rs_result_qcreds->creddesc";
$creduser = "$rs_result_qcreds->creduser";
$credpass = "$rs_result_qcreds->credpass";
$patterndata = "$rs_result_qcreds->patterndata";
$credtype = "$rs_result_qcreds->credtype";
$creddate2 = "$rs_result_qcreds->creddate";
$credgroupid = "$rs_result_qcreds->groupid";

if($credgroupid == 0) {
$badgestyle = "passbadge";
} else {
$badgestyle = "passbadge2";
}


$creddate = pcrtdate("$pcrt_mediumdate", "$creddate2");
if($credtype == 1) {
echo "<table class=\"$badgestyle\"><tr><td><i class=\"fa fa-lock fa-2x fa-fw\"></i></td>";
echo "<td><strong>$creddesc</strong> &bull; <span class=sizeme10>$creddate</span>";
echo "<br><i class=\"fa fa-user\"></i> $creduser
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class=\"fa fa-key\"></i> $credpass";
echo "</td></tr></table>";
}

if($credtype == 2) {
echo "<table class=\"$badgestyle\"><tr><td><i class=\"fa fa-thumb-tack fa-2x fa-fw\"></i></td>";
echo "<td><strong>$creddesc</strong> &bull; <span class=sizeme10>$creddate</span>";
echo "<br><i class=\"fa fa-thumb-tack\"></i> $credpass";
echo "</td></tr></table>";
}

if($credtype == 3) {
echo "<table class=\"$badgestyle\"><tr><td><i class=\"fa fa-th fa-2x fa-fw\"></i></td>";
echo "<td><strong>$creddesc</strong> &bull; <span class=sizeme10>$creddate</span><br>";
echo draw3x3("$patterndata","small");
echo "</td></tr></table>";
}

if($credtype == 5) {
echo "<table class=\"$badgestyle\"><tr><td><i class=\"fa fa-question-circle fa-2x fa-fw\"></i></td>";
echo "<td><strong>$creddesc</strong> &bull; <span class=sizeme10>$creddate</span>";
echo "<br><i class=\"fa fa-question\"></i> $creduser<br><i class=\"fa fa-commenting-o\"></i> $credpass";
echo "</td></tr></table>";
}

}




echo "</td></tr>";
echo "</table><br>";


echo "<font class=text12b>".pcrtlang("Problem/Task").":</font><br><blockquote><font class=text12>$probdesc</font><br>";


foreach($theprobsindb as $key => $val) {
if(in_array("$val",$comprobarrayv)) {
echo "<font class=text12>&bull; $val</font><br>";
}
}

echo "</blockquote>";

echo "<font class=text12b>".pcrtlang("Notes").":</font>";


echo "<br>";



echo "</td><td width=25>&nbsp;</td><td style=\"width:40%;text-align:left;\">";

echo "<br><center><span class=claimticketheader><i class=\"fa fa-wrench\"></i>&nbsp;".pcrtlang("Bench Sheet")."</span></center><br><br>";

$types = array(0,1);

foreach($types as $key => $scantype) {

if ($scantype == "0") {
$boxtitle = pcrtlang("Scans");
} elseif ($scantype == "1") {
$boxtitle = pcrtlang("Actions");
} elseif ($scantype == "2") {
$boxtitle = pcrtlang("Installs");
} elseif ($scantype == "3") {
$boxtitle = pcrtlang("Notes &amp; Recommendations");
} else {
$boxtitle = "-";
}

echo "<span class=sizeme16 style=\"box-shadow: inset 0 0 0 1000px #dddddd;display:block;padding:5px;\">$boxtitle</span><br>";

$rs_sq = "SELECT * FROM pc_scans WHERE scantype='$scantype' ORDER BY theorder DESC LIMIT 18";
$rs_result1 = mysqli_query($rs_connect, $rs_sq);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$scanid = "$rs_result_q1->scanid";
$progname = "$rs_result_q1->progname";
$progword = "$rs_result_q1->progword";
$progicon = "$rs_result_q1->progicon";
$hasinfo = "$rs_result_q1->hasinfo";
$printinfo = "$rs_result_q1->printinfo";
$theorder = "$rs_result_q1->theorder";
$scantype = "$rs_result_q1->scantype";
$active = "$rs_result_q1->active";

$checkscans =  "SELECT * FROM pc_scan WHERE scantype='$scanid'";
$rs_result_chk = mysqli_query($rs_connect, $checkscans);
$totalscans = mysqli_num_rows($rs_result_chk);

if ($active == 1) {
if ($progicon != "") {
echo "<i class=\"fa fa-square-o\"></i> <img src=../repair/images/scans/$progicon style=\"width:16px;\">";
}
echo " $progname<br>";
}
}
echo "<br>";
}

echo "</td></tr>";

echo "</table><br>";

echo "\n\n<DIV style=\"page-break-after:always\"></DIV>\n\n";

echo "<table style=\"width:100%\"><tr>";

$types = array(2,3);

foreach($types as $key => $scantype) {

echo "<td style=\"vertical-align:top;width:50%\">";

if ($scantype == "0") {
$boxtitle = pcrtlang("Scans");
} elseif ($scantype == "1") {
$boxtitle = pcrtlang("Actions");
} elseif ($scantype == "2") {
$boxtitle = pcrtlang("Installs");
} elseif ($scantype == "3") {
$boxtitle = pcrtlang("Notes &amp; Recommendations");
} else {
$boxtitle = "-";
}

echo "<span class=sizeme16 style=\"box-shadow: inset 0 0 0 1000px #dddddd;display:block;padding:5px;\">$boxtitle</span><br>";

$rs_sq = "SELECT * FROM pc_scans WHERE scantype='$scantype' ORDER BY theorder DESC LIMIT 18";
$rs_result1 = mysqli_query($rs_connect, $rs_sq);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$scanid = "$rs_result_q1->scanid";
$progname = "$rs_result_q1->progname";
$progword = "$rs_result_q1->progword";
$progicon = "$rs_result_q1->progicon";
$hasinfo = "$rs_result_q1->hasinfo";
$printinfo = "$rs_result_q1->printinfo";
$theorder = "$rs_result_q1->theorder";
$scantype = "$rs_result_q1->scantype";
$active = "$rs_result_q1->active";

$checkscans =  "SELECT * FROM pc_scan WHERE scantype='$scanid'";
$rs_result_chk = mysqli_query($rs_connect, $checkscans);
$totalscans = mysqli_num_rows($rs_result_chk);

if ($active == 1) {
if ($progicon != "") {
echo "<i class=\"fa fa-square-o\"></i> <img src=../repair/images/scans/$progicon style=\"width:16px;\">";
}
echo " $progname<br>";
}
}
echo "</td>";

}


echo "</tr>";

echo "</table><br>";

########## Checks

$pcwo = $woid;

$rs_sq = "SELECT * FROM mainassettypes WHERE mainassettypeid = '$mainassettypeidindb'";
$rs_result1 = mysqli_query($rs_connect, $rs_sq);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$mainassetchecksindb = serializedarraytest("$rs_result_q1->mainassetchecks");


if(count($mainassetchecksindb) > 0) {
echo "<table class=standard>";

echo "<tr><th colspan=2>".pcrtlang("Pre Checks")."</th><th colspan=2>".pcrtlang("Post Checks")."</th></tr>";

$rs_checks = "SELECT * FROM checks LIMIT 20";
$rs_checksq = mysqli_query($rs_connect, $rs_checks);
while($rs_result_cq = mysqli_fetch_object($rs_checksq)) {
$checkid = "$rs_result_cq->checkid";
$checkname = "$rs_result_cq->checkname";


if (in_array($checkid, $mainassetchecksindb)) {

# not checked = 0, not applicable = 1, pass = 2, fail = 3

echo "<tr><td>$checkname</td><td>";
echo "<i class=\"fa fa-square-o fa-lg\"></i>&nbsp; ";
echo "<i class=\"fa fa-minus fa-lg\"></i>&nbsp; ";
echo "<i class=\"fa fa-check fa-lg\"></i>&nbsp; ";
echo "<i class=\"fa fa-warning fa-lg\"></i>&nbsp; ";
echo "</td><td>$checkname</td><td>";

echo "<i class=\"fa fa-square-o fa-lg\"></i>&nbsp; ";
echo "<i class=\"fa fa-minus fa-lg\"></i>&nbsp; ";
echo "<i class=\"fa fa-check fa-lg\"></i>&nbsp; ";
echo "<i class=\"fa fa-warning fa-lg\"></i>&nbsp; ";
echo "</td></tr>";

}

}


echo "</table>";
echo "<br>";

}



printablefooter();


}



function setsl() {

require("deps.php");
require("common.php");

$slid = $_REQUEST['slid'];
$woid = $_REQUEST['woid'];

require_once("validate.php");

$rs_set_sl = "UPDATE pc_wo SET slid = '$slid' WHERE woid = '$woid'";
@mysqli_query($rs_connect, $rs_set_sl);

header("Location: index.php?pcwo=$woid#workorderinfo");

}


function setcheck() {

require("deps.php");
require("common.php");

$checkid = $_REQUEST['checkid'];
$woid = $_REQUEST['woid'];
$checktype = $_REQUEST['checktype'];
$checkvalue = $_REQUEST['checkvalue'];

require_once("validate.php");

$rs_findpc = "SELECT * FROM pc_wo WHERE woid = '$woid'";
$rs_result = mysqli_query($rs_connect, $rs_findpc);
$rs_result_q = mysqli_fetch_object($rs_result);
$wochecks = serializedarraytest("$rs_result_q->wochecks");

$wochecks[$checkid][$checktype] = $checkvalue;

if($checkvalue == 1) {
$wochecks[$checkid][0] = 1;
$wochecks[$checkid][1] = 1;
} else {
$wochecks[$checkid][$checktype] = $checkvalue;
}

$wochecksins = serialize($wochecks);

$set_wc = "UPDATE pc_wo SET wochecks = '$wochecksins' WHERE woid = '$woid'";
@mysqli_query($rs_connect, $set_wc);

header("Location: index.php?pcwo=$woid#scans");

}



function newpass() {

require("deps.php");
require("common.php");


$credtype = $_REQUEST['credtype'];
$returnto = $_REQUEST['returnto'];

if (array_key_exists('groupid',$_REQUEST)) {
$groupid = $_REQUEST['groupid'];
} else {
$groupid = "0";
}


if (array_key_exists('woid',$_REQUEST)) {
$woid = $_REQUEST['woid'];
} else {
$woid = "0";
}

if (array_key_exists('pcid',$_REQUEST)) {
$pcid = $_REQUEST['pcid'];
} else {
$pcid = "0";
}


if (array_key_exists('creddesc',$_REQUEST)) {
$creddesc = pv($_REQUEST['creddesc']);
} else {
$creddesc = "";
}

if (array_key_exists('username',$_REQUEST)) {
$nusername = pv($_REQUEST['username']);
} else {
$nusername = "";
}

if (array_key_exists('password',$_REQUEST)) {
$npassword = pv($_REQUEST['password']);
} else {
$npassword = "";
}


if (array_key_exists('newpattern',$_REQUEST)) {
$newpattern = $_REQUEST['newpattern'];
} else {
$newpattern = "";
}

if($newpattern == "") {
$newpattern = "456";
}


require_once("validate.php");

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

$set_np = "INSERT INTO creds (creddesc,creduser,credpass,patterndata,pcid,credtype,creddate,groupid)
VALUES ('$creddesc','$nusername','$npassword','$newpattern','$pcid','$credtype','$currentdatetime','$groupid')";


@mysqli_query($rs_connect, $set_np);

if($returnto == "wo") {
header("Location: index.php?pcwo=$woid#ownerinfo");
} else {
header("Location: group.php?func=viewgroup&pcgroupid=$groupid#credentials");
}


}


function deletecred() {
require_once("validate.php");
require("deps.php");

$credid = $_REQUEST['credid'];
$returnto = $_REQUEST['returnto'];
if (array_key_exists('groupid',$_REQUEST)) {
$groupid = $_REQUEST['groupid'];
} else {
$groupid = "0";
}


if (array_key_exists('woid',$_REQUEST)) {
$woid = $_REQUEST['woid'];
} else {
$woid = "0";
}

if (array_key_exists('pcid',$_REQUEST)) {
$pcid = $_REQUEST['pcid'];
} else {
$pcid = "0";
}


$rs_del_cred = "DELETE FROM creds WHERE credid = '$credid'";
@mysqli_query($rs_connect, $rs_del_cred);

if($returnto == "wo") {
header("Location: index.php?pcwo=$woid#ownerinfo");
} else {
header("Location: group.php?func=viewgroup&pcgroupid=$groupid#credentials");
}


}

function movecred() {
require_once("validate.php");
require("deps.php");

$woid = $_REQUEST['woid'];
$pcid = $_REQUEST['pcid'];
$credid = $_REQUEST['credid'];
$groupid = $_REQUEST['groupid'];
$moveto = $_REQUEST['moveto'];

if($moveto == "group") {
$rs_mv_cred = "UPDATE creds SET groupid = '$groupid', pcid = '0' WHERE credid = '$credid'";
} else {
$rs_mv_cred = "UPDATE creds SET groupid = '0', pcid = '$pcid' WHERE credid = '$credid'";
}
@mysqli_query($rs_connect, $rs_mv_cred);

header("Location: index.php?pcwo=$woid#ownerinfo");


}

function editcred() {

require("deps.php");
require("common.php");

$credtype = $_REQUEST['credtype'];
$returnto = $_REQUEST['returnto'];

if (array_key_exists('groupid',$_REQUEST)) {
$groupid = $_REQUEST['groupid'];
} else {
$groupid = "0";
}


if (array_key_exists('woid',$_REQUEST)) {
$woid = $_REQUEST['woid'];
} else {
$woid = "0";
}

if (array_key_exists('pcid',$_REQUEST)) {
$pcid = $_REQUEST['pcid'];
} else {
$pcid = "0";
}


if (array_key_exists('credid',$_REQUEST)) {
$credid = $_REQUEST['credid'];
} else {
$credid = "";
}

$rs_findcreds = "SELECT * FROM creds WHERE credid = '$credid'";
$rs_result_creds = mysqli_query($rs_connect, $rs_findcreds);
$rs_result_qcreds = mysqli_fetch_object($rs_result_creds);
$creddesc = "$rs_result_qcreds->creddesc";
$creduser = "$rs_result_qcreds->creduser";
$credpass = "$rs_result_qcreds->credpass";




if($credtype == 1) {
$uholder = pcrtlang("Enter Username");
$pholder = pcrtlang("Enter Password");
} elseif($credtype == 2) {
$uholder = "";
$pholder = pcrtlang("Enter PIN");
} elseif($credtype == 5) {
$uholder = pcrtlang("Enter Security Question");
$pholder = pcrtlang("Enter Answer");
} else {
$uholder = "";
$pholder = "";
}



require_once("validate.php");
require("dheader.php");

echo "<div data-role=\"header\" data-theme=\"b\"><h2>".pcrtlang("Edit Cred")."</h2></div>";
echo "<div class=\"ui-content\" role=\"main\">";


echo "<br><form action=pc.php?func=editcred2 method=POST data-ajax=\"false\">";
$rs_cd = "SELECT * FROM creddesc ORDER BY creddescorder DESC";
$rs_resultcd1 = mysqli_query($rs_connect, $rs_cd);
$creddescoptions = "<option value=\"\">".pcrtlang("pick one or edit below")."</option>";
while($rs_result_cdq1 = mysqli_fetch_object($rs_resultcd1)) {
$credtitle = "$rs_result_cdq1->credtitle";
$creddescoptions .= "<option value=\"$credtitle\">$credtitle</option>";
}

echo pcrtlang("Description").":";
echo "<select name=creddesc2 onchange='document.getElementById(\"creddesceditbox\").value=this.options[this.selectedIndex].value '>";
echo "$creddescoptions";
echo "</select>";
echo "<input type=text class=textbox id=creddesceditbox name=creddesc2 value=\"$creddesc\" style=\"width:250px\" placeholder=\"".pcrtlang("Description")."\"><br><br>";



if($credtype != 2) {
echo "$uholder:<br>";
echo "<input type=text value=\"$creduser\" name=username class=textbox size=35>";
} else {
echo "<input type=hidden value=\"\" name=username>";
}

echo "<input type=hidden value=$credid name=credid>";
echo "<input type=hidden value=$woid name=woid>";
echo "<input type=hidden value=$pcid name=pcid>";
echo "<input type=hidden value=$groupid name=groupid>";
echo "<input type=hidden value=$returnto name=returnto>";
echo "$pholder:<br>";
echo "<input type=text value=\"$credpass\" name=password class=textbox size=35>";

echo "<input type=submit class=button value=\"".pcrtlang("Save")."\" data-theme=\"b\"></form><br><br>";



require_once("dfooter.php");

}



function editcred2() {

require("deps.php");
require("common.php");

$creduser = pv($_REQUEST['username']);
$credpass = pv($_REQUEST['password']);
$creddesc = pv($_REQUEST['creddesc2']);
$credid = $_REQUEST['credid'];
$returnto = $_REQUEST['returnto'];

$groupid = $_REQUEST['groupid'];

if (array_key_exists('woid',$_REQUEST)) {
$woid = $_REQUEST['woid'];
} else {
$woid = "0";
}

if (array_key_exists('pcid',$_REQUEST)) {
$pcid = $_REQUEST['pcid'];
} else {
$pcid = "0";
}



require_once("validate.php");
if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

$set_c = "UPDATE creds SET creddesc = '$creddesc', creduser = '$creduser', credpass = '$credpass' WHERE credid = '$credid'";
@mysqli_query($rs_connect, $set_c);
if($returnto == "wo") {
header("Location: index.php?pcwo=$woid#ownerinfo");
} else {
header("Location: group.php?func=viewgroup&pcgroupid=$groupid#credentials");
}


}



function deletemessage() {
require_once("validate.php");
require("deps.php");

$messageid = $_REQUEST['messageid'];
$woid = $_REQUEST['woid'];

$rs_del_message = "DELETE FROM messages WHERE messageid = '$messageid'";
@mysqli_query($rs_connect, $rs_del_message);

header("Location: index.php?pcwo=$woid#notes");
}


function addmessage() {
require_once("validate.php");
require("deps.php");
require("common.php");

$woid = $_REQUEST['woid'];
$themessage = pv($_REQUEST['themessage']);
$phnumbers_il = $_REQUEST['phonenumbers'];
$emails_il = $_REQUEST['emails'];
$dropoff = $_REQUEST['dropoff'];
$pickup = $_REQUEST['pickup'];
$messagetype = $_REQUEST['type'];
$fromemail = pv($_REQUEST['fromemail']);
$toemail = pv($_REQUEST['toemail']);

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');


if ($messagetype == 2) {
$rs_insert_message = "INSERT INTO messages (messagefrom,messagebody,messagedatetime,messagevia,woid,messagedirection)
VALUES ('$ipofpc','$themessage','$currentdatetime','im','$woid','out')";
} elseif ($messagetype == 1) {
$rs_insert_message = "INSERT INTO messages (messagefrom,messagebody,messagedatetime,messagevia,woid,messagedirection)
VALUES ('$ipofpc','$themessage','$currentdatetime','call','$woid','out')";
} elseif ($messagetype == 3) {
$rs_insert_message = "INSERT INTO messages (messagefrom,messageto,messagebody,messagedatetime,messagevia,woid,messagedirection)
VALUES ('$fromemail','$toemail','$themessage','$currentdatetime','email','$woid','out')";
if(($fromemail != "") && ($toemail != "")) {
require_once("sendenotify.php");
$storeinfoarray = getstoreinfo($defaultuserstore);
$subject = pcrtlang("Message from")." $storeinfoarray[storename]";

$plaintextprefix = "##-## ".pcrtlang("Please reply above this line")." ##-##\n\n";
$htmltextprefix = "##-## ".pcrtlang("Please reply above this line")." ##-##<br><br>";

$plaintext = "$plaintextprefix $themessage";
$htmltext = "$htmltextprefix $themessage";
sendenotify("$fromemail","$toemail","$subject","$plaintext","$htmltext");
}
} else {
echo "Unknown Type";
}

@mysqli_query($rs_connect, $rs_insert_message);


require("ajaxcalls.php");
displaymessages("$phnumbers_il","$emails_il","$woid","$pickup","$dropoff");

}



#########################################################################################


function viewassetstatus() {

require("header.php");
require("deps.php");
require("brandicon.php");

$statusid = $_REQUEST['pcstatus'];

$rs_findstatii = "SELECT * FROM boxstyles ORDER BY displayedorder ASC";
$rs_result_st = mysqli_query($rs_connect, $rs_findstatii);
while($rs_result_stq = mysqli_fetch_object($rs_result_st)) {
$statusids[] = "$rs_result_stq->statusid";
$statusoptions[$rs_result_stq->statusid] = serializedarraytest("$rs_result_stq->statusoptions");
}


if (in_array("workbench", $statusoptions[$statusid])) {
$statsort = "workarea, dropdate";
} else {
$statsort = "dropdate";
}

$rs_findpcs5 = "SELECT * FROM pc_wo WHERE pcstatus = '$statusid' AND storeid = '$defaultuserstore' ORDER BY $statsort DESC";
$rs_result5 = mysqli_query($rs_connect, $rs_findpcs5);


if ((mysqli_num_rows($rs_result5)) != 0) {
$chksclog = "SELECT refid FROM userlog WHERE reftype = 'woid' AND actionid = '23' ORDER BY thedatetime DESC LIMIT 25";
$rs_result_sclog = mysqli_query($rs_connect, $chksclog);
if (mysqli_num_rows($rs_result_sclog) != "0") {
while($rs_result_item_sclogq = mysqli_fetch_object($rs_result_sclog)) {
$cscarray[] = "$rs_result_item_sclogq->refid";
}
} else {
$cscarray = array();
}

$currentworkarea = "nothing";
$currentworkorderswitch = "0";

$boxstyle = getboxstyle("$statusid");
start_status_box("$statusid","$boxstyle[boxtitle]");


while($rs_result_q = mysqli_fetch_object($rs_result5)) {

$pcid = "$rs_result_q->pcid";
$woid = "$rs_result_q->woid";
$dropdate = "$rs_result_q->dropdate";
$workarea = "$rs_result_q->workarea";
$pcpriorityindb = "$rs_result_q->pcpriority";
$thepass = "$rs_result_q->thepass";
$probdesc = "$rs_result_q->probdesc";
$commonproblems = "$rs_result_q->commonproblems";
$assigneduser = "$rs_result_q->assigneduser";
$skeddate = "$rs_result_q->skeddate";
$sked = "$rs_result_q->sked";

$dropdatestring = strtotime($dropdate);
$dropdatestringdiff = time() - $dropdatestring;


if ($pcpriorityindb != "") {
$picon = "$pcpriority[$pcpriorityindb]";
} else {
$picon = "";
}



$storeworkareas = array();
$rs_qb = "SELECT * FROM benches WHERE storeid = '$defaultuserstore'";
$rs_resultb = mysqli_query($rs_connect, $rs_qb);
while($rs_result_qb = mysqli_fetch_object($rs_resultb)) {
$benchid = "$rs_result_qb->benchid";
$benchname = "$rs_result_qb->benchname";
$benchcolor = "$rs_result_qb->benchcolor";
$storeworkareas[$benchname] = $benchcolor;
}


$rs_findowner = "SELECT pcname,pcmake,pccompany,mainassettypeid,prefcontact,pcphone,pcemail,pccellphone,pcworkphone,scid FROM pc_owner WHERE pcid = '$pcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);

$rs_result_q2 = mysqli_fetch_object($rs_result2);
$pcname = "$rs_result_q2->pcname";
$pcmake = "$rs_result_q2->pcmake";
$pccompany = "$rs_result_q2->pccompany";
$mainassettypeidindb = "$rs_result_q2->mainassettypeid";
$prefcontact = "$rs_result_q2->prefcontact";
$pcphone = "$rs_result_q2->pcphone";
$pcemail = "$rs_result_q2->pcemail";
$pccellphone = "$rs_result_q2->pccellphone";
$pcworkphone = "$rs_result_q2->pcworkphone";
$scid = "$rs_result_q2->scid";



if (in_array("workbench", $statusoptions[$statusid])) {

if (($workarea == "") || !array_key_exists("$workarea", $storeworkareas)) {
$workarea2 = pcrtlang("Unassigned");
$bgstyle = "style=\"background: #ffffff;padding:3px;\"";
$bgstyle2 = "style=\"background: #cccccc;padding:3px;border-radius:3px;\"";
} else {
$workarea2 = "$workarea";
$bgcolor = $storeworkareas[$workarea];
$bgstyle2 = "style=\"background: #$bgcolor;padding:3px;border-radius:3px;\"";
}
if (($workarea != $currentworkarea) && (!empty($storeworkareas)))  {
if(($currentworkarea != "$workarea") && ($currentworkarea != "nothing")) {
echo "</ul>";
}
echo "\n\n<br><div $bgstyle2><i class=\"fa fa-plug\"></i> <font class=smallerb>$workarea2</font></div>\n\n";
}
if($currentworkarea != "$workarea") {
echo "<ul data-role=\"listview\" data-inset=\"true\">\n";
}
$currentworkarea = "$workarea";
} else {
if($currentworkorderswitch == 0) {
echo "<ul data-role=\"listview\" data-inset=\"true\">\n";
$currentworkorderswitch = 1;
}
}


#####
echo "<li>\n";
echo "<a href=\"index.php?pcwo=$woid#workorderinfo\"  data-ajax=\"false\"><font class=em90>$pcname</font>\n";


if (in_array("mcompany", $statusoptions[$statusid])) {
if($pccompany != "") {
echo "<br><font class=em75><i class=\"fa fa-building fa-fw\"></i> $pccompany</font>\n";
}
}

if (in_array("mwoids", $statusoptions[$statusid])) {
echo "<br><font class=em75><i class=\"fa fa-tag\"></i> AS $pcid  &nbsp;&nbsp;&nbsp;<i class=\"fa fa-clipboard\"></i> WO $woid</font>\n";
}

if (in_array("massettype", $statusoptions[$statusid])) {
$mainassettype = getassettypename($mainassettypeidindb);
echo "<br><font class=em75><i class=\"fa fa-cog\"></i> $mainassettype: $pcmake</font>\n";
}

if (in_array("mmsp", $statusoptions[$statusid])) {
if($scid == 1) {
echo "<br><font class=em75><i class=\"fa fa-file-text\"></i> ".pcrtlang("Service Contract").": $scid</font> \n";
}
}


if (in_array("mskedjobs", $statusoptions[$statusid])) {
if($sked == 1) {
echo "<br><font class=em75><i class=\"fa fa-clock-o\"></i> \n";
skedwhen("$skeddate");
echo "</font>";
}
}


if (in_array("mpassword", $statusoptions[$statusid])) {
$rs_findcreds = "SELECT * FROM creds WHERE pcid = '$pcid' AND credtype < '3' ORDER BY creddate DESC";
$rs_result_creds = mysqli_query($rs_connect, $rs_findcreds);
while($rs_result_qcreds = mysqli_fetch_object($rs_result_creds)) {
$creddesc = "$rs_result_qcreds->creddesc";
$creduser = "$rs_result_qcreds->creduser";
$credpass = "$rs_result_qcreds->credpass";
$credtype = "$rs_result_qcreds->credtype";
$patterndata = "$rs_result_qcreds->patterndata";
if($credtype == 1) {
echo "<br>$creddesc: <i class=\"fa fa-user\"></i> $creduser <i class=\"fa fa-key\"></i> $credpass";
} else {
echo "<br>$creddesc: <i class=\"fa fa-thumb-tack\"></i> $credpass";
}
}
}


if (in_array("mdaysinshop", $statusoptions[$statusid])) {
$elapse = elaps($dropdate);
echo "<br><font class=em75><i class=\"fa fa-history\"></i> $elapse ".pcrtlang("in the shop")."</font>\n";
}
if (in_array("massigneduser", $statusoptions[$statusid])) {
if($assigneduser != "") {
echo "<br><font class=em75><i class=\"fa fa-user\"></i> ".pcrtlang("Assigned User").": $assigneduser</font>\n";
}
}


if (in_array("mrepaircart", $statusoptions[$statusid])) {
$rs_findbill = "SELECT * FROM repaircart WHERE pcwo = '$woid'";
$rs_findbill2 = mysqli_query($rs_connect, $rs_findbill);
$numite = mysqli_num_rows($rs_findbill2);

if($numite != 0) {
$rs_findsum = "SELECT (SUM(cart_price) + SUM(itemtax)) as checkcartsum FROM repaircart WHERE pcwo = '$woid'";
$rs_findsum2 = @mysqli_query($rs_connect, $rs_findsum);
$rs_findsum3 = mysqli_fetch_object($rs_findsum2);
$cartsum = "$rs_findsum3->checkcartsum";

if($cartsum == 0) {
echo "<br><font class=\"em75\"><i class=\"fa fa-money\"></i> $money ".pcrtlang("NO CHARGE")."</font> \n";
} else {
echo "<br><font class=\"em75\"><i class=\"fa fa-money\"></i> $money".mf("$cartsum")."</font> \n";
}

}
}




if (in_array("mstatuscheck", $statusoptions[$statusid])) {
if(in_array("$woid", $cscarray)) {
$thecheckarray = customerstatuscheck($woid,2);
echo "<br><font class=em75><i class=\"fa fa-eye fa-lg\" style=\"color:#0000ff\"></i> $thecheckarray[thetimes] ".pcrtlang("time(s)")."</font>\n";
}
}



echo "</a></li>\n";


#wo while
}


echo "</ul><br>\n";
echo "<br>";

}

require("footer.php");

}

function tagsave() {
require_once("validate.php");

require("deps.php");
require("common.php");

$pcid = $_REQUEST['pcid'];
$woid = $_REQUEST['woid'];
$tags = $_REQUEST['tags'];

if (array_key_exists('tags',$_REQUEST)) {
$tags = $_REQUEST['tags'];
} else {
$tags = array();
}

$tags3 = array_filter($tags);
$tags2 = implode_list($tags3);
mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_update_sal = "UPDATE pc_owner SET tags = '$tags2' WHERE pcid = '$pcid'";
@mysqli_query($rs_connect, $rs_update_sal);

header("Location: index.php?pcwo=$woid#ownerinfo");

}


function changepromiseview() {

require("deps.php");
require("common.php");

$view = $_REQUEST['view'];

require_once("validate.php");

$rs_cv = "UPDATE users SET promiseview = '$view' WHERE username = '$ipofpc'";
@mysqli_query($rs_connect, $rs_cv);

header("Location: ../repairmobile/");

}



#####

switch($func) {
                                                                                                    
    default:
    addpc();
    break;
                                
    case "addpc":
    addpc();
    break;

    case "addpc2":
    addpc2();
    break;
                                   
    case "stat_change":
    stat_change();
    break;
                                 
    case "add_scan":
    add_scan();
    break;

    case "rm_scan":
    rm_scan();
    break;

    case "checkout":
    checkout();
    break;

    case "printit":
    printit();
    break;

   case "printclaimticket":
    printclaimticket();
    break;

  case "emailclaimticket":
    emailclaimticket();
    break;

  case "emailclaimticket2":
    emailclaimticket2();
    break;

   case "printcheckoutreceipt":
    printcheckoutreceipt();
    break;

    case "view":
    view();
    break;


    case "showpc":
    showpc();
    break;

    case "returnpc":
    returnpc();
    break;

    case "returnpcajax":
    returnpcajax();
    break;


    case "returnpc2":
    returnpc2();
    break;

    case "returnpc3":
    returnpc3();
    break;

    case "editowner":
    editowner();
    break;

    case "editowner2":
    editowner2();
    break;

    case "editproblem":
    editproblem();
    break;

  case "editproblem_jq":
    editproblem_jq();
    break;

    case "editproblem2":
    editproblem2();
    break;

    case "movewo":
    movewo();
    break;

    case "movewo2":
    movewo2();
    break;


    case "stats":
    stats();
    break;
    
    case "precalled":
    precalled();
    break;
                                                                                                                         
    case "called":
    called();
    break;

    case "status":
    status();
    break;

  case "changewa":
    changewa();
    break;

 case "custominfocreate":
    custominfocreate();
    break;

 case "custominfocreate2":
    custominfocreate2();
    break;

 case "custominforevert":
    custominforevert();
    break;

 case "addcustomscan":
    addcustomscan();
    break;

case "addcustomscan2":
    addcustomscan2();
    break;

case "editcustominfo":
    editcustominfo();
    break;

case "editcustominfo2":
    editcustominfo2();
    break;

case "setpriority":
    setpriority();
    break;


case "removephoto":
    removephoto();
    break;

case "highlightphoto":
    highlightphoto();
    break;

case "remhighlightphoto":
    remhighlightphoto();
    break;

case "checkoutpc":
    checkoutpc();
    break;

case "checkoutpc2":
    checkoutpc2();
    break;

case "emailit":
    emailit();
    break;

case "emailit2":
    emailit2();
    break;

case "workorderaction":
    workorderaction();
    break;

case "addassetphoto":
    addassetphoto();
    break;

case "addassetphoto2":
    addassetphoto2();
    break;

case "searchwo":
    searchwo();
    break;

case "savesig":
    savesig();
    break;

case "savesigtopaz":
    savesigtopaz();
    break;


case "clearsig":
    clearsig();
    break;

case "clearsigtopaz":
    clearsigtopaz();
    break;


case "savesigwo":
    savesigwo();
    break;

case "clearsigwo":
    clearsigwo();
    break;

case "savesigcr":
    savesigcr();
    break;

case "clearsigcr":
    clearsigcr();
    break;

case "savesigwotopaz":
    savesigwotopaz();
    break;

case "clearsigwotopaz":
    clearsigwotopaz();
    break;

case "savesigcrtopaz":
    savesigcrtopaz();
    break;

case "clearsigcrtopaz":
    clearsigcrtopaz();
    break;



case "changestatusview":
    changestatusview();
    break;

case "frameit":
    frameit();
    break;

case "thankyou":
    thankyou();
    break;

case "printthankyou":
    printthankyou();
    break;

case "emailthankyou":
    emailthankyou();
    break;

case "emailthankyou2":
    emailthankyou2();
    break;

case "hidesigct":
    hidesigct();
    break;

case "hidesigrr":
    hidesigrr();
    break;

case "hidesigcr":
    hidesigcr();
    break;

case "hidesigcttopaz":
    hidesigcttopaz();
    break;

case "hidesigrrtopaz":
    hidesigrrtopaz();
    break;

case "hidesigcrtopaz":
    hidesigcrtopaz();
    break;


case "getpcimage":
    getpcimage();
    break;

case "searchreturnpcsreq":
    searchreturnpcsreq();
    break;


case "addnote2":
    addnote2();
    break;

case "addd7note":
    addd7note();
    break;

case "editnote":
    editnote();
    break;

case "editnote2":
    editnote2();
    break;

case "deletenote":
    deletenote();
    break;

case "convertnote":
    convertnote();
    break;

case "worenotify":
    worenotify();
    break;

case "addassetonly":
    addassetonly();
    break;

case "addassetonly2":
    addassetonly2();
    break;

case "pullsubasset":
    pullsubasset();
    break;

case "pullsubassetedit":
    pullsubassetedit();
    break;

case "pullinfofields":
    pullinfofields();
    break;

case "pullinfofieldsedit":
    pullinfofieldsedit();
    break;

case "timerstart":
    timerstart();
    break;

case "timerstartmanual":
    timerstartmanual();
    break;


case "timerstop":
    timerstop();
    break;

case "timerdelete":
    timerdelete();
    break;

case "timerresume":
    timerresume();
    break;

case "timerbill":
    timerbill();
    break;

case "timerbillfirst":
    timerbillfirst();
    break;

case "timeredit":
    timeredit();
    break;

case "timeredit2":
    timeredit2();
    break;

case "timereditprog":
    timereditprog();
    break;

case "timeredit2prog":
    timeredit2prog();
    break;

case "callmap":
    callmap();
    break;

case "addspo":
    addspo();
    break;

case "addspo2":
    addspo2();
    break;

case "editspo":
    editspo();
    break;

case "editspo2":
    editspo2();
    break;

case "deletespo":
    deletespo();
    break;

case "addmiles":
    addmiles();
    break;

case "addmiles2":
    addmiles2();
    break;

case "deletetl":
    deletetl();
    break;

case "showworkorders":
    showworkorders();
    break;

case "switchdeposit":
    switchdeposit();
    break;

case "adddeposittowo":
    adddeposittowo();
    break;

case "removedepositfromwo":
    removedepositfromwo();
    break;

case "benchsheet":
    benchsheet();
    break;

case "setsl":
    setsl();
    break;

case "setcheck":
    setcheck();
    break;

case "newpass":
    newpass();
    break;

case "deletecred":
    deletecred();
    break;

case "movecred":
    movecred();
    break;

case "editcred":
    editcred();
    break;

case "editcred2":
    editcred2();
    break;

case "deletemessage":
    deletemessage();
    break;

case "addmessage":
    addmessage();
    break;

case "viewassetstatus":
    viewassetstatus();
    break;

case "tagsave":
    tagsave();
    break;

case "changepromiseview":
    changepromiseview();
    break;


}

