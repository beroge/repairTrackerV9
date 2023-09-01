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
echo "<br><br><a href=databaseupgrade-1.25to1.26.php?func=do_upgrade>Click Here</a> to upgrade the database from 1.25 to the 1.26 version of PC Repair Tracker.<br><br>";
stop_box();

require_once("footer.php");
                                                                                                    
}


function do_upgrade() {
require_once("validate.php");
require("deps.php");
require("common.php");

$rs_connect = @mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect the db");
$rs_select_db = @mysql_select_db($dbname, $rs_connect) or die("Couldn't select the db");


$sql1 = "ALTER TABLE users ADD touchwide INT NOT NULL DEFAULT '3'";

$sql2 = "ALTER TABLE invoices ADD preinvoice INT NOT NULL DEFAULT '0'";

$sql3 = "CREATE TABLE stickytypes (
stickytypeid INT NOT NULL AUTO_INCREMENT ,
stickytypename TEXT NOT NULL ,
bordercolor TEXT NOT NULL ,
notecolor TEXT NOT NULL ,
notecolor2 TEXT NOT NULL ,
UNIQUE (
stickytypeid
)
) ENGINE = MYISAM";


$sql4 = "CREATE TABLE stickynotes (
  stickyid int(11) NOT NULL auto_increment,
  stickyaddy1 text NOT NULL,
  stickyaddy2 text NOT NULL,
  stickycity text NOT NULL,
  stickystate text NOT NULL,
  stickyzip text NOT NULL,
  stickyphone text NOT NULL,
  stickyemail text NOT NULL,
  stickyduedate datetime NOT NULL,
  stickytypeid int(11) NOT NULL,
  stickyuser text NOT NULL,
  stickynote text NOT NULL,
  stickyname text NOT NULL,
  refid int(11) NOT NULL default '0',
  reftype text NOT NULL,
  showonwall TINYINT NOT NULL DEFAULT '1',
  UNIQUE KEY stickyid (stickyid)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";



$sql5 = "ALTER TABLE users ADD stickywide TINYINT NOT NULL DEFAULT '3'";

$sql6 = "INSERT INTO stickytypes (stickytypeid, stickytypename, bordercolor, notecolor, notecolor2) VALUES (1, 'Scheduled Service Call', '00a908', 'ffffff', 'b4ff96'),
(2, 'Return a Call', '0f00d0', 'ffffff', '90f3ff'),
(4, 'Order a Part', 'c48f00', 'ffffff', 'fff889'),
(5, 'Scheduled Remote Session', 'fb4700', 'ffffff', 'ffc990'),
(6, 'Quote Request', 'd9000a', 'ffe4e5', 'ffcdcf'),
(7, 'Task', '960094', 'ffd7ff', 'ff9bfe')";



@mysql_query($sql1, $rs_connect);
@mysql_query($sql2, $rs_connect);
@mysql_query($sql3, $rs_connect);
@mysql_query($sql4, $rs_connect);
@mysql_query($sql5, $rs_connect);           
@mysql_query($sql6, $rs_connect);
                 
header("Location: databaseupgrade-1.25to1.26.php?func=do_upgrade2");
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
