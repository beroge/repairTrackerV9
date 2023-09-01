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

                                                                                                    
function nothing() {
require_once("header.php");
require_once("footer.php");

}



function checkout() {
require_once("validate.php");
require("deps.php");
require("common.php");

$invoice_id = $_REQUEST['invoice_id'];
$custname = urlencode($_REQUEST['custname']);
$custcompany = urlencode($_REQUEST['custcompany']);
$custaddy1 = urlencode($_REQUEST['custaddy1']);
$custaddy2 = urlencode($_REQUEST['custaddy2']);
$custcity = urlencode($_REQUEST['custcity']);
$custstate = urlencode($_REQUEST['custstate']);
$custzip = urlencode($_REQUEST['custzip']);
$custphone =  urlencode($_REQUEST['custphone']);
$custemail =  urlencode($_REQUEST['custemail']);





if(!array_key_exists('prepaid',$_REQUEST)) {

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');


$rs_check = "UPDATE pc_wo SET pcstatus = '5', pickupdate = '$currentdatetime', cobyuser = '$ipofpc' WHERE woid = '$woid'";
#@mysqli_query($rs_connect, $rs_check);

}

$rs_findsinv = "SELECT * FROM invoices WHERE invoice_id = '$invoice_id'";
$rs_findsinv2 = @mysqli_query($rs_connect, $rs_findsinv);
$rs_find_invoices_q = mysqli_fetch_object($rs_findsinv2);
$woid = "$rs_find_invoices_q->woid";


header("Location: ../storemobile/invoice.php?func=checkoutinv&invoice_id=$invoice_id&custname=$custname&company=$custcompany&custaddy1=$custaddy1&custaddy2=$custaddy2&custcity=$custcity&custstate=$custstate&custzip=$custzip&custphone=$custphone&custemail=$custemail&woid=$woid");

}


##########

function createinvoice() {


require_once("common.php");
require("dheader.php");


$woid = $_REQUEST['woid'];

$invname = $_REQUEST['pcname'];
$invcompany = $_REQUEST['pccompany'];
$invaddy1 = urldecode($_REQUEST['pcaddress']);
$invaddy2 = urldecode($_REQUEST['pcaddress2']);
$invcity = urldecode($_REQUEST['pccity']);
$invstate = urldecode($_REQUEST['pcstate']);
$invzip = urldecode($_REQUEST['pczip']);
$invphone = $_REQUEST['pcphone'];
$invemail = $_REQUEST['pcemail'];
$preinvoice = $_REQUEST['preinvoice'];


dheader(pcrtlang("New Invoice"));

echo "<form action=repinvoice.php?func=createinvoice2 method=post data-ajax=\"false\"><input type=hidden name=woid value=$woid><input type=hidden name=preinvoice value=\"$preinvoice\">";
echo pcrtlang("Customer Name").":<input type=text name=invname value=\"$invname\">";
echo pcrtlang("Company").":<input type=text name=invcompany value=\"$invcompany\">";
echo "$pcrt_address1:<input type=text name=invaddy1 value=\"$invaddy1\">";
echo "$pcrt_address2:<input type=text name=invaddy2 value=\"$invaddy2\">";
echo "$pcrt_city:<input type=text name=invcity value=\"$invcity\">";
echo "$pcrt_state:<input type=text name=invstate value=\"$invstate\">";
echo "$pcrt_zip:<input type=text name=invzip value=\"$invzip\">";
echo pcrtlang("Customer Phone").":<input type=text name=invphone value=\"$invphone\">";
echo pcrtlang("Customer Email").":<input type=text name=invemail value=\"$invemail\">";


echo pcrtlang("Invoice or Quote?").":<select name=iorq>";
echo "<option selected value=invoice>".pcrtlang("Invoice")."</option><option value=quote>".pcrtlang("Quote")."</option>";
echo "</select>";


echo pcrtlang("Invoice Terms?").":<select name=invoicetermsid>";

$rs_sl = "SELECT * FROM invoiceterms ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_sl);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$invoicetermsid = "$rs_result_q1->invoicetermsid";
$invoicetermstitle = "$rs_result_q1->invoicetermstitle";
$invoicetermsdays = "$rs_result_q1->invoicetermsdays";
$invoicetermslatefee = "$rs_result_q1->invoicetermslatefee";
$invoicetermsdefault = "$rs_result_q1->invoicetermsdefault";

if ($invoicetermsdefault == "1") {
echo "<option selected value=$invoicetermsid>$invoicetermstitle ($invoicetermslatefee% ".pcrtlang("Late Fee").")</option>";
} else {
echo "<option value=$invoicetermsid>$invoicetermstitle ($invoicetermslatefee% ".pcrtlang("Late Fee").")</option>";
}

}

