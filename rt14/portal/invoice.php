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


function invoices() {

echo "Nothing to see here";

}



##########

function printinv() {
require_once("validate.php");
$invoice_ids = $_REQUEST['invoice_id'];

include("deps.php");
include("common.php");

if(!is_array($invoice_ids)) {
if (strpos($invoice_ids, '_') !== false) {
$invoicearray = array_filter(explode("_", "$invoice_ids"));
} else {
$invoicearray = array("$invoice_ids");
}
} else {
$invoicearray = $invoice_ids;
}


if (count($invoicearray) > 1) {
if (array_key_exists('returnurl', $_REQUEST)) {
$returnurl = $_REQUEST['returnurl'];
} else {
$returnurl = "invoice.php";
}
}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php

if (count($invoicearray) == 1) {
$iorqtitle = ucfirst(invoiceorquote($invoice_ids));
echo "<title>$iorqtitle $invoice_ids</title>";
} else {
echo "<title>".pcrtlang("Print Invoices")."</title>";
}


echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"printstyle.css\">";
echo "<link rel=\"stylesheet\" href=\"fa/css/font-awesome.min.css\">";
echo "</head>";

echo "<body class=printpagebg>";

if (count($invoicearray) > 1) {
echo "<div class=printbar>";
echo "<button onClick=\"window.history.back()\" class=bigbutton><img src=images/left.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Return")."</button>";
echo "<font class=text30b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>";
echo "<button onClick=\"print();\" class=bigbutton><img src=images/print.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Print")."</button>";
echo "</div>";
}


foreach($invoicearray as $key => $invoice_id) {


$rs_invoice_permq = "(SELECT DISTINCT(invoices.invoice_id) FROM invoices, pc_wo, pc_owner WHERE pc_owner.pcgroupid = '$portalgroupid' AND pc_owner.pcid = pc_wo.pcid
AND invoices.iorq != 'quote' AND (pc_wo.woid = invoices.woid OR invoices.woid LIKE CONCAT('%\_',pc_wo.woid,'\_%')))
UNION (SELECT invoices.invoice_id FROM invoices,rinvoices WHERE invoices.rinvoice_id = rinvoices.rinvoice_id AND rinvoices.pcgroupid = '$portalgroupid')
UNION (SELECT invoice_id FROM invoices WHERE pcgroupid = '$portalgroupid')
UNION (SELECT invoices.invoice_id 
FROM invoices,blockcontracthours,blockcontract WHERE blockcontracthours.invoiceid = invoices.invoice_id
AND blockcontract.pcgroupid = '$portalgroupid' AND blockcontract.blockid = blockcontracthours.blockcontractid)";

$rs_invoice_perm = mysqli_query($rs_connect, $rs_invoice_permq);
while ($rs_result_perm = mysqli_fetch_object($rs_invoice_perm)) {
$invoicecheck[] = "$rs_result_perm->invoice_id";
}

if(!in_array("$invoice_id", $invoicecheck)) {
break 1;
}




$mastertaxtotals = array();




$rs_find_name = "SELECT * FROM invoices WHERE invoice_id = '$invoice_id'";
$rs_result_name = mysqli_query($rs_connect, $rs_find_name);

if(mysqli_num_rows($rs_result_name) == 0) {
continue;
}

$rs_result_name_q = mysqli_fetch_object($rs_result_name);
$rs_soldto = "$rs_result_name_q->invname";
$rs_company = "$rs_result_name_q->invcompany";
$rs_ad1 = "$rs_result_name_q->invaddy1";
$rs_ad2 = "$rs_result_name_q->invaddy2";
$rs_city = "$rs_result_name_q->invcity";
$rs_state = "$rs_result_name_q->invstate";
$rs_zip = "$rs_result_name_q->invzip";
$rs_ph = "$rs_result_name_q->invphone";
$rs_datesold = "$rs_result_name_q->invdate";
$rs_woid = "$rs_result_name_q->woid";
$invnotes = "$rs_result_name_q->invnotes";
$rs_storeid = "$rs_result_name_q->storeid";
$preinvoice = "$rs_result_name_q->preinvoice";
$rs_email = "$rs_result_name_q->invemail";
$invstatus = "$rs_result_name_q->invstatus";
$thesig = "$rs_result_name_q->thesig";
$showsiginv = "$rs_result_name_q->showsiginv";
$thesigtopaz = "$rs_result_name_q->thesigtopaz";
$showsiginvtopaz = "$rs_result_name_q->showsiginvtopaz";


