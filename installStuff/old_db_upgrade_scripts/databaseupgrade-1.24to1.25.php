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

echo "<a href=databaseupgrade-1.24to1.25.php?func=do_upgrade>Click Here</a> to upgrade the database from 1.24 to the 1.25 version of PC Repair Tracker.";

require_once("footer.php");
                                                                                                    
}


function do_upgrade() {
require_once("validate.php");
require("deps.php");
require("common.php");

$rs_connect = @mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect the db");
$rs_select_db = @mysql_select_db($dbname, $rs_connect) or die("Couldn't select the db");


$sql1 = "ALTER TABLE users ADD gomodal INT NOT NULL DEFAULT '0'";

$sql2 = "CREATE TABLE commonproblems (
probid INT NOT NULL AUTO_INCREMENT ,
theproblem TEXT NOT NULL ,
UNIQUE (
probid
)
) ENGINE = MYISAM";


$sql4 = "INSERT INTO commonproblems (probid, theproblem) VALUES (1, 'Virus/Rogue Cleaning'),
(3, 'Tuneup'),
(4, 'Backup Important Data First'),
(5, 'Reload Operating System'),
(6, 'Install New AntiVirus'),
(7, 'Internal Physical Cleaning'),
(8, 'Replace Bad Capacitors'),
(9, 'Computer does not Boot'),
(10, 'Computer does not power on'),
(11, 'Replace Bad LCD Screen'),
(15, 'Internet does not Work'),
(13, 'Computer has noisy fan'),
(16, 'Blue Screening'),
(17, 'Upgrade Memory')";




$sql3 = "ALTER TABLE pc_wo ADD commonproblems TEXT NOT NULL";



@mysql_query($sql1, $rs_connect);
@mysql_query($sql2, $rs_connect);
@mysql_query($sql3, $rs_connect);
@mysql_query($sql4, $rs_connect);
                            
header("Location: $domain/databaseupgrade-1.24to1.25.php?func=do_upgrade2");
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
