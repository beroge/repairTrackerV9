<?php

/***************************************************************************
 *   copyright            : (C) 2012 PCRepairTracker.com
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


function add() {


if (array_key_exists('currenttotal',$_REQUEST)) {
$currenttotal =  $_REQUEST['currenttotal'];
} else {
$currenttotal = "";
}

if (array_key_exists('isdeposit',$_REQUEST)) {
$isdeposit =  $_REQUEST['isdeposit'];
} else {
$isdeposit = "0";
}

if (array_key_exists('woid',$_REQUEST)) {
$woid =  $_REQUEST['woid'];
} else {
$woid = "0";
}

if (array_key_exists('invoiceid',$_REQUEST)) {
$invoiceid =  $_REQUEST['invoiceid'];
} else {
$invoiceid = "0";
}

if (array_key_exists('cfirstname',$_REQUEST)) {
$cfirstname = $_REQUEST['cfirstname'];
} else {
$cfirstname = "";
}
if (array_key_exists('ccompany',$_REQUEST)) {
$ccompany = $_REQUEST['ccompany'];
} else {
$ccompany = "";
}
if (array_key_exists('caddress',$_REQUEST)) {
$caddress = $_REQUEST['caddress'];
} else {
$caddress = "";
}
if (array_key_exists('caddress2',$_REQUEST)) {
$caddress2 = $_REQUEST['caddress2'];
} else {
$caddress2 = "";
}
if (array_key_exists('ccity',$_REQUEST)) {
$ccity = $_REQUEST['ccity'];
} else {
$ccity = "";
}
if (array_key_exists('cstate',$_REQUEST)) {
$cstate = $_REQUEST['cstate'];
} else {
$cstate = "";
}
if (array_key_exists('czip',$_REQUEST)) {
$czip = $_REQUEST['czip'];
} else {
$czip = "";
}

if (array_key_exists('cphone',$_REQUEST)) {
$cphone = $_REQUEST['cphone'];
} else {
$cphone = "";
}

if (array_key_exists('cemail',$_REQUEST)) {
$cemail = $_REQUEST['cemail'];
} else {
$cemail = "";
}

                                                                                                                                               
require("dheader.php");

dheader(pcrtlang("Add Cash Payment"));
if ($isdeposit != 1) {
echo pcrtlang("Balance").": $money".mf("$currenttotal")."<br><br>";
}
echo "<form action=Cash.php?func=add2 method=post data-ajax=\"false\">";




echo pcrtlang("Amount to Pay").": <br><font class=em90>".pcrtlang("amount to pay with this method")."</font><input type=text class=textboxw name=amounttopay value=\"".mf("$currenttotal")."\">";
echo pcrtlang("Amount Tendered").": <input type=text name=amounttendered>";


echo "<br>".pcrtlang("Customer Name").": <input type=text name=cfirstname value=\"$cfirstname\">";
echo pcrtlang("Company").": <input type=text name=ccompany value=\"$ccompany\">";
echo "$pcrt_address1: ";
echo "<input type=text name=caddress value=\"$caddress\">";

echo "$pcrt_address2: ";
echo "<input type=text name=caddress2 value=\"$caddress2\">";

echo "$pcrt_city";
echo "<input type=text name=ccity value=\"$ccity\">";

echo " $pcrt_state  <input type=text name=cstate value=\"$cstate\">";

echo "$pcrt_zip <input type=text name=czip value=\"$czip\">";
echo "<input type=hidden name=isdeposit value=\"$isdeposit\">";
echo "<input type=hidden name=woid value=\"$woid\">";
echo "<input type=hidden name=invoiceid value=\"$invoiceid\">";

echo pcrtlang("Phone").": <input type=text name=cphone value=\"$cphone\">";
echo pcrtlang("Email").": <input type=text name=cemail value=\"$cemail\">";

echo "<button type=submit>".pcrtlang("Next")." <i class=\"fa fa-chevron-right fa-lg\"></i></button></form>";

dfooter();
require("dfooter.php");
}


function add2() {

$amounttendered = $_REQUEST['amounttendered'];
$amounttopay = $_REQUEST['amounttopay'];

$cfirstname = $_REQUEST['cfirstname'];
$ccompany = $_REQUEST['ccompany'];
$caddress = $_REQUEST['caddress'];
$caddress2 = $_REQUEST['caddress2'];
$ccity = $_REQUEST['ccity'];
$cstate = $_REQUEST['cstate'];
$czip = $_REQUEST['czip'];
$cphone = $_REQUEST['cphone'];
$cemail = $_REQUEST['cemail'];

$isdeposit = $_REQUEST['isdeposit'];
$woid = $_REQUEST['woid'];
$invoiceid = $_REQUEST['invoiceid'];
                                                                                                                                               
require("dheader.php");
                                                                         
dheader(pcrtlang("Add Cash Payment"));
$change = tnv($amounttendered) - tnv($amounttopay);
$changeformatted = number_format($change, 2, '.', '');
echo "<form action=Cash.php?func=add3 method=post data-ajax=\"false\">".pcrtlang("Change").": $changeformatted<br><br>";
echo "<input type=hidden name=cfirstname value=\"$cfirstname\">";
echo "<input type=hidden name=ccompany value=\"$ccompany\">";
echo "<input type=hidden name=caddress value=\"$caddress\">";
echo "<input type=hidden name=caddress2 value=\"$caddress2\">";
echo "<input type=hidden name=ccity value=\"$ccity\">";
echo "<input type=hidden name=cstate value=\"$cstate\">";
echo "<input type=hidden name=czip value=\"$czip\">";
echo "<input type=hidden name=cphone value=\"$cphone\">";
echo "<input type=hidden name=cemail value=\"$cemail\">";
echo "<input type=hidden name=change value=\"$changeformatted\">";
echo "<input type=hidden name=tendered value=\"$amounttendered\">";

echo "<input type=hidden name=isdeposit value=\"$isdeposit\">";
echo "<input type=hidden name=woid value=\"$woid\">";
echo "<input type=hidden name=invoiceid value=\"$invoiceid\">";

echo "<input type=hidden value=\"$amounttopay\" name=amounttopay><input type=submit value=\"".pcrtlang("Add Payment")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Adding Payment")."...'; this.form.submit();\"></form>";
dfooter();
                                                                                                                                               
require("dfooter.php");
}


function add3() {
require_once("validate.php");

require("deps.php");
require_once("common.php");

$amounttopay = $_REQUEST['amounttopay'];
$custname = pv($_REQUEST['cfirstname']);
$ccompany = pv($_REQUEST['ccompany']);
$custaddy1 = pv($_REQUEST['caddress']);
$custaddy2 = pv($_REQUEST['caddress2']);
$custcity = pv($_REQUEST['ccity']);
$custstate = pv($_REQUEST['cstate']);
$custzip = pv($_REQUEST['czip']);
$custphone = pv($_REQUEST['cphone']);
$custemail = pv($_REQUEST['cemail']);

$change = pv($_REQUEST['change']);
$tendered = pv($_REQUEST['tendered']);

$isdeposit = pv($_REQUEST['isdeposit']);
$woid = pv($_REQUEST['woid']);
$invoiceid = pv($_REQUEST['invoiceid']);




if ($isdeposit != 1) {
if($custname != "") {
$chkcustnamesqlex = "SELECT * FROM currentcustomer WHERE byuser = '$ipofpc'";
$chkcustnamesqlexq = @mysqli_query($rs_connect, $chkcustnamesqlex);
$custnamecountex = mysqli_num_rows($chkcustnamesqlexq);
if ($custnamecountex == 0) {
$custins = "INSERT INTO currentcustomer (cfirstname,byuser) VALUES ('$custname','$ipofpc')";
@mysqli_query($rs_connect, $custins);
} else {
$custins = "UPDATE currentcustomer SET cfirstname = '$custname' WHERE byuser = '$ipofpc' AND cfirstname = ''";
@mysqli_query($rs_connect, $custins);
}
}

if($ccompany != "") {
$chkcompanysqlex = "SELECT * FROM currentcustomer WHERE byuser = '$ipofpc'";
$chkcompanysqlexq = @mysqli_query($rs_connect, $chkcompanysqlex);
$companycountex = mysqli_num_rows($chkcompanysqlexq);
if ($companycountex == 0) {
$companyins = "INSERT INTO currentcustomer (ccompany,byuser) VALUES ('$ccompany','$ipofpc')";
@mysqli_query($rs_connect, $companyins);
} else {
$companyins = "UPDATE currentcustomer SET ccompany = '$ccompany' WHERE byuser = '$ipofpc' AND ccompany = ''";
@mysqli_query($rs_connect, $companyins);
}
}

if($custaddy1 != "") {
$chkcustaddy1sqlex = "SELECT * FROM currentcustomer WHERE byuser = '$ipofpc'";
$chkcustaddy1sqlexq = @mysqli_query($rs_connect, $chkcustaddy1sqlex);
$custaddy1countex = mysqli_num_rows($chkcustaddy1sqlexq);
if ($custaddy1countex == 0) {
$addy1ins = "INSERT INTO currentcustomer (caddress,byuser) VALUES ('$custaddy1','$ipofpc')";
@mysqli_query($rs_connect, $addy1ins);
} else {
$addy1ins = "UPDATE currentcustomer SET caddress = '$custaddy1' WHERE byuser = '$ipofpc' AND caddress = ''";
@mysqli_query($rs_connect, $addy1ins);
}
}

if($custaddy2 != "") {
$chkcustaddy2sqlex = "SELECT * FROM currentcustomer WHERE byuser = '$ipofpc'";
$chkcustaddy2sqlexq = @mysqli_query($rs_connect, $chkcustaddy2sqlex);
$custaddy2countex = mysqli_num_rows($chkcustaddy2sqlexq);
if ($custaddy2countex == 0) {
$addy2ins = "INSERT INTO currentcustomer (caddress2,byuser) VALUES ('$custaddy2','$ipofpc')";
@mysqli_query($rs_connect, $addy2ins);
} else {
$addy2ins = "UPDATE currentcustomer SET caddress2 = '$custaddy2' WHERE byuser = '$ipofpc' AND caddress2 = ''";
@mysqli_query($rs_connect, $addy2ins);
}
}

if($custcity != "") {
$chkcustcitysqlex = "SELECT * FROM currentcustomer WHERE byuser = '$ipofpc'";
$chkcustcitysqlexq = @mysqli_query($rs_connect, $chkcustcitysqlex);
$custcitycountex = mysqli_num_rows($chkcustcitysqlexq);
if ($custcitycountex == 0) {
$cityins = "INSERT INTO currentcustomer (ccity,byuser) VALUES ('$custcity','$ipofpc')";
@mysqli_query($rs_connect, $cityins);
} else {
$cityins = "UPDATE currentcustomer SET ccity = '$custcity' WHERE byuser = '$ipofpc' AND ccity = ''";
@mysqli_query($rs_connect, $cityins);
}
}

if($custstate != "") {
$chkcuststatesqlex = "SELECT * FROM currentcustomer WHERE byuser = '$ipofpc'";
$chkcuststatesqlexq = @mysqli_query($rs_connect, $chkcuststatesqlex);
$custstatecountex = mysqli_num_rows($chkcuststatesqlexq);
if ($custstatecountex == 0) {
$stateins = "INSERT INTO currentcustomer (cstate,byuser) VALUES ('$custstate','$ipofpc')";
@mysqli_query($rs_connect, $stateins);
} else {
$stateins = "UPDATE currentcustomer SET cstate = '$custstate' WHERE byuser = '$ipofpc' AND cstate = ''";
@mysqli_query($rs_connect, $stateins);
}
}

if($custzip != "") {
$chkcustzipsqlex = "SELECT * FROM currentcustomer WHERE byuser = '$ipofpc'";
$chkcustzipsqlexq = @mysqli_query($rs_connect, $chkcustzipsqlex);
$custzipcountex = mysqli_num_rows($chkcustzipsqlexq);
if ($custzipcountex == 0) {
$zipins = "INSERT INTO currentcustomer (czip,byuser) VALUES ('$custzip','$ipofpc')";
@mysqli_query($rs_connect, $zipins);
} else {
$zipins = "UPDATE currentcustomer SET czip = '$custzip' WHERE byuser = '$ipofpc' AND czip = ''";
@mysqli_query($rs_connect, $zipins);
}
}

if($custphone != "") {
$chkcustphonesqlex = "SELECT * FROM currentcustomer WHERE byuser = '$ipofpc'";
$chkcustphonesqlexq = @mysqli_query($rs_connect, $chkcustphonesqlex);
$custphonecountex = mysqli_num_rows($chkcustphonesqlexq);
if ($custphonecountex == 0) {
$phoneins = "INSERT INTO currentcustomer (cphone,byuser) VALUES ('$custphone','$ipofpc')";
@mysqli_query($rs_connect, $phoneins);
} else {
$phoneins = "UPDATE currentcustomer SET cphone = '$custphone' WHERE byuser = '$ipofpc' AND cphone = ''";
@mysqli_query($rs_connect, $phoneins);
}
}

if($custemail != "") {
$chkcustemailsqlex = "SELECT * FROM currentcustomer WHERE byuser = '$ipofpc'";
$chkcustemailsqlexq = @mysqli_query($rs_connect, $chkcustemailsqlex);
$custemailcountex = mysqli_num_rows($chkcustemailsqlexq);
if ($custemailcountex == 0) {
$emailins = "INSERT INTO currentcustomer (cemail,byuser) VALUES ('$custemail','$ipofpc')";
@mysqli_query($rs_connect, $emailins);
} else {
$emailins = "UPDATE currentcustomer SET cemail = '$custemail' WHERE byuser = '$ipofpc' AND cemail = ''";
@mysqli_query($rs_connect, $emailins);
}
}
}


if ($custname == "") {
$custname = "Customer";
}

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');


if ($isdeposit == 1) {
$registerid = getcurrentregister();
$rs_insert_cash = "INSERT INTO deposits (pfirstname,pcompany,byuser,amount,paymentplugin,paymentstatus,paymenttype,paddress,paddress2,pcity,pstate,pzip,pphone,pemail,woid,invoiceid,dstatus,depdate,storeid,cashchange,registerid) VALUES  ('$custname','$ccompany','$ipofpc','$amounttopay','Cash','ready','cash','$custaddy1','$custaddy2','$custcity','$custstate','$custzip','$custphone','$custemail','$woid','$invoiceid','open','$currentdatetime','$defaultuserstore','$change|$tendered','$registerid')";
@mysqli_query($rs_connect, $rs_insert_cash);
$depositid = mysqli_insert_id($rs_connect);
header("Location: deposits.php?func=deposit_receipt&depositid=$depositid&woid=$woid");
} else {
$rs_insert_cash = "INSERT INTO currentpayments (pfirstname,pcompany,byuser,amount,paymentplugin,paymentstatus,paymenttype,paddress,paddress2,pcity,pstate,pzip,pphone,pemail,cashchange) VALUES  ('$custname','$ccompany','$ipofpc','$amounttopay','Cash','ready','cash','$custaddy1','$custaddy2','$custcity','$custstate','$custzip','$custphone','$custemail','$change|$tendered')";
@mysqli_query($rs_connect, $rs_insert_cash);
header("Location: cart.php");
}

                                                                                                                                               
}


function void() {
require_once("validate.php");

require("deps.php");
require_once("common.php");


if (array_key_exists('payid',$_REQUEST)) {
$payid = $_REQUEST['payid'];
} else {
$payid = 0;
}

if (array_key_exists('depositid',$_REQUEST)) {
$depositid = $_REQUEST['depositid'];
} else {
$depositid = 0;
}

if (array_key_exists('isdeposit',$_REQUEST)) {
$isdeposit = $_REQUEST['isdeposit'];
} else {
$isdeposit = 0;
}






if ($isdeposit != 1) {
$rs_void_cash = "DELETE FROM currentpayments WHERE paymentid = '$payid'";
@mysqli_query($rs_connect, $rs_void_cash);
header("Location: cart.php");
} else {
$rs_void_cash = "DELETE FROM deposits WHERE depositid = '$depositid'";
@mysqli_query($rs_connect, $rs_void_cash);
header("Location: deposits.php");
}


}



switch($func) {
                                                                                                                             
    default:
    nothing();
    break;
                                
    case "add":
    add();
    break;

    case "add2":
    add2();
    break;

  case "add3":
    add3();
    break;

case "void":
    void();
    break;

}

?>
