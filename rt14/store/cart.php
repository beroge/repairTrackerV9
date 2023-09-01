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

                                                                                                    
function show_cart() {
require_once("header.php");
require("deps.php");
require_once("common.php");

echo "<script type=\"text/javascript\">document.title = \"".pcrtlang("Cart")."\";</script>";


#fop

$sqlcheckfop = "SELECT fop FROM sold_items";
$check = mysqli_query($rs_connect, $sqlcheckfop);

if(!$check) {
$cf = "ALTER TABLE sold_items ADD fop int(11) NOT NULL DEFAULT '0'";
@mysqli_query($rs_connect, $cf);
}

$sqlcheckfop2 = "SELECT fop FROM sold_items";
$check2 = mysqli_query($rs_connect, $sqlcheckfop2);

if($check2) {
$fopq = "SELECT sold_id,ourprice,quantity FROM sold_items WHERE fop = '0' AND sold_type = 'purchase' AND stockid != 0 AND quantity > '1'";
$rs_result_fopqq = mysqli_query($rs_connect, $fopq);
while($rs_result_tq = mysqli_fetch_object($rs_result_fopqq)) {
$rs_fopsold_id = "$rs_result_tq->sold_id";
$rs_fopourprice = "$rs_result_tq->ourprice";
$rs_fopquantity = "$rs_result_tq->quantity";

$nop = $rs_fopourprice * $rs_fopquantity;

$ffop = "UPDATE sold_items SET ourprice = '$nop', fop = '1' WHERE sold_id = '$rs_fopsold_id'";
@mysqli_query($rs_connect, $ffop);

}
}
#



if ($gomodal == 1) {
$therel = "rel=facebox";
} else {
$therel = "";
}

echo "<table style=\"width:100%;background:#ffffff;\"><tr><td style=\"width:200px;vertical-align:middle;text-align:center\"><img src=$logo style=\"height:40px\"></td><td style=\"padding-left:20px;\">";

$mastertaxtotals = array();

#####

echo "<div class=\"nvmbar radiusall\"  id=newinvoicearea>";


echo "</div><br>";
####

echo "</td></tr></table>";



##########################################################################
# Start of Cart
##########################################################################


###################
# Cart Area
echo "<table style=\"width:100%;\"><tr><td style=\"width:200px;vertical-align:top;\">";
start_box_cb("eeeeee");
echo "<div id=customerarea></div>";
echo "<table>";
echo "<tr><td colspan=2><form action=cart.php?func=pickcustomer method=post>";
echo "<input type=text class=textboxw name=searchtext id=csearchbox autocomplete=no placeholder=\"".pcrtlang("Search Customer")."\"style=\"width:100%;box-sizing:border-box;\"></td><td>";
echo "<button type=submit class=button><i class=\"fa fa-search\"></i></button></form>";
echo "</td></tr><tr><td colspan=3>";

echo "<div id=themain></div>";

echo "</td></tr></table>";
stop_box();

echo "</td><td style=\"vertical-align:top;padding-left:20px;\">";

echo "<div id=cartarea>";
echo "<table class=\"pointofsale lastalignright3\">";
echo "<tr><th colspan=5>".pcrtlang("Items")."<span class=floatright>";
echo "</span></th></tr>";
echo "<tr><td width=20%>&nbsp;</td><td width=50% colspan=4 style=\"text-align:left;\"><span class=\"italme colormegray\">".pcrtlang("No Purchase Items")."</span></td></tr>";
echo "<tr><th colspan=5>".pcrtlang("Labor")."</th></tr>";
echo "<tr><td width=20%>&nbsp;</td><td width=80% colspan=4 style=\"text-align:left;\"><span class=\"italme colormegray\">".pcrtlang("No Labor Items")."</span></td></tr>";
echo "<tr><th colspan=5>".pcrtlang("Returned Items")."</th></tr>";
echo "<tr><td width=20%>&nbsp;</td><td width=80% colspan=4 style=\"text-align:left;\"><span class=\"italme colormegray\">".pcrtlang("No Return Items")."</span></td></tr>";
echo "<tr><th colspan=5>".pcrtlang("Refunded Labor")."</th></tr>";
echo "<tr><td width=20%>&nbsp;</td><td width=80% colspan=4 style=\"text-align:left;\"><span class=\"italme colormegray\">".pcrtlang("No Labor Refunds")."</span></td></tr>";
echo "</table><br>";
echo "</div>";

?>
<script type="text/javascript">
$(document).ready(function () {
                $.get('cart.php?func=cartarea', function(data) {
                $('#cartarea').html(data);
                });
});
</script>
<?php

echo "</td></tr></table>";

########################################################
# End of Cart
########################################################

echo "<table width=100%><tr>";

#<td width=40% style=\"padding:2px;\" valign=top>";



#############################################
# Current Customer Area
###############################################


#echo "<div id=customerarea></div>";

?>
<script type="text/javascript">
$(document).ready(function () {
                $.get('cart.php?func=customerarea', function(data) {
                $('#customerarea').html(data);
                });
});
</script>
<?php

########################################
# End Current Customer Area
########################################



echo "<td width=60% valign=top style=\"padding:2px;\" >";

start_moneybox();

#echo "<span class=\"sizemelarge colormemoney boldme\">&nbsp;".pcrtlang("Add Payment")."&nbsp;</span><br><br>";


####################################
# Payment Method Area
####################################

echo "<div id=paymentmethodsarea></div>";

?>
<script type="text/javascript">
$(document).ready(function () {
                $.get('cart.php?func=paymentmethodsarea', function(data) {
                $('#paymentmethodsarea').html(data);
                });
});
</script>
<?php

#############################################################
# End Payment Method Area
#########################################################

stop_box();

echo "</td><td width=40% valign=top style=\"padding:2px;\" >";

start_moneybox();

############################################################
# Payments Area
#############################################################

echo "<div id=paymentsarea></div>";

?>
<script type="text/javascript">
$(document).ready(function () {
                $.get('cart.php?func=paymentsarea', function(data) {
                $('#paymentsarea').html(data);
                });
});
</script>
<?php

stop_box();

#################################################################
# End Payments Area
#################################################################


echo "</td></tr></table>";


echo "<div id=newinvoiceareaold></div>";

?>
<script type="text/javascript">
$(document).ready(function () {
                $.get('cart.php?func=newinvoicearea', function(data) {
                $('#newinvoicearea').html(data);
                });
});
</script>
<?php


##


?>
<script type="text/javascript">
$(document).ready(function(){
  var globalTimeoutrs = null;
  $("input#csearchbox").keyup(function(){
                        if (globalTimeoutrs != null) {
                        clearTimeout(globalTimeoutrs);
                        }
                        var encodedinv = encodeURIComponent(this.value);
                        var searchlength = this.value.length;
                        globalTimeoutrs = setTimeout(function() {
                        globalTimeoutrs = null;
                                if(searchlength<3) {
                                        $("div#themain").slideUp(200,function(){
                                        return false;
                                        });

                                }else{
                                        $('div#themain').load('cart.php?func=pickcustomerajax&search='+encodedinv).slideDown(200);
                                }
                        }, 500);
  });
});
</script>

<?php

#bar code

echo "<div id=bottomnavbarfixedlight></div>";

?>
<script type="text/javascript">
$(document).ready(function () {
                $.get('cart.php?func=cartfloaterarea', function(data) {
                $('#bottomnavbarfixedlight').html(data);
                });
});
</script>


<?php


require_once("footer.php");
                                                                                                    
}


function add_item() {
require_once("validate.php");
$stockid = $_REQUEST['stockid'];

require("deps.php");
require("common.php");


if (array_key_exists('qty', $_REQUEST)) {
$qty = $_REQUEST['qty'];
if (!ii($qty)) {
die(pcrtlang("Please enter a whole number"." $qty"));
}
} else {
$qty = 1;
}


if ($stockid == "") {
die("Error - no stock id entered");
}


$stockids = explode(" ", $stockid);

$usertaxid = getusertaxid();
$salestaxrate = getsalestaxrate($usertaxid);

reset($stockids);
foreach($stockids as $key => $stocktoadd) {

$stockidsize = mb_strlen($stocktoadd);




if ($stockidsize < 11) {
$rs_insert_stock = "SELECT * FROM stock WHERE stock_id = '$stocktoadd'";
} else {
$rs_insert_stock = "SELECT * FROM stock WHERE stock_upc = '$stocktoadd'";
}

$rs_find_stock_price = @mysqli_query($rs_connect, $rs_insert_stock);

if(mysqli_num_rows($rs_find_stock_price) == "0") {
die(pcrtlang("Sorry, that stock ID or UPC code does not exist"));
}

while($rs_find_result_q = mysqli_fetch_object($rs_find_stock_price)) {
$rs_price = "$rs_find_result_q->stock_price";
$rs_stockid = "$rs_find_result_q->stock_id";

$rs_find_serial = "SELECT * FROM inventory WHERE stock_id = '$rs_stockid' AND itemserial != ''";
$rs_find_serial_q = @mysqli_query($rs_connect, $rs_find_serial);
if(mysqli_num_rows($rs_find_serial_q) > 0) {
break 2;
}


$ourprice = getourprice($rs_stockid) * $qty;
$total_price = $rs_price * $qty;
$itemtax = $total_price * $salestaxrate;
$addtime = time();
$rs_insert_cart = "INSERT INTO cart (cart_price,cart_type,cart_stock_id,ipofpc,taxex,itemtax,ourprice,addtime,quantity,unit_price) VALUES  ('$total_price','purchase','$rs_stockid','$ipofpc','$usertaxid','$itemtax','$ourprice','$addtime','$qty','$rs_price')";
@mysqli_query($rs_connect, $rs_insert_cart);
}
}                                                                                                                                               

if(mysqli_num_rows($rs_find_serial_q) > 0) {                                                                                                                                               
header("Location: cart.php?func=addbyserial&stockid=$rs_stockid");
} else {
header("Location: cart.php");
}

}


function addbyserial() {
require_once("validate.php");

require("deps.php");
require("common.php");

require_once("header.php");

start_blue_box(pcrtlang("Enter Serial/Code?"));


$stockid = $_REQUEST['stockid'];




$availser = available_serials($stockid);

echo "<form action=cart.php?func=addbyserial2 method=post><table>";

if(count($availser) != 0) {
echo "<tr><td>".pcrtlang("Pick Serial").":</td>";
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
echo "<td><input type=text cols=30 name=itemserial id=itemserial class=textbox><input type=hidden name=stockid value=\"$stockid\"></td></tr>";

echo "<tr><td><input type=submit value=\"".pcrtlang("Add to Cart")."\" class=button onclick=\"this.disabled=true;this.value='".pcrtlang("Adding to Cart")."...'; this.form.submit();\"></form></td><td></td></tr>";

echo "</table>";


stop_blue_box();
require_once("footer.php");

}


function add_noninv() {
require_once("validate.php");

require("deps.php");
require("common.php");

$itemdesc = pv($_REQUEST['itemdesc']);
$stock_pdesc = pv($_REQUEST['stock_pdesc']);
$unit_price = $_REQUEST['itemprice'];
$ourprice2 = $_REQUEST['ourprice'];
$itemserial = pv(trim($_REQUEST['itemserial']));

$usertaxid = getusertaxid();
$salestaxrate = getsalestaxrate($usertaxid);

if (array_key_exists('qty', $_REQUEST)) {
$qty2 = $_REQUEST['qty'];
if(($qty2 > 1) && ($itemserial != "")) {
$qty = 1;
} else {
$qty = $qty2;
}
} else {
$qty = 1;
}

$itemprice = $unit_price * $qty;

$itemtax = $itemprice * $salestaxrate;

$ourprice = $ourprice2 * $qty;

$addtime = time();
$rs_insert_cart = "INSERT INTO cart (cart_price,cart_type,cart_stock_id,labor_desc,ipofpc,taxex,itemtax,ourprice,itemserial,addtime,quantity,unit_price,printdesc) VALUES  ('$itemprice','purchase','0','$itemdesc','$ipofpc','$usertaxid','$itemtax','$ourprice','$itemserial','$addtime','$qty','$unit_price','$stock_pdesc')";
@mysqli_query($rs_connect, $rs_insert_cart);

header("Location: cart.php");
}


function addbyserial2() {
require_once("validate.php");
$stockid = $_REQUEST['stockid'];
$itemserial = $_REQUEST['itemserial'];

require("deps.php");
require("common.php");

if ($stockid == "") {
die("Error - stock id missing");
}

$usertaxid = getusertaxid();
$salestaxrate = getsalestaxrate($usertaxid);

$availser = available_serials($stockid);
$availserl = array_map('strtolower', $availser);
if(in_array(strtolower("$itemserial"), $availserl) && !in_array("$itemserial", $availser)) {
$key = array_search(strtolower("$itemserial"), $availserl);
$itemserial = $availser[$key];
}


$rs_insert_stock = "SELECT * FROM stock WHERE stock_id = '$stockid'";

$rs_find_stock_price = @mysqli_query($rs_connect, $rs_insert_stock);

while($rs_find_result_q = mysqli_fetch_object($rs_find_stock_price)) {
$rs_price = "$rs_find_result_q->stock_price";
$rs_stockid = "$rs_find_result_q->stock_id";
$rs_stockpdesc = "$rs_find_result_q->stock_pdesc";

$ourprice = getourprice($rs_stockid);

$itemtax = $rs_price * $salestaxrate;
$addtime = time();
$rs_insert_cart = "INSERT INTO cart (cart_price,cart_type,cart_stock_id,ipofpc,taxex,itemtax,ourprice,itemserial,addtime,quantity,unit_price,printdesc) VALUES  ('$rs_price','purchase','$rs_stockid','$ipofpc','$usertaxid','$itemtax','$ourprice','$itemserial','$addtime','1','$rs_price','$rs_stockpdesc')";
@mysqli_query($rs_connect, $rs_insert_cart);
}

header("Location: cart.php");

}



function add_labor() {

require("deps.php");

require_once("common.php");

if($gomodal != "1") {
require("header.php");
}

if($gomodal != "1") {
start_blue_box(pcrtlang("Add Labor Charge to Current Cart"));
} else {
echo "<h4>".pcrtlang("Add Labor Charge to Current Cart")."</h4>";
}

echo "<table width=100%><tr><td width=50% style=\"vertical-align:top;\">";
echo "<form action=cart.php?func=add_labor2 method=post>";
echo pcrtlang("Labor Quantity")."<br><input type=number value=1 min=\".01\" step=\".01\" name=qty class=textbox><br><br>";
echo pcrtlang("Labor Charge")."<br>";

$usertaxid = getusertaxid();
$servicetaxrateremain = (1 + getservicetaxrate($usertaxid));

echo "$money<input autofocus type=text class=textbox name=laborprice id=laborprice>";

if($servicetaxrateremain != 1) {
echo "<button class=button type=button onclick='document.getElementById(\"laborprice\").value=(document.getElementById(\"laborprice\").value / $servicetaxrateremain).toFixed(5);this.disabled=true;'>
<i class=\"fa fa-calculator\"></i> ".pcrtlang("Pre-tax")."</button>";
}


echo "<br><br>".pcrtlang("Labor Title").":<br><input type=text class=textbox size=40 name=labordesc id=labordesc><br><br>";



echo "".pcrtlang("Printed Labor Description")." (".pcrtlang("optional")."):<br><textarea class=textbox cols=60 name=laborpdesc id=laborpdesc></textarea><br><br>";
echo "<input type=submit class=button value=\"".pcrtlang("Add to Cart")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Adding to Cart")."...'; this.form.submit();\"></form>";

echo "</td><td width=50%>";
echo "<table><tr><td colspan=2><span class=\"sizeme16 boldme\">".pcrtlang("Quick Add Labor")."</span></td></tr>";
$rs_quicklabor = "SELECT * FROM quicklabor ORDER BY theorder DESC";
$rs_result_ql  = mysqli_query($rs_connect, $rs_quicklabor);
while($rs_result_qld = mysqli_fetch_object($rs_result_ql)) {
$labordesc = "$rs_result_qld->labordesc";
$laborprice = "$rs_result_qld->laborprice";
$printdesc = "$rs_result_qld->printdesc";

$printdesc2 = urlencode("$printdesc");

$primero = mb_substr("$labordesc", 0, 1);
if("$primero" != "-") {
$labordesc2 = urlencode("$labordesc");
echo "<tr><td><form class=quicklaborfill>
<input type=hidden name=labordesc value=\"".pf("$labordesc")."\">
<input type=hidden name=laborprice value=\"".pf(mf("$laborprice"))."\">
<input type=hidden name=laborpdesc value=\"".pf("$printdesc")."\">
<button type=\"submit\" style=\"width:75px\" class=\"linkbuttonsmall linkbuttongray radiusall displayblock\">$money".mf("$laborprice")."</button></form>
</td><td><span class=\"boldme\">$labordesc</span></td></tr>";
} else {
$labordesc3 = mb_substr("$labordesc", 1);
echo "<tr><td colspan=2><span class=\"linkbuttonsmall linkbuttongraylabel radiusall\">$labordesc3</span></td></tr>";
}

}

echo "</table>";

?>

<script>

$('.quicklaborfill').submit(function(e){
    e.preventDefault();
    var ql_labordesc = $(this).find('input[name="labordesc"]').val();
    var ql_laborprice = $(this).find('input[name="laborprice"]').val();
    var ql_laborpdesc = $(this).find('input[name="laborpdesc"]').val();
    $("#labordesc").val(ql_labordesc);
    $("#laborprice").val(ql_laborprice);
    $("#laborpdesc").val(ql_laborpdesc);
});


</script>

<?php


echo "</td></tr></table>";

if($gomodal != 1) {
stop_blue_box();
}

if($gomodal != 1) {
require_once("footer.php");
}

}

function add_noninv2() {

require("deps.php");

require_once("common.php");
if($gomodal != "1") {
require("header.php");
}

if($gomodal != "1") {
start_blue_box(pcrtlang("Add Non-Inventoried Item"));
} else {
echo "<h4>".pcrtlang("Add Non-Inventoried Item")."</h4><br><br>";
}

echo "<table><tr><td>";
echo "<form action=cart.php?func=add_noninv name=newinv method=post>";
echo pcrtlang("Qty").":<br><input type=number class=textboxw name=qty value=1 min=\"1\" step=\"1\" style=\"width:40px;\"><br><br>";

$usertaxid = getusertaxid();
$salestaxrateremain = (1 + getsalestaxrate($usertaxid));

echo pcrtlang("Price").":<br>";
echo "$money<input autofocus type=text class=textbox name=itemprice id=itemprice>";

if($salestaxrateremain != 1) {
echo "<button id=pretax class=button type=button onclick='document.getElementById(\"itemprice\").value=(document.getElementById(\"itemprice\").value / $salestaxrateremain).toFixed(5);this.disabled=true;'>
<i class=\"fa fa-calculator\"></i> ".pcrtlang("Pre-tax")."</button>";
}

echo "<br><br>";
echo pcrtlang("Our Unit Cost").":<br>";
echo "$money<input type=text class=textbox name=ourprice value=\"0.00\"><br><br>";

?>
<script>
function markup() {
var marknum = Math.ceil((document.newinv.ourprice.value - 0) * (document.newinv.chooser.value - 0)) - document.newinv.cents.value;
document.newinv.itemprice.value = marknum.toFixed(2);
}
</script>
<?php

echo pcrtlang("Markup").": ";
echo "<select name=chooser onChange=\"markup()\">
<option value=\"1.0\"></option>
<option value=\"1.04\">4%</option>
<option value=\"1.1\">10%</option>
<option value=\"1.2\">20%</option>
<option value=\"1.3\">30%</option>
<option value=\"1.4\">40%</option>
<option value=\"1.5\">50%</option>
<option value=\"1.75\">75%</option>
<option value=\"2\">2X</option>
<option value=\"3\">3X</option>
<option value=\"5\">5X</option>
<option value=\"10\">10X</option>
</select>";

echo "<select name=cents onChange=\"markup()\">
<option value=\"0.10\">90 ".pcrtlang("cents")."</option>
<option value=\"0.05\">95 ".pcrtlang("cents")."</option>
<option value=\"0.01\">99 ".pcrtlang("cents")."</option>
<option value=\"00\">00 ".pcrtlang("cents")."</option>
</select><br><br>";



echo pcrtlang("Product Name").":<br><input type=text class=textbox size=40 name=itemdesc id=ni_title><br><br>";
echo pcrtlang("Printed Description").":<br><textarea class=textbox name=stock_pdesc cols=60 id=ni_pdesc></textarea><br><br>";
echo pcrtlang("Item Serial/Code").": <span class=\"sizemesmaller italme\">(".pcrtlang("optional").")</span><br><input type=text class=textbox size=40 name=itemserial><br><br>";
echo "<input type=submit class=button value=\"".pcrtlang("Add to Cart")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Adding to Cart")."...'; this.form.submit();\"></form>";

echo "</td><td style=\"vertical-align:top;\">";

$rs_qni = "SELECT * FROM stocknoninv ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_qni);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$niid = "$rs_result_q1->niid";
$ni_title = "$rs_result_q1->ni_title";
$ni_price = "$rs_result_q1->ni_price";
$theorder = "$rs_result_q1->theorder";
$ni_pdesc = "$rs_result_q1->ni_pdesc";

$primero = mb_substr("$ni_title", 0, 1);

if("$primero" != "-") {
echo "<form class=noninvitem>
<input type=hidden name=ni_title value=\"".pf("$ni_title")."\">
<input type=hidden name=ni_price value=\"".pf(mf("$ni_price"))."\">
<input type=hidden name=ni_pdesc value=\"".pf("$ni_pdesc")."\">
<button type=\"submit\" class=\"linkbuttonsmall linkbuttongray radiusall\">$money".mf("$ni_price")." $ni_title</button></form>";

} else {
$ni_title = mb_substr("$ni_title", 1);
echo "<br><span class=\"sizemelarger boldme\">$ni_title</span><br>";
}

}

?>
<script>

$('.noninvitem').submit(function(e){
    e.preventDefault();
    var ni_title = $(this).find('input[name="ni_title"]').val();
    var ni_price = $(this).find('input[name="ni_price"]').val();
    var ni_pdesc = $(this).find('input[name="ni_pdesc"]').val();
    $("#ni_title").val(ni_title);
    $("#itemprice").val(ni_price);
    $("#ni_pdesc").val(ni_pdesc);
    $("#pretax").prop('disabled', false);
});


</script>

<?php


echo "</td></tr></table>";

if($gomodal != 1) {
stop_blue_box();
}

if($gomodal != 1) {
require_once("footer.php");
}

}



function add_labor2() {
require_once("validate.php");

require("deps.php");
require("common.php");

$laborunitprice = $_REQUEST['laborprice'];
$labordesc = pv($_REQUEST['labordesc']);
$laborpdesc = pv($_REQUEST['laborpdesc']);


if (array_key_exists('qty', $_REQUEST)) {
$qty = $_REQUEST['qty'];
} else {
$qty = 1;
}
                                                                                                                                
$usertaxid = getusertaxid();
$servicetaxrate = getservicetaxrate($usertaxid);


$laborprice = $laborunitprice * $qty;
$servicetax = $laborprice * $servicetaxrate;

$labordescins = pv($labordesc);
$addtime = time();
$rs_insert_cart = "INSERT INTO cart (cart_price,cart_type,labor_desc,ipofpc,taxex,itemtax,addtime,unit_price,quantity,printdesc) VALUES  ('$laborprice','labor','$labordescins','$ipofpc','$usertaxid','$servicetax','$addtime','$laborunitprice','$qty','$laborpdesc')";
@mysqli_query($rs_connect, $rs_insert_cart);
                                                                                                                                               
header("Location: cart.php");
                                                                                                                                               
}


function remove_cart_item() {
require_once("validate.php");                    
$cart_item_id = $_REQUEST['cart_item_id'];
                                                                                                                           
require("deps.php");
require("common.php");
                                                                                                                                               


                                                                                                                                         
                                                                                                                                               
$rs_delete_cart = "DELETE FROM cart WHERE cart_item_id = '$cart_item_id'";
@mysqli_query($rs_connect, $rs_delete_cart);

if (array_key_exists('rs_return_sold_id', $_REQUEST)) {
$rs_return_sold_id = $_REQUEST['rs_return_sold_id'];                                           
$rs_reset_flag = "UPDATE sold_items SET return_flag = '' WHERE sold_id = '$rs_return_sold_id'";
@mysqli_query($rs_connect, $rs_reset_flag);
}
                                                                                                    
header("Location: cart.php");
                                                                                                                                               
}

function empty_cart() {
require_once("validate.php");
require("deps.php");
require("common.php");
                                                                                                                                               


                              
                                                                                                                                               
$rs_delete_cart = "DELETE FROM cart WHERE ipofpc = '$ipofpc'";
@mysqli_query($rs_connect, $rs_delete_cart);
                                          
$rs_reset_flag = "UPDATE sold_items SET return_flag = ''";
@mysqli_query($rs_connect, $rs_reset_flag);

$rs_clear_cust = "DELETE FROM currentcustomer WHERE byuser = '$ipofpc'";
@mysqli_query($rs_connect, $rs_clear_cust);         
                                                                                            
header("Location: cart.php");
                                                                                                                                               
}

function add_return() {
require_once("validate.php");

require("deps.php");
require("common.php");

$item = $_REQUEST['item'];
$receipt = $_REQUEST['receipt'];
$price = $_REQUEST['price'];
$stocktitle = pv($_REQUEST['stocktitle']);
$stockid = $_REQUEST['stockid'];
$rs_taxex = $_REQUEST['taxex'];
$itemserial = $_REQUEST['citemserial'];
$ourprice = $_REQUEST['courprice'];
$returnfee = $_REQUEST['returnfee'];
$cquantity = $_REQUEST['cquantity'];                                                                                                                             
$cunitprice = $_REQUEST['cunitprice'];
$quantity = $_REQUEST['quantity'];

if (array_key_exists('cfirstname',$_REQUEST)) {
$custname =  pv($_REQUEST['cfirstname']);
} else {
$custname = "";
}

if (array_key_exists('ccompany',$_REQUEST)) {
$ccompany =  pv($_REQUEST['ccompany']);
} else {
$ccompany = "";
}


if (array_key_exists('caddress',$_REQUEST)) {
$custaddy1 =  pv($_REQUEST['caddress']);
} else {
$custaddy1 = "";
}

if (array_key_exists('caddress2',$_REQUEST)) {
$custaddy2 =  pv($_REQUEST['caddress2']);
} else {
$custaddy2 = "";
}

if (array_key_exists('ccity',$_REQUEST)) {
$custcity =  pv($_REQUEST['ccity']);
} else {
$custcity = "";
}

if (array_key_exists('cstate',$_REQUEST)) {
$custstate =  pv($_REQUEST['cstate']);
} else {
$custstate = "";
}

if (array_key_exists('czip',$_REQUEST)) {
$custzip =  pv($_REQUEST['czip']);
} else {
$custzip = "";
}

if (array_key_exists('cphone',$_REQUEST)) {
$custphone =  pv($_REQUEST['cphone']);
} else {
$custphone = "";
}

if (array_key_exists('cemail',$_REQUEST)) {
$custemail =  pv($_REQUEST['cemail']);
} else {
$custemail = "";
}


$rs_clear_cust = "DELETE FROM currentcustomer WHERE byuser = '$ipofpc'";
@mysqli_query($rs_connect, $rs_clear_cust);

$rs_insert_cust = "INSERT INTO currentcustomer (cfirstname,ccompany,caddress,caddress2,ccity,cstate,czip,cphone,cemail,byuser) VALUES ('$custname','$ccompany','$custaddy1','$custaddy2','$custcity','$custstate','$custzip','$custphone','$custemail','$ipofpc')";
@mysqli_query($rs_connect, $rs_insert_cust);


$returnfee2 = (1 - ($returnfee * .01));

$price2 = ($cunitprice * $returnfee2 * $quantity);

$salestaxrate = getsalestaxrate($rs_taxex);

$unit_price = $cunitprice * $returnfee2;

$itemtax = $price2 * $salestaxrate;

$addtime = time();
$rs_insert_return = "INSERT INTO cart (cart_price,cart_type,cart_stock_id,labor_desc,return_sold_id,restocking_fee,ipofpc,taxex,itemtax,ourprice,itemserial,addtime,unit_price,quantity) VALUES  ('$price2','refund','$stockid','$stocktitle','$item','$returnfee','$ipofpc','$rs_taxex','$itemtax','$ourprice','$itemserial','$addtime','$unit_price','$quantity')";
@mysqli_query($rs_connect, $rs_insert_return);

$rs_flag_return = "UPDATE sold_items SET return_flag = 'flagged' WHERE sold_id = '$item'";
@mysqli_query($rs_connect, $rs_flag_return);
                                                                                                                                               
header("Location: receipt.php?func=show_receipt&receipt=$receipt");
}




function show_quote() {
require_once("validate.php");
require("deps.php");
include("common.php");
echo "<html><head><title>".pcrtlang("Estimate")."</title>";

echo "<style>";
echo ".textboxt {font-size: 14px; padding: 3px; font-weight: bold; background-color: #ffffff; border: .5px solid #eeeeee;}";
echo "</style>";

echo "<style type=\"text/css\">\n<!--\n";

include("../repair/printstyle.css");

echo "\n-->\n</style>\n";


echo "</head><body>";
echo "<table width=100%><tr><td width=55%>";

$storeinfoarray = getstoreinfo($defaultuserstore);


echo "<img src=$printablelogo><br><span class=italme>$servicebyline</span><br><br>";
echo "$storeinfoarray[storename]<br>$storeinfoarray[storeaddy1]";
if ("$storeinfoarray[storeaddy2]" != "") {
echo "<br>$storeinfoarray[storeaddy2]";
}
echo "<br>$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]";
echo "<br><br>".pcrtlang("Phone").": $storeinfoarray[storephone]<br><br>";


echo "<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".pcrtlang("Bill To").":<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=textbox size=40 class=textboxt><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=textbox size=40 class=textboxt><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=textbox size=40 class=textboxt><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=textbox size=40 class=textboxt><br><br>";



echo "<table width=100% border=0 cellspacing=0>";
echo "<tr bgcolor=#4992ff><td colspan=3 width=100%>".pcrtlang("Items")."</td></tr>";

echo "<tr bgcolor=#4992ff><td width=20%>&nbsp;</td><td width=50%>".pcrtlang("Name of Product")."</td><td width=15%>".pcrtlang("Price")."</td></tr>";





$rs_find_cart_items = "SELECT * FROM cart WHERE cart_type = 'purchase' AND ipofpc = '$ipofpc'";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

if (mysqli_num_rows($rs_result) == 0) {
echo "<tr><td width=20%>&nbsp;</td><td width=50%><span class=\"colormegray italme\">".pcrtlang("No Purchase Items")."</span></td><td width=15%>&nbsp;</td></tr>";
}


while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_cart_item_id = "$rs_result_q->cart_item_id";
$rs_cart_price = "$rs_result_q->cart_price";
$rs_stock_id = "$rs_result_q->cart_stock_id";
$rs_noninvdesc = "$rs_result_q->labor_desc";

if ($rs_stock_id != "0") {

$rs_find_item_detail = "SELECT * FROM stock WHERE stock_id = '$rs_stock_id'";
$rs_find_result = mysqli_query($rs_connect, $rs_find_item_detail);
while($rs_find_result_q = mysqli_fetch_object($rs_find_result)) {
$rs_stocktitle = "$rs_find_result_q->stock_title";
echo "<tr><td width=20%>&nbsp;</td><td width=50%>$rs_stocktitle</td>";
echo "<td width=15% align=right>$money".mf("$rs_cart_price")."</td></tr>";
}

} else {
echo "<tr><td width=20%>&nbsp;</td><td width=50%>$rs_noninvdesc</td>";
echo "<td width=15% align=right>$money".mf("$rs_cart_price")."</td></tr>";


}


}


echo "<tr><td width=100% colspan=3>&nbsp;</td></tr>";
echo "<tr bgcolor=#4992ff><td colspan=3>".pcrtlang("Labor")."</td></tr>";
echo "<tr bgcolor=#4992ff><td width=20%>&nbsp;</td><td width=50%>".pcrtlang("Labor Description")."</td><td width=15%>".pcrtlang("Price")."</td></tr>";

$rs_find_cart_labor = "SELECT * FROM cart WHERE cart_type = 'labor' AND ipofpc = '$ipofpc'";
$rs_result_labor = mysqli_query($rs_connect, $rs_find_cart_labor);

if (mysqli_num_rows($rs_result_labor) == 0) {
echo "<tr><td width=20%>&nbsp;</td><td width=50%><span class=\"colormegray italme\">".pcrtlang("No Labor Items")."</span></td><td width=15%>&nbsp;</td></tr>";
}

                                                                                                                                               
while($rs_result_labor_q = mysqli_fetch_object($rs_result_labor)) {
$rs_cart_labor_id = "$rs_result_labor_q->cart_item_id";
$rs_cart_labor_price = "$rs_result_labor_q->cart_price";
$rs_cart_labor_desc = "$rs_result_labor_q->labor_desc";
echo "<tr><td width=20%>&nbsp;</td><td width=50%>$rs_cart_labor_desc</td><td width=15% align=right>$money".mf("$rs_cart_labor_price")."</td></tr>";

}

echo "<tr><td width=20%>&nbsp;</td><td width=50% align=right>&nbsp;</td><td width=15%>&nbsp;</td></tr>";


$usertaxid = getusertaxid();
$salestaxrate = getsalestaxrate($usertaxid);
$servicetaxrate = getservicetaxrate($usertaxid);
$taxname = gettaxname($usertaxid);

                                                                                                                                             

echo "<tr><td width=20%>&nbsp;</td><td width=50% align=right>&nbsp;</td><td width=15%>&nbsp;</td></tr>";

$rs_find_item_total = "SELECT SUM(cart_price) AS total_price_parts FROM cart WHERE cart_type = 'purchase' AND ipofpc = '$ipofpc'";
$rs_find_result_total = mysqli_query($rs_connect, $rs_find_item_total);
                                                                                                                                               
while($rs_find_result_total_q = mysqli_fetch_object($rs_find_result_total)) {
$rs_total_parts = "$rs_find_result_total_q->total_price_parts";

if ($rs_total_parts == "") {
$rs_total_parts = "0.00";
}
                                                                                                                                               
echo "<tr><td width=20%>&nbsp;</td><td width=50% align=right>".pcrtlang("Parts Subtotal").":</td><td width=15% align=right>$money".mf("$rs_total_parts")."</td></tr>";

$rs_find_itemtax_total = "SELECT SUM(itemtax) AS total_tax_parts FROM cart WHERE cart_type = 'purchase' AND ipofpc = '$ipofpc'";
$rs_find_result_taxtotal = mysqli_query($rs_connect, $rs_find_itemtax_total);
while($rs_find_result_taxtotal_q = mysqli_fetch_object($rs_find_result_taxtotal)) {
$rs_total_partstax = "$rs_find_result_taxtotal_q->total_tax_parts";

$salestax = $rs_total_partstax;


if ($salestax > 0) {
echo "<tr><td width=20%>&nbsp;</td><td width=50% align=right>$t_tax:</td><td width=15% align=right>$money".mf("$salestax")."</td></tr>";
}
}

echo "<tr><td width=20%>&nbsp;</td><td width=50% align=right>&nbsp;</td><td width=15%>&nbsp;</td></tr>";

$rs_find_labor_total = "SELECT SUM(cart_price) AS total_labor_price FROM cart WHERE cart_type = 'labor' AND ipofpc = '$ipofpc'";
$rs_find_result_labor_total = mysqli_query($rs_connect, $rs_find_labor_total);
                                                                                                            
                                   
while($rs_find_result_labor_total_q = mysqli_fetch_object($rs_find_result_labor_total)) {
$rs_total_labor = "$rs_find_result_labor_total_q->total_labor_price";

if ($rs_total_labor == "") {
$rs_total_labor = "0.00";
}
                       
                                                                                                                        
                                                                                                                                               
echo "<tr><td width=20%>&nbsp;</td><td width=50% align=right>".pcrtlang("Labor Total").":</td><td width=15% align=right>$money".mf("$rs_total_labor")."</td></tr>";

}


$rs_find_labortax_total = "SELECT SUM(itemtax) AS total_labortax_price FROM cart WHERE cart_type = 'labor' AND ipofpc = '$ipofpc'";
$rs_find_result_taxlabor_total = mysqli_query($rs_connect, $rs_find_labortax_total);
while($rs_find_result_labortax_total_q = mysqli_fetch_object($rs_find_result_taxlabor_total)) {
$rs_total_labortax = "$rs_find_result_labortax_total_q->total_labortax_price";

$servicetax = $rs_total_labortax;

if ($servicetax > 0) {
echo "<tr><td width=20%>&nbsp;</td><td width=50% align=right>$t_tax:</td><td width=15% align=right>$money".mf("$servicetax")."</td></tr>";
}

}

echo "<tr><td width=20%>&nbsp;</td><td width=50% align=right>&nbsp;</td><td width=15%>&nbsp;</td></tr>";
                                                                                                                                               

}
                                                                                                                                               
                                                                                                                                               

