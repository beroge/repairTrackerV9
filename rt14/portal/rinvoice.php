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

echo "Nothing to see here";

}



##########

function browseri() {
require_once("validate.php");

include("deps.php");
include("common.php");

require("header.php");

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}


echo "<h3>".pcrtlang("Recurring Services")."</h3>";

echo "<div class=\"table-responsive\">";
echo "<table class=\"table\">";

echo "<tr><th>".pcrtlang("ID")."#&nbsp;&nbsp;</th><th>".pcrtlang("Customer Name")."&nbsp;&nbsp;</th>";

echo "<th>".pcrtlang("Invoiced Thru Date")."&nbsp;&nbsp;</th><th>".pcrtlang("Interval")."</th>";
echo "<th> ".pcrtlang("Total")." &nbsp;&nbsp;</th><th>".pcrtlang("Status")."</th></tr>";

$rs_invoices = "SELECT * FROM rinvoices WHERE pcgroupid = '$portalgroupid' AND invactive = '1' ORDER BY invthrudate ASC";
$rs_find_invoices = @mysqli_query($rs_connect, $rs_invoices);
while($rs_find_invoices_q = mysqli_fetch_object($rs_find_invoices)) {
$rinvoice_id = "$rs_find_invoices_q->rinvoice_id";
$invname = "$rs_find_invoices_q->invname";
$invcompany = "$rs_find_invoices_q->invcompany";
$invactive = "$rs_find_invoices_q->invactive";
$invemail = "$rs_find_invoices_q->invemail";
$invphone = "$rs_find_invoices_q->invphone";
$invaddy1 = "$rs_find_invoices_q->invaddy1";
$invaddy2 = "$rs_find_invoices_q->invaddy2";
$invcity = "$rs_find_invoices_q->invcity";
$invstate = "$rs_find_invoices_q->invstate";
$invzip = "$rs_find_invoices_q->invzip";
$invthrudate = "$rs_find_invoices_q->invthrudate";
$invterms = "$rs_find_invoices_q->invterms";
$invinterval = "$rs_find_invoices_q->invinterval";
$invthrudate2 = date("F j, Y", strtotime($invthrudate));
$invstoreid = "$rs_find_invoices_q->storeid";
$pcgroupid = "$rs_find_invoices_q->pcgroupid";

$storeinfoarray = getstoreinfo($invstoreid);

$invoiceintervals = array('1W' => pcrtlang('Weekly'),'2W' => pcrtlang('Every 2 Weeks'),'1M' => pcrtlang('Monthly'),'2M' => pcrtlang('Every 2 Months'),
'3M' => pcrtlang('Quarterly'),'6M' => pcrtlang('Every 6 Months'),'1Y' => pcrtlang('Yearly'),'2Y' => pcrtlang('Every 2 Years'));

$findinvtotal = "SELECT SUM(cart_price) AS invsubtotal, SUM(itemtax) AS invtax FROM rinvoice_items WHERE rinvoice_id = '$rinvoice_id'";
$findinvq = @mysqli_query($rs_connect, $findinvtotal);
$findinva = mysqli_fetch_object($findinvq);
$invtax = "$findinva->invtax";
$invsubtotal = "$findinva->invsubtotal";
$invtotal2 = $invtax + $invsubtotal;
$invtotal = number_format($invtotal2, 2, '.', '');
if ($invactive == 1) {
$thestatus = "<td class=\"text-success bg-success\">".pcrtlang("Active")."</td>";
} else {
$thestatus = "<td class=\"text-danger bg-danger\">".pcrtlang("In-Active")."</td>";
}

echo "<tr><td><font class=text12>$rinvoice_id</font></td><td>$invname";
if("$invcompany" != "") {
echo "<br>$invcompany";
}

echo "</td>";


echo "<td>$invthrudate2</td><td>$invoiceintervals[$invinterval]</td><td>$money$invtotal</td>$thestatus</tr>";
echo "<tr><td></td><td colspan=5>";
###############################################################################################################################

$mastertaxtotals = array();

echo "<table style=\"width:100%\" class=\"table table-condensed table-striped table-bordered\">";

$rs_find_cart_items = "SELECT * FROM rinvoice_items WHERE cart_type = 'purchase' AND rinvoice_id = '$rinvoice_id'";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

if (mysqli_num_rows($rs_result) != 0) {
echo "<tr class=\"info text-info\"><th colspan=4 width=100%>".pcrtlang("Purchase Items")."</th></tr>";

echo "<tr><th width=20%><small>".pcrtlang("Qty")."</small></th><th width=50%><small>".pcrtlang("Name of Product")."</small></th>
<th width=15%><span class=pull-right><small>".pcrtlang("Unit Price")."</small></span></th><th width=15%><span class=pull-right><small>".pcrtlang("Total Price")."</small></span></th></tr>";
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

echo "<tr><td width=20%><font class=text12b>".qf("$quantity")."</font>";


echo "</td><td width=50%><font class=text12b>$rs_stocktitle</font>";

if($rs_printdesc != "") {
echo "<br><br><span class=leftindent>".nl2br("$rs_printdesc")."</span>";
}

if ($itemserial != "") {
echo "&nbsp;&nbsp;<small>(".pcrtlang("Serial/Code").": $itemserial)</small>";
}


if (($price_alt == 1) && ($origprice > $rs_cart_price)) {
echo "<br>";
$disc = explode('|',"$discounttype");
if("$disc[0]" == "percent") {
echo "<small>&nbsp;&nbsp;$disc[1]"."% ".pcrtlang("discount applied")."</small>";
} elseif("$disc[0]" == "custom") {
echo "<small>&nbsp;&nbsp;".pcrtlang("discount applied")."</small>";
} else {

}
}


echo "</td><td width=15% align=right>$money".limf("$unit_price","$unit_tax");

if (($price_alt == 1) && ($origprice > $rs_cart_price)) {
$origunitpricetax = $origprice * getsalestaxrate($taxex);
echo "<br><small>".pcrtlang("was")." $money".limf("$origprice","$origunitpricetax")."</small>";
}
echo "</td><td width=15% align=right>$money".limf("$rs_cart_price","$itemtax")."</td></tr>";



}



$rs_find_cart_labor = "SELECT * FROM rinvoice_items WHERE cart_type = 'labor' AND rinvoice_id = '$rinvoice_id' ORDER BY addtime ASC";
$rs_result_labor = mysqli_query($rs_connect, $rs_find_cart_labor);

if (mysqli_num_rows($rs_result_labor) != 0) {
echo "<tr><td width=100% colspan=4>&nbsp;</td></tr>";
echo "<tr class=\"info text-info\"><th colspan=4>".pcrtlang("Labor")."</th></tr>";
echo "<tr><th width=20%>&nbsp;</th><th width=50%><small>".pcrtlang("Labor Description")."</small></th><th width=15%><span class=pull-right><small>".pcrtlang("Unit Price")."</small></span></th>
<th width=15%><span class=pull-right><small>".pcrtlang("Price")."</small></span></th></tr>";

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

echo "<tr><td width=20%>".qf("$lquantity")."</td><td width=50%>$rs_cart_labor_desc";

if($rs_cart_labor_pdesc != "") {
echo "<br><br><div class=leftindent>".nl2br("$rs_cart_labor_pdesc")."</div>";
}

if (($lprice_alt == 1) && ($lorigprice > $rs_cart_labor_price)) {
echo "<br>";
$ldisc = explode('|',"$ldiscounttype");
if("$ldisc[0]" == "percent") {
echo "<small>&nbsp;&nbsp;$ldisc[1]"."% ".pcrtlang("discount applied")."</small>";
} elseif("$ldisc[0]" == "custom") {
echo "<small>&nbsp;&nbsp;".pcrtlang("discount applied")."</small>";
} else {

}
}

echo "</td><td width=15% align=right>$money".limf("$lunit_price","$lunit_tax")."</td><td width=15% align=right>$money".limf("$rs_cart_labor_price","$litemtax");
if (($lprice_alt == 1) && ($lorigprice > $rs_cart_labor_price)) {
$lorigunitpricetax = $lorigprice * getservicetaxrate($ltaxex);
echo "<br><small>".pcrtlang("was")." $money".limf("$lorigprice","$lorigunitpricetax")."</small>";
}

echo "</td></tr>";

}

echo "</table>";



###############################################################################################################################



echo "</td></tr>";
}
echo "</table>";
echo "</div>";

require("footer.php");



}

























switch($func) {
                                                                                                    
    default:
    nothing();
    break;
                                
    case "browseri":
    browseri();
    break;



}

