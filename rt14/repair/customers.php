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

require("deps.php");
require_once("common.php");

require_once("header.php");


echo "<script>document.title = \"".pcrtlang("Assets/Devices")."\";</script>";

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

if (array_key_exists("search", $_REQUEST)) {
$search = $_REQUEST['search'];
} else {
$search = "";
}

$search_ue = urlencode($search);

start_blue_box(pcrtlang("Browse Assets/Customers"));

echo "<table style=\"width:100%\"><tr><td>";

echo "<a href=\"pc.php?func=addassetonly\" class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-user-plus fa-lg\"></i> ".pcrtlang("Add New Customer/Asset")."</a>";

echo "</td><td style=\"text-align:right\"><i class=\"fa fa-search fa-lg\"></i> <input type=text class=\"textbox\" id=searchbox placeholder=\"".pcrtlang("Enter Search Text")."\" value=\"$search\"></td></tr></table><br>";


echo "<div id=themain>";

echo "</div>";

?>
<script type="text/javascript">
$(document).ready(function () {
     $.get('customers.php?func=custlistajax&pageNumber=<?php echo $pageNumber; ?>&sortby=<?php echo $sortby; ?>&search=<?php echo $search_ue; ?>', function(data) {
     $('#themain').html(data);
     });
});
</script>


<script type="text/javascript">
$(document).ready(function(){
  var globalTimeoutrs = null;
  $("input#searchbox").keyup(function(){
                        if (globalTimeoutrs != null) {
                        clearTimeout(globalTimeoutrs);
                        }
                        var encodedinv = encodeURIComponent(this.value);
                        var searchlength = this.value.length;
                        globalTimeoutrs = setTimeout(function() {
                        globalTimeoutrs = null;
                                if(searchlength<3) {
                                        $('div#themain').load('customers.php?func=custlistajax&pageNumber=<?php echo $pageNumber; ?>&sortby=<?php echo $sortby; ?>').slideDown(200,function(){
                                        return false;
                                        });
                                }else{
                                        $('div#themain').load('customers.php?func=custlistajax&pageNumber=<?php echo $pageNumber; ?>&sortby=<?php echo $sortby; ?>&search='+encodedinv).slideDown(200);
                                }
                        }, 500);
  });
});
</script>


<?php

stop_blue_box();

require("footer.php");

}



function custlistajax() {

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




$results_per_page = 40;

if ($pageNumber == "") {
$offset = "0";
} else {
$offset = ($pageNumber * $results_per_page) - $results_per_page;
}

if (array_key_exists("search", $_REQUEST)) {
$search = $_REQUEST['search'];
if($search != "") {
$searchsql = "AND (pcname LIKE '%$search%' OR pcemail LIKE '%$search%' OR pcnotes LIKE '%$search%' OR pccompany LIKE '%$search%' OR pcworkphone LIKE '%$search%' OR pccellphone LIKE '%$search%' OR pcphone LIKE '%$search%' OR pcaddress LIKE '%$search%')";
} else {
$searchsql = "";
$search = "";
}
} else {
$searchsql = "";
$search = "";
}

$search_ue = urlencode($search);

require("deps.php");
require_once("common.php");


$rs_find_cart_items_total = "SELECT * FROM pc_owner WHERE 1 $searchsql";
$rs_result_total = mysqli_query($rs_connect, $rs_find_cart_items_total);

$totalentries = mysqli_num_rows($rs_result_total);
$lastpage = $totalentries / $results_per_page;
if($lastpage != floor($lastpage)) {
$lastpage = floor($lastpage) + 1;
}

if($pageNumber > $lastpage) {
$pageNumber = 1;
$offset = 0;
}




if ("$sortby" == "id_asc") {
$rs_find_cart_items = "SELECT * FROM pc_owner WHERE 1 $searchsql ORDER BY pcid ASC LIMIT $offset,$results_per_page";
} elseif ("$sortby" == "id_desc") {
$rs_find_cart_items = "SELECT * FROM pc_owner WHERE 1 $searchsql ORDER BY pcid DESC LIMIT $offset,$results_per_page";
} elseif ("$sortby" == "name_desc") {
$rs_find_cart_items = "SELECT * FROM pc_owner WHERE 1 $searchsql ORDER BY pcname DESC LIMIT $offset,$results_per_page";
} elseif ("$sortby" == "name_asc") {
$rs_find_cart_items = "SELECT * FROM pc_owner WHERE 1 $searchsql ORDER BY pcname ASC LIMIT $offset,$results_per_page";
} elseif ("$sortby" == "company_asc") {
$rs_find_cart_items = "SELECT * FROM pc_owner WHERE 1 $searchsql ORDER BY pccompany ASC LIMIT $offset,$results_per_page";
} else {
$rs_find_cart_items = "SELECT * FROM pc_owner WHERE 1 $searchsql ORDER BY pccompany DESC LIMIT $offset,$results_per_page";
}



$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);


