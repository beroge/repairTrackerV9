<?php
                                                                                                    
/***************************************************************************
 *   copyright            : (C) 2020 PCRepairTracker.com
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


$sqlcheck = "SELECT * FROM discounts";
$check = mysqli_query($rs_connect, $sqlcheck);


start_box();

if($check) {
echo "<br><br><a href=databaseupgrade-7to8.php?func=do_upgrade>Click Here</a> to upgrade the database from v7 to v8 of PC Repair Tracker.<br><br>";
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


$sql2 = "CREATE TABLE IF NOT EXISTS docphotos (
  docphotoid int(11) NOT NULL AUTO_INCREMENT,
  docphotofilename varchar(200) NOT NULL,
  docphotoarchived int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (docphotoid)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";


$sql3 = "CREATE TABLE IF NOT EXISTS doctemplates (
  doctemplateid int(11) NOT NULL AUTO_INCREMENT,
  doctemplatename text NOT NULL,
  doctemplatecreated datetime NOT NULL,
  doctemplate text NOT NULL,
  PRIMARY KEY (doctemplateid)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";


$sql4 = "CREATE TABLE IF NOT EXISTS documents (
  documentid int(11) NOT NULL AUTO_INCREMENT,
  documentname text NOT NULL,
  documenttemplate text NOT NULL,
  groupid int(11) NOT NULL DEFAULT '0',
  pcid int(11) NOT NULL DEFAULT '0',
  scid int(11) NOT NULL DEFAULT '0',
  thesig text NOT NULL,
  thesigtopaz text NOT NULL,
  showinportal int(11) NOT NULL DEFAULT '0',
  signeddatetime datetime NOT NULL,
  PRIMARY KEY (documentid)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";


$sql6 = "ALTER TABLE users ADD twofactor int(11) NOT NULL DEFAULT '0'";
$sql7 = "ALTER TABLE users ADD twofactorpassword mediumtext COLLATE utf8_unicode_ci NOT NULL";


@mysqli_query($rs_connect, $sql1);
@mysqli_query($rs_connect, $sql2);
@mysqli_query($rs_connect, $sql3);
@mysqli_query($rs_connect, $sql4);
@mysqli_query($rs_connect, $sql6);
@mysqli_query($rs_connect, $sql7);

header("Location: databaseupgrade-7to8.php?func=do_upgrade2");
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


