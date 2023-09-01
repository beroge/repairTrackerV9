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
require_once("header.php");


require_once("footer.php");
                                                                                                    
}

function view() {
require("deps.php");
require_once("validate.php");
require_once("common.php");

$groupid =  $_REQUEST['groupid'];





$rs_find_stripe_customers = "SELECT * FROM savedcardscustomers WHERE groupid = '$groupid' AND sccplugin = 'Stripe'";
$rs_result_fsc = mysqli_query($rs_connect, $rs_find_stripe_customers);


$custcount = mysqli_num_rows($rs_result_fsc);

if ($custcount != 0) {

$rs_result_q = mysqli_fetch_object($rs_result_fsc);
$stripecustomer = "$rs_result_q->sccprocid";
$stripecustomerlocalid = "$rs_result_q->sccid";

$rs_find_stripe_cards = "SELECT * FROM savedcards WHERE sccid = '$stripecustomerlocalid'";
$rs_result_cards = mysqli_query($rs_connect, $rs_find_stripe_cards);


while($rs_result_q = mysqli_fetch_object($rs_result_cards)) {
$stripecardlocalid = "$rs_result_q->savedcardid";
$stripecardfour = "$rs_result_q->savedcardfour";
$stripecardexpmonth = "$rs_result_q->savedcardexpmonth";
$stripecardexpyear = "$rs_result_q->savedcardexpyear";
$stripecardname = "$rs_result_q->savedcardname";
$stripecardbrand = "$rs_result_q->savedcardbrand";
$stripecardprocid = "$rs_result_q->savedcardprocid";
$stripecarddefault = "$rs_result_q->savedcarddefault";
echo "<table class=standard>";
echo "<tr><th>".pcrtlang("Card Holder")."</th><td>$stripecardname</td></tr>";
echo "<tr><th>".pcrtlang("Last 4 Card Digits")."</th><td>$stripecardfour";
if($stripecarddefault == 1) {
echo " (".pcrtlang("default").")";
}

echo "</td></tr>";
echo "<tr><th>".pcrtlang("Expiration")."</th><td>$stripecardexpmonth / $stripecardexpyear</td></tr>";
echo "<tr><th>".pcrtlang("Card Type")."</th><td>$stripecardbrand</td></tr>";
echo "<tr><th>".pcrtlang("Actions")."</th><td>";
echo "<a href=\"../storemobile/Stripe_stored.php?func=delete&groupid=$groupid&cardid=$stripecardprocid&pcrtcardid=$stripecardlocalid&custid=$stripecustomer\" onClick=\"return confirm('".pcrtlang("ARE YOU SURE YOU WANT TO DELETE THIS CARD?")."');\"  class=\"ui-btn ui-corner-all ui-shadow\">
<i class=\"fa fa-times fa-lg\"></i> ".pcrtlang("Delete Card")."</a>&nbsp;&nbsp;&nbsp;";

if($stripecarddefault == 0) {
echo "<a href=\"../store/Stripe_stored.php?func=setdefault&groupid=$groupid&cardid=$stripecardprocid&pcrtcardid=$stripecardlocalid&custid=$stripecustomer&pcrtcustid=$stripecustomerlocalid\" class=\"ui-btn ui-corner-all ui-shadow\">
<i class=\"fa fa-credit-card fa-lg\"></i> ".pcrtlang("Set as Default Card")."</a>";
}

echo "</td></tr>";
echo "</table><br><br>";
}

}

if ($custcount == 0) {
echo "<br><button type=button onClick=\"parent.location='../store/Stripe_stored.php?func=add&groupid=$groupid&addtype=new'\" data-theme=\"b\">
<i class=\"fa fa-credit-card fa-lg\"></i> ".pcrtlang("Add Stripe Card and Customer")."</button>";
} else {
echo "<br><button type=button onClick=\"parent.location='../storemobile/Stripe_stored.php?func=add&groupid=$groupid&addtype=existing'\">
<i class=\"fa fa-credit-card fa-lg\"></i> ".pcrtlang("Add Card to Stripe")."</button>";
}





}



