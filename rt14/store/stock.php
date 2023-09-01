<?php

/***************************************************************************
 *   copyright            : (C) 2021 PCRepairTracker.com
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
require("header.php");

perm_boot("6");

start_blue_box(pcrtlang("Add New Stock Item"));

?>
<script src="../repair/jq/select2.min.js"></script>
<link rel="stylesheet" href="../repair/jq/select2.min.css">

<?php

echo "<span class=\"colormered sizemelarger\"><i class=\"fa fa-warning fa-lg\"></i> ".pcrtlang("Do not add items that have been previously stocked here!")."</span><br><br>";

echo "<form action=stock.php?func=add_new_stock2 method=post name=newinv>";
echo "<table width=100%>";
echo "<tr><td>".pcrtlang("Name of Product").":</td><td><input size=35 type=text class=textbox name=productname></td></tr>";
echo "<tr><td>".pcrtlang("Product UPC")."#</td><td><input size=35 type=text class=textbox name=productupc></td></tr>";
echo "<tr><td>".pcrtlang("Product Category").":</td><td><select name=category class=\"select-cat\">";





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

echo "</select></td></tr>";

?>

<script>
function markup() {
var marknum = Math.ceil((document.newinv.ourprice.value - 0) * (document.newinv.chooser.value - 0)) - document.newinv.cents.value;
document.newinv.sellprice.value = marknum.toFixed(2);
}
</script>


<?php


echo "<tr><td>".pcrtlang("Product Description").":</td><td><textarea class=\"textbox textarea\" name=prod_desc cols=60 rows=5></textarea></td></tr>";
echo "<tr><td>".pcrtlang("Printed Description").":</td><td><textarea class=\"textbox textarea\" name=stock_pdesc cols=60 rows=5></textarea></td></tr>";
echo "<tr><td>".pcrtlang("Selling Price").":</td><td>$money<input size=10 type=text class=textbox name=sellprice id=sellprice>";

$usertaxid = getusertaxid();
$salestaxrateremain = (1 + getsalestaxrate($usertaxid));
if($salestaxrateremain != 1) {
echo "<button class=button type=button onclick='document.getElementById(\"sellprice\").value=(document.getElementById(\"sellprice\").value / $salestaxrateremain).toFixed(5);'>
<i class=\"fa fa-calculator\"></i> ".pcrtlang("Pre-tax")."</button>";
}


echo "</td></tr>";



echo "<tr><td>".pcrtlang("Unit Cost").":</td><td>$money<input size=10 type=text class=textbox name=ourprice></td></tr>";

echo "<tr><td>".pcrtlang("Markup").": </td><td>";
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


echo "</td></tr>";


echo "<tr><td>".pcrtlang("Quantity to Stock").":</td><td align=center><span class=\"sizemesmaller italme\">".pcrtlang("Enter serials and codes one per line").".</span></td></tr>";

$rs_find_stores = "SELECT * FROM stores WHERE storeenabled = '1' ORDER BY storesname ASC";
$rs_result_stores = mysqli_query($rs_connect, $rs_find_stores);
while($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
$rs_storesname = "$rs_result_storeq->storesname";
$rs_storeid = "$rs_result_storeq->storeid";

echo "<tr><td align=right>$rs_storesname:</td><td><table><tr><td><input type=text class=textbox size=3 name=store$rs_storeid value=0>";
echo "</td><td>&nbsp;</td><td>";
echo "<span class=\"sizemesmaller italme\">".pcrtlang("serials/codes").":</span></td><td><textarea name=storeserial$rs_storeid rows=2 cols=40 class=\"textbox textarea\"></textarea></td></tr></table></td></tr>";

}

echo "<tr><td>".pcrtlang("Pick Supplier").":</td><td><select name=supplierid>";

echo "<option value=0>".pcrtlang("Manually Entered Supplier")."</option>";

$rs_find_suppliers = "SELECT * FROM suppliers ORDER BY suppliername ASC";
$rs_result_supp = mysqli_query($rs_connect, $rs_find_suppliers);

while($rs_result_suppq = mysqli_fetch_object($rs_result_supp)) {
$suppliername = "$rs_result_suppq->suppliername";
$supplierid = "$rs_result_suppq->supplierid";

echo "<option value=$supplierid>$suppliername</option>";

}
echo "</select></td></tr>";

echo "<tr><td>".pcrtlang("Supplier Name")."</td><td><input size=35 type=text class=textbox name=suppliername></td></tr>";
echo "<tr><td>".pcrtlang("Supplier Part No.")."</td><td><input size=35 type=text class=textbox name=partnumber></td></tr>";
echo "<tr><td>".pcrtlang("Part URL")."</td><td><input size=35 type=text class=textbox name=parturl></td></tr>";
echo "<tr><td>".pcrtlang("Purchase Order")."</td><td><input size=35 type=text class=textbox name=ponumber></td></tr>";

echo "<tr><td>&nbsp;</td><td><input type=submit value=\"".pcrtlang("Add New Item")."\" class=button onclick=\"this.disabled=true;this.value='".pcrtlang("Adding New Item")."...'; this.form.submit();\"></td></tr>";
echo "</table>";

?>

<script>
$(document).ready(function() {
    $('.select-cat').select2();
});
</script>


<?php


stop_blue_box();

?>
<script>
$(":input").not('.textarea').keypress(function(event){
    if (event.which == '10' || event.which == '13') {
        event.preventDefault();
    }
});
</script>
<?php

require_once("footer.php");

                                                                                                    
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
$ponumber = pv($_REQUEST['ponumber']);




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
$rs_insert_inv = "INSERT INTO inventory (stock_id,inv_price,inv_quantity,inv_date,storeid,itemserial,supplierid,suppliername,parturl,partnumber,ponumber) VALUES  ('$lastinsert','$ourprice','$thecount','$currentdatetime','$rs_storeid','$itemserial','$supplierid','$suppliername','$parturl','$partnumber','$ponumber')";
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

start_gray_box("$rs_stocktitle &bull; #$rs_stockid");

echo "<table style=\"width:100%;\"><tr><td style=\"width:75%\">";

echo "";
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

echo "$rs_storesname ".pcrtlang("Stock").": <span class=colormegreen>$stockqty</span>&nbsp;&nbsp;";

}

echo "";
echo pcrtlang("Price").": <span class=colormeblue>$money".mf("$rs_stockprice")."</span><br><br>";
echo "<table><tr><td><form action=cart.php?func=add_item method=post><input type=hidden name=stockid value=$rs_stockid>";
echo "<input type=number class=textbox style=\"width:50px;\" name=\"qty\" value=\"1\" min=\"1\" step=\"1\"> ";
echo "<input type=submit class=button value=\"".pcrtlang("Add Item to Cart")."\">";
echo "</form></td><td>&nbsp;&nbsp;&nbsp;</td><td>";
echo "<a href=stock.php?func=show_stock_detail&stockid=$rs_stockid class=\"linkbuttonmedium linkbuttongray radiusall\">".pcrtlang("View Item Details")." <i class=\"fa fa-chevron-right fa-lg\"></i></a></td></tr></table>";
echo "</td><td style=\"width:25%;\" class=productimagebg>";

$rs_show_photo = "SELECT * FROM photos WHERE stock_item = '$rs_stockid'";
$rs_photo_result = mysqli_query($rs_connect, $rs_show_photo);
while($rs_photo_result_q = mysqli_fetch_object($rs_photo_result)) {
$rs_filename = "$rs_photo_result_q->photo_filename";
echo "<img src=stock.php?func=getinvimage&photo_name=ths_$rs_filename class=productimage><br><br>";
}


echo "</td></tr></table>";

stop_gray_box();
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

         
if ($gomodal == 1) {
$therel = "rel=facebox";
} else {
$therel = "";
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
$rs_dis_cont = "$rs_stock_result_q->dis_cont";


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

start_blue_box("$rs_stocktitle - #$rs_stockid");

echo "<table style=\"width:100%\"><tr><td style=\"width:60%;vertical-align:top;\">";
 

echo "<span class=boldme>".pcrtlang("Category").": $rs_mcat_name <i class=\"fa fa-chevron-right\"></i> $rs_scat_name</span><br>";

if ($rs_stockupc != 0) {
echo "<br><span class=boldme>".pcrtlang("Item UPC#")."</span><span class=\"colormeblue boldme\"> $rs_stockupc</span><br>";
}
echo "<br><table class=standard><tr><th>".pcrtlang("Description")."</th></tr><tr><td>$rs_stockdesc</td></tr></table>";

echo "<br><table class=standard><tr><th>".pcrtlang("Printed Description")."</th></tr><tr><td>".nl2br("$rs_stockpdesc")."</td></tr></table><br><br>";

echo "</td><td style=\"width:40%\" class=productimagebg>";

$rs_show_photo = "SELECT * FROM photos WHERE stock_item = '$stockid'";
$rs_photo_result = mysqli_query($rs_connect, $rs_show_photo);
while($rs_photo_result_q = mysqli_fetch_object($rs_photo_result)) {
$rs_filename = "$rs_photo_result_q->photo_filename";
echo "<img src=stock.php?func=getinvimage&photo_name=th_$rs_filename class=productimage><br><br>";

}
                                                                                                                                              
echo "</td></tr></table>";

#####
$invoicelist = "";
$workorderlist = "";
$invoicelistarray = array();
$workorderlistarray = array();

start_box_nested();
echo "<table style=\"width:100%\" class=pad20><tr><td style=\"vertical-align:top\"><span class=\"linkbuttonsmall linkbuttongraylabel radiusall displayblock\">".pcrtlang("Items in Stock")."</span>";

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

echo "$rs_storesname: <span class=\"floatright colormegreen boldme\">$stockqty</span><br>";

$checkopeninvoices = "SELECT invoice_items.quantity,invoice_items.cart_stock_id,invoices.invoice_id,invoices.invname FROM invoice_items,invoices WHERE invoice_items.cart_stock_id = '$rs_stockid' AND invoice_items.invoice_id = invoices.invoice_id AND invoices.invstatus = '1' AND invoices.storeid = '$rs_storeid' AND invoices.iorq != 'quote'";
$checkopeninvoices_q = mysqli_query($rs_connect, $checkopeninvoices);
$countoninvoices = 0;


while($checkopeninvoices_qp = mysqli_fetch_object($checkopeninvoices_q)) {
$invoice_id = "$checkopeninvoices_qp->invoice_id";
$invoice_name = "$checkopeninvoices_qp->invname";
$invoice_qty = "$checkopeninvoices_qp->quantity";
$countoninvoices = $countoninvoices + $invoice_qty;

if(!in_array("$invoice_id", $invoicelistarray)) {
$invoicelist .= "<a href=\"invoice.php?func=printinv&invoice_id=$invoice_id\">#$invoice_id $invoice_name</a><br>";
}

$invoicelistarray[] = $invoice_id;

}


$thetotalitemsinv = array();

if ($countoninvoices > 0) {
if(!isset($itemsonopen)) {
$itemsonopen = "<span class=\"linkbuttonsmall linkbuttongraylabel radiusall displayblock\">".pcrtlang("Items on Open Invoices")."</span>";
}
$itemsonopen .= "$rs_storesname: <span class=\"colormered boldme floatright\">$countoninvoices</span><br>";
$thetotalitemsinv[$rs_storeid] = $countoninvoices;
} else {
$thetotalitemsinv[$rs_storeid] = 0;
}



#####
$countonwo = 0;
$countonwoqty = 0;
$rcarray2 = array();
$rcarray = array();
$fillrcarr = "SELECT pcwo,quantity FROM repaircart WHERE cart_stock_id = '$rs_stockid'";
$fillrcarr_q = mysqli_query($rs_connect, $fillrcarr);
while ($rs_result_frca = mysqli_fetch_object($fillrcarr_q)) {
$thewoid = "$rs_result_frca->pcwo";
$woquantity = "$rs_result_frca->quantity";
$rcarray[] = $thewoid;
if(!array_key_exists($thewoid, $rcarray2)) {
$rcarray2[$thewoid] = 0;
}
$rcarray2[$thewoid] = $rcarray2[$thewoid] + $woquantity;

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
$workorderlist .= "<a href=\"../repair/index.php?pcwo=$thewoid\">#$thewoid $pcname</a><br>";
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
$countonwo = $countonwo + $rcarray2[$thewoid];


}
}
}


#############################

$thetotalitemswo = array();

if ($countonwo > 0) {
if(!isset($itemsonopenwo)) {
$itemsonopenwo = "<span class=\"linkbuttonsmall linkbuttongraylabel radiusall displayblock\">".pcrtlang("Items On Open Work Orders")."</span>";
}
$itemsonopenwo .= "$rs_storesname: <span class=\"colormered boldme floatright\">$countonwo</span><br>";
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
$countavail = "<span class=\"linkbuttonsmall linkbuttongraylabel radiusall displayblock\">".pcrtlang("Estimated Items Available")."</span>";
}
$countavail .= "<span classboldme>$rs_storesname:</span> <span class=\"colormegreen boldme floatright\">$tavail</span><br>";


}


echo "</td>";

if(isset($itemsonopen)) {
echo "<td style=\"vertical-align:top;\">";
echo "$itemsonopen";
echo "</td>";
}

unset($itemsonopen);

if(isset($itemsonopenwo)) {
echo "<td style=\"vertical-align:top;\">";
echo "$itemsonopenwo";
echo "</td>";
}

unset($itemsonopenwo);

if(isset($countavail)) {
echo "<td style=\"vertical-align:top;\">";
echo "$countavail";
echo "</td>";
}

unset($countavail);



echo "</tr></table>";

if(($invoicelist != "") || ($workorderlist != "")) {
echo "<div id=showme style=\"display:none;\"><table><tr><td style=\"vertical-align:top;\">".pcrtlang("Invoices")."<br><br>$invoicelist</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td style=\"vertical-align:top;\">".pcrtlang("Work Orders")."<br><br>$workorderlist</td></tr></table></div>";
echo "<a href=#showme rel=facebox class=\"linkbuttonsmall linkbuttongray radiusall\">".pcrtlang("Show Invoices and Work Orders with items")."</a>";
}

stop_box();

#####

echo "<br><span class=\"sizeme16 boldme\">".pcrtlang("Price").": </span><span class=\"sizeme16 boldme colormeblue\">$money".mf("$rs_stockprice")."</span>";


if (perm_check("6")) {

$rs_find_laststock = "SELECT inv_price FROM inventory WHERE stock_id = '$stockid' ORDER BY inv_date DESC LIMIT 1";
$rs_result_last = mysqli_query($rs_connect, $rs_find_laststock);

$numpi = mysqli_num_rows($rs_result_last);
if($numpi != 0 ) {
$rs_result_lastitem_q = mysqli_fetch_object($rs_result_last);
$rs_lastinvprice = pf("$rs_result_lastitem_q->inv_price");
} else {
$rs_lastinvprice = 0;
}


if($rs_lastinvprice != 0) {
if($rs_stockprice < ($rs_lastinvprice * 1.99)) {
$markup = round(($rs_stockprice / $rs_lastinvprice) - 1, 2) * 100;
$markup .= "&#37;";
} else {
$markup = round(($rs_stockprice / $rs_lastinvprice), 2);
$markup .= "X";
}


echo "<br>".pcrtlang("Current Markup").": <span class=colormeblue>$markup</span> <span class=\"sizemesmaller\">(".pcrtlang("based on most recent cost price").")</span>";
}
}



echo "<br><br>";
echo "<form action=cart.php?func=add_item method=post><input type=hidden name=stockid value=$rs_stockid>";
echo "<input type=number class=textbox style=\"width:50px;\" name=\"qty\" value=\"1\" min=\"1\" step=\"1\"> ";
echo "<input type=submit class=button value=\"".pcrtlang("Add Item to Cart")."\"></form>";

stop_blue_box();
                                                                                                               
}

echo "<br><br>";

if (perm_check("6")) {
start_box();
$rs_stocktitle2 = urlencode($rs_stocktitle);

if($rs_dis_cont == 0) {
echo "<a href=stock.php?func=restock_item&stockid=$rs_stockid&stocktitle=$rs_stocktitle2 $therel class=\"linkbuttonmedium linkbuttongray radiusleft\">
<img src=images/restock.png class=iconmedium> ".pcrtlang("Restock this item")."</a>";
if (perm_check("36")) {
echo "<a href=stock.php?func=discont2&stockid=$rs_stockid&stocktitle=$rs_stocktitle2 class=\"linkbuttonmedium linkbuttongray radius\">
<img src=images/restock.png class=iconmedium> ".pcrtlang("Discontinue this item")."</a>";
}
}
if($rs_dis_cont == 1) {
echo "<a href=stock.php?func=restock_item&stockid=$rs_stockid&stocktitle=$rs_stocktitle2 $therel class=\"linkbuttonmedium linkbuttongray radiusleft nopointerevents\" style=\"opacity:.5\">
<img src=images/restock.png class=iconmedium style=\"filter: grayscale(100%);\"> ".pcrtlang("Restock this item")."</a>";
if (perm_check("36")) {
echo "<a href=stock.php?func=undodis&stockid=$rs_stockid&stocktitle=$rs_stocktitle2 class=\"linkbuttonmedium linkbuttongray radius\">
<img src=images/restock.png class=iconmedium> ".pcrtlang("Un-Discontinue this item")."</a>";
}
}

if ($activestorecount > "1") {
echo "<a href=stock.php?func=transfer_stock&stockid=$rs_stockid&stocktitle=$rs_stocktitle2 $therel class=\"linkbuttonmedium linkbuttongray\"><img src=images/restock.png class=iconmedium> ".pcrtlang("Transfer Stock")."</a>";
}

$rs_stockprice_ue = urlencode($rs_stockprice);

$rs_stockupc_ue = urlencode($rs_stockupc);

echo "<a href=stock.php?func=edit_stock&stockid=$rs_stockid&stocktitle=$rs_stocktitle2 $therel class=\"linkbuttonmedium linkbuttongray\"> <img src=images/invedit.png class=iconmedium> ".pcrtlang("Edit this item")."</a>";

$rs_findpics = "SELECT * FROM photos WHERE stock_item = '$rs_stockid'";
$rs_findpics_result = mysqli_query($rs_connect, $rs_findpics);

$numpics = mysqli_num_rows($rs_findpics_result);

if ($numpics == 0) {
echo "<a href=stock.php?func=addphoto&stockid=$rs_stockid $therel class=\"linkbuttonmedium linkbuttongray radiusright\"><img src=images/camera.png class=iconmedium> ".pcrtlang("Add Picture")."</a>";
} else {
echo "<a href=stock.php?func=delphoto&stockid=$rs_stockid class=\"linkbuttonmedium linkbuttongray radiusright\"><img src=images/delphoto.png class=iconmedium> ".pcrtlang("Remove Picture")."</a>";
}





echo "<br><br><a href=printpricetag.php?price=$rs_stockprice_ue&stockid=$rs_stockid&itemupc=$rs_stockupc_ue&name=$rs_stocktitle2&dymojsapi=html class=\"linkbuttonsmall linkbuttongray radiusleft\"><img src=images/pricetag.png class=iconmedium> ".pcrtlang("Print Price Tag")."</a>";




$usertaxid = getusertaxid();
$salestaxrate = getsalestaxrate($usertaxid);
$itemtax = $rs_stockprice * $salestaxrate;
$totalprice = $rs_stockprice + $itemtax;
$totalprice_ue = urlencode("$totalprice");
$taxname = urlencode(gettaxname($usertaxid));

echo "<a href=printpricetag.php?withtaxname=$taxname&price=$totalprice_ue&stockid=$rs_stockid&itemupc=$rs_stockupc_ue&name=$rs_stocktitle2&dymojsapi=html class=\"linkbuttonsmall linkbuttongray\"><img src=images/pricetag.png class=iconmedium> ".pcrtlang("Print Price Tag w/Tax")."</a>";

echo "<a href=printpricecard.php?stockid=$rs_stockid&dymojsapi=html class=\"linkbuttonsmall linkbuttongray radiusright\"><img src=images/pricetag.png class=iconmedium> ".pcrtlang("Print Price Tent")."</a>";


stop_box();


echo "<br><br>";

if (perm_check("6")) {
start_blue_box(pcrtlang("Stock Levels"));

echo "<table class=standard>";
echo "<tr><th>".pcrtlang("Store")."</th><th>".pcrtlang("Current Qty")."</th><th style=\"padding-left:10px;padding-right:10px;text-align:right;\">".pcrtlang("Minimum Qty")."</th><th style=\"padding-left:10px;padding-right:10px;\">".pcrtlang("Maximum Qty")."</th><th>".pcrtlang("Reorder Qty")."</th>
<th>".pcrtlang("Maintain Stock?")."</th>
<th>".pcrtlang("Actions")."</th></tr>";

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

echo "<tr><td><form action=stock.php?func=savestocklevels&stockid=$rs_stockid method=post><input type=hidden name=storeid value=\"$rs_storeid\">$rs_storesname</td>
<td style=\"padding-left:10px;padding-right:10px;text-align:right;\">$stockqty</td>
<td style=\"padding-left:10px;padding-right:10px;text-align:right;\"><input type=number min=0 class=textbox name=minstock value=$minstock style=\"width:40px;\"></td>
<td style=\"padding-left:10px;padding-right:10px;text-align:right;\"><input type=number min=0 class=textbox name=maxstock value=$maxstock style=\"width:40px;\"></td>
<td style=\"padding-left:10px;padding-right:10px;text-align:right;\"><input type=number min=0 class=textbox name=reorderqty value=$reorderqty style=\"width:40px;\"></td>
<td style=\"padding-left:10px;padding-right:10px;text-align:center;\">";

if($maintainstock == 0) {
echo "<input type=checkbox name=maintainstock></td>";
} else {
echo "<input type=checkbox checked name=maintainstock></td>";
}


echo "<td><button class=button><i class=\"fa fa-chevron-left\"></i> ".pcrtlang("Save")."</button></form>";
if($reqcount == 1) {
echo "<button onClick=\"parent.location='stock.php?func=requestrecount&stockid=$rs_stockid&recount=0&storeid=$rs_storeid'\" class=button><i class=\"fa fa-ban fa-lg\"></i> ".pcrtlang("Cancel Recount Request")."</button>";
} else {
echo "<button onClick=\"parent.location='stock.php?func=requestrecount&stockid=$rs_stockid&recount=1&storeid=$rs_storeid'\" class=button><i class=\"fa fa-check-circle-o fa-lg\"></i> ".pcrtlang("Request Recount")."</button>";
}
echo "</td></tr>";


}

echo "</table>";
stop_box();
}



echo "<br><br>";

if (perm_check("6")) {
start_blue_box(pcrtlang("Stocking History"));

echo "<table style=\"padding-left:10px;padding-right:10px;\" class=standard>";
echo "<tr><th>".pcrtlang("Date")."</th><th>".pcrtlang("Quantity")."</th>";
echo "<th style=\"padding-left:10px;padding-right:10px;text-align:right;\">".pcrtlang("Unit Cost")."</th>";
echo "<th style=\"padding-left:10px;padding-right:10px;\">".pcrtlang("Store")."</th>";
echo "<th>".pcrtlang("Serials/Codes")."</th><th>".pcrtlang("Supplier")."</th>";
echo "<th>".pcrtlang("Supplier PN")."</td><th>".pcrtlang("Part URL")."</th>";
echo "<th>&nbsp;</th></tr>";
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
$ponumber = "$rs_result_stockhq->ponumber";

if("$itemserials" != "") { 
$serialsarray = preg_split('/\n|\r\n?/', $itemserials);
} else {
$serialsarray = array();
}

$storeinfoarray = getstoreinfo($invstoreid);

$invdate2 = pcrtdate("$pcrt_longdate", "$invdate");

$itemserials2 = urlencode($rs_result_stockhq->itemserial);

echo "<tr><td>$invdate2</td><td align=right>$invquantity</td>";
echo "<td style=\"padding-left:10px;padding-right:10px;text-align:right;\">$money".mf("$invprice")."</td>";
echo "<td style=\"padding-left:10px;padding-right:10px;\">$storeinfoarray[storesname]</td>";
echo "<td>";

foreach($serialsarray as $key => $serial) {
$serialue = urlencode("$serial");
echo "<span class=\"sizemesmaller\">$serial</span> <a href=\"printpricetag.php?price=".mf("$rs_stockprice")."&stockid=$rs_stockid&itemupc=$rs_stockupc_ue&name=$rs_stocktitle2&itemserial=$serialue&dymojsapi=html\" class=\"linkbuttontiny linkbuttongray radiusleft\"> <img src=images/pricetag.png style=\"width:15px;vertical-align:middle;margin-bottom: .25em;\"></a>";
echo "<a href=\"printpricetag.php?price=".mf("$totalprice")."&stockid=$rs_stockid&itemupc=$rs_stockupc_ue&name=$rs_stocktitle2&itemserial=$serialue&dymojsapi=html\" class=\"linkbuttontiny linkbuttongray radiusright\"> <img src=images/pricetag.png style=\"width:15px;vertical-align:middle;margin-bottom: .25em;\">".pcrtlang("w/tax")."</a><br>";
}

echo "</td>";

if($supplierid != 0) {
$rs_find_suppliers = "SELECT * FROM suppliers WHERE supplierid = $supplierid";
$rs_result_supp = mysqli_query($rs_connect, $rs_find_suppliers);
$rs_result_suppq = mysqli_fetch_object($rs_result_supp);
$suppliername2 = "$rs_result_suppq->suppliername";
} else {
$suppliername2 = "$suppliername";
}


if(perm_check("23") && ($supplierid != 0)) {
echo "<td><a href=\"suppliers.php?func=viewsupplier&supplierid=$supplierid\" class=\"linkbuttontiny linkbuttongray radiusall\">$suppliername2</a>";
} else {
echo "<td><span class=\"sizemesmaller\">$suppliername2</span>";
}

if($ponumber != "") {
echo "<br><span class=\"sizemesmaller\">$ponumber</span>";
}

echo "</td>";


echo "<td><span class=\"sizemesmaller\">$partnumber</span></td>";
echo "<td>";
if($parturl != "") {
$parturl2 = addhttp("$parturl");
echo "<a href=\"$parturl2\" target=\"_blank\" class=\"linkbuttontiny linkbuttongray radiusall\"><i class=\"fa fa-external-link fa-lg\"></i></a>";
}
echo "</td>";
$ponumber = urlencode("$ponumber");
echo "<td><a href=stock.php?func=editstockinv&invid=$inv_id&stockid=$rs_stockid&invstoreid=$invstoreid&invstockqty=$invquantity&ourprice=$invprice&itemserial=$itemserials2&ponumber=$ponumber $therel class=\"linkbuttontiny linkbuttongray radiusleft\">".pcrtlang("Edit")."</a><a href=stock.php?func=deletestockinv&invid=$inv_id&stockid=$rs_stockid&invstoreid=$invstoreid&invstockqty=$invquantity&delprice=$invprice onClick=\"return confirm('".pcrtlang("Are you sure you wish to permanently delete this inventory entry!!!?")."');\" class=\"linkbuttontiny linkbuttongray radiusright\">".pcrtlang("Delete")."</a></td>";


echo "</tr>";

}

echo "</table>";
stop_blue_box();
}




echo "<br><br>";

start_blue_box(pcrtlang("Recent Sales of this Item"));

echo "<table class=standard>";
echo "<tr><th>".pcrtlang("Date")."</th><th>".pcrtlang("Receipt No.")."</th><th>".pcrtlang("Customer ")."</th><th>".pcrtlang("Work Order")."</th><th>".pcrtlang("Invoice")."</th><th></th></tr>";
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


echo "<tr><td>$date_sold</td>
<td><a href=\"receipt.php?func=show_receipt&receipt=$receipt_id\" class=\"linkbuttontiny linkbuttongray radiusall\">$receipt_id</a></td>";
echo "<td>$customername $company</td><td>";

if($woid != 0) {
echo "<a href=\"../repair/index.php?pcwo=$woid\" class=\"linkbuttontiny linkbuttongray radiusall\">$woid</a>";
}

echo "</td><td>";

if($invoice_id != 0) {
echo "<a href=\"invoice.php?func=printinv&invoice_id=$invoice_id\" class=\"linkbuttontiny linkbuttongray radiusall\">$invoice_id</a>";
}

echo "</td><td>";


if($return_receipt != 0) {
echo "".pcrtlang("Returned on Receipt").": #<a href=\"receipt.php?func=show_receipt&receipt=$return_receipt\" class=\"linkbuttontiny linkbuttongray radiusall\">$return_receipt</a>";
}

echo "</td></tr>";



}
echo "</table>";
stop_blue_box();








}

require("footer.php");
                                                                                                                                               
}

function addphoto() {

$stockid = $_REQUEST['stockid'];

require("deps.php");

require_once("common.php");

perm_boot("6");

if($gomodal != "1") {
require("header.php");
} else {
require_once("validate.php");
}


if ($demo == "yes") {
die(pcrtlang("Sorry this feature is disabled in demo mode"));
}


$folderperms = substr(sprintf('%o', fileperms('../productphotos')), -3);

if (!is_writable("../productphotos")) {
echo "<span class=colormered>".pcrtlang("It appears your productphotos folder might not be writeable. You may not be able to upload stock pictures.")." $folderperms</span><br><br>";
}

if($gomodal != "1") {
start_blue_box(pcrtlang("Add Photo"));
} else {
echo "<h4>".pcrtlang("Add Photo")."</h4>";
}

                                                                                                                                              
echo "<form action=stock.php?func=addphoto2 method=post enctype=\"multipart/form-data\">";
echo "<table width=100%>";
echo "<tr><td>".pcrtlang("Picture to Upload").":</td><td><input type=file name=photo><input type=hidden name=stockid value=$stockid></td></tr>";
echo "<tr><td>&nbsp;</td><td><input type=submit class=button value=\"".pcrtlang("Upload Photo")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Uploading Photo")."...'; this.form.submit();\"></form></td></tr>";
echo "</table>";

if($gomodal != 1) {
stop_blue_box();
}

if($gomodal != 1) {
require_once("footer.php");
}


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


if($gomodal != "1") {
require("header.php");
} else {
require_once("validate.php");
}


perm_boot("6");

if($gomodal != "1") {
start_blue_box(pcrtlang("Edit Stock Item"));
} else {
echo "<h4>".pcrtlang("Edit Stock Item")."</h4>";
}
                                                                                                                                
                   




$rs_find_stockinfo = "SELECT * FROM stock WHERE stock_id = '$stockid'";
$rs_result_item = mysqli_query($rs_connect, $rs_find_stockinfo);
                                                                                                                                               
                                                                                                                                               
while($rs_result_item_q = mysqli_fetch_object($rs_result_item)) {
$rs_stocktitle = pf("$rs_result_item_q->stock_title");
$rs_stockdesc = "$rs_result_item_q->stock_desc";
$rs_stockpdesc = "$rs_result_item_q->stock_pdesc";
$rs_stock_price = "$rs_result_item_q->stock_price";
$rs_catin = "$rs_result_item_q->stock_cat";
$rs_upc = "$rs_result_item_q->stock_upc";
                                                                                                                            
echo "<form action=stock.php?func=edit_stock2 name=editstock method=post>";
echo "<table width=100%>";
echo "<tr><td>".pcrtlang("Name of Product").":</td><td><input size=35 type=text class=textbox name=productname value=\"$rs_stocktitle\"></td></tr>";
echo "<tr><td>".pcrtlang("Product UPC").":</td><td><input size=35 type=text class=textbox name=productupc value=\"$rs_upc\"></td></tr>";       
                                                                                                                                        
echo "<tr><td>".pcrtlang("Product Category").":</td><td><select name=category>";
                                                                                                       
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
echo "</select></td></tr>";

$rs_find_laststock = "SELECT inv_price FROM inventory WHERE stock_id = '$stockid' ORDER BY inv_date DESC LIMIT 1";
$rs_result_last = mysqli_query($rs_connect, $rs_find_laststock);
$rs_result_lastitem_q = mysqli_fetch_object($rs_result_last);
$rs_lastinvprice = pf("$rs_result_lastitem_q->inv_price");


echo "<tr><td>".pcrtlang("Product Description").":</td><td><textarea name=prod_desc cols=60 rows=10 class=textboxw>$rs_stockdesc</textarea></td></tr>";
echo "<tr><td>".pcrtlang("Printed Description").":</td><td><textarea name=prod_pdesc cols=60 rows=10 class=textboxw>$rs_stockpdesc</textarea></td></tr>";
echo "<tr><td>".pcrtlang("Selling Price").":</td><td>$money<input size=10 type=text class=textbox name=sellprice id=sellprice value=\"".mf("$rs_stock_price")."\">";

$usertaxid = getusertaxid();
$salestaxrateremain = (1 + getsalestaxrate($usertaxid));
if($salestaxrateremain != 1) {
echo "<button class=button type=button onclick='document.getElementById(\"sellprice\").value=(document.getElementById(\"sellprice\").value / $salestaxrateremain).toFixed(5);'>
<i class=\"fa fa-calculator\"></i> ".pcrtlang("Pre-tax")."</button>";
}


echo "<br>Current Price:<span class=colormeblue> ".mf("$rs_stock_price")."</span>";


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


echo "<br>".pcrtlang("Current Markup").": <span class=colormeblue>$markup</span> <span class=\"sizemesmaller\">(".pcrtlang("based on most recent cost price").")</span></td></tr>";



echo "<tr><td>".pcrtlang("Most Recent Cost Price").":</td><td>$money<input size=10 type=text readonly class=textboxnoborder name=ourprice value=\"".mf("$rs_lastinvprice")."\"></td></tr>";


         

echo "<tr><td>".pcrtlang("Change Markup").": </td><td>";

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

echo "</td></tr>";

                                                                                                                                      
echo "<tr><td>&nbsp;</td><td><input type=hidden value=$stockid name=stockid><input type=submit class=button value=\"".pcrtlang("Edit Item")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Saving")."...'; this.form.submit();\"></form></td></tr>";
echo "</table>";
}
                
if($gomodal != 1) {
stop_blue_box();
}

if($gomodal != 1) {
require_once("footer.php");
}   

                                                                                                                                            
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

if($gomodal != "1") {
require("header.php");
} else {
require_once("validate.php");
}


if($gomodal != "1") {
start_blue_box(pcrtlang("Restock Item")." #$stockid $stocktitle");
} else {
echo "<h4>".pcrtlang("Restock Item")." #$stockid $stocktitle</h4>";
}

if (array_key_exists('stockqty',$_REQUEST)) {
$stockqty = $_REQUEST['stockqty'];
} else {
$stockqty = "0";
}



echo "".pcrtlang("Enter Number of Items to add to stock").":<br>";
echo "<form action=stock.php?func=restock_item2 method=post>";
echo "<table>";
$rs_find_stores = "SELECT * FROM stores WHERE storeenabled = '1' ORDER BY storesname ASC";
$rs_result_stores = mysqli_query($rs_connect, $rs_find_stores);
while($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
$rs_storesname = "$rs_result_storeq->storesname";
$rs_storeid = "$rs_result_storeq->storeid";

if ($defaultuserstore == $rs_storeid) {
echo "<tr><td align=right>$rs_storesname:</td><td><table><tr><td><input type=text class=textbox size=3 name=store$rs_storeid value=$stockqty>";
} else {
echo "<tr><td align=right>$rs_storesname:</td><td><table><tr><td><input type=text class=textbox size=3 name=store$rs_storeid value=0>";
}

echo "</td><td>&nbsp;</td><td>";
echo "<span class=\"sizemesmaller italme\">".pcrtlang("serials/codes").":</span></td><td><textarea name=storeserial$rs_storeid rows=2 cols=40 class=textbox></textarea></td></tr></table></td></tr>";

}
echo "</table>";

echo "<table><tr><td>".pcrtlang("Unit Cost").":</td><td>$money<input type=text class=textbox name=ourcost></td></tr>";
echo "<tr><td colspan=2><span class=\"sizemesmaller italme\">".pcrtlang("Supplier info below pre-filled from most recent previous stock entry...")."</span></td></tr>";


$rs_find_laststock = "SELECT * FROM inventory WHERE stock_id = '$stockid' ORDER BY inv_date DESC LIMIT 1";
$rs_result_last = mysqli_query($rs_connect, $rs_find_laststock);
$rs_result_lastitem_q = mysqli_fetch_object($rs_result_last);
$supplieridindb = "$rs_result_lastitem_q->supplierid";
$suppliernameindb = "$rs_result_lastitem_q->suppliername";
$parturlindb = "$rs_result_lastitem_q->parturl";
$partnumberindb = "$rs_result_lastitem_q->partnumber";


echo "<tr><td>".pcrtlang("Pick Supplier").":</td><td><select name=supplierid>";

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
echo "</select></td></tr>";

echo "<tr><td>".pcrtlang("Supplier Name")."</td><td><input size=35 type=text class=textbox name=suppliername value=\"$suppliernameindb\"></td></tr>";
echo "<tr><td>".pcrtlang("Supplier Part No.")."</td><td><input size=35 type=text class=textbox name=partnumber value=\"$partnumberindb\"></td></tr>";
echo "<tr><td>".pcrtlang("Part URL")."</td><td><input size=35 type=text class=textbox name=parturl value=\"$parturlindb\"></td></tr>";
echo "<tr><td>".pcrtlang("PO Number")."</td><td><input size=35 type=text class=textbox name=ponumber></td></tr>";

echo "</table>";


echo "<input type=hidden name=stockid value=$stockid>";
echo "<br><input type=submit class=ibutton value=\"".pcrtlang("Add to stock")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Adding to Stock")."...'; this.form.submit();\"></form>";

if($gomodal != 1) {
stop_blue_box();
}

if($gomodal != 1) {
require_once("footer.php");
}

                                                                                                                                               
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
$ponumber = pv($_REQUEST['ponumber']);


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
$rs_insert_inv = "INSERT INTO inventory (stock_id,inv_price,inv_quantity,inv_date,storeid,itemserial,supplierid,suppliername,parturl,partnumber,ponumber) VALUES  ('$stockid','$ourprice','$thecount','$currentdatetime','$rs_storeid','$theserials','$supplierid','$suppliername','$parturl','$partnumber','$ponumber')";
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
$rs_show_stockold = "SELECT DISTINCT stock.stock_id, stock.stock_title, stock.stock_desc, stock.stock_price FROM stock,inventory WHERE 
((stock.stock_title LIKE '%$thesearch%' OR stock.stock_upc LIKE '%$thesearch%' OR stock.stock_desc LIKE '%$thesearch%') OR 
(inventory.partnumber LIKE '%$thesearch%' AND stock.stock_id = inventory.stock_id)) AND stock.dis_cont = 0";

$rs_show_stock = "(SELECT stock.stock_id, stock.stock_title, stock.stock_desc, stock.stock_price FROM stock,inventory 
WHERE stock.dis_cont = 0 AND (stock.stock_title LIKE '%$thesearch%' OR stock.stock_upc LIKE '%$thesearch%' OR stock.stock_desc LIKE '%$thesearch%'))
UNION
(SELECT stock.stock_id, stock.stock_title, stock.stock_desc, stock.stock_price FROM stock,inventory WHERE stock.dis_cont = 0 AND
(inventory.partnumber LIKE '%$thesearch%' AND stock.stock_id = inventory.stock_id))";

} else {
$rs_show_stockold = "SELECT DISTINCT stock.stock_id, stock.stock_title, stock.stock_desc, stock.stock_price FROM stock,inventory WHERE 
((stock.stock_title LIKE '%$thesearch%' OR stock.stock_upc LIKE '%$thesearch%' OR stock.stock_desc LIKE '%$thesearch%') OR
(inventory.partnumber LIKE '%$thesearch%' AND stock.stock_id = inventory.stock_id))  AND stock_cat = '$searchcat' AND stock.dis_cont = 0";

$rs_show_stock = "(SELECT stock.stock_id, stock.stock_title, stock.stock_desc, stock.stock_price FROM stock,inventory
WHERE stock.dis_cont = 0  AND stock_cat = '$searchcat' AND (stock.stock_title LIKE '%$thesearch%' OR stock.stock_upc LIKE '%$thesearch%' OR stock.stock_desc LIKE '%$thesearch%'))
UNION
(SELECT stock.stock_id, stock.stock_title, stock.stock_desc, stock.stock_price FROM stock,inventory WHERE stock.dis_cont = 0  AND stock_cat = '$searchcat' AND
(inventory.partnumber LIKE '%$thesearch%' AND stock.stock_id = inventory.stock_id))";


}
$rs_stock_result = mysqli_query($rs_connect, $rs_show_stock);


$rs_show_stockcold = "SELECT DISTINCT stock.stock_cat, stock.stock_title, COUNT(stock.stock_cat) AS stockitems FROM stock,inventory WHERE
((stock.stock_title LIKE '%$thesearch%' OR stock.stock_upc LIKE '%$thesearch%' OR stock.stock_desc LIKE '%$thesearch%') OR
(inventory.partnumber LIKE '%$thesearch%' AND inventory.stock_id = stock.stock_id)) AND stock.dis_cont = 0 GROUP BY stock.stock_cat";


$rs_show_stockc = "
(
SELECT DISTINCT stock.stock_cat, stock.stock_title FROM stock,inventory WHERE
(stock.stock_title LIKE '%$thesearch%' OR stock.stock_upc LIKE '%$thesearch%' OR stock.stock_desc LIKE '%$thesearch%') AND stock.dis_cont = 0
) UNION (
SELECT DISTINCT stock.stock_cat, stock.stock_title FROM stock,inventory WHERE
(inventory.partnumber LIKE '%$thesearch%' AND inventory.stock_id = stock.stock_id) AND stock.dis_cont = 0
)
";


$rs_stock_resultc = mysqli_query($rs_connect, $rs_show_stockc);


start_box();
echo "".pcrtlang("Searched for").": <span class=colormered>$thesearch2</span> ";

if($searchcat != 0) {
$rs_find_sub_cat = "SELECT * FROM sub_cats WHERE sub_cat_id = '$searchcat'";
$rs_find_result = mysqli_query($rs_connect, $rs_find_sub_cat);
$rs_find_result_q = mysqli_fetch_object($rs_find_result);
$rs_subcatname = "$rs_find_result_q->sub_cat_name";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".pcrtlang("In Category").": <span class=colormered>$rs_subcatname</span> ";
}

echo "<br>";

if($searchcat == 0) {
echo "".pcrtlang("Narrow Search").": "; 

$usedcats = array();

while($rs_stock_result_qc = mysqli_fetch_object($rs_stock_resultc)) {
$rs_stockcat = "$rs_stock_result_qc->stock_cat";

if(!in_array($rs_stockcat, $usedcats)) {
$usedcats[] = "$rs_stockcat";

$rs_find_sub_cat = "SELECT * FROM sub_cats WHERE sub_cat_id = '$rs_stockcat'";
$rs_find_result = mysqli_query($rs_connect, $rs_find_sub_cat);
$rs_find_result_q = mysqli_fetch_object($rs_find_result);
$rs_subcatname = "$rs_find_result_q->sub_cat_name";


echo " <a href=stock.php?func=search_stock&thesearch=$thesearchue&searchcat=$rs_stockcat class=\"linkbuttonsmall linkbuttongray radiusall\">$rs_subcatname</a> ";
}
}
}
stop_box();

echo "<br><table width=100% cellspacing=0 cellpadding=3 border=0>";

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

echo "<tr><td bgcolor=#e5e5e5><b><a href=stock.php?func=show_stock_detail&stockid=$rs_stockid class=\"linkbuttonmedium linkbuttongray radiusall\">$rs_stocktitle - $rs_stockid</a>";
echo "</td><td width=25% rowspan=2 bgcolor=#e5e5e5>";

$rs_show_photo = "SELECT * FROM photos WHERE stock_item = '$rs_stockid'";
$rs_photo_result = mysqli_query($rs_connect, $rs_show_photo);
while($rs_photo_result_q = mysqli_fetch_object($rs_photo_result)) {
$rs_filename = "$rs_photo_result_q->photo_filename";
echo "<img src=stock.php?func=getinvimage&photo_name=ths_$rs_filename align=right hspace=3 vspace=3><br><br>";
}


echo "</td></tr>";
echo "<tr><td width=75% bgcolor=#ffffff>$rs_stockdesc2<br><br>".pcrtlang("Items in Stock").": <br>";

$rs_find_stores = "SELECT * FROM stores WHERE storeenabled = '1' ORDER BY storesname ASC";
$rs_result_stores = mysqli_query($rs_connect, $rs_find_stores);
while($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
$rs_storesname = "$rs_result_storeq->storesname";
$rs_storeid = "$rs_result_storeq->storeid";

$rs_find_stock = "SELECT * FROM stockcounts WHERE storeid = '$rs_storeid' AND stockid = '$rs_stockid'";
$rs_result_stock = mysqli_query($rs_connect, $rs_find_stock);
$rs_result_stockq = mysqli_fetch_object($rs_result_stock);
$stockqty = "$rs_result_stockq->quantity";

echo "$rs_storesname: <span class=colormered>$stockqty</span><br>";

}


echo "<br>".pcrtlang("Price").": <span class=colormeblue>$money".mf("$rs_stockprice")."</span><br><br>";
echo "<form action=cart.php?func=add_item method=post><input type=hidden name=stockid value=$rs_stockid>";
echo "<input type=submit class=button value=\"".pcrtlang("Add Item to Cart")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Adding to Cart")."...'; this.form.submit();\"></form></td></tr>";
echo "<tr><td colspan=2>&nbsp;</td></tr>";

}
echo "</table>";
require("footer.php");
}



function discont() {

$stock_id = $_REQUEST['stock_id'];
$pageNumber = $_REQUEST['pageNumber'];

include("deps.php");

require_once("common.php");
perm_boot("36");

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

if($gomodal != "1") {
require("header.php");
} else {
require_once("validate.php");
}


if($gomodal != "1") {
start_blue_box(pcrtlang("Transfer Stock Item")." #$stockid $stocktitle");
} else {
echo "<h4>".pcrtlang("Transfer Stock Item")." #$stockid $stocktitle</h4>";
}

echo "<form action=stock.php?func=transfer_stock2 method=post>";
echo "<table>";
$storeoptions = "";
echo "<tr><td>".pcrtlang("Current Stock Quantities")."</td><td></td></tr>";
$rs_find_stores = "SELECT * FROM stores WHERE storeenabled = '1' ORDER BY storesname ASC";
$rs_result_stores = mysqli_query($rs_connect, $rs_find_stores);
while($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
$rs_storesname = "$rs_result_storeq->storesname";
$rs_storeid = "$rs_result_storeq->storeid";

$rs_find_stock = "SELECT * FROM stockcounts WHERE storeid = '$rs_storeid' AND stockid = '$stockid'";
$rs_result_stock = mysqli_query($rs_connect, $rs_find_stock);
$rs_result_stockq = mysqli_fetch_object($rs_result_stock);
$stockqty = "$rs_result_stockq->quantity";

echo "<tr><td>$rs_storesname</td><td><span class=colormegreen>$stockqty</span></td></tr>";

$storeoptions .= "<option value=$rs_storeid>$rs_storesname</option>";

}
echo "<tr><td>&nbsp;</td><td></td></tr>";
echo "<tr><td>".pcrtlang("Number of Items to Transfer").":</td><td><input type=text class=textbox name=\"stockqty\" value=\"0\" size=4></td></tr>";
echo "<tr><td>".pcrtlang("Transfer From").":</td><td><select name=storefrom>$storeoptions</select></td></tr>";
echo "<tr><td>".pcrtlang("Transfer To").":</td><td><select name=storeto>$storeoptions</select></td></tr>";


echo "</table>";
echo "<br><br>";
echo "<input type=hidden name=stockid value=$stockid>";
echo "<br><input type=submit class=ibutton value=\"".pcrtlang("Transfer Stock")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Transferring")."...'; this.form.submit();\"></form>";

if($gomodal != 1) {
stop_blue_box();
}

if($gomodal != 1) {
require_once("footer.php");
}


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
$ponumber = $_REQUEST['ponumber'];

require("deps.php");

require_once("common.php");

perm_boot("6");

checkstorecount($stockid);

if($gomodal != "1") {
require("header.php");
} else {
require_once("validate.php");
}


if($gomodal != "1") {
start_blue_box(pcrtlang("Edit Previous Inventory Restock Entry"));
} else {
echo "<h4>".pcrtlang("Edit Previous Inventory Restock Entry")."</h4>";
}

echo "<form action=stock.php?func=editstockinv2 method=post>";
echo "<input type=hidden name=\"oldinvstockqty\" value=\"$invstockqty\">";
echo "<input type=hidden name=\"oldourprice\" value=\"$ourprice\">";

echo "<table>";

echo "<tr><td>".pcrtlang("New Quantity").":</td><td><input type=text class=textbox name=\"newstockqty\" value=\"$invstockqty\" size=4></td></tr>";
echo "<tr><td>".pcrtlang("Unit Cost").":</td><td>$money<input type=text class=textbox name=\"ourprice\" value=\"".mf("$ourprice")."\" size=6></td></tr>";
echo "<tr><td>".pcrtlang("PO Number").":</td><td><input type=text class=textbox name=\"ponumber\" value=\"$ponumber\" size=6></td></tr>";
echo "<tr><td>".pcrtlang("Serials/Codes").":<br><span class=\"sizemesmaller italme\">(".pcrtlang("One per line").")</span></td><td><textarea class=textbox name=\"itemserial\" rows=4 cols=40>$itemserial</textarea></td></tr>";


echo "</table>";
echo "<br><br>";
echo "<input type=hidden name=invstoreid value=$invstoreid>";
echo "<input type=hidden name=stockid value=$stockid>";
echo "<input type=hidden name=oldstockqty value=$invstockqty>";
echo "<input type=hidden name=invid value=$invid>";
echo "<br><input type=submit class=ibutton value=\"".pcrtlang("Save")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Saving")."...'; this.form.submit();\"></form>";

if($gomodal != 1) {
stop_blue_box();
}

if($gomodal != 1) {
require_once("footer.php");
}


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
$ponumber = $_REQUEST['ponumber'];

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

$rs_adj_inv = "UPDATE inventory SET inv_quantity = '$newstockqty', inv_price = '$ourprice', itemserial = '$itemserial', ponumber = '$ponumber' WHERE inv_id = '$invid'";
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

echo "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../repair/style.css\">";
echo "<script src=\"../repair/jq/jquery.js\" type=\"text/javascript\"></script>";

echo "<script>\n";
echo "<!--\n";
echo "function sf(){document.f.stockid.focus();}\n";
echo "// -->\n";
echo "</script>\n";

echo "</head><body onLoad=sf() style=\"background:#00ff00\"><br><br>";

start_box();

$storeinfoarray = getstoreinfo($defaultuserstore);


echo "<center><h4>".pcrtlang("Store").": $storeinfoarray[storesname]</h4>";

echo "<h4>".pcrtlang("Scan Price Tag")."</h4>";

echo "<form action=stock.php?func=fixinv2 name=f method=post>";

echo "<input type=text class=textbox name=\"stockid\" size=30 placeholder=\"".pcrtlang("Enter/Scan Stock ID or UPC")."\">";

echo "<br><br>";
echo "<br><input type=submit class=\"linkbuttonlarge linkbuttongreen radiusall\" value=\"".pcrtlang("Scan.... Next")."-&gt;\" onclick=\"this.disabled=true;this.value='".pcrtlang("Wait")."...'; this.form.submit();\"></form></center>";
stop_box();

echo "<center><br>&nbsp;&nbsp;<span style=\"font-size:80px;color:#ffffff\">$storeinfoarray[storesname]</span></center>";

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

echo "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">";

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../repair/style.css\">";
echo "<script src=\"../repair/jq/jquery.js\" type=\"text/javascript\"></script>";

echo "<script>\n";
echo "<!--\n";
echo "function sf(){document.f.stockcount.focus();}\n";
echo "// -->\n";
echo "</script>\n";

echo "</head><body onLoad=sf() style=\"background:#ff0000\"><br><br>";
start_box();

echo "<center>";

$rs_show_stock = "SELECT stock_title FROM stock WHERE stock_id = '$stockid'";
$rs_stock_result = mysqli_query($rs_connect, $rs_show_stock);
$rs_stock_result_q = mysqli_fetch_object($rs_stock_result);
$rs_stocktitle = "$rs_stock_result_q->stock_title";


$storeinfoarray = getstoreinfo($defaultuserstore);


echo "<h4>".pcrtlang("Store").": $storeinfoarray[storesname]</h4>";

echo "<h4>".pcrtlang("Enter Stock Quantity")." <br> #$stockid $rs_stocktitle</h4>";

echo "<form action=stock.php?func=fixinv3 name=f method=post>";
echo "<table>";

echo "<tr><td><span class=\"boldme\">".pcrtlang("Current Quantity").":</span></td><td style=\"text-align:right;\"><span class=\"colormeblue boldme\" style=\"text-align:right;\">$stockqty</span></td></tr>";
echo "<tr><td><span class=\"boldme\">".pcrtlang("Stock Count").":</span></td><td><input type=text class=textbox name=\"stockcount\" value=\"$stockqty\" size=10></td></tr>";




echo "</table>";
echo "<br><br>";
echo "<br><input type=hidden name=stockid value=$stockid>";

if (array_key_exists('thedate',$_REQUEST)) {
$thedate = $_REQUEST['thedate'];
echo "<input type=hidden name=thedate value=\"$thedate\">";
}

echo "<input type=submit  class=\"linkbuttonlarge linkbuttonred radiusall\"  value=\"".pcrtlang("Count.... Save")."&raquo;\" onclick=\"this.disabled=true;this.value='".pcrtlang("Wait")."...'; this.form.submit();\"></form>";
echo "</center>";
stop_box();

echo "<center><br>&nbsp;&nbsp;<span style=\"font-size:80px;color:#ffffff\">$storeinfoarray[storesname]</span></center>";

$availser = available_serials($stockid);
if(count($availser) > 0) {
echo "<center><span class=\"colormewhite boldme\">".pcrtlang("Available Serials").":<br></span>";
foreach($availser as $key => $val) {
echo "<span class=colormewhite>$val</span><br>";
}
echo "</center>";
}


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


echo "</head><body><br><br>";

echo "<h4>".pcrtlang("Items that show positive stock counts that have not had inventory counts verified since")." $thedate</h4>";

echo "<table>";

echo "<tr><td>".pcrtlang("Stock ID")."</td><td>".pcrtlang("Stock Title")."</td><td></td></tr>";
$rs_find_stock = "SELECT * FROM stockcounts WHERE storeid = '$defaultuserstore' AND quantity > 0 AND lastcounted < '$thedate 00:00:00' ORDER BY stockid ASC";
$rs_result_stock = mysqli_query($rs_connect, $rs_find_stock);
while($rs_result_stockq = mysqli_fetch_object($rs_result_stock)) {
$rs_stockid = "$rs_result_stockq->stockid";
$rs_quantity = "$rs_result_stockq->quantity";

$rs_show_stock = "SELECT stock_title FROM stock WHERE stock_id = '$rs_stockid'";
$rs_stock_result = mysqli_query($rs_connect, $rs_show_stock);
$rs_stock_result_q = mysqli_fetch_object($rs_stock_result);
$rs_stocktitle = "$rs_stock_result_q->stock_title";

echo "<tr><td>$rs_stockid</td><td>$rs_stocktitle</td><td>$rs_quantity</td><td><a href=stock.php?func=fixinv2&stockid=$rs_stockid&thedate=$thedate>".pcrtlang("Fix Quantity")."</a></td></tr>";
}



echo "</table>";
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


echo "<script type=\"text/javascript\">document.title = \"".pcrtlang("Special Orders")."\";</script>";


$rs_find_so = "SELECT * FROM specialorders WHERE spoopenclosed = '0' AND spostoreid = '$defaultuserstore' ORDER BY spodate DESC";
$rs_result_so = mysqli_query($rs_connect, $rs_find_so);

start_blue_box(pcrtlang("Special Order Parts"));

echo "<a href=\"stock.php?func=addspo\" class=\"linkbuttonmedium linkbuttongray radiusleft\"><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Add Special Order Item")."</a>";
echo "<a href=\"stock.php?func=specialordersall\" class=\"linkbuttonmedium linkbuttongray radiusright\"><i class=\"fa fa-chevron-right fa-lg\"></i> ".pcrtlang("Show All Special Orders")."</a><br><br>";



if(mysqli_num_rows($rs_result_so) > 0) {


echo "<table style=\"padding-left:10px;padding-right:10px;\" class=standard>";
echo "<tr><th>".pcrtlang("Part Name")."</th><th>".pcrtlang("Qty")."/".pcrtlang("Price")."</th>";
echo "<th style=\"padding-left:10px;padding-right:10px;text-align:right;\">".pcrtlang("Supplier")."</th>";
echo "<th style=\"padding-left:10px;padding-right:10px;\">".pcrtlang("Supplier PN")."</th>";
echo "<th>".pcrtlang("Url")."</th><th>".pcrtlang("Tracking No.")."</th>";
echo "<th>".pcrtlang("Date")."</td><th>".pcrtlang("Status")."</th>";
echo "<th>".pcrtlang("Work Order")."</td>";
echo "<th>&nbsp;</th></tr>";

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
$spopartname = pf("$rs_result_item_q->spopartname");
$spoprice = "$rs_result_item_q->spoprice";
$spocost = "$rs_result_item_q->spocost";
$spowoid = "$rs_result_item_q->spowoid";
$sposupplierid = pf("$rs_result_item_q->sposupplierid");
$sposuppliername = pf("$rs_result_item_q->sposuppliername");
$spopartnumber = pf("$rs_result_item_q->spopartnumber");
$spoparturl = pf("$rs_result_item_q->spoparturl");
$spotracking = pf("$rs_result_item_q->spotracking");
$spostatus = "$rs_result_item_q->spostatus";
$spodate2 = "$rs_result_item_q->spodate";
$sponotes = pf("$rs_result_item_q->sponotes");
$unit_price = "$rs_result_item_q->unit_price";
$quantity = "$rs_result_item_q->quantity";


$spodate = pcrtdate("$pcrt_shortdate", "$spodate2");

echo "<tr><td>$spopartname</td><td align=right>".qf("$quantity")."<br>$money".mf("$unit_price")."<br>$money".mf("$spoprice")."</td>";

if($sposupplierid != 0) {
$rs_find_suppliers = "SELECT * FROM suppliers WHERE supplierid = '$sposupplierid'";
$rs_result_supp = mysqli_query($rs_connect, $rs_find_suppliers);
$rs_result_suppq = mysqli_fetch_object($rs_result_supp);
$suppliername2 = "$rs_result_suppq->suppliername";
} else {
$suppliername2 = "$sposuppliername";
}


if(perm_check("23") && ($sposupplierid != 0)) {
echo "<td><a href=\"suppliers.php?func=viewsupplier&supplierid=$sposupplierid\" class=\"linkbuttonsmall linkbuttongray radiusall\">$suppliername2</a></td>";
} else {
echo "<td>$suppliername2</td>";
}

echo "<td><span class=\"sizemesmaller\">$spopartnumber</span></td>";
echo "<td>";
if($spoparturl != "") {
$parturl2 = addhttp("$spoparturl");
echo "<a href=\"$parturl2\" target=\"_blank\" class=\"linkbuttonsmall linkbuttongray radiusall\"><i class=\"fa fa-external-link fa-lg\"></i></a>";
}
echo "</td>";

echo "<td>";
if($spotracking != "") {
echo "<a href=\"http://google.com/#q=".pf("$spotracking")."\" target=\"_blank\" class=\"linkbuttonsmall linkbuttongray radiusall\">$spotracking</a>";
}
echo "</td>";

echo "<td><span class=\"sizemesmaller\">$spodate</span></td>";

echo "<td><span class=\"sizemesmaller boldme\">$statii[$spostatus]</span><br><span class=\"sizemesmaller\">$sponotes</span></td>";

echo "<td>";

if($spowoid != 0) {
echo "<a href=\"../repair/index.php?pcwo=$spowoid\" class=\"linkbuttonsmall linkbuttongray radiusall\">#$spowoid</a>";
}

echo "</td>";

echo "<td>";
echo "<a href=\"stock.php?func=deletespo&spoid=$spoid\" style=\"white-space: nowrap\" onClick=\"return confirm('".pcrtlang("Are you sure you wish to permanently delete this special order!!!?")."');\" class=\"linkbuttontiny linkbuttongray radiusleft\"><i class=\"fa fa-trash-o fa-lg\"></i> ".pcrtlang("delete")."</a>";
echo "<a href=\"stock.php?func=editspo&spoid=$spoid\" style=\"white-space: nowrap\" class=\"linkbuttontiny linkbuttongray radiusright\"><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("edit")."</a><br>";
echo "<a href=\"stock.php?func=spoopenclose&spoid=$spoid&openclose=1\" style=\"white-space: nowrap\" class=\"linkbuttontiny linkbuttongray radiusall\"><i class=\"fa fa-sign-out fa-lg\"></i> ".pcrtlang("close")."</a>";
echo "<a href=\"cart.php?func=spoaddcart&spoid=$spoid\" style=\"white-space: nowrap\" class=\"linkbuttontiny linkbuttongray radiusright\"><i class=\"fa fa-shopping-cart fa-lg\"></i> ".pcrtlang("add to cart")."</a>";

echo "</td>";

echo "</tr>";

}
echo "</table>";

}

stop_box();

require("footer.php");
}




function addspo() {
require("deps.php");
require_once("common.php");

require("header.php");

start_blue_box(pcrtlang("Add Special Order Part"));

echo "<form action=stock.php?func=addspo2 method=post name=newinv>";
echo "<table width=100%>";
echo "<tr><td>".pcrtlang("Name of Part/Item").":</td><td><input size=35 type=text class=textbox name=spopartname></td></tr>";

echo "<tr><td>".pcrtlang("Optional Printed Description").":</td><td><textarea cols=60 class=textbox name=spoprintdesc></textarea></td></tr>";

?>

<script>
function markup() {
var marknum = Math.ceil((document.newinv.spocost.value - 0) * (document.newinv.chooser.value - 0)) - document.newinv.cents.value;
document.newinv.spoprice.value = marknum.toFixed(2);
}
</script>

<?php
echo "<tr><td>".pcrtlang("Selling Price").":</td><td>$money<input size=10 type=text class=textbox name=spoprice></td></tr>";
echo "<tr><td>".pcrtlang("Unit Cost").":</td><td>$money<input size=10 type=text class=textbox name=spocost></td></tr>";
echo "<tr><td>".pcrtlang("Quantity").":</td><td><input size=5 type=number class=textbox name=spoquantity min=1 step=1></td></tr>";

echo "<tr><td>".pcrtlang("Markup").": </td><td>";
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


echo "</td></tr>";

echo "<tr><td>".pcrtlang("Pick Supplier").":</td><td><select name=sposupplierid>";

echo "<option value=0>".pcrtlang("Manually Entered Supplier")."</option>";
$rs_find_suppliers = "SELECT * FROM suppliers ORDER BY suppliername ASC";
$rs_result_supp = mysqli_query($rs_connect, $rs_find_suppliers);

while($rs_result_suppq = mysqli_fetch_object($rs_result_supp)) {
$suppliername = "$rs_result_suppq->suppliername";
$supplierid = "$rs_result_suppq->supplierid";

echo "<option value=$supplierid>$suppliername</option>";

}
echo "</select><input type=hidden name=spowoid value=\"$woid\"></td></tr>";

echo "<tr><td>".pcrtlang("Supplier Name")."</td><td><input size=35 type=text class=textbox name=sposuppliername></td></tr>";
echo "<tr><td>".pcrtlang("Supplier Part No.")."</td><td><input size=35 type=text class=textbox name=spopartnumber></td></tr>";
echo "<tr><td>".pcrtlang("Part URL")."</td><td><input size=35 type=text class=textbox name=spoparturl></td></tr>";
echo "<tr><td>".pcrtlang("Shipping Tracking Number")."</td><td><input size=35 type=text class=textbox name=spotracking></td></tr>";
echo "<tr><td>".pcrtlang("Notes")."</td><td><input size=35 type=text class=textbox name=sponotes></td></tr>";

echo "<tr><td>".pcrtlang("Status").":</td><td><select name=spostatus>";
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
echo "</select></td></tr>";
echo "<tr><td>&nbsp;</td><td><input type=submit value=\"".pcrtlang("Save")."\" class=button></td></tr>";

echo "</table>";


stop_blue_box();
require_once("footer.php");
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
$spoquantity = $_REQUEST['spoquantity'];

$spoprice = $spounitprice * $spoquantity;
$spocost = $spocost * $spoquantity;



userlog(36,'','','');

$rs_insert_so = "INSERT INTO specialorders (spopartname,spoprice,spocost,sposupplierid,sposuppliername,spopartnumber,spoparturl,spotracking,spostatus,spodate,spostoreid,sponotes,quantity,unit_price,printdesc) VALUES ('$spopartname','$spoprice','$spocost','$sposupplierid','$sposuppliername','$spopartnumber','$spoparturl','$spotracking','$spostatus','$currentdatetime','$defaultuserstore','$sponotes','$spoquantity','$spounitprice','$spoprintdesc')";
@mysqli_query($rs_connect, $rs_insert_so);
header("Location: stock.php?func=specialorders");

}


function editspo() {
require("deps.php");
require_once("common.php");

require("header.php");

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

start_blue_box(pcrtlang("Edit Special Order Part"));
echo "<form action=stock.php?func=editspo2 method=post name=newinv>";
echo "<table width=100%>";
echo "<tr><td>".pcrtlang("Name of Part/Item").":</td><td><input size=35 type=text class=textbox name=spopartname value=\"$spopartname\"></td></tr>";

echo "<tr><td>".pcrtlang("Optional Printed Description").":</td><td><textarea cols=60 class=textbox name=spoprintdesc>$spoprintdesc</textarea></td></tr>";

?>

<script>
function markup() {
var marknum = Math.ceil((document.newinv.spocost.value - 0) * (document.newinv.chooser.value - 0)) - document.newinv.cents.value;
document.newinv.spoprice.value = marknum.toFixed(2);
}
</script>

<?php
echo "<tr><td>".pcrtlang("Quantity").":</td><td><input size=10 type=number class=textbox name=spoquantity min=1 step=1 value=\"".qf("$spoquantity")."\"></td></tr>";
echo "<tr><td>".pcrtlang("Selling Price").":</td><td>$money<input size=10 type=text class=textbox name=spoprice value=\"".mf("$spounit_price")."\"></td></tr>";
echo "<tr><td>".pcrtlang("Unit Cost").":</td><td>$money<input size=10 type=text class=textbox name=spocost value=\"$spocost\"></td></tr>";

echo "<tr><td>".pcrtlang("Markup").": </td><td>";
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


echo "</td></tr>";

echo "<tr><td>".pcrtlang("Pick Supplier").":</td><td><select name=sposupplierid value=\"$sposupplierid\">";

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
echo "</select><input type=hidden name=spoid value=\"$spoid\"></td></tr>";
echo "<tr><td>".pcrtlang("Supplier Name")."</td><td><input size=35 type=text class=textbox name=sposuppliername value=\"$sposuppliername\"></td></tr>";
echo "<tr><td>".pcrtlang("Supplier Part No.")."</td><td><input size=35 type=text class=textbox name=spopartnumber value=\"$spopartnumber\"></td></tr>";
echo "<tr><td>".pcrtlang("Part URL")."</td><td><input size=35 type=text class=textbox name=spoparturl value=\"$spoparturl\"></td></tr>";
echo "<tr><td>".pcrtlang("Shipping Tracking Number")."</td><td><input size=35 type=text class=textbox name=spotracking value=\"$spotracking\"></td></tr>";
echo "<tr><td>".pcrtlang("Notes")."</td><td><input size=35 type=text class=textbox name=sponotes value=\"$sponotes\"></td></tr>";

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

echo "<tr><td>".pcrtlang("Status").":</td><td><select name=spostatus value=\"$spostatus\">";

foreach($statii as $key => $val) {
if($key == $spostatus) {
echo "<option selected value=\"$key\">$val</option>";
} else {
echo "<option value=\"$key\">$val</option>";
}

}

echo "</select></td></tr>";
echo "<tr><td>&nbsp;</td><td><input type=submit value=\"".pcrtlang("Save")."\" class=button onclick=\"this.disabled=true;this.value='".pcrtlang("Saving")."...'; this.form.submit();\"></td></tr>";

echo "</table>";

stop_blue_box();
require_once("footer.php");


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
$spopartnumber = pv($_REQUEST['spopartnumber']);
$spoparturl = pv($_REQUEST['spoparturl']);
$spotracking = pv($_REQUEST['spotracking']);
$spostatus = $_REQUEST['spostatus'];
$sponotes = pv($_REQUEST['sponotes']);
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


start_blue_box(pcrtlang("Special Order Parts"));

echo "<a href=\"stock.php?func=addspo\" style=\"white-space: nowrap\" class=\"linkbuttonmedium linkbuttongray radiusleft\"><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Add Special Order Item")."</a>";
echo "<a href=\"stock.php?func=specialorders\" style=\"white-space: nowrap\" class=\"linkbuttonmedium linkbuttongray radiusright\"><i class=\"fa fa-chevron-right fa-lg\"></i> ".pcrtlang("Show Open Special Orders")."</a><br><br>";



if(mysqli_num_rows($rs_result_total) > 0) {


echo "<table style=\"padding-left:10px;padding-right:10px;\" class=standard>";
echo "<tr><th>".pcrtlang("Part Name")."</th><th>".pcrtlang("Qty")."/".pcrtlang("Price")."</th>";
echo "<th style=\"padding-left:10px;padding-right:10px;text-align:right;\">".pcrtlang("Supplier")."</th>";
echo "<th style=\"padding-left:10px;padding-right:10px;\">".pcrtlang("Supplier PN")."</th>";
echo "<th>".pcrtlang("Url")."</th><th>".pcrtlang("Tracking No.")."</th>";
echo "<th>".pcrtlang("Date");

if($sortby == "date_desc") {
echo " <a href=stock.php?func=specialordersall&pageNumber=$pageNumber&sortby=date_asc class=\"linkbuttontiny linkbuttongray radiusall\"><i class=\"fa fa-sort\"></i></a>";
} else {
echo " <a href=stock.php?func=specialordersall&pageNumber=$pageNumber&sortby=date_desc class=\"linkbuttontiny linkbuttongray radiusall\"><i class=\"fa fa-sort\"></i></a>";
}

echo "</td><th>".pcrtlang("Status")."</th>";
echo "<th>".pcrtlang("Work Order")."</th>";
echo "<th></th></tr>";
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

echo "<tr><td>$spopartname</td><td align=right>".qf("$quantity")."<br>$money".mf("$unit_price")."<br>$money".mf("$spoprice")."</td>";

if($sposupplierid != 0) {
$rs_find_suppliers = "SELECT * FROM suppliers WHERE supplierid = '$sposupplierid'";
$rs_result_supp = mysqli_query($rs_connect, $rs_find_suppliers);
$rs_result_suppq = mysqli_fetch_object($rs_result_supp);
$suppliername2 = "$rs_result_suppq->suppliername";
} else {
$suppliername2 = "$sposuppliername";
}


if(perm_check("23") && ($sposupplierid != 0)) {
echo "<td><a href=\"suppliers.php?func=viewsupplier&supplierid=$sposupplierid\" class=\"linkbuttontiny linkbuttongray radiusall\">$suppliername2</a></td>";
} else {
echo "<td>$suppliername2</td>";
}

echo "<td><span class=\"sizemesmaller\">$spopartnumber</span></td>";
echo "<td>";
if($spoparturl != "") {
$parturl2 = addhttp("$spoparturl");
echo "<a href=\"$parturl2\" target=\"_blank\" class=\"linkbuttontiny linkbuttongray radiusall\"><i class=\"fa fa-external-link fa-lg\"></i></a>";
}
echo "</td>";

echo "<td>";

if($spotracking != "") {
echo "<a href=\"http://google.com/#q=$spotracking\" target=\"_blank\" class=\"linkbuttontiny linkbuttongray radiusall\">$spotracking</a></td>";
}

echo "<td><span class=\"sizemesmaller\">$spodate</span>";
echo "</td>";
echo "<td><span class=\"sizemesmaller boldme\">$statii[$spostatus]</span><br><span class=\"sizemesmaller\">$sponotes</span></td>";

echo "<td>";

if($spowoid != 0) {
echo "<a href=\"../repair/index.php?pcwo=$spowoid\" class=\"linkbuttontiny linkbuttongray radiusall\">#$spowoid</a>";
}

echo "</td>";

echo "<td>";
echo "<a href=\"stock.php?func=deletespo&spoid=$spoid\" style=\"white-space: nowrap\" onClick=\"return confirm('".pcrtlang("Are you sure you wish to permanently delete this special order!!!?")."');\" class=\"linkbuttontiny linkbuttongray radiusleft\"><i class=\"fa fa-trash-o fa-lg\"></i> ".pcrtlang("delete")."</a>";
echo "<a href=\"stock.php?func=editspo&spoid=$spoid\" style=\"white-space: nowrap\" class=\"linkbuttontiny linkbuttongray radiusright\"><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("edit")."</a><br>";
if($spoopenclosed == 0) {
echo "<a href=\"stock.php?func=spoopenclose&spoid=$spoid&openclose=1\" style=\"white-space: nowrap\" class=\"linkbuttontiny linkbuttongray radiusall\"><i class=\"fa fa-sign-out fa-lg\"></i> ".pcrtlang("close")."</a> &nbsp; ";
} else {
echo "<a href=\"stock.php?func=spoopenclose&spoid=$spoid&openclose=0\" style=\"white-space: nowrap\" class=\"linkbuttontiny linkbuttongray radiusall\"><i class=\"fa fa-sign-in fa-lg\"></i> ".pcrtlang("re-open")."</a> &nbsp; ";
}



echo "<a href=\"cart.php?func=spoaddcart&spoid=$spoid\" style=\"white-space: nowrap\" class=\"linkbuttontiny linkbuttongray radiusall\"><i class=\"fa fa-shopping-cart fa-lg\"></i> ".pcrtlang("add to cart")."</a> &nbsp; ";

echo "</td>";

echo "</tr>";

}
echo "</table>";

}

stop_box();


echo "<br>";

start_box();

echo "<center>";

#browse here
$totalentry = mysqli_num_rows($rs_result_total);
$prevpage = $pageNumber - 1;
$nextpage = $pageNumber + 1;

if ($pageNumber > 1) {
echo "<a href=stock.php?func=specialordersall&pageNumber=$prevpage&sortby=$sortby class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-left fa-lg\"></i></a>&nbsp;";
}

$total_results = $totalentry;
$results_per_page = $results_per_page;
$html = get_paged_nav($total_results, $results_per_page, false);
echo "$html";

if (($totalentry / $results_per_page) > $pageNumber) {
echo "<a href=stock.php?func=specialordersall&pageNumber=$nextpage&sortby=$sortby class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-right fa-lg\"></i></a>";
}

echo "</center>";
stop_box();


require("footer.php");
}


function undodis() {

$stockid = "$_REQUEST[stockid]";

include("deps.php");
include_once("common.php");
perm_boot("36");

$rs_insert_undo_dis = "UPDATE stock SET dis_cont = '0' WHERE stock_id = '$stockid'";
@mysqli_query($rs_connect, $rs_insert_undo_dis);

header("Location: stock.php?func=show_stock_detail&stockid=$stockid");

}

function discont2() {

$stockid = "$_REQUEST[stockid]";

include("deps.php");
include_once("common.php");
perm_boot("36");

$rs_insert_undo_dis = "UPDATE stock SET dis_cont = '1' WHERE stock_id = '$stockid'";
@mysqli_query($rs_connect, $rs_insert_undo_dis);

header("Location: stock.php?func=show_stock_detail&stockid=$stockid");

}


function noninventory() {
require("header.php");
require_once("common.php");
require("deps.php");

perm_boot("6");

mysqli_query($rs_connect, "SET CHARACTER SET utf8");

start_blue_box(pcrtlang("Quick Non-Inventoried Items"));
echo "<a href=../repair/admin.php class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-circle-left fa-lg\"></i> ".pcrtlang("Go Back to Settings")."</a><br><br>";
echo "<table class=standard>";
$rs_qni = "SELECT * FROM stocknoninv ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_qni);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$niid = "$rs_result_q1->niid";
$ni_title = pf("$rs_result_q1->ni_title");
$ni_price = "$rs_result_q1->ni_price";
$theorder = "$rs_result_q1->theorder";
$ni_pdesc = pf("$rs_result_q1->ni_pdesc");

$primero = mb_substr("$ni_title", 0, 1);

if("$primero" != "-") {
echo "<tr><td valign=top><form action=stock.php?func=noninventorysave method=post><input type=hidden name=niid value=$niid>";
echo "<a href=stock.php?func=reordernoninventory&niid=$niid&dir=up&theorder=$theorder class=\"linkbuttonsmall linkbuttongray radiusleft\"><i class=\"fa fa-chevron-up fa-lg\"></i></a>";
echo "<a href=stock.php?func=reordernoninventory&niid=$niid&dir=down&theorder=$theorder class=\"linkbuttonsmall linkbuttongray radiusright\"><i class=\"fa fa-chevron-down fa-lg\"></i></a>";
echo "</td>";
echo "<td><input type=text name=ni_title size=40 value=\"$ni_title\" class=textbox>&nbsp;&nbsp; $money
<input type=text name=ni_price id=ni_price"."$niid size=8 value=\"".mf($ni_price)."\" class=textbox>";

$usertaxid = getusertaxid();
$salestaxrateremain = (1 + getsalestaxrate($usertaxid));

if($salestaxrateremain != 1) {
echo "<button class=button type=button onclick='document.getElementById(\"ni_price"."$niid\").value=(document.getElementById(\"ni_price"."$niid\").value / $salestaxrateremain).toFixed(5);this.disabled=true;'>
<i class=\"fa fa-calculator\"></i> ".pcrtlang("Pre-tax")."</button>";
}

echo "<br><textarea name=ni_pdesc style=\"width:380px;height:40px\" value=\"$ni_pdesc\" class=textbox placeholder=\"".pcrtlang("Enter Optional Printed Description")."\">$ni_pdesc</textarea>";
echo "</td><td valign=top><button type=submit class=sbutton><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button></form></td><td valign=top>
<form action=stock.php?func=noninventorydelete method=post>";
echo "<input type=hidden name=niid value=$niid>";
echo "<button type=submit class=ibutton><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")."</button></form>";
} else {
$ni_title2 = mb_substr("$ni_title", 1);
echo "<tr><td valign=top><input type=hidden name=niid value=$niid>";
echo "<a href=stock.php?func=reordernoninventory&niid=$niid&dir=up&theorder=$theorder class=\"linkbuttonsmall linkbuttongray radiusleft\"><i class=\"fa fa-chevron-up fa-lg\"></i></a>";
echo "<a href=stock.php?func=reordernoninventory&niid=$niid&dir=down&theorder=$theorder class=\"linkbuttonsmall linkbuttongray radiusright\"><i class=\"fa fa-chevron-down fa-lg\"></i></a>";
echo "</td>";
echo "<td><span class=\"linkbuttongraylabel linkbuttonsmall radiusall\">$ni_title2</span>";
echo "</td><td valign=top></td><td valign=top><form action=stock.php?func=noninventorydelete method=post>";
echo "<input type=hidden name=niid_id value=$niid>";
echo "<button type=submit class=ibutton><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")."</button></form>";
}


echo "</td></tr>";

}

echo "</table>";

echo "<br><br><span class=\"sizeme16 boldme\">".pcrtlang("Add").":</span><br>";
echo "<form action=stock.php?func=noninventoryadd method=post>";
echo "<input type=text name=ni_title size=30 value=\"\" class=textbox placeholder=\"".pcrtlang("Enter Item Name")."\">&nbsp;&nbsp; $money
<input type=text name=ni_price id=ni_price size=8 value=\"\" class=textbox class=textbox>";

$usertaxid = getusertaxid();
$salestaxrateremain = (1 + getsalestaxrate($usertaxid));
if($salestaxrateremain != 1) {
echo "<button class=button type=button onclick='document.getElementById(\"ni_price\").value=(document.getElementById(\"ni_price\").value / $salestaxrateremain).toFixed(5);this.disabled=true;'>
<i class=\"fa fa-calculator\"></i> ".pcrtlang("Pre-tax")."</button>";
}


echo "<br><textarea name=ni_pdesc cols=50 class=textbox placeholder=\"".pcrtlang("Enter Optional Printed Description")."\"></textarea>";
echo "<button type=submit class=sbutton><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Add")."</button></form>";
echo "<span class=italme>".pcrtlang("Start item name with a - to create a title spacer.")."</span>";
stop_blue_box();

require_once("footer.php");

}


function noninventorysave() {
require_once("validate.php");

require("deps.php");
require("common.php");

perm_boot("6");

$niid = $_REQUEST['niid'];
$ni_title = pv($_REQUEST['ni_title']);
$ni_price = $_REQUEST['ni_price'];
$ni_pdesc = pv($_REQUEST['ni_pdesc']);



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_update_ni = "UPDATE stocknoninv SET ni_title = '$ni_title', ni_price = '$ni_price', ni_pdesc = '$ni_pdesc' WHERE niid = '$niid'";
@mysqli_query($rs_connect, $rs_update_ni);

header("Location: stock.php?func=noninventory");


}

function noninventorydelete() {
require_once("validate.php");

require("deps.php");
require("common.php");

$niid = $_REQUEST['niid'];

perm_boot("6");

if (($demo == "yes") && ("$ipofpc" != "admin")) {
die("Sorry this feature is disabled in demo mode");
}



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_deleteni = "DELETE FROM stocknoninv WHERE niid = '$niid'";
@mysqli_query($rs_connect, $rs_deleteni);
header("Location: stock.php?func=noninventory");

}



function noninventoryadd() {
require_once("validate.php");

require("deps.php");
require("common.php");

perm_boot("6");

$ni_title = pv($_REQUEST['ni_title']);
$ni_price = $_REQUEST['ni_price'];
$ni_desc = pv($_REQUEST['ni_desc']);
$ni_pdesc = pv($_REQUEST['ni_pdesc']);

mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_ni = "INSERT INTO stocknoninv (ni_title,ni_price,ni_pdesc) VALUES ('$ni_title','$ni_price','$ni_pdesc')";
@mysqli_query($rs_connect, $rs_insert_ni);

header("Location: stock.php?func=noninventory");


}


function reordernoninventory() {
require_once("validate.php");

$niid = $_REQUEST['niid'];
$dir = $_REQUEST['dir'];
$theorder = $_REQUEST['theorder'];

require("deps.php");
require_once("common.php");
perm_boot("6");

mysqli_query($rs_connect, "SET NAMES 'utf8'");

if ($dir == "up") {
$rs_sq = "SELECT * FROM stocknoninv WHERE theorder > '$theorder' ORDER BY theorder ASC LIMIT 1";
} else {
$rs_sq = "SELECT * FROM stocknoninv WHERE theorder < '$theorder' ORDER BY theorder DESC LIMIT 1";
}

$rs_result1 = mysqli_query($rs_connect, $rs_sq);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
if(mysqli_num_rows($rs_result1) == "0") {
$nextorder = "$theorder";
} else {
$nextorder = "$rs_result_q1->theorder";
}


if ($dir == "up") {
$neworder = $nextorder + 1;
} else {
$neworder = $nextorder -1;
}

$rs_insert_reorder = "UPDATE stocknoninv SET theorder = '$neworder' WHERE niid = $niid";
@mysqli_query($rs_connect, $rs_insert_reorder);


$rs_resetorder = "SELECT * FROM stocknoninv ORDER BY theorder ASC";
$rs_resultreset = mysqli_query($rs_connect, $rs_resetorder);
$a = 0;
while($rs_result_r1 = mysqli_fetch_object($rs_resultreset)) {
$qniid = "$rs_result_r1->niid";
$rs_set_order = "UPDATE stocknoninv SET theorder = '$a' WHERE niid = $qniid";
@mysqli_query($rs_connect, $rs_set_order);
$a = $a + 5;
}


header("Location: stock.php?func=noninventory");


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

    case "discont2":
    discont2();
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

case "undodis":
    undodis();
    break;

case "noninventory":
    noninventory();
    break;

case "noninventorydelete":
    noninventorydelete();
    break;

case "noninventoryadd":
    noninventoryadd();
    break;

case "noninventorysave":
    noninventorysave();
    break;

case "reordernoninventory":
    reordernoninventory();
    break;


}


