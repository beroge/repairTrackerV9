<?php
                                                                                                    
/***************************************************************************
 *   copyright            : (C) 2014 PCRepairTracker.com
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


function newcontract() {

$pcgroupid = $_REQUEST['pcgroupid'];

require("deps.php");

require_once("common.php");

if($gomodal != "1") {
require("header.php");
} else {
require_once("validate.php");
}


if($gomodal != "1") {
start_blue_box(pcrtlang("New Block of Hours Contract"));
} else {
echo "<h4>".pcrtlang("New Block of Hours Contract")."</h4>";
}

?>
<script type='text/javascript' src='jq/jquery.autogrow-textarea.js'></script>
<?php


echo "<form action=blockcontract.php?func=newcontract2 method=post>";
echo "<table width=100%>";

echo "<tr><td>".pcrtlang("Title").":</td><td><input type=text class=textbox name=blocktitle size=35></td></tr>";

$thedate = date("Y-m-d");
echo "<tr><td><span class=\"boldme\">".pcrtlang("Start Date").":</span></td><td>";
echo "<input id=\"blockstart\" type=text class=textbox name=blockstart value=\"$thedate\" style=\"width:120px;\">";


?>

<script type="text/javascript" src="../repair/jq/datepickr.js"></script>
<script type="text/javascript">
new datepickr('blockstart', { dateFormat: 'Y-m-d', theCurrentDate: document.getElementById("blockstart").value });
</script>

<?php

echo "</td></tr>\n";

echo "<tr><td>".pcrtlang("Notes").":</td><td><textarea name=blocknote rows=1 class=textboxw style=\"width:98%\"></textarea><input type=hidden name=pcgroupid value=$pcgroupid></td></tr>";

echo "<tr><td>&nbsp;</td><td><input type=submit class=button value=\"".pcrtlang("Save")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Saving")."...'; this.form.submit();\"></form></td></tr>";
echo "</table>";

?>

<script type='text/javascript'>
  $(function() {
    $('textarea').autogrow();
  });
</script>

<?php

if($gomodal != 1) {
stop_blue_box();
}

if($gomodal != 1) {
require_once("footer.php");
}

}






function newcontract2() {

require("deps.php");
require_once("validate.php");
require("common.php");

$blocktitle = pv($_REQUEST['blocktitle']);
$blocknote = pv($_REQUEST['blocknote']);
$blockstart = $_REQUEST['blockstart'];
$pcgroupid = $_REQUEST['pcgroupid'];





$rs_insert_bc = "INSERT INTO blockcontract (blocktitle,blocknote,blockstart,pcgroupid) VALUES ('$blocktitle','$blocknote','$blockstart','$pcgroupid')";
@mysqli_query($rs_connect, $rs_insert_bc);

header("Location: group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=blockcontract");

}



function starttimerbc() {

$pcgroupid = $_REQUEST['pcgroupid'];
$blockcontractid = $_REQUEST['blockcontractid'];

require("deps.php");

require_once("common.php");

if($gomodal != "1") {
require("header.php");
} else {
require_once("validate.php");
}

if($gomodal != "1") {
start_blue_box(pcrtlang("Start Timer"));
} else {
echo "<h4>".pcrtlang("Start Timer")."</h4>";
}

echo "<form action=pc.php?func=timerstart&pcgroupid=$pcgroupid&blockcontractid=$blockcontractid method=post><span class=\"boldme\">".pcrtlang("Task Description").":</span> ";
echo "<input name=timername size=20 class=textbox>";

echo "<br><br><select name=savedround><option selected value=0>".pcrtlang("Bill Actual Time")."</option><option value=15>".pcrtlang("Round up to nearest quarter hour")."</option>";
echo "<option value=30>".pcrtlang("Round up to nearest half hour")."</option><option value=60>".pcrtlang("Round up to nearest hour")."</option></select><br>";
echo "<br><input type=submit class=button value=\"".pcrtlang("Start New Timer")."\"></form>";

if($gomodal != 1) {
stop_blue_box();
}

if($gomodal != 1) {
require_once("footer.php");
}

}






function addhourssingle() {

$pcgroupid = $_REQUEST['pcgroupid'];
$blocktitle = $_REQUEST['blocktitle'];
$blockcontractid = $_REQUEST['blockcontractid'];

require("deps.php");

require_once("common.php");

if($gomodal != "1") {
require("header.php");
} else {
require_once("validate.php");
}

if($gomodal != "1") {
start_blue_box(pcrtlang("Add Hours/Invoice"));
} else {
echo "<h4>".pcrtlang("Add Hours/Invoice")."</h4>";
}

echo "<form action=blockcontract.php?func=addhourssingle2&pcgroupid=$pcgroupid&blockcontractid=$blockcontractid method=post><table><tr><td>";
echo pcrtlang("Hours to Add").":</td><td>";
echo "<input name=hourstoadd size=20 class=textbox></td></tr>";

echo "<tr><td>".pcrtlang("Invoice Line Item Title").":</td><td>";
echo "<input name=blocktitle size=40 class=textbox value=\"$blocktitle\"></td></tr>";

echo "<tr><td>".pcrtlang("Choose Option").":<br><span class=\"sizemesmaller italme\">(".pcrtlang("or manually enter hourly rate").")</span></td><td>";

$rs_quicklabor2 = "SELECT * FROM quicklabor ORDER BY theorder DESC";
$rs_result_ql2  = mysqli_query($rs_connect, $rs_quicklabor2);

echo "<select name=pricepick id=stringall onchange='document.getElementById(\"billrate\").value=this.options[this.selectedIndex].value'>";
echo "<option value=\"0\">".pcrtlang("Choose").":</option>";
while($rs_result_qld2 = mysqli_fetch_object($rs_result_ql2)) {
$labordesc = "$rs_result_qld2->labordesc";
$laborprice = mf("$rs_result_qld2->laborprice");
$primero = substr("$labordesc", 0, 1);
if("$primero" != "-") {
echo "<option value=\"$laborprice\">$money$laborprice - $labordesc</option>";
} else {
$labordesc3 = substr("$labordesc", 1);
echo "<option value=\"0\" style=\"background:#000000;color:#ffffff;padding:1px;\">$labordesc3</option>";
}
}

echo "</td></tr>";

echo "<tr><td>".pcrtlang("Hourly Rate").": </td>";
echo "<td>$money<input type=text id=billrate name=billrate class=textbox size=6></td></tr>";


echo "<tr><td>".pcrtlang("Invoice Terms?").":</td><td><select name=invoicetermsid>";

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

echo "</select></td></tr>";


echo "<tr><td colspan=2><input type=submit class=button value=\"".pcrtlang("Add Hours and Invoice")."\"></form></td></tr></table></form>";

if($gomodal != 1) {
stop_blue_box();
}

if($gomodal != 1) {
require_once("footer.php");
}

}



function addhourssingle2() {
require_once("validate.php");
require("deps.php");
require("common.php");

$pcgroupid = $_REQUEST['pcgroupid'];
$blockcontractid = $_REQUEST['blockcontractid'];

$hourstoadd = $_REQUEST['hourstoadd'];
$billrate = $_REQUEST['billrate'];

$blocktitle = $_REQUEST['blocktitle'];
$invoicetermsid = $_REQUEST['invoicetermsid'];


$invservice = $hourstoadd * $billrate;

$usertaxid = getusertaxid();
$taxrate = getservicetaxrate($usertaxid);
$itemtax = $taxrate * $invservice;


$rs_findpc = "SELECT * FROM pc_group WHERE pcgroupid = '$pcgroupid'";
$rs_result = mysqli_query($rs_connect, $rs_findpc);
$rs_result_q = mysqli_fetch_object($rs_result);
$invname = pv("$rs_result_q->pcgroupname");
$invcompany = pv("$rs_result_q->grpcompany");
$invphone = pv("$rs_result_q->grpphone");
$invaddy1 = pv("$rs_result_q->grpaddress1");
$invaddy2 = pv("$rs_result_q->grpaddress2");
$invcity = pv("$rs_result_q->grpcity");
$invstate = pv("$rs_result_q->grpstate");
$invzip = pv("$rs_result_q->grpzip");
$invemail = pv("$rs_result_q->grpemail");


if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');
$timestamp = time();


#wip

$rs_sl = "SELECT * FROM invoiceterms WHERE invoicetermsid = '$invoicetermsid'";
$rs_result1 = mysqli_query($rs_connect, $rs_sl);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$invoicetermsdays = "$rs_result_q1->invoicetermsdays";

$duedate = date('Y-m-d H:i:s', (time() + ($invoicetermsdays * 86400)));


$rs_insert_cart = "INSERT INTO invoices (invname,invcompany,invaddy1,invaddy2,invphone,invemail,invdate,invcity,invstate,invzip,byuser,storeid,iorq,invoicetermsid,duedate) 
VALUES ('$invname','$invcompany','$invaddy1','$invaddy2','$invphone','$invemail','$currentdatetime',
'$invcity','$invstate','$invzip','$ipofpc','$defaultuserstore','invoice','$invoicetermsid','$duedate')";
@mysqli_query($rs_connect, $rs_insert_cart);

$invoiceid = mysqli_insert_id($rs_connect);


$rs_insert_invitems = "INSERT INTO invoice_items (cart_price,cart_type,cart_stock_id,labor_desc,return_sold_id,restocking_fee,price_alt,invoice_id,taxex,itemtax,
origprice,discounttype,ourprice,itemserial,addtime,unit_price,quantity) VALUES ('$invservice','labor','0','$blocktitle','0','','0','$invoiceid','$usertaxid','$itemtax',
'0','','0','','$timestamp','$billrate','$hourstoadd')";
@mysqli_query($rs_connect, $rs_insert_invitems);

$blockdate = date('Y-m-d');

$rs_insert_bch = "INSERT INTO blockcontracthours (blockhours,blockhoursdate,blockcontractid,invoiceid) VALUES 
('$hourstoadd','$blockdate','$blockcontractid','$invoiceid')";
@mysqli_query($rs_connect, $rs_insert_bch);



header("Location: group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=blockcontract");

}


function contractclosed() {

require("deps.php");
require_once("validate.php");
require("common.php");

$contractclosed = $_REQUEST['contractclosed'];
$blockcontractid = $_REQUEST['blockcontractid'];
$pcgroupid = $_REQUEST['pcgroupid'];





$rs_switch_bc = "UPDATE blockcontract SET contractclosed = '$contractclosed' WHERE blockid = '$blockcontractid'";
@mysqli_query($rs_connect, $rs_switch_bc);

if($contractclosed == 1) {
$rs_switch_ri = "UPDATE rinvoices SET invactive = '0' WHERE blockcontractid = '$blockcontractid'";
@mysqli_query($rs_connect, $rs_switch_ri);
}

header("Location: group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=blockcontract");

}

function deletehoursinvoice() {

require("deps.php");
require_once("validate.php");
require("common.php");

$blockcontracthoursid = $_REQUEST['blockcontracthoursid'];
$pcgroupid = $_REQUEST['pcgroupid'];





$rs_del_bch = "DELETE FROM blockcontracthours WHERE blockcontracthoursid = '$blockcontracthoursid'";
@mysqli_query($rs_connect, $rs_del_bch);

header("Location: group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=blockcontract");

}


function editcontract() {

$pcgroupid = $_REQUEST['pcgroupid'];
$blockcontractid = $_REQUEST['blockcontractid'];

require("deps.php");

require_once("common.php");

if($gomodal != "1") {
require("header.php");
} else {
require_once("validate.php");
}


if($gomodal != "1") {
start_blue_box(pcrtlang("Edit Block of Hours Contract"));
} else {
echo "<h4>".pcrtlang("Edit Block of Hours Contract")."</h4>";
}





$rs_findbc = "SELECT * FROM blockcontract WHERE blockid = '$blockcontractid'";
$rs_result = mysqli_query($rs_connect, $rs_findbc);
$rs_result_qbc = mysqli_fetch_object($rs_result);
$blocktitle = "$rs_result_qbc->blocktitle";
$blocknote = "$rs_result_qbc->blocknote";
$blockstart = "$rs_result_qbc->blockstart";

echo "<form action=blockcontract.php?func=editcontract2 method=post>";
echo "<table width=100%>";

echo "<tr><td>".pcrtlang("Title").":</td><td><input type=text class=textbox name=blocktitle size=35 value=\"$blocktitle\"></td></tr>";

echo "<tr><td><span class=\"boldme\">".pcrtlang("Start Date").":</span></td><td>";
echo "<input id=\"blockstart\" type=text class=textbox name=blockstart value=\"$blockstart\" style=\"width:120px;\">";
?>

<script type="text/javascript" src="../repair/jq/datepickr.js"></script>
<script type="text/javascript">
new datepickr('blockstart', { dateFormat: 'Y-m-d', theCurrentDate: document.getElementById("blockstart").value });
</script>

<?php

echo "</td></tr>\n";

echo "<tr><td>".pcrtlang("Notes").":</td><td><textarea name=blocknote rows=1 class=textboxw style=\"width:98%\">$blocknote</textarea>
<input type=hidden name=pcgroupid value=$pcgroupid><input type=hidden name=blockcontractid value=$blockcontractid></td></tr>";

echo "<tr><td>&nbsp;</td><td><input type=submit class=button value=\"".pcrtlang("Save")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Saving")."...'; this.form.submit();\"></form></td></tr>";
echo "</table>";

?>
<script type='text/javascript' src='jq/jquery.autogrow-textarea.js'></script>

<script type='text/javascript'>
  $(function() {
    $('textarea').autogrow();
  });
</script>

<?php



if($gomodal != 1) {
stop_blue_box();
}

if($gomodal != 1) {
require_once("footer.php");
}

}


function editcontract2() {

require("deps.php");
require_once("validate.php");
require("common.php");

$blocktitle = pv($_REQUEST['blocktitle']);
$blocknote = pv($_REQUEST['blocknote']);
$blockstart = $_REQUEST['blockstart'];
$pcgroupid = $_REQUEST['pcgroupid'];
$blockcontractid = $_REQUEST['blockcontractid'];






$rs_insert_bc = "UPDATE blockcontract SET blocktitle = '$blocktitle', blocknote = '$blocknote', blockstart = '$blockstart' WHERE blockid = '$blockcontractid'";
@mysqli_query($rs_connect, $rs_insert_bc);

header("Location: group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=blockcontract");

}


function billtocontract() {

require("deps.php");
require_once("validate.php");
require("common.php");

$blockcontractid = pv($_REQUEST['blockcontractid']);
$woid = pv($_REQUEST['woid']);
$pcgroupid = $_REQUEST['pcgroupid'];
$timerid = $_REQUEST['timerid'];





$rs_insert_bc = "UPDATE timers SET pcgroupid = '$pcgroupid', blockcontractid = '$blockcontractid', billedout = '1' WHERE timerid = '$timerid'";
@mysqli_query($rs_connect, $rs_insert_bc);

header("Location: group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=blockcontract");

}

function removefromcontract() {

require("deps.php");
require_once("validate.php");
require("common.php");

$pcgroupid = $_REQUEST['pcgroupid'];
$timerid = $_REQUEST['timer'];





$rs_insert_bc = "UPDATE timers SET pcgroupid = '0', blockcontractid = '0' WHERE timerid = '$timerid'";
@mysqli_query($rs_connect, $rs_insert_bc);

header("Location: group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=blockcontract");

}



function roundblock() {

$pcgroupid = $_REQUEST['pcgroupid'];
$timerid = $_REQUEST['timerid'];

require("deps.php");

require_once("common.php");

require("header.php");

start_blue_box(pcrtlang("Round Hour Entry"));

echo "<button class=button onClick=\"parent.location='blockcontract.php?func=roundblock2&pcgroupid=$pcgroupid&timerid=$timerid&roundto=0'\">Bill Actual Time</button><br>";
echo "<button class=button onClick=\"parent.location='blockcontract.php?func=roundblock2&pcgroupid=$pcgroupid&timerid=$timerid&roundto=15'\">Round up to nearest quarter hour</button><br>";
echo "<button class=button onClick=\"parent.location='blockcontract.php?func=roundblock2&pcgroupid=$pcgroupid&timerid=$timerid&roundto=30'\">Round up to nearest half hour</button><br>";
echo "<button class=button onClick=\"parent.location='blockcontract.php?func=roundblock2&pcgroupid=$pcgroupid&timerid=$timerid&roundto=60'\">Round up to nearest hour</button><br>";

stop_blue_box();
require_once("footer.php");

}


function roundblock2() {

require("deps.php");
require_once("validate.php");
require("common.php");

$pcgroupid = $_REQUEST['pcgroupid'];
$timerid = $_REQUEST['timerid'];
$roundto = $_REQUEST['roundto'];





$rs_insert_bc = "UPDATE timers SET savedround = '$roundto' WHERE timerid = '$timerid'";
@mysqli_query($rs_connect, $rs_insert_bc);

header("Location: group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=blockcontract");

}



function addhoursrecurring() {

$pcgroupid = $_REQUEST['pcgroupid'];
$blocktitle = $_REQUEST['blocktitle'];
$blockcontractid = $_REQUEST['blockcontractid'];

require("deps.php");

require_once("common.php");

if($gomodal != "1") {
require("header.php");
} else {
require_once("validate.php");
}

if($gomodal != "1") {
start_blue_box(pcrtlang("Add Recurring Invoice"));
} else {
echo "<h4>".pcrtlang("Add Recurring Invoice")."</h4>";
}

echo "<form action=blockcontract.php?func=addhoursrecurring2&pcgroupid=$pcgroupid&blockcontractid=$blockcontractid method=post><table><tr><td>";
echo "".pcrtlang("Recurring Hours to Add").":</td><td>";
echo "<input name=hourstoadd size=20 class=textbox></td></tr>";

echo "<tr><td>".pcrtlang("Invoice Line Item Title").":</td><td>";
echo "<input name=blocktitle size=40 class=textbox value=\"$blocktitle\"></td></tr>";

echo "<tr><td>".pcrtlang("Choose Option").":<br><span class=\"sizemesmaller italme\">(".pcrtlang("or manually enter hourly rate").")</span></td><td>";

$rs_quicklabor2 = "SELECT * FROM quicklabor ORDER BY theorder DESC";
$rs_result_ql2  = mysqli_query($rs_connect, $rs_quicklabor2);

echo "<select name=pricepick id=stringall onchange='document.getElementById(\"billrate\").value=this.options[this.selectedIndex].value'>";
echo "<option value=\"0\">".pcrtlang("Choose").":</option>";
while($rs_result_qld2 = mysqli_fetch_object($rs_result_ql2)) {
$labordesc = "$rs_result_qld2->labordesc";
$laborprice = mf("$rs_result_qld2->laborprice");
$primero = substr("$labordesc", 0, 1);
if("$primero" != "-") {
echo "<option value=\"$laborprice\">$money$laborprice - $labordesc</option>";
} else {
$labordesc3 = substr("$labordesc", 1);
echo "<option value=\"0\" style=\"background:#000000;color:#ffffff;padding:1px;\">$labordesc3</option>";
}
}

echo "</td></tr>";

echo "<tr><td>".pcrtlang("Hourly Rate").": </td>";
echo "<td>$money<input type=text id=billrate name=billrate class=textbox size=6></td></tr>";

$invoiceintervals = array('1W' => pcrtlang('Weekly'),'2W' => pcrtlang('Every 2 Weeks'),'1M' => pcrtlang('Monthly'),'2M' => pcrtlang('Every 2 Months'), '3M' => pcrtlang('Quarterly'),'6M' => pcrtlang('Every 6 Months'),'1Y' => pcrtlang('Yearly'));

$invoiceterms = 14;
$currentdate = date('Y-m-d');
$invthrudate = $currentdate;
$invoiceinterval = "1M";
$invoiceactive = 1;
$invoicenotes = "";


if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}

echo "<tr><td><span class=\"boldme\">".pcrtlang("Invoiced Thru Date").":</span></td><td><input size=35 type=text id=invthrudate class=textbox name=invthrudate value=\"$invthrudate\"></td></tr>";

?>
<script type="text/javascript" src="../repair/jq/datepickr.js"></script>
<script type="text/javascript">
new datepickr('invthrudate', { dateFormat: 'Y-m-d', theCurrentDate: document.getElementById("invthrudate").value });
</script>
<?php
echo "<tr><td><span class=\"boldme\">".pcrtlang("Invoice Inverval").":</span></td><td><select name=invinterval>";

foreach($invoiceintervals as $k => $v) {
if ($k == "$invoiceinterval") {
echo "<option selected value=$k>$v</option>";
} else {
echo "<option value=$k>$v</option>";
}
}

echo "</select></td></tr>";

echo "<tr><td><span class=\"boldme\">".pcrtlang("Invoice Terms").":</span><br><span class=\"sizemesmaller italme\">".pcrtlang("days prior to invoice thru date to re-invoice").".</span></td><td><input size=35 type=text class=textbox name=invterms value=\"$invoiceterms\"></td></tr>";


echo "<tr><td colspan=2><input type=submit class=button value=\"".pcrtlang("Add Recurring Invoice")."\"></form></td></tr></table></form>";

if($gomodal != 1) {
stop_blue_box();
}

if($gomodal != 1) {
require_once("footer.php");
}

}



function addhoursrecurring2() {
require_once("validate.php");
require("deps.php");
require("common.php");

$pcgroupid = $_REQUEST['pcgroupid'];
$blockcontractid = $_REQUEST['blockcontractid'];

$hourstoadd = $_REQUEST['hourstoadd'];
$billrate = $_REQUEST['billrate'];

$invthrudate = $_REQUEST['invthrudate'];
$invinterval = $_REQUEST['invinterval'];
$invterms = $_REQUEST['invterms'];

$reinvoicedate = date("Y-m-d", (strtotime($invthrudate) - ($invterms * 86400)));

$blocktitle = $_REQUEST['blocktitle'];

$invservice = $hourstoadd * $billrate;

$usertaxid = getusertaxid();
$taxrate = getservicetaxrate($usertaxid);
$itemtax = $taxrate * $invservice;


$rs_findpc = "SELECT * FROM pc_group WHERE pcgroupid = '$pcgroupid'";
$rs_result = mysqli_query($rs_connect, $rs_findpc);
$rs_result_q = mysqli_fetch_object($rs_result);
$invname = pv("$rs_result_q->pcgroupname");
$invcompany = pv("$rs_result_q->grpcompany");
$invphone = pv("$rs_result_q->grpphone");
$invaddy1 = pv("$rs_result_q->grpaddress1");
$invaddy2 = pv("$rs_result_q->grpaddress2");
$invcity = pv("$rs_result_q->grpcity");
$invstate = pv("$rs_result_q->grpstate");
$invzip = pv("$rs_result_q->grpzip");
$invemail = pv("$rs_result_q->grpemail");


if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');
$timestamp = time();





$rs_insert_cart = "INSERT INTO rinvoices (invname,invcompany,invaddy1,invaddy2,invphone,invemail,invthrudate,invinterval,invterms,reinvoicedate,invcity,invstate,invzip,byuser,invnotes,storeid,pcgroupid,invactive,blockcontractid,blockhours) VALUES  ('$invname','$invcompany','$invaddy1','$invaddy2','$invphone','$invemail','$invthrudate','$invinterval','$invterms','$reinvoicedate','$invcity','$invstate','$invzip','$ipofpc','','$defaultuserstore','$pcgroupid','1','$blockcontractid','$hourstoadd')";
@mysqli_query($rs_connect, $rs_insert_cart);

$invoiceid = mysqli_insert_id($rs_connect);

$rs_insert_invitems = "INSERT INTO rinvoice_items (cart_price,cart_type,cart_stock_id,labor_desc,return_sold_id,restocking_fee,price_alt,rinvoice_id,taxex,itemtax,origprice,discounttype,ourprice,itemserial,addtime) VALUES ('$invservice','labor','0','$blocktitle','0','','0','$invoiceid','$usertaxid','$itemtax','0','','0','','$timestamp')";
@mysqli_query($rs_connect, $rs_insert_invitems);

header("Location: group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=blockcontract");

}

#################################################################


function contractlist() {

require("deps.php");
require_once("common.php");

require_once("header.php");

echo "<script type=\"text/javascript\">document.title = \"".pcrtlang("Block of Time Contracts")."\";</script>";

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

if (array_key_exists("bcactive", $_REQUEST)) {
$bcactive = $_REQUEST['bcactive'];
} else {
$bcactive = "0";
}


if (array_key_exists("search", $_REQUEST)) {
$search = $_REQUEST['search'];
} else {
$search = "";
}

$search_ue = urlencode($search);


start_blue_box(pcrtlang("Browse Block of Time Contracts"));


echo "<table style=\"width:100%\"><tr><td>";
if($bcactive == 0) {
echo "<a href=blockcontract.php?func=contractlist&bcactive=1&search=$search_ue&sortby=$sortby class=\"linkbuttonmedium linkbuttongray radiusall\">
".pcrtlang("Show Inactive Contracts")."</a>";
} else {
echo "<a href=blockcontract.php?func=contractlist&bcactive=0&search=$search_ue&sortby=$sortby class=\"linkbuttonmedium linkbuttongray radiusall\">
".pcrtlang("Show Active Contracts")."</a>";
}


echo "</td><td style=\"text-align:right\"><i class=\"fa fa-search fa-lg\"></i>";
echo "<input type=text class=\"textbox\" id=searchbox placeholder=\"".pcrtlang("Enter Search Text")."\" value=\"$search\">";
echo "</td></tr></table>";

echo "<div id=themain>";

echo "</div>";

?>
<script type="text/javascript">
$(document).ready(function () {
     $.get('blockcontract.php?func=contractlistajax&pageNumber=<?php echo $pageNumber; ?>&sortby=<?php echo $sortby; ?>&search=<?php echo $search_ue; ?>&bcactive=<?php echo $bcactive; ?>', function(data) {
     $('#themain').html(data);
     });
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
                                        $('div#themain').load('blockcontract.php?func=contractlistajax&pageNumber=<?php echo $pageNumber; ?>&sortby=<?php echo $sortby; ?>&bcactive=<?php echo $bcactive; ?>').slideDown(200,function(){
                                        return false;
                                        });
                                }else{
                                        $('div#themain').load('blockcontract.php?func=contractlistajax&pageNumber=<?php echo $pageNumber; ?>&sortby=<?php echo $sortby; ?>&bcactive=<?php echo $bcactive; ?>&search='+encodedinv).slideDown(200);
                                }
                        }, 500);
  });
});
</script>


<?php


stop_blue_box();

require("footer.php");

}




function contractlistajax() {


if (array_key_exists("pageNumber", $_REQUEST)) {
$pageNumber = $_REQUEST['pageNumber'];
} else {
$pageNumber = 1;
}

if (array_key_exists("bcactive", $_REQUEST)) {
$bcactive = $_REQUEST['bcactive'];
} else {
$bcactive = 0;
}


if (array_key_exists("sortby", $_REQUEST)) {
$sortby = $_REQUEST['sortby'];
} else {
$sortby = "name_asc";
}


$results_per_page = 40;

if ($pageNumber == "") {
$offset = "0";
} else {
$offset = ($pageNumber * $results_per_page) - $results_per_page;
}



require("deps.php");
require_once("common.php");


if (array_key_exists("search", $_REQUEST)) {
$search = $_REQUEST['search'];
if($search != "") {
$searchsql = "AND (blockcontract.blocktitle LIKE '%$search%' OR blockcontract.blocknote LIKE '%$search%' OR pc_group.pcgroupname LIKE '%$search%' OR pc_group.grpemail LIKE '%$search%' OR pc_group.grpphone LIKE '%$search%' OR pc_group.grpworkphone LIKE '%$search%' OR pc_group.grpcellphone LIKE '%$search%' OR pc_group.grpcompany LIKE '%$search%')";
} else {
$searchsql = "";
$search = "";
}
} else {
$searchsql = "";
$search = "";
}

$search_ue = urlencode($search);

$rs_find_cart_items_total = "SELECT * FROM blockcontract,pc_group WHERE blockcontract.pcgroupid = pc_group.pcgroupid AND blockcontract.contractclosed = '$bcactive' $searchsql";
$rs_result_total = mysqli_query($rs_connect, $rs_find_cart_items_total);

$totalentries = mysqli_num_rows($rs_result_total);
$lastpage = $totalentries / $results_per_page;
if($lastpage != floor($lastpage)) {
$lastpage = floor($lastpage) + 1;
}

if($pageNumber > $lastpage) {
$pageNumber = 1;
$offset = 0;
}


if ("$sortby" == "id_asc") {
$rs_find_cart_items = "SELECT blockcontract.blockid AS blockid, blockcontract.blocktitle AS blocktitle, blockcontract.blocknote AS blocknote
, blockcontract.contractclosed AS bcactive,  blockcontract.hourscache AS hourscache,
blockcontract.pcgroupid AS pcgroupid, pc_group.pcgroupname AS groupname
FROM blockcontract,pc_group WHERE blockcontract.pcgroupid = pc_group.pcgroupid AND blockcontract.contractclosed = '$bcactive' $searchsql ORDER BY
blockcontract.blockid ASC LIMIT $offset,$results_per_page";

} elseif ("$sortby" == "id_desc") {
$rs_find_cart_items = "SELECT blockcontract.blockid AS blockid, blockcontract.blocktitle AS blocktitle, blockcontract.blocknote AS blocknote
, blockcontract.contractclosed AS bcactive, blockcontract.hourscache AS hourscache,
blockcontract.pcgroupid AS pcgroupid, pc_group.pcgroupname AS groupname
FROM blockcontract,pc_group WHERE blockcontract.pcgroupid = pc_group.pcgroupid AND blockcontract.contractclosed = '$bcactive' $searchsql ORDER BY
blockcontract.blockid DESC LIMIT $offset,$results_per_page";

} elseif ("$sortby" == "name_desc") {
$rs_find_cart_items = "SELECT blockcontract.blockid AS blockid, blockcontract.blocktitle AS blocktitle, blockcontract.blocknote AS blocknote
, blockcontract.contractclosed AS bcactive, blockcontract.hourscache AS hourscache,
blockcontract.pcgroupid AS pcgroupid, pc_group.pcgroupname AS groupname
FROM blockcontract,pc_group WHERE blockcontract.pcgroupid = pc_group.pcgroupid AND blockcontract.contractclosed = '$bcactive' $searchsql
ORDER BY pc_group.pcgroupname DESC LIMIT $offset,$results_per_page";

} else {
$rs_find_cart_items = "SELECT blockcontract.blockid AS blockid, blockcontract.blocktitle AS blocktitle, blockcontract.blocknote AS blocknote
, blockcontract.contractclosed AS bcactive, blockcontract.hourscache AS hourscache,
blockcontract.pcgroupid AS pcgroupid, pc_group.pcgroupname AS groupname
FROM blockcontract,pc_group WHERE blockcontract.pcgroupid = pc_group.pcgroupid AND blockcontract.contractclosed = '$bcactive' $searchsql
ORDER BY pc_group.pcgroupname ASC LIMIT $offset,$results_per_page";

}



$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);
echo "<br><table class=\"standard lastalignright\">";
echo "<tr><th>".pcrtlang("ID#");
echo "</th><th><a href=blockcontract.php?func=contractlist&pageNumber=$pageNumber&sortby=id_asc&scactive=$bcactive&search=$search_ue
class=\"linkbuttontiny linkbuttongray radiustop\">
<i class=\"fa fa-chevron-up\"></i></a><br>";
echo "<a href=blockcontract.php?func=contractlist&pageNumber=$pageNumber&sortby=id_desc&bcactive=$bcactive&search=$search_ue
class=\"linkbuttontiny linkbuttongray radiusbottom\">
<i class=\"fa fa-chevron-down\"></i></a>";
echo "</th><th>".pcrtlang("Customer");
echo "</th><th><a href=blockcontract.php?func=contractlist&pageNumber=$pageNumber&sortby=name_asc&bcactive=$bcactive&search=$search_ue
class=\"linkbuttontiny linkbuttongray radiustop\">
<i class=\"fa fa-chevron-up\"></i></a><br>";
echo "<a href=blockcontract.php?func=contractlist&pageNumber=$pageNumber&sortby=name_desc&bcactive=$bcactive&search=$search_ue
class=\"linkbuttontiny linkbuttongray radiusbottom\">
<i class=\"fa fa-chevron-down\"></i></a>";
echo "</th>";

echo "<th>".pcrtlang("Contract Name");
echo "</th>";

echo "<th>".pcrtlang("Contact Notes")."</th>";

echo "<th>".pcrtlang("Balance")."</th></tr>";

while($rs_result_q = mysqli_fetch_object($rs_result)) {
$blockid = "$rs_result_q->blockid";
$blocktitle = "$rs_result_q->blocktitle";
$blocknote = "$rs_result_q->blocknote";
$groupname = "$rs_result_q->groupname";
$bcactive2 = "$rs_result_q->bcactive";
$pcgroupid = "$rs_result_q->pcgroupid";
$hourscache = "$rs_result_q->hourscache";

echo "<tr><td colspan=2>#$blockid</td>";
echo "<td colspan=2><a href=group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=blockcontract class=\"linkbuttonsmall linkbuttongray radiusall\">$groupname</a>
</td>";
echo "<td><a href=\"group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=blockcontract\" class=\"linkbuttonsmall linkbuttongray radiusall\">$blocktitle</a>";


echo "</td>";

echo "<td>$blocknote</td><td>";

if($hourscache > 0) { 
echo "$hourscache";
} else {
echo "<span class=colormered>$hourscache</span>";
}

echo "</td>";

echo "</tr>";

}

echo "</table>";

stop_blue_box();

echo "<br>";

start_box();
#browse here

echo "<center>";

if($pageNumber != 1) {
$prevpage = $pageNumber - 1;
echo "<a href=blockcontract.php?func=contractlist&pageNumber=$prevpage&sortby=$sortby&scactive=$scactive&search=$search_ue class=\"linkbuttonmedium linkbuttongray radiusall\">
<i class=\"fa fa-chevron-left fa-lg\"></i></a>";
}

$html = get_paged_nav($totalentries, $results_per_page, false);

$html = str_replace("contractlistajax", "contractlist", "$html");
echo "$html";

if($lastpage != $pageNumber) {
$nextpage = $pageNumber + 1;
echo "<a href=blockcontract.php?func=contractlist&pageNumber=$nextpage&sortby=$sortby&bcactive=$bcactive&search=$search_ue class=\"linkbuttonmedium linkbuttongray radiusall\">
<i class=\"fa fa-chevron-right fa-lg\"></i></a>";
}

echo "</center>";


}







switch($func) {
                                                                                                    
    default:
    nothing();
    break;
                                
    case "newcontract":
    newcontract();
    break;

    case "newcontract2":
    newcontract2();
    break;

   case "starttimerbc":
    starttimerbc();
    break;

  case "addhourssingle":
    addhourssingle();
    break;

  case "addhourssingle2":
    addhourssingle2();
    break;


  case "contractclosed":
    contractclosed();
    break;

 case "deletehoursinvoice":
    deletehoursinvoice();
    break;

  case "editcontract":
    editcontract();
    break;

  case "editcontract2":
    editcontract2();
    break;


 case "billtocontract":
    billtocontract();
    break;
  
 case "removefromcontract":
    removefromcontract();
    break;

 case "roundblock":
    roundblock();
    break;

 case "roundblock2":
    roundblock2();
    break;

  case "addhoursrecurring":
    addhoursrecurring();
    break;

  case "addhoursrecurring2":
    addhoursrecurring2();
    break;

  case "contractlist":
    contractlist();
    break;

  case "contractlistajax":
    contractlistajax();
    break;


}

