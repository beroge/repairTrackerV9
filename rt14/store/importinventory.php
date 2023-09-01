<?php


/***************************************************************************
 *   copyright            : (C) 2014 PCRepairTracker.com
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


function pickcsv() {
require_once("header.php");
require("deps.php");
require_once("common.php");


start_blue_box(pcrtlang("Choose CSV to Upload"));
echo "<form action=importinventory.php?func=importcsv method=post>";
echo pcrtlang("Paste CSV").":<br>";
echo "<textarea class=textbox name=csv cols=120 rows=50></textarea><br>";
echo "<input type=submit class=button value=\"".pcrtlang("Read CSV")."\"></form>";
stop_blue_box();


require_once("footer.php");

}



function importcsv() {
require_once("header.php");
require("deps.php");
require_once("common.php");

$csv = trim($_REQUEST['csv']);

function parse_csv ($csv_string, $delimiter = ",", $skip_empty_lines = true, $trim_fields = true)
{
    $enc = preg_replace('/(?<!")""/', '!!Q!!', $csv_string);
    $enc = preg_replace_callback(
        '/"(.*?)"/s',
        function ($field) {
            return urlencode(utf8_encode($field[1]));
        },
        $enc
    );
    $lines = preg_split($skip_empty_lines ? ($trim_fields ? '/( *\R)+/s' : '/\R+/s') : '/\R/s', $enc);
    return array_map(
        function ($line) use ($delimiter, $trim_fields) {
            $fields = $trim_fields ? array_map('trim', explode($delimiter, $line)) : explode($delimiter, $line);
            return array_map(
                function ($field) {
                    return str_replace('!!Q!!', '"', utf8_decode(urldecode($field)));
                },
                $fields
            );
        },
        $lines
    );
}

$csvarray = parse_csv($csv);

start_blue_box(pcrtlang("Import Inventory from CSV"));

echo pcrtlang("The first record has been pulled from your CSV file, match up the fields to the appropriate fields. If you do not have a field that matches, leave it set to [No Match]");

$options = "<option value=\"nomatch\">No Match</option>";
foreach($csvarray[0] as $key => $val) {
$options .= "<option value=\"$key\">$val</option>";
}

echo "<table>";
echo "<tr><td><form action=importinventory.php?func=importcsv2 method=post>".pcrtlang("Name of Product").": </td><td><select name=prodname>$options</select></td>";
echo "<td rowspan=17 style=\"vertical-align:top\"><textarea class=textbox name=csv cols=60 rows=10>$csv</textarea></td></tr>";
echo "<tr><td>".pcrtlang("Product Desc").": </td><td><select name=proddesc>$options</select></td></tr>";
echo "<tr><td>".pcrtlang("Price").": </td><td><select name=prodprice>$options</select></td></tr>";
echo "<tr><td>".pcrtlang("UPC").": </td><td><select name=produpc>$options</select></td></tr>";
echo "<tr><td>".pcrtlang("Quantity").": </td><td><select name=prodqty>$options</select></td></tr>";
echo "<tr><td>".pcrtlang("Average Cost").": </td><td><select name=avgcost>$options</select></td></tr>";
echo "<tr><td colspan=2><br></td></tr>";
echo "<tr><td>".pcrtlang("Select Stock Category to import to:").": </td><td><select name=stockcat>";








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

echo "<tr><td>".pcrtlang("Select Store to save stock qty to:").": </td><td><select name=storetoimport>";

$rs_find_stores = "SELECT * FROM stores WHERE storeenabled = '1' ORDER BY storesname ASC";
$rs_result_stores = mysqli_query($rs_connect, $rs_find_stores);


while($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
$rs_storesname = "$rs_result_storeq->storesname";
$rs_storeid = "$rs_result_storeq->storeid";

if ($rs_storeid == $defaultuserstore) {
echo "<option selected value=$rs_storeid>$rs_storesname</option>";
} else {
echo "<option value=$rs_storeid>$rs_storesname</option>";
}
}
echo "</select>";



echo "<tr><td colspan=2><input type=submit class=button value=\"".pcrtlang("Import")."\"></form></td></tr>";

echo "</table>";

stop_blue_box();

require_once("footer.php");

}


function importcsv2() {
require_once("header.php");
require("deps.php");
require_once("common.php");

$csv = trim($_REQUEST['csv']);


$prodname = $_REQUEST['prodname'];
$proddesc = $_REQUEST['proddesc'];
$produpc = $_REQUEST['produpc'];
$prodprice = $_REQUEST['prodprice'];
$prodqty = $_REQUEST['prodqty'];
$avgcost = $_REQUEST['avgcost'];
$stockcat = $_REQUEST['stockcat'];
$storetoimport = $_REQUEST['storetoimport'];

if($stockcat != "") {
$stockcatset = "$stockcat";
} else {
$stockcatset = "1";
}


if($storetoimport != "") {
$storetoimportset = "$storetoimport";
} else {
$storetoimportset = "1";
}





function parse_csv ($csv_string, $delimiter = ",", $skip_empty_lines = true, $trim_fields = true)
{
    $enc = preg_replace('/(?<!")""/', '!!Q!!', $csv_string);
    $enc = preg_replace_callback(
        '/"(.*?)"/s',
        function ($field) {
            return urlencode(utf8_encode($field[1]));
        },
        $enc
    );
    $lines = preg_split($skip_empty_lines ? ($trim_fields ? '/( *\R)+/s' : '/\R+/s') : '/\R/s', $enc);
    return array_map(
        function ($line) use ($delimiter, $trim_fields) {
            $fields = $trim_fields ? array_map('trim', explode($delimiter, $line)) : explode($delimiter, $line);
            return array_map(
                function ($field) {
                    return str_replace('!!Q!!', '"', utf8_decode(urldecode($field)));
                },
                $fields
            );
        },
        $lines
    );
}

$csvarray = parse_csv($csv);

start_blue_box(pcrtlang("Import Results..."));

foreach($csvarray as $key => $val) {

if(($prodname != "nomatch") && ($val["$prodname"] != '"')){
$prodnameset = $val["$prodname"];
} else {
$prodnameset = "";
}

if(($proddesc != "nomatch") && ($val["$proddesc"] != '"')){
$proddescset = $val["$proddesc"];
} else {
$proddescset = "";
}

if(($produpc != "nomatch") && ($val["$produpc"] != '"')){
$produpcset = $val["$produpc"];
} else {
$produpcset = "";
}

if(($prodprice != "nomatch") && ($val["$prodprice"] != '"')){
$prodpriceset = $val["$prodprice"];
} else {
$prodpriceset = "";
}

if(($prodqty != "nomatch") && ($val["$prodqty"] != '"')){
$prodqtyset = $val["$prodqty"];
} else {
$prodqtyset = "0";
}

if(($avgcost != "nomatch") && ($val["$avgcost"] != '"')){
$avgcostset = $val["$avgcost"];
} else {
$avgcostset = "0";
}




$rs_insert_stock = "INSERT INTO stock (stock_title,stock_desc,stock_cat,stock_price,stock_upc,avg_cost) 
VALUES ('$prodnameset','$proddescset','$stockcatset','$prodpriceset','$produpcset','$avgcostset')";
@mysqli_query($rs_connect, $rs_insert_stock);

if($prodqtyset > 0) {
$lastinsert = mysqli_insert_id($rs_connect);
checkstorecount($lastinsert);

$rs_insert_qty = "UPDATE stockcounts SET quantity = '$prodqtyset' WHERE storeid = '$storetoimportset' AND stockid = '$lastinsert'";
@mysqli_query($rs_connect, $rs_insert_qty);

}


updatecategories();



echo "$prodnameset<br>";

}






stop_blue_box();

require_once("footer.php");

}


switch($func) {

    default:
    pickcsv();
    break;

    case "importcsv":
    importcsv();
    break;

 case "importcsv2":
    importcsv2();
    break;
	
}


?>

