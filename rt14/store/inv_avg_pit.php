<?php

/***************************************************************************
 *   copyright            : (C) 2018 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/


require_once("validate.php"); 

require("deps.php");
require("common.php");

if (array_key_exists('orderby',$_REQUEST)) {
$orderby = "$_REQUEST[orderby]";
} else {
$orderby = "cat";
}

$ondate = "$_REQUEST[ondate]";

#$ondate = "2017-01-01";

printableheader("Inventory");


$rs_find_stores = "SELECT * FROM stores";
$rs_result_stores = mysqli_query($rs_connect, $rs_find_stores);
while($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
$rs_storesname = "$rs_result_storeq->storesname";
$rs_storeid = "$rs_result_storeq->storeid";
$storesarray[$rs_storeid] = "$rs_storesname";
}


if ($orderby == "stockid") {
$rs_find_stock = "SELECT * FROM stock ORDER BY stock_id";
} else {
$rs_find_stock = "SELECT * FROM stock ORDER BY stock_cat";
}

$inventoryarray = array();

$rs_result = mysqli_query($rs_connect, $rs_find_stock);
while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_stock_id = "$rs_result_q->stock_id";
$rs_stock_title = "$rs_result_q->stock_title";
$rs_stock_price = number_format("$rs_result_q->stock_price", 2, '.', '');
$rs_avg_cost = number_format("$rs_result_q->avg_cost", 2, '.', '');
$inventoryarray[$rs_stock_id]['title'] = "$rs_stock_title";
$inventoryarray[$rs_stock_id]['price'] = "$rs_stock_price";
$inventoryarray[$rs_stock_id]['avgcost'] = "$rs_avg_cost";

checkstorecount($rs_stock_id);

$rs_find_qty = "SELECT * FROM stockcounts WHERE stockid = '$rs_stock_id'";
$rs_result_qty = mysqli_query($rs_connect, $rs_find_qty);
while($rs_result_qtyq = mysqli_fetch_object($rs_result_qty)) {
$stockqty = "$rs_result_qtyq->quantity";
$storeid = "$rs_result_qtyq->storeid";
$inventoryarray[$rs_stock_id]['storeids'][$storeid] = $stockqty;
}
}



$rs_find_sold = "SELECT SUM(sold_items.quantity) AS quantity,sold_items.stockid,receipts.storeid FROM sold_items,receipts 
WHERE sold_items.date_sold > '$ondate' AND receipts.receipt_id = sold_items.receipt AND sold_items.stockid != '0' AND sold_items.sold_type = 'purchase' 
GROUP BY sold_items.stockid,receipts.storeid";
$rs_result_sold = mysqli_query($rs_connect, $rs_find_sold);
while($rs_result_sold_q = mysqli_fetch_object($rs_result_sold)) {
$quantity = "$rs_result_sold_q->quantity";
$rs_stock_id = "$rs_result_sold_q->stockid";
$rs_store_id = "$rs_result_sold_q->storeid";
checkstorecount($rs_stock_id);
$inventoryarray[$rs_stock_id]['storeids'][$rs_store_id] = $inventoryarray[$rs_stock_id]['storeids'][$rs_store_id] + $quantity;
}

$rs_find_sold = "SELECT SUM(sold_items.quantity) AS quantity,sold_items.stockid,receipts.storeid FROM sold_items,receipts
WHERE sold_items.date_sold > '$ondate' AND receipts.receipt_id = sold_items.receipt AND sold_items.stockid != '0' AND sold_items.sold_type = 'refund'
GROUP BY sold_items.stockid,receipts.storeid";
$rs_result_sold = mysqli_query($rs_connect, $rs_find_sold);
while($rs_result_sold_q = mysqli_fetch_object($rs_result_sold)) {
$quantity = "$rs_result_sold_q->quantity";
$rs_stock_id = "$rs_result_sold_q->stockid";
$rs_store_id = "$rs_result_sold_q->storeid";
checkstorecount($rs_stock_id);
$inventoryarray[$rs_stock_id]['storeids'][$rs_store_id] = $inventoryarray[$rs_stock_id]['storeids'][$rs_store_id] - $quantity;
}

$rs_find_sold = "SELECT SUM(inv_quantity) AS quantity, stock_id, storeid FROM inventory
WHERE inv_date > '$ondate'
GROUP BY stock_id,storeid";
$rs_result_sold = mysqli_query($rs_connect, $rs_find_sold);
while($rs_result_sold_q = mysqli_fetch_object($rs_result_sold)) {
$quantity = "$rs_result_sold_q->quantity";
$rs_stock_id = "$rs_result_sold_q->stock_id";
$rs_store_id = "$rs_result_sold_q->storeid";
checkstorecount($rs_stock_id);
$inventoryarray[$rs_stock_id]['storeids'][$rs_store_id] = $inventoryarray[$rs_stock_id]['storeids'][$rs_store_id] - $quantity;
}




#echo "<pre>";
#print_r($inventoryarray);
#exit;



$totalcostprice = 0;
$totalretailprice = 0;
echo "<center><h3>".pcrtlang("Inventory")."</h3>";

echo "<span class=sizemelarge>".pcrtlang("Inventory Date").": $ondate &nbsp; &nbsp; &nbsp;".pcrtlang("Generated Date").": ".date("Y-m-d")."</span><br><br>";

echo "<span class=\"sizemesmaller italme\">".pcrtlang("Note: This inventory report is calculated using current stock levels and adding/subtracting sales and additions to inventory.")."</span><br><br>";

echo "<span class=\"sizemesmaller italme\">".pcrtlang("Note: The inventory values are calculated based on current cost average values.")."</span><br><br>";

echo "<span class=\"sizemesmaller italme\">".pcrtlang("Note: This report cannot account for manual inventory adjustments or corrections.")."</span><br><br>";

if ($orderby == "stockid") {
echo "<a href=inv_avg_pit.php?orderby=cat&ondate=$ondate>".pcrtlang("Categories")."</a> | ".pcrtlang("Stock ID");
} else {
echo pcrtlang("Categories")." | <a href=inv_avg_pit.php?orderby=stockid&ondate=$ondate>".pcrtlang("Stock ID")."</a>";
}

echo "<br><br>";

echo "<table class=standard>";
echo "<tr><th>".pcrtlang("Stock ID")."</th><th>".pcrtlang("Stock Name")."</th><th>".pcrtlang("Store Quantity")."</th><th>".pcrtlang("Total Quantity")."</th><th>".pcrtlang("Our Price")."</th><th>".pcrtlang("Retail Price")."</th>";
echo "<th>".pcrtlang("Our Price Total")."</th><th>".pcrtlang("Retail Price Total")."</th></tr>";

foreach($inventoryarray as $key => $value) {

$rs_stock_id = "$key";
$rs_stock_title = $value['title'];
$rs_price = $value['price'];
$rs_avgcost = $value['avgcost'];

echo "<tr><td><b>$rs_stock_id</b></td><td>$rs_stock_title</td><td>";

$rs_num=0;
foreach($value['storeids'] as $key2 => $value2) {
echo "$storesarray[$key2]: <span class=boldme>$value2</span><br>";
$rs_num = $rs_num + $value2;
}

if ($rs_num < 0) {
$rs_num = "<span class=\"colormered\"><b>$rs_num</b></span>";
} else {
$rs_num = "$rs_num";
}

if ($rs_num > 0) {
$subtotal = number_format(($rs_num * $rs_avgcost), 2, '.', '');
$subtotal2 = number_format(($rs_num * $rs_price), 2, '.', '');
} else {
$subtotal = "0.00";
$subtotal2 = "0.00";
}

$totalcostprice = $totalcostprice + $subtotal;
$totalretailprice = $totalretailprice + $subtotal2;

echo "</td><td align=right><b>$rs_num</b></td><td align=right>$money".mf("$rs_avgcost")."</td><td align=right>$money$rs_price</td><td align=right>";

echo "$money$subtotal</td><td align=right>$money$subtotal2</td></tr>";
}



echo "</table>";

$tcp = number_format($totalcostprice, 2, '.', '');
$trp = number_format($totalretailprice, 2, '.', '');

echo pcrtlang("Total value (Our Price Paid) is")." $money$tcp<br>";
echo pcrtlang("Total value (Retail) is")." $money$trp";


printablefooter();
