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

function possearch() {
require_once("validate2.php");
require("deps.php");
require("common.php");


$search = pv($_REQUEST['search']);






echo "<button id=button class=ibutton style=\"float:right;\"><i class=\"fa fa-times fa-lg\"></i></button>";

?>

<script>
$("#button").click(function() { 
    $("#autosearch").slideUp(200);
});
</script>
<?php

echo "<table width=100%><tr><td width=32% valign=top>";

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

echo "<table class=standard><tr><th style=\"width:50px;\"><img src=images/deposits.png align=absmiddle></th>";
echo "<th><span class=sizeme20>$dfirstname $dlastname</span><br>&nbsp;";
if ("$dcompany" != "") {
echo "$dcompany";
}

echo "</th></tr><tr><td colspan=2>$money".mf("$damount")."</td></tr>";
echo "<tr><td colspan=2>".pcrtlang("Deposit ID")."#$depositid</td></tr>";
echo "<tr><td colspan=2><a href=\"deposits.php?func=deposit_receipt&depemail=$demail&woid=$woid&depositid=$depositid\" class=\"linkbuttonsmall linkbuttongray radiusall\">".pcrtlang("view")."</a></td></tr></table>";

}

echo "</td><td width=2%></td><td width=32%>";


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



echo "<table class=standard><tr><th style=\"width:50px;\"><img src=images/invoice.png align=absmiddle></th>";
echo "<th><span class=sizeme20>$invname</span><br>&nbsp;";
if($invcompany != "") {
echo "$invcompany";
}
echo "</th></tr><tr><td colspan=2>".pcrtlang("Total").": $money$invtotal</td></td>";


echo "<tr><td colspan=2>".pcrtlang("$ilabel").": #$invoice_id</td></tr>";

echo "<tr><td colspan=2>".pcrtlang("Status").": $thestatus</td></tr>";

echo "<tr><td colspan=2>".pcrtlang("Invoice Date").": $invdate2</td></tr>";
echo "<tr><td colspan=2><a href=invoice.php?func=printinv&invoice_id=$invoice_id  class=\"linkbuttonsmall linkbuttongray radiusleft\"><i class=\"fa fa-print\"></i> Print</a>";
echo "<a href=invoice.php?func=emailinv2&invoice_id=$invoice_id&emailaddy=$invemail class=\"linkbuttonsmall linkbuttongray\"><i class=\"fa fa-envelope\"></i> ".pcrtlang("Email")."</a>";

echo "<a href=invoice.php?func=editinvoice&invoice_id=$invoice_id&modaloff=off&returnurl=../store/invoice.php class=\"linkbuttonsmall linkbuttongray radiusright\"><i class=\"fa fa-edit\"></i> ".pcrtlang("Edit")."</a>";
if ($invstatus == "1") {
echo "<br><a href=invoice.php?func=checkoutinv&invoice_id=$invoice_id&woid=$invwoid&custname=$invname_ue&company=$invcompany_ue&custaddy1=$invaddy1_ue&custaddy2=$invaddy2_ue&custcity=$invcity_ue&custstate=$invstate_ue&custzip=$invzip_ue&custphone=$invphone_ue&custemail=$invemail_ue&pcgroupid=$pcgroupid class=\"linkbuttonsmall linkbuttongray radiusleft\"><i class=\"fa fa-shopping-cart\"></i> ".pcrtlang("Checkout/Edit Items")."</a>";
echo "<a href=invoice.php?func=changeinvoicestatus&invstatus=3&invoice_id=$invoice_id  onClick=\"return confirm('".pcrtlang("Are you sure you wish to void this invoice?")."');\" class=\"linkbuttonsmall linkbuttongray\"><i class=\"fa fa-ban\"></i> ".pcrtlang("Void")."</a>";
echo "<a href=invoice.php?func=changeinvoicestatus&invstatus=2&invoice_id=$invoice_id  onClick=\"return confirm('".pcrtlang("Are you sure you wish to close this invoice? Usually you want to checkout an invoice so that the invoice gets marked as paid.")."');\" class=\"linkbuttonsmall linkbuttongray radiusright\"><i class=\"fa fa-logout\"></i> ".pcrtlang("Close")."</a>";
} else {
echo "<br><a href=invoice.php?func=changeinvoicestatus&invstatus=1&invoice_id=$invoice_id  onClick=\"return confirm('".pcrtlang("Are you sure you wish to re-open this invoice?")."');\" class=\"linkbuttonsmall linkbuttongray radiusall\"><i class=\"fa fa-reply\"></i> ".pcrtlang("Re-Open this Invoice")."</a>";
}


