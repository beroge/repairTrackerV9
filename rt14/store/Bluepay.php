<?php

/***************************************************************************
 *   copyright            : (C) 2018 PCRepairTracker.com
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


require("header.php");


start_box();
echo "<h4>".pcrtlang("Swipe Credit Card NOW!")." (Bluepay)</h4><br><br>";

echo "<form name=c action=$securedomain/Bluepay.php?func=add2 method=post><input autofocus class=textbox type=password name=swipedata autocomplete=off>";

echo "<input type=hidden name=cfirstname value=\"$cfirstname\">";
echo "<input type=hidden name=ccompany value=\"$ccompany\">";
echo "<input type=hidden name=caddress value=\"$caddress\">";
echo "<input type=hidden name=caddress2 value=\"$caddress2\">";
echo "<input type=hidden name=ccity value=\"$ccity\">";
echo "<input type=hidden name=cstate value=\"$cstate\">";
echo "<input type=hidden name=czip value=\"$czip\">";
echo "<input type=hidden name=cphone value=\"$cphone\">";
echo "<input type=hidden name=cemail value=\"$cemail\">";

echo "<input type=hidden name=isdeposit value=\"$isdeposit\">";
echo "<input type=hidden name=woid value=\"$woid\">";
echo "<input type=hidden name=invoiceid value=\"$invoiceid\">";

echo "<input type=hidden name=currenttotal value=\"$currenttotal\">";

echo "<input type=submit class=button value=\"".pcrtlang("Proceed")."\"></form>";



require("footer.php");


}


function add2() {

$currenttotal =  $_REQUEST['currenttotal'];

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

if (array_key_exists('swipedata', $_REQUEST)) {
$swipedata = $_REQUEST['swipedata'];
} else {
$swipedata = "";
}

if ("$swipedata" != "") {
$mainpiece = explode("^", $swipedata);
$mainpiece1 = $mainpiece['1'];
$mainpiece3 = explode("/", $mainpiece1);

$cardnumberpiece = $mainpiece['0'];
$cardnumber = str_replace(" ", "", substr($cardnumberpiece, 2));

$ccname = $mainpiece3['1'];
$ccname2 = $mainpiece3['0'];
$ccexpyear =  substr($mainpiece['2'], 0,2);
$ccexpmonth =  substr($mainpiece['2'], 2,2);
} else {
$cardnumber = "";
$ccname = "";
$ccname2 = "";
$ccexpyear = "";
$ccexpmonth = "";
}
                                                                                                                                               
require("header.php");

start_blue_box(pcrtlang("Add Credit Card Payment")." (Bluepay)");
if($isdeposit != 1) {
echo "<h4>".pcrtlang("Balance").": $money".mf("$currenttotal")."</h4><br><br>";
}
echo "<table><tr><td><form action=$securedomain/Bluepay.php?func=add3 method=post>";
echo "".pcrtlang("Amount to Pay").": </td><td>$money <input type=text class=textboxw name=cardamount value=\"".mf("$currenttotal")."\" size=15></td></tr>";
echo "<tr><td>".pcrtlang("Credit Card Number").": </td><td><input type=text class=textboxw name=ccnumber size=20 value=\"$cardnumber\"> <span class=\"sizemesmaller italme\">".pcrtlang("16 digits, no dashes or spaces")."</span></td></tr>";
echo "<tr><td>".pcrtlang("Expiration Month").": </td><td><input type=text class=textboxw name=ccmonth size=4 value=\"$ccexpmonth\"> <span class=\"sizemesmaller italme\">".pcrtlang("2 digits")."</span></td></tr>";
echo "<tr><td>".pcrtlang("Expiration Year").": </td><td><input type=text class=textboxw name=ccyear size=4 value=\"$ccexpyear\"> <span class=\"sizemesmaller italme\">".pcrtlang("4 digits")."</span></td></tr>";
echo "<tr><td>".pcrtlang("CID").": </td><td><input type=text class=textboxw name=cccid size=5></td></tr>";

echo "<tr><td colspan=2>&nbsp;</td></tr>";
echo "<tr><td colspan=2>&nbsp;</td></tr>";

echo "<tr><td>".pcrtlang("First Name on Card").": </td>";
echo "<td><input type=text class=textboxw name=cfirstname value=\"$ccname\" size=25></td></tr>";

echo "<tr><td>".pcrtlang("Last Name on Card").": </td>";
echo "<td><input type=text class=textboxw name=clastname value=\"$ccname2\" size=25></td></tr>";

echo "<tr><td>".pcrtlang("Company").": </td>";
echo "<td><input type=text class=textboxw name=ccompany value=\"$ccompany\" size=25></td></tr>";

echo "<tr><td>$pcrt_address1: </td>";
echo "<td><input type=text class=textboxw name=caddress value=\"$caddress\" size=25></td></tr>";

echo "<tr><td>$pcrt_address2: </td>";
echo "<td><input type=text class=textboxw name=caddress2 value=\"$caddress2\" size=25></td></tr>";

echo "<tr><td>$pcrt_city, $pcrt_state $pcrt_zip </td>";
echo "<td><input type=text class=textboxw name=ccity value=\"$ccity\" size=15>";

echo "<input type=text class=textboxw name=cstate value=\"$cstate\" size=6>";

echo "<input type=text class=textboxw name=czip value=\"$czip\" size=10>";

echo "<input type=hidden name=isdeposit value=\"$isdeposit\">";
echo "<input type=hidden name=woid value=\"$woid\">";
echo "<input type=hidden name=invoiceid value=\"$invoiceid\">";

echo "</td></tr>";
echo "<tr><td>".pcrtlang("Phone").": </td><td><input type=text class=textboxw name=cphone value=\"$cphone\" size=20></td></tr>";

echo "<tr><td>".pcrtlang("Email").": </td><td><input type=text class=textboxw name=cemail value=\"$cemail\" size=20></td></tr>";

echo "<tr><td></td><td><input type=submit class=button value=\"".pcrtlang("Add Credit Card Payment")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Adding Credit Card Payment")."...'; this.form.submit();\"></form></td></tr></table>";
stop_blue_box();


require("footer.php");
}



function add3() {
require_once("validate.php");

require("deps.php");
require_once("common.php");

$amounttopay = $_REQUEST['cardamount'];
$ccnumber = pv($_REQUEST['ccnumber']);
$ccmonth = pv($_REQUEST['ccmonth']);
$ccyear = pv($_REQUEST['ccyear']);
$cccid = pv($_REQUEST['cccid']);

$cfirstname = pv($_REQUEST['cfirstname']);
$clastname = pv($_REQUEST['clastname']);
$ccompany = pv($_REQUEST['ccompany']);
$custaddy1 = pv($_REQUEST['caddress']);
$custaddy2 = pv($_REQUEST['caddress2']);
$custcity = pv($_REQUEST['ccity']);
$custstate = pv($_REQUEST['cstate']);
$custzip = pv($_REQUEST['czip']);
$custphone = pv($_REQUEST['cphone']);
$custemail = pv($_REQUEST['cemail']);

$custname = "$cfirstname $clastname";

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

if ($demo == "yes") {
die("Sorry this feature is disabled in demo mode");
}

$ccexpdate = "$ccmonth"."$ccyear";

$DEBUGGING= 1;                          # Display additional information to track down problems
$TESTING = 0;                           # Set the testing flag so that transactions are not live
$ERROR_RETRIES = 2;                     # Number of transactions to post if soft errors occur

$auth_net_url = "https://secure.bluepay.com/gateway/transact.dll";

$authnet_values                         = array
(
        "x_login"               => $BluepayAccountId,
        "x_version"             => "3.1",
        "x_delim_char"          => "|",
        "x_delim_data"          => "TRUE",
        "x_url"                 => "FALSE",
        "x_type"                => "AUTH_CAPTURE",
        "x_method"              => "CC",
        "x_tran_key"            => $BluepaySecretKey,
        "x_relay_response"      => "FALSE",
        "x_card_num"            => "$ccnumber",
        "x_exp_date"            => "$ccexpdate",
        "x_description"         => "Computer Parts and Service",
        "x_amount"              => "$amounttopay",
        "x_first_name"          => "$cfirstname",
        "x_last_name"           => "$clastname",
        "x_address"             => "$custaddy1",
        "x_city"                => "$custcity",
        "x_state"               => "$custstate",
        "x_zip"                 => "$custzip",
        "x_email"               => "$custemail",
        "x_phone"               => "$custphone",
	"x_card_code"           => "$cccid",
);

$fields = "";
foreach( $authnet_values as $key => $value ) $fields .= "$key=" . urlencode( $value ) . "&";

$ch = curl_init("$BluepayNetUrl");
curl_setopt($ch, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
curl_setopt($ch, CURLOPT_POSTFIELDS, rtrim( $fields, "& " )); // use HTTP POST to send form data
### curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response. ###
$resp = curl_exec($ch); //execute post and get results
curl_close ($ch);

$isapprovedarray = explode("|", $resp);

$isapproved = $isapprovedarray[0];
$cc_transid = $isapprovedarray[6];
$cccardtype = $isapprovedarray[51];

if ($isapproved > 1) {
require_once("common.php");
echo "<span style=\"font-size:20px;\">".pcrtlang("Credit Card Declined")."</span><br><br>";
$thereason = $isapprovedarray['3'];
echo pcrtlang("Reason").":<br><br><span style=\"font-size:16px;font-color:red\">$thereason</span>";
} else {



$ccnumber2 = substr("$ccnumber", -4);

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

if ($isdeposit == 1) {
$registerid = getcurrentregister();
$rs_insert_gcc = "INSERT INTO deposits (pfirstname,pcompany,byuser,amount,paymentplugin,paymentstatus,paymenttype,paddress,paddress2,pcity,pstate,pzip,pphone,cc_number,cc_expmonth,cc_expyear,cc_transid,cc_cardtype,woid,invoiceid,dstatus,depdate,storeid,registerid) VALUES  ('$custname','$ccompany','$ipofpc','$amounttopay','Bluepay','ready','credit','$custaddy1','$custaddy2','$custcity','$custstate','$custzip','$custphone','$ccnumber2','$ccmonth','$ccyear','$cc_transid','$cccardtype','$woid','$invoiceid','open','$currentdatetime','$defaultuserstore','$registerid')";
@mysqli_query($rs_connect, $rs_insert_gcc);

$depositid = mysqli_insert_id($rs_connect);
header("Location: deposits.php?func=deposit_receipt&depositid=$depositid&woid=$woid");
} else {

$rs_insert_gcc = "INSERT INTO currentpayments (pfirstname,pcompany,byuser,amount,paymentplugin,paymentstatus,paymenttype,paddress,paddress2,pcity,pstate,pzip,pphone,cc_number,cc_expmonth,cc_expyear,cc_transid,cc_cardtype) VALUES  ('$custname','$ccompany','$ipofpc','$amounttopay','Bluepay','ready','credit','$custaddy1','$custaddy2','$custcity','$custstate','$custzip','$custphone','$ccnumber2','$ccmonth','$ccyear','$cc_transid','$cccardtype')";
@mysqli_query($rs_connect, $rs_insert_gcc);

header("Location: $domain/cart.php");
}

}
                                                                                                                                               
}


function void() {
require_once("validate.php");

require("deps.php");
require_once("common.php");

$payid = $_REQUEST['payid'];
$cc_transid = $_REQUEST['cc_transid'];

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

if ($demo == "yes") {
die("Sorry this feature is disabled in demo mode");
}


$DEBUGGING= 1;                          # Display additional information to track down problems
$TESTING = 0;                           # Set the testing flag so that transactions are not live
$ERROR_RETRIES = 2;                     # Number of transactions to post if soft errors occur

$authnet_values                         = array
(
        "x_login"               => $BluepayAccountId,
        "x_version"             => "3.1",
        "x_delim_char"          => "|",
        "x_delim_data"          => "TRUE",
        "x_url"                 => "FALSE",
        "x_type"                => "VOID",
        "x_method"              => "CC",
        "x_tran_key"            => $BluepaySecretKey,
        "x_relay_response"      => "FALSE",
        "x_trans_id"           => "$cc_transid",
);

$fields = "";
foreach( $authnet_values as $key => $value ) $fields .= "$key=" . urlencode( $value ) . "&";

$ch = curl_init("$BluepayNetUrl");
curl_setopt($ch, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
curl_setopt($ch, CURLOPT_POSTFIELDS, rtrim( $fields, "& " )); // use HTTP POST to send form data
### curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response. ###
$resp = curl_exec($ch); //execute post and get results
curl_close ($ch);

$isapprovedarray = explode("|", $resp);

$isapproved = $isapprovedarray[0];

if ($isapproved > 1) {
require_once("common.php");
echo "<span style=\"font-size:20px;\">".pcrtlang("Void Failed")."</span><br><br>";
$thereason = $isapprovedarray['3'];
echo pcrtlang("Reason").":<br><br><span style=\"font-size:16px;font-color:red\">$thereason</span>";

echo "<a href=Bluepay.php?func=voidoverride&payid=$payid&isdeposit=$isdeposit&depositid=$depositid>".pcrtlang("Override and Remove this Credit Card Payment")."</a><br><br>".pcrtlang("Note: If you do this it will not release the hold on funds for your customers credit card, you must manually login to your control panel and void this charge")."";

} else {






if ($isdeposit != 1) {
$rs_void_cc = "DELETE FROM currentpayments WHERE paymentid = '$payid'";
@mysqli_query($rs_connect, $rs_void_cc);

header("Location: cart.php");
} else {
$rs_void_cc = "DELETE FROM deposits WHERE depositid = '$depositid'";
@mysqli_query($rs_connect, $rs_void_cc);
header("Location: deposits.php");
}
}
}


function voidoverride() {
require_once("validate.php");

require("deps.php");
require_once("common.php");

$payid = $_REQUEST['payid'];

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

if ($demo == "yes") {
die("Sorry this feature is disabled in demo mode");
}




if ($isdeposit != 1) {
$rs_void_cc = "DELETE FROM currentpayments WHERE paymentid = '$payid'";
@mysqli_query($rs_connect, $rs_void_cc);
header("Location: cart.php");
} else {
$rs_void_cc = "DELETE FROM deposits WHERE depositid = '$depositid'";
@mysqli_query($rs_connect, $rs_void_cc);
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

case "voidoverride":
    voidoverride();
    break;


}

?>