echo "<table class=standard>";
echo "<tr><th>".pcrtlang("ID#");
echo "</th><th><a href=customers.php?pageNumber=$pageNumber&sortby=id_asc&search=$search_ue class=\"linkbuttontiny linkbuttongray radiustop\">
<i class=\"fa fa-chevron-up\"></i></a><br>";
echo "<a href=customers.php?pageNumber=$pageNumber&sortby=id_desc&search=$search_ue class=\"linkbuttontiny linkbuttongray radiusbottom\">
<i class=\"fa fa-chevron-down\"></i></a>";
echo "</th><th>".pcrtlang("Customer Name");
echo "</th><th><a href=customers.php?pageNumber=$pageNumber&sortby=name_asc&search=$search_ue class=\"linkbuttontiny linkbuttongray radiustop\">
<i class=\"fa fa-chevron-up\"></i></a><br>";
echo "<a href=customers.php?pageNumber=$pageNumber&sortby=name_desc&search=$search_ue class=\"linkbuttontiny linkbuttongray radiusbottom\">
<i class=\"fa fa-chevron-down\"></i></a>";
echo "</th>";

echo "<th>".pcrtlang("Company");
echo "</th><th><a href=customers.php?pageNumber=$pageNumber&sortby=company_asc&search=$search_ue class=\"linkbuttontiny linkbuttongray radiustop\">
<i class=\"fa fa-chevron-up\"></i></a><br>";
echo "<a href=customers.php?pageNumber=$pageNumber&sortby=company_desc&search=$search_ue class=\"linkbuttontiny linkbuttongray radiusbottom\">
<i class=\"fa fa-chevron-down\"></i></a>";
echo "</th>";

echo "<th>".pcrtlang("Customer Phone")."</th><th>".pcrtlang("Customer Email")."</th><th>".pcrtlang("Make/Model")."</th>";
echo "</tr>";

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


echo "<tr><td colspan=2><a href=pc.php?func=showpc&pcid=$pcid class=\"linkbuttonsmall linkbuttongray radiusall\">#$pcid</a></td>";
echo "<td colspan=2><a href=pc.php?func=showpc&pcid=$pcid class=\"linkbuttonsmall linkbuttongray radiusall\">$rs_pcname</a></td>";
echo "<td colspan=2>$rs_pccompany</td>";

if (($rs_prefcontact != "email") || ($rs_prefcontact != "none") || ($rs_prefcontact != "sms")) {
if($rs_prefcontact == "work") {
echo "<td>$rs_pcworkphone</td>";
} elseif ($rs_prefcontact == "mobile") {
echo "<td>$rs_pccellphone</td>";
} else {
echo "<td>$rs_pcphone</td>";
}
} else {
if($rs_pcphone != "") {
echo "<td>$rs_pcphone</td>";
} elseif ($rs_pcworkphone != "") {
echo "<td>$rs_pcworkphone</td>";
} else {
echo "<td>$rs_pccellphone</td>";
}
}

echo "<td>";

if($rs_pcemail != "") {
echo "<a href=\"mailto:$rs_pcemail\" class=\"linkbuttonsmall linkbuttongray radiusall\">$rs_pcemail</a>";
}

echo "</td>";

echo "<td>$rs_pcmake</td>";



echo "</tr>";

}

echo "</table>";

stop_blue_box();

echo "<br>";

echo "<center>";
#browse here

if($pageNumber != 1) {
$prevpage = $pageNumber - 1;
echo "<a href=customers.php?func=custlist&pageNumber=$prevpage&sortby=$sortby&search=$search_ue class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-left fa-lg\"></i></a> ";
}

$results_per_page = $results_per_page;
$html = get_paged_nav($totalentries, $results_per_page, false);
$html = str_replace("custlistajax", "custlist", "$html");
echo "$html";

if($lastpage != $pageNumber) {
$nextpage = $pageNumber + 1;
echo "<a href=customers.php?func=custlist&pageNumber=$nextpage&sortby=$sortby&search=$search_ue class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-right fa-lg\"></i></a>";
}

echo "</center>";


}



######

switch($func) {
                                                                                                    
    default:
    custlist();
    break;

    case "custlist":
    custlist();
    break;
                                
    case "custlistajax":
    custlistajax();
    break;


}

?>

