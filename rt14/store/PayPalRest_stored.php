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

                                                                                                    
function nothing() {
require_once("header.php");


require_once("footer.php");
                                                                                                    
}

function view() {
require("deps.php");
require_once("validate.php");
require_once("common.php");

$groupid =  $_REQUEST['groupid'];





$rs_find_paypal_customers = "SELECT * FROM savedcardscustomers WHERE groupid = '$groupid' AND sccplugin = 'PayPalRest'";
$rs_result_fsc = mysqli_query($rs_connect, $rs_find_paypal_customers);


$custcount = mysqli_num_rows($rs_result_fsc);

if ($custcount != 0) {

$rs_result_q = mysqli_fetch_object($rs_result_fsc);
$paypalcustomer = "$rs_result_q->sccprocid";
$paypalcustomerlocalid = "$rs_result_q->sccid";

$rs_find_paypal_cards = "SELECT * FROM savedcards WHERE sccid = '$paypalcustomerlocalid'";
$rs_result_cards = mysqli_query($rs_connect, $rs_find_paypal_cards);


echo "<table class=\"standard pad10\">";
echo "<tr><th>".pcrtlang("Card Holder")."</th>";
echo "<th>".pcrtlang("Last 4 Card Digits")."</th>";
echo "<th>".pcrtlang("Expiration")."</th>";
echo "<th>".pcrtlang("Card Type")."</th>";
echo "<th>".pcrtlang("Actions")."</th></tr>";

while($rs_result_q = mysqli_fetch_object($rs_result_cards)) {
$paypalcardlocalid = "$rs_result_q->savedcardid";
$paypalcardfour = "$rs_result_q->savedcardfour";
$paypalcardexpmonth = "$rs_result_q->savedcardexpmonth";
$paypalcardexpyear = "$rs_result_q->savedcardexpyear";
$paypalcardname = "$rs_result_q->savedcardname";
$paypalcardbrand = "$rs_result_q->savedcardbrand";
$paypalcardprocid = "$rs_result_q->savedcardprocid";
$paypalcarddefault = "$rs_result_q->savedcarddefault";

echo "<tr><td>$paypalcardname</td>";
echo "<td>$paypalcardfour";
if($paypalcarddefault == 1) {
echo " (".pcrtlang("default").")";
}

echo "</td>";
echo "<td>$paypalcardexpmonth / $paypalcardexpyear</td>";
echo "<td>$paypalcardbrand</td>";
echo "<td>";
echo "<a href=\"../store/PayPalRest_stored.php?func=delete&groupid=$groupid&cardid=$paypalcardprocid&pcrtcardid=$paypalcardlocalid&custid=$paypalcustomer\" 
onClick=\"return confirm('".pcrtlang("ARE YOU SURE YOU WANT TO DELETE THIS CARD?")."');\" class=\"linkbuttonsmall linkbuttongray radiusall\">
<i class=\"fa fa-times fa-lg\"></i> ".pcrtlang("Delete Card")."</a>&nbsp;&nbsp;&nbsp;";

if($paypalcarddefault == 0) {
echo "<a href=\"../store/PayPalRest_stored.php?func=setdefault&groupid=$groupid&cardid=$paypalcardprocid&pcrtcardid=$paypalcardlocalid&custid=$paypalcustomer&pcrtcustid=$paypalcustomerlocalid\" class=\"linkbuttonsmall linkbuttongray radiusall\">
<i class=\"fa fa-credit-card fa-lg\"></i> ".pcrtlang("Set as Default Card")."</a>";
}

echo "</td></tr>";

}
echo "</table>";

}

if ($custcount == 0) {
echo "<br><button class=button type=button onClick=\"parent.location='../store/PayPalRest_stored.php?func=add&groupid=$groupid&addtype=new'\">
<i class=\"fa fa-credit-card fa-lg\"></i> ".pcrtlang("Add First Paypal Card")."</button>";
} else {
echo "<br><button class=button type=button onClick=\"parent.location='../store/PayPalRest_stored.php?func=add&groupid=$groupid&addtype=existing'\">
<i class=\"fa fa-credit-card fa-lg\"></i> ".pcrtlang("Add Card to Paypal")."</button>";
}





}



