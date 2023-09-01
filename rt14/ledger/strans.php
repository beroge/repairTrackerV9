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

                                                                                                    
function transactions() {
require_once("header.php");
require("deps.php");

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}

$thedate = date("Y-m-d");

if (array_key_exists('pageNumber',$_REQUEST)) {
$pageNumber = $_REQUEST['pageNumber'];
} else {
$pageNumber = "1";
}



echo "<i class=\"fa fa-search fa-lg\"></i> <input type=text class=\"textbox\" id=searchbox placeholder=\"".pcrtlang("Enter Search Text")."\"><br><br>";



echo "<div id=transmaster style=\"width:95%\"></div><br><br>\n\n";

?>
<script type="text/javascript">
  $.get('strans.php?func=transviewer&pageNumber=<?php echo "$pageNumber"; ?>', function(data) {
    $('#transmaster').html(data);
  });
</script>

<script type="text/javascript">
$(document).ready(function(){
  var globalTimeoutrs = null;
  $("input#searchbox").keyup(function(){
                        if (globalTimeoutrs != null) {
                        clearTimeout(globalTimeoutrs);
                        }
                        var encodedinv = encodeURIComponent(this.value);
                        var searchlength = this.value.length;
                        globalTimeoutrs = setTimeout(function() {
                        globalTimeoutrs = null;
                         if(searchlength<3) {
                          $('div#transmaster').load('strans.php?func=transviewer').slideDown(200,function(){
                                return false;
                          });
                          } else {
                          $('div#transmaster').load('strans.php?func=transviewer&search='+encodedinv).slideDown(200);
                          }
                        }, 500);
  });
});
</script>


<?php


echo "<div style=\"position:fixed;z-index:5;bottom:0px;right:0px;padding:2px 0px 0px 0px;background:#777777;width:70%;box-sizing:border-box;box-shadow: 0px -3px 3px 0px rgba(0,0,0,0.29);\">";
echo "<form action=strans.php?func=newtransaction method=post id=transactionform>";
echo "<table class=standard>";
#echo "<tr><th style=\"width:125px\">".pcrtlang("Date").":</th><th style=\"width:100px\">".pcrtlang("Number")."</th><th colspan=3>".pcrtlang("Description").":</th></tr>";
echo "<tr>
<td style=\"width:50px\"><input type=\"date\" name=transdate class=textbox value=\"$thedate\"></td>
<td style=\"width:100px\"><input name=transnumber style=\"width:80px;\" class=textbox placeholder=\"".pcrtlang("number")."\"></td>
<td style=\"width:400px;\"><input name=transdesc class=textbox style=\"width:390px;box-sizing:border-box\" placeholder=\"".pcrtlang("transaction description")."\"></td>";
echo "<td style=\"text-align:center\"><span class=sizemelarger>".pcrtlang("Total")." $money</span><input type=\"text\" disabled name=\"total\" id=\"total\" class=textbox style=\"width:100px;border:none;font-size:16px;\" value=\"0.00\"></td>";
echo "<td><a id=\"add\" href=\"javascript:void(0)\" class=\"linkbuttongray linkbuttontiny radiusleft\"><i class=\"fa fa-plus fa-lg\"></i></a>";
echo "<a id=\"DeleteButton\" href=\"javascript:void(0)\" class=\"linkbuttongray linkbuttontiny radiusright\"><i class=\"fa fa-minus fa-lg\"></i></a>";

echo "</td></tr></table>";

echo "<table class=standard id=translineitems>";
#echo "<tr><td style=\"background:#cccccc;width:20%\">".pcrtlang("Account")."</td>";
#echo "<td style=\"background:#cccccc;width:25%\">".pcrtlang("Detail Description")." (".pcrtlang("optional").")</td>";
#echo "<td style=\"background:#cccccc;width:20%\">".pcrtlang("Payee")."</td>";
#echo "<td style=\"background:#cccccc;width:15%\">".pcrtlang("Expense")."</td>";
#echo "<td style=\"background:#cccccc;width:15%\">".pcrtlang("Income")."</td>";
#echo "<td style=\"background:#cccccc;width:5%\"><a id=\"add\" href=\"javascript:void(0)\" class=\"linkbuttongray linkbuttontiny radiusall floatright\">
#<i class=\"fa fa-plus fa-lg\"></i></a>";
#echo "</td></tr>";

echo "<tr><td style=\"width:20%\"><select name=account[] required>";
echo "<option value=\"\" selected disabled style=\"font-weight:bold\">".pcrtlang("Account")."</option>";
echo "<option disabled value=\"\" style=\"background:#eeeeee\">".pcrtlang("Expense")."</option>";
$rs_find_income = "SELECT * FROM glsaccounts WHERE accounttype = 'expense' AND ledgerid = '$userledgerid' ORDER BY accountname ASC";
$rs_result_income = mysqli_query($rs_connect,$rs_find_income);
while($rs_result_incomeq = mysqli_fetch_object($rs_result_income)) {
$accountid = "$rs_result_incomeq->accountid";
$accountname = "$rs_result_incomeq->accountname";
echo "<option value=$accountid>$accountname</option>";
}


echo "<option disabled value=\"\" style=\"background:#eeeeee;\">".pcrtlang("Income")."</option>";
$rs_find_income = "SELECT * FROM glsaccounts WHERE accounttype = 'income' AND ledgerid = '$userledgerid' ORDER BY accountname ASC";
$rs_result_income = mysqli_query($rs_connect,$rs_find_income);
while($rs_result_incomeq = mysqli_fetch_object($rs_result_income)) {
$accountid = "$rs_result_incomeq->accountid";
$accountname = "$rs_result_incomeq->accountname";
echo "<option value=$accountid>$accountname</option>";
}

echo "<option disabled value=\"\" style=\"background:#eeeeee;\">".pcrtlang("Liabilities")."</option>";
$rs_find_liability = "SELECT * FROM glsaccounts WHERE accounttype = 'liability' AND ledgerid = '$userledgerid' ORDER BY accountname ASC";
$rs_result_liability = mysqli_query($rs_connect,$rs_find_liability);
while($rs_result_liabilityq = mysqli_fetch_object($rs_result_liability)) {
$accountid = "$rs_result_liabilityq->accountid";
$accountname = "$rs_result_liabilityq->accountname";
echo "<option value=$accountid>$accountname</option>";
}


echo "</select></td><td style=\"width:25%\"><input type=text class=textbox name=transdetdesc[] style=\"width:100%;box-sizing:border-box;\" placeholder=\"".pcrtlang("detail description - optional")."\"></td>";

?>
<script src="../repair/jq/select2.min.js"></script>
<link rel="stylesheet" href="../repair/jq/select2.min.css">
<?php