$grand_total = ($salestax + $rs_total_parts + $rs_total_labor + $servicetax);


echo "<tr><td width=20%>&nbsp;</td><td width=50% align=right>&nbsp;</td><td width=15%>&nbsp;</td></tr>";

echo "<tr><td width=20%>&nbsp;</td><td width=50% align=right>".pcrtlang("Amount Due").":</td><td width=15% align=right>".mf("$grand_total")."</td></tr>";


echo "<tr><td width=100% colspan=3>";
echo "<center><a href=cart.php>".pcrtlang("Return")."</a></center>";
echo "<br><br><br> ".pcrtlang("Received By").":____________________________________________________________";

echo "</td></tr></table><br><br>";

echo "</body></html>";

                                                                                                    
}


function discount_cart_item() {
require_once("validate.php");
$cart_item_id = $_REQUEST['cart_item_id'];
$rs_dis_percent = $_REQUEST['rs_dis_percent'];
$taxex = $_REQUEST['rs_taxex'];
$carttype = $_REQUEST['carttype'];
$discountname = $_REQUEST['discountname'];


require("deps.php");
require("common.php");


if ($carttype == "labor") {
$itemtax = getservicetaxrate($taxex);
} else {
$itemtax = getsalestaxrate($taxex);
}





$rs_discount_cart3 = "UPDATE cart SET origprice = cart_price, discounttype = 'percent|$rs_dis_percent', discountname = '$discountname' WHERE cart_item_id = '$cart_item_id'";
@mysqli_query($rs_connect, $rs_discount_cart3);


$rs_discount_cart = "UPDATE cart SET cart_price = (cart_price * ((100 - $rs_dis_percent) * .01)) , price_alt = '1' WHERE cart_item_id = '$cart_item_id'";
@mysqli_query($rs_connect, $rs_discount_cart);

$rs_discount_cart3 = "UPDATE cart SET unit_price = (unit_price * ((100 - $rs_dis_percent) * .01)) , price_alt = '1' WHERE cart_item_id = '$cart_item_id'";
@mysqli_query($rs_connect, $rs_discount_cart3);


$rs_discount_cart2 = "UPDATE cart SET itemtax = (cart_price * $itemtax)  WHERE cart_item_id = '$cart_item_id'";
@mysqli_query($rs_connect, $rs_discount_cart2);



header("Location: cart.php");

}



function custom_price() {
require_once("validate.php");
$cart_item_id = $_REQUEST['cart_item_id'];
$unit_price = $_REQUEST['custom_price'];
$taxex = $_REQUEST['rs_taxex'];
$qty = $_REQUEST['qty'];
$discountname = $_REQUEST['discountname'];


require("deps.php");
require("common.php");

$custom_price = $unit_price * $qty;


$carttype = $_REQUEST['carttype'];

if ($carttype == "labor") {
$itemtaxrate = getservicetaxrate($taxex);
} else {
$itemtaxrate = getsalestaxrate($taxex);
}

$itemtax = $custom_price * $itemtaxrate;


$rs_discount_cart2 = "UPDATE cart SET origprice = cart_price, discounttype = 'custom|na', discountname = '$discountname' WHERE cart_item_id = '$cart_item_id'";
@mysqli_query($rs_connect, $rs_discount_cart2);

$rs_discount_cart = "UPDATE cart SET cart_price = '$custom_price', unit_price = '$unit_price', price_alt = '1', itemtax = '$itemtax' WHERE cart_item_id = '$cart_item_id'";
@mysqli_query($rs_connect, $rs_discount_cart);


header("Location: cart.php");

}




function savecart() {
require_once("validate.php");
require("deps.php");
require("common.php");
$cartname = pv($_REQUEST['cartname']);
$cartcheck = $_REQUEST['cartcheck'];


if (array_key_exists('iskit',$_REQUEST)) {
$iskit = $_REQUEST['iskit'];;
} else {
$iskit = 0;
}

$cartcheckv = cartcheck();
if($cartcheck != $cartcheckv) die("Cart has changed <a href=cart.php>Reload Current Cart</a>");

$rs_find_cart_items = "SELECT * FROM cart WHERE ipofpc = '$ipofpc'";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

$rs_rm_cart = "DELETE FROM savedcarts WHERE cartname = '$cartname'";
@mysqli_query($rs_connect, $rs_rm_cart);

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_cart_price = "$rs_result_q->cart_price";
$rs_cart_type = "$rs_result_q->cart_type";
$rs_cart_stock_id = "$rs_result_q->cart_stock_id";
$rs_labor_desc = pv($rs_result_q->labor_desc);
$printdesc = pv($rs_result_q->printdesc);
$rs_return_sold_id = "$rs_result_q->return_sold_id";
$rs_restocking_fee = "$rs_result_q->restocking_fee";
$rs_price_alt = "$rs_result_q->price_alt";
$rs_taxex = "$rs_result_q->taxex";
$rs_itemtax = "$rs_result_q->itemtax";
$rs_origprice = "$rs_result_q->origprice";
$rs_discounttype = "$rs_result_q->discounttype";
$rs_ourprice = "$rs_result_q->ourprice";
$rs_unit_price = "$rs_result_q->unit_price";
$rs_quantity = "$rs_result_q->quantity";


$rs_insert_cart = "INSERT INTO savedcarts (cart_price,cart_type,cart_stock_id,labor_desc,return_sold_id,restocking_fee,price_alt,cartname,savedwhen,taxex,itemtax,origprice,discounttype,ourprice,iskit,unit_price,quantity,printdesc) VALUES  ('$rs_cart_price','$rs_cart_type','$rs_cart_stock_id','$rs_labor_desc','$rs_return_sold_id','$rs_restocking_fee','$rs_price_alt','$cartname','$currentdatetime','$rs_taxex','$rs_itemtax','$rs_origprice','$rs_discounttype','$rs_ourprice','$iskit','$rs_unit_price','$rs_quantity','$printdesc')";
@mysqli_query($rs_connect, $rs_insert_cart);

header("Location: cart.php");

}
}


function show_savecart() {

require_once("header.php");

require("deps.php");

if (array_key_exists('iskit',$_REQUEST)) {
$iskit = $_REQUEST['iskit'];
} else {
$iskit = 0;
}


if($iskit == 0) {
start_blue_box(pcrtlang("Saved Carts"));
} else {
start_blue_box(("Kits"));
}




if($iskit == 0) {
$rs_find_cart_items = "SELECT DISTINCT cartname, savedwhen FROM savedcarts WHERE iskit = '0'";
} else {
$rs_find_cart_items = "SELECT DISTINCT cartname, savedwhen FROM savedcarts WHERE iskit = '1'";
}

$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);
while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_cart_name = "$rs_result_q->cartname";
$rs_saved_when = "$rs_result_q->savedwhen";

$saved = pcrtdate("$pcrt_longdate", "$rs_saved_when").", ".pcrtdate("$pcrt_time", "$rs_saved_when");


start_box();
echo "<table style=\"width:100%\"><tr><td width=50%><span class=\"sizemelarge boldme\">$rs_cart_name</span><br>".pcrtlang("Saved").": $saved</td><td valign=top rowspan=2>&nbsp;&nbsp;&nbsp;&nbsp;</td><td valign=top rowspan=2>";

echo "<table class=standard><tr><th>".pcrtlang("Items")."</th><th>".pcrtlang("Qty")."</th><th>".pcrtlang("Unit Price")."</th>";

echo "<th>";

if($iskit == 0) {
echo pcrtlang("Cart Price");
} else {
echo pcrtlang("Kit Price");
}

echo "</th><th>".pcrtlang("Qty in Stock")."</th><th>".pcrtlang("Inv Price")."</th></tr>";

$rs_find_items = "SELECT * FROM savedcarts WHERE cartname = '$rs_cart_name'";
$rs_find_result = mysqli_query($rs_connect, $rs_find_items);


while($rs_find_result_q = mysqli_fetch_object($rs_find_result)) {
$rs_stock_id = "$rs_find_result_q->cart_stock_id";
$rs_labor = "$rs_find_result_q->labor_desc";
$rs_cartprice = "$rs_find_result_q->cart_price";
$rs_taxex = "$rs_find_result_q->taxex";
$rs_unit_price = "$rs_find_result_q->unit_price";
$rs_quantity = "$rs_find_result_q->quantity";

if ($rs_stock_id == '0') {
echo "<tr><td>$rs_labor</td><td style=\"text-align:right;\">".qf("$rs_quantity")."</td><td style=\"text-align:right;\">$money".mf("$rs_unit_price")."</td><td style=\"text-align:right;\">$money".mf("$rs_cartprice")."</td></tr>";
} else {
$rs_find_item_detail = "SELECT * FROM stock WHERE stock_id = '$rs_stock_id'";
$rs_find_result_detail = mysqli_query($rs_connect, $rs_find_item_detail);

while($rs_find_result_detail_q = mysqli_fetch_object($rs_find_result_detail)) {
$rs_stocktitle = "$rs_find_result_detail_q->stock_title";
$rs_stockprice = "$rs_find_result_detail_q->stock_price";

echo "<tr><td>$rs_stocktitle</td><td style=\"text-align:right;\">".qf("$rs_quantity")."</td><td style=\"text-align:right;\">$money".mf("$rs_unit_price")."</td><td style=\"text-align:right;\">$money".mf("$rs_cartprice")."</td>";

$rs_find_stock = "SELECT * FROM stockcounts WHERE storeid = '$defaultuserstore' AND stockid = '$rs_stock_id'";
$rs_result_stock = mysqli_query($rs_connect, $rs_find_stock);
$rs_result_stockq = mysqli_fetch_object($rs_result_stock);
$stockqty = "$rs_result_stockq->quantity";

echo "<td style=\"text-align:right;\">$stockqty</td>";

if($rs_stockprice != $rs_cartprice) {
echo "<td style=\"text-align:right;\">$money".mf("$rs_stockprice")."";

$salestaxrate = getsalestaxrate($rs_taxex);
$itemtax = $rs_stockprice * $salestaxrate;
$rs_cart_name2 = urlencode("$rs_cart_name");
echo  "<br><a href=cart.php?func=resyncprice&newprice=$rs_stockprice&newtax=$itemtax&iskit=$iskit&cart_stock_id=$rs_stock_id&cartname=$rs_cart_name2 class=smalllink>".pcrtlang("resync price")."</a>";

echo "</td>";
}


echo "</tr>";
}
}
}

$rs_find_totals = "SELECT SUM(cart_price) AS cptotal, SUM(itemtax) AS cptax FROM savedcarts WHERE cartname = '$rs_cart_name'";
$rs_find_result_totals = mysqli_query($rs_connect, $rs_find_totals);
$rs_find_result_tq = mysqli_fetch_object($rs_find_result_totals);
$rs_tprice = "$rs_find_result_tq->cptotal";
$rs_ttax = "$rs_find_result_tq->cptax";

$carttotal = $rs_ttax + $rs_tprice;

echo "<tr><td style=\"text-align:right;\" colspan=3>".pcrtlang("Tax")."</td>
<td style=\"text-align:right;\" colspan=1>$money".mf("$rs_ttax")."</td></tr>";

echo "<tr><td style=\"text-align:right;\" colspan=3>".pcrtlang("Total")."</td>
<td style=\"text-align:right;\" colspan=1>$money".mf("$carttotal")."</td></tr>";

echo "</table>";

echo "</td><tr><td>";
echo "<form action=cart.php?func=loadsavecart method=post><input type=hidden name=cartname value=\"$rs_cart_name\">";
echo "<input class=button type=submit value=\"".pcrtlang("Copy to Cart")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Loading Cart")."...'; this.form.submit();\"></form>";

$rs_cart_name_ue = htmlspecialchars($rs_cart_name, ENT_QUOTES, 'utf-8');

echo "<form action=cart.php?func=del_savecart&iskit=1 method=post><input type=hidden name=cartname value=\"$rs_cart_name_ue\">";
echo "<input class=ibutton type=submit value=\"".pcrtlang("Delete")."\"  onClick=\"return confirm('".pcrtlang("ARE YOUR SURE YOU WANT TO DELETE THIS?")."');\"></form>";

echo "<form action=cart.php?func=copysavecart method=post>".pcrtlang("WO")."#<input type=hidden name=cartname value=\"$rs_cart_name\"><input type=text name=pcwo size=5 class=textbox>";
echo "<input class=button type=submit value=\"".pcrtlang("Copy to Work Order")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Copying")."...'; this.form.submit();\"></form>";
echo "</td></tr></table>";
stop_box();
echo "<br>";
}
stop_blue_box();
require_once("footer.php");



}


function show_savecarts() {


require("deps.php");


if(!isset($_REQUEST['printable'])) {
require_once("header.php");
start_blue_box(pcrtlang("Ready to Sell Systems"));
} else {
require_once("common.php");
printableheader(pcrtlang("Ready to Sell Systems"));
}



if(array_key_exists("mainassettypeid", $_REQUEST)) {
$mainassettypeid = $_REQUEST['mainassettypeid'];
$rs_find_cart_items = "SELECT * FROM pc_wo,pc_owner WHERE pc_wo.pcstatus = '7' AND pc_wo.storeid = '$defaultuserstore' AND pc_owner.mainassettypeid = '$mainassettypeid' AND pc_owner.pcid = pc_wo.pcid ORDER BY pc_wo.dropdate ASC";
$link = "cart.php?func=show_savecarts&printable=1&mainassettypeid=$mainassettypeid";
} else {
$rs_find_cart_items = "SELECT * FROM pc_wo WHERE pcstatus = '7' AND storeid = '$defaultuserstore' ORDER BY dropdate ASC";
$link = "cart.php?func=show_savecarts&printable=1";
}


if(!isset($_REQUEST['printable'])) {
echo "<a href=\"$link\" class=\"linkbuttonmedium linkbuttongray radiusall floatright\"><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Printable Version")."</a><br><br><br>";
}


$ourpricetotal = 0;
$cartsumtotal = 0;


$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);
while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_woid = "$rs_result_q->woid";
$rs_pcid = "$rs_result_q->pcid";
$rs_prob = "$rs_result_q->probdesc";
$rs_dropdate2 = "$rs_result_q->dropdate";

$rs_dropdate = pcrtdate("$pcrt_longdate", "$rs_dropdate2");


$rs_prob2 = nl2br($rs_prob);


$rs_findbill = "SELECT * FROM repaircart WHERE pcwo = '$rs_woid'";
$rs_findbill2 = mysqli_query($rs_connect, $rs_findbill);
$numite = mysqli_num_rows($rs_findbill2);

if($numite != 0) {
$rs_findsum = "SELECT (SUM(cart_price) + SUM(itemtax)) as checkcartsum, SUM(ourprice) AS ourprice FROM repaircart WHERE pcwo = '$rs_woid'";
$rs_findsum2 = @mysqli_query($rs_connect, $rs_findsum);
$rs_findsum3 = mysqli_fetch_object($rs_findsum2);
$cartsum = "$rs_findsum3->checkcartsum";
$ourprice = "$rs_findsum3->ourprice";
} else {
$cartsum = 0;
$ourprice = 0;
}


$ourpricetotal = $ourpricetotal + $ourprice;
$cartsumtotal = $cartsumtotal + $cartsum;

$rs_find_cart_items2 = "SELECT * FROM pc_owner WHERE pcid = '$rs_pcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_find_cart_items2);
while($rs_result_q2 = mysqli_fetch_object($rs_result2)) {
$rs_model = "$rs_result_q2->pcmake";
$mainassettypeidindb = "$rs_result_q2->mainassettypeid";
$pcextra = "$rs_result_q2->pcextra";

$custompcinfoindb = array_filter(serializedarraytest($pcextra));

#$mainassettype = getassettypename($mainassettypeidindb);

$rs_allfindassets = "SELECT * FROM mainassetinfofields";
$rs_result2all = mysqli_query($rs_connect, $rs_allfindassets);
while ($rs_result_q2all = mysqli_fetch_object($rs_result2all)) {
$mainassetfieldid = "$rs_result_q2all->mainassetfieldid";
$mainassetfieldname = "$rs_result_q2all->mainassetfieldname";
$allassetinfofields[$mainassetfieldid] = "$mainassetfieldname";
}






echo "<table class=standard>";

if(!isset($_REQUEST['printable'])) {
echo "<tr><th width=25% valign=top><a href=../repair/index.php?pcwo=$rs_woid class=\"linkbuttonmedium linkbutton radiusall\">";
echo "<i class=\"fa fa-clipboard fa-lg\"></i> $rs_pcid</a>";
echo "</th><th width=50%><span class=sizeme20>$rs_model</span><br>$rs_dropdate</th>";
echo "<th>".pcrtlang("Cart Total").": $money".mf("$cartsum")."<br>".pcrtlang("Cost Price").": $money".mf("$ourprice")."</th>";
echo "</tr>";
echo "<tr><td colspan=3>";
} else {
echo "<tr><th width=15% valign=top>";
echo "<i class=\"fa fa-clipboard fa-lg\"></i> $rs_pcid";
echo "</th><th width=40%><span class=sizeme16>$rs_model</span></th>";
echo "<th>".pcrtlang("Price").": $money".mf("$cartsum")."</th><th>".pcrtlang("Cost").": $money".mf("$ourprice")."</th>";
echo "</tr>";
echo "<tr><td colspan=4>";
}

if(!empty($custompcinfoindb)) {
echo "<table style=\"width:100%;\"><tr><td valign=top>";
$a = 1;
$countitems = ceil((count($custompcinfoindb) / 3));

foreach($custompcinfoindb as $key => $val) {
if(array_key_exists("$key", $allassetinfofields)) {
echo "<p style=\"margin:0px 0px 3px 0px; border:1px #cccccc solid; background:#eeeeee; padding:1px 10px 1px 10px; border-radius:3px;\">$allassetinfofields[$key]: <br>$val</p>";
}

if(($a % $countitems) == 0) {
echo "</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td valign=top>";
}

$a++;
}

echo "</td></tr></table>";
}




echo "</td></tr></table>";

echo "<br>";
}
}


echo "<br><span class=sizeme20>".pcrtlang("Cart Totals").": $money".mf("$cartsumtotal")."<br><br>".pcrtlang("Cost Price Total").": $money".mf("$ourpricetotal")."</span>";

if(!isset($_REQUEST['printable'])) {
stop_blue_box();
require_once("footer.php");
} else {
printablefooter();
}


}



function show_repcart() {

require_once("header.php");

require("deps.php");

start_blue_box(pcrtlang("Active Repair Carts"));

$rs_find_cart_items = "SELECT * FROM pc_wo WHERE pcstatus < '5'";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);
while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_pcid = "$rs_result_q->pcid";
$rs_woid = "$rs_result_q->woid";

$rs_find_owner = "SELECT pcname FROM pc_owner WHERE pcid = '$rs_pcid'";
$rs_result_o = mysqli_query($rs_connect, $rs_find_owner);
while($rs_result_qo = mysqli_fetch_object($rs_result_o)) {
$rs_owner_name = "$rs_result_qo->pcname";



$rs_find_items = "SELECT * FROM repaircart WHERE pcwo = '$rs_woid'";
$rs_find_result = mysqli_query($rs_connect, $rs_find_items);

$itemsfound = mysqli_num_rows($rs_find_result);


if ($itemsfound > 0) {

start_box();
echo "<table width=100%><tr><td width=50%>$rs_owner_name<br></td><td valign=top rowspan=2>".pcrtlang("Items").":<br>";

while($rs_find_result_q = mysqli_fetch_object($rs_find_result)) {
$rs_stock_id = "$rs_find_result_q->cart_stock_id";
$rs_price = "$rs_find_result_q->cart_price";


if ($rs_stock_id == '0') {
echo "<li><span class=\"sizemesmaller\"> ".pcrtlang("Labor")." - $money".mf("$rs_price")."</span></li>";
} else {
$rs_find_item_detail = "SELECT * FROM stock WHERE stock_id = '$rs_stock_id'";
$rs_find_result_detail = mysqli_query($rs_connect, $rs_find_item_detail);

while($rs_find_result_detail_q = mysqli_fetch_object($rs_find_result_detail)) {
$rs_stocktitle = "$rs_find_result_detail_q->stock_title";

echo "<li><span class=\"sizemesmaller\"> $rs_stocktitle - $money".mf("$rs_price")."</span></li>";
}
}
}

echo "</td><tr><td>";
echo "<form action=../repair/repcart.php?func=loadsavecart method=post><input type=hidden name=pcwo value=\"$rs_woid\">";
echo "<input class=button type=submit value=\"".pcrtlang("Load Cart")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Loading Cart")."...'; this.form.submit();\"></form>";
echo "</td></tr</table>";
stop_box();
echo "<br>";
}
}
}
stop_blue_box();
require_once("footer.php");
}





function del_savecart() {
require_once("validate.php");

require("deps.php");
require("common.php");

$cartname = pv($_REQUEST['cartname']);

$rs_rm_cart = "DELETE FROM savedcarts WHERE cartname = '$cartname'";
@mysqli_query($rs_connect, $rs_rm_cart);

if (array_key_exists('iskit',$_REQUEST)) {
header("Location: cart.php?func=show_savecart&iskit=1");
} else {
header("Location: cart.php?func=show_savecart");
}


}


function loadsavecart() {
require_once("validate.php");

require("deps.php");
require("common.php");

$cartname = $_REQUEST['cartname'];




$rs_find_cart_items = "SELECT * FROM savedcarts WHERE cartname = '$cartname'";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);


while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_cart_price = "$rs_result_q->cart_price";
$rs_cart_type = "$rs_result_q->cart_type";
$rs_cart_stock_id = "$rs_result_q->cart_stock_id";
$rs_labor_desc = pv($rs_result_q->labor_desc);
$printdesc = pv($rs_result_q->printdesc);
$rs_return_sold_id = "$rs_result_q->return_sold_id";
$rs_restocking_fee = "$rs_result_q->restocking_fee";
$rs_price_alt = "$rs_result_q->price_alt";
$rs_taxex = "$rs_result_q->taxex";
$rs_itemtax = "$rs_result_q->itemtax";
$rs_origprice = "$rs_result_q->origprice";
$rs_discounttype = "$rs_result_q->discounttype";
$rs_ourprice = "$rs_result_q->ourprice";
$rs_itemserial = "$rs_result_q->itemserial";
$rs_addtime = "$rs_result_q->addtime";
$rs_unit_price = "$rs_result_q->unit_price";
$rs_quantity = "$rs_result_q->quantity";
$rs_discountname = "$rs_result_q->discountname";

$rs_insert_cart = "INSERT INTO cart (cart_price,cart_type,cart_stock_id,labor_desc,return_sold_id,restocking_fee,price_alt,ipofpc,taxex,itemtax,origprice,discounttype,ourprice,itemserial,addtime,unit_price,quantity,printdesc,discountname) VALUES  ('$rs_cart_price','$rs_cart_type','$rs_cart_stock_id','$rs_labor_desc','$rs_return_sold_id','$rs_restocking_fee','$rs_price_alt','$ipofpc','$rs_taxex','$rs_itemtax','$rs_origprice','$rs_discounttype','$rs_ourprice','$rs_itemserial','$rs_addtime','$rs_unit_price','$rs_quantity','$printdesc','$rs_discountname')";
@mysqli_query($rs_connect, $rs_insert_cart);
header("Location: cart.php");

}
}


function copysavecart() {

require_once("validate.php");
require("deps.php");
require("common.php");

$cartname = $_REQUEST['cartname'];
$pcwo = $_REQUEST['pcwo'];

$rs_find_cart_items = "SELECT * FROM savedcarts WHERE cartname = '$cartname'";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

@mysqli_query($rs_connect, $rs_rm_cart);


while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_cart_price = "$rs_result_q->cart_price";
$rs_cart_type = "$rs_result_q->cart_type";
$rs_cart_stock_id = "$rs_result_q->cart_stock_id";
$rs_labor_desc = pv($rs_result_q->labor_desc);
$printdesc = pv($rs_result_q->printdesc);
$rs_return_sold_id = "$rs_result_q->return_sold_id";
$rs_restocking_fee = "$rs_result_q->restocking_fee";
$rs_price_alt = "$rs_result_q->price_alt";
$rs_taxex = "$rs_result_q->taxex";
$rs_itemtax = "$rs_result_q->itemtax";
$rs_origprice = "$rs_result_q->origprice";
$rs_discounttype = "$rs_result_q->discounttype";
$rs_ourprice = "$rs_result_q->ourprice";
$rs_itemserial = "$rs_result_q->itemserial";
$rs_addtime = "$rs_result_q->addtime";
$rs_unit_price = "$rs_result_q->unit_price";
$rs_quantity = "$rs_result_q->quantity";
$rs_discountname = "$rs_result_q->discountname";

$rs_insert_cart = "INSERT INTO repaircart (cart_price,cart_type,cart_stock_id,labor_desc,return_sold_id,restocking_fee,price_alt,pcwo,taxex,itemtax,origprice,discounttype,ourprice,itemserial,addtime,unit_price,quantity,printdesc,discountname) VALUES ('$rs_cart_price','$rs_cart_type','$rs_cart_stock_id','$rs_labor_desc','$rs_return_sold_id','$rs_restocking_fee','$rs_price_alt','$pcwo','$rs_taxex','$rs_itemtax','$rs_origprice','$rs_discounttype','$rs_ourprice','$rs_itemserial','$rs_addtime','$rs_unit_price','$rs_quantity','$printdesc','$rs_discountname')";
@mysqli_query($rs_connect, $rs_insert_cart);
header("Location: ../repair/index.php?pcwo=$pcwo");

}
}


function copycurrenttorepaircart() {
require_once("validate.php");

require("deps.php");
require("common.php");

$pcwo = $_REQUEST['pcwo'];

if ($pcwo == 0) {
die("You must choose a repair cart to save to");
}



$rs_find_cart_items = "SELECT * FROM cart WHERE ipofpc = '$ipofpc'";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

@mysqli_query($rs_connect, $rs_rm_cart);


while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_cart_price = "$rs_result_q->cart_price";
$rs_cart_type = "$rs_result_q->cart_type";
$rs_cart_stock_id = "$rs_result_q->cart_stock_id";
$rs_labor_desc = pv($rs_result_q->labor_desc);
$printdesc = pv($rs_result_q->printdesc);
$rs_return_sold_id = "$rs_result_q->return_sold_id";
$rs_restocking_fee = "$rs_result_q->restocking_fee";
$rs_price_alt = "$rs_result_q->price_alt";
$rs_taxex = "$rs_result_q->taxex";
$rs_itemtax = "$rs_result_q->itemtax";
$rs_origprice = "$rs_result_q->origprice";
$rs_discounttype = "$rs_result_q->discounttype";
$rs_ourprice = "$rs_result_q->ourprice";
$rs_itemserial = "$rs_result_q->itemserial";
$rs_unit_price = "$rs_result_q->unit_price";
$rs_quantity = "$rs_result_q->quantity";
$rs_discountname = "$rs_result_q->discountname";

$rs_insert_cart = "INSERT INTO repaircart (cart_price,cart_type,cart_stock_id,labor_desc,return_sold_id,restocking_fee,price_alt,pcwo,taxex,itemtax,origprice,discounttype,ourprice,itemserial,unit_price,quantity,printdesc,discountname) VALUES ('$rs_cart_price','$rs_cart_type','$rs_cart_stock_id','$rs_labor_desc','$rs_return_sold_id','$rs_restocking_fee','$rs_price_alt','$pcwo','$rs_taxex','$rs_itemtax','$rs_origprice','$rs_discounttype','$rs_ourprice','$rs_itemserial','$rs_unit_price','$rs_quantity','$printdesc','$rs_discountname')";
@mysqli_query($rs_connect, $rs_insert_cart);
header("Location: ../repair/index.php?pcwo=$pcwo");
 
}
}




function setusertax() {
require_once("validate.php");
require("deps.php");
require("common.php");

$setusername = "$ipofpc";
$settaxname = $_REQUEST['settaxname'];




$rs_rm_cart = "UPDATE users SET currenttaxid = '$settaxname' WHERE username = '$setusername'";
@mysqli_query($rs_connect, $rs_rm_cart);

header("Location: cart.php");

}


function setitemtax() {
require_once("validate.php");
require("deps.php");
require("common.php");

$settaxid = $_REQUEST['settaxid'];
$cart_item_id = $_REQUEST['cart_item_id'];
$cartitemtype = $_REQUEST['cartitemtype'];

if ($cartitemtype == "labor") {
$taxrate = getservicetaxrate($settaxid);
} else {
$taxrate = getsalestaxrate($settaxid);
}





$rs_rm_cart = "UPDATE cart SET taxex = '$settaxid', itemtax = (cart_price * $taxrate) WHERE ipofpc = '$ipofpc' AND cart_item_id = $cart_item_id";
@mysqli_query($rs_connect, $rs_rm_cart);

header("Location: cart.php");

}



function savecurrentcustomer() {
require_once("validate.php");

require("deps.php");
require("common.php");

$cfirstname = pv($_REQUEST['cfirstname']);
$ccompany = pv($_REQUEST['ccompany']);
$caddress = pv($_REQUEST['caddress']);
$caddress2 = pv($_REQUEST['caddress2']);
$ccity = pv($_REQUEST['ccity']);
$cstate = pv($_REQUEST['cstate']);
$czip = pv($_REQUEST['czip']);
$cphone = pv($_REQUEST['cphone']);
$cemail = pv($_REQUEST['cemail']);
$cwoid = pv($_REQUEST['cwoid']);
$cinvoiceid = pv($_REQUEST['cinvoiceid']);
$crinvoiceid = pv($_REQUEST['crinvoiceid']);
$pcgroupid = pv($_REQUEST['pcgroupid']);




$rs_clear_cust = "DELETE FROM currentcustomer WHERE byuser = '$ipofpc'";
@mysqli_query($rs_connect, $rs_clear_cust);

$rs_insert_cust = "INSERT INTO currentcustomer (cfirstname,ccompany,caddress,caddress2,ccity,cstate,czip,cphone,cemail,woid,invoiceid,rinvoiceid,byuser,pcgroupid) VALUES  ('$cfirstname','$ccompany','$caddress','$caddress2','$ccity','$cstate','$czip','$cphone','$cemail','$cwoid','$cinvoiceid','$crinvoiceid','$ipofpc','$pcgroupid')";
@mysqli_query($rs_connect, $rs_insert_cust);

header("Location: cart.php");

}


function clearcurrentcustomer() {
require_once("validate.php");

require("deps.php");
require("common.php");




$rs_clear_cust = "DELETE FROM currentcustomer WHERE byuser = '$ipofpc'";
@mysqli_query($rs_connect, $rs_clear_cust);

header("Location: cart.php");

}

function removedeposit() {
require_once("validate.php");

require("deps.php");
require("common.php");

$depositid = $_REQUEST['depositid'];




$rs_clear_dep = "DELETE FROM currentpayments WHERE depositid = '$depositid' AND byuser = '$ipofpc'";
@mysqli_query($rs_connect, $rs_clear_dep);

header("Location: cart.php");

}


function pickcustomer() {
require("header.php");
require("deps.php");

$searchtext = $_REQUEST['searchtext'];

if (mb_strlen($searchtext) < 3) {
die("Search term too short");
} 

if (array_key_exists('pickfor',$_REQUEST)) {
$pickfor = $_REQUEST['pickfor'];
} else {
$pickfor = "currentcart";
}





$rs_find_pc = "SELECT DISTINCT pcname,pccompany,pcaddress,pcaddress2,pccity,pcstate,pczip,pcstate,pczip,pcemail,pcphone FROM pc_owner WHERE pcname LIKE '%$searchtext%' OR pccompany LIKE '%$searchtext%'";
$rs_result_item = mysqli_query($rs_connect, $rs_find_pc);

echo "<table><tr><td width=33% valign=top>";

start_blue_box(pcrtlang("Asset/Device Search Results"));

if (mysqli_num_rows($rs_result_item) == "0") {
echo "<br><span class=\"colormegray italme\">".pcrtlang("No Items Found")."...<br><br></span>";
}

while($rs_result_q = mysqli_fetch_object($rs_result_item)) {
$personname = "$rs_result_q->pcname";
$pccompany = "$rs_result_q->pccompany";
$address1 = "$rs_result_q->pcaddress";
$address2 = "$rs_result_q->pcaddress2";
$city = "$rs_result_q->pccity";
$state = "$rs_result_q->pcstate";
$zip = "$rs_result_q->pczip";
$email = "$rs_result_q->pcemail";
$phone = "$rs_result_q->pcphone";

$ue_personname = urlencode($personname);
$ue_pccompany = urlencode($pccompany);
$ue_address1 = urlencode($address1);
$ue_address2 = urlencode($address2);
$ue_city = urlencode($city);
$ue_state = urlencode($state);
$ue_zip = urlencode($zip);
$ue_email = urlencode($email);
$ue_phone = urlencode($phone);

echo "<table class=badge><tr><td>";

echo "<i class=\"fa fa-user fa-lg\"></i> $personname";
if ("$pickfor" == "currentcart") {
echo "<a href=\"cart.php?func=pickcustomer2&personname=$ue_personname&company=$ue_pccompany&address1=$ue_address1&address2=$ue_address2&city=$ue_city&state=$ue_state&zip=$ue_zip&email=$ue_email&phone=$ue_phone\" class=\"linkbuttongray linkbuttonmedium radiusall\" style=\"float:right;\">".pcrtlang("pick")." <i class=\"fa fa-arrow-circle-right fa-lg\"></i></a><br>";
} else {
echo "<a href=\"deposits.php?cfirstname=$ue_personname&ccompany=$ue_pccompany&caddress=$ue_address1&caddress2=$ue_address2&ccity=$ue_city&cstate=$ue_state&czip=$ue_zip&cemail=$ue_email&cphone=$ue_phone\" class=\"linkbuttongray linkbuttonmedium radiusall\" style=\"float:right;\">".pcrtlang("pick")." <i class=\"fa fa-arrow-circle-right fa-lg\"></i></a><br>";
}

if("$pccompany" != "") {
echo "$pccompany<br>";
}

echo "<span class=\"sizemesmaller\">$address1";
if ($address2 != "") {
echo "<br>$address2";
}

if (($city != "") || ($state != "") || ($zip != "")) {
echo "<br>";
}

if ($city != "") {
echo "$city,";
}
if ($state != "") {
echo "$state,";
}
if ($zip != "") {
echo "$zip";
}

echo "</span>";


echo "</td></tr></table>";


}
stop_blue_box();

echo "</td><td width=2%><td><td width=33% valign=top>";

start_blue_box(pcrtlang("Group Search Results"));

$rs_findgrp = "SELECT * FROM pc_group WHERE pcgroupname LIKE '%$searchtext%' OR grpcompany LIKE '%$searchtext%'";
$rs_resultgrp = mysqli_query($rs_connect, $rs_findgrp);

if (mysqli_num_rows($rs_resultgrp) == "0") {
echo "<br><span class=\"colormegray italme\">".pcrtlang("No Groups Found")."...<br><br></span>";
}

while ($rs_result_grpq = mysqli_fetch_object($rs_resultgrp)) {
$groupid = "$rs_result_grpq->pcgroupid";
$personname = "$rs_result_grpq->pcgroupname";
$grpcompany = "$rs_result_grpq->grpcompany";
$address1 = "$rs_result_grpq->grpaddress1";
$address2 = "$rs_result_grpq->grpaddress2";
$city = "$rs_result_grpq->grpcity";
$state = "$rs_result_grpq->grpstate";
$zip = "$rs_result_grpq->grpzip";
$email = "$rs_result_grpq->grpemail";
$phone = "$rs_result_grpq->grpphone";

$ue_personname = urlencode($personname);
$ue_grpcompany = urlencode($grpcompany);
$ue_address1 = urlencode($address1);
$ue_address2 = urlencode($address2);
$ue_city = urlencode($city);
$ue_state = urlencode($state);
$ue_zip = urlencode($zip);
$ue_email = urlencode($email);
$ue_phone = urlencode($phone);

echo "<table class=badge><tr><td>";
echo "<i class=\"fa fa-group fa-lg\"></i> $personname";
if ("$pickfor" == "currentcart") {
echo "<a href=\"cart.php?func=pickcustomer2&personname=$ue_personname&company=$ue_grpcompany&address1=$ue_address1&address2=$ue_address2&city=$ue_city&state=$ue_state&zip=$ue_zip&email=$ue_email&phone=$ue_phone&pcgroupid=$groupid\" style=\"float:right;\" class=\"linkbuttongray linkbuttonmedium radiusall\">".pcrtlang("pick")." <i class=\"fa fa-arrow-circle-right fa-lg\"></i></a><br>";
} else {
echo "<a href=\"deposits.php?cfirstname=$ue_personname&ccompany=$ue_grpcompany&caddress1=$ue_address1&caddress2=$ue_address2&ccity=$ue_city&cstate=$ue_state&czip=$ue_zip&cemail=$ue_email&cphone=$ue_phone&pcgroupid=$groupid\" style=\"float:right;\" class=\"linkbuttongray linkbuttonmedium radiusall\">".pcrtlang("pick")." <i class=\"fa fa-arrow-circle-right fa-lg\"></i></a><br>";
}
if("$grpcompany" != "") {
echo "$grpcompany<br>";
}

echo "<span class=\"sizemesmaller\">$address1";
if ($address2 != "") {
echo "<br>$address2";
}

if (($city != "") || ($state != "") || ($zip != "")) {
echo "<br>";
}

if ($city != "") {
echo "$city,";
}
if ($state != "") {
echo "$state,"; 
}
if ($zip != "") {
echo "$zip"; 
}

echo "</span></td></tr></table>";


}
stop_blue_box();


echo "</td><td width=2%><td><td width=33% valign=top>";

start_blue_box(pcrtlang("Receipt Search Results"));

$rs_findrec = "SELECT DISTINCT person_name,company,address1,address2,city,state,zip,email,phone_number FROM receipts WHERE person_name LIKE '%$searchtext%' OR company LIKE '%$searchtext%' ORDER BY date_sold DESC LIMIT 10";
$rs_resultrec = mysqli_query($rs_connect, $rs_findrec);

if (mysqli_num_rows($rs_resultrec) == "0") {
echo "<br><span class=\"colormegray italme\">".pcrtlang("No Receipts Found")."...<br><br></span>";
}

while ($rs_result_recq = mysqli_fetch_object($rs_resultrec)) {
$personname = "$rs_result_recq->person_name";
$company = "$rs_result_recq->company";
$address1 = "$rs_result_recq->address1";
$address2 = "$rs_result_recq->address2";
$city = "$rs_result_recq->city";
$state = "$rs_result_recq->state";
$zip = "$rs_result_recq->zip";
$email = "$rs_result_recq->email";
$phone = "$rs_result_recq->phone_number";

$ue_personname = urlencode($personname);
$ue_company = urlencode($company);
$ue_address1 = urlencode($address1);
$ue_address2 = urlencode($address2);
$ue_city = urlencode($city);
$ue_state = urlencode($state);
$ue_zip = urlencode($zip);
$ue_email = urlencode($email);
$ue_phone = urlencode($phone);



echo "<table class=badge><tr><td>";
echo "$personname";
if ("$pickfor" == "currentcart") {
echo "<a href=\"cart.php?func=pickcustomer2&personname=$ue_personname&company=$ue_company&address1=$ue_address1&address2=$ue_address2&city=$ue_city&state=$ue_state&zip=$ue_zip&email=$ue_email&phone=$ue_phone\" style=\"float:right;\" class=\"linkbuttongray linkbuttonmedium radiusall\">".pcrtlang("pick")." <i class=\"fa fa-arrow-circle-right fa-lg\"></i></a><br>";
} else {
echo "<a href=\"deposits.php?cfirstname=$ue_personname&ccompany=$ue_company&caddress1=$ue_address1&caddress2=$ue_address2&ccity=$ue_city&cstate=$ue_state&czip=$ue_zip&cemail=$ue_email&cphone=$ue_phone\" style=\"float:right;\" class=\"linkbuttongray linkbuttonmedium radiusall\">".pcrtlang("pick")." <i class=\"fa fa-arrow-circle-right fa-lg\"></i></a><br>";
}

if("$company" != "") {
echo "$company<br>";
}


echo "<span class=\"sizemesmaller\">$address1";
if ($address2 != "") {
echo "<br>$address2";
}

if (($city != "") || ($state != "") || ($zip != "")) {
echo "<br>";
}

if ($city != "") {
echo "$city,";
}
if ($state != "") {
echo "$state,";
}
if ($zip != "") {
echo "$zip";
}

echo "</span></td></tr></table>";


}
stop_blue_box();

echo "</td>";


echo "</tr></table>";

require_once("footer.php");

}



