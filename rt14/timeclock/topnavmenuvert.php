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

echo "<table style=\"width:100%\"><tr><td style=\"vertical-align:top;width:50%\">";





echo "<a href=\"clock.php\" class=menulink><img src=../repair/images/reports.png  class=menuicon border=0> ".pcrtlang("Reports")."</a>";
if(perm_check("1")) {
echo "<a href=\"employee.php?func=addemployee\" class=menulink><img src=../repair/images/customers.png class=menuicon> ".pcrtlang("New Employee")."</a>";
}

echo "</td><td style=\"vertical-align:top;\">";

echo "</td></tr></table>";


?>