echo "<td style=\"width:20%\"><select class=\"select-payee\" name=payee[]\">";
echo "<option value=0>".pcrtlang("No Payee")."</option>";
$rs_find_payees = "SELECT * FROM glpayees ORDER BY payeename ASC";
$rs_result_payees = mysqli_query($rs_connect,$rs_find_payees);
while($rs_result_payeesq = mysqli_fetch_object($rs_result_payees)) {
$payeeid = "$rs_result_payeesq->payeeid";
$payeename = "$rs_result_payeesq->payeename";
echo "<option value=$payeeid>$payeename</option>";
}
echo "</select></td>";

?>
<script>
$(document).ready(function() {
    $('.select-payee').select2();
});
</script>
<?php



echo "<td style=\"width:15%\">$money<input type=text autocomplete=off class=\"textbox colormedarkred\" name=expense[] onKeyUp=\"findTotal()\" style=\"width:100px\" placeholder=\"".pcrtlang("expense")."\"></td>";

echo "<td style=\"width:15%\">$money<input type=text autocomplete=off class=\"textbox colormedarkgreen\" name=income[] style=\"width:100px;\" onKeyUp=\"findTotalCredit()\" placeholder=\"".pcrtlang("income")."\"></td>";


echo "</tr>";

echo "</table>";

echo "<table class=\"standard\"><tr><td style=\"width:65%;text-align:center;\">";
echo "<button class=\"button\" type=submit id=submitbutton style=\"width:200px;\"><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save Transaction")."</button>";
echo "</td><td style=\"width:15%\">$money<input disabled type=\"text\" name=\"debittotal\" id=\"debittotal\" 
class=textbox style=\"width:100px;border:none\" value=\"0.00\"></td><td style=\"width:15%\">$money<input type=\"text\" disabled name=\"credittotal\" id=\"credittotal\" 
class=textbox style=\"width:100px;border:none\" value=\"0.00\"></td></tr>";
echo "</table>";

?>


   <script type="text/javascript">
function findTotal(){
    var arr = document.getElementsByName("expense[]");
    var tot=0;
    for(var i=0;i<arr.length;i++){
        if(parseFloat(arr[i].value))
            tot += parseFloat(arr[i].value);
    }
    document.getElementById('debittotal').value = tot.toFixed(2);
    document.getElementById('total').value = (document.getElementById('credittotal').value - tot).toFixed(2);
}
function findTotalCredit(){
    var arrcredit = document.getElementsByName("income[]");
    var totcredit=0;
    for(var i=0;i<arrcredit.length;i++){
        if(parseFloat(arrcredit[i].value))
            totcredit += parseFloat(arrcredit[i].value);
    }
    document.getElementById('credittotal').value = totcredit.toFixed(2);
    document.getElementById('total').value =  (totcredit - document.getElementById('debittotal').value).toFixed(2);
}

    </script>

<?php

echo "</form>";

?>
<script type="text/javascript">
    $(document).ready(function() {
        $("#add").click(function() {
          $('.select-payee').select2("destroy");
	  $('#translineitems tbody>tr:last').clone(true).insertAfter('#translineitems tbody>tr:last');
          $('.select-payee').select2();
         return false;
        });
    });

    $("#DeleteButton").click(function() {
          $('.select-payee').select2("destroy");
          $('#translineitems tbody>tr:last').not(':first-child').remove();
          $('.select-payee').select2();
    });

</script>

<script type='text/javascript'>
$(document).ready(function(){
$('#transactionform').submit(function(e) { // catch the form's submit event
        e.preventDefault();
        $.ajax({ // create an AJAX call...
        data: $(this).serialize(), // get the form data
        type: $(this).attr('method'), // GET or POST
        url: $(this).attr('action'), // the file to call
        success: function(response) { // on success..
                $.get('strans.php?func=transviewer', function(data) {
                $('#transmaster').html(data);
                });
        $("#translineitems").find("tr:gt(0)").remove();
        $('#transactionform').each (function(){
          this.reset();
        });
	$(".select-payee").select2("val", "0");
    }
    });
});
});
</script>

<?php


echo "</div>";
#End Trans Add


echo "<div style=\"height:150px;\"></div>";


require_once("footer.php");
                                                                                                    
}




function newtransaction() {
require_once("validate.php");
require("deps.php");
require("common.php");       

#echo "<pre>";
#print_r($_REQUEST);
#die();

$transdate = $_REQUEST['transdate'];
$transnumber = $_REQUEST['transnumber'];
$transdesc = $_REQUEST['transdesc'];
$account = $_REQUEST['account'];
$payee = $_REQUEST['payee'];
$expense = $_REQUEST['expense'];
$income = $_REQUEST['income'];
$transdetdesc = $_REQUEST['transdetdesc'];

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currenttime = date('H:i:s');



$rs_insert_trans = "INSERT INTO glstrans (transdate,transnumber,transdesc,ledgerid) VALUES ('$transdate $currenttime','$transnumber','$transdesc','$userledgerid')";
@mysqli_query($rs_connect, $rs_insert_trans);
                        
$transid = mysqli_insert_id($rs_connect);

foreach($account as $key => $val) {

if($expense[$key] == "") {
$expense[$key] = 0;
}
if($income[$key] == "") {
$income[$key] = 0;
}

if (($expense[$key] != "") || ($income[$key] != "")) {
if (($expense[$key] > 0) || ($income[$key] > 0)) {
$rs_insert_transdet = "INSERT INTO glstransdet (transid,accountid,expense,income,transdetdesc,payee) 
VALUES ('$transid','$account[$key]','$expense[$key]','$income[$key]','$transdetdesc[$key]','$payee[$key]')";
@mysqli_query($rs_connect, $rs_insert_transdet);
}
}
}
       
header("Location: strans.php");

}


function deletetrans() {
require_once("validate.php");
require("deps.php");
require("common.php");

$transid = pv($_REQUEST['transid']);
$pageNumber = pv($_REQUEST['pageNumber']);


$rs_delete_trans = "DELETE FROM glstrans WHERE transid = $transid";
@mysqli_query($rs_connect, $rs_delete_trans);

$rs_delete_trans2 = "DELETE FROM glstransdet WHERE transid = $transid";
@mysqli_query($rs_connect, $rs_delete_trans2);

$rs_clear_baddebt = "UPDATE glstrans SET baddebttransid = '0' WHERE baddebttransid = $transid";
@mysqli_query($rs_connect, $rs_clear_baddebt);

#header("Location: strans.php?pageNumber=$pageNumber");

}




