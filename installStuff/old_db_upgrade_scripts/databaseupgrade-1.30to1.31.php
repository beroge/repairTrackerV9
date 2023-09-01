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
echo "<br><br><a href=databaseupgrade-1.30to1.31.php?func=do_upgrade>Click Here</a> to upgrade the database from 1.30 to the 1.31 version of PC Repair Tracker.<br><br>";
stop_box();

require_once("footer.php");
                                                                                                    
}


function do_upgrade() {
require_once("validate.php");
require("deps.php");
require("common.php");

$rs_connect = @mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect the db");
$rs_select_db = @mysql_select_db($dbname, $rs_connect) or die("Couldn't select the db");




$sql1 = "ALTER TABLE pc_group ADD grpphone TEXT NOT NULL,
ADD grpcellphone TEXT NOT NULL,
ADD grpworkphone TEXT NOT NULL,
ADD grpemail TEXT NOT NULL,
ADD grpaddress1 TEXT NOT NULL,
ADD grpaddress2 TEXT NOT NULL,
ADD grpcity TEXT NOT NULL,
ADD grpstate TEXT NOT NULL,
ADD grpzip TEXT NOT NULL,
ADD grpprefcontact TEXT NOT NULL,
ADD grpcustsourceid INT NOT NULL";


$sql2 = "ALTER TABLE userlog ADD mensaje TEXT NOT NULL";

$sql3 = "ALTER TABLE cart ADD origprice DECIMAL(11,2) NOT NULL, 
ADD discounttype TEXT NOT NULL";

$sql4 = "ALTER TABLE invoice_items ADD origprice DECIMAL(11,2) NOT NULL,
ADD discounttype TEXT NOT NULL";

$sql5 = "ALTER TABLE repaircart ADD origprice DECIMAL(11,2) NOT NULL,
ADD discounttype TEXT NOT NULL";

$sql6 = "ALTER TABLE savedcarts ADD origprice DECIMAL(11,2) NOT NULL,
ADD discounttype TEXT NOT NULL";

$sql7 = "ALTER TABLE sold_items ADD origprice DECIMAL(11,2) NOT NULL,
ADD discounttype TEXT NOT NULL";

$sql8 = "ALTER TABLE sold_items ADD price_alt INT NOT NULL DEFAULT '0'";

$sql9 = "ALTER TABLE users ADD floatbar INT NOT NULL DEFAULT '1'";

@mysql_query($sql1, $rs_connect);
@mysql_query($sql2, $rs_connect);
@mysql_query($sql3, $rs_connect);
@mysql_query($sql4, $rs_connect);
@mysql_query($sql5, $rs_connect);
@mysql_query($sql6, $rs_connect);
@mysql_query($sql7, $rs_connect);
@mysql_query($sql8, $rs_connect);
@mysql_query($sql9, $rs_connect);

                 
header("Location: databaseupgrade-1.30to1.31.php?func=do_upgrade2");
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
