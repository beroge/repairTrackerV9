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

                                                                                                    
function nothing() {
require_once("header.php");


require_once("footer.php");
                                                                                                    
}


function runsreq() {

require_once("header.php");
require("deps.php");
require_once("common.php");


if (array_key_exists('showstore',$_REQUEST)) {
$showstore = $_REQUEST['showstore'];
} else {
$showstore = "$defaultuserstore";
}






echo "<br><h3>".pcrtlang("Service Requests")."</h3>";
echo pcrtlang("Show").":";
$rs_stores = "SELECT DISTINCT storeid, COUNT(storeid) AS thecount FROM servicerequests WHERE sreq_processed = '0' GROUP BY storeid";
$rs_find_stores = @mysqli_query($rs_connect, $rs_stores);
while($rs_find_stores_q = mysqli_fetch_object($rs_find_stores)) {
$srstore_id = "$rs_find_stores_q->storeid";
$thecount = "$rs_find_stores_q->thecount";

if($srstore_id != 0) {
$storeinfoarray = getstoreinfo($srstore_id);
} 

if($srstore_id == 0) {
if($srstore_id == $showstore) {
echo "($thecount) ".pcrtlang("Unassigned").":";
} else {
echo "<button type=button onClick=\"parent.location='servicerequests.php?func=runsreq&showstore=0'\">($thecount) ".pcrtlang("Unassigned")."</button>";
}
} else {
if($srstore_id == $showstore) {
echo "($thecount) $storeinfoarray[storesname]";
} else {
echo "<button type=button onClick=\"parent.location='servicerequests.php?func=runsreq&showstore=$srstore_id'\">($thecount) $storeinfoarray[storesname]</button>";
}
}
}

echo "<button type=button onClick=\"parent.location='servicerequests.php?func=sreqlist'\">".pcrtlang("Show Closed Requests")."</button>";

echo "<br>";

if($showstore == 0) {
echo "<h3>".pcrtlang("Unassigned")."</h3>";
} else {
$storeinfoarray2 = getstoreinfo($showstore);
echo "<h3>$storeinfoarray2[storesname]</h3>";
}

$rs_sr = "SELECT * FROM servicerequests WHERE sreq_processed = '0' AND storeid = '$showstore' ORDER BY sreq_datetime";
$rs_find_sr = @mysqli_query($rs_connect, $rs_sr);

while($rs_find_sr_q = mysqli_fetch_object($rs_find_sr)) {
$sreq_id = "$rs_find_sr_q->sreq_id";
$sreq_ip = "$rs_find_sr_q->sreq_ip";
$sreq_agent = "$rs_find_sr_q->sreq_agent";
$sreq_name = "$rs_find_sr_q->sreq_name";
$sreq_company = "$rs_find_sr_q->sreq_company";
$sreq_homephone = "$rs_find_sr_q->sreq_homephone";
$sreq_cellphone = "$rs_find_sr_q->sreq_cellphone";
$sreq_workphone = "$rs_find_sr_q->sreq_workphone";
$sreq_addy1 = "$rs_find_sr_q->sreq_addy1";
$sreq_addy2 = "$rs_find_sr_q->sreq_addy2";
$sreq_city = "$rs_find_sr_q->sreq_city";
$sreq_state = "$rs_find_sr_q->sreq_state";
$sreq_zip = "$rs_find_sr_q->sreq_zip";
$sreq_email = "$rs_find_sr_q->sreq_email";
$sreq_problem = "$rs_find_sr_q->sreq_problem";
$sreq_model = "$rs_find_sr_q->sreq_model";
$sreq_datetime = "$rs_find_sr_q->sreq_datetime";
$sreq_custsourceid = "$rs_find_sr_q->sreq_custsourceid";
$sreq_pcid = "$rs_find_sr_q->sreq_pcid";

$sreq_date2 = date("F j, Y, g:i a", strtotime($sreq_datetime));

$pcname = urlencode("$sreq_name");
$pccompany = urlencode("$sreq_company");
$pcphone = urlencode("$sreq_homephone");
$pcemail = urlencode("$sreq_email");
$pcaddress = urlencode("$sreq_addy1");
$pcaddress2 = urlencode("$sreq_addy2");
$pccity = urlencode("$sreq_city");
$pcstate = urlencode("$sreq_state");
$pczip = urlencode("$sreq_zip");
$pccellphone = urlencode("$sreq_cellphone");
$pcworkphone = urlencode("$sreq_workphone");
$pcproblem = urlencode("$sreq_problem");
$pcmake = urlencode("$sreq_model");

echo "<table class=standard><tr>";
echo "<th>$sreq_name";
if("$sreq_company" != "") {
echo "<br>$sreq_company";
}

echo "</th></tr>";

echo "<tr><td>$sreq_addy1<br>$sreq_addy2";
echo "<br>$sreq_city, $sreq_state $sreq_zip<br><br>H: $sreq_homephone";
echo "<br>M: $sreq_cellphone<br>W: $sreq_workphone";
echo "<br><br>$sreq_email</td></tr>";
echo "<tr><td>".pcrtlang("Make/Model").": $sreq_model</td></tr>";
echo "<tr><td>".pcrtlang("Problem").":<br>$sreq_problem</td></tr>";
echo "<tr><td>".pcrtlang("Submitted").": $sreq_date2</td></tr>";
echo "<tr><td>".pcrtlang("IP Address")."<br>$sreq_ip<br><br>".pcrtlang("Browser Agent").":</font><br>$sreq_agent";

if($sreq_custsourceid != "0") {
$rs_cssq = "SELECT * FROM custsource WHERE custsourceid = '$sreq_custsourceid'";
$rs_result1cs = mysqli_query($rs_connect, $rs_cssq);
while($rs_result_qcs1 = mysqli_fetch_object($rs_result1cs)) {
$thesource = "$rs_result_qcs1->thesource";
$sourceicon = "$rs_result_qcs1->sourceicon";

echo "<tr><td>".pcrtlang("Customer Source").": <img src=../repair/images/custsources/$sourceicon align=absmiddle> $thesource</td></tr>";
}
}


echo "<tr><td>";

echo "<div data-role=\"collapsible\">";
echo "<h3>".pcrtlang("Actions")."</h3>";

echo "<button type=button onClick=\"parent.location='pc.php?func=addpc&pcname=$pcname&pccompany=$pccompany&pcphone=$pcphone&pcemail=$pcemail&pcaddress=$pcaddress&pcaddress2=$pcaddress2&pccity=$pccity&pcstate=$pcstate&pczip=$pczip&pccellphone=$pccellphone&pcworkphone=$pcworkphone&pcproblem=$pcproblem&pcmake=$pcmake&sreq_id=$sreq_id&storeid=$showstore&custsourceid=$sreq_custsourceid'\"> <i class=\"fa fa-reply fa-lg\"></i> ".pcrtlang("Create New Work Order")."</button>";
echo "<button type=button onClick=\"parent.location='sticky.php?func=addsticky&stickyname=$pcname&stickycompany=$pccompany&stickyphone=$pcphone&stickyemail=$pcemail&stickyaddy1=$pcaddress&stickyaddy2=$pcaddress2&stickycity=$pccity&stickystate=$pcstate&stickyzip=$pczip&stickynote=$pcproblem&sreq_id=$sreq_id&storeid=$showstore'\"> <i class=\"fa fa-comment fa-lg\"></i> ".pcrtlang("Create Sticky")."</button>";
echo "<button type=button onClick=\"parent.location='servicerequests.php?func=proreq&sreq_id=$sreq_id&showstore=$showstore'\"> <i class=\"fa fa-check fa-lg\"></i> ".pcrtlang("Mark as Processed")."</button>";

echo "<a href=\"#popupdeletesr$sreq_id\" data-rel=\"popup\" data-position-to=\"window\" data-transition=\"pop\" class=\"ui-btn ui-shadow ui-corner-all\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete Request")."</a>";
echo "<div data-role=\"popup\" id=\"popupdeletesr$sreq_id\" data-overlay-theme=\"b\"  data-theme=\"a\" data-dismissible=\"false\">";
echo "<div data-role=\"header\" data-theme=\"b\">";
echo "<h1>".pcrtlang("Delete Request")."?</h1>";
echo "</div>";
echo "<div role=\"main\" class=\"ui-content\">";
echo "<p>".pcrtlang("Are you sure you wish to permanently delete this Service Request!!!?")."</p>";
echo "<div align=\"right\"><a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\" data-inline=\"true\">";
echo "<i class=\"fa fa-ban fa-lg\"></i> Cancel</a>";
echo "<button onClick=\"parent.location='servicerequests.php?func=delreq&sreq_id=$sreq_id&showstore=$showstore'\" data-inline=\"true\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")." </button></div>";
echo "</div>";
echo "</div>";



