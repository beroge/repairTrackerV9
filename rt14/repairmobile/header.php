<?php
require("deps.php");
require_once("common.php");
require("validate.php");
?>
<!DOCTYPE html>
<html>
<head>

<?php
require("headincludes.php");
?>

</head>
<body>


<div data-role="page" id="pageone">

<div data-role="panel" id="repairPanel"> 

<?php
$thenotify = pcrtnotify();
if($thenotify != "") {
echo "<div data-role=\"collapsible\" data-theme=\"b\">";
echo "<h3>";
echo "<i class=\"fa fa-comment fa-lg\"></i> ";
echo pcrtlang("Notifications");
echo "</h3>";

echo $thenotify;

echo "</div>";
}
?>

<div data-role="collapsible">
<h3 style="text-align:center">
<?php
echo "<i class=\"fa fa-clipboard fa-lg\"></i> ";
echo pcrtlang("Work Orders");
?>
</h3>

<script type="text/javascript">
  $.get('sidemenu.php?time=<?php echo time(); ?>', function(data) {
    $('#sidemenu').html(data).enhanceWithin('create');
  });
</script>
<div id="sidemenu" class="sidemenu"></div>



</div>

<br><br>

<?php

echo "<button onClick=\"parent.location='../repairmobile/pc.php?func=addpc'\"><i class=\"fa fa-mail-reply fa-lg\"></i> ".pcrtlang("New Check-in")."</button>";
echo "<button onClick=\"parent.location='../repairmobile/pc.php?func=returnpc'\"><i class=\"fa fa-mail-reply-all fa-lg\"></i> ".pcrtlang("Return Check-in")."</button>";
echo "<button onClick=\"parent.location='../repairmobile/pc.php?func=checkoutpc'\"><i class=\"fa fa-mail-forward fa-lg\"></i> ".pcrtlang("Checkout")."</button>";
echo "<button onClick=\"parent.location='../repairmobile/autosearch.php?func=search'\"><i class=\"fa fa-search fa-lg\"></i>".pcrtlang("Search")."</button>";
echo "<button onClick=\"parent.location='./'\"><i class=\"fa fa-file-o fa-lg\"></i> ".pcrtlang("Sticky Wall")."</button>";
echo "<button onClick=\"parent.location='../repairmobile/index.php?showwhat=calendar'\"><i class=\"fa fa-calendar fa-lg\"></i> ".pcrtlang("Sticky Calendar")."</button>";
echo "<button onClick=\"parent.location='../repairmobile/messages.php?func=browsemessages'\"><i class=\"fa fa-comment fa-lg\"></i> ".pcrtlang("Messages")."</button>";
echo "<button onClick=\"parent.location='../repairmobile/customers.php'\"><i class=\"fa fa-desktop fa-lg\"></i> ".pcrtlang("Assets/Devices")."</button>";
echo "<button onClick=\"parent.location='../repairmobile/group.php?func=browsegroups'\"><i class=\"fa fa-group fa-lg\"></i> ".pcrtlang("Groups")."</button>";
echo "<button onClick=\"parent.location='../repairmobile/msp.php?func=contractlist'\"><i class=\"fa fa-file-text fa-lg\"></i> ".pcrtlang("Service Contracts")."</button>";
echo "<button onClick=\"parent.location='../repairmobile/blockcontract.php?func=contractlist'\"><i class=\"fa fa-group fa-lg\"></i> ".pcrtlang("Block of Time Contracts")."</button>";
echo "<button onClick=\"parent.location='../repairmobile/workorders.php'\"><i class=\"fa fa-tag fa-lg\"></i> ".pcrtlang("Recent Work Orders")."</button>";
echo "<button onClick=\"parent.location='../repairmobile/logout.php'\"><i class=\"fa fa-sign-out fa-lg\"></i> ".pcrtlang("Logout")."</button>";

?>
</div> 

<div data-role="panel" id="salePanel" data-position="right">


<button type=button onClick="parent.location='../storemobile/cart.php'"><i class="fa fa-shopping-cart fa-lg"></i> <?php echo pcrtlang("Current Cart"); ?></button>
<?php
if (perm_check("25")) {
echo "<button type=button onClick=\"parent.location='../storemobile/reports.php?func=browse_receipts'\"><i class=\"fa fa-file-text-o fa-lg\"></i> ".pcrtlang("Receipts")."</button>";
}
?>
<button type=button onClick="parent.location='../storemobile/invoice.php'"><i class="fa fa-clipboard fa-lg"></i> <?php echo pcrtlang("Invoices"); ?></button>
<button type=button onClick="parent.location='../storemobile/deposits.php'"><i class="fa fa-money fa-lg"></i> <?php echo pcrtlang("Deposits"); ?></button>

<button type=button onClick="parent.location='../storemobile/autosearch.php?func=search'"><i class="fa fa-search fa-lg"></i> <?php echo pcrtlang("Search"); ?></button>


<?php
if (perm_check("6")) {
echo "<button type=button onClick=\"parent.location='../storemobile/categories.php'\"><i class=\"fa fa-tags fa-lg\"></i> ".pcrtlang("Inventory")."</button>";
}
if (perm_check("23")) {
echo "<button type=button onClick=\"parent.location='../storemobile/suppliers.php'\"><i class=\"fa fa-building fa-lg\"></i> ".pcrtlang("Suppliers")."</button>";
}

echo "<button type=button onClick=\"parent.location='../storemobile/stock.php?func=specialorders'\"><i class=\"fa fa-truck fa-lg\"></i> ".pcrtlang("Special Orders")."</button>";

?>
<button type=button onClick="parent.location='../storemobile/reports.php'"><i class="fa fa-file-text-o fa-lg"></i> <?php echo pcrtlang("Reports"); ?></button>
<?php
echo "<button type=button onClick=\"parent.location='../repairmobile/logout.php'\"><i class=\"fa fa-sign-out fa-lg\"></i> ".pcrtlang("Logout")."</button>";
?>




</div>



<div data-role="header" data-theme="a" data-position="fixed">

<?php
if ($activestorecount > "1") {
$rs_find_stores = "SELECT * FROM stores WHERE storeenabled = '1' ORDER BY storesname ASC";
$rs_result_stores = mysqli_query($rs_connect, $rs_find_stores);

echo "<div style=\"text-align:center\">";
echo "<form method=post action=../repairmobile/admin.php?func=setuserdefaultstore>";
echo "<select name=setuserdefaultstore data-native-menu=\"false\" onchange='this.form.submit()'>";

while($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
$rs_storesname = "$rs_result_storeq->storesname";
$rs_storeid = "$rs_result_storeq->storeid";

if ($rs_storeid == $defaultuserstore) {
echo "<option selected value=$rs_storeid>$rs_storesname</option>";
} else {
echo "<option value=$rs_storeid>$rs_storesname</option>";
}
}
echo "</select></form>";
} else {
echo "<div style=\"text-align:center\">";
$storeinfoarray = getstoreinfo($defaultuserstore);
echo "$storeinfoarray[storesname]<br><br>";
}
echo "</div>";
?>


    <a href="#repairPanel"  data-theme="b"><i class="fa fa-wrench fa-lg"></i> REPAIR</a>
    <a href="#salePanel"  data-theme="b"><i class="fa fa-shopping-cart fa-lg"></i> SALE</a>
  </div>



  <div data-role="content">


