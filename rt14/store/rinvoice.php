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

                                                                                                    

function createrinvoice() {

require_once("common.php");
if($gomodal != "1") {
require("header.php");
} else {
require_once("validate.php");
}



if($gomodal != "1") {
start_blue_box(pcrtlang("Create/Save Recurring Invoice"));
} else {
echo "<h4>".pcrtlang("Create/Save Recurring Invoice")."</h4>";
}

$cfirstname = $_REQUEST['cfirstname'];
$ccompany = $_REQUEST['ccompany'];
$caddress1 = $_REQUEST['caddress1'];
$caddress2 = $_REQUEST['caddress2'];
$ccity = $_REQUEST['ccity'];
$cstate = $_REQUEST['cstate'];
$czip = $_REQUEST['czip'];
$cphone =  $_REQUEST['cphone'];
$cemail =  $_REQUEST['cemail'];

if (array_key_exists('pcgroupid',$_REQUEST)) {
$pcgroupid = $_REQUEST['pcgroupid'];
} else {
$pcgroupid = 0;
}



if (array_key_exists('crinvoiceid',$_REQUEST)) {
$crinvoiceid2 = $_REQUEST['crinvoiceid'];
if ($crinvoiceid2 != "") {
$crinvoiceid = $crinvoiceid2;
} else {
$crinvoiceid = "0";
}
} else {
$crinvoiceid = "0";
}

$invoiceintervals = array('1W' => pcrtlang('Weekly'),'2W' => pcrtlang('Every 2 Weeks'),'1M' => pcrtlang('Monthly'),'2M' => pcrtlang('Every 2 Months'),'3M' => pcrtlang('Quarterly'),'6M' => pcrtlang('Every 6 Months'),'1Y' => pcrtlang('Yearly'),'2Y' => pcrtlang('2 Years'),'3Y' => pcrtlang('3 Years'),'4Y' => pcrtlang('4 Years'),'5Y' => pcrtlang('5 Years'));

if ($crinvoiceid == "0") {
if (isset($defaultinvoiceterms)) {
$invoiceterms = $defaultinvoiceterms;
} else {
$invoiceterms = 14;
}
if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdate = date('Y-m-d');
$invthrudate = $currentdate;

if (isset($recurringinvoiceinterval)) {
$invoiceinterval = $recurringinvoiceinterval;
} else {
$invoiceinterval = "1M";
}

if (isset($invoicetermsid)) {
$invoicetermsid = $invoicetermsid;
} else {
$invoicetermsid = getinvoicetermsdefault();
}


$invoiceactive = 1;
$invoicenotes = "";

$rstoreid = $defaultuserstore;
$blockcontractid = 0;
} else {




$rs_find_name = "SELECT * FROM rinvoices WHERE rinvoice_id = '$crinvoiceid'";
$rs_result_name = mysqli_query($rs_connect, $rs_find_name);
$rs_result_name_q = mysqli_fetch_object($rs_result_name);
$invthrudate = "$rs_result_name_q->invthrudate";
$invoiceterms = "$rs_result_name_q->invterms";
$invoiceinterval = "$rs_result_name_q->invinterval";
$invoiceactive = "$rs_result_name_q->invactive";
$invoicenotes = "$rs_result_name_q->invnotes";
$blockcontractid = "$rs_result_name_q->blockcontractid";
$blockhours = "$rs_result_name_q->blockhours";
$rstoreid = "$rs_result_name_q->storeid";
$invoicetermsid = "$rs_result_name_q->invoicetermsid";
}



echo "<form action=rinvoice.php?func=createrinvoice2 method=post>";
echo "<table width=100%><tr><td><table>";
echo "<tr><td>".pcrtlang("Customer Name").":</td><td><input size=35 class=textbox type=text name=invname value=\"$cfirstname\"></td></tr>";
echo "<tr><td>".pcrtlang("Company").":</td><td><input size=35 class=textbox type=text name=invcompany value=\"$ccompany\"></td></tr>";
echo "<tr><td>$pcrt_address1:</td><td><input size=35 type=text class=textbox name=invaddy1 value=\"$caddress1\"></td></tr>";
echo "<tr><td>$pcrt_address2:</td><td><input size=35 type=text class=textbox name=invaddy2 value=\"$caddress2\"></td></tr>";
echo "<tr><td>$pcrt_city, $pcrt_state $pcrt_zip</td><td><input size=13 type=text class=textbox name=invcity value=\"$ccity\">";
echo "<input size=7 type=text class=textbox name=invstate value=\"$cstate\">";
echo "<input size=8 type=text class=textbox name=invzip value=\"$czip\"></td></tr>";
echo "<tr><td>".pcrtlang("Customer Phone").":</td><td><input size=35 type=text class=textbox name=invphone value=\"$cphone\"></td></tr>";
echo "<tr><td>".pcrtlang("Customer Email").":</td><td><input size=35 type=text class=textbox name=invemail value=\"$cemail\"></td></tr>";

echo "<tr><td>".pcrtlang("Invoiced Thru Date").":</td><td><input size=35 type=text id=invthrudate class=textbox name=invthrudate value=\"$invthrudate\"></td></tr>";

?>
<script type="text/javascript" src="../repair/jq/datepickr.js"></script>
<script type="text/javascript">
new datepickr('invthrudate', { dateFormat: 'Y-m-d', theCurrentDate: document.getElementById("invthrudate").value });
</script>
<?php

echo "<tr><td>".pcrtlang("Invoice Inverval").":</td><td><select name=invinterval>";


foreach($invoiceintervals as $k => $v) {
if ($k == "$invoiceinterval") {
echo "<option selected value=$k>$v</option>";
} else {
echo "<option value=$k>$v</option>";
}
}



echo "</select></td></tr>";

echo "<tr><td>".pcrtlang("Recurring Invoice Active").":</td><td><select name=invactive>";
if ($invoiceactive == "1") {
echo "<option selected value=1>".pcrtlang("Yes")."</option>";
echo "<option value=0>".pcrtlang("No")."</option>";
} else {
echo "<option value=1>".pcrtlang("Yes")."</option>";
echo "<option selected value=0>".pcrtlang("No")."</option>";
}
echo "</select></td></tr>";

echo "<tr><td>".pcrtlang("Create Invoice in Advance").":<br><span class=\"sizemesmaller italme\">".pcrtlang("days prior to invoice thru date to re-invoice").".</span></td>";
echo "<td><input size=35 type=text class=textbox name=invterms value=\"$invoiceterms\"></td></tr>";

####

echo "<tr><td>".pcrtlang("Invoice Terms?").":</td><td><select name=invoicetermsid>";

$rs_sl = "SELECT * FROM invoiceterms ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_sl);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$invoicetermsidoptions = "$rs_result_q1->invoicetermsid";
$invoicetermstitle = "$rs_result_q1->invoicetermstitle";
$invoicetermsdays = "$rs_result_q1->invoicetermsdays";
$invoicetermslatefee = "$rs_result_q1->invoicetermslatefee";
$invoicetermsdefault = "$rs_result_q1->invoicetermsdefault";

if ($invoicetermsidoptions == "$invoicetermsid") {
echo "<option selected value=$invoicetermsidoptions>$invoicetermstitle ($invoicetermslatefee% ".pcrtlang("Late Fee").")</option>";
} else {
echo "<option value=$invoicetermsidoptions>$invoicetermstitle ($invoicetermslatefee% ".pcrtlang("Late Fee").")</option>";
}

}