function pickcustomer2() {
require_once("validate.php");

require("deps.php");
require("common.php");

$cfirstname = pv($_REQUEST['personname']);
$ccompany = pv($_REQUEST['company']);
$caddress = pv($_REQUEST['address1']);
$caddress2 = pv($_REQUEST['address2']);
$ccity = pv($_REQUEST['city']);
$cstate = pv($_REQUEST['state']);
$czip = pv($_REQUEST['zip']);
$cphone = pv($_REQUEST['phone']);
$cemail = pv($_REQUEST['email']);

if (array_key_exists('pcgroupid',$_REQUEST)) {
$pcgroupid = pv($_REQUEST['pcgroupid']);
} else {
$pcgroupid = 0;
}




$rs_clear_cust = "DELETE FROM currentcustomer WHERE byuser = '$ipofpc'";
@mysqli_query($rs_connect, $rs_clear_cust);

$rs_insert_cust = "INSERT INTO currentcustomer (cfirstname,ccompany,caddress,caddress2,ccity,cstate,czip,cphone,cemail,byuser,pcgroupid) VALUES  ('$cfirstname','$ccompany','$caddress','$caddress2','$ccity','$cstate','$czip','$cphone','$cemail','$ipofpc','$pcgroupid')";
@mysqli_query($rs_connect, $rs_insert_cust);

header("Location: cart.php");

}

function edit() {
require_once("validate.php");
require("deps.php");

require_once("common.php");
if($gomodal != "1") {
require("header.php");
} else {
require_once("validate.php");
}

$rs_cart_item_id = $_REQUEST['cart_item_id'];
$rs_taxex = $_REQUEST['rs_taxex'];
$carttype = $_REQUEST['rs_cart_type'];
$rs_cart_price = $_REQUEST['rs_cart_price'];
$itemdesc = $_REQUEST['itemdesc'];
$printdesc = $_REQUEST['printdesc'];
$serial = $_REQUEST['serial'];
$price_alt = $_REQUEST['price_alt'];
$cost = $_REQUEST['cost'];
$qty = $_REQUEST['qty'];



if($gomodal != "1") {
start_blue_box(pcrtlang("Edit Cart Item"));
} else {
echo "<h4>".pcrtlang("Edit Cart Item")."</h4><br><br>";
}

echo pcrtlang("Original Unit Price").": <span class=colormeblue>$money".mf("$rs_cart_price")."</span><br><br>";

echo "<form method=post action=cart.php?func=edit2 name=editnoninv id=editform><input type=hidden name=cart_item_id value=$rs_cart_item_id>";
echo "<input type=hidden name=rs_taxex value=$rs_taxex><input type=hidden name=carttype value=\"$carttype\">";
echo "<table>";
if($carttype == "purchase") {

if($serial != "") {
echo "<tr><td>".pcrtlang("Quantity").":</td><td>".qf("$qty")."<input type=hidden name=qty value=\"$qty\"></td></tr>";
} else {
echo "<tr><td>".pcrtlang("Quantity").":</td><td><input size=30 type=number class=textbox name=qty value=\"".qf("$qty")."\" min=1 step=1></td></tr>";
}

echo "<tr><td>".pcrtlang("Item Title").":</td><td><input size=30 type=text class=textbox name=itemdesc value=\"".pf("$itemdesc")."\"></td></tr>";

echo "<tr><td>".pcrtlang("Optional Printable Description").":</td><td><textarea size=60 class=textbox name=printdesc>$printdesc</textarea></td></tr>";

if($qty == 1) {
echo "<tr><td>".pcrtlang("Serial/Code").":</td><td><input size=30 type=text class=textbox name=serial value=\"$serial\"></td></tr>";
} else {
echo "<input type=hidden name=serial value=\"\">";
}



} else {
echo "<tr><td>".pcrtlang("Quantity").":</td><td><input size=30 type=number class=textbox name=qty value=\"$qty\" min=\".01\" step=\".01\"></td></tr>";
echo "<tr><td>".pcrtlang("Labor Title").":</td><td><input size=30 type=text class=textbox name=itemdesc value=\"".pf("$itemdesc")."\"></td></tr>";
echo "<tr><td>".pcrtlang("Optional Printable Description").":</td><td><textarea size=60 class=textbox name=printdesc>$printdesc</textarea></td></tr>";
}
if($price_alt != "1") {
echo "<tr><td>".pcrtlang("Unit Price").":</td><td><input size=8 type=text class=textbox name=price id=price value=\"".mf("$rs_cart_price")."\">";

$usertaxid = getusertaxid();
if($carttype == "purchase") {
$salestaxrateremain = (1 + getsalestaxrate($usertaxid));
} else {
$salestaxrateremain = (1 + getservicetaxrate($usertaxid));
}
if($salestaxrateremain != 1) {
echo "<button class=button type=button onclick='document.getElementById(\"price\").value=(document.getElementById(\"price\").value / $salestaxrateremain).toFixed(5);this.disabled=true;'>
<i class=\"fa fa-calculator\"></i> ".pcrtlang("Pre-tax")."</button>";
}


echo "</td></tr>";

if($carttype == "purchase") {
echo "<tr><td>".pcrtlang("Unit Cost").":</td><td><input size=8 type=text class=textbox name=cost value=\"".mf("$cost")."\"></td></tr>";

?>

<script>
function markup() {
var marknum = Math.ceil((document.editnoninv.cost.value - 0) * (document.editnoninv.chooser.value - 0)) - document.editnoninv.cents.value;
document.editnoninv.price.value = marknum.toFixed(2);
}
</script>

<?php

echo "<tr><td>".pcrtlang("Markup").": </td><td>";
echo "<select name=chooser onChange=\"markup()\">
<option value=\"1.0\"></option>
<option value=\"1.04\">4%</option>
<option value=\"1.1\">10%</option>
<option value=\"1.2\">20%</option>
<option value=\"1.3\">30%</option>
<option value=\"1.4\">40%</option>
<option value=\"1.5\">50%</option>
<option value=\"1.75\">75%</option>
<option value=\"2\">2X</option>
<option value=\"3\">3X</option>
<option value=\"5\">5X</option>
<option value=\"10\">10X</option>
</select>";

echo "<select name=cents onChange=\"markup()\">
<option value=\"0.10\">90 ".pcrtlang("cents")."</option>
<option value=\"0.05\">95 ".pcrtlang("cents")."</option>
<option value=\"0.01\">99 ".pcrtlang("cents")."</option>
<option value=\"00\">00 ".pcrtlang("cents")."</option>
</select></td></tr>";



}
} else {
echo "<input type=hidden name=price value=\"$rs_cart_price\">";
if($carttype == "purchase") {
echo "<input type=hidden name=cost value=\"$cost\">";
}
}
echo "</table>";
echo "<br><button type=submit id=editbutton class=button><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save")."</button></form>";


if($gomodal != 1) {
stop_blue_box();
}

if($gomodal != 1) {
require_once("footer.php");
}

}


function edit2() {
require_once("validate.php");

require("deps.php");
require("common.php");


$cart_item_id = $_REQUEST['cart_item_id'];
$carttype = $_REQUEST['carttype'];
$taxex = $_REQUEST['rs_taxex'];
$itemdesc = pv($_REQUEST['itemdesc']);
$printdesc = pv($_REQUEST['printdesc']);
$price = $_REQUEST['price'];
$qty = $_REQUEST['qty'];




$rs_find_cart_item = "SELECT * FROM cart WHERE cart_item_id = '$cart_item_id'";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_item);
$rs_result_q = mysqli_fetch_object($rs_result);
$rs_price_alt = "$rs_result_q->price_alt";
$rs_origprice = "$rs_result_q->origprice";
$rs_quantity = "$rs_result_q->quantity";

if($rs_price_alt == 1) {
if($rs_origprice != 0) {
$orig_unit_price = $rs_origprice / $rs_quantity;
$neworigprice = $orig_unit_price * $qty;
} else {
$neworigprice = 0;
}
} else {
$neworigprice = 0;
}


if($carttype == "purchase") {
$cost = $_REQUEST['cost'] * $qty;
$serial = $_REQUEST['serial'];
$salestaxrate = getsalestaxrate($taxex);
$itemtax = $price * $salestaxrate * $qty;
$totalprice = $price * $qty;

if(($qty != 1) && ($serial != "")) {
die(pcrtlang("Error: Quantity on an item with a serial number must be 1"));
}


$rs_setprice_cart = "UPDATE cart SET cart_price = '$totalprice', unit_price = '$price', quantity = '$qty', itemtax = '$itemtax', labor_desc = '$itemdesc', ourprice = '$cost', itemserial = '$serial', origprice = '$neworigprice', printdesc = '$printdesc' WHERE cart_item_id = '$cart_item_id'";
@mysqli_query($rs_connect, $rs_setprice_cart);

} else {

$servicetaxrate = getservicetaxrate($taxex);
$servicetax = $price * $servicetaxrate * $qty;

$totalprice = $price * $qty;

$rs_setprice_cart = "UPDATE cart SET cart_price = '$totalprice', unit_price = '$price', quantity = '$qty', itemtax = '$servicetax', labor_desc = '$itemdesc', origprice = '$neworigprice', printdesc = '$printdesc'  WHERE cart_item_id = '$cart_item_id'";
@mysqli_query($rs_connect, $rs_setprice_cart);


}

header("Location: cart.php");
}

function removediscount() {
require_once("validate.php");
$cart_item_id = $_REQUEST['cart_item_id'];

require("deps.php");
require("common.php");



$rs_find_cart_item = "SELECT * FROM cart WHERE cart_item_id = '$cart_item_id'";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_item);
$rs_result_q = mysqli_fetch_object($rs_result);
$rs_cart_type = "$rs_result_q->cart_type";
$rs_price_alt = "$rs_result_q->price_alt";
$rs_taxex = "$rs_result_q->taxex";
$rs_origprice = "$rs_result_q->origprice";
$rs_unit_price = "$rs_result_q->unit_price";
$rs_quantity = "$rs_result_q->quantity";

if($rs_origprice != 0) {
$rs_orig_unit_price = $rs_origprice / $rs_quantity;
} else {
$rs_orig_unit_price = 0;
}


if($rs_cart_type == "purchase") {
$salestaxrate = getsalestaxrate($rs_taxex);
$itemtax = $rs_origprice * $salestaxrate;

$rs_setprice_cart = "UPDATE cart SET cart_price = '$rs_origprice', itemtax = '$itemtax', discounttype = '', origprice = '0', price_alt = '0', unit_price = '$rs_orig_unit_price', discountname = '' WHERE cart_item_id = '$cart_item_id'";
@mysqli_query($rs_connect, $rs_setprice_cart);

} else {

$servicetaxrate = getservicetaxrate($rs_taxex);
$servicetax = $rs_origprice * $servicetaxrate;

$rs_setprice_cart = "UPDATE cart SET cart_price = '$rs_origprice', itemtax = '$servicetax', discounttype = '', origprice = '0', price_alt = '0', unit_price = '$rs_orig_unit_price', discountname = '' WHERE cart_item_id = '$cart_item_id'";
@mysqli_query($rs_connect, $rs_setprice_cart);

}

header("Location: cart.php");
}


function refundlabor() {
require_once("validate.php");

require("deps.php");
require("common.php");

$item = $_REQUEST['item'];
$receipt = $_REQUEST['receipt'];
$price = $_REQUEST['price'];
$labordesc = pv($_REQUEST['labordesc']);
$rs_taxex = $_REQUEST['taxex'];
$cunitprice = $_REQUEST['cunitprice'];
$cquantity = $_REQUEST['cquantity'];
$quantity = $_REQUEST['quantity'];


if (array_key_exists('cfirstname',$_REQUEST)) {
$custname =  pv($_REQUEST['cfirstname']);
} else {
$custname = "";
}

if (array_key_exists('ccompany',$_REQUEST)) {
$ccompany =  pv($_REQUEST['ccompany']);
} else {
$ccompany = "";
}


if (array_key_exists('caddress',$_REQUEST)) {
$custaddy1 =  pv($_REQUEST['caddress']);
} else {
$custaddy1 = "";
}

if (array_key_exists('caddress2',$_REQUEST)) {
$custaddy2 =  pv($_REQUEST['caddress2']);
} else {
$custaddy2 = "";
}

if (array_key_exists('ccity',$_REQUEST)) {
$custcity =  pv($_REQUEST['ccity']);
} else {
$custcity = "";
}

if (array_key_exists('cstate',$_REQUEST)) {
$custstate =  pv($_REQUEST['cstate']);
} else {
$custstate = "";
}

if (array_key_exists('czip',$_REQUEST)) {
$custzip =  pv($_REQUEST['czip']);
} else {
$custzip = "";
}

if (array_key_exists('cphone',$_REQUEST)) {
$custphone =  pv($_REQUEST['cphone']);
} else {
$custphone = "";
}

if (array_key_exists('cemail',$_REQUEST)) {
$custemail =  pv($_REQUEST['cemail']);
} else {
$custemail = "";
}


$rs_clear_cust = "DELETE FROM currentcustomer WHERE byuser = '$ipofpc'";
@mysqli_query($rs_connect, $rs_clear_cust);
$rs_insert_cust = "INSERT INTO currentcustomer (cfirstname,ccompany,caddress,caddress2,ccity,cstate,czip,cphone,cemail,byuser) VALUES ('$custname','$ccompany','$custaddy1','$custaddy2','$custcity','$custstate','$custzip','$custphone','$custemail','$ipofpc')";
@mysqli_query($rs_connect, $rs_insert_cust);


$servicetaxrate = getservicetaxrate($rs_taxex);

$price2 = $cunitprice * $quantity;

$labortax = $price2 * $servicetaxrate;




$addtime = time();
$rs_insert_return = "INSERT INTO cart (cart_price,cart_type,labor_desc,return_sold_id,ipofpc,taxex,itemtax,addtime,unit_price,quantity) VALUES ('$price2','refundlabor','$labordesc','$item','$ipofpc','$rs_taxex','$labortax','$addtime','$cunitprice','$quantity')";
@mysqli_query($rs_connect, $rs_insert_return);


$rs_flag_return = "UPDATE sold_items SET return_flag = 'flagged' WHERE sold_id = '$item'";
@mysqli_query($rs_connect, $rs_flag_return);
header("Location: receipt.php?func=show_receipt&receipt=$receipt");
}



function spoaddcart() {
require_once("validate.php");

require("deps.php");
require("common.php");

$spowoid = $_REQUEST['spowoid'];
$spoid = $_REQUEST['spoid'];

$rs_find_so = "SELECT * FROM specialorders WHERE spoid = '$spoid'";
$rs_result_so = mysqli_query($rs_connect, $rs_find_so);

$rs_result_item_q = mysqli_fetch_object($rs_result_so);
$spoid = "$rs_result_item_q->spoid";
$spopartname = "$rs_result_item_q->spopartname";
$spoprintdesc = "$rs_result_item_q->printdesc";
$spoprice = mf("$rs_result_item_q->spoprice");
$spocost = mf("$rs_result_item_q->spocost");
$unit_price = "$rs_result_item_q->unit_price";
$quantity = "$rs_result_item_q->quantity";

$usertaxid = getusertaxid();
$taxrate = getsalestaxrate($usertaxid);
$itemtax = $taxrate * $spoprice * $quantity;

$addtime = time();

$rs_insert_cart = "INSERT INTO cart (cart_price,cart_type,labor_desc,taxex,itemtax,ourprice,addtime,ipofpc,unit_price,quantity,printdesc) VALUES ('$spoprice','purchase','$spopartname','$usertaxid','$itemtax','$spocost','$addtime','$ipofpc','$unit_price','$quantity','$spoprintdesc')";
@mysqli_query($rs_connect, $rs_insert_cart);


header("Location: cart.php");

}



function resyncprice() {
require_once("validate.php");

$newtax = $_REQUEST['newtax'];
$newprice = $_REQUEST['newprice'];
$iskit = $_REQUEST['iskit'];
$cartname = $_REQUEST['cartname'];
$cart_stock_id = $_REQUEST['cart_stock_id'];

require("deps.php");
require("common.php");





$rs_update = "UPDATE savedcarts SET cart_price = '$newprice', itemtax = '$newtax' WHERE cartname = '$cartname' AND cart_stock_id = '$cart_stock_id'";

@mysqli_query($rs_connect, $rs_update);

header("Location: cart.php?func=show_savecart&iskit=$iskit");

}



function pickcustomerajax() {

require("deps.php");
require("common.php");
require("headerincludes.php");


$search = $_REQUEST['search'];


$rs_findpc = "SELECT * FROM pc_group WHERE pcgroupname LIKE '%$search%' OR grpcompany LIKE '%$search%' OR grpphone LIKE '%$search%' OR grpcellphone LIKE '%$search%'
OR grpworkphone LIKE '%$search%' OR grpemail LIKE '%$search%' ORDER BY pcgroupid DESC LIMIT 20";
$rs_result = mysqli_query($rs_connect, $rs_findpc);

while ($rs_result_q = mysqli_fetch_object($rs_result)) {
$pcgroupname = "$rs_result_q->pcgroupname";
$pcgroupid = "$rs_result_q->pcgroupid";
$grpcompany = "$rs_result_q->grpcompany";
$grpphone = "$rs_result_q->grpphone";
$grpcellphone = "$rs_result_q->grpcellphone";
$grpworkphone = "$rs_result_q->grpworkphone";
$grpaddress = "$rs_result_q->grpaddress1";
$grpaddress2 = "$rs_result_q->grpaddress2";
$grpcity = "$rs_result_q->grpcity";
$grpstate = "$rs_result_q->grpstate";
$grpzip = "$rs_result_q->grpzip";
$grpemail = "$rs_result_q->grpemail";
$grpcustsourceid = "$rs_result_q->grpcustsourceid";
$grpprefcontact = "$rs_result_q->grpprefcontact";

$ue_pcgroupname = urlencode($pcgroupname);
$ue_grpcompany = urlencode($grpcompany);
$ue_grpphone = urlencode($grpphone);
$ue_grpcellphone = urlencode($grpcellphone);
$ue_grpworkphone = urlencode($grpworkphone);
$ue_grpaddress = urlencode($grpaddress);
$ue_grpaddress2 = urlencode($grpaddress2);
$ue_grpcity = urlencode($grpcity);
$ue_grpstate = urlencode($grpstate);
$ue_grpzip = urlencode($grpzip);
$ue_grpemail = urlencode($grpemail);
$ue_grpcustsourceid = urlencode($grpcustsourceid);
$ue_grpprefcontact = urlencode($grpprefcontact);




echo "<a href=\"cart.php?func=pickcustomer2&personname=$ue_pcgroupname&company=$ue_grpcompany&address1=$ue_grpaddress&address2=$ue_grpaddress2&city=$ue_grpcity&state=$ue_grpstate&zip=$ue_grpzip&email=$ue_grpemail&phone=$ue_grpphone&pcgroupid=$pcgroupid\" class=\"catchpickcustomer linkbuttonmedium linkbuttonblack radiusall displayblock\" style=\"margin-top:7px;\"><i class=\"fa fa-group fa-lg\"></i> $pcgroupname <br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$grpcompany<span class=floatright><i class=\"fa fa-chevron-right fa-lg\"></i></span></a>";


}


if(mysqli_num_rows($rs_result) < 4) {

$rs_find_pc = "SELECT * FROM pc_owner WHERE pcname LIKE '%$search%' OR pccompany LIKE '%$search%'  OR pcmake LIKE '%$search%' OR pcphone LIKE '%$search%'
OR pcworkphone LIKE '%$search%' OR pccellphone LIKE '%$search%' OR pcemail LIKE '%$search%' ORDER BY pcid DESC LIMIT 20";
$rs_result_item = mysqli_query($rs_connect, $rs_find_pc);


while($rs_result_q = mysqli_fetch_object($rs_result_item)) {

$groupid = "$rs_result_q->pcgroupid";
$personname = "$rs_result_q->pcname";
$pccompany = "$rs_result_q->pccompany";
$address1 = "$rs_result_q->pcaddress";
$address2 = "$rs_result_q->pcaddress2";
$city = "$rs_result_q->pccity";
$state = "$rs_result_q->pcstate";
$zip = "$rs_result_q->pczip";
$email = "$rs_result_q->pcemail";
$phone = "$rs_result_q->pcphone";
$workphone = "$rs_result_q->pcworkphone";
$cellphone = "$rs_result_q->pccellphone";

if($phone != "") {
    $phone = "$phone";
} elseif ($cellphone != "") {
    $phone = "$cellphone";
} else {
    $phone = "$workphone";
}

$ue_personname = urlencode($personname);
$ue_pccompany = urlencode($pccompany);
$ue_address1 = urlencode($address1);
$ue_address2 = urlencode($address2);
$ue_city = urlencode($city);
$ue_state = urlencode($state);
$ue_zip = urlencode($zip);
$ue_email = urlencode($email);
$ue_phone = urlencode($phone);


echo "<a href=\"cart.php?func=pickcustomer2&personname=$ue_personname&company=$ue_pccompany&address1=$ue_address1&address2=$ue_address2&city=$ue_city&state=$ue_state&zip=$ue_zip&email=$ue_email&phone=$ue_phone&pcgroupid=$groupid\" style=\"margin-top:7px;\" class=\"catchpickcustomer linkbuttongray linkbuttonmedium displayblock radiusall\"><i class=\"fa fa-tag fa-lg\"></i> $personname <span class=floatright><i class=\"fa fa-chevron-right fa-lg\"></i></span></a>";
}
}

?>
<script type='text/javascript'>
$(document).ready(function(){
$('.catchpickcustomer').click(function(e) { // catch the form's submit event
        e.preventDefault();
		 $('.ajaxspinner').toggle();
                var url = $(this).attr('href');
                $.get(url, function () {
                $.get('cart.php?func=cartarea', function(data) {
                $('#cartarea').html(data);
                });
                $.get('cart.php?func=paymentsarea', function(data) {
                $('#paymentsarea').html(data);
                });
                $.get('cart.php?func=customerarea&saved=yes', function(data) {
                $('#customerarea').html(data);
                });
                $.get('cart.php?func=paymentmethodsarea', function(data) {
                $('#paymentmethodsarea').html(data);
                });
                $.get('cart.php?func=newinvoicearea', function(data) {
                $('#newinvoicearea').html(data);
                });
                $.get('cart.php?func=cartfloaterarea', function(data) {
                $('#bottomnavbarfixedlight').html(data);
                });

		$("div#themain").slideUp(200,function(){
                	return false;
                });
		 $('.ajaxspinner').toggle();

    });
});
});
</script>
<?php


}




function register_close() {
require_once("validate.php");
require("deps.php");

require_once("common.php");
perm_boot("30");
require("header.php");

if (array_key_exists('plugin',$_REQUEST)) {
$plugin = $_REQUEST['plugin'];
} else {
$plugin = "Cash";
}


if (array_key_exists('registerid',$_REQUEST)) {
$registerid = $_REQUEST['registerid'];
} else {
$registerid = getcurrentregister();
}

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');


$rs_find_last_close = "SELECT * FROM regclose WHERE registerid = '$registerid' AND paymentplugin = '$plugin' ORDER BY closeddate DESC LIMIT 1";
$rs_result_lc = mysqli_query($rs_connect, $rs_find_last_close);
$lccount = mysqli_num_rows($rs_result_lc);

if($lccount == 0) {
$balanceforward = 0;
$expectedtotal = 0;
$closeddate = "0000-00-00 00:00:00";
} else {
$rs_result_lcq = mysqli_fetch_object($rs_result_lc);
$balanceforward = "$rs_result_lcq->balanceforward";
$closeddate = "$rs_result_lcq->closeddate";

$rs_find_sales = "SELECT SUM(amount) AS total FROM savedpayments WHERE paymentdate <= '$currentdatetime' AND paymentdate  >= '$closeddate' 
AND paymentplugin = '$plugin' AND registerid = '$registerid'";
$rs_result_sales = mysqli_query($rs_connect, $rs_find_sales);
$rs_result_sales_q = mysqli_fetch_object($rs_result_sales);
$rs_total = "$rs_result_sales_q->total";

$rs_find_rdeposits = "SELECT SUM(amount) AS rtotal FROM deposits WHERE depdate <= '$currentdatetime' AND depdate  >= '$closeddate'
AND paymentplugin = '$plugin' AND registerid = '$registerid'";
$rs_result_rdeposits = mysqli_query($rs_connect, $rs_find_rdeposits);
$rs_result_rdeposits_q = mysqli_fetch_object($rs_result_rdeposits);
$rs_totalrdeposit = "$rs_result_rdeposits_q->rtotal";

$rs_find_adeposits = "SELECT SUM(amount) AS atotal FROM deposits WHERE applieddate <= '$currentdatetime' AND applieddate  >= '$closeddate'
AND paymentplugin = '$plugin' AND aregisterid = '$registerid'";
$rs_result_adeposits = mysqli_query($rs_connect, $rs_find_adeposits);
$rs_result_adeposits_q = mysqli_fetch_object($rs_result_adeposits);
$rs_totaladeposit = "$rs_result_adeposits_q->atotal";

$expectedtotal = mf((tnv($rs_total) + tnv($balanceforward) + tnv($rs_totalrdeposit)) - tnv($rs_totaladeposit));

}



start_blue_box(pcrtlang("Close Register"));


start_box();
$rs_find_registers = "SELECT * FROM registers WHERE registerstoreid = '$defaultuserstore' ORDER BY registername ASC";
$rs_result_registers = mysqli_query($rs_connect, $rs_find_registers);

echo "<table><tr><td><span class=\"boldme sizeme16\">";

if($registerid != 0) {
echo pcrtlang("Switch Register").":";
} else {
echo pcrtlang("Please Select a Register").":";
}

echo "</span></td><td>";
echo "<form method=post action=cart.php?func=register_close>";
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
echo "</select></form></td></tr></table>";

stop_box();

echo "<br>";

if($registerid != 0) {

echo "<table style=\"width:100%;\"><tr><td style=\"vertical-align:top;\">";
echo "<form name=submitform action=cart.php?func=register_close2 method=post>";

echo "&nbsp;<input type=text disabled class=\"denom textboxnoborder\" name=\"null\" style=\"width:50px;\"> ";
echo "<input type=text disabled class=\"textboxnoborder\" name=\"null\" style=\"width:50px;\" value=\"".pcrtlang("Count")."\"> ";
echo "&nbsp;&nbsp;&nbsp;<input type=text disabled class=\"textboxnoborder\" name=\"null\" style=\"width:75px;\" value=\"".pcrtlang("Subtotal")."\"><br> ";

$tabindex = 1;

$rs_qb = "SELECT * FROM denoms ORDER BY denomvalue ASC";
$rs_resultb = mysqli_query($rs_connect, $rs_qb);
while($rs_result_qb = mysqli_fetch_object($rs_resultb)) {
$denomid = "$rs_result_qb->denomid";
$denomvalue = "$rs_result_qb->denomvalue";

echo "<div>";
echo "$money<input type=text readonly class=\"denom textboxnoborder\" name=\"denom[]\" value=\"$denomvalue\" style=\"width:50px;\"> ";
echo "<input type=text class=\"count textbox\" name=\"count[]\" style=\"width:50px;\" tabindex=$tabindex> ";
echo "$money<input type=text readonly class=\"subtotal textbox\" name=\"subtotal[]\" style=\"width:75px;\"><br> ";
echo "</div>";

$tabindex++;

}

echo "</td><td style=\"vertical-align:top;\">";

echo "<table>";
echo "<tr><td><span class=boldme>".pcrtlang("Count Total").":</span></td><td> $money<input readonly type=text class=\"grandtotal textbox\" name=\"counttotal\" value=\"0\"></td></tr>";
echo "<tr><td><span class=boldme>".pcrtlang("Expected Total").":</span></td>";

if($lccount == 0) {
echo "<td style=\"padding:10px;\"><span class=colormered><i class=\"fa fa-warning fa-lg\"></i> ".pcrtlang("Previous close data not available")."...</span><input readonly type=hidden class=\"expectedtotal\" name=\"expectedtotal\" value=\"$expectedtotal\"></td>";
} else {
echo "<td> $money<input readonly type=text class=\"expectedtotal textbox\" name=\"expectedtotal\" value=\"$expectedtotal\"></td>";
}

echo "</td></tr>";
echo "<tr><td><span class=boldme>".pcrtlang("Difference").":</span></td>";

if($lccount != 0) {
echo "<td> $money<input readonly type=text class=\"difference textbox\" name=\"difference\" value=\"0\"></td>";
} else {
echo "<td style=\"padding:10px;\"><input readonly type=hidden class=\"difference\" name=\"difference\" value=\"0\"></td>";
}


echo "</td></tr>";
echo "<tr><td><span class=boldme>".pcrtlang("Withdrawal Amount").":</span></td><td> $money<input type=text class=\"removed textbox\" name=\"removed\" value=\"0\" tabindex=50></td></tr>";
echo "<tr><td><span class=boldme>".pcrtlang("Next Opening Count").":</span></td>
<td> $money<input type=text class=\"opening textbox\" name=\"nextopening\" value=\"0\"></td></tr>";
echo "<tr><td><span class=boldme>".pcrtlang("Notes").":</span></td>
<td><textarea class=\"textbox\" name=\"notes\"></textarea></td></tr>";

echo "</table>";


echo "<input type=hidden name=closeddate value=\"$currentdatetime\">";
echo "<input type=hidden name=opendate value=\"$closeddate\">";
echo "<input type=hidden name=registerid value=\"$registerid\">";
echo "<input type=hidden name=plugin value=\"$plugin\">";
echo "<br><button type=submit class=button><i class=\"fa fa-sign-out fa-lg\"></i> ".pcrtlang("Close Register")."</button>";


echo "</form>";


echo "</td><tr></table>";

?>

<script>

$(function () {
    $('.denom,.count,.removed').on('keyup', function () {
    var denom = $(this).hasClass('denom') ? $(this).val() : $(this).siblings('.denom').val();
    var count = $(this).hasClass('count') ? $(this).val() : $(this).siblings('.count').val();
    denom = denom || 0;
    count = count || 0;
    var val = denom > 0 && count >= 1 ? parseFloat(denom * count) : 0;
    $(this).siblings('.subtotal').val(val.toFixed(2));
    var total = 0;
    var update = false;
    $('.subtotal').each(function () {
       total += parseFloat($(this).val() || 0);
    });
    $('.grandtotal').val(total.toFixed(2));
    var grandtotal = $('.grandtotal').val();
    var expectedtotal = $('.expectedtotal').val();
    var difference = parseFloat(grandtotal - expectedtotal);
    $('.difference').val(difference.toFixed(2));
    var removed = $('.removed').val();
    removed = removed || 0;
    var opening = parseFloat(grandtotal - removed);
    $('.opening').val(opening.toFixed(2));
  });
});

</script>

<?php

}

stop_blue_box();

require("footer.php");
}


function register_close2() {
require_once("validate.php");

require("deps.php");
require("common.php");
perm_boot("30");


$denom = $_REQUEST['denom'];
$count = $_REQUEST['count'];
$subtotal = $_REQUEST['subtotal'];
$counttotal = pv($_REQUEST['counttotal']);
$expectedtotal = pv($_REQUEST['expectedtotal']);
$difference = pv($_REQUEST['difference']);
$removed = pv($_REQUEST['removed']);
$nextopening = pv($_REQUEST['nextopening']);
$closeddate = pv($_REQUEST['closeddate']);
$opendate = pv($_REQUEST['opendate']);
$registerid = pv($_REQUEST['registerid']);
$plugin = pv($_REQUEST['plugin']);
$notes = pv($_REQUEST['notes']);

$countarray = array();

foreach($denom as $key => $val) {
$countarray[$val] = current($count);
next($count);
}

$countarray = pv(serialize($countarray));

$rs_close = "INSERT INTO regclose (registerid,storeid,paymentplugin,opendate,closeddate,closedby,counttotal,expectedtotal,variance,balanceforward,removedtotal,countarray,notes)
VALUES  ('$registerid','$defaultuserstore','$plugin','$opendate','$closeddate','$ipofpc','$counttotal','$expectedtotal','$difference','$nextopening','$removed','$countarray','$notes')";
@mysqli_query($rs_connect, $rs_close);

header("Location: reports.php?func=registerhistory&registerid=$registerid");

}


