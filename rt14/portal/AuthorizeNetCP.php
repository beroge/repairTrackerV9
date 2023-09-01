<?php

/***************************************************************************
 *   copyright            : (C) 2017 PCRepairTracker.com
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

if (array_key_exists('amounttopay',$_REQUEST)) {
$amounttopay =  $_REQUEST['amounttopay'];
} else {
die("error");
}

if (array_key_exists('invtotal',$_REQUEST)) {
$invtotal =  $_REQUEST['invtotal'];
} else {
die("error");
}


$invoiceid = $_REQUEST['invoiceid'];
$invtax = $_REQUEST['invtax'];

                                                                                                                                               
require("header.php");

echo "<h3>".pcrtlang("Add Credit Card Payment")."</h3>";

echo "<table class=table style=\"max-width:400px;\"><tr><td><form action=$securedomain/AuthorizeNetCP.php?func=add3 method=post>";
echo pcrtlang("Amount to Pay").": </td><td>$money $amounttopay<input type=hidden name=amounttopay value=\"".mf("$amounttopay")."\"><input type=hidden name=invtotal value=\"".mf("$invtotal")."\"><input type=hidden name=invtax value=\"$invtax\"></td></tr>";
echo "<tr><td>".pcrtlang("Credit Card Number").": </td><td><input type=text name=ccnumber size=20 class=\"form-control\"> ".pcrtlang("16 digits, no dashes or spaces")."</td></tr>";
echo "<tr><td>".pcrtlang("Expiration Month").": </td><td><input type=text name=ccmonth size=4 class=\"form-control\"> ".pcrtlang("2 digits")."</td></tr>";
echo "<tr><td>".pcrtlang("Expiration Year").": </td><td><input type=text name=ccyear size=4 class=\"form-control\"> ".pcrtlang("4 digits")."</td></tr>";
echo "<tr><td>".pcrtlang("Security Code on Back").": </td><td><input type=text name=cccid size=5 class=\"form-control\"></td></tr>";

echo "<tr><td colspan=2>&nbsp;</td></tr>";

echo "<tr><td>".pcrtlang("First Name on Card").": </td>";
echo "<td><input type=text name=cfirstname size=25 class=\"form-control\"></td></tr>";

echo "<tr><td>".pcrtlang("Last Name on Card").": </td>";
echo "<td><input type=text name=clastname size=25 class=\"form-control\"></td></tr>";

echo "<input type=hidden name=invoiceid value=\"$invoiceid\">";


echo "<tr><td></td><td><input type=submit class=\"btn btn-primary\" value=\"".pcrtlang("Pay Invoice")."\" onclick=\"this.disabled=false;this.value='".pcrtlang("Please Wait")."...'; this.form.submit();\"></form></td></tr></table>";


require("footer.php");
}



function add3() {
require_once("validate.php");

require("deps.php");
require_once("common.php");

$amounttopay = $_REQUEST['amounttopay'];
$invtotal = $_REQUEST['invtotal'];
$invtax = $_REQUEST['invtax'];
$ccnumber = pv($_REQUEST['ccnumber']);
$ccmonth = pv($_REQUEST['ccmonth']);
$ccyear = pv($_REQUEST['ccyear']);
$cccid = pv($_REQUEST['cccid']);

$cfirstname = pv($_REQUEST['cfirstname']);
$clastname = pv($_REQUEST['clastname']);
$custname = "$cfirstname $clastname";

$invoiceid = pv($_REQUEST['invoiceid']);


if ($demo == "yes") {
die("Sorry this feature is disabled in demo mode");
}

$ccexpdate = "$ccmonth"."$ccyear";

$DEBUGGING= 1;                          # Display additional information to track down problems
$TESTING = 0;                           # Set the testing flag so that transactions are not live
$ERROR_RETRIES = 2;                     # Number of transactions to post if soft errors occur

$auth_net_url = "https://secure.authorize.net/gateway/transact.dll";

$authnet_values                         = array
(
        "x_login"               => $AuthorizeNetLoginIDCP,
        "x_cpversion"           => "1.0",
        "x_response_format"     => "1",
        "x_delim_char"          => "|",
        "x_delim_data"          => "TRUE",
        "x_url"                 => "FALSE",
        "x_type"                => "AUTH_CAPTURE",
        "x_method"              => "CC",
        "x_tran_key"            => $AuthorizeNetTranKeyCP,
        "x_relay_response"      => "FALSE",
        "x_card_num"            => "$ccnumber",
        "x_exp_date"            => "$ccexpdate",
        "x_description"         => "Computer Parts and Service",
        "x_amount"              => "$amounttopay",
        "x_first_name"          => "$cfirstname",
        "x_last_name"           => "$clastname",
        "x_address"             => "",
        "x_city"                => "",
        "x_state"               => "",
        "x_zip"                 => "",
        "x_email"               => "",
        "x_phone"               => "",
        "x_card_code"           => "$cccid",
        "x_market_type"         => "2",
        "x_device_type"         => "5",
        "x_track1"              => "",
);

$fields = "";
foreach( $authnet_values as $key => $value ) $fields .= "$key=" . urlencode( $value ) . "&";

$ch = curl_init("$AuthorizeNetUrlCP");
curl_setopt($ch, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
curl_setopt($ch, CURLOPT_POSTFIELDS, rtrim( $fields, "& " )); // use HTTP POST to send form data
### curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response. ###
$resp = curl_exec($ch); //execute post and get results
curl_close ($ch);

$isapprovedarray = explode("|", $resp);

$isapproved = $isapprovedarray[1];
$cc_transid = $isapprovedarray[7];

if (($isapproved > 1) || (!is_numeric($cc_transid))) {

require_once("common.php");
require("header.php");
echo "<br><br><br><div class=\"bg-danger text-center\">";
echo "<br><h3 class=\"text-danger\"><i class=\"fa fa-warning fa-lg\"></i> ".pcrtlang("Payment Failed")."...</h3><br>";
$thereason = $isapprovedarray['3'];
echo pcrtlang("Reason").": $thereason<br><br>";
echo "<a href=index.php><i class=\"fa fa-home fa-lg\"></i> ".pcrtlang("Go Home")."</a><br><br>";
echo "</div>";
require("footer.php");

} else {

$cc_transid = $cc_transid;
$cardinfo = "";
$cccardtype = "";   

$ccnumber2 = substr("$ccnumber", -4);

$ccmonth = pv($_REQUEST['ccmonth']);
$ccyear = pv($_REQUEST['ccyear']);
$custname = urlencode("$custname");


header("Location: $domain/checkoutinvoice.php?func=checkout&invoiceid=$invoiceid&ccnumber=$ccnumber2&transid=$cc_transid&cardtype=$cccardtype&cardnamefirst=$cfirstname&cardnamelast=$clastname&ccmonth=$ccmonth&ccyear=$ccyear&amounttopay=$amounttopay&invtotal=$invtotal&invtax=$invtax");


}
                                                                                                                                               
}



switch($func) {
                                                                                                                             
    default:
    nothing();
    break;
                                
    case "add":
    add();
    break;

    case "add3":
    add3();
    break;



}

?>