function edittrans() {
require_once("header.php");
require("deps.php");

$transid = pv($_REQUEST['transid']);
$pageNumber = pv($_REQUEST['pageNumber']);
start_blue_box(pcrtlang("Edit Transaction"));


$rs_find_trans = "SELECT * FROM glstrans WHERE transid = '$transid'";
$rs_result_trans = mysqli_query($rs_connect,$rs_find_trans);
$rs_result_transq = mysqli_fetch_object($rs_result_trans);
$transnumber = "$rs_result_transq->transnumber";
$transdate2 = "$rs_result_transq->transdate";
$transdesc = "$rs_result_transq->transdesc";

$transdate = date('Y-m-d',strtotime($transdate2));
$transtime = date('H:i:s',strtotime($transdate2));

echo "<form action=strans.php?func=edittrans2 method=post id=transactionform>";
echo "<table class=standard>";
echo "<tr><th style=\"width:125px\">".pcrtlang("Date").":</th><th style=\"width:100px\">".pcrtlang("Number")."</th><th colspan=3>".pcrtlang("Description").":</th></tr>";
echo "<tr><td><input type=\"date\" name=transdate class=textbox value=\"$transdate\" style=\"width:120px\"></td>";
echo "<td><input name=transnumber class=textbox style=\"width:75px;\" value=\"$transnumber\"></td><td>
<input name=transdesc class=textbox style=\"width:100%;box-sizing:border-box\" value=\"$transdesc\">
<input type=hidden name=transid value=$transid><input type=hidden name=transtime value=$transtime><input type=hidden name=pageNumber value=$pageNumber></td>";
echo "</tr></table>";

echo "<table class=standard id=translineitems>";
echo "<tr><td style=\"background:#cccccc;width:20%\">".pcrtlang("Account")."</td>";
echo "<td style=\"background:#cccccc;width:25%\">".pcrtlang("Detail Description")." (".pcrtlang("optional").")</td>";
echo "<td style=\"background:#cccccc;width:20%\">".pcrtlang("Payee")."</td>";
echo "<td style=\"background:#cccccc;width:15%\">".pcrtlang("Expense")."</td>";
echo "<td style=\"background:#cccccc;width:15%\">".pcrtlang("Income")."</td>";
echo "<td style=\"background:#cccccc;width:5%\"><a id=\"add\" href=\"javascript:void(0)\" class=\"linkbuttongray linkbuttontiny radiusall floatright\">
<i class=\"fa fa-plus fa-lg\"></i></a>";
echo "</td></tr>";

$rs_find_transdet = "SELECT * FROM glstransdet WHERE transid = '$transid'";
$rs_result_transdet = mysqli_query($rs_connect,$rs_find_transdet);
while($rs_result_transdetq = mysqli_fetch_object($rs_result_transdet)) {
$selaccountid = "$rs_result_transdetq->accountid";
$expense = mf("$rs_result_transdetq->expense");
$income = mf("$rs_result_transdetq->income");
$transdetdesc = "$rs_result_transdetq->transdetdesc";
$selpayeeid = "$rs_result_transdetq->payee";

echo "<tr><td><select name=account[] required>";
echo "<option value=0 disabled style=\"font-weight:bold\">".pcrtlang("Select Account")."</option>";
echo "<option disabled value=0 style=\"background:#eeeeee\">".pcrtlang("Expense")."</option>";
$rs_find_income = "SELECT * FROM glsaccounts WHERE accounttype = 'expense' AND ledgerid = '$userledgerid'";
$rs_result_income = mysqli_query($rs_connect,$rs_find_income);
while($rs_result_incomeq = mysqli_fetch_object($rs_result_income)) {
$accountid = "$rs_result_incomeq->accountid";
$accountname = "$rs_result_incomeq->accountname";
if($accountid == $selaccountid) {
echo "<option selected value=$accountid>$accountname</option>";
} else {
echo "<option value=$accountid>$accountname</option>";
}
}

echo "<option disabled value=0 style=\"background:#eeeeee;\">".pcrtlang("Income")."</option>";
$rs_find_income = "SELECT * FROM glsaccounts WHERE accounttype = 'income' AND ledgerid = '$userledgerid'";
$rs_result_income = mysqli_query($rs_connect,$rs_find_income);
while($rs_result_incomeq = mysqli_fetch_object($rs_result_income)) {
$accountid = "$rs_result_incomeq->accountid";
$accountname = "$rs_result_incomeq->accountname";
if($accountid == $selaccountid) {
echo "<option selected value=$accountid>$accountname</option>";
} else {
echo "<option value=$accountid>$accountname</option>";
}
}

echo "<option disabled value=0 style=\"background:#eeeeee;\">".pcrtlang("Liabilities")."</option>";
$rs_find_liability = "SELECT * FROM glsaccounts WHERE accounttype = 'liability' AND ledgerid = '$userledgerid'";
$rs_result_liability = mysqli_query($rs_connect,$rs_find_liability);
while($rs_result_liabilityq = mysqli_fetch_object($rs_result_liability)) {
$accountid = "$rs_result_liabilityq->accountid";
$accountname = "$rs_result_liabilityq->accountname";
if($accountid == $selaccountid) {
echo "<option selected value=$accountid>$accountname</option>";
} else {
echo "<option value=$accountid>$accountname</option>";
}
}


echo "</select></td><td><input type=text class=textbox name=transdetdesc[] value=\"$transdetdesc\" style=\"width:100%;box-sizing:border-box;\"></td>";

echo "<td><select name=payee[] class=select-payee>";
echo "<option value=0>".pcrtlang("None")."</option>";
$rs_find_payees = "SELECT * FROM glpayees ORDER BY payeename ASC";
$rs_result_payees = mysqli_query($rs_connect,$rs_find_payees);
while($rs_result_payeesq = mysqli_fetch_object($rs_result_payees)) {
$payeeid = "$rs_result_payeesq->payeeid";
$payeename = "$rs_result_payeesq->payeename";
if($payeeid == $selpayeeid) {
echo "<option selected value=$payeeid>$payeename</option>";
} else {
echo "<option value=$payeeid>$payeename</option>";
}
}
echo "</select></td>";



echo "<td>$money<input type=text class=textbox name=expense[] onKeyUp=\"findTotal()\" style=\"width:100px\" value=\"$expense\"></td>";

echo "<td>$money<input type=text class=textbox name=income[] style=\"width:100px;\" onKeyUp=\"findTotalCredit()\" value=\"$income\"></td><td></td></tr>";

}

echo "</table>";

echo "<table class=\"standard\"><tr><td style=\"width:65%\"></td><td style=\"width:15%\">$money<input disabled type=\"text\" name=\"debittotal\" id=\"debittotal\"
class=textbox style=\"width:100px;border:none\" value=\"0.00\"></td><td style=\"width:15%\">$money<input type=\"text\" disabled name=\"credittotal\" id=\"credittotal\"
class=textbox style=\"width:100px;border:none\" value=\"0.00\"></td><td style=\"width:5%\"></td></tr>";

echo "<tr><td></td><td>".pcrtlang("Total")."</td><td>$money<input type=\"text\" disabled name=\"total\" id=\"total\" class=textbox style=\"width:100px;border:none\"
value=\"0.00\"></td></tr></table>";

?>

<link rel="stylesheet" href="../repair/jq/select2.min.css">
<script src="../repair/jq/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('.select-payee').select2();
});
</script>



   <script type="text/javascript">
