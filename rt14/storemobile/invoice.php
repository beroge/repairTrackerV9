<?php
                                                                                                    
/***************************************************************************
 *   copyright            : (C) 2019 PCRepairTracker.com
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
require_once("header.php");
require("deps.php");

if ($gomodal == 1) {
$therel = "rel=facebox";
} else {
$therel = "";
}


if (!isset($invoiceoverduedays)) {
$invoiceoverduedays = 21;
}






echo "<div data-role=\"navbar\">";
echo "<ul>";
echo "<li><a href=\"invoice.php\" class=\"ui-btn-active\">".pcrtlang("Open Invoices")."</a></li>";
echo "<li><a href=\"invoice.php?func=allinvoices\">".pcrtlang("Browse All Invoices")."</a></li>";
echo "</ul>";
echo "</div>";
echo "<div data-role=\"navbar\">";
echo "<ul>";
echo "<li><a href=\"invoice.php?func=browsequotes\">".pcrtlang("Quotes")."</a></li>";
echo "<li><a href=\"invoice.php?func=recurringinvoices\">".pcrtlang("Recurring Invoices")."</a></li>";
echo "</ul>";
echo "</div>";

$overduedeposittotal = 0;
$currentdeposittotal = 0;

echo "<br><form action=\"invoice.php\" method=POST data-ajax=\"false\">";
$rs_invoices = "SELECT * FROM invoices WHERE iorq != 'quote' AND duedate < NOW() AND invstatus = '1' ORDER BY invdate ASC";
$rs_find_invoices = @mysqli_query($rs_connect, $rs_invoices);
$totalinv = mysqli_num_rows($rs_find_invoices);
if ($totalinv != "0") {

start_status_box("53",pcrtlang("Overdue Invoices - Days Overdue").": (+$invoiceoverduedays)");
#echo "<table border=0 cellspacing=3 cellpadding=2>";
#echo "<tr class=\"troweven\"><td colspan=2><font class=text12b>".pcrtlang("Inv")."#&nbsp;&nbsp;</font></td><td><font class=text12b>".pcrtlang("Customer Name")."&nbsp;&nbsp;</font></td>";
#if ($activestorecount > 1) {
#echo "<td><font class=text12b>".pcrtlang("Store")."</font></td>";
#}


#echo "<td><font class=text12b>".pcrtlang("Invoice Date")."&nbsp;&nbsp;</font></td>";
#echo "<td><font class=text12b> ".pcrtlang("Total")." </font>&nbsp;&nbsp;</td><td><font class=text12b>".pcrtlang("Actions")."</font>&nbsp;&nbsp;</td></tr>";
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
$invstoreid = "$rs_find_invoices_q->storeid";
$pcgroupid = "$rs_find_invoices_q->pcgroupid";

$storeinfoarray = getstoreinfo($invstoreid);

$chkinvoicesql = "SELECT * FROM userlog WHERE reftype = 'invoiceid' AND refid = '$invoice_id' AND actionid = '15'";
$chkinvoice = mysqli_num_rows(mysqli_query($rs_connect, $chkinvoicesql));

$invname_ue = urlencode($invname);
$invcompany_ue = urlencode($invcompany);
$invemail_ue = urlencode($invemail);
$invphone_ue = urlencode($invphone);
$invaddy1_ue = urlencode($invaddy1);
$invaddy2_ue = urlencode($invaddy2);
$invcity_ue = urlencode($invcity);
$invstate_ue = urlencode($invstate);
$invzip_ue = urlencode($invzip);

$invwoid = "$rs_find_invoices_q->woid";
$pcgroupid = "$rs_find_invoices_q->pcgroupid";
$invrec = "$rs_find_invoices_q->receipt_id";
$invdate = "$rs_find_invoices_q->invdate";
$invdate2 = pcrtdate("$pcrt_longdate", "$invdate");
$findinvtotal = "SELECT SUM(cart_price) AS invsubtotal, SUM(itemtax) AS invtax FROM invoice_items WHERE invoice_id = '$invoice_id'";
$findinvq = @mysqli_query($rs_connect, $findinvtotal);
$findinva = mysqli_fetch_object($findinvq);
$invtax = "$findinva->invtax";
$invsubtotal = "$findinva->invsubtotal";
$invtotal2 = $invtax + $invsubtotal;


$invtotal = number_format($invtotal2, 2, '.', '');
echo "<table class=standard><tr><th><label>";

echo "<input type=checkbox name=invoice_id[] value=\"$invoice_id\">";

if ($invemail == "") {
echo "<i class=\"fa fa-envelope\" style=\"color:#ff0000\"></i>";
}

echo " $invoice_id $invname</label></th>";

echo "<th style=\"text-align:right;\">$money".mf("$invtotal");


$finddeposits = "SELECT SUM(amount) AS deposittotal FROM deposits WHERE invoiceid = '$invoice_id'";
$finddepositsq = @mysqli_query($rs_connect, $finddeposits);
$finddepositsa = mysqli_fetch_object($finddepositsq);
$deposittotal = mf("$finddepositsa->deposittotal");
$depositbalance = mf($invtotal - $deposittotal);

if($deposittotal > 0) {
echo "<br><span class=colormegreen>$money$deposittotal</span>";
echo "<br><span class=colormered>$money$depositbalance</span>";
}



echo "</th></tr>";

if("$invcompany" != "") {
echo "<tr><td colspan=2>$invcompany</td></tr>";
}


if ($activestorecount > 1) {
echo "<tr><td colspan=2>".pcrtlang("Store").": $storeinfoarray[storesname]</td></tr>";
}

echo "<tr><td colspan=2>".pcrtlang("Invoice Date").": $invdate2</td></tr>";
echo "<tr><td colspan=2>";

echo "<div data-role=\"collapsible\" data-mini=\"true\">";
echo "<h3>".pcrtlang("Invoice Actions")."</h3>";

echo "<button type=button onClick=\"parent.location='invoice.php?func=printinv&invoice_id=$invoice_id'\" data-mini=\"true\"><i class=\"fa fa-print\"></i> ".pcrtlang("Print")."</button>";
echo "<button type=button onClick=\"parent.location='invoice.php?func=emailinv2&invoice_id=$invoice_id&emailaddy=$invemail'\" data-mini=\"true\"><i class=\"fa fa-envelope\"></i> ".pcrtlang("Email");

if ($chkinvoice >= 1) {
echo " <i class=\"fa fa-check-circle fa-lg\"></i>";
}

echo "</button>";

$returnurl12 = urlencode("../storemobile/invoice.php");

echo "<button type=button onClick=\"parent.location='invoice.php?func=editinvoice&invoice_id=$invoice_id&returnurl=$returnurl12'\" data-mini=\"true\"><i class=\"fa fa-edit\"></i> ".pcrtlang("Edit")."</button> ";
if ($invstatus == "1") {

echo "<button type=button onClick=\"parent.location='invoice.php?func=checkoutinv&invoice_id=$invoice_id&woid=$invwoid&custname=$invname_ue&company=$invcompany_ue&custaddy1=$invaddy1_ue&custaddy2=$invaddy2_ue&custcity=$invcity_ue&custstate=$invstate_ue&custzip=$invzip_ue&custphone=$invphone_ue&custemail=$invemail_ue&pcgroupid=$pcgroupid'\" data-mini=\"true\"><i class=\"fa fa-shopping-cart\"></i> ".pcrtlang("Checkout/Edit Items")."</button>";

if($depositbalance > 0) {
echo "<button type=button onClick=\"parent.location='deposits.php?invoiceid=$invoice_id&cfirstname=$invname_ue&ccompany=$invcompany_ue&caddress=$invaddy1_ue&caddress2=$invaddy2_ue&ccity=$invcity_ue&cstate=$invstate_ue&czip=$invzip_ue&cphone=$invphone_ue&cemail=$invemail&depamount=$depositbalance'\" data-mini=\"true\"><i class=\"fa fa-money\"></i> ".pcrtlang("Add Deposit")."</button>";
}


echo "<button type=button onClick=\"parent.location='invoice.php?func=changeinvoicestatus&invstatus=3&invoice_id=$invoice_id'\"  onClick=\"return confirm('".pcrtlang("Are you sure you wish to void this invoice?")."');\" data-mini=\"true\"><i class=\"fa fa-ban\"></i> ".pcrtlang("Void")."</button> ";
echo "<button type=button onClick=\"parent.location='invoice.php?func=changeinvoicestatus&invstatus=2&invoice_id=$invoice_id'\"  onClick=\"return confirm('".pcrtlang("Are you sure you wish to close this invoice?  Usually you want to checkout an invoice so that the invoice gets marked as paid.")."');\" data-mini=\"true\"><i class=\"fa fa-square\"></i> ".pcrtlang("Close")."</button>";
} else {
echo "<button type=button onClick=\"parent.location='invoice.php?func=changeinvoicestatus&invstatus=1&invoice_id=$invoice_id'\"  onClick=\"return confirm('".pcrtlang("Are you sure you wish to re-open this invoice?")."');\" data-mini=\"true\"><i class=\"fa fa-retweet\"></i> ".pcrtlang("Re-Open this Invoice")."</button> ";
}

if ($invwoid != "") {
echo "<div data-role=\"collapsible\" data-theme=\"a\" data-mini=\"true\">";
echo "<h3>".pcrtlang("Work Orders").":</h3>";
$rs_invwoids = explode_list($invwoid);
foreach($rs_invwoids as $key => $rs_invwoidids) {
echo "<button type=button onClick=\"parent.location='../repairmobile/pc.php?func=view&woid=$rs_invwoidids'\" data-mini=\"true\">#$rs_invwoidids </button>";
}
echo "</div>";
}

$groupidmatch = groupbyinvoice($invoice_id);
if($groupidmatch != 0) {
echo "<button type=button onClick=\"parent.location='../repairmobile/group.php?func=viewgroup&pcgroupid=$groupidmatch&groupview=invoices'\"><i class=\"fa fa-group fa-lg\"></i> ".pcrtlang("Group")." #$groupidmatch </button>";
}



if($invrec != "0") {
echo "<button type=button onClick=\"parent.location='receipt.php?func=show_receipt&receipt=$invrec'\" data-mini=\"true\">".pcrtlang("View Receipt")." #$invrec</button>";
}
echo "</div></td></tr></table><br>";
}


$findinvtotalov = "SELECT SUM(invoice_items.cart_price) AS invsubtotal, SUM(invoice_items.itemtax) AS invtax FROM invoices,invoice_items WHERE invoices.iorq != 'quote' 
AND invoices.duedate < NOW() AND invoices.invstatus = '1' AND invoices.invoice_id = invoice_items.invoice_id";
$findinvqov = @mysqli_query($rs_connect, $findinvtotalov);
$findinvaov = mysqli_fetch_object($findinvqov);
$invtaxov = "$findinvaov->invtax";
$invsubtotalov = "$findinvaov->invsubtotal";
$invtotal2ov = $invtaxov + $invsubtotalov;
$invtotalov = number_format($invtotal2ov, 2, '.', '');


echo "<center><h3>".pcrtlang("Overdue Invoice Totals").": $money".mf("$invtotalov")."</h3></center>";

echo "<center><h3>".pcrtlang("Deposit Totals").": $money".mf("$overduedeposittotal")."</h3></center>";

$overduebalancedeposittotal = $invtotalov - $overduedeposittotal;

echo "<center></h3>".pcrtlang("Balance").": $money".mf("$overduebalancedeposittotal")."</h3></center>";



}


echo "<br><br><br>";

$rs_invoices = "SELECT * FROM invoices WHERE iorq != 'quote' AND duedate > NOW() AND invstatus = '1' ORDER BY invdate ASC";
$rs_find_invoices = @mysqli_query($rs_connect, $rs_invoices);
$totalinv = mysqli_num_rows($rs_find_invoices);
if ($totalinv != "0") {

start_status_box("52",pcrtlang("Current Open Invoices"));


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
$invstoreid = "$rs_find_invoices_q->storeid";
$pcgroupid = "$rs_find_invoices_q->pcgroupid";

$storeinfoarray = getstoreinfo($invstoreid);

$chkinvoicesql = "SELECT * FROM userlog WHERE reftype = 'invoiceid' AND refid = '$invoice_id' AND actionid = '15'";
$chkinvoice = mysqli_num_rows(mysqli_query($rs_connect, $chkinvoicesql));

$invname_ue = urlencode($invname);
$invcompany_ue = urlencode($invcompany);
$invemail_ue = urlencode($invemail);
$invphone_ue = urlencode($invphone);
$invaddy1_ue = urlencode($invaddy1);
$invaddy2_ue = urlencode($invaddy2);
$invcity_ue = urlencode($invcity);
$invstate_ue = urlencode($invstate);
$invzip_ue = urlencode($invzip);

$invwoid = "$rs_find_invoices_q->woid";
$pcgroupid = "$rs_find_invoices_q->pcgroupid";
$invrec = "$rs_find_invoices_q->receipt_id";
$invdate = "$rs_find_invoices_q->invdate";
$invdate2 = pcrtdate("$pcrt_longdate", "$invdate");
$findinvtotal = "SELECT SUM(cart_price) AS invsubtotal, SUM(itemtax) AS invtax FROM invoice_items WHERE invoice_id = '$invoice_id'";
$findinvq = @mysqli_query($rs_connect, $findinvtotal);
$findinva = mysqli_fetch_object($findinvq);
$invtax = "$findinva->invtax";
$invsubtotal = "$findinva->invsubtotal";
$invtotal2 = $invtax + $invsubtotal;
$invtotal = number_format($invtotal2, 2, '.', '');
echo "<table class=standard><tr><th>";

echo "<label><input type=checkbox name=invoice_id[] value=\"$invoice_id\">";


if ($invemail == "") {
echo "<i class=\"fa fa-envelope\" style=\"color:#ff0000\"></i>";
}


echo " $invoice_id $invname</label></th><th style=\"text-align:right\">$money".mf("$invtotal");


$finddeposits = "SELECT SUM(amount) AS deposittotal FROM deposits WHERE invoiceid = '$invoice_id'";
$finddepositsq = @mysqli_query($rs_connect, $finddeposits);
$finddepositsa = mysqli_fetch_object($finddepositsq);
$deposittotal = mf("$finddepositsa->deposittotal");
$depositbalance = mf($invtotal - $deposittotal);

if($deposittotal > 0) {
echo "<br><span class=colormegreen>$money$deposittotal</span>";
echo "<br><span class=colormered>$money$depositbalance</span>";
}


echo "</th></tr>";



if("$invcompany" != "") {
echo "<tr><td colspan=2>$invcompany</td></tr>";
}


if ($activestorecount > 1) {
echo "<tr><td colspan=2>".pcrtlang("Store").": $storeinfoarray[storesname]</td></tr>";
}

echo "<tr><td colspan=2>".pcrtlang("Invoice Date").": $invdate2</td></tr>";
echo "<tr><td colspan=2>";

echo "<div data-role=\"collapsible\" data-mini=\"true\">";
echo "<h3>".pcrtlang("Invoice Actions")."</h3>";

echo "<button type=button onClick=\"parent.location='invoice.php?func=printinv&invoice_id=$invoice_id'\" data-mini=\"true\"><i class=\"fa fa-print\"></i> Print</button>";
echo "<button type=button onClick=\"parent.location='invoice.php?func=emailinv2&invoice_id=$invoice_id&emailaddy=$invemail'\" data-mini=\"true\"><i class=\"fa fa-envelope\"></i> ".pcrtlang("Email");

if ($chkinvoice >= 1) {
echo " <i class=\"fa fa-check-circle\"></i>";
}


echo "</button>";

$returnurl12 = urlencode("../storemobile/invoice.php");

echo "<button type=button onClick=\"parent.location='invoice.php?func=editinvoice&invoice_id=$invoice_id&returnurl=$returnurl12'\" data-mini=\"true\"><i class=\"fa fa-edit\"></i> ".pcrtlang("Edit")."</button> ";
if ($invstatus == "1") {
echo "<button type=button onClick=\"parent.location='invoice.php?func=checkoutinv&invoice_id=$invoice_id&woid=$invwoid&custname=$invname_ue&company=$invcompany_ue&custaddy1=$invaddy1_ue&custaddy2=$invaddy2_ue&custcity=$invcity_ue&custstate=$invstate_ue&custzip=$invzip_ue&custphone=$invphone_ue&custemail=$invemail_ue&pcgroupid=$pcgroupid'\" data-mini=\"true\"><i class=\"fa fa-shopping-cart\"></i> ".pcrtlang("Checkout/Edit Items")."</button> ";

if($depositbalance > 0) {
echo "<button type=button onClick=\"parent.location='deposits.php?invoiceid=$invoice_id&cfirstname=$invname_ue&ccompany=$invcompany_ue&caddress=$invaddy1_ue&caddress2=$invaddy2_ue&ccity=$invcity_ue&cstate=$invstate_ue&czip=$invzip_ue&cphone=$invphone_ue&cemail=$invemail&depamount=$depositbalance'\" data-mini=\"true\"><i class=\"fa fa-money\"></i> ".pcrtlang("Add Deposit")."</button>";
}


echo "<button type=button onClick=\"parent.location='invoice.php?func=changeinvoicestatus&invstatus=3&invoice_id=$invoice_id'\"  onClick=\"return confirm('".pcrtlang("Are you sure you wish to void this invoice?")."');\" data-mini=\"true\"><i class=\"fa fa-ban\"></i> ".pcrtlang("Void")."</button> ";
echo "<button type=button onClick=\"parent.location='invoice.php?func=changeinvoicestatus&invstatus=2&invoice_id=$invoice_id'\"  onClick=\"return confirm('".pcrtlang("Are you sure you wish to close this invoice? Usually you want to checkout an invoice so that the invoice gets marked as paid.")."');\" data-mini=\"true\"><i class=\"fa fa-square\"></i> ".pcrtlang("Close")."</button>";
} else {
echo "<button type=button onClick=\"parent.location='invoice.php?func=changeinvoicestatus&invstatus=1&invoice_id=$invoice_id'\"  onClick=\"return confirm('".pcrtlang("Are you sure you wish to re-open this invoice?")."');\" data-mini=\"true\"><i class=\"fa fa-retweet\"></i> ".pcrtlang("Re-Open this Invoice")."</button> ";
}

if (perm_check("15")) {

echo "<a href=\"#popupdeleteinv$invoice_id\" data-rel=\"popup\" data-position-to=\"window\" data-transition=\"pop\" class=\"ui-btn ui-shadow ui-corner-all\">";
echo "<i class=\"fa fa-trash\"></i> ".pcrtlang("Delete Invoice")."</a>";
echo "<div data-role=\"popup\" id=\"popupdeleteinv$invoice_id\" data-overlay-theme=\"b\"  data-theme=\"a\" data-dismissible=\"false\">";
echo "<div data-role=\"header\" data-theme=\"b\">";
echo "<h1>".pcrtlang("Delete Invoice")."?</h1>";
echo "</div>";
echo "<div role=\"main\" class=\"ui-content\">";
echo "<p>".pcrtlang("Are you sure you wish to permanently delete this Invoice!!!?")."</p>";
echo "<div align=\"right\"><a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\" data-inline=\"true\"><i class=\"fa fa-ban fa-lg\"></i> ".pcrtlang("Cancel")."</a>";
echo "<button onClick=\"parent.location='invoice.php?func=deleteinvoice&invstatus=2&invoice_id=$invoice_id'\" data-inline=\"true\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")." </button></div>";
echo "</div>";
echo "</div>";


}


if ($invwoid != "") {
echo "<div data-role=\"collapsible\" data-theme=\"a\" data-mini=\"true\">";
echo "<h3>".pcrtlang("Work Orders").":</h3>";
$rs_invwoids = explode_list($invwoid);
foreach($rs_invwoids as $key => $rs_invwoidids) {
echo "<button type=button onClick=\"parent.location='../repairmobile/pc.php?func=view&woid=$rs_invwoidids'\" data-mini=\"true\">#$rs_invwoidids</button>";
}
echo "</div>";
}

if ($pcgroupid != "0") {
echo "<button type=button onClick=\"parent.location='../repairmobile/group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=invoices'\"><i class=\"fa fa-group fa-lg\"></i> ".pcrtlang("Group")." #$pcgroupid </button>";
}



if($invrec != "0") {
echo "<button type=button onClick=\"parent.location='receipt.php?func=show_receipt&receipt=$invrec'\" data-mini=\"true\">".pcrtlang("View Receipt")." #$invrec</button>";
}
echo "</div></td></tr></table><br>";
}


$findinvtotalo = "SELECT SUM(invoice_items.cart_price) AS invsubtotal, SUM(invoice_items.itemtax) AS invtax FROM invoices,invoice_items WHERE invoices.iorq != 'quote'
AND invoices.duedate > NOW() AND invoices.invstatus = '1' AND invoices.invoice_id = invoice_items.invoice_id";
$findinvqo = @mysqli_query($rs_connect, $findinvtotalo);
$findinvao = mysqli_fetch_object($findinvqo);
$invtaxo = "$findinvao->invtax";
$invsubtotalo = "$findinvao->invsubtotal";
$invtotal2o = $invtaxo + $invsubtotalo;
$invtotalo = number_format($invtotal2o, 2, '.', '');



echo "<center><h3>".pcrtlang("Open Invoice Totals").": $money".mf("$invtotalo")."</h3></center>";

echo "<h3><center>".pcrtlang("Deposit Totals").": $money".mf("$currentdeposittotal")."</h3></center>";

$balancedeposittotal = $invtotalo - $currentdeposittotal;

echo "<h3><center>".pcrtlang("Balance").": $money".mf("$balancedeposittotal")."</h3></center>";

echo "<br>";

}

echo "<table class=standard><tr><th>".pcrtlang("Multiple Invoice Actions").":</th></tr><tr><td><fieldset data-role=\"controlgroup\"><label><input type=radio checked value=emailinv name=func>";
echo pcrtlang("Email")."</label><label><input type=radio value=printinv name=func>".pcrtlang("Print")."</label><label><input type=radio value=checkoutmultipleinv name=func>".pcrtlang("Checkout on One Receipt")."</label></fieldset><br>";
echo "<input type=submit value=\"".pcrtlang("Go")."\"></form>";
echo "<i class=\"fa fa-envelope\" style=\"color:#ff0000\"></i> ".pcrtlang("red envelopes do not have an email address specified on the invoice");
echo "</td></tr></table><br><br>";

echo "<table class=standard><tr><th>".pcrtlang("Print Range of Invoices").":</th></tr><tr><td>";
echo "<form action=\"invoice.php?func=printmultinv\" method=post>";
echo pcrtlang("Invoice Number From").":<input type=text name=invfrom>".pcrtlang("Invoice Number To").":";
echo "<input type=text name=invto><input type=submit value=\"".pcrtlang("Print")."\"></form>";
echo "</td></tr></table>";
echo "<br><br>";





require_once("footer.php");
                                                                                                    
}

##########

function allinvoices() {
require_once("header.php");
require("deps.php");

if (array_key_exists('pageNumber',$_REQUEST)) {
$pageNumber = $_REQUEST['pageNumber'];
} else {
$pageNumber = 1;
}

$results_per_page = 40;

$offset = ($pageNumber * $results_per_page) - $results_per_page;







echo "<div data-role=\"navbar\">";
echo "<ul>";
echo "<li><a href=\"invoice.php\">".pcrtlang("Open Invoices")."</a></li>";
echo "<li><a href=\"invoice.php?func=allinvoices\" class=\"ui-btn-active\">".pcrtlang("Browse All Invoices")."</a></li>";
echo "</ul>";
echo "</div>";
echo "<div data-role=\"navbar\">";
echo "<ul>";
echo "<li><a href=\"invoice.php?func=browsequotes\">".pcrtlang("Quotes")."</a></li>";
echo "<li><a href=\"invoice.php?func=recurringinvoices\">".pcrtlang("Recurring Invoices")."</a></li>";
echo "</ul>";
echo "</div><br><br>";



start_status_box("52",pcrtlang("All Invoices"));
echo "<form action=\"invoice.php\" method=POST  data-ajax=\"false\">";


$rs_invoicest = "SELECT * FROM invoices WHERE iorq != 'quote'";
$rs_find_invoicest = @mysqli_query($rs_connect, $rs_invoicest);


$rs_invoices = "SELECT * FROM invoices WHERE iorq != 'quote' ORDER BY invdate DESC LIMIT $offset,$results_per_page";
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
$pcgroupid = "$rs_find_invoices_q->pcgroupid";
$invrec = "$rs_find_invoices_q->receipt_id";
$invdate = "$rs_find_invoices_q->invdate";
$invdate2 = pcrtdate("$pcrt_longdate", "$invdate");
$invstoreid = "$rs_find_invoices_q->storeid";
$pcgroupid = "$rs_find_invoices_q->pcgroupid";

$invname_ue = urlencode($invname);
$invcompany_ue = urlencode($invcompany);
$invemail_ue = urlencode($invemail);
$invphone_ue = urlencode($invphone);
$invaddy1_ue = urlencode($invaddy1);
$invaddy2_ue = urlencode($invaddy2);
$invcity_ue = urlencode($invcity);
$invstate_ue = urlencode($invstate);
$invzip_ue = urlencode($invzip);

$chkinvoicesql = "SELECT * FROM userlog WHERE reftype = 'invoiceid' AND refid = '$invoice_id' AND actionid = '15'";
$chkinvoice = mysqli_num_rows(mysqli_query($rs_connect, $chkinvoicesql));

$storeinfoarray = getstoreinfo($invstoreid);

$findinvtotal = "SELECT SUM(cart_price) AS invsubtotal, SUM(itemtax) AS invtax FROM invoice_items WHERE invoice_id = '$invoice_id'";
$findinvq = @mysqli_query($rs_connect, $findinvtotal);
$findinva = mysqli_fetch_object($findinvq);
$invtax = "$findinva->invtax";
$invsubtotal = "$findinva->invsubtotal";
$invtotal2 = $invtax + $invsubtotal;
$invtotal = number_format($invtotal2, 2, '.', '');


if ($invstatus == 1) {
$thestatus = pcrtlang("Open");
} elseif ($invstatus == 2) {
$thestatus = pcrtlang("Closed/Paid");
} else {
$thestatus = pcrtlang("Voided");
}


echo "<table class=standard><tr><th><label>";

echo "<input type=checkbox name=invoice_id[] value=\"$invoice_id\">";

if ($invemail == "") {
echo "<i class=\"fa fa-envelope\" style=\"color:#ff0000\"></i>";
}

echo " $invoice_id $invname</label></th>";

echo "<th style=\"text-align:right;\">$money".mf("$invtotal")."</th></tr>";

if("$invcompany" != "") {
echo "<tr><td colspan=2>$invcompany</td></tr>";
}


if ($activestorecount > 1) {
echo "<tr><td colspan=2>".pcrtlang("Store").": $storeinfoarray[storesname]</td></tr>";
}

echo "<tr><td colspan=2>".pcrtlang("Invoice Date").": $invdate2</td></tr>";

echo "<tr><td colspan=2>".pcrtlang("Status").": $thestatus</td></tr>";

echo "<tr><td colspan=2>";

echo "<div data-role=\"collapsible\" data-mini=\"true\">";
echo "<h3>".pcrtlang("Invoice Actions")."</h3>";

echo "<button type=button onClick=\"parent.location='invoice.php?func=printinv&invoice_id=$invoice_id'\" data-mini=\"true\"><i class=\"fa fa-print\"></i> ".pcrtlang("Print")."</button>";
echo "<button type=button onClick=\"parent.location='invoice.php?func=emailinv2&invoice_id=$invoice_id&emailaddy=$invemail'\" data-mini=\"true\"><i class=\"fa fa-envelope\"></i> ".pcrtlang("Email");

if ($chkinvoice >= 1) {
echo " <i class=\"fa fa-check-circle fa-lg\"></i>";
}

echo "</button>";

$returnurl12 = urlencode("../storemobile/invoice.php");

echo "<button type=button onClick=\"parent.location='invoice.php?func=editinvoice&invoice_id=$invoice_id&returnurl=$returnurl12'\" data-mini=\"true\"><i class=\"fa fa-edit\"></i> ".pcrtlang("Edit")."</button> ";
if ($invstatus == "1") {

echo "<button type=button onClick=\"parent.location='invoice.php?func=checkoutinv&invoice_id=$invoice_id&woid=$invwoid&custname=$invname_ue&company=$invcompany_ue&custaddy1=$invaddy1_ue&custaddy2=$invaddy2_ue&custcity=$invcity_ue&custstate=$invstate_ue&custzip=$invzip_ue&custphone=$invphone_ue&custemail=$invemail_ue&pcgroupid=$pcgroupid'\" data-mini=\"true\"><i class=\"fa fa-shopping-cart\"></i> ".pcrtlang("Checkout/Edit Items")."</button>";
echo "<button type=button onClick=\"parent.location='invoice.php?func=changeinvoicestatus&invstatus=3&invoice_id=$invoice_id'\"  onClick=\"return confirm('".pcrtlang("Are you sure you wish to void this invoice?")."');\" data-mini=\"true\"><i class=\"fa fa-ban\"></i> ".pcrtlang("Void")."</button> ";
echo "<button type=button onClick=\"parent.location='invoice.php?func=changeinvoicestatus&invstatus=2&invoice_id=$invoice_id'\"  onClick=\"return confirm('".pcrtlang("Are you sure you wish to close this invoice?  Usually you want to checkout an invoice so that the invoice gets marked as paid.")."');\" data-mini=\"true\"><i class=\"fa fa-square\"></i> ".pcrtlang("Close")."</button>";
} else {
echo "<button type=button onClick=\"parent.location='invoice.php?func=changeinvoicestatus&invstatus=1&invoice_id=$invoice_id'\"  onClick=\"return confirm('".pcrtlang("Are you sure you wish to re-open this invoice?")."');\" data-mini=\"true\"><i class=\"fa fa-retweet\"></i> ".pcrtlang("Re-Open this Invoice")."</button> ";
}

if ($invwoid != "") {
echo "<div data-role=\"collapsible\" data-theme=\"a\" data-mini=\"true\">";
echo "<h3>".pcrtlang("Work Orders").":</h3>";
$rs_invwoids = explode_list($invwoid);
foreach($rs_invwoids as $key => $rs_invwoidids) {
echo "<button type=button onClick=\"parent.location='../repairmobile/pc.php?func=view&woid=$rs_invwoidids'\" data-mini=\"true\">#$rs_invwoidids </button>";
}
echo "</div>";
}

$groupidmatch = groupbyinvoice($invoice_id);
if($groupidmatch != 0) {
echo "<button type=button onClick=\"parent.location='../repairmobile/group.php?func=viewgroup&pcgroupid=$groupidmatch&groupview=invoices'\"><i class=\"fa fa-group fa-lg\"></i> ".pcrtlang("Group")." #$groupidmatch </button>";
}


if($invrec != "0") {
echo "<button type=button onClick=\"parent.location='receipt.php?func=show_receipt&receipt=$invrec'\" data-mini=\"true\">".pcrtlang("View Receipt")." #$invrec</button>";
}
echo "</div></td></tr></table><br>";
}



echo "<br><center>";

#browse here
$totalentry = mysqli_num_rows($rs_find_invoicest);
$prevpage = $pageNumber - 1;
$nextpage = $pageNumber + 1;

if ($pageNumber > 1) {
echo "<button type=button onClick=\"parent.location='invoice.php?func=allinvoices&pageNumber=$prevpage'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\">";
echo "<i class=\"fa fa-chevron-left fa-lg\"></i></button>";
}

$total_results = $totalentry;
$results_per_page = $results_per_page;
$html = get_paged_nav($total_results, $results_per_page, false);
echo "$html";
if (($totalentry / $results_per_page) > $pageNumber) {
echo "<button type=button onClick=\"parent.location='invoice.php?func=allinvoices&pageNumber=$nextpage'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\">";
echo "<i class=\"fa fa-chevron-right fa-lg\"></i></button>";
}

echo "</center>";

echo "<br><br>";
echo "<table class=standard><tr><th>".pcrtlang("Email/Print Multiple Invoices").":</th></tr><tr><td>";
echo "<fieldset data-role=\"controlgroup\"><label><input type=radio checked value=emailinv name=func>";
echo pcrtlang("Email")."</label><label><input type=radio value=printinv name=func>".pcrtlang("Print")."</label></fieldset>";
echo "<input type=hidden value=\"invoice.php?func=allinvoices&pageNumber=$pageNumber\" name=returnurl><input type=submit value=\"".pcrtlang("Email/Print")."\"></form>";
echo "<i class=\"fa fa-envelope\" style=\"color:#ff0000\"></i> ".pcrtlang("red envelopes do not have an email address specified on the invoice");
echo "</td></tr></table>";

echo "<br>";
echo "<table class=standard><tr><th>".pcrtlang("Print Range of Invoices").":</th></tr><tr><td>";
echo "<form action=\"invoice.php?func=printmultinv\" method=post><input type=hidden value=\"invoice.php?func=allinvoices&pageNumber=$pageNumber\" name=returnurl>";
echo pcrtlang("Invoice Number From").":<input type=text name=invfrom>".pcrtlang("Invoice Number To").":";
echo "<input type=text class=textbox name=invto><input type=submit class=button value=\"".pcrtlang("Print")."\"></form>";
echo "</td></tr></table>";
echo "<br><br>";

require_once("footer.php");

}




##########

function browsequotes() {
require_once("header.php");
require("deps.php");

if (array_key_exists('pageNumber',$_REQUEST)) {
$pageNumber = $_REQUEST[pageNumber];
} else {
$pageNumber = 1;
}

$results_per_page = 40;

$offset = ($pageNumber * $results_per_page) - $results_per_page;







echo "<div data-role=\"navbar\">";
echo "<ul>";
echo "<li><a href=\"invoice.php\">".pcrtlang("Open Invoices")."</a></li>";
echo "<li><a href=\"invoice.php?func=allinvoices\">".pcrtlang("Browse All Invoices")."</a></li>";
echo "</ul>";
echo "</div>";
echo "<div data-role=\"navbar\">";
echo "<ul>";
echo "<li><a href=\"invoice.php?func=browsequotes\" class=\"ui-btn-active\">".pcrtlang("Quotes")."</a></li>";
echo "<li><a href=\"invoice.php?func=recurringinvoices\">".pcrtlang("Recurring Invoices")."</a></li>";
echo "</ul>";
echo "</div><br><br>";



start_status_box("52",pcrtlang("Quotes"));

$rs_invoicest = "SELECT * FROM invoices WHERE iorq = 'quote'";
$rs_find_invoicest = @mysqli_query($rs_connect, $rs_invoicest);


$rs_invoices = "SELECT * FROM invoices WHERE iorq = 'quote' ORDER BY invdate DESC LIMIT $offset,$results_per_page";
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
$pcgroupid = "$rs_find_invoices_q->pcgroupid";
$invrec = "$rs_find_invoices_q->receipt_id";
$invdate = "$rs_find_invoices_q->invdate";
$invdate2 = pcrtdate("$pcrt_longdate", "$invdate");
$invstoreid = "$rs_find_invoices_q->storeid";

$invname_ue = urlencode($invname);
$invcompany_ue = urlencode($invcompany);
$invemail_ue = urlencode($invemail);
$invphone_ue = urlencode($invphone);
$invaddy1_ue = urlencode($invaddy1);
$invaddy2_ue = urlencode($invaddy2);
$invcity_ue = urlencode($invcity);
$invstate_ue = urlencode($invstate);
$invzip_ue = urlencode($invzip);



$storeinfoarray = getstoreinfo($invstoreid);

$findinvtotal = "SELECT SUM(cart_price) AS invsubtotal, SUM(itemtax) AS invtax FROM invoice_items WHERE invoice_id = '$invoice_id'";
$findinvq = @mysqli_query($rs_connect, $findinvtotal);
$findinva = mysqli_fetch_object($findinvq);
$invtax = "$findinva->invtax";
$invsubtotal = "$findinva->invsubtotal";
$invtotal2 = $invtax + $invsubtotal;
$invtotal = number_format($invtotal2, 2, '.', '');


echo "<table class=standard><tr><th>";



echo " $invoice_id $invname</th>";

echo "<th style=\"text-align:right;\">$money".mf("$invtotal")."</th></tr>";

if("$invcompany" != "") {
echo "<tr><td colspan=2>$invcompany</td></tr>";
}


if ($activestorecount > 1) {
echo "<tr><td colspan=2>".pcrtlang("Store").": $storeinfoarray[storesname]</td></tr>";
}

echo "<tr><td colspan=2>".pcrtlang("Quote Date").": $invdate2</td></tr>";
echo "<tr><td colspan=2>";

echo "<div data-role=\"collapsible\" data-theme=\"a\" data-mini=\"true\">";
echo "<h3>".pcrtlang("Quote Actions")."</h3>";



$returnurl12 = urlencode("../storemobile/invoice.php?func=browsequotes");

echo "<button type=button onClick=\"parent.location='invoice.php?func=printinv&invoice_id=$invoice_id'\" data-mini=\"true\"><i class=\"fa fa-print\"></i> ".pcrtlang("Print")."</button>";
echo "<button type=button onClick=\"parent.location='invoice.php?func=emailinv2&invoice_id=$invoice_id&emailaddy=$invemail'\" data-mini=\"true\"><i class=\"fa fa-envelope\"></i> ".pcrtlang("Email")."</button>";


echo "<button type=button onClick=\"parent.location='invoice.php?func=editinvoice&invoice_id=$invoice_id&returnurl=$returnurl12'\" data-mini=\"true\"><i class=\"fa fa-edit\"></i> ".pcrtlang("Edit Quote")."</button> ";

echo "<button type=button onClick=\"parent.location='invoice.php?func=checkoutinv&invoice_id=$invoice_id&woid=$invwoid&custname=$invname_ue&company=$invcompany_ue&custaddy1=$invaddy1_ue&custaddy2=$invaddy2_ue&custcity=$invcity_ue&custstate=$invstate_ue&custzip=$invzip_ue&custphone=$invphone_ue&custemail=$invemail_ue&pcgroupid=$pcgroupid'\" data-mini=\"true\"><i class=\"fa fa-shopping-cart\"></i> ".pcrtlang("Edit Items")."</button>";

echo "<a href=\"#popupdeleteinv$invoice_id\" data-rel=\"popup\" data-position-to=\"window\" data-transition=\"pop\" class=\"ui-btn ui-shadow ui-corner-all\">";
echo "<i class=\"fa fa-trash\"></i> ".pcrtlang("Delete Quote")."</a>";
echo "<div data-role=\"popup\" id=\"popupdeleteinv$invoice_id\" data-overlay-theme=\"b\"  data-theme=\"a\" data-dismissible=\"false\">";
echo "<div data-role=\"header\" data-theme=\"b\">";
echo "<h1>".pcrtlang("Delete Quote")."?</h1>";
echo "</div>";
echo "<div role=\"main\" class=\"ui-content\">";
echo "<p>".pcrtlang("Are you sure you wish to permanently delete this Quote!!!?")."</p>";
echo "<div align=\"right\"><a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\" data-inline=\"true\"><i class=\"fa fa-ban fa-lg\"></i> ".pcrtlang("Cancel")."</a>";
echo "<button onClick=\"parent.location='invoice.php?func=deletequote&invoice_id=$invoice_id'\" data-inline=\"true\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")." </button></div>";
echo "</div>";
echo "</div>";



echo "</div></td></tr></table>";
}



echo "<br><center>";
#browse here
$totalentry = mysqli_num_rows($rs_find_invoicest);
$prevpage = $pageNumber - 1;
$nextpage = $pageNumber + 1;

if ($pageNumber > 1) {
echo "<button type=button onClick=\"parent.location='invoice.php?func=browsequotes&pageNumber=$prevpage'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\">";
echo "<i class=\"fa fa-chevron-left fa-lg\"></i></button>";
}

$total_results = $totalentry;
$results_per_page = $results_per_page;
$html = get_paged_nav($total_results, $results_per_page, false);
echo "$html";
if (($totalentry / $results_per_page) > $pageNumber) {
echo "<button type=button onClick=\"parent.location='invoice.php?func=browsequotes&pageNumber=$nextpage'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\">";
echo "<i class=\"fa fa-chevron-right fa-lg\"></i></button>";
}

echo "</center>";

require_once("footer.php");

}


#######

function searchinvoices() {
require_once("header.php");
require("deps.php");

if (array_key_exists('pageNumber', $_REQUEST)) {
$pageNumber = $_REQUEST['pageNumber'];
} else {
$pageNumber = 1;
}

$searchterm = pv($_REQUEST['searchterm']);

$results_per_page = 40;

$offset = ($pageNumber * $results_per_page) - $results_per_page;






start_box();
echo "<font class=text20b>".pcrtlang("Searched for").": $searchterm</font><br>";
stop_box();
echo "<br>";

start_color_box("52",pcrtlang("Invoices"));
echo "<table border=0 cellspacing=3 cellpadding=2>";
echo "<tr class=troweven><td><font class=text12b>".pcrtlang("Inv")."#&nbsp;&nbsp;</font></td><td><font class=text12b>".pcrtlang("Customer Name")."&nbsp;&nbsp;</font></td><td><font class=text12b>".pcrtlang("Invoice Date")."&nbsp;&nbsp;</font></td>";
echo "<td><font class=text12b> ".pcrtlang("Total")." </font>&nbsp;&nbsp;</td><td><font class=text12b>".pcrtlang("Status")."</font></td><td><font class=text12b>".pcrtlang("Actions")."</font>&nbsp;&nbsp;</td></tr>";

$rs_invoicest = "SELECT * FROM invoices WHERE invoice_id = '$searchterm' OR invname LIKE '%$searchterm%' OR invcompany LIKE '%$searchterm%'";
$rs_find_invoicest = @mysqli_query($rs_connect, $rs_invoicest);


$rs_invoices = "SELECT * FROM invoices WHERE invoice_id = '$searchterm' OR invname LIKE '%$searchterm%' OR invcompany LIKE '%$searchterm%' ORDER BY invdate DESC LIMIT $offset,$results_per_page";
$rs_find_invoices = @mysqli_query($rs_connect, $rs_invoices);
while($rs_find_invoices_q = mysqli_fetch_object($rs_find_invoices)) {
$invoice_id = "$rs_find_invoices_q->invoice_id";
$invname = "$rs_find_invoices_q->invname";
$invcompany = "$rs_find_invoices_q->invcompany";
$invstatus = "$rs_find_invoices_q->invstatus";
$invemail = "$rs_find_invoices_q->invemail";
$invaddy1 = "$rs_find_invoices_q->invaddy1";
$invaddy2 = "$rs_find_invoices_q->invaddy2";
$invcity = "$rs_find_invoices_q->invcity";
$invstate = "$rs_find_invoices_q->invstate";
$invzip = "$rs_find_invoices_q->invzip";
$invphone = "$rs_find_invoices_q->invphone";
$invwoid = "$rs_find_invoices_q->woid";
$pcgroupid = "$rs_find_invoices_q->pcgroupid";
$invrec = "$rs_find_invoices_q->receipt_id";
$invdate = "$rs_find_invoices_q->invdate";
$invdate2 = pcrtdate("$pcrt_longdate", "$invdate");
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
$thestatus = pcrtlang("Open");
} elseif ($invstatus == 2) {
$thestatus = pcrtlang("Closed/Paid");
} else {
$thestatus = pcrtlang("Voided");
}

echo "<tr><td><font class=text12>$invoice_id</font></td><td><font class=text12b>$invname</font>";
if("$invcompany" != "") {
echo "<br><font class=text10>$invcompany</font>";
}

echo "</td><td><font class=text12b>$invdate2</font></td><td><font class=text12b>$money".mf("$invtotal")."</font></td><td><font class=text12>$thestatus</font></td>";
echo "<td><a href=invoice.php?func=printinv&invoice_id=$invoice_id>".pcrtlang("Print")."</a> | ";
echo "<a href=invoice.php?func=emailinv2&invoice_id=$invoice_id&emailaddy=$invemail>".pcrtlang("Email")."</a> ";
if ($invstatus == "1") {
echo "| <a href=invoice.php?func=checkoutinv&invoice_id=$invoice_id&woid=$invwoid&custname=$invname_ue&company=$invcompany_ue&custaddy1=$invaddy1_ue&custaddy2=$invaddy2_ue&custcity=$invcity_ue&custstate=$invstate_ue&custzip=$invzip_ue&custphone=$invphone_ue&custemail=$invemail_ue&pcgroupid=$pcgroupid>".pcrtlang("Checkout/Edit Items")."</a> ";
echo "| <a href=invoice.php?func=changeinvoicestatus&invstatus=3&invoice_id=$invoice_id  onClick=\"return confirm('".pcrtlang("Are you sure you wish to void this invoice?")."');\">".pcrtlang("Void")."</a> ";
echo "| <a href=invoice.php?func=changeinvoicestatus&invstatus=2&invoice_id=$invoice_id  onClick=\"return confirm('".pcrtlang("Are you sure you wish to close this invoice? Usually you want to checkout an invoice so that the invoice gets marked as paid").".');\">".pcrtlang("Close")."</a>";
} else {
echo "| <a href=invoice.php?func=changeinvoicestatus&invstatus=1&invoice_id=$invoice_id  onClick=\"return confirm('".pcrtlang("Are you sure you wish to re-open this invoice?")."');\">".pcrtlang("Re-Open this Invoice")."</a> ";
}

if ($invwoid != "") {
echo "<br><font class=text12>".pcrtlang("Work Orders").":</font> ";
$rs_invwoids = explode_list($invwoid);
foreach($rs_invwoids as $key => $rs_invwoidids) {
echo "<a href=../repairmobile/pc.php?func=view&woid=$rs_invwoidids>#$rs_invwoidids </a>";
}
}


if (($invwoid != "") && ($invrec != "0")) {
echo " | ";
}
if($invrec != "0") {
echo "<a href=receipt.php?func=show_receipt&receipt=$invrec>".pcrtlang("View Receipt")." #$invrec</a>";
}
echo "</td></tr>";
}
echo "</table>";
stop_color_box();


echo "<br>";
start_box();
#browse here
$totalentry = mysqli_num_rows($rs_find_invoicest);
$prevpage = $pageNumber - 1;
$nextpage = $pageNumber + 1;

if ($pageNumber > 1) {
echo "<a href=invoice.php?func=searchinvoices&pageNumber=$prevpage&searchterm=$searchterm><img src=../store/images/left.png border=0 align=absmiddle";
echo " alt=\"".pcrtlang("Show Previous Page")."\"></a>&nbsp;";
}

$total_results = $totalentry;
$results_per_page = $results_per_page;
$html = get_paged_nav($total_results, $results_per_page, false);
echo "$html";
if (($totalentry / $results_per_page) > $pageNumber) {
echo "<a href=invoice.php?func=searchinvoices&pageNumber=$nextpage&searchterm=$searchterm><img src=../store/images/right.png border=0 ";
echo "align=absmiddle alt=\"".pcrtlang("Show Next Page")."\"></a>";
}
stop_box();

echo "<br><br>";


require_once("footer.php");

}



##########

function createinvoice() {

require_once("common.php");
require("dheader.php");



dheader(pcrtlang("Save Invoice/Quote"));

$cfirstname = $_REQUEST['cfirstname'];
$ccompany = $_REQUEST['ccompany'];
$caddress1 = $_REQUEST['caddress1'];
$caddress2 = $_REQUEST['caddress2'];
$ccity = $_REQUEST['ccity'];
$cstate = $_REQUEST['cstate'];
$czip = $_REQUEST['czip'];
$cphone =  $_REQUEST['cphone'];
$cemail =  $_REQUEST['cemail'];

if (array_key_exists('cinvoiceid',$_REQUEST)) {
$cinvoiceid2 = $_REQUEST['cinvoiceid'];
if ($cinvoiceid2 != "") {
$cinvoiceid = $cinvoiceid2;
$iorq = invoiceorquote($cinvoiceid);

$rs_find_name = "SELECT * FROM invoices WHERE invoice_id = '$cinvoiceid'";
$rs_result_name = mysqli_query($rs_connect, $rs_find_name);
$rs_result_name_q = mysqli_fetch_object($rs_result_name);
$invnotes = "$rs_result_name_q->invnotes";


} else {
$cinvoiceid = "0";
$iorq = "invoice";
}
} else {
$cinvoiceid = "0";
$iorq =	"invoice";
}

if (array_key_exists('pcgroupid',$_REQUEST)) {
$pcgroupid = $_REQUEST['pcgroupid'];
} else {
$pcgroupid = 0;
}

if (array_key_exists('woid',$_REQUEST)) {
$woid = $_REQUEST['woid'];
} else {
$woid = "";
}


echo "<form action=invoice.php?func=createinvoice2 method=post data-ajax=\"false\">";
echo pcrtlang("Customer Name").":<input type=text name=invname value=\"$cfirstname\">";
echo pcrtlang("Company").":<input type=text name=invcompany value=\"$ccompany\">";
echo "$pcrt_address1:<input type=text name=invaddy1 value=\"$caddress1\">";
echo "$pcrt_address2:<input type=text name=invaddy2 value=\"$caddress2\">";
echo "$pcrt_city:<input type=text name=invcity value=\"$ccity\">";
echo "$pcrt_state:<input type=text name=invstate value=\"$cstate\">";
echo "$pcrt_zip:<input type=text name=invzip value=\"$czip\">";
echo pcrtlang("Customer Phone").":<input type=text name=invphone value=\"$cphone\">";
echo pcrtlang("Customer Email").":<input type=text name=invemail value=\"$cemail\">";

echo pcrtlang("Invoice or Quote?").":<select name=iorq>";
if ($iorq == "invoice") {
echo "<option selected value=invoice>".pcrtlang("Invoice")."</option><option value=quote>".pcrtlang("Quote")."</option>";
} else {
echo "<option selected value=quote>".pcrtlang("Quote")."</option><option value=invoice>".pcrtlang("Invoice")."</option>";
}

echo "</select>";


echo "<tr><td>".pcrtlang("Invoice Terms?").":</td><td><select name=invoicetermsid>";

$rs_sl = "SELECT * FROM invoiceterms ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_sl);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$invoicetermsid = "$rs_result_q1->invoicetermsid";
$invoicetermstitle = "$rs_result_q1->invoicetermstitle";
$invoicetermsdays = "$rs_result_q1->invoicetermsdays";
$invoicetermslatefee = "$rs_result_q1->invoicetermslatefee";
$invoicetermsdefault = "$rs_result_q1->invoicetermsdefault";

if ($invoicetermsdefault == "1") {
echo "<option selected value=$invoicetermsid>$invoicetermstitle ($invoicetermslatefee% ".pcrtlang("Late Fee").")</option>";
} else {
echo "<option value=$invoicetermsid>$invoicetermstitle ($invoicetermslatefee% ".pcrtlang("Late Fee").")</option>";
}

}

echo "</select></td></tr>";


echo pcrtlang("Notes").": <textarea name=invnotes></textarea>";

echo "<input type=hidden name=woid value=\"$woid\"><input type=hidden name=pcgroupid value=\"$pcgroupid\"><input type=hidden name=cinvoiceid value=\"$cinvoiceid\"><input type=submit value=\"".pcrtlang("Save Invoice/Quote")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Saving")."...'; this.form.submit();\" data-theme=\"b\">";

echo "</form>";

dfooter();

require_once("dfooter.php");


}


function createinvoice2() {
require_once("validate.php");
require("deps.php");
require("common.php");

$invname = pv($_REQUEST['invname']);
$invcompany = pv($_REQUEST['invcompany']);
$invaddy1 = pv($_REQUEST['invaddy1']);
$invaddy2 = pv($_REQUEST['invaddy2']);
$invphone = pv($_REQUEST['invphone']);
$invemail = pv($_REQUEST['invemail']);
$invcity = pv($_REQUEST['invcity']);
$invstate = pv($_REQUEST['invstate']);
$invzip = pv($_REQUEST['invzip']);
$invnotes = pv($_REQUEST['invnotes']);
$cinvoiceid = $_REQUEST['cinvoiceid'];
$pcgroupid = $_REQUEST['pcgroupid'];
$iorq = $_REQUEST['iorq'];
$woid = $_REQUEST['woid'];
$invoicetermsid = $_REQUEST['invoicetermsid'];

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');


$rs_sl = "SELECT * FROM invoiceterms WHERE invoicetermsid = '$invoicetermsid'";
$rs_result1 = mysqli_query($rs_connect, $rs_sl);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$invoicetermsdays = "$rs_result_q1->invoicetermsdays";


if ($cinvoiceid == 0) {
$duedate = date('Y-m-d H:i:s', (time() + ($invoicetermsdays * 86400)));
$rs_insert_cart = "INSERT INTO invoices (invname,invcompany,invaddy1,invaddy2,invphone,invemail,invdate,invcity,invstate,invzip,byuser,invnotes,storeid,iorq,pcgroupid,woid,invoicetermsid,duedate) VALUES  ('$invname','$invcompany','$invaddy1','$invaddy2','$invphone','$invemail','$currentdatetime','$invcity','$invstate','$invzip','$ipofpc','$invnotes','$defaultuserstore','$iorq','$pcgroupid','$woid','$invoicetermsid','$duedate')";
@mysqli_query($rs_connect, $rs_insert_cart);
$invoiceid = mysqli_insert_id($rs_connect);
} else {
$invoiceid = $cinvoiceid;
$rs_find_name = "SELECT * FROM invoices WHERE invoice_id = '$cinvoiceid'";
$rs_result_name = mysqli_query($rs_connect, $rs_find_name);
$rs_result_name_q = mysqli_fetch_object($rs_result_name);
$invdate = "$rs_result_name_q->invdate";
$duedate = date('Y-m-d H:i:s', (strtotime($invdate) + ($invoicetermsdays * 86400)));
$rs_insert_cart = "UPDATE invoices SET invname = '$invname', invcompany = '$invcompany', invaddy1 = '$invaddy1', invaddy2 = '$invaddy2', invphone = '$invphone', invemail = '$invemail', invcity = '$invcity', invstate = '$invstate', invzip = '$invzip', byuser = '$ipofpc', invnotes = '$invnotes', iorq = '$iorq', pcgroupid = '$pcgroupid', woid = '$woid' WHERE invoice_id = '$invoiceid'";
@mysqli_query($rs_connect, $rs_insert_cart);
$rs_clear_items = "DELETE FROM invoice_items WHERE invoice_id = $invoiceid";
@mysqli_query($rs_connect, $rs_clear_items);
}

if($iorq == "invoice") {
userlog(16,$invoiceid,'invoiceid','');
} else {
userlog(17,$invoiceid,'invoiceid','');
}

$rs_purchases = "SELECT * FROM cart WHERE ipofpc = '$ipofpc' ORDER BY addtime ASC";
$rs_find_purchases = @mysqli_query($rs_connect, $rs_purchases);

while($rs_find_purchases_q = mysqli_fetch_object($rs_find_purchases)) {
$purchase_price = "$rs_find_purchases_q->cart_price";
$purchase_stockid = "$rs_find_purchases_q->cart_stock_id";
$purchase_labordesc = pv($rs_find_purchases_q->labor_desc);
$purchase_printdesc = pv($rs_find_purchases_q->printdesc);
$purchase_taxex = "$rs_find_purchases_q->taxex";
$purchase_itemtax = "$rs_find_purchases_q->itemtax";
$purchase_returnsoldid = "$rs_find_purchases_q->return_sold_id";
$purchase_restockingfee = "$rs_find_purchases_q->restocking_fee";
$purchase_pricealt = "$rs_find_purchases_q->price_alt";
$purchase_carttype = "$rs_find_purchases_q->cart_type";
$purchase_origprice = "$rs_find_purchases_q->origprice";
$purchase_discounttype = "$rs_find_purchases_q->discounttype";
$purchase_ourprice = "$rs_find_purchases_q->ourprice";
$purchase_itemserial = "$rs_find_purchases_q->itemserial";
$purchase_addtime = "$rs_find_purchases_q->addtime";
$purchase_unit_price = "$rs_find_purchases_q->unit_price";
$purchase_quantity = "$rs_find_purchases_q->quantity";
$purchase_discountname = "$rs_find_purchases_q->discountname";

$rs_insert_invitems = "INSERT INTO invoice_items (cart_price,cart_type,cart_stock_id,labor_desc,return_sold_id,restocking_fee,price_alt,invoice_id,taxex,itemtax,origprice,discounttype,ourprice,itemserial,addtime,unit_price,quantity,printdesc,discountname) VALUES ('$purchase_price','$purchase_carttype','$purchase_stockid','$purchase_labordesc','$purchase_returnsoldid','$purchase_restockingfee','$purchase_pricealt','$invoiceid','$purchase_taxex','$purchase_itemtax','$purchase_origprice','$purchase_discounttype','$purchase_ourprice','$purchase_itemserial','$purchase_addtime','$purchase_unit_price','$purchase_quantity','$purchase_printdesc','$purchase_discountname')";
@mysqli_query($rs_connect, $rs_insert_invitems);

}

$rs_delete_cart = "DELETE FROM cart WHERE ipofpc = '$ipofpc'";
@mysqli_query($rs_connect, $rs_delete_cart);

$rs_clear_cust = "DELETE FROM currentcustomer WHERE byuser = '$ipofpc'";
@mysqli_query($rs_connect, $rs_clear_cust);


header("Location: invoice.php?func=printinv&invoice_id=$invoiceid");

}

######################################################################################################################################

function printinv() {
require_once("validate.php");
$invoice_ids = $_REQUEST['invoice_id'];

include("deps.php");
include("common.php");

if (!isset($enablesignaturepad_invoice)) {
$enablesignaturepad_invoice = "no";
}

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


echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../repair/printstyle.css\">";

if ($enablesignaturepad_invoice == "yes") {
?>
 <link rel="stylesheet" href="../repair/jq/signature/jquery.signaturepad.css">
  <!--[if lt IE 9]><script src="../repair/jq/signature/flashcanvas.js"></script><![endif]-->
  <script src="../repair/jq/jquery.js"></script>

<script type="text/javascript" src="../repair/jq/signature/jquery.signaturepad.min.js"></script>
<script type="text/javascript" src="../repair/jq/signature/json2.min.js"></script>
<?php

}


if ($enablesignaturepad_invoice == "topaz") {
require("../repair/jq/topaz.js");
}

echo "</head>";

echo "<body class=printpagebg>";

if (count($invoicearray) > 1) {
echo "<div class=printbar>";
echo "<button onClick=\"parent.location='$returnurl'\" class=bigbutton><img src=../store/images/left.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Return")."</button>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<button onClick=\"print();\" class=bigbutton><img src=../store/images/print.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Print")."</button>";
echo "</div>";
}


foreach($invoicearray as $key => $invoice_id) {


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
$invoicetermsid = "$rs_result_name_q->invoicetermsid";
$duedate = "$rs_result_name_q->duedate";

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
echo "<button onClick=\"parent.location='$returnurl'\" class=bigbutton><img src=../store/images/left.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Return")."</button>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<button onClick=\"print();\" class=bigbutton><img src=../repair/images/print.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Print")."</button>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<button onClick=\"parent.location='../repairmobile/addresslabel.php?pcname=$rs_soldto_ue&pccompany=$rs_company_ue&pcaddress1=$rs_ad1_ue&pcaddress2=$rs_ad2_ue&pccity=$rs_city_ue&pcstate=$rs_state_ue&pczip=$rs_zip_ue&dymojsapi=html'\" class=bigbutton><img src=../repair/images/labelprinter.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Address Label")."</button>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<button  onClick=\"parent.location='../storemobile/invoice.php?func=emailinv2&invoice_id=$invoice_id&emailaddy=$rs_email&returnurl=$rs_returnurl'\" class=bigbutton><img src=images/email.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Email")."</button>";
echo "</div>";
}

if($iorq == "invoice") {
userlog(21,$invoice_id,'invoiceid','');
} else {
userlog(22,$invoice_id,'invoiceid','');
}

if ($iorq == "quote") {
$ilabellog = pcrtlang("Sent Quote for Work Order");
$ilabellog = pcrtlang("Quote");
} else {
$ilabellog = pcrtlang("Sent Invoice for Work Order");
$ilabellog = pcrtlang("Invoice");
}

echo "<div class=printpage>";
echo "<table width=100%><tr><td width=55%>";


if ($rs_woid != "0") {
userlog(21,$rs_woid,'woid',"$ilabellog");
} else {
userlog(22,$rs_woid,'woid',"$ilabellog");
}


$storeinfoarray = getstoreinfo($rs_storeid);

echo "<img src=../repair/$printablelogo><br><span class=italme>$servicebyline</span><br><br>";
echo "$storeinfoarray[storename]<br>$storeinfoarray[storeaddy1]";
if ("$storeinfoarray[storeaddy2]" != "") {
echo "<br>$storeinfoarray[storeaddy2]";
}
echo "<br>$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]";
echo "";
echo "<br>".pcrtlang("Phone").": $storeinfoarray[storephone]<br><br><br>";

echo "<table cellpadding=3 cellspacing=0 border=0><tr><td valign=top>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>";

if ("$rs_company" != "") {
echo "$rs_company";
} else {
echo "$rs_soldto";
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

echo "</td></tr></table>";

echo "<br></td><td valign=top><table><tr><td align=right width=45% valign=top>";
echo "<span class=textidnumber>$ilabel2 #$invoice_id<br></span>";


$rs_datesold2 = pcrtdate("$pcrt_longdate", "$rs_datesold");

echo "<br>$ilabel2 ".pcrtlang("Date").": $rs_datesold2";

if ($rs_woid != "") {
echo "<br>".pcrtlang("Work Order")." ";
$rs_woids = explode_list($rs_woid);
foreach($rs_woids as $key => $rs_woidids) {
echo "#$rs_woidids ";
}
}




echo "<br><br><img src=\"barcode.php?barcode=$invoice_id&width=220&height=20&text=0\">";


if ((strtotime($duedate) < time()) && ($iorq != "quote") && ($invstatus == 1)) {
echo "<br><br><br><span class=overduestamp style=\"display:inline-block;\">".pcrtlang("OVERDUE")."</span>";
}

echo "</td></tr><tr><td>";

if ($invnotes != "") {
echo "<br>".pcrtlang("Note").": ";
echo nl2br($invnotes);
echo "";
}

echo "</td></tr></table></td></tr></table>";



echo "<table class=printables>";

$rs_find_cart_items = "SELECT * FROM invoice_items WHERE cart_type = 'purchase' AND invoice_id = '$invoice_id' ORDER BY addtime ASC";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

if (mysqli_num_rows($rs_result) != 0) {
echo "<tr><th colspan=5 width=100%>".pcrtlang("Purchase Items")."</th></tr>";

echo "<tr><td width=5% class=subhead>".pcrtlang("Qty")."</td><td width=50% class=subhead>".pcrtlang("Name of Product")."</td><td width=15% align=right class=subhead>".pcrtlang("Unit Price")."</td><td width=15% align=right class=subhead>".pcrtlang("Total Price");

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
$discountname = "$rs_result_q->discountname";

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

$lineitemtax[$val] = $salestaxratei * $rs_cart_price;

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


echo "<tr><td width=5% class=lineitems>".qf("$quantity");


echo "</td><td width=50% class=lineitems>$rs_stocktitle";

if($rs_stockpdesc != "") {
echo "<br><br><div class=leftindent>".nl2br("$rs_stockpdesc")."</div>";
}


if ($itemserial != "") {
echo "&nbsp;&nbsp;<span class=\"sizemesmaller boldme\">(".pcrtlang("Serial/Code").":</span> <span class=\"sizemesmaller\">$itemserial</span><span class=\"sizemesmaller boldme\">)</span>";
}


if (($price_alt == 1) && ($origprice > $unit_price)) {
echo "<br>";
$disc = explode('|',"$discounttype");
if("$disc[0]" == "percent") {
echo "<span class=\"sizemesmaller italme\">$discountname</span>";
} elseif("$disc[0]" == "custom") {
echo "<span class=\"sizemesmaller italme\">$discountname</span>";
} else {

}
}

$rs_cart_price_total = $rs_cart_price;

echo "</td><td width=15% align=right class=lineitems>$money".limf("$unit_price","$unit_tax")."";

if (($price_alt == 1) && ($origprice > $unit_price)) {
$origunitpricetax = $origprice * getsalestaxrate($taxex);
echo "<br><span class=\"sizemesmaller italme\">".pcrtlang("was")." $money".limf("$origprice","$origunitpricetax")."</span>";
}

echo "</td>";




echo "<td width=15% align=right class=lineitems>$money".limf("$rs_cart_price_total","$itemtax")."</td><td align=right>";

reset($lineitemtax);
foreach($lineitemtax as $key => $val) {
$shortname = gettaxshortname($key);
if($val != 0) {
echo "<span class=\"sizemesmaller italme\">";
echo "$shortname: $money".mf("$val");
echo "</span><br>";
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
echo "<tr><td width=5% class=subhead>".pcrtlang("Qty")."</td><td width=50% class=subhead>".pcrtlang("Labor Description")."</td><td width=15% class=subhead>".pcrtlang("Unit Price")."</td>";
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
$ldiscountname = "$rs_result_labor_q->discountname";
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


echo "<tr><td width=5% class=lineitems>".qf("$lquantity")."</td><td width=50% class=lineitems>$rs_cart_labor_desc";

if($rs_cart_labor_pdesc != "") {
echo "<br><br><div class=leftindent>".nl2br("$rs_cart_labor_pdesc")."</div>";
}

if (($lprice_alt == 1) && ($lorigprice > $lunit_price)) {
echo "<br>";
$ldisc = explode('|',"$ldiscounttype");
if("$ldisc[0]" == "percent") {
echo "<span class=\"sizemesmaller italme\">$ldiscountname</span>";
} elseif("$ldisc[0]" == "custom") {
echo "<span class=\"sizemesmaller italme\">$ldiscountname</span>";
} else {

}
}

echo "</td><td width=15% align=right class=lineitems>".limf("$lunit_price","$lunit_tax")."</td><td width=15% align=right class=lineitems>$money".limf("$rs_cart_labor_price","$litemtax")."";

if (($lprice_alt == 1) && ($lorigprice > $lunit_price)) {
$lorigunitpricetax = $lorigprice * getservicetaxrate($ltaxex);
echo "<br><span class=\"sizemesmaller italme\">".pcrtlang("was")." $money".limf("$lorigprice","$lorigunitpricetax")."</span>";
}

echo "</td><td align=right>";

reset($laboritemtax);
foreach($laboritemtax as $key => $val) {
$shortname = gettaxshortname($key);
if($val != 0) {

echo "<span class=\"sizemesmaller italme\">";
echo "$shortname: $money".mf("$val");
echo "</span><br>";

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

echo "<tr><td width=5%>&nbsp;</td><td width=80% align=right colspan=3>".pcrtlang("Parts Subtotal").":</td><td width=15% align=right>$money".limf("$rs_total_parts","$rs_total_parts_tax")."</td></tr>";

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
echo "<tr><td width=5%>&nbsp;</td><td width=80% align=right colspan=3>".pcrtlang("Labor Total").":</td><td width=15% align=right>$money".limf("$rs_total_labor","$rs_total_labor_tax")."</td></tr>";

$rs_find_labortax_total = "SELECT SUM(itemtax) AS total_labortax_price FROM invoice_items WHERE cart_type = 'labor' AND invoice_id = '$invoice_id'";
$rs_find_result_taxlabor_total = mysqli_query($rs_connect, $rs_find_labortax_total);
while($rs_find_result_labortax_total_q = mysqli_fetch_object($rs_find_result_taxlabor_total)) {
$rs_total_labortax = "$rs_find_result_labortax_total_q->total_labortax_price";

$servicetax = $rs_total_labortax;

}


#echo "<tr><td width=100% colspan=5>&nbsp;</td></tr>";

$grand_total = (tnv($salestax) + tnv($rs_total_parts) + tnv($rs_total_labor) + tnv($servicetax));

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
echo "<tr><td width=5%></td><td width=80% align=right colspan=3><span class=\"sizemesmaller boldme\">$taxname:</span></td>
<td width=15% align=right>$money".mf("$taxtotal")."</td></tr>";
}
}

echo "<tr><td width=100% colspan=5>&nbsp;</td></tr>";

echo "<tr><td width=5%></td><td width=80% align=right colspan=3><span class=sizemelarger>";

if("$iorq" == "invoice") {
echo pcrtlang("Invoice Total").":";
} else {
echo pcrtlang("Quote Total").":";
}


echo "</span></td>";
echo "<td width=15% align=right><span class=sizemelarger>$money".mf("$grand_total")."</span>";



echo "</td></tr>";


if(("$iorq" == "invoice") && ($invstatus == 1)) {


$finddepositstotal = "SELECT * FROM deposits WHERE invoiceid = '$invoice_id'";
$finddepositsqtotal = @mysqli_query($rs_connect, $finddepositstotal);


if(mysqli_num_rows($finddepositsqtotal) > 0) {

while($rs_find_deposits_q = mysqli_fetch_object($finddepositsqtotal)) {
$depositid = "$rs_find_deposits_q->depositid";
$depositamount = "$rs_find_deposits_q->amount";
$checknumber = "$rs_find_deposits_q->chk_number";

echo "<tr><td width=5%></td><td width=80% align=right colspan=3>".pcrtlang("Deposit ID").": #$depositid";
if($checknumber != "") {
echo " | ".pcrtlang("Check No.")." #$checknumber";
}

echo "</td>";
echo "<td width=15% align=right>$money".mf("$depositamount")."</td></tr>";


}

$finddeposits = "SELECT SUM(amount) AS totaldep FROM deposits WHERE invoiceid = '$invoice_id'";
$finddepositsq = @mysqli_query($rs_connect, $finddeposits);

$finddepositsa = mysqli_fetch_object($finddepositsq);
$totaldep = "$finddepositsa->totaldep";
$balance = $grand_total - $totaldep;

echo "<tr><td width=5%></td><td width=80% align=right colspan=3><span class=sizemelarge>".pcrtlang("Total Deposits").":</span></td>";
echo "<td width=15% align=right><span class=sizemelarge>$money".mf("$totaldep")."</span></td></tr>";

echo "<tr><td width=5%></td><td width=80% align=right colspan=3><span class=sizemelarge>".pcrtlang("Balance Due").":</span></td>";
echo "<td width=15% align=right><span class=sizemelarge>$money".mf("$balance")."</span></td></tr>";


}

}


echo "</table>";

$invoiceterms = getinvoicetermstitle($invoicetermsid);

if ("$iorq" == "invoice") {
echo "<center>";

echo "<span class=sizemelarger>".pcrtlang("Invoice Terms").": $invoiceterms</span><br>";
$duedate2 = pcrtdate("$pcrt_longdate", "$duedate");
echo pcrtlang("Due Date").": $duedate2<br>";
echo nl2br($storeinfoarray['invoicefooter']);
echo "</center>\n\n";
} else {
echo "<center>";
echo "<span class=sizemelarger>".pcrtlang("Invoice Terms").": $invoiceterms</span>";
echo nl2br($storeinfoarray['quotefooter']);
echo "</center>\n\n";
}



##############################

if (($enablesignaturepad_invoice == "yes") && ($showsiginv == "0") && (count($invoicearray) == 1)) {
echo "<a href=invoice.php?func=hidesiginv&invoice_id=$invoice_id&hidesig=1 class=hideprintedlink><br><br>(".pcrtlang("show signature pad").")</a>";
}

if (($enablesignaturepad_invoice == "yes") && ($showsiginv == "1")) {

if (($showsiginv == "1") && (count($invoicearray) == "1")) {
echo "<a href=invoice.php?func=hidesiginv&invoice_id=$invoice_id&hidesig=0 class=hideprintedlink><br><br>(".pcrtlang("hide signature pad").")</a>";
}


if(($thesig == "") && (count($invoicearray) == 1)) {

?>
<blockquote>
  <form method="post" action="invoice.php?func=savesig" class="sigPad"><input type=hidden name=invoice_id value=<?php echo $invoice_id; ?>><input type=hidden name=invoicestoreid value=<?php echo $rs_storeid; ?>>
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
} elseif ($thesig != "") {

if (count($invoicearray) == 1) {
echo "<br><br><span class=sizemelarge>".pcrtlang("Signed").":</span> <a href=invoice.php?func=clearsig&invoice_id=$invoice_id class=hideprintedlink>(".pcrtlang("remove signature").")</a><br>";
} else {
echo "<br><br><span class=sizemelarge>".pcrtlang("Signed").":</span><br>";
}

?>

<div class="sigPad<?php echo $invoice_id; ?> signed">
  <div class="sigWrapper">
    <canvas class="pad" width="450" height="75"></canvas>
  </div>
</div>

<script>
$(document).ready(function () {
  $('.sigPad<?php echo $invoice_id; ?>').signaturePad({displayOnly:true}).regenerate(<?php echo $thesig ?>)
})
</script>
<?php
} else {
}



}





#start topaz

if (($enablesignaturepad_invoice == "topaz") && (count($invoicearray) == "1")) {

if ($showsiginvtopaz == "0") {
echo "<a href=invoice.php?func=hidesiginvtopaz&invoice_id=$invoice_id&hidesig=1 class=hideprintedlink><br><br>(".pcrtlang("show signature pad").")</a>";
}

if ($showsiginvtopaz == "1") {
echo "<a href=invoice.php?func=hidesiginvtopaz&invoice_id=$invoice_id&hidesig=0 class=hideprintedlink><br><br>(".pcrtlang("hide signature pad").")</a>";
}

if ($showsiginvtopaz == "1") {
if ($thesigtopaz == "") {


?>

<br>
<canvas id="cnv" name="cnv" width="500" height="100"></canvas>

<form action="invoice.php?func=savesigtopaz" name=FORM1 method=post>
<input id="SignBtn" name="SignBtn" type="button" value="<?php echo pcrtlang("Activate Sig Pad"); ?>"  class=button onclick="javascript:onSign()"/>&nbsp;&nbsp;&nbsp;&nbsp;
<input id="button1" name="ClearBtn" type="button" class=button value="Clear" onclick="javascript:onClear()"/>&nbsp;&nbsp;&nbsp;&nbsp;
<input id="button2" name="DoneBtn" type="button" class=button value="Done" onclick="javascript:onDone()"/>&nbsp;&nbsp;&nbsp;&nbsp;

<input type="submit" class=button value="Save">&nbsp;&nbsp;&nbsp;&nbsp

<INPUT TYPE=HIDDEN NAME="bioSigData">
<INPUT TYPE=HIDDEN NAME="sigImgData">

<input type=hidden name=invoice_id value=<?php echo $invoice_id; ?>>

<input type=hidden NAME="sigImageData" value="">
</form>



<?php

} else {
echo "<br><br><span class=sizemelarge>".pcrtlang("Signed").":</span><a href=invoice.php?func=clearsigtopaz&invoice_id=$invoice_id class=hideprintedlink>(".pcrtlang("remove signature").")</a><br>";

echo '<br><img src="data:image/png;base64,' . $thesigtopaz . '" />';

}

#end hide
}

}
#end topaz






echo "</div>";


#############################




echo "</div>";

if (count($invoicearray) > 1) {
echo "\n\n<DIV style=\"page-break-after:always\"></DIV>\n\n";
}


}




if (count($invoicearray) == 1) {

echo "<div class=printfooterbar>";

echo "<br><span class=infoheading>".pcrtlang("Invoice History")."</span><br><br>";

$rs_find_log = "SELECT * FROM userlog WHERE reftype = 'invoiceid' AND refid = '$invoice_ids' ORDER BY thedatetime ASC";
$rs_result_log = mysqli_query($rs_connect, $rs_find_log);

if((mysqli_num_rows($rs_result_log)) == "0") {
echo "<br><span class=\"italme colormegray\">".pcrtlang("No Results Found")."</span>";
}
echo "<table>";

while($rs_result_q = mysqli_fetch_object($rs_result_log)) {
$rs_actionid = "$rs_result_q->actionid";
$rs_thedatetime2 = "$rs_result_q->thedatetime";
$rs_thedatetime = pcrtdate("$pcrt_shortdate", "$rs_thedatetime2").", ".pcrtdate("$pcrt_time", "$rs_thedatetime2");
$rs_refid = "$rs_result_q->refid";
$loggeduser = "$rs_result_q->loggeduser";
$reftype = "$rs_result_q->reftype";
$mensaje = "$rs_result_q->mensaje";

echo "<tr><td><td>($loggeduser) $loggedactions[$rs_actionid]</td>";
echo "<td>$rs_thedatetime</td><td> $mensaje</td></tr>";

}

echo "</table>";

echo "</div>";
}


echo "</body></html>";


}



######################################################################################################################################

function emailinv() {

require_once("validate.php");

$invoice_ids = $_REQUEST['invoice_id'];

$sendingerror = 0;
$infopass = "";

if(!is_array($invoice_ids)) {
if (strpos($invoice_ids, '_') !== false) {
$invoicearray = array_filter(explode("_", "$invoice_ids"));
} else {
$invoicearray = array("$invoice_ids");
}
} else {
$invoicearray = $invoice_ids;
}

include("deps.php");
include("common.php");

if (($pcrt_mailer == "pearsmtp") || ($pcrt_mailer == "pearsmtpauth") || ($pcrt_mailer == "pearphpmailer")) {

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
}


if (array_key_exists('returnurl',$_REQUEST)) {
$returnurl = $_REQUEST['returnurl'];
} else {
$returnurl = "invoice.php";
}

foreach($invoicearray as $key => $invoice_id) {

$iorq = invoiceorquote($invoice_id);
if ($iorq == "quote") {
$ilabel = pcrtlang("Quote");
} else {
$ilabel = pcrtlang("Invoice");
}


if ($demo == "yes") {
die("Sorry this feature is disabled in demo mode");
}

$mastertaxtotals = array();




$rs_find_name = "SELECT * FROM invoices WHERE invoice_id = '$invoice_id'";
$rs_result_name = mysqli_query($rs_connect, $rs_find_name);

while($rs_result_name_q = mysqli_fetch_object($rs_result_name)) {
$rs_soldto = "$rs_result_name_q->invname";
$rs_company = "$rs_result_name_q->invcompany";
$rs_ad1 = "$rs_result_name_q->invaddy1";
$rs_ad2 = "$rs_result_name_q->invaddy2";
$rs_city = "$rs_result_name_q->invcity";
$rs_state = "$rs_result_name_q->invstate";
$rs_zip = "$rs_result_name_q->invzip";
$rs_ph = "$rs_result_name_q->invphone";
$emailaddy = "$rs_result_name_q->invemail";
$rs_datesold = "$rs_result_name_q->invdate";
$receipt_id = "$rs_result_name_q->receipt_id";
$invnotes = "$rs_result_name_q->invnotes";
$rs_storeid = "$rs_result_name_q->storeid";
$rs_woid = "$rs_result_name_q->woid";
$preinvoice = "$rs_result_name_q->preinvoice";
$invstatus = "$rs_result_name_q->invstatus";
$invoicetermsid = "$rs_result_name_q->invoicetermsid";
$duedate = "$rs_result_name_q->duedate";



if ($iorq == "invoice") {
userlog(15,$invoice_id,'invoiceid',"$ilabel ".pcrtlang("sent to")." $emailaddy");
} else {
userlog(19,$invoice_id,'invoiceid',"$ilabel ".pcrtlang("sent to")." $emailaddy");
}



$storeinfoarray = getstoreinfo($rs_storeid);

$to = "$emailaddy";

if("$storeinfoarray[storeccemail]" != "") {
$to .= ",$storeinfoarray[storeccemail]";
}

$subject = "$storeinfoarray[storename] - $ilabel #$invoice_id";
$random_hash = md5(date('r', time()));
$headers = "From: $storeinfoarray[storeemail]\nReply-To: $storeinfoarray[storeemail]\nX-Mailer: PHP/".phpversion();
$headers .= "\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
$headers .= "\nMIME-Version: 1.0";

$message = "\n\n--PHP-alt-$random_hash\n";
$message .= "Content-Type: text/plain; charset=\"utf-8\"\n";
$message .= "Content-Transfer-Encoding: 7bit\n\n";

$message .= pcrtlang("Your Invoice")."\n\n";
$peartext = pcrtlang("Your Invoice")."\n\n";

$message .= "--PHP-alt-$random_hash\n";
$message .= "Content-Type: text/html; charset=\"utf-8\"\n";
$message .= "Content-Transfer-Encoding: 7bit\n\n";

$message .= "<html><body><table width=100%><tr><td width=55%>\n";
$pearhtml = "<html><body><table width=100%><tr><td width=55%>\n";


$message .= "<font face=Arial size=4><b>$storeinfoarray[storename]</b><br></font>\n<font face=arial size=3><i>$servicebyline</i><br>\n";
$pearhtml .= "<img src=../store/$logo>\n<br><font face=arial size=3><i>$servicebyline</i><br><br>$storeinfoarray[storename]";
$peartext .= "$storeinfoarray[storename]";

$rs_datesold2 = pcrtdate("$pcrt_longdate", "$rs_datesold");
$ilabel2 = strtoupper("$ilabel");

$peartext .= "\t\t\t\t\t$ilabel2 #$invoice_id\n";


$message .= "<br>$storeinfoarray[storeaddy1]";

if ("$storeinfoarray[storeaddy2]" != "") {
$message .="<br>$storeinfoarray[storeaddy2]\n";
}
$message .= "<br>$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]\n";
$message .= "</font><br><br>".pcrtlang("Phone").": $storeinfoarray[storephone]</font></font><br><br>\n";


$pearhtml .= "<br>$storeinfoarray[storeaddy1]";
$peartext .= "$storeinfoarray[storeaddy1]";
$peartext .= "\t\t\t\t\t\t\t$ilabel ".pcrtlang("Date").": $rs_datesold2\n";
if ("$storeinfoarray[storeaddy2]" != "") {
$pearhtml .="<br>$storeinfoarray[storeaddy2]\n";
$peartext .="$storeinfoarray[storeaddy2]\n";
}
$pearhtml .= "<br>$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]\n";
$pearhtml .= "</font><br><br>".pcrtlang("Phone").": $storeinfoarray[storephone]</font></font><br><br>\n";
$peartext .= "$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]\n";
$peartext .= "\n".pcrtlang("Phone").": $storeinfoarray[storephone]\n\n";

if("$rs_company" != "") {
$rs_soldto2 = "$rs_company";
} else {
$rs_soldto2 = "$rs_soldto";
}

$message .= "<table cellpadding=3 cellspacing=0 border=0><tr><td valign=top><b>".pcrtlang("Sold to").":</b></td><td>$rs_soldto2<br>$rs_ad1";
$pearhtml .= "<table cellpadding=3 cellspacing=0 border=0><tr><td valign=top><b>".pcrtlang("Sold to").":</b></td><td>$rs_soldto2<br>$rs_ad1";
$peartext .= "".pcrtlang("Sold to").":\n-----------------\n$rs_soldto2\n$rs_ad1";

if ($rs_ad2 != "") {
$message .= "<br>$rs_ad2";
$pearhtml .= "<br>$rs_ad2";
$peartext .= "$rs_ad2\n";
}


$message .= "<br>$rs_city, $rs_state $rs_zip<br>";
$pearhtml .= "<br>$rs_city, $rs_state $rs_zip<br>";
$peartext .= "$rs_city, $rs_state $rs_zip\n";


$message .= "<br>$rs_ph</td></tr></table>\n";
$pearhtml .= "<br>$rs_ph</td></tr></table>\n";
$peartext .= "$rs_ph\n";

$message .= "</font><br></td><td valign=top><table><tr><td align=right width=45% valign=top>\n";
$pearhtml .= "</font><br></td><td valign=top><table><tr><td align=right width=45% valign=top>\n";


$message .= "<font color=888888 face=arial size=6>$ilabel2 #$invoice_id<br></font>\n";
$pearhtml .= "<font color=888888 face=arial size=6>$ilabel2 #$invoice_id<br></font>\n";


$message .= "<br>$ilabel ".pcrtlang("Date").": <b>$rs_datesold2</b><br>\n";
$pearhtml .= "<br>$ilabel ".pcrtlang("Date").": <b>$rs_datesold2</b><br>\n";

if ($rs_woid != "") {
$message .= "<br>".pcrtlang("Work Order")." ";
$pearhtml .= "<br>".pcrtlang("Work Order")." ";
$rs_woids = explode_list($rs_woid);
foreach($rs_woids as $key => $rs_woidids) {
$message .= "#$rs_woidids ";
$pearhtml .= "#$rs_woidids ";
}
}





$overduestyle = <<<OVERDUESTYLE
padding:5px;
margin-right:100px;
COLOR: #ff0000;
FONT-SIZE: 40px;
FONT-WEIGHT: bold;
text-align:left;
FONT-FAMILY:Trebuchet MS,Verdana,Helvetica,Arial;
border: 4px solid #ff0000;
border-radius:20px;
-moz-border-radius:20px;
        -webkit-transform: rotate(-12deg);
        -moz-transform: rotate(-12deg);
        -ms-transform: rotate(-12deg);
        -o-transform: rotate(-12deg);
        transform: rotate(-12deg);
OVERDUESTYLE;

if ((strtotime($duedate) < time()) && ($iorq != "quote") && ($invstatus == 1)) {
$message .= "<br><br><br><font style=\"$overduestyle\">".pcrtlang("OVERDUE")."</font>";
$pearhtml .= "<br><br><br><font style=\"$overduestyle\">".pcrtlang("OVERDUE")."</font>";
}



$invnotes2 = nl2br($invnotes);

$message .= "</td></tr><tr><td><br>".pcrtlang("Note").": </font>$invnotes2</font>\n";
$pearhtml .= "</td></tr><tr><td><br>".pcrtlang("Note").": </font>$invnotes2</font>\n";

$message .= "</td></tr></table></td></tr></table>\n";
$pearhtml .= "</td></tr></table></td></tr></table>\n";

}

$message .= "<table width=100% border=0 cellspacing=0 cellpadding=0>\n";
$pearhtml .= "<table width=100% border=0 cellspacing=0 cellpadding=0>\n";

$rs_find_cart_items = "SELECT * FROM invoice_items WHERE cart_type = 'purchase' AND invoice_id = '$invoice_id' ORDER BY addtime ASC";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

if (mysqli_num_rows($rs_result) != 0) {
$message .= "<tr><td colspan=5 width=100% style=\"box-shadow: inset 0 0 0 1000px #dddddd;padding:8px;\"><b>".pcrtlang("Purchase Items")."</b></td></tr>\n";
$pearhtml .= "<tr><td colspan=5 width=100% style=\"box-shadow: inset 0 0 0 1000px #dddddd;padding:8px;\"><b>".pcrtlang("Purchase Items")."</b></td></tr>\n";
$peartext .= "\n\n".pcrtlang("Purchase Items");

$message .= "<tr><td width=5%>".pcrtlang("Qty")."</td><td width=50%><i>".pcrtlang("Name of Product")."</u></td>\n<td width=15% align=right>".pcrtlang("Unit Price")."</td><td width=15% align=right>".pcrtlang("Total Price")."</td><td width=15% align=right>".pcrtlang("Tax")."</td></tr>\n<tr><td colspan=5><hr color=black></td></tr>\n";
$pearhtml .= "<tr><td width=5%>".pcrtlang("Qty")."</td><td width=50%><i>".pcrtlang("Name of Product")."</u></td>\n<td width=15% align=right>".pcrtlang("Unit Price")."</td><td width=15% align=right>".pcrtlang("Total Price")."</td><td width=15% align=right>".pcrtlang("Tax")."</td></tr>\n<tr><td colspan=5><hr color=black></td></tr>\n";
$peartext .= "\n\n".pcrtlang("Qty")."\t".pcrtlang("Name of Product")."\t\t\t".pcrtlang("Unit Price")."\t".pcrtlang("Total Price")."\t".pcrtlang("Tax")."\n";
$peartext .= "----------------------------------------------------------------------------------------";
}


while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_cart_item_id = "$rs_result_q->cart_item_id";
$rs_cart_price = "$rs_result_q->cart_price";
$rs_stock_id = "$rs_result_q->cart_stock_id";
$rs_labordesc = "$rs_result_q->labor_desc";
$rs_laborprintdesc = "$rs_result_q->printdesc";
$origprice = "$rs_result_q->origprice";
$discounttype = "$rs_result_q->discounttype";
$price_alt = "$rs_result_q->price_alt";
$taxex = "$rs_result_q->taxex";
$itemtax = "$rs_result_q->itemtax";
$unit_price = "$rs_result_q->unit_price";
$quantity = "$rs_result_q->quantity";
$discountname = "$rs_result_q->discountname";

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
$rs_stockpdesc = "$rs_laborprintdesc";
}

#newtaxcode
$salestaxrate = getsalestaxrate($taxex);
$isgrouprate = isgrouprate($taxex);

if($isgrouprate == 0) {
$lineitemtax[$taxex] = $rs_tax_total2;
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

$lineitemtax[$val] = $salestaxratei * $rs_cart_price;

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

$message .= "<tr><td width=5%>".qf("$quantity")."\n";
$pearhtml .= "<tr><td width=5%>".qf("$quantity")."\n";
$peartext .= "\n".qf("$quantity")."";

$message .= "</td><td width=50%>$rs_stocktitle\n";
$pearhtml .= "</td><td width=50%>$rs_stocktitle\n";
$peartext .= "\t$rs_stocktitle\t\t";

if($rs_stockpdesc != "") {
$message .= "\n<br><small>".nl2br("$rs_stockpdesc")."</small>\n\n";
$pearhtml .= "\n<br><small>".nl2br("$rs_stockpdesc")."</small>\n\n";
$peartext .= "\n".nl2br("$rs_stockpdesc")."\n\n";
}


if (($price_alt == 1) && ($origprice > $unit_price)) {
$message .= "<br>";
$pearhtml .= "<br>";
$disc = explode('|',"$discounttype");
if("$disc[0]" == "percent") {
$message .= "<font size=1><i>$discountname</i></font>";
$pearhtml .= "<font size=1><i>$discountname</i></font>";
} elseif("$disc[0]" == "custom") {
$message .= "<font size=1><i>$discountname</i></font>";
$pearhtml .= "<font size=1><i>$discountname</i></font>";
} else {

}
}


$rs_cart_price_total = $rs_cart_price;

$message .= "</td><td width=15% align=right>$money".limf("$unit_price","$unit_tax");
$pearhtml .= "</td><td width=15% align=right>$money".limf("$unit_price","$unit_tax");
$peartext .= "\n\t\t\t\t\t".limf("$unit_price","$unit_tax");

if (($price_alt == 1) && ($origprice > $rs_cart_price)) {
$origunitpricetax = $origprice * getsalestaxrate($taxex);
$message .= "<br><font size=1><i>".pcrtlang("was")." $money".limf("$origprice","$origunitpricetax")."</i></font>";
$pearhtml .= "<br><font size=1><i>".pcrtlang("was")." $money".limf("$origprice","$origunitpricetax")."</i></font>";
}

$message .= "</td>\n<td width=15% align=right>$money".limf("$rs_cart_price_total","$itemtax")."</td><td align=right>\n";
$pearhtml .= "</td>\n<td width=15% align=right>$money".limf("$rs_cart_price_total","$itemtax")."</td><td align=right>\n";
$peartext .= "\t\t".limf("$rs_cart_price_total","$itemtax")."\t";

reset($lineitemtax);
foreach($lineitemtax as $key => $val) {
$shortname = gettaxshortname($key);
if($val != 0) {
$message .= "<font size=1>$shortname: $money".mf("$val")."</font><br>";
$pearhtml .= "<font size=1>$shortname: $money".mf("$val")."</font><br>";
$peartext .= "$shortname: $money".mf("$val")."\n";
}
}
unset($lineitemtax);



}


$message .= "</td></tr>\n";
$pearhtml .= "</td></tr>\n";

$rs_find_cart_labor = "SELECT * FROM invoice_items WHERE cart_type = 'labor' AND invoice_id = '$invoice_id' ORDER BY addtime ASC";
$rs_result_labor = mysqli_query($rs_connect, $rs_find_cart_labor);

if (mysqli_num_rows($rs_result_labor) != 0) {
$message .= "<tr><td width=100% colspan=5><br><br></td></tr>\n";
$pearhtml .= "<tr><td width=100% colspan=5><br><br></td></tr>\n";
$peartext .= "\n\n";
$message .= "<tr><td colspan=5 style=\"box-shadow: inset 0 0 0 1000px #dddddd;padding:8px;\"><b>".pcrtlang("Labor")."</b></td></tr>\n";
$pearhtml .= "<tr><td colspan=5 style=\"box-shadow: inset 0 0 0 1000px #dddddd;padding:8px;\"><b>".pcrtlang("Labor")."</b></td></tr>\n";
$peartext .= pcrtlang("Labor")."\n";

$message .= "<tr><td width=5%>".pcrtlang("Qty")."</td><td width=50%><i>".pcrtlang("Labor Description")."</i></td><td width=15% align=right>".pcrtlang("Unit Price")."</td>";
$pearhtml .= "<tr><td width=5%>".pcrtlang("Qty")."</td><td width=50%><i>".pcrtlang("Labor Description")."</i></td><td width=15% align=right>".pcrtlang("Unit Price")."</td>";
$peartext .= pcrtlang("Qty")."\t".pcrtlang("Labor Description");

$message .= "<td width=15% align=right>".pcrtlang("Price")."</td><td width=15% align=right>".pcrtlang("Tax")."</td></tr><tr><td colspan=5><hr color=black></td></tr>\n";
$pearhtml .= "<td width=15% align=right>".pcrtlang("Price")."</td><td width=15% align=right>".pcrtlang("Tax")."</td></tr><tr><td colspan=5><hr color=black></td></tr>\n";
$peartext .= "\t\t\t\t".pcrtlang("Price")."\t".pcrtlang("Tax")."\n";
$peartext .= "----------------------------------------------------------------------------------------";

}


while($rs_result_labor_q = mysqli_fetch_object($rs_result_labor)) {
$rs_cart_labor_id = "$rs_result_labor_q->cart_item_id";
$rs_cart_labor_price = "$rs_result_labor_q->cart_price";
$rs_cart_labor_desc = "$rs_result_labor_q->labor_desc";
$rs_cart_labor_printdesc = "$rs_result_labor_q->printdesc";
$lorigprice = "$rs_result_labor_q->origprice";
$ldiscounttype = "$rs_result_labor_q->discounttype";
$lprice_alt = "$rs_result_labor_q->price_alt";
$ltaxex = "$rs_result_labor_q->taxex";
$litemtax = "$rs_result_labor_q->itemtax";
$lunit_price = "$rs_result_labor_q->unit_price";
$lquantity = "$rs_result_labor_q->quantity";
$ldiscountname = "$rs_result_labor_q->discountname";

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


$message .= "<tr><td width=5%>".qf("$lquantity")."</td><td width=50%>$rs_cart_labor_desc";
$pearhtml .= "<tr><td width=5%>".qf("$lquantity")."</td><td width=50%>$rs_cart_labor_desc";
$peartext .= qf("$lquantity")."\n\t$rs_cart_labor_desc";

if($rs_cart_labor_printdesc != "") {
$message .= "<br><small>".nl2br("$rs_cart_labor_printdesc")."</small><br><br>";
$pearhtml .= "<br><small>".nl2br("$rs_cart_labor_printdesc")."</small><br><br>";
$peartext .= "\n".nl2br("$rs_cart_labor_printdesc")."\n\n";
}



if (($lprice_alt == 1) && ($lorigprice > $lunit_price)) {
$message .= "<br>";
$pearhtml .= "<br>";
$ldisc = explode('|',"$ldiscounttype");
if("$ldisc[0]" == "percent") {
$message .= "<font size=1><i>$ldiscountname</i></font>";
$pearhtml .= "<font size=1><i>$ldiscountname</i></font>";
} elseif("$ldisc[0]" == "custom") {
$message .= "<font size=1><i>$ldiscountname</i></font>";
$pearhtml .= "<font size=1><i>$ldiscounname</i></font>";
} else {

}
}

$message .= "</td><td width=15% align=right>".limf("$lunit_price","$lunit_tax")."</td><td width=15% align=right>$money".limf("$rs_cart_labor_price","$litemtax");
$pearhtml .= "</td><td width=15% align=right>".limf("$lunit_price","$lunit_tax")."</td><td width=15% align=right>$money".limf("$rs_cart_labor_price","$litemtax");
$peartext .= "\n\t\t\t\t\t".limf("$lunit_price","$lunit_tax")."\t\t".limf("$rs_cart_labor_price","$litemtax");

if (($lprice_alt == 1) && ($lorigprice > $lunit_price)) {
$lorigunitpricetax = $lorigprice * getservicetaxrate($ltaxex);
$message .= "<br><font size=1><i>".pcrtlang("was")." $money".limf("$lorigprice","$lorigunitpricetax")."</i></font>";
$pearhtml .= "<br><font size=1><i>".pcrtlang("was")." $money".limf("$lorigprice","$lorigunitpricetax")."</i></font>";
}

$message .= "</td><td align=right>\n";
$pearhtml .= "</td><td align=right>\n";

reset($laboritemtax);
foreach($laboritemtax as $key => $val) {
$shortname = gettaxshortname($key);
if($val != 0) {
$message .= "<font size=1>$shortname: $money".mf("$val")."</font><br>";
$pearhtml .= "<font size=1>$shortname: $money".mf("$val")."</font><br>";
$peartext .= "\t $shortname: $money".mf("$val")."\n";
}
}
unset($laboritemtax);


$message .= "</td></tr>\n";
$pearhtml .= "</td></tr>\n";
}


$message .= "<tr><td width=100% colspan=5>&nbsp;<br><br></td></tr>\n";
$pearhtml .= "<tr><td width=100% colspan=5>&nbsp;<br><br></td></tr>\n";

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

$message .= "<tr><td width=5%>&nbsp;</td><td width=80% align=right colspan=3>".pcrtlang("Parts Subtotal").":</td><td width=15% align=right>$money".limf("$rs_total_parts","$rs_total_parts_tax")."</td></tr>\n";
$pearhtml .= "<tr><td width=5%>&nbsp;</td><td width=80% align=right colspan=3>".pcrtlang("Parts Subtotal").":</td><td width=15% align=right>$money".limf("$rs_total_parts","$rs_total_parts_tax")."</td></tr>\n";
$peartext .= "\n\n\n\t\t\t\t\t".pcrtlang("Parts Subtotal").":\t".limf("$rs_total_parts","$rs_total_parts_tax");

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
$message .= "<tr><td width=5%>&nbsp;</td><td width=80% align=right colspan=3>".pcrtlang("Labor Total").":</td><td width=15% align=right>$money".limf("$rs_total_labor","$rs_total_labor_tax")."</td></tr>\n";
$pearhtml .= "<tr><td width=5%>&nbsp;</td><td width=80% align=right colspan=3>".pcrtlang("Labor Total").":</td><td width=15% align=right>$money".limf("$rs_total_labor","$rs_total_labor_tax")."</td></tr>\n";
$peartext .= "\n\t\t\t\t\t".pcrtlang("Labor Total")."\t".limf("$rs_total_labor","$rs_total_labor_tax");

$rs_find_labortax_total = "SELECT SUM(itemtax) AS total_labortax_price FROM invoice_items WHERE cart_type = 'labor' AND invoice_id = '$invoice_id'";
$rs_find_result_taxlabor_total = mysqli_query($rs_connect, $rs_find_labortax_total);
while($rs_find_result_labortax_total_q = mysqli_fetch_object($rs_find_result_taxlabor_total)) {
$rs_total_labortax = "$rs_find_result_labortax_total_q->total_labortax_price";

$servicetax = $rs_total_labortax;

}


$message .= "<tr><td width=5%>&nbsp;</td><td width=80% align=right colspan=3>&nbsp;</td><td width=15%>&nbsp;</td></tr>\n";
$pearhtml .= "<tr><td width=5%>&nbsp;</td><td width=80% align=right colspan=3>&nbsp;</td><td width=15%>&nbsp;</td></tr>\n";
$peartext .= "\n";

$grand_total = (tnv($salestax) + tnv($rs_total_parts) + tnv($rs_total_labor) + tnv($servicetax));

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
$message .= "<tr><td width=5%></td><td width=80% align=right colspan=3>$taxname:</td><td width=15% align=right>$money".mf("$taxtotal")."</td></tr>";
$pearhtml .= "<tr><td width=5%></td><td width=80% align=right colspan=3>$taxname:</td><td width=15% align=right>$money".mf("$taxtotal")."</td></tr>";
$peartext .= "\t\t\t\t\t$taxname: \t$money".mf("$taxtotal");
}
}



$message .= "<tr><td width=5%>&nbsp;</td><td width=80% align=right colspan=3>&nbsp;</td><td width=15%>&nbsp;</td></tr>\n";
$pearhtml .= "<tr><td width=5%>&nbsp;</td><td width=80% align=right colspan=3>&nbsp;</td><td width=15%>&nbsp;</td></tr>\n";

$message .= "<tr><td width=5%></td>\n<td width=80% align=right colspan=3><h3>".pcrtlang("Invoice Total").":</h3></td>";
$pearhtml .= "<tr><td width=5%></td>\n<td width=80% align=right colspan=3><h3>".pcrtlang("Invoice Total").":</h3></td>";
$peartext .= "\n\t\t\t\t\t".pcrtlang("Invoice Total").":";
$message .= "<td width=15% align=right><h3>$money".mf("$grand_total")."</h3></td></tr>\n";
$pearhtml .= "<td width=15% align=right><h3>$money".mf("$grand_total")."</h3></td></tr>\n";
$peartext .= "\t".mf("$grand_total");



if(("$iorq" == "invoice") && ($invstatus == 1)) {

$finddepositstotal = "SELECT * FROM deposits WHERE invoiceid = '$invoice_id'";
$finddepositsqtotal = @mysqli_query($rs_connect, $finddepositstotal);

if(mysqli_num_rows($finddepositsqtotal) > 0) {

while($rs_find_deposits_q = mysqli_fetch_object($finddepositsqtotal)) {
$depositid = "$rs_find_deposits_q->depositid";
$depositamount = "$rs_find_deposits_q->amount";
$checknumber = "$rs_find_deposits_q->chk_number";

$message .= "<tr><td width=5%></td><td width=80% align=right colspan=3><h2>".pcrtlang("Deposit ID").": #$depositid";
$pearhtml .= "<tr><td width=5%></td><td width=80% align=right colspan=3><h2>".pcrtlang("Deposit ID").": #$depositid";
$peartext .= "\n\t\t\t\t\t".pcrtlang("Deposit ID").": \t#$depositid";

if($checknumber != "") {
$message .= " | ".pcrtlang("Check No.")." #$checknumber";
$pearhtml .= " | ".pcrtlang("Check No.")." #$checknumber";
$peartext .= "\t".pcrtlang("Check No.")." #$checknumber";
}

$message .= "</h2></td><td width=15% align=right><h2>$money".mf("$depositamount")."</h2></td></tr>";
$pearhtml .= "</h2></td><td width=15% align=right><h2>$money".mf("$depositamount")."</h2></td></tr>";
$peartext .= "\t".mf("$depositamount")."\n";

}


$finddeposits = "SELECT SUM(amount) AS totaldep FROM deposits WHERE invoiceid = '$invoice_id'";
$finddepositsq = @mysqli_query($rs_connect, $finddeposits);


$finddepositsa = mysqli_fetch_object($finddepositsq);
$totaldep = "$finddepositsa->totaldep";
$balance = $grand_total - $totaldep;

$message .= "<tr><td width=5%></td><td width=80% align=right colspan=3><h2>".pcrtlang("Total Deposits").":</h2></td>";
$message .= "<td width=15% align=right><h2>$money".mf("$totaldep")."</h2></td></tr>";
$pearhtml .= "<tr><td width=5%></td><td width=80% align=right colspan=3><h2>".pcrtlang("Total Deposits").":</h2></td>";
$pearhtml .= "<td width=15% align=right><h2>$money".mf("$totaldep")."</h2></td></tr>";
$peartext .= "\t\t\t\t\t".pcrtlang("Total Deposits").":";
$peartext .= "\t".mf("$totaldep")."\n";


$message .= "<tr><td width=5%></td><td width=80% align=right colspan=3><h3>".pcrtlang("Balance Due").":</h3></td>";
$message .= "<td width=15% align=right><h3>$money".mf("$balance")."</h3></td></tr>";
$pearhtml .= "<tr><td width=5%></td><td width=80% align=right colspan=3><h3>".pcrtlang("Balance Due").":</h3></td>";
$pearhtml .= "<td width=15% align=right><h3>$money".mf("$balance")."</h3></td></tr>";
$peartext .= "\t\t\t\t\t".pcrtlang("Balance Due").":\t";
$peartext .= mf("$balance");

}

}


$message .= "</table>\n\n";
$pearhtml .= "</table>\n\n";


if ($iorq == "invoice") {


if($receipt_id == 0) {

if ((isset($paypalonlineemail)) && (!isset($depositsexist))) {
if ($paypalonlineemail != "") {
$paypalonlineitemname = urlencode("Pay Invoice #$invoice_id");
$paypalonlinelink = "https://www.paypal.com/cgi-bin/webscr?business=$paypalonlineemail&cmd=_xclick&currency_code=$paypalcountrycurrencycode&amount=".mf("$grand_total")."&item_name=$paypalonlineitemname";
$message .= "<center><br><br><a href=\"$paypalonlinelink\">".pcrtlang("Pay this Invoice with PayPal")."</a>
<br>".pcrtlang("Paypal is a easy, safe way to pay this invoice using a credit card. No PayPal account is required!")."</center><br><br>\n\n";
$pearhtml .= "<center><br><br><a href=\"$paypalonlinelink\">".pcrtlang("Pay this Invoice with PayPal")."</a>
<br>".pcrtlang("Paypal is a easy, safe way to pay this invoice using a credit card. No PayPal account is required!")."</center><br><br>\n\n";
$peartext .= "\n\n".pcrtlang("Click Here to Pay this Invoice Using PayPal")."\n$paypalonlinelink\n\n";
}
}


if ((isset($paypalonlineemail)) && (isset($depositsexist))) {
if ($paypalonlineemail != "") {
$paypalonlineitemname = urlencode("Pay Invoice #$invoice_id");
$paypalonlinelink = "https://www.paypal.com/cgi-bin/webscr?business=$paypalonlineemail&cmd=_xclick&currency_code=$paypalcountrycurrencycode&amount=".mf("$balance")."&item_name=$paypalonlineitemname";
$message .= "<center><br><br><a href=\"$paypalonlinelink\">".pcrtlang("Pay this Invoice Balance with PayPal")."</a>
<br>".pcrtlang("Paypal is a easy, safe way to pay this invoice using a credit card. No PayPal account is required!")."</center><br><br>\n\n";
$pearhtml .= "<center><br><br><a href=\"$paypalonlinelink\">".pcrtlang("Pay this Invoice Balance with PayPal")."</a>
<br>".pcrtlang("Paypal is a easy, safe way to pay this invoice using a credit card. No PayPal account is required!")."</center><br><br>\n\n";
$peartext .= "\n\n".pcrtlang("Click Here to Pay this Invoice Using PayPal")."\n$paypalonlinelink\n\n";
}
}



} else {
$message .= "<center><br><br>".pcrtlang("This Invoice was paid on Receipt")." #$receipt_id</center><br><br>";
$pearhtml .= "<center><br><br>".pcrtlang("This Invoice was paid on Receipt")." #$receipt_id</center><br><br>";
$peartext .= "\n\n".pcrtlang("This Invoice was paid on Receipt")." #$receipt_id\n\n";
}


$invoiceterms = getinvoicetermstitle($invoicetermsid);

$message .= "<center>";
$message .= "<span class=sizemelarger>".pcrtlang("Invoice Terms").": $invoiceterms</span><br>";
$duedate2 = pcrtdate("$pcrt_longdate", "$duedate");
$message .= pcrtlang("Due Date").": $duedate2<br>";
$message .= nl2br($storeinfoarray['invoicefooter']);
$message .= "</center></body></html>\n\n";
$pearhtml .= "<center>";
$pearhtml .= pcrtlang("Invoice Terms").": $invoiceterms<br>";
$pearhtml .= pcrtlang("Due Date").": $duedate2<br>";
$pearhtml .= nl2br($storeinfoarray['invoicefooter']);
$pearhtml .= "</center></body></html>\n\n";
$peartext .= "\n\n";
$peartext .= pcrtlang("Invoice Terms").": $invoiceterms\n";
$peartext .= pcrtlang("Due Date").": $duedate2\n\n";
$peartext .= $storeinfoarray['invoicefooter'];
} else {
$message .= "<center>";
$message .= pcrtlang("Invoice Terms").": $invoiceterms<br>";
$message .= nl2br($storeinfoarray['quotefooter']);
$message .= "</center></body></html>\n\n";
$pearhtml .= "<center>";
$pearhtml .= pcrtlang("Invoice Terms").": $invoiceterms<br>";
$pearhtml .= nl2br($storeinfoarray['quotefooter']);
$pearhtml .= "</center></body></html>\n\n";
$peartext .= "\n\n";
$peartext .= pcrtlang("Invoice Terms").": $invoiceterms\n\n";
$peartext .= $storeinfoarray['quotefooter'];
}





# View Output No Email
# die($pearhtml);



$message .= "\n\n--PHP-alt-$random_hash--\n\n";


if (!isset($pcrt_mailer)) {
$pcrt_mailer = "mail";
}

if ($pcrt_mailer == "mail") {

$mail_sent = @mail( $to, $subject, $message, $headers );
if($mail_sent) {
$infopass .= pcrtlang("Invoice")." #$invoice_id ".pcrtlang("Sent to")." $to<br>";

if ($rs_woid != "") {
$rs_woids = explode_list($rs_woid);
foreach($rs_woids as $key => $rs_woidids) {
userlog(15,$rs_woidids,'woid',"$ilabel ".pcrtlang("sent for Work Order"));
}
}



} else {
$infopass .= pcrtlang("Failed to send Invoice")." #$invoice_id ".pcrtlang("to")." $to<br>";
$sendingerror = 1;
}

} elseif (($pcrt_mailer == "pearsmtp") || ($pcrt_mailer == "pearsmtpauth") || ($pcrt_mailer == "pearphpmailer")) {


    $pearmessage2 = new Mail_mime();

    $pearmessage2->setTXTBody($peartext);
    $pearmessage2->setHTMLBody($pearhtml);

$imagetype = substr("$logo", -3);
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
$infopass .= $mailresult->getMessage() . "<br><br>";
$sendingerror = 1;
  } else {
$infopass .= pcrtlang("Invoice")." #$invoice_id ".pcrtlang("sent to")." $to<br>";

if ($rs_woid != "") {
$rs_woids = explode_list($rs_woid);
foreach($rs_woids as $key => $rs_woidids) {
userlog(15,$rs_woidids,'woid',"$ilabel ".pcrtlang("sent for Work Order"));
}
}



  }

} else {
$infopass .= "Error: invalid mailer specified in the deps.php config file";
}



}

if ((count($invoicearray) == 1) && ($sendingerror == 0) && (!array_key_exists('pinvoice_id', $_REQUEST))) {
echo "<html><head><meta http-equiv=\"refresh\" content=\"2;url=$returnurl\"></head><body>";
echo "$infopass";
echo "<br><a href=$returnurl>".pcrtlang("Return")."</a></body></html>";
} else {

if(!array_key_exists('pinvoice_id', $_REQUEST)) {
echo "<html><head></head><body>";
echo "$infopass";
echo "<br><a href=$returnurl>".pcrtlang("Return")."</a></body></html>";
} else {
echo "<html><head></head><body>";
echo "$infopass";

$pinvoice_id2 = $_REQUEST['pinvoice_id'];


if(!is_array($pinvoice_id2)) {
if (strpos($pinvoice_id2, '_') !== false) {
$pinvoice_id = array_filter(explode("_", "$pinvoice_id2"));
} else {
$pinvoice_id = array("$pinvoice_id2");
}
} else {
$pinvoice_id = $pinvoice_id2;
}


$thefurl = "&invoice_id=";

foreach($pinvoice_id as $key => $pinvoice_id3) {
$thefurl .= "$pinvoice_id3"."_";
}

if(count($pinvoice_id) > 0) {
$thefurl = substr("$thefurl", 0, -1);
}


echo "<br><br><a href=\"invoice.php?func=printinv$thefurl\">".pcrtlang("Print Invoices")."</a>";
}

}


}


######################################################################################################################

function emailinv2() {
require_once("validate.php");
require_once("dheader.php");
require("deps.php");

$emailaddy = $_REQUEST['emailaddy'];
$invoice_id = $_REQUEST['invoice_id'];

if (array_key_exists("returnurl",$_REQUEST)) {
$returnurl = $_REQUEST['returnurl'];
} else {
$returnurl = "invoice.php";
}


dheader(pcrtlang("Email Invoice/Quote"));

echo "<br><form action=invoice.php?func=emailinv3 method=POST data-ajax=\"false\">".pcrtlang("Email Address").": <input type=text value=\"$emailaddy\" name=emailaddy><input type=hidden value=$invoice_id name=invoice_id><input type=hidden value=\"$returnurl\" name=returnurl>";
echo "<input type=submit value=\"".pcrtlang("Send Email Invoice/Quote")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Emailing Invoice/Quote")."...'; this.form.submit();\" data-theme=\"b\"></form>";


dfooter();

require_once("dfooter.php");


}


##########

function emailinv3() {
require_once("validate.php");
require_once("common.php");
require("deps.php");

$emailaddy = $_REQUEST['emailaddy'];
$invoice_id = $_REQUEST['invoice_id'];
$returnurl2 = $_REQUEST['returnurl'];

$returnurl = urlencode($returnurl2);




$rs_rm_cart = "UPDATE invoices SET invemail = '$emailaddy'  WHERE invoice_id = '$invoice_id'";
@mysqli_query($rs_connect, $rs_rm_cart);

header("Location: invoice.php?func=emailinv&invoice_id=$invoice_id&returnurl=$returnurl");


}

############################################################################################################

function checkoutinv() {
require_once("validate.php");
require("deps.php");
require("common.php");

$invoice_id = pv($_REQUEST['invoice_id']);

if (array_key_exists('woid',$_REQUEST)) {
$custwoid =   pv($_REQUEST['woid']);
} else {
$custwoid = "";
}

if (array_key_exists('pcgroupid',$_REQUEST)) {
$pcgroupid =   pv($_REQUEST['pcgroupid']);
} else {
$pcgroupid = "0";
}


if (array_key_exists('custname',$_REQUEST)) {
$custname =  pv($_REQUEST['custname']);
} else {
$custname = "";
}

if (array_key_exists('company',$_REQUEST)) {
$company =  pv($_REQUEST['company']);
} else {
$company = "";
}


if (array_key_exists('custaddy1',$_REQUEST)) {
$custaddy1 =  pv($_REQUEST['custaddy1']);
} else {
$custaddy1 = "";
}

if (array_key_exists('custaddy2',$_REQUEST)) {
$custaddy2 =  pv($_REQUEST['custaddy2']);
} else {
$custaddy2 = "";
}

if (array_key_exists('custcity',$_REQUEST)) {
$custcity =  pv($_REQUEST['custcity']);
} else {
$custcity = "";
}

if (array_key_exists('custstate',$_REQUEST)) {
$custstate =  pv($_REQUEST['custstate']);
} else {
$custstate = "";
}

if (array_key_exists('custzip',$_REQUEST)) {
$custzip =  pv($_REQUEST['custzip']);
} else {
$custzip = "";
}

if (array_key_exists('custphone',$_REQUEST)) {
$custphone =  pv($_REQUEST['custphone']);
} else {
$custphone = "";
}

if (array_key_exists('custemail',$_REQUEST)) {
$custemail =  pv($_REQUEST['custemail']);
} else {
$custemail = "";
}




$rs_clear_cust = "DELETE FROM currentcustomer WHERE byuser = '$ipofpc'";
@mysqli_query($rs_connect, $rs_clear_cust);

$rs_insert_cust = "INSERT INTO currentcustomer (cfirstname,ccompany,caddress,caddress2,ccity,cstate,czip,cphone,cemail,woid,invoiceid,byuser,pcgroupid) VALUES ('$custname','$company','$custaddy1','$custaddy2','$custcity','$custstate','$custzip','$custphone','$custemail','$custwoid','$invoice_id','$ipofpc','$pcgroupid')";
@mysqli_query($rs_connect, $rs_insert_cust);


$rs_find_cart_items = "SELECT * FROM invoice_items WHERE invoice_id = '$invoice_id'";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);
$rs_rm_cart = "DELETE FROM cart WHERE ipofpc = '$ipofpc'";
@mysqli_query($rs_connect, $rs_rm_cart);


while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_cart_price = "$rs_result_q->cart_price";
$rs_cart_type = "$rs_result_q->cart_type";
$rs_cart_stock_id = "$rs_result_q->cart_stock_id";
$rs_labor_desc = pv($rs_result_q->labor_desc);
$rs_printdesc = pv($rs_result_q->printdesc);
$rs_return_sold_id = "$rs_result_q->return_sold_id";
$rs_restocking_fee = "$rs_result_q->restocking_fee";
$rs_price_alt = "$rs_result_q->price_alt";
$rs_taxex = "$rs_result_q->taxex";
$rs_itemtax = "$rs_result_q->itemtax";
$rs_origprice = "$rs_result_q->origprice";
$rs_discounttype = "$rs_result_q->discounttype";
$rs_ourprice = "$rs_result_q->ourprice";
$rs_itemserial = "$rs_result_q->itemserial";
$rs_addtime = "$rs_result_q->addtime";
$rs_unit_price = "$rs_result_q->unit_price";
$rs_quantity = "$rs_result_q->quantity";
$rs_discountname = "$rs_result_q->discountname";

$rs_insert_cart = "INSERT INTO cart (cart_price,cart_type,cart_stock_id,labor_desc,return_sold_id,restocking_fee,price_alt,ipofpc,taxex,itemtax,origprice,discounttype,ourprice,itemserial,addtime,unit_price,quantity,printdesc,discountname) VALUES ('$rs_cart_price','$rs_cart_type','$rs_cart_stock_id','$rs_labor_desc','$rs_return_sold_id','$rs_restocking_fee','$rs_price_alt','$ipofpc','$rs_taxex','$rs_itemtax','$rs_origprice','$rs_discounttype','$rs_ourprice','$rs_itemserial','$rs_addtime','$rs_unit_price','$rs_quantity','$rs_printdesc','$rs_discountname')";
@mysqli_query($rs_connect, $rs_insert_cart);

}


header("Location: cart.php");
}


############################################################################################################

function changeinvoicestatus() {
require_once("validate.php");                                                                                                                                                                                                         
require("deps.php");
require("common.php");


if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}

if (array_key_exists('returnurl',$_REQUEST)) {
$returnurl = $_REQUEST['returnurl'];
} else {
$returnurl = "invoice.php";
}


$invoice_id = $_REQUEST['invoice_id'];
$invstatus = $_REQUEST['invstatus'];



$rs_rm_cart = "UPDATE invoices SET invstatus = '$invstatus'  WHERE invoice_id = '$invoice_id'";
@mysqli_query($rs_connect, $rs_rm_cart);
                                                                                                                                                                                                         
                                                                                                                                                                                                         
header("Location: $returnurl");
}





###########


function editinvoice() {

require_once("common.php");

require("dheader.php");


$invoice_id = $_REQUEST['invoice_id'];

if (array_key_exists('returnurl',$_REQUEST)) {
$returnurl = $_REQUEST['returnurl'];
} else {
$returnurl = "invoice.php";
}

$iorq = invoiceorquote($invoice_id);
if ($iorq == "quote") {
$ilabel = pcrtlang("Quote");
} else {
$ilabel = pcrtlang("Invoice");
}


dheader(pcrtlang("Edit")." $ilabel");




$rs_find_name = "SELECT * FROM invoices WHERE invoice_id = '$invoice_id'";
$rs_result_name = mysqli_query($rs_connect, $rs_find_name);

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
$rs_email = "$rs_result_name_q->invemail";
$rs_invnotes = "$rs_result_name_q->invnotes";
$invoicetermsidindb = "$rs_result_name_q->invoicetermsid";

echo "<form action=../store/invoice.php?func=editinvoice2 method=post data-ajax=\"false\">";
echo pcrtlang("Customer Name").":<input type=text name=invname value=\"$rs_soldto\">";
echo pcrtlang("Company").":<input type=text name=invcompany value=\"$rs_company\">";
echo "$pcrt_address1:<input type=text name=invaddy1 value=\"$rs_ad1\">";
echo "$pcrt_address2:<input type=text name=invaddy2 value=\"$rs_ad2\">";
echo "$pcrt_city:<input type=text name=invcity value=\"$rs_city\">";
echo "$pcrt_state:<input type=text name=invstate value=\"$rs_state\">";
echo "$pcrt_zip:<input type=text name=invzip value=\"$rs_zip\">";
echo pcrtlang("Customer Phone").":<input type=text name=invphone value=\"$rs_ph\">";
echo pcrtlang("Customer Email").":<input type=text name=invemail value=\"$rs_email\">";

$rs_datesold2 = date("Y-m-d", strtotime($rs_datesold));
$rs_time = date("H:i:s", strtotime($rs_datesold));

echo pcrtlang("Invoice Date").":<input id=invdate type=date name=invdate value=\"$rs_datesold2\">";
echo "<input type=text name=invtime value=\"$rs_time\">";



echo pcrtlang("Invoice or Quote?").":<select name=iorq>";
if ($iorq == "invoice") {
echo "<option selected value=invoice>".pcrtlang("Invoice")."</option><option value=quote>".pcrtlang("Quote")."</option>";
} else {
echo "<option selected value=quote>".pcrtlang("Quote")."</option><option value=invoice>".pcrtlang("Invoice")."</option>";
}

echo "</select>";

echo "<tr><td>".pcrtlang("Invoice Terms?").":</td><td><select name=invoicetermsid>";

$rs_sl = "SELECT * FROM invoiceterms ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_sl);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$invoicetermsid = "$rs_result_q1->invoicetermsid";
$invoicetermstitle = "$rs_result_q1->invoicetermstitle";
$invoicetermsdays = "$rs_result_q1->invoicetermsdays";
$invoicetermslatefee = "$rs_result_q1->invoicetermslatefee";
$invoicetermsdefault = "$rs_result_q1->invoicetermsdefault";

if ($invoicetermsidindb == "$invoicetermsid") {
echo "<option selected value=$invoicetermsid>$invoicetermstitle ($invoicetermslatefee% ".pcrtlang("Late Fee").")</option>";
} else {
echo "<option value=$invoicetermsid>$invoicetermstitle ($invoicetermslatefee% ".pcrtlang("Late Fee").")</option>";
}

}

echo "</select></td></tr>";


echo pcrtlang("Notes").": <textarea name=invnotes>$rs_invnotes</textarea>";

echo "<tr><td></td><td><input type=hidden name=returnurl value=\"$returnurl\"><input type=hidden name=invoice_id value=\"$invoice_id\"><input type=submit class=ibutton value=\"".pcrtlang("Save")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Saving")."...'; this.form.submit();\" data-theme=\"b\"></form>";

dfooter();
require_once("dfooter.php");


}


function editinvoice2() {
require_once("validate.php");
require("deps.php");
require("common.php");

$invoice_id = $_REQUEST['invoice_id'];
$invname = pv($_REQUEST['invname']);
$invcompany = pv($_REQUEST['invcompany']);
$invaddy1 = pv($_REQUEST['invaddy1']);
$invaddy2 = pv($_REQUEST['invaddy2']);
$invphone = pv($_REQUEST['invphone']);
$invemail = pv($_REQUEST['invemail']);
$invcity = pv($_REQUEST['invcity']);
$invstate = pv($_REQUEST['invstate']);
$invzip = pv($_REQUEST['invzip']);
$invdate3 = pv($_REQUEST['invdate']." ".$_REQUEST['invtime']);
$returnurl = $_REQUEST['returnurl'];
$invnotes = pv($_REQUEST['invnotes']);
$iorq = $_REQUEST['iorq'];
$invoicetermsid = $_REQUEST['invoicetermsid'];

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}

if (($invdate2 = strtotime($invdate3)) === false) {
$invdate = date('Y-m-d H:i:s');
} else {
$invdate = date('Y-m-d H:i:s', $invdate2);
}




$currentdatetime = date('Y-m-d H:i:s');

$rs_sl = "SELECT * FROM invoiceterms WHERE invoicetermsid = '$invoicetermsid'";
$rs_result1 = mysqli_query($rs_connect, $rs_sl);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$invoicetermsdays = "$rs_result_q1->invoicetermsdays";

$duedate = date('Y-m-d H:i:s', (strtotime($invdate) + ($invoicetermsdays * 86400)));




$rs_update_invoice = "UPDATE invoices SET invname = '$invname', invcompany = '$invcompany', invaddy1 = '$invaddy1', invaddy2 = '$invaddy2', invphone = '$invphone', invcity = '$invcity', invstate = '$invstate', invzip = '$invzip', invdate = '$invdate', invemail = '$invemail', invnotes = '$invnotes', iorq = '$iorq', invoicetermsid = '$invoicetermsid', duedate = '$duedate' WHERE invoice_id = '$invoice_id'";
@mysqli_query($rs_connect, $rs_update_invoice);

header("Location: $returnurl");

}

function deletequote() {
require_once("validate.php");
require("deps.php");
require("common.php");


if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}

if (array_key_exists('returnurl',$_REQUEST)) {
$returnurl = $_REQUEST['returnurl'];
} else {
$returnurl = "invoice.php?func=browsequotes";
}

$invoice_id = $_REQUEST['invoice_id'];



$rs_rm_inv = "DELETE FROM invoices WHERE invoice_id = '$invoice_id'";
@mysqli_query($rs_connect, $rs_rm_inv);
                                    
$rs_rm_invitems = "DELETE FROM invoice_items WHERE invoice_id = '$invoice_id'";
@mysqli_query($rs_connect, $rs_rm_invitems);

$rs_rm_invrec = "UPDATE receipts SET invoice_id  = '0' WHERE invoice_id = '$invoice_id'";
@mysqli_query($rs_connect, $rs_rm_invrec);

header("Location: $returnurl");
}


function deleteinvoice() {
require_once("validate.php");
require("deps.php");
require("common.php");


if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}

perm_boot("15");

if (array_key_exists('returnurl',$_REQUEST)) {
$returnurl = $_REQUEST['returnurl'];
} else {
$returnurl = "invoice.php";
}

$invoice_id = $_REQUEST['invoice_id'];



$rs_rm_inv = "DELETE FROM invoices WHERE invoice_id = '$invoice_id'";
@mysqli_query($rs_connect, $rs_rm_inv);

$rs_rm_invitems = "DELETE FROM invoice_items WHERE invoice_id = '$invoice_id'";
@mysqli_query($rs_connect, $rs_rm_invitems);

$rs_rm_bc = "DELETE FROM blockcontracthours WHERE invoiceid = '$invoice_id'";
@mysqli_query($rs_connect, $rs_rm_bc);


header("Location: $returnurl");
}



function recurringinvoices() {
require_once("header.php");
require("deps.php");

if (array_key_exists('pageNumber',$_REQUEST)) {
$pageNumber = $_REQUEST['pageNumber'];
} else {
$pageNumber = 1;
}

$results_per_page = 40;

$offset = ($pageNumber * $results_per_page) - $results_per_page;








echo "<div data-role=\"navbar\">";
echo "<ul>";
echo "<li><a href=\"invoice.php\">".pcrtlang("Open Invoices")."</a></li>";
echo "<li><a href=\"invoice.php?func=allinvoices\">".pcrtlang("Browse All Invoices")."</a></li>";
echo "</ul>";
echo "</div>";
echo "<div data-role=\"navbar\">";
echo "<ul>";
echo "<li><a href=\"invoice.php?func=browsequotes\">".pcrtlang("Quotes")."</a></li>";
echo "<li><a href=\"invoice.php?func=recurringinvoices\" class=\"ui-btn-active\">".pcrtlang("Recurring Invoices")."</a></li>";
echo "</ul>";
echo "</div><br><br>";


start_status_box("52",pcrtlang("All Recurring Invoices"));


$rs_invoicest = "SELECT * FROM rinvoices";
$rs_find_invoicest = @mysqli_query($rs_connect, $rs_invoicest);


$rs_invoices = "SELECT * FROM rinvoices WHERE invactive != '2' ORDER BY invthrudate ASC LIMIT $offset,$results_per_page";
$rs_find_invoices = @mysqli_query($rs_connect, $rs_invoices);
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
$invthrudate2 = pcrtdate("$pcrt_longdate", "$invthrudate");
$invstoreid = "$rs_find_invoices_q->storeid";
$pcgroupid = "$rs_find_invoices_q->pcgroupid";
$blockcontractid = "$rs_find_invoices_q->blockcontractid";

$storeinfoarray = getstoreinfo($invstoreid);

$findinvtotal = "SELECT SUM(cart_price) AS invsubtotal, SUM(itemtax) AS invtax FROM rinvoice_items WHERE rinvoice_id = '$rinvoice_id'";
$findinvq = @mysqli_query($rs_connect, $findinvtotal);
$findinva = mysqli_fetch_object($findinvq);
$invtax = "$findinva->invtax";
$invsubtotal = "$findinva->invsubtotal";
$invtotal2 = $invtax + $invsubtotal;
$invtotal = number_format($invtotal2, 2, '.', '');
if ($invactive == 1) {
$thestatus = "Active";
} else {
$thestatus = "In-Active";
}


echo "<table class=standard><tr><th>";

echo "#$rinvoice_id $invname</th>";

echo "<th style=\"text-align:right;\">$money".mf("$invtotal")."</th></tr>";

if("$invcompany" != "") {
echo "<tr><td colspan=2>$invcompany</td></tr>";
}


if ($activestorecount > 1) {
echo "<tr><td colspan=2>".pcrtlang("Store").": $storeinfoarray[storesname]</td></tr>";
}

echo "<tr><td colspan=2>".pcrtlang("Invoice Thru Date").": $invthrudate</td></tr>";


$returnurl = urlencode("invoice.php?func=recurringinvoices&pageNumber=$pageNumber");

echo "<tr><td colspan=2>".pcrtlang("Status").": $thestatus</td></tr>";


echo "<tr><td colspan=2>";

echo "<div data-role=\"collapsible\" data-theme=\"a\" data-mini=\"true\">";
echo "<h3>".pcrtlang("Recurring Invoice Actions")."</h3>";

echo "<button type=button onClick=\"parent.location='rinvoice.php?func=viewrinvoice&rinvoice_id=$rinvoice_id&returnurl=$returnurl'\">".pcrtlang("View Recurring Invoice")."</button>";

if($pcgroupid != "0") {
echo "<button type=button onClick=\"parent.location='../repairmobile/group.php?func=viewgroup&pcgroupid=$pcgroupid'\">".pcrtlang("View PC Group")." #$pcgroupid</button>";
}

if($blockcontractid != "0") {
echo "<button type=button onClick=\"parent.location='../repairmobile/group.php?func=viewgroup&pcgroupid=$pcgroupid#botc'\">".pcrtlang("View Block of Time Contract")."</button>";
}


$rs_findsc = "SELECT * FROM servicecontracts WHERE rinvoice = '$rinvoice_id'";
$rs_resultsc = mysqli_query($rs_connect, $rs_findsc);

if(mysqli_num_rows($rs_resultsc) != 0) {
$rs_resultsc_q = mysqli_fetch_object($rs_resultsc);
$scid = "$rs_resultsc_q->scid";
$scname = "$rs_resultsc_q->scname";

echo  "<button type=button onClick=\"parent.location='../repairmobile/msp.php?func=viewservicecontract&scid=$scid'\">".pcrtlang("View Service Contract").":<br> $scname</button><br>";


}



echo "</div>";

echo "</td></tr></table><br>";
}

echo "<br>";

#browse here
$totalentry = mysqli_num_rows($rs_find_invoicest);
$prevpage = $pageNumber - 1;
$nextpage = $pageNumber + 1;
echo "<center>";
if ($pageNumber > 1) {
echo "<button type=button onClick=\"parent.location='invoice.php?func=recurringinvoices&pageNumber=$prevpage'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\">";
echo "<i class=\"fa fa-chevron-left fa-lg\"></i></button>";
}

$total_results = $totalentry;
$results_per_page = $results_per_page;
$html = get_paged_nav($total_results, $results_per_page, false);
echo "$html";
if (($totalentry / $results_per_page) > $pageNumber) {
echo "<button type=button onClick=\"parent.location='invoice.php?func=recurringinvoices&pageNumber=$nextpage'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\">";
echo "<i class=\"fa fa-chevron-left fa-lg\"></i></button>";
}

echo "</center>";

require_once("footer.php");

}


function savesig() {

require("deps.php");
require("common.php");

$output = pv($_REQUEST['sigImageData']);
$invoice_id = $_REQUEST['invoice_id'];

require_once("validate.php");




$rs_savesig = "UPDATE invoices SET thesig = '$output' WHERE invoice_id = '$invoice_id'";
@mysqli_query($rs_connect, $rs_savesig);

header("Location: invoice.php?func=printinv&invoice_id=$invoice_id");

}

function savesigtopaz() {

require("deps.php");
require("common.php");

$output = pv($_REQUEST['sigImageData']);
$invoice_id = $_REQUEST['invoice_id'];

require_once("validate.php");




$rs_savesig = "UPDATE invoices SET thesigtopaz = '$output' WHERE invoice_id = '$invoice_id'";
@mysqli_query($rs_connect, $rs_savesig);

header("Location: invoice.php?func=printinv&invoice_id=$invoice_id");

}



function clearsig() {

require("deps.php");
require("common.php");

$invoice_id = $_REQUEST['invoice_id'];

require_once("validate.php");




$rs_savesig = "UPDATE invoices SET thesig = '' WHERE invoice_id = '$invoice_id'";
@mysqli_query($rs_connect, $rs_savesig);

header("Location: invoice.php?func=printinv&invoice_id=$invoice_id");

}


function clearsigtopaz() {

require("deps.php");
require("common.php");

$invoice_id = $_REQUEST['invoice_id'];

require_once("validate.php");




$rs_savesig = "UPDATE invoices SET thesigtopaz = '' WHERE invoice_id = '$invoice_id'";
@mysqli_query($rs_connect, $rs_savesig);

header("Location: invoice.php?func=printinv&invoice_id=$invoice_id");

}



function hidesiginv() {

require("deps.php");
require("common.php");

$hidesig = pv($_REQUEST['hidesig']);
$invoice_id = $_REQUEST['invoice_id'];

require_once("validate.php");




$rs_hidesig = "UPDATE invoices SET showsiginv = '$hidesig' WHERE invoice_id = '$invoice_id'";
@mysqli_query($rs_connect, $rs_hidesig);

header("Location: invoice.php?func=printinv&invoice_id=$invoice_id");

}

function hidesiginvtopaz() {

require("deps.php");
require("common.php");

$hidesig = pv($_REQUEST['hidesig']);
$invoice_id = $_REQUEST['invoice_id'];

require_once("validate.php");




$rs_hidesig = "UPDATE invoices SET showsiginvtopaz = '$hidesig' WHERE invoice_id = '$invoice_id'";
@mysqli_query($rs_connect, $rs_hidesig);

header("Location: invoice.php?func=printinv&invoice_id=$invoice_id");

}




function printmultinv() {

require("deps.php");
require("common.php");

$invfrom = $_REQUEST['invfrom'];
$invto = $_REQUEST['invto'];

if (array_key_exists('returnurl',$_REQUEST)) {
$returnurl2 = $_REQUEST['returnurl'];
$returnurl = urlencode($returnurl2);
}

if ($invfrom > $invto) {
die(pcrtlang("Error: Invoice Start number must be smaller than ending number"));
}


if (($invto - $invfrom) > 205) {
die(pcrtlang("Error: Sorry, due to server limits you cannot print more than 200 invoices at a time."));
}


require_once("validate.php");


$invoice_id = "";

while ($invfrom <= $invto) {
$invoice_id .= "$invfrom"."_";
$invfrom++;
}




if (array_key_exists('returnurl',$_REQUEST)) {
header("Location: invoice.php?func=printinv&invoice_id=$invoice_id&returnurl=$returnurl");
} else {
header("Location: invoice.php?func=printinv&invoice_id=$invoice_id");
}


}


function searchinvoices2() {

require("deps.php");
require("common.php");

$searchterm = urlencode($_REQUEST['searchterm']);

require_once("validate.php");

header("Location: invoice.php?func=searchinvoices&searchterm=$searchterm");

}


function checkoutmultipleinv() {
require_once("validate.php");
require("deps.php");
require("common.php");

$checkoutinvs = $_REQUEST['invoice_id'];
$invtopullcontact = $checkoutinvs[0];



$rs_findowner = "SELECT * FROM invoices WHERE invoice_id = '$invtopullcontact'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
$rs_result_q2 = mysqli_fetch_object($rs_result2);
$cfirstname = pv("$rs_result_q2->invname");
$ccompany = pv("$rs_result_q2->invcompany");
$cphone = pv("$rs_result_q2->invphone");
$cemail = pv("$rs_result_q2->invemail");
$caddress = pv("$rs_result_q2->invaddy1");
$caddress2 = pv("$rs_result_q2->invaddy2");
$ccity = pv("$rs_result_q2->invcity");
$cstate = pv("$rs_result_q2->invstate");
$czip = pv("$rs_result_q2->invzip");
$cpcgroupid = "$rs_find_invoices_q->pcgroupid";


reset($checkoutinvs);

$cinvs = implode_list($checkoutinvs);

$allthewoids = array();

$rs_clear_cust = "DELETE FROM currentcustomer WHERE byuser = '$ipofpc'";
@mysqli_query($rs_connect, $rs_clear_cust);

$rs_rm_cart = "DELETE FROM cart WHERE ipofpc = '$ipofpc'";
@mysqli_query($rs_connect, $rs_rm_cart);
reset($checkoutinvs);

foreach($checkoutinvs as $key => $invs) {

$rs_find_cart_items = "SELECT * FROM invoice_items WHERE invoice_id = '$invs'";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_cart_price = "$rs_result_q->cart_price";
$rs_cart_type = "$rs_result_q->cart_type";
$rs_cart_stock_id = "$rs_result_q->cart_stock_id";
$rs_labor_desc = pv($rs_result_q->labor_desc);
$rs_print_desc = pv($rs_result_q->printdesc);
$rs_return_sold_id = "$rs_result_q->return_sold_id";
$rs_restocking_fee = "$rs_result_q->restocking_fee";
$rs_price_alt = "$rs_result_q->price_alt";
$rs_taxex = "$rs_result_q->taxex";
$rs_itemtax = "$rs_result_q->itemtax";
$rs_origprice = "$rs_result_q->origprice";
$rs_discounttype = "$rs_result_q->discounttype";
$rs_ourprice = "$rs_result_q->ourprice";
$rs_itemserial = "$rs_result_q->itemserial";
$rs_addtime = "$rs_result_q->addtime";
$rs_unit_price = "$rs_result_q->unit_price";
$rs_quantity = "$rs_result_q->quantity";
$rs_discountname = "$rs_result_q->discountname";

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

$rs_insert_cart = "INSERT INTO cart (cart_price,cart_type,cart_stock_id,labor_desc,return_sold_id,restocking_fee,price_alt,ipofpc,taxex,itemtax,origprice,discounttype,ourprice,itemserial,addtime,unit_price,quantity,printdesc,discountname) VALUES ('$rs_cart_price','$rs_cart_type','$rs_cart_stock_id','$rs_labor_desc','$rs_return_sold_id','$rs_restocking_fee','$rs_price_alt','$ipofpc','$rs_taxex','$rs_itemtax','$rs_origprice','$rs_discounttype','$rs_ourprice','$rs_itemserial','$rs_addtime','$rs_unit_price','$rs_quantity','$rs_print_desc','$rs_discountname')";
@mysqli_query($rs_connect, $rs_insert_cart);

$rs_findwoids = "SELECT * FROM invoices WHERE invoice_id = '$invs'";
$rs_result2wo = mysqli_query($rs_connect, $rs_findwoids);
$rs_result_q2wo = mysqli_fetch_object($rs_result2wo);
$woids = "$rs_result_q2wo->woid";

}

if($woids != "") {
$allthewoids = array_merge($allthewoids, explode_list("$woids"));
}



}

if(count($allthewoids) != 0) {
$allthewoids2 = implode_list($allthewoids);
} else {
$allthewoids2 = "";
}


$rs_insert_cust = "INSERT INTO currentcustomer (cfirstname,caddress,caddress2,ccity,cstate,czip,cphone,cemail,woid,invoiceid,byuser,pcgroupid) VALUES ('$cfirstname','$caddress','$caddress2','$ccity','$cstate','$czip','$cphone','$cemail','$allthewoids2','$cinvs','$ipofpc','$cpcgroupid')";
@mysqli_query($rs_connect, $rs_insert_cust);

header("Location: ../storemobile/cart.php");
}



switch($func) {
                                                                                                    
    default:
    invoices();
    break;
                                
    case "createinvoice":
    createinvoice();
    break;

  case "createinvoice2":
    createinvoice2();
    break;

    case "printinv":
    printinv();
    break;

  case "emailinv":
    emailinv();
    break;

    case "emailinv2":
    emailinv2();
    break;

   case "emailinv3":
    emailinv3();
    break;
                                   
    case "changeinvoicestatus":
    changeinvoicestatus();
    break;
                                 
    case "checkoutinv":
    checkoutinv();
    break;

 case "checkoutinv2":
    checkoutinv2();
    break;

 case "allinvoices":
    allinvoices();
    break;

case "searchinvoices":
    searchinvoices();
    break;

case "searchinvoices2":
    searchinvoices2();
    break;


case "editinvoice":
    editinvoice();
    break;

case "editinvoice2":
    editinvoice2();
    break;

case "browsequotes":
    browsequotes();
    break;

case "deletequote":
   deletequote();
    break;

case "deleteinvoice":
   deleteinvoice();
    break;


case "recurringinvoices":
   recurringinvoices();
    break;

case "savesig":
   savesig();
    break;

case "clearsig":
   clearsig();
    break;

case "hidesiginv":
   hidesiginv();
    break;

case "savesigtopaz":
   savesigtopaz();
    break;

case "clearsigtopaz":
   clearsigtopaz();
    break;

case "hidesiginvtopaz":
   hidesiginvtopaz();
    break;


case "printmultinv":
   printmultinv();
    break;

case "checkoutmultipleinv":
   checkoutmultipleinv();
    break;


}

?>