echo "</select></td></tr>";




####




if($blockcontractid != 0) {
echo "<tr><td>".pcrtlang("Block of Time Hours").":<br><span class=\"sizemesmaller italme\">".pcrtlang("Enter the number of hours to add to the block of time contract per invoice cycle.").".</span></td>";
echo "<td><input size=35 type=text class=textbox name=blockhours value=\"$blockhours\"></td></tr>";
} 


###
if ($activestorecount > "1") {
$rs_find_stores = "SELECT * FROM stores WHERE storeenabled = '1' ORDER BY storesname ASC";
$rs_result_stores = mysqli_query($rs_connect, $rs_find_stores);

echo "<tr><td><span class=boldme>".pcrtlang("Store")."</span></td><td>";
echo "<select name=rstoreid>";

while($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
$rs_storesname = "$rs_result_storeq->storesname";
$rs_storeid = "$rs_result_storeq->storeid";

if ($rstoreid == $rs_storeid) {
echo "<option selected value=$rs_storeid>$rs_storesname</option>";
} else {
echo "<option value=$rs_storeid>$rs_storesname</option>";
}
}
echo "</select></td></tr>";
} else {
echo "<input type=hidden name=rstoreid value=\"$rstoreid\">";
}


###

echo "<tr><td>".pcrtlang("Group ID")."<br><span class=\"sizemesmaller italme\">".pcrtlang("only change to move to a different group<br>or zero for no group").".</span></td><td><input size=5 type=text class=textbox name=pcgroupid value=\"$pcgroupid\"></td></tr>";

echo "<tr><td></td><td><input type=hidden name=crinvoiceid value=\"$crinvoiceid\">";
echo "<input type=submit class=ibutton value=\"".pcrtlang("Save Recurring Invoice")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Saving")."...'; this.form.submit();\"></td></tr>";

echo "</table></td><td>";
echo "<td valign=top>".pcrtlang("Notes").":<br><textarea name=invnotes class=textboxw rows=10 cols=30>$invoicenotes</textarea></form></td></tr></table>";

if($gomodal != 1) {
stop_blue_box();
}

if($gomodal != 1) {
require_once("footer.php");
}


}


function createrinvoice2() {
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
$crinvoiceid = $_REQUEST['crinvoiceid'];
$pcgroupid = $_REQUEST['pcgroupid'];
$invterms = $_REQUEST['invterms'];
$invinterval = $_REQUEST['invinterval'];
$invthrudate = $_REQUEST['invthrudate'];
$invactive = $_REQUEST['invactive'];
$rstoreid = $_REQUEST['rstoreid'];
$invoicetermsid = $_REQUEST['invoicetermsid'];


if(array_key_exists("blockhours",$_REQUEST)) {
$blockhours = $_REQUEST['blockhours'];
} else {
$blockhours = 0;
}


$reinvoicedate = date("Y-m-d", (strtotime($invthrudate) - ($invterms * 86400)));  






if ($crinvoiceid == 0) {
$rs_insert_cart = "INSERT INTO rinvoices (invname,invcompany,invaddy1,invaddy2,invphone,invemail,invthrudate,invinterval,invterms,reinvoicedate,invcity,invstate,invzip,byuser,invnotes,storeid,pcgroupid,invactive,invoicetermsid) VALUES  ('$invname','$invcompany','$invaddy1','$invaddy2','$invphone','$invemail','$invthrudate','$invinterval','$invterms','$reinvoicedate','$invcity','$invstate','$invzip','$ipofpc','$invnotes','$rstoreid','$pcgroupid','$invactive','$invoicetermsid')";
@mysqli_query($rs_connect, $rs_insert_cart);
$rinvoiceid = mysqli_insert_id($rs_connect);
} else {
$rinvoiceid = $crinvoiceid;
$rs_insert_cart = "UPDATE rinvoices SET invname = '$invname', invcompany = '$invcompany', invaddy1 = '$invaddy1', invaddy2 = '$invaddy2', invphone = '$invphone', invemail = '$invemail', invthrudate = '$invthrudate', invinterval = '$invinterval', invterms = '$invterms', reinvoicedate = '$reinvoicedate', invcity = '$invcity', invstate = '$invstate', invzip = '$invzip', byuser = '$ipofpc', invnotes = '$invnotes', invactive = '$invactive', blockhours = '$blockhours', storeid = '$rstoreid', pcgroupid = '$pcgroupid', invoicetermsid = '$invoicetermsid' WHERE rinvoice_id = '$rinvoiceid'";
@mysqli_query($rs_connect, $rs_insert_cart);
$rs_clear_items = "DELETE FROM rinvoice_items WHERE rinvoice_id = $rinvoiceid";
@mysqli_query($rs_connect, $rs_clear_items);
}

userlog(29,$rinvoiceid,'rinvoiceid','');

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
$purchase_addtime = "$rs_find_purchases_q->addtime";
$purchase_unit_price = "$rs_find_purchases_q->unit_price";
$purchase_quantity = "$rs_find_purchases_q->quantity";
$purchase_discountname = "$rs_find_purchases_q->discountname";

$rs_insert_invitems = "INSERT INTO rinvoice_items (cart_price,cart_type,cart_stock_id,labor_desc,return_sold_id,restocking_fee,price_alt,rinvoice_id,taxex,itemtax,origprice,discounttype,ourprice,addtime,unit_price,quantity,printdesc,discountname) VALUES ('$purchase_price','$purchase_carttype','$purchase_stockid','$purchase_labordesc','$purchase_returnsoldid','$purchase_restockingfee','$purchase_pricealt','$rinvoiceid','$purchase_taxex','$purchase_itemtax','$purchase_origprice','$purchase_discounttype','$purchase_ourprice','$purchase_addtime','$purchase_unit_price','$purchase_quantity','$purchase_printdesc','$purchase_discountname')";
@mysqli_query($rs_connect, $rs_insert_invitems);

}

$rs_delete_cart = "DELETE FROM cart WHERE ipofpc = '$ipofpc'";
@mysqli_query($rs_connect, $rs_delete_cart);

