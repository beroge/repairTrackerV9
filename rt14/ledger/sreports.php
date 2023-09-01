<?php

/***************************************************************************
 *   copyright            : (C) 2020 PCRepairTracker.com
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


function reportlist() {
require_once("header.php");

echo "<script type=\"text/javascript\">document.title = \"".pcrtlang("Reports")."\";</script>";


$thedate = date("Y-m-d");
$firstdayofyear = date("Y")."-01-01";
     
echo "<table width=100%><tr><td width=48% valign=top>";
start_blue_box(pcrtlang("Income/Expense Reports"));
echo "<form action=sreports.php?func=day_span_pl method=post><table class=standard><tr><th colspan=3>".pcrtlang("Day Range Income/Expense Report")."</th></tr>";
echo "<tr><td>".pcrtlang("Enter From Date").":</td><td><input type=date class=textbox name=dayfrom value=\"$firstdayofyear\"></td><td></td>";
echo "<tr><td>".pcrtlang("Enter To Date").":</td><td><input type=date class=textbox name=dayto value=\"$thedate\"></td>";
echo "<td><input class=\"button floatright\" type=submit value=\"".pcrtlang("Show Report")."\"></td></tr></table></form>";
echo "<br>";


$theyear = date("Y");

echo "<form action=sreports.php?func=month_pl method=post><table class=standard><tr><th colspan=3>".pcrtlang("Monthly Income/Expense Report")."&nbsp;</th></tr>";
echo "<tr><td>".pcrtlang("Enter Year").":</td><td><input type=number class=\"textbox\" size=6 name=year value=\"$theyear\"></td>";
echo "<td><input type=submit class=\"button floatright\" value=\"".pcrtlang("Show Report")."\"></td></tr></table></form>";
echo "<br>";

echo "<form action=sreports.php?func=quarter_pl method=post><table class=standard><tr><th colspan=3>".pcrtlang("Quarterly Income/Expense Report")."</th></tr>";
echo "<tr><td>".pcrtlang("Enter Year").":</td><td><input type=number class=\"textbox\" name=year value=\"$theyear\"></td>";
echo "<td><input class=\"button floatright\" type=submit value=\"".pcrtlang("Show Report")."\"></td></tr></table></form>";
echo "<br>";

echo "<form action=sreports.php?func=year_pl method=post><table class=standard><tr><th colspan=3>".pcrtlang("Yearly Income/Expense Report")."</th></tr>";
echo "<tr><td>".pcrtlang("Enter Year").":</td><td><input type=number class=\"textbox\" name=year value=\"$theyear\"></td>";
echo "<td><input class=\"button floatright\" type=submit value=\"".pcrtlang("Show Report")."\"></td></tr></table></form>";
echo "<br>";

stop_blue_box();

echo "</td><td width=4%></td><td width=48% valign=top>";


start_blue_box(pcrtlang("Payee/Account Reports"));

echo "<form action=sreports.php?func=day_span_asr method=post><table class=standard><tr><th colspan=3>".pcrtlang("Day Range Account Summary Report")."</th></tr>";
echo "<tr><td>".pcrtlang("Enter From Date").":</td><td><input type=date class=textbox name=dayfrom value=\"$firstdayofyear\"></td><td></td>";
echo "<tr><td>".pcrtlang("Enter To Date").":</td><td><input type=date class=textbox name=dayto value=\"$thedate\"></td>";
echo "<td><input class=\"button floatright\" type=submit value=\"".pcrtlang("Show Report")."\"></td></tr></table></form>";
echo "<br>";




echo "<form action=sreports.php?func=day_span_ar method=post><table class=standard><tr><th colspan=3>".pcrtlang("Day Range Account Report")."</th></tr>";

echo "<tr><td>".pcrtlang("Account").":</td><td><select class=select name=account>";
echo "<option selected disabled style=\"background:#eeeeee\">".pcrtlang("Income Accounts")."</option>";
$rs_find_income = "SELECT * FROM glsaccounts WHERE accounttype = 'income' AND ledgerid = '$userledgerid'";
$rs_result_income = mysqli_query($rs_connect,$rs_find_income);
while($rs_result_incomeq = mysqli_fetch_object($rs_result_income)) {
$accountid = "$rs_result_incomeq->accountid";
$accountname = "$rs_result_incomeq->accountname";
echo "<option value=$accountid>$accountname</options>";
}
echo "<option disabled style=\"background:#eeeeee\">".pcrtlang("Expense Accounts")."</option>";
$rs_find_expense = "SELECT * FROM glsaccounts WHERE accounttype = 'expense' AND ledgerid = '$userledgerid'";
$rs_result_expense = mysqli_query($rs_connect,$rs_find_expense);
while($rs_result_expenseq = mysqli_fetch_object($rs_result_expense)) {
$accountid = "$rs_result_expenseq->accountid";
$accountname = "$rs_result_expenseq->accountname";
echo "<option value=$accountid>$accountname</options>";
}
echo "<option disabled style=\"background:#eeeeee\">".pcrtlang("Liability Accounts")."</option>";
$rs_find_liability = "SELECT * FROM glsaccounts WHERE accounttype = 'liability' AND ledgerid = '$userledgerid'";
$rs_result_liability = mysqli_query($rs_connect,$rs_find_liability);
while($rs_result_liabilityq = mysqli_fetch_object($rs_result_liability)) {
$accountid = "$rs_result_liabilityq->accountid";
$accountname = "$rs_result_liabilityq->accountname";
echo "<option value=$accountid>$accountname</options>";
}

echo "</select>";
echo "</td><td></td></tr>";






echo "<tr><td>".pcrtlang("Enter From Date").":</td><td><input type=date class=textbox name=dayfrom value=\"$firstdayofyear\"></td><td></td>";
echo "<tr><td>".pcrtlang("Enter To Date").":</td><td><input type=date class=textbox name=dayto value=\"$thedate\"></td>";
echo "<td><input class=\"button floatright\" type=submit value=\"".pcrtlang("Show Report")."\"></td></tr></table></form>";
echo "<br>";


echo "<form action=sreports.php?func=day_span_psr method=post><table class=standard><tr><th colspan=3>".pcrtlang("Day Range Payee Summary Report")."</th></tr>";
echo "<tr><td>".pcrtlang("Enter From Date").":</td><td><input type=date class=textbox name=dayfrom value=\"$firstdayofyear\"></td><td></td>";
echo "<tr><td>".pcrtlang("Enter To Date").":</td><td><input type=date class=textbox name=dayto value=\"$thedate\"></td>";
echo "<td><input class=\"button floatright\" type=submit value=\"".pcrtlang("Show Report")."\"></td></tr></table></form>";
echo "<br>";

echo "<form action=sreports.php?func=day_span_pr method=post><table class=standard><tr><th colspan=3>".pcrtlang("Day Range Payee Report")."</th></tr>";

?>
<script src="../repair/jq/select2.min.js"></script>
<link rel="stylesheet" href="../repair/jq/select2.min.css">
<?php


echo "<tr><td>".pcrtlang("Payee").":</td><td><select class=select-payee name=payee placeholder=\"Choose or Search Payee\">";
echo "<option style=\"background:#eeeeee\" value=\"\">".pcrtlang("Choose or Search Payee")."</option>";
$rs_find_payees = "SELECT * FROM glpayees ORDER BY payeename ASC";
$rs_result_payees = mysqli_query($rs_connect,$rs_find_payees);
while($rs_result_payeesq = mysqli_fetch_object($rs_result_payees)) {
$payeeid = "$rs_result_payeesq->payeeid";
$payeename = "$rs_result_payeesq->payeename";
echo "<option value=$payeeid>$payeename</options>";
}

echo "</select>";

?>
<script>
$(document).ready(function() {
    $('.select-payee').select2();
});
</script>
<?php


echo "</td><td></td></tr>";

echo "<tr><td>".pcrtlang("Enter From Date").":</td><td><input type=date class=textbox name=dayfrom value=\"$firstdayofyear\"></td><td></td>";
echo "<tr><td>".pcrtlang("Enter To Date").":</td><td><input type=date class=textbox name=dayto value=\"$thedate\"></td>";
echo "<td><input class=\"button floatright\" type=submit value=\"".pcrtlang("Show Report")."\"></td></tr></table></form>";
echo "<br>";



stop_blue_box();


echo "</td></tr></table>";
                                                                                                                        
require_once("footer.php");
                                                                                                                             
}





function day_span_pl() {

require_once("deps.php");
require_once("common.php");

if (array_key_exists('dayto',$_REQUEST)) {
if ($_REQUEST['dayto'] != "") {
$dayto = $_REQUEST['dayto'];
} else {
$dayto = date("Y-m-d");
}
} else {
$dayto = date("Y-m-d");
}

if (array_key_exists('dayfrom',$_REQUEST)) {
if ($_REQUEST['dayfrom'] != "") {
$dayfrom = $_REQUEST['dayfrom'];
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}

if(!isset($_REQUEST['printable'])) {
require_once("header.php");
} else {
printableheadernw(pcrtlang("Day Span Report")." $dayfrom - $dayto");
}

start_box();

echo "<table width=100%><tr><td width=75%>";

echo "<h4>".pcrtlang("Report for")." $dayfrom ".pcrtlang("to")." $dayto</h4>";

echo "</td><td width=25% align=right>";

if(!isset($_REQUEST['printable'])) {
echo "<a href=sreports.php?func=day_span_pl&dayto=$dayto&dayfrom=$dayfrom&printable=yes class=linkbutton target=_blank><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Printable")."</a>";
}


echo "</td></tr></table>";


echo "<table class=\"bigstandard lastalignright3\">";

echo "<tr><th></th><th>".pcrtlang("Expense")."</th><th>".pcrtlang("Income")."</th><th>".pcrtlang("Balance")."</th></tr>";

$rs_find_e = "SELECT SUM(expense) AS dtotal, SUM(income) AS ctotal FROM glstransdet,glstrans,glsaccounts 
WHERE glstrans.ledgerid = '$userledgerid' AND glstrans.transid = glstransdet.transid
AND glstransdet.accountid = glsaccounts.accountid AND glsaccounts.accounttype = 'expense' 
AND glstrans.transdate <= '$dayto 23:59:59' AND glstrans.transdate >= '$dayfrom 00:00:00'";
$rs_result_e = mysqli_query($rs_connect, $rs_find_e);
$rs_result_e_q = mysqli_fetch_object($rs_result_e);
$rs_dtotal_e = "$rs_result_e_q->dtotal";
$rs_ctotal_e = "$rs_result_e_q->ctotal";
$balance_e = $rs_ctotal_e - $rs_dtotal_e;
if($balance_e < 0) {
$pbalance_e = "(".mf(abs($balance_e)).")";
} else {
$pbalance_e = mf("$balance_e");
}
echo "<tr><td>".pcrtlang("Expense Accounts")."</td><td>$money".mf("$rs_dtotal_e")."</td><td>$money".mf("$rs_ctotal_e")."</td><td>$pbalance_e</td></tr>";

$rs_find_i = "SELECT SUM(expense) AS dtotal, SUM(income) AS ctotal FROM glstransdet,glstrans,glsaccounts
WHERE glstrans.ledgerid = '$userledgerid' AND glstrans.transid = glstransdet.transid
AND glstransdet.accountid = glsaccounts.accountid AND glsaccounts.accounttype = 'income'
AND glstrans.transdate <= '$dayto 23:59:59' AND glstrans.transdate >= '$dayfrom 00:00:00'";
$rs_result_i = mysqli_query($rs_connect, $rs_find_i);
$rs_result_i_q = mysqli_fetch_object($rs_result_i);
$rs_dtotal_i = "$rs_result_i_q->dtotal";
$rs_ctotal_i = "$rs_result_i_q->ctotal";
$balance_i = $rs_ctotal_i - $rs_dtotal_i;
if($balance_i < 0) {
$pbalance_i = "(".mf(abs($balance_i)).")";
} else {
$pbalance_i = mf("$balance_i");
}
echo "<tr><td>".pcrtlang("Income Accounts")."</td><td>$money".mf("$rs_dtotal_i")."</td><td>$money".mf("$rs_ctotal_i")."</td><td>$money$pbalance_i</td></tr>";

$rs_find_l = "SELECT SUM(expense) AS dtotal, SUM(income) AS ctotal FROM glstransdet,glstrans,glsaccounts
WHERE glstrans.ledgerid = '$userledgerid' AND glstrans.transid = glstransdet.transid
AND glstransdet.accountid = glsaccounts.accountid AND glsaccounts.accounttype = 'liability'
AND glstrans.transdate <= '$dayto 23:59:59' AND glstrans.transdate >= '$dayfrom 00:00:00'";
$rs_result_l = mysqli_query($rs_connect, $rs_find_l);
$rs_result_l_q = mysqli_fetch_object($rs_result_l);
$rs_dtotal_l = "$rs_result_l_q->dtotal";
$rs_ctotal_l = "$rs_result_l_q->ctotal";
$balance_l = $rs_ctotal_l - $rs_dtotal_l;
if($balance_l < 0) {
$pbalance_l = "(".mf(abs($balance_l)).")";
} else {
$pbalance_l = mf("$balance_l");
}
echo "<tr><td>".pcrtlang("Liability Accounts")."</td><td>$money".mf("$rs_dtotal_l")."</td><td>$money".mf("$rs_ctotal_l")."</td><td>$money$pbalance_l</td></tr>";

$ledgerbalance = $balance_e + $balance_i + $balance_l;
$iebalance = $balance_e + $balance_i;


if($ledgerbalance < 0) {
$pledgerbalance = "(".mf(abs($ledgerbalance)).")";
} else {
$pledgerbalance = mf("$ledgerbalance");
}

if($iebalance < 0) {
$piebalance = "(".mf(abs($iebalance)).")";
} else {
$piebalance = mf("$iebalance");
}


echo "<tr style=\"border-top: #333333 2px solid\"><td>".pcrtlang("Ledger Balance")."</td><td></td><td></td><td>$money$pledgerbalance</td></tr>";

echo "<tr><td>".pcrtlang("Income/Expense Balance")."</td><td></td><td></td><td>$money$piebalance</td></tr>";

echo "</table>";



####



if(!isset($_REQUEST['printable'])) {
stop_box();
}

if(!isset($_REQUEST['printable'])) {
require("footer.php");
} else {
printablefooter();
}

}

################################################################################################################################

function year_pl() {

require_once("deps.php");
require_once("common.php");

if (array_key_exists('year',$_REQUEST)) {
if ($_REQUEST['year'] != "") {
$year = $_REQUEST['year'];
} else {
$year = date("Y");
}
} else {
$year = date("Y");
}


if(!isset($_REQUEST['printable'])) {
require_once("header.php");
} else {
printableheadernw(pcrtlang("Yearly Report").": $year");
}

start_box();

echo "<table width=100%><tr><td width=75%>";

echo "<h4>".pcrtlang("Yearly Report for").": $year</h4>";

echo "</td><td width=25% align=right>";

if(!isset($_REQUEST['printable'])) {
echo "<a href=sreports.php?func=year_pl&year=$year&printable=yes class=linkbutton target=_blank><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Printable")."</a>";
}


echo "</td></tr></table>";


echo "<table class=\"bigstandard lastalignright3\">";

echo "<tr><th></th><th>".pcrtlang("Expense")."</th><th>".pcrtlang("Income")."</th><th>".pcrtlang("Balance")."</th></tr>";

$rs_find_e = "SELECT SUM(expense) AS dtotal, SUM(income) AS ctotal FROM glstransdet,glstrans,glsaccounts
WHERE glstrans.ledgerid = '$userledgerid' AND glstrans.transid = glstransdet.transid
AND glstransdet.accountid = glsaccounts.accountid AND glsaccounts.accounttype = 'expense'
AND glstrans.transdate LIKE '$year%'";
$rs_result_e = mysqli_query($rs_connect, $rs_find_e);
$rs_result_e_q = mysqli_fetch_object($rs_result_e);
$rs_dtotal_e = "$rs_result_e_q->dtotal";
$rs_ctotal_e = "$rs_result_e_q->ctotal";
$balance_e = $rs_ctotal_e - $rs_dtotal_e;
if($balance_e < 0) {
$pbalance_e = "(".mf(abs($balance_e)).")";
} else {
$pbalance_e = mf("$balance_e");
}
echo "<tr><td>".pcrtlang("Expense Accounts")."</td><td>$money".mf("$rs_dtotal_e")."</td><td>$money".mf("$rs_ctotal_e")."</td><td>$money$pbalance_e</td></tr>";

$rs_find_i = "SELECT SUM(expense) AS dtotal, SUM(income) AS ctotal FROM glstransdet,glstrans,glsaccounts
WHERE glstrans.ledgerid = '$userledgerid' AND glstrans.transid = glstransdet.transid
AND glstransdet.accountid = glsaccounts.accountid AND glsaccounts.accounttype = 'income'
AND glstrans.transdate LIKE '$year%'";
$rs_result_i = mysqli_query($rs_connect, $rs_find_i);
$rs_result_i_q = mysqli_fetch_object($rs_result_i);
$rs_dtotal_i = "$rs_result_i_q->dtotal";
$rs_ctotal_i = "$rs_result_i_q->ctotal";
$balance_i = $rs_ctotal_i - $rs_dtotal_i;
if($balance_i < 0) {
$pbalance_i = "(".mf(abs($balance_i)).")";
} else {
$pbalance_i = mf("$balance_i");
}
echo "<tr><td>".pcrtlang("Income Accounts")."</td><td>$money".mf("$rs_dtotal_i")."</td><td>$money".mf("$rs_ctotal_i")."</td><td>$money$pbalance_i</td></tr>";

$rs_find_l = "SELECT SUM(expense) AS dtotal, SUM(income) AS ctotal FROM glstransdet,glstrans,glsaccounts
WHERE glstrans.ledgerid = '$userledgerid' AND glstrans.transid = glstransdet.transid
AND glstransdet.accountid = glsaccounts.accountid AND glsaccounts.accounttype = 'liability'
AND glstrans.transdate LIKE '$year%'";
$rs_result_l = mysqli_query($rs_connect, $rs_find_l);
$rs_result_l_q = mysqli_fetch_object($rs_result_l);
$rs_dtotal_l = "$rs_result_l_q->dtotal";
$rs_ctotal_l = "$rs_result_l_q->ctotal";
$balance_l = $rs_ctotal_l - $rs_dtotal_l;
if($balance_l < 0) {
$pbalance_l = "(".mf(abs($balance_l)).")";
} else {
$pbalance_l = mf("$balance_l");
}
echo "<tr><td>".pcrtlang("Liability Accounts")."</td><td>$money".mf("$rs_dtotal_l")."</td><td>$money".mf("$rs_ctotal_l")."</td><td>$money$pbalance_l</td></tr>";

$ledgerbalance = $balance_e + $balance_i + $balance_l;

if($ledgerbalance < 0) {
$pledgerbalance = "(".mf(abs($ledgerbalance)).")";
} else {
$pledgerbalance = mf("$ledgerbalance");
}


$iebalance = $balance_e + $balance_i;

if($iebalance < 0) {
$piebalance = "(".mf(abs($iebalance)).")";
} else {
$piebalance = mf("$iebalance");
}


echo "<tr style=\"border-top: #333333 2px solid\"><td>".pcrtlang("Ledger Balance")."</td><td></td><td></td><td>$money$pledgerbalance</td></tr>";
echo "<tr><td>".pcrtlang("Income/Expense Balance")."</td><td></td><td></td><td>$money$piebalance</td></tr>";
echo "</table>";


####



if(!isset($_REQUEST['printable'])) {
stop_box();
}

if(!isset($_REQUEST['printable'])) {
require("footer.php");
} else {
printablefooter();
}

}


################################################################################################################################

function quarter_pl() {

require_once("deps.php");
require_once("common.php");

if (array_key_exists('year',$_REQUEST)) {
if ($_REQUEST['year'] != "") {
$year = $_REQUEST['year'];
} else {
$year = date("Y");
}
} else {
$year = date("Y");
}


if(!isset($_REQUEST['printable'])) {
require_once("header.php");
} else {
printableheadernw(pcrtlang("Quarterly Report").": $year");
}

start_box();

echo "<table width=100%><tr><td width=75%>";

echo "<h4>".pcrtlang("Quarterly Report for")." $year</h4>";

echo "</td><td width=25% align=right>";

if(!isset($_REQUEST['printable'])) {
echo "<a href=sreports.php?func=quarter_pl&year=$year&printable=yes class=linkbutton target=_blank><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Printable")."</a>";
}


echo "</td></tr></table>";

$firstq = 1;

while($firstq <= 4) {

echo "<table class=\"bigstandard lastalignright3\">";

echo "<tr><th>".pcrtlang("Quarter")." &num;$firstq</th><th>".pcrtlang("Expense")."</th><th>".pcrtlang("Income")."</th><th>".pcrtlang("Balance")."</th></tr>";

$rs_find_e = "SELECT SUM(expense) AS dtotal, SUM(income) AS ctotal FROM glstransdet,glstrans,glsaccounts
WHERE glstrans.ledgerid = '$userledgerid' AND glstrans.transid = glstransdet.transid
AND glstransdet.accountid = glsaccounts.accountid AND glsaccounts.accounttype = 'expense'
AND QUARTER(glstrans.transdate) = '$firstq' AND YEAR(glstrans.transdate) = '$year'";
$rs_result_e = mysqli_query($rs_connect, $rs_find_e);
$rs_result_e_q = mysqli_fetch_object($rs_result_e);
$rs_dtotal_e = "$rs_result_e_q->dtotal";
$rs_ctotal_e = "$rs_result_e_q->ctotal";
$balance_e = $rs_ctotal_e - $rs_dtotal_e;
if($balance_e < 0) {
$pbalance_e = "(".mf(abs($balance_e)).")";
} else {
$pbalance_e = mf("$balance_e");
}
echo "<tr><td>".pcrtlang("Expense Accounts")."</td><td>$money".mf("$rs_dtotal_e")."</td><td>$money".mf("$rs_ctotal_e")."</td><td>$money$pbalance_e</td></tr>";

$rs_find_i = "SELECT SUM(expense) AS dtotal, SUM(income) AS ctotal FROM glstransdet,glstrans,glsaccounts
WHERE glstrans.ledgerid = '$userledgerid' AND glstrans.transid = glstransdet.transid
AND glstransdet.accountid = glsaccounts.accountid AND glsaccounts.accounttype = 'income'
AND QUARTER(glstrans.transdate) = '$firstq' AND YEAR(glstrans.transdate) = '$year'";
$rs_result_i = mysqli_query($rs_connect, $rs_find_i);
$rs_result_i_q = mysqli_fetch_object($rs_result_i);
$rs_dtotal_i = "$rs_result_i_q->dtotal";
$rs_ctotal_i = "$rs_result_i_q->ctotal";
$balance_i = $rs_ctotal_i - $rs_dtotal_i;
if($balance_i < 0) {
$pbalance_i = "(".mf(abs($balance_i)).")";
} else {
$pbalance_i = mf("$balance_i");
}
echo "<tr><td>".pcrtlang("Income Accounts")."</td><td>$money".mf("$rs_dtotal_i")."</td><td>$money".mf("$rs_ctotal_i")."</td><td>$money$pbalance_i</td></tr>";

$rs_find_l = "SELECT SUM(expense) AS dtotal, SUM(income) AS ctotal FROM glstransdet,glstrans,glsaccounts
WHERE glstrans.ledgerid = '$userledgerid' AND glstrans.transid = glstransdet.transid
AND glstransdet.accountid = glsaccounts.accountid AND glsaccounts.accounttype = 'liability'
AND QUARTER(glstrans.transdate) = '$firstq' AND YEAR(glstrans.transdate) = '$year'";
$rs_result_l = mysqli_query($rs_connect, $rs_find_l);
$rs_result_l_q = mysqli_fetch_object($rs_result_l);
$rs_dtotal_l = "$rs_result_l_q->dtotal";
$rs_ctotal_l = "$rs_result_l_q->ctotal";
$balance_l = $rs_ctotal_l - $rs_dtotal_l;
if($balance_l < 0) {
$pbalance_l = "(".mf(abs($balance_l)).")";
} else {
$pbalance_l = mf("$balance_l");
}
echo "<tr><td>".pcrtlang("Liability Accounts")."</td><td>$money".mf("$rs_dtotal_l")."</td><td>$money".mf("$rs_ctotal_l")."</td><td>$money$pbalance_l</td></tr>";

$ledgerbalance = $balance_e + $balance_i + $balance_l;

if($ledgerbalance < 0) {
$pledgerbalance = "(".mf(abs($ledgerbalance)).")";
} else {
$pledgerbalance = mf("$ledgerbalance");
}


echo "<tr style=\"border-top: #333333 2px solid\"><td>".pcrtlang("Ledger Balance")."</td><td></td><td></td><td>$money$pledgerbalance</td></tr>";

$iebalance = $balance_e + $balance_i;

if($iebalance < 0) {
$piebalance = "(".mf(abs($iebalance)).")";
} else {
$piebalance = mf("$iebalance");
}


echo "<tr><td>".pcrtlang("Income/Expense Balance")."</td><td></td><td></td><td>$money$piebalance</td></tr>";


echo "</table><br>";

$firstq++;

}



####



if(!isset($_REQUEST['printable'])) {
stop_box();
}

if(!isset($_REQUEST['printable'])) {
require("footer.php");
} else {
printablefooter();
}

}


################################################################################################################################

function month_pl() {

require_once("deps.php");
require_once("common.php");

if (array_key_exists('year',$_REQUEST)) {
if ($_REQUEST['year'] != "") {
$year = $_REQUEST['year'];
} else {
$year = date("Y");
}
} else {
$year = date("Y");
}


if(!isset($_REQUEST['printable'])) {
require_once("header.php");
} else {
printableheadernw(pcrtlang("Monthly Report")." $year");
}

start_box();

echo "<table width=100%><tr><td width=75%>";

echo "<h4>".pcrtlang("Monthly Report for")." $year</h4>";

echo "</td><td width=25% align=right>";

if(!isset($_REQUEST['printable'])) {
echo "<a href=sreports.php?func=month_pl&year=$year&printable=yes class=linkbutton target=_blank><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Printable")."</a>";
}


echo "</td></tr></table>";

$m = 1;

while($m < 13) {

echo "<table class=\"bigstandard lastalignright3\" style=\"width:600px;\">";

echo "<tr><th>";

if ($m == 1) {
echo pcrtlang("January");
} elseif ($m == 2) {
echo pcrtlang("February");
} elseif ($m == 3) {
echo pcrtlang("March");
} elseif ($m == 4) {
echo pcrtlang("April");
} elseif ($m == 5) {
echo pcrtlang("May");
} elseif ($m == 6) {
echo pcrtlang("June");
} elseif ($m == 7) {
echo pcrtlang("July");
} elseif ($m == 8) {
echo pcrtlang("August");
} elseif ($m == 9) {
echo pcrtlang("September");
} elseif ($m == 10) {
echo pcrtlang("October");
} elseif ($m == 11) {
echo pcrtlang("November");
} else {
echo pcrtlang("December");
}


echo "</th><th>".pcrtlang("Expense")."</th><th>".pcrtlang("Income")."</th><th>".pcrtlang("Balance")."</th></tr>";

$rs_find_e = "SELECT SUM(expense) AS dtotal, SUM(income) AS ctotal FROM glstransdet,glstrans,glsaccounts
WHERE glstrans.ledgerid = '$userledgerid' AND glstrans.transid = glstransdet.transid
AND glstransdet.accountid = glsaccounts.accountid AND glsaccounts.accounttype = 'expense'
AND MONTH(glstrans.transdate) = '$m' AND YEAR(glstrans.transdate) = '$year'";
$rs_result_e = mysqli_query($rs_connect, $rs_find_e);
$rs_result_e_q = mysqli_fetch_object($rs_result_e);
$rs_dtotal_e = "$rs_result_e_q->dtotal";
$rs_ctotal_e = "$rs_result_e_q->ctotal";
$balance_e = $rs_ctotal_e - $rs_dtotal_e;
if($balance_e < 0) {
$pbalance_e = "(".mf(abs($balance_e)).")";
} else {
$pbalance_e = mf("$balance_e");
}
echo "<tr><td>".pcrtlang("Expense Accounts")."</td><td>$money".mf("$rs_dtotal_e")."</td><td>$money".mf("$rs_ctotal_e")."</td><td>$money$pbalance_e</td></tr>";

$rs_find_i = "SELECT SUM(expense) AS dtotal, SUM(income) AS ctotal FROM glstransdet,glstrans,glsaccounts
WHERE glstrans.ledgerid = '$userledgerid' AND glstrans.transid = glstransdet.transid
AND glstransdet.accountid = glsaccounts.accountid AND glsaccounts.accounttype = 'income'
AND MONTH(glstrans.transdate) = '$m' AND YEAR(glstrans.transdate) = '$year'";
$rs_result_i = mysqli_query($rs_connect, $rs_find_i);
$rs_result_i_q = mysqli_fetch_object($rs_result_i);
$rs_dtotal_i = "$rs_result_i_q->dtotal";
$rs_ctotal_i = "$rs_result_i_q->ctotal";
$balance_i = $rs_ctotal_i - $rs_dtotal_i;
if($balance_i < 0) {
$pbalance_i = "(".mf(abs($balance_i)).")";
} else {
$pbalance_i = mf("$balance_i");
}
echo "<tr><td>".pcrtlang("Income Accounts")."</td><td>$money".mf("$rs_dtotal_i")."</td><td>$money".mf("$rs_ctotal_i")."</td><td>$money$pbalance_i</td></tr>";

$rs_find_l = "SELECT SUM(expense) AS dtotal, SUM(income) AS ctotal FROM glstransdet,glstrans,glsaccounts
WHERE glstrans.ledgerid = '$userledgerid' AND glstrans.transid = glstransdet.transid
AND glstransdet.accountid = glsaccounts.accountid AND glsaccounts.accounttype = 'liability'
AND MONTH(glstrans.transdate) = '$m' AND YEAR(glstrans.transdate) = '$year'";
$rs_result_l = mysqli_query($rs_connect, $rs_find_l);
$rs_result_l_q = mysqli_fetch_object($rs_result_l);
$rs_dtotal_l = "$rs_result_l_q->dtotal";
$rs_ctotal_l = "$rs_result_l_q->ctotal";
$balance_l = $rs_ctotal_l - $rs_dtotal_l;
if($balance_l < 0) {
$pbalance_l = "(".mf(abs($balance_l)).")";
} else {
$pbalance_l = mf("$balance_l");
}
echo "<tr><td>".pcrtlang("Liability Accounts")."</td><td>$money".mf("$rs_dtotal_l")."</td><td>$money".mf("$rs_ctotal_l")."</td><td>$money$pbalance_l</td></tr>";

$ledgerbalance = $balance_e + $balance_i + $balance_l;

if($ledgerbalance < 0) {
$pledgerbalance = "(".mf(abs($ledgerbalance)).")";
} else {
$pledgerbalance = mf("$ledgerbalance");
}


echo "<tr style=\"border-top: #333333 2px solid\"><td>".pcrtlang("Ledger Balance")."</td><td></td><td></td><td>$money$pledgerbalance</td></tr>";


$iebalance = $balance_e + $balance_i;

if($iebalance < 0) {
$piebalance = "(".mf(abs($iebalance)).")";
} else {
$piebalance = mf("$iebalance");
}


echo "<tr><td>".pcrtlang("Income/Expense Balance")."</td><td></td><td></td><td>$money$piebalance</td></tr>";


echo "</table><br>";

$m++;

}



####



if(!isset($_REQUEST['printable'])) {
stop_box();
}

if(!isset($_REQUEST['printable'])) {
require("footer.php");
} else {
printablefooter();
}

}



#################################################################################################################################

function day_span_asr() {

require_once("deps.php");
require_once("common.php");

if (array_key_exists('dayto',$_REQUEST)) {
if ($_REQUEST['dayto'] != "") {
$dayto = $_REQUEST['dayto'];
} else {
$dayto = date("Y-m-d");
}
} else {
$dayto = date("Y-m-d");
}

if (array_key_exists('dayfrom',$_REQUEST)) {
if ($_REQUEST['dayfrom'] != "") {
$dayfrom = $_REQUEST['dayfrom'];
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}

if(!isset($_REQUEST['printable'])) {
require_once("header.php");
} else {
printableheadernw(pcrtlang("Account Summary Report").": $dayfrom - $dayto");
}

start_box();

echo "<table width=100%><tr><td width=75%>";

echo "<h4>".pcrtlang("Account Summary Report")." $dayfrom ".pcrtlang("to")." $dayto</h4>";

echo "</td><td width=25% align=right>";

if(!isset($_REQUEST['printable'])) {
echo "<a href=sreports.php?func=day_span_asr&dayto=$dayto&dayfrom=$dayfrom&printable=yes class=linkbutton target=_blank><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Printable")."</a>";
}

echo "</td></tr></table>";


$accounttypes = array('income' => "Income", 'expense' => "Expenses", 'liability' => "Liabilities");

foreach($accounttypes as $key => $val) {


echo "<h4>$val</h4>";

echo "<table class=\"bigstandard lastalignright3\" style=\"width:600px;\">";

echo "<tr><th style=\"width:300px;\">".pcrtlang("Account")."</th><th>".pcrtlang("Expense")."</th><th>".pcrtlang("Income")."</th><th>".pcrtlang("Balance")."</th></tr>";


$rs_find_acc = "SELECT * FROM glsaccounts WHERE ledgerid = '$userledgerid' AND accounttype = '$key'";
$rs_result_acc = mysqli_query($rs_connect, $rs_find_acc);
while($rs_result_acc_q = mysqli_fetch_object($rs_result_acc)) {
$accountid = "$rs_result_acc_q->accountid";
$accountname = "$rs_result_acc_q->accountname";


$rs_find_e = "SELECT SUM(expense) AS dtotal, SUM(income) AS ctotal FROM glstransdet,glstrans,glsaccounts
WHERE glstrans.ledgerid = '$userledgerid' AND glstrans.transid = glstransdet.transid
AND glstransdet.accountid = glsaccounts.accountid
AND glsaccounts.accountid = glstransdet.accountid
AND glstransdet.accountid = '$accountid'
AND glstrans.transdate <= '$dayto 23:59:59' AND glstrans.transdate >= '$dayfrom 00:00:00'";
$rs_result_e = mysqli_query($rs_connect, $rs_find_e);
$rs_result_e_q = mysqli_fetch_object($rs_result_e);
$rs_dtotal_e = "$rs_result_e_q->dtotal";
$rs_ctotal_e = "$rs_result_e_q->ctotal";
$balance_e = $rs_ctotal_e - $rs_dtotal_e;
if($balance_e < 0) {
$pbalance_e = "(".mf(abs($balance_e)).")";
} else {
$pbalance_e = mf("$balance_e");
}
echo "<tr><td>$accountname</td><td>$money".mf("$rs_dtotal_e")."</td><td>$money".mf("$rs_ctotal_e")."</td><td>$money$pbalance_e</td></tr>";

}

echo "</table>";

}

####



if(!isset($_REQUEST['printable'])) {
stop_box();
}

if(!isset($_REQUEST['printable'])) {
require("footer.php");
} else {
printablefooter();
}

}



#################################################################################################################################

function day_span_ar() {

require_once("deps.php");
require_once("common.php");

if (array_key_exists('dayto',$_REQUEST)) {
if ($_REQUEST['dayto'] != "") {
$dayto = $_REQUEST['dayto'];
} else {
$dayto = date("Y-m-d");
}
} else {
$dayto = date("Y-m-d");
}

if (array_key_exists('dayfrom',$_REQUEST)) {
if ($_REQUEST['dayfrom'] != "") {
$dayfrom = $_REQUEST['dayfrom'];
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}

$account = $_REQUEST['account'];

if(!isset($_REQUEST['printable'])) {
require_once("header.php");
} else {
printableheadernw(pcrtlang("Account Report")." $dayfrom - $dayto");
}

start_box();

echo "<table width=100%><tr><td width=75%>";

echo "<h4>".pcrtlang("Account Report").": ".getaccountname("$account")."</h4>";

echo "<h4>$dayfrom ".pcrtlang("to")." $dayto</h4>";

echo "</td><td width=25% align=right>";

if(!isset($_REQUEST['printable'])) {
echo "<a href=sreports.php?func=day_span_ar&dayto=$dayto&dayfrom=$dayfrom&printable=yes&account=$account class=linkbutton target=_blank><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Printable")."</a>";
}

echo "</td></tr></table>";


####

echo "<table class=\"standard lastalignright3\">";
echo "<tr><th style=\"width:100px\">".pcrtlang("Date")."</th><th style=\"width:100px\">".pcrtlang("Number")."</th><th>".pcrtlang("Description")."</th>";
echo "<th>".pcrtlang("Payee")."</th>";
echo "<th style=\"width:100px;text-align:right\">".pcrtlang("Expense")."</th><th style=\"width:100px;text-align:right\">".pcrtlang("Income")."</th>";
echo "<th style=\"width:100px;text-align:right\">".pcrtlang("Line Total")."</th></tr>";

$itotal = 0;
$etotal = 0;
$ctotal = 0;

$rs_find_e = "SELECT glstransdet.transid AS transid,glstransdet.income AS income,glstransdet.expense AS expense,glstrans.transdesc AS transdesc,glstransdet.payee 
AS payee,glstrans.transdate AS transdate,glstrans.receiptid AS receiptid, glstrans.invoiceid AS invoiceid FROM glstransdet,glstrans
WHERE glstrans.ledgerid = '$userledgerid' AND glstrans.transid = glstransdet.transid
AND glstransdet.accountid = '$account'
AND glstrans.transid = glstransdet.transid
AND glstrans.transdate <= '$dayto 23:59:59' AND glstrans.transdate >= '$dayfrom 00:00:00'";
$rs_result_e = mysqli_query($rs_connect, $rs_find_e);
while($rs_result_e_q = mysqli_fetch_object($rs_result_e)) {
$transid = "$rs_result_e_q->transid";
$transdesc = "$rs_result_e_q->transdesc";
$payee = "$rs_result_e_q->payee";
$invoiceid = "$rs_result_e_q->invoiceid";
$receiptid = "$rs_result_e_q->receiptid";
$transdate2 = "$rs_result_e_q->transdate";
$transdate = pcrtdate("$pcrt_shortdate", "$transdate2");



echo "<tr><td>$transdate</td>";
echo "<td>";
if ($receiptid != 0) {
echo "<a href=\"../store/receipt.php?func=show_receipt&receipt=$receiptid\" target=\"_blank\" class=\"linkbuttongray linkbuttontiny radiusall\">";
echo "<i class=\"fa fa-receipt\"></i> $receiptid</a>";
if (!comparereceipttrans($receiptid, $transid)) {
echo " <i class=\"fa fa-warning colormered\"></i>";
}
} elseif ($invoiceid != 0) {
echo "<a href=\"../store/invoice.php?func=printinv&invoice_id=$invoiceid\" target=\"_blank\" class=\"linkbuttongray linkbuttontiny radiusall\">";
echo "<i class=\"fa fa-file-invoice\"></i> $invoiceid</a>";
if (!compareinvoicetrans($invoiceid, $transid)) {
echo " <i class=\"fa fa-warning colormered\"></i>";
}
}
echo "</td>";

echo "<td>$transdesc</td><td>".getpayeename("$payee")."</td>";

$rs_find_transdet = "SELECT SUM(income) AS income, SUM(expense) AS expense FROM glstransdet WHERE transid = '$transid' AND accountid = '$account'";
$rs_result_transdet = mysqli_query($rs_connect,$rs_find_transdet);
$rs_result_transdetq = mysqli_fetch_object($rs_result_transdet);
$income = "$rs_result_transdetq->income";
$expense = "$rs_result_transdetq->expense" * -1;

$linebalance = $income + $expense;

if($expense != 0) {
echo "<td>$money".mfie("$expense")."</td>";
} else {
echo "<td>-</td>";
}
if($income != 0) {
echo "<td>$money".mfie("$income")."</td>";
} else {
echo "<td>-</td>";
}



echo "<td>$money".mfie("$linebalance")."</td>";

$etotal = $etotal + $expense;
$itotal = $itotal + $income;
$ctotal = $ctotal + $linebalance;

}

echo "<tr style=\"border-top: #333333 2px solid\"><td></td><td></td><td></td><td></td><td>$".mfie($etotal)."</td><td>$".mfie($itotal)."</td><td>$".mfie("$ctotal")."</td>";
echo "";

echo "</table>";



####



if(!isset($_REQUEST['printable'])) {
stop_box();
}

if(!isset($_REQUEST['printable'])) {
require("footer.php");
} else {
printablefooter();
}

}



#################################################################################################################################

function day_span_psr() {

require_once("deps.php");
require_once("common.php");

if (array_key_exists('dayto',$_REQUEST)) {
if ($_REQUEST['dayto'] != "") {
$dayto = $_REQUEST['dayto'];
} else {
$dayto = date("Y-m-d");
}
} else {
$dayto = date("Y-m-d");
}

if (array_key_exists('dayfrom',$_REQUEST)) {
if ($_REQUEST['dayfrom'] != "") {
$dayfrom = $_REQUEST['dayfrom'];
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}

if(!isset($_REQUEST['printable'])) {
require_once("header.php");
} else {
printableheadernw(pcrtlang("Payee Summary Report").": $dayfrom - $dayto");
}

start_box();

echo "<table width=100%><tr><td width=75%>";

echo "<h4>".pcrtlang("Payee Summary Report")." $dayfrom ".pcrtlang("to")." $dayto</h4>";

echo "</td><td width=25% align=right>";

if(!isset($_REQUEST['printable'])) {
echo "<a href=sreports.php?func=day_span_psr&dayto=$dayto&dayfrom=$dayfrom&printable=yes class=linkbutton target=\"_blank\"><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Printable")."</a>";
}

echo "</td></tr></table>";

echo "<table class=\"bigstandard lastalignright3\" style=\"width:600px;\">";

echo "<tr><th style=\"width:300px;\">".pcrtlang("Payee")."</th><th>".pcrtlang("Expense")."</th><th>".pcrtlang("Income")."</th><th>".pcrtlang("Balance")."</th></tr>";


$rs_find_acc = "SELECT * FROM glpayees ORDER BY payeename ASC";
$rs_result_acc = mysqli_query($rs_connect, $rs_find_acc);
while($rs_result_acc_q = mysqli_fetch_object($rs_result_acc)) {
$payeeid = "$rs_result_acc_q->payeeid";
$payeename = "$rs_result_acc_q->payeename";


$rs_find_e = "SELECT SUM(expense) AS dtotal, SUM(income) AS ctotal FROM glstransdet,glstrans
WHERE glstrans.ledgerid = '$userledgerid' AND glstrans.transid = glstransdet.transid
AND glstransdet.payee = '$payeeid'
AND glstrans.transdate <= '$dayto 23:59:59' AND glstrans.transdate >= '$dayfrom 00:00:00'";
$rs_result_e = mysqli_query($rs_connect, $rs_find_e);
$rs_result_e_q = mysqli_fetch_object($rs_result_e);
$rs_dtotal_e = "$rs_result_e_q->dtotal";
$rs_ctotal_e = "$rs_result_e_q->ctotal";
$balance_e = $rs_ctotal_e - $rs_dtotal_e;
if($balance_e < 0) {
$pbalance_e = "(".mf(abs($balance_e)).")";
} else {
$pbalance_e = mf("$balance_e");
}
echo "<tr><td>$payeename</td><td>$money".mf("$rs_dtotal_e")."</td><td>$money".mf("$rs_ctotal_e")."</td><td>$money$pbalance_e</td></tr>";

}

echo "</table>";



####



if(!isset($_REQUEST['printable'])) {
stop_box();
}

if(!isset($_REQUEST['printable'])) {
require("footer.php");
} else {
printablefooter();
}

}


#################################################################################################################################

function day_span_pr() {

require_once("deps.php");
require_once("common.php");

if (array_key_exists('dayto',$_REQUEST)) {
if ($_REQUEST['dayto'] != "") {
$dayto = $_REQUEST['dayto'];
} else {
$dayto = date("Y-m-d");
}
} else {
$dayto = date("Y-m-d");
}

if (array_key_exists('dayfrom',$_REQUEST)) {
if ($_REQUEST['dayfrom'] != "") {
$dayfrom = $_REQUEST['dayfrom'];
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}

$payee = $_REQUEST['payee'];

if(!isset($_REQUEST['printable'])) {
require_once("header.php");
} else {
printableheadernw(pcrtlang("Day Span Report")." $dayfrom - $dayto");
}

start_box();

echo "<table width=100%><tr><td width=75%>";

echo "<h4>".pcrtlang("Payee Report").": ".getpayeename("$payee")."</h4>";

echo "<h4>$dayfrom ".pcrtlang("to")." $dayto</h4>";

echo "</td><td width=25% align=right>";

if(!isset($_REQUEST['printable'])) {
echo "<a href=sreports.php?func=day_span_pr&dayto=$dayto&dayfrom=$dayfrom&printable=yes&payee=$payee class=linkbutton target=_blank><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Printable")."</a>";
}

echo "</td></tr></table>";


####

echo "<table class=\"standard lastalignright3\">";
echo "<tr><th style=\"width:100px\">".pcrtlang("Date")."</th><th style=\"width:100px\">".pcrtlang("Number")."</th><th>".pcrtlang("Description")."</th>";
echo "<th style=\"width:100px;text-align:right\">".pcrtlang("Expense")."</th><th style=\"width:100px;text-align:right\">".pcrtlang("Income")."</th>";
echo "<th style=\"width:100px;text-align:right\">".pcrtlang("Line Total")."</th></tr>";

$itotal = 0;
$etotal = 0;
$ctotal = 0;

$rs_find_e = "SELECT glstransdet.transid AS transid,glstransdet.income AS income,glstransdet.expense AS expense,glstrans.transdesc AS transdesc,glstransdet.payee
AS payee,glstrans.transdate AS transdate,glstrans.receiptid AS receiptid, glstrans.invoiceid AS invoiceid FROM glstransdet,glstrans
WHERE glstrans.ledgerid = '$userledgerid' AND glstrans.transid = glstransdet.transid
AND glstransdet.payee = '$payee'
AND glstrans.transid = glstransdet.transid
AND glstrans.transdate <= '$dayto 23:59:59' AND glstrans.transdate >= '$dayfrom 00:00:00'
ORDER BY transdate ASC";
$rs_result_e = mysqli_query($rs_connect, $rs_find_e);
while($rs_result_e_q = mysqli_fetch_object($rs_result_e)) {
$transid = "$rs_result_e_q->transid";
$transdesc = "$rs_result_e_q->transdesc";
$payee = "$rs_result_e_q->payee";
$invoiceid = "$rs_result_e_q->invoiceid";
$receiptid = "$rs_result_e_q->receiptid";
$transdate2 = "$rs_result_e_q->transdate";
$transdate = pcrtdate("$pcrt_shortdate", "$transdate2");



echo "<tr><td>$transdate</td>";
echo "<td>";
if ($receiptid != 0) {
echo "<a href=\"../store/receipt.php?func=show_receipt&receipt=$receiptid\" target=\"_blank\" class=\"linkbuttongray linkbuttontiny radiusall\">";
echo "<i class=\"fa fa-receipt\"></i> $receiptid</a>";
if (!comparereceipttrans($receiptid, $transid)) {
echo " <i class=\"fa fa-warning colormered\"></i>";
}
} elseif ($invoiceid != 0) {
echo "<a href=\"../store/invoice.php?func=printinv&invoice_id=$invoiceid\" target=\"_blank\" class=\"linkbuttongray linkbuttontiny radiusall\">";
echo "<i class=\"fa fa-file-invoice\"></i> $invoiceid</a>";
if (!compareinvoicetrans($invoiceid, $transid)) {
echo " <i class=\"fa fa-warning colormered\"></i>";
}
}
echo "</td>";

echo "<td>$transdesc</td>";

$rs_find_transdet = "SELECT SUM(income) AS income, SUM(expense) AS expense FROM glstransdet WHERE transid = '$transid' AND payee = '$payee'";
$rs_result_transdet = mysqli_query($rs_connect,$rs_find_transdet);
$rs_result_transdetq = mysqli_fetch_object($rs_result_transdet);
$income = "$rs_result_transdetq->income";
$expense = "$rs_result_transdetq->expense" * -1;

$linebalance = $income + $expense;

if($expense != 0) {
echo "<td>$money".mfie("$expense")."</td>";
} else {
echo "<td>-</td>";
}
if($income != 0) {
echo "<td>$money".mfie("$income")."</td>";
} else {
echo "<td>-</td>";
}



echo "<td>$money".mfie("$linebalance")."</td>";

$etotal = $etotal + $expense;
$itotal = $itotal + $income;
$ctotal = $ctotal + $linebalance;

}

echo "<tr style=\"border-top: #333333 2px solid\"><td></td><td></td><td></td><td>$".mfie($etotal)."</td><td>$".mfie($itotal)."</td><td>$".mfie("$ctotal")."</td>";
echo "";

echo "</table>";



####



if(!isset($_REQUEST['printable'])) {
stop_box();
}

if(!isset($_REQUEST['printable'])) {
require("footer.php");
} else {
printablefooter();
}

}




#################################################################################################################################

function year_report() {

require_once("deps.php");
require_once("common.php");
perm_boot("5");

if (array_key_exists('year',$_REQUEST)) {
if ($_REQUEST['year'] != "") {
$year = $_REQUEST['year'];
} else {
$year = date("Y");
}
} else {
$year = date("Y");
}



if(!isset($_REQUEST['printable'])) {
require_once("header.php");
} else {
printableheadernw(pcrtlang("Year Report for")." $year");
}


$reportstoreid = $_REQUEST['reportstoreid'];
                                                                                                                                           
if(!isset($_REQUEST['printable'])) {
start_box();
}

echo "<table width=100%><tr><td width=50% align=left>";
echo "<span class=sizemelarger>".pcrtlang("Yearly Report for")." $year</span><br><br>";

if ($activestorecount > 1) {
if ("$reportstoreid" == "all") {
echo "<span class=sizemelarge>".pcrtlang("Store: All Stores")."</span><br><br>";
} else {
$storeinfoarray = getstoreinfo($reportstoreid);
echo "<span class=sizemelarge>".pcrtlang("Store").": $storeinfoarray[storesname]</span><br><br>";
}
}


echo "</td><td width=50% align=right>";
if(!isset($_REQUEST['printable'])) {
echo "<a href=reports.php?func=year_report&year=$year&printable=yes&reportstoreid=$reportstoreid class=linkbutton><img src=images/print.png border=0 align=absmiddle> ".pcrtlang("Printable")."</a>";


echo "<br><a href=reports.php?func=year_report_csv&year=$year&reportstoreid=$reportstoreid class=linkbutton><img src=images/csv.png border=0 align=absmiddle> ".pcrtlang("CSV")."</a>";
}
echo "</td></tr></table>";




echo "<table class=\"bigstandard lastalignright\">";

echo "<tr><th colspan=2>$year</th></tr>";

if ("$reportstoreid" == "all") {
$rs_find_cart_pur = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='purchase' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_pur = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='purchase' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_pur = mysqli_query($rs_connect, $rs_find_cart_pur);
while($rs_result_pur_q = mysqli_fetch_object($rs_result_pur)) {
$rs_purtotal = "$rs_result_pur_q->total";
echo "<tr><td>".pcrtlang("Total Purchases").":</td><td>$money".mf("$rs_purtotal")."</td></tr>";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_lab = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='labor' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_lab = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='labor' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_lab = mysqli_query($rs_connect, $rs_find_cart_lab);
while($rs_result_lab_q = mysqli_fetch_object($rs_result_lab)) {
$rs_labtotal = "$rs_result_lab_q->total";
echo "<tr><td>".pcrtlang("Total Labor").":</td><td>$money".mf("$rs_labtotal")."</td></tr>";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_ref = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='refund' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_ref = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='refund' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_ref = mysqli_query($rs_connect, $rs_find_cart_ref);
while($rs_result_ref_q = mysqli_fetch_object($rs_result_ref)) {
$rs_reftotal = "$rs_result_ref_q->total";
echo "<tr><td>".pcrtlang("Total Sales Refunds").":</td><td>$money".mf("$rs_reftotal")."</td></tr>";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_labr = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='refundlabor' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_labr = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='refundlabor' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_labr = mysqli_query($rs_connect, $rs_find_cart_labr);
while($rs_result_labr_q = mysqli_fetch_object($rs_result_labr)) {
$rs_labtotalr = "$rs_result_labr_q->total";
echo "<tr><td>".pcrtlang("Total Refunded Labor").":</td><td>$money".mf("$rs_labtotalr")."</td></tr>";
}



if ("$reportstoreid" == "all") {
$rs_find_cart_refx = "SELECT SUM(itemtax) AS total FROM sold_items WHERE YEAR(date_sold) = '$year' AND sold_type != 'refund' AND sold_type != 'refundlabor'";
} else {
$rs_find_cart_refx = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts WHERE YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.sold_type != 'refund' AND sold_items.sold_type != 'refundlabor'";
}
$rs_result_refx = mysqli_query($rs_connect, $rs_find_cart_refx);
while($rs_result_ref_qx = mysqli_fetch_object($rs_result_refx)) {
$rs_totaltax = "$rs_result_ref_qx->total";
echo "<tr><td>".pcrtlang("Sales/Service Tax Collected").":</td><td>$money".mf("$rs_totaltax")."</td></tr>";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_refxr = "SELECT SUM(itemtax) AS total FROM sold_items WHERE YEAR(date_sold) = '$year' AND (sold_type = 'refund' OR sold_type = 'refundlabor')";
} else {
$rs_find_cart_refxr = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts WHERE YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id  AND (sold_items.sold_type = 'refund' OR sold_items.sold_type = 'refundlabor')";
}
$rs_result_refxr = mysqli_query($rs_connect, $rs_find_cart_refxr);
while($rs_result_ref_qxr = mysqli_fetch_object($rs_result_refxr)) {
$rs_totaltaxr = "$rs_result_ref_qxr->total";
echo "<tr><td>".pcrtlang("Refunded Sales/Service Tax").":</td><td>$money".mf("$rs_totaltaxr")."</td></tr>";
}



$totalgross = ((tnv($rs_purtotal) + tnv($rs_labtotal) + tnv($rs_totaltax)) - (tnv($rs_reftotal) + tnv($rs_totaltaxr) + tnv($rs_labtotalr)));
echo "<tr><td>".pcrtlang("Gross Total").":</td><td>$money".mf("$totalgross")."</td></tr>";

if ("$reportstoreid" == "all") {
$rs_find_op = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_op = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE sold_items.sold_type='purchase' AND YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$reportstoreid'";
}
$rs_result_op = mysqli_query($rs_connect, $rs_find_op);
$rs_result_op_q = mysqli_fetch_object($rs_result_op);
$rs_totalop = "$rs_result_op_q->ourprice";
$rs_totalsp = "$rs_result_op_q->soldprice";
if ("$reportstoreid" == "all") {
$rs_find_opr = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_opr = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$reportstoreid'";
}

$rs_result_opr = mysqli_query($rs_connect, $rs_find_opr);
$rs_result_opr_q = mysqli_fetch_object($rs_result_opr);
$rs_totalopr = "$rs_result_opr_q->ourprice";
$rs_totalspr = "$rs_result_opr_q->soldprice";


$rs_totalnet = ((tnv($rs_totalsp) - tnv($rs_totalspr)) - (tnv($rs_totalop) - tnv($rs_totalopr)));

$totalnet = abs($rs_totalnet);

if ($rs_totalnet > 0) {
echo "<tr><td>".pcrtlang("Estimated Net Sales").":</td><td>$money".mf("$totalnet")."</td></tr>";
} else {
echo "<tr><td>".pcrtlang("Estimated Net Sales").":</td><td><span class=colormered> $money".mf("$totalnet")."</span></td></tr>";
}


$rs_cogs = (tnv($rs_totalop) - tnv($rs_totalopr));
$totalcogs = abs($rs_cogs);

if ($rs_cogs > 0) {
echo "<tr><td>".pcrtlang("Cost of Goods Sold").":</td><td>$money".mf("$totalcogs")."</td></tr>";
} else {
echo "<tr><td>".pcrtlang("Cost of Goods Sold").":</td><td><span class=colormered>$money".mf("$totalcogs")."</span></td></tr>";
}


$profit = (tnv($rs_totalnet) + tnv($rs_labtotal)) - tnv($rs_labtotalr);
$profitabs = abs("$profit");

if ($profit > 0) {
echo "<tr><td>".pcrtlang("Net Income").":</td><td>$money".mf("$profitabs")."</td></tr>";
} else {
echo "<tr><td>".pcrtlang("Net Income").":</td><td><span class=colormered>$money".mf("$profitabs")."</span></td></tr>";
}


echo "</table>";


if(!isset($_REQUEST['printable'])) {
stop_box();
}
                                                                                                                                   
if(!isset($_REQUEST['printable'])) {
require("footer.php");
} else {
printablefooter();
}


}



function year_report_csv() {

if (array_key_exists('year',$_REQUEST)) {
if ($_REQUEST['year'] != "") {
$year = $_REQUEST['year'];
} else {
$year = date("Y");
}
} else {
$year = date("Y");
}

$reportstoreid = $_REQUEST['reportstoreid'];

require_once("common.php");
                                                                                                                                           
require("deps.php");

perm_boot("5");


$csv =  "\"".pcrtlang("Yearly Report for")." $year\"\n";

if ($activestorecount > 1) {
if ("$reportstoreid" == "all") {
$csv .= "\"".pcrtlang("Store: All Stores")."\"\n";
} else {
$storeinfoarray = getstoreinfo($reportstoreid);
$csv .= "\"Store: $storeinfoarray[storesname]\"\n";
}
}






if ("$reportstoreid" == "all") {
$rs_find_cart_pur = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='purchase' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_pur = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='purchase' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_pur = mysqli_query($rs_connect, $rs_find_cart_pur);
while($rs_result_pur_q = mysqli_fetch_object($rs_result_pur)) {
$rs_purtotal = "$rs_result_pur_q->total";
$csv .= "\"".pcrtlang("Total Purchases").":\",\"".mf("$rs_purtotal")."\"\n";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_lab = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='labor' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_lab = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='labor' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_lab = mysqli_query($rs_connect, $rs_find_cart_lab);
while($rs_result_lab_q = mysqli_fetch_object($rs_result_lab)) {
$rs_labtotal = "$rs_result_lab_q->total";
$csv .= "\"".pcrtlang("Total Labor").":\",\"$rs_labtotal\"\n";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_ref = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='refund' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_ref = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='refund' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_ref = mysqli_query($rs_connect, $rs_find_cart_ref);
while($rs_result_ref_q = mysqli_fetch_object($rs_result_ref)) {
$rs_reftotal = "$rs_result_ref_q->total";
$csv .= "\"".pcrtlang("Total Sales Refunds").":\",\"$rs_reftotal\"\n";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_labr = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='refundlabor' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_labr = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='refundlabor' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_labr = mysqli_query($rs_connect, $rs_find_cart_labr);
while($rs_result_labr_q = mysqli_fetch_object($rs_result_labr)) {
$rs_labtotalr = "$rs_result_labr_q->total";
$csv .= "\"".pcrtlang("Total Refunded Labor").":\",\"$rs_labtotalr\"\n";
}



if ("$reportstoreid" == "all") {
$rs_find_cart_refx = "SELECT SUM(itemtax) AS total FROM sold_items WHERE YEAR(date_sold) = '$year' AND sold_type != 'refund' AND sold_type != 'refundlabor'";
} else {
$rs_find_cart_refx = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts WHERE YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type != 'refund' AND sold_type != 'refundlabor' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_refx = mysqli_query($rs_connect, $rs_find_cart_refx);
while($rs_result_ref_qx = mysqli_fetch_object($rs_result_refx)) {
$rs_totaltax = "$rs_result_ref_qx->total";
$csv .= "\"".pcrtlang("Sales/Service Tax Collected").":\",\"$rs_totaltax\"\n";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_refxr = "SELECT SUM(itemtax) AS total FROM sold_items WHERE YEAR(date_sold) = '$year' AND sold_type = 'refund' AND sold_type = 'refundlabor'";
} else {
$rs_find_cart_refxr = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts WHERE YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id  AND (sold_items.sold_type = 'refund' OR sold_items.sold_type = 'refundlabor')";
}
$rs_result_refxr = mysqli_query($rs_connect, $rs_find_cart_refxr);
while($rs_result_ref_qxr = mysqli_fetch_object($rs_result_refxr)) {
$rs_totaltaxr = "$rs_result_ref_qxr->total";
$csv .= "\"".pcrtlang("Refunded Sales/Service Tax").":\",\"$rs_totaltaxr\"\n";
}



$totalgross = ((tnv($rs_purtotal) + tnv($rs_labtotal) + tnv($rs_totaltax)) - (tnv($rs_reftotal) + tnv($rs_totaltaxr) + tnv($rs_labtotalr)));
$csv .= "\"".pcrtlang("Gross Total").":\",\"$totalgross\"\n";


if ("$reportstoreid" == "all") {
$rs_find_op = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_op = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE sold_items.sold_type='purchase' AND YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$reportstoreid'";
}
$rs_result_op = mysqli_query($rs_connect, $rs_find_op);
$rs_result_op_q = mysqli_fetch_object($rs_result_op);
$rs_totalop = "$rs_result_op_q->ourprice";
$rs_totalsp = "$rs_result_op_q->soldprice";
if ("$reportstoreid" == "all") {
$rs_find_opr = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_opr = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$reportstoreid'";
}

$rs_result_opr = mysqli_query($rs_connect, $rs_find_opr);
$rs_result_opr_q = mysqli_fetch_object($rs_result_opr);
$rs_totalopr = "$rs_result_opr_q->ourprice";
$rs_totalspr = "$rs_result_opr_q->soldprice";


$rs_totalnet = ((tnv($rs_totalsp) - tnv($rs_totalspr)) - (tnv($rs_totalop) - tnv($rs_totalopr)));
$csv .= "\"".pcrtlang("Estimated Net Sales").":\",\"$rs_totalnet\"\n";


$rs_cogs = (tnv($rs_totalop) - tnv($rs_totalopr));
$csv .= "\"".pcrtlang("Cost of Goods Sold").":\",\"$rs_cogs\"\n";



header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"year_report_$year.csv\"");
echo $csv;

}




function quarter_report() {

require("deps.php");
require("common.php");
perm_boot("5");

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}


if (array_key_exists('year',$_REQUEST)) {
if ($_REQUEST['year'] != "") {
$year = $_REQUEST['year'];
} else {
$year = date("Y");
}
} else {
$year = date("Y");
}


if(!isset($_REQUEST['printable'])) {
require_once("header.php");
} else {
printableheadernw(pcrtlang("Quarterly Report for")." $year");
}

$reportstoreid = $_REQUEST['reportstoreid'];

if(!isset($_REQUEST['printable'])) {
start_box();
}

echo "<table width=100%><tr><td width=50% align=left>";
echo "<span class=sizemelarger>".pcrtlang("Quarterly Reports")."</span><br><br>";

if ($activestorecount > 1) {
if ("$reportstoreid" == "all") {
echo "<span sizemelarge>".pcrtlang("Store").": ".pcrtlang("All Stores")."</span><br><br>";
} else {
$storeinfoarray = getstoreinfo($reportstoreid);
echo "<span class=sizemelarge>".pcrtlang("Store").": $storeinfoarray[storesname]</span><br><br>";
}
}


echo "</td><td width=50% align=right>";

if(!isset($_REQUEST['printable'])) {
echo "<a href=reports.php?func=quarter_report&year=$year&printable=yes&reportstoreid=$reportstoreid class=linkbutton><img src=images/print.png border=0 align=absmiddle> ".pcrtlang("Printable")."</a>";
echo "<br><a href=reports.php?func=quarter_report_csv&year=$year&reportstoreid=$reportstoreid class=linkbutton><img src=images/csv.png border=0 align=absmiddle> ".pcrtlang("CSV")."</a>";
}


echo "</td></tr></table>";



echo "<table style=\"width:100%\" class=pad10><tr><td>";

$firstq = 1;

while($firstq <= 4) {

echo "<table class=\"standard lastalignright\">";


echo "<tr><th colspan=2>".pcrtlang("Quarter")." $firstq, $year&nbsp;</th></tr>";



if ("$reportstoreid" == "all") {
$rs_find_cart_pur = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='purchase' AND QUARTER(date_sold) = '$firstq' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_pur = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='purchase' AND QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_pur = mysqli_query($rs_connect, $rs_find_cart_pur);
while($rs_result_pur_q = mysqli_fetch_object($rs_result_pur)) {
$rs_purtotal = "$rs_result_pur_q->total";
echo "<tr><td>".pcrtlang("Total Purchases").":</td><td>$money".mf("$rs_purtotal")."</td></tr>";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_lab = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='labor' AND QUARTER(date_sold) = '$firstq' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_lab = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='labor' AND QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_lab = mysqli_query($rs_connect, $rs_find_cart_lab);
while($rs_result_lab_q = mysqli_fetch_object($rs_result_lab)) {
$rs_labtotal = "$rs_result_lab_q->total";
echo "<tr><td>".pcrtlang("Total Labor").":</td><td>$money".mf("$rs_labtotal")."</td></tr>";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_ref = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='refund' AND QUARTER(date_sold) = '$firstq' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_ref = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='refund' AND QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_ref = mysqli_query($rs_connect, $rs_find_cart_ref);
while($rs_result_ref_q = mysqli_fetch_object($rs_result_ref)) {
$rs_reftotal = "$rs_result_ref_q->total";
echo "<tr><td>".pcrtlang("Total Sales Refunds").":</td><td>$money".mf("$rs_reftotal")."</td></tr>";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_labr = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='refundlabor' AND QUARTER(date_sold) = '$firstq' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_labr = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='refundlabor' AND QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_labr = mysqli_query($rs_connect, $rs_find_cart_labr);
while($rs_result_labr_q = mysqli_fetch_object($rs_result_labr)) {
$rs_labtotalr = "$rs_result_labr_q->total";
echo "<tr><td>".pcrtlang("Total Labor Refunds").":</td><td>$money".mf("$rs_labtotalr")."</td></tr>";
}


if ("$reportstoreid" == "all") {
$rs_find_cart_tax = "SELECT SUM(itemtax) AS total FROM sold_items WHERE QUARTER(date_sold) = '$firstq' AND YEAR(date_sold) = '$year' AND sold_type != 'refund' AND sold_type != 'refundlabor'";
} else {
$rs_find_cart_tax = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts WHERE QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.sold_type != 'refund' AND sold_items.sold_type != 'refundlabor'";
}
$rs_result_tax = mysqli_query($rs_connect, $rs_find_cart_tax);
while($rs_result_tax_q = mysqli_fetch_object($rs_result_tax)) {
$rs_taxtotal = "$rs_result_tax_q->total";
echo "<tr><td>".pcrtlang("Sales/Service Tax").":</td><td>$money".mf("$rs_taxtotal")."</td></tr>";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_taxr = "SELECT SUM(itemtax) AS total FROM sold_items WHERE QUARTER(date_sold) = '$firstq' AND YEAR(date_sold) = '$year' AND (sold_type = 'refund' OR sold_type = 'refundlabor')";
} else {
$rs_find_cart_taxr = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts WHERE QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND (sold_items.sold_type = 'refund' OR sold_items.sold_type = 'refundlabor')";
}
$rs_result_taxr = mysqli_query($rs_connect, $rs_find_cart_taxr);
while($rs_result_tax_qr = mysqli_fetch_object($rs_result_taxr)) {
$rs_taxtotalr = "$rs_result_tax_qr->total";
echo "<tr><td>".pcrtlang("Refunded Sales/Service Tax").":</td><td>$money".mf("$rs_taxtotalr")."</td></tr>";
}



$totalgross = (tnv($rs_purtotal) + tnv($rs_labtotal) + tnv($rs_taxtotal) - (tnv($rs_reftotal) + tnv($rs_taxtotalr) + tnv($rs_labtotalr)));
echo "<tr><td>".pcrtlang("Gross Total").":</td><td>$money".mf("$totalgross")."</td></tr>";

if ("$reportstoreid" == "all") {
$rs_find_op = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_op = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE sold_items.sold_type='purchase' AND QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$reportstoreid'";
}


$rs_result_op = mysqli_query($rs_connect, $rs_find_op);
$rs_result_op_q = mysqli_fetch_object($rs_result_op);
$rs_totalop = "$rs_result_op_q->ourprice";
$rs_totalsp = "$rs_result_op_q->soldprice";
if ("$reportstoreid" == "all") {
$rs_find_opr = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_opr = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$reportstoreid'";
}

$rs_result_opr = mysqli_query($rs_connect, $rs_find_opr);
$rs_result_opr_q = mysqli_fetch_object($rs_result_opr);
$rs_totalopr = "$rs_result_opr_q->ourprice";
$rs_totalspr = "$rs_result_opr_q->soldprice";


$rs_totalnet = ((tnv($rs_totalsp) - tnv($rs_totalspr)) - (tnv($rs_totalop) - tnv($rs_totalopr)));

$totalnet = abs($rs_totalnet);

if ($rs_totalnet > 0) {
echo "<tr><td>".pcrtlang("Estimated Net Sales").":</td><td>$money".mf("$totalnet")."</td></tr>";
} else {
echo "<tr><td>".pcrtlang("Estimated Net Sales").":</td><td><span class=colormered> $money".mf("$totalnet")."</span></td></tr>";
}


$rs_cogs = (tnv($rs_totalop) - tnv($rs_totalopr));
$totalcogs = abs($rs_cogs);

if ($rs_cogs > 0) {
echo "<tr><td>".pcrtlang("Cost of Goods Sold").":</td><td>$money".mf("$totalcogs")."</td></tr>";
} else {
echo "<tr><td>".pcrtlang("Cost of Goods Sold").":</td><td><span class=colormered> $money".mf("$totalcogs")."</span></td></tr>";
}

$profit = (tnv($rs_totalnet) + tnv($rs_labtotal)) - tnv($rs_labtotalr);
$profitabs = abs("$profit");

if ($profit > 0) {
echo "<tr><td>".pcrtlang("Net Income").":</td><td>$money".mf("$profitabs")."</td></tr>";
} else {
echo "<tr><td>".pcrtlang("Net Income").":</td><td><span class=colormered> $money".mf("$profitabs")."</span></td></tr>";
}


echo "</table><br>";

if($firstq == 2) {
echo "</td><td>";
}



$firstq++;
}

echo "</td></tr></table>";

if(!isset($_REQUEST['printable'])) {
stop_box();
}

if(!isset($_REQUEST['printable'])) {
require("footer.php");
} else {
printablefooter();
}

}


function quarter_report_csv() {

if (array_key_exists('year',$_REQUEST)) {
if ($_REQUEST['year'] != "") {
$year = $_REQUEST['year'];
} else {
$year = date("Y");
}
} else {
$year = date("Y");
}

$reportstoreid = $_REQUEST['reportstoreid'];

require_once("common.php");
                                                                                                                                               
require("deps.php");

perm_boot("5");

$csv = "\"".pcrtlang("Quarterly Reports")."\"\n";

if ($activestorecount > 1) {
if ("$reportstoreid" == "all") {
$csv .= "\"".pcrtlang("Store").": ".pcrtlang("All Stores")."\"\n";
} else {
$storeinfoarray = getstoreinfo($reportstoreid);
$csv .= "\"".pcrtlang("Store").": $storeinfoarray[storesname]\"\n";
}
}






$firstq = 1;

while($firstq <= 4) {

$csv .= "\"\"\n";
$csv .= "\"".pcrtlang("Quarter")." $firstq, $year\"\n";


if ("$reportstoreid" == "all") {
$rs_find_cart_pur = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='purchase' AND QUARTER(date_sold) = '$firstq' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_pur = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='purchase' AND QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_pur = mysqli_query($rs_connect, $rs_find_cart_pur);
while($rs_result_pur_q = mysqli_fetch_object($rs_result_pur)) {
$rs_purtotal = "$rs_result_pur_q->total";
$csv .= "\"".pcrtlang("Total Purchases")."\",\"$rs_purtotal\"\n";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_lab = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='labor' AND QUARTER(date_sold) = '$firstq' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_lab = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='labor' AND QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_lab = mysqli_query($rs_connect, $rs_find_cart_lab);
while($rs_result_lab_q = mysqli_fetch_object($rs_result_lab)) {
$rs_labtotal = "$rs_result_lab_q->total";
$csv .= "\"".pcrtlang("Total Labor").":\",\"$rs_labtotal\"\n";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_ref = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='refund' AND QUARTER(date_sold) = '$firstq' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_ref = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='refund' AND QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_ref = mysqli_query($rs_connect, $rs_find_cart_ref);
while($rs_result_ref_q = mysqli_fetch_object($rs_result_ref)) {
$rs_reftotal = "$rs_result_ref_q->total";
$csv .= "\"".pcrtlang("Total Sales Refunds").":\",\"$rs_reftotal\"\n";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_labr = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='refundlabor' AND QUARTER(date_sold) = '$firstq' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_labr = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='refundlabor' AND QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_labr = mysqli_query($rs_connect, $rs_find_cart_labr);
while($rs_result_labr_q = mysqli_fetch_object($rs_result_labr)) {
$rs_labtotalr = "$rs_result_labr_q->total";
$csv .= "\"".pcrtlang("Total Refunded Labor").":\",\"$rs_labtotalr\"\n";
}


if ("$reportstoreid" == "all") {
$rs_find_cart_tax = "SELECT SUM(itemtax) AS total FROM sold_items WHERE QUARTER(date_sold) = '$firstq' AND YEAR(date_sold) = '$year' AND sold_type != 'refund' AND sold_type != 'refundlabor'";
} else {
$rs_find_cart_tax = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts WHERE QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.sold_type != 'refund' AND sold_items.sold_type != 'refundlabor'";
}
$rs_result_tax = mysqli_query($rs_connect, $rs_find_cart_tax);
while($rs_result_tax_q = mysqli_fetch_object($rs_result_tax)) {
$rs_taxtotal = "$rs_result_tax_q->total";
$csv .= "\"".pcrtlang("Sales/Service Tax").":\",\"$rs_taxtotal\"\n";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_taxr = "SELECT SUM(itemtax) AS total FROM sold_items WHERE QUARTER(date_sold) = '$firstq' AND YEAR(date_sold) = '$year' AND (sold_type = 'refund' OR sold_type = 'refundlabor')";
} else {
$rs_find_cart_taxr = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts WHERE QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND (sold_items.sold_type = 'refund' OR sold_items.sold_type = 'refundlabor')";
}
$rs_result_taxr = mysqli_query($rs_connect, $rs_find_cart_taxr);
while($rs_result_tax_qr = mysqli_fetch_object($rs_result_taxr)) {
$rs_taxtotalr = "$rs_result_tax_qr->total";
$csv .= "\"".pcrtlang("Refunded Sales/Service Tax").":\",\"$rs_taxtotalr\"\n";
}



$totalgross = (tnv($rs_purtotal) + tnv($rs_labtotal) + tnv($rs_taxtotal) - (tnv($rs_reftotal) + tnv($rs_taxtotalr) + tnv($rs_labtotalr)));
$csv .= "\"".pcrtlang("Gross Total")."\",\"$totalgross\"\n";

if ("$reportstoreid" == "all") {
$rs_find_op = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_op = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE sold_items.sold_type='purchase' AND QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$reportstoreid'";
}
$rs_result_op = mysqli_query($rs_connect, $rs_find_op);
$rs_result_op_q = mysqli_fetch_object($rs_result_op);
$rs_totalop = "$rs_result_op_q->ourprice";
$rs_totalsp = "$rs_result_op_q->soldprice";
if ("$reportstoreid" == "all") {
$rs_find_opr = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_opr = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE QUARTER(sold_items.date_sold) = '$firstq' AND YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$reportstoreid'";
}

$rs_result_opr = mysqli_query($rs_connect, $rs_find_opr);
$rs_result_opr_q = mysqli_fetch_object($rs_result_opr);
$rs_totalopr = "$rs_result_opr_q->ourprice";
$rs_totalspr = "$rs_result_opr_q->soldprice";


$rs_totalnet = ((tnv($rs_totalsp) - tnv($rs_totalspr)) - (tnv($rs_totalop) - tnv($rs_totalopr)));
$csv .= "\"".pcrtlang("Estimate Net Sales")."\",\"$rs_totalnet\"\n";


$rs_cogs = (tnv($rs_totalop) - tnv($rs_totalopr));
$csv .= "\"".pcrtlang("Cost of Goods Sold")."\",\"$rs_cogs\"\n";








$firstq++;
}

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"quarter_report_$year.csv\"");
echo $csv;

}



function month_report() {

require("deps.php");
require("common.php");

perm_boot("5");
                      
if (array_key_exists('year',$_REQUEST)) {
if ($_REQUEST['year'] != "") {
$year = $_REQUEST['year'];
} else {
$year = date("Y");
}
} else {
$year = date("Y");
}


$year2 = $year - 1;

$reportstoreid = $_REQUEST['reportstoreid'];
         
if(!isset($_REQUEST['printable'])) {
require_once("header.php");
} else {
printableheader(pcrtlang("Monthly Report for")." $year");
}


if(!isset($_REQUEST['printable'])) {         
start_box();
}

echo "<table width=100%><tr><td width=50% align=left>";
echo "<span class=sizemelarger>".pcrtlang("Monthly Reports")."</span><br><br>";

if ($activestorecount > 1) {
if ("$reportstoreid" == "all") {
echo "<span class=sizemelarge>".pcrtlang("Store").": ".pcrtlang("All Stores")."</span><br><br>";
} else {
$storeinfoarray = getstoreinfo($reportstoreid);
echo "<span class=sizemelarge>".pcrtlang("Store").": $storeinfoarray[storesname]</span><br><br>";
}
}


echo "</td><td width=50% align=right>";     

if(!isset($_REQUEST['printable'])) {
echo "<a href=reports.php?func=month_report&year=$year&printable=yes&reportstoreid=$reportstoreid class=linkbutton><img src=images/print.png border=0 align=absmiddle> ".pcrtlang("Printable")."</a>";
echo "<br><a href=reports.php?func=month_report_csv&year=$year&reportstoreid=$reportstoreid class=linkbutton><img src=images/csv.png border=0 align=absmiddle> ".pcrtlang("CSV")."</a>";
}

echo "</td></tr></table>";

$m = 1;
       
$chartlabor = array();
$chartpurchases = array();
$chartprofit = array();

$chartlabor2 = array();
$chartpurchases2 = array();
$chartprofit2 = array();


?>
<span class=sizemelarger><?php echo pcrtlang("Monthly Totals"); ?></span><br><br>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.2/Chart.bundle.min.js"></script>
<canvas id="myLineChart" width="700" height="400"></canvas><br><br>
<span class=sizemelarger><?php echo pcrtlang("Cumulative Totals"); ?></span><br><br>
<canvas id="myLineChart2" width="700" height="400"></canvas>
<?php

echo "<table style=\"width:100%\"><tr><td style=\"padding:20px;\">";

while($m < 13) {


echo "<table class=standard><tr><th colspan=2>";


if ($m == 1) {
echo pcrtlang("January");
} elseif ($m == 2) {
echo pcrtlang("February");
} elseif ($m == 3) {
echo pcrtlang("March");
} elseif ($m == 4) {
echo pcrtlang("April");
} elseif ($m == 5) {
echo pcrtlang("May");
} elseif ($m == 6) {
echo pcrtlang("June");
} elseif ($m == 7) {
echo pcrtlang("July");
} elseif ($m == 8) {
echo pcrtlang("August");
} elseif ($m == 9) {
echo pcrtlang("September");
} elseif ($m == 10) {
echo pcrtlang("October");
} elseif ($m == 11) {
echo pcrtlang("November");
} else {
echo pcrtlang("December");
}




echo "</th></tr>";
                                                                                                                                                                                                         

if ("$reportstoreid" == "all") {
$rs_find_cart_pur = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='purchase' AND MONTH(date_sold) = '$m' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_pur = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='purchase' AND MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_pur = mysqli_query($rs_connect, $rs_find_cart_pur);
$rs_result_pur_q = mysqli_fetch_object($rs_result_pur);
$rs_purtotal = "$rs_result_pur_q->total";
echo "<tr><td>".pcrtlang("Total Purchases").":</td><td class=textalignright> $money".mf("$rs_purtotal")."</td></tr>";

if ("$reportstoreid" == "all") {
$rs_find_cart_pur2 = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='purchase' AND MONTH(date_sold) = '$m' AND YEAR(date_sold) = '$year2'";
} else {
$rs_find_cart_pur2 = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='purchase' AND MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year2' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_pur2 = mysqli_query($rs_connect, $rs_find_cart_pur2);
$rs_result_pur_q2 = mysqli_fetch_object($rs_result_pur2);
$rs_purtotal2 = "$rs_result_pur_q2->total";



if ("$reportstoreid" == "all") {
$rs_find_cart_lab = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='labor' AND MONTH(date_sold) = '$m' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_lab = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='labor' AND MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_lab = mysqli_query($rs_connect, $rs_find_cart_lab);
$rs_result_lab_q = mysqli_fetch_object($rs_result_lab);
$rs_labtotal = "$rs_result_lab_q->total";
echo "<tr><td>".pcrtlang("Total Labor").":</td><td class=textalignright>$money".mf("$rs_labtotal")."</td></tr>";

if ("$reportstoreid" == "all") {
$rs_find_cart_lab2 = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='labor' AND MONTH(date_sold) = '$m' AND YEAR(date_sold) = '$year2'";
} else {
$rs_find_cart_lab2 = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='labor' AND MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year2' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_lab2 = mysqli_query($rs_connect, $rs_find_cart_lab2);
$rs_result_lab_q2 = mysqli_fetch_object($rs_result_lab2);
$rs_labtotal2 = "$rs_result_lab_q2->total";



if ("$reportstoreid" == "all") {
$rs_find_cart_ref = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='refund' AND MONTH(date_sold) = '$m' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_ref = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='refund' AND MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_ref = mysqli_query($rs_connect, $rs_find_cart_ref);
$rs_result_ref_q = mysqli_fetch_object($rs_result_ref);
$rs_reftotal = "$rs_result_ref_q->total";
echo "<tr><td>".pcrtlang("Total Sales Refunds").":</td><td class=textalignright> $money".mf("$rs_reftotal")."</td></tr>";

if ("$reportstoreid" == "all") {
$rs_find_cart_ref2 = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='refund' AND MONTH(date_sold) = '$m' AND YEAR(date_sold) = '$year2'";
} else {
$rs_find_cart_ref2 = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='refund' AND MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year2' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_ref2 = mysqli_query($rs_connect, $rs_find_cart_ref2);
$rs_result_ref_q2 = mysqli_fetch_object($rs_result_ref2);
$rs_reftotal2 = "$rs_result_ref_q2->total";



if ("$reportstoreid" == "all") {
$rs_find_cart_refl = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='refundlabor' AND MONTH(date_sold) = '$m' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_refl = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='refundlabor' AND MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_refl = mysqli_query($rs_connect, $rs_find_cart_refl);
$rs_result_ref_ql = mysqli_fetch_object($rs_result_refl);
$rs_reftotall = "$rs_result_ref_ql->total";
echo "<tr><td>".pcrtlang("Total Labor Refunds").":</td><td class=textalignright>$money".mf("$rs_reftotall")."</td></tr>";

if ("$reportstoreid" == "all") {
$rs_find_cart_refl2 = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='refundlabor' AND MONTH(date_sold) = '$m' AND YEAR(date_sold) = '$year2'";
} else {
$rs_find_cart_refl2 = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='refundlabor' AND MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year2' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_refl2 = mysqli_query($rs_connect, $rs_find_cart_refl2);
$rs_result_ref_ql2 = mysqli_fetch_object($rs_result_refl2);
$rs_reftotall2 = "$rs_result_ref_ql2->total";




$chartpurchases[] = mf(tnv($rs_purtotal) - tnv($rs_reftotal));
$chartlabor[] = mf(tnv($rs_labtotal) - tnv($rs_reftotall));

$chartpurchases2[] = mf(tnv($rs_purtotal2) - tnv($rs_reftotal2));
$chartlabor2[] = mf(tnv($rs_labtotal2) - tnv($rs_reftotall2));





if ("$reportstoreid" == "all") {
$rs_find_cart_taxx = "SELECT SUM(itemtax) AS total FROM sold_items WHERE MONTH(date_sold) = '$m' AND YEAR(date_sold) = '$year' AND sold_type != 'refund'
 AND sold_type != 'refundlabor'";
} else {
$rs_find_cart_taxx = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts WHERE MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.sold_type != 'refund' AND sold_items.sold_type != 'refundlabor'";
}
$rs_result_taxx = mysqli_query($rs_connect, $rs_find_cart_taxx);
$rs_result_tax_qx = mysqli_fetch_object($rs_result_taxx);
$rs_taxtotalx = "$rs_result_tax_qx->total";
echo "<tr><td>".pcrtlang("Sales/Service Tax").":</td><td class=textalignright>$money".mf("$rs_taxtotalx")."</td></tr>";

if ("$reportstoreid" == "all") {
$rs_find_cart_taxx2 = "SELECT SUM(itemtax) AS total FROM sold_items WHERE MONTH(date_sold) = '$m' AND YEAR(date_sold) = '$year2' AND sold_type != 'refund' AND sold_type != 'refundlabor'";
} else {
$rs_find_cart_taxx2 = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts WHERE MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year2' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.sold_type != 'refund' AND sold_items.sold_type != 'refundlabor'";
}
$rs_result_taxx2 = mysqli_query($rs_connect, $rs_find_cart_taxx2);
$rs_result_tax_qx2 = mysqli_fetch_object($rs_result_taxx2);
$rs_taxtotalx2 = "$rs_result_tax_qx2->total";




if ("$reportstoreid" == "all") {
$rs_find_cart_taxxr = "SELECT SUM(itemtax) AS total FROM sold_items WHERE MONTH(date_sold) = '$m' AND YEAR(date_sold) = '$year' AND (sold_type = 'refund' OR sold_type = 'refundlabor')";
} else {
$rs_find_cart_taxxr = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts WHERE MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND (sold_items.sold_type = 'refund' OR sold_items.sold_type = 'refundlabor')";
}
$rs_result_taxxr = mysqli_query($rs_connect, $rs_find_cart_taxxr);
$rs_result_tax_qxr = mysqli_fetch_object($rs_result_taxxr);
$rs_taxtotalxr = "$rs_result_tax_qxr->total";
echo "<tr><td>".pcrtlang("Refunded Sales/Service Tax").":</td><td class=textalignright>$money".mf("$rs_taxtotalxr")."</td></tr>";

if ("$reportstoreid" == "all") {
$rs_find_cart_taxxr2 = "SELECT SUM(itemtax) AS total FROM sold_items WHERE MONTH(date_sold) = '$m' AND YEAR(date_sold) = '$year2' AND (sold_type = 'refund' OR sold_type = 'refundlabor')";
} else {
$rs_find_cart_taxxr2 = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts WHERE MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold)= '$year2' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND (sold_items.sold_type = 'refund' OR sold_items.sold_type = 'refundlabor')";
}
$rs_result_taxxr2 = mysqli_query($rs_connect, $rs_find_cart_taxxr2);
$rs_result_tax_qxr2 = mysqli_fetch_object($rs_result_taxxr2);
$rs_taxtotalxr2 = "$rs_result_tax_qxr2->total";




$totalgross = ((tnv($rs_purtotal)  + tnv($rs_labtotal) + tnv($rs_taxtotalx)) - (tnv($rs_taxtotalxr) + tnv($rs_reftotal) + tnv($rs_reftotall)));
echo "<tr><td>".pcrtlang("Gross Total").":</td><td class=textalignright>$money".mf("$totalgross")."</td></tr>";

$chartgrosstotal[] = mf($totalgross);

$totalgross2 = ((tnv($rs_purtotal2)  + tnv($rs_labtotal2) + tnv($rs_taxtotalx2)) - (tnv($rs_taxtotalxr2) + tnv($rs_reftotal2) + tnv($rs_reftotall2)));
$chartgrosstotal2[] = mf($totalgross2);

###

if ("$reportstoreid" == "all") {
$rs_find_op = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_op = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE sold_items.sold_type='purchase' AND MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$reportstoreid'";
}
$rs_result_op = mysqli_query($rs_connect, $rs_find_op);
$rs_result_op_q = mysqli_fetch_object($rs_result_op);
$rs_totalop = "$rs_result_op_q->ourprice";
$rs_totalsp = "$rs_result_op_q->soldprice";

if ("$reportstoreid" == "all") {
$rs_find_op2 = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year2' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_op2 = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE sold_items.sold_type='purchase' AND MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year2' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$reportstoreid'";
}
$rs_result_op2 = mysqli_query($rs_connect, $rs_find_op2);
$rs_result_op_q2 = mysqli_fetch_object($rs_result_op2);
$rs_totalop2 = "$rs_result_op_q2->ourprice";
$rs_totalsp2 = "$rs_result_op_q2->soldprice";




if ("$reportstoreid" == "all") {
$rs_find_opr = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_opr = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$reportstoreid'";
}

$rs_result_opr = mysqli_query($rs_connect, $rs_find_opr);
$rs_result_opr_q = mysqli_fetch_object($rs_result_opr);
$rs_totalopr = "$rs_result_opr_q->ourprice";
$rs_totalspr = "$rs_result_opr_q->soldprice";

if ("$reportstoreid" == "all") {
$rs_find_opr2 = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year2' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_opr2 = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year2' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$reportstoreid'";
}

$rs_result_opr2 = mysqli_query($rs_connect, $rs_find_opr2);
$rs_result_opr_q2 = mysqli_fetch_object($rs_result_opr2);
$rs_totalopr2 = "$rs_result_opr_q2->ourprice";
$rs_totalspr2 = "$rs_result_opr_q2->soldprice";



$rs_totalnet = ((tnv($rs_totalsp) - tnv($rs_totalspr)) - (tnv($rs_totalop) - tnv($rs_totalopr)));
$totalnet = abs($rs_totalnet);

$rs_totalnet2 = ((tnv($rs_totalsp2) - tnv($rs_totalspr2)) - (tnv($rs_totalop2) - tnv($rs_totalopr2)));
$totalnet2 = abs($rs_totalnet2);



if ($rs_totalnet > 0) {
echo "<tr><td>".pcrtlang("Estimated Net Sales").":</td><td class=textalignright>$money".mf("$totalnet")."</td></tr>";
} else {
echo "<tr><td>".pcrtlang("Estimated Net Sales").":</td><td class=textalignright><span class=colormered> $money".mf("$totalnet")."</span></td></tr>";
}

$chartprofit[] = mf((tnv($rs_labtotal) - tnv($rs_reftotall)) + tnv($rs_totalnet)); 
$profit = mf((tnv($rs_labtotal) - tnv($rs_reftotall)) + tnv($rs_totalnet));
$profitabs = abs(mf((tnv($rs_labtotal) - tnv($rs_reftotall)) + tnv($rs_totalnet)));
$rs_cogs = (tnv($rs_totalop) - tnv($rs_totalopr));
$totalcogs = abs($rs_cogs);
$chartcogs[] = mf($rs_cogs);

$chartprofit2[] = mf((tnv($rs_labtotal2) - tnv($rs_reftotall2)) + tnv($rs_totalnet2));
$profit2 = mf((tnv($rs_labtotal2) - tnv($rs_reftotall2)) + tnv($rs_totalnet2));
$profitabs2 = abs(mf((tnv($rs_labtotal2) - tnv($rs_reftotall2)) + tnv($rs_totalnet2)));
$rs_cogs2 = (tnv($rs_totalop2) - tnv($rs_totalopr2));
$totalcogs2 = abs($rs_cogs2);
$chartcogs2[] = mf($rs_cogs2);




if ($rs_cogs > 0) {
echo "<tr><td>".pcrtlang("Cost of Goods Sold").":</td><td class=textalignright>$money".mf("$totalcogs")."</td></tr>";
} else {
echo "<tr><td>".pcrtlang("Cost of Goods Sold").":</td><td class=textalignright><span class=colormered> $money".mf("$totalcogs")."</span></td></tr>";
}


if ($profit > 0) {
echo "<tr><td>".pcrtlang("Net Income").":</td><td class=textalignright>$money".mf("$profitabs")."</td></tr>";
} else {
echo "<tr><td>".pcrtlang("Net Income").":</td><td class=textalignright><span class=colormered> $money".mf("$profitabs")."</span></td></tr>";
}


echo "</table><br>";

if($m == 6) {
echo "</td><td style=\"padding:20px;\">";
}

$m++;
}

echo "</td></tr></table>";

###

$chartlaborjson = json_encode($chartlabor);
$chartpurchasesjson = json_encode($chartpurchases);
$chartprofitjson = json_encode($chartprofit);
$chartcogsjson = json_encode($chartcogs);
$chartgrosstotaljson = json_encode($chartgrosstotal);
$months = "[\"".pcrtlang("January")."\", \"".pcrtlang("February")."\", \"".pcrtlang("March")."\", \"".pcrtlang("April")."\", \"".pcrtlang("May")."\", \"".pcrtlang("June")."\", \"".pcrtlang("July")."\", \"".pcrtlang("August")."\", \"".pcrtlang("September")."\", \"".pcrtlang("October")."\", \"".pcrtlang("November")."\", \"".pcrtlang("December")."\"]";

$chartlaborjson2 = json_encode($chartlabor2);
$chartpurchasesjson2 = json_encode($chartpurchases2);
$chartprofitjson2 = json_encode($chartprofit2);
$chartcogsjson2 = json_encode($chartcogs2);
$chartgrosstotaljson2 = json_encode($chartgrosstotal2);



?>

<script>

var data = {
    labels:  <?php echo $months; ?>,
    datasets: [
        {
            label: "<?php echo pcrtlang("Labor"); ?>",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(75,0,192,0.4)",
            borderColor: "rgba(75,0,192,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php echo $chartlaborjson; ?>,
            spanGaps: false,
        },
	{
            label: "<?php echo pcrtlang("Gross Sales") ?>",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(75,192,192,0.4)",
            borderColor: "rgba(75,192,192,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php echo $chartpurchasesjson; ?>,
            spanGaps: false,
        },
       {
            label: "<?php echo pcrtlang("Profit") ?>",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(75,192,0,0.4)",
            borderColor: "rgba(75,192,0,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php echo $chartprofitjson; ?>,
            spanGaps: false,
        },
       {
            label: "<?php echo pcrtlang("Cost of Goods") ?>",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(255,89,89,0.4)",
            borderColor: "rgba(255,89,89,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php echo $chartcogsjson; ?>,
            spanGaps: false,
        },
       {
            label: "<?php echo pcrtlang("Total Gross") ?>",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(0,0,0,0.4)",
            borderColor: "rgba(0,0,0,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php echo $chartgrosstotaljson; ?>,
            spanGaps: false,
        },
        {
            label: "<?php echo pcrtlang("Labor")." $year2"; ?>",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(75,0,192,0.4)",
            borderColor: "rgba(75,0,192,0.4)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php echo $chartlaborjson2; ?>,
            spanGaps: false,
	    hidden: true,
        },
        {
            label: "<?php echo pcrtlang("Gross Sales")." $year2" ?>",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(75,192,192,0.4)",
            borderColor: "rgba(75,192,192,0.4)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php echo $chartpurchasesjson2; ?>,
            spanGaps: false,
	    hidden: true,
        },
       {
            label: "<?php echo pcrtlang("Profit")." $year2" ?>",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(75,192,0,0.4)",
            borderColor: "rgba(73,124,38,0.4)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php echo $chartprofitjson2; ?>,
            spanGaps: false,
	    hidden: true,
        },
       {
            label: "<?php echo pcrtlang("Cost of Goods")." $year2" ?>",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(255,89,89,0.4)",
            borderColor: "rgba(255,89,89,0.4)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php echo $chartcogsjson2; ?>,
            spanGaps: false,
	    hidden: true,
        },
       {
            label: "<?php echo pcrtlang("Total Gross")." $year2" ?>",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(0,0,0,0.4)",
            borderColor: "rgba(0,0,0,0.4)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php echo $chartgrosstotaljson2; ?>,
            spanGaps: false,
	    hidden: true,
        }

    ]
};

var ctx = document.getElementById("myLineChart");
var myLineChart = new Chart(ctx, {
    type: 'line',
    data: data,
 options: {
        responsive: false
    }
});

</script>
<?php

reset($chartlabor);
reset($chartpurchases);
reset($chartprofit);
reset($chartcogs);
reset($chartgrosstotal);

reset($chartlabor2);
reset($chartpurchases2);
reset($chartprofit2);
reset($chartcogs2);
reset($chartgrosstotal2);


$newval = 0;
foreach($chartlabor as $key => $val) {
$newval = $newval + $val;
$chartlaborc[] = $newval;
}

$newval = 0;
foreach($chartpurchases as $key => $val) {
$newval = $newval + $val;
$chartpurchasesc[] = $newval;
}

$newval = 0;
foreach($chartprofit as $key => $val) {
$newval = $newval + $val;
$chartprofitc[] = $newval;
}

$newval = 0;
foreach($chartcogs as $key => $val) {
$newval = $newval + $val;
$chartcogsc[] = $newval;
}

$newval = 0;
foreach($chartgrosstotal as $key => $val) {
$newval = $newval + $val;
$chartgrosstotalc[] = $newval;
}



$chartlaborjsonc = json_encode($chartlaborc);
$chartpurchasesjsonc = json_encode($chartpurchasesc);
$chartprofitjsonc = json_encode($chartprofitc);
$chartcogsjsonc = json_encode($chartcogsc);
$chartgrosstotaljsonc = json_encode($chartgrosstotalc);



$newval = 0;
foreach($chartlabor2 as $key => $val) {
$newval = $newval + $val;
$chartlaborc2[] = $newval;
}

$newval = 0;
foreach($chartpurchases2 as $key => $val) {
$newval = $newval + $val;
$chartpurchasesc2[] = $newval;
}

$newval = 0;
foreach($chartprofit2 as $key => $val) {
$newval = $newval + $val;
$chartprofitc2[] = $newval;
}

$newval = 0;
foreach($chartcogs2 as $key => $val) {
$newval = $newval + $val;
$chartcogsc2[] = $newval;
}
$newval = 0;
foreach($chartgrosstotal2 as $key => $val) {
$newval = $newval + $val;
$chartgrosstotalc2[] = $newval;
}



$chartlaborjsonc2 = json_encode($chartlaborc2);
$chartpurchasesjsonc2 = json_encode($chartpurchasesc2);
$chartprofitjsonc2 = json_encode($chartprofitc2);
$chartcogsjsonc2 = json_encode($chartcogsc2);
$chartgrosstotaljsonc2 = json_encode($chartgrosstotalc2);




?>

<script>

var data2 = {
    labels:  <?php echo $months; ?>,
    datasets: [
        {
            label: "<?php echo pcrtlang("Labor"); ?>",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(75,0,192,0.4)",
            borderColor: "rgba(75,0,192,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php echo $chartlaborjsonc; ?>,
            spanGaps: false,
        },
        {
            label: "<?php echo pcrtlang("Gross Sales") ?>",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(75,192,192,0.4)",
            borderColor: "rgba(75,192,192,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php echo $chartpurchasesjsonc; ?>,
            spanGaps: false,
        },
       {
            label: "<?php echo pcrtlang("Profit") ?>",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(75,192,0,0.4)",
            borderColor: "rgba(75,192,0,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php echo $chartprofitjsonc; ?>,
            spanGaps: false,
        },
       {
            label: "<?php echo pcrtlang("Cost of Goods") ?>",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(255,89,89,0.4)",
            borderColor: "rgba(255,89,89,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php echo $chartcogsjsonc; ?>,
            spanGaps: false,
        },
       {
            label: "<?php echo pcrtlang("Total Gross") ?>",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(0,0,0,0.4)",
            borderColor: "rgba(0,0,0,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php echo $chartgrosstotaljsonc; ?>,
            spanGaps: false,
        },
        {
            label: "<?php echo pcrtlang("Labor")." $year2"; ?>",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(75,0,192,0.4)",
            borderColor: "rgba(75,0,192,0.4)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php echo $chartlaborjsonc2; ?>,
            spanGaps: false,
            hidden: true,
        },
        {
            label: "<?php echo pcrtlang("Gross Sales")." $year2" ?>",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(75,192,192,0.4)",
            borderColor: "rgba(75,192,192,0.4)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php echo $chartpurchasesjsonc2; ?>,
            spanGaps: false,
            hidden: true,
        },
       {
            label: "<?php echo pcrtlang("Profit")." $year2" ?>",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(75,192,0,0.4)",
            borderColor: "rgba(75,192,0,0.4)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php echo $chartprofitjsonc2; ?>,
            spanGaps: false,
            hidden: true,
        },
       {
            label: "<?php echo pcrtlang("Cost of Goods")." $year2" ?>",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(255,89,89,0.4)",
            borderColor: "rgba(255,89,89,0.4)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php echo $chartcogsjsonc2; ?>,
            spanGaps: false,
            hidden: true,
        },
       {
            label: "<?php echo pcrtlang("Total Gross")." $year2" ?>",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(0,0,0,0.4)",
            borderColor: "rgba(0,0,0,0.4)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php echo $chartgrosstotaljsonc2; ?>,
            spanGaps: false,
            hidden: true,
        }



    ]
};

var ctx = document.getElementById("myLineChart2");
var myLineChart2 = new Chart(ctx, {
    type: 'line',
    data: data2,
 options: {
        responsive: false
    }
});
</script>
<?php



if(!isset($_REQUEST['printable'])) {
stop_box();
}

if(!isset($_REQUEST['printable'])) {
require("footer.php");
} else {
printablefooter();
}

}


function month_report_csv() {
                      
if (array_key_exists('year',$_REQUEST)) {
if ($_REQUEST['year'] != "") {
$year = $_REQUEST['year'];
} else {
$year = date("Y");
}
} else {
$year = date("Y");
}

$reportstoreid = $_REQUEST['reportstoreid'];
         
require_once("common.php");

require("deps.php");

perm_boot("5");
         
$csv = "\"".pcrtlang("Monthly Reports")."\"\n";

if ($activestorecount > 1) {
if ("$reportstoreid" == "all") {
$csv .= "\"".pcrtlang("Store").": ".pcrtlang("All Stores")."\"\n";
} else {
$storeinfoarray = getstoreinfo($reportstoreid);
$csv .= "\"".pcrtlang("Store").": $storeinfoarray[storesname]\"\n";
}
}


$m = 1;
       
while($m < 13) {


        
$csv .= "\"\"\n";
                                                                                                                                                                                     

if ($m == 1) {
$csv .= "\"".pcrtlang("January")."\"\n";
} elseif ($m == 2) {
$csv .= "\"".pcrtlang("February")."\"\n";
} elseif ($m == 3) {
$csv .= "\"".pcrtlang("March")."\"\n";
} elseif ($m == 4) {
$csv .= "\"".pcrtlang("April")."\"\n";
} elseif ($m == 5) {
$csv .= "\"".pcrtlang("May")."\"\n";
} elseif ($m == 6) {
$csv .= "\"".pcrtlang("June")."\"\n";
} elseif ($m == 7) {
$csv .= "\"".pcrtlang("July")."\"\n";
} elseif ($m == 8) {
$csv .= "\"".pcrtlang("August")."\"\n";
} elseif ($m == 9) {
$csv .= "\"".pcrtlang("September")."\"\n";
} elseif ($m == 10) {
$csv .= "\"".pcrtlang("October")."\"\n";
} elseif ($m == 11) {
$csv .= "\"".pcrtlang("November")."\"\n";
} else {
$csv .= "\"".pcrtlang("December")."\"\n";
}




                                                                                                                                                                                                         




if ("$reportstoreid" == "all") {
$rs_find_cart_pur = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='purchase' AND MONTH(date_sold) = '$m' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_pur = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='purchase' AND MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_pur = mysqli_query($rs_connect, $rs_find_cart_pur);
while($rs_result_pur_q = mysqli_fetch_object($rs_result_pur)) {
$rs_purtotal = "$rs_result_pur_q->total";
$csv .= "\"".pcrtlang("Total Purchases").":\",\"$rs_purtotal\"\n";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_lab = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='labor' AND MONTH(date_sold) = '$m' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_lab = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='labor' AND MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_lab = mysqli_query($rs_connect, $rs_find_cart_lab);
while($rs_result_lab_q = mysqli_fetch_object($rs_result_lab)) {
$rs_labtotal = "$rs_result_lab_q->total";
$csv .= "\"".pcrtlang("Total Labor").":\",\"$rs_labtotal\"\n";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_ref = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='refund' AND MONTH(date_sold) = '$m' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_ref = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='refund' AND MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_ref = mysqli_query($rs_connect, $rs_find_cart_ref);
while($rs_result_ref_q = mysqli_fetch_object($rs_result_ref)) {
$rs_reftotal = "$rs_result_ref_q->total";
$csv .= "\"".pcrtlang("Total Sales Refunds").":\",\"$rs_reftotal\"\n";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_refl = "SELECT SUM(sold_price) AS total FROM sold_items WHERE sold_type='refundlabor' AND MONTH(date_sold) = '$m' AND YEAR(date_sold) = '$year'";
} else {
$rs_find_cart_refl = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='refundlabor' AND MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id";
}
$rs_result_refl = mysqli_query($rs_connect, $rs_find_cart_refl);
while($rs_result_ref_ql = mysqli_fetch_object($rs_result_refl)) {
$rs_reftotall = "$rs_result_ref_ql->total";
$csv .= "\"".pcrtlang("Total Labor Refunds").":\",\"$rs_reftotall\"\n";
}


if ("$reportstoreid" == "all") {
$rs_find_cart_taxx = "SELECT SUM(itemtax) AS total FROM sold_items WHERE MONTH(date_sold) = '$m' AND YEAR(date_sold) = '$year' AND sold_type != 'refund' AND sold_type != 'refundlabor'";
} else {
$rs_find_cart_taxx = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts WHERE MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id  AND sold_items.sold_type != 'refund'  AND sold_items.sold_type != 'refundlabor'";
}
$rs_result_taxx = mysqli_query($rs_connect, $rs_find_cart_taxx);
while($rs_result_tax_qx = mysqli_fetch_object($rs_result_taxx)) {
$rs_taxtotalx = "$rs_result_tax_qx->total";
$csv .= "\"".pcrtlang("Sales/Service Tax")."\",\"$rs_taxtotalx\"\n";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_taxxr = "SELECT SUM(itemtax) AS total FROM sold_items WHERE MONTH(date_sold) = '$m' AND YEAR(date_sold) = '$year' AND (sold_type = 'refund' OR sold_type = 'refundlabor')";
} else {
$rs_find_cart_taxxr = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts WHERE MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND (sold_items.sold_type = 'refund' OR sold_items.sold_type = 'refundlabor')";
}
$rs_result_taxxr = mysqli_query($rs_connect, $rs_find_cart_taxxr);
while($rs_result_tax_qxr = mysqli_fetch_object($rs_result_taxxr)) {
$rs_taxtotalxr = "$rs_result_tax_qxr->total";
$csv .= "\"".pcrtlang("Refunded Sales/Service Tax")."\",\"$rs_taxtotalxr\"\n";
}




$totalgross = ((tnv($rs_purtotal)  + tnv($rs_labtotal) + tnv($rs_taxtotalx)) - (tnv($rs_taxtotalxr) + tnv($rs_reftotal) + tnv($rs_taxtotalxr)));
$csv .= "\"".pcrtlang("Gross Total").":\",\"$totalgross\"\n";


if ("$reportstoreid" == "all") {
$rs_find_op = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_op = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE sold_items.sold_type='purchase' AND MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$reportstoreid'";
}
$rs_result_op = mysqli_query($rs_connect, $rs_find_op);
$rs_result_op_q = mysqli_fetch_object($rs_result_op);
$rs_totalop = "$rs_result_op_q->ourprice";
$rs_totalsp = "$rs_result_op_q->soldprice";
if ("$reportstoreid" == "all") {
$rs_find_opr = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_opr = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE MONTH(sold_items.date_sold) = '$m' AND YEAR(sold_items.date_sold) = '$year' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$reportstoreid'";
}

$rs_result_opr = mysqli_query($rs_connect, $rs_find_opr);
$rs_result_opr_q = mysqli_fetch_object($rs_result_opr);
$rs_totalopr = "$rs_result_opr_q->ourprice";
$rs_totalspr = "$rs_result_opr_q->soldprice";


$rs_totalnet = ((tnv($rs_totalsp) - tnv($rs_totalspr)) - (tnv($rs_totalop) - tnv($rs_totalopr)));

$csv .= "\"".pcrtlang("Estimated Net Sales").":\",\"".mf("$rs_totalnet")."\"\n";


$rs_cogs = (tnv($rs_totalop) - tnv($rs_totalopr));

$csv .= "\"".pcrtlang("Cost of Goods Sold").":\",\"".mf("$rs_cogs")."\"\n";




$m++;
}

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"month_report_$year.csv\"");
echo $csv;


}





function browse_sold() {

require_once("header.php");

$results_per_page = 40;

if (array_key_exists("pageNumber", $_REQUEST)) {
$pageNumber = $_REQUEST['pageNumber'];
} else {
$pageNumber = 1;
}


if ($pageNumber == "") {
$offset = "0";
} else {
$offset = ($pageNumber * $results_per_page) - $results_per_page;
}



require("deps.php");




$rs_find_cart_items = "SELECT sold_items.sold_id,sold_items.receipt,sold_items.sold_price,sold_items.unit_price,sold_items.stockid,sold_items.sold_type,sold_items.date_sold FROM sold_items,receipts WHERE sold_items.stockid != '0' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$defaultuserstore' ORDER BY date_sold DESC LIMIT $offset,$results_per_page";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

$rs_find_cart_items_total = "SELECT sold_items.sold_id FROM sold_items,receipts WHERE sold_items.stockid != '0' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$defaultuserstore'";
$rs_result_total = mysqli_query($rs_connect, $rs_find_cart_items_total);

if ($activestorecount > 1) {
$storeinfoarray = getstoreinfo($defaultuserstore);
start_blue_box(pcrtlang("Browse Sold Items")." | ".pcrtlang("Store").": $storeinfoarray[storesname]");
} else {
start_blue_box(pcrtlang("Browse Sold Items"));
}

echo "<table class=standard>";
echo "<tr><th>".pcrtlang("Receipt")."</th><th>".pcrtlang("Item Name")."</th><th width=10%>".pcrtlang("Price")."</th><th>".pcrtlang("Sold Date")."</th>";
echo "<th>".pcrtlang("Stock Ct")."</th></tr>";

while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_sold_id = "$rs_result_q->sold_id";
$rs_receipt = "$rs_result_q->receipt";
$rs_sold_price = "$rs_result_q->sold_price";
$rs_stockid = "$rs_result_q->stockid";
$rs_sold_type = "$rs_result_q->sold_type";
$rs_date_sold = "$rs_result_q->date_sold";
$rs_unit_price = "$rs_result_q->unit_price";

$rs_find_stock_name = "SELECT * FROM stock WHERE stock_id = '$rs_stockid'";
$rs_result_stock = mysqli_query($rs_connect, $rs_find_stock_name);
$rs_result_stock_q = mysqli_fetch_object($rs_result_stock);
$rs_partname2 = "$rs_result_stock_q->stock_title";

$rs_find_stock_count = "SELECT * FROM stockcounts WHERE stockid = '$rs_stockid' AND storeid = '$defaultuserstore'";
$rs_result_stockc = mysqli_query($rs_connect, $rs_find_stock_count);
$rs_result_stock_cq = mysqli_fetch_object($rs_result_stockc);
$rs_stockcount = "$rs_result_stock_cq->quantity";


$rs_partname2 = "$rs_result_stock_q->stock_title";

$rs_partname = urlencode("$rs_partname2");

echo "<tr><td><a href=receipt.php?func=show_receipt&receipt=$rs_receipt class=\"linkbuttonsmall linkbuttongray radiusall\">#$rs_receipt</td>";



echo "<td><a href=stock.php?func=show_stock_detail&stockid=$rs_stockid class=\"linkbuttonsmall linkbuttongray radiusall\">$rs_partname2</a> <a href=\"shoplist.php?func=add_item&qty=1&itemdesc=$rs_partname&status=Need%20to%20Order&stockid=$rs_stockid\" class=\"linkbuttonsmall linkbuttongray radiusall floatright\"><i class=\"fa fa-plus\"></i> ".pcrtlang("add to order list")."</a>";


echo "</td>";




echo "<td>$money".mf("$rs_unit_price")."</td>";


$rs_date2 = date("n-j-y", strtotime($rs_date_sold));
echo "<td>$rs_date2</td>";

echo "<td><span class=colormered>$rs_stockcount</span></td>";



echo "</tr>";

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
echo "<a href=reports.php?func=browse_sold&pageNumber=$prevpage class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-left fa-lg\"></i></a>";
}

$total_results = $totalentry;
$results_per_page = $results_per_page;
$html = get_paged_nav($total_results, $results_per_page, false);
echo "$html";

if (($totalentry / $results_per_page) > $pageNumber) {
echo "<a href=reports.php?func=browse_sold&pageNumber=$nextpage class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-right fa-lg\"></i></a>";
}

if(!isset($_REQUEST['printable'])) {
echo "</center>";
stop_box();
}

require("footer.php");

}




function browse_outofstock() {

require_once("header.php");

$results_per_page = 40;

if (array_key_exists("pageNumber", $_REQUEST)) {
$pageNumber = $_REQUEST['pageNumber'];
} else {
$pageNumber = 1;
}


if ($pageNumber == "") {
$offset = "0";
} else {
$offset = ($pageNumber * $results_per_page) - $results_per_page;
}



require("deps.php");




$rs_find_cart_items = "SELECT stock.stock_price,stock.stock_id,stock.stock_title,stockcounts.quantity FROM stock,stockcounts WHERE stock.dis_cont != '1' AND stockcounts.quantity <= '0' AND stockcounts.storeid = '$defaultuserstore' AND stock.stock_id = stockcounts.stockid ORDER BY stock_id DESC LIMIT $offset,$results_per_page";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

$rs_find_cart_items_total = "SELECT stock.stock_price,stock.stock_id,stock.stock_title,stockcounts.quantity FROM stock,stockcounts WHERE stock.dis_cont != '1' AND stockcounts.quantity <= '0' AND stockcounts.storeid = '$defaultuserstore' AND stock.stock_id = stockcounts.stockid";
$rs_result_total = mysqli_query($rs_connect, $rs_find_cart_items_total);

if ($activestorecount > 1) {
$storeinfoarray = getstoreinfo($defaultuserstore);
start_blue_box(pcrtlang("Browse Out of Stock Items")." | ".pcrtlang("Store").": $storeinfoarray[storesname]");
} else {
start_blue_box(pcrtlang("Browse Out of Stock Items"));
}

echo "<table class=standard>";
echo "<tr><th>".pcrtlang("Stock Id")."</th><th>".pcrtlang("Item Name")."</th><th width=10%>".pcrtlang("Price")."</th>";
echo "<th>".pcrtlang("Stock Ct")."</th></tr>";

while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_sold_price = "$rs_result_q->stock_price";
$rs_stockid = "$rs_result_q->stock_id";
$rs_partname2 = "$rs_result_q->stock_title";
$rs_stockcount = "$rs_result_q->quantity";


$rs_partname = urlencode("$rs_partname2");

echo "<tr><td><a href=stock.php?func=show_stock_detail&stockid=$rs_stockid class=\"linkbuttonsmall linkbuttongray radiusall\">#$rs_stockid</td>";

$thestat = urlencode(pcrtlang("Need to Order"));

echo "<td><a href=stock.php?func=show_stock_detail&stockid=$rs_stockid class=\"linkbuttonsmall linkbuttongray radiusall\">$rs_partname2</a> <a href=\"shoplist.php?func=add_item&qty=1&itemdesc=$rs_partname&status=$thestat&stockid=$rs_stockid\" class=\"linkbuttonsmall linkbuttongray radiusall floatright\"><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("add to order list")."</a>";

echo "</td>";


echo "<td>$money".mf("$rs_sold_price")."</td>";


echo "<td><span class=colormered>$rs_stockcount</span></td>";



echo "</tr>";
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
echo "<a href=reports.php?func=browse_outofstock&pageNumber=$prevpage class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-left fa-lg\"></i></a>";
}

$total_results = $totalentry;
$results_per_page = $results_per_page;
$html = get_paged_nav($total_results, $results_per_page, false);
echo "$html";

if (($totalentry / $results_per_page) > $pageNumber) {
echo "<a href=reports.php?func=browse_outofstock&pageNumber=$nextpage class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-right fa-lg\"></i></a>";
}

if(!isset($_REQUEST['printable'])) {
echo "</center>";
stop_box();
}

require("footer.php");

}






function repair_vol() {

require("deps.php");
require("common.php");

if(!isset($_REQUEST['printable'])) {
require_once("header.php");
start_box();
} else {
printableheader(pcrtlang("Repair Volume"));
}


$shift = 0;

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}

$currentdatetime = date('Y-m-d H:i:s');

$today = date('N');

$thefirstday = (time() - (86400 * $today));

$thefirstdaytime = 604799 + strtotime(date('Y-m-d 00:00:00', $thefirstday));

echo "<span class=sizemelarger>".pcrtlang("Repair Volume")."</span><br><br>";

if(!isset($_REQUEST['printable'])) {
echo "<a href=reports.php?func=repair_vol&printable=1 class=\"linkbutton floatright\"><img src=images/print.png class=iconmedium>".pcrtlang("Printable")."</a>";
}


?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.2/Chart.bundle.min.js"></script>
<canvas id="myLineChart" width="700" height="400"></canvas>

<br><br><canvas id="myLineChartMonth" width="700" height="400"></canvas>
<?php


while($shift < 53) {

if($shift > 0) {
$weeksago[] = "$shift ".pcrtlang("Weeks Ago");
} else {
$weeksago[] = pcrtlang("This Week");
}


$theq = "SELECT * FROM pc_wo WHERE (WEEK(dropdate) = WEEK(DATE_SUB('$currentdatetime', INTERVAL $shift week)) AND YEAR(dropdate) = YEAR(DATE_SUB('$currentdatetime', INTERVAL $shift week))) AND storeid = '$defaultuserstore' AND pcstatus != '7'";
$theqp = "SELECT * FROM pc_wo WHERE (WEEK(pickupdate) = WEEK(DATE_SUB('$currentdatetime', INTERVAL $shift week)) AND YEAR(pickupdate) = YEAR(DATE_SUB('$currentdatetime', INTERVAL $shift week))) AND storeid = '$defaultuserstore' AND pcstatus != '7'";

$a = 0;
$rs_result_wo_r = mysqli_query($rs_connect, $theq);
while($rs_result_rq = mysqli_fetch_object($rs_result_wo_r)) {
$rs_pcids = "$rs_result_rq->pcid";
$totaloftwo = "SELECT pcid FROM pc_wo WHERE pcid = '$rs_pcids'";
$rs_result_two = mysqli_query($rs_connect, $totaloftwo);
$totalpcs_wo = mysqli_num_rows($rs_result_two);
if($totalpcs_wo > 1) {
$a++;
}
}

$pcsret[] = $a;

$rs_result = mysqli_query($rs_connect, $theq);
$totalpcs = mysqli_num_rows($rs_result);
$pcsin[] = $totalpcs;
$rs_result2 = mysqli_query($rs_connect, $theqp);
$totalpcs2 = mysqli_num_rows($rs_result2);
$pcsout[] = $totalpcs2;

$shift++;
$thefirstdaytime = $thefirstdaytime - 604800;
}


$shift = 0;

####
while($shift < 24) {

if($shift > 0) {
$monthsago[] = "$shift ".pcrtlang("Months Ago");
} else {
$monthsago[] = pcrtlang("This Month");
}


$theq = "SELECT * FROM pc_wo WHERE (MONTH(dropdate) = MONTH(DATE_SUB('$currentdatetime', INTERVAL $shift month)) AND YEAR(dropdate) = YEAR(DATE_SUB('$currentdatetime', INTERVAL $shift month))) AND storeid = '$defaultuserstore'";
$theqp = "SELECT * FROM pc_wo WHERE (MONTH(pickupdate) = MONTH(DATE_SUB('$currentdatetime', INTERVAL $shift month)) AND YEAR(pickupdate) = YEAR(DATE_SUB('$currentdatetime', INTERVAL $shift month))) AND storeid = '$defaultuserstore'";

$a = 0;
$rs_result_wo_r = mysqli_query($rs_connect, $theq);
while($rs_result_rq = mysqli_fetch_object($rs_result_wo_r)) {
$rs_pcids = "$rs_result_rq->pcid";
$totaloftwo = "SELECT pcid FROM pc_wo WHERE pcid = '$rs_pcids'";
$rs_result_two = mysqli_query($rs_connect, $totaloftwo);
$totalpcs_wo = mysqli_num_rows($rs_result_two);
if($totalpcs_wo > 1) {
$a++;
}
}

$mpcsret[] = $a;
$rs_result = mysqli_query($rs_connect, $theq);
$totalpcs = mysqli_num_rows($rs_result);
$mpcsin[] = $totalpcs;
$rs_result2 = mysqli_query($rs_connect, $theqp);
$totalpcs2 = mysqli_num_rows($rs_result2);
$mpcsout[] = $totalpcs2;

$shift++;
$thefirstdaytime = $thefirstdaytime - 604800;
}

$mpcsinjson = json_encode($mpcsin);
$mpcsoutjson = json_encode($mpcsout);
$mpcsretjson = json_encode($mpcsret);
$monthsagojson = json_encode($monthsago);


####



$pcsinjson = json_encode($pcsin);
$pcsoutjson = json_encode($pcsout);
$pcsretjson = json_encode($pcsret);
$weeksagojson = json_encode($weeksago);


?>

<script>

var data = {
    labels:  <?php echo $weeksagojson; ?>,
    datasets: [
        {
            label: "<?php echo pcrtlang("Checkins") ?>",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(0,255,0,0.4)",
            borderColor: "rgba(0,255,0,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php echo $pcsinjson; ?>,
            spanGaps: false,
        },
	{
            label: "<?php echo pcrtlang("Checkouts") ?>",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(255,0,0,0.4)",
            borderColor: "rgba(255,0,0,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php echo $pcsoutjson; ?>,
            spanGaps: false,
        },
       {
            label: "<?php echo pcrtlang("Return Checkins") ?>",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(0,0,255,0.4)",
            borderColor: "rgba(0,0,255,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php echo $pcsretjson; ?>,
            spanGaps: false,
        }
    

    ]
};

var ctx = document.getElementById("myLineChart");
var myLineChart = new Chart(ctx, {
    type: 'line',
    data: data,
 options: {
        responsive: false
    }
});

</script>

<script>

var data = {
    labels:  <?php echo $monthsagojson; ?>,
    datasets: [
        {
            label: "<?php echo pcrtlang("Checkins") ?>",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(0,255,0,0.4)",
            borderColor: "rgba(0,255,0,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php echo $mpcsinjson; ?>,
            spanGaps: false,
        },
        {
            label: "<?php echo pcrtlang("Checkouts") ?>",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(255,0,0,0.4)",
            borderColor: "rgba(255,0,0,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php echo $mpcsoutjson; ?>,
            spanGaps: false,
        },
       {
            label: "<?php echo pcrtlang("Return Checkins") ?>",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(0,0,255,0.4)",
            borderColor: "rgba(0,0,255,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php echo $mpcsretjson; ?>,
            spanGaps: false,
        }


    ]
};

var ctx = document.getElementById("myLineChartMonth");
var myLineChartMonth = new Chart(ctx, {
    type: 'line',
    data: data,
 options: {
        responsive: false
    }
});

</script>
<?php



if(!isset($_REQUEST['printable'])) {
stop_box();
require("footer.php");
} else {
printablefooter();
}


}






function fixinv1() {

$thenum = $_REQUEST['thenum'];

require_once("header.php");

require("deps.php");

perm_boot("6");

if ($thenum =="") {
$thenum = 1;
}

$theq = "SELECT * FROM `stock` WHERE stock_quantity > '0' LIMIT $thenum,1";




$rs_result = mysqli_query($rs_connect, $theq);

$more = $thenum + 1;
$less =	$thenum	- 1;

while($rs_result_q = mysqli_fetch_object($rs_result)) {
$qty = "$rs_result_q->stock_quantity";
$stockid = "$rs_result_q->stock_id";

$plus1 = $qty + 1;
$minus1 = $qty - 1;

echo "<a href=reports.php?func=fixinv2&thenum=$thenum&numadd=$plus1&stockid=$stockid>".pcrtlang("Up")."<a><br>";
echo "<a href=reports.php?func=fixinv1&thenum=$less>&lt;</a> $stockid  &gt;  $qty <a href=reports.php?func=fixinv1&thenum=$more>&gt;</a><br>";
echo "<a href=reports.php?func=fixinv2&thenum=$thenum&numadd=$minus1&stockid=$stockid>".pcrtlang("Down")."<a><br>";

}

}


function fixinv2() {

$thenum = $_REQUEST['thenum'];
$numadd = $_REQUEST['numadd'];
$stockid = $_REQUEST['stockid'];

require_once("validate.php");
require("common.php");
require("deps.php");

perm_boot("6");





$rs_insert_stock = "UPDATE stock SET stock_quantity = '$numadd' WHERE stock_id = '$stockid'";
@mysqli_query($rs_connect, $rs_insert_stock);

header("Location: reports.php?func=fixinv1&thenum=$thenum");



}



#################

function taxreport() {

if (array_key_exists('year',$_REQUEST)) {
if ($_REQUEST['year'] != "") {
$year = $_REQUEST['year'];
} else {
$year = date("Y");
}
} else {
$year = date("Y");
}

if (array_key_exists('month',$_REQUEST)) {
if ($_REQUEST['month'] != "") {
$qmonth = $_REQUEST['month'];
} else {
$qmonth = date("M");
}
} else {
$qmonth = date("M");
}



if (array_key_exists('fiscaldate',$_REQUEST)) {
$fiscaldate = $_REQUEST['fiscaldate'];
} else {
$fiscaldate = 0;
}



if(!isset($_REQUEST['printable'])) {
require_once("header.php");
} else {
require_once("common.php");

?>
<!DOCTYPE html>

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php


echo "<title>";
if (!$fiscaldate) {
echo pcrtlang("Yearly Sales/Service Tax Report for")." $year";
} else {
echo pcrtlang("Yearly Sales/Service Tax Report for Fiscal")." $year";
}
echo "</title>";
if(!isset($pcrt_stylesheet)) {
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../repair/style.css\">";
} else {
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../repair/$pcrt_stylesheet\">";
}

echo "</head><body><table style=\"width: 90%;padding:5px;\"><tr><td>";
}

require("deps.php");

perm_boot("5");

if(!isset($_REQUEST['printable'])) {
start_box();
}

echo "<table width=100%><tr><td width=75% align=left>";
if (!$fiscaldate) {
echo "<h4>".pcrtlang("Yearly Sales/Service Tax Report for")." $year</h4><br><br>";
} else {
echo "<h4>".pcrtlang("Yearly Sales/Service Tax Report for Fiscal")." $year</h4><br><br>";
}

if($fiscaldate) {
echo pcrtlang("Fiscal Year Starting")." $year-$qmonth-01<br><br>";
}

echo "</td><td width=25% align=right>";
if(isset($_REQUEST['printable'])) {
echo "<a href=reports.php?func=taxreport&year=$year&month=$qmonth&fiscaldate=$fiscaldate class=linkbutton>".pcrtlang("Non-Printable")."</a>";
} else {
echo "<a href=reports.php?func=taxreport&year=$year&printable=yes&month=$qmonth&fiscaldate=$fiscaldate class=linkbutton><img src=images/print.png border=0 align=absmiddle> ".pcrtlang("Printable")."</a>";
echo "<br><a href=reports.php?func=taxreport_csv&year=$year&month=$qmonth&fiscaldate=$fiscaldate class=linkbutton><img src=images/csv.png border=0 align=absmiddle> ".pcrtlang("CSV")."</a>";
}


echo "</td></tr></table>";




if(!isset($_REQUEST['printable'])) {
if(!$fiscaldate) {
echo "<h4>".pcrtlang("Year Total for")." $year &nbsp;</h4><br><br>";
} else {
echo "<h4>".pcrtlang("Year Total for Fiscal")." $year &nbsp;</h4><br><br>";
}
} else {
if(!$fiscaldate) {
echo "<h4>".pcrtlang("Year Total for")." $year &nbsp;</h4><br><br>";
} else {
echo "<h4>".pcrtlang("Year Total for Fiscal")." $year &nbsp;</h4><br><br>";
}
}


echo "<table>";
$rs_find_cart_tax = "SELECT * FROM taxes";
$rs_result_tax = mysqli_query($rs_connect, $rs_find_cart_tax);
while($rs_result_tax_q = mysqli_fetch_object($rs_result_tax)) {
$rs_taxid = "$rs_result_tax_q->taxid";
$rs_taxname = "$rs_result_tax_q->taxname";
$rs_taxenabled = "$rs_result_tax_q->taxenabled";

if ($rs_taxenabled != "1") {
$ycolor="textgray12b";
} else {
$ycolor="text12b";
}

if(!$fiscaldate) {
$rs_find_cart_purt = "SELECT SUM(itemtax) AS total FROM `sold_items` WHERE YEAR(date_sold) = '$year' AND taxex = '$rs_taxid' AND sold_type != 'refund'";
} else {
$rs_find_cart_purt = "SELECT SUM(itemtax) AS total FROM `sold_items` WHERE date_sold >= '$year-$qmonth-01' AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 1 YEAR)) AND taxex = '$rs_taxid' AND sold_type != 'refund'";
}


$rs_result_purt = mysqli_query($rs_connect, $rs_find_cart_purt);
while($rs_result_pur_qt = mysqli_fetch_object($rs_result_purt)) {
$rs_taxtotal = "$rs_result_pur_qt->total";
echo "<tr><td><span class=$ycolor>$rs_taxname ".pcrtlang("Tax Collected").":</span> </td><td><span class=$ycolor>$money".mf("$rs_taxtotal")."</span></td></tr>";
}

if(!$fiscaldate) {
$rs_find_cart_purtr = "SELECT SUM(itemtax) AS total FROM `sold_items` WHERE YEAR(date_sold) = '$year' AND taxex = '$rs_taxid' AND sold_type = 'refund'";
} else {
$rs_find_cart_purtr = "SELECT SUM(itemtax) AS total FROM `sold_items` WHERE date_sold >= '$year-$qmonth-01' AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 1 YEAR)) AND taxex = '$rs_taxid' AND sold_type = 'refund'";
}
$rs_result_purtr = mysqli_query($rs_connect, $rs_find_cart_purtr);
while($rs_result_pur_qtr = mysqli_fetch_object($rs_result_purtr)) {
$rs_taxtotalr = "$rs_result_pur_qtr->total";
echo "<tr><td><span class=$ycolor>$rs_taxname ".pcrtlang("Tax Refunded").":</span> </td><td><span class=$ycolor>$money".mf("$rs_taxtotalr")."</span></td></tr>";
}

$rs_taxtotalcolminusrefund = $rs_taxtotal - $rs_taxtotalr;
echo "<tr><td><span class=$ycolor>$rs_taxname ".pcrtlang("Tax").":</span> </td><td><span class=$ycolor>$money".mf("$rs_taxtotalcolminusrefund")."</span></td></tr>";


if(!$fiscaldate) {
$rs_find_cart_pur = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE YEAR(date_sold) = '$year' AND taxex = '$rs_taxid' AND sold_type = 'purchase' ";
} else {
$rs_find_cart_pur = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE date_sold >= '$year-$qmonth-01' AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 1 YEAR)) AND taxex = '$rs_taxid' AND sold_type = 'purchase' ";
}
$rs_result_pur = mysqli_query($rs_connect, $rs_find_cart_pur);
while($rs_result_pur_q = mysqli_fetch_object($rs_result_pur)) {
$rs_total = "$rs_result_pur_q->total";
echo "<tr><td><span class=$ycolor>$rs_taxname ".pcrtlang("Tax Basis")." (purchases):</span> </td><td><span class=$ycolor>$money".mf("$rs_total")."</span></td></tr>";
}

if(!$fiscaldate) {
$rs_find_cart_purl = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE YEAR(date_sold) = '$year' AND taxex = '$rs_taxid' AND sold_type = 'labor' ";
} else {
$rs_find_cart_purl = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE date_sold >= '$year-$qmonth-01' AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 1 YEAR)) AND taxex = '$rs_taxid' AND sold_type = 'labor' ";
}
$rs_result_purl = mysqli_query($rs_connect, $rs_find_cart_purl);
while($rs_result_pur_ql = mysqli_fetch_object($rs_result_purl)) {
$rs_totall = "$rs_result_pur_ql->total";
echo "<tr><td><span class=$ycolor>$rs_taxname ".pcrtlang("Tax Basis")." (".pcrtlang("labor")."):</span> </td><td><span class=$ycolor>$money".mf("$rs_totall")."</span></td></tr>";
}

if(!$fiscaldate) {
$rs_find_cart_ref = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE YEAR(date_sold) = '$year' AND taxex = '$rs_taxid' AND sold_type = 'refund' ";
} else {
$rs_find_cart_ref = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE date_sold >= '$year-$qmonth-01' AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 1 YEAR)) AND taxex = '$rs_taxid' AND sold_type = 'refund' ";
}
$rs_result_ref = mysqli_query($rs_connect, $rs_find_cart_ref);
while($rs_result_ref_q = mysqli_fetch_object($rs_result_ref)) {
$rs_totalref = "$rs_result_ref_q->total";
echo "<tr><td><span class=$ycolor>$rs_taxname ".pcrtlang("Tax Basis")." (".pcrtlang("refunds")."):</span> </td><td><span class=$ycolor>$money".mf("$rs_totalref")."</span></td></tr>";
}

$rs_totalpur = $rs_total - $rs_totalref;
echo "<tr><td><span class=$ycolor>$rs_taxname ".pcrtlang("Tax Basis")." (".pcrtlang("purchases")."-".pcrtlang("refunds")."):</span> </td><td><span class=$ycolor>$money".mf("$rs_totalpur")."</span></td></tr>";

$rs_totallabpur = (($rs_total + $rs_totall) - $rs_totalref);
echo "<tr><td><span class=$ycolor>$rs_taxname ".pcrtlang("Tax Basis")." (".pcrtlang("labor")."+".pcrtlang("purchases")."-".pcrtlang("refunds")."):</span> </td><td><span class=$ycolor>$money".mf("$rs_totallabpur")."</span></td></tr>";
echo "<tr><td colspan=2>&nbsp;</td></tr>";



}
echo "</table>";

###quarter

if(!isset($_REQUEST['printable'])) {
if(!$fiscaldate) {
echo "<br><br><h4>".pcrtlang("Quarter Total for")." $year &nbsp;</h4>";
} else {
echo "<br><br><h4>".pcrtlang("Quarter Total for Fiscal")." $year &nbsp;</h4>";
}
} else {
if(!$fiscaldate) {
echo "<br><br><h4>".pcrtlang("Quarter Total for")." $year &nbsp;</h4>";
} else {
echo "<br><br><h4>".pcrtlang("Quarter Total for Fiscal")." $year &nbsp;</h4>";
}
}


echo "<table>";

$fiscalquarter[1] = "date_sold >= '$year-$qmonth-01' AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 3 MONTH))";
$fiscalquarter[2] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 3 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 6 MONTH))";
$fiscalquarter[3] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 6 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 9 MONTH))";
$fiscalquarter[4] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 9 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 1 YEAR))";


$qrtr = 1;

while ($qrtr < 5) {

$rs_find_cart_tax2 = "SELECT * FROM taxes";
$rs_result_tax2 = mysqli_query($rs_connect, $rs_find_cart_tax2);

while($rs_result_tax_q2 = mysqli_fetch_object($rs_result_tax2)) {
$rs_taxid2 = "$rs_result_tax_q2->taxid";
$rs_taxname2 = "$rs_result_tax_q2->taxname";
$rs_taxenabled2 = "$rs_result_tax_q2->taxenabled";

if ($rs_taxenabled2 != '1') {
$ycolor2="textgray12b";
} else {
$ycolor2="text12b";
}

if(!$fiscaldate) {
$rs_find_cart_purt = "SELECT SUM(itemtax) AS total FROM `sold_items` WHERE QUARTER(date_sold) = '$qrtr' AND YEAR(date_sold) = '$year' AND taxex = '$rs_taxid2' AND sold_type != 'refund'";
} else {
$rs_find_cart_purt = "SELECT SUM(itemtax) AS total FROM `sold_items` WHERE $fiscalquarter[$qrtr] AND taxex = '$rs_taxid2' AND sold_type != 'refund'";
}


$rs_result_purt = mysqli_query($rs_connect, $rs_find_cart_purt);
while($rs_result_pur_qt = mysqli_fetch_object($rs_result_purt)) {
$rs_taxtotal = "$rs_result_pur_qt->total";
echo "<tr><td><span class=$ycolor>".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Collected").":</span> </td><td><span class=$ycolor>$money".mf("$rs_taxtotal")."</span></td></tr>";
}

if(!$fiscaldate) {
$rs_find_cart_purtr = "SELECT SUM(itemtax) AS total FROM `sold_items` WHERE QUARTER(date_sold) = '$qrtr' AND YEAR(date_sold) = '$year' AND taxex = '$rs_taxid2' AND sold_type = 'refund'";
} else {
$rs_find_cart_purtr = "SELECT SUM(itemtax) AS total FROM `sold_items` WHERE $fiscalquarter[$qrtr] AND taxex = '$rs_taxid2' AND sold_type = 'refund'";
}
$rs_result_purtr = mysqli_query($rs_connect, $rs_find_cart_purtr);
while($rs_result_pur_qtr = mysqli_fetch_object($rs_result_purtr)) {
$rs_taxtotalr = "$rs_result_pur_qtr->total";
echo "<tr><td><span class=$ycolor>".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Refunded").":</span> </td><td><span class=$ycolor>$money".mf("$rs_taxtotalr")."</span></td></tr>";
}

$rs_taxtotalcolminusrefund = $rs_taxtotal - $rs_taxtotalr;
echo "<tr><td><span class=$ycolor>".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax").":</span> </td><td><span class=$ycolor>$money".mf("$rs_taxtotalcolminusrefund")."</span></td></tr>";


if(!$fiscaldate) {
$rs_find_cart_pur = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE QUARTER(date_sold) = '$qrtr' AND YEAR(date_sold) = '$year' AND taxex = '$rs_taxid2' AND sold_type = 'purchase'";
} else {
$rs_find_cart_pur = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalquarter[$qrtr] AND taxex = '$rs_taxid2' AND sold_type = 'purchase'";
}
$rs_result_pur = mysqli_query($rs_connect, $rs_find_cart_pur);
while($rs_result_pur_q = mysqli_fetch_object($rs_result_pur)) {
$rs_total = "$rs_result_pur_q->total";
echo "<tr><td><span class=$ycolor>".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Basis")." (".pcrtlang("purchases")."):</span> </td><td><span class=$ycolor>$money".mf("$rs_total")."</span></td></tr>";
}

if(!$fiscaldate) {
$rs_find_cart_purl = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE QUARTER(date_sold) = '$qrtr' AND YEAR(date_sold) = '$year' AND taxex = '$rs_taxid2' AND sold_type = 'labor' ";
} else {
$rs_find_cart_purl = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalquarter[$qrtr] AND taxex = '$rs_taxid2' AND sold_type = 'labor' ";
}
$rs_result_purl = mysqli_query($rs_connect, $rs_find_cart_purl);
while($rs_result_pur_ql = mysqli_fetch_object($rs_result_purl)) {
$rs_totall = "$rs_result_pur_ql->total";
echo "<tr><td><span class=$ycolor>".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Basis")." (".pcrtlang("labor")."):</span> </td><td><span class=$ycolor>$money".mf("$rs_totall")."</span></td></tr>";
}

if(!$fiscaldate) {
$rs_find_cart_ref = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE QUARTER(date_sold) = '$qrtr' AND YEAR(date_sold) = '$year' AND taxex = '$rs_taxid2' AND sold_type = 'refund' ";
} else {
$rs_find_cart_ref = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalquarter[$qrtr] AND taxex = '$rs_taxid2' AND sold_type = 'refund' ";
}
$rs_result_ref = mysqli_query($rs_connect, $rs_find_cart_ref);
while($rs_result_ref_q = mysqli_fetch_object($rs_result_ref)) {
$rs_totalref = "$rs_result_ref_q->total";
echo "<tr><td><span class=$ycolor>".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Basis")." (".pcrtlang("refunds")."):</span> </td><td><span class=$ycolor>$money".mf("$rs_totalref")."</span></td></tr>";
}

$rs_totalpur = $rs_total - $rs_totalref;
echo "<tr><td><span class=$ycolor>".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Basis")." (".pcrtlang("purchases")."-".pcrtlang("refunds")."):</span> </td><td><span class=$ycolor>$money".mf("$rs_totalpur")."</span></td></tr>";

$rs_totallabpur = (($rs_total + $rs_totall) - $rs_totalref);
echo "<tr><td><span class=$ycolor>".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Basis")." (".pcrtlang("labor")."+".pcrtlang("purchases")."-".pcrtlang("refunds")."):</span> </td><td><span class=$ycolor>$money".mf("$rs_totallabpur")."</span></td></tr>";
echo "<tr><td colspan=2>&nbsp;</td></tr>";



}
echo "<tr><td colspan=2>&nbsp;</td></tr>";
$qrtr++;

}
echo "</table>";





####month 

if(!isset($_REQUEST['printable'])) {
if(!$fiscaldate) {
echo "<br><br><h4>".pcrtlang("Monthly Totals for")." $year &nbsp;</h4>";
} else {
echo "<br><br><h4>".pcrtlang("Monthly Totals for Fiscal")." $year &nbsp;</h4>";
}
} else {
if(!$fiscaldate) {
echo "<br><br><h4>".pcrtlang("Monthly Totals for")." $year &nbsp;</h4>";
} else {
echo "<br><br><h4>".pcrtlang("Monthly Totals for Fiscal")." $year &nbsp;</h4>";
}
}


echo "<table>";

$fiscalmonth[1] = "date_sold >= '$year-$qmonth-01' AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 1 MONTH))";
$fiscalmonth[2] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 1 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 2 MONTH))";
$fiscalmonth[3] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 2 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 3 MONTH))";
$fiscalmonth[4] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 3 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 4 MONTH))";
$fiscalmonth[5] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 4 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 5 MONTH))";
$fiscalmonth[6] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 5 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 6 MONTH))";
$fiscalmonth[7] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 6 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 7 MONTH))";
$fiscalmonth[8] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 7 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 8 MONTH))";
$fiscalmonth[9] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 8 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 9 MONTH))";
$fiscalmonth[10] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 9 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 10 MONTH))";
$fiscalmonth[11] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 10 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 11 MONTH))";
$fiscalmonth[12] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 11 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 12 MONTH))";

$month = 1;

while ($month < 13) {

$rs_find_cart_tax3 = "SELECT * FROM taxes";
$rs_result_tax3 = mysqli_query($rs_connect, $rs_find_cart_tax3);

while($rs_result_tax_q3 = mysqli_fetch_object($rs_result_tax3)) {
$rs_taxid3 = "$rs_result_tax_q3->taxid";
$rs_taxname3 = "$rs_result_tax_q3->taxname";
$rs_taxenabled3 = "$rs_result_tax_q3->taxenabled";

if ($rs_taxenabled3 != '1') {
$ycolor3 = "textgray12b";
} else {
$ycolor3 = "text12b";
}

if(!$fiscaldate) {
$rs_find_cart_purt = "SELECT SUM(itemtax) AS total FROM `sold_items` WHERE MONTH(date_sold) = '$month' AND YEAR(date_sold) = '$year' AND taxex = '$rs_taxid3' AND sold_type != 'refund'";
} else {
$rs_find_cart_purt = "SELECT SUM(itemtax) AS total FROM `sold_items` WHERE $fiscalmonth[$month] AND taxex = '$rs_taxid3' AND sold_type != 'refund'";
}
$rs_result_purt = mysqli_query($rs_connect, $rs_find_cart_purt);
while($rs_result_pur_qt = mysqli_fetch_object($rs_result_purt)) {
$rs_taxtotal = "$rs_result_pur_qt->total";
echo "<tr><td><span class=$ycolor>".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Collected").":</span> </td><td><span class=$ycolor>$money".mf("$rs_taxtotal")."</span></td></tr>";
}

if(!$fiscaldate) {
$rs_find_cart_purtr = "SELECT SUM(itemtax) AS total FROM `sold_items` WHERE MONTH(date_sold) = '$month' AND YEAR(date_sold) = '$year' AND taxex = '$rs_taxid3' AND sold_type = 'refund'";
} else {
$rs_find_cart_purtr = "SELECT SUM(itemtax) AS total FROM `sold_items` WHERE $fiscalmonth[$month] AND taxex = '$rs_taxid3' AND sold_type = 'refund'";
}
$rs_result_purtr = mysqli_query($rs_connect, $rs_find_cart_purtr);
while($rs_result_pur_qtr = mysqli_fetch_object($rs_result_purtr)) {
$rs_taxtotalr = "$rs_result_pur_qtr->total";
echo "<tr><td><span class=$ycolor>".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Refunded").":</span> </td><td><span class=$ycolor>$money".mf("$rs_taxtotalr")."</span></td></tr>";
}

$rs_taxtotalcolminusrefund = $rs_taxtotal - $rs_taxtotalr;
echo "<tr><td><span class=$ycolor>".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax").":</span> </td><td><span class=$ycolor>$money".mf("$rs_taxtotalcolminusrefund")."</span></td></tr>";


if(!$fiscaldate) {
$rs_find_cart_pur = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE MONTH(date_sold) = '$month' AND YEAR(date_sold) = '$year' AND taxex = '$rs_taxid3' AND sold_type = 'purchase' ";
} else {
$rs_find_cart_pur = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalmonth[$month] AND taxex = '$rs_taxid3' AND sold_type = 'purchase' ";
}
$rs_result_pur = mysqli_query($rs_connect, $rs_find_cart_pur);
while($rs_result_pur_q = mysqli_fetch_object($rs_result_pur)) {
$rs_total = "$rs_result_pur_q->total";
echo "<tr><td><span class=$ycolor>".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Basis")." (".pcrtlang("purchases")."):</span> </td><td><span class=$ycolor>$money".mf("$rs_total")."</span></td></tr>";
}

if(!$fiscaldate) {
$rs_find_cart_purl = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE MONTH(date_sold) = '$month' AND YEAR(date_sold) = '$year' AND taxex = '$rs_taxid3' AND sold_type = 'labor' ";
} else {
$rs_find_cart_purl = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalmonth[$month] AND taxex = '$rs_taxid3' AND sold_type = 'labor' ";
}
$rs_result_purl = mysqli_query($rs_connect, $rs_find_cart_purl);
while($rs_result_pur_ql = mysqli_fetch_object($rs_result_purl)) {
$rs_totall = "$rs_result_pur_ql->total";
echo "<tr><td><span class=$ycolor>".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Basis")." (".pcrtlang("labor")."):</span> </td><td><span class=$ycolor>$money".mf("$rs_totall")."</span></td></tr>";
}

if(!$fiscaldate) {
$rs_find_cart_ref = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE MONTH(date_sold) = '$month' AND YEAR(date_sold) = '$year' AND taxex = '$rs_taxid3' AND sold_type = 'refund' ";
} else {
$rs_find_cart_ref = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalmonth[$month] AND taxex = '$rs_taxid3' AND sold_type = 'refund' ";
}
$rs_result_ref = mysqli_query($rs_connect, $rs_find_cart_ref);
while($rs_result_ref_q = mysqli_fetch_object($rs_result_ref)) {
$rs_totalref = "$rs_result_ref_q->total";
echo "<tr><td><span class=$ycolor>".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Basis")." (".pcrtlang("refunds")."):</span> </td><td><span class=$ycolor>$money".mf("$rs_totalref")."</span></td></tr>";
}

$rs_totalpur = $rs_total - $rs_totalref;
echo "<tr><td><span class=$ycolor>".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Basis")." (".pcrtlang("purchases")."-".pcrtlang("refunds")."):</span> </td><td><span class=$ycolor>$money".mf("$rs_totalpur")."</span></td></tr>";

$rs_totallabpur = (($rs_total + $rs_totall) - $rs_totalref);
echo "<tr><td><span class=$ycolor>".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Basis")." (".pcrtlang("labor")."+".pcrtlang("purchases")."-".pcrtlang("refunds")."):</span> </td><td><span class=$ycolor>$money".mf("$rs_totallabpur")."</span></td></tr>";
echo "<tr><td colspan=2>&nbsp;</td></tr>";




}
echo "<tr><td colspan=2>&nbsp;</td></tr>";
$month++;

}
echo "</table>";

if(!isset($_REQUEST['printable'])) {
stop_box();
}

if(!isset($_REQUEST['printable'])) {
require("footer.php");
} else {
echo "</td></tr></table></body></html>";
}



}


######################################################################################################################

function taxreportnew() {

require("deps.php");
require_once("common.php");
perm_boot("5");

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}


if (array_key_exists('year',$_REQUEST)) {
if ($_REQUEST['year'] != "") {
$year = $_REQUEST['year'];
} else {
$year = date("Y");
}
} else {
$year = date("Y");
}

if (array_key_exists('month',$_REQUEST)) {
if ($_REQUEST['month'] != "") {
$qmonth = $_REQUEST['month'];
} else {
$qmonth = date("M");
}
} else {
$qmonth = date("M");
}



if (array_key_exists('fiscaldate',$_REQUEST)) {
$fiscaldate = $_REQUEST['fiscaldate'];
} else {
$fiscaldate = 0;
}



if(!isset($_REQUEST['printable'])) {
require_once("header.php");
} else {
if (!$fiscaldate) {
echo printableheader(pcrtlang("Yearly Sales/Service Tax Report for")." $year");
} else {
echo printableheader(pcrtlang("Yearly Sales/Service Tax Report for Fiscal")." $year");
}
}

if(!isset($_REQUEST['printable'])) {
start_box();
}

echo "<table width=100%><tr><td width=75% align=left>";
if (!$fiscaldate) {
echo "<span class=sizemelarger>".pcrtlang("Yearly Sales/Service Tax Report for")." $year</span><br><br>";
} else {
echo "<span class=sizemelarger>".pcrtlang("Yearly Sales/Service Tax Report for Fiscal")." $year</span><br><br>";
}

if($fiscaldate) {
echo "<span class=sizeme12>".pcrtlang("Fiscal Year Starting")." $year-$qmonth-01</span><br><br>";
}

echo "</td><td width=25% align=right>";
if(!isset($_REQUEST['printable'])) {
echo "<a href=reports.php?func=taxreportnew&year=$year&printable=yes&month=$qmonth&fiscaldate=$fiscaldate class=linkbutton><img src=images/print.png border=0 align=absmiddle> ".pcrtlang("Printable")."</a>";
echo "<br><a href=reports.php?func=taxreportnew_csv&year=$year&month=$qmonth&fiscaldate=$fiscaldate class=linkbutton><img src=images/csv.png border=0 align=absmiddle> ".pcrtlang("CSV")."</a>";
}


echo "</td></tr></table>";




if(!isset($_REQUEST['printable'])) {
if(!$fiscaldate) {
echo "<span class=sizemelarger>".pcrtlang("Year Total for")." $year &nbsp;</span><br><br>";
} else {
echo "<span class=sizemelarger>".pcrtlang("Year Total for Fiscal")." $year &nbsp;</span><br><br>";
}
} else {
if(!$fiscaldate) {
echo "<span class=sizemelarger>".pcrtlang("Year Total for")." $year &nbsp;</span><br><br>";
} else {
echo "<span class=sizemelarger>".pcrtlang("Year Total for Fiscal")." $year &nbsp;</span><br><br>";
}
}


echo "<table class=\"standard lastalignright\">";
$rs_find_cart_tax = "SELECT * FROM taxes WHERE isgrouprate != '1'";
$rs_result_tax = mysqli_query($rs_connect, $rs_find_cart_tax);
while($rs_result_tax_q = mysqli_fetch_object($rs_result_tax)) {
$rs_taxid = "$rs_result_tax_q->taxid";
$rs_taxname = "$rs_result_tax_q->taxname";
$rs_taxenabled = "$rs_result_tax_q->taxenabled";


$groupsbelong = array();
$groupsbelong[] = "$rs_taxid";
$rs_ql_isingroup = "SELECT * FROM taxes WHERE isgrouprate = '1'";
$rs_result1_isingroup = mysqli_query($rs_connect, $rs_ql_isingroup);
while($rs_result_q1_isingroup = mysqli_fetch_object($rs_result1_isingroup)) {
$compositerate = "$rs_result_q1_isingroup->compositerate";
$gtaxid = "$rs_result_q1_isingroup->taxid";
$subarray = unserialize($compositerate);
if (in_array($rs_taxid,$subarray)) {
$groupsbelong[] = $gtaxid;
}
}



if ($rs_taxenabled != "1") {
$ycolor="<span class=italme>";
} else {
$ycolor="<span>";
}

$taxids = implode(',',$groupsbelong);  


if(!$fiscaldate) {
$rs_find_cart_purt_purchase = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE YEAR(date_sold) = '$year' AND sold_type = 'purchase' AND taxex IN ($taxids)";
$rs_find_cart_purt_labor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE YEAR(date_sold) = '$year' AND sold_type = 'labor' AND taxex IN ($taxids)";
$rs_find_cart_purt_refund = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE YEAR(date_sold) = '$year' AND sold_type = 'refund' AND taxex IN ($taxids)";
$rs_find_cart_purt_refundlabor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE YEAR(date_sold) = '$year' AND sold_type = 'refundlabor' AND taxex IN ($taxids)";
} else {
$rs_find_cart_purt_purchase = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE date_sold >= '$year-$qmonth-01' AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 1 YEAR)) AND sold_type = 'purchase' AND taxex IN ($taxids)";
$rs_find_cart_purt_labor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE date_sold >= '$year-$qmonth-01' AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 1 YEAR)) AND sold_type = 'labor' AND taxex IN ($taxids)";
$rs_find_cart_purt_refund = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE date_sold >= '$year-$qmonth-01' AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 1 YEAR)) AND sold_type = 'refund' AND taxex IN ($taxids)";
$rs_find_cart_purt_refundlabor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE date_sold >= '$year-$qmonth-01' AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 1 YEAR)) AND sold_type = 'refundlabor' AND taxex IN ($taxids)";
}


$rs_result_purt_purchase = mysqli_query($rs_connect, $rs_find_cart_purt_purchase);
$rs_result_pur_purchase_qt = mysqli_fetch_object($rs_result_purt_purchase);
$rs_totalsales_purchase = "$rs_result_pur_purchase_qt->total";
$salestaxrate = getsalestaxrate($rs_taxid);
$rs_totaltax_purchase = tnv($rs_totalsales_purchase) * $salestaxrate;

$rs_result_purt_labor = mysqli_query($rs_connect, $rs_find_cart_purt_labor);
$rs_result_pur_labor_qt = mysqli_fetch_object($rs_result_purt_labor);
$rs_totalsales_labor = "$rs_result_pur_labor_qt->total";
$servicetaxrate = getservicetaxrate($rs_taxid);
$rs_totaltax_labor = tnv($rs_totalsales_labor) * $servicetaxrate;

$rs_result_purt_refund = mysqli_query($rs_connect, $rs_find_cart_purt_refund);
$rs_result_pur_refund_qt = mysqli_fetch_object($rs_result_purt_refund);
$rs_totalsales_refund = "$rs_result_pur_refund_qt->total";
$rs_totaltax_refund = tnv($rs_totalsales_refund) * $salestaxrate;

$rs_result_purt_refundlabor = mysqli_query($rs_connect, $rs_find_cart_purt_refundlabor);
$rs_result_pur_refundlabor_qt = mysqli_fetch_object($rs_result_purt_refundlabor);
$rs_totalsales_refundlabor = "$rs_result_pur_refundlabor_qt->total";
$rs_totaltax_refundlabor = tnv($rs_totalsales_refundlabor) * $servicetaxrate;


$rs_taxtotal = $rs_totaltax_purchase + $rs_totaltax_labor;
$rs_taxtotalrefund = $rs_totaltax_refund + $rs_totaltax_refundlabor;


echo "<tr><td>$ycolor$rs_taxname ".pcrtlang("Tax Collected").":</span> </td><td>$ycolor$money".mf("$rs_taxtotal")."</span></td></tr>";
echo "<tr><td>$ycolor$rs_taxname ".pcrtlang("Tax Refunded").":</span> </td><td>$ycolor$money".mf("$rs_taxtotalrefund")."</span></td></tr>";

$rs_taxtotalcolminusrefund = $rs_taxtotal - $rs_taxtotalrefund;

echo "<tr><td>$ycolor$rs_taxname ".pcrtlang("Tax").":</span> </td><td>$ycolor$money".mf("$rs_taxtotalcolminusrefund")."</span></td></tr>";
echo "<tr><td>$ycolor$rs_taxname ".pcrtlang("Tax Basis")." (".pcrtlang("purchases")."):</span> </td><td>$ycolor$money".mf("$rs_totalsales_purchase")."</span></td></tr>";
echo "<tr><td>$ycolor$rs_taxname ".pcrtlang("Tax Basis")." (".pcrtlang("labor")."):</span> </td><td>$ycolor$money".mf("$rs_totalsales_labor")."</span></td></tr>";
echo "<tr><td>$ycolor$rs_taxname ".pcrtlang("Tax Basis")." (".pcrtlang("sales refunds")."):</span> </td><td>$ycolor$money".mf("$rs_totalsales_refund")."</span></td></tr>";
echo "<tr><td>$ycolor$rs_taxname ".pcrtlang("Tax Basis")." (".pcrtlang("labor refunds")."):</span> </td><td>$ycolor$money".mf("$rs_totalsales_refundlabor")."</span></td></tr>";


$rs_totalpur = tnv($rs_totalsales_purchase) - tnv($rs_totalsales_refund);

echo "<tr><td>$ycolor$rs_taxname ".pcrtlang("Tax Basis")." (".pcrtlang("purchases")."-".pcrtlang("sales refunds")."):</span> </td><td>$ycolor$money".mf("$rs_totalpur")."</span></td></tr>";

$rs_totallabpur = ((tnv($rs_totalsales_purchase) + tnv($rs_totalsales_labor)) - (tnv($rs_totalsales_refund) + tnv($rs_totalsales_refundlabor)));
echo "<tr><td>$ycolor$rs_taxname ".pcrtlang("Tax Basis")." (".pcrtlang("labor")."+".pcrtlang("purchases")."-".pcrtlang("sales refunds")."+".pcrtlang("labor refunds")."):</span> </td><td>$ycolor$money".mf("$rs_totallabpur")."</span></td></tr>";
echo "<tr><td colspan=2>&nbsp;</td></tr>";

}
echo "</table>";

###quarter

if(!isset($_REQUEST['printable'])) {
if(!$fiscaldate) {
echo "<br><br><span class=sizemelarger>".pcrtlang("Quarter Total for")." $year &nbsp;</span><br><br>";
} else {
echo "<br><br><span class=sizemelarger>".pcrtlang("Quarter Total for Fiscal")." $year &nbsp;</span><br><br>";
}
} else {
if(!$fiscaldate) {
echo "<br><br><span class=sizemelarger>".pcrtlang("Quarter Total for")." $year &nbsp;</span><br><br>";
} else {
echo "<br><br><span class=sizemelarger>".pcrtlang("Quarter Total for Fiscal")." $year &nbsp;</span><br><br>";
}
}


echo "<table class=\"standard lastalignright\">";

$fiscalquarter[1] = "date_sold >= '$year-$qmonth-01' AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 3 MONTH))";
$fiscalquarter[2] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 3 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 6 MONTH))";
$fiscalquarter[3] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 6 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 9 MONTH))";
$fiscalquarter[4] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 9 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 1 YEAR))";


$qrtr = 1;

while ($qrtr < 5) {

$rs_find_cart_tax2 = "SELECT * FROM taxes WHERE isgrouprate != '1'";
$rs_result_tax2 = mysqli_query($rs_connect, $rs_find_cart_tax2);

while($rs_result_tax_q2 = mysqli_fetch_object($rs_result_tax2)) {
$rs_taxid2 = "$rs_result_tax_q2->taxid";
$rs_taxname2 = "$rs_result_tax_q2->taxname";
$rs_taxenabled2 = "$rs_result_tax_q2->taxenabled";


$groupsbelong = array();
$groupsbelong[] = "$rs_taxid2";
$rs_ql_isingroup = "SELECT * FROM taxes WHERE isgrouprate = '1'";
$rs_result1_isingroup = mysqli_query($rs_connect, $rs_ql_isingroup);
while($rs_result_q1_isingroup = mysqli_fetch_object($rs_result1_isingroup)) {
$compositerate = "$rs_result_q1_isingroup->compositerate";
$gtaxid = "$rs_result_q1_isingroup->taxid";
$subarray = unserialize($compositerate);
if (in_array($rs_taxid2,$subarray)) {
$groupsbelong[] = $gtaxid;
}
}

if ($rs_taxenabled2 != '1') {
$ycolor2="<span class=italme>";
} else {
$ycolor2="<span>";
}

$taxids = implode(',',$groupsbelong);

if(!$fiscaldate) {
$rs_find_cart_purt_purchase = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE QUARTER(date_sold) = '$qrtr' AND YEAR(date_sold) = '$year' AND sold_type = 'purchase' AND taxex IN ($taxids)";
$rs_find_cart_purt_labor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE QUARTER(date_sold) = '$qrtr' AND YEAR(date_sold) = '$year' AND sold_type = 'labor' AND taxex IN ($taxids)";
$rs_find_cart_purt_refund = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE QUARTER(date_sold) = '$qrtr' AND YEAR(date_sold) = '$year' AND sold_type = 'refund' AND taxex IN ($taxids)";
$rs_find_cart_purt_refundlabor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE QUARTER(date_sold) = '$qrtr' AND YEAR(date_sold) = '$year' AND sold_type = 'refundlabor' AND taxex IN ($taxids)";
} else {
$rs_find_cart_purt_purchase = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalquarter[$qrtr] AND sold_type = 'purchase' AND taxex IN ($taxids)";
$rs_find_cart_purt_labor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalquarter[$qrtr] AND sold_type = 'labor' AND taxex IN ($taxids)";
$rs_find_cart_purt_refund = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalquarter[$qrtr] AND sold_type = 'refund' AND taxex IN ($taxids)";
$rs_find_cart_purt_refundlabor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalquarter[$qrtr] AND sold_type = 'refundlabor' AND taxex IN ($taxids)";
}


$rs_result_purt_purchase = mysqli_query($rs_connect, $rs_find_cart_purt_purchase);
$rs_result_pur_purchase_qt = mysqli_fetch_object($rs_result_purt_purchase);
$rs_totalsales_purchase = "$rs_result_pur_purchase_qt->total";
$salestaxrate = getsalestaxrate($rs_taxid2);
$rs_totaltax_purchase = tnv($rs_totalsales_purchase) * $salestaxrate;

$rs_result_purt_labor = mysqli_query($rs_connect, $rs_find_cart_purt_labor);
$rs_result_pur_labor_qt = mysqli_fetch_object($rs_result_purt_labor);
$rs_totalsales_labor = "$rs_result_pur_labor_qt->total";
$servicetaxrate = getservicetaxrate($rs_taxid2);
$rs_totaltax_labor = tnv($rs_totalsales_labor) * $servicetaxrate;

$rs_result_purt_refund = mysqli_query($rs_connect, $rs_find_cart_purt_refund);
$rs_result_pur_refund_qt = mysqli_fetch_object($rs_result_purt_refund);
$rs_totalsales_refund = "$rs_result_pur_refund_qt->total";
$rs_totaltax_refund = tnv($rs_totalsales_refund) * $salestaxrate;

$rs_result_purt_refundlabor = mysqli_query($rs_connect, $rs_find_cart_purt_refundlabor);
$rs_result_pur_refundlabor_qt = mysqli_fetch_object($rs_result_purt_refundlabor);
$rs_totalsales_refundlabor = "$rs_result_pur_refundlabor_qt->total";
$rs_totaltax_refundlabor = tnv($rs_totalsales_refundlabor) * $servicetaxrate;



$rs_taxtotal = $rs_totaltax_purchase + $rs_totaltax_labor;
$rs_taxtotalrefund = $rs_totaltax_refund + $rs_totaltax_refundlabor;

echo "<tr><td>$ycolor".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Collected").":</span> </td><td>$ycolor$money".mf("$rs_taxtotal")."</span></td></tr>";
echo "<tr><td>$ycolor".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Refunded").":</span> </td><td>$ycolor$money".mf("$rs_taxtotalrefund")."</span></td></tr>";

$rs_taxtotalcolminusrefund = $rs_taxtotal - $rs_taxtotalrefund;
echo "<tr><td>$ycolor".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax").":</span> </td><td>$ycolor$money".mf("$rs_taxtotalcolminusrefund")."</span></td></tr>";
echo "<tr><td>$ycolor".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Basis")." (".pcrtlang("purchases")."):</span> </td><td>$ycolor$money".mf("$rs_totalsales_purchase")."</span></td></tr>";
echo "<tr><td>$ycolor".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Basis")." (".pcrtlang("labor")."):</span> </td><td>$ycolor$money".mf("$rs_totalsales_labor")."</span></td></tr>";
echo "<tr><td>$ycolor".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Basis")." (".pcrtlang("sales refunds")."):</span> </td><td>$ycolor$money".mf("$rs_totalsales_refund")."</span></td></tr>";
echo "<tr><td>$ycolor".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Basis")." (".pcrtlang("labor refunds")."):</span> </td><td>$ycolor$money".mf("$rs_totalsales_refundlabor")."</span></td></tr>";

$rs_totalpur = tnv($rs_totalsales_purchase) - tnv($rs_totalsales_refund);
echo "<tr><td>$ycolor".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Basis")." (".pcrtlang("purchases")."-".pcrtlang("refunds")."):</span> </td><td>$ycolor$money".mf("$rs_totalpur")."</span></td></tr>";

$rs_totallabpur = ((tnv($rs_totalsales_purchase) + tnv($rs_totalsales_labor)) - (tnv($rs_totalsales_refund) + tnv($rs_totalsales_refundlabor)));
echo "<tr><td>$ycolor".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Basis")." (".pcrtlang("labor")."+".pcrtlang("purchases")."-".pcrtlang("sales refunds")."+".pcrtlang("labor refunds")."):</span> </td><td>$ycolor$money".mf("$rs_totallabpur")."</span></td></tr>";
echo "<tr><td colspan=2>&nbsp;</td></tr>";



}
echo "<tr><td colspan=2>&nbsp;</td></tr>";
$qrtr++;

}
echo "</table>";





####month 

if(!isset($_REQUEST['printable'])) {
if(!$fiscaldate) {
echo "<br><br><span class=sizemelarger>".pcrtlang("Monthly Totals for")." $year &nbsp;</span><br><br>";
} else {
echo "<br><br><span class=sizemelarger>".pcrtlang("Monthly Totals for Fiscal")." $year &nbsp;</span><br><br>";
}
} else {
if(!$fiscaldate) {
echo "<br><br><span class=sizemelarger>".pcrtlang("Monthly Totals for")." $year &nbsp;</span><br><br>";
} else {
echo "<br><br><span class=sizemelarger>".pcrtlang("Monthly Totals for Fiscal")." $year &nbsp;</span><br><br>";
}
}


echo "<table class=\"standard lastalignright\">";

$fiscalmonth[1] = "date_sold >= '$year-$qmonth-01' AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 1 MONTH))";
$fiscalmonth[2] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 1 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 2 MONTH))";
$fiscalmonth[3] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 2 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 3 MONTH))";
$fiscalmonth[4] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 3 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 4 MONTH))";
$fiscalmonth[5] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 4 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 5 MONTH))";
$fiscalmonth[6] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 5 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 6 MONTH))";
$fiscalmonth[7] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 6 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 7 MONTH))";
$fiscalmonth[8] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 7 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 8 MONTH))";
$fiscalmonth[9] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 8 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 9 MONTH))";
$fiscalmonth[10] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 9 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 10 MONTH))";
$fiscalmonth[11] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 10 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 11 MONTH))";
$fiscalmonth[12] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 11 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 12 MONTH))";

$month = 1;

while ($month < 13) {

$rs_find_cart_tax3 = "SELECT * FROM taxes WHERE isgrouprate != '1'";
$rs_result_tax3 = mysqli_query($rs_connect, $rs_find_cart_tax3);

while($rs_result_tax_q3 = mysqli_fetch_object($rs_result_tax3)) {
$rs_taxid3 = "$rs_result_tax_q3->taxid";
$rs_taxname3 = "$rs_result_tax_q3->taxname";
$rs_taxenabled3 = "$rs_result_tax_q3->taxenabled";

$groupsbelong = array();
$groupsbelong[] = "$rs_taxid3";
$rs_ql_isingroup = "SELECT * FROM taxes WHERE isgrouprate = '1'";
$rs_result1_isingroup = mysqli_query($rs_connect, $rs_ql_isingroup);
while($rs_result_q1_isingroup = mysqli_fetch_object($rs_result1_isingroup)) {
$compositerate = "$rs_result_q1_isingroup->compositerate";
$gtaxid = "$rs_result_q1_isingroup->taxid";
$subarray = unserialize($compositerate);
if (in_array($rs_taxid3,$subarray)) {
$groupsbelong[] = $gtaxid;
}
}

$taxids = implode(',',$groupsbelong);

if ($rs_taxenabled3 != '1') {
$ycolor3 = "<span class=italme>";
} else {
$ycolor3 = "<span>";
}

if(!$fiscaldate) {
$rs_find_cart_purt_purchase = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE MONTH(date_sold) = '$month' AND YEAR(date_sold) = '$year' AND sold_type = 'purchase' AND taxex IN ($taxids)";
$rs_find_cart_purt_labor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE MONTH(date_sold) = '$month' AND YEAR(date_sold) = '$year' AND sold_type = 'labor' AND taxex IN ($taxids)";
$rs_find_cart_purt_refund = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE MONTH(date_sold) = '$month' AND YEAR(date_sold) = '$year' AND sold_type = 'refund' AND taxex IN ($taxids)";
$rs_find_cart_purt_refundlabor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE MONTH(date_sold) = '$month' AND YEAR(date_sold) = '$year' AND sold_type = 'refundlabor' AND taxex IN ($taxids)";
} else {
$rs_find_cart_purt_purchase = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalmonth[$month] AND taxex = '$rs_taxid3' AND sold_type = 'purchase' AND taxex IN ($taxids)";
$rs_find_cart_purt_labor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalmonth[$month] AND taxex = '$rs_taxid3' AND sold_type = 'labor' AND taxex IN ($taxids)";
$rs_find_cart_purt_refund = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalmonth[$month] AND taxex = '$rs_taxid3' AND sold_type = 'refund' AND taxex IN ($taxids)";
$rs_find_cart_purt_refundlabor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalmonth[$month] AND taxex = '$rs_taxid3' AND sold_type = 'refundlabor' AND taxex IN ($taxids)";
}

$rs_result_purt_purchase = mysqli_query($rs_connect, $rs_find_cart_purt_purchase);
$rs_result_pur_purchase_qt = mysqli_fetch_object($rs_result_purt_purchase);
$rs_totalsales_purchase = "$rs_result_pur_purchase_qt->total";
$salestaxrate = getsalestaxrate($rs_taxid3);
$rs_totaltax_purchase = tnv($rs_totalsales_purchase) * $salestaxrate;

$rs_result_purt_labor = mysqli_query($rs_connect, $rs_find_cart_purt_labor);
$rs_result_pur_labor_qt = mysqli_fetch_object($rs_result_purt_labor);
$rs_totalsales_labor = "$rs_result_pur_labor_qt->total";
$servicetaxrate = getservicetaxrate($rs_taxid3);
$rs_totaltax_labor = tnv($rs_totalsales_labor) * $servicetaxrate;

$rs_result_purt_refund = mysqli_query($rs_connect, $rs_find_cart_purt_refund);
$rs_result_pur_refund_qt = mysqli_fetch_object($rs_result_purt_refund);
$rs_totalsales_refund = "$rs_result_pur_refund_qt->total";
$rs_totaltax_refund = tnv($rs_totalsales_refund) * $salestaxrate;

$rs_result_purt_refundlabor = mysqli_query($rs_connect, $rs_find_cart_purt_refundlabor);
$rs_result_pur_refundlabor_qt = mysqli_fetch_object($rs_result_purt_refundlabor);
$rs_totalsales_refundlabor = "$rs_result_pur_refundlabor_qt->total";
$rs_totaltax_refundlabor = tnv($rs_totalsales_refundlabor) * $servicetaxrate;

$rs_taxtotal = $rs_totaltax_purchase + $rs_totaltax_labor;
$rs_taxtotalrefund = $rs_totaltax_refund + $rs_totaltax_refundlabor;

echo "<tr><td>$ycolor".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Collected").":</span> </td><td>$ycolor$money".mf("$rs_taxtotal")."</span></td></tr>";
echo "<tr><td>$ycolor".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Refunded").":</span> </td><td>$ycolor$money".mf("$rs_taxtotalrefund")."</span></td></tr>";

$rs_taxtotalcolminusrefund = $rs_taxtotal - $rs_taxtotalrefund;


echo "<tr><td>$ycolor".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax").":</span> </td><td>$ycolor$money".mf("$rs_taxtotalcolminusrefund")."</span></td></tr>";
echo "<tr><td>$ycolor".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Basis")." (".pcrtlang("purchases")."):</span> </td><td>$ycolor$money".mf("$rs_totalsales_purchase")."</span></td></tr>";
echo "<tr><td>$ycolor".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Basis")." (".pcrtlang("labor")."):</span> </td><td>$ycolor$money".mf("$rs_totalsales_labor")."</span></td></tr>";
echo "<tr><td>$ycolor".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Basis")." (".pcrtlang("sales refunds")."):</span> </td><td>$ycolor$money".mf("$rs_totalsales_refund")."</span></td></tr>";
echo "<tr><td>$ycolor".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Basis")." (".pcrtlang("labor refunds")."):</span> </td><td>$ycolor$money".mf("$rs_totalsales_refundlabor")."</span></td></tr>";

$rs_totalpur = tnv($rs_totalsales_purchase) - tnv($rs_totalsales_refund);
echo "<tr><td>$ycolor".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Basis")." (".pcrtlang("purchases")."-".pcrtlang("refunds")."):</span> </td><td>$ycolor$money".mf("$rs_totalpur")."</span></td></tr>";

$rs_totallabpur = ((tnv($rs_totalsales_purchase) + tnv($rs_totalsales_labor)) - (tnv($rs_totalsales_refund) + tnv($rs_totalsales_refundlabor)));
echo "<tr><td>$ycolor".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Basis")." (".pcrtlang("labor")."+".pcrtlang("purchases")."-".pcrtlang("sales refunds")."+".pcrtlang("labor refunds")."):</span> </td><td>$ycolor$money".mf("$rs_totallabpur")."</span></td></tr>";
echo "<tr><td colspan=2>&nbsp;</td></tr>";




}
echo "<tr><td colspan=2>&nbsp;</td></tr>";
$month++;

}
echo "</table>";

if(!isset($_REQUEST['printable'])) {
stop_box();
}

if(!isset($_REQUEST['printable'])) {
require("footer.php");
} else {
printablefooter();
}



}


########################################################################################################################


function taxreportnew_csv() {

if (array_key_exists('year',$_REQUEST)) {
if ($_REQUEST['year'] != "") {
$year = $_REQUEST['year'];
} else {
$year = date("Y");
}
} else {
$year = date("Y");
}

if (array_key_exists('month',$_REQUEST)) {
if ($_REQUEST['month'] != "") {
$qmonth = $_REQUEST['month'];
} else {
$qmonth = date("M");
}
} else {
$qmonth = date("M");
}

if (array_key_exists('fiscaldate',$_REQUEST)) {
$fiscaldate = $_REQUEST['fiscaldate'];
} else {
$fiscaldate = 0;
}

require_once("common.php");

require("deps.php");

perm_boot("5");

$csv = "\"".pcrtlang("Yearly Sales/Service Tax Report for")." $year\"\n\n";

if($fiscaldate) {
$csv .= "\"".pcrtlang("Fiscal Year Starting")." $year-$qmonth-01\"\n\n";
}





if($fiscaldate) {
$csv .= "\"".pcrtlang("Year Total for")." $year\"\n\n";
} else {
$csv .= "\"".pcrtlang("Year Total for Fiscal")." $year\"\n\n";
}


$rs_find_cart_tax = "SELECT * FROM taxes WHERE isgrouprate != '1'";
$rs_result_tax = mysqli_query($rs_connect, $rs_find_cart_tax);
while($rs_result_tax_q = mysqli_fetch_object($rs_result_tax)) {
$rs_taxid = "$rs_result_tax_q->taxid";
$rs_taxname = "$rs_result_tax_q->taxname";
$rs_taxenabled = "$rs_result_tax_q->taxenabled";

$groupsbelong = array();
$groupsbelong[] = "$rs_taxid";
$rs_ql_isingroup = "SELECT * FROM taxes WHERE isgrouprate = '1'";
$rs_result1_isingroup = mysqli_query($rs_connect, $rs_ql_isingroup);
while($rs_result_q1_isingroup = mysqli_fetch_object($rs_result1_isingroup)) {
$compositerate = "$rs_result_q1_isingroup->compositerate";
$gtaxid = "$rs_result_q1_isingroup->taxid";
$subarray = unserialize($compositerate);
if (in_array($rs_taxid,$subarray)) {
$groupsbelong[] = $gtaxid;
}
}

$taxids = implode(',',$groupsbelong); 

if(!$fiscaldate) {
$rs_find_cart_purt_purchase = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE YEAR(date_sold) = '$year' AND sold_type = 'purchase' AND taxex IN ($taxids)";
$rs_find_cart_purt_labor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE YEAR(date_sold) = '$year' AND sold_type = 'labor' AND taxex IN ($taxids)";
$rs_find_cart_purt_refund = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE YEAR(date_sold) = '$year' AND sold_type = 'refund' AND taxex IN ($taxids)";
$rs_find_cart_purt_refundlabor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE YEAR(date_sold) = '$year' AND sold_type = 'refundlabor' AND taxex IN ($taxids)";
} else {
$rs_find_cart_purt_purchase = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE date_sold >= '$year-$qmonth-01' AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 1 YEAR)) AND sold_type = 'purchase' AND taxex IN ($taxids)";
$rs_find_cart_purt_labor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE date_sold >= '$year-$qmonth-01' AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 1 YEAR)) AND sold_type = 'labor' AND taxex IN ($taxids)";
$rs_find_cart_purt_refund = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE date_sold >= '$year-$qmonth-01' AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 1 YEAR)) AND sold_type = 'refund' AND taxex IN ($taxids)";
$rs_find_cart_purt_refund = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE date_sold >= '$year-$qmonth-01' AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 1 YEAR)) AND sold_type = 'refundlabor' AND taxex IN ($taxids)";
}



$rs_result_purt_purchase = mysqli_query($rs_connect, $rs_find_cart_purt_purchase);
$rs_result_pur_purchase_qt = mysqli_fetch_object($rs_result_purt_purchase);
$rs_totalsales_purchase = "$rs_result_pur_purchase_qt->total";
$salestaxrate = getsalestaxrate($rs_taxid);
$rs_totaltax_purchase = tnv($rs_totalsales_purchase) * $salestaxrate;

$rs_result_purt_labor = mysqli_query($rs_connect, $rs_find_cart_purt_labor);
$rs_result_pur_labor_qt = mysqli_fetch_object($rs_result_purt_labor);
$rs_totalsales_labor = "$rs_result_pur_labor_qt->total";
$servicetaxrate = getservicetaxrate($rs_taxid);
$rs_totaltax_labor = tnv($rs_totalsales_labor) * $servicetaxrate;

$rs_result_purt_refund = mysqli_query($rs_connect, $rs_find_cart_purt_refund);
$rs_result_pur_refund_qt = mysqli_fetch_object($rs_result_purt_refund);
$rs_totalsales_refund = "$rs_result_pur_refund_qt->total";
$rs_totaltax_refund = tnv($rs_totalsales_refund) * $salestaxrate;

$rs_result_purt_refundlabor = mysqli_query($rs_connect, $rs_find_cart_purt_refundlabor);
$rs_result_pur_refundlabor_qt = mysqli_fetch_object($rs_result_purt_refundlabor);
$rs_totalsales_refundlabor = "$rs_result_pur_refundlabor_qt->total";
$rs_totaltax_refundlabor = tnv($rs_totalsales_refundlabor) * $servicetaxrate;


$rs_taxtotal = $rs_totaltax_purchase + $rs_totaltax_labor;
$rs_taxtotalrefund = $rs_totaltax_refund + $rs_totaltax_refundlabor;

$csv .= "\"$rs_taxname ".pcrtlang("Tax Collected").":\",\"".mf("$rs_taxtotal")."\"\n";
$csv .= "\"$rs_taxname ".pcrtlang("Tax Refunded").":\",\"".mf("$rs_taxtotalrefund")."\"\n";

$rs_taxtotalcolminusrefund = $rs_taxtotal - $rs_taxtotalrefund;

$csv .= "\"$rs_taxname ".pcrtlang("Tax").":\",\"".mf("$rs_taxtotalcolminusrefund")."\"\n";
$csv .= "\"$rs_taxname ".pcrtlang("Tax Basis")." (".pcrtlang("purchases")."):\",\"".mf("$rs_totalsales_purchase")."\"\n";
$csv .= "\"$rs_taxname ".pcrtlang("Tax Basis")." (".pcrtlang("labor")."):\",\"".mf("$rs_totalsales_labor")."\"\n";
$csv .= "\"$rs_taxname ".pcrtlang("Tax Basis")." (".pcrtlang("sales refunds")."):\",\"".mf("$rs_totalsales_refund")."\"\n";
$csv .= "\"$rs_taxname ".pcrtlang("Tax Basis")." (".pcrtlang("labor refunds")."):\",\"".mf("$rs_totalsales_refundlabor")."\"\n";

$rs_totalpur = tnv($rs_totalsales_purchase) - tnv($rs_totalsales_refund);

$csv .= "\"$rs_taxname ".pcrtlang("Tax Basis")." (".pcrtlang("purchases")."-".pcrtlang("sales refunds")."):\",\"".mf("$rs_totalpur")."\"\n";

$rs_totallabpur = ((tnv($rs_totalsales_purchase) + tnv($rs_totalsales_labor)) - (tnv($rs_totalsales_refund) + tnv($rs_totalsales_refundlabor)));

$csv .= "\"$rs_taxname ".pcrtlang("Tax Basis")." (".pcrtlang("labor")."+".pcrtlang("purchases")."-".pcrtlang("sales refunds")."+".pcrtlang("labor refunds")."):\",\"".mf("$rs_totallabpur")."\"\n";

}

###quarter

if(!$fiscaldate) {
$csv .= "\n\"".pcrtlang("Quarter Total for")." $year\"\n\n";
} else {
$csv .= "\n\"".pcrtlang("Quarter Total for Fiscal")." $year\"\n\n";
}

$fiscalquarter[1] = "date_sold >= '$year-$qmonth-01' AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 3 MONTH))";
$fiscalquarter[2] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 3 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 6 MONTH))";
$fiscalquarter[3] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 6 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 9 MONTH))";
$fiscalquarter[4] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 9 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 1 YEAR))";

$qrtr = 1;

while ($qrtr < 5) {

$rs_find_cart_tax2 = "SELECT * FROM taxes WHERE isgrouprate != '1'";
$rs_result_tax2 = mysqli_query($rs_connect, $rs_find_cart_tax2);

while($rs_result_tax_q2 = mysqli_fetch_object($rs_result_tax2)) {
$rs_taxid2 = "$rs_result_tax_q2->taxid";
$rs_taxname2 = "$rs_result_tax_q2->taxname";
$rs_taxenabled2 = "$rs_result_tax_q2->taxenabled";

$groupsbelong = array();
$groupsbelong[] = "$rs_taxid2";
$rs_ql_isingroup = "SELECT * FROM taxes WHERE isgrouprate = '1'";
$rs_result1_isingroup = mysqli_query($rs_connect, $rs_ql_isingroup);
while($rs_result_q1_isingroup = mysqli_fetch_object($rs_result1_isingroup)) {
$compositerate = "$rs_result_q1_isingroup->compositerate";
$gtaxid = "$rs_result_q1_isingroup->taxid";
$subarray = unserialize($compositerate);
if (in_array($rs_taxid2,$subarray)) {
$groupsbelong[] = $gtaxid;
}
}


$taxids = implode(',',$groupsbelong);

if(!$fiscaldate) {
$rs_find_cart_purt_purchase = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE QUARTER(date_sold) = '$qrtr' AND YEAR(date_sold) = '$year' AND sold_type = 'purchase' AND taxex IN ($taxids)";
$rs_find_cart_purt_labor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE QUARTER(date_sold) = '$qrtr' AND YEAR(date_sold) = '$year' AND sold_type = 'labor' AND taxex IN ($taxids)";
$rs_find_cart_purt_refund = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE QUARTER(date_sold) = '$qrtr' AND YEAR(date_sold) = '$year' AND sold_type = 'refund' AND taxex IN ($taxids)";
$rs_find_cart_purt_refundlabor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE QUARTER(date_sold) = '$qrtr' AND YEAR(date_sold) = '$year' AND sold_type = 'refundlabor' AND taxex IN ($taxids)";
} else {
$rs_find_cart_purt_purchase = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalquarter[$qrtr] AND sold_type = 'purchase' AND taxex IN ($taxids)";
$rs_find_cart_purt_labor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalquarter[$qrtr] AND sold_type = 'labor' AND taxex IN ($taxids)";
$rs_find_cart_purt_refund = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalquarter[$qrtr] AND sold_type = 'refund' AND taxex IN ($taxids)";
$rs_find_cart_purt_refundlabor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalquarter[$qrtr] AND sold_type = 'refundlabor' AND taxex IN ($taxids)";
}


$rs_result_purt_purchase = mysqli_query($rs_connect, $rs_find_cart_purt_purchase);
$rs_result_pur_purchase_qt = mysqli_fetch_object($rs_result_purt_purchase);
$rs_totalsales_purchase = "$rs_result_pur_purchase_qt->total";
$salestaxrate = getsalestaxrate($rs_taxid2);
$rs_totaltax_purchase = tnv($rs_totalsales_purchase) * $salestaxrate;

$rs_result_purt_labor = mysqli_query($rs_connect, $rs_find_cart_purt_labor);
$rs_result_pur_labor_qt = mysqli_fetch_object($rs_result_purt_labor);
$rs_totalsales_labor = "$rs_result_pur_labor_qt->total";
$servicetaxrate = getservicetaxrate($rs_taxid2);
$rs_totaltax_labor = tnv($rs_totalsales_labor) * $servicetaxrate;

$rs_result_purt_refund = mysqli_query($rs_connect, $rs_find_cart_purt_refund);
$rs_result_pur_refund_qt = mysqli_fetch_object($rs_result_purt_refund);
$rs_totalsales_refund = "$rs_result_pur_refund_qt->total";
$rs_totaltax_refund = tnv($rs_totalsales_refund) * $salestaxrate;

$rs_result_purt_refundlabor = mysqli_query($rs_connect, $rs_find_cart_purt_refundlabor);
$rs_result_pur_refundlabor_qt = mysqli_fetch_object($rs_result_purt_refundlabor);
$rs_totalsales_refundlabor = "$rs_result_pur_refundlabor_qt->total";
$rs_totaltax_refundlabor = tnv($rs_totalsales_refundlabor) * $servicetaxrate;


$rs_taxtotal = $rs_totaltax_purchase + $rs_totaltax_labor;
$rs_taxtotalrefund = $rs_totaltax_refund + $rs_totaltax_refundlabor;



$csv .= "\"".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Collected").":\",\"".mf("$rs_taxtotal")."\"\n";
$csv .= "\"".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Refunded").":\",\"".mf("$rs_totaltax_refund")."\"\n";

$rs_taxtotalcolminusrefund = $rs_taxtotal - $rs_taxtotalrefund;

$csv .= "\"".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax").":\",\"".mf("$rs_taxtotalcolminusrefund")."\"\n";

$csv .= "\"".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Basis")." (".pcrtlang("purchases")."):\",\"".mf("$rs_totalsales_purchase")."\"\n";
$csv .= "\"".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Basis")." (".pcrtlang("labor")."):\",\"".mf("$rs_totalsales_labor")."\"\n";
$csv .= "\"".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Basis")." (".pcrtlang("sales refunds")."):\",\"".mf("$rs_totalsales_refund")."\"\n";
$csv .= "\"".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Basis")." (".pcrtlang("labor refunds")."):\",\"".mf("$rs_totalsales_refundlabor")."\"\n";

$rs_totalpur = tnv($rs_totalsales_purchase) - tnv($rs_totalsales_refund);

$csv .= "\"".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Basis")." (".pcrtlang("purchases")."-".pcrtlang("sales refunds")."):\",\"".mf("$rs_totalpur")."\"\n";

$rs_totallabpur = ((tnv($rs_totalsales_purchase) + tnv($rs_totalsales_labor)) - (tnv($rs_totalsales_refund) + tnv($rs_totalsales_refundlabor)));

$csv .= "\"".pcrtlang("Quarter")." #$qrtr $rs_taxname2 ".pcrtlang("Tax Basis")." (".pcrtlang("labor")."+".pcrtlang("purchases")."-".pcrtlang("sales refunds")."+".pcrtlang("labor refunds")."):\",\"".mf("$rs_totallabpur")."\"\n";



}

$qrtr++;

}





####month

if(!$fiscaldate) {
$csv .= "\n\"".pcrtlang("Monthly Totals for")." $year\"\n\n";
} else {
$csv .= "\n\"".pcrtlang("Monthly Totals for Fiscal")." $year\"\n\n";
}

$fiscalmonth[1] = "date_sold >= '$year-$qmonth-01' AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 1 MONTH))";
$fiscalmonth[2] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 1 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 2 MONTH))";
$fiscalmonth[3] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 2 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 3 MONTH))";
$fiscalmonth[4] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 3 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 4 MONTH))";
$fiscalmonth[5] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 4 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 5 MONTH))";
$fiscalmonth[6] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 5 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 6 MONTH))";
$fiscalmonth[7] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 6 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 7 MONTH))";
$fiscalmonth[8] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 7 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 8 MONTH))";
$fiscalmonth[9] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 8 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 9 MONTH))";
$fiscalmonth[10] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 9 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 10 MONTH))";
$fiscalmonth[11] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 10 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 11 MONTH))";
$fiscalmonth[12] = "date_sold >= (DATE_ADD('$year-$qmonth-01', INTERVAL 11 MONTH)) AND date_sold < (DATE_ADD('$year-$qmonth-01', INTERVAL 12 MONTH))";


$month = 1;

while ($month < 13) {

$rs_find_cart_tax3 = "SELECT * FROM taxes WHERE isgrouprate != '1'";
$rs_result_tax3 = mysqli_query($rs_connect, $rs_find_cart_tax3);

while($rs_result_tax_q3 = mysqli_fetch_object($rs_result_tax3)) {
$rs_taxid3 = "$rs_result_tax_q3->taxid";
$rs_taxname3 = "$rs_result_tax_q3->taxname";
$rs_taxenabled3 = "$rs_result_tax_q3->taxenabled";

$groupsbelong = array();
$groupsbelong[] = "$rs_taxid3";
$rs_ql_isingroup = "SELECT * FROM taxes WHERE isgrouprate = '1'";
$rs_result1_isingroup = mysqli_query($rs_connect, $rs_ql_isingroup);
while($rs_result_q1_isingroup = mysqli_fetch_object($rs_result1_isingroup)) {
$compositerate = "$rs_result_q1_isingroup->compositerate";
$gtaxid = "$rs_result_q1_isingroup->taxid";
$subarray = unserialize($compositerate);
if (in_array($rs_taxid3,$subarray)) {
$groupsbelong[] = $gtaxid;
}
}

$taxids = implode(',',$groupsbelong);

if(!$fiscaldate) {
$rs_find_cart_purt_purchase = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE MONTH(date_sold) = '$month' AND YEAR(date_sold) = '$year' AND sold_type = 'purchase' AND taxex IN ($taxids)";
$rs_find_cart_purt_labor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE MONTH(date_sold) = '$month' AND YEAR(date_sold) = '$year' AND sold_type = 'labor' AND taxex IN ($taxids)";
$rs_find_cart_purt_refund = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE MONTH(date_sold) = '$month' AND YEAR(date_sold) = '$year' AND sold_type = 'refund' AND taxex IN ($taxids)";
$rs_find_cart_purt_refundlabor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE MONTH(date_sold) = '$month' AND YEAR(date_sold) = '$year' AND sold_type = 'refundlabor' AND taxex IN ($taxids)";
} else {
$rs_find_cart_purt_purchase = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalmonth[$month] AND taxex = '$rs_taxid3' AND sold_type = 'purchase' AND taxex IN ($taxids)";
$rs_find_cart_purt_labor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalmonth[$month] AND taxex = '$rs_taxid3' AND sold_type = 'labor' AND taxex IN ($taxids)";
$rs_find_cart_purt_refund = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalmonth[$month] AND taxex = '$rs_taxid3' AND sold_type = 'refund' AND taxex IN ($taxids)";
$rs_find_cart_purt_refundlabor = "SELECT SUM(sold_price) AS total FROM `sold_items` WHERE $fiscalmonth[$month] AND taxex = '$rs_taxid3' AND sold_type = 'refundlabor' AND taxex IN ($taxids)";
}

$rs_result_purt_purchase = mysqli_query($rs_connect, $rs_find_cart_purt_purchase);
$rs_result_pur_purchase_qt = mysqli_fetch_object($rs_result_purt_purchase);
$rs_totalsales_purchase = "$rs_result_pur_purchase_qt->total";
$salestaxrate = getsalestaxrate($rs_taxid3);
$rs_totaltax_purchase = tnv($rs_totalsales_purchase) * $salestaxrate;

$rs_result_purt_labor = mysqli_query($rs_connect, $rs_find_cart_purt_labor);
$rs_result_pur_labor_qt = mysqli_fetch_object($rs_result_purt_labor);
$rs_totalsales_labor = "$rs_result_pur_labor_qt->total";
$servicetaxrate = getservicetaxrate($rs_taxid3);
$rs_totaltax_labor = tnv($rs_totalsales_labor) * $servicetaxrate;

$rs_result_purt_refund = mysqli_query($rs_connect, $rs_find_cart_purt_refund);
$rs_result_pur_refund_qt = mysqli_fetch_object($rs_result_purt_refund);
$rs_totalsales_refund = "$rs_result_pur_refund_qt->total";
$rs_totaltax_refund = tnv($rs_totalsales_refund) * $salestaxrate;

$rs_result_purt_refundlabor = mysqli_query($rs_connect, $rs_find_cart_purt_refundlabor);
$rs_result_pur_refundlabor_qt = mysqli_fetch_object($rs_result_purt_refundlabor);
$rs_totalsales_refundlabor = "$rs_result_pur_refundlabor_qt->total";
$rs_totaltax_refundlabor = tnv($rs_totalsales_refundlabor) * $servicetaxrate;


$rs_taxtotal = $rs_totaltax_purchase + $rs_totaltax_labor;
$rs_taxtotalrefund = $rs_totaltax_refund + $rs_totaltax_refundlabor;

$csv .= "\"".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Collected").":\",\"".mf("$rs_taxtotal")."\"\n";
$csv .= "\"".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Refunded").":\",\"".mf("$rs_totaltax_refundlabor")."\"\n";

$rs_taxtotalcolminusrefund = $rs_taxtotal - $rs_taxtotalrefund;

$csv .= "\"".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax").":\",\"".mf("$rs_taxtotalcolminusrefund")."\"\n";
$csv .= "\"".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Basis")." (".pcrtlang("purchases")."):\",\"".mf("$rs_totalsales_purchase")."\"\n";
$csv .= "\"".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Basis")." (".pcrtlang("labor")."):\",\"".mf("$rs_totalsales_labor")."\"\n";
$csv .= "\"".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Basis")." (".pcrtlang("sales refunds")."):\",\"".mf("$rs_totalsales_refund")."\"\n";
$csv .= "\"".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Basis")." (".pcrtlang("labor refunds")."):\",\"".mf("$rs_totalsales_refundlabor")."\"\n";

$rs_totalpur = tnv($rs_totalsales_purchase) - tnv($rs_totalsales_refund);

$csv .= "\"".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Basis")." (".pcrtlang("purchases")."-".pcrtlang("refunds")."):\",\"".mf("$rs_totalpur")."\"\n";

$rs_totallabpur = ((tnv($rs_totalsales_purchase) + tnv($rs_totalsales_labor)) - (tnv($rs_totalsales_refund) + tnv($rs_totalsales_refundlabor)));

$csv .= "\"".pcrtlang("Month")." #$month $rs_taxname3 ".pcrtlang("Tax Basis")." (".pcrtlang("labor")."+".pcrtlang("purchases")."-".pcrtlang("sales refunds")."+".pcrtlang("labor refunds")."):\",\"".mf("$rs_totallabpur")."\"\n";



}
$month++;

}

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"tax_report_$year.csv\"");
echo $csv;


}




###############
function user_act_report() {

if (array_key_exists('dayto',$_REQUEST)) {
if ($_REQUEST['dayto'] != "") {
$dayto = $_REQUEST['dayto'];
} else {
$dayto = date("Y-m-d");
}
} else {
$dayto = date("Y-m-d");
}

if (array_key_exists('dayfrom',$_REQUEST)) {
if ($_REQUEST['dayfrom'] != "") {
$dayfrom = $_REQUEST['dayfrom'];
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}

                                                                                                                   
require_once("header.php");

perm_boot("7");
                                                                                                                                           
require("deps.php");

start_box();
echo "<span class=sizemelarger>".pcrtlang("Technician Activity Report for")." $dayfrom ".pcrtlang("to")." $dayto</span><br><br>";





$findmax = "SELECT COUNT(*) AS themax FROM userlog WHERE thedatetime <= '$dayto 23:59:59' AND thedatetime  >= '$dayfrom 00:00:00' GROUP BY loggeduser,actionid ORDER BY themax DESC LIMIT 1";
$rs_result_max = mysqli_query($rs_connect, $findmax);
$rs_result_max_q = mysqli_fetch_object($rs_result_max);
$themax = "$rs_result_max_q->themax";
if($themax != "0") {
$themulty = (75 / $themax);
} else {
$themulty = 1;
}

$loggedactions2 = array(
"1" => pcrtlang("Created a New Work Order"),
"2" => pcrtlang("Checked Out a Work Order"),
"3" => pcrtlang("Recorded a Scan, Install, Action, or Note"),
"4" => pcrtlang("Saved Customer or Technician Notes"),
"5" => pcrtlang("Printed Customer Repair Sheet"),
"6" => pcrtlang("Emailed Customer Repair Sheet"),
"7" => pcrtlang("Uploaded Asset Photo"),
"8" => pcrtlang("Created Repair Invoice"),
"9" => pcrtlang("Completed Sale"),
"10" => pcrtlang("Created Invoice"),
"11" => pcrtlang("Changed Customer Call Status"),
"12" => pcrtlang("Emailed Claim Ticket"),
"13" => pcrtlang("Printed Claim Ticket"),
"14" => pcrtlang("Sent SMS Message"),
"15" => pcrtlang("Emailed Invoice"),
"16" => pcrtlang("Edited Invoice"),
"17" => pcrtlang("Created Quote"),
"18" => pcrtlang("Edited Quote"),
"19" => pcrtlang("Emailed Quote"),
"20" => pcrtlang("Created Repair Quote"),
"21" => pcrtlang("Printed or Viewed Invoice"),
"22" => pcrtlang("Printed Quote"),
"24" => pcrtlang("Printed Thank You Letter"),
"25" => pcrtlang("Emailed Thank You Letter"),
"26" => pcrtlang("Uploaded an Attachment"),
"27" => pcrtlang("Emailed Receipt"),
"28" => pcrtlang("Viewed or Printed Receipt"),
"29" => pcrtlang("Created Recurring Invoice"),
"30" => pcrtlang("Logged In"),
"32" => pcrtlang("Changed Work Order Status"),
"33" => pcrtlang("Added Service Reminder"),
"34" => pcrtlang("Emailed Service Reminder"),
"35" => pcrtlang("Printed Service Reminder")
);



reset($loggedactions2);
echo "<table width=100%>";
foreach($loggedactions2 as $key => $val) {

echo "<tr><td><span class=boldme>".pcrtlang("Action").": $val</span></td></tr>";

$rs_find_users = "SELECT * FROM users"; 
$rs_result_users = mysqli_query($rs_connect, $rs_find_users);
while($rs_result_users_q = mysqli_fetch_object($rs_result_users)) {
$theuser = "$rs_result_users_q->username";


$rs_find_cart_pur = "SELECT * FROM userlog WHERE actionid = '$key' AND thedatetime <= '$dayto 23:59:59' AND thedatetime  >= '$dayfrom 00:00:00' AND loggeduser = '$theuser'";
$rs_result_pur = mysqli_query($rs_connect, $rs_find_cart_pur);

$thesum = mysqli_num_rows($rs_result_pur);
if ($thesum == "0") {
$thewidth = .5;
} else {
$thewidth = floor($thesum * $themulty);
}

echo "<tr><td><div class=gbarorange style=\"width:$thewidth"."%\"></div>";
echo " $thesum $theuser</td></tr>";
}
echo "<tr><td>&nbsp;</td></tr>";
}

echo "</table>";
echo "<br><br>";


require("footer.php");
}
#######

function user_log_report() {

$day = $_REQUEST['day'];
$theuser = $_REQUEST['theuser'];

                                                                                                                                               
require_once("header.php");

$plusday = date("Y-m-d", (strtotime("$day") + 86400));                 
$minusday = date("Y-m-d", (strtotime("$day") - 86400));

start_box();
echo "<h3><a href=reports.php?func=user_log_report&day=$minusday&theuser=$theuser class=imagelink><img src=images/left.png border=0 align=absmiddle></a> ".pcrtlang("Report for")." $theuser ".pcrtlang("on")." $day <a href=reports.php?func=user_log_report&day=$plusday&theuser=$theuser class=imagelink><img src=images/right.png border=0 align=absmiddle></a></h3>";
require("deps.php");




echo "<form action=reports.php?func=user_log_report method=post><input class=button type=submit value=\"".pcrtlang("Switch User")."\">";
echo "<input type=hidden name=day value=\"$day\">";
echo "<select name=theuser onchange='this.form.submit()'>";
$rs_find_users = "SELECT * FROM users WHERE username != 'admin'";
$rs_result_users = mysqli_query($rs_connect, $rs_find_users);
while($rs_result_users_q = mysqli_fetch_object($rs_result_users)) {
$theusersw = "$rs_result_users_q->username";
if ("$theuser" == "$theusersw") {
echo "<option value=\"$theusersw\" selected>$theusersw</option>";
} else {
echo "<option value=\"$theusersw\">$theusersw</option>";
}

}
echo "</select></form>";



$rs_find_cart_items = "SELECT * FROM userlog WHERE thedatetime LIKE '$day%' AND loggeduser = '$theuser' ORDER BY thedatetime ASC ";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

if((mysqli_num_rows($rs_result)) == "0") {
echo "<br><span class=\"colormegray italme\">".pcrtlang("No Results Found for")." $day</span>";
}      
              
echo "<table class=standard>";
                                                                                                                           
while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_actionid = "$rs_result_q->actionid";                                                                                                         
$rs_thedatetime2 = "$rs_result_q->thedatetime";
$rs_thedatetime = (date("g:i:s A", strtotime("$rs_thedatetime2")));
$rs_refid = "$rs_result_q->refid";
$reftype = "$rs_result_q->reftype";
$mensaje = "$rs_result_q->mensaje";

if($reftype == "woid") {
$link = "".pcrtlang("on Work Order").": #<a href=../repair/index.php?pcwo=$rs_refid class=\"linkbuttontiny linkbuttongray radiusall\">$rs_refid</a>";
} elseif ($reftype == "pcid") {
$link = "".pcrtlang("on PC ID").": #<a href=../repair/pc.php?func=showpc&pcid=$rs_refid class=\"linkbuttontiny linkbuttongray radiusall\">$rs_refid</a>";
} elseif ($reftype == "invoiceid") {
$link = "".pcrtlang("on Invoice").": #<a href=../store/invoice.php?func=printinv&invoice_id=$rs_refid class=\"linkbuttontiny linkbuttongray radiusall\">$rs_refid</a>";
} elseif ($reftype == "rinvoiceid") {
$link = "".pcrtlang("on Recurring Invoice").": #<a href=../store/rinvoice.php?func=viewrinvoice&rinvoice_id=$rs_refid class=\"linkbuttontiny linkbuttongray radiusall\">$rs_refid</a>";
} elseif ($reftype == "receiptid") {
$link = "".pcrtlang("on Receipt").": #<a href=../store/receipt.php?func=show_receipt&receipt=$rs_refid class=\"linkbuttontiny linkbuttongray radiusall\">$rs_refid</a>";
} elseif ($reftype == "groupid") {
$link = "".pcrtlang("on Group").": #<a href=../repair/group.php?func=viewgroup&pcgroupid=$rs_refid class=\"linkbuttontiny linkbuttongray radiusall\">$rs_refid</a>";
} else {
$link = "";
}

echo "<tr><td style=\"white-space:nowrap\">$rs_thedatetime</td><td>$loggedactions[$rs_actionid] $link | $mensaje</td></tr>";

}


echo "</table>";


stop_box();

require("footer.php");

}


function customer_source_report() {

if (array_key_exists('dayto',$_REQUEST)) {
if ($_REQUEST['dayto'] != "") {
$dayto = $_REQUEST['dayto'];
} else {
$dayto = date("Y-m-d");
}
} else {
$dayto = date("Y-m-d");
}

if (array_key_exists('dayfrom',$_REQUEST)) {
if ($_REQUEST['dayfrom'] != "") {
$dayfrom = $_REQUEST['dayfrom'];
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}


require_once("header.php");

perm_boot("9");

require("deps.php");

start_box();
echo "<span class=sizemelarger>".pcrtlang("Customer Source Report for")." $dayfrom ".pcrtlang("to")." $dayto</span><br><br>";





$arrayofcs = array();

$rs_find_cst = "SELECT custsourceid FROM custsource WHERE showonreport != '0' AND sourceenabled != '0'";
$rs_result_cst = mysqli_query($rs_connect, $rs_find_cst);
while($rs_result_qcst = mysqli_fetch_object($rs_result_cst)) {
$jamit = "$rs_result_qcst->custsourceid";
$arrayofcs[$jamit] = 0;
}


$rs_find_current_woid = "SELECT MIN(woid), pcid FROM pc_wo WHERE dropdate <= '$dayto 23:59:59' AND dropdate  >= '$dayfrom 00:00:00' GROUP BY pcid";
$rs_result_pur = mysqli_query($rs_connect, $rs_find_current_woid);
while($rs_result_q = mysqli_fetch_object($rs_result_pur)) {
$rs_pcid = "$rs_result_q->pcid";


$rs_find_cs = "SELECT custsourceid FROM pc_owner WHERE pcid = '$rs_pcid' AND custsourceid != '0'";
$rs_result_cs = mysqli_query($rs_connect, $rs_find_cs);
while($rs_result_qcs = mysqli_fetch_object($rs_result_cs)) {
$custsourceid = "$rs_result_qcs->custsourceid";
if(array_key_exists("$custsourceid",$arrayofcs)) {
$arrayofcs[$custsourceid] = ($arrayofcs[$custsourceid] + 1);
}
}

}


$maxcount = max($arrayofcs);
if ($maxcount != 0) {
$multy = (90 / $maxcount);
} else {
$multy = 5;
}

arsort($arrayofcs);

foreach($arrayofcs as $key => $val) {

$rs_find_cst2 = "SELECT * FROM custsource WHERE custsourceid = '$key'";
$rs_result_cst2 = mysqli_query($rs_connect, $rs_find_cst2);
$rs_result_qcst2 = mysqli_fetch_object($rs_result_cst2);
$thesource = "$rs_result_qcst2->thesource";
$sourceicon = "$rs_result_qcst2->sourceicon";

if ($val == "0") {
$thewidth = 1;
} else {
$thewidth = floor($multy * $val);
}

echo "<img src=../repair/images/custsources/$sourceicon align=absmiddle> <span class=sizemelarge>$thesource: $val</span><br>";
echo "<div style=\"width:$thewidth"."%\" class=gbarorange></div><br><br>";

}


require("footer.php");
}



function service_type_report() {

if (array_key_exists('dayto',$_REQUEST)) {
if ($_REQUEST['dayto'] != "") {
$dayto = $_REQUEST['dayto'];
} else {
$dayto = date("Y-m-d");
}
} else {
$dayto = date("Y-m-d");
}

if (array_key_exists('dayfrom',$_REQUEST)) {
if ($_REQUEST['dayfrom'] != "") {
$dayfrom = $_REQUEST['dayfrom'];
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}


require_once("header.php");

perm_boot("9");

require("deps.php");

start_box();
echo "<span class=sizemelarger>".pcrtlang("Service Type Sales Report for")." $dayfrom ".pcrtlang("to")." $dayto (".pcrtlang("All Stores").")</span><br><br>";



$theservice = array();
$servicetotal = array();

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.2/Chart.bundle.min.js"></script>
<canvas id="BarChart" width="800" height="500"></canvas>
<?php

$rs_find_current_woid = "SELECT SUM(sold_price) AS soldtotal, COUNT(sold_price) AS servicecount, labor_desc FROM sold_items WHERE date_sold <= '$dayto 23:59:59' AND date_sold  >= '$dayfrom 00:00:00' AND sold_type = 'labor' GROUP BY labor_desc ORDER BY soldtotal DESC LIMIT 20";
$rs_result_pur = mysqli_query($rs_connect, $rs_find_current_woid);

echo "<table class=standard>";
echo "<tr><th style=\"text-align:center\">".pcrtlang("Service Count")."</th><th>".pcrtlang("Service Description")."</th><th>".pcrtlang("Average Service Price")."</th><th>".pcrtlang("Total Sales")."</th></tr>";

while($rs_result_q = mysqli_fetch_object($rs_result_pur)) {
$soldtotal = "$rs_result_q->soldtotal";
$labor_desc = "$rs_result_q->labor_desc";
$servicecount = "$rs_result_q->servicecount";

$averagesaleprice = $soldtotal / $servicecount;

if($servicecount > 1) {
echo "<tr><td style=\"text-align:center\">$servicecount</td><td>$labor_desc</td><td style=\"text-align:right\">$money".mf("$averagesaleprice")."</td><td style=\"text-align:right\">$money".mf("$soldtotal")."</td></tr>";

$theservice[] = $labor_desc;
$servicetotal[] = $soldtotal;

}


}
echo "</table>";

$theservicejson = json_encode($theservice);
$servicetotaljson = json_encode($servicetotal);

?>


<script>

var data = {
    labels: <?php echo $theservicejson; ?>,
    datasets: [
        {
            label: "<?php echo pcrtlang("Service Type Sales Report"); ?>",
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1,
            data: <?php echo $servicetotaljson; ?>,
        }
    ]
};

var ctx = document.getElementById("BarChart");
var BarChart = new Chart(ctx, {
    type: 'horizontalBar',
    data: data,
options: {
        responsive: false
    }
});


</script>
<?php

require("footer.php");
}






function emaillist() {
require_once("validate.php");

require("deps.php");

require_once("common.php");
perm_boot("10");

echo "<pre>".pcrtlang("Email List").":\n\n\n";





$rs_show_email = "SELECT DISTINCT(pcemail) FROM pc_owner WHERE pcemail != ''";
$rs_email_result = mysqli_query($rs_connect, $rs_show_email);
while($rs_email_result_q = mysqli_fetch_object($rs_email_result)) {
$rs_email = "$rs_email_result_q->pcemail";
echo "$rs_email\n";

}

echo "</pre>";

}


function customers_csv() {

require_once("common.php");

require("deps.php");

perm_boot("10");

$csv = "\"".pcrtlang("PC ID")."\",\"".pcrtlang("Customer Name")."\",\"".pcrtlang("PC Make")."\",\"$pcrt_address1\",\"$pcrt_address2\",\"$pcrt_city\",\"$pcrt_state\",\"$pcrt_zip\",\"".pcrtlang("Email")."\",\"".pcrtlang("Phone")."\",\"".pcrtlang("Mobile Phone")."\",\"".pcrtlang("Work Phone")."\"\n";





$rs_find_customers = "SELECT * FROM pc_owner";
$rs_result_total = mysqli_query($rs_connect, $rs_find_customers);

while($rs_result_q = mysqli_fetch_object($rs_result_total)) {
$pcid = "$rs_result_q->pcid";
$rs_pcname = "$rs_result_q->pcname";
$rs_pcmake = "$rs_result_q->pcmake";
$rs_pcphone = "$rs_result_q->pcphone";
$rs_pccellphone = "$rs_result_q->pccellphone";
$rs_pcworkphone = "$rs_result_q->pcworkphone";
$rs_pcemail = "$rs_result_q->pcemail";
$rs_pcaddress = "$rs_result_q->pcaddress";
$rs_pcaddress2 = "$rs_result_q->pcaddress2";
$rs_pccity = "$rs_result_q->pccity";
$rs_pcstate = "$rs_result_q->pcstate";
$rs_pczip = "$rs_result_q->pczip";

$csv .= "\"$pcid\",\"$rs_pcname\",\"$rs_pcmake\",\"$rs_pcaddress\",\"$rs_pcaddress2\",\"$rs_pccity\",\"$rs_pcstate\",\"$rs_pczip\",\"$rs_pcemail\",\"$rs_pcphone\",\"$rs_pccellphone\",\"$rs_pcworkphone\"\n";

}

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"customers.csv\"");
echo $csv;

}


function groupcustomers_csv() {

require_once("common.php");

require("deps.php");

perm_boot("10");

$csv = "\"".pcrtlang("Group ID")."\",\"".pcrtlang("Customer Name")."\",\"$pcrt_address1\",\"$pcrt_address2\",\"$pcrt_city\",\"$pcrt_state\",\"$pcrt_zip\",\"".pcrtlang("Email")."\",\"".pcrtlang("Home Phone")."\",\"".pcrtlang("Mobile Phone")."\",\"".pcrtlang("Work Phone")."\"\n";





$rs_find_customers = "SELECT * FROM pc_group";
$rs_result_total = mysqli_query($rs_connect, $rs_find_customers);

while($rs_result_q = mysqli_fetch_object($rs_result_total)) {
$pcid = "$rs_result_q->pcgroupid";
$rs_pcname = "$rs_result_q->pcgroupname";
$rs_pcphone = "$rs_result_q->grpphone";
$rs_pccellphone = "$rs_result_q->grpcellphone";
$rs_pcworkphone = "$rs_result_q->grpworkphone";
$rs_pcemail = "$rs_result_q->grpemail";
$rs_pcaddress = "$rs_result_q->grpaddress1";
$rs_pcaddress2 = "$rs_result_q->grpaddress2";
$rs_pccity = "$rs_result_q->grpcity";
$rs_pcstate = "$rs_result_q->grpstate";
$rs_pczip = "$rs_result_q->grpzip";

$csv .= "\"$pcid\",\"$rs_pcname\",\"$rs_pcaddress\",\"$rs_pcaddress2\",\"$rs_pccity\",\"$rs_pcstate\",\"$rs_pczip\",\"$rs_pcemail\",\"$rs_pcphone\",\"$rs_pccellphone\",\"$rs_pcworkphone\"\n";

}

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"groupcustomers.csv\"");
echo $csv;

}





function tech_day_span_report() {


require_once("deps.php");
require_once("common.php");
perm_boot("7");

if (array_key_exists('dayto',$_REQUEST)) {
if ($_REQUEST['dayto'] != "") {
$dayto = $_REQUEST['dayto'];
} else {
$dayto = date("Y-m-d");
}
} else {
$dayto = date("Y-m-d");
}

if (array_key_exists('dayfrom',$_REQUEST)) {
if ($_REQUEST['dayfrom'] != "") {
$dayfrom = $_REQUEST['dayfrom'];
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}

$reportstoreid = $_REQUEST['reportstoreid'];
$thetech = $_REQUEST['thetech'];

if(!isset($_REQUEST['printable'])) {
require_once("header.php");
} else {
printableheader(pcrtlang("Technician Report"));
}


if(!isset($_REQUEST['printable'])) {
start_box();
}

echo "<table width=100%><tr><td width=75%>";

echo "<span class=sizemelarger>".pcrtlang("Report for")." $dayfrom ".pcrtlang("to")." $dayto</span><br><br><span class=sizemelarge>".pcrtlang("for Technician").": $thetech</span><br><br>";

if ($activestorecount > 1) {
if ("$reportstoreid" == "all") {
echo "<span class=sizemelarge>".pcrtlang("Store").": ".pcrtlang("All Stores")."</span><br><br>";
} else {
$storeinfoarray = getstoreinfo($reportstoreid);
echo "<span class=sizemelarge>".pcrtlang("Store").": $storeinfoarray[storesname]</span><br><br>";
}
}


echo "</td><td width=25% align=right>";

if(!isset($_REQUEST['printable'])) {
echo "<a href=reports.php?func=tech_day_span_report&dayto=$dayto&dayfrom=$dayfrom&printable=yes&reportstoreid=$reportstoreid&thetech=$thetech class=linkbutton><img src=images/print.png align=absmiddle border=0> ".pcrtlang("Printable")."</a>";
}


echo "</td></tr></table>";


echo "<table class=\"standard lastalignright\">";
echo "<tr><th colspan=2>".pcrtlang("Sales")."</th></tr>";



if ("$reportstoreid" == "all") {
$rs_find_cart_pur = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='purchase' AND sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold  >= '$dayfrom 00:00:00' AND receipts.byuser = '$thetech' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_cart_pur = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='purchase' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold  >= '$dayfrom 00:00:00' AND receipts.byuser = '$thetech'";
}
$rs_result_pur = mysqli_query($rs_connect, $rs_find_cart_pur);
while($rs_result_pur_q = mysqli_fetch_object($rs_result_pur)) {
$rs_purtotal = "$rs_result_pur_q->total";
echo "<tr><td>".pcrtlang("Total Purchases").":</td><td>$money".mf("$rs_purtotal")."</td></tr>";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_lab = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type = 'labor' AND sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND receipts.byuser = '$thetech' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_cart_lab = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type = 'labor' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND receipts.byuser = '$thetech'";
}
$rs_result_lab = mysqli_query($rs_connect, $rs_find_cart_lab);
while($rs_result_lab_q = mysqli_fetch_object($rs_result_lab)) {
$rs_labtotal = "$rs_result_lab_q->total";
echo "<tr><td>".pcrtlang("Total Labor").":</td><td>$money".mf("$rs_labtotal")."</td></tr>";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_ref = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='refund' AND sold_items.date_sold <= '
$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND receipts.byuser = '$thetech' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_cart_ref = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='refund' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.date_sold <= '$dayto 23:59:59' AND  sold_items.date_sold >= '$dayfrom 00:00:00' AND receipts.byuser = '$thetech'";
}
$rs_result_ref = mysqli_query($rs_connect, $rs_find_cart_ref);
while($rs_result_ref_q = mysqli_fetch_object($rs_result_ref)) {
$rs_reftotal = "$rs_result_ref_q->total";
echo "<tr><td>".pcrtlang("Total Sales Refunds").":</td><td>$money".mf("$rs_reftotal")."</td></tr>";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_refl = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='refundlabor' AND sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND receipts.byuser = '$thetech' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_cart_refl = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type='refundlabor' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.date_sold <= '$dayto 23:59:59' AND  sold_items.date_sold >= '$dayfrom 00:00:00' AND receipts.byuser = '$thetech'";
}
$rs_result_refl = mysqli_query($rs_connect, $rs_find_cart_refl);
while($rs_result_refl_q = mysqli_fetch_object($rs_result_refl)) {
$rs_refltotal = "$rs_result_refl_q->total";
echo "<tr><td>".pcrtlang("Total Labor Refunds").":</td><td>$money".mf("$rs_refltotal")."</td></tr>";
}



if ("$reportstoreid" == "all") {
$rs_find_cart_refx = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts WHERE sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND sold_items.sold_type != 'refund' AND receipts.byuser = '$thetech' AND sold_items.receipt = receipts.receipt_id";
} else {
$rs_find_cart_refx = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts WHERE receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.date_sold <= '$dayto 23:59:59' AND  sold_items.date_sold >= '$dayfrom 00:00:00' AND sold_items.sold_type != 'refund' AND receipts.byuser = '$thetech'";
}
$rs_result_refx = mysqli_query($rs_connect, $rs_find_cart_refx);
while($rs_result_ref_qx = mysqli_fetch_object($rs_result_refx)) {
$rs_totaltax = "$rs_result_ref_qx->total";
echo "<tr><td>".pcrtlang("Total Sales/Service Tax Collected").":</td><td>$money".mf("$rs_totaltax")."</td></tr>";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_refxr = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts WHERE sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND receipts.byuser = '$thetech' AND sold_items.receipt = receipts.receipt_id AND (sold_items.sold_type = 'refund' OR sold_items.sold_type = 'refundlabor')";
} else {
$rs_find_cart_refxr = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts WHERE receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND receipts.byuser = '$thetech' AND (sold_items.sold_type = 'refund' OR sold_items.sold_type = 'refundlabor')";
}
$rs_result_refxr = mysqli_query($rs_connect, $rs_find_cart_refxr);
while($rs_result_ref_qxr = mysqli_fetch_object($rs_result_refxr)) {
$rs_totaltaxr = "$rs_result_ref_qxr->total";
echo "<tr><td>".pcrtlang("Total Sales/Service Tax Refunded").":</td><td>$money".mf("$rs_totaltaxr")."</td></tr>";
}



$totalgross = ((tnv($rs_purtotal) + tnv($rs_labtotal)) - (tnv($rs_reftotal) + tnv($rs_refltotal)));
echo "<tr><td>".pcrtlang("Gross Total")."<br><span class=sizeme10>(".pcrtlang("Taxable + Non-Taxable Sales &amp; Labor/Not Including Tax")."):</span></td><td>$money".mf("$totalgross")."</td></tr>";
            

$totaltax = tnv($rs_totaltax) - tnv($rs_totaltaxr);
echo "<tr><td>".pcrtlang("Tax Total less Refunded Tax").":</td><td>$money".mf("$totaltax")."</td></tr>";



#####

if ("$reportstoreid" == "all") {
$rs_find_op = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id AND receipts.byuser = '$thetech'";
} else {
$rs_find_op = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$reportstoreid' AND receipts.byuser = '$thetech'";
}
$rs_result_op = mysqli_query($rs_connect, $rs_find_op);
$rs_result_op_q = mysqli_fetch_object($rs_result_op);
$rs_totalop = "$rs_result_op_q->ourprice";
$rs_totalsp = "$rs_result_op_q->soldprice";

if ("$reportstoreid" == "all") {
$rs_find_opr = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id AND receipts.byuser = '$thetech'";
} else {
$rs_find_opr = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts WHERE sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$reportstoreid' AND receipts.byuser = '$thetech'";
}

$rs_result_opr = mysqli_query($rs_connect, $rs_find_opr);
$rs_result_opr_q = mysqli_fetch_object($rs_result_opr);
$rs_totalopr = "$rs_result_opr_q->ourprice";
$rs_totalspr = "$rs_result_opr_q->soldprice";


$rs_totalnet = ((tnv($rs_totalsp) - tnv($rs_totalspr)) - (tnv($rs_totalop) - tnv($rs_totalopr)));
$totalnet = abs("$rs_totalnet");

if ($rs_totalnet > 0) {
echo "<tr><td>".pcrtlang("Estimated Net Sales").":</td><td>$money".mf("$totalnet")."</td></tr>";
} else {
echo "<tr><td>".pcrtlang("Estimated Net Sales").":</td><td><span class=colormered> $money".mf("$totalnet")."</span></td></tr>";
}


echo "</table>";




####



if(!isset($_REQUEST['printable'])) {
stop_box();
}
                                                                 
echo "<br><br>";
if(!isset($_REQUEST['printable'])) {
start_box();
}


echo "<table class=\"standard lastalignright\">";

echo "<tr><th colspan=4>".pcrtlang("Open Invoices")."</th></tr>";


$opentotal = 0;
$opentotal_ourprice = 0;
$opentotal_tax = 0;
$closedtotal = 0;
$closedtotal_ourprice = 0;
$closedtotal_tax = 0;


if ("$reportstoreid" == "all") {
$rs_invoices = "SELECT * FROM invoices WHERE iorq != 'quote' 
AND invdate <= '$dayto 23:59:59' AND invdate  >= '$dayfrom 00:00:00'
AND invstatus = '1' AND byuser = '$thetech' ORDER BY invdate ASC";
} else {
$rs_invoices = "SELECT * FROM invoices WHERE iorq != 'quote'
AND invdate <= '$dayto 23:59:59' AND invdate  >= '$dayfrom 00:00:00' AND storeid = '$reportstoreid' 
AND invstatus = '1' AND byuser = '$thetech' ORDER BY invdate ASC";
}

$rs_find_invoices = @mysqli_query($rs_connect, $rs_invoices);
$totalinv = mysqli_num_rows($rs_find_invoices);

while($rs_find_invoices_q = mysqli_fetch_object($rs_find_invoices)) {
$invoice_id = "$rs_find_invoices_q->invoice_id";
$invname = "$rs_find_invoices_q->invname";
$invcompany = "$rs_find_invoices_q->invcompany";
$invstoreid = "$rs_find_invoices_q->storeid";

$findinvtotal = "SELECT SUM(cart_price) AS invsubtotal, SUM(itemtax) AS invtax, SUM(ourprice) AS ourprice FROM invoice_items WHERE invoice_id = '$invoice_id'";
$findinvq = @mysqli_query($rs_connect, $findinvtotal);
$findinva = mysqli_fetch_object($findinvq);
$invtax = "$findinva->invtax";
$invsubtotal = "$findinva->invsubtotal";
$ourprice = "$findinva->ourprice";
$invtotal2 = $invtax + $invsubtotal;

$opentotal = $opentotal + $invtotal2;
$opentotal_ourprice = $opentotal_ourprice + $ourprice;
$opentotal_tax = $opentotal_tax + $invtax;

echo "<tr><td>$invoice_id</td><td>$invname</td><td>$invcompany</td><td>$money".mf("$invtotal2")."</td></tr>";

}

echo "<tr><td colspan=4><span class=boldme>".pcrtlang("Grand Total").": $money".mf("$opentotal")."</span></td></tr>";
echo "<tr><td colspan=4><span class=boldme>".pcrtlang("Cost of Goods").": $money".mf("$opentotal_ourprice")."</span></td></tr>";
echo "<tr><td colspan=4><span class=boldme>".pcrtlang("Tax").": $money".mf("$opentotal_tax")."</span></td></tr>";
$opentotal_profit = $opentotal - ($opentotal_ourprice + $opentotal_tax);
echo "<tr><td colspan=4><span class=boldme>".pcrtlang("Net Profit").": $money".mf("$opentotal_profit")."</span></td></tr>";


echo "</table><br>";



echo "<table class=\"standard lastalignright\">";

echo "<tr><th colspan=4>".pcrtlang("Closed Invoices")."</th></tr>";


if ("$reportstoreid" == "all") {
$rs_invoices = "SELECT * FROM invoices WHERE iorq != 'quote'
AND invdate <= '$dayto 23:59:59' AND invdate  >= '$dayfrom 00:00:00'
AND invstatus = '2' AND byuser = '$thetech' ORDER BY invdate ASC";
} else {
$rs_invoices = "SELECT * FROM invoices WHERE iorq != 'quote'
AND invdate <= '$dayto 23:59:59' AND invdate  >= '$dayfrom 00:00:00' AND storeid = '$reportstoreid' 
AND invstatus = '2' AND byuser = '$thetech' ORDER BY invdate ASC";
}

$rs_find_invoices = @mysqli_query($rs_connect, $rs_invoices);
$totalinv = mysqli_num_rows($rs_find_invoices);

while($rs_find_invoices_q = mysqli_fetch_object($rs_find_invoices)) {
$invoice_id = "$rs_find_invoices_q->invoice_id";
$invname = "$rs_find_invoices_q->invname";
$invcompany = "$rs_find_invoices_q->invcompany";
$invstoreid = "$rs_find_invoices_q->storeid";

$findinvtotal = "SELECT SUM(cart_price) AS invsubtotal, SUM(itemtax) AS invtax, SUM(ourprice) AS ourprice FROM invoice_items WHERE invoice_id = '$invoice_id'";
$findinvq = @mysqli_query($rs_connect, $findinvtotal);
$findinva = mysqli_fetch_object($findinvq);
$invtax = "$findinva->invtax";
$invsubtotal = "$findinva->invsubtotal";
$ourprice = "$findinva->ourprice";
$invtotal2 = $invtax + $invsubtotal;

$closedtotal = $closedtotal + $invtotal2;
$closedtotal_ourprice = $closedtotal_ourprice + $ourprice;
$closedtotal_tax = $closedtotal_tax + $invtax;


echo "<tr><td>$invoice_id</td><td>$invname</td><td>$invcompany</td><td>$money".mf("$invtotal2")."</td></tr>";

}

echo "<tr><td colspan=4><span class=boldme>".pcrtlang("Grand Total").": $money".mf("$closedtotal")."</span></td></tr>";
echo "<tr><td colspan=4><span class=boldme>".pcrtlang("Cost of Goods").": $money".mf("$closedtotal_ourprice")."</span></td></tr>";
echo "<tr><td colspan=4><span class=boldme>".pcrtlang("Tax").": $money".mf("$closedtotal_tax")."</span></td></tr>";
$closedtotal_profit = $closedtotal - ($closedtotal_ourprice + $closedtotal_tax);
echo "<tr><td colspan=4><span class=boldme>".pcrtlang("Net Profit").": $money".mf("$closedtotal_profit")."</span></td></tr>";
echo "</table><br>";




#############################################



if(!isset($_REQUEST['printable'])) {
stop_box();
}

echo "<br><br>";

if(!isset($_REQUEST['printable'])) {
start_box();
}

echo "<br><span class=sizemelarge>".pcrtlang("Assigned Work Orders")."</span><br>";


if ("$reportstoreid" == "all") {
$rs_find_the_wo = "SELECT *  FROM pc_wo WHERE assigneduser = '$thetech' AND dropdate <= '$dayto 23:59:59' AND dropdate >= '$dayfrom 00:00:00' ORDER BY dropdate DESC";
} else {
$rs_find_the_wo = "SELECT *  FROM pc_wo WHERE assigneduser = '$thetech' AND dropdate <= '$dayto 23:59:59' AND dropdate >= '$dayfrom 00:00:00' AND storeid = '$reportstoreid' ORDER BY dropdate DESC";
}
$rs_result_wo = mysqli_query($rs_connect, $rs_find_the_wo);
$totalpcs = mysqli_num_rows($rs_result_wo);
echo "<span class=floatright>".pcrtlang("Total Work Orders").": $totalpcs</span><br><br>";

echo "<table class=standard>";
echo "<tr><th>".pcrtlang("Drop Off Date")."</th><th>".pcrtlang("Name")."</th>";
echo "<th>".pcrtlang("Asset Make")."</th>";
echo "<th style=\"padding-left:10px;padding-right:10px;\">".pcrtlang("Status")."</th>";
echo "<th>".pcrtlang("Work Order")."</th>";
echo "</tr>";



while($rs_result_wo_q = mysqli_fetch_object($rs_result_wo)) {
$rs_pcid = "$rs_result_wo_q->pcid";
$rs_woid = "$rs_result_wo_q->woid";
$probdesc = "$rs_result_wo_q->probdesc";
$dropoff = "$rs_result_wo_q->dropdate";
$pcstatus = "$rs_result_wo_q->pcstatus";

$rs_findowner = "SELECT * FROM pc_owner WHERE pcid = '$rs_pcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
$rs_result_q2 = mysqli_fetch_object($rs_result2);
$pcname = "$rs_result_q2->pcname";
$pccompany = "$rs_result_q2->pccompany";
$pcmake = "$rs_result_q2->pcmake";


$dropoff2 = pcrtdate("$pcrt_longdate", "$dropoff").", ".pcrtdate("$pcrt_time", "$dropoff");

$boxstyle = getboxstyle("$pcstatus");

echo "<tr>";
echo "<td>$dropoff2</td>";
echo "<td>$pcname</td>";
echo "<td>$pcmake</td>";

echo "<td><i class=\"fa fa-bookmark fa-lg\" style=\"color:#$boxstyle[selectorcolor];\"></i> $boxstyle[boxtitle]</td>";
echo "<td><a href=\"../repair/index.php?pcwo=$rs_woid\">$rs_woid</a></td>";

echo "</tr>";


}

echo "</table>";


if(!isset($_REQUEST['printable'])) {
stop_box();
}
                                                                  

if(!isset($_REQUEST['printable'])) {
require("footer.php");
} else {
printablefooter();
}

}


#################################################################

function tech_day_span_report_bwa() {


require_once("deps.php");
require_once("common.php");
perm_boot("7");

if (array_key_exists('dayto',$_REQUEST)) {
if ($_REQUEST['dayto'] != "") {
$dayto = $_REQUEST['dayto'];
} else {
$dayto = date("Y-m-d");
}
} else {
$dayto = date("Y-m-d");
}

if (array_key_exists('dayfrom',$_REQUEST)) {
if ($_REQUEST['dayfrom'] != "") {
$dayfrom = $_REQUEST['dayfrom'];
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}

$reportstoreid = $_REQUEST['reportstoreid'];
$thetech = $_REQUEST['thetech'];

if(!isset($_REQUEST['printable'])) {
require_once("header.php");
} else {
printableheader(pcrtlang("Technician Report"));
}


if(!isset($_REQUEST['printable'])) {
start_box();
}

echo "<table width=100%><tr><td width=75%>";

echo "<span class=sizemelarger>".pcrtlang("Tech Sales/Invoice/Work Order Report by Work Order Assignment")."</span><br><br>";


echo "<span class=sizemelarger>".pcrtlang("Report for")." $dayfrom ".pcrtlang("to")." $dayto</span><br><br><span class=sizemelarge>".pcrtlang("for Technician").": $thetech</span><br><br>";

if ($activestorecount > 1) {
if ("$reportstoreid" == "all") {
echo "<span class=sizemelarge>".pcrtlang("Store").": ".pcrtlang("All Stores")."</span><br><br>";
} else {
$storeinfoarray = getstoreinfo($reportstoreid);
echo "<span class=sizemelarge>".pcrtlang("Store").": $storeinfoarray[storesname]</span><br><br>";
}
}


echo "</td><td width=25% align=right>";

if(!isset($_REQUEST['printable'])) {
echo "<a href=reports.php?func=tech_day_span_report_bwa&dayto=$dayto&dayfrom=$dayfrom&printable=yes&reportstoreid=$reportstoreid&thetech=$thetech class=linkbutton><img src=images/print.png align=absmiddle border=0> ".pcrtlang("Printable")."</a>";
}


echo "</td></tr></table>";


echo "<table class=\"standard lastalignright\">";
echo "<tr><th colspan=2>".pcrtlang("Sales")."</th></tr>";


if ("$reportstoreid" == "all") {
$rs_find_cart_pur = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts,pc_wo WHERE sold_items.sold_type='purchase' AND sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold  >= '$dayfrom 00:00:00' AND pc_wo.assigneduser = '$thetech' AND sold_items.receipt = receipts.receipt_id AND (receipts.woid = pc_wo.woid OR CONCAT('\_',receipts.woid,'\_' = pc_wo.woid))";
} else {
$rs_find_cart_pur = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts,pc_wo WHERE sold_items.sold_type='purchase' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold  >= '$dayfrom 00:00:00' AND pc_wo.assigneduser = '$thetech' AND (receipts.woid = pc_wo.woid OR CONCAT('\_',receipts.woid,'\_' = pc_wo.woid))";
}
$rs_result_pur = mysqli_query($rs_connect, $rs_find_cart_pur);
while($rs_result_pur_q = mysqli_fetch_object($rs_result_pur)) {
$rs_purtotal = "$rs_result_pur_q->total";
echo "<tr><td>".pcrtlang("Total Purchases").":</td><td>$money".mf("$rs_purtotal")."</td></tr>";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_lab = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts,pc_wo WHERE sold_items.sold_type = 'labor' AND sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND pc_wo.assigneduser = '$thetech' AND sold_items.receipt = receipts.receipt_id AND (receipts.woid = pc_wo.woid OR CONCAT('\_',receipts.woid,'\_' = pc_wo.woid))";
} else {
$rs_find_cart_lab = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts,pc_wo WHERE sold_items.sold_type = 'labor' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND pc_wo.assigneduser = '$thetech' AND (receipts.woid = pc_wo.woid OR CONCAT('\_',receipts.woid,'\_' = pc_wo.woid))";
}
$rs_result_lab = mysqli_query($rs_connect, $rs_find_cart_lab);
while($rs_result_lab_q = mysqli_fetch_object($rs_result_lab)) {
$rs_labtotal = "$rs_result_lab_q->total";
echo "<tr><td>".pcrtlang("Total Labor").":</td><td>$money".mf("$rs_labtotal")."</td></tr>";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_ref = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts,pc_wo WHERE sold_items.sold_type='refund' AND sold_items.date_sold <= '
$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND pc_wo.assigneduser = '$thetech' AND sold_items.receipt = receipts.receipt_id AND (receipts.woid = pc_wo.woid OR CONCAT('\_',receipts.woid,'\_' = pc_wo.woid))";
} else {
$rs_find_cart_ref = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts,pc_wo WHERE sold_items.sold_type='refund' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.date_sold <= '$dayto 23:59:59' AND  sold_items.date_sold >= '$dayfrom 00:00:00' AND pc_wo.assigneduser = '$thetech' AND (receipts.woid = pc_wo.woid OR CONCAT('\_',receipts.woid,'\_' = pc_wo.woid))";
}
$rs_result_ref = mysqli_query($rs_connect, $rs_find_cart_ref);
while($rs_result_ref_q = mysqli_fetch_object($rs_result_ref)) {
$rs_reftotal = "$rs_result_ref_q->total";
echo "<tr><td>".pcrtlang("Total Sales Refunds").":</td><td>$money".mf("$rs_reftotal")."</td></tr>";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_refl = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts,pc_wo WHERE sold_items.sold_type='refundlabor' AND sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND pc_wo.assigneduser = '$thetech' AND sold_items.receipt = receipts.receipt_id AND (receipts.woid = pc_wo.woid OR CONCAT('\_',receipts.woid,'\_' = pc_wo.woid))";
} else {
$rs_find_cart_refl = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts,pc_wo WHERE sold_items.sold_type='refundlabor' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.date_sold <= '$dayto 23:59:59' AND  sold_items.date_sold >= '$dayfrom 00:00:00' AND pc_wo.assigneduser = '$thetech' AND (receipts.woid = pc_wo.woid OR CONCAT('\_',receipts.woid,'\_' = pc_wo.woid))";
}
$rs_result_refl = mysqli_query($rs_connect, $rs_find_cart_refl);
while($rs_result_refl_q = mysqli_fetch_object($rs_result_refl)) {
$rs_refltotal = "$rs_result_refl_q->total";
echo "<tr><td>".pcrtlang("Total Labor Refunds").":</td><td>$money".mf("$rs_refltotal")."</td></tr>";
}



if ("$reportstoreid" == "all") {
$rs_find_cart_refx = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts,pc_wo WHERE sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND sold_items.sold_type != 'refund' AND pc_wo.assigneduser = '$thetech' AND sold_items.receipt = receipts.receipt_id AND (receipts.woid = pc_wo.woid OR CONCAT('\_',receipts.woid,'\_' = pc_wo.woid))";
} else {
$rs_find_cart_refx = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts,pc_wo WHERE receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.date_sold <= '$dayto 23:59:59' AND  sold_items.date_sold >= '$dayfrom 00:00:00' AND sold_items.sold_type != 'refund' AND pc_wo.assigneduser = '$thetech' AND (receipts.woid = pc_wo.woid OR CONCAT('\_',receipts.woid,'\_' = pc_wo.woid))";
}
$rs_result_refx = mysqli_query($rs_connect, $rs_find_cart_refx);
while($rs_result_ref_qx = mysqli_fetch_object($rs_result_refx)) {
$rs_totaltax = "$rs_result_ref_qx->total";
echo "<tr><td>".pcrtlang("Total Sales/Service Tax Collected").":</td><td>$money".mf("$rs_totaltax")."</td></tr>";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_refxr = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts,pc_wo WHERE sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND pc_wo.assigneduser = '$thetech' AND sold_items.receipt = receipts.receipt_id AND (receipts.woid = pc_wo.woid OR CONCAT('\_',receipts.woid,'\_' = pc_wo.woid)) AND (sold_items.sold_type = 'refund' OR sold_items.sold_type = 'refundlabor')";
} else {
$rs_find_cart_refxr = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts,pc_wo WHERE receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND (receipts.woid = pc_wo.woid OR CONCAT('\_',receipts.woid,'\_' = pc_wo.woid)) AND sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND pc_wo.assigneduser = '$thetech' AND (sold_items.sold_type = 'refund' OR sold_items.sold_type = 'refundlabor')";
}
$rs_result_refxr = mysqli_query($rs_connect, $rs_find_cart_refxr);
while($rs_result_ref_qxr = mysqli_fetch_object($rs_result_refxr)) {
$rs_totaltaxr = "$rs_result_ref_qxr->total";
echo "<tr><td>".pcrtlang("Total Sales/Service Tax Refunded").":</td><td>$money".mf("$rs_totaltaxr")."</td></tr>";
}



$totalgross = (($rs_purtotal + $rs_labtotal) - ($rs_reftotal + $rs_refltotal));
echo "<tr><td>".pcrtlang("Gross Total")."<br><span class=sizeme10>(".pcrtlang("Taxable + Non-Taxable Sales &amp; Labor/Not Including Tax")."):</span></td><td>$money".mf("$totalgross")."</td></tr>";
            

$totaltax = $rs_totaltax - $rs_totaltaxr;
echo "<tr><td>".pcrtlang("Tax Total less Refunded Tax").":</td><td>$money".mf("$totaltax")."</td></tr>";



#####

if ("$reportstoreid" == "all") {
$rs_find_op = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts,pc_wo WHERE sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id AND pc_wo.assigneduser = '$thetech' AND (receipts.woid = pc_wo.woid OR CONCAT('\_',receipts.woid,'\_' = pc_wo.woid))";
} else {
$rs_find_op = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts,pc_wo WHERE sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$reportstoreid' AND pc_wo.assigneduser = '$thetech' AND (receipts.woid = pc_wo.woid OR CONCAT('\_',receipts.woid,'\_' = pc_wo.woid))";
}
$rs_result_op = mysqli_query($rs_connect, $rs_find_op);
$rs_result_op_q = mysqli_fetch_object($rs_result_op);
$rs_totalop = "$rs_result_op_q->ourprice";
$rs_totalsp = "$rs_result_op_q->soldprice";

if ("$reportstoreid" == "all") {
$rs_find_opr = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts,pc_wo WHERE sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id AND pc_wo.assigneduser = '$thetech' AND (receipts.woid = pc_wo.woid OR CONCAT('\_',receipts.woid,'\_' = pc_wo.woid))";
} else {
$rs_find_opr = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts,pc_wo WHERE sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$reportstoreid' AND pc_wo.assigneduser = '$thetech' AND (receipts.woid = pc_wo.woid OR CONCAT('\_',receipts.woid,'\_' = pc_wo.woid))";
}

$rs_result_opr = mysqli_query($rs_connect, $rs_find_opr);
$rs_result_opr_q = mysqli_fetch_object($rs_result_opr);
$rs_totalopr = "$rs_result_opr_q->ourprice";
$rs_totalspr = "$rs_result_opr_q->soldprice";


$rs_totalnet = (($rs_totalsp - $rs_totalspr) - ($rs_totalop - $rs_totalopr));
$totalnet = abs("$rs_totalnet");

if ($rs_totalnet > 0) {
echo "<tr><td>".pcrtlang("Estimated Net Sales").":</td><td>$money".mf("$totalnet")."</td></tr>";
} else {
echo "<tr><td>".pcrtlang("Estimated Net Sales").":</td><td><span class=colormered> $money".mf("$totalnet")."</span></td></tr>";
}


echo "</table>";



####



if(!isset($_REQUEST['printable'])) {
stop_box();
}
                                                                 
echo "<br><br>";
if(!isset($_REQUEST['printable'])) {
start_box();
}


echo "<table class=\"standard lastalignright\">";

echo "<tr><th colspan=4>".pcrtlang("Open Invoices")."</th></tr>";


$opentotal = 0;
$opentotal_ourprice = 0;
$opentotal_tax = 0;
$closedtotal = 0;
$closedtotal_ourprice = 0;
$closedtotal_tax = 0;


if ("$reportstoreid" == "all") {
$rs_invoices = "SELECT * FROM invoices,pc_wo WHERE invoices.iorq != 'quote' 
AND invoices.invdate <= '$dayto 23:59:59' AND invoices.invdate  >= '$dayfrom 00:00:00'
AND invoices.invstatus = '1' AND pc_wo.assigneduser = '$thetech' AND invoices.woid = pc_wo.woid ORDER BY invoices.invdate ASC";
} else {
$rs_invoices = "SELECT * FROM invoices,pc_wo WHERE invoices.iorq != 'quote'
AND invoices.invdate <= '$dayto 23:59:59' AND invoices.invdate  >= '$dayfrom 00:00:00' AND invoices.storeid = '$reportstoreid' 
AND invoices.invstatus = '1' AND pc_wo.assigneduser = '$thetech' AND invoices.woid = pc_wo.woid ORDER BY invoices.invdate ASC";
}

$rs_find_invoices = @mysqli_query($rs_connect, $rs_invoices);
$totalinv = mysqli_num_rows($rs_find_invoices);

while($rs_find_invoices_q = mysqli_fetch_object($rs_find_invoices)) {
$invoice_id = "$rs_find_invoices_q->invoice_id";
$invname = "$rs_find_invoices_q->invname";
$invcompany = "$rs_find_invoices_q->invcompany";
$invstoreid = "$rs_find_invoices_q->storeid";

$findinvtotal = "SELECT SUM(cart_price) AS invsubtotal, SUM(itemtax) AS invtax, SUM(ourprice) AS ourprice FROM invoice_items WHERE invoice_id = '$invoice_id'";
$findinvq = @mysqli_query($rs_connect, $findinvtotal);
$findinva = mysqli_fetch_object($findinvq);
$invtax = "$findinva->invtax";
$invsubtotal = "$findinva->invsubtotal";
$ourprice = "$findinva->ourprice";
$invtotal2 = $invtax + $invsubtotal;

$opentotal = $opentotal + $invtotal2;
$opentotal_ourprice = $opentotal_ourprice + $ourprice;
$opentotal_tax = $opentotal_tax + $invtax;

echo "<tr><td>$invoice_id</td><td>$invname</td><td>$invcompany</td><td>$money".mf("$invtotal2")."</td></tr>";

}

echo "<tr><td colspan=4><span class=boldme>".pcrtlang("Grand Total").": $money".mf("$opentotal")."</span></td></tr>";
echo "<tr><td colspan=4><span class=boldme>".pcrtlang("Cost of Goods").": $money".mf("$opentotal_ourprice")."</span></td></tr>";
echo "<tr><td colspan=4><span class=boldme>".pcrtlang("Tax").": $money".mf("$opentotal_tax")."</span></td></tr>";
$opentotal_profit = $opentotal - ($opentotal_ourprice + $opentotal_tax);
echo "<tr><td colspan=4><span class=boldme>".pcrtlang("Net Profit").": $money".mf("$opentotal_profit")."</span></td></tr>";


echo "</table><br>";



echo "<table class=\"standard lastalignright\">";

echo "<tr><th colspan=4>".pcrtlang("Closed Invoices")."</th></tr>";


if ("$reportstoreid" == "all") {
$rs_invoices = "SELECT * FROM invoices,pc_wo WHERE invoices.iorq != 'quote'
AND invoices.invdate <= '$dayto 23:59:59' AND invoices.invdate  >= '$dayfrom 00:00:00'
AND invoices.invstatus = '2' AND pc_wo.assigneduser = '$thetech' AND invoices.woid = pc_wo.woid  ORDER BY invoices.invdate ASC";
} else {
$rs_invoices = "SELECT * FROM invoices,pc_wo WHERE invoices.iorq != 'quote'
AND invoices.invdate <= '$dayto 23:59:59' AND invoices.invdate  >= '$dayfrom 00:00:00' AND invoices.storeid = '$reportstoreid' 
AND invoices.invstatus = '2' AND pc_wo.assigneduser = '$thetech' AND invoices.woid = pc_wo.woid ORDER BY invoices.invdate ASC";
}

$rs_find_invoices = @mysqli_query($rs_connect, $rs_invoices);
$totalinv = mysqli_num_rows($rs_find_invoices);

while($rs_find_invoices_q = mysqli_fetch_object($rs_find_invoices)) {
$invoice_id = "$rs_find_invoices_q->invoice_id";
$invname = "$rs_find_invoices_q->invname";
$invcompany = "$rs_find_invoices_q->invcompany";
$invstoreid = "$rs_find_invoices_q->storeid";

$findinvtotal = "SELECT SUM(cart_price) AS invsubtotal, SUM(itemtax) AS invtax, SUM(ourprice) AS ourprice FROM invoice_items WHERE invoice_id = '$invoice_id'";
$findinvq = @mysqli_query($rs_connect, $findinvtotal);
$findinva = mysqli_fetch_object($findinvq);
$invtax = "$findinva->invtax";
$invsubtotal = "$findinva->invsubtotal";
$ourprice = "$findinva->ourprice";
$invtotal2 = $invtax + $invsubtotal;

$closedtotal = $closedtotal + $invtotal2;
$closedtotal_ourprice = $closedtotal_ourprice + $ourprice;
$closedtotal_tax = $closedtotal_tax + $invtax;


echo "<tr><td>$invoice_id</td><td>$invname</td><td>$invcompany</td><td>$money".mf("$invtotal2")."</td></tr>";

}

echo "<tr><td colspan=4><span class=boldme>".pcrtlang("Grand Total").": $money".mf("$closedtotal")."</span></td></tr>";
echo "<tr><td colspan=4><span class=boldme>".pcrtlang("Cost of Goods").": $money".mf("$closedtotal_ourprice")."</span></td></tr>";
echo "<tr><td colspan=4><span class=boldme>".pcrtlang("Tax").": $money".mf("$closedtotal_tax")."</span></td></tr>";
$closedtotal_profit = $closedtotal - ($closedtotal_ourprice + $closedtotal_tax);
echo "<tr><td colspan=4><span class=boldme>".pcrtlang("Net Profit").": $money".mf("$closedtotal_profit")."</span></td></tr>";
echo "</table><br>";




#############################################



if(!isset($_REQUEST['printable'])) {
stop_box();
}

echo "<br><br>";

if(!isset($_REQUEST['printable'])) {
start_box();
}

echo "<br><span class=sizemelarge>".pcrtlang("Assigned Work Orders")."</span><br>";


if ("$reportstoreid" == "all") {
$rs_find_the_wo = "SELECT *  FROM pc_wo WHERE assigneduser = '$thetech' AND dropdate <= '$dayto 23:59:59' AND dropdate >= '$dayfrom 00:00:00' ORDER BY dropdate DESC";
} else {
$rs_find_the_wo = "SELECT *  FROM pc_wo WHERE assigneduser = '$thetech' AND dropdate <= '$dayto 23:59:59' AND dropdate >= '$dayfrom 00:00:00' AND storeid = '$reportstoreid' ORDER BY dropdate DESC";
}
$rs_result_wo = mysqli_query($rs_connect, $rs_find_the_wo);
$totalpcs = mysqli_num_rows($rs_result_wo);
echo "<span class=floatright>".pcrtlang("Total Work Orders").": $totalpcs</span><br><br>";

echo "<table class=standard>";
echo "<tr><th>".pcrtlang("Drop Off Date")."</th><th>".pcrtlang("Name")."</th>";
echo "<th>".pcrtlang("Asset Make")."</th>";
echo "<th style=\"padding-left:10px;padding-right:10px;\">".pcrtlang("Status")."</th>";
echo "<th>".pcrtlang("Work Order")."</th>";
echo "</tr>";



while($rs_result_wo_q = mysqli_fetch_object($rs_result_wo)) {
$rs_pcid = "$rs_result_wo_q->pcid";
$rs_woid = "$rs_result_wo_q->woid";
$probdesc = "$rs_result_wo_q->probdesc";
$dropoff = "$rs_result_wo_q->dropdate";
$pcstatus = "$rs_result_wo_q->pcstatus";

$rs_findowner = "SELECT * FROM pc_owner WHERE pcid = '$rs_pcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
$rs_result_q2 = mysqli_fetch_object($rs_result2);
$pcname = "$rs_result_q2->pcname";
$pccompany = "$rs_result_q2->pccompany";
$pcmake = "$rs_result_q2->pcmake";


$dropoff2 = pcrtdate("$pcrt_longdate", "$dropoff").", ".pcrtdate("$pcrt_time", "$dropoff");

$boxstyle = getboxstyle("$pcstatus");

echo "<tr>";
echo "<td>$dropoff2</td>";
echo "<td>$pcname</td>";
echo "<td>$pcmake</td>";

echo "<td><i class=\"fa fa-bookmark fa-lg\" style=\"color:#$boxstyle[selectorcolor];\"></i> $boxstyle[boxtitle]</td>";
echo "<td><a href=\"../repair/index.php?pcwo=$rs_woid\">$rs_woid</a></td>";

echo "</tr>";


}

echo "</table>";


if(!isset($_REQUEST['printable'])) {
stop_box();
}
                                                                  

if(!isset($_REQUEST['printable'])) {
require("footer.php");
} else {
printablefooter();
}

}



#################################################################


#################################################################

function tech_day_span_report_bwaplus() {


require_once("deps.php");
require_once("common.php");
perm_boot("7");

if (array_key_exists('dayto',$_REQUEST)) {
if ($_REQUEST['dayto'] != "") {
$dayto = $_REQUEST['dayto'];
} else {
$dayto = date("Y-m-d");
}
} else {
$dayto = date("Y-m-d");
}

if (array_key_exists('dayfrom',$_REQUEST)) {
if ($_REQUEST['dayfrom'] != "") {
$dayfrom = $_REQUEST['dayfrom'];
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}

$reportstoreid = $_REQUEST['reportstoreid'];
$thetech = $_REQUEST['thetech'];

if(!isset($_REQUEST['printable'])) {
require_once("header.php");
} else {
printableheader(pcrtlang("Technician Report"));
}


if(!isset($_REQUEST['printable'])) {
start_box();
}

echo "<table width=100%><tr><td width=75%>";

echo "<span class=sizemelarger>".pcrtlang("Tech Sales/Invoice/Work Order Report by Work Order Assignment + Unattached Receipts and Invoices")."</span><br><br>";


echo "<span class=sizemelarger>".pcrtlang("Report for")." $dayfrom ".pcrtlang("to")." $dayto</span><br><br><span class=sizemelarge>".pcrtlang("for Technician").": $thetech</span><br><br>";

if ($activestorecount > 1) {
if ("$reportstoreid" == "all") {
echo "<span class=sizemelarge>".pcrtlang("Store").": ".pcrtlang("All Stores")."</span><br><br>";
} else {
$storeinfoarray = getstoreinfo($reportstoreid);
echo "<span class=sizemelarge>".pcrtlang("Store").": $storeinfoarray[storesname]</span><br><br>";
}
}


echo "</td><td width=25% align=right>";

if(!isset($_REQUEST['printable'])) {
echo "<a href=reports.php?func=tech_day_span_report_bwaplus&dayto=$dayto&dayfrom=$dayfrom&printable=yes&reportstoreid=$reportstoreid&thetech=$thetech class=linkbutton><img src=images/print.png align=absmiddle border=0> ".pcrtlang("Printable")."</a>";
}


echo "</td></tr></table>";


echo "<table class=\"standard lastalignright\">";
echo "<tr><th colspan=2>".pcrtlang("Sales")."</th></tr>";



if ("$reportstoreid" == "all") {
$rs_find_cart_pur = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts,pc_wo WHERE sold_items.sold_type='purchase' AND sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold  >= '$dayfrom 00:00:00' AND sold_items.receipt = receipts.receipt_id AND ((pc_wo.assigneduser = '$thetech' AND (receipts.woid = pc_wo.woid OR CONCAT('\_',receipts.woid,'\_' = pc_wo.woid))) OR (receipts.byuser = '$thetech' AND receipts.woid = '' AND pc_wo.woid = ''))";
} else {
$rs_find_cart_pur = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts,pc_wo WHERE sold_items.sold_type='purchase' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold  >= '$dayfrom 00:00:00'  AND ((pc_wo.assigneduser = '$thetech' AND (receipts.woid = pc_wo.woid OR CONCAT('\_',receipts.woid,'\_' = pc_wo.woid))) OR (receipts.byuser = '$thetech' AND receipts.woid = '' AND pc_wo.woid = ''))";
}

$rs_result_pur = mysqli_query($rs_connect, $rs_find_cart_pur);
while($rs_result_pur_q = mysqli_fetch_object($rs_result_pur)) {
$rs_purtotal = "$rs_result_pur_q->total";
echo "<tr><td>".pcrtlang("Total Purchases").":</td><td>$money".mf("$rs_purtotal")."</td></tr>";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_lab = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts,pc_wo WHERE sold_items.sold_type = 'labor' AND sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND sold_items.receipt = receipts.receipt_id AND pc_wo.assigneduser = '$thetech' AND (receipts.woid = pc_wo.woid OR CONCAT('\_',receipts.woid,'\_' = pc_wo.woid))"; 
$rs_find_cart_lab2 = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type = 'labor' AND sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND sold_items.receipt = receipts.receipt_id AND receipts.byuser = '$thetech' AND receipts.woid = ''";
} else {
$rs_find_cart_lab = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts,pc_wo WHERE sold_items.sold_type = 'labor' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND pc_wo.assigneduser = '$thetech' AND (receipts.woid = pc_wo.woid OR CONCAT('\_',receipts.woid,'\_' = pc_wo.woid))";
$rs_find_cart_lab2 = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts WHERE sold_items.sold_type = 'labor' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND receipts.byuser = '$thetech' AND receipts.woid = ''";
}

$rs_result_lab = mysqli_query($rs_connect, $rs_find_cart_lab);
$rs_result_lab_q = mysqli_fetch_object($rs_result_lab);
$rs_result_lab2 = mysqli_query($rs_connect, $rs_find_cart_lab2);
$rs_result_lab_q2 = mysqli_fetch_object($rs_result_lab2);
$rs_labtotal = $rs_result_lab_q->total + $rs_result_lab_q2->total;
echo "<tr><td>".pcrtlang("Total Labor").":</td><td>$money".mf("$rs_labtotal")."</td></tr>";


if ("$reportstoreid" == "all") {
$rs_find_cart_ref = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts,pc_wo WHERE sold_items.sold_type='refund' AND sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND sold_items.receipt = receipts.receipt_id  AND ((pc_wo.assigneduser = '$thetech' AND (receipts.woid = pc_wo.woid OR CONCAT('\_',receipts.woid,'\_' = pc_wo.woid))) OR (receipts.byuser = '$thetech' AND receipts.woid = '' AND pc_wo.woid = ''))";
} else {
$rs_find_cart_ref = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts,pc_wo WHERE sold_items.sold_type='refund' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.date_sold <= '$dayto 23:59:59' AND  sold_items.date_sold >= '$dayfrom 00:00:00'  AND ((pc_wo.assigneduser = '$thetech' AND (receipts.woid = pc_wo.woid OR CONCAT('\_',receipts.woid,'\_' = pc_wo.woid))) OR (receipts.byuser = '$thetech' AND receipts.woid = '' AND pc_wo.woid = ''))";
}
$rs_result_ref = mysqli_query($rs_connect, $rs_find_cart_ref);
while($rs_result_ref_q = mysqli_fetch_object($rs_result_ref)) {
$rs_reftotal = "$rs_result_ref_q->total";
echo "<tr><td>".pcrtlang("Total Sales Refunds").":</td><td>$money".mf("$rs_reftotal")."</td></tr>";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_refl = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts,pc_wo WHERE sold_items.sold_type='refundlabor' AND sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND sold_items.receipt = receipts.receipt_id  AND ((pc_wo.assigneduser = '$thetech' AND (receipts.woid = pc_wo.woid OR CONCAT('\_',receipts.woid,'\_' = pc_wo.woid))) OR (receipts.byuser = '$thetech' AND receipts.woid = '' AND pc_wo.woid = ''))";
} else {
$rs_find_cart_refl = "SELECT SUM(sold_items.sold_price) AS total FROM sold_items,receipts,pc_wo WHERE sold_items.sold_type='refundlabor' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.date_sold <= '$dayto 23:59:59' AND  sold_items.date_sold >= '$dayfrom 00:00:00' AND receipts.woid = pc_wo.woid  AND ((pc_wo.assigneduser = '$thetech' AND (receipts.woid = pc_wo.woid OR CONCAT('\_',receipts.woid,'\_' = pc_wo.woid))) OR (receipts.byuser = '$thetech' AND receipts.woid = '' AND pc_wo.woid = ''))";
}
$rs_result_refl = mysqli_query($rs_connect, $rs_find_cart_refl);
while($rs_result_refl_q = mysqli_fetch_object($rs_result_refl)) {
$rs_refltotal = "$rs_result_refl_q->total";
echo "<tr><td>".pcrtlang("Total Labor Refunds").":</td><td>$money".mf("$rs_refltotal")."</td></tr>";
}



if ("$reportstoreid" == "all") {
$rs_find_cart_refx = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts,pc_wo WHERE sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND sold_items.sold_type != 'refund' AND sold_items.receipt = receipts.receipt_id  AND ((pc_wo.assigneduser = '$thetech' AND (receipts.woid = pc_wo.woid OR CONCAT('\_',receipts.woid,'\_' = pc_wo.woid))) OR (receipts.byuser = '$thetech' AND receipts.woid = '' AND pc_wo.woid = ''))";
} else {
$rs_find_cart_refx = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts,pc_wo WHERE receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.date_sold <= '$dayto 23:59:59' AND  sold_items.date_sold >= '$dayfrom 00:00:00' AND sold_items.sold_type != 'refund'  AND ((pc_wo.assigneduser = '$thetech' AND (receipts.woid = pc_wo.woid OR CONCAT('\_',receipts.woid,'\_' = pc_wo.woid))) OR (receipts.byuser = '$thetech' AND receipts.woid = '' AND pc_wo.woid = ''))";
}
$rs_result_refx = mysqli_query($rs_connect, $rs_find_cart_refx);
while($rs_result_ref_qx = mysqli_fetch_object($rs_result_refx)) {
$rs_totaltax = "$rs_result_ref_qx->total";
echo "<tr><td>".pcrtlang("Total Sales/Service Tax Collected").":</td><td>$money".mf("$rs_totaltax")."</td></tr>";
}

if ("$reportstoreid" == "all") {
$rs_find_cart_refxr = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts,pc_wo WHERE sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND sold_items.receipt = receipts.receipt_id AND (sold_items.sold_type = 'refund' OR sold_items.sold_type = 'refundlabor')  AND ((pc_wo.assigneduser = '$thetech' AND (receipts.woid = pc_wo.woid OR CONCAT('\_',receipts.woid,'\_' = pc_wo.woid))) OR (receipts.byuser = '$thetech' AND receipts.woid = '' AND pc_wo.woid = ''))";
} else {
$rs_find_cart_refxr = "SELECT SUM(sold_items.itemtax) AS total FROM sold_items,receipts,pc_wo WHERE receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND receipts.woid = pc_wo.woid AND sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND (sold_items.sold_type = 'refund' OR sold_items.sold_type = 'refundlabor')  AND ((pc_wo.assigneduser = '$thetech' AND (receipts.woid = pc_wo.woid OR CONCAT('\_',receipts.woid,'\_' = pc_wo.woid))) OR (receipts.byuser = '$thetech' AND receipts.woid = '' AND pc_wo.woid = ''))";
}
$rs_result_refxr = mysqli_query($rs_connect, $rs_find_cart_refxr);
while($rs_result_ref_qxr = mysqli_fetch_object($rs_result_refxr)) {
$rs_totaltaxr = "$rs_result_ref_qxr->total";
echo "<tr><td>".pcrtlang("Total Sales/Service Tax Refunded").":</td><td>$money".mf("$rs_totaltaxr")."</td></tr>";
}



$totalgross = (($rs_purtotal + $rs_labtotal) - ($rs_reftotal + $rs_refltotal));
echo "<tr><td>".pcrtlang("Gross Total")."<br><span class=sizeme10>(".pcrtlang("Taxable + Non-Taxable Sales &amp; Labor/Not Including Tax")."):</span></td><td>$money".mf("$totalgross")."</td></tr>";
            

$totaltax = $rs_totaltax - $rs_totaltaxr;
echo "<tr><td>".pcrtlang("Tax Total less Refunded Tax").":</td><td>$money".mf("$totaltax")."</td></tr>";



#####

if ("$reportstoreid" == "all") {
$rs_find_op = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts,pc_wo WHERE sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id  AND ((pc_wo.assigneduser = '$thetech' AND (receipts.woid = pc_wo.woid OR CONCAT('\_',receipts.woid,'\_' = pc_wo.woid))) OR (receipts.byuser = '$thetech' AND receipts.woid = '' AND pc_wo.woid = ''))";
} else {
$rs_find_op = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts,pc_wo WHERE sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND sold_items.sold_type = 'purchase' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$reportstoreid'  AND ((pc_wo.assigneduser = '$thetech' AND (receipts.woid = pc_wo.woid OR CONCAT('\_',receipts.woid,'\_' = pc_wo.woid))) OR (receipts.byuser = '$thetech' AND receipts.woid = '' AND pc_wo.woid = ''))";
}
$rs_result_op = mysqli_query($rs_connect, $rs_find_op);
$rs_result_op_q = mysqli_fetch_object($rs_result_op);
$rs_totalop = "$rs_result_op_q->ourprice";
$rs_totalsp = "$rs_result_op_q->soldprice";

if ("$reportstoreid" == "all") {
$rs_find_opr = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts,pc_wo WHERE sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id  AND ((pc_wo.assigneduser = '$thetech' AND (receipts.woid = pc_wo.woid OR CONCAT('\_',receipts.woid,'\_' = pc_wo.woid))) OR (receipts.byuser = '$thetech' AND receipts.woid = '' AND pc_wo.woid = '')) ";
} else {
$rs_find_opr = "SELECT SUM(sold_items.ourprice) AS ourprice, SUM(sold_items.sold_price) AS soldprice FROM sold_items,receipts,pc_wo WHERE sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold >= '$dayfrom 00:00:00' AND sold_items.sold_type = 'refund' AND sold_items.receipt = receipts.receipt_id AND receipts.storeid = '$reportstoreid'  AND ((pc_wo.assigneduser = '$thetech' AND (receipts.woid = pc_wo.woid OR CONCAT('\_',receipts.woid,'\_' = pc_wo.woid))) OR (receipts.byuser = '$thetech' AND receipts.woid = '' AND pc_wo.woid = ''))";
}

$rs_result_opr = mysqli_query($rs_connect, $rs_find_opr);
$rs_result_opr_q = mysqli_fetch_object($rs_result_opr);
$rs_totalopr = "$rs_result_opr_q->ourprice";
$rs_totalspr = "$rs_result_opr_q->soldprice";


$rs_totalnet = (($rs_totalsp - $rs_totalspr) - ($rs_totalop - $rs_totalopr));
$totalnet = abs("$rs_totalnet");

if ($rs_totalnet > 0) {
echo "<tr><td>".pcrtlang("Estimated Net Sales").":</td><td>$money".mf("$totalnet")."</td></tr>";
} else {
echo "<tr><td>".pcrtlang("Estimated Net Sales").":</td><td><span class=colormered> $money".mf("$totalnet")."</span></td></tr>";
}


echo "</table>";



####



if(!isset($_REQUEST['printable'])) {
stop_box();
}
                                                                 
echo "<br><br>";
if(!isset($_REQUEST['printable'])) {
start_box();
}


echo "<table class=\"standard lastalignright\">";

echo "<tr><th colspan=4>".pcrtlang("Open Invoices")."</th></tr>";


$opentotal = 0;
$opentotal_ourprice = 0;
$opentotal_tax = 0;
$closedtotal = 0;
$closedtotal_ourprice = 0;
$closedtotal_tax = 0;


if ("$reportstoreid" == "all") {
$rs_invoices = "SELECT * FROM invoices,pc_wo WHERE invoices.iorq != 'quote' 
AND invoices.invdate <= '$dayto 23:59:59' AND invoices.invdate  >= '$dayfrom 00:00:00'
AND invoices.invstatus = '1' 
AND ((pc_wo.assigneduser = '$thetech' AND (invoices.woid = pc_wo.woid OR CONCAT('\_',invoices.woid,'\_') = pc_wo.woid)) 
OR (invoices.byuser = '$thetech' AND invoices.woid = '' AND pc_wo.woid = '')) 
ORDER BY invoices.invdate ASC";
} else {
$rs_invoices = "SELECT * FROM invoices,pc_wo WHERE invoices.iorq != 'quote'
AND invoices.invdate <= '$dayto 23:59:59' AND invoices.invdate  >= '$dayfrom 00:00:00' AND invoices.storeid = '$reportstoreid' 
AND invoices.invstatus = '1' 
AND ((pc_wo.assigneduser = '$thetech' AND (invoices.woid = pc_wo.woid OR CONCAT('\_',invoices.woid,'\_') = pc_wo.woid)) 
OR (invoices.byuser = '$thetech' AND invoices.woid = '' AND pc_wo.woid = ''))
ORDER BY invoices.invdate ASC";
}


$rs_find_invoices = @mysqli_query($rs_connect, $rs_invoices);
$totalinv = mysqli_num_rows($rs_find_invoices);

while($rs_find_invoices_q = mysqli_fetch_object($rs_find_invoices)) {
$invoice_id = "$rs_find_invoices_q->invoice_id";
$invname = "$rs_find_invoices_q->invname";
$invcompany = "$rs_find_invoices_q->invcompany";
$invstoreid = "$rs_find_invoices_q->storeid";

$findinvtotal = "SELECT SUM(cart_price) AS invsubtotal, SUM(itemtax) AS invtax, SUM(ourprice) AS ourprice FROM invoice_items WHERE invoice_id = '$invoice_id'";
$findinvq = @mysqli_query($rs_connect, $findinvtotal);
$findinva = mysqli_fetch_object($findinvq);
$invtax = "$findinva->invtax";
$invsubtotal = "$findinva->invsubtotal";
$ourprice = "$findinva->ourprice";
$invtotal2 = $invtax + $invsubtotal;

$opentotal = $opentotal + $invtotal2;
$opentotal_ourprice = $opentotal_ourprice + $ourprice;
$opentotal_tax = $opentotal_tax + $invtax;

echo "<tr><td>$invoice_id</td><td>$invname</td><td>$invcompany</td><td>$money".mf("$invtotal2")."</td></tr>";

}

echo "<tr><td colspan=4><span class=boldme>".pcrtlang("Grand Total").": $money".mf("$opentotal")."</span></td></tr>";
echo "<tr><td colspan=4><span class=boldme>".pcrtlang("Cost of Goods").": $money".mf("$opentotal_ourprice")."</span></td></tr>";
echo "<tr><td colspan=4><span class=boldme>".pcrtlang("Tax").": $money".mf("$opentotal_tax")."</span></td></tr>";
$opentotal_profit = $opentotal - ($opentotal_ourprice + $opentotal_tax);
echo "<tr><td colspan=4><span class=boldme>".pcrtlang("Net Profit").": $money".mf("$opentotal_profit")."</span></td></tr>";


echo "</table><br>";



echo "<table class=\"standard lastalignright\">";

echo "<tr><th colspan=4>".pcrtlang("Closed Invoices")."</th></tr>";


if ("$reportstoreid" == "all") {
$rs_invoices = "SELECT * FROM invoices,pc_wo WHERE invoices.iorq != 'quote'
AND invoices.invdate <= '$dayto 23:59:59' AND invoices.invdate  >= '$dayfrom 00:00:00'
AND invoices.invstatus = '2'  AND ((pc_wo.assigneduser = '$thetech' AND invoices.woid = pc_wo.woid) OR (invoices.byuser = '$thetech' AND invoices.woid = '' AND pc_wo.woid = ''))
ORDER BY invoices.invdate ASC";
} else {
$rs_invoices = "SELECT * FROM invoices,pc_wo WHERE invoices.iorq != 'quote'
AND invoices.invdate <= '$dayto 23:59:59' AND invoices.invdate  >= '$dayfrom 00:00:00' AND invoices.storeid = '$reportstoreid' 
AND invoices.invstatus = '2' AND ((pc_wo.assigneduser = '$thetech' AND invoices.woid = pc_wo.woid) OR (invoices.byuser = '$thetech' AND invoices.woid = '' AND pc_wo.woid = ''))
ORDER BY invoices.invdate ASC";
}

$rs_find_invoices = @mysqli_query($rs_connect, $rs_invoices);
$totalinv = mysqli_num_rows($rs_find_invoices);

while($rs_find_invoices_q = mysqli_fetch_object($rs_find_invoices)) {
$invoice_id = "$rs_find_invoices_q->invoice_id";
$invname = "$rs_find_invoices_q->invname";
$invcompany = "$rs_find_invoices_q->invcompany";
$invstoreid = "$rs_find_invoices_q->storeid";

$findinvtotal = "SELECT SUM(cart_price) AS invsubtotal, SUM(itemtax) AS invtax, SUM(ourprice) AS ourprice FROM invoice_items WHERE invoice_id = '$invoice_id'";
$findinvq = @mysqli_query($rs_connect, $findinvtotal);
$findinva = mysqli_fetch_object($findinvq);
$invtax = "$findinva->invtax";
$invsubtotal = "$findinva->invsubtotal";
$ourprice = "$findinva->ourprice";
$invtotal2 = $invtax + $invsubtotal;

$closedtotal = $closedtotal + $invtotal2;
$closedtotal_ourprice = $closedtotal_ourprice + $ourprice;
$closedtotal_tax = $closedtotal_tax + $invtax;


echo "<tr><td>$invoice_id</td><td>$invname</td><td>$invcompany</td><td>$money".mf("$invtotal2")."</td></tr>";

}

echo "<tr><td colspan=4><span class=boldme>".pcrtlang("Grand Total").": $money".mf("$closedtotal")."</span></td></tr>";
echo "<tr><td colspan=4><span class=boldme>".pcrtlang("Cost of Goods").": $money".mf("$closedtotal_ourprice")."</span></td></tr>";
echo "<tr><td colspan=4><span class=boldme>".pcrtlang("Tax").": $money".mf("$closedtotal_tax")."</span></td></tr>";
$closedtotal_profit = $closedtotal - ($closedtotal_ourprice + $closedtotal_tax);
echo "<tr><td colspan=4><span class=boldme>".pcrtlang("Net Profit").": $money".mf("$closedtotal_profit")."</span></td></tr>";
echo "</table><br>";




#############################################



if(!isset($_REQUEST['printable'])) {
stop_box();
}

echo "<br><br>";

if(!isset($_REQUEST['printable'])) {
start_box();
}

echo "<br><span class=sizemelarge>".pcrtlang("Assigned Work Orders")."</span><br>";


if ("$reportstoreid" == "all") {
$rs_find_the_wo = "SELECT *  FROM pc_wo WHERE assigneduser = '$thetech' AND dropdate <= '$dayto 23:59:59' AND dropdate >= '$dayfrom 00:00:00' ORDER BY dropdate DESC";
} else {
$rs_find_the_wo = "SELECT *  FROM pc_wo WHERE assigneduser = '$thetech' AND dropdate <= '$dayto 23:59:59' AND dropdate >= '$dayfrom 00:00:00' AND storeid = '$reportstoreid' ORDER BY dropdate DESC";
}
$rs_result_wo = mysqli_query($rs_connect, $rs_find_the_wo);
$totalpcs = mysqli_num_rows($rs_result_wo);
echo "<span class=floatright>".pcrtlang("Total Work Orders").": $totalpcs</span><br><br>";

echo "<table class=standard>";
echo "<tr><th>".pcrtlang("Drop Off Date")."</th><th>".pcrtlang("Name")."</th>";
echo "<th>".pcrtlang("Asset Make")."</th>";
echo "<th style=\"padding-left:10px;padding-right:10px;\">".pcrtlang("Status")."</th>";
echo "<th>".pcrtlang("Work Order")."</th>";
echo "</tr>";



while($rs_result_wo_q = mysqli_fetch_object($rs_result_wo)) {
$rs_pcid = "$rs_result_wo_q->pcid";
$rs_woid = "$rs_result_wo_q->woid";
$probdesc = "$rs_result_wo_q->probdesc";
$dropoff = "$rs_result_wo_q->dropdate";
$pcstatus = "$rs_result_wo_q->pcstatus";

$rs_findowner = "SELECT * FROM pc_owner WHERE pcid = '$rs_pcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
$rs_result_q2 = mysqli_fetch_object($rs_result2);
$pcname = "$rs_result_q2->pcname";
$pccompany = "$rs_result_q2->pccompany";
$pcmake = "$rs_result_q2->pcmake";


$dropoff2 = pcrtdate("$pcrt_longdate", "$dropoff").", ".pcrtdate("$pcrt_time", "$dropoff");

$boxstyle = getboxstyle("$pcstatus");

echo "<tr>";
echo "<td>$dropoff2</td>";
echo "<td>$pcname</td>";
echo "<td>$pcmake</td>";

echo "<td><i class=\"fa fa-bookmark fa-lg\" style=\"color:#$boxstyle[selectorcolor];\"></i> $boxstyle[boxtitle]</td>";
echo "<td><a href=\"../repair/index.php?pcwo=$rs_woid\">$rs_woid</a></td>";

echo "</tr>";


}

echo "</table>";


if(!isset($_REQUEST['printable'])) {
stop_box();
}
                                                                  

if(!isset($_REQUEST['printable'])) {
require("footer.php");
} else {
printablefooter();
}

}



#################################################################




function dailycalllog() {

require("deps.php");
require("common.php");

require("header.php");

if (array_key_exists('day',$_REQUEST)) {
if ($_REQUEST['day'] != "") {
$day = $_REQUEST['day'];
} else {
$day = date("Y-m-d");
}
} else {
$day = date("Y-m-d");
}


start_box();
echo "<h4>".pcrtlang("Daily Call/SMS Log")."</h4>&nbsp;&nbsp;&nbsp;&nbsp;";


$plusday = date("Y-m-d", (strtotime("$day") + 86400));
$minusday = date("Y-m-d", (strtotime("$day") - 86400));


echo "<a href=reports.php?func=dailycalllog&day=$minusday class=imagelink><img src=images/left.png border=0 align=absmiddle></a> <span class=\"sizemelarge boldme\">".pcrtlang("Report for")." $day </span><a href=reports.php?func=dailycalllog&day=$plusday class=imagelink><img src=images/right.png border=0 align=absmiddle></a>";






$rs_find_cart_items = "SELECT * FROM userlog WHERE reftype = 'woid' AND thedatetime LIKE '$day%' AND (actionid = '11' OR actionid = '14') ORDER BY thedatetime ASC";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

if((mysqli_num_rows($rs_result)) == "0") {
echo "<br><span class=\"colormegray italme\">".pcrtlang("No Results Found")."</span>";
}

echo "<table>";

while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_actionid = "$rs_result_q->actionid";
$rs_thedatetime2 = "$rs_result_q->thedatetime";
$rs_thedatetime = (date("g:i:s A", strtotime("$rs_thedatetime2")));
$rs_refid = "$rs_result_q->refid";
$loggeduser = "$rs_result_q->loggeduser";
$reftype = "$rs_result_q->reftype";
$refid = "$rs_result_q->refid";
$mensaje = "$rs_result_q->mensaje";

$rs_find_store = "SELECT storeid,pcid FROM pc_wo WHERE woid = '$refid'";
$rs_resultfs = mysqli_query($rs_connect, $rs_find_store);
$rs_result_qfs = mysqli_fetch_object($rs_resultfs);
$rs_storeid = "$rs_result_qfs->storeid";
$rs_pcid = "$rs_result_qfs->pcid";

if($rs_storeid == $defaultuserstore) {

$rs_find_owner = "SELECT * FROM pc_owner WHERE pcid = '$rs_pcid'";
$rs_resulto = mysqli_query($rs_connect, $rs_find_owner);
$rs_result_qo = mysqli_fetch_object($rs_resulto);
$rs_pcname = "$rs_result_qo->pcname";
$rs_pccompany = "$rs_result_qo->pccompany";


if ($mensaje != "") {
$link = "<div class=\"wonote left\">$mensaje</div>";
} else {
$link = "";
}

echo "<tr><td><td style=\"vertical-align:top;\">".pcrtlang("User").": $loggeduser<br>$loggedactions[$rs_actionid]<br>";
echo "$rs_thedatetime<br>";
echo "<a href=\"../repair/index.php?pcwo=$refid\">$rs_pcname</a><br>";
echo "".pcrtlang("Work Order").":$refid<br><br></td>";
echo "<td> $link</td></tr>";

}
}

echo "</table>";

stop_box();
stop_blue_box();


}




#######

function day_span_payments_report() {

require_once("deps.php");
require_once("common.php");
perm_boot("5");

if (array_key_exists('dayto',$_REQUEST)) {
if ($_REQUEST['dayto'] != "") {
$dayto = $_REQUEST['dayto'];
} else {
$dayto = date("Y-m-d");
}
} else {
$dayto = date("Y-m-d");
}

if (array_key_exists('dayfrom',$_REQUEST)) {
if ($_REQUEST['dayfrom'] != "") {
$dayfrom = $_REQUEST['dayfrom'];
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}

$reportstoreid = $_REQUEST['reportstoreid'];



if(!isset($_REQUEST['printable'])) {                                                                                                                                      
require_once("header.php");
} else {
printableheader(pcrtlang("Payments Report")." $dayfrom - $dayto");
}



if(!isset($_REQUEST['printable'])) { 
start_box();
}

echo "<table width=100%><tr><td width=75 align=left>";

echo "<span class=sizemelarger>".pcrtlang("Payment Report for")." $dayfrom ".pcrtlang("to")." $dayto</span><br><br>";

if ($activestorecount > 1) {
if ("$reportstoreid" == "all") {
echo "<span class=sizemelarger>".pcrtlang("Store").": ".pcrtlang("All Stores")."</span><br><br>";
} else {
$storeinfoarray = getstoreinfo($reportstoreid);
echo "<span class=sizemelarger>".pcrtlang("Store").": $storeinfoarray[storesname]</span><br><br>";
}
}


echo "</td><td width=25% align=right>";

if(!isset($_REQUEST['printable'])) {
echo "<a href=reports.php?func=day_span_payments_report&dayto=$dayto&dayfrom=$dayfrom&printable=yes&reportstoreid=$reportstoreid class=linkbutton><img src=images/print.png align=absmiddle border=0> ".pcrtlang("Printable")."</a>";
echo "<br><!--<a href=reports.php?func=day_span_payments_report_csv&dayto=$dayto&dayfrom=$dayfrom&reportstoreid=$reportstoreid class=linkbutton><img src=images/csv.png align=absmiddle border=0> ".pcrtlang("CSV")."</a>-->";
}

echo "</td></tr></table>";
echo "<table class=\"bigstandard lastalignright\">";  
echo "<tr><th colspan=2>".pcrtlang("Totals")."</th><th>".pcrtlang("Total Transactions")."</th></tr>";


$pluginstotal = 0;
$pluginstotala = 0;
$pluginstotalb = 0;

reset($paymentplugins);
foreach($paymentplugins as $key => $plugin) {
if ("$reportstoreid" == "all") {
$rs_find_plugins = "SELECT SUM(amount) AS totalcash, COUNT(paymentid) AS totaltrans  FROM savedpayments WHERE paymentdate <= '$dayto 23:59:59' AND paymentdate  >= '$dayfrom 00:00:00' AND paymentplugin = '$plugin'";
} else {
$rs_find_plugins = "SELECT SUM(amount) AS totalcash, COUNT(paymentid) AS totaltrans FROM savedpayments WHERE paymentdate <= '$dayto 23:59:59' AND paymentdate  >= '$dayfrom 00:00:00' AND paymentplugin = '$plugin' AND storeid = '$reportstoreid'";
}
$rs_result_plugin = mysqli_query($rs_connect, $rs_find_plugins);
while($rs_result_plugin_q = mysqli_fetch_object($rs_result_plugin)) {
$rs_totalcash = "$rs_result_plugin_q->totalcash";
$rs_totaltrans = "$rs_result_plugin_q->totaltrans";
if ($rs_totalcash != '') {
$cash = $rs_totalcash;
} else {
$cash = "0.00";
}
}
if ($cash != "0") {
echo "<tr><td>".pcrtlang("$plugin").":</td><td class=textalignright>$money".mf("$cash")."</td><td>$rs_totaltrans</td></tr>";
}
$pluginstotal = $pluginstotal + $cash;
}


reset($paymentplugins);
foreach($paymentplugins as $key => $plugin) {
if ("$reportstoreid" == "all") {
$rs_find_pluginsdep = "SELECT SUM(amount) AS totalcash, COUNT(depositid) AS totaltrans  FROM deposits WHERE depdate <= '$dayto 23:59:59' AND depdate  >= '$dayfrom 00:00:00'  AND paymentplugin = '$plugin'";
} else {
$rs_find_pluginsdep = "SELECT SUM(amount) AS totalcash, COUNT(depositid) AS totaltrans FROM deposits WHERE depdate <= '$dayto 23:59:59' AND depdate  >= '$dayfrom 00:00:00'  AND paymentplugin = '$plugin' AND storeid = '$reportstoreid'";
}

$rs_result_plugindep = mysqli_query($rs_connect, $rs_find_pluginsdep);
while($rs_result_plugin_qdep = mysqli_fetch_object($rs_result_plugindep)) {
$rs_totalcashdep = "$rs_result_plugin_qdep->totalcash";
$rs_totaltransdep = "$rs_result_plugin_qdep->totaltrans";
if ($rs_totalcashdep != '') {
$cashb = $rs_totalcashdep;
} else {
$cashb = "0.00";
}
}
if ($cashb != "0") {
echo "<tr><td>".pcrtlang("$plugin")." (".pcrtlang("Received Deposits")."):</td><td class=textalignright>$money".mf("$cashb")."</td><td>$rs_totaltransdep</td></tr>";
}
$pluginstotalb = $pluginstotalb + $cashb;
}


reset($paymentplugins);
foreach($paymentplugins as $key => $plugin) {
if ("$reportstoreid" == "all") {
$rs_find_pluginsdepa = "SELECT SUM(amount) AS totalcash, COUNT(depositid) AS totaltrans FROM deposits WHERE applieddate <= '$dayto 23:59:59' AND applieddate  >= '$dayfrom 00:00:00' AND paymentplugin = '$plugin' AND dstatus = 'applied'";
} else {
$rs_find_pluginsdepa = "SELECT SUM(amount) AS totalcash, COUNT(depositid) AS totaltrans  FROM deposits WHERE applieddate <= '$dayto 23:59:59' AND applieddate  >= '$dayfrom 00:00:00' AND paymentplugin = '$plugin' AND dstatus = 'applied' AND appliedstoreid = '$reportstoreid'";
}
$rs_result_plugindepa = mysqli_query($rs_connect, $rs_find_pluginsdepa);
while($rs_result_plugin_qdepa = mysqli_fetch_object($rs_result_plugindepa)) {
$rs_totalcashdepa = "$rs_result_plugin_qdepa->totalcash";
$rs_totaltransdepa = "$rs_result_plugin_qdepa->totaltrans";
if ($rs_totalcashdepa != '') {
$casha = $rs_totalcashdepa;
} else {
$casha = "0.00";
}
}
if ($casha != "0") {
echo "<tr><td>".pcrtlang("$plugin")." (".pcrtlang("Applied Deposits")."):</td><td class=textalignright>$money".mf("$casha")."</td><td>$rs_totaltransdepa</td></tr>";
}
$pluginstotala = $pluginstotala + $casha;
}


echo "</table>";

if(($pluginstotal == "0") && ($pluginstotala == "0") && ($pluginstotalb =="0")) {
echo "<span class=\"italme colormegray\">".pcrtlang("No Payment Data available for this time period.")."</span>";
}


if(!isset($_REQUEST['printable'])) {
stop_box();
}


if(!isset($_REQUEST['printable'])) {
require("footer.php");
} else {
printablefooter();
}



}


#####################

function day_span_payments_detail_report() {

require_once("deps.php");
require_once("common.php");
perm_boot("5");

if (array_key_exists('dayto',$_REQUEST)) {
if ($_REQUEST['dayto'] != "") {
$dayto = $_REQUEST['dayto'];
} else {
$dayto = date("Y-m-d");
}
} else {
$dayto = date("Y-m-d");
}

if (array_key_exists('dayfrom',$_REQUEST)) {
if ($_REQUEST['dayfrom'] != "") {
$dayfrom = $_REQUEST['dayfrom'];
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}

$reportstoreid = $_REQUEST['reportstoreid'];

$plugin = $_REQUEST['plugin'];

if(!isset($_REQUEST['printable'])) {                                                                                                                                      
require_once("header.php");
} else {
printableheader(pcrtlang("Payment Detail Report")." $dayfrom - $dayto");
}




if(!isset($_REQUEST['printable'])) { 
start_box();
}

echo "<table width=100%><tr><td width=75 align=left>";

echo "<span class=sizemelarger>".pcrtlang("Payment Detail Report for")." $dayfrom ".pcrtlang("to")." $dayto</span><br><br>";

if ($activestorecount > 1) {
if ("$reportstoreid" == "all") {
echo "<span class=sizemelarge>".pcrtlang("Store").": ".pcrtlang("All Stores")."</span><br><br>";
} else {
$storeinfoarray = getstoreinfo($reportstoreid);
echo "<span class=sizemelarge>".pcrtlang("Store").": $storeinfoarray[storesname]</span><br><br>";
}
}


echo "</td><td width=25% align=right>";

if(!isset($_REQUEST['printable'])) {
echo "<a href=reports.php?func=day_span_payments_detail_report&dayto=$dayto&dayfrom=$dayfrom&printable=yes&reportstoreid=$reportstoreid&plugin=$plugin class=linkbutton><img src=images/print.png align=absmiddle border=0> ".pcrtlang("Printable")."</a>";
echo "<br>";
}

echo "</td></tr></table>";
echo "<table class=standard>";                                                                      


echo "<tr><th>".pcrtlang("Name")."</th>";
echo "<th>".pcrtlang("Date")."</th>";
echo "<th style=\"text-align:right;\">".pcrtlang("Payment Method").": $plugin</th>";
echo "<th style=\"text-align:right;\">".pcrtlang("Amount")."</th>";
echo "</tr>";



if ("$reportstoreid" == "all") {
$rs_find_plugins = "SELECT * FROM savedpayments WHERE paymentdate <= '$dayto 23:59:59' AND paymentdate  >= '$dayfrom 00:00:00' AND paymentplugin = '$plugin' ORDER BY paymentdate ASC";
} else {
$rs_find_plugins = "SELECT * FROM savedpayments WHERE paymentdate <= '$dayto 23:59:59' AND paymentdate  >= '$dayfrom 00:00:00' AND paymentplugin = '$plugin' AND storeid = '$reportstoreid' ORDER BY paymentdate ASC";
}

$amounttotal = 0;

$rs_result_plugin = mysqli_query($rs_connect, $rs_find_plugins);
while($rs_result_plugin_q = mysqli_fetch_object($rs_result_plugin)) {
$rs_pfirstname = "$rs_result_plugin_q->pfirstname";
$rs_plastname = "$rs_result_plugin_q->plastname";
$rs_amount = "$rs_result_plugin_q->amount";
$rs_chk_number = "$rs_result_plugin_q->chk_number";
$rs_paymentdate = "$rs_result_plugin_q->paymentdate";
$rs_cc_confirmation = "$rs_result_plugin_q->cc_confirmation";
$rs_paymenttype = "$rs_result_plugin_q->paymenttype";

$amounttotal = $amounttotal + $rs_amount;

echo "<tr><td>$rs_pfirstname $rs_plastname</td>";
echo "<td>$rs_paymentdate</td>";

if($rs_paymenttype == "cash") {
echo "<td></td>";
} elseif ($rs_paymenttype == "credit") {
echo "<td>$rs_cc_confirmation</td>";
} elseif ($rs_paymenttype == "check") {
echo "<td style=\"text-align:right;\">#$rs_chk_number</td>";
} elseif ($rs_paymenttype == "custompayment") {
echo "<td></td>";
} else {
echo "<td></td>";
}

echo "<td style=\"text-align:right;\">$money".mf("$rs_amount")."</td>";

echo "</tr>";
}


echo "<tr><td colspan=4 style=\"text-align:right;\">".pcrtlang("Total").": $money$amounttotal</td></tr>";

echo "</table>";


if(!isset($_REQUEST['printable'])) {
stop_box();
}


if(!isset($_REQUEST['printable'])) {
require("footer.php");
} else {
printablefooter();
}



}




#####################



function monthly_payments_report() {

require_once("deps.php");
require_once("common.php");
perm_boot("5");

if (array_key_exists('year',$_REQUEST)) {
if ($_REQUEST['year'] != "") {
$year = $_REQUEST['year'];
} else {
$year = date("Y");
}
} else {
$year = date("Y");
}



$reportstoreid = $_REQUEST['reportstoreid'];



if(!isset($_REQUEST['printable'])) {                                                                                                                                      
require_once("header.php");
} else {
printableheader(pcrtlang("Payments Report")." $year");
}


if(!isset($_REQUEST['printable'])) { 
start_box();
}

echo "<table style=\"width:100%\"><tr><td>";

echo "<span class=sizemelarger>".pcrtlang("Monthly Payment Report for")." $year</span><br><br>";

if ($activestorecount > 1) {
if ("$reportstoreid" == "all") {
echo "<span class=sizemelarge>".pcrtlang("Store").": ".pcrtlang("All Stores")."</span><br><br>";
} else {
$storeinfoarray = getstoreinfo($reportstoreid);
echo "<span class=sizemelarge>".pcrtlang("Store").": $storeinfoarray[storesname]</span><br><br>";
}
}


echo "</td><td width=25% align=right>";

if(!isset($_REQUEST['printable'])) {
echo "<a href=reports.php?func=monthly_payments_report&year=$year&printable=yes&reportstoreid=$reportstoreid class=linkbutton><img src=images/print.png border=0 align=absmiddle> ".pcrtlang("Printable")."</a>";
}

echo "</td></tr></table>";
echo "<table class=standard style=\"width:60%\">";  


$m = 1;
       
while($m < 13) {

echo "<tr><th colspan=2>";

if ($m == 1) {
echo pcrtlang("January");
} elseif ($m == 2) {
echo pcrtlang("February");
} elseif ($m == 3) {
echo pcrtlang("March");
} elseif ($m == 4) {
echo pcrtlang("April");
} elseif ($m == 5) {
echo pcrtlang("May");
} elseif ($m == 6) {
echo pcrtlang("June");
} elseif ($m == 7) {
echo pcrtlang("July");
} elseif ($m == 8) {
echo pcrtlang("August");
} elseif ($m == 9) {
echo pcrtlang("September");
} elseif ($m == 10) {
echo pcrtlang("October");
} elseif ($m == 11) {
echo pcrtlang("November");
} else {
echo pcrtlang("December");
}




echo "</th></tr>";


$pluginstotal = 0;
$pluginstotala = 0;
$pluginstotalb = 0;

reset($paymentplugins);
foreach($paymentplugins as $key => $plugin) {
if ("$reportstoreid" == "all") {
$rs_find_plugins = "SELECT SUM(amount) AS totalcash FROM savedpayments WHERE MONTH(paymentdate) = '$m' AND YEAR(paymentdate) = '$year' AND paymentplugin = '$plugin'";
} else {
$rs_find_plugins = "SELECT SUM(amount) AS totalcash FROM savedpayments WHERE MONTH(paymentdate) = '$m' AND YEAR(paymentdate) = '$year' AND paymentplugin = '$plugin' AND storeid = '$reportstoreid'";
}
$rs_result_plugin = mysqli_query($rs_connect, $rs_find_plugins);
while($rs_result_plugin_q = mysqli_fetch_object($rs_result_plugin)) {
$rs_totalcash = "$rs_result_plugin_q->totalcash";
if ($rs_totalcash != '') {
$cash = $rs_totalcash;
} else {
$cash = "0.00";
}
}
if ($cash != "0") {
echo "<tr><td>".pcrtlang("$plugin").":</td><td class=textalignright>$money".mf("$cash")."</td></tr>";
}
$pluginstotal = $pluginstotal + $cash;
}


reset($paymentplugins);
foreach($paymentplugins as $key => $plugin) {
if ("$reportstoreid" == "all") {
$rs_find_pluginsdep = "SELECT SUM(amount) AS totalcash FROM deposits WHERE MONTH(depdate) = '$m' AND YEAR(depdate) = '$year'   AND paymentplugin = '$plugin'";
} else {
$rs_find_pluginsdep = "SELECT SUM(amount) AS totalcash FROM deposits WHERE MONTH(depdate) = '$m' AND YEAR(depdate) = '$year' AND paymentplugin = '$plugin' AND storeid = '$reportstoreid'";
}

$rs_result_plugindep = mysqli_query($rs_connect, $rs_find_pluginsdep);
while($rs_result_plugin_qdep = mysqli_fetch_object($rs_result_plugindep)) {
$rs_totalcashdep = "$rs_result_plugin_qdep->totalcash";
if ($rs_totalcashdep != '') {
$cashb = $rs_totalcashdep;
} else {
$cashb = "0.00";
}
}
if ($cashb != "0") {
echo "<tr><td>".pcrtlang("$plugin")." (".pcrtlang("Received Deposits")."):</td><td class=textalignright>$money".mf("$cashb")."</td></tr>";
}
$pluginstotalb = $pluginstotalb + $cashb;
}


reset($paymentplugins);
foreach($paymentplugins as $key => $plugin) {
if ("$reportstoreid" == "all") {
$rs_find_pluginsdepa = "SELECT SUM(amount) AS totalcash FROM deposits WHERE MONTH(applieddate) = '$m' AND YEAR(applieddate) = '$year' AND paymentplugin = '$plugin' AND dstatus = 'applied'";
} else {
$rs_find_pluginsdepa = "SELECT SUM(amount) AS totalcash FROM deposits WHERE MONTH(applieddate) = '$m' AND YEAR(applieddate) = '$year' AND paymentplugin = '$plugin' AND dstatus = 'applied' AND appliedstoreid = '$reportstoreid'";
}
$rs_result_plugindepa = mysqli_query($rs_connect, $rs_find_pluginsdepa);
while($rs_result_plugin_qdepa = mysqli_fetch_object($rs_result_plugindepa)) {
$rs_totalcashdepa = "$rs_result_plugin_qdepa->totalcash";
if ($rs_totalcashdepa != '') {
$casha = $rs_totalcashdepa;
} else {
$casha = "0.00";
}
}
if ($casha != "0") {
echo "<tr><td>".pcrtlang("$plugin")." (".pcrtlang("Applied Deposits")."):</td><td class=textalignright>$money".mf("$casha")."</td></tr>";
}
$pluginstotala = $pluginstotala + $casha;
}

if(($pluginstotal == "0") && ($pluginstotala == "0") && ($pluginstotalb =="0")) {
echo "<tr><td colspan=2><span class=italme>".pcrtlang("No Payment Data available for this month.")."</span></td></tr>";
}


echo "<tr><td colspan=2><br></td></tr>";


$m++;

}

echo "</table>";

if(!isset($_REQUEST['printable'])) {
stop_box();
}


if(!isset($_REQUEST['printable'])) {
require("footer.php");
} else {
printablefooter();
}



}


function searchnii() {

require_once("header.php");

require("deps.php");

$thesearch = $_REQUEST['thesearch'];

start_blue_box(pcrtlang("Sold Non-Inventoried Item Search"));

echo "<form action=reports.php?func=searchnii method=post>";
echo "".pcrtlang("Enter Search Term").": <input type=text class=textbox name=thesearch value=\"$thesearch\">";
echo "<input class=button type=submit value=\"".pcrtlang("Search Again")."\"></form>";
echo "<br>";


echo "<table class=standard><tr><th>".pcrtlang("Date")."</th><th>".pcrtlang("Item Name")."</th>";

echo "<th>".pcrtlang("Receipt No.")."</th><th>".pcrtlang("Customer Name")."</th>";
echo "<th>".pcrtlang("Work Order ID")."</th><th>".pcrtlang("Invoice")."</th></tr>";

$theq = "SELECT * FROM sold_items WHERE stockid = '0' AND sold_type = 'purchase' AND (labor_desc LIKE '%$thesearch%' OR itemserial LIKE '%$thesearch%') ORDER BY date_sold DESC LIMIT 50";





$rs_result_nii_r = mysqli_query($rs_connect, $theq);
while($rs_result_rq = mysqli_fetch_object($rs_result_nii_r)) {
$receipt_id = "$rs_result_rq->receipt";
$date_sold = "$rs_result_rq->date_sold";
$itemname = "$rs_result_rq->labor_desc";

$theqc = "SELECT * FROM receipts WHERE receipt_id = '$receipt_id'";
$rs_result_nii_rc = mysqli_query($rs_connect, $theqc);
$rs_result_rqc = mysqli_fetch_object($rs_result_nii_rc);
$customername = "$rs_result_rqc->person_name";
$company = "$rs_result_rqc->company";
$invoice_id = "$rs_result_rqc->invoice_id";
$woid = "$rs_result_rqc->woid";

echo "<tr><td>$date_sold</td><td>$itemname</td>";
echo "<td><a href=\"receipt.php?func=show_receipt&receipt=$receipt_id\" class=\"linkbuttonsmall linkbuttongray\">$receipt_id</a></td>";
echo "<td>$customername $company</td><td>";

if($woid != 0) {
echo "<a href=\"../repair/index.php?pcwo=$woid\" class=\"linkbuttonsmall linkbuttongray\">$woid</a>";
}

echo "</td><td>";

if($invoice_id != 0) {
echo "<a href=\"invoice.php?func=printinv&invoice_id=$invoice_id\" class=\"linkbuttonsmall linkbuttongray\">$invoice_id</a>";
}

echo "</td></tr>";

}
echo "</table>";
stop_blue_box();

require("footer.php");

}


function searchsolditemserial() {

require_once("header.php");

require("deps.php");

$thesearch = $_REQUEST['thesearch'];

start_blue_box(pcrtlang("Sold Item Search by Serial"));

echo "<form action=reports.php?func=searchsolditemserial method=post>";
echo "".pcrtlang("Enter Serial Number").": <input type=text class=textbox name=thesearch value=\"$thesearch\">";
echo "<input class=button type=submit value=\"".pcrtlang("Search Again")."\"></form>";
echo "<br>";


echo "<table class=standard><tr><th>".pcrtlang("Date")."</th><th>".pcrtlang("Item Name")."</th>";

echo "<th>".pcrtlang("Receipt No.")."</th><th>".pcrtlang("Customer Name")."</th>";
echo "<th>".pcrtlang("Work Order ID")."</th><th>".pcrtlang("Invoice")."</th></tr>";
$theq = "SELECT * FROM sold_items WHERE sold_type = 'purchase'  AND itemserial LIKE '%$thesearch%' ORDER BY date_sold DESC LIMIT 50";

$rs_result_nii_r = mysqli_query($rs_connect, $theq);
while($rs_result_rq = mysqli_fetch_object($rs_result_nii_r)) {
$receipt_id = "$rs_result_rq->receipt";
$date_sold = "$rs_result_rq->date_sold";
$stockid = "$rs_result_rq->stockid";
$labor_desc = "$rs_result_rq->labor_desc";

if($stockid == 0) {
$itemname = "$labor_desc";
} else {
$rs_find_item_detail = "SELECT * FROM stock WHERE stock_id = '$stockid'";
$rs_find_result = mysqli_query($rs_connect, $rs_find_item_detail);
$rs_find_result_q = mysqli_fetch_object($rs_find_result);
$itemname = "$rs_find_result_q->stock_title";
}


$theqc = "SELECT * FROM receipts WHERE receipt_id = '$receipt_id'";
$rs_result_nii_rc = mysqli_query($rs_connect, $theqc);
$rs_result_rqc = mysqli_fetch_object($rs_result_nii_rc);
$customername = "$rs_result_rqc->person_name";
$company = "$rs_result_rqc->company";
$invoice_id = "$rs_result_rqc->invoice_id";
$woid = "$rs_result_rqc->woid";

echo "<tr><td>$date_sold</td><td>$itemname</td>";
echo "<td><a href=\"receipt.php?func=show_receipt&receipt=$receipt_id\" class=\"linkbuttonsmall linkbuttongray\">$receipt_id</a></td>";
echo "<td>$customername $company</td><td>";

if($woid != 0) {
echo "<a href=\"../repair/index.php?pcwo=$woid\" class=\"linkbuttonsmall linkbuttongray\">$woid</a>";
}

echo "</td><td>";

if($invoice_id != 0) {
echo "<a href=\"invoice.php?func=printinv&invoice_id=$invoice_id\" class=\"linkbuttonsmall linkbuttongray\">$invoice_id</a>";
}

echo "</td></tr>";
}
echo "</table>";
stop_blue_box();

require("footer.php");

}




function day_span_nii() {

require("deps.php");
require_once("common.php");
perm_boot("5");

if(!isset($_REQUEST['printable'])) {    
require("header.php");
} else {
printableheader(pcrtlang("Day Range Non-Inventoried Item Report"));
}


if (array_key_exists('dayto',$_REQUEST)) {
if ($_REQUEST['dayto'] != "") {
$dayto = $_REQUEST['dayto'];
} else {
$dayto = date("Y-m-d");
}
} else {
$dayto = date("Y-m-d");
}

if (array_key_exists('dayfrom',$_REQUEST)) {
if ($_REQUEST['dayfrom'] != "") {
$dayfrom = $_REQUEST['dayfrom'];
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}

$reportstoreid = $_REQUEST['reportstoreid'];

if(!isset($_REQUEST['printable'])) {
start_box();
}

echo "<span class=sizemelarger>".pcrtlang("Day Range Non-Inventoried Item Report")."</span><br><br>";

if(!isset($_REQUEST['printable'])) {
echo "<div class=floatright>";
echo "<a href=reports.php?func=day_span_nii&dayto=$dayto&dayfrom=$dayfrom&printable=yes&reportstoreid=$reportstoreid class=linkbutton><img src=images/print.png border=0 align=absmiddle> ".pcrtlang("Printable")."</a>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=reports.php?func=day_span_nii_csv&dayto=$dayto&dayfrom=$dayfrom&printable=yes&reportstoreid=$reportstoreid class=linkbutton><img src=images/csv.png border=0 align=absmiddle> ".pcrtlang("CSV")."</a>";
echo "</div>";
}



echo "<table class=standard><tr><th>".pcrtlang("Date")."</th><th>".pcrtlang("Item Name")."</th>";

echo "<th>".pcrtlang("Receipt No.")."</th><th>".pcrtlang("Customer Name")."</th>";
echo "<th>".pcrtlang("WO ID")."</th><th>".pcrtlang("Invoice")."</th>";
echo "<th>".pcrtlang("Store")."</th>";
echo "<th style=\"text-align:right;\">".pcrtlang("Cost")."</th>";
echo "<th style=\"text-align:right;\">".pcrtlang("Price")."</th>";
echo "</tr>";

if ("$reportstoreid" == "all") {
$theq = "SELECT * FROM sold_items WHERE sold_type='purchase' AND date_sold <= '$dayto 23:59:59' AND date_sold >= '$dayfrom 00:00:00' AND stockid = '0' ORDER BY date_sold DESC LIMIT 500";
} else {
$theq = "SELECT * FROM sold_items,receipts WHERE sold_items.sold_type='purchase' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold  >= '$dayfrom 00:00:00' AND stockid = '0' ORDER BY sold_items.date_sold DESC LIMIT 500";
}





$rs_result_nii_r = mysqli_query($rs_connect, $theq);

$chkrec = mysqli_num_rows($rs_result_nii_r);

if($chkrec != 0) {

while($rs_result_rq = mysqli_fetch_object($rs_result_nii_r)) {
$receipt_id = "$rs_result_rq->receipt";
$date_sold = "$rs_result_rq->date_sold";
$itemname = "$rs_result_rq->labor_desc";
$soldprice = "$rs_result_rq->sold_price";
$ourprice = "$rs_result_rq->ourprice";

$theqc = "SELECT * FROM receipts WHERE receipt_id = '$receipt_id'";
$rs_result_nii_rc = mysqli_query($rs_connect, $theqc);
$rs_result_rqc = mysqli_fetch_object($rs_result_nii_rc);
$customername = "$rs_result_rqc->person_name";
$company = "$rs_result_rqc->company";
$invoice_id = "$rs_result_rqc->invoice_id";
$woid = "$rs_result_rqc->woid";
$storeid = "$rs_result_rqc->storeid";

echo "<tr><td>$date_sold</td><td>$itemname</td>";
echo "<td><a href=\"receipt.php?func=show_receipt&receipt=$receipt_id\" class=\"linkbuttontiny linkbuttongray radiusall\">$receipt_id</a></td>";
echo "<td>$customername $company</td><td>";

if($woid != 0) {
echo "<a href=\"../repair/index.php?pcwo=$woid\" class=\"linkbuttontiny linkbuttongray radiusall\">$woid</a>";
}

echo "</td><td>";

if($invoice_id != 0) {
echo "<a href=\"invoice.php?func=printinv&invoice_id=$invoice_id\" class=\"linkbuttontiny linkbuttongray radiusall\">$invoice_id</a>";
}

echo "</td>";

$storeinfo = getstoreinfo($storeid);

echo "<td>$storeinfo[storesname]</td>";

echo "<td style=\"text-align:right;\">$money".mf("$ourprice")."</td>";
echo "<td style=\"text-align:right;\">$money".mf("$soldprice")."</td>";

echo "</tr>";

}
} else {
echo "<tr><td colspan=3>".pcrtlang("Sorry, No results found")."</td></tr>";
}


echo "</table>";

if(!isset($_REQUEST['printable'])) {
stop_box();
}


if(!isset($_REQUEST['printable'])) {
require("footer.php");
} else {
printablefooter();
}




}




function day_span_nii_csv() {


require("deps.php");

require_once("common.php");


perm_boot("5");

if (array_key_exists('dayto',$_REQUEST)) {
if ($_REQUEST['dayto'] != "") {
$dayto = $_REQUEST['dayto'];
} else {
$dayto = date("Y-m-d");
}
} else {
$dayto = date("Y-m-d");
}

if (array_key_exists('dayfrom',$_REQUEST)) {
if ($_REQUEST['dayfrom'] != "") {
$dayfrom = $_REQUEST['dayfrom'];
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}

$reportstoreid = $_REQUEST['reportstoreid'];


header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"non_inv_item_report.csv\"");



echo "\"".pcrtlang("Date")."\",\"".pcrtlang("Item Name")."\",";

echo "\"".pcrtlang("Receipt No.")."\",\"".pcrtlang("Customer Name")."\",";
echo "\"".pcrtlang("WO ID")."\",\"".pcrtlang("Invoice")."\",";
echo "\"".pcrtlang("Store")."\",";
echo "\"".pcrtlang("Cost")."\",";
echo "\"".pcrtlang("Price")."\"";

if ("$reportstoreid" == "all") {
$theq = "SELECT * FROM sold_items WHERE sold_type='purchase' AND date_sold <= '$dayto 23:59:59' AND date_sold >= '$dayfrom 00:00:00' AND stockid = '0' ORDER BY date_sold DESC LIMIT 500";
} else {
$theq = "SELECT * FROM sold_items,receipts WHERE sold_items.sold_type='purchase' AND receipts.storeid = '$reportstoreid' AND sold_items.receipt = receipts.receipt_id AND sold_items.date_sold <= '$dayto 23:59:59' AND sold_items.date_sold  >= '$dayfrom 00:00:00' AND stockid = '0' ORDER BY sold_items.date_sold DESC LIMIT 500";
}





$rs_result_nii_r = mysqli_query($rs_connect, $theq);

while($rs_result_rq = mysqli_fetch_object($rs_result_nii_r)) {
$receipt_id = "$rs_result_rq->receipt";
$date_sold = "$rs_result_rq->date_sold";
$itemname = "$rs_result_rq->labor_desc";
$soldprice = "$rs_result_rq->sold_price";
$ourprice = "$rs_result_rq->ourprice";

$theqc = "SELECT * FROM receipts WHERE receipt_id = '$receipt_id'";
$rs_result_nii_rc = mysqli_query($rs_connect, $theqc);
$rs_result_rqc = mysqli_fetch_object($rs_result_nii_rc);
$customername = "$rs_result_rqc->person_name";
$company = "$rs_result_rqc->company";
$invoice_id = "$rs_result_rqc->invoice_id";
$woid = "$rs_result_rqc->woid";
$storeid = "$rs_result_rqc->storeid";

echo "\n\"$date_sold\",\"$itemname\",";
echo "\"$receipt_id\",";
echo "\"$customername $company\",\"";

if($woid != 0) {
echo "$woid";
}

echo "\",\"";

if($invoice_id != 0) {
echo "$invoice_id";
}

echo "\",";

$storeinfo = getstoreinfo($storeid);

echo "\"$storeinfo[storesname]\",";

echo "\"".mf("$ourprice")."\",";
echo "\"".mf("$soldprice")."\"";


}




} 


                                                                                 

function managedstockreports() {

require("deps.php");
require_once("common.php");

$whattoshow = $_REQUEST['what'];

if (array_key_exists('printable',$_REQUEST)) {
$printable = $_REQUEST['printable'];
} else {
$printable = "no";
}

if($printable == "yes") {
printableheader(pcrtlang("Managed Stock Report"));
} else {
require_once("header.php");
}





if($whattoshow == "store") {
$rs_find_cart_items = "SELECT stockcounts.storeid,stock.stock_price,stock.stock_id,stock.stock_title,stockcounts.quantity,stockcounts.reorderqty,stockcounts.minstock,stockcounts.maxstock FROM stock,stockcounts
WHERE stockcounts.maintainstock = '1' AND stockcounts.minstock > stockcounts.quantity AND stockcounts.storeid = '$defaultuserstore' AND stock.stock_id = stockcounts.stockid
ORDER BY stock_id";
} else {
$rs_find_cart_items = "SELECT stockcounts.storeid,stock.stock_price,stock.stock_id,stock.stock_title,stockcounts.quantity,stockcounts.reorderqty,stockcounts.minstock,stockcounts.maxstock FROM stock,stockcounts
WHERE stockcounts.maintainstock = '1' AND stockcounts.minstock > stockcounts.quantity AND stock.stock_id = stockcounts.stockid
ORDER BY stock_id";
}


$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

if($printable != "yes") {
echo "<p style=\"text-align:right;\">";
echo "<a href=reports.php?func=managedstockreports&what=$whattoshow&printable=yes class=linkbutton><img src=images/print.png border=0 align=absmiddle> ".pcrtlang("Printable Version")."</a><br></p>";

if($whattoshow == "store") {
$storeinfoarray = getstoreinfo($defaultuserstore);
start_blue_box(pcrtlang("Managed Stock Report")." | ".pcrtlang("Store").": $storeinfoarray[storesname]");
} else {
start_blue_box(pcrtlang("Managed Stock Report")." | ".pcrtlang("All Stores"));
}
} else {
if($whattoshow == "store") {
$storeinfoarray = getstoreinfo($defaultuserstore);
echo "<h4>".pcrtlang("Managed Stock Report")." | ".pcrtlang("Store").": $storeinfoarray[storesname]</h4>";
} else {
echo "<h4>".pcrtlang("Managed Stock Report")." | ".pcrtlang("All Stores")."</h4>";
}
}

echo "<table class=standard>";
echo "<tr><th>".pcrtlang("Stock Id")."</th><th>".pcrtlang("Item Name")."</th>";
echo "<th width=10%>".pcrtlang("Current Quantity")."</th>";
echo "<th width=10%>".pcrtlang("Available Quantity")."</th>";
echo "<th>".pcrtlang("Re-Order Quantity")."</th>";
echo "<th>".pcrtlang("Min Stock")."</th>";
echo "<th>".pcrtlang("Max Stock")."</th>";

echo "<th>".pcrtlang("Store")."</th>";


echo "</tr>";

$previousstockid = 0;

$totalsarray[1] = 0;
$totalsarray[2] = 0;
$totalsarray[3] = 0;
$totalsarray[4] = 0;


while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_sold_price = "$rs_result_q->stock_price";
$rs_stockid = "$rs_result_q->stock_id";
$rs_partname2 = "$rs_result_q->stock_title";
$rs_quantity = "$rs_result_q->quantity";
$rs_minstock = "$rs_result_q->minstock";
$rs_maxstock = "$rs_result_q->maxstock";
$rs_reorderqty = "$rs_result_q->reorderqty";
$rs_storeid = "$rs_result_q->storeid";


$rs_find_rs = "SELECT * FROM inventory WHERE stock_id = '$rs_stockid' ORDER BY inv_date DESC LIMIT 1";

$rs_result_rs = mysqli_query($rs_connect, $rs_find_rs);
$rs_result_qrs = mysqli_fetch_object($rs_result_rs);
$supplierid = "$rs_result_qrs->supplierid";
$suppliername = "$rs_result_qrs->suppliername";
$parturl = "$rs_result_qrs->parturl";
$partnumber = "$rs_result_qrs->partnumber";





if(($whattoshow == "all") && ($previousstockid != $rs_stockid) && ($previousstockid != 0)) {
echo "<tr style=\"border-bottom: 5px solid #777777; border-top: 2px solid #777777;\"><td colspan=4>".pcrtlang("Store Totals")."</td>";
echo "<td style=\"text-align:right;\">";
echo "".pcrtlang("reorder qty").": $totalsarray[1]<br>";
echo "".pcrtlang("qty to min").": $totalsarray[2]<br>";
echo "".pcrtlang("qty to min + reorder qty").": <span class=colormeblue>$totalsarray[3]</span><br>";
echo "".pcrtlang("qty to max").": $totalsarray[4]";
echo "</td><td colspan=3></td></tr>";

$totalsarray[1] = 0;
$totalsarray[2] = 0;
$totalsarray[3] = 0;
$totalsarray[4] = 0;

}




$rs_partname = urlencode("$rs_partname2");

echo "<tr><td><a href=stock.php?func=show_stock_detail&stockid=$rs_stockid class=\"linkbuttonsmall linkbuttongray radiusall\">#$rs_stockid</td>";

$thestat = urlencode(pcrtlang("Need to Order"));

echo "<td><a href=stock.php?func=show_stock_detail&stockid=$rs_stockid class=\"linkbuttonsmall linkbuttongray radiusall\">$rs_partname2</a>";


if($supplierid != 0) {
$rs_find_suppliers = "SELECT * FROM suppliers WHERE supplierid = $supplierid";
$rs_result_supp = mysqli_query($rs_connect, $rs_find_suppliers);
$rs_result_suppq = mysqli_fetch_object($rs_result_supp);
$suppliername2 = "$rs_result_suppq->suppliername";
} else {
$suppliername2 = "$suppliername";
}


if(perm_check("23") && ($supplierid != 0)) {
echo "<br><a href=\"suppliers.php?func=viewsupplier&supplierid=$supplierid\" class=\"linkbuttonsmall linkbuttongray radiusall\">$suppliername2</a>";
} else {
echo "<br><span class=\"sizemesmaller\">$suppliername2</span>";
}


if($parturl != "") {
$parturl2 = addhttp("$parturl");
echo " <a href=\"$parturl2\" target=\"_blank\" class=\"linkbuttonsmall linkbuttongray radiusall\"><i class=\"fa fa-external-link fa-lg\"></i></a>";
}


if($partnumber != "") {
echo "<br><span class=\"sizemesmaller\">$partnumber</span>";
}

echo "</td>";


echo "<td style=\"text-align:center;\">$rs_quantity</td>";

$availableq = stockavailability($rs_stockid,$rs_storeid,$rs_quantity);

$qtytohitmin = $rs_minstock - $availableq['available'];
$qtytohitmax = $rs_maxstock - $availableq['available'];
$qtytominplusrecc = $qtytohitmin + $rs_reorderqty;

$totalsarray[1] = $rs_reorderqty + $totalsarray[1];
$totalsarray[2]	= $qtytohitmin + $totalsarray[2];
$totalsarray[3]	= $qtytominplusrecc + $totalsarray[3];
$totalsarray[4]	= $qtytohitmax + $totalsarray[4];

echo "<td style=\"text-align:center;\">$availableq[available]</td>";
echo "<td style=\"text-align:right;\">";
echo "".pcrtlang("reorder qty").": $rs_reorderqty<br>";
echo "".pcrtlang("qty to min").": $qtytohitmin<br>";
echo "".pcrtlang("qty to min + reorder qty").": <span class=colormeblue>$qtytominplusrecc</span><br>";
echo "".pcrtlang("qty to max").": $qtytohitmax";

echo "</td>";
echo "<td style=\"text-align:center;\">$rs_minstock</td>";
echo "<td style=\"text-align:center;\">$rs_maxstock</td>";

$storeinfoarray = getstoreinfo($rs_storeid);
$storesname = $storeinfoarray['storesname'];

echo "<td>$storesname</td>";


echo "</tr>";


$previousstockid = $rs_stockid;

        }


if(($whattoshow == "all")) {
echo "<tr style=\"border-bottom: 5px solid #777777; border-top: 2px solid #777777;\"><td colspan=4>".pcrtlang("Store Totals")."</td>";
echo "<td style=\"text-align:right;\">";
echo "".pcrtlang("reorder qty").": $totalsarray[1]<br>";
echo "".pcrtlang("qty to min").": $totalsarray[2]<br>";
echo "".pcrtlang("qty to min + reorder qty").": <span class=colormeblue>$totalsarray[3]</span><br>";
echo "".pcrtlang("qty to max").": $totalsarray[4]";
echo "</td><td colspan=3></td></tr>";
}



echo "</table>";

if($printable != "yes") {
stop_blue_box();
}
echo "<br>";

if($printable == "yes") {
printablefooter();
} else {
require("footer.php");
}

}



###############


function mileage_report() {

require("deps.php");
require_once("common.php");

if (array_key_exists('dayto',$_REQUEST)) {
if ($_REQUEST['dayto'] != "") {
$dayto = $_REQUEST['dayto'];
} else {
$dayto = date("Y-m-d");
}
} else {
$dayto = date("Y-m-d");
}

if (array_key_exists('dayfrom',$_REQUEST)) {
if ($_REQUEST['dayfrom'] != "") {
$dayfrom = $_REQUEST['dayfrom'];
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}
} else {
$dayfrom = date("Y-m-d",strtotime("last Sunday"));
}

$thetech = $_REQUEST['thetech'];

if (array_key_exists('printable',$_REQUEST)) {
$printable = $_REQUEST['printable'];
} else {
$printable = "yes";
}

if($printable == "yes") {
printableheader(pcrtlang("Mileage Report"));
} else {
require_once("header.php");
}





if($thetech == "all") {
$rs_find_ml_items = "SELECT * FROM travellog WHERE tldate <= '$dayto 23:59:59' AND tldate >= '$dayfrom 00:00:00'";
} else {
$rs_find_ml_items = "SELECT * FROM travellog WHERE traveluser = '$thetech' AND tldate <= '$dayto 23:59:59' AND tldate >= '$dayfrom 00:00:00'";
}


$rs_result = mysqli_query($rs_connect, $rs_find_ml_items);

echo "<span class=sizemelarger>".pcrtlang("Mileage Report")."</span><br><br>";

echo "<table class=\"standard lastalignright\">";
echo "<tr><th>".pcrtlang("Technician")."</th><th>".pcrtlang("Date")."</th>";
echo "<th>".pcrtlang("Work Order")."</th>";
echo "<th>".pcrtlang("Customer Name")."</th>";
echo "<th>".pcrtlang("Miles")."</th>";
echo "</tr>";

$totaldist = 0;

while($rs_result_item_q = mysqli_fetch_object($rs_result)) {
$tlid = "$rs_result_item_q->tlid";
$tlwo = "$rs_result_item_q->tlwo";
$tldate2 = "$rs_result_item_q->tldate";
$tlmiles = "$rs_result_item_q->tlmiles";
$traveluser = "$rs_result_item_q->traveluser";

$totaldist = $totaldist + $tlmiles;

$tldate = pcrtdate("$pcrt_time", "$tldate2")." ".pcrtdate("$pcrt_shortdate", "$tldate2");

$rs_find_pc = "SELECT pcid FROM pc_wo WHERE woid = '$tlwo'";
$rs_result_item = mysqli_query($rs_connect, $rs_find_pc);
$rs_result_item_q = mysqli_fetch_object($rs_result_item);
$pcidq = "$rs_result_item_q->pcid";


$rs_find_pcowner = "SELECT pcname FROM pc_owner WHERE pcid = $pcidq";
$rs_result_item_owner = mysqli_query($rs_connect, $rs_find_pcowner);
$rs_result_item_qo = mysqli_fetch_object($rs_result_item_owner);
$pcname = "$rs_result_item_qo->pcname";



echo "<tr><td>$traveluser</td>";

echo "<td>$tldate</td>";
echo "<td>$tlwo</td>";

echo "<td>$pcname</td>";






echo "<td>$tlmiles";

if("$pcrt_units" == "METRIC") {
echo pcrtlang("km");
} else {
echo " ".pcrtlang("miles");
}

echo "</td></tr>";

}



echo "<tr><td colspan=3></td><td>".pcrtlang("Total")."</td><td>$totaldist ";

if("$pcrt_units" == "METRIC") {
echo pcrtlang("km");
} else {
echo " ".pcrtlang("miles");
}


echo "</td></tr>";




echo "</table>";

echo "<br>";

printablefooter();

}



function registerhistory() {
require_once("header.php");
require("deps.php");

if (array_key_exists('registerid',$_REQUEST)) {
$registerid = $_REQUEST['registerid'];
} else {
$registerid = getcurrentregister();
}

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

if (array_key_exists('plugin',$_REQUEST)) {
$plugin = $_REQUEST['plugin'];
} else {
$plugin = "Cash";
}


$results_per_page = 40;

$rs_find_last_close = "SELECT regcloseid FROM regclose WHERE registerid = '$registerid' AND paymentplugin = '$plugin' ORDER BY closeddate DESC LIMIT 1";
$rs_result_lc = mysqli_query($rs_connect, $rs_find_last_close);
$totallc = mysqli_num_rows($rs_result_lc);
if($totallc != 0) {
$rs_result_registerlc = mysqli_fetch_object($rs_result_lc);
$rs_lastcloseid = "$rs_result_registerlc->regcloseid";
} else {
$rs_lastcloseid = 0;
}


$rs_regcloset = "SELECT * FROM regclose WHERE storeid = '$defaultuserstore' AND registerid = '$registerid' AND paymentplugin = '$plugin'";
$rs_find_regcloset = @mysqli_query($rs_connect, $rs_regcloset);


$totalentries = mysqli_num_rows($rs_find_regcloset);
$offset = ($pageNumber * $results_per_page) - $results_per_page;


start_box();
$rs_find_registers = "SELECT * FROM registers WHERE registerstoreid = '$defaultuserstore' ORDER BY registername ASC";
$rs_result_registers = mysqli_query($rs_connect, $rs_find_registers);

echo "<table style=\"width:100%\"><tr><td><span class=\"boldme sizemelarge\">";

if($registerid != 0) {
echo pcrtlang("Switch Register").":";
} else {
echo pcrtlang("Please Select a Register").":";
}


echo "</span></td><td>";
echo "<form method=post action=reports.php?func=registerhistory>";
echo "<select name=registerid onchange='this.form.submit()'>";

if ($registerid == 0) {
echo "<option selected value=0></option>";
} else {
echo "<option value=0></option>";
}


while($rs_result_registerq = mysqli_fetch_object($rs_result_registers)) {
$rs_registername = "$rs_result_registerq->registername";
$rs_registerid = "$rs_result_registerq->registerid";

if ($rs_registerid == $registerid) {
echo "<option selected value=$rs_registerid>$rs_registername</option>";
} else {
echo "<option value=$rs_registerid>$rs_registername</option>";
}

}
echo "</select></form></td><td style=\"width:50%\">";

echo "<a href=cart.php?func=register_close&registerid=$registerid class=\"linkbuttonmedium linkbuttonred radiusall floatright\"><i class=\"fa fa-money fa-lg\"></i> ".pcrtlang("Close Register")."</a>";


echo "</td></tr></table>";

stop_box();

echo "<br>";


start_color_box("51",pcrtlang("Register Closing History"));
echo "<table class=standard>";
echo "<tr><th>".pcrtlang("Register")."#&nbsp;&nbsp;</th><th>".pcrtlang("Close Date")."&nbsp;&nbsp;</th><th>".pcrtlang("Closed By")."&nbsp;&nbsp;</th>
<th style=\"text-align:right;\">".pcrtlang("Count Total")."</th>
<th style=\"text-align:right;\">".pcrtlang("Expected Total")."</th>
<th style=\"text-align:right;\">".pcrtlang("Difference")."</th>
<th style=\"text-align:right;\">".pcrtlang("Removed Funds")."</th>
<th style=\"text-align:right;\">".pcrtlang("Balance Forward")."</th>
";

echo "<th></th></tr>";

$rs_regclose = "SELECT * FROM regclose WHERE storeid = '$defaultuserstore' AND registerid = '$registerid' ORDER BY closeddate DESC LIMIT $offset,$results_per_page";
$rs_find_regclose = @mysqli_query($rs_connect, $rs_regclose);

while($rs_find_rc_q = mysqli_fetch_object($rs_find_regclose)) {
$regcloseid = "$rs_find_rc_q->regcloseid";
$registerid = "$rs_find_rc_q->registerid";
$regstoreid = "$rs_find_rc_q->storeid";
$paymentplugin = "$rs_find_rc_q->paymentplugin";
$opendate = "$rs_find_rc_q->opendate";
$closeddate = "$rs_find_rc_q->closeddate";
$closedby = "$rs_find_rc_q->closedby";
$counttotal = "$rs_find_rc_q->counttotal";
$expectedtotal = "$rs_find_rc_q->expectedtotal";
$variance = "$rs_find_rc_q->variance";
$balanceforward = "$rs_find_rc_q->balanceforward";
$removedtotal = "$rs_find_rc_q->removedtotal";
$countarray = serializedarraytest("$rs_find_rc_q->countarray");
$notes = "$rs_find_rc_q->notes";

$closeddate2 = pcrtdate("$pcrt_time", "$closeddate")." ".pcrtdate("$pcrt_shortdate", "$closeddate");

echo "<tr><td>$registerid</td><td>$closeddate2</td>";

echo "<td>$closedby</td>";
echo "<td style=\"text-align:right;\">$money".mf("$counttotal")."</td>";
echo "<td style=\"text-align:right;\">$money".mf("$expectedtotal")."</td>";
echo "<td style=\"text-align:right;\">$money".mf("$variance")."</td>";
echo "<td style=\"text-align:right;\">$money".mf("$removedtotal")."</td>";
echo "<td style=\"text-align:right;\">$money".mf("$balanceforward")."</td>";

echo "<td>";

echo "&nbsp;&nbsp;&nbsp;<a href=\"javascript:void(0);\" class=\"linkbuttongray linkbuttonsmall radiusall\" style=\"float:right;\" 
id=regchange$regcloseid><i class=\"fa fa-chevron-down\"></i></a>";

echo "<tr><td colspan=9 style=\"border-bottom: #777777 2px solid;\"><div id=regbox$regcloseid style=\"display:none;\">";

echo "<table class=standard><tr><th style=\"width:45%\">".pcrtlang("Count")."</th><th style=\"width:10%\"></th><th style=\"width:45%\">".pcrtlang("Payments")."</th><tr><tr><td style=\"vertical-align:top;\"><table class=standard>";
echo "<tr><th style=\"text-align:right;\">".pcrtlang("Denomination")."</th><th style=\"text-align:right;\">".pcrtlang("Count")."</th><th style=\"text-align:right;\">".pcrtlang("Total")."</th></tr>";
foreach($countarray as $key => $val) {
if($val != 0) {
$total = $key * $val;
echo "<tr><td style=\"text-align:right;\">$key:</td><td style=\"text-align:right;\">$val</td><td style=\"text-align:right;\">$money".mf("$total")."</td></tr>";
}
}
echo "</table></td><td></td><td style=\"vertical-align:top;\"><table class=standard>";



$rs_find_sales = "SELECT * FROM savedpayments WHERE paymentdate <= '$closeddate' AND paymentdate  >= '$opendate'
AND paymentplugin = '$paymentplugin' AND registerid = '$registerid'";
$rs_result_sales = mysqli_query($rs_connect, $rs_find_sales);

$totalentry = mysqli_num_rows($rs_result_sales);
if(($totalentry > 0) && ($opendate != "0000-00-00 00:00:00")) {
echo "<tr><th colspan=4>".pcrtlang("Payments Received")."</th></tr>";


while ($rs_result_sales_q = mysqli_fetch_object($rs_result_sales)) {
$amount = "$rs_result_sales_q->amount";
$receipt = "$rs_result_sales_q->receipt_id";
echo "<tr><td>".pcrtlang("On Receipt").":</td><td><a href=receipt.php?func=show_receipt&receipt=$receipt class=\"linkbuttonsmall linkbuttongray radiusall\">#$receipt</a></td><td>".pcrtlang("Payment").":</td><td><i class=\"fa fa-plus\"></i> $money".mf("$amount")."</td></tr>";
}
}

$rs_find_rdeposits = "SELECT * FROM deposits WHERE depdate <= '$closeddate' AND depdate  >= '$opendate'
AND paymentplugin = '$paymentplugin' AND registerid = '$registerid'";
$rs_result_rdeposits = mysqli_query($rs_connect, $rs_find_rdeposits);

$totalentry = mysqli_num_rows($rs_result_rdeposits);
if(($totalentry > 0) && ($opendate != "0000-00-00 00:00:00")) {
echo "<tr><th colspan=4>".pcrtlang("Deposits Received")."</th></tr>";



while ($rs_result_rdeposits_q = mysqli_fetch_object($rs_result_rdeposits)) {
$amount = "$rs_result_rdeposits_q->amount";
$deposit = "$rs_result_rdeposits_q->depositid";
echo "<tr><td>".pcrtlang("Deposit ID").":</td><td>$depositid</td><td>".pcrtlang("Received Amount").":</td><td><i class=\"fa fa-plus\"></i> $money".mf("$amount")."</td></tr>";
}
}

$rs_find_adeposits = "SELECT * FROM deposits WHERE applieddate <= '$closeddate' AND applieddate  >= '$opendate'
AND paymentplugin = '$paymentplugin' AND registerid = '$registerid'";
$rs_result_adeposits = mysqli_query($rs_connect, $rs_find_adeposits);

$totalentry = mysqli_num_rows($rs_result_adeposits);
if(($totalentry > 0) && ($opendate != "0000-00-00 00:00:00")) {
echo "<tr><th colspan=4>".pcrtlang("Applied Deposits")."</th></tr>";


while ($rs_result_adeposits_q = mysqli_fetch_object($rs_result_adeposits)) {
$amount = "$rs_result_adeposits_q->amount";
$depositid = "$rs_result_adeposits_q->depositid";
echo "<tr><td>".pcrtlang("Deposit ID")."</td><td>$depositid</td><td>".pcrtlang("Applied Amount").":</td><td><i class=\"fa fa-minus\"></i> $money".mf("$amount")."</td></tr>";
}
}

echo "</table>";

if($notes != "") {
echo "<br><span class=\"sizemelarge boldme\">".pcrtlang("Notes")."</span><br>".nl2br("$notes");
}


if(($rs_lastcloseid == 0 || $regcloseid == $rs_lastcloseid)) {
echo "<br><br><a href=reports.php?func=delrc&regcloseid=$regcloseid&registerid=$registerid
onClick=\"return confirm('".pcrtlang("Are you sure you wish to delete this entry?")."');\"
 class=\"linkbuttonmedium linkbuttonred radiusall floatright\"><i class=\"fa fa-times fa-lg\"></i> ".pcrtlang("Delete this register closing entry?")." </a>";
}


echo "</td></tr></table>";



echo "</div></td></tr>";

?>
<script type='text/javascript'>
$('#regchange<?php echo "$regcloseid"; ?>').click(function(){
  $('#regbox<?php echo "$regcloseid"; ?>').toggle('1000');
  $("i",this).toggleClass("fa-chevron-up fa-chevron-down");
});
</script>
<?php


echo "</td></tr>";
}
echo "</table>";

echo "<br>";

#browse here
$totalentry = mysqli_num_rows($rs_find_regcloset);
$prevpage = $pageNumber - 1;
$nextpage = $pageNumber + 1;

echo "<center>";

if ($pageNumber > 1) {
echo "<a href=reports.php?func=registerhistory&pageNumber=$prevpage&registerid=$registerid class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-left fa-lg\"></i></a>&nbsp;";
}

$total_results = $totalentry;
$results_per_page = $results_per_page;
$html = get_paged_nav($total_results, $results_per_page, false);
if (!preg_match("/registerid/i", "$html")) {
$html = str_replace("pageNumber", "registerid=$registerid"."&pageNumber", "$html");
}
echo "$html";
if (($totalentry / $results_per_page) > $pageNumber) {
echo "<a href=reports.php?func=registerhistory&pageNumber=$nextpage&registerid=$registerid class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-right fa-lg\"></i></a>";
}

echo "</center>";





stop_color_box();







require_once("footer.php");
                                                                                                    
}


function delrc() {
require_once("validate.php");
$regcloseid = $_REQUEST['regcloseid'];
$registerid = $_REQUEST['registerid'];

require("deps.php");
require("common.php");

$rs_delete_rc = "DELETE FROM regclose WHERE regcloseid = '$regcloseid'";
@mysqli_query($rs_connect, $rs_delete_rc);

header("Location: reports.php?func=registerhistory&registerid=$registerid");

}


function addserialafter() {
require_once("validate.php");

require("deps.php");
require("common.php");

require_once("header.php");

start_blue_box(pcrtlang("Enter Serial/Code?"));

$stockid = $_REQUEST['stockid'];
$pcwo = $_REQUEST['pcwo'];
$cart_item_id = $_REQUEST['cart_item_id'];

$availser = available_serials($stockid);

echo "<form action=repcart.php?func=addserialafter2 method=post><table>";
if (count($availser) != 0) {
echo "<tr><td>".pcrtlang("Pick Serial").":<form action=repcart.php?func=addserialafter2 method=post></td>";
echo "<td><select name=itemserialchooser onchange='document.getElementById(\"itemserial\").value=this.options[this.selectedIndex].value '>";
echo "<option value=\"\">".pcrtlang("(optional) choose a serial/code or type one below")."</option>";
foreach($availser as $key => $val) {
if($val != "") {

$rs_find_store = "SELECT * FROM inventory WHERE itemserial LIKE '%$val%' AND stock_id = '$stockid' LIMIT 1";
$rs_find_store_q = @mysqli_query($rs_connect, $rs_find_store);
$rs_find_result_q = mysqli_fetch_object($rs_find_store_q);
$rs_storeid = "$rs_find_result_q->storeid";
$storeinfo = getstoreinfo($rs_storeid);


echo "<option value=\"$val\">$storeinfo[storesname] &bull; $val</option>";
}
}
echo "</select></td></tr>";
}
echo "<tr><td>".pcrtlang("Serial/Code (optional)").":</td>";
echo "<td><input type=text cols=30 name=itemserial id=itemserial class=textbox><input type=hidden name=stockid value=\"$stockid\"><input type=hidden name=pcwo value=\"$pcwo\"></td></tr>";
echo "<tr><td><input type=hidden name=cart_item_id value=\"$cart_item_id\"><input type=submit value=\"".pcrtlang("Save")."\" class=button></form></td><td></td></tr>";

echo "</table>";


stop_blue_box();
require_once("footer.php");

}



function addserialafter2() {
require_once("validate.php");
require("deps.php");
require("common.php");

$stockid = $_REQUEST['stockid'];
$itemserial = pv($_REQUEST['itemserial']);
$pcwo = $_REQUEST['pcwo'];
$cart_item_id = $_REQUEST['cart_item_id'];

$qty = 1;

$availser = available_serials($stockid);
$availserl = array_map('strtolower', $availser);
if(in_array(strtolower("$itemserial"), $availserl) && !in_array("$itemserial", $availser)) {
$key = array_search(strtolower("$itemserial"), $availserl);
$itemserial = $availser[$key];
}

$rs_update_rc = "UPDATE repaircart SET itemserial = '$itemserial' WHERE cart_item_id = '$cart_item_id'";
$rs_find_stock_price = @mysqli_query($rs_connect, $rs_update_rc);


header("Location: index.php?pcwo=$pcwo#repaircart");

}


######

switch($func) {
                                                                                                    
    default:
    reportlist();
    break;
                                
    case "day_span_pl":
    day_span_pl();
    break;

   case "year_pl":
    year_pl();
    break;


    case "quarter_pl":
    quarter_pl();
    break;

    case "month_pl":
    month_pl();
    break;

   case "day_span_asr":
    day_span_asr();
    break;


    case "day_span_ar":
    day_span_ar();
    break;

    case "day_span_pr":
    day_span_pr();
    break;

    case "day_span_psr":
    day_span_psr();
    break;


}


