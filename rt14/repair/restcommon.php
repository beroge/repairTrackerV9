<?php

function getstoreinfo($storetoget) {

require("deps.php");
$rs_ql = "SELECT * FROM stores WHERE storeid = '$storetoget'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$storesname = "$rs_result_q1->storesname";
$storename = "$rs_result_q1->storename";
$storeaddy1 = "$rs_result_q1->storeaddy1";
$storeaddy2 = "$rs_result_q1->storeaddy2";
$storecity = "$rs_result_q1->storecity";
$storestate = "$rs_result_q1->storestate";
$storezip = "$rs_result_q1->storezip";
$storeemail = "$rs_result_q1->storeemail";
$storeccemail = "$rs_result_q1->ccemail";
$storephone = "$rs_result_q1->storephone";
$quotefooter = "$rs_result_q1->quotefooter";
$invoicefooter = "$rs_result_q1->invoicefooter";
$repairsheetfooter = "$rs_result_q1->repairsheetfooter";
$returnpolicy = "$rs_result_q1->returnpolicy";
$depositfooter = "$rs_result_q1->depositfooter";
$thankyouletter = "$rs_result_q1->thankyouletter";
$claimticket = "$rs_result_q1->claimticket";
$checkoutreceipt = "$rs_result_q1->checkoutreceipt";
$linecolor1 = "$rs_result_q1->linecolor1";
$linecolor2 = "$rs_result_q1->linecolor2";
$bgcolor1 = "$rs_result_q1->bgcolor1";
$bgcolor2 = "$rs_result_q1->bgcolor2";



$storeinfo = array(
"storesname" => "$storesname", 
"storename" => "$storename", 
"storeaddy1" => "$storeaddy1", 
"storeaddy2" => "$storeaddy2",
"storecity" => "$storecity",
"storestate" => "$storestate",
"storezip" => "$storezip",
"storeemail" => "$storeemail",
"storephone" => "$storephone",
"quotefooter" => "$quotefooter",
"invoicefooter" => "$invoicefooter",
"repairsheetfooter" => "$repairsheetfooter",
"returnpolicy" => "$returnpolicy",
"depositfooter" => "$depositfooter",
"thankyouletter" => "$thankyouletter",
"claimticket" => "$claimticket",
"checkoutreceipt" => "$checkoutreceipt",
"storeccemail" => "$storeccemail"
);

return $storeinfo;

}


function pv($value) {
require("deps.php");
$value2 = trim($value);
   return mysqli_real_escape_string($rs_connect, $value2);
}


function getsalestaxrate($taxid) {
require("deps.php");
$findtaxsql = "SELECT * FROM taxes WHERE taxid = $taxid";
$findtaxq = @mysqli_query($rs_connect, $findtaxsql);
$findtaxa = mysqli_fetch_object($findtaxq);
$taxrate = "$findtaxa->taxrategoods";
return $taxrate;
}

function getservicetaxrate($taxid) {
require("deps.php");
$findtaxsql = "SELECT * FROM taxes WHERE taxid = $taxid";
$findtaxq = @mysqli_query($rs_connect, $findtaxsql);
$findtaxa = mysqli_fetch_object($findtaxq);
$taxrate = "$findtaxa->taxrateservice";
return $taxrate;
}

function gettaxname($taxid) {
require("deps.php");
$findtaxsql = "SELECT * FROM taxes WHERE taxid = $taxid";
$findtaxq = @mysqli_query($rs_connect, $findtaxsql);
$findtaxa = mysqli_fetch_object($findtaxq);
$taxname = "$findtaxa->taxname";
return $taxname;
}


function isgrouprate($taxid) {
require("deps.php");

$findtaxgsql = "SELECT isgrouprate FROM taxes WHERE taxid = $taxid";
$findtaxgq = @mysqli_query($rs_connect, $findtaxgsql);
$findtaxga = mysqli_fetch_object($findtaxgq);
$isgrouprate = "$findtaxga->isgrouprate";
return $isgrouprate;
}

function getgrouprates($taxid) {
require("deps.php");

$findtaxgsql = "SELECT compositerate FROM taxes WHERE taxid = $taxid";
$findtaxgq = @mysqli_query($rs_connect, $findtaxgsql);
$findtaxga = mysqli_fetch_object($findtaxgq);
$compositerate2 = "$findtaxga->compositerate";
$compositerate = unserialize($compositerate2);
return $compositerate;
}


function gettaxshortname($taxid) {
require("deps.php");

$findtaxsql = "SELECT * FROM taxes WHERE taxid = $taxid";
$findtaxq = @mysqli_query($rs_connect, $findtaxsql);
$findtaxa = mysqli_fetch_object($findtaxq);
$taxname = "$findtaxa->shortname";
return $taxname;
}



function serializedarraytest($array) {
if ($array != "") {
$arrayout2 = unserialize($array);
if (is_array($arrayout2)) {
$arrayout = $arrayout2;
} else {
$arrayout = array();
}
} else {
$arrayout = array();
}

return $arrayout;
}



function getboxstyle($statusid) {
require("deps.php");
$rs_qc = "SELECT * FROM boxstyles WHERE statusid = '$statusid'";
$rs_result1 = mysqli_query($rs_connect, $rs_qc);

if (mysqli_num_rows($rs_result1) != "0") {
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$boxstyle = array();
$boxstyle['selectorcolor'] = "$rs_result_q1->selectorcolor";
$boxstyle['boxtitle'] = "$rs_result_q1->boxtitle";
} else {
$boxstyle = array();
$boxstyle['selectorcolor'] = "";
$boxstyle['boxtitle'] = "Undefined";
}


return $boxstyle;

}

