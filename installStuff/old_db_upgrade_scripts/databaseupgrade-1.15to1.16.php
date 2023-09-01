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

echo "<a href=databaseupgrade-1.15to1.16.php?func=do_upgrade>Click Here</a> to upgrade the database from 1.15 to the 1.16 version of PC Repair Tracker.";

require_once("footer.php");
                                                                                                    
}


function do_upgrade() {
require_once("validate.php");
require("deps.php");
require("common.php");

$rs_connect = @mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect the db");
$rs_select_db = @mysql_select_db($dbname, $rs_connect) or die("Couldn't select the db");


$sql1 = "ALTER TABLE `pc_owner` ADD `pcaddress2` TEXT NOT NULL ,
ADD `pcstate` TEXT NOT NULL ,
ADD `pccity` TEXT NOT NULL ,
ADD `pczip` TEXT NOT NULL ,
ADD `pccellphone` TEXT NOT NULL ,
ADD `pcworkphone` TEXT NOT NULL ,
ADD `pcextra` TEXT NOT NULL";




$sql2 = "ALTER TABLE `invoices` ADD `invcity` TEXT NOT NULL ,
ADD `invstate` TEXT NOT NULL ,
ADD `invzip` TEXT NOT NULL";



@mysql_query($sql1, $rs_connect);
@mysql_query($sql2, $rs_connect);


                            
header("Location: $domain/databaseupgrade-1.15to1.16.php?func=do_upgrade2");
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
