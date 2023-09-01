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

                                                                                                    
function accounts() {
require_once("header.php");
require("deps.php");


start_blue_box(pcrtlang("Accounts"));

echo "<h4>".pcrtlang("Income Accounts/Categories")."</h4>";

echo "<table class=standard>";
echo "<tr><th>".pcrtlang("Account Name")."</th>";
echo "<th></th></tr>";

$rs_find_income = "SELECT * FROM glsaccounts WHERE accounttype = 'income' AND ledgerid = '$userledgerid' ORDER BY accountname ASC";
$rs_result_income = mysqli_query($rs_connect,$rs_find_income);
while($rs_result_incomeq = mysqli_fetch_object($rs_result_income)) {
$accountid = "$rs_result_incomeq->accountid";
$accountname = "$rs_result_incomeq->accountname";
echo "<tr><td>$accountname</td>";
echo "<td><a href=\"saccounts.php?func=editaccount&accountid=$accountid&accountname=".urlencode("$accountname")."\" class=\"linkbuttonmedium linkbuttongray radiusall\">
<i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("Edit")."</a>";

$rs_find_incomeu = "SELECT * FROM glstransdet WHERE accountid = '$accountid'";
$rs_result_incomeu = mysqli_query($rs_connect,$rs_find_incomeu);
$incomeused = mysqli_num_rows($rs_result_incomeu);
if($incomeused == 0) {
echo " <a href=\"saccounts.php?func=deleteaccount&accountid=$accountid\" class=\"linkbuttonmedium linkbuttongray radiusall\">
<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")."</a>";
}
echo "</td></tr>";

}

echo "</table>";

echo "<h4>".pcrtlang("Expense Accounts/Categories")."</h4>";

echo "<table class=standard>";
echo "<tr><th>".pcrtlang("Account Name")."</th>";
echo "<th></th></tr>";

$rs_find_expense = "SELECT * FROM glsaccounts WHERE accounttype = 'expense' AND ledgerid = '$userledgerid' ORDER BY accountname ASC";
$rs_result_expense = mysqli_query($rs_connect,$rs_find_expense);
while($rs_result_expenseq = mysqli_fetch_object($rs_result_expense)) {
$accountid = "$rs_result_expenseq->accountid";
$accountname = "$rs_result_expenseq->accountname";
echo "<tr><td>$accountname</td>";
echo "<td><a href=\"saccounts.php?func=editaccount&accountid=$accountid&accountname=".urlencode("$accountname")."\" class=\"linkbuttonmedium linkbuttongray radiusall\">
<i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("Edit")."</a>";

$rs_find_expenseu = "SELECT * FROM glstransdet WHERE accountid = '$accountid'";
$rs_result_expenseu = mysqli_query($rs_connect,$rs_find_expenseu);
$expenseused = mysqli_num_rows($rs_result_expenseu);
if($expenseused == 0) {
echo " <a href=\"saccounts.php?func=deleteaccount&accountid=$accountid\" class=\"linkbuttonmedium linkbuttongray radiusall\">
<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")."</a>";
}
echo "</td></tr>";
}

echo "</table>";

echo "<h4>".pcrtlang("Liability Accounts")."</h4>";

echo "<table class=standard>";
echo "<tr><th>".pcrtlang("Account Name")."</th>";
echo "<th></th></tr>";

$rs_find_liability = "SELECT * FROM glsaccounts WHERE accounttype = 'liability' AND ledgerid = '$userledgerid' ORDER BY accountname ASC";
$rs_result_liability = mysqli_query($rs_connect,$rs_find_liability);
while($rs_result_liabilityq = mysqli_fetch_object($rs_result_liability)) {
$accountid = "$rs_result_liabilityq->accountid";
$accountname = "$rs_result_liabilityq->accountname";
echo "<tr><td>$accountname</td>";
echo "<td><a href=\"saccounts.php?func=editaccount&accountid=$accountid&accountname=".urlencode("$accountname")."\" class=\"linkbuttonmedium linkbuttongray radiusall\">
<i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("Edit")."</a>";

$rs_find_liabilityu = "SELECT * FROM glstransdet WHERE accountid = '$accountid'";
$rs_result_liabilityu = mysqli_query($rs_connect,$rs_find_liabilityu);
$liabilityused = mysqli_num_rows($rs_result_liabilityu);
if($liabilityused == 0) {
echo " <a href=\"saccounts.php?func=deleteaccount&accountid=$accountid\" class=\"linkbuttonmedium linkbuttongray radiusall\">
<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")."</a>";
}
echo "</td></tr>";
}

echo "</table>";

echo "<br><a href=saccounts.php?func=importsalestaxrates class=\"linkbuttonmedium radiusall linkbuttongray\">".pcrtlang("Import Sales Tax Rates")."</a>";

echo " <i class=\"fa fa-info-circle\"></i> ".pcrtlang("Note: Sales Tax rates are automatically created when importing sales.")."";

stop_blue_box();

echo "<br><br>";

start_blue_box(pcrtlang("Add New Account"));

echo "<form action=saccounts.php?func=newaccount method=post>";
echo "<table class=standard>";
echo "<tr><td>".pcrtlang("Account Name").":</td><td><input size=35 class=textbox type=text name=accountname required=required></td></tr>";
echo "<tr><td>".pcrtlang("Account Type").":</td><td><select name=accounttype><option value=income>".pcrtlang("Income")."</option><option value=expense>".pcrtlang("Expense")."</option><option value=liability>".pcrtlang("Liability")."</option></td></tr>";

echo "<tr><td colspan=2><button class=button type=submit id=submitbutton><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Add New Account")."</button>";
echo "</form>";
echo "</td></tr>";