function add() {

$groupid =  $_REQUEST['groupid'];
$addtype =  $_REQUEST['addtype'];


require("dheader.php");

echo "<div data-role=\"header\" data-theme=\"b\"><h2>".pcrtlang("Swipe Card")."</h2></div>";
echo "<div class=\"ui-content\" role=\"main\">";


echo "<form name=c action=$securedomain"."mobile/Stripe_stored.php?func=add2 method=post data-ajax=\"false\"><input autofocus type=password name=swipedata autocomplete=off>";

echo "<input type=hidden name=groupid value=\"$groupid\">";
echo "<input type=hidden name=addtype value=\"$addtype\">";

echo "<input type=submit value=\"".pcrtlang("Proceed")."\"></form>";

echo "</div>";

require("dfooter.php");


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
                                                                                                                                               
require("dheader.php");

echo "<div data-role=\"header\" data-theme=\"b\"><h2>".pcrtlang("Add Card")."</h2></div>";
echo "<div class=\"ui-content\" role=\"main\">";


?>

 <form action="Stripe_stored.php?func=add3" method="POST" id="payment-form"  data-ajax="false">
    <span class="payment-errors"></span>

    <div style="padding:3px;">
      <label>
        <span><?php echo pcrtlang("Card Name"); ?></span>
        <input type="text" name="cardname" value="<?php echo "$ccname $ccname2"; ?>">
      </label>
    </div>


    <div style="padding:3px;">
      <label>
        <span><?php echo pcrtlang("Card Number"); ?></span>
        <input type="text" data-stripe="number" value="<?php echo "$cardnumber"; ?>">
      </label>
    </div>

    <div style="padding:3px;">
      <label>
        <span><?php echo pcrtlang("CVC"); ?></span>
        <input type="text" data-stripe="cvc"/>
      </label>
    </div>

    <div style="padding:3px;">
      <label>
        <span><?php echo pcrtlang("Expiration (MM YYYY)"); ?></span>
        <input type="text" data-stripe="exp-month" value="<?php echo "$ccexpmonth"; ?>" placeholder="<?php echo "Enter 2 Digit Month"; ?>">
      </label>
      <input type="text" data-stripe="exp-year" value="<?php echo "$ccexpyear"; ?>" placeholder="<?php echo "Enter 4 Digit Year"; ?>">
    </div>

   <input type=hidden name=groupid value="<?php echo "$groupid"; ?>">
   <input type=hidden name=addtype value="<?php echo "$addtype"; ?>">

    <button type="submit"><?php echo pcrtlang("Submit Card"); ?></button>
  </form>


<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script type="text/javascript">
    // This identifies your website in the createToken call below
    Stripe.setPublishableKey('<?php echo "$stripe_api_key_public"; ?>');
    var stripeResponseHandler = function(status, response) {
      var $form = $('#payment-form');
      if (response.error) {
        // Show the errors on the form
        $form.find('.payment-errors').text(response.error.message);
        $form.find('button').prop('disabled', false);
      } else {
        // token contains id, last4, and card type
        var token = response.id;
        // Insert the token into the form so it gets submitted to the server
        $form.append($('<input type="hidden" name="stripeToken" />').val(token));
        // and re-submit
        $form.get(0).submit();
      }
    };
    jQuery(function($) {
      $('#payment-form').submit(function(e) {
        var $form = $(this);
        // Disable the submit button to prevent repeated clicks
        $form.find('button').prop('disabled', true);
        Stripe.card.createToken($form, stripeResponseHandler);
        // Prevent the form from submitting with the default action
        return false;
      });
    });
  </script>



<?php



echo "</div>";

require("dfooter.php");
}



