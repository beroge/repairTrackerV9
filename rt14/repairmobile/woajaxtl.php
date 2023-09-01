<?php 

/***************************************************************************
 *   copyright            : (C) 2010 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/

require("validate2.php");
require("common.php");

$pcwo = $_REQUEST['pcwo'];
$addystring = $_REQUEST['addystring'];

echo "<br>";
echo "<button type=button onClick=\"parent.location='pc.php?func=addmiles&woid=$pcwo&addystring=$addystring'\" data-theme=\"b\"><i class=\"fa fa-car fa-lg\"></i> ".pcrtlang("add mileage")."</button>";


echo "<br>";

$rs_find_tl = "SELECT * FROM travellog WHERE tlwo = '$pcwo'";
$rs_result_tl = mysqli_query($rs_connect, $rs_find_tl);

if(mysqli_num_rows($rs_result_tl) > 0) {


echo "<form action=repcart.php?func=addmiles method=post data-ajax=\"false\">";
echo "<table class=doublestandard><tr><th colspan=2>".pcrtlang("Travel Log")."</th>";


$totaldist = 0;

while($rs_result_item_q = mysqli_fetch_object($rs_result_tl)) {
$tlid = "$rs_result_item_q->tlid";
$tlwo = "$rs_result_item_q->tlwo";
$tldate2 = "$rs_result_item_q->tldate";
$tlmiles = "$rs_result_item_q->tlmiles";
$traveluser = "$rs_result_item_q->traveluser";

$totaldist = $totaldist + $tlmiles;

$tldate = pcrtdate("$pcrt_shortdate", "$tldate2")." ".pcrtdate("$pcrt_time", "$tldate2");
echo "<tr><td>$traveluser</td><td>$tlmiles";

if("$pcrt_units" == "METRIC") {
echo pcrtlang("km");
} else {
echo " ".pcrtlang("miles");
}

echo "</td></tr><tr><td>$tldate</td><td>";


echo "<a href=\"#popupdeletetl$tlid\" data-rel=\"popup\" data-position-to=\"window\" data-transition=\"pop\" class=\"ui-btn ui-shadow ui-corner-all\">";
echo "<i class=\"fa fa-trash fa-lg\"></i></a>";
echo "<div data-role=\"popup\" id=\"popupdeletetl$tlid\" data-overlay-theme=\"b\"  data-theme=\"a\" data-dismissible=\"false\">";
echo "<div data-role=\"header\" data-theme=\"b\">";
echo "<h1>".pcrtlang("Delete Entry")."?</h1>";
echo "</div>";
echo "<div role=\"main\" class=\"ui-content\">";
echo "<p>".pcrtlang("Are you sure you wish to delete this travel log entry?")."</p>";
echo "<div align=\"right\"><a href=\"#\" data-rel=\"back\" class=\"ui-btn ui-shadow ui-btn-inline ui-corner-all\" data-inline=\"true\">";
echo "<i class=\"fa fa-ban fa-lg\"></i>  ".pcrtlang("Cancel")."</a>";
echo "<button onClick=\"parent.location='pc.php?func=deletetl&tlid=$tlid&woid=$pcwo'\" data-inline=\"true\">";
echo "<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Delete")." </button></div>";
echo "</div>";
echo "</div>";
echo "</td></tr>";

}

echo "<tr><td>".pcrtlang("Total")."</td><td><input type=text name=miles value=\"$totaldist\"></td></tr><tr>";
echo "<td><input type=text name=permile placeholder=\"Enter mileage charge\"> <input type=hidden name=pcwo value=$pcwo>";
echo "</td><td><button type=submit>".pcrtlang("Add to Cart")."</button></td></tr>";

echo "</table></form>";


}




?>
