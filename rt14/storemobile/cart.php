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

                                                                                                    
function show_cart() {
require("deps.php");
require_once("validate.php");
require_once("header.php");
require_once("common.php");


$rs_find_cart_items_c = "SELECT SUM(quantity) AS ccitems FROM cart WHERE cart_type = 'purchase' AND ipofpc = '$ipofpc'";
$rs_result_c = mysqli_query($rs_connect, $rs_find_cart_items_c);
$totitem = mysqli_num_rows($rs_result_c);
$rs_result_ccitems = mysqli_fetch_object($rs_result_c);
$rs_ccitems = qf("$rs_result_ccitems->ccitems");


$mastertaxtotals = array();

echo "<div data-role=\"collapsible\" data-theme=\"a\">";
echo "<h3>".pcrtlang("Cart Actions")."</h3>";

echo "<button type=button onClick=\"parent.location='cart.php?func=show_savecart'\"><i class=\"fa fa-shopping-cart fa-lg\"></i> ".pcrtlang("Saved Carts")."</button>";
echo "<button type=button onClick=\"parent.location='cart.php?func=show_savecart&iskit=1'\"><i class=\"fa fa-puzzle-piece fa-lg\"></i> ".pcrtlang("Kits")."</button>";
echo "<button type=button onClick=\"parent.location='cart.php?func=empty_cart'\"><i class=\"fa fa-trash fa-lg\" style=\"color:#ff0000;\"></i> ".pcrtlang("Empty Cart")."</button>";

$rs_find_tax = "SELECT * FROM taxes WHERE taxenabled = '1' ORDER BY taxname ASC";
$rs_result_tax = mysqli_query($rs_connect, $rs_find_tax);
$usertaxid = getusertaxid();
echo pcrtlang("Default Tax Rate");
echo "<form method=post  data-ajax=\"false\" action=cart.php?func=setusertax>";
echo "<select name=settaxname  onchange='this.form.submit()' data-native-menu=\"false\">";

while($rs_result_tq = mysqli_fetch_object($rs_result_tax)) {
$rs_taxname = "$rs_result_tq->taxname";
$rs_taxid = "$rs_result_tq->taxid";

if ($rs_taxid == $usertaxid) {
echo "<option selected value=$rs_taxid>$rs_taxname</option>";
} else {
echo "<option value=$rs_taxid>$rs_taxname</option>";
}
}
echo "</select></form>";


echo "</div>";

echo "<div data-role=\"collapsible\" data-theme=\"a\">";
echo "<h3>".pcrtlang("Add to Cart")."</h3>";

echo "<font class=em90>".pcrtlang("Enter stock id number as shown on price tag or UPC code, Separate multiple items with a space")."</font>";
echo "<form action=cart.php?func=add_item method=post data-ajax=\"false\">";


echo "<div class=\"ui-field-contain\">";
echo "<label for=\"qty\">".pcrtlang("Qty").":</label>";
echo "<input type=number name=\"qty\" value=1> ";
echo "</div>";

echo "<input type=text name=\"stockid\" required=required></label>";

echo "<button type=submit onclick=\"this.disabled=true; this.form.submit();\"  data-ajax=\"false\"><i class=\"fa fa-plus\"></i> ".pcrtlang("Add")."</button></form><br>";
echo "<form action=stock.php?func=show_stock_detail method=post data-ajax=\"false\">";
echo "<input type=text name=\"stockid\" value=\"".pcrtlang("Enter Stock Id #")."\" onfocus=\"if(this.value=='".pcrtlang("Enter Stock Id #")."')this.value=''\">";
echo "<button type=submit><i class=\"fa fa-eye\"></i> ".pcrtlang("View")."</button></form><br>";


echo "<form action=stock.php?func=search_stock method=post data-ajax=\"false\">";
echo "<input type=text name=thesearch value=\"".pcrtlang("Enter Item Description")."\" onfocus=\"if(this.value=='".pcrtlang("Enter Item Description")."')this.value=''\">";
echo "<button type=submit><i class=\"fa fa-search\"></i> ".pcrtlang("Search")."</button></form><br>";

echo "<button type=button onClick=\"parent.location='cart.php?func=add_labor'\"><i class=\"fa fa-shopping-cart fa-lg\"></i> ".pcrtlang("Add Labor to Cart")."</button>";
echo "<button type=button onClick=\"parent.location='cart.php?func=add_noninv2'\"><i class=\"fa fa-shopping-cart fa-lg\"></i> ".pcrtlang("Add Non Inventoried Item to Cart")."</button>";

echo "</div>";



echo "<center><h3>".pcrtlang("Current Cart").": ";

if ($rs_ccitems == "0") {
echo pcrtlang("No Items");
} elseif ($rs_ccitems == "1") {
echo "$rs_ccitems ".pcrtlang("Item");
} else {
echo "$rs_ccitems ".pcrtlang("Items");
}

echo "</h3></center>";


echo "<br><table class=cart>";
echo "<tr><th colspan=2>".pcrtlang("Purchase Items")."</td></tr>";


$rs_find_cart_items = "SELECT * FROM cart WHERE cart_type = 'purchase' AND ipofpc = '$ipofpc' ORDER BY addtime ASC";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

if (mysqli_num_rows($rs_result) == 0) {
echo "<tr><td colspan=2>".pcrtlang("No Purchase Items")."</td></tr>";
}


while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_cart_item_id = "$rs_result_q->cart_item_id";
$rs_cart_price = "$rs_result_q->cart_price";
$rs_cart_type = "$rs_result_q->cart_type";
$rs_stock_id = "$rs_result_q->cart_stock_id";
$rs_price_alt = "$rs_result_q->price_alt";
$rs_noninvdesc = "$rs_result_q->labor_desc";
$rs_printdesc = "$rs_result_q->printdesc";
$rs_taxex = "$rs_result_q->taxex";
$rs_itemtax = "$rs_result_q->itemtax";
$rs_itemserial = "$rs_result_q->itemserial";
$rs_ourprice = "$rs_result_q->ourprice";
$rs_origprice = mf("$rs_result_q->origprice");
$rs_quantity = mf("$rs_result_q->quantity");
$rs_unit_price = mf("$rs_result_q->unit_price");


#newtaxcode
$salestaxrate = getsalestaxrate($rs_taxex);
$isgrouprate = isgrouprate($rs_taxex);

if($isgrouprate == 0) {
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

if ($rs_stock_id != "0") {
$rs_find_item_detail = "SELECT * FROM stock WHERE stock_id = '$rs_stock_id'";
$rs_find_result = mysqli_query($rs_connect, $rs_find_item_detail);
while($rs_find_result_q = mysqli_fetch_object($rs_find_result)) {
$rs_stocktitle = "$rs_find_result_q->stock_title";

echo "<tr><td><strong>$rs_stocktitle</strong>";

if ($rs_itemserial != "") {
echo "<br><span class=em90>".pcrtlang("Serial/Code").": $rs_itemserial</span>";
}

if (($rs_itemserial == "") && ($rs_quantity == 1)) {
if (count(available_serials($rs_stock_id)) > 0) {
echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class=\"fa fa-info-circle faa-flash animated\"></i> ".pcrtlang("Serials Available")."</span>";
echo " <button onClick=\"parent.location='cart.php?func=addserialafter&cart_item_id=$rs_cart_item_id&stockid=$rs_stock_id'\"  data-inline=\"true\"  class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\">
<i class=\"fa fa-plus\"></i></a>";
}
}

$rs_find_stock = "SELECT * FROM stockcounts WHERE storeid = '$defaultuserstore' AND stockid = '$rs_stock_id'";
$rs_result_stock = mysqli_query($rs_connect, $rs_find_stock);
$rs_result_stockq = mysqli_fetch_object($rs_result_stock);
$stockqty = "$rs_result_stockq->quantity";


if($stockqty < 1) {
echo "<br><i class=\"fa fa-exclamation-triangle fa-lg\"></i> ".pcrtlang("Warning: Item showing out of stock quantity")." ($stockqty) <button type=button onClick=\"parent.location='stock.php?func=show_stock_detail&stockid=$rs_stock_id'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline ui-mini\"><i class=\"fa fa-eye\"></i> ".pcrtlang("check qty")."</button>";
}


echo "</td><td style=\"text-align:right;\"><span class=em90>".qf("$rs_quantity")." X $money".mf("$rs_unit_price")."</span><br><strong>$money".mf("$rs_cart_price")."</strong><br><font class=em90>$t_tax: $money".mf("$rs_itemtax")."</font></td></tr>";

echo "<tr><td colspan=2>";


echo "<div data-role=\"collapsible\" data-theme=\"a\" data-mini=\"true\">";
echo "<h3>".pcrtlang("Item Actions")."</h3>";


echo "<a href=\"#popupdeleteci$rs_cart_item_id\" data-rel=\"popup\" data-position-to=\"window\" data-transition=\"pop\" class=\" ui-btn-inline ui-btn ui-shadow ui-corner-all\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> remove</a>";
echo "<div data-role=\"popup\" id=\"popupdeleteci$rs_cart_item_id\" data-overlay-theme=\"b\"  data-theme=\"a\" data-dismissible=\"false\">";
echo "<div data-role=\"header\" data-theme=\"b\">";
echo "<h1>".pcrtlang("Remove Cart Item")."?</h1>";
echo "</div>";
echo "<div role=\"main\" class=\"ui-content\">";
echo "<p>".pcrtlang("Are you sure you wish to remove this item from the cart?")."</p>";
echo "<div align=\"right\"><a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\" data-inline=\"true\"><i class=\"fa fa-ban fa-lg\"></i>  ".pcrtlang("Cancel")."</a>";
echo "<button onClick=\"parent.location='cart.php?func=remove_cart_item&cart_item_id=$rs_cart_item_id'\" data-inline=\"true\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")." </button></div>";
echo "</div>";
echo "</div>";

if($rs_itemserial == "") {
$rs_cart_unit_price_ue = urlencode("$rs_unit_price");
$rs_quantity_ue = urlencode("$rs_quantity");

if($rs_ourprice == 0 ) {
$ourprice_ue = 0;
} else {
$ourprice_ue = urlencode($rs_ourprice / $rs_quantity);
}

echo "<button onClick=\"parent.location='cart.php?func=editinvitem&cart_item_id=$rs_cart_item_id&rs_cart_price=$rs_cart_unit_price_ue&rs_taxex=$rs_taxex&price_alt=$rs_price_alt&cost=$ourprice_ue&qty=$rs_quantity_ue'\"  data-inline=\"true\"  class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\" ><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("edit")."</button><br>";
}




$rs_find_tax = "SELECT * FROM taxes WHERE taxenabled = '1' ORDER BY taxname ASC";
$rs_result_tax = mysqli_query($rs_connect, $rs_find_tax);
echo "<form method=post  data-ajax=\"false\" action=cart.php?func=setitemtax><input type=hidden name=cart_item_id value=$rs_cart_item_id><select name=settaxid class=selects  onchange='this.form.submit()'>";

while($rs_result_tq = mysqli_fetch_object($rs_result_tax)) {
$rs_taxname = "$rs_result_tq->taxname";
$rs_taxid = "$rs_result_tq->taxid";

if ($rs_taxid == $rs_taxex) {
echo "<option selected value=$rs_taxid>$rs_taxname</option>";
} else {
echo "<option value=$rs_taxid>$rs_taxname</option>";
}
}
echo "</select><input type=hidden name=cartitemtype value=purchase></form>";





if ($rs_price_alt != 1) {
echo "<br>";

#
echo "<div data-role=\"collapsible\" data-theme=\"b\">";
echo "<h3>".pcrtlang("Percentage Discount")."</h3>";
echo "<form method=post action=cart.php?func=discount_cart_item  data-ajax=\"false\"><input type=hidden name=cart_item_id value=$rs_cart_item_id><input type=hidden name=rs_taxex value=$rs_taxex>";
echo "<input type=hidden name=carttype value=purchase><input type=hidden name=qty value=$rs_quantity>";
echo "<input type=text placeholder=\"".pcrtlang("Enter Percentage")."\" name=rs_dis_percent id=percentdiscount$rs_cart_item_id>
<i class=\"fa fa-percent\"></i>";

echo "<br><input type=text name=discountname id=discountname$rs_cart_item_id placeholder=\"".pcrtlang("Enter Discount Name")."\"><br>";

echo "<select name=myoptions onchange='document.getElementById(\"percentdiscount$rs_cart_item_id\").value=this.options[this.selectedIndex].value; document.getElementById(\"discountname$rs_cart_item_id\").value=this.options[this.selectedIndex].text'>";
$rs_ql = "SELECT * FROM discounts WHERE discounttype = '1' ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
echo "<option value=\"\">".pcrtlang("Choose Discount")."</option>";
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$discountid = "$rs_result_q1->discountid";
$discounttitle = "$rs_result_q1->discounttitle";
$discountamount = "$rs_result_q1->discountamount";
$discounttype = "$rs_result_q1->discounttype";
echo "<option value=\"".mf("$discountamount")."\">$discounttitle</option>";
}
echo "</select>";

echo "<br><button type=reset><i class=\"fa fa-eraser\"></i> ".pcrtlang("Reset")."</button>";
echo "<button type=button onclick=\"this.disabled=true; this.form.submit();\"><i class=\"fa fa-plus\"></i> ".pcrtlang("Add Discount")."</button>";

echo "</form>";
echo "</div>";

echo "<br>";
echo "<div data-role=\"collapsible\" data-theme=\"b\">";
echo "<h3>".pcrtlang("Nominal Discount")."</h3>";
echo "<form method=post action=cart.php?func=custom_price  data-ajax=\"false\"><input type=hidden name=cart_item_id value=$rs_cart_item_id><input type=hidden name=rs_taxex value=$rs_taxex>";
echo "<input type=hidden name=carttype value=\"$rs_cart_type\"><input type=hidden name=qty value=$rs_quantity>";
echo "<input type=text name=custom_price id=customprice$rs_cart_item_id value=\"".mf("$rs_unit_price")."\">";
echo "<br><input type=text name=discountname id=discountnamen$rs_cart_item_id placeholder=\"".pcrtlang("Enter Discount Name")."\"><br>";

################

echo "<select name=myoptions onchange='document.getElementById(\"customprice$rs_cart_item_id\").value=($rs_cart_price"." - this.options[this.selectedIndex].value).toFixed(2); document.getElementById(\"discountnamen$rs_cart_item_id\").value=this.options[this.selectedIndex].text'>";
$rs_ql = "SELECT * FROM discounts WHERE discounttype = '2' AND discountamount <= '$rs_unit_price' ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
echo "<option value=\"$rs_unit_price\">".pcrtlang("Choose Discount")."</option>";
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$discountid = "$rs_result_q1->discountid";
$discounttitle = "$rs_result_q1->discounttitle";
$discountamount = "$rs_result_q1->discountamount";
$discounttype = "$rs_result_q1->discounttype";
echo "<option value=\"$discountamount\">$discounttitle</option>";
}
echo "</select>";

echo "<br><button type=reset><i class=\"fa fa-eraser\"></i> ".pcrtlang("Reset")."</button>";
echo "<button onclick=\"this.disabled=true; this.form.submit();\"><i class=\"fa fa-plus\"></i> ".pcrtlang("Set Custom Price")."</button>";

#########
echo "</form>";
echo "</div>";
#

} else {
echo pcrtlang("discounted/custom price")." - ".pcrtlang("was")." $money$rs_origprice <button type=button onClick=\"parent.location='cart.php?func=removediscount&cart_item_id=$rs_cart_item_id'\"><i class=\"fa fa-times fa-lg\"></i> ".pcrtlang("remove discount")."</button>";
}


echo "</div>";



echo "</td></tr>";
}

} else {

echo "<tr><td>";

echo "<strong>$rs_noninvdesc</strong>";

if ($rs_itemserial != "") {
echo "<br><font class=em90>".pcrtlang("Serial/Code").": $rs_itemserial</font>";
}


echo "</td><td style=\"text-align:right;\"><span class=em90>".qf("$rs_quantity")." X $money".mf("$rs_unit_price")."</span><br><strong>$money".mf("$rs_cart_price")."</strong><br><font class=em90>$t_tax: $money".mf("$rs_itemtax")."</font></td></tr>";

echo "<tr><td colspan=2>";

echo "<div data-role=\"collapsible\" data-theme=\"a\" data-mini=\"true\">";
echo "<h3>".pcrtlang("Item Actions")."</h3>";

$rs_cart_unit_price_ue = urlencode("$rs_unit_price");
$rs_cart_price_ue = urlencode("$rs_cart_price");
$rs_labor_desc_ue = urlencode("$rs_noninvdesc");
$rs_printdesc_ue = urlencode("$rs_printdesc");
$rs_itemserial_ue = urlencode("$rs_itemserial");
$rs_quantity_ue = urlencode("$rs_quantity");

if($rs_ourprice == 0 ) {
$ourprice_ue = 0;
} else {
$ourprice_ue = urlencode($rs_ourprice / $rs_quantity);
}

echo "<button type=button  class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" onClick=\"parent.location='cart.php?func=edit&cart_item_id=$rs_cart_item_id&rs_cart_price=$rs_cart_price_ue&rs_taxex=$rs_taxex&rs_cart_type=$rs_cart_type&itemdesc=$rs_labor_desc_ue&price_alt=$rs_price_alt&serial=$rs_itemserial_ue&cost=$ourprice_ue&qty=$rs_quantity_ue&printdesc=$rs_printdesc_ue'\"><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("edit")."</button>";


echo "<a href=\"#popupdeleteci$rs_cart_item_id\" data-rel=\"popup\" data-position-to=\"window\" data-transition=\"pop\" class=\"ui-btn-inline ui-btn ui-shadow ui-corner-all\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> remove</a>";
echo "<div data-role=\"popup\" id=\"popupdeleteci$rs_cart_item_id\" data-overlay-theme=\"b\"  data-theme=\"a\" data-dismissible=\"false\">";
echo "<div data-role=\"header\" data-theme=\"b\">";
echo "<h1>".pcrtlang("Remove Cart Item")."?</h1>";
echo "</div>";
echo "<div role=\"main\" class=\"ui-content\">";
echo "<p>".pcrtlang("Are you sure you wish to remove this item from the cart?")."</p>";
echo "<div align=\"right\"><a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\" data-inline=\"true\"><i class=\"fa fa-ban fa-lg\"></i>  ".pcrtlang("Cancel")."</a>";
echo "<button onClick=\"parent.location='cart.php?func=remove_cart_item&cart_item_id=$rs_cart_item_id'\" data-inline=\"true\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")." </button></div>";
echo "</div>";
echo "</div>";


$rs_find_tax = "SELECT * FROM taxes WHERE taxenabled = '1' ORDER BY taxname ASC";
$rs_result_tax = mysqli_query($rs_connect, $rs_find_tax);
echo "<form method=post  data-ajax=\"false\" action=cart.php?func=setitemtax><input type=hidden name=cart_item_id value=$rs_cart_item_id><select name=settaxid class=selects  onchange='this.form.submit()'>";

while($rs_result_tq = mysqli_fetch_object($rs_result_tax)) {
$rs_taxname = "$rs_result_tq->taxname";
$rs_taxid = "$rs_result_tq->taxid";

if ($rs_taxid == $rs_taxex) {
echo "<option selected value=$rs_taxid>$rs_taxname</option>";
} else {
echo "<option value=$rs_taxid>$rs_taxname</option>";
}
}
echo "</select><input type=hidden name=cartitemtype value=purchase></form>";





if ($rs_price_alt != 1) {

echo "<div data-role=\"collapsible\" data-theme=\"b\">";
echo "<h3>".pcrtlang("Percentage Discount")."</h3>";
echo "<form method=post action=cart.php?func=discount_cart_item data-ajax=\"false\"><input type=hidden name=cart_item_id value=$rs_cart_item_id><input type=hidden name=rs_taxex value=$rs_taxex>";
echo "<input type=hidden name=carttype value=purchase><input type=hidden name=qty value=$rs_quantity>";
echo "<input type=text placeholder=\"".pcrtlang("Enter Percentage")."\" name=rs_dis_percent id=percentdiscount$rs_cart_item_id>";

echo "<br><input type=text name=discountname id=discountname$rs_cart_item_id placeholder=\"".pcrtlang("Enter Discount Name")."\"><br>";

echo "<select name=myoptions class=margin5 onchange='document.getElementById(\"percentdiscount$rs_cart_item_id\").value=this.options[this.selectedIndex].value; document.getElementById(\"discountname$rs_cart_item_id\").value=this.options[this.selectedIndex].text'>";
$rs_ql = "SELECT * FROM discounts WHERE discounttype = '1' ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
echo "<option value=\"\">".pcrtlang("Choose Discount")."</option>";
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$discountid = "$rs_result_q1->discountid";
$discounttitle = "$rs_result_q1->discounttitle";
$discountamount = "$rs_result_q1->discountamount";
$discounttype = "$rs_result_q1->discounttype";
echo "<option value=\"".mf("$discountamount")."\">$discounttitle</option>";
}
echo "</select>";