$iorq = invoiceorquote($invoice_id);

if (count($invoicearray) == 1) {
if (array_key_exists('returnurl', $_REQUEST)) {
$returnurl = $_REQUEST['returnurl'];
} else {
if ($iorq != 'quote') {
$returnurl = "invoice.php";
} else {
$returnurl = "invoice.php?func=browsequotes";
}
}
}

$rs_soldto_ue = urlencode($rs_soldto);
$rs_company_ue = urlencode($rs_company);
$rs_ad1_ue = urlencode($rs_ad1);
$rs_ad2_ue = urlencode($rs_ad2);
$rs_city_ue = urlencode($rs_city);
$rs_state_ue = urlencode($rs_state);
$rs_zip_ue = urlencode($rs_zip);
$rs_returnurl = urlencode($returnurl);


if (count($invoicearray) == 1) {
echo "<div class=printbar>";
echo "<button  onClick=\"window.history.back()\" class=bigbutton><i class=\"fa fa-reply\"></i> ".pcrtlang("Return")."</button>";
echo "<font class=text30b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>";
echo "<button onClick=\"print();\" class=bigbutton><i class=\"fa fa-print\"></i> ".pcrtlang("Print")."</button>";
echo "</div>";
}


echo "<div class=printpage>";
echo "<table width=100%><tr><td width=55%>";


$storeinfoarray = getstoreinfo($rs_storeid);

echo "<img src=$printablelogo><br><font class=text12bi>$servicebyline</font><br><br><font class=text12b>";
echo "$storeinfoarray[storename]</font><font class=text12><br>$storeinfoarray[storeaddy1]";
if ("$storeinfoarray[storeaddy2]" != "") {
echo "<br>$storeinfoarray[storeaddy2]";
}
echo "<br>$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]";
echo "</font>";
echo "</font><br><font class=text12>".pcrtlang("Phone").": $storeinfoarray[storephone]</font><br><br><br>";

echo "<table cellpadding=3 cellspacing=0 border=0><tr><td valign=top><font class=text12b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></td><td>";

