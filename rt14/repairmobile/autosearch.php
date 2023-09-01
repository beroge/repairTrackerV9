<?php
                                                                                                    
/***************************************************************************
 *   copyright            : (C) 2010 PCRepairTracker.com
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


function search() {
require_once("validate.php");
require_once("dheader.php");
require("deps.php");

dheader(pcrtlang("Search"));

echo pcrtlang("Enter Search Term").":<form action=autosearch.php?func=pc method=POST data-ajax=\"false\">";
echo "<input type=text name=search type=search>";
echo "<input type=submit value=\"".pcrtlang("Search")."\"  data-theme=\"b\"></form><br><br>";


dfooter();

require_once("dfooter.php");


}



function pc() {
require_once("validate2.php");
require("deps.php");
require_once("header.php");

$pcid = pv($_REQUEST['search']);






echo pcrtlang("Enter Search Term").":<form action=autosearch.php?func=pc method=POST data-ajax=\"false\">";
echo "<input type=text name=search value=\"$pcid\">";
echo "<input type=submit value=\"".pcrtlang("Search Again")."\"  data-theme=\"b\"></form><br><br>";


echo "<div data-role=\"tabs\" id=\"tabs\">";
echo "<div data-role=\"navbar\">";
echo "<ul>";
echo "<li><a href=\"#workorders\" data-ajax=\"false\">".pcrtlang("Work Orders")."</a></li>";
echo "<li><a href=\"#assets\" data-ajax=\"false\">".pcrtlang("Assets/Devices")."</a></li>";
echo "<li><a href=\"#groups\" data-ajax=\"false\">".pcrtlang("Groups")."</a></li>";
echo "</ul>";
echo "</div>";




#wo ind

echo "<div id=\"workorders\" class=\"ui-body-d ui-content\">";

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

echo "$pcname";
if($pccompany != "") {
echo "<br>".pcrtlang("Company").": $pccompany";
}
echo "<br>".pcrtlang("Asset Make").": $pcmake";
echo "<br>".pcrtlang("Work Order ID").": #$pcid";
echo "<button type=button onClick=\"parent.location='pc.php?func=returnpc2&pcid=$pcid2'\" data-mini=\"true\"><i class=\"fa fa-reply\"></i> ".pcrtlang("return check-in")."</button>";
echo "<button type=button onClick=\"parent.location='pc.php?func=showpc&pcid=$pcid2'\" data-mini=\"true\"><i class=\"fa fa-eye\"></i> ".pcrtlang("view")."</button>";

}
}




echo "<h3>".pcrtlang("Work Order Search Results")."</h3>";

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
echo "<br>".pcrtlang("No Work Orders Found")."...<br><br>";
} else {

echo "<form action=pc.php?func=searchwo method=post data-ajax=\"false\"><input type=text name=searchterm value=\"$pcid\" required=required>";
echo "<button type=submit><i class=\"fa fa-search fa-lg\"></i> ".pcrtlang("Detailed WO Search")."</button>";
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

echo "<table class=standard><tr><th>$pcname</th></tr>";
if ("$pccompany" != "") {
echo "<tr><td>".pcrtlang("Company").": $pccompany</td></tr>";
}
echo "<tr><td>".pcrtlang("Work Order").": $val</td></tr>";
echo "<tr><td>".pcrtlang("Asset Make").": $pcmake</td></tr>";

echo "<tr><td>";
echo "<button type=button onClick=\"parent.location='index.php?pcwo=$woidq'\" data-mini=\"true\"><i class=\"fa fa-edit\"></i> ".pcrtlang("edit wo")."</button>";
echo "<button type=button onClick=\"parent.location='pc.php?func=showpc&pcid=$pcidq'\" data-mini=\"true\"><i class=\"fa fa-history\"></i> work order history</button>";
echo "<button type=button onClick=\"parent.location='pc.php?func=returnpc2&pcid=$pcidq'\" data-mini=\"true\"><i class=\"fa fa-reply\"></i> ".pcrtlang("return check-in")."</button>";
echo "</td></tr></table><br>";

}
}

echo "</div>";

#pc owner ind

echo "<div id=\"assets\" class=\"ui-body-d ui-content\">";


$rs_find_pc_solo = "SELECT * FROM pc_owner WHERE pcid = '$pcid'";
$rs_result_item_solo = mysqli_query($rs_connect, $rs_find_pc_solo);


if (mysqli_num_rows($rs_result_item_solo) != "0") {

$rs_result_item_solo_q = mysqli_fetch_object($rs_result_item_solo);
$pcname = "$rs_result_item_solo_q->pcname";
$pccompany = "$rs_result_item_solo_q->pccompany";
$pcid2 = "$rs_result_item_solo_q->pcid";
$pcmake = "$rs_result_item_solo_q->pcmake";

echo "$pcname";
if($pccompany != "") {
echo "<br>".pcrtlang("Company").": $pccompany";
}
echo "<br>".pcrtlang("Device Make").": $pcmake";
echo "<br>".pcrtlang("Asset/Device ID").": $pcid2";
echo "<button type=button onClick=\"parent.location='pc.php?func=returnpc2&pcid=$pcid2'\"><i class=\"fa fa-edit\"></i> ".pcrtlang("return check-in")."</button>";
echo "<button type=button onClick=\"parent.location='pc.php?func=showpc&pcid=$pcid2'\"><i class=\"fa fa-eye\"></i> ".pcrtlang("view")."</button><br><br>";

}


echo "<h3>".pcrtlang("Asset/Device Search Results")."</h3>";

$rs_find_pc = "SELECT * FROM pc_owner WHERE pcname LIKE '%$pcid%' OR pccompany LIKE '%$pcid%'  OR pcmake LIKE '%$pcid%' OR pcphone LIKE '%$pcid%' OR pcworkphone LIKE '%$pcid%' OR pccellphone LIKE '%$pcid%' OR pcemail LIKE '%$pcid%' OR pcaddress LIKE '%$pcid%' OR pcaddress2 LIKE '%$pcid%' OR pcextra LIKE '%$pcid%' OR pcmake LIKE '%$pcid%' OR pcnotes LIKE '%$pcid%' ORDER BY pcid DESC LIMIT 20";
$rs_result_item = mysqli_query($rs_connect, $rs_find_pc);


if (mysqli_num_rows($rs_result_item) == "0") {
echo "<br>".pcrtlang("No Items Found")."...<br><br>";
}


while($rs_result_item_q = mysqli_fetch_object($rs_result_item)) {
$pcname = "$rs_result_item_q->pcname";
$pccompany = "$rs_result_item_q->pccompany";
$pcid2 = "$rs_result_item_q->pcid";
$pcmake = "$rs_result_item_q->pcmake";

echo "<table class=standard><tr><th>$pcname</th></tr>";
if("$pccompany" != "") {
echo "<tr><td>".pcrtlang("Company").": $pccompany</td></tr>";
}
echo "<tr><td>".pcrtlang("Device Make").": $pcmake</td></tr>";
echo "<tr><td>".pcrtlang("Device/Asset ID").": $pcid2</td></tr>";
echo "<tr><td>";
echo "<button type=button onClick=\"parent.location='pc.php?func=showpc&pcid=$pcid2'\" data-mini=\"true\"><i class=\"fa fa-history\"></i> ".pcrtlang("work order history")."</button>";
echo "<button type=button onClick=\"parent.location='pc.php?func=returnpc2&pcid=$pcid2'\" data-mini=\"true\"><i class=\"fa fa-reply\"></i> ".pcrtlang("return check-in")."</button>";
echo "</td></tr></table><br>";
}

echo "</div>";

#start group ind

echo "<div id=\"groups\" class=\"ui-body-d ui-content\">";



$rs_find_group_solo = "SELECT * FROM pc_group WHERE pcgroupid = '$pcid'";
$rs_result_group_solo = mysqli_query($rs_connect, $rs_find_group_solo);


if (mysqli_num_rows($rs_result_group_solo) != "0") {

$rs_result_item_group_q = mysqli_fetch_object($rs_result_group_solo);
$pcgroupname = "$rs_result_item_group_q->pcgroupname";
$grpcompany = "$rs_result_item_group_q->grpcompany";
$pcgroupid2 = "$rs_result_item_group_q->pcgroupid";

echo "$pcgroupname<br>$grpcompany";
echo "<br>".pcrtlang("Group ID").": $pcgroupid2";
echo "<button type=button onClick=\"parent.location='group.php?func=viewgroup&pcgroupid=$pcgroupid2'\" data-mini=\"true\"><i class=\"fa fa-eye\"></i> ".pcrtlang("view")."</button><br><br>";

}






echo "<h3>".pcrtlang("Group Search Results")."</h3>";

$rs_findpc = "SELECT * FROM pc_group WHERE pcgroupname LIKE '%$pcid%' OR grpcompany LIKE '%$pcid%' OR grpphone LIKE '%$pcid%' OR grpcellphone LIKE '%$pcid%' OR grpworkphone LIKE '%$pcid%' OR grpemail LIKE '%$pcid%' OR grpaddress1 LIKE '%$pcid%' OR grpaddress2 LIKE '%$pcid%' OR grpnotes LIKE '%$pcid%' ORDER BY pcgroupid DESC LIMIT 20";
$rs_result = mysqli_query($rs_connect, $rs_findpc);

if (mysqli_num_rows($rs_result) == "0") {
echo "<br>".pcrtlang("No Groups Found")."...<br><br>";
}

while ($rs_result_q = mysqli_fetch_object($rs_result)) {
$pcgroupname = "$rs_result_q->pcgroupname";
$pcgroupid = "$rs_result_q->pcgroupid";
$grpcompany = "$rs_result_q->grpcompany";

echo "<table class=standard><tr><th>$pcgroupname</th></tr><tr><td>";
echo "<button type=button onClick=\"parent.location='group.php?func=viewgroup&pcgroupid=$pcgroupid'\" data-mini=\"true\"><i class=\"fa fa-group\"></i> ".pcrtlang("View Group")." #$pcgroupid</button></td></tr>";

if("$grpcompany" != "") {
echo "<tr><td>$grpcompany</td></tr>";
}

$rs_findowner = "SELECT * FROM pc_owner WHERE pcgroupid = '$pcgroupid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);

if (mysqli_num_rows($rs_result2) != "0") {
echo "<tr><th>".pcrtlang("Asset/Devices in this Group").":</th></tr>";
}


while($rs_result_q2 = mysqli_fetch_object($rs_result2)) {
$pcid3 = "$rs_result_q2->pcid";
$pcname3 = "$rs_result_q2->pcname";
$pccompany3 = "$rs_result_q2->pccompany";
$pcmake3 = "$rs_result_q2->pcmake";

echo "<tr><td><strong>$pcname3</strong>";

if("$pccompany3" != "") {
echo "<br>$pccompany3";
}
echo "<br>$pcmake3";
echo "<button type=button onClick=\"parent.location='pc.php?func=showpc&pcid=$pcid3'\" data-mini=\"true\"><i class=\"fa fa-eye\"></i> ".pcrtlang("view")." #$pcid3 $pcname3</button>";
echo "<button type=button onClick=\"parent.location='pc.php?func=returnpc2&pcid=$pcid3'\" data-mini=\"true\"><i class=\"fa fa-reply\"></i> ".pcrtlang("return check-in")."</button><br>";

echo "</td></tr>";

}

echo "</table><br>";

}

echo "</div>";

require_once("footer.php");



}


function inv() {
require_once("validate2.php");
require("deps.php");
require("common.php");


$thesearch2 = pv($_REQUEST['search']);

$thesearch = str_replace(" ", "%", "$thesearch2");





$rs_show_stock = "SELECT * FROM stock WHERE (stock_id LIKE '%$thesearch%' OR stock_title LIKE '%$thesearch%' OR stock_upc LIKE '%$thesearch%' OR stock_desc LIKE '%$thesearch%') AND dis_cont = 0";

$rs_stock_result = mysqli_query($rs_connect, $rs_show_stock);

if (mysqli_num_rows($rs_stock_result) != "0") {

echo "<table>";
while($rs_stock_result_q = mysqli_fetch_object($rs_stock_result)) {
$rs_stockid = "$rs_stock_result_q->stock_id";
$rs_stocktitle = "$rs_stock_result_q->stock_title";
$rs_stockdesc = "$rs_stock_result_q->stock_desc";
$rs_stockprice = "$rs_stock_result_q->stock_price";

checkstorecount($rs_stockid);

echo "<tr><td rowspan=2><a href=\"javascript:void(0)\" onClick='document.getElementById(\"autoinvsearchbox\").value=$rs_stockid'  class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\"><i class=\"fa fa-plus\"></i></a> </td><td> $rs_stocktitle</td></tr><tr><td style=\"text-align:right;\">$money".mf("$rs_stockprice")."</td></tr>";

}

echo "</table>";

?>
<script>
$('#autoinvsearchbox').enhanceWithin('create');
</script>
<?php

} else {

echo pcrtlang("No Search Results Found")."...";

} 

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

    case "search":
    search();
    break;


}

?>
