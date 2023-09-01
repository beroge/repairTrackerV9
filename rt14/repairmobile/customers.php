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


function custlist() {

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




if ("$sortby" == "id_asc") {
$rs_find_cart_items = "SELECT * FROM pc_owner ORDER BY pcid ASC LIMIT $offset,$results_per_page";
} elseif ("$sortby" == "id_desc") {
$rs_find_cart_items = "SELECT * FROM pc_owner ORDER BY pcid DESC LIMIT $offset,$results_per_page";
} elseif ("$sortby" == "name_desc") {
$rs_find_cart_items = "SELECT * FROM pc_owner ORDER BY pcname DESC LIMIT $offset,$results_per_page";
} elseif ("$sortby" == "name_asc") {
$rs_find_cart_items = "SELECT * FROM pc_owner ORDER BY pcname ASC LIMIT $offset,$results_per_page";
} elseif ("$sortby" == "company_asc") {
$rs_find_cart_items = "SELECT * FROM pc_owner ORDER BY pccompany ASC LIMIT $offset,$results_per_page";
} else {
$rs_find_cart_items = "SELECT * FROM pc_owner ORDER BY pccompany DESC LIMIT $offset,$results_per_page";
}



$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

$rs_find_cart_items_total = "SELECT * FROM pc_owner";
$rs_result_total = mysqli_query($rs_connect, $rs_find_cart_items_total);



echo "<h3>".pcrtlang("Browse Assets/Customers")."</h3>";

echo "<button type=button onClick=\"parent.location='pc.php?func=addassetonly'\"><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Add New Customer/Asset")."</button>";

echo "<div data-role=\"collapsible\" data-theme=\"a\">";
echo "<h3>".pcrtlang("Sort Order")."</h3>";
echo "<button type=button onClick=\"parent.location='customers.php?pageNumber=$pageNumber&sortby=id_asc'\"><i class=\"fa fa-sort-numeric-asc fa-lg\"></i> ".pcrtlang("By ID, Ascending")."</button>";
echo "<button type=button onClick=\"parent.location='customers.php?pageNumber=$pageNumber&sortby=id_desc'\"><i class=\"fa fa-sort-numeric-desc fa-lg\"></i> ".pcrtlang("By ID, Descending")."</button>";
echo "<button type=button onClick=\"parent.location='customers.php?pageNumber=$pageNumber&sortby=name_asc'\"><i class=\"fa fa-sort-alpha-asc fa-lg\"></i> ".pcrtlang("By Name, Ascending")."</button>";
echo "<button type=button onClick=\"parent.location='customers.php?pageNumber=$pageNumber&sortby=name_desc'\"><i class=\"fa fa-sort-alpha-desc fa-lg\"></i> ".pcrtlang("By Name, Descending")."</button>";
echo "<button type=button onClick=\"parent.location='customers.php?pageNumber=$pageNumber&sortby=company_asc'\"><i class=\"fa fa-sort-alpha-asc fa-lg\"></i> ".pcrtlang("By Company, Ascending")."</button>";
echo "<button type=button onClick=\"parent.location='customers.php?pageNumber=$pageNumber&sortby=company_desc'\"><i class=\"fa fa-sort-alpha-desc fa-lg\"></i> ".pcrtlang("By Company, Descending")."</button>";
echo "</div><br>";


while($rs_result_q = mysqli_fetch_object($rs_result)) {
$pcid = "$rs_result_q->pcid";
$rs_pcname = "$rs_result_q->pcname";
$rs_pccompany = "$rs_result_q->pccompany";
$rs_pcmake = "$rs_result_q->pcmake";
$rs_pcphone = "$rs_result_q->pcphone";
$rs_pcworkphone = "$rs_result_q->pcworkphone";
$rs_pccellphone = "$rs_result_q->pccellphone";
$rs_pcemail = "$rs_result_q->pcemail";
$rs_pcaddress = "$rs_result_q->pcaddress";
$rs_pcaddress2 = "$rs_result_q->pcaddress2";
$rs_pccity = "$rs_result_q->pccity";
$rs_pcstate = "$rs_result_q->pcstate";
$rs_pczip = "$rs_result_q->pczip";
$rs_prefcontact = "$rs_result_q->prefcontact";


echo "<table class=standard><tr><th>#$pcid ";
echo "$rs_pcname<br>";
echo "$rs_pccompany</td></tr><tr><td>";

echo pcrtlang("Work Phone").": $rs_pcworkphone";
echo "<br>".pcrtlang("Mobile Phone").": $rs_pccellphone";
echo "<br>".pcrtlang("Home Phone").": $rs_pcphone";

if("$rs_pcemail" != "") {
echo "<br>".pcrtlang("Email").": $rs_pcemail";
}

echo "<br>".pcrtlang("Asset/Device Make").": $rs_pcmake";

echo "<button type=button onClick=\"parent.location='pc.php?func=showpc&pcid=$pcid'\">View Asset/Device</button>";

echo "</td></tr></table><br><br>";

}


echo "<br>";

#browse here
$totalentry = mysqli_num_rows($rs_result_total);
$prevpage = $pageNumber - 1;
$nextpage = $pageNumber + 1;

echo "<div style=\"text-align:center\">";

if ($pageNumber > 1) {
echo "<button type=button onClick=\"parent.location='customers.php?func=custlist&pageNumber=$prevpage&sortby=$sortby'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\">";
echo "<i class=\"fa fa-chevron-left fa-lg\"></i>";
echo "</button>";
}

$total_results = $totalentry;
$results_per_page = $results_per_page;
$html = get_paged_nav($total_results, $results_per_page, false);
echo "$html";

if (($totalentry / $results_per_page) > $pageNumber) {
echo "<button type=button onClick=\"parent.location='customers.php?func=custlist&pageNumber=$nextpage&sortby=$sortby'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\">";
echo "<i class=\"fa fa-chevron-right fa-lg\"></i></button>";
}

echo "</div>";

require("footer.php");

}



######

switch($func) {
                                                                                                    
    default:
    custlist();
    break;
                                
    case "custlist":
    custlist();
    break;


}

?>

