<?php
                                                                                                    
/***************************************************************************
 *   copyright            : (C) 2018 PCRepairTracker.com
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

echo "<script type=\"text/javascript\">document.title = \"".pcrtlang("Service Requests")."\";</script>";

if ($gomodal == 1) {
$therel = "rel=facebox";
} else {
$therel = "";
}

if (array_key_exists('showstore',$_REQUEST)) {
$showstore = $_REQUEST['showstore'];
} else {
$showstore = "$defaultuserstore";
}






start_box();
echo "<h4>".pcrtlang("Service Requests")."</h4>";
echo "<span class=\"linkbuttonmedium linkbuttongraylabel radiusleft\">".pcrtlang("Show").": </span>";
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
echo "<span  class=\"linkbuttonmedium linkbuttongraydisabled\">($thecount) ".pcrtlang("Unassigned")."</span>";
} else {
echo "<a href=\"servicerequests.php?func=runsreq&showstore=0\" class=\"linkbuttonmedium linkbuttongray\">($thecount) ".pcrtlang("Unassigned")."</a>";
}
} else {
if($srstore_id == $showstore) {
echo "<span class=\"linkbuttonmedium linkbuttongraydisabled\">($thecount) $storeinfoarray[storesname]</span>";
} else {
echo "<a href=\"servicerequests.php?func=runsreq&showstore=$srstore_id\" class=\"linkbuttonmedium linkbuttongray\">($thecount) $storeinfoarray[storesname]</a>&nbsp;&nbsp;&nbsp;&nbsp;";
}
}
}

echo "<a href=\"servicerequests.php?func=sreqlist\" class=\"linkbuttonmedium linkbuttongray radiusright\">".pcrtlang("Show Closed Requests")."</a>";

stop_box();
echo "<br>";

if($showstore == 0) {
start_color_box("50",pcrtlang("Unassigned"));
} else {
$storeinfoarray2 = getstoreinfo($showstore);
start_color_box("50","$storeinfoarray2[storesname]");
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

start_box();
echo "<table style=\"width:100%\"><tr>";
echo "<td style=\"vertical-align:top;width:33%;\"><span class=\"sizemelarger boldme\">$sreq_name</span>";
if("$sreq_company" != "") {
echo "<br>$sreq_company";
}
if($sreq_addy1 != "") {
echo "<br>$sreq_addy1";
}
if($sreq_addy2 != "") {
echo "<br>$sreq_addy2,";
}

if(($sreq_city != "") || ($sreq_state != "") || ($sreq_zip != "")){
echo "<br>$sreq_city, $sreq_state $sreq_zip";
}

echo "<br><br><i class=\"fa fa-home fa-lg fa-fw\"></i> $sreq_homephone";
echo "<br><i class=\"fa fa-mobile fa-lg fa-fw\"></i> $sreq_cellphone<br><i class=\"fa fa-briefcase fa-lg fa-fw\"></i> $sreq_workphone";
echo "<br><br><i class=\"fa fa-envelope fa-lg fa-fw\"></i> $sreq_email</td>";
echo "<td style=\"vertical-align:top;width:33%;\"><span class=boldme>".pcrtlang("Make/Model")."</span><br>$sreq_model<br><br><span class=boldme>".pcrtlang("Problem")."</span><br>$sreq_problem</td>";
echo "<td style=\"vertical-align:top;width:33%;\"><span class=boldme>".pcrtlang("Submitted")."</span><br>$sreq_date2<br><br><span class=boldme>".pcrtlang("IP Address")."</span><br>$sreq_ip<br><br><span class=boldme>".pcrtlang("Browser Agent")."</span><br>$sreq_agent";

if($sreq_custsourceid != "0") {
$rs_cssq = "SELECT * FROM custsource WHERE custsourceid = '$sreq_custsourceid'";
$rs_result1cs = mysqli_query($rs_connect, $rs_cssq);
while($rs_result_qcs1 = mysqli_fetch_object($rs_result1cs)) {
$thesource = "$rs_result_qcs1->thesource";
$sourceicon = "$rs_result_qcs1->sourceicon";

echo "<br><br>".pcrtlang("Customer Source").":<br><img src=images/custsources/$sourceicon align=absmiddle> $thesource<br><br>";
}
}


echo "</td></tr></table><br>";
######################

$sqlwhere = "";
if("$sreq_company" != "") {
$sqlwhere .= " OR pccompany LIKE '%".pv("$sreq_company")."%'";
}
if($sreq_homephone != "") {
$sqlwhere .= " OR pcphone LIKE '%".pv("$sreq_homephone")."%'";
}
if($sreq_cellphone != "") {
$sqlwhere .= "OR pccellphone LIKE '%".pv("$sreq_cellphone")."%' ";
}
if($sreq_workphone != "") {
$sqlwhere .= " OR pcworkphone LIKE '%".pv("$sreq_homephone")."%'";
}
if($sreq_email != "") {
$sqlwhere .= " OR pcemail LIKE '%".pv("$sreq_email")."%'";
}
if($sreq_pcid != "") {
$sqlwhere .= " OR pcid = '".pv("$sreq_pcid")."'";
}
if($sreq_name != "") {
$sqlwhere .= " OR pcname LIKE '".pv("$sreq_name")."'";
}


echo "<table class=standard>";
echo "<tr><th colspan=4>".pcrtlang("Potential Asset Matches")."</th></tr>";
$rs_find_pc = "SELECT * FROM pc_owner WHERE 1=2 $sqlwhere LIMIT 50";
$rs_result_item = mysqli_query($rs_connect, $rs_find_pc);
while($rs_result_item_q = mysqli_fetch_object($rs_result_item)) {
$pcname = "$rs_result_item_q->pcname";
$pccompany = "$rs_result_item_q->pccompany";
$pcid2 = "$rs_result_item_q->pcid";
$pcmake = "$rs_result_item_q->pcmake";
echo "<tr><td>";
if($pcid2 == $sreq_pcid) {
echo "<i class=\"fa fa-tag colormered\"></i>";
}
echo "</td>";
echo "<td><i class=\"fa fa-user\"></i>$pcid2 $pcname</td><td><i class=\"fa fa-cog\"></i> $pcmake</td><td>";
echo "<form action=pc.php?func=returnpc2 method=post>";
echo "<input type=hidden name=pcid value=\"$pcid2\">";
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
echo "<button type=submit class=\"linkbuttonsmall linkbuttongray radiusall\"><img src=images/return.png style=\"height:16px;\"></button>";
echo "</form>";
echo "</td></tr>";
}
echo "</table><br>";



##############3
echo "<a href=pc.php?func=addpc&pcname=$pcname&pccompany=$pccompany&pcphone=$pcphone&pcemail=$pcemail&pcaddress=$pcaddress&pcaddress2=$pcaddress2&pccity=$pccity&pcstate=$pcstate&pczip=$pczip&pccellphone=$pccellphone&pcworkphone=$pcworkphone&pcproblem=$pcproblem&pcmake=$pcmake&sreq_id=$sreq_id&storeid=$showstore&custsourceid=$sreq_custsourceid class=\"linkbuttonmedium linkbuttongray radiusleft\"><img src=images/new.png align=absmiddle border=0 height=24> ".pcrtlang("New Work Order")."</a>";

echo "<a href=pc.php?func=addassetonly&pcname=$pcname&pccompany=$pccompany&pcphone=$pcphone&pcemail=$pcemail&pcaddress=$pcaddress&pcaddress2=$pcaddress2&pccity=$pccity&pcstate=$pcstate&pczip=$pczip&pccellphone=$pccellphone&pcworkphone=$pcworkphone&pcmake=$pcmake class=\"linkbuttonmedium linkbuttongray\"><img src=images/customers.png align=absmiddle border=0 height=24> ".pcrtlang("New Asset/Device")."</a>";

echo "<a href=group.php?func=addtogroupnew&groupname=$pcname&pccompany=$pccompany&pchomephone=$pcphone&pcemail=$pcemail&pcaddress1=$pcaddress&pcaddress2=$pcaddress2&pccity=$pccity&pcstate=$pcstate&pczip=$pczip&pccellphone=$pccellphone&pcworkphone=$pcworkphone class=\"linkbuttonmedium linkbuttongray radiusleft\"><img src=images/groups.png align=absmiddle border=0 height=24> ".pcrtlang("New Group")."</a>";


echo "<a href=sticky.php?func=addsticky&stickyname=$pcname&stickycompany=$pccompany&stickyphone=$pcphone&stickyemail=$pcemail&stickyaddy1=$pcaddress&stickyaddy2=$pcaddress2&stickycity=$pccity&stickystate=$pcstate&stickyzip=$pczip&stickynote=$pcproblem&sreq_id=$sreq_id&storeid=$showstore $therel class=\"linkbuttonmedium linkbuttongray\"><img src=images/sticky.png align=absmiddle border=0 height=24> ".pcrtlang("New Sticky")."</a>";
echo "<a href=servicerequests.php?func=proreq&sreq_id=$sreq_id&showstore=$showstore class=\"linkbuttonmedium linkbuttongray\"><img src=images/right.png align=absmiddle border=0 height=24> ".pcrtlang("Mark as Processed")."</a>";
echo "<a href=servicerequests.php?func=delreq&sreq_id=$sreq_id&showstore=$showstore class=\"linkbuttonmedium linkbuttongray radiusright\"><img src=images/del.png align=absmiddle border=0 height=24> ".pcrtlang("Delete")."</a>";

if("$sreq_pcid" != 0) {
$pcid = "$sreq_pcid";
} else {
$pcid = "";
}


echo "<br><table style=\"width:100%;\"><tr><td><form action=pc.php?func=returnpc2 method=POST>";
echo "".pcrtlang("Returning Asset/Device ID").": <input class=textbox type=text name=pcid value=\"$pcid\" size=6>";
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
echo "</form></td><td>";


echo "<form action=pc.php?func=searchreturnpcsreq method=POST>";
echo "".pcrtlang("Return Asset/Device Search").": <input class=textbox type=text name=searchterm size=10>";
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



stop_box();

echo "<br><br>";
}
stop_color_box();


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

require("deps.php");
require_once("common.php");

require_once("header.php");

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

start_blue_box(pcrtlang("Browse Service Requests"));

echo "<table style=\"width:100%\"><tr><td>";
echo "</td><td style=\"text-align:right\">";
echo "<i class=\"fa fa-search fa-lg\"></i> <input type=text class=textbox id=searchbox placeholder=\"".pcrtlang("Enter Search Text")."\" value=\"$search\">";

echo "</td></tr></table><br>";

echo "<div id=themain>";

echo "</div>";

?>
<script type="text/javascript">
$(document).ready(function () {
     $.get('servicerequests.php?func=sreqlistajax&pageNumber=<?php echo $pageNumber; ?>&sortby=<?php echo $sortby; ?>&search=<?php echo $search_ue; ?>', function(data) {
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
                                        $('div#themain').load('servicerequests.php?func=sreqlistajax&pageNumber=<?php echo $pageNumber; ?>&sortby=<?php echo $sortby; ?>').slideDown(200,function(){
                                        return false;
                                        });
                                }else{
                                        $('div#themain').load('servicerequests.php?func=sreqlistajax&pageNumber=<?php echo $pageNumber; ?>&sortby=<?php echo $sortby; ?>&search='+encodedinv).slideDown(200);
                                }
                        }, 500);
  });
});
</script>


<?php

stop_blue_box();

require("footer.php");

}




function sreqlistajax() {


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



require("deps.php");
require_once("common.php");


if (array_key_exists("search", $_REQUEST)) {
$search = $_REQUEST['search'];
if($search != "") {
$searchsql = "AND (sreq_name LIKE '%$search%' OR sreq_problem LIKE '%$search%' OR sreq_company LIKE '%$search%' OR sreq_email LIKE '%$search%' OR sreq_cellphone LIKE '%$search%' OR sreq_workphone LIKE '%$search%' OR sreq_homephone LIKE '%$search%' OR sreq_model LIKE '%$search%')";
} else {
$searchsql = "";
$search = "";
}
} else {
$searchsql = "";
$search = "";
}


$search_ue = urlencode($search);


if ("$sortby" == "id_asc") {
$rs_find_sreq = "SELECT * FROM servicerequests WHERE sreq_processed = '1' $searchsql ORDER BY sreq_id ASC LIMIT $offset,$results_per_page";
} elseif ("$sortby" == "id_desc") {
$rs_find_sreq = "SELECT * FROM servicerequests WHERE sreq_processed = '1' $searchsql ORDER BY sreq_id DESC LIMIT $offset,$results_per_page";
} elseif ("$sortby" == "name_desc") {
$rs_find_sreq = "SELECT * FROM servicerequests WHERE sreq_processed = '1' $searchsql ORDER BY sreq_name DESC LIMIT $offset,$results_per_page";
} else {
$rs_find_sreq = "SELECT * FROM servicerequests WHERE sreq_processed = '1' $searchsql ORDER BY sreq_name ASC LIMIT $offset,$results_per_page";
}

$rs_result = mysqli_query($rs_connect, $rs_find_sreq);

$rs_find_sreq_total = "SELECT * FROM servicerequests WHERE 1 $searchsql";
$rs_result_total = mysqli_query($rs_connect, $rs_find_sreq_total);

$totalentries = mysqli_num_rows($rs_result_total);
$lastpage = $totalentries / $results_per_page;
if($lastpage != floor($lastpage)) {
$lastpage = floor($lastpage) + 1;
}

if($pageNumber > $lastpage) {
$pageNumber = 1;
$offset = 0;
}

echo "<table class=standard>";
echo "<tr><th>".pcrtlang("ID")."#";
echo "</th><th><a href=servicerequests.php?func=sreqlist&pageNumber=$pageNumber&sortby=id_asc&search=$search_ue class=\"linkbuttontiny linkbuttongray radiustop\">
<i class=\"fa fa-chevron-up\"></i></a><br>";
echo "<a href=servicerequests.php?func=sreqlist&pageNumber=$pageNumber&sortby=id_desc&search=$search_ue class=\"linkbuttontiny linkbuttongray radiusbottom\">
<i class=\"fa fa-chevron-down\"></i></a>";
echo "</th><th>".pcrtlang("Customer Name");
echo "</th><th><a href=servicerequests.php?func=sreqlist&pageNumber=$pageNumber&sortby=name_asc&search=$search_ue class=\"linkbuttontiny linkbuttongray radiustop\">
<i class=\"fa fa-chevron-up\"></i></a><br>";
echo "<a href=servicerequests.php?func=sreqlist&pageNumber=$pageNumber&sortby=name_desc&search=$search_ue class=\"linkbuttontiny linkbuttongray radiusbottom\">
<i class=\"fa fa-chevron-down\"></i></a>";
echo "</th><th>".pcrtlang("Make/Model")."</th><th>".pcrtlang("Problem")."</th>";
echo "</tr>";

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

echo "<tr><td style=\"width:70px;\" colspan=2><a href=servicerequests.php?func=show_sreq&sreq_id=$sreq_id&returnurl=$returnurl class=\"linkbuttonsmall linkbuttongray radiusall\">#$sreq_id</a></td>";
echo "<td style=\"width:150px;\" colspan=2><span class=boldme>$sreq_name</span>";

if("$sreq_company" != "") {
echo "<br><span class=\"sizemesmaller\">$sreq_company</span>";
}

echo "</td>";

echo "<td style=\"width:150px;\">$sreq_model</td>";

echo "<td>$sreq_problem2</td>";



echo "</tr>";

}

echo "</table>";

stop_blue_box();

echo "<br>";

start_box();
#browse here

echo "<center>";

if($pageNumber != 1) {
$prevpage = $pageNumber - 1;
echo "<a href=servicerequests.php?func=sreqlist&pageNumber=$prevpage&sortby=$sortby&search=$search_ue class=\"linkbuttonmedium linkbuttongray radiusall\">
<i class=\"fa fa-chevron-left fa-lg\"></i></a>";
}

$html = get_paged_nav($totalentries, $results_per_page, false);
$html = str_replace("servicerequestsajax", "servicerequests", "$html");
echo "$html";

if($lastpage != $pageNumber) {
$nextpage = $pageNumber + 1;
echo "<a href=servicerequests.php?func=sreqlist&&pageNumber=$nextpage&sortby=$sortby&search=$search_ue class=\"linkbuttonmedium linkbuttongray radiusall\">
<i class=\"fa fa-chevron-right fa-lg\"></i></a>";
}

echo "</center>";

stop_box();


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
#wip
start_box();
echo "<h4>".pcrtlang("Service Request")."</h4><br><br>";
echo "<table style=\"width:100%\"><tr>";

echo "<td style=\"vertical-align:top;width:33%;\"><span class=\"sizemelarger boldme\">$sreq_name</span>";
if("$sreq_company" != "") {
echo "<br>$sreq_company";
}
if($sreq_addy1 != "") {
echo "<br>$sreq_addy1";
}
if($sreq_addy2 != "") {
echo "<br>$sreq_addy2,";
}

if(($sreq_city != "") || ($sreq_state != "") || ($sreq_zip != "")){
echo "<br>$sreq_city, $sreq_state $sreq_zip";
}

echo "<br><br><i class=\"fa fa-home fa-lg fa-fw\"></i> $sreq_homephone";
echo "<br><i class=\"fa fa-mobile fa-lg fa-fw\"></i> $sreq_cellphone<br><i class=\"fa fa-briefcase fa-lg fa-fw\"></i> $sreq_workphone";
echo "<br><br><i class=\"fa fa-envelope fa-lg fa-fw\"></i> $sreq_email</td>";


echo "<td style=\"vertical-align:top;width:33%;\"><span class=boldme>".pcrtlang("Make/Model")."</span><br>$sreq_model<br><br><span class=boldme>".pcrtlang("Problem").":</span><br>$sreq_problem</td>";
echo "<td style=\"vertical-align:top;width:33%;\"><span class=boldme>".pcrtlang("Submitted")."</span><br>$sreq_date2<br><br><span class=boldme>".pcrtlang("IP Address")."</span><br>$sreq_ip<br><br><span class=boldme>".pcrtlang("Browser Agent").":</span><br>$sreq_agent</td>";
echo "</tr></table><br>";
echo "<a href=$returnurl class=\"linkbuttongray linkbuttonmedium radiusleft\"><img src=images/left.png align=absmiddle border=0> ".pcrtlang("Go Back")."</a>";
echo "<a href=pc.php?func=addpc&pcname=$pcname&pcphone=$pcphone&pcemail=$pcemail&pcaddress=$pcaddress&pcaddress2=$pcaddress2&pccity=$pccity&pcstate=$pcstate&pczip=$pczip&pccellphone=$pccellphone&pcworkphone=$pcworkphone&pcproblem=$pcproblem&pcmake=$pcmake&sreq_id=$sreq_id&storeid=$sreq_storeid class=\"linkbuttongray linkbuttonmedium\"><img src=images/new.png align=absmiddle border=0> ".pcrtlang("Create Work Order")."</a>";
echo "<a href=sticky.php?func=addsticky&stickyname=$pcname&stickyphone=$pcphone&stickyemail=$pcemail&stickyaddy1=$pcaddress&stickyaddy2=$pcaddress2&stickycity=$pccity&stickystate=$pcstate&stickyzip=$pczip&stickynote=$pcproblem&sreq_id=$sreq_id&storeid=$sreq_storeid class=\"linkbuttongray linkbuttonmedium\"><img src=images/sticky.png align=absmiddle border=0> ".pcrtlang("Create Sticky")."</a>";
echo "<a href=servicerequests.php?func=delreq&sreq_id=$sreq_id&returnurl=$returnurl class=\"linkbuttongray linkbuttonmedium\"><img src=images/del.png align=absmiddle border=0> ".pcrtlang("Delete")."</a>";

if("$sreq_pcid" != 0) {
$pcid = "$sreq_pcid";
} else {
$pcid = "";
}


echo "<br><table style=\"width:100%;\"><tr><td><form action=pc.php?func=returnpc2 method=POST>";
echo "".pcrtlang("Returning Asset/Device ID").": <input class=textbox type=text name=pcid value=\"$pcid\" size=6>";
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
echo "</form></td><td>";
echo "<form action=pc.php?func=searchreturnpcsreq method=POST>";
echo "".pcrtlang("Return PC Search").": <input class=textbox type=text name=searchterm size=10>";
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


stop_box();

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

  case "sreqlistajax":
    sreqlistajax();
    break;

  case "show_sreq":
    show_sreq();
    break;


}

