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
echo "<br><br><a href=databaseupgrade-1.31to1.32.php?func=do_upgrade>Click Here</a> to upgrade the database from 1.31 to the 1.32 version of PC Repair Tracker.<br><br>";
stop_box();

require_once("footer.php");
                                                                                                    
}


function do_upgrade() {
require_once("validate.php");
require("deps.php");
require("common.php");

$rs_connect = @mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect the db");
$rs_select_db = @mysql_select_db($dbname, $rs_connect) or die("Couldn't select the db");


$sql1 = "ALTER TABLE invoices ADD invnotes TEXT NOT NULL";
$sql1_1 = "ALTER TABLE invoices ADD storeid INT NOT NULL";

$sql2 = "ALTER TABLE deposits ADD applieddate DATETIME NOT NULL";
$sql2_2 = "ALTER TABLE deposits ADD appliedstoreid INT NOT NULL";

$sql3 = "CREATE TABLE stores (
  storeid int(11) NOT NULL auto_increment,
  storesname text NOT NULL,
  storename text NOT NULL,
  storeaddy1 text NOT NULL,
  storeaddy2 text NOT NULL,
  storecity text NOT NULL,
  storestate text NOT NULL,
  storezip text NOT NULL,
  storeemail text NOT NULL,
  storephone text NOT NULL,
  storedefault int(11) NOT NULL default '0',
  storeenabled int(11) NOT NULL default '1',
  UNIQUE KEY storeid (storeid)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1";


$sql4 = "ALTER TABLE users ADD defaultstore INT NOT NULL DEFAULT '0'";

$sql5 = "ALTER TABLE pc_wo ADD storeid INT NOT NULL";
$sql6 = "ALTER TABLE receipts ADD storeid INT NOT NULL";
$sql7 = "ALTER TABLE savedpayments ADD storeid INT NOT NULL";
$sql8 = "ALTER TABLE deposits ADD storeid INT NOT NULL";
$sql9 = "ALTER TABLE stickynotes ADD storeid INT NOT NULL";


$sql11 = "CREATE TABLE stockcounts (
  stockcountid int(11) NOT NULL auto_increment,
  stockid int(11) NOT NULL,
  storeid int(11) NOT NULL,
  quantity int(11) NOT NULL default '0',
  PRIMARY KEY  (stockcountid)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";


$sql12 = "ALTER TABLE inventory ADD storeid INT NOT NULL";

@mysql_query($sql1, $rs_connect);
@mysql_query($sql1_1, $rs_connect);
@mysql_query($sql2, $rs_connect);
@mysql_query($sql2_2, $rs_connect);
@mysql_query($sql3, $rs_connect);
@mysql_query($sql4, $rs_connect);
@mysql_query($sql5, $rs_connect);
@mysql_query($sql6, $rs_connect);
@mysql_query($sql7, $rs_connect);
@mysql_query($sql8, $rs_connect);
@mysql_query($sql9, $rs_connect);
@mysql_query($sql11, $rs_connect);
@mysql_query($sql12, $rs_connect);

$sqlchk2 = "SELECT * FROM stores";
$sqlchk2b = mysql_query($sqlchk2, $rs_connect);
$sqlchk2c = mysql_num_rows($sqlchk2b);

if ($sqlchk2c == '0') {
$sql13 = "INSERT INTO stores (storesname,storename,storeaddy1,storeaddy2,storecity,storestate,storezip,storeemail,storephone,storedefault,storeenabled) VALUES ('store 1','$businessname','Address1','Address2','Store City','Store State','Store Zip','$businessemail','$phone','1','1')";
@mysql_query($sql13, $rs_connect);
$lastinsert = mysql_insert_id();

$sql14 = "UPDATE users SET defaultstore = '$lastinsert'";
$sql15 = "UPDATE pc_wo SET storeid = '$lastinsert'";
$sql16 = "UPDATE receipts SET storeid = '$lastinsert'";
$sql17 = "UPDATE savedpayments SET storeid = '$lastinsert'";
$sql18 = "UPDATE deposits SET storeid = '$lastinsert'";
$sql19 = "UPDATE stickynotes SET storeid = '$lastinsert'";
$sql20 = "UPDATE inventory SET storeid = '$lastinsert'";
$sql20_1 = "UPDATE invoices SET storeid = '$lastinsert'";


@mysql_query($sql14, $rs_connect);
@mysql_query($sql15, $rs_connect);
@mysql_query($sql16, $rs_connect);
@mysql_query($sql17, $rs_connect);
@mysql_query($sql18, $rs_connect);
@mysql_query($sql19, $rs_connect);
@mysql_query($sql20, $rs_connect);                 
@mysql_query($sql20_1, $rs_connect);

$sqlchk1 = "SELECT * FROM stockcounts";
$sqlchk1b = mysql_query($sqlchk1, $rs_connect);
$sqlchk1c = mysql_num_rows($sqlchk1b);

if ($sqlchk1c == '0') {
$sql21 = "SELECT * FROM stock";
$sql21_result = mysql_query($sql21, $rs_connect);
while($sql21_resultq = mysql_fetch_object($sql21_result)) {
$stockid = "$sql21_resultq->stock_id";
$stockqty = "$sql21_resultq->stock_quantity";
$insertq = "INSERT INTO stockcounts (stockid,storeid,quantity) VALUES ('$stockid','$lastinsert','$stockqty')";
@mysql_query($insertq, $rs_connect);
}
}
}

$sql25 = "CREATE TABLE benches (
  benchid int(11) NOT NULL auto_increment,
  benchname text NOT NULL,
  benchcolor text NOT NULL,
  storeid int(11) NOT NULL,
  UNIQUE KEY benchid (benchid)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 AUTO_INCREMENT=5";

$sql26 = "INSERT INTO benches (benchid, benchname, benchcolor, storeid) VALUES (1, 'North Bench', 'f6f6f6', '$lastinsert'),
(2, 'South Bench', 'd4d4ff', '$lastinsert'),
(3, 'Laptop Bench', 'fff4c6', '$lastinsert'),
(4, 'East Bench', 'b0ffa5', '$lastinsert')";

@mysql_query($sql25, $rs_connect);
@mysql_query($sql26, $rs_connect);


header("Location: databaseupgrade-1.31to1.32.php?func=do_upgrade2");
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
