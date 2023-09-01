<?php

/***************************************************************************
 *   copyright            : (C) 2019 PCRepairTracker.com
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


function reportlist() {
require_once("header.php");


$storereportoptions = "";
if ($activestorecount > 1) {
$rs_find_stores = "SELECT * FROM stores WHERE storeenabled = '1' ORDER BY storesname ASC";
$rs_result_stores = mysqli_query($rs_connect, $rs_find_stores);
$storereportoptions .= "<font class=text12b>".pcrtlang("Store").":</font> ";
$storereportoptions .= "<select name=reportstoreid>";
while($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
$rs_storesname = "$rs_result_storeq->storesname";
$rs_storeid = "$rs_result_storeq->storeid";
if ($rs_storeid == $defaultuserstore) {
$storereportoptions .= "<option selected value=$rs_storeid>$rs_storesname</option>";
} else {
$storereportoptions .= "<option value=$rs_storeid>$rs_storesname</option>";
}
}
$storereportoptions .= "<option value=all>".pcrtlang("All Stores")."</option>";
$storereportoptions .= "</select><br>";
} else {
$storereportoptions = "<input type=hidden name=reportstoreid value=\"$defaultuserstore\">";
}

$thedate = date("Y-m-d");

if(!isset($pcrt_weekstart)) {
$pcrt_weekstart = "Sunday";
}
if ($pcrt_weekstart == "Sunday") {
$thedate2 = date("Y-m-d",strtotime("last Sunday"));
} else {
$thedate2 = date("Y-m-d",strtotime("last Monday"));
}


     
echo "<div data-role=\"collapsible\" data-theme=\"b\">";
echo "<h3>".pcrtlang("Sales Reports")."</h3>";

if (perm_check("25")) {
echo "<br><button type=button onClick=\"parent.location='reports.php?func=browse_receipts'\">".pcrtlang("Browse Receipts")."</button><br><br>";
}

if (perm_check("26")) {
echo "<form action=reports.php?func=day_report method=post  data-ajax=\"false\"><h3>".pcrtlang("Day Report")."</h3>".pcrtlang("Enter Date").":";
echo "<input id=day type=date name=day value=\"$thedate\">";


echo "<input type=submit value=\"".pcrtlang("Show Report")."\"></form>";
echo "<br>";
}

if (perm_check("5")) {



echo "<form action=reports.php?func=day_span_report method=post data-ajax=\"false\"><h3>".pcrtlang("Day Range Sales Report")."</h3>";


echo $storereportoptions;

echo pcrtlang("Enter From Date").":<input id=drrfrom type=date name=dayfrom value=\"$thedate2\">";


echo pcrtlang("Enter To Date").":<input id=drrto type=date name=dayto value=\"$thedate\">";


echo "<input class=button type=submit value=\"".pcrtlang("Show Report")."\"></form>";
echo "<br>";


echo "<form action=reports.php?func=day_span_payments_report method=post data-ajax=\"false\"><h3>".pcrtlang("Day Range Payment Report")."&nbsp;</h3>";
$storereportoptions = "";
if ($activestorecount > 1) {
$rs_find_stores = "SELECT * FROM stores WHERE storeenabled = '1' ORDER BY storesname ASC";
$rs_result_stores = mysqli_query($rs_connect, $rs_find_stores);
$storereportoptions .= "<font class=text12b>".pcrtlang("Store").":</font> ";
$storereportoptions .= "<select name=reportstoreid>";
while($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
$rs_storesname = "$rs_result_storeq->storesname";
$rs_storeid = "$rs_result_storeq->storeid";
if ($rs_storeid == $defaultuserstore) {
$storereportoptions .= "<option selected value=$rs_storeid>$rs_storesname</option>";
} else {
$storereportoptions .= "<option value=$rs_storeid>$rs_storesname</option>";
}
}
$storereportoptions .= "<option value=all>".pcrtlang("All Stores")."</option>";
$storereportoptions .= "</select><br>";
} else {
$storereportoptions = "<input type=hidden name=reportstoreid value=\"$defaultuserstore\">";
}

echo $storereportoptions;

echo pcrtlang("Enter From Date").":<input id=drrpfrom type=date name=dayfrom value=\"$thedate2\">";


echo pcrtlang("Enter To Date").":<input id=drrpto type=date name=dayto value=\"$thedate\">";



echo "<input type=submit value=\"".pcrtlang("Show Report")."\"></form>";
echo "<br>";



$theyear = date("Y");

echo "<form action=reports.php?func=monthly_payments_report method=post data-ajax=\"false\"><h3>".pcrtlang("Monthly Payment Report")."</h3>";

echo $storereportoptions;

echo pcrtlang("Enter Year").":<input type=number name=year value=\"$theyear\">";
echo "<input type=submit value=\"".pcrtlang("Show Report")."\"></form>";
echo "<br>";



echo "<form action=reports.php?func=month_report method=post data-ajax=\"false\"><h3>".pcrtlang("Monthly Sales Report")."&nbsp;</h3>";

echo $storereportoptions;

echo pcrtlang("Enter Year").":<input type=number name=year value=\"$theyear\">";
echo "<input type=submit value=\"".pcrtlang("Show Report")."\"></form>";
echo "<br>";

echo "<form action=reports.php?func=quarter_report method=post data-ajax=\"false\"><h3>".pcrtlang("Quarterly Sales Report")."</h3><br><br>";
echo $storereportoptions;
echo pcrtlang("Enter Year").":<input type=number name=year value=\"$theyear\">";
echo "<input type=submit value=\"".pcrtlang("Show Report")."\"></form>";
echo "<br>";

echo "<form action=reports.php?func=year_report method=post data-ajax=\"false\"><h3>".pcrtlang("Yearly Sales Report")."</h3>";
echo $storereportoptions;
echo pcrtlang("Enter Year").":</font><input type=number name=year value=\"$theyear\">";
echo "<input type=submit value=\"".pcrtlang("Show Report")."\"></form>";
echo "<br>";

echo "<!--<form action=reports.php?func=taxreportnew method=post data-ajax=\"false\"><h3>".pcrtlang("Show Sales/Service Tax Reports")."</h3>";
echo pcrtlang("Enter Year").":</font><input type=number name=year value=\"$theyear\">";
echo "<input type=submit value=\"".pcrtlang("Show Report")."\"></form>";
echo "<br>";

$theyear2 = $theyear - 1;
echo "<form action=reports.php?func=taxreportnew&fiscaldate=1 method=post data-ajax=\"false\"><h3>".pcrtlang("Show Fiscal Year Sales/Service Tax Report")."</h3>";
echo "<br><br>";
echo pcrtlang("Enter Start Year").":<input type=number name=year value=\"$theyear2\"><br>";
echo pcrtlang("Enter Start Month").":<input type=number name=month value=\"08\" min=1 max=12>";
echo "<input type=submit value=\"".pcrtlang("Show Report")."\"></form>";
echo "<br>-->";


}

echo "</div>";

echo "<br><br>";

echo "<div data-role=\"collapsible\" data-theme=\"b\">";
echo "<h3>".pcrtlang("Inventory Reports")."</h3>";

echo "<button type=button onClick=\"parent.location='reports.php?func=browse_sold'\">".pcrtlang("Browse Sold Items")."</button>";
echo "<button type=button onClick=\"parent.location='reports.php?func=browse_outofstock'\">".pcrtlang("Browse Out of Stock Items")."</button>";



if (perm_check("6")) {


if ($activestorecount > 1) {
echo "<h3>".pcrtlang("Managed Stock Report").": </h3>";
echo "<button type=button onClick=\"parent.location='reports.php?func=managedstockreports&what=all'\">".pcrtlang("All Stores")."</button>";
echo "<button type=button onClick=\"parent.location='reports.php?func=managedstockreports&what=store'\">".pcrtlang("Current Store")."</button>";
} else {
echo "<button type=button onClick=\"parent.location='reports.php?func=managedstockreports&what=all'\">".pcrtlang("Managed Stock Report")."</button>";
}


echo "<button type=button onClick=\"parent.location='inv.php'\">".pcrtlang("Printable Inventory (last stocked price valuation)")."</button>";
echo "<button type=button onClick=\"parent.location='inv_avg.php'\">".pcrtlang("Printable Inventory (average cost price valuation)")."</button>";


echo "<form action=reports.php?func=searchnii method=post data-ajax=\"false\"><h3>".pcrtlang("Search for Sold Non-Inv Items")."<h3>";
echo pcrtlang("Enter Search Term").":<input type=text name=thesearch>";
echo "<input type=submit value=\"".pcrtlang("Search")."\"></form>";
echo "<br>";


echo "<form action=reports.php?func=day_span_nii&printable=no method=post data-ajax=\"false\"><h3>".pcrtlang("Day Range Non-Inv Item Report")."</h3>";
$storereportoptions = "";
if ($activestorecount > 1) {
$rs_find_stores = "SELECT * FROM stores WHERE storeenabled = '1' ORDER BY storesname ASC";
$rs_result_stores = mysqli_query($rs_connect, $rs_find_stores);
$storereportoptions .= "<font class=text12b>".pcrtlang("Store").":</font> ";
$storereportoptions .= "<select name=reportstoreid>";
while($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
$rs_storesname = "$rs_result_storeq->storesname";
$rs_storeid = "$rs_result_storeq->storeid";
if ($rs_storeid == $defaultuserstore) {
$storereportoptions .= "<option selected value=$rs_storeid>$rs_storesname</option>";
} else {
$storereportoptions .= "<option value=$rs_storeid>$rs_storesname</option>";
}
}
$storereportoptions .= "<option value=all>".pcrtlang("All Stores")."</option>";
$storereportoptions .= "</select><br>";
} else {
$storereportoptions = "<input type=hidden name=reportstoreid value=\"$defaultuserstore\">";
}

echo $storereportoptions;

echo pcrtlang("Enter From Date").":<input id=niisfrom type=date name=dayfrom value=\"$thedate2\">";

echo pcrtlang("Enter To Date").":<input id=niisto type=date name=dayto value=\"$thedate\">";


echo "<input type=submit value=\"".pcrtlang("Show Report")."\"></form>";
echo "<br>";



}


echo "</div>";

echo "<br><br>";

echo "<div data-role=\"collapsible\" data-theme=\"b\">";
echo "<h3>".pcrtlang("Repair Reports")."</h3>";


echo "<br><button type=button onClick=\"parent.location='reports.php?func=repair_vol'\">".pcrtlang("Repair Volume")."</button>";
#echo "<button type=button onClick=\"parent.location='../repairmobile/repairreports.php?func=dailystatus'\">".pcrtlang("Current Repair Status Report")."</button>";
echo "<button type=button onClick=\"parent.location='../repairmobile/pc.php?func=stats'\">".pcrtlang("Repair Stats by PC Manufacturer")."</button>";
echo "<button type=button onClick=\"parent.location='../repairmobile/servicerequests.php?func=sreqlist'\">".pcrtlang("Browse Closed Service Requests")."</button><br>";

if (perm_check("7")) {

$thedate = date("Y-m-d");
$thedate2 = date("Y-m-d",strtotime("last Sunday"));

echo "<form action=reports.php?func=dailycalllog method=post data-ajax=\"false\"><h3>".pcrtlang("SMS/Call Log")."</h3>";
echo pcrtlang("Enter Date").":";
echo "<input id=calllog type=date name=day value=\"$thedate\">";

echo "<input type=submit value=\"".pcrtlang("Show Report")."\"></form>";
echo "<br>";



echo "<form action=reports.php?func=user_act_report method=post data-ajax=\"false\"><h3>".pcrtlang("Technician Activity Report")."</h3>";
echo pcrtlang("Enter From Date").": <input id=tarfrom type=date name=dayfrom value=\"$thedate2\">";


echo "<br>".pcrtlang("Enter To Date").": <input id=tarto type=date name=dayto value=\"$thedate\">";


echo "<input type=submit value=\"".pcrtlang("Show Report")."\"></form>";
echo "<br>";



echo "<form action=reports.php?func=user_log_report method=post data-ajax=\"false\"><h3>".pcrtlang("Daily Technician Report")."</h3>";
echo pcrtlang("Enter Date").": <input id=dtrdate type=date name=day value=\"$thedate\"><br>";


echo pcrtlang("Choose User").": <select name=theuser>";
$rs_find_users = "SELECT * FROM users WHERE username != 'admin'";
$rs_result_users = mysqli_query($rs_connect, $rs_find_users);
while($rs_result_users_q = mysqli_fetch_object($rs_result_users)) {
$theuser = "$rs_result_users_q->username";
echo "<option value=\"$theuser\">$theuser</option>";
}
echo "</select>";
echo "<input type=submit value=\"".pcrtlang("Show Report")."\"></form><br>";


$thedate = date("Y-m-d");
$thedate2 = date("Y-m-d",strtotime("last Sunday"));
echo "<form action=reports.php?func=tech_day_span_report method=post data-ajax=\"false\"><h3>".pcrtlang("Tech Sales/Invoice/Work Order Report")."</h3>";

echo pcrtlang("Choose User").": <select name=thetech>";
$rs_find_users = "SELECT * FROM users WHERE username != 'admin'";
$rs_result_users = mysqli_query($rs_connect, $rs_find_users);
while($rs_result_users_q = mysqli_fetch_object($rs_result_users)) {
$theuser = "$rs_result_users_q->username";
echo "<option value=\"$theuser\">$theuser</option>";
}
echo "</select><br>";


echo $storereportoptions;

echo pcrtlang("Enter From Date").": <input id=tsrfrom type=date name=dayfrom value=\"$thedate2\">";


echo "<br>".pcrtlang("Enter To Date").": <input id=tsrto type=date name=dayto value=\"$thedate\">";


echo "<input type=submit value=\"".pcrtlang("Show Report")."\"></form>";
echo "<br>";

echo "<form action=reports.php?func=mileage_report method=post data-ajax=\"false\"><h3>".pcrtlang("Tech Mileage Report")."</h3>";

echo "<font class=text12b>".pcrtlang("Choose User").":</font><select name=thetech>";
echo "<option value=\"all\">".pcrtlang("All Users")."</option>";
$rs_find_users = "SELECT * FROM users WHERE username != 'admin'";
$rs_result_users = mysqli_query($rs_connect, $rs_find_users);
while($rs_result_users_q = mysqli_fetch_object($rs_result_users)) {
$theuser = "$rs_result_users_q->username";
echo "<option value=\"$theuser\">$theuser</option>";
}
echo "</select><br>";

echo pcrtlang("Enter From Date").": <input id=mrfrom type=date name=dayfrom value=\"$thedate2\">";


echo "<br>".pcrtlang("Enter To Date").": <input id=mrto type=date name=dayto value=\"$thedate\">";


echo "<input type=submit value=\"".pcrtlang("Show Report")."\"></form>";
echo "<br>";






}





echo "</div>";

echo "<br><br>";

echo "<div data-role=\"collapsible\" data-theme=\"b\">";
echo "<h3>".pcrtlang("Marketing Reports")."</h3>";


if (perm_check("9")) {

$thedate = date("Y-m-d");
$thedate2 = date("Y-m-d",strtotime("-3 months"));
echo "<form action=reports.php?func=customer_source_report method=post data-ajax=\"false\"><br><font class=text16bu>".pcrtlang("Customer Source Report")."&nbsp;</font><br><br>";
echo "<font class=text12b>".pcrtlang("Enter From Date").":</font><input id=mrfrom type=date name=dayfrom value=\"$thedate2\">";


echo "<br><font class=text12b>".pcrtlang("Enter To Date").":</font>&nbsp;&nbsp;&nbsp;&nbsp;<input id=mrto type=date name=dayto value=\"$thedate\">";


echo "<input class=button type=submit value=\"".pcrtlang("Show Report")."\"></form>";
echo "<br><br>";

}


if (perm_check("10")) {
echo "<button type=button onClick=\"parent.location='reports.php?func=emaillist'\"><i class=\"fa fa-envelope fa-lg\"></i> ".pcrtlang("Show Customer Email List")."</button>";
echo "<button type=button onClick=\"parent.location='reports.php?func=customers_csv'\"><i class=\"fa fa-database fa-lg\"></i> ".pcrtlang("Download CSV PC/Customer List")."</button>";
echo "<button type=button onClick=\"parent.location='reports.php?func=groupcustomers_csv'\"><i class=\"fa fa-database fa-lg\"></i> ".pcrtlang("Download CSV Customer Group List")."</button>";
}

echo "</div>";

                                                                                                                        
require_once("footer.php");
                                                                                                                             
}
                                                                                                    
                                                                                                    
function browse_receipts() {

if (array_key_exists("pageNumber", $_REQUEST)) {
$pageNumber = $_REQUEST['pageNumber'];
} else {
$pageNumber = 1;
}


require_once("header.php");
require_once("common.php");

perm_boot("25");

$results_per_page = 40;

if ($pageNumber == "") {
$offset = "0";
} else {
$offset = ($pageNumber * $results_per_page) - $results_per_page;
}



require("deps.php");




$rs_find_cart_items = "SELECT * FROM receipts ORDER BY date_sold DESC LIMIT $offset,$results_per_page";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

$rs_find_cart_items_total = "SELECT * FROM receipts";
$rs_result_total = mysqli_query($rs_connect, $rs_find_cart_items_total);



echo "<center><h3>".pcrtlang("Browse Receipts")."</h3></center>";
echo "<form action=\"receipt.php?func=show_receipt_printable\" method=POST data-ajax=\"false\"  data-ajax=\"false\">";



while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_receipt_id = "$rs_result_q->receipt_id";
$rs_pay_type = "$rs_result_q->pay_type";
$rs_name = "$rs_result_q->person_name";
$rs_company = "$rs_result_q->company";
$rs_pay_type = "$rs_result_q->pay_type";
$rs_checkno = "$rs_result_q->check_number";
$rs_gt = "$rs_result_q->grandtotal";
$rs_date = "$rs_result_q->date_sold";
$rs_tax = "$rs_result_q->grandtax";
$rs_taxex = "$rs_result_q->taxex";
$rs_storeid = "$rs_result_q->storeid";

echo "<table class=standard><tr>";
echo "<th><label><input type=checkbox name=receipt[] value=\"$rs_receipt_id\" >";
echo " $rs_name</label></th></tr>";

if("$rs_company" != "") {
echo "<tr><td>$rs_company</td></tr>";
}


if ($activestorecount >	1) {
$storeinfoarray = getstoreinfo($rs_storeid);
echo "<tr><td>".pcrtlang("Store").": $storeinfoarray[storesname]</td></tr>";
}


$rs_date2 = pcrtdate("$pcrt_time", "$rs_date")." ".pcrtdate("$pcrt_shortdate", "$rs_date");
echo "<tr><td>".pcrtlang("Date").": $rs_date2</td></tr>";

$chkemailrecsql = "SELECT * FROM userlog WHERE reftype = 'receiptid' AND refid = '$rs_receipt_id' AND actionid = '27'";
$chkemailrec = mysqli_num_rows(mysqli_query($rs_connect, $chkemailrecsql));


echo "<tr><td>".pcrtlang("Emailed?");
if ($chkemailrec >= 1) {
echo " <i class=\"fa fa-thumbs-up fa-lg\"></i>";
} else {
echo " <i class=\"fa fa-thumbs-down fa-lg\"></i>";
}
echo "</td></tr>";


if ($rs_gt < 0) {
echo "<tr><td>$money".mf("$rs_gt")."</td></tr>";
} else {
echo "<tr><td>$money".mf("$rs_gt")."</td></tr>";
}

echo "<tr><td><button type=button onClick=\"parent.location='receipt.php?func=show_receipt&receipt=$rs_receipt_id'\">".pcrtlang("Receipt")."# $rs_receipt_id</button></td></tr>";


echo "</table><br>";

}

echo "<br>";

#browse here
$totalentry = mysqli_num_rows($rs_result_total);
$prevpage = $pageNumber - 1;
$nextpage = $pageNumber + 1;

echo "<center>";

if ($pageNumber > 1) {
echo "<button type=button onClick=\"parent.location='reports.php?func=browse_receipts&pageNumber=$prevpage'\"  class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\">";
echo "<i class=\"fa fa-chevron-left fa-lg\"></i></button>";
}

$total_results = $totalentry;
$results_per_page = $results_per_page;
$html = get_paged_nav($total_results, $results_per_page, false);
echo "$html";

if (($totalentry / $results_per_page) > $pageNumber) {
echo "<button type=button onClick=\"parent.location='reports.php?func=browse_receipts&pageNumber=$nextpage'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\">";
echo "<i class=\"fa fa-chevron-right fa-lg\"></i></button>";
}

echo "</center>";

echo "<br><br>";
echo "<font class=text12b>".pcrtlang("Print Multiple Receipts").":</font>&nbsp;&nbsp;";
echo "<input type=submit class=button value=\"".pcrtlang("Print")."\"><font class=text10i>".pcrtlang("Select the checkboxes above to choose which receipts to print").".</font></form>";
echo "<br>";


echo "<table class=standard><tr><th>".pcrtlang("Print Range of Receipts")."</th></tr><tr><td><form action=\"receipt.php?func=printmultireceipts\" method=post data-ajax=\"false\"  data-ajax=\"false\">";
echo pcrtlang("From Receipt Number").":<input type=text name=recfrom>".pcrtlang("To Receipt Number").":";
echo "<input type=text name=recto><input type=submit value=\"".pcrtlang("Print")."\"></form></td></tr></table>";
echo "<br><br>";



require("footer.php");

}





function day_report() {


if (array_key_exists('day',$_REQUEST)) {
if ($_REQUEST['day'] != "") {
$day = $_REQUEST['day'];
} else {
$day = date("Y-m-d");
}
} else {
$day = date("Y-m-d");
}

if (array_key_exists('usertoshow',$_REQUEST)) {
if ($_REQUEST['usertoshow'] != "") {
$usertoshow = $_REQUEST['usertoshow'];
} else {
$usertoshow = "all";
}
} else {
$usertoshow = "all";
}


require_once("header.php");
perm_boot("26");

$plusday = date("Y-m-d", (strtotime("$day") + 86400));                 
$minusday = date("Y-m-d", (strtotime("$day") - 86400));


if (array_key_exists('storetoshow',$_REQUEST)) {
if ($_REQUEST['storetoshow'] != "") {
$storetoshow = $_REQUEST['storetoshow'];
} else {
$storetoshow = "default";
}
} else {
$storetoshow = "default";
}

if(($storetoshow == "all") && (!perm_check("5"))) {
$storetoshow = "default";
}


if ($activestorecount > 1) {
$storeinfoarray = getstoreinfo($defaultuserstore);
if($storetoshow == "default") {
echo "<h3>".pcrtlang("Store").": $storeinfoarray[storesname]</h3>";
} else {
echo "<h3>".pcrtlang("Store").": ".pcrtlang("All Stores")."</h3>";
}
}



echo "<form action=reports.php?func=day_report&day=$day method=post data-ajax=\"false\">";
echo pcrtlang("User").": <select name=usertoshow onchange='this.form.submit()'>";
if ("$usertoshow" == "all") {
echo "<option value=\"all\" selected>All</option>";
} else {
echo "<option value=\"all\">All</option>";
}


$rs_find_users = "SELECT * FROM users";
$rs_result_users = mysqli_query($rs_connect, $rs_find_users);
while($rs_result_users_q = mysqli_fetch_object($rs_result_users)) {
$theusersw = "$rs_result_users_q->username";
if ("$usertoshow" == "$theusersw") {
echo "<option value=\"$theusersw\" selected>$theusersw</option>";
} else {
echo "<option value=\"$theusersw\">$theusersw</option>";
}

}
echo "</select></form>";


if(perm_check("5")) {
if($storetoshow == "default") {
echo "<button type=button onClick=\"parent.location='reports.php?func=day_report&day=$day&storetoshow=all'\">".pcrtlang("Show All Stores")."</button><br><br>";
} else {
$storeinfoarray = getstoreinfo($defaultuserstore);
echo "<button type=button onClick=\"parent.location='reports.php?func=day_report&day=$day&storetoshow=default'\">".pcrtlang("Show Store").": $storeinfoarray[storesname]</button><br><br>";
}
}


echo "<center>";
echo "<button type=button onClick=\"parent.location='reports.php?func=day_report&day=$minusday&storetoshow=$storetoshow'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"><i class=\"fa fa-chevron-left fa-lg\"></i></button> ".pcrtlang("Report for")." $day &nbsp;<button type=button onClick=\"parent.location='reports.php?func=day_report&day=$plusday&storetoshow=$storetoshow'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"><i class=\"fa fa-chevron-right fa-lg\"></i></button>";
echo "</center>";



echo "<table class=standard>";                                                                      
require("deps.php");




$pluginstotal = 0;
$pluginstotala = 0;
$pluginstotalb = 0;
$paymentarray = array();

if($storetoshow != "all") {
$storesql = " AND savedpayments.storeid = '$defaultuserstore' ";
} else {
$storesql = "";
}

reset($paymentplugins);
foreach($paymentplugins as $key => $plugin) {
if($usertoshow == "all") {
$rs_find_plugins = "SELECT SUM(amount) AS totalcash FROM savedpayments WHERE paymentdate LIKE '$day%' AND paymentplugin = '$plugin' $storesql";
} else {
$rs_find_plugins = "SELECT SUM(amount) AS totalcash FROM savedpayments, receipts WHERE savedpayments.paymentdate LIKE '$day%' AND savedpayments.paymentplugin = '$plugin' $storesql AND receipts.byuser = '$usertoshow' AND savedpayments.receipt_id = receipts.receipt_id";
}

$rs_result_plugin = mysqli_query($rs_connect, $rs_find_plugins);
while($rs_result_plugin_q = mysqli_fetch_object($rs_result_plugin)) {
$rs_totalcash = "$rs_result_plugin_q->totalcash";
if ($rs_totalcash != '') {
$cash = $rs_totalcash;
} else {
$cash = "0.00";
}

if (array_key_exists('$plugin',$paymentarray)) {
$paymentarray[$plugin]['totals'] = $paymentarray[$plugin]['totals'] + $cash;
} else {
$paymentarray[$plugin]['totals'] = $cash;
$paymentarray[$plugin]['deposits'] = 0;
$paymentarray[$plugin]['adeposits'] = 0;
}


}
if ($cash != "0") {
echo "<tr><td>".pcrtlang("$plugin").":</td><td align=right>$money".mf("$cash")."</td></tr>";
}
$pluginstotal = $pluginstotal + $cash;
}


if($storetoshow != "all") {
$storesql = " AND storeid = '$defaultuserstore' ";
} else {
$storesql = "";
}

reset($paymentplugins);
foreach($paymentplugins as $key => $plugin) {
if($usertoshow == "all") {
$rs_find_pluginsdep = "SELECT SUM(amount) AS totalcash FROM deposits WHERE depdate LIKE '$day%' AND paymentplugin = '$plugin' $storesql";
} else {
$rs_find_pluginsdep = "SELECT SUM(amount) AS totalcash FROM deposits WHERE depdate LIKE '$day%' AND paymentplugin = '$plugin' $storesql AND byuser = '$usertoshow'";
}
$rs_result_plugindep = mysqli_query($rs_connect, $rs_find_pluginsdep);
while($rs_result_plugin_qdep = mysqli_fetch_object($rs_result_plugindep)) {
$rs_totalcashdep = "$rs_result_plugin_qdep->totalcash";
if ($rs_totalcashdep != '') {
$cashb = $rs_totalcashdep;
} else {
$cashb = "0.00";
}

if (array_key_exists('$plugin',$paymentarray)) {
$paymentarray[$plugin]['deposits'] = $paymentarray[$plugin]['deposits'] + $cashb;
} else {
$paymentarray[$plugin]['deposits'] = $cashb;
}

}
if ($cashb != "0") {
echo "<tr><td>".pcrtlang("$plugin")." (".pcrtlang("Received Deposits")."):</td><td align=right>$money".mf("$cashb")."</td></tr>";
}
$pluginstotalb = $pluginstotalb + $cashb;
}


if($storetoshow != "all") {
$storesql = " AND appliedstoreid = '$defaultuserstore' ";
} else {
$storesql = "";
}

reset($paymentplugins);
foreach($paymentplugins as $key => $plugin) {
if($usertoshow == "all") {
$rs_find_pluginsdepa = "SELECT SUM(amount) AS totalcash FROM deposits WHERE applieddate LIKE '$day%' AND paymentplugin = '$plugin' AND dstatus = 'applied' $storesql";
} else {
$rs_find_pluginsdepa = "SELECT SUM(amount) AS totalcash FROM deposits WHERE applieddate LIKE '$day%' AND paymentplugin = '$plugin' AND dstatus = 'applied' $storesql AND byuser = '$usertoshow'";
}
$rs_result_plugindepa = mysqli_query($rs_connect, $rs_find_pluginsdepa);
while($rs_result_plugin_qdepa = mysqli_fetch_object($rs_result_plugindepa)) {
$rs_totalcashdepa = "$rs_result_plugin_qdepa->totalcash";
if ($rs_totalcashdepa != '') {
$casha = $rs_totalcashdepa;
} else {
$casha = "0.00";
}

if (array_key_exists('$plugin',$paymentarray)) {
$paymentarray[$plugin]['adeposits'] = $paymentarray[$plugin]['adeposits'] + $casha;
} else {
$paymentarray[$plugin]['adeposits'] = $casha;
}

}
if ($casha != "0") {
echo "<tr><td>".pcrtlang("$plugin")." (".pcrtlang("Applied Deposits")."):</td><td align=right>$money".mf("$casha")."</td></tr>";
}
$pluginstotala = $pluginstotala + $casha;
}


reset($paymentplugins);
foreach($paymentplugins as $key => $plugin) {
if (($paymentarray[$plugin]['deposits'] != 0) || ($paymentarray[$plugin]['adeposits'] != 0)) {
$netdiff = $paymentarray[$plugin]['totals'] + $paymentarray[$plugin]['deposits'] - $paymentarray[$plugin]['adeposits'];
echo "<tr><td>".pcrtlang("Net")." $plugin: ".pcrtlang("(less applied deposits) (plus received deposits)")."</td><td align=right>$money".mf("$netdiff")."</td></tr>";
}
}

if($storetoshow != "all") {
$storesql = " AND storeid = '$defaultuserstore' ";
} else {
$storesql = "";
}


if($usertoshow == "all") {
$rs_find_refund = "SELECT SUM(grandtotal) AS totalrefund FROM receipts WHERE date_sold LIKE '$day%' AND pay_type = 'refund' $storesql";
} else {
$rs_find_refund = "SELECT SUM(grandtotal) AS totalrefund FROM receipts WHERE date_sold LIKE '$day%' AND pay_type = 'refund' $storesql AND byuser = '$usertoshow'";
}
$rs_result_refund = mysqli_query($rs_connect, $rs_find_refund);
while($rs_result_refund_q = mysqli_fetch_object($rs_result_refund)) {
$rs_totalrefund = "$rs_result_refund_q->totalrefund";
if ($rs_totalrefund != '') {
$refund = mf(abs($rs_totalrefund));
} else {
$refund = "0.00";
}
}
if ($refund != "0") {
echo "<tr><td>".pcrtlang("Refund Total").":</td><td align=right>$money".mf("$refund")."</td></tr>";
}

##

if($storetoshow != "all") {
$storesql = " AND receipts.storeid = '$defaultuserstore' ";
} else {
$storesql = "";
}

if($usertoshow == "all") {
$rs_find_op = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE sold_items.date_sold LIKE '$day%' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id $storesql";
} else {
$rs_find_op = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE sold_items.date_sold LIKE '$day%' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id $storesql AND receipts.byuser = '$usertoshow'";
}
$rs_result_op = mysqli_query($rs_connect, $rs_find_op);
$rs_result_op_q = mysqli_fetch_object($rs_result_op);
$rs_totalop = "$rs_result_op_q->ourprice";
$rs_totalsp = "$rs_result_op_q->soldprice";

if($usertoshow == "all") {
$rs_find_opr = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE sold_items.date_sold LIKE '$day%' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id $storesql";
} else {
$rs_find_opr = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE sold_items.date_sold LIKE '$day%' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id $storesql AND receipts.byuser = '$usertoshow'";
}
$rs_result_opr = mysqli_query($rs_connect, $rs_find_opr);
$rs_result_opr_q = mysqli_fetch_object($rs_result_opr);
$rs_totalopr = "$rs_result_opr_q->ourprice";
$rs_totalspr = "$rs_result_opr_q->soldprice";


$rs_totalnet = ((tnv($rs_totalsp) - tnv($rs_totalspr)) - (tnv($rs_totalop) - tnv($rs_totalopr)));

$totalnet = mf(abs("$rs_totalnet"));

if($usertoshow == "all") {
$rs_find_lab = "SELECT SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE sold_items.date_sold LIKE '$day%' AND sold_items.sold_type = 'labor' AND sold_items.receipt = receipts.receipt_id $storesql";
} else {
$rs_find_lab = "SELECT SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE sold_items.date_sold LIKE '$day%' AND sold_items.sold_type = 'labor' AND sold_items.receipt = receipts.receipt_id $storesql AND receipts.byuser = '$usertoshow'";
}
$rs_result_lab = mysqli_query($rs_connect, $rs_find_lab);
$rs_result_lab_q = mysqli_fetch_object($rs_result_lab);
$rs_totallab = "$rs_result_lab_q->soldprice";
$totallabor = mf(abs($rs_totallab));


##


$totaltake =  (tnv($pluginstotal) + tnv($rs_totalrefund)); 
$totaltake2 = mf(abs($totaltake));

echo "<tr><td>".pcrtlang("Grand Total Sales").":</td>";
if ($totaltake < 0) {
echo "<td align=right><font class=textred>$money".mf("$totaltake2")."</font></td></tr>";
} else {
echo "<td align=right>$money".mf("$totaltake2")."</td></tr>";
}

if(($pluginstotala != 0) ||($pluginstotalb != 0)) {
echo "<tr><td>".pcrtlang("Grand Total")." (".pcrtlang("less applied deposits").") (".pcrtlang("plus received deposits")."):</td>";
$totaltakea = ($totaltake - $pluginstotala) + $pluginstotalb;
$totaltakea2 = mf(abs($totaltakea));
if ($totaltakea < 0) {
echo "<td align=right><font class=textred>$money".mf("$totaltakea2")."</font></td></tr>";
} else {
echo "<td align=right>$money".mf("$totaltakea2")."</td></tr>";
}
}

if (perm_check("5")) {
echo "<tr><td colspan=2>&nbsp;</td></tr>";
if ($totalnet != "0") {
if ($rs_totalnet > 0) {
echo "<tr><td>".pcrtlang("Estimated Net Sales").":</td><td align=right>$money".mf("$totalnet")."</td></tr>";
} else {
echo "<tr><td>".pcrtlang("Estimated Net Sales").":</td><td align=right><font class=textred>$money".mf("$totalnet")."</font></td></tr>";
}
}

if($rs_totallab != "0") {
echo "<tr><td>".pcrtlang("Labor Total").":</td><td align=right>$money".mf("$totallabor")."</td></tr>";
}


}

echo "</table>";

if($storetoshow != "all") {
$storesql = " AND storeid = '$defaultuserstore' ";
} else {
$storesql = "";
}

#hack
if($usertoshow == "all") {
$rs_find_cart_items = "SELECT * FROM receipts WHERE date_sold LIKE '$day%' $storesql ORDER BY date_sold DESC";
} else {
$rs_find_cart_items = "SELECT * FROM receipts WHERE date_sold LIKE '$day%' $storesql AND byuser = '$usertoshow' ORDER BY date_sold DESC";
}

$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);
                                                                                                                                               
echo "<br><h3>".pcrtlang("Receipts")." for $day</h3>";
echo "<table class=standard>";
echo "<tr><th>".pcrtlang("Receipt")."</th><th>".pcrtlang("Sold To")."</th><th><i class=\"fa fa-envelope fa-lg\"></i></th><th>".pcrtlang("Total")."</th></tr>";
                                                                                                                                               
while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_receipt_id = "$rs_result_q->receipt_id";
$rs_pay_type = "$rs_result_q->pay_type";
$rs_name = "$rs_result_q->person_name";
$rs_company = "$rs_result_q->company";
$rs_pay_type = "$rs_result_q->pay_type";
$rs_checkno = "$rs_result_q->check_number";
$rs_gt = "$rs_result_q->grandtotal";
$rs_date = "$rs_result_q->date_sold";
$rs_tax = "$rs_result_q->grandtax";
$rs_paywith = "$rs_result_q->paywith";
$rs_taxex = "$rs_result_q->taxex";
                                                                                                         
echo "<tr><td><button type=button onClick=\"parent.location='receipt.php?func=show_receipt&receipt=$rs_receipt_id'\" data-mini=\"true\">#$rs_receipt_id</button></td>";
$rs_date2 = date("g:i a", strtotime($rs_date));
 
echo "<td>$rs_name";
if("$rs_company" != "") {
echo "<br>$rs_company";
}

echo "<br><font class=em90>$rs_date2</font>";

echo "</td>";

$chkemailrecsql = "SELECT * FROM userlog WHERE reftype = 'receiptid' AND refid = '$rs_receipt_id' AND actionid = '27'";
$chkemailrec = mysqli_num_rows(mysqli_query($rs_connect, $chkemailrecsql));

if ($chkemailrec >= 1) {
echo "<td><i class=\"fa fa-check fa-lg\"></i></td>";
} else {
echo "<td>&nbsp;</td>";
}



if ($rs_gt < 0) {
$rs_gt2 =  mf(abs($rs_gt));
echo "<td style=\"text-align:right\"><font class=textred>$money".mf("$rs_gt2")."</font></td>";
} else {
echo "<td style=\"text-align:right\">$money".mf("$rs_gt")."</td>";
}
                                                                                                                                               
                                                                                                                                               
                                                                                                                                               
echo "</tr>";
                                                                                                                                               
}

echo "</table>";



####### payments
echo "<br><h3>".pcrtlang("Payments")." for $day</h3>";
echo "<table class=standard>";
echo "<tr><th>".pcrtlang("Payment Name")."</th><th>".pcrtlang("Receipt")."</th><th>".pcrtlang("Amount")."</th></tr>";

if($storetoshow != "all") {
$storesql = " AND savedpayments.storeid = '$defaultuserstore' ";
} else {
$storesql = "";
}

if($usertoshow == "all") {
$findpayments = "SELECT * FROM savedpayments WHERE paymentdate LIKE '$day%' $storesql ORDER BY paymentplugin ASC, paymentdate ASC";
} else {
$findpayments = "SELECT * FROM savedpayments,receipts WHERE savedpayments.paymentdate LIKE '$day%' $storesql AND receipts.receipt_id = savedpayments.receipt_id AND receipts.byuser = '$usertoshow' ORDER BY savedpayments.paymentplugin ASC, savedpayments.paymentdate ASC";
}

$findpaymentsq = @mysqli_query($rs_connect, $findpayments);
while ($findpaymentsa = mysqli_fetch_object($findpaymentsq)) {
$paymentamount = "$findpaymentsa->amount";
$paymentdate2 = "$findpaymentsa->paymentdate";
$rs_receipt_id = "$findpaymentsa->receipt_id";
$pfirstname = "$findpaymentsa->pfirstname";
$pcompany = "$findpaymentsa->pcompany";
$paymenttype = "$findpaymentsa->paymenttype";
$paymentid = "$findpaymentsa->paymentid";
$paymentplugin = "$findpaymentsa->paymentplugin";
$checknumber = "$findpaymentsa->chk_number";
$ccnumber2 = "$findpaymentsa->cc_number";
$ccexpmonth = "$findpaymentsa->cc_expmonth";
$ccexpyear = "$findpaymentsa->cc_expyear";
$cc_transid = "$findpaymentsa->cc_transid";
$cc_cardtype = "$findpaymentsa->cc_cardtype";
$custompaymentinfo2 = "$findpaymentsa->custompaymentinfo";

$custompaymentinfo = unserialize("$custompaymentinfo2");
$ccnumber = mb_substr("$ccnumber2", -4, 4);

$paymentdate = date("g:i a", strtotime($paymentdate2));

if ($paymenttype == "cash") {
echo "<tr><td>$pfirstname<br>".pcrtlang("Cash")."</td><td><button type=button onClick=\"parent.location='receipt.php?func=show_receipt&receipt=$rs_receipt_id'\" data-mini=\"true\">#$rs_receipt_id</button></td><td style=\"text-align:right\">$money".mf("$paymentamount")."</td>";
echo "</tr>";

} elseif ($paymenttype == "check") {
echo "<tr><td>$pfirstname<br>".pcrtlang("Check")."#$checknumber";
echo "</td><td><button type=button onClick=\"parent.location='receipt.php?func=show_receipt&receipt=$rs_receipt_id'\" data-mini=\"true\">#$rs_receipt_id</button></td><td style=\"text-align:right\">$money".mf("$paymentamount")."</td>";
echo "</tr>";

} elseif ($paymenttype == "credit") {
echo "<tr><td>";
echo "$pfirstname<br>$paymentplugin</td><td><button type=button onClick=\"parent.location='receipt.php?func=show_receipt&receipt=$rs_receipt_id'\" data-mini=\"true\">#$rs_receipt_id</button></td><td style=\"text-align:right\">$money".mf("$paymentamount")."</td>";
echo "</tr>";

} elseif ($paymenttype == "custompayment") {
echo "<tr><td>$pfirstname<br>$paymentplugin</td><td><button type=button onClick=\"parent.location='receipt.php?func=show_receipt&receipt=$rs_receipt_id'\" data-mini=\"true\">#$rs_receipt_id</button></td><td style=\"text-align:right\">$money".mf("$paymentamount")."";

echo "</td>";
echo "</tr>";

} else {
echo "<tr><td colspan=3>Error! Undefined Payment Type in database</td></tr>";
}

}



echo "</table>";

#######


echo "<button type=button onClick=\"parent.location='reports.php?func=day_report_csv&day=$day'\"><i class=\"fa fa-database fa-lg\"></i> ".pcrtlang("CSV")."</button>";


require("footer.php");

}


function day_report_csv() {

if (array_key_exists('day',$_REQUEST)) {
if ($_REQUEST['day'] != "") {
$day = $_REQUEST['day'];
} else {
$day = date("Y-m-d");
}
} else {
$day = date("Y-m-d");
}

         
require_once("common.php");

perm_boot("26");


$plusday = date("Y-m-d", (strtotime("$day") + 86400));                 
$minusday = date("Y-m-d", (strtotime("$day") - 86400));

if ($activestorecount > 1) {
$storeinfoarray = getstoreinfo($defaultuserstore);
$csv = "\"Store: $storeinfoarray[storesname]\"\n";
}


$csv = "\"".pcrtlang("Day Report for")." $day\"\n";

require("deps.php");




$pluginstotal = 0;
$pluginstotala = 0;

reset($paymentplugins);
foreach($paymentplugins as $key => $plugin) {
$rs_find_plugins = "SELECT SUM(amount) AS totalcash FROM savedpayments WHERE paymentdate LIKE '$day%' AND paymentplugin = '$plugin' AND storeid = '$defaultuserstore'";
$rs_result_plugin = mysqli_query($rs_connect, $rs_find_plugins);
while($rs_result_plugin_q = mysqli_fetch_object($rs_result_plugin)) {
$rs_totalcash = "$rs_result_plugin_q->totalcash";
if ($rs_totalcash != '') {
$cash = $rs_totalcash;
} else {
$cash = "0.00";
}
}
$csv .= "\"".pcrtlang("$plugin")." ".pcrtlang("Total").":\",\"$cash\"\n";
$pluginstotal = $pluginstotal + $cash;
}

reset($paymentplugins);
foreach($paymentplugins as $key => $plugin) {
$rs_find_pluginsdep = "SELECT SUM(amount) AS totalcash FROM deposits WHERE depdate LIKE '$day%' AND paymentplugin = '$plugin' AND storeid = '$defaultuserstore'";
$rs_result_plugindep = mysqli_query($rs_connect, $rs_find_pluginsdep);
while($rs_result_plugin_qdep = mysqli_fetch_object($rs_result_plugindep)) {
$rs_totalcashdep = "$rs_result_plugin_qdep->totalcash";
if ($rs_totalcashdep != '') {
$cash = $rs_totalcashdep;
} else {
$cash = "0.00";
}
}
if ($cash != "0") {
$csv .= "\"".pcrtlang("$plugin")." (".pcrtlang("Received Deposits")."):\",\"".mf("$cash")."\"\n";
}
$pluginstotal = $pluginstotal + $cash;
}



reset($paymentplugins);
foreach($paymentplugins as $key => $plugin) {
$rs_find_pluginsdepa = "SELECT SUM(amount) AS totalcash FROM deposits WHERE applieddate LIKE '$day%' AND paymentplugin = '$plugin' AND dstatus = 'applied' AND storeid = '$defaultuserstore'";
$rs_result_plugindepa = mysqli_query($rs_connect, $rs_find_pluginsdepa);
while($rs_result_plugin_qdepa = mysqli_fetch_object($rs_result_plugindepa)) {
$rs_totalcashdepa = "$rs_result_plugin_qdepa->totalcash";
if ($rs_totalcashdepa != '') {
$casha = $rs_totalcashdepa;
} else {
$casha = "0.00";
}
}
if ($casha != "0") {
$csv .= "\"".pcrtlang("$plugin")." (".pcrtlang("Applied Deposits")."):\",\"".mf("$casha")."\"\n";
}
$pluginstotala = $pluginstotala + $casha;
}




$rs_find_refund = "SELECT SUM(grandtotal) AS totalrefund FROM receipts WHERE date_sold LIKE '$day%' AND pay_type = 'refund' AND paywith NOT LIKE 'credit' AND storeid = '$defaultuserstore'";
$rs_result_refund = mysqli_query($rs_connect, $rs_find_refund);
while($rs_result_refund_q = mysqli_fetch_object($rs_result_refund)) {
$rs_totalrefund = "$rs_result_refund_q->totalrefund";
if ($rs_totalrefund != '') {
$refund = abs($rs_totalrefund);
} else {
$refund = "0.00";
}
}
$csv .= "\"".pcrtlang("Refund Total").":\",\"".mf("$refund")."\"\n";


$rs_find_op = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE sold_items.date_sold LIKE '$day%' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$defaultuserstore'";
$rs_result_op = mysqli_query($rs_connect, $rs_find_op);
$rs_result_op_q = mysqli_fetch_object($rs_result_op);
$rs_totalop = "$rs_result_op_q->ourprice";
$rs_totalsp = "$rs_result_op_q->soldprice";


$rs_find_opr = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE sold_items.date_sold LIKE '$day%' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$defaultuserstore'";
$rs_result_opr = mysqli_query($rs_connect, $rs_find_opr);
$rs_result_opr_q = mysqli_fetch_object($rs_result_opr);
$rs_totalopr = "$rs_result_opr_q->ourprice";
$rs_totalspr = "$rs_result_opr_q->soldprice";


$rs_totalnet = (($rs_totalsp - $rs_totalspr) - ($rs_totalop - $rs_totalopr));

$totalnet = abs($rs_totalnet);



$totaltake =  ($pluginstotal + $rs_totalrefund); 
$totaltake2 = abs($totaltake);

$csv .= "\"".pcrtlang("Grand Total").":\",";
$csv .= "\"".mf("$totaltake2")."\"\n";

if($pluginstotala != 0) {
$csv .= "\"".pcrtlang("Grand Total")." (".pcrtlang("less applied deposits")."):\",";
$totaltakea = $totaltake - $pluginstotala;
$csv .= "\"".mf("$totaltakea")."\"\n";
}


if (perm_check("5")) {
if ($totalnet != "0") {
$csv .= "\"".pcrtlang("Estimated Net Sales").":\",\"".mf("$totalnet")."\"\n";
}
}


$csv .= "\"\"\n";
$rs_find_cart_items = "SELECT * FROM receipts WHERE date_sold LIKE '$day%' AND storeid = '$defaultuserstore' ORDER BY date_sold DESC ";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);
                                                                                                                                               
$csv .= "\"".pcrtlang("Receipts for")." $day\"\n";
$csv .= "\"".pcrtlang("Receipt Number")."\",\"".pcrtlang("Date")."\",\"".pcrtlang("Sold To")."\",\"".pcrtlang("Total")."\"\n";


                                                                                                                                               
while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_receipt_id = "$rs_result_q->receipt_id";
$rs_pay_type = "$rs_result_q->pay_type";
$rs_name = "$rs_result_q->person_name";
$rs_pay_type = "$rs_result_q->pay_type";
$rs_checkno = "$rs_result_q->check_number";
$rs_gt = "$rs_result_q->grandtotal";
$rs_date = "$rs_result_q->date_sold";
$rs_tax = "$rs_result_q->grandtax";
$rs_paywith = "$rs_result_q->paywith";
$rs_taxex = "$rs_result_q->taxex";
                                                                                                         
$csv .= "\"#$rs_receipt_id\",";
$rs_date2 = date("n-j-y, g:i a", strtotime($rs_date));
$csv .= "\"$rs_date2\",";
 
$csv .= "\"$rs_name\",";
                                                                                                                                               
$csv .= "\"".mf("$rs_gt")."\"\n";

}

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"day_report_$day.csv\"");
echo $csv;


}







function day_span_report() {

if (array_key_exists('dayto',$_REQUEST)) {
if ($_REQUEST['dayto'] != "") {
$dayto = $_REQUEST['dayto'];
} else {
$dayto = date("Y-m-d");
}
} else {
$dayto = date("Y-m-d");
}

if (array_key_exists('dayfrom',$_REQUEST)) {
if ($_REQUEST['dayfrom'] != "") {
$dayfrom = $_REQUEST['dayfrom'];
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}

$reportstoreid = $_REQUEST['reportstoreid'];

require_once("header.php");

perm_boot("5");
                                                                                                                                           
require("deps.php");



echo "<h3>".pcrtlang("Report for")." $dayfrom ".pcrtlang("to")." $dayto</h3>";

if ($activestorecount > 1) {
if ("$reportstoreid" == "all") {
echo "<h3>".pcrtlang("Store").": ".pcrtlang("All Stores")."</h3>";
} else {
$storeinfoarray = getstoreinfo($reportstoreid);
echo "<h3>".pcrtlang("Store").": $storeinfoarray[storesname]</h3>";
}
}



#echo "<a href=reports.php?func=day_span_report&dayto=$dayto&dayfrom=$dayfrom&printable=yes&reportstoreid=$reportstoreid><img src=images/print.png align=absmiddle border=0> ".pcrtlang("Printable")."</a>";
#echo "<br><a href=reports.php?func=day_span_report_csv&dayto=$dayto&dayfrom=$dayfrom&reportstoreid=$reportstoreid><img src=images/csv.png align=absmiddle border=0> ".pcrtlang("CSV")."</a>";







if ("$reportstoreid" == "all") {
$rs_find_cart_pur = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='purchase' AND date_sold <= '$dayto 23:59:59' AND date_sold >= '$dayfrom 00:00:00'";
} else {
$rs_find_cart_pur = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='purchase' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold  >= '$dayfrom 00:00:00'";
}
$rs_result_pur = mysqli_query($rs_connect, $rs_find_cart_pur);
while($rs_result_pur_q = mysqli_fetch_object($rs_result_pur)) {
$rs_purtotal = "$rs_result_pur_q->total";
echo pcrtlang("Total Purchases").": $money".mf("$rs_purtotal")."<br>";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_lab = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type = 'labor' AND date_sold <= '$dayto 23:59:59' AND date_sold >= '$dayfrom 00:00:00'";
} else {
$rs_find_cart_lab = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type = 'labor' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00'";
}
$rs_result_lab = mysqli_query($rs_connect, $rs_find_cart_lab);
while($rs_result_lab_q = mysqli_fetch_object($rs_result_lab)) {
$rs_labtotal = "$rs_result_lab_q->total";
echo pcrtlang("Total Labor").": $money".mf("$rs_labtotal")."<br>";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_ref = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='refund' AND date_sold <= '$dayto 23:59:59' AND date_sold >= '$dayfrom 00:00:00'";
} else {
$rs_find_cart_ref = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='refund' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.date_sold <= '$dayto 23:59:59' AND  sold_items.date_sold >= '$dayfrom 00:00:00'";
}
$rs_result_ref = mysqli_query($rs_connect, $rs_find_cart_ref);
while($rs_result_ref_q = mysqli_fetch_object($rs_result_ref)) {
$rs_reftotal = "$rs_result_ref_q->total";
echo pcrtlang("Total Sales Refunds").": $money".mf("$rs_reftotal")."<br>";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_refr = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='refundlabor' AND date_sold <= '$dayto 23:59:59' AND date_sold >= '$dayfrom 00:00:00'";
} else {
$rs_find_cart_refr = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='refundlabor' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.date_sold <= '$dayto 23:59:59' AND  sold_items.date_sold >= '$dayfrom 00:00:00'";
}
$rs_result_refr = mysqli_query($rs_connect, $rs_find_cart_refr);
while($rs_result_refr_q = mysqli_fetch_object($rs_result_refr)) {
$rs_reftotallr = "$rs_result_refr_q->total";
echo pcrtlang("Total Refunded Labor").": $money".mf("$rs_reftotallr")."<br>";
}


if ("$reportstoreid" == "all") {
$rs_find_cart_refx = "SELECT SUM(itemtax) AS total FROM sold_items WHERE date_sold <= '$dayto 23:59:59' AND date_sold >= '$dayfrom 00:00:00' AND sold_type != 'refund' AND sold_type != 'refundlabor'";
} else {
$rs_find_cart_refx = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts WHERE receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.date_sold <= '$dayto 23:59:59' AND  sold_items.date_sold >= '$dayfrom 00:00:00' AND sold_items.sold_type != 'refund' AND sold_items.sold_type != 'refundlabor'";
}
$rs_result_refx = mysqli_query($rs_connect, $rs_find_cart_refx);
while($rs_result_ref_qx = mysqli_fetch_object($rs_result_refx)) {
$rs_totaltax = "$rs_result_ref_qx->total";
echo "<br>".pcrtlang("Total Sales/Service Tax Collected").": $money".mf("$rs_totaltax");
}

if ("$reportstoreid" == "all") {
$rs_find_cart_refxr = "SELECT SUM(itemtax) AS total FROM sold_items WHERE date_sold <= '$dayto 23:59:59' AND date_sold >= '$dayfrom 00:00:00' AND (sold_type = 'refund' OR sold_type = 'refundlabor')";
} else {
$rs_find_cart_refxr = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts WHERE receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND (sold_items.sold_type = 'refund' OR sold_items.sold_type = 'refundlabor')";
}
$rs_result_refxr = mysqli_query($rs_connect, $rs_find_cart_refxr);
while($rs_result_ref_qxr = mysqli_fetch_object($rs_result_refxr)) {
$rs_totaltaxr = "$rs_result_ref_qxr->total";
echo "<br>".pcrtlang("Total Sales/Service Tax Refunded").": $money".mf("$rs_totaltaxr")."<br>";
}



$totalgross = ((tnv($rs_purtotal) + tnv($rs_labtotal)) - (tnv($rs_reftotal) + tnv($rs_reftotallr)));
if ($totalgross >= 0) {
echo "<br>".pcrtlang("Gross Total")." (".pcrtlang("Taxable + Non-Taxable Sales &amp; Labor/Not Including Tax")."): $money".mf("$totalgross")."<br>";
} else {
echo "<br>".pcrtlang("Gross Total")." (".pcrtlang("Taxable + Non-Taxable Sales &amp; Labor/Not Including Tax")."): <font class=textred>($money".mf(abs($totalgross)).")</font><br>";
}

$totalgrosswtax = ((tnv($rs_purtotal) + tnv($rs_labtotal) + tnv($rs_totaltax)) - (tnv($rs_reftotal) + tnv($rs_reftotallr) + tnv($rs_totaltaxr)));
if ($totalgrosswtax >= 0) {
echo "<br>".pcrtlang("Gross Total inc. Tax")." (".pcrtlang("Taxable + Non-Taxable Sales &amp; Labor/Including Tax")."): $money".mf("$totalgrosswtax")."<br>";
} else {
echo "<br>".pcrtlang("Gross Total inc Tax")." (".pcrtlang("Taxable + Non-Taxable Sales &amp; Labor/Including Tax")."): <font class=textred>($money".mf(abs($totalgrosswtax)).")<br>";
}


$totaltax = tnv($rs_totaltax) - tnv($rs_totaltaxr);
if ($totaltax >= 0) {
echo "<br><font class=text14b>".pcrtlang("Tax Total less Refunded Tax").":</font> <font class=text14b>$money".mf("$totaltax")."</font><br><br>";
} else {
echo "<br><font class=text14b>".pcrtlang("Tax Total less Refunded Tax").":</font> <font class=textred14b>($money".mf(abs("$totaltax")).")</font><br><br>";
}


#####

if ("$reportstoreid" == "all") {
$rs_find_op = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_op = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$reportstoreid'";
}
$rs_result_op = mysqli_query($rs_connect, $rs_find_op);
$rs_result_op_q = mysqli_fetch_object($rs_result_op);
$rs_totalop = "$rs_result_op_q->ourprice";
$rs_totalsp = "$rs_result_op_q->soldprice";

if ("$reportstoreid" == "all") {
$rs_find_opr = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_opr = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$reportstoreid'";
}

$rs_result_opr = mysqli_query($rs_connect, $rs_find_opr);
$rs_result_opr_q = mysqli_fetch_object($rs_result_opr);
$rs_totalopr = "$rs_result_opr_q->ourprice";
$rs_totalspr = "$rs_result_opr_q->soldprice";


$rs_totalnet = ((tnv($rs_totalsp) - tnv($rs_totalspr)) - (tnv($rs_totalop) - tnv($rs_totalopr)));

$totalnet = abs($rs_totalnet);

if ($rs_totalnet >= 0) {
echo pcrtlang("Estimated Net Sales").": $money".mf("$totalnet")."<br><br>";
} else {
echo pcrtlang("Estimated Net Sales").":<font class=textred> ($money".mf("$totalnet").")</font><br><br>";
}


$rs_cogs = (tnv($rs_totalop) - tnv($rs_totalopr));
$totalcogs = abs($rs_cogs);

if ($rs_cogs >= 0) {
echo pcrtlang("Cost of Goods Sold").": $money".mf("$totalcogs")."<br><br>";
} else {
echo pcrtlang("Cost of Goods Sold").":<font class=textred> ($money".mf("$totalcogs").")</font><br><br>";
}



$netincome = tnv($rs_totalnet) + (tnv($rs_labtotal) - tnv($rs_reftotallr));

if ($rs_totalnet >= 0) {
echo pcrtlang("Net Income").": $money".mf("$netincome")."<br><br>";
} else {
echo pcrtlang("Net Income").":<font class=textred> ($money".mf("$netincome").")</font><br><br>";
}




####




require("footer.php");

}



function day_span_report_csv() {

if (array_key_exists('dayto',$_REQUEST)) {
if ($_REQUEST['dayto'] != "") {
$dayto = $_REQUEST['dayto'];
} else {
$dayto = date("Y-m-d");
}
} else {
$dayto = date("Y-m-d");
}

if (array_key_exists('dayfrom',$_REQUEST)) {
if ($_REQUEST['dayfrom'] != "") {
$dayfrom = $_REQUEST['dayfrom'];
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}

$reportstoreid = $_REQUEST['reportstoreid'];

require_once("common.php");

perm_boot("5");
                                                                                                                                           
require("deps.php");

$csv = "\"".pcrtlang("Report for")." $dayfrom ".pcrtlang("to")." $dayto\"\n";

if ($activestorecount > 1) {
if ("$reportstoreid" == "all") {
$csv .= "\"".pcrtlang("Store: All Stores")."\"\n";
} else {
$storeinfoarray = getstoreinfo($reportstoreid);
$csv .= "\"".pcrtlang("Store").": $storeinfoarray[storesname]\"\n";
}
}








if ("$reportstoreid" == "all") {
$rs_find_cart_pur = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='purchase' AND date_sold <= '$dayto 23:59:59' AND date_sold  >= '$dayfrom 00:00:00'";
} else {
$rs_find_cart_pur = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE receipts.storeid = '$reportstoreid' AND sold_items.sold_type='purchase' AND sold_items.receipt = receipts.receipt_id AND sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold  >= '$dayfrom 00:00:00'";
}
$rs_result_pur = mysqli_query($rs_connect, $rs_find_cart_pur);
while($rs_result_pur_q = mysqli_fetch_object($rs_result_pur)) {
$rs_purtotal = "$rs_result_pur_q->total";
$csv .= "\"".pcrtlang("Total Purchases").":\",\"".mf("$rs_purtotal")."\"\n";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_lab = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='labor' AND date_sold <= '$dayto 23:59:59' AND date_sold >= '$dayfrom 00:00:00'";
} else {
$rs_find_cart_lab = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='labor' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00'";
}
$rs_result_lab = mysqli_query($rs_connect, $rs_find_cart_lab);
while($rs_result_lab_q = mysqli_fetch_object($rs_result_lab)) {
$rs_labtotal = "$rs_result_lab_q->total";
$csv .= "\"".pcrtlang("Total Labor").":\",\"".mf("$rs_labtotal")."\"\n";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_ref = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='refund' AND date_sold <= '$dayto 23:59:59' AND date_sold >= '$dayfrom 00:00:00'";
} else {
$rs_find_cart_ref = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='refund' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00'";
}
$rs_result_ref = mysqli_query($rs_connect, $rs_find_cart_ref);
while($rs_result_ref_q = mysqli_fetch_object($rs_result_ref)) {
$rs_reftotal = "$rs_result_ref_q->total";
$csv .= "\"".pcrtlang("Total Sales Refunds").":\",\"".mf("$rs_reftotal")."\"\n";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_refr = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='refundlabor' AND date_sold <= '$dayto 23:59:59' AND date_sold >= '$dayfrom 00:00:00'";
} else {
$rs_find_cart_refr = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='refundlabor' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00'";
}
$rs_result_refr = mysqli_query($rs_connect, $rs_find_cart_refr);
while($rs_result_refr_q = mysqli_fetch_object($rs_result_refr)) {
$rs_reftotallr = "$rs_result_refr_q->total";
$csv .= "\"".pcrtlang("Total Labor Refunds").":\",\"".mf("$rs_reftotallr")."\"\n";
}



if ("$reportstoreid" == "all") {
$rs_find_cart_refx = "SELECT SUM(itemtax) AS total FROM sold_items WHERE date_sold <= '$dayto 23:59:59' AND date_sold >= '$dayfrom 00:00:00' AND sold_type != 'refund' AND sold_type != 'refundlabor'";
} else {
$rs_find_cart_refx = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts WHERE sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND receipts.storeid = '$reportstoreid' AND sold_items.sold_type != 'refund' AND sold_items.sold_type != 'refundlabor' AND sold_items.receipt = receipts.receipt_id ";
}
$rs_result_refx = mysqli_query($rs_connect, $rs_find_cart_refx);
while($rs_result_ref_qx = mysqli_fetch_object($rs_result_refx)) {
$rs_totaltax = "$rs_result_ref_qx->total";
$csv .= "\"".pcrtlang("Total Sales/Service Tax Collected").":\",\"".mf("$rs_totaltax")."\"\n";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_refxr = "SELECT SUM(itemtax) AS total FROM sold_items WHERE date_sold <= '$dayto 23:59:59' AND date_sold >= '$dayfrom 00:00:00' AND (sold_type = 'refund' OR sold_type = 'refundlabor')";
} else {
$rs_find_cart_refxr = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts WHERE sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND (sold_items.sold_type = 'refund' OR AND sold_items.sold_type = 'refundlabor')";
}
$rs_result_refxr = mysqli_query($rs_connect, $rs_find_cart_refxr);
while($rs_result_ref_qxr = mysqli_fetch_object($rs_result_refxr)) {
$rs_totaltaxr = "$rs_result_ref_qxr->total";
$csv .= "\"".pcrtlang("Total Sales/Service Tax Refunded").":\",\"(".mf(abs("$rs_totaltaxr")).")\"\n";
}



$totalgross = (($rs_purtotal + $rs_labtotal) - ($rs_reftotal + $rs_reftotallr));
if($totalgross >= 0) {
$csv .= "\"".pcrtlang("Gross Total")." (".pcrtlang("Taxable + Non Taxable Sales and Labor Not Including Tax")."):\",\"".mf("$totalgross")."\"\n";
} else {
$csv .= "\"".pcrtlang("Gross Total")." (".pcrtlang("Taxable + Non Taxable Sales and Labor Not Including Tax")."):\",\"(".mf(abs("$totalgross")).")\"\n";
}

$totaltax = $rs_totaltax - $rs_totaltaxr;
if($totaltax >= 0) {
$csv .= "\"".pcrtlang("Tax Total less Refunded Tax").":\",\"".mf("$totaltax")."\"\n";
} else {
$csv .= "\"".pcrtlang("Tax Total less Refunded Tax").":\",\"(".mf(abs("$totaltax")).")\"\n";
}

if ("$reportstoreid" == "all") {
$rs_find_op = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_op = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$reportstoreid'";
}
$rs_result_op = mysqli_query($rs_connect, $rs_find_op);
$rs_result_op_q = mysqli_fetch_object($rs_result_op);
$rs_totalop = "$rs_result_op_q->ourprice";
$rs_totalsp = "$rs_result_op_q->soldprice";

if ("$reportstoreid" == "all") {
$rs_find_opr = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_opr = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$reportstoreid'";
}

$rs_result_opr = mysqli_query($rs_connect, $rs_find_opr);
$rs_result_opr_q = mysqli_fetch_object($rs_result_opr);
$rs_totalopr = "$rs_result_opr_q->ourprice";
$rs_totalspr = "$rs_result_opr_q->soldprice";

$rs_totalnet = (($rs_totalsp - $rs_totalspr) - ($rs_totalop - $rs_totalopr));

$csv .= "\"".pcrtlang("Estimated Net Sales").":\",\"".mf("$rs_totalnet")."\"\n";

$rs_cogs = ($rs_totalop - $rs_totalopr);

$csv .= "\"".pcrtlang("Total Cost of Goods Sold").":\",\"".mf("$rs_cogs")."\"\n";

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"day_span_report_".$dayto."_".$dayfrom.".csv\"");
echo $csv;

            
}








#################################################################################################################################

function year_report() {


if (array_key_exists('year',$_REQUEST)) {
if ($_REQUEST['year'] != "") {
$year = $_REQUEST['year'];
} else {
$year = date("Y");
}
} else {
$year = date("Y");
}



require_once("header.php");

$reportstoreid = $_REQUEST['reportstoreid'];
                                                                                                                                           
require("deps.php");

perm_boot("5");

echo "<h3>".pcrtlang("Yearly Report for")." $year</h3>";

if ($activestorecount > 1) {
if ("$reportstoreid" == "all") {
echo pcrtlang("Store: All Stores")."<br><br>";
} else {
$storeinfoarray = getstoreinfo($reportstoreid);
echo pcrtlang("Store").": $storeinfoarray[storesname]<br><br>";
}
}


echo "<table class=standard><tr><th>$year</th></tr><tr><td>";






if ("$reportstoreid" == "all") {
$rs_find_cart_pur = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='purchase' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_pur = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='purchase' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_pur = mysqli_query($rs_connect, $rs_find_cart_pur);
while($rs_result_pur_q = mysqli_fetch_object($rs_result_pur)) {
$rs_purtotal = "$rs_result_pur_q->total";
echo pcrtlang("Total Purchases").": $money".mf("$rs_purtotal")."<br>";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_lab = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='labor' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_lab = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='labor' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_lab = mysqli_query($rs_connect, $rs_find_cart_lab);
while($rs_result_lab_q = mysqli_fetch_object($rs_result_lab)) {
$rs_labtotal = "$rs_result_lab_q->total";
echo pcrtlang("Total Labor").": $money".mf("$rs_labtotal")."<br>";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_ref = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='refund' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_ref = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='refund' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_ref = mysqli_query($rs_connect, $rs_find_cart_ref);
while($rs_result_ref_q = mysqli_fetch_object($rs_result_ref)) {
$rs_reftotal = "$rs_result_ref_q->total";
echo pcrtlang("Total Sales Refunds").": $money".mf("$rs_reftotal")."<br>";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_labr = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='refundlabor' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_labr = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='refundlabor' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_labr = mysqli_query($rs_connect, $rs_find_cart_labr);
while($rs_result_labr_q = mysqli_fetch_object($rs_result_labr)) {
$rs_labtotalr = "$rs_result_labr_q->total";
echo pcrtlang("Total Refunded Labor").": $money".mf("$rs_labtotalr")."<br>";
}



if ("$reportstoreid" == "all") {
$rs_find_cart_refx = "SELECT SUM(itemtax) AS total FROM sold_items WHERE YEAR(date_sold) = '$year' AND sold_type != 'refund' AND sold_type != 'refundlabor'";
} else {
$rs_find_cart_refx = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts WHERE YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.sold_type != 'refund' AND sold_items.sold_type != 'refundlabor'";
}
$rs_result_refx = mysqli_query($rs_connect, $rs_find_cart_refx);
while($rs_result_ref_qx = mysqli_fetch_object($rs_result_refx)) {
$rs_totaltax = "$rs_result_ref_qx->total";
echo "<br>".pcrtlang("Sales/Service Tax Collected").": $money".mf("$rs_totaltax");
}

if ("$reportstoreid" == "all") {
$rs_find_cart_refxr = "SELECT SUM(itemtax) AS total FROM sold_items WHERE YEAR(date_sold) = '$year' AND (sold_type = 'refund' OR sold_type = 'refundlabor')";
} else {
$rs_find_cart_refxr = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts WHERE YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id  AND (sold_items.sold_type = 'refund' OR sold_items.sold_type = 'refundlabor')";
}
$rs_result_refxr = mysqli_query($rs_connect, $rs_find_cart_refxr);
while($rs_result_ref_qxr = mysqli_fetch_object($rs_result_refxr)) {
$rs_totaltaxr = "$rs_result_ref_qxr->total";
echo "<br>".pcrtlang("Refunded Sales/Service Tax").": $money".mf("$rs_totaltaxr")."<br>";
}



$totalgross = ((tnv($rs_purtotal) + tnv($rs_labtotal) + tnv($rs_totaltax)) - (tnv($rs_reftotal) + tnv($rs_totaltaxr) + tnv($rs_labtotalr)));
echo "<br>".pcrtlang("Gross Total").": $money".mf("$totalgross")."<br><br><br>";

if ("$reportstoreid" == "all") {
$rs_find_op = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_op = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE sold_items.sold_type='purchase' AND YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$reportstoreid'";
}
$rs_result_op = mysqli_query($rs_connect, $rs_find_op);
$rs_result_op_q = mysqli_fetch_object($rs_result_op);
$rs_totalop = "$rs_result_op_q->ourprice";
$rs_totalsp = "$rs_result_op_q->soldprice";
if ("$reportstoreid" == "all") {
$rs_find_opr = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_opr = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$reportstoreid'";
}

$rs_result_opr = mysqli_query($rs_connect, $rs_find_opr);
$rs_result_opr_q = mysqli_fetch_object($rs_result_opr);
$rs_totalopr = "$rs_result_opr_q->ourprice";
$rs_totalspr = "$rs_result_opr_q->soldprice";


$rs_totalnet = ((tnv($rs_totalsp) - tnv($rs_totalspr)) - (tnv($rs_totalop) - tnv($rs_totalopr)));

$totalnet = abs($rs_totalnet);

if ($rs_totalnet > 0) {
echo pcrtlang("Estimated Net Sales").": $money".mf("$totalnet")."<br><br>";
} else {
echo pcrtlang("Estimated Net Sales").":<font class=textred> $money".mf("$totalnet")."</font><br><br>";
}


$rs_cogs = (tnv($rs_totalop) - tnv($rs_totalopr));
$totalcogs = abs($rs_cogs);

if ($rs_cogs > 0) {
echo pcrtlang("Cost of Goods Sold").": $money".mf("$totalcogs")."<br><br>";
} else {
echo pcrtlang("Cost of Goods Sold").":<font class=textred> $money".mf("$totalcogs")."</font><br><br>";
}


echo "</td></tr></table><br>";



echo "<button type=button onClick=\"parent.location='reports.php?func=year_report_csv&year=$year&reportstoreid=$reportstoreid'\"><i class=\"fa fa-database fa-lg\"></i> ".pcrtlang("CSV")."</button>";
                                                                                                                                   
require("footer.php");



}



function year_report_csv() {

if (array_key_exists('year',$_REQUEST)) {
if ($_REQUEST['year'] != "") {
$year = $_REQUEST['year'];
} else {
$year = date("Y");
}
} else {
$year = date("Y");
}

$reportstoreid = $_REQUEST['reportstoreid'];

require_once("common.php");
                                                                                                                                           
require("deps.php");

perm_boot("5");


$csv =  "\"".pcrtlang("Yearly Report for")." $year\"\n";

if ($activestorecount > 1) {
if ("$reportstoreid" == "all") {
$csv .= "\"".pcrtlang("Store: All Stores")."\"\n";
} else {
$storeinfoarray = getstoreinfo($reportstoreid);
$csv .= "\"Store: $storeinfoarray[storesname]\"\n";
}
}






if ("$reportstoreid" == "all") {
$rs_find_cart_pur = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='purchase' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_pur = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='purchase' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_pur = mysqli_query($rs_connect, $rs_find_cart_pur);
while($rs_result_pur_q = mysqli_fetch_object($rs_result_pur)) {
$rs_purtotal = "$rs_result_pur_q->total";
$csv .= "\"".pcrtlang("Total Purchases").":\",\"".mf("$rs_purtotal")."\"\n";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_lab = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='labor' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_lab = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='labor' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_lab = mysqli_query($rs_connect, $rs_find_cart_lab);
while($rs_result_lab_q = mysqli_fetch_object($rs_result_lab)) {
$rs_labtotal = "$rs_result_lab_q->total";
$csv .= "\"".pcrtlang("Total Labor").":\",\"$rs_labtotal\"\n";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_ref = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='refund' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_ref = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='refund' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_ref = mysqli_query($rs_connect, $rs_find_cart_ref);
while($rs_result_ref_q = mysqli_fetch_object($rs_result_ref)) {
$rs_reftotal = "$rs_result_ref_q->total";
$csv .= "\"".pcrtlang("Total Sales Refunds").":\",\"$rs_reftotal\"\n";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_labr = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='refundlabor' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_labr = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='refundlabor' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_labr = mysqli_query($rs_connect, $rs_find_cart_labr);
while($rs_result_labr_q = mysqli_fetch_object($rs_result_labr)) {
$rs_labtotalr = "$rs_result_labr_q->total";
$csv .= "\"".pcrtlang("Total Refunded Labor").":\",\"$rs_labtotalr\"\n";
}



if ("$reportstoreid" == "all") {
$rs_find_cart_refx = "SELECT SUM(itemtax) AS total FROM sold_items WHERE YEAR(date_sold) = '$year' AND sold_type != 'refund' AND sold_type != 'refundlabor'";
} else {
$rs_find_cart_refx = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts WHERE YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type != 'refund' AND sold_type != 'refundlabor' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_refx = mysqli_query($rs_connect, $rs_find_cart_refx);
while($rs_result_ref_qx = mysqli_fetch_object($rs_result_refx)) {
$rs_totaltax = "$rs_result_ref_qx->total";
$csv .= "\"".pcrtlang("Sales/Service Tax Collected").":\",\"$rs_totaltax\"\n";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_refxr = "SELECT SUM(itemtax) AS total FROM sold_items WHERE YEAR(date_sold) = '$year' AND sold_type = 'refund' AND sold_type = 'refundlabor'";
} else {
$rs_find_cart_refxr = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts WHERE YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id  AND (sold_items.sold_type = 'refund' OR sold_items.sold_type = 'refundlabor')";
}
$rs_result_refxr = mysqli_query($rs_connect, $rs_find_cart_refxr);
while($rs_result_ref_qxr = mysqli_fetch_object($rs_result_refxr)) {
$rs_totaltaxr = "$rs_result_ref_qxr->total";
$csv .= "\"".pcrtlang("Refunded Sales/Service Tax").":\",\"$rs_totaltaxr\"\n";
}



$totalgross = (($rs_purtotal + $rs_labtotal + $rs_totaltax) - ($rs_reftotal + $rs_totaltaxr + $rs_labtotalr));
$csv .= "\"".pcrtlang("Gross Total").":\",\"$totalgross\"\n";


if ("$reportstoreid" == "all") {
$rs_find_op = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_op = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE sold_items.sold_type='purchase' AND YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$reportstoreid'";
}
$rs_result_op = mysqli_query($rs_connect, $rs_find_op);
$rs_result_op_q = mysqli_fetch_object($rs_result_op);
$rs_totalop = "$rs_result_op_q->ourprice";
$rs_totalsp = "$rs_result_op_q->soldprice";
if ("$reportstoreid" == "all") {
$rs_find_opr = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_opr = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$reportstoreid'";
}

$rs_result_opr = mysqli_query($rs_connect, $rs_find_opr);
$rs_result_opr_q = mysqli_fetch_object($rs_result_opr);
$rs_totalopr = "$rs_result_opr_q->ourprice";
$rs_totalspr = "$rs_result_opr_q->soldprice";


$rs_totalnet = (($rs_totalsp - $rs_totalspr) - ($rs_totalop - $rs_totalopr));
$csv .= "\"".pcrtlang("Estimated Net Sales").":\",\"$rs_totalnet\"\n";


$rs_cogs = ($rs_totalop - $rs_totalopr);
$csv .= "\"".pcrtlang("Cost of Goods Sold").":\",\"$rs_cogs\"\n";



header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"year_report_$year.csv\"");
echo $csv;

}




function quarter_report() {


require("deps.php");

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}


if (array_key_exists('year',$_REQUEST)) {
if ($_REQUEST['year'] != "") {
$year = $_REQUEST['year'];
} else {
$year = date("Y");
}
} else {
$year = date("Y");
}


require_once("header.php");

$reportstoreid = $_REQUEST['reportstoreid'];
                                                                                                                                               

perm_boot("5");


echo "<h3>".pcrtlang("Quarterly Reports")."</h3>";

if ($activestorecount > 1) {
if ("$reportstoreid" == "all") {
echo pcrtlang("Store").": ".pcrtlang("All Stores")."<br><br>";
} else {
$storeinfoarray = getstoreinfo($reportstoreid);
echo pcrtlang("Store").": $storeinfoarray[storesname]<br><br>";
}
}










$firstq = 1;

while($firstq <= 4) {

echo "<table class=standard><tr><th>".pcrtlang("Quarter")." $firstq, $year</th></tr><tr><td>";



if ("$reportstoreid" == "all") {
$rs_find_cart_pur = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='purchase' AND QUARTER(date_sold) = '$firstq' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_pur = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='purchase' AND QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_pur = mysqli_query($rs_connect, $rs_find_cart_pur);
while($rs_result_pur_q = mysqli_fetch_object($rs_result_pur)) {
$rs_purtotal = "$rs_result_pur_q->total";
echo pcrtlang("Total Purchases").": $money".mf("$rs_purtotal")."<br>";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_lab = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='labor' AND QUARTER(date_sold) = '$firstq' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_lab = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='labor' AND QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_lab = mysqli_query($rs_connect, $rs_find_cart_lab);
while($rs_result_lab_q = mysqli_fetch_object($rs_result_lab)) {
$rs_labtotal = "$rs_result_lab_q->total";
echo pcrtlang("Total Labor").": $money".mf("$rs_labtotal")."<br>";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_ref = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='refund' AND QUARTER(date_sold) = '$firstq' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_ref = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='refund' AND QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_ref = mysqli_query($rs_connect, $rs_find_cart_ref);
while($rs_result_ref_q = mysqli_fetch_object($rs_result_ref)) {
$rs_reftotal = "$rs_result_ref_q->total";
echo pcrtlang("Total Sales Refunds").": $money".mf("$rs_reftotal")."<br>";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_labr = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='refundlabor' AND QUARTER(date_sold) = '$firstq' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_labr = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='refundlabor' AND QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_labr = mysqli_query($rs_connect, $rs_find_cart_labr);
while($rs_result_labr_q = mysqli_fetch_object($rs_result_labr)) {
$rs_labtotalr = "$rs_result_labr_q->total";
echo pcrtlang("Total Labor Refunds").": $money".mf("$rs_labtotalr")."<br>";
}


if ("$reportstoreid" == "all") {
$rs_find_cart_tax = "SELECT SUM(itemtax) AS total FROM sold_items WHERE QUARTER(date_sold) = '$firstq' AND YEAR(date_sold) = '$year' AND sold_type != 'refund' AND sold_type != 'refundlabor'";
} else {
$rs_find_cart_tax = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts WHERE QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.sold_type != 'refund' AND sold_items.sold_type != 'refundlabor'";
}
$rs_result_tax = mysqli_query($rs_connect, $rs_find_cart_tax);
while($rs_result_tax_q = mysqli_fetch_object($rs_result_tax)) {
$rs_taxtotal = "$rs_result_tax_q->total";
echo "<br>".pcrtlang("Sales/Service Tax").": $money".mf("$rs_taxtotal");
}

if ("$reportstoreid" == "all") {
$rs_find_cart_taxr = "SELECT SUM(itemtax) AS total FROM sold_items WHERE QUARTER(date_sold) = '$firstq' AND YEAR(date_sold) = '$year' AND (sold_type = 'refund' OR sold_type = 'refundlabor')";
} else {
$rs_find_cart_taxr = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts WHERE QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND (sold_items.sold_type = 'refund' OR sold_items.sold_type = 'refundlabor')";
}
$rs_result_taxr = mysqli_query($rs_connect, $rs_find_cart_taxr);
while($rs_result_tax_qr = mysqli_fetch_object($rs_result_taxr)) {
$rs_taxtotalr = "$rs_result_tax_qr->total";
echo "<br>".pcrtlang("Refunded Sales/Service Tax").": $money".mf("$rs_taxtotalr")."<br>";
}



$totalgross = (tnv($rs_purtotal) + tnv($rs_labtotal) + tnv($rs_taxtotal) - (tnv($rs_reftotal) + tnv($rs_taxtotalr) + tnv($rs_labtotalr)));
echo "<br>".pcrtlang("Gross Total").": $money".mf("$totalgross")."<br><br>";

if ("$reportstoreid" == "all") {
$rs_find_op = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_op = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE sold_items.sold_type='purchase' AND QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$reportstoreid'";
}


$rs_result_op = mysqli_query($rs_connect, $rs_find_op);
$rs_result_op_q = mysqli_fetch_object($rs_result_op);
$rs_totalop = "$rs_result_op_q->ourprice";
$rs_totalsp = "$rs_result_op_q->soldprice";
if ("$reportstoreid" == "all") {
$rs_find_opr = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_opr = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$reportstoreid'";
}

$rs_result_opr = mysqli_query($rs_connect, $rs_find_opr);
$rs_result_opr_q = mysqli_fetch_object($rs_result_opr);
$rs_totalopr = "$rs_result_opr_q->ourprice";
$rs_totalspr = "$rs_result_opr_q->soldprice";


$rs_totalnet = ((tnv($rs_totalsp) - tnv($rs_totalspr)) - (tnv($rs_totalop) - tnv($rs_totalopr)));

$totalnet = abs($rs_totalnet);

if ($rs_totalnet > 0) {
echo pcrtlang("Estimated Net Sales").": $money".mf("$totalnet")."<br><br>";
} else {
echo pcrtlang("Estimated Net Sales").":<font class=textred> $money".mf("$totalnet")."</font><br><br>";
}


$rs_cogs = (tnv($rs_totalop) - tnv($rs_totalopr));
$totalcogs = abs($rs_cogs);

if ($rs_cogs > 0) {
echo pcrtlang("Cost of Goods Sold").": $money".mf("$totalcogs")."<br><br>";
} else {
echo pcrtlang("Cost of Goods Sold").":<font class=textred> $money".mf("$totalcogs")."</font><br><br>";
}



$firstq++;

echo "</td></tr></table><br>";

}


require("footer.php");

echo "<button type=button onClick=\"parent.location='reports.php?func=quarter_report_csv&year=$year&reportstoreid=$reportstoreid'\"><i class=\"fa fa-database fa-lg\"></i> ".pcrtlang("CSV")."</button>";


}


function quarter_report_csv() {

if (array_key_exists('year',$_REQUEST)) {
if ($_REQUEST['year'] != "") {
$year = $_REQUEST['year'];
} else {
$year = date("Y");
}
} else {
$year = date("Y");
}

$reportstoreid = $_REQUEST['reportstoreid'];

require_once("common.php");
                                                                                                                                               
require("deps.php");

perm_boot("5");

$csv = "\"".pcrtlang("Quarterly Reports")."\"\n";

if ($activestorecount > 1) {
if ("$reportstoreid" == "all") {
$csv .= "\"".pcrtlang("Store").": ".pcrtlang("All Stores")."\"\n";
} else {
$storeinfoarray = getstoreinfo($reportstoreid);
$csv .= "\"".pcrtlang("Store").": $storeinfoarray[storesname]\"\n";
}
}






$firstq = 1;

while($firstq <= 4) {

$csv .= "\"\"\n";
$csv .= "\"".pcrtlang("Quarter")." $firstq, $year\"\n";


if ("$reportstoreid" == "all") {
$rs_find_cart_pur = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='purchase' AND QUARTER(date_sold) = '$firstq' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_pur = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='purchase' AND QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_pur = mysqli_query($rs_connect, $rs_find_cart_pur);
while($rs_result_pur_q = mysqli_fetch_object($rs_result_pur)) {
$rs_purtotal = "$rs_result_pur_q->total";
$csv .= "\"".pcrtlang("Total Purchases")."\",\"$rs_purtotal\"\n";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_lab = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='labor' AND QUARTER(date_sold) = '$firstq' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_lab = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='labor' AND QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_lab = mysqli_query($rs_connect, $rs_find_cart_lab);
while($rs_result_lab_q = mysqli_fetch_object($rs_result_lab)) {
$rs_labtotal = "$rs_result_lab_q->total";
$csv .= "\"".pcrtlang("Total Labor").":\",\"$rs_labtotal\"\n";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_ref = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='refund' AND QUARTER(date_sold) = '$firstq' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_ref = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='refund' AND QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_ref = mysqli_query($rs_connect, $rs_find_cart_ref);
while($rs_result_ref_q = mysqli_fetch_object($rs_result_ref)) {
$rs_reftotal = "$rs_result_ref_q->total";
$csv .= "\"".pcrtlang("Total Sales Refunds").":\",\"$rs_reftotal\"\n";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_labr = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='refundlabor' AND QUARTER(date_sold) = '$firstq' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_labr = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='refundlabor' AND QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_labr = mysqli_query($rs_connect, $rs_find_cart_labr);
while($rs_result_labr_q = mysqli_fetch_object($rs_result_labr)) {
$rs_labtotalr = "$rs_result_labr_q->total";
$csv .= "\"".pcrtlang("Total Refunded Labor").":\",\"$rs_labtotalr\"\n";
}


if ("$reportstoreid" == "all") {
$rs_find_cart_tax = "SELECT SUM(itemtax) AS total FROM sold_items WHERE QUARTER(date_sold) = '$firstq' AND YEAR(date_sold) = '$year' AND sold_type != 'refund' AND sold_type != 'refundlabor'";
} else {
$rs_find_cart_tax = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts WHERE QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.sold_type != 'refund' AND sold_items.sold_type != 'refundlabor'";
}
$rs_result_tax = mysqli_query($rs_connect, $rs_find_cart_tax);
while($rs_result_tax_q = mysqli_fetch_object($rs_result_tax)) {
$rs_taxtotal = "$rs_result_tax_q->total";
$csv .= "\"".pcrtlang("Sales/Service Tax").":\",\"$rs_taxtotal\"\n";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_taxr = "SELECT SUM(itemtax) AS total FROM sold_items WHERE QUARTER(date_sold) = '$firstq' AND YEAR(date_sold) = '$year' AND (sold_type = 'refund' OR sold_type = 'refundlabor')";
} else {
$rs_find_cart_taxr = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts WHERE QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND (sold_items.sold_type = 'refund' OR sold_items.sold_type = 'refundlabor')";
}
$rs_result_taxr = mysqli_query($rs_connect, $rs_find_cart_taxr);
while($rs_result_tax_qr = mysqli_fetch_object($rs_result_taxr)) {
$rs_taxtotalr = "$rs_result_tax_qr->total";
$csv .= "\"".pcrtlang("Refunded Sales/Service Tax").":\",\"$rs_taxtotalr\"\n";
}



$totalgross = ($rs_purtotal + $rs_labtotal +$rs_taxtotal - ($rs_reftotal + $rs_taxtotalr + $rs_labtotalr));
$csv .= "\"".pcrtlang("Gross Total")."\",\"$totalgross\"\n";

if ("$reportstoreid" == "all") {
$rs_find_op = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_op = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE sold_items.sold_type='purchase' AND QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$reportstoreid'";
}
$rs_result_op = mysqli_query($rs_connect, $rs_find_op);
$rs_result_op_q = mysqli_fetch_object($rs_result_op);
$rs_totalop = "$rs_result_op_q->ourprice";
$rs_totalsp = "$rs_result_op_q->soldprice";
if ("$reportstoreid" == "all") {
$rs_find_opr = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_opr = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$reportstoreid'";
}

$rs_result_opr = mysqli_query($rs_connect, $rs_find_opr);
$rs_result_opr_q = mysqli_fetch_object($rs_result_opr);
$rs_totalopr = "$rs_result_opr_q->ourprice";
$rs_totalspr = "$rs_result_opr_q->soldprice";


$rs_totalnet = (($rs_totalsp - $rs_totalspr) - ($rs_totalop - $rs_totalopr));
$csv .= "\"".pcrtlang("Estimate Net Sales")."\",\"$rs_totalnet\"\n";


$rs_cogs = ($rs_totalop - $rs_totalopr);
$csv .= "\"".pcrtlang("Cost of Goods Sold")."\",\"$rs_cogs\"\n";








$firstq++;
}

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"quarter_report_$year.csv\"");
echo $csv;

}



function month_report() {
                      
require("deps.php");

if (array_key_exists('year',$_REQUEST)) {
if ($_REQUEST['year'] != "") {
$year = $_REQUEST['year'];
} else {
$year = date("Y");
}
} else {
$year = date("Y");
}


$reportstoreid = $_REQUEST['reportstoreid'];
         
require_once("header.php");



perm_boot("5");


echo "<h3>".pcrtlang("Monthly Reports")."</h3>";

if ($activestorecount > 1) {
if ("$reportstoreid" == "all") {
echo pcrtlang("Store").": ".pcrtlang("All Stores")."<br><br>";
} else {
$storeinfoarray = getstoreinfo($reportstoreid);
echo pcrtlang("Store").": $storeinfoarray[storesname]<br><br>";
}
}




$m = 1;
       
while($m < 13) {

echo "<table class=standard><tr><th>";


if ($m == 1) {
echo pcrtlang("January");
} elseif ($m == 2) {
echo pcrtlang("February");
} elseif ($m == 3) {
echo pcrtlang("March");
} elseif ($m == 4) {
echo pcrtlang("April");
} elseif ($m == 5) {
echo pcrtlang("May");
} elseif ($m == 6) {
echo pcrtlang("June");
} elseif ($m == 7) {
echo pcrtlang("July");
} elseif ($m == 8) {
echo pcrtlang("August");
} elseif ($m == 9) {
echo pcrtlang("September");
} elseif ($m == 10) {
echo pcrtlang("October");
} elseif ($m == 11) {
echo pcrtlang("November");
} else {
echo pcrtlang("December");
}




echo "</th></tr><tr><td>";
                                                                                                                                                                                                         




if ("$reportstoreid" == "all") {
$rs_find_cart_pur = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='purchase' AND MONTH(date_sold) = '$m' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_pur = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='purchase' AND MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_pur = mysqli_query($rs_connect, $rs_find_cart_pur);
while($rs_result_pur_q = mysqli_fetch_object($rs_result_pur)) {
$rs_purtotal = "$rs_result_pur_q->total";
echo pcrtlang("Total Purchases").": $money".mf("$rs_purtotal")."<br>";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_lab = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='labor' AND MONTH(date_sold) = '$m' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_lab = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='labor' AND MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_lab = mysqli_query($rs_connect, $rs_find_cart_lab);
while($rs_result_lab_q = mysqli_fetch_object($rs_result_lab)) {
$rs_labtotal = "$rs_result_lab_q->total";
echo pcrtlang("Total Labor").": $money".mf("$rs_labtotal")."<br>";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_ref = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='refund' AND MONTH(date_sold) = '$m' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_ref = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='refund' AND MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_ref = mysqli_query($rs_connect, $rs_find_cart_ref);
while($rs_result_ref_q = mysqli_fetch_object($rs_result_ref)) {
$rs_reftotal = "$rs_result_ref_q->total";
echo pcrtlang("Total Sales Refunds").": $money".mf("$rs_reftotal")."<br>";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_refl = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='refundlabor' AND MONTH(date_sold) = '$m' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_refl = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='refundlabor' AND MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_refl = mysqli_query($rs_connect, $rs_find_cart_refl);
while($rs_result_ref_ql = mysqli_fetch_object($rs_result_refl)) {
$rs_reftotall = "$rs_result_ref_ql->total";
echo pcrtlang("Total Labor Refunds").": $money".mf("$rs_reftotall")."<br>";
}



if ("$reportstoreid" == "all") {
$rs_find_cart_taxx = "SELECT SUM(itemtax) AS total FROM sold_items WHERE MONTH(date_sold) = '$m' AND YEAR(date_sold) = '$year' AND sold_type != 'refund' AND sold_type != 'refundlabor'";
} else {
$rs_find_cart_taxx = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts WHERE MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id  AND sold_items.sold_type != 'refund' AND sold_items.sold_type != 'refundlabor'";
}
$rs_result_taxx = mysqli_query($rs_connect, $rs_find_cart_taxx);
while($rs_result_tax_qx = mysqli_fetch_object($rs_result_taxx)) {
$rs_taxtotalx = "$rs_result_tax_qx->total";
echo "<br>".pcrtlang("Sales/Service Tax").": $money".mf("$rs_taxtotalx")."<br>";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_taxxr = "SELECT SUM(itemtax) AS total FROM sold_items WHERE MONTH(date_sold) = '$m' AND YEAR(date_sold) = '$year' AND (sold_type = 'refund' OR sold_type = 'refundlabor')";
} else {
$rs_find_cart_taxxr = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts WHERE MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND (sold_items.sold_type = 'refund' OR sold_items.sold_type = 'refundlabor')";
}
$rs_result_taxxr = mysqli_query($rs_connect, $rs_find_cart_taxxr);
while($rs_result_tax_qxr = mysqli_fetch_object($rs_result_taxxr)) {
$rs_taxtotalxr = "$rs_result_tax_qxr->total";
echo pcrtlang("Refunded Sales/Service Tax").": $money".mf("$rs_taxtotalxr")."<br>";
}


$totalgross = ((tnv($rs_purtotal)  + tnv($rs_labtotal) + tnv($rs_taxtotalx)) - (tnv($rs_taxtotalxr) + tnv($rs_reftotal) + tnv($rs_reftotall)));
echo pcrtlang("Gross Total").": $money".mf("$totalgross")."<br><br>";

###

if ("$reportstoreid" == "all") {
$rs_find_op = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_op = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE sold_items.sold_type='purchase' AND MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$reportstoreid'";
}
$rs_result_op = mysqli_query($rs_connect, $rs_find_op);
$rs_result_op_q = mysqli_fetch_object($rs_result_op);
$rs_totalop = "$rs_result_op_q->ourprice";
$rs_totalsp = "$rs_result_op_q->soldprice";

if ("$reportstoreid" == "all") {
$rs_find_opr = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_opr = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$reportstoreid'";
}

$rs_result_opr = mysqli_query($rs_connect, $rs_find_opr);
$rs_result_opr_q = mysqli_fetch_object($rs_result_opr);
$rs_totalopr = "$rs_result_opr_q->ourprice";
$rs_totalspr = "$rs_result_opr_q->soldprice";


$rs_totalnet = ((tnv($rs_totalsp) - tnv($rs_totalspr)) - (tnv($rs_totalop) - tnv($rs_totalopr)));

$totalnet = abs($rs_totalnet);

if ($rs_totalnet > 0) {
echo pcrtlang("Estimated Net Sales").": $money".mf("$totalnet")."<br><br>";
} else {
echo pcrtlang("Estimated Net Sales").":<font class=textred> $money".mf("$totalnet")."</font><br><br>";
}


$rs_cogs = (tnv($rs_totalop) - tnv($rs_totalopr));
$totalcogs = abs($rs_cogs);

if ($rs_cogs > 0) {
echo pcrtlang("Cost of Goods Sold").": $money".mf("$totalcogs")."<br><br>";
} else {
echo pcrtlang("Cost of Goods Sold").":<font class=textred> $money".mf("$totalcogs")."</font><br><br>";
}




$m++;

echo "</td></tr></table><br>";

}


echo "<br><button type=button onClick=\"parent.location='reports.php?func=month_report_csv&year=$year&reportstoreid=$reportstoreid'\"><i class=\"fa fa-database fa-lg\"></i> ".pcrtlang("CSV")."</button>";

require("footer.php");

}


function month_report_csv() {
                      
if (array_key_exists('year',$_REQUEST)) {
if ($_REQUEST['year'] != "") {
$year = $_REQUEST['year'];
} else {
$year = date("Y");
}
} else {
$year = date("Y");
}

$reportstoreid = $_REQUEST['reportstoreid'];
         
require_once("common.php");

require("deps.php");

perm_boot("5");
         
$csv = "\"".pcrtlang("Monthly Reports")."\"\n";

if ($activestorecount > 1) {
if ("$reportstoreid" == "all") {
$csv .= "\"".pcrtlang("Store").": ".pcrtlang("All Stores")."\"\n";
} else {
$storeinfoarray = getstoreinfo($reportstoreid);
$csv .= "\"".pcrtlang("Store").": $storeinfoarray[storesname]\"\n";
}
}


$m = 1;
       
while($m < 13) {


        
$csv .= "\"\"\n";
                                                                                                                                                                                     

if ($m == 1) {
$csv .= "\"".pcrtlang("January")."\"\n";
} elseif ($m == 2) {
$csv .= "\"".pcrtlang("February")."\"\n";
} elseif ($m == 3) {
$csv .= "\"".pcrtlang("March")."\"\n";
} elseif ($m == 4) {
$csv .= "\"".pcrtlang("April")."\"\n";
} elseif ($m == 5) {
$csv .= "\"".pcrtlang("May")."\"\n";
} elseif ($m == 6) {
$csv .= "\"".pcrtlang("June")."\"\n";
} elseif ($m == 7) {
$csv .= "\"".pcrtlang("July")."\"\n";
} elseif ($m == 8) {
$csv .= "\"".pcrtlang("August")."\"\n";
} elseif ($m == 9) {
$csv .= "\"".pcrtlang("September")."\"\n";
} elseif ($m == 10) {
$csv .= "\"".pcrtlang("October")."\"\n";
} elseif ($m == 11) {
$csv .= "\"".pcrtlang("November")."\"\n";
} else {
$csv .= "\"".pcrtlang("December")."\"\n";
}




                                                                                                                                                                                                         




if ("$reportstoreid" == "all") {
$rs_find_cart_pur = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='purchase' AND MONTH(date_sold) = '$m' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_pur = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='purchase' AND MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_pur = mysqli_query($rs_connect, $rs_find_cart_pur);
while($rs_result_pur_q = mysqli_fetch_object($rs_result_pur)) {
$rs_purtotal = "$rs_result_pur_q->total";
$csv .= "\"".pcrtlang("Total Purchases").":\",\"$rs_purtotal\"\n";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_lab = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='labor' AND MONTH(date_sold) = '$m' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_lab = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='labor' AND MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_lab = mysqli_query($rs_connect, $rs_find_cart_lab);
while($rs_result_lab_q = mysqli_fetch_object($rs_result_lab)) {
$rs_labtotal = "$rs_result_lab_q->total";
$csv .= "\"".pcrtlang("Total Labor").":\",\"$rs_labtotal\"\n";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_ref = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='refund' AND MONTH(date_sold) = '$m' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_ref = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='refund' AND MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_ref = mysqli_query($rs_connect, $rs_find_cart_ref);
while($rs_result_ref_q = mysqli_fetch_object($rs_result_ref)) {
$rs_reftotal = "$rs_result_ref_q->total";
$csv .= "\"".pcrtlang("Total Sales Refunds").":\",\"$rs_reftotal\"\n";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_refl = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='refundlabor' AND MONTH(date_sold) = '$m' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_refl = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='refundlabor' AND MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_refl = mysqli_query($rs_connect, $rs_find_cart_refl);
while($rs_result_ref_ql = mysqli_fetch_object($rs_result_refl)) {
$rs_reftotall = "$rs_result_ref_ql->total";
$csv .= "\"".pcrtlang("Total Labor Refunds").":\",\"$rs_reftotall\"\n";
}


if ("$reportstoreid" == "all") {
$rs_find_cart_taxx = "SELECT SUM(itemtax) AS total FROM sold_items WHERE MONTH(date_sold) = '$m' AND YEAR(date_sold) = '$year' AND sold_type != 'refund' AND sold_type != 'refundlabor'";
} else {
$rs_find_cart_taxx = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts WHERE MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id  AND sold_items.sold_type != 'refund'  AND sold_items.sold_type != 'refundlabor'";
}
$rs_result_taxx = mysqli_query($rs_connect, $rs_find_cart_taxx);
while($rs_result_tax_qx = mysqli_fetch_object($rs_result_taxx)) {
$rs_taxtotalx = "$rs_result_tax_qx->total";
$csv .= "\"".pcrtlang("Sales/Service Tax")."\",\"$rs_taxtotalx\"\n";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_taxxr = "SELECT SUM(itemtax) AS total FROM sold_items WHERE MONTH(date_sold) = '$m' AND YEAR(date_sold) = '$year' AND (sold_type = 'refund' OR sold_type = 'refundlabor')";
} else {
$rs_find_cart_taxxr = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts WHERE MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND (sold_items.sold_type = 'refund' OR sold_items.sold_type = 'refundlabor')";
}
$rs_result_taxxr = mysqli_query($rs_connect, $rs_find_cart_taxxr);
while($rs_result_tax_qxr = mysqli_fetch_object($rs_result_taxxr)) {
$rs_taxtotalxr = "$rs_result_tax_qxr->total";
$csv .= "\"".pcrtlang("Refunded Sales/Service Tax")."\",\"$rs_taxtotalxr\"\n";
}




$totalgross = (($rs_purtotal  + $rs_labtotal + $rs_taxtotalx) - ($rs_taxtotalxr + $rs_reftotal + $rs_taxtotalxr));
$csv .= "\"".pcrtlang("Gross Total").":\",\"$totalgross\"\n";


if ("$reportstoreid" == "all") {
$rs_find_op = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_op = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE sold_items.sold_type='purchase' AND MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$reportstoreid'";
}
$rs_result_op = mysqli_query($rs_connect, $rs_find_op);
$rs_result_op_q = mysqli_fetch_object($rs_result_op);
$rs_totalop = "$rs_result_op_q->ourprice";
$rs_totalsp = "$rs_result_op_q->soldprice";
if ("$reportstoreid" == "all") {
$rs_find_opr = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_opr = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$reportstoreid'";
}

$rs_result_opr = mysqli_query($rs_connect, $rs_find_opr);
$rs_result_opr_q = mysqli_fetch_object($rs_result_opr);
$rs_totalopr = "$rs_result_opr_q->ourprice";
$rs_totalspr = "$rs_result_opr_q->soldprice";


$rs_totalnet = (($rs_totalsp - $rs_totalspr) - ($rs_totalop - $rs_totalopr));

$csv .= "\"".pcrtlang("Estimated Net Sales").":\",\"".mf("$rs_totalnet")."\"\n";


$rs_cogs = ($rs_totalop - $rs_totalopr);

$csv .= "\"".pcrtlang("Cost of Goods Sold").":\",\"".mf("$rs_cogs")."\"\n";




$m++;
}

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"month_report_$year.csv\"");
echo $csv;


}





function browse_sold() {

require_once("header.php");

$results_per_page = 40;

if (array_key_exists("pageNumber", $_REQUEST)) {
$pageNumber = $_REQUEST['pageNumber'];
} else {
$pageNumber = 1;
}


if ($pageNumber == "") {
$offset = "0";
} else {
$offset = ($pageNumber * $results_per_page) - $results_per_page;
}



require("deps.php");




$rs_find_cart_items = "SELECT sold_items.sold_id,sold_items.receipt,sold_items.sold_price,sold_items.unit_price,sold_items.stockid,sold_items.sold_type,sold_items.date_sold FROM sold_items,receipts WHERE sold_items.stockid != '0' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$defaultuserstore' ORDER BY date_sold DESC LIMIT $offset,$results_per_page";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

$rs_find_cart_items_total = "SELECT sold_items.sold_id FROM sold_items,receipts WHERE sold_items.stockid != '0' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$defaultuserstore'";
$rs_result_total = mysqli_query($rs_connect, $rs_find_cart_items_total);

if ($activestorecount > 1) {
$storeinfoarray = getstoreinfo($defaultuserstore);
echo "<h3>".pcrtlang("Browse Sold Items")." | ".pcrtlang("Store").": $storeinfoarray[storesname]</h3>";
} else {
echo "<h3>".pcrtlang("Browse Sold Items")."</h3>";
}


while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_sold_id = "$rs_result_q->sold_id";
$rs_receipt = "$rs_result_q->receipt";
$rs_sold_price = "$rs_result_q->sold_price";
$rs_stockid = "$rs_result_q->stockid";
$rs_sold_type = "$rs_result_q->sold_type";
$rs_date_sold = "$rs_result_q->date_sold";
$rs_unit_price = "$rs_result_q->unit_price";

$rs_find_stock_name = "SELECT * FROM stock WHERE stock_id = '$rs_stockid'";
$rs_result_stock = mysqli_query($rs_connect, $rs_find_stock_name);
$rs_result_stock_q = mysqli_fetch_object($rs_result_stock);
$rs_partname2 = "$rs_result_stock_q->stock_title";

$rs_find_stock_count = "SELECT * FROM stockcounts WHERE stockid = '$rs_stockid' AND storeid = '$defaultuserstore'";
$rs_result_stockc = mysqli_query($rs_connect, $rs_find_stock_count);
$rs_result_stock_cq = mysqli_fetch_object($rs_result_stockc);
$rs_stockcount = "$rs_result_stock_cq->quantity";


$rs_partname2 = "$rs_result_stock_q->stock_title";

$rs_partname = urlencode("$rs_partname2");

echo "<table class=standard>";




echo "<tr><th><button type=button onClick=\"parent.location='stock.php?func=show_stock_detail&stockid=$rs_stockid'\" data-mini=\"true\">$rs_partname2</button></th></tr>";
echo "<tr><td><button type=button onClick=\"parent.location='receipt.php?func=show_receipt&receipt=$rs_receipt'\" data-mini=\"true\">".pcrtlang("Receipt")." #$rs_receipt</button></td></tr>";



echo "<tr><td>".pcrtlang("Sell Price")." $money".mf("$rs_unit_price")."</td></tr>";


$rs_date2 = date("n-j-y", strtotime($rs_date_sold));
echo "<tr><td>".pcrtlang("Date")." $rs_date2</td></tr>";

echo "<tr><td>".pcrtlang("In Stock Qty")." $rs_stockcount</td></tr>";



echo "</table><br>";

}


echo "<br>";
#browse here
$totalentry = mysqli_num_rows($rs_result_total);
$prevpage = $pageNumber - 1;
$nextpage = $pageNumber + 1;

echo "<center>";

if ($pageNumber > 1) {
echo "<button type=button onClick=\"parent.location='reports.php?func=browse_sold&pageNumber=$prevpage'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\">";
echo "<i class=\"fa fa-chevron-right fa-lg\"></i></button>";
}

$total_results = $totalentry;
$results_per_page = $results_per_page;
$html = get_paged_nav($total_results, $results_per_page, false);
echo "$html";

if (($totalentry / $results_per_page) > $pageNumber) {
echo "<button type=button onClick=\"parent.location='reports.php?func=browse_sold&pageNumber=$nextpage'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\">";
echo "<i class=\"fa fa-chevron-right fa-lg\"></i></button>";
}

echo "</center>";

require("footer.php");

}




function browse_outofstock() {

require_once("header.php");

$results_per_page = 40;

if (array_key_exists("pageNumber", $_REQUEST)) {
$pageNumber = $_REQUEST['pageNumber'];
} else {
$pageNumber = 1;
}


if ($pageNumber == "") {
$offset = "0";
} else {
$offset = ($pageNumber * $results_per_page) - $results_per_page;
}



require("deps.php");




$rs_find_cart_items = "SELECT stock.stock_price,stock.stock_id,stock.stock_title,stockcounts.quantity FROM stock,stockcounts WHERE stock.dis_cont != '1' AND stockcounts.quantity <= '0' AND stockcounts.storeid = '$defaultuserstore' AND stock.stock_id = stockcounts.stockid ORDER BY stock_id DESC LIMIT $offset,$results_per_page";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

$rs_find_cart_items_total = "SELECT stock.stock_price,stock.stock_id,stock.stock_title,stockcounts.quantity FROM stock,stockcounts WHERE stock.dis_cont != '1' AND stockcounts.quantity <= '0' AND stockcounts.storeid = '$defaultuserstore' AND stock.stock_id = stockcounts.stockid";
$rs_result_total = mysqli_query($rs_connect, $rs_find_cart_items_total);

if ($activestorecount > 1) {
$storeinfoarray = getstoreinfo($defaultuserstore);
echo "<h3>".pcrtlang("Browse Out of Stock Items")." | ".pcrtlang("Store").": $storeinfoarray[storesname]</h3>";
} else {
echo "<h3>".pcrtlang("Browse Out of Stock Items")."</h3>";
}

while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_sold_price = "$rs_result_q->stock_price";
$rs_stockid = "$rs_result_q->stock_id";
$rs_partname2 = "$rs_result_q->stock_title";
$rs_stockcount = "$rs_result_q->quantity";


$rs_partname = urlencode("$rs_partname2");

echo "<table class=standard><tr><th><button type=button onClick=\"parent.location='stock.php?func=show_stock_detail&stockid=$rs_stockid'\" data-mini=\"true\">#$rs_stockid $rs_partname2</button></td></tr>";


echo "<tr><td>".pcrtlang("Price").": $money".mf("$rs_sold_price")."</td></tr>";


echo "<tr><td>".pcrtlang("Stock Qty").": $rs_stockcount</td></tr>";



echo "</table><br>";

}


echo "<br>";
#browse here
$totalentry = mysqli_num_rows($rs_result_total);
$prevpage = $pageNumber - 1;
$nextpage = $pageNumber + 1;

echo "<center>";

if ($pageNumber > 1) {
echo "<button type=button onClick=\"parent.location='reports.php?func=browse_outofstock&pageNumber=$prevpage'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\">";
echo "<i class=\"fa fa-chevron-left fa-lg\"></i></button>";
}

$total_results = $totalentry;
$results_per_page = $results_per_page;
$html = get_paged_nav($total_results, $results_per_page, false);
echo "$html";

if (($totalentry / $results_per_page) > $pageNumber) {
echo "<button type=button onClick=\"parent.location='reports.php?func=browse_outofstock&pageNumber=$nextpage'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\">";
echo "<i class=\"fa fa-chevron-right fa-lg\"></i></button>";
}

echo "</center>";

require("footer.php");

}






function repair_vol() {

require_once("header.php");

require("deps.php");
$shift = 0;

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}

$currentdatetime = date('Y-m-d H:i:s');

$today = date('N');

$thefirstday = (time() - (86400 * $today));

$thefirstdaytime = 604799 + strtotime(date('Y-m-d 00:00:00', $thefirstday));

echo "<h3>".pcrtlang("PC Repair Volume")." &bull; $currentdatetime</h3>";

echo "<table width=100%><tr><td width=25><center>".pcrtlang("Weeks Ago")."</td><td>";
echo pcrtlang("Total Computers Checked In(green)<br>Returning Computers Checked In(blue)<br>Out(red):")."</td></tr>";
while($shift < 53) {

$theq = "SELECT * FROM pc_wo WHERE (WEEK(dropdate) = WEEK(DATE_SUB('$currentdatetime', INTERVAL $shift week)) AND YEAR(dropdate) = YEAR(DATE_SUB('$currentdatetime', INTERVAL $shift week))) AND storeid = '$defaultuserstore'";
$theqp = "SELECT * FROM pc_wo WHERE (WEEK(pickupdate) = WEEK(DATE_SUB('$currentdatetime', INTERVAL $shift week)) AND YEAR(pickupdate) = YEAR(DATE_SUB('$currentdatetime', INTERVAL $shift week))) AND storeid = '$defaultuserstore'";






$a = 0;
$rs_result_wo_r = mysqli_query($rs_connect, $theq);
while($rs_result_rq = mysqli_fetch_object($rs_result_wo_r)) {
$rs_pcids = "$rs_result_rq->pcid";
$totaloftwo = "SELECT pcid FROM pc_wo WHERE pcid = '$rs_pcids'";
$rs_result_two = mysqli_query($rs_connect, $totaloftwo);
$totalpcs_wo = mysqli_num_rows($rs_result_two);
if($totalpcs_wo > 1) {
$a++;
}
}

$rs_result = mysqli_query($rs_connect, $theq);
$totalpcs = mysqli_num_rows($rs_result);
$rs_result2 = mysqli_query($rs_connect, $theqp);
$totalpcs2 = mysqli_num_rows($rs_result2);


if ($totalpcs == "0") {
$growit = 2;
} else {
$growit = $totalpcs * 8;
}

if ($totalpcs2 == "0") {
$growit2 = 2;
} else {
$growit2 = $totalpcs2 * 8;
}

if ($a == "0") {
$growit3 = 2;
} else {
$growit3 = $a * 2;
}


if ($shift == '0') {
$theweek = pcrtlang("This Week")."<br>";
} else {
$thefrom = date('Y-m-d', $thefirstdaytime);
$theto = date('Y-m-d', ($thefirstdaytime - 604799));
$theweek = "$shift<br>$thefrom<br>".pcrtlang("thru")."<br>$theto";
}

echo "<tr><td width=25 rowspan=3><center>$theweek</center></td><td>";
echo "<div style=\"width:$growit"."px; background:green;\">&nbsp;</div>$totalpcs";
echo "</td></tr>";

echo "<tr><td><div style=\"width:$growit3"."px; background:blue;\">&nbsp;</div>$a";
echo "</td></tr>";

echo "<tr><td><div style=\"width:$growit2"."px; background:red;\">&nbsp;</div>$totalpcs2";
echo "</td></tr>";

echo "<tr><td colspan=2>&nbsp;</td></tr>";


$shift++;
$thefirstdaytime = $thefirstdaytime - 604800;
}

echo "</table>";


require("footer.php");

}






function fixinv1() {

$thenum = $_REQUEST['thenum'];

require_once("header.php");

require("deps.php");

perm_boot("6");

if ($thenum =="") {
$thenum = 1;
}

$theq = "SELECT * FROM `stock` WHERE stock_quantity > '0' LIMIT $thenum,1";




$rs_result = mysqli_query($rs_connect, $theq);

$more = $thenum + 1;
$less =	$thenum	- 1;

while($rs_result_q = mysqli_fetch_object($rs_result)) {
$qty = "$rs_result_q->stock_quantity";
$stockid = "$rs_result_q->stock_id";

$plus1 = $qty + 1;
$minus1 = $qty - 1;

echo "<font size=6><b><a href=reports.php?func=fixinv2&thenum=$thenum&numadd=$plus1&stockid=$stockid>".pcrtlang("Up")."<a><br>";
echo "<a href=reports.php?func=fixinv1&thenum=$less>&lt;</a> $stockid  &gt;  $qty <a href=reports.php?func=fixinv1&thenum=$more>&gt;</a><br>";
echo "<a href=reports.php?func=fixinv2&thenum=$thenum&numadd=$minus1&stockid=$stockid>".pcrtlang("Down")."<a><br></font></b>";

}

}


function fixinv2() {

$thenum = $_REQUEST['thenum'];
$numadd = $_REQUEST['numadd'];
$stockid = $_REQUEST['stockid'];

require_once("validate.php");
require("common.php");
require("deps.php");

perm_boot("6");





$rs_insert_stock = "UPDATE stock SET stock_quantity = '$numadd' WHERE stock_id = '$stockid'";
@mysqli_query($rs_connect, $rs_insert_stock);

header("Location: reports.php?func=fixinv1&thenum=$thenum");



}



#################

function taxreport() {

if (array_key_exists('year',$_REQUEST)) {
if ($_REQUEST['year'] != "") {
$year = $_REQUEST['year'];
} else {
$year = date("Y");
}
} else {
$year = date("Y");
}

if (array_key_exists('month',$_REQUEST)) {
if ($_REQUEST['month'] != "") {
$qmonth = $_REQUEST['month'];
} else {
$qmonth = date("M");
}
} else {
$qmonth = date("M");
}



if (array_key_exists('fiscaldate',$_REQUEST)) {
$fiscaldate = $_REQUEST['fiscaldate'];
} else {
$fiscaldate = 0;
}



if(!isset($_REQUEST['printable'])) {
require_once("header.php");
} else {
require_once("common.php");

?>
<!DOCTYPE html>

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php


echo "<title>";
if (!$fiscaldate) {
echo pcrtlang("Yearly Sales/Service Tax Report for")." $year";
} else {
echo pcrtlang("Yearly Sales/Service Tax Report for Fiscal")." $year";
}
echo "</title>";
if(!isset($pcrt_stylesheet)) {
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../repair/style.css\">";
} else {
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../repair/$pcrt_stylesheet\">";
}

echo "</head><body><table style=\"width: 90%;padding:5px;\"><tr><td>";
}

require("deps.php");

perm_boot("5");

if(!isset($_REQUEST['printable'])) {
start_box();
}

echo "<table width=100%><tr><td width=75% align=left>";
if (!$fiscaldate) {
echo "<font class=text20b>".pcrtlang("Yearly Sales/Service Tax Report for")." $year</font><br><br>";
} else {
echo "<font class=text20b>".pcrtlang("Yearly Sales/Service Tax Report for Fiscal")." $year</font><br><br>";
}

if($fiscaldate) {
echo "<font class=text12b>".pcrtlang("Fiscal Year Starting")." $year-$qmonth-01</font><br><br>";
}

echo "</td><td width=25% align=right>";
if(isset($_REQUEST['printable'])) {
echo "<a href=reports.php?func=taxreport&year=$year&month=$qmonth&fiscaldate=$fiscaldate>".pcrtlang("Non-Printable")."</a>";
} else {
echo "<a href=reports.php?func=taxreport&year=$year&printable=yes&month=$qmonth&fiscaldate=$fiscaldate><img src=images/print.png border=0 align=absmiddle> ".pcrtlang("Printable")."</a>";
echo "<br><a href=reports.php?func=taxreport_csv&year=$year&month=$qmonth&fiscaldate=$fiscaldate><img src=images/csv.png border=0 align=absmiddle> ".pcrtlang("CSV")."</a>";
}


echo "</td></tr></table>";




if(!isset($_REQUEST['printable'])) {
if(!$fiscaldate) {
echo "<font class=text16bu>".pcrtlang("Year Total for")." $year &nbsp;</font><br><br>";
} else {
echo "<font class=text16bu>".pcrtlang("Year Total for Fiscal")." $year &nbsp;</font><br><br>";
}
} else {
if(!$fiscaldate) {
echo "<font class=text20bo>".pcrtlang("Year Total for")." $year &nbsp;</font><br><br>";
} else {
echo "<font class=text20bo>".pcrtlang("Year Total for Fiscal")." $year &nbsp;</font><br><br>";
}
}


echo "<table>";
$rs_find_cart_tax = "SELECT * FROM taxes";
$rs_result_tax = mysqli_query($rs_connect, $rs_find_cart_tax);
while($rs_result_tax_q = mysqli_fetch_object($rs_result_tax)) {
$rs_taxid = "$rs_result_tax_q->taxid";
$rs_taxname = "$rs_result_tax_q->taxname";
$rs_taxenabled = "$rs_result_tax_q->taxenabled";

if ($rs_taxenabled != "1") {
$ycolor="textgray12b";
} else {
$ycolor="text12b";
}

if(!$fiscaldate) {
$rs_find_cart_purt = "SELECT SUM(itemtax) AS total FROM `sold_items` WHERE YEAR(date_sold) = '$year' AND taxex = '$rs_taxid' AND sold_type != 'refund'";
} else {
$rs_find_cart_purt = "SELECT SUM(itemtax) AS total FROM `sold_items` WHERE date_sold >= '$year-$qmonth-01' AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 1 YEAR)) AND taxex = '$rs_taxid' AND sold_type != 'refund'";
}


$rs_result_purt = mysqli_query($rs_connect, $rs_find_cart_purt);
while($rs_result_pur_qt = mysqli_fetch_object($rs_result_purt)) {
$rs_taxtotal = "$rs_result_pur_qt->total";
echo "<tr><td><font class=$ycolor>$rs_taxname ".pcrtlang("Tax Collected").":</font> </td><td><font class=$ycolor>$money".mf("$rs_taxtotal")."</font></td></tr>";
}

if(!$fiscaldate) {
$rs_find_cart_purtr = "SELECT SUM(itemtax) AS total FROM `sold_items` WHERE YEAR(date_sold) = '$year' AND taxex = '$rs_taxid' AND sold_type = 'refund'";
} else {
$rs_find_cart_purtr = "SELECT SUM(itemtax) AS total FROM `sold_items` WHERE date_sold >= '$year-$qmonth-01' AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 1 YEAR)) AND taxex = '$rs_taxid' AND sold_type = 'refund'";
}
$rs_result_purtr = mysqli_query($rs_connect, $rs_find_cart_purtr);
while($rs_result_pur_qtr = mysqli_fetch_object($rs_result_purtr)) {
$rs_taxtotalr = "$rs_result_pur_qtr->total";
echo "<tr><td><font class=$ycolor>$rs_taxname ".pcrtlang("Tax Refunded").":</font> </td><td><font class=$ycolor>$money".mf("$rs_taxtotalr")."</font></td></tr>";
}

$rs_taxtotalcolminusrefund = $rs_taxtotal - $rs_taxtotalr;
echo "<tr><td><font class=$ycolor>$rs_taxname ".pcrtlang("Tax").":</font> </td><td><font class=$ycolor>$money".mf("$rs_taxtotalcolminusrefund")."</font></td></tr>";


if(!$fiscaldate) {
$rs_find_cart_pur = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE YEAR(date_sold) = '$year' AND taxex = '$rs_taxid' AND sold_type = 'purchase' ";
} else {
$rs_find_cart_pur = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE date_sold >= '$year-$qmonth-01' AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 1 YEAR)) AND taxex = '$rs_taxid' AND sold_type = 'purchase' ";
}
$rs_result_pur = mysqli_query($rs_connect, $rs_find_cart_pur);
while($rs_result_pur_q = mysqli_fetch_object($rs_result_pur)) {
$rs_total = "$rs_result_pur_q->total";
echo "<tr><td><font class=$ycolor>$rs_taxname ".pcrtlang("Tax Basis")." (purchases):</font> </td><td><font class=$ycolor>$money".mf("$rs_total")."</font></td></tr>";
}

if(!$fiscaldate) {
$rs_find_cart_purl = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE YEAR(date_sold) = '$year' AND taxex = '$rs_taxid' AND sold_type = 'labor' ";
} else {
$rs_find_cart_purl = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE date_sold >= '$year-$qmonth-01' AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 1 YEAR)) AND taxex = '$rs_taxid' AND sold_type = 'labor' ";
}
$rs_result_purl = mysqli_query($rs_connect, $rs_find_cart_purl);
while($rs_result_pur_ql = mysqli_fetch_object($rs_result_purl)) {
$rs_totall = "$rs_result_pur_ql->total";
echo "<tr><td><font class=$ycolor>$rs_taxname ".pcrtlang("Tax Basis")." (".pcrtlang("labor")."):</font> </td><td><font class=$ycolor>$money".mf("$rs_totall")."</font></td></tr>";
}

if(!$fiscaldate) {
$rs_find_cart_ref = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE YEAR(date_sold) = '$year' AND taxex = '$rs_taxid' AND sold_type = 'refund' ";
} else {
$rs_find_cart_ref = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE date_sold >= '$year-$qmonth-01' AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 1 YEAR)) AND taxex = '$rs_taxid' AND sold_type = 'refund' ";
}
$rs_result_ref = mysqli_query($rs_connect, $rs_find_cart_ref);
while($rs_result_ref_q = mysqli_fetch_object($rs_result_ref)) {
$rs_totalref = "$rs_result_ref_q->total";
echo "<tr><td><font class=$ycolor>$rs_taxname ".pcrtlang("Tax Basis")." (".pcrtlang("refunds")."):</font> </td><td><font class=$ycolor>$money".mf("$rs_totalref")."</font></td></tr>";
}

$rs_totalpur = $rs_total - $rs_totalref;
echo "<tr><td><font class=$ycolor>$rs_taxname ".pcrtlang("Tax Basis")." (".pcrtlang("purchases")."-".pcrtlang("refunds")."):</font> </td><td><font class=$ycolor>$money".mf("$rs_totalpur")."</font></td></tr>";

$rs_totallabpur = (($rs_total + $rs_totall) - $rs_totalref);
echo "<tr><td><font class=$ycolor>$rs_taxname ".pcrtlang("Tax Basis")." (".pcrtlang("labor")."+".pcrtlang("purchases")."-".pcrtlang("refunds")."):</font> </td><td><font class=$ycolor>$money".mf("$rs_totallabpur")."</font></td></tr>";
echo "<tr><td colspan=2>&nbsp;</td></tr>";



}
echo "</table>";

###quarter

if(!isset($_REQUEST['printable'])) {
if(!$fiscaldate) {
echo "<br><br><font class=text16bu>".pcrtlang("Quarter Total for")." $year &nbsp;</font><br><br>";
} else {
echo "<br><br><font class=text16bu>".pcrtlang("Quarter Total for Fiscal")." $year &nbsp;</font><br><br>";
}
} else {
if(!$fiscaldate) {
echo "<br><br><font class=text20bo>".pcrtlang("Quarter Total for")." $year &nbsp;</font><br><br>";
} else {
echo "<br><br><font class=text20bo>".pcrtlang("Quarter Total for Fiscal")." $year &nbsp;</font><br><br>";
}
}


echo "<table>";

$fiscalquarter[1] = "date_sold >= '$year-$qmonth-01' AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 3 MONTH))";
$fiscalquarter[2] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 3 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 6 MONTH))";
$fiscalquarter[3] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 6 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 9 MONTH))";
$fiscalquarter[4] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 9 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 1 YEAR))";


$qrtr = 1;

while ($qrtr < 5) {

$rs_find_cart_tax2 = "SELECT * FROM taxes";
$rs_result_tax2 = mysqli_query($rs_connect, $rs_find_cart_tax2);

while($rs_result_tax_q2 = mysqli_fetch_object($rs_result_tax2)) {
$rs_taxid2 = "$rs_result_tax_q2->taxid";
$rs_taxname2 = "$rs_result_tax_q2->taxname";
$rs_taxenabled2 = "$rs_result_tax_q2->taxenabled";

if ($rs_taxenabled2 != '1') {
$ycolor2="textgray12b";
} else {
$ycolor2="text12b";
}

if(!$fiscaldate) {
$rs_find_cart_purt = "SELECT SUM(itemtax) AS total FROM `sold_items` WHERE QUARTER(date_sold) = '$qrtr' AND YEAR(date_sold) = '$year' AND taxex = '$rs_taxid2' AND sold_type != 'refund'";
} else {
$rs_find_cart_purt = "SELECT SUM(itemtax) AS total FROM `sold_items` WHERE $fiscalquarter[$qrtr] AND taxex = '$rs_taxid2' AND sold_type != 'refund'";
}


$rs_result_purt = mysqli_query($rs_connect, $rs_find_cart_purt);
while($rs_result_pur_qt = mysqli_fetch_object($rs_result_purt)) {
$rs_taxtotal = "$rs_result_pur_qt->total";
echo "<tr><td><font class=$ycolor>".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Collected").":</font> </td><td><font class=$ycolor>$money".mf("$rs_taxtotal")."</font></td></tr>";
}

if(!$fiscaldate) {
$rs_find_cart_purtr = "SELECT SUM(itemtax) AS total FROM `sold_items` WHERE QUARTER(date_sold) = '$qrtr' AND YEAR(date_sold) = '$year' AND taxex = '$rs_taxid2' AND sold_type = 'refund'";
} else {
$rs_find_cart_purtr = "SELECT SUM(itemtax) AS total FROM `sold_items` WHERE $fiscalquarter[$qrtr] AND taxex = '$rs_taxid2' AND sold_type = 'refund'";
}
$rs_result_purtr = mysqli_query($rs_connect, $rs_find_cart_purtr);
while($rs_result_pur_qtr = mysqli_fetch_object($rs_result_purtr)) {
$rs_taxtotalr = "$rs_result_pur_qtr->total";
echo "<tr><td><font class=$ycolor>".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Refunded").":</font> </td><td><font class=$ycolor>$money".mf("$rs_taxtotalr")."</font></td></tr>";
}

$rs_taxtotalcolminusrefund = $rs_taxtotal - $rs_taxtotalr;
echo "<tr><td><font class=$ycolor>".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax").":</font> </td><td><font class=$ycolor>$money".mf("$rs_taxtotalcolminusrefund")."</font></td></tr>";


if(!$fiscaldate) {
$rs_find_cart_pur = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE QUARTER(date_sold) = '$qrtr' AND YEAR(date_sold) = '$year' AND taxex = '$rs_taxid2' AND sold_type = 'purchase'";
} else {
$rs_find_cart_pur = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalquarter[$qrtr] AND taxex = '$rs_taxid2' AND sold_type = 'purchase'";
}
$rs_result_pur = mysqli_query($rs_connect, $rs_find_cart_pur);
while($rs_result_pur_q = mysqli_fetch_object($rs_result_pur)) {
$rs_total = "$rs_result_pur_q->total";
echo "<tr><td><font class=$ycolor>".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Basis")." (".pcrtlang("purchases")."):</font> </td><td><font class=$ycolor>$money".mf("$rs_total")."</font></td></tr>";
}

if(!$fiscaldate) {
$rs_find_cart_purl = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE QUARTER(date_sold) = '$qrtr' AND YEAR(date_sold) = '$year' AND taxex = '$rs_taxid2' AND sold_type = 'labor' ";
} else {
$rs_find_cart_purl = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalquarter[$qrtr] AND taxex = '$rs_taxid2' AND sold_type = 'labor' ";
}
$rs_result_purl = mysqli_query($rs_connect, $rs_find_cart_purl);
while($rs_result_pur_ql = mysqli_fetch_object($rs_result_purl)) {
$rs_totall = "$rs_result_pur_ql->total";
echo "<tr><td><font class=$ycolor>".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Basis")." (".pcrtlang("labor")."):</font> </td><td><font class=$ycolor>$money".mf("$rs_totall")."</font></td></tr>";
}

if(!$fiscaldate) {
$rs_find_cart_ref = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE QUARTER(date_sold) = '$qrtr' AND YEAR(date_sold) = '$year' AND taxex = '$rs_taxid2' AND sold_type = 'refund' ";
} else {
$rs_find_cart_ref = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalquarter[$qrtr] AND taxex = '$rs_taxid2' AND sold_type = 'refund' ";
}
$rs_result_ref = mysqli_query($rs_connect, $rs_find_cart_ref);
while($rs_result_ref_q = mysqli_fetch_object($rs_result_ref)) {
$rs_totalref = "$rs_result_ref_q->total";
echo "<tr><td><font class=$ycolor>".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Basis")." (".pcrtlang("refunds")."):</font> </td><td><font class=$ycolor>$money".mf("$rs_totalref")."</font></td></tr>";
}

$rs_totalpur = $rs_total - $rs_totalref;
echo "<tr><td><font class=$ycolor>".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Basis")." (".pcrtlang("purchases")."-".pcrtlang("refunds")."):</font> </td><td><font class=$ycolor>$money".mf("$rs_totalpur")."</font></td></tr>";

$rs_totallabpur = (($rs_total + $rs_totall) - $rs_totalref);
echo "<tr><td><font class=$ycolor>".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Basis")." (".pcrtlang("labor")."+".pcrtlang("purchases")."-".pcrtlang("refunds")."):</font> </td><td><font class=$ycolor>$money".mf("$rs_totallabpur")."</font></td></tr>";
echo "<tr><td colspan=2>&nbsp;</td></tr>";



}
echo "<tr><td colspan=2>&nbsp;</td></tr>";
$qrtr++;

}
echo "</table>";





####month 

if(!isset($_REQUEST['printable'])) {
if(!$fiscaldate) {
echo "<br><br><font class=text16bu>".pcrtlang("Monthly Totals for")." $year &nbsp;</font><br><br>";
} else {
echo "<br><br><font class=text16bu>".pcrtlang("Monthly Totals for Fiscal")." $year &nbsp;</font><br><br>";
}
} else {
if(!$fiscaldate) {
echo "<br><br><font class=text20bo>".pcrtlang("Monthly Totals for")." $year &nbsp;</font><br><br>";
} else {
echo "<br><br><font class=text20bo>".pcrtlang("Monthly Totals for Fiscal")." $year &nbsp;</font><br><br>";
}
}


echo "<table>";

$fiscalmonth[1] = "date_sold >= '$year-$qmonth-01' AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 1 MONTH))";
$fiscalmonth[2] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 1 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 2 MONTH))";
$fiscalmonth[3] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 2 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 3 MONTH))";
$fiscalmonth[4] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 3 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 4 MONTH))";
$fiscalmonth[5] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 4 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 5 MONTH))";
$fiscalmonth[6] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 5 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 6 MONTH))";
$fiscalmonth[7] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 6 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 7 MONTH))";
$fiscalmonth[8] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 7 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 8 MONTH))";
$fiscalmonth[9] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 8 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 9 MONTH))";
$fiscalmonth[10] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 9 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 10 MONTH))";
$fiscalmonth[11] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 10 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 11 MONTH))";
$fiscalmonth[12] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 11 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 12 MONTH))";

$month = 1;

while ($month < 13) {

$rs_find_cart_tax3 = "SELECT * FROM taxes";
$rs_result_tax3 = mysqli_query($rs_connect, $rs_find_cart_tax3);

while($rs_result_tax_q3 = mysqli_fetch_object($rs_result_tax3)) {
$rs_taxid3 = "$rs_result_tax_q3->taxid";
$rs_taxname3 = "$rs_result_tax_q3->taxname";
$rs_taxenabled3 = "$rs_result_tax_q3->taxenabled";

if ($rs_taxenabled3 != '1') {
$ycolor3 = "textgray12b";
} else {
$ycolor3 = "text12b";
}

if(!$fiscaldate) {
$rs_find_cart_purt = "SELECT SUM(itemtax) AS total FROM `sold_items` WHERE MONTH(date_sold) = '$month' AND YEAR(date_sold) = '$year' AND taxex = '$rs_taxid3' AND sold_type != 'refund'";
} else {
$rs_find_cart_purt = "SELECT SUM(itemtax) AS total FROM `sold_items` WHERE $fiscalmonth[$month] AND taxex = '$rs_taxid3' AND sold_type != 'refund'";
}
$rs_result_purt = mysqli_query($rs_connect, $rs_find_cart_purt);
while($rs_result_pur_qt = mysqli_fetch_object($rs_result_purt)) {
$rs_taxtotal = "$rs_result_pur_qt->total";
echo "<tr><td><font class=$ycolor>".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Collected").":</font> </td><td><font class=$ycolor>$money".mf("$rs_taxtotal")."</font></td></tr>";
}

if(!$fiscaldate) {
$rs_find_cart_purtr = "SELECT SUM(itemtax) AS total FROM `sold_items` WHERE MONTH(date_sold) = '$month' AND YEAR(date_sold) = '$year' AND taxex = '$rs_taxid3' AND sold_type = 'refund'";
} else {
$rs_find_cart_purtr = "SELECT SUM(itemtax) AS total FROM `sold_items` WHERE $fiscalmonth[$month] AND taxex = '$rs_taxid3' AND sold_type = 'refund'";
}
$rs_result_purtr = mysqli_query($rs_connect, $rs_find_cart_purtr);
while($rs_result_pur_qtr = mysqli_fetch_object($rs_result_purtr)) {
$rs_taxtotalr = "$rs_result_pur_qtr->total";
echo "<tr><td><font class=$ycolor>".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Refunded").":</font> </td><td><font class=$ycolor>$money".mf("$rs_taxtotalr")."</font></td></tr>";
}

$rs_taxtotalcolminusrefund = $rs_taxtotal - $rs_taxtotalr;
echo "<tr><td><font class=$ycolor>".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax").":</font> </td><td><font class=$ycolor>$money".mf("$rs_taxtotalcolminusrefund")."</font></td></tr>";


if(!$fiscaldate) {
$rs_find_cart_pur = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE MONTH(date_sold) = '$month' AND YEAR(date_sold) = '$year' AND taxex = '$rs_taxid3' AND sold_type = 'purchase' ";
} else {
$rs_find_cart_pur = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalmonth[$month] AND taxex = '$rs_taxid3' AND sold_type = 'purchase' ";
}
$rs_result_pur = mysqli_query($rs_connect, $rs_find_cart_pur);
while($rs_result_pur_q = mysqli_fetch_object($rs_result_pur)) {
$rs_total = "$rs_result_pur_q->total";
echo "<tr><td><font class=$ycolor>".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Basis")." (".pcrtlang("purchases")."):</font> </td><td><font class=$ycolor>$money".mf("$rs_total")."</font></td></tr>";
}

if(!$fiscaldate) {
$rs_find_cart_purl = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE MONTH(date_sold) = '$month' AND YEAR(date_sold) = '$year' AND taxex = '$rs_taxid3' AND sold_type = 'labor' ";
} else {
$rs_find_cart_purl = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalmonth[$month] AND taxex = '$rs_taxid3' AND sold_type = 'labor' ";
}
$rs_result_purl = mysqli_query($rs_connect, $rs_find_cart_purl);
while($rs_result_pur_ql = mysqli_fetch_object($rs_result_purl)) {
$rs_totall = "$rs_result_pur_ql->total";
echo "<tr><td><font class=$ycolor>".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Basis")." (".pcrtlang("labor")."):</font> </td><td><font class=$ycolor>$money".mf("$rs_totall")."</font></td></tr>";
}

if(!$fiscaldate) {
$rs_find_cart_ref = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE MONTH(date_sold) = '$month' AND YEAR(date_sold) = '$year' AND taxex = '$rs_taxid3' AND sold_type = 'refund' ";
} else {
$rs_find_cart_ref = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalmonth[$month] AND taxex = '$rs_taxid3' AND sold_type = 'refund' ";
}
$rs_result_ref = mysqli_query($rs_connect, $rs_find_cart_ref);
while($rs_result_ref_q = mysqli_fetch_object($rs_result_ref)) {
$rs_totalref = "$rs_result_ref_q->total";
echo "<tr><td><font class=$ycolor>".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Basis")." (".pcrtlang("refunds")."):</font> </td><td><font class=$ycolor>$money".mf("$rs_totalref")."</font></td></tr>";
}

$rs_totalpur = $rs_total - $rs_totalref;
echo "<tr><td><font class=$ycolor>".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Basis")." (".pcrtlang("purchases")."-".pcrtlang("refunds")."):</font> </td><td><font class=$ycolor>$money".mf("$rs_totalpur")."</font></td></tr>";

$rs_totallabpur = (($rs_total + $rs_totall) - $rs_totalref);
echo "<tr><td><font class=$ycolor>".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Basis")." (".pcrtlang("labor")."+".pcrtlang("purchases")."-".pcrtlang("refunds")."):</font> </td><td><font class=$ycolor>$money".mf("$rs_totallabpur")."</font></td></tr>";
echo "<tr><td colspan=2>&nbsp;</td></tr>";




}
echo "<tr><td colspan=2>&nbsp;</td></tr>";
$month++;

}
echo "</table>";

if(!isset($_REQUEST['printable'])) {
stop_box();
}

if(!isset($_REQUEST['printable'])) {
require("footer.php");
} else {
echo "</td></tr></table></body></html>";
}



}


######################################################################################################################

function taxreportnew() {

if (array_key_exists('year',$_REQUEST)) {
if ($_REQUEST['year'] != "") {
$year = $_REQUEST['year'];
} else {
$year = date("Y");
}
} else {
$year = date("Y");
}

if (array_key_exists('month',$_REQUEST)) {
if ($_REQUEST['month'] != "") {
$qmonth = $_REQUEST['month'];
} else {
$qmonth = date("M");
}
} else {
$qmonth = date("M");
}



if (array_key_exists('fiscaldate',$_REQUEST)) {
$fiscaldate = $_REQUEST['fiscaldate'];
} else {
$fiscaldate = 0;
}



if(!isset($_REQUEST['printable'])) {
require_once("header.php");
} else {
require_once("common.php");

?>
<!DOCTYPE html>

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php


echo "<title>";
if (!$fiscaldate) {
echo pcrtlang("Yearly Sales/Service Tax Report for")." $year";
} else {
echo pcrtlang("Yearly Sales/Service Tax Report for Fiscal")." $year";
}
echo "</title>";
if(!isset($pcrt_stylesheet)) {
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../repair/style.css\">";
} else {
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../repair/$pcrt_stylesheet\">";
}

echo "</head><body><table style=\"width: 90%;padding:5px;\"><tr><td>";
}

require("deps.php");

perm_boot("5");

if(!isset($_REQUEST['printable'])) {
start_box();
}

echo "<table width=100%><tr><td width=75% align=left>";
if (!$fiscaldate) {
echo "<font class=text20b>".pcrtlang("Yearly Sales/Service Tax Report for")." $year</font><br><br>";
} else {
echo "<font class=text20b>".pcrtlang("Yearly Sales/Service Tax Report for Fiscal")." $year</font><br><br>";
}

if($fiscaldate) {
echo "<font class=text12b>".pcrtlang("Fiscal Year Starting")." $year-$qmonth-01</font><br><br>";
}

echo "</td><td width=25% align=right>";
if(isset($_REQUEST['printable'])) {
echo "<a href=reports.php?func=taxreportnew&year=$year&month=$qmonth&fiscaldate=$fiscaldate>".pcrtlang("Non-Printable")."</a>";
} else {
echo "<a href=reports.php?func=taxreportnew&year=$year&printable=yes&month=$qmonth&fiscaldate=$fiscaldate><img src=images/print.png border=0 align=absmiddle> ".pcrtlang("Printable")."</a>";
echo "<br><a href=reports.php?func=taxreportnew_csv&year=$year&month=$qmonth&fiscaldate=$fiscaldate><img src=images/csv.png border=0 align=absmiddle> ".pcrtlang("CSV")."</a>";
}


echo "</td></tr></table>";




if(!isset($_REQUEST['printable'])) {
if(!$fiscaldate) {
echo "<font class=text16bu>".pcrtlang("Year Total for")." $year &nbsp;</font><br><br>";
} else {
echo "<font class=text16bu>".pcrtlang("Year Total for Fiscal")." $year &nbsp;</font><br><br>";
}
} else {
if(!$fiscaldate) {
echo "<font class=text20bo>".pcrtlang("Year Total for")." $year &nbsp;</font><br><br>";
} else {
echo "<font class=text20bo>".pcrtlang("Year Total for Fiscal")." $year &nbsp;</font><br><br>";
}
}


echo "<table>";
$rs_find_cart_tax = "SELECT * FROM taxes WHERE isgrouprate != '1'";
$rs_result_tax = mysqli_query($rs_connect, $rs_find_cart_tax);
while($rs_result_tax_q = mysqli_fetch_object($rs_result_tax)) {
$rs_taxid = "$rs_result_tax_q->taxid";
$rs_taxname = "$rs_result_tax_q->taxname";
$rs_taxenabled = "$rs_result_tax_q->taxenabled";


$groupsbelong = array();
$groupsbelong[] = "$rs_taxid";
$rs_ql_isingroup = "SELECT * FROM taxes WHERE isgrouprate = '1'";
$rs_result1_isingroup = mysqli_query($rs_connect, $rs_ql_isingroup);
while($rs_result_q1_isingroup = mysqli_fetch_object($rs_result1_isingroup)) {
$compositerate = "$rs_result_q1_isingroup->compositerate";
$gtaxid = "$rs_result_q1_isingroup->taxid";
$subarray = unserialize($compositerate);
if (in_array($rs_taxid,$subarray)) {
$groupsbelong[] = $gtaxid;
}
}



if ($rs_taxenabled != "1") {
$ycolor="textgray12b";
} else {
$ycolor="text12b";
}

$taxids = implode(',',$groupsbelong);  


if(!$fiscaldate) {
$rs_find_cart_purt_purchase = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE YEAR(date_sold) = '$year' AND sold_type = 'purchase' AND taxex IN ($taxids)";
$rs_find_cart_purt_labor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE YEAR(date_sold) = '$year' AND sold_type = 'labor' AND taxex IN ($taxids)";
$rs_find_cart_purt_refund = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE YEAR(date_sold) = '$year' AND sold_type = 'refund' AND taxex IN ($taxids)";
$rs_find_cart_purt_refundlabor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE YEAR(date_sold) = '$year' AND sold_type = 'refundlabor' AND taxex IN ($taxids)";
} else {
$rs_find_cart_purt_purchase = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE date_sold >= '$year-$qmonth-01' AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 1 YEAR)) AND sold_type = 'purchase' AND taxex IN ($taxids)";
$rs_find_cart_purt_labor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE date_sold >= '$year-$qmonth-01' AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 1 YEAR)) AND sold_type = 'labor' AND taxex IN ($taxids)";
$rs_find_cart_purt_refund = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE date_sold >= '$year-$qmonth-01' AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 1 YEAR)) AND sold_type = 'refund' AND taxex IN ($taxids)";
$rs_find_cart_purt_refundlabor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE date_sold >= '$year-$qmonth-01' AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 1 YEAR)) AND sold_type = 'refundlabor' AND taxex IN ($taxids)";
}


$rs_result_purt_purchase = mysqli_query($rs_connect, $rs_find_cart_purt_purchase);
$rs_result_pur_purchase_qt = mysqli_fetch_object($rs_result_purt_purchase);
$rs_totalsales_purchase = "$rs_result_pur_purchase_qt->total";
$salestaxrate = getsalestaxrate($rs_taxid);
$rs_totaltax_purchase = $rs_totalsales_purchase * $salestaxrate;

$rs_result_purt_labor = mysqli_query($rs_connect, $rs_find_cart_purt_labor);
$rs_result_pur_labor_qt = mysqli_fetch_object($rs_result_purt_labor);
$rs_totalsales_labor = "$rs_result_pur_labor_qt->total";
$servicetaxrate = getservicetaxrate($rs_taxid);
$rs_totaltax_labor = $rs_totalsales_labor * $servicetaxrate;

$rs_result_purt_refund = mysqli_query($rs_connect, $rs_find_cart_purt_refund);
$rs_result_pur_refund_qt = mysqli_fetch_object($rs_result_purt_refund);
$rs_totalsales_refund = "$rs_result_pur_refund_qt->total";
$rs_totaltax_refund = $rs_totalsales_refund * $salestaxrate;

$rs_result_purt_refundlabor = mysqli_query($rs_connect, $rs_find_cart_purt_refundlabor);
$rs_result_pur_refundlabor_qt = mysqli_fetch_object($rs_result_purt_refundlabor);
$rs_totalsales_refundlabor = "$rs_result_pur_refundlabor_qt->total";
$rs_totaltax_refundlabor = $rs_totalsales_refundlabor * $servicetaxrate;


$rs_taxtotal = $rs_totaltax_purchase + $rs_totaltax_labor;
$rs_taxtotalrefund = $rs_totaltax_refund + $rs_totaltax_refundlabor;


echo "<tr><td><font class=$ycolor>$rs_taxname ".pcrtlang("Tax Collected").":</font> </td><td><font class=$ycolor>$money".mf("$rs_taxtotal")."</font></td></tr>";
echo "<tr><td><font class=$ycolor>$rs_taxname ".pcrtlang("Tax Refunded").":</font> </td><td><font class=$ycolor>$money".mf("$rs_taxtotalrefund")."</font></td></tr>";

$rs_taxtotalcolminusrefund = $rs_taxtotal - $rs_taxtotalrefund;

echo "<tr><td><font class=$ycolor>$rs_taxname ".pcrtlang("Tax").":</font> </td><td><font class=$ycolor>$money".mf("$rs_taxtotalcolminusrefund")."</font></td></tr>";
echo "<tr><td><font class=$ycolor>$rs_taxname ".pcrtlang("Tax Basis")." (".pcrtlang("purchases")."):</font> </td><td><font class=$ycolor>$money".mf("$rs_totalsales_purchase")."</font></td></tr>";
echo "<tr><td><font class=$ycolor>$rs_taxname ".pcrtlang("Tax Basis")." (".pcrtlang("labor")."):</font> </td><td><font class=$ycolor>$money".mf("$rs_totalsales_labor")."</font></td></tr>";
echo "<tr><td><font class=$ycolor>$rs_taxname ".pcrtlang("Tax Basis")." (".pcrtlang("sales refunds")."):</font> </td><td><font class=$ycolor>$money".mf("$rs_totalsales_refund")."</font></td></tr>";
echo "<tr><td><font class=$ycolor>$rs_taxname ".pcrtlang("Tax Basis")." (".pcrtlang("labor refunds")."):</font> </td><td><font class=$ycolor>$money".mf("$rs_totalsales_refundlabor")."</font></td></tr>";


$rs_totalpur = $rs_totalsales_purchase - $rs_totalsales_refund;

echo "<tr><td><font class=$ycolor>$rs_taxname ".pcrtlang("Tax Basis")." (".pcrtlang("purchases")."-".pcrtlang("sales refunds")."):</font> </td><td><font class=$ycolor>$money".mf("$rs_totalpur")."</font></td></tr>";

$rs_totallabpur = (($rs_totalsales_purchase + $rs_totalsales_labor) - ($rs_totalsales_refund + $rs_totalsales_refundlabor));
echo "<tr><td><font class=$ycolor>$rs_taxname ".pcrtlang("Tax Basis")." (".pcrtlang("labor")."+".pcrtlang("purchases")."-".pcrtlang("sales refunds")."+".pcrtlang("labor refunds")."):</font> </td><td><font class=$ycolor>$money".mf("$rs_totallabpur")."</font></td></tr>";
echo "<tr><td colspan=2>&nbsp;</td></tr>";

}
echo "</table>";

###quarter

if(!isset($_REQUEST['printable'])) {
if(!$fiscaldate) {
echo "<br><br><font class=text16bu>".pcrtlang("Quarter Total for")." $year &nbsp;</font><br><br>";
} else {
echo "<br><br><font class=text16bu>".pcrtlang("Quarter Total for Fiscal")." $year &nbsp;</font><br><br>";
}
} else {
if(!$fiscaldate) {
echo "<br><br><font class=text20bo>".pcrtlang("Quarter Total for")." $year &nbsp;</font><br><br>";
} else {
echo "<br><br><font class=text20bo>".pcrtlang("Quarter Total for Fiscal")." $year &nbsp;</font><br><br>";
}
}


echo "<table>";

$fiscalquarter[1] = "date_sold >= '$year-$qmonth-01' AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 3 MONTH))";
$fiscalquarter[2] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 3 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 6 MONTH))";
$fiscalquarter[3] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 6 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 9 MONTH))";
$fiscalquarter[4] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 9 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 1 YEAR))";


$qrtr = 1;

while ($qrtr < 5) {

$rs_find_cart_tax2 = "SELECT * FROM taxes WHERE isgrouprate != '1'";
$rs_result_tax2 = mysqli_query($rs_connect, $rs_find_cart_tax2);

while($rs_result_tax_q2 = mysqli_fetch_object($rs_result_tax2)) {
$rs_taxid2 = "$rs_result_tax_q2->taxid";
$rs_taxname2 = "$rs_result_tax_q2->taxname";
$rs_taxenabled2 = "$rs_result_tax_q2->taxenabled";


$groupsbelong = array();
$groupsbelong[] = "$rs_taxid2";
$rs_ql_isingroup = "SELECT * FROM taxes WHERE isgrouprate = '1'";
$rs_result1_isingroup = mysqli_query($rs_connect, $rs_ql_isingroup);
while($rs_result_q1_isingroup = mysqli_fetch_object($rs_result1_isingroup)) {
$compositerate = "$rs_result_q1_isingroup->compositerate";
$gtaxid = "$rs_result_q1_isingroup->taxid";
$subarray = unserialize($compositerate);
if (in_array($rs_taxid2,$subarray)) {
$groupsbelong[] = $gtaxid;
}
}

if ($rs_taxenabled2 != '1') {
$ycolor2="textgray12b";
} else {
$ycolor2="text12b";
}

$taxids = implode(',',$groupsbelong);

if(!$fiscaldate) {
$rs_find_cart_purt_purchase = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE QUARTER(date_sold) = '$qrtr' AND YEAR(date_sold) = '$year' AND sold_type = 'purchase' AND taxex IN ($taxids)";
$rs_find_cart_purt_labor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE QUARTER(date_sold) = '$qrtr' AND YEAR(date_sold) = '$year' AND sold_type = 'labor' AND taxex IN ($taxids)";
$rs_find_cart_purt_refund = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE QUARTER(date_sold) = '$qrtr' AND YEAR(date_sold) = '$year' AND sold_type = 'refund' AND taxex IN ($taxids)";
$rs_find_cart_purt_refundlabor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE QUARTER(date_sold) = '$qrtr' AND YEAR(date_sold) = '$year' AND sold_type = 'refundlabor' AND taxex IN ($taxids)";
} else {
$rs_find_cart_purt_purchase = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalquarter[$qrtr] AND sold_type = 'purchase' AND taxex IN ($taxids)";
$rs_find_cart_purt_labor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalquarter[$qrtr] AND sold_type = 'labor' AND taxex IN ($taxids)";
$rs_find_cart_purt_refund = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalquarter[$qrtr] AND sold_type = 'refund' AND taxex IN ($taxids)";
$rs_find_cart_purt_refundlabor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalquarter[$qrtr] AND sold_type = 'refundlabor' AND taxex IN ($taxids)";
}


$rs_result_purt_purchase = mysqli_query($rs_connect, $rs_find_cart_purt_purchase);
$rs_result_pur_purchase_qt = mysqli_fetch_object($rs_result_purt_purchase);
$rs_totalsales_purchase = "$rs_result_pur_purchase_qt->total";
$salestaxrate = getsalestaxrate($rs_taxid2);
$rs_totaltax_purchase = $rs_totalsales_purchase * $salestaxrate;

$rs_result_purt_labor = mysqli_query($rs_connect, $rs_find_cart_purt_labor);
$rs_result_pur_labor_qt = mysqli_fetch_object($rs_result_purt_labor);
$rs_totalsales_labor = "$rs_result_pur_labor_qt->total";
$servicetaxrate = getservicetaxrate($rs_taxid2);
$rs_totaltax_labor = $rs_totalsales_labor * $servicetaxrate;

$rs_result_purt_refund = mysqli_query($rs_connect, $rs_find_cart_purt_refund);
$rs_result_pur_refund_qt = mysqli_fetch_object($rs_result_purt_refund);
$rs_totalsales_refund = "$rs_result_pur_refund_qt->total";
$rs_totaltax_refund = $rs_totalsales_refund * $salestaxrate;

$rs_result_purt_refundlabor = mysqli_query($rs_connect, $rs_find_cart_purt_refundlabor);
$rs_result_pur_refundlabor_qt = mysqli_fetch_object($rs_result_purt_refundlabor);
$rs_totalsales_refundlabor = "$rs_result_pur_refundlabor_qt->total";
$rs_totaltax_refundlabor = $rs_totalsales_refundlabor * $servicetaxrate;



$rs_taxtotal = $rs_totaltax_purchase + $rs_totaltax_labor;
$rs_taxtotalrefund = $rs_totaltax_refund + $rs_totaltax_refundlabor;

echo "<tr><td><font class=$ycolor>".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Collected").":</font> </td><td><font class=$ycolor>$money".mf("$rs_taxtotal")."</font></td></tr>";
echo "<tr><td><font class=$ycolor>".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Refunded").":</font> </td><td><font class=$ycolor>$money".mf("$rs_taxtotalrefund")."</font></td></tr>";

$rs_taxtotalcolminusrefund = $rs_taxtotal - $rs_taxtotalrefund;
echo "<tr><td><font class=$ycolor>".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax").":</font> </td><td><font class=$ycolor>$money".mf("$rs_taxtotalcolminusrefund")."</font></td></tr>";
echo "<tr><td><font class=$ycolor>".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Basis")." (".pcrtlang("purchases")."):</font> </td><td><font class=$ycolor>$money".mf("$rs_totalsales_purchase")."</font></td></tr>";
echo "<tr><td><font class=$ycolor>".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Basis")." (".pcrtlang("labor")."):</font> </td><td><font class=$ycolor>$money".mf("$rs_totalsales_labor")."</font></td></tr>";
echo "<tr><td><font class=$ycolor>".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Basis")." (".pcrtlang("sales refunds")."):</font> </td><td><font class=$ycolor>$money".mf("$rs_totalsales_refund")."</font></td></tr>";
echo "<tr><td><font class=$ycolor>".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Basis")." (".pcrtlang("labor refunds")."):</font> </td><td><font class=$ycolor>$money".mf("$rs_totalsales_refundlabor")."</font></td></tr>";

$rs_totalpur = $rs_totalsales_purchase - $rs_totalsales_refund;
echo "<tr><td><font class=$ycolor>".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Basis")." (".pcrtlang("purchases")."-".pcrtlang("refunds")."):</font> </td><td><font class=$ycolor>$money".mf("$rs_totalpur")."</font></td></tr>";

$rs_totallabpur = (($rs_totalsales_purchase + $rs_totalsales_labor) - ($rs_totalsales_refund + $rs_totalsales_refundlabor));
echo "<tr><td><font class=$ycolor>".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Basis")." (".pcrtlang("labor")."+".pcrtlang("purchases")."-".pcrtlang("sales refunds")."+".pcrtlang("labor refunds")."):</font> </td><td><font class=$ycolor>$money".mf("$rs_totallabpur")."</font></td></tr>";
echo "<tr><td colspan=2>&nbsp;</td></tr>";



}
echo "<tr><td colspan=2>&nbsp;</td></tr>";
$qrtr++;

}
echo "</table>";





####month 

if(!isset($_REQUEST['printable'])) {
if(!$fiscaldate) {
echo "<br><br><font class=text16bu>".pcrtlang("Monthly Totals for")." $year &nbsp;</font><br><br>";
} else {
echo "<br><br><font class=text16bu>".pcrtlang("Monthly Totals for Fiscal")." $year &nbsp;</font><br><br>";
}
} else {
if(!$fiscaldate) {
echo "<br><br><font class=text20bo>".pcrtlang("Monthly Totals for")." $year &nbsp;</font><br><br>";
} else {
echo "<br><br><font class=text20bo>".pcrtlang("Monthly Totals for Fiscal")." $year &nbsp;</font><br><br>";
}
}


echo "<table>";

$fiscalmonth[1] = "date_sold >= '$year-$qmonth-01' AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 1 MONTH))";
$fiscalmonth[2] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 1 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 2 MONTH))";
$fiscalmonth[3] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 2 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 3 MONTH))";
$fiscalmonth[4] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 3 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 4 MONTH))";
$fiscalmonth[5] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 4 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 5 MONTH))";
$fiscalmonth[6] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 5 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 6 MONTH))";
$fiscalmonth[7] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 6 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 7 MONTH))";
$fiscalmonth[8] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 7 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 8 MONTH))";
$fiscalmonth[9] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 8 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 9 MONTH))";
$fiscalmonth[10] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 9 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 10 MONTH))";
$fiscalmonth[11] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 10 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 11 MONTH))";
$fiscalmonth[12] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 11 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 12 MONTH))";

$month = 1;

while ($month < 13) {

$rs_find_cart_tax3 = "SELECT * FROM taxes WHERE isgrouprate != '1'";
$rs_result_tax3 = mysqli_query($rs_connect, $rs_find_cart_tax3);

while($rs_result_tax_q3 = mysqli_fetch_object($rs_result_tax3)) {
$rs_taxid3 = "$rs_result_tax_q3->taxid";
$rs_taxname3 = "$rs_result_tax_q3->taxname";
$rs_taxenabled3 = "$rs_result_tax_q3->taxenabled";

$groupsbelong = array();
$groupsbelong[] = "$rs_taxid3";
$rs_ql_isingroup = "SELECT * FROM taxes WHERE isgrouprate = '1'";
$rs_result1_isingroup = mysqli_query($rs_connect, $rs_ql_isingroup);
while($rs_result_q1_isingroup = mysqli_fetch_object($rs_result1_isingroup)) {
$compositerate = "$rs_result_q1_isingroup->compositerate";
$gtaxid = "$rs_result_q1_isingroup->taxid";
$subarray = unserialize($compositerate);
if (in_array($rs_taxid3,$subarray)) {
$groupsbelong[] = $gtaxid;
}
}

$taxids = implode(',',$groupsbelong);

if ($rs_taxenabled3 != '1') {
$ycolor3 = "textgray12b";
} else {
$ycolor3 = "text12b";
}

if(!$fiscaldate) {
$rs_find_cart_purt_purchase = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE MONTH(date_sold) = '$month' AND YEAR(date_sold) = '$year' AND sold_type = 'purchase' AND taxex IN ($taxids)";
$rs_find_cart_purt_labor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE MONTH(date_sold) = '$month' AND YEAR(date_sold) = '$year' AND sold_type = 'labor' AND taxex IN ($taxids)";
$rs_find_cart_purt_refund = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE MONTH(date_sold) = '$month' AND YEAR(date_sold) = '$year' AND sold_type = 'refund' AND taxex IN ($taxids)";
$rs_find_cart_purt_refundlabor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE MONTH(date_sold) = '$month' AND YEAR(date_sold) = '$year' AND sold_type = 'refundlabor' AND taxex IN ($taxids)";
} else {
$rs_find_cart_purt_purchase = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalmonth[$month] AND taxex = '$rs_taxid3' AND sold_type = 'purchase' AND taxex IN ($taxids)";
$rs_find_cart_purt_labor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalmonth[$month] AND taxex = '$rs_taxid3' AND sold_type = 'labor' AND taxex IN ($taxids)";
$rs_find_cart_purt_refund = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalmonth[$month] AND taxex = '$rs_taxid3' AND sold_type = 'refund' AND taxex IN ($taxids)";
$rs_find_cart_purt_refundlabor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalmonth[$month] AND taxex = '$rs_taxid3' AND sold_type = 'refundlabor' AND taxex IN ($taxids)";
}

$rs_result_purt_purchase = mysqli_query($rs_connect, $rs_find_cart_purt_purchase);
$rs_result_pur_purchase_qt = mysqli_fetch_object($rs_result_purt_purchase);
$rs_totalsales_purchase = "$rs_result_pur_purchase_qt->total";
$salestaxrate = getsalestaxrate($rs_taxid3);
$rs_totaltax_purchase = $rs_totalsales_purchase * $salestaxrate;

$rs_result_purt_labor = mysqli_query($rs_connect, $rs_find_cart_purt_labor);
$rs_result_pur_labor_qt = mysqli_fetch_object($rs_result_purt_labor);
$rs_totalsales_labor = "$rs_result_pur_labor_qt->total";
$servicetaxrate = getservicetaxrate($rs_taxid3);
$rs_totaltax_labor = $rs_totalsales_labor * $servicetaxrate;

$rs_result_purt_refund = mysqli_query($rs_connect, $rs_find_cart_purt_refund);
$rs_result_pur_refund_qt = mysqli_fetch_object($rs_result_purt_refund);
$rs_totalsales_refund = "$rs_result_pur_refund_qt->total";
$rs_totaltax_refund = $rs_totalsales_refund * $salestaxrate;

$rs_result_purt_refundlabor = mysqli_query($rs_connect, $rs_find_cart_purt_refundlabor);
$rs_result_pur_refundlabor_qt = mysqli_fetch_object($rs_result_purt_refundlabor);
$rs_totalsales_refundlabor = "$rs_result_pur_refundlabor_qt->total";
$rs_totaltax_refundlabor = $rs_totalsales_refundlabor * $servicetaxrate;

$rs_taxtotal = $rs_totaltax_purchase + $rs_totaltax_labor;
$rs_taxtotalrefund = $rs_totaltax_refund + $rs_totaltax_refundlabor;

echo "<tr><td><font class=$ycolor>".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Collected").":</font> </td><td><font class=$ycolor>$money".mf("$rs_taxtotal")."</font></td></tr>";
echo "<tr><td><font class=$ycolor>".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Refunded").":</font> </td><td><font class=$ycolor>$money".mf("$rs_taxtotalrefund")."</font></td></tr>";

$rs_taxtotalcolminusrefund = $rs_taxtotal - $rs_taxtotalrefund;


echo "<tr><td><font class=$ycolor>".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax").":</font> </td><td><font class=$ycolor>$money".mf("$rs_taxtotalcolminusrefund")."</font></td></tr>";
echo "<tr><td><font class=$ycolor>".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Basis")." (".pcrtlang("purchases")."):</font> </td><td><font class=$ycolor>$money".mf("$rs_totalsales_purchase")."</font></td></tr>";
echo "<tr><td><font class=$ycolor>".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Basis")." (".pcrtlang("labor")."):</font> </td><td><font class=$ycolor>$money".mf("$rs_totalsales_labor")."</font></td></tr>";
echo "<tr><td><font class=$ycolor>".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Basis")." (".pcrtlang("sales refunds")."):</font> </td><td><font class=$ycolor>$money".mf("$rs_totalsales_refund")."</font></td></tr>";
echo "<tr><td><font class=$ycolor>".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Basis")." (".pcrtlang("labor refunds")."):</font> </td><td><font class=$ycolor>$money".mf("$rs_totalsales_refundlabor")."</font></td></tr>";

$rs_totalpur = $rs_totalsales_purchase - $rs_totalsales_refund;
echo "<tr><td><font class=$ycolor>".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Basis")." (".pcrtlang("purchases")."-".pcrtlang("refunds")."):</font> </td><td><font class=$ycolor>$money".mf("$rs_totalpur")."</font></td></tr>";

$rs_totallabpur = (($rs_totalsales_purchase + $rs_totalsales_labor) - ($rs_totalsales_refund + $rs_totalsales_refundlabor));
echo "<tr><td><font class=$ycolor>".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Basis")." (".pcrtlang("labor")."+".pcrtlang("purchases")."-".pcrtlang("sales refunds")."+".pcrtlang("labor refunds")."):</font> </td><td><font class=$ycolor>$money".mf("$rs_totallabpur")."</font></td></tr>";
echo "<tr><td colspan=2>&nbsp;</td></tr>";




}
echo "<tr><td colspan=2>&nbsp;</td></tr>";
$month++;

}
echo "</table>";

if(!isset($_REQUEST['printable'])) {
stop_box();
}

if(!isset($_REQUEST['printable'])) {
require("footer.php");
} else {
echo "</td></tr></table></body></html>";
}



}


########################################################################################################################


function taxreportnew_csv() {

if (array_key_exists('year',$_REQUEST)) {
if ($_REQUEST['year'] != "") {
$year = $_REQUEST['year'];
} else {
$year = date("Y");
}
} else {
$year = date("Y");
}

if (array_key_exists('month',$_REQUEST)) {
if ($_REQUEST['month'] != "") {
$qmonth = $_REQUEST['month'];
} else {
$qmonth = date("M");
}
} else {
$qmonth = date("M");
}

if (array_key_exists('fiscaldate',$_REQUEST)) {
$fiscaldate = $_REQUEST['fiscaldate'];
} else {
$fiscaldate = 0;
}

require_once("common.php");

require("deps.php");

perm_boot("5");

$csv = "\"".pcrtlang("Yearly Sales/Service Tax Report for")." $year\"\n\n";

if($fiscaldate) {
$csv .= "\"".pcrtlang("Fiscal Year Starting")." $year-$qmonth-01\"\n\n";
}





if($fiscaldate) {
$csv .= "\"".pcrtlang("Year Total for")." $year\"\n\n";
} else {
$csv .= "\"".pcrtlang("Year Total for Fiscal")." $year\"\n\n";
}


$rs_find_cart_tax = "SELECT * FROM taxes WHERE isgrouprate != '1'";
$rs_result_tax = mysqli_query($rs_connect, $rs_find_cart_tax);
while($rs_result_tax_q = mysqli_fetch_object($rs_result_tax)) {
$rs_taxid = "$rs_result_tax_q->taxid";
$rs_taxname = "$rs_result_tax_q->taxname";
$rs_taxenabled = "$rs_result_tax_q->taxenabled";

$groupsbelong = array();
$groupsbelong[] = "$rs_taxid";
$rs_ql_isingroup = "SELECT * FROM taxes WHERE isgrouprate = '1'";
$rs_result1_isingroup = mysqli_query($rs_connect, $rs_ql_isingroup);
while($rs_result_q1_isingroup = mysqli_fetch_object($rs_result1_isingroup)) {
$compositerate = "$rs_result_q1_isingroup->compositerate";
$gtaxid = "$rs_result_q1_isingroup->taxid";
$subarray = unserialize($compositerate);
if (in_array($rs_taxid,$subarray)) {
$groupsbelong[] = $gtaxid;
}
}

$taxids = implode(',',$groupsbelong); 

if(!$fiscaldate) {
$rs_find_cart_purt_purchase = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE YEAR(date_sold) = '$year' AND sold_type = 'purchase' AND taxex IN ($taxids)";
$rs_find_cart_purt_labor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE YEAR(date_sold) = '$year' AND sold_type = 'labor' AND taxex IN ($taxids)";
$rs_find_cart_purt_refund = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE YEAR(date_sold) = '$year' AND sold_type = 'refund' AND taxex IN ($taxids)";
$rs_find_cart_purt_refundlabor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE YEAR(date_sold) = '$year' AND sold_type = 'refundlabor' AND taxex IN ($taxids)";
} else {
$rs_find_cart_purt_purchase = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE date_sold >= '$year-$qmonth-01' AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 1 YEAR)) AND sold_type = 'purchase' AND taxex IN ($taxids)";
$rs_find_cart_purt_labor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE date_sold >= '$year-$qmonth-01' AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 1 YEAR)) AND sold_type = 'labor' AND taxex IN ($taxids)";
$rs_find_cart_purt_refund = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE date_sold >= '$year-$qmonth-01' AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 1 YEAR)) AND sold_type = 'refund' AND taxex IN ($taxids)";
$rs_find_cart_purt_refund = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE date_sold >= '$year-$qmonth-01' AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 1 YEAR)) AND sold_type = 'refundlabor' AND taxex IN ($taxids)";
}



$rs_result_purt_purchase = mysqli_query($rs_connect, $rs_find_cart_purt_purchase);
$rs_result_pur_purchase_qt = mysqli_fetch_object($rs_result_purt_purchase);
$rs_totalsales_purchase = "$rs_result_pur_purchase_qt->total";
$salestaxrate = getsalestaxrate($rs_taxid);
$rs_totaltax_purchase = $rs_totalsales_purchase * $salestaxrate;

$rs_result_purt_labor = mysqli_query($rs_connect, $rs_find_cart_purt_labor);
$rs_result_pur_labor_qt = mysqli_fetch_object($rs_result_purt_labor);
$rs_totalsales_labor = "$rs_result_pur_labor_qt->total";
$servicetaxrate = getservicetaxrate($rs_taxid);
$rs_totaltax_labor = $rs_totalsales_labor * $servicetaxrate;

$rs_result_purt_refund = mysqli_query($rs_connect, $rs_find_cart_purt_refund);
$rs_result_pur_refund_qt = mysqli_fetch_object($rs_result_purt_refund);
$rs_totalsales_refund = "$rs_result_pur_refund_qt->total";
$rs_totaltax_refund = $rs_totalsales_refund * $salestaxrate;

$rs_result_purt_refundlabor = mysqli_query($rs_connect, $rs_find_cart_purt_refundlabor);
$rs_result_pur_refundlabor_qt = mysqli_fetch_object($rs_result_purt_refundlabor);
$rs_totalsales_refundlabor = "$rs_result_pur_refundlabor_qt->total";
$rs_totaltax_refundlabor = $rs_totalsales_refundlabor * $servicetaxrate;


$rs_taxtotal = $rs_totaltax_purchase + $rs_totaltax_labor;
$rs_taxtotalrefund = $rs_totaltax_refund + $rs_totaltax_refundlabor;

$csv .= "\"$rs_taxname ".pcrtlang("Tax Collected").":\",\"".mf("$rs_taxtotal")."\"\n";
$csv .= "\"$rs_taxname ".pcrtlang("Tax Refunded").":\",\"".mf("$rs_taxtotalrefund")."\"\n";

$rs_taxtotalcolminusrefund = $rs_taxtotal - $rs_taxtotalrefund;

$csv .= "\"$rs_taxname ".pcrtlang("Tax").":\",\"".mf("$rs_taxtotalcolminusrefund")."\"\n";
$csv .= "\"$rs_taxname ".pcrtlang("Tax Basis")." (".pcrtlang("purchases")."):\",\"".mf("$rs_totalsales_purchase")."\"\n";
$csv .= "\"$rs_taxname ".pcrtlang("Tax Basis")." (".pcrtlang("labor")."):\",\"".mf("$rs_totalsales_labor")."\"\n";
$csv .= "\"$rs_taxname ".pcrtlang("Tax Basis")." (".pcrtlang("sales refunds")."):\",\"".mf("$rs_totalsales_refund")."\"\n";
$csv .= "\"$rs_taxname ".pcrtlang("Tax Basis")." (".pcrtlang("labor refunds")."):\",\"".mf("$rs_totalsales_refundlabor")."\"\n";

$rs_totalpur = $rs_totalsales_purchase - $rs_totalsales_refund;

$csv .= "\"$rs_taxname ".pcrtlang("Tax Basis")." (".pcrtlang("purchases")."-".pcrtlang("sales refunds")."):\",\"".mf("$rs_totalpur")."\"\n";

$rs_totallabpur = (($rs_totalsales_purchase + $rs_totalsales_labor) - ($rs_totalsales_refund + $rs_totalsales_refundlabor));

$csv .= "\"$rs_taxname ".pcrtlang("Tax Basis")." (".pcrtlang("labor")."+".pcrtlang("purchases")."-".pcrtlang("sales refunds")."+".pcrtlang("labor refunds")."):\",\"".mf("$rs_totallabpur")."\"\n";

}

###quarter

if(!$fiscaldate) {
$csv .= "\n\"".pcrtlang("Quarter Total for")." $year\"\n\n";
} else {
$csv .= "\n\"".pcrtlang("Quarter Total for Fiscal")." $year\"\n\n";
}

$fiscalquarter[1] = "date_sold >= '$year-$qmonth-01' AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 3 MONTH))";
$fiscalquarter[2] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 3 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 6 MONTH))";
$fiscalquarter[3] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 6 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 9 MONTH))";
$fiscalquarter[4] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 9 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 1 YEAR))";

$qrtr = 1;

while ($qrtr < 5) {

$rs_find_cart_tax2 = "SELECT * FROM taxes WHERE isgrouprate != '1'";
$rs_result_tax2 = mysqli_query($rs_connect, $rs_find_cart_tax2);

while($rs_result_tax_q2 = mysqli_fetch_object($rs_result_tax2)) {
$rs_taxid2 = "$rs_result_tax_q2->taxid";
$rs_taxname2 = "$rs_result_tax_q2->taxname";
$rs_taxenabled2 = "$rs_result_tax_q2->taxenabled";

$groupsbelong = array();
$groupsbelong[] = "$rs_taxid2";
$rs_ql_isingroup = "SELECT * FROM taxes WHERE isgrouprate = '1'";
$rs_result1_isingroup = mysqli_query($rs_connect, $rs_ql_isingroup);
while($rs_result_q1_isingroup = mysqli_fetch_object($rs_result1_isingroup)) {
$compositerate = "$rs_result_q1_isingroup->compositerate";
$gtaxid = "$rs_result_q1_isingroup->taxid";
$subarray = unserialize($compositerate);
if (in_array($rs_taxid2,$subarray)) {
$groupsbelong[] = $gtaxid;
}
}


$taxids = implode(',',$groupsbelong);

if(!$fiscaldate) {
$rs_find_cart_purt_purchase = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE QUARTER(date_sold) = '$qrtr' AND YEAR(date_sold) = '$year' AND sold_type = 'purchase' AND taxex IN ($taxids)";
$rs_find_cart_purt_labor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE QUARTER(date_sold) = '$qrtr' AND YEAR(date_sold) = '$year' AND sold_type = 'labor' AND taxex IN ($taxids)";
$rs_find_cart_purt_refund = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE QUARTER(date_sold) = '$qrtr' AND YEAR(date_sold) = '$year' AND sold_type = 'refund' AND taxex IN ($taxids)";
$rs_find_cart_purt_refundlabor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE QUARTER(date_sold) = '$qrtr' AND YEAR(date_sold) = '$year' AND sold_type = 'refundlabor' AND taxex IN ($taxids)";
} else {
$rs_find_cart_purt_purchase = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalquarter[$qrtr] AND sold_type = 'purchase' AND taxex IN ($taxids)";
$rs_find_cart_purt_labor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalquarter[$qrtr] AND sold_type = 'labor' AND taxex IN ($taxids)";
$rs_find_cart_purt_refund = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalquarter[$qrtr] AND sold_type = 'refund' AND taxex IN ($taxids)";
$rs_find_cart_purt_refundlabor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalquarter[$qrtr] AND sold_type = 'refundlabor' AND taxex IN ($taxids)";
}


$rs_result_purt_purchase = mysqli_query($rs_connect, $rs_find_cart_purt_purchase);
$rs_result_pur_purchase_qt = mysqli_fetch_object($rs_result_purt_purchase);
$rs_totalsales_purchase = "$rs_result_pur_purchase_qt->total";
$salestaxrate = getsalestaxrate($rs_taxid2);
$rs_totaltax_purchase = $rs_totalsales_purchase * $salestaxrate;

$rs_result_purt_labor = mysqli_query($rs_connect, $rs_find_cart_purt_labor);
$rs_result_pur_labor_qt = mysqli_fetch_object($rs_result_purt_labor);
$rs_totalsales_labor = "$rs_result_pur_labor_qt->total";
$servicetaxrate = getservicetaxrate($rs_taxid2);
$rs_totaltax_labor = $rs_totalsales_labor * $servicetaxrate;

$rs_result_purt_refund = mysqli_query($rs_connect, $rs_find_cart_purt_refund);
$rs_result_pur_refund_qt = mysqli_fetch_object($rs_result_purt_refund);
$rs_totalsales_refund = "$rs_result_pur_refund_qt->total";
$rs_totaltax_refund = $rs_totalsales_refund * $salestaxrate;

$rs_result_purt_refundlabor = mysqli_query($rs_connect, $rs_find_cart_purt_refundlabor);
$rs_result_pur_refundlabor_qt = mysqli_fetch_object($rs_result_purt_refundlabor);
$rs_totalsales_refundlabor = "$rs_result_pur_refundlabor_qt->total";
$rs_totaltax_refundlabor = $rs_totalsales_refundlabor * $servicetaxrate;


$rs_taxtotal = $rs_totaltax_purchase + $rs_totaltax_labor;
$rs_taxtotalrefund = $rs_totaltax_refund + $rs_totaltax_refundlabor;



$csv .= "\"".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Collected").":\",\"".mf("$rs_taxtotal")."\"\n";
$csv .= "\"".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Refunded").":\",\"".mf("$rs_totaltax_refund")."\"\n";

$rs_taxtotalcolminusrefund = $rs_taxtotal - $rs_taxtotalrefund;

$csv .= "\"".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax").":\",\"".mf("$rs_taxtotalcolminusrefund")."\"\n";

$csv .= "\"".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Basis")." (".pcrtlang("purchases")."):\",\"".mf("$rs_totalsales_purchase")."\"\n";
$csv .= "\"".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Basis")." (".pcrtlang("labor")."):\",\"".mf("$rs_totalsales_labor")."\"\n";
$csv .= "\"".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Basis")." (".pcrtlang("sales refunds")."):\",\"".mf("$rs_totalsales_refund")."\"\n";
$csv .= "\"".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Basis")." (".pcrtlang("labor refunds")."):\",\"".mf("$rs_totalsales_refundlabor")."\"\n";

$rs_totalpur = $rs_totalsales_purchase - $rs_totalsales_refund;

$csv .= "\"".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Basis")." (".pcrtlang("purchases")."-".pcrtlang("sales refunds")."):\",\"".mf("$rs_totalpur")."\"\n";

$rs_totallabpur = (($rs_totalsales_purchase + $rs_totalsales_labor) - ($rs_totalsales_refund + $rs_totalsales_refundlabor));

$csv .= "\"".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Basis")." (".pcrtlang("labor")."+".pcrtlang("purchases")."-".pcrtlang("sales refunds")."+".pcrtlang("labor refunds")."):\",\"".mf("$rs_totallabpur")."\"\n";



}

$qrtr++;

}





####month

if(!$fiscaldate) {
$csv .= "\n\"".pcrtlang("Monthly Totals for")." $year\"\n\n";
} else {
$csv .= "\n\"".pcrtlang("Monthly Totals for Fiscal")." $year\"\n\n";
}

$fiscalmonth[1] = "date_sold >= '$year-$qmonth-01' AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 1 MONTH))";
$fiscalmonth[2] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 1 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 2 MONTH))";
$fiscalmonth[3] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 2 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 3 MONTH))";
$fiscalmonth[4] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 3 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 4 MONTH))";
$fiscalmonth[5] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 4 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 5 MONTH))";
$fiscalmonth[6] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 5 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 6 MONTH))";
$fiscalmonth[7] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 6 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 7 MONTH))";
$fiscalmonth[8] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 7 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 8 MONTH))";
$fiscalmonth[9] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 8 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 9 MONTH))";
$fiscalmonth[10] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 9 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 10 MONTH))";
$fiscalmonth[11] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 10 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 11 MONTH))";
$fiscalmonth[12] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 11 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 12 MONTH))";


$month = 1;

while ($month < 13) {

$rs_find_cart_tax3 = "SELECT * FROM taxes WHERE isgrouprate != '1'";
$rs_result_tax3 = mysqli_query($rs_connect, $rs_find_cart_tax3);

while($rs_result_tax_q3 = mysqli_fetch_object($rs_result_tax3)) {
$rs_taxid3 = "$rs_result_tax_q3->taxid";
$rs_taxname3 = "$rs_result_tax_q3->taxname";
$rs_taxenabled3 = "$rs_result_tax_q3->taxenabled";

$groupsbelong = array();
$groupsbelong[] = "$rs_taxid3";
$rs_ql_isingroup = "SELECT * FROM taxes WHERE isgrouprate = '1'";
$rs_result1_isingroup = mysqli_query($rs_connect, $rs_ql_isingroup);
while($rs_result_q1_isingroup = mysqli_fetch_object($rs_result1_isingroup)) {
$compositerate = "$rs_result_q1_isingroup->compositerate";
$gtaxid = "$rs_result_q1_isingroup->taxid";
$subarray = unserialize($compositerate);
if (in_array($rs_taxid3,$subarray)) {
$groupsbelong[] = $gtaxid;
}
}

$taxids = implode(',',$groupsbelong);

if(!$fiscaldate) {
$rs_find_cart_purt_purchase = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE MONTH(date_sold) = '$month' AND YEAR(date_sold) = '$year' AND sold_type = 'purchase' AND taxex IN ($taxids)";
$rs_find_cart_purt_labor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE MONTH(date_sold) = '$month' AND YEAR(date_sold) = '$year' AND sold_type = 'labor' AND taxex IN ($taxids)";
$rs_find_cart_purt_refund = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE MONTH(date_sold) = '$month' AND YEAR(date_sold) = '$year' AND sold_type = 'refund' AND taxex IN ($taxids)";
$rs_find_cart_purt_refundlabor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE MONTH(date_sold) = '$month' AND YEAR(date_sold) = '$year' AND sold_type = 'refundlabor' AND taxex IN ($taxids)";
} else {
$rs_find_cart_purt_purchase = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalmonth[$month] AND taxex = '$rs_taxid3' AND sold_type = 'purchase' AND taxex IN ($taxids)";
$rs_find_cart_purt_labor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalmonth[$month] AND taxex = '$rs_taxid3' AND sold_type = 'labor' AND taxex IN ($taxids)";
$rs_find_cart_purt_refund = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalmonth[$month] AND taxex = '$rs_taxid3' AND sold_type = 'refund' AND taxex IN ($taxids)";
$rs_find_cart_purt_refundlabor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalmonth[$month] AND taxex = '$rs_taxid3' AND sold_type = 'refundlabor' AND taxex IN ($taxids)";
}

$rs_result_purt_purchase = mysqli_query($rs_connect, $rs_find_cart_purt_purchase);
$rs_result_pur_purchase_qt = mysqli_fetch_object($rs_result_purt_purchase);
$rs_totalsales_purchase = "$rs_result_pur_purchase_qt->total";
$salestaxrate = getsalestaxrate($rs_taxid3);
$rs_totaltax_purchase = $rs_totalsales_purchase * $salestaxrate;

$rs_result_purt_labor = mysqli_query($rs_connect, $rs_find_cart_purt_labor);
$rs_result_pur_labor_qt = mysqli_fetch_object($rs_result_purt_labor);
$rs_totalsales_labor = "$rs_result_pur_labor_qt->total";
$servicetaxrate = getservicetaxrate($rs_taxid3);
$rs_totaltax_labor = $rs_totalsales_labor * $servicetaxrate;

$rs_result_purt_refund = mysqli_query($rs_connect, $rs_find_cart_purt_refund);
$rs_result_pur_refund_qt = mysqli_fetch_object($rs_result_purt_refund);
$rs_totalsales_refund = "$rs_result_pur_refund_qt->total";
$rs_totaltax_refund = $rs_totalsales_refund * $salestaxrate;

$rs_result_purt_refundlabor = mysqli_query($rs_connect, $rs_find_cart_purt_refundlabor);
$rs_result_pur_refundlabor_qt = mysqli_fetch_object($rs_result_purt_refundlabor);
$rs_totalsales_refundlabor = "$rs_result_pur_refundlabor_qt->total";
$rs_totaltax_refundlabor = $rs_totalsales_refundlabor * $servicetaxrate;


$rs_taxtotal = $rs_totaltax_purchase + $rs_totaltax_labor;
$rs_taxtotalrefund = $rs_totaltax_refund + $rs_totaltax_refundlabor;

$csv .= "\"".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Collected").":\",\"".mf("$rs_taxtotal")."\"\n";
$csv .= "\"".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Refunded").":\",\"".mf("$rs_totaltax_refundlabor")."\"\n";

$rs_taxtotalcolminusrefund = $rs_taxtotal - $rs_taxtotalrefund;

$csv .= "\"".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax").":\",\"".mf("$rs_taxtotalcolminusrefund")."\"\n";
$csv .= "\"".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Basis")." (".pcrtlang("purchases")."):\",\"".mf("$rs_totalsales_purchase")."\"\n";
$csv .= "\"".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Basis")." (".pcrtlang("labor")."):\",\"".mf("$rs_totalsales_labor")."\"\n";
$csv .= "\"".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Basis")." (".pcrtlang("sales refunds")."):\",\"".mf("$rs_totalsales_refund")."\"\n";
$csv .= "\"".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Basis")." (".pcrtlang("labor refunds")."):\",\"".mf("$rs_totalsales_refundlabor")."\"\n";

$rs_totalpur = $rs_totalsales_purchase - $rs_totalsales_refund;

$csv .= "\"".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Basis")." (".pcrtlang("purchases")."-".pcrtlang("refunds")."):\",\"".mf("$rs_totalpur")."\"\n";

$rs_totallabpur = (($rs_totalsales_purchase + $rs_totalsales_labor) - ($rs_totalsales_refund + $rs_totalsales_refundlabor));

$csv .= "\"".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Basis")." (".pcrtlang("labor")."+".pcrtlang("purchases")."-".pcrtlang("sales refunds")."+".pcrtlang("labor refunds")."):\",\"".mf("$rs_totallabpur")."\"\n";



}
$month++;

}

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"tax_report_$year.csv\"");
echo $csv;


}




###############
function user_act_report() {

if (array_key_exists('dayto',$_REQUEST)) {
if ($_REQUEST['dayto'] != "") {
$dayto = $_REQUEST['dayto'];
} else {
$dayto = date("Y-m-d");
}
} else {
$dayto = date("Y-m-d");
}

if (array_key_exists('dayfrom',$_REQUEST)) {
if ($_REQUEST['dayfrom'] != "") {
$dayfrom = $_REQUEST['dayfrom'];
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}

                                                                                                                   
require_once("header.php");

perm_boot("7");
                                                                                                                                           
require("deps.php");

echo "<h3>".pcrtlang("Technician Activity Report for")." $dayfrom ".pcrtlang("to")." $dayto</h3>";





$findmax = "SELECT COUNT(*) AS themax FROM userlog WHERE thedatetime <= '$dayto 23:59:59' AND thedatetime  >= '$dayfrom 00:00:00' GROUP BY loggeduser,actionid ORDER BY themax DESC LIMIT 1";
$rs_result_max = mysqli_query($rs_connect, $findmax);
$rs_result_max_q = mysqli_fetch_object($rs_result_max);
$themax = "$rs_result_max_q->themax";
if($themax != "0") {
$themulty = (75 / $themax);
} else {
$themulty = 1;
}


reset($loggedactions);
echo "<table width=100%>";
foreach($loggedactions as $key => $val) {

echo "<tr><td><strong>".pcrtlang("Action").": $val</strong></td></tr>";

$rs_find_users = "SELECT * FROM users WHERE username != 'admin'"; 
$rs_result_users = mysqli_query($rs_connect, $rs_find_users);
while($rs_result_users_q = mysqli_fetch_object($rs_result_users)) {
$theuser = "$rs_result_users_q->username";


$rs_find_cart_pur = "SELECT * FROM userlog WHERE actionid = '$key' AND thedatetime <= '$dayto 23:59:59' AND thedatetime  >= '$dayfrom 00:00:00' AND loggeduser = '$theuser'";
$rs_result_pur = mysqli_query($rs_connect, $rs_find_cart_pur);

$thesum = mysqli_num_rows($rs_result_pur);
if ($thesum == "0") {
$thewidth = 1;
} else {
$thewidth = floor($thesum * $themulty);
}

echo "<tr><td><div style=\"width:$thewidth"."%; background-color:#f5ba14;\">&nbsp;</div>";
echo " $thesum $theuser</td></tr>";
}
echo "<tr><td>&nbsp;</td></tr>";
}

echo "</table>";
echo "<br><br>";


require("footer.php");
}
#######

function user_log_report() {

$day = $_REQUEST['day'];
$theuser = $_REQUEST['theuser'];

                                                                                                                                               
require_once("header.php");

$plusday = date("Y-m-d", (strtotime("$day") + 86400));                 
$minusday = date("Y-m-d", (strtotime("$day") - 86400));
echo "<center>";
echo "<button type=button onClick=\"parent.location='reports.php?func=user_log_report&day=$minusday&theuser=$theuser'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"><i class=\"fa fa-chevron-left fa-lg\"></i></button> ".pcrtlang("Report for")." $theuser ".pcrtlang("on")." $day <button type=button onClick=\"parent.location='reports.php?func=user_log_report&day=$plusday&theuser=$theuser'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"><i class=\"fa fa-chevron-right fa-lg\"></i></button></h3>";
echo "</center>";
require("deps.php");




echo "<form action=reports.php?func=user_log_report method=post data-ajax=\"false\">";
echo "<input type=hidden name=day value=\"$day\">";
echo "<select name=theuser onchange='this.form.submit()'>";
$rs_find_users = "SELECT * FROM users WHERE username != 'admin'";
$rs_result_users = mysqli_query($rs_connect, $rs_find_users);
while($rs_result_users_q = mysqli_fetch_object($rs_result_users)) {
$theusersw = "$rs_result_users_q->username";
if ("$theuser" == "$theusersw") {
echo "<option value=\"$theusersw\" selected>$theusersw</option>";
} else {
echo "<option value=\"$theusersw\">$theusersw</option>";
}

}
echo "</select></form>";



$rs_find_cart_items = "SELECT * FROM userlog WHERE thedatetime LIKE '$day%' AND loggeduser = '$theuser' ORDER BY thedatetime ASC ";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

if((mysqli_num_rows($rs_result)) == "0") {
echo "<br>".pcrtlang("No Results Found for")." $day";
}      
                                                                                                                                         
while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_actionid = "$rs_result_q->actionid";                                                                                                         
$rs_thedatetime2 = "$rs_result_q->thedatetime";
$rs_thedatetime = (date("g:i:s A", strtotime("$rs_thedatetime2")));
$rs_refid = "$rs_result_q->refid";
$reftype = "$rs_result_q->reftype";
$mensaje = "$rs_result_q->mensaje";

if($reftype == "woid") {
$link = "".pcrtlang("on Work Order").": #<a href=../repair/index.php?pcwo=$rs_refid>$rs_refid</a>";
} elseif ($reftype == "pcid") {
$link = "".pcrtlang("on PC ID").": #<a href=../repair/pc.php?func=showpc&pcid=$rs_refid>$rs_refid</a>";
} elseif ($reftype == "invoiceid") {
$link = "".pcrtlang("on Invoice").": #<a href=../store/invoice.php?func=printinv&invoice_id=$rs_refid>$rs_refid</a>";
} elseif ($reftype == "rinvoiceid") {
$link = "".pcrtlang("on Recurring Invoice").": #<a href=../store/rinvoice.php?func=viewrinvoice&rinvoice_id=$rs_refid>$rs_refid</a>";
} elseif ($reftype == "receiptid") {
$link = "".pcrtlang("on Receipt").": #<a href=../store/receipt.php?func=show_receipt&receipt=$rs_refid>$rs_refid</a>";
} elseif ($reftype == "groupid") {
$link = "".pcrtlang("on Group").": #<a href=../repair/group.php?func=viewgroup&pcgroupid=$rs_refid>$rs_refid</a>";
} else {
$link = "";
}

echo "<br>$rs_thedatetime - $loggedactions[$rs_actionid] $link | $mensaje";

}



require("footer.php");

}


function customer_source_report() {

if (array_key_exists('dayto',$_REQUEST)) {
if ($_REQUEST['dayto'] != "") {
$dayto = $_REQUEST['dayto'];
} else {
$dayto = date("Y-m-d");
}
} else {
$dayto = date("Y-m-d");
}

if (array_key_exists('dayfrom',$_REQUEST)) {
if ($_REQUEST['dayfrom'] != "") {
$dayfrom = $_REQUEST['dayfrom'];
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}


require_once("header.php");

perm_boot("9");

require("deps.php");

echo "<h3>".pcrtlang("Customer Source Report for")." $dayfrom ".pcrtlang("to")." $dayto</h3><br><br>";





$arrayofcs = array();

$rs_find_cst = "SELECT custsourceid FROM custsource WHERE showonreport != '0' AND sourceenabled != '0'";
$rs_result_cst = mysqli_query($rs_connect, $rs_find_cst);
while($rs_result_qcst = mysqli_fetch_object($rs_result_cst)) {
$jamit = "$rs_result_qcst->custsourceid";
$arrayofcs[$jamit] = 0;
}


$rs_find_current_woid = "SELECT MIN(woid), pcid FROM pc_wo WHERE dropdate <= '$dayto 23:59:59' AND dropdate  >= '$dayfrom 00:00:00' GROUP BY pcid";
$rs_result_pur = mysqli_query($rs_connect, $rs_find_current_woid);
while($rs_result_q = mysqli_fetch_object($rs_result_pur)) {
$rs_pcid = "$rs_result_q->pcid";


$rs_find_cs = "SELECT custsourceid FROM pc_owner WHERE pcid = '$rs_pcid' AND custsourceid != '0'";
$rs_result_cs = mysqli_query($rs_connect, $rs_find_cs);
while($rs_result_qcs = mysqli_fetch_object($rs_result_cs)) {
$custsourceid = "$rs_result_qcs->custsourceid";
if(array_key_exists("$custsourceid",$arrayofcs)) {
$arrayofcs[$custsourceid] = ($arrayofcs[$custsourceid] + 1);
}
}

}


$maxcount = max($arrayofcs);
if ($maxcount != 0) {
$multy = (90 / $maxcount);
} else {
$multy = 5;
}

arsort($arrayofcs);

foreach($arrayofcs as $key => $val) {

$rs_find_cst2 = "SELECT * FROM custsource WHERE custsourceid = '$key'";
$rs_result_cst2 = mysqli_query($rs_connect, $rs_find_cst2);
$rs_result_qcst2 = mysqli_fetch_object($rs_result_cst2);
$thesource = "$rs_result_qcst2->thesource";
$sourceicon = "$rs_result_qcst2->sourceicon";

if ($val == "0") {
$thewidth = 1;
} else {
$thewidth = floor($multy * $val);
}

echo "<img src=../repair/images/custsources/$sourceicon align=absmiddle> $thesource: $val<br>";
echo "<div style=\"width:$thewidth"."%; background-color:#999999; margin-top:10px;\">&nbsp;</div><br><br>";

}


require("footer.php");
}



function emaillist() {
require_once("validate.php");

require("deps.php");

require_once("common.php");
perm_boot("10");

echo "<pre>".pcrtlang("Email List").":\n\n\n";





$rs_show_email = "SELECT DISTINCT(pcemail) FROM pc_owner WHERE pcemail != ''";
$rs_email_result = mysqli_query($rs_connect, $rs_show_email);
while($rs_email_result_q = mysqli_fetch_object($rs_email_result)) {
$rs_email = "$rs_email_result_q->pcemail";
echo "$rs_email\n";

}

echo "</pre>";

}


function customers_csv() {

require_once("common.php");

require("deps.php");

perm_boot("10");

$csv = "\"".pcrtlang("PC ID")."\",\"".pcrtlang("Customer Name")."\",\"".pcrtlang("PC Make")."\",\"$pcrt_address1\",\"$pcrt_address2\",\"$pcrt_city\",\"$pcrt_state\",\"$pcrt_zip\",\"".pcrtlang("Email")."\",\"".pcrtlang("Phone")."\",\"".pcrtlang("Mobile Phone")."\",\"".pcrtlang("Work Phone")."\"\n";





$rs_find_customers = "SELECT * FROM pc_owner";
$rs_result_total = mysqli_query($rs_connect, $rs_find_customers);

while($rs_result_q = mysqli_fetch_object($rs_result_total)) {
$pcid = "$rs_result_q->pcid";
$rs_pcname = "$rs_result_q->pcname";
$rs_pcmake = "$rs_result_q->pcmake";
$rs_pcphone = "$rs_result_q->pcphone";
$rs_pccellphone = "$rs_result_q->pccellphone";
$rs_pcworkphone = "$rs_result_q->pcworkphone";
$rs_pcemail = "$rs_result_q->pcemail";
$rs_pcaddress = "$rs_result_q->pcaddress";
$rs_pcaddress2 = "$rs_result_q->pcaddress2";
$rs_pccity = "$rs_result_q->pccity";
$rs_pcstate = "$rs_result_q->pcstate";
$rs_pczip = "$rs_result_q->pczip";

$csv .= "\"$pcid\",\"$rs_pcname\",\"$rs_pcmake\",\"$rs_pcaddress\",\"$rs_pcaddress2\",\"$rs_pccity\",\"$rs_pcstate\",\"$rs_pczip\",\"$rs_pcemail\",\"$rs_pcphone\",\"$rs_pccellphone\",\"$rs_pcworkphone\"\n";

}

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"customers.csv\"");
echo $csv;

}


function groupcustomers_csv() {

require_once("common.php");

require("deps.php");

perm_boot("10");

$csv = "\"".pcrtlang("Group ID")."\",\"".pcrtlang("Customer Name")."\",\"$pcrt_address1\",\"$pcrt_address2\",\"$pcrt_city\",\"$pcrt_state\",\"$pcrt_zip\",\"".pcrtlang("Email")."\",\"".pcrtlang("Home Phone")."\",\"".pcrtlang("Mobile Phone")."\",\"".pcrtlang("Work Phone")."\"\n";





$rs_find_customers = "SELECT * FROM pc_group";
$rs_result_total = mysqli_query($rs_connect, $rs_find_customers);

while($rs_result_q = mysqli_fetch_object($rs_result_total)) {
$pcid = "$rs_result_q->pcgroupid";
$rs_pcname = "$rs_result_q->pcgroupname";
$rs_pcphone = "$rs_result_q->grpphone";
$rs_pccellphone = "$rs_result_q->grpcellphone";
$rs_pcworkphone = "$rs_result_q->grpworkphone";
$rs_pcemail = "$rs_result_q->grpemail";
$rs_pcaddress = "$rs_result_q->grpaddress1";
$rs_pcaddress2 = "$rs_result_q->grpaddress2";
$rs_pccity = "$rs_result_q->grpcity";
$rs_pcstate = "$rs_result_q->grpstate";
$rs_pczip = "$rs_result_q->grpzip";

$csv .= "\"$pcid\",\"$rs_pcname\",\"$rs_pcaddress\",\"$rs_pcaddress2\",\"$rs_pccity\",\"$rs_pcstate\",\"$rs_pczip\",\"$rs_pcemail\",\"$rs_pcphone\",\"$rs_pccellphone\",\"$rs_pcworkphone\"\n";

}

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"groupcustomers.csv\"");
echo $csv;

}





function tech_day_span_report() {

if (array_key_exists('dayto',$_REQUEST)) {
if ($_REQUEST['dayto'] != "") {
$dayto = $_REQUEST['dayto'];
} else {
$dayto = date("Y-m-d");
}
} else {
$dayto = date("Y-m-d");
}

if (array_key_exists('dayfrom',$_REQUEST)) {
if ($_REQUEST['dayfrom'] != "") {
$dayfrom = $_REQUEST['dayfrom'];
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}

$reportstoreid = $_REQUEST['reportstoreid'];
$thetech = $_REQUEST['thetech'];

require_once("header.php");
                                                                                                                   

perm_boot("7");
                                                                                                                                           
require("deps.php");


echo "<h3>".pcrtlang("Sales Report for")." $dayfrom ".pcrtlang("to")." $dayto<br>".pcrtlang("for Technician").": $thetech</h3>";

if ($activestorecount > 1) {
if ("$reportstoreid" == "all") {
echo pcrtlang("Store").": ".pcrtlang("All Stores")."<br><br>";
} else {
$storeinfoarray = getstoreinfo($reportstoreid);
echo pcrtlang("Store").": $storeinfoarray[storesname]<br><br>";
}
}







if ("$reportstoreid" == "all") {
$rs_find_cart_pur = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='purchase' AND sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold  >= '$dayfrom 00:00:00' AND receipts.byuser = '$thetech' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_cart_pur = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='purchase' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold  >= '$dayfrom 00:00:00' AND receipts.byuser = '$thetech'";
}
$rs_result_pur = mysqli_query($rs_connect, $rs_find_cart_pur);
while($rs_result_pur_q = mysqli_fetch_object($rs_result_pur)) {
$rs_purtotal = "$rs_result_pur_q->total";
echo pcrtlang("Total Purchases").": $money".mf("$rs_purtotal")."<br>";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_lab = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type = 'labor' AND sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND receipts.byuser = '$thetech' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_cart_lab = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type = 'labor' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND receipts.byuser = '$thetech'";
}
$rs_result_lab = mysqli_query($rs_connect, $rs_find_cart_lab);
while($rs_result_lab_q = mysqli_fetch_object($rs_result_lab)) {
$rs_labtotal = "$rs_result_lab_q->total";
echo pcrtlang("Total Labor").": $money".mf("$rs_labtotal")."<br>";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_ref = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='refund' AND sold_items.date_sold <= '
$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND receipts.byuser = '$thetech' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_cart_ref = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='refund' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.date_sold <= '$dayto 23:59:59' AND  sold_items.date_sold >= '$dayfrom 00:00:00' AND receipts.byuser = '$thetech'";
}
$rs_result_ref = mysqli_query($rs_connect, $rs_find_cart_ref);
while($rs_result_ref_q = mysqli_fetch_object($rs_result_ref)) {
$rs_reftotal = "$rs_result_ref_q->total";
echo pcrtlang("Total Sales Refunds").": $money".mf("$rs_reftotal")."<br>";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_refl = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='refundlabor' AND sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND receipts.byuser = '$thetech' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_cart_refl = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='refundlabor' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.date_sold <= '$dayto 23:59:59' AND  sold_items.date_sold >= '$dayfrom 00:00:00' AND receipts.byuser = '$thetech'";
}
$rs_result_refl = mysqli_query($rs_connect, $rs_find_cart_refl);
while($rs_result_refl_q = mysqli_fetch_object($rs_result_refl)) {
$rs_refltotal = "$rs_result_refl_q->total";
echo pcrtlang("Total Labor Refunds").": $money".mf("$rs_refltotal")."<br>";
}



if ("$reportstoreid" == "all") {
$rs_find_cart_refx = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts WHERE sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND sold_items.sold_type != 'refund' AND receipts.byuser = '$thetech' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_cart_refx = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts WHERE receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.date_sold <= '$dayto 23:59:59' AND  sold_items.date_sold >= '$dayfrom 00:00:00' AND sold_items.sold_type != 'refund' AND receipts.byuser = '$thetech'";
}
$rs_result_refx = mysqli_query($rs_connect, $rs_find_cart_refx);
while($rs_result_ref_qx = mysqli_fetch_object($rs_result_refx)) {
$rs_totaltax = "$rs_result_ref_qx->total";
echo "<br>".pcrtlang("Total Sales/Service Tax Collected").": $money".mf("$rs_totaltax");
}

if ("$reportstoreid" == "all") {
$rs_find_cart_refxr = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts WHERE sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND receipts.byuser = '$thetech' AND sold_items.receipt = receipts.receipt_id AND (sold_items.sold_type = 'refund' OR sold_items.sold_type = 'refundlabor')";
} else {
$rs_find_cart_refxr = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts WHERE receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND receipts.byuser = '$thetech' AND (sold_items.sold_type = 'refund' OR sold_items.sold_type = 'refundlabor')";
}
$rs_result_refxr = mysqli_query($rs_connect, $rs_find_cart_refxr);
while($rs_result_ref_qxr = mysqli_fetch_object($rs_result_refxr)) {
$rs_totaltaxr = "$rs_result_ref_qxr->total";
echo "<br>".pcrtlang("Total Sales/Service Tax Refunded").": $money".mf("$rs_totaltaxr")."<br>";
}



$totalgross = ((tnv($rs_purtotal) + tnv($rs_labtotal)) - (tnv($rs_reftotal) + tnv($rs_refltotal)));
echo "<br>".pcrtlang("Gross Total").": (".pcrtlang("Taxable + Non-Taxable Sales &amp; Labor/Not Including Tax")."): $money".mf("$totalgross")."<br>";
            

$totaltax = tnv($rs_totaltax) - tnv($rs_totaltaxr);
echo "<br>".pcrtlang("Tax Total less Refunded Tax").": $money".mf("$totaltax")."<br><br>";


#####

if ("$reportstoreid" == "all") {
$rs_find_op = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id AND receipts.byuser = '$thetech'";
} else {
$rs_find_op = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$reportstoreid' AND receipts.byuser = '$thetech'";
}
$rs_result_op = mysqli_query($rs_connect, $rs_find_op);
$rs_result_op_q = mysqli_fetch_object($rs_result_op);
$rs_totalop = "$rs_result_op_q->ourprice";
$rs_totalsp = "$rs_result_op_q->soldprice";

if ("$reportstoreid" == "all") {
$rs_find_opr = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id AND receipts.byuser = '$thetech'";
} else {
$rs_find_opr = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$reportstoreid' AND receipts.byuser = '$thetech'";
}

$rs_result_opr = mysqli_query($rs_connect, $rs_find_opr);
$rs_result_opr_q = mysqli_fetch_object($rs_result_opr);
$rs_totalopr = "$rs_result_opr_q->ourprice";
$rs_totalspr = "$rs_result_opr_q->soldprice";


$rs_totalnet = ((tnv($rs_totalsp) - tnv($rs_totalspr)) - (tnv($rs_totalop) - tnv($rs_totalopr)));
$totalnet = abs("$rs_totalnet");

if ($rs_totalnet > 0) {
echo pcrtlang("Estimated Net Sales").": $money".mf("$totalnet")."<br><br>";
} else {
echo pcrtlang("Estimated Net Sales").":<font class=textred> $money".mf("$totalnet")."</font><br><br>";
}





####





echo "<h3>".pcrtlang("Invoice Report for")." $dayfrom ".pcrtlang("to")." $dayto<br>".pcrtlang("for Technician").": $thetech</h3><br><br>";

if ("$reportstoreid" == "all") {
$rs_find_cart_pur = "SELECT SUM(invoice_items.cart_price) AS total FROM invoice_items,invoices WHERE invoice_items.cart_type='purchase' AND invoice_items.invoice_id = invoices.invoice_id AND invoices.invdate <= '$dayto 23:59:59' AND invoices.invdate  >= '$dayfrom 00:00:00' AND invoices.byuser = '$thetech' AND invoices.iorq = 'invoice' AND invoices.invstatus = '2'";
} else {
$rs_find_cart_pur = "SELECT SUM(invoice_items.cart_price) AS total FROM invoice_items,invoices WHERE invoice_items.cart_type='purchase' AND invoices.storeid = '$reportstoreid' AND invoice_items.invoice_id = invoices.invoice_id AND invoices.invdate <= '$dayto 23:59:59' AND invoices.invdate  >=  '$dayfrom 00:00:00' AND invoices.byuser = '$thetech' AND invoices.iorq = 'invoice' AND invoices.invstatus = '2'";
}
$rs_result_pur = mysqli_query($rs_connect, $rs_find_cart_pur);
while($rs_result_pur_q = mysqli_fetch_object($rs_result_pur)) {
$rs_purtotal = "$rs_result_pur_q->total";
echo pcrtlang("Total Purchases").": $money".mf("$rs_purtotal")."<br>";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_lab = "SELECT SUM(invoice_items.cart_price) AS total FROM invoice_items,invoices WHERE invoice_items.cart_type = 'labor' AND invoice_items.invoice_id = invoices.invoice_id AND invoices.invdate <= '$dayto 23:59:59' AND invoices.invdate >= '$dayfrom 00:00:00' AND invoices.byuser = '$thetech' AND invoices.iorq = 'invoice' AND invoices.invstatus = '2'";
} else {
$rs_find_cart_lab = "SELECT SUM(invoice_items.cart_price) AS total FROM invoice_items,invoices WHERE invoice_items.cart_type = 'labor' AND invoices.storeid = '$reportstoreid' AND invoice_items.invoice_id = invoices.invoice_id AND invoices.invdate <= '$dayto 23:59:59' AND invoices.invdate >= '$dayfrom 00:00:00' AND invoices.byuser = '$thetech' AND invoices.iorq = 'invoice' AND invoices.invstatus = '2'";
}
$rs_result_lab = mysqli_query($rs_connect, $rs_find_cart_lab);
while($rs_result_lab_q = mysqli_fetch_object($rs_result_lab)) {
$rs_labtotal = "$rs_result_lab_q->total";
echo pcrtlang("Total Labor:")." $money".mf("$rs_labtotal")."<br>";
}




echo "<br><br>";


echo "<h3>".pcrtlang("Assigned Work Order Report for")." $dayfrom ".pcrtlang("to")." $dayto<br>".pcrtlang("for Technician").": $thetech</h3><br><br>";

if ("$reportstoreid" == "all") {
$rs_find_the_wo = "SELECT *  FROM pc_wo WHERE assigneduser = '$thetech' AND dropdate <= '$dayto 23:59:59' AND dropdate >= '$dayfrom 00:00:00' ORDER BY dropdate DESC";
} else {
$rs_find_the_wo = "SELECT *  FROM pc_wo WHERE assigneduser = '$thetech' AND dropdate <= '$dayto 23:59:59' AND dropdate >= '$dayfrom 00:00:00' AND storeid = '$reportstoreid' ORDER BY dropdate DESC";
}
$rs_result_wo = mysqli_query($rs_connect, $rs_find_the_wo);
$totalpcs = mysqli_num_rows($rs_result_wo);
echo pcrtlang("Total Work Orders").": $totalpcs<br>";

echo "<table style=\"padding-left:10px;padding-right:10px;\" class=standard>";
echo "<tr><th>".pcrtlang("Drop Off Date")."</th><th>".pcrtlang("Name")."</th>";
echo "<th>".pcrtlang("Asset Make")."</th>";
echo "<th style=\"padding-left:10px;padding-right:10px;\">".pcrtlang("Status")."</th>";
echo "<th>".pcrtlang("Work Order")."</th>";
echo "</tr>";



while($rs_result_wo_q = mysqli_fetch_object($rs_result_wo)) {
$rs_pcid = "$rs_result_wo_q->pcid";
$rs_woid = "$rs_result_wo_q->woid";
$probdesc = "$rs_result_wo_q->probdesc";
$dropoff = "$rs_result_wo_q->dropdate";
$pcstatus = "$rs_result_wo_q->pcstatus";

$rs_findowner = "SELECT * FROM pc_owner WHERE pcid = '$rs_pcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
$rs_result_q2 = mysqli_fetch_object($rs_result2);
$pcname = "$rs_result_q2->pcname";
$pccompany = "$rs_result_q2->pccompany";
$pcmake = "$rs_result_q2->pcmake";


$dropoff2 = pcrtdate("$pcrt_longdate", "$dropoff").", ".pcrtdate("$pcrt_time", "$dropoff");

$boxstyle = getboxstyle("$pcstatus");

echo "<tr>";
echo "<td>$dropoff2</td>";
echo "<td>$pcname</td>";
echo "<td>$pcmake</td>";
echo "<td style=\"background-color:#$boxstyle[selectorcolor];\">";

if(isset($_REQUEST['printable'])) {
echo "<font style=\"color:#$boxstyle[selectorcolor];\"><i class=\"fa fa-square fa-lg\"></i></font> ";
}


echo "<font style=\"color:white;\">$boxstyle[boxtitle]</font></td>";
echo "<td><a href=\"../repair/index.php?pcwo=$rs_woid\">$rs_woid</a></td>";

echo "</tr>";


}

echo "</table>";


require("footer.php");

}


function dailycalllog() {

require("deps.php");
require("header.php");
require_once("common.php");


if (array_key_exists('day',$_REQUEST)) {
if ($_REQUEST['day'] != "") {
$day = $_REQUEST['day'];
} else {
$day = date("Y-m-d");
}
} else {
$day = date("Y-m-d");
}


echo "<h3>".pcrtlang("Daily Call/SMS Log")."</h3>";


$plusday = date("Y-m-d", (strtotime("$day") + 86400));
$minusday = date("Y-m-d", (strtotime("$day") - 86400));


echo "<center><button type=button onClick=\"parent.location='reports.php?func=dailycalllog&day=$minusday'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"><i class=\"fa fa-chevron-left fa-lg\"></i></button> ".pcrtlang("Report for")." $day <button type=button onClick=\"parent.location='reports.php?func=dailycalllog&day=$plusday'\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"><i class=\"fa fa-chevron-right fa-lg\"></i></button></center>";






$rs_find_cart_items = "SELECT * FROM userlog WHERE reftype = 'woid' AND thedatetime LIKE '$day%' AND (actionid = '11' OR actionid = '14') ORDER BY thedatetime ASC";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

if((mysqli_num_rows($rs_result)) == "0") {
echo "<br>".pcrtlang("No Results Found");
}


while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_actionid = "$rs_result_q->actionid";
$rs_thedatetime2 = "$rs_result_q->thedatetime";
$rs_thedatetime = (date("g:i:s A", strtotime("$rs_thedatetime2")));
$rs_refid = "$rs_result_q->refid";
$loggeduser = "$rs_result_q->loggeduser";
$reftype = "$rs_result_q->reftype";
$refid = "$rs_result_q->refid";
$mensaje = "$rs_result_q->mensaje";

$rs_find_store = "SELECT storeid,pcid FROM pc_wo WHERE woid = '$refid'";
$rs_resultfs = mysqli_query($rs_connect, $rs_find_store);
$rs_result_qfs = mysqli_fetch_object($rs_resultfs);
$rs_storeid = "$rs_result_qfs->storeid";
$rs_pcid = "$rs_result_qfs->pcid";

if($rs_storeid == $defaultuserstore) {

$rs_find_owner = "SELECT * FROM pc_owner WHERE pcid = '$rs_pcid'";
$rs_resulto = mysqli_query($rs_connect, $rs_find_owner);
$rs_result_qo = mysqli_fetch_object($rs_resulto);
$rs_pcname = "$rs_result_qo->pcname";
$rs_pccompany = "$rs_result_qo->pccompany";


if ($mensaje != "") {
$link = "$mensaje";
} else {
$link = "";
}

echo "<table class=standard><tr><th>".pcrtlang("User").": $loggeduser  <i class=\"fa fa-chevron-right\"></i> $loggedactions[$rs_actionid]</th></tr>";
echo "<tr><td>".pcrtlang("Date").": $rs_thedatetime</td></tr>";
echo "<tr><td><button type=button onClick=\"parent.location='../repairmobile/index.php?pcwo=$refid'\">$rs_pcname</button></td><tr>";
echo "<tr><td>".pcrtlang("Work Order").": $refid</td></tr>";
echo "<tr><td> $link</td></tr></table><br>";

}
}




}




#######

function day_span_payments_report() {



if (array_key_exists('dayto',$_REQUEST)) {
if ($_REQUEST['dayto'] != "") {
$dayto = $_REQUEST['dayto'];
} else {
$dayto = date("Y-m-d");
}
} else {
$dayto = date("Y-m-d");
}

if (array_key_exists('dayfrom',$_REQUEST)) {
if ($_REQUEST['dayfrom'] != "") {
$dayfrom = $_REQUEST['dayfrom'];
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}

$reportstoreid = $_REQUEST['reportstoreid'];



require_once("header.php");

echo "<h3>".pcrtlang("Payment Report for")." $dayfrom ".pcrtlang("to")." $dayto</h3><br><br>";

if ($activestorecount > 1) {
if ("$reportstoreid" == "all") {
echo pcrtlang("Store").": ".pcrtlang("All Stores")."<br><br>";
} else {
$storeinfoarray = getstoreinfo($reportstoreid);
echo pcrtlang("Store").": $storeinfoarray[storesname]<br><br>";
}
}



#echo "<a href=reports.php?func=day_span_payments_report&dayto=$dayto&dayfrom=$dayfrom&printable=yes&reportstoreid=$reportstoreid><img src=images/print.png align=absmiddle border=0> ".pcrtlang("Printable")."</a>";
#echo "<br><!--<a href=reports.php?func=day_span_payments_report_csv&dayto=$dayto&dayfrom=$dayfrom&reportstoreid=$reportstoreid><img src=images/csv.png align=absmiddle border=0> ".pcrtlang("CSV")."</a>-->";

echo "<table class=standard>";                                                                      
require("deps.php");




$pluginstotal = 0;
$pluginstotala = 0;
$pluginstotalb = 0;

reset($paymentplugins);
foreach($paymentplugins as $key => $plugin) {
if ("$reportstoreid" == "all") {
$rs_find_plugins = "SELECT SUM(amount) AS totalcash FROM savedpayments WHERE paymentdate <= '$dayto 23:59:59' AND paymentdate  >= '$dayfrom 00:00:00' AND paymentplugin = '$plugin'";
} else {
$rs_find_plugins = "SELECT SUM(amount) AS totalcash FROM savedpayments WHERE paymentdate <= '$dayto 23:59:59' AND paymentdate  >= '$dayfrom 00:00:00' AND paymentplugin = '$plugin' AND storeid = '$reportstoreid'";
}
$rs_result_plugin = mysqli_query($rs_connect, $rs_find_plugins);
while($rs_result_plugin_q = mysqli_fetch_object($rs_result_plugin)) {
$rs_totalcash = "$rs_result_plugin_q->totalcash";
if ($rs_totalcash != '') {
$cash = $rs_totalcash;
} else {
$cash = "0.00";
}
}
if ($cash != "0") {
echo "<tr><td>".pcrtlang("$plugin").":</td><td style=\"text-align:right\">$money".mf("$cash")."</td></tr>";
}
$pluginstotal = $pluginstotal + $cash;
}


reset($paymentplugins);
foreach($paymentplugins as $key => $plugin) {
if ("$reportstoreid" == "all") {
$rs_find_pluginsdep = "SELECT SUM(amount) AS totalcash FROM deposits WHERE depdate <= '$dayto 23:59:59' AND depdate  >= '$dayfrom 00:00:00'  AND paymentplugin = '$plugin'";
} else {
$rs_find_pluginsdep = "SELECT SUM(amount) AS totalcash FROM deposits WHERE depdate <= '$dayto 23:59:59' AND depdate  >= '$dayfrom 00:00:00'  AND paymentplugin = '$plugin' AND storeid = '$reportstoreid'";
}

$rs_result_plugindep = mysqli_query($rs_connect, $rs_find_pluginsdep);
while($rs_result_plugin_qdep = mysqli_fetch_object($rs_result_plugindep)) {
$rs_totalcashdep = "$rs_result_plugin_qdep->totalcash";
if ($rs_totalcashdep != '') {
$cashb = $rs_totalcashdep;
} else {
$cashb = "0.00";
}
}
if ($cashb != "0") {
echo "<tr><td>".pcrtlang("$plugin")." (".pcrtlang("Received Deposits")."):</td><td style=\"text-align:right\">$money".mf("$cashb")."</td></tr>";
}
$pluginstotalb = $pluginstotalb + $cashb;
}


reset($paymentplugins);
foreach($paymentplugins as $key => $plugin) {
if ("$reportstoreid" == "all") {
$rs_find_pluginsdepa = "SELECT SUM(amount) AS totalcash FROM deposits WHERE applieddate <= '$dayto 23:59:59' AND applieddate  >= '$dayfrom 00:00:00' AND paymentplugin = '$plugin' AND dstatus = 'applied'";
} else {
$rs_find_pluginsdepa = "SELECT SUM(amount) AS totalcash FROM deposits WHERE applieddate <= '$dayto 23:59:59' AND applieddate  >= '$dayfrom 00:00:00' AND paymentplugin = '$plugin' AND dstatus = 'applied' AND appliedstoreid = '$reportstoreid'";
}
$rs_result_plugindepa = mysqli_query($rs_connect, $rs_find_pluginsdepa);
while($rs_result_plugin_qdepa = mysqli_fetch_object($rs_result_plugindepa)) {
$rs_totalcashdepa = "$rs_result_plugin_qdepa->totalcash";
if ($rs_totalcashdepa != '') {
$casha = $rs_totalcashdepa;
} else {
$casha = "0.00";
}
}
if ($casha != "0") {
echo "<tr><td>".pcrtlang("$plugin")." (".pcrtlang("Applied Deposits")."):</td><td style=\"text-align:right\">$money".mf("$casha")."</td></tr>";
}
$pluginstotala = $pluginstotala + $casha;
}


echo "</table>";

if(($pluginstotal == "0") && ($pluginstotala == "0") && ($pluginstotalb =="0")) {
echo pcrtlang("No Payment Data available for this time period.");
}




require("footer.php");



}






function monthly_payments_report() {


if (array_key_exists('year',$_REQUEST)) {
if ($_REQUEST['year'] != "") {
$year = $_REQUEST['year'];
} else {
$year = date("Y");
}
} else {
$year = date("Y");
}



$reportstoreid = $_REQUEST['reportstoreid'];



require_once("header.php");


echo "<h3>".pcrtlang("Monthly Payment Report for")." $year</h3><br><br>";

if ($activestorecount > 1) {
if ("$reportstoreid" == "all") {
echo pcrtlang("Store").": ".pcrtlang("All Stores")."<br><br>";
} else {
$storeinfoarray = getstoreinfo($reportstoreid);
echo pcrtlang("Store").": $storeinfoarray[storesname]<br><br>";
}
}




echo "<table class=standard>";                                                                      
require("deps.php");





$m = 1;
       
while($m < 13) {

echo "<tr><th colspan=2>";


if ($m == 1) {
echo pcrtlang("January");
} elseif ($m == 2) {
echo pcrtlang("February");
} elseif ($m == 3) {
echo pcrtlang("March");
} elseif ($m == 4) {
echo pcrtlang("April");
} elseif ($m == 5) {
echo pcrtlang("May");
} elseif ($m == 6) {
echo pcrtlang("June");
} elseif ($m == 7) {
echo pcrtlang("July");
} elseif ($m == 8) {
echo pcrtlang("August");
} elseif ($m == 9) {
echo pcrtlang("September");
} elseif ($m == 10) {
echo pcrtlang("October");
} elseif ($m == 11) {
echo pcrtlang("November");
} else {
echo pcrtlang("December");
}




echo "</th></tr>";


$pluginstotal = 0;
$pluginstotala = 0;
$pluginstotalb = 0;

reset($paymentplugins);
foreach($paymentplugins as $key => $plugin) {
if ("$reportstoreid" == "all") {
$rs_find_plugins = "SELECT SUM(amount) AS totalcash FROM savedpayments WHERE MONTH(paymentdate) = '$m' AND YEAR(paymentdate) = '$year' AND paymentplugin = '$plugin'";
} else {
$rs_find_plugins = "SELECT SUM(amount) AS totalcash FROM savedpayments WHERE MONTH(paymentdate) = '$m' AND YEAR(paymentdate) = '$year' AND paymentplugin = '$plugin' AND storeid = '$reportstoreid'";
}
$rs_result_plugin = mysqli_query($rs_connect, $rs_find_plugins);
while($rs_result_plugin_q = mysqli_fetch_object($rs_result_plugin)) {
$rs_totalcash = "$rs_result_plugin_q->totalcash";
if ($rs_totalcash != '') {
$cash = $rs_totalcash;
} else {
$cash = "0.00";
}
}
if ($cash != "0") {
echo "<tr><td>".pcrtlang("$plugin").":</td><td style=\"text-align:right\">$money".mf("$cash")."</td></tr>";
}
$pluginstotal = $pluginstotal + $cash;
}


reset($paymentplugins);
foreach($paymentplugins as $key => $plugin) {
if ("$reportstoreid" == "all") {
$rs_find_pluginsdep = "SELECT SUM(amount) AS totalcash FROM deposits WHERE MONTH(depdate) = '$m' AND YEAR(depdate) = '$year'   AND paymentplugin = '$plugin'";
} else {
$rs_find_pluginsdep = "SELECT SUM(amount) AS totalcash FROM deposits WHERE MONTH(depdate) = '$m' AND YEAR(depdate) = '$year' AND paymentplugin = '$plugin' AND storeid = '$reportstoreid'";
}

$rs_result_plugindep = mysqli_query($rs_connect, $rs_find_pluginsdep);
while($rs_result_plugin_qdep = mysqli_fetch_object($rs_result_plugindep)) {
$rs_totalcashdep = "$rs_result_plugin_qdep->totalcash";
if ($rs_totalcashdep != '') {
$cashb = $rs_totalcashdep;
} else {
$cashb = "0.00";
}
}
if ($cashb != "0") {
echo "<tr><td>".pcrtlang("$plugin")." (".pcrtlang("Received Deposits")."):</td><td style=\"text-align:right\">$money".mf("$cashb")."</td></tr>";
}
$pluginstotalb = $pluginstotalb + $cashb;
}


reset($paymentplugins);
foreach($paymentplugins as $key => $plugin) {
if ("$reportstoreid" == "all") {
$rs_find_pluginsdepa = "SELECT SUM(amount) AS totalcash FROM deposits WHERE MONTH(applieddate) = '$m' AND YEAR(applieddate) = '$year' AND paymentplugin = '$plugin' AND dstatus = 'applied'";
} else {
$rs_find_pluginsdepa = "SELECT SUM(amount) AS totalcash FROM deposits WHERE MONTH(applieddate) = '$m' AND YEAR(applieddate) = '$year' AND paymentplugin = '$plugin' AND dstatus = 'applied' AND appliedstoreid = '$reportstoreid'";
}
$rs_result_plugindepa = mysqli_query($rs_connect, $rs_find_pluginsdepa);
while($rs_result_plugin_qdepa = mysqli_fetch_object($rs_result_plugindepa)) {
$rs_totalcashdepa = "$rs_result_plugin_qdepa->totalcash";
if ($rs_totalcashdepa != '') {
$casha = $rs_totalcashdepa;
} else {
$casha = "0.00";
}
}
if ($casha != "0") {
echo "<tr><td>".pcrtlang("$plugin")." (".pcrtlang("Applied Deposits")."):</td><td style=\"text-align:right\">$money".mf("$casha")."</td></tr>";
}
$pluginstotala = $pluginstotala + $casha;
}

if(($pluginstotal == "0") && ($pluginstotala == "0") && ($pluginstotalb =="0")) {
echo "<tr><td colspan=2>".pcrtlang("No Payment Data available for this month.")."</td></tr>";
}


echo "<tr><td colspan=2><br></td></tr>";


$m++;

}

echo "</table>";

require("footer.php");



}


function searchnii() {

require_once("header.php");

require("deps.php");

$thesearch = $_REQUEST['thesearch'];

echo "<h3>".pcrtlang("Sold Non-Inventoried Item Search")."</h3>";

echo "<form action=reports.php?func=searchnii method=post data-ajax=\"false\">";
echo pcrtlang("Enter Search Term").": </font><input type=text name=thesearch value=\"$thesearch\">";
echo "<input type=submit value=\"".pcrtlang("Search Again")."\"></form>";
echo "<br>";



$theq = "SELECT * FROM sold_items WHERE labor_desc LIKE '%$thesearch%' AND stockid = '0' AND sold_type = 'purchase' ORDER BY date_sold DESC LIMIT 50";





$rs_result_nii_r = mysqli_query($rs_connect, $theq);
while($rs_result_rq = mysqli_fetch_object($rs_result_nii_r)) {
$receipt_id = "$rs_result_rq->receipt";
$date_sold = "$rs_result_rq->date_sold";
$itemname = "$rs_result_rq->labor_desc";

$theqc = "SELECT * FROM receipts WHERE receipt_id = '$receipt_id'";
$rs_result_nii_rc = mysqli_query($rs_connect, $theqc);
$rs_result_rqc = mysqli_fetch_object($rs_result_nii_rc);
$customername = "$rs_result_rqc->person_name";
$company = "$rs_result_rqc->company";
$invoice_id = "$rs_result_rqc->invoice_id";
$woid = "$rs_result_rqc->woid";

echo "<table class=standard>";
echo "<tr><th>$itemname</th></tr>";
echo "<tr><td>".pcrtlang("Date Sold")." $date_sold</td></tr>";
echo "<tr><td><button onClick=\"parent.location='receipt.php?func=show_receipt&receipt=$receipt_id'\" data-mini=\"true\">".pcrtlang("Receipt")." #$receipt_id</button></td></tr>";
echo "<tr><td>$customername $company</td></tr>";

if($woid != 0) {
echo "<tr><td><button onClick=\"parent.location='../repair/index.php?pcwo=$woid\" data-mini=\"true\">".pcrtlang("Work Order")." #$woid</button></td></tr>";
}


if($invoice_id != 0) {
echo "<tr><td><button onClick=\"parent.location='invoice.php?func=printinv&invoice_id=$invoice_id'\" data-mini=\"true\">".pcrtlang("Invoice")." #$invoice_id</button></td></tr>";
}

echo "</table><br>";

}

require("footer.php");

}



function day_span_nii() {


require("deps.php");

if(!isset($_REQUEST['printable'])) {    
require("header.php");
} else {
require_once("common.php");

?>
<!DOCTYPE html>

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php

echo "<title>".pcrtlang("Day Range Non-Inventoried Item Report")."</title>";
if(!isset($pcrt_stylesheet)) {
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../repair/style.css\">";
} else {
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../repair/$pcrt_stylesheet\">";
}

echo "</head><body><table style=\"width: 90%;padding:5px;\"><tr><td>";
}

perm_boot("5");

if (array_key_exists('dayto',$_REQUEST)) {
if ($_REQUEST['dayto'] != "") {
$dayto = $_REQUEST['dayto'];
} else {
$dayto = date("Y-m-d");
}
} else {
$dayto = date("Y-m-d");
}

if (array_key_exists('dayfrom',$_REQUEST)) {
if ($_REQUEST['dayfrom'] != "") {
$dayfrom = $_REQUEST['dayfrom'];
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}

$reportstoreid = $_REQUEST['reportstoreid'];

if(!isset($_REQUEST['printable'])) {
start_blue_box(pcrtlang("Day Range Non-Inventoried Item Report"));
} else {
echo "<font class=text14b>".pcrtlang("Day Range Non-Inventoried Item Report")."</font><br><br>";
}

#if(isset($_REQUEST['printable'])) {
#echo "<a href=reports.php?func=day_span_nii&dayto=$dayto&dayfrom=$dayfrom&reportstoreid=$reportstoreid>".pcrtlang("Non-Printable")."</a>";
#} else {
#echo "<a href=reports.php?func=day_span_nii&dayto=$dayto&dayfrom=$dayfrom&printable=yes&reportstoreid=$reportstoreid><img src=images/print.png border=0 align=absmiddle> ".pcrtlang("Printable")."</a>";
#echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=reports.php?func=day_span_nii_csv&dayto=$dayto&dayfrom=$dayfrom&printable=yes&reportstoreid=$reportstoreid><img src=images/csv.png border=0 align=absmiddle> ".pcrtlang("CSV")."</a>";
#}



echo "<table style=\"width:100%\"><tr><td><font class=text14b>".pcrtlang("Date")."</font></td><td><font class=text14b>".pcrtlang("Item Name")."</font></td>";

echo "<td><font class=text14b>".pcrtlang("Receipt No.")."</font></td><td><font class=text14b>".pcrtlang("Customer Name")."</font></td>";
echo "<td><font class=text14b>".pcrtlang("WO ID")."</font></td><td><font class=text14b>".pcrtlang("Invoice")."</font></td>";
echo "<td><font class=text14b>".pcrtlang("Store")."</font></td>";
echo "<td style=\"text-align:right;\"><font class=text14b>".pcrtlang("Cost")."</font></td>";
echo "<td style=\"text-align:right;\"><font class=text14b>".pcrtlang("Price")."</font></td>";
echo "</tr>";

if ("$reportstoreid" == "all") {
$theq = "SELECT * FROM sold_items WHERE sold_type='purchase' AND date_sold <= '$dayto 23:59:59' AND date_sold >= '$dayfrom 00:00:00' AND stockid = '0' ORDER BY date_sold DESC LIMIT 500";
} else {
$theq = "SELECT * FROM sold_items,receipts WHERE sold_items.sold_type='purchase' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold  >= '$dayfrom 00:00:00' AND stockid = '0' ORDER BY sold_items.date_sold DESC LIMIT 500";
}





$rs_result_nii_r = mysqli_query($rs_connect, $theq);

$chkrec = mysqli_num_rows($rs_result_nii_r);

if($chkrec != 0) {

while($rs_result_rq = mysqli_fetch_object($rs_result_nii_r)) {
$receipt_id = "$rs_result_rq->receipt";
$date_sold = "$rs_result_rq->date_sold";
$itemname = "$rs_result_rq->labor_desc";
$soldprice = "$rs_result_rq->sold_price";
$ourprice = "$rs_result_rq->ourprice";

$theqc = "SELECT * FROM receipts WHERE receipt_id = '$receipt_id'";
$rs_result_nii_rc = mysqli_query($rs_connect, $theqc);
$rs_result_rqc = mysqli_fetch_object($rs_result_nii_rc);
$customername = "$rs_result_rqc->person_name";
$company = "$rs_result_rqc->company";
$invoice_id = "$rs_result_rqc->invoice_id";
$woid = "$rs_result_rqc->woid";
$storeid = "$rs_result_rqc->storeid";

echo "<tr><td><font class=text12>$date_sold</font></td><td><font class=text12>$itemname</font></td>";
echo "<td><a href=\"receipt.php?func=show_receipt&receipt=$receipt_id\">$receipt_id</a></td>";
echo "<td><font class=text12>$customername $company</font></td><td>";

if($woid != 0) {
echo "<a href=\"../repair/index.php?pcwo=$woid\">$woid</a>";
}

echo "</td><td>";

if($invoice_id != 0) {
echo "<a href=\"invoice.php?func=printinv&invoice_id=$invoice_id\">$invoice_id</a>";
}

echo "</td>";

$storeinfo = getstoreinfo($storeid);

echo "<td><font class=text12>$storeinfo[storesname]</font></td>";

echo "<td style=\"text-align:right;\"><font class=text12>$money".mf("$ourprice")."</font></td>";
echo "<td style=\"text-align:right;\"><font class=text12>$money".mf("$soldprice")."</font></td>";

echo "</tr>";

}
} else {
echo "<tr><td colspan=3><font class=text12>".pcrtlang("Sorry, No results found")."</font></td></tr>";
}


echo "</table>";

if(!isset($_REQUEST['printable'])) {
stop_blue_box();
}


if(!isset($_REQUEST['printable'])) {
require("footer.php");
} else {
echo "</body></html>";
}




}




function day_span_nii_csv() {


require("deps.php");

require_once("common.php");


perm_boot("5");

if (array_key_exists('dayto',$_REQUEST)) {
if ($_REQUEST['dayto'] != "") {
$dayto = $_REQUEST['dayto'];
} else {
$dayto = date("Y-m-d");
}
} else {
$dayto = date("Y-m-d");
}

if (array_key_exists('dayfrom',$_REQUEST)) {
if ($_REQUEST['dayfrom'] != "") {
$dayfrom = $_REQUEST['dayfrom'];
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}

$reportstoreid = $_REQUEST['reportstoreid'];


header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"non_inv_item_report.csv\"");



echo "\"".pcrtlang("Date")."\",\"".pcrtlang("Item Name")."\",";

echo "\"".pcrtlang("Receipt No.")."\",\"".pcrtlang("Customer Name")."\",";
echo "\"".pcrtlang("WO ID")."\",\"".pcrtlang("Invoice")."\",";
echo "\"".pcrtlang("Store")."\",";
echo "\"".pcrtlang("Cost")."\",";
echo "\"".pcrtlang("Price")."\"";

if ("$reportstoreid" == "all") {
$theq = "SELECT * FROM sold_items WHERE sold_type='purchase' AND date_sold <= '$dayto 23:59:59' AND date_sold >= '$dayfrom 00:00:00' AND stockid = '0' ORDER BY date_sold DESC LIMIT 500";
} else {
$theq = "SELECT * FROM sold_items,receipts WHERE sold_items.sold_type='purchase' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold  >= '$dayfrom 00:00:00' AND stockid = '0' ORDER BY sold_items.date_sold DESC LIMIT 500";
}





$rs_result_nii_r = mysqli_query($rs_connect, $theq);

while($rs_result_rq = mysqli_fetch_object($rs_result_nii_r)) {
$receipt_id = "$rs_result_rq->receipt";
$date_sold = "$rs_result_rq->date_sold";
$itemname = "$rs_result_rq->labor_desc";
$soldprice = "$rs_result_rq->sold_price";
$ourprice = "$rs_result_rq->ourprice";

$theqc = "SELECT * FROM receipts WHERE receipt_id = '$receipt_id'";
$rs_result_nii_rc = mysqli_query($rs_connect, $theqc);
$rs_result_rqc = mysqli_fetch_object($rs_result_nii_rc);
$customername = "$rs_result_rqc->person_name";
$company = "$rs_result_rqc->company";
$invoice_id = "$rs_result_rqc->invoice_id";
$woid = "$rs_result_rqc->woid";
$storeid = "$rs_result_rqc->storeid";

echo "\n\"$date_sold\",\"$itemname\",";
echo "\"$receipt_id\",";
echo "\"$customername $company\",\"";

if($woid != 0) {
echo "$woid";
}

echo "\",\"";

if($invoice_id != 0) {
echo "$invoice_id";
}

echo "\",";

$storeinfo = getstoreinfo($storeid);

echo "\"$storeinfo[storesname]\",";

echo "\"".mf("$ourprice")."\",";
echo "\"".mf("$soldprice")."\"";


}




} 


                                                                                 

function managedstockreports() {

require("deps.php");
require_once("common.php");

$whattoshow = $_REQUEST['what'];

#if (array_key_exists('printable',$_REQUEST)) {
#$printable = $_REQUEST['printable'];
#} else {
#$printable = "no";
#}

$printable = "yes";

if($printable == "yes") {
printableheader(pcrtlang("Managed Stock Report"));
} else {
require_once("header.php");
}





if($whattoshow == "store") {
$rs_find_cart_items = "SELECT stockcounts.storeid,stock.stock_price,stock.stock_id,stock.stock_title,stockcounts.quantity,stockcounts.reorderqty,stockcounts.minstock,stockcounts.maxstock FROM stock,stockcounts
WHERE stockcounts.maintainstock = '1' AND stockcounts.minstock > stockcounts.quantity AND stockcounts.storeid = '$defaultuserstore' AND stock.stock_id = stockcounts.stockid
ORDER BY stock_id";
} else {
$rs_find_cart_items = "SELECT stockcounts.storeid,stock.stock_price,stock.stock_id,stock.stock_title,stockcounts.quantity,stockcounts.reorderqty,stockcounts.minstock,stockcounts.maxstock FROM stock,stockcounts
WHERE stockcounts.maintainstock = '1' AND stockcounts.minstock > stockcounts.quantity AND stock.stock_id = stockcounts.stockid
ORDER BY stock_id";
}


$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

if($printable != "yes") {
echo "<p style=\"text-align:right;\">";
echo "<img src=images/print.png border=0 align=absmiddle> ";
echo "<a href=reports.php?func=managedstockreports&what=$whattoshow&printable=yes>".pcrtlang("Printable Version")."</a><br></p>";

if($whattoshow == "store") {
$storeinfoarray = getstoreinfo($defaultuserstore);
echo "<h3>".pcrtlang("Managed Stock Report")." | ".pcrtlang("Store").": $storeinfoarray[storesname]</h3>";
} else {
echo "<h3>".pcrtlang("Managed Stock Report")." | ".pcrtlang("All Stores")."</h3>";
}
} else {
if($whattoshow == "store") {
$storeinfoarray = getstoreinfo($defaultuserstore);
echo "<font class=text14b>".pcrtlang("Managed Stock Report")." | ".pcrtlang("Store").": $storeinfoarray[storesname]</font><br><br>";
} else {
echo "<font class=text14b>".pcrtlang("Managed Stock Report")." | ".pcrtlang("All Stores")."</font><br><br>";
}
}

echo "<table class=stocklist>";
echo "<tr><th><font class=text12b>".pcrtlang("Stock Id")."</font></th><th><font class=text12b>".pcrtlang("Item Name")."</font></th>";
echo "<th width=10%><font class=text12b>".pcrtlang("Current Quantity")."</font></th>";
echo "<th width=10%><font class=text12b>".pcrtlang("Available Quantity")."</font></th>";
echo "<th><font class=text12b>".pcrtlang("Re-Order Quantity")."</font></th>";
echo "<th><font class=text12b>".pcrtlang("Min Stock")."</font></th>";
echo "<th><font class=text12b>".pcrtlang("Max Stock")."</font></th>";

echo "<th><font class=text12b>".pcrtlang("Store")."</font></th>";


echo "</tr>";

$previousstockid = 0;

$totalsarray[1] = 0;
$totalsarray[2] = 0;
$totalsarray[3] = 0;
$totalsarray[4] = 0;


while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_sold_price = "$rs_result_q->stock_price";
$rs_stockid = "$rs_result_q->stock_id";
$rs_partname2 = "$rs_result_q->stock_title";
$rs_quantity = "$rs_result_q->quantity";
$rs_minstock = "$rs_result_q->minstock";
$rs_maxstock = "$rs_result_q->maxstock";
$rs_reorderqty = "$rs_result_q->reorderqty";
$rs_storeid = "$rs_result_q->storeid";


$rs_find_rs = "SELECT * FROM inventory WHERE stock_id = '$rs_stockid' ORDER BY inv_date DESC LIMIT 1";

$rs_result_rs = mysqli_query($rs_connect, $rs_find_rs);
$rs_result_qrs = mysqli_fetch_object($rs_result_rs);
$supplierid = "$rs_result_qrs->supplierid";
$suppliername = "$rs_result_qrs->suppliername";
$parturl = "$rs_result_qrs->parturl";
$partnumber = "$rs_result_qrs->partnumber";





if(($whattoshow == "all") && ($previousstockid != $rs_stockid) && ($previousstockid != 0)) {
echo "<tr style=\"border-bottom: 5px solid #777777; border-top: 2px solid #777777;\"><td colspan=4><font class=text14b>".pcrtlang("Store Totals")."</font></td>";
echo "<td style=\"text-align:right;\">";
echo "<font class=text12>".pcrtlang("reorder qty").": </font><font class=text12>$totalsarray[1]</font><br>";
echo "<font class=text12>".pcrtlang("qty to min").": </font><font class=text12>$totalsarray[2]</font><br>";
echo "<font class=text12>".pcrtlang("qty to min + reorder qty").": </font><font class=textblue12b>$totalsarray[3]</font><br>";
echo "<font class=text12>".pcrtlang("qty to max").": </font><font class=text12>$totalsarray[4]</font>";
echo "</td><td colspan=3></td></tr>";

$totalsarray[1] = 0;
$totalsarray[2] = 0;
$totalsarray[3] = 0;
$totalsarray[4] = 0;

}




$rs_partname = urlencode("$rs_partname2");

echo "<tr><td><a href=stock.php?func=show_stock_detail&stockid=$rs_stockid>#$rs_stockid</td>";

$thestat = urlencode(pcrtlang("Need to Order"));

echo "<td><a href=stock.php?func=show_stock_detail&stockid=$rs_stockid>$rs_partname2</a>";


if($supplierid != 0) {
$rs_find_suppliers = "SELECT * FROM suppliers WHERE supplierid = $supplierid";
$rs_result_supp = mysqli_query($rs_connect, $rs_find_suppliers);
$rs_result_suppq = mysqli_fetch_object($rs_result_supp);
$suppliername2 = "$rs_result_suppq->suppliername";
} else {
$suppliername2 = "$suppliername";
}


if(perm_check("23") && ($supplierid != 0)) {
echo "<br><a href=\"suppliers.php?func=viewsupplier&supplierid=$supplierid\" class=smalllink>$suppliername2</a>";
} else {
echo "<br><font class=text10>$suppliername2</font>";
}


if($parturl != "") {
$parturl2 = addhttp("$parturl");
echo " <a href=\"$parturl2\" target=\"_blank\"><i class=\"fa fa-external-link fa-lg\"></i></a>";
}


if($partnumber != "") {
echo "<br><font class=text10>$partnumber</font>";
}

echo "</td>";


echo "<td style=\"text-align:center;\"><font class=text12>$rs_quantity</font></td>";

$availableq = stockavailability($rs_stockid,$rs_storeid,$rs_quantity);

$qtytohitmin = $rs_minstock - $availableq['available'];
$qtytohitmax = $rs_maxstock - $availableq['available'];
$qtytominplusrecc = $qtytohitmin + $rs_reorderqty;

$totalsarray[1] = $rs_reorderqty + $totalsarray[1];
$totalsarray[2]	= $qtytohitmin + $totalsarray[2];
$totalsarray[3]	= $qtytominplusrecc + $totalsarray[3];
$totalsarray[4]	= $qtytohitmax + $totalsarray[4];

echo "<td style=\"text-align:center;\"><font class=text12>$availableq[available]</font></td>";
echo "<td style=\"text-align:right;\">";
echo "<font class=text12>".pcrtlang("reorder qty").": </font><font class=text12>$rs_reorderqty</font><br>";
echo "<font class=text12>".pcrtlang("qty to min").": </font><font class=text12>$qtytohitmin</font><br>";
echo "<font class=text12>".pcrtlang("qty to min + reorder qty").": </font><font class=textblue12b>$qtytominplusrecc</font><br>";
echo "<font class=text12>".pcrtlang("qty to max").": </font><font class=text12>$qtytohitmax</font>";

echo "</td>";
echo "<td style=\"text-align:center;\"><font class=text12>$rs_minstock</font></td>";
echo "<td style=\"text-align:center;\"><font class=text12>$rs_maxstock</font></td>";

$storeinfoarray = getstoreinfo($rs_storeid);
$storesname = $storeinfoarray['storesname'];

echo "<td><font class=text12>$storesname</font></td>";


echo "</tr>";


$previousstockid = $rs_stockid;

        }


if(($whattoshow == "all")) {
echo "<tr style=\"border-bottom: 5px solid #777777; border-top: 2px solid #777777;\"><td colspan=4><font class=text14b>".pcrtlang("Store Totals")."</font></td>";
echo "<td style=\"text-align:right;\">";
echo "<font class=text12>".pcrtlang("reorder qty").": </font><font class=text12>$totalsarray[1]</font><br>";
echo "<font class=text12>".pcrtlang("qty to min").": </font><font class=text12>$totalsarray[2]</font><br>";
echo "<font class=text12>".pcrtlang("qty to min + reorder qty").": </font><font class=textblue12b>$totalsarray[3]</font><br>";
echo "<font class=text12>".pcrtlang("qty to max").": </font><font class=text12>$totalsarray[4]</font>";
echo "</td><td colspan=3></td></tr>";
}



echo "</table>";

echo "<br>";

if($printable == "yes") {
printablefooter();
} else {
require("footer.php");
}

}



###############


function mileage_report() {

require("deps.php");
require_once("common.php");

if (array_key_exists('dayto',$_REQUEST)) {
if ($_REQUEST['dayto'] != "") {
$dayto = $_REQUEST['dayto'];
} else {
$dayto = date("Y-m-d");
}
} else {
$dayto = date("Y-m-d");
}

if (array_key_exists('dayfrom',$_REQUEST)) {
if ($_REQUEST['dayfrom'] != "") {
$dayfrom = $_REQUEST['dayfrom'];
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}

$thetech = $_REQUEST['thetech'];

if (array_key_exists('printable',$_REQUEST)) {
$printable = $_REQUEST['printable'];
} else {
$printable = "yes";
}

if($printable == "yes") {
printableheader(pcrtlang("Mileage Report"));
} else {
require_once("header.php");
}





if($thetech == "all") {
$rs_find_ml_items = "SELECT * FROM travellog WHERE tldate <= '$dayto 23:59:59' AND tldate >= '$dayfrom 00:00:00'";
} else {
$rs_find_ml_items = "SELECT * FROM travellog WHERE traveluser = '$thetech' AND tldate <= '$dayto 23:59:59' AND tldate >= '$dayfrom 00:00:00'";
}


$rs_result = mysqli_query($rs_connect, $rs_find_ml_items);

echo "<font class=text14b>".pcrtlang("Mileage Report")."</font><br><br>";

echo "<table class=stocklist>";
echo "<tr><th><font class=text12b>".pcrtlang("Technician")."</font></th><th><font class=text12b>".pcrtlang("Date")."</font></th>";
echo "<th><font class=text12b>".pcrtlang("Work Order")."</font></th>";
echo "<th><font class=text12b>".pcrtlang("Customer Name")."</font></th>";
echo "<th><font class=text12b>".pcrtlang("Miles")."</font></th>";
echo "</tr>";

$totaldist = 0;

while($rs_result_item_q = mysqli_fetch_object($rs_result)) {
$tlid = "$rs_result_item_q->tlid";
$tlwo = "$rs_result_item_q->tlwo";
$tldate2 = "$rs_result_item_q->tldate";
$tlmiles = "$rs_result_item_q->tlmiles";
$traveluser = "$rs_result_item_q->traveluser";

$totaldist = $totaldist + $tlmiles;

$tldate = pcrtdate("$pcrt_time", "$tldate2")." ".pcrtdate("$pcrt_shortdate", "$tldate2");

$rs_find_pc = "SELECT pcid FROM pc_wo WHERE woid = '$tlwo'";
$rs_result_item = mysqli_query($rs_connect, $rs_find_pc);
$rs_result_item_q = mysqli_fetch_object($rs_result_item);
$pcidq = "$rs_result_item_q->pcid";


$rs_find_pcowner = "SELECT pcname FROM pc_owner WHERE pcid = $pcidq";
$rs_result_item_owner = mysqli_query($rs_connect, $rs_find_pcowner);
$rs_result_item_qo = mysqli_fetch_object($rs_result_item_owner);
$pcname = "$rs_result_item_qo->pcname";



echo "<tr><td><font class=text12>$traveluser</font></td>";

echo "<td><font class=text12>$tldate</font></td>";
echo "<td><font class=text12>$tlwo</font></td>";

echo "<td><font class=text12>$pcname</font></td>";






echo "<td><font class=text12>$tlmiles";

if("$pcrt_units" == "METRIC") {
echo pcrtlang("km");
} else {
echo " ".pcrtlang("miles");
}

echo "</font></td></tr>";

}



echo "<tr><td colspan=3></td><td><font class=text12b>".pcrtlang("Total")."</font></td><td><font class=text12>$totaldist ";

if("$pcrt_units" == "METRIC") {
echo pcrtlang("km");
} else {
echo " ".pcrtlang("miles");
}


echo "</font></td></tr>";




echo "</table>";

echo "<br>";

printablefooter();

}



######

switch($func) {
                                                                                                    
    default:
    reportlist();
    break;
                                
    case "browse_receipts":
    browse_receipts();
    break;

    case "day_report":
    day_report();
    break;

  case "day_report_csv":
    day_report_csv();
    break;


    case "day_span_report":
    day_span_report();
    break;

   case "day_span_report_csv":
    day_span_report_csv();
    break;


    case "quarter_report":
    quarter_report();
    break;

    case "quarter_report_csv":
    quarter_report_csv();
    break;


    case "year_report":
    year_report();
    break;

 case "year_report_csv":
    year_report_csv();
    break;


    case "taxex_report":
    taxex_report();
    break;

    case "month_report":
    month_report();
    break;

   case "month_report_csv":
    month_report_csv();
    break;


    case "browse_sold":
    browse_sold();
    break;

 case "browse_outofstock":
    browse_outofstock();
    break;


    case "repair_vol":
    repair_vol();
    break;

  case "fixinv1":
    fixinv1();
    break;

 case "fixinv2":
    fixinv2();
    break;

 case "taxreport":
    taxreport();
    break;

 case "taxreport_csv":
    taxreport_csv();
    break;

 case "taxreportnew":
    taxreportnew();
    break;

 case "taxreportnew_csv":
    taxreportnew_csv();
    break;

 case "user_act_report":
    user_act_report();
    break;

 case "user_log_report":
    user_log_report();
    break;

 case "customer_source_report":
    customer_source_report();
    break;

 case "emaillist":
    emaillist();
    break;

 case "customers_csv":
    customers_csv();
    break;

 case "groupcustomers_csv":
    groupcustomers_csv();
    break;

   case "tech_day_span_report":
    tech_day_span_report();
    break;

   case "dailycalllog":
    dailycalllog();
    break;

    case "day_span_payments_report":
    day_span_payments_report();
    break;

   case "day_span_payments_report_csv":
    day_span_payments_report_csv();
    break;

    case "monthly_payments_report":
    monthly_payments_report();
    break;

    case "searchnii":
    searchnii();
    break;

    case "day_span_nii":
    day_span_nii();
    break;

    case "day_span_nii_csv":
    day_span_nii_csv();
    break;

    case "managedstockreports":
    managedstockreports();
    break;

    case "mileage_report":
    mileage_report();
    break;


}

?>

