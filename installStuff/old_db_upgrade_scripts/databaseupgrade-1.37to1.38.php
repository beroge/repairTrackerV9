<?php
                                                                                                    
/***************************************************************************
 *   copyright            : (C) 2013 PCRepairTracker.com
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
echo "<br><br><a href=databaseupgrade-1.37to1.38.php?func=do_upgrade>Click Here</a> to upgrade the database from 1.37 to the 1.38 version of PC Repair Tracker.<br><br>";
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

$sql1 = "ALTER TABLE pc_owner ADD mainassettypeid INT NOT NULL DEFAULT  '1'";
@mysql_query($sql1, $rs_connect);


$sql2 = "CREATE TABLE mainassettypes (
  mainassettypeid int(11) NOT NULL auto_increment,
  mainassetname mediumtext NOT NULL,
  mainassetdefault int(11) NOT NULL,
  subassetlist mediumtext NOT NULL,
  assetinfofields mediumtext NOT NULL,
  PRIMARY KEY  (mainassettypeid)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 AUTO_INCREMENT=10";
@mysql_query($sql2, $rs_connect);

$sql3 = "INSERT INTO mainassettypes (mainassettypeid, mainassetname, mainassetdefault, subassetlist, assetinfofields) VALUES (1, 'Computer', 1, 'a:11:{i:0;s:10:\"Power Cord\";i:1;s:7:\"Printer\";i:2;s:12:\"System Discs\";i:3;s:7:\"Display\";i:4;s:5:\"Modem\";i:5;s:6:\"Router\";i:6;s:11:\"Flash Drive\";i:7;s:17:\"External HD or CD\";i:8;s:5:\"Mouse\";i:9;s:8:\"Keyboard\";i:10;s:7:\"AirCard\";}', 'a:9:{i:0;s:3:\"101\";i:1;s:3:\"100\";i:2;s:3:\"102\";i:3;s:1:\"2\";i:4;s:3:\"104\";i:5;s:1:\"1\";i:6;s:1:\"5\";i:7;s:1:\"4\";i:8;s:3:\"103\";}'),
(2, 'Laptop', 0, 'a:9:{i:0;s:20:\"Laptop Power Adapter\";i:1;s:10:\"Laptop Bag\";i:2;s:7:\"Printer\";i:3;s:12:\"System Discs\";i:4;s:6:\"Router\";i:5;s:11:\"Flash Drive\";i:6;s:17:\"External HD or CD\";i:7;s:5:\"Mouse\";i:8;s:7:\"AirCard\";}', 'a:10:{i:0;s:3:\"101\";i:1;s:3:\"100\";i:2;s:3:\"102\";i:3;s:1:\"2\";i:4;s:1:\"1\";i:5;s:1:\"3\";i:6;s:1:\"4\";i:7;s:1:\"5\";i:8;s:3:\"103\";i:9;s:3:\"104\";}'),
(3, 'Phone', 0, 'a:5:{i:0;s:7:\"Charger\";i:1;s:20:\"USB Sync/Charge Cord\";i:2;s:10:\"Phone Case\";i:3;s:8:\"Sim Card\";i:4;s:11:\"Car Charger\";}', 'a:5:{i:0;s:1:\"2\";i:1;s:3:\"100\";i:2;s:3:\"101\";i:3;s:3:\"106\";i:4;s:3:\"104\";}'),
(4, 'Printer', 0, 'a:2:{i:0;s:10:\"Power Cord\";i:1;s:13:\"Install Discs\";}', 'a:1:{i:0;s:3:\"104\";}'),
(5, 'Router', 0, 'a:2:{i:0;s:10:\"Power Cord\";i:1;s:5:\"Modem\";}', 'a:1:{i:0;s:3:\"104\";}'),
(6, 'Tablet', 0, 'a:7:{i:0;s:7:\"Printer\";i:1;s:5:\"Mouse\";i:2;s:8:\"Keyboard\";i:3;s:7:\"Charger\";i:4;s:20:\"USB Sync/Charge Cord\";i:5;s:8:\"Sim Card\";i:6;s:11:\"Car Charger\";}', 'a:4:{i:0;s:1:\"2\";i:1;s:3:\"103\";i:2;s:3:\"104\";i:3;s:3:\"106\";}'),
(7, 'Other', 0, 'a:0:{}', 'a:0:{}'),
(8, 'Ticket Only', 0, 'a:0:{}', 'a:0:{}')";
@mysql_query($sql3, $rs_connect);



$sql4 = "CREATE TABLE mainassetinfofields (
  mainassetfieldid int(11) NOT NULL auto_increment,
  mainassetfieldname mediumtext NOT NULL,
  matchword mediumtext NOT NULL,
  showonclaim int(11) NOT NULL default '0',
  showonrepair int(11) NOT NULL default '0',
  showoncheckout int(11) NOT NULL default '0',
  showonpricecard int(11) NOT NULL default '0',
  PRIMARY KEY  (mainassetfieldid)
) ENGINE=MyISAM AUTO_INCREMENT=120 DEFAULT CHARSET=utf8 AUTO_INCREMENT=120";
@mysql_query($sql4, $rs_connect);

$sql5 = "INSERT INTO mainassetinfofields (mainassetfieldid, mainassetfieldname, matchword, showonclaim, showonrepair, showoncheckout, showonpricecard) VALUES (100, 'Memory (RAM)', 'ram', 1, 1, 1, 1),
(101, 'Processor (CPU)', 'cpu', 1, 1, 1, 1),
(102, 'Hard Drive', 'partition', 1, 1, 1, 1),
(103, 'Condition', '', 0, 0, 0, 0),
(104, 'Serial No/Service Tag', 'serial', 1, 1, 1, 0),
(106, 'Internal Storage', '', 0, 0, 0, 0)";

while (list($key, $val) = each($custompcinfo)) {

$sqlins = "INSERT INTO mainassetinfofields (mainassetfieldid, mainassetfieldname, showonclaim, showonrepair, showoncheckout, showonpricecard) VALUES ('$key', '$val', 0, 0, 0, 0)";
@mysql_query($sqlins, $rs_connect);
}

@mysql_query($sql5, $rs_connect);

$rs_findowner = "SELECT * FROM pc_owner";
$rs_result2 = mysql_query($rs_findowner, $rs_connect);
while($rs_result_q2 = mysql_fetch_object($rs_result2)) {
$pcid = "$rs_result_q2->pcid";
$pcram = "$rs_result_q2->pcram";
$pcproc = "$rs_result_q2->pcproc";
$pchd = "$rs_result_q2->pchd";
$pccond = "$rs_result_q2->pccond";
$pcserial = "$rs_result_q2->pcserial";
$pcextra = "$rs_result_q2->pcextra";

if ($pcextra != "") {
$pcextraindb3 = unserialize($pcextra);
} else {
$pcextraindb3 = array();
}

if (is_array($pcextraindb3)) {
$pcextraindb = $pcextraindb3;
} else {
$pcextraindb = array();
}

$pcextraindb['100'] = "$pcram"; 
$pcextraindb['101'] = "$pcproc";
$pcextraindb['102'] = "$pchd";
$pcextraindb['103'] = "$pccond";
$pcextraindb['104'] = "$pcserial";

$pcextra = pv(serialize($pcextraindb));

$rs_update = "UPDATE pc_owner SET pcextra = '$pcextra' WHERE pcid = '$pcid'";
@mysql_query($rs_update, $rs_connect);

}



#tax changes

$sql6 = "ALTER TABLE taxes ADD shortname MEDIUMTEXT NOT NULL ,
ADD isgrouprate INT NOT NULL DEFAULT '0',
ADD compositerate MEDIUMTEXT NOT NULL";
@mysql_query($sql6, $rs_connect);


# scheduled status

$sql7 = "ALTER TABLE pc_wo ADD skeddate DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER readydate, ADD sked INT NOT NULL DEFAULT '0' AFTER skeddate";
@mysql_query($sql7, $rs_connect);

$sql7_2 = "ALTER TABLE pc_wo ADD INDEX (sked)";
@mysql_query($sql7_2, $rs_connect);

#receipts

$sql8 = "ALTER TABLE users ADD narrow INT NOT NULL DEFAULT '0'";
@mysql_query($sql8, $rs_connect);

$sql9 = "ALTER TABLE users ADD narrowct INT NOT NULL DEFAULT  '0'";
@mysql_query($sql9, $rs_connect);


#timer

$sql10 = "CREATE TABLE timers (
 timerid INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
 woid INT NOT NULL,
 timerstart DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
 timerstop DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
 timertotal INT NOT NULL DEFAULT '0',
 timerdesc MEDIUMTEXT NOT NULL
) ENGINE = MYISAM";

$sql11 = "ALTER TABLE timers ADD billedout INT NOT NULL DEFAULT '0'";

$sql11_2 = "ALTER TABLE timers ADD byuser TEXT NOT NULL";

@mysql_query($sql10, $rs_connect);
@mysql_query($sql11, $rs_connect);
@mysql_query($sql11_2, $rs_connect);

#login attempts

$sql12 = "CREATE TABLE loginattempts (
username TEXT NOT NULL,
ipaddress TEXT NOT NULL,
attempttime DATETIME NOT NULL
) ENGINE = MYISAM";

@mysql_query($sql12, $rs_connect);


# change

$sql13 = "ALTER TABLE currentpayments ADD cashchange TEXT NOT NULL";
$sql14 = "ALTER TABLE savedpayments ADD cashchange TEXT NOT NULL";
$sql14_2 = "ALTER TABLE deposits ADD cashchange TEXT NOT NULL";



@mysql_query($sql13, $rs_connect);
@mysql_query($sql14, $rs_connect);
@mysql_query($sql14_2, $rs_connect);

# BC additions

$sql15 = "ALTER TABLE timers ADD pcgroupid INT NOT NULL DEFAULT '0'";
$sql16 = "ALTER TABLE timers ADD blockcontractid INT NOT NULL DEFAULT '0'";
$sql17 = "ALTER TABLE timers ADD savedround INT NOT NULL DEFAULT '0'";

$sql18 = "ALTER TABLE rinvoices ADD blockcontractid INT NOT NULL DEFAULT '0',
ADD blockhours INT NOT NULL DEFAULT '0'";

@mysql_query($sql15, $rs_connect);
@mysql_query($sql16, $rs_connect);
@mysql_query($sql17, $rs_connect);
@mysql_query($sql18, $rs_connect);



$sql19 = "CREATE TABLE blockcontract (
  blockid int(11) NOT NULL auto_increment,
  blocktitle text NOT NULL,
  blocknote text NOT NULL,
  blockstart date NOT NULL,
  pcgroupid int(11) NOT NULL default '0',
  contractclosed int(11) NOT NULL default '0',
  hourscache float(11,2) NOT NULL default '0.00',
  UNIQUE KEY blockid (blockid)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";


$sql20 = "CREATE TABLE blockcontracthours (
  blockcontracthoursid int(11) NOT NULL auto_increment,
  blockhours float(11,2) NOT NULL,
  blockhoursdate date NOT NULL,
  blockcontractid int(11) NOT NULL,
  invoiceid int(11) NOT NULL,
  UNIQUE KEY blockcontractid (blockcontracthoursid)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";


@mysql_query($sql19, $rs_connect);
@mysql_query($sql20, $rs_connect);


$sql21 = "ALTER TABLE stock ADD avg_cost FLOAT( 11, 5 ) NOT NULL DEFAULT '0.00000'";
@mysql_query($sql21, $rs_connect);

header("Location: databaseupgrade-1.37to1.38.php?func=do_upgrade2");
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
