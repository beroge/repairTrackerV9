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

                                                                                                    
function nothing() {
require_once("header.php");


require_once("footer.php");
                                                                                                    
}

function pc() {
require_once("validate2.php");
require("deps.php");
require("common.php");


$pcid = pv($_REQUEST['search']);






echo "<button id=button class=ibutton style=\"float:right;\"><i class=\"fa fa-times fa-lg\"></i></button>";

?>

<script>
$("#button").click(function() { 
    $("#autosearch").slideUp(200);
});
</script>
<?php

echo "<table width=100%><tr><td width=32% valign=top>";

$rs_find_pc_solowo = "SELECT pcid FROM pc_wo WHERE woid = '$pcid' LIMIT 1";
$rs_result_item_solowo = mysqli_query($rs_connect, $rs_find_pc_solowo);

if (mysqli_num_rows($rs_result_item_solowo) != "0") {
$rs_result_item_solowo_q = mysqli_fetch_object($rs_result_item_solowo);
$pcid3 = "$rs_result_item_solowo_q->pcid";
$rs_find_pc_solo = "SELECT * FROM pc_owner WHERE pcid = '$pcid3'";
$rs_result_item_solo = mysqli_query($rs_connect, $rs_find_pc_solo);



if (mysqli_num_rows($rs_result_item_solo) != "0") {

$rs_result_item_solo_q = mysqli_fetch_object($rs_result_item_solo);
$pcname = "$rs_result_item_solo_q->pcname";
$pccompany = "$rs_result_item_solo_q->pccompany";
$pcid2 = "$rs_result_item_solo_q->pcid";
$pcmake = "$rs_result_item_solo_q->pcmake";

echo "<table class=standard><tr><th style=\"width:50px;\"><img src=images/woedit.png align=absmiddle></th><th>";
echo "<span class=sizeme20>$pcname</span><br>&nbsp;";
if($pccompany != "") {
echo "$pccompany";
}
echo "</th></tr><tr><td colspan=2><span class=\"boldme\">$pcmake</span></td></tr>";
echo "<tr><td colspan=2><i class=\"fa fa-clipboard fa-lg\"></i> $pcid &nbsp;&nbsp;&nbsp;<i class=\"fa fa-tag fa-lg\"></i> $pcid3</td></tr>";
echo "<tr><td colspan=2><a href=\"pc.php?func=returnpc2&pcid=$pcid2\" class=\"linkbuttonmedium linkbuttongray radiusleft\"><i class=\"fa fa-reply fa-lg\"></i> ".pcrtlang("Return Check-in")."</a>";
echo "<a href=\"pc.php?func=showpc&pcid=$pcid2\" class=\"linkbuttonmedium linkbuttongray radiusright\"><i class=\"fa fa-eye fa-lg\"></i> ".pcrtlang("view")."</a></td></tr></table>";

}
}

echo "</td><td width=2%></td><td width=32%>";


$rs_find_pc_solo = "SELECT * FROM pc_owner WHERE pcid = '$pcid'";
$rs_result_item_solo = mysqli_query($rs_connect, $rs_find_pc_solo);


if (mysqli_num_rows($rs_result_item_solo) != "0") {

$rs_result_item_solo_q = mysqli_fetch_object($rs_result_item_solo);
$pcname = "$rs_result_item_solo_q->pcname";
$pccompany = "$rs_result_item_solo_q->pccompany";
$pcid2 = "$rs_result_item_solo_q->pcid";
$pcmake = "$rs_result_item_solo_q->pcmake";

echo "<table class=standard><tr><th style=\"width:50px;\"><img src=images/customers.png align=absmiddle></th><th>";
echo "<span class=sizeme20>$pcname</span><br>&nbsp;";
if($pccompany != "") {
echo "$pccompany";
}
echo "</th></tr><tr><td colspan=2><span class=\"boldme\">$pcmake</span></td></tr>";
echo "<tr><td colspan=2><i class=\"fa fa-tag fa-lg\"></i> $pcid2</td></tr>";
echo "<tr><td colspan=2><a href=\"pc.php?func=returnpc2&pcid=$pcid2\" class=\"linkbuttonmedium linkbuttongray radiusleft\"><i class=\"fa fa-reply fa-lg\"></i> ".pcrtlang("Return Check-in")."</a>";
echo "<a href=\"pc.php?func=showpc&pcid=$pcid2\" class=\"linkbuttonmedium linkbuttongray radiusright\"><i class=\"fa fa-eye fa-lg\"></i> ".pcrtlang("view")."</a></td></tr></table>";

}


echo "</td><td width=2%><td><td width=32% valign=top>";


$rs_find_group_solo = "SELECT * FROM pc_group WHERE pcgroupid = '$pcid'";
$rs_result_group_solo = mysqli_query($rs_connect, $rs_find_group_solo);


if (mysqli_num_rows($rs_result_group_solo) != "0") {

$rs_result_item_group_q = mysqli_fetch_object($rs_result_group_solo);
$pcgroupname = "$rs_result_item_group_q->pcgroupname";
$grpcompany = "$rs_result_item_group_q->grpcompany";
$pcgroupid2 = "$rs_result_item_group_q->pcgroupid";

echo "<table class=standard><tr><th style=\"width:50px;\"><img src=images/groups.png align=absmiddle></th>";
echo "<th><span class=sizeme20>$pcgroupname</span><br>$grpcompany&nbsp;</th></tr>";
echo "<tr><td colspan=2><i class=\"fa fa-group fa-lg\"></i> $pcgroupid2</td></tr><tr><td colspan=2>&nbsp;</td></tr><tr><td colspan=2><a href=\"group.php?func=viewgroup&pcgroupid=$pcgroupid2\" class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-eye fa-lg\"></i> ".pcrtlang("view")."</a></td></tr></table>";

}




echo "</td></tr></table>";

echo "<table width=99%><tr><td width=32% valign=top>";

start_blue_box(pcrtlang("Work Order Search Results"));

$woids = array();
$rs_find_pc3 = "SELECT woid FROM pc_wo WHERE probdesc LIKE '%$pcid%' OR thepass LIKE '%$pcid%' LIMIT 12";
$rs_result_item3 = mysqli_query($rs_connect, $rs_find_pc3);

while($rs_result_item_q3 = mysqli_fetch_object($rs_result_item3)) {
$woidq = "$rs_result_item_q3->woid";
$woids[] = $woidq;
} 

$rs_find_pc2 = "SELECT woid FROM wonotes WHERE thenote LIKE '%$pcid%' LIMIT 12";
$rs_result_item2 = mysqli_query($rs_connect, $rs_find_pc2);

while($rs_result_item_q2 = mysqli_fetch_object($rs_result_item2)) {
$woidq2 = "$rs_result_item_q2->woid";
if(!in_array("$woidq2", $woids)) {
$woids[] = $woidq2;
}
}
rsort($woids);

if (empty($woids)) {
echo "<br><span class=\"colormegray italme\">".pcrtlang("No Work Orders Found")."...<br><br></span>";
} else {

echo "<form action=pc.php?func=searchwo method=post><input type=text class=textbox name=searchterm size=10 value=\"$pcid\" required=required>";
echo "<button class=button><i class=\"fa fa-search\"></i> ".pcrtlang("Detailed WO Search")."</button>";
echo "</form><br>";
}



foreach($woids as $key => $val) {

$rs_find_pc = "SELECT woid,pcid,probdesc FROM pc_wo WHERE woid = '$val'";
$rs_result_item = mysqli_query($rs_connect, $rs_find_pc);

while($rs_result_item_q = mysqli_fetch_object($rs_result_item)) {
$woidq = "$rs_result_item_q->woid";
$pcidq = "$rs_result_item_q->pcid";
$probdesc = "$rs_result_item_q->probdesc";
$rs_find_pcowner = "SELECT pcname,pcmake,pccompany,pcid FROM pc_owner WHERE pcid = $pcidq";
$rs_result_item_owner = mysqli_query($rs_connect, $rs_find_pcowner);
$rs_result_item_qo = mysqli_fetch_object($rs_result_item_owner);
$pcmake = "$rs_result_item_qo->pcmake";
$pcname = "$rs_result_item_qo->pcname";
$pccompany = "$rs_result_item_qo->pccompany";

echo "<table class=badgeclickonwhite>";
echo "<tr><td style=\"vertical-align:top;\">";
echo "<strong><i class=\"fa fa-clipboard fa-lg\"></i> $val</strong>&nbsp;&nbsp;</td><td><span class=\"boldme\">$pcname</span>";
if ("$pccompany" != "") {
echo "<br>$pccompany";
}
echo "<br><span class=\"sizemesmaller\">$pcmake</span><br>";
echo "<a href=index.php?pcwo=$woidq class=\"linkbuttongray linkbuttontiny\"><i class=\"fa fa-edit\"></i> ".pcrtlang("edit wo")."</a><a href=pc.php?func=showpc&pcid=$pcidq class=\"linkbuttongray linkbuttontiny\"><i class=\"fa fa-history\"></i> work order history</a>";
echo "<a href=\"pc.php?func=returnpc2&pcid=$pcidq\" class=\"linkbuttongray linkbuttontiny\"><i class=\"fa fa-reply\"></i> ".pcrtlang("check in")."</a>";
echo "</td></tr>";
echo "</table>";
}

}


stop_blue_box();

echo "</td><td width=2%></td><td width=32% valign=top>";

start_blue_box(pcrtlang("Asset/Device Search Results"));

$rs_find_pc = "SELECT * FROM pc_owner WHERE pcname LIKE '%$pcid%' OR pccompany LIKE '%$pcid%'  OR pcmake LIKE '%$pcid%' OR pcphone LIKE '%$pcid%' OR pcworkphone LIKE '%$pcid%' OR pccellphone LIKE '%$pcid%' OR pcemail LIKE '%$pcid%' OR pcaddress LIKE '%$pcid%' OR pcaddress2 LIKE '%$pcid%' OR pcextra LIKE '%$pcid%' OR pcmake LIKE '%$pcid%' OR pcnotes LIKE '%$pcid%' ORDER BY pcid DESC LIMIT 20";
$rs_result_item = mysqli_query($rs_connect, $rs_find_pc);


if (mysqli_num_rows($rs_result_item) == "0") {
echo "<br><span class=\"colormegray italme\">".pcrtlang("No Items Found")."...<br><br></span>";
}


while($rs_result_item_q = mysqli_fetch_object($rs_result_item)) {
$pcname = "$rs_result_item_q->pcname";
$pccompany = "$rs_result_item_q->pccompany";
$pcid2 = "$rs_result_item_q->pcid";
$pcmake = "$rs_result_item_q->pcmake";


echo "<table class=badgeclickonwhite>";
echo "<tr><td style=\"vertical-align:top;\"><strong><i class=\"fa fa-tag fa-lg\"></i> $pcid2<br>";

displaytags($pcid2,0,24);

echo "</td><td><span class=\"boldme\"> $pcname</span>";
if("$pccompany" != "") {
echo "<br>$pccompany";
}
echo "<br><span class=\"sizemesmaller boldme\">$pcmake</span><br>";
echo "<a href=pc.php?func=showpc&pcid=$pcid2 class=\"linkbuttongray linkbuttontiny\"><i class=\"fa fa-history\"></i> ".pcrtlang("work order history")."</a>";
echo "<a href=\"pc.php?func=returnpc2&pcid=$pcid2\" class=\"linkbuttongray linkbuttontiny\"><i class=\"fa fa-reply\"></i> ".pcrtlang("check in")."</a>";
echo "<br></td></tr>";
echo "</table>";
}

stop_blue_box();


echo "</td><td width=2%></td><td width=32% valign=top>";


start_blue_box(pcrtlang("Group Search Results"));

$rs_findpc = "SELECT * FROM pc_group WHERE pcgroupname LIKE '%$pcid%' OR grpcompany LIKE '%$pcid%' OR grpphone LIKE '%$pcid%' OR grpcellphone LIKE '%$pcid%' OR grpworkphone LIKE '%$pcid%' OR grpemail LIKE '%$pcid%' OR grpaddress1 LIKE '%$pcid%' OR grpaddress2 LIKE '%$pcid%' OR grpnotes LIKE '%$pcid%' ORDER BY pcgroupid DESC LIMIT 20";
$rs_result = mysqli_query($rs_connect, $rs_findpc);

if (mysqli_num_rows($rs_result) == "0") {
echo "<br><span class=\"colormegray italme\">".pcrtlang("No Groups Found")."...<br><br></span>";
}

while ($rs_result_q = mysqli_fetch_object($rs_result)) {
$pcgroupname = "$rs_result_q->pcgroupname";
$pcgroupid = "$rs_result_q->pcgroupid";
$grpcompany = "$rs_result_q->grpcompany";

echo "<table class=badgeclickonwhite><tr><td>";

echo "<a href=group.php?func=viewgroup&pcgroupid=$pcgroupid class=\"linkbuttonsmall linkbuttonblack radiusall\"><i class=\"fa fa-group\"></i> $pcgroupid</a> <span class=\"boldme\">$pcgroupname</span>";

if("$grpcompany" != "") {
echo "<br>$grpcompany";
}

$rs_findowner = "SELECT * FROM pc_owner WHERE pcgroupid = '$pcgroupid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);

if (mysqli_num_rows($rs_result2) != "0") {
echo "<br><br><span class=\"boldme\">".pcrtlang("Assets/Devices in this Group").":</span><br>";
}


while($rs_result_q2 = mysqli_fetch_object($rs_result2)) {
$pcid3 = "$rs_result_q2->pcid";
$pcname3 = "$rs_result_q2->pcname";
$pccompany3 = "$rs_result_q2->pccompany";
$pcmake3 = "$rs_result_q2->pcmake";

echo "<a href=pc.php?func=showpc&pcid=$pcid3 class=\"linkbuttonsmall linkbuttongray\"><i class=\"fa fa-tag\"></i> $pcid3</a> | $pcname3 ";
if("$pccompany3" != "") {
echo "| $pccompany3 ";
}
echo "| $pcmake3 | ";
echo "<a href=\"pc.php?func=returnpc2&pcid=$pcid3\"><img src=\"images/return.png\" width=16 align=absmiddle></a><br>";
}

echo "</td></tr></table>";

}

stop_blue_box();

echo "</td></tr></table>";

}