if ("$rs_company" != "") {
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


echo "$rs_state $rs_zip<br><br>";


if ($iorq == "quote") {
$ilabel = pcrtlang("Quote");
} else {
$ilabel = pcrtlang("Invoice");
}


$ilabel2 = strtoupper($ilabel);

echo "</font></td></tr></table>";

echo "</font><br></td><td valign=top><table><tr><td align=right width=45% valign=top>";
echo "<font class=textidnumber>$ilabel2 #$invoice_id<br></font>";


$rs_datesold2 = pcrtdate("$pcrt_longdate", "$rs_datesold");

echo "<br><font class=text12>$ilabel2 ".pcrtlang("Date").": </font><font class=text12b>$rs_datesold2</font>";

if ($rs_woid != "") {
echo "<br><font class=text12b>".pcrtlang("Work Order")."</font> ";
$rs_woids = explode_list($rs_woid);
foreach($rs_woids as $key => $rs_woidids) {
echo "<font class=textgray12>#$rs_woidids</font> ";
}
}





$invtimestamp = strtotime($rs_datesold);
$invlateperiod = $invoiceoverduedays * 86400;
$invlatetime = $invtimestamp + $invlateperiod;


if (($invlatetime < time()) && ($iorq != "quote") && ($invstatus == 1)) {
echo "<br><br><br><font class=overduestamp style=\"display:inline-block;\">".pcrtlang("OVERDUE")."</font>";
}

echo "</td></tr><tr><td>";

if ($invnotes != "") {
echo "<br><font class=text12b>".pcrtlang("Note").": </font><font class=text12>";
echo nl2br($invnotes);
echo "</font>";
}

echo "</td></tr></table></td></tr></table>";



echo "<table class=printables>";

$rs_find_cart_items = "SELECT * FROM invoice_items WHERE cart_type = 'purchase' AND invoice_id = '$invoice_id' ORDER BY addtime ASC";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

if (mysqli_num_rows($rs_result) != 0) {
echo "<tr><th colspan=5 width=100%>".pcrtlang("Purchase Items")."</th></tr>";

echo "<tr><td width=5% class=subhead>".pcrtlang("Qty")."</td><td width=50% class=subhead>".pcrtlang("Name of Product")."</td><td width=15% align=right class=subhead>".pcrtlang("Item Price")."</td><td width=15% align=right class=subhead>".pcrtlang("Total Price");

echo "</td><td width=15% align=right class=subhead>".pcrtlang("Tax")."</td></tr>";
}


while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_cart_item_id = "$rs_result_q->cart_item_id";
$rs_cart_price = "$rs_result_q->cart_price";
$rs_stock_id = "$rs_result_q->cart_stock_id";
$rs_labordesc = "$rs_result_q->labor_desc";
$rs_printdesc = "$rs_result_q->printdesc";
$origprice = "$rs_result_q->origprice";
$discounttype = "$rs_result_q->discounttype";
$price_alt = "$rs_result_q->price_alt";
$itemserial = "$rs_result_q->itemserial";
$taxex = "$rs_result_q->taxex";
$itemtax = "$rs_result_q->itemtax";
$unit_price = "$rs_result_q->unit_price";
$quantity = "$rs_result_q->quantity";

$unit_tax = $itemtax / $quantity;

$rs_tax_total2 = $itemtax;
$rs_tax_total = number_format($rs_tax_total2, 2, '.', '');

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
$lineitemtax[$taxex] = $rs_tax_total;
if(!array_key_exists("$taxex", $mastertaxtotals)) {
$mastertaxtotals[$taxex]['parts'] = $salestaxrate * $rs_cart_price;
$mastertaxtotals[$taxex]['labor'] = 0;
$mastertaxtotals[$taxex]['return'] = 0;
} else {
$mastertaxtotals[$taxex]['parts'] = ($salestaxrate * $rs_cart_price) + $mastertaxtotals[$taxex]['parts'];
}
} else {
$grouprates = getgrouprates($taxex);

foreach($grouprates as $key => $val) {
$salestaxratei = getsalestaxrate($val);

$lineitemtax[$val] = $salestaxratei * $rs_cart_price * $rs_itemtotal;

if(!array_key_exists("$val", $mastertaxtotals)) {
$mastertaxtotals[$val]['parts'] = $salestaxratei * $rs_cart_price;
$mastertaxtotals[$val]['labor'] = 0;
$mastertaxtotals[$val]['return'] = 0;
} else {
$mastertaxtotals[$val]['parts'] = ($salestaxratei * $rs_cart_price) + $mastertaxtotals[$val]['parts'];
}

}
}
####


echo "<tr><td width=5% class=lineitems><font class=text12b>".qf("$quantity")."</font>";


echo "</td><td width=50% class=lineitems><font class=text12b>$rs_stocktitle</font>";

if($rs_stockpdesc != "") {
echo "<br><br><div class=leftindent>".nl2br("$rs_stockpdesc")."</div>";
}


if ($itemserial != "") {
echo "&nbsp;&nbsp;<font class=text10b>(".pcrtlang("Serial/Code").":</font> <font class=text10>$itemserial</font><font class=text10b>)</font>";
}


if (($price_alt == 1) && ($origprice > $rs_cart_price)) {
echo "<br>";
$disc = explode('|',"$discounttype");
if("$disc[0]" == "percent") {
echo "<font class=text10i>&nbsp;&nbsp;$disc[1]".pcrtlang("% discount applied</font>");
} elseif("$disc[0]" == "custom") {
echo "<font class=text10i>&nbsp;&nbsp;".pcrtlang("discount applied</font>");
} else {

}
}

