<?php
                                                                                                    
/***************************************************************************
 *   copyright            : (C) 2016 PCRepairTracker.com
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


$sqlcheck = "SELECT * FROM rwo";
$check = mysqli_query($rs_connect, $sqlcheck);



start_box();

if($check) {
echo "<br><br><a href=databaseupgrade-3to4.php?func=do_upgrade>Click Here</a> to upgrade the database from v3 to v4 of PC Repair Tracker.<br><br>";
} else {
echo "You must perform previous upgrades first.";
}


stop_box();

require_once("footer.php");
                                                                                                    
}


function do_upgrade() {
require_once("validate.php");
require("deps.php");
require("common.php");


$sql1 = "ALTER TABLE users ADD pin MEDIUMTEXT NOT NULL";

$sql2 = "CREATE TABLE IF NOT EXISTS denoms (
  denomid int(11) NOT NULL AUTO_INCREMENT,
  denomvalue decimal(11,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (denomid)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1";

$sql3 = "CREATE TABLE IF NOT EXISTS registers (
  registerid int(11) NOT NULL AUTO_INCREMENT,
  registername text NOT NULL,
  registerstoreid int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (registerid)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1";

$sql4 = "ALTER TABLE receipts ADD registerid INT NOT NULL DEFAULT '0'";

$sql5 = "ALTER TABLE sold_items ADD registerid INT NOT NULL DEFAULT '0'";

$sql6 = "ALTER TABLE deposits ADD registerid INT NOT NULL DEFAULT '0'";
$sql61 = "ALTER TABLE deposits ADD aregisterid INT NOT NULL DEFAULT '0'";

$sql7 = "ALTER TABLE savedpayments ADD registerid INT NOT NULL DEFAULT '0'";

$sql8 = "CREATE TABLE IF NOT EXISTS regclose (
  regcloseid int(11) NOT NULL AUTO_INCREMENT,
  registerid int(11) NOT NULL DEFAULT '0',
  storeid int(11) NOT NULL DEFAULT '0',
  paymentplugin text COLLATE utf8_unicode_ci NOT NULL,
  opendate datetime NOT NULL,
  closeddate datetime NOT NULL,
  closedby text COLLATE utf8_unicode_ci NOT NULL,
  counttotal decimal(11,5) NOT NULL,
  expectedtotal decimal(11,2) NOT NULL DEFAULT '0.00',
  variance decimal(11,5) NOT NULL,
  balanceforward decimal(11,5) NOT NULL,
  removedtotal decimal(11,5) NOT NULL,
  countarray text COLLATE utf8_unicode_ci NOT NULL,
  notes text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (regcloseid),
  KEY registerid (registerid),
  KEY storeid (storeid)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1";

$sql9 = "ALTER TABLE savedpayments ADD depositid INT NOT NULL DEFAULT '0'";

$sql10 = "CREATE TABLE IF NOT EXISTS storagelocations (
  slid int(11) NOT NULL AUTO_INCREMENT,
  slname text COLLATE utf8_unicode_ci NOT NULL,
  theorder int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (slid)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1";

$sql11 = "ALTER TABLE pc_wo ADD slid INT NOT NULL DEFAULT '0'";

$sql12 = "ALTER TABLE employees ADD linkeduser TEXT NOT NULL";

$sql13 = "CREATE TABLE IF NOT EXISTS checks (
  checkid int(11) NOT NULL AUTO_INCREMENT,
  checkname text NOT NULL,
  PRIMARY KEY (checkid)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1";

$sql14 = "ALTER TABLE mainassettypes ADD mainassetchecks TEXT NOT NULL";

$sql15 = "ALTER TABLE pc_wo ADD wochecks TEXT NOT NULL";

$sql16 = "INSERT INTO checks (checkid, checkname) VALUES
(2, 'Wifi'),
(3, 'Wired Network Adapter'),
(4, 'Safe Browser Homepage'),
(5, 'Missing Drivers'),
(6, 'Hard Drive Smart Test'),
(7, 'PUP Toolbars'),
(8, 'Sound'),
(9, 'DVD Drive'),
(10, 'Touchscreen'),
(11, 'Power Jack'),
(12, 'USB Ports'),
(13, 'Screen Hinges'),
(14, 'Battery'),
(15, 'No Malicious Browser Extensions'),
(16, 'Updates Current'),
(17, 'Current Anti-Virus'),
(18, 'Drive under 10% Fragmentation')";

$sql17 = "INSERT INTO denoms (denomid, denomvalue) VALUES
(1, '0.05'),
(12, '0.01'),
(3, '0.25'),
(4, '0.10'),
(5, '0.50'),
(6, '1.00'),
(7, '5.00'),
(8, '10.00'),
(9, '20.00'),
(10, '50.00'),
(11, '100.00')";


@mysqli_query($rs_connect, $sql1);
@mysqli_query($rs_connect, $sql2);
@mysqli_query($rs_connect, $sql3);
@mysqli_query($rs_connect, $sql4);
@mysqli_query($rs_connect, $sql5);
@mysqli_query($rs_connect, $sql6);
@mysqli_query($rs_connect, $sql61);
@mysqli_query($rs_connect, $sql7);
@mysqli_query($rs_connect, $sql8);
@mysqli_query($rs_connect, $sql9);
@mysqli_query($rs_connect, $sql10);
@mysqli_query($rs_connect, $sql11);
@mysqli_query($rs_connect, $sql12);
@mysqli_query($rs_connect, $sql13);
@mysqli_query($rs_connect, $sql14);
@mysqli_query($rs_connect, $sql15);
@mysqli_query($rs_connect, $sql16);
@mysqli_query($rs_connect, $sql17);




header("Location: databaseupgrade-3to4.php?func=do_upgrade2");
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