if ($invwoid != "") {
$rs_woids = explode_list($invwoid);
foreach($rs_woids as $key => $rs_woidids) {
echo "<a href=../repair/pc.php?func=view&woid=$rs_woidids class=\"linkbuttonsmall linkbuttongray radiusall\">".pcrtlang("Work Order")." #$rs_woidids</a>";
}
}


if($invrec != "0") {
echo "<a href=receipt.php?func=show_receipt&receipt=$invrec class=\"linkbuttonsmall linkbuttongray radiusright\">".pcrtlang("View Receipt")." #$invrec</a>";
}

echo "</td></tr></table>";

}

echo "</td><td width=2%><td><td width=32% valign=top>";


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

echo "<table class=standard><tr><th style=\"width:50px;\"><img src=images/receipts.png align=absmiddle></th>";
echo "<th><span class=sizeme20>$rs_soldto</span><br>&nbsp;";
if($rs_company != "") {
echo "$rs_company";
}
echo "</th></tr><tr><td colspan=2>".pcrtlang("Receipt Date").": $rs_date2</td></tr><tr><td colspan=2>".pcrtlang("Amount").": ".mf("$rtot")."</td></tr>";
echo "<tr><td colspan=2>".pcrtlang("Receipt")." # $rs_rt</td></tr><tr><td colspan=2><a href=\"receipt.php?func=show_receipt&receipt=$rs_rt\" class=\"linkbuttonsmall linkbuttongray radiusall\"><i class=\"fa fa-eye\"></i> ".pcrtlang("view")."</a></td></tr></table>";


}




echo "</td></tr></table>";

echo "<table width=99%><tr><td width=32% valign=top>";

start_blue_box(pcrtlang("Deposit Search Results"));


echo "<table class=moneylist>";

$rs_find_solodep = "SELECT * FROM deposits WHERE pfirstname LIKE '%$search%' OR plastname LIKE '%$search%' OR pemail LIKE '%$search%' OR pphone LIKE '%$search%'";
$rs_result_item_solodep = mysqli_query($rs_connect, $rs_find_solodep);

if (mysqli_num_rows($rs_result_item_solodep) == "0") {

echo "<tr><td><br><span class=\"italme colormegray\">".pcrtlang("No Items Found")."...<br><br></span></td></tr>";

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

echo "<tr><th style=\"vertical-align:top;\">";
echo "<span class=boldme>$dfirstname $dlastname</span></th><th>&nbsp;&nbsp;$money".mf("$damount")."</th></tr>";
if ("$dcompany" != "") {
echo "<tr><td colspan=2><span class=sizemesmaller>$dcompany</span></td></tr>";
}
echo "<tr><td colspan=2><a href=deposits.php?func=editdeposit&depositid=$depositid&modaloff=off class=\"linkbuttontiny linkbuttonmoney radiusleft\"><i class=\"fa fa-edit\"></i> edit deposit</a>";
echo "<a href=deposits.php?func=deposit_receipt&depositid=$depositid class=\"linkbuttontiny linkbuttonmoney\"><i class=\"fa fa-print\"></i> print deposit receipt</a>";
if($dstatus == "open") {
echo "<a href=deposits.php?func=adddep&depositid=$depositid&modaloff=off class=\"linkbuttontiny linkbuttonmoney radiusright\"><i class=\"fa fa-cart-plus\"></i> add to cart</a>";
}
echo "<br><br></td></tr>";

}
}
echo "</table>";

stop_blue_box();



echo "</td><td width=2%></td><td width=32% valign=top>";

start_blue_box(pcrtlang("Invoice Search Results"));

$rs_find_invoice = "SELECT * FROM invoices WHERE invname LIKE '%$search%' OR invphone LIKE '%$search%' OR invemail LIKE '%$search%' OR invnotes LIKE '%$search%' AND iorq != 'quote' ORDER BY invoice_id DESC LIMIT 20";
$rs_result_invoice = mysqli_query($rs_connect, $rs_find_invoice);