echo "</div>";
echo "</td></tr>";


if("$sreq_pcid" != 0) {
$pcid = "$sreq_pcid";
} else {
$pcid = "";
}


echo "<tr><td><form action=pc.php?func=returnpc2 method=POST  data-ajax=\"false\">";
echo pcrtlang("Returning PC ID").": <input type=text name=pcid value=\"$pcid\">";
echo "<input type=hidden name=merge_custname value=\"$sreq_name\">";
echo "<input type=hidden name=merge_custcompany value=\"$sreq_company\">";
echo "<input type=hidden name=merge_custphone value=\"$sreq_homephone\">";
echo "<input type=hidden name=merge_custemail value=\"$sreq_email\">";
echo "<input type=hidden name=merge_custworkphone value=\"$sreq_workphone\">";
echo "<input type=hidden name=merge_custcellphone value=\"$sreq_cellphone\">";
echo "<input type=hidden name=merge_custaddress1 value=\"$sreq_addy1\">";
echo "<input type=hidden name=merge_custaddress2 value=\"$sreq_addy2\">";
echo "<input type=hidden name=merge_custcity value=\"$sreq_city\">";
echo "<input type=hidden name=merge_custstate value=\"$sreq_state\">";
echo "<input type=hidden name=merge_custzip value=\"$sreq_zip\">";
echo "<input type=hidden name=merge_probdesc value=\"$sreq_problem\">";
echo "<input type=hidden name=merge_pcmake value=\"$sreq_model\">";
echo "<input type=hidden name=sreq_id value=\"$sreq_id\">";

