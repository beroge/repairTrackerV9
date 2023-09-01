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






include_once ("../store/AuthorizeNetCIMfunctions.php");

$content =
	"<?xml version=\"1.0\" encoding=\"utf-8\"?>".
	"<createCustomerProfileTransactionRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">".
        MerchantAuthenticationBlock().
  	"<transaction>".
    	"<profileTransVoid>".
      	"<transId>$cc_transid</transId>".
    	"</profileTransVoid>".
  	"</transaction>".
	"</createCustomerProfileTransactionRequest>";


$response = send_xml_request($content);
$parsedresponse = parse_api_response($response);

if ("Ok" == $parsedresponse->messages->resultCode) {

} else {
die(pcrtlang("Failed to Void Payment"));
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