function inv() {
require_once("validate2.php");
require("deps.php");
require("common.php");


$pcwo = pv($_REQUEST['pcwo']);
$thesearch2 = pv($_REQUEST['search']);
$thesearch = str_replace(" ", "%", "$thesearch2");

$rs_show_stock = "SELECT * FROM stock WHERE (stock_id LIKE '%$thesearch%' OR stock_title LIKE '%$thesearch%' OR stock_upc LIKE '%$thesearch%' OR stock_desc LIKE '%$thesearch%') 
AND dis_cont = 0";

$rs_stock_result = mysqli_query($rs_connect, $rs_show_stock);

if (mysqli_num_rows($rs_stock_result) != "0") {

echo "<table>";
while($rs_stock_result_q = mysqli_fetch_object($rs_stock_result)) {
$rs_stockid = "$rs_stock_result_q->stock_id";
$rs_stocktitle = "$rs_stock_result_q->stock_title";
$rs_stockdesc = "$rs_stock_result_q->stock_desc";
$rs_stockprice = "$rs_stock_result_q->stock_price";

checkstorecount($rs_stockid);

echo "<tr><td>";
$rs_find_serial = "SELECT * FROM inventory WHERE stock_id = '$rs_stockid' AND itemserial != ''";
$rs_find_serial_q = @mysqli_query($rs_connect, $rs_find_serial);
if(mysqli_num_rows($rs_find_serial_q) > 0) {
echo "<a href=\"repcart.php?func=addbyserial&stockid=$rs_stockid&pcwo=$pcwo\" class=\"linkbuttontiny linkbuttonblack radiusall\"><i class=\"fa fa-cart-plus\"></i> $rs_stockid</a></td><td> $rs_stocktitle (".pcrtlang("Must Enter Serial").")</td><td style=\"text-align:right;\"><span class=\"boldme\">$money".mf("$rs_stockprice")."</span>";
} else {
echo "<a href=\"javascript:void(0)\" onClick='document.getElementById(\"autoinvsearchbox\").value=$rs_stockid' class=\"linkbuttontiny linkbuttonmoney radiusall\">
<i class=\"fa fa-cart-plus\"></i> $rs_stockid</a> </td><td> $rs_stocktitle</td><td style=\"text-align:right;\"><span class=\"boldme\">$money".mf("$rs_stockprice")."</span>";
}

echo "</td></tr>";

}

echo "</table>";

} else {

echo "<span class=\"colormegray italme\">".pcrtlang("No Search Results Found")."...</span>";

} 

}