$rs_cart_price_total = $rs_cart_price;

echo "</td><td width=15% align=right class=lineitems><font class=text12b>$money".limf("$unit_price","$unit_tax")."</font>";

if (($price_alt == 1) && ($origprice > $rs_cart_price)) {
$origunitpricetax = $origprice * getsalestaxrate($taxex);
echo "<br><font class=text10i>".pcrtlang("was")." $money".limf("$origprice","$origunitpricetax")."</font>";
}

echo "</td>";




echo "<td width=15% align=right class=lineitems><font class=text12b>$money".limf("$rs_cart_price_total","$itemtax")."</font></td><td align=right>";

reset($lineitemtax);
foreach($lineitemtax as $key => $val) {
$shortname = gettaxshortname($key);
if($val != 0) {
echo "<font class=text10i>";
echo "$shortname: $money".mf("$val");
echo "</font><br>";
}
}
unset($lineitemtax);

echo "</td></tr>";

}



$rs_find_cart_labor = "SELECT * FROM invoice_items WHERE cart_type = 'labor' AND invoice_id = '$invoice_id' ORDER BY addtime ASC";
$rs_result_labor = mysqli_query($rs_connect, $rs_find_cart_labor);

if (mysqli_num_rows($rs_result_labor) != 0) {
echo "<tr><td width=100% colspan=5>&nbsp;</td></tr>";
echo "<tr><th colspan=5>".pcrtlang("Labor")."</th></tr>";
echo "<tr><td width=5% class=subhead>".pcrtlang("Qty")."</td><td width=50% class=subhead>".pcrtlang("Labor Description")."</td><td width=15% class=subhead align=right>".pcrtlang("Unit Price")."</td>";
echo "<td width=15% align=right class=subhead>".pcrtlang("Price")."</td><td width=15% align=right class=subhead>".pcrtlang("Tax")."</td></tr>";


}


while($rs_result_labor_q = mysqli_fetch_object($rs_result_labor)) {
$rs_cart_labor_id = "$rs_result_labor_q->cart_item_id";
$rs_cart_labor_price = "$rs_result_labor_q->cart_price";
$rs_cart_labor_desc = "$rs_result_labor_q->labor_desc";
$rs_cart_labor_pdesc = "$rs_result_labor_q->printdesc";
$lorigprice = "$rs_result_labor_q->origprice";
$ldiscounttype = "$rs_result_labor_q->discounttype";
$lprice_alt = "$rs_result_labor_q->price_alt";
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
} else {
$mastertaxtotals[$val]['labor'] = ($servicetaxratei * $rs_cart_labor_price) + $mastertaxtotals[$val]['labor'];
}

}
}
####


echo "<tr><td width=5% class=lineitems>".qf("$lquantity")."</td><td width=50% class=lineitems><font class=text12b>$rs_cart_labor_desc</font>";

if($rs_cart_labor_pdesc != "") {
echo "<br><br><div class=leftindent>".nl2br("$rs_cart_labor_pdesc")."</div>";
}


if (($lprice_alt == 1) && ($lorigprice > $rs_cart_labor_price)) {
echo "<br>";
$ldisc = explode('|',"$ldiscounttype");
if("$ldisc[0]" == "percent") {
echo "<font class=text10i>&nbsp;&nbsp;$ldisc[1]".pcrtlang("% discount applied")."</font>";
} elseif("$ldisc[0]" == "custom") {
echo "<font class=text10i>&nbsp;&nbsp;".pcrtlang("discount applied")."</font>";
} else {

}
}

#wip

echo "</td><td width=15% align=right class=lineitems>$money".limf("$lunit_price","$lunit_tax")."</td><td width=15% align=right class=lineitems><font class=text12b>$money".limf("$rs_cart_labor_price","$litemtax")."</font>";

if (($lprice_alt == 1) && ($lorigprice > $rs_cart_labor_price)) {
$lorigunitpricetax = $lorigprice * getservicetaxrate($ltaxex);
echo "<br><font class=text10i>was $money".limf("$lorigprice","$lorigunitpricetax")."</font>";
}