function findTotal(){
    var arr = document.getElementsByName("expense[]");
    var tot=0;
    for(var i=0;i<arr.length;i++){
        if(parseFloat(arr[i].value))
            tot += parseFloat(arr[i].value);
    }
    document.getElementById('debittotal').value = tot.toFixed(2);
    document.getElementById('total').value = (document.getElementById('credittotal').value - tot).toFixed(2);
}
function findTotalCredit(){
    var arrcredit = document.getElementsByName("income[]");
    var totcredit=0;
    for(var i=0;i<arrcredit.length;i++){
        if(parseFloat(arrcredit[i].value))
            totcredit += parseFloat(arrcredit[i].value);
    }
    document.getElementById('credittotal').value = totcredit.toFixed(2);
    document.getElementById('total').value =  (totcredit - document.getElementById('debittotal').value).toFixed(2);
}

    </script>

<?php


echo "<button class=button type=submit id=submitbutton><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button>";

echo "</form>";

?>
<script type="text/javascript">
    $(document).ready(function() {
        $("#add").click(function() {
		 $('.select-payee').select2("destroy");
          $('#translineitems tbody>tr:last').clone(true).insertAfter('#translineitems tbody>tr:last');
		 $('.select-payee').select2();
          return false;
        });
    });
</script>
<?php


stop_blue_box();


require_once("footer.php");

}


function edittrans2() {
require_once("validate.php");
require("deps.php");
require("common.php");

#echo "<pre>";
#print_r($_REQUEST);
#die();

$transid = $_REQUEST['transid'];
$transdate = $_REQUEST['transdate'];
$transtime = $_REQUEST['transtime'];
$transnumber = $_REQUEST['transnumber'];
$transdesc = $_REQUEST['transdesc'];
$account = $_REQUEST['account'];
$payee = $_REQUEST['payee'];
$expense = $_REQUEST['expense'];
$income = $_REQUEST['income'];
$transdetdesc = $_REQUEST['transdetdesc'];
$pageNumber = $_REQUEST['pageNumber'];

$rs_insert_trans = "UPDATE glstrans SET transdate = '$transdate $transtime', transnumber = '$transnumber', transdesc = '$transdesc' WHERE transid = '$transid'";
@mysqli_query($rs_connect, $rs_insert_trans);

$cleardetail = "DELETE FROM glstransdet WHERE transid = '$transid'";
@mysqli_query($rs_connect, $cleardetail);

foreach($account as $key => $val) {

if($expense[$key] == "") {
$expense[$key] = 0;
}
if($income[$key] == "") {
$income[$key] = 0;
}

if (($expense[$key] != "") || ($income[$key] != "")) {
if (($expense[$key] > 0) || ($income[$key] > 0)) {
$rs_insert_transdet = "INSERT INTO glstransdet (transid,accountid,expense,income,transdetdesc,payee)
VALUES ('$transid','$account[$key]','$expense[$key]','$income[$key]','$transdetdesc[$key]','$payee[$key]')";
@mysqli_query($rs_connect, $rs_insert_transdet);
}
}

}

header("Location: strans.php?pageNumber=$pageNumber");

}