echo "</select>";

echo pcrtlang("Notes").":<textarea name=invnotes></textarea>";

echo "<input type=submit value=\"".pcrtlang("Create Invoice")."\" data-theme=\"b\"></form>";


dfooter();

require_once("dfooter.php");


}


function createinvoice2() {
require_once("validate.php");
require("deps.php");
require("common.php");

$invname = pv($_REQUEST['invname']);
$invcompany = pv($_REQUEST['invcompany']);
$invaddy1 = pv($_REQUEST['invaddy1']);
$invaddy2 = pv($_REQUEST['invaddy2']);
$invcity = pv($_REQUEST['invcity']);
$invstate = pv($_REQUEST['invstate']);
$invzip = pv($_REQUEST['invzip']);
$invphone = pv($_REQUEST['invphone']);
$invemail = pv($_REQUEST['invemail']);
$invnotes = pv($_REQUEST['invnotes']);
$woid = $_REQUEST['woid'];
$preinvoice = $_REQUEST['preinvoice'];
$iorq = $_REQUEST['iorq'];
$invoicetermsid = $_REQUEST['invoicetermsid'];

if ($invname == "") {
die(pcrtlang("You must enter a name on the invoice."));
}

if ($iorq == "invoice") {
userlog(8,$woid,'woid','');
} else {
userlog(20,$woid,'woid','');
}

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');



$rs_sl = "SELECT * FROM invoiceterms WHERE invoicetermsid = '$invoicetermsid'";
$rs_result1 = mysqli_query($rs_connect, $rs_sl);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$invoicetermsdays = "$rs_result_q1->invoicetermsdays";

$duedate = date('Y-m-d H:i:s', (time() + ($invoicetermsdays * 86400)));


$rs_insert_cart = "INSERT INTO invoices (invname,invcompany,invaddy1,invaddy2,invphone,invemail,invdate,woid,invcity,invstate,invzip,byuser,preinvoice,invnotes,storeid,iorq,invoicetermsid,duedate) VALUES  ('$invname','$invcompany','$invaddy1','$invaddy2','$invphone','$invemail','$currentdatetime','$woid','$invcity','$invstate','$invzip','$ipofpc','$preinvoice','$invnotes','$defaultuserstore','$iorq','$invoicetermsid','$duedate')";
@mysqli_query($rs_connect, $rs_insert_cart);

$invoiceid = mysqli_insert_id($rs_connect);

$rs_purchases = "SELECT * FROM repaircart WHERE pcwo = '$woid'";
$rs_find_purchases = @mysqli_query($rs_connect, $rs_purchases);

while($rs_find_purchases_q = mysqli_fetch_object($rs_find_purchases)) {
$purchase_price = "$rs_find_purchases_q->cart_price";
$purchase_stockid = "$rs_find_purchases_q->cart_stock_id";
$purchase_labordesc = pv($rs_find_purchases_q->labor_desc);
$purchase_printdesc = pv($rs_find_purchases_q->printdesc);
$purchase_taxex = "$rs_find_purchases_q->taxex";
$purchase_itemtax = "$rs_find_purchases_q->itemtax";
$purchase_returnsoldid = "$rs_find_purchases_q->return_sold_id";
$purchase_restockingfee = "$rs_find_purchases_q->restocking_fee";
$purchase_pricealt = "$rs_find_purchases_q->price_alt";
$purchase_carttype = "$rs_find_purchases_q->cart_type";
$purchase_origprice = "$rs_find_purchases_q->origprice";
$purchase_discounttype = "$rs_find_purchases_q->discounttype";
$purchase_ourprice = "$rs_find_purchases_q->ourprice";
$purchase_itemserial = "$rs_find_purchases_q->itemserial";
$purchase_addtime = "$rs_find_purchases_q->addtime";
$purchase_unit_price = "$rs_find_purchases_q->unit_price";
$purchase_quantity = "$rs_find_purchases_q->quantity";
$purchase_discountname = "$rs_find_purchases_q->discountname";

$rs_insert_invitems = "INSERT INTO invoice_items (cart_price,cart_type,cart_stock_id,labor_desc,return_sold_id,restocking_fee,price_alt,invoice_id,taxex,itemtax,origprice,discounttype,ourprice,itemserial,addtime,unit_price,quantity,printdesc,discountname) VALUES ('$purchase_price','$purchase_carttype','$purchase_stockid','$purchase_labordesc','$purchase_returnsoldid','$purchase_restockingfee','$purchase_pricealt','$invoiceid','$purchase_taxex','$purchase_itemtax','$purchase_origprice','$purchase_discounttype','$purchase_ourprice','$purchase_itemserial','$purchase_addtime','$purchase_unit_price','$purchase_quantity','$purchase_printdesc','$purchase_discountname')";
@mysqli_query($rs_connect, $rs_insert_invitems);


}
header("Location: index.php?&pcwo=$woid#invoicing");

}