echo "</td><td align=right>";

reset($laboritemtax);
foreach($laboritemtax as $key => $val) {
$shortname = gettaxshortname($key);
if($val != 0) {

echo "<font class=text10i>";
echo "$shortname: $money".mf("$val");
echo "</font><br>";

}
}
unset($laboritemtax);

echo "</td></tr>";

}


echo "<tr><td colspan=5 width=100%>&nbsp;</td></tr>";

$rs_find_item_total = "SELECT SUM(cart_price) AS total_price_parts, SUM(itemtax) AS total_price_parts_tax FROM invoice_items WHERE cart_type = 'purchase' AND invoice_id = '$invoice_id'";
$rs_find_result_total = mysqli_query($rs_connect, $rs_find_item_total);

while($rs_find_result_total_q = mysqli_fetch_object($rs_find_result_total)) {
$rs_total_parts = "$rs_find_result_total_q->total_price_parts";
$rs_total_parts_tax = "$rs_find_result_total_q->total_price_parts_tax";
}

if ($rs_total_parts == "") {
$rs_total_parts = "0.00";
$rs_total_parts_tax = "0.00";
}

echo "<tr><td width=5%>&nbsp;</td><td width=80% align=right colspan=3><font class=text14b>".pcrtlang("Parts Subtotal").":</font></td><td width=15% align=right><font class=text14b>$money".limf("$rs_total_parts","$rs_total_parts_tax")."</font></td></tr>";

$rs_find_itemtax_total = "SELECT SUM(itemtax) AS total_tax_parts FROM invoice_items WHERE cart_type = 'purchase' AND invoice_id = '$invoice_id'";
$rs_find_result_taxtotal = mysqli_query($rs_connect, $rs_find_itemtax_total);
while($rs_find_result_taxtotal_q = mysqli_fetch_object($rs_find_result_taxtotal)) {
$rs_total_partstax = "$rs_find_result_taxtotal_q->total_tax_parts";

$salestax = $rs_total_partstax;

}




$rs_find_labor_total = "SELECT SUM(cart_price) AS total_labor_price, SUM(itemtax) AS total_labor_price_tax FROM invoice_items WHERE cart_type = 'labor' AND invoice_id = '$invoice_id'";
$rs_find_result_labor_total = mysqli_query($rs_connect, $rs_find_labor_total);


while($rs_find_result_labor_total_q = mysqli_fetch_object($rs_find_result_labor_total)) {
$rs_total_labor = "$rs_find_result_labor_total_q->total_labor_price";
$rs_total_labor_tax = "$rs_find_result_labor_total_q->total_labor_price_tax";
}
if ($rs_total_labor == "") {
$rs_total_labor = "0.00";
$rs_total_labor_tax = "0.00";
}
echo "<tr><td width=5%>&nbsp;</td><td width=80% align=right colspan=3><font class=text14b>".pcrtlang("Labor Total").":</font></td><td width=15% align=right><font class=text14b>$money".limf("$rs_total_labor","$rs_total_labor_tax")."</font></td></tr>";

$rs_find_labortax_total = "SELECT SUM(itemtax) AS total_labortax_price FROM invoice_items WHERE cart_type = 'labor' AND invoice_id = '$invoice_id'";
$rs_find_result_taxlabor_total = mysqli_query($rs_connect, $rs_find_labortax_total);
while($rs_find_result_labortax_total_q = mysqli_fetch_object($rs_find_result_taxlabor_total)) {
$rs_total_labortax = "$rs_find_result_labortax_total_q->total_labortax_price";

$servicetax = $rs_total_labortax;

}


#echo "<tr><td width=100% colspan=5>&nbsp;</td></tr>";

$grand_total = ($salestax + $rs_total_parts + $rs_total_labor + $servicetax);

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