function transviewer() {
require_once("validate.php");
require("deps.php");
require("common.php");
#wip


if (array_key_exists('search',$_REQUEST)) {
$searchterm = $_REQUEST['search'];
if($searchterm != "0") {
$search = "AND transdesc LIKE '%$searchterm%'";
} else {
$search = "";
}
} else {
$search = "";
$searchterm = "";
}

#print_r($_REQUEST)."<br>";
#echo "$search - $searchterm<br>";

$results_per_page = 20;

$rs_find_transtotal = "SELECT transid FROM glstrans WHERE ledgerid = '$userledgerid' $search";
$rs_result_transtotal = mysqli_query($rs_connect,$rs_find_transtotal);
$totaltransactions = mysqli_num_rows($rs_result_transtotal);

$totalpages = ceil($totaltransactions / $results_per_page);

if (!array_key_exists('pageNumber',$_REQUEST)) {
$pageNumber = 1;
$offset = $totaltransactions - $results_per_page;
} else {
$pageNumber =  pv($_REQUEST['pageNumber']);
$offset = $totaltransactions - (($results_per_page * $pageNumber));
}

if($offset < 0) {
$offset = 0;
}


$offsetprior = $offset;

if($offsetprior < 1) {
$offsetprior = 0;
}

if($offsetprior > 1) {
$rs_find_prebal = "SELECT SUM(income) AS startibal, SUM(expense) AS startebal FROM 
(SELECT * FROM glstrans WHERE ledgerid = '$userledgerid' $search ORDER BY transdate ASC LIMIT 0, $offsetprior) t1
JOIN glstransdet t2 ON t2.transid = t1.transid";

#echo "$rs_find_prebal";

$rs_result_prebal = mysqli_query($rs_connect,$rs_find_prebal);
$rs_result_prebalq = mysqli_fetch_object($rs_result_prebal);
$startibal = "$rs_result_prebalq->startibal";
$startebal = "$rs_result_prebalq->startebal";

} else {
$startibal = 0;
$startebal = 0;
}


#echo "i $startibal e $startebal";

$startbal = $startibal - $startebal;

echo "<table class=\"standard lastalignright3\">";
echo "<tr><th style=\"width:125px\">".pcrtlang("Date")."</th><th style=\"width:100px\">".pcrtlang("Number")."</th><th>".pcrtlang("Description")."</th><th></th>";
echo "<th style=\"width:100px;text-align:right\">".pcrtlang("Expense")."</th><th style=\"width:100px;text-align:right\">".pcrtlang("Income")."</th>";
echo "<th style=\"width:100px;text-align:right\">".pcrtlang("Balance")."</th></tr>";

$rs_find_trans = "SELECT * FROM glstrans WHERE ledgerid = '$userledgerid' $search ORDER BY transdate ASC LIMIT $offset, $results_per_page";

echo "<tr><td style=\"background:#f1f1f1\"></td><td style=\"background:#f1f1f1\"></td><td style=\"background:#f1f1f1\" class=boldme>".pcrtlang("Previous Balance")."</td><td style=\"background:#f1f1f1\"></td><td style=\"background:#f1f1f1\"></td><td style=\"background:#f1f1f1\"></td><td style=\"background:#f1f1f1\">";

if($startbal < 0) {
echo "<span class=\"colormered boldme\">$money".mf(abs("$startbal"))."</span>";
} else {
echo "<span class=\"boldme\">$money".mf("$startbal")."</span>";
}

echo "</td></tr>";
$rs_result_trans = mysqli_query($rs_connect,$rs_find_trans);
while($rs_result_transq = mysqli_fetch_object($rs_result_trans)) {
$transid = "$rs_result_transq->transid";
$transnumber = "$rs_result_transq->transnumber";
$transdate2 = "$rs_result_transq->transdate";
$transdesc = "$rs_result_transq->transdesc";
$receiptid = "$rs_result_transq->receiptid";
$invoiceid = "$rs_result_transq->invoiceid";
$transdate = pcrtdate("$pcrt_shortdate", "$transdate2");
$baddebttransid = "$rs_result_transq->baddebttransid";


$rs_find_transdetsum = "SELECT SUM(income) AS income, SUM(expense) AS expense FROM glstransdet WHERE transid = '$transid'";
$rs_result_transdetsum = mysqli_query($rs_connect,$rs_find_transdetsum);
$rs_result_transdetsumq = mysqli_fetch_object($rs_result_transdetsum);
$sbalexpense = "$rs_result_transdetsumq->expense";
$sbalincome = "$rs_result_transdetsumq->income";
$startbal = ($startbal + ($sbalincome - $sbalexpense));

echo "<tr><td>$transdate</td>";

echo "<td>";
if(($receiptid == 0) && ($invoiceid == 0)) {
echo "$transnumber";
} elseif ($receiptid != 0) {
echo "<a href=\"../store/receipt.php?func=show_receipt&receipt=$receiptid\" target=\"_blank\" class=\"linkbuttongray linkbuttontiny radiusall\">";
echo "<i class=\"fa fa-cash-register colormegreen\"></i> $receiptid</a>";
if (!comparereceipttrans($receiptid, $transid)) {
echo " <i class=\"fa fa-warning colormered\"></i>";
}
} elseif ($invoiceid != 0) {
echo "<a href=\"../store/invoice.php?func=printinv&invoice_id=$invoiceid\" target=\"_blank\" class=\"linkbuttongray linkbuttontiny radiusall\">";
if(getinvoicestatus($invoiceid) != 2) {
echo "<i class=\"fa fa-file-invoice colormered\"></i> $invoiceid</a>";
} else {
echo "<i class=\"fa fa-file-invoice colormegreen\"></i> $invoiceid</a>";
}
if (!compareinvoicetrans($invoiceid, $transid)) {
echo " <i class=\"fa fa-warning colormered\"></i>";
}
}
echo "</td>";

echo "<td><a href=\"javascript:void(0);\" class=\"showtransdetdiv linkbuttongray linkbuttontiny radiusall\"><i class=\"fa fa-chevron-down\"></i></a> $transdesc";

echo "<div class=transdetdiv style=\"display:none\">";
echo "<table class=\"standard\" style=\"margin-top:10px;\">";
echo "<tr><th>".pcrtlang("account")."</th><th>".pcrtlang("description")."</th><th>".pcrtlang("payee")."</th><th style=\"text-align:right\">".pcrtlang("expense")."</th><th style=\"text-align:right\">".pcrtlang("income")."</th></tr>";
$rs_find_transdet = "SELECT * FROM glstransdet WHERE transid = '$transid'";
$rs_result_transdet = mysqli_query($rs_connect,$rs_find_transdet);
while($rs_result_transdetq = mysqli_fetch_object($rs_result_transdet)) {
$accountid = "$rs_result_transdetq->accountid";
$expense = "$rs_result_transdetq->expense";
$income = "$rs_result_transdetq->income";
$transdetdesc = "$rs_result_transdetq->transdetdesc";
$payee = "$rs_result_transdetq->payee";
if($payee != 0) {
$payeename = getpayeename("$payee");
} else {
$payeename = "";
}
echo "<tr><td>".getaccountname("$accountid")."</td><td>$transdetdesc</td><td>$payeename</td><td>";
if($expense != 0) {
echo "$money".mf("$expense");
}
echo "</td><td>";
if($income != 0) {
echo "$money".mf("$income");
}
echo "</td></tr>";
}
echo "</table>";
echo "</div>";

if($baddebttransid != 0) {
echo " <span class=colormered><i class=\"fa fa-skull-crossbones fa-lg\"></i> recorded as bad debt</span>";
}


echo "</td>";


echo "<td style=\"text-align:right;\">";
echo "<a href=\"javascript:void(0);\" class=\"showdelete linkbuttongray linkbuttontiny radiusleft\"><i class=\"fa fa-trash fa-lg\"></i></a><a href=\"strans.php?func=deletetrans&transid=$transid&pageNumber=$pageNumber\" class=\"linkbuttonred linkbuttontiny deletetranbutton\" style=\"display:none\"><i class=\"fa fa-check fa-lg\"></i> ".pcrtlang("Are you sure?")."</a>";

if ($invoiceid != 0) {
if($baddebttransid == 0) {
if(getinvoicestatus($invoiceid) != 2) {
echo "<a href=\"javascript:void(0);\" class=\"showbaddebt linkbuttongray linkbuttontiny\"><i class=\"fa fa-skull-crossbones fa-lg\"></i></a><a href=\"strans.php?func=baddebt&transid=$transid&pageNumber=$pageNumber\" class=\"linkbuttonred linkbuttontiny baddebtbutton\" style=\"display:none\"><i class=\"fa fa-check fa-lg\"></i> ".pcrtlang("Record as Bad Debt?")."</a>";
}
}
}

echo "<a href=\"strans.php?func=edittrans&transid=$transid&pageNumber=$pageNumber\" class=\"linkbuttongray linkbuttontiny radiusright\"><i class=\"fa fa-edit fa-lg\"></i></a></td>";

$rs_find_transdet = "SELECT SUM(income) AS income, SUM(expense) AS expense FROM glstransdet WHERE transid = '$transid'";
$rs_result_transdet = mysqli_query($rs_connect,$rs_find_transdet);
$rs_result_transdetq = mysqli_fetch_object($rs_result_transdet);
$income = "$rs_result_transdetq->income";
$expense = "$rs_result_transdetq->expense";
if($expense != 0) {
echo "<td><span class=colormered>$money".mf("$expense")."</span></td>";
} else {
echo "<td></td>";
}
if($income != 0) {
echo "<td><span class=colormegreen>$money".mf("$income")."</span></td>";
} else {
echo "<td></td>";
}

echo "<td>";
if($startbal < 0) {
echo "<span class=colormered>$money".mf(abs("$startbal"))."</span>";
} else {
echo "$money".mf("$startbal");
}
echo "</td>";


echo "</tr>";
}

echo "</table>";

$pageNumberup = $pageNumber + 1;
$pageNumberdown = $pageNumber - 1;

echo "<center>";

$actpage = ($totalpages - $pageNumber) + 1;

echo "<div class=radiustop style=\"position:fixed;z-index:80;top:150px;right:0%;padding:3px;background:#777777; border-top-left-radius: 40px 60px; border-bottom-left-radius: 40px 60px;\">";

echo "<br><br>";
if($totaltransactions > (($pageNumberup * $results_per_page) - $results_per_page)) {
echo "<a href=\"javascript:void(0);\" id=scrolltop class=\"linkbuttonmedium linkbuttongray radiustop\"><i class=\"fa fa-step-forward fa-rotate-270 fa-lg fa-fw\"></i></a><br>";
echo "<a href=\"javascript:void(0);\" id=scrollup class=\"linkbuttonmedium linkbuttongray radiusbottom\"><br><i class=\"fa fa-chevron-up fa-lg fa-fw\"></i><br><br></a><br>";
} else {
echo "<span class=\"linkbuttonmedium linkbuttongraydisabled radiustop\"><i class=\"fa fa-step-forward fa-rotate-270 fa-lg fa-fw\"></i></span><br>";
echo "<span class=\"linkbuttonmedium linkbuttongraydisabled radiusbottom\"><br><i class=\"fa fa-chevron-up fa-lg fa-fw\"></i><br><br></span><br>";
}

echo "<span class=\"linkbuttongraylabel radiusleft linkbuttonmedium\">$actpage ".pcrtlang("of")." $totalpages</span><br>";

if($pageNumber != 1) {
echo "<a href=\"javascript:void(0);\" id=scrolldown class=\"linkbuttonmedium linkbuttongray radiustop\"><br><i class=\"fa fa-chevron-down fa-lg fa-fw\"></i><br><br></a><br>";
echo "<a href=\"javascript:void(0);\" id=scrollbottom class=\"linkbuttonmedium linkbuttongray radiusbottom\"><i class=\"fa fa-step-forward fa-rotate-90 fa-lg fa-fw\"></i></a><br>";
} else {
echo "<span class=\"linkbuttonmedium linkbuttongraydisabled radiustop\"><br><i class=\"fa fa-chevron-down fa-lg fa-fw\"></i><br><br></span><br>";
echo "<span class=\"linkbuttonmedium linkbuttongraydisabled radiusbottom\"><i class=\"fa fa-step-forward fa-rotate-90 fa-lg fa-fw\"></i></span><br>";
}
echo "<br><br><br>";
echo "</div>";

if($searchterm != "") {
$searchurl = "&search=$searchterm";
} else {
$searchurl = "";
}

?>

<script type="text/javascript">
$(document).ready(function(){
$('#scrollup').click(function(){
                $.get('strans.php?func=transviewer&pageNumber=<?php echo "$pageNumberup"."$searchurl"; ?>', function(data) {
                $('#transmaster').html(data);
                });
        });
});
</script>

<script type="text/javascript">
$(document).ready(function(){
$('#scrolldown').click(function(){
                $.get('strans.php?func=transviewer&pageNumber=<?php echo "$pageNumberdown"."$searchurl"; ?>', function(data) {
                $('#transmaster').html(data);
                });
        });
});
</script>

<script type="text/javascript">
$(document).ready(function(){
$('#scrolltop').click(function(){
                $.get('strans.php?func=transviewer&pageNumber=<?php echo "$totalpages"."$searchurl"; ?>', function(data) {
                $('#transmaster').html(data);
                });
        });
});
</script>

<script type="text/javascript">
$(document).ready(function(){
$('#scrollbottom').click(function(){
                $.get('strans.php?func=transviewer&pageNumber=1<?php echo "$searchurl"; ?>', function(data) {
                $('#transmaster').html(data);
                });
        });
});
</script>


<script type="text/javascript">

$(".showtransdetdiv").click(function(){
$(this).next().toggle();
$("i",this).toggleClass("fa-chevron-up fa-chevron-down");
});

</script>

<script type="text/javascript">

$(".showdelete").click(function(){
$(this).next().toggle();
});


$(".showbaddebt").click(function(){
$(this).next().toggle();
});

</script>

<script>
$(document).ready(function(){
$('.deletetranbutton').on('click', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                $.get(url, function () {
                $.get('strans.php?func=transviewer&pageNumber=<?php echo "$pageNumber"; ?>', function(data) {
                $('#transmaster').html(data);
                });
                });
                });
});

