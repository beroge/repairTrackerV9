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

                                                                                                    
function payees() {
require_once("header.php");
require("deps.php");


start_blue_box(pcrtlang("Payees"));

echo "<table class=standard>";
echo "<tr><th>".pcrtlang("Payee Name")."</th>";
echo "<th>".pcrtlang("Contact")."</th>";
echo "<th>".pcrtlang("Account No.")."</th>";
echo "<th>".pcrtlang("Email")."</th>";
echo "<th>".pcrtlang("Phone")."</th>";
echo "<th>".pcrtlang("Address")."</th>";

echo "<th></th></tr>";

$rs_find_payees = "SELECT * FROM glpayees ORDER BY payeename ASC";
$rs_result_payees = mysqli_query($rs_connect,$rs_find_payees);
while($rs_result_payeesq = mysqli_fetch_object($rs_result_payees)) {
$payeeid = "$rs_result_payeesq->payeeid";
$payeename = "$rs_result_payeesq->payeename";
$payeecontact = "$rs_result_payeesq->payeecontact";
$payeeaccountno = "$rs_result_payeesq->payeeaccountno";
$payeeemail = "$rs_result_payeesq->payeeemail";
$payeephone = "$rs_result_payeesq->payeephone";
$payeeaddy1 = "$rs_result_payeesq->payeeaddy1";
$payeeaddy2 = "$rs_result_payeesq->payeeaddy2";
$payeecity = "$rs_result_payeesq->payeecity";
$payeestate = "$rs_result_payeesq->payeestate";
$payeezip = "$rs_result_payeesq->payeezip";


echo "<tr><td>$payeename</td><td>$payeecontact</td><td>$payeeaccountno</td><td>$payeeemail</td><td>$payeephone</td><td>$payeeaddy1";

if("$payeeaddy2" != "") {
echo "<br>$payeeaddy2";
} 
echo "<br>$payeecity $payeestate $payeezip";

echo "</td>";

echo "<td style=\"width:80px\"><a href=\"payees.php?func=editpayee&payeeid=$payeeid\" class=\"linkbuttonsmall linkbuttongray radiusall\"><i class=\"fa fa-edit fa-lg\"></i></a>";

$rs_find_payeeu = "SELECT * FROM glstransdet WHERE payee = '$payeeid'";
$rs_result_payeeu = mysqli_query($rs_connect,$rs_find_payeeu);
$payeeused = mysqli_num_rows($rs_result_payeeu);
if($payeeused == 0) {
echo "<a href=\"payees.php?func=deletepayee&payeeid=$payeeid\" class=\"linkbuttonsmall linkbuttongray radiusall\"><i class=\"fa fa-trash fa-lg\"></i></a>";
}
echo "</td></tr>";




}

echo "</table>";

stop_blue_box();

echo "<br><br>";

start_blue_box(pcrtlang("Add New Payee"));

echo "<form action=payees.php?func=newpayee method=post>";
echo "<table class=standard>";
echo "<tr><td>".pcrtlang("Payee Name").":</td><td><input size=35 class=textbox type=text name=payeename required=required></td></tr>";
echo "<tr><td>".pcrtlang("Payee Contact").":</td><td><input size=35 class=textbox type=text name=payeecontact></td></tr>";
echo "<tr><td>".pcrtlang("Payee Account No.").":</td><td><input size=35 class=textbox type=text name=payeeaccountno></td></tr>";
echo "<tr><td>".pcrtlang("Payee Email").":</td><td><input size=35 class=textbox type=text name=payeeemail></td></tr>";
echo "<tr><td>".pcrtlang("Payee Phone").":</td><td><input size=35 class=textbox type=text name=payeephone></td></tr>";

echo "<tr><td>$pcrt_address1:</td><td><input size=35 class=textbox type=text name=payeeaddy1></td></tr>";
echo "<tr><td>$pcrt_address2:</td><td><input size=35 class=textbox type=text name=payeeaddy2></td></tr>";
echo "<tr><td>$pcrt_city:</td><td><input size=35 class=textbox type=text name=payeecity></td></tr>";
echo "<tr><td>$pcrt_state:</td><td><input size=35 class=textbox type=text name=payeestate></td></tr>";
echo "<tr><td>$pcrt_zip:</td><td><input size=35 class=textbox type=text name=payeezip></td></tr>";


echo "<tr><td colspan=2><button class=button type=submit id=submitbutton><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Add New Payee")."</button>";
echo "</form>";
echo "</td></tr>";


echo "</table>";

stop_blue_box();

require_once("footer.php");
                                                                                                    
}




function newpayee() {
require_once("validate.php");
require("deps.php");
require("common.php");       

$payeename = pv($_REQUEST['payeename']);
$payeecontact = pv($_REQUEST['payeecontact']);
$payeeaccountno = pv($_REQUEST['payeeaccountno']);
$payeeemail = pv($_REQUEST['payeeemail']);
$payeephone = pv($_REQUEST['payeephone']);
$payeeaddy1 = pv($_REQUEST['payeeaddy1']);
$payeeaddy2 = pv($_REQUEST['payeeaddy2']);
$payeecity = pv($_REQUEST['payeecity']);
$payeestate = pv($_REQUEST['payeestate']);
$payeezip = pv($_REQUEST['payeezip']);




$rs_insert_payee = "INSERT INTO glpayees (payeename,payeecontact,payeeaccountno,payeeemail,payeephone,payeeaddy1,payeeaddy2,payeecity,payeestate,payeezip) 
VALUES ('$payeename','$payeecontact','$payeeaccountno','$payeeemail','$payeephone','$payeeaddy1','$payeeaddy2','$payeecity','$payeestate','$payeezip')";
@mysqli_query($rs_connect, $rs_insert_payee);
                               
header("Location: payees.php");

}