$taxtotal = ($mastertaxtotals[$key]['parts'] + $mastertaxtotals[$key]['labor']);
if($taxtotal != "0") {
echo "<tr><td width=5%></td><td width=80% align=right colspan=3><font class=text10b>$taxname:</font></td>
<td width=15% align=right><font class=text12>$money".mf("$taxtotal")."</font></td></tr>";
}
}

echo "<tr><td width=100% colspan=5>&nbsp;</td></tr>";

echo "<tr><td width=5%></td><td width=80% align=right colspan=3><font class=text20b>";

if("$iorq" == "invoice") {
echo pcrtlang("Invoice Total").":";
} else {
echo pcrtlang("Quote Total").":";
}


echo "</font></td>";
echo "<td width=15% align=right><font class=text20b>$money".mf("$grand_total")."</font>";



echo "</td></tr>";


if(("$iorq" == "invoice") && ($invstatus == 1)) {


$finddepositstotal = "SELECT * FROM deposits WHERE invoiceid = '$invoice_id'";
$finddepositsqtotal = @mysqli_query($rs_connect, $finddepositstotal);


if(mysqli_num_rows($finddepositsqtotal) > 0) {

while($rs_find_deposits_q = mysqli_fetch_object($finddepositsqtotal)) {
$depositid = "$rs_find_deposits_q->depositid";
$depositamount = "$rs_find_deposits_q->amount";
$checknumber = "$rs_find_deposits_q->chk_number";

echo "<tr><td width=5%></td><td width=80% align=right colspan=3><font class=text14b>".pcrtlang("Deposit ID").": #$depositid";
if($checknumber != "") {
echo " | ".pcrtlang("Check No.")." #$checknumber";
}

echo "</font></td>";
echo "<td width=15% align=right><font class=text14b>$money".mf("$depositamount")."</font></td></tr>";


}

$finddeposits = "SELECT SUM(amount) AS totaldep FROM deposits WHERE invoiceid = '$invoice_id'";
$finddepositsq = @mysqli_query($rs_connect, $finddeposits);

$finddepositsa = mysqli_fetch_object($finddepositsq);
$totaldep = "$finddepositsa->totaldep";
$balance = $grand_total - $totaldep;

echo "<tr><td width=5%></td><td width=80% align=right colspan=3><font class=text20b>".pcrtlang("Total Deposits").":</font></td>";
echo "<td width=15% align=right><font class=text20b>$money".mf("$totaldep")."</font></td></tr>";

echo "<tr><td width=5%></td><td width=80% align=right colspan=3><font class=text20b>".pcrtlang("Balance Due").":</font></td>";
echo "<td width=15% align=right><font class=text20b>$money".mf("$balance")."</font></td></tr>";


}

}


echo "</table>";



if ("$iorq" == "invoice") {
echo "<center>";
echo nl2br($storeinfoarray['invoicefooter']);
echo "</center>\n\n";
} else {
echo "<center>";
echo nl2br($storeinfoarray['quotefooter']);
echo "</center>\n\n";
}


##############################


echo "</div>";


#############################




echo "</div>";

if (count($invoicearray) > 1) {
echo "\n\n<DIV style=\"page-break-after:always\"></DIV>\n\n";
}


}




echo "</body></html>";


}























function browseinvoices() {

require("deps.php");
require("common.php");
require("header.php");


if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}


if (array_key_exists('pageNumber',$_REQUEST)) {
$pageNumber = $_REQUEST['pageNumber'];
} else {
$pageNumber = 1;
}

$results_per_page = 40;

$offset = ($pageNumber * $results_per_page) - $results_per_page;


#wip

echo "<h3>".pcrtlang("Browse Invoices")."</h3>";

#echo "<div class=\"table-responsive\">";
echo "<table class=\"table table-striped\" id=invoicetable><thead>";

echo "<tr><th><strong>".pcrtlang("Inv")."#&nbsp;&nbsp;</strong></th><th>".pcrtlang("Customer Name")."&nbsp;&nbsp;</th><th>".pcrtlang("Invoice Date")."&nbsp;&nbsp;</th>";
echo "<th> ".pcrtlang("Total")." &nbsp;&nbsp;</th><th>".pcrtlang("Status")."</th><th>".pcrtlang("Actions")."&nbsp;&nbsp;</th></tr></thead><tbody>";