$(document).ready(function(){
$('.baddebtbutton').on('click', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                $.get(url, function () {
                $.get('strans.php?func=transviewer&pageNumber=<?php echo "$pageNumber"; ?>', function(data) {
                $('#transmaster').html(data);
                });
                });
                });
});

</script>




<?php


}



function import() {
require_once("validate.php");
require("deps.php");
require("common.php");

$importfrom = pv($_REQUEST['importfrom']);
$incomeaccount = pv($_REQUEST['account']);


$linkedstorearray = explode_list($userlinkedstore);


foreach($linkedstorearray as $storekey => $storeval) {

if($userledgermethod == 1) {

$rs_find_receipts = "SELECT * FROM receipts WHERE date_sold > '$importfrom 00:00:00' AND storeid = '$storeval'";
$rs_result = mysqli_query($rs_connect, $rs_find_receipts);
while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_receipt_id = "$rs_result_q->receipt_id";
$rs_name = pv("$rs_result_q->person_name");
$rs_storeid = "$rs_result_q->storeid";
$rs_date_sold = "$rs_result_q->date_sold";

$rs_find_checkexist = "SELECT * FROM glstrans WHERE receiptid = '$rs_receipt_id' AND ledgerid = '$userledgerid'";
$rs_resultchecksexist = mysqli_query($rs_connect, $rs_find_checkexist);

$checkexist = mysqli_num_rows($rs_resultchecksexist);

if($checkexist == 0) {

if(isset($taxtotals)) {
unset($taxtotals);
}
$receipttotal = 0;
$taxtotals = array();

$rs_find_sold_items = "SELECT sold_price,itemtax,taxex FROM sold_items WHERE receipt = '$rs_receipt_id' AND (sold_type = 'purchase' OR sold_type = 'labor')";
$rs_result_sold_items = mysqli_query($rs_connect, $rs_find_sold_items);
while($rs_result_siq = mysqli_fetch_object($rs_result_sold_items)) {
$sold_price = "$rs_result_siq->sold_price";
$itemtax = "$rs_result_siq->itemtax";
$taxex = "$rs_result_siq->taxex";
$receipttotal = $receipttotal + $sold_price;
if(array_key_exists("$taxex", $taxtotals)) {
$taxtotals[$taxex] = $taxtotals[$taxex] + $itemtax;
} else {
$taxtotals[$taxex] = 0 + $itemtax;
}
}

$rs_find_sold_items = "SELECT sold_price,itemtax,taxex FROM sold_items WHERE receipt = '$rs_receipt_id' AND (sold_type = 'refund' OR sold_type = 'refundlabor')";
$rs_result_sold_items = mysqli_query($rs_connect, $rs_find_sold_items);
while($rs_result_siq = mysqli_fetch_object($rs_result_sold_items)) {
$sold_price = "$rs_result_siq->sold_price";
$itemtax = "$rs_result_siq->itemtax";
$taxex = "$rs_result_siq->taxex";
$receipttotal = $receipttotal - $sold_price;
if(array_key_exists("$taxex", $taxtotals)) {
$taxtotals[$taxex] = $taxtotals[$taxex] - $itemtax;
} else {
$taxtotals[$taxex] = 0 - $itemtax;
}
}

#insert here

$rs_insert_trans = "INSERT INTO glstrans (transdate,transnumber,transdesc,ledgerid,receiptid) VALUES ('$rs_date_sold','$rs_receipt_id','$rs_name','$userledgerid','$rs_receipt_id')";
@mysqli_query($rs_connect, $rs_insert_trans);
$transid = mysqli_insert_id($rs_connect);
if($receipttotal < 0) {
$rs_insert_transdet = "INSERT INTO glstransdet (transid,accountid,expense) VALUES ('$transid','$incomeaccount','".abs("$receipttotal")."')";
} else {
$rs_insert_transdet = "INSERT INTO glstransdet (transid,accountid,income) VALUES ('$transid','$incomeaccount','$receipttotal')";
}
@mysqli_query($rs_connect, $rs_insert_transdet);

foreach($taxtotals as $key => $val) {
$taxname = pv(gettaxname($key));
$account = getlinkedtaxaccountid($key);
if($val < 0) {
$rs_insert_transdettax = "INSERT INTO glstransdet (transid,accountid,expense,transdetdesc) VALUES ('$transid','$account','".abs("$val")."','$taxname')";
@mysqli_query($rs_connect, $rs_insert_transdettax);
} else {
if($val > 0) {
$rs_insert_transdettax = "INSERT INTO glstransdet (transid,accountid,income,transdetdesc) VALUES ('$transid','$account','$val','$taxname')";
@mysqli_query($rs_connect, $rs_insert_transdettax);
}
}
}

#end exist check
}

}
#end ledger method 1 cash
} elseif($userledgermethod == 2) {

#####
#start accrural

$rs_find_receipts = "SELECT * FROM receipts WHERE date_sold > '$importfrom 00:00:00' AND storeid = '$storeval' AND (invoice_id = '' or invoice_id = '0')";
$rs_result = mysqli_query($rs_connect, $rs_find_receipts);
while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_receipt_id = "$rs_result_q->receipt_id";
$rs_name = pv("$rs_result_q->person_name");
$rs_storeid = "$rs_result_q->storeid";
$rs_date_sold = "$rs_result_q->date_sold";

$rs_find_checkexist = "SELECT * FROM glstrans WHERE receiptid = '$rs_receipt_id' AND ledgerid = '$userledgerid'";
$rs_resultchecksexist = mysqli_query($rs_connect, $rs_find_checkexist);

$checkexist = mysqli_num_rows($rs_resultchecksexist);

if($checkexist == 0) {

if(isset($taxtotals)) {
unset($taxtotals);
}
$receipttotal = 0;
$taxtotals = array();

$rs_find_sold_items = "SELECT sold_price,itemtax,taxex FROM sold_items WHERE receipt = '$rs_receipt_id' AND (sold_type = 'purchase' OR sold_type = 'labor')";
$rs_result_sold_items = mysqli_query($rs_connect, $rs_find_sold_items);
while($rs_result_siq = mysqli_fetch_object($rs_result_sold_items)) {
$sold_price = "$rs_result_siq->sold_price";
$itemtax = "$rs_result_siq->itemtax";
$taxex = "$rs_result_siq->taxex";
$receipttotal = $receipttotal + $sold_price;
if(array_key_exists("$taxex", $taxtotals)) {
$taxtotals[$taxex] = $taxtotals[$taxex] + $itemtax;
} else {
$taxtotals[$taxex] = 0 + $itemtax;
}
}

$rs_find_sold_items = "SELECT sold_price,itemtax,taxex FROM sold_items WHERE receipt = '$rs_receipt_id' AND (sold_type = 'refund' OR sold_type = 'refundlabor')";
$rs_result_sold_items = mysqli_query($rs_connect, $rs_find_sold_items);
while($rs_result_siq = mysqli_fetch_object($rs_result_sold_items)) {
$sold_price = "$rs_result_siq->sold_price";
$itemtax = "$rs_result_siq->itemtax";
$taxex = "$rs_result_siq->taxex";
$receipttotal = $receipttotal - $sold_price;
if(array_key_exists("$taxex", $taxtotals)) {
$taxtotals[$taxex] = $taxtotals[$taxex] - $itemtax;
} else {
$taxtotals[$taxex] = 0 - $itemtax;
}
}

#insert here

$rs_insert_trans = "INSERT INTO glstrans (transdate,transnumber,transdesc,ledgerid,receiptid) VALUES ('$rs_date_sold','$rs_receipt_id','$rs_name','$userledgerid','$rs_receipt_id')";
@mysqli_query($rs_connect, $rs_insert_trans);
$transid = mysqli_insert_id($rs_connect);
if($receipttotal < 0) {
$rs_insert_transdet = "INSERT INTO glstransdet (transid,accountid,expense) VALUES ('$transid','$incomeaccount','".abs("$receipttotal")."')";
} else {
$rs_insert_transdet = "INSERT INTO glstransdet (transid,accountid,income) VALUES ('$transid','$incomeaccount','$receipttotal')";
}
@mysqli_query($rs_connect, $rs_insert_transdet);
foreach($taxtotals as $key => $val) {
$taxname = pv(gettaxname($key));
$account = getlinkedtaxaccountid($key);
if($val < 0) {
$rs_insert_transdettax = "INSERT INTO glstransdet (transid,accountid,expense,transdetdesc) VALUES ('$transid','$account','".abs("$val")."','$taxname')";
@mysqli_query($rs_connect, $rs_insert_transdettax);
} else {
if($val > 0) {
$rs_insert_transdettax = "INSERT INTO glstransdet (transid,accountid,income,transdetdesc) VALUES ('$transid','$account','$val','$taxname')";
@mysqli_query($rs_connect, $rs_insert_transdettax);
}
}
}

}
#end receipt exist check
}

##### Start Invoice Input

$rs_find_invoices = "SELECT * FROM invoices WHERE invdate > '$importfrom 00:00:00' AND storeid = '$storeval' AND iorq = 'invoice' AND invstatus < '3'";
$rs_result = mysqli_query($rs_connect, $rs_find_invoices);
while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_invoice_id = "$rs_result_q->invoice_id";
$rs_name = pv("$rs_result_q->invname");
$rs_storeid = "$rs_result_q->storeid";
$rs_invdate = "$rs_result_q->invdate";

$rs_find_checkexist = "SELECT * FROM glstrans WHERE invoiceid = '$rs_invoice_id' AND ledgerid = '$userledgerid'";
$rs_resultchecksexist = mysqli_query($rs_connect, $rs_find_checkexist);

$checkexist = mysqli_num_rows($rs_resultchecksexist);

if($checkexist == 0) {

if(isset($taxtotals)) {
unset($taxtotals);
}
$invoicetotal = 0;
$taxtotals = array();

$rs_find_invitems = "SELECT cart_price,itemtax,taxex FROM invoice_items WHERE invoice_id = '$rs_invoice_id' AND (cart_type = 'purchase' OR cart_type = 'labor')";
$rs_result_inv_items = mysqli_query($rs_connect, $rs_find_invitems);
while($rs_result_siq = mysqli_fetch_object($rs_result_inv_items)) {
$cart_price = "$rs_result_siq->cart_price";
$itemtax = "$rs_result_siq->itemtax";
$taxex = "$rs_result_siq->taxex";
$invoicetotal = $invoicetotal + $cart_price;
if(array_key_exists("$taxex", $taxtotals)) {
$taxtotals[$taxex] = $taxtotals[$taxex] + $itemtax;
} else {
$taxtotals[$taxex] = 0 + $itemtax;
}
}

#insert here

$rs_insert_trans = "INSERT INTO glstrans (transdate,transnumber,transdesc,ledgerid,invoiceid) VALUES ('$rs_invdate','$rs_invoice_id','$rs_name','$userledgerid','$rs_invoice_id')";
@mysqli_query($rs_connect, $rs_insert_trans);
$transid = mysqli_insert_id($rs_connect);
$rs_insert_transdet = "INSERT INTO glstransdet (transid,accountid,income) VALUES ('$transid','$incomeaccount','$invoicetotal')";
@mysqli_query($rs_connect, $rs_insert_transdet);
foreach($taxtotals as $key => $val) {
$taxname = pv(gettaxname($key));
$account = getlinkedtaxaccountid($key);
if($val > 0) {
$rs_insert_transdetinvtax = "INSERT INTO glstransdet (transid,accountid,income,transdetdesc) VALUES ('$transid','$account','$val','$taxname')";
@mysqli_query($rs_connect, $rs_insert_transdetinvtax);
}
}

}
#end exist check

}