if (mysqli_num_rows($rs_result_invoice) == "0") {

echo "<br><span class=\"italme colormegray\">".pcrtlang("No Items Found")."...<br><br></span>";

} else {

echo "<table class=standard>";

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



echo "<tr><th colspan=2>$invname";
if($invcompany != "") {
echo " &bull; $invcompany";
}
echo "</th></tr>";
echo "<tr><td><span class=\"sizemesmaller\">".pcrtlang("Total").":</span></td><td><span class=\"sizemesmaller boldme\">$money$invtotal</span></td></tr>";


echo "<tr><td><span class=\"sizemesmaller\">".pcrtlang("$ilabel").":</span></td><td><span class=\"sizemesmaller boldme\">#$invoice_id</span></td</tr>";

echo "<tr><td><span class=\"sizemesmaller\">".pcrtlang("Status").":</span></td><td><span class=\"sizemesmaller boldme\">$thestatus</span></td></tr>";

echo "<tr><td><span class=\"sizemesmaller\">".pcrtlang("Invoice Date").":</span></td><td><span class=\"sizemesmaller boldme\">$invdate2</span></td></tr>";
echo "<tr><td colspan=2><a href=invoice.php?func=printinv&invoice_id=$invoice_id class=\"linkbuttonsmall linkbuttongray radiusleft\"><i class=\"fa fa-print\"></i> Print</a>";
echo "<a href=invoice.php?func=emailinv2&invoice_id=$invoice_id&emailaddy=$invemail class=\"linkbuttonsmall linkbuttongray\"><i class=\"fa fa-envelope\"></i> ".pcrtlang("Email")."</a>";

echo "<a href=invoice.php?func=editinvoice&invoice_id=$invoice_id&modaloff=off&returnurl=../store/invoice.php class=\"linkbuttonsmall linkbuttongray radiusright\"><i class=\"fa fa-edit\"></i> ".pcrtlang("Edit")."</a>";
if ($invstatus == "1") {
echo "<br><a href=invoice.php?func=checkoutinv&invoice_id=$invoice_id&woid=$invwoid&custname=$invname_ue&company=$invcompany_ue&custaddy1=$invaddy1_ue&custaddy2=$invaddy2_ue&custcity=$invcity_ue&custstate=$invstate_ue&custzip=$invzip_ue&custphone=$invphone_ue&custemail=$invemail_ue&pcgroupid=$pcgroupid class=\"linkbuttonsmall linkbuttongray radiusleft\"><i class=\"fa fa-shopping-cart\"></i> ".pcrtlang("Checkout/Edit Items")."</a>";
echo "<a href=invoice.php?func=changeinvoicestatus&invstatus=3&invoice_id=$invoice_id  onClick=\"return confirm('".pcrtlang("Are you sure you wish to void this invoice?")."');\" class=\"linkbuttonsmall linkbuttongray\"><i class=\"fa fa-ban\"></i> ".pcrtlang("Void")."</a>";
echo "<a href=invoice.php?func=changeinvoicestatus&invstatus=2&invoice_id=$invoice_id  onClick=\"return confirm('".pcrtlang("Are you sure you wish to close this invoice? Usually you want to checkout an invoice so that the invoice gets marked as paid.")."');\" class=\"linkbuttonsmall linkbuttongray radiusall\"><i class=\"fa fa-logout\"></i> ".pcrtlang("Close")."</a>";
} else {
echo "<a href=invoice.php?func=changeinvoicestatus&invstatus=1&invoice_id=$invoice_id  onClick=\"return confirm('".pcrtlang("Are you sure you wish to re-open this invoice?")."');\" class=\"linkbuttonsmall linkbuttongray radiusall\"><i class=\"fa fa-reply\"></i> ".pcrtlang("Re-Open this Invoice")."</a>";
}

echo "<br>";
if($invwoid != "") {
echo "<a href=../repair/pc.php?func=view&woid=$invwoid class=\"linkbuttonsmall linkbuttongray radiusall\">".pcrtlang("View Work Order")." #$invwoid</a>";
}
if($invrec != "0") {
echo "<a href=receipt.php?func=show_receipt&receipt=$invrec class=\"linkbuttonsmall linkbuttongray radiusall\">".pcrtlang("View Receipt")." #$invrec</a>";
}

echo "<br><br></td></tr>";

}

echo "</table>";

}


stop_blue_box();

echo "</td><td width=2%></td><td width=32% valign=top>";


start_blue_box(pcrtlang("Receipt Search Results"));
#wip
$rs_find_rec = "(SELECT DISTINCT(receipts.receipt_id),receipts.person_name,receipts.company,receipts.date_sold,receipts.grandtotal FROM receipts,sold_items WHERE receipts.person_name LIKE '%$search%' OR receipts.company LIKE '%$search%' OR receipts.phone_number LIKE '%$search%')
UNION (SELECT DISTINCT(receipts.receipt_id),receipts.person_name,receipts.company,receipts.date_sold,receipts.grandtotal FROM receipts,sold_items WHERE receipts.receipt_id = sold_items.receipt AND sold_items.itemserial LIKE '%$search%') 
ORDER BY date_sold DESC LIMIT 20";
$rs_result_rec = mysqli_query($rs_connect, $rs_find_rec);


