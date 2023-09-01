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


function wolist() {

if (array_key_exists("pageNumber", $_REQUEST)) {
$pageNumber = $_REQUEST['pageNumber'];
} else {
$pageNumber = 1;
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
require_once("brandicon.php");




$rs_find_wo = "SELECT * FROM pc_wo WHERE pcstatus = '5' ORDER BY pickupdate DESC LIMIT $offset,$results_per_page";


$rs_result2 = mysqli_query($rs_connect, $rs_find_wo);

$rs_find_cart_items_total = "SELECT * FROM pc_wo WHERE pcstatus = '5'";
$rs_result_total = mysqli_query($rs_connect, $rs_find_cart_items_total);



echo "<h3>".pcrtlang("Browse Work Orders")."</h3>";

echo "<table class=doublestandard>";
echo "<tr>";

echo "</tr>";

while($rs_result_q5 = mysqli_fetch_object($rs_result2)) {
$pcid = "$rs_result_q5->pcid";
$woid = "$rs_result_q5->woid";
$called = "$rs_result_q5->called";
$pcpriorityindb = "$rs_result_q5->pcpriority";
$probdesc = "$rs_result_q5->probdesc";
$pickdate = "$rs_result_q5->pickupdate";


$rs_findowner = "SELECT * FROM pc_owner WHERE pcid = '$pcid'";
$rs_result = mysqli_query($rs_connect, $rs_findowner);

if (mysqli_num_rows($rs_result) != "0") {


$rs_result_q = mysqli_fetch_object($rs_result);
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


echo "<tr>";
echo "<td>";

$rs_findpic = "SELECT * FROM assetphotos WHERE pcid = '$pcid' AND highlight='1'";
$rs_resultfindpic = mysqli_query($rs_connect, $rs_findpic);


echo "<a href=\"index.php?pcwo=$woid\" class=\"imagelink\">";
if (mysqli_num_rows($rs_resultfindpic) != "0") {
$rs_resultpic_q2 = mysqli_fetch_object($rs_resultfindpic);
$assetphotoid = "$rs_resultpic_q2->assetphotoid";
echo "<img src=pc.php?func=getpcimage&photoid=$assetphotoid border=0 width=75><br>";
} else {
$medicon = brandicon("$rs_pcmake");
echo "<img src=../repair/images/pcs/$medicon border=0 width=64>";
}

echo "</td>";

echo "<td>";


echo "<button type=button onClick=\"parent.location='pc.php?func=showpc&pcid=$pcid'\">$rs_pcname</button><br>";
echo "<button type=button onClick=\"parent.location='index.php?pcwo=$woid'\"><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("edit")."</button><br>";


if($rs_pccompany != "") {
echo "$rs_pccompany<br>";
}

if (($rs_prefcontact != "email") || ($rs_prefcontact != "none") || ($rs_prefcontact != "sms")) {
if($rs_prefcontact == "work") {
echo "$rs_pcworkphone<br>";
} elseif ($rs_prefcontact == "mobile") {
echo "$rs_pccellphone<br>";
} else {
echo "$rs_pcphone<br>";
}
} else {
if($rs_pcphone != "") {
echo "$rs_pcphone<br>";
} elseif ($rs_pcworkphone != "") {
echo "$rs_pcworkphone<br>";
} else {
echo "$rs_pccellphone<br>";
}
}

if($rs_pcemail != "") {
echo "<a href=\"mailto:$rs_pcemail\">$rs_pcemail</a><br>";
}

echo "$rs_pcmake<br>";




echo "</td></tr>";



echo "<tr><td>";

$chktelog = "SELECT refid FROM userlog WHERE reftype = 'woid' AND actionid = '25' AND refid = '$woid'";
$rs_resultcl = mysqli_query($rs_connect, $chktelog);
if (mysqli_num_rows($rs_resultcl) != "0") {

} else {
echo "<button type=button onClick=\"parent.location='pc.php?func=emailthankyou&woid=$woid&email=$rs_pcemail'\"><i class=\"fa fa-exclamation-circle fa-lg\"></i> TY</button>";
}

echo "</td><td>";

echo pcrtlang("Problem").":<br>";

echo "$probdesc<br><br>";

echo pcrtlang("Picked-Up On").": <br>$pickdate";





echo "</td></tr>";

}
}


echo "</table>";


echo "<br>";

echo "<center>";

#browse here
$totalentry = mysqli_num_rows($rs_result_total);
$prevpage = $pageNumber - 1;
$nextpage = $pageNumber + 1;

if ($pageNumber > 1) {
echo "<button type=button onClick=\"parent.location='workorders.php?func=wolist&pageNumber=$prevpage'\"><i class=\"fa fa-chevron-left fa-lg\"></i></button>";
}

$total_results = $totalentry;
$results_per_page = $results_per_page;
$html = get_paged_nav($total_results, $results_per_page, false);
echo "$html";

if (($totalentry / $results_per_page) > $pageNumber) {
echo "<button type=button onClick=\"parent.location='workorders.php?func=wolist&pageNumber=$nextpage'\"><i class=\"fa fa-chevron-right fa-lg\"></i></button>";
}

echo "</center>";

require("footer.php");

}



######

switch($func) {
                                                                                                    
    default:
    wolist();
    break;
                                
    case "wolist":
    wolist();
    break;


}

?>