function add() {

$groupid =  $_REQUEST['groupid'];
$addtype =  $_REQUEST['addtype'];


require("header.php");


start_box();
echo "<span class=\"sizemelarge boldme\">".pcrtlang("Swipe Credit Card NOW")."! (Stored PayPal)</span><br><br>";

echo "<form name=c action=$securedomain/PayPalRest_stored.php?func=add2 method=post><input autofocus class=textbox type=password name=swipedata autocomplete=off>";

echo "<input type=hidden name=groupid value=\"$groupid\">";
echo "<input type=hidden name=addtype value=\"$addtype\">";

echo "<input type=submit class=button value=\"".pcrtlang("Proceed")."\"></form>";



require("footer.php");


}


function add2() {


$groupid = $_REQUEST['groupid'];

if (array_key_exists('swipedata', $_REQUEST)) {
$swipedata = $_REQUEST['swipedata'];
} else {
$swipedata = "";
}

$addtype =  $_REQUEST['addtype'];

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

start_blue_box(pcrtlang("Add Credit Card Payment")." (PayPal)");


?>

 <form action="<?php echo "$securedomain"; ?>/PayPalRest_stored.php?func=add3" method="POST" id="payment-form">

    <div style="padding:3px;">
      <label>
        <span><?php echo pcrtlang("First Name"); ?></span>
        <input type="text" required class=textbox size="20" name="cardnamefirst" value="<?php echo "$ccname"; ?>">
      </label>
    </div>

    <div style="padding:3px;">
      <label>
        <span><?php echo pcrtlang("Last Name"); ?></span>
        <input type="text" required class=textbox size="20" name="cardnamelast" value="<?php echo "$ccname2"; ?>">
      </label>
    </div>


    <div style="padding:3px;">
      <label>
        <span><?php echo pcrtlang("Card Number"); ?></span>
        <input type="text" required class=textbox size="20" name="cardnumber" value="<?php echo "$cardnumber"; ?>">
      </label>
    </div>

    <div style="padding:3px;">
      <label>
        <span><?php echo pcrtlang("CVC"); ?></span>
        <input type="text" class=textbox size="4" name="cvc"/>
      </label>
    </div>

    <div style="padding:3px;">
      <label>
        <span><?php echo pcrtlang("Expiration (MM/YYYY)"); ?></span>
        <input type="text" required class=textbox size="2" name="exp-month" value="<?php echo "$ccexpmonth"; ?>">
      </label>
      <span> / </span>
      <input type="text" required class=textbox size="4" name="exp-year" value="<?php echo "$ccexpyear"; ?>">
    </div>


    <div style="padding:3px;">
      <label>
        <span><?php echo pcrtlang("Card Type"); ?></span>
	<select name=cardtype>
	<option value="mastercard">MasterCard</option>
	<option value="visa">Visa</option>
	<option value="discover">Discover</option>
	<option value="amex">Amex</option>
	</select>


      </label>
    </div>




   <input type=hidden name=groupid value="<?php echo "$groupid"; ?>">
   <input type=hidden name=addtype value="<?php echo "$addtype"; ?>">

    <button type="submit" class=button><?php echo pcrtlang("Submit Card"); ?></button>
  </form>

<?php

stop_blue_box();


require("footer.php");
}



