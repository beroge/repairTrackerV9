<?php
                                                                                                    
/***************************************************************************
 *   copyright            : (C) 2010 PCRepairTracker.com
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

                                                                                                    
function newsupplier() {
require_once("dheader.php");
require("deps.php");

perm_boot("24");

dheader(pcrtlang("New Supplier"));

echo "<form action=suppliers.php?func=newsupplier2 method=post  data-ajax=\"false\">";
echo pcrtlang("Supplier Name").":<input type=text name=suppliername required=required>";
echo "<input type=submit id=submitbutton value=\"".pcrtlang("Add New Supplier")."\" data-theme=\"b\">";
echo "</form>";


dfooter();

require_once("dfooter.php");
                                                                                                    
}




function newsupplier2() {
require_once("validate.php");
require("deps.php");
require("common.php");       

perm_boot("24");

$suppliername = pv($_REQUEST['suppliername']);


if ($suppliername == "") { die("Please go back and enter the group name"); }
                                                                




$rs_insert_supplier = "INSERT INTO suppliers (suppliername) VALUES ('$suppliername')";
@mysqli_query($rs_connect, $rs_insert_supplier);
                               
$supplierid = mysqli_insert_id($rs_connect);

header("Location: suppliers.php?func=editsupplier&supplierid=$supplierid");

}








function editsupplier() {
require_once("common.php");
require("deps.php");

perm_boot("24");

require("dheader.php");

$supplierid = $_REQUEST['supplierid'];


dheader(pcrtlang("Edit Supplier"));





$rs_find_supplier = "SELECT * FROM suppliers WHERE supplierid = '$supplierid'";
$rs_result_supplier = mysqli_query($rs_connect, $rs_find_supplier);

while($rs_result_item_q = mysqli_fetch_object($rs_result_supplier)) {
$suppliername = "$rs_result_item_q->suppliername";
$supplierphone = "$rs_result_item_q->supplierphone";
$supplieremail = "$rs_result_item_q->supplieremail";
$supplieraddress1 = "$rs_result_item_q->supplieraddress1";
$supplieraddress2 = "$rs_result_item_q->supplieraddress2";
$suppliercity = "$rs_result_item_q->suppliercity";
$supplierstate = "$rs_result_item_q->supplierstate";
$supplierzip = "$rs_result_item_q->supplierzip";
$suppliernotes = "$rs_result_item_q->suppliernotes";
$supplierwebsite = "$rs_result_item_q->supplierwebsite";
$supplieraccountno = "$rs_result_item_q->supplieraccountno";

echo "<form action=suppliers.php?func=editsupplier2 method=post  data-ajax=\"false\">";
echo pcrtlang("Supplier Name").":<input type=text value=\"$suppliername\" name=suppliername required=required>";
echo pcrtlang("Phone").":<input type=text value=\"$supplierphone\" name=supplierphone>";


echo "<input type=hidden name=supplierid value=$supplierid>";

echo pcrtlang("Email Address").":<input type=text name=supplieremail value=\"$supplieremail\">";

echo "$pcrt_address1<input type=text name=supplieraddress1 value=\"$supplieraddress1\">";
echo "$pcrt_address2<input type=text name=supplieraddress2 value=\"$supplieraddress2\">";
echo "$pcrt_city<input type=text name=suppliercity value=\"$suppliercity\">$pcrt_state<input type=text name=supplierstate value=\"$supplierstate\">$pcrt_zip<input type=text name=supplierzip value=\"$supplierzip\">";

echo pcrtlang("Notes").":<textarea name=suppliernotes>$suppliernotes</textarea>";

echo pcrtlang("Account Number").":<input type=text value=\"$supplieraccountno\" name=supplieraccountno>";
echo pcrtlang("Supplier Website").":<input type=text value=\"$supplierwebsite\" name=supplierwebsite>";


echo "<input type=submit value=\"".pcrtlang("Save")."\" data-theme=\"b\"></form>";

}

dfooter();
require_once("dfooter.php");


}


function editsupplier2() {
require_once("validate.php");
require("deps.php");
require("common.php");

perm_boot("24");

$suppliername = pv($_REQUEST['suppliername']);
$supplierphone = pv($_REQUEST['supplierphone']);
$supplierid = $_REQUEST['supplierid'];

$supplieremail = pv($_REQUEST['supplieremail']);
$supplieraddress1 = pv($_REQUEST['supplieraddress1']);
$supplieraddress2 = pv($_REQUEST['supplieraddress2']);
$suppliercity = pv($_REQUEST['suppliercity']);
$supplierstate = pv($_REQUEST['supplierstate']);
$supplierzip = pv($_REQUEST['supplierzip']);
$suppliernotes = pv($_REQUEST['suppliernotes']);
$supplierwebsite = pv($_REQUEST['supplierwebsite']);
$supplieraccountno = pv($_REQUEST['supplieraccountno']);


if ($suppliername == "") { die("Please go back and enter the supplier name"); }





$rs_supplier_update = "UPDATE suppliers SET suppliername = '$suppliername', supplierphone = '$supplierphone', supplieremail = '$supplieremail', supplieraddress1 = '$supplieraddress1', supplieraddress2 = '$supplieraddress2', suppliercity = '$suppliercity', supplierstate = '$supplierstate', supplierzip = '$supplierzip', suppliernotes = '$suppliernotes', supplierwebsite = '$supplierwebsite', supplieraccountno = '$supplieraccountno' WHERE supplierid = '$supplierid'";
@mysqli_query($rs_connect, $rs_supplier_update);

header("Location: suppliers.php?func=viewsupplier&supplierid=$supplierid");


}



function browsesuppliers() {

if (array_key_exists("pageNumber", $_REQUEST)) {
$pageNumber = $_REQUEST['pageNumber'];
} else {
$pageNumber = 1;
}

if (array_key_exists("sortby", $_REQUEST)) {
$sortby = $_REQUEST['sortby'];
} else {
$sortby = "name_asc";
}


require_once("header.php");


$results_per_page = 40;

if ($pageNumber == "") {
$offset = "0";
} else {
$offset = ($pageNumber * $results_per_page) - $results_per_page;
}



require("deps.php");
require_once("common.php");

perm_boot("23");





if ("$sortby" == "id_asc") {
$rs_find_cart_items = "SELECT * FROM suppliers ORDER BY supplierid ASC LIMIT $offset,$results_per_page";
} elseif ("$sortby" == "id_desc") {
$rs_find_cart_items = "SELECT * FROM suppliers ORDER BY supplierid DESC LIMIT $offset,$results_per_page";
} elseif ("$sortby" == "name_desc") {
$rs_find_cart_items = "SELECT * FROM suppliers ORDER BY suppliername DESC LIMIT $offset,$results_per_page";
} else {
$rs_find_cart_items = "SELECT * FROM suppliers ORDER BY suppliername ASC LIMIT $offset,$results_per_page";
}

$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

$rs_find_cart_items_total = "SELECT * FROM suppliers";
$rs_result_total = mysqli_query($rs_connect, $rs_find_cart_items_total);



echo "<h3>".pcrtlang("Browse Suppliers")."</h3>";


if (perm_check("24")) {
echo "<button type=button onClick=\"parent.location='suppliers.php?func=newsupplier'\"><i class=\"fa fa-plus fa-lg\"></i>".pcrtlang("Add New Supplier")."</button><br>";
}


echo "<div data-role=\"collapsible\" data-theme=\"a\">";
echo "<h3>".pcrtlang("Sort Order")."</h3>";
echo "<button type=button onClick=\"parent.location='suppliers.php?func=browsesuppliers&pageNumber=$pageNumber&sortby=id_asc'\">
<i class=\"fa fa-sort-numeric-asc fa-lg\"></i> ".pcrtlang("By ID, Ascending")."</button>";
echo "<button type=button onClick=\"parent.location='suppliers.php?func=browsesuppliers&pageNumber=$pageNumber&sortby=id_desc'\">
<i class=\"fa fa-sort-numeric-desc fa-lg\"></i> ".pcrtlang("By ID, Descending")."</button>";
echo "<button type=button onClick=\"parent.location='suppliers.php?func=browsesuppliers&pageNumber=$pageNumber&sortby=name_asc'\">
<i class=\"fa fa-sort-alpha-asc fa-lg\"></i> ".pcrtlang("By Name, Ascending")."</button>";
echo "<button type=button onClick=\"parent.location='suppliers.php?func=browsesuppliers&pageNumber=$pageNumber&sortby=name_desc'\">
<i class=\"fa fa-sort-alpha-desc fa-lg\"></i> ".pcrtlang("By Name, Descending")."</button>";
echo "</div><br>";



while($rs_result_q = mysqli_fetch_object($rs_result)) {
$supplierid = "$rs_result_q->supplierid";
$suppliername = "$rs_result_q->suppliername";
$supplierphone = "$rs_result_q->supplierphone";
$supplieremail = "$rs_result_q->supplieremail";
$supplieraddress1 = "$rs_result_q->supplieraddress1";
$supplieraddress2 = "$rs_result_q->supplieraddress2";
$suppliercity = "$rs_result_q->suppliercity";
$supplierstate = "$rs_result_q->supplierstate";
$supplierzip = "$rs_result_q->supplierzip";
$supplieraccountno = "$rs_result_q->supplieraccountno";
$supplierwebsite = "$rs_result_q->supplierwebsite";

echo "<table class=standard><tr><th><button type=button onClick=\"parent.location='suppliers.php?func=viewsupplier&supplierid=$supplierid'\">#$supplierid $suppliername</button></th></tr>";

echo "<tr><td>$supplieraccountno</td></tr>";
echo "<tr><td>$supplierphone</td></tr>";

echo "<tr><td><button type=button onClick=\"parent.location='mailto:$supplieremail'\">$supplieremail</button></td></tr>";

$supplierwebsite2 = addhttp("$supplierwebsite");

$supplierwebhost = parse_url("$supplierwebsite2", PHP_URL_HOST);

echo "<tr><td><a href=\"$supplierwebsite2\" target=\"_blank\"  class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\">$supplierwebhost <i class=\"fa fa-external-link fa-lg\"></i></a></td></tr>";
echo "</table><br>";
}


echo "<br>";

#browse here
$totalentry = mysqli_num_rows($rs_result_total);
$prevpage = $pageNumber - 1;
$nextpage = $pageNumber + 1;

echo "<center>";

if ($pageNumber > 1) {
echo "<button type=button onClick=\"parent.location='suppliers.php?func=browsesuppliers&pageNumber=$prevpage&sortby=$sortby'\">";
echo " <i class=\"fa fa-chevron-left fa-lg\"></i></button>";
}

$total_results = $totalentry;
$results_per_page = $results_per_page;
$html = get_paged_nav($total_results, $results_per_page, false);
echo "$html";

if (($totalentry / $results_per_page) > $pageNumber) {
echo "<button type=button onClick=\"parent.location='suppliers.php?func=browsesuppliers&pageNumber=$nextpage&sortby=$sortby'\">";
echo " <i class=\"fa fa-chevron-right fa-lg\"></i></button>";
}

echo "</center>";

require("footer.php");

}



function viewsupplier() {

$supplierid = $_REQUEST['supplierid'];

require("header.php");
require("deps.php");


perm_boot("23");

echo "<button type=button onClick=\"parent.location='suppliers.php'\"><i class=\"fa fa-chevron-left\"></i> ".pcrtlang("Back to Supplier List")."</button>";

echo "<br>";




$rs_findsupplier = "SELECT * FROM suppliers WHERE supplierid = '$supplierid'";
$rs_result = mysqli_query($rs_connect, $rs_findsupplier);
$rs_result_q = mysqli_fetch_object($rs_result);
$suppliername = "$rs_result_q->suppliername";
$supplierphone = "$rs_result_q->supplierphone";
$supplieraddress1 = "$rs_result_q->supplieraddress1";
$supplieraddress2 = "$rs_result_q->supplieraddress2";
$suppliercity = "$rs_result_q->suppliercity";
$supplierstate = "$rs_result_q->supplierstate";
$supplierzip = "$rs_result_q->supplierzip";
$supplieremail = "$rs_result_q->supplieremail";
$supplierwebsite = "$rs_result_q->supplierwebsite";
$supplieraccountno = "$rs_result_q->supplieraccountno";
$suppliernotes = nl2br("$rs_result_q->suppliernotes");


echo "<h3>$suppliername</h3>";

if($suppliernotes !=	"") {
echo "<br>".pcrtlang("Notes").":<br>$suppliernotes";
}


if (perm_check("24")) {
echo "<br><br><button type=button onClick=\"parent.location='suppliers.php?func=editsupplier&supplierid=$supplierid'\"> <i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("Edit Supplier")."</button>";
}

echo "<table><tr><td bgcolor=#0000ff><i class=\"fa fa-phone fa-lg fa-fw\" style=\"color:#ffffff;\"></i></td><td>";

echo pcrtlang("Phone").": $supplierphone<br>";

echo "</td></tr></table>";


if($supplieraddress1 != "") {
$supplieraddressbr = nl2br($supplieraddress1);
echo "<table><tr><td bgcolor=#0000ff><i class=\"fa fa-map-marker fa-lg fa-fw\" style=\"color:#ffffff;\"></i></td><td>$supplieraddressbr<br>";
if($supplieraddress2 != "") {
echo "$supplieraddress2<br>";
}
if(($suppliercity != "") && ($supplierstate != "") && ($supplierzip != "")) {
echo "$suppliercity, $supplierstate $supplierzip";
}
echo "</td></tr></table>";

}


if($supplieremail != "") {
echo pcrtlang("Email").": <a href=mailto:$supplieremail  class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\">$supplieremail</a><br>";
}

if($supplieraccountno != "") {
echo "<br>".pcrtlang("Account No.").": $supplieraccountno<br>";
}


if($supplierwebsite != "") {

$supplierwebsite2 = addhttp("$supplierwebsite");
$supplierwebhost = parse_url("$supplierwebsite2", PHP_URL_HOST);


echo "<br>".pcrtlang("Website").": <a href=$supplierwebsite2 class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\">$supplierwebhost <i class=\"fa fa-external-link fa-lg\"></i></a><br>";
}




echo "<br>";

require("footer.php");

}




switch($func) {
                                                                                                    
    default:
    browsesuppliers();
    break;
                                
    case "newsupplier":
    newsupplier();
    break;

    case "newsupplier2":
    newsupplier2();
    break;
                                   
    case "viewsupplier":
    viewsupplier();
    break;
                                 
  case "editsupplier":
    editsupplier();
    break;

  case "editsupplier2":
    editsupplier2();
    break;

  case "browsesuppliers":
    browsesuppliers();
    break;



}

?>