$rs_clear_cust = "DELETE FROM currentcustomer WHERE byuser = '$ipofpc'";
@mysqli_query($rs_connect, $rs_clear_cust);

header("Location: rinvoice.php?func=viewrinvoice&rinvoice_id=$rinvoiceid");

}

##########

function viewrinvoice() {
require_once("validate.php");
$rinvoice_id = $_REQUEST['rinvoice_id'];

include("deps.php");
include("common.php");

require("header.php");

$rs_find_name = "SELECT * FROM rinvoices WHERE rinvoice_id = '$rinvoice_id'";
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
$rs_invthrudate = "$rs_result_name_q->invthrudate";
$rs_pcgroupid = "$rs_result_name_q->pcgroupid";
$invnotes = "$rs_result_name_q->invnotes";
$rs_storeid = "$rs_result_name_q->storeid";
$rs_email = "$rs_result_name_q->invemail";
$rs_rinvoicedate = "$rs_result_name_q->reinvoicedate";
$rs_invterms = "$rs_result_name_q->invterms";
$rs_invinterval = "$rs_result_name_q->invinterval";
$rs_invactive = "$rs_result_name_q->invactive";
$invoicetermsid = "$rs_result_name_q->invoicetermsid";


$rs_soldto_ue = urlencode($rs_soldto);
$rs_company_ue = urlencode($rs_company);
$rs_ad1_ue = urlencode($rs_ad1);
$rs_ad2_ue = urlencode($rs_ad2);
$rs_city_ue = urlencode($rs_city);
$rs_state_ue = urlencode($rs_state);
$rs_zip_ue = urlencode($rs_zip);

$rs_invthrudate2 = pcrtdate("$pcrt_longdate", "$rs_invthrudate");
$rs_rinvoicedate2 = pcrtdate("$pcrt_longdate", "$rs_rinvoicedate");

start_box();
echo "<table style=\"width:100%\"><td style=\"width:50%\">";
echo "<a href=rinvoice.php?func=editrinvoice&rinvoice_id=$rinvoice_id  class=\"linkbutton\"><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("Edit this Recurring Invoice")."</a>";
if(array_key_exists("returnurl",$_REQUEST)) {
$returnurl = $_REQUEST['returnurl'];
echo "<br><a href=$returnurl class=linkbutton><i class=\"fa fa-chevron-left fa-lg\"></i> ".pcrtlang("Return")."</a>";
} else {
echo "<br><a href=invoice.php?func=recurringinvoices class=linkbutton><i class=\"fa fa-chevron-left fa-lg\"></i> ".pcrtlang("Browse All Recurring Invoices")."</a>";
}

echo "</td><td style=\"width:50%\">";
echo "<table>";
echo "<tr><td>".pcrtlang("Recurring Invoice").":</td><td> <span class=colormeblue>#$rinvoice_id</span></td></tr>";
echo "<tr><td>".pcrtlang("Invoiced Thru").":</td><td> <span class=colormeblue>$rs_invthrudate2</span></td></tr>";
echo "<tr><td>".pcrtlang("Re-Invoice After").":</td><td> <span class=colormeblue>$rs_rinvoicedate2</span></td></tr>";
echo "<tr><td>".pcrtlang("Create Invoice in Advance").":</td><td> <span class=colormeblue>$rs_invterms</span></td></tr>";
echo "<tr><td>".pcrtlang("Invoice Terms").":</td><td> <span class=colormeblue>".getinvoicetermstitle($invoicetermsid)."</span></td></tr>";
echo "<tr><td>".pcrtlang("Invoice Interval").":</td><td> <span class=colormeblue>$rs_invinterval</span></td></tr>";
if ($rs_invactive == 0) {
echo "<tr><td>".pcrtlang("Invoice Status").":</td><td>  <span class=\"linkbuttonsmall linkbuttonredlabel radiusleft\">".pcrtlang("Inactive")."</span>";
echo "<a href=rinvoice.php?func=disablerinvoice&rinvoice_id=$rinvoice_id&active=1 class=\"linkbuttonsmall linkbuttongray\">".pcrtlang("activate")."</a>";
echo "<a href=rinvoice.php?func=disablerinvoice&rinvoice_id=$rinvoice_id&active=2 class=\"linkbuttonsmall linkbuttongray radiusright\">".pcrtlang("archive")."</a></td></tr>";
} elseif ($rs_invactive == 1) {
echo "<tr><td>".pcrtlang("Invoice Status").":</td><td> <span class=\"linkbuttonsmall linkbuttongreenlabel radiusleft\">".pcrtlang("Active")."</span>";
echo "<a href=rinvoice.php?func=disablerinvoice&rinvoice_id=$rinvoice_id&active=0 class=\"linkbuttonsmall linkbuttongray radiusright\">".pcrtlang("deactivate")."</a></td></tr>";
} else {
echo "<tr><td>".pcrtlang("Invoice Status").":</td><td>  <span class=\"linkbuttonsmall linkbuttonblacklabel radiusleft\">".pcrtlang("Archived")."</span>";
echo "<a href=rinvoice.php?func=disablerinvoice&rinvoice_id=$rinvoice_id&active=1 class=\"linkbuttonsmall linkbuttongray radiusright\">".pcrtlang("activate")."</a></td></tr>";
}

$rs_findsc = "SELECT * FROM servicecontracts WHERE rinvoice = '$rinvoice_id'";
$rs_resultsc = mysqli_query($rs_connect, $rs_findsc);

if(mysqli_num_rows($rs_resultsc) != 0) {
$rs_resultsc_q = mysqli_fetch_object($rs_resultsc);
$scid = "$rs_resultsc_q->scid";
$scname = "$rs_resultsc_q->scname";

echo  "<tr><td>".pcrtlang("Service Contract").":</td><td><a href=../repair/msp.php?func=viewservicecontract&scid=$scid class=\"linkbuttonsmall linkbuttongray radiusall\">$scname</a></td></tr><br>";

}


if ($rs_pcgroupid != "0") {
echo "<tr><td>".pcrtlang("Asset/Device Group").": $rs_pcgroupid</td><td> <a href=../repair/group.php?func=viewgroup&pcgroupid=$rs_pcgroupid class=\"linkbuttonsmall linkbuttongray radiusall\">".pcrtlang("view")."</a></td></tr>";
}

echo "</table></td></tr></table>";
stop_box();

echo "<br>";
start_box_cb("ffffff");

echo "<table width=100%><tr><td width=55%>";

$storeinfoarray = getstoreinfo($rs_storeid);

echo "<img src=$printablelogo><br><span class=italme>$servicebyline</span><br><br>";
echo "$storeinfoarray[storename]<br>$storeinfoarray[storeaddy1]<br>";
if ("$storeinfoarray[storeaddy2]" != "") {
echo "<br>$storeinfoarray[storeaddy2]";
}
echo "$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]";
echo "<br><br>".pcrtlang("Phone").": $storeinfoarray[storephone]<br><br>";

echo "<table cellpadding=3 cellspacing=0 border=0><tr><td valign=top>".pcrtlang("Customer").":</td><td>$rs_soldto";

if("$rs_company" != "") {
echo "<br>$rs_company";
}

echo "<br>$rs_ad1";

if ($rs_ad2 != "") {
echo "<br>$rs_ad2";
}

echo "<br>";

if ($rs_city != "") {
echo "$rs_city,";
}


echo "$rs_state $rs_zip";

if ($rs_ph != "") {
echo "<br><br>$rs_ph";
}


echo "</td></tr></table>";

echo "<br></td><td valign=top><table><tr><td align=right width=45% valign=top>";
echo "<span class=\"sizeme2x boldme\">".pcrtlang("INVOICE")."</span>";

echo "</td></tr><tr><td>";

if ($invnotes != "") {
echo "<br>Note: $invnotes";
}

echo "</td></tr></table></td></tr></table>";

$mastertaxtotals = array();

echo "<table class=printables>";

$rs_find_cart_items = "SELECT * FROM rinvoice_items WHERE cart_type = 'purchase' AND rinvoice_id = '$rinvoice_id'";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

if (mysqli_num_rows($rs_result) != 0) {
echo "<tr><th colspan=4 width=100%>".pcrtlang("Purchase Items")."</th></tr>";

echo "<tr><td width=20% class=subhead>".pcrtlang("Qty")."</td><td width=50% class=subhead>".pcrtlang("Name of Product")."</td><td width=15% align=right class=subhead>".pcrtlang("Unit Price")."</td><td width=15% align=right class=subhead>".pcrtlang("Total Price")."</td></tr>";
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

echo "<tr><td width=20%>".qf("$quantity");


echo "</td><td width=50%>$rs_stocktitle";

if($rs_stockpdesc != "") {
echo "<br><br><div class=leftindent>".nl2br("$rs_stockpdesc")."</div>";
}


if ($itemserial != "") {
echo "&nbsp;&nbsp;<span class=\"sizemesmaller boldme\">(".pcrtlang("Serial/Code").":</span> <span class=\"sizemesmaller\">$itemserial</span><span class=\"sizemesmaller boldme\">)</span>";
}


if (($price_alt == 1) && ($origprice > $rs_cart_price)) {
echo "<br>";
$disc = explode('|',"$discounttype");
if("$disc[0]" == "percent") {
echo "<span class=\"sizemesmaller italme\">&nbsp;&nbsp;$disc[1]"."% ".pcrtlang("discount applied")."</span>";
} elseif("$disc[0]" == "custom") {
echo "<span class=\"sizemesmaller italme\">&nbsp;&nbsp;".pcrtlang("discount applied")."</span>";
} else {

}
}


echo "</td><td width=15% align=right>$money".limf("$unit_price","$unit_tax")."";

if (($price_alt == 1) && ($origprice > $rs_cart_price)) {
$origunitpricetax = $origprice * getsalestaxrate($taxex);
echo "<br><span class=\"sizemesmaller italme\">".pcrtlang("was")." $money".limf("$origprice","$origunitpricetax")."</span>";
}



echo "</td><td width=15% align=right>$money".limf("$rs_cart_price","$itemtax")."</td></tr>";



}



$rs_find_cart_labor = "SELECT * FROM rinvoice_items WHERE cart_type = 'labor' AND rinvoice_id = '$rinvoice_id' ORDER BY addtime ASC";
$rs_result_labor = mysqli_query($rs_connect, $rs_find_cart_labor);

if (mysqli_num_rows($rs_result_labor) != 0) {
echo "<tr><td width=100% colspan=3>&nbsp;<br><br></td></tr>";
echo "<tr><th colspan=4>".pcrtlang("Labor")."</th></tr>";
echo "<tr><td width=20% class=subhead>".pcrtlang("Qty")."</td><td width=50% class=subhead>".pcrtlang("Labor Description")."</td><td width=15% align=right class=subhead>".pcrtlang("Unit Price")."</td><td width=15% align=right class=subhead>".pcrtlang("Total Price")."</td></tr>";

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
echo "<span class=\"sizemesmaller italme\">&nbsp;&nbsp;$ldisc[1]"."% ".pcrtlang("discount applied")."</span>";
} elseif("$ldisc[0]" == "custom") {
echo "<span class=\"sizemesmaller italme\">&nbsp;&nbsp;".pcrtlang("discount applied")."</span>";
} else {

}
}

