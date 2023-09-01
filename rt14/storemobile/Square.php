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

                                                                                                    
function nothing() {
require_once("dheader.php");


require_once("dfooter.php");
                                                                                                    
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


dheader(pcrtlang("Square"));
echo pcrtlang("Swipe Credit Card NOW!")." (Square)<br><br>";

echo "<form name=c action=$securedomain"."mobile/Square.php?func=add2 method=post><input autofocus class=textbox type=password name=swipedata autocomplete=off>";

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



require("dfooter.php");


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
                                                                                                                                               
require("common.php");

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Square</title>


<script type="text/javascript" src="https://js.squareup.com/v2/paymentform"></script>
<script type="text/javascript">
    var sqPaymentForm = new SqPaymentForm({
      // Replace this value with your application's ID (available from the merchant dashboard).
      // If you're just testing things out, replace this with your _Sandbox_ application ID,
      // which is also available there.
      applicationId: '<?php echo "$SquareApplicationId"; ?>',
      inputClass: 'sq-input',
      cardNumber: {
        elementId: 'sq-card-number',
        placeholder: "5555 5555 5555 5555"
      },
      cvv: {
        elementId: 'sq-cvv',
        placeholder: 'CVV'
      },
      expirationDate: {
        elementId: 'sq-expiration-date',
        placeholder: '01/20'
      },
      postalCode: {
        elementId: 'sq-postal-code',
        placeholder: 'Postal Code'
      },
      inputStyles: [
        // Because this object provides no value for mediaMaxWidth or mediaMinWidth,
        // these styles apply for screens of all sizes, unless overridden by another
        // input style below.
        {
          fontSize: '14px',
          padding: '3px'
        },
        // These styles are applied to inputs ONLY when the screen width is 400px
        // or smaller. Note that because it doesn't specify a value for padding,
        // the padding value in the previous object is preserved.
        {
          mediaMaxWidth: '400px',
          fontSize: '18px',
        }
      ],
      callbacks: {
        cardNonceResponseReceived: function(errors, nonce, cardData) {
          if (errors) {
            var errorDiv = document.getElementById('errors');
            errorDiv.innerHTML = "";
            errors.forEach(function(error) {
              var p = document.createElement('p');
              p.innerHTML = error.message;
              errorDiv.appendChild(p);
            });
          } else {
            // This alert is for debugging purposes only.
            // alert('Nonce received! ' + nonce + ' ' + JSON.stringify(cardData));
            // Assign the value of the nonce to a hidden form element
            var nonceField = document.getElementById('card-nonce');
            nonceField.value = nonce;
            // Submit the form
            document.getElementById('form').submit();
          }
        },
        unsupportedBrowserDetected: function() {
          // Alert the buyer that their browser is not supported
        }
      }
    });

function submitButtonClick(event) {
      event.preventDefault();
      sqPaymentForm.requestCardNonce();
}

</script>

<style type="text/css">
    .sq-input {
      border: 1px solid #CCCCCC;
      margin-bottom: 10px;
      padding: 1px;
    }
    .sq-input--focus {
      outline-width: 2px;
      outline-color: #70ACE9;
      outline-offset: -1px;
      outline-style: auto;
    }
    .sq-input--error {
      outline-width: 5px;
      outline-color: #FF9393;
      outline-offset: 0px;
      outline-style: auto;
    }
  </style>
</head>
<body style="background:#333333">






<div style="width:95%;margin-left:auto;margin-right:auto;margin-top:50px; background:white; padding:30px; border-radius:10px;">
<span class="sizeme16 boldme"><?php echo pcrtlang("Square Payment"); ?></span><br><br>

<h3><?php echo pcrtlang("Please Re-enter Card Info:"); ?></h3>

<br><br>

  <form id="form" novalidate action="Square.php?func=add3" method="post">
    <label>Credit Card</label>
    <div id="sq-card-number"></div>
    <label>CVV</label>
    <div id="sq-cvv"></div>
    <label>Expiration Date</label>
    <div id="sq-expiration-date"></div>
    <label>Postal Code</label>
    <div id="sq-postal-code"></div>
    <input type="hidden" id="card-nonce" name="nonce">

<?php
echo "<input type=hidden name=ccname value=\"$ccname\">";
echo "<input type=hidden name=ccname2 value=\"$ccname2\">";
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

echo "<input type=hidden name=ccnumber value=\"$cardnumber\">";
echo "<input type=hidden name=ccmonth value=\"$ccexpmonth\">";
echo "<input type=hidden name=ccyear value=\"$ccexpyear\">";




?>
 
    <button type="submit" onclick="submitButtonClick(event)" class=button><?php echo pcrtlang("Tokenize Card"); ?></button>
  </form>

<?php

}



