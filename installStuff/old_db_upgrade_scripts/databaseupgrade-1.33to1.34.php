<?php
                                                                                                    
/***************************************************************************
 *   copyright            : (C) 2010 PCRepairTracker.com
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
require_once("header.php");

start_box();
echo "<br><br><a href=databaseupgrade-1.33to1.34.php?func=do_upgrade>Click Here</a> to upgrade the database from 1.33 to the 1.34 version of PC Repair Tracker.<br><br>";
stop_box();

require_once("footer.php");
                                                                                                    
}


function do_upgrade() {
require_once("validate.php");
require("deps.php");
require("common.php");

$rs_connect = @mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect the db");
$rs_select_db = @mysql_select_db($dbname, $rs_connect) or die("Couldn't select the db");



$sql1 = "ALTER TABLE pc_wo ADD thesigwo TEXT NOT NULL AFTER thesig";
$sql2 = "ALTER TABLE stockcounts ADD lastcounted DATETIME NOT NULL";

$sql3 = "CREATE TABLE attachments (
  attach_id int(11) NOT NULL auto_increment,
  attach_title text NOT NULL,
  attach_filename text NOT NULL,
  attach_size int(11) NOT NULL,
  attach_dcount int(11) NOT NULL,
  attach_keywords text NOT NULL,
  pcid int(11) NOT NULL,
  woid int(11) NOT NULL,
  groupid int(11) NOT NULL,
  attach_cat int(11) NOT NULL,
  attach_date datetime NOT NULL,
  UNIQUE KEY attach_id (attach_id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";


$sql4 = "CREATE TABLE techdocs (
  techdoccatid int(11) NOT NULL auto_increment,
  techdoccatname text NOT NULL,
  UNIQUE KEY techdoccatid (techdoccatid)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";

$sql5 = "CREATE TABLE smstext (
  smstextid int(11) NOT NULL auto_increment,
  smstext text NOT NULL,
  theorder int(11) NOT NULL default '0',
  PRIMARY KEY  (smstextid)
) ENGINE=MyISAM AUTO_INCREMENT=1";


$sql6 = "ALTER TABLE stores ADD storehash TEXT NOT NULL";

$sql7 = "CREATE TABLE claimsigtext (
 sigtextid INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
 sigtext TEXT NOT NULL ,
 woid INT NOT NULL
) ENGINE = MYISAM";




$sql8 = "ALTER TABLE inventory ADD itemserial TEXT NOT NULL";
$sql9 = "ALTER TABLE cart ADD itemserial TEXT NOT NULL";
$sql10 = "ALTER TABLE invoice_items ADD itemserial TEXT NOT NULL";
$sql11 = "ALTER TABLE repaircart ADD itemserial TEXT NOT NULL";
$sql12 = "ALTER TABLE savedcarts ADD itemserial TEXT NOT NULL";
$sql13 = "ALTER TABLE sold_items ADD itemserial TEXT NOT NULL";

$sql14 = "INSERT INTO techdocs (techdoccatid, techdoccatname) VALUES (1, 'Windows XP'),
(2, 'Windows 7'),
(3, 'Windows Vista'),
(4, 'Networking'),
(5, 'Virus Removal'),
(6, 'Hardware'),
(7, 'Apple - MAC'),
(8, 'Printers'),
(9, 'Routers'),
(10, 'Software'),
(12, 'Other')";

$sql15 = "INSERT INTO smstext (smstextid, smstext, theorder) VALUES (1, 'Your repair is completed and ready for pickup!\r\n-PC Repair Tracker', 15),
(2, 'Please call the office at  XXX-XXX-XXXX\r\n-PC Repair Tracker', 10),
(4, 'Please Call the office at  XXX-XXX-XXXX, we need your password\r\n-PC Repair Tracker', 0),
(5, 'Your computer is taking longer than expected, will be ready tomorrow\r\n-PC Repair Tracker', 5)";





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

header("Location: databaseupgrade-1.33to1.34.php?func=do_upgrade2");
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
