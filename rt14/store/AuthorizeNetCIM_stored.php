<?php

/***************************************************************************
 *   copyright            : (C) 2015 PCRepairTracker.com
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





$rs_find_an_customers = "SELECT * FROM savedcardscustomers WHERE groupid = '$groupid' AND sccplugin = 'AuthorizeNetCIM'";
$rs_result_fsc = mysqli_query($rs_connect, $rs_find_an_customers);


$custcount = mysqli_num_rows($rs_result_fsc);

if ($custcount != 0) {

$rs_result_q = mysqli_fetch_object($rs_result_fsc);
$ancustomer = "$rs_result_q->sccprocid";
$ancustomerlocalid = "$rs_result_q->sccid";

$rs_find_an_cards = "SELECT * FROM savedcards WHERE sccid = '$ancustomerlocalid'";
$rs_result_cards = mysqli_query($rs_connect, $rs_find_an_cards);


echo "<table class=\"standard pad10\">";
echo "<tr><th>".pcrtlang("Card Holder")."</th>";
echo "<th>".pcrtlang("Last 4 Card Digits")."</th>";
echo "<th>".pcrtlang("Expiration")."</th>";
echo "<th>".pcrtlang("Card Type")."</th>";
echo "<th>".pcrtlang("Actions")."</th></tr>";

while($rs_result_q = mysqli_fetch_object($rs_result_cards)) {
$ancardlocalid = "$rs_result_q->savedcardid";
$ancardfour = "$rs_result_q->savedcardfour";
$ancardexpmonth = "$rs_result_q->savedcardexpmonth";
$ancardexpyear = "$rs_result_q->savedcardexpyear";
$ancardname = "$rs_result_q->savedcardname";
$ancardbrand = "$rs_result_q->savedcardbrand";
$ancardprocid = "$rs_result_q->savedcardprocid";
$ancarddefault = "$rs_result_q->savedcarddefault";

echo "<tr><td>$ancardname</td>";
echo "<td>$ancardfour";
if($ancarddefault == 1) {
echo " (".pcrtlang("default").")";
}

echo "</td>";
echo "<td>$ancardexpmonth / $ancardexpyear</td>";
echo "<td>$ancardbrand</td>";
echo "<td>";
echo "<a href=\"../store/AuthorizeNetCIM_stored.php?func=delete&groupid=$groupid&cardid=$ancardprocid&pcrtcardid=$ancardlocalid&custid=$ancustomer\" 
onClick=\"return confirm('".pcrtlang("ARE YOU SURE YOU WANT TO DELETE THIS CARD?")."');\" class=\"linkbuttonsmall linkbuttongray radiusall\">
<i class=\"fa fa-times fa-lg\"></i> ".pcrtlang("Delete Card")."</a>&nbsp;&nbsp;&nbsp;";

if($ancarddefault == 0) {
echo "<a href=\"../store/AuthorizeNetCIM_stored.php?func=setdefault&groupid=$groupid&cardid=$ancardprocid&pcrtcardid=$ancardlocalid&custid=$ancustomer&pcrtcustid=$ancustomerlocalid\" class=\"linkbuttonsmall linkbuttongray radiusall\">
<i class=\"fa fa-credit-card fa-lg\"></i> ".pcrtlang("Set as Default Card")."</a>";
}

echo "</td></tr>";

}
echo "</table>";

}

if ($custcount == 0) {
echo "<br><button class=button type=button onClick=\"parent.location='../store/AuthorizeNetCIM_stored.php?func=add&groupid=$groupid&addtype=new'\">
<i class=\"fa fa-credit-card fa-lg\"></i> ".pcrtlang("Add AuthorizeNet CIM Card and Customer")."</button>";
} else {
echo "<br><button class=button type=button onClick=\"parent.location='../store/AuthorizeNetCIM_stored.php?func=add&groupid=$groupid&addtype=existing'\">
<i class=\"fa fa-credit-card fa-lg\"></i> ".pcrtlang("Add Card to AuthorizeNet CIM")."</button>";
}





}



function add() {

$groupid =  $_REQUEST['groupid'];
$addtype =  $_REQUEST['addtype'];


require("header.php");


start_box();
echo "<font class=text14b>".pcrtlang("Swipe Credit Card NOW")."! (Stored AuthorizeNet CIM)</font><br><br>";

echo "<form name=c action=$securedomain/AuthorizeNetCIM_stored.php?func=add2 method=post><input autofocus class=textbox type=password name=swipedata autocomplete=off>";

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

start_blue_box(pcrtlang("Add Credit Card Payment")." (AuthorizeNet CIM Stored)");


?>

 <form action="AuthorizeNetCIM_stored.php?func=add3" method="POST" id="payment-form">

    <div style="padding:3px;">
      <label>
        <span><?php echo pcrtlang("Card First Name"); ?></span>
        <input type="text" class=textbox size="20" name="cardnamefirst" value="<?php echo "$ccname"; ?>">
      </label>
    </div>

    <div style="padding:3px;">
      <label>
        <span><?php echo pcrtlang("Card Last Name"); ?></span>
        <input type="text" class=textbox size="20" name="cardnamelast" value="<?php echo "$ccname2"; ?>">
      </label>
    </div>


    <div style="padding:3px;">
      <label>
        <span><?php echo pcrtlang("Card Number"); ?></span>
        <input type="text" class=textbox size="20" name=cardnumber value="<?php echo "$cardnumber"; ?>">
      </label>
    </div>

    <div style="padding:3px;">
      <label>
        <span><?php echo pcrtlang("CVC"); ?></span>
        <input type="text" class=textbox size="4" name="cvc">
      </label>
    </div>

    <div style="padding:3px;">
      <label>
        <span><?php echo pcrtlang("Expiration (MM/YYYY)"); ?></span>
        <input type="text" class=textbox size="2" name="ccexpmonth" value="<?php echo "$ccexpmonth"; ?>">
      </label>
      <span> / </span>
      <input type="text" class=textbox size="4" name="ccexpyear" value="<?php echo "$ccexpyear"; ?>">
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
$groupid = $_REQUEST['groupid'];
$addtype =  $_REQUEST['addtype'];
$ccexpmonth =  $_REQUEST['ccexpmonth'];
$ccexpyear =  $_REQUEST['ccexpyear'];
$cvc =  $_REQUEST['cvc'];

include_once ("AuthorizeNetCIMfunctions.php");






$rs_findgroupname = "SELECT * FROM pc_group WHERE pcgroupid = '$groupid'";
$rs_resultgn = mysqli_query($rs_connect, $rs_findgroupname);
$rs_result_gnq = mysqli_fetch_object($rs_resultgn);
$groupid = "$rs_result_gnq->pcgroupid";
$groupname = "$rs_result_gnq->pcgroupname";
$grpcompany = "$rs_result_gnq->grpcompany";
$grpemail = "$rs_result_gnq->grpemail";
$grpphone = "$rs_result_gnq->grpphone";
$grpaddress = "$rs_result_gnq->grpaddress1";
$grpcity = "$rs_result_gnq->grpcity";
$grpstate = "$rs_result_gnq->grpstate";
$grpzip = "$rs_result_gnq->grpzip";

if($addtype == "new") {


$content =
	"<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
	"<createCustomerProfileRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">" .
	MerchantAuthenticationBlock().
	"<profile>".
	"<merchantCustomerId>$groupid</merchantCustomerId>". // Your own identifier for the customer.
	"<description></description>".
	"<email>$grpemail</email>".
	"</profile>".
	"</createCustomerProfileRequest>";

$response = send_xml_request($content);
$parsedresponse = parse_api_response($response);

if ("Ok" == $parsedresponse->messages->resultCode) {
$ancustomer = $parsedresponse->customerProfileId;

$insertcust = "INSERT INTO savedcardscustomers (sccprocid,sccplugin,groupid) VALUES ('$ancustomer','AuthorizeNetCIM','$groupid')";
@mysqli_query($rs_connect, $insertcust);
$sccid = mysqli_insert_id($rs_connect);

} else {
die(pcrtlang("Failed to create CIM customer profile"));
}

} else {

$rs_find_an_customers = "SELECT * FROM savedcardscustomers WHERE groupid = '$groupid' AND sccplugin = 'AuthorizeNetCIM'";
$rs_result_fsc = mysqli_query($rs_connect, $rs_find_an_customers);
$rs_result_q = mysqli_fetch_object($rs_result_fsc);
$ancustomer = "$rs_result_q->sccprocid";
$sccid = "$rs_result_q->sccid";

}





$contentcard =
	"<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
	"<createCustomerPaymentProfileRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">" .
	MerchantAuthenticationBlock().
	"<customerProfileId>$ancustomer</customerProfileId>".
	"<paymentProfile>".
    "<billTo>".
     "<firstName>$cardnamefirst</firstName>".
     "<lastName>$cardnamelast</lastName>".
     "<company>$grpcompany</company>".
     "<address>$grpaddress</address>".
     "<city>$grpcity</city>".
     "<state>$grpstate</state>".
     "<zip>$grpzip</zip>".
     "<country>X</country>".
     "<phoneNumber>$grpphone</phoneNumber>".
     "<faxNumber>X</faxNumber>".
    "</billTo>".
	"<payment>".
	 "<creditCard>".
	  "<cardNumber>$cardnumber</cardNumber>".
	  "<expirationDate>$ccexpyear"."-"."$ccexpmonth</expirationDate>". // required format for API is YYYY-MM
	 "</creditCard>".
	"</payment>".
	"</paymentProfile>".
	"<validationMode>testMode</validationMode>". // or testMode
	"</createCustomerPaymentProfileRequest>";


$responsecard = send_xml_request($contentcard);
$parsedresponsecard = parse_api_response($responsecard);


if ("Ok" == $parsedresponsecard->messages->resultCode) {

$ancard = $parsedresponsecard->customerPaymentProfileId;

$last4  = substr("$cardnumber", -4);
$brand = "";
$expmonth = $ccexpmonth;
$expyear= $ccexpyear;


$setdefault = "UPDATE savedcards SET savedcarddefault = '0' WHERE sccid = '$sccid'";
@mysqli_query($rs_connect, $setdefault);


$insertcard = "INSERT INTO savedcards (savedcardfour,savedcardexpmonth,savedcardexpyear,savedcardname,sccid,savedcardbrand,savedcardprocid,savedcarddefault) 
VALUES ('$last4','$expmonth','$expyear','$cardnamefirst $cardnamelast','$sccid','$brand','$ancard','1')";
@mysqli_query($rs_connect, $insertcard);

header("Location: ../repair/group.php?func=viewgroup&pcgroupid=$groupid&groupview=savedcards");

}
                                                                                                                                               
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

include_once ("AuthorizeNetCIMfunctions.php");

$content =
	"<?xml version=\"1.0\" encoding=\"utf-8\"?>".
	"<deleteCustomerPaymentProfileRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">".
        MerchantAuthenticationBlock().
  	"<customerProfileId>$custid</customerProfileId>".
  	"<customerPaymentProfileId>$cardid</customerPaymentProfileId>".
	"</deleteCustomerPaymentProfileRequest>";

$response = send_xml_request($content);
$parsedresponse = parse_api_response($response);

if ("Ok" == $parsedresponse->messages->resultCode) {

} else {
die(pcrtlang("Card Deleted, but failed to find/delete CIM payment profile at AuthorizeNet"));
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

include_once ("AuthorizeNetCIMfunctions.php");

$amounttopay = $_REQUEST['currenttotal'];
$sccid = pv($_REQUEST['sccid']);


$rs_find_an_customers = "SELECT * FROM savedcardscustomers WHERE sccid = '$sccid'";
$rs_result_fsc = mysqli_query($rs_connect, $rs_find_an_customers);

$rs_result_q = mysqli_fetch_object($rs_result_fsc);
$ancustomer = "$rs_result_q->sccprocid";
$ancustomerlocalid = "$rs_result_q->sccid";
$scgroupid = "$rs_result_q->groupid";


$rs_find_an_cards = "SELECT * FROM savedcards WHERE sccid = '$ancustomerlocalid' AND savedcarddefault = '1'";
$rs_result_cards = mysqli_query($rs_connect, $rs_find_an_cards);

$rs_result_q = mysqli_fetch_object($rs_result_cards);
$ancardlocalid = "$rs_result_q->savedcardid";
$ancardfour = "$rs_result_q->savedcardfour";
$ancardexpmonth = "$rs_result_q->savedcardexpmonth";
$ancardexpyear = "$rs_result_q->savedcardexpyear";
$custname = "$rs_result_q->savedcardname";
$ancardbrand = "$rs_result_q->savedcardbrand";
$savedcardprocid = "$rs_result_q->savedcardprocid";
$ancarddefault = "$rs_result_q->savedcarddefault";







if ($demo == "yes") {
die("Sorry this feature is disabled in demo mode");
}

$storeinfoarray = getstoreinfo($defaultuserstore);

$content =
	"<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
	"<createCustomerProfileTransactionRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">" .
	MerchantAuthenticationBlock().
	"<transaction>".
	"<profileTransAuthCapture>".
	"<amount>$amounttopay</amount>". // should include tax, shipping, and everything.
	"<customerProfileId>$ancustomer</customerProfileId>".
	"<customerPaymentProfileId>$savedcardprocid</customerPaymentProfileId>".
	"</profileTransAuthCapture>".
	"</transaction>".
	"</createCustomerProfileTransactionRequest>";


$isapproved = 1;


$response = send_xml_request($content);
$parsedresponse = parse_api_response($response);
if ("Ok" == $parsedresponse->messages->resultCode) {
$isapproved = 1;
} else {
$isapproved = 0;
}

if (isset($parsedresponse->directResponse)) {
		
	$directResponseFields = explode(",", $parsedresponse->directResponse);
	$responseCode = $directResponseFields[0]; // 1 = Approved 2 = Declined 3 = Error
	$responseReasonCode = $directResponseFields[2]; // See http://www.authorize.net/support/AIM_guide.pdf
	$responseReasonText = $directResponseFields[3];
	$approvalCode = $directResponseFields[4]; // Authorization code
	$transId = $directResponseFields[6];
}






if (($isapproved == 0) && ($responseCode != 1)) {
require_once("common.php");
echo "<font size=6>".pcrtlang("Credit Card Declined")."</font><br><br>";
$thereason = $responseReasonText;
echo pcrtlang("Reason").":<br><br><font color=red size=5>$thereason</font>";
} else {

$cc_transid = $transId;

$ccnumber2 = "$ancardfour";

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');


$rs_insert_gcc = "INSERT INTO currentpayments 
        (pfirstname,byuser,amount,paymentplugin,paymentstatus,paymenttype,cc_number,cc_expmonth,cc_expyear,cc_transid,cc_cardtype)
VALUES ('$custname','$ipofpc','$amounttopay','AuthorizeNetCIM','ready','credit','$ccnumber2','$ancardexpmonth','$ancardexpyear','$cc_transid','')";
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