echo "</td><td width=15% align=right>$money".limf("$lunit_price","$lunit_tax")."</td><td width=15% align=right>$money".limf("$rs_cart_labor_price","$litemtax");

if (($lprice_alt == 1) && ($lorigprice > $rs_cart_labor_price)) {
$lorigunitpricetax = $lorigprice * getservicetaxrate($litemtax);
echo "<br><span class=\"sizemesmaller italme\">".pcrtlang("was")." $money".limf("$lorigprice","$lorigunitpricetax")."</span>";
}

echo "</td></tr>";

}


echo "<tr><td width=20%>&nbsp;</td><td width=50% align=right>&nbsp;</td><td width=15%>&nbsp;</td><td width=15%>&nbsp;<br><br></td></tr>";

$rs_find_item_total = "SELECT SUM(cart_price) AS total_price_parts, SUM(itemtax) AS total_price_parts_tax FROM rinvoice_items WHERE cart_type = 'purchase' AND rinvoice_id = '$rinvoice_id'";
$rs_find_result_total = mysqli_query($rs_connect, $rs_find_item_total);

while($rs_find_result_total_q = mysqli_fetch_object($rs_find_result_total)) {
$rs_total_parts = "$rs_find_result_total_q->total_price_parts";
$rs_total_parts_tax = "$rs_find_result_total_q->total_price_parts_tax";
}

if ($rs_total_parts == "") {
$rs_total_parts = "0.00";
$rs_total_parts_tax = "0.00";
}


echo "<tr><td width=20%>&nbsp;</td><td width=65% align=right colspan=2>".pcrtlang("Parts Subtotal").":</td><td width=15% align=right>$money".limf("$rs_total_parts","$rs_total_parts_tax")."</td></tr>";

