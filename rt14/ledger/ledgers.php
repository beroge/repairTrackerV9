<?php
                                                                                                    
/***************************************************************************
 *   copyright            : (C) 2021 PCRepairTracker.com
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

                                                                                                    
function ledgers() {
require_once("header.php");
require("deps.php");


start_blue_box(pcrtlang("Ledgers"));

echo "<table class=standard>";
echo "<tr><th>".pcrtlang("Ledger Name").":</th>";
echo "<th>".pcrtlang("Account Number").":</th>";
echo "<th>".pcrtlang("Linked to Store").":</th>";
echo "<th>".pcrtlang("Ledger Type").":</th>";
echo "<th>".pcrtlang("Accounting Method").":</th>";
echo "<th></th></tr>";

$rs_find_linkedstores = "SELECT * FROM gl";
$rs_result_linkedstores = mysqli_query($rs_connect,$rs_find_linkedstores);
while($rs_result_linkedstoreq = mysqli_fetch_object($rs_result_linkedstores)) {
$ledgerid = "$rs_result_linkedstoreq->ledgerid";
$ledgername = "$rs_result_linkedstoreq->ledgername";
$ledgeran = "$rs_result_linkedstoreq->ledgeran";
$linkedstore = "$rs_result_linkedstoreq->linkedstore";
$method = "$rs_result_linkedstoreq->method";
$type = "$rs_result_linkedstoreq->type";


$linkedstorearray = explode_list($linkedstore);


echo "<tr><td>$ledgername</td><td>$ledgeran</td><td>";

if(!empty($linkedstorearray)) {

foreach($linkedstorearray as $key => $val) {
$rs_find_stores = "SELECT * FROM stores WHERE storeid = '$val'";
$rs_result_stores = mysqli_query($rs_connect,$rs_find_stores);
$rs_result_storeq = mysqli_fetch_object($rs_result_stores);
$linkedstoresname = "$rs_result_storeq->storesname";
echo "$linkedstoresname<br>";
}

}



echo "</td>";

if($type ==1 ) {
echo "<td>".pcrtlang("Simple")."</td>";
} else {
echo "<td>".pcrtlang("Double Entry")."</td>";
}


if($method ==1 ) {
echo "<td>".pcrtlang("Cash")."</td>";
} else {
echo "<td>".pcrtlang("Accrual")."</td>";
}
echo "<td><a href=\"ledgers.php?func=editledger&ledgerid=$ledgerid\" class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("Edit")."</a>";

#wip
$rs_count_trans = "SELECT * FROM glstrans WHERE ledgerid = '$ledgerid' AND receiptid = '0' AND invoiceid = '0'";
$rs_count_trans_result = mysqli_query($rs_connect,$rs_count_trans);
$totaltransactions = mysqli_num_rows($rs_count_trans_result);

if($totaltransactions < 50) {
echo "<a href=\"ledgers.php?func=deleteledger&ledgerid=$ledgerid\" class=\"linkbuttonmedium linkbuttongray radiusall\" onClick=\"return confirm('".pcrtlang("Are you sure you wish to permanently delete this LEDGER and all associated accounts and transactions!!!?")."');\"><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")."</a>";
}

echo "</td></tr>";

}

echo "</table>";

stop_blue_box();

echo "<br><br>";

start_blue_box(pcrtlang("Add New Ledger"));

echo "<form action=ledgers.php?func=newledger method=post>";
echo "<table class=standard>";
echo "<tr><td>".pcrtlang("Ledger Name").":</td><td><input size=35 class=textbox type=text name=ledgername required=required></td></tr>";
echo "<tr><td>".pcrtlang("Account Number").":</td><td><input size=35 class=textbox type=text name=ledgeran placeholder=\"".pcrtlang("Optional")."\"><input type=hidden name=type value=1></td></tr>";

#echo "<tr><td>".pcrtlang("Ledger Type").":</td><td><input type=radio value=1 name=type checked>".pcrtlang("Simple")."<input type=radio value=2 name=type>".pcrtlang("Double Entry")."";
#echo "<br><span class=boldme>".pcrtlang("Simple").":</span>".pcrtlang("Basic Expense and Income Tracking");
#echo "<br><span class=boldme>".pcrtlang("Double Entry").":</span>".pcrtlang("Tracking of Assets, Liabilities, Equity, Income and Expenses. Requires knowledge of accounting principles.");
#echo "</td></tr>";


echo "<tr><td>".pcrtlang("Accounting Method").":</td><td><input type=radio value=1 name=method checked>".pcrtlang("Cash")." 
<input type=radio value=2 name=method>".pcrtlang("Accrual")."";

echo "<br><span class=boldme>".pcrtlang("Cash").":</span>".pcrtlang("Income and Expense is recorded when received or paid.");
echo "<br><span class=boldme>".pcrtlang("Accrual").":</span>".pcrtlang("Income and Expense is recorded when invoiced or ordered. Unpaid invoices unlikely to be paid must be recorded as a bad debt expense.");

echo "</td></tr>";

echo "<tr><td>".pcrtlang("Linked to Store").":</td><td>";

$reservedstores = array();

echo "<div class=\"checkbox\">";

$rs_find_stores = "SELECT * FROM stores WHERE storeenabled = '1' ORDER BY storesname ASC";
$rs_result_stores = mysqli_query($rs_connect,$rs_find_stores);
while($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
$rs_storesname = "$rs_result_storeq->storesname";
$rs_storeid = "$rs_result_storeq->storeid";
if(!in_array("$rs_storeid", $reservedstores)) {
echo "<input type=checkbox id=\"$rs_storeid\" value=\"$rs_storeid\" name=\"storeid[]\"><label for=\"$rs_storeid\" style=\"padding:3px;\"><i class=\"fa fa-store\"></i> ".pcrtlang("$rs_storesname")."</input></label><br>";
}
}

echo "</div>";

echo "</td></tr>";


echo "<tr><td colspan=2><button class=button type=submit id=submitbutton><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Add New Ledger")."</button>";
echo "</form>";
echo "</td></tr>";


echo "</table>";

stop_blue_box();

require_once("footer.php");
                                                                                                    
}




function newledger() {
require_once("validate.php");
require("deps.php");
require("common.php");       

$ledgername = pv($_REQUEST['ledgername']);
$storeid2 = $_REQUEST['storeid'];
$ledgeran = pv($_REQUEST['ledgeran']);
$method = pv($_REQUEST['method']);
$type = pv($_REQUEST['type']);

$storeid = implode_list($storeid2);

$rs_insert_ledger = "INSERT INTO gl (ledgername,ledgeran,linkedstore,method,type) VALUES ('$ledgername','$ledgeran','$storeid','$method','$type')";
@mysqli_query($rs_connect, $rs_insert_ledger);
                               
header("Location: ledgers.php");

}



function editledger() {
require_once("header.php");
require("deps.php");

$ledgerid = pv($_REQUEST['ledgerid']);

$rs_find_linkedstores = "SELECT * FROM gl WHERE ledgerid = '$ledgerid'";
$rs_result_linkedstores = mysqli_query($rs_connect,$rs_find_linkedstores);
$rs_result_linkedstoreq = mysqli_fetch_object($rs_result_linkedstores);
$ledgername = "$rs_result_linkedstoreq->ledgername";
$ledgeran = "$rs_result_linkedstoreq->ledgeran";


start_blue_box(pcrtlang("Edit Ledger"));

echo "<form action=ledgers.php?func=editledger2 method=post><input type=hidden name=ledgerid value=\"$ledgerid\">";
echo "<table class=standard>";
echo "<tr><td>".pcrtlang("Ledger Name").":</td><td><input size=35 class=textbox type=text name=ledgername required=required value=\"$ledgername\"></td></tr>";
echo "<tr><td>".pcrtlang("Account Number").":</td><td><input size=35 class=textbox type=text name=ledgeran value=\"$ledgeran\" placeholder=\"".pcrtlang("Optional")."\"></td></tr>";
echo "<tr><td colspan=2><button class=button type=submit id=submitbutton><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button>";
echo "</form>";
echo "</td></tr>";
echo "</table>";

stop_blue_box();

require_once("footer.php");

}



function editledger2() {
require_once("validate.php");
require("deps.php");
require("common.php");

$ledgername = pv($_REQUEST['ledgername']);
$ledgerid = pv($_REQUEST['ledgerid']);
$ledgeran = pv($_REQUEST['ledgeran']);


$rs_update_ledger = "UPDATE gl SET ledgername = '$ledgername', ledgeran = '$ledgeran' WHERE ledgerid = '$ledgerid'";
@mysqli_query($rs_connect, $rs_update_ledger);

header("Location: ledgers.php");

}

function changeledger() {
require_once("validate.php");
require("deps.php");
require("common.php");

$ledgerid = pv($_REQUEST['ledger']);

$rs_update_ledger = "UPDATE users SET ledgerid = '$ledgerid' WHERE username = '$ipofpc'";
@mysqli_query($rs_connect, $rs_update_ledger);

header("Location: index.php");

}


function deleteledger() {
require_once("validate.php");
require("deps.php");
require("common.php");

$ledgerid = pv($_REQUEST['ledgerid']);

$dtransdet = "SELECT * FROM glstrans WHERE ledgerid = '$ledgerid'";
$rs_result_dtransdet = mysqli_query($rs_connect,$dtransdet);
while($rs_result_dtransdetq = mysqli_fetch_object($rs_result_dtransdet)) {
$transid = "$rs_result_dtransdetq->transid";
$rs_delete_transdet = "DELETE FROM glstransdet WHERE transid = '$transid'";
@mysqli_query($rs_connect, $rs_delete_transdet);
}

$rs_delete_ledger = "DELETE FROM gl WHERE ledgerid = '$ledgerid'";
@mysqli_query($rs_connect, $rs_delete_ledger);

$rs_delete_trans = "DELETE FROM glstrans WHERE ledgerid = '$ledgerid'";
@mysqli_query($rs_connect, $rs_delete_trans);

$rs_delete_accounts = "DELETE FROM glsaccounts WHERE ledgerid = '$ledgerid'";
@mysqli_query($rs_connect, $rs_delete_accounts);

header("Location: ledgers.php");

}




switch($func) {
                                                                                                    
    default:
    ledgers();
    break;
                                
    case "newledger":
    newledger();
    break;

  case "editledger":
    editledger();
    break;

  case "editledger2":
    editledger2();
    break;

  case "deleteledger":
    deleteledger();
    break;

  case "browsesuppliers":
    browsesuppliers();
    break;

  case "changeledger":
    changeledger();
    break;


}

?>

