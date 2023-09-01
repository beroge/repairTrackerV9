<?php
                                                                                                    
/***************************************************************************
 *   copyright            : (C) 2019 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/

require("deps.php");
require("restcommon.php");

if (array_key_exists('api_key',$_REQUEST)) {
$hash = pv($_REQUEST['api_key']);
if($hash != "") {
$rs_ql = "SELECT storehash FROM stores WHERE storehash = '$hash'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$totalresult = mysqli_num_rows($rs_result1);
} else {
$totalresult = 0;
}
} else {
$totalresult = 0;
}

if ($totalresult == 0) {
header('Content-Type: application/json');
header('Status: 400');
exit();
}



if (array_key_exists('func',$_REQUEST)) {
$func = $_REQUEST['func'];
} else {
$func = "";
}

                                                                                                    
function nothing() {
echo "Have a great day!";
}




##########

function stickynotes() {

require("deps.php");
require_once("restcommon.php");

if (array_key_exists('offset',$_REQUEST)) {
$offset = pv($_REQUEST['offset']);
} else {
$offset = "0";
}

if (array_key_exists('records',$_REQUEST)) {
$records = pv($_REQUEST['records']);
} else {
$records = "20";
}


if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}


header('Content-Type: application/json');
header('Status: 200');
$jsonout = "[\n";

$rs_findnotes = "SELECT * FROM stickynotes ORDER BY stickyid DESC LIMIT $offset,$records";
$rs_result = mysqli_query($rs_connect, $rs_findnotes);

while($rs_result_qn5 = mysqli_fetch_object($rs_result)) {
$stickyid = "$rs_result_qn5->stickyid";
$stickyaddy1 = "$rs_result_qn5->stickyaddy1";
$stickyaddy2 = "$rs_result_qn5->stickyaddy2";
$stickycity = "$rs_result_qn5->stickycity";
$stickystate = "$rs_result_qn5->stickystate";
$stickyzip = "$rs_result_qn5->stickyzip";
$stickyphone = "$rs_result_qn5->stickyphone";
$stickyemail = "$rs_result_qn5->stickyemail";
$stickyduedateorig = "$rs_result_qn5->stickyduedate";
$stickytypeid = "$rs_result_qn5->stickytypeid";
$stickyuser = "$rs_result_qn5->stickyuser";
$stickynote_orig = "$rs_result_qn5->stickynote";
$stickynote = nl2br($stickynote_orig);
$stickyname = "$rs_result_qn5->stickyname";
$stickycompany = "$rs_result_qn5->stickycompany";
$storeid = "$rs_result_qn5->storeid";


$stickystartdate = date('Y-m-d H:i:s',strtotime("$stickyduedateorig"));
$stickystartdate8601 = date('c',strtotime("$stickyduedateorig"));
$plusonehour = strtotime($stickyduedateorig) + 3600;
$stickyenddate = date('Y-m-d H:i:s', "$plusonehour");
$stickyenddate8601 = date('c', "$plusonehour");

$rs_qst = "SELECT * FROM stickytypes WHERE stickytypeid = '$stickytypeid'";
$rs_resultst1 = mysqli_query($rs_connect, $rs_qst);
if(mysqli_num_rows($rs_resultst1) == "1") {
$rs_result_stq1 = mysqli_fetch_object($rs_resultst1);
$stickytypename = "$rs_result_stq1->stickytypename";
} else {
$stickytypename = "Undefined Type";
}

$rs_find_stores = "SELECT * FROM stores WHERE storeid = '$storeid'";
$rs_result_stores = mysqli_query($rs_connect,$rs_find_stores);
$rs_result_storeq = mysqli_fetch_object($rs_result_stores);
$storesname = "$rs_result_storeq->storesname";



$json = json_encode(
array(
"id" => "$stickyid",
"Message" => "$stickynote_orig",
"Summary" => "$stickytypename",
"StartDate" => "$stickystartdate",
"EndDate" => "$stickyenddate",
"StartDate8601" => "$stickystartdate8601",
"EndDate8601" => "$stickyenddate8601",
"Location" => "$stickyaddy1 $stickycity, $stickystate $stickyzip",
"Name" => "$stickyname",
"Company" => "$stickycompany",
"Address" => "$stickyaddy1",
"City" => "$stickycity",
"State" => "$stickystate",
"PostCode" => "$stickyzip",
"Phone" => "$stickyphone",
"Email" => "$stickyemail",
"AssignedUser" => "$stickyuser",
"StoreName" => "$storesname",
"Store" => "$storeid"
)
, JSON_PRETTY_PRINT);

$jsonout .= "$json,\n";

}

echo mb_substr($jsonout, 0, -2);

echo "\n]";

}



##########

function groups() {

require("deps.php");
require_once("restcommon.php");

if (array_key_exists('offset',$_REQUEST)) {
$offset = pv($_REQUEST['offset']);
} else {
$offset = "1";
}

if (array_key_exists('records',$_REQUEST)) {
$records = pv($_REQUEST['records']);
} else {
$records = "50";
}


if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}


header('Content-Type: application/json');
header('Status: 200');
$jsonout = "[\n";



$rs_find_group_items = "SELECT * FROM pc_group ORDER BY pcgroupid DESC LIMIT $offset,$records";
$rs_result = mysqli_query($rs_connect, $rs_find_group_items);


while($rs_result_q = mysqli_fetch_object($rs_result)) {
$pcgroupid = "$rs_result_q->pcgroupid";
$name = "$rs_result_q->pcgroupname";
$company = "$rs_result_q->grpcompany";
$phone = "$rs_result_q->grpphone";
$mobilephone = "$rs_result_q->grpcellphone";
$workphone = "$rs_result_q->grpworkphone";
$email = "$rs_result_q->grpemail";
$address = "$rs_result_q->grpaddress1";
$address2 = "$rs_result_q->grpaddress2";
$city = "$rs_result_q->grpcity";
$state = "$rs_result_q->grpstate";
$zip = "$rs_result_q->grpzip";
$notes = "$rs_result_q->grpnotes";

$json = json_encode(
array(
"id" => "$pcgroupid",
"CustomerName" => "$name",
"Company" => "$company",
"Phone" => "$phone",
"MobilePhone" => "$mobilephone",
"WorkPhone" => "$workphone",
"Email" => "$email",
"Address" => "$address",
"Address2" => "$address2",
"City" => "$city",
"State" => "$state",
"Zip" => "$zip",
"Notes" => "$notes"
)
, JSON_PRETTY_PRINT);

$jsonout .= "$json,\n";

}

echo mb_substr($jsonout, 0, -2);

echo "\n]";

}


############################################

function invoices() {

require("deps.php");
require_once("restcommon.php");

if (array_key_exists('offset',$_REQUEST)) {
$offset = pv($_REQUEST['offset']);
} else {
$offset = "0";
}

if (array_key_exists('records',$_REQUEST)) {
$records = pv($_REQUEST['records']);
} else {
$records = "50";
}

if (array_key_exists('invstatus',$_REQUEST)) {
$invstatus = pv($_REQUEST['invstatus']);
} else {
$invstatus = "2";
}

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}


header('Content-Type: application/json');
header('Status: 200');
$jsonout = "[\n";


$rs_find_invoices = "SELECT * FROM invoices WHERE invstatus = '$invstatus' ORDER BY invoice_id DESC LIMIT $offset,$records";
$rs_result_invoices = mysqli_query($rs_connect, $rs_find_invoices);


while ($rs_result_name_q = mysqli_fetch_object($rs_result_invoices)) {
$rs_invoice_id = "$rs_result_name_q->invoice_id";
$rs_soldto = "$rs_result_name_q->invname";
$rs_company = "$rs_result_name_q->invcompany";
$rs_ad1 = "$rs_result_name_q->invaddy1";
$rs_ad2 = "$rs_result_name_q->invaddy2";
$rs_city = "$rs_result_name_q->invcity";
$rs_state = "$rs_result_name_q->invstate";
$rs_zip = "$rs_result_name_q->invzip";
$rs_ph = "$rs_result_name_q->invphone";
$rs_datesold = "$rs_result_name_q->invdate";
$rs_woid = "$rs_result_name_q->woid";
$invnotes = "$rs_result_name_q->invnotes";
$rs_storeid = "$rs_result_name_q->storeid";
$preinvoice = "$rs_result_name_q->preinvoice";
$rs_email = "$rs_result_name_q->invemail";
$invstatus = "$rs_result_name_q->invstatus";

$rs_datesold8601 = date('c',strtotime("$rs_datesold"));

$storeinfoarray = getstoreinfo($rs_storeid);

$json = array(
"id" => "$rs_invoice_id",
"CustomerName" => "$rs_soldto",
"Company" => "$rs_company",
"Date" => "$rs_datesold",
"Date8601" => "$rs_datesold8601",
"AddressLine1" => "$rs_ad1",
"AddressLine2" => "$rs_ad2",
"City" => "$rs_city",
"State" => "$rs_state",
"PostCode" => "$rs_zip",
"Phone" => "$rs_ph",
"Email" => "$rs_email",
"Notes" => "$invnotes",
"StoreName" => "$storeinfoarray[storesname]",
"Store" => "$rs_storeid"
);


$storeinfoarray = getstoreinfo($rs_storeid);

$mastertaxtotals = array();


$rs_find_cart_items = "SELECT cart_item_id, cart_price, labor_desc, cart_stock_id, origprice, discounttype, price_alt, taxex, itemtax, itemserial, quantity, unit_price, MIN(addtime) AS addtime FROM invoice_items WHERE cart_type = 'purchase' AND invoice_id = '$rs_invoice_id' ORDER BY addtime ASC";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);


while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_cart_item_id = "$rs_result_q->cart_item_id";
$rs_cart_price = "$rs_result_q->cart_price";
$rs_stock_id = "$rs_result_q->cart_stock_id";
$rs_labordesc = "$rs_result_q->labor_desc";
$origprice = "$rs_result_q->origprice";
$discounttype = "$rs_result_q->discounttype";
$price_alt = "$rs_result_q->price_alt";
$itemserial = "$rs_result_q->itemserial";
$taxex = "$rs_result_q->taxex";
$itemtax = "$rs_result_q->itemtax";
$quantity = "$rs_result_q->quantity";
$unit_price = "$rs_result_q->unit_price";

$rs_tax_total2 = $itemtax * $rs_itemtotal * $quantity;
$rs_tax_total = number_format($rs_tax_total2, 2, '.', '');

if ($rs_stock_id != "0") {
$rs_find_item_detail = "SELECT * FROM stock WHERE stock_id = '$rs_stock_id'";
$rs_find_result = mysqli_query($rs_connect, $rs_find_item_detail);
$rs_stocktitlea = mysqli_fetch_object($rs_find_result);
$rs_stocktitle = "$rs_stocktitlea->stock_title";
} else {
$rs_stocktitle = "$rs_labordesc";
}

#newtaxcode
$salestaxrate = getsalestaxrate($taxex);
$isgrouprate = isgrouprate($taxex);

if($isgrouprate == 0) {
$lineitemtax[$taxex] = $rs_tax_total;
if(!array_key_exists("$taxex", $mastertaxtotals)) {
$mastertaxtotals[$taxex]['parts'] = $salestaxrate * $rs_cart_price;
$mastertaxtotals[$taxex]['labor'] = 0;
$mastertaxtotals[$taxex]['return'] = 0;
} else {
$mastertaxtotals[$taxex]['parts'] = ($salestaxrate * $rs_cart_price) + $mastertaxtotals[$taxex]['parts'];
}
} else {
$grouprates = getgrouprates($taxex);

foreach($grouprates as $key => $val) {
$salestaxratei = getsalestaxrate($val);

$lineitemtax[$val] = $salestaxratei * $rs_cart_price;

if(!array_key_exists("$val", $mastertaxtotals)) {
$mastertaxtotals[$val]['parts'] = $salestaxratei * $rs_cart_price;
$mastertaxtotals[$val]['labor'] = 0;
$mastertaxtotals[$val]['return'] = 0;
} else {
$mastertaxtotals[$val]['parts'] = ($salestaxratei * $rs_cart_price) + $mastertaxtotals[$val]['parts'];
}

}
}
####

$rs_cart_price_total = $rs_cart_price;

$taxesitems = array();

reset($lineitemtax);
foreach($lineitemtax as $key => $val) {
$shortname = gettaxshortname($key);
if($val != 0) {
$taxesitems[] = array("TaxName" => "$shortname", "TaxAmount" => "$val");
}
}
unset($lineitemtax);

$lineitemtaxname = gettaxshortname($taxex);

$json['lineitems'][] = array(
"CartItemId" => "$rs_cart_item_id",
"Quantity" => "$rs_itemtotal",
"Title" => "$rs_stocktitle",
"SerialCode" => "$itemserial",
"UnitPrice" => "$rs_cart_price",
"TotalPrice" => "$rs_cart_price_total",
"ItemTaxes" => $taxesitems,
"TaxId" => $taxex,
"LineItemTaxTotal" => $itemtax,
"LineItemTaxName" => "$lineitemtaxname",
"LineItemType" => "tangible"
);

unset($taxesitems);

}



$rs_find_cart_labor = "SELECT * FROM invoice_items WHERE cart_type = 'labor' AND invoice_id = '$rs_invoice_id' ORDER BY addtime ASC";
$rs_result_labor = mysqli_query($rs_connect, $rs_find_cart_labor);

while($rs_result_labor_q = mysqli_fetch_object($rs_result_labor)) {
$rs_cart_labor_id = "$rs_result_labor_q->cart_item_id";
$rs_cart_labor_price = "$rs_result_labor_q->cart_price";
$rs_cart_labor_desc = "$rs_result_labor_q->labor_desc";
$lorigprice = "$rs_result_labor_q->origprice";
$ldiscounttype = "$rs_result_labor_q->discounttype";
$lprice_alt = "$rs_result_labor_q->price_alt";
$ltaxex = "$rs_result_labor_q->taxex";
$litemtax = "$rs_result_labor_q->itemtax";
$lunit_price = "$rs_result_labor_q->unit_price";
$lquantity = "$rs_result_labor_q->quantity";

#newtaxcode
$servicetaxrate = getservicetaxrate($ltaxex);
$isgrouprate = isgrouprate($ltaxex);

if($isgrouprate == 0) {
$laboritemtax[$ltaxex] = $litemtax;
if(!array_key_exists("$ltaxex", $mastertaxtotals)) {
$mastertaxtotals[$ltaxex]['parts'] = 0;
$mastertaxtotals[$ltaxex]['labor'] = $servicetaxrate * $rs_cart_labor_price;
$mastertaxtotals[$ltaxex]['return'] = 0;
} else {
$mastertaxtotals[$ltaxex]['labor'] = ($servicetaxrate * $rs_cart_labor_price) + $mastertaxtotals[$ltaxex]['labor'];
}
} else {
$grouprates = getgrouprates($ltaxex);
foreach($grouprates as $key => $val) {
$servicetaxratei = getservicetaxrate($val);

$laboritemtax[$val] = $servicetaxratei * $rs_cart_labor_price;

if(!array_key_exists("$val", $mastertaxtotals)) {
$mastertaxtotals[$val]['parts'] = 0;
$mastertaxtotals[$val]['labor'] = $servicetaxratei * $rs_cart_labor_price;
$mastertaxtotals[$val]['return'] = 0;
} else {
$mastertaxtotals[$val]['labor'] = ($servicetaxratei * $rs_cart_labor_price) + $mastertaxtotals[$val]['labor'];
}

}
}
####

$taxeslabor = array();

reset($laboritemtax);
foreach($laboritemtax as $key => $val) {
$shortname = gettaxshortname($key);
if($val != 0) {
$taxeslabor[] = array("TaxName" => "$shortname", "TaxAmount" => "$val");
}
}
unset($laboritemtax);

$lineitemtaxname = gettaxshortname($ltaxex);

$json['lineitems'][] = array(
"CartItemId" => "$rs_cart_labor_id",
"Quantity" => "$lquantity",
"Title" => "$rs_cart_labor_desc",
"SerialCode" => "",
"UnitPrice" => "$lunit_price",
"TotalPrice" => "$rs_cart_labor_price",
"ItemTaxes" => $taxeslabor,
"TaxId" => $ltaxex,
"LineItemTaxTotal" => $litemtax,
"LineItemTaxName" => "$lineitemtaxname",
"LineItemType" => "non-tangible"
);

unset($taxeslabor);

}

$rs_find_item_total = "SELECT SUM(cart_price) AS total_price_parts FROM invoice_items WHERE cart_type = 'purchase' AND invoice_id = '$rs_invoice_id'";
$rs_find_result_total = mysqli_query($rs_connect, $rs_find_item_total);

while($rs_find_result_total_q = mysqli_fetch_object($rs_find_result_total)) {
$rs_total_parts = "$rs_find_result_total_q->total_price_parts";
}

if ($rs_total_parts == "") {
$rs_total_parts = "0.00";
}

$json['TangibleSubtotal'] = "$rs_total_parts";

$rs_find_itemtax_total = "SELECT SUM(itemtax) AS total_tax_parts FROM invoice_items WHERE cart_type = 'purchase' AND invoice_id = '$rs_invoice_id'";
$rs_find_result_taxtotal = mysqli_query($rs_connect, $rs_find_itemtax_total);
while($rs_find_result_taxtotal_q = mysqli_fetch_object($rs_find_result_taxtotal)) {
$rs_total_partstax = "$rs_find_result_taxtotal_q->total_tax_parts";

$salestax = $rs_total_partstax;

}




$rs_find_labor_total = "SELECT SUM(cart_price) AS total_labor_price FROM invoice_items WHERE cart_type = 'labor' AND invoice_id = '$rs_invoice_id'";
$rs_find_result_labor_total = mysqli_query($rs_connect, $rs_find_labor_total);


while($rs_find_result_labor_total_q = mysqli_fetch_object($rs_find_result_labor_total)) {
$rs_total_labor = "$rs_find_result_labor_total_q->total_labor_price";
}
if ($rs_total_labor == "") {
$rs_total_labor = "0.00";
}

$json['NonTangibleSubtotal'] = "$rs_total_labor";

$rs_find_labortax_total = "SELECT SUM(itemtax) AS total_labortax_price FROM invoice_items WHERE cart_type = 'labor' AND invoice_id = '$rs_invoice_id'";
$rs_find_result_taxlabor_total = mysqli_query($rs_connect, $rs_find_labortax_total);
while($rs_find_result_labortax_total_q = mysqli_fetch_object($rs_find_result_taxlabor_total)) {
$rs_total_labortax = "$rs_find_result_labortax_total_q->total_labortax_price";

$servicetax = $rs_total_labortax;

}


$grand_total = ($salestax + $rs_total_parts + $rs_total_labor + $servicetax);

reset($mastertaxtotals);
foreach($mastertaxtotals as $key => $val) {

$taxname = gettaxshortname($key);

$taxtotal = ($mastertaxtotals[$key]['parts'] + $mastertaxtotals[$key]['labor']);
if($taxtotal != "0") {
$json['Tax'][] = array("TaxId" => "$key", "TaxName" => "$taxname", "Total" => "$taxtotal");
}
}

$json['TotalTax'] = ($salestax + $servicetax);

$json['InvoiceTotal'] = "$grand_total";

$jsonout .= json_encode($json, JSON_PRETTY_PRINT);
$jsonout .= ",\n";

}


echo mb_substr($jsonout, 0, -2);

echo "\n]";


}



function workorders() {

require("deps.php");
require_once("restcommon.php");

if (array_key_exists('offset',$_REQUEST)) {
$offset = pv($_REQUEST['offset']);
} else {
$offset = "1";
}

if (array_key_exists('records',$_REQUEST)) {
$records = pv($_REQUEST['records']);
} else {
$records = "50";
}


if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}


header('Content-Type: application/json');
header('Status: 200');
$jsonout = "[\n";



$rs_findpc = "SELECT * FROM pc_wo ORDER BY dropdate DESC LIMIT $offset,$records";
$rs_result = mysqli_query($rs_connect, $rs_findpc);
while($rs_result_q = mysqli_fetch_object($rs_result)) {
$woid = "$rs_result_q->woid";
$pcid = "$rs_result_q->pcid";
$probdesc = "$rs_result_q->probdesc";
$dropoff = "$rs_result_q->dropdate";
$pickup = "$rs_result_q->pickupdate";
$pcstatus = "$rs_result_q->pcstatus";
$cobyuser = "$rs_result_q->cobyuser";
$cibyuser = "$rs_result_q->cibyuser";
$theprobsindb = serializedarraytest("$rs_result_q->commonproblems");
$assigneduser = "$rs_result_q->assigneduser";

$boxstyles = getboxstyle($pcstatus);


$dropoff8601 = date('c',strtotime("$dropoff"));
$pickup8601 = date('c',strtotime("$pickup"));

$rs_findowner = "SELECT * FROM pc_owner WHERE pcid = '$pcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
while ($rs_result_q2 = mysqli_fetch_object($rs_result2)) {
$pcname = "$rs_result_q2->pcname";
$pccompany = "$rs_result_q2->pccompany";
$pcphone = "$rs_result_q2->pcphone";
$pccellphone = "$rs_result_q2->pccellphone";
$pcworkphone = "$rs_result_q2->pcworkphone";
$pcmake = "$rs_result_q2->pcmake";
$pcaddress = "$rs_result_q2->pcaddress";
$pcaddress2 = "$rs_result_q2->pcaddress2";
$pccity = "$rs_result_q2->pccity";
$pcstate = "$rs_result_q2->pcstate";
$pczip = "$rs_result_q2->pczip";
$pcemail = "$rs_result_q2->pcemail";
$pcnotes = "$rs_result_q2->pcnotes";
$pcmake = "$rs_result_q2->pcmake";
$pcgroupid = "$rs_result_q2->pcgroupid";





$json = array(
"id" => "$woid",
"AssetId" => "$pcid",
"AssetGroupId" => "$pcgroupid",
"CustomerName" => "$pcname",
"Company" => "$pccompany",
"Phone" => "$pcphone",
"MobilePhone" => "$pccellphone",
"WorkPhone" => "$pcworkphone",
"Email" => "$pcemail",
"Address" => "$pcaddress",
"Address2" => "$pcaddress2",
"City" => "$pccity",
"State" => "$pcstate",
"Zip" => "$pczip",
"AssetMake" => "$pcmake",
"DropoffDate" => "$dropoff",
"AssignedUser" => "$assigneduser",
"CheckedInBy" => "$cibyuser",
"CheckedOutBy" => "$cobyuser",
"PickupDate" => "$pickup",
"CurrentStatus" => "$boxstyles[boxtitle]",
"Notes" => "$pcnotes"
);




$rs_findnotes = "SELECT * FROM wonotes WHERE woid = '$woid' AND notetype = '0' ORDER BY notetime ASC";
$rs_result_n = mysqli_query($rs_connect, $rs_findnotes);
while($rs_result_qn = mysqli_fetch_object($rs_result_n)) {
$thenote = "$rs_result_qn->thenote";
$noteuser = "$rs_result_qn->noteuser";
$noteid = "$rs_result_qn->noteid";
$notetime = "$rs_result_qn->notetime";

$json['CustomerNotes'][] = array(
"NoteId" => "$noteid",
"Note" => "$thenote",
"NoteDateTime" => "$notetime",
"ByUser" => "$noteuser"
);
}

$rs_findnotes = "SELECT * FROM wonotes WHERE woid = '$woid' AND notetype = '1' ORDER BY notetime ASC";
$rs_result_n = mysqli_query($rs_connect, $rs_findnotes);
while($rs_result_qn = mysqli_fetch_object($rs_result_n)) {
$thenote = "$rs_result_qn->thenote";
$noteuser = "$rs_result_qn->noteuser";
$noteid = "$rs_result_qn->noteid";
$notetime = "$rs_result_qn->notetime";

$json['PrivateNotes'][] = array(
"NoteId" => "$noteid",
"Note" => "$thenote",
"NoteDateTime" => "$notetime",
"ByUser" => "$noteuser"
);
}



$jsonout .= json_encode($json, JSON_PRETTY_PRINT);
$jsonout .= ",\n";


}
}

echo mb_substr($jsonout, 0, -2);

echo "\n]";

}



function postgroups() {

require("deps.php");
require_once("restcommon.php");


$json = file_get_contents('php://input');
$data = json_decode($json, true);



if (array_key_exists('GroupName',$data)) {
$pcgroupname = $data['GroupName'];
} else {
$pcgroupname = "";
}

if($pcgroupname == "") {
$pcgroupname = "Customer";
}


if (array_key_exists('GroupCompany',$data)) {
$pccompany = $data['GroupCompany'];
} else {
$pccompany = "";
}

if (array_key_exists('AddressLine1',$data)) {
$pcaddress1 = $data['AddressLine1'];
} else {
$pcaddress1 = "";
}

if (array_key_exists('AddressLine2',$data)) {
$pcaddress2 = $data['AddressLine2'];
} else {
$pcaddress2 = "";
}

if (array_key_exists('City',$data)) {
$pccity = $data['City'];
} else {
$pccity = "";
}

if (array_key_exists('State',$data)) {
$pcstate = $data['State'];
} else {
$pcstate = "";
}

if (array_key_exists('PostCode',$data)) {
$pczip = $data['PostCode'];
} else {
$pczip = "";
}

if (array_key_exists('Email',$data)) {
$pcemail = $data['Email'];
} else {
$pcemail = "";
}

if (array_key_exists('Phone',$data)) {
$pchomephone = $data['Phone'];
} else {
$pchomephone = "";
}

if (array_key_exists('MobilePhone',$data)) {
$pccellphone = $data['MobilePhone'];
} else {
$pccellphone = "";
}

if (array_key_exists('WorkPhone',$data)) {
$pcworkphone = $data['WorkPhone'];
} else {
$pcworkphone = "";
}



$rs_insert_group = "INSERT INTO pc_group (pcgroupname,grpcompany,grpaddress1,grpaddress2,grpcity,grpstate,grpzip,grpemail,grpphone,grpcellphone,grpworkphone)
VALUES ('$pcgroupname','$pccompany','$pcaddress1','$pcaddress2','$pccity','$pcstate','$pczip','$pcemail','$pchomephone','$pccellphone','$pcworkphone')";
@mysqli_query($rs_connect, $rs_insert_group);


}



function fetchstores() {

require("deps.php");
require_once("restcommon.php");

$jsonout = "[\n";

$rs_find_stores = "SELECT * FROM stores";
$rs_result_stores = mysqli_query($rs_connect,$rs_find_stores);
while ($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
$storesname = "$rs_result_storeq->storesname";
$storename = "$rs_result_storeq->storename";
$storeid = "$rs_result_storeq->storeid";

$json = json_encode(
array(
"id" => "$storeid",
"StoreShortName" => "$storesname",
"StoreName" => "$storename"
)
, JSON_PRETTY_PRINT);

$jsonout .= "$json,\n";

}

echo mb_substr($jsonout, 0, -2);

echo "\n]";

}



function poststickynotes() {

require("deps.php");
require_once("restcommon.php");


if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}

$json = file_get_contents('php://input');
$data = json_decode($json, true);



if (array_key_exists('CustomerName',$data)) {
$stickyname = $data['CustomerName'];
} else {
$stickyname = "";
}

if($stickyname == "") {
$stickyname = "Customer";
}

if (array_key_exists('Company',$data)) {
$stickycompany = $data['Company'];
} else {
$stickycompany = "";
}

if (array_key_exists('AddressLine1',$data)) {
$stickyaddy1 = $data['AddressLine1'];
} else {
$stickyaddy1 = "";
}

if (array_key_exists('AddressLine2',$data)) {
$stickyaddy2 = $data['AddressLine2'];
} else {
$stickyaddy2 = "";
}

if (array_key_exists('City',$data)) {
$stickycity = $data['City'];
} else {
$stickycity = "";
}

if (array_key_exists('State',$data)) {
$stickystate = $data['State'];
} else {
$stickystate = "";
}

if (array_key_exists('PostCode',$data)) {
$stickyzip = $data['PostCode'];
} else {
$stickyzip = "";
}
if (array_key_exists('Email',$data)) {
$stickyemail = $data['Email'];
} else {
$stickyemail = "";
}

if (array_key_exists('Phone',$data)) {
$stickyphone = $data['Phone'];
} else {
$stickyphone = "";
}

if (array_key_exists('Note',$data)) {
$stickynote = $data['Note'];
} else {
$stickynote = "";
}

if (array_key_exists('StickyTypeId',$data)) {
$stickytypeid = $data['StickyTypeId'];
} else {
$stickytypeid = "1";
}


if (array_key_exists('StoreId',$data)) {
$stickystoreid = $data['StoreId'];
} else {
$stickystoreid = "1";
}

if (array_key_exists('StartDate',$data)) {
$stickyduedate2 = $data['StartDate'];
$stickyduedate = date('Y-m-d H:i:s', strtotime("$stickyduedate2"));
} else {
$stickyduedate = time();
}


$rs_insert_cart = "INSERT INTO stickynotes (stickyname,stickycompany,stickyaddy1,stickyaddy2,stickycity,stickystate,stickyzip,stickyphone,stickyemail,
stickytypeid,
stickyduedate,stickynote,storeid) VALUES  ('$stickyname','$stickycompany','$stickyaddy1','$stickyaddy2','$stickycity','$stickystate','$stickyzip'
,'$stickyphone','$stickyemail','$stickytypeid','$stickyduedate','$stickynote','$stickystoreid')";
@mysqli_query($rs_connect, $rs_insert_cart);


}



function fetchstickytypes() {

require("deps.php");
require_once("restcommon.php");

$jsonout = "[\n";

$rs_find_st = "SELECT * FROM stickytypes";
$rs_result_st = mysqli_query($rs_connect,$rs_find_st);
while ($rs_result_stq = mysqli_fetch_object($rs_result_st)) {
$stickyid = "$rs_result_stq->stickytypeid";
$stickytypename = "$rs_result_stq->stickytypename";

$json = json_encode(
array(
"id" => "$stickyid",
"StickyTypeName" => "$stickytypename"
)
, JSON_PRETTY_PRINT);

$jsonout .= "$json,\n";

}

echo mb_substr($jsonout, 0, -2);

echo "\n]";

}



function postservicerequests() {

require("deps.php");
require_once("restcommon.php");


$json = file_get_contents('php://input');
$data = json_decode($json, true);



if (array_key_exists('CustomerName',$data)) {
$sreq_name = $data['CustomerName'];
} else {
$sreq_name = "";
}

if($sreq_name == "") {
$sreq_name = "Customer";
}


if (array_key_exists('Company',$data)) {
$sreq_company = $data['Company'];
} else {
$sreq_company = "";
}

if (array_key_exists('AddressLine1',$data)) {
$sreq_addy1 = $data['AddressLine1'];
} else {
$sreq_addy1 = "";
}
if (array_key_exists('AddressLine2',$data)) {
$sreq_addy2 = $data['AddressLine2'];
} else {
$sreq_addy2 = "";
}

if (array_key_exists('City',$data)) {
$sreq_city = $data['City'];
} else {
$sreq_city = "";
}

if (array_key_exists('State',$data)) {
$sreq_state = $data['State'];
} else {
$sreq_state = "";
}

if (array_key_exists('PostCode',$data)) {
$sreq_zip = $data['PostCode'];
} else {
$sreq_zip = "";
}

if (array_key_exists('Email',$data)) {
$sreq_email = $data['Email'];
} else {
$sreq_email = "";
}

if (array_key_exists('Phone',$data)) {
$sreq_phone = $data['Phone'];
} else {
$sreq_phone = "";
}
if (array_key_exists('MobilePhone',$data)) {
$sreq_cellphone = $data['MobilePhone'];
} else {
$sreq_cellphone = "";
}

if (array_key_exists('WorkPhone',$data)) {
$sreq_workphone = $data['WorkPhone'];
} else {
$sreq_workphone = "";
}

if (array_key_exists('Message',$data)) {
$sreq_problem = $data['Message'];
} else {
$sreq_problem = "";
}

if (array_key_exists('DeviceMake',$data)) {
$sreq_model = $data['DeviceMake'];
} else {
$sreq_model = "";
}

if (array_key_exists('DeviceType',$data)) {
$sreq_type = $data['DeviceType'];
} else {
$sreq_type = "";
}

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}

$currentdatetime = date('Y-m-d H:i:s');

$rs_insert_sq = "INSERT INTO servicerequests (sreq_name,sreq_company,sreq_homephone,sreq_cellphone,sreq_workphone,sreq_addy1,sreq_addy2,sreq_city,sreq_state,sreq_zip,sreq_email,sreq_problem,sreq_model,sreq_datetime) VALUES ('$sreq_name','$sreq_company','$sreq_phone','$sreq_cellphone','$sreq_workphone','$sreq_addy1','$sreq_addy2','$sreq_city','$sreq_state','$sreq_zip','$sreq_email','$sreq_problem','$sreq_model $sreq_type','$currentdatetime')";
@mysqli_query($rs_connect, $rs_insert_sq);


}




function postmessage() {

require("deps.php");
require_once("restcommon.php");

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}

$json = file_get_contents('php://input');
$data = json_decode($json, true);


$myfile = fopen("../attachments/log.txt", "w") or die("Unable to open file!");
$txt = print_r($data);
fwrite($myfile, $txt);
fclose($myfile);


if (array_key_exists('CustomerName',$data)) {
$emailname = $data['CustomerName'];
} else {
$emailname = "";
}

if (array_key_exists('EmailAddress',$data)) {
$emailaddress = $data['EmailAddress'];
} else {
$emailaddress = "";
}

if (array_key_exists('PhoneNumber',$data)) {
$phonenumber = $data['PhoneNumber'];
} else {
$phonenumber = "";
}


if (array_key_exists('Message',$data)) {
$messagewhole = $data['Message'];

$messageparts = explode("##-##", $messagewhole);
$message = $messageparts['0'];
$message = explode("\n", $message);
array_pop($message);
#array_pop($message);
$message = implode("\n", $message);
echo "$message";


} else {
$message = "";
}

if (array_key_exists('DateTime',$data)) {
$datetime2 = $data['DateTime'];
$datetime = date('Y-m-d H:i:s', strtotime("$datetime2"));
} else {
$datetime =  date('Y-m-d H:i:s');
}

#$myfile = fopen("../attachments/log.txt", "w") or die("Unable to open file!");
#$txt = print_r($data);
#$txt .= "\n\n $datetime \n\n $message \n\n $phonenumber \n\n $emailaddress \n\n $emailname";
#fwrite($myfile, $txt);
#fclose($myfile);


$message = pv($message);

if (filter_var($emailaddress, FILTER_VALIDATE_EMAIL)) {
$rs_insert_message = "INSERT INTO messages (messagefrom,messagebody,messagedatetime,messagevia,messagedirection)
VALUES ('$emailaddress','$message','$datetime','email','in')";
} else {
$rs_insert_message = "INSERT INTO messages (messagefrom,messagebody,messagedatetime,messagevia,messagedirection)
VALUES ('$phonenumber','$message','$datetime','im','in')";
}


@mysqli_query($rs_connect, $rs_insert_message);

}


function getpcimage() {

require("deps.php");
require_once("restcommon.php");

$photoid = $_REQUEST['photoid'];

$rs_findfileid = "SELECT photofilename FROM assetphotos WHERE assetphotoid = '$photoid'";
$rs_resultfid = mysqli_query($rs_connect, $rs_findfileid);
$rs_result_qfid = mysqli_fetch_object($rs_resultfid);
$photo_filename = "$rs_result_qfid->photofilename";


header("Content-Type: image/jpeg");
readfile("../pcphotos/$photo_filename");

}



switch($func) {
                                                                                                    
    default:
    nothing();
    break;
                                
    case "stickynotes":
    stickynotes();
    break;

    case "groups":
    groups();
    break;

    case "postgroups":
    postgroups();
    break;

    case "poststickynotes":
    poststickynotes();
    break;

    case "invoices":
    invoices();
    break;

    case "workorders":
    workorders();
    break;

    case "fetchstores":
    fetchstores();
    break;

    case "fetchstickytypes":
    fetchstickytypes();
    break;

    case "postservicerequests":
    postservicerequests();
    break;

    case "postmessage":
    postmessage();
    break;

    case "getpcimage":
    getpcimage();
    break;


}


