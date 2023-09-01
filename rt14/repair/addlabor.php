<?php

require("deps.php");
require_once("common.php");

$pcwo = $_REQUEST['pcwo'];

echo "<br>";
echo "<table width=100%><tr><td width=50% valign=top>";

echo "<table class=moneylist><tr><th>".pcrtlang("Add Labor")."</th></tr><tr><td>";
echo "<form action=repcart.php?func=add_labor2 method=post class=catchrepaircartform><input type=hidden name=pcwo value=$pcwo>";
echo "<span class=\"boldme\">".pcrtlang("Qty")."</span><input type=number class=textboxw name=qty value=1 min=\".01\" step=\".01\" style=\"width:40px;\">";
echo "<input type=text class=textboxw size=40 id=labordesc name=labordesc placeholder=\"".pcrtlang("Enter Labor Title")."\"> <span class=\"boldme\">$money</span><input type=text class=textboxw size=6 name=laborprice id=laborprice required=required onFocus=\"this.form.submitbutton.disabled=false;this.form.submitbutton.value='&laquo;".pcrtlang("Add Labor")."';\">";

$usertaxid = getusertaxid();
$servicetaxrateremain = (1 + getservicetaxrate($usertaxid));
if($servicetaxrateremain != 1) {
echo "<button class=button type=button title=\"".pcrtlang("Pre-Tax Calculator")."\" onclick='document.getElementById(\"laborprice\").value=(document.getElementById(\"laborprice\").value / $servicetaxrateremain).toFixed(5)'>
<i class=\"fa fa-calculator\"></i></button>";
}

echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<textarea class=textboxw cols=50 rows=1 id=laborpdesc name=laborpdesc placeholder=\"".pcrtlang("Enter Optional Printed Labor Description")."\"></textarea>";
echo "<button type=submit class=button id=submitbutton style=\"float:right;\"><i class=\"fa fa-arrow-circle-right\"></i> <i class=\"fa fa-shopping-cart\"></i></button></form>";
echo "</td></tr></table><br>";

echo "<table class=moneylist><tr><th>".pcrtlang("Add Items from Inventory")."</th></tr><tr><td>";
echo "<form action=repcart.php?func=add_item method=post class=catchrepaircartform><input type=hidden name=pcwo value=$pcwo>";
echo "<span class=\"boldme\">".pcrtlang("Qty")."</span><input type=number class=textboxw name=qty value=1 min=1 step=1 style=\"width:40px;\">";
echo "<input type=text class=textboxw size=45 autocomplete=off id=autoinvsearchbox name=\"stockid\" placeholder=\"".pcrtlang("Enter Stock Id Numbers or Search Term")."\">";
echo "<button type=submit class=button style=\"float:right;\"><i class=\"fa fa-arrow-circle-right\"></i> <i class=\"fa fa-shopping-cart\"></i></button></form>";
echo "<div id=\"autoinvsearch\"></div>";
echo "</td></tr></table><br>";

echo "<form action=repcart.php?func=add_noninv name=add_noninv id=add_noninv method=post class=catchrepaircartform>";
echo "<table class=moneylist><tr><th>".pcrtlang("Add Non Inventoried Item")."</th></tr><tr><td>";
echo "<span class=\"boldme\">".pcrtlang("Qty")."</span><input type=number class=textboxw name=qty value=1 min=1 step=1 style=\"width:40px;\">";
echo "<input type=text id=ni_title class=textboxw size=50 name=itemdesc placeholder=\"".pcrtlang("Enter Item Name")."\"></td></tr>";

echo "<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<textarea id=ni_pdesc class=textboxw cols=54 name=itempdesc placeholder=\"".pcrtlang("Enter Optional Printed Item Description")."\"></textarea></td></tr>";

echo "<tr><td><span class=\"boldme\">&nbsp;".pcrtlang("Serial/Code").":&nbsp;</span><span class=\"sizemesmaller italme\">(".pcrtlang("optional").")</span>
<input type=text class=textboxw name=itemserial size=35></td></tr><tr><td>";


echo "<span class=\"boldme\">&nbsp;".pcrtlang("Price")."&nbsp;$money</span><input type=text class=textboxw name=itemprice id=itemprice size=5 required=required>";

