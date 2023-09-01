
<?php

/***************************************************************************
 *   copyright            : (C) 2012 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/


require_once("validate2.php");
include_once("common.php");

echo "<table><tr><td style=\"vertical-align:top;\">";

?>

<a href="./" class=menulink><img src=images/home.png class=menuicon> <?php echo pcrtlang("Home"); ?></a>
<a href="cart.php" class=menulink><img src=images/cart.png class=menuicon> <?php echo pcrtlang("Current Cart"); ?></a>
<?php
if (perm_check("25")) {
echo "<a href=\"reports.php?func=browse_receipts\" class=menulink><img src=images/receipts.png class=menuicon> ".pcrtlang("Receipts")."</a>";
}
?>
<a href="invoice.php" class=menulink><img src=images/invoice.png class=menuicon> <?php echo pcrtlang("Invoices"); ?></a>

<a href="invoice.php?func=browsequotes" class=menulink><img src=images/invoice.png class=menuicon> <?php echo pcrtlang("Quotes"); ?></a>

<a href="deposits.php" class=menulink><img src=images/deposits.png class=menuicon> <?php echo pcrtlang("Deposits"); ?></a>



<?php
echo "</td><td style=\"vertical-align:top;\">";


if (perm_check("6")) {
echo "<a href=\"categories.php\" class=menulink><img src=images/inventory.png class=menuicon> ".pcrtlang("Inventory")."</a>";
}
if (perm_check("23")) {
echo "<a href=\"suppliers.php\" class=menulink><img src=images/suppliers.png class=menuicon> ".pcrtlang("Suppliers")."</a>";
}

echo "<a href=\"stock.php?func=specialorders\" class=menulink><img src=images/specialorder.png class=menuicon> ".pcrtlang("Special Orders")."</a>";

?>

<a href="reports.php" class=menulink><img src=images/reports.png class=menuicon> <?php echo pcrtlang("Reports"); ?></a>
<?php
echo "<a href=../repair/admin.php class=menulink><img src=../repair/images/admin.png class=menuicon> ".pcrtlang("Settings")."</a>";
echo "<a href=\"../repair/logout.php\" class=menulink><img src=../repair/images/logout.png class=menuicon> ".pcrtlang("Logout")."</a>";

echo "</td></tr></table>";

?>