function add3() {

require("dheader.php");

$currenttotal =  $_REQUEST['currenttotal'];

$ccname = $_REQUEST['ccname'];
$ccname2 = $_REQUEST['ccname2'];
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
$nonce = $_REQUEST['nonce'];

$ccnumber = pv($_REQUEST['ccnumber']);
$ccmonth = pv($_REQUEST['ccmonth']);
$ccyear = pv($_REQUEST['ccyear']);
         



dheader(pcrtlang("Add Credit Card Payment")." (Square)");

if($isdeposit != 1) {
echo pcrtlang("Balance").": $money".mf("$currenttotal")."<br><br>";
}
echo "<form action=$securedomain"."mobile/Square.php?func=add4 method=post><table>";

echo "<tr><td>".pcrtlang("Amount to Pay").": <br><input type=text name=cardamount value=\"".mf("$currenttotal")."\"></td></tr>";

echo "<tr><td>".pcrtlang("First Name on Card").": <br>";
echo "<input type=text name=cfirstname value=\"$ccname\"></td></tr>";

echo "<tr><td>".pcrtlang("Last Name on Card").": <br>";
echo "<input type=text name=clastname value=\"$ccname2\"></td></tr>";

echo "<tr><td>".pcrtlang("Company").": <br>";
echo "<input type=text name=ccompany value=\"$ccompany\"></td></tr>";

echo "<tr><td>$pcrt_address1: <br>";
echo "<input type=text name=caddress value=\"$caddress\"></td></tr>";

echo "<tr><td>$pcrt_address2: <br>";
echo "<input type=text name=caddress2 value=\"$caddress2\"></td></tr>";

echo "<tr><td>$pcrt_city<br><input type=text name=ccity value=\"$ccity\"></td></tr>";

echo "<tr><td>$pcrt_state<br><input type=text name=cstate value=\"$cstate\"></td></tr>";

echo "<tr><td>$pcrt_zip <br><input type=text name=czip value=\"$czip\"></td></tr>";

echo "<input type=hidden name=isdeposit value=\"$isdeposit\">\n";
echo "<input type=hidden name=woid value=\"$woid\">\n";
echo "<input type=hidden name=invoiceid value=\"$invoiceid\">\n";
echo "<input type=\"hidden\" name=\"nonce\" value=\"$nonce\">\n";

echo "<input type=hidden name=ccnumber value=\"$ccnumber\">";
echo "<input type=hidden name=ccmonth value=\"$ccmonth\">";
echo "<input type=hidden name=ccyear value=\"$ccyear\">";

echo "</td></tr>";
echo "<tr><td>".pcrtlang("Phone").": <br><input type=text name=cphone value=\"$cphone\"></td></tr>";

echo "<tr><td>".pcrtlang("Email").":<br><input type=text name=cemail value=\"$cemail\"></td></tr>";

echo "<tr><td><input type=submit class=button value=\"".pcrtlang("Add Credit Card Payment")."\" onclick=\"this.disabled=false;this.value='".pcrtlang("Adding Credit Card Payment")."...'; this.form.submit();\"></form></td></tr></table>";


require("dfooter.php");
}




function add4() {
require_once("validate.php");

require("deps.php");
require_once("common.php");

$amounttopay = $_REQUEST['cardamount'];
$ccnumber = pv($_REQUEST['ccnumber']);
$ccmonth = pv($_REQUEST['ccmonth']);
$ccyear = pv($_REQUEST['ccyear']);


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
$nonce = $_REQUEST['nonce'];



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

$storeinfoarray = getstoreinfo($defaultuserstore);

$amounttopaycents = number_format($amounttopay, 2, '', ''); 


$isapproved = 1;

require 'Square/autoload.php';

$location_id = "$SquareLocationId";
$access_token = "$SquareAccessToken";

# Helps ensure this code has been reached via form submission
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  error_log("Received a non-POST request");
  echo "Request not allowed";
  http_response_code(405);
  return;
}

# Fail if the card form didn't send a value for `nonce` to the server
#$nonce = $_POST['nonce'];
if (is_null($nonce)) {
  echo "Invalid card data";
  http_response_code(422);
  return;
}

$transaction_api = new \SquareConnect\Api\TransactionApi();
$request_body = array (
  "card_nonce" => $nonce,
  # Monetary amounts are specified in the smallest unit of the applicable currency.
  # This amount is in cents. It's also hard-coded for $1.00, which isn't very useful.
  "amount_money" => array (
    "amount" => (int)$amounttopaycents,
    "currency" => "USD"
  ),
  # Every payment you process with the SDK must have a unique idempotency key.
  # If you're unsure whether a particular payment succeeded, you can reattempt
  # it with the same idempotency key without worrying about double charging
  # the buyer.
  "idempotency_key" => uniqid()
);

#print_r($request_body);
#die();