$usertaxid = getusertaxid();
$salestaxrateremain = (1 + getsalestaxrate($usertaxid));
if($salestaxrateremain != 1) {
echo "<button class=button type=button title=\"".pcrtlang("Pre-Tax Calculator")."\" onclick='document.getElementById(\"itemprice\").value=(document.getElementById(\"itemprice\").value / $salestaxrateremain).toFixed(5)'>
<i class=\"fa fa-calculator\"></i></button>";
}

echo "<span class=\"boldme\">&nbsp;".pcrtlang("Cost")."&nbsp;$money</span>";
echo "<input type=text class=textboxw name=ourprice size=4 value=\"0.00\"><input type=hidden name=woid value=$pcwo>";

?>
<script>
function markup() {
var marknum = Math.ceil((document.add_noninv.ourprice.value - 0) * (document.add_noninv.chooser.value - 0)) - document.add_noninv.cents.value;
document.add_noninv.itemprice.value = marknum.toFixed(2);
}
</script>



<script type="text/javascript">
$(document).ready(function(){
  $("input#autoinvsearchbox").keyup(function(){
    if(this.value.length<3) {
      $("div#autoinvsearch").slideUp(200,function(){
        return false;
      });
    }else{
        var encodedinv = encodeURIComponent(this.value);
        $('div#autoinvsearch').load('autosearch.php?func=inv&pcwo=<?php echo "$pcwo"; ?>&search='+encodedinv).slideDown(200);
    }
  });
});
</script>

<?php

echo "<span class=\"boldme\">".pcrtlang("Markup").": </span>";
echo "<select name=chooser class=select onChange=\"markup()\">
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
<option value=\"0.10\">90 cents</option>
<option value=\"0.05\">95 cents</option>
<option value=\"0.01\">99 cents</option>
<option value=\"00\">00 cents</option>
</select>";


echo "<button type=submit class=button id=submitbutton style=\"float:right;\"><i class=\"fa fa-arrow-circle-right\"></i> <i class=\"fa fa-shopping-cart\"></i></button>";
echo "</td></tr></table></form>";


echo "<br><table class=moneylist><tr><th>".pcrtlang("Special Order Parts")."</th></tr><tr><td>";
echo "<a href=pc.php?func=addspo&woid=$pcwo class=\"linkbutton catchaddspo\" rel=facebox><i class=\"fa fa-shipping-fast fa-lg\"></i> ".pcrtlang("Add Special Order Part")."</a>";
echo "</td></tr></table><br>";

echo "<table class=moneylist><tr><th>".pcrtlang("Add Kit to Repair Cart")."</th></tr><tr><td>";
echo "<form action=\"../store/cart.php?func=copysavecart\" method=post class=catchrepaircartform><input type=hidden name=pcwo value=$pcwo><select name=cartname>";
$rs_find_cart_items = "SELECT DISTINCT cartname, savedwhen FROM savedcarts WHERE iskit = '1' ORDER BY cartname ASC";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);
while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_cart_name = "$rs_result_q->cartname";
$rs_saved_when = "$rs_result_q->savedwhen";


echo "<option value=\"$rs_cart_name\">$rs_cart_name</option>";
}
echo "</select>";

echo "<button type=submit class=button><i class=\"fa fa-toolbox\"></i> ".pcrtlang("Add Kit to Repair Cart")."</button></form>";

echo "</td></tr></table>";

echo "</td><td width=25% valign=top>";

echo "<div style=\"max-height:600px;overflow-y:auto;scrollbar-width: thin;\">";

echo "<table class=moneylist><tr><th colspan=2>".pcrtlang("Add Quick Labor")."</th></tr>";
$rs_quicklabor = "SELECT * FROM quicklabor ORDER BY theorder DESC";
$rs_result_ql  = mysqli_query($rs_connect, $rs_quicklabor);