function switchregister() {
require_once("validate.php");

require("deps.php");
require("common.php");

$registerid = pv($_REQUEST['setregisterid']);
$receiptid = pv($_REQUEST['receiptid']);
$day = pv($_REQUEST['day']);
$storetoshow = pv($_REQUEST['storetoshow']);
$usertoshow = pv($_REQUEST['usertoshow']);

$rs_update1 = "UPDATE receipts SET registerid = '$registerid' WHERE receipt_id = '$receiptid'";
@mysqli_query($rs_connect, $rs_update1);
$rs_update2 = "UPDATE sold_items SET registerid = '$registerid' WHERE receipt = '$receiptid'";
@mysqli_query($rs_connect, $rs_update2);
$rs_update3 = "UPDATE savedpayments SET registerid = '$registerid' WHERE receipt_id = '$receiptid'";
@mysqli_query($rs_connect, $rs_update3);
$rs_update4 = "UPDATE deposits SET aregisterid = '$registerid' WHERE receipt_id = '$receiptid'";
@mysqli_query($rs_connect, $rs_update4);


header("Location: reports.php?func=day_report&day=$day&storetoshow=$storetoshow&usertoshow=$usertoshow");

}




function editinvitem() {
require_once("validate.php");
require("deps.php");

require_once("common.php");
if($gomodal != "1") {
require("header.php");
} else {
require_once("validate.php");
}

$rs_cart_item_id = $_REQUEST['cart_item_id'];
$rs_taxex = $_REQUEST['rs_taxex'];
$rs_cart_price = $_REQUEST['rs_cart_price'];
$price_alt = $_REQUEST['price_alt'];
$cost = $_REQUEST['cost'];
$qty = $_REQUEST['qty'];



if($gomodal != "1") {
start_blue_box(pcrtlang("Edit Cart Item"));
} else {
echo "<h4>".pcrtlang("Edit Cart Item")."</h4><br><br>";
}

echo "<form method=post action=cart.php?func=editinvitem2 name=editinvitem2 id=editform><input type=hidden name=cart_item_id value=$rs_cart_item_id>";
echo "<input type=hidden name=rs_taxex value=$rs_taxex><input type=hidden name=cost value=$cost>";
echo "<table>";
echo "<tr><td>".pcrtlang("Quantity").":</td><td><input size=30 type=number class=textbox name=qty value=\"".qf("$qty")."\" min=1 step=1></td></tr>";

echo "</table>";
echo "<br><button type=submit id=editbutton class=button><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Edit")."</button></form>";


if($gomodal != 1) {
stop_blue_box();
}

if($gomodal != 1) {
require_once("footer.php");
}

}


function editinvitem2() {
require_once("validate.php");

require("deps.php");
require("common.php");


$cart_item_id = $_REQUEST['cart_item_id'];
$taxex = $_REQUEST['rs_taxex'];
$qty = $_REQUEST['qty'];




$rs_find_cart_item = "SELECT * FROM cart WHERE cart_item_id = '$cart_item_id'";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_item);
$rs_result_q = mysqli_fetch_object($rs_result);
$rs_price_alt = "$rs_result_q->price_alt";
$rs_origprice = "$rs_result_q->origprice";
$rs_quantity = "$rs_result_q->quantity";
$unit_price = "$rs_result_q->unit_price";

if($rs_price_alt == 1) {
if($rs_origprice != 0) {
$orig_unit_price = $rs_origprice / $rs_quantity;
$neworigprice = $orig_unit_price * $qty;
} else {
$neworigprice = 0;
}
} else {
$neworigprice = 0;
}


$cost = $_REQUEST['cost'] * $qty;
$salestaxrate = getsalestaxrate($taxex);
$itemtax = $unit_price * $salestaxrate * $qty;
$totalprice = $unit_price * $qty;

$rs_setprice_cart = "UPDATE cart SET cart_price = '$totalprice', unit_price = '$unit_price', quantity = '$qty', itemtax = '$itemtax', ourprice = '$cost', origprice = '$neworigprice' WHERE cart_item_id = '$cart_item_id'";
@mysqli_query($rs_connect, $rs_setprice_cart);

header("Location: cart.php");
}



function addserialafter() {
require_once("validate.php");

require("deps.php");
require("common.php");

require_once("header.php");

start_blue_box(pcrtlang("Enter Serial/Code?"));

$stockid = $_REQUEST['stockid'];
$cart_item_id = $_REQUEST['cart_item_id'];

$availser = available_serials($stockid);

echo "<form action=cart.php?func=addserialafter2 method=post><table>";
if (count($availser) != 0) {
echo "<tr><td>".pcrtlang("Pick Serial").":<form action=cart.php?func=addserialafter2 method=post></td>";
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
echo "<td><input type=text cols=30 name=itemserial id=itemserial class=textbox><input type=hidden name=stockid value=\"$stockid\"></td></tr>";
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
$cart_item_id = $_REQUEST['cart_item_id'];

$qty = 1;

$availser = available_serials($stockid);
$availserl = array_map('strtolower', $availser);
if(in_array(strtolower("$itemserial"), $availserl) && !in_array("$itemserial", $availser)) {
$key = array_search(strtolower("$itemserial"), $availserl);
$itemserial = $availser[$key];
}

$rs_update_rc = "UPDATE cart SET itemserial = '$itemserial' WHERE cart_item_id = '$cart_item_id'";
$rs_find_stock_price = @mysqli_query($rs_connect, $rs_update_rc);


header("Location: cart.php");

}


function cartarea() {
require_once("validate.php");
require("deps.php");
require("common.php");
require("headerincludes.php");


if ($gomodal == 1) {
$therel = "rel=facebox";
} else {
$therel = "";
}

$mastertaxtotals = array();

$rs_find_cart_items_c = "SELECT SUM(quantity) AS ccitems FROM cart WHERE cart_type = 'purchase' AND ipofpc = '$ipofpc'";
$rs_result_c = mysqli_query($rs_connect, $rs_find_cart_items_c);
$totitem = mysqli_num_rows($rs_result_c);
$rs_result_ccitems = mysqli_fetch_object($rs_result_c);
$rs_ccitems = qf("$rs_result_ccitems->ccitems");


echo "<table class=\"pointofsale lastalignright3\">";
echo "<tr><th colspan=5>".pcrtlang("Items");

if ($rs_ccitems > "0") {
echo " &nbsp;<span style=\"padding:0px 6px 0px 6px;background:#cbdd87;color:#636d42\"\ class=radiusall>$rs_ccitems</span>";
}


echo "<span class=floatright>";
echo "<a href=cart.php?func=empty_cart class=\"catchcartarealink linkbuttontiny linkbuttonred radiusall\"><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Empty Cart")."</a>";
echo "</span></th></tr>";


$rs_find_cart_items = "SELECT * FROM cart WHERE cart_type = 'purchase' AND ipofpc = '$ipofpc' ORDER BY addtime ASC";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

if (mysqli_num_rows($rs_result) == 0) {
echo "<tr><td width=20%>&nbsp;</td><td width=50% colspan=4 style=\"text-align:left;\"><span class=\"italme colormegray\">".pcrtlang("No Purchase Items")."</span></td></tr>";
} else {
echo "<tr>";
echo "<td style=\"width:20%\" class=subhead>&nbsp</td>";
echo "<td style=\"width:50%\" class=subhead>".pcrtlang("Item Description")."</td>";
echo "<td style=\"width:5%\" class=subhead>".pcrtlang("Qty")."</td>";
echo "<td style=\"width:10%\" class=subhead>".pcrtlang("Unit Price")."</td>";
echo "<td style=\"width:15%\" class=subhead>".pcrtlang("Total")."</td>";
echo "</tr>";
}


while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_cart_item_id = "$rs_result_q->cart_item_id";
$rs_cart_price = "$rs_result_q->cart_price";
$rs_cart_type = "$rs_result_q->cart_type";
$rs_stock_id = "$rs_result_q->cart_stock_id";
$rs_price_alt = "$rs_result_q->price_alt";
$rs_noninvdesc = "$rs_result_q->labor_desc";
$rs_printdesc = "$rs_result_q->printdesc";
$rs_taxex = "$rs_result_q->taxex";
$rs_itemtax = "$rs_result_q->itemtax";
$rs_itemserial = "$rs_result_q->itemserial";
$rs_ourprice = "$rs_result_q->ourprice";
$rs_origprice = mf("$rs_result_q->origprice");
$rs_quantity = mf("$rs_result_q->quantity");
$rs_unit_price = mf("$rs_result_q->unit_price");
$rs_discountname = "$rs_result_q->discountname";


#newtaxcode
$salestaxrate = getsalestaxrate($rs_taxex);
$isgrouprate = isgrouprate($rs_taxex);

if($isgrouprate == 0) {
if(!array_key_exists("$rs_taxex", $mastertaxtotals)) {
$mastertaxtotals[$rs_taxex]['parts'] = $salestaxrate * $rs_cart_price;
$mastertaxtotals[$rs_taxex]['labor'] = 0;
$mastertaxtotals[$rs_taxex]['return'] = 0;
$mastertaxtotals[$rs_taxex]['refundlabor'] = 0;
} else {
$mastertaxtotals[$rs_taxex]['parts'] = ($salestaxrate * $rs_cart_price) + $mastertaxtotals[$rs_taxex]['parts'];
}
} else {
$grouprates = getgrouprates($rs_taxex);

foreach($grouprates as $key => $val) {
$salestaxratei = getsalestaxrate($val);

if(!array_key_exists("$val", $mastertaxtotals)) {
$mastertaxtotals[$val]['parts'] = $salestaxratei * $rs_cart_price;
$mastertaxtotals[$val]['labor'] = 0;
$mastertaxtotals[$val]['return'] = 0;
$mastertaxtotals[$val]['refundlabor'] = 0;
} else {
$mastertaxtotals[$val]['parts'] = ($salestaxratei * $rs_cart_price) + $mastertaxtotals[$val]['parts'];
}

}
}
####

if ($rs_stock_id != "0") {
$rs_find_item_detail = "SELECT * FROM stock WHERE stock_id = '$rs_stock_id'";
$rs_find_result = mysqli_query($rs_connect, $rs_find_item_detail);
while($rs_find_result_q = mysqli_fetch_object($rs_find_result)) {
$rs_stocktitle = "$rs_find_result_q->stock_title";
echo "<tr><td style=\"width:20%;vertical-align:top\">";

echo "<a href=\"javascript:void(0);\" class=\"linkbuttonmoney linkbuttonmedium radiusleft\" style=\"text-align:center;\" id=cartitemlink$rs_cart_item_id><i class=\"fa fa-chevron-down\"></i></a>";


if($rs_itemserial == "") {
$rs_cart_unit_price_ue = urlencode("$rs_unit_price");
$rs_quantity_ue = urlencode("$rs_quantity");

if($rs_ourprice == 0 ) {
$ourprice_ue = 0;
} else {
$ourprice_ue = urlencode($rs_ourprice / $rs_quantity);
}

echo "<a href=cart.php?func=editinvitem&cart_item_id=$rs_cart_item_id&rs_cart_price=$rs_cart_unit_price_ue&rs_taxex=$rs_taxex&price_alt=$rs_price_alt&cost=$ourprice_ue&qty=$rs_quantity_ue $therel class=\"linkbuttonmoney linkbuttonmedium\"><i class=\"fa fa-edit fa-lg\"></i></a>";
}

echo "<a href=cart.php?func=remove_cart_item&cart_item_id=$rs_cart_item_id class=\"catchcartarealink linkbuttonred2 linkbuttonmedium\"
style=\"display:none\"><i class=\"fa fa-check fa-lg\"></i></a><a href=\"javascript:void(0);\" class=\"deletereveal linkbuttonmoney linkbuttonmedium radiusright\"><i class=\"fa fa-trash fa-lg\"></i></a>";

echo "<div id=cartitem$rs_cart_item_id style=\"display:none;\"><br>";

$rs_find_tax = "SELECT * FROM taxes WHERE taxenabled = '1' ORDER BY taxname ASC";
$rs_result_tax = mysqli_query($rs_connect, $rs_find_tax);
echo "<form method=post action=cart.php?func=setitemtax class=\"catchcartareaformonchange\"><input type=hidden name=cart_item_id value=$rs_cart_item_id>";
echo "<select name=settaxid class=\"selects\">";

while($rs_result_tq = mysqli_fetch_object($rs_result_tax)) {
$rs_taxname = "$rs_result_tq->taxname";
$rs_taxid = "$rs_result_tq->taxid";

if ($rs_taxid == $rs_taxex) {
echo "<option selected value=$rs_taxid>$rs_taxname</option>";
} else {
echo "<option value=$rs_taxid>$rs_taxname</option>";
}
}
echo "</select><input type=hidden name=cartitemtype value=purchase>";
echo "</form>";

echo "</div>";

echo "</td><td style=\"width:50%;vertical-align:top;\">";


echo "$rs_stocktitle";

if($rs_printdesc != "") {
echo "<br><br><div class=leftindent>".nl2br("$rs_printdesc")."</div>";
}


if ($rs_itemserial != "") {
echo "<br><span class=\"sizemesmaller boldme\">".pcrtlang("Serial/Code").":</span> <span class=\"sizemesmaller\">$rs_itemserial</span>";
}


if (($rs_itemserial == "") && ($rs_quantity == 1)) {
if (count(available_serials($rs_stock_id)) > 0) {
echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class=\"sizemesmaller boldme\"><i class=\"fa fa-info-circle faa-flash animated\"></i> ".pcrtlang("Serials Available")."</span>";
echo " <a href=cart.php?func=addserialafter&cart_item_id=$rs_cart_item_id&stockid=$rs_stock_id class=\"linkbuttontiny linkbuttonmoney radiusall\" style=\"padding:2px;\"><i class=\"fa fa-plus\"></i></a>";
}
}



if ($rs_price_alt != 1) {


echo "<div id=cartitemd$rs_cart_item_id style=\"display:none;\">";


start_box();
echo "<span class=boldme>".pcrtlang("Percentage Discount")."</span>";
echo "<br><form method=post action=cart.php?func=discount_cart_item class=catchcartareaform><input type=hidden name=cart_item_id value=$rs_cart_item_id><input type=hidden name=rs_taxex value=$rs_taxex>";
echo "<input type=hidden name=carttype value=purchase><input type=hidden name=qty value=$rs_quantity>";
echo "<input type=text style=\"width:75px;\" placeholder=\"".pcrtlang("Percentage")."\" class=\"textbox margin5\" name=rs_dis_percent id=percentdiscount$rs_cart_item_id><i class=\"fa fa-percent\"></i>";

echo "<input type=text name=discountname id=discountname$rs_cart_item_id class=\"textbox margin5\" style=\"width:125px;\" placeholder=\"".pcrtlang("Enter Discount Name")."\">";

echo "<select name=myoptions class=margin5 onchange='document.getElementById(\"percentdiscount$rs_cart_item_id\").value=this.options[this.selectedIndex].value;document.getElementById(\"discountname$rs_cart_item_id\").value=this.options[this.selectedIndex].text'>";
$rs_ql = "SELECT * FROM discounts WHERE discounttype = '1' ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
echo "<option value=\"\">".pcrtlang("Choose Discount")."</option>";
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$discountid = "$rs_result_q1->discountid";
$discounttitle = "$rs_result_q1->discounttitle";
$discountamount = "$rs_result_q1->discountamount";
$discounttype = "$rs_result_q1->discounttype";
echo "<option value=\"".mf("$discountamount")."\">$discounttitle</option>";
}
echo "</select>";

echo "<br><button type=reset class=\"button margin5\"><i class=\"fa fa-eraser\"></i> ".pcrtlang("Reset")."</button>";
echo "<button type=submit class=\"button margin5\"><i class=\"fa fa-plus\"></i> ".pcrtlang("Add Discount")."</button>";

echo "</form>";

stop_box();
echo "<br>";
start_box();
echo "<span class=boldme>".pcrtlang("Nominal Discount")."</span><br>";
echo "<form method=post action=cart.php?func=custom_price class=catchcartareaform><input type=hidden name=cart_item_id value=$rs_cart_item_id><input type=hidden name=rs_taxex value=$rs_taxex>";
echo "<input type=hidden name=carttype value=\"$rs_cart_type\"><input type=hidden name=qty value=$rs_quantity>";
echo "$money<input style=\"width:50px\" type=text class=\"textbox margin5\" name=custom_price id=customprice$rs_cart_item_id value=\"".mf("$rs_unit_price")."\">";
echo "<input type=text name=discountname id=discountnamen$rs_cart_item_id class=\"textbox margin5\" style=\"width:125px\" placeholder=\"".pcrtlang("Enter Discount Name")."\">";

################

echo "<select name=myoptions class=\"margin5\" onchange='document.getElementById(\"customprice$rs_cart_item_id\").value=($rs_cart_price"." - this.options[this.selectedIndex].value).toFixed(2); document.getElementById(\"discountnamen$rs_cart_item_id\").value=this.options[this.selectedIndex].text'>";
$rs_ql = "SELECT * FROM discounts WHERE discounttype = '2' AND discountamount <= '$rs_unit_price' ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
echo "<option value=\"\">".pcrtlang("Choose Discount")."</option>";
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$discountid = "$rs_result_q1->discountid";
$discounttitle = "$rs_result_q1->discounttitle";
$discountamount = "$rs_result_q1->discountamount";
$discounttype = "$rs_result_q1->discounttype";
echo "<option value=\"$discountamount\">$discounttitle</option>";
}
echo "</select>";

echo "<br><button type=reset class=\"button margin5\"><i class=\"fa fa-eraser\"></i> ".pcrtlang("Reset")."</button>";
echo "<button type=submit class=\"button margin5\"><i class=\"fa fa-plus\"></i> ".pcrtlang("Set Custom Price")."</button>";

#########
echo "</form>";

stop_box();


echo "</div>";


} else {
echo "<br><span class=\"sizemesmaller colormered\">$rs_discountname - ".pcrtlang("was")." $money$rs_origprice</span>";
echo "<div id=cartitemd$rs_cart_item_id style=\"display:none;\"><br>";
echo "<a href=\"cart.php?func=removediscount&cart_item_id=$rs_cart_item_id\" class=\"linkbutton catchcartarealink\"><img src=images/remdiscount.png border=0 align=absmiddle width=16> ".pcrtlang("remove discount")."</a>";
echo "</div>";
}


?>
<script type='text/javascript'>
$('#cartitemlink<?php echo "$rs_cart_item_id"; ?>').click(function(){
  $('#cartitemd<?php echo "$rs_cart_item_id"; ?>').toggle('1000');
  $("i",this).toggleClass("fa-chevron-up fa-chevron-down");
  $('#cartitem<?php echo "$rs_cart_item_id"; ?>').toggle('1000');

});
</script>
<?php


$rs_find_stock = "SELECT * FROM stockcounts WHERE storeid = '$defaultuserstore' AND stockid = '$rs_stock_id'";
$rs_result_stock = mysqli_query($rs_connect, $rs_find_stock);
$rs_result_stockq = mysqli_fetch_object($rs_result_stock);
$stockqty = "$rs_result_stockq->quantity";

if($stockqty < $rs_quantity) {
echo "<span class=\"colormered sizemesmaller\"><i class=\"fa fa-exclamation-triangle fa-lg faa-flash animated\"></i>".pcrtlang("Warning: Item showing non-sufficient stock quantity")." ($stockqty)</span> <a href=stock.php?func=show_stock_detail&stockid=$rs_stock_id class=\"linkbuttontiny linkbuttonred radiusall\">(".pcrtlang("check qty").")</a>";
}




echo "</td>";

echo "<td style=\"width:5%;text-align:right\">".qf("$rs_quantity")."</td>";
echo "<td style=\"width:10%;text-align:right\">$money".mf("$rs_unit_price")."</td>";

echo "<td style=\"width:15%;text-align:right\">$money".mf("$rs_cart_price")."";
echo "<br><span class=sizemesmaller>$t_tax: $money".mf("$rs_itemtax")."</span></td></tr>";
}

} else {

echo "<tr><td style=\"width:20%;vertical-align:top\">";

$rs_cart_unit_price_ue = urlencode("$rs_unit_price");
$rs_labor_desc_ue = urlencode("$rs_noninvdesc");
$rs_printdesc_ue = urlencode("$rs_printdesc");
$rs_itemserial_ue = urlencode("$rs_itemserial");
$rs_quantity_ue = urlencode("$rs_quantity");

if($rs_ourprice == 0 ) {
$ourprice_ue = 0;
} else {
$ourprice_ue = urlencode($rs_ourprice / $rs_quantity);
}

echo "<a href=\"javascript:void(0);\" class=\"linkbuttonmoney linkbuttonmedium radiusleft\" style=\"text-align:center;\" id=cartitemlink$rs_cart_item_id><i class=\"fa fa-chevron-down\"></i></a>";


echo "<a href=cart.php?func=edit&cart_item_id=$rs_cart_item_id&rs_cart_price=$rs_cart_unit_price_ue&rs_taxex=$rs_taxex&rs_cart_type=$rs_cart_type&itemdesc=$rs_labor_desc_ue&price_alt=$rs_price_alt&serial=$rs_itemserial_ue&cost=$ourprice_ue&qty=$rs_quantity_ue&printdesc=$rs_printdesc_ue $therel class=\"linkbuttonmoney linkbuttonmedium\"><i class=\"fa fa-edit fa-lg\"></i></a>";

echo "<a href=cart.php?func=remove_cart_item&cart_item_id=$rs_cart_item_id class=\"catchcartarealink linkbuttonmedium linkbuttonred2\" style=\"display:none\"><i class=\"fa fa-check fa-lg\"></i></a>";
echo "<a href=\"javascript:void(0);\" class=\"deletereveal linkbuttonmoney linkbuttonmedium radiusright\"><i class=\"fa fa-trash fa-lg\"></i></a>";

echo "<div id=cartitem$rs_cart_item_id style=\"display:none;\"><br>";

$rs_find_tax = "SELECT * FROM taxes WHERE taxenabled = '1' ORDER BY taxname ASC";
$rs_result_tax = mysqli_query($rs_connect, $rs_find_tax);
echo "<form method=post action=cart.php?func=setitemtax class=catchcartareaformonchange><input type=hidden name=cart_item_id value=$rs_cart_item_id><select name=settaxid class=\"selects\">";

while($rs_result_tq = mysqli_fetch_object($rs_result_tax)) {
$rs_taxname = "$rs_result_tq->taxname";
$rs_taxid = "$rs_result_tq->taxid";

if ($rs_taxid == $rs_taxex) {
echo "<option selected value=$rs_taxid>$rs_taxname</option>";
} else {
echo "<option value=$rs_taxid>$rs_taxname</option>";
}
}
echo "</select><input type=hidden name=cartitemtype value=purchase></form>";

echo "</div>";


echo "</td><td style=\"width:50%;vertical-align:top\">$rs_noninvdesc";

if($rs_printdesc != "") {
echo "<br><br><div class=leftindent>".nl2br("$rs_printdesc")."</div>";
}

if ($rs_itemserial != "") {
echo "<br><span class=\"sizemesmaller boldme\">".pcrtlang("Serial/Code").":</span> <span class=\"sizemesmaller\">$rs_itemserial</span>";
}


if ($rs_price_alt != 1) {

echo "<div id=cartitemd$rs_cart_item_id style=\"display:none;\"><br>";

start_box();
echo "<span class=boldme>".pcrtlang("Percentage Discount")."</span>";
echo "<br><form method=post action=cart.php?func=discount_cart_item class=catchcartareaform><input type=hidden name=cart_item_id value=$rs_cart_item_id><input type=hidden name=rs_taxex value=$rs_taxex>";
echo "<input type=hidden name=carttype value=purchase><input type=hidden name=qty value=$rs_quantity>";
echo "<input type=text style=\"width:75px;\" placeholder=\"".pcrtlang("Percentage")."\" class=\"textbox margin5\" name=rs_dis_percent id=percentdiscount$rs_cart_item_id><i class=\"fa fa-percent\"></i>";

echo "<input type=text name=discountname id=discountname$rs_cart_item_id class=\"textbox margin5\" style=\"width:125px\" placeholder=\"".pcrtlang("Enter Discount Name")."\">";

echo "<select name=myoptions class=margin5 onchange='document.getElementById(\"percentdiscount$rs_cart_item_id\").value=this.options[this.selectedIndex].value;document.getElementById(\"discountname$rs_cart_item_id\").value=this.options[this.selectedIndex].text'>";
$rs_ql = "SELECT * FROM discounts WHERE discounttype = '1' ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
echo "<option value=\"\">".pcrtlang("Choose Discount")."</option>";
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$discountid = "$rs_result_q1->discountid";
$discounttitle = "$rs_result_q1->discounttitle";
$discountamount = "$rs_result_q1->discountamount";
$discounttype = "$rs_result_q1->discounttype";
echo "<option value=\"".mf("$discountamount")."\">$discounttitle</option>";
}
echo "</select>";

echo "<br><button type=reset class=\"button margin5\"><i class=\"fa fa-eraser\"></i> ".pcrtlang("Reset")."</button>";
echo "<button type=submit class=\"button margin5\"><i class=\"fa fa-plus\"></i> ".pcrtlang("Add Discount")."</button>";

echo "</form>";

stop_box();
echo "<br>";
start_box();
echo "<span class=boldme>".pcrtlang("Nominal Discount")."</span><br>";
echo "<form method=post action=cart.php?func=custom_price class=catchcartareaform><input type=hidden name=cart_item_id value=$rs_cart_item_id><input type=hidden name=rs_taxex value=$rs_taxex>";
echo "<input type=hidden name=carttype value=\"$rs_cart_type\"><input type=hidden name=qty value=$rs_quantity>";
echo "$money<input style=\"width:75px;\" type=text class=\"textbox margin5\" name=custom_price id=customprice$rs_cart_item_id value=\"".mf("$rs_cart_price")."\">";
echo "<input type=text name=discountname id=discountnamen$rs_cart_item_id class=\"textbox margin5\" style=\"width:125px\" placeholder=\"".pcrtlang("Enter Discount Name")."\">";

################

echo "<select name=myoptions class=\"margin5\" onchange='document.getElementById(\"customprice$rs_cart_item_id\").value=($rs_cart_price"." - this.options[this.selectedIndex].value).toFixed(2);document.getElementById(\"discountnamen$rs_cart_item_id\").value=this.options[this.selectedIndex].text'>";
$rs_ql = "SELECT * FROM discounts WHERE discounttype = '2' AND discountamount <= '$rs_unit_price' ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
echo "<option value=\"\">".pcrtlang("Choose Discount")."</option>";
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$discountid = "$rs_result_q1->discountid";
$discounttitle = "$rs_result_q1->discounttitle";
$discountamount = "$rs_result_q1->discountamount";
$discounttype = "$rs_result_q1->discounttype";
echo "<option value=\"$discountamount\">$discounttitle</option>";
}
echo "</select>";

echo "<br><button type=reset class=\"button margin5\"><i class=\"fa fa-eraser\"></i> ".pcrtlang("Reset")."</button>";
echo "<button type=submit class=\"button margin5\"><i class=\"fa fa-plus\"></i> ".pcrtlang("Set Custom Price")."</button>";

#########
echo "</form>";

stop_box();


echo "</div>";

} else {
echo "<br><span class=\"colormered sizemesmaller\">$rs_discountname - ".pcrtlang("was")." $money$rs_origprice</span>";

echo "<div id=cartitemd$rs_cart_item_id style=\"display:none;\"><br>";

echo "<a href=\"cart.php?func=removediscount&cart_item_id=$rs_cart_item_id\" class=\"catchcartarealink linkbutton\"><img src=images/remdiscount.png border=0 align=absmiddle width=16> ".pcrtlang("remove discount")."</a>";
echo "</div>";
}

?>
<script type='text/javascript'>
$('#cartitemlink<?php echo "$rs_cart_item_id"; ?>').click(function(){
  $('#cartitemd<?php echo "$rs_cart_item_id"; ?>').toggle('1000');
  $("i",this).toggleClass("fa-chevron-up fa-chevron-down");
  $('#cartitem<?php echo "$rs_cart_item_id"; ?>').toggle('1000');

});
</script>
<?php



echo "</td>";

echo "<td style=\"width:5%;text-align:right\">".qf("$rs_quantity")."</td>";
echo "<td style=\"width:10%;text-align:right\">$money".mf("$rs_unit_price")."</td>";

echo "<td style=\"width:15%;text-align:right\">$money".mf("$rs_cart_price")."<br><span class=sizemesmaller>$t_tax: $money".mf("$rs_itemtax")."</span></td></tr>";


}



}


echo "<tr><th colspan=5>".pcrtlang("Labor")."</th></tr>";

$rs_find_cart_labor = "SELECT * FROM cart WHERE cart_type = 'labor' AND ipofpc = '$ipofpc' ORDER BY addtime ASC";
$rs_result_labor = mysqli_query($rs_connect, $rs_find_cart_labor);

if (mysqli_num_rows($rs_result_labor) == 0) {
echo "<tr><td style=\"width:20%;\">&nbsp;</td><td colspan=4 style=\"width:80%;text-align:left;\"><span class=\"italme colormegray\">".pcrtlang("No Labor Items")."</span></td></tr>";
} else {
echo "<tr>";
echo "<td style=\"width:20%\" class=subhead>&nbsp</td>";
echo "<td style=\"width:50%\" class=subhead>".pcrtlang("Labor Description")."</td>";
echo "<td style=\"width:5%\" class=subhead>".pcrtlang("Qty")."</td>";
echo "<td style=\"width:10%\" class=subhead>".pcrtlang("Unit Price")."</td>";
echo "<td style=\"width:15%\" class=subhead>".pcrtlang("Total")."</td>";
echo "</tr>";

}


while($rs_result_labor_q = mysqli_fetch_object($rs_result_labor)) {
$rs_cart_labor_id = "$rs_result_labor_q->cart_item_id";
$rs_cart_labor_price = "$rs_result_labor_q->cart_price";
$rs_cart_labor_type = "$rs_result_labor_q->cart_type";
$rs_cart_labor_desc = "$rs_result_labor_q->labor_desc";
$rs_cart_printdesc = "$rs_result_labor_q->printdesc";
$rs_labprice_alt = "$rs_result_labor_q->price_alt";
$rs_taxex = "$rs_result_labor_q->taxex";
$rs_labortax = "$rs_result_labor_q->itemtax";
$rs_cart_labor_origprice = mf("$rs_result_labor_q->origprice");
$rs_cart_labor_unit_price = "$rs_result_labor_q->unit_price";
$rs_cart_labor_quantity = "$rs_result_labor_q->quantity";
$rs_cart_labor_discountname = "$rs_result_labor_q->discountname";

#newtaxcode
$servicetaxrate = getservicetaxrate($rs_taxex);
$isgrouprate = isgrouprate($rs_taxex);

if($isgrouprate == 0) {
if(!array_key_exists("$rs_taxex", $mastertaxtotals)) {
$mastertaxtotals[$rs_taxex]['parts'] = 0;
$mastertaxtotals[$rs_taxex]['labor'] = $servicetaxrate * $rs_cart_labor_price;
$mastertaxtotals[$rs_taxex]['return'] = 0;
$mastertaxtotals[$rs_taxex]['refundlabor'] = 0;
} else {
$mastertaxtotals[$rs_taxex]['labor'] = ($servicetaxrate * $rs_cart_labor_price) + $mastertaxtotals[$rs_taxex]['labor'];
}
} else {
$grouprates = getgrouprates($rs_taxex);
foreach($grouprates as $key => $val) {
$servicetaxratei = getservicetaxrate($val);

if(!array_key_exists("$val", $mastertaxtotals)) {
$mastertaxtotals[$val]['parts'] = 0;
$mastertaxtotals[$val]['labor'] = $servicetaxratei * $rs_cart_labor_price;
$mastertaxtotals[$val]['return'] = 0;
$mastertaxtotals[$val]['refundlabor'] = 0;
} else {
$mastertaxtotals[$val]['labor'] = ($servicetaxratei * $rs_cart_labor_price) + $mastertaxtotals[$val]['labor'];
}

}
}
####




echo "<tr><td style=\"width:20%;vertical-align:top\">";

$rs_cart_labor_unit_price2 = urlencode("$rs_cart_labor_unit_price");
$rs_cart_labor_desc2 = urlencode("$rs_cart_labor_desc");
$rs_cart_printdesc2 = urlencode("$rs_cart_printdesc");
$rs_cart_labor_quantity2 = urlencode("$rs_cart_labor_quantity");

echo "<a href=\"javascript:void(0);\" class=\"linkbuttonmoney linkbuttonmedium radiusleft\" style=\"text-align:center;\"  id=cartitemlink$rs_cart_labor_id><i class=\"fa fa-chevron-down\"></i></a>";


echo "<a href=cart.php?func=edit&cart_item_id=$rs_cart_labor_id&rs_cart_price=$rs_cart_labor_unit_price2&rs_taxex=$rs_taxex&rs_cart_type=$rs_cart_labor_type&itemdesc=$rs_cart_labor_desc2&price_alt=$rs_labprice_alt&serial=&cost=0&qty=$rs_cart_labor_quantity2&printdesc=$rs_cart_printdesc2 $therel class=\"linkbuttonmoney linkbuttonmedium\"><i class=\"fa fa-edit fa-lg\"></i></a>";

echo "<a href=cart.php?func=remove_cart_item&cart_item_id=$rs_cart_labor_id class=\"catchcartarealink linkbuttonred2 linkbuttonmedium\" style=\"display:none\"><i class=\"fa fa-check fa-lg\"></i></a>";
echo "<a href=\"javascript:void(0);\" class=\"deletereveal linkbuttonmoney linkbuttonmedium radiusright\"><i class=\"fa fa-trash fa-lg\"></i></a>";

echo "<div id=cartitem$rs_cart_labor_id style=\"display:none;\"><br>";

$rs_find_tax = "SELECT * FROM taxes WHERE taxenabled = '1' ORDER BY taxname ASC";
$rs_result_tax = mysqli_query($rs_connect, $rs_find_tax);
echo "<form method=post action=cart.php?func=setitemtax class=catchcartareaformonchange><input type=hidden name=cart_item_id value=$rs_cart_labor_id><select name=settaxid class=selects>";

while($rs_result_tq = mysqli_fetch_object($rs_result_tax)) {
$rs_taxname = "$rs_result_tq->taxname";
$rs_taxid = "$rs_result_tq->taxid";

if ($rs_taxid == $rs_taxex) {
echo "<option selected value=$rs_taxid>$rs_taxname</option>";
} else {
echo "<option value=$rs_taxid>$rs_taxname</option>";
}
}
echo "</select><input type=hidden name=cartitemtype value=labor></form>";

echo "</div>";


echo "</td><td style=\"width:50%;\" valign=top>$rs_cart_labor_desc";

if($rs_cart_printdesc != "") {
echo "<br><br><div class=leftindent>".nl2br("$rs_cart_printdesc")."</div>";
}



if ($rs_labprice_alt != 1) {

echo "<div id=cartitemd$rs_cart_labor_id style=\"display:none;\"><br>";

start_box();
echo "<span class=boldme>".pcrtlang("Percentage Discount")."</span>";
echo "<br><form method=post action=cart.php?func=discount_cart_item class=catchcartareaform><input type=hidden name=cart_item_id value=$rs_cart_labor_id><input type=hidden name=rs_taxex value=$rs_taxex>";
echo "<input type=hidden name=carttype value=labor><input type=hidden name=qty value=$rs_cart_labor_quantity>";
echo "<input type=text style=\"width:100px;\" placeholder=\"".pcrtlang("Percentage")."\" class=\"textbox margin5\" name=rs_dis_percent id=percentdiscount$rs_cart_labor_id><i class=\"fa fa-percent\"></i>";

echo "<input type=text name=discountname id=discountname$rs_cart_labor_id class=\"textbox margin5\" style=\"width:125px;\" placeholder=\"".pcrtlang("Enter Discount Name")."\">";

echo "<select name=myoptions class=margin5 onchange='document.getElementById(\"percentdiscount$rs_cart_labor_id\").value=this.options[this.selectedIndex].value;document.getElementById(\"discountname$rs_cart_labor_id\").value=this.options[this.selectedIndex].text'>";
$rs_ql = "SELECT * FROM discounts WHERE discounttype = '1' ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
echo "<option value=\"\">".pcrtlang("Choose Discount")."</option>";
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$discountid = "$rs_result_q1->discountid";
$discounttitle = "$rs_result_q1->discounttitle";
$discountamount = "$rs_result_q1->discountamount";
$discounttype = "$rs_result_q1->discounttype";
echo "<option value=\"".mf("$discountamount")."\">$discounttitle</option>";
}
echo "</select>";

echo "<br><button type=reset class=\"button margin5\"><i class=\"fa fa-eraser\"></i> ".pcrtlang("Reset")."</button>";
echo "<button type=submit class=\"button margin5\"><i class=\"fa fa-plus\"></i> ".pcrtlang("Add Discount")."</button>";

echo "</form>";

stop_box();
echo "<br>";
start_box();
echo "<span class=boldme>".pcrtlang("Nominal Discount")."</span><br>";
echo "<form method=post action=cart.php?func=custom_price class=catchcartareaform><input type=hidden name=cart_item_id value=$rs_cart_labor_id><input type=hidden name=rs_taxex value=$rs_taxex>";
echo "<input type=hidden name=carttype value=\"$rs_cart_labor_type\"><input type=hidden name=qty value=$rs_cart_labor_quantity>";
echo "$money<input style=\"width:75px\" type=text class=\"textbox margin5\" name=custom_price id=customprice$rs_cart_labor_id value=\"".mf("$rs_cart_labor_unit_price")."\">";
echo "<input type=text name=discountname id=discountnamen$rs_cart_labor_id class=\"textbox margin5\" style=\"width:125px%;\" placeholder=\"".pcrtlang("Enter Discount Name")."\">";

################

echo "<select name=myoptions class=\"margin5\" onchange='document.getElementById(\"customprice$rs_cart_labor_id\").value=($rs_cart_labor_unit_price"." - this.options[this.selectedIndex].value).toFixed(2); document.getElementById(\"discountnamen$rs_cart_labor_id\").value=this.options[this.selectedIndex].text'>";
$rs_ql = "SELECT * FROM discounts WHERE discounttype = '2' AND discountamount <= '$rs_cart_labor_unit_price' ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
echo "<option value=\"\">".pcrtlang("Choose Discount")."</option>";
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$discountid = "$rs_result_q1->discountid";
$discounttitle = "$rs_result_q1->discounttitle";
$discountamount = "$rs_result_q1->discountamount";
$discounttype = "$rs_result_q1->discounttype";
echo "<option value=\"$discountamount\">$discounttitle</option>";
}
echo "</select>";

