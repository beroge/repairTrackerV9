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

                                                                                                    
function search() {
require_once("validate.php");
require_once("dheader.php");
require("deps.php");

dheader(pcrtlang("Search"));

echo pcrtlang("Enter Search Term").":<form action=autosearch.php?func=possearch method=POST data-ajax=\"false\">";
echo "<input type=text name=search type=search>";
echo "<input type=submit value=\"".pcrtlang("Search")."\"  data-theme=\"b\"></form><br><br>";


dfooter();

require_once("dfooter.php");


}



function possearch() {
require_once("validate2.php");
require("deps.php");
require("common.php");


require_once("header.php");

$search = pv($_REQUEST['search']);







echo pcrtlang("Enter Search Term").":<form action=autosearch.php?func=possearch method=POST data-ajax=\"false\">";
echo "<input type=text name=search required>";
echo "<input type=submit value=\"".pcrtlang("Search Again")."\"  data-theme=\"b\"></form><br><br>";


echo "<div data-role=\"tabs\" id=\"tabs\">";
echo "<div data-role=\"navbar\">";
echo "<ul>";
echo "<li><a href=\"#deposits\" data-ajax=\"false\">".pcrtlang("Deposits")."</a></li>";
echo "<li><a href=\"#invoicing\" data-ajax=\"false\">".pcrtlang("Invoices")."</a></li>";
echo "<li><a href=\"#receipts\" data-ajax=\"false\">".pcrtlang("Receipts")."</a></li>";
echo "</ul>";
echo "</div>";


#start dep ind

echo "<div id=\"deposits\" class=\"ui-body-d ui-content\">";

$rs_find_solodep = "SELECT * FROM deposits WHERE depositid = '$search'";
$rs_result_item_solodep = mysqli_query($rs_connect, $rs_find_solodep);

if (mysqli_num_rows($rs_result_item_solodep) != "0") {
$rs_result_item_solodep_q = mysqli_fetch_object($rs_result_item_solodep);
$depositid = "$rs_result_item_solodep_q->depositid";
$dfirstname = "$rs_result_item_solodep_q->pfirstname";
$dlastname = "$rs_result_item_solodep_q->plastname";
$dcompany = "$rs_result_item_solodep_q->pcompany";
$damount = "$rs_result_item_solodep_q->amount";
$demail = "$rs_result_item_solodep_q->pemail";
$woid = "$rs_result_item_solodep_q->woid";

echo "$dfirstname $dlastname";
if ("$dcompany" != "") {
echo "<br>$dcompany";
}

echo "<br>$money".mf("$damount");
echo "<br>Deposit ID# $depositid";
echo "<button type=button onClick=\"parent.location='deposits.php?func=deposit_receipt&depemail=$demail&woid=$woid&depositid=$depositid'\">".pcrtlang("view")."</button>";

}





echo "<h3>".pcrtlang("Deposit Search Results")."</h3>";



$rs_find_solodep = "SELECT * FROM deposits WHERE pfirstname LIKE '%$search%' OR plastname LIKE '%$search%' OR pemail LIKE '%$search%' OR pphone LIKE '%$search%'";
$rs_result_item_solodep = mysqli_query($rs_connect, $rs_find_solodep);

if (mysqli_num_rows($rs_result_item_solodep) == "0") {

echo pcrtlang("No Items Found")."...";

} else {

while ($rs_result_item_solodep_q = mysqli_fetch_object($rs_result_item_solodep)) {
$depositid = "$rs_result_item_solodep_q->depositid";
$dfirstname = "$rs_result_item_solodep_q->pfirstname";
$dlastname = "$rs_result_item_solodep_q->plastname";
$dcompany = "$rs_result_item_solodep_q->pcompany";
$damount = "$rs_result_item_solodep_q->amount";
$demail = "$rs_result_item_solodep_q->pemail";
$woid = "$rs_result_item_solodep_q->woid";
$dstatus = "$rs_result_item_solodep_q->dstatus";

echo "<table class=standard><tr><th>";
echo "$dfirstname $dlastname</th><th style=\"text-align:right;\">$money".mf("$damount")."</th></tr>";
if ("$dcompany" != "") {
echo "<tr><td colspan=2>$dcompany";
}
echo "<tr><td colspan=2>";

echo "<div data-role=\"collapsible\" data-mini=\"true\">";
echo "<h3>".pcrtlang("Deposit Actions")."</h3>";

echo "<button type=button onClick=\"parent.location='deposits.php?func=editdeposit&depositid=$depositid'\" data-mini=\"true\"><i class=\"fa fa-edit\"></i> edit deposit</button>";
echo "<button type=button onClick=\"parent.location='deposits.php?func=deposit_receipt&depositid=$depositid'\" data-mini=\"true\"><i class=\"fa fa-print fa-lg\"></i> print deposit receipt</button>";
if($dstatus == "open") {
echo "<button type=button onClick=\"parent.location='deposits.php?func=adddep&depositid=$depositid'\" data-mini=\"true\"><i class=\"fa fa-cart-plus fa-lg\"></i> add to cart</button>";
}

echo "</div>";

echo "</td></tr></table><br>";

}
}

echo "</div>";




#start inv ind
echo "<div id=\"invoicing\" class=\"ui-body-d ui-content\">";

$rs_find_invoice_solo = "SELECT * FROM invoices WHERE invoice_id = '$search' AND iorq != 'quote'";
$rs_result_invoice_solo = mysqli_query($rs_connect, $rs_find_invoice_solo);


if (mysqli_num_rows($rs_result_invoice_solo) != "0") {

$rs_result_invoice_solo_q = mysqli_fetch_object($rs_result_invoice_solo);
$invoice_id = "$rs_result_invoice_solo_q->invoice_id";
$invname = "$rs_result_invoice_solo_q->invname";
$invcompany = "$rs_result_invoice_solo_q->invcompany";
$invstatus = "$rs_result_invoice_solo_q->invstatus";
$invcompany = "$rs_result_invoice_solo_q->invcompany";
$invemail = "$rs_result_invoice_solo_q->invemail";
$invphone = "$rs_result_invoice_solo_q->invphone";
$invaddy1 = "$rs_result_invoice_solo_q->invaddy1";
$invaddy2 = "$rs_result_invoice_solo_q->invaddy2";
$invcity = "$rs_result_invoice_solo_q->invcity";
$invstate = "$rs_result_invoice_solo_q->invstate";
$invzip = "$rs_result_invoice_solo_q->invzip";
$invstoreid = "$rs_result_invoice_solo_q->storeid";
$invwoid = "$rs_result_invoice_solo_q->woid";
$invrec = "$rs_result_invoice_solo_q->receipt_id";


if($invstatus == 1) {
$thestatus = pcrtlang("Open");
} elseif ($invstatus == 2) {
$thestatus = pcrtlang("Paid/Closed");
} else {
$thestatus = pcrtlang("Voided");
}




$invname_ue = urlencode($invname);
$invcompany_ue = urlencode($invcompany);
$invemail_ue = urlencode($invemail);
$invphone_ue = urlencode($invphone);
$invaddy1_ue = urlencode($invaddy1);
$invaddy2_ue = urlencode($invaddy2);
$invcity_ue = urlencode($invcity);
$invstate_ue = urlencode($invstate);
$invzip_ue = urlencode($invzip);

$invwoid = "$rs_result_invoice_solo_q->woid";
$pcgroupid = "$rs_result_invoice_solo_q->pcgroupid";
$invrec = "$rs_result_invoice_solo_q->receipt_id";
$invdate = "$rs_result_invoice_solo_q->invdate";
$invdate2 = pcrtdate("$pcrt_shortdate", "$invdate");
$findinvtotal = "SELECT SUM(cart_price) AS invsubtotal, SUM(itemtax) AS invtax FROM invoice_items WHERE invoice_id = '$invoice_id'";
$findinvq = @mysqli_query($rs_connect, $findinvtotal);
$findinva = mysqli_fetch_object($findinvq);
$invtax = "$findinva->invtax";
$invsubtotal = "$findinva->invsubtotal";
$invtotal2 = $invtax + $invsubtotal;
$invtotal = number_format($invtotal2, 2, '.', '');

$iorq = invoiceorquote($invoice_id);
if ($iorq == "quote") {
$ilabel = pcrtlang("Quote");
} else {
$ilabel = pcrtlang("Invoice");
}



echo "<strong>$invname</strong>";
if($invcompany != "") {
echo "<br>$invcompany";
}
echo "<br>".pcrtlang("Total").": $money$invtotal";


echo "<br>".pcrtlang("$ilabel").": #$invoice_id";

echo "<br>".pcrtlang("Status").": $thestatus<br>";

echo pcrtlang("Invoice Date").": $invdate2";

echo "<div data-role=\"collapsible\" data-mini=\"true\">";
echo "<h3>".pcrtlang("Actions")."</h3>";

echo "<button type=button onClick=\"parent.location='invoice.php?func=printinv&invoice_id=$invoice_id'\" data-mini=\"true\">Print</button>";
echo "<button type=button onClick=\"parent.location='invoice.php?func=emailinv2&invoice_id=$invoice_id&emailaddy=$invemail'\" data-mini=\"true\">".pcrtlang("Email")."</button>";

echo "<button type=button onClick=\"parent.location='invoice.php?func=editinvoice&invoice_id=$invoice_id&modaloff=off&returnurl=../store/invoice.php'\" data-mini=\"true\">".pcrtlang("Edit")."</button>";
if ($invstatus == "1") {
echo "<button type=button onClick=\"parent.location='invoice.php?func=checkoutinv&invoice_id=$invoice_id&woid=$invwoid&custname=$invname_ue&company=$invcompany_ue&custaddy1=$invaddy1_ue&custaddy2=$invaddy2_ue&custcity=$invcity_ue&custstate=$invstate_ue&custzip=$invzip_ue&custphone=$invphone_ue&custemail=$invemail_ue&pcgroupid=$pcgroupid'\" data-mini=\"true\">".pcrtlang("Checkout/Edit Items")."</button>";
echo "<button type=button onClick=\"parent.location='invoice.php?func=changeinvoicestatus&invstatus=3&invoice_id=$invoice_id'\" data-mini=\"true\">".pcrtlang("Void")."</button> ";
echo "<button type=button onClick=\"parent.location='invoice.php?func=changeinvoicestatus&invstatus=2&invoice_id=$invoice_id'\" data-mini=\"true\">".pcrtlang("Close")."</button>";
} else {
echo "<button type=button onClick=\"parent.location='invoice.php?func=changeinvoicestatus&invstatus=1&invoice_id=$invoice_id'\" data-mini=\"true\">".pcrtlang("Re-Open this Invoice")."</button> ";
}

if($invwoid != "0") {
echo "<button type=button onClick=\"parent.location='../repairmobile/pc.php?func=view&woid=$invwoid'\" data-mini=\"true\">".pcrtlang("View Work Order")." #$invwoid</button>";
}
if($invrec != "0") {
echo "<button type=button onClick=\"parent.location='receipt.php?func=show_receipt&receipt=$invrec'\" data-mini=\"true\">".pcrtlang("View Receipt")." #$invrec</button>";
}

echo "</div>";

}



echo "<h3>".pcrtlang("Invoice Search Results")."</h3>";

$rs_find_invoice = "SELECT * FROM invoices WHERE invname LIKE '%$search%' OR invphone LIKE '%$search%' OR invemail LIKE '%$search%' OR invnotes LIKE '%$search%' AND iorq != 'quote' ORDER BY invoice_id DESC LIMIT 20";
$rs_result_invoice = mysqli_query($rs_connect, $rs_find_invoice);


if (mysqli_num_rows($rs_result_invoice) == "0") {

echo "<br>".pcrtlang("No Items Found")."...<br><br>";

} else {


while ($rs_result_invoice_q = mysqli_fetch_object($rs_result_invoice)) {
$invoice_id = "$rs_result_invoice_q->invoice_id";
$invname = "$rs_result_invoice_q->invname";
$invcompany = "$rs_result_invoice_q->invcompany";
$invstatus = "$rs_result_invoice_q->invstatus";
$invcompany = "$rs_result_invoice_q->invcompany";
$invemail = "$rs_result_invoice_q->invemail";
$invphone = "$rs_result_invoice_q->invphone";
$invaddy1 = "$rs_result_invoice_q->invaddy1";
$invaddy2 = "$rs_result_invoice_q->invaddy2";
$invcity = "$rs_result_invoice_q->invcity";
$invstate = "$rs_result_invoice_q->invstate";
$invzip = "$rs_result_invoice_q->invzip";
$invstoreid = "$rs_result_invoice_q->storeid";
$invwoid = "$rs_result_invoice_q->woid";
$invrec = "$rs_result_invoice_q->receipt_id";


if($invstatus == 1) {
$thestatus = pcrtlang("Open");
} elseif ($invstatus == 2) {
$thestatus = pcrtlang("Paid/Closed");
} else {
$thestatus = pcrtlang("Voided");
}




$invname_ue = urlencode($invname);
$invcompany_ue = urlencode($invcompany);
$invemail_ue = urlencode($invemail);
$invphone_ue = urlencode($invphone);
$invaddy1_ue = urlencode($invaddy1);
$invaddy2_ue = urlencode($invaddy2);
$invcity_ue = urlencode($invcity);
$invstate_ue = urlencode($invstate);
$invzip_ue = urlencode($invzip);

$invwoid = "$rs_result_invoice_q->woid";
$pcgroupid = "$rs_result_invoice_q->pcgroupid";
$invrec = "$rs_result_invoice_q->receipt_id";
$invdate = "$rs_result_invoice_q->invdate";
$invdate2 = pcrtdate("$pcrt_shortdate", "$invdate");
$findinvtotal = "SELECT SUM(cart_price) AS invsubtotal, SUM(itemtax) AS invtax FROM invoice_items WHERE invoice_id = '$invoice_id'";
$findinvq = @mysqli_query($rs_connect, $findinvtotal);
$findinva = mysqli_fetch_object($findinvq);
$invtax = "$findinva->invtax";
$invsubtotal = "$findinva->invsubtotal";
$invtotal2 = $invtax + $invsubtotal;
$invtotal = number_format($invtotal2, 2, '.', '');

$iorq = invoiceorquote($invoice_id);
if ($iorq == "quote") {
$ilabel = pcrtlang("Quote");
} else {
$ilabel = pcrtlang("Invoice");
}



echo "<table class=standard><tr><th colspan=2>$invname";
if($invcompany != "") {
echo " &bull; $invcompany";
}
echo "</th></tr>";
echo "<tr><td>".pcrtlang("Total").":</td><td>$money$invtotal</td></tr>";


echo "<tr><td>".pcrtlang("$ilabel").":</td><td>#$invoice_id</td</tr>";

echo "<tr><td>".pcrtlang("Status").":</td><td>$thestatus</td></tr>";

echo "<tr><td>".pcrtlang("Invoice Date").":</td><td>$invdate2</td></tr>";
echo "<tr><td colspan=2>";

echo "<div data-role=\"collapsible\" data-mini=\"true\">";
echo "<h3>".pcrtlang("Actions")."</h3>";

echo "<button type=button onClick=\"parent.location='invoice.php?func=printinv&invoice_id=$invoice_id'\" data-mini=\"true\">Print</button>";
echo "<button type=button onClick=\"parent.location='invoice.php?func=emailinv2&invoice_id=$invoice_id&emailaddy=$invemail'\" data-mini=\"true\">".pcrtlang("Email")."</button>";

echo "<button type=button onClick=\"parent.location='invoice.php?func=editinvoice&invoice_id=$invoice_id&modaloff=off&returnurl=../store/invoice.php'\" data-mini=\"true\">".pcrtlang("Edit")."</button> ";
if ($invstatus == "1") {
echo "<button type=button onClick=\"parent.location='invoice.php?func=checkoutinv&invoice_id=$invoice_id&woid=$invwoid&custname=$invname_ue&company=$invcompany_ue&custaddy1=$invaddy1_ue&custaddy2=$invaddy2_ue&custcity=$invcity_ue&custstate=$invstate_ue&custzip=$invzip_ue&custphone=$invphone_ue&custemail=$invemail_ue&pcgroupid=$pcgroupid'\" data-mini=\"true\">".pcrtlang("Checkout/Edit Items")."</button> ";
echo "<button type=button onClick=\"parent.location='invoice.php?func=changeinvoicestatus&invstatus=3&invoice_id=$invoice_id'\" data-mini=\"true\">".pcrtlang("Void")."</button> ";
echo "<button type=button onClick=\"parent.location='invoice.php?func=changeinvoicestatus&invstatus=2&invoice_id=$invoice_id'\" data-mini=\"true\">".pcrtlang("Close")."</button>";
} else {
echo "<button type=button onClick=\"parent.location='invoice.php?func=changeinvoicestatus&invstatus=1&invoice_id=$invoice_id'\" data-mini=\"true\">".pcrtlang("Re-Open this Invoice")."</button> ";
}

if($invwoid != "") {
echo "<button type=button onClick=\"parent.location='../repairmobile/pc.php?func=view&woid=$invwoid'\" data-mini=\"true\">".pcrtlang("View Work Order")." # $invwoid</button>";
}
if($invrec != "0") {
echo "<button type=button onClick=\"parent.location='receipt.php?func=show_receipt&receipt=$invrec'\" data-mini=\"true\">".pcrtlang("View Receipt")." # $invrec</button>";
}

echo "</div>";

echo "</td></tr></table><br>";

}


}


echo "</div>";


#start rec ind
echo "<div id=\"receipts\" class=\"ui-body-d ui-content\">";

$rs_find_rec_solo = "SELECT * FROM receipts WHERE receipt_id = '$search'";
$rs_result_rec_solo = mysqli_query($rs_connect, $rs_find_rec_solo);

if (mysqli_num_rows($rs_result_rec_solo) != "0") {

$rs_result_rec_solo_q = mysqli_fetch_object($rs_result_rec_solo);
$rs_soldto = "$rs_result_rec_solo_q->person_name";
$rs_company = "$rs_result_rec_solo_q->company";
$rs_rt = "$rs_result_rec_solo_q->receipt_id";
$rs_date = "$rs_result_rec_solo_q->date_sold";
$rtot = "$rs_result_rec_solo_q->grandtotal";
$rs_date2 = pcrtdate("$pcrt_shortdate", "$rs_date");

echo "<strong>$rs_soldto</strong>";
if($rs_company != "") {
echo "<br>$rs_company";
}
echo "<br>".pcrtlang("Receipt Date").": $rs_date2<br>".pcrtlang("Amount").": ".mf("$rtot");
echo "<br>".pcrtlang("Receipt")." #$rs_rt&nbsp;&nbsp;<button type=button onClick=\"parent.location='receipt.php?func=show_receipt&receipt=$rs_rt'\" data-mini=\"true\">".pcrtlang("view")."</button><br><br>";


}





echo "<h3>".pcrtlang("Receipt Search Results")."</h3>";

$rs_find_rec = "SELECT * FROM receipts WHERE person_name LIKE '%$search%' OR company LIKE '%$search%' OR phone_number LIKE '%$search%' ORDER BY date_sold DESC LIMIT 20";
$rs_result_rec = mysqli_query($rs_connect, $rs_find_rec);

if (mysqli_num_rows($rs_result_rec) == "0") {

echo "<br>".pcrtlang("No Items Found")."...<br><br>";

} else {


while($rs_result_rec_q = mysqli_fetch_object($rs_result_rec)) {
$rs_soldto = "$rs_result_rec_q->person_name";
$rs_company = "$rs_result_rec_q->company";
$rs_rt = "$rs_result_rec_q->receipt_id";
$rs_date = "$rs_result_rec_q->date_sold";
$rtot = "$rs_result_rec_q->grandtotal";
$rs_date2 = pcrtdate("$pcrt_shortdate", "$rs_date");

echo "<table class=standard><tr><th colspan=2>$rs_soldto";
if($rs_company != "") {
echo " &bull; $rs_company";
}
echo "</th></tr>";
echo "<tr><td>".pcrtlang("Receipt Date").":</td><td>$rs_date2</td></tr><tr><td>".pcrtlang("Amount").": </td><td>$money".mf("$rtot")."</td></tr>";
echo "<tr><td>".pcrtlang("Receipt")." #$rs_rt</td><td><button type=button onClick=\"parent.location='receipt.php?func=show_receipt&receipt=$rs_rt'\" data-mini=\"true\">".pcrtlang("view")."</button></td></tr>";

echo "</table><br>";
}


}



echo "</div>";

require_once("footer.php");

}


switch($func) {

    default:
    search();
    break;

    case "possearch":
    possearch();
    break;

    case "search":
    search();
    break;


    case "inv":
    inv();
    break;


}

?>