echo "<br><button type=reset><i class=\"fa fa-eraser\"></i> ".pcrtlang("Reset")."</button>";
echo "<button type=button onclick=\"this.disabled=true; this.form.submit();\"><i class=\"fa fa-plus\"></i> ".pcrtlang("Add Discount")."</button>";

echo "</form>";

echo "</div>";
echo "<br>";

echo "<div data-role=\"collapsible\" data-theme=\"b\">";
echo "<h3>".pcrtlang("Nominal Discount")."</h3>";
echo "<form method=post action=cart.php?func=custom_price data-ajax=\"false\"><input type=hidden name=cart_item_id value=$rs_cart_item_id><input type=hidden name=rs_taxex value=$rs_taxex>";
echo "<input type=hidden name=carttype value=\"$rs_cart_type\"><input type=hidden name=qty value=$rs_quantity>";
echo "<input type=text name=custom_price id=customprice$rs_cart_item_id value=\"".mf("$rs_cart_price")."\">";
echo "<br><input type=text name=discountname id=discountnamen$rs_cart_item_id placeholder=\"".pcrtlang("Enter Discount Name")."\"><br>";

################

echo "<select name=myoptions onchange='document.getElementById(\"customprice$rs_cart_item_id\").value=($rs_cart_price"." - this.options[this.selectedIndex].value).toFixed(2); document.getElementById(\"discountnamen$rs_cart_item_id\").value=this.options[this.selectedIndex].text'>";
$rs_ql = "SELECT * FROM discounts WHERE discounttype = '2' AND discountamount <= '$rs_unit_price' ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
echo "<option value=\"$rs_unit_price\">".pcrtlang("Choose Discount")."</option>";
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$discountid = "$rs_result_q1->discountid";
$discounttitle = "$rs_result_q1->discounttitle";
$discountamount = "$rs_result_q1->discountamount";
$discounttype = "$rs_result_q1->discounttype";
echo "<option value=\"$discountamount\">$discounttitle</option>";
}
echo "</select>";

echo "<br><button type=reset><i class=\"fa fa-eraser\"></i> ".pcrtlang("Reset")."</button>";
echo "<button type=\"button\" onclick=\"this.disabled=true; this.form.submit();\"><i class=\"fa fa-plus\"></i> ".pcrtlang("Set Custom Price")."</button>";

#########
echo "</form>";
echo "</div>";


} else {
echo pcrtlang("discounted/custom price")." - ".pcrtlang("was")." $money$rs_origprice <button type=button onClick=\"parent.location='cart.php?func=removediscount&cart_item_id=$rs_cart_item_id'\"><i class=\"fa fa-times fa-lg\"></i> ".pcrtlang("remove discount")."</button>";
}


echo "</div>";
echo "</td></tr>";


}



}


echo "<tr><th colspan=2>".pcrtlang("Labor")."</th></tr>";

$rs_find_cart_labor = "SELECT * FROM cart WHERE cart_type = 'labor' AND ipofpc = '$ipofpc' ORDER BY addtime ASC";
$rs_result_labor = mysqli_query($rs_connect, $rs_find_cart_labor);

if (mysqli_num_rows($rs_result_labor) == 0) {
echo "<tr><td colspan=2>".pcrtlang("No Labor Items")."</td></tr>";
}

                                                                                                                                               
while($rs_result_labor_q = mysqli_fetch_object($rs_result_labor)) {
$rs_cart_labor_id = "$rs_result_labor_q->cart_item_id";
$rs_cart_labor_price = "$rs_result_labor_q->cart_price";
$rs_cart_labor_type = "$rs_result_labor_q->cart_type";
$rs_cart_labor_desc = "$rs_result_labor_q->labor_desc";
$rs_cart_printdesc = "$rs_result_labor_q->printdesc";
$rs_labprice_alt = "$rs_result_labor_q->price_alt";
$rs_taxex = "$rs_result_labor_q->taxex";
$rs_labortax = "$rs_result_labor_q->itemtax";
$rs_cart_labor_origprice = mf("$rs_result_labor_q->origprice");
$rs_cart_labor_unit_price = "$rs_result_labor_q->unit_price";
$rs_cart_labor_quantity = "$rs_result_labor_q->quantity";

#newtaxcode
$servicetaxrate = getservicetaxrate($rs_taxex);
$isgrouprate = isgrouprate($rs_taxex);

if($isgrouprate == 0) {
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




echo "<tr><td><strong>$rs_cart_labor_desc</strong>";

echo "</td><td style=\"text-align:right;\"><span class=em90>".qf("$rs_cart_labor_quantity")." X $money".mf("$rs_cart_labor_unit_price")."</span><br><strong>$money".mf("$rs_cart_labor_price")."</strong><br><font class=em90>$t_tax: $money".mf("$rs_labortax")."</font></td></tr>";

#$rs_cart_labor_price2 = urlencode("$rs_cart_labor_price");

$rs_cart_labor_unit_price2 = urlencode("$rs_cart_labor_unit_price");
$rs_cart_labor_desc2 = urlencode("$rs_cart_labor_desc"); 
$rs_cart_printdesc2 = urlencode("$rs_cart_printdesc");
$rs_cart_labor_quantity2 = urlencode("$rs_cart_labor_quantity");

echo "<tr><td colspan=2>";
echo "<div data-role=\"collapsible\" data-theme=\"a\" data-mini=\"true\">";
echo "<h3>".pcrtlang("Labor Item Actions")."</h3>";

echo "<button type=button onClick=\"parent.location='cart.php?func=edit&cart_item_id=$rs_cart_labor_id&rs_cart_price=$rs_cart_labor_unit_price2&rs_taxex=$rs_taxex&rs_cart_type=$rs_cart_labor_type&itemdesc=$rs_cart_labor_desc2&price_alt=$rs_labprice_alt&serial=&cost=0&qty=$rs_cart_labor_quantity2&printdesc=$rs_cart_printdesc2'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("edit")."</button>";



echo "<a href=\"#popupdeleteci$rs_cart_labor_id\" data-rel=\"popup\" data-position-to=\"window\" data-transition=\"pop\" class=\"ui-btn-inline ui-btn ui-shadow ui-corner-all\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> remove</a>";
echo "<div data-role=\"popup\" id=\"popupdeleteci$rs_cart_labor_id\" data-overlay-theme=\"b\"  data-theme=\"a\" data-dismissible=\"false\">";
echo "<div data-role=\"header\" data-theme=\"b\">";
echo "<h1>".pcrtlang("Remove Cart Item")."?</h1>";
echo "</div>";
echo "<div role=\"main\" class=\"ui-content\">";
echo "<p>".pcrtlang("Are you sure you wish to remove this item from the cart?")."</p>";
echo "<div align=\"right\"><a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\" data-inline=\"true\"><i class=\"fa fa-ban fa-lg\"></i>  ".pcrtlang("Cancel")."</a>";
echo "<button onClick=\"parent.location='cart.php?func=remove_cart_item&cart_item_id=$rs_cart_labor_id'\" data-inline=\"true\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")." </button></div>";
echo "</div>";
echo "</div>";



$rs_find_tax = "SELECT * FROM taxes WHERE taxenabled = '1' ORDER BY taxname ASC";
$rs_result_tax = mysqli_query($rs_connect, $rs_find_tax);
echo "<form method=post  data-ajax=\"false\" action=cart.php?func=setitemtax><input type=hidden name=cart_item_id value=$rs_cart_labor_id><select name=settaxid class=selects onchange='this.form.submit()'>";

while($rs_result_tq = mysqli_fetch_object($rs_result_tax)) {
$rs_taxname = "$rs_result_tq->taxname";
$rs_taxid = "$rs_result_tq->taxid";

if ($rs_taxid == $rs_taxex) {
echo "<option selected value=$rs_taxid>$rs_taxname</option>";
} else {
echo "<option value=$rs_taxid>$rs_taxname</option>";
}
}
echo "</select><input type=hidden name=cartitemtype value=labor></form>";



if ($rs_labprice_alt != 1) {

echo "<div data-role=\"collapsible\" data-theme=\"b\">";
echo "<h3>".pcrtlang("Percentage Discount")."</h3>";
echo "<br><form method=post action=cart.php?func=discount_cart_item  data-ajax=\"false\"><input type=hidden name=cart_item_id value=$rs_cart_labor_id><input type=hidden name=rs_taxex value=$rs_taxex>";
echo "<input type=hidden name=carttype value=labor><input type=hidden name=qty value=$rs_cart_labor_quantity>";
echo "<input type=text placeholder=\"".pcrtlang("Enter Percentage")."\" class=\"textbox margin5\" name=rs_dis_percent id=percentdiscount$rs_cart_labor_id>";

echo "<br><input type=text name=discountname id=discountname$rs_cart_labor_id class=\"textbox margin5\" style=\"width:90%;\" placeholder=\"".pcrtlang("Enter Discount Name")."\"><br>";

echo "<select name=myoptions class=margin5 onchange='document.getElementById(\"percentdiscount$rs_cart_labor_id\").value=this.options[this.selectedIndex].value; 
document.getElementById(\"discountname$rs_cart_labor_id\").value=this.options[this.selectedIndex].text'>";
$rs_ql = "SELECT * FROM discounts WHERE discounttype = '1' ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
echo "<option value=\"\">".pcrtlang("Choose Discount")."</option>";
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$discountid = "$rs_result_q1->discountid";
$discounttitle = "$rs_result_q1->discounttitle";
$discountamount = "$rs_result_q1->discountamount";
$discounttype = "$rs_result_q1->discounttype";
echo "<option value=\"".mf("$discountamount")."\">$discounttitle</option>";
}
echo "</select>";

echo "<br><button type=reset><i class=\"fa fa-eraser\"></i> ".pcrtlang("Reset")."</button>";
echo "<button type=button onclick=\"this.disabled=true; this.form.submit();\"><i class=\"fa fa-plus\"></i> ".pcrtlang("Add Discount")."</button>";

echo "</form>";
echo "</div>";
echo "<br>";
echo "<div data-role=\"collapsible\" data-theme=\"b\">";
echo "<h3>".pcrtlang("Nominal Discount")."</h3><br>";
echo "<form method=post action=cart.php?func=custom_price  data-ajax=\"false\"><input type=hidden name=cart_item_id value=$rs_cart_labor_id><input type=hidden name=rs_taxex value=$rs_taxex>";
echo "<input type=hidden name=carttype value=\"$rs_cart_labor_type\"><input type=hidden name=qty value=$rs_cart_labor_quantity>";
echo "$money<input type=text name=custom_price id=customprice$rs_cart_labor_id value=\"".mf("$rs_cart_labor_unit_price")."\">";
echo "<br><input type=text name=discountname id=discountnamen$rs_cart_labor_id placeholder=\"".pcrtlang("Enter Discount Name")."\"><br>";

################

echo "<select name=myoptions onchange='document.getElementById(\"customprice$rs_cart_labor_id\").value=($rs_cart_labor_unit_price"." - this.options[this.selectedIndex].value).toFixed(2); document.getElementById(\"discountnamen$rs_cart_labor_id\").value=this.options[this.selectedIndex].text'>";
$rs_ql = "SELECT * FROM discounts WHERE discounttype = '2' AND discountamount <= '$rs_cart_labor_unit_price' ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
echo "<option value=\"$rs_cart_labor_unit_price\">".pcrtlang("Choose Discount")."</option>";
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$discountid = "$rs_result_q1->discountid";
$discounttitle = "$rs_result_q1->discounttitle";
$discountamount = "$rs_result_q1->discountamount";
$discounttype = "$rs_result_q1->discounttype";
echo "<option value=\"$discountamount\">$discounttitle</option>";
}
echo "</select>";

echo "<br><button type=reset><i class=\"fa fa-eraser\"></i> ".pcrtlang("Reset")."</button>";
echo "<button type=\"button\" onclick=\"this.disabled=true; this.form.submit();\"><i class=\"fa fa-plus\"></i> ".pcrtlang("Set Custom Price")."</button>";

#########
echo "</form>";
echo "</div>";

} else {
echo pcrtlang("discounted")." - ".pcrtlang("was")." $money$rs_cart_labor_origprice <button type=button onClick=\"parent.location='cart.php?func=removediscount&cart_item_id=$rs_cart_labor_id'\"><i class=\"fa fa-times fa-lg\"></i> ".pcrtlang("remove discount")."</button>";
}


echo "</div>";
echo "</td></tr>";



}




echo "<tr><th colspan=2>".pcrtlang("Returned Items")."</th></tr>";
                                                                                                                                               
                                                                                                                                               
$rs_find_cart_returns = "SELECT * FROM cart WHERE cart_type = 'refund' AND ipofpc = '$ipofpc' ORDER BY addtime ASC";
$rs_result_returns = mysqli_query($rs_connect, $rs_find_cart_returns);
      
$returncount = mysqli_num_rows($rs_result_returns);