$rs_invoicest = "(SELECT DISTINCT(invoices.invoice_id) FROM invoices, pc_wo, pc_owner WHERE pc_owner.pcgroupid = '$portalgroupid' AND pc_owner.pcid = pc_wo.pcid 
AND invoices.iorq != 'quote' AND (pc_wo.woid = invoices.woid OR invoices.woid LIKE CONCAT('%\_',pc_wo.woid,'\_%'))) 
UNION (SELECT invoices.invoice_id FROM invoices,rinvoices WHERE invoices.rinvoice_id = rinvoices.rinvoice_id AND rinvoices.pcgroupid = '$portalgroupid' AND invoices.iorq != 'quote') 
UNION (SELECT invoice_id FROM invoices WHERE pcgroupid = '$portalgroupid' AND iorq != 'quote')
UNION (SELECT invoices.invoice_id
FROM invoices,blockcontracthours,blockcontract WHERE blockcontracthours.invoiceid = invoices.invoice_id AND invoices.iorq != 'quote' 
AND blockcontract.pcgroupid = '$portalgroupid' AND blockcontract.blockid = blockcontracthours.blockcontractid)";

$rs_find_invoicest = @mysqli_query($rs_connect, $rs_invoicest);
$rs_invoices = "(SELECT DISTINCT(invoices.invoice_id),invoices.invname,invoices.invstatus,invoices.invemail,invoices.woid,invoices.receipt_id,invoices.invdate,
invoices.invcompany,invoices.pcgroupid,invoices.invphone,invoices.invaddy1,invoices.invaddy2,invoices.invcity,invoices.invstate,invoices.invzip FROM invoices, pc_wo, pc_owner WHERE pc_owner.pcgroupid = '$portalgroupid' AND pc_owner.pcid = pc_wo.pcid AND invoices.iorq != 'quote' 
AND (pc_wo.woid = invoices.woid OR invoices.woid LIKE CONCAT('%\_',pc_wo.woid,'\_%'))) 
UNION (SELECT invoices.invoice_id,invoices.invname,invoices.invstatus,invoices.invemail,invoices.woid,invoices.receipt_id,invoices.invdate,invoices.invcompany,invoices.pcgroupid,invoices.invphone,invoices.invaddy1,invoices.invaddy2,invoices.invcity,invoices.invstate,invoices.invzip 
FROM invoices,rinvoices WHERE invoices.rinvoice_id = rinvoices.rinvoice_id AND rinvoices.pcgroupid = '$portalgroupid' AND invoices.iorq != 'quote') 
UNION (SELECT invoices.invoice_id,invoices.invname,invoices.invstatus,invoices.invemail,invoices.woid,invoices.receipt_id,invoices.invdate,invoices.invcompany,invoices.pcgroupid,invoices.invphone,invoices.invaddy1,invoices.invaddy2,invoices.invcity,invoices.invstate,invoices.invzip
FROM invoices WHERE invoices.pcgroupid = '$portalgroupid' AND invoices.iorq != 'quote')
UNION (SELECT invoices.invoice_id,invoices.invname,invoices.invstatus,invoices.invemail,invoices.woid,invoices.receipt_id,invoices.invdate,invoices.invcompany,
invoices.pcgroupid,invoices.invphone,invoices.invaddy1,invoices.invaddy2,invoices.invcity,invoices.invstate,invoices.invzip
FROM invoices,blockcontracthours,blockcontract WHERE blockcontracthours.invoiceid = invoices.invoice_id
AND blockcontract.pcgroupid = '$portalgroupid' AND blockcontract.blockid = blockcontracthours.blockcontractid AND invoices.iorq != 'quote')
ORDER BY invdate DESC LIMIT $offset,$results_per_page";

