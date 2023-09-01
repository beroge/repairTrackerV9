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

echo "<a href=databaseupgrade-1.23to1.24.php?func=do_upgrade>Click Here</a> to upgrade the database from 1.23 to the 1.24 version of PC Repair Tracker.";

require_once("footer.php");
                                                                                                    
}


function do_upgrade() {
require_once("validate.php");
require("deps.php");
require("common.php");

$rs_connect = @mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect the db");
$rs_select_db = @mysql_select_db($dbname, $rs_connect) or die("Couldn't select the db");


$sql1 = "ALTER TABLE users ADD lastseen DATETIME NOT NULL ,
ADD touchrefresh INT NOT NULL DEFAULT '300'";

$sql2 = "ALTER TABLE pc_owner ADD custsourceid INT NOT NULL DEFAULT '0'";


$sql3 = "CREATE TABLE custsource (
  custsourceid int(11) NOT NULL auto_increment,
  thesource text NOT NULL,
  sourceenabled int(11) NOT NULL default '1',
  sourceicon text NOT NULL,
  showonreport int(11) NOT NULL default '1',
  PRIMARY KEY  (`custsourceid`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1 AUTO_INCREMENT=18";


$sql4 = "INSERT INTO custsource (custsourceid, thesource, sourceenabled, sourceicon, showonreport) VALUES (1, 'Yellow Pages', 1, 'yp.png', 1),
(2, 'Website', 1, 'www.png', 1),
(3, 'Unknown', 1, 'unknown.png', 0),
(4, 'Word of Mouth Refferal', 1, 'wordofmouth.png', 1),
(5, 'Billboard Advertising', 1, 'billboard.png', 1),
(6, 'Email or Mailed Newsletter', 1, 'emailornewsletter.png', 1),
(7, 'Social Network Refferal', 1, 'facebook.png', 1),
(8, 'Flyer', 1, 'flyer.png', 1),
(9, 'Google Adwords', 1, 'googleadwords.png', 1),
(10, 'Business Networking', 1, 'linkedin.png', 1),
(11, 'Phone Book', 1, 'phonebook.png', 1),
(12, 'Existing Customer', 1, 'regularcustomer.png', 0),
(13, 'Sponsorship Advertising', 1, 'sponsor.png', 1),
(14, 'Store Drive By', 1, 'storedriveby.png', 1),
(15, 'Newspaper Advertising ', 1, 'newspaper.png', 1)";



@mysql_query($sql1, $rs_connect);
@mysql_query($sql2, $rs_connect);
@mysql_query($sql3, $rs_connect);
@mysql_query($sql4, $rs_connect);

                            
header("Location: $domain/databaseupgrade-1.23to1.24.php?func=do_upgrade2");
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
