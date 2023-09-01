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

                                                                                                    
function nothing() {
require_once("header.php");


require_once("footer.php");
                                                                                                    
}

function add_labor2() {
require_once("validate.php");
require("deps.php");
require("common.php");

$laborunitprice = $_REQUEST['laborprice'];
$labordesc = $_REQUEST['labordesc'];
$laborpdesc = $_REQUEST['laborpdesc'];
$pcwo = $_REQUEST['pcwo'];

if (array_key_exists('qty', $_REQUEST)) {
$qty = $_REQUEST['qty'];
} else {
$qty = 1;
}

$usertaxid = getusertaxid();
$taxrate = getservicetaxrate($usertaxid);

$laborprice = $laborunitprice * $qty;

$itemtax = $taxrate * $laborprice;

$labordescins = pv($labordesc);

$addtime = time();
$rs_insert_cart = "INSERT INTO repaircart (cart_price,cart_type,labor_desc,pcwo,taxex,itemtax,addtime,unit_price,quantity,printdesc) VALUES  ('$laborprice','labor','$labordescins','$pcwo','$usertaxid','$itemtax','$addtime','$laborunitprice','$qty','$laborpdesc')";
@mysqli_query($rs_connect, $rs_insert_cart);

header("Location: index.php?pcwo=$pcwo#repaircart");

}


function add_labor3() {
require_once("validate.php");
require("deps.php");
require("common.php");

$qlid = $_REQUEST['qlid'];
$pcwo = $_REQUEST['pcwo'];

if("$qlid" != "0") {

if (array_key_exists('qty', $_REQUEST)) {
$qty = $_REQUEST['qty'];
} else {
$qty = 1;
}


$rs_ql = "SELECT * FROM quicklabor WHERE quickid = '$qlid'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$labordesc = pv("$rs_result_q1->labordesc");
$laborpdesc = pv("$rs_result_q1->laborpdesc");
$laborunitprice = "$rs_result_q1->laborprice";

$laborprice = $laborunitprice * $qty;

$usertaxid = getusertaxid();
$taxrate = getservicetaxrate($usertaxid);

$itemtax = $taxrate * $laborprice;
$addtime = time();
$rs_insert_cart = "INSERT INTO repaircart (cart_price,cart_type,labor_desc,pcwo,taxex,itemtax,addtime,unit_price,quantity,printdesc) VALUES ('$laborprice','labor','$labordesc','$pcwo','$usertaxid','$itemtax','$addtime','$laborunitprice','$qty','$laborpdesc')";
@mysqli_query($rs_connect, $rs_insert_cart);

}

header("Location: index.php?pcwo=$pcwo#repaircart");

}



function add_item() {
require_once("validate.php");
require("deps.php");
require("common.php");


$stockid = $_REQUEST['stockid'];
$pcwo = $_REQUEST['pcwo'];

if ($stockid == "") {
die("Error - no stock id entered");
}

if (array_key_exists('qty', $_REQUEST)) {
$qty = $_REQUEST['qty'];
} else {
$qty = 1;
}


$usertaxid = getusertaxid();
$taxrate = getsalestaxrate($usertaxid);

$stockids = explode(" ", $stockid);

reset($stockids);
foreach($stockids as $key => $stocktoadd) {

$stockidsize = strlen($stocktoadd);

if ($stockidsize < 11) {
$rs_insert_stock = "SELECT * FROM stock WHERE stock_id = '$stocktoadd'";
$stocktoadd2 = "$stocktoadd";
} else {
$rs_insert_stock = "SELECT * FROM stock WHERE stock_upc = '$stocktoadd'";
}



$rs_find_stock_price = @mysqli_query($rs_connect, $rs_insert_stock);


if(mysqli_num_rows($rs_find_stock_price) == "0") {
die (pcrtlang("Sorry, that stock ID or UPC code does not exist"));
}


while($rs_find_result_q = mysqli_fetch_object($rs_find_stock_price)) {
$rs_unit_price = "$rs_find_result_q->stock_price";
$stocktoadd2 = "$rs_find_result_q->stock_id";
$ourprice = getourprice($stocktoadd2);

$rs_find_serial = "SELECT * FROM inventory WHERE stock_id = '$stocktoadd2' AND itemserial != ''";
$rs_find_serial_q = @mysqli_query($rs_connect, $rs_find_serial);
if(mysqli_num_rows($rs_find_serial_q) > 0) {
break 2;
}

$itemtax = $taxrate * $rs_unit_price * $qty;
$ourpricetotal = $ourprice * $qty;
$rs_price = $rs_unit_price * $qty;

$addtime = time();
$rs_insert_cart = "INSERT INTO repaircart (cart_price,cart_type,cart_stock_id,pcwo,taxex,itemtax,ourprice,addtime,unit_price,quantity) VALUES  ('$rs_price','purchase','$stocktoadd2','$pcwo','$usertaxid','$itemtax','$ourpricetotal','$addtime','$rs_unit_price','$qty')";
@mysqli_query($rs_connect, $rs_insert_cart);
	}                     
}


if(mysqli_num_rows($rs_find_serial_q) > 0) {
header("Location: repcart.php?func=addbyserial&stockid=$stocktoadd2&pcwo=$pcwo");
} else {
header("Location: index.php?pcwo=$pcwo#repaircart");
}

}





