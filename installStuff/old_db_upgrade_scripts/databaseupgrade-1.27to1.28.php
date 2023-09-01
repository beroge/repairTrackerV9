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
echo "<br><br><a href=databaseupgrade-1.27to1.28.php?func=do_upgrade>Click Here</a> to upgrade the database from 1.27 to the 1.28 version of PC Repair Tracker.<br><br>";
stop_box();

require_once("footer.php");
                                                                                                    
}


function do_upgrade() {
require_once("validate.php");
require("deps.php");
require("common.php");

$rs_connect = @mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect the db");
$rs_select_db = @mysql_select_db($dbname, $rs_connect) or die("Couldn't select the db");




$sql1 = "ALTER TABLE receipts ADD city TEXT NOT NULL ,
ADD state TEXT NOT NULL ,
ADD zip TEXT NOT NULL ,
ADD email TEXT NOT NULL ,
ADD invoice_id TEXT NOT NULL ,
ADD woid TEXT NOT NULL";

$sql2 = "CREATE TABLE currentcustomer (
  cfirstname text NOT NULL,
  caddress text NOT NULL,
  caddress2 text NOT NULL,
  ccity text NOT NULL,
  cstate text NOT NULL,
  czip text NOT NULL,
  cphone text NOT NULL,
  cemail text NOT NULL,
  byuser text NOT NULL,
  woid int(11) NOT NULL,
  invoiceid int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1";

$sql3 = "CREATE TABLE currentpayments (
  paymentid int(11) NOT NULL auto_increment,
  pfirstname text NOT NULL,
  plastname text NOT NULL,
  paddress text NOT NULL,
  paddress2 text NOT NULL,
  pcity text NOT NULL,
  pstate text NOT NULL,
  pzip text NOT NULL,
  pphone text NOT NULL,
  pemail text NOT NULL,
  byuser text NOT NULL,
  amount decimal(11,2) NOT NULL,
  paymentplugin text NOT NULL,
  cc_number text NOT NULL,
  cc_expmonth int(11) NOT NULL,
  cc_expyear int(11) NOT NULL,
  cc_transid text NOT NULL,
  cc_confirmation text NOT NULL,
  cc_cid int(11) NOT NULL,
  cc_track1 text NOT NULL,
  cc_track2 text NOT NULL,
  chk_dl text NOT NULL,
  chk_number text NOT NULL,
  paymentstatus text NOT NULL,
  paymenttype text NOT NULL,
  cc_cardtype text NOT NULL,
  custompaymentinfo text NOT NULL,
  isdeposit int(11) NOT NULL default '0',
  depositid int(11) NOT NULL default '0',
  UNIQUE KEY paymentid (paymentid)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=latin1";

$sql4 = "CREATE TABLE savedpayments (
  paymentid int(11) NOT NULL auto_increment,
  pfirstname text NOT NULL,
  plastname text NOT NULL,
  paddress text NOT NULL,
  paddress2 text NOT NULL,
  pcity text NOT NULL,
  pstate text NOT NULL,
  pzip text NOT NULL,
  pphone text NOT NULL,
  pemail text NOT NULL,
  receipt_id text NOT NULL,
  amount decimal(11,2) NOT NULL,
  paymentplugin text NOT NULL,
  cc_number text NOT NULL,
  cc_expmonth int(11) NOT NULL,
  cc_expyear int(11) NOT NULL,
  cc_transid text NOT NULL,
  cc_confirmation text NOT NULL,
  chk_dl text NOT NULL,
  chk_number text NOT NULL,
  paymentstatus text NOT NULL,
  paymenttype text NOT NULL,
  paymentdate datetime NOT NULL,
  cc_cardtype text NOT NULL,
  custompaymentinfo text NOT NULL,
  UNIQUE KEY paymentid (paymentid)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1";

$sql42 = "CREATE TABLE deposits (
  depositid int(11) NOT NULL auto_increment,
  pfirstname text NOT NULL,
  plastname text NOT NULL,
  paddress text NOT NULL,
  paddress2 text NOT NULL,
  pcity text NOT NULL,
  pstate text NOT NULL,
  pzip text NOT NULL,
  pphone text NOT NULL,
  pemail text NOT NULL,
  byuser text NOT NULL,
  amount decimal(11,2) NOT NULL,
  paymentplugin text NOT NULL,
  cc_number text NOT NULL,
  cc_expmonth int(11) NOT NULL,
  cc_expyear int(11) NOT NULL,
  cc_transid text NOT NULL,
  cc_confirmation text NOT NULL,
  cc_cid int(11) NOT NULL,
  cc_track1 text NOT NULL,
  cc_track2 text NOT NULL,
  chk_dl text NOT NULL,
  chk_number text NOT NULL,
  paymentstatus text NOT NULL,
  paymenttype text NOT NULL,
  cc_cardtype text NOT NULL,
  custompaymentinfo text NOT NULL,
  woid int(11) NOT NULL,
  receipt_id int(11) NOT NULL,
  dstatus text NOT NULL,
  depdate datetime NOT NULL,
  UNIQUE KEY depositid (depositid)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000";

$sql43 = "ALTER TABLE users ADD autoprint TINYINT NOT NULL DEFAULT '1'";
$sql44 = "ALTER TABLE users ADD touchview INT NOT NULL DEFAULT '2'";
$sql45 = "ALTER TABLE shoplist ADD stockid INT NOT NULL DEFAULT '0'";

@mysql_query($sql1, $rs_connect);
@mysql_query($sql2, $rs_connect);
@mysql_query($sql3, $rs_connect);
@mysql_query($sql4, $rs_connect);
@mysql_query($sql42, $rs_connect);
@mysql_query($sql43, $rs_connect);
@mysql_query($sql44, $rs_connect);
@mysql_query($sql45, $rs_connect);

$sql5 = "SELECT * FROM savedpayments";
$rs_chk = @mysql_query($sql5, $rs_connect);

if (mysql_num_rows($rs_chk) > 0) {
die("This script cannot be run again on your installation.");
}

$rs_findpayments_sql = "SELECT * FROM receipts WHERE pay_type != 'refund'";
$rs_find_payments = @mysql_query($rs_findpayments_sql, $rs_connect);
while($rs_find_payments_q = mysql_fetch_object($rs_find_payments)) {
$pfirstname = pv($rs_find_payments_q->person_name);
$paddress = pv($rs_find_payments_q->address1);
$paddress2 = pv($rs_find_payments_q->address2);
$amount = pv($rs_find_payments_q->grandtotal);
$receiptnumber = pv($rs_find_payments_q->receipt_id);
$currentdatetime = pv($rs_find_payments_q->date_sold);

$paymentplugin2 = pv($rs_find_payments_q->paywith);
if($paymentplugin2 == "credit") {
$paymentplugin = "GenericCreditCard";
} elseif ($paymentplugin2 == "check") {
$paymentplugin = "Check";
} elseif ($paymentplugin2 == "cash") {
$paymentplugin = "Cash";
} else {
$paymentplugin = "Unknown";
}


$cc_number = "$rs_find_payments_q->ccnumber";
$cc_expmonth = pv($rs_find_payments_q->ccexpdate);
$cc_confirmation = pv($rs_find_payments_q->confirmation);
$chk_dl = pv($rs_find_payments_q->driverslc);
$chk_number = pv($rs_find_payments_q->check_number);
$paymentstatus = "ready";
$paymenttype = pv($rs_find_payments_q->paywith);
$ccnumber2 = substr("$cc_number", -4);


$insertpaymentssql = "INSERT INTO savedpayments (pfirstname,paddress,paddress2,receipt_id,amount,paymentplugin,cc_number,cc_expmonth,cc_confirmation,chk_dl,chk_number,paymentstatus,paymenttype,paymentdate) VALUES ('$pfirstname', '$paddress', '$paddress2', '$receiptnumber', '$amount', '$paymentplugin', '$ccnumber2', '$cc_expmonth', '$cc_confirmation', '$chk_dl', '$chk_number', '$paymentstatus', '$paymenttype','$currentdatetime')";
@mysql_query($insertpaymentssql, $rs_connect);
}




                 
header("Location: databaseupgrade-1.27to1.28.php?func=do_upgrade2");
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
