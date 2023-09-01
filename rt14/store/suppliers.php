<?php
                                                                                                    
/***************************************************************************
 *   copyright            : (C) 2017 PCRepairTracker.com
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
require_once("header.php");
require("deps.php");

perm_boot("24");

start_blue_box(pcrtlang("Add New Supplier"));

echo "<form action=suppliers.php?func=newsupplier2 method=post>";
echo "<table>";
echo "<tr><td>".pcrtlang("Supplier Name").":</td><td><input size=35 class=textbox type=text name=suppliername required=required>";
echo "<button class=button type=submit id=submitbutton><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Add New Supplier")."</button>";
echo "</form>";
echo "</td></tr>";


echo "</table>";

stop_blue_box();

require_once("footer.php");
                                                                                                    
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

require("header.php");

$supplierid = $_REQUEST['supplierid'];


start_blue_box(pcrtlang("Edit Supplier"));





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

echo "<form action=suppliers.php?func=editsupplier2 method=post>";
echo "<table width=100%>";
echo "<tr><td>".pcrtlang("Supplier Name").":</td><td><input size=35 type=text value=\"$suppliername\" name=suppliername class=textbox required=required></td></tr>";
echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
echo "<tr><td>".pcrtlang("Phone").":</td><td><input size=35 type=text value=\"$supplierphone\" name=supplierphone class=textbox></td></tr>";


echo "<input type=hidden name=supplierid value=$supplierid></td></tr>";

echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
echo "<tr><td>".pcrtlang("Email Address").":</td><td><input size=35 type=text class=textbox name=supplieremail value=\"$supplieremail\"></td></tr>";

echo "<tr><td>$pcrt_address1</td><td><input type=text class=textbox name=supplieraddress1 size=35 value=\"$supplieraddress1\"></td></tr>";
echo "<tr><td>$pcrt_address2</td><td><input size=25 type=text class=textbox name=supplieraddress2 value=\"$supplieraddress2\"></td></tr>";
echo "<tr><td>$pcrt_city, $pcrt_state, $pcrt_zip</td><td><input size=16 type=text class=textbox name=suppliercity value=\"$suppliercity\"><input size=5 type=text class=textbox name=supplierstate value=\"$supplierstate\"><input size=10 type=text class=textbox name=supplierzip value=\"$supplierzip\"></td></tr>";

echo "<tr><td>".pcrtlang("Notes").":</td><td><textarea class=textbox name=suppliernotes cols=40 rows=5>$suppliernotes</textarea></td></tr>";

echo "<tr><td>".pcrtlang("Account Number").":</td><td><input size=35 type=text value=\"$supplieraccountno\" name=supplieraccountno class=textbox></td></tr>";
echo "<tr><td>".pcrtlang("Supplier Website").":</td><td><input size=35 type=text value=\"$supplierwebsite\" name=supplierwebsite class=textbox></td></tr>";


echo "<tr><td>&nbsp;</td><td><input class=button type=submit value=\"".pcrtlang("Save")."\"></form></td></tr>";
echo "</table>";

}

stop_blue_box();
require_once("footer.php");


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

echo "<script type=\"text/javascript\">document.title = \"".pcrtlang("Suppliers")."\";</script>";

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



start_blue_box(pcrtlang("Browse Suppliers"));


if (perm_check("24")) {
echo "<a href=\"suppliers.php?func=newsupplier\" class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Add New Supplier")."</a><br><br>";
}

echo "<table class=standard>";
echo "<tr><th>".pcrtlang("ID")."#";
echo "</th><th><a href=suppliers.php?func=browsesuppliers&pageNumber=$pageNumber&sortby=id_asc class=\"linkbuttontiny linkbuttongray radiustop\">
<i class=\"fa fa-chevron-up\"></i></a><br>";
echo "<a href=suppliers.php?func=browsesuppliers&pageNumber=$pageNumber&sortby=id_desc class=\"linkbuttontiny linkbuttongray radiusbottom\">
<i class=\"fa fa-chevron-down\"></i></a>";
echo "</th><th>".pcrtlang("Supplier Name");
echo "</th><th><a href=suppliers.php?func=browsesuppliers&pageNumber=$pageNumber&sortby=name_asc class=\"linkbuttontiny linkbuttongray radiustop\">
<i class=\"fa fa-chevron-up\"></i></a><br>";
echo "<a href=suppliers.php?func=browsesuppliers&pageNumber=$pageNumber&sortby=name_desc class=\"linkbuttontiny linkbuttongray radiusbottom\">
<i class=\"fa fa-chevron-down\"></i></a>";
echo "</th>";
echo "<th>".pcrtlang("Account No.");
echo "</th>";

echo "<th>".pcrtlang("Supplier Phone")."</th><th>".pcrtlang("Supplier Email")."</th><th>".pcrtlang("Website")."</th>";
echo "</tr>";

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

echo "<tr><td colspan=2><a href=suppliers.php?func=viewsupplier&supplierid=$supplierid class=\"linkbuttonmedium linkbuttongray radiusall\">#$supplierid</a></td>";
echo "<td colspan=2><a href=suppliers.php?func=viewsupplier&supplierid=$supplierid class=\"linkbuttonmedium linkbuttongray radiusall\">$suppliername</a></td>";

echo "<td>$supplieraccountno</td>";
echo "<td>$supplierphone</td>";

echo "<td>";
if($supplieremail != "") {
echo "<a href=\"mailto:$supplieremail\" class=\"linkbuttonmedium linkbuttongray radiusall\">$supplieremail</a>";
}
echo "</td>";

$supplierwebsite2 = addhttp("$supplierwebsite");

$supplierwebhost = parse_url("$supplierwebsite2", PHP_URL_HOST);

echo "<td><a href=\"$supplierwebsite2\" target=\"_blank\" class=\"linkbuttonmedium linkbuttongray radiusall\">$supplierwebhost <i class=\"fa fa-external-link fa-lg\"></i></td></tr>";

}

echo "</table>";

stop_blue_box();

echo "<br>";

start_box();
#browse here
$totalentry = mysqli_num_rows($rs_result_total);
$prevpage = $pageNumber - 1;
$nextpage = $pageNumber + 1;

if ($pageNumber > 1) {
echo "<a href=suppliers.php?func=browsesuppliers&pageNumber=$prevpage&sortby=$sortby class=imagelink><img src=images/left.png border=0 align=absmiddle";
echo " alt=\"".pcrtlang("Show Previous Page")."\"></a>&nbsp;";
}

$total_results = $totalentry;
$results_per_page = $results_per_page;
$html = get_paged_nav($total_results, $results_per_page, false);
echo "$html";

if (($totalentry / $results_per_page) > $pageNumber) {
echo "<a href=suppliers.php?func=browsesuppliers&pageNumber=$nextpage&sortby=$sortby class=imagelink><img src=images/right.png border=0 ";
echo "align=absmiddle alt=\"".pcrtlang("Show Next Page")."\"></a>";
}

stop_box();

require("footer.php");

}



function viewsupplier() {

$supplierid = $_REQUEST['supplierid'];

require("header.php");
require("deps.php");


perm_boot("23");

start_box();

echo "<a href=\"suppliers.php\" class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-left\"></i> ".pcrtlang("Back to Supplier List")."</a>";

stop_box();
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

echo "<div class=\"groupbox colorbox\">";
echo "<table style=\"width:100%\"><tr><td style=\"width:50%\">";

echo "<h4>$suppliername</h4>";

if($suppliernotes !=	"") {
echo "<br><br>".pcrtlang("Notes").":<br>$suppliernotes";
}


if (perm_check("24")) {
echo "<br><br><a href=\"suppliers.php?func=editsupplier&supplierid=$supplierid\" class=\"linkbuttonmedium linkbuttongray radiusall\">".pcrtlang("Edit Supplier")."</a>";
}

echo "</td><td style=\"width:25%;vertical-align:top\">";

echo "<table border=0 cellspacing=0 cellpadding=2><tr><td style=\"background: #777777;\" class=radiusall><i class=\"fa fa-phone fa-lg\" style=\"padding:20px 3px; color:#ffffff;\"></i></td><td>";

echo "&nbsp;".pcrtlang("Phone").": $supplierphone<br>";

echo "</td></tr></table>";


echo "</td><td style=\"width:25%;vertical-align:top\">";

if($supplieraddress1 != "") {
$supplieraddressbr = nl2br($supplieraddress1);
echo "<table cellpadding=2 cellspacing=0 border=0><tr><td style=\"background: #777777;\" class=radiusall><i class=\"fa fa-map-marker fa-lg\" style=\"padding:20px 5px; color:#ffffff;\"></i></td><td>$supplieraddressbr<br>";
if($supplieraddress2 != "") {
echo "$supplieraddress2<br>";
}
if(($suppliercity != "") && ($supplierstate != "") && ($supplierzip != "")) {
echo "$suppliercity, $supplierstate $supplierzip";
}
echo "</td></tr></table>";

}


echo "</td></tr><tr><td>";


echo "</td><td colspan=2>";

if($supplieremail != "") {
echo "".pcrtlang("Email").": <a href=mailto:$supplieremail class=\"linkbuttonmedium linkbuttongray radiusall\">$supplieremail</a><br>";
}

if($supplieraccountno != "") {
echo "".pcrtlang("Account No.").": $supplieraccountno<br>";
}


if($supplierwebsite != "") {

$supplierwebsite2 = addhttp("$supplierwebsite");
$supplierwebhost = parse_url("$supplierwebsite2", PHP_URL_HOST);


echo "".pcrtlang("Website").": <a href=$supplierwebsite2 class=\"linkbuttonmedium linkbuttongray radiusall\">$supplierwebhost <i class=\"fa fa-external-link fa-lg\"></i></a><br>";
}



echo "</td></tr></table>";


echo "</div>";


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