$rs_find_itemtax_total = "SELECT SUM(itemtax) AS total_tax_parts FROM rinvoice_items WHERE cart_type = 'purchase' AND rinvoice_id = '$rinvoice_id'";
$rs_find_result_taxtotal = mysqli_query($rs_connect, $rs_find_itemtax_total);
while($rs_find_result_taxtotal_q = mysqli_fetch_object($rs_find_result_taxtotal)) {
$rs_total_partstax = "$rs_find_result_taxtotal_q->total_tax_parts";

$salestax = $rs_total_partstax;


if (($salestax > 0) && (isset($pcrt_printable_showtax_subtotals))) {
echo "<tr><td width=20%>&nbsp;</td><td width=65% align=right colspan=2>$t_tax:</td><td width=15% align=right>$money".mf("$salestax")."</td></tr>";
}

}




$rs_find_labor_total = "SELECT SUM(cart_price) AS total_labor_price, SUM(itemtax) AS total_labor_price_tax FROM rinvoice_items WHERE cart_type = 'labor' AND rinvoice_id = '$rinvoice_id'";
$rs_find_result_labor_total = mysqli_query($rs_connect, $rs_find_labor_total);


while($rs_find_result_labor_total_q = mysqli_fetch_object($rs_find_result_labor_total)) {
$rs_total_labor = "$rs_find_result_labor_total_q->total_labor_price";
$rs_total_labor_tax = "$rs_find_result_labor_total_q->total_labor_price_tax";
}
if ($rs_total_labor == "") {
$rs_total_labor = "0.00";
$rs_total_labor_tax = "0.00";
}
echo "<tr><td width=20%>&nbsp;</td><td width=65% align=right colspan=2>".pcrtlang("Labor Total").":</td><td width=15% align=right>$money".limf("$rs_total_labor","$rs_total_labor_tax")."</td></tr>";

$rs_find_labortax_total = "SELECT SUM(itemtax) AS total_labortax_price FROM rinvoice_items WHERE cart_type = 'labor' AND rinvoice_id = '$rinvoice_id'";
$rs_find_result_taxlabor_total = mysqli_query($rs_connect, $rs_find_labortax_total);
while($rs_find_result_labortax_total_q = mysqli_fetch_object($rs_find_result_taxlabor_total)) {
$rs_total_labortax = "$rs_find_result_labortax_total_q->total_labortax_price";

$servicetax = $rs_total_labortax;


if (($servicetax > 0) && (isset($pcrt_printable_showtax_subtotals))) {
echo "<tr><td width=20%>&nbsp;</td><td width=65% align=right colspan=2>$t_tax:</td><td width=15% align=right>$money".mf("$servicetax")."</td></tr>";
}

}


echo "<tr><td width=20%>&nbsp;</td><td width=65% align=right colspan=2>&nbsp;</td><td width=15%>&nbsp;</td></tr>";

$grand_total = (tnv($salestax) + tnv($rs_total_parts) + tnv($rs_total_labor) + tnv($servicetax));


reset($mastertaxtotals);
foreach($mastertaxtotals as $key => $val) {
$taxname = gettaxshortname($key);
$taxtotal = ($mastertaxtotals[$key]['parts'] + $mastertaxtotals[$key]['labor']);
if($taxtotal != "0") {
echo "<tr><td width=20%></td><td width=65% align=right colspan=2><span class=\"sizemesmaller boldme\">$taxname:</span></td>
<td width=15% align=right>$money".mf("$taxtotal")."</td></tr>";
}
}


echo "<tr><td width=20%>&nbsp;</td><td width=65% align=right colspan=2>&nbsp;</td><td width=15%>&nbsp;</td></tr>";

echo "<tr><td width=20%></td><td width=65% align=right colspan=2><span class=sizemelarger>";

echo pcrtlang("Invoice Total").":";

echo "</span></td>";
echo "<td width=15% align=right><span class=sizemelarger>$money".mf("$grand_total")."</span></td></tr>";

echo "</table>";


stop_box();
echo "<br><br>";

start_box();

echo "<br><span class=\"sizemelarge boldme\">".pcrtlang("Invoice History")."</span><br><br>";


echo "<table class=standard>";
echo "<tr><th>".pcrtlang("Inv")."#</th><th>".pcrtlang("Customer Name")."</th>";

if ($activestorecount > 1) {
echo "<th>".pcrtlang("Store")."</th>";
}

echo "<th>".pcrtlang("Invoice Date")."</th>";
echo "<th>".pcrtlang("Total")."</th><th>".pcrtlang("Status")."</th><th>".pcrtlang("Actions")."</th></tr>";


$rs_invoices = "SELECT * FROM invoices WHERE rinvoice_id = $rinvoice_id ORDER BY invdate DESC";
$rs_find_invoices = @mysqli_query($rs_connect, $rs_invoices);

if((mysqli_num_rows($rs_find_invoices)) == "0") {
echo "<tr><td colspan=6>".pcrtlang("No Results Found")."</td></tr>";
}


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
$invtotal = tnv($invtax) + tnv($invsubtotal);


if ($invstatus == 1) {
$thestatus = pcrtlang("Open");
} elseif ($invstatus == 2) {
$thestatus = pcrtlang("Closed/Paid");
} else {
$thestatus = pcrtlang("Voided");
}

echo "<tr><td>$invoice_id</td><td>$invname";

if("$invcompany" != "") {
echo "<br><span class=sizeme10>$invcompany<span>";
} 

echo "</td>";

if ($activestorecount > 1) {
echo "<td>$storeinfoarray[storesname]</td>";
}

echo "<td>$invdate2</td><td>$money".mf("$invtotal")."</td><td>$thestatus</td>";
echo "<td><a href=invoice.php?func=printinv&invoice_id=$invoice_id class=\"linkbuttonsmall linkbuttongray radiusleft\"><i class=\"fa fa-print\"></i> ".pcrtlang("Print")."</a>";
echo "<a href=invoice.php?func=emailinv2&invoice_id=$invoice_id&emailaddy=$invemail class=\"linkbuttonsmall linkbuttongray\"><i class=\"fa fa-envelope\"></i> ".pcrtlang("Email")."</a>";
if ($invstatus == "1") {
echo "<a href=invoice.php?func=checkoutinv&invoice_id=$invoice_id&woid=$invwoid&custname=$invname_ue&company=$invcompany_ue&custaddy1=$invaddy1_ue&custaddy2=$invaddy2_ue&custcity=$invcity_ue&custstate=$invstate_ue&custzip=$invzip_ue&custphone=$invphone_ue&custemail=$invemail_ue class=\"linkbuttonsmall linkbuttongray\"><i class=\"fa fa-sign-out\"></i> ".pcrtlang("Checkout/Edit Items")."</a>";
echo "<a href=invoice.php?func=changeinvoicestatus&invstatus=3&invoice_id=$invoice_id  onClick=\"return confirm('".pcrtlang("Are you sure you wish to void this invoice?")."');\" class=\"linkbuttonsmall linkbuttongray\"><i class=\"fa fa-ban\"></i> ".pcrtlang("Void")."</a>";
echo "<a href=invoice.php?func=changeinvoicestatus&invstatus=2&invoice_id=$invoice_id  onClick=\"return confirm('".pcrtlang("Are you sure you wish to close this invoice? Usually you want to checkout an invoice so that the invoice gets marked as paid").".');\" class=\"linkbuttonsmall linkbuttongray radiusright\"><i class=\"fa fa-sign-out\"></i> ".pcrtlang("Close")."</a>";
} else {
echo "<a href=invoice.php?func=changeinvoicestatus&invstatus=1&invoice_id=$invoice_id  onClick=\"return confirm('".pcrtlang("Are you sure you wish to re-open this invoice?")."');\" class=\"linkbuttonsmall linkbuttongray radiusright\"><i class=\"fa fa-reply\"></i> ".pcrtlang("Re-Open this Invoice")."</a>";
}
echo "<br>";
if($invwoid != "") {
echo "<a href=../repair/pc.php?func=view&woid=$invwoid class=\"linkbuttonsmall linkbuttongray\">".pcrtlang("View Work Order")." #$invwoid</a>";
}
if($invrec != "0") {
echo "<a href=receipt.php?func=show_receipt&receipt=$invrec class=\"linkbuttonsmall linkbuttongray radiusall\">".pcrtlang("View Receipt")." #$invrec</a>";
}
echo "</td></tr>";
}
echo "</table>";




