<?php
                                                                                                    
/***************************************************************************
 *   copyright            : (C) 2018 PCRepairTracker.com
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


$sqlcheck = "SELECT * FROM creds";
$check = mysqli_query($rs_connect, $sqlcheck);


start_box();

if($check) {
echo "<br><br><a href=databaseupgrade-5to6.php?func=do_upgrade>Click Here</a> to upgrade the database from v5 to v6 of PC Repair Tracker.<br><br>";
} else {
echo "You must perform previous upgrades first. Database tables that should already be there from a previous PCRT version are missing.";
}


stop_box();

require_once("footer.php");
                                                                                                    
}


function do_upgrade() {
require_once("validate.php");
require("deps.php");
require("common.php");

$sql1 = "ALTER TABLE cart ADD quantity DECIMAL( 11, 5 ) NOT NULL DEFAULT '1',
ADD unit_price DECIMAL( 11, 5 ) NOT NULL DEFAULT '0.00000'";

$sql2 = "ALTER TABLE invoice_items ADD quantity DECIMAL( 11, 5 ) NOT NULL DEFAULT '1',
ADD unit_price DECIMAL( 11, 5 ) NOT NULL DEFAULT '0.00000'";

$sql3 = "ALTER TABLE repaircart ADD quantity DECIMAL( 11, 5 ) NOT NULL DEFAULT '1',
ADD unit_price DECIMAL( 11, 5 ) NOT NULL DEFAULT '0.00000'";

$sql4 = "ALTER TABLE rinvoice_items ADD quantity DECIMAL( 11, 5 ) NOT NULL DEFAULT '1',
ADD unit_price DECIMAL( 11, 5 ) NOT NULL DEFAULT '0.00000'";

$sql5 = "ALTER TABLE savedcarts ADD quantity DECIMAL( 11, 5 ) NOT NULL DEFAULT '1',
ADD unit_price DECIMAL( 11, 5 ) NOT NULL DEFAULT '0.00000'";

$sql6 = "ALTER TABLE sold_items ADD quantity DECIMAL( 11, 5 ) NOT NULL DEFAULT '1',
ADD unit_price DECIMAL( 11, 5 ) NOT NULL DEFAULT '0.00000'";

$sql7 = "ALTER TABLE specialorders ADD quantity DECIMAL( 11, 5 ) NOT NULL DEFAULT '1',
ADD unit_price DECIMAL( 11, 5 ) NOT NULL DEFAULT '0.00000'";


$sql8 = "UPDATE cart SET unit_price = cart_price";
$sql9 = "UPDATE invoice_items SET unit_price = cart_price";
$sql10 = "UPDATE repaircart SET unit_price = cart_price";
$sql11 = "UPDATE rinvoice_items SET unit_price = cart_price";
$sql12 = "UPDATE savedcarts SET unit_price = cart_price";
$sql13 = "UPDATE sold_items SET unit_price = sold_price";
$sql14 = "UPDATE specialorders SET unit_price = spoprice";

$sql15 = "ALTER TABLE sold_items CHANGE return_receipt return_receipt TEXT NOT NULL DEFAULT ''";
$sql16 = "UPDATE sold_items SET return_receipt = '' WHERE return_receipt = '0'";

$sql17 = "ALTER TABLE pc_owner ADD tags TEXT NOT NULL";

$sql18 = "ALTER TABLE pc_group ADD tags TEXT NOT NULL";

$sql19 = "ALTER TABLE users ADD notifytime DATETIME NOT NULL";

$sql20 = "ALTER TABLE stickynotes ADD stickyduedateend DATETIME NOT NULL AFTER stickyduedate";

$sql21 = "ALTER TABLE inventory ADD ponumber TEXT NOT NULL";

$sql22 = "ALTER TABLE messages ADD mediaurls TEXT NOT NULL";


$sql23 = "CREATE TABLE IF NOT EXISTS custtags (
  tagid int(11) NOT NULL AUTO_INCREMENT,
  thetag mediumtext COLLATE utf8_unicode_ci NOT NULL,
  tagenabled int(11) NOT NULL DEFAULT '1',
  tagicon mediumtext COLLATE utf8_unicode_ci NOT NULL,
  theorder int(11) NOT NULL,
  PRIMARY KEY (tagid)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=26";


$sql24 = "INSERT INTO custtags (tagid, thetag, tagenabled, tagicon, theorder) VALUES
(1, 'Crappy Computer', 1, '1f4a9.png', 0),
(2, 'Great Customer', 1, '1f4b0.png', 105),
(3, 'Slow Paying Customer', 1, '1f422.png', 95),
(5, 'Night Shift Customer', 1, '1f303.png', 30),
(6, 'Refuse Service', 1, '26d4.png', 110),
(7, 'Gamer', 1, '1f3ae.png', 35),
(8, 'Previous Water Damage', 1, '1f4a6.png', 5),
(9, 'Doctor', 1, '1f3e8.png', 40),
(10, 'Premier Business Client', 1, '1f4bc.png', 50),
(11, 'Buggy Computer', 1, '1f41e.png', 10),
(12, 'Special Needs', 1, '267f.png', 60),
(13, 'Slow Computer', 1, '1f40c.png', 15),
(14, 'Always Call Customer', 1, '1f4de.png', 100),
(15, 'Smoker', 1, '1f6ad.png', 55),
(16, 'Online Gambler', 1, '2663.png', 65),
(17, 'Cash Only', 1, '1f4b5.png', 115),
(19, 'Temperamental', 1, '1f621.png', 70),
(20, 'Hard of Hearing', 1, '1f442.png', 80),
(21, '-Customer Tags', 1, '', 85),
(22, '-Device Tags', 1, '', 20),
(23, '-Billing Tags', 1, '', 120),
(24, 'Government/Politician', 1, '1f451.png', 25),
(25, 'Tax Exempt', 1, '1f4b5.png', 90)";





@mysqli_query($rs_connect, $sql1);
@mysqli_query($rs_connect, $sql2);
@mysqli_query($rs_connect, $sql3);
@mysqli_query($rs_connect, $sql4);
@mysqli_query($rs_connect, $sql5);
@mysqli_query($rs_connect, $sql6);
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
@mysqli_query($rs_connect, $sql18);
@mysqli_query($rs_connect, $sql19);
@mysqli_query($rs_connect, $sql20);
@mysqli_query($rs_connect, $sql21);
@mysqli_query($rs_connect, $sql22);
@mysqli_query($rs_connect, $sql23);
@mysqli_query($rs_connect, $sql24);


header("Location: databaseupgrade-5to6.php?func=do_upgrade2");
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


