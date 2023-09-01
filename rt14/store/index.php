<?php 

/***************************************************************************
 *   copyright            : (C) 2020 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/

// Step 1: Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

 require("header.php"); 

echo "<script type=\"text/javascript\">document.title = \"".pcrtlang("Sale Home")."\";</script>";

require("deps.php");
require_once("common.php");


$thedate = date("Y-m-d");

if(!isset($pcrt_weekstart)) {
$pcrt_weekstart = "Sunday";
}

if ($pcrt_weekstart == "Sunday") {
if(date("w") == 0) {
$thedate2 = date("Y-m-d");
} else {
$thedate2 = date("Y-m-d",strtotime("last Sunday"));
}

} else {

if(date("N") == 1) {
$thedate2 = date("Y-m-d");
} else {
$thedate2 = date("Y-m-d",strtotime("last Monday"));
}
}



if ($pcrt_weekstart == "Sunday") {
$lthedate = date("Y-m-d",strtotime("last Saturday"));
$lthedate2 = date("Y-m-d",strtotime("last Saturday") - 518400);
} else {
$lthedate = date("Y-m-d",strtotime("last Sunday"));
$lthedate2 = date("Y-m-d",strtotime("last Sunday") - 518400);
}


$findinvtotalov = "SELECT SUM(invoice_items.cart_price) AS invsubtotal, SUM(invoice_items.itemtax) AS invtax FROM invoices,invoice_items WHERE invoices.iorq != 'quote'
AND invoices.invdate < (DATE_SUB(NOW(),INTERVAL $invoiceoverduedays DAY)) AND invoices.invstatus = '1' AND invoices.invoice_id = invoice_items.invoice_id";
$findinvqov = @mysqli_query($rs_connect, $findinvtotalov);
$findinvaov = mysqli_fetch_object($findinvqov);
$invtaxov = "$findinvaov->invtax";
$invsubtotalov = "$findinvaov->invsubtotal";
$invtotal2ov = tnv($invtaxov) + tnv($invsubtotalov);
$invtotalov = number_format($invtotal2ov, 2, '.', '');

$findinvtotalovcount = "SELECT * FROM invoices WHERE iorq != 'quote' AND invdate < (DATE_SUB(NOW(),INTERVAL $invoiceoverduedays DAY)) AND invstatus = '1'";
$findinvqovcount = @mysqli_query($rs_connect, $findinvtotalovcount);
$invtotalovcount = mysqli_num_rows($findinvqovcount);

$findinvtotalo = "SELECT SUM(invoice_items.cart_price) AS invsubtotal, SUM(invoice_items.itemtax) AS invtax FROM invoices,invoice_items WHERE invoices.iorq != 'quote'
AND invoices.invdate > (DATE_SUB(NOW(),INTERVAL $invoiceoverduedays DAY)) AND invoices.invstatus = '1' AND invoices.invoice_id = invoice_items.invoice_id";
$findinvqo = @mysqli_query($rs_connect, $findinvtotalo);
$findinvao = mysqli_fetch_object($findinvqo);
$invtaxo = "$findinvao->invtax";
$invsubtotalo = "$findinvao->invsubtotal";
$invtotal2o = tnv($invtaxo) + tnv($invsubtotalo);
$invtotalo = number_format($invtotal2o, 2, '.', '');

$findinvtotalocount = "SELECT * FROM invoices WHERE iorq != 'quote' AND invdate > (DATE_SUB(NOW(),INTERVAL $invoiceoverduedays DAY)) AND invstatus = '1'";
$findinvqocount = @mysqli_query($rs_connect, $findinvtotalocount);
$invtotalocount = mysqli_num_rows($findinvqocount);

$findrectotaltw = "SELECT SUM(sold_items.sold_price) AS recsubtotal, SUM(sold_items.itemtax) AS rectax FROM receipts,sold_items WHERE sold_items.date_sold > '$thedate2 00:00:00' 
AND receipts.receipt_id = sold_items.receipt";
$findrecqtw = @mysqli_query($rs_connect, $findrectotaltw);
$findrecatw = mysqli_fetch_object($findrecqtw);
$rectaxtw = "$findrecatw->rectax";
$recsubtotaltw = "$findrecatw->recsubtotal";
$rectotal2tw = tnv($rectaxtw) + tnv($recsubtotaltw);
$rectotaltw = number_format($rectotal2tw, 2, '.', '');

$findrectotaltwcount = "SELECT * FROM receipts WHERE date_sold > '$thedate2 00:00:00'";
$findrecqtwcount = @mysqli_query($rs_connect, $findrectotaltwcount);
$rectotaltwcount = mysqli_num_rows($findrecqtwcount);

$findrectotallw = "SELECT SUM(sold_items.sold_price) AS recsubtotal, SUM(sold_items.itemtax) AS rectax FROM receipts,sold_items WHERE 
sold_items.date_sold > '$lthedate2 00:00:00' AND sold_items.date_sold < '$lthedate 11:59:59' 
AND receipts.receipt_id = sold_items.receipt";
$findrecqlw = @mysqli_query($rs_connect, $findrectotallw);
$findrecalw = mysqli_fetch_object($findrecqlw);
$rectaxlw = "$findrecalw->rectax";
$recsubtotallw = "$findrecalw->recsubtotal";
$rectotal2lw = tnv($rectaxlw) + tnv($recsubtotallw);
$rectotallw = number_format($rectotal2lw, 2, '.', '');

$findrectotallwcount = "SELECT * FROM receipts WHERE date_sold > '$lthedate2 00:00:00' AND date_sold < '$lthedate 11:59:59'";
$findrecqlwcount = @mysqli_query($rs_connect, $findrectotallwcount);
$rectotallwcount = mysqli_num_rows($findrecqlwcount);


$findinvtotaltwc = "SELECT * FROM invoices WHERE invoices.iorq != 'quote' AND invdate > '$thedate2 00:00:00'";
$findinvqtwc = @mysqli_query($rs_connect, $findinvtotaltwc);
$twc = mysqli_num_rows($findinvqtwc);

$findinvtotallwc = "SELECT * FROM invoices WHERE invoices.iorq != 'quote' AND invdate > '$lthedate2 00:00:00' AND invdate < '$lthedate 11:59:59'";
$findinvqlwc = @mysqli_query($rs_connect, $findinvtotallwc);
$lwc = mysqli_num_rows($findinvqlwc);

echo "<table class=pad10 style=\"width:100%;\">";
echo "<tr>";

$accentcolor = "#FF5F4B";
echo "<td style=\"width:34%;vertical-align:top;\"><div class=radiustop style=\"background:#ffffff;border-top: #cccccc 1px solid;border-right: #cccccc 1px solid;
border-left: #cccccc 1px solid;padding:20px\">";

if (perm_check("5")) {
echo "<span style=\"color:$accentcolor\" class=\"boldme sizemelarger\">$money$invtotalov</span> &nbsp;";
echo "<span class=\"boldme sizemelarger\">".pcrtlang("Overdue Balance")."</span><br>";
echo "<span style=\"color:$accentcolor\" class=\"boldme sizemelarger\">$money$invtotalo</span> &nbsp;";
echo "<span class=\"boldme sizemelarger\">".pcrtlang("Balance")."</span></div>";
} else {
echo "<span style=\"color:$accentcolor\" class=\"boldme sizemelarger\">$invtotalovcount</span> &nbsp;";
echo "<span class=\"boldme sizemelarger\">".pcrtlang("Total Overdue Invoices")."</span><br>";
echo "<span style=\"color:$accentcolor\" class=\"boldme sizemelarger\">$invtotalocount</span> &nbsp;";
echo "<span class=\"boldme sizemelarger\">".pcrtlang("Open Invoices")."</span></div>";
}

echo "<div class=radiusbottom style=\"background:$accentcolor; padding:20px; color:#FFFFFF\">";
echo "<span class=boldme style=\"line-height:28px\"> ".pcrtlang("Un-Paid Invoices")."<i class=\"fa fa-file-invoice fa-2x floatright\"></i></span></div></td>";


$accentcolor2 = "#4BD34B";
echo "<td style=\"width:33%;vertical-align:top;\"><div class=radiustop style=\"background:#ffffff;border-top: #cccccc 1px solid;border-right: #cccccc 1px solid;
border-left: #cccccc 1px solid;padding:20px\">";
if (perm_check("5")) {
echo "<span style=\"color:$accentcolor2\" class=\"boldme sizemelarger\">$money$rectotaltw</span> &nbsp;";
echo "<span class=\"boldme sizemelarger\">".pcrtlang("This Week")."</span><br>";
echo "<span style=\"color:$accentcolor2\" class=\"boldme sizemelarger\">$money$rectotallw</span> &nbsp;";
echo "<span class=\"boldme sizemelarger\">".pcrtlang("Last Week")."</span></div>";
} else {
echo "<span style=\"color:$accentcolor2\" class=\"boldme sizemelarger\">$rectotaltwcount</span> &nbsp;";
echo "<span class=\"boldme sizemelarger\">".pcrtlang("This Week")."</span><br>";
echo "<span style=\"color:$accentcolor2\" class=\"boldme sizemelarger\">$rectotallwcount</span> &nbsp;";
echo "<span class=\"boldme sizemelarger\">".pcrtlang("Last Week")."</span></div>";
}
echo "<div class=radiusbottom style=\"background:$accentcolor2; padding:20px; color:#FFFFFF\">";
echo "<span class=\"boldme\" style=\"line-height:28px\"> ".pcrtlang("Receipts")."<i class=\"fa fa-receipt fa-2x floatright\"></i></span></div></td>";

$accentcolor3 = "#0077ee";
echo "<td style=\"width:33%;vertical-align:top;\"><div class=radiustop style=\"background:#ffffff;border-top: #cccccc 1px solid;border-right: #cccccc 1px solid;
border-left: #cccccc 1px solid;padding:20px\">";
echo "<span style=\"color:$accentcolor3\" class=\"boldme sizemelarger\">$twc</span> &nbsp;";
echo "<span class=\"boldme sizemelarger\">".pcrtlang("This Week")."</span><br>";
echo "<span style=\"color:$accentcolor3\" class=\"boldme sizemelarger\">$lwc</span> &nbsp;";
echo "<span class=\"boldme sizemelarger\">".pcrtlang("Last Week")."</span></div>";
echo "<div class=radiusbottom style=\"background:$accentcolor3; padding:20px; color:#FFFFFF\">";
echo "<span class=boldme style=\"line-height:28px\"> ".pcrtlang("New Invoices")."<i class=\"fa fa-file-invoice fa-2x floatright\"></i></span></div></td>";



echo "</tr></table>";


echo "<br><br><table class=pad10 style=\"width:100%;\">";
echo "<tr>";



$accentcolor2 = "#FF5F4B";
echo "<td style=\"width:50%;vertical-align:top;\">";
echo "<div class=radiustop style=\"background:$accentcolor2; padding:20px; color:#FFFFFF\">";
echo "<span class=boldme style=\"line-height:28px\"> ".pcrtlang("Oldest Overdue Invoices")."<i class=\"fa fa-file-invoice fa-2x floatright\"></i></span></div>";
echo "<div style=\"background:#ffffff;border-right: #cccccc 1px solid;border-left: #cccccc 1px solid;padding:20px\">";

echo "<table class=\"standard lastalignright\">";
$rs_invoices = "SELECT * FROM invoices WHERE iorq != 'quote' AND invdate < (DATE_SUB(NOW(),INTERVAL $invoiceoverduedays DAY)) AND invstatus = '1' ORDER BY invdate ASC LIMIT 10";
$rs_find_invoices = @mysqli_query($rs_connect, $rs_invoices);
while($rs_find_invoices_q = mysqli_fetch_object($rs_find_invoices)) {
$invoice_id = "$rs_find_invoices_q->invoice_id";
$invname = "$rs_find_invoices_q->invname";
$invcompany = "$rs_find_invoices_q->invcompany";
$invdate = "$rs_find_invoices_q->invdate";
$invdate2 = pcrtdate("$pcrt_shortdate", "$invdate");
$findinvtotal = "SELECT SUM(cart_price) AS invsubtotal, SUM(itemtax) AS invtax FROM invoice_items WHERE invoice_id = '$invoice_id'";
$findinvq = @mysqli_query($rs_connect, $findinvtotal);
$findinva = mysqli_fetch_object($findinvq);
$invtax = "$findinva->invtax";
$invsubtotal = "$findinva->invsubtotal";
$invtotal2 = tnv($invtax) + tnv($invsubtotal);
$invtotal = number_format($invtotal2, 2, '.', '');
echo "<tr><td>$invdate2</td><td>$invname</td><td>$money$invtotal</td></tr>";

}
echo "</table></div>";

echo "<div class=radiusbottom style=\"background:$accentcolor2; padding:10px; color:#FFFFFF\">";
echo "<a href=\"invoice.php\" class=\"linkbuttonopaque linkbuttonmedium radiusall\" style=\"display:block\">".pcrtlang("View Open Invoices")."</a></div>";

echo "</td>";

$accentcolor3 = "#4BD34B";
echo "<td style=\"width:50%;vertical-align:top;\">";
echo "<div class=radiustop style=\"background:$accentcolor3; padding:20px; color:#FFFFFF\">";
echo "<span class=boldme style=\"line-height:28px\"> ".pcrtlang("Upcoming Recurring Invoices")."<i class=\"fa fa-retweet fa-2x floatright\"></i></span></div>";
echo "<div style=\"background:#ffffff;border-right: #cccccc 1px solid;border-left: #cccccc 1px solid;padding:20px\">";


$rs_invoices = "SELECT * FROM rinvoices WHERE invactive = '1' ORDER BY invthrudate ASC LIMIT 10";
$rs_find_invoices = @mysqli_query($rs_connect, $rs_invoices);
echo "<table class=\"standard lastalignright\">";
while($rs_find_invoices_q = mysqli_fetch_object($rs_find_invoices)) {
$rinvoice_id = "$rs_find_invoices_q->rinvoice_id";
$invname = "$rs_find_invoices_q->invname";
$invcompany = "$rs_find_invoices_q->invcompany";
$invthrudate = "$rs_find_invoices_q->invthrudate";
$invinterval = "$rs_find_invoices_q->invinterval";
$invthrudate2 = pcrtdate("$pcrt_shortdate", "$invthrudate");

$findinvtotal = "SELECT SUM(cart_price) AS invsubtotal, SUM(itemtax) AS invtax FROM rinvoice_items WHERE rinvoice_id = '$rinvoice_id'";
$findinvq = @mysqli_query($rs_connect, $findinvtotal);
$findinva = mysqli_fetch_object($findinvq);
$invtax = "$findinva->invtax";
$invsubtotal = "$findinva->invsubtotal";

$invtotal2 = tnv($invtax) + tnv($invsubtotal);
$invtotal = number_format($invtotal2, 2, '.', '');
echo "<tr><td>$invthrudate2</td><td>$invname</td><td>$money$invtotal</td></tr>";
}

echo "</table></div>";

echo "<div class=radiusbottom style=\"background:$accentcolor3; padding:10px; color:#FFFFFF\">";
echo "<a href=\"../store/invoice.php?func=recurringinvoices\" class=\"linkbuttonopaque linkbuttonmedium radiusall\" style=\"display:block\">".pcrtlang("View Recurring Invoices")."</a></div>";

echo "</td>";

echo "</tr></table>";

#####

echo "<br><br><table class=pad10 style=\"width:100%;\">";

$accentcolor2 = "#f7a900";
echo "<td style=\"width:50%;vertical-align:top;\">";
echo "<div class=radiustop style=\"background:$accentcolor2; padding:20px; color:#FFFFFF\">";
echo "<span class=boldme style=\"line-height:28px\"> ".pcrtlang("Recently Sold Low Stock Items")."<i class=\"fa fa-truck-loading fa-2x floatright\"></i></span></div>";
echo "<div class=radiusbottom style=\"background:#ffffff;border-bottom: #cccccc 1px solid;border-right: #cccccc 1px solid;border-left: #cccccc 1px solid;padding:20px\">";

$rs_find_cart_items = "SELECT sold_items.sold_id,sold_items.receipt,sold_items.sold_price,sold_items.unit_price,sold_items.stockid,sold_items.sold_type,sold_items.date_sold
FROM sold_items,receipts WHERE sold_items.stockid != '0' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$defaultuserstore'
ORDER BY date_sold DESC LIMIT 50";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

echo "<table class=\"standard lastalignright\">";
$totalechoed = 0;
while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_sold_id = "$rs_result_q->sold_id";
$rs_stockid = "$rs_result_q->stockid";
$rs_sold_type = "$rs_result_q->sold_type";
$rs_date_sold = "$rs_result_q->date_sold";
$rs_date_sold2 = pcrtdate("$pcrt_shortdate", "$rs_date_sold");

$rs_find_stock_name = "SELECT * FROM stock WHERE stock_id = '$rs_stockid'";
$rs_result_stock = mysqli_query($rs_connect, $rs_find_stock_name);
$rs_result_stock_q = mysqli_fetch_object($rs_result_stock);
$rs_partname2 = "$rs_result_stock_q->stock_title";

$rs_find_stock_count = "SELECT * FROM stockcounts WHERE stockid = '$rs_stockid' AND storeid = '$defaultuserstore'";
$rs_result_stockc = mysqli_query($rs_connect, $rs_find_stock_count);
$rs_result_stock_cq = mysqli_fetch_object($rs_result_stockc);
$rs_stockcount = "$rs_result_stock_cq->quantity";
if($rs_stockcount < 2) {
echo "<tr><td>$rs_date_sold2</td><td><a href=\"../store/stock.php?func=show_stock_detail&stockid=$rs_stockid\" class=\"linkbuttongray linkbuttontiny radiusall\">$rs_partname2</a></td><td>$rs_stockcount</td></tr>";
$totalechoed++;
if($totalechoed > 9) {
break;
}
}
}

echo "</table>";

echo "</div";

echo "</td>";

$accentcolor3 = "#b92dff";
echo "<td style=\"width:50%;vertical-align:top;\">";
echo "<div class=radiustop style=\"background:$accentcolor3; padding:20px; color:#FFFFFF\">";
echo "<span class=boldme style=\"line-height:28px\"> ".pcrtlang("Block of Time Balances")."<i class=\"fa fa-clock fa-2x floatright\"></i></span></div>";
echo "<div class=radiusbottom style=\"background:#ffffff;border-bottom: #cccccc 1px solid;border-right: #cccccc 1px solid;border-left: #cccccc 1px solid;padding:20px\">";

$rs_find_cart_items = "SELECT blockcontract.blockid AS blockid, blockcontract.blocktitle AS blocktitle, blockcontract.contractclosed AS bcactive, 
blockcontract.hourscache AS hourscache, blockcontract.pcgroupid AS pcgroupid, pc_group.pcgroupname AS groupname
FROM blockcontract,pc_group WHERE blockcontract.pcgroupid = pc_group.pcgroupid AND blockcontract.contractclosed = '0'
ORDER BY blockcontract.hourscache ASC LIMIT 10";

$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

echo "<table class=\"standard lastalignright\">";
while($rs_result_q = mysqli_fetch_object($rs_result)) {
$blockid = "$rs_result_q->blockid";
$blocktitle = "$rs_result_q->blocktitle";
$groupname = "$rs_result_q->groupname";
$bcactive2 = "$rs_result_q->bcactive";
$pcgroupid = "$rs_result_q->pcgroupid";
$hourscache = "$rs_result_q->hourscache";

if($hourscache > 0) {
echo "<tr><td>$groupname</td><td><a href=\"../repair/group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=blockcontract\" class=\"linkbuttongray linkbuttontiny radiusall\">$blocktitle</a></td><td>$hourscache</td></tr>";
} else {
echo "<tr><td>$groupname</td><td><a href=\"../repair/group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=blockcontract\" class=\"linkbuttongray linkbuttontiny radiusall\">$blocktitle</a></td><td><span class=colormered>$hourscache</span></td></tr>";
}
}
echo "</table>";

echo "</div>";
echo "</td>";

echo "</tr></table>";


require("footer.php"); 
?>