echo "<br><button type=reset class=\"button margin5\"><i class=\"fa fa-eraser\"></i> ".pcrtlang("Reset")."</button>";
echo "<button type=submit class=\"button margin5\"><i class=\"fa fa-plus\"></i> ".pcrtlang("Set Custom Price")."</button>";

#########
echo "</form>";

stop_box();

echo "</div>";

} else {
echo "<br><span class=\"colormered sizemesmaller\">$rs_cart_labor_discountname - ".pcrtlang("was")." $money$rs_cart_labor_origprice</span>";

echo "<div id=cartitemd$rs_cart_labor_id style=\"display:none;\"><br>";
echo "<a href=\"cart.php?func=removediscount&cart_item_id=$rs_cart_labor_id\" class=\"linkbutton catchcartarealink\"><img src=images/remdiscount.png border=0 align=absmiddle width=16> ".pcrtlang("remove discount")."</a>";
echo "</div>";

}


?>
<script type='text/javascript'>
$('#cartitemlink<?php echo "$rs_cart_labor_id"; ?>').click(function(){
  $('#cartitemd<?php echo "$rs_cart_labor_id"; ?>').toggle('1000');
  $("i",this).toggleClass("fa-chevron-up fa-chevron-down");
  $('#cartitem<?php echo "$rs_cart_labor_id"; ?>').toggle('1000');

});
</script>
<?php

echo "</td>";


echo "<td style=\"width:5%;text-align:right\">".qf("$rs_cart_labor_quantity")."</td>";
echo "<td style=\"width:10%;text-align:right\">$money".mf("$rs_cart_labor_unit_price")."</td>";

echo "<td style=\"width:15%;text-align:right\">$money".mf("$rs_cart_labor_price")."<br><span class=sizemesmaller>$t_tax: $money".mf("$rs_labortax")."</span></td></tr>";

}


$rs_find_cart_returns = "SELECT * FROM cart WHERE cart_type = 'refund' AND ipofpc = '$ipofpc' ORDER BY addtime ASC";
$rs_result_returns = mysqli_query($rs_connect, $rs_find_cart_returns);

$returncount = mysqli_num_rows($rs_result_returns);



$rs_find_cart_returns = "SELECT * FROM cart WHERE cart_type = 'refund' AND ipofpc = '$ipofpc' ORDER BY addtime ASC";
$rs_result_returns = mysqli_query($rs_connect, $rs_find_cart_returns);

$returncount = mysqli_num_rows($rs_result_returns);

if ($returncount == 0) {
#echo "<tr><td style=\"width:20%\">&nbsp;</td><td  style=\"width:50%\" colspan=4 style=\"text-align:left;\"><span class=\"italme colormegray\">".pcrtlang("No Return Items")."</span></td></tr>";
} else {
echo "<tr><th colspan=5>".pcrtlang("Returned Items")."</th></tr>";
echo "<tr>";
echo "<td style=\"width:20%\" class=subhead>&nbsp</td>";
echo "<td style=\"width:50%\" class=subhead>".pcrtlang("Item Description")."</td>";
echo "<td style=\"width:5%\" class=subhead>".pcrtlang("Qty")."</td>";
echo "<td style=\"width:10%\" class=subhead>".pcrtlang("Unit Price")."</td>";
echo "<td style=\"width:15%\" class=subhead>".pcrtlang("Total")."</td>";
echo "</tr>";
}


while($rs_result_returns_q = mysqli_fetch_object($rs_result_returns)) {
$rs_cart_return_id = "$rs_result_returns_q->cart_item_id";
$rs_cart_return_price = "$rs_result_returns_q->cart_price";
$rs_stock_return_id = "$rs_result_returns_q->cart_stock_id";
$rs_restocking_fee = "$rs_result_returns_q->restocking_fee";
$rs_return_sold_id = "$rs_result_returns_q->return_sold_id";
$rs_return_noninvitem = "$rs_result_returns_q->labor_desc";
$rs_return_taxex = "$rs_result_returns_q->taxex";
$rs_return_itemtax = "$rs_result_returns_q->itemtax";
$rs_return_unit_price = "$rs_result_returns_q->unit_price";
$rs_return_quantity = "$rs_result_returns_q->quantity";

#newtaxcode
$salestaxrate = getsalestaxrate($rs_return_taxex);
$isgrouprate = isgrouprate($rs_return_taxex);

if($isgrouprate == 0) {
if(!array_key_exists("$rs_return_taxex", $mastertaxtotals)) {
$mastertaxtotals[$rs_return_taxex]['parts'] = 0;
$mastertaxtotals[$rs_return_taxex]['labor'] = 0;
$mastertaxtotals[$rs_return_taxex]['return'] = $salestaxrate * $rs_cart_return_price;
$mastertaxtotals[$rs_return_taxex]['refundlabor'] = 0;
} else {
$mastertaxtotals[$rs_return_taxex]['return'] = ($salestaxrate * $rs_cart_return_price) + $mastertaxtotals[$rs_return_taxex]['return'];
}
} else {
$grouprates = getgrouprates($rs_return_taxex);
foreach($grouprates as $key => $val) {
$salestaxratei = getsalestaxrate($val);

if(!array_key_exists("$val", $mastertaxtotals)) {
$mastertaxtotals[$val]['parts'] = 0;
$mastertaxtotals[$val]['labor'] = 0;
$mastertaxtotals[$val]['return'] = $salestaxratei * $rs_cart_return_price;
$mastertaxtotals[$val]['refundlabor'] = 0;
} else {
$mastertaxtotals[$val]['return'] = ($salestaxratei * $rs_cart_return_price) + $mastertaxtotals[$val]['return'];
}

}
}
####




$return_taxname = gettaxname($rs_return_taxex);

if ($rs_stock_return_id != "0") {
$rs_find_return_detail = "SELECT * FROM stock WHERE stock_id = '$rs_stock_return_id'";
$rs_find_return_result = mysqli_query($rs_connect, $rs_find_return_detail);
while($rs_find_result_return_q = mysqli_fetch_object($rs_find_return_result)) {
$rs_return_stocktitle = "$rs_find_result_return_q->stock_title";
echo "<tr><td style=\"width:20%;\"><a href=cart.php?func=remove_cart_item&cart_item_id=$rs_cart_return_id&rs_return_sold_id=$rs_return_sold_id class=\"catchcartarealink linkbuttonmoney linkbuttonsmall radiusall\"><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Remove")."</a></td>";
echo "<td style=\"width:50%;\">$rs_return_stocktitle";

if ($rs_restocking_fee == 'yes') {
echo "<span class=\"sizemesmaller italme\"><br>".pcrtlang("Subject to 20% Restocking Fee")."</span>";
} elseif ($rs_restocking_fee == '5per') {
echo "<span class=\"sizemesmaller italme\"><br>".pcrtlang("Subject to 5% Restocking Fee")."</span>";
}
echo "</td><td style=\"width:5%;\">".qf("$rs_return_quantity")."</td><td style=\"width:10%\">$money".mf("$rs_return_unit_price")."</td><td style=\"width:15%;text-align:right\">$money".mf("$rs_cart_return_price")."<br>".pcrtlang("Refunded")." $t_tax: ".mf("$rs_return_itemtax")."</td></tr>";
}

} else {

echo "<tr><td style=\"width:20%\"><a href=cart.php?func=remove_cart_item&cart_item_id=$rs_cart_return_id&rs_return_sold_id=$rs_return_sold_id class=\"catchcartarealink linkbuttonmoney linkbuttonsmall radiusall\"><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Remove")."</a></td>";
echo "<td style=\"width:50%;\">$rs_return_noninvitem";

if ($rs_restocking_fee == 'yes') {
echo "<span class=\"sizemesmaller italme\"><br>".pcrtlang("Subject to 20% Restocking Fee")."</span>";
} elseif ($rs_restocking_fee == '5per') {
echo "<span class=\"sizemesmaller italme\"><br>".pcrtlang("Subject to 5% Restocking Fee")."</span>";
}
echo "</td><td style=\"width:5%\">".qf("$rs_return_quantity")."</td><td style=\"width:10%\">$money".mf("$rs_return_unit_price")."</td><td style=\"width:15%;text-align:right\">$money".mf("$rs_cart_return_price")."<br><span class=sizemesmaller>".pcrtlang("Refunded")." $t_tax: ".mf("$rs_return_itemtax")."</span></td></tr>";


}


}


##### # labor refund

$rs_find_cart_refundlabor = "SELECT * FROM cart WHERE cart_type = 'refundlabor' AND ipofpc = '$ipofpc' ORDER BY addtime ASC";
$rs_result_refundlabor = mysqli_query($rs_connect, $rs_find_cart_refundlabor);

$refundlaborcount = mysqli_num_rows($rs_result_refundlabor);

if ($refundlaborcount == 0) {
#echo "<tr><td style=\"width:20%\">&nbsp;</td><td style=\"width:80%\" colspan=4 style=\"text-align:left;\"><span class=\"italme colormegray\">".pcrtlang("No Labor Refunds")."</span></td></tr>";
} else {
echo "<tr><th colspan=5>".pcrtlang("Refunded Labor")."</th></tr>";
echo "<tr>";
echo "<td style=\"width:20%\" class=subhead>&nbsp</td>";
echo "<td style=\"width:50%\" class=subhead>".pcrtlang("Labor Description")."</td>";
echo "<td style=\"width:5%\" class=subhead>".pcrtlang("Qty")."</td>";
echo "<td style=\"width:10%\" class=subhead>".pcrtlang("Unit Price")."</td>";
echo "<td style=\"width:15%\" class=subhead>".pcrtlang("Total")."</td>";
echo "</tr>";
}


while($rs_result_refundlabor_q = mysqli_fetch_object($rs_result_refundlabor)) {
$rs_cart_refundlabor_id = "$rs_result_refundlabor_q->cart_item_id";
$rs_cart_refundlabor_price = "$rs_result_refundlabor_q->cart_price";
$rs_refundlabor_sold_id = "$rs_result_refundlabor_q->return_sold_id";
$rs_refundlabor_labordesc = "$rs_result_refundlabor_q->labor_desc";
$rs_refundlabor_taxex = "$rs_result_refundlabor_q->taxex";
$rs_refundlabor_itemtax = "$rs_result_refundlabor_q->itemtax";
$rs_refundlabor_unit_price = "$rs_result_refundlabor_q->unit_price";
$rs_refundlabor_quantity = "$rs_result_refundlabor_q->quantity";



#newtaxcode
$servicetaxrate = getservicetaxrate($rs_refundlabor_taxex);
$isgrouprate = isgrouprate($rs_refundlabor_taxex);

if($isgrouprate == 0) {
if(!array_key_exists("$rs_refundlabor_taxex", $mastertaxtotals)) {
$mastertaxtotals[$rs_refundlabor_taxex]['parts'] = 0;
$mastertaxtotals[$rs_refundlabor_taxex]['labor'] = 0;
$mastertaxtotals[$rs_refundlabor_taxex]['return'] = 0;
$mastertaxtotals[$rs_refundlabor_taxex]['refundlabor'] = $servicetaxrate * $rs_cart_refundlabor_price;
} else {
$mastertaxtotals[$rs_refundlabor_taxex]['refundlabor'] = ($servicetaxrate * $rs_cart_refundlabor_price) + $mastertaxtotals[$rs_refundlabor_taxex]['return'];
}
} else {
$grouprates = getgrouprates($rs_refundlabor_taxex);
foreach($grouprates as $key => $val) {
$servicetaxratei = getservicetaxrate($val);

if(!array_key_exists("$val", $mastertaxtotals)) {
$mastertaxtotals[$val]['parts'] = 0;
$mastertaxtotals[$val]['labor'] = 0;
$mastertaxtotals[$val]['return'] = 0;
$mastertaxtotals[$val]['refundlabor'] = $servicetaxratei * $rs_cart_refundlabor_price;
} else {
$mastertaxtotals[$val]['refundlabor'] = ($servicetaxratei * $rs_cart_refundlabor_price) + $mastertaxtotals[$val]['refundlabor'];
}

}
}
####
$refundlabor_taxname = gettaxname($rs_refundlabor_taxex);

echo "<tr><td style=\"width:20%\"><a href=cart.php?func=remove_cart_item&cart_item_id=$rs_cart_refundlabor_id&rs_return_sold_id=$rs_refundlabor_sold_id class=\"catchcartarealink linkbuttonmoney linkbuttonsmall radiusall\"><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("Remove")."</a></td>";
echo "<td style=\"width:50%\">$rs_refundlabor_labordesc";

echo "</td><td style=\"width:5%\">".qf("$rs_refundlabor_quantity")."</td><td style=\"width:10%\">$money".mf("$rs_refundlabor_unit_price")."</td><td style=\"width:15%;text-align:right\">$money".mf("$rs_cart_refundlabor_price")."<br><span class=sizemesmaller>".pcrtlang("Refunded")." $t_tax: $money".mf("$rs_refundlabor_itemtax")."</span></td></tr>";





}


##### #



$rs_find_item_total = "SELECT SUM(cart_price) AS total_price_parts FROM cart WHERE cart_type = 'purchase' AND ipofpc = '$ipofpc'";
$rs_find_result_total = mysqli_query($rs_connect, $rs_find_item_total);

while($rs_find_result_total_q = mysqli_fetch_object($rs_find_result_total)) {
$rs_total_parts = "$rs_find_result_total_q->total_price_parts";

if ($rs_total_parts == "") {
$rs_total_parts = "0.00";
}

echo "<tr><td style=\"width:20%;\">&nbsp;</td><td colspan=3  style=\"width:65%\"><span class=floatright>".pcrtlang("Purchased Items Total").":</span></td><td style=\"width:15%;text-align:right\">$money".mf("$rs_total_parts")."</td></tr>";



$rs_find_itemtax_total = "SELECT SUM(itemtax) AS total_tax_parts FROM cart WHERE cart_type = 'purchase' AND ipofpc = '$ipofpc'";
$rs_find_result_taxtotal = mysqli_query($rs_connect, $rs_find_itemtax_total);
while($rs_find_result_taxtotal_q = mysqli_fetch_object($rs_find_result_taxtotal)) {
$rs_total_partstax = "$rs_find_result_taxtotal_q->total_tax_parts";


if ($rs_total_partstax > 0) {

foreach($mastertaxtotals as $key => $val) {
$taxname = gettaxshortname($key);
$taxtotal = $mastertaxtotals[$key]['parts'];
if($taxtotal != 0) {
echo "<tr><td style=\"width:20%\"></td><td colspan=3  style=\"width:65%\"><span class=\"sizemesmaller boldme floatright\">$taxname:</span></td><td style=\"width:15%;text-align:right\"><span class=\"sizemesmaller\">$money".mf("$taxtotal")."</span></td></tr>";
}
}

echo "<tr><td style=\"width:20%\">&nbsp;</td><td colspan=3 style=\"width:65%\"><span class=floatright>".pcrtlang("Total Purchased Items")." $t_tax:</span></td><td style=\"width:15%;text-align:right\">$money".mf("$rs_total_partstax")."</td></tr>";
}
}
}




$rs_find_labor_total = "SELECT SUM(cart_price) AS total_labor_price FROM cart WHERE cart_type = 'labor' AND ipofpc = '$ipofpc'";
$rs_find_result_labor_total = mysqli_query($rs_connect, $rs_find_labor_total);
while($rs_find_result_labor_total_q = mysqli_fetch_object($rs_find_result_labor_total)) {
$rs_total_labor = "$rs_find_result_labor_total_q->total_labor_price";

if ($rs_total_labor == "") {
$rs_total_labor = "0.00";
}



echo "<tr><td style=\"width:20%\">&nbsp;</td><td colspan=3 style=\"width:65%\"><span class=floatright>".pcrtlang("Labor Total").":</float></td><td style=\"width:15%;text-align:right\">$money".mf("$rs_total_labor")."</td></tr>";

$rs_find_labortax_total = "SELECT SUM(itemtax) AS total_labortax_price FROM cart WHERE cart_type = 'labor' AND ipofpc = '$ipofpc'";
$rs_find_result_taxlabor_total = mysqli_query($rs_connect, $rs_find_labortax_total);
while($rs_find_result_labortax_total_q = mysqli_fetch_object($rs_find_result_taxlabor_total)) {
$rs_total_labortax = "$rs_find_result_labortax_total_q->total_labortax_price";

if ($rs_total_labortax > 0) {

reset($mastertaxtotals);
foreach($mastertaxtotals as $key => $val) {
$taxname = gettaxshortname($key);
$taxtotal = $mastertaxtotals[$key]['labor'];
if($taxtotal != 0) {
echo "<tr><td style=\"width:20%\"></td><td colspan=3 style=\"width:65%\"><span class=\"sizemesmaller boldme floatright\">$taxname:</span></td><td style=\"width:15%;text-align:right\"><span class=\"sizemesmaller\">$money".mf("$taxtotal")."</span></td></tr>";
}
}


echo "<tr><td style=\"width:20%\">&nbsp;</td><td colspan=3 style=\"width:65%\"><span class=floatright>".pcrtlang("Total Labor")." $t_tax:</span></td><td style=\"width:15%;text-align:right\">$money".mf("$rs_total_labortax")."</td></tr>";
}
}



}


$rs_find_refund_total = "SELECT SUM(cart_price) AS total_price_parts FROM cart WHERE cart_type = 'refund' AND ipofpc = '$ipofpc'";
$rs_find_result_refund_total = mysqli_query($rs_connect, $rs_find_refund_total);
while($rs_find_result_refund_total_q = mysqli_fetch_object($rs_find_result_refund_total)) {
$rs_total_refund = "$rs_find_result_refund_total_q->total_price_parts";


if ($rs_total_refund == "") {
$rs_total_refund = "0.00";
}

if ($rs_total_refund != "0") {
echo "<tr><td style=\"width:20%;text-align:right\">&nbsp;</td><td colspan=3 style=\"width:65%\"><span class=floatright>".pcrtlang("Returned Items Total").":</span></td><td style=\"width:15%;text-align:right\">$money".mf("$rs_total_refund")."</td></tr>";
}

$rs_find_refund_totalref = "SELECT SUM(itemtax) AS total_price_partsref FROM cart WHERE cart_type = 'refund' AND ipofpc = '$ipofpc'";
$rs_find_result_refund_totalref = mysqli_query($rs_connect, $rs_find_refund_totalref);
while($rs_find_result_refund_totalref_q = mysqli_fetch_object($rs_find_result_refund_totalref)) {
$rs_total_refundtax = "$rs_find_result_refund_totalref_q->total_price_partsref";

if ($rs_total_refundtax > 0) {

reset($mastertaxtotals);
foreach($mastertaxtotals as $key => $val) {
$taxname = gettaxshortname($key);
$taxtotal = $mastertaxtotals[$key]['return'];
if($taxtotal != 0) {
echo "<tr><td style=\"width:20%;\"></td><td colspan=3 style=\"width:65%\"><span class=\"sizemesmaller boldme floatright\">$taxname:</span></td><td style=\"width:15%\"><span class=\"sizemesmaller\">$money".mf("$taxtotal")."</span></td></tr>";
}
}

echo "<tr><td style=\"width:20%\">&nbsp;</td><td colspan=3 style=\"width:65%\"><span class=floatright>".pcrtlang("Total Refunded")." $t_tax:</span></td><td style=\"width:15%;text-align:right\">$money".mf("$rs_total_refundtax")."</td></tr>";
}

}

}


## #
$rs_find_refundlabor_total = "SELECT SUM(cart_price) AS total_price_refundlabor FROM cart WHERE cart_type = 'refundlabor' AND ipofpc = '$ipofpc'";
$rs_find_result_refundlabor_total = mysqli_query($rs_connect, $rs_find_refundlabor_total);
while($rs_find_result_refundlabor_total_q = mysqli_fetch_object($rs_find_result_refundlabor_total)) {
$rs_total_refundlabor = "$rs_find_result_refundlabor_total_q->total_price_refundlabor";

if ($rs_total_refundlabor == "") {
$rs_total_refundlabor = "0.00";
}
if ($rs_total_refundlabor != "0") {
echo "<tr><td style=\"width:20%\">&nbsp;</td><td colspan=3 style=\"width:65%\"><span class=floatright>".pcrtlang("Refunded Labor Total").":</span></td><td style=\"width:15%;text-align:right\">$money".mf("$rs_total_refundlabor")."</td></tr>";
}

$rs_find_refundlabor_totalref = "SELECT SUM(itemtax) AS total_price_refundlabor FROM cart WHERE cart_type = 'refundlabor' AND ipofpc = '$ipofpc'";
$rs_find_result_refundlabor_totalref = mysqli_query($rs_connect, $rs_find_refundlabor_totalref);
while($rs_find_result_refundlabor_totalref_q = mysqli_fetch_object($rs_find_result_refundlabor_totalref)) {
$rs_total_refundlabortax = "$rs_find_result_refundlabor_totalref_q->total_price_refundlabor";
if ($rs_total_refundlabortax > 0) {

reset($mastertaxtotals);
foreach($mastertaxtotals as $key => $val) {
$taxname = gettaxshortname($key);
$taxtotal = $mastertaxtotals[$key]['refundlabor'];
if($taxtotal != 0) {
echo "<tr><td style=\"width:20%\"></td><td colspan=3 style=\"width:65%\"><span class=\"sizemesmaller boldme floatright\">$taxname:</span></td><td style=\"width:15%;text-align:right\"><span class=\"sizemesmaller\">$money".mf("$taxtotal")."</span></td></tr>";
}
}

echo "<tr><td style=\"width:20%;\">&nbsp;</td><td colspan=3 style=\"width:65%\"><span class=floatright>".pcrtlang("Total Refunded Labor")." $t_tax:</span></td><td style=\"width:15%;text-align:right\">$money".mf("$rs_total_refundlabortax")."</td></tr>";
}

}

}


## #

$rs_total_partstax = tnv($rs_total_partstax);
$rs_total_parts = tnv($rs_total_parts);
$rs_total_labortax = tnv($rs_total_labortax);
$rs_total_labor = tnv($rs_total_labor);
$rs_total_refundtax = tnv($rs_total_refundtax);
$rs_total_refund = tnv($rs_total_refund);
$rs_total_refundlabor = tnv($rs_total_refundlabor);
$rs_total_refundlabortax = tnv($rs_total_refundlabortax);


$grand_total = mf(($rs_total_partstax + $rs_total_parts + $rs_total_labortax + $rs_total_labor) - ($rs_total_refundtax + $rs_total_refund +
$rs_total_refundlabor + $rs_total_refundlabortax));

$paidtax = (($rs_total_partstax + $rs_total_labortax) - ($rs_total_refundtax + $rs_total_refundlabortax));
$abstax = mf("$paidtax");



if ($grand_total >= 0){
echo "<tr><td style=\"width:20%\"></td><td colspan=3 style=\"width:65%\"><span class=\"sizemelarger floatright\">".pcrtlang("Grand Total").":</span></td><td style=\"width:15%;text-align:right\"><span class=sizemelarger>$money".mf("$grand_total")."</span></td></tr>";
} else {
$refund_total = abs($grand_total);
echo "<tr><td style=\"width:20%\">&nbsp;</td><td colspan=3 style=\"width:65%\"><span class=\"sizemelarger colormered floatright\">".pcrtlang("Refund").":</span></td><td style=\"width:15%;text-align:right\"><span class=sizemelarger>$money".mf("$refund_total")."</span></td></tr>";
}


echo "</table>";

?>

<script type='text/javascript'>
$(document).ready(function(){
$('.catchcartarealink').click(function(e) { // catch the form's submit event
        e.preventDefault();
		 $('.ajaxspinner').toggle();
                var url = $(this).attr('href');
                $.get(url, function () {
                $.get('cart.php?func=cartarea', function(data) {
                $('#cartarea').html(data);
                });
                $.get('cart.php?func=paymentsarea', function(data) {
                $('#paymentsarea').html(data);
                });
                $.get('cart.php?func=customerarea', function(data) {
                $('#customerarea').html(data);
                });
                $.get('cart.php?func=paymentmethodsarea', function(data) {
                $('#paymentmethodsarea').html(data);
                });
                $.get('cart.php?func=newinvoicearea', function(data) {
                $('#newinvoicearea').html(data);
                });
                $.get('cart.php?func=cartfloaterarea', function(data) {
                $('#bottomnavbarfixedlight').html(data);
                });
		 $('.ajaxspinner').toggle();
    });
});
});
</script>

<script type='text/javascript'>
$(document).ready(function(){
$('.catchcartareaform').submit(function(e) { // catch the form's submit event
        e.preventDefault();
        $.ajax({ // create an AJAX call...
        data: $(this).serialize(), // get the form data
        type: $(this).attr('method'), // GET or POST
        url: $(this).attr('action'), // the file to call
        success: function(response) { // on success..
                $.get('cart.php?func=cartarea', function(data) {
                $('#cartarea').html(data);
                });
                $.get('cart.php?func=paymentsarea', function(data) {
                $('#paymentsarea').html(data);
                });
                $.get('cart.php?func=customerarea', function(data) {
                $('#customerarea').html(data);
                });
                $.get('cart.php?func=paymentmethodsarea', function(data) {
                $('#paymentmethodsarea').html(data);
                });
                $.get('cart.php?func=newinvoicearea', function(data) {
                $('#newinvoicearea').html(data);
                });
                $.get('cart.php?func=cartfloaterarea', function(data) {
                $('#bottomnavbarfixedlight').html(data);
                });
    }
    });
});
});
</script>

<script type='text/javascript'>
$(document).ready(function(){
$('.catchcartareaformonchange').change(function(e) { // catch the form's submit event
        e.preventDefault();
        $.ajax({ // create an AJAX call...
        data: $(this).serialize(), // get the form data
        type: $(this).attr('method'), // GET or POST
        url: $(this).attr('action'), // the file to call
        success: function(response) { // on success..
                $.get('cart.php?func=cartarea', function(data) {
                $('#cartarea').html(data);
                });
                $.get('cart.php?func=paymentsarea', function(data) {
                $('#paymentsarea').html(data);
                });
                $.get('cart.php?func=customerarea', function(data) {
                $('#customerarea').html(data);
                });
                $.get('cart.php?func=paymentmethodsarea', function(data) {
                $('#paymentmethodsarea').html(data);
                });
                $.get('cart.php?func=newinvoicearea', function(data) {
                $('#newinvoicearea').html(data);
                });
                $.get('cart.php?func=cartfloaterarea', function(data) {
                $('#bottomnavbarfixedlight').html(data);
                });
    }
    });
});
});
</script>

<script type="text/javascript">
$(".deletereveal").click(function(){
$(this).prev().toggle();
});
</script>


<?php

}



function customerarea() {
require_once("validate.php");
require("deps.php");
require("common.php");
require("headerincludes.php");


$findcurrentcustomer = "SELECT * FROM currentcustomer WHERE byuser = '$ipofpc'";
$findcurrentcustomerq = @mysqli_query($rs_connect, $findcurrentcustomer);

$existcust = mysqli_num_rows($findcurrentcustomerq);

if($existcust == 1) {
$findcurrentcustomera = mysqli_fetch_object($findcurrentcustomerq);
$cfirstname = "$findcurrentcustomera->cfirstname";
$ccompany = "$findcurrentcustomera->ccompany";
$caddress = "$findcurrentcustomera->caddress";
$caddress2 = "$findcurrentcustomera->caddress2";
$ccity = "$findcurrentcustomera->ccity";
$cstate = "$findcurrentcustomera->cstate";
$czip = "$findcurrentcustomera->czip";
$cphone = "$findcurrentcustomera->cphone";
$cemail = "$findcurrentcustomera->cemail";
$cwoid = "$findcurrentcustomera->woid";
$cinvoiceid = "$findcurrentcustomera->invoiceid";
$crinvoiceid = "$findcurrentcustomera->rinvoiceid";
$pcgroupid = "$findcurrentcustomera->pcgroupid";
} else {
$cfirstname = "";
$ccompany = "";
$caddress = "";
$caddress2 = "";
$ccity = "";
$cstate = "";
$czip = "";
$cphone = "";
$cemail = "";
$cwoid = "";
$cinvoiceid = "";
$crinvoiceid = "0";
$pcgroupid = "0";
}

$groupidarray = array();
if($pcgroupid != 0) {
$groupidarray[] = $pcgroupid;
}

$cfirstname_ue = urlencode($cfirstname);
$ccompany_ue = urlencode($ccompany);
$caddress_ue = urlencode($caddress);
$caddress2_ue = urlencode($caddress2);
$ccity_ue = urlencode($ccity);
$cstate_ue = urlencode($cstate);
$czip_ue = urlencode($czip);
$cphone_ue = urlencode($cphone);
$cemail_ue = urlencode($cemail);



#echo "<div class=\"sizemelarger\" style=\"text-align:center\">".pcrtlang("Customer")."</div><br>";

echo "<form action=cart.php?func=savecurrentcustomer id=catchsavecurrentcustomer method=post>";
echo "<table style=\"width:100%\">";
echo "<tr><td colspan=2>";
echo "<input style=\"width:100%;box-sizing:border-box;\" class=textboxw type=text name=cfirstname value=\"$cfirstname\" placeholder=\"".pcrtlang("Customer Name")."\"></td></tr>";
echo "<tr><td colspan=2><input style=\"width:100%;box-sizing:border-box;\" type=text class=textboxw name=ccompany value=\"$ccompany\" placeholder=\"".pcrtlang("Business Name")."\"></td></tr>";
echo "<tr><td colspan=2><input style=\"width:100%;box-sizing:border-box;\" type=text class=textboxw name=caddress value=\"$caddress\" placeholder=\"$pcrt_address1\"></td></tr>";
echo "<tr><td colspan=2><input style=\"width:100%;box-sizing:border-box;\" type=text class=textboxw name=caddress2 value=\"$caddress2\" placeholder=\"$pcrt_address2\"></td></tr>";
echo "<tr><td colspan=2><input style=\"width:100%;box-sizing:border-box;\" type=text class=textboxw name=ccity value=\"$ccity\" placeholder=\"$pcrt_city\">";
echo "<tr><td colspan=2><input style=\"width:100%;box-sizing:border-box;\" type=text class=textboxw name=cstate value=\"$cstate\" placeholder=\"$pcrt_state\">";
echo "<tr><td colspan=2><input style=\"width:100%;box-sizing:border-box;\" type=text class=textboxw name=czip value=\"$czip\" placeholder=\"$pcrt_zip\"></td></tr>";
echo "<tr><td colspan=2><input style=\"width:100%;box-sizing:border-box;\" type=text class=textboxw name=cphone value=\"$cphone\" placeholder=\"".pcrtlang("Customer Phone")."\"></td></tr>";
echo "<tr><td colspan=2><input style=\"width:100%;box-sizing:border-box;\" type=text class=textboxw name=cemail value=\"$cemail\" placeholder=\"".pcrtlang("Customer Email")."\"></td></tr>";

if ($cinvoiceid != "") {

$cinvoicelist = explode_list($cinvoiceid);
foreach($cinvoicelist as $key => $cinvoicelistids) {
$iorq = invoiceorquote($cinvoicelistids);
if ($iorq == "quote") {
$ilabel = pcrtlang("Quote");
} else {
$ilabel = pcrtlang("Invoice");
}
echo "<tr><td><span class=\"sizemesmaller boldme\">$ilabel:</span></td><td>#$cinvoicelistids</td></tr>";
$rs_find_invoice_ifrecur = "SELECT rinvoice_id FROM invoices WHERE invoice_id = '$cinvoicelistids'";
$rs_result_finv = mysqli_query($rs_connect, $rs_find_invoice_ifrecur);
while($rs_result_qfr = mysqli_fetch_object($rs_result_finv)) {
$rinvoicef = "$rs_result_qfr->rinvoice_id";
if($rinvoicef != 0) {
$rs_find_invoice_recur = "SELECT pcgroupid FROM rinvoices WHERE rinvoice_id = '$rinvoicef'";
$rs_result_frinv = mysqli_query($rs_connect, $rs_find_invoice_recur);
$rs_result_qfr = mysqli_fetch_object($rs_result_frinv);
$fpcgroupid = "$rs_result_qfr->pcgroupid";
if($fpcgroupid != 0) {
$groupidarray[] = "$fpcgroupid";
}
}
}





}

}

if ($cwoid != "") {
echo "<tr><td><span class=\"sizemesmaller boldme\">".pcrtlang("Work Order ID").":</span></td><td>";

$cwoidlist = explode_list($cwoid);
foreach($cwoidlist as $key => $cwoidlistids) {
echo "#$cwoidlistids ";

$rs_find_pc_ifgroup = "SELECT pcid FROM pc_wo WHERE woid = '$cwoidlistids'";
$rs_result_fpc = mysqli_query($rs_connect, $rs_find_pc_ifgroup);
while($rs_result_qfpc = mysqli_fetch_object($rs_result_fpc)) {
$pcidf = "$rs_result_qfpc->pcid";
$rs_find_grp = "SELECT pcgroupid FROM pc_owner WHERE pcid = '$pcidf'";
$rs_result_fpcg = mysqli_query($rs_connect, $rs_find_grp);
$rs_result_qfpcg = mysqli_fetch_object($rs_result_fpcg);
$fpcgroupid = "$rs_result_qfpcg->pcgroupid";
if($fpcgroupid != 0) {
$groupidarray[] = "$fpcgroupid";
}
}




}
echo "</td></tr>";
}


echo "<tr><td colspan=2><input type=hidden name=cinvoiceid value=\"$cinvoiceid\"><input type=hidden name=crinvoiceid value=\"$crinvoiceid\"><input type=hidden name=pcgroupid value=\"$pcgroupid\"><input type=hidden name=cwoid value=\"$cwoid\">";

echo "<button type=submit class=\"linkbuttongreen2 linkbuttonmedium radiusall\"><i class=\"fa fa-save\"></i> ".pcrtlang("Save")."</button>";


echo "<a href=\"cart.php?func=clearcurrentcustomer\" id=catchclearcurrentcustomer class=\"linkbuttonred2 linkbuttonmedium floatright radiusall\"><i class=\"fa fa-times\"></i> ".pcrtlang("Clear")."</a>";

echo "</td></tr></table></form>";

#wip


?>

<script type='text/javascript'>
$(document).ready(function(){
$('#catchsavecurrentcustomer').submit(function(e) { // catch the form's submit event
        e.preventDefault();
	 $('.ajaxspinner').toggle();
        $.ajax({ // create an AJAX call...
        data: $(this).serialize(), // get the form data
        type: $(this).attr('method'), // GET or POST
        url: $(this).attr('action'), // the file to call
        success: function(response) { // on success..
                $.get('cart.php?func=cartarea', function(data) {
                $('#cartarea').html(data);
                });
                $.get('cart.php?func=paymentsarea', function(data) {
                $('#paymentsarea').html(data);
                });
                $.get('cart.php?func=customerarea&saved=yes', function(data) {
                $('#customerarea').html(data);
		 $('.ajaxspinner').toggle();
                });
                $.get('cart.php?func=paymentmethodsarea', function(data) {
                $('#paymentmethodsarea').html(data);
                });
                $.get('cart.php?func=newinvoicearea', function(data) {
                $('#newinvoicearea').html(data);
                });
                $.get('cart.php?func=cartfloaterarea', function(data) {
                $('#bottomnavbarfixedlight').html(data);
                });
    }
    });
});
});
</script>

<script type='text/javascript'>
$(document).ready(function(){
$('#catchclearcurrentcustomer').click(function(e) { // catch the form's submit event
        e.preventDefault();
		 $('.ajaxspinner').toggle();
                var url = $(this).attr('href');
                $.get(url, function () {
                $.get('cart.php?func=cartarea', function(data) {
                $('#cartarea').html(data);
                });
                $.get('cart.php?func=paymentsarea', function(data) {
                $('#paymentsarea').html(data);
                });
                $.get('cart.php?func=customerarea&saved=yes', function(data) {
                $('#customerarea').html(data);
                });
                $.get('cart.php?func=paymentmethodsarea', function(data) {
                $('#paymentmethodsarea').html(data);
                });
                $.get('cart.php?func=newinvoicearea', function(data) {
                $('#newinvoicearea').html(data);
                });
                $.get('cart.php?func=cartfloaterarea', function(data) {
                $('#bottomnavbarfixedlight').html(data);
                });
		 $('.ajaxspinner').toggle();
    });
});
});
</script>


<?php



}