function add3() {

require("deps.php");
require_once("validate.php");
require_once("common.php");


$cardnamefirst = $_REQUEST['cardnamefirst'];
$cardnamelast = $_REQUEST['cardnamelast'];
$cardnumber = $_REQUEST['cardnumber'];
$cardtype = $_REQUEST['cardtype'];
$cvc = $_REQUEST['cvc'];
$expyear = $_REQUEST['exp-year'];
$expmonth = $_REQUEST['exp-month'];
$groupid = $_REQUEST['groupid'];
$addtype =  $_REQUEST['addtype'];





require("paypalbootstrap.php");

$card = new PayPal\Api\CreditCard();
$card->setType("$cardtype")
    ->setNumber("$cardnumber")
    ->setExpireMonth("$expmonth")
    ->setExpireYear("$expyear")
    ->setCvv2("$cvc")
    ->setFirstName("$cardnamefirst")
    ->setLastName("$cardnamelast");

try { 

$card->create($apiContext); 


} catch (Exception $ex) {

echo $ex;

exit(1);

}


$paypalcard = $card->id;

if($addtype == "new") {

$rs_findgroupname = "SELECT * FROM pc_group WHERE pcgroupid = '$groupid'";
$rs_resultgn = mysqli_query($rs_connect, $rs_findgroupname);
$rs_result_gnq = mysqli_fetch_object($rs_resultgn);
$groupname = "$rs_result_gnq->pcgroupname";

} else {

$rs_findpaypalcust = "SELECT * FROM savedcardscustomers WHERE groupid = '$groupid' AND sccplugin = 'PayPal'";
$rs_result = mysqli_query($rs_connect, $rs_findpaypalcust);
$rs_result_q = mysqli_fetch_object($rs_result);
$sccid = "$rs_result_q->sccid";

}


$last4  = substr("$card->number", -4);
$brand = $card->type;
$expmonth = $card->expire_month;
$expyear= $card->expire_year;


if($addtype == "new") {
$insertcust = "INSERT INTO savedcardscustomers (sccprocid,sccplugin,groupid) VALUES ('$groupname','PayPal','$groupid')";
@mysqli_query($rs_connect, $insertcust);
$sccid = mysqli_insert_id($rs_connect);
}


$setdefault = "UPDATE savedcards SET savedcarddefault = '0' WHERE sccid = '$sccid'";
@mysqli_query($rs_connect, $setdefault);

$insertcard = "INSERT INTO savedcards (savedcardfour,savedcardexpmonth,savedcardexpyear,savedcardname,sccid,savedcardbrand,savedcardprocid,savedcarddefault) VALUES ('$last4','$expmonth','$expyear','$cardnamefirst $cardnamelast','$sccid','$cardtype','$paypalcard','1')";
@mysqli_query($rs_connect, $insertcard);

header("Location: ../repair/group.php?func=viewgroup&pcgroupid=$groupid&groupview=savedcards");

                                                                                                                                               
}


function delete() {

require("deps.php");
require_once("validate.php");
require_once("common.php");

$cardid = $_REQUEST['cardid'];
$groupid = $_REQUEST['groupid'];
$pcrtcardid = $_REQUEST['pcrtcardid'];
$custid = $_REQUEST['custid'];






$deletecard = "DELETE FROM savedcards WHERE savedcardid = '$pcrtcardid'";
@mysqli_query($rs_connect, $deletecard);


require("paypalbootstrap.php");

$creditCard = PayPal\Api\CreditCard::get("$cardid", $apiContext);

try {

$creditCard->delete($apiContext);

} catch (Exception $ex) {

echo pcrtlang("Notice: Card has been deleted, but the card was not found at PayPal");

echo $ex;

exit(1);

}





header("Location: ../repair/group.php?func=viewgroup&pcgroupid=$groupid&groupview=savedcards");

}


function setdefault() {

require("deps.php");
require_once("validate.php");
require_once("common.php");

$cardid = $_REQUEST['cardid'];
$groupid = $_REQUEST['groupid'];
$pcrtcardid = $_REQUEST['pcrtcardid'];
$pcrtcustid = $_REQUEST['pcrtcustid'];
$custid = $_REQUEST['custid'];






$cleardefault = "UPDATE savedcards SET savedcarddefault = '0' WHERE sccid = '$pcrtcustid'";
@mysqli_query($rs_connect, $cleardefault);
$setdefault = "UPDATE savedcards SET savedcarddefault = '1' WHERE savedcardid = '$pcrtcardid'";
@mysqli_query($rs_connect, $setdefault);

header("Location: ../repair/group.php?func=viewgroup&pcgroupid=$groupid&groupview=savedcards");

}