function addbyserial() {
require_once("validate.php");

require("deps.php");
require("common.php");

require_once("dheader.php");


echo "<div data-role=\"header\" data-theme=\"b\"><h2>".pcrtlang("Enter Serial/Code?")."</h2></div>";
echo "<div class=\"ui-content\" role=\"main\">";

$stockid = $_REQUEST['stockid'];
$pcwo = $_REQUEST['pcwo'];




$availser = available_serials($stockid);

echo "<form action=repcart.php?func=addbyserial2 method=post data-ajax=\"false\">";
if (count($availser) != 0) {
echo pcrtlang("Pick Serial").":<form action=repcart.php?func=addbyserial2 method=post>";
echo "<select name=itemserialchooser onchange='document.getElementById(\"itemserial\").value=this.options[this.selectedIndex].value '>";
echo "<option value=\"\">".pcrtlang("(optional) choose a serial/code or type one below")."</option>";
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
echo "<input type=text name=itemserial id=itemserial><input type=hidden name=stockid value=\"$stockid\"><input type=hidden name=pcwo value=\"$pcwo\">";

echo "<input type=submit value=\"".pcrtlang("Add to Cart")."\"  data-theme=\"b\"></form>";


echo "</div>";
require_once("dfooter.php");

}


function addbyserial2() {
require_once("validate.php");
require("deps.php");
require("common.php");

$stockid = $_REQUEST['stockid'];
$itemserial = pv($_REQUEST['itemserial']);
$pcwo = $_REQUEST['pcwo'];

$qty = 1;

if ($stockid == "") {
die(pcrtlang("Error - stock id missing"));
}

$usertaxid = getusertaxid();
$salestaxrate = getsalestaxrate($usertaxid);

$availser = available_serials($stockid);
$availserl = array_map('strtolower', $availser);
if(in_array(strtolower("$itemserial"), $availserl) && !in_array("$itemserial", $availser)) {
$key = array_search(strtolower("$itemserial"), $availserl);
$itemserial = $availser[$key];
}

$rs_insert_stock = "SELECT * FROM stock WHERE stock_id = '$stockid'";

$rs_find_stock_price = @mysqli_query($rs_connect, $rs_insert_stock);

while($rs_find_result_q = mysqli_fetch_object($rs_find_stock_price)) {
$rs_price = "$rs_find_result_q->stock_price";
$rs_stockid = "$rs_find_result_q->stock_id";

$ourprice = getourprice($rs_stockid);
$itemtax = $rs_price * $salestaxrate;
$addtime = time();
$rs_insert_cart = "INSERT INTO repaircart (cart_price,cart_type,cart_stock_id,pcwo,taxex,itemtax,ourprice,itemserial,addtime,unit_price,quantity) VALUES  ('$rs_price','purchase','$rs_stockid','$pcwo','$usertaxid','$itemtax','$ourprice','$itemserial','$addtime','$rs_price','$qty')";
@mysqli_query($rs_connect, $rs_insert_cart);
}


header("Location: index.php?pcwo=$pcwo#repaircart");

}


function remove_cart_item() {
require_once("validate.php");
require("deps.php");
require("common.php");

$cart_item_id = $_REQUEST['cart_item_id'];
$pcwo = $_REQUEST['pcwo'];





$rs_delete_cart = "DELETE FROM repaircart WHERE cart_item_id = '$cart_item_id'";
@mysqli_query($rs_connect, $rs_delete_cart);

header("Location: index.php?pcwo=$pcwo#repaircart");
}


function loadsavecart() {
require_once("validate.php");
require("deps.php");
require("common.php");

$pcwo = $_REQUEST['pcwo'];

$cfirstname = pv($_REQUEST['cfirstname']);
$caddress = pv($_REQUEST['caddress']);
$caddress2 = pv($_REQUEST['caddress2']);
$ccity = pv($_REQUEST['ccity']);
$cstate = pv($_REQUEST['cstate']);
$czip = pv($_REQUEST['czip']);
$cphone = pv($_REQUEST['cphone']);
$cemail = pv($_REQUEST['cemail']);
$cwoid = pv($_REQUEST['cwoid']);


if (array_key_exists('cinvoiceid',$_REQUEST)) {
$cinvoiceid = pv($_REQUEST['cinvoiceid']);
} else {
$cinvoiceid = "";
}





$rs_clear_cust = "DELETE FROM currentcustomer WHERE byuser = '$ipofpc'";
@mysqli_query($rs_connect, $rs_clear_cust);

$rs_insert_cust = "INSERT INTO currentcustomer (cfirstname,caddress,caddress2,ccity,cstate,czip,cphone,cemail,woid,invoiceid,byuser) VALUES ('$cfirstname','$caddress','$caddress2','$ccity','$cstate','$czip','$cphone','$cemail','$cwoid','$cinvoiceid','$ipofpc')";
@mysqli_query($rs_connect, $rs_insert_cust);

$rs_find_cart_items = "SELECT * FROM repaircart WHERE pcwo = '$pcwo'";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);
$rs_rm_cart = "DELETE FROM cart WHERE ipofpc = '$ipofpc'";
#@mysqli_query($rs_connect, $rs_rm_cart);


while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_cart_price = "$rs_result_q->cart_price";
$rs_cart_type = "$rs_result_q->cart_type";
$rs_cart_stock_id = "$rs_result_q->cart_stock_id";
$rs_labor_desc = pv($rs_result_q->labor_desc);
$rs_labor_pdesc = pv($rs_result_q->printdesc);
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

$rs_insert_cart = "INSERT INTO cart (cart_price,cart_type,cart_stock_id,labor_desc,return_sold_id,restocking_fee,price_alt,ipofpc,taxex,itemtax,origprice,discounttype,ourprice,itemserial,addtime,unit_price,quantity,printdesc,discountname) VALUES ('$rs_cart_price','$rs_cart_type','$rs_cart_stock_id','$rs_labor_desc','$rs_return_sold_id','$rs_restocking_fee','$rs_price_alt','$ipofpc','$rs_taxex','$rs_itemtax','$rs_origprice','$rs_discounttype','$rs_ourprice','$rs_itemserial','$rs_addtime','$rs_unit_price','$rs_quantity','$rs_labor_pdesc','$rs_discountname')";
@mysqli_query($rs_connect, $rs_insert_cart);

}
header("Location: ../storemobile/cart.php");
}

