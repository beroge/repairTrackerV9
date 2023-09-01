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


$sqlcheck = "SELECT * FROM documents";
$check = mysqli_query($rs_connect, $sqlcheck);

$sqlcheck2 = "SELECT * FROM stocknoninv";
$check2 = mysqli_query($rs_connect, $sqlcheck2);

start_box();

if($check) {

if($check2) {
echo "<span class=\"sizeme2x colormered\">You have already run this script. Running it again will create a new invoice terms entry and reset your existing invoices to the new terms specified below.<br><br></span>";
}

echo "<span class=sizeme2x>Upgrade to PCRT v9 from v8</span><br><br>Due to a new feature that adds configurable invoice terms and optional automatic invoice late fees,  
we need some info to set things on your existing invoices.<br><br>If you decide to apply late fees to your invoices make sure you consider customer reactions to it, make sure you have it in your terms and conditions, and check your local laws. Monthly late fees of 1 to 1.5 percent are typical, but many areas have legal limits set much lower.<br><br>";

echo "<form action=databaseupgrade-8to9.php?func=do_upgrade method=post>";

echo "<table class=standard><tr><th colspan=2>Set Invoice Terms for Existing Invoices</span></th></tr>";
echo "<tr><td><span class=boldme>Invoice Terms Title</span></td><td><input type=text name=invoicetermstitle size=50 value=\"NET $invoiceoverduedays\" class=textbox></td></tr>";
echo "<tr><td><span class=boldme>How many days after an invoice is created is it due?</span><br>(This value was pulled from your existing overdue invoice day count setting.)</td><td><input type=number min=0 max=180 name=invoicetermsdays size=10 value=\"$invoiceoverduedays\" class=textbox></td></tr>";
echo "<tr><td><span class=boldme>Monthly Late Fee</span><br>(If you specify anything other than zero here, your open invoices that are past due will have late fees automatically added.)</td><td><input type=text name=invoicetermslatefee size=10 value=\"0\" class=textbox>%</td></tr>";
echo "<tr><td><span class=boldme>Tax Rate to Apply to Late Fees</span><br>(For most you will want to choose a tax exempt/zero tax rate unless you are required by your taxing authority to add sales/service tax to late invoice fees as well.)</td><td>";

$rs_find_tax = "SELECT * FROM taxes WHERE taxenabled = '1' ORDER BY taxname ASC";
$rs_result_tax = mysqli_query($rs_connect, $rs_find_tax);
$usertaxid = getusertaxid();
echo "<select name=taxid>";
while($rs_result_tq = mysqli_fetch_object($rs_result_tax)) {
$rs_taxname = "$rs_result_tq->taxname";
$rs_taxid = "$rs_result_tq->taxid";
if ($rs_taxid == $usertaxid) {
echo "<option selected value=$rs_taxid>$rs_taxname</option>";
} else {
echo "<option value=$rs_taxid>$rs_taxname</option>";
}
}
echo "</select>";
echo "</td></tr><tr><td colspan=2>";

echo "<button type=submit class=ibutton>Click Here to upgrade the database from v8 to v9 of PC Repair Tracker.</button></td></tr></table></form><br><br>";

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



$sql1 = "CREATE TABLE IF NOT EXISTS stocknoninv (
  niid int(11) NOT NULL AUTO_INCREMENT,
  ni_title mediumtext COLLATE utf8_unicode_ci NOT NULL,
  ni_desc mediumtext COLLATE utf8_unicode_ci NOT NULL,
  ni_price float(11,5) NOT NULL DEFAULT '0.00000',
  ni_pdesc text COLLATE utf8_unicode_ci NOT NULL,
  theorder int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY niid (niid)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1";

$sql2 = "ALTER TABLE employees ADD wage DECIMAL( 11, 2 ) NOT NULL"; 

$sql3 = "CREATE TABLE IF NOT EXISTS absenses (
  abid int(11) NOT NULL AUTO_INCREMENT,
  abdate datetime NOT NULL,
  abreason int(11) NOT NULL DEFAULT '0',
  eid int(11) NOT NULL,
  abnotes text NOT NULL,
  PRIMARY KEY (abid)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";



$sql4 = "CREATE TABLE IF NOT EXISTS gl (
  ledgerid int(11) NOT NULL AUTO_INCREMENT,
  ledgername text NOT NULL,
  ledgeran text NOT NULL,
  linkedstore text NOT NULL,
  method int(11) NOT NULL DEFAULT '1',
  type int(11) NOT NULL DEFAULT '1',
  ledgerenabled int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (ledgerid)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";


$sql5 = "CREATE TABLE IF NOT EXISTS glpayees (
  payeeid int(11) NOT NULL AUTO_INCREMENT,
  payeename text NOT NULL,
  payeecontact text NOT NULL,
  payeeaddy1 text NOT NULL,
  payeeaddy2 text NOT NULL,
  payeecity text NOT NULL,
  payeestate text NOT NULL,
  payeezip text NOT NULL,
  payeeemail text NOT NULL,
  payeeaccountno text NOT NULL,
  payeephone text NOT NULL,
  PRIMARY KEY (payeeid)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10";


$sql6 = "CREATE TABLE IF NOT EXISTS glsaccounts (
  accountid int(11) NOT NULL AUTO_INCREMENT,
  ledgerid int(11) NOT NULL,
  accountname text NOT NULL,
  accounttype varchar(20) NOT NULL,
  linkedtaxid int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (accountid)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=100";


$sql7 = "CREATE TABLE IF NOT EXISTS glstrans (
  transid int(11) NOT NULL AUTO_INCREMENT,
  transnumber varchar(60) NOT NULL,
  transdate datetime NOT NULL,
  transdesc varchar(200) NOT NULL,
  ledgerid int(11) NOT NULL,
  receiptid int(11) NOT NULL,
  invoiceid int(11) NOT NULL,
  baddebttransid int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (transid),
  KEY ledgerid (ledgerid),
  KEY receiptid (receiptid),
  KEY invoiceid (invoiceid),
  KEY transdate (transdate)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000";


$sql8 = "CREATE TABLE IF NOT EXISTS glstransdet (
  transdetid int(11) NOT NULL AUTO_INCREMENT,
  transid int(11) NOT NULL,
  accountid int(11) NOT NULL,
  expense decimal(11,5) NOT NULL,
  income decimal(11,5) NOT NULL,
  transdetdesc varchar(120) NOT NULL,
  payee int(11) NOT NULL,
  PRIMARY KEY (transdetid),
  KEY transid (transid),
  KEY accountid (accountid),
  KEY payee (payee),
  KEY income (income),
  KEY expense (expense)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000";


$sql9 = "ALTER TABLE invoices ADD invoicetermsid int(11) NOT NULL DEFAULT '0'";
$sql10 = "ALTER TABLE invoices ADD latefeeid int(11) NOT NULL DEFAULT '0'";
$sql11 = "ALTER TABLE invoices ADD duedate datetime NOT NULL";


$sql12 = "CREATE TABLE IF NOT EXISTS invoiceterms (
  invoicetermsid int(11) NOT NULL AUTO_INCREMENT,
  invoicetermstitle text NOT NULL,
  invoicetermsdays int(11) NOT NULL,
  invoicetermslatefee decimal(3,2) NOT NULL,
  theorder int(11) NOT NULL DEFAULT '0',
  invoicetermsdefault int(11) NOT NULL DEFAULT '0',
  taxid int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (invoicetermsid)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";

$sql13 = "ALTER TABLE users ADD ledgerid int(11) NOT NULL";

$sql14 = "ALTER TABLE rinvoices ADD invoicetermsid int(11) NOT NULL DEFAULT '0'";


$sqlcheck2 = "SELECT * FROM stocknoninv";
$check2 = mysqli_query($rs_connect, $sqlcheck2);


if($check2) {
$nochanges = 1;
} else {
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
@mysqli_query($rs_connect, $sql11);
@mysqli_query($rs_connect, $sql12);
@mysqli_query($rs_connect, $sql13);
@mysqli_query($rs_connect, $sql14);

}

$invoicetermstitle = pv($_REQUEST['invoicetermstitle']);
$invoicetermsdays = pv($_REQUEST['invoicetermsdays']);
$invoicetermslatefee = pv($_REQUEST['invoicetermslatefee']);
$taxid = pv($_REQUEST['taxid']);

$rs_insert_scan = "INSERT INTO invoiceterms (invoicetermstitle,invoicetermsdays,invoicetermslatefee,invoicetermsdefault,taxid) VALUES ('$invoicetermstitle','$invoicetermsdays','$invoicetermslatefee','1','$taxid')";
@mysqli_query($rs_connect, $rs_insert_scan);
$invoicetermsid = mysqli_insert_id($rs_connect);

$updateexistinginvoices = "UPDATE invoices SET invoicetermsid = '$invoicetermsid', duedate = DATE_ADD(invdate, INTERVAL $invoicetermsdays DAY)";
@mysqli_query($rs_connect, $updateexistinginvoices);

$updateexistingrinvoices = "UPDATE rinvoices SET invoicetermsid = '$invoicetermsid'";
@mysqli_query($rs_connect, $updateexistingrinvoices);

header("Location: databaseupgrade-8to9.php?func=do_upgrade2");
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