echo "<input type=submit class=button value=\"".pcrtlang("Return Check-in")."\">";
echo "</form></td></tr>";


echo "<tr><td>";
echo "<form action=pc.php?func=searchreturnpcsreq method=POST  data-ajax=\"false\">";
echo pcrtlang("Return PC Search").": <input type=text name=searchterm>";
echo "<input type=hidden name=merge_custname value=\"$sreq_name\">";
echo "<input type=hidden name=merge_custcompany value=\"$sreq_company\">";
echo "<input type=hidden name=merge_custphone value=\"$sreq_homephone\">";
echo "<input type=hidden name=merge_custemail value=\"$sreq_email\">";
echo "<input type=hidden name=merge_custworkphone value=\"$sreq_workphone\">";
echo "<input type=hidden name=merge_custcellphone value=\"$sreq_cellphone\">";
echo "<input type=hidden name=merge_custaddress1 value=\"$sreq_addy1\">";
echo "<input type=hidden name=merge_custaddress2 value=\"$sreq_addy2\">";
echo "<input type=hidden name=merge_custcity value=\"$sreq_city\">";
echo "<input type=hidden name=merge_custstate value=\"$sreq_state\">";
echo "<input type=hidden name=merge_custzip value=\"$sreq_zip\">";
echo "<input type=hidden name=merge_probdesc value=\"$sreq_problem\">";
echo "<input type=hidden name=merge_pcmake value=\"$sreq_model\">";
echo "<input type=hidden name=sreq_id value=\"$sreq_id\">";

echo "<input type=submit class=button value=\"".pcrtlang("Search")."\">";
echo "</form></td></tr></table>";