function add3() {

require("deps.php");
require_once("validate.php");
require_once("common.php");

require_once('../store/stripe/init.php');

$token = $_REQUEST['stripeToken'];
$cardname = $_REQUEST['cardname'];
$groupid = $_REQUEST['groupid'];
$addtype =  $_REQUEST['addtype'];






\Stripe\Stripe::setApiKey("$stripe_api_key");

if($addtype == "new") {

$rs_findgroupname = "SELECT * FROM pc_group WHERE pcgroupid = '$groupid'";
$rs_resultgn = mysqli_query($rs_connect, $rs_findgroupname);
$rs_result_gnq = mysqli_fetch_object($rs_resultgn);
$groupname = "$rs_result_gnq->pcgroupname";


$customer = \Stripe\Customer::create(array(
  "source" => $token,
  "description" => "$groupid $groupname")
);
$stripecustomer = $customer->id;
$stripecard = $customer->default_source;

$cu = \Stripe\Customer::retrieve("$stripecustomer");
$card = $cu->sources->retrieve("$stripecard");
$card->name = "$cardname";
$card->save();

} else {

$rs_findstripecust = "SELECT * FROM savedcardscustomers WHERE groupid = '$groupid' AND sccplugin = 'Stripe'";
$rs_result = mysqli_query($rs_connect, $rs_findstripecust);
$rs_result_q = mysqli_fetch_object($rs_result);
$stripecustomer = "$rs_result_q->sccprocid";
$sccid = "$rs_result_q->sccid";

$cu = \Stripe\Customer::retrieve("$stripecustomer");
$newcard = $cu->sources->create(array("source" => "$token"));
$stripecard = $newcard->id;

$card = $cu->sources->retrieve("$stripecard");
$card->name = "$cardname";
$card->save();


}


$customer = \Stripe\Customer::retrieve("$stripecustomer");
$card = $customer->sources->retrieve("$stripecard");


$last4 = $card->last4;
$brand = $card->brand;
$expmonth = $card->exp_month;
$expyear= $card->exp_year;


if($addtype == "new") {
$insertcust = "INSERT INTO savedcardscustomers (sccprocid,sccplugin,groupid) VALUES ('$stripecustomer','Stripe','$groupid')";
@mysqli_query($rs_connect, $insertcust);
$sccid = mysqli_insert_id($rs_connect);
}


$setdefault = "UPDATE savedcards SET savedcarddefault = '0' WHERE sccid = '$sccid'";
@mysqli_query($rs_connect, $setdefault);


$insertcard = "INSERT INTO savedcards (savedcardfour,savedcardexpmonth,savedcardexpyear,savedcardname,sccid,savedcardbrand,savedcardprocid,savedcarddefault) VALUES ('$last4','$expmonth','$expyear','$cardname','$sccid','$brand','$stripecard','1')";
@mysqli_query($rs_connect, $insertcard);

header("Location: ../repair/group.php?func=viewgroup&pcgroupid=$groupid#savedcards");

                                                                                                                                               
}


function delete() {

require("deps.php");
require_once("validate.php");
require_once("common.php");

require_once('../store/stripe/init.php');

$cardid = $_REQUEST['cardid'];
$groupid = $_REQUEST['groupid'];
$pcrtcardid = $_REQUEST['pcrtcardid'];
$custid = $_REQUEST['custid'];





$deletecard = "DELETE FROM savedcards WHERE savedcardid = '$pcrtcardid'";
@mysqli_query($rs_connect, $deletecard);

try {
\Stripe\Stripe::setApiKey("$stripe_api_key");

$cu = \Stripe\Customer::retrieve("$custid");
$cu->sources->retrieve("$cardid")->delete();
}
  catch (Exception $e) {
    $error = $e->getMessage();

echo pcrtlang("Notice: Card has been deleted, but the card was not found at Stripe");

echo "$error";


}



header("Location: ../repair/group.php?func=viewgroup&pcgroupid=$groupid#savedcards");

}