if ($returncount == 0) {
echo "<tr><td colspan=2>".pcrtlang("No Return Items")."</td></tr>";
}

                                                                                                                                         
while($rs_result_returns_q = mysqli_fetch_object($rs_result_returns)) {
$rs_cart_return_id = "$rs_result_returns_q->cart_item_id";
$rs_cart_return_price = "$rs_result_returns_q->cart_price";
$rs_stock_return_id = "$rs_result_returns_q->cart_stock_id";
$rs_restocking_fee = "$rs_result_returns_q->restocking_fee"; 
$rs_return_sold_id = "$rs_result_returns_q->return_sold_id";                                                                                   
$rs_return_noninvitem = "$rs_result_returns_q->labor_desc";
$rs_return_taxex = "$rs_result_returns_q->taxex";                                                         
$rs_return_itemtax = "$rs_result_returns_q->itemtax";
$rs_return_unit_price = "$rs_result_returns_q->unit_price";
$rs_return_quantity = "$rs_result_returns_q->quantity";


#newtaxcode
$salestaxrate = getsalestaxrate($rs_return_taxex);
$isgrouprate = isgrouprate($rs_return_taxex);

if($isgrouprate == 0) {
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




$return_taxname = gettaxname($rs_return_taxex);


if ($rs_stock_return_id != "0") {
echo "<tr><td><strong>$rs_return_stocktitle</strong></td><td style=\"text-align:right;\">";
echo "<span class=em90>".qf("$rs_return_quantity")." X $money".mf("$rs_return_unit_price")."</span><br>";
echo "<strong>$money".mf("$rs_cart_return_price")."</strong><br><font class=em90>".pcrtlang("Refunded")." $t_tax: ".mf("$rs_return_itemtax");
echo "</font></td></tr>";
echo "<tr><td>";
$rs_find_return_detail = "SELECT * FROM stock WHERE stock_id = '$rs_stock_return_id'";
$rs_find_return_result = mysqli_query($rs_connect, $rs_find_return_detail);
while($rs_find_result_return_q = mysqli_fetch_object($rs_find_return_result)) {
$rs_return_stocktitle = "$rs_find_result_return_q->stock_title";
echo "<button type=button onClick=\"parent.location='cart.php?func=remove_cart_item&cart_item_id=$rs_cart_return_id&rs_return_sold_id=$rs_return_sold_id'\">".pcrtlang("Remove")."</a>";

if ($rs_restocking_fee == 'yes') {
echo "<br><font class=em90>".pcrtlang("Subject to 20% Restocking Fee")."</font>";
} elseif ($rs_restocking_fee == '5per') {
echo "<font class=em90><br>".pcrtlang("Subject to 5% Restocking Fee")."</font>";
}
}

echo "</td></tr>";

} else {
echo "<tr><td><strong>$rs_return_noninvitem</strong></td><td style=\"text-align:right;\">";
echo "<strong>$money".mf("$rs_cart_return_price")."</strong><br><font class=em90>".pcrtlang("Refunded")." $t_tax: ".mf("$rs_return_itemtax");
echo "</font></td></tr>";
echo "<tr><td colspan=2>";
if ($rs_restocking_fee == 'yes') {
echo "<br><font class=em90>".pcrtlang("Subject to 20% Restocking Fee")."</font>";
} elseif ($rs_restocking_fee == '5per') {
echo "<br><font class=em90".pcrtlang("Subject to 5% Restocking Fee")."</font>";
}

echo "<button type=button onClick=\"parent.location='cart.php?func=remove_cart_item&cart_item_id=$rs_cart_return_id&rs_return_sold_id=$rs_return_sold_id'\" data-mini=\"true\"><i class=\"fa fa-times fa-lg\"></i> ".pcrtlang("Remove")."</button>";
echo "</td></tr>";

}
}

##### # labor refund
echo "<tr><th colspan=2>".pcrtlang("Refunded Labor")."</td></tr>";

$rs_find_cart_refundlabor = "SELECT * FROM cart WHERE cart_type = 'refundlabor' AND ipofpc = '$ipofpc' ORDER BY addtime ASC";
$rs_result_refundlabor = mysqli_query($rs_connect, $rs_find_cart_refundlabor);

$refundlaborcount = mysqli_num_rows($rs_result_refundlabor);

if ($refundlaborcount == 0) {
echo "<tr><td colspan=2>".pcrtlang("No Labor Refunds")."</td></tr>";
}


while($rs_result_refundlabor_q = mysqli_fetch_object($rs_result_refundlabor)) {
$rs_cart_refundlabor_id = "$rs_result_refundlabor_q->cart_item_id";
$rs_cart_refundlabor_price = "$rs_result_refundlabor_q->cart_price";
$rs_refundlabor_sold_id = "$rs_result_refundlabor_q->return_sold_id";
$rs_refundlabor_labordesc = "$rs_result_refundlabor_q->labor_desc";
$rs_refundlabor_taxex = "$rs_result_refundlabor_q->taxex";
$rs_refundlabor_itemtax = "$rs_result_refundlabor_q->itemtax";
$rs_refundlabor_unit_price = "$rs_result_refundlabor_q->unit_price";
$rs_refundlabor_quantity = "$rs_result_refundlabor_q->quantity";

#newtaxcode
$servicetaxrate = getservicetaxrate($rs_refundlabor_taxex);
$isgrouprate = isgrouprate($rs_refundlabor_taxex);

if($isgrouprate == 0) {
if(!array_key_exists("$rs_refundlabor_taxex", $mastertaxtotals)) {
$mastertaxtotals[$rs_refundlabor_taxex]['parts'] = 0;
$mastertaxtotals[$rs_refundlabor_taxex]['labor'] = 0;
$mastertaxtotals[$rs_refundlabor_taxex]['return'] = 0;
$mastertaxtotals[$rs_refundlabor_taxex]['refundlabor'] = $servicetaxrate * $rs_cart_refundlabor_price;
} else {
$mastertaxtotals[$rs_refundlabor_taxex]['refundlabor'] = ($servicetaxrate * $rs_cart_refundlabor_price) + $mastertaxtotals[$rs_refundlabor_taxex]['return'];
}
} else {
$grouprates = getgrouprates($rs_refundlabor_taxex);
foreach($grouprates as $key => $val) {
$servicetaxratei = getservicetaxrate($val);

if(!array_key_exists("$val", $mastertaxtotals)) {
$mastertaxtotals[$val]['parts'] = 0;
$mastertaxtotals[$val]['labor'] = 0;
$mastertaxtotals[$val]['return'] = 0;
$mastertaxtotals[$val]['refundlabor'] = $servicetaxratei * $rs_cart_refundlabor_price;
} else {
$mastertaxtotals[$val]['refundlabor'] = ($servicetaxratei * $rs_cart_refundlabor_price) + $mastertaxtotals[$val]['refundlabor'];
}

}
}
####
$refundlabor_taxname = gettaxname($rs_refundlabor_taxex);

echo "<tr><td><strong>$rs_refundlabor_labordesc</strong></td>";

echo "<td style=\"text-align:right;\">";

echo "<span class=em90>".qf("$rs_refundlabor_quantity")." X $money".mf("$rs_refundlabor_unit_price")."</span><br>";
echo "<strong>$money".mf("$rs_cart_refundlabor_price")."</strong><br><font class=em90>".pcrtlang("Refunded")." $t_tax: ".mf("$rs_refundlabor_itemtax")."</font></td></tr>";

echo "<tr><td colspan=2><button type=button onClick=\"parent.location='cart.php?func=remove_cart_item&cart_item_id=$rs_cart_refundlabor_id&rs_return_sold_id=$rs_refundlabor_sold_id'\" data-mini=\"true\"><i class=\"fa fa-times fa-lg\"></i> ".pcrtlang("Remove")."</button></td></tr>";

}

echo "<tr><td colspan=2>&nbsp;</td></tr>";

##### #



$rs_find_item_total = "SELECT SUM(cart_price) AS total_price_parts FROM cart WHERE cart_type = 'purchase' AND ipofpc = '$ipofpc'";
$rs_find_result_total = mysqli_query($rs_connect, $rs_find_item_total);
                                                                                                                                               
while($rs_find_result_total_q = mysqli_fetch_object($rs_find_result_total)) {
$rs_total_parts = "$rs_find_result_total_q->total_price_parts";

if ($rs_total_parts == "") {
$rs_total_parts = "0.00";
}
                                                                                                                                               
echo "<tr><td style=\"text-align:right;\"><strong>".pcrtlang("Purchased Items Total").":</strong></td><td style=\"text-align:right;\"><strong>$money".mf("$rs_total_parts")."</strong></td></tr>";



$rs_find_itemtax_total = "SELECT SUM(itemtax) AS total_tax_parts FROM cart WHERE cart_type = 'purchase' AND ipofpc = '$ipofpc'";
$rs_find_result_taxtotal = mysqli_query($rs_connect, $rs_find_itemtax_total);
while($rs_find_result_taxtotal_q = mysqli_fetch_object($rs_find_result_taxtotal)) {
$rs_total_partstax = "$rs_find_result_taxtotal_q->total_tax_parts";


if ($rs_total_partstax > 0) {

foreach($mastertaxtotals as $key => $val) {
$taxname = gettaxshortname($key);
$taxtotal = $mastertaxtotals[$key]['parts'];
if($taxtotal != 0) {
echo "<tr><td style=\"text-align:right;\">$taxname:</td><td style=\"text-align:right;\">$money".mf("$taxtotal")."</td></tr>";
}
}

echo "<tr><td style=\"text-align:right;\">".pcrtlang("Total Parts")." $t_tax:</td><td style=\"text-align:right;\">$money".mf("$rs_total_partstax")."</td></tr>";
}
}
}
                                                                                                                                               
                                                                                                                                               


$rs_find_labor_total = "SELECT SUM(cart_price) AS total_labor_price FROM cart WHERE cart_type = 'labor' AND ipofpc = '$ipofpc'";
$rs_find_result_labor_total = mysqli_query($rs_connect, $rs_find_labor_total);
while($rs_find_result_labor_total_q = mysqli_fetch_object($rs_find_result_labor_total)) {
$rs_total_labor = "$rs_find_result_labor_total_q->total_labor_price";

if ($rs_total_labor == "") {
$rs_total_labor = "0.00";
}
                       
                                                                                                                        
echo "<tr><td style=\"text-align:right;\"><strong>".pcrtlang("Labor Total").":</strong></td><td style=\"text-align:right;\"><strong>$money".mf("$rs_total_labor")."</strong></td></tr>";

$rs_find_labortax_total = "SELECT SUM(itemtax) AS total_labortax_price FROM cart WHERE cart_type = 'labor' AND ipofpc = '$ipofpc'";
$rs_find_result_taxlabor_total = mysqli_query($rs_connect, $rs_find_labortax_total);
while($rs_find_result_labortax_total_q = mysqli_fetch_object($rs_find_result_taxlabor_total)) {
$rs_total_labortax = "$rs_find_result_labortax_total_q->total_labortax_price";

if ($rs_total_labortax > 0) {

reset($mastertaxtotals);
foreach($mastertaxtotals as $key => $val) {
$taxname = gettaxshortname($key);
$taxtotal = $mastertaxtotals[$key]['labor'];
if($taxtotal != 0) {
echo "<tr><td style=\"text-align:right;\">$taxname:</td><td style=\"text-align:right;\">$money".mf("$taxtotal")."</td></tr>";
}
}


echo "<tr><td style=\"text-align:right;\">".pcrtlang("Total Labor")." $t_tax:</td><td style=\"text-align:right;\">$money".mf("$rs_total_labortax")."</td></tr>";
}
}


                                                                        
}

                                                                                                                                               
$rs_find_refund_total = "SELECT SUM(cart_price) AS total_price_parts FROM cart WHERE cart_type = 'refund' AND ipofpc = '$ipofpc'";
$rs_find_result_refund_total = mysqli_query($rs_connect, $rs_find_refund_total);
while($rs_find_result_refund_total_q = mysqli_fetch_object($rs_find_result_refund_total)) {
$rs_total_refund = "$rs_find_result_refund_total_q->total_price_parts";


if ($rs_total_refund == "") {
$rs_total_refund = "0.00";
}

                                                                                                                                
echo "<tr><td style=\"text-align:right;\"><strong>".pcrtlang("Returned Items Total").":</strong></td><td style=\"text-align:right;\"><strong>$money".mf("$rs_total_refund")."</strong></td></tr>";


$rs_find_refund_totalref = "SELECT SUM(itemtax) AS total_price_partsref FROM cart WHERE cart_type = 'refund' AND ipofpc = '$ipofpc'";
$rs_find_result_refund_totalref = mysqli_query($rs_connect, $rs_find_refund_totalref);
while($rs_find_result_refund_totalref_q = mysqli_fetch_object($rs_find_result_refund_totalref)) {
$rs_total_refundtax = "$rs_find_result_refund_totalref_q->total_price_partsref";

if ($rs_total_refundtax > 0) {

reset($mastertaxtotals);
foreach($mastertaxtotals as $key => $val) {
$taxname = gettaxshortname($key);
$taxtotal = $mastertaxtotals[$key]['return'];
if($taxtotal != 0) {
echo "<tr><td style=\"text-align:right;\">$taxname:</td><td style=\"text-align:right;\">$money".mf("$taxtotal")."</td></tr>";
}
}

echo "<tr><td style=\"text-align:right;\">".pcrtlang("Total Refunded")." $t_tax:</td><td style=\"text-align:right;\">$money".mf("$rs_total_refundtax")."</td></tr>";
}

}

}
                                                                                                                                               
                                                                                                                                               
## #
$rs_find_refundlabor_total = "SELECT SUM(cart_price) AS total_price_refundlabor FROM cart WHERE cart_type = 'refundlabor' AND ipofpc = '$ipofpc'";
$rs_find_result_refundlabor_total = mysqli_query($rs_connect, $rs_find_refundlabor_total);
while($rs_find_result_refundlabor_total_q = mysqli_fetch_object($rs_find_result_refundlabor_total)) {
$rs_total_refundlabor = "$rs_find_result_refundlabor_total_q->total_price_refundlabor";

if ($rs_total_refundlabor == "") {
$rs_total_refundlabor = "0.00";
}
echo "<tr><td style=\"text-align:right;\"><strong>".pcrtlang("Refunded Labor Total").":</strong></td><td style=\"text-align:right;\"><strong>$money".mf("$rs_total_refundlabor")."</strong></td></tr>";


$rs_find_refundlabor_totalref = "SELECT SUM(itemtax) AS total_price_refundlabor FROM cart WHERE cart_type = 'refundlabor' AND ipofpc = '$ipofpc'";
$rs_find_result_refundlabor_totalref = mysqli_query($rs_connect, $rs_find_refundlabor_totalref);
while($rs_find_result_refundlabor_totalref_q = mysqli_fetch_object($rs_find_result_refundlabor_totalref)) {
$rs_total_refundlabortax = "$rs_find_result_refundlabor_totalref_q->total_price_refundlabor";
if ($rs_total_refundlabortax > 0) {

reset($mastertaxtotals);
foreach($mastertaxtotals as $key => $val) {
$taxname = gettaxshortname($key);
$taxtotal = $mastertaxtotals[$key]['refundlabor'];
if($taxtotal != 0) {
echo "<tr><td style=\"text-align:right;\">$taxname:</td><td style=\"text-align:right;\">$money".mf("$taxtotal")."</td></tr>";
}
}

echo "<tr><td style=\"text-align:right;\">".pcrtlang("Total Refunded Labor")." $t_tax:</td><td style=\"text-align:right;\">$money".mf("$rs_total_refundlabortax")."</td></tr>";
}

}

}


## #


$grand_total = mf((tnv($rs_total_partstax) + tnv($rs_total_parts) + tnv($rs_total_labortax) + tnv($rs_total_labor)) - (tnv($rs_total_refundtax) + tnv($rs_total_refund) + tnv($rs_total_refundlabor) + tnv($rs_total_refundlabortax)));

$paidtax = ((tnv($rs_total_partstax) + tnv($rs_total_labortax)) - (tnv($rs_total_refundtax) + tnv($rs_total_refundlabortax)));
$abstax = mf("$paidtax");



if ($grand_total >= 0){
echo "<tr><td style=\"text-align:right;\"><strong>".pcrtlang("Grand Total").":</strong></td><td style=\"text-align:right;\"><strong>$money".mf("$grand_total")."</strong></td></tr>";
} else {
$refund_total = abs($grand_total);
echo "<tr><td style=\"text-align:right;\"><strong>".pcrtlang("Refund").":</strong></td><td style=\"text-align:right;\"><strong>$money".mf("$refund_total")."</strong></td></tr>";
}



echo "</table><br>";

$cartcheck = cartcheck();

$purchasecount = mysqli_num_rows($rs_result);
$laborcount = mysqli_num_rows($rs_result_labor);
$returnscount = mysqli_num_rows($rs_result_returns);
$refundlaborcount = mysqli_num_rows($rs_result_refundlabor);

if (($purchasecount != 0) || ($laborcount != 0) || ($returnscount != 0) || ($refundlaborcount != 0)) {

$findpaytotal = "SELECT SUM(amount) AS totalpayments FROM currentpayments WHERE byuser = '$ipofpc'";
$findpaytotalq = @mysqli_query($rs_connect, $findpaytotal);
$findpaytotala = mysqli_fetch_object($findpaytotalq);
$totalpayments = mf($findpaytotala->totalpayments);
$balance = $grand_total - $totalpayments;


$findcurrentcustomer = "SELECT * FROM currentcustomer WHERE byuser = '$ipofpc'";
$findcurrentcustomerq = @mysqli_query($rs_connect, $findcurrentcustomer);

$existcust = mysqli_num_rows($findcurrentcustomerq);

if($existcust == 1) {
$findcurrentcustomera = mysqli_fetch_object($findcurrentcustomerq);
$cfirstname = "$findcurrentcustomera->cfirstname";
$ccompany = "$findcurrentcustomera->ccompany";
$caddress = "$findcurrentcustomera->caddress";
$caddress2 = "$findcurrentcustomera->caddress2";
$ccity = "$findcurrentcustomera->ccity";
$cstate = "$findcurrentcustomera->cstate";
$czip = "$findcurrentcustomera->czip";
$cphone = "$findcurrentcustomera->cphone";
$cemail = "$findcurrentcustomera->cemail";
$cwoid = "$findcurrentcustomera->woid";
$cinvoiceid = "$findcurrentcustomera->invoiceid";
$crinvoiceid = "$findcurrentcustomera->rinvoiceid";
$pcgroupid = "$findcurrentcustomera->pcgroupid";
} else {
$cfirstname = "";
$ccompany = "";
$caddress = "";
$caddress2 = "";
$ccity = "";
$cstate = "";
$czip = "";
$cphone = "";
$cemail = "";
$cwoid = "";
$cinvoiceid = "";
$crinvoiceid = "0";
$pcgroupid = "0";
}

$groupidarray = array();
if($pcgroupid != 0) {
$groupidarray[] = $pcgroupid;
}

#if($crinvoiceid != 0) {
#$groupidarray[] = $crinvoiceid;
#}


$cfirstname_ue = urlencode($cfirstname);
$ccompany_ue = urlencode($ccompany);
$caddress_ue = urlencode($caddress);
$caddress2_ue = urlencode($caddress2);
$ccity_ue = urlencode($ccity);
$cstate_ue = urlencode($cstate);
$czip_ue = urlencode($czip);
$cphone_ue = urlencode($cphone);
$cemail_ue = urlencode($cemail);


echo "<table class=standard>";
echo "<tr><th>".pcrtlang("Current Customer").":</th></tr>";
echo "<tr><td>";

echo pcrtlang("Customer Name").":<form action=cart.php?func=savecurrentcustomer method=post data-ajax=\"false\"><input type=text name=cfirstname value=\"$cfirstname\">";
echo pcrtlang("Company").":<input type=text name=ccompany value=\"$ccompany\">";
echo "$pcrt_address1:<input type=text name=caddress value=\"$caddress\">";
echo "$pcrt_address2:<input type=text name=caddress2 value=\"$caddress2\">";
echo "$pcrt_city<input type=text name=ccity value=\"$ccity\">";
echo "$pcrt_state<input type=text name=cstate value=\"$cstate\">";
echo "$pcrt_zip<input type=text name=czip value=\"$czip\">";
echo pcrtlang("Customer Phone").":<input type=text name=cphone value=\"$cphone\">";
echo pcrtlang("Customer Email").":<input type=text name=cemail value=\"$cemail\">";

if ($cinvoiceid != "") {

$cinvoicelist = explode_list($cinvoiceid);
foreach($cinvoicelist as $key => $cinvoicelistids) {
$iorq = invoiceorquote($cinvoicelistids);
if ($iorq == "quote") {
$ilabel = pcrtlang("Quote");
} else {
$ilabel = pcrtlang("Invoice");
}
echo "$ilabel ".pcrtlang("ID").":$cinvoicelistids <br>";

$rs_find_invoice_ifrecur = "SELECT rinvoice_id FROM invoices WHERE invoice_id = '$cinvoicelistids'";
$rs_result_finv = mysqli_query($rs_connect, $rs_find_invoice_ifrecur);
while($rs_result_qfr = mysqli_fetch_object($rs_result_finv)) {
$rinvoicef = "$rs_result_qfr->rinvoice_id";
if($rinvoicef != 0) {
$rs_find_invoice_recur = "SELECT pcgroupid FROM rinvoices WHERE rinvoice_id = '$rinvoicef'";
$rs_result_frinv = mysqli_query($rs_connect, $rs_find_invoice_recur);
$rs_result_qfr = mysqli_fetch_object($rs_result_frinv);
$fpcgroupid = "$rs_result_qfr->pcgroupid";
if($fpcgroupid != 0) {
$groupidarray[] = "$fpcgroupid";
}
}
}



}
}

if ($cwoid != "") {
echo pcrtlang("Work Order ID").": ";

$cwoidlist = explode_list($cwoid);
foreach($cwoidlist as $key => $cwoidlistids) {
echo "#$cwoidlistids ";

$rs_find_pc_ifgroup = "SELECT pcid FROM pc_wo WHERE woid = '$cwoidlistids'";
$rs_result_fpc = mysqli_query($rs_connect, $rs_find_pc_ifgroup);
while($rs_result_qfpc = mysqli_fetch_object($rs_result_fpc)) {
$pcidf = "$rs_result_qfpc->pcid";
$rs_find_grp = "SELECT pcgroupid FROM pc_owner WHERE pcid = '$pcidf'";
$rs_result_fpcg = mysqli_query($rs_connect, $rs_find_grp);
$rs_result_qfpcg = mysqli_fetch_object($rs_result_fpcg);
$fpcgroupid = "$rs_result_qfpcg->pcgroupid";
if($fpcgroupid != 0) {
$groupidarray[] = "$fpcgroupid";
}
}



}
}


echo "<input type=hidden name=cinvoiceid value=\"$cinvoiceid\"><input type=hidden name=crinvoiceid value=\"$crinvoiceid\"><input type=hidden name=pcgroupid value=\"$pcgroupid\"><input type=hidden name=cwoid value=\"$cwoid\"><button type=button class=button onclick=\"this.disabled=true; this.form.submit();\"><i class=\"fa fa-save\"></i> ".pcrtlang("Save")."</button></form>";
echo "<form action=cart.php?func=clearcurrentcustomer method=post  data-ajax=\"false\"><button type=submit><i class=\"fa fa-times\"></i> ".pcrtlang("Clear")."</button></form>";

echo "</td></tr></table>";



echo "<form action=cart.php?func=pickcustomer method=post  data-ajax=\"false\">";
echo "<input type=text name=searchtext>";
echo "<button type=submit class=button><i class=\"fa fa-search\"></i> ".pcrtlang("Search &amp; Pick Customer")."</button></form>";





echo "<div data-role=\"collapsible\" data-theme=\"b\">";
echo "<h3>".pcrtlang("Add Payment")."</h3>";

$cwoids = explode_list($cwoid);


if(isset($cinvoicelist)) {
reset($cinvoicelist);
} else {
$cinvoicelist = array();
}


if((count($cinvoicelist) != 0) || (count($cwoids) != 0)) {

if(count($cinvoicelist) != 0) {
$sqllist = "";

$sqllist .= " AND (invoiceid = '$cinvoicelist[0]'";
unset($cinvoicelist[0]);
foreach($cinvoicelist as $key => $cinvoiceids) {
$sqllist .= " OR invoiceid = '$cinvoiceids'";
}
$sqllist .= ")";

} elseif (count($cwoids) != 0) {
$sqllist = "";
$sqllist .= " AND (woid = '$cwoids[0]'";
unset($cwoids[0]);

foreach($cwoids as $key => $cwoidids) {
$sqllist .= " OR woid = '$cwoidids'";
}
$sqllist .= ")";
} else {
$sqllist = "";
}


$finddeposits = "SELECT * FROM deposits WHERE dstatus != 'applied'";

if(isset($sqllist)) {
$finddeposits .= " $sqllist";
}



$finddepositsq = @mysqli_query($rs_connect, $finddeposits);
while ($finddepositsa = mysqli_fetch_object($finddepositsq)) {
$depdepositid = "$finddepositsa->depositid";
$depamount = "$finddepositsa->amount";
$depfirstname = "$finddepositsa->pfirstname";
$depplugin = "$finddepositsa->paymentplugin";
$depwoid = "$finddepositsa->woid";
$depinvoiceid = "$finddepositsa->invoiceid";


$findpaymentsd = "SELECT * FROM currentpayments WHERE byuser = '$ipofpc' AND depositid = $depdepositid";
$findpaymentsqd = @mysqli_query($rs_connect, $findpaymentsd);
$depexist = mysqli_num_rows($findpaymentsqd);


if ($depexist == 0) {
echo pcrtlang("Deposit")."# $depdepositid<br>$depplugin: $money".mf("$depamount")."<br>$depfirstname<br>";

if($depinvoiceid != 0) {
echo pcrtlang("Invoice").": <span class=boldme>$depinvoiceid</span>";
} elseif($depwoid != 0) {
echo pcrtlang("Work Order").": <span class=boldme>$depwoid</span>";
} else {
}


if($balance > 0) {
if($depamount > $balance) {
echo "<form action=deposits.php?func=adddep method=post data-ajax=\"false\"><input type=hidden name=depositid value=\"$depdepositid\">";
echo "<input type=hidden name=balance value=\"$balance\">";
$amountextra = $depamount - $balance;
echo "<input type=hidden name=amountextra value=\"$amountextra\">";
echo "<button onclick=\"this.disabled=true; this.form.submit();\">".pcrtlang("Split &amp; Add Deposit")."
<i class=\"fa fa-chevron-right\"></i></button></form><br>";
} else {
echo "<form action=deposits.php?func=adddep method=post data-ajax=\"false\"><input type=hidden name=depositid value=\"$depdepositid\">";
echo "<button onclick=\"this.disabled=true; this.form.submit();\">".pcrtlang("Add Deposit")."
<i class=\"fa fa-chevron-right\"></i></button></form><br>";
}
} else {
echo "<br><br><span class=\"sizeme10 italme\">".pcrtlang("Please remove a payment in order to apply this deposit.")."</span>";
}


}
}
}




if ($balance > 0) {
reset($paymentplugins);
foreach($paymentplugins as $key => $plugin) {

echo "<form action=$plugin.php?func=add method=post  data-ajax=\"false\"><input type=hidden name=currenttotal value=\"".mf("$balance")."\">";

echo "<input type=hidden name=cfirstname value=\"$cfirstname\">";
echo "<input type=hidden name=ccompany value=\"$ccompany\">";
echo "<input type=hidden name=caddress value=\"$caddress\">";
echo "<input type=hidden name=caddress2 value=\"$caddress2\">";
echo "<input type=hidden name=ccity value=\"$ccity\">";
echo "<input type=hidden name=cstate value=\"$cstate\">";
echo "<input type=hidden name=czip value=\"$czip\">";
echo "<input type=hidden name=cphone value=\"$cphone\">";
echo "<input type=hidden name=cemail value=\"$cemail\">";

if($balance == "$grand_total") {
echo "<input type=hidden name=taxamt value=\"$paidtax\">";
}


echo "<input type=submit class=button value=\"".pcrtlang("$plugin")."\"></form>";


}

#saved payments

$groupidarray2 = array_unique($groupidarray);

reset($groupidarray2);
foreach($groupidarray2 as $key => $arrpcgroupid) {

$findcardcustomers = "SELECT * FROM savedcardscustomers WHERE groupid = '$arrpcgroupid'";
$findcardcustomersq = @mysqli_query($rs_connect, $findcardcustomers);
while ($findcardcustomersa = mysqli_fetch_object($findcardcustomersq)) {
$sccid = "$findcardcustomersa->sccid";
$sccplugin = "$findcardcustomersa->sccplugin";

$findcards = "SELECT * FROM savedcards WHERE sccid = '$sccid' AND savedcarddefault = '1'";
$findcardsq = @mysqli_query($rs_connect, $findcards);
$findcardsa = mysqli_fetch_object($findcardsq);
$savedcardname = "$findcardsa->savedcardname";
$savedcardexpmonth = "$findcardsa->savedcardexpmonth";
$savedcardexpyear = "$findcardsa->savedcardexpyear";
$savedcardfour = "$findcardsa->savedcardfour";
echo "<form action=$sccplugin"."_stored.php?func=charge method=post><input type=hidden name=currenttotal value=\"".mf("$balance")."\">";
echo "<input type=hidden name=sccid value=\"$sccid\">";
echo "<button type=submit><b>".pcrtlang("Saved Card")."</b><br>$sccplugin<br>$savedcardname<br>
<i class=\"fa fa-credit-card fa-lg\"></i> XXXX-$savedcardfour<br>".pcrtlang("exp.")." $savedcardexpmonth-$savedcardexpyear</button></form>";

}
}
#end saved payments



}

echo "</div>";


echo "<table class=standard><tr><th colspan=2>".pcrtlang("Payments - Checkout")."</th></tr>";


$findpayments = "SELECT * FROM currentpayments WHERE byuser = '$ipofpc'";
$findpaymentsq = @mysqli_query($rs_connect, $findpayments);
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
$isdeposit = "$findpaymentsa->isdeposit";
$depositid = "$findpaymentsa->depositid";

$custompaymentinfo = unserialize("$custompaymentinfo2");

$ccnumber = mb_substr("$ccnumber2", -4, 4);

echo "<tr><td>";

if ($paymenttype == "cash") {
echo "<strong>".pcrtlang("Cash")."</strong><br>$pfirstname - $money".mf("$paymentamount")."</td><td>";
if ($isdeposit == 1) {
echo "<form action=cart.php?func=removedeposit method=post  data-ajax=\"false\"><input type=hidden name=depositid value=\"$depositid\">";
echo "<button type=submit class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Remove Deposit")."</button></form>";
} else {
echo "<form action=$paymentplugin.php?func=void method=post  data-ajax=\"false\"><input type=hidden name=payid value=\"$paymentid\">";
echo "<button type=submit class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Remove")."</button></form>";
}

} elseif ($paymenttype == "check") {
echo "<strong>".pcrtlang("Check")." #$checknumber:</strong><br>$pfirstname - ";
echo "$money".mf("$paymentamount")."</td><td>";
if ($isdeposit == 1) {
echo "<form action=cart.php?func=removedeposit method=post  data-ajax=\"false\"><input type=hidden name=depositid value=\"$depositid\">";
echo "<button type=submit class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"><i class=\"fa fa-trash fa-lg\"></i>  ".pcrtlang("Remove Deposit")."</button></form>";
} else {
echo "<form action=$paymentplugin.php?func=void method=post  data-ajax=\"false\"><input type=hidden name=payid value=\"$paymentid\">";
echo "<button type=submit class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Remove")."</button></form>";
}

} elseif ($paymenttype == "credit") {
echo pcrtlang("Credit Card")." <br>XXXX-$ccnumber<br>".pcrtlang("Exp").": $ccexpmonth/$ccexpyear<br>";
echo "$pfirstname - $money".mf("$paymentamount")."<br>$paymentplugin $cc_cardtype</td><td>";
if ($isdeposit == 1) {
echo "<form action=cart.php?func=removedeposit method=post  data-ajax=\"false\"><input type=hidden name=depositid value=\"$depositid\">";
echo "<button type=submit class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Remove Deposit")."></button></form>";
} else {
echo "<form action=$paymentplugin.php?func=void method=post  data-ajax=\"false\"><input type=hidden name=payid value=\"$paymentid\">";
echo "<input type=hidden name=cc_transid value=\"$cc_transid\">";
echo "<button type=submit class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"><i class=\"fa fa-ban fa-lg\"></i> ".pcrtlang("Void")."</button></form>";
}

} elseif ($paymenttype == "custompayment") {
echo "$paymentplugin<br>$pfirstname - $money".mf("$paymentamount")."<br>";

reset($custompaymentinfo);
foreach($custompaymentinfo as $key => $val) {
echo "$key: $val<br>";
}

echo "</td><td>";


if ($isdeposit == 1) {
echo "<form action=cart.php?func=removedeposit method=post  data-ajax=\"false\"><input type=hidden name=depositid value=\"$depositid\">";
echo "<button type=submit class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Remove Deposit")."</button></form>";
} else {
echo "<form action=$paymentplugin.php?func=void method=post  data-ajax=\"false\"><input type=hidden name=payid value=\"$paymentid\">";
echo "<button type=submit class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Remove")."</button></form>";
}

} else {
echo "Error! Undefined Payment Type in database";
}