function deletepayee() {
require_once("validate.php");
require("deps.php");
require("common.php");

$payeeid = pv($_REQUEST['payeeid']);

$rs_delete_payee = "DELETE FROM glpayees WHERE payeeid = '$payeeid'";
@mysqli_query($rs_connect, $rs_delete_payee);

header("Location: payees.php");

}





function editpayee() {
require_once("header.php");
require("deps.php");

$payeeid = pv($_REQUEST['payeeid']);

$rs_find_payees = "SELECT * FROM glpayees WHERE payeeid = '$payeeid'";
$rs_result_payees = mysqli_query($rs_connect,$rs_find_payees);
$rs_result_payeesq = mysqli_fetch_object($rs_result_payees);
$payeename = "$rs_result_payeesq->payeename";
$payeecontact = "$rs_result_payeesq->payeecontact";
$payeeaccountno = "$rs_result_payeesq->payeeaccountno";
$payeeemail = "$rs_result_payeesq->payeeemail";
$payeephone = "$rs_result_payeesq->payeephone";
$payeeaddy1 = "$rs_result_payeesq->payeeaddy1";
$payeeaddy2 = "$rs_result_payeesq->payeeaddy2";
$payeecity = "$rs_result_payeesq->payeecity";
$payeestate = "$rs_result_payeesq->payeestate";
$payeezip = "$rs_result_payeesq->payeezip";


start_blue_box(pcrtlang("Edit Payee"));

echo "<form action=payees.php?func=editpayee2 method=post><input type=hidden name=payeeid value=$payeeid>";
echo "<table class=standard>";
echo "<tr><td>".pcrtlang("Payee Name").":</td><td><input size=35 class=textbox type=text name=payeename required=required value=\"$payeename\"></td></tr>";
echo "<tr><td>".pcrtlang("Payee Contact").":</td><td><input size=35 class=textbox type=text name=payeecontact value=\"$payeecontact\"></td></tr>";
echo "<tr><td>".pcrtlang("Payee Account No.").":</td><td><input size=35 class=textbox type=text name=payeeaccountno value=\"$payeeaccountno\"></td></tr>";
echo "<tr><td>".pcrtlang("Payee Email").":</td><td><input size=35 class=textbox type=text name=payeeemail value=\"$payeeemail\"></td></tr>";
echo "<tr><td>".pcrtlang("Payee Phone").":</td><td><input size=35 class=textbox type=text name=payeephone value=\"$payeephone\"></td></tr>";

echo "<tr><td>$pcrt_address1:</td><td><input size=35 class=textbox type=text name=payeeaddy1 value=\"$payeeaddy1\"></td></tr>";
echo "<tr><td>$pcrt_address2:</td><td><input size=35 class=textbox type=text name=payeeaddy2 value=\"$payeeaddy2\"></td></tr>";
echo "<tr><td>$pcrt_city:</td><td><input size=35 class=textbox type=text name=payeecity value=\"$payeecity\"></td></tr>";
echo "<tr><td>$pcrt_state:</td><td><input size=35 class=textbox type=text name=payeestate value=\"$payeestate\"></td></tr>";
echo "<tr><td>$pcrt_zip:</td><td><input size=35 class=textbox type=text name=payeezip value=\"$payeezip\"></td></tr>";


echo "<tr><td colspan=2><button class=button type=submit id=submitbutton><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button>";
echo "</form>";
echo "</td></tr>";


echo "</table>";

stop_blue_box();



require_once("footer.php");

}



function editpayee2() {
require_once("validate.php");
require("deps.php");
require("common.php");

$payeeid = pv($_REQUEST['payeeid']);
$payeename = pv($_REQUEST['payeename']);
$payeecontact = pv($_REQUEST['payeecontact']);
$payeeaccountno = pv($_REQUEST['payeeaccountno']);
$payeeemail = pv($_REQUEST['payeeemail']);
$payeephone = pv($_REQUEST['payeephone']);
$payeeaddy1 = pv($_REQUEST['payeeaddy1']);
$payeeaddy2 = pv($_REQUEST['payeeaddy2']);
$payeecity = pv($_REQUEST['payeecity']);
$payeestate = pv($_REQUEST['payeestate']);
$payeezip = pv($_REQUEST['payeezip']);


$rs_update_payee = "UPDATE glpayees SET payeename = '$payeename', payeecontact = '$payeecontact', payeeaccountno = '$payeeaccountno', payeeemail = '$payeeemail', payeephone = '$payeephone', payeeaddy1 = '$payeeaddy1', payeeaddy2 = '$payeeaddy2', payeecity = '$payeecity', payeestate = '$payeestate', payeezip = '$payeezip' WHERE payeeid = '$payeeid'";
@mysqli_query($rs_connect, $rs_update_payee);


header("Location: payees.php");

}



switch($func) {
                                                                                                    
    default:
    payees();
    break;
                                
    case "newpayee":
    newpayee();
    break;

  case "deletepayee":
    deletepayee();
    break;


  case "editpayee":
    editpayee();
    break;

  case "editpayee2":
    editpayee2();
    break;


}

?>