echo "<br><br>";
}


require_once("footer.php");
}

function delreq() {
require_once("validate.php");

require("deps.php");
require("common.php");

$sreq_id = $_REQUEST['sreq_id'];
$showstore = $_REQUEST['showstore'];




$rs_insert_scan = "DELETE FROM servicerequests WHERE sreq_id = '$sreq_id'";
@mysqli_query($rs_connect, $rs_insert_scan);

if (!array_key_exists("returnurl", $_REQUEST)) {
header("Location: servicerequests.php?func=runsreq&showstore=$showstore");
} else {
$returnurl = $_REQUEST['returnurl'];
header("Location: $returnurl");
}


}

function proreq() {
require_once("validate.php");

require("deps.php");
require("common.php");

$sreq_id = $_REQUEST['sreq_id'];
$showstore = $_REQUEST['showstore'];




$rs_insert_scan = "UPDATE servicerequests SET sreq_processed = '1' WHERE sreq_id = '$sreq_id'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: servicerequests.php?func=runsreq&showstore=$showstore");

}

function sreqlist() {

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

$results_per_page = 20;

if ($pageNumber == "") {
$offset = "0";
} else {
$offset = ($pageNumber * $results_per_page) - $results_per_page;
}



require("deps.php");
require_once("common.php");




if ("$sortby" == "id_asc") {
$rs_find_sreq = "SELECT * FROM servicerequests WHERE sreq_processed = '1' ORDER BY sreq_id ASC LIMIT $offset,$results_per_page";
} elseif ("$sortby" == "id_desc") {
$rs_find_sreq = "SELECT * FROM servicerequests WHERE sreq_processed = '1' ORDER BY sreq_id DESC LIMIT $offset,$results_per_page";
} elseif ("$sortby" == "name_desc") {
$rs_find_sreq = "SELECT * FROM servicerequests WHERE sreq_processed = '1' ORDER BY sreq_name DESC LIMIT $offset,$results_per_page";
} else {
$rs_find_sreq = "SELECT * FROM servicerequests WHERE sreq_processed = '1' ORDER BY sreq_name ASC LIMIT $offset,$results_per_page";
}

$rs_result = mysqli_query($rs_connect, $rs_find_sreq);

$rs_find_sreq_total = "SELECT * FROM servicerequests";
$rs_result_total = mysqli_query($rs_connect, $rs_find_sreq_total);



echo "<h3>".pcrtlang("Browse Service Requests")."</h3>";


echo "<div data-role=\"collapsible\">";
echo "<h3>".pcrtlang("Sort By")."</h3>";

echo "<button type=button onClick=\"parent.location='servicerequests.php?func=sreqlist&pageNumber=$pageNumber&sortby=id_asc'\"><i class=\"fa fa-sort-numeric-asc fa-lg\"></i> ".pcrtlang("By ID")."</button>";
echo "<button type=button onClick=\"parent.location='servicerequests.php?func=sreqlist&pageNumber=$pageNumber&sortby=id_desc'\"><i class=\"fa fa-sort-numeric-desc fa-lg\"></i> ".pcrtlang("By ID")."</button>";
echo "<button type=button onClick=\"parent.location='servicerequests.php?func=sreqlist&pageNumber=$pageNumber&sortby=name_asc'\"><i class=\"fa fa-sort-alpha-asc fa-lg\"></i> ".pcrtlang("By Customer Name")."</button>";
echo "<button type=button onClick=\"parent.location='servicerequests.php?func=sreqlist&pageNumber=$pageNumber&sortby=name_desc'\"><i class=\"fa fa-sort-alpha-desc fa-lg\"></i> ".pcrtlang("By Customer Name")."</button>";
echo "</div>";


while($rs_result_q = mysqli_fetch_object($rs_result)) {
$sreq_id = "$rs_result_q->sreq_id";
$sreq_name = "$rs_result_q->sreq_name";
$sreq_company = "$rs_result_q->sreq_company";
$sreq_model = "$rs_result_q->sreq_model";
$sreq_problem = "$rs_result_q->sreq_problem";

if (strlen("$sreq_problem") > 200) {
$sreq_problem2 = substr("$sreq_problem", 0,200)."...";
} else {
$sreq_problem2 = $sreq_problem;
}

$returnurl = urlencode("servicerequests.php?func=sreqlist&pageNumber=$pageNumber&sortby=$sortby");

echo "<table class=standard><tr><th>";
echo "<button type=button onClick=\"parent.location='servicerequests.php?func=show_sreq&sreq_id=$sreq_id&returnurl=$returnurl'\">#$sreq_id $sreq_name</button>";

echo "</th></tr>";


if("$sreq_company" != "") {
echo "<tr><td>$sreq_company</td></tr>";
}


echo "<tr><td>$sreq_model</td></tr>";

echo "<tr><td>$sreq_problem2</td>";



echo "</tr></table><br><br>";

}



echo "<br>";

start_box();
#browse here
$totalentry = mysqli_num_rows($rs_result_total);
$prevpage = $pageNumber - 1;
$nextpage = $pageNumber + 1;

echo "<center>";

if ($pageNumber > 1) {
echo "<button type=button onClick=\"parent.location='servicerequests.php?func=sreqlist&pageNumber=$prevpage&sortby=$sortby'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\">";
echo "<i class=\"fa fa-chevron-right fa-lg\"></i></button>";
}

$total_results = $totalentry;
$results_per_page = $results_per_page;
$html = get_paged_nav($total_results, $results_per_page, false);
echo "$html";

if (($totalentry / $results_per_page) > $pageNumber) {
echo "<button type=button onClick=\"parent.location='servicerequests.php?func=sreqlist&&pageNumber=$nextpage&sortby=$sortby'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\">";
echo "<i class=\"fa fa-chevron-right fa-lg\"></i></button>";
}

echo "</center>";

require("footer.php");

}

