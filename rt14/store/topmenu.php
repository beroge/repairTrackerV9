<?php

/***************************************************************************
 *   copyright            : (C) 2018 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/


require_once("validate2.php");
include_once("common.php");

?>
<table width=100%><tr><td>

<a href="./" class=boldlink><img src=images/home.png align=absmiddle border=0> Home</a> | <a href="cart.php" class=boldlink><img src=images/cart.png align=absmiddle border=0> Current Cart</a>
 | <a href=cart.php?func=show_savecart class=boldlink><img src=images/scart.png align=absmiddle border=0> Saved Carts</a>
 | <a href=cart.php?func=show_savecarts class=boldlink><img src=images/dcart.png align=absmiddle border=0> Ready to Sell</a>
|  <a href="invoice.php" class=boldlink><img src=images/invoice.png align=absmiddle border=0> Invoices</a>
|  <a href="deposits.php" class=boldlink><img src=images/deposits.png align=absmiddle border=0> Deposits</a>

<?php
if (perm_check("6")) {
echo "| <a href=\"categories.php\" class=boldlink><img src=images/inventory.png align=absmiddle border=0> Inventory</a>";
}
?>

 |  <a href="reports.php" class=boldlink><img src=images/reports.png align=absmiddle border=0> Reports</a>
 |  <a href="logout.php" class=boldlink><img src=images/logout.png align=absmiddle border=0> Logout</a>
</td><td halign=right>

<form action=receipt.php?func=search_receipt method=post>
<input type=text class=textbox name=thesearch size=10 required=required>
<input type=submit class=button value="Search Receipts"></form>


</td></tr></table>

