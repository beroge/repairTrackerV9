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



start_blue_box(pcrtlang("Browse Work Orders"));

echo "<table class=standard>";
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

if(mysqli_num_rows($rs_result) != 0) {


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
$rs_scid = "$rs_result_q->scid";

$rs_findpic = "SELECT * FROM assetphotos WHERE pcid = '$pcid' AND highlight='1'";
$rs_resultfindpic = mysqli_query($rs_connect, $rs_findpic);


echo "<tr>";
echo "<td>";



echo "<a href=\"index.php?pcwo=$woid\" class=\"imagelink\">";
if (mysqli_num_rows($rs_resultfindpic) != "0") {
$rs_resultpic_q2 = mysqli_fetch_object($rs_resultfindpic);
$assetphotoid = "$rs_resultpic_q2->assetphotoid";
echo "<img src=pc.php?func=getpcimage&photoid=$assetphotoid border=0 width=75><br>";
} else {
$medicon = brandicon("$rs_pcmake");
echo "<img src=images/pcs/$medicon border=0 width=64>";
}

echo "</td>";

echo "<td>";


echo " <a href=pc.php?func=showpc&pcid=$pcid class=\"linkbuttonsmall linkbuttongray radiusall\">$rs_pcname</a><br>";
echo "<i class=\"fa fa-tag\"></i> $pcid<br>";


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

if("$rs_pcemail" != "") {
echo "<a href=\"mailto:$rs_pcemail\" class=\"linkbuttontiny linkbuttongray radiusall\"><i class=\"fa fa-envelope fa-lg\"></i> $rs_pcemail</a><br>";
}

echo "$rs_pcmake<br>";




echo "</td>";



echo "<td style=\"width:50%\">";

echo pcrtlang("Problem").": ";

echo "$probdesc<br><br>";

$pickdate2 = pcrtdate("$pcrt_longdate", "$pickdate").", ".pcrtdate("$pcrt_time", "$pickdate");

echo pcrtlang("Closed On").": $pickdate2";


echo "</td><td>";


$chktelog = "SELECT refid FROM userlog WHERE reftype = 'woid' AND actionid = '25' AND refid = '$woid'";
$rs_resultcl = mysqli_query($rs_connect, $chktelog);
if (mysqli_num_rows($rs_resultcl) != "0") {

} else {
if("$rs_pcemail" != "") {
echo "<a href=\"pc.php?func=emailthankyou&woid=$woid&email=$rs_pcemail\" class=\"linkbuttontiny linkbuttongray radiusall\" style=\"margin:3px;\"><i class=\"fa fa-exclamation-circle fa-lg colormered\"></i> Send TY</a><br>";
}
}



$rs_find_invoices = "SELECT * FROM invoices WHERE (woid LIKE '%_$woid"."_%' OR woid = '$woid') AND iorq = 'invoice' AND invstatus < '3'";
$rs_resultinv = mysqli_query($rs_connect, $rs_find_invoices);
if(mysqli_num_rows($rs_resultinv) > 0) {
while($rs_result_qinv = mysqli_fetch_object($rs_resultinv)) {
$invoice_id = "$rs_result_qinv->invoice_id";

$findinvtotal = "SELECT SUM(cart_price) AS invsubtotal, SUM(itemtax) AS invtax FROM invoice_items WHERE invoice_id = '$invoice_id'";
$findinvq = @mysqli_query($rs_connect, $findinvtotal);
$findinva = mysqli_fetch_object($findinvq);
$invtax = "$findinva->invtax";
$invsubtotal = "$findinva->invsubtotal";
$invoicegrandtotal = $invtax + $invsubtotal;

echo " <a href=../store/invoice.php?func=printinv&invoice_id=$invoice_id class=\"linkbuttontiny linkbuttoninv radiusall\" style=\"margin:3px;\">
<img src=../store/images/invoice.png class=icontiny> $money".mf($invoicegrandtotal)."</a> ";
}
}
$rs_find_cart_items = "SELECT * FROM receipts WHERE (woid LIKE '%_$woid"."_%' OR woid = '$woid')";
$rs_resultrec = mysqli_query($rs_connect, $rs_find_cart_items);
if(mysqli_num_rows($rs_resultrec) > 0) {
echo "<br>";
while($rs_result_q = mysqli_fetch_object($rs_resultrec)) {
$rs_receipt_id = "$rs_result_q->receipt_id";
$rs_gt = "$rs_result_q->grandtotal";
echo " <a href=../store/receipt.php?func=show_receipt&receipt=$rs_receipt_id class=\"linkbuttontiny linkbuttonmoney radiusall\" style=\"margin:3px;\">
<img src=../store/images/receipts.png class=icontiny> $money".mf($rs_gt)."</a> ";
}
}

if ($rs_scid != "0") {

$rs_scn = "SELECT * FROM servicecontracts WHERE scid = '$rs_scid'";
$rs_resultscn = mysqli_query($rs_connect, $rs_scn);
$rs_result_scn = mysqli_fetch_object($rs_resultscn);
$scname = "$rs_result_scn->scname";

echo "<a href=\"msp.php?func=viewservicecontract&scid=$rs_scid\" class=\"linkbuttontiny linkbuttonblack radiusall\" style=\"margin:3px;\">";
echo "<i class=\"fa fa-file-text\"></i> $scname</a>";

}


echo "</td>";

echo "<td>";

echo "<a href=\"index.php?pcwo=$woid\" class=\"linkbuttonmedium radiusall\" style=\"background:#000000;text-align:center;\" ><i class=\"fa fa-chevron-right fa-lg\"></i></a>";


echo "</td>";


echo "</tr>";

}

}

echo "</table>";

stop_blue_box();

echo "<br>";

start_box();
echo "<center>";
#browse here
$totalentry = mysqli_num_rows($rs_result_total);
$prevpage = $pageNumber - 1;
$nextpage = $pageNumber + 1;

if ($pageNumber > 1) {
echo "<a href=workorders.php?func=wolist&pageNumber=$prevpage class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-left fa-lg\"></i></a>&nbsp;";
}

$total_results = $totalentry;
$results_per_page = $results_per_page;
$html = get_paged_nav($total_results, $results_per_page, false);
echo "$html";

if (($totalentry / $results_per_page) > $pageNumber) {
echo "<a href=workorders.php?func=wolist&pageNumber=$nextpage class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-right fa-lg\"></i></a>";
}

echo "</center>";
stop_box();

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

