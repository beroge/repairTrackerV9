<?php

/***************************************************************************
 *   copyright            : (C) 2012 PCRepairTracker.com
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

                                                                                                    
function add_new_stock() {
require("deps.php");
require_once("common.php");
require("dheader.php");

perm_boot("6");

dheader(pcrtlang("Add New Stock"));

echo "<i class=\"fa fa-warning fa-lg\"></i> ".pcrtlang("Do not add items that have been previously stocked here!")."<br><br>";

echo "<form action=stock.php?func=add_new_stock2 method=post name=newinv data-ajax=\"false\">";
echo pcrtlang("Name of Product").":<input type=text name=productname>";
echo pcrtlang("Product UPC")."#<input type=text name=productupc>";
echo pcrtlang("Product Category").":<select name=category>";





$rs_insert_main_cat = "SELECT * FROM maincats ORDER BY cat_name ASC";
$rs_result = mysqli_query($rs_connect, $rs_insert_main_cat);

while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_catid = "$rs_result_q->cat_id";
$rs_catname = "$rs_result_q->cat_name";

$rs_find_sub_cat = "SELECT * FROM sub_cats WHERE sub_cat_parent = '$rs_catid' ORDER BY sub_cat_name ASC";
$rs_find_result = mysqli_query($rs_connect, $rs_find_sub_cat);

while($rs_find_result_q = mysqli_fetch_object($rs_find_result)) {
$rs_subcatid = "$rs_find_result_q->sub_cat_id";
$rs_subcatname = "$rs_find_result_q->sub_cat_name";

echo "<option value=$rs_subcatid>$rs_catname -> $rs_subcatname</option>";

}



}

echo "</select>";

?>

<script>
function markup() {
var marknum = Math.ceil((document.newinv.ourprice.value - 0) * (document.newinv.chooser.value - 0)) - document.newinv.cents.value;
document.newinv.sellprice.value = marknum.toFixed(2);
}
</script>

<?php


echo pcrtlang("Product Description").":<textarea name=prod_desc></textarea>";
echo pcrtlang("Printed Description").":<textarea name=stock_pdesc></textarea>";
echo pcrtlang("Selling Price").":<input type=text name=sellprice id=sellprice>";

$usertaxid = getusertaxid();
$salestaxrateremain = (1 + getsalestaxrate($usertaxid));
if($salestaxrateremain != 1) {
echo "<button class=button type=button title=\"".pcrtlang("Pre-Tax Calculator")."\" onclick='document.getElementById(\"sellprice\").value=(document.getElementById(\"sellprice\").value / $salestaxrateremain).toFixed(5)'>
<i class=\"fa fa-calculator\"></i> ".pcrtlang("Calculate Pre-Tax")."</button>";
}

echo pcrtlang("Our Cost").":<input type=text name=ourprice>";

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
<option selected value=\"0.01\">99 ".pcrtlang("cents")."</option>
<option value=\"00\">00 ".pcrtlang("cents")."</option>
</select>";




echo pcrtlang("Quantity to Stock").":<br><font class=em90>".pcrtlang("Enter serials and codes one per line").".</font><br><br>";

$rs_find_stores = "SELECT * FROM stores WHERE storeenabled = '1' ORDER BY storesname ASC";
$rs_result_stores = mysqli_query($rs_connect, $rs_find_stores);
while($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
$rs_storesname = "$rs_result_storeq->storesname";
$rs_storeid = "$rs_result_storeq->storeid";

echo "$rs_storesname: <input type=text name=store$rs_storeid value=0>";
echo pcrtlang("serials/codes").":<textarea name=storeserial$rs_storeid></textarea>";

}

echo pcrtlang("Pick Supplier").":<select name=supplierid>";

echo "<option value=0>".pcrtlang("Manually Entered Supplier")."</option>";

$rs_find_suppliers = "SELECT * FROM suppliers ORDER BY suppliername ASC";
$rs_result_supp = mysqli_query($rs_connect, $rs_find_suppliers);

while($rs_result_suppq = mysqli_fetch_object($rs_result_supp)) {
$suppliername = "$rs_result_suppq->suppliername";
$supplierid = "$rs_result_suppq->supplierid";

echo "<option value=$supplierid>$suppliername</option>";

}
echo "</select>";

echo pcrtlang("Supplier Name")."<input type=text name=suppliername>";
echo pcrtlang("Supplier Part No.")."<input type=text name=partnumber>";
echo pcrtlang("Part URL")."<input type=text name=parturl>";


echo "<input type=submit value=\"".pcrtlang("Add New Item")."\"  data-theme=\"b\" onclick=\"this.disabled=true;this.value='".pcrtlang("Adding New Item")."...'; this.form.submit();\">";


dfooter();
require_once("dfooter.php");

                                                                                                    
}

function add_new_stock2() {
require_once("validate.php");

require("deps.php");
require("common.php");

perm_boot("6");

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

$productname = pv($_REQUEST['productname']);
$category = $_REQUEST['category'];
$prod_desc = pv($_REQUEST['prod_desc']);
$stock_pdesc = pv($_REQUEST['stock_pdesc']);
$sellprice = $_REQUEST['sellprice'];
$ourprice = $_REQUEST['ourprice'];
$productupc = pv($_REQUEST['productupc']);
$partnumber = pv($_REQUEST['partnumber']);
$parturl = pv($_REQUEST['parturl']);
$suppliername = pv($_REQUEST['suppliername']);
$supplierid = $_REQUEST['supplierid'];





#####


######

$rs_insert_stock = "INSERT INTO stock (stock_title,stock_desc,stock_cat,stock_price,stock_upc,avg_cost,stock_pdesc) VALUES ('$productname','$prod_desc','$category','$sellprice','$productupc','$ourprice','$stock_pdesc')";
@mysqli_query($rs_connect, $rs_insert_stock);
                               
$lastinsert = mysqli_insert_id($rs_connect);

######

checkstorecount($lastinsert);

$rs_find_stores = "SELECT * FROM stores WHERE storeenabled = '1' ORDER BY storesname ASC";
$rs_result_stores = mysqli_query($rs_connect, $rs_find_stores);
while($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
$rs_storeid = "$rs_result_storeq->storeid";

$thecount =  $_REQUEST["store$rs_storeid"];
if (is_numeric("$thecount")) {
$rs_insert_stock = "UPDATE stockcounts SET quantity = quantity+$thecount WHERE stockid = '$lastinsert' AND storeid = '$rs_storeid'";
@mysqli_query($rs_connect, $rs_insert_stock);

if ($thecount > 0) {
$itemserial = pv($_REQUEST["storeserial$rs_storeid"]);
$rs_insert_inv = "INSERT INTO inventory (stock_id,inv_price,inv_quantity,inv_date,storeid,itemserial,supplierid,suppliername,parturl,partnumber) VALUES  ('$lastinsert','$ourprice','$thecount','$currentdatetime','$rs_storeid','$itemserial','$supplierid','$suppliername','$parturl','$partnumber')";
@mysqli_query($rs_connect, $rs_insert_inv);
}
}

}




#####


updatecategories();

header("Location: stock.php?func=show_stock_detail&stockid=$lastinsert");
                                                                                                                             
}

function show_stock() {

$category = $_REQUEST['category'];
                    
require("header.php");
require("deps.php");
                                                                                                               




$rs_show_stock = "SELECT MAX(stockcounts.quantity),stock.stock_id,stock.stock_title,stock.stock_desc,stock.stock_price,stock.stock_upc FROM stock,stockcounts WHERE stock.stock_cat = '$category' AND stock.dis_cont = 0 AND stock.stock_id = stockcounts.stockid AND stockcounts.quantity > '0' GROUP BY stock.stock_id";

$rs_stock_result = mysqli_query($rs_connect, $rs_show_stock);
                                                                                                                                               
while($rs_stock_result_q = mysqli_fetch_object($rs_stock_result)) {
$rs_stockid = "$rs_stock_result_q->stock_id";
$rs_stocktitle = "$rs_stock_result_q->stock_title";
$rs_stockdesc = "$rs_stock_result_q->stock_desc";
$rs_stockprice = "$rs_stock_result_q->stock_price";
$rs_stockupc = "$rs_stock_result_q->stock_upc";

checkstorecount($rs_stockid);

echo "<table class=standard><tr><th>$rs_stocktitle</th></tr>";

echo "<tr><td>";

if ($rs_stockupc != 0) {
echo "Item UPC# $rs_stockupc<br><br>";
}


$rs_find_stores = "SELECT * FROM stores WHERE storeenabled = '1' AND storeid = '$defaultuserstore' ORDER BY storesname ASC";
$rs_result_stores = mysqli_query($rs_connect, $rs_find_stores);
while($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
$rs_storesname = "$rs_result_storeq->storesname";
$rs_storeid = "$rs_result_storeq->storeid";

$rs_find_stock = "SELECT * FROM stockcounts WHERE storeid = '$defaultuserstore' AND stockid = '$rs_stockid'";
$rs_result_stock = mysqli_query($rs_connect, $rs_find_stock);
$rs_result_stockq = mysqli_fetch_object($rs_result_stock);
$stockqty = "$rs_result_stockq->quantity";

$stockqtyarray[$rs_storeid] = $stockqty;

echo "$rs_storesname ".pcrtlang("Stock").": $stockqty";

}

echo "<br><strong>".pcrtlang("Price").": $money".mf("$rs_stockprice")."</strong><br>";

echo "<br><strong>".pcrtlang("Qty")."</strong><br>";

echo "<form action=cart.php?func=add_item method=post data-ajax=\"false\"><input type=hidden name=stockid value=$rs_stockid>";
echo "<input type=number style=\"width:50px;\" name=\"qty\" value=\"1\" min=\"1\" step=\"1\"> ";
echo "<button type=submit><i class=\"fa fa-cart-plus fa-lg\"></i> ".pcrtlang("Add Item to Cart")."</button>";
echo "</form>";
echo "<button type=button onClick=\"parent.location='stock.php?func=show_stock_detail&stockid=$rs_stockid'\"><i class=\"fa fa-eye fa-lg\"></i> ".pcrtlang("View Item Details")."</button>";

$rs_show_photo = "SELECT * FROM photos WHERE stock_item = '$rs_stockid'";
$rs_photo_result = mysqli_query($rs_connect, $rs_show_photo);
while($rs_photo_result_q = mysqli_fetch_object($rs_photo_result)) {
$rs_filename = "$rs_photo_result_q->photo_filename";
echo "<img src=\"stock.php?func=getinvimage&photo_name=ths_$rs_filename\">";
}


echo "</td></tr></table>";

echo "<br><br>";

}
require("footer.php");                  
                                                                                                                            
}




function show_stock_detail() {

$stockid = $_REQUEST['stockid'];

require("header.php");
require("deps.php");


if ($stockid == "") {
die(pcrtlang("Error - no stock id entered")); 
}

if (!is_numeric($stockid)) {
die(pcrtlang("Error - You must enter a numeric value."));
}

         
                                                                                                                                      





$stockidsize = strlen($stockid);   
if ($stockidsize < 11) {
$rs_show_stock = "SELECT * FROM stock WHERE stock_id = '$stockid'";
} else {
$rs_show_stock = "SELECT * FROM stock WHERE stock_upc = '$stockid' LIMIT 1";
}
 
$rs_stock_result = mysqli_query($rs_connect, $rs_show_stock);

if((mysqli_num_rows($rs_stock_result)) == "0") {
die("Error - Stock id number doesn't exist");
}
                             

                                                                                                                  
                                                                                                                                               
while($rs_stock_result_q = mysqli_fetch_object($rs_stock_result)) {
$rs_stockid = "$rs_stock_result_q->stock_id";
$rs_stocktitle = "$rs_stock_result_q->stock_title";
$rs_stockdesc = "$rs_stock_result_q->stock_desc";
$rs_stockpdesc = "$rs_stock_result_q->stock_pdesc";
$rs_stockprice = "$rs_stock_result_q->stock_price";
$rs_stockupc = "$rs_stock_result_q->stock_upc";
$rs_stockcat = "$rs_stock_result_q->stock_cat";


$rs_find_scat = "SELECT * FROM sub_cats WHERE sub_cat_id = '$rs_stockcat'";
$rs_fscat_result = mysqli_query($rs_connect, $rs_find_scat);
$rs_scat_result_q = mysqli_fetch_object($rs_fscat_result);
$rs_scat_name = "$rs_scat_result_q->sub_cat_name";
$rs_scat_pid = "$rs_scat_result_q->sub_cat_parent";

$rs_find_mcat = "SELECT * FROM maincats WHERE cat_id = '$rs_scat_pid'";
$rs_fmcat_result = mysqli_query($rs_connect, $rs_find_mcat);
$rs_mcat_result_q = mysqli_fetch_object($rs_fmcat_result);
$rs_mcat_name = "$rs_mcat_result_q->cat_name";

checkstorecount($rs_stockid);

echo "<table class=standard><tr><th>$rs_stocktitle - #$rs_stockid</th></tr><tr><td>";
 
echo pcrtlang("Category").": $rs_mcat_name &raquo; $rs_scat_name<br>";

if ($rs_stockupc != 0) {
echo pcrtlang("Item UPC#")." $rs_stockupc<br>";
}
echo "$rs_stockdesc<br><br>";

echo "<br>".pcrtlang("Printed Description")."<br>$rs_stockpdesc<br><br>";

echo "<strong>".pcrtlang("Price").": $money".mf("$rs_stockprice")."</strong><br><br>";

$rs_show_photo = "SELECT * FROM photos WHERE stock_item = '$stockid'";
$rs_photo_result = mysqli_query($rs_connect, $rs_show_photo);
while($rs_photo_result_q = mysqli_fetch_object($rs_photo_result)) {
$rs_filename = "$rs_photo_result_q->photo_filename";
echo "<img src=\"stock.php?func=getinvimage&photo_name=th_$rs_filename\" style=\"width:200px;\"><br><br>";

}
                                                                                                                                              

#####
$invoicelist = "";
$workorderlist = "";
$invoicelistarray = array();
$workorderlistarray = array();

echo "<strong>".pcrtlang("Items in Stock").":</strong> <br>";

$rs_find_stores = "SELECT * FROM stores WHERE storeenabled = '1' ORDER BY storesname ASC";
$rs_result_stores = mysqli_query($rs_connect, $rs_find_stores);
while($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
$rs_storesname = "$rs_result_storeq->storesname";
$rs_storeid = "$rs_result_storeq->storeid";

$rs_find_stock = "SELECT * FROM stockcounts WHERE storeid = '$rs_storeid' AND stockid = '$rs_stockid'";
$rs_result_stock = mysqli_query($rs_connect, $rs_find_stock);
$rs_result_stockq = mysqli_fetch_object($rs_result_stock);
$stockqty = "$rs_result_stockq->quantity";

$testing[] = stockavailability($rs_stockid,$rs_storeid,$stockqty);


$stockqtyarray[$rs_storeid] = $stockqty;

echo "$rs_storesname: $stockqty<br>";


$checkopeninvoices = "SELECT invoice_items.cart_stock_id,invoices.invoice_id,invoices.invname FROM invoice_items,invoices WHERE invoice_items.cart_stock_id = '$rs_stockid' AND invoice_items.invoice_id = invoices.invoice_id AND invoices.invstatus = '1' AND invoices.storeid = '$rs_storeid' AND invoices.iorq != 'quote'";
$checkopeninvoices_q = mysqli_query($rs_connect, $checkopeninvoices);
$countoninvoices = mysqli_num_rows($checkopeninvoices_q);

while($checkopeninvoices_qp = mysqli_fetch_object($checkopeninvoices_q)) {
$invoice_id = "$checkopeninvoices_qp->invoice_id";
$invoice_name = "$checkopeninvoices_qp->invname";

if(!in_array("$invoice_id", $invoicelistarray)) {
$invoicelist .= "<button type=button onClick=\"parent.location='invoice.php?func=printinv&invoice_id=$invoice_id'\">#$invoice_id $invoice_name</button><br>";
}

$invoicelistarray[] = $invoice_id;

}


$thetotalitemsinv = array();

if ($countoninvoices > 0) {
if(!isset($itemsonopen)) {
$itemsonopen = "<strong>".pcrtlang("Items on Open Invoices").":</strong> <br>";
}
$itemsonopen .= "$rs_storesname: $countoninvoices<br>";
$thetotalitemsinv[$rs_storeid] = $countoninvoices;
} else {
$thetotalitemsinv[$rs_storeid] = 0;
}


#####
$countonwo = 0;

$rcarray = array();
$fillrcarr = "SELECT pcwo FROM repaircart WHERE cart_stock_id = '$rs_stockid'";
$fillrcarr_q = mysqli_query($rs_connect, $fillrcarr);
while ($rs_result_frca = mysqli_fetch_object($fillrcarr_q)) {
$thewoid = "$rs_result_frca->pcwo";
$rcarray[] = $thewoid;

if(!in_array("$thewoid", $workorderlistarray)) {


if($thewoid != 0) {
$findwosql = "SELECT pcid,pcstatus FROM pc_wo WHERE woid = '$thewoid'";
$findwo_q = mysqli_query($rs_connect, $findwosql);
$rs_result_ffwon = mysqli_fetch_object($findwo_q);
$pcid = "$rs_result_ffwon->pcid";
$pcstatus = "$rs_result_ffwon->pcstatus";

$findnamesql = "SELECT pcname FROM pc_owner WHERE pcid = '$pcid'";
$findname_q = mysqli_query($rs_connect, $findnamesql);
$rs_result_ffn = mysqli_fetch_object($findname_q);
$pcname = "$rs_result_ffn->pcname";
if($pcstatus != '5') {
$workorderlist .= "<button type=button onClick=\"parent.location='../repair/index.php?pcwo=$thewoid'\">#$thewoid $pcname</button>";
}
}

$workorderlistarray[] = $thewoid;
}
}

$rcarray_counted = array_count_values($rcarray);

########

$rs_find_wo = "SELECT * FROM pc_wo WHERE pcstatus != '5' AND storeid = '$rs_storeid'";
$rs_result_wo = mysqli_query($rs_connect, $rs_find_wo);
while ($rs_result_woq = mysqli_fetch_object($rs_result_wo)) {
$thewoid = "$rs_result_woq->woid";

if(array_key_exists("$thewoid", $rcarray_counted)) {
$rs_find_wo_inv = "SELECT * FROM invoices WHERE woid = '$thewoid' AND iorq != 'quote'";
$rs_result_wo_inv = mysqli_query($rs_connect, $rs_find_wo_inv);
if (mysqli_num_rows($rs_result_wo_inv) == 0) {
$countonwo = $countonwo + $rcarray_counted[$thewoid];
}
}
}


#############################

$thetotalitemswo = array();

if ($countonwo > 0) {
if(!isset($itemsonopenwo)) {
$itemsonopenwo = "<strong>".pcrtlang("Items On Open Work Orders").":</strong> <br>";
}
$itemsonopenwo .= "$rs_storesname: $countonwo<br>";
$thetotalitemswo[$rs_storeid] = $countonwo;
} else {
$thetotalitemswo[$rs_storeid] = 0;
}


if(!array_key_exists("$rs_storeid", $thetotalitemsinv)) {
$thetotalitemsinv[$rs_storeid] = 0;
}

if(!array_key_exists("$rs_storeid", $thetotalitemswo)) {
$thetotalitemswo[$rs_storeid] = 0;
}

$tavail = ($stockqtyarray[$rs_storeid] - $thetotalitemsinv[$rs_storeid]) - $thetotalitemswo[$rs_storeid];

unset($thetotalitemsinv);
unset($thetotalitemswo);

if(!isset($countavail)) {
$countavail = "<strong>".pcrtlang("Estimated Items Available").":</strong> <br>";
}
$countavail .= "$rs_storesname: $tavail<br>";


}



if(isset($itemsonopen)) {
echo "<br>$itemsonopen";
}

unset($itemsonopen);

if(isset($itemsonopenwo)) {
echo "<br>$itemsonopenwo";
}

unset($itemsonopenwo);

if(isset($countavail)) {
echo "<br>$countavail";
}

unset($countavail);




if(($invoicelist != "") || ($workorderlist != "")) {

echo "<div data-role=\"popup\" id=\"popuponopen\">";
echo "<a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-corner-all ui-shadow ui-btn ui-icon-delete ui-btn-icon-notext ui-btn-right\">Close</a>";
echo "<table class=standard><tr><th>".pcrtlang("Invoices")."</th></tr><tr><td>$invoicelist</td><tr></table><br><br><table class=standard><tr><th>".pcrtlang("Work Orders")."</th></tr><tr><td>$workorderlist</td></tr></table>";
echo "</div>";

echo "<a href=\"#popuponopen\" data-rel=\"popup\" class=\"ui-btn ui-corner-all ui-shadow\">".pcrtlang("Show Invoices/Work Orders with items")."</a>";
}


#####


if (perm_check("6")) {

$rs_find_laststock = "SELECT inv_price FROM inventory WHERE stock_id = '$stockid' ORDER BY inv_date DESC LIMIT 1";
$rs_result_last = mysqli_query($rs_connect, $rs_find_laststock);
$rs_result_lastitem_q = mysqli_fetch_object($rs_result_last);
$rs_lastinvprice = pf("$rs_result_lastitem_q->inv_price");

if($rs_lastinvprice != 0) {
if($rs_stockprice < ($rs_lastinvprice * 1.99)) {
$markup = round(($rs_stockprice / $rs_lastinvprice) - 1, 2) * 100;
$markup .= "&#37;";
} else {
$markup = round(($rs_stockprice / $rs_lastinvprice), 2);
$markup .= "X";
}


echo "<br>".pcrtlang("Current Markup").": $markup <br>(".pcrtlang("based on most recent cost price").")";
}
}



echo "<br><br>";

echo "<form action=cart.php?func=add_item method=post data-ajax=\"false\"><input type=hidden name=stockid value=$rs_stockid>";
echo "<strong>".pcrtlang("Qty")."</strong>";
echo "<input type=number style=\"width:50px;\" name=\"qty\" value=\"1\" min=\"1\" step=\"1\"> ";
echo "<input type=submit value=\"".pcrtlang("Add Item to Cart")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Adding Item to Cart")."...'; this.form.submit();\"  data-theme=\"b\"></form>";

                                                                                                               
}

echo "<br>";


echo "<div data-role=\"collapsible\">\n";
echo "<h3>".pcrtlang("Item Actions")."</h3>\n";

if (perm_check("6")) {


$rs_stocktitle2 = urlencode($rs_stocktitle);
echo "<button type=button onClick=\"parent.location='stock.php?func=restock_item&stockid=$rs_stockid&stocktitle=$rs_stocktitle2'\"><img src=../store/images/restock.png align=absmiddle> ".pcrtlang("Restock this item")."</button>\n";
if ($activestorecount > "1") {
echo "<button type=button onClick=\"parent.location='stock.php?func=transfer_stock&stockid=$rs_stockid&stocktitle=$rs_stocktitle2'\"><img src=../store/images/restock.png align=absmiddle> ".pcrtlang("Transfer Stock")."</button>\n";
}

$rs_stockprice_ue = urlencode($rs_stockprice);

$rs_stockupc_ue = urlencode($rs_stockupc);

echo "<button type=button onClick=\"parent.location='stock.php?func=edit_stock&stockid=$rs_stockid&stocktitle=$rs_stocktitle2'\"><img src=../store/images/invedit.png align=absmiddle> ".pcrtlang("Edit this item")."</button>\n";

$rs_findpics = "SELECT * FROM photos WHERE stock_item = '$rs_stockid'";
$rs_findpics_result = mysqli_query($rs_connect, $rs_findpics);

$numpics = mysqli_num_rows($rs_findpics_result);

if ($numpics == 0) {
echo "<button type=button onClick=\"parent.location='stock.php?func=addphoto&stockid=$rs_stockid'\"><img src=../store/images/camera.png align=absmiddle> ".pcrtlang("Add Picture")."</button>\n";
} else {
echo "<button type=button onClick=\"parent.location='stock.php?func=delphoto&stockid=$rs_stockid'\"><img src=../store/images/delphoto.png align=absmiddle> ".pcrtlang("Remove Picture")."</button>\n";
}

#test
}


echo "<button type=button onClick=\"parent.location='printpricetag.php?price=$rs_stockprice_ue&stockid=$rs_stockid&itemupc=$rs_stockupc_ue&name=$rs_stocktitle2&dymojsapi=html'\"><img src=../store/images/pricetag.png align=absmiddle> ".pcrtlang("Print Price Tag")."</button>\n";




$usertaxid = getusertaxid();
$salestaxrate = getsalestaxrate($usertaxid);
$itemtax = $rs_stockprice * $salestaxrate;
$totalprice = $rs_stockprice + $itemtax;
$totalprice_ue = urlencode("$totalprice");
$taxname = urlencode(gettaxname($usertaxid));

echo "<button type=button onClick=\"parent.location='printpricetag.php?withtaxname=$taxname&price=$totalprice_ue&stockid=$rs_stockid&itemupc=$rs_stockupc_ue&name=$rs_stocktitle2&dymojsapi=html'\"><img src=../store/images/pricetag.png align=absmiddle> ".pcrtlang("Print Price Tag w/Tax")."</button>\n";

echo "<button type=button onClick=\"parent.location='printpricecard.php?stockid=$rs_stockid&dymojsapi=html'\"><img src=../store/images/pricetag.png align=absmiddle> ".pcrtlang("Print Price Card")."</button>\n";

echo "</div>\n\n";


echo "<br>";

if (perm_check("6")) {

echo "<div data-role=\"collapsible\">\n";
echo "<h3>".pcrtlang("Stock Levels")."</h3>\n";


$rs_find_stores = "SELECT * FROM stores WHERE storeenabled = '1' ORDER BY storesname ASC";
$rs_result_stores = mysqli_query($rs_connect, $rs_find_stores);
while($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
$rs_storesname = "$rs_result_storeq->storesname";
$rs_storeid = "$rs_result_storeq->storeid";

$rs_find_stock = "SELECT * FROM stockcounts WHERE storeid = '$rs_storeid' AND stockid = '$rs_stockid'";
$rs_result_stock = mysqli_query($rs_connect, $rs_find_stock);
$rs_result_stockq = mysqli_fetch_object($rs_result_stock);
$stockqty = "$rs_result_stockq->quantity";
$maintainstock = "$rs_result_stockq->maintainstock";
$maxstock = "$rs_result_stockq->maxstock";
$minstock = "$rs_result_stockq->minstock";
$reorderqty = "$rs_result_stockq->reorderqty";
$reqcount = "$rs_result_stockq->reqcount";

echo "<form action=\"stock.php?func=savestocklevels&stockid=$rs_stockid\" method=post  data-ajax=\"false\">";
echo "<table class=standard><tr><th colspan=2>";
echo "<input type=hidden name=storeid value=\"$rs_storeid\">$rs_storesname</th></tr>
<tr><td>".pcrtlang("Current Qty")."</td><td style=\"text-align:right;\">$stockqty</td></tr>
<tr><td>".pcrtlang("Minimum Qty")."</td><td style=\"padding-left:10px;padding-right:10px;text-align:right;\"><input type=text name=minstock value=$minstock></td></tr>
<tr><td>".pcrtlang("Maximum Qty")."</td><td style=\"padding-left:10px;padding-right:10px;text-align:right;\"><input type=text name=maxstock value=$maxstock></font></td></tr>
<tr><td>".pcrtlang("Reorder Qty")."</td><td style=\"padding-left:10px;padding-right:10px;text-align:right;\"><input type=text name=reorderqty value=$reorderqty></font></td></tr>
<tr><td colspan=2><label>";

if($maintainstock == 0) {
echo "<input type=checkbox name=maintainstock>";
} else {
echo "<input type=checkbox checked name=maintainstock>";
}

echo pcrtlang("Maintain Stock")."</label></td></tr>";

echo "<tr><td colspan=2><button type=submit class=button><i class=\"fa fa-save fa-lg\"></i> Save</button>";
if($reqcount == 1) {
echo "<button onClick=\"parent.location='stock.php?func=requestrecount&stockid=$rs_stockid&recount=0&storeid=$rs_storeid'\" class=button><i class=\"fa fa-ban fa-lg\"></i> Cancel Recount Request</button>";
} else {
echo "<button onClick=\"parent.location='stock.php?func=requestrecount&stockid=$rs_stockid&recount=1&storeid=$rs_storeid'\" class=button><i class=\"fa fa-check-circle-o fa-lg\"></i> Request Recount</button>";
}
echo "</td></tr></table></form>\n\n<br>";


}

echo "</div>";

}


echo "<br>";

if (perm_check("6")) {

echo "<div data-role=\"collapsible\">\n";
echo "<h3>".pcrtlang("Stocking History")."</h3>\n";

$rs_find_stockh = "SELECT * FROM inventory WHERE stock_id = '$rs_stockid' ORDER BY inv_date DESC";
$rs_result_stockh = mysqli_query($rs_connect, $rs_find_stockh);
while($rs_result_stockhq = mysqli_fetch_object($rs_result_stockh)) {
$inv_id = "$rs_result_stockhq->inv_id";
$invprice = "$rs_result_stockhq->inv_price";
$invquantity = "$rs_result_stockhq->inv_quantity";
$invdate = "$rs_result_stockhq->inv_date";
$invstoreid = "$rs_result_stockhq->storeid";
$itemserials = "$rs_result_stockhq->itemserial";
$supplierid = "$rs_result_stockhq->supplierid";
$suppliername = "$rs_result_stockhq->suppliername";
$partnumber = "$rs_result_stockhq->partnumber";
$parturl = "$rs_result_stockhq->parturl";

if("$itemserials" != "") { 
$serialsarray = preg_split('/\n|\r\n?/', $itemserials);
} else {
$serialsarray = array();
}

$storeinfoarray = getstoreinfo($invstoreid);

$invdate2 = pcrtdate("$pcrt_longdate", "$invdate");

$itemserials2 = urlencode($rs_result_stockhq->itemserial);

echo "<div data-role=\"collapsible\" data-mini=\"true\">\n";
echo "<h3>$invdate2</h3>";

echo "<table class=standard>";
echo "<tr><td>".pcrtlang("Quantity").":</td><td align=right>$invquantity</td></tr>";
echo "<tr><td>".pcrtlang("Price").":</td><td>$money".mf("$invprice")."</td></tr>";
echo "<tr><td>".pcrtlang("Store").":</td><td>$storeinfoarray[storesname]</td></tr>";
echo "<tr><td>".pcrtlang("Serials")."</td><td>";

foreach($serialsarray as $key => $serial) {
$serialue = urlencode("$serial");
echo "$serial <button type=button onClick=\"parent.location='printpricetag.php?price=".mf("$rs_stockprice")."&stockid=$rs_stockid&itemupc=$rs_stockupc_ue&name=$rs_stocktitle2&itemserial=$serialue&dymojsapi=html'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"> <img src=../store/images/pricetag.png style=\"width:15px;vertical-align:middle;margin-bottom: .25em;\"></button>";
echo "<button type=button onClick=\"parent.location='printpricetag.php?price=".mf("$totalprice")."&stockid=$rs_stockid&itemupc=$rs_stockupc_ue&name=$rs_stocktitle2&itemserial=$serialue&dymojsapi=html'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"> <img src=../store/images/pricetag.png style=\"width:15px;vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("w/tax")."</button><br>";
}

echo "</td></tr>";

if($supplierid != 0) {
$rs_find_suppliers = "SELECT * FROM suppliers WHERE supplierid = $supplierid";
$rs_result_supp = mysqli_query($rs_connect, $rs_find_suppliers);
$rs_result_suppq = mysqli_fetch_object($rs_result_supp);
$suppliername2 = "$rs_result_suppq->suppliername";
} else {
$suppliername2 = "$suppliername";
}


if(perm_check("23") && ($supplierid != 0)) {
echo "<tr><td>".pcrtlang("Supplier").":</td><td> <button type=button onClick=\"parent.location='suppliers.php?func=viewsupplier&supplierid=$supplierid'\">$suppliername2</button></td></tr>";
} else {
echo "<tr><td>".pcrtlang("Supplier")."</td><td>$suppliername2</td></tr>";
}

echo "<tr><td>".pcrtlang("Part Number")."</td><td>$partnumber</td></tr>";
echo "<tr><td>".pcrtlang("Part URL")."</td><td>";
if($parturl != "") {
$parturl2 = addhttp("$parturl");
echo "<a href=\"$parturl2\" target=\"_blank\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"><i class=\"fa fa-external-link fa-lg\"></i></a>";
}
echo "</td></tr>";
echo "<tr><td colspan=2><button type=button onClick=\"parent.location='stock.php?func=editstockinv&invid=$inv_id&stockid=$rs_stockid&invstoreid=$invstoreid&invstockqty=$invquantity&ourprice=$invprice&itemserial=$itemserials2'\"><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("Edit")."</button>";

echo "<a href=\"#popupdeleteinvid$inv_id\" data-rel=\"popup\" data-position-to=\"window\" data-transition=\"pop\" class=\"ui-btn ui-shadow ui-corner-all\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")."</a>";
echo "<div data-role=\"popup\" id=\"popupdeleteinvid$inv_id\" data-overlay-theme=\"b\"  data-theme=\"a\" data-dismissible=\"false\">";
echo "<div data-role=\"header\" data-theme=\"b\">";
echo "<h1>".pcrtlang("Delete Item")."?</h1>";
echo "</div>";
echo "<div role=\"main\" class=\"ui-content\">";
echo "<p>".pcrtlang("Are you sure you wish to permanently delete this inventory entry!!!?")."</p>";
echo "<div align=\"right\"><a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\" data-inline=\"true\">";
echo "<i class=\"fa fa-ban fa-lg\"></i> Cancel</a>";
echo "<button onClick=\"parent.location='stock.php?func=deletestockinv&invid=$inv_id&stockid=$rs_stockid&invstoreid=$invstoreid&invstockqty=$invquantity&delprice=$invprice'\" data-inline=\"true\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")." </button></div>";
echo "</div>";
echo "</div>";
echo "</td></tr>";


echo "</table>\n";
echo "</div>\n";

}

echo "</div>\n";

}




echo "<br>";


echo "<div data-role=\"collapsible\">";
echo "<h3>".pcrtlang("Recent Sales of this Item")."</h3>";

$rs_find_stocks = "SELECT * FROM sold_items WHERE stockid = '$rs_stockid' ORDER BY date_sold DESC LIMIT 25";
$rs_result_stockss = mysqli_query($rs_connect, $rs_find_stocks);
while($rs_result_stockhs = mysqli_fetch_object($rs_result_stockss)) {
$receipt_id = "$rs_result_stockhs->receipt";
$date_sold2 = "$rs_result_stockhs->date_sold";
$return_receipt = "$rs_result_stockhs->return_receipt";

$date_sold = pcrtdate("$pcrt_longdate", "$date_sold2");

$theqc = "SELECT * FROM receipts WHERE receipt_id = '$receipt_id'";
$rs_result_nii_rc = mysqli_query($rs_connect, $theqc);
$rs_result_rqc = mysqli_fetch_object($rs_result_nii_rc);
$customername = "$rs_result_rqc->person_name";
$company = "$rs_result_rqc->company";
$invoice_id = "$rs_result_rqc->invoice_id";
$woid = "$rs_result_rqc->woid";

echo "<div data-role=\"collapsible\"  data-mini=\"true\">";
echo "<h3>$customername</h3>";

echo "<table class=standard><tr><td>".pcrtlang("Date Sold").": </td><td>$date_sold</td></tr>";
echo "<tr><td>".pcrtlang("Receipt").": </td><td><button type=button onClick=\"parent.location='receipt.php?func=show_receipt&receipt=$receipt_id'\">$receipt_id</button></td></tr>";

if($company != "") {
echo "<tr><td>".pcrtlang("Company").": </td><td>$company</td></tr>";
}

if($woid != 0) {
echo "<tr><td>".pcrtlang("Work Orders").": </td><td>";
echo "<button type=button onClick=\"parent.location='../repairmobile/index.php?pcwo=$woid'\">$woid</button>";
echo "</td></tr>";
}



if($invoice_id != 0) {
echo "<tr><td>".pcrtlang("Invoice").": </td><td>";
echo "<button type=button onClick=\"parent.location='invoice.php?func=printinv&invoice_id=$invoice_id'\">$invoice_id</button>";
echo "</td></tr>";
}



if($return_receipt != 0) {
echo "<tr><td>";
echo pcrtlang("Returned on Receipt").":</td><td><button type=button onClick=\"parent.location='receipt.php?func=show_receipt&receipt=$return_receipt'\">$return_receipt</button>";
echo "</td></tr>";
}





echo "</table>";

echo "</div>";

}
echo "</div>";









echo "</td></tr></table>";

require("footer.php");
                                                                                                                                               
}

function addphoto() {

$stockid = $_REQUEST['stockid'];

require("deps.php");

require_once("common.php");

perm_boot("6");

require("dheader.php");

if ($demo == "yes") {
die(pcrtlang("Sorry this feature is disabled in demo mode"));
}


$folderperms = substr(sprintf('%o', fileperms('../productphotos')), -3);


dheader(pcrtlang("Add Photo"));

                                                                                                                                              
echo "<form action=stock.php?func=addphoto2 method=post enctype=\"multipart/form-data\"  data-ajax=\"false\">";
echo pcrtlang("Picture to Upload").":<input type=file name=photo accept=\"image/*;capture=camera\"><input type=hidden name=stockid value=$stockid>";
echo "<input type=submit value=\"".pcrtlang("Upload Photo")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Uploading Photo")."...'; this.form.submit();\" data-theme=\"b\"></form>";

dfooter();

require_once("dfooter.php");


}


function addphoto2() {
require_once("validate.php");
$stockid = $_REQUEST['stockid'];
                                                                                                                                               
require("deps.php");

require_once("common.php");
perm_boot("6");

if ($demo == "yes") {
die("Sorry this feature is disabled in demo mode");
}


$photofilename = basename($_FILES['photo']['name']);

function validate_conn($v_filename) {
   return preg_match('/^[a-z0-9_-]+\.(jpg|png)$/i', $v_filename) ? '1' : '0';
}


if (validate_conn($photofilename) == '0') {
die(pcrtlang("Please rename the filename so that it contains only underscores, dashes, periods, and alphanumeric charachers<br><br>File must also be a jpg or png"));
}


$uploaddir = "../productphotos/";
$uploadfile = $uploaddir . basename($_FILES['photo']['name']);
if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile)) {
} else {
    echo "Possible file upload attack!\n";
}

exec("convert -resize '350>x350>' ../productphotos/$photofilename ../productphotos/th_$stockid$photofilename");                                                                             
exec("convert -resize '100>x100>' ../productphotos/$photofilename ../productphotos/ths_$stockid$photofilename");

$problem_message = "";
if (!file_exists("../productphotos/th_$stockid$photofilename")) {
$problem_message = pcrtlang("Failed to create image using ImageMagick from the command line. Looking for Apache Module...")."<br><br>";

if (class_exists('Imagick')) {
  $img = new Imagick();
  $img->readImage("../productphotos/$photofilename");
  $img->scaleImage(320,240,true);
  $img->writeImage("../productphotos/th_$stockid$photofilename");
  $img->clear();
  $img->destroy();
  $img = new Imagick();
  $img->readImage("../productphotos/$photofilename");
  $img->scaleImage(100,100,true);
  $img->writeImage("../productphotos/ths_$stockid$photofilename");
  $img->clear();
  $img->destroy();
$problem_message = pcrtlang("ImageMagick Apache Module found... Attempting to save image...")."<br><br>";
if (!file_exists("../productphotos/th_$stockid$photofilename")) {
$problem_message = pcrtlang("Image Save Failed.")."<br><br>";
}
} else {
$problem_message = pcrtlang("ImageMagick Apache Module not available... Image Upload Failed.")."<br><br>";
}
}

###

if (!file_exists("../productphotos/th_$stockid$photofilename")) {

define('THUMBNAIL_IMAGE_MAX_WIDTH', 320);
define('THUMBNAIL_IMAGE_MAX_HEIGHT', 240);

function generate_image_thumbnail($source_image_path, $thumbnail_image_path)
{
    list($source_image_width, $source_image_height, $source_image_type) = getimagesize($source_image_path);
    switch ($source_image_type) {
        case IMAGETYPE_GIF:
            $source_gd_image = imagecreatefromgif($source_image_path);
            break;
        case IMAGETYPE_JPEG:
            $source_gd_image = imagecreatefromjpeg($source_image_path);
            break;
        case IMAGETYPE_PNG:
            $source_gd_image = imagecreatefrompng($source_image_path);
            break;
    }
    if ($source_gd_image === false) {
        return false;
    }
    $source_aspect_ratio = $source_image_width / $source_image_height;
    $thumbnail_aspect_ratio = THUMBNAIL_IMAGE_MAX_WIDTH / THUMBNAIL_IMAGE_MAX_HEIGHT;
    if ($source_image_width <= THUMBNAIL_IMAGE_MAX_WIDTH && $source_image_height <= THUMBNAIL_IMAGE_MAX_HEIGHT) {
        $thumbnail_image_width = $source_image_width;
        $thumbnail_image_height = $source_image_height;
    } elseif ($thumbnail_aspect_ratio > $source_aspect_ratio) {
        $thumbnail_image_width = (int) (THUMBNAIL_IMAGE_MAX_HEIGHT * $source_aspect_ratio);
        $thumbnail_image_height = THUMBNAIL_IMAGE_MAX_HEIGHT;
    } else {
        $thumbnail_image_width = THUMBNAIL_IMAGE_MAX_WIDTH;
        $thumbnail_image_height = (int) (THUMBNAIL_IMAGE_MAX_WIDTH / $source_aspect_ratio);
    }
    $thumbnail_gd_image = imagecreatetruecolor($thumbnail_image_width, $thumbnail_image_height);
    imagecopyresampled($thumbnail_gd_image, $source_gd_image, 0, 0, 0, 0, $thumbnail_image_width, $thumbnail_image_height, $source_image_width, $source_image_height);
    imagejpeg($thumbnail_gd_image, $thumbnail_image_path, 90);
    imagedestroy($source_gd_image);
    imagedestroy($thumbnail_gd_image);
    return true;
}

generate_image_thumbnail("../productphotos/$photofilename", "../productphotos/th_$stockid$photofilename");
generate_image_thumbnail("../productphotos/$photofilename", "../productphotos/ths_$stockid$photofilename");
if (!file_exists("../pcphotos/$photofilename")) {
$problem_message = pcrtlang("Image Save Failed using GD...")."<br><br>";
}
}



##



if (file_exists("../productphotos/$photofilename")) {
unlink("../productphotos/$photofilename");
} 

if (!file_exists("../productphotos/th_$stockid$photofilename")) {
die("$problem_message");
}






$rs_insert_stock = "INSERT INTO photos (photo_filename,stock_item) VALUES ('$stockid$photofilename','$stockid')";
@mysqli_query($rs_connect, $rs_insert_stock);
 
header("Location: stock.php?func=show_stock_detail&stockid=$stockid");
                                                                                                                           
                                                                                                                                               
}

function delphoto() {
require_once("validate.php");
$stockid = $_REQUEST['stockid'];

                                                                                                                                               
require("deps.php");

require_once("common.php");
perm_boot("6");

if ($demo == "yes") {
die("Sorry this feature is disabled in demo mode");
}

                                                                                                                                               




$rs_show_photo = "SELECT * FROM photos WHERE stock_item = '$stockid'";
$rs_photo_result = mysqli_query($rs_connect, $rs_show_photo);
while($rs_photo_result_q = mysqli_fetch_object($rs_photo_result)) {
$rs_filename = "$rs_photo_result_q->photo_filename";

unlink("../productphotos/th_$rs_filename");
unlink("../productphotos/ths_$rs_filename");


}

$rs_del_stock = "DELETE FROM photos WHERE stock_item = '$stockid'";
@mysqli_query($rs_connect, "$rs_del_stock");


header("Location: stock.php?func=show_stock_detail&stockid=$stockid");
                                                                                                                                               
                                                                                                                                               
}




function edit_stock() {

$stockid = $_REQUEST['stockid'];


require("deps.php");

require_once("common.php");


require("dheader.php");

perm_boot("6");

dheader(pcrtlang("Edit Stock"));





$rs_find_stockinfo = "SELECT * FROM stock WHERE stock_id = '$stockid'";
$rs_result_item = mysqli_query($rs_connect, $rs_find_stockinfo);
                                                                                                                                               
                                                                                                                                               
while($rs_result_item_q = mysqli_fetch_object($rs_result_item)) {
$rs_stocktitle = pf("$rs_result_item_q->stock_title");
$rs_stockdesc = "$rs_result_item_q->stock_desc";
$rs_stockpdesc = "$rs_result_item_q->stock_pdesc";
$rs_stock_price = "$rs_result_item_q->stock_price";
$rs_catin = "$rs_result_item_q->stock_cat";
$rs_upc = "$rs_result_item_q->stock_upc";
                                                                                                                            
echo "<form action=stock.php?func=edit_stock2 name=editstock method=post data-ajax=\"false\">";
echo pcrtlang("Name of Product").":<input type=text name=productname value=\"$rs_stocktitle\">";
echo pcrtlang("Product UPC").":<input type=text name=productupc value=\"$rs_upc\">";
                                                                                                                                        
echo pcrtlang("Product Category").": <select name=category>";
                                                                                                       
$rs_insert_main_cat = "SELECT * FROM maincats ORDER BY cat_name ASC";
$rs_result = mysqli_query($rs_connect, $rs_insert_main_cat);
                                                                                                                                               
                                                                                                                                               
while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_catid = "$rs_result_q->cat_id";
$rs_catname = "$rs_result_q->cat_name";
                                                                                                                                               
$rs_find_sub_cat = "SELECT * FROM sub_cats WHERE sub_cat_parent = '$rs_catid' ORDER BY sub_cat_name ASC";
$rs_find_result = mysqli_query($rs_connect, $rs_find_sub_cat);
                                                                                                                                               
while($rs_find_result_q = mysqli_fetch_object($rs_find_result)) {
$rs_subcatid = "$rs_find_result_q->sub_cat_id";
$rs_subcatname = "$rs_find_result_q->sub_cat_name";

if ($rs_subcatid == $rs_catin) {                                                                                                                                               
echo "<option value=$rs_subcatid selected>$rs_catname -> $rs_subcatname</option>";
} else {
echo "<option value=$rs_subcatid>$rs_catname -> $rs_subcatname</option>";
}
                                                                                                                                               
}
                                                                                                                                               
                                                                                                                                               
                                                                                                                                               
}
echo "</select>";

$rs_find_laststock = "SELECT inv_price FROM inventory WHERE stock_id = '$stockid' ORDER BY inv_date DESC LIMIT 1";
$rs_result_last = mysqli_query($rs_connect, $rs_find_laststock);
$rs_result_lastitem_q = mysqli_fetch_object($rs_result_last);
$rs_lastinvprice = pf("$rs_result_lastitem_q->inv_price");


echo pcrtlang("Product Description").":<textarea name=prod_desc>$rs_stockdesc</textarea>";
echo pcrtlang("Printed Description").":<textarea name=prod_pdesc>$rs_stockpdesc</textarea>";
echo pcrtlang("Selling Price").":<input type=text name=sellprice id=sellprice value=\"".mf("$rs_stock_price")."\"><br>Current Price: ".mf("$rs_stock_price");

$usertaxid = getusertaxid();
$salestaxrateremain = (1 + getsalestaxrate($usertaxid));
if($salestaxrateremain != 1) {
echo "<button class=button type=button title=\"".pcrtlang("Pre-Tax Calculator")."\"
onclick='document.getElementById(\"sellprice\").value=(document.getElementById(\"sellprice\").value / $salestaxrateremain).toFixed(5)'>
<i class=\"fa fa-calculator\"></i> ".pcrtlang("Calculate Pre-Tax")."</button>";
}


if("$rs_lastinvprice" >= "0.00000001") {
if($rs_stock_price < ($rs_lastinvprice * 1.99)) {
$markup = round(($rs_stock_price / $rs_lastinvprice) - 1, 2) * 100;
$markup .= "&#37;";
} else {
$markup = round(($rs_stock_price / $rs_lastinvprice), 2);
$markup .= "X";
}
} else {
$markup = pcrtlang("na");
}


echo "<br><br>".pcrtlang("Current Markup").": $markup<br><font class=em90>(".pcrtlang("based on most recent cost price").")</font>";



echo "<br><br>".pcrtlang("Most Recent Cost Price").":<input type=text readonly name=ourprice value=\"".mf("$rs_lastinvprice")."\">";


         

echo pcrtlang("Change Markup").":";

?>

<script>
function markup() {
var marknum = Math.ceil((document.editstock.ourprice.value - 0) * (document.editstock.chooser.value - 0)) - document.editstock.cents.value;
document.editstock.sellprice.value = marknum.toFixed(2);
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


                                                                                                                                      
echo "<input type=hidden value=$stockid name=stockid><input type=submit value=\"".pcrtlang("Edit Item")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Saving")."...'; this.form.submit();\" data-theme=\"b\"></form>";
}
                
dfooter();

require_once("dfooter.php");

                                                                                                                                            
}



function edit_stock2() {
require_once("validate.php");

require("deps.php");
require("common.php");

perm_boot("6");

$stockid = $_REQUEST['stockid'];
$productname = pv($_REQUEST['productname']);
$category = $_REQUEST['category'];
$prod_desc = pv($_REQUEST['prod_desc']);
$prod_pdesc = pv($_REQUEST['prod_pdesc']);
$sellprice = $_REQUEST['sellprice'];
$productupc = pv($_REQUEST['productupc']);

                                                                                                                                               




$rs_insert_stock = "UPDATE stock SET stock_title = '$productname', stock_desc = '$prod_desc', stock_cat = '$category', stock_price = '$sellprice', stock_upc = '$productupc', stock_pdesc = '$prod_pdesc' WHERE stock_id = '$stockid'";

@mysqli_query($rs_connect, $rs_insert_stock);
updatecategories();
                                                                                                                                               
header("Location: stock.php?func=show_stock_detail&stockid=$stockid");
                                                                                                                                               
}


function restock_item() {

$stockid = $_REQUEST['stockid'];
$stocktitle = $_REQUEST['stocktitle'];

require("deps.php");

require_once("common.php");

perm_boot("6");

checkstorecount($stockid);

require("dheader.php");

dheader(pcrtlang("Restock Item"));

if (array_key_exists('stockqty',$_REQUEST)) {
$stockqty = $_REQUEST['stockqty'];
} else {
$stockqty = "0";
}



echo pcrtlang("Enter Number of Items to add to stock").":<br>";
echo "<form action=stock.php?func=restock_item2 method=post data-ajax=\"false\">";
$rs_find_stores = "SELECT * FROM stores WHERE storeenabled = '1' ORDER BY storesname ASC";
$rs_result_stores = mysqli_query($rs_connect, $rs_find_stores);
while($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
$rs_storesname = "$rs_result_storeq->storesname";
$rs_storeid = "$rs_result_storeq->storeid";

echo "<br>";

echo "<div class=\"ui-field-contain\">";
echo "<label for=\"store$rs_storeid\">$rs_storesname:</label>";

if ($defaultuserstore == $rs_storeid) {
echo "<input type=text name=store$rs_storeid value=$stockqty>";
} else {
echo "<input type=text name=store$rs_storeid value=0>";
}

echo "</div>";

echo pcrtlang("serials/codes").":<textarea name=storeserial$rs_storeid></textarea>";

}

echo "<br>".pcrtlang("Our Cost").": <input type=text name=ourcost>";
echo pcrtlang("Supplier info below pre-filled from most recent previous stock entry...");


$rs_find_laststock = "SELECT * FROM inventory WHERE stock_id = '$stockid' ORDER BY inv_date DESC LIMIT 1";
$rs_result_last = mysqli_query($rs_connect, $rs_find_laststock);
$rs_result_lastitem_q = mysqli_fetch_object($rs_result_last);
$supplieridindb = "$rs_result_lastitem_q->supplierid";
$suppliernameindb = "$rs_result_lastitem_q->suppliername";
$parturlindb = "$rs_result_lastitem_q->parturl";
$partnumberindb = "$rs_result_lastitem_q->partnumber";


echo pcrtlang("Pick Supplier").": <select name=supplierid>";

if($supplieridindb == 0) {
echo "<option value=0 selected>".pcrtlang("Manually Entered Supplier")."</option>";
} else {
echo "<option value=0>".pcrtlang("Manually Entered Supplier")."</option>";
}


$rs_find_suppliers = "SELECT * FROM suppliers ORDER BY suppliername ASC";
$rs_result_supp = mysqli_query($rs_connect, $rs_find_suppliers);

while($rs_result_suppq = mysqli_fetch_object($rs_result_supp)) {
$suppliername = "$rs_result_suppq->suppliername";
$supplierid = "$rs_result_suppq->supplierid";


if($supplieridindb == $supplierid) {
echo "<option value=$supplierid selected>$suppliername</option>";
} else {
echo "<option value=$supplierid>$suppliername</option>";
}


}
echo "</select>";

echo pcrtlang("Supplier Name")." <input type=text name=suppliername value=\"$suppliernameindb\">";
echo pcrtlang("Supplier Part No.")." <input type=text name=partnumber value=\"$partnumberindb\">";
echo pcrtlang("Part URL")." <input type=text name=parturl value=\"$parturlindb\">";



echo "<input type=hidden name=stockid value=$stockid>";
echo "<input type=submit value=\"".pcrtlang("Add to stock")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Adding to Stock")."...'; this.form.submit();\" data-theme=\"b\"></form>";

dfooter();

require_once("dfooter.php");

                                                                                                                                               
}



function restock_item2() {
require_once("validate.php");

require("common.php");
require("deps.php");

$stockid = $_REQUEST['stockid'];
$ourprice = $_REQUEST['ourcost'];

$partnumber = pv($_REQUEST['partnumber']);
$parturl = pv($_REQUEST['parturl']);
$suppliername = pv($_REQUEST['suppliername']);
$supplierid = $_REQUEST['supplierid'];



perm_boot("6");

checkstorecount($stockid);

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');





$rs_find_stores = "SELECT * FROM stores WHERE storeenabled = '1' ORDER BY storesname ASC";
$rs_result_stores = mysqli_query($rs_connect, $rs_find_stores);
while($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
$rs_storeid = "$rs_result_storeq->storeid";

$thecount =  $_REQUEST["store$rs_storeid"];
if (is_numeric("$thecount")) {
if ($thecount > 0) {
$rs_find_stock_qty = "SELECT stock.avg_cost, SUM(stockcounts.quantity) AS stock_quantity FROM stock, stockcounts WHERE stock.stock_id = stockcounts.stockid AND stockcounts.stockid = '$stockid'";
$rs_result_stock_qty = mysqli_query($rs_connect, $rs_find_stock_qty);
$rs_result_stock_qtyq = mysqli_fetch_object($rs_result_stock_qty);
$rs_stock_quantity = "$rs_result_stock_qtyq->stock_quantity";
$avg_cost = "$rs_result_stock_qtyq->avg_cost";

if ($avg_cost != 0) {
$rs_insert_avg_cost = "UPDATE stock SET avg_cost = (avg_cost * $rs_stock_quantity + $ourprice * $thecount) / ($rs_stock_quantity + $thecount) WHERE stock_id = '$stockid'";
} else {
$rs_insert_avg_cost = "UPDATE stock SET avg_cost = $ourprice WHERE stock_id = '$stockid'";
}
@mysqli_query($rs_connect, $rs_insert_avg_cost);

$rs_insert_stock = "UPDATE stockcounts SET quantity = quantity+$thecount WHERE stockid = '$stockid' AND storeid = '$rs_storeid'";
@mysqli_query($rs_connect, $rs_insert_stock);

$theserials =  pv($_REQUEST["storeserial$rs_storeid"]);
$rs_insert_inv = "INSERT INTO inventory (stock_id,inv_price,inv_quantity,inv_date,storeid,itemserial,supplierid,suppliername,parturl,partnumber) VALUES  ('$stockid','$ourprice','$thecount','$currentdatetime','$rs_storeid','$theserials','$supplierid','$suppliername','$parturl','$partnumber')";
@mysqli_query($rs_connect, $rs_insert_inv);
}
}

}


updatecategories();
                                                                                                                                               
header("Location: stock.php?func=show_stock_detail&stockid=$stockid");
                                                                                                                                               
}


function search_stock() {

$thesearch2 = $_REQUEST['thesearch'];

require("header.php");
require("deps.php");

if ($thesearch2 == "") {
die(pcrtlang("Please enter a search term"));
}

$thesearch = pv(str_replace(" ", "%", "$thesearch2"));
$thesearchue = urlencode("$thesearch2");

if (array_key_exists('searchcat',$_REQUEST)) {
$searchcat = $_REQUEST['searchcat'];
} else {
$searchcat = 0;
}





if($searchcat == 0) {
$rs_show_stock = "SELECT * FROM stock WHERE (stock_title LIKE '%$thesearch%' OR stock_upc LIKE '%$thesearch%' OR stock_desc LIKE '%$thesearch%') AND dis_cont = 0";
} else {
$rs_show_stock = "SELECT * FROM stock WHERE (stock_title LIKE '%$thesearch%' OR stock_upc LIKE '%$thesearch%' OR stock_desc LIKE '%$thesearch%') AND dis_cont = 0 AND stock_cat = '$searchcat'";
}
$rs_stock_result = mysqli_query($rs_connect, $rs_show_stock);

$rs_show_stockc = "SELECT DISTINCT stock_cat, stock_title, COUNT(stock_cat) AS stockitems FROM stock WHERE (stock_title LIKE '%$thesearch%' OR stock_upc LIKE '%$thesearch%' OR stock_desc LIKE '%$thesearch%') AND dis_cont = 0 GROUP BY stock_cat";

$rs_stock_resultc = mysqli_query($rs_connect, $rs_show_stockc);



echo "<h3>".pcrtlang("Searched for").": $thesearch2</h3>";

if($searchcat != 0) {
$rs_find_sub_cat = "SELECT * FROM sub_cats WHERE sub_cat_id = '$searchcat'";
$rs_find_result = mysqli_query($rs_connect, $rs_find_sub_cat);
$rs_find_result_q = mysqli_fetch_object($rs_find_result);
$rs_subcatname = "$rs_find_result_q->sub_cat_name";
echo "<h3>".pcrtlang("In Category").": $rs_subcatname</h3>";
}


if($searchcat == 0) {

echo "<div data-role=\"collapsible\">";
echo "<h3>".pcrtlang("Narrow Search")."</h3>";

while($rs_stock_result_qc = mysqli_fetch_object($rs_stock_resultc)) {
$rs_stockcat = "$rs_stock_result_qc->stock_cat";
$rs_stockitems = "$rs_stock_result_qc->stockitems";

$rs_find_sub_cat = "SELECT * FROM sub_cats WHERE sub_cat_id = '$rs_stockcat'";
$rs_find_result = mysqli_query($rs_connect, $rs_find_sub_cat);
$rs_find_result_q = mysqli_fetch_object($rs_find_result);
$rs_subcatname = "$rs_find_result_q->sub_cat_name";


echo "<button type=button onClick=\"parent.location='stock.php?func=search_stock&thesearch=$thesearchue&searchcat=$rs_stockcat'\">($rs_stockitems) $rs_subcatname</button> ";

}

echo "</div>";

}



while($rs_stock_result_q = mysqli_fetch_object($rs_stock_result)) {
$rs_stockid = "$rs_stock_result_q->stock_id";
$rs_stocktitle = "$rs_stock_result_q->stock_title";
$rs_stockdesc = "$rs_stock_result_q->stock_desc";
$rs_stockprice = "$rs_stock_result_q->stock_price";

checkstorecount($rs_stockid);

if ((strlen($rs_stockdesc)) > 40) {
$rs_stockdesc2 = substr("$rs_stockdesc", 0, 40)."..";
} else {
$rs_stockdesc2 = $rs_stockdesc;
}


echo "<table class=standard><tr><th>
#$rs_stockid $rs_stocktitle</th></tr>";


echo "<tr><td>$rs_stockdesc2</td></tr>";

echo "<tr><td>";
echo pcrtlang("Items in Stock").": ";

$rs_find_stores = "SELECT * FROM stores WHERE storeenabled = '1' ORDER BY storesname ASC";
$rs_result_stores = mysqli_query($rs_connect, $rs_find_stores);
while($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
$rs_storesname = "$rs_result_storeq->storesname";
$rs_storeid = "$rs_result_storeq->storeid";

$rs_find_stock = "SELECT * FROM stockcounts WHERE storeid = '$rs_storeid' AND stockid = '$rs_stockid'";
$rs_result_stock = mysqli_query($rs_connect, $rs_find_stock);
$rs_result_stockq = mysqli_fetch_object($rs_result_stock);
$stockqty = "$rs_result_stockq->quantity";

echo "<br>$rs_storesname: $stockqty";

}
echo "</td></tr>";


echo "<tr><td>".pcrtlang("Price").": $money".mf("$rs_stockprice")."</td></tr>";


$rs_show_photo = "SELECT * FROM photos WHERE stock_item = '$rs_stockid'";
$rs_photo_result = mysqli_query($rs_connect, $rs_show_photo);
while($rs_photo_result_q = mysqli_fetch_object($rs_photo_result)) {
$rs_filename = "$rs_photo_result_q->photo_filename";
echo "<tr><td><img src=stock.php?func=getinvimage&photo_name=ths_$rs_filename></td></tr>";
}



echo "<tr><td><form action=cart.php?func=add_item method=post data-native-menu=\"false\"><input type=hidden name=stockid value=$rs_stockid>";
echo "<input type=submit value=\"".pcrtlang("Add Item to Cart")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Adding to Cart")."...'; this.form.submit();\"></form>";
echo "<button type=button onClick=\"parent.location='stock.php?func=show_stock_detail&stockid=$rs_stockid'\"><i class=\"fa fa-eye fa-lg\"></i> ".pcrtlang("View Item")."</button>";
echo "</td></tr>";
echo "</table><br>";
}
require("footer.php");
}



function discont() {

$stock_id = $_REQUEST['stock_id'];
$pageNumber = $_REQUEST['pageNumber'];

include("deps.php");

require_once("common.php");
perm_boot("6");





$rs_insert_sub_cat = "UPDATE stock SET dis_cont = '1' WHERE stock_id = '$stock_id'";
@mysqli_query($rs_connect, $rs_insert_sub_cat);

header("Location: reports.php?func=browse_outofstock&pageNumber=$pageNumber");

}

function transfer_stock() {

$stockid = $_REQUEST['stockid'];
$stocktitle = $_REQUEST['stocktitle'];

require("deps.php");

require_once("common.php");

perm_boot("6");

checkstorecount($stockid);

require("dheader.php");


dheader(pcrtlang("Transfer Stock Item"));

echo "<form action=stock.php?func=transfer_stock2 method=post  data-ajax=\"false\">";
$storeoptions = "";
echo "<strong>".pcrtlang("Current Stock Quantities").":</strong><br><br>";
$rs_find_stores = "SELECT * FROM stores WHERE storeenabled = '1' ORDER BY storesname ASC";
$rs_result_stores = mysqli_query($rs_connect, $rs_find_stores);
while($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
$rs_storesname = "$rs_result_storeq->storesname";
$rs_storeid = "$rs_result_storeq->storeid";

$rs_find_stock = "SELECT * FROM stockcounts WHERE storeid = '$rs_storeid' AND stockid = '$stockid'";
$rs_result_stock = mysqli_query($rs_connect, $rs_find_stock);
$rs_result_stockq = mysqli_fetch_object($rs_result_stock);
$stockqty = "$rs_result_stockq->quantity";

echo "$rs_storesname: $stockqty<br>";

$storeoptions .= "<option value=$rs_storeid>$rs_storesname</option>";

}
echo "<br><br>".pcrtlang("Number of Items to Transfer").":<input type=text name=\"stockqty\" value=\"0\">";
echo pcrtlang("Transfer From").":<select name=storefrom>$storeoptions</select>";
echo pcrtlang("Transfer To").":<select name=storeto>$storeoptions</select>";


echo "<input type=hidden name=stockid value=$stockid>";
echo "<br><input type=submit value=\"".pcrtlang("Transfer Stock")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Transferring")."...'; this.form.submit();\" data-theme=\"b\"></form>";

dfooter();

require_once("dfooter.php");


}



function transfer_stock2() {
require_once("validate.php");
$stockid = $_REQUEST['stockid'];
$storefrom = $_REQUEST['storefrom'];
$storeto = $_REQUEST['storeto'];
$stockqty = $_REQUEST['stockqty'];

require("common.php");
require("deps.php");

perm_boot("6");

checkstorecount($stockid);

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');





if ((is_numeric("$storefrom")) && (is_numeric("$storefrom"))) {
$rs_sub_stock = "UPDATE stockcounts SET quantity = quantity-$stockqty WHERE stockid = '$stockid' AND storeid = '$storefrom'";
@mysqli_query($rs_connect, $rs_sub_stock);
$rs_add_stock = "UPDATE stockcounts SET quantity = quantity+$stockqty WHERE stockid = '$stockid' AND storeid = '$storeto'";
@mysqli_query($rs_connect, $rs_add_stock);
}


updatecategories();

header("Location: stock.php?func=show_stock_detail&stockid=$stockid");

}


function deletestockinv() {
require_once("validate.php");
$stockid = $_REQUEST['stockid'];
$invid = $_REQUEST['invid'];
$invstoreid = $_REQUEST['invstoreid'];
$invstockqty = $_REQUEST['invstockqty'];
$delprice = $_REQUEST['delprice'];

require("common.php");
require("deps.php");

perm_boot("6");

checkstorecount($stockid);





$rs_find_stock_qty = "SELECT stock.avg_cost, SUM(stockcounts.quantity) AS stock_quantity FROM stock, stockcounts WHERE stock.stock_id = stockcounts.stockid AND stockcounts.stockid = '$stockid'";
$rs_result_stock_qty = mysqli_query($rs_connect, $rs_find_stock_qty);
$rs_result_stock_qtyq = mysqli_fetch_object($rs_result_stock_qty);
$rs_stock_quantity = "$rs_result_stock_qtyq->stock_quantity";
$avg_cost = "$rs_result_stock_qtyq->avg_cost";

if ($avg_cost != "0") {
$rs_insert_avg_cost = "UPDATE stock SET avg_cost = (avg_cost * $rs_stock_quantity - $delprice * $invstockqty) / ($rs_stock_quantity - $invstockqty) WHERE stock_id = '$stockid'";
@mysqli_query($rs_connect, $rs_insert_avg_cost);
}

$rs_delinv = "DELETE FROM inventory WHERE inv_id = '$invid'";
@mysqli_query($rs_connect, $rs_delinv);

$rs_adj_stock = "UPDATE stockcounts SET quantity = quantity-$invstockqty WHERE stockid = '$stockid' AND storeid = '$invstoreid'";
@mysqli_query($rs_connect, $rs_adj_stock);

updatecategories();

header("Location: stock.php?func=show_stock_detail&stockid=$stockid");

}



function editstockinv() {

$stockid = $_REQUEST['stockid'];
$invid = $_REQUEST['invid'];
$invstoreid = $_REQUEST['invstoreid'];
$invstockqty = $_REQUEST['invstockqty'];
$ourprice = $_REQUEST['ourprice'];
$itemserial = $_REQUEST['itemserial'];

require("deps.php");

require_once("common.php");

perm_boot("6");

checkstorecount($stockid);

require("dheader.php");


dheader(pcrtlang("Edit Inv Entry"));

echo "<form action=stock.php?func=editstockinv2 method=post  data-ajax=\"false\">";
echo "<input type=hidden name=\"oldinvstockqty\" value=\"$invstockqty\">";
echo "<input type=hidden name=\"oldourprice\" value=\"$ourprice\">";

echo "<table>";

echo pcrtlang("New Quantity").": <input type=text name=\"newstockqty\" value=\"$invstockqty\">";
echo pcrtlang("Our Cost").": <input type=text name=\"ourprice\" value=\"".mf("$ourprice")."\">";
echo pcrtlang("Serials/Codes").":<br>(".pcrtlang("One per line").")<textarea name=\"itemserial\">$itemserial</textarea>";

echo "<input type=hidden name=invstoreid value=$invstoreid>";
echo "<input type=hidden name=stockid value=$stockid>";
echo "<input type=hidden name=oldstockqty value=$invstockqty>";
echo "<input type=hidden name=invid value=$invid>";
echo "<input type=submit value=\"".pcrtlang("Save")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Saving")."...'; this.form.submit();\" data-theme=\"b\"></form>";

dfooter();

require_once("dfooter.php");


}


function editstockinv2() {
require_once("validate.php");
$stockid = $_REQUEST['stockid'];
$invid = $_REQUEST['invid'];
$invstoreid = $_REQUEST['invstoreid'];
$oldstockqty = $_REQUEST['oldstockqty'];
$newstockqty = $_REQUEST['newstockqty'];
$ourprice = $_REQUEST['ourprice'];
$itemserial = $_REQUEST['itemserial'];

$oldinvstockqty = $_REQUEST['oldinvstockqty'];
$oldourprice = $_REQUEST['oldourprice'];

require("common.php");
require("deps.php");

perm_boot("6");

$rs_find_stock_qty = "SELECT stock.avg_cost, SUM(stockcounts.quantity) AS stock_quantity FROM stock, stockcounts WHERE stock.stock_id = stockcounts.stockid AND stockcounts.stockid = '$stockid'";
$rs_result_stock_qty = mysqli_query($rs_connect, $rs_find_stock_qty);
$rs_result_stock_qtyq = mysqli_fetch_object($rs_result_stock_qty);
$rs_stock_quantity = "$rs_result_stock_qtyq->stock_quantity";
$avg_cost = "$rs_result_stock_qtyq->avg_cost";


$changeinvalue = (($newstockqty * $ourprice) - ($oldinvstockqty * $oldourprice));

if ($newstockqty > $oldstockqty) {
$achange = $newstockqty - $oldstockqty;

if ($avg_cost != 0) {
$rs_insert_avg_cost = "UPDATE stock SET avg_cost = (avg_cost * $rs_stock_quantity + $changeinvalue) / ($rs_stock_quantity + $achange) WHERE stock_id = '$stockid'";
}
@mysqli_query($rs_connect, $rs_insert_avg_cost);


$rs_adj_stock = "UPDATE stockcounts SET quantity = quantity+$achange WHERE stockid = '$stockid' AND storeid = '$invstoreid'";
} elseif ($newstockqty < $oldstockqty) {
$achange = $oldstockqty - $newstockqty;

if ($avg_cost != 0) {
$rs_insert_avg_cost = "UPDATE stock SET avg_cost = (avg_cost * $rs_stock_quantity + $changeinvalue) / ($rs_stock_quantity - $achange) WHERE stock_id = '$stockid'";
}
@mysqli_query($rs_connect, $rs_insert_avg_cost);


$rs_adj_stock = "UPDATE stockcounts SET quantity = quantity-$achange WHERE stockid = '$stockid' AND storeid = '$invstoreid'";
} else {
}

checkstorecount($stockid);





@mysqli_query($rs_connect, $rs_adj_stock);

$rs_adj_inv = "UPDATE inventory SET inv_quantity = '$newstockqty', inv_price = '$ourprice', itemserial = '$itemserial' WHERE inv_id = '$invid'";
@mysqli_query($rs_connect, $rs_adj_inv);

updatecategories();

header("Location: stock.php?func=show_stock_detail&stockid=$stockid");

}


function fixinv() {

require("deps.php");

require_once("common.php");

require_once("validate.php");

perm_boot("6");

echo "<html><head>";

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../repair/style.css\">";
echo "<script src=\"../repair/jq/jquery.js\" type=\"text/javascript\"></script>";

?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="mobile-web-app-capable" content="yes">
<?php

echo "<script>\n";
echo "<!--\n";
echo "function sf(){document.f.stockid.focus();}\n";
echo "// -->\n";
echo "</script>\n";


echo "</head><body onLoad=sf() style=\"background:#00ff00\"><br><br>";




start_box_nested();

$storeinfoarray = getstoreinfo($defaultuserstore);


echo "<font class=text16heading>".pcrtlang("Store").": $storeinfoarray[storesname]</font><br><br>";

echo "<font class=text16heading>".pcrtlang("Scan Price Tag")."</font><br><br>";

echo "<form action=stock.php?func=fixinv2 name=f method=post>";
echo "<table>";

echo "<tr><td><font class=text12b>".pcrtlang("Stock ID or UPC").":</font></td><td><input type=text class=textbox name=\"stockid\" size=10></td></tr>";

echo "</table>";
echo "<br><br>";
echo "<br><input type=submit class=rbigbutton value=\"".pcrtlang("Scan.... Next")."-&gt;\" onclick=\"this.disabled=true;this.value='".pcrtlang("Wait")."...'; this.form.submit();\"></form>";
stop_box();

echo "<br>&nbsp;&nbsp;<font style=\"font-size:80px;color:#ffffff\">$storeinfoarray[storesname]</font>";

echo "</body>";
echo "</html>";

}


function fixinv2() {

require("deps.php");

require_once("validate.php");

require_once("common.php");

$stockid = $_REQUEST['stockid'];


checkstorecount($stockid);





$stockidsize = mb_strlen($stockid);

if ($stockidsize < 11) {
$rs_chk_stock = "SELECT * FROM stock WHERE stock_id = '$stockid'";
} else {
$rs_chk_stock = "SELECT * FROM stock WHERE stock_upc = '$stockid'";
}



$rs_chkresult_stock = mysqli_query($rs_connect, $rs_chk_stock);

$rs_result_stockidq = mysqli_fetch_object($rs_chkresult_stock);
$stockidcount = "$rs_result_stockidq->stock_id";

$checkcount = mysqli_num_rows($rs_chkresult_stock);
if ($checkcount == 0) {
die("Stock ID or UPC doesnt exist");
}

$rs_find_stock = "SELECT * FROM stockcounts WHERE storeid = '$defaultuserstore' AND stockid = '$stockidcount'";
$rs_result_stock = mysqli_query($rs_connect, $rs_find_stock);
$rs_result_stockq = mysqli_fetch_object($rs_result_stock);
$stockqty = "$rs_result_stockq->quantity";

perm_boot("6");

echo "<html><head>";

?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="mobile-web-app-capable" content="yes">
<?php


echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../repair/style.css\">";
echo "<script src=\"../repair/jq/jquery.js\" type=\"text/javascript\"></script>";

echo "<script>\n";
echo "<!--\n";
echo "function sf(){document.f.stockcount.focus();}\n";
echo "// -->\n";
echo "</script>\n";

echo "</head><body onLoad=sf() style=\"background:#ff0000\"><br><br>";
start_box_nested();


$rs_show_stock = "SELECT stock_title FROM stock WHERE stock_id = '$stockid'";
$rs_stock_result = mysqli_query($rs_connect, $rs_show_stock);
$rs_stock_result_q = mysqli_fetch_object($rs_stock_result);
$rs_stocktitle = "$rs_stock_result_q->stock_title";


$storeinfoarray = getstoreinfo($defaultuserstore);


echo "<font class=text16heading>".pcrtlang("Store").": $storeinfoarray[storesname]</font><br><br>";

echo "<font class=text16heading>".pcrtlang("Enter Stock Quantity")." <br><br></font><font class=text16heading> #$stockid $rs_stocktitle</font><br><br>";

echo "<form action=stock.php?func=fixinv3 name=f method=post>";
echo "<table>";

echo "<tr><td><font class=text12b>".pcrtlang("Current Quantity").":</font></td><td style=\"text-align:right;\"><font class=textblue12b style=\"text-align:right;\">$stockqty</font></td></tr>";
echo "<tr><td><font class=text12b>".pcrtlang("Stock Count").":</font></td><td><input type=text class=textbox name=\"stockcount\" value=\"$stockqty\" size=10></td></tr>";

echo "</table>";
echo "<br><br>";
echo "<br><input type=hidden name=stockid value=$stockid>";

if (array_key_exists('thedate',$_REQUEST)) {
$thedate = $_REQUEST['thedate'];
echo "<input type=hidden name=thedate value=\"$thedate\">";
}

echo "<input type=submit class=redbigbutton40 value=\"".pcrtlang("Count.... Save")."&raquo;\" onclick=\"this.disabled=true;this.value='".pcrtlang("Wait")."...'; this.form.submit();\"></form>";
stop_box();

echo "<br>&nbsp;&nbsp;<font style=\"font-size:80px;color:#ffffff\">$storeinfoarray[storesname]</font>";

echo "</body>";
echo "</html>";

}


function fixinv3() {
$stockid = $_REQUEST['stockid'];
$stockcount = $_REQUEST['stockcount'];

require("common.php");
require("deps.php");

require_once("validate.php");

perm_boot("6");

$rs_adj_stock = "UPDATE stockcounts SET quantity = $stockcount, lastcounted = NOW() WHERE stockid = '$stockid' AND storeid = '$defaultuserstore'";


@mysqli_query($rs_connect, $rs_adj_stock);



if (array_key_exists('thedate',$_REQUEST)) {
$thedate = $_REQUEST['thedate'];
header("Location: stock.php?func=fixinv4&thedate=$thedate");
} else {
header("Location: stock.php?func=fixinv");
}


}

function fixinv4() {

require("deps.php");

require_once("validate.php");

require_once("common.php");

perm_boot("6");

$thedate = $_REQUEST['thedate'];

echo "<html><head>";


?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="mobile-web-app-capable" content="yes">
<?php


echo "</head><body><br><br>";

echo "<font style=\"font-weight:bold;font-size:16;\">".pcrtlang("Items that show positive stock counts that have not had inventory counts verified since")." $thedate</font><br><br>";

echo "<table>";

echo "<tr><td><font class=text12b>".pcrtlang("Stock ID")."</font></td><td><font class=text12b>".pcrtlang("Stock Title")."</font></td><td></td></tr>";
$rs_find_stock = "SELECT * FROM stockcounts WHERE storeid = '$defaultuserstore' AND quantity > 0 AND lastcounted < '$thedate 00:00:00' ORDER BY stockid ASC";
$rs_result_stock = mysqli_query($rs_connect, $rs_find_stock);
while($rs_result_stockq = mysqli_fetch_object($rs_result_stock)) {
$rs_stockid = "$rs_result_stockq->stockid";
$rs_quantity = "$rs_result_stockq->quantity";

if($rs_stockid != 0) {
$rs_show_stock = "SELECT stock_title FROM stock WHERE stock_id = '$rs_stockid'";
$rs_stock_result = mysqli_query($rs_connect, $rs_show_stock);
$rs_stock_result_q = mysqli_fetch_object($rs_stock_result);
$rs_stocktitle = "$rs_stock_result_q->stock_title";
echo "<tr><td><font class=text12b>$rs_stockid</font></td><td>$rs_stocktitle</td><td>$rs_quantity</td><td>
<button type=button style=\"padding:8px;\" onClick=\"parent.location='stock.php?func=fixinv2&stockid=$rs_stockid&thedate=$thedate'\">".pcrtlang("Fix")."</button></td></tr>";
}
}
echo "</table>";

echo "<button type=button style=\"padding:8px;\" onClick=\"parent.location='categories.php'\">".pcrtlang("Back to Inventory")."</button>";

echo "</body>";
echo "</html>";

}


function getinvimage() {


require("deps.php");
require("common.php");
require_once("validate.php");
$photo_name = $_REQUEST['photo_name'];

header("Content-Type: image/jpg; Content-Disposition: inline; filename=\"$photo_name\"");
readfile("../productphotos/$photo_name");

}


function savestocklevels() {
require_once("validate.php");
$stockid = $_REQUEST['stockid'];
$minstock = $_REQUEST['minstock'];
$maxstock = $_REQUEST['maxstock'];
$reorderqty = $_REQUEST['reorderqty'];
$storeid = $_REQUEST['storeid'];

if (array_key_exists('maintainstock',$_REQUEST)) {
$maintainstock = 1;
} else {
$maintainstock = 0;
}

require("common.php");
require("deps.php");

perm_boot("6");





$rs_save_levels = "UPDATE stockcounts SET maintainstock = '$maintainstock', minstock = '$minstock', maxstock = '$maxstock', reorderqty = '$reorderqty' WHERE stockid = '$stockid' AND storeid = '$storeid'";
@mysqli_query($rs_connect, $rs_save_levels);

header("Location: stock.php?func=show_stock_detail&stockid=$stockid");

}


function requestrecount() {
require_once("validate.php");
$stockid = $_REQUEST['stockid'];
$storeid = $_REQUEST['storeid'];
$recount = $_REQUEST['recount'];

require("common.php");
require("deps.php");

perm_boot("6");





$rs_save_levels = "UPDATE stockcounts SET reqcount = '$recount' WHERE stockid = $stockid AND storeid = '$storeid'";
@mysqli_query($rs_connect, $rs_save_levels);

header("Location: stock.php?func=show_stock_detail&stockid=$stockid");

}



function specialorders() {

require("header.php");
require("deps.php");





$rs_find_so = "SELECT * FROM specialorders WHERE spoopenclosed = '0' AND spostoreid = '$defaultuserstore' ORDER BY spodate DESC";
$rs_result_so = mysqli_query($rs_connect, $rs_find_so);

echo "<h3>".pcrtlang("Special Order Parts")."</h3>";

echo "<button type=button onClick=\"parent.location='stock.php?func=addspo'\"><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Add Special Order Item")."</button>";
echo "<button type=button onClick=\"parent.location='stock.php?func=specialordersall'\"><i class=\"fa fa-chevron-right fa-lg\"></i> ".pcrtlang("Show All Special Orders")."</button>";



if(mysqli_num_rows($rs_result_so) > 0) {



$statii = array(
0 => pcrtlang("Awaiting Customer Approval"),
8 => pcrtlang("Order Part"),
1 => pcrtlang("On Order"),
2 => pcrtlang("Received"),
3 => pcrtlang("Installed"),
4 => pcrtlang("Wrong Part"),
5 => pcrtlang("Bad/Damaged Part"),
6 => pcrtlang("Abandoned Part"),
7 => pcrtlang("Unable to Locate Part"),
9 => pcrtlang("Shipped")
);

while($rs_result_item_q = mysqli_fetch_object($rs_result_so)) {
$spoid = "$rs_result_item_q->spoid";
$spopartname = "$rs_result_item_q->spopartname";
$spoprice = "$rs_result_item_q->spoprice";
$spocost = "$rs_result_item_q->spocost";
$spowoid = "$rs_result_item_q->spowoid";
$sposupplierid = "$rs_result_item_q->sposupplierid";
$sposuppliername = "$rs_result_item_q->sposuppliername";
$spopartnumber = "$rs_result_item_q->spopartnumber";
$spoparturl = "$rs_result_item_q->spoparturl";
$spotracking = "$rs_result_item_q->spotracking";
$spostatus = "$rs_result_item_q->spostatus";
$spodate2 = "$rs_result_item_q->spodate";
$sponotes = "$rs_result_item_q->sponotes";
$unit_price = "$rs_result_item_q->unit_price";
$quantity = "$rs_result_item_q->quantity";

$spodate = pcrtdate("$pcrt_shortdate", "$spodate2");

echo "<table class=standard><tr><th>$spopartname</th></tr><tr><td>".pcrtlang("Quantity").":".qf("$quantity")."<br>".pcrtlang("Unit Price").":$money".mf("$unit_price")."<br>".pcrtlang("Total").":$money".mf("$spoprice")."</td></tr>";

if($sposupplierid != 0) {
$rs_find_suppliers = "SELECT * FROM suppliers WHERE supplierid = '$sposupplierid'";
$rs_result_supp = mysqli_query($rs_connect, $rs_find_suppliers);
$rs_result_suppq = mysqli_fetch_object($rs_result_supp);
$suppliername2 = "$rs_result_suppq->suppliername";
} else {
$suppliername2 = "$sposuppliername";
}


if(perm_check("23") && ($sposupplierid != 0)) {
echo "<tr><td><button type=button onClick=\"parent.location='suppliers.php?func=viewsupplier&supplierid=$sposupplierid'\">$suppliername2</button></td></tr>";
} else {
echo "<tr><td>$suppliername2</td></tr>";
}

echo "<tr><td>".pcrtlang("Part Number").": $spopartnumber</td></tr>";
echo "<tr><td>";
if($spoparturl != "") {
$parturl2 = addhttp("$spoparturl");
echo pcrtlang("Part URL").": <a href=\"$parturl2\" target=\"_blank\"  class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"><i class=\"fa fa-external-link fa-lg\"></i></a>";
}
echo "</td></tr>";

echo "<tr><td>".pcrtlang("Tracking").": <a href=\"http://google.com/#q=$spotracking\" target=\"_blank\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"><i class=\"fa fa-truck fa-lg\"></i> $spotracking</a></td></tr>";

echo "<tr><td>".pcrtlang("Date").": $spodate</td></tr>";

echo "<tr><td>$statii[$spostatus]<br>$sponotes</td></tr>";

echo "<tr><td>";

if($spowoid != 0) {
echo "<button type=button onClick=\"parent.location='../repair/index.php?pcwo=$spowoid'\">".pcrtlang("Work Order")." #$spowoid</button>";
}

echo "</td></tr>";

echo "<tr><td>";
echo "<div data-role=\"collapsible\">";
echo "<h3>".pcrtlang("Actions")."</h3>";


echo "<a href=\"#popupdeletespo$spoid\" data-rel=\"popup\" data-position-to=\"window\" data-transition=\"pop\" class=\"ui-btn ui-shadow ui-corner-all\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("delete")."</a>";
echo "<div data-role=\"popup\" id=\"popupdeletespo$spoid\" data-overlay-theme=\"b\"  data-theme=\"a\" data-dismissible=\"false\">";
echo "<div data-role=\"header\" data-theme=\"b\">";
echo "<h1>".pcrtlang("Delete Special Order")."?</h1>";
echo "</div>";
echo "<div role=\"main\" class=\"ui-content\">";
echo "<p>".pcrtlang("Are you sure you wish to permanently delete this special order!!!?")."</p>";
echo "<div align=\"right\"><a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\" data-inline=\"true\">";
echo "<i class=\"fa fa-ban fa-lg\"></i> Cancel</a>";
echo "<button onClick=\"parent.location='stock.php?func=deletespo&spoid=$spoid'\" data-inline=\"true\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")." </button></div>";
echo "</div>";
echo "</div>";


echo "<button type=button onClick=\"parent.location='stock.php?func=editspo&spoid=$spoid'\"><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("edit")."</button>";
echo "<button type=button onClick=\"parent.location='stock.php?func=spoopenclose&spoid=$spoid&openclose=1'\"><i class=\"fa fa-sign-out fa-lg\"></i> ".pcrtlang("close")."</button>";
echo "<button type=button onClick=\"parent.location='cart.php?func=spoaddcart&spoid=$spoid'\"><i class=\"fa fa-shopping-cart fa-lg\"></i> ".pcrtlang("add to cart")."</button>";
echo "</div>";

echo "</td></tr>";

echo "</table><br>";

}

}


require("footer.php");
}




function addspo() {
require("deps.php");
require_once("common.php");

require("dheader.php");

dheader(pcrtlang("Add Special Order Part"));

echo "<form action=stock.php?func=addspo2 method=post name=newinv data-ajax=\"false\">";
echo pcrtlang("Name of Part/Item").":<input type=text name=spopartname>";

echo pcrtlang("Optional Printed Description").":<textarea name=spoprintdesc></textarea>";

?>

<script>
function markup() {
var marknum = Math.ceil((document.newinv.spocost.value - 0) * (document.newinv.chooser.value - 0)) - document.newinv.cents.value;
document.newinv.spoprice.value = marknum.toFixed(2);
}
</script>

<?php
echo pcrtlang("Selling Price").": $money<input type=text name=spoprice>";
echo pcrtlang("Our Cost").":$money<input type=text name=spocost>";
echo pcrtlang("Quantity").":<input type=text name=spoquantity min=1 step=1>";

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
<option selected value=\"0.01\">99 ".pcrtlang("cents")."</option>
<option value=\"00\">00 ".pcrtlang("cents")."</option>
</select>";



echo pcrtlang("Pick Supplier").": <select name=sposupplierid>";

echo "<option value=0>".pcrtlang("Manually Entered Supplier")."</option>";
$rs_find_suppliers = "SELECT * FROM suppliers ORDER BY suppliername ASC";
$rs_result_supp = mysqli_query($rs_connect, $rs_find_suppliers);

while($rs_result_suppq = mysqli_fetch_object($rs_result_supp)) {
$suppliername = "$rs_result_suppq->suppliername";
$supplierid = "$rs_result_suppq->supplierid";

echo "<option value=$supplierid>$suppliername</option>";

}
echo "</select><input type=hidden name=spowoid value=\"$woid\">";

echo pcrtlang("Supplier Name").": <input type=text name=sposuppliername>";
echo pcrtlang("Supplier Part No.").": <input type=text name=spopartnumber>";
echo pcrtlang("Part URL").": <input type=text name=spoparturl>";
echo pcrtlang("Shipping Tracking Number").": <input type=text name=spotracking>";
echo pcrtlang("Notes").": <input type=text name=sponotes>";

echo pcrtlang("Status").":<select name=spostatus>";
echo "<option value=0 selected>".pcrtlang("Awaiting Customer Approval")."</option>";
echo "<option value=8>".pcrtlang("Order Part")."</option>";
echo "<option value=1>".pcrtlang("On Order")."</option>";
echo "<option value=2>".pcrtlang("Received")."</option>";
echo "<option value=3>".pcrtlang("Installed")."</option>";
echo "<option value=4>".pcrtlang("Wrong Part")."</option>";
echo "<option value=5>".pcrtlang("Bad/Damaged Part")."</option>";
echo "<option value=6>".pcrtlang("Abandoned Part")."</option>";
echo "<option value=7>".pcrtlang("Unable to Locate Part")."</option>";
echo "<option value=9>".pcrtlang("Shipped")."</option>";
echo "</select>";
echo "<input type=submit value=\"".pcrtlang("Save")."\" class=button onclick=\"this.disabled=true;this.value='".pcrtlang("Saving")."...'; this.form.submit();\" data-theme=\"b\">";



dfooter();
require_once("dfooter.php");
}




function addspo2() {
require_once("validate.php");

require("deps.php");
require("common.php");

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

$spopartname = pv($_REQUEST['spopartname']);
$spoprintdesc = pv($_REQUEST['spoprintdesc']);
$spounitprice = $_REQUEST['spoprice'];
$spocost = $_REQUEST['spocost'];
$sposupplierid = pv($_REQUEST['sposupplierid']);
$sposuppliername = pv($_REQUEST['sposuppliername']);
$spopartnumber = pv($_REQUEST['spopartnumber']);
$spoparturl = pv($_REQUEST['spoparturl']);
$spotracking = pv($_REQUEST['spotracking']);
$spostatus = $_REQUEST['spostatus'];
$sponotes = pv($_REQUEST['sponotes']);
$spoquantity = pv($_REQUEST['spoquantity']);

$spoprice = $spounitprice * $spoquantity;
$spocost = $spocost * $spoquantity;


$rs_insert_so = "INSERT INTO specialorders (spopartname,spoprice,spocost,sposupplierid,sposuppliername,spopartnumber,spoparturl,spotracking,spostatus,spodate,spostoreid,sponotes,quantity,unit_price,printdesc) VALUES ('$spopartname','$spoprice','$spocost','$sposupplierid','$sposuppliername','$spopartnumber','$spoparturl','$spotracking','$spostatus','$currentdatetime','$defaultuserstore','$sponotes','$spoquantity','$spounitprice','$spoprintdesc')";
@mysqli_query($rs_connect, $rs_insert_so);
header("Location: stock.php?func=specialorders");

}


function editspo() {
require("deps.php");
require_once("common.php");

require("dheader.php");

$spoid = $_REQUEST['spoid'];

$rs_find_so = "SELECT * FROM specialorders WHERE spoid = '$spoid'";
$rs_result_so = mysqli_query($rs_connect, $rs_find_so);

$rs_result_item_q = mysqli_fetch_object($rs_result_so);
$spoid = "$rs_result_item_q->spoid";
$spopartname = pf("$rs_result_item_q->spopartname");
$spoprintdesc = pf("$rs_result_item_q->printdesc");
$spoprice = mf("$rs_result_item_q->spoprice");
$spocost = mf("$rs_result_item_q->spocost");
$spowoid = "$rs_result_item_q->spowoid";
$sposupplierid = "$rs_result_item_q->sposupplierid";
$sposuppliername = pf("$rs_result_item_q->sposuppliername");
$spopartnumber = pf("$rs_result_item_q->spopartnumber");
$spoparturl = pf("$rs_result_item_q->spoparturl");
$spotracking = pf("$rs_result_item_q->spotracking");
$spostatus = "$rs_result_item_q->spostatus";
$sponotes = pf("$rs_result_item_q->sponotes");
$spounit_price = "$rs_result_item_q->unit_price";
$spoquantity = "$rs_result_item_q->quantity";

$spocost = $spocost / $spoquantity;

dheader(pcrtlang("Edit Special Order Part"));
echo "<form action=stock.php?func=editspo2 method=post name=newinv  data-ajax=\"false\">";
echo pcrtlang("Name of Part/Item").": <input type=text name=spopartname value=\"$spopartname\">";

echo pcrtlang("Optional Printed Description").":<textarea name=spoprintdesc>$spoprintdesc</textarea>";

?>

<script>
function markup() {
var marknum = Math.ceil((document.newinv.spocost.value - 0) * (document.newinv.chooser.value - 0)) - document.newinv.cents.value;
document.newinv.spoprice.value = marknum.toFixed(2);
}
</script>

<?php

echo pcrtlang("Quantity").":<input type=number name=spoquantity min=1 step=1 value=\"".qf("$spoquantity")."\">";

echo pcrtlang("Selling Price").": $money<input type=text name=spoprice value=\"".mf("$spounit_price")."\">";
echo pcrtlang("Our Cost").": $money<input type=text name=spocost value=\"$spocost\">";

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
<option selected value=\"0.01\">99 ".pcrtlang("cents")."</option>
<option value=\"00\">00 ".pcrtlang("cents")."</option>
</select>";



echo pcrtlang("Pick Supplier").": <select name=sposupplierid value=\"$sposupplierid\">";

echo "<option value=0>".pcrtlang("Manually Entered Supplier")."</option>";

$rs_find_suppliers = "SELECT * FROM suppliers ORDER BY suppliername ASC";
$rs_result_supp = mysqli_query($rs_connect, $rs_find_suppliers);

while($rs_result_suppq = mysqli_fetch_object($rs_result_supp)) {
$suppliername = "$rs_result_suppq->suppliername";
$supplierid = "$rs_result_suppq->supplierid";

if($sposupplierid == $supplierid) {
echo "<option selected value=$supplierid>$suppliername</option>";
} else {
echo "<option value=$supplierid>$suppliername</option>";
}


}
echo "</select><input type=hidden name=spoid value=\"$spoid\">";
echo pcrtlang("Supplier Name").": <input type=text name=sposuppliername value=\"$sposuppliername\">";
echo pcrtlang("Supplier Part No.").": <input type=text name=spopartnumber value=\"$spopartnumber\">";
echo pcrtlang("Part URL").": <input type=text name=spoparturl value=\"$spoparturl\">";
echo pcrtlang("Shipping Tracking Number").": <input type=text name=spotracking value=\"$spotracking\">";
echo pcrtlang("Notes").": <input type=text name=sponotes value=\"$sponotes\">";

$statii = array(
0 => pcrtlang("Awaiting Customer Approval"),
8 => pcrtlang("Order Part"),
1 => pcrtlang("On Order"),
2 => pcrtlang("Received"),
3 => pcrtlang("Installed"),
4 => pcrtlang("Wrong Part"),
5 => pcrtlang("Bad/Damaged Part"),
6 => pcrtlang("Abandoned Part"),
7 => pcrtlang("Unable to Locate Part"),
9 => pcrtlang("Shipped")
);

echo pcrtlang("Status").": <select name=spostatus value=\"$spostatus\">";

foreach($statii as $key => $val) {
if($key == $spostatus) {
echo "<option selected value=\"$key\">$val</option>";
} else {
echo "<option value=\"$key\">$val</option>";
}

}

echo "</select>";
echo "<input type=submit value=\"".pcrtlang("Save")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Saving")."...'; this.form.submit();\" data-theme=\"b\">";


dfooter();
require_once("dfooter.php");


}




function editspo2() {
require_once("validate.php");

require("deps.php");
require("common.php");

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

$spoid = $_REQUEST['spoid'];
$spopartname = pv($_REQUEST['spopartname']);
$spoprintdesc = pv($_REQUEST['spoprintdesc']);
$spounitprice = $_REQUEST['spoprice'];
$spocost = $_REQUEST['spocost'];
$spowoid = $_REQUEST['spowoid'];
$sposupplierid = pv($_REQUEST['sposupplierid']);
$sposuppliername = pv($_REQUEST['sposuppliername']);
$spopartnumber = $_REQUEST['spopartnumber'];
$spoparturl = pv($_REQUEST['spoparturl']);
$spotracking = pv($_REQUEST['spotracking']);
$spostatus = $_REQUEST['spostatus'];
$sponotes = $_REQUEST['sponotes'];
$spoquantity = $_REQUEST['spoquantity'];


$spoprice = $spounitprice * $spoquantity;
$spocost = $spocost * $spoquantity;

$rs_update_so = "UPDATE specialorders SET spopartname = '$spopartname', spoprice = '$spoprice', spocost = '$spocost', sposupplierid = '$sposupplierid', sposuppliername = '$sposuppliername', spopartnumber = '$spopartnumber', spoparturl = '$spoparturl', spotracking = '$spotracking', spostatus = '$spostatus', sponotes = '$sponotes', quantity = '$spoquantity', unit_price = '$spounitprice', printdesc = '$spoprintdesc' WHERE spoid = '$spoid'";
@mysqli_query($rs_connect, $rs_update_so);
header("Location: stock.php?func=specialorders");

}


function spoopenclose() {
require_once("validate.php");

require("deps.php");
require("common.php");

$spoid = $_REQUEST['spoid'];
$openclose = $_REQUEST['openclose'];





$rs_update_so = "UPDATE specialorders SET spoopenclosed = '$openclose' WHERE spoid = '$spoid'";
@mysqli_query($rs_connect, $rs_update_so);
header("Location: stock.php?func=specialorders");
}


function deletespo() {
require_once("validate.php");

require("deps.php");
require("common.php");

$spoid = $_REQUEST['spoid'];




$rs_del_so = "DELETE FROM specialorders WHERE spoid = '$spoid'";
@mysqli_query($rs_connect, $rs_del_so);
header("Location: stock.php?func=specialorders");
}



function specialordersall() {

require("header.php");
require("deps.php");


if (array_key_exists("pageNumber", $_REQUEST)) {
$pageNumber = $_REQUEST['pageNumber'];
} else {
$pageNumber = 1;
}

if (array_key_exists("sortby", $_REQUEST)) {
$sortby = $_REQUEST['sortby'];
} else {
$sortby = "date_asc";
}


$results_per_page = 40;

if ($pageNumber == "") {
$offset = "0";
} else {
$offset = ($pageNumber * $results_per_page) - $results_per_page;
}







if ("$sortby" == "date_asc") {
$rs_find_spo_items = "SELECT * FROM specialorders WHERE spostoreid = '$defaultuserstore' ORDER BY spodate ASC LIMIT $offset,$results_per_page";
} elseif ("$sortby" == "date_desc") {
$rs_find_spo_items = "SELECT * FROM specialorders WHERE spostoreid = '$defaultuserstore' ORDER BY spodate DESC LIMIT $offset,$results_per_page";
} elseif ("$sortby" == "name_desc") {
$rs_find_spo_items = "SELECT * FROM specialorders WHERE spostoreid = '$defaultuserstore' ORDER BY pcname DESC LIMIT $offset,$results_per_page";
} elseif ("$sortby" == "name_asc") {
$rs_find_spo_items = "SELECT * FROM specialorders WHERE spostoreid = '$defaultuserstore' ORDER BY pcname ASC LIMIT $offset,$results_per_page";
} elseif ("$sortby" == "company_asc") {
$rs_find_spo_items = "SELECT * FROM specialorders WHERE spostoreid = '$defaultuserstore' ORDER BY pccompany ASC LIMIT $offset,$results_per_page";
} else {
$rs_find_spo_items = "SELECT * FROM specialorders WHERE spostoreid = '$defaultuserstore' ORDER BY pccompany DESC LIMIT $offset,$results_per_page";
}

$rs_result = mysqli_query($rs_connect, $rs_find_spo_items);

$rs_find_spo_items_total = "SELECT * FROM specialorders WHERE spostoreid = '$defaultuserstore'";
$rs_result_total = mysqli_query($rs_connect, $rs_find_spo_items_total);


echo "<h3>".pcrtlang("Special Order Parts")."</h3>";

echo "<button type=button onClick=\"parent.location='stock.php?func=addspo'\"><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Add Special Order Item")."</button>";
echo "<button type=button onClick=\"parent.location='stock.php?func=specialorders'\"><i class=\"fa fa-chevron-right fa-lg\"></i> ".pcrtlang("Show Open Special Orders")."</button>";



if(mysqli_num_rows($rs_result_total) > 0) {


echo "<div data-role=\"collapsible\">";
echo "<h3>".pcrtlang("Sort Order")."</h3>";
echo "<button type=button onClick=\"parent.location='stock.php?func=specialordersall&pageNumber=$pageNumber&sortby=date_asc'\"><i class=\"fa fa-sort-numeric-asc fa-lg\"></i></button>";
echo "<button type=button onClick=\"parent.location='stock.php?func=specialordersall&pageNumber=$pageNumber&sortby=date_desc'\"><i class=\"fa fa-sort-numeric-desc fa-lg\"></i></button>";
echo "</div>";


$statii = array(
0 => pcrtlang("Awaiting Customer Approval"),
8 => pcrtlang("Order Part"),
1 => pcrtlang("On Order"),
2 => pcrtlang("Received"),
3 => pcrtlang("Installed"),
4 => pcrtlang("Wrong Part"),
5 => pcrtlang("Bad/Damaged Part"),
6 => pcrtlang("Abandoned Part"),
7 => pcrtlang("Unable to Locate Part"),
9 => pcrtlang("Shipped")
);

while($rs_result_item_q = mysqli_fetch_object($rs_result)) {
$spoid = "$rs_result_item_q->spoid";
$spopartname = "$rs_result_item_q->spopartname";
$spoprice = "$rs_result_item_q->spoprice";
$spocost = "$rs_result_item_q->spocost";
$spowoid = "$rs_result_item_q->spowoid";
$sposupplierid = "$rs_result_item_q->sposupplierid";
$sposuppliername = "$rs_result_item_q->sposuppliername";
$spopartnumber = "$rs_result_item_q->spopartnumber";
$spoparturl = "$rs_result_item_q->spoparturl";
$spotracking = "$rs_result_item_q->spotracking";
$spostatus = "$rs_result_item_q->spostatus";
$spodate2 = "$rs_result_item_q->spodate";
$sponotes = "$rs_result_item_q->sponotes";
$spoopenclosed = "$rs_result_item_q->spoopenclosed";
$unit_price = "$rs_result_item_q->unit_price";
$quantity = "$rs_result_item_q->quantity";

$spodate = pcrtdate("$pcrt_shortdate", "$spodate2");

echo "<table class=standard><tr><th>$spopartname</th></tr><tr><td>".pcrtlang("Quantity").":".qf("$quantity")."<br>".pcrtlang("Unit Price").":$money".mf("$unit_price")."<br>".pcrtlang("Total").":$money".mf("$spoprice")."</td></tr>";

if($sposupplierid != 0) {
$rs_find_suppliers = "SELECT * FROM suppliers WHERE supplierid = '$sposupplierid'";
$rs_result_supp = mysqli_query($rs_connect, $rs_find_suppliers);
$rs_result_suppq = mysqli_fetch_object($rs_result_supp);
$suppliername2 = "$rs_result_suppq->suppliername";
} else {
$suppliername2 = "$sposuppliername";
}


if(perm_check("23") && ($sposupplierid != 0)) {
echo "<tr><td><button type=button onClick=\"parent.location='suppliers.php?func=viewsupplier&supplierid=$sposupplierid'\">$suppliername2</button></td></tr>";
} else {
echo "<tr><td>$suppliername2</td></tr>";
}

echo "<tr><td>".pcrtlang("Part Number").": $spopartnumber</td></tr>";
echo "<tr><td>";
if($spoparturl != "") {
$parturl2 = addhttp("$spoparturl");
echo pcrtlang("Part URL").": <a href=\"$parturl2\" target=\"_blank\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"><i class=\"fa fa-external-link fa-lg\"></i></a>";
}
echo "</td></tr>";

if($spotracking != "") {
echo "<tr><td>".pcrtlang("Tracking").": <a href=\"http://google.com/#q=$spotracking\" target=\"_blank\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\">$spotracking</a></td></tr>";
}

echo "<tr><td>".pcrtlang("Date").": $spodate";
echo "</td></tr>";
echo "<tr><td>$statii[$spostatus]<br>$sponotes</td></tr>";

echo "<tr><td>";

if($spowoid != 0) {
echo "<button type=button onClick=\"parent.location='../repair/index.php?pcwo=$spowoid\">".pcrtlang("Work Order")." #$spowoid</button>";
}

echo "</td></tr>";

echo "<tr><td>";


echo "<div data-role=\"collapsible\">";
echo "<h3>".pcrtlang("Actions")."</h3>";


echo "<a href=\"#popupdeletespo$spoid\" data-rel=\"popup\" data-position-to=\"window\" data-transition=\"pop\" class=\"ui-btn ui-shadow ui-corner-all\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")."</a>";
echo "<div data-role=\"popup\" id=\"popupdeletespo$spoid\" data-overlay-theme=\"b\"  data-theme=\"a\" data-dismissible=\"false\">";
echo "<div data-role=\"header\" data-theme=\"b\">";
echo "<h1>".pcrtlang("Delete Special Order")."?</h1>";
echo "</div>";
echo "<div role=\"main\" class=\"ui-content\">";
echo "<p>".pcrtlang("Are you sure you wish to permanently delete this special order!!!?")."</p>";
echo "<div align=\"right\"><a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\" data-inline=\"true\">";
echo "<i class=\"fa fa-ban fa-lg\"></i> Cancel</a>";
echo "<button onClick=\"parent.location='stock.php?func=deletespo&spoid=$spoid'\" data-inline=\"true\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")." </button></div>";
echo "</div>";
echo "</div>";


echo "<button type=button onClick=\"parent.location='stock.php?func=editspo&spoid=$spoid'\"><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("edit")."</button>";
if($spoopenclosed == 0) {
echo "<button type=button onClick=\"parent.location='stock.php?func=spoopenclose&spoid=$spoid&openclose=1'\"><i class=\"fa fa-sign-out fa-lg\"></i> ".pcrtlang("close")."</button>";
} else {
echo "<button type=button onClick=\"parent.location='stock.php?func=spoopenclose&spoid=$spoid&openclose=0'\"><i class=\"fa fa-sign-in fa-lg\"></i> ".pcrtlang("re-open")."</button>";
}


echo "<button type=button onClick=\"parent.location='cart.php?func=spoaddcart&spoid=$spoid'\"><i class=\"fa fa-shopping-cart fa-lg\"></i> ".pcrtlang("add to cart")."</button>";

echo "</div>";

echo "</td>";

echo "</tr></table><br>";

}

}



echo "<br>";

#browse here
$totalentry = mysqli_num_rows($rs_result_total);
$prevpage = $pageNumber - 1;
$nextpage = $pageNumber + 1;

echo "<center>";

if ($pageNumber > 1) {
echo "<button type=button onClick=\"parent.location='stock.php?func=specialordersall&pageNumber=$prevpage&sortby=$sortby'\">";
echo "<i class=\"fa fa-chevron-left fa-lg\"></i></button>";
}

$total_results = $totalentry;
$results_per_page = $results_per_page;
$html = get_paged_nav($total_results, $results_per_page, false);
echo "$html";

if (($totalentry / $results_per_page) > $pageNumber) {
echo "<button type=button onClick=\"parent.location='stock.php?func=specialordersall&pageNumber=$nextpage&sortby=$sortby'\">";
echo "<i class=\"fa fa-chevron-right fa-lg\"></i></button>";
}

echo "</center>";

require("footer.php");
}








switch($func) {
                                                                                                    
    default:
    add_new_stock();
    break;
                                
    case "add_new_stock2":
    add_new_stock2();
    break;

    case "show_stock":
    show_stock();
    break;
                                   
    case "show_stock_detail":
    show_stock_detail();
    break;
                                 
    case "addphoto":
    addphoto();
    break;

    case "addphoto2":
    addphoto2();
    break;

    case "delphoto":
    delphoto();
    break;

    case "edit_stock":
    edit_stock();
    break;

    case "edit_stock2":
    edit_stock2();
    break;

    case "restock_item":
    restock_item();
    break;

    case "restock_item2":
    restock_item2();
    break;

    case "search_stock":
    search_stock();
    break;

    case "discont":
    discont();
    break;

    case "transfer_stock":
    transfer_stock();
    break;

   case "transfer_stock2":
    transfer_stock2();
    break;

   case "deletestockinv":
    deletestockinv();
    break;

    case "editstockinv":
    editstockinv();
    break;

   case "editstockinv2":
    editstockinv2();
    break;

  case "fixinv":
    fixinv();
    break;

  case "fixinv2":
    fixinv2();
    break;

  case "fixinv3":
    fixinv3();
    break;

  case "fixinv4":
    fixinv4();
    break;

 case "getinvimage":
    getinvimage();
    break;

 case "savestocklevels":
    savestocklevels();
    break;

 case "requestrecount":
    requestrecount();
    break;

 case "specialorders":
    specialorders();
    break;

 case "specialordersall":
    specialordersall();
    break;


case "addspo":
    addspo();
    break;

case "addspo2":
    addspo2();
    break;

case "editspo":
    editspo();
    break;

case "editspo2":
    editspo2();
    break;

case "deletespo":
    deletespo();
    break;

case "spoopenclose":
    spoopenclose();
    break;



}

?>