function paymentmethodsarea() {
require_once("validate.php");
require("deps.php");
require("common.php");
require("headerincludes.php");

$rs_find_item_total = "SELECT SUM(cart_price) AS total_price_parts FROM cart WHERE cart_type = 'purchase' AND ipofpc = '$ipofpc'";
$rs_find_result_total = mysqli_query($rs_connect, $rs_find_item_total);

$rs_find_result_total_q = mysqli_fetch_object($rs_find_result_total);
$rs_total_parts = "$rs_find_result_total_q->total_price_parts";

if ($rs_total_parts == "") {
$rs_total_parts = "0.00";
}

$rs_find_itemtax_total = "SELECT SUM(itemtax) AS total_tax_parts FROM cart WHERE cart_type = 'purchase' AND ipofpc = '$ipofpc'";
$rs_find_result_taxtotal = mysqli_query($rs_connect, $rs_find_itemtax_total);
$rs_find_result_taxtotal_q = mysqli_fetch_object($rs_find_result_taxtotal);
$rs_total_partstax = "$rs_find_result_taxtotal_q->total_tax_parts";

$rs_find_labor_total = "SELECT SUM(cart_price) AS total_labor_price FROM cart WHERE cart_type = 'labor' AND ipofpc = '$ipofpc'";
$rs_find_result_labor_total = mysqli_query($rs_connect, $rs_find_labor_total);
$rs_find_result_labor_total_q = mysqli_fetch_object($rs_find_result_labor_total);
$rs_total_labor = "$rs_find_result_labor_total_q->total_labor_price";

if ($rs_total_labor == "") {
$rs_total_labor = "0.00";
}


$rs_find_labortax_total = "SELECT SUM(itemtax) AS total_labortax_price FROM cart WHERE cart_type = 'labor' AND ipofpc = '$ipofpc'";
$rs_find_result_taxlabor_total = mysqli_query($rs_connect, $rs_find_labortax_total);
$rs_find_result_labortax_total_q = mysqli_fetch_object($rs_find_result_taxlabor_total);
$rs_total_labortax = "$rs_find_result_labortax_total_q->total_labortax_price";


$rs_find_refund_total = "SELECT SUM(cart_price) AS total_price_parts FROM cart WHERE cart_type = 'refund' AND ipofpc = '$ipofpc'";
$rs_find_result_refund_total = mysqli_query($rs_connect, $rs_find_refund_total);
$rs_find_result_refund_total_q = mysqli_fetch_object($rs_find_result_refund_total);
$rs_total_refund = "$rs_find_result_refund_total_q->total_price_parts";


if ($rs_total_refund == "") {
$rs_total_refund = "0.00";
}

$rs_find_refund_totalref = "SELECT SUM(itemtax) AS total_price_partsref FROM cart WHERE cart_type = 'refund' AND ipofpc = '$ipofpc'";
$rs_find_result_refund_totalref = mysqli_query($rs_connect, $rs_find_refund_totalref);
$rs_find_result_refund_totalref_q = mysqli_fetch_object($rs_find_result_refund_totalref);
$rs_total_refundtax = "$rs_find_result_refund_totalref_q->total_price_partsref";

$rs_find_refundlabor_total = "SELECT SUM(cart_price) AS total_price_refundlabor FROM cart WHERE cart_type = 'refundlabor' AND ipofpc = '$ipofpc'";
$rs_find_result_refundlabor_total = mysqli_query($rs_connect, $rs_find_refundlabor_total);
$rs_find_result_refundlabor_total_q = mysqli_fetch_object($rs_find_result_refundlabor_total);
$rs_total_refundlabor = "$rs_find_result_refundlabor_total_q->total_price_refundlabor";

if ($rs_total_refundlabor == "") {
$rs_total_refundlabor = "0.00";
}

$rs_find_refundlabor_totalref = "SELECT SUM(itemtax) AS total_price_refundlabor FROM cart WHERE cart_type = 'refundlabor' AND ipofpc = '$ipofpc'";
$rs_find_result_refundlabor_totalref = mysqli_query($rs_connect, $rs_find_refundlabor_totalref);
$rs_find_result_refundlabor_totalref_q = mysqli_fetch_object($rs_find_result_refundlabor_totalref);
$rs_total_refundlabortax = "$rs_find_result_refundlabor_totalref_q->total_price_refundlabor";

$rs_total_partstax = tnv($rs_total_partstax);
$rs_total_parts = tnv($rs_total_parts);
$rs_total_labortax = tnv($rs_total_labortax);
$rs_total_labor = tnv($rs_total_labor);
$rs_total_refundtax = tnv($rs_total_refundtax);
$rs_total_refund = tnv($rs_total_refund);
$rs_total_refundlabor = tnv($rs_total_refundlabor);
$rs_total_refundlabortax = tnv($rs_total_refundlabortax);


$grand_total = mf(($rs_total_partstax + $rs_total_parts + $rs_total_labortax + $rs_total_labor) - ($rs_total_refundtax + $rs_total_refund + $rs_total_refundlabor + $rs_total_refundlabortax));

$paidtax = (($rs_total_partstax + $rs_total_labortax) - ($rs_total_refundtax + $rs_total_refundlabortax));
$abstax = mf("$paidtax");

$findpaytotal = "SELECT SUM(amount) AS totalpayments FROM currentpayments WHERE byuser = '$ipofpc'";
$findpaytotalq = @mysqli_query($rs_connect, $findpaytotal);
$findpaytotala = mysqli_fetch_object($findpaytotalq);
$totalpayments = mf($findpaytotala->totalpayments);
$balance = $grand_total - $totalpayments;

# End repull


$findcurrentcustomer = "SELECT * FROM currentcustomer WHERE byuser = '$ipofpc'";
$findcurrentcustomerq = @mysqli_query($rs_connect, $findcurrentcustomer);

$existcust = mysqli_num_rows($findcurrentcustomerq);

if($existcust == 1) {
$findcurrentcustomera = mysqli_fetch_object($findcurrentcustomerq);
$cfirstname = "$findcurrentcustomera->cfirstname";
$ccompany = "$findcurrentcustomera->ccompany";
$caddress = "$findcurrentcustomera->caddress";
$caddress2 = "$findcurrentcustomera->caddress2";
$ccity = "$findcurrentcustomera->ccity";
$cstate = "$findcurrentcustomera->cstate";
$czip = "$findcurrentcustomera->czip";
$cphone = "$findcurrentcustomera->cphone";
$cemail = "$findcurrentcustomera->cemail";
$cwoid = "$findcurrentcustomera->woid";
$cinvoiceid = "$findcurrentcustomera->invoiceid";
$crinvoiceid = "$findcurrentcustomera->rinvoiceid";
$pcgroupid = "$findcurrentcustomera->pcgroupid";
} else {
$cfirstname = "";
$ccompany = "";
$caddress = "";
$caddress2 = "";
$ccity = "";
$cstate = "";
$czip = "";
$cphone = "";
$cemail = "";
$cwoid = "";
$cinvoiceid = "";
$crinvoiceid = "0";
$pcgroupid = "0";
}

$groupidarray = array();
if($pcgroupid != 0) {
$groupidarray[] = $pcgroupid;
}

$cfirstname_ue = urlencode($cfirstname);
$ccompany_ue = urlencode($ccompany);
$caddress_ue = urlencode($caddress);
$caddress2_ue = urlencode($caddress2);
$ccity_ue = urlencode($ccity);
$cstate_ue = urlencode($cstate);
$czip_ue = urlencode($czip);
$cphone_ue = urlencode($cphone);
$cemail_ue = urlencode($cemail);
if ($cinvoiceid != "") {

$cinvoicelist = explode_list($cinvoiceid);
foreach($cinvoicelist as $key => $cinvoicelistids) {
$rs_find_invoice_ifrecur = "SELECT rinvoice_id FROM invoices WHERE invoice_id = '$cinvoicelistids'";
$rs_result_finv = mysqli_query($rs_connect, $rs_find_invoice_ifrecur);
while($rs_result_qfr = mysqli_fetch_object($rs_result_finv)) {
$rinvoicef = "$rs_result_qfr->rinvoice_id";
if($rinvoicef != 0) {
$rs_find_invoice_recur = "SELECT pcgroupid FROM rinvoices WHERE rinvoice_id = '$rinvoicef'";
$rs_result_frinv = mysqli_query($rs_connect, $rs_find_invoice_recur);
$rs_result_qfr = mysqli_fetch_object($rs_result_frinv);
$fpcgroupid = "$rs_result_qfr->pcgroupid";
if($fpcgroupid != 0) {
$groupidarray[] = "$fpcgroupid";
}
}
}
}
}
if ($cwoid != "") {
$cwoidlist = explode_list($cwoid);
foreach($cwoidlist as $key => $cwoidlistids) {
$rs_find_pc_ifgroup = "SELECT pcid FROM pc_wo WHERE woid = '$cwoidlistids'";
$rs_result_fpc = mysqli_query($rs_connect, $rs_find_pc_ifgroup);
while($rs_result_qfpc = mysqli_fetch_object($rs_result_fpc)) {
$pcidf = "$rs_result_qfpc->pcid";
$rs_find_grp = "SELECT pcgroupid FROM pc_owner WHERE pcid = '$pcidf'";
$rs_result_fpcg = mysqli_query($rs_connect, $rs_find_grp);
$rs_result_qfpcg = mysqli_fetch_object($rs_result_fpcg);
$fpcgroupid = "$rs_result_qfpcg->pcgroupid";
if($fpcgroupid != 0) {
$groupidarray[] = "$fpcgroupid";
}
}
}
}

#end repull

$cwoids = explode_list($cwoid);

if(isset($cinvoicelist)) {
reset($cinvoicelist);
} else {
$cinvoicelist = array();
}

if((count($cinvoicelist) != 0) || (count($cwoids) != 0)) {

if(count($cinvoicelist) != 0) {
$sqllist = "";

$sqllist .= " AND (invoiceid = '$cinvoicelist[0]'";
unset($cinvoicelist[0]);
foreach($cinvoicelist as $key => $cinvoiceids) {
$sqllist .= " OR invoiceid = '$cinvoiceids'";
}
$sqllist .= ")";

} elseif (count($cwoids) != 0) {
$sqllist = "";
$sqllist .= " AND (woid = '$cwoids[0]'";
unset($cwoids[0]);

foreach($cwoids as $key => $cwoidids) {
$sqllist .= " OR woid = '$cwoidids'";
}
$sqllist .= ")";
} else {
$sqllist = "";
}


$finddeposits = "SELECT * FROM deposits WHERE dstatus != 'applied'";

if(isset($sqllist)) {
$finddeposits .= " $sqllist";
}


echo "<span style=\"display:flex;flex-wrap:wrap\">";

$finddepositsq = @mysqli_query($rs_connect, $finddeposits);
while ($finddepositsa = mysqli_fetch_object($finddepositsq)) {
$depdepositid = "$finddepositsa->depositid";
$depamount = "$finddepositsa->amount";
$depfirstname = "$finddepositsa->pfirstname";
$depplugin = "$finddepositsa->paymentplugin";
$depwoid = "$finddepositsa->woid";
$depinvoiceid = "$finddepositsa->invoiceid";

$findpaymentsd = "SELECT * FROM currentpayments WHERE byuser = '$ipofpc' AND depositid = $depdepositid";
$findpaymentsqd = @mysqli_query($rs_connect, $findpaymentsd);
$depexist = mysqli_num_rows($findpaymentsqd);

if ($depexist == 0) {
$depbutton = pcrtlang("Deposit")."# $depdepositid<br>$depplugin: $money".mf("$depamount")."<br>$depfirstname<br>";

if($depinvoiceid != 0) {
$depbutton .= pcrtlang("Invoice").": <span class=boldme>$depinvoiceid</span>";
} elseif($depwoid != 0) {
$depbutton .= pcrtlang("Work Order").": <span class=boldme>$depwoid</span>";
} else {
}


if($balance > 0) {
if($depamount > $balance) {
echo "<form action=deposits.php?func=adddep method=post><input type=hidden name=depositid value=\"$depdepositid\">";
echo "<input type=hidden name=balance value=\"$balance\">";
$amountextra = $depamount - $balance;
echo "<input type=hidden name=amountextra value=\"$amountextra\">";
echo "<button type=button class=ibutton onclick=\"this.disabled=true; this.form.submit();\">".pcrtlang("Split &amp; Add Deposit")." <i class=\"fa fa-chevron-right\"></i><br>$depbutton
</button></form><br>";
} else {
echo "<form action=deposits.php?func=adddep method=post><input type=hidden name=depositid value=\"$depdepositid\">";
echo "<button type=button class=button onclick=\"this.disabled=true; this.form.submit();\"><span class=boldme>".pcrtlang("Add Deposit")." <i class=\"fa fa-arrow-alt-circle-right\"></i></span><br><span class=sizemesmaller>$depbutton</span></button></form><br>";
}
} else {
echo "<br><br><span class=\"sizeme10 italme\">".pcrtlang("Please remove a payment in order to apply this deposit.")."</span>";
}



}
}
echo "</span>";
}

echo "<span style=\"display:flex;flex-wrap:wrap\">";
if ($balance > 0) {
reset($paymentplugins);
foreach($paymentplugins as $key => $plugin) {

echo "<form action=$plugin.php?func=add method=post><input type=hidden name=currenttotal value=\"".mf("$balance")."\">";

echo "<input type=hidden name=cfirstname value=\"$cfirstname\">";
echo "<input type=hidden name=ccompany value=\"$ccompany\">";
echo "<input type=hidden name=caddress value=\"$caddress\">";
echo "<input type=hidden name=caddress2 value=\"$caddress2\">";
echo "<input type=hidden name=ccity value=\"$ccity\">";
echo "<input type=hidden name=cstate value=\"$cstate\">";
echo "<input type=hidden name=czip value=\"$czip\">";
echo "<input type=hidden name=cphone value=\"$cphone\">";
echo "<input type=hidden name=cemail value=\"$cemail\">";

if($balance == "$grand_total") {
echo "<input type=hidden name=taxamt value=\"$paidtax\">";
}

echo "<button type=submit class=button style=\"width:125px;\">".paymentlogo("$plugin")."<br>".pcrtlang("$plugin")."</button></form>";

}


#saved payments

$groupidarray2 = array_unique($groupidarray);

reset($groupidarray2);
foreach($groupidarray2 as $key => $arrpcgroupid) {

$findcardcustomers = "SELECT * FROM savedcardscustomers WHERE groupid = '$arrpcgroupid'";
$findcardcustomersq = @mysqli_query($rs_connect, $findcardcustomers);
while ($findcardcustomersa = mysqli_fetch_object($findcardcustomersq)) {
$sccid = "$findcardcustomersa->sccid";
$sccplugin = "$findcardcustomersa->sccplugin";

$findcards = "SELECT * FROM savedcards WHERE sccid = '$sccid' AND savedcarddefault = '1'";
$findcardsq = @mysqli_query($rs_connect, $findcards);
$findcardsa = mysqli_fetch_object($findcardsq);
$savedcardname = "$findcardsa->savedcardname";
$savedcardexpmonth = "$findcardsa->savedcardexpmonth";
$savedcardexpyear = "$findcardsa->savedcardexpyear";
$savedcardfour = "$findcardsa->savedcardfour";


echo "<form action=$sccplugin"."_stored.php?func=charge method=post><input type=hidden name=currenttotal value=\"".mf("$balance")."\">";
echo "<input type=hidden name=sccid value=\"$sccid\">";
echo "<button type=submit class=button style=\"width:125px;\"><b>".pcrtlang("Saved Card")."</b><br><span class=sizemesmaller>$sccplugin</span><br>$savedcardname<br>
<i class=\"fa fa-credit-card\"></i><span class=sizemesmaller> XXXX-$savedcardfour</span></button></form>";

}
}

echo "</span>";

}


}

function paymentsarea() {
require_once("validate.php");
require("deps.php");
require("common.php");
require("headerincludes.php");

$cartcheck = cartcheck();

$rs_find_item_total = "SELECT SUM(cart_price) AS total_price_parts FROM cart WHERE cart_type = 'purchase' AND ipofpc = '$ipofpc'";
$rs_find_result_total = mysqli_query($rs_connect, $rs_find_item_total);

$rs_find_result_total_q = mysqli_fetch_object($rs_find_result_total);
$rs_total_parts = "$rs_find_result_total_q->total_price_parts";

if ($rs_total_parts == "") {
$rs_total_parts = "0.00";
}

$rs_find_itemtax_total = "SELECT SUM(itemtax) AS total_tax_parts FROM cart WHERE cart_type = 'purchase' AND ipofpc = '$ipofpc'";
$rs_find_result_taxtotal = mysqli_query($rs_connect, $rs_find_itemtax_total);
$rs_find_result_taxtotal_q = mysqli_fetch_object($rs_find_result_taxtotal);
$rs_total_partstax = "$rs_find_result_taxtotal_q->total_tax_parts";

$rs_find_labor_total = "SELECT SUM(cart_price) AS total_labor_price FROM cart WHERE cart_type = 'labor' AND ipofpc = '$ipofpc'";
$rs_find_result_labor_total = mysqli_query($rs_connect, $rs_find_labor_total);
$rs_find_result_labor_total_q = mysqli_fetch_object($rs_find_result_labor_total);
$rs_total_labor = "$rs_find_result_labor_total_q->total_labor_price";

if ($rs_total_labor == "") {
$rs_total_labor = "0.00";
}


$rs_find_labortax_total = "SELECT SUM(itemtax) AS total_labortax_price FROM cart WHERE cart_type = 'labor' AND ipofpc = '$ipofpc'";
$rs_find_result_taxlabor_total = mysqli_query($rs_connect, $rs_find_labortax_total);
$rs_find_result_labortax_total_q = mysqli_fetch_object($rs_find_result_taxlabor_total);
$rs_total_labortax = "$rs_find_result_labortax_total_q->total_labortax_price";


$rs_find_refund_total = "SELECT SUM(cart_price) AS total_price_parts FROM cart WHERE cart_type = 'refund' AND ipofpc = '$ipofpc'";
$rs_find_result_refund_total = mysqli_query($rs_connect, $rs_find_refund_total);
$rs_find_result_refund_total_q = mysqli_fetch_object($rs_find_result_refund_total);
$rs_total_refund = "$rs_find_result_refund_total_q->total_price_parts";


if ($rs_total_refund == "") {
$rs_total_refund = "0.00";
}

$rs_find_refund_totalref = "SELECT SUM(itemtax) AS total_price_partsref FROM cart WHERE cart_type = 'refund' AND ipofpc = '$ipofpc'";
$rs_find_result_refund_totalref = mysqli_query($rs_connect, $rs_find_refund_totalref);
$rs_find_result_refund_totalref_q = mysqli_fetch_object($rs_find_result_refund_totalref);
$rs_total_refundtax = "$rs_find_result_refund_totalref_q->total_price_partsref";

$rs_find_refundlabor_total = "SELECT SUM(cart_price) AS total_price_refundlabor FROM cart WHERE cart_type = 'refundlabor' AND ipofpc = '$ipofpc'";
$rs_find_result_refundlabor_total = mysqli_query($rs_connect, $rs_find_refundlabor_total);
$rs_find_result_refundlabor_total_q = mysqli_fetch_object($rs_find_result_refundlabor_total);
$rs_total_refundlabor = "$rs_find_result_refundlabor_total_q->total_price_refundlabor";

if ($rs_total_refundlabor == "") {
$rs_total_refundlabor = "0.00";
}

$rs_find_refundlabor_totalref = "SELECT SUM(itemtax) AS total_price_refundlabor FROM cart WHERE cart_type = 'refundlabor' AND ipofpc = '$ipofpc'";
$rs_find_result_refundlabor_totalref = mysqli_query($rs_connect, $rs_find_refundlabor_totalref);
$rs_find_result_refundlabor_totalref_q = mysqli_fetch_object($rs_find_result_refundlabor_totalref);
$rs_total_refundlabortax = "$rs_find_result_refundlabor_totalref_q->total_price_refundlabor";

$rs_total_partstax = tnv($rs_total_partstax);
$rs_total_parts = tnv($rs_total_parts);
$rs_total_labortax = tnv($rs_total_labortax);
$rs_total_labor = tnv($rs_total_labor);
$rs_total_refundtax = tnv($rs_total_refundtax);
$rs_total_refund = tnv($rs_total_refund);
$rs_total_refundlabor = tnv($rs_total_refundlabor);
$rs_total_refundlabortax = tnv($rs_total_refundlabortax);


$grand_total = mf(($rs_total_partstax + $rs_total_parts + $rs_total_labortax + $rs_total_labor) - ($rs_total_refundtax + $rs_total_refund + 
$rs_total_refundlabor + $rs_total_refundlabortax));

$paidtax = (($rs_total_partstax + $rs_total_labortax) - ($rs_total_refundtax + $rs_total_refundlabortax));
$abstax = mf("$paidtax");

$findpaytotal = "SELECT SUM(amount) AS totalpayments FROM currentpayments WHERE byuser = '$ipofpc'";
$findpaytotalq = @mysqli_query($rs_connect, $findpaytotal);
$findpaytotala = mysqli_fetch_object($findpaytotalq);
$totalpayments = mf($findpaytotala->totalpayments);
$balance = $grand_total - $totalpayments;

# End repull


$findcurrentcustomer = "SELECT * FROM currentcustomer WHERE byuser = '$ipofpc'";
$findcurrentcustomerq = @mysqli_query($rs_connect, $findcurrentcustomer);

$existcust = mysqli_num_rows($findcurrentcustomerq);

if($existcust == 1) {
$findcurrentcustomera = mysqli_fetch_object($findcurrentcustomerq);
$cfirstname = "$findcurrentcustomera->cfirstname";
$ccompany = "$findcurrentcustomera->ccompany";
$caddress = "$findcurrentcustomera->caddress";
$caddress2 = "$findcurrentcustomera->caddress2";
$ccity = "$findcurrentcustomera->ccity";
$cstate = "$findcurrentcustomera->cstate";
$czip = "$findcurrentcustomera->czip";
$cphone = "$findcurrentcustomera->cphone";
$cemail = "$findcurrentcustomera->cemail";
$cwoid = "$findcurrentcustomera->woid";
$cinvoiceid = "$findcurrentcustomera->invoiceid";
$crinvoiceid = "$findcurrentcustomera->rinvoiceid";
$pcgroupid = "$findcurrentcustomera->pcgroupid";
} else {
$cfirstname = "";
$ccompany = "";
$caddress = "";
$caddress2 = "";
$ccity = "";
$cstate = "";
$czip = "";
$cphone = "";
$cemail = "";
$cwoid = "";
$cinvoiceid = "";
$crinvoiceid = "0";
$pcgroupid = "0";
}

$groupidarray = array();
if($pcgroupid != 0) {
$groupidarray[] = $pcgroupid;
}

$cfirstname_ue = urlencode($cfirstname);
$ccompany_ue = urlencode($ccompany);
$caddress_ue = urlencode($caddress);
$caddress2_ue = urlencode($caddress2);
$ccity_ue = urlencode($ccity);
$cstate_ue = urlencode($cstate);
$czip_ue = urlencode($czip);
$cphone_ue = urlencode($cphone);
$cemail_ue = urlencode($cemail);
if ($cinvoiceid != "") {

$cinvoicelist = explode_list($cinvoiceid);
foreach($cinvoicelist as $key => $cinvoicelistids) {
$rs_find_invoice_ifrecur = "SELECT rinvoice_id FROM invoices WHERE invoice_id = '$cinvoicelistids'";
$rs_result_finv = mysqli_query($rs_connect, $rs_find_invoice_ifrecur);
while($rs_result_qfr = mysqli_fetch_object($rs_result_finv)) {
$rinvoicef = "$rs_result_qfr->rinvoice_id";
if($rinvoicef != 0) {
$rs_find_invoice_recur = "SELECT pcgroupid FROM rinvoices WHERE rinvoice_id = '$rinvoicef'";
$rs_result_frinv = mysqli_query($rs_connect, $rs_find_invoice_recur);
$rs_result_qfr = mysqli_fetch_object($rs_result_frinv);
$fpcgroupid = "$rs_result_qfr->pcgroupid";
if($fpcgroupid != 0) {
$groupidarray[] = "$fpcgroupid";
}
}
}
}
}
if ($cwoid != "") {
$cwoidlist = explode_list($cwoid);
foreach($cwoidlist as $key => $cwoidlistids) {
$rs_find_pc_ifgroup = "SELECT pcid FROM pc_wo WHERE woid = '$cwoidlistids'";
$rs_result_fpc = mysqli_query($rs_connect, $rs_find_pc_ifgroup);
while($rs_result_qfpc = mysqli_fetch_object($rs_result_fpc)) {
$pcidf = "$rs_result_qfpc->pcid";
$rs_find_grp = "SELECT pcgroupid FROM pc_owner WHERE pcid = '$pcidf'";
$rs_result_fpcg = mysqli_query($rs_connect, $rs_find_grp);
$rs_result_qfpcg = mysqli_fetch_object($rs_result_fpcg);
$fpcgroupid = "$rs_result_qfpcg->pcgroupid";
if($fpcgroupid != 0) {
$groupidarray[] = "$fpcgroupid";
}
}
}
}

#end repull


echo "<span class=\"sizemelarge colormemoney boldme\">&nbsp;".pcrtlang("Payments")."&nbsp;</span><br><br>";

echo "<table style=\"width:100%\">";

$findpayments = "SELECT * FROM currentpayments WHERE byuser = '$ipofpc'";
$findpaymentsq = @mysqli_query($rs_connect, $findpayments);
$currentpaymenttotal = mysqli_num_rows($findpaymentsq);
while ($findpaymentsa = mysqli_fetch_object($findpaymentsq)) {
$paymentamount = "$findpaymentsa->amount";
$pfirstname = "$findpaymentsa->pfirstname";
$pcompany = "$findpaymentsa->pcompany";
$paymenttype = "$findpaymentsa->paymenttype";
$paymentid = "$findpaymentsa->paymentid";
$paymentplugin = "$findpaymentsa->paymentplugin";
$checknumber = "$findpaymentsa->chk_number";
$ccnumber2 = "$findpaymentsa->cc_number";
$ccexpmonth = "$findpaymentsa->cc_expmonth";
$ccexpyear = "$findpaymentsa->cc_expyear";
$cc_transid = "$findpaymentsa->cc_transid";
$cc_cardtype = "$findpaymentsa->cc_cardtype";
$custompaymentinfo2 = "$findpaymentsa->custompaymentinfo";
$isdeposit = "$findpaymentsa->isdeposit";
$depositid = "$findpaymentsa->depositid";

$custompaymentinfo = unserialize("$custompaymentinfo2");

$ccnumber = mb_substr("$ccnumber2", -4, 4);

if ($paymenttype == "cash") {
echo "<tr><td style=\"width:50px;vertical-align:top\">".paymentlogo("$paymentplugin")."</td><td><span class=\"boldme sizemelarge colormemoney\">".pcrtlang("Cash")." </span><br><span class=\"colormemoney\">$pfirstname - $money".mf("$paymentamount")."</span></td>";
echo "<td valign=top>";
if ($isdeposit == 1) {
echo "<form action=cart.php?func=removedeposit method=post><input type=hidden name=depositid value=\"$depositid\">";
echo "<input type=submit class=ibutton value=\"".pcrtlang("Remove Deposit")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Removing")."...'; this.form.submit();\"></form>";
} else {
echo "<form action=$paymentplugin.php?func=void method=post class=catchremovepayment><input type=hidden name=payid value=\"$paymentid\">";
echo "<input type=submit class=ibutton value=\"".pcrtlang("Remove")."\"></form>";
}
echo "</td></tr>";
echo "<tr><td colspan=2>&nbsp;</td></tr>";

} elseif ($paymenttype == "check") {
echo "<tr><td style=\"width:50px;vertical-align:top\">".paymentlogo("$paymentplugin")."</td><td valign=top><span class=\"boldme sizemelarge colormemoney\">".pcrtlang("Check")." #$checknumber:</span><br><span class=\"colormemoney\">$pfirstname - ";
echo "$money".mf("$paymentamount")."</span></td>";
echo "<td valign=top>";
if ($isdeposit == 1) {
echo "<form action=cart.php?func=removedeposit method=post><input type=hidden name=depositid value=\"$depositid\">";
echo "<input type=submit class=ibutton value=\"".pcrtlang("Remove Deposit")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Removing")."...'; this.form.submit();\"></form>";
} else {
echo "<form action=$paymentplugin.php?func=void method=post class=catchremovepayment><input type=hidden name=payid value=\"$paymentid\">";
echo "<input type=submit class=ibutton value=\"".pcrtlang("Remove")."\"></form>";
}
echo "</td></tr>";
echo "<tr><td colspan=2>&nbsp;</td></tr>";

} elseif ($paymenttype == "credit") {
echo "<tr><td style=\"width:50px;vertical-align:top\">".paymentlogo("$paymentplugin")."</td><td valign=top><span class=\"boldme sizemelarge colormemoney\"> ".pcrtlang("Credit Card")." </span><br><span class=\"colormemoney\">XXXX-$ccnumber<br>".pcrtlang("Exp").": $ccexpmonth/$ccexpyear<br>";
echo "$pfirstname - $money".mf("$paymentamount")."<br>$paymentplugin $cc_cardtype</span></td>";
echo "<td valign=top>";
if ($isdeposit == 1) {
echo "<form action=cart.php?func=removedeposit method=post><input type=hidden name=depositid value=\"$depositid\">";
echo "<input type=submit class=ibutton value=\"".pcrtlang("Remove Deposit")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Removing")."...'; this.form.submit();\"></form>";
} else {
echo "<form action=$paymentplugin.php?func=void method=post><input type=hidden name=payid value=\"$paymentid\">";
echo "<input type=hidden name=cc_transid value=\"$cc_transid\"><input type=hidden name=refundamount value=\"$paymentamount\">";
echo "<input type=submit class=ibutton value=\"".pcrtlang("Void")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Voiding")."...'; this.form.submit();\"></form>";
}
echo "<br></td></tr>";
echo "<tr><td colspan=2>&nbsp;</td></tr>";

} elseif ($paymenttype == "custompayment") {
echo "<tr><td style=\"width:50px;vertical-align:top\">".paymentlogo("$paymentplugin")."</td><td valign=top><span class=\"boldme sizemelarge colormemoney\"> $paymentplugin</span><br><span class=\"colormemoney\">$pfirstname - $money".mf("$paymentamount")."</span><br>";


reset($custompaymentinfo);
foreach($custompaymentinfo as $key => $val) {
echo "<span class=\"sizemesmaller boldme colormemoney\">$key:</span><span class=\"sizemesmaller italme colormemoney\"> $val</span><br>";
}


echo "</td>";
echo "<td valign=top>";
if ($isdeposit == 1) {
echo "<form action=cart.php?func=removedeposit method=post><input type=hidden name=depositid value=\"$depositid\">";
echo "<input type=submit class=ibutton value=\"".pcrtlang("Remove Deposit")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Removing")."...'; this.form.submit();\"></form>";
} else {
echo "<form action=$paymentplugin.php?func=void method=post class=catchremovepayment><input type=hidden name=payid value=\"$paymentid\">";
echo "<input type=submit class=ibutton value=\"Remove\"></form>";
}
echo "</td></tr>";
echo "<tr><td colspan=2>&nbsp;</td></tr>";

} else {
echo "<tr><td colspan=2>Error! Undefined Payment Type in database</td></tr>";
}

}

echo "</table>";


if ($balance > 0) {
echo "<table><tr><td colspan=2><span class=\"sizemelarge boldme colormemoney\">".pcrtlang("Balance").":</span> <span 
class=\"colormered sizemelarge boldme floatright\"> $money".mf("$balance")."</span></td></tr></table>";
}

if (($balance < 0) && ($currentpaymenttotal > 0)) {
echo "<table><tr><td colspan=2><span class=\"sizemelarge boldme colormemoney\">".pcrtlang("Over Payment").":</span> <span
class=\"colormegreen sizemelarge boldme floatright\"> $money".mf(abs("$balance"))."</span></td></tr></table>";
}


if($cinvoiceid != "") {
$totalinvoicesincart = count(explode_list($cinvoiceid));
if($totalinvoicesincart == "1") {
$iorq = invoiceorquote($cinvoiceid);
if ($iorq == "quote") {
$ilabel = pcrtlang("Quote");
} else {
$ilabel = pcrtlang("Invoice");
}
$findinvtot = "SELECT SUM(cart_price + itemtax) AS invtotal FROM invoice_items WHERE invoice_id = '$cinvoiceid'";
$findinvtotq = @mysqli_query($rs_connect, $findinvtot);
$findinvtota = mysqli_fetch_object($findinvtotq);
$paymentamount = mf("$findinvtota->invtotal");
if ($paymentamount != $grand_total) {
echo "<table><tr><td colspan=2><br><span class=colormered><i class=\"fa fa-warning fa-lg\"></i> ".pcrtlang("Cart contains items not on or saved in")." $ilabel #$cinvoiceid.</span></td></tr></table>";
}
}
}

?>

<script type='text/javascript'>
$(document).ready(function(){
$('.catchremovepayment').submit(function(e) { // catch the form's submit event
        e.preventDefault();
        $.ajax({ // create an AJAX call...
        data: $(this).serialize(), // get the form data
        type: $(this).attr('method'), // GET or POST
        url: $(this).attr('action'), // the file to call
        success: function(response) { // on success..
                $.get('cart.php?func=cartarea', function(data) {
                $('#cartarea').html(data);
                });
                $.get('cart.php?func=paymentsarea', function(data) {
                $('#paymentsarea').html(data);
                });
                $.get('cart.php?func=customerarea', function(data) {
                $('#customerarea').html(data);
                });
                $.get('cart.php?func=paymentmethodsarea', function(data) {
                $('#paymentmethodsarea').html(data);
                });
                $.get('cart.php?func=newinvoicearea', function(data) {
                $('#newinvoicearea').html(data);
                });
                $.get('cart.php?func=cartfloaterarea', function(data) {
                $('#bottomnavbarfixedlight').html(data);
                });
    }
    });
});
});
</script>


<?php


}