# The SDK throws an exception if a Connect endpoint responds with anything besides
# a 200-level HTTP code. This block catches any exceptions that occur from the request.
try {
  $result = $transaction_api->charge($access_token, $location_id, $request_body);
#print_r($result);

  $transaction = $result->getTransaction();
  $transid = $transaction['id'];

  $tenderid = $transaction["tenders"][0]["id"];

$cc_transid = "$transid"."tender"."$tenderid";

} catch (\SquareConnect\ApiException $e) {
  echo "Caught exception!<br/>";
  print_r("<strong>Response body:</strong><br/>");
  echo "<pre>"; var_dump($e->getResponseBody()); echo "</pre>";
  echo "<br/><strong>Response headers:</strong><br/>";
  echo "<pre>"; var_dump($e->getResponseHeaders()); echo "</pre>";
$isapproved = 0;
}



if ($isapproved == 0) {
echo "<font size=6>".pcrtlang("Credit Card Declined")."</font><br><br>";
} else {


$ccnumber2 = substr("$ccnumber", -4);

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

if ($isdeposit == 1) {
$registerid = getcurrentregister();
$rs_insert_gcc = "INSERT INTO deposits (pfirstname,pcompany,byuser,amount,paymentplugin,paymentstatus,paymenttype,paddress,paddress2,pcity,pstate,pzip,pphone,cc_number,cc_expmonth,cc_expyear,cc_transid,cc_cardtype,woid,invoiceid,dstatus,depdate,storeid,registerid) VALUES  ('$custname','$ccompany','$ipofpc','$amounttopay','Square','ready','credit','$custaddy1','$custaddy2','$custcity','$custstate','$custzip','$custphone','$ccnumber2','$ccmonth','$ccyear','$cc_transid','','$woid','$invoiceid','open','$currentdatetime','$defaultuserstore','$registerid')";
@mysqli_query($rs_connect, $rs_insert_gcc);

$depositid = mysqli_insert_id($rs_connect);
header("Location: deposits.php?func=deposit_receipt&depositid=$depositid&woid=$woid");
} else {

$rs_insert_gcc = "INSERT INTO currentpayments (pfirstname,pcompany,byuser,amount,paymentplugin,paymentstatus,paymenttype,paddress,paddress2,pcity,pstate,pzip,pphone,cc_number,cc_expmonth,cc_expyear,cc_transid,cc_cardtype) VALUES  ('$custname','$ccompany','$ipofpc','$amounttopay','Square','ready','credit','$custaddy1','$custaddy2','$custcity','$custstate','$custzip','$custphone','$ccnumber2','$ccmonth','$ccyear','$cc_transid','')";
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
$cc_transid2 = $_REQUEST['cc_transid'];
$refundamount = $_REQUEST['refundamount'];

$refundcents = number_format($refundamount, 2, '', ''); 

$transarray = explode("tender", $cc_transid2);

$cc_transid = $transarray['0'];
$cc_tenderid = $transarray['1'];


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


######
require 'Square/autoload.php';

$location_id = "$SquareLocationId";
$access_token = "$SquareAccessToken";

$transaction_api = new \SquareConnect\Api\RefundApi();
$request_body = array (
  "tender_id" => $cc_tenderid,
  "reason" => "Refund",
  # Monetary amounts are specified in the smallest unit of the applicable currency.
  # This amount is in cents. It's also hard-coded for $1.00, which isn't very useful.
  "amount_money" => array (
    "amount" => (int)$refundcents,
    "currency" => "USD"
  ),
  # Every payment you process with the SDK must have a unique idempotency key.
  # If you're unsure whether a particular payment succeeded, you can reattempt
  # it with the same idempotency key without worrying about double charging
  # the buyer.
  "idempotency_key" => uniqid()
);

#print_r($request_body);
#die();

$isapproved = 1;

try {
  $result = $transaction_api->createRefund($access_token, $location_id, $cc_transid, $request_body);

 

} catch (\SquareConnect\ApiException $e) {
  echo "Caught exception!<br/>";
  print_r("<strong>Response body:</strong><br/>");
  echo "<pre>"; var_dump($e->getResponseBody()); echo "</pre>";
  echo "<br/><strong>Response headers:</strong><br/>";
  echo "<pre>"; var_dump($e->getResponseHeaders()); echo "</pre>";

echo "<a href=Square.php?func=voidoverride&payid=$payid&isdeposit=$isdeposit&depositid=$depositid>".pcrtlang("Override and Remove this Credit Card Payment")."</a><br><br>".pcrtlang("Note: If you do this it will not release the hold on funds for your customers credit card, you must manually login to your control panel and void this charge.");

$isapproved = 0;
}



if ($isapproved == 0) {
require_once("common.php");
echo "<font size=6>".pcrtlang("Refund Failed")."</font><br><br>";
$thereason = $chargeerror;
echo "Reason:<br><br><font color=red size=5>$thereason</font>";


echo "<a href=Square.php?func=voidoverride&payid=$payid&isdeposit=$isdeposit&depositid=$depositid>".pcrtlang("Override and Remove this Credit Card Payment")."</a><br><br>".pcrtlang("Note: If you do this it will not release the hold on funds for your customers credit card, you must manually login to your control panel and void this charge.");

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

    case "add4":
    add4();
    break;


case "void":
    void();
    break;

case "voidoverride":
    voidoverride();
    break;


}

?>