###########

function loadsavecartout() {
require_once("validate.php");                                                                                                                                                                                                         
require("deps.php");
require("common.php");

$pcwo = $_REQUEST['pcwo'];

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

if (array_key_exists('cinvoiceid',$_REQUEST)) {
$cinvoiceid = pv($_REQUEST['cinvoiceid']);
} else {
$cinvoiceid = "";
}





$rs_clear_cust = "DELETE FROM currentcustomer WHERE byuser = '$ipofpc'";
@mysqli_query($rs_connect, $rs_clear_cust);

$rs_insert_cust = "INSERT INTO currentcustomer (cfirstname,ccompany,caddress,caddress2,ccity,cstate,czip,cphone,cemail,woid,invoiceid,byuser) VALUES('$cfirstname','$ccompany','$caddress','$caddress2','$ccity','$cstate','$czip','$cphone','$cemail','$cwoid','$cinvoiceid','$ipofpc')";
@mysqli_query($rs_connect, $rs_insert_cust);

$rs_find_cart_items = "SELECT * FROM repaircart WHERE pcwo = '$pcwo'";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

$rs_rm_cart = "DELETE FROM cart WHERE ipofpc = '$ipofpc'";
@mysqli_query($rs_connect, $rs_rm_cart);

while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_cart_price = "$rs_result_q->cart_price";
$rs_cart_type = "$rs_result_q->cart_type";
$rs_cart_stock_id = "$rs_result_q->cart_stock_id";
$rs_labor_desc = pv($rs_result_q->labor_desc);
$rs_labor_pdesc = pv($rs_result_q->printdesc);
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

                                                                                                                             
$rs_insert_cart = "INSERT INTO cart (cart_price,cart_type,cart_stock_id,labor_desc,return_sold_id,restocking_fee,price_alt,ipofpc,taxex,itemtax,origprice,discounttype,ourprice,itemserial,addtime,unit_price,quantity,printdesc,discountname) VALUES ('$rs_cart_price','$rs_cart_type','$rs_cart_stock_id','$rs_labor_desc','$rs_return_sold_id','$rs_restocking_fee','$rs_price_alt','$ipofpc','$rs_taxex','$rs_itemtax','$rs_origprice','$rs_discounttype','$rs_ourprice','$rs_itemserial','$rs_addtime','$rs_unit_price','$rs_quantity','$rs_labor_pdesc','$rs_discountname')";
@mysqli_query($rs_connect, $rs_insert_cart);

userlog(2,$pcwo,'woid','');

                                                                                                                                                                                                  
}
header("Location: ../storemobile/cart.php");
}



function add_noninv() {
require_once("validate.php");

require("deps.php");
require("common.php");

$itemdesc = pv($_REQUEST['itemdesc']);
$itempdesc = pv($_REQUEST['itempdesc']);
$itemunitprice = $_REQUEST['itemprice'];
$ourprice = $_REQUEST['ourprice'];
$woid = $_REQUEST['woid'];
$itemserial = pv(trim($_REQUEST['itemserial']));

if (array_key_exists('qty', $_REQUEST)) {
$qty = $_REQUEST['qty'];
if($itemserial != "") {
$qty = 1;
}
} else {
$qty = 1;
}


$usertaxid = getusertaxid();
$taxrate = getsalestaxrate($usertaxid);
$itemprice = $itemunitprice * $qty;
$itemtax = $taxrate * $itemprice;
$ourpricetotal = $ourprice * $qty;

$addtime = time();



$rs_insert_cart = "INSERT INTO repaircart (cart_price,cart_type,labor_desc,pcwo,taxex,itemtax,ourprice,itemserial,addtime,unit_price,quantity,printdesc) VALUES ('$itemprice','purchase','$itemdesc','$woid','$usertaxid','$itemtax','$ourpricetotal','$itemserial','$addtime','$itemunitprice','$qty','$itempdesc')";
@mysqli_query($rs_connect, $rs_insert_cart);

header("Location: index.php?pcwo=$woid#repaircart");


}