function sms() {
require_once("validate2.php");
require("deps.php");
require("common.php");

$thesearch = pv($_REQUEST['search']);

echo "<br><br>";

$rs_findpc = "SELECT * FROM pc_owner WHERE pcname LIKE '%$thesearch%' AND pccellphone != '' ORDER BY pcname ASC LIMIT 10";
$rs_resultpc2 = mysqli_query($rs_connect, $rs_findpc);
if(mysqli_num_rows($rs_resultpc2) != 0) {
while($rs_resultpc_q2 = mysqli_fetch_object($rs_resultpc2)) {
$pcname = "$rs_resultpc_q2->pcname";
$pccellphone = "$rs_resultpc_q2->pccellphone";
echo "<a href=\"javascript:void(0)\" onClick='document.getElementById(\"autosmssearchbox\").value=[\"$pccellphone\"]' class=\"linkbuttontiny linkbuttongray displayblock\">
<i class=\"fa fa-plus\"></i> $pcname<br>$pccellphone</a>";
}
} else {
echo "<span class=\"sizeme10 italme\">".pcrtlang("No Asset Search Results Found")."...</span><br>";
}


$rs_findg = "SELECT * FROM pc_group WHERE pcgroupname LIKE '%$thesearch%' AND grpcellphone != '' ORDER BY pcgroupname ASC LIMIT 10";
$rs_resultg2 = mysqli_query($rs_connect, $rs_findg);
if(mysqli_num_rows($rs_resultg2) != 0) {
while($rs_resultg_q2 = mysqli_fetch_object($rs_resultg2)) {
$groupname = "$rs_resultg_q2->pcgroupname";
$grpcellphone = "$rs_resultg_q2->grpcellphone";
echo "<a href=\"javascript:void(0)\" onClick='document.getElementById(\"autosmssearchbox\").value=[\"$grpcellphone\"]' class=\"linkbuttontiny linkbuttongray displayblock\">
<i class=\"fa fa-plus\"></i> $groupname<br>$grpcellphone</a>";
}
} else {
echo "<span class=\"sizeme10 italme\">".pcrtlang("No Group Search Results Found")."...</span><br>";
}

echo "<br><br>";

}


                                                                                                    
switch($func) {

    default:
    nothing();
    break;
                                
    case "pc":
    pc();
    break;

    case "inv":
    inv();
    break;

    case "sms":
    sms();
    break;


}

?>