function addtoexistinginvoice() {
require_once("validate.php");
require("deps.php");
require("common.php");

$woid = pv($_REQUEST['woid']);
$invoice_id = pv($_REQUEST['invoice_id']);

$rs_purchases = "SELECT * FROM repaircart WHERE pcwo = '$woid'";
$rs_find_purchases = @mysqli_query($rs_connect, $rs_purchases);

while($rs_find_purchases_q = mysqli_fetch_object($rs_find_purchases)) {
$purchase_price = "$rs_find_purchases_q->cart_price";
$purchase_stockid = "$rs_find_purchases_q->cart_stock_id";
$purchase_labordesc = pv($rs_find_purchases_q->labor_desc);
$purchase_printdesc = pv($rs_find_purchases_q->printdesc);
$purchase_taxex = "$rs_find_purchases_q->taxex";
$purchase_itemtax = "$rs_find_purchases_q->itemtax";
$purchase_returnsoldid = "$rs_find_purchases_q->return_sold_id";
$purchase_restockingfee = "$rs_find_purchases_q->restocking_fee";
$purchase_pricealt = "$rs_find_purchases_q->price_alt";
$purchase_carttype = "$rs_find_purchases_q->cart_type";
$purchase_origprice = "$rs_find_purchases_q->origprice";
$purchase_discounttype = "$rs_find_purchases_q->discounttype";
$purchase_ourprice = "$rs_find_purchases_q->ourprice";
$purchase_itemserial = "$rs_find_purchases_q->itemserial";
$purchase_addtime = "$rs_find_purchases_q->addtime";
$purchase_unit_price = "$rs_find_purchases_q->unit_price";
$purchase_quantity = "$rs_find_purchases_q->quantity";
$purchase_discountname = "$rs_find_purchases_q->discountname";

$rs_insert_invitems = "INSERT INTO invoice_items (cart_price,cart_type,cart_stock_id,labor_desc,return_sold_id,restocking_fee,price_alt,invoice_id,taxex,itemtax,origprice,discounttype,ourprice,itemserial,addtime,unit_price,quantity,printdesc,discountname) VALUES ('$purchase_price','$purchase_carttype','$purchase_stockid','$purchase_labordesc','$purchase_returnsoldid','$purchase_restockingfee','$purchase_pricealt','$invoice_id','$purchase_taxex','$purchase_itemtax','$purchase_origprice','$purchase_discounttype','$purchase_ourprice','$purchase_itemserial','$purchase_addtime','$purchase_unit_price','$purchase_quantity','$purchase_printdesc','$purchase_discountname')";
@mysqli_query($rs_connect, $rs_insert_invitems);

}

$rs_findotherinv = "SELECT * FROM invoices WHERE invoice_id = '$invoice_id'";
$rs_findotherinv_2 = @mysqli_query($rs_connect, $rs_findotherinv);
$rs_find_otherinv_q = mysqli_fetch_object($rs_findotherinv_2);
$woidvalue = "$rs_find_otherinv_q->woid";

$woidvaluearray = explode_list($woidvalue);
$woidvaluearray[] = $woid;
$newwoidvalue = implode_list($woidvaluearray);

$updatewoidfield = "UPDATE invoices SET woid = '$newwoidvalue' WHERE invoice_id = '$invoice_id'";
@mysqli_query($rs_connect, $updatewoidfield);


header("Location: index.php?&pcwo=$woid");

}





##########






switch($func) {
                                                                                                    
    default:
    nothing();
    break;
                                
    case "createinvoice":
    createinvoice();
    break;

  case "createinvoice2":
    createinvoice2();
    break;

 case "checkout":
    checkout();
    break;

 case "addtoexistinginvoice":
    addtoexistinginvoice();
    break;


}

?>