stop_box();



require("footer.php");

}

#########



function editrinvoice() {
require_once("validate.php");
require("deps.php");
require("common.php");

$rinvoice_id = $_REQUEST['rinvoice_id'];





$rs_find_name = "SELECT * FROM rinvoices WHERE rinvoice_id = '$rinvoice_id'";
$rs_result_name = mysqli_query($rs_connect, $rs_find_name);

$rs_result_name_q = mysqli_fetch_object($rs_result_name);
$rs_soldto = pv("$rs_result_name_q->invname");
$rs_company = pv("$rs_result_name_q->invcompany");
$rs_ad1 = pv("$rs_result_name_q->invaddy1");
$rs_ad2 = pv("$rs_result_name_q->invaddy2");
$rs_city = pv("$rs_result_name_q->invcity");
$rs_state = pv("$rs_result_name_q->invstate");
$rs_zip = pv("$rs_result_name_q->invzip");
$rs_ph = pv("$rs_result_name_q->invphone");
$rs_invthrudate = pv("$rs_result_name_q->invthrudate");
$rs_pcgroupid = "$rs_result_name_q->pcgroupid";
$invnotes = pv("$rs_result_name_q->invnotes");
$rs_storeid = "$rs_result_name_q->storeid";
$rs_email = pv("$rs_result_name_q->invemail");
$rs_rinvoicedate = pv("$rs_result_name_q->reinvoicedate");
$rs_invterms = pv("$rs_result_name_q->invterms");
$rs_invinterval = pv("$rs_result_name_q->invinterval");
$rs_invactive = "$rs_result_name_q->invactive";



$rs_clear_cust = "DELETE FROM currentcustomer WHERE byuser = '$ipofpc'";
@mysqli_query($rs_connect, $rs_clear_cust);

$rs_insert_cust = "INSERT INTO currentcustomer (cfirstname,ccompany,caddress,caddress2,ccity,cstate,czip,cphone,cemail,pcgroupid,rinvoiceid,byuser) VALUES ('$rs_soldto','$rs_company','$rs_ad1','$rs_ad2','$rs_city','$rs_state','$rs_zip','$rs_ph','$rs_email','$rs_pcgroupid','$rinvoice_id','$ipofpc')";
@mysqli_query($rs_connect, $rs_insert_cust);


$rs_find_cart_items = "SELECT * FROM rinvoice_items WHERE rinvoice_id = '$rinvoice_id'";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);
$rs_rm_cart = "DELETE FROM cart WHERE ipofpc = '$ipofpc'";
@mysqli_query($rs_connect, $rs_rm_cart);


while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_cart_price = "$rs_result_q->cart_price";
$rs_cart_type = "$rs_result_q->cart_type";
$rs_cart_stock_id = "$rs_result_q->cart_stock_id";
$rs_labor_desc = pv($rs_result_q->labor_desc);
$rs_labor_printdesc = pv($rs_result_q->printdesc);
$rs_return_sold_id = "$rs_result_q->return_sold_id";
$rs_restocking_fee = "$rs_result_q->restocking_fee";
$rs_price_alt = "$rs_result_q->price_alt";
$rs_taxex = "$rs_result_q->taxex";
$rs_itemtax = "$rs_result_q->itemtax";
$rs_origprice = "$rs_result_q->origprice";
$rs_discounttype = "$rs_result_q->discounttype";
$rs_ourprice = "$rs_result_q->ourprice";
$rs_addtime = "$rs_result_q->addtime";
$unit_price = "$rs_result_q->unit_price";
$quantity = "$rs_result_q->quantity";
$discountname = "$rs_result_q->discountname";

$rs_insert_cart = "INSERT INTO cart (cart_price,cart_type,cart_stock_id,labor_desc,return_sold_id,restocking_fee,price_alt,ipofpc,taxex,itemtax,origprice,discounttype,ourprice,addtime,quantity,unit_price,printdesc,discountname) VALUES ('$rs_cart_price','$rs_cart_type','$rs_cart_stock_id','$rs_labor_desc','$rs_return_sold_id','$rs_restocking_fee','$rs_price_alt','$ipofpc','$rs_taxex','$rs_itemtax','$rs_origprice','$rs_discounttype','$rs_ourprice','$rs_addtime','$quantity','$unit_price','$rs_labor_printdesc','$discountname')";
@mysqli_query($rs_connect, $rs_insert_cart);

}



header("Location: cart.php");


}

function deleterinvoice() {
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

header("Location: $returnurl");
}

function disablerinvoice() {
require_once("validate.php");
require("deps.php");
require("common.php");

$rinvoice_id = $_REQUEST['rinvoice_id'];
$active = $_REQUEST['active'];

if (array_key_exists('returnurl',$_REQUEST)) {
$returnurl = $_REQUEST['returnurl'];
} else {
$returnurl = "rinvoice.php?func=viewrinvoice&rinvoice_id=$rinvoice_id";
}





$rs_rm_rinv = "UPDATE rinvoices SET invactive = '$active' WHERE rinvoice_id = '$rinvoice_id'";
@mysqli_query($rs_connect, $rs_rm_rinv);

header("Location: $returnurl");
}