###########

function setitemtax() {
require_once("validate.php");
require("deps.php");
require("common.php");

$settaxid = $_REQUEST['settaxid'];
$cart_item_id = $_REQUEST['cart_item_id'];
$cartitemtype = $_REQUEST['cartitemtype'];
$woid = $_REQUEST['woid'];

if ($cartitemtype == "labor") {
$taxrate = getservicetaxrate($settaxid);
} else {
$taxrate = getsalestaxrate($settaxid);
}





$rs_rm_cart = "UPDATE repaircart SET taxex = '$settaxid', itemtax = (cart_price * $taxrate) WHERE cart_item_id = $cart_item_id";
@mysqli_query($rs_connect, $rs_rm_cart);

header("Location: index.php?pcwo=$woid#repaircart");
}


function add_discount() {
require_once("validate.php");
require("deps.php");

require_once("common.php");
require("dheader.php");

$rs_cart_item_id = $_REQUEST['cart_item_id'];
$woid = $_REQUEST['woid'];
$rs_taxex = $_REQUEST['rs_taxex'];
$carttype = $_REQUEST['rs_cart_type'];
$rs_cart_price = $_REQUEST['rs_cart_price'];
$itemdesc = $_REQUEST['itemdesc'];
$qty = $_REQUEST['qty'];


echo "<div data-role=\"header\" data-theme=\"b\"><h2>".pcrtlang("Add Discount")."</h2></div>";
echo "<div class=\"ui-content\" role=\"main\">";

echo "<h3>".pcrtlang("Add Discount to").":$itemdesc</h3>";
echo pcrtlang("Original Price").": $money".mf("$rs_cart_price");

echo "<br><h3>".pcrtlang("Percentage Discount")."</h3>";
echo "<form method=post action=repcart.php?func=discount_cart_item data-ajax=\"false\"><input type=hidden name=cart_item_id value=$rs_cart_item_id><input type=hidden name=rs_taxex value=$rs_taxex>";
echo "<input type=hidden name=carttype value=\"$carttype\"><input type=hidden name=qty value=$qty><input type=hidden name=woid value=$woid>";
echo "<input type=text placeholder=\"".pcrtlang("Enter Percentage")."\" name=rs_dis_percent id=percentdiscount$rs_cart_item_id>";

echo "<br><input type=text name=discountname id=discountname$rs_cart_item_id placeholder=\"".pcrtlang("Enter Discount Name")."\"><br>";

echo "<select name=myoptions onchange='document.getElementById(\"percentdiscount$rs_cart_item_id\").value=this.options[this.selectedIndex].value;
document.getElementById(\"discountname$rs_cart_item_id\").value=this.options[this.selectedIndex].text'>";
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

echo "<br>";
echo "<h3>".pcrtlang("Nominal Discount")."</h3>";
echo "<form method=post action=repcart.php?func=custom_price data-ajax=\"false\"><input type=hidden name=cart_item_id value=$rs_cart_item_id><input type=hidden name=rs_taxex value=$rs_taxex>";
echo "<input type=hidden name=carttype value=\"$carttype\"><input type=hidden name=qty value=$qty><input type=hidden name=woid value=$woid>";
echo "<input size=6 type=text name=custom_price id=customprice$rs_cart_item_id value=\"".mf("$rs_cart_price")."\">";
echo "<br><input type=text name=discountname id=discountnamen$rs_cart_item_id placeholder=\"".pcrtlang("Enter Discount Name")."\"><br>";

################
echo "<select name=myoptions onchange='document.getElementById(\"customprice$rs_cart_item_id\").value=($rs_cart_price"." - this.options[this.selectedIndex].value).toFixed(2); document.getElementById(\"discountnamen$rs_cart_item_id\").value=this.options[this.selectedIndex].text'>";
$rs_ql = "SELECT * FROM discounts WHERE discounttype = '2' AND discountamount <= '$rs_cart_price' ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
echo "<option value=\"$rs_cart_price\">".pcrtlang("Choose Discount")."</option>";
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$discountid = "$rs_result_q1->discountid";
$discounttitle = "$rs_result_q1->discounttitle";
$discountamount = "$rs_result_q1->discountamount";
$discounttype = "$rs_result_q1->discounttype";
echo "<option value=\"$discountamount\">$discounttitle</option>";
}
echo "</select>";

echo "<br><button type=reset><i class=\"fa fa-eraser\"></i> ".pcrtlang("Reset")."</button>";
echo "<button type=submit onclick=\"this.disabled=true; this.form.submit();\"><i class=\"fa fa-plus\"></i> ".pcrtlang("Set Custom Price")."</button>";

#########
echo "</form>";




echo "</div>";
require_once("dfooter.php");

}




