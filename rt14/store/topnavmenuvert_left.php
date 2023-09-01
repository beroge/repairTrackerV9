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

echo "<a href=\"../repair/\" class=menulink><img src=../repair/images/home.png class=menuicon> ".pcrtlang("Repair Home")."</a>";
echo "<a href=\"../repair/pc.php?func=returnpc\" class=menulink><img src=../repair/images/new.png class=menuicon> ".pcrtlang("Check-in")."</a>";
//echo "<a href=../repair/pc.php?func=returnpc class=menulink><img src=../repair/images/new.png class=menuicon> ".pcrtlang("New Check-in")."</a>";
echo "<a href=../repair/pc.php?func=checkoutpc class=menulink><img src=../repair/images/checkout.png class=menuicon> ".pcrtlang("Checkout")."</a>";
echo "<a href=../repair/customers.php class=menulink><img src=../repair/images/customers.png class=menuicon> ".pcrtlang("Assets/Devices")."</a>";
echo "<a href=../repair/group.php?func=browsegroups class=menulink><img src=../repair/images/groups.png class=menuicon> ".pcrtlang("Groups")."</a>";

echo "<a href=../repair/msp.php?func=contractlist class=menulink><img src=../repair/images/contract.png class=menuicon> ".pcrtlang("Service Contracts")."</a>";


echo "</td><td style=\"vertical-align:top;\">";
echo "<a href=\"../repair\" class=menulink><img src=../repair/images/sticky.png class=menuicon> ".pcrtlang("Sticky Wall")."</a>";
echo "<a href=\"../repair/index.php?showwhat=calendar\" class=menulink><img src=../repair/images/calendar.png class=menuicon> ".pcrtlang("Sticky Calendar")."</a>";

echo "<a href=../repair/servicereminder.php?func=browsesr class=menulink><img src=../repair/images/reminder.png class=menuicon> ".pcrtlang("Service Reminders")."</a>";
echo "<a href=../repair/rwo.php?func=browserwo class=menulink><img src=../repair/images/rwo.png class=menuicon> ".pcrtlang("Recurring Work Orders")."</a>";
echo "<a href=../repair/servicerequests.php?func=sreqlist class=menulink><img src=../repair/images/sr.png class=menuicon> ".pcrtlang("Closed Service Requests")."</a>";






echo "<a href=../repair/pc.php?func=frameit class=menulink><img src=../repair/images/tools.png class=menuicon> ".pcrtlang("Tools &amp Docs")."</a>";
echo "</td></tr></table>";

?>