echo "</td></tr>";

}

echo "</table>";

if ($grand_total == 0) {
if ($totalpayments == 0) {


echo "<form action=checkout.php?func=checkout method=post  data-ajax=\"false\">";
echo "<input type=hidden name=cfirstname value=\"$cfirstname\">";
echo "<input type=hidden name=ccompany value=\"$ccompany\">";
echo "<input type=hidden name=caddress value=\"$caddress\">";
echo "<input type=hidden name=caddress2 value=\"$caddress2\">";
echo "<input type=hidden name=ccity value=\"$ccity\">";
echo "<input type=hidden name=cstate value=\"$cstate\">";
echo "<input type=hidden name=czip value=\"$czip\">";
echo "<input type=hidden name=cphone value=\"$cphone\">";
echo "<input type=hidden name=cemail value=\"$cemail\">";
echo "<input type=hidden name=cartcheck value=\"$cartcheck\">";
echo "<input type=hidden name=grandtotal value=\"$grand_total\">";
echo "<input type=hidden name=grandtax value=\"$abstax\">";
echo "<input type=hidden name=woid value=\"$cwoid\">";
echo "<input type=hidden name=invoice_id value=\"$cinvoiceid\">";
echo "<input type=hidden name=checkoutaction value=\"exchange\">";
if (($rs_total_refund != 0) && ($rs_total_refundlabor)) {
echo "<input type=submit value=\"".pcrtlang("Exchange")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Exchanging")."...'; this.form.submit();\"  data-theme=\"b\">";
} else {

if($cwoid != 0) {
echo "<br>".pcrtlang("Set Work Order Status on Checkout to").":";

$statuscolors = getstatusselectorcolors();
$boxtitles = getboxtitles();

$coptions = "";
$rs_qc = "SELECT * FROM boxstyles WHERE statusid > 99";
$rs_result1 = mysqli_query($rs_connect, $rs_qc);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$statusid = "$rs_result_q1->statusid";
$selectorcolor2 = "$rs_result_q1->selectorcolor";
$boxtitle2 = "$rs_result_q1->boxtitle";
$coptions .= "<option value=\"$statusid\" class=statusdrop style=\"background:#$selectorcolor2\">$boxtitle2</option>";
}

echo "<select name=statnum>
<option value=5 class=statusdrop style=\"background:#$statuscolors[5]\">$boxtitles[5]</option>
<option value=1 class=statusdrop style=\"background:#$statuscolors[1]\">$boxtitles[1]</option>
<option value=2 class=statusdrop style=\"background:#$statuscolors[2]\">$boxtitles[2]</option>
<option value=8 class=statusdrop style=\"background:#$statuscolors[8]\">$boxtitles[8]</option><option value=9 class=statusdrop style=\"background:#$statuscolors[9]\">$boxtitles[9]</option>
<option value=3 class=statusdrop style=\"background:#$statuscolors[3]\">$boxtitles[3]</option><option value=4 class=statusdrop style=\"background:#$statuscolors[4]\">$boxtitles[4]</option>
<option value=6 class=statusdrop style=\"background:#$statuscolors[6]\">$boxtitles[6]</option><option value=7 class=statusdrop style=\"background:#$statuscolors[7]\">$boxtitles[7]</option>";
echo "$coptions";

echo "</select><br>";
}



echo "<input type=submit value=\"".pcrtlang("No Charge")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Wait")."...'; this.form.submit();\">";
}
echo "</form>";
}
} elseif ($grand_total > 0) {
if ($balance == 0) {

echo "<form action=checkout.php?func=checkout method=post  data-ajax=\"false\">";

if($cwoid != "") {
echo "<br>".pcrtlang("Set Work Order Status on Checkout to").":";

$statuscolors = getstatusselectorcolors();
$boxtitles = getboxtitles();

$coptions = "";
$rs_qc = "SELECT * FROM boxstyles WHERE statusid > 99";
$rs_result1 = mysqli_query($rs_connect, $rs_qc);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$statusid = "$rs_result_q1->statusid";
$selectorcolor2 = "$rs_result_q1->selectorcolor";
$boxtitle2 = "$rs_result_q1->boxtitle";
$coptions .= "<option value=\"$statusid\" class=statusdrop style=\"background:#$selectorcolor2\">$boxtitle2</option>";
}

echo "<select name=statnum>
<option value=5 class=statusdrop style=\"background:#$statuscolors[5]\">$boxtitles[5]</option>
<option value=1 class=statusdrop style=\"background:#$statuscolors[1]\">$boxtitles[1]</option>
<option value=2 class=statusdrop style=\"background:#$statuscolors[2]\">$boxtitles[2]</option>
<option value=8 class=statusdrop style=\"background:#$statuscolors[8]\">$boxtitles[8]</option><option value=9 class=statusdrop style=\"background:#$statuscolors[9]\">$boxtitles[9]</option>
<option value=3 class=statusdrop style=\"background:#$statuscolors[3]\">$boxtitles[3]</option><option value=4 class=statusdrop style=\"background:#$statuscolors[4]\">$boxtitles[4]</option>
<option value=6 class=statusdrop style=\"background:#$statuscolors[6]\">$boxtitles[6]</option><option value=7 class=statusdrop style=\"background:#$statuscolors[7]\">$boxtitles[7]</option>";

echo "$coptions";

echo "</select>";



}




echo "<input type=hidden name=cfirstname value=\"$cfirstname\">";
echo "<input type=hidden name=ccompany value=\"$ccompany\">";
echo "<input type=hidden name=caddress value=\"$caddress\">";
echo "<input type=hidden name=caddress2 value=\"$caddress2\">";
echo "<input type=hidden name=ccity value=\"$ccity\">";
echo "<input type=hidden name=cstate value=\"$cstate\">";
echo "<input type=hidden name=czip value=\"$czip\">";
echo "<input type=hidden name=cphone value=\"$cphone\">";
echo "<input type=hidden name=cemail value=\"$cemail\">";
echo "<input type=hidden name=cartcheck value=\"$cartcheck\">";
echo "<input type=hidden name=grandtotal value=\"$grand_total\">";
echo "<input type=hidden name=grandtax value=\"$abstax\">";
echo "<input type=hidden name=woid value=\"$cwoid\">";
echo "<input type=hidden name=invoice_id value=\"$cinvoiceid\">";
echo "<input type=hidden name=checkoutaction value=\"purchase\">";
echo "<button type=submit  data-theme=\"b\"><i class=\"fa fa-check-circle fa-lg\"></i> ".pcrtlang("Checkout")."</button></form></td></tr>";


}
} else {
if ($totalpayments == 0) {
echo "<form action=checkout.php?func=checkout method=post  data-ajax=\"false\">";
echo "<input type=hidden name=cfirstname value=\"$cfirstname\">";
echo "<input type=hidden name=ccompany value=\"$ccompany\">";
echo "<input type=hidden name=caddress value=\"$caddress\">";
echo "<input type=hidden name=caddress2 value=\"$caddress2\">";
echo "<input type=hidden name=ccity value=\"$ccity\">";
echo "<input type=hidden name=cstate value=\"$cstate\">";
echo "<input type=hidden name=czip value=\"$czip\">";
echo "<input type=hidden name=cphone value=\"$cphone\">";
echo "<input type=hidden name=cemail value=\"$cemail\">";
echo "<input type=hidden name=cartcheck value=\"$cartcheck\">";
echo "<input type=hidden name=grandtotal value=\"$grand_total\">";
echo "<input type=hidden name=grandtax value=\"$abstax\">";
echo "<input type=hidden name=woid value=\"$cwoid\">";
echo "<input type=hidden name=invoice_id value=\"$cinvoiceid\">";
echo "<input type=hidden name=checkoutaction value=\"refund\">";
echo "<input type=submit value=\"".pcrtlang("Refund")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Refunding")."...'; this.form.submit();\"  data-theme=\"b\"></form>";
}
}

if ($balance > 0) {
echo "<center><h2>".pcrtlang("Balance").":$money".mf("$balance")."</h2></center>";
}


if($cinvoiceid != "") {
$totalinvoicesincart = count(explode_list($cinvoiceid));
if($totalinvoicesincart == "1") {
$findinvtot = "SELECT SUM(cart_price + itemtax) AS invtotal FROM invoice_items WHERE invoice_id = '$cinvoiceid'";
$findinvtotq = @mysqli_query($rs_connect, $findinvtot);
$findinvtota = mysqli_fetch_object($findinvtotq);
$paymentamount = mf("$findinvtota->invtotal");
if ($paymentamount != $grand_total) {
echo pcrtlang("Warning: This cart contains items not on or saved in")." $ilabel #$cinvoiceid.";
}
}
}

if ($activestorecount > "1") {
$storeinfoarray = getstoreinfo($defaultuserstore);
echo "<br><center>".pcrtlang("Current Store").":$storeinfoarray[storesname]</center>";
}

if (($purchasecount != "0") || ($laborcount != "0")) {
if ((mysqli_num_rows($rs_result_returns) == "0") && (mysqli_num_rows($rs_result_refundlabor) == "0")) {
echo "<br><table class=standard><tr><th>".pcrtlang("Other Cart Actions")."</th></tr><tr><td>";

echo "<button type=button onClick=\"parent.location='invoice.php?func=createinvoice&cfirstname=$cfirstname_ue&ccompany=$ccompany_ue&caddress1=$caddress_ue&caddress2=$caddress2_ue&ccity=$ccity_ue&cstate=$cstate_ue&czip=$czip_ue&cphone=$cphone_ue&cemail=$cemail_ue&pcgroupid=$pcgroupid&woid=$cwoid'\"><img src=../store/images/invoice.png align=absmiddle> ".pcrtlang("Create New Invoice/Quote")."</button>";

if($cinvoiceid != "") {
$totalinvoicesincart = count(explode_list($cinvoiceid));
if($totalinvoicesincart == "1") {
$iorq = invoiceorquote($cinvoiceid);
if ($iorq == "quote") {
$ilabel = pcrtlang("Quote");
} else {
$ilabel = pcrtlang("Invoice");
}
echo "<button type=button onClick=\"parent.location='invoice.php?func=createinvoice&cfirstname=$cfirstname_ue&ccompany=$ccompany_ue&caddress1=$caddress_ue&caddress2=$caddress2_ue&ccity=$ccity_ue&cstate=$cstate_ue&czip=$czip_ue&cphone=$cphone_ue&cemail=$cemail_ue&cinvoiceid=$cinvoiceid&woid=$cwoid&pcgroupid=$pcgroupid'\"><img src=../store/images/invoice.png align=absmiddle border=0> ".pcrtlang("Save")." $ilabel #$cinvoiceid</button>";
}
}

if ($crinvoiceid == 0) {
echo "<button type=button onClick=\"parent.location='rinvoice.php?func=createrinvoice&cfirstname=$cfirstname_ue&ccompany=$ccompany_ue&caddress1=$caddress_ue&caddress2=$caddress2_ue&ccity=$ccity_ue&cstate=$cstate_ue&czip=$czip_ue&cphone=$cphone_ue&cemail=$cemail_ue&pcgroupid=$pcgroupid'\"><img src=../store/images/rinvoice.png align=absmiddle border=0> ".pcrtlang("Create New Recurring Invoice")."</button>";
}



if ($crinvoiceid != 0) {
echo "<button type=button onClick=\"parent.location='rinvoice.php?func=createrinvoice&cfirstname=$cfirstname_ue&ccompany=$ccompany_ue&caddress1=$caddress_ue&caddress2=$caddress2_ue&ccity=$ccity_ue&cstate=$cstate_ue&czip=$czip_ue&cphone=$cphone_ue&cemail=$cemail_ue&crinvoiceid=$crinvoiceid&pcgroupid=$pcgroupid'\"><img src=../store/images/rinvoice.png align=absmiddle border=0> ".pcrtlang("Save Recurring Invoice")." #$crinvoiceid</button>";
}


echo "<button type=button onClick=\"parent.location='cart.php?func=show_quote'\"><img src=../store/images/print.png align=absmiddle border=0 height=30> ".pcrtlang("Print Quick Quote/Estimate")."</button>";

#if ($cfirstname_ue != "") {
#echo " | <img src=../repair/images/labelprinter.png border=0 align=absmiddle width=24>";
#$backurl = urlencode("../store/cart.php");
#echo " <a href=\"../repair/addresslabel.php?pcname=$cfirstname_ue&pccompany=$ccompany_ue&pcaddress1=$caddress_ue&pcaddress2=$caddress2_ue&pccity=$ccity_ue&pcstate=$cstate_ue&pczip=$czip_ue&dymojsapi=html&backurl=$backurl\">".pcrtlang("Print Address Label")."</a>";
#}
}
}
}

echo "<br><br>";
if (($purchasecount != "0") || ($laborcount != "0")) { 
if (($returncount == '0') && ($refundlaborcount == "0")) {

echo "<form action=cart.php?func=savecart method=post  data-ajax=\"false\">";
echo "<input type=text name=cartname class=textbox value=\"".pcrtlang("Enter Cart Name")."\"onfocus=\"if(this.value=='".pcrtlang("Enter Cart Name")."')this.value=''\">
<input type=hidden name=cartcheck value=\"$cartcheck\">
<button class=button type=button onclick=\"this.disabled=true; this.form.submit();\"><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save Cart")."</button></form>";


echo "<br><form action=cart.php?func=savecart&iskit=1 method=post  data-ajax=\"false\">";
echo "<input type=text name=cartname class=textbox value=\"".pcrtlang("Enter Kit Name")."\"onfocus=\"if(this.value=='".pcrtlang("Enter Kit Name")."')this.value=''\">
<input type=hidden name=cartcheck value=\"$cartcheck\">
<button class=button type=button onclick=\"this.disabled=true; this.form.submit();\"><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save Cart as Kit")."</button></form>";


echo "<br><form method=post onchange='this.form.submit()' data-ajax=\"false\" action=cart.php?func=copycurrenttorepaircart><select name=pcwo>";

echo "<option value=0>".pcrtlang("Copy Cart to Repair Cart")."</option>";

$rs_findpcs = "SELECT * FROM pc_wo WHERE pcstatus != '5' AND  pcstatus != '7'";
$rs_findpcssr = mysqli_query($rs_connect, $rs_findpcs);
while($rs_result_qsr = mysqli_fetch_object($rs_findpcssr)) {
$pcidsr = "$rs_result_qsr->pcid";
$woidsr = "$rs_result_qsr->woid";
$dropdate = "$rs_result_qsr->dropdate";
$rs_findowner = "SELECT * FROM pc_owner WHERE pcid = '$pcidsr'";
$rs_result2sr = mysqli_query($rs_connect, $rs_findowner);
while($rs_result_q2sr = mysqli_fetch_object($rs_result2sr)) {
$pcname = "$rs_result_q2sr->pcname";
$pccompany = "$rs_result_q2sr->pccompany";
$pcmake = "$rs_result_q2sr->pcmake";

echo "<option value=$woidsr>#$pcidsr $pcname $pccompany</option>";
}
}


echo "</select></form>";

echo "<br><br>";
}
}


echo "</td></tr></table>";

require_once("footer.php");
                                                                                                    
}


function add_item() {
require_once("validate.php");
$stockid = $_REQUEST['stockid'];

require("deps.php");
require("common.php");

if (array_key_exists('qty', $_REQUEST)) {
$qty = $_REQUEST['qty'];
if (!ii($qty)) {
die(pcrtlang("Please enter a whole number"." $qty"));
}
} else {
$qty = 1;
}


if ($stockid == "") {
die("Error - no stock id entered");
}


$stockids = explode(" ", $stockid);

$usertaxid = getusertaxid();
$salestaxrate = getsalestaxrate($usertaxid);

reset($stockids);
foreach($stockids as $key => $stocktoadd) {

$stockidsize = mb_strlen($stocktoadd);




if ($stockidsize < 11) {
$rs_insert_stock = "SELECT * FROM stock WHERE stock_id = '$stocktoadd'";
} else {
$rs_insert_stock = "SELECT * FROM stock WHERE stock_upc = '$stocktoadd'";
}

$rs_find_stock_price = @mysqli_query($rs_connect, $rs_insert_stock);

if(mysqli_num_rows($rs_find_stock_price) == "0") {
die(pcrtlang("Sorry, that stock ID or UPC code does not exist"));
}

while($rs_find_result_q = mysqli_fetch_object($rs_find_stock_price)) {
$rs_price = "$rs_find_result_q->stock_price";
$rs_stockid = "$rs_find_result_q->stock_id";

$rs_find_serial = "SELECT * FROM inventory WHERE stock_id = '$rs_stockid' AND itemserial != ''";
$rs_find_serial_q = @mysqli_query($rs_connect, $rs_find_serial);
if(mysqli_num_rows($rs_find_serial_q) > 0) {
break 2;
}

$ourprice = getourprice($rs_stockid) * $qty;
$total_price = $rs_price * $qty;
$itemtax = $total_price * $salestaxrate;

$addtime = time();
$rs_insert_cart = "INSERT INTO cart (cart_price,cart_type,cart_stock_id,ipofpc,taxex,itemtax,ourprice,addtime,quantity,unit_price) VALUES  ('$rs_price','purchase','$rs_stockid','$ipofpc','$usertaxid','$itemtax','$ourprice','$addtime','$qty','$rs_price')";
@mysqli_query($rs_connect, $rs_insert_cart);
}

}                                                                                                                                               

if(mysqli_num_rows($rs_find_serial_q) > 0) {                                                                                                                                               
header("Location: cart.php?func=addbyserial&stockid=$rs_stockid");
} else {
header("Location: cart.php");
}

}