function discount_cart_item() {
require_once("validate.php");

require("deps.php");
require("common.php");

$cart_item_id = $_REQUEST['cart_item_id'];
$rs_dis_percent = $_REQUEST['rs_dis_percent'];
$taxex = $_REQUEST['rs_taxex'];
$carttype = $_REQUEST['carttype'];
$woid = $_REQUEST['woid'];
$discountname = $_REQUEST['discountname'];

if ($carttype == "labor") {
$itemtax = getservicetaxrate($taxex);
} else {
$itemtax = getsalestaxrate($taxex);
}

$rs_discount_cart3 = "UPDATE repaircart SET origprice = cart_price, discounttype = 'percent|$rs_dis_percent', discountname = '$discountname' WHERE cart_item_id = '$cart_item_id'";
@mysqli_query($rs_connect, $rs_discount_cart3);

$rs_discount_cart = "UPDATE repaircart SET cart_price = (cart_price * ((100 - $rs_dis_percent) * .01)) , price_alt = '1' WHERE cart_item_id = '$cart_item_id'";
@mysqli_query($rs_connect, $rs_discount_cart);

$rs_discount_cart2 = "UPDATE repaircart SET itemtax = (cart_price * $itemtax)  WHERE cart_item_id = '$cart_item_id'";
@mysqli_query($rs_connect, $rs_discount_cart2);

$rs_discount_cart3 = "UPDATE repaircart SET unit_price = (unit_price * ((100 - $rs_dis_percent) * .01)) WHERE cart_item_id = '$cart_item_id'";
@mysqli_query($rs_connect, $rs_discount_cart3);

header("Location: index.php?pcwo=$woid#repaircart");
}


function custom_price() {
require_once("validate.php");
require("deps.php");
require("common.php");

$cart_item_id = $_REQUEST['cart_item_id'];
$custom_unit_price = $_REQUEST['custom_price'];
$taxex = $_REQUEST['rs_taxex'];
$woid = $_REQUEST['woid'];
$qty = $_REQUEST['qty'];
$discountname = $_REQUEST['discountname'];

$carttype = $_REQUEST['carttype'];

if ($carttype == "labor") {
$itemtaxrate = getservicetaxrate($taxex);
} else {
$itemtaxrate = getsalestaxrate($taxex);
}

$custom_price = $custom_unit_price * $qty;

$itemtax = $custom_price * $itemtaxrate;

$rs_discount_cart2 = "UPDATE repaircart SET origprice = cart_price, discounttype = 'custom|na', discountname = '$discountname' WHERE cart_item_id = '$cart_item_id'";
@mysqli_query($rs_connect, $rs_discount_cart2);

$rs_discount_cart = "UPDATE repaircart SET cart_price = '$custom_price', price_alt = '1', itemtax = '$itemtax', unit_price = '$custom_unit_price' WHERE cart_item_id = '$cart_item_id'";
@mysqli_query($rs_connect, $rs_discount_cart);

header("Location: index.php?pcwo=$woid#repaircart");
}


