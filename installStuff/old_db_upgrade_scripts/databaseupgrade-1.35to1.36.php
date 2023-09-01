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
echo "<br><br><a href=databaseupgrade-1.35to1.36.php?func=do_upgrade>Click Here</a> to upgrade the database from 1.35 to the 1.36 version of PC Repair Tracker.<br><br>";
stop_box();

require_once("footer.php");
                                                                                                    
}


function do_upgrade() {
require_once("validate.php");
require("deps.php");
require("common.php");

$rs_connect = @mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect the db");
$rs_select_db = @mysql_select_db($dbname, $rs_connect) or die("Couldn't select the db");


$sql1 = "CREATE TABLE serviceremindercanned (
  srid int(11) NOT NULL auto_increment,
  srtitle text NOT NULL,
  srtext text NOT NULL,
  srorder int(11) NOT NULL,
  UNIQUE KEY srid (srid)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";


$sql2 = "INSERT INTO `serviceremindercanned` (`srid`, `srtitle`, `srtext`, `srorder`) VALUES (1, 'Anti-Virus Renewal', 'Your Anti-Virus software subscription will expire soon. Please give us a call or stop in to our store at your convenience to inquire about renewing your subscription so that your computer will continue to be protected by the latest threats.', 20),
(2, 'Dust Cleaning', 'Your computer is due to have the dirt and dust cleaned from the inside. Dust build up is leading cause of overheating. Continued overheating can cause permanent and costly damage to your computer. Please contact us to inquire about having this service performed on your computer.', 30),
(3, 'Computer Tuneup', 'This message is just to remind you that it has been a while since your computer last had a tuneup performed. Regular tuneups can help insure top performance of your computer as well as preventing serious problems that can be caught earlier before they happen. We can also make sure your anti-virus is performing properly. Please contact us to ask about all the details.', 10),
(4, 'Disk Defragmentation & Cleanup', 'It is recommended that your computer be defragged for optimum performance. This is a great task to start before you go to bed for the night. Select the \"Defraggler\" icon on your desktop and click the defrag button to start the process. \r\n\r\nIt is also recommend to clean out your temp folders by selecting the \"CCleaner\" icon on your desktop and hitting the \"Run Cleaner\" button to perform a cleanup on your computer', 15),
(5, 'Thank You for your Business!', 'Thank you for choosing us as your computer service company!', 0),
(6, 'Check Your Backup', 'This is just a reminder to make sure to check your backup system on your computer to make sure it is running correctly. If you would like some help with this, feel free to give us a call.', 25),
(7, 'Get a 20% Discount', 'Bring this page in to receive a free dust cleaning or 20% off the regular price of a full tuneup for this computer. This offer is valid within 14 days of the date at the top of this page', 5)";

$sql25 = "CREATE TABLE servicereminders (
  srid int(11) NOT NULL auto_increment,
  srpcid int(11) NOT NULL,
  srnote text NOT NULL,
  srdate date NOT NULL,
  srcanned text NOT NULL,
  srsent int(11) NOT NULL default '0',
  UNIQUE KEY srid (srid)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 AUTO_INCREMENT=7";



$sql3 = "ALTER TABLE pc_wo ADD showsigct INT NOT NULL DEFAULT '1',
ADD showsigrr INT NOT NULL DEFAULT '1'";


$sql4 = "ALTER TABLE invoices ADD thesig TEXT NOT NULL ,
ADD showsiginv INT NOT NULL DEFAULT '1'";

$sql5 = "ALTER TABLE receipts ADD thesig TEXT NOT NULL ,
ADD showsigrec INT NOT NULL DEFAULT '1'";

$sql6 = "ALTER TABLE deposits ADD thesig TEXT NOT NULL ,
ADD showsigdep INT NOT NULL DEFAULT '1'";

$sql7 = "ALTER TABLE users ADD useremail TEXT NOT NULL ,
ADD usermobile TEXT NOT NULL";

$sql8 = "ALTER TABLE stores ADD oncalluser TEXT NOT NULL";

$sql9 = "CREATE TABLE servicerequests (
  sreq_id int(11) NOT NULL auto_increment,
  sreq_ip text NOT NULL,
  sreq_agent text NOT NULL,
  sreq_name text NOT NULL,
  sreq_homephone text NOT NULL,
  sreq_cellphone text NOT NULL,
  sreq_workphone text NOT NULL,
  sreq_addy1 text NOT NULL,
  sreq_addy2 text NOT NULL,
  sreq_city text NOT NULL,
  sreq_state text NOT NULL,
  sreq_zip text NOT NULL,
  sreq_email text NOT NULL,
  sreq_problem text NOT NULL,
  sreq_model text NOT NULL,
  sreq_datetime datetime NOT NULL,
  sreq_processed int(11) NOT NULL default '0',
  storeid int(11) NOT NULL default '0',
  sreq_custsourceid int(11) NOT NULL default '0',
  sreq_pcid int(11) NOT NULL default '0',
  PRIMARY KEY  (sreq_id)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";

$sql10 = "ALTER TABLE currentcustomer ADD ccompany TEXT NOT NULL";
$sql11 = "ALTER TABLE deposits ADD pcompany TEXT NOT NULL";
$sql12 = "ALTER TABLE invoices ADD invcompany TEXT NOT NULL";
$sql13 = "ALTER TABLE pc_group ADD grpcompany TEXT NOT NULL";
$sql14 = "ALTER TABLE pc_owner ADD pccompany TEXT NOT NULL";
$sql15 = "ALTER TABLE receipts ADD company TEXT NOT NULL";
$sql16 = "ALTER TABLE rinvoices ADD invcompany TEXT NOT NULL";
$sql17 = "ALTER TABLE savedpayments ADD pcompany TEXT NOT NULL";
$sql18 = "ALTER TABLE servicerequests ADD sreq_company TEXT NOT NULL";
$sql19 = "ALTER TABLE stickynotes ADD stickycompany TEXT NOT NULL";
$sql20 = "ALTER TABLE currentpayments ADD pcompany TEXT NOT NULL";


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
@mysql_query($sql17, $rs_connect);
@mysql_query($sql18, $rs_connect);
@mysql_query($sql19, $rs_connect);
@mysql_query($sql20, $rs_connect);
@mysql_query($sql25, $rs_connect);

header("Location: databaseupgrade-1.35to1.36.php?func=do_upgrade2");
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