echo "</table>";

stop_blue_box();

require_once("footer.php");
                                                                                                    
}




function newaccount() {
require_once("validate.php");
require("deps.php");
require("common.php");       

$accountname = pv($_REQUEST['accountname']);
$accounttype = pv($_REQUEST['accounttype']);


$rs_insert_account = "INSERT INTO glsaccounts (accountname, accounttype, ledgerid) 
VALUES ('$accountname','$accounttype','$userledgerid')";

@mysqli_query($rs_connect, $rs_insert_account);
                               
header("Location: saccounts.php");

}


function deleteaccount() {
require_once("validate.php");
require("deps.php");
require("common.php");

$accountid = pv($_REQUEST['accountid']);

$rs_delete_account = "DELETE FROM glsaccounts WHERE accountid = '$accountid'";
@mysqli_query($rs_connect, $rs_delete_account);

header("Location: saccounts.php");

}



function editaccount() {
require_once("header.php");
require("deps.php");

$accountid = pv($_REQUEST['accountid']);
$accountname = pv($_REQUEST['accountname']);

start_blue_box(pcrtlang("Account Ledger"));

echo "<form action=saccounts.php?func=editaccount2 method=post><input type=hidden name=accountid value=\"$accountid\">";
echo "<table class=standard>";
echo "<tr><td>".pcrtlang("Account Name").":</td><td><input size=35 class=textbox type=text name=accountname required=required value=\"$accountname\"></td></tr>";
echo "<tr><td colspan=2><button class=button type=submit id=submitbutton><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button>";
echo "</form>";
echo "</td></tr>";
echo "</table>";

stop_blue_box();

require_once("footer.php");

}



function editaccount2() {
require_once("validate.php");
require("deps.php");
require("common.php");

$accountname = pv($_REQUEST['accountname']);
$accountid = pv($_REQUEST['accountid']);


$rs_update_account = "UPDATE glsaccounts SET accountname = '$accountname' WHERE accountid = '$accountid'";
@mysqli_query($rs_connect, $rs_update_account);

header("Location: saccounts.php");

}

function importsalestaxrates() {
require_once("validate.php");
require("deps.php");
require("common.php");

$rs_find_tax = "SELECT * FROM taxes  ORDER BY taxname ASC";
$rs_result_tax = mysqli_query($rs_connect, $rs_find_tax);
while($rs_result_tq = mysqli_fetch_object($rs_result_tax)) {
$rs_taxname = "$rs_result_tq->taxname";
$rs_taxid = "$rs_result_tq->taxid";
$rs_find_xtax = "SELECT * FROM glsaccounts WHERE linkedtaxid = '$rs_taxid'";
$rs_result_xtax = mysqli_query($rs_connect, $rs_find_xtax);
$xtax = mysqli_num_rows($rs_result_xtax);
if($xtax == 0) {
$rs_insert_account = "INSERT INTO glsaccounts (accountname, accounttype, ledgerid, linkedtaxid) VALUES ('$rs_taxname','liability','$userledgerid','$rs_taxid')";
@mysqli_query($rs_connect, $rs_insert_account);
}
}


header("Location: saccounts.php");

}




switch($func) {
                                                                                                    
    default:
    accounts();
    break;
                                
    case "newaccount":
    newaccount();
    break;

  case "deleteaccount":
    deleteaccount();
    break;

  case "editaccount":
    editaccount();
    break;

  case "editaccount2":
    editaccount2();
    break;

  case "importsalestaxrates":
    importsalestaxrates();
    break;


}

?>