function edit() {
require_once("validate.php");
require("deps.php");

require_once("common.php");
require("dheader.php");

$rs_cart_item_id = $_REQUEST['cart_item_id'];
$woid = $_REQUEST['woid'];
$rs_taxex = $_REQUEST['rs_taxex'];
$carttype = $_REQUEST['rs_cart_type'];
$rs_cart_price = $_REQUEST['rs_cart_price'];
$itemdesc = $_REQUEST['itemdesc'];
$itempdesc = $_REQUEST['itempdesc'];
$serial = $_REQUEST['serial'];
$price_alt = $_REQUEST['price_alt'];
$cost = mf($_REQUEST['cost']);
$qty = qf($_REQUEST['qty']);


echo "<div data-role=\"header\" data-theme=\"b\"><h2>".pcrtlang("Edit Cart Item")."</h2></div>";
echo "<div class=\"ui-content\" role=\"main\">";


echo pcrtlang("Original Price").": <span class=colormeblue>$money".mf("$rs_cart_price")."</span><br><br>";

echo "<form method=post action=repcart.php?func=edit2 name=newinv data-ajax=\"false\"><input type=hidden name=cart_item_id value=$rs_cart_item_id><input type=hidden name=woid value=$woid>";
echo "<input type=hidden name=rs_taxex value=$rs_taxex><input type=hidden name=carttype value=\"$carttype\">";

if($carttype == "purchase") {
if($serial != "") {
echo pcrtlang("Quantity").":".qf("$qty")."<input type=hidden name=qty value=\"$qty\">";
} else {
echo pcrtlang("Quantity").":<input type=number name=qty value=\"".qf("$qty")."\" min=1 step=1>";
}
echo pcrtlang("Item title").":<input type=text name=itemdesc value=\"$itemdesc\">";
echo pcrtlang("Optional Printed Item Description").":<textarea name=itempdesc>$itempdesc</textarea>";

if($qty == 1) {
echo pcrtlang("Serial/Code").":<input type=text name=serial value=\"$serial\">";
} else {
echo "<input type=hidden name=serial value=\"\">";
}

} else {
echo pcrtlang("Quantity").":<input type=number name=qty value=\"".qf("$qty")."\" min=\".01\" step=\".01\">";
echo pcrtlang("Labor Description").":<input type=text name=itemdesc value=\"$itemdesc\">";
}


if($price_alt != "1") {
echo pcrtlang("Price").":<input type=text name=price value=\"".mf("$rs_cart_price")."\">";
if($carttype == "purchase") {
echo pcrtlang("Cost").":<input type=text name=cost value=\"$cost\">";

if($cost == 0) {
$markup = "X";
} else {
if($rs_cart_price < ($cost * 1.99)) {
$markup = round(($rs_cart_price / $cost) - 1, 2) * 100;
$markup .= "&#37;";
} else {
$markup = round(($rs_cart_price / $cost), 2);
$markup .= "X";
}
}

echo pcrtlang("Current Markup").": <span class=colormeblue>$markup</span> <span class=\"sizemesmaller\">(".pcrtlang("based on cost price").")</span>";

echo pcrtlang("Markup").":";

?>

<script>
function markup() {
var marknum = Math.ceil((document.newinv.cost.value - 0) * (document.newinv.chooser.value - 0)) - document.newinv.cents.value;
document.newinv.price.value = marknum.toFixed(2);
}
</script>

<?php

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
echo "<br><input type=submit value=\"".pcrtlang("Save")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Saving")."...'; this.form.submit();\"></form>";




echo "</div>";
require_once("dfooter.php");

}


function edit2() {

require("deps.php");
require("common.php");

require_once("validate.php");

$cart_item_id = $_REQUEST['cart_item_id'];
$carttype = $_REQUEST['carttype'];
$taxex = $_REQUEST['rs_taxex'];
$woid = $_REQUEST['woid'];
$itemdesc = pv($_REQUEST['itemdesc']);
$itempdesc = pv($_REQUEST['itempdesc']);
$price = $_REQUEST['price'];
$qty = $_REQUEST['qty'];
$totalprice = $price * $qty;


$rs_find_cart_item = "SELECT * FROM repaircart WHERE cart_item_id = '$cart_item_id'";
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
$serial = pv($_REQUEST['serial']);
$salestaxrate = getsalestaxrate($taxex);
$itemtax = $price * $salestaxrate * $qty;

if(($qty != 1) && ($serial != "")) {
die(pcrtlang("Error: Quantity on an item with a serial number must be 1"));
}

$rs_setprice_cart = "UPDATE repaircart SET cart_price = '$totalprice', itemtax = '$itemtax', labor_desc = '$itemdesc', 
ourprice = '$cost', itemserial = '$serial', origprice = '$neworigprice', unit_price = '$price', quantity = '$qty' WHERE cart_item_id = '$cart_item_id'";
@mysqli_query($rs_connect, $rs_setprice_cart);

} else {

$servicetaxrate = getservicetaxrate($taxex);
$servicetax = $price * $servicetaxrate * $qty;

$rs_setprice_cart = "UPDATE repaircart SET cart_price = '$totalprice', itemtax = '$servicetax', labor_desc = '$itemdesc', origprice = '$neworigprice', unit_price = '$price', quantity = '$qty', printdesc = '$itempdesc'  WHERE cart_item_id = '$cart_item_id'";
@mysqli_query($rs_connect, $rs_setprice_cart);


}

header("Location: index.php?pcwo=$woid#repaircart");
}

function removediscount() {
require_once("validate.php");
require("deps.php");
require("common.php");

$cart_item_id = $_REQUEST['cart_item_id'];
$woid = $_REQUEST['woid'];




$rs_find_cart_item = "SELECT * FROM repaircart WHERE cart_item_id = '$cart_item_id'";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_item);
$rs_result_q = mysqli_fetch_object($rs_result);
$rs_cart_type = "$rs_result_q->cart_type";
$rs_price_alt = "$rs_result_q->price_alt";
$rs_taxex = "$rs_result_q->taxex";
$rs_origprice = "$rs_result_q->origprice";
$unit_price = "$rs_result_q->unit_price";
$quantity = "$rs_result_q->quantity";

if($rs_origprice != 0) {
$rs_orig_unit_price = $rs_origprice / $quantity;
} else {
$rs_orig_unit_price = 0;
}


if($rs_cart_type == "purchase") {
$salestaxrate = getsalestaxrate($rs_taxex);
$itemtax = $rs_origprice * $salestaxrate;

$rs_setprice_cart = "UPDATE repaircart SET cart_price = '$rs_origprice', itemtax = '$itemtax', discounttype = '', origprice = '0', price_alt = '0', unit_price = '$rs_orig_unit_price', discountname = '' WHERE cart_item_id = '$cart_item_id'";
@mysqli_query($rs_connect, $rs_setprice_cart);

} else {

$servicetaxrate = getservicetaxrate($rs_taxex);
$servicetax = $rs_origprice * $servicetaxrate;

$rs_setprice_cart = "UPDATE repaircart SET cart_price = '$rs_origprice', itemtax = '$servicetax', discounttype = '', origprice = '0', price_alt = '0', unit_price = '$rs_orig_unit_price', discountname = '' WHERE cart_item_id = '$cart_item_id'";
@mysqli_query($rs_connect, $rs_setprice_cart);

}

header("Location: index.php?pcwo=$woid#repaircart");
}



