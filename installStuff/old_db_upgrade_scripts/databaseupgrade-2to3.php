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



start_box();


echo "<br><br><a href=databaseupgrade-2to3.php?func=do_upgrade>Click Here</a> to upgrade the database from v2 to v3 of PC Repair Tracker.<br><br>";



stop_box();

require_once("footer.php");
                                                                                                    
}


function do_upgrade() {
require_once("validate.php");
require("deps.php");
require("common.php");


$sql2 = "ALTER TABLE deposits ADD invoiceid INT NOT NULL DEFAULT '0'";
$sql3 = "ALTER TABLE invoices ADD pcgroupid INT NOT NULL DEFAULT '0'";

$sql4 = "ALTER TABLE servicereminders ADD recurringinterval TEXT NOT NULL";

$sql5 = "CREATE TABLE IF NOT EXISTS rwo (
  rwoid int(11) NOT NULL AUTO_INCREMENT,
  pcid int(11) NOT NULL,
  rwodate date NOT NULL,
  rwointerval text NOT NULL,
  rwotask text NOT NULL,
  rwostatus int(11) NOT NULL DEFAULT '1',
  tasksummary text NOT NULL,
  rwostoreid int(11) NOT NULL,
  PRIMARY KEY (rwoid),
  UNIQUE KEY rwoid (rwoid),
  KEY pcid (pcid)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1";


$sql6 = "CREATE TABLE IF NOT EXISTS swatches (
  swatchid int(11) NOT NULL AUTO_INCREMENT,
  sw1 text NOT NULL,
  sw2 text NOT NULL,
  sw3 text NOT NULL,
  sw4 text NOT NULL,
  PRIMARY KEY (swatchid)
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=55";

$sql7 = "INSERT INTO swatches (swatchid, sw1, sw2, sw3, sw4) VALUES
(47, 'cccccc', 'cccccc', '333333', 'ffffff'),
(5, 'FF0000', '6B0000', '28343b', 'ffffff'),
(6, '898989', '3D3D3D', '6D604D', 'c8bc8d'),
(7, 'e1a8ff', '51007b', 'ff39ce', 'ffc3fe'),
(8, '008aff', '003e72', '6D604D', 'c8bc8d'),
(9, 'ffde6c', 'ff9c00', '003e72', '008aff'),
(10, 'e5ff97', '6f9300', '000000', '727272'),
(11, 'ff97e0', 'ab0279', 'bcad5c', 'fff6c3'),
(12, 'e8e4d0', 'a6a081', '473f13', 'a69f7a'),
(25, '9f42d7', '5f3980', 'a689a9', 'e7d9ea'),
(14, '325FFF', '325FFF', '222222', '222222'),
(36, 'ff8132', 'ea5800', '222222', 'ffffff'),
(24, '222222', '222222', '999999', 'ffffff'),
(39, '48f2bf', '0ec991', 'b7713e', 'e6cab5'),
(22, '0050ef', '0050ef', '8f8f8f', 'ffffff'),
(29, 'DE4D4E', 'DA4624', '5E412F', 'FCEBB6'),
(26, '57f40b', '0e6a09', '6d604d', 'c8bc8d'),
(30, '59323C', '260126', 'BFAF80', 'F2EEB3'),
(28, 'ffff00', 'ffe428', '676767', 'ffffff'),
(31, 'F69B9A', 'EF4666', '84AF9C', 'C6C7AA'),
(37, 'ff8132', 'ea5800', '886a33', 'ffffff'),
(34, 'd88950', 'b76528', '219db8', 'd3f1f8'),
(38, 'd3ff04', 'a4c400', '8f8f8f', 'ffffff'),
(40, 'd88950', 'cd6132', '8895ac', 'dae6e7'),
(41, 'd3ff04', 'a4c400', '5b66c4', 'ffffff'),
(42, 'e4e4e4', 'b1b1b1', '8ca65e', 'dde8bb'),
(43, 'e1e68a', '809834', 'bc5076', 'e9daab'),
(45, 'ffff66', 'ffcc00', '000000', '6c6c6c'),
(48, 'ff0000', 'ff0000', '3535ac', 'fcebb6'),
(49, 'b39862', '67502c', '687b44', 'dde8bb'),
(50, 'cb97df', 'b01ac6', '1d6265', '58a795'),
(51, '77c1ff', '0127de', 'ffffff', '808080'),
(52, 'f38854', 'd04e0f', 'ffffff', 'bd8c42'),
(53, 'f4f0e1', 'e8dabf', 'ffffff', '015781'),
(54, 'f4f4f4', 'bcbcbc', 'ffffff', '515151')";

$sql8 = "ALTER TABLE deposits ADD parentdeposit INT NOT NULL DEFAULT '0'";

$sql9 = "ALTER TABLE stores ADD lastbackup DATETIME NOT NULL";


@mysqli_query($rs_connect, $sql2);
@mysqli_query($rs_connect, $sql3);
@mysqli_query($rs_connect, $sql4);
@mysqli_query($rs_connect, $sql5);
@mysqli_query($rs_connect, $sql6);
@mysqli_query($rs_connect, $sql7);
@mysqli_query($rs_connect, $sql8);
@mysqli_query($rs_connect, $sql9);

header("Location: databaseupgrade-2to3.php?func=do_upgrade2");
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


