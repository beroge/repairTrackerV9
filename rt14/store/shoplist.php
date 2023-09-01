<?php

/***************************************************************************
 *   copyright            : (C) 2012 PCRepairTracker.com
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


                                                                                                    
function shoplist() {
require_once("header.php");

?>



<table style="width:100%;border-collapse:collapse;border: 1px #777777 solid;margin:0px;"><tr><td valign=top colspan=5 bgcolor=#eeeeee>
<h4><?php echo pcrtlang("Order Planning"); ?>&nbsp;</h4><br><br>
<?php echo pcrtlang("Qty"); ?>. &nbsp;&nbsp;<?php echo pcrtlang("Items Desc"); ?>:</td></tr><tr bgcolor=#eeeeee><td colspan=5 valign=top>
<form action=shoplist.php?func=add_item method=post>
<input type=text size=2 name=qty class=textbox value=1><input type=text size=30 name=itemdesc class=textbox>
<select name=status>
<?php
require("deps.php");

if ($gomodal == 1) {
$therel = "rel=facebox";
} else {
$therel = "";
}


reset($shopliststatus);
foreach($shopliststatus as $thestatus => $thestatus2) {
echo "<option value=\"$thestatus\">$thestatus</option>";
}

echo "</select><input type=submit value=\"".pcrtlang("Add")."\" class=button></form></td></tr>";

$rs_findpc = "SELECT * FROM shoplist ORDER BY itemstatus DESC,itemdesc ASC";
$rs_result = mysqli_query($rs_connect, $rs_findpc);

$oldstatus = "";



while($rs_result_q = mysqli_fetch_object($rs_result)) {
$shopid = "$rs_result_q->shopid";
$qty = "$rs_result_q->qty";
$itemdesc2 = "$rs_result_q->itemdesc";
$status = "$rs_result_q->itemstatus";
$byuser = "$rs_result_q->byuser";
$stockid = "$rs_result_q->stockid";

reset($shopliststatus);
$thecol = $shopliststatus["$status"];

if ($oldstatus != $status) {
echo "<tr><td colspan=5 bgcolor=#eeeeee>&nbsp;</td></tr>";
echo "<tr bgcolor=#$thecol><td colspan=5>$status</td></tr>";
}

echo "\n<tr bgcolor=#$thecol><td><a href=shoplist.php?func=edititemq&dir=up&shopid=$shopid class=\"linkbuttontiny linkbuttongray radiusleft\"><i class=\"fa fa-chevron-up\"></i></a>";

if ($qty > 1) {
echo "<a href=shoplist.php?func=edititemq&dir=down&shopid=$shopid class=\"linkbuttontiny linkbuttongray radiusright\"><i class=\"fa fa-chevron-down\"></i></a>";
}

$itemdesc = htmlspecialchars($itemdesc2);

echo "</td><td><form action=shoplist.php?func=edititem method=post><input type=hidden value=$shopid name=shopid><input type=text size=2 name=qty class=textbox value=$qty>
<input type=text size=35 name=itemdesc class=textboxw value=\"$itemdesc\">";

if ($byuser != "") {
echo " <span class=\"sizemesmaller italme\">".pcrtlang("by")." $byuser</span>";
}

echo "</td><td valign=center>";
echo "\n<select name=status onchange='this.form.submit()'><option value=\"$status\">$status</option>";
reset($shopliststatus);
foreach($shopliststatus as $thestatus => $thestatus2) {
echo "<option value=\"$thestatus\">$thestatus</option>\n";
$oldstatus = $status;
}


echo "</select> </td><td><input type=submit value=\"&laquo;".pcrtlang("edit")."\" class=button></form>";

if ($stockid != 0) {
echo "&nbsp;&nbsp;<a href=\"stock.php?func=restock_item&stockid=$stockid&stockqty=$qty\" class=imagelink $therel><img src=\"images/restock.png\" align=absmiddle></a>";
}

echo "</td><td> &nbsp;&nbsp;&nbsp;&nbsp;<a href=shoplist.php?func=remove_item&item_id=$shopid class=\"linkbuttonsmall linkbuttonred radiusall\">
<i class=\"fa fa-trash fa-lg\"></i></a></td></tr>";

}



?>

</table>






<?php


require_once("footer.php");
                                                                                                    
}

function add_item() {

require("deps.php");

require("common.php");

require_once("validate.php");

$qty = pv($_REQUEST['qty']);
$itemdesc = pv($_REQUEST['itemdesc']);
$status = pv($_REQUEST['status']);
if (array_key_exists('stockid',$_REQUEST)) {
$stockid = $_REQUEST['stockid'];
} else {
$stockid = 0;
}






$rs_insert_cart = "INSERT INTO shoplist (qty,itemdesc,itemstatus,byuser,stockid) VALUES  ('$qty','$itemdesc','$status','$ipofpc','$stockid')";
@mysqli_query($rs_connect, $rs_insert_cart);

header("Location: shoplist.php");

}



function remove_item() {

$item_id = $_REQUEST['item_id'];


require("deps.php");
require("common.php");

require_once("validate.php");






$rs_delete_cart = "DELETE FROM shoplist WHERE shopid = '$item_id'";
@mysqli_query($rs_connect, $rs_delete_cart);

header("Location: shoplist.php");
}

function edititem() {

require("deps.php");
require("common.php");

require_once("validate.php");

$shopid = $_REQUEST['shopid'];
$qty = $_REQUEST['qty'];
$itemdesc = pv($_REQUEST['itemdesc']);
$status = pv($_REQUEST['status']);
                                                                                                                                               



                                                                                                                                         
                                                                                                                                               
$rs_update = "UPDATE shoplist SET qty = '$qty', itemdesc = '$itemdesc', itemstatus = '$status' WHERE shopid = '$shopid'";
@mysqli_query($rs_connect, $rs_update);
                                                                                                                                               
header("Location: shoplist.php");
}

function edititemq() {

$dir = $_REQUEST['dir'];
$shopid = $_REQUEST['shopid'];


require("deps.php");
require("common.php");

require_once("validate.php");






if ($dir =="up") {
$rs_update = "UPDATE shoplist SET qty = (qty + 1) WHERE shopid = '$shopid'";
} else {
$rs_update = "UPDATE shoplist SET qty = (qty - 1) WHERE shopid = '$shopid'";
}

@mysqli_query($rs_connect, $rs_update);

header("Location: shoplist.php");
}







switch($func) {
                                                                                                    
    default:
    shoplist();
    break;
                                
    case "add_item":
    add_item();
    break;

                                   
    case "remove_item":
    remove_item();
    break;
                                 
    case "edititem":
    edititem();
    break;
                                                                                                                             
    case "edititemq":
    edititemq();
    break;

    case "shoplist":
    shoplist();
    break;



}

?>