function runinvoices() {
require_once("header.php");
require("deps.php");
require_once("common.php");

perm_boot("14");

start_color_box("52",pcrtlang("Process Recurring Invoices"));
echo "<form action=rinvoice.php?func=runinvoices2 method=post>";
echo "<table class=\"doublestandard\">";
echo "<tr><th>".pcrtlang("Inv ID")."#&nbsp;&nbsp;</th><th>".pcrtlang("Customer Name")."&nbsp;&nbsp;</th>";

if ($activestorecount > 1) {
echo "<th>".pcrtlang("Store")."</th>";
}

echo "<th>".pcrtlang("Inv-Thru Date")."</th>";
echo "<th>".pcrtlang("Interval")."&nbsp;&nbsp;</th>";
echo "<th> ".pcrtlang("Total")." &nbsp;&nbsp;</th><th>".pcrtlang("Actions")."&nbsp;&nbsp;</th></tr>";

$a = 3;

$rs_invoices = "SELECT * FROM rinvoices WHERE reinvoicedate < NOW() AND invactive = '1' ORDER BY reinvoicedate";
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
$blockhours = "$rs_find_invoices_q->blockhours";

$storeinfoarray = getstoreinfo($invstoreid);

$findinvtotal = "SELECT SUM(cart_price) AS invsubtotal, SUM(itemtax) AS invtax FROM rinvoice_items WHERE rinvoice_id = '$rinvoice_id'";
$findinvq = @mysqli_query($rs_connect, $findinvtotal);
$findinva = mysqli_fetch_object($findinvq);
$invtax = "$findinva->invtax";
$invsubtotal = "$findinva->invsubtotal";
$invtotal = tnv($invtax) + tnv($invsubtotal);


echo "<tr><td><span class=colormeblue>$rinvoice_id</span></td><td>$invname";

if("$invcompany" != "") {
echo "<br><span class=\"sizemesmaller\">$invcompany</span>";
}

echo "</td>";

if ($activestorecount > 1) {
echo "<td>$storeinfoarray[storesname]</td>";
}

$returnurl = urlencode("rinvoice.php?func=runinvoices");

echo "<td>$invthrudate2</td><td>$invinterval</td><td>$money".mf("$invtotal")."</td>";
echo "<td><a href=rinvoice.php?func=viewrinvoice&rinvoice_id=$rinvoice_id&returnurl=$returnurl class=\"linkbuttonsmall linkbuttongray radiusleft\"><i class=\"fa fa-eye fa-lg\"></i> ".pcrtlang("View")."</a>";

if($pcgroupid != "0") {
echo "<a href=../repair/group.php?func=viewgroup&pcgroupid=$pcgroupid class=\"linkbuttonsmall linkbuttongray radiusright\"><i class=\"fa fa-group fa-lg\"></i> ".pcrtlang("View PC Group")." #$pcgroupid</a>";
}

echo "</td></tr>";


if ($activestorecount > 1) {
echo "<tr><td colspan=4>";
} else {
echo "<tr><td colspan=3>";
}

echo "\n\n<input type=checkbox checked name=ginvoice_id[] value=\"$rinvoice_id\" id=create$rinvoice_id> <label for=create$rinvoice_id>".pcrtlang("Create Invoice")."</label>&nbsp;&nbsp;&nbsp;&nbsp;<br>";
if($invemail == "") {
echo "\n<input type=checkbox checked name=pinvoice_id[] value=\"$rinvoice_id\" id=print$rinvoice_id> <label for=print$rinvoice_id>".pcrtlang("Print Invoice")."</label>&nbsp;&nbsp;&nbsp;&nbsp;";
} else {
echo "\n<input type=checkbox checked name=einvoice_id[] value=\"$rinvoice_id\" id=email$rinvoice_id> <label for=email$rinvoice_id>".pcrtlang("Email to").": $invemail</label>&nbsp;&nbsp;&nbsp;&nbsp;<br>";
echo "\n<input type=checkbox name=pinvoice_id[] value=\"$rinvoice_id\" id=print$rinvoice_id> <label for=print$rinvoice_id>".pcrtlang("Print Invoice")."</label>&nbsp;&nbsp;&nbsp;&nbsp;";
}

echo "</td>";

echo "<td colspan=3>";

echo "</td></tr>";

$a++;

}

echo "</table>";
echo "<br><br><input type=submit value=\"".pcrtlang("Create Invoices")."\" class=button></form>";

stop_color_box();

echo "<br>";


require_once("footer.php");
}


