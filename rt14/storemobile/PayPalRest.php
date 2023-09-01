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

function void() {

require("deps.php");
require_once("validate.php");
require_once("common.php");

$payid = $_REQUEST['payid'];
$cc_transid = $_REQUEST['cc_transid'];
$refundamount = $_REQUEST['refundamount'];







require("paypalbootstrap.php");

$saleId = "$cc_transid";

$amt = new \PayPal\Api\Amount(); 
$amt->setCurrency("$PayPalRestCurrencyCode") ->setTotal("$refundamount");

$refund = new \PayPal\Api\Refund();
$refund->setAmount($amt);

$sale = new \PayPal\Api\Sale();
$sale->setId($saleId);

try {

$sale->refund($refund, $apiContext);

} catch (Exception $ex) {

echo $ex;

exit(1);

}



$deletecard = "DELETE FROM currentpayments WHERE paymentid = '$payid'";
@mysqli_query($rs_connect, $deletecard);



header("Location: cart.php");

}




switch($func) {
                                                                                                                             
    default:
    nothing();
    break;

case "void":
    void();
    break;



}

?>
