<?php
                                                                                                    
/***************************************************************************
 *   copyright            : (C) 2020 PCRepairTracker.com
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


function invoices() {

echo "Nothing to see here";

}


function browsereceipts() {

require("deps.php");
require("common.php");
require("header.php");


if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}


if (array_key_exists("pageNumber", $_REQUEST)) {
$pageNumber = $_REQUEST[pageNumber];
} else {
$pageNumber = 1;
}

$results_per_page = 40;

if ($pageNumber == "") {
$offset = "0";
} else {
$offset = ($pageNumber * $results_per_page) - $results_per_page;
}



$rs_find_cart_items = "(SELECT DISTINCT(receipts.receipt_id),receipts.person_name,receipts.grandtotal,receipts.date_sold FROM receipts, pc_wo, pc_owner
WHERE pc_owner.pcgroupid = '$portalgroupid' AND pc_owner.pcid = pc_wo.pcid AND (pc_wo.woid = receipts.woid OR receipts.woid LIKE CONCAT('%\_',pc_wo.woid,'\_%')))
UNION (SELECT DISTINCT(receipts.receipt_id),receipts.person_name,receipts.grandtotal,receipts.date_sold FROM receipts, invoices
WHERE invoices.pcgroupid = '$portalgroupid' AND receipts.receipt_id = invoices.receipt_id)
UNION (SELECT DISTINCT(receipts.receipt_id),receipts.person_name,receipts.grandtotal,receipts.date_sold FROM receipts, invoices, rinvoices 
WHERE invoices.rinvoice_id = rinvoices.rinvoice_id AND rinvoices.pcgroupid = '$portalgroupid' 
AND (invoices.invoice_id = receipts.invoice_id OR invoices.invoice_id LIKE CONCAT('%\_',receipts.invoice_id,'\_%')))

UNION (SELECT DISTINCT(receipts.receipt_id),receipts.person_name,receipts.grandtotal,receipts.date_sold FROM receipts, invoices, blockcontract, blockcontracthours
WHERE blockcontracthours.invoiceid = invoices.invoice_id
AND blockcontract.pcgroupid = '$portalgroupid' AND blockcontract.blockid = blockcontracthours.blockcontractid
AND (invoices.invoice_id = receipts.invoice_id OR invoices.invoice_id LIKE CONCAT('%\_',receipts.invoice_id,'\_%')))


ORDER BY date_sold DESC LIMIT $offset,$results_per_page";


$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);


echo "<h3>".pcrtlang("Browse Receipts")."</h3>";

#echo "<div class=\"table-responsive\">";
echo "<table id=receipttable class=\"table table-striped\">";



echo "<thead><tr><th><strong>".pcrtlang("Receipt Number")."</strong></th><th>".pcrtlang("Date")."</th><th>".pcrtlang("Sold To")."</th>";
echo "<th>".pcrtlang("Total")."</th><th>".pcrtlang("Actions")."</th></tr></thead><tbody>";

$receipt_ids = array();

while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_receipt_id = "$rs_result_q->receipt_id";
$receipt_ids[] = $rs_receipt_id;

$addit_ids = findreturnreceipts($rs_receipt_id);
$receipt_ids = array_merge($receipt_ids, $addit_ids);

}

$totalentry = count($receipt_ids);

foreach($receipt_ids as $key => $receipt) {
$rs_find_cart_items = "SELECT * FROM receipts WHERE receipt_id = '$receipt'";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);
while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_receipt_id = "$rs_result_q->receipt_id";
$rs_name = "$rs_result_q->person_name";
$rs_gt2 = "$rs_result_q->grandtotal";
$rs_gt = number_format($rs_gt2, 2, '.', '');
$rs_date = "$rs_result_q->date_sold";

echo "<tr><td><strong>#$rs_receipt_id</strong></td>";
$rs_date2 = date("n-j-y, g:i a", strtotime($rs_date));
echo "<td><font class=text12>$rs_date2</font></td>";
echo "<td><font class=text12b>$rs_name</font></td>";
if ($rs_gt < 0) {
echo "<td><font class=textred12b>$money$rs_gt</font></td>";
} else {
echo "<td><font class=text12b>$money$rs_gt</font></td>";
}
echo "<td><a href=receipt.php?func=printreceipt&receipt=$rs_receipt_id><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Print Receipt")."</a></td>";
echo "</tr>";

}
}

echo "</tbody></table>";
#echo "</div>";

echo "<br>";

echo "<center>";
#browse here
$prevpage = $pageNumber - 1;
$nextpage = $pageNumber + 1;

if ($pageNumber > 1) {
echo "<a href=receipt.php?func=browsereceipts&pageNumber=$prevpage class=\"btn btn-default\" role=button><i class=\"fa fa-chevron-left fa-lg\"></i></a>";
}

$total_results = $totalentry;
$results_per_page = $results_per_page;
$html = get_paged_nav($total_results, $results_per_page, false);
echo "$html";

if (($totalentry / $results_per_page) > $pageNumber) {
echo "<a href=group.php?func=browsereceipts&pageNumber=$nextpage class=\"btn btn-default\" role=button><i class=\"fa fa-chevron-right fa-lg\"></i></a>";
}

echo "</center><br><br>";


require("footer.php");

?>
<script>
$(document).ready(function () {
    $('#receipttable').resTables();
});
</script>

<?php



}




function printreceipt() {
require_once("validate.php");

include("deps.php");
include("common.php");

if (!array_key_exists('receipt', $_REQUEST)) {
die(pcrtlang("Error: no receipts selected for printing."));
}



if (array_key_exists('receiptsnarrow', $_REQUEST)) {
$receiptsnarrow = $_REQUEST['receiptsnarrow'];
} else {
$receiptsnarrow = "0";
}




$narrow = $receiptsnarrow;

$receipts = $_REQUEST['receipt'];


if(!is_array($receipts)) {
$receiptarray = array("$receipts");
} else {
$receiptarray = $receipts;
}



?>
<!DOCTYPE html>

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php


if(!is_array($receipts)) {
echo "<title>".pcrtlang("Receipt")." $receipts</title>";
} else {
echo "<title>".pcrtlang("Print Receipts")."</title>";
}

echo "<style type=\"text/css\">\n<!--\n";

include("printstyle.css");

echo "\n-->\n</style>\n";

echo "<link rel=\"stylesheet\" href=\"fa/css/font-awesome.min.css\">";



echo "</head>";

if($autoprint == 1) {
echo "<body class=printpagebg onLoad=\"window.print()\">";
} else {
echo "<body class=printpagebg>";
}



if (count($receiptarray) > 1) {
echo "<div class=printbar>";
echo "<button onClick=\"window.history.back()\" class=bigbutton><i class=\"fa fa-reply\"></i> ".pcrtlang("Return")."</button>";
echo "<font class=text30b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>";
echo "<button onClick=\"print();\" class=bigbutton><i class=\"fa fa-print\"></i> ".pcrtlang("Print")."</button>";
echo "</div>";
}

foreach($receiptarray as $key => $receipt) {

#perm check

$rs_receipt_permq = "(SELECT DISTINCT(receipts.receipt_id)
FROM receipts, pc_wo, pc_owner WHERE pc_owner.pcgroupid = '$portalgroupid' AND pc_owner.pcid = pc_wo.pcid
AND (pc_wo.woid = receipts.woid OR receipts.woid LIKE CONCAT('%\_',pc_wo.woid,'\_%')))
UNION (SELECT DISTINCT(receipts.receipt_id) FROM receipts, invoices
WHERE invoices.pcgroupid = '$portalgroupid' AND receipts.receipt_id = invoices.receipt_id)
UNION (SELECT DISTINCT(receipts.receipt_id) FROM receipts, invoices, rinvoices
WHERE invoices.rinvoice_id = rinvoices.rinvoice_id AND rinvoices.pcgroupid = '$portalgroupid'
AND (invoices.invoice_id = receipts.invoice_id OR invoices.invoice_id LIKE CONCAT('%\_',receipts.invoice_id,'\_%')))

UNION (SELECT DISTINCT(receipts.receipt_id) FROM receipts, invoices, blockcontract, blockcontracthours
WHERE blockcontracthours.invoiceid = invoices.invoice_id
AND blockcontract.pcgroupid = '$portalgroupid' AND blockcontract.blockid = blockcontracthours.blockcontractid
AND (invoices.invoice_id = receipts.invoice_id OR invoices.invoice_id LIKE CONCAT('%\_',receipts.invoice_id,'\_%')))";




$rs_receipt_perm = mysqli_query($rs_connect, $rs_receipt_permq);
while ($rs_result_perm = mysqli_fetch_object($rs_receipt_perm)) {
$receiptadd = "$rs_result_perm->receipt_id";
$receiptcheck[] = "$receiptadd";

$addit_ids = findreturnreceipts($receiptadd);
$receiptcheck = array_merge($receiptcheck, $addit_ids);

}

if(!in_array("$receipt", $receiptcheck)) {
echo pcrtlang("Access Denied");
break 1;
}

$rs_find_name = "SELECT * FROM receipts WHERE receipt_id = '$receipt'";
$rs_result_name = mysqli_query($rs_connect, $rs_find_name);

if(mysqli_num_rows($rs_result_name) == 0) {
continue;
}


$rs_result_name_q = mysqli_fetch_object($rs_result_name);
$rs_soldto = "$rs_result_name_q->person_name";
$rs_company = "$rs_result_name_q->company";
$rs_ad1 = "$rs_result_name_q->address1";
$rs_ad2 = "$rs_result_name_q->address2";
$rs_ph = "$rs_result_name_q->phone_number";
$rs_cn = "$rs_result_name_q->check_number";
$rs_ccn = "$rs_result_name_q->ccnumber";
$rs_datesold = "$rs_result_name_q->date_sold";
$rs_pw = "$rs_result_name_q->paywith";
$rs_byuser = "$rs_result_name_q->byuser";
$rs_city = "$rs_result_name_q->city";
$rs_state = "$rs_result_name_q->state";
$rs_zip = "$rs_result_name_q->zip";
$rs_email = "$rs_result_name_q->email";
$rs_woid = "$rs_result_name_q->woid";
$rs_storeid = "$rs_result_name_q->storeid";
$thesig = "$rs_result_name_q->thesig";
$showsigrec = "$rs_result_name_q->showsigrec";
$thesigtopaz = "$rs_result_name_q->thesigtopaz";
$showsigrectopaz = "$rs_result_name_q->showsigrectopaz";


$rs_soldto_ue = urlencode($rs_soldto);
$rs_company_ue = urlencode($rs_company);
$rs_ad1_ue = urlencode($rs_ad1);
$rs_ad2_ue = urlencode($rs_ad2);
$rs_city_ue = urlencode($rs_city);
$rs_state_ue = urlencode($rs_state);
$rs_zip_ue = urlencode($rs_zip);


if (count($receiptarray) == 1) {
echo "<div class=printbar>";
echo "<button onClick=\"window.history.back()\" class=bigbutton><i class=\"fa fa-reply\"></i> ".pcrtlang("Return")."</button>";
echo "<font class=text30b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>";
echo "<button onClick=\"print();\" class=bigbutton><i class=\"fa fa-print\"></i> ".pcrtlang("Print")."</button>";
echo "</div>";
}


if(!$narrow) {
echo "<div class=printpage>";
} else {
echo "<div class=printpage80>";
}


if(!$narrow) {

echo "<table style=\"width:100%\"><tr><td width=55%>";

$storeinfoarray = getstoreinfo($rs_storeid);

echo "<img src=$printablelogo><br><font class=text12bi>$servicebyline</font><br><br><font class=text12b>";
echo "$storeinfoarray[storename]</font><font class=text12><br>$storeinfoarray[storeaddy1]";
if ("$storeinfoarray[storeaddy2]" != "") {
echo "<br>$storeinfoarray[storeaddy2]";
}
echo "<br>$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]";
echo "</font><br><br><font class=text12>".pcrtlang("Phone").": $storeinfoarray[storephone]</font><br><br>";


if ("$rs_company" != "") {
$rs_soldto2 = "$rs_company";
} else {
$rs_soldto2 = "$rs_soldto";
}

echo "<table cellpadding=3 cellspacing=0 border=0><tr><td valign=top><font class=text12b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></td><td><font class=text12>$rs_soldto2<br>$rs_ad1";
if ($rs_ad2 != "") {
echo "<br>$rs_ad2";
}

echo "<br>";
if ($rs_city != "") {
echo "$rs_city,";
}
echo " $rs_state $rs_zip</font><br>";

if ($rs_email != "") {
echo "<br><br><a href=\"receipt.php?func=email_receipt&receipt=$receipt&depemail=$rs_email\">".pcrtlang("Email").": $rs_email</a>";
}

echo "</td></tr></table>";


echo "</font><br></td><td align=right width=45% valign=top>";
echo "<font class=textidnumber>".pcrtlang("RECEIPT")." #$receipt<br></font>";

                                                                                                                             
$rs_datesold2 = pcrtdate("$pcrt_longdate", "$rs_datesold").", ".pcrtdate("$pcrt_time", "$rs_datesold");
                                                                                                                             
echo "<br><font class=text12b>".pcrtlang("Sale Date").":</font><font class=textgray12> $rs_datesold2</font>";


$rs_find_inv = "SELECT * FROM invoices WHERE receipt_id = '$receipt'";
$rs_result_inv = mysqli_query($rs_connect, $rs_find_inv);

if(mysqli_num_rows($rs_result_inv) > 0) {
echo "<br><font class=text12b>".pcrtlang("Paid Invoice")."</font>";


while($rs_result_qinv = mysqli_fetch_object($rs_result_inv)) {
$rs_invoice_id = "$rs_result_qinv->invoice_id";
echo " <font class=textgray12>#$rs_invoice_id</font>";
}
}

if ($rs_woid != "") {
echo "<br><font class=text12b>".pcrtlang("Work Order")."</font> ";
$rs_woids = explode_list($rs_woid);
foreach($rs_woids as $key => $rs_woidids) {
echo "<font class=textgray12>#$rs_woidids</font> ";
}
}


if ($rs_byuser != "") {
echo "<br><font class=text12b>".pcrtlang("Sold by").":</font><font class=textgray12> $rs_byuser</font>";
}



echo "<br><br><span class=paidstamp style=\"display:inline-block;\">".pcrtlang("PAID")."</span>";

echo "</td></tr></table>";

} else {
#narrow
echo "<center>";
echo "<font class=text12b>".pcrtlang("RECEIPT")." #$receipt<br><br></font>";

$rs_datesold2 = pcrtdate("$pcrt_longdate", "$rs_datesold").", ".pcrtdate("$pcrt_time", "$rs_datesold");
echo "<font class=text12>$rs_datesold2</font><br><br>";


$storeinfoarray = getstoreinfo($rs_storeid);

echo "<img src=$printablelogo width=200><br><font class=text10i>$servicebyline</font><br><br><font class=text12b>";
echo "$storeinfoarray[storename]</font><font class=text12><br>$storeinfoarray[storeaddy1]";
if ("$storeinfoarray[storeaddy2]" != "") {
echo "<br>$storeinfoarray[storeaddy2]";
}
echo "<br>$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]";
echo "</font><br><br><font class=text12>".pcrtlang("Phone").": $storeinfoarray[storephone]</font><br><br>";



if ("$rs_company" != "") {
$rs_soldto2 = "$rs_company";
} else {
$rs_soldto2 = "$rs_soldto";
}

echo "<font class=text12>$rs_soldto2<br>$rs_ad1";
if ($rs_ad2 != "") {
echo "<br>$rs_ad2";
}

echo "<br>";
if ($rs_city != "") {
echo "$rs_city,";
}
echo "$rs_state $rs_zip</font><br>";

if ($rs_email != "") {
echo "<a href=\"receipt.php?func=email_receipt&receipt=$receipt&depemail=$rs_email\" class=smalllink>".pcrtlang("Email").": $rs_email</a><br><br>";
}

echo "</center>";

#narrow end
}


$mastertaxtotals = array();

if(!$narrow) {
echo "<table class=printables>";
} else {
echo "<table class=printablesrp>";
}

$rs_find_cart_items = "SELECT * FROM sold_items WHERE sold_type = 'purchase' AND receipt = '$receipt' ORDER BY addtime ASC";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

if (mysqli_num_rows($rs_result) != 0) {
if(!$narrow) {
echo "<tr><th colspan=5>".pcrtlang("Purchase Items")."</th></tr>";
echo "<tr><td width=5% class=subhead>".pcrtlang("Qty")."</td><td width=50% class=subhead>".pcrtlang("Name of Product")."</td>";
echo "<td width=15% align=right class=subhead>".pcrtlang("Unit Price")."</td>";
echo "<td width=15% align=right class=subhead>".pcrtlang("Total Price")."</td>";
echo "<td width=15% align=right class=subhead>".pcrtlang("Tax")."</td></tr>";



} else {
echo "<tr><th colspan=5>".pcrtlang("Purchase Items")."</th></tr>";
echo "<tr><td width=5% class=subhead>".pcrtlang("Qty")."</td><td width=50% class=subhead>".pcrtlang("Product Name")."</td>";
echo "<td width=15% align=right class=subhead>".pcrtlang("Item Price")."</td>";
echo "<td width=30% align=right colspan=2 class=subhead>".pcrtlang("Total Price")."</td></tr>";
}
}

while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_cart_item_id = "$rs_result_q->sold_id";
$rs_cart_price = "$rs_result_q->sold_price";
$rs_stock_id = "$rs_result_q->stockid";
$rs_return_flag = "$rs_result_q->return_flag";
$rs_return_receipt = "$rs_result_q->return_receipt";
$rs_labordesc = "$rs_result_q->labor_desc";
$rs_printdesc = "$rs_result_q->printdesc";
$origprice = "$rs_result_q->origprice";
$itemtax = "$rs_result_q->itemtax";
$taxex = "$rs_result_q->taxex";
$discounttype = "$rs_result_q->discounttype";
$price_alt = "$rs_result_q->price_alt";
$itemserial = "$rs_result_q->itemserial";
$unit_price = "$rs_result_q->unit_price";
$quantity = "$rs_result_q->quantity";

$unit_tax = $itemtax / $quantity;

if ($rs_stock_id != "0") {
$rs_find_item_detail = "SELECT * FROM stock WHERE stock_id = '$rs_stock_id'";
$rs_find_result = mysqli_query($rs_connect, $rs_find_item_detail);
$rs_stocktitlea = mysqli_fetch_object($rs_find_result);
$rs_stocktitle = "$rs_stocktitlea->stock_title";
$rs_stockpdesc = "$rs_stocktitlea->stock_pdesc";
} else {
$rs_stocktitle = "$rs_labordesc";
$rs_stockpdesc = "$rs_printdesc";
}


#newtaxcode
$salestaxrate = getsalestaxrate($taxex);
$isgrouprate = isgrouprate($taxex);

if($isgrouprate == 0) {
$lineitemtax[$taxex] = $itemtax;

if(!array_key_exists("$taxex", $mastertaxtotals)) {
$mastertaxtotals[$taxex]['parts'] = $salestaxrate * $rs_cart_price;
$mastertaxtotals[$taxex]['labor'] = 0;
$mastertaxtotals[$taxex]['return'] = 0;
$mastertaxtotals[$taxex]['refundlabor'] = 0;
} else {
$mastertaxtotals[$taxex]['parts'] = ($salestaxrate * $rs_cart_price) + $mastertaxtotals[$taxex]['parts'];
}
} else {
$grouprates = getgrouprates($taxex);

foreach($grouprates as $key => $val) {
$salestaxratei = getsalestaxrate($val);

$lineitemtax[$val] = $salestaxratei * $rs_cart_price;

if(!array_key_exists("$val", $mastertaxtotals)) {
$mastertaxtotals[$val]['parts'] = $salestaxratei * $rs_cart_price;
$mastertaxtotals[$val]['labor'] = 0;
$mastertaxtotals[$val]['return'] = 0;
$mastertaxtotals[$val]['refundlabor'] = 0;
} else {
$mastertaxtotals[$val]['parts'] = ($salestaxratei * $rs_cart_price) + $mastertaxtotals[$val]['parts'];
}

}
}
####

if(!$narrow) {
echo "<tr><td width=5%><font class=text12b>".qf("$quantity")."</font>";
echo "</td><td width=50%><font class=text12b>$rs_stocktitle</font>";
if($rs_stockpdesc != "") {
echo "<br><br><div class=leftindent>".nl2br("$rs_stockpdesc")."</div>";
}
} else {
echo "<tr><td width=5%><font class=text10b>".qf("$quantity")."</font>";
echo "</td><td width=50%><font class=text10b>$rs_stocktitle</font>";
if($rs_stockpdesc != "") {
echo "<br><br><div class=\"sizemesmaller boldme leftindent\">".nl2br("$rs_stockpdesc")."</div>";
}
}


if ($itemserial != "") {
echo "<br><font class=text10b>".pcrtlang("Serial/Code").":</font> <font class=text10>$itemserial</font>";
}

if (($price_alt == 1) && ($origprice > $rs_cart_price)) {
echo "<br>";
$disc = explode('|',"$discounttype");
if("$disc[0]" == "percent") {
echo "<font class=text10i>&nbsp;&nbsp;$disc[1]"."% ".pcrtlang("discount applied")."</font>";
} elseif("$disc[0]" == "custom") {
echo "<font class=text10i>&nbsp;&nbsp;".pcrtlang("discount applied")."</font>";
} else {

}
}


##
$rs_find_return_total = "SELECT SUM(quantity) AS returnedqtotal FROM sold_items WHERE return_sold_id = '$rs_cart_item_id'";
$rs_find_return_totalq= mysqli_query($rs_connect, $rs_find_return_total);
$rs_return_result_total = mysqli_fetch_object($rs_find_return_totalq);
$returned_quantity_total = "$rs_return_result_total->returnedqtotal";

$quantityleftcount = tnv($quantity) - tnv($returned_quantity_total);

if ($rs_return_receipt != "") {
$rs_find_return_entry = "SELECT * FROM sold_items WHERE return_sold_id = '$rs_cart_item_id'";
$rs_find_return_result = mysqli_query($rs_connect, $rs_find_return_entry);
while($rs_return_result = mysqli_fetch_object($rs_find_return_result)) {
$returned_quantity = "$rs_return_result->quantity";
$returned_receipt = "$rs_return_result->receipt";
echo "<br><span class=text10i>(".qf("$returned_quantity").") ".pcrtlang("Returned on Receipt")." #$returned_receipt</span>";
}
if($quantityleftcount > 0) {
echo "<br><span class=text10i>(".qf($quantityleftcount).") ".pcrtlang("Remaining")."</span>";
}
}
###

$rs_cart_price_total = $rs_cart_price;

$rs_tax_total = $itemtax;

if(!$narrow) {
echo "</td><td width=15% align=right><font class=text12>$money".limf("$unit_price","$unit_tax")."</font>";
} else {
echo "</td><td width=15% align=right><font class=text10>$money".limf("$unit_price","$unit_tax")."</font>";
}


if (($price_alt == 1) && ($origprice > $rs_cart_price)) {
$origunitpricetax = $origprice * getsalestaxrate($taxex);
echo "<br><font class=text10i>".pcrtlang("was")." $money".limf("$origprice","$origunitpricetax")."</font>";
}

if(!$narrow) {
echo "</td><td width=15% align=right><font class=text12b>$money".limf("$rs_cart_price_total","$itemtax")."</font></td><td width=15% align=right>";
} else {
echo "</td><td width=30% align=right colspan=2><font class=text10b>$money".limf("$rs_cart_price_total","$itemtax")."</font>";
}


reset($lineitemtax);
foreach($lineitemtax as $key => $val) {
$shortname = gettaxshortname($key);
if($val != 0) {
if(!$narrow) {
echo "<font class=text10i>$shortname: $money".mf("$val")."</font><br>";
} else {
echo "<br><font class=text10i>$shortname $money".mf("$val")."</font>";
}
}
}

unset($lineitemtax);



echo "</td></tr>";

}



$rs_find_cart_labor = "SELECT * FROM sold_items WHERE sold_type = 'labor' AND receipt = '$receipt' ORDER BY addtime ASC";
$rs_result_labor = mysqli_query($rs_connect, $rs_find_cart_labor);

if (mysqli_num_rows($rs_result_labor) != 0) {
if(!$narrow) {
echo "<tr><td width=100% colspan=5>&nbsp;</td></tr>";
echo "<tr><th colspan=5>".pcrtlang("Labor")."</th></tr>";
echo "<tr><td width=5% class=subhead>".pcrtlang("Qty")."</td><td width=50% class=subhead>".pcrtlang("Labor Description")."</td>";
echo "<td width=15% class=subhead>".pcrtlang("Unit Price")."</td><td width=15% align=right class=subhead>".pcrtlang("Price")."</td>";
echo "<td width=15% align=right class=subhead>".pcrtlang("Tax")."</td>";
echo "</tr>";
} else {
echo "<tr><td width=100% colspan=5>&nbsp;</td></tr>";
echo "<tr><th colspan=5>".pcrtlang("Labor")."</th></tr>";
echo "<tr><td width=5% class=subhead>&nbsp;</td><td width=50% class=subhead>".pcrtlang("Labor Description")."</td>";
echo "<td width=15% class=subhead>&nbsp;</td><td width=30% align=right class=subhead colspan=2>".pcrtlang("Price")."</td>";
echo "</tr>";
}
}

                                                                                                                                               
while($rs_result_labor_q = mysqli_fetch_object($rs_result_labor)) {
$rs_cart_labor_id = "$rs_result_labor_q->sold_id";
$rs_cart_labor_price = "$rs_result_labor_q->sold_price";
$rs_cart_labor_desc = "$rs_result_labor_q->labor_desc";
$rs_cart_printdesc = "$rs_result_labor_q->printdesc";
$lorigprice = "$rs_result_labor_q->origprice";
$ldiscounttype = "$rs_result_labor_q->discounttype";
$lprice_alt = "$rs_result_labor_q->price_alt";
$rs_cart_labor_return_receipt = "$rs_result_labor_q->return_receipt";
$ltaxex = "$rs_result_labor_q->taxex";
$litemtax = "$rs_result_labor_q->itemtax";
$lunit_price = "$rs_result_labor_q->unit_price";
$lquantity = "$rs_result_labor_q->quantity";
$lunit_tax = $litemtax / $lquantity;

#newtaxcode
$servicetaxrate = getservicetaxrate($ltaxex);
$isgrouprate = isgrouprate($ltaxex);

if($isgrouprate == 0) {
$laboritemtax[$ltaxex] = $litemtax;

if(!array_key_exists("$ltaxex", $mastertaxtotals)) {
$mastertaxtotals[$ltaxex]['parts'] = 0;
$mastertaxtotals[$ltaxex]['labor'] = $servicetaxrate * $rs_cart_labor_price;
$mastertaxtotals[$ltaxex]['return'] = 0;
$mastertaxtotals[$ltaxex]['refundlabor'] = 0;
} else {
$mastertaxtotals[$ltaxex]['labor'] = ($servicetaxrate * $rs_cart_labor_price) + $mastertaxtotals[$ltaxex]['labor'];
}
} else {
$grouprates = getgrouprates($ltaxex);
foreach($grouprates as $key => $val) {
$servicetaxratei = getservicetaxrate($val);

$laboritemtax[$val] = $servicetaxratei * $rs_cart_labor_price;

if(!array_key_exists("$val", $mastertaxtotals)) {
$mastertaxtotals[$val]['parts'] = 0;
$mastertaxtotals[$val]['labor'] = $servicetaxratei * $rs_cart_labor_price;
$mastertaxtotals[$val]['return'] = 0;
$mastertaxtotals[$val]['refundlabor'] = 0;
} else {
$mastertaxtotals[$val]['labor'] = ($servicetaxratei * $rs_cart_labor_price) + $mastertaxtotals[$val]['labor'];
}

}
}
####

if(!$narrow) {
echo "<tr><td width=5%>".qf("$lquantity")."</td><td width=50%><font class=text12b>$rs_cart_labor_desc</font>";
if($rs_cart_printdesc != "") {
echo "<br><br><div class=leftindent>".nl2br("$rs_cart_printdesc")."</div>";
}
} else {
echo "<tr><td width=5%>&nbsp;</td><td width=50%><font class=text10b>$rs_cart_labor_desc</font>";
if($rs_printdesc != "") {
echo "<br><br><div class=\"sizemesmaller boldme leftindent\">".nl2br("$rs_cart_printdesc")."</div>";
}
}


if (($lprice_alt == 1) && ($lorigprice > $rs_cart_labor_price)) {
echo "<br>";
$ldisc = explode('|',"$ldiscounttype");
if("$ldisc[0]" == "percent") {
echo "<font class=text10i>&nbsp;&nbsp;$ldisc[1]"."% ".pcrtlang("discount applied")."</font>";
} elseif("$ldisc[0]" == "custom") {
echo "<font class=text10i>&nbsp;&nbsp;".pcrtlang("discount applied")."</i></font>";
} else {

}
}

####

$rs_find_labor_return_total = "SELECT SUM(quantity) AS returnedqtotal FROM sold_items WHERE return_sold_id = '$rs_cart_labor_id'";
$rs_find_labor_return_totalq= mysqli_query($rs_connect, $rs_find_labor_return_total);
$rs_labor_return_result_total = mysqli_fetch_object($rs_find_labor_return_totalq);
$returned_labor_quantity_total = "$rs_labor_return_result_total->returnedqtotal";

$laborquantityleftcount = tnv($lquantity) - tnv($returned_labor_quantity_total);

if ($rs_cart_labor_return_receipt != "") {
$rs_find_laborreturn_entry = "SELECT * FROM sold_items WHERE return_sold_id = '$rs_cart_labor_id'";
$rs_find_laborreturn_result = mysqli_query($rs_connect, $rs_find_laborreturn_entry);
while($rs_laborreturn_result = mysqli_fetch_object($rs_find_laborreturn_result)) {
$laborreturned_quantity = "$rs_laborreturn_result->quantity";
$laborreturned_receipt = "$rs_laborreturn_result->receipt";
echo "<br><span class=\"text10i\">(".qf("$laborreturned_quantity").") ".pcrtlang("Returned on Receipt")." #$laborreturned_receipt</span>";
}
if($laborquantityleftcount > 0) {
echo "<br><span class=\"text10i\">(".qf("$laborquantityleftcount").") ".pcrtlang("Remaining")."</span>";
}
}


####


if(!$narrow) {
echo "</td><td width=15% align=right>$money".limf("$lunit_price","$lunit_tax")."</td><td width=15% align=right><font class=text12b>$money".limf("$rs_cart_labor_price","$litemtax")."</font>";
} else {
echo "</td><td width=15% align=right>&nbsp;</td><td width=30% align=right colspan=2><font class=text10b>$money".limf("$rs_cart_labor_price","$litemtax")."</font>";
}


if (($lprice_alt == 1) && ($lorigprice > $rs_cart_labor_price)) {
$lorigunitpricetax = $lorigprice * getservicetaxrate($ltaxex);
echo "<br><font class=text10i>".pcrtlang("was")." $money".limf("$lorigprice","$lorigunitpricetax")."</font>";
}

if(!$narrow) {
echo "</td><td width=15% align=right>";
}

reset($laboritemtax);
foreach($laboritemtax as $key => $val) {
$shortname = gettaxshortname($key);
if($val != 0) {
if(!$narrow) {
echo "<font class=text10i>$shortname: $money".mf("$val")."</font><br>";
} else {
echo "<br><font class=text10i>$shortname: $money".mf("$val")."</font>";
}
}
}
unset($laboritemtax);




echo "</td></tr>";

}


                                                                                                                                               
$rs_find_cart_returns = "SELECT * FROM sold_items WHERE sold_type = 'refund' AND receipt = '$receipt' ORDER BY addtime ASC";
$rs_result_returns = mysqli_query($rs_connect, $rs_find_cart_returns);

if (mysqli_num_rows($rs_result_returns) != 0) {
if(!$narrow) {
echo "<tr><td width=100% colspan=5>&nbsp;</td></tr>";
echo "<tr><th colspan=5 width=100%>".pcrtlang("Returned Items")."</th></tr>";
echo "<tr><td width=5% class=subhead>".pcrtlang("Qty")."</td><td width=50% class=subhead>".pcrtlang("Name of Product")."</td><td width=15% class=subhead>".pcrtlang("Unit Price")."</td>";
echo "<td width=15% align=right class=subhead>".pcrtlang("Price")."</td>";
echo "<td width=15% align=right class=subhead>".pcrtlang("Tax")."</td></tr>";
} else {
echo "<tr><td width=100% colspan=5>&nbsp;</td></tr>";
echo "<tr><th colspan=5>".pcrtlang("Returned Items")."</th></tr>";
echo "<tr><td width=5% class=subhead>&nbsp;</td><td width=50% class=subhead>".pcrtlang("Name of Product")."</td><td width=15% class=subhead>&nbsp;</td>";
echo "<td width=30% align=right colspan=2 class=subhead>".pcrtlang("Price")."</td>";
echo "</tr>";

}
}

                                                                                                                                               
while($rs_result_returns_q = mysqli_fetch_object($rs_result_returns)) {
$rs_cart_return_id = "$rs_result_returns_q->sold_id";
$rs_cart_return_price = "$rs_result_returns_q->sold_price";
$rs_stock_return_id = "$rs_result_returns_q->stockid";
$rs_return_sold_id = "$rs_result_returns_q->return_sold_id";
$rs_return_labordesc = "$rs_result_returns_q->labor_desc";
$rtaxex = "$rs_result_returns_q->taxex";
$ritemtax = "$rs_result_returns_q->itemtax";
$runit_price = "$rs_result_returns_q->unit_price";
$rquantity = "$rs_result_returns_q->quantity";
$runit_tax = $ritemtax / $rquantity;

if ($rs_stock_return_id != "0") {
$rs_find_return_detail = "SELECT * FROM stock WHERE stock_id = '$rs_stock_return_id'";
$rs_find_return_result = mysqli_query($rs_connect, $rs_find_return_detail);
$rs_stocktitlear = mysqli_fetch_object($rs_find_return_result);
$rs_return_stocktitle = "$rs_stocktitlear->stock_title";
} else {
$rs_return_stocktitle = "$rs_return_labordesc";
}
                                                                                                                                               
#newtaxcode
$salestaxrate = getsalestaxrate($rtaxex);
$isgrouprate = isgrouprate($rtaxex);

if($isgrouprate == 0) {
$refunditemtax[$rtaxex] = $ritemtax;
if(!array_key_exists("$rtaxex", $mastertaxtotals)) {
$mastertaxtotals[$rtaxex]['parts'] = 0;
$mastertaxtotals[$rtaxex]['labor'] = 0;
$mastertaxtotals[$rtaxex]['return'] = $salestaxrate * $rs_cart_return_price;
$mastertaxtotals[$rtaxex]['refundlabor'] = 0;
} else {
$mastertaxtotals[$rtaxex]['return'] = ($salestaxrate * $rs_cart_return_price) + $mastertaxtotals[$rtaxex]['return'];
}
} else {
$grouprates = getgrouprates($rtaxex);
foreach($grouprates as $key => $val) {
$salestaxratei = getsalestaxrate($val);

$refunditemtax[$val] = $salestaxratei * $rs_cart_return_price;

if(!array_key_exists("$val", $mastertaxtotals)) {
$mastertaxtotals[$val]['parts'] = 0;
$mastertaxtotals[$val]['labor'] = 0;
$mastertaxtotals[$val]['return'] = $salestaxratei * $rs_cart_return_price;
$mastertaxtotals[$val]['refundlabor'] = 0;
} else {
$mastertaxtotals[$val]['return'] = ($salestaxratei * $rs_cart_return_price) + $mastertaxtotals[$val]['return'];
}

}
}
####                                                                                                                                               
                   
$rs_find_original = "SELECT * FROM sold_items WHERE sold_id = '$rs_return_sold_id'";
$rs_find_original_result = mysqli_query($rs_connect, $rs_find_original);
while($rs_find_original_return_q = mysqli_fetch_object($rs_find_original_result)) {
$rs_return_original = "$rs_find_original_return_q->receipt";

if(!$narrow) {
echo "<tr><td width=5%>".qf("$rquantity")."</td><td width=50%><font class=text12b>$rs_return_stocktitle</font><br><font class=textgreen12i>".pcrtlang("Sold on Receipt")."</font>";
echo " <a href=receipt.php?func=show_receipt&receipt=$rs_return_original>#$rs_return_original</a></td>";
echo "<td width=15%>$money".limf("$runit_price","$runit_tax")."</td><td width=15% align=right><font class=text12b>$money".limf("$rs_cart_return_price","$ritemtax")."</font></td><td width=15% align=right>";
} else {
echo "<tr><td width=5%>&nbsp;</td><td width=50%><strong>$rs_return_stocktitle</strong><br>".pcrtlang("Sold on Receipt");
echo " <a href=receipt.php?func=show_receipt&receipt=$rs_return_original>#$rs_return_original</a></td>";
echo "<td width=15%>&nbsp;</td><td width=30% align=right colspan=2>$money".limf("$rs_cart_return_price","$ritemtax");
}


reset($refunditemtax);
foreach($refunditemtax as $key => $val) {
$shortname = gettaxshortname($key);
if($val != 0) {
if(!$narrow) {
echo "<font class=text10i>$shortname: $money".mf("$val")."</font><br>";
} else {
echo "<br><font class=text10i>$shortname: $money".mf("$val")."</font>";
}
}
}
unset($refunditemtax);

echo "</td></tr>";

}
                                                                                                                                               
                                                                                                                                               
}


##### #
$rs_find_cart_refundlabor = "SELECT * FROM sold_items WHERE sold_type = 'refundlabor' AND receipt = '$receipt' ORDER BY addtime ASC";
$rs_result_refundlabor = mysqli_query($rs_connect, $rs_find_cart_refundlabor);

if (mysqli_num_rows($rs_result_refundlabor) != 0) {
if(!$narrow) {
echo "<tr><td width=100% colspan=5>&nbsp;</td></tr>";
echo "<tr><th colspan=5>".pcrtlang("Refunded Labor")."</th></tr>";
echo "<tr><td width=5% class=subhead>".pcrtlang("Qty")."</td><td width=50% class=subhead>".pcrtlang("Labor Description")."</td>";
echo "<td width=15% class=subhead>".pcrtlang("Unit Price")."</td><td width=15% align=right class=subhead>".pcrtlang("Price")."</td>";
echo "<td width=15% align=right class=subhead>".pcrtlang("Tax")."</td>";
echo "</tr>";
} else {
echo "<tr><td width=100% colspan=5>&nbsp;</td></tr>";
echo "<tr><th colspan=5 class=subhead>".pcrtlang("Refunded Labor")."</th></tr>";
echo "<tr><td width=5% class=subhead>&nbsp;</td><td width=50% class=subhead>".pcrtlang("Labor Description")."</td>";
echo "<td width=15% class=subhead>&nbsp;</td><td width=30% align=right class=subhead colspan=2>".pcrtlang("Price")."</td></tr>";
}
}
while($rs_result_refundlabor_q = mysqli_fetch_object($rs_result_refundlabor)) {
$rs_cart_refundlabor_id = "$rs_result_refundlabor_q->sold_id";
$rs_cart_refundlabor_price = "$rs_result_refundlabor_q->sold_price";
$rs_cart_refundlabor_desc = "$rs_result_refundlabor_q->labor_desc";
$rs_cart_refundlabor_sold_id = "$rs_result_refundlabor_q->return_sold_id";
$refundltaxex = "$rs_result_refundlabor_q->taxex";
$refundlitemtax = "$rs_result_refundlabor_q->itemtax";
$refundlaborunit_price = "$rs_result_refundlabor_q->unit_price";
$refundlaborquantity = "$rs_result_refundlabor_q->quantity";

$refundlunit_tax = $refundlitemtax / $refundlaborquantity;

#newtaxcode
$refundservicetaxrate = getservicetaxrate($refundltaxex);
$isgrouprate = isgrouprate($refundltaxex);
if($isgrouprate == 0) {
$refundlaboritemtax[$refundltaxex] = $refundlitemtax;

if(!array_key_exists("$refundltaxex", $mastertaxtotals)) {
$mastertaxtotals[$refundltaxex]['parts'] = 0;
$mastertaxtotals[$refundltaxex]['labor'] = 0;
$mastertaxtotals[$refundltaxex]['return'] = 0;
$mastertaxtotals[$refundltaxex]['refundlabor'] =  $refundservicetaxrate * $rs_cart_refundlabor_price;
} else {
$mastertaxtotals[$refundltaxex]['refundlabor'] = ($refundservicetaxrate * $rs_cart_refundlabor_price) + $mastertaxtotals[$refundltaxex]['refundlabor'];
}
} else {
$grouprates = getgrouprates($refundltaxex);
foreach($grouprates as $key => $val) {
$refundservicetaxratei = getservicetaxrate($val);

$refundlaboritemtax[$val] = $refundservicetaxratei * $rs_cart_refundlabor_price;

if(!array_key_exists("$val", $mastertaxtotals)) {
$mastertaxtotals[$val]['parts'] = 0;
$mastertaxtotals[$val]['labor'] = 0;
$mastertaxtotals[$val]['return'] = 0;
$mastertaxtotals[$val]['refundlabor'] = $refundservicetaxratei * $rs_cart_refundlabor_price;

} else {
$mastertaxtotals[$val]['refundlabor'] = ($refundservicetaxratei * $rs_cart_refundlabor_price) + $mastertaxtotals[$val]['refundlabor'];
}

}
}
####

$rs_find_original_rl = "SELECT * FROM sold_items WHERE sold_id = '$rs_cart_refundlabor_sold_id'";
$rs_find_original_result_rl = mysqli_query($rs_connect, $rs_find_original_rl);
$rs_find_original_return_rl_q = mysqli_fetch_object($rs_find_original_result_rl);
$rs_return_original_rl = "$rs_find_original_return_rl_q->receipt";



if(!$narrow) {
echo "<tr><td width=5%>".qf("$refundlaborquantity")."</td><td width=50%><font class=text12b>$rs_cart_refundlabor_desc</font><br><font class=textgreen12i>".pcrtlang("Billed on Receipt")."</font>";
echo " <a href=receipt.php?func=show_receipt&receipt=$rs_return_original_rl>#$rs_return_original_rl</a>";
} else {
echo "<tr><td width=5%>&nbsp;</td><td width=50%><font class=text10b>$rs_cart_refundlabor_desc</font><br><font class=text10i>".pcrtlang("Billed on Receipt")."</font>";
echo " <a href=receipt.php?func=show_receipt&receipt=$rs_return_original_rl>#$rs_return_original_rl</a>";
}

if(!$narrow) {
echo "</td><td width=15% align=right>$money".limf("$refundlaborunit_price","$refundlunit_tax")."</td><td width=15% align=right><font class=text12b>$money".limf("$rs_cart_refundlabor_price","$refundlitemtax")."</font>";
} else {
echo "</td><td width=15% align=right>&nbsp;</td><td width=30% align=right colspan=2><font class=text10b>$money".mf("$rs_cart_refundlabor_price","$refundlitemtax")."</font>";
}

if(!$narrow) {
echo "</td><td width=15% align=right>";
}

reset($refundlaboritemtax);
foreach($refundlaboritemtax as $key => $val) {
$shortname = gettaxshortname($key);
if($val != 0) {
if(!$narrow) {
echo "<font class=text10i>$shortname: $money".mf("$val")."</font><br>";
} else {
echo "<br><font class=text10i>$shortname: $money".mf("$val")."</font>";
}
}
}
unset($refundlaboritemtax);

echo "</td></tr>";

}


##### #





echo "<tr><td width=100% colspan=5>&nbsp;<br><br></td></tr>";

$rs_find_item_total = "SELECT SUM(sold_price) AS total_price_parts, SUM(itemtax) AS total_price_parts_tax FROM sold_items WHERE sold_type = 'purchase' AND receipt = '$receipt'";
$rs_find_result_total = mysqli_query($rs_connect, $rs_find_item_total);
                                                                                                                                               
while($rs_find_result_total_q = mysqli_fetch_object($rs_find_result_total)) {
$rs_total_parts = "$rs_find_result_total_q->total_price_parts";
$rs_total_parts_tax = "$rs_find_result_total_q->total_price_parts_tax";

if ($rs_total_parts == "") {
$rs_total_parts = "0.00";
$rs_total_parts_tax = "0.00";
}

if ($rs_total_parts > "0") {
if(!$narrow) {
echo "<tr><td width=5%>&nbsp;</td><td width=80% align=right colspan=3><font class=text12>".pcrtlang("Parts Subtotal").":</font></td>";
echo "<td width=15% align=right><font class=text12b>$money".limf("$rs_total_parts","$rs_total_parts_tax")."</font></td></tr>";
} else {
echo "<tr><td width=5%>&nbsp;</td><td width=80% align=right colspan=3><font class=text10>".pcrtlang("Parts Subtotal").":</font></td>";
echo "<td width=15% align=right><font class=text10b>$money".limf("$rs_total_parts","$rs_total_parts_tax")."</font></td></tr>";
}
}

$rs_find_itemtax_total = "SELECT SUM(itemtax) AS total_tax_parts FROM sold_items WHERE sold_type = 'purchase' AND receipt = '$receipt'";
$rs_find_result_taxtotal = mysqli_query($rs_connect, $rs_find_itemtax_total);
while($rs_find_result_taxtotal_q = mysqli_fetch_object($rs_find_result_taxtotal)) {
$rs_total_partstax = "$rs_find_result_taxtotal_q->total_tax_parts";

$salestax = $rs_total_partstax;



}
}
                                                                                                                                               
                                                                                                                                               

$rs_find_labor_total = "SELECT SUM(sold_price) AS total_labor_price, SUM(itemtax) AS total_labor_price_tax FROM sold_items WHERE sold_type = 'labor' AND receipt = '$receipt'";
$rs_find_result_labor_total = mysqli_query($rs_connect, $rs_find_labor_total);
                                                                                                            
                                   
while($rs_find_result_labor_total_q = mysqli_fetch_object($rs_find_result_labor_total)) {
$rs_total_labor = "$rs_find_result_labor_total_q->total_labor_price";
$rs_total_labor_tax = "$rs_find_result_labor_total_q->total_labor_price_tax";

if ($rs_total_labor == "") {
$rs_total_labor = "0.00";
$rs_total_labor_tax = "0.00";
}
                       
                                                                                                                        
if ($rs_total_labor > "0") {
if(!$narrow) {
echo "<tr><td width=5%>&nbsp;</td><td width=80% align=right colspan=3><font class=text12>".pcrtlang("Labor Total").":</font></td>";
echo "<td width=15% align=right><font class=text12b>$money".limf("$rs_total_labor","$rs_total_labor_tax")."</font></td></tr>";
} else {
echo "<tr><td width=5%>&nbsp;</td><td width=80% align=right colspan=3><font class=text10>".pcrtlang("Labor Total").":</font></td>";
echo "<td width=15% align=right><font class=text10b>$money".limf("$rs_total_labor","$rs_total_labor_tax")."</font></td></tr>";
}
}

$rs_find_labortax_total = "SELECT SUM(itemtax) AS total_labortax_price FROM sold_items WHERE sold_type = 'labor' AND receipt = '$receipt'";
$rs_find_result_taxlabor_total = mysqli_query($rs_connect, $rs_find_labortax_total);
while($rs_find_result_labortax_total_q = mysqli_fetch_object($rs_find_result_taxlabor_total)) {
$rs_total_labortax = "$rs_find_result_labortax_total_q->total_labortax_price";

$servicetax = $rs_total_labortax;

}
                                                                                                                                               
}

echo "<tr><td width=5%>&nbsp;</td><td width=80% align=right colspan=3>&nbsp;</td><td width=15%>&nbsp;</td></tr>";
                                                                                                                                               
$rs_find_refund_total = "SELECT SUM(sold_price) AS total_price_parts, SUM(itemtax) AS total_price_parts_tax FROM sold_items WHERE sold_type = 'refund' AND receipt = '$receipt'";
$rs_find_result_refund_total = mysqli_query($rs_connect, $rs_find_refund_total);
                                                                                                                                               
while($rs_find_result_refund_total_q = mysqli_fetch_object($rs_find_result_refund_total)) {
$rs_total_refund = "$rs_find_result_refund_total_q->total_price_parts";
$rs_total_refund_tax = "$rs_find_result_refund_total_q->total_price_parts_tax";
               
if ($rs_total_refund == "") {
$rs_total_refund = "0.00";
$rs_total_refund_tax = "0.00";
}

if ($rs_total_refund > "0") {                                                                                                                               
if (!$narrow) {
echo "<tr><td width=5%>&nbsp;</td><td width=80% align=right colspan=3><font class=text12>".pcrtlang("Refund Subtotal").":</font></td>";
echo "<td width=15% align=right><font class=text12b>$money".limf("$rs_total_refund","$rs_total_refund_tax")."</font>";
echo "</td></tr>";
} else {
echo "<tr><td width=5%>&nbsp;</td><td width=80% align=right colspan=3><font class=text10>".pcrtlang("Refund Subtotal").":</font></td>";
echo "<td width=15% align=right><font class=text10b>$money".limf("$rs_total_refund","$rs_total_refund_tax")."</font>";
echo "</td></tr>";

}
}

$rs_find_refund_totalref = "SELECT SUM(itemtax) AS total_price_partsref FROM sold_items WHERE sold_type = 'refund' AND receipt = '$receipt'";
$rs_find_result_refund_totalref = mysqli_query($rs_connect, $rs_find_refund_totalref);
while($rs_find_result_refund_totalref_q = mysqli_fetch_object($rs_find_result_refund_totalref)) {
$rs_total_refundtax = "$rs_find_result_refund_totalref_q->total_price_partsref";

$refundtax = $rs_total_refundtax;

}


}
                                                                                                                                               


# # #

$rs_find_refundlabor_total = "SELECT SUM(sold_price) AS total_refundlabor_price, SUM(itemtax) AS total_refundlabor_price_tax FROM sold_items WHERE sold_type = 'refundlabor' AND receipt = '$receipt'";
$rs_find_result_refundlabor_total = mysqli_query($rs_connect, $rs_find_refundlabor_total);


while($rs_find_result_refundlabor_total_q = mysqli_fetch_object($rs_find_result_refundlabor_total)) {
$rs_total_refundlabor = "$rs_find_result_refundlabor_total_q->total_refundlabor_price";
$rs_total_refundlabor_tax = "$rs_find_result_refundlabor_total_q->total_refundlabor_price_tax";

if ($rs_total_refundlabor == "") {
$rs_total_refundlabor = "0.00";
$rs_total_refundlabor_tax = "0.00";
}


if ($rs_total_refundlabor > "0") {
if(!$narrow) {
echo "<tr><td width=5%>&nbsp;</td><td width=80% align=right colspan=3><font class=text12>".pcrtlang("Refunded Labor Total").":</font></td>";
echo "<td width=15% align=right><font class=text12b>$money".limf("$rs_total_refundlabor","$rs_total_refundlabor_tax")."</font></td></tr>";
} else {
echo "<tr><td width=5%>&nbsp;</td><td width=80% align=right colspan=3><font class=text10>".pcrtlang("Refunded Labor Total").":</font></td>";
echo "<td width=15% align=right><font class=text10b>$money".limf("$rs_total_refundlabor","$rs_total_refundlabor_tax")."</font></td></tr>";
}
}

$rs_find_refundlabortax_total = "SELECT SUM(itemtax) AS total_refundlabortax_price FROM sold_items WHERE sold_type = 'refundlabor' AND receipt = '$receipt'";
$rs_find_result_refundtaxlabor_total = mysqli_query($rs_connect, $rs_find_refundlabortax_total);
while($rs_find_result_refundlabortax_total_q = mysqli_fetch_object($rs_find_result_refundtaxlabor_total)) {
$rs_total_refundlabortax = "$rs_find_result_refundlabortax_total_q->total_refundlabortax_price";

$refundservicetax = $rs_total_refundlabortax;

}

}

echo "<tr><td width=5%>&nbsp;</td><td width=80% align=right colspan=3>&nbsp;</td><td width=15%>&nbsp;</td></tr>";

# # #



$grand_total = (tnv($salestax) + tnv($rs_total_parts) + tnv($rs_total_labor) + tnv($servicetax)) - (tnv($refundtax) + tnv($rs_total_refund) + tnv($rs_total_refundlabor) + tnv($refundservicetax));

if (!isset($pcrt_showtax_total)) {
$pcrt_showtax_total = "short";
}

reset($mastertaxtotals);
foreach($mastertaxtotals as $key => $val) {
if($pcrt_showtax_total == "short") {
$taxname = gettaxshortname($key);
} else {
$taxname = gettaxname($key);
}


$taxtotal = ($mastertaxtotals[$key]['parts'] + $mastertaxtotals[$key]['labor']) - ($mastertaxtotals[$key]['return'] + $mastertaxtotals[$key]['refundlabor']);
if($taxtotal > 0) {
if(!$narrow) {
echo "<tr><td width=5%></td><td width=80% align=right colspan=3><font class=text10b>$taxname:</font></td>
<td width=15% align=right><font class=text12>$money".mf("$taxtotal")."</font></td></tr>";
} else {
echo "<tr><td width=5%></td><td width=80% align=right colspan=3><font class=text10b>$taxname:</font></td>
<td width=15% align=right><font class=text10>$money".mf("$taxtotal")."</font></td></tr>";
}
} elseif($taxtotal < 0) {
if(!$narrow) {
echo "<tr><td width=5%></td><td width=80% align=right colspan=3><font class=text10b>$taxname:</font></td>
<td width=15% align=right><font class=textred12>($money".mf("$taxtotal").")</font></td></tr>";
} else {
echo "<tr><td width=5%></td><td width=80% align=right colspan=3><font class=text10b>$taxname:</font></td>
<td width=15% align=right><font class=text10>($money".mf("$taxtotal").")</font></td></tr>";
}
} else {
}
}



echo "<tr><td width=5%>&nbsp;</td><td width=80% align=right colspan=2>&nbsp;</td><td width=15%>&nbsp;</td></tr>";

if ($grand_total >= 0){
if(!$narrow) {
echo "<tr><td width=5%></td><td width=80% align=right colspan=3><font class=text16b>".pcrtlang("Grand Total").":</font></td>";
echo "<td width=15% align=right><font class=text16b>$money".mf("$grand_total")."</font></td></tr>";
} else {
echo "<tr><td width=5%></td><td width=95% align=right colspan=4><font class=text12b>".pcrtlang("Grand Total").":</font> ";
echo "<font class=text12b>$money".mf("$grand_total")."</font></td></tr>";
}
} else {
$refund_total = abs($grand_total);
if(!$narrow) {
echo "<tr><td width=5%></td><td width=80% align=right colspan=3><font class=textred16b>".pcrtlang("Refund").":</font></td>";
echo "<td width=15% align=right><font class=textred16b>$money".mf("$refund_total")."</font></td></tr>";
} else {
echo "<tr><td width=5%></td><td width=80% align=right colspan=3><font class=text12b>".pcrtlang("Refund").":</font></td>";
echo "<td width=15% align=right><font class=text12b>$money".mf("$refund_total")."</font></td></tr>";
}
}


echo "</table>";


$findpayments = "SELECT * FROM savedpayments WHERE receipt_id = '$receipt'";
$findpaymentsq = @mysqli_query($rs_connect, $findpayments);
if (mysqli_num_rows($findpaymentsq) != 0) {
echo "<br><table><tr><td valign=top><strong>&nbsp;".pcrtlang("Payments").":</strong>&nbsp;</td></tr></table>";
echo "<table><tr>";
}

while ($findpaymentsa = mysqli_fetch_object($findpaymentsq)) {
$paymentamount = "$findpaymentsa->amount";
$pfirstname = "$findpaymentsa->pfirstname";
$pcompany = "$findpaymentsa->pcompany";
$paymenttype = "$findpaymentsa->paymenttype";
$paymentid = "$findpaymentsa->paymentid";
$paymentplugin = "$findpaymentsa->paymentplugin";
$checknumber = "$findpaymentsa->chk_number";
$ccnumber2 = "$findpaymentsa->cc_number";
$ccexpmonth = "$findpaymentsa->cc_expmonth";
$ccexpyear = "$findpaymentsa->cc_expyear";
$cc_transid = "$findpaymentsa->cc_transid";
$cc_cardtype = "$findpaymentsa->cc_cardtype";
$depositid = "$findpaymentsa->depositid";
$custompaymentinfo2 = "$findpaymentsa->custompaymentinfo";

$custompaymentinfo = unserialize("$custompaymentinfo2");

$cashchange = "$findpaymentsa->cashchange";


$ccnumber = substr("$ccnumber2", -4, 4);

if("$pcompany" != "") {
$pcompany2 = "$pcompany - ";
} else {
$pcompany2 = "";
}

if ($paymenttype == "cash") {
echo "<td valign=top style=\"padding:5px 30px 0px 5px;border: 2px solid #000000;border-radius:3px;\">";
echo "<i class=\"fa fa-money fa-lg\"></i><strong> ".pcrtlang("Cash")."</strong>&nbsp;<br><font class=\"text12\">$pfirstname - $pcompany2$money".mf("$paymentamount")."</font>";
if($cashchange != "") {
$cashchange2 = explode('|', $cashchange);
echo "<br><font class=text10>".pcrtlang("Change").": $money".mf("$cashchange2[0]")." ".pcrtlang("Tendered").": $money".mf("$cashchange2[1]")."</font>";
}
if($depositid != "0") {
echo "<br>".pcrtlang("Deposit").": $depositid";
}
echo "</td>";

} elseif ($paymenttype == "check") {
echo "<td valign=top style=\"padding:5px 30px 0px 5px;border: 2px solid #000000;border-radius:3px;\">";
echo "<i class=\"fa fa-list-alt fa-lg\"></i><strong> ".pcrtlang("Check")." #$checknumber</strong>&nbsp;<br>$pfirstname - $pcompany2";
echo "$money".mf("$paymentamount");
if($depositid != "0") {
echo "<br>".pcrtlang("Deposit").": $depositid";
}
echo "</td>";

} elseif ($paymenttype == "credit") {
echo "<td valign=top style=\"padding:5px 30px 0px 5px;border: 2px solid #000000;border-radius:3px;\">";
echo "<i class=\"fa fa-credit-card fa-lg\"></i><strong> ".pcrtlang("Credit Card")."</strong>&nbsp;<br>XXXX-$ccnumber<br>";
echo pcrtlang("TransID").": $cc_transid<br>$pfirstname - $pcompany2$money".mf("$paymentamount")."<br>$paymentplugin $cc_cardtype";
if($depositid != "0") {
echo "<br>".pcrtlang("Deposit").": $depositid";
}
echo "</td>";

} elseif ($paymenttype == "custompayment") {
echo "<td valign=top style=\"padding:5px 30px 0px 5px;border: 2px solid #000000;border-radius:3px;\">";
echo "<i class=\"fa fa-product-hunt fa-lg\"></i><strong> $paymentplugin</strong>&nbsp;<br>$pfirstname - $pcompany2$money".mf("$paymentamount")."<br>";

reset($custompaymentinfo);
foreach($custompaymentinfo as $key => $val) {
if(!in_array("$key", $CustomPaymentPrintExclude)) {
echo "<font class=\"text10\">$key: $val</font><br>";
}
}
if($depositid != "0") {
echo "<br>".pcrtlang("Deposit").": $depositid";
}
echo "</td>";

} else {
echo "<td colspan=2 style=\"padding:5px 30px 0px 5px;border: 2px solid #000000;border-radius:3px;\">Error! Undefined Payment Type in database</td>";
}

if($narrow) {
echo "</tr><tr>";
}

}

if (mysqli_num_rows($findpaymentsq) != 0) {
echo "</tr></table>";
}



echo nl2br($storeinfoarray['returnpolicy']);



if($narrow) {
echo "<br><br><br><br><font style=\"color:white;\">.</font>";
}


####


echo "</div>";




####










if (count($receiptarray) > 1) {
echo "\n\n<DIV style=\"page-break-after:always\"></DIV>\n\n";
}

}

echo "</body></html>";
                                                                                                    
}







##########



switch($func) {
                                                                                                    
    default:
    invoices();
    break;
                                
    case "printreceipt":
    printreceipt();
    break;

    case "browsereceipts":
    browsereceipts();
    break;


}