if (mysqli_num_rows($rs_result_rec) == "0") {

echo "<br><span class=\"italme colormegray\">".pcrtlang("No Items Found")."...<br><br></span>";

} else {

echo "<table class=standard>";

while($rs_result_rec_q = mysqli_fetch_object($rs_result_rec)) {
$rs_soldto = "$rs_result_rec_q->person_name";
$rs_company = "$rs_result_rec_q->company";
$rs_rt = "$rs_result_rec_q->receipt_id";
$rs_date = "$rs_result_rec_q->date_sold";
$rtot = "$rs_result_rec_q->grandtotal";
$rs_date2 = pcrtdate("$pcrt_shortdate", "$rs_date");

echo "<tr><th colspan=2>$rs_soldto";
if($rs_company != "") {
echo " &bull; $rs_company";
}
echo "</th></tr>";
echo "<tr><td><span class=\"sizemesmaller\">".pcrtlang("Receipt Date").":</span></td><td><span class=\"sizemesmaller boldme\">$rs_date2</span></td></tr><tr><td><span class=\"sizemesmaller\">".pcrtlang("Amount").": </span></td><td><span class=\"sizemesmaller boldme\">$money".mf("$rtot")."</span></td></tr>";
echo "<tr><td><span class=\"sizemesmaller\"> ".pcrtlang("Receipt")." # </span></td><td><span class=\"sizemesmaller boldme\">$rs_rt</span>&nbsp;&nbsp;<a href=\"receipt.php?func=show_receipt&receipt=$rs_rt\" class=\"linkbuttonsmall linkbuttongray radiusall\"><i class=\"fa fa-eye\"></i> ".pcrtlang("view")."</a></td></tr><tr><td colspan=2>&nbsp;</td></tr>";
}

echo "</table>";

}

stop_blue_box();

echo "</td></tr></table>";

}



function inv() {
require_once("validate2.php");
require("deps.php");
require("common.php");


$thesearch2 = pv($_REQUEST['search']);

$thesearch = str_replace(" ", "%", "$thesearch2");

$rs_show_stock = "SELECT * FROM stock WHERE (stock_id LIKE '%$thesearch%' OR stock_title LIKE '%$thesearch%' OR stock_upc LIKE '%$thesearch%' OR
stock_desc LIKE '%$thesearch%') AND dis_cont = 0";

$rs_stock_result = mysqli_query($rs_connect, $rs_show_stock);

if (mysqli_num_rows($rs_stock_result) != "0") {

echo "<table class=standard style=\"width:400px;\">";
while($rs_stock_result_q = mysqli_fetch_object($rs_stock_result)) {
$rs_stockid = "$rs_stock_result_q->stock_id";
$rs_stocktitle = "$rs_stock_result_q->stock_title";
$rs_stockdesc = "$rs_stock_result_q->stock_desc";
$rs_stockprice = "$rs_stock_result_q->stock_price";

checkstorecount($rs_stockid);

echo "<tr><td>";

$rs_find_serial = "SELECT * FROM inventory WHERE stock_id = '$rs_stockid' AND itemserial != ''";
$rs_find_serial_q = @mysqli_query($rs_connect, $rs_find_serial);
if(mysqli_num_rows($rs_find_serial_q) > 0) {
echo "<a href=\"cart.php?func=addbyserial&stockid=$rs_stockid\" class=\"linkbuttontiny linkbuttongray radiusall\"><i class=\"fa fa-cart-plus\"></i> $rs_stocktitle</a> (".pcrtlang("Must Enter Serial Number").")";
} else {
echo "<a href=\"javascript:void(0)\" onClick='document.getElementById(\"autoinvsearchbox\").value=$rs_stockid'
class=\"linkbuttontiny linkbuttongray radiusall\"><i class=\"fa fa-cart-plus\"></i> $rs_stocktitle</a>";
}


echo "</td><td style=\"text-align:right;\"><span class=\"boldme\">$money".mf("$rs_stockprice")."</span></td></tr>";

}

echo "</table>";

} else {

echo "<span class=\"colormegray italme\">".pcrtlang("No Search Results Found")."...</span>";
}

}




switch($func) {

    default:
    nothing();
    break;

    case "possearch":
    possearch();
    break;

    case "inv":
    inv();
    break;


}

?>
