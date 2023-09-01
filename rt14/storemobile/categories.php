<?php

/***************************************************************************
 *   copyright            : (C) 2012 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/

if (array_key_exists('func',$_REQUEST)) {
$func = "$_REQUEST[func]";
} else {
$func = "";
}

                                                                                                    
function show_cats() {
require_once("header.php");

perm_boot("6");

require_once("catnav.php");
echo "<br>";
require("deps.php");

updatecategories();

$rs_insert_main_cat = "SELECT * FROM maincats ORDER BY cat_name ASC";
$rs_result = mysqli_query($rs_connect, $rs_insert_main_cat);


echo "<table class=standard><tr><th colspan=2>".pcrtlang("Categories")."</th></tr></table>";

echo "<div data-role=\"collapsible-set\">";

while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_catid = "$rs_result_q->cat_id";
$rs_catname = "$rs_result_q->cat_name";
$rs_cattotal = "$rs_result_q->cat_total_items";

echo "<div data-role=\"collapsible\" data-theme=\"a\" data-mini=\"true\">";
echo "<h3>$rs_catname</h3>";

echo "<button type=button onClick=\"parent.location='categories.php?func=edit_main_cat&maincat_id=$rs_catid'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" data-mini=\"true\"><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("Edit Main Category")."</button>";

if ($rs_cattotal == "0") {
echo "<button type=button onClick=\"parent.location='categories.php?func=delete_main_cat&maincat_id=$rs_catid'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" data-mini=\"true\"><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete Main Category")."</button>";
}





$rs_find_sub_cat = "SELECT * FROM sub_cats WHERE sub_cat_parent = '$rs_catid' ORDER BY sub_cat_name ASC";
$rs_find_result = mysqli_query($rs_connect, $rs_find_sub_cat);

echo "<table class=standard>";

while($rs_find_result_q = mysqli_fetch_object($rs_find_result)) {
$rs_subcatid = "$rs_find_result_q->sub_cat_id";
$rs_subcatname = "$rs_find_result_q->sub_cat_name";
$rs_subcat_items = "$rs_find_result_q->sub_cat_item_total";

$rs_find_item = "SELECT * FROM stock WHERE stock_cat = '$rs_subcatid' AND dis_cont = '0'";
$rs_find_item_result = mysqli_query($rs_connect, $rs_find_item);

$countitem = mysqli_num_rows($rs_find_item_result);

echo "<tr><td><button type=button onClick=\"parent.location='categories.php?func=show_stock&category=$rs_subcatid'\" class=\"ui-btn ui-corner-all ui-shadow ui-mini\">$rs_subcatname ($countitem)</button><br>";
echo "<button type=button onClick=\"parent.location='categories.php?func=edit_sub_cat&subcat_id=$rs_subcatid'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline ui-mini\"><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("Edit")."</button>";

if ($rs_subcat_items == "0") {
echo "<button type=button onClick=\"parent.location='categories.php?func=delete_sub_cat&subcat_id=$rs_subcatid'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline ui-mini\"><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")."</button>";
}


echo "</td></tr>";


}

echo "</table></div>";

}

echo "</div>";

require("footer.php");
                                                                                                    
}

                                                                                                    
function add_main_cat() {
require("dheader.php");

perm_boot("6");

dheader(pcrtlang("New Main Category"));

echo "<form method=post action=categories.php?func=add_main_cat2  data-ajax=\"false\">";
echo "<input type=text name=title><input type=submit value=\"".pcrtlang("Create New Main Category")."\" data-theme=\"b\"></form>";

dfooter();

require("dfooter.php");
                                                                                                    
}
                                                                                                    

function add_main_cat2() {

require("deps.php");
require("common.php");

perm_boot("6");

$title = pv($_REQUEST[title]);




$rs_insert_main_cat = "INSERT INTO maincats (cat_name) VALUES ('$title')";
@mysqli_query($rs_connect, $rs_insert_main_cat);

header("Location: categories.php");
                                                                                                    
}


function edit_main_cat() {

$maincat_id = "$_REQUEST[maincat_id]";

require("dheader.php");

perm_boot("6");

dheader(pcrtlang("Edit Category"));

include("deps.php");



$rs_insert_main_cat = "SELECT * FROM maincats WHERE cat_id = '$maincat_id'";
$rs_result = mysqli_query($rs_connect, $rs_insert_main_cat);
                                                                                                    
                                                                                                    
while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_catname = "$rs_result_q->cat_name";


echo "<form method=post action=categories.php?func=edit_main_cat2 data-ajax=\"false\">";
echo "<input type=hidden name=maincat_id value=\"$maincat_id\">";
echo "<input type=\"text\" name=\"title\" value=\"$rs_catname\"> <input type=submit value=\"".pcrtlang("Edit Main Category")."\" data-theme=\"b\"></form>";
}

dfooter();

require("dfooter.php");
                                                                                                    
}


function edit_main_cat2() {

require("deps.php");
require("common.php");

perm_boot("6");

$title = pv($_REQUEST[title]);
$maincat_id = "$_REQUEST[maincat_id]";




$rs_insert_main_cat = "UPDATE maincats SET cat_name = '$title' WHERE cat_id = '$maincat_id'";
@mysqli_query($rs_connect, $rs_insert_main_cat);

header("Location: categories.php");

}

function add_sub_cat() {
include("deps.php");
require("dheader.php");

perm_boot("6");


dheader(pcrtlang("New Sub Category"));


echo "<form method=post action=categories.php?func=add_sub_cat2 data-ajax=\"false\">";
echo pcrtlang("Sub Category Name").":<input type=text name=title>";
echo pcrtlang("Main Category").":<select name=maincat_id>";



$rs_insert_main_cat = "SELECT * FROM maincats ORDER BY cat_name ASC";
$rs_result = mysqli_query($rs_connect, $rs_insert_main_cat);


while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_catname = "$rs_result_q->cat_name";
$rs_catid = "$rs_result_q->cat_id";
echo "<option name=maincat_id value=$rs_catid>$rs_catname</option>";
}

echo "</select>";


echo "<input type=submit value=\"".pcrtlang("Add New Sub Category")."\" data-theme=\"b\"></form>";

dfooter();

require("dfooter.php");

}

function add_sub_cat2() {

require("deps.php");
require("common.php");

perm_boot("6");

$title = pv($_REQUEST['title']);
$maincat_id = "$_REQUEST[maincat_id]";




$rs_insert_sub_cat = "INSERT INTO sub_cats (sub_cat_name,sub_cat_parent) VALUES ('$title','$maincat_id')";
@mysqli_query($rs_connect, $rs_insert_sub_cat);

header("Location: categories.php");

}


function edit_sub_cat() {

$subcat_id = "$_REQUEST[subcat_id]";
include("deps.php");
require("dheader.php");

perm_boot("6");

dheader(pcrtlang("Edit Sub Category"));





$rs_findsubcat = "SELECT * FROM sub_cats WHERE sub_cat_id = '$subcat_id'";
$rs_subcat_result = mysqli_query($rs_connect, $rs_findsubcat);


while($rs_result_q = mysqli_fetch_object($rs_subcat_result)) {
$rs_catname = "$rs_result_q->sub_cat_name";
$rs_catparent = "$rs_result_q->sub_cat_parent";


echo "<form method=post action=categories.php?func=edit_sub_cat2 data-ajax=\"false\">";
echo pcrtlang("Sub Category Name").":<input type=text name=title value=\"$rs_catname\">";
echo pcrtlang("Main Category").":<select name=maincat_id>";
echo "<option selected value=$rs_catparent>".pcrtlang("Leave in Existing Category");

$rs_find_main_cat = "SELECT * FROM maincats ORDER BY cat_name";
$rs_maincat_result = mysqli_query($rs_connect, $rs_find_main_cat);
                                                                                                                             
while($rs_maincat_result_q = mysqli_fetch_object($rs_maincat_result)) {
$rs_maincatname = "$rs_maincat_result_q->cat_name";
$rs_catid = "$rs_maincat_result_q->cat_id";

echo "<option value=$rs_catid>$rs_maincatname</option>";
}

}                                                                                                                             
echo "</select>";
echo "<input type=submit value=\"".pcrtlang("Edit Sub Category")."\" data-theme=\"b\"><input type=hidden name=subcat_id value=$subcat_id></form>";

dfooter();
                                                                                                                             
require("dfooter.php");
                                                                                                                             
}


function edit_sub_cat2() {

require("deps.php");
require("common.php");

perm_boot("6");

$title = pv($_REQUEST[title]);
$maincat_id = "$_REQUEST[maincat_id]";
$subcat_id = "$_REQUEST[subcat_id]";
                                                                                                                                               
                                                                                                                                               



$rs_insert_sub_cat = "UPDATE sub_cats SET sub_cat_name = '$title', sub_cat_parent = '$maincat_id' WHERE sub_cat_id = '$subcat_id'";
@mysqli_query($rs_connect, $rs_insert_sub_cat);
                                                                                                                                               
header("Location: categories.php");
                                                                                                                                               
}


function show_stock() {

$category = "$_REQUEST[category]";

require("header.php");
require("deps.php");
               
perm_boot("6");
                                                                                                                                



$rs_show_stock = "SELECT * FROM stock WHERE stock_cat = '$category' AND dis_cont = '0'";
                                                                                                                                               
$rs_stock_result = mysqli_query($rs_connect, $rs_show_stock);

while($rs_stock_result_q = mysqli_fetch_object($rs_stock_result)) {
$rs_stockid = "$rs_stock_result_q->stock_id";
$rs_stocktitle = "$rs_stock_result_q->stock_title";
$rs_stockdesc = "$rs_stock_result_q->stock_desc";
$rs_stockprice = "$rs_stock_result_q->stock_price";
$rs_stockupc = "$rs_stock_result_q->stock_upc";          

echo "<table class=standard><tr><th>".pcrtlang("$rs_stocktitle &bull; #$rs_stockid")."</th></tr><tr><td>";

#echo "<table class=standard><tr><td>";

                                                                                                                               
$rs_find_stock_count_c = "SELECT quantity FROM stockcounts WHERE stockid = '$rs_stockid' AND quantity > '0'";
$rs_result_sc_c = mysqli_query($rs_connect, $rs_find_stock_count_c);       
$stockcountresult = mysqli_num_rows($rs_result_sc_c);

echo pcrtlang("Price").": $money".mf("$rs_stockprice");

if ($rs_stockupc != 0) {
echo "<br>".pcrtlang("Item UPC#")." $rs_stockupc";
}


if ($stockcountresult == 0) {
if (perm_check("36")) {
echo "<button type=button onClick=\"parent.location='categories.php?func=discont&stock_id=$rs_stockid&categ=$category'\">".pcrtlang("Mark as Discontinued")."</button>";
}
}
echo "<form method=post action=categories.php?func=alterstock data-ajax=\"false\"><input type=hidden name=category value=$category><input type=hidden name=stockid value=$rs_stockid>";

checkstorecount($rs_stockid);

echo "</td></tr><tr><td><table class=standard>";
$rs_find_stores = "SELECT * FROM stores WHERE storeenabled = '1' ORDER BY storesname ASC";
$rs_result_stores = mysqli_query($rs_connect, $rs_find_stores);
while($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
$rs_storesname = "$rs_result_storeq->storesname";
$rs_storeid = "$rs_result_storeq->storeid";

$rs_find_stock = "SELECT * FROM stockcounts WHERE storeid = '$rs_storeid' AND stockid = '$rs_stockid'";
$rs_result_stock = mysqli_query($rs_connect, $rs_find_stock);
$rs_result_stockq = mysqli_fetch_object($rs_result_stock);
$stockqty = "$rs_result_stockq->quantity";

$stockqtyarray[$rs_storeid] = $stockqty;

echo "<tr><td>$rs_storesname:</td><td><input type=textbox name=\"store$rs_storeid\" value=\"$stockqty\"></td></tr>";

$checkopeninvoices = "SELECT invoice_items.cart_stock_id FROM invoice_items,invoices WHERE invoice_items.cart_stock_id = '$rs_stockid' AND invoice_items.invoice_id = invoices.invoice_id AND invoices.invstatus = '1' AND invoices.storeid = '$rs_storeid' AND invoices.iorq != 'quote'";
$checkopeninvoices_q = mysqli_query($rs_connect, $checkopeninvoices);
$countoninvoices = mysqli_num_rows($checkopeninvoices_q);

$thetotalitemsinv = array();

if ($countoninvoices > 0) {
if(!isset($itemsonopen)) {
$itemsonopen = pcrtlang("Items on Open Invoices").": <br>";
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
$itemsonopenwo = pcrtlang("Items On Open Work Orders").": <br>";
}
$itemsonopenwo .= "$rs_storesname: $countonwo<br>";
$thetotalitemswo[$rs_storeid] = $countonwo;
} else {
$thetotalitemswo[$rs_storeid] = 0;
}


$tavail = ($stockqtyarray[$rs_storeid] - $thetotalitemsinv[$rs_storeid]) - $thetotalitemswo[$rs_storeid];

unset($thetotalitemsinv);
unset($thetotalitemswo);

if(!isset($countavail)) {
$countavail = pcrtlang("Estimated Items Available").": <br>";
}
$countavail .= "$rs_storesname: $tavail<br>";


}


echo "<tr><td colspan=2><input type=submit value=\"".pcrtlang("Change Qty")."\"></form>";
echo "<button type=button onClick=\"parent.location='stock.php?func=show_stock_detail&stockid=$rs_stockid'\">".pcrtlang("Item Details")."</button></td></tr></table></td></tr>";


########
if(isset($itemsonopen)) {
echo "<tr><td style=\"vertical-align:top;\">";
echo "$itemsonopen";
echo "</td></tr>";
}

unset($itemsonopen);

if(isset($itemsonopenwo)) {
echo "<tr><td style=\"vertical-align:top;\">";
echo "$itemsonopenwo";
echo "</td></tr>";
}

unset($itemsonopenwo);

if(isset($countavail)) {
echo "<tr><td style=\"vertical-align:top;\">";
echo "$countavail";
echo "</td></tr>";
}

unset($countavail);

#######


if(isset($itemsonopen)) {
echo "<tr><td>$itemsonopen</td></tr>";
}
unset($itemsonopen);

echo "<tr><td>";

$rs_show_photo = "SELECT * FROM photos WHERE stock_item = '$rs_stockid'";
$rs_photo_result = mysqli_query($rs_connect, $rs_show_photo);
$rs_show_photo = "SELECT * FROM photos WHERE stock_item = '$rs_stockid'";
$rs_photo_result = mysqli_query($rs_connect, $rs_show_photo);
while($rs_photo_result_q = mysqli_fetch_object($rs_photo_result)) {
$rs_filename = "$rs_photo_result_q->photo_filename";
echo "<img src=stock.php?func=getinvimage&photo_name=ths_$rs_filename class=productimage><br><br>";
}


echo "</td></tr></table>";

echo "</td></tr></table>";
echo "<br><br>";
}

require("footer.php");


                                                                                                                                               
}


function discont() {

$stock_id = "$_REQUEST[stock_id]";
$categ = "$_REQUEST[categ]";

include("deps.php");
include_once("common.php");
perm_boot("6");




$rs_insert_sub_cat = "UPDATE stock SET dis_cont = '1' WHERE stock_id = '$stock_id'";
@mysqli_query($rs_connect, $rs_insert_sub_cat);

header("Location: categories.php?func=show_stock&category=$categ");

}

function alterstock() {

$category = "$_REQUEST[category]";
$stockid = "$_REQUEST[stockid]";

include("deps.php");
include_once("common.php");

perm_boot("6");




$rs_find_stores = "SELECT * FROM stores WHERE storeenabled = '1' ORDER BY storesname ASC";
$rs_result_stores = mysqli_query($rs_connect, $rs_find_stores);
while($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
$rs_storeid = "$rs_result_storeq->storeid";

$thecount =  $_REQUEST["store$rs_storeid"];
if (is_numeric("$thecount")) {
$rs_insert_stock = "UPDATE stockcounts SET quantity = '$thecount' WHERE stockid = '$stockid' AND storeid = '$rs_storeid'";
@mysqli_query($rs_connect, $rs_insert_stock);
}
}


header("Location: categories.php?func=show_stock&category=$category");

}



function delete_main_cat() {

$maincat_id = "$_REQUEST[maincat_id]";
include("deps.php");
if ($demo == "yes") {
die("Sorry this feature is disabled in demo mode");
}

include_once("common.php");

perm_boot("6");




$rs_insert_sub_cat = "DELETE FROM maincats WHERE cat_id = '$maincat_id'";
@mysqli_query($rs_connect, $rs_insert_sub_cat);

header("Location: categories.php");

}

function delete_sub_cat() {

$subcat_id = "$_REQUEST[subcat_id]";
include("deps.php");
if ($demo == "yes") {
die("Sorry this feature is disabled in demo mode");
}

include_once("common.php");

perm_boot("6");




$rs_insert_sub_cat = "DELETE FROM sub_cats WHERE sub_cat_id = '$subcat_id'";
@mysqli_query($rs_connect, $rs_insert_sub_cat);

header("Location: categories.php");

}


function inventorytools() {

require("header.php");

perm_boot("6");

require("catnav.php");
echo "<br>";

echo "<table class=standard><tr><th>".pcrtlang("Inventory Tools")."</th></tr><tr><td>";

echo "<button type=button onClick=\"parent.location='stock.php?func=fixinv'\">".pcrtlang("Inventory Re-Counting")."</button><br>";
echo pcrtlang("Use this tool with your scan gun to re-count your inventory").".<br><br>";

echo pcrtlang("Show Uncounted Inventory Before").":<br>";

$thedate = date("Y-m-d", strtotime('-1 month'));
echo "<form action=stock.php?func=fixinv4 method=post data-ajax=\"false\">";
echo pcrtlang("Enter Date").":<input type=text name=thedate value=\"$thedate\">";
echo "<input type=submit value=\"".pcrtlang("Show Report")."\"></form>";
echo "<br>";


echo pcrtlang("Use this report to show uncounted inventory prior to the specified date with positive stock counts").".<br><br>";


echo "</td></tr></table>";

include("deps.php");


require("footer.php");

}



function stockrecount() {

require("header.php");
require("deps.php");





$rs_find_so = "SELECT * FROM stockcounts WHERE reqcount = '1' AND storeid = '$defaultuserstore'";
$rs_result_so = mysqli_query($rs_connect, $rs_find_so);

$storeinfoarray = getstoreinfo($defaultuserstore);

start_blue_box(pcrtlang("Stock Recount Requests")." | ".pcrtlang("Store").": $storeinfoarray[storesname]");

if(mysqli_num_rows($rs_result_so) > 0) {
echo "<table style=\"padding-left:10px;padding-right:10px;\" class=stocklist>";
echo "<tr><th><font class=text12b>".pcrtlang("Stock ID")."</font></th><th><font class=text12b>".pcrtlang("Stock Name")."</font></th>";
echo "<th style=\"padding-left:10px;padding-right:10px;\"><font class=text12b>".pcrtlang("Current Count")."</font></th>";
echo "<th></th>";
echo "</tr>";

while($rs_result_item_q = mysqli_fetch_object($rs_result_so)) {
$stockcountid = "$rs_result_item_q->stockcountid";
$stockid = "$rs_result_item_q->stockid";
$stockquantity = "$rs_result_item_q->quantity";


$rs_show_stock = "SELECT * FROM stock WHERE stock_id = '$stockid'";
$rs_stock_result = mysqli_query($rs_connect, $rs_show_stock);
$rs_stock_result_q = mysqli_fetch_object($rs_stock_result);
$stockname = "$rs_stock_result_q->stock_title";



echo "<tr><td><font class=text12>$stockid</font></td><td><font class=text12>$stockname</font></td>";

echo "<td><form action=categories.php?func=savestockrecount method=post><input type=text name=stockquantity class=textbox value=\"$stockquantity\" style=\"width:50px;\"><input type=hidden name=stockcountid value=\"$stockcountid\"></td>";

echo "<td><button class=button><i class=\"fa fa-save\"></i> Save</button></form></td>";

echo "</tr>";

}

echo "</table>";

} else {

echo "<font class=text10i>".pcrtlang("No Pending Recount Requests")."...</font>";

}


stop_box();

require("footer.php");
}



function savestockrecount() {

require("deps.php");
require("common.php");

$stockquantity = pv($_REQUEST[stockquantity]);
$stockcountid = "$_REQUEST[stockcountid]";




$rs_updatecount = "UPDATE stockcounts SET quantity = '$stockquantity', reqcount = '0' WHERE stockcountid = '$stockcountid'";
@mysqli_query($rs_connect, $rs_updatecount);

header("Location: categories.php?func=stockrecount");

}


switch($func) {
                                                                                                    
    default:
    show_cats();
    break;
                                                                                                    
    case "add_main_cat":
    add_main_cat();
    break;

    case "add_main_cat2":
    add_main_cat2();
    break;

    case "edit_main_cat":
    edit_main_cat();
    break;

    case "edit_main_cat2":
    edit_main_cat2();
    break;

    case "add_sub_cat":
    add_sub_cat();
    break;

    case "add_sub_cat2":
    add_sub_cat2();
    break;

    case "edit_sub_cat":
    edit_sub_cat();
    break;

    case "edit_sub_cat2":
    edit_sub_cat2();
    break;

    case "show_stock":
    show_stock();
    break;

    case "discont":
    discont();
    break;

 case "delete_sub_cat":
    delete_sub_cat();
    break;

 case "delete_main_cat":
    delete_main_cat();
    break;


    case "alterstock":
    alterstock();
    break;

    case "inventorytools":
    inventorytools();
    break;

    case "stockrecount":
    stockrecount();
    break;

    case "savestockrecount":
    savestockrecount();
    break;



}

?>
