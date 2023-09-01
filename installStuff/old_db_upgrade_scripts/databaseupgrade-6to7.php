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


$sqlcheck = "SELECT * FROM custtags";
$check = mysqli_query($rs_connect, $sqlcheck);


start_box();

if($check) {
echo "<br><br><a href=databaseupgrade-6to7.php?func=do_upgrade>Click Here</a> to upgrade the database from v6 to v7 of PC Repair Tracker.<br><br>";
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


$sql1_2 = "ALTER TABLE cart ADD printdesc TEXT NOT NULL";
$sql1 = "ALTER TABLE stock ADD stock_pdesc TEXT NOT NULL";
$sql2 = "ALTER TABLE invoice_items ADD printdesc TEXT NOT NULL"; 
$sql3 = "ALTER TABLE repaircart ADD printdesc TEXT NOT NULL"; 
$sql4 = "ALTER TABLE rinvoice_items ADD printdesc TEXT NOT NULL"; 
$sql5 = "ALTER TABLE savedcarts ADD printdesc TEXT NOT NULL"; 
$sql6 = "ALTER TABLE sold_items ADD printdesc TEXT NOT NULL"; 
$sql7 = "ALTER TABLE quicklabor ADD printdesc TEXT NOT NULL";
$sql8 = "ALTER TABLE specialorders ADD printdesc TEXT NOT NULL";


$sql9 = "ALTER TABLE cart ADD discountname TEXT NOT NULL"; 
$sql10 = "ALTER TABLE invoice_items ADD discountname TEXT NOT NULL"; 
$sql11 = "ALTER TABLE repaircart ADD discountname TEXT NOT NULL"; 
$sql12 = "ALTER TABLE rinvoice_items ADD discountname TEXT NOT NULL"; 
$sql13 = "ALTER TABLE savedcarts ADD discountname TEXT NOT NULL";
$sql14 = "ALTER TABLE sold_items ADD discountname TEXT NOT NULL";


$sql15 = "ALTER TABLE mainassetinfofields ADD showonbenchsheet INT NOT NULL DEFAULT '0'";

$sql16 = "ALTER TABLE users ADD promiseview INT NOT NULL DEFAULT '0'";

$sql16_2 = "ALTER TABLE pc_wo ADD servicepromiseid int(11) NOT NULL DEFAULT '0'";
$sql16_3 = "ALTER TABLE pc_wo ADD promisedtime datetime NOT NULL DEFAULT '0000-00-00 00:00:00'";


$sql17 = "ALTER TABLE pc_wo ADD INDEX ( promisedtime )"; 
$sql18 = "ALTER TABLE pc_wo ADD INDEX ( servicepromiseid )"; 


$sql19 = "CREATE TABLE IF NOT EXISTS discounts (
  discountid int(11) NOT NULL AUTO_INCREMENT,
  discounttitle text NOT NULL,
  discountamount decimal(11,5) NOT NULL,
  discounttype int(11) NOT NULL DEFAULT '1',
  theorder int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (discountid)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14";


$sql20 = "INSERT INTO discounts (discountid, discounttitle, discountamount, discounttype, theorder) VALUES
(1, '5% Off', '5.00000', 1, 15),
(2, '$10 Off', '10.00000', 2, 5),
(3, 'Returning Customer Discount', '10.00000', 1, 25),
(11, 'Customer Referral Discount', '15.00000', 1, 20),
(12, '10% Off', '10.00000', 1, 10),
(13, '$20 Off', '20.00000', 2, 0)";


$sql21 = "CREATE TABLE IF NOT EXISTS servicepromises (
  servicepromiseid int(11) NOT NULL AUTO_INCREMENT,
  sptitle text NOT NULL,
  sptype int(11) NOT NULL,
  sptime int(11) NOT NULL,
  sptimeofday time NOT NULL DEFAULT '00:00:00',
  theorder int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (servicepromiseid)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20";


$sql22 = "INSERT INTO servicepromises (servicepromiseid, sptitle, sptype, sptime, sptimeofday, theorder) VALUES
(1, '1 Hour', 1, 3600, '00:00:00', 40),
(2, '2 Hours', 1, 7200, '00:00:00', 35),
(3, '3 Hours', 1, 10800, '00:00:00', 30),
(4, 'Tomorrow End of Day', 2, 86400, '17:00:00', 15),
(5, 'End of Today', 2, 0, '17:00:00', 20),
(12, '4 Hours', 1, 14400, '00:00:00', 25),
(16, '2 Days End of Day', 2, 172800, '17:00:00', 10),
(17, '3 Days End of Day', 2, 259200, '17:00:00', 5),
(18, '1 Week End of Day', 2, 604800, '17:00:00', 0)";


$sql23 = "ALTER TABLE pc_wo ADD wocheckstime DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER wochecks";

 $sql24 = "CREATE TABLE IF NOT EXISTS imessages (
  imessageid int(11) NOT NULL AUTO_INCREMENT,
  imessagedate datetime NOT NULL,
  imessage text CHARACTER SET utf8 NOT NULL,
  imessagefrom varchar(50) CHARACTER SET utf8 NOT NULL,
  imessageinvolves varchar(200) CHARACTER SET utf8 NOT NULL,
  imessagereadby varchar(200) CHARACTER SET utf8 NOT NULL,
  imessagereferences text NOT NULL,
  PRIMARY KEY (imessageid),
  KEY imessagedate (imessagedate),
  KEY imessagereadby (imessagereadby),
  KEY imessageinvolves (imessageinvolves)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";


 $sql25 = "ALTER TABLE users ADD lastmessage int(11) NOT NULL DEFAULT '0'";


@mysqli_query($rs_connect, $sql1);
@mysqli_query($rs_connect, $sql1_2);
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
@mysqli_query($rs_connect, $sql16_2);
@mysqli_query($rs_connect, $sql16_3);
@mysqli_query($rs_connect, $sql17);
@mysqli_query($rs_connect, $sql18);
@mysqli_query($rs_connect, $sql19);
@mysqli_query($rs_connect, $sql20);
@mysqli_query($rs_connect, $sql21);
@mysqli_query($rs_connect, $sql22);
@mysqli_query($rs_connect, $sql23);
@mysqli_query($rs_connect, $sql24);
@mysqli_query($rs_connect, $sql25);

header("Location: databaseupgrade-6to7.php?func=do_upgrade2");
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