function show_sreq() {

require_once("header.php");
require("deps.php");
require_once("common.php");

$sreq_id = $_REQUEST['sreq_id'];
$returnurl = $_REQUEST['returnurl'];





$rs_sr = "SELECT * FROM servicerequests WHERE sreq_id = '$sreq_id'";
$rs_find_sr = @mysqli_query($rs_connect, $rs_sr);

while($rs_find_sr_q = mysqli_fetch_object($rs_find_sr)) {
$sreq_id = "$rs_find_sr_q->sreq_id";
$sreq_ip = "$rs_find_sr_q->sreq_ip";
$sreq_agent = "$rs_find_sr_q->sreq_agent";
$sreq_name = "$rs_find_sr_q->sreq_name";
$sreq_company = "$rs_find_sr_q->sreq_company";
$sreq_homephone = "$rs_find_sr_q->sreq_homephone";
$sreq_cellphone = "$rs_find_sr_q->sreq_cellphone";
$sreq_workphone = "$rs_find_sr_q->sreq_workphone";
$sreq_addy1 = "$rs_find_sr_q->sreq_addy1";
$sreq_addy2 = "$rs_find_sr_q->sreq_addy2";
$sreq_city = "$rs_find_sr_q->sreq_city";
$sreq_state = "$rs_find_sr_q->sreq_state";
$sreq_zip = "$rs_find_sr_q->sreq_zip";
$sreq_email = "$rs_find_sr_q->sreq_email";
$sreq_problem = "$rs_find_sr_q->sreq_problem";
$sreq_model = "$rs_find_sr_q->sreq_model";
$sreq_datetime = "$rs_find_sr_q->sreq_datetime";
$sreq_storeid = "$rs_find_sr_q->storeid";
$sreq_pcid = "$rs_find_sr_q->sreq_pcid";
$sreq_custsourceid = "$rs_find_sr_q->sreq_custsourceid";

$sreq_date2 = date("F j, Y, g:i a", strtotime($sreq_datetime));

$pcname = urlencode("$sreq_name");
$pccompany = urlencode("$sreq_company");
$pcphone = urlencode("$sreq_homephone");
$pcemail = urlencode("$sreq_email");
$pcaddress = urlencode("$sreq_addy1");
$pcaddress2 = urlencode("$sreq_addy2");
$pccity = urlencode("$sreq_city");
$pcstate = urlencode("$sreq_state");
$pczip = urlencode("$sreq_zip");
$pccellphone = urlencode("$sreq_cellphone");
$pcworkphone = urlencode("$sreq_workphone");
$pcproblem = urlencode("$sreq_problem");
$pcmake = urlencode("$sreq_model");

echo "<table class=standard><tr>";
echo "<th>$sreq_name";
if("$sreq_company" != "") {
echo "<br>$sreq_company";
}

echo "</th></tr>";

echo "<tr><td>$sreq_addy1<br>$sreq_addy2";
echo "<br>$sreq_city, $sreq_state $sreq_zip<br><br>H: $sreq_homephone";
echo "<br>M: $sreq_cellphone<br>W: $sreq_workphone";
echo "<br><br>$sreq_email</td></tr>";
echo "<tr><td>".pcrtlang("Make/Model").": $sreq_model</td></tr>";
echo "<tr><td>".pcrtlang("Problem").":<br>$sreq_problem</td></tr>";
echo "<tr><td>".pcrtlang("Submitted").": $sreq_date2</td></tr>";
echo "<tr><td>".pcrtlang("IP Address")."<br>$sreq_ip<br><br>".pcrtlang("Browser Agent").":</font><br>$sreq_agent";
if($sreq_custsourceid != "0") {
$rs_cssq = "SELECT * FROM custsource WHERE custsourceid = '$sreq_custsourceid'";
$rs_result1cs = mysqli_query($rs_connect, $rs_cssq);
while($rs_result_qcs1 = mysqli_fetch_object($rs_result1cs)) {
$thesource = "$rs_result_qcs1->thesource";
$sourceicon = "$rs_result_qcs1->sourceicon";

echo "<tr><td>".pcrtlang("Customer Source").": <img src=../repair/images/custsources/$sourceicon align=absmiddle> $thesource</td></tr>";
}
}


echo "<tr><td>";

echo "<div data-role=\"collapsible\">";
echo "<h3>".pcrtlang("Actions")."</h3>";
echo "<button type=button onClick=\"parent.location='pc.php?func=addpc&pcname=$pcname&pccompany=$pccompany&pcphone=$pcphone&pcemail=$pcemail&pcaddress=$pcaddress&pcaddress2=$pcaddress2&pccity=$pccity&pcstate=$pcstate&pczip=$pczip&pccellphone=$pccellphone&pcworkphone=$pcworkphone&pcproblem=$pcproblem&pcmake=$pcmake&sreq_id=$sreq_id&custsourceid=$sreq_custsourceid'\"> <i class=\"fa fa-reply fa-lg\"></i> ".pcrtlang("Create New Work Order")."</button>";
echo "<button type=button onClick=\"parent.location='sticky.php?func=addsticky&stickyname=$pcname&stickycompany=$pccompany&stickyphone=$pcphone&stickyemail=$pcemail&stickyaddy1=$pcaddress&stickyaddy2=$pcaddress2&stickycity=$pccity&stickystate=$pcstate&stickyzip=$pczip&stickynote=$pcproblem&sreq_id=$sreq_id'\"> <i class=\"fa fa-comment fa-lg\"></i> ".pcrtlang("Create Sticky")."</button>";

echo "<a href=\"#popupdeletesr$sreq_id\" data-rel=\"popup\" data-position-to=\"window\" data-transition=\"pop\" class=\"ui-btn ui-shadow ui-corner-all\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete Request")."</a>";
echo "<div data-role=\"popup\" id=\"popupdeletesr$sreq_id\" data-overlay-theme=\"b\"  data-theme=\"a\" data-dismissible=\"false\">";
echo "<div data-role=\"header\" data-theme=\"b\">";
echo "<h1>".pcrtlang("Delete Request")."?</h1>";
echo "</div>";
echo "<div role=\"main\" class=\"ui-content\">";
echo "<p>".pcrtlang("Are you sure you wish to permanently delete this Service Request!!!?")."</p>";
echo "<div align=\"right\"><a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\" data-inline=\"true\">";
echo "<button onClick=\"parent.location='servicerequests.php?func=delreq&sreq_id=$sreq_id&showstore=$showstore'\" data-inline=\"true\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")." </button></div>";
echo "</div>";
echo "</div>";