function setdefault() {

require("deps.php");
require_once("validate.php");
require_once("common.php");

require_once('../store/stripe/init.php');

$cardid = $_REQUEST['cardid'];
$groupid = $_REQUEST['groupid'];
$pcrtcardid = $_REQUEST['pcrtcardid'];
$pcrtcustid = $_REQUEST['pcrtcustid'];
$custid = $_REQUEST['custid'];






\Stripe\Stripe::setApiKey("$stripe_api_key");

$cu = \Stripe\Customer::retrieve("$custid");
$cu->default_source = "$cardid"; 
$cu->save();


$cleardefault = "UPDATE savedcards SET savedcarddefault = '0' WHERE sccid = '$pcrtcustid'";
@mysqli_query($rs_connect, $cleardefault);
$setdefault = "UPDATE savedcards SET savedcarddefault = '1' WHERE savedcardid = '$pcrtcardid'";
@mysqli_query($rs_connect, $setdefault);

header("Location: ../repair/group.php?func=viewgroup&pcgroupid=$groupid#savedcards");

}


function charge() {
require_once("validate.php");

require("deps.php");
require_once("common.php");

$amounttopay = $_REQUEST['currenttotal'];
$sccid = pv($_REQUEST['sccid']);


$rs_find_stripe_customers = "SELECT * FROM savedcardscustomers WHERE sccid = '$sccid'";
$rs_result_fsc = mysqli_query($rs_connect, $rs_find_stripe_customers);

$rs_result_q = mysqli_fetch_object($rs_result_fsc);
$stripecustomer = "$rs_result_q->sccprocid";
$stripecustomerlocalid = "$rs_result_q->sccid";
$scgroupid = "$rs_result_q->groupid";


$rs_find_stripe_cards = "SELECT * FROM savedcards WHERE sccid = '$stripecustomerlocalid' AND savedcarddefault = '1'";
$rs_result_cards = mysqli_query($rs_connect, $rs_find_stripe_cards);

$rs_result_q = mysqli_fetch_object($rs_result_cards);
$stripecardlocalid = "$rs_result_q->savedcardid";
$stripecardfour = "$rs_result_q->savedcardfour";
$stripecardexpmonth = "$rs_result_q->savedcardexpmonth";
$stripecardexpyear = "$rs_result_q->savedcardexpyear";
$custname = "$rs_result_q->savedcardname";
$stripecardbrand = "$rs_result_q->savedcardbrand";
$savedcardprocid = "$rs_result_q->savedcardprocid";
$stripecarddefault = "$rs_result_q->savedcarddefault";







if ($demo == "yes") {
die("Sorry this feature is disabled in demo mode");
}

$storeinfoarray = getstoreinfo($defaultuserstore);

$amounttopaycents = number_format($amounttopay, 2, '', '');

require_once('../store/stripe/init.php');

$isapproved = 1;

try {
\Stripe\Stripe::setApiKey("$stripe_api_key");
$ch = \Stripe\Charge::create(array(
  "amount" => "$amounttopaycents",
  "currency" => "$stripe_currency",
  "customer" => "$stripecustomer",
  "description" => pcrtlang("Charge from")." $storeinfoarray[storename]")
);

}
  catch (Exception $e) {
    $chargeerror = $e->getMessage();
$isapproved = 0;
}



if ($isapproved == 0) {
require_once("common.php");
echo "<font size=6>".pcrtlang("Credit Card Declined")."</font><br><br>";
$thereason = $chargeerror;
echo pcrtlang("Reason").":<br><br><font color=red size=5>$thereason</font>";
} else {

$cc_transid = $ch->id;
$cardinfo = $ch->card;
$cccardtype = $cardinfo['type'];

$ccnumber2 = "$stripecardfour";

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');


$rs_insert_gcc = "INSERT INTO currentpayments 
        (pfirstname,byuser,amount,paymentplugin,paymentstatus,paymenttype,cc_number,cc_expmonth,cc_expyear,cc_transid,cc_cardtype)
VALUES ('$custname','$ipofpc','$amounttopay','Stripe','ready','credit','$ccnumber2','$stripecardexpmonth','$stripecardexpyear','$cc_transid','$cccardtype')";
@mysqli_query($rs_connect, $rs_insert_gcc);

header("Location: $domain"."mobile/cart.php");

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
