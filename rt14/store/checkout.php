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


function checkout() {
require_once("validate.php");

require("deps.php");
require_once("common.php");

$grandtotal = $_REQUEST['grandtotal'];
$grandtax = $_REQUEST['grandtax'];
$cartcheck = $_REQUEST['cartcheck'];
$checkoutaction = $_REQUEST['checkoutaction'];
$cfirstname2 = pv($_REQUEST['cfirstname']);

if($cfirstname2 == "") {
$cfirstname = "Customer";
} else {
$cfirstname = "$cfirstname2";
}

$ccompany = pv($_REQUEST['ccompany']);
$caddress = pv($_REQUEST['caddress']);
$caddress2 = pv($_REQUEST['caddress2']);
$ccity = pv($_REQUEST['ccity']);
$cstate = pv($_REQUEST['cstate']);
$czip = pv($_REQUEST['czip']);
$cphone = pv($_REQUEST['cphone']);
$cemail = pv($_REQUEST['cemail']);
$woid = $_REQUEST['woid'];
$invoice_id = $_REQUEST['invoice_id'];

$registerid = getcurrentregister();


$findpaytotal = "SELECT SUM(amount) AS totalpayments FROM currentpayments WHERE byuser = '$ipofpc'";
$findpaytotalq = @mysqli_query($rs_connect, $findpaytotal);
$findpaytotala = mysqli_fetch_object($findpaytotalq);
$totalpayments = "$findpaytotala->totalpayments";

if ($checkoutaction == "purchase") {
if ($totalpayments != $grandtotal) {
die(pcrtlang("Someone has added or removed items or payments from the current cart")." <a href=cart.php>".pcrtlang("Reload Current Cart")."</a> $totalpayments : $grandtotal");
}
}

$cartcheckv = cartcheck();
if($cartcheck != $cartcheckv) die("Cart has changed <a href=cart.php>".pcrtlang("Reload Current Cart")."</a>");

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

####

if(($woid != "") && array_key_exists('statnum', $_REQUEST)) {
$statnum = $_REQUEST['statnum'];

$woidschecked = explode_list($woid);
foreach($woidschecked as $key => $indwoid) {
$rs_checkout11 = "UPDATE pc_wo SET pcstatus = '$statnum', cobyuser = '$ipofpc' WHERE woid = '$indwoid'";
@mysqli_query($rs_connect, $rs_checkout11);
if($statnum == 5) {
$rs_checkout22 = "UPDATE pc_wo SET pickupdate = '$currentdatetime' WHERE woid = '$indwoid' AND pickupdate = '0000-00-00 00:00:00'";
@mysqli_query($rs_connect, $rs_checkout22);

$setstatus = "UPDATE specialorders SET spoopenclosed = '1' WHERE spowoid = '$indwoid'";
@mysqli_query($rs_connect, $setstatus);


userlog(2,$indwoid,'woid','');
}
}
}
####

$rs_insert_receipt = "INSERT INTO receipts (pay_type,grandtotal,date_sold,grandtax,paywith,person_name,company,byuser,address1,address2,phone_number,city,state,zip,email,woid,invoice_id,storeid,registerid) VALUES  ('$checkoutaction','$grandtotal','$currentdatetime','$grandtax','split','$cfirstname','$ccompany','$ipofpc','$caddress','$caddress2','$cphone','$ccity','$cstate','$czip','$cemail','$woid','$invoice_id','$defaultuserstore','$registerid')";
@mysqli_query($rs_connect, $rs_insert_receipt);

$receiptnumber = mysqli_insert_id($rs_connect);

userlog(9,$receiptnumber,'receiptid','');


###

$rs_findpayments_sql = "SELECT * FROM currentpayments WHERE byuser = '$ipofpc'";
$rs_find_payments = @mysqli_query($rs_connect, $rs_findpayments_sql);
while($rs_find_payments_q = mysqli_fetch_object($rs_find_payments)) {
$pfirstname = pv($rs_find_payments_q->pfirstname);
$plastname = pv($rs_find_payments_q->plastname);
$pcompany = pv($rs_find_payments_q->pcompany);
$paddress = pv($rs_find_payments_q->paddress);
$paddress2 = pv($rs_find_payments_q->paddress2);
$pcity = pv($rs_find_payments_q->pcity);
$pstate = pv($rs_find_payments_q->pstate);
$pzip = pv($rs_find_payments_q->pzip);
$pphone = pv($rs_find_payments_q->pphone);
$pemail = pv($rs_find_payments_q->pemail);
$amount = pv($rs_find_payments_q->amount);
$paymentplugin = pv($rs_find_payments_q->paymentplugin);
$cc_number = "$rs_find_payments_q->cc_number";
$cc_expmonth = pv($rs_find_payments_q->cc_expmonth);
$cc_expyear = pv($rs_find_payments_q->cc_expyear);
$cc_transid = pv($rs_find_payments_q->cc_transid);
$cc_confirmation = pv($rs_find_payments_q->cc_confirmation);
$chk_dl = pv($rs_find_payments_q->chk_dl);
$chk_number = pv($rs_find_payments_q->chk_number);
$paymentstatus = pv($rs_find_payments_q->paymentstatus);
$paymenttype = pv($rs_find_payments_q->paymenttype);
$ccnumber2 = substr("$cc_number", -4);
$cc_cardtype = pv($rs_find_payments_q->cc_cardtype);
$custompaymentinfo = pv($rs_find_payments_q->custompaymentinfo);
$isdeposit = pv($rs_find_payments_q->isdeposit);
$depositid = pv($rs_find_payments_q->depositid);
$cashchange = pv($rs_find_payments_q->cashchange);

$insertpaymentssql = "INSERT INTO savedpayments (pfirstname,plastname,pcompany,paddress,paddress2,pcity,pstate,pzip,pphone,pemail,receipt_id,amount,paymentplugin,cc_number,cc_expmonth,cc_expyear,cc_transid,cc_confirmation,chk_dl,chk_number,paymentstatus,paymenttype,paymentdate,cc_cardtype,custompaymentinfo,storeid,cashchange,registerid,depositid) VALUES ('$pfirstname', '$plastname', '$pcompany', '$paddress', '$paddress2', '$pcity', '$pstate', '$pzip', '$pphone', '$pemail', '$receiptnumber', '$amount', '$paymentplugin', '$ccnumber2', '$cc_expmonth', '$cc_expyear', '$cc_transid', '$cc_confirmation', '$chk_dl', '$chk_number', '$paymentstatus', '$paymenttype','$currentdatetime','$cc_cardtype','$custompaymentinfo','$defaultuserstore','$cashchange','$registerid','$depositid')";
@mysqli_query($rs_connect, $insertpaymentssql);

if($isdeposit == 1) {
$setdepositflag = "UPDATE deposits SET dstatus = 'applied', applieddate = '$currentdatetime', appliedstoreid = '$defaultuserstore', aregisterid = '$registerid' WHERE depositid = '$depositid'";
@mysqli_query($rs_connect, $setdepositflag);
$setrecflag = "UPDATE deposits SET receipt_id = '$receiptnumber' WHERE depositid = '$depositid'";
@mysqli_query($rs_connect, $setrecflag);
}

}

$clearcpayments = "DELETE FROM currentpayments WHERE byuser = '$ipofpc'";
@mysqli_query($rs_connect, $clearcpayments);

$clearccustomer = "DELETE FROM currentcustomer WHERE byuser = '$ipofpc'";
@mysqli_query($rs_connect, $clearccustomer);

###




if ($invoice_id != "") {
$invoiceids = explode_list($invoice_id);
foreach($invoiceids as $key => $indinvid) {
$rs_setinv = "UPDATE invoices SET receipt_id = '$receiptnumber', invstatus = '2' WHERE invoice_id = '$indinvid'";
@mysqli_query($rs_connect, $rs_setinv);
}
}

$rs_purchases = "SELECT * FROM cart WHERE cart_type = 'purchase' AND ipofpc = '$ipofpc' ORDER BY addtime ASC";
$rs_find_purchases = @mysqli_query($rs_connect, $rs_purchases);
                                                                                                                             
while($rs_find_purchases_q = mysqli_fetch_object($rs_find_purchases)) {
$purchase_price = "$rs_find_purchases_q->cart_price";
$purchase_stockid = "$rs_find_purchases_q->cart_stock_id";
$purchase_labordesc = pv($rs_find_purchases_q->labor_desc);
$purchase_printdesc = pv($rs_find_purchases_q->printdesc);
$purchase_taxex = "$rs_find_purchases_q->taxex";
$purchase_itemtax = "$rs_find_purchases_q->itemtax";
$purchase_origprice = "$rs_find_purchases_q->origprice";
$purchase_discounttype = "$rs_find_purchases_q->discounttype";
$purchase_pricealt = "$rs_find_purchases_q->price_alt";
$purchase_itemserial = "$rs_find_purchases_q->itemserial";
$purchase_addtime = "$rs_find_purchases_q->addtime";
$purchase_unit_price = "$rs_find_purchases_q->unit_price";
$purchase_quantity = "$rs_find_purchases_q->quantity";
$purchase_discountname = "$rs_find_purchases_q->discountname";

if ($purchase_stockid != "0") {
$purchase_ourprice2 = getourprice($purchase_stockid);
$purchase_ourprice = $purchase_ourprice2 * $purchase_quantity;
} else {
$purchase_ourprice = "$rs_find_purchases_q->ourprice";
}



$rs_insert_purchase = "INSERT INTO sold_items (receipt,sold_price,stockid,labor_desc,sold_type,date_sold,taxex,itemtax,origprice,discounttype,price_alt,ourprice,itemserial,addtime,registerid,unit_price,quantity,printdesc,discountname,fop) VALUES  ('$receiptnumber','$purchase_price','$purchase_stockid','$purchase_labordesc','purchase','$currentdatetime','$purchase_taxex','$purchase_itemtax','$purchase_origprice','$purchase_discounttype','$purchase_pricealt','$purchase_ourprice','$purchase_itemserial','$purchase_addtime','$registerid','$purchase_unit_price','$purchase_quantity','$purchase_printdesc','$purchase_discountname','1')";
@mysqli_query($rs_connect, $rs_insert_purchase);

if ($purchase_stockid != "0") {
checkstorecount($purchase_stockid);
$rs_remove_stock = "UPDATE stockcounts SET quantity = quantity - $purchase_quantity WHERE stockid = '$purchase_stockid' AND storeid = '$defaultuserstore'";
@mysqli_query($rs_connect, $rs_remove_stock);
}

}

$rs_labor = "SELECT * FROM cart WHERE cart_type = 'labor' AND ipofpc = '$ipofpc' ORDER BY addtime ASC";
$rs_find_labor = @mysqli_query($rs_connect, $rs_labor);
                                                                                                                                               
while($rs_find_labor_q = mysqli_fetch_object($rs_find_labor)) {
$labor_price = "$rs_find_labor_q->cart_price";
$labor_desc = pv($rs_find_labor_q->labor_desc);
$printdesc = pv($rs_find_labor_q->printdesc);
$labor_taxex = "$rs_find_labor_q->taxex";
$labor_itemtax = "$rs_find_labor_q->itemtax";
$labor_origprice = "$rs_find_labor_q->origprice";
$labor_discounttype = "$rs_find_labor_q->discounttype";
$labor_pricealt = "$rs_find_labor_q->price_alt";
$labor_addtime = "$rs_find_labor_q->addtime";
$labor_unit_price = "$rs_find_labor_q->unit_price";
$labor_quantity = "$rs_find_labor_q->quantity";
$labor_discountname = "$rs_find_labor_q->discountname";

$rs_insert_labor = "INSERT INTO sold_items (receipt,sold_price,labor_desc,sold_type,date_sold,taxex,itemtax,origprice,discounttype,price_alt,addtime,registerid,unit_price,quantity,printdesc,discountname) VALUES  ('$receiptnumber','$labor_price','$labor_desc','labor','$currentdatetime','$labor_taxex','$labor_itemtax','$labor_origprice','$labor_discounttype','$labor_pricealt','$labor_addtime','$registerid','$labor_unit_price','$labor_quantity','$printdesc','$labor_discountname')";
@mysqli_query($rs_connect, $rs_insert_labor);
                                                                                                                                               
}

$rs_returns = "SELECT * FROM cart WHERE cart_type = 'refund' AND ipofpc = '$ipofpc' ORDER BY addtime ASC";
$rs_find_returns = @mysqli_query($rs_connect, $rs_returns);
                                                                                                                                               
while($rs_find_returns_q = mysqli_fetch_object($rs_find_returns)) {
$returns_price = "$rs_find_returns_q->cart_price";
$returns_stockid = "$rs_find_returns_q->cart_stock_id";
$return_sold_id = "$rs_find_returns_q->return_sold_id";
$return_labordesc = pv($rs_find_returns_q->labor_desc);
$return_printdesc = pv($rs_find_returns_q->printdesc);
$return_taxex = "$rs_find_returns_q->taxex";
$return_itemtax = "$rs_find_returns_q->itemtax";
$return_ourprice = "$rs_find_returns_q->ourprice";
$return_itemserial = "$rs_find_returns_q->itemserial";
$return_addtime = "$rs_find_returns_q->addtime";
$return_unit_price = "$rs_find_returns_q->unit_price";
$return_quantity = "$rs_find_returns_q->quantity";
                                                                                                                                     
$rs_insert_return = "INSERT INTO sold_items (receipt,sold_price,stockid,labor_desc,sold_type,return_sold_id,date_sold,taxex,itemtax,ourprice,itemserial,addtime,registerid,unit_price,quantity,printdesc) VALUES  ('$receiptnumber','$returns_price','$returns_stockid','$return_labordesc','refund','$return_sold_id','$currentdatetime','$return_taxex','$return_itemtax','$return_ourprice','$return_itemserial','$return_addtime','$registerid','$return_unit_price','$return_quantity','$return_printdesc')";
@mysqli_query($rs_connect, $rs_insert_return);

if ($returns_stockid != "0") {
checkstorecount($returns_stockid);

$rs_find_stock_qty = "SELECT stock.avg_cost, SUM(stockcounts.quantity) AS stock_quantity FROM stock, stockcounts WHERE stock.stock_id = stockcounts.stockid AND stockcounts.stockid = '$returns_stockid'";
$rs_result_stock_qty = mysqli_query($rs_connect, $rs_find_stock_qty);
$rs_result_stock_qtyq = mysqli_fetch_object($rs_result_stock_qty);
$rs_stock_quantity = "$rs_result_stock_qtyq->stock_quantity";
$avg_cost = "$rs_result_stock_qtyq->avg_cost";


if ($avg_cost == 0) {
$rs_qop = "SELECT inv_price FROM inventory WHERE stock_id = $returns_stockid ORDER BY inv_date DESC LIMIT 1";
$rs_result1 = mysqli_query($rs_connect, $rs_qop);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$lastinvprice = "$rs_result_q1->inv_price";
$rs_insert_avg_cost = "UPDATE stock SET avg_cost = '$lastinvprice' WHERE stock_id = '$returns_stockid'";
}

$rs_update_avg_cost = "UPDATE stock SET avg_cost = (avg_cost * $rs_stock_quantity + $return_ourprice) / ($rs_stock_quantity + $return_quantity) WHERE stock_id = '$returns_stockid'";
@mysqli_query($rs_connect, $rs_update_avg_cost);

$rs_replace_stock = "UPDATE stockcounts SET quantity = quantity + $return_quantity WHERE stockid = '$returns_stockid' AND storeid = '$defaultuserstore'";
@mysqli_query($rs_connect, $rs_replace_stock);

}               


$rs_qrr = "SELECT return_receipt FROM sold_items WHERE sold_id = '$return_sold_id'";
$rs_resultrr1 = mysqli_query($rs_connect, $rs_qrr);
$rs_result_qrr1 = mysqli_fetch_object($rs_resultrr1);
$current_rr = "$rs_result_qrr1->return_receipt";

$current_rr_exp = explode_list($current_rr);
                     
$current_rr_exp[] = "$receiptnumber";

$updated_rr = implode_list($current_rr_exp);

$rs_update_rr = "UPDATE sold_items SET return_receipt = '$updated_rr' WHERE sold_id = '$return_sold_id'";
@mysqli_query($rs_connect, $rs_update_rr);

                                                                                                                              
}

$rs_refundlabor = "SELECT * FROM cart WHERE cart_type = 'refundlabor' AND ipofpc = '$ipofpc' ORDER BY addtime ASC";
$rs_find_refundlabor = @mysqli_query($rs_connect, $rs_refundlabor);

while($rs_find_refundlabor_q = mysqli_fetch_object($rs_find_refundlabor)) {
$refundlabor_price = "$rs_find_refundlabor_q->cart_price";
$refundlabor_desc = pv($rs_find_refundlabor_q->labor_desc);
$refundlabor_printdesc = pv($rs_find_refundlabor_q->printdesc);
$refundlabor_taxex = "$rs_find_refundlabor_q->taxex";
$refundlabor_itemtax = "$rs_find_refundlabor_q->itemtax";
$refundlabor_origprice = "$rs_find_refundlabor_q->origprice";
$refundlabor_discounttype = "$rs_find_refundlabor_q->discounttype";
$refundlabor_pricealt = "$rs_find_refundlabor_q->price_alt";
$refundlabor_addtime = "$rs_find_refundlabor_q->addtime";
$refundlabor_return_sold_id = "$rs_find_refundlabor_q->return_sold_id";
$refundlabor_unit_price = "$rs_find_refundlabor_q->unit_price";
$refundlabor_quantity = "$rs_find_refundlabor_q->quantity";

$rs_insert_refundlabor = "INSERT INTO sold_items (receipt,sold_price,labor_desc,return_sold_id,sold_type,date_sold,taxex,itemtax,addtime,registerid,unit_price,quantity,printdesc) VALUES  ('$receiptnumber','$refundlabor_price','$refundlabor_desc','$refundlabor_return_sold_id','refundlabor','$currentdatetime','$refundlabor_taxex','$refundlabor_itemtax','$refundlabor_addtime','$registerid','$refundlabor_unit_price','$refundlabor_quantity','$refundlabor_printdesc')";
@mysqli_query($rs_connect, $rs_insert_refundlabor);

$rs_qrrlabor = "SELECT return_receipt FROM sold_items WHERE sold_id = '$refundlabor_return_sold_id'";
$rs_resultrrlabor1 = mysqli_query($rs_connect, $rs_qrrlabor);
$rs_result_qrrlabor1 = mysqli_fetch_object($rs_resultrrlabor1);
$current_rrlabor = "$rs_result_qrrlabor1->return_receipt";

$current_rrlabor_exp = explode_list($current_rrlabor);

$current_rrlabor_exp[] = "$receiptnumber";

$updatedlabor_rr = implode_list($current_rrlabor_exp);


$rs_replace_markref = "UPDATE sold_items SET return_receipt = '$updatedlabor_rr' WHERE sold_id = '$refundlabor_return_sold_id'";
@mysqli_query($rs_connect, $rs_replace_markref);

}


$empty_cart = "DELETE FROM cart WHERE ipofpc = '$ipofpc'";
@mysqli_query($rs_connect, $empty_cart);

$rs_reset_flag = "UPDATE sold_items SET return_flag = ''";
@mysqli_query($rs_connect, $rs_reset_flag);

header("Location: receipt.php?func=show_receipt_printable&receipt=$receiptnumber");
                                                                                                                                               
}



switch($func) {
                                                                                                                             
    default:
    nothing();
    break;
                                
    case "checkout":
    checkout();
    break;

}

?>
