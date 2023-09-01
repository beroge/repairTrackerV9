<?php
                                                                                                    
/***************************************************************************
 *   copyright            : (C) 2010 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/
$func = $_REQUEST[func];
                                                                                                    
function nothing() {
require_once("header.php");

echo "<a href=databaseupgrade-1.06to1.08.php?func=do_upgrade>Click Here</a> to upgrade the database from 1.06 to the 1.08 version of PC Repair Tracker.";

require_once("footer.php");
                                                                                                    
}


function do_upgrade() {
require_once("validate.php");
require("deps.php");
require("common.php");

$rs_connect = @mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect the db");
$rs_select_db = @mysql_select_db($dbname, $rs_connect) or die("Couldn't select the db");


#@mysql_query($sql2, $rs_connect);

$sql1 = "ALTER TABLE `pc_wo` ADD `workarea` TEXT NOT NULL";
$sql2 = "ALTER TABLE `sold_items` ADD `itemtax` DECIMAL( 11, 2 ) NOT NULL";
$sql3 = "ALTER TABLE `cart` ADD `taxex` INT NOT NULL DEFAULT '0', ADD `itemtax` DECIMAL( 11, 2 ) NOT NULL";
$sql4 = "ALTER TABLE `savedcarts` ADD `taxex` INT NOT NULL DEFAULT '0', ADD `itemtax` DECIMAL( 11, 2 ) NOT NULL DEFAULT '0'";
$sql5 = "ALTER TABLE `repaircart` ADD `taxex` INT NOT NULL DEFAULT '0', ADD `itemtax` DECIMAL( 11, 2 ) NOT NULL DEFAULT '0'";
$sql6 = "ALTER TABLE `stock` ADD `stock_upc` INT NOT NULL DEFAULT '0'";

$sql7 = "CREATE TABLE `invoice_items` (
  `cart_item_id` int(11) NOT NULL auto_increment,
  `cart_price` float(11,2) NOT NULL default '0.00',
  `cart_type` text NOT NULL,
  `cart_stock_id` int(11) NOT NULL default '0',
  `labor_desc` text NOT NULL,
  `return_sold_id` int(11) NOT NULL default '0',
  `restocking_fee` text NOT NULL,
  `price_alt` int(11) NOT NULL default '0',
  `addtime` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `invoice_id` int(11) NOT NULL,
  `taxex` int(11) NOT NULL default '0',
  `itemtax` decimal(11,2) NOT NULL default '0.00',
  UNIQUE KEY `cart_item_id` (`cart_item_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";

$sql8 = "CREATE TABLE `invoices` (
  `invoice_id` int(11) NOT NULL auto_increment,
  `invstatus` int(11) NOT NULL default '1',
  `invname` text NOT NULL,
  `invaddy1` text NOT NULL,
  `invaddy2` text NOT NULL,
  `invemail` text NOT NULL,
  `invphone` text NOT NULL,
  `invdate` datetime NOT NULL,
  `woid` int(11) NOT NULL default '0',
  `receipt_id` int(11) NOT NULL default '0',
  KEY `invoice_id` (`invoice_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";

@mysql_query($sql1, $rs_connect);
@mysql_query($sql2, $rs_connect);
@mysql_query($sql3, $rs_connect);
@mysql_query($sql4, $rs_connect);
@mysql_query($sql5, $rs_connect);
@mysql_query($sql6, $rs_connect);
@mysql_query($sql7, $rs_connect);
@mysql_query($sql8, $rs_connect);


$rs_insert_stock = "SELECT * FROM sold_items";
$rs_find_stock_price = @mysql_query($rs_insert_stock, $rs_connect);

while($rs_find_result_q = mysql_fetch_object($rs_find_stock_price)) {
$rs_price = "$rs_find_result_q->sold_price";
$taxex = "$rs_find_result_q->taxex";
$sold_type = "$rs_find_result_q->sold_type";
$sold_id = "$rs_find_result_q->sold_id";

if($sold_type == "labor") {
$taxrate = getservicetaxrate($taxex);
} else {
$taxrate = getsalestaxrate($taxex);
}

$itemtax = $rs_price * $taxrate;

$rs_insert_cart = "UPDATE sold_items SET itemtax = '$itemtax' WHERE sold_id = '$sold_id'";
@mysql_query($rs_insert_cart, $rs_connect);
}                     
                                                                                       
                            
header("Location: $domain/databaseupgrade-1.06to1.08.php?func=do_upgrade2");
}



function do_upgrade2() {
require_once("header.php");

echo "Upgrade Complete";

require_once("footer.php");

}




switch($func) {
                                                                                                    
    default:
    nothing();
    break;
                                
    case "do_upgrade":
    do_upgrade();
    break;

 case "do_upgrade2":
    do_upgrade2();
    break;


}

?>
