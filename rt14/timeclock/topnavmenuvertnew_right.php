
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

if ($gomodal == 1) {
$therel = "rel=facebox";
} else {
$therel = "";
}


echo "<table style=\"width:100%\"><tr><td style=\"vertical-align:top;width:50%\">";



echo "</td><td style=\"vertical-align:top;\">";

echo "<a href=../repair/ class=menulink><i class=\"fa fa-wrench fa-lg menuicon\"></i> ".pcrtlang("Repair")."</a>";

echo "<a href=admin.php class=menulink><img src=../repair/images/admin.png class=menuicon> ".pcrtlang("Settings")."</a>";

echo "<a href=\"logout.php\" class=menulink><img src=../repair/images/logout.png class=menuicon> ".pcrtlang("Logout")."</a>";

echo "</td></tr></table>";