#####
# end method type accrural
}

#End While Linked Store
}

header("Location: strans.php");
}


function baddebt() {
require_once("validate.php");
require("deps.php");
require("common.php");


$transid = pv($_REQUEST['transid']);
$pageNumber = pv($_REQUEST['pageNumber']);

$rs_find_trans = "SELECT * FROM glstrans WHERE transid = '$transid'";
$rs_result_trans = mysqli_query($rs_connect,$rs_find_trans);
$rs_result_transq = mysqli_fetch_object($rs_result_trans);
$transnumber = "$rs_result_transq->transnumber";
$transdesc = "$rs_result_transq->transdesc";
$ledgerid = "$rs_result_transq->ledgerid";

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

$rs_insert_trans = "INSERT INTO glstrans (transdate,transnumber,transdesc,ledgerid) VALUES ('$currentdatetime','$transnumber','$transdesc','$ledgerid')";
@mysqli_query($rs_connect, $rs_insert_trans);

$transidbd = mysqli_insert_id($rs_connect);

$rs_find_transdet = "SELECT * FROM glstransdet WHERE transid = '$transid'";
$rs_result_transdet = mysqli_query($rs_connect,$rs_find_transdet);
while($rs_result_transdetq = mysqli_fetch_object($rs_result_transdet)) {
$accountid = "$rs_result_transdetq->accountid";
$expense = "$rs_result_transdetq->expense";
$income = "$rs_result_transdetq->income";
$transdetdesc = "$rs_result_transdetq->transdetdesc";
$payee = "$rs_result_transdetq->payee";

$rs_insert_transdet = "INSERT INTO glstransdet (transid,accountid,expense,income,transdetdesc,payee)
VALUES ('$transidbd','$accountid','$income','$expense','$transdetdesc','$payee')";
@mysqli_query($rs_connect, $rs_insert_transdet);
}

$setbaddebt = "UPDATE glstrans SET baddebttransid = '$transidbd' WHERE transid = '$transid'";
@mysqli_query($rs_connect, $setbaddebt);

#header("Location: strans.php?pageNumber=$pageNumber");

}