function addbyserial() {
require_once("validate.php");

require("deps.php");
require("common.php");

require_once("dheader.php");

dheader(pcrtlang("Enter Serial/Code?"));


$stockid = $_REQUEST['stockid'];




$availser = available_serials($stockid);

echo "<form action=cart.php?func=addbyserial2 method=post  data-ajax=\"false\">";

if(count($availser) != 0) {
echo pcrtlang("Pick Serial").":";
echo "<select name=itemserialchooser onchange='document.getElementById(\"itemserial\").value=this.options[this.selectedIndex].value '>";
echo "<option value=\"\">".pcrtlang("(optional) choose a serial/code")."</option>";
foreach($availser as $key => $val) {
if($val != "") {

$rs_find_store = "SELECT * FROM inventory WHERE itemserial LIKE '%$val%' AND stock_id = '$stockid' LIMIT 1";
$rs_find_store_q = @mysqli_query($rs_connect, $rs_find_store);
$rs_find_result_q = mysqli_fetch_object($rs_find_store_q);
$rs_storeid = "$rs_find_result_q->storeid";
$storeinfo = getstoreinfo($rs_storeid);

echo "<option value=\"$val\">$storeinfo[storesname] &bull; $val</option>";
}
}
echo "</select>";
}

echo pcrtlang("Serial/Code (optional)").":";
echo "<input type=text name=itemserial id=itemserial><input type=hidden name=stockid value=\"$stockid\">";

echo "<input type=submit value=\"".pcrtlang("Add to Cart")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Adding to Cart")."...'; this.form.submit();\" data-theme=\"b\"></form>";



dfooter();
require_once("dfooter.php");

}


function add_noninv() {
require_once("validate.php");

require("deps.php");
require("common.php");

$itemdesc = pv($_REQUEST['itemdesc']);
$stock_pdesc = pv($_REQUEST['stock_pdesc']);
$unit_price = $_REQUEST['itemprice'];
$ourprice2 = $_REQUEST['ourprice'];
$itemserial = pv(trim($_REQUEST['itemserial']));

$usertaxid = getusertaxid();
$salestaxrate = getsalestaxrate($usertaxid);

if (array_key_exists('qty', $_REQUEST)) {
$qty2 = $_REQUEST['qty'];
if(($qty2 > 1) && ($itemserial != "")) {
$qty = 1;
} else {
$qty = $qty2;
}
} else {
$qty = 1;
}


$itemprice = $unit_price * $qty;
$itemtax = $itemprice * $salestaxrate;
$ourprice = $ourprice2 * $qty;

$addtime = time();
$rs_insert_cart = "INSERT INTO cart (cart_price,cart_type,cart_stock_id,labor_desc,ipofpc,taxex,itemtax,ourprice,itemserial,addtime,quantity,unit_price,printdesc) VALUES  ('$itemprice','purchase','0','$itemdesc','$ipofpc','$usertaxid','$itemtax','$ourprice','$itemserial','$addtime','$qty','$unit_price','$stock_pdesc')";
@mysqli_query($rs_connect, $rs_insert_cart);

header("Location: cart.php");
}


function addbyserial2() {
require_once("validate.php");
$stockid = $_REQUEST['stockid'];
$itemserial = $_REQUEST['itemserial'];

require("deps.php");
require("common.php");

if ($stockid == "") {
die("Error - stock id missing");
}

$usertaxid = getusertaxid();
$salestaxrate = getsalestaxrate($usertaxid);




$rs_insert_stock = "SELECT * FROM stock WHERE stock_id = '$stockid'";

$rs_find_stock_price = @mysqli_query($rs_connect, $rs_insert_stock);

while($rs_find_result_q = mysqli_fetch_object($rs_find_stock_price)) {
$rs_price = "$rs_find_result_q->stock_price";
$rs_stockid = "$rs_find_result_q->stock_id";
$rs_stockpdesc = "$rs_find_result_q->stock_pdesc";

$ourprice = getourprice($rs_stockid);

$itemtax = $rs_price * $salestaxrate;
$addtime = time();
$rs_insert_cart = "INSERT INTO cart (cart_price,cart_type,cart_stock_id,ipofpc,taxex,itemtax,ourprice,itemserial,addtime,quantity,unit_price,printdesc) VALUES  ('$rs_price','purchase','$rs_stockid','$ipofpc','$usertaxid','$itemtax','$ourprice','$itemserial','$addtime','1','$rs_price','$rs_stockpdesc')";
@mysqli_query($rs_connect, $rs_insert_cart);
}

header("Location: cart.php");

}



function add_labor() {

require("deps.php");

require_once("common.php");
require("dheader.php");




dheader(pcrtlang("Add Labor"));

echo "<form action=cart.php?func=add_labor2 method=post  data-ajax=\"false\">";
echo pcrtlang("Labor Quantity")."<input type=number value=1 name=qty class=textbox min=\".01\" step=\".01\">";
echo pcrtlang("Labor Charge");
echo "<input type=text name=laborprice id=laborprice>";

$usertaxid = getusertaxid();
$servicetaxrateremain = (1 + getservicetaxrate($usertaxid));
if($servicetaxrateremain != 1) {
echo "<button class=button type=button title=\"".pcrtlang("Pre-Tax Calculator")."\" onclick='document.getElementById(\"laborprice\").value=(document.getElementById(\"laborprice\").value / $servicetaxrateremain).toFixed(5)'>
<i class=\"fa fa-calculator\"></i> ".pcrtlang("Calculate Pre-Tax")."</button>";
}

echo pcrtlang("Labor Description").":<input type=text name=labordesc>";
echo "".pcrtlang("Printed Labor Description")." (".pcrtlang("optional")."):<br><textarea class=textbox cols=60 name=laborpdesc></textarea><br><br>";
echo "<input type=submit value=\"".pcrtlang("Add to Cart")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Adding to Cart")."...'; this.form.submit();\"></form>";

echo "<br><h3>".pcrtlang("Quick Add Labor").":</h3>";

$rs_quicklabor = "SELECT * FROM quicklabor ORDER BY theorder DESC";
$rs_result_ql  = mysqli_query($rs_connect, $rs_quicklabor);
while($rs_result_qld = mysqli_fetch_object($rs_result_ql)) {
$labordesc = "$rs_result_qld->labordesc";
$laborprice = "$rs_result_qld->laborprice";
$printdesc = "$rs_result_qld->printdesc";

$primero = mb_substr("$labordesc", 0, 1);
if("$primero" != "-") {
$labordesc2 = urlencode("$labordesc");
$printdesc2 = urlencode("$printdesc");
echo "<button type=button onClick=\"parent.location='cart.php?func=add_labor2&labordesc=$labordesc2&laborprice=$laborprice&laborpdesc=$printdesc2'\">$money".mf("$laborprice")." $labordesc</button>";
} else {
$labordesc3 = mb_substr("$labordesc", 1);
echo "<h3>$labordesc3</h3>";
}

}




dfooter();

require_once("dfooter.php");

}


function add_noninv2() {

require("deps.php");

require_once("common.php");
require("dheader.php");

dheader(pcrtlang("Add Non-Inv Item"));

echo "<form action=cart.php?func=add_noninv name=newinv method=post  data-ajax=\"false\">";
echo pcrtlang("Qty").":<input type=number name=qty value=1 step=1 min=1>";

echo pcrtlang("Price").":";
echo "<input type=text name=itemprice id=itemprice>";

$usertaxid = getusertaxid();
$salestaxrateremain = (1 + getsalestaxrate($usertaxid));
if($salestaxrateremain != 1) {
echo "<button class=button type=button title=\"".pcrtlang("Pre-Tax Calculator")."\" onclick='document.getElementById(\"itemprice\").value=(document.getElementById(\"itemprice\").value / $salestaxrateremain).toFixed(5)'>
<i class=\"fa fa-calculator\"></i> ".pcrtlang("Calculate Pre-Tax")."</button>";
}

echo pcrtlang("Our Cost").":";
echo "<input type=text name=ourprice value=\"0.00\">";

?>
<script>
function markup() {
var marknum = Math.ceil((document.newinv.ourprice.value - 0) * (document.newinv.chooser.value - 0)) - document.newinv.cents.value;
document.newinv.itemprice.value = marknum.toFixed(2);
}
</script>
<?php

echo pcrtlang("Markup").": ";
echo "<select name=chooser onChange=\"markup()\">
<option value=\"1.0\"></option>
<option value=\"1.04\">4%</option>
<option value=\"1.1\">10%</option>
<option value=\"1.2\">20%</option>
<option value=\"1.3\">30%</option>
<option value=\"1.4\">40%</option>
<option value=\"1.5\">50%</option>
<option value=\"1.75\">75%</option>
<option value=\"2\">2X</option>
<option value=\"3\">3X</option>
<option value=\"5\">5X</option>
<option value=\"10\">10X</option>
</select>";

echo "<select name=cents onChange=\"markup()\">
<option value=\"0.10\">90 ".pcrtlang("cents")."</option>
<option value=\"0.05\">95 ".pcrtlang("cents")."</option>
<option value=\"0.01\">99 ".pcrtlang("cents")."</option>
<option value=\"00\">00 ".pcrtlang("cents")."</option>
</select>";



echo pcrtlang("Item Description").":<input type=text name=itemdesc>";
echo pcrtlang("Printed Description").":<br><textarea class=textbox name=stock_pdesc cols=60></textarea>";
echo pcrtlang("Item Serial/Code").": (".pcrtlang("optional").")<input type=text name=itemserial>";
echo "<input type=submit value=\"".pcrtlang("Add to Cart")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Adding to Cart")."...'; this.form.submit();\" data-theme=\"b\"></form>";

dfooter();

require_once("dfooter.php");

}



function add_labor2() {
require_once("validate.php");

require("deps.php");
require("common.php");

$laborunitprice = $_REQUEST['laborprice'];
$labordesc = $_REQUEST['labordesc'];
$laborpdesc = $_REQUEST['laborpdesc'];
                                                                                                                                               
if (array_key_exists('qty', $_REQUEST)) {
$qty = $_REQUEST['qty'];
} else {
$qty = 1;
}

                                                                                                                                
$usertaxid = getusertaxid();
$servicetaxrate = getservicetaxrate($usertaxid);

$laborprice = $laborunitprice * $qty;
$servicetax = $laborprice * $servicetaxrate;

$labordescins = pv($labordesc);
$addtime = time();
$rs_insert_cart = "INSERT INTO cart (cart_price,cart_type,labor_desc,ipofpc,taxex,itemtax,addtime,unit_price,quantity,printdesc) VALUES  ('$laborprice','labor','$labordescins','$ipofpc','$usertaxid','$servicetax','$addtime','$laborunitprice','$qty','$laborpdesc')";
@mysqli_query($rs_connect, $rs_insert_cart);
                                                                                                                                               
header("Location: cart.php");
                                                                                                                                               
}


function remove_cart_item() {
require_once("validate.php");                    
$cart_item_id = $_REQUEST['cart_item_id'];
                                                                                                                           
require("deps.php");
require("common.php");
                                                                                                                                               


                                                                                                                                         
                                                                                                                                               
$rs_delete_cart = "DELETE FROM cart WHERE cart_item_id = '$cart_item_id'";
@mysqli_query($rs_connect, $rs_delete_cart);

if (array_key_exists('rs_return_sold_id', $_REQUEST)) {
$rs_return_sold_id = $_REQUEST['rs_return_sold_id'];                                           
$rs_reset_flag = "UPDATE sold_items SET return_flag = '' WHERE sold_id = '$rs_return_sold_id'";
@mysqli_query($rs_connect, $rs_reset_flag);
}
                                                                                                    
header("Location: cart.php");
                                                                                                                                               
}

function empty_cart() {
require_once("validate.php");
require("deps.php");
require("common.php");
                                                                                                                                               


                              
                                                                                                                                               
$rs_delete_cart = "DELETE FROM cart WHERE ipofpc = '$ipofpc'";
@mysqli_query($rs_connect, $rs_delete_cart);
                                          
$rs_reset_flag = "UPDATE sold_items SET return_flag = ''";
@mysqli_query($rs_connect, $rs_reset_flag);

$rs_clear_cust = "DELETE FROM currentcustomer WHERE byuser = '$ipofpc'";
@mysqli_query($rs_connect, $rs_clear_cust);         
                                                                                            
header("Location: cart.php");
                                                                                                                                               
}

function add_return() {
require_once("validate.php");

require("deps.php");
require("common.php");

$item = $_REQUEST['item'];
$receipt = $_REQUEST['receipt'];
$price = $_REQUEST['price'];
$stocktitle = pv($_REQUEST['stocktitle']);
$stockid = $_REQUEST['stockid'];
$rs_taxex = $_REQUEST['taxex'];
$itemserial = $_REQUEST['citemserial'];
$ourprice = $_REQUEST['courprice'];
$returnfee = $_REQUEST['returnfee'];
$cquantity = $_REQUEST['cquantity'];
$cunitprice = $_REQUEST['cunitprice'];
$quantity = $_REQUEST['quantity'];


if (array_key_exists('cfirstname',$_REQUEST)) {
$custname =  pv($_REQUEST['cfirstname']);
} else {
$custname = "";
}

if (array_key_exists('ccompany',$_REQUEST)) {
$ccompany =  pv($_REQUEST['ccompany']);
} else {
$ccompany = "";
}


if (array_key_exists('caddress',$_REQUEST)) {
$custaddy1 =  pv($_REQUEST['caddress']);
} else {
$custaddy1 = "";
}

if (array_key_exists('caddress2',$_REQUEST)) {
$custaddy2 =  pv($_REQUEST['caddress2']);
} else {
$custaddy2 = "";
}

if (array_key_exists('ccity',$_REQUEST)) {
$custcity =  pv($_REQUEST['ccity']);
} else {
$custcity = "";
}

if (array_key_exists('cstate',$_REQUEST)) {
$custstate =  pv($_REQUEST['cstate']);
} else {
$custstate = "";
}

if (array_key_exists('czip',$_REQUEST)) {
$custzip =  pv($_REQUEST['czip']);
} else {
$custzip = "";
}

if (array_key_exists('cphone',$_REQUEST)) {
$custphone =  pv($_REQUEST['cphone']);
} else {
$custphone = "";
}

if (array_key_exists('cemail',$_REQUEST)) {
$custemail =  pv($_REQUEST['cemail']);
} else {
$custemail = "";
}


$rs_clear_cust = "DELETE FROM currentcustomer WHERE byuser = '$ipofpc'";
@mysqli_query($rs_connect, $rs_clear_cust);

$rs_insert_cust = "INSERT INTO currentcustomer (cfirstname,ccompany,caddress,caddress2,ccity,cstate,czip,cphone,cemail,byuser) VALUES ('$custname','$ccompany','$custaddy1','$custaddy2','$custcity','$custstate','$custzip','$custphone','$custemail','$ipofpc')";
@mysqli_query($rs_connect, $rs_insert_cust);

$returnfee2 = (1 - ($returnfee * .01));

$price2 = ($cunitprice * $returnfee2 * $quantity);

$salestaxrate = getsalestaxrate($rs_taxex);

$unit_price = $cunitprice * $returnfee2;

$itemtax = $price2 * $salestaxrate;


$addtime = time();
$rs_insert_return = "INSERT INTO cart (cart_price,cart_type,cart_stock_id,labor_desc,return_sold_id,restocking_fee,ipofpc,taxex,itemtax,ourprice,itemserial,addtime,unit_price,quantity) VALUES  ('$price2','refund','$stockid','$stocktitle','$item','$returnfee','$ipofpc','$rs_taxex','$itemtax','$ourprice','$itemserial','$addtime','$unit_price','$quantity')";
@mysqli_query($rs_connect, $rs_insert_return);

$rs_flag_return = "UPDATE sold_items SET return_flag = 'flagged' WHERE sold_id = '$item'";
@mysqli_query($rs_connect, $rs_flag_return);
                                                                                                                                               
header("Location: receipt.php?func=show_receipt&receipt=$receipt");
}




function show_quote() {
require_once("validate.php");
require("deps.php");
include("common.php");
echo "<html><head><title>".pcrtlang("Estimate")."</title>";

echo "<style>";
echo ".textboxt {font-size: 14px; padding: 3px; font-weight: bold; background-color: #ffffff; border: .5px solid #eeeeee;}";
echo "</style>";

echo "<style type=\"text/css\">\n<!--\n";

include("../repair/printstyle.css");

echo "\n-->\n</style>\n";


echo "</head><body>";
echo "<table width=100%><tr><td width=55%>";

$storeinfoarray = getstoreinfo($defaultuserstore);


echo "<img src=../store/$printablelogo><br><font class=text12bi>$servicebyline</font><br><br><font class=text12b>";
echo "$storeinfoarray[storename]</font><font class=text12><br>$storeinfoarray[storeaddy1]";
if ("$storeinfoarray[storeaddy2]" != "") {
echo "<br>$storeinfoarray[storeaddy2]";
}
echo "<br>$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]";
echo "</font><br><br><font class=text12>".pcrtlang("Phone").": $storeinfoarray[storephone]</font></font><br><br>";


echo "<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font class=text12b>".pcrtlang("Bill To").":</font><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=textbox size=40 class=textboxt><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=textbox size=40 class=textboxt><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=textbox size=40 class=textboxt><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=textbox size=40 class=textboxt><br><br>";



echo "<table width=100% border=0 cellspacing=0>";
echo "<tr bgcolor=#4992ff><td colspan=3 width=100%><font class=text14b>".pcrtlang("Purchase Items")."</font></td></tr>";

echo "<tr bgcolor=#4992ff><td width=20%>&nbsp;</td><td width=65%><font class=text12b>".pcrtlang("Name of Product")."</font></td><td width=15%><font class=text12b>".pcrtlang("Price")."</font></td></tr>";





$rs_find_cart_items = "SELECT * FROM cart WHERE cart_type = 'purchase' AND ipofpc = '$ipofpc'";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

if (mysqli_num_rows($rs_result) == 0) {
echo "<tr><td width=20%>&nbsp;</td><td width=65%><font class=textgray12>".pcrtlang("No Purchase Items")."</font></td><td width=15%>&nbsp;</td></tr>";
}


while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_cart_item_id = "$rs_result_q->cart_item_id";
$rs_cart_price = "$rs_result_q->cart_price";
$rs_stock_id = "$rs_result_q->cart_stock_id";
$rs_noninvdesc = "$rs_result_q->labor_desc";

if ($rs_stock_id != "0") {

$rs_find_item_detail = "SELECT * FROM stock WHERE stock_id = '$rs_stock_id'";
$rs_find_result = mysqli_query($rs_connect, $rs_find_item_detail);
while($rs_find_result_q = mysqli_fetch_object($rs_find_result)) {
$rs_stocktitle = "$rs_find_result_q->stock_title";
echo "<tr><td width=20%>&nbsp;</td><td width=65%><font class=text12b>$rs_stocktitle</font></td>";
echo "<td width=15% align=right><font class=text12b>$money".mf("$rs_cart_price")."</font></td></tr>";
}

} else {
echo "<tr><td width=20%>&nbsp;</td><td width=65%><font class=text12b>$rs_noninvdesc</font></td>";
echo "<td width=15% align=right><font class=text12b>$money".mf("$rs_cart_price")."</font></td></tr>";


}


}


echo "<tr><td width=100% colspan=3>&nbsp;</td></tr>";
echo "<tr bgcolor=#4992ff><td colspan=3><font class=text14b>".pcrtlang("Labor")."</font></td></tr>";
echo "<tr bgcolor=#4992ff><td width=20%>&nbsp;</td><td width=65%><font class=text12b>".pcrtlang("Labor Description")."</font></td><td width=15%><font class=text12b>".pcrtlang("Price")."</font></td></tr>";

$rs_find_cart_labor = "SELECT * FROM cart WHERE cart_type = 'labor' AND ipofpc = '$ipofpc'";
$rs_result_labor = mysqli_query($rs_connect, $rs_find_cart_labor);

