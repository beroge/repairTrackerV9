<?php
                                                                                                    
/***************************************************************************
 *   copyright            : (C) 2012 PCRepairTracker.com
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

                                                                                                    
function deposits() {
require_once("header.php");
require("deps.php");


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

if (array_key_exists('woid',$_REQUEST)) {
$woid = $_REQUEST['woid'];
} else {
$woid = "0";
}

if (array_key_exists('invoiceid',$_REQUEST)) {
$invoiceid = $_REQUEST['invoiceid'];
} else {
$invoiceid = "0";
}

if (array_key_exists('depamount',$_REQUEST)) {
$depamount = $_REQUEST['depamount'];
} else {
$depamount = "0";
}




echo "<div data-role=\"collapsible\" data-theme=\"b\">";
echo "<h3>".pcrtlang("Take a Deposit")."</h3>";

reset($paymentplugins);
foreach($paymentplugins as $key => $plugin) {

echo "<form action=$plugin.php?func=add method=post  data-ajax=\"false\">";

echo "<input type=hidden name=cfirstname value=\"$cfirstname\">";
echo "<input type=hidden name=ccompany value=\"$ccompany\">";
echo "<input type=hidden name=caddress value=\"$caddress\">";
echo "<input type=hidden name=caddress2 value=\"$caddress2\">";
echo "<input type=hidden name=ccity value=\"$ccity\">";
echo "<input type=hidden name=cstate value=\"$cstate\">";
echo "<input type=hidden name=czip value=\"$czip\">";
echo "<input type=hidden name=cphone value=\"$cphone\">";
echo "<input type=hidden name=cemail value=\"$cemail\">";
echo "<input type=hidden name=woid value=\"$woid\">";
echo "<input type=hidden name=invoiceid value=\"$invoiceid\">";
echo "<input type=hidden name=currenttotal value=\"$depamount\">";
echo "<input type=hidden name=isdeposit value=\"1\">";
echo "<input type=submit value=\"".pcrtlang("$plugin")."\"></form>";

}

echo "</div>";

if(($woid == 0) && ($invoiceid == 0)) {
echo "<form action=cart.php?func=pickcustomer method=post data-ajax=\"false\">";
echo "<input type=text name=searchtext><input type=hidden value=deposits name=pickfor>";
echo "<input type=submit value=\"".pcrtlang("Search &amp; Pick Customer")."\"></form>";
}

if ("$cfirstname" != "") {

echo "<h3>".pcrtlang("Current Pick")."</h3>$cfirstname";
if($ccompany != "") {
echo "<br>$ccompany";
}
echo "$caddress";
if ($caddress2 != "") {
echo "<br>$caddress2";
}

if (($ccity != "") || ($cstate != "") || ($czip != "")) {
echo "<br>";
}

if ($ccity != "") {
echo "$ccity,";
}
if ($cstate != "") {
echo "$cstate,";
}
if ($czip != "") {
echo "$czip";
}

}





echo "<br><br>";

echo "<button type=button onClick=\"parent.location='deposits.php?func=alldeposits'\">".pcrtlang("Browse Applied Deposits")."</button>";
echo "<br>";



$rs_invoices = "SELECT * FROM deposits WHERE dstatus = 'open'";
$rs_find_deposits = @mysqli_query($rs_connect, $rs_invoices);
$totaldep = mysqli_num_rows($rs_find_deposits);
if ($totaldep != "0") {

echo "<h3>".pcrtlang("Current Open Deposits")."</h3>";
while($rs_find_deposits_q = mysqli_fetch_object($rs_find_deposits)) {
$depositid = "$rs_find_deposits_q->depositid";
$depfirstname = "$rs_find_deposits_q->pfirstname";
$deplastname = "$rs_find_deposits_q->plastname";
$depname = "$depfirstname $deplastname";
$depcompany = "$rs_find_deposits_q->pcompany";
$depamount2 = "$rs_find_deposits_q->amount";
$depamount = number_format($depamount2, 2, '.', '');
$depwoid = "$rs_find_deposits_q->woid";
$depinvoiceid = "$rs_find_deposits_q->invoiceid";
$depemail = "$rs_find_deposits_q->pemail";
$paymentplugin = "$rs_find_deposits_q->paymentplugin";
$cc_transid = "$rs_find_deposits_q->cc_transid";
$depdate = "$rs_find_deposits_q->depdate";
$depdate2 = pcrtdate("$pcrt_longdate", "$depdate");

echo "<table class=standard>";
echo "<tr><th>#$depositid $depname</th></tr>";
if("$depcompany" != "") {
echo "<tr><td>$depcompany</td></tr>";
}
echo "<tr><td>$depdate2</td></tr><tr><td>$money".mf("$depamount")."</td></tr>";


if($depinvoiceid != 0) {
echo "<tr><td>".pcrtlang("Invoice").": #$depinvoiceid</td></tr>";
}

if($depwoid != 0) {
echo "<tr><td>".pcrtlang("Work Order").": #$depwoid</td></tr>";
}



echo "<tr><td>";

echo "<div data-role=\"collapsible\">";
echo "<h3>".pcrtlang("Deposit Actions")."</h3>";

echo "<button type=button onClick=\"parent.location='deposits.php?func=deposit_receipt&depositid=$depositid&depemail=$depemail&woid=$depwoid'\"><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Print Deposit Receipt")."</button>";
echo "<button type=button onClick=\"parent.location='deposits.php?func=adddep&depositid=$depositid'\"><i class=\"fa fa-cart-plus fa-lg\"></i> ".pcrtlang("Add Deposit to Cart")."</button>";
echo "<button type=button onClick=\"parent.location='deposits.php?func=editdeposit&depositid=$depositid'\"><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("Edit")."</button> ";


echo "<a href=\"#popupdeletedep$depositid\" data-rel=\"popup\" data-position-to=\"window\" data-transition=\"pop\" class=\"ui-btn ui-shadow ui-corner-all\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Void & Delete")."</a>";
echo "<div data-role=\"popup\" id=\"popupdeletedep$depositid\" data-overlay-theme=\"b\"  data-theme=\"a\" data-dismissible=\"false\">";
echo "<div data-role=\"header\" data-theme=\"b\">";
echo "<h1>".pcrtlang("Delete Deposit")."?</h1>";
echo "</div>";
echo "<div role=\"main\" class=\"ui-content\">";
echo "<p>".pcrtlang("Are you sure you wish to permanently delete this Deposit?")."</p>";
echo "<div align=\"right\"><a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\" data-inline=\"true\"><i class=\"fa fa-ban fa-lg\"></i> Cancel</a>";
echo "<button onClick=\"parent.location='$paymentplugin.php?func=void&depositid=$depositid&isdeposit=1&cc_transid=$cc_transid'\" data-inline=\"true\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")." </button></div>";
echo "</div>";
echo "</div>";

if($depwoid != "0") {
echo "<button type=button onClick=\"parent.location='../repairmobile/pc.php?func=view&woid=$depwoid'\">".pcrtlang("View Work Order")." #$depwoid</button>";
}


if(($depwoid == "0") && ($depinvoiceid != 0)) {
echo "<button type=button onClick=\"parent.location='deposits.php?func=removefrominvoice&depositid=$depositid'\"><i class=\"fa fa-times fa-lg\"></i> ".pcrtlang("Remove from Invoice")." #$depinvoiceid</button>";
}

if(($depwoid == "0") && ($depinvoiceid == 0) && ($woid != 0)) {
echo "<button type=button onClick=\"parent.location='../repairmobile/pc.php?func=adddeposittowo&depositid=$depositid&woid=$woid'\">
<i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Add to Work Order")." #$woid</button>";
}


if($depinvoiceid != 0) {
echo "<button type=button onClick=\"parent.location='invoice.php?func=printinv&invoice_id=$depinvoiceid'\">
<i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Print Invoice")." #$depinvoiceid</button>";
} else {
if(($invoiceid != 0) && ($woid == 0)) {
echo "<button type=button onClick=\"parent.location='deposits.php?func=adddeptoinv&invoiceid=$invoiceid&depositid=$depositid'\">
<i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Add to Invoice")." #$invoiceid</button>";
}
}




echo "</div>";
echo "</td></tr>";
echo "</table><br>";
}
}


require_once("footer.php");
                                                                                                    
}

##########

function alldeposits() {
require_once("header.php");
require("deps.php");

if (array_key_exists('pageNumber',$_REQUEST)) {
$pageNumber = $_REQUEST[pageNumber];
} else {
$pageNumber = 1;
}

$results_per_page = 40;

$offset = ($pageNumber * $results_per_page) - $results_per_page;







echo "<button type=button onClick=\"parent.location='deposits.php'\">".pcrtlang("Open Deposits")."</button><br>";
echo "<br>";

echo "<h3>".pcrtlang("Applied Deposits")."</h3>";

$rs_depositst = "SELECT * FROM deposits WHERE dstatus = 'applied'";
$rs_find_depositst = @mysqli_query($rs_connect, $rs_depositst);


$rs_deposits = "SELECT * FROM deposits WHERE dstatus = 'applied' ORDER BY depdate DESC LIMIT $offset,$results_per_page";
$rs_find_deposits = @mysqli_query($rs_connect, $rs_deposits);
while($rs_find_deposits_q = mysqli_fetch_object($rs_find_deposits)) {
$depositid = "$rs_find_deposits_q->depositid";
$depfirstname = "$rs_find_deposits_q->pfirstname";
$deplastname = "$rs_find_deposits_q->plastname";
$depname = "$depfirstname $deplastname";
$depcompany = "$rs_find_deposits_q->pcompany";
$depamount2 = "$rs_find_deposits_q->amount";
$depamount = number_format($depamount2, 2, '.', '');
$depwoid = "$rs_find_deposits_q->woid";
$depemail = "$rs_find_deposits_q->pemail";
$paymentplugin = "$rs_find_deposits_q->paymentplugin";
$depdate = "$rs_find_deposits_q->depdate";
$depdate2 = pcrtdate("$pcrt_longdate", "$depdate");
$deprec = "$rs_find_deposits_q->receipt_id";
$applieddate = "$rs_find_deposits_q->applieddate";
$applieddate2 = pcrtdate("$pcrt_longdate", "$applieddate");

echo "<table class=standard><tr><th>#$depositid $depfirstname</th></tr>";
if("$depcompany" != "") {
echo "<tr><td>$depcompany</td></tr>";
}
echo "</td><td>$depdate2</td></tr><tr><td>$applieddate2</td></tr><tr><td>$money".mf("$depamount")."</font></td></tr>";
echo "<tr><td>";

echo "<div data-role=\"collapsible\">";
echo "<h3>".pcrtlang("Deposit Actions")."</h3>";

echo "<button type=button onClick=\"parent.location='deposits.php?func=deposit_receipt&depositid=$depositid&depemail=$depemail&woid=$depwoid'\"><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Print")."</button>";
if($depwoid != "0") {
echo "<button type=button onClick=\"parent.location='../repairmobile/index.php?pcwo=$depwoid'\"><i class=\"fa fa-eye fa-lg\"></i> ".pcrtlang("View Work Order")." #$depwoid</button>";
}
if($deprec != "0") {
echo "<button type=button onClick=\"parent.location='receipt.php?func=show_receipt&receipt=$deprec'\"><i class=\"fa fa-eye fa-lg\"></i> ".pcrtlang("View Receipt")." #$deprec</button>";
}

echo "</div>";
echo "</td></tr></table><br>";

}

echo "<br>";

#browse here
$totalentry = mysqli_num_rows($rs_find_depositst);
$prevpage = $pageNumber - 1;
$nextpage = $pageNumber + 1;

echo "<center>";
if ($pageNumber > 1) {
echo "<button type=button onClick=\"parent.location='deposits.php?func=alldeposits&pageNumber=$prevpage'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\">";
echo "<i class=\"fa fa-chevron-left fa-lg\"></i></button>";
}

$total_results = $totalentry;
$results_per_page = $results_per_page;
$html = get_paged_nav($total_results, $results_per_page, false);
echo "$html";
if (($totalentry / $results_per_page) > $pageNumber) {
echo "<button type=button onClick=\"parent.location='deposits.php?func=alldeposits&pageNumber=$nextpage'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\">";
echo "<i class=\"fa fa-chevron-right fa-lg\"></i></button>";
}

echo "</center>";


require_once("footer.php");

}



#######

function deposit_receipt() {
require_once("validate.php");
$depositid = $_REQUEST['depositid'];

include("deps.php");
include("common.php");


$narrow = $receiptsnarrow;

?>
<!DOCTYPE html>

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php


echo "<title>".pcrtlang("Deposit Receipt").": #$depositid</title>";

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../repair/printstyle.css\">";

if (!isset($enablesignaturepad_deposits)) {
$enablesignaturepad_deposit = "no";
}

if ($enablesignaturepad_deposits == "yes") {
?>
 <link rel="stylesheet" href="../repair/jq/signature/jquery.signaturepad.css">
  <!--[if lt IE 9]><script src="../repair/jq/signature/flashcanvas.js"></script><![endif]-->
  <script src="../repair/jq/jquery.js"></script>

<?php

}

if ($enablesignaturepad_deposits == "topaz") {
require("../repair/jq/topaz.js");
}

echo "<link rel=\"stylesheet\" href=\"../repair/fa/css/font-awesome.min.css\">";


echo "</head>";

if($autoprint == 1) {
if(($enablesignaturepad_deposits == "yes") || ($enablesignaturepad_deposits == "topaz")) {
if($thesig != "") {
echo "<body class=printpagebg onLoad=\"window.print()\">";
} else {
echo "<body class=printpagebg>";
}
} else {
echo "<body class=printpagebg onLoad=\"window.print()\">";
}
} else {
echo "<body class=printpagebg>";
}


$rs_find_name = "SELECT * FROM deposits WHERE depositid = '$depositid'";
$rs_result_name = mysqli_query($rs_connect, $rs_find_name);

$rs_result_name_q = mysqli_fetch_object($rs_result_name);
$rs_soldto = "$rs_result_name_q->pfirstname";
$rs_ad1 = "$rs_result_name_q->paddress";
$rs_company = "$rs_result_name_q->pcompany";
$rs_ad2 = "$rs_result_name_q->paddress2";
$rs_ph = "$rs_result_name_q->pphone";
$rs_cn = "$rs_result_name_q->chk_number";
$rs_ccn = "$rs_result_name_q->cc_number";
$rs_datesold = "$rs_result_name_q->depdate";
$rs_pw = "$rs_result_name_q->paymenttype";
$rs_byuser = "$rs_result_name_q->byuser";
$rs_city = "$rs_result_name_q->pcity";
$rs_state = "$rs_result_name_q->pstate";
$rs_zip = "$rs_result_name_q->pzip";
$rs_email = "$rs_result_name_q->pemail";
$rs_email2 = urlencode($rs_email);
$rs_storeid = "$rs_result_name_q->storeid";
$thesig = "$rs_result_name_q->thesig";
$showsigdep = "$rs_result_name_q->showsigdep";
$thesigtopaz = "$rs_result_name_q->thesigtopaz";
$showsigdeptopaz = "$rs_result_name_q->showsigdeptopaz";



if(!array_key_exists('woid', $_REQUEST)) {
$returnurl = "deposits.php";
} else {
$pcwoid = $_REQUEST['woid'];
if ($pcwoid == 0) {
$returnurl = "deposits.php";
} else {
$returnurl = "../repairmobile/index.php?pcwo=$pcwoid";
}
}


echo "<div class=printbar>";
echo "<button onClick=\"parent.location='$returnurl'\" class=bigbutton><img src=../store/images/left.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Return")."</button>";
echo "<font class=text30b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>";
echo "<button onClick=\"print();\" class=bigbutton><img src=../store/images/print.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Print")."</button>";

echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<button onClick=\"parent.location='deposits.php?func=email_deposit_receipt&depositid=$depositid&depemail=$rs_email2&returnurl=$returnurl'\" class=bigbutton><img src=../repair/images/email.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Email")."</button>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$returnreceipt = urlencode("../storemobile/deposits.php?func=deposit_receipt&depositid=$depositid");
if($receiptsnarrow == 0) {
echo "<button onClick=\"parent.location='../repairmobile/admin.php?func=switch_receipt&receipt=$returnreceipt&switch=1'\" class=bigbutton><img src=../repair/images/narrowreceipts.png style=\"
vertical-align:middle;margin-bottom: .25em;\"></button>";
} else {
echo "<button onClick=\"parent.location='../repairmobile/admin.php?func=switch_receipt&receipt=$returnreceipt&switch=0'\" class=bigbutton><img src=../repair/images/widereceipts.png style=\" 
vertical-align:middle;margin-bottom: .25em;\"></button>";
}


echo "</div>";

require("deps.php");




if(!$narrow) {
echo "<div class=printpage>";
} else {
echo "<div class=printpage80>";
}

if(!$narrow) {
echo "<table width=100%><tr><td width=55%>";
}




$storeinfoarray = getstoreinfo($rs_storeid);

$woid = "$rs_result_name_q->woid";

$paymentamount2 = "$rs_result_name_q->amount";
$paymentamount = number_format($paymentamount2, 2, '.', '');
$pfirstname = "$rs_result_name_q->pfirstname";
$pcompany = "$rs_result_name_q->pcompany";
$paymenttype = "$rs_result_name_q->paymenttype";
$paymentplugin = "$rs_result_name_q->paymentplugin";
$checknumber = "$rs_result_name_q->chk_number";
$ccnumber2 = "$rs_result_name_q->cc_number";
$ccexpmonth = "$rs_result_name_q->cc_expmonth";
$ccexpyear = "$rs_result_name_q->cc_expyear";
$cc_transid = "$rs_result_name_q->cc_transid";
$cc_cardtype = "$rs_result_name_q->cc_cardtype";
$custompaymentinfo2 = "$rs_result_name_q->custompaymentinfo";

$custompaymentinfo = unserialize("$custompaymentinfo2");

$ccnumber = substr("$ccnumber2", -4, 4);

if(!$narrow) {
echo "<img src=../store/$printablelogo><br><font class=text12bi>$servicebyline</font><br><br><font class=text12b>";
echo "$storeinfoarray[storename]</font><font class=text12><br>$storeinfoarray[storeaddy1]";
if ("$storeinfoarray[storeaddy2]" != "") {
echo "<br>$storeinfoarray[storeaddy2]";
}
echo "<br>$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]";
echo "</font><br><br><font class=text12>Phone: $storeinfoarray[storephone]</font></font><br><br>";



echo "<table cellpadding=3 cellspacing=0 border=0><tr><td valign=top><font class=text14b>".pcrtlang("Received From").":</font></td><td>";

if("$rs_company" != "") {
echo "<font class=text12>$rs_company";
} else {
echo "<font class=text12>$rs_soldto";
}

echo "<br>$rs_ad1";
if ($rs_ad2 != "") {
echo "<br>$rs_ad2";
}

echo "<br>";
if ($rs_city != "") {
echo "$rs_city, ";
}
echo "$rs_state $rs_zip<br></font>";

echo pcrtlang("Email").": $rs_email";


echo "</td></tr></table>";


echo "</font><br></td><td align=right width=45% valign=top>";
echo "<font class=textidnumber>".pcrtlang("Deposit Receipt")." #$depositid<br></font>";


$rs_datesold2 = pcrtdate("$pcrt_longdate", "$rs_datesold").", ".pcrtdate("$pcrt_time", "$rs_datesold");

echo "<br><font class=text12b>".pcrtlang("Deposit Date").":</font><font class=textgray12b> $rs_datesold2</font><br>";


if ($rs_byuser != "") {
echo "<br><font class=text12b>".pcrtlang("Received By").":</font><font class=textgray12b> $rs_byuser</font>";
}


echo "<br><img src=\"barcode.php?barcode=$depositid&width=220&height=40&text=0\">";


echo "</td></tr></table>";

} else {
#start narrow
echo "<center>";
echo "<font class=text12b>".pcrtlang("Deposit Receipt")." #$depositid<br></font>";

$rs_datesold2 = pcrtdate("$pcrt_longdate", "$rs_datesold");
echo "<br><font class=text12>".pcrtlang("Deposit Date").":</font><font class=text12> $rs_datesold2</font><br>";

echo "<br><img src=\"../repair/barcode.php?barcode=$depositid&width=220&height=20&text=0\">";

echo "<br><br><img src=../repair/$printablelogo width=200><br><font class=text10i>$servicebyline</font><br><br><font class=text12b>";
echo "$storeinfoarray[storename]</font><font class=text12><br>$storeinfoarray[storeaddy1]";
if ("$storeinfoarray[storeaddy2]" != "") {
echo "<br>$storeinfoarray[storeaddy2]";
}
echo "<br>$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]";
echo "</font><br><br><font class=text12>Phone: $storeinfoarray[storephone]</font></font><br><br>";


echo "<font class=text10b>".pcrtlang("Received From").":</font><br>";

if("$rs_company" != "") {
echo "<font class=text12b>$rs_company</font>";
} else {
echo "<font class=text12b>$rs_soldto</font>";
}

echo "<br><font class=text12>$rs_ad1";
if ($rs_ad2 != "") {
echo "<br>$rs_ad2";
}

echo "<br>";
if ($rs_city != "") {
echo "$rs_city, ";
}
echo "$rs_state $rs_zip<br></font>";
if($rs_email != "") {
echo "<font class=text12>".pcrtlang("Email").": $rs_email</font>";
}

echo "<br>";


#end narrow
}


echo "<table><tr>";

if ($paymenttype == "cash") {
echo "<td valign=top style=\"padding:5px 30px 0px 5px;border: 2px solid #000000;border-radius:3px;\">";
echo "<i class=\"fa fa-money fa-lg\"></i><strong> &nbsp;".pcrtlang("Cash")."&nbsp;</strong><br><br>";
echo "<font style=\"font-size:20px;\">$pfirstname";
if("$pcompany" != "") {
echo " - $pcompany";
}
echo " - $money".mf("$paymentamount")."</font></td>";

} elseif ($paymenttype == "check") {
echo "<td valign=top style=\"padding:5px 30px 0px 5px;border: 2px solid #000000;border-radius:3px;\">";
echo "<i class=\"fa fa-list-alt fa-lg\"></i><strong> ".pcrtlang("Check")." #$checknumber&nbsp;</strong><br><br>";
echo "<font style=\"font-size:20px;\">$pfirstname";
if("$pcompany" != "") {
echo " - $pcompany";
}
echo " - $money".mf("$paymentamount")."</font></td>";

} elseif ($paymenttype == "credit") {
echo "<td valign=top style=\"padding:5px 30px 0px 5px;border: 2px solid #000000;border-radius:3px;\">";
echo "<i class=\"fa fa-credit-card fa-lg\"></i><strong> ".pcrtlang("Credit Card")."&nbsp;</strong>";
echo "<br><font style=\"font-size:20px;\">XXXX-$ccnumber<br><br>";
echo "<font style=\"font-size:20px;\">$pfirstname";
if("$pcompany" != "") {
echo " - $pcompany";
}
echo " - $money".mf("$paymentamount")."<br>$paymentplugin $cc_cardtype<br>".pcrtlang("Trans ID").": $cc_transid</font></td>";

} elseif ($paymenttype == "custompayment") {
echo "<td valign=top style=\"padding:5px 30px 0px 5px;border: 2px solid #000000;border-radius:3px;\">";
echo "<i class=\"fa fa-product-hunt fa-lg\"></i><strong>&nbsp;$paymentplugin&nbsp;</strong><br><br>";
echo "<font style=\"font-size:20px;\">$pfirstname";
if("$pcompany" != "") {
echo " - $pcompany";
}
echo " - $money".mf("$paymentamount")."</font></td>";

reset($custompaymentinfo);
foreach($custompaymentinfo as $key => $val) {
if(!in_array("$key", $CustomPaymentPrintExclude)) {
echo "<font style=\"font-size:10px;\">$key: $val</font><br>";
}
}

echo "</td>";

} else {
echo "<td valign=top style=\"padding:5px 30px 0px 5px;border: 2px solid #000000;border-radius:3px;\">";
echo "Error! Undefined Payment Type in database</font></td>";
}


echo "</tr></table>";

echo "<br><br>";

echo nl2br($storeinfoarray['depositfooter']);

if($narrow) {
echo "<br><br><br><br><font style=\"color:white;\">.</font>";
}




######

if (($enablesignaturepad_deposits == "yes") && ($showsigdep == "0") && (!$narrow)) {
echo "<a href=deposits.php?func=hidesigdep&depositid=$depositid&hidesig=1 class=hideprintedlink><br><br>(".pcrtlang("show signature pad").")</a>";
}

if (($enablesignaturepad_deposits == "yes") && ($showsigdep == "1") && (!$narrow)) {

if ($showsigdep == "1") {
echo "<a href=deposits.php?func=hidesigdep&depositid=$depositid&hidesig=0 class=hideprintedlink><br><br>(hide signature pad)</a>";
}


if($thesig == "") {

?>
<blockquote>
  <form method="post" action="deposits.php?func=savesig" class="sigPad"><input type=hidden name=depositid value=<?php echo $depositid; ?>>
    <p class="drawItDesc"><?php echo pcrtlang("Use Stylus to write your signature"); ?></p>
    <ul class="sigNav">
      <li class="clearButton"><a href="#clear"><?php echo pcrtlang("Clear Signature"); ?></a></li>
    </ul>
    <div class="sig sigWrapper">
      <div class="typed"></div>
      <canvas class="pad" width="446" height="75"></canvas>
      <input type="hidden" name="output" class="output">
    </div>
    <button type="submit"><?php echo pcrtlang("I accept the terms of this agreement"); ?>.</button>
  </form>

  <script src="../repair/jq/signature/jquery.signaturepad.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.sigPad').signaturePad({drawOnly:true,lineTop:60});
    });
  </script>
  <script src="../repair/jq/signature/json2.min.js"></script>
</blockquote>
<?php
} else {
echo "<br><br><font class=text16b>".pcrtlang("Signed").":</font> <a href=deposits.php?func=clearsig&depositid=$depositid class=hideprintedlink>(".pcrtlang("remove signature").")</a></font><br>";
?>

<div class="sigPad signed">
  <div class="sigWrapper">
    <canvas class="pad" width="450" height="75"></canvas>
  </div>
</div>

<script type="text/javascript" src="../repair/jq/signature/jquery.signaturepad.min.js"></script>
<script>
$(document).ready(function () {
  $('.sigPad').signaturePad({displayOnly:true}).regenerate(<?php echo $thesig ?>)
})
</script>
<script type="text/javascript" src="../repair/jq/signature/json2.min.js"></script>
<?php
}

}


######





#start topaz

if ($enablesignaturepad_deposits == "topaz") {

if ($showsigdeptopaz == "0") {
echo "<a href=deposits.php?func=hidesigdeptopaz&depositid=$depositid&hidesig=1 class=hideprintedlink><br><br>(".pcrtlang("show signature pad").")</a>";
}

if ($showsigdeptopaz == "1") {
echo "<a href=deposits.php?func=hidesigdeptopaz&depositid=$depositid&hidesig=0 class=hideprintedlink><br><br>(".pcrtlang("hide signature pad").")</a>";
}

if ($showsigdeptopaz == "1") {
if ($thesigtopaz == "") {


?>

<br>
<canvas id="cnv" name="cnv" width="500" height="100"></canvas>

<form action="deposits.php?func=savesigtopaz" name=FORM1 method=post>
<input id="SignBtn" name="SignBtn" type="button" value="<?php echo pcrtlang("Activate Sig Pad"); ?>"  class=button onclick="javascript:onSign()"/>&nbsp;&nbsp;&nbsp;&nbsp;
<input id="button1" name="ClearBtn" type="button" class=button value="Clear" onclick="javascript:onClear()"/>&nbsp;&nbsp;&nbsp;&nbsp;
<input id="button2" name="DoneBtn" type="button" class=button value="Done" onclick="javascript:onDone()"/>&nbsp;&nbsp;&nbsp;&nbsp;

<input type="submit" class=button value="Save">&nbsp;&nbsp;&nbsp;&nbsp

<INPUT TYPE=HIDDEN NAME="bioSigData">
<INPUT TYPE=HIDDEN NAME="sigImgData">

<input type=hidden name=depositid value=<?php echo $depositid; ?>>

<input type=hidden NAME="sigImageData" value="">
</form>



<?php

} else {
echo "<br><br><font class=text16b>".pcrtlang("Signed").":</font><a href=deposits.php?func=clearsigtopaz&depositid=$depositid class=hideprintedlink>(".pcrtlang("remove signature").")</a><br>";

if(!$narrow) {
echo '<br><img src="data:image/png;base64,' . $thesigtopaz . '" />';
} else {
echo '<br><img src="data:image/png;base64,' . $thesigtopaz . '" width=260/>';
}


}

#end hide
}

}
#end topaz






echo "</div>";


echo "</div>";
echo "</body></html>";

}

#######

function email_deposit_receipt() {
require_once("validate.php");
require_once("dheader.php");
require("deps.php");

echo "<div data-role=\"header\" data-theme=\"b\"><h2>".pcrtlang("Email Repair Report")."</h2></div>";
echo "<div class=\"ui-content\" role=\"main\">";

$depositid = $_REQUEST['depositid'];
$depemail = $_REQUEST['depemail'];
$returnurl = $_REQUEST['returnurl'];

echo "<h3>".pcrtlang("Email Deposit Receipt")." #$depositid</h3>";

echo pcrtlang("Enter Email Address").":<br><form action=deposits.php?func=email_deposit_receipt2 method=POST  data-ajax=\"false\">";
echo "<input type=text value=\"$depemail\" name=depemail><input type=hidden value=$depositid name=depositid>";
echo "<input type=hidden value=$returnurl name=returnurl><input type=submit value=\"".pcrtlang("Email Deposit Receipt")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Sending Email")."...'; this.form.submit();\"></form><br><br>";

echo "</div>";

require_once("dfooter.php");


}




function email_deposit_receipt2() {
require_once("validate.php");
$depositid = $_REQUEST['depositid'];
$depemail = $_REQUEST['depemail'];
$returnurl = $_REQUEST['returnurl'];

include("deps.php");
include("common.php");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}

require("deps.php");



$rs_find_name = "SELECT * FROM deposits WHERE depositid = '$depositid'";
$rs_result_name = mysqli_query($rs_connect, $rs_find_name);

while($rs_result_name_q = mysqli_fetch_object($rs_result_name)) {
$rs_soldto = "$rs_result_name_q->pfirstname";
$rs_company = "$rs_result_name_q->pcompany";
$rs_ad1 = "$rs_result_name_q->paddress";
$rs_ad2 = "$rs_result_name_q->paddress2";
$rs_ph = "$rs_result_name_q->pphone";
$rs_cn = "$rs_result_name_q->chk_number";
$rs_ccn = "$rs_result_name_q->cc_number";
$rs_datesold = "$rs_result_name_q->depdate";
$rs_pw = "$rs_result_name_q->paymenttype";
$rs_byuser = "$rs_result_name_q->byuser";
$rs_city = "$rs_result_name_q->pcity";
$rs_state = "$rs_result_name_q->pstate";
$rs_zip = "$rs_result_name_q->pzip";
$rs_email = "$rs_result_name_q->pemail";
$woid = "$rs_result_name_q->woid";
$rs_storeid = "$rs_result_name_q->storeid";

$paymentamount = "$rs_result_name_q->amount";
$pfirstname = "$rs_result_name_q->pfirstname";
$pcompany = "$rs_result_name_q->pcompany";
$paymenttype = "$rs_result_name_q->paymenttype";
$paymentplugin = "$rs_result_name_q->paymentplugin";
$checknumber = "$rs_result_name_q->chk_number";
$ccnumber2 = "$rs_result_name_q->cc_number";
$ccexpmonth = "$rs_result_name_q->cc_expmonth";
$ccexpyear = "$rs_result_name_q->cc_expyear";
$cc_transid = "$rs_result_name_q->cc_transid";
$cc_cardtype = "$rs_result_name_q->cc_cardtype";
$custompaymentinfo2 = "$rs_result_name_q->custompaymentinfo";

$custompaymentinfo = unserialize("$custompaymentinfo2");

$ccnumber = substr("$ccnumber2", -4, 4);

$storeinfoarray = getstoreinfo($rs_storeid);

$to = "$depemail";

if($storeinfoarray['storeccemail'] != "")	{
$to .= ",$storeinfoarray[storeccemail]";
}

$subject = "$storeinfoarray[storename] - ".pcrtlang("Deposit Receipt")." #$depositid";
$random_hash = md5(date('r', time()));
$headers = "From: $storeinfoarray[storeemail]\r\nReply-To: $storeinfoarray[storeemail]\r\nX-Mailer: PHP/".phpversion();
$headers .= "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
$headers .= "\r\nMIME-Version: 1.0";

$message = "--PHP-alt-$random_hash\r";
$message .= "Content-Type: text/plain; charset=\"iso-8859-1\"\r";
$message .= "Content-Transfer-Encoding: 7bit\r";

$message .= "Sorry, Your email client does not support html email.\n";
$peartext = "Sorry, Your email client does not support html email.\n";

$message .= "--PHP-alt-$random_hash\n";
$message .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
$message .= "Content-Transfer-Encoding: 7bit\n\n";

$message .= "<html><head><title>".pcrtlang("Deposit Receipt").": #$depositid</title></head><body>";
$message .= "<table width=100%><tr><td width=55%>";

$pearhtml = "<html><head><title>".pcrtlang("Deposit Receipt").": #$depositid</title></head><body>";
$pearhtml .= "<table width=100%><tr><td width=55%>";


$message .= "<font face=Arial size=4><b>$storeinfoarray[storename]</b><br></font>\n<font face=arial size=3><i>$servicebyline</i><br>\n";
$pearhtml .= "<img src=$logo>\n<br><font face=arial size=3><i>$servicebyline</i><br>\n";

$message .= "<br>$storeinfoarray[storeaddy1]<br>";
if ("$storeinfoarray[storeaddy2]" != "") {
$message .="<br>$storeinfoarray[storeaddy2]\n";
}
$message .= "$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]\n";
$message .= "</font><br><br><font class=text12>".pcrtlang("Phone").": $storeinfoarray[storephone]</font></font><br><br>\n";


$pearhtml .= "<br>$storeinfoarray[storeaddy1]<br>";
if ("$storeinfoarray[storeaddy2]" != "") {
$pearhtml .="<br>$storeinfoarray[storeaddy2]\n";
}
$pearhtml .= "$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]\n";
$pearhtml .= "</font><br><br><font class=text12>".pcrtlang("Phone").": $storeinfoarray[storephone]</font></font><br><br>\n";



$message .= "<table cellpadding=3 cellspacing=0 border=0><tr><td valign=top><b>".pcrtlang("Received From").":</b></td><td>$rs_soldto";
if("$rs_company" != "") {
$message .= "<br>$rs_company";
}
$message .= "<br>$rs_ad1";
$pearhtml .= "<table cellpadding=3 cellspacing=0 border=0><tr><td valign=top><b>".pcrtlang("Received From").":</b></td><td>$rs_soldto";
if("$rs_company" != "") {
$pearhtml .= "<br>$rs_company";
}
$pearhtml .= "<br>$rs_ad1";
if ($rs_ad2 != "") {
$message .= "<br>$rs_ad2";
$pearhtml .= "<br>$rs_ad2";
}

$message .= "<br>";
$pearhtml .= "<br>";
if ($rs_city != "") {
$message .= "$rs_city,";
$pearhtml .= "$rs_city,";
}
$message .= "$rs_state $rs_zip<br>";
$pearhtml .= "$rs_state $rs_zip<br>";

$message .= "</td></tr></table>";
$message .= "</font><br></td><td align=right width=45% valign=top>";
$message .= "<font color=888888 face=arial size=6>".pcrtlang("Deposit Receipt")." #$depositid<br></font>";

$pearhtml .= "</td></tr></table>";
$pearhtml .= "</font><br></td><td align=right width=45% valign=top>";
$pearhtml .= "<font color=888888 face=arial size=6>".pcrtlang("Deposit Receipt")." #$depositid<br></font>";

$rs_datesold2 = pcrtdate("$pcrt_longdate", "$rs_datesold").", ".pcrtdate("$pcrt_time", "$rs_datesold");

$message .= "<br>".pcrtlang("Deposit Date").":<font color=888888> $rs_datesold2</font><br>";
$pearhtml .= "<br>".pcrtlang("Deposit Date").":<font color=888888> $rs_datesold2</font><br>";

if ($rs_byuser != "") {
$message .= "<br>".pcrtlang("Received By").":<font color=#888888> $rs_byuser</font>";
$pearhtml .= "<br>".pcrtlang("Received By").":<font color=#888888> $rs_byuser</font>";
}


$message .= "</td></tr></table>";
$pearhtml .= "</td></tr></table>";

$message .= "<table><tr>";
$pearhtml .= "<table><tr>";

if ($paymenttype == "cash") {
$message .= "<td valign=top style=\"padding:0px 30px 0px 5px;border: 2px solid #000000;border-radius:10px;\">";
$message .= "<font style=\"border: 2px solid #000000;padding5px;border-radius:7px;font-size:28px;\">&nbsp;".pcrtlang("Cash")."&nbsp;</font><br>";
$message .= "<font style=\"font-size:20px;\">$pfirstname"; 
if("$pcompany" != "") {
$message .= " - $pcompany";
}
$message .= " - $money".mf("$paymentamount")."</font></td>";

$pearhtml .= "<td valign=top style=\"padding:0px 30px 0px 5px;border: 2px solid #000000;border-radius:10px;\">";
$pearhtml .= "<font style=\"border: 2px solid #000000;padding5px;border-radius:7px;font-size:28px;\">&nbsp;".pcrtlang("Cash")."&nbsp;</font><br>";
$pearhtml .= "<font style=\"font-size:20px;\">$pfirstname";
if("$pcompany" != "") {
$pearhtml .= " - $pcompany";
}
$pearhtml .= " - $money".mf("$paymentamount")."</font></td>";


} elseif ($paymenttype == "check") {
$message .= "<td valign=top style=\"padding:0px 30px 0px 5px;border: 2px solid #000000;border-radius:10px;\">";
$message .= "<font style=\"border: 2px solid #000000;padding3px;border-radius:7px;font-size:28px;\">&nbsp;".pcrtlang("Check")." #$checknumber&nbsp;</font><br>";
$message .= "<font style=\"font-size:20px;\">$pfirstname";
if("$pcompany" != "") {
$message .= " - $pcompany";
}
$message .= " - $money".mf("$paymentamount")."</font></td>";


$pearhtml .= "<td valign=top style=\"padding:0px 30px 0px 5px;border: 2px solid #000000;border-radius:10px;\">";
$pearhtml .= "<font style=\"border: 2px solid #000000;padding3px;border-radius:7px;font-size:28px;\">&nbsp;".pcrtlang("Check")." #$checknumber&nbsp;</font><br>";
$pearhtml .= "<font style=\"font-size:20px;\">$pfirstname";
if("$pcompany" != "") {
$pearhtml .= " - $pcompany";
}
$pearhtml .= " - $money".mf("$paymentamount")."</font></td>";



} elseif ($paymenttype == "credit") {
$message .= "<td valign=top style=\"padding:0px 30px 0px 5px;border: 2px solid #000000;border-radius:10px;\">";
$message .= "<font style=\"border: 2px solid #000000;padding3px;border-radius:7px;font-size:28px;\">&nbsp;".pcrtlang("Credit Card")."&nbsp;</font>";
$message .= "<br><font style=\"font-size:20px;\">XXXX-$ccnumber<br>";
$message .= "<font style=\"font-size:20px;\">$pfirstname";
if("$pcompany" != "") {
$message .= " - $pcompany";
}
$message .= " - $money".mf("$paymentamount")."<br>$paymentplugin $cc_cardtype</font></td>";


$pearhtml .= "<td valign=top style=\"padding:0px 30px 0px 5px;border: 2px solid #000000;border-radius:10px;\">";
$pearhtml .= "<font style=\"border: 2px solid #000000;padding3px;border-radius:7px;font-size:28px;\">&nbsp;".pcrtlang("Credit Card")."&nbsp;</font>";
$pearhtml .= "<br><font style=\"font-size:20px;\">XXXX-$ccnumber<br>";
$pearhtml .= "<font style=\"font-size:20px;\">$pfirstname";
if("$pcompany" != "") {
$pearhtml .= " - $pcompany";
}
$pearhtml .= " - $money".mf("$paymentamount")."<br>$paymentplugin $cc_cardtype</font></td>";

} elseif ($paymenttype == "custompayment") {
$message .= "<td valign=top style=\"padding:0px 30px 0px 5px;border: 2px solid #000000;border-radius:10px;\">";
$message .= "<font style=\"border: 2px solid #000000;padding3px;border-radius:7px;font-size:28px;\">&nbsp;$paymentplugin&nbsp;</font><br>";
$message .= "<font style=\"font-size:20px;\">$pfirstname";
if("$pcompany" != "") {
$message .= " - $pcompany";
}
$message .= " - $money".mf("$paymentamount")."</font></td>";



$pearhtml .= "<td valign=top style=\"padding:0px 30px 0px 5px;border: 2px solid #000000;border-radius:10px;\">";
$pearhtml .= "<font style=\"border: 2px solid #000000;padding3px;border-radius:7px;font-size:28px;\">&nbsp;$paymentplugin&nbsp;</font><br>";
$pearhtml .= "<font style=\"font-size:20px;\">$pfirstname";
if("$pcompany" != "") {
$pearhtml .= " - $pcompany";
}
$pearhtml .= " - $money".mf("$paymentamount")."</font></td>";


reset($custompaymentinfo);
foreach($custompaymentinfo as $key => $val) {
if(!in_array("$key", $CustomPaymentPrintExclude)) {
$message .= "<font style=\"font-size:10px;\">$key: $val</font><br>";
$pearhtml .= "<font style=\"font-size:10px;\">$key: $val</font><br>";
}
}

$message .= "</td>";
$pearhtml .= "</td>";

} else {
$message .= "<td colspan=2 style=\"padding:0px 30px 0px 5px;border: 2px solid #000000;border-radius:10px;font-size:28px;\">";
$message .= "Error! Undefined Payment Type in database</font></td>";

$pearhtml .= "<td colspan=2 style=\"padding:0px 30px 0px 5px;border: 2px solid #000000;border-radius:10px;font-size:28px;\">";
$pearhtml .= "Error! Undefined Payment Type in database</font></td>";
}

$message .= "</tr></table>";
$pearhtml .= "</tr></table>";

}

$message .= "<br><br><br>";
$pearhtml .= "<br><br><br>";

$message .= nl2br($storeinfoarray['depositfooter']);
$message .= "\n</body></html>\n\r";
$pearhtml .= nl2br($storeinfoarray['depositfooter']);
$pearhtml .= "\n</body></html>\n\r";

$message .= "--PHP-alt-$random_hash--\n\n";

#wip


if (!isset($pcrt_mailer)) {
$pcrt_mailer = "mail";
}

if ($pcrt_mailer == "mail") {
$mail_sent = @mail( $to, $subject, $message, $headers );
echo $mail_sent ? "<html><head><meta http-equiv=\"refresh\" content=\"2;url=$gotourl\"></head><body>".pcrtlang("Mail sent")."<br><br><a href=$gotourl>".pcrtlang("Return")."</a></body></html>" : pcrtlang("Mail failed");
} elseif (($pcrt_mailer == "pearsmtp") || ($pcrt_mailer == "pearsmtpauth") || ($pcrt_mailer == "pearphpmailer")) {

if (!@include('Mail.php'))  {
echo "<div style=\"border: #ff0000 2px solid; background:#FFBCBC; color:#ff0000; margin: 20px; padding:20px;\">";
echo "Sorry you server does not have support for the Pear Mail and Pear Mail-Mime library. Check with your host to see if it is supported, or visit go-pear.com to download the pear installer
that can be run from your website to install your own local copy of Pear and the Pear Mail and Pear Mail-Mime modules.<br><br>If you choose to install your own copy, after installing, you
will need to also add the Mail and Mail-Mime packages. You will need to use your host control panel to password protect the directory. You will also need to add a setting to a
php.ini or php5.ini file to specify the runtime path of pear for your server. Quite often you can google your hosting provider name and pear to find a howto for your host.
if you are running your own linux server, quite often your distribution provides ready to install Pear packages.";
echo "</div>";
die();
}


#include('Mail.php');
    include('Mail/mime.php');

    $pearmessage2 = new Mail_mime();

    $pearmessage2->setTXTBody($peartext);
    $pearmessage2->setHTMLBody($pearhtml);

$imagetype = substr("../store/$logo", -3);
if ($imagetype == "gif") {
$pearmessage2->addHTMLImage("../store/$logo", 'image/gif');
} elseif ($imagetype == "jpg") {
$pearmessage2->addHTMLImage("../store/$logo", 'image/jpeg');
} elseif ($imagetype == "png") {
$pearmessage2->addHTMLImage("../store/$logo", 'image/png');
} else {
}

$mime_params = array(
  'text_encoding' => '7bit',
  'text_charset'  => 'UTF-8',
  'html_charset'  => 'UTF-8',
  'head_charset'  => 'UTF-8'
);

    $body = $pearmessage2->get($mime_params);
    $extraheaders = array("To"=>"$to","From"=>"$storeinfoarray[storeemail]", "Subject"=>"$subject", "Content-Type"  => "text/html; charset=UTF-8");
    $pearheaders = $pearmessage2->headers($extraheaders);

if ("$pcrt_mailer" == "pearsmtpauth") {
$smtp = Mail::factory('smtp',
   array ('host' => $pcrt_pear_host,
     'auth' => true,
     'port' => $pcrt_pear_port,
     'username' => $pcrt_pear_username,
     'password' => $pcrt_pear_password));
} elseif ("$pcrt_mailer" == "pearphpmailer") {
$smtp = Mail::factory('mail');
} elseif ("$pcrt_mailer" == "pearsmtp")  {
$smtp = Mail::factory('smtp');
} else {
die("Invalid Mailer Chosen");
}


$mailresult = $smtp->send("$to", $pearheaders, $body);

if (PEAR::isError($mailresult)) {
   echo("<p>" . $mailresult->getMessage() . "</p>");
  } else {
   echo "<html><head><meta http-equiv=\"refresh\" content=\"2;url=$returnurl\"></head><body>".pcrtlang("Mail sent")."<br>";
   echo "<br><a href=$returnurl>".pcrtlang("Return")."</a></body></html>";
  }

} else {
echo "Error: invalid mailer specified in the deps.php config file";
}

}


####################


function adddep() {
require_once("validate.php");
require("deps.php");
require("common.php");

$depositid = $_REQUEST['depositid'];

$rs_finddeposits_sql = "SELECT * FROM deposits WHERE depositid = '$depositid'";
$rs_find_deposits = @mysqli_query($rs_connect, $rs_finddeposits_sql);
while($rs_find_payments_q = mysqli_fetch_object($rs_find_deposits)) {
$pfirstname = pv($rs_find_payments_q->pfirstname);
$plastname = pv($rs_find_payments_q->plastname);
$pcompany = pv($rs_find_payments_q->pcompany);
$paddress = pv($rs_find_payments_q->paddress);
$paddress2 = pv($rs_find_payments_q->paddress2);
$pcity = pv($rs_find_payments_q->pcity);
$pstate = pv($rs_find_payments_q->pstate);
$pzip = pv($rs_find_payments_q->pzip);
$pphone = pv($rs_find_payments_q->pphone);
$pemail = pv($rs_find_payments_q->pemail);
$amount = pv($rs_find_payments_q->amount);
$paymentplugin = pv($rs_find_payments_q->paymentplugin);
$cc_number = "$rs_find_payments_q->cc_number";
$cc_expmonth = pv($rs_find_payments_q->cc_expmonth);
$cc_expyear = pv($rs_find_payments_q->cc_expyear);
$cc_transid = pv($rs_find_payments_q->cc_transid);
$cc_confirmation = pv($rs_find_payments_q->cc_confirmation);
$cc_cid = pv($rs_find_payments_q->cc_cid);
$cc_track1 = pv($rs_find_payments_q->cc_track1);
$cc_track2 = pv($rs_find_payments_q->cc_track2);
$chk_dl = pv($rs_find_payments_q->chk_dl);
$chk_number = pv($rs_find_payments_q->chk_number);
$paymentstatus = pv($rs_find_payments_q->paymentstatus);
$paymenttype = pv($rs_find_payments_q->paymenttype);
$ccnumber2 = substr("$cc_number", -4);
$cc_cardtype = pv($rs_find_payments_q->cc_cardtype);
$dstatus = pv($rs_find_payments_q->dstatus);
$depdate = pv($rs_find_payments_q->depdate);
$storeid = pv($rs_find_payments_q->storeid);
$pcompany = pv($rs_find_payments_q->pcompany);
$parentdeposit = pv($rs_find_payments_q->parentdeposit);
$registerid = pv($rs_find_payments_q->registerid);
$aregisterid = pv($rs_find_payments_q->aregisterid);

if($parentdeposit == 0) {
$parentdepositid = $depositid;
} else {
$parentdepositid = $parentdeposit;
}

$custompaymentinfo = pv($rs_find_payments_q->custompaymentinfo);
$cashchange = pv($rs_find_payments_q->cashchange);
$cashchange2 = pv($rs_find_payments_q->cashchange2);

if (!array_key_exists('balance', $_REQUEST)) {
$insertpaymentssql = "INSERT INTO currentpayments (pfirstname,plastname,pcompany,paddress,paddress2,pcity,pstate,pzip,pphone,pemail,byuser,amount,paymentplugin,
cc_number,cc_expmonth,cc_expyear,cc_transid,cc_confirmation,chk_dl,chk_number,paymentstatus,paymenttype,cc_cardtype,custompaymentinfo,isdeposit,depositid,cashchange)
VALUES ('$pfirstname', '$plastname', '$pcompany', '$paddress', '$paddress2', '$pcity', '$pstate', '$pzip', '$pphone', '$pemail', '$ipofpc','$amount','$paymentplugin',
'$ccnumber2', '$cc_expmonth', '$cc_expyear', '$cc_transid', '$cc_confirmation', '$chk_dl', '$chk_number','$paymentstatus', '$paymenttype','$cc_cardtype',
'$custompaymentinfo','1','$depositid','$cashchange')";
@mysqli_query($rs_connect, $insertpaymentssql);

} else {
$balance = $_REQUEST['balance'];
$amountextra = $_REQUEST['amountextra'];
$insertpaymentssql = "INSERT INTO currentpayments (pfirstname,plastname,pcompany,paddress,paddress2,pcity,pstate,pzip,pphone,pemail,byuser,amount,paymentplugin,
cc_number,cc_expmonth,cc_expyear,cc_transid,cc_confirmation,chk_dl,chk_number,paymentstatus,paymenttype,cc_cardtype,custompaymentinfo,isdeposit,depositid,cashchange)
VALUES ('$pfirstname', '$plastname', '$pcompany', '$paddress', '$paddress2', '$pcity', '$pstate', '$pzip', '$pphone', '$pemail', '$ipofpc','$balance','$paymentplugin',
'$ccnumber2', '$cc_expmonth', '$cc_expyear', '$cc_transid', '$cc_confirmation', '$chk_dl', '$chk_number','$paymentstatus', '$paymenttype','$cc_cardtype',
'$custompaymentinfo','1','$depositid','$cashchange')";
@mysqli_query($rs_connect, $insertpaymentssql);

$editdepositsql = "UPDATE deposits SET amount = '$balance', cashchange = '', cashchange2 = '' WHERE depositid = '$depositid'";
@mysqli_query($rs_connect, $editdepositsql);


$insertnewdepositsql = "INSERT INTO deposits (pfirstname,plastname,pcompany,paddress,paddress2,pcity,pstate,pzip,pphone,pemail,byuser,amount,paymentplugin,
cc_number,cc_expmonth,cc_expyear,cc_transid,cc_confirmation,cc_cid,cc_track1,cc_track2,chk_dl,chk_number,paymentstatus,paymenttype,cc_cardtype,custompaymentinfo,
dstatus,depdate,storeid,parentdeposit,registerid,aregisterid)
VALUES ('$pfirstname', '$plastname', '$pcompany', '$paddress', '$paddress2', '$pcity', '$pstate', '$pzip', '$pphone', '$pemail', '$ipofpc','$amountextra',
'$paymentplugin',
'$ccnumber2', '$cc_expmonth', '$cc_expyear', '$cc_transid', '$cc_confirmation', '$cc_cid', '$cc_track1', '$cc_track2', '$chk_dl', '$chk_number','$paymentstatus',
'$paymenttype','$cc_cardtype',
'$custompaymentinfo','$dstatus','$depdate','$storeid','$parentdepositid','$registerid','$aregisterid')";

@mysqli_query($rs_connect, $insertnewdepositsql);

}

}

header("Location: cart.php");
}



###########


function editdeposit() {

require_once("common.php");
if(($gomodal != "1") || array_key_exists('modaloff', $_REQUEST)) {
require("header.php");
} else {
require_once("validate.php");
}


$depositid = $_REQUEST['depositid'];


if(($gomodal != "1") || array_key_exists("modaloff", $_REQUEST)) {
start_blue_box(pcrtlang("Edit Deposit"));
} else {
echo "<font class=text16heading>".pcrtlang("Edit Deposit")."</font><br><br>";
}




$rs_find_name = "SELECT * FROM deposits WHERE depositid = '$depositid'";
$rs_result_name = mysqli_query($rs_connect, $rs_find_name);

$rs_result_name_q = mysqli_fetch_object($rs_result_name);
$rs_soldto = "$rs_result_name_q->pfirstname";
$rs_company = "$rs_result_name_q->pcompany";
$rs_ad1 = "$rs_result_name_q->paddress";
$rs_ad2 = "$rs_result_name_q->paddress2";
$rs_city = "$rs_result_name_q->pcity";
$rs_state = "$rs_result_name_q->pstate";
$rs_zip = "$rs_result_name_q->pzip";
$rs_ph = "$rs_result_name_q->pphone";
$rs_email = "$rs_result_name_q->pemail";

echo "<form action=deposits.php?func=editdeposit2 method=post>";
echo "<table width=100%>";
echo "<tr><td><font class=text12b>".pcrtlang("Customer Name").":</font></td><td><input size=35 class=textbox type=text name=depname value=\"$rs_soldto\"></td></tr>";
echo "<tr><td><font class=text12b>".pcrtlang("Company").":</font></td><td><input size=35 class=textbox type=text name=depcompany value=\"$rs_company\"></td></tr>";
echo "<tr><td><font class=text12b>$pcrt_address1:</font></td><td><input size=35 type=text class=textbox name=depaddy1 value=\"$rs_ad1\"></td></tr>";
echo "<tr><td><font class=text12b>$pcrt_address2:</font></td><td><input size=35 type=text class=textbox name=depaddy2 value=\"$rs_ad2\"></td></tr>";
echo "<tr><td><font class=text12b>$pcrt_city:</font></td><td><input size=35 type=text class=textbox name=depcity value=\"$rs_city\"></td></tr>";
echo "<tr><td><font class=text12b>$pcrt_state:</font></td><td><input size=35 type=text class=textbox name=depstate value=\"$rs_state\"></td></tr>";
echo "<tr><td><font class=text12b>$pcrt_zip:</font></td><td><input size=35 type=text class=textbox name=depzip value=\"$rs_zip\"></td></tr>";
echo "<tr><td><font class=text12b>".pcrtlang("Customer Phone").":</font></td><td><input size=35 type=text class=textbox name=depphone value=\"$rs_ph\"></td></tr>";
echo "<tr><td><font class=text12b>".pcrtlang("Customer Email").":</font></td><td><input size=35 type=text class=textbox name=depemail value=\"$rs_email\"></td></tr>";
echo "<tr><td></td><td><input type=hidden name=depositid value=\"$depositid\"><input type=submit class=ibutton value=\"".pcrtlang("Save Deposit")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Saving Deposit")."...'; this.form.submit();\"></td></tr>";
echo "</table>";

if(($gomodal != "1") || array_key_exists('modaloff', $_REQUEST)) {
stop_blue_box();
require_once("footer.php");
}


}


function editdeposit2() {
require_once("validate.php");
require("deps.php");
require("common.php");

$depositid = $_REQUEST['depositid'];
$depname = pv($_REQUEST['depname']);
$depcompany = pv($_REQUEST['depcompany']);
$depaddy1 = pv($_REQUEST['depaddy1']);
$depaddy2 = pv($_REQUEST['depaddy2']);
$depphone = pv($_REQUEST['depphone']);
$depemail = pv($_REQUEST['depemail']);
$depcity = pv($_REQUEST['depcity']);
$depstate = pv($_REQUEST['depstate']);
$depzip = pv($_REQUEST['depzip']);




$rs_update_deposit = "UPDATE deposits SET pfirstname = '$depname', pcompany = '$depcompany', paddress = '$depaddy1', paddress2 = '$depaddy2', pphone = '$depphone', pcity = '$depcity', pstate = '$depstate', pzip = '$depzip', pemail = '$depemail' WHERE depositid = '$depositid'";
@mysqli_query($rs_connect, $rs_update_deposit);

header("Location: deposits.php");

}


function savesig() {

require("deps.php");
require("common.php");

$output = pv($_REQUEST['output']);
$depositid = $_REQUEST['depositid'];

require_once("validate.php");




$rs_savesig = "UPDATE deposits SET thesig = '$output' WHERE depositid = '$depositid'";
@mysqli_query($rs_connect, $rs_savesig);

header("Location: deposits.php?func=deposit_receipt&depositid=$depositid");

}

function savesigtopaz() {

require("deps.php");
require("common.php");

$output = pv($_REQUEST['sigImageData']);
$depositid = $_REQUEST['depositid'];

require_once("validate.php");




$rs_savesig = "UPDATE deposits SET thesigtopaz = '$output' WHERE depositid = '$depositid'";
@mysqli_query($rs_connect, $rs_savesig);

header("Location: deposits.php?func=deposit_receipt&depositid=$depositid");

}


function clearsig() {

require("deps.php");
require("common.php");

$depositid = $_REQUEST['depositid'];

require_once("validate.php");




$rs_savesig = "UPDATE deposits SET thesig = '' WHERE depositid = '$depositid'";
@mysqli_query($rs_connect, $rs_savesig);

header("Location: deposits.php?func=deposit_receipt&depositid=$depositid");

}


function clearsigtopaz() {

require("deps.php");
require("common.php");

$depositid = $_REQUEST['depositid'];

require_once("validate.php");




$rs_savesig = "UPDATE deposits SET thesigtopaz = '' WHERE depositid = '$depositid'";
@mysqli_query($rs_connect, $rs_savesig);

header("Location: deposits.php?func=deposit_receipt&depositid=$depositid");

}


function hidesigdep() {

require("deps.php");
require("common.php");

$hidesig = pv($_REQUEST['hidesig']);
$depositid = $_REQUEST['depositid'];

require_once("validate.php");




$rs_hidesig = "UPDATE deposits SET showsigdep = '$hidesig' WHERE depositid = '$depositid'";
@mysqli_query($rs_connect, $rs_hidesig);

header("Location: deposits.php?func=deposit_receipt&depositid=$depositid");

}


function hidesigdeptopaz() {

require("deps.php");
require("common.php");

$hidesig = pv($_REQUEST['hidesig']);
$depositid = $_REQUEST['depositid'];

require_once("validate.php");




$rs_hidesig = "UPDATE deposits SET showsigdeptopaz = '$hidesig' WHERE depositid = '$depositid'";
@mysqli_query($rs_connect, $rs_hidesig);

header("Location: deposits.php?func=deposit_receipt&depositid=$depositid");

}



function searchdeposits() {
require_once("header.php");
require("deps.php");

$searchterm = $_REQUEST['searchterm'];





start_box();
echo "<form action=deposits.php?func=searchdeposits method=POST>";
echo "<input type=text value=\"$searchterm\" name=searchterm class=textbox size=25>";
echo "<input type=submit class=button value=\"".pcrtlang("Search Again")."\"></form>";
stop_box();

echo "<br>";

start_color_box("51",pcrtlang("Deposit Search Results"));
echo "<table border=0 cellspacing=3 cellpadding=2>";
echo "<tr class=troweven><td><font class=text12b>".pcrtlang("Dep")."#&nbsp;&nbsp;</font></td><td>
<font class=text12b>".pcrtlang("Customer Name")."&nbsp;&nbsp;</font></td><td>
<font class=text12b>".pcrtlang("Deposit Date")."&nbsp;&nbsp;</font></td><td><font class=text12b>".pcrtlang("Applied Date")."</font></td>";
echo "<td><font class=text12b> ".pcrtlang("Total")." </font>&nbsp;&nbsp;</td><td><font class=text12b>".pcrtlang("Actions")."</font>&nbsp;&nbsp;</td></tr>";


$rs_deposits = "SELECT * FROM deposits WHERE pfirstname LIKE '%$searchterm%' OR plastname LIKE '%$searchterm%' OR pphone LIKE '%$searchterm%' OR pemail LIKE '%$searchterm%' OR pcompany LIKE '%$searchterm%' ORDER BY depdate DESC";
$rs_find_deposits = @mysqli_query($rs_connect, $rs_deposits);
while($rs_find_deposits_q = mysqli_fetch_object($rs_find_deposits)) {
$depositid = "$rs_find_deposits_q->depositid";
$depfirstname = "$rs_find_deposits_q->pfirstname";
$deplastname = "$rs_find_deposits_q->plastname";
$depname = "$depfirstname $deplastname";
$depcompany = "$rs_find_deposits_q->pcompany";
$depamount2 = "$rs_find_deposits_q->amount";
$depamount = number_format($depamount2, 2, '.', '');
$depwoid = "$rs_find_deposits_q->woid";
$depemail = "$rs_find_deposits_q->pemail";
$paymentplugin = "$rs_find_deposits_q->paymentplugin";
$depdate = "$rs_find_deposits_q->depdate";
$depdate2 = pcrtdate("$pcrt_longdate", "$depdate");
$deprec = "$rs_find_deposits_q->receipt_id";
$applieddate = "$rs_find_deposits_q->applieddate";
$applieddate2 = pcrtdate("$pcrt_longdate", "$applieddate");

echo "<tr><td><font class=text12>$depositid</font></td><td><font class=text12b>$depfirstname";
if("$depcompany" != "") {
echo " - $depcompany";
}
echo "</font></td><td><font class=text12>$depdate2</font></td><td><font class=text12>$applieddate2</font></td>
<td><font class=text12b>$money".mf("$depamount")."</font></td>";
echo "<td><a href=deposits.php?func=deposit_receipt&depositid=$depositid&depemail=$depemail&woid=$depwoid>".pcrtlang("Print")."</a>";
if($depwoid != "0") {
echo " | <a href=../repair/index.php?pcwo=$depwoid>".pcrtlang("View Work Order")." #$depwoid</a>";
}
if (($depwoid != "0") && ($deprec != "0")) {
echo " | ";
}
if($deprec != "0") {
echo " <a href=receipt.php?func=show_receipt&receipt=$deprec>".pcrtlang("View Receipt")." #$deprec</a>";
}
echo "</td></tr>";
}
echo "</table>";
stop_color_box();

echo "<br>";



require_once("footer.php");

}

function removefrominvoice() {

require("deps.php");
require("common.php");

$depositid = pv($_REQUEST['depositid']);

require_once("validate.php");

$switchdep = "UPDATE deposits SET invoiceid = '0' WHERE depositid = '$depositid'";
@mysqli_query($rs_connect, $switchdep);

header("Location: deposits.php");
}


function adddeptoinv() {

require("deps.php");
require("common.php");

$depositid = pv($_REQUEST['depositid']);
$invoiceid = pv($_REQUEST['invoiceid']);

require_once("validate.php");

$switchdep = "UPDATE deposits SET invoiceid = '$invoiceid' WHERE depositid = '$depositid'";
@mysqli_query($rs_connect, $switchdep);

header("Location: invoice.php?func=printinv&invoice_id=$invoiceid");
}


switch($func) {
                                                                                                    
    default:
    deposits();
    break;
                                
    case "adddep":
    adddep();
    break;

    case "alldeposits":
    alldeposits();
    break;

case "editdeposit":
    editdeposit();
    break;

case "editdeposit2":
    editdeposit2();
    break;

case "deposit_receipt":
    deposit_receipt();
    break;

case "email_deposit_receipt":
    email_deposit_receipt();
    break;

case "email_deposit_receipt2":
    email_deposit_receipt2();
    break;

case "savesig":
    savesig();
    break;

case "clearsig":
    clearsig();
    break;

case "hidesigdep":
    hidesigdep();
    break;

case "savesigtopaz":
    savesigtopaz();
    break;

case "clearsigtopaz":
    clearsigtopaz();
    break;

case "hidesigdeptopaz":
    hidesigdeptopaz();
    break;


case "searchdeposits":
    searchdeposits();
    break;

case "removefrominvoice":
   removefrominvoice();
    break;

case "adddeptoinv":
   adddeptoinv();
    break;

}