function runinvoices2() {
require_once("validate.php");
require("deps.php");
require("common.php");

perm_boot("14");

$ginvoice_id = $_REQUEST['ginvoice_id'];

if (array_key_exists('pinvoice_id',$_REQUEST)) {
$pinvoice_id = $_REQUEST['pinvoice_id'];
} else {
$pinvoice_id = array();
}

if (array_key_exists('einvoice_id',$_REQUEST)) {
$einvoice_id = $_REQUEST['einvoice_id'];
} else {
$einvoice_id = array();
}

$pinvoice_id2 = array();
$einvoice_id2 = array();

$stringfsf = pcrtlang("For Services from");
$stringthru = pcrtlang("thru");

foreach($ginvoice_id as $key => $rinvoice_id) {




$rs_find_name = "SELECT * FROM rinvoices WHERE rinvoice_id = '$rinvoice_id'";
$rs_result_name = mysqli_query($rs_connect, $rs_find_name);
$rs_result_name_q = mysqli_fetch_object($rs_result_name);
$invname = pv("$rs_result_name_q->invname");
$invcompany = pv("$rs_result_name_q->invcompany");
$invaddy1 = pv("$rs_result_name_q->invaddy1");
$invaddy2 = pv("$rs_result_name_q->invaddy2");
$invemail = pv("$rs_result_name_q->invemail");
$invphone = pv("$rs_result_name_q->invphone");
$invthrudate = pv("$rs_result_name_q->invthrudate");
$invinterval = pv("$rs_result_name_q->invinterval");
$invterms = pv("$rs_result_name_q->invterms");
$invcity = pv("$rs_result_name_q->invcity");
$invstate = pv("$rs_result_name_q->invstate");
$invzip = pv("$rs_result_name_q->invzip");
$invnotes = pv("$rs_result_name_q->invnotes");
$invstoreid = "$rs_result_name_q->storeid";
$pcgroupid = "$rs_result_name_q->pcgroupid";
$blockcontractid = "$rs_result_name_q->blockcontractid";
$blockhours = "$rs_result_name_q->blockhours";
$invoicetermsid = "$rs_result_name_q->invoicetermsid";

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

#######

if ($invinterval == "1W") {
$thedatesql = "DATE_ADD(invthrudate, INTERVAL 1 week)";
} elseif ($invinterval == "2W") {
$thedatesql = "DATE_ADD(invthrudate, INTERVAL 2 week)";
} elseif ($invinterval == "1M") {
$thedatesql = "DATE_ADD(invthrudate, INTERVAL 1 month)";
} elseif ($invinterval == "2M") {
$thedatesql = "DATE_ADD(invthrudate, INTERVAL 2 month)";
} elseif ($invinterval == "3M") {
$thedatesql = "DATE_ADD(invthrudate, INTERVAL 3 month)";
} elseif ($invinterval == "6M") {
$thedatesql = "DATE_ADD(invthrudate, INTERVAL 6 month)";
} elseif ($invinterval == "1Y") {
$thedatesql = "DATE_ADD(invthrudate, INTERVAL 1 year)";
} elseif ($invinterval == "2Y") {
$thedatesql = "DATE_ADD(invthrudate, INTERVAL 2 year)";
} elseif ($invinterval == "3Y") {
$thedatesql = "DATE_ADD(invthrudate, INTERVAL 3 year)";
} elseif ($invinterval == "4Y") {
$thedatesql = "DATE_ADD(invthrudate, INTERVAL 4 year)";
} elseif ($invinterval == "5Y") {
$thedatesql = "DATE_ADD(invthrudate, INTERVAL 5 year)";
} else {
die("Error: Unhandled Invoice Interval");
}

$rs_update_rinv = "UPDATE rinvoices SET invthrudate = $thedatesql WHERE rinvoice_id = '$rinvoice_id'";

$rs_update_reinvdate = "UPDATE rinvoices SET reinvoicedate = DATE_SUB(invthrudate, INTERVAL $invterms day) WHERE rinvoice_id = '$rinvoice_id'";

@mysqli_query($rs_connect, $rs_update_rinv);
@mysqli_query($rs_connect, $rs_update_reinvdate);

$rs_find_nd = "SELECT * FROM rinvoices WHERE rinvoice_id = '$rinvoice_id'";
$rs_result_nd = mysqli_query($rs_connect, $rs_find_nd);
$rs_result_nd_q = mysqli_fetch_object($rs_result_nd);
$newinvthrudate = "$rs_result_nd_q->invthrudate";


$invoicenotes = "$stringfsf $invthrudate $stringthru $newinvthrudate\n$invnotes";

#####

$rs_sl = "SELECT * FROM invoiceterms WHERE invoicetermsid = '$invoicetermsid'";
$rs_result1 = mysqli_query($rs_connect, $rs_sl);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$invoicetermsdays = "$rs_result_q1->invoicetermsdays";

$duedate = date('Y-m-d H:i:s', (time() + ($invoicetermsdays * 86400)));


$rs_insert_cart = "INSERT INTO invoices (invname,invcompany,invaddy1,invaddy2,invphone,invemail,invdate,invcity,invstate,invzip,byuser,invnotes,storeid,iorq,rinvoice_id,invoicetermsid,duedate) VALUES  ('$invname','$invcompany','$invaddy1','$invaddy2','$invphone','$invemail','$currentdatetime','$invcity','$invstate','$invzip','$ipofpc','$invoicenotes','$invstoreid','invoice','$rinvoice_id','$invoicetermsid','$duedate')";
@mysqli_query($rs_connect, $rs_insert_cart);

$invoiceid = mysqli_insert_id($rs_connect);

if($blockcontractid != 0) {
$blockdate = date('Y-m-d');
$rs_insert_bch = "INSERT INTO blockcontracthours (blockhours,blockhoursdate,blockcontractid,invoiceid) VALUES ('$blockhours','$blockdate','$blockcontractid','$invoiceid')";
@mysqli_query($rs_connect, $rs_insert_bch);

}



if (in_array("$rinvoice_id", $pinvoice_id)) {
$pinvoice_id2[] = $invoiceid;
}

if (in_array("$rinvoice_id", $einvoice_id)) {
$einvoice_id2[] = $invoiceid;
}

$rs_purchases = "SELECT * FROM rinvoice_items WHERE rinvoice_id = '$rinvoice_id' ORDER BY addtime ASC";
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
$purchase_addtime = "$rs_find_purchases_q->addtime";
$unit_price = "$rs_find_purchases_q->unit_price";
$quantity = "$rs_find_purchases_q->quantity";
$discountname = "$rs_find_purchases_q->discountname";

$rs_insert_invitems = "INSERT INTO invoice_items (cart_price,cart_type,cart_stock_id,labor_desc,return_sold_id,restocking_fee,price_alt,invoice_id,taxex,itemtax,origprice,discounttype,ourprice,addtime,quantity,unit_price,printdesc,discountname) VALUES ('$purchase_price','$purchase_carttype','$purchase_stockid','$purchase_labordesc','$purchase_returnsoldid','$purchase_restockingfee','$purchase_pricealt','$invoiceid','$purchase_taxex','$purchase_itemtax','$purchase_origprice','$purchase_discounttype','$purchase_ourprice','$purchase_addtime','$quantity','$unit_price','$purchase_printdesc','$discountname')";
@mysqli_query($rs_connect, $rs_insert_invitems);
}



}


$thefurl = "&invoice_id=";
$thefurl2 = "&invoice_id=";
#brackets where in three bottom vars 
foreach($einvoice_id2 as $key => $einvoice_id3) {
$thefurl .= "$einvoice_id3"."_";
}

if(count($einvoice_id2) > 0) {
$thefurl .= substr("$thefurl", 0, -1);
}

if(count($pinvoice_id2) != 0) {
$thefurl .= "&pinvoice_id=";
}

foreach($pinvoice_id2 as $key => $pinvoice_id3) {
$thefurl .= "$pinvoice_id3"."_";
}

if(count($pinvoice_id2) > 0) {
$thefurl .= substr("$thefurl", 0, -1);
}


reset($pinvoice_id2);
foreach($pinvoice_id2 as $key => $pinvoice_id3) {
$thefurl2 .= "$pinvoice_id3"."_";
}

if(count($pinvoice_id2) > 0) {
$thefurl2 .= substr("$thefurl2", 0, -1);
}


if (count($einvoice_id2) > 0) {
header("Location: invoice.php?func=emailinv$thefurl");
} elseif (count($pinvoice_id2) > 0) {
header("Location: invoice.php?func=printinv$thefurl2");
} else {
header("Location: invoice.php");
}



}



switch($func) {
                                                                                                    
    default:
    createrinvoice();
    break;
                                
    case "createrinvoice":
    createrinvoice();
    break;

  case "createrinvoice2":
    createrinvoice2();
    break;

    case "viewrinvoice":
    viewrinvoice();
    break;

case "searchrinvoices":
    searchinvoices();
    break;

case "editrinvoice":
    editrinvoice();
    break;

case "deleterinvoice":
   deleterinvoice();
    break;

case "disablerinvoice":
   disablerinvoice();
    break;

case "runinvoices":
   runinvoices();
    break;

case "runinvoices2":
   runinvoices2();
    break;


}