if (mysqli_num_rows($rs_result_labor) == 0) {
echo "<tr><td width=20%>&nbsp;</td><td width=65%><font class=textgray12>".pcrtlang("No Labor Items")."</font></td><td width=15%>&nbsp;</td></tr>";
}

                                                                                                                                               
while($rs_result_labor_q = mysqli_fetch_object($rs_result_labor)) {
$rs_cart_labor_id = "$rs_result_labor_q->cart_item_id";
$rs_cart_labor_price = "$rs_result_labor_q->cart_price";
$rs_cart_labor_desc = "$rs_result_labor_q->labor_desc";
echo "<tr><td width=20%>&nbsp;</td><td width=65%><font class=text12b>$rs_cart_labor_desc</font></td><td width=15% align=right><font class=text12b>$money".mf("$rs_cart_labor_price")."</font></td></tr>";

}

echo "<tr><td width=20%>&nbsp;</td><td width=65% align=right>&nbsp;</td><td width=15%>&nbsp;</td></tr>";


$usertaxid = getusertaxid();
$salestaxrate = getsalestaxrate($usertaxid);
$servicetaxrate = getservicetaxrate($usertaxid);
$taxname = gettaxname($usertaxid);

                                                                                                                                             

echo "<tr><td width=20%>&nbsp;</td><td width=65% align=right>&nbsp;</td><td width=15%>&nbsp;</td></tr>";

$rs_find_item_total = "SELECT SUM(cart_price) AS total_price_parts FROM cart WHERE cart_type = 'purchase' AND ipofpc = '$ipofpc'";
$rs_find_result_total = mysqli_query($rs_connect, $rs_find_item_total);
                                                                                                                                               
while($rs_find_result_total_q = mysqli_fetch_object($rs_find_result_total)) {
$rs_total_parts = "$rs_find_result_total_q->total_price_parts";

if ($rs_total_parts == "") {
$rs_total_parts = "0.00";
}
                                                                                                                                               
echo "<tr><td width=20%>&nbsp;</td><td width=65% align=right><font class=text12b>".pcrtlang("Parts Subtotal").":</font></td><td width=15% align=right><font class=text12b>$money".mf("$rs_total_parts")."</font></td></tr>";

$rs_find_itemtax_total = "SELECT SUM(itemtax) AS total_tax_parts FROM cart WHERE cart_type = 'purchase' AND ipofpc = '$ipofpc'";
$rs_find_result_taxtotal = mysqli_query($rs_connect, $rs_find_itemtax_total);
while($rs_find_result_taxtotal_q = mysqli_fetch_object($rs_find_result_taxtotal)) {
$rs_total_partstax = "$rs_find_result_taxtotal_q->total_tax_parts";

$salestax = $rs_total_partstax;


if ($salestax > 0) {
echo "<tr><td width=20%>&nbsp;</td><td width=65% align=right><font class=text12b>$t_tax:</font></td><td width=15% align=right><font class=text12b>$money".mf("$salestax")."</font></td></tr>";
}
}

echo "<tr><td width=20%>&nbsp;</td><td width=65% align=right>&nbsp;</td><td width=15%>&nbsp;</td></tr>";

$rs_find_labor_total = "SELECT SUM(cart_price) AS total_labor_price FROM cart WHERE cart_type = 'labor' AND ipofpc = '$ipofpc'";
$rs_find_result_labor_total = mysqli_query($rs_connect, $rs_find_labor_total);
                                                                                                            
                                   
while($rs_find_result_labor_total_q = mysqli_fetch_object($rs_find_result_labor_total)) {
$rs_total_labor = "$rs_find_result_labor_total_q->total_labor_price";

if ($rs_total_labor == "") {
$rs_total_labor = "0.00";
}
                       
                                                                                                                        
                                                                                                                                               
echo "<tr><td width=20%>&nbsp;</td><td width=65% align=right><font class=text12b>".pcrtlang("Labor Total").":</font></td><td width=15% align=right><font class=text12b>$money".mf("$rs_total_labor")."</font></td></tr>";

}


$rs_find_labortax_total = "SELECT SUM(itemtax) AS total_labortax_price FROM cart WHERE cart_type = 'labor' AND ipofpc = '$ipofpc'";
$rs_find_result_taxlabor_total = mysqli_query($rs_connect, $rs_find_labortax_total);
while($rs_find_result_labortax_total_q = mysqli_fetch_object($rs_find_result_taxlabor_total)) {
$rs_total_labortax = "$rs_find_result_labortax_total_q->total_labortax_price";

$servicetax = $rs_total_labortax;

if ($servicetax > 0) {
echo "<tr><td width=20%>&nbsp;</td><td width=65% align=right><font class=text12b>$t_tax:</font></td><td width=15% align=right><font class=text12b>$money".mf("$servicetax")."</font></td></tr>";
}

}

echo "<tr><td width=20%>&nbsp;</td><td width=65% align=right>&nbsp;</td><td width=15%>&nbsp;</td></tr>";
                                                                                                                                               

}
                                                                                                                                               
                                                                                                                                               

$grand_total = ($salestax + $rs_total_parts + $rs_total_labor + $servicetax);


echo "<tr><td width=20%>&nbsp;</td><td width=65% align=right>&nbsp;</td><td width=15%>&nbsp;</td></tr>";

echo "<tr><td width=20%>&nbsp;</td><td width=65% align=right><font class=text14b>".pcrtlang("Amount Due").":</font></td><td width=15% align=right><font class=text14b>".mf("$grand_total")."</font></td></tr>";


echo "<tr><td width=100% colspan=3>";
echo "<center><a href=cart.php>".pcrtlang("Return")."</a></center>";
echo "<br><br><br> <font class=text12b>".pcrtlang("Received By").":</font>____________________________________________________________";

echo "</td></tr></table><br><br>";

echo "</body></html>";

                                                                                                    
}


function discount_cart_item() {
require_once("validate.php");
$cart_item_id = $_REQUEST['cart_item_id'];
$rs_dis_percent = $_REQUEST['rs_dis_percent'];
$taxex = $_REQUEST['rs_taxex'];
$carttype = $_REQUEST['carttype'];
$discountname = $_REQUEST['discountname'];

require("deps.php");
require("common.php");


if ($carttype == "labor") {
$itemtax = getservicetaxrate($taxex);
} else {
$itemtax = getsalestaxrate($taxex);
}


$rs_discount_cart3 = "UPDATE cart SET origprice = cart_price, discounttype = 'percent|$rs_dis_percent', discountname = '$discountname' WHERE cart_item_id = '$cart_item_id'";
@mysqli_query($rs_connect, $rs_discount_cart3);


$rs_discount_cart = "UPDATE cart SET cart_price = (cart_price * ((100 - $rs_dis_percent) * .01)) , price_alt = '1' WHERE cart_item_id = '$cart_item_id'";
@mysqli_query($rs_connect, $rs_discount_cart);

$rs_discount_cart3 = "UPDATE cart SET unit_price = (unit_price * ((100 - $rs_dis_percent) * .01)) , price_alt = '1' WHERE cart_item_id = '$cart_item_id'";
@mysqli_query($rs_connect, $rs_discount_cart3);


$rs_discount_cart2 = "UPDATE cart SET itemtax = (cart_price * $itemtax)  WHERE cart_item_id = '$cart_item_id'";
@mysqli_query($rs_connect, $rs_discount_cart2);

header("Location: cart.php");

}



function custom_price() {
require_once("validate.php");
$cart_item_id = $_REQUEST['cart_item_id'];
$unit_price = $_REQUEST['custom_price'];
$taxex = $_REQUEST['rs_taxex'];
$qty = $_REQUEST['qty'];
$discountname = $_REQUEST['discountname'];

require("deps.php");
require("common.php");

$custom_price = $unit_price * $qty;

$carttype = $_REQUEST['carttype'];

if ($carttype == "labor") {
$itemtaxrate = getservicetaxrate($taxex);
} else {
$itemtaxrate = getsalestaxrate($taxex);
}

$itemtax = $custom_price * $itemtaxrate;


$rs_discount_cart2 = "UPDATE cart SET origprice = cart_price, discounttype = 'custom|na', discountname = '$discountname' WHERE cart_item_id = '$cart_item_id'";
@mysqli_query($rs_connect, $rs_discount_cart2);

$rs_discount_cart = "UPDATE cart SET cart_price = '$custom_price', unit_price = '$unit_price', price_alt = '1', itemtax = '$itemtax' WHERE cart_item_id = '$cart_item_id'";
@mysqli_query($rs_connect, $rs_discount_cart);


header("Location: cart.php");

}




function savecart() {
require_once("validate.php");
$cartname = $_REQUEST['cartname'];
$cartcheck = $_REQUEST['cartcheck'];

require("deps.php");
require("common.php");

if (array_key_exists('iskit',$_REQUEST)) {
$iskit = $_REQUEST['iskit'];;
} else {
$iskit = 0;
}


$cartcheckv = cartcheck();
if($cartcheck != $cartcheckv) die("Cart has changed <a href=cart.php>Reload Current Cart</a>");




$rs_find_cart_items = "SELECT * FROM cart WHERE ipofpc = '$ipofpc'";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

$rs_rm_cart = "DELETE FROM savedcarts WHERE cartname = '$cartname'";
@mysqli_query($rs_connect, $rs_rm_cart);

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_cart_price = "$rs_result_q->cart_price";
$rs_cart_type = "$rs_result_q->cart_type";
$rs_cart_stock_id = "$rs_result_q->cart_stock_id";
$rs_labor_desc = pv($rs_result_q->labor_desc);
$printdesc = pv($rs_result_q->printdesc);
$rs_return_sold_id = "$rs_result_q->return_sold_id";
$rs_restocking_fee = "$rs_result_q->restocking_fee";
$rs_price_alt = "$rs_result_q->price_alt";
$rs_taxex = "$rs_result_q->taxex";
$rs_itemtax = "$rs_result_q->itemtax";
$rs_origprice = "$rs_result_q->origprice";
$rs_discounttype = "$rs_result_q->discounttype";
$rs_ourprice = "$rs_result_q->ourprice";
$rs_unit_price = "$rs_result_q->unit_price";
$rs_quantity = "$rs_result_q->quantity";

$rs_insert_cart = "INSERT INTO savedcarts (cart_price,cart_type,cart_stock_id,labor_desc,return_sold_id,restocking_fee,price_alt,cartname,savedwhen,taxex,itemtax,origprice,discounttype,ourprice,iskit,unit_price,quantity,printdesc) VALUES  ('$rs_cart_price','$rs_cart_type','$rs_cart_stock_id','$rs_labor_desc','$rs_return_sold_id','$rs_restocking_fee','$rs_price_alt','$cartname','$currentdatetime','$rs_taxex','$rs_itemtax','$rs_origprice','$rs_discounttype','$rs_ourprice','$iskit','$rs_unit_price','$rs_quantity','$printdesc')";
@mysqli_query($rs_connect, $rs_insert_cart);

header("Location: cart.php");

}
}


function show_savecart() {


require_once("header.php");

require("deps.php");

if (array_key_exists('iskit',$_REQUEST)) {
$iskit = $_REQUEST['iskit'];
} else {
$iskit = 0;
}


if($iskit == 0) {
echo "<h3>".pcrtlang("Saved Carts")."</h3>";
} else {
echo "<h3>".pcrtlang("Kits")."</h3>";
}




if($iskit == 0) {
$rs_find_cart_items = "SELECT DISTINCT cartname, savedwhen FROM savedcarts WHERE iskit = '0'";
} else {
$rs_find_cart_items = "SELECT DISTINCT cartname, savedwhen FROM savedcarts WHERE iskit = '1'";
}

$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);
while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_cart_name = "$rs_result_q->cartname";
$rs_saved_when = "$rs_result_q->savedwhen";

$saved = pcrtdate("$pcrt_longdate", "$rs_saved_when").", ".pcrtdate("$pcrt_time", "$rs_saved_when");


echo "<table class=standard><tr><td>$rs_cart_name<br>".pcrtlang("Saved").": $saved</td>
</tr><tr><td valign=top>";

echo "<table class=standard><tr><th colspan=2>".pcrtlang("Items")."</th>";

echo "</tr>";

if($iskit == 0) {
$cartlabel = pcrtlang("Cart Price");
} else {
$cartlabel = pcrtlang("Kit Price");
}


$rs_find_items = "SELECT * FROM savedcarts WHERE cartname = '$rs_cart_name'";
$rs_find_result = mysqli_query($rs_connect, $rs_find_items);


while($rs_find_result_q = mysqli_fetch_object($rs_find_result)) {
$rs_stock_id = "$rs_find_result_q->cart_stock_id";
$rs_labor = "$rs_find_result_q->labor_desc";
$rs_cartprice = "$rs_find_result_q->cart_price";
$rs_taxex = "$rs_find_result_q->taxex";
$rs_unit_price = "$rs_find_result_q->unit_price";
$rs_quantity = "$rs_find_result_q->quantity";

if ($rs_stock_id == '0') {
echo "<tr><th>".pcrtlang("Item").":</th><th>$rs_labor</th></tr><tr><th>$cartlabel</th><td>$money".mf("$rs_cartprice")."</td></tr>";

echo "<tr><th>".pcrtlang("Qty")."</th><td>".qf("$rs_quantity")."</td></tr>";

echo "<tr><th>".pcrtlang("Unit Price")."</th><td>$money".mf("$rs_unit_price")."</td></tr>";

} else {
$rs_find_item_detail = "SELECT * FROM stock WHERE stock_id = '$rs_stock_id'";
$rs_find_result_detail = mysqli_query($rs_connect, $rs_find_item_detail);

while($rs_find_result_detail_q = mysqli_fetch_object($rs_find_result_detail)) {
$rs_stocktitle = "$rs_find_result_detail_q->stock_title";
$rs_stockprice = "$rs_find_result_detail_q->stock_price";

echo "<tr><th>".pcrtlang("Item").":</th><th>$rs_stocktitle</th></tr><tr><th>$cartlabel</th><td>$money".mf("$rs_cartprice")."</td></tr>";

echo "<tr><th>".pcrtlang("Qty")."</th><td>".qf("$rs_quantity")."</td></tr>";

echo "<tr><th>".pcrtlang("Unit Price")."</th><td>$money".mf("$rs_unit_price")."</td></tr>";

$rs_find_stock = "SELECT * FROM stockcounts WHERE storeid = '$defaultuserstore' AND stockid = '$rs_stock_id'";
$rs_result_stock = mysqli_query($rs_connect, $rs_find_stock);
$rs_result_stockq = mysqli_fetch_object($rs_result_stock);
$stockqty = "$rs_result_stockq->quantity";

echo "<tr><th>".pcrtlang("Qty in Stock")."</th><td style=\"text-align:right;\">$stockqty</td></tr>";

if($rs_stockprice != $rs_cartprice) {
echo "<tr><th>".pcrtlang("Current Price")."</th><td style=\"text-align:right;\">$money".mf("$rs_stockprice");

$salestaxrate = getsalestaxrate($rs_taxex);
$itemtax = $rs_stockprice * $salestaxrate;
$rs_cart_name2 = urlencode("$rs_cart_name");
echo  "<br><a href=cart.php?func=resyncprice&newprice=$rs_stockprice&newtax=$itemtax&iskit=$iskit&cart_stock_id=$rs_stock_id&cartname=$rs_cart_name2  data-ajax=\"false\">".pcrtlang("resync price")."</a>";

echo "</td></tr>";
}

}
}
}

$rs_find_totals = "SELECT SUM(cart_price) AS cptotal, SUM(itemtax) AS cptax FROM savedcarts WHERE cartname = '$rs_cart_name'";
$rs_find_result_totals = mysqli_query($rs_connect, $rs_find_totals);
$rs_find_result_tq = mysqli_fetch_object($rs_find_result_totals);
$rs_tprice = "$rs_find_result_tq->cptotal";
$rs_ttax = "$rs_find_result_tq->cptax";

$carttotal = $rs_ttax + $rs_tprice;

echo "<tr><td style=\"text-align:right;\">".pcrtlang("Tax")."</td>
<td style=\"text-align:right;\">$money".mf("$rs_ttax")."</td></tr>";

echo "<tr><td style=\"text-align:right;\">".pcrtlang("Total")."</td>
<td style=\"text-align:right;\">$money".mf("$carttotal")."</td></tr>";

echo "</table>";

echo "</td><tr><td>";
echo "<form action=cart.php?func=loadsavecart method=post  data-ajax=\"false\"><input type=hidden name=cartname value=\"$rs_cart_name\">";
echo "<input type=submit value=\"".pcrtlang("Copy to Cart")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Loading Cart")."...'; this.form.submit();\" data-ajax=\"false\"></form>";

$rs_cart_name_ue = htmlspecialchars($rs_cart_name, ENT_QUOTES, 'utf-8');

echo "<form action=cart.php?func=del_savecart method=post  data-ajax=\"false\"><input type=hidden name=cartname value=\"$rs_cart_name_ue\">";
echo "<input type=submit value=\"".pcrtlang("Delete")."\"  onClick=\"return confirm('".pcrtlang("ARE YOUR SURE YOU WANT TO DELETE THIS?")."');\" data-ajax=\"false\"></form>";

echo "<form action=cart.php?func=copysavecart method=post  data-ajax=\"false\">".pcrtlang("WO")."#<input type=hidden name=cartname value=\"$rs_cart_name\"><input type=text name=pcwo size=5>";
echo "<input class=button type=submit value=\"".pcrtlang("Copy to Work Order")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Copying")."...'; this.form.submit();\" data-ajax=\"false\"></form>";
echo "</td></tr></table>";
echo "<br>";
}


require_once("footer.php");



}


function show_savecarts() {

require_once("header.php");

require("deps.php");

echo "<h3>".pcrtlang("Ready to Sell Systems")."</h3>";

if(array_key_exists("mainassettypeid", $_REQUEST)) {
$mainassettypeid = $_REQUEST['mainassettypeid'];
$rs_find_cart_items = "SELECT * FROM pc_wo,pc_owner WHERE pc_wo.pcstatus = '7' AND pc_wo.storeid = '$defaultuserstore' AND pc_owner.mainassettypeid = '$mainassettypeid' AND pc_owner.pcid = pc_wo.pcid ORDER BY pc_wo.woid ASC";
} else {
$rs_find_cart_items = "SELECT * FROM pc_wo WHERE pcstatus = '7' AND storeid = '$defaultuserstore' ORDER BY woid ASC";
}

$ourpricetotal = 0;
$cartsumtotal = 0;

$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);
while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_woid = "$rs_result_q->woid";
$rs_pcid = "$rs_result_q->pcid";
$rs_prob = "$rs_result_q->probdesc";

$rs_findbill = "SELECT * FROM repaircart WHERE pcwo = '$rs_woid'";
$rs_findbill2 = mysqli_query($rs_connect, $rs_findbill);
$numite = mysqli_num_rows($rs_findbill2);

if($numite != 0) {
$rs_findsum = "SELECT (SUM(cart_price) + SUM(itemtax)) as checkcartsum, SUM(ourprice) AS ourprice FROM repaircart WHERE pcwo = '$rs_woid'";
$rs_findsum2 = @mysqli_query($rs_connect, $rs_findsum);
$rs_findsum3 = mysqli_fetch_object($rs_findsum2);
$cartsum = "$rs_findsum3->checkcartsum";
$ourprice = "$rs_findsum3->ourprice";
} else {
$cartsum = 0;
$ourprice = 0;
}


$ourpricetotal = $ourpricetotal + $ourprice;
$cartsumtotal = $cartsumtotal + $cartsum;



$rs_prob2 = nl2br($rs_prob);

$rs_find_cart_items2 = "SELECT * FROM pc_owner WHERE pcid = '$rs_pcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_find_cart_items2);
while($rs_result_q2 = mysqli_fetch_object($rs_result2)) {
$rs_model = "$rs_result_q2->pcmake";
$mainassettypeidindb = "$rs_result_q2->mainassettypeid";
$pcextra = "$rs_result_q2->pcextra";

$custompcinfoindb = array_filter(serializedarraytest($pcextra));

#$mainassettype = getassettypename($mainassettypeidindb);

$rs_allfindassets = "SELECT * FROM mainassetinfofields";
$rs_result2all = mysqli_query($rs_connect, $rs_allfindassets);
while ($rs_result_q2all = mysqli_fetch_object($rs_result2all)) {
$mainassetfieldid = "$rs_result_q2all->mainassetfieldid";
$mainassetfieldname = "$rs_result_q2all->mainassetfieldname";
$allassetinfofields[$mainassetfieldid] = "$mainassetfieldname";
}






echo "<table class=standard><tr><th><a href=../repairmobile/index.php?pcwo=$rs_woid class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"><i class=\"fa fa-tag fa-lg\"></i> $rs_pcid</a> $rs_model</th></tr><tr><table><tr><td>";



$a = 1;
$countitems = ceil((count($custompcinfoindb) / 2));

foreach($custompcinfoindb as $key => $val) {
if(array_key_exists("$key", $allassetinfofields)) {
echo "<p style=\"margin:0px 0px 3px 0px; border:1px #cccccc solid; background:#eeeeee; padding:1px 10px 1px 10px; border-radius:3px;\">$allassetinfofields[$key]: <br>$val</p>";
}

if(($a % $countitems) == 0) {
echo "</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td valign=top>";
}

$a++;
}



echo "</td></tr></table></td></tr>";
echo "<tr><td colspan=2>";
echo "<br>".pcrtlang("Cart Total").": $money".mf("$cartsum")."<br>".pcrtlang("Cost Price").": $money".mf("$ourprice");
echo "</td></tr>";
echo "</table>";



echo "<br><br>";
}
}


