<?php
                                                                                                    
/***************************************************************************
 *   copyright            : (C) 2013 PCRepairTracker.com
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

                                                                                                    
function printpricecard() {
require_once("validate.php");
require("deps.php");
require_once("common.php");

$stockid = $_REQUEST['stockid'];





$rs_findpc = "SELECT * FROM stock WHERE stock_id = '$stockid'";
$rs_result = mysqli_query($rs_connect, $rs_findpc);
while($rs_result_q = mysqli_fetch_object($rs_result)) {
$stock_title = "$rs_result_q->stock_title";
$stock_price2 = "$rs_result_q->stock_price";

if(array_key_exists('tax', $_REQUEST)) {
$usertaxid = getusertaxid();
$salestaxrate = getsalestaxrate($usertaxid);
$itemtax = $stock_price2 * $salestaxrate;
$stock_price = $stock_price2 + $itemtax;
} else {
$stock_price = $stock_price2;
}

?>
<!DOCTYPE html>

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php


echo "<title>$sitename</title>";

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../repair/printstyle.css\">";


echo "</head>";

if($autoprint == 1) {
if($enablesignaturepad_claimticket == "yes") {
if($thesig != "") {
echo "<body class=printpagebg onLoad=\"window.print()\">";
} else {
echo "<body class=printpagebg>";
}
} else {
echo "<body class=printpagebg onLoad=\"window.print()\">";
}
} else {
echo "<body class=printpagebg>";
}


echo "<div class=printbar>";
echo "<button onClick=\"parent.location='stock.php?func=show_stock_detail&stockid=$stockid'\" class=bigbutton><img src=../store/images/left.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Return")."</button>";
echo "<font class=text30b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>";
echo "<button onClick=\"print();\" class=bigbutton><img src=../store/images/print.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Print")."</button>";
echo "<font class=text30b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>";

if(!array_key_exists('tax', $_REQUEST)) {
echo "<button onClick=\"parent.location='printpricecard.php?func=printpricecard&stockid=$stockid&tax=tax'\" class=bigbutton><img src=../store/images/pricetag.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Add Tax")."</button>";
echo "<font class=text30b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>";
} else {
echo "<button onClick=\"parent.location='printpricecard.php?func=printpricecard&stockid=$stockid'\" class=bigbutton><img src=../store/images/pricetag.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Remove Tax")."</button>";
echo "<font class=text30b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>";
}


echo "</div>";

echo "<div class=printpage>";
echo "<table style=\"width:500px;border-collapse:collapse;\">";

echo "<tr><td style=\"border-left: #cccccc 1px dashed;border-top: #cccccc 1px dashed;border-right: #cccccc 1px dashed;border-bottom: #cccccc 1px solid;height:300px;\">.</td></tr>";

echo "<tr><td style=\"border-left: #cccccc 1px dashed;border-right: #cccccc 1px dashed;height:275px;text-align:center;\">";






#################################################################################
# Start of Price Card
#################################################################################

echo "<font class=pricetitle>&nbsp;&nbsp;$stock_title&nbsp;&nbsp;</font><br>";

echo "<table style=\"margin-left:auto;margin-right:auto\"><tr><td style=\"padding: 10px\">";
echo "</td><td style=\"padding: 10px\">";
echo "<font class=text12b>Stock ID:</font> <font class=text12>$stockid</font><br>";
echo "</td></tr></table>";

echo "<font class=text50b>$money".mf("$stock_price")."</font><br>";
#################################################################################
# End of Price Card
#################################################################################







echo "</td></tr>";

echo "<tr><td style=\"border-left: #cccccc 1px dashed;border-top: #cccccc 1px solid;border-right: #cccccc 1px dashed;border-bottom: #cccccc 1px solid;height:200px;\">.</td></tr>";
echo "<tr><td style=\"border-left: #cccccc 1px dashed;border-right: #cccccc 1px dashed;border-bottom: #cccccc 1px dashed;height:75px;\">.</td></tr>";
echo "</table>";

}



echo "</div>";

}






switch($func) {
                                                                                                    
    default:
    printpricecard();
    break;
                                


}

?>
