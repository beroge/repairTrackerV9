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

echo "<table class=table style=\"max-width:400px;\"><tr><td><form action=$securedomain/Stripe.php?func=add3 method=post>";
echo pcrtlang("Amount to Pay").": </td><td>$money $amounttopay<input type=hidden name=amounttopay value=\"".mf("$amounttopay")."\"><input type=hidden name=invtotal value=\"".mf("$invtotal")."\"><input type=hidden name=invtax value=\"$invtax\"></td></tr>";
echo "<tr><td>".pcrtlang("Credit Card Number").": </td><td><input type=text name=ccnumber size=20 class=\"form-control\"> ".pcrtlang("16 digits, no dashes or spaces")."</td></tr>";
echo "<tr><td>".pcrtlang("Expiration Month").": </td><td><input type=text name=ccmonth size=4 class=\"form-control\"> ".pcrtlang("2 digits")."</td></tr>";
echo "<tr><td>".pcrtlang("Expiration Year").": </td><td><input type=text name=ccyear size=4 class=\"form-control\"> ".pcrtlang("4 digits")."</td></tr>";
echo "<tr><td>".pcrtlang("Security Code on Back").": </td><td><input type=text name=cccid size=5 class=\"form-control\"></td></tr>";

echo "<tr><td>".pcrtlang("Card Type").": </td><td><select name=cardtype>";

echo "<option value=\"MasterCard\">MasterCard</option>";
echo "<option value=\"Visa\">Visa</option>";
echo "<option value=\"Discover\">Discover</option>";
echo "<option value=\"Amex\">Amex</option>";
echo "<option value=\"Maestro\">Maestro</option>";
echo "<option value=\"Solo\">Solo</option>";

echo "</select></td></tr>";

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
$cardtype = pv($_REQUEST['cardtype']);

$cfirstname = pv($_REQUEST['cfirstname']);
$clastname = pv($_REQUEST['clastname']);
$custname = "$cfirstname $clastname";

$invoiceid = pv($_REQUEST['invoiceid']);


if ($demo == "yes") {
die("Sorry this feature is disabled in demo mode");
}



######

function PPHttpPost($methodName_, $nvpStr_) {

require("deps.php");

	// Set up your API credentials, PayPal end point, and API version.
	$API_UserName = urlencode($PayPalUsername);
	$API_Password = urlencode($PayPalPassword);
	$API_Signature = urlencode($PayPalSignature);
	$API_Endpoint = "https://api-3t.paypal.com/nvp";
	if("sandbox" === $PayPalenvironment || "beta-sandbox" === $PayPalenvironment) {
		$API_Endpoint = "https://api-3t.$PayPalenvironment.paypal.com/nvp";
	}
	$version = urlencode('51.0');

	// Set the curl parameters.
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
	curl_setopt($ch, CURLOPT_VERBOSE, 1);

	// Turn off the server and peer verification (TrustManager Concept).
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);

	// Set the API operation, version, and API signature in the request.
	$nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";

	// Set the request as a POST FIELD for curl.
	curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

	// Get response from the server.
	$httpResponse = curl_exec($ch);

	if(!$httpResponse) {
		exit("$methodName_ failed: ".curl_error($ch).'('.curl_errno($ch).')');
	}

	// Extract the response details.
	$httpResponseAr = explode("&", $httpResponse);

	$httpParsedResponseAr = array();
	foreach ($httpResponseAr as $i => $value) {
		$tmpAr = explode("=", $value);
		if(sizeof($tmpAr) > 1) {
			$httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
		}
	}

	if((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
		exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
	}

	return $httpParsedResponseAr;
}

// Set request-specific fields.
$paymentType = urlencode('Sale');				// or 'Sale'
$firstName = urlencode($cfirstname);
$lastName = urlencode($clastname);
$creditCardType = urlencode($cardtype);
$creditCardNumber = urlencode($ccnumber);
$expDateMonth = "$ccmonth";
// Month must be padded with leading zero
$padDateMonth = urlencode(str_pad($expDateMonth, 2, '0', STR_PAD_LEFT));

$expDateYear = urlencode($ccyear);
$cvv2Number = urlencode($cccid);
$address1 = urlencode($custaddy1);
$address2 = urlencode($custaddy2);
$city = urlencode($custcity);
$state = urlencode($custstate);
$zip = urlencode($custzip);
$country = urlencode($PayPalCountryCode);				// US or other valid country code
$amount = urlencode($amounttopay);
$currencyID = urlencode($PayPalCurrencyCode);							// or other currency ('GBP', 'EUR', 'JPY', 'CAD', 'AUD')

// Add request-specific fields to the request string.
$nvpStr =	"&PAYMENTACTION=".$paymentType."&AMT=".$amount."&CREDITCARDTYPE=".$creditCardType."&ACCT=".$creditCardNumber.
			"&EXPDATE=".$padDateMonth.$expDateYear."&CVV2=".$cvv2Number."&FIRSTNAME=".$firstName."&LASTNAME=".$lastName.
			"&STREET=".$address1."&CITY=".$city."&STATE=".$state."&ZIP=".$zip."&COUNTRYCODE=".$country."&CURRENCYCODE=".$currencyID;

#if("$taxamt" != "") {
#$nvpStr .= "&TAXAMT=".$taxamt;
#}


// Execute the API operation; see the PPHttpPost function above.
$httpParsedResponseAr = PPHttpPost('DoDirectPayment', $nvpStr);

if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {

$cc_transid = $httpParsedResponseAr["TRANSACTIONID"];

$ccnumber2 = substr("$ccnumber", -4);

$isapproved == 1;

} else {
$isapproved == 0;
}



#####



if ($isapproved == 0) {

require_once("common.php");
require("header.php");
echo "<br><br><br><div class=\"bg-danger text-center\">";
echo "<br><h3 class=\"text-danger\"><i class=\"fa fa-warning fa-lg\"></i> ".pcrtlang("Payment Failed")."...</h3><br>";

echo pcrtlang("Reason").": <br><br>";
print_r($httpParsedResponseAr, true);
echo "<br><br>";
echo "<a href=index.php><i class=\"fa fa-home fa-lg\"></i> ".pcrtlang("Go Home")."</a><br><br>";
echo "</div>";
require("footer.php");

} else {

$cccardtype = $cardtype;   

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