echo "<br><h3>".pcrtlang("Cart Totals").": $money".mf("$cartsumtotal")."</h3><h3>".pcrtlang("Cost Price Total").": $money".mf("$ourpricetotal")."</h3>";

require_once("footer.php");



}





function del_savecart() {
require_once("validate.php");

require("deps.php");
require("common.php");

$cartname = pv($_REQUEST['cartname']);





$rs_rm_cart = "DELETE FROM savedcarts WHERE cartname = '$cartname'";
@mysqli_query($rs_connect, $rs_rm_cart);

header("Location: cart.php?func=show_savecart");

}


function loadsavecart() {
require_once("validate.php");

require("deps.php");
require("common.php");

$cartname = $_REQUEST['cartname'];




$rs_find_cart_items = "SELECT * FROM savedcarts WHERE cartname = '$cartname'";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);


while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_cart_price = "$rs_result_q->cart_price";
$rs_cart_type = "$rs_result_q->cart_type";
$rs_cart_stock_id = "$rs_result_q->cart_stock_id";
$rs_labor_desc = pv($rs_result_q->labor_desc);
$printdesc = pv($rs_result_q->printdesc);
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

$rs_insert_cart = "INSERT INTO cart (cart_price,cart_type,cart_stock_id,labor_desc,return_sold_id,restocking_fee,price_alt,ipofpc,taxex,itemtax,origprice,discounttype,ourprice,itemserial,addtime,unit_price,quantity,printdesc,discountname) VALUES  ('$rs_cart_price','$rs_cart_type','$rs_cart_stock_id','$rs_labor_desc','$rs_return_sold_id','$rs_restocking_fee','$rs_price_alt','$ipofpc','$rs_taxex','$rs_itemtax','$rs_origprice','$rs_discounttype','$rs_ourprice','$rs_itemserial','$rs_addtime','$rs_unit_price','$rs_quantity','$printdesc','$rs_discountname')";
@mysqli_query($rs_connect, $rs_insert_cart);
header("Location: cart.php");

}
}


function copysavecart() {

require_once("validate.php");
require("deps.php");
require("common.php");

$cartname = $_REQUEST['cartname'];
$pcwo = $_REQUEST['pcwo'];

$rs_find_cart_items = "SELECT * FROM savedcarts WHERE cartname = '$cartname'";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

@mysqli_query($rs_connect, $rs_rm_cart);


while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_cart_price = "$rs_result_q->cart_price";
$rs_cart_type = "$rs_result_q->cart_type";
$rs_cart_stock_id = "$rs_result_q->cart_stock_id";
$rs_labor_desc = pv($rs_result_q->labor_desc);
$printdesc = pv($rs_result_q->printdesc);
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

$rs_insert_cart = "INSERT INTO repaircart (cart_price,cart_type,cart_stock_id,labor_desc,return_sold_id,restocking_fee,price_alt,pcwo,taxex,itemtax,origprice,discounttype,ourprice,itemserial,addtime,unit_price,quantity,printdesc,discountname) VALUES ('$rs_cart_price','$rs_cart_type','$rs_cart_stock_id','$rs_labor_desc','$rs_return_sold_id','$rs_restocking_fee','$rs_price_alt','$pcwo','$rs_taxex','$rs_itemtax','$rs_origprice','$rs_discounttype','$rs_ourprice','$rs_itemserial','$rs_addtime','$rs_unit_price','$rs_quantity','$printdesc','$rs_discountname')";
@mysqli_query($rs_connect, $rs_insert_cart);
header("Location: ../repairmobile/index.php?pcwo=$pcwo#repaircart");

}
}


function copycurrenttorepaircart() {
require_once("validate.php");

require("deps.php");
require("common.php");

$pcwo = $_REQUEST['pcwo'];

if ($pcwo == 0) {
die("You must choose a repair cart to save to");
}



$rs_find_cart_items = "SELECT * FROM cart WHERE ipofpc = '$ipofpc'";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

@mysqli_query($rs_connect, $rs_rm_cart);


while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_cart_price = "$rs_result_q->cart_price";
$rs_cart_type = "$rs_result_q->cart_type";
$rs_cart_stock_id = "$rs_result_q->cart_stock_id";
$rs_labor_desc = pv($rs_result_q->labor_desc);
$printdesc = pv($rs_result_q->printdesc);
$rs_return_sold_id = "$rs_result_q->return_sold_id";
$rs_restocking_fee = "$rs_result_q->restocking_fee";
$rs_price_alt = "$rs_result_q->price_alt";
$rs_taxex = "$rs_result_q->taxex";
$rs_itemtax = "$rs_result_q->itemtax";
$rs_origprice = "$rs_result_q->origprice";
$rs_discounttype = "$rs_result_q->discounttype";
$rs_ourprice = "$rs_result_q->ourprice";
$rs_itemserial = "$rs_result_q->itemserial";
$rs_unit_price = "$rs_result_q->unit_price";
$rs_quantity = "$rs_result_q->quantity";
$rs_discountname = "$rs_result_q->discountname";

$rs_insert_cart = "INSERT INTO repaircart (cart_price,cart_type,cart_stock_id,labor_desc,return_sold_id,restocking_fee,price_alt,pcwo,taxex,itemtax,origprice,discounttype,ourprice,itemserial,unit_price,quantity,printdesc,discountname) VALUES ('$rs_cart_price','$rs_cart_type','$rs_cart_stock_id','$rs_labor_desc','$rs_return_sold_id','$rs_restocking_fee','$rs_price_alt','$pcwo','$rs_taxex','$rs_itemtax','$rs_origprice','$rs_discounttype','$rs_ourprice','$rs_itemserial','$rs_unit_price','$rs_quantity','$printdesc','$rs_discountname')";
@mysqli_query($rs_connect, $rs_insert_cart);
header("Location: ../repair/index.php?pcwo=$pcwo");
 
}
}




function setusertax() {
require_once("validate.php");
require("deps.php");
require("common.php");

$setusername = $_COOKIE['username'];
$settaxname = $_REQUEST['settaxname'];

$rs_rm_cart = "UPDATE users SET currenttaxid = '$settaxname' WHERE username = '$setusername'";
@mysqli_query($rs_connect, $rs_rm_cart);

header("Location: cart.php");

}


function setitemtax() {
require_once("validate.php");
require("deps.php");
require("common.php");

$settaxid = $_REQUEST['settaxid'];
$cart_item_id = $_REQUEST['cart_item_id'];
$cartitemtype = $_REQUEST['cartitemtype'];

if ($cartitemtype == "labor") {
$taxrate = getservicetaxrate($settaxid);
} else {
$taxrate = getsalestaxrate($settaxid);
}





$rs_rm_cart = "UPDATE cart SET taxex = '$settaxid', itemtax = (cart_price * $taxrate) WHERE ipofpc = '$ipofpc' AND cart_item_id = $cart_item_id";
@mysqli_query($rs_connect, $rs_rm_cart);

header("Location: cart.php");

}



function savecurrentcustomer() {
require_once("validate.php");

require("deps.php");
require("common.php");

$cfirstname = pv($_REQUEST['cfirstname']);
$ccompany = pv($_REQUEST['ccompany']);
$caddress = pv($_REQUEST['caddress']);
$caddress2 = pv($_REQUEST['caddress2']);
$ccity = pv($_REQUEST['ccity']);
$cstate = pv($_REQUEST['cstate']);
$czip = pv($_REQUEST['czip']);
$cphone = pv($_REQUEST['cphone']);
$cemail = pv($_REQUEST['cemail']);
$cwoid = pv($_REQUEST['cwoid']);
$cinvoiceid = pv($_REQUEST['cinvoiceid']);
$crinvoiceid = pv($_REQUEST['crinvoiceid']);
$pcgroupid = pv($_REQUEST['pcgroupid']);




$rs_clear_cust = "DELETE FROM currentcustomer WHERE byuser = '$ipofpc'";
@mysqli_query($rs_connect, $rs_clear_cust);

$rs_insert_cust = "INSERT INTO currentcustomer (cfirstname,ccompany,caddress,caddress2,ccity,cstate,czip,cphone,cemail,woid,invoiceid,rinvoiceid,byuser,pcgroupid) VALUES  ('$cfirstname','$ccompany','$caddress','$caddress2','$ccity','$cstate','$czip','$cphone','$cemail','$cwoid','$cinvoiceid','$crinvoiceid','$ipofpc','$pcgroupid')";
@mysqli_query($rs_connect, $rs_insert_cust);

header("Location: cart.php");

}


function clearcurrentcustomer() {
require_once("validate.php");

require("deps.php");
require("common.php");




$rs_clear_cust = "DELETE FROM currentcustomer WHERE byuser = '$ipofpc'";
@mysqli_query($rs_connect, $rs_clear_cust);

header("Location: cart.php");

}

function removedeposit() {
require_once("validate.php");

require("deps.php");
require("common.php");

$depositid = $_REQUEST['depositid'];




$rs_clear_dep = "DELETE FROM currentpayments WHERE depositid = '$depositid' AND byuser = '$ipofpc'";
@mysqli_query($rs_connect, $rs_clear_dep);

header("Location: cart.php");

}


function pickcustomer() {
require("dheader.php");
require("deps.php");

$searchtext = $_REQUEST['searchtext'];

if (mb_strlen($searchtext) < 3) {
die("Search term too short");
} 

if (array_key_exists('pickfor',$_REQUEST)) {
$pickfor = $_REQUEST['pickfor'];
} else {
$pickfor = "currentcart";
}





$rs_find_pc = "SELECT DISTINCT pcname,pccompany,pcaddress,pcaddress2,pccity,pcstate,pczip,pcstate,pczip,pcemail,pcphone FROM pc_owner WHERE pcname LIKE '%$searchtext%' OR pccompany LIKE '%$searchtext%'";
$rs_result_item = mysqli_query($rs_connect, $rs_find_pc);


dheader(pcrtlang("Pick Customer"));

echo "<div data-role=\"collapsible-set\" class=\"ui-collapsible-set\" data-corners=\"false\">";
echo "<div data-role=\"collapsible\">";
echo "<h3>".pcrtlang("PC Search Results")."</h3>";

if (mysqli_num_rows($rs_result_item) == "0") {
echo pcrtlang("No Items Found")."...";
}

while($rs_result_q = mysqli_fetch_object($rs_result_item)) {
$personname = "$rs_result_q->pcname";
$pccompany = "$rs_result_q->pccompany";
$address1 = "$rs_result_q->pcaddress";
$address2 = "$rs_result_q->pcaddress2";
$city = "$rs_result_q->pccity";
$state = "$rs_result_q->pcstate";
$zip = "$rs_result_q->pczip";
$email = "$rs_result_q->pcemail";
$phone = "$rs_result_q->pcphone";

$ue_personname = urlencode($personname);
$ue_pccompany = urlencode($pccompany);
$ue_address1 = urlencode($address1);
$ue_address2 = urlencode($address2);
$ue_city = urlencode($city);
$ue_state = urlencode($state);
$ue_zip = urlencode($zip);
$ue_email = urlencode($email);
$ue_phone = urlencode($phone);



echo "<table class=standard><tr><th>$personname</th><th style=\"text-align:right;\">";
if ("$pickfor" == "currentcart") {
echo "<button type=button onClick=\"parent.location='cart.php?func=pickcustomer2&personname=$ue_personname&company=$ue_pccompany&address1=$ue_address1&address2=$ue_address2&city=$ue_city&state=$ue_state&zip=$ue_zip&email=$ue_email&phone=$ue_phone'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" data-mini=\"true\"><i class=\"fa fa-plus fa-lg\"></i></button>";
} else {
echo "<button type=button onClick=\"parent.location='deposits.php?cfirstname=$ue_personname&ccompany=$ue_pccompany&caddress=$ue_address1&caddress2=$ue_address2&ccity=$ue_city&cstate=$ue_state&czip=$ue_zip&cemail=$ue_email&cphone=$ue_phone'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" data-mini=\"true\"><i class=\"fa fa-plus fa-lg\"></i></button>";
}

echo "</th></tr><tr><td colspan=2>";

if("$pccompany" != "") {
echo "$pccompany";
}

echo "$address1";
if ($address2 != "") {
echo "<br>$address2";
}

if (($city != "") || ($state != "") || ($zip != "")) {
echo "<br>";
}

if ($city != "") {
echo "$city,";
}
if ($state != "") {
echo "$state,";
}
if ($zip != "") {
echo "$zip";
}

echo "</td></tr></table>";

echo "<br><br>";



}

echo "</div>";

echo "<div data-role=\"collapsible\">";
echo "<h3>".pcrtlang("Group Search Results")."</h3>";


$rs_findgrp = "SELECT * FROM pc_group WHERE pcgroupname LIKE '%$searchtext%' OR grpcompany LIKE '%$searchtext%'";
$rs_resultgrp = mysqli_query($rs_connect, $rs_findgrp);

if (mysqli_num_rows($rs_resultgrp) == "0") {
echo pcrtlang("No Groups Found")."...";
}

while ($rs_result_grpq = mysqli_fetch_object($rs_resultgrp)) {
$groupid = "$rs_result_grpq->pcgroupid";
$personname = "$rs_result_grpq->pcgroupname";
$grpcompany = "$rs_result_grpq->grpcompany";
$address1 = "$rs_result_grpq->grpaddress1";
$address2 = "$rs_result_grpq->grpaddress2";
$city = "$rs_result_grpq->grpcity";
$state = "$rs_result_grpq->grpstate";
$zip = "$rs_result_grpq->grpzip";
$email = "$rs_result_grpq->grpemail";
$phone = "$rs_result_grpq->grpphone";

$ue_personname = urlencode($personname);
$ue_grpcompany = urlencode($grpcompany);
$ue_address1 = urlencode($address1);
$ue_address2 = urlencode($address2);
$ue_city = urlencode($city);
$ue_state = urlencode($state);
$ue_zip = urlencode($zip);
$ue_email = urlencode($email);
$ue_phone = urlencode($phone);


echo "<table class=standard><tr><th>$personname</th><th style=\"text-align:right;\">";
if ("$pickfor" == "currentcart") {
echo "<button type=button onClick=\"parent.location='cart.php?func=pickcustomer2&personname=$ue_personname&company=$ue_grpcompany&address1=$ue_address1&address2=$ue_address2&city=$ue_city&state=$ue_state&zip=$ue_zip&email=$ue_email&phone=$ue_phone&pcgroupid=$groupid'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" data-mini=\"true\"><i class=\"fa fa-plus fa-lg\"></i></button>";
} else {
echo "<button type=button onClick=\"parent.location='deposits.php?cfirstname=$ue_personname&ccompany=$ue_grpcompany&caddress1=$ue_address1&caddress2=$ue_address2&ccity=$ue_city&cstate=$ue_state&czip=$ue_zip&cemail=$ue_email&cphone=$ue_phone&pcgroupid=$groupid'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" data-mini=\"true\"><i class=\"fa fa-plus fa-lg\"></i></button>";
}
echo "</th></tr><tr><td colspan=2>";

if("$grpcompany" != "") {
echo "$grpcompany<br>";
}

echo "$address1";
if ($address2 != "") {
echo "<br>$address2";
}

if (($city != "") || ($state != "") || ($zip != "")) {
echo "<br>";
}

if ($city != "") {
echo "$city,";
}
if ($state != "") {
echo "$state,"; 
}
if ($zip != "") {
echo "$zip"; 
}

echo "</td></tr></table>";
echo "<br><br>";


}

echo "</div>";

echo "<div data-role=\"collapsible\">";
echo "<h3>".pcrtlang("Receipt Search Results")."</h3>";


$rs_findrec = "SELECT DISTINCT person_name,company,address1,address2,city,state,zip,email,phone_number FROM receipts WHERE person_name LIKE '%$searchtext%' OR company LIKE '%$searchtext%' ORDER BY date_sold DESC LIMIT 10";
$rs_resultrec = mysqli_query($rs_connect, $rs_findrec);

if (mysqli_num_rows($rs_resultrec) == "0") {
echo pcrtlang("No Receipts Found");
}

while ($rs_result_recq = mysqli_fetch_object($rs_resultrec)) {
$personname = "$rs_result_recq->person_name";
$company = "$rs_result_recq->company";
$address1 = "$rs_result_recq->address1";
$address2 = "$rs_result_recq->address2";
$city = "$rs_result_recq->city";
$state = "$rs_result_recq->state";
$zip = "$rs_result_recq->zip";
$email = "$rs_result_recq->email";
$phone = "$rs_result_recq->phone_number";

$ue_personname = urlencode($personname);
$ue_company = urlencode($company);
$ue_address1 = urlencode($address1);
$ue_address2 = urlencode($address2);
$ue_city = urlencode($city);
$ue_state = urlencode($state);
$ue_zip = urlencode($zip);
$ue_email = urlencode($email);
$ue_phone = urlencode($phone);




echo "<table class=standard><tr><th>$personname</th><th style=\"text-align:right;\">";
if ("$pickfor" == "currentcart") {
echo "<button type=button onClick=\"parent.location='cart.php?func=pickcustomer2&personname=$ue_personname&company=$ue_company&address1=$ue_address1&address2=$ue_address2&city=$ue_city&state=$ue_state&zip=$ue_zip&email=$ue_email&phone=$ue_phone'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"><i class=\"fa fa-plus\"></i></button>";
} else {
echo "<button type=button onClick=\"parent.location='deposits.php?cfirstname=$ue_personname&ccompany=$ue_company&caddress1=$ue_address1&caddress2=$ue_address2&ccity=$ue_city&cstate=$ue_state&czip=$ue_zip&cemail=$ue_email&cphone=$ue_phone'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"><i class=\"fa fa-plus\"></i></button>";
}

echo "</th></tr><tr><td colspan=2>";

if("$company" != "") {
echo "$company";
}


echo "$address1";
if ($address2 != "") {
echo "<br>$address2";
}

if (($city != "") || ($state != "") || ($zip != "")) {
echo "<br>";
}

if ($city != "") {
echo "$city,";
}
if ($state != "") {
echo "$state,";
}
if ($zip != "") {
echo "$zip";
}

echo "</td></tr></table>";

echo "<br><br>";


}


echo "</div>";
echo "</div>";

require_once("dfooter.php");

}



function pickcustomer2() {
require_once("validate.php");

require("deps.php");
require("common.php");

$cfirstname = pv($_REQUEST['personname']);
$ccompany = pv($_REQUEST['company']);
$caddress = pv($_REQUEST['address1']);
$caddress2 = pv($_REQUEST['address2']);
$ccity = pv($_REQUEST['city']);
$cstate = pv($_REQUEST['state']);
$czip = pv($_REQUEST['zip']);
$cphone = pv($_REQUEST['phone']);
$cemail = pv($_REQUEST['email']);

if (array_key_exists('pcgroupid',$_REQUEST)) {
$pcgroupid = pv($_REQUEST['pcgroupid']);
} else {
$pcgroupid = 0;
}




$rs_clear_cust = "DELETE FROM currentcustomer WHERE byuser = '$ipofpc'";
@mysqli_query($rs_connect, $rs_clear_cust);

$rs_insert_cust = "INSERT INTO currentcustomer (cfirstname,ccompany,caddress,caddress2,ccity,cstate,czip,cphone,cemail,byuser,pcgroupid) VALUES  ('$cfirstname','$ccompany','$caddress','$caddress2','$ccity','$cstate','$czip','$cphone','$cemail','$ipofpc','$pcgroupid')";
@mysqli_query($rs_connect, $rs_insert_cust);

header("Location: cart.php");

}

