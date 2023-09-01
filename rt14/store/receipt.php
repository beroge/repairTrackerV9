<?php

/***************************************************************************
 *   copyright            : (C) 2018 PCRepairTracker.com
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


function enter_receipt() {
require_once("header.php");
echo "default";                                                                                                                             
                                                                                                                             
require_once("footer.php");
                                                                                                                             
}
                                                                                                    
                                                                                                    
function show_receipt() {

$receipt = $_REQUEST['receipt'];


require_once("header.php");

require("deps.php");




$rs_find_name = "SELECT * FROM receipts WHERE receipt_id = '$receipt'";
$rs_result_name = mysqli_query($rs_connect, $rs_find_name);

if((mysqli_num_rows($rs_result_name)) != "0") {
start_box();
echo "<table width=100%><tr><td width=55%>";
} else {
start_box();
echo "<span class=colormered>".pcrtlang("Error: Receipt Not Found")."</span>";
stop_box();
}


while($rs_result_name_q = mysqli_fetch_object($rs_result_name)) {
$rs_soldto = "$rs_result_name_q->person_name";
$rs_company = "$rs_result_name_q->company";
$rs_ad1 = "$rs_result_name_q->address1";
$rs_ad2 = "$rs_result_name_q->address2";
$rs_ph = "$rs_result_name_q->phone_number";
$rs_cn = "$rs_result_name_q->check_number";
$rs_cc = "$rs_result_name_q->ccexpdate";
$rs_ccn = "$rs_result_name_q->ccnumber";
$rs_byuser = "$rs_result_name_q->byuser";
$rs_woid = "$rs_result_name_q->woid";
$rs_storeid = "$rs_result_name_q->storeid";

$storeinfoarray = getstoreinfo($rs_storeid);

$rs_datesold = "$rs_result_name_q->date_sold";
$rs_pw = "$rs_result_name_q->paywith";
$rs_dl = "$rs_result_name_q->driverslc";
$rs_city = "$rs_result_name_q->city";
$rs_state = "$rs_result_name_q->state";
$rs_zip = "$rs_result_name_q->zip";
$rs_email = "$rs_result_name_q->email";



echo "<table><tr>";
echo "<td><span class=\"sizeme16 boldme\">$rs_soldto</span>";
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
echo " $rs_state $rs_zip<br>";

if ($rs_ph != "") {
echo "<br>$rs_ph";
}

if ($rs_email != "") {
echo "<br><br><i class=\"fa fa-envelope fa-lg\"></i> $rs_email";
}


echo "</td></tr></table>";


echo "<br></td><td align=right width=45% valign=top>";
echo "<a href=receipt.php?func=show_receipt_printable&receipt=$receipt class=\"linkbuttongray radiusleft linkbuttonmedium\"><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Printable Receipt")."</a>";
echo "<a href=receipt.php?func=email_receipt&receipt=$receipt class=\"linkbuttongray radiusright linkbuttonmedium\"><i class=\"fa fa-envelope fa-lg\"></i> ".pcrtlang("Email Receipt")."</a><br><br>";
echo "<span class=\"sizeme20 boldme\">".pcrtlang("Receipt")." #$receipt<br></span><br>";

                                                                                                                             
$rs_datesold2 = pcrtdate("$pcrt_longdate", "$rs_datesold").", ".pcrtdate("$pcrt_time", "$rs_datesold");

if (!isset($returndays)) {
$returndays = 14;
}

$unixtimesold = strtotime($rs_datesold);
$unixtwoweeksago = time() - (60 * 60 * 24 * $returndays);

if (($unixtimesold < $unixtwoweeksago) && ($ipofpc != "admin")) {
$allowreturn = 0;
} else {
$allowreturn = 1;
}

echo "<table class=standard><tr><td>".pcrtlang("Sale Date").":</td><td>$rs_datesold2</td></tr>";
                                                                                                                             
if ($activestorecount > 1) {
echo "<tr><td>".pcrtlang("Store").":</td><td>$storeinfoarray[storesname]</td></tr>";
}
                                                                                                                             
$rs_find_inv = "SELECT * FROM invoices WHERE receipt_id = '$receipt'";
$rs_result_inv = mysqli_query($rs_connect, $rs_find_inv);

if(mysqli_num_rows($rs_result_inv) > 0) {
echo "<tr><td>".pcrtlang("Paid Invoice")."</td><td>";


while($rs_result_qinv = mysqli_fetch_object($rs_result_inv)) {
$rs_invoice_id = "$rs_result_qinv->invoice_id";

echo " <a href=invoice.php?func=printinv&invoice_id=$rs_invoice_id class=\"linkbuttonsmall linkbuttongray radiusall\">#$rs_invoice_id</a>";
}
echo "</td></tr>";
}

if (($rs_woid != "0") && ($rs_woid != "")) {
echo "<tr><td>".pcrtlang("Work Order")." </td><td>";
$rs_woids = explode_list($rs_woid);
foreach($rs_woids as $key => $rs_woidids) {
echo "<a href=../repair/pc.php?func=view&woid=$rs_woidids class=\"linkbuttonsmall linkbuttongray radiusall\">#$rs_woidids</a> ";
}
echo "</td></tr>";
}


if ($rs_byuser != "") {
echo "<tr><td>".pcrtlang("Sold by").": </td><td> $rs_byuser</td></tr>";
}

echo "</table>";

echo "<br></td></tr></table>";



stop_box();

$rs_check_cart_return = "SELECT * FROM cart WHERE ipofpc = '$ipofpc' AND (cart_type = 'refund' OR cart_type = 'refundlabor')";
$rs_result_checkcart = mysqli_query($rs_connect, $rs_check_cart_return);
$totalreturnitems = mysqli_num_rows($rs_result_checkcart);

if ($totalreturnitems > 0) {
echo "<br>";
echo "<span class=\"linkbuttonlarge linkbuttonredlabel radiusall displayblock\">";
echo "<table><tr><td>$totalreturnitems ".pcrtlang("Item(s) are in the Current Cart Ready for Return").".";
echo "</td><td>&nbsp;&nbsp;</td><td><INPUT TYPE=button value=\"".pcrtlang("Go to Current Cart")."\" onClick=\"parent.location='cart.php'\" style=\"font-size:16px;\" class=button>";
echo "</td></tr></table>";
echo "</span>";
}

echo "<br><table class=pointofsale>";
echo "<tr><th colspan=5>".pcrtlang("Purchase Items")."</td></tr>";

require("deps.php");




$rs_find_cart_items = "SELECT * FROM sold_items WHERE sold_type = 'purchase' AND receipt = '$receipt' ORDER BY addtime ASC";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

if (mysqli_num_rows($rs_result) == 0) {
echo "<tr><td width=20%>&nbsp;</td><td width=80% colspan=4><span class=\"colormegray italme\">".pcrtlang("No Purchase Items")."</span></td></tr>";
}


while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_cart_item_id = "$rs_result_q->sold_id";
$rs_cart_price = "$rs_result_q->sold_price";
$rs_stock_id = "$rs_result_q->stockid";
$rs_itemtax = "$rs_result_q->itemtax";
$rs_return_flag = "$rs_result_q->return_flag";
$rs_return_receipt = "$rs_result_q->return_receipt";
$rs_labordesc = "$rs_result_q->labor_desc";
$rs_printdesc = "$rs_result_q->printdesc";
$rs_taxex = "$rs_result_q->taxex";
$rs_ourprice = "$rs_result_q->ourprice";
$rs_itemserial = "$rs_result_q->itemserial";
$rs_unit_price = "$rs_result_q->unit_price";
$rs_quantity = "$rs_result_q->quantity";


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


echo "<tr><td width=20%>";

$rs_find_return_total = "SELECT SUM(quantity) AS returnedqtotal FROM sold_items WHERE return_sold_id = '$rs_cart_item_id'";
$rs_find_return_totalq= mysqli_query($rs_connect, $rs_find_return_total);
$rs_return_result_total = mysqli_fetch_object($rs_find_return_totalq);
$returned_quantity_total = "$rs_return_result_total->returnedqtotal";

$quantityleftcount = tnv($rs_quantity) - tnv($returned_quantity_total);

if($returned_quantity_total < $rs_quantity) {
$quantityleft = 1;
} else {
$quantityleft = 0;
}

if (($rs_return_flag !=  'flagged') && ($quantityleft == '1') && ($allowreturn == 1)) {
echo "<form action=cart.php?func=add_return method=post><input type=hidden name=receipt value=$receipt>";
echo "<input type=hidden name=item value=\"$rs_cart_item_id\"><input type=hidden name=price value=\"$rs_cart_price\">";
echo "<input type=hidden name=stockid value=\"$rs_stock_id\"><input type=hidden name=taxex value=\"$rs_taxex\">";
echo "<input type=hidden name=returnfee value=\"20\">";
echo "<input type=hidden name=cfirstname value=\"$rs_soldto\">";
echo "<input type=hidden name=ccompany value=\"$rs_company\">";
echo "<input type=hidden name=caddress value=\"$rs_ad1\">";
echo "<input type=hidden name=caddress2 value=\"$rs_ad2\">";
echo "<input type=hidden name=ccity value=\"$rs_city\">";
echo "<input type=hidden name=cstate value=\"$rs_state\">";
echo "<input type=hidden name=czip value=\"$rs_zip\">";
echo "<input type=hidden name=cphone value=\"$rs_ph\">";
echo "<input type=hidden name=cemail value=\"$rs_email\">";
echo "<input type=hidden name=citemserial value=\"$rs_itemserial\">";
echo "<input type=hidden name=courprice value=\"$rs_ourprice\">";
echo "<input type=hidden name=cquantity value=\"$rs_quantity\">";
echo "<input type=hidden name=cunitprice value=\"$rs_unit_price\">";
echo "<input type=hidden name=stocktitle value=\"$rs_stocktitle\">";
echo pcrtlang("Qty").":<input type=number name=quantity class=textbox style=\"width:40px;\" min=1 max=\"$quantityleftcount\" step=1>";
echo "<select name=returnfee>";
echo "<option selected value=0>".pcrtlang("No Fee")."</option>";
echo "<option value=5>".pcrtlang("5")."%</option>";
echo "<option value=10>".pcrtlang("10")."%</option>";
echo "<option value=15>".pcrtlang("15")."%</option>";
echo "<option value=20>".pcrtlang("20")."%</option>";
echo "<option value=25>".pcrtlang("25")."%</option>";
echo "<option value=30>".pcrtlang("30")."%</option>";
echo "<option value=50>".pcrtlang("50")."%</option>";
echo "</select>";
echo "<input type=submit class=button value=\"Return Item\"></form>";



} else {
echo "&nbsp;";
}
echo "</td><td width=50%><span class=boldme>$rs_stocktitle</span>";

if($rs_stockpdesc != "") {
echo "<br><br><div class=leftindent>".nl2br("$rs_stockpdesc")."</div>";
}

if ($rs_itemserial != "") {
echo "<br><span class=\"sizemesmaller boldme\">".pcrtlang("Serial/Code").":</span> <span class=\"sizemesmaller\">$rs_itemserial</span>";
}


if ($rs_return_flag == 'flagged') {
echo "<br><span class=colormegreen>".pcrtlang("Flagged for Return")."</span>";
}
if ($rs_return_receipt != "") {
$rs_find_return_entry = "SELECT * FROM sold_items WHERE return_sold_id = '$rs_cart_item_id'";
$rs_find_return_result = mysqli_query($rs_connect, $rs_find_return_entry);
while($rs_return_result = mysqli_fetch_object($rs_find_return_result)) {
$returned_quantity = "$rs_return_result->quantity";
$returned_receipt = "$rs_return_result->receipt";
echo "<br><span class=colormegreen>(".qf("$returned_quantity").") ".pcrtlang("Returned on Receipt")."</span> <a href=receipt.php?func=show_receipt&receipt=$returned_receipt>#$returned_receipt</a>";
}
if($quantityleftcount > 0) {
echo "<br>(".qf($quantityleftcount).") ".pcrtlang("Remaining");
}
}

$unit_tax = $rs_itemtax / $rs_quantity;

echo "</td>";
echo "<td width=5%>".qf("$rs_quantity")."</td>";
echo "<td width=15%>$money".limf("$rs_unit_price","$unit_tax")."</td>";
echo "<td width=15% align=right>$money".limf("$rs_cart_price","$rs_itemtax")."</td></tr>";
}


echo "<tr><th colspan=5>".pcrtlang("Labor")."</td></tr>";

$rs_find_cart_labor = "SELECT * FROM sold_items WHERE sold_type = 'labor' AND receipt = '$receipt' ORDER BY addtime ASC";
$rs_result_labor = mysqli_query($rs_connect, $rs_find_cart_labor);

if (mysqli_num_rows($rs_result_labor) == 0) {
echo "<tr><td width=20%>&nbsp;</td><td width=65% colspan=4><span class=\"colormegray italme\">".pcrtlang("No Labor Items")."</span></td></tr>";
}

                                                                                                                                               
while($rs_result_labor_q = mysqli_fetch_object($rs_result_labor)) {
$rs_cart_labor_id = "$rs_result_labor_q->sold_id";
$rs_cart_labor_price = "$rs_result_labor_q->sold_price";
$rs_cart_labor_itemtax = "$rs_result_labor_q->itemtax";
$rs_cart_labor_desc = "$rs_result_labor_q->labor_desc";
$rs_cart_labor_pdesc = "$rs_result_labor_q->printdesc";
$rs_cart_labor_return_flag = "$rs_result_labor_q->return_flag";
$rs_cart_labor_return_receipt = "$rs_result_labor_q->return_receipt";
$rs_labor_taxex = "$rs_result_labor_q->taxex";
$rs_cart_labor_unit_price = "$rs_result_labor_q->unit_price";
$rs_cart_labor_quantity = "$rs_result_labor_q->quantity";

echo "<tr><td width=20%>";
#refundlabor

$rs_find_labor_return_total = "SELECT SUM(quantity) AS returnedqtotal FROM sold_items WHERE return_sold_id = '$rs_cart_labor_id'";
$rs_find_labor_return_totalq= mysqli_query($rs_connect, $rs_find_labor_return_total);
$rs_labor_return_result_total = mysqli_fetch_object($rs_find_labor_return_totalq);
$returned_labor_quantity_total = "$rs_labor_return_result_total->returnedqtotal";

$laborquantityleftcount = tnv($rs_cart_labor_quantity) - tnv($returned_labor_quantity_total);


if($returned_labor_quantity_total < $rs_cart_labor_quantity) {
$laborquantityleft = 1;
} else {
$laborquantityleft = 0;
}



if (($rs_cart_labor_return_flag !=  'flagged') && ($laborquantityleft == '1') && ($allowreturn == 1) && perm_check("22")) {

echo "<form action=cart.php?func=refundlabor method=post><input type=hidden name=receipt value=$receipt>";
echo "<input type=hidden name=cfirstname value=\"$rs_soldto\">";
echo "<input type=hidden name=ccompany value=\"$rs_company\">";
echo "<input type=hidden name=caddress value=\"$rs_ad1\">";
echo "<input type=hidden name=caddress2 value=\"$rs_ad2\">";
echo "<input type=hidden name=ccity value=\"$rs_city\">";
echo "<input type=hidden name=cstate value=\"$rs_state\">";
echo "<input type=hidden name=czip value=\"$rs_zip\">";
echo "<input type=hidden name=cphone value=\"$rs_ph\">";
echo "<input type=hidden name=cemail value=\"$rs_email\">";
echo "<input type=hidden name=item value=\"$rs_cart_labor_id\"><input type=hidden name=price value=\"$rs_cart_labor_price\">";
echo "<input type=hidden name=taxex value=\"$rs_labor_taxex\">";
echo "<input type=hidden name=labordesc value=\"$rs_cart_labor_desc\">";
echo "<input type=hidden name=cquantity value=\"$rs_cart_labor_quantity\">";
echo "<input type=hidden name=cunitprice value=\"$rs_cart_labor_unit_price\">";
echo pcrtlang("Qty").":<input type=number name=quantity class=textbox style=\"width:40px;\" value=\"$laborquantityleftcount\" min=\".01\" max=\"$laborquantityleftcount\" step=\".01\">";
echo "<input type=submit class=button value=\"".pcrtlang("Refund Labor")."\"></form>";

} else {
echo "&nbsp;";
}


echo "</td><td width=65%>$rs_cart_labor_desc";

if($rs_cart_labor_pdesc != "") {
echo "<br><br><div class=leftindent>".nl2br("$rs_cart_labor_pdesc")."</div>";
}

if ($rs_cart_labor_return_flag == 'flagged') {
echo "<br><span class=\"colormegreen\">".pcrtlang("Flagged for Return")."</span>";
}
if ($rs_cart_labor_return_receipt != "") {

$rs_find_laborreturn_entry = "SELECT * FROM sold_items WHERE return_sold_id = '$rs_cart_labor_id'";
$rs_find_laborreturn_result = mysqli_query($rs_connect, $rs_find_laborreturn_entry);
while($rs_laborreturn_result = mysqli_fetch_object($rs_find_laborreturn_result)) {
$laborreturned_quantity = "$rs_laborreturn_result->quantity";
$laborreturned_receipt = "$rs_laborreturn_result->receipt";
echo "<br><span class=colormegreen>(".qf("$laborreturned_quantity").") ".pcrtlang("Returned on Receipt")."</span>
<a href=receipt.php?func=show_receipt&receipt=$laborreturned_receipt>#$laborreturned_receipt</a>";
}
if($laborquantityleftcount > 0) {
echo "<br>(".qf("$laborquantityleftcount").") ".pcrtlang("Remaining");
}
}

$lunit_tax = $rs_cart_labor_itemtax / $rs_cart_labor_quantity;

echo "</td>";
echo "<td width=5%>".qf("$rs_cart_labor_quantity")."</td>";
echo "<td width=15%>$money".limf("$rs_cart_labor_unit_price","$lunit_tax")."</td>";
echo "<td width=15% align=right>$money".limf("$rs_cart_labor_price","$rs_cart_labor_itemtax")."</td></tr>";

}




echo "<tr><th colspan=5>".pcrtlang("Returned Items")."</td></tr>";

                                                                                                                                               
$rs_find_cart_returns = "SELECT * FROM sold_items WHERE sold_type = 'refund' AND receipt = '$receipt' ORDER BY addtime ASC";
$rs_result_returns = mysqli_query($rs_connect, $rs_find_cart_returns);
                                      
if (mysqli_num_rows($rs_result_returns) == 0) {
echo "<tr><td width=20%>&nbsp;</td><td width=80% colspan=4><span class=\"colormegray italme\">".pcrtlang("No Return Items")."</span></td></tr>";
}

                                                                                                         
while($rs_result_returns_q = mysqli_fetch_object($rs_result_returns)) {
$rs_cart_return_id = "$rs_result_returns_q->sold_id";
$rs_cart_return_price = "$rs_result_returns_q->sold_price";
$rs_cart_return_itemtax = "$rs_result_returns_q->itemtax";
$rs_stock_return_id = "$rs_result_returns_q->stockid";
$rs_return_sold_id = "$rs_result_returns_q->return_sold_id";
$rs_return_labordesc = "$rs_result_returns_q->labor_desc";
$rs_return_unit_price = "$rs_result_returns_q->unit_price";
$rs_return_quantity = "$rs_result_returns_q->quantity";

if ($rs_stock_return_id != "0") {
$rs_find_return_detail = "SELECT * FROM stock WHERE stock_id = '$rs_stock_return_id'";
$rs_find_return_result = mysqli_query($rs_connect, $rs_find_return_detail);
$rs_stocktitlear = mysqli_fetch_object($rs_find_return_result);
$rs_return_stocktitle = "$rs_stocktitlear->stock_title";
} else {
$rs_return_stocktitle = "$rs_return_labordesc";
}


                                                                  
                   
$rs_find_original = "SELECT * FROM sold_items WHERE sold_id = '$rs_return_sold_id'";
$rs_find_original_result = mysqli_query($rs_connect, $rs_find_original);
while($rs_find_original_return_q = mysqli_fetch_object($rs_find_original_result)) {
$rs_return_original = "$rs_find_original_return_q->receipt";
                                                                                                                            
echo "<tr><td width=20%>&nbsp;</td><td width=50%>$rs_return_stocktitle<br><a href=receipt.php?func=show_receipt&receipt=$rs_return_original class=\"linkbuttontiny linkbuttonmoney radiusall\">".pcrtlang("Sold on Receipt")." #$rs_return_original</a></td>";

$rs_return_unit_tax = $rs_cart_return_itemtax / $rs_return_quantity;

echo "<td width=5%>".qf("$rs_return_quantity")."</td>";
echo "<td width=15%>$money".limf("$rs_return_unit_price","$rs_return_unit_tax")."</td>";

echo "<td width=15% align=right>$money".mf("$rs_cart_return_price","$rs_cart_return_itemtax")."</td></tr>";
        }
                                                                                                                                               
                                                                                                                                               
}


echo "<tr><th colspan=5>".pcrtlang("Refunded Labor")."</td></tr>";

$rs_find_cart_refundlabor = "SELECT * FROM sold_items WHERE sold_type = 'refundlabor' AND receipt = '$receipt' ORDER BY addtime ASC";
$rs_result_refundlabor = mysqli_query($rs_connect, $rs_find_cart_refundlabor);

if (mysqli_num_rows($rs_result_refundlabor) == 0) {
echo "<tr><td width=20%>&nbsp;</td><td width=65%><span class=\"colormegray italme\">".pcrtlang("No Refunded Labor Items")."</span></td><td width=15% colspan=3>&nbsp;</td></tr>";
}


while($rs_result_refundlabor_q = mysqli_fetch_object($rs_result_refundlabor)) {
$rs_cart_refundlabor_id = "$rs_result_refundlabor_q->sold_id";
$rs_cart_refundlabor_price = "$rs_result_refundlabor_q->sold_price";
$rs_cart_refundlabor_itemtax = "$rs_result_refundlabor_q->itemtax";
$rs_cart_refundlabor_desc = "$rs_result_refundlabor_q->labor_desc";
$rs_cart_refundlabor_return_flag = "$rs_result_refundlabor_q->return_flag";
$rs_cart_refundlabor_return_receipt = "$rs_result_refundlabor_q->return_receipt";
$rs_cart_refundlabor_sold_id = "$rs_result_refundlabor_q->return_sold_id";
$rs_refundlabor_taxex = "$rs_result_refundlabor_q->taxex";
$rs_refundlabor_unit_price = "$rs_result_refundlabor_q->unit_price";
$rs_refundlabor_quantity = "$rs_result_refundlabor_q->quantity";

$rs_find_original_rl = "SELECT * FROM sold_items WHERE sold_id = '$rs_cart_refundlabor_sold_id'";
$rs_find_original_result_rl = mysqli_query($rs_connect, $rs_find_original_rl);
$rs_find_original_return_rl_q = mysqli_fetch_object($rs_find_original_result_rl);
$rs_return_original_rl = "$rs_find_original_return_rl_q->receipt";


echo "<tr><td width=20%>&nbsp;";
echo "</td><td width=50%>$rs_cart_refundlabor_desc<br><a href=receipt.php?func=show_receipt&receipt=$rs_return_original_rl class=\"linkbuttontiny linkbuttonmoney radiusall\">".pcrtlang("Billed on Receipt")." #$rs_return_original_rl</a>";
echo "</td>";

$rs_refundlabor_unittax = $rs_cart_refundlabor_itemtax / $rs_refundlabor_quantity;

echo "<td width=5%>".qf("$rs_refundlabor_quantity")."</td>";
echo "<td width=15%>$money".limf("$rs_refundlabor_unit_price","$rs_refundlabor_unittax")."</td>";

echo "<td width=15% align=right>$money".mf("$rs_cart_refundlabor_price","$rs_cart_refundlabor_itemtax")."</td></tr>";

}




echo "<tr><td width=100% colspan=5>&nbsp;</td></tr>";




$rs_find_item_total = "SELECT SUM(sold_price) AS total_price_parts, SUM(itemtax) AS total_price_parts_tax FROM sold_items WHERE sold_type = 'purchase' AND receipt = '$receipt'";
$rs_find_result_total = mysqli_query($rs_connect, $rs_find_item_total);
                                                                                                                                               
while($rs_find_result_total_q = mysqli_fetch_object($rs_find_result_total)) {
$rs_total_parts = "$rs_find_result_total_q->total_price_parts";
$rs_total_parts_tax = "$rs_find_result_total_q->total_price_parts_tax";

if ($rs_total_parts == "") {
$rs_total_parts = "0.00";
}
                                                                                                                                               
echo "<tr><td width=20%>&nbsp;</td><td width=80% align=right colspan=3>".pcrtlang("Parts Subtotal").":</td><td width=15% align=right>$money".limf("$rs_total_parts","$rs_total_parts_tax")."</td></tr>";


$rs_find_itemtax_total = "SELECT SUM(itemtax) AS total_tax_parts FROM sold_items WHERE sold_type = 'purchase' AND receipt = '$receipt'";
$rs_find_result_taxtotal = mysqli_query($rs_connect, $rs_find_itemtax_total);
while($rs_find_result_taxtotal_q = mysqli_fetch_object($rs_find_result_taxtotal)) {
$rs_total_partstax = "$rs_find_result_taxtotal_q->total_tax_parts";

$salestax = $rs_total_partstax;

if ($salestax > 0) {
echo "<tr><td width=20%>&nbsp;</td><td width=80% align=right colspan=3>$t_tax:</td><td width=15% align=right>$money".mf("$salestax")."</td></tr>";
}
}
}

                                                                                                                                               
                                                                                                                                               

echo "<tr><td width=20%>&nbsp;</td><td width=80% align=right colspan=3>&nbsp;</td><td width=15%>&nbsp;</td></tr>";

$rs_find_labor_total = "SELECT SUM(sold_price) AS total_labor_price, SUM(itemtax) AS total_labor_price_tax FROM sold_items WHERE sold_type = 'labor' AND receipt = '$receipt'";
$rs_find_result_labor_total = mysqli_query($rs_connect, $rs_find_labor_total);
                                                                                                            
                                   
while($rs_find_result_labor_total_q = mysqli_fetch_object($rs_find_result_labor_total)) {
$rs_total_labor = "$rs_find_result_labor_total_q->total_labor_price";
$rs_total_labor_tax = "$rs_find_result_labor_total_q->total_labor_price_tax";

if ($rs_total_labor == "") {
$rs_total_labor = "0.00";
}
                       
                                                                                                                        
                                                                                                                                               
echo "<tr><td width=20%>&nbsp;</td><td width=80% align=right colspan=3>".pcrtlang("Labor Total").":</td><td width=15% align=right>
$money".limf("$rs_total_labor","$rs_total_labor_tax")."</td></tr>";


$rs_find_labortax_total = "SELECT SUM(itemtax) AS total_labortax_price FROM sold_items WHERE sold_type = 'labor' AND receipt = '$receipt'";
$rs_find_result_taxlabor_total = mysqli_query($rs_connect, $rs_find_labortax_total);
while($rs_find_result_labortax_total_q = mysqli_fetch_object($rs_find_result_taxlabor_total)) {
$rs_total_labortax = "$rs_find_result_labortax_total_q->total_labortax_price";

$servicetax = $rs_total_labortax;

if ($servicetax > 0) {
echo "<tr><td width=20%>&nbsp;</td><td width=80% align=right colspan=3>$t_tax:</td><td width=15% align=right>$money".mf("$servicetax")."</td></tr>";
}

}

                                                                                                                                               
}

echo "<tr><td width=20%>&nbsp;</td><td width=80% align=right colspan=3>&nbsp;</td><td width=15%>&nbsp;</td></tr>";
                                                                                                                                               
$rs_find_refund_total = "SELECT SUM(sold_price) AS total_price_parts, SUM(itemtax) AS total_price_parts_tax FROM sold_items WHERE sold_type = 'refund' AND receipt = '$receipt'";
$rs_find_result_refund_total = mysqli_query($rs_connect, $rs_find_refund_total);
                                                                                                                                               
while($rs_find_result_refund_total_q = mysqli_fetch_object($rs_find_result_refund_total)) {
$rs_total_refund = "$rs_find_result_refund_total_q->total_price_parts";
$rs_total_refund_tax = "$rs_find_result_refund_total_q->total_price_parts_tax";
               
if ($rs_total_refund == "") {
$rs_total_refund = "0.00";
}

                                                                                                                                
echo "<tr><td width=20%>&nbsp;</td><td width=80% align=right colspan=3>".pcrtlang("Refund Subtotal").":</td><td width=15% align=right>$money".limf("$rs_total_refund","$rs_total_refund_tax")."</td></tr>";
 

$rs_find_refund_totalref = "SELECT SUM(itemtax) AS total_price_partsref FROM sold_items WHERE sold_type = 'refund' AND receipt = '$receipt'";
$rs_find_result_refund_totalref = mysqli_query($rs_connect, $rs_find_refund_totalref);
while($rs_find_result_refund_totalref_q = mysqli_fetch_object($rs_find_result_refund_totalref)) {
$rs_total_refundtax = "$rs_find_result_refund_totalref_q->total_price_partsref";

$refundtax = $rs_total_refundtax;



if ($refundtax > 0) {
echo "<tr><td width=20%>&nbsp;</td><td width=80% align=right colspan=3>".pcrtlang("Refunded")." $t_tax:</td><td width=15% align=right>$money".mf("$refundtax")."</td></tr>";
}

}
}




echo "<tr><td width=20%>&nbsp;</td><td width=80% align=right colspan=3>&nbsp;</td><td width=15%>&nbsp;</td></tr>";

$rs_find_refundlabor_total = "SELECT SUM(sold_price) AS total_refundlabor_price, SUM(itemtax) AS total_refundlabor_price_tax FROM sold_items WHERE sold_type = 'refundlabor' AND receipt = '$receipt'";
$rs_find_result_refundlabor_total = mysqli_query($rs_connect, $rs_find_refundlabor_total);


while($rs_find_result_refundlabor_total_q = mysqli_fetch_object($rs_find_result_refundlabor_total)) {
$rs_total_refundlabor = "$rs_find_result_refundlabor_total_q->total_refundlabor_price";
$rs_total_refundlabor_tax = "$rs_find_result_refundlabor_total_q->total_refundlabor_price_tax";

if ($rs_total_refundlabor == "") {
$rs_total_refundlabor = "0.00";
}



echo "<tr><td width=20%>&nbsp;</td><td width=80% align=right colspan=3>".pcrtlang("Refunded Labor Total").":</td><td width=15% align=right>$money".limf("$rs_total_refundlabor","$rs_total_refundlabor_tax")."</td></tr>";


$rs_find_refundlabortax_total = "SELECT SUM(itemtax) AS total_refundlabortax_price FROM sold_items WHERE sold_type = 'refundlabor' AND receipt = '$receipt'";
$rs_find_result_taxrefundlabor_total = mysqli_query($rs_connect, $rs_find_refundlabortax_total);
while($rs_find_result_refundlabortax_total_q = mysqli_fetch_object($rs_find_result_taxrefundlabor_total)) {
$rs_total_refundlabortax = "$rs_find_result_refundlabortax_total_q->total_refundlabortax_price";

$refundservicetax = tnv($rs_total_refundlabortax);

if ($refundservicetax > 0) {
echo "<tr><td width=20%>&nbsp;</td><td width=80% align=right colspan=3>$t_tax:</td><td width=15% align=right>$money".mf("$refundservicetax")."</td></tr>";
}

}


}






$grand_total = (tnv($salestax) + tnv($rs_total_parts) + tnv($rs_total_labor) + tnv($servicetax)) - (tnv($refundtax) + tnv($rs_total_refund) + tnv($refundservicetax) + tnv($rs_total_refundlabor));



echo "<tr><td width=20%>&nbsp;</td><td width=80% align=right colspan=3>&nbsp;</td><td width=15%>&nbsp;</td></tr>";

if ($grand_total >= 0){
echo "<tr><td width=20%>&nbsp;</td><td width=80% align=right colspan=3><span class=\"sizemelarger\">".pcrtlang("Grand Total").":</span></td><td width=15% align=right><span class=\"sizemelarger\">$money".mf("$grand_total")."</span></td></tr>";
} else {
$refund_total = abs($grand_total);
echo "<tr><td width=20%>&nbsp;</td><td width=80% align=right colspan=3><span class=\"colormered sizemelarger\">".pcrtlang("Refund").":</span></td><td width=15% align=right><span class=\"sizemelarger\">$money".mf("$refund_total")."</span></td></tr>";
}


echo "<tr><td width=100% colspan=5>";


$findpayments = "SELECT * FROM savedpayments WHERE receipt_id = '$receipt'";
$findpaymentsq = @mysqli_query($rs_connect, $findpayments);
if (mysqli_num_rows($findpaymentsq) != 0) {
echo "<table><tr><td valign=top><span class=\"sizemelarge colormemoney\">&nbsp;".pcrtlang("Payments").":&nbsp;</span><br><br></td></tr></table>";
echo "<table class=payments><tr>";
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
$cc_confirmation = "$findpaymentsa->cc_confirmation";
$cc_cardtype = "$findpaymentsa->cc_cardtype";
$custompaymentinfo2 = "$findpaymentsa->custompaymentinfo";
$chk_dl = "$findpaymentsa->chk_dl";
$paddress = "$findpaymentsa->paddress";
$paddress2 = "$findpaymentsa->paddress2";
$pcity = "$findpaymentsa->pcity";
$pstate = "$findpaymentsa->pstate";
$pzip = "$findpaymentsa->pzip";
$pphone = "$findpaymentsa->pphone";
$cashchange = "$findpaymentsa->cashchange";
$depositid = "$findpaymentsa->depositid";

$custompaymentinfo = unserialize("$custompaymentinfo2");

$ccnumber = substr("$ccnumber2", -4, 4);

if("$pcompany" != "") {
$pcompany2 = "$pcompany - ";
} else {
$pcompany2 = "";
}

if ($paymenttype == "cash") {
echo "<td>";
echo "<span class=\"sizeme16 boldme\"><i class=\"fa fa-money fa-lg\"></i> ".pcrtlang("Cash")."</span><br><br>$pfirstname - $pcompany2: $money".mf("$paymentamount");
if($cashchange != "") {
$cashchange2 = explode('|', $cashchange);
echo "<br>".pcrtlang("Change").": $money".mf("$cashchange2[0]")."<br>".pcrtlang("Tendered").": $money".mf("$cashchange2[1]");
}

if($depositid != "0") {
echo "<br>".pcrtlang("Deposit").": $depositid";
}


echo "</td>";

} elseif ($paymenttype == "check") {
echo "<td>";
echo "<span class=\"sizeme16 boldme\"><i class=\"fa fa-list-alt fa-lg\"></i> ".pcrtlang("Check")." #$checknumber</span><br><br>$pfirstname -$pcompany2";
echo "$money".mf("$paymentamount")."<br><br>$chk_dl<br>$paddress<br>$paddress2<br>$pcity $pstate $pzip<br>$pphone";
if($depositid != "0") {
echo "<br>".pcrtlang("Deposit").": $depositid";
}
echo "</td>";

} elseif ($paymenttype == "credit") {
echo "<td>";
echo "<span class=\"sizeme16 boldme\"><i class=\"fa fa-credit-card fa-lg\"></i> ".pcrtlang("Credit Card")."</span><br><br>XXXX-$ccnumber<br>";

if($cc_transid != "") {
echo pcrtlang("TransID").": $cc_transid<br>";
}

if($cc_confirmation != "") {
echo pcrtlang("Confirmation").": $cc_confirmation<br>";
}

echo "$pfirstname - $pcompany2$money".mf("$paymentamount")."<br>$paymentplugin $cc_cardtype";
if($depositid != "0") {
echo "<br>".pcrtlang("Deposit").": $depositid";
}
echo "</td>";

} elseif ($paymenttype == "custompayment") {
echo "<td>";
echo "<span class=\"sizeme16 boldme\"><i class=\"fa fa-product-hunt fa-lg\"></i> $paymentplugin</span><br><br>$pfirstname - $pcompany2: $money".mf("$paymentamount")."<br>";

reset($custompaymentinfo);
foreach($custompaymentinfo as $key => $val) {
if(!in_array("$key", $CustomPaymentPrintExclude)) {
echo "$key: $val<br>";
}
}
if($depositid != "0") {
echo "<br>".pcrtlang("Deposit").": $depositid";
}
echo "</td>";

} else {
echo "<td colspan=2>Error! Undefined Payment Type in database</td>";
}

}

if (mysqli_num_rows($findpaymentsq) != 0) {
echo "</tr></table>";
}



echo "</td></tr><tr><td width=100% colspan=5>";

echo "<center><a href=receipt.php?func=show_receipt_printable&receipt=$receipt class=\"linkbuttonlarge linkbuttongray radiusleft\"><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Printable Receipt")."</a>";

echo "<a href=receipt.php?func=email_receipt&receipt=$receipt class=\"linkbuttonlarge linkbuttongray radiusright\"><i class=\"fa fa-envelope fa-lg\"></i> ".pcrtlang("Email Receipt")."</a>";

echo "<br>";

if (perm_check("4")) {
echo "<br><a href=receipt.php?func=delete_receipt&receipt=$receipt onClick=\"return confirm('".pcrtlang("Do you want to permanently delete this transaction?")."')\" class=\"linkbuttonmedium linkbuttongray radiusall\">
<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Permanently Void and Delete this Receipt")."</a>";
}

if (perm_check("21")) {

if ($activestorecount > "1") {
$rs_find_stores = "SELECT * FROM stores WHERE storeenabled = '1' ORDER BY storesname ASC";
$rs_result_stores = mysqli_query($rs_connect, $rs_find_stores);

echo "<br><br><form method=post action=receipt.php?func=move_receipt><span class=\"sizeme14 boldme\">".pcrtlang("Move Receipt to a Different Store:")."</span>&nbsp;&nbsp;&nbsp;";
echo "<input type=hidden name=receipt value=\"$receipt\"><input type=hidden name=oldstore value=\"$rs_storeid\"><select name=newstore class=select onchange='this.form.submit()'>";

while($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
$rs_storesname = "$rs_result_storeq->storesname";
$rs_storeidc = "$rs_result_storeq->storeid";

if ($rs_storeidc == $rs_storeid) {
echo "<option selected value=$rs_storeidc>$rs_storesname</option>";
} else {
echo "<option value=$rs_storeidc>$rs_storesname</option>";
}
}
echo "</select></form>";
}


}


echo "</center></td></tr></table><br><br>";


start_blue_box(pcrtlang("Receipt History"));

$rs_find_cart_items = "SELECT * FROM userlog WHERE reftype = 'receiptid' AND refid = '$receipt' ORDER BY thedatetime ASC";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

if((mysqli_num_rows($rs_result)) == "0") {
echo "<br><span class=\"colormegray italme\">".pcrtlang("No Results Found")."</span>";
}
echo "<table class=standard>";

while($rs_result_q = mysqli_fetch_object($rs_result)) {
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


stop_blue_box();

}

updatecategories();


require_once("footer.php");
                                                                                                    
}





###################





function show_receipt_printable() {
require_once("validate.php");

include("deps.php");
include("common.php");

if (!array_key_exists('receipt', $_REQUEST)) {
die(pcrtlang("Error: no receipts selected for printing."));
}



$narrow = $receiptsnarrow;

$receipts = $_REQUEST['receipt'];


if(!is_array($receipts)) {
$receiptarray = array("$receipts");
} else {
$receiptarray = $receipts;
}


if (count($receiptarray) > 1) {
if (array_key_exists('returnurl', $_REQUEST)) {
$returnurl = $_REQUEST['returnurl'];
} else {
$returnurl = "reports.php?func=browse_receipts";
}
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

include("../repair/printstyle.css");

echo "\n-->\n</style>\n";

echo "<link rel=\"stylesheet\" href=\"../repair/fa/css/font-awesome.min.css\">";

if (!isset($enablesignaturepad_receipt)) {
$enablesignaturepad_receipt = "no";
}

if ($enablesignaturepad_receipt == "yes") {
?>
 <link rel="stylesheet" href="../repair/jq/signature/jquery.signaturepad.css">
  <!--[if lt IE 9]><script src="../repair/jq/signature/flashcanvas.js"></script><![endif]-->
  <script src="../repair/jq/jquery.js"></script>

<?php

}

if ($enablesignaturepad_receipt == "topaz") {
require("../repair/jq/topaz.js");
}


echo "</head>";

if (count($receiptarray) == 1) {
if($autoprint == 1) {
if(($enablesignaturepad_receipt == "yes") || ($enablesignaturepad_receipt == "topaz")) {
echo "<body class=printpagebg>";
} else {
echo "<body class=printpagebg onLoad=\"window.print()\">";
}
} else {
echo "<body class=printpagebg>";
}
} else {
echo "<body class=printpagebg>";
}



if (count($receiptarray) > 1) {
echo "<div class=printbar>";
echo "<button onClick=\"parent.location='$returnurl'\" class=bigbutton><img src=images/left.png style=\"vertical-align:middle;margin-bottom: .25em;\"></button>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<button onClick=\"print();\" class=bigbutton><img src=images/print.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Print")."</button>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";


$returnreceipt = urlencode("../store/reports.php?func=browse_receipts");
if($receiptsnarrow == 0) {
echo "<button onClick=\"parent.location='../repair/admin.php?func=switch_receipt&receipt=$returnreceipt&switch=1'\" class=bigbutton><img src=../repair/images/narrowreceipts.png style=\"
vertical-align:middle;margin-bottom: .25em;\"></button>";
} else {
echo "<button onClick=\"parent.location='../repair/admin.php?func=switch_receipt&receipt=$returnreceipt&switch=0'\" class=bigbutton><img src=../repair/images/widereceipts.png style=\"vertical-align:middle;margin-bottom: .25em;\"></button>";
}

echo "</div>";
}

foreach($receiptarray as $key => $receipt) {

userlog(28,$receipt,'receiptid',"");





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
echo "<button onClick=\"parent.location='receipt.php?func=show_receipt&receipt=$receipt'\" class=bigbutton><img src=images/left.png style=\"vertical-align:middle;margin-bottom: .25em;\"></button>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<button onClick=\"print();\" class=bigbutton><img src=images/print.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Print")."</button>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

echo "<button onClick=\"parent.location='receipt.php?func=email_receipt&receipt=$receipt'\"
class=bigbutton><img src=images/email.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Email")."</button>";
echo "&nbsp;&nbsp;&nbsp;";

echo "<button onClick=\"parent.location='../repair/addresslabel.php?pcname=$rs_soldto_ue&pccompany=$rs_company_ue&pcaddress1=$rs_ad1_ue&pcaddress2=$rs_ad2_ue&pccity=$rs_city_ue&pcstate=$rs_state_ue&pczip=$rs_zip_ue&dymojsapi=html'\" class=bigbutton><img src=../repair/images/labelprinter.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Address Label")."</button>";

echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$returnreceipt = urlencode("../store/receipt.php?func=show_receipt_printable&receipt=$receipt");
if($receiptsnarrow == 0) {
echo "<button onClick=\"parent.location='../repair/admin.php?func=switch_receipt&receipt=$returnreceipt&switch=1'\" class=bigbutton><img src=../repair/images/narrowreceipts.png style=\"
vertical-align:middle;margin-bottom: .25em;\"></button>";
} else {
echo "<button onClick=\"parent.location='../repair/admin.php?func=switch_receipt&receipt=$returnreceipt&switch=0'\" class=bigbutton><img src=../repair/images/widereceipts.png style=\"
vertical-align:middle;margin-bottom: .25em;\"></button>";
}


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

echo "<img src=$printablelogo><br><span class=italme>$servicebyline</span><br><br>";
echo "$storeinfoarray[storename]<br>$storeinfoarray[storeaddy1]";
if ("$storeinfoarray[storeaddy2]" != "") {
echo "<br>$storeinfoarray[storeaddy2]";
}
echo "<br>$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]";
echo "<br><br>".pcrtlang("Phone").": $storeinfoarray[storephone]<br><br>";


if ("$rs_company" != "") {
$rs_soldto2 = "$rs_company";
} else {
$rs_soldto2 = "$rs_soldto";
}

echo "<table cellpadding=3 cellspacing=0 border=0><tr><td valign=top>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>$rs_soldto2<br>$rs_ad1";
if ($rs_ad2 != "") {
echo "<br>$rs_ad2";
}

echo "<br>";
if ($rs_city != "") {
echo "$rs_city,";
}
echo " $rs_state $rs_zip<br><br>";

if ($rs_ph != "") {
echo "<br>$rs_ph";
}

if ($rs_email != "") {
echo "<br><a href=\"receipt.php?func=email_receipt&receipt=$receipt&depemail=$rs_email\">".pcrtlang("Email").": $rs_email</a>";
}


echo "</td></tr></table>";


echo "<br></td><td align=right width=45% valign=top>";
echo "<span class=textidnumber>".pcrtlang("RECEIPT")." #$receipt<br></span>";

                                                                                                                             
$rs_datesold2 = pcrtdate("$pcrt_longdate", "$rs_datesold").", ".pcrtdate("$pcrt_time", "$rs_datesold");
                                                                                                                             
echo "<br>".pcrtlang("Sale Date").": $rs_datesold2";


$rs_find_inv = "SELECT * FROM invoices WHERE receipt_id = '$receipt'";
$rs_result_inv = mysqli_query($rs_connect, $rs_find_inv);

if(mysqli_num_rows($rs_result_inv) > 0) {
echo "<br>".pcrtlang("Paid Invoice")."";


while($rs_result_qinv = mysqli_fetch_object($rs_result_inv)) {
$rs_invoice_id = "$rs_result_qinv->invoice_id";
echo " #$rs_invoice_id";
}
}

if ($rs_woid != "") {
echo "<br>".pcrtlang("Work Order")." ";
$rs_woids = explode_list($rs_woid);
foreach($rs_woids as $key => $rs_woidids) {
echo "#$rs_woidids ";
}
}


if ($rs_byuser != "") {
echo "<br>".pcrtlang("Sold by").": $rs_byuser";
}


echo "<br><br><img src=\"barcode.php?barcode=$receipt&width=220&height=20&text=0\">";


echo "<br><br><span class=paidstamp style=\"display:inline-block;\">".pcrtlang("PAID")."</span>";

echo "</td></tr></table>";

} else {
#narrow
echo "<center>";
echo "".pcrtlang("RECEIPT")." #$receipt<br><br>";

$rs_datesold2 = pcrtdate("$pcrt_longdate", "$rs_datesold").", ".pcrtdate("$pcrt_time", "$rs_datesold");
echo "$rs_datesold2<br><br>";



echo "<img src=\"barcode.php?barcode=$receipt&width=200&height=20&text=0\"><br><br>";

$storeinfoarray = getstoreinfo($rs_storeid);

echo "<img src=$printablelogo width=200><br><span class=\"sizemesmaller italme\">$servicebyline</span><br><br>";
echo "$storeinfoarray[storename]<br>$storeinfoarray[storeaddy1]";
if ("$storeinfoarray[storeaddy2]" != "") {
echo "<br>$storeinfoarray[storeaddy2]";
}
echo "<br>$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]";
echo "<br><br>".pcrtlang("Phone").": $storeinfoarray[storephone]<br><br>";



if ("$rs_company" != "") {
$rs_soldto2 = "$rs_company";
} else {
$rs_soldto2 = "$rs_soldto";
}

echo "$rs_soldto2<br>$rs_ad1";
if ($rs_ad2 != "") {
echo "<br>$rs_ad2";
}

echo "<br>";
if ($rs_city != "") {
echo "$rs_city,";
}
echo "$rs_state $rs_zip<br>";

if ($rs_ph != "") {
echo "<br>$rs_ph";
}


if ($rs_email != "") {
echo "<br><br><a href=\"receipt.php?func=email_receipt&receipt=$receipt&depemail=$rs_email\" class=smalllink>".pcrtlang("Email").": $rs_email</a><br><br>";
}

echo "</center>";

#narrow end
}


$mastertaxtotals = array();

if(!$narrow) {
echo "<table class=\"printables lastalignright3\">";
} else {
echo "<table class=\"printablesrp lastalignright2\">";
}

$rs_find_cart_items = "SELECT * FROM sold_items WHERE sold_type = 'purchase' AND receipt = '$receipt' ORDER BY addtime ASC";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

if (mysqli_num_rows($rs_result) != 0) {
if(!$narrow) {
echo "<tr><th colspan=5>".pcrtlang("Purchase Items")."</th></tr>";
echo "<tr><td width=5% class=subhead>".pcrtlang("Qty")."</td><td width=50% class=subhead>".pcrtlang("Name of Product")."</td>";
echo "<td width=15%  class=subhead>".pcrtlang("Unit Price")."</td>";
echo "<td width=15%  class=subhead>".pcrtlang("Total Price")."</td>";
echo "<td width=15%  class=subhead>".pcrtlang("Tax")."</td></tr>";

} else {
echo "<tr><th colspan=5>".pcrtlang("Purchase Items")."</th></tr>";
echo "<tr><td width=5% class=subhead>".pcrtlang("Qty")."</td><td width=50% class=subhead>".pcrtlang("Product Name")."</td>";
echo "<td width=15%  class=subhead>".pcrtlang("Unit Price")."</td>";
echo "<td width=30%  colspan=2 class=subhead>".pcrtlang("Total Price")."</td></tr>";
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
$discountname = "$rs_result_q->discountname";

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
echo "<tr><td width=5%>".qf("$quantity");
echo "</td><td width=50%>$rs_stocktitle";
if($rs_stockpdesc != "") {
echo "<br><br><div class=leftindent>".nl2br("$rs_stockpdesc")."</div>";
}
} else {
echo "<tr><td width=5%><span class=\"sizemesmaller boldme\">".qf("$quantity")."</span>";
echo "</td><td width=50%><span class=\"sizemesmaller boldme\">$rs_stocktitle</span>";
if($rs_stockpdesc != "") {
echo "<br><br><div class=\"sizemesmaller boldme leftindent\">".nl2br("$rs_stockpdesc")."</div>";
}
}


if ($itemserial != "") {
echo "<br><span class=\"sizemesmaller boldme\">".pcrtlang("Serial/Code").":</span> <span class=\"sizemesmaller\">$itemserial</span>";
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
if(!$narrow) {
echo "<br><span class=\"sizemesmaller italme\">(".qf("$returned_quantity").") ".pcrtlang("Returned on Receipt")." #$returned_receipt</span>";
} else {
echo "<br><span class=\"sizemesmaller italme\">(".qf("$returned_quantity").") ".pcrtlang("Returned on Receipt").": #$returned_receipt</span>";
}
}
if($quantityleftcount > 0) {
echo "<br><span class=\"sizemesmaller italme\">(".qf($quantityleftcount).") ".pcrtlang("Remaining")."</span>";
}
}

$rs_cart_price_total = $rs_cart_price;

$rs_tax_total = $itemtax;

$unit_tax = $itemtax / $quantity;

if(!$narrow) {
echo "</td><td width=15%>$money".limf("$unit_price","$unit_tax")."";
} else {
echo "</td><td width=15%><span class=\"sizemesmaller\">$money".limf("$unit_price","$unit_tax")."</span>";
}


if (($price_alt == 1) && ($origprice > $unit_price)) {
$origunitpricetax = $origprice * getsalestaxrate($taxex);
echo "<br><span class=\"sizemesmaller italme\">".pcrtlang("was")." $money".limf("$origprice","$origunitpricetax")."</span>";
}

if(!$narrow) {
echo "</td><td width=15%>$money".limf("$rs_cart_price_total","$itemtax")."</td><td width=15%>";
} else {
echo "</td><td width=30% colspan=2><span class=\"sizemesmaller boldme\">$money".limf("$rs_cart_price_total","$itemtax")."</span>";
}


reset($lineitemtax);
foreach($lineitemtax as $key => $val) {
$shortname = gettaxshortname($key);
if($val != 0) {
if(!$narrow) {
echo "<span class=\"sizemesmaller italme\">$shortname: $money".mf("$val")."</span><br>";
} else {
echo "<br><span class=\"sizemesmaller italme\">$shortname $money".mf("$val")."</span>";
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
echo "<td width=15% class=subhead >".pcrtlang("Unit Price")."</td><td width=15%  class=subhead>".pcrtlang("Price")."</td>";
echo "<td width=15%  class=subhead>".pcrtlang("Tax")."</td>";
echo "</tr>";
} else {
echo "<tr><td width=100% colspan=5>&nbsp;</td></tr>";
echo "<tr><th colspan=5>".pcrtlang("Labor")."</th></tr>";
echo "<tr><td width=5% class=subhead>".pcrtlang("Qty")."</td><td width=50% class=subhead>".pcrtlang("Labor Description")."</td>";
echo "<td width=15% class=subhead>".pcrtlang("Unit Price")."</td><td width=30%  class=subhead colspan=2>".pcrtlang("Price")."</td>";
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
echo "<tr><td width=5%>".qf("$lquantity")."</td><td width=50%>$rs_cart_labor_desc";
if($rs_cart_printdesc != "") {
echo "<br><br><div class=leftindent>".nl2br("$rs_cart_printdesc")."</div>";
}
} else {
echo "<tr><td width=5%>".qf("$lquantity")."</td><td width=50%><span class=\"sizemesmaller boldme\">$rs_cart_labor_desc</span>";
if($rs_cart_printdesc != "") {
echo "<br><br><div class=\"sizemesmaller boldme leftindent\">".nl2br("$rs_cart_printdesc")."</div>";
}
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

#####

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
echo "<br><span class=\"sizemesmaller italme\">(".qf("$laborreturned_quantity").") ".pcrtlang("Returned on Receipt")." #$laborreturned_receipt</span>";
}
if($laborquantityleftcount > 0) {
echo "<br><span class=\"sizemesmaller italme\">(".qf("$laborquantityleftcount").") ".pcrtlang("Remaining")."</span>";
}
}

#####

$lunit_tax = $litemtax / $lquantity;

if(!$narrow) {
echo "</td><td width=15%>$money".limf("$lunit_price","$lunit_tax")."</td><td width=15%>$money".limf("$rs_cart_labor_price","$litemtax")."";
} else {
echo "</td><td width=15%>$money".limf("$lunit_price","$lunit_tax")."</td><td width=30%  colspan=2><span class=\"sizemesmaller boldme\">$money".limf("$rs_cart_labor_price","$litemtax")."</span>";
}


if (($lprice_alt == 1) && ($lorigprice > $lunit_price)) {
$lorigunitpricetax = $origprice * getservicetaxrate($ltaxex);
echo "<br><span class=\"sizemesmaller italme\">".pcrtlang("was")." $money".limf("$lorigprice","$lorigunitpricetax")."</span>";
}

if(!$narrow) {
echo "</td><td width=15%>";
}

reset($laboritemtax);
foreach($laboritemtax as $key => $val) {
$shortname = gettaxshortname($key);
if($val != 0) {
if(!$narrow) {
echo "<span class=\"sizemesmaller italme\">$shortname: $money".mf("$val")."</span><br>";
} else {
echo "<br><span class=\"sizemesmaller italme\">$shortname: $money".mf("$val")."</span>";
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
echo "<td width=15%  class=subhead>".pcrtlang("Price")."</td>";
echo "<td width=15%  class=subhead>".pcrtlang("Tax")."</td></tr>";
} else {
echo "<tr><td width=100% colspan=5>".pcrtlang("Qty")."</td></tr>";
echo "<tr><th colspan=5>".pcrtlang("Returned Items")."</th></tr>";
echo "<tr><td width=5% class=subhead>&nbsp;</td><td width=50% class=subhead>".pcrtlang("Name of Product")."</td><td width=15% class=subhead>".pcrtlang("Unit Price")."</td>";
echo "<td width=30%  colspan=2 class=subhead>".pcrtlang("Price")."</td>";
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
echo "<tr><td width=5%>".qf("$rquantity")."</td><td width=50%>$rs_return_stocktitle<br><span class=\"colormemoney italme sizemesmaller\">".pcrtlang("Sold on Receipt");
echo " #$rs_return_original</span></td>";
echo "<td width=15%>$money".limf("$runit_price","$runit_tax")."</td><td width=15%>$money".limf("$rs_cart_return_price","$ritemtax")."</td><td width=15%>";
} else {
echo "<tr><td width=5%>".qf("$rquantity")."</td><td width=50%><span class=boldme>$rs_return_stocktitle</span><br><span class=\"italme sizemesmaller\">".pcrtlang("Sold on Receipt");
echo " #$rs_return_original</span></td>";
echo "<td width=15%>$money".limf("$runit_price","$runit_tax")."</td><td width=30% colspan=2>$money".limf("$rs_cart_return_price","$ritemtax");
}


reset($refunditemtax);
foreach($refunditemtax as $key => $val) {
$shortname = gettaxshortname($key);
if($val != 0) {
if(!$narrow) {
echo "<span class=\"sizemesmaller italme\">$shortname: $money".mf("$val")."</span><br>";
} else {
echo "<br><span class=\"sizemesmaller italme\">$shortname: $money".mf("$val")."</span>";
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
echo "<td width=15% class=subhead >".pcrtlang("Unit Price")."</td><td width=15%  class=subhead>".pcrtlang("Price")."</td>";
echo "<td width=15%  class=subhead>".pcrtlang("Tax")."</td>";
echo "</tr>";
} else {
echo "<tr><td width=100% colspan=5>".pcrtlang("Qty")."</td></tr>";
echo "<tr><th colspan=5 class=subhead>".pcrtlang("Refunded Labor")."</th></tr>";
echo "<tr><td width=5% class=subhead >".pcrtlang("Unit Price")."</td><td width=50% class=subhead>".pcrtlang("Labor Description")."</td>";
echo "<td width=15% class=subhead>&nbsp;</td><td width=30%  class=subhead colspan=2>".pcrtlang("Price")."</td></tr>";
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
$refundlaborunit_tax = $refunditemtax / $refundlaborquantity;

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
echo "<tr><td width=5%>".qf("$refundlaborquantity")."</td><td width=50%>$rs_cart_refundlabor_desc<br><span class=\"colormemoney italme sizemesmaller\">".pcrtlang("Billed on Receipt");
echo " #$rs_return_original_rl</span>";
} else {
echo "<tr><td width=5%>".qf("$refundlaborquantity")."</td><td width=50%><span class=\"sizemesmaller boldme\">$rs_cart_refundlabor_desc</span><br><span class=\"sizemesmaller italme\">".pcrtlang("Billed on Receipt");
echo " #$rs_return_original_rl</span>";
}


if(!$narrow) {
echo "</td><td width=15%>$money".limf("$refundlaborunit_price","$refundlaborunit_tax")."</td><td width=15%>$money".limf("$rs_cart_refundlabor_price","$refunditemtax")."";
} else {
echo "</td><td width=15%>$money".limf("$refundlaborunit_price","$refundlaborunit_tax")."</td><td width=30%  colspan=2><span class=\"sizemesmaller boldme\">$money".limf("$rs_cart_refundlabor_price","$refunditemtax")."</span>";
}

if(!$narrow) {
echo "</td><td width=15%>";
}

reset($refundlaboritemtax);
foreach($refundlaboritemtax as $key => $val) {
$shortname = gettaxshortname($key);
if($val != 0) {
if(!$narrow) {
echo "<span class=\"sizemesmaller italme\">$shortname: $money".mf("$val")."</span><br>";
} else {
echo "<br><span class=\"sizemesmaller italme\">$shortname: $money".mf("$val")."</span>";
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
echo "<tr><td width=5%>&nbsp;</td><td width=80%  colspan=3>".pcrtlang("Parts Subtotal").":</td>";
echo "<td width=15%>$money".limf("$rs_total_parts","$rs_total_parts_tax")."</td></tr>";
} else {
echo "<tr><td width=5%>&nbsp;</td><td width=80%  colspan=3><span class=\"sizemesmaller\">".pcrtlang("Parts Subtotal").":</span></td>";
echo "<td width=15%><span class=\"sizemesmaller boldme\">$money".limf("$rs_total_parts","$rs_total_parts_tax")."</span></td></tr>";
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
echo "<tr><td width=5%>&nbsp;</td><td width=80%  colspan=3>".pcrtlang("Labor Total").":</td>";
echo "<td width=15%>$money".limf("$rs_total_labor","$rs_total_labor_tax")."</td></tr>";
} else {
echo "<tr><td width=5%>&nbsp;</td><td width=80%  colspan=3><span class=\"sizemesmaller\">".pcrtlang("Labor Total").":</span></td>";
echo "<td width=15%><span class=\"sizemesmaller boldme\">$money".limf("$rs_total_labor","$rs_total_labor_tax")."</span></td></tr>";
}
}

$rs_find_labortax_total = "SELECT SUM(itemtax) AS total_labortax_price FROM sold_items WHERE sold_type = 'labor' AND receipt = '$receipt'";
$rs_find_result_taxlabor_total = mysqli_query($rs_connect, $rs_find_labortax_total);
while($rs_find_result_labortax_total_q = mysqli_fetch_object($rs_find_result_taxlabor_total)) {
$rs_total_labortax = "$rs_find_result_labortax_total_q->total_labortax_price";

$servicetax = $rs_total_labortax;

}
                                                                                                                                               
}

echo "<tr><td width=5%>&nbsp;</td><td width=80%  colspan=3>&nbsp;</td><td width=15%>&nbsp;</td></tr>";
                                                                                                                                               
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
echo "<tr><td width=5%>&nbsp;</td><td width=80%  colspan=3>".pcrtlang("Refund Subtotal").":</td>";
echo "<td width=15%>$money".limf("$rs_total_refund","$rs_total_refund_tax")."";
echo "</td></tr>";
} else {
echo "<tr><td width=5%>&nbsp;</td><td width=80%  colspan=3><span class=\"sizemesmaller\">".pcrtlang("Refund Subtotal").":</span></td>";
echo "<td width=15%><span class=\"sizemesmaller boldme\">$money".mf("$rs_total_refund","$rs_total_refund_tax")."</span>";
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
echo "<tr><td width=5%>&nbsp;</td><td width=80%  colspan=3>".pcrtlang("Refunded Labor Total").":</td>";
echo "<td width=15%>$money".limf("$rs_total_refundlabor","$rs_total_refundlabor_tax")."</td></tr>";
} else {
echo "<tr><td width=5%>&nbsp;</td><td width=80%  colspan=3><span class=\"sizemesmaller\">".pcrtlang("Refunded Labor Total").":</span></td>";
echo "<td width=15%><span class=\"sizemesmaller boldme\">$money".limf("$rs_total_refundlabor","$rs_total_refundlabor_tax")."</span></td></tr>";
}
}

$rs_find_refundlabortax_total = "SELECT SUM(itemtax) AS total_refundlabortax_price FROM sold_items WHERE sold_type = 'refundlabor' AND receipt = '$receipt'";
$rs_find_result_refundtaxlabor_total = mysqli_query($rs_connect, $rs_find_refundlabortax_total);
while($rs_find_result_refundlabortax_total_q = mysqli_fetch_object($rs_find_result_refundtaxlabor_total)) {
$rs_total_refundlabortax = "$rs_find_result_refundlabortax_total_q->total_refundlabortax_price";

$refundservicetax = $rs_total_refundlabortax;

}

}

echo "<tr><td width=5%>&nbsp;</td><td width=80%  colspan=3>&nbsp;</td><td width=15%>&nbsp;</td></tr>";

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
echo "<tr><td width=5%></td><td width=80%  colspan=3><span class=\"sizemesmaller boldme\">$taxname:</span></td>
<td width=15%>$money".mf("$taxtotal")."</td></tr>";
} else {
echo "<tr><td width=5%></td><td width=80%  colspan=3><span class=\"sizemesmaller boldme\">$taxname:</span></td>
<td width=15%><span class=\"sizemesmaller\">$money".mf("$taxtotal")."</span></td></tr>";
}
} elseif($taxtotal < 0) {
if(!$narrow) {
echo "<tr><td width=5%></td><td width=80%  colspan=3><span class=\"sizemesmaller boldme\">$taxname:</span></td>
<td width=15%><span class=colormered>($money".mf("$taxtotal").")</span></td></tr>";
} else {
echo "<tr><td width=5%></td><td width=80%  colspan=3><span class=\"sizemesmaller boldme\">$taxname:</span></td>
<td width=15%><span class=\"sizemesmaller\">($money".mf("$taxtotal").")</span></td></tr>";
}
} else {
}
}



echo "<tr><td width=5%>&nbsp;</td><td width=80%  colspan=2>&nbsp;</td><td width=15%>&nbsp;</td></tr>";

if ($grand_total >= 0){
if(!$narrow) {
echo "<tr><td width=5%></td><td width=80%  colspan=3><span class=\"sizemelarger boldme\">".pcrtlang("Grand Total").":</span></td>";
echo "<td width=15%><span class=\"sizemelarger boldme\">$money".mf("$grand_total")."</span></td></tr>";
} else {
echo "<tr><td width=5%></td><td width=95%  colspan=4>".pcrtlang("Grand Total").": ";
echo "$money".mf("$grand_total")."</td></tr>";
}
} else {
$refund_total = abs($grand_total);
if(!$narrow) {
echo "<tr><td width=5%></td><td width=80%  colspan=3><span class=\"sizemelarge colormered boldme\">".pcrtlang("Refund").":</span></td>";
echo "<td width=15%><span class=\"colormered sizemelarge boldme\">$money".mf("$refund_total")."</span></td></tr>";
} else {
echo "<tr><td width=5%></td><td width=80%  colspan=3>".pcrtlang("Refund").":</td>";
echo "<td width=15%>$money".mf("$refund_total")."</td></tr>";
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
echo "<i class=\"fa fa-money fa-lg\"></i><strong> ".pcrtlang("Cash")."</strong>&nbsp;<br>$pfirstname - $pcompany2$money".mf("$paymentamount");
if($cashchange != "") {
$cashchange2 = explode('|', $cashchange);
echo "<br><span class=\"sizemesmaller\">".pcrtlang("Change").": $money".mf("$cashchange2[0]")." ".pcrtlang("Tendered").": $money".mf("$cashchange2[1]")."</span>";
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
echo "<span class=\"sizemesmaller\">$key: $val</span><br>";
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
echo "<br><br><br><br><span style=\"color:white;\">.</span>";
}


####

if (($enablesignaturepad_receipt == "yes") && ($showsigrec == "0") && (count($receiptarray) == 1) && (!$narrow)) {
echo "<a href=receipt.php?func=hidesigrec&receipt=$receipt&hidesig=1 class=hideprintedlink><br><br>(".pcrtlang("show signature pad").")</a>";
}

if (($enablesignaturepad_receipt == "yes") && ($showsigrec == "1") && (!$narrow)) {

if (($showsigrec == "1") && (count($receiptarray) == 1))  {
echo "<a href=receipt.php?func=hidesigrec&receipt=$receipt&hidesig=0 class=hideprintedlink><br><br>(".pcrtlang("hide signature pad").")</a>";
}


if(($thesig == "") && (count($receiptarray) == 1)) {

?>
<blockquote>
  <form method="post" action="receipt.php?func=savesig" class="sigPad"><input type=hidden name=receipt value=<?php echo $receipt; ?>>
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
if (count($receiptarray) == 1) {
echo "<br><br><span class=sizemelarge>".pcrtlang("Signed").":</span> <a href=receipt.php?func=clearsig&receipt=$receipt class=hideprintedlink>(".pcrtlang("remove signature").")</a><br>";
} else {
echo "<br><br><span class=sizemelarge>".pcrtlang("Signed").":</span><br>";
}

?>

<div class="sigPad<?php echo $receipt; ?> signed">
  <div class="sigWrapper">
<?php
if(!$narrow) {
echo "<canvas class=\"pad\" width=\"450\" height=\"75\"></canvas>";
} else {
echo "<canvas class=\"pad\" width=\"250\" height=\"75\"></canvas>";
}
?>
  </div>
</div>

<script type="text/javascript" src="../repair/jq/signature/jquery.signaturepad.min.js"></script>
<script>
$(document).ready(function () {
  $('.sigPad<?php echo $receipt; ?>').signaturePad({displayOnly:true}).regenerate(<?php echo $thesig ?>)
})
</script>
<script type="text/javascript" src="../repair/jq/signature/json2.min.js"></script>
<?php
}


}



#start topaz

if (($enablesignaturepad_receipt == "topaz") && (count($receiptarray) == 1)) {

if ($showsigrectopaz == "0") {
echo "<a href=receipt.php?func=hidesigrectopaz&receipt=$receipt&hidesig=1 class=hideprintedlink><br><br>(".pcrtlang("show signature pad").")</a>";
}

if ($showsigrectopaz == "1") {
echo "<a href=receipt.php?func=hidesigrectopaz&receipt=$receipt&hidesig=0 class=hideprintedlink><br><br>(".pcrtlang("hide signature pad").")</a>";
}

if ($showsigrectopaz == "1") {
if ($thesigtopaz == "") {


?>

<br>
<canvas id="cnv" name="cnv" width="500" height="100"></canvas>

<form action="receipt.php?func=savesigtopaz" name=FORM1 method=post>
<input id="SignBtn" name="SignBtn" type="button" value="<?php echo pcrtlang("Activate Sig Pad"); ?>"  class=button onclick="javascript:onSign()"/>&nbsp;&nbsp;&nbsp;&nbsp;
<input id="button1" name="ClearBtn" type="button" class=button value="Clear" onclick="javascript:onClear()"/>&nbsp;&nbsp;&nbsp;&nbsp;
<input id="button2" name="DoneBtn" type="button" class=button value="Done" onclick="javascript:onDone()"/>&nbsp;&nbsp;&nbsp;&nbsp;

<input type="submit" class=button value="Save">&nbsp;&nbsp;&nbsp;&nbsp;

<INPUT TYPE=HIDDEN NAME="bioSigData">
<INPUT TYPE=HIDDEN NAME="sigImgData">

<input type=hidden name=receipt value=<?php echo $receipt; ?>>

<input type=hidden NAME="sigImageData" value="">
</form>



<?php

} else {
echo "<br><br><span class=sizemelarge>".pcrtlang("Signed").":</span><a href=receipt.php?func=clearsigtopaz&receipt=$receipt class=hideprintedlink>(".pcrtlang("remove signature").")</a><br>";

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




####










if (count($receiptarray) > 1) {
echo "\n\n<DIV style=\"page-break-after:always\"></DIV>\n\n";
}

}

echo "</body></html>";
                                                                                                    
}





#################################################


function search_receipt() {

require("deps.php");
require("common.php");
$thesearch = pv($_REQUEST['thesearch']);

if ($thesearch == "") {
die(pcrtlang("please go back and enter a search term"));
}







$rs_find_name = "SELECT * FROM receipts WHERE person_name LIKE '%$thesearch%' OR company LIKE '%$thesearch%' OR email LIKE '%$thesearch%' OR phone_number LIKE '%$thesearch%' OR address1 LIKE '%$thesearch%' ORDER BY date_sold DESC";
$rs_result_name = mysqli_query($rs_connect, $rs_find_name);

require_once("header.php");

start_blue_box(pcrtlang("Search for Receipt"));

echo "<table class=standard>";
echo "<tr><th>".pcrtlang("Receipt No.")."</th><th>".pcrtlang("Customer Name")."</th><th>".pcrtlang("Date Sold")."</th><th>".pcrtlang("Grand Total")."</th></tr>";

if (mysqli_num_rows($rs_result_name) == 0) {
echo "<tr><td colspan=4><span class=\"colormegray italme\">".pcrtlang("No Results Found")."</span></td></tr>";
}

while($rs_result_name_q = mysqli_fetch_object($rs_result_name)) {
$rs_soldto = "$rs_result_name_q->person_name";
$rs_company = "$rs_result_name_q->company";
$rs_rt = "$rs_result_name_q->receipt_id";
$rs_date = "$rs_result_name_q->date_sold";
$rtot = "$rs_result_name_q->grandtotal";
$rs_date2 = pcrtdate("$pcrt_longdate", "$rs_date").", ".pcrtdate("$pcrt_time", "$rs_date");

if("$rs_company" != "") {
$rs_company2 = "- $rs_company";
} else {
$rs_company2 = "";
}

echo "<tr><td align=right>$rs_rt</td><td><a href=receipt.php?func=show_receipt&receipt=$rs_rt class=\"linkbuttonmedium linkbuttongray radiusall\">$rs_soldto$rs_company2</a></td><td>$rs_date2</td><td>$money".mf("$rtot")."</td></tr>";


}

echo "</table>";
stop_blue_box();

require_once("footer.php");


}


function delete_receipt() {
require_once("validate.php");
$receipt = $_REQUEST['receipt'];

require("deps.php");
require("common.php");

perm_boot("4");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}


$rs_solditems = "SELECT * FROM sold_items WHERE sold_type = 'purchase' AND receipt = '$receipt'";
$rs_find_solditems = @mysqli_query($rs_connect, $rs_solditems);

while($rs_find_si_q = mysqli_fetch_object($rs_find_solditems)) {
$sold_stockid = "$rs_find_si_q->stockid";

if ($sold_stockid != "0") {
checkstorecount($sold_stockid);
$rs_replace_stock = "UPDATE stockcounts SET quantity = quantity+1 WHERE stockid = '$sold_stockid' AND storeid = '$defaultuserstore'";
@mysqli_query($rs_connect, $rs_replace_stock);
}

}



$rs_delete_rec = "DELETE FROM receipts WHERE receipt_id = '$receipt'";
@mysqli_query($rs_connect, $rs_delete_rec);

$rs_delete_items = "DELETE FROM sold_items WHERE receipt = '$receipt'";
@mysqli_query($rs_connect, $rs_delete_items);

$rs_delete_payments = "DELETE FROM savedpayments WHERE receipt_id = '$receipt'";
@mysqli_query($rs_connect, $rs_delete_payments);

$rs_reset_deposit = "UPDATE deposits SET receipt_id = '0', applieddate = '0000-00-00 00:00:00', dstatus = 'open' WHERE receipt_id = '$receipt'";
@mysqli_query($rs_connect, $rs_reset_deposit);

$rs_clear_return = "UPDATE sold_items SET return_receipt = '0' WHERE return_receipt = '$receipt'";
@mysqli_query($rs_connect, $rs_clear_return);

header("Location: reports.php?func=browse_receipts");

}


function email_receipt() {
require_once("validate.php");
require_once("header.php");
require("deps.php");

$receipt = $_REQUEST['receipt'];

$rs_find_inv = "SELECT * FROM invoices WHERE receipt_id = '$receipt'";
$rs_result_inv = mysqli_query($rs_connect, $rs_find_inv);

if ((mysqli_num_rows($rs_result_inv)) > "0") {
$rs_result_qinv = mysqli_fetch_object($rs_result_inv);
$rs_email = "$rs_result_qinv->invemail";
} else {
$rs_find_rec = "SELECT * FROM receipts WHERE receipt_id = '$receipt'";
$rs_result_rec = mysqli_query($rs_connect, $rs_find_rec);
$rs_result_qrec = mysqli_fetch_object($rs_result_rec);
$rs_email = "$rs_result_qrec->email";
}


start_blue_box(pcrtlang("Email Receipt")." #$receipt");

echo "<br>".pcrtlang("Enter Email Address").":<br><form action=receipt.php?func=email_receipt2 method=POST>";
echo "<input type=text value=\"$rs_email\" name=email class=textbox size=25><input type=hidden value=$receipt name=receipt>";
echo "<input type=submit class=button value=\"".pcrtlang("Email Receipt")."\"></form><br><br>";


stop_blue_box();

require_once("footer.php");


}






function email_receipt2() {
require_once("validate.php");
$receipt = $_REQUEST['receipt'];
$email = $_REQUEST['email'];


include("deps.php");
include("common.php");



if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}

$mastertaxtotals = array();

require("deps.php");




$rs_find_name = "SELECT * FROM receipts WHERE receipt_id = '$receipt'";
$rs_result_name = mysqli_query($rs_connect, $rs_find_name);

while($rs_result_name_q = mysqli_fetch_object($rs_result_name)) {
$rs_soldto = "$rs_result_name_q->person_name";
$rs_company = "$rs_result_name_q->company";
$rs_ad1 = "$rs_result_name_q->address1";
$rs_ad2 = "$rs_result_name_q->address2";
$rs_ph = "$rs_result_name_q->phone_number";
$rs_cn = "$rs_result_name_q->check_number";
$rs_ccn = "$rs_result_name_q->ccnumber";
$rs_datesold = "$rs_result_name_q->date_sold";
$rs_pw = "$rs_result_name_q->paywith";
$rs_storeid = "$rs_result_name_q->storeid";
$rs_byuser = "$rs_result_name_q->byuser";
$rs_woid = "$rs_result_name_q->woid";

$storeinfoarray = getstoreinfo($rs_storeid);

$to = "$email";

if("$storeinfoarray[storeccemail]" != "")	{
$to .= ",$storeinfoarray[storeccemail]";
}



$subject = "$storeinfoarray[storename] - ".pcrtlang("Receipt")." #$receipt";
$random_hash = md5(date('r', time()));
$headers = "From: $storeinfoarray[storeemail]\nReply-To: $storeinfoarray[storeemail]\nX-Mailer: PHP/".phpversion();
$headers .= "\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
$headers .= "\nMIME-Version: 1.0";

$message = "--PHP-alt-$random_hash\n";
$message .= "Content-Transfer-Encoding: 7bit\n";
$message .= "Content-Type: text/plain; charset=\"iso-8859-1\"\n";

$message .= "\nSorry, Your email client does not support html email.\n\n";
$peartext = "\nSorry, Your email client does not support html email.\n\n";

$message .= "--PHP-alt-$random_hash\n";
$message .= "Content-Transfer-Encoding: 7bit\n";
$message .= "Content-Type: text/html; charset=\"iso-8859-1\"\n\n";

$message .= "<html><body><table width=100%><tr><td width=55%>";
$pearhtml = "<html><body><table width=100%><tr><td width=55%>";


$message .= "<font style=\"font-size:16px; font-weight:bold;\">$storeinfoarray[storename]</font><br><font face=arial size=3><i>$servicebyline</i>";
$pearhtml .= "<img src=$logo><br><font face=arial size=3><i>$servicebyline</i>";

$message .= "<br>$storeinfoarray[storeaddy1]";
if ("$storeinfoarray[storeaddy2]" != "") {
$message .= "<br>$storeinfoarray[storeaddy2]\n";
}
$message .= "<br>$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]\n";
$message .= "</font><br><br>Phone: $storeinfoarray[storephone]</font><br><br>\n";


$pearhtml .= "<br>$storeinfoarray[storeaddy1]";
if ("$storeinfoarray[storeaddy2]" != "") {
$pearhtml .= "<br>$storeinfoarray[storeaddy2]\n";
}
$pearhtml .= "<br>$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]\n";
$pearhtml .= "</font><br><br>Phone: $storeinfoarray[storephone]</font><br><br>\n";


if("$rs_company" != "") {
$rs_soldto2 = "$rs_company";
} else {
$rs_soldto2 = "$rs_soldto";
}

$message .= "<table cellpadding=3 cellspacing=0 border=0><tr><td valign=top><b>".pcrtlang("Sold to").":</b></td><td>$rs_soldto2<br>$rs_ad1<br>$rs_ad2<br>$rs_ph</td></tr></table>\n";
$pearhtml .= "<table cellpadding=3 cellspacing=0 border=0><tr><td valign=top><b>".pcrtlang("Sold to").":</b></td><td>$rs_soldto2<br>$rs_ad1<br>$rs_ad2<br>$rs_ph</td></tr></table>\n";

$message .= "</font><br></td><td align=right width=45% valign=top>\n";
$pearhtml .= "</font><br></td><td align=right width=45% valign=top>\n";

$message .= "<font color=888888 face=arial size=6>".pcrtlang("RECEIPT")." #$receipt<br></font>\n";
$pearhtml .= "<font color=888888 face=arial size=6>".pcrtlang("RECEIPT")." #$receipt<br></font>\n";

$rs_datesold2 = pcrtdate("$pcrt_longdate", "$rs_datesold").", ".pcrtdate("$pcrt_time", "$rs_datesold");
$message .= "<br>".pcrtlang("Sale Date").":<font color=888888> $rs_datesold2</font><br>\n";
$pearhtml .= "<br>".pcrtlang("Sale Date").":<font color=888888> $rs_datesold2</font><br>\n";


$rs_find_inv = "SELECT * FROM invoices WHERE receipt_id = '$receipt'";
$rs_result_inv = mysqli_query($rs_connect, $rs_find_inv);

if ((mysqli_num_rows($rs_result_inv)) != 0) {

$message .= "<br>".pcrtlang("Paid Invoice").":";
$pearhtml .= "<br>".pcrtlang("Paid Invoice").":";
while($rs_result_qinv = mysqli_fetch_object($rs_result_inv)) {
$rs_invoice_id = "$rs_result_qinv->invoice_id";
$message .= " <font color=888888>#$rs_invoice_id</font>\n";
$pearhtml .= " <font color=888888>#$rs_invoice_id</font>\n";
}
}

if ($rs_woid != "") {
$message .= "<br>".pcrtlang("Work Order")." ";
$rs_woids = explode_list($rs_woid);
$pearhtml .= "<br>".pcrtlang("Work Order")." ";
$rs_woids = explode_list($rs_woid);
foreach($rs_woids as $key => $rs_woidids) {
$message .= "<font color=888888>#$rs_woidids</font>\n";
$pearhtml .= "<font color=888888>#$rs_woidids</font>\n";
}
}


if ($rs_byuser != "") {
$message .= "<br>".pcrtlang("Sold by").": <font color=888888>$rs_byuser</font>";
$pearhtml .= "<br>".pcrtlang("Sold by").": <font color=888888>$rs_byuser</font>";
}


$paidstyle = <<<PAIDSTYLE
padding:5px;
margin-right:100px;
COLOR: #00cc00;
FONT-SIZE: 40px;
FONT-WEIGHT: bold;
text-align:left;
FONT-FAMILY:Trebuchet MS,Verdana,Helvetica,Arial;
border: 4px solid #00cc00;
border-radius:20px;
-moz-border-radius:20px;
        -webkit-transform: rotate(-12deg);
        -moz-transform: rotate(-12deg);
        -ms-transform: rotate(-12deg);
        -o-transform: rotate(-12deg);
        transform: rotate(-12deg);
PAIDSTYLE;


$message .= "<br><br><font style=\"$paidstyle\">".pcrtlang("PAID")."</font>";
$pearhtml .= "<br><br><font style=\"$paidstyle\">".pcrtlang("PAID")."</font>";


$message .= "</td></tr></table>\n";
$pearhtml .= "</td></tr></table>\n";

}

$message .= "<table width=100% border=0 cellspacing=0 cellpadding=0>\n";
$pearhtml .= "<table width=100% border=0 cellspacing=0 cellpadding=0>\n";

$rs_find_cart_items = "SELECT * FROM sold_items WHERE sold_type = 'purchase' AND receipt = '$receipt' ORDER BY addtime ASC";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

if ((mysqli_num_rows($rs_result)) != 0) {
$message .= "<tr><td colspan=5 width=100% style=\"box-shadow: inset 0 0 0 1000px #dddddd;padding:8px;\"><b>".pcrtlang("Purchase Items")."</b></td></tr>\n";
$pearhtml .= "<tr><td colspan=5 width=100% style=\"box-shadow: inset 0 0 0 1000px #dddddd;padding:8px;\"><b>".pcrtlang("Purchase Items")."</b></td></tr>\n";

$message .= "<tr><td width=5%>".pcrtlang("Qty")."</td><td width=50%><i>".pcrtlang("Name of Product")."</u></td><td width=15% align=right>".pcrtlang("Unit Price")."</td>";
$pearhtml .= "<tr><td width=5%>".pcrtlang("Qty")."</td><td width=50%><i>".pcrtlang("Name of Product")."</u></td><td width=15% align=right>".pcrtlang("Unit Price")."</td>";

$message .= "<td width=15% align=right>".pcrtlang("Total Price")."</td><td width=15% align=right>".pcrtlang("Tax")."</td></tr><tr><td colspan=5><hr color=black></td></tr>\n";
$pearhtml .= "<td width=15% align=right>".pcrtlang("Total Price")."</td><td width=15% align=right>".pcrtlang("Tax")."</td></tr><tr><td colspan=5><hr color=black></td></tr>\n";
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
$discounttype = "$rs_result_q->discounttype";
$price_alt = "$rs_result_q->price_alt";
$itemserial = "$rs_result_q->itemserial";
$rs_taxex = "$rs_result_q->taxex";
$unit_price = "$rs_result_q->unit_price";
$quantity = "$rs_result_q->quantity";
$discountname = "$rs_result_q->discountname";
$itemtax = "$rs_result_q->itemtax";

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
$salestaxrate = getsalestaxrate($rs_taxex);
$isgrouprate = isgrouprate($rs_taxex);


if($isgrouprate == 0) {
$lineitemtax[$rs_taxex] = $rs_cart_price * $salestaxrate;

if(!array_key_exists("$rs_taxex", $mastertaxtotals)) {
$mastertaxtotals[$rs_taxex]['parts'] = $salestaxrate * $rs_cart_price;
$mastertaxtotals[$rs_taxex]['labor'] = 0;
$mastertaxtotals[$rs_taxex]['return'] = 0;
$mastertaxtotals[$rs_taxex]['refundlabor'] = 0;
} else {
$mastertaxtotals[$rs_taxex]['parts'] = ($salestaxrate * $rs_cart_price) + $mastertaxtotals[$rs_taxex]['parts'];
}
} else {
$grouprates = getgrouprates($rs_taxex);

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
########


$message .= "<tr><td width=5%>".qf("$quantity");
$pearhtml .= "<tr><td width=5%>".qf("$quantity");


$message .= "</td><td width=50%>$rs_stocktitle\n";
$pearhtml .= "</td><td width=50%>$rs_stocktitle\n";


if($rs_printdesc != "") {
$message .= "<br><br>".nl2br("$rs_printdesc");
$pearhtml .= "<br><br>".nl2br("$rs_printdesc");
}


if ($itemserial != "") {
$message .= "<br><font size=1><b>".pcrtlang("Serial/Code").":</b>$itemserial</font>";
$pearhtml .= "<br><font size=1><b>".pcrtlang("Serial/Code").":</b>$itemserial</font>";
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


if ($rs_return_receipt != "") {
$message .= "<br><font color=green>".pcrtlang("Returned on Receipt")." <a href=receipt.php?func=show_receipt&receipt=$rs_return_receipt>#$rs_return_receipt</a></font>\n";
$pearhtml .= "<br><font color=green>".pcrtlang("Returned on Receipt")." <a href=receipt.php?func=show_receipt&receipt=$rs_return_receipt>#$rs_return_receipt</a></font>\n";
}



$rs_cart_price_total = $rs_cart_price;


$message .= "</td><td width=15% align=right>$money".limf("$unit_price","$unit_tax");
$pearhtml .= "</td><td width=15% align=right>$money".limf("$unit_price","$unit_tax");

if (($price_alt == 1) && ($origprice > $unit_price)) {
$origunitpricetax = $origprice * getsalestaxrate($taxex);
$message .= "<br><font size=1><i>".pcrtlang("was")." $money".limf("$origprice","$origunitpricetax")."</i></font>";
$pearhtml .= "<br><font size=1><i>".pcrtlang("was")." $money".limf("$origprice","$origunitpricetax")."</i></font>";
}

$message .= "</td><td width=15% align=right>$money".limf("$rs_cart_price_total","$itemtax")."</td><td width=15% align=right>\n";
$pearhtml .= "</td><td width=15% align=right>$money".limf("$rs_cart_price_total","$itemtax")."</td><td width=15% align=right>\n";



reset($lineitemtax);
foreach($lineitemtax as $key => $val) {
$shortname = gettaxshortname($key);
if($val != 0) {
$message .= "<span class=\"sizemesmaller italme\">$shortname: $money".mf("$val")."</span><br>";
$pearhtml .= "<span class=\"sizemesmaller italme\">$shortname: $money".mf("$val")."</span><br>";
}
}
unset($lineitemtax);

$message .= "</td></tr>";
$pearhtml .= "</td></tr>";

}



$rs_find_cart_labor = "SELECT * FROM sold_items WHERE sold_type = 'labor' AND receipt = '$receipt' ORDER BY addtime ASC";
$rs_result_labor = mysqli_query($rs_connect, $rs_find_cart_labor);

if (mysqli_num_rows($rs_result_labor) != 0) {
$message .= "<tr><td colspan=5 style=\"box-shadow: inset 0 0 0 1000px #dddddd;padding:8px;\"><b>".pcrtlang("Labor")."</b></td></tr>";
$pearhtml .= "<tr><td colspan=5 style=\"box-shadow: inset 0 0 0 1000px #dddddd;padding:8px;\"><b>".pcrtlang("Labor")."</b></td></tr>";

$message .= "<tr><td width=5%>".pcrtlang("Qty")."</td><td width=50%><i>".pcrtlang("Labor Description")."</i></td>";
$pearhtml .= "<tr><td width=5%>".pcrtlang("Qty")."</td><td width=50%><i>".pcrtlang("Labor Description")."</i></td>";

$message .= "<td width=15% align=right>".pcrtlang("Unit Price")."</td><td width=15% align=right>".pcrtlang("Price")."</td><td width=15% align=right>".pcrtlang("Tax")."</td></tr><tr><td colspan=5><hr color=black></td></tr>\n";
$pearhtml .= "<td width=15% align=right>".pcrtlang("Unit Price")."</td><td width=15% align=right>".pcrtlang("Price")."</td><td width=15% align=right>".pcrtlang("Tax")."</td></tr><tr><td colspan=5><hr color=black></td></tr>\n";

}

while($rs_result_labor_q = mysqli_fetch_object($rs_result_labor)) {
$rs_cart_labor_id = "$rs_result_labor_q->sold_id";
$rs_cart_labor_price = "$rs_result_labor_q->sold_price";
$rs_cart_labor_desc = "$rs_result_labor_q->labor_desc";
$rs_cart_labor_printdesc = "$rs_result_labor_q->printdesc";
$lorigprice = "$rs_result_labor_q->origprice";
$ldiscounttype = "$rs_result_labor_q->discounttype";
$lprice_alt = "$rs_result_labor_q->price_alt";
$rs_taxex = "$rs_result_labor_q->taxex";
$lunit_price = "$rs_result_labor_q->unit_price";
$lquantity = "$rs_result_labor_q->quantity";
$ldiscountname = "$rs_result_labor_q->discountname";
$litemtax = "$rs_result_labor_q->itemtax";

$lunit_tax = $litemtax / $lquantity;

#newtaxcode
$servicetaxrate = getservicetaxrate($rs_taxex);
$isgrouprate = isgrouprate($rs_taxex);

if($isgrouprate == 0) {

$laboritemtax[$rs_taxex] = $servicetaxrate * $rs_cart_labor_price;

if(!array_key_exists("$rs_taxex", $mastertaxtotals)) {
$mastertaxtotals[$rs_taxex]['parts'] = 0;
$mastertaxtotals[$rs_taxex]['labor'] = $servicetaxrate * $rs_cart_labor_price;
$mastertaxtotals[$rs_taxex]['return'] = 0;
$mastertaxtotals[$rs_taxex]['refundlabor'] = 0;
} else {
$mastertaxtotals[$rs_taxex]['labor'] = ($servicetaxrate * $rs_cart_labor_price) + $mastertaxtotals[$rs_taxex]['labor'];
}
} else {
$grouprates = getgrouprates($rs_taxex);
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



$message .= "<tr><td width=5%>".qf("$lquantity")."</td><td width=50%>$rs_cart_labor_desc";
$pearhtml .= "<tr><td width=5%>".qf("$lquantity")."</td><td width=50%>$rs_cart_labor_desc";

if($rs_cart_labor_printdesc != "") {
$message .= "<br><br>".nl2br("$rs_cart_labor_printdesc");
$pearhtml .= "<br><br>".nl2br("$rs_cart_labor_printdesc");
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
$pearhtml .= "<font size=1><i>$ldiscountname</i></font>";
} else {

}
}

$message .= "</td><td width=15% align=right>$money".limf("$lunit_price","$lunit_tax")."</td><td width=15% align=right>";
$pearhtml .= "</td><td width=15% align=right>$money".limf("$lunit_price","$lunit_tax")."</td><td width=15% align=right>";

$message .= "$money".limf("$rs_cart_labor_price","$litemtax");
$pearhtml .= "$money".limf("$rs_cart_labor_price","$litemtax");

if (($lprice_alt == 1) && ($lorigprice > $lunit_price)) {
$lorigunitpricetax = $lorigprice * getservicetaxrate($rs_taxex);
$message .= "<br><font size=1><i>".pcrtlang("was")." $money".limf("$lorigprice","$lorigunitpricetax")."</i></font>";
$pearhtml .= "<br><font size=1><i>".pcrtlang("was")." $money".limf("$lorigprice","$lorigunitpricetax")."</i></font>";
}

$message .= "</td><td width=15% align=right>\n";
$pearhtml .= "</td><td width=15% align=right>\n";


reset($laboritemtax);
foreach($laboritemtax as $key => $val) {
$shortname = gettaxshortname($key);
if($val != 0) {
$message .= "<span class=\"sizemesmaller italme\">$shortname: $money".mf("$val")."</span><br>";
$pearhtml .= "<span class=\"sizemesmaller italme\">$shortname: $money".mf("$val")."</span><br>";
}
}
unset($laboritemtax);

$message .= "</td></tr>\n";
$pearhtml .= "</td></tr>\n";

}

$rs_find_cart_returns = "SELECT * FROM sold_items WHERE sold_type = 'refund' AND receipt = '$receipt' ORDER BY addtime ASC";
$rs_result_returns = mysqli_query($rs_connect, $rs_find_cart_returns);

if (mysqli_num_rows($rs_result_returns) != 0) {
$message .= "<tr><td width=5%>&nbsp;</td><td width=50% align=right>&nbsp;</td><td width=15%>&nbsp;</td><td width=15%>&nbsp;</td></tr>";
$pearhtml .= "<tr><td width=5%>&nbsp;</td><td width=50% align=right>&nbsp;</td><td width=15%>&nbsp;</td><td width=15%>&nbsp;</td></tr>";

$message .= "<tr><td colspan=5 width=100% style=\"box-shadow: inset 0 0 0 1000px #dddddd;padding:8px;\"><b>".pcrtlang("Returned Items")."</b></td></tr>\n";
$pearhtml .= "<tr><td colspan=5 width=100% style=\"box-shadow: inset 0 0 0 1000px #dddddd;padding:8px;\"><b>".pcrtlang("Returned Items")."</b></td></tr>\n";

$message .= "<tr><td width=5%>".pcrtlang("Qty")."</td><td width=50%><i>".pcrtlang("Name of Product")."</i></td><td width=15%>".pcrtlang("Unit Price")."</td><td width=15% align=right>".pcrtlang("Price")."</td><td width=15% align=right>".pcrtlang("Tax")."</td></tr>";
$pearhtml .= "<tr><td width=5%>".pcrtlang("Qty")."</td><td width=50%><i>".pcrtlang("Name of Product")."</i></td><td width=15%>".pcrtlang("Unit Price")."</td><td width=15% align=right>".pcrtlang("Price")."</td><td width=15% align=right>".pcrtlang("Tax")."</td></tr>";

$message .= "<tr><td colspan=5><hr color=black></td></tr>\n";
$pearhtml .= "<tr><td colspan=5><hr color=black></td></tr>\n";

}

while($rs_result_returns_q = mysqli_fetch_object($rs_result_returns)) {
$rs_cart_return_id = "$rs_result_returns_q->sold_id";
$rs_cart_return_price = "$rs_result_returns_q->sold_price";
$rs_stock_return_id = "$rs_result_returns_q->stockid";
$rs_return_sold_id = "$rs_result_returns_q->return_sold_id";
$rs_return_labordesc = "$rs_result_returns_q->labor_desc";
$rs_return_taxex = "$rs_result_returns_q->taxex";
$rs_return_unit_price = "$rs_result_returns_q->unit_price";
$rs_return_quantity = "$rs_result_returns_q->quantity";
$rs_return_itemtax = "$rs_result_returns_q->itemtax";

$rs_return_unit_tax = $rs_return_itemtax / $rs_return_quantity;

#newtaxcode
$salestaxrate = getsalestaxrate($rs_return_taxex);
$isgrouprate = isgrouprate($rs_return_taxex);

if($isgrouprate == 0) {

$refunditemtax[$rs_return_taxex] = $salestaxrate * $rs_cart_return_price;

if(!array_key_exists("$rs_return_taxex", $mastertaxtotals)) {
$mastertaxtotals[$rs_return_taxex]['parts'] = 0;
$mastertaxtotals[$rs_return_taxex]['labor'] = 0;
$mastertaxtotals[$rs_return_taxex]['return'] = $salestaxrate * $rs_cart_return_price;
$mastertaxtotals[$rs_return_taxex]['refundlabor'] = 0;
} else {
$mastertaxtotals[$rs_return_taxex]['return'] = ($salestaxrate * $rs_cart_return_price) + $mastertaxtotals[$rs_return_taxex]['return'];
}
} else {
$grouprates = getgrouprates($rs_return_taxex);
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


if ($rs_stock_return_id != "0") {
$rs_find_return_detail = "SELECT * FROM stock WHERE stock_id = '$rs_stock_return_id'";
$rs_find_return_result = mysqli_query($rs_connect, $rs_find_return_detail);
$rs_stocktitlear = mysqli_fetch_object($rs_find_return_result);
$rs_return_stocktitle = "$rs_stocktitlear->stock_title";
} else {
$rs_return_stocktitle = "$rs_return_labordesc";
}

$rs_find_original = "SELECT * FROM sold_items WHERE sold_id = '$rs_return_sold_id'";
$rs_find_original_result = mysqli_query($rs_connect, $rs_find_original);
while($rs_find_original_return_q = mysqli_fetch_object($rs_find_original_result)) {
$rs_return_original = "$rs_find_original_return_q->receipt";

$message .= "<tr><td width=5%>".qf("$rs_return_quantity")."</td><td width=50%>$rs_return_stocktitle<br><font color=green>".pcrtlang("Sold on Receipt")."</font>";
$pearhtml .= "<tr><td width=5%>".qf("$rs_return_quantity")."</td><td width=50%>$rs_return_stocktitle<br><font color=green>".pcrtlang("Sold on Receipt")."</font>";

$message .= "<a href=receipt.php?func=show_receipt&receipt=$rs_return_original>#$rs_return_original</a></td>\n";
$pearhtml .= "<a href=receipt.php?func=show_receipt&receipt=$rs_return_original>#$rs_return_original</a></td>\n";

$message .= "<td width=15%>".limf("$rs_return_unit_price","$rs_return_unit_tax")."</td><td width=15% align=right>$money".limf("$rs_cart_return_price","$rs_return_itemtax")."</td>\n";
$pearhtml .= "<td width=15%>".limf("$rs_return_unit_price","$rs_return_unit_tax")."</td><td width=15% align=right>$money".limf("$rs_cart_return_price","$rs_return_itemtax")."</td>\n";

$message .= "<td width=15% align=right>\n";
$pearhtml .= "<td width=15% align=right>\n";

reset($refunditemtax);
foreach($refunditemtax as $key => $val) {
$shortname = gettaxshortname($key);
if($val != 0) {
$message .= "<span class=\"sizemesmaller italme\">$shortname: $money".mf("$val")."</span><br>";
$pearhtml .= "<span class=\"sizemesmaller italme\">$shortname: $money".mf("$val")."</span><br>";
}
}
unset($refunditemtax);

$message .= "</td></tr>";
$pearhtml .= "</td></tr>";


        }
}



##### #
$rs_find_cart_refundlabor = "SELECT * FROM sold_items WHERE sold_type = 'refundlabor' AND receipt = '$receipt' ORDER BY addtime ASC";
$rs_result_refundlabor = mysqli_query($rs_connect, $rs_find_cart_refundlabor);

if (mysqli_num_rows($rs_result_refundlabor) != 0) {
$message .= "<tr><td width=100% colspan=5>&nbsp;</td></tr>";
$message .= "<tr><td colspan=5 style=\"box-shadow: inset 0 0 0 1000px #dddddd;padding:8px;\"><b>".pcrtlang("Refunded Labor")."</b></td></tr>";
$message .= "<tr><td width=5%>".pcrtlang("Qty")."</td><td width=50%>".pcrtlang("Labor Description")."</td>";
$message .= "<td width=15%>".pcrtlang("Unit Price")."</td><td width=15% align=right>".pcrtlang("Price")."</td>";
$message .= "<td width=15% align=right>".pcrtlang("Tax")."</td>";
$message .= "</tr>";
$pearhtml .= "<tr><td width=100% colspan=5>&nbsp;</td></tr>";
$pearhtml .= "<tr><td colspan=5 style=\"box-shadow: inset 0 0 0 1000px #dddddd;padding:8px;\"><b>".pcrtlang("Refunded Labor")."</b></td></tr>";
$pearhtml .= "<tr><td width=5%>".pcrtlang("Qty")."</td><td width=50%><i>".pcrtlang("Labor Description")."</i></td>";
$pearhtml .= "<td width=15%>".pcrtlang("Unit Price")."</td><td width=15% align=right>".pcrtlang("Price")."</td>";
$pearhtml .= "<td width=15% align=right>".pcrtlang("Tax")."</td>";
$pearhtml .= "</tr>";

$message .= "<tr><td colspan=5><hr color=black></td></tr>\n";
$pearhtml .= "<tr><td colspan=5><hr color=black></td></tr>\n";

}
while($rs_result_refundlabor_q = mysqli_fetch_object($rs_result_refundlabor)) {
$rs_cart_refundlabor_id = "$rs_result_refundlabor_q->sold_id";
$rs_cart_refundlabor_price = "$rs_result_refundlabor_q->sold_price";
$rs_cart_refundlabor_desc = "$rs_result_refundlabor_q->labor_desc";
$rs_cart_refundlabor_sold_id = "$rs_result_refundlabor_q->return_sold_id";
$refundltaxex = "$rs_result_refundlabor_q->taxex";
$refundlitemtax = "$rs_result_refundlabor_q->itemtax";
$refundlunit_price = "$rs_result_refundlabor_q->unit_price";
$refundlquantity = "$rs_result_refundlabor_q->quantity";

$refundl_unit_tax = $refundlitemtax / $refundlquantity;

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


$message .= "<tr><td width=5%>".qf("$refundlquantity")."</td><td width=50%>$rs_cart_refundlabor_desc<br>
<font color=green>".pcrtlang("Billed on Receipt")."</font>";
$message .= " <a href=receipt.php?func=show_receipt&receipt=$rs_return_original_rl>#$rs_return_original_rl</a>";
$message .= "</td><td width=15% align=right>".limf("$refundlunit_price","$refundl_unit_tax")."</td><td width=15% align=right>$money".limf("$rs_cart_refundlabor_price","$refundlitemtax")."";
$message .= "</td><td width=15% align=right>";
$pearhtml .= "<tr><td width=5%>".qf("$refundlquantity")."</td><td width=50%>$rs_cart_refundlabor_desc<br>
<font color=green>".pcrtlang("Billed on Receipt")."</font>";
$pearhtml .= " <a href=receipt.php?func=show_receipt&receipt=$rs_return_original_rl>#$rs_return_original_rl</a>";
$pearhtml .= "</td><td width=15% align=right>".limf("$refundlunit_price","$refundl_unit_tax")."</td><td width=15% align=right>$money".limf("$rs_cart_refundlabor_price","$refundlitemtax")."";
$pearhtml .= "</td><td width=15% align=right>";


reset($refundlaboritemtax);
foreach($refundlaboritemtax as $key => $val) {
$shortname = gettaxshortname($key);
if($val != 0) {
$message .= "$shortname: $money".mf("$val")."<br>";
$pearhtml .= "$shortname: $money".mf("$val")."<br>";
}
}
unset($refundlaboritemtax);

$message .= "</td></tr>";
$pearhtml .= "</td></tr>";

}
##### #


$message .= "<tr><td width=100% colspan=5>&nbsp;<br><br></td></tr>\n";
$pearhtml .= "<tr><td width=100% colspan=5>&nbsp;<br><br></td></tr>\n";

$rs_find_item_total = "SELECT SUM(sold_price) AS total_price_parts, SUM(itemtax) AS total_price_parts_tax FROM sold_items WHERE sold_type = 'purchase' AND receipt = '$receipt'";
$rs_find_result_total = mysqli_query($rs_connect, $rs_find_item_total);
while($rs_find_result_total_q = mysqli_fetch_object($rs_find_result_total)) {
$rs_total_parts = "$rs_find_result_total_q->total_price_parts";
$rs_total_parts_tax = "$rs_find_result_total_q->total_price_parts_tax";

if ($rs_total_parts == "") {
$rs_total_parts = "0.00";
$rs_total_parts_tax = "0.00";
}

if ($rs_total_parts > 0) {
$message .= "<tr><td width=5%>&nbsp;</td><td width=80% align=right colspan=3>Parts Subtotal:</td><td width=15% align=right>$money".limf("$rs_total_parts","$rs_total_parts_tax")."</td></tr>\n";
$pearhtml .= "<tr><td width=5%>&nbsp;</td><td width=80% align=right colspan=3>Parts Subtotal:</td><td width=15% align=right>$money".limf("$rs_total_parts","$rs_total_parts_tax")."</td></tr>\n";
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
$message .= "<tr><td width=5%>&nbsp;</td><td width=80% align=right colspan=3>".pcrtlang("Labor Total").":</td><td width=15% align=right>$money".limf("$rs_total_labor","$rs_total_labor_tax")."</td></tr>\n";
$pearhtml .= "<tr><td width=5%>&nbsp;</td><td width=80% align=right colspan=3>".pcrtlang("Labor Total").":</td><td width=15% align=right>$money".limf("$rs_total_labor","$rs_total_labor_tax")."</td></tr>\n";
}

$rs_find_labortax_total = "SELECT SUM(itemtax) AS total_labortax_price FROM sold_items WHERE sold_type = 'labor' AND receipt = '$receipt'";
$rs_find_result_taxlabor_total = mysqli_query($rs_connect, $rs_find_labortax_total);
while($rs_find_result_labortax_total_q = mysqli_fetch_object($rs_find_result_taxlabor_total)) {
$rs_total_labortax = "$rs_find_result_labortax_total_q->total_labortax_price";

$servicetax = $rs_total_labortax;

}
}

$message .= "<tr><td width=5%>&nbsp;</td><td width=80% align=right colspan=3>&nbsp;</td><td width=15%>&nbsp;</td></tr>\n";
$pearhtml .= "<tr><td width=5%>&nbsp;</td><td width=80% align=right colspan=3>&nbsp;</td><td width=15%>&nbsp;</td></tr>\n";
$rs_find_refund_total = "SELECT SUM(sold_price) AS total_price_parts, SUM(itemtax) AS total_price_parts_tax FROM sold_items WHERE sold_type = 'refund' AND receipt = '$receipt'";
$rs_find_result_refund_total = mysqli_query($rs_connect, $rs_find_refund_total);
while($rs_find_result_refund_total_q = mysqli_fetch_object($rs_find_result_refund_total)) {
$rs_total_refund = "$rs_find_result_refund_total_q->total_price_parts";
$rs_total_refund_tax = "$rs_find_result_refund_total_q->total_price_parts_tax";

if ($rs_total_refund == "") {
$rs_total_refund = "0.00";
$rs_total_refund_tax = "0.00";
}

if($rs_total_refund > 0) {
$message .= "<tr><td width=5%>&nbsp;</td><td width=80% align=right colspan=3>".pcrtlang("Refund Subtotal").":</td><td width=15% align=right>$money".limf("$rs_total_refund","$rs_total_refund_tax")."</td></tr>\n";
$pearhtml .= "<tr><td width=5%>&nbsp;</td><td width=80% align=right colspan=3>".pcrtlang("Refund Subtotal").":</td><td width=15% align=right>$money".limf("$rs_total_refund","$rs_total_refund_tax")."</td></tr>\n";
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
$message .= "<tr><td width=5%>&nbsp;</td><td width=80% align=right colspan=3>".pcrtlang("Refunded Labor Total").":</td>";
$message .= "<td width=15% align=right>$money".limf("$rs_total_refundlabor","$rs_total_refundlabor_tax")."</td></tr>";
$pearhtml .= "<tr><td width=5%>&nbsp;</td><td width=80% align=right colspan=3>".pcrtlang("Refunded Labor Total").":</td>";
$pearhtml .= "<td width=15% align=right>$money".limf("$rs_total_refundlabor","$rs_total_refundlabor_tax")."</td></tr>";

}

$rs_find_refundlabortax_total = "SELECT SUM(itemtax) AS total_refundlabortax_price FROM sold_items WHERE sold_type = 'refundlabor' AND receipt = '$receipt'";
$rs_find_result_refundtaxlabor_total = mysqli_query($rs_connect, $rs_find_refundlabortax_total);
while($rs_find_result_refundlabortax_total_q = mysqli_fetch_object($rs_find_result_refundtaxlabor_total)) {
$rs_total_refundlabortax = "$rs_find_result_refundlabortax_total_q->total_refundlabortax_price";

$refundservicetax = $rs_total_refundlabortax;

}

}

$message .= "<tr><td width=5%>&nbsp;</td><td width=80% align=right colspan=3>&nbsp;</td><td width=15%>&nbsp;</td></tr>";
$pearhtml .= "<tr><td width=5%>&nbsp;</td><td width=80% align=right colspan=3>&nbsp;</td><td width=15%>&nbsp;</td></tr>";




$grand_total = (tnv($salestax) + tnv($rs_total_parts) + tnv($rs_total_labor) + tnv($servicetax)) - (tnv($refundtax) + tnv($rs_total_refund) + tnv($rs_total_refundlabor) + tnv($refundservicetax));


####new tax code

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
$message .= "<tr><td width=5%></td><td width=80% align=right colspan=3>$taxname:</td><td width=15% align=right>$money".mf("$taxtotal")."</td></tr>";
$pearhtml .= "<tr><td width=5%></td><td width=80% align=right colspan=3>$taxname:</td><td width=15% align=right>$money".mf("$taxtotal")."</td></tr>";
} elseif($taxtotal < 0) {
$message .= "<tr><td width=5%></td><td width=80% align=right colspan=3>$taxname:</td><td width=15% align=right>($money".mf("$taxtotal").")</td></tr>";
$pearhtml .= "<tr><td width=5%></td><td width=80% align=right colspan=3>$taxname:</td><td width=15% align=right>($money".mf("$taxtotal").")</td></tr>";
} else {
}
}

#######



$message .= "<tr><td width=5%>&nbsp;</td><td width=80% align=right colspan=3>&nbsp;</td><td width=15%>&nbsp;</td></tr>\n";
$pearhtml .= "<tr><td width=5%>&nbsp;</td><td width=80% align=right colspan=3>&nbsp;</td><td width=15%>&nbsp;</td></tr>\n";

if ($grand_total >= 0){
$message .= "<tr><td width=5%></td><td width=80% align=right colspan=3><h3>".pcrtlang("Grand Total").":</h3></td><td width=15% align=right><h3>$money".mf("$grand_total")."</h3></td></tr>\n";
$pearhtml .= "<tr><td width=5%></td><td width=80% align=right colspan=3><h3>".pcrtlang("Grand Total").":</h3></td><td width=15% align=right><h3>$money".mf("$grand_total")."</h3></td></tr>\n";
} else {
$refund_total = abs($grand_total);
$message .= "<tr><td width=5%><a href=receipt.php?func=show_receipt&receipt=$receipt>".pcrtlang("Return")."</a></td>";
$pearhtml .= "<tr><td width=5%><a href=receipt.php?func=show_receipt&receipt=$receipt>".pcrtlang("Return")."</a></td>";

$message .= "<td width=80% align=right colspan=3><font color=red><h3>".pcrtlang("Refund").":</h3></font></td><td width=15% align=right><h3>$money".mf("$refund_total")."</h3></td></tr>\n";
$pearhtml .= "<td width=80% align=right colspan=3><font color=red><h3>".pcrtlang("Refund").":</h3></font></td><td width=15% align=right><h3>$money".mf("$refund_total")."</h3></td></tr>\n";
}


$message .= "</table>\n";
$pearhtml .= "</table>\n";

$findpayments = "SELECT * FROM savedpayments WHERE receipt_id = '$receipt'";
$findpaymentsq = @mysqli_query($rs_connect, $findpayments);
if (mysqli_num_rows($findpaymentsq) != 0) {
$message .= "<table><tr><td valign=top><font style=\"font-weight:bold;border-bottom: 2px solid #000000;\">&nbsp;".pcrtlang("Payments").":&nbsp;</font></td></tr></table>";
$pearhtml .= "<table><tr><td valign=top><font style=\"font-weight:bold;border-bottom: 2px solid #000000;\">&nbsp;".pcrtlang("Payments").":&nbsp;</font></td></tr></table>";

$message .= "<table><tr>";
$pearhtml .= "<table><tr>";
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
$custompaymentinfo2 = "$findpaymentsa->custompaymentinfo";
$cashchange = "$findpaymentsa->cashchange";


$custompaymentinfo = unserialize("$custompaymentinfo2");

$ccnumber = substr("$ccnumber2", -4, 4);

if("$pcompany" != "") {
$pcompany2 = "$pcompany - ";
} else {
$pcompany2 = "";
}

#ooooo
if ($paymenttype == "cash") {
$message .= "<td valign=top style=\"padding:0px 30px 0px 5px;border: 2px solid #000000;border-radius:10px;\">";
$pearhtml .= "<td valign=top style=\"padding:0px 30px 0px 5px;border: 2px solid #000000;border-radius:10px;\">";

$message .= "<font style=\"border: 2px solid #000000;padding3px;border-radius:7px;\">&nbsp;".pcrtlang("Cash")."&nbsp;</font><br>$pfirstname - $pcompany2$money".mf("$paymentamount")."</td>";
$pearhtml .= "<font style=\"border: 2px solid #000000;padding3px;border-radius:7px;\">&nbsp;".pcrtlang("Cash")."&nbsp;</font><br>$pfirstname - $pcompany2$money".mf("$paymentamount");

if($cashchange != "") {
$cashchange2 = explode('|', $cashchange);
$message .= "<br><font size=1>".pcrtlang("Change").": $money".mf("$cashchange2[0]")." ".pcrtlang("Tendered").": $money".mf("$cashchange2[1]")."</font>";
$pearhtml .= "<br><font size=1>".pcrtlang("Change").": $money".mf("$cashchange2[0]")." ".pcrtlang("Tendered").": $money".mf("$cashchange2[1]")."</font>";
}

$message .= "</td>";
$pearhtml .= "</td>";


} elseif ($paymenttype == "check") {

$message .= "<td valign=top style=\"padding:0px 30px 0px 5px;border: 2px solid #000000;border-radius:10px;\">";
$pearhtml .= "<td valign=top style=\"padding:0px 30px 0px 5px;border: 2px solid #000000;border-radius:10px;\">";

$message .= "<font style=\"border: 2px solid #000000;padding3px;border-radius:7px;\">&nbsp;".pcrtlang("Check")." #$checknumber&nbsp;</font><br>$pfirstname -$pcompany2";
$pearhtml .= "<font style=\"border: 2px solid #000000;padding3px;border-radius:7px;\">&nbsp;".pcrtlang("Check")." #$checknumber&nbsp;</font><br>$pfirstname -$pcompany2";

$message .= "$money".mf("$paymentamount")."</td>";
$pearhtml .= "$money".mf("$paymentamount")."</td>";

} elseif ($paymenttype == "credit") {
$message .= "<td valign=top style=\"padding:0px 30px 0px 5px;border: 2px solid #000000;border-radius:10px;\">";
$pearhtml .= "<td valign=top style=\"padding:0px 30px 0px 5px;border: 2px solid #000000;border-radius:10px;\">";

$message .= "<font style=\"border: 2px solid #000000;padding3px;border-radius:7px;\">&nbsp;".pcrtlang("Credit Card")."&nbsp;</font>";
$pearhtml .= "<font style=\"border: 2px solid #000000;padding3px;border-radius:7px;\">&nbsp;".pcrtlang("Credit Card")."&nbsp;</font>";

$message .= "<br>XXXX-$ccnumber<br>";
$pearhtml .= "<br>XXXX-$ccnumber<br>";

$message .= "$pfirstname - $pcompany2$money".mf("$paymentamount")."<br>$paymentplugin $cc_cardtype</td>";
$pearhtml .= "$pfirstname - $pcompany2$money".mf("$paymentamount")."<br>$paymentplugin $cc_cardtype</td>";

} elseif ($paymenttype == "custompayment") {
$message .= "<td valign=top style=\"padding:0px 30px 0px 5px;border: 2px solid #000000;border-radius:10px;\">";
$pearhtml .= "<td valign=top style=\"padding:0px 30px 0px 5px;border: 2px solid #000000;border-radius:10px;\">";

$message .= "<font style=\"border: 2px solid #000000;padding3px;border-radius:7px;\">&nbsp;$paymentplugin&nbsp;</font><br>$pfirstname - $pcompany2$money".mf("$paymentamount")."<br>";
$pearhtml .= "<font style=\"border: 2px solid #000000;padding3px;border-radius:7px;\">&nbsp;$paymentplugin&nbsp;</font><br>$pfirstname - $pcompany2$money".mf("$paymentamount")."<br>";

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
$message .= "<td colspan=2 style=\"padding:0px 30px 0px 5px;border: 2px solid #000000;border-radius:10px;\">Error! Undefined Payment Type in database</td>";
$pearhtml .= "<td colspan=2 style=\"padding:0px 30px 0px 5px;border: 2px solid #000000;border-radius:10px;\">Error! Undefined Payment Type in database</td>";
}

}

if (mysqli_num_rows($findpaymentsq) != 0) {
$message .= "</tr></table>";
$pearhtml .= "</tr></table>";
}


$message .= nl2br($storeinfoarray['returnpolicy']);
$message .= "\n</body></html>\n\n";
$pearhtml .= nl2br($storeinfoarray['returnpolicy']);
$pearhtml .= "\n</body></html>\n\n";

# View Output No Email
# die($pearhtml);


$message .= "\n--PHP-alt-$random_hash--\n\n";

if (!isset($pcrt_mailer)) {
$pcrt_mailer = "mail";
}

if ($pcrt_mailer == "mail") {

userlog(27,$receipt,'receiptid',"Emailed to $to");
$mail_sent = @mail( $to, $subject, $message, $headers );
echo $mail_sent ? "<html><head><meta http-equiv=\"refresh\" content=\"2;url=receipt.php?func=show_receipt&receipt=$receipt\"></head><body>".pcrtlang("Mail sent")."<br><br><a href=receipt.php?func=show_receipt&receipt=$receipt>".pcrtlang("Return")."</a></body></html>" : pcrtlang("Mail failed");
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

$imagetype = substr("$logo", -3);
if ($imagetype == "gif") {
$pearmessage2->addHTMLImage("$logo", 'image/gif');
} elseif ($imagetype == "jpg") {
$pearmessage2->addHTMLImage("$logo", 'image/jpeg');
} elseif ($imagetype == "png") {
$pearmessage2->addHTMLImage("$logo", 'image/png');
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

userlog(27,$receipt,'receiptid',pcrtlang("Emailed to")." $to");

   echo "<html><head><meta http-equiv=\"refresh\" content=\"2;url=receipt.php?func=show_receipt&receipt=$receipt\"></head><body>".pcrtlang("Mail sent")."<br>";
   echo "<br><a href=receipt.php?func=show_receipt&receipt=$receipt>".pcrtlang("Return")."</a></body></html>";
  }

} else {
echo "Error: invalid mailer specified in the deps.php config file";
}


}


function savesig() {

require("deps.php");
require("common.php");

$output = pv($_REQUEST['output']);
$receipt = $_REQUEST['receipt'];

require_once("validate.php");





$rs_savesig = "UPDATE receipts SET thesig = '$output' WHERE receipt_id = '$receipt'";
@mysqli_query($rs_connect, $rs_savesig);

header("Location: receipt.php?func=show_receipt_printable&receipt=$receipt");

}

function savesigtopaz() {

require("deps.php");
require("common.php");

$output = pv($_REQUEST['sigImageData']);
$receipt = $_REQUEST['receipt'];

require_once("validate.php");





$rs_savesig = "UPDATE receipts SET thesigtopaz = '$output' WHERE receipt_id = '$receipt'";
@mysqli_query($rs_connect, $rs_savesig);

header("Location: receipt.php?func=show_receipt_printable&receipt=$receipt");

}



function clearsig() {

require("deps.php");
require("common.php");

$receipt = $_REQUEST['receipt'];

require_once("validate.php");





$rs_savesig = "UPDATE receipts SET thesig = '' WHERE receipt_id = '$receipt'";
@mysqli_query($rs_connect, $rs_savesig);

header("Location: receipt.php?func=show_receipt_printable&receipt=$receipt");

}

function clearsigtopaz() {

require("deps.php");
require("common.php");

$receipt = $_REQUEST['receipt'];

require_once("validate.php");





$rs_savesig = "UPDATE receipts SET thesigtopaz = '' WHERE receipt_id = '$receipt'";
@mysqli_query($rs_connect, $rs_savesig);

header("Location: receipt.php?func=show_receipt_printable&receipt=$receipt");

}



function hidesigrec() {

require("deps.php");
require("common.php");

$hidesig = pv($_REQUEST['hidesig']);
$receipt = $_REQUEST['receipt'];

require_once("validate.php");





$rs_hidesig = "UPDATE receipts SET showsigrec = '$hidesig' WHERE receipt_id = '$receipt'";
@mysqli_query($rs_connect, $rs_hidesig);

header("Location: receipt.php?func=show_receipt_printable&receipt=$receipt");

}

function hidesigrectopaz() {

require("deps.php");
require("common.php");

$hidesig = pv($_REQUEST['hidesig']);
$receipt = $_REQUEST['receipt'];

require_once("validate.php");





$rs_hidesig = "UPDATE receipts SET showsigrectopaz = '$hidesig' WHERE receipt_id = '$receipt'";
@mysqli_query($rs_connect, $rs_hidesig);

header("Location: receipt.php?func=show_receipt_printable&receipt=$receipt");

}


function printmultireceipts() {

require("deps.php");
require("common.php");

$recfrom = $_REQUEST['recfrom'];
$recto = $_REQUEST['recto'];

if ($recfrom > $recto) {
die(pcrtlang("Error: Receipt Start number must be smaller than ending number"));
}


if (($recto - $recfrom) > 205) {
die(pcrtlang("Error: Sorry, due to server limits you cannot print more than 200 receipts at a time."));
}


require_once("validate.php");


$receipt = "";

while ($recfrom <= $recto) {
$receipt .= "&receipt[]=$recfrom";
$recfrom++;
}


header("Location: receipt.php?func=show_receipt_printable$receipt");

}

function detailedsearch() {
require_once("validate.php");
require_once("header.php");
require("deps.php");

$searchterm = $_REQUEST['thesearch'];

start_blue_box(pcrtlang("Detailed Search"));

echo "<form action=receipt.php?func=search_receipt method=POST>";
echo "<input type=text value=\"$searchterm\" name=thesearch class=textbox size=25>";
echo "<input type=submit class=button value=\"".pcrtlang("Search Receipts")."\"></form><br><br>";

echo "<form action=invoice.php?func=searchinvoices method=POST>";
echo "<input type=text value=\"$searchterm\" name=searchterm class=textbox size=25>";
echo "<input type=submit class=button value=\"".pcrtlang("Search Invoices")."\"></form><br><br>";

echo "<form action=deposits.php?func=searchdeposits method=POST>";
echo "<input type=text value=\"$searchterm\" name=searchterm class=textbox size=25>";
echo "<input type=submit class=button value=\"".pcrtlang("Search Deposits")."\"></form><br><br>";



stop_blue_box();

require_once("footer.php");


}



function move_receipt() {
require_once("validate.php");
$receipt = $_REQUEST['receipt'];
$newstore = $_REQUEST['newstore'];
$oldstore = $_REQUEST['oldstore'];


require("deps.php");
require("common.php");

perm_boot("21");






$rs_update_rec = "UPDATE receipts SET storeid = '$newstore' WHERE receipt_id = '$receipt'";
@mysqli_query($rs_connect, $rs_update_rec);

$rs_update_payments = "UPDATE savedpayments SET storeid = '$newstore' WHERE receipt_id = '$receipt'";
@mysqli_query($rs_connect, $rs_update_payments);

$checkdeposit = "UPDATE deposits SET appliedstoreid = '$newstore' WHERE receipt_id = '$receipt'";
@mysqli_query($rs_connect, $checkdeposit);

$rs_find_cart_items = "SELECT * FROM sold_items WHERE sold_type = 'purchase' AND receipt = '$receipt'";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);
while($rs_result_q = mysqli_fetch_object($rs_result)) {
$purchase_stockid = "$rs_result_q->stockid";
if ($purchase_stockid != "0") {
checkstorecount($purchase_stockid);
$rs_add_stock = "UPDATE stockcounts SET quantity = quantity+1 WHERE stockid = '$purchase_stockid' AND storeid = '$oldstore'";
@mysqli_query($rs_connect, $rs_add_stock);
$rs_remove_stock = "UPDATE stockcounts SET quantity = quantity-1 WHERE stockid = '$purchase_stockid' AND storeid = '$newstore'";
@mysqli_query($rs_connect, $rs_remove_stock);
}
}

$rs_find_cart_items_returns = "SELECT * FROM sold_items WHERE sold_type = 'refund' AND receipt = '$receipt'";
$rs_result_return = mysqli_query($rs_connect, $rs_find_cart_items_returns);
while($rs_result_qr = mysqli_fetch_object($rs_result_return)) {
$purchase_stockidr = "$rs_result_qr->stockid";
if ($purchase_stockidr != "0") {
checkstorecount($purchase_stockidr);
$rs_add_stockr = "UPDATE stockcounts SET quantity = quantity-1 WHERE stockid = '$purchase_stockidr' AND storeid = '$oldstore'";
@mysqli_query($rs_connect, $rs_add_stockr);
$rs_remove_stockr = "UPDATE stockcounts SET quantity = quantity+1 WHERE stockid = '$purchase_stockidr' AND storeid = '$newstore'";
@mysqli_query($rs_connect, $rs_remove_stockr);
}
}

header("Location: receipt.php?func=show_receipt&receipt=$receipt");

}


switch($func) {
                                                                                                    
    default:
    enter_receipt();
    break;
                                
    case "show_receipt":
    show_receipt();
    break;

   case "delete_receipt":
    delete_receipt();
    break;

    case "show_receipt_printable":
    show_receipt_printable();
    break;

  case "search_receipt":
    search_receipt();
    break;

  case "detailedsearch":
    detailedsearch();
    break;


case "email_receipt":
    email_receipt();
    break;

case "email_receipt2":
    email_receipt2();
    break;

  case "savesig":
    savesig();
    break;

case "clearsig":
    clearsig();
    break;

case "hidesigrec":
    hidesigrec();
    break;

  case "savesigtopaz":
    savesigtopaz();
    break;

case "clearsigtopaz":
    clearsigtopaz();
    break;

case "hidesigrectopaz":
    hidesigrectopaz();
    break;


case "printmultireceipts":
    printmultireceipts();
    break;

case "move_receipt":
    move_receipt();
    break;


}

?>