function loadsavecartout_multiple() {
require_once("validate.php");
require("deps.php");
require("common.php");

$checkoutwo = $_REQUEST['checkoutwo'];
$wotopullcontact = $checkoutwo[0];


$rs_findpc = "SELECT * FROM pc_wo WHERE woid = '$wotopullcontact'";
$rs_result = mysqli_query($rs_connect, $rs_findpc);
$rs_result_q = mysqli_fetch_object($rs_result);
$pcid = "$rs_result_q->pcid";



$rs_findowner = "SELECT * FROM pc_owner WHERE pcid = '$pcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
$rs_result_q2 = mysqli_fetch_object($rs_result2);
$cfirstname = "$rs_result_q2->pcname";
$ccompany = "$rs_result_q2->pccompany";
$cphone = "$rs_result_q2->pcphone";
$cemail = "$rs_result_q2->pcemail";
$caddress = "$rs_result_q2->pcaddress";
$caddress2 = "$rs_result_q2->pcaddress2";
$ccity = "$rs_result_q2->pccity";
$cstate = "$rs_result_q2->pcstate";
$czip = "$rs_result_q2->pczip";



if (array_key_exists('cinvoiceid',$_REQUEST)) {
$cinvoiceid = pv($_REQUEST['cinvoiceid']);
} else {
$cinvoiceid = "";
}

reset($checkoutwo);

$cwoid = implode_list($checkoutwo);




$rs_clear_cust = "DELETE FROM currentcustomer WHERE byuser = '$ipofpc'";
@mysqli_query($rs_connect, $rs_clear_cust);

$rs_insert_cust = "INSERT INTO currentcustomer (cfirstname,caddress,caddress2,ccity,cstate,czip,cphone,cemail,woid,invoiceid,byuser) VALUES('$cfirstname','$caddress','$caddress2','$ccity','$cstate','$czip','$cphone','$cemail','$cwoid','$cinvoiceid','$ipofpc')";
@mysqli_query($rs_connect, $rs_insert_cust);


$rs_rm_cart = "DELETE FROM cart WHERE ipofpc = '$ipofpc'";
@mysqli_query($rs_connect, $rs_rm_cart);

reset($checkoutwo);

foreach($checkoutwo as $key => $pcwo) {

$rs_find_cart_items = "SELECT * FROM repaircart WHERE pcwo = '$pcwo'";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_cart_price = "$rs_result_q->cart_price";
$rs_cart_type = "$rs_result_q->cart_type";
$rs_cart_stock_id = "$rs_result_q->cart_stock_id";
$rs_labor_desc = pv($rs_result_q->labor_desc);
$rs_labor_pdesc = pv($rs_result_q->printdesc);
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


$rs_insert_cart = "INSERT INTO cart (cart_price,cart_type,cart_stock_id,labor_desc,return_sold_id,restocking_fee,price_alt,ipofpc,taxex,itemtax,origprice,discounttype,ourprice,itemserial,addtime,unit_price,quantity,printdesc,discountname) VALUES ('$rs_cart_price','$rs_cart_type','$rs_cart_stock_id','$rs_labor_desc','$rs_return_sold_id','$rs_restocking_fee','$rs_price_alt','$ipofpc','$rs_taxex','$rs_itemtax','$rs_origprice','$rs_discounttype','$rs_ourprice','$rs_itemserial','$rs_addtime','$rs_unit_price','$rs_quantity','$rs_labor_pdesc','$rs_discountname')";
@mysqli_query($rs_connect, $rs_insert_cart);

$rs_check = "UPDATE pc_wo SET pickupdate = '$currentdatetime', cobyuser = '$ipofpc' WHERE woid = '$pcwo'";
@mysqli_query($rs_connect, $rs_check);


}


}
header("Location: ../storemobile/cart.php");
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
$unit_price = mf("$rs_result_item_q->unit_price");
$quantity = "$rs_result_item_q->quantity";


$usertaxid = getusertaxid();
$taxrate = getsalestaxrate($usertaxid);
$itemtax = $taxrate * $spoprice;

$addtime = time();

$rs_insert_cart = "INSERT INTO repaircart (cart_price,cart_type,labor_desc,pcwo,taxex,itemtax,ourprice,addtime,unit_price,quantity,printdesc) VALUES ('$spoprice','purchase','$spopartname','$spowoid','$usertaxid','$itemtax','$spocost','$addtime','$unit_price','$quantity','$spoprintdesc')";
@mysqli_query($rs_connect, $rs_insert_cart);


header("Location: index.php?pcwo=$spowoid#repaircart");

}


function addmiles() {
require_once("validate.php");
require("deps.php");
require("common.php");

$miles = $_REQUEST['miles'];
$permile = $_REQUEST['permile'];
$pcwo = $_REQUEST['pcwo'];



$usertaxid = getusertaxid();
$taxrate = getservicetaxrate($usertaxid);

$laborprice = $miles * $permile;
$itemtax = $taxrate * $laborprice;

if($pcrt_units != "METRIC") {
$distlab = pcrtlang("miles");
$distlab2= pcrtlang("mile");
} else {
$distlab = pcrtlang("km");
$distlab2 = pcrtlang("km");
}


$labordesc = pcrtlang("Mileage Charge")." (".pcrtlang("per $distlab2").")";

$labordescins = pv($labordesc);


$addtime = time();
$rs_insert_cart = "INSERT INTO repaircart (cart_price,cart_type,labor_desc,pcwo,taxex,itemtax,addtime,unit_price,quantity) VALUES ('$laborprice','labor','$labordescins','$pcwo','$usertaxid','$itemtax','$addtime','$permile','$miles')";
@mysqli_query($rs_connect, $rs_insert_cart);

header("Location: index.php?pcwo=$pcwo#repaircart");

}




