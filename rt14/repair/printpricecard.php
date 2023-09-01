<?php
                                                                                                    
/***************************************************************************
 *   copyright            : (C) 2019 PCRepairTracker.com
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

$woid = $_REQUEST['woid'];

if (array_key_exists('vas',$_REQUEST)) {
$vas = $_REQUEST['vas'];
} else {
$vas = "0";
}






$rs_findpc = "SELECT * FROM pc_wo WHERE woid = '$woid'";
$rs_result = mysqli_query($rs_connect, $rs_findpc);
while($rs_result_q = mysqli_fetch_object($rs_result)) {
$pcid = "$rs_result_q->pcid";


$rs_findowner = "SELECT * FROM pc_owner WHERE pcid = '$pcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
while($rs_result_q2 = mysqli_fetch_object($rs_result2)) {
$pcname = "$rs_result_q2->pcname";
$pcmake = "$rs_result_q2->pcmake";
$pcextra = "$rs_result_q2->pcextra";
$mainassettypeidindb = "$rs_result_q2->mainassettypeid";
$mainassettype = getassettypename($mainassettypeidindb);

if ($pcextra != "") {
$custompcinfoindb3 = unserialize($pcextra);
} else {
$custompcinfoindb3 = array();
}
if(is_array($custompcinfoindb3)) {
$custompcinfoindb = $custompcinfoindb3;
} else {
$custompcinfoindb = array();
}


$rs_findtsum = "SELECT SUM(cart_price) AS checkcartitemsum,  SUM(itemtax) AS checkcarttaxsum FROM repaircart WHERE pcwo = '$woid' AND cart_type = 'purchase'";
$rs_findtsum2 = @mysqli_query($rs_connect, $rs_findtsum);
$rs_findtsum3 = mysqli_fetch_object($rs_findtsum2);
$checkcartitemsum = "$rs_findtsum3->checkcartitemsum";
$checkcarttaxsum = "$rs_findtsum3->checkcarttaxsum";
$checkcartitemsumwithtax = tnv($checkcartitemsum) + tnv($checkcarttaxsum);

?>
<!DOCTYPE html>

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<link rel="stylesheet" href="fa/css/font-awesome.min.css">

<?php


echo "<title>$sitename</title>";

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"printstyle.css\">";


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
echo "<button onClick=\"parent.location='index.php?pcwo=$woid'\" class=bigbutton><img src=images/left.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Return")."</button>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<button onClick=\"print();\" class=bigbutton><img src=images/print.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Print")."</button>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

if(!array_key_exists('tax', $_REQUEST)) {
echo "<button onClick=\"parent.location='printpricecard.php?func=printpricecard&woid=$woid&tax=tax&vas=$vas'\" class=bigbutton><img src=../store/images/pricetag.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Add Tax")."</button>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
} else {
echo "<button onClick=\"parent.location='printpricecard.php?func=printpricecard&woid=$woid&vas=$vas'\" class=bigbutton><img src=../store/images/pricetag.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Remove Tax")."</button>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
}
echo "";


###
$rs_quicklabor = "SELECT * FROM quicklabor ORDER BY theorder DESC";
$rs_result_ql  = mysqli_query($rs_connect, $rs_quicklabor);

echo "<h4>".pcrtlang("Include Value Added Service Option:")."</h4>";

echo "<form action=\"printpricecard.php?func=printpricecard&woid=$woid\" method=post><input type=hidden name=pcwo value=$woid><select name=vas onchange='this.form.submit()'>";
echo "<option value=\"0\">".pcrtlang("Choose").":</option>";


while($rs_result_qld = mysqli_fetch_object($rs_result_ql)) {
$labordesc = "$rs_result_qld->labordesc";
$laborprice = mf("$rs_result_qld->laborprice");
$qlid = "$rs_result_qld->quickid";

$labordesc2 = urlencode("$labordesc");

$primero = substr("$labordesc", 0, 1);

if("$primero" != "-") {
echo "<option value=\"$qlid\">$money$laborprice $labordesc</option>";
} else {
$labordesc3 = substr("$labordesc", 1);
echo "<option value=\"0\" style=\"background:#000000;color:#ffffff;padding:3px;\">$labordesc3</option>";
}
}


echo "</select></form>";

###



echo "</div>";


echo "<div class=printpage><table style=\"width:500px;border-collapse:collapse;\">";

echo "<tr><td style=\"border-left: #cccccc 1px dashed;border-top: #cccccc 1px dashed;border-right: #cccccc 1px dashed;border-bottom: #cccccc 1px solid;height:300px;\">.</td></tr>";

echo "<tr><td style=\"border-left: #cccccc 1px dashed;border-right: #cccccc 1px dashed;height:325px;text-align:center;padding:5px\">";


function removezeros($price) {
return str_replace('.00', '', $price);
}




#################################################################################
# Start of Price Card
#################################################################################


echo "<table style=\"margin-left:auto;margin-right:auto; border:#000000 10px solid;border-radius:30px;width:100%\"><tr><td style=\"padding: 20px\">";

echo "<img src=$printablelogo style=\"width:128px\"><br><br>";

require_once("brandicon.php");
$largeicon = brandicon("$pcmake $mainassettype");
echo "<img src=images/pcs/$largeicon border=0>";
echo "</td><td style=\"padding: 30px\">";

echo "<span class=pricetitle style=\"white-space: nowrap;\">&nbsp;&nbsp;$pcmake&nbsp;&nbsp;</span><br><br>";

echo "<table style=\"width:100%\">";
$rs_allfindassets = "SELECT * FROM mainassetinfofields WHERE showonpricecard = '1'";
$rs_result2all = mysqli_query($rs_connect, $rs_allfindassets);
while ($rs_result_q2all = mysqli_fetch_object($rs_result2all)) {
$mainassetfieldid = "$rs_result_q2all->mainassetfieldid";
$mainassetfieldname = "$rs_result_q2all->mainassetfieldname";
$allassetinfofields[$mainassetfieldid] = "$mainassetfieldname";
}

foreach($custompcinfoindb as $key => $val) {
if(array_key_exists("$key", $allassetinfofields)) {
if($val != "") {
echo "<tr><td>$allassetinfofields[$key]: </td><td>$val</td></tr>";
}
}
}

echo "</table>";

echo "<br><i class=\"fa fa-tag fa-lg\"></i> $pcid<br><br>";

#echo "</td></tr></table>";



if(!array_key_exists('tax', $_REQUEST)) {
echo "<span class=\"sizeme4x boldme\">$money".removezeros(mf("$checkcartitemsum"))."</span><br>";
} else {
echo "<span class=\"sizeme4x boldme\">$money".removezeros(mf("$checkcartitemsumwithtax"))."</span><br>";
}

if($vas != 0) {
$rs_quicklabor = "SELECT * FROM quicklabor WHERE quickid = '$vas'";
$rs_result_ql  = mysqli_query($rs_connect, $rs_quicklabor);
$rs_result_qld = mysqli_fetch_object($rs_result_ql);
$labordesc = "$rs_result_qld->labordesc";
$laborprice = mf("$rs_result_qld->laborprice");
$qlid = "$rs_result_qld->quickid";

$usertaxid = getusertaxid();
$taxrate = getservicetaxrate($usertaxid);

$laborpricetax =  $laborprice * $taxrate;

$checkcartitemsumwithtaxvas = $checkcartitemsumwithtax + $laborpricetax + $laborprice;
$checkcartitemsumvas = $checkcartitemsum + $laborprice;

if(array_key_exists('tax', $_REQUEST)) {
echo "<br><span class=\"sizemelarger boldme\">".pcrtlang("With").": $labordesc</span><br><span class=\"sizeme3x boldme\">$money".removezeros(mf("$checkcartitemsumwithtaxvas"))."</span><br>";
} else {
echo "<br><span class=\"sizemelarger boldme\">".pcrtlang("With").": $labordesc</span><br><span class=\"sizeme3x boldme\">$money".removezeros(mf("$checkcartitemsumvas"))."</span><br>";
}


}


echo "</td></tr></table>";

#################################################################################
# End of Price Card
#################################################################################







echo "</td></tr>";

echo "<tr><td style=\"border-left: #cccccc 1px dashed;border-top: #cccccc 1px solid;border-right: #cccccc 1px dashed;border-bottom: #cccccc 1px solid;height:200px;\">.</td></tr>";
echo "<tr><td style=\"border-left: #cccccc 1px dashed;border-right: #cccccc 1px dashed;border-bottom: #cccccc 1px dashed;height:75px;\">.</td></tr>";
echo "</table>";

}

}

echo "</div>";

}






switch($func) {
                                                                                                    
    default:
    printpricecard();
    break;
                                


}

?>
