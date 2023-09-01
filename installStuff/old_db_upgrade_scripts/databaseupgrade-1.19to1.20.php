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

echo "<a href=databaseupgrade-1.19to1.20.php?func=do_upgrade>Click Here</a> to upgrade the database from 1.19 to the 1.20 version of PC Repair Tracker.";

require_once("footer.php");
                                                                                                    
}


function do_upgrade() {
require_once("validate.php");
require("deps.php");
require("common.php");

$rs_connect = @mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect the db");
$rs_select_db = @mysql_select_db($dbname, $rs_connect) or die("Couldn't select the db");


$sql1 = "CREATE TABLE assetphotos (
assetphotoid INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
pcid INT NOT NULL ,
photofilename TEXT NOT NULL ,
highlight int(11) NOT NULL default '0'
) ENGINE = MYISAM";


$sql2 = "ALTER TABLE pc_owner ADD pcgroupid INT NOT NULL DEFAULT '0'";
$sql3 = "ALTER TABLE users ADD scanrecordview INT NOT NULL DEFAULT '0'";
$sql4 = "CREATE TABLE pc_group (
pcgroupid INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
pcgroupname TEXT NOT NULL
) ENGINE = MYISAM";


@mysql_query($sql1, $rs_connect);
@mysql_query($sql2, $rs_connect);
@mysql_query($sql3, $rs_connect);
@mysql_query($sql4, $rs_connect);
                            
header("Location: $domain/databaseupgrade-1.19to1.20.php?func=do_upgrade2");
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