function importsales() {
require_once("header.php");
require("deps.php");

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}

$thedate = date("Y-m-d");

if($userledgermethod == 1) {
$ledgermethod = "(".pcrtlang("Cash Accounting").")";
} else {
$ledgermethod = "(".pcrtlang("Accrual Accounting").")";
}

if($userlinkedstore == 0) {
$linkedstore = pcrtlang("All Stores");
} else {
$rs_find_stores = "SELECT storename FROM stores WHERE storeid = '$userlinkedstore'";
$rs_result_stores = mysqli_query($rs_connect,$rs_find_stores);
$rs_result_storeq = mysqli_fetch_object($rs_result_stores);
$linkedstore = "$rs_result_storeq->storename";
}


#wip

start_blue_box(pcrtlang("Import Sales Transactions")." $ledgermethod");

echo "<form action=strans.php?func=import method=post>";
echo "<table class=standard>";

echo "<tr><td>".pcrtlang("Import From Store").":</td><td>";

$linkedstorearray = explode_list($userlinkedstore);

if(!empty($linkedstorearray)) {

foreach($linkedstorearray as $key => $val) {
$rs_find_stores = "SELECT * FROM stores WHERE storeid = '$val'";
$rs_result_stores = mysqli_query($rs_connect,$rs_find_stores);
$rs_result_storeq = mysqli_fetch_object($rs_result_stores);
$linkedstoresname = "$rs_result_storeq->storesname";
echo "<i class=\"fa fa-store\"></i> $linkedstoresname<br>";
}

}



echo "</td></tr>";

echo "<tr><td>".pcrtlang("From Date").":</td><td><input type=date class=textbox name=importfrom value=\"$thedate\"></td></tr>";

echo "<tr><td>".pcrtlang("Income Account")."</td><td><select name=account>";
$rs_find_income = "SELECT * FROM glsaccounts WHERE accounttype = 'income' AND ledgerid = '$userledgerid'";
$rs_result_income = mysqli_query($rs_connect,$rs_find_income);
while($rs_result_incomeq = mysqli_fetch_object($rs_result_income)) {
$accountid = "$rs_result_incomeq->accountid";
$accountname = "$rs_result_incomeq->accountname";
echo "<option value=$accountid>$accountname</option>";
}
echo "</select></td></tr>";


echo "<tr><td colspan=2><button type=submit class=button><i class=\"fa fa-file-import fa-lg\"></i> ".pcrtlang("Import")."</button></td></tr>";

echo "</table></form>";


stop_blue_box();

require_once("footer.php");

}




switch($func) {
                                                                                                    
    default:
    transactions();
    break;
                                
    case "newtransaction":
    newtransaction();
    break;

    case "deletetrans":
    deletetrans();
    break;

  case "edittrans":
    edittrans();
    break;

  case "edittrans2":
    edittrans2();
    break;

 case "transviewer":
    transviewer();
    break;

 case "import":
    import();
    break;

 case "importsales":
    importsales();
    break;


 case "baddebt":
    baddebt();
    break;


}

?>