$rs_find_invoices = @mysqli_query($rs_connect, $rs_invoices);
while($rs_find_invoices_q = mysqli_fetch_object($rs_find_invoices)) {
$invoice_id = "$rs_find_invoices_q->invoice_id";
$invname = "$rs_find_invoices_q->invname";
$invcompany = "$rs_find_invoices_q->invcompany";
$invstatus = "$rs_find_invoices_q->invstatus";
$invemail = "$rs_find_invoices_q->invemail";
$invphone = "$rs_find_invoices_q->invphone";
$invaddy1 = "$rs_find_invoices_q->invaddy1";
$invaddy2 = "$rs_find_invoices_q->invaddy2";
$invcity = "$rs_find_invoices_q->invcity";
$invstate = "$rs_find_invoices_q->invstate";
$invzip = "$rs_find_invoices_q->invzip";
$invwoid = "$rs_find_invoices_q->woid";
$invpcgroupid = "$rs_find_invoices_q->pcgroupid";
$invrec = "$rs_find_invoices_q->receipt_id";
$invdate = "$rs_find_invoices_q->invdate";
$invdate2 = date("F j, Y", strtotime($invdate));
$findinvtotal = "SELECT SUM(cart_price) AS invsubtotal, SUM(itemtax) AS invtax FROM invoice_items WHERE invoice_id = '$invoice_id'";
$findinvq = @mysqli_query($rs_connect, $findinvtotal);
$findinva = mysqli_fetch_object($findinvq);
$invtax = "$findinva->invtax";
$invsubtotal = "$findinva->invsubtotal";
$invtotal2 = $invtax + $invsubtotal;
$invtotal = number_format($invtotal2, 2, '.', '');


$invname_ue = urlencode($invname);
$invcompany_ue = urlencode($invcompany);
$invemail_ue = urlencode($invemail);
$invphone_ue = urlencode($invphone);
$invaddy1_ue = urlencode($invaddy1);
$invaddy2_ue = urlencode($invaddy2);
$invcity_ue = urlencode($invcity);
$invstate_ue = urlencode($invstate);
$invzip_ue = urlencode($invzip);

if ($invstatus == 1) {
$thestatus = "Open";
} elseif ($invstatus == 2) {
$thestatus = "Closed/Paid";
} else {
$thestatus = "Voided";
}


echo "<tr><td>$invoice_id</td><td><span class=boldme>$invname</span>";
if ("$invcompany" != "") {
echo "<br>$invcompany";
}
echo "</td><td>$invdate2</td><td>$money$invtotal</td><td>".pcrtlang("$thestatus")."</td>";
echo "<td><a href=invoice.php?func=printinv&invoice_id=$invoice_id><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Print Invoice")."</a>";
echo "&nbsp;&nbsp;&nbsp;";
if($invrec != "0") {
echo "<a href=receipt.php?func=printreceipt&receipt=$invrec><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Print Receipt")."</a>";
}
echo "</td></tr>";
}
echo "</tbody></table>";

#echo "</div>";



echo "<br>";

echo "<center>";
#browse here
$totalentry = mysqli_num_rows($rs_find_invoicest);
$prevpage = $pageNumber - 1;
$nextpage = $pageNumber + 1;

if ($pageNumber > 1) {
echo "<a href=invoice.php?func=browseinvoices&pageNumber=$prevpage class=\"btn btn-default\" role=button><i class=\"fa fa-chevron-left fa-lg\"></i></a> ";
}

$total_results = $totalentry;
$results_per_page = $results_per_page;
$html = get_paged_nav($total_results, $results_per_page, false);
echo "$html";
if (($totalentry / $results_per_page) > $pageNumber) {
echo "<a href=invoice.php?func=browseinvoices&pageNumber=$nextpage class=\"btn btn-default\" role=button><i class=\"fa fa-chevron-right fa-lg\"></i></a>";
}

echo "</center><br><br>";




require("footer.php");

?>
<script>
$(document).ready(function () {
    $('#invoicetable').resTables();
});
</script>

<?php
}


switch($func) {
                                                                                                    
    default:
    invoices();
    break;
                                
    case "printinv":
    printinv();
    break;

    case "browseinvoices":
    browseinvoices();
    break;


}

