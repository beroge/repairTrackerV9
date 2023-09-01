<?php
                                                                                                    
/***************************************************************************
 *   copyright            : (C) 2017 PCRepairTracker.com
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

echo "Nothing to see here";

}



##########

function checkout() {
require_once("validate.php");

$invoiceid = $_REQUEST['invoiceid'];
$ccnumber = $_REQUEST['ccnumber'];
$transid = $_REQUEST['transid'];
$cardtype = $_REQUEST['cardtype'];
$cardnamefirst = $_REQUEST['cardnamefirst'];
$cardnamelast = $_REQUEST['cardnamelast'];
$ccmonth = $_REQUEST['ccmonth'];
$ccyear = $_REQUEST['ccyear'];
$amounttopay = $_REQUEST['amounttopay'];
$invtotal = $_REQUEST['invtotal'];
$invtax = $_REQUEST['invtax'];

include("deps.php");
include("common.php");


$rs_find_name = "SELECT * FROM invoices WHERE invoice_id = '$invoiceid'";
$rs_result_name = mysqli_query($rs_connect, $rs_find_name);

$rs_result_name_q = mysqli_fetch_object($rs_result_name);
$invname = pv("$rs_result_name_q->invname");
$invcompany = pv("$rs_result_name_q->invcompany");
$invaddy1 = pv("$rs_result_name_q->invaddy1");
$invaddy2 = pv("$rs_result_name_q->invaddy2");
$invcity = pv("$rs_result_name_q->invcity");
$invstate = pv("$rs_result_name_q->invstate");
$invzip = pv("$rs_result_name_q->invzip");
$invphone = pv("$rs_result_name_q->invphone");
$woid = "$rs_result_name_q->woid";
$invemail = "$rs_result_name_q->invemail";
$byuser = "$rs_result_name_q->byuser";
$storeid = "$rs_result_name_q->storeid";

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

$rs_insert_receipt = "INSERT INTO receipts (pay_type,grandtotal,date_sold,grandtax,paywith,person_name,company,byuser,address1,address2,phone_number,city,state,zip,email,woid,invoice_id,storeid) VALUES ('purchase','$invtotal','$currentdatetime','$invtax','split','$invname','$invcompany','$byuser','$invaddy1','$invaddy2','$invphone','$invcity','$invstate','$invzip','$invemail','$woid','$invoiceid','$storeid')";
@mysqli_query($rs_connect, $rs_insert_receipt);
$receiptnumber = mysqli_insert_id($rs_connect);

####

if($woid != "") {
$woidschecked = explode_list($woid);
foreach($woidschecked as $key => $indwoid) {
$rs_checkout11 = "UPDATE pc_wo SET pcstatus = '5', cobyuser = '$byuser' WHERE woid = '$indwoid'";
@mysqli_query($rs_connect, $rs_checkout11);
$rs_checkout22 = "UPDATE pc_wo SET pickupdate = '$currentdatetime' WHERE woid = '$indwoid' AND pickupdate = '0000-00-00 00:00:00'";
@mysqli_query($rs_connect, $rs_checkout22);
$setstatus = "UPDATE specialorders SET spoopenclosed = '1' WHERE spowoid = '$indwoid'";
@mysqli_query($rs_connect, $setstatus);
}
}

####
$insertpaymentssql = "INSERT INTO savedpayments (pfirstname,plastname,pcompany,paddress,paddress2,pcity,pstate,pzip,pphone,pemail,receipt_id,amount,paymentplugin,cc_number,cc_expmonth,cc_expyear,cc_transid,paymentstatus,paymenttype,paymentdate,cc_cardtype,storeid) VALUES ('$cardnamefirst', '$cardnamelast', '$invcompany', '$invaddy1', '$invaddy2', '$invcity', '$invstate', '$invzip', '$invphone', '$invemail', '$receiptnumber', '$amounttopay', '$paymentplugin', '$ccnumber', '$ccmonth', '$ccyear', '$transid', 'ready', 'credit','$currentdatetime','$cardtype','$storeid')";
@mysqli_query($rs_connect, $insertpaymentssql);

$rs_finddeposits_sql = "SELECT * FROM deposits WHERE invoiceid = '$invoiceid'";
$rs_find_deposits = @mysqli_query($rs_connect, $rs_finddeposits_sql);
while($rs_find_payments_q = mysqli_fetch_object($rs_find_deposits)) {
$depositid = pv($rs_find_payments_q->depositid);
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
$cc_cid = pv($rs_find_payments_q->cc_cid);
$cc_track1 = pv($rs_find_payments_q->cc_track1);
$cc_track2 = pv($rs_find_payments_q->cc_track2);
$chk_dl = pv($rs_find_payments_q->chk_dl);
$chk_number = pv($rs_find_payments_q->chk_number);
$paymentstatus = pv($rs_find_payments_q->paymentstatus);
$paymenttype = pv($rs_find_payments_q->paymenttype);
$ccnumber2 = substr("$cc_number", -4);
$cc_cardtype = pv($rs_find_payments_q->cc_cardtype);
$dstatus = pv($rs_find_payments_q->dstatus);
$depdate = pv($rs_find_payments_q->depdate);
$storeid = pv($rs_find_payments_q->storeid);
$pcompany = pv($rs_find_payments_q->pcompany);
$parentdeposit = pv($rs_find_payments_q->parentdeposit);
$registerid = pv($rs_find_payments_q->registerid);
$aregisterid = pv($rs_find_payments_q->aregisterid);
$custompaymentinfo = pv($rs_find_payments_q->custompaymentinfo);
$cashchange = pv($rs_find_payments_q->cashchange);
$cashchange2 = pv($rs_find_payments_q->cashchange2);

$insertpaymentssql2 = "INSERT INTO savedpayments (pfirstname,plastname,pcompany,paddress,paddress2,pcity,pstate,pzip,pphone,pemail,receipt_id,amount,paymentplugin,cc_number,cc_expmonth,cc_expyear,cc_transid,cc_confirmation,chk_dl,chk_number,paymentstatus,paymenttype,cc_cardtype,custompaymentinfo,depositid,cashchange,storeid,paymentdate)
VALUES ('$pfirstname', '$plastname', '$pcompany', '$paddress', '$paddress2', '$pcity', '$pstate', '$pzip', '$pphone', '$pemail', '$receiptnumber','$amount','$paymentplugin','$ccnumber2', '$cc_expmonth', '$cc_expyear', '$cc_transid', '$cc_confirmation', '$chk_dl', '$chk_number','$paymentstatus', '$paymenttype','$cc_cardtype','$custompaymentinfo','$depositid','$cashchange','$storeid','$currentdatetime')";
@mysqli_query($rs_connect, $insertpaymentssql2);

$setdepositflag = "UPDATE deposits SET dstatus = 'applied', applieddate = '$currentdatetime', appliedstoreid = '$storeid' WHERE depositid = '$depositid'";
@mysqli_query($rs_connect, $setdepositflag);
$setrecflag = "UPDATE deposits SET receipt_id = '$receiptnumber' WHERE depositid = '$depositid'";
@mysqli_query($rs_connect, $setrecflag);
}


####
$rs_setinv = "UPDATE invoices SET receipt_id = '$receiptnumber', invstatus = '2' WHERE invoice_id = '$invoiceid'";
@mysqli_query($rs_connect, $rs_setinv);

####

$rs_purchases = "SELECT * FROM invoice_items WHERE cart_type = 'purchase' AND invoice_id = '$invoiceid' ORDER BY addtime ASC";
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
$purchase_quantity = "$rs_find_purchases_q->quantity";
$purchase_unit_price = "$rs_find_purchases_q->unit_price";

if ($purchase_stockid != "0") {
$purchase_ourprice = getourprice($purchase_stockid);
} else {
$purchase_ourprice = "$rs_find_purchases_q->ourprice";
}



$rs_insert_purchase = "INSERT INTO sold_items (receipt,sold_price,stockid,labor_desc,sold_type,date_sold,taxex,itemtax,origprice,discounttype,price_alt,ourprice,itemserial,addtime,quantity,unit_price,printdesc) VALUES  ('$receiptnumber','$purchase_price','$purchase_stockid','$purchase_labordesc','purchase','$currentdatetime','$purchase_taxex','$purchase_itemtax','$purchase_origprice','$purchase_discounttype','$purchase_pricealt','$purchase_ourprice','$purchase_itemserial','$purchase_addtime','$purchase_quantity','$purchase_unit_price','$purchase_printdesc')";
@mysqli_query($rs_connect, $rs_insert_purchase);

if ($purchase_stockid != "0") {
checkstorecount($purchase_stockid);
$rs_remove_stock = "UPDATE stockcounts SET quantity = quantity-1 WHERE stockid = '$purchase_stockid' AND storeid = '$storeid'";
@mysqli_query($rs_connect, $rs_remove_stock);
}

}

$rs_labor = "SELECT * FROM invoice_items WHERE cart_type = 'labor' AND invoice_id = '$invoiceid' ORDER BY addtime ASC";
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
$labor_quantity = "$rs_find_purchases_q->quantity";
$labor_unit_price = "$rs_find_purchases_q->unit_price";

$rs_insert_labor = "INSERT INTO sold_items (receipt,sold_price,labor_desc,sold_type,date_sold,taxex,itemtax,origprice,discounttype,price_alt,addtime,quantity,unit_price,printdesc) VALUES  ('$receiptnumber','$labor_price','$labor_desc','labor','$currentdatetime','$labor_taxex','$labor_itemtax','$labor_origprice','$labor_discounttype','$labor_pricealt','$labor_addtime','$labor_quantity','$labor_unit_price','$printdesc')";
@mysqli_query($rs_connect, $rs_insert_labor);
                                                                                                                                               
}

####

header("Location: index.php?paidinvoice=$invoiceid&receiptnumber=$receiptnumber");

}


switch($func) {
                                                                                                    
    default:
    nothing();
    break;
                                
    case "checkout":
    checkout();
    break;

}