function charge() {
require_once("validate.php");

require("deps.php");
require_once("common.php");

$amounttopay = $_REQUEST['currenttotal'];
$sccid = pv($_REQUEST['sccid']);






$rs_find_paypal_customers = "SELECT * FROM savedcardscustomers WHERE sccid = '$sccid'";
$rs_result_fsc = mysqli_query($rs_connect, $rs_find_paypal_customers);

$rs_result_q = mysqli_fetch_object($rs_result_fsc);
$paypalcustomer = "$rs_result_q->sccprocid";
$paypalcustomerlocalid = "$rs_result_q->sccid";
$scgroupid = "$rs_result_q->groupid";


$rs_find_paypal_cards = "SELECT * FROM savedcards WHERE sccid = '$paypalcustomerlocalid' AND savedcarddefault = '1'";
$rs_result_cards = mysqli_query($rs_connect, $rs_find_paypal_cards);

$rs_result_q = mysqli_fetch_object($rs_result_cards);
$paypalcardlocalid = "$rs_result_q->savedcardid";
$paypalcardfour = "$rs_result_q->savedcardfour";
$paypalcardexpmonth = "$rs_result_q->savedcardexpmonth";
$paypalcardexpyear = "$rs_result_q->savedcardexpyear";
$custname = "$rs_result_q->savedcardname";
$paypalcardbrand = "$rs_result_q->savedcardbrand";
$savedcardprocid = "$rs_result_q->savedcardprocid";
$paypalcarddefault = "$rs_result_q->savedcarddefault";


if ($demo == "yes") {
die("Sorry this feature is disabled in demo mode");
}

$storeinfoarray = getstoreinfo($defaultuserstore);

require("paypalbootstrap.php");

$isapproved = 1;


$card = PayPal\Api\CreditCard::get("$savedcardprocid", $apiContext);

$creditCardToken = new PayPal\Api\CreditCardToken();
$creditCardToken->setCreditCardId($card->getId());

$fi = new PayPal\Api\FundingInstrument();
$fi->setCreditCardToken($creditCardToken);

$payer = new PayPal\Api\Payer();
$payer->setPaymentMethod("credit_card")
    ->setFundingInstruments(array($fi));

$amount = new PayPal\Api\Amount();
$amount->setCurrency("$PayPalRestCurrencyCode")
    ->setTotal("$amounttopay");

$transaction = new PayPal\Api\Transaction();
$transaction->setAmount($amount)
    ->setDescription("Services");

	
$payment = new PayPal\Api\Payment();
$payment->setIntent("sale")
    ->setPayer($payer)
    ->setTransactions(array($transaction));

$request = clone $payment;

try {
    $payment->create($apiContext);
} catch (Exception $ex) {
$isapproved = 0;
    exit(1);
}



if ($isapproved == 0) {
require_once("common.php");
echo "<span style=\"font-size:20px;\">".pcrtlang("Credit Card Declined")."</span><br><br>";
$thereason = $ex;
echo pcrtlang("Reason").":<br><br><span style=\"font-size:16px;font-color:red\">$thereason</span>";
} else {

$cc_transid = $payment->transactions[0]->related_resources[0]->sale->id;

$cccardtype = "$paypalcardbrand";

$ccnumber2 = "$paypalcardfour";

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');


$rs_insert_gcc = "INSERT INTO currentpayments 
        (pfirstname,byuser,amount,paymentplugin,paymentstatus,paymenttype,cc_number,cc_expmonth,cc_expyear,cc_transid,cc_cardtype)
VALUES ('$custname','$ipofpc','$amounttopay','PayPalRest','ready','credit','$ccnumber2','$paypalcardmonth','$paypalcardyear','$cc_transid','$cccardtype')";
@mysqli_query($rs_connect, $rs_insert_gcc);

header("Location: $domain/cart.php");

}

}





switch($func) {
                                                                                                                             
    default:
    nothing();
    break;

    case "view":
    view();
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


case "charge":
    charge();
    break;

case "delete":
    delete();
    break;

case "setdefault":
    setdefault();
    break;


}

?>