echo "</div>";
echo "</td></tr>";


if("$sreq_pcid" != 0) {
$pcid = "$sreq_pcid";
} else {
$pcid = "";
}


echo "<tr><td><form action=pc.php?func=returnpc2 method=POST  data-ajax=\"false\">";
echo pcrtlang("Returning PC ID").": <input type=text name=pcid value=\"$pcid\">";
echo "<input type=hidden name=merge_custname value=\"$sreq_name\">";
echo "<input type=hidden name=merge_custcompany value=\"$sreq_company\">";
echo "<input type=hidden name=merge_custphone value=\"$sreq_homephone\">";
echo "<input type=hidden name=merge_custemail value=\"$sreq_email\">";
echo "<input type=hidden name=merge_custworkphone value=\"$sreq_workphone\">";
echo "<input type=hidden name=merge_custcellphone value=\"$sreq_cellphone\">";
echo "<input type=hidden name=merge_custaddress1 value=\"$sreq_addy1\">";
echo "<input type=hidden name=merge_custaddress2 value=\"$sreq_addy2\">";
echo "<input type=hidden name=merge_custcity value=\"$sreq_city\">";
echo "<input type=hidden name=merge_custstate value=\"$sreq_state\">";
echo "<input type=hidden name=merge_custzip value=\"$sreq_zip\">";
echo "<input type=hidden name=merge_probdesc value=\"$sreq_problem\">";
echo "<input type=hidden name=merge_pcmake value=\"$sreq_model\">";
echo "<input type=hidden name=sreq_id value=\"$sreq_id\">";

