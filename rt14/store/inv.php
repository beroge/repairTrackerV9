<?php

/***************************************************************************
 *   copyright            : (C) 2012 PCRepairTracker.com
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


printableheader("Inventory");




if ($orderby == "stockid") {
$rs_find_stock = "SELECT stock.stock_id,stock.stock_title,stock.stock_price, SUM(stockcounts.quantity) AS stock_quantity FROM stock,stockcounts WHERE stock.dis_cont = '0' AND stockcounts.stockid = stock.stock_id GROUP BY stock.stock_id ORDER BY stock.stock_id";
} else {
$rs_find_stock = "SELECT stock.stock_id,stock.stock_title,stock.stock_price, SUM(stockcounts.quantity) AS stock_quantity FROM stock,stockcounts WHERE stock.dis_cont = '0' AND stockcounts.stockid = stock.stock_id GROUP BY stock.stock_id ORDER BY stock.stock_cat";
}

$rs_result = mysqli_query($rs_connect, $rs_find_stock);

$a = 0;
$p = 0;
$rp = 0;
echo "<center><h3>".pcrtlang("Inventory")."</h3>";

if ($orderby == "stockid") {
echo "<a href=inv.php?orderby=cat>".pcrtlang("Categories")."</a> | ".pcrtlang("Stock ID");
} else {
echo pcrtlang("Categories")." | <a href=inv.php?orderby=stockid>".pcrtlang("Stock ID")."</a>";
}

echo "<br>";

echo "<table class=standard>";
echo "<tr><th>".pcrtlang("Stock ID")."</th><th>".pcrtlang("Stock Name")."</th><th>".pcrtlang("Store Quantity")."</th><th align=right>".pcrtlang("Total Quantity")."</th><th align=right>".pcrtlang("Our Price")."</th><th align=right>".pcrtlang("Retail Price")."</th>";
echo "<th align=right>".pcrtlang("Our Price Total")."</th><th align=right>".pcrtlang("Retail Price Total")."</th></tr>";

while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_stock_id = "$rs_result_q->stock_id";
$rs_stock_title = "$rs_result_q->stock_title";
$rs_stock_price = number_format("$rs_result_q->stock_price", 2, '.', '');
$rs_num = "$rs_result_q->stock_quantity";

$rs_find_price = "SELECT * FROM inventory WHERE stock_id = '$rs_stock_id'  ORDER BY inv_date DESC LIMIT 1";
$rs_resultp = mysqli_query($rs_connect, $rs_find_price);
while($rs_result_qp = mysqli_fetch_object($rs_resultp)) {
$rs_price = number_format("$rs_result_qp->inv_price", 2, '.', '');

if ($rs_num > 0) {
$subtotal = number_format(($rs_num * $rs_price), 2, '.', '');
$subtotal2 = number_format(($rs_num * $rs_stock_price), 2, '.', '');
} else {
$subtotal = "0.00";
$subtotal2 = "0.00";
}

if ($rs_num < 0) {
$rs_num2 = "<span class=\"colormered boldme\">$rs_num</span>";
} else {
$rs_num2 = "$rs_num";
}

$a = $a + $subtotal;
echo "<tr><td><b>$rs_stock_id</b></td><td>$rs_stock_title</td><td>";

$rs_find_stores = "SELECT * FROM stores ORDER BY storesname ASC";
$rs_result_stores = mysqli_query($rs_connect, $rs_find_stores);
while($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
$rs_storesname = "$rs_result_storeq->storesname";
$rs_storeid = "$rs_result_storeq->storeid";

$rs_find_stock = "SELECT quantity FROM stockcounts WHERE storeid = '$rs_storeid' AND stockid = '$rs_stock_id'";
$rs_result_stock = mysqli_query($rs_connect, $rs_find_stock);
if(mysqli_num_rows($rs_result_stock) != 0) {
$rs_result_stockq = mysqli_fetch_object($rs_result_stock);
$stockqty = "$rs_result_stockq->quantity";
echo "$rs_storesname: <span class=boldme>$stockqty</span></font><br>";
}

}

echo "</td><td align=right><b>$rs_num2</b></td><td align=right>$money$rs_price</td><td align=right>$money$rs_stock_price</td><td align=right>";

$p = $p + $subtotal;
$rp = $rp + $subtotal2;

echo "$money$subtotal</td><td align=right>$money$subtotal2</td></tr>";
}
}


echo "</table>";

$pf = number_format($p, 2, '.', '');
$rpf = number_format($rp, 2, '.', '');

echo pcrtlang("Total value (Our Price Paid) is")." $money$pf<br>";
echo pcrtlang("Total value (Retail) is")." $money$rpf";


printablefooter();
