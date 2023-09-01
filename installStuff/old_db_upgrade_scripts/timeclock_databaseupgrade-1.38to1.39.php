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
echo "<br><br><a href=timeclock_databaseupgrade-1.38to1.39.php?func=do_upgrade>Click Here</a> to add the timeclock to the 1.39 version of PC Repair Tracker.<br><br>";
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


$sql1 = "CREATE TABLE allowedip (
  ipid int(11) NOT NULL auto_increment,
  ipaddress text collate utf8_unicode_ci NOT NULL,
  dateadded date NOT NULL,
  lastaccess date NOT NULL,
  PRIMARY KEY  (ipid)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3";

$sql2 = "CREATE TABLE departments (
  deptid int(11) NOT NULL auto_increment,
  deptcode mediumtext collate utf8_unicode_ci NOT NULL,
  deptname mediumtext collate utf8_unicode_ci NOT NULL,
  UNIQUE KEY deptid (deptid)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1";



$sql3 = "CREATE TABLE employees (
  employeeid int(11) NOT NULL auto_increment,
  clocknumber int(11) default '0',
  employeename varchar(255) collate utf8_unicode_ci default NULL,
  isactive int(11) NOT NULL default '1',
  location int(11) NOT NULL default '1',
  deptid int(11) NOT NULL default '0',
  fulltime int(11) NOT NULL default '0',
  PRIMARY KEY  (employeeid),
  KEY clocknumber (clocknumber)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1";



$sql4 = "CREATE TABLE ephotos (
  ephotoid int(11) NOT NULL auto_increment,
  eid int(11) NOT NULL,
  photofilename mediumtext collate utf8_unicode_ci NOT NULL,
  addtime timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (ephotoid)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3";


$sql5 = "CREATE TABLE punches (
  punchid int(11) NOT NULL auto_increment,
  employeeid int(11) NOT NULL,
  punchstatus mediumtext collate utf8_unicode_ci NOT NULL,
  punchin datetime NOT NULL,
  punchout datetime NOT NULL,
  medit mediumtext collate utf8_unicode_ci NOT NULL,
  thein mediumtext collate utf8_unicode_ci NOT NULL,
  theout mediumtext collate utf8_unicode_ci NOT NULL,
  editnote mediumtext collate utf8_unicode_ci NOT NULL,
  servertime timestamp NOT NULL default CURRENT_TIMESTAMP,
  punchtype int(11) NOT NULL default '1',
  punchtypeout int(11) NOT NULL default '1',
  breakin datetime NOT NULL,
  breakout datetime NOT NULL,
  PRIMARY KEY  (punchid),
  KEY employeeid (employeeid)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11";



$sql6 = "ALTER TABLE `users` ADD `timeclockperms` TEXT NOT NULL ,
ADD `defloc` TINYINT( 4 ) NOT NULL DEFAULT '1',
ADD `locperms` TEXT NOT NULL ,
ADD `deptperms` TEXT NOT NULL";

$sql7 = "CREATE TABLE locations (
  locid int(11) NOT NULL auto_increment,
  locname mediumtext collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (locid)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1";


$sql8 = "ALTER TABLE stores ADD tempbadge TEXT NOT NULL";


@mysql_query($sql1, $rs_connect);
@mysql_query($sql2, $rs_connect);
@mysql_query($sql3, $rs_connect);
@mysql_query($sql4, $rs_connect);
@mysql_query($sql5, $rs_connect);
@mysql_query($sql6, $rs_connect);
@mysql_query($sql7, $rs_connect);
@mysql_query($sql8, $rs_connect);

header("Location: timeclock_databaseupgrade-1.38to1.39.php?func=do_upgrade2");
}



function do_upgrade2() {
require_once("header.php");


start_box();
echo "<br><br><br>Timeclock Additions Complete<br><br><br>";
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
