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



start_box();


echo "<br><br><a href=databaseupgrade-1.40to2.php?func=do_upgrade>Click Here</a> to upgrade the database from 1.40 to version 2 of PC Repair Tracker.<br><br>";



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


$sql1 = "ALTER TABLE boxstyles
  DROP headerstyle,
  DROP bodystyle,
  DROP floaterstyle";



$sql2 = "ALTER TABLE boxstyles ADD displayedstatus INT NOT NULL DEFAULT '1'";

$sql3 = "ALTER TABLE boxstyles ADD selectablestatus INT NOT NULL DEFAULT '1'";

$sql4 = "ALTER TABLE boxstyles ADD displayedorder INT NOT NULL DEFAULT '1000'";

$sql5 = "ALTER TABLE boxstyles ADD statusoptions TEXT COLLATE utf8_unicode_ci NOT NULL";

$sql6 = "UPDATE boxstyles SET displayedstatus = '0' WHERE statusid = '5'";
$sql7 = "UPDATE boxstyles SET displayedstatus = '0' WHERE statusid = '7'";
$sql8 = "UPDATE boxstyles SET displayedstatus = '0', selectablestatus = '0' WHERE statusid = '50'";
$sql9 = "UPDATE boxstyles SET displayedstatus = '0', selectablestatus = '0' WHERE statusid = '51'";
$sql10 = "UPDATE boxstyles SET displayedstatus = '0', selectablestatus = '0' WHERE statusid = '52'";
$sql11 = "UPDATE boxstyles SET displayedstatus = '0', selectablestatus = '0' WHERE statusid = '53'";
$sql12 = "UPDATE boxstyles SET displayedstatus = '0', selectablestatus = '0' WHERE statusid = '50'";

$sqlfix1 = "UPDATE boxstyles SET boxtitle = 'Standard Inventory Title Boxes' WHERE statusid = '51'";
@mysql_query($sqlfix1, $rs_connect);

$sqlfix2 = "DELETE FROM boxstyles WHERE statusid = '0'";
@mysql_query($sqlfix2, $rs_connect);


$sql13 = "ALTER TABLE mainassettypes ADD showscans INT NOT NULL DEFAULT '1'";

$sql14 = "ALTER TABLE mainassettypes ADD mspdevice INT NOT NULL DEFAULT '1'";

$sql15 = "CREATE TABLE IF NOT EXISTS servicecontracts (
  scid int(11) NOT NULL AUTO_INCREMENT,
  scstartdate date NOT NULL,
  scexpdate date NOT NULL,
  scname text NOT NULL,
  sccontactperson text NOT NULL,
  scdesc text NOT NULL,
  scperusercharge decimal(11,5) NOT NULL,
  scusers text NOT NULL,
  scactive int(11) NOT NULL DEFAULT '1',
  groupid int(11) NOT NULL DEFAULT '0',
  rinvoice int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (scid)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000";


$sql16 = "ALTER TABLE pc_owner ADD scid INT NOT NULL DEFAULT '0'";

$sql17 = "ALTER TABLE pc_owner ADD scpriceid INT NOT NULL DEFAULT '0'";


$sql20 = "ALTER TABLE attachments ADD scid INT NOT NULL DEFAULT '0' AFTER groupid";

$sql21 = "CREATE TABLE IF NOT EXISTS scprices (
  scpriceid int(11) NOT NULL AUTO_INCREMENT,
  labordesc mediumtext COLLATE utf8_unicode_ci NOT NULL,
  laborprice decimal(11,2) NOT NULL DEFAULT '0.00',
  theorder int(11) NOT NULL DEFAULT '0',
  mainassettypeid int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (scpriceid)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1";



$sql22 = "CREATE TABLE IF NOT EXISTS savedcards (
  savedcardid int(11) NOT NULL AUTO_INCREMENT,
  savedcardfour text NOT NULL,
  savedcardexpmonth text NOT NULL,
  savedcardexpyear text NOT NULL,
  savedcardname text NOT NULL,
  sccid int(11) NOT NULL,
  savedcardbrand text NOT NULL,
  savedcardprocid text NOT NULL,
  savedcarddefault int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (savedcardid),
  UNIQUE KEY savedcardid (savedcardid)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2";


$sql23 = "CREATE TABLE IF NOT EXISTS savedcardscustomers (
  sccid int(11) NOT NULL AUTO_INCREMENT,
  sccprocid text NOT NULL,
  sccplugin text NOT NULL,
  groupid int(11) NOT NULL,
  PRIMARY KEY (sccid),
  UNIQUE KEY sccid (sccid)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2";


$sql24 = "UPDATE stores SET bgcolor1 = '333333', bgcolor2 = 'ffffff'";





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
@mysql_query($sql20, $rs_connect);
@mysql_query($sql21, $rs_connect);
@mysql_query($sql22, $rs_connect);
@mysql_query($sql23, $rs_connect);
@mysql_query($sql24, $rs_connect);

header("Location: databaseupgrade-1.40to2.php?func=do_upgrade2");
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