function editinvitem() {
require("deps.php");

require_once("common.php");
require_once("validate.php");
require("dheader.php");

$woid = $_REQUEST['woid'];
$rs_cart_item_id = $_REQUEST['cart_item_id'];
$rs_taxex = $_REQUEST['rs_taxex'];
$rs_cart_price = $_REQUEST['rs_cart_price'];
$price_alt = $_REQUEST['price_alt'];
$cost = $_REQUEST['cost'];
$qty = $_REQUEST['qty'];

dheader(pcrtlang("Edit Cart Item"));

echo "<form method=post action=repcart.php?func=editinvitem2 name=editinvitem2 id=editform  data-ajax=\"false\"><input type=hidden name=cart_item_id value=$rs_cart_item_id>";
echo "<input type=hidden name=rs_taxex value=$rs_taxex><input type=hidden name=cost value=$cost><input type=hidden name=woid value=$woid>";
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

$woid = $_REQUEST['woid'];
$cart_item_id = $_REQUEST['cart_item_id'];
$taxex = $_REQUEST['rs_taxex'];
$qty = $_REQUEST['qty'];

$rs_find_cart_item = "SELECT * FROM repaircart WHERE cart_item_id = '$cart_item_id'";
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

$rs_setprice_cart = "UPDATE repaircart SET cart_price = '$totalprice', unit_price = '$unit_price', quantity = '$qty', itemtax = '$itemtax', ourprice = '$cost',
origprice = '$neworigprice' WHERE cart_item_id = '$cart_item_id'";
@mysqli_query($rs_connect, $rs_setprice_cart);

header("Location: index.php?pcwo=$woid#repaircart");
}


function addserialafter() {
require_once("validate.php");

require("deps.php");
require("common.php");

require("dheader.php");

dheader(pcrtlang("Enter Serial/Code?"));

$stockid = $_REQUEST['stockid'];
$pcwo = $_REQUEST['pcwo'];
$cart_item_id = $_REQUEST['cart_item_id'];

$availser = available_serials($stockid);

echo "<form action=repcart.php?func=addserialafter2 method=post data-ajax=\"false\"><table>";
if (count($availser) != 0) {
echo "<tr><td>".pcrtlang("Pick Serial").":<form action=repcart.php?func=addserialafter2 method=post></td>";
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
echo "<td><input type=text name=itemserial id=itemserial><input type=hidden name=stockid value=\"$stockid\"><input type=hidden name=pcwo value=\"$pcwo\"></td></tr>";
echo "<tr><td><input type=hidden name=cart_item_id value=\"$cart_item_id\"><button type=submit id=editbutton><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button></form></td><td></td></tr>";

echo "</table>";

dfooter();
require_once("dfooter.php");

}



function addserialafter2() {
require_once("validate.php");
require("deps.php");
require("common.php");

$stockid = $_REQUEST['stockid'];
$itemserial = pv($_REQUEST['itemserial']);
$pcwo = $_REQUEST['pcwo'];
$cart_item_id = $_REQUEST['cart_item_id'];

$qty = 1;

$availser = available_serials($stockid);
$availserl = array_map('strtolower', $availser);
if(in_array(strtolower("$itemserial"), $availserl) && !in_array("$itemserial", $availser)) {
$key = array_search(strtolower("$itemserial"), $availserl);
$itemserial = $availser[$key];
}

$rs_update_rc = "UPDATE repaircart SET itemserial = '$itemserial' WHERE cart_item_id = '$cart_item_id'";
$rs_find_stock_price = @mysqli_query($rs_connect, $rs_update_rc);


header("Location: index.php?pcwo=$pcwo#repaircart");

}




switch($func) {
                                                                                                    
    default:
    nothing();
    break;
                                
    case "add_labor2":
    add_labor2();
    break;

    case "add_labor3":
    add_labor3();
    break;

    case "add_item":
    add_item();
    break;
                                   
    case "remove_cart_item":
    remove_cart_item();
    break;
                                 
    case "loadsavecart":
    loadsavecart();
    break;

 case "loadsavecartout":
    loadsavecartout();
    break;

 case "add_noninv":
    add_noninv();
    break;

case "setitemtax":
    setitemtax();
    break;

case "addbyserial":
    addbyserial();
    break;

case "addbyserial2":
    addbyserial2();
    break;

case "add_discount":
    add_discount();
    break;

case "discount_cart_item":
    discount_cart_item();
    break;

case "custom_price":
    custom_price();
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

 case "loadsavecartout_multiple":
    loadsavecartout_multiple();
    break;

 case "spoaddcart":
    spoaddcart();
    break;

 case "addmiles":
    addmiles();
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
