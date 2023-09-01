<?php

/***************************************************************************
 *   copyright            : (C) 2010 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/

require_once("deps.php");
require_once("validate2.php");
require_once("common.php");

echo "<table><tr><td style=\"vertical-align:top;\">";
#echo "<a href=\"../repair/\" class=\"linkbuttonlarge radiusall linkbuttonblack displayblock\"><i class=\"fa fa-home fa-lg\"></i> ".pcrtlang("Repairs")."</a>";
if(perm_check("42")) {
echo "<a href=\"ledgers.php\" class=menulink><i class=\"fa fa-book fa-2x menuicon fa-fw\"></i> ".pcrtlang("Manage Ledgers")."</a>";
}
#echo "<a href=../repair/pc.php?func=checkoutpc class=menulink><img src=../repair/images/checkout.png class=menuicon> ".pcrtlang("Checkout")."</a>";
#echo "<a href=../repair/customers.php class=menulink><img src=../repair/images/customers.png class=menuicon> ".pcrtlang("Assets/Devices")."</a>";
#echo "<a href=../repair/group.php?func=browsegroups class=menulink><img src=../repair/images/groups.png class=menuicon> ".pcrtlang("Groups")."</a>";
#echo "<a href=\"../repair/stickydisplay.php\" class=menulink><img src=../repair/images/sticky.png class=menuicon> ".pcrtlang("Sticky Wall")."</a>";
#echo "<a href=\"../repair/stickydisplay.php?showwhat=calendar\" class=menulink><img src=../repair/images/calendar.png class=menuicon> ".pcrtlang("Sticky Calendar")."</a>";

#echo "<a href=../repair/messages.php?func=browsemessages class=menulink><img src=../repair/images/sr.png class=menuicon> ".pcrtlang("Client Messages")."</a>";

#echo "<a href=../repair/msp.php?func=contractlist class=menulink><img src=../repair/images/contract.png class=menuicon> ".pcrtlang("Service Contracts")."</a>";
#echo "<a href=../repair/blockcontract.php?func=contractlist class=menulink><img src=../repair/images/clock.png class=menuicon> ".pcrtlang("Block of Time Contracts")."</a>";

#echo "<a href=../repair/servicereminder.php?func=browsesr class=menulink><img src=../repair/images/reminder.png class=menuicon> ".pcrtlang("Service Reminders")."</a>";
#echo "<a href=../repair/rwo.php?func=browserwo class=menulink><img src=../repair/images/rwo.png class=menuicon> ".pcrtlang("Recurring Work Orders")."</a>";
#echo "<a href=../repair/servicerequests.php?func=runsreq class=menulink><img src=../repair/images/sr.png class=menuicon> ".pcrtlang("Service Requests")."</a>";

echo "</td><td style=\"vertical-align:top;\">";


?>

<!--

#<a href="../store/" class="linkbuttonlarge radiusall linkbuttonblack displayblock"><i class="fa fa-home fa-lg"></i> <?php echo pcrtlang("Point of Sale"); ?></a>

#<a href="../store/cart.php" class=menulink><img src=../store/images/cart.png class=menuicon> <?php echo pcrtlang("Current Cart"); ?></a>

#<a href="../store/invoice.php" class=menulink><img src=../store/images/invoice.png class=menuicon> <?php echo pcrtlang("Invoices"); ?></a>
#<a href="../store/invoice.php?func=browsequotes" class=menulink><img src=../repair/images/invoice.png class=menuicon> <?php echo pcrtlang("Quotes"); ?></a>
#<a href="../store/deposits.php" class=menulink><img src=../store/images/deposits.png class=menuicon> <?php echo pcrtlang("Deposits"); ?></a>




<a href="../store/reports.php" class=menulink><img src=../store/images/reports.png class=menuicon> <?php echo pcrtlang("Reports"); ?></a>
-->

</td></tr></table>


