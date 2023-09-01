<?php

/***************************************************************************
 *   copyright            : (C) 2012 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/


require_once("validate2.php");

require_once("common.php");

?>

<button type=button onClick="parent.location='stock.php'"><img src=../store/images/addstock.png align=absmiddle> <?php echo pcrtlang("Add New Stock"); ?></button>



<button type=button onClick="parent.location='categories.php?func=add_main_cat'"><img src=../store/images/folder.png align=absmiddle> <?php echo pcrtlang("Add a New Main Category"); ?></button>
<button type=button onClick="parent.location='categories.php?func=add_sub_cat'"><img src=../store/images/subfolder.png align=absmiddle> <?php echo pcrtlang("Add a New Sub Category"); ?></button>
<button type=button onClick="parent.location='categories.php?func=inventorytools'"><img src=../store/images/tools.png align=absmiddle> <?php echo pcrtlang("Inventory Tools"); ?></button>