function cartfloaterarea() {
require_once("validate.php");
require("deps.php");
require("common.php");
require("headerincludes.php");

$cartcheck = cartcheck();

$rs_find_item_total = "SELECT SUM(cart_price) AS total_price_parts FROM cart WHERE cart_type = 'purchase' AND ipofpc = '$ipofpc'";
$rs_find_result_total = mysqli_query($rs_connect, $rs_find_item_total);

$rs_find_result_total_q = mysqli_fetch_object($rs_find_result_total);
$rs_total_parts = "$rs_find_result_total_q->total_price_parts";

if ($rs_total_parts == "") {
$rs_total_parts = "0.00";
}

$rs_find_itemtax_total = "SELECT SUM(itemtax) AS total_tax_parts FROM cart WHERE cart_type = 'purchase' AND ipofpc = '$ipofpc'";
$rs_find_result_taxtotal = mysqli_query($rs_connect, $rs_find_itemtax_total);
$rs_find_result_taxtotal_q = mysqli_fetch_object($rs_find_result_taxtotal);
$rs_total_partstax = "$rs_find_result_taxtotal_q->total_tax_parts";

$rs_find_labor_total = "SELECT SUM(cart_price) AS total_labor_price FROM cart WHERE cart_type = 'labor' AND ipofpc = '$ipofpc'";
$rs_find_result_labor_total = mysqli_query($rs_connect, $rs_find_labor_total);
$rs_find_result_labor_total_q = mysqli_fetch_object($rs_find_result_labor_total);
$rs_total_labor = "$rs_find_result_labor_total_q->total_labor_price";

if ($rs_total_labor == "") {
$rs_total_labor = "0.00";
}


$rs_find_labortax_total = "SELECT SUM(itemtax) AS total_labortax_price FROM cart WHERE cart_type = 'labor' AND ipofpc = '$ipofpc'";
$rs_find_result_taxlabor_total = mysqli_query($rs_connect, $rs_find_labortax_total);
$rs_find_result_labortax_total_q = mysqli_fetch_object($rs_find_result_taxlabor_total);
$rs_total_labortax = "$rs_find_result_labortax_total_q->total_labortax_price";


$rs_find_refund_total = "SELECT SUM(cart_price) AS total_price_parts FROM cart WHERE cart_type = 'refund' AND ipofpc = '$ipofpc'";
$rs_find_result_refund_total = mysqli_query($rs_connect, $rs_find_refund_total);
$rs_find_result_refund_total_q = mysqli_fetch_object($rs_find_result_refund_total);
$rs_total_refund = "$rs_find_result_refund_total_q->total_price_parts";


if ($rs_total_refund == "") {
$rs_total_refund = "0.00";
}

$rs_find_refund_totalref = "SELECT SUM(itemtax) AS total_price_partsref FROM cart WHERE cart_type = 'refund' AND ipofpc = '$ipofpc'";
$rs_find_result_refund_totalref = mysqli_query($rs_connect, $rs_find_refund_totalref);
$rs_find_result_refund_totalref_q = mysqli_fetch_object($rs_find_result_refund_totalref);
$rs_total_refundtax = "$rs_find_result_refund_totalref_q->total_price_partsref";

$rs_find_refundlabor_total = "SELECT SUM(cart_price) AS total_price_refundlabor FROM cart WHERE cart_type = 'refundlabor' AND ipofpc = '$ipofpc'";
$rs_find_result_refundlabor_total = mysqli_query($rs_connect, $rs_find_refundlabor_total);
$rs_find_result_refundlabor_total_q = mysqli_fetch_object($rs_find_result_refundlabor_total);
$rs_total_refundlabor = "$rs_find_result_refundlabor_total_q->total_price_refundlabor";

if ($rs_total_refundlabor == "") {
$rs_total_refundlabor = "0.00";
}

$rs_find_refundlabor_totalref = "SELECT SUM(itemtax) AS total_price_refundlabor FROM cart WHERE cart_type = 'refundlabor' AND ipofpc = '$ipofpc'";
$rs_find_result_refundlabor_totalref = mysqli_query($rs_connect, $rs_find_refundlabor_totalref);
$rs_find_result_refundlabor_totalref_q = mysqli_fetch_object($rs_find_result_refundlabor_totalref);
$rs_total_refundlabortax = "$rs_find_result_refundlabor_totalref_q->total_price_refundlabor";

$rs_total_partstax = tnv($rs_total_partstax);
$rs_total_parts = tnv($rs_total_parts);
$rs_total_labortax = tnv($rs_total_labortax);
$rs_total_labor = tnv($rs_total_labor);
$rs_total_refundtax = tnv($rs_total_refundtax);
$rs_total_refund = tnv($rs_total_refund);
$rs_total_refundlabor = tnv($rs_total_refundlabor);
$rs_total_refundlabortax = tnv($rs_total_refundlabortax);


$grand_total = mf(($rs_total_partstax + $rs_total_parts + $rs_total_labortax + $rs_total_labor) - ($rs_total_refundtax + $rs_total_refund +
$rs_total_refundlabor + $rs_total_refundlabortax));

$paidtax = (($rs_total_partstax + $rs_total_labortax) - ($rs_total_refundtax + $rs_total_refundlabortax));
$abstax = mf("$paidtax");

$findpaytotal = "SELECT SUM(amount) AS totalpayments FROM currentpayments WHERE byuser = '$ipofpc'";
$findpaytotalq = @mysqli_query($rs_connect, $findpaytotal);
$findpaytotala = mysqli_fetch_object($findpaytotalq);
$totalpayments = mf($findpaytotala->totalpayments);
$balance = $grand_total - $totalpayments;

# End repull


$findcurrentcustomer = "SELECT * FROM currentcustomer WHERE byuser = '$ipofpc'";
$findcurrentcustomerq = @mysqli_query($rs_connect, $findcurrentcustomer);

$existcust = mysqli_num_rows($findcurrentcustomerq);

if($existcust == 1) {
$findcurrentcustomera = mysqli_fetch_object($findcurrentcustomerq);
$cfirstname = "$findcurrentcustomera->cfirstname";
$ccompany = "$findcurrentcustomera->ccompany";
$caddress = "$findcurrentcustomera->caddress";
$caddress2 = "$findcurrentcustomera->caddress2";
$ccity = "$findcurrentcustomera->ccity";
$cstate = "$findcurrentcustomera->cstate";
$czip = "$findcurrentcustomera->czip";
$cphone = "$findcurrentcustomera->cphone";
$cemail = "$findcurrentcustomera->cemail";
$cwoid = "$findcurrentcustomera->woid";
$cinvoiceid = "$findcurrentcustomera->invoiceid";
$crinvoiceid = "$findcurrentcustomera->rinvoiceid";
$pcgroupid = "$findcurrentcustomera->pcgroupid";
} else {
$cfirstname = "";
$ccompany = "";
$caddress = "";
$caddress2 = "";
$ccity = "";
$cstate = "";
$czip = "";
$cphone = "";
$cemail = "";
$cwoid = "";
$cinvoiceid = "";
$crinvoiceid = "0";
$pcgroupid = "0";
}

$groupidarray = array();
if($pcgroupid != 0) {
$groupidarray[] = $pcgroupid;
}

$cfirstname_ue = urlencode($cfirstname);
$ccompany_ue = urlencode($ccompany);
$caddress_ue = urlencode($caddress);
$caddress2_ue = urlencode($caddress2);
$ccity_ue = urlencode($ccity);
$cstate_ue = urlencode($cstate);
$czip_ue = urlencode($czip);
$cphone_ue = urlencode($cphone);
$cemail_ue = urlencode($cemail);
if ($cinvoiceid != "") {

$cinvoicelist = explode_list($cinvoiceid);
foreach($cinvoicelist as $key => $cinvoicelistids) {
$rs_find_invoice_ifrecur = "SELECT rinvoice_id FROM invoices WHERE invoice_id = '$cinvoicelistids'";
$rs_result_finv = mysqli_query($rs_connect, $rs_find_invoice_ifrecur);
while($rs_result_qfr = mysqli_fetch_object($rs_result_finv)) {
$rinvoicef = "$rs_result_qfr->rinvoice_id";
if($rinvoicef != 0) {
$rs_find_invoice_recur = "SELECT pcgroupid FROM rinvoices WHERE rinvoice_id = '$rinvoicef'";
$rs_result_frinv = mysqli_query($rs_connect, $rs_find_invoice_recur);
$rs_result_qfr = mysqli_fetch_object($rs_result_frinv);
$fpcgroupid = "$rs_result_qfr->pcgroupid";
if($fpcgroupid != 0) {
$groupidarray[] = "$fpcgroupid";
}
}
}
}
}
if ($cwoid != "") {
$cwoidlist = explode_list($cwoid);
foreach($cwoidlist as $key => $cwoidlistids) {
$rs_find_pc_ifgroup = "SELECT pcid FROM pc_wo WHERE woid = '$cwoidlistids'";
$rs_result_fpc = mysqli_query($rs_connect, $rs_find_pc_ifgroup);
while($rs_result_qfpc = mysqli_fetch_object($rs_result_fpc)) {
$pcidf = "$rs_result_qfpc->pcid";
$rs_find_grp = "SELECT pcgroupid FROM pc_owner WHERE pcid = '$pcidf'";
$rs_result_fpcg = mysqli_query($rs_connect, $rs_find_grp);
$rs_result_qfpcg = mysqli_fetch_object($rs_result_fpcg);
$fpcgroupid = "$rs_result_qfpcg->pcgroupid";
if($fpcgroupid != 0) {
$groupidarray[] = "$fpcgroupid";
}
}
}
}

## Bar

echo "<table style=\"width:100%;border-collapse:collapse;padding:0px;\"><tr><td style=\"text-align:left;vertical-align:top;padding:0px 0px 0px 0px;width:300px\">";

echo "<form name=f action=cart.php?func=add_item method=post id=catchadditem><table style=\"border-collapse:collapse;padding:0px;\"><tr><td>";
echo "<input type=number class=textbox style=\"width:40px;padding:16px 0px 16px 5px;font-size:15px;\" name=\"qty\" value=\"1\" min=\"1\" step=\"1\"></td><td>";
echo "<input autofocus type=text class=textbox id=autoinvsearchbox style=\"box-sizing:border-box;width:130px;padding:18px 0px 18px 5px;\" name=\"stockid\" required=required placeholder=\"".pcrtlang("StockId/Search/UPC")."\">";
echo "</td><td><button type=submit class=\"linkbuttonmoney linkbuttonlarge radiusall\" style=\"padding:6px;\"><i class=\"fa fa-cart-plus fa-lg\"></i><br>".pcrtlang("Add Item")."</button></table></form>";
#echo "<div id=\"autoinvsearch\"></div>";
echo "</td><td style=\"width:200px;vertical-align:top;padding:0px 0px 0px 0px;\">";
echo "<a href=\"javascript:void(0);\" id=addlaboronfloater style=\"padding:6px;\" class=\"linkbuttonmoney linkbuttonlarge radiusleft\"><i class=\"fa fa-cart-plus fa-lg\"></i><br>".pcrtlang("Labor")."</a>";
echo "<a href=\"javascript:void(0);\" id=addnoninvonfloater style=\"padding:6px;\" class=\"linkbuttonmoney linkbuttonlarge radiusright\"><i class=\"fa fa-cart-plus fa-lg\"></i><br>".pcrtlang("Non-Inv")."</a>";

echo "</td><td style=\"vertical-align:top\">";

echo "<div style=\"background:#444444;padding:5px 40px 5px 5px; text-align:center;\" class=radiusall>";

## End First Half of Bar
echo "<table style=\"width:100%\"><tr><td style=\"vertical-align:center\">";


$rs_find_cart_items = "SELECT cart_item_id FROM cart WHERE cart_type = 'purchase' AND ipofpc = '$ipofpc'";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);
$rs_find_cart_labor = "SELECT cart_item_id FROM cart WHERE cart_type = 'labor' AND ipofpc = '$ipofpc'";
$rs_result_labor = mysqli_query($rs_connect, $rs_find_cart_labor);
$rs_find_cart_returns = "SELECT cart_item_id FROM cart WHERE cart_type = 'refund' AND ipofpc = '$ipofpc'";
$rs_result_returns = mysqli_query($rs_connect, $rs_find_cart_returns);
$rs_find_cart_refundlabor = "SELECT cart_item_id FROM cart WHERE cart_type = 'refundlabor' AND ipofpc = '$ipofpc'";
$rs_result_refundlabor = mysqli_query($rs_connect, $rs_find_cart_refundlabor);
$purchasecount = mysqli_num_rows($rs_result);
$laborcount = mysqli_num_rows($rs_result_labor);
$returnscount = mysqli_num_rows($rs_result_returns);
$refundlaborcount = mysqli_num_rows($rs_result_refundlabor);

if (($purchasecount != 0) || ($laborcount != 0) || ($returnscount != 0) || ($refundlaborcount != 0)) {
if ($grand_total == 0) {
if ($totalpayments == 0) {


echo "<form action=checkout.php?func=checkout method=post>";
echo "<input type=hidden name=cfirstname value=\"$cfirstname\">";
echo "<input type=hidden name=ccompany value=\"$ccompany\">";
echo "<input type=hidden name=caddress value=\"$caddress\">";
echo "<input type=hidden name=caddress2 value=\"$caddress2\">";
echo "<input type=hidden name=ccity value=\"$ccity\">";
echo "<input type=hidden name=cstate value=\"$cstate\">";
echo "<input type=hidden name=czip value=\"$czip\">";
echo "<input type=hidden name=cphone value=\"$cphone\">";
echo "<input type=hidden name=cemail value=\"$cemail\">";
echo "<input type=hidden name=cartcheck value=\"$cartcheck\">";
echo "<input type=hidden name=grandtotal value=\"$grand_total\">";
echo "<input type=hidden name=grandtax value=\"$abstax\">";
echo "<input type=hidden name=woid value=\"$cwoid\">";
echo "<input type=hidden name=invoice_id value=\"$cinvoiceid\">";
echo "<input type=hidden name=checkoutaction value=\"exchange\">";
if (($rs_total_refund != 0) && ($rs_total_refundlabor)) {
echo "<input type=submit  class=\"linkbuttonlarge linkbuttongreen2 radiusall\"  value=\"".pcrtlang("Exchange")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Exchanging")."...'; this.form.submit();\">";
} else {

if($cwoid != 0) {
#echo pcrtlang("Set Status").":";

$statuscolors = getstatusselectorcolors();
$boxtitles = getboxtitles();

$coptions = "";
$rs_qc = "SELECT * FROM boxstyles WHERE statusid > 99";
$rs_result1 = mysqli_query($rs_connect, $rs_qc);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$statusid = "$rs_result_q1->statusid";
$selectorcolor2 = "$rs_result_q1->selectorcolor";
$boxtitle2 = "$rs_result_q1->boxtitle";
$coptions .= "<option value=\"$statusid\" class=statusdrop style=\"background:#$selectorcolor2\">$boxtitle2</option>";
}

echo "<select name=statnum>
<option value=5 class=statusdrop style=\"background:#$statuscolors[5]\">$boxtitles[5]</option>
<option value=1 class=statusdrop style=\"background:#$statuscolors[1]\">$boxtitles[1]</option>
<option value=2 class=statusdrop style=\"background:#$statuscolors[2]\">$boxtitles[2]</option>
<option value=8 class=statusdrop style=\"background:#$statuscolors[8]\">$boxtitles[8]</option><option value=9 class=statusdrop style=\"background:#$statuscolors[9]\">$boxtitles[9]</option>
<option value=3 class=statusdrop style=\"background:#$statuscolors[3]\">$boxtitles[3]</option><option value=4 class=statusdrop style=\"background:#$statuscolors[4]\">$boxtitles[4]</option>
<option value=6 class=statusdrop style=\"background:#$statuscolors[6]\">$boxtitles[6]</option><option value=7 class=statusdrop style=\"background:#$statuscolors[7]\">$boxtitles[7]</option>";
echo "$coptions";

echo "</select> &nbsp;&nbsp;&nbsp;";
}


echo "<input type=submit  class=\"linkbuttonlarge linkbuttonred2 radiusall\"  value=\"".pcrtlang("No Charge")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Wait")."...'; this.form.submit();\">";
}
}
echo "</form>";
} elseif ($grand_total > 0) {
if ($balance == 0) {

echo "<form action=checkout.php?func=checkout method=post>";

if($cwoid != "") {
#echo "<span class=\"colormemoney\">".pcrtlang("Set Status").":</span>";

$statuscolors = getstatusselectorcolors();
$boxtitles = getboxtitles();

$coptions = "";
$rs_qc = "SELECT * FROM boxstyles WHERE statusid > 99";
$rs_result1 = mysqli_query($rs_connect, $rs_qc);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$statusid = "$rs_result_q1->statusid";
$selectorcolor2 = "$rs_result_q1->selectorcolor";
$boxtitle2 = "$rs_result_q1->boxtitle";
$coptions .= "<option value=\"$statusid\" class=statusdrop style=\"background:#$selectorcolor2\">$boxtitle2</option>";
}

echo "<select name=statnum style=\"font-size:11px;width:150px;\">
<option value=5 class=statusdrop style=\"background:#$statuscolors[5]\">$boxtitles[5]</option>
<option value=1 class=statusdrop style=\"background:#$statuscolors[1]\">$boxtitles[1]</option>
<option value=2 class=statusdrop style=\"background:#$statuscolors[2]\">$boxtitles[2]</option>
<option value=8 class=statusdrop style=\"background:#$statuscolors[8]\">$boxtitles[8]</option><option value=9 class=statusdrop style=\"background:#$statuscolors[9]\">$boxtitles[9]</option>
<option value=3 class=statusdrop style=\"background:#$statuscolors[3]\">$boxtitles[3]</option><option value=4 class=statusdrop style=\"background:#$statuscolors[4]\">$boxtitles[4]</option>
<option value=6 class=statusdrop style=\"background:#$statuscolors[6]\">$boxtitles[6]</option><option value=7 class=statusdrop style=\"background:#$statuscolors[7]\">$boxtitles[7]</option>";

echo "$coptions";

echo "</select> &nbsp;&nbsp;&nbsp;";

}


echo "<input type=hidden name=cfirstname value=\"$cfirstname\">";
echo "<input type=hidden name=ccompany value=\"$ccompany\">";
echo "<input type=hidden name=caddress value=\"$caddress\">";
echo "<input type=hidden name=caddress2 value=\"$caddress2\">";
echo "<input type=hidden name=ccity value=\"$ccity\">";
echo "<input type=hidden name=cstate value=\"$cstate\">";
echo "<input type=hidden name=czip value=\"$czip\">";
echo "<input type=hidden name=cphone value=\"$cphone\">";
echo "<input type=hidden name=cemail value=\"$cemail\">";
echo "<input type=hidden name=cartcheck value=\"$cartcheck\">";
echo "<input type=hidden name=grandtotal value=\"$grand_total\">";
echo "<input type=hidden name=grandtax value=\"$abstax\">";
echo "<input type=hidden name=woid value=\"$cwoid\">";
echo "<input type=hidden name=invoice_id value=\"$cinvoiceid\">";
echo "<input type=hidden name=checkoutaction value=\"purchase\">";
echo "<input type=submit class=\"linkbuttonlarge linkbuttongreen2 radiusall\" value=\"".pcrtlang("Checkout")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Checking Out")."...'; this.form.submit();\">";

}
echo "</form>";
} else {
if ($totalpayments == 0) {
echo "<form action=checkout.php?func=checkout method=post>";
echo "<input type=hidden name=cfirstname value=\"$cfirstname\">";
echo "<input type=hidden name=ccompany value=\"$ccompany\">";
echo "<input type=hidden name=caddress value=\"$caddress\">";
echo "<input type=hidden name=caddress2 value=\"$caddress2\">";
echo "<input type=hidden name=ccity value=\"$ccity\">";
echo "<input type=hidden name=cstate value=\"$cstate\">";
echo "<input type=hidden name=czip value=\"$czip\">";
echo "<input type=hidden name=cphone value=\"$cphone\">";
echo "<input type=hidden name=cemail value=\"$cemail\">";
echo "<input type=hidden name=cartcheck value=\"$cartcheck\">";
echo "<input type=hidden name=grandtotal value=\"$grand_total\">";
echo "<input type=hidden name=grandtax value=\"$abstax\">";
echo "<input type=hidden name=woid value=\"$cwoid\">";
echo "<input type=hidden name=invoice_id value=\"$cinvoiceid\">";
echo "<input type=hidden name=checkoutaction value=\"refund\">";
echo "<input type=submit  class=\"linkbuttonlarge linkbuttonred2 radiusall\"  value=\"".pcrtlang("Refund")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Refunding")."...'; this.form.submit();\">";
}
echo "</form>";
}

# End of cart counts
}

echo "</td>";

#end of bar
echo "<td>";
echo "<span class=\"colormewhite boldme sizeme2x floatright\">$money$grand_total</span>";
echo "</td></tr></table></div></td></tr></table>";

echo "<div id=\"autoinvsearch\"></div>";
echo "<div id=\"addlaborajax\"></div>";
echo "<div id=\"addnoninvajax\"></div>";

#wip



?>

<script type="text/javascript">
$(document).ready(function(){
  $("input#autoinvsearchbox").keyup(function(){
     $("div#addlaborajax").empty();	
     $("div#addnoninvajax").empty();
    if(this.value.length<3) {
      $("div#autoinvsearch").slideUp(200,function(){
        return false;
      });
    }else{
        var encodedinv = encodeURIComponent(this.value);
        $('div#autoinvsearch').load('autosearch.php?func=inv&search='+encodedinv).slideDown(200);
    }
  });
});
</script>

<script type="text/javascript">
$(document).ready(function(){
$('#addlaboronfloater').click(function(e) {
                e.preventDefault(); // stop the browser from following the link
		 $('.ajaxspinner').toggle();
		$("div#autoinvsearch").empty();
     		$("div#addnoninvajax").empty();
                $.get('cart.php?func=add_labor_ajax', function(data) {
                $('#addlaborajax').html(data);
                $('.ajaxspinner').toggle();
		});
        });
});
</script>

<script type='text/javascript'>
$(document).ready(function(){
$('#catchadditem').submit(function(e) { // catch the form's submit event
        e.preventDefault();
	 $('.ajaxspinner').toggle();
        $("div#addlaborajax").empty();
        $("div#addnoninvajax").empty();
        $("div#autoinvsearch").empty();
        $.ajax({ // create an AJAX call...
        data: $(this).serialize(), // get the form data
        type: $(this).attr('method'), // GET or POST
        url: $(this).attr('action'), // the file to call
        success: function(response) { // on success..
                $.get('cart.php?func=cartarea', function(data) {
                $('#cartarea').html(data);
                });
                $.get('cart.php?func=paymentsarea', function(data) {
                $('#paymentsarea').html(data);
                });
                $.get('cart.php?func=customerarea', function(data) {
                $('#customerarea').html(data);
                });
                $.get('cart.php?func=paymentmethodsarea', function(data) {
                $('#paymentmethodsarea').html(data);
                });
                $.get('cart.php?func=newinvoicearea', function(data) {
                $('#newinvoicearea').html(data);
                });
                $.get('cart.php?func=cartfloaterarea', function(data) {
                $('#bottomnavbarfixedlight').html(data);
                });
		 $('.ajaxspinner').toggle();
    }
    });
});
});
</script>

<script type="text/javascript">
$(document).ready(function(){
$('#addnoninvonfloater').click(function(e) {
                e.preventDefault(); // stop the browser from following the link
		 $('.ajaxspinner').toggle();
                $("div#autoinvsearch").empty();
     		$("div#addlaborajax").empty();
                $.get('cart.php?func=add_noninv_ajax', function(data) {
                $('#addnoninvajax').html(data);
		 $('.ajaxspinner').toggle();
                });
        });
});
</script>


<?php

}


function add_labor_ajax() {

require("deps.php");
require_once("common.php");
require("headerincludes.php");

echo "<a href=\"javascript:void(0);\" class=\"linkbuttonmedium linkbuttonred2 floatright radiusall\" id=closeaddlabor><i class=\"fa fa-times fa-lg\"></i></a>";

echo "<br><table style=\"width:100%\"><tr><td style=\"vertical-align:top;text-align:left;width:25%;padding:4px;\">";
echo "<form action=cart.php?func=add_labor2 id=catchaddlaborform method=post>";
echo pcrtlang("Labor Quantity")."<br><input type=number value=1 min=\".01\" step=\".01\" name=qty class=textbox style=\"width:40px;\"><br><br>";
echo pcrtlang("Labor Charge")."<br>";

$usertaxid = getusertaxid();
$servicetaxrateremain = (1 + getservicetaxrate($usertaxid));

echo "$money<input autofocus type=text class=textbox style=\"width:50px\" name=laborprice id=laborprice>";

if($servicetaxrateremain != 1) {
echo "<button class=button type=button onclick='document.getElementById(\"laborprice\").value=(document.getElementById(\"laborprice\").value / $servicetaxrateremain).toFixed(5);this.disabled=true;'>
<i class=\"fa fa-calculator\"></i> ".pcrtlang("Pre-tax")."</button>";
}


echo "<br><br>".pcrtlang("Labor Title").":<br><input type=text class=textbox style=\"width:90%\" name=labordesc id=labordesc><br><br>";



echo "".pcrtlang("Printed Labor Description")." (".pcrtlang("optional")."):<br><textarea class=textbox name=laborpdesc id=laborpdesc style=\"width:90%\"></textarea><br><br>";
echo "<button type=submit class=button><i class=\"fa fa-cart-plus\"></i> ".pcrtlang("Add to Cart")."</button></form>";

echo "</td><td style=\"width:75%;vertical-align:top\">";
echo "<div class=positemgrid style=\"height:450px;overflow-x:auto;scrollbar-width: thin;\">";
$rs_quicklabor = "SELECT * FROM quicklabor ORDER BY theorder DESC";
$rs_result_ql  = mysqli_query($rs_connect, $rs_quicklabor);
while($rs_result_qld = mysqli_fetch_object($rs_result_ql)) {
$labordesc = "$rs_result_qld->labordesc";
$laborprice = "$rs_result_qld->laborprice";
$printdesc = "$rs_result_qld->printdesc";

$printdesc2 = urlencode("$printdesc");

$primero = mb_substr("$labordesc", 0, 1);
if("$primero" != "-") {
$labordesc2 = urlencode("$labordesc");
echo "<form class=quicklaborfill>
<input type=hidden name=labordesc value=\"".pf("$labordesc")."\">
<input type=hidden name=laborprice value=\"".pf(mf("$laborprice"))."\">
<input type=hidden name=laborpdesc value=\"".pf("$printdesc")."\">
<button type=\"submit\" style=\"width:100px;height:75px;margin:5px\" class=\"linkbuttonsmall linkbuttongray radiusall\"><span class=\"sizemelarger\">$money".mf("$laborprice")."</span><br><span style=\"font-weight:normal;\">$labordesc</span></button></form>";
} else {
$labordesc3 = mb_substr("$labordesc", 1);
echo "<span class=\"linkbuttonsmall linkbuttongraylabel radiusall\" style=\"width:100px;height:75px;margin:5px;\"><br>$labordesc3<br><i class=\"fa fa-chevron-down fa-2x\"></i></span>";
}

}

echo "</div>";

?>

<script>
$('.quicklaborfill').submit(function(e){
    e.preventDefault();
    var ql_labordesc = $(this).find('input[name="labordesc"]').val();
    var ql_laborprice = $(this).find('input[name="laborprice"]').val();
    var ql_laborpdesc = $(this).find('input[name="laborpdesc"]').val();
    $("#labordesc").val(ql_labordesc);
    $("#laborprice").val(ql_laborprice);
    $("#laborpdesc").val(ql_laborpdesc);
});
</script>

<script>
$('#closeaddlabor').click(function(e){
    e.preventDefault();
    $("div#addlaborajax").empty();    
});
</script>


<script type='text/javascript'>
$(document).ready(function(){
$('#catchaddlaborform').submit(function(e) { // catch the form's submit event
        e.preventDefault();
	 $('.ajaxspinner').toggle();
        $("div#addlaborajax").empty();
        $("div#addnoninvajax").empty();
        $("div#autoinvsearch").empty();
        $.ajax({ // create an AJAX call...
        data: $(this).serialize(), // get the form data
        type: $(this).attr('method'), // GET or POST
        url: $(this).attr('action'), // the file to call
        success: function(response) { // on success..
                $.get('cart.php?func=cartarea', function(data) {
                $('#cartarea').html(data);
                });
                $.get('cart.php?func=paymentsarea', function(data) {
                $('#paymentsarea').html(data);
                });
		$.get('cart.php?func=customerarea', function(data) {
                $('#customerarea').html(data);
                });
                $.get('cart.php?func=paymentmethodsarea', function(data) {
                $('#paymentmethodsarea').html(data);
                });
                $.get('cart.php?func=newinvoicearea', function(data) {
                $('#newinvoicearea').html(data);
                });
                $.get('cart.php?func=cartfloaterarea', function(data) {
                $('#bottomnavbarfixedlight').html(data);
                });
		 $('.ajaxspinner').toggle();
    }
    });
});
});
</script>

<?php


echo "</td></tr></table>";

}


function add_noninv_ajax() {

require("deps.php");
require_once("common.php");
require("headerincludes.php");

echo "<a href=\"javascript:void(0);\" class=\"linkbuttonmedium linkbuttonred2 floatright radiusall\" id=closeaddnoninv><i class=\"fa fa-times fa-lg\"></i></a>";

echo "<table style=\"width:100%\"><tr><td style=\"vertical-align:top;text-align:left;width:25%;padding:4px;\">";
echo "<form action=cart.php?func=add_noninv id=catchnoninvaddform name=newinv method=post>";
echo pcrtlang("Qty")."/".pcrtlang("Price").":<br><input type=number class=textboxw name=qty value=1 min=\"1\" step=\"1\" style=\"width:40px;\">";

$usertaxid = getusertaxid();
$salestaxrateremain = (1 + getsalestaxrate($usertaxid));

echo "$money<input autofocus type=text style=\"width:50px;\" class=textbox name=itemprice id=itemprice>";

if($salestaxrateremain != 1) {
echo "<button id=pretax class=button type=button onclick='document.getElementById(\"itemprice\").value=(document.getElementById(\"itemprice\").value / $salestaxrateremain).toFixed(5);this.disabled=true;'>
<i class=\"fa fa-calculator\"></i></button>";
}

echo "<br><br>";
echo pcrtlang("Our Unit Cost")."/".pcrtlang("Markup").":<br>";
echo "$money<input type=text class=textbox name=ourprice style=\"width:50px;\" value=\"0.00\">";

?>
<script>
function markup() {
var marknum = Math.ceil((document.newinv.ourprice.value - 0) * (document.newinv.chooser.value - 0)) - document.newinv.cents.value;
document.newinv.itemprice.value = marknum.toFixed(2);
}
</script>
<?php

echo "<select name=chooser onChange=\"markup()\">
<option value=\"1.0\"></option>
<option value=\"1.04\">4%</option>
<option value=\"1.1\">10%</option>
<option value=\"1.2\">20%</option>
<option value=\"1.3\">30%</option>
<option value=\"1.4\">40%</option>
<option value=\"1.5\">50%</option>
<option value=\"1.75\">75%</option>
<option value=\"2\">2X</option>
<option value=\"3\">3X</option>
<option value=\"5\">5X</option>
<option value=\"10\">10X</option>
</select>";

echo "<select name=cents onChange=\"markup()\">
<option value=\"0.10\">90 ".pcrtlang("cents")."</option>
<option value=\"0.05\">95 ".pcrtlang("cents")."</option>
<option value=\"0.01\">99 ".pcrtlang("cents")."</option>
<option value=\"00\">00 ".pcrtlang("cents")."</option>
</select><br><br>";



echo pcrtlang("Product Name").":<br><input type=text class=textbox style=\"width:90%\" name=itemdesc id=ni_title><br><br>";
echo pcrtlang("Printed Description").":<br><textarea class=textbox style=\"width:90%\" name=stock_pdesc id=ni_pdesc></textarea><br><br>";
echo pcrtlang("Item Serial/Code").": <span class=\"sizemesmaller italme\">(".pcrtlang("optional").")</span><br><input type=text class=textbox style=\"width:90%\" name=itemserial><br><br>";
echo "<button type=submit class=button><i class=\"fa fa-cart-plus\"></i> ".pcrtlang("Add to Cart")."</button></form>";


echo "</td><td style=\"width:75%;vertical-align:top\">";
echo "<div class=positemgrid style=\"height:450px;overflow-x:auto;scrollbar-width: thin;\">";


$rs_qni = "SELECT * FROM stocknoninv ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_qni);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$niid = "$rs_result_q1->niid";
$ni_title = "$rs_result_q1->ni_title";
$ni_price = "$rs_result_q1->ni_price";
$theorder = "$rs_result_q1->theorder";
$ni_pdesc = "$rs_result_q1->ni_pdesc";

$primero = mb_substr("$ni_title", 0, 1);

if("$primero" != "-") {
echo "<form class=noninvitem>
<input type=hidden name=ni_title value=\"".pf("$ni_title")."\">
<input type=hidden name=ni_price value=\"".pf(mf("$ni_price"))."\">
<input type=hidden name=ni_pdesc value=\"".pf("$ni_pdesc")."\">
<button type=\"submit\" class=\"linkbuttonsmall linkbuttongray radiusall\" style=\"width:100px;height:75px;margin:5px\"><span class=\"sizemelarger\">$money".mf("$ni_price")."</span><br><span style=\"font-weight:normal;\">$ni_title</span></button></form>";

} else {
$ni_title = mb_substr("$ni_title", 1);
echo "<span class=\"linkbuttonsmall linkbuttongraylabel radiusall\" style=\"width:100px;height:75px;margin:5px\"><br>$ni_title</span>";
}

}

echo "</div>";

?>
<script>
$('.noninvitem').submit(function(e){
    e.preventDefault();
    var ni_title = $(this).find('input[name="ni_title"]').val();
    var ni_price = $(this).find('input[name="ni_price"]').val();
    var ni_pdesc = $(this).find('input[name="ni_pdesc"]').val();
    $("#ni_title").val(ni_title);
    $("#itemprice").val(ni_price);
    $("#ni_pdesc").val(ni_pdesc);
    $("#pretax").prop('disabled', false);
});
</script>

<script>
$('#closeaddnoninv').click(function(e){
    e.preventDefault();
    $("div#addnoninvajax").empty();
});
</script>

<script type='text/javascript'>
$(document).ready(function(){
$('#catchnoninvaddform').submit(function(e) { // catch the form's submit event
        e.preventDefault();
	 $('.ajaxspinner').toggle();
     	$("div#addlaborajax").empty();
     	$("div#addnoninvajax").empty();
	$("div#autoinvsearch").empty();
        $.ajax({ // create an AJAX call...
        data: $(this).serialize(), // get the form data
        type: $(this).attr('method'), // GET or POST
        url: $(this).attr('action'), // the file to call
        success: function(response) { // on success..
                $.get('cart.php?func=cartarea', function(data) {
                $('#cartarea').html(data);
                });
                $.get('cart.php?func=paymentsarea', function(data) {
                $('#paymentsarea').html(data);
                });
                $.get('cart.php?func=customerarea', function(data) {
                $('#customerarea').html(data);
                });
                $.get('cart.php?func=paymentmethodsarea', function(data) {
                $('#paymentmethodsarea').html(data);
                });
                $.get('cart.php?func=newinvoicearea', function(data) {
                $('#newinvoicearea').html(data);
                });

                $.get('cart.php?func=cartfloaterarea', function(data) {
                $('#bottomnavbarfixedlight').html(data);
                });
		 $('.ajaxspinner').toggle();
    }
    });
});
});
</script>


<?php


echo "</td></tr></table>";

}