while($rs_result_qld = mysqli_fetch_object($rs_result_ql)) {
$labordesc = "$rs_result_qld->labordesc";
$printdesc = "$rs_result_qld->printdesc";
$laborprice = mf("$rs_result_qld->laborprice");
$qlid = "$rs_result_qld->quickid";

$labordesc2 = urlencode("$labordesc");
$printdesc2 = urlencode("$printdesc");

$primero = substr("$labordesc", 0, 1);
if("$primero" != "-") {

echo "<tr><td style=\"text-align:right; padding:2px;\"><form class=quicklaborfill>
<input type=hidden name=labordesc value=\"".pf("$labordesc")."\">
<input type=hidden name=laborprice value=\"".pf(mf("$laborprice"))."\">
<input type=hidden name=laborpdesc value=\"".pf("$printdesc")."\">
<button type=\"submit\" style=\"width:75px\" class=\"linkbuttonsmall linkbuttonmoney radiusall displayblock\">$money".mf("$laborprice")."</button></form></td><td><span class=\"boldme\">$labordesc</span></td></tr>";

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

} else {
$labordesc3 = substr("$labordesc", 1);
echo "<tr><td colspan=2 style=\"vertical-align:bottom\"><span class=\"linkbuttonsmall linkbuttonmoneylabel displayblock radiusall\">$labordesc3</span></td></tr>";
}


}



echo "</table>";

echo "</div>";

#echo "<br><a href=\"repcart.php?func=add_labor2&labordesc=NO%20CHARGE&pcwo=$pcwo&laborprice=0&laborpdesc=\" class=\"linkbuttonmedium linkbuttonmoney displayblock radiusall\"><i class=\"fa fa-ban fa-lg\"></i> ".pcrtlang("NO CHARGE")."</a><br>";
echo "<br><form action=repcart.php?func=add_labor2 method=post class=catchrepaircartform><input type=hidden name=pcwo value=$pcwo><input type=hidden name=labordesc value=\"".pcrtlang("NO CHARGE")."\"><input type=hidden name=laborprice value=0><input type=hidden name=laborpdesc value=\"\"><button type=submit class=\"linkbuttonmedium linkbuttonmoney displayblock radiusall\" style=\"width:100%\"><i class=\"fa fa-ban fa-lg\"></i> ".pcrtlang("NO CHARGE")."</button></form>";


echo "</td>";

echo "<td style=\"width:25%;vertical-align:top\">";

echo "<div style=\"max-height:600px;overflow-y:auto;scrollbar-width: thin;\">";

echo "<table class=moneylist><tr><th colspan=2>".pcrtlang("Add Non-Inventoried Items")."</th></tr>";

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
echo "
<td style=\"text-align:right; padding:2px;\">
<form class=noninvitem>
<input type=hidden name=ni_title value=\"".pf("$ni_title")."\">
<input type=hidden name=ni_price value=\"".pf(mf("$ni_price"))."\">
<input type=hidden name=ni_pdesc value=\"".pf("$ni_pdesc")."\">
<button type=\"submit\" style=\"width:75px\" class=\"linkbuttonsmall linkbuttonmoney radiusall displayblock\">$money".mf("$ni_price")."</button></form></td><td><span class=\"boldme\">$ni_title</span>
</td></tr>";
} else {
$ni_title = mb_substr("$ni_title", 1);
echo "<tr><td colspan=2 style=\"vertical-align:bottom\"><span class=\"linkbuttonsmall linkbuttonmoneylabel displayblock radiusall\">$ni_title</span></td></tr>";
}

echo "</td></tr>";

}

echo "</table>";

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
});


</script>

<?php


echo "</td>";

echo "</tr></table>";
stop_box();

?>

<script type='text/javascript'>
$(document).ready(function(){
$('.catchrepaircartform').submit(function(e) { // catch the form's submit event
        e.preventDefault();
	 $('.ajaxspinner').toggle();
 	$('html, body').animate({scrollTop: $("#repaircartarea").offset().top-90}, 100);
        $.ajax({ // create an AJAX call...
        data: $(this).serialize(), // get the form data
        type: $(this).attr('method'), // GET or POST
        url: $(this).attr('action'), // the file to call
        success: function(response) { // on success..
                $.get('ajaxhelpers.php?func=cartitemsandinvoices&pcwo=<?php echo "$pcwo"; ?>', function(data) {
                $('#repaircartitemsandinvoices').html(data);
		 $('.ajaxspinner').toggle();
                });
        	$('.catchrepaircartform').each (function(){
        	  this.reset();
        	});
    }
    });
});
});
</script>