function edit() {
require_once("validate.php");
require("deps.php");

require_once("common.php");
require("dheader.php");

$rs_cart_item_id = $_REQUEST['cart_item_id'];
$rs_taxex = $_REQUEST['rs_taxex'];
$carttype = $_REQUEST['rs_cart_type'];
$rs_cart_price = $_REQUEST['rs_cart_price'];
$itemdesc = $_REQUEST['itemdesc'];
$printdesc = $_REQUEST['printdesc'];
$serial = $_REQUEST['serial'];
$price_alt = $_REQUEST['price_alt'];
$cost = $_REQUEST['cost'];
$qty = $_REQUEST['qty'];

dheader(pcrtlang("Edit Cart Item"));

echo pcrtlang("Original Price").": $money".mf("$rs_cart_price")."<br><br>";

echo "<form method=post  data-ajax=\"false\" action=cart.php?func=edit2 name=editnoninv id=editform><input type=hidden name=cart_item_id value=$rs_cart_item_id>";
echo "<input type=hidden name=rs_taxex value=$rs_taxex><input type=hidden name=carttype value=\"$carttype\">";
if($carttype == "purchase") {

if($serial != "") {
echo pcrtlang("Quantity").": ".qf("$qty")."<input type=hidden name=qty value=\"$qty\">";
} else {
echo pcrtlang("Quantity").": <input type=number name=qty value=\"".qf("$qty")."\" min=1 step=1>";
}

echo pcrtlang("Item Title").": <input type=text name=itemdesc value=\"$itemdesc\">";

echo pcrtlang("Optional Printable Description").": <textarea size=60 class=textbox name=printdesc>$printdesc</textarea>";

if($qty == 1) {
echo pcrtlang("Serial/Code").": <input size=30 type=text class=textbox name=serial value=\"$serial\">";
} else {
echo "<input type=hidden name=serial value=\"\">";
}

} else {

echo pcrtlang("Quantity").": <input type=number name=qty value=\"$qty\" min=\".01\" step=\".01\">";
echo pcrtlang("Labor Description").": <input type=text name=itemdesc value=\"$itemdesc\">";
echo pcrtlang("Optional Printable Description").":<textarea size=60 class=textbox name=printdesc>$printdesc</textarea>";
}
if($price_alt != "1") {
echo pcrtlang("Price").": <input type=text name=price id=price value=\"".mf("$rs_cart_price")."\">";

$usertaxid = getusertaxid();
if($carttype == "purchase") {
$salestaxrateremain = (1 + getsalestaxrate($usertaxid));
} else {
$salestaxrateremain = (1 + getservicetaxrate($usertaxid));
}
if($salestaxrateremain != 1) {
echo "<button class=button type=button onclick='document.getElementById(\"price\").value=(document.getElementById(\"price\").value / $salestaxrateremain).toFixed(5);this.disabled=true;'>
<i class=\"fa fa-calculator\"></i> ".pcrtlang("Pre-tax")."</button>";
}




if($carttype == "purchase") {
echo pcrtlang("Cost").": <input type=text name=cost value=\"".mf("$cost")."\">";

?>

<script>
function markup() {
var marknum = Math.ceil((document.editnoninv.cost.value - 0) * (document.editnoninv.chooser.value - 0)) - document.editnoninv.cents.value;
document.editnoninv.price.value = marknum.toFixed(2);
}
</script>

<?php

echo pcrtlang("Markup").": ";
echo "<select name=chooser onChange=\"markup()\">
<option value=\"1.0\"></option>
<option value=\"1.04\">4%</option>
<option value=\"1.1\">10%</option>
<option value=\"1.2\">20%</option>
<option value=\"1.3\">30%</option>
<option value=\"1.4\">40%</option>
<option value=\"1.5\">50%</option>
<option value=\"1.75\">75%</option>
<option value=\"2\">2X</option>
<option value=\"3\">3X</option>
<option value=\"5\">5X</option>
<option value=\"10\">10X</option>
</select>";

echo "<select name=cents onChange=\"markup()\">
<option value=\"0.10\">90 ".pcrtlang("cents")."</option>
<option value=\"0.05\">95 ".pcrtlang("cents")."</option>
<option value=\"0.01\">99 ".pcrtlang("cents")."</option>
<option value=\"00\">00 ".pcrtlang("cents")."</option>
</select>";



}
} else {
echo "<input type=hidden name=price value=\"$rs_cart_price\">";
if($carttype == "purchase") {
echo "<input type=hidden name=cost value=\"$cost\">";
}
}
echo "<br><button type=button id=editbutton onclick=\"this.disabled=true; document.getElementById('editbutton').innerHTML = '".pcrtlang("Saving")."...'; this.form.submit();\" data-theme=\"b\"><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button></form>";


dfooter();
require_once("dfooter.php");

}


function edit2() {
require_once("validate.php");
require("deps.php");
require("common.php");

$cart_item_id = $_REQUEST['cart_item_id'];
$carttype = $_REQUEST['carttype'];
$taxex = $_REQUEST['rs_taxex'];
$itemdesc = pv($_REQUEST['itemdesc']);
$printdesc = pv($_REQUEST['printdesc']);
$price = $_REQUEST['price'];
$qty = $_REQUEST['qty'];



$rs_find_cart_item = "SELECT * FROM cart WHERE cart_item_id = '$cart_item_id'";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_item);
$rs_result_q = mysqli_fetch_object($rs_result);
$rs_price_alt = "$rs_result_q->price_alt";
$rs_origprice = "$rs_result_q->origprice";
$rs_quantity = "$rs_result_q->quantity";

if($rs_price_alt == 1) {
if($rs_origprice != 0) {
$orig_unit_price = $rs_origprice / $rs_quantity;
$neworigprice = $orig_unit_price * $qty;
} else {
$neworigprice = 0;
}
} else {
$neworigprice = 0;
}


if($carttype == "purchase") {
$cost = $_REQUEST['cost'] * $qty;
$serial = $_REQUEST['serial'];
$salestaxrate = getsalestaxrate($taxex);
$itemtax = $price * $salestaxrate * $qty;
$totalprice = $price * $qty;

if(($qty != 1) && ($serial != "")) {
die(pcrtlang("Error: Quantity on an item with a serial number must be 1"));
}


$rs_setprice_cart = "UPDATE cart SET cart_price = '$totalprice', unit_price = '$price', quantity = '$qty', itemtax = '$itemtax', labor_desc = '$itemdesc', ourprice = '$cost', itemserial = '$serial', origprice = '$neworigprice', printdesc = '$printdesc' WHERE cart_item_id = '$cart_item_id'";
@mysqli_query($rs_connect, $rs_setprice_cart);

} else {

$servicetaxrate = getservicetaxrate($taxex);
$servicetax = $price * $servicetaxrate * $qty;

$totalprice = $price * $qty;

$rs_setprice_cart = "UPDATE cart SET cart_price = '$totalprice', unit_price = '$price', quantity = '$qty', itemtax = '$servicetax', labor_desc = '$itemdesc', origprice = '$neworigprice', printdesc = '$printdesc'  WHERE cart_item_id = '$cart_item_id'";
@mysqli_query($rs_connect, $rs_setprice_cart);


}

header("Location: cart.php");
}

function removediscount() {
require_once("validate.php");
$cart_item_id = $_REQUEST['cart_item_id'];

require("deps.php");
require("common.php");



$rs_find_cart_item = "SELECT * FROM cart WHERE cart_item_id = '$cart_item_id'";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_item);
$rs_result_q = mysqli_fetch_object($rs_result);
$rs_cart_type = "$rs_result_q->cart_type";
$rs_price_alt = "$rs_result_q->price_alt";
$rs_taxex = "$rs_result_q->taxex";
$rs_origprice = "$rs_result_q->origprice";
$rs_unit_price = "$rs_result_q->unit_price";
$rs_quantity = "$rs_result_q->quantity";

if($rs_origprice != 0) {
$rs_orig_unit_price = $rs_origprice / $rs_quantity;
} else {
$rs_orig_unit_price = 0;
}


if($rs_cart_type == "purchase") {
$salestaxrate = getsalestaxrate($rs_taxex);
$itemtax = $rs_origprice * $salestaxrate;

$rs_setprice_cart = "UPDATE cart SET cart_price = '$rs_origprice', itemtax = '$itemtax', discounttype = '', origprice = '0', price_alt = '0', unit_price = '$rs_orig_unit_price', discountname = '' WHERE cart_item_id = '$cart_item_id'";
@mysqli_query($rs_connect, $rs_setprice_cart);

} else {

$servicetaxrate = getservicetaxrate($rs_taxex);
$servicetax = $rs_origprice * $servicetaxrate;

$rs_setprice_cart = "UPDATE cart SET cart_price = '$rs_origprice', itemtax = '$servicetax', discounttype = '', origprice = '0', price_alt = '0', unit_price = '$rs_orig_unit_price', discountname = '' WHERE cart_item_id = '$cart_item_id'";
@mysqli_query($rs_connect, $rs_setprice_cart);

}


header("Location: cart.php");
}



function refundlabor() {
require_once("validate.php");

require("deps.php");
require("common.php");

$item = $_REQUEST['item'];
$receipt = $_REQUEST['receipt'];
$price = $_REQUEST['price'];
$labordesc = pv($_REQUEST['labordesc']);
$rs_taxex = $_REQUEST['taxex'];
$cunitprice = $_REQUEST['cunitprice'];
$cquantity = $_REQUEST['cquantity'];
$quantity = $_REQUEST['quantity'];


if (array_key_exists('cfirstname',$_REQUEST)) {
$custname =  pv($_REQUEST['cfirstname']);
} else {
$custname = "";
}

if (array_key_exists('ccompany',$_REQUEST)) {
$ccompany =  pv($_REQUEST['ccompany']);
} else {
$ccompany = "";
}


if (array_key_exists('caddress',$_REQUEST)) {
$custaddy1 =  pv($_REQUEST['caddress']);
} else {
$custaddy1 = "";
}

if (array_key_exists('caddress2',$_REQUEST)) {
$custaddy2 =  pv($_REQUEST['caddress2']);
} else {
$custaddy2 = "";
}

if (array_key_exists('ccity',$_REQUEST)) {
$custcity =  pv($_REQUEST['ccity']);
} else {
$custcity = "";
}

if (array_key_exists('cstate',$_REQUEST)) {
$custstate =  pv($_REQUEST['cstate']);
} else {
$custstate = "";
}

if (array_key_exists('czip',$_REQUEST)) {
$custzip =  pv($_REQUEST['czip']);
} else {
$custzip = "";
}

if (array_key_exists('cphone',$_REQUEST)) {
$custphone =  pv($_REQUEST['cphone']);
} else {
$custphone = "";
}

if (array_key_exists('cemail',$_REQUEST)) {
$custemail =  pv($_REQUEST['cemail']);
} else {
$custemail = "";
}


$rs_clear_cust = "DELETE FROM currentcustomer WHERE byuser = '$ipofpc'";
@mysqli_query($rs_connect, $rs_clear_cust);
$rs_insert_cust = "INSERT INTO currentcustomer (cfirstname,ccompany,caddress,caddress2,ccity,cstate,czip,cphone,cemail,byuser) VALUES ('$custname','$ccompany','$custaddy1','$custaddy2','$custcity','$custstate','$custzip','$custphone','$custemail','$ipofpc')";
@mysqli_query($rs_connect, $rs_insert_cust);


$servicetaxrate = getservicetaxrate($rs_taxex);

$price2 = $cunitprice * $quantity;

$labortax = $price2 * $servicetaxrate;




$addtime = time();
$rs_insert_return = "INSERT INTO cart (cart_price,cart_type,labor_desc,return_sold_id,ipofpc,taxex,itemtax,addtime,unit_price,quantity) VALUES ('$price2','refundlabor','$labordesc','$item','$ipofpc','$rs_taxex','$labortax','$addtime','$cunitprice','$quantity')";
@mysqli_query($rs_connect, $rs_insert_return);


$rs_flag_return = "UPDATE sold_items SET return_flag = 'flagged' WHERE sold_id = '$item'";
@mysqli_query($rs_connect, $rs_flag_return);
header("Location: receipt.php?func=show_receipt&receipt=$receipt");
}





function spoaddcart() {
require_once("validate.php");

require("deps.php");
require("common.php");

$spowoid = $_REQUEST['spowoid'];
$spoid = $_REQUEST['spoid'];

$rs_find_so = "SELECT * FROM specialorders WHERE spoid = '$spoid'";
$rs_result_so = mysqli_query($rs_connect, $rs_find_so);

$rs_result_item_q = mysqli_fetch_object($rs_result_so);
$spoid = "$rs_result_item_q->spoid";
$spopartname = "$rs_result_item_q->spopartname";
$spoprintdesc = "$rs_result_item_q->printdesc";
$spoprice = mf("$rs_result_item_q->spoprice");
$spocost = mf("$rs_result_item_q->spocost");
$unit_price = "$rs_result_item_q->unit_price";
$quantity = "$rs_result_item_q->quantity";

$usertaxid = getusertaxid();
$taxrate = getsalestaxrate($usertaxid);
$itemtax = $taxrate * $spoprice * $quantity;

$addtime = time();

$rs_insert_cart = "INSERT INTO cart (cart_price,cart_type,labor_desc,taxex,itemtax,ourprice,addtime,ipofpc,unit_price,quantity,printdesc) VALUES ('$spoprice','purchase','$spopartname','$usertaxid','$itemtax','$spocost','$addtime','$ipofpc','$unit_price','$quantity','$spoprintdesc')";
@mysqli_query($rs_connect, $rs_insert_cart);


header("Location: cart.php");

}



function resyncprice() {
require_once("validate.php");

$newtax = $_REQUEST['newtax'];
$newprice = $_REQUEST['newprice'];
$iskit = $_REQUEST['iskit'];
$cartname = $_REQUEST['cartname'];
$cart_stock_id = $_REQUEST['cart_stock_id'];

require("deps.php");
require("common.php");





$rs_update = "UPDATE savedcarts SET cart_price = '$newprice', itemtax = '$newtax' WHERE cartname = '$cartname' AND cart_stock_id = '$cart_stock_id'";

@mysqli_query($rs_connect, $rs_update);

header("Location: cart.php?func=show_savecart&iskit=$iskit");

}


function editinvitem() {
require("deps.php");
require_once("common.php");
require_once("validate.php");

require("dheader.php");
dheader(pcrtlang("Edit Cart Item"));

$rs_cart_item_id = $_REQUEST['cart_item_id'];
$rs_taxex = $_REQUEST['rs_taxex'];
$rs_cart_price = $_REQUEST['rs_cart_price'];
$price_alt = $_REQUEST['price_alt'];
$cost = $_REQUEST['cost'];
$qty = $_REQUEST['qty'];

echo "<form method=post action=cart.php?func=editinvitem2 name=editinvitem2 id=editform  data-ajax=\"false\"><input type=hidden name=cart_item_id value=$rs_cart_item_id>";
echo "<input type=hidden name=rs_taxex value=$rs_taxex><input type=hidden name=cost value=$cost>";
echo "<table>";
echo "<tr><td>".pcrtlang("Quantity").":</td><td><input type=number name=qty value=\"".qf("$qty")."\" min=1 step=1></td></tr>";

echo "</table>";
echo "<br><button type=submit id=editbutton><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button></form>";

dfooter();
require_once("dfooter.php");

}


function editinvitem2() {
require_once("validate.php");

require("deps.php");
require("common.php");


$cart_item_id = $_REQUEST['cart_item_id'];
$taxex = $_REQUEST['rs_taxex'];
$qty = $_REQUEST['qty'];

$rs_find_cart_item = "SELECT * FROM cart WHERE cart_item_id = '$cart_item_id'";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_item);
$rs_result_q = mysqli_fetch_object($rs_result);
$rs_price_alt = "$rs_result_q->price_alt";
$rs_origprice = "$rs_result_q->origprice";
$rs_quantity = "$rs_result_q->quantity";
$unit_price = "$rs_result_q->unit_price";

if($rs_price_alt == 1) {
if($rs_origprice != 0) {
$orig_unit_price = $rs_origprice / $rs_quantity;
$neworigprice = $orig_unit_price * $qty;
} else {
$neworigprice = 0;
}
} else {
$neworigprice = 0;
}


$cost = $_REQUEST['cost'] * $qty;
$salestaxrate = getsalestaxrate($taxex);
$itemtax = $unit_price * $salestaxrate * $qty;
$totalprice = $unit_price * $qty;

$rs_setprice_cart = "UPDATE cart SET cart_price = '$totalprice', unit_price = '$unit_price', quantity = '$qty', itemtax = '$itemtax', ourprice = '$cost', origprice = '$neworigprice' WHERE cart_item_id = '$cart_item_id'";
@mysqli_query($rs_connect, $rs_setprice_cart);

header("Location: cart.php");
}


function addserialafter() {
require_once("validate.php");

require("deps.php");
require("common.php");

require_once("dheader.php");

dheader(pcrtlang("Enter Serial/Code?"));

$stockid = $_REQUEST['stockid'];
$cart_item_id = $_REQUEST['cart_item_id'];

$availser = available_serials($stockid);

echo "<form action=cart.php?func=addserialafter2 method=post><table>";
if (count($availser) != 0) {
echo "<tr><td>".pcrtlang("Pick Serial").":<form action=cart.php?func=addserialafter2 method=post data-ajax=\"false\"></td>";
echo "<td><select name=itemserialchooser onchange='document.getElementById(\"itemserial\").value=this.options[this.selectedIndex].value '>";
echo "<option value=\"\">".pcrtlang("(optional) pick serial/code or type below")."</option>";
foreach($availser as $key => $val) {
if($val != "") {

$rs_find_store = "SELECT * FROM inventory WHERE itemserial LIKE '%$val%' AND stock_id = '$stockid' LIMIT 1";
$rs_find_store_q = @mysqli_query($rs_connect, $rs_find_store);
$rs_find_result_q = mysqli_fetch_object($rs_find_store_q);
$rs_storeid = "$rs_find_result_q->storeid";
$storeinfo = getstoreinfo($rs_storeid);


echo "<option value=\"$val\">$storeinfo[storesname] &bull; $val</option>";
}
}
echo "</select></td></tr>";
}
echo "<tr><td>".pcrtlang("Serial/Code (optional)").":</td>";
echo "<td><input type=text name=itemserial id=itemserial><input type=hidden name=stockid value=\"$stockid\"></td></tr>";
echo "<tr><td><input type=hidden name=cart_item_id value=\"$cart_item_id\"><button type=submit id=editbutton><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button></form></td><td></td></tr>";

echo "</table>";


require_once("dfooter.php");

}



function addserialafter2() {
require_once("validate.php");
require("deps.php");
require("common.php");

$stockid = $_REQUEST['stockid'];
$itemserial = pv($_REQUEST['itemserial']);
$cart_item_id = $_REQUEST['cart_item_id'];

$qty = 1;

$availser = available_serials($stockid);
$availserl = array_map('strtolower', $availser);
if(in_array(strtolower("$itemserial"), $availserl) && !in_array("$itemserial", $availser)) {
$key = array_search(strtolower("$itemserial"), $availserl);
$itemserial = $availser[$key];
}

$rs_update_rc = "UPDATE cart SET itemserial = '$itemserial' WHERE cart_item_id = '$cart_item_id'";
$rs_find_stock_price = @mysqli_query($rs_connect, $rs_update_rc);


header("Location: cart.php");

}



switch($func) {
                                                                                                    
    default:
    show_cart();
    break;
                                
    case "add_item":
    add_item();
    break;

 case "add_noninv":
    add_noninv();
    break;

case "add_noninv2":
    add_noninv2();
    break;

    case "add_labor":
    add_labor();
    break;

    case "add_labor2":
    add_labor2();
    break;

    case "remove_cart_item":
    remove_cart_item();
    break;

    case "empty_cart":
    empty_cart();
    break;

    case "add_return":
    add_return();
    break;

    case "add_return5":
    add_return5();
    break;


    case "add_exchange":
    add_exchange();
    break;

    case "show_quote":
    show_quote();
    break;

    case "discount_cart_item":
    discount_cart_item();
    break;

    case "custom_price":
    custom_price();
    break;

   case "savecart":
    savecart();
    break;

  case "show_savecart":
    show_savecart();
    break;

 case "show_repcart":
    show_repcart();
    break;

 case "show_savecarts":
    show_savecarts();
    break;

  case "del_savecart":
    del_savecart();
    break;

 case "loadsavecart":
    loadsavecart();
    break;

case "copysavecart":
    copysavecart();
    break;

case "copycurrenttorepaircart":
    copycurrenttorepaircart();
    break;


 case "setusertax":
    setusertax();
    break;

case "setitemtax":
    setitemtax();
    break;

case "savecurrentcustomer":
    savecurrentcustomer();
    break;

case "clearcurrentcustomer":
    clearcurrentcustomer();
    break;

case "removedeposit":
    removedeposit();
    break;

case "pickcustomer":
    pickcustomer();
    break;

case "pickcustomer2":
    pickcustomer2();
    break;

case "addbyserial":
    addbyserial();
    break;

case "addbyserial2":
    addbyserial2();
    break;

case "edit":
    edit();
    break;

case "edit2":
    edit2();
    break;

case "removediscount":
    removediscount();
    break;

case "refundlabor":
    refundlabor();
    break;

case "spoaddcart":
    spoaddcart();
    break;

case "resyncprice":
    resyncprice();
    break;

case "editinvitem":
    editinvitem();
    break;

case "editinvitem2":
    editinvitem2();
    break;

case "addserialafter":
    addserialafter();
    break;

case "addserialafter2":
    addserialafter2();
    break;

}

?>