function newinvoiceareaold() {

require("deps.php");
require_once("common.php");
require("headerincludes.php");

if ($gomodal == 1) {
$therel = "rel=facebox";
} else {
$therel = "";
}


$cartcheck = cartcheck();

$rs_find_item_total = "SELECT SUM(cart_price) AS total_price_parts FROM cart WHERE cart_type = 'purchase' AND ipofpc = '$ipofpc'";
$rs_find_result_total = mysqli_query($rs_connect, $rs_find_item_total);

$rs_find_result_total_q = mysqli_fetch_object($rs_find_result_total);
$rs_total_parts = "$rs_find_result_total_q->total_price_parts";

if ($rs_total_parts == "") {
$rs_total_parts = "0.00";
}

$rs_find_itemtax_total = "SELECT SUM(itemtax) AS total_tax_parts FROM cart WHERE cart_type = 'purchase' AND ipofpc = '$ipofpc'";
$rs_find_result_taxtotal = mysqli_query($rs_connect, $rs_find_itemtax_total);
$rs_find_result_taxtotal_q = mysqli_fetch_object($rs_find_result_taxtotal);
$rs_total_partstax = "$rs_find_result_taxtotal_q->total_tax_parts";

$rs_find_labor_total = "SELECT SUM(cart_price) AS total_labor_price FROM cart WHERE cart_type = 'labor' AND ipofpc = '$ipofpc'";
$rs_find_result_labor_total = mysqli_query($rs_connect, $rs_find_labor_total);
$rs_find_result_labor_total_q = mysqli_fetch_object($rs_find_result_labor_total);
$rs_total_labor = "$rs_find_result_labor_total_q->total_labor_price";

if ($rs_total_labor == "") {
$rs_total_labor = "0.00";
}


$rs_find_labortax_total = "SELECT SUM(itemtax) AS total_labortax_price FROM cart WHERE cart_type = 'labor' AND ipofpc = '$ipofpc'";
$rs_find_result_taxlabor_total = mysqli_query($rs_connect, $rs_find_labortax_total);
$rs_find_result_labortax_total_q = mysqli_fetch_object($rs_find_result_taxlabor_total);
$rs_total_labortax = "$rs_find_result_labortax_total_q->total_labortax_price";


$rs_find_refund_total = "SELECT SUM(cart_price) AS total_price_parts FROM cart WHERE cart_type = 'refund' AND ipofpc = '$ipofpc'";
$rs_find_result_refund_total = mysqli_query($rs_connect, $rs_find_refund_total);
$rs_find_result_refund_total_q = mysqli_fetch_object($rs_find_result_refund_total);
$rs_total_refund = "$rs_find_result_refund_total_q->total_price_parts";


if ($rs_total_refund == "") {
$rs_total_refund = "0.00";
}

$rs_find_refund_totalref = "SELECT SUM(itemtax) AS total_price_partsref FROM cart WHERE cart_type = 'refund' AND ipofpc = '$ipofpc'";
$rs_find_result_refund_totalref = mysqli_query($rs_connect, $rs_find_refund_totalref);
$rs_find_result_refund_totalref_q = mysqli_fetch_object($rs_find_result_refund_totalref);
$rs_total_refundtax = "$rs_find_result_refund_totalref_q->total_price_partsref";

$rs_find_refundlabor_total = "SELECT SUM(cart_price) AS total_price_refundlabor FROM cart WHERE cart_type = 'refundlabor' AND ipofpc = '$ipofpc'";
$rs_find_result_refundlabor_total = mysqli_query($rs_connect, $rs_find_refundlabor_total);
$rs_find_result_refundlabor_total_q = mysqli_fetch_object($rs_find_result_refundlabor_total);
$rs_total_refundlabor = "$rs_find_result_refundlabor_total_q->total_price_refundlabor";

if ($rs_total_refundlabor == "") {
$rs_total_refundlabor = "0.00";
}

$rs_find_refundlabor_totalref = "SELECT SUM(itemtax) AS total_price_refundlabor FROM cart WHERE cart_type = 'refundlabor' AND ipofpc = '$ipofpc'";
$rs_find_result_refundlabor_totalref = mysqli_query($rs_connect, $rs_find_refundlabor_totalref);
$rs_find_result_refundlabor_totalref_q = mysqli_fetch_object($rs_find_result_refundlabor_totalref);
$rs_total_refundlabortax = "$rs_find_result_refundlabor_totalref_q->total_price_refundlabor";

$rs_total_partstax = tnv($rs_total_partstax);
$rs_total_parts = tnv($rs_total_parts);
$rs_total_labortax = tnv($rs_total_labortax);
$rs_total_labor = tnv($rs_total_labor);
$rs_total_refundtax = tnv($rs_total_refundtax);
$rs_total_refund = tnv($rs_total_refund);
$rs_total_refundlabor = tnv($rs_total_refundlabor);
$rs_total_refundlabortax = tnv($rs_total_refundlabortax);


$grand_total = mf(($rs_total_partstax + $rs_total_parts + $rs_total_labortax + $rs_total_labor) - ($rs_total_refundtax + $rs_total_refund +
$rs_total_refundlabor + $rs_total_refundlabortax));

$paidtax = (($rs_total_partstax + $rs_total_labortax) - ($rs_total_refundtax + $rs_total_refundlabortax));
$abstax = mf("$paidtax");

$rs_find_cart_items = "SELECT cart_item_id FROM cart WHERE cart_type = 'purchase' AND ipofpc = '$ipofpc'";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);
$rs_find_cart_labor = "SELECT cart_item_id FROM cart WHERE cart_type = 'labor' AND ipofpc = '$ipofpc'";
$rs_result_labor = mysqli_query($rs_connect, $rs_find_cart_labor);
$rs_find_cart_returns = "SELECT cart_item_id FROM cart WHERE cart_type = 'refund' AND ipofpc = '$ipofpc'";
$rs_result_returns = mysqli_query($rs_connect, $rs_find_cart_returns);
$rs_find_cart_refundlabor = "SELECT cart_item_id FROM cart WHERE cart_type = 'refundlabor' AND ipofpc = '$ipofpc'";
$rs_result_refundlabor = mysqli_query($rs_connect, $rs_find_cart_refundlabor);

$purchasecount = mysqli_num_rows($rs_result);
$laborcount = mysqli_num_rows($rs_result_labor);
$returnscount = mysqli_num_rows($rs_result_returns);
$returncount = $returnscount;
$refundlaborcount = mysqli_num_rows($rs_result_refundlabor);


$findcurrentcustomer = "SELECT * FROM currentcustomer WHERE byuser = '$ipofpc'";
$findcurrentcustomerq = @mysqli_query($rs_connect, $findcurrentcustomer);

$existcust = mysqli_num_rows($findcurrentcustomerq);

if($existcust == 1) {
$findcurrentcustomera = mysqli_fetch_object($findcurrentcustomerq);
$cfirstname = "$findcurrentcustomera->cfirstname";
$ccompany = "$findcurrentcustomera->ccompany";
$caddress = "$findcurrentcustomera->caddress";
$caddress2 = "$findcurrentcustomera->caddress2";
$ccity = "$findcurrentcustomera->ccity";
$cstate = "$findcurrentcustomera->cstate";
$czip = "$findcurrentcustomera->czip";
$cphone = "$findcurrentcustomera->cphone";
$cemail = "$findcurrentcustomera->cemail";
$cwoid = "$findcurrentcustomera->woid";
$cinvoiceid = "$findcurrentcustomera->invoiceid";
$crinvoiceid = "$findcurrentcustomera->rinvoiceid";
$pcgroupid = "$findcurrentcustomera->pcgroupid";
} else {
$cfirstname = "";
$ccompany = "";
$caddress = "";
$caddress2 = "";
$ccity = "";
$cstate = "";
$czip = "";
$cphone = "";
$cemail = "";
$cwoid = "";
$cinvoiceid = "";
$crinvoiceid = "0";
$pcgroupid = "0";
}

$cfirstname_ue = urlencode($cfirstname);
$ccompany_ue = urlencode($ccompany);
$caddress_ue = urlencode($caddress);
$caddress2_ue = urlencode($caddress2);
$ccity_ue = urlencode($ccity);
$cstate_ue = urlencode($cstate);
$czip_ue = urlencode($czip);
$cphone_ue = urlencode($cphone);
$cemail_ue = urlencode($cemail);



if (($purchasecount != "0") || ($laborcount != "0")) {
if ((mysqli_num_rows($rs_result_returns) == "0") && (mysqli_num_rows($rs_result_refundlabor) == "0")) {
echo "<br>";
start_box();
echo "<a href=invoice.php?func=createinvoice&cfirstname=$cfirstname_ue&ccompany=$ccompany_ue&caddress1=$caddress_ue&caddress2=$caddress2_ue&ccity=$ccity_ue&cstate=$cstate_ue&czip=$czip_ue&cphone=$cphone_ue&cemail=$cemail_ue&pcgroupid=$pcgroupid&woid=$cwoid $therel class=\"linkbuttonmedium linkbuttongray radiusleft\"><img src=images/invoice.png class=iconmedium> ".pcrtlang("Create New Invoice/Quote")."</a>";

if($cinvoiceid != "") {
$totalinvoicesincart = count(explode_list($cinvoiceid));
if($totalinvoicesincart == "1") {
$iorq = invoiceorquote($cinvoiceid);
if ($iorq == "quote") {
$ilabel = pcrtlang("Quote");
} else {
$ilabel = pcrtlang("Invoice");
}
echo "<a href=invoice.php?func=createinvoice&cfirstname=$cfirstname_ue&ccompany=$ccompany_ue&caddress1=$caddress_ue&caddress2=$caddress2_ue&ccity=$ccity_ue&cstate=$cstate_ue&czip=$czip_ue&cphone=$cphone_ue&cemail=$cemail_ue&cinvoiceid=$cinvoiceid&woid=$cwoid&pcgroupid=$pcgroupid $therel  class=\"linkbuttonmedium linkbuttongray\"><img src=images/invoice.png class=iconmedium> ".pcrtlang("Save")." $ilabel #$cinvoiceid</a> ";
}
}

if ($crinvoiceid == 0) {
echo "<a href=rinvoice.php?func=createrinvoice&cfirstname=$cfirstname_ue&ccompany=$ccompany_ue&caddress1=$caddress_ue&caddress2=$caddress2_ue&ccity=$ccity_ue&cstate=$cstate_ue&czip=$czip_ue&cphone=$cphone_ue&cemail=$cemail_ue&pcgroupid=$pcgroupid $therel  class=\"linkbuttonmedium linkbuttongray\"><img src=images/rinvoice.png class=iconmedium> ".pcrtlang("Create New Recurring Invoice")."</a>";
}



if ($crinvoiceid != 0) {
echo "<a href=rinvoice.php?func=createrinvoice&cfirstname=$cfirstname_ue&ccompany=$ccompany_ue&caddress1=$caddress_ue&caddress2=$caddress2_ue&ccity=$ccity_ue&cstate=$cstate_ue&czip=$czip_ue&cphone=$cphone_ue&cemail=$cemail_ue&crinvoiceid=$crinvoiceid&pcgroupid=$pcgroupid $therel  class=\"linkbuttonmedium linkbuttongray\"><img src=images/rinvoice.png class=iconmedium> ".pcrtlang("Save Recurring Invoice")." #$crinvoiceid</a>";
}


echo "<a href=cart.php?func=show_quote  class=\"linkbuttonmedium linkbuttongray\"><img src=images/print.png class=iconmedium> ".pcrtlang("Print Quick Quote/Estimate")."</a>";

if ($cfirstname_ue != "") {
$backurl = urlencode("../store/cart.php");
echo "<a href=\"../repair/addresslabel.php?pcname=$cfirstname_ue&pccompany=$ccompany_ue&pcaddress1=$caddress_ue&pcaddress2=$caddress2_ue&pccity=$ccity_ue&pcstate=$cstate_ue&pczip=$czip_ue&dymojsapi=html&backurl=$backurl\"  class=\"linkbuttonmedium linkbuttongray\"><img src=../repair/images/labelprinter.png class=iconmedium> ".pcrtlang("Print Address Label")."</a>";
}
stop_box();
}
}

echo "<br><br>";
if (($purchasecount != "0") || ($laborcount != "0")) {
if (($returncount == '0') && ($refundlaborcount == "0")) {

start_box();
echo "<table><tr><td>";
echo "<form action=cart.php?func=savecart method=post>";
echo "<input type=text name=cartname class=textbox placeholder=\"".pcrtlang("Enter Cart Name")."\"><input type=hidden name=cartcheck value=\"$cartcheck\"><button class=button type=button onclick=\"this.disabled=true; this.form.submit();\"><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save Cart")."</button></form>";

echo "</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>";

echo "<form action=cart.php?func=savecart&iskit=1 method=post>";
echo "<input type=text name=cartname class=textbox required placeholder=\"".pcrtlang("Enter Kit Name")."\"><input type=hidden name=cartcheck value=\"$cartcheck\"><button class=button type=submit><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save Cart as Kit")."</button></form>";

echo "</td></tr></table>";

echo "<br><form method=post action=cart.php?func=copycurrenttorepaircart><select name=pcwo>";

echo "<option value=0>".pcrtlang("Choose Customer")."</option>";

$rs_findpcs = "SELECT * FROM pc_wo WHERE pcstatus != '5' AND  pcstatus != '7'";
$rs_findpcssr = mysqli_query($rs_connect, $rs_findpcs);
while($rs_result_qsr = mysqli_fetch_object($rs_findpcssr)) {
$pcidsr = "$rs_result_qsr->pcid";
$woidsr = "$rs_result_qsr->woid";
$dropdate = "$rs_result_qsr->dropdate";
$rs_findowner = "SELECT * FROM pc_owner WHERE pcid = '$pcidsr'";
$rs_result2sr = mysqli_query($rs_connect, $rs_findowner);
while($rs_result_q2sr = mysqli_fetch_object($rs_result2sr)) {
$pcname = "$rs_result_q2sr->pcname";
$pccompany = "$rs_result_q2sr->pccompany";
$pcmake = "$rs_result_q2sr->pcmake";

echo "<option value=$woidsr>#$pcidsr $pcname $pccompany</option>";
}
}


echo "</select><button type=button class=button onclick=\"this.disabled=true; this.form.submit();\"><i class=\"fa fa-copy\"></i> ".pcrtlang("Copy Current Cart to Repair Cart")."</button></form>";

stop_box();
echo "<br><br>";
}
}


}

###

function newinvoicearea() {

require("deps.php");
require_once("common.php");
require("headerincludes.php");

if ($gomodal == 1) {
$therel = "rel=facebox";
} else {
$therel = "";
}


$cartcheck = cartcheck();

$rs_find_item_total = "SELECT SUM(cart_price) AS total_price_parts FROM cart WHERE cart_type = 'purchase' AND ipofpc = '$ipofpc'";
$rs_find_result_total = mysqli_query($rs_connect, $rs_find_item_total);

$rs_find_result_total_q = mysqli_fetch_object($rs_find_result_total);
$rs_total_parts = "$rs_find_result_total_q->total_price_parts";

if ($rs_total_parts == "") {
$rs_total_parts = "0.00";
}

$rs_find_itemtax_total = "SELECT SUM(itemtax) AS total_tax_parts FROM cart WHERE cart_type = 'purchase' AND ipofpc = '$ipofpc'";
$rs_find_result_taxtotal = mysqli_query($rs_connect, $rs_find_itemtax_total);
$rs_find_result_taxtotal_q = mysqli_fetch_object($rs_find_result_taxtotal);
$rs_total_partstax = "$rs_find_result_taxtotal_q->total_tax_parts";

$rs_find_labor_total = "SELECT SUM(cart_price) AS total_labor_price FROM cart WHERE cart_type = 'labor' AND ipofpc = '$ipofpc'";
$rs_find_result_labor_total = mysqli_query($rs_connect, $rs_find_labor_total);
$rs_find_result_labor_total_q = mysqli_fetch_object($rs_find_result_labor_total);
$rs_total_labor = "$rs_find_result_labor_total_q->total_labor_price";

if ($rs_total_labor == "") {
$rs_total_labor = "0.00";
}


$rs_find_labortax_total = "SELECT SUM(itemtax) AS total_labortax_price FROM cart WHERE cart_type = 'labor' AND ipofpc = '$ipofpc'";
$rs_find_result_taxlabor_total = mysqli_query($rs_connect, $rs_find_labortax_total);
$rs_find_result_labortax_total_q = mysqli_fetch_object($rs_find_result_taxlabor_total);
$rs_total_labortax = "$rs_find_result_labortax_total_q->total_labortax_price";


$rs_find_refund_total = "SELECT SUM(cart_price) AS total_price_parts FROM cart WHERE cart_type = 'refund' AND ipofpc = '$ipofpc'";
$rs_find_result_refund_total = mysqli_query($rs_connect, $rs_find_refund_total);
$rs_find_result_refund_total_q = mysqli_fetch_object($rs_find_result_refund_total);
$rs_total_refund = "$rs_find_result_refund_total_q->total_price_parts";


if ($rs_total_refund == "") {
$rs_total_refund = "0.00";
}

$rs_find_refund_totalref = "SELECT SUM(itemtax) AS total_price_partsref FROM cart WHERE cart_type = 'refund' AND ipofpc = '$ipofpc'";
$rs_find_result_refund_totalref = mysqli_query($rs_connect, $rs_find_refund_totalref);
$rs_find_result_refund_totalref_q = mysqli_fetch_object($rs_find_result_refund_totalref);
$rs_total_refundtax = "$rs_find_result_refund_totalref_q->total_price_partsref";

$rs_find_refundlabor_total = "SELECT SUM(cart_price) AS total_price_refundlabor FROM cart WHERE cart_type = 'refundlabor' AND ipofpc = '$ipofpc'";
$rs_find_result_refundlabor_total = mysqli_query($rs_connect, $rs_find_refundlabor_total);
$rs_find_result_refundlabor_total_q = mysqli_fetch_object($rs_find_result_refundlabor_total);
$rs_total_refundlabor = "$rs_find_result_refundlabor_total_q->total_price_refundlabor";

if ($rs_total_refundlabor == "") {
$rs_total_refundlabor = "0.00";
}

$rs_find_refundlabor_totalref = "SELECT SUM(itemtax) AS total_price_refundlabor FROM cart WHERE cart_type = 'refundlabor' AND ipofpc = '$ipofpc'";
$rs_find_result_refundlabor_totalref = mysqli_query($rs_connect, $rs_find_refundlabor_totalref);
$rs_find_result_refundlabor_totalref_q = mysqli_fetch_object($rs_find_result_refundlabor_totalref);
$rs_total_refundlabortax = "$rs_find_result_refundlabor_totalref_q->total_price_refundlabor";

$rs_total_partstax = tnv($rs_total_partstax);
$rs_total_parts = tnv($rs_total_parts);
$rs_total_labortax = tnv($rs_total_labortax);
$rs_total_labor = tnv($rs_total_labor);
$rs_total_refundtax = tnv($rs_total_refundtax);
$rs_total_refund = tnv($rs_total_refund);
$rs_total_refundlabor = tnv($rs_total_refundlabor);
$rs_total_refundlabortax = tnv($rs_total_refundlabortax);


$grand_total = mf(($rs_total_partstax + $rs_total_parts + $rs_total_labortax + $rs_total_labor) - ($rs_total_refundtax + $rs_total_refund +
$rs_total_refundlabor + $rs_total_refundlabortax));

$paidtax = (($rs_total_partstax + $rs_total_labortax) - ($rs_total_refundtax + $rs_total_refundlabortax));
$abstax = mf("$paidtax");

$rs_find_cart_items = "SELECT cart_item_id FROM cart WHERE cart_type = 'purchase' AND ipofpc = '$ipofpc'";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);
$rs_find_cart_labor = "SELECT cart_item_id FROM cart WHERE cart_type = 'labor' AND ipofpc = '$ipofpc'";
$rs_result_labor = mysqli_query($rs_connect, $rs_find_cart_labor);
$rs_find_cart_returns = "SELECT cart_item_id FROM cart WHERE cart_type = 'refund' AND ipofpc = '$ipofpc'";
$rs_result_returns = mysqli_query($rs_connect, $rs_find_cart_returns);
$rs_find_cart_refundlabor = "SELECT cart_item_id FROM cart WHERE cart_type = 'refundlabor' AND ipofpc = '$ipofpc'";
$rs_result_refundlabor = mysqli_query($rs_connect, $rs_find_cart_refundlabor);

$purchasecount = mysqli_num_rows($rs_result);
$laborcount = mysqli_num_rows($rs_result_labor);
$returnscount = mysqli_num_rows($rs_result_returns);
$returncount = $returnscount;
$refundlaborcount = mysqli_num_rows($rs_result_refundlabor);


$findcurrentcustomer = "SELECT * FROM currentcustomer WHERE byuser = '$ipofpc'";
$findcurrentcustomerq = @mysqli_query($rs_connect, $findcurrentcustomer);

$existcust = mysqli_num_rows($findcurrentcustomerq);

if($existcust == 1) {
$findcurrentcustomera = mysqli_fetch_object($findcurrentcustomerq);
$cfirstname = "$findcurrentcustomera->cfirstname";
$ccompany = "$findcurrentcustomera->ccompany";
$caddress = "$findcurrentcustomera->caddress";
$caddress2 = "$findcurrentcustomera->caddress2";
$ccity = "$findcurrentcustomera->ccity";
$cstate = "$findcurrentcustomera->cstate";
$czip = "$findcurrentcustomera->czip";
$cphone = "$findcurrentcustomera->cphone";
$cemail = "$findcurrentcustomera->cemail";
$cwoid = "$findcurrentcustomera->woid";
$cinvoiceid = "$findcurrentcustomera->invoiceid";
$crinvoiceid = "$findcurrentcustomera->rinvoiceid";
$pcgroupid = "$findcurrentcustomera->pcgroupid";
} else {
$cfirstname = "";
$ccompany = "";
$caddress = "";
$caddress2 = "";
$ccity = "";
$cstate = "";
$czip = "";
$cphone = "";
$cemail = "";
$cwoid = "";
$cinvoiceid = "";
$crinvoiceid = "0";
$pcgroupid = "0";
}

$cfirstname_ue = urlencode($cfirstname);
$ccompany_ue = urlencode($ccompany);
$caddress_ue = urlencode($caddress);
$caddress2_ue = urlencode($caddress2);
$ccity_ue = urlencode($ccity);
$cstate_ue = urlencode($cstate);
$czip_ue = urlencode($czip);
$cphone_ue = urlencode($cphone);
$cemail_ue = urlencode($cemail);


$usertaxid = getusertaxid();
$rs_find_taxs = "SELECT * FROM taxes WHERE taxid = '$usertaxid'";
$rs_result_taxs = mysqli_query($rs_connect, $rs_find_taxs);
$rs_result_tqs = mysqli_fetch_object($rs_result_taxs);
$rs_taxnames = "$rs_result_tqs->taxname";
echo "<div class=\"nvmdropdown\">";
echo "<button class=\"nvmdropbtn\" style=\"background:#ff0000;color:#ffffff\"><i class=\"fa fa-percent\"></i> ".pcrtlang("Tax").": $rs_taxnames";
echo " <i class=\"fa fa-caret-down\"></i>";
echo "</button>";
echo "<div class=\"nvmdropdown-content\">";
$rs_find_tax = "SELECT * FROM taxes WHERE taxenabled = '1' ORDER BY taxname ASC";
$rs_result_tax = mysqli_query($rs_connect, $rs_find_tax);
while($rs_result_tq = mysqli_fetch_object($rs_result_tax)) {
$rs_taxname = "$rs_result_tq->taxname";
$rs_taxid = "$rs_result_tq->taxid";
echo "<a href=cart.php?func=setusertax&settaxname=$rs_taxid>$rs_taxname</a>";
}
echo "</div>";
echo "</div>";


if (($purchasecount != "0") || ($laborcount != "0")) {
if (($returncount == '0') && ($refundlaborcount == "0")) {
echo "<div class=\"nvmdropdown\">";
echo "<button class=\"nvmdropbtn\"><i class=\"fa fa-shopping-cart fa-lg\"></i> ".pcrtlang("Cart Actions");
echo " <i class=\"fa fa-caret-down\"></i>";
echo "</button>";
echo "<div class=\"nvmdropdown-content\" style=\"padding:10px;\">";

echo "<form action=cart.php?func=savecart method=post>";
echo "<input type=text name=cartname class=textbox style=\"width:100%;box-sizing:border-box\" placeholder=\"".pcrtlang("Enter Cart Name")."\"><input type=hidden name=cartcheck value=\"$cartcheck\">";
echo "<br><button class=button type=button onclick=\"this.disabled=true; this.form.submit();\"><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save Cart")."</button></form>";


echo "<br><form action=cart.php?func=savecart&iskit=1 method=post>";
echo "<input type=text name=cartname style=\"width:100%;box-sizing:border-box\" class=textbox required placeholder=\"".pcrtlang("Enter Kit Name")."\">";
echo "<input type=hidden name=cartcheck value=\"$cartcheck\"><br><button class=button type=submit><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save Cart as Kit")."</button></form>";


echo "<br><form method=post action=cart.php?func=copycurrenttorepaircart><select name=pcwo  style=\"width:100%\">";

echo "<option value=0>".pcrtlang("Choose Customer")."</option>";

$rs_findpcs = "SELECT * FROM pc_wo WHERE pcstatus != '5' AND  pcstatus != '7'";
$rs_findpcssr = mysqli_query($rs_connect, $rs_findpcs);
while($rs_result_qsr = mysqli_fetch_object($rs_findpcssr)) {
$pcidsr = "$rs_result_qsr->pcid";
$woidsr = "$rs_result_qsr->woid";
$dropdate = "$rs_result_qsr->dropdate";
$rs_findowner = "SELECT * FROM pc_owner WHERE pcid = '$pcidsr'";
$rs_result2sr = mysqli_query($rs_connect, $rs_findowner);
while($rs_result_q2sr = mysqli_fetch_object($rs_result2sr)) {
$pcname = "$rs_result_q2sr->pcname";
$pccompany = "$rs_result_q2sr->pccompany";
$pcmake = "$rs_result_q2sr->pcmake";

echo "<option value=$woidsr>#$pcidsr $pcname $pccompany</option>";
}
}

echo "</select>";
echo "<br><button type=button class=button onclick=\"this.disabled=true; this.form.submit();\"><i class=\"fa fa-copy\"></i> ".pcrtlang("Copy Current Cart to Repair Cart")."</button></form>";

echo "</div>";
echo "</div>";

}
}


if (($purchasecount != "0") || ($laborcount != "0")) {
if ((mysqli_num_rows($rs_result_returns) == "0") && (mysqli_num_rows($rs_result_refundlabor) == "0")) {
echo "<div class=\"nvmdropdown\">";
echo "<button class=\"nvmdropbtn\"><i class=\"fa fa-file-invoice fa-lg\"></i> ".pcrtlang("Invoice Actions");
echo " <i class=\"fa fa-caret-down\"></i>";
echo "</button>";
echo "<div class=\"nvmdropdown-content\">";

echo "<a href=invoice.php?func=createinvoice&cfirstname=$cfirstname_ue&ccompany=$ccompany_ue&caddress1=$caddress_ue&caddress2=$caddress2_ue&ccity=$ccity_ue&cstate=$cstate_ue&czip=$czip_ue&cphone=$cphone_ue&cemail=$cemail_ue&pcgroupid=$pcgroupid&woid=$cwoid $therel><img src=images/invoice.png class=iconmedium> ".pcrtlang("Create New Invoice/Quote")."</a>";

if($cinvoiceid != "") {
$totalinvoicesincart = count(explode_list($cinvoiceid));
if($totalinvoicesincart == "1") {
$iorq = invoiceorquote($cinvoiceid);
if ($iorq == "quote") {
$ilabel = pcrtlang("Quote");
} else {
$ilabel = pcrtlang("Invoice");
}
echo "<a href=invoice.php?func=createinvoice&cfirstname=$cfirstname_ue&ccompany=$ccompany_ue&caddress1=$caddress_ue&caddress2=$caddress2_ue&ccity=$ccity_ue&cstate=$cstate_ue&czip=$czip_ue&cphone=$cphone_ue&cemail=$cemail_ue&cinvoiceid=$cinvoiceid&woid=$cwoid&pcgroupid=$pcgroupid $therel><img src=images/invoice.png class=iconmedium> ".pcrtlang("Save")." $ilabel #$cinvoiceid</a> ";
}
}

if ($crinvoiceid == 0) {
echo "<a href=rinvoice.php?func=createrinvoice&cfirstname=$cfirstname_ue&ccompany=$ccompany_ue&caddress1=$caddress_ue&caddress2=$caddress2_ue&ccity=$ccity_ue&cstate=$cstate_ue&czip=$czip_ue&cphone=$cphone_ue&cemail=$cemail_ue&pcgroupid=$pcgroupid $therel><img src=images/rinvoice.png class=iconmedium> ".pcrtlang("Create New Recurring Invoice")."</a>";
}



if ($crinvoiceid != 0) {
echo "<a href=rinvoice.php?func=createrinvoice&cfirstname=$cfirstname_ue&ccompany=$ccompany_ue&caddress1=$caddress_ue&caddress2=$caddress2_ue&ccity=$ccity_ue&cstate=$cstate_ue&czip=$czip_ue&cphone=$cphone_ue&cemail=$cemail_ue&crinvoiceid=$crinvoiceid&pcgroupid=$pcgroupid $therel><img src=images/rinvoice.png class=iconmedium> ".pcrtlang("Save Recurring Invoice")." #$crinvoiceid</a>";
}


echo "<a href=cart.php?func=show_quote><img src=images/print.png class=iconmedium> ".pcrtlang("Print Quick Quote/Estimate")."</a>";

if ($cfirstname_ue != "") {
$backurl = urlencode("../store/cart.php");
echo "<a href=\"../repair/addresslabel.php?pcname=$cfirstname_ue&pccompany=$ccompany_ue&pcaddress1=$caddress_ue&pcaddress2=$caddress2_ue&pccity=$ccity_ue&pcstate=$cstate_ue&pczip=$czip_ue&dymojsapi=html&backurl=$backurl\"><img src=../repair/images/labelprinter.png class=iconmedium> ".pcrtlang("Print Address Label")."</a>";
}
echo "</div>";
echo "</div>";
}
}

# End Invoice Actions Drop

#save single invoice

#echo "<div class=\"nvdropbtn\">";
if (($purchasecount != "0") || ($laborcount != "0")) {
if ((mysqli_num_rows($rs_result_returns) == "0") && (mysqli_num_rows($rs_result_refundlabor) == "0")) {

if($cinvoiceid != "") {
$totalinvoicesincart = count(explode_list($cinvoiceid));
if($totalinvoicesincart == "1") {
$iorq = invoiceorquote($cinvoiceid);
if ($iorq == "quote") {
$ilabel = pcrtlang("Quote");
} else {
$ilabel = pcrtlang("Invoice");
}
echo "<a href=invoice.php?func=createinvoice&cfirstname=$cfirstname_ue&ccompany=$ccompany_ue&caddress1=$caddress_ue&caddress2=$caddress2_ue&ccity=$ccity_ue&cstate=$cstate_ue&czip=$czip_ue&cphone=$cphone_ue&cemail=$cemail_ue&cinvoiceid=$cinvoiceid&woid=$cwoid&pcgroupid=$pcgroupid $therel class=nvmdropbtn><i class=\"fa fa-save fa-lg\" style=\"color:#00e500\"></i> ".pcrtlang("Save")." $ilabel #$cinvoiceid</a> ";
}
}

if ($crinvoiceid != 0) {
echo "<a href=rinvoice.php?func=createrinvoice&cfirstname=$cfirstname_ue&ccompany=$ccompany_ue&caddress1=$caddress_ue&caddress2=$caddress2_ue&ccity=$ccity_ue&cstate=$cstate_ue&czip=$czip_ue&cphone=$cphone_ue&cemail=$cemail_ue&crinvoiceid=$crinvoiceid&pcgroupid=$pcgroupid $therel class=nvmdropbtn><i class=\"fa fa-save fa-lg\" style=\"color:#00e500\"></i> ".pcrtlang("Save Recurring Invoice")." #$crinvoiceid</a>";
}


}
}

#echo "</div>";

##


$registerid = getcurrentregister();
if($registerid != 0) {
$rs_find_register = "SELECT * FROM registers WHERE registerid = '$registerid'";
$rs_result_register = mysqli_query($rs_connect, $rs_find_register);
$rs_result_registerq = mysqli_fetch_object($rs_result_register);
$rs_registername = "$rs_result_registerq->registername";
} else {
$rs_registername = pcrtlang("Not Set");
}
echo "<div class=\"nvmdropdown\">";
echo "<button class=\"nvmdropbtn\"><i class=\"fa fa-cash-register fa-lg\"></i> $rs_registername";
echo " <i class=\"fa fa-caret-down\"></i>";
echo "</button>";
echo "<div class=\"nvmdropdown-content\">";
$rs_find_registers = "SELECT * FROM registers WHERE registerstoreid = '$defaultuserstore' ORDER BY registername ASC";
$rs_result_registers = mysqli_query($rs_connect, $rs_find_registers);
while($rs_result_registerq = mysqli_fetch_object($rs_result_registers)) {
$rs_registername = "$rs_result_registerq->registername";
$rs_registerid = "$rs_result_registerq->registerid";
echo "<a href=cart.php?func=setregister&setregisterid=$rs_registerid><i class=\"fa fa-cash-register\"></i> $rs_registername</a>";
}
if (perm_check("30")) {
echo "<a href=cart.php?func=register_close><i class=\"fa fa-coins\"></i> ".pcrtlang("Close Register")."</a>";
}
echo "</div>";
echo "</div>";



}


###

function setregister() {
require_once("validate.php");

require("deps.php");
require("common.php");

$setregisterid = $_REQUEST['setregisterid'];

if(isset($cookiedomain)) {
setcookie("registerid", $setregisterid, time()+63072000, "/","$cookiedomain");
} else {
setcookie("registerid", $setregisterid, time()+63072000, "/");
}

header("Location: cart.php");

}



switch($func) {
                                                                                                    
    default:
    show_cart();
    break;
                                
    case "add_item":
    add_item();
    break;

 case "add_noninv":
    add_noninv();
    break;

case "add_noninv2":
    add_noninv2();
    break;

    case "add_labor":
    add_labor();
    break;

    case "add_labor2":
    add_labor2();
    break;

    case "remove_cart_item":
    remove_cart_item();
    break;

    case "empty_cart":
    empty_cart();
    break;

    case "add_return":
    add_return();
    break;

    case "show_quote":
    show_quote();
    break;

    case "discount_cart_item":
    discount_cart_item();
    break;

    case "custom_price":
    custom_price();
    break;

   case "savecart":
    savecart();
    break;

  case "show_savecart":
    show_savecart();
    break;

 case "show_repcart":
    show_repcart();
    break;

 case "show_savecarts":
    show_savecarts();
    break;

  case "del_savecart":
    del_savecart();
    break;

 case "loadsavecart":
    loadsavecart();
    break;

case "copysavecart":
    copysavecart();
    break;

case "copycurrenttorepaircart":
    copycurrenttorepaircart();
    break;


 case "setusertax":
    setusertax();
    break;

case "setitemtax":
    setitemtax();
    break;

case "savecurrentcustomer":
    savecurrentcustomer();
    break;

case "clearcurrentcustomer":
    clearcurrentcustomer();
    break;

case "removedeposit":
    removedeposit();
    break;

case "pickcustomer":
    pickcustomer();
    break;

case "pickcustomer2":
    pickcustomer2();
    break;

case "pickcustomerajax":
    pickcustomerajax();
    break;

case "addbyserial":
    addbyserial();
    break;

case "addbyserial2":
    addbyserial2();
    break;

case "edit":
    edit();
    break;

case "edit2":
    edit2();
    break;

case "editinvitem":
    editinvitem();
    break;

case "editinvitem2":
    editinvitem2();
    break;

case "removediscount":
    removediscount();
    break;

case "refundlabor":
    refundlabor();
    break;

case "spoaddcart":
    spoaddcart();
    break;

case "resyncprice":
    resyncprice();
    break;

case "register_close":
    register_close();
    break;

case "register_close2":
    register_close2();
    break;

case "switchregister":
    switchregister();
    break;

case "addserialafter":
    addserialafter();
    break;

case "addserialafter2":
    addserialafter2();
    break;

    case "cartarea":
    cartarea();
    break;

    case "paymentsarea":
    paymentsarea();
    break;

    case "paymentmethodsarea":
    paymentmethodsarea();
    break;

    case "customerarea":
    customerarea();
    break;

    case "cartfloaterarea":
    cartfloaterarea();
    break;

    case "newinvoicearea":
    newinvoicearea();
    break;

    case "add_labor_ajax":
    add_labor_ajax();
    break;

    case "add_noninv_ajax":
    add_noninv_ajax();
    break;

    case "setregister":
    setregister();
    break;


}


