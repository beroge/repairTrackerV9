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
echo "<br><br><a href=databaseupgrade-1.32to1.33.php?func=do_upgrade>Click Here</a> to upgrade the database from 1.32 to the 1.33 version of PC Repair Tracker.<br><br>";
stop_box();

require_once("footer.php");
                                                                                                    
}


function do_upgrade() {
require_once("validate.php");
require("deps.php");
require("common.php");

$rs_connect = @mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect the db");
$rs_select_db = @mysql_select_db($dbname, $rs_connect) or die("Couldn't select the db");




$sql1 = "ALTER TABLE cart ADD ourprice DECIMAL( 11, 2 ) NOT NULL DEFAULT '0.00'";
$sql2 = "ALTER TABLE invoice_items ADD ourprice DECIMAL( 11, 2 ) NOT NULL DEFAULT '0.00'";
$sql3 = "ALTER TABLE repaircart ADD ourprice DECIMAL( 11, 2 ) NOT NULL DEFAULT '0.00'";
$sql4 = "ALTER TABLE savedcarts ADD ourprice DECIMAL( 11, 2 ) NOT NULL DEFAULT '0.00'";
$sql5 = "ALTER TABLE sold_items ADD ourprice DECIMAL( 11, 2 ) NOT NULL DEFAULT '0.00'";


$sql7 = "ALTER TABLE invoices ADD iorq TEXT NOT NULL";

$sql8 = "ALTER TABLE pc_wo ADD readydate DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER pickupdate";
$sql9 = "UPDATE pc_wo SET readydate = pickupdate";

$sql10 = "ALTER TABLE pc_wo ADD thesig TEXT NOT NULL";


$sql11 = "ALTER TABLE quicklabor ADD theorder INT NOT NULL DEFAULT '0'";

$sql12 = "ALTER TABLE commonproblems ADD custviewable INT NOT NULL DEFAULT '0'";

$sql13 = "ALTER TABLE pc_group ADD grpnotes TEXT NOT NULL";

$sql14 = "ALTER TABLE pc_wo ADD assigneduser TEXT NOT NULL";

$sql15 = "ALTER TABLE users ADD statusview INT NOT NULL DEFAULT '0'";

$sql16 = "ALTER TABLE stores ADD quotefooter TEXT NOT NULL ,
ADD invoicefooter TEXT NOT NULL ,
ADD repairsheetfooter TEXT NOT NULL ,
ADD returnpolicy TEXT NOT NULL ,
ADD depositfooter TEXT NOT NULL ,
ADD thankyouletter TEXT NOT NULL ,
ADD claimticket TEXT NOT NULL";

$sql16_2 = "UPDATE stores SET thankyouletter = '<font class=text12b>Thank-You for choosing My Company for your recent service work.</font>\r\n\r\n<font class=text12>We want you to be satisfied with the level of service we have provided you. If you have any further issues or questions, do not hesitate to contact us. We want you to be 100% satisfied with our work.\r\n\r\nWe also welcome feedback and reviews on our Google Places page located here: <a href=http://g.co/maps/>My Google Places Page</a>. If you have any immediate issues though, be sure to contact us directly, we are ready and eager to solve any issue.\r\n\r\nThanks Again for choosing us, and please remember us for any future needs.\r\n\r\nSincerely,\r\nThe Staff of My Company</font>'";


$sql17 = "CREATE TABLE frameit (
frameitid INT NOT NULL AUTO_INCREMENT ,
frameitname TEXT NOT NULL ,
frameiturl TEXT NOT NULL ,
UNIQUE (
frameitid
)
) ENGINE = MYISAM";


$sql17_2 = "INSERT INTO frameit (frameitid, frameitname, frameiturl) VALUES (6, 'Ninite', 'http://www.ninite.com'),
(12, 'Blacklist Check', 'http://www.mxtoolbox.com/blacklists.aspx'),
(11, 'Acer Support', 'http://support.acer.com/us/en/default.aspx'),
(7, 'Speedtest', 'http://www.speedtest.net'),
(8, 'Dell Warranty', 'http://support.dell.com/support/topics/global.aspx/support/my_systems_info/details'),
(9, 'HP Warranty', 'http://h10025.www1.hp.com/ewfrf/wc/weInput?cc=us&lc=en'),
(10, 'Toshiba Warranty', 'http://www.warranty.toshiba.com')";


$sql18 = "ALTER TABLE pc_owner ADD pcnotes TEXT NOT NULL";


$sql19 = "ALTER TABLE stores ADD linecolor1 VARCHAR( 6 ) NOT NULL DEFAULT '65FF00',
ADD linecolor2 VARCHAR( 6 ) NOT NULL DEFAULT '439600',
ADD bgcolor1 VARCHAR( 6 ) NOT NULL DEFAULT 'b5bdc8',
ADD bgcolor2 VARCHAR( 6 ) NOT NULL DEFAULT '28343b'";

@mysql_query($sql1, $rs_connect);
@mysql_query($sql2, $rs_connect);
@mysql_query($sql3, $rs_connect);
@mysql_query($sql4, $rs_connect);
@mysql_query($sql5, $rs_connect);
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
@mysql_query($sql16_2, $rs_connect);
@mysql_query($sql17, $rs_connect);
@mysql_query($sql17_2, $rs_connect);
@mysql_query($sql18, $rs_connect);
@mysql_query($sql19, $rs_connect);


header("Location: databaseupgrade-1.32to1.33.php?func=do_upgrade2");
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