echo "<input type=submit class=button value=\"".pcrtlang("Return Check-in")."\">";
echo "</form></td></tr>";


echo "<tr><td>";
echo "<form action=pc.php?func=searchreturnpcsreq method=POST  data-ajax=\"false\">";
echo pcrtlang("Return PC Search").": <input type=text name=searchterm>";
echo "<input type=hidden name=merge_custname value=\"$sreq_name\">";
echo "<input type=hidden name=merge_custcompany value=\"$sreq_company\">";
echo "<input type=hidden name=merge_custphone value=\"$sreq_homephone\">";
echo "<input type=hidden name=merge_custemail value=\"$sreq_email\">";
echo "<input type=hidden name=merge_custworkphone value=\"$sreq_workphone\">";
echo "<input type=hidden name=merge_custcellphone value=\"$sreq_cellphone\">";
echo "<input type=hidden name=merge_custaddress1 value=\"$sreq_addy1\">";
echo "<input type=hidden name=merge_custaddress2 value=\"$sreq_addy2\">";
echo "<input type=hidden name=merge_custcity value=\"$sreq_city\">";
echo "<input type=hidden name=merge_custstate value=\"$sreq_state\">";
echo "<input type=hidden name=merge_custzip value=\"$sreq_zip\">";
echo "<input type=hidden name=merge_probdesc value=\"$sreq_problem\">";
echo "<input type=hidden name=merge_pcmake value=\"$sreq_model\">";
echo "<input type=hidden name=sreq_id value=\"$sreq_id\">";

echo "<input type=submit class=button value=\"".pcrtlang("Search")."\">";
echo "</form></td></tr></table>";


echo "<br><br>";
}


require_once("footer.php");
}



switch($func) {
                                                                                                    
    default:
    nothing();
    break;
                                
  case "runsreq":
    runsreq();
    break;

  case "delreq":
    delreq();
    break;

  case "proreq":
    proreq();
    break;

  case "sreqlist":
    sreqlist();
    break;

  case "show_sreq":
    show_sreq();
    break;


}

?>
