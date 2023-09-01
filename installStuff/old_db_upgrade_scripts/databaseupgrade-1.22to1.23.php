<?php
                                                                                                    
/***************************************************************************
 *   copyright            : (C) 2010 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/
$func = $_REQUEST[func];
                                                                                                    
function nothing() {
require_once("header.php");

echo "<a href=databaseupgrade-1.22to1.23.php?func=do_upgrade>Click Here</a> to upgrade the database from 1.22 to the 1.23 version of PC Repair Tracker.";

require_once("footer.php");
                                                                                                    
}


function do_upgrade() {
require_once("validate.php");
require("deps.php");
require("common.php");

$rs_connect = @mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect the db");
$rs_select_db = @mysql_select_db($dbname, $rs_connect) or die("Couldn't select the db");


$sql1 = "ALTER TABLE users ADD theperms TEXT NOT NULL";
$sql2 = "ALTER TABLE pc_scan ADD byuser TEXT NOT NULL";
$sql3 = "ALTER TABLE pc_wo ADD cibyuser TEXT NOT NULL ,
ADD notesbyuser TEXT NOT NULL ,
ADD cobyuser TEXT NOT NULL
";
$sql4 = "ALTER TABLE invoices ADD byuser TEXT NOT NULL";
$sql5 = "ALTER TABLE shoplist ADD byuser TEXT NOT NULL";
$sql6 = "ALTER TABLE receipts ADD byuser TEXT NOT NULL";

$sql7 = "CREATE TABLE userlog (
  userlogid int(11) NOT NULL auto_increment,
  actionid int(11) NOT NULL,
  thedatetime datetime NOT NULL,
  refid int(11) NOT NULL,
  reftype varchar(15) NOT NULL,
  loggeduser varchar(30) NOT NULL,
  UNIQUE KEY userlogid (userlogid)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 AUTO_INCREMENT=1
";


@mysql_query($sql1, $rs_connect);
@mysql_query($sql2, $rs_connect);
@mysql_query($sql3, $rs_connect);
@mysql_query($sql4, $rs_connect);
@mysql_query($sql5, $rs_connect);
@mysql_query($sql6, $rs_connect);
@mysql_query($sql7, $rs_connect);


                            
header("Location: $domain/databaseupgrade-1.22to1.23.php?func=do_upgrade2");
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
