<?php
                                                                                                    
/***************************************************************************
 *   copyright            : (C) 2016 PCRepairTracker.com
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


$sqlcheck = "SELECT * FROM registers";
$check = mysqli_query($rs_connect, $sqlcheck);



start_box();

if($check) {
echo "<br><br><a href=databaseupgrade-4to5.php?func=do_upgrade>Click Here</a> to upgrade the database from v4 to v5 of PC Repair Tracker.<br><br>";
} else {
echo "You must perform previous upgrades first. Database tables that should already be there from a previous PCRT version are missing.";
}


stop_box();

require_once("footer.php");
                                                                                                    
}


function do_upgrade() {
require_once("validate.php");
require("deps.php");
require("common.php");



$sql1 = "CREATE TABLE IF NOT EXISTS creds (
  credid int(11) NOT NULL AUTO_INCREMENT,
  creddesc text NOT NULL,
  creduser text NOT NULL,
  credpass text NOT NULL,
  patterndata text NOT NULL,
  groupid int(11) NOT NULL DEFAULT '0',
  pcid int(11) NOT NULL DEFAULT '0',
  credq text NOT NULL,
  creda text NOT NULL,
  credtype int(11) NOT NULL DEFAULT '1',
  creddate datetime NOT NULL,
  PRIMARY KEY (credid)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";

$sql2 = "CREATE TABLE IF NOT EXISTS creddesc (
  creddescid int(11) NOT NULL AUTO_INCREMENT,
  credtitle text NOT NULL,
  creddescorder int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (creddescid)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";



$sql3 = "ALTER TABLE users ADD enabled INT NOT NULL DEFAULT '1'";


$sql4 = "CREATE TABLE IF NOT EXISTS messages (
  messageid int(11) NOT NULL AUTO_INCREMENT,
  messagebody mediumtext COLLATE utf8_unicode_ci NOT NULL,
  messagefrom varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  messageto varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  messagevia mediumtext COLLATE utf8_unicode_ci NOT NULL,
  messageservice mediumtext COLLATE utf8_unicode_ci NOT NULL,
  messagedatetime datetime NOT NULL,
  messageraw mediumtext COLLATE utf8_unicode_ci NOT NULL,
  woid int(11) NOT NULL DEFAULT '0',
  groupid int(11) NOT NULL DEFAULT '0',
  pcid int(11) NOT NULL DEFAULT '0',
  messagedirection varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (messageid),
  KEY woid (woid),
  KEY groupid (groupid),
  KEY pcid (pcid),
  KEY messagedatetime (messagedatetime),
  KEY messagefrom (messagefrom),
  KEY messageto (messageto),
  KEY messagedirection (messagedirection)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1";


$sql5 = "ALTER TABLE pc_group ADD portalpassword MEDIUMTEXT NOT NULL";
$sql6 = "ALTER TABLE pc_group ADD portalpasswordauth MEDIUMTEXT NOT NULL";

$sql7 = "CREATE TABLE IF NOT EXISTS portalloginattempts (
  portalusername text NOT NULL,
  ipaddress text NOT NULL,
  attempttime datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8";


$sql8 = "CREATE TABLE IF NOT EXISTS portaldownloads (
  downloadid int(11) NOT NULL AUTO_INCREMENT,
  downloadfilename text NOT NULL,
  downloadfiletitle text NOT NULL,
  storedas text NOT NULL,
  groupid int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (downloadid)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";


$sql9 = "ALTER TABLE creds ADD INDEX (groupid)";
$sql10 = "ALTER TABLE creds ADD INDEX (pcid)";

$sql14 = "INSERT INTO creddesc (creddescid, credtitle, creddescorder) VALUES
(1, 'Main Login', 50),
(2, 'Router', 0),
(3, 'Login Pattern', 40),
(4, 'Wi-Fi', 30),
(5, 'PIN', 45),
(6, 'Server Login', 5),
(7, 'Switch', 10),
(8, 'Email', 35),
(9, 'Facebook', 15),
(10, 'FTP', 20),
(11, 'Server Share', 25)";


@mysqli_query($rs_connect, $sql1);
@mysqli_query($rs_connect, $sql2);
@mysqli_query($rs_connect, $sql3);
@mysqli_query($rs_connect, $sql4);
@mysqli_query($rs_connect, $sql5);
@mysqli_query($rs_connect, $sql6);
@mysqli_query($rs_connect, $sql7);
@mysqli_query($rs_connect, $sql8);
@mysqli_query($rs_connect, $sql9);
@mysqli_query($rs_connect, $sql10);
@mysqli_query($rs_connect, $sql14);


$rs_check_creds = "SELECT * FROM creds";
$rs_find_creds = @mysqli_query($rs_connect, $rs_check_creds);
$total_creds = mysqli_num_rows($rs_find_creds);

if ($total_creds < 10) {

$rs_wo = "SELECT * FROM pc_wo WHERE thepass != ''";
$rs_find_wo = @mysqli_query($rs_connect, $rs_wo);
while($rs_find_wo_q = mysqli_fetch_object($rs_find_wo)) {
$woid = "$rs_find_wo_q->woid";
$dropdate = "$rs_find_wo_q->dropdate";
$pcid = "$rs_find_wo_q->pcid";
$thepass = "$rs_find_wo_q->thepass";

$set_np = "INSERT INTO creds (creddesc,credpass,pcid,credtype,creddate)
VALUES ('Password','$thepass','$pcid','1','$dropdate')";
@mysqli_query($rs_connect, $set_np);
}

}


$sql20 = "ALTER TABLE deposits ADD INDEX ( invoiceid )";
$sql21 = "ALTER TABLE inventory ADD INDEX ( storeid )";
$sql22 = "ALTER TABLE invoices ADD INDEX ( pcgroupid )";
$sql23 = "ALTER TABLE invoices ADD INDEX ( invstatus )";
$sql24 = "ALTER TABLE invoices ADD INDEX ( rinvoice_id )";
$sql25 = "ALTER TABLE pc_owner ADD INDEX ( scid )";
$sql26 = "ALTER TABLE pc_scan ADD INDEX ( scantype )";
$sql27 = "ALTER TABLE pc_wo ADD INDEX ( slid )";
$sql28 = "ALTER TABLE pc_wo ADD INDEX ( dropdate )";
$sql29 = "ALTER TABLE pc_wo ADD INDEX ( pickupdate )";
$sql30 = "ALTER TABLE timers ADD INDEX ( woid )";
$sql31 = "ALTER TABLE timers ADD INDEX ( pcgroupid )";
$sql32 = "ALTER TABLE timers ADD INDEX ( blockcontractid )";
$sql33 = "ALTER TABLE userlog ADD INDEX ( loggeduser )";
$sql34 = "ALTER TABLE userlog ADD INDEX ( thedatetime )";

@mysqli_query($rs_connect, $sql20);
@mysqli_query($rs_connect, $sql21);
@mysqli_query($rs_connect, $sql22);
@mysqli_query($rs_connect, $sql23);
@mysqli_query($rs_connect, $sql24);
@mysqli_query($rs_connect, $sql25);
@mysqli_query($rs_connect, $sql26);
@mysqli_query($rs_connect, $sql27);
@mysqli_query($rs_connect, $sql28);
@mysqli_query($rs_connect, $sql29);
@mysqli_query($rs_connect, $sql30);
@mysqli_query($rs_connect, $sql31);
@mysqli_query($rs_connect, $sql32);
@mysqli_query($rs_connect, $sql33);
@mysqli_query($rs_connect, $sql34);

$sql35 = "ALTER TABLE users ADD lastmessage INT NOT NULL DEFAULT '0'";
@mysqli_query($rs_connect, $sql35);

$sql36 = "ALTER TABLE boxstyles ADD collapsedstatus INT NOT NULL DEFAULT '0'";
@mysqli_query($rs_connect, $sql36);

header("Location: databaseupgrade-4to5.php?func=do_upgrade2");
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


