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

echo "<form action=$securedomain/Stripe.php?func=add3 method=post id=\"payment-form\" class=\"form-inline\">";
echo "<table class=table style=\"max-width:400px;\"><tr><td>";
echo pcrtlang("Amount to Pay").": </td><td>$money $amounttopay<input type=hidden name=amounttopay value=\"".mf("$amounttopay")."\"><input type=hidden name=invtotal value=\"".mf("$invtotal")."\"><input type=hidden name=invtax value=\"$invtax\"></td></tr>";

echo "<tr><td colspan=2>"

?>

    <span class="payment-errors"></span>

    <div style="padding:3px;">
      <label>
        <span><?php echo pcrtlang("Card Name"); ?></span>
        <input type="text" class=form-control size="20" name="cardname">
      </label>
    </div>


    <div style="padding:3px;">
      <label>
        <span><?php echo pcrtlang("Card Number"); ?></span>
        <input type="text" class=form-control size="20" data-stripe="number">
      </label>
    </div>

    <div style="padding:3px;">
      <label>
        <span><?php echo pcrtlang("3 Digit Security Code"); ?></span>
        <input type="text" class=form-control size="4" data-stripe="cvc"/>
      </label>
    </div>

    <div style="padding:3px;">
      <label>
        <span><?php echo pcrtlang("Expiration (MM/YYYY)"); ?></span>
        <input type="text" class=form-control  style="width:50px" data-stripe="exp-month" placeholder="MM"> / <input type="text" class=form-control style="width:100px" data-stripe="exp-year" placeholder="YYYY">
      </label>
    </div>


<?php

echo "</td></tr>";
echo "<tr><td colspan=2>&nbsp;</td></tr>";


echo "<input type=hidden name=invoiceid value=\"$invoiceid\">";


echo "<tr><td></td><td><input type=submit class=\"btn btn-primary\" value=\"".pcrtlang("Pay Invoice")."\"></td></tr></table></form>";

?>

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


require("footer.php");
}



function add3() {
require_once("validate.php");

require("deps.php");
require_once("common.php");

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');


$invtotal = $_REQUEST['invtotal'];
$invtax = $_REQUEST['invtax'];

$cardname = $_REQUEST['cardname'];
$splitthename = explode(' ', "$cardname", 2);
$cfirstname = $splitthename[0];

if (array_key_exists('1',$splitthename)) {
$clastname = $splitthename[1];
} else {
$clastname = "";
}

$custname = trim("$cfirstname")." ".trim("$clastname");

$amounttopay = $_REQUEST['amounttopay'];

$invoiceid = pv($_REQUEST['invoiceid']);

$token = $_REQUEST['stripeToken'];

if ($demo == "yes") {
die("Sorry this feature is disabled in demo mode");
}

$amounttopaycents = number_format($amounttopay, 2, '', ''); 

require_once('stripe/init.php');

$isapproved = 1;

try {
\Stripe\Stripe::setApiKey("$stripe_api_key");
$ch = \Stripe\Charge::create(array(
  "amount" => "$amounttopaycents",
  "currency" => "$stripe_currency",
  "source" => $token,
  "description" => pcrtlang("Charge from")." $cardname - $businessname")
);

}
  catch (Exception $e) {
    $chargeerror = $e->getMessage();

	
	$isapproved = 0;
}


if ($isapproved == 0) {

require_once("common.php");
require("header.php");
echo "<br><br><br><div class=\"bg-danger text-center\">";
echo "<br><h3 class=\"text-danger\"><i class=\"fa fa-warning fa-lg\"></i> ".pcrtlang("Payment Failed")."...</h3><br>";
$thereason = $chargeerror;
echo pcrtlang("Reason").": $thereason<br><br>";
echo "<a href=index.php><i class=\"fa fa-home fa-lg\"></i> ".pcrtlang("Go Home")."</a><br><br>";
echo "</div>";
require("footer.php");

} else {


$cc_transid = $ch->id;
$ccmonth = $ch->source->exp_month;
$ccyear = $ch->source->exp_year;
$ccnumber2 = $ch->source->last4;
$cccardtype = $ch->source->brand;


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
