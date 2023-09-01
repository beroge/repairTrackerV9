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
$sqlcheck = "SELECT * FROM travellog";
$check = mysql_query($sqlcheck, $rs_connect);



start_box();


if($check) {
echo "<br><br><a href=databaseupgrade-1.39to1.40.php?func=do_upgrade>Click Here</a> to upgrade the database from 1.39 to the 1.40 version of PC Repair Tracker.<br><br>";
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




$sql1 = "ALTER TABLE deposits ADD thesigtopaz text COLLATE utf8_unicode_ci NOT NULL,
  ADD showsigdeptopaz int(11) NOT NULL DEFAULT '1'";

$sql2 = "ALTER TABLE invoices ADD thesigtopaz text COLLATE utf8_unicode_ci NOT NULL,
  ADD showsiginvtopaz int(11) NOT NULL DEFAULT '1'";

$sql3 = "ALTER TABLE pc_wo ADD thesigtopaz text COLLATE utf8_unicode_ci NOT NULL,
  ADD showsigcttopaz int(11) NOT NULL DEFAULT '1',
  ADD showsigrrtopaz int(11) NOT NULL DEFAULT '1',
  ADD showsigcrtopaz int(11) NOT NULL DEFAULT '1',
  ADD thesigwotopaz text COLLATE utf8_unicode_ci NOT NULL,
  ADD thesigcrtopaz text COLLATE utf8_unicode_ci NOT NULL";

$sql4 = "ALTER TABLE receipts ADD thesigtopaz text COLLATE utf8_unicode_ci NOT NULL,
  ADD showsigrectopaz int(11) NOT NULL DEFAULT '1'";



@mysql_query($sql1, $rs_connect);
@mysql_query($sql2, $rs_connect);
@mysql_query($sql3, $rs_connect);
@mysql_query($sql4, $rs_connect);

header("Location: databaseupgrade-1.39to1.40.php?func=do_upgrade2");
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
