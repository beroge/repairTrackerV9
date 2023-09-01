<?php

/***************************************************************************
 *   copyright            : (C) 2021 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/


require_once("validate2.php");

require_once("common.php");

?>
<table width=100%><tr><td>

<a href="stock.php" class=linkbutton><img src=images/addstock.png align=absmiddle border=0> <?php echo pcrtlang("Add New Stock"); ?></a>



<a href="categories.php?func=add_main_cat" class=linkbutton><img src=images/folder.png align=absmiddle border=0 height=32> <?php echo pcrtlang("Add a New Main Category"); ?></a> 
<a href="categories.php?func=add_sub_cat" class=linkbutton><img src=images/subfolder.png align=absmiddle border=0 height=32> <?php echo pcrtlang("Add a New Sub Category"); ?></a>
<a href="categories.php" class=linkbutton><img src=images/inventory.png align=absmiddle border=0 height=32> <?php echo pcrtlang("Show Categories"); ?></a><br>
<a href="stock.php?func=noninventory" class=linkbutton><img src=images/inventory.png align=absmiddle border=0> <?php echo pcrtlang("Manage Non-Inventoried Items"); ?></a>
<a href="categories.php?func=inventorytools" class=linkbutton><img src=images/tools.png align=absmiddle border=0 height=32> <?php echo pcrtlang("Inventory Tools"); ?></a>
<a href="../repair/pc.php?func=massreadytosell" class=linkbutton><img src=../repair/images/new.png align=absmiddle border=0 height=32> <?php echo pcrtlang("Mass Add Ready to Sell"); ?></a>
<a href="shoplist.php" class=linkbutton><img src=images/tools.png align=absmiddle border=0 height=32> <?php echo pcrtlang("Order Planning"); ?></a><br>
</td></tr></table>


