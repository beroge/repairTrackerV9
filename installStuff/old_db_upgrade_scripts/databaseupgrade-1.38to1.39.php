<?php
                                                                                                    
/***************************************************************************
 *   copyright            : (C) 2014 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/

if (array_key_exists('func',$_REQUEST)) {
$func = $_REQUEST['func'];
} else {
$func = "";
}

                                                                                                    
function nothing() {

require_once("validate.php");
require("deps.php");
require("common.php");
require_once("header.php");


$rs_connect = @mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect the db");
$rs_select_db = @mysql_select_db($dbname, $rs_connect) or die("Couldn't select the db");
$sqlcheck = "SELECT * FROM mainassettypes";
$check = mysql_query($sqlcheck, $rs_connect);



start_box();


if($check) {
echo "<br><br><a href=databaseupgrade-1.38to1.39.php?func=do_upgrade>Click Here</a> to upgrade the database from 1.38 to the 1.39 version of PC Repair Tracker.<br><br>";
} else {
echo "<br><br>You must perform previous upgrades first.....<br><br>";
}



stop_box();

require_once("footer.php");
                                                                                                    
}


function do_upgrade() {
require_once("validate.php");
require("deps.php");
require("common.php");

$rs_connect = @mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect the db");
$rs_select_db = @mysql_select_db($dbname, $rs_connect) or die("Couldn't select the db");

mysql_query("SET NAMES utf8");


$sql1 = "ALTER TABLE invoices DROP INDEX woid";
$sql2 = "ALTER TABLE invoices CHANGE  woid  woid TEXT NOT NULL DEFAULT  ''";
$sql3 = "UPDATE invoices SET woid =  '' WHERE woid =  '0'";

$sql4 = "ALTER TABLE  currentcustomer CHANGE woid  woid TEXT NOT NULL";
$sql5 = "ALTER TABLE  receipts DROP INDEX  woid";
$sql6 = "ALTER TABLE  receipts CHANGE  woid  woid TEXT NOT NULL";
$sql7 = "UPDATE receipts SET woid =  '' WHERE woid =  '0'";

$sql8 = "ALTER TABLE currentcustomer CHANGE invoiceid invoiceid TEXT NOT NULL"; 

$sql9 = "ALTER TABLE receipts DROP INDEX invoice_id"; 
$sql10 = "ALTER TABLE receipts CHANGE invoice_id invoice_id TEXT NOT NULL"; 


$sql11 = "ALTER TABLE stockcounts ADD maintainstock INT NOT NULL DEFAULT '0',
ADD minstock INT NOT NULL DEFAULT '0',
ADD maxstock INT NOT NULL DEFAULT '1',
ADD reorderqty INT NOT NULL DEFAULT '1',
ADD reqcount INT NOT NULL DEFAULT '0'";

$sql12 = "CREATE TABLE suppliers (
supplierid INT NOT NULL AUTO_INCREMENT ,
suppliername TEXT NOT NULL ,
supplieraddress1 TEXT NOT NULL ,
supplieraddress2 TEXT NOT NULL ,
suppliercity TEXT NOT NULL ,
supplierstate TEXT NOT NULL ,
supplierzip TEXT NOT NULL ,
supplierphone TEXT NOT NULL ,
supplieremail TEXT NOT NULL ,
supplierwebsite TEXT NOT NULL ,
suppliernotes TEXT NOT NULL ,
supplieraccountno TEXT NOT NULL ,
UNIQUE (
supplierid
)
) ENGINE = MYISAM";


$sql13 = "ALTER TABLE inventory ADD supplierid INT NOT NULL DEFAULT '0',
ADD suppliername TEXT NOT NULL ,
ADD parturl TEXT NOT NULL ,
ADD partnumber TEXT NOT NULL";



$sql14 = "CREATE TABLE specialorders (
  spoid int(11) NOT NULL auto_increment,
  spopartname text NOT NULL,
  spoprice decimal(11,5) NOT NULL default '0.00000',
  spocost decimal(11,5) NOT NULL default '0.00000',
  spowoid int(11) NOT NULL default '0',
  sposupplierid int(11) NOT NULL default '0',
  sposuppliername text NOT NULL,
  spopartnumber text NOT NULL,
  spoparturl text NOT NULL,
  spotracking text NOT NULL,
  spostatus int(11) NOT NULL default '0',
  spodate datetime NOT NULL,
  spoopenclosed int(11) NOT NULL default '0',
  spostoreid int(11) NOT NULL,
  sponotes text NOT NULL,
  UNIQUE KEY spoid (spoid)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";

$sql15 = "ALTER TABLE savedcarts ADD iskit INT NOT NULL DEFAULT '0'";

$sql16 = "CREATE TABLE travellog (
  tlid int(11) NOT NULL auto_increment,
  tlwo int(11) NOT NULL default '0',
  tldate datetime NOT NULL,
  tlmiles decimal(11,1) NOT NULL,
  traveluser text NOT NULL,
  UNIQUE KEY tlid (tlid)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";


@mysql_query($sql1, $rs_connect);
@mysql_query($sql2, $rs_connect);
@mysql_query($sql3, $rs_connect);
@mysql_query($sql4, $rs_connect);
@mysql_query($sql5, $rs_connect);
@mysql_query($sql6, $rs_connect);
@mysql_query($sql7, $rs_connect);
@mysql_query($sql8, $rs_connect);
@mysql_query($sql9, $rs_connect);
@mysql_query($sql10, $rs_connect);
@mysql_query($sql11, $rs_connect);
@mysql_query($sql12, $rs_connect);
@mysql_query($sql13, $rs_connect);
@mysql_query($sql14, $rs_connect);
@mysql_query($sql15, $rs_connect);
@mysql_query($sql16, $rs_connect);

header("Location: databaseupgrade-1.38to1.39.php?func=do_upgrade2");
}



function do_upgrade2() {
require_once("header.php");


start_box();
echo "<br><br><br>Upgrade Complete<br><br><br>";
stop_box();

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
