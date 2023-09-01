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
echo "<br><br><a href=databaseupgrade-1.34to1.35.php?func=do_upgrade>Click Here</a> to upgrade the database from 1.34 to the 1.35 version of PC Repair Tracker.<br><br>";
stop_box();

require_once("footer.php");
                                                                                                    
}


function do_upgrade() {
require_once("validate.php");
require("deps.php");
require("common.php");

$rs_connect = @mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect the db");
$rs_select_db = @mysql_select_db($dbname, $rs_connect) or die("Couldn't select the db");




$sql1 = "ALTER TABLE currentcustomer ADD pcgroupid INT NOT NULL DEFAULT '0'";
$sql2 = "ALTER TABLE currentcustomer ADD rinvoiceid INT NOT NULL DEFAULT '0'";
$sql3 = "ALTER TABLE invoices ADD rinvoice_id INT NOT NULL DEFAULT '0'";
$sql4 = "ALTER TABLE stores ADD ccemail TEXT NOT NULL";

$sql5 = "CREATE TABLE rinvoices (
  rinvoice_id int(11) NOT NULL auto_increment,
  invactive int(11) NOT NULL default '1',
  invname text NOT NULL,
  invaddy1 text NOT NULL,
  invaddy2 text NOT NULL,
  invemail text NOT NULL,
  invphone text NOT NULL,
  invthrudate date NOT NULL,
  reinvoicedate date NOT NULL,
  invterms int(11) NOT NULL default '0',
  invinterval text NOT NULL,
  invcity text NOT NULL,
  invstate text NOT NULL,
  invzip text NOT NULL,
  byuser text NOT NULL,
  invnotes text NOT NULL,
  storeid int(11) NOT NULL,
  pcgroupid int(11) NOT NULL default '0',
  KEY rinvoice_id (rinvoice_id)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1";


$sql6 = "CREATE TABLE rinvoice_items (
  cart_item_id int(11) NOT NULL auto_increment,
  cart_price float(11,2) NOT NULL default '0.00',
  cart_type text NOT NULL,
  cart_stock_id int(11) NOT NULL default '0',
  labor_desc text NOT NULL,
  return_sold_id int(11) NOT NULL default '0',
  restocking_fee text NOT NULL,
  price_alt int(11) NOT NULL default '0',
  addtime timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  rinvoice_id int(11) NOT NULL,
  taxex int(11) NOT NULL default '0',
  itemtax decimal(11,2) NOT NULL default '0.00',
  origprice decimal(11,2) NOT NULL,
  discounttype text NOT NULL,
  ourprice decimal(11,2) NOT NULL default '0.00',
  itemserial text NOT NULL,
  UNIQUE KEY cart_item_id (cart_item_id)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";

$sql7 = "CREATE TABLE boxstyles (
  statusid int(11) NOT NULL,
  headerstyle text NOT NULL,
  bodystyle text NOT NULL,
  selectorcolor text NOT NULL,
  floaterstyle text NOT NULL,
  boxtitle text NOT NULL,
  KEY statusid (statusid)
) ENGINE=MyISAM DEFAULT CHARSET=latin1";

$sql8 = "INSERT INTO boxstyles (statusid, headerstyle, bodystyle, selectorcolor, floaterstyle, boxtitle) VALUES (2, 'background: #0000ff;\r\nborder-right: 2px solid #0000ff;\r\nborder-left: 2px solid #0000ff;\r\nborder-top: 2px solid #0000ff;\r\nborder-bottom: 1px solid #0000ff;\r\nbackground: -moz-linear-gradient(top, #6699FF 0%, #3366CC 50%, #003399 51%, #6699FF 100%); /* firefox */\r\nbackground: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#6699FF), color-stop(50%,#3366CC), color-stop(51%,#003399), color-stop(100%,#6699FF));\r\nbackground: -o-linear-gradient(top, #6699FF 0%,#3366CC 50%,#003399 51%,#6699FF 100%); /* Opera11.10+ */\r\nbackground: -ms-linear-gradient(top, #6699FF 0%,#3366CC 50%,#003399 51%,#6699FF 100%); /* IE10+ */\r\nbackground: linear-gradient(top, #6699FF 0%,#3366CC 50%,#003399 51%,#6699FF 100%); /* W3C */', 'border-right: 2px solid #0000ff;\r\nborder-left: 2px solid #0000ff;\r\nborder-bottom: 2px solid #0000ff;', '0000ff', 'background: #6699ff; /* Old browsers */\r\nbackground: -moz-linear-gradient(top,  #6699ff 0%, #003399 100%); /* FF3.6+ */\r\nbackground: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#6699ff), color-stop(100%,#003399)); /* Chrome,Safari4+ */\r\nbackground: -webkit-linear-gradient(top,  #6699ff 0%,#003399 100%); /* Chrome10+,Safari5.1+ */\r\nbackground: -o-linear-gradient(top,  #6699ff 0%,#003399 100%); /* Opera 11.10+ */\r\nbackground: -ms-linear-gradient(top,  #6699ff 0%,#003399 100%); /* IE10+ */\r\nbackground: linear-gradient(top,  #6699ff 0%,#003399 100%); /* W3C */\r\nborder: 2px solid #000022;', 'On the Bench'),
(52, 'background: #0000ff;\r\nborder-right: 2px solid #0000ff;\r\nborder-left: 2px solid #0000ff;\r\nborder-top: 2px solid #0000ff;\r\nborder-bottom: 1px solid #0000ff;\r\nbackground: -moz-linear-gradient(top, #6699FF 0%, #3366CC 50%, #003399 51%, #6699FF 100%); /* firefox */\r\nbackground: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#6699FF), color-stop(50%,#3366CC), color-stop(51%,#003399), color-stop(100%,#6699FF));\r\nbackground: -o-linear-gradient(top, #6699FF 0%,#3366CC 50%,#003399 51%,#6699FF 100%); /* Opera11.10+ */\r\nbackground: -ms-linear-gradient(top, #6699FF 0%,#3366CC 50%,#003399 51%,#6699FF 100%); /* IE10+ */\r\nbackground: linear-gradient(top, #6699FF 0%,#3366CC 50%,#003399 51%,#6699FF 100%); /* W3C */', 'border-right: 2px solid #0000ff;\r\nborder-left: 2px solid #0000ff;\r\nborder-bottom: 2px solid #0000ff;', '0000ff', '', 'Invoice List Box'),
(53, 'background: #aa0000;\r\nborder-right: 2px solid #aa0000;\r\nborder-left: 2px solid #aa0000;\r\nborder-top: 2px solid #aa0000;\r\nborder-bottom: 1px solid #aa0000;\r\nbackground: -moz-linear-gradient(top, #FF8282 0%, #D10000 50%, #AA0000 51%, #FF8282 100%); /* firefox */\r\nbackground: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#FF8282), color-stop(50%,#D10000), color-stop(51%,#AA0000), color-stop(100%,#FF8282));\r\nbackground: -o-linear-gradient(top, #FF8282 0%, #D10000 50%, #AA0000 51%, #FF8282 100%); /* Opera11.10+ */\r\nbackground: -ms-linear-gradient(top, #FF8282 0%, #D10000 50%, #AA0000 51%, #FF8282 100%); /* IE10+ */\r\nbackground: linear-gradient(top, #FF8282 0%, #D10000 50%, #AA0000 51%, #FF8282 100%); /* W3C */', 'border-right: 2px solid #aa0000;\r\nborder-left: 2px solid #aa0000;\r\nborder-bottom: 2px solid #aa0000;', 'aa0000', '', 'Overdue Invoice Box'),
(1, 'background: #000022;\r\nborder-right: 2px solid #000022;\r\nborder-left: 2px solid #000022;\r\nborder-top: 2px solid #000022;\r\nborder-bottom: 1px solid #000022;\r\nbackground: -moz-linear-gradient(top, #4669AF 0%, #1F3E7C 50%, #001644 51%, #4364A8 100%);\r\nbackground: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#4669AF), color-stop(50%,#1F3E7C), color-stop(51%,#001644), color-stop(100%,#4364A8));\r\nbackground: -o-linear-gradient(top, #4669AF 0%,#1F3E7C 50%,#001644 51%,#4364A8 100%); /* Opera11.10+ */\r\nbackground: -ms-linear-gradient(top, #4669AF 0%,#1F3E7C 50%,#001644 51%,#4364A8 100%); /* IE10+ */\r\nbackground: linear-gradient(top, #4669AF 0%,#1F3E7C 50%,#001644 51%,#4364A8 100%); /* W3C */', 'border-right: 2px solid #000022;\r\nborder-left: 2px solid #000022;\r\nborder-bottom: 2px solid #000022;', '000022', 'background: #4669AF; /* old browsers */\r\nbackground: -moz-linear-gradient(top, #4669AF 0%, #001644 100%); /* firefox */\r\nbackground: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#4669AF), color-stop(100%,#001644)); /* webkit */\r\nfilter: progid:DXImageTransform.Microsoft.gradient( startColorstr=''#4669AF'', endColorstr=''#001644'',GradientType=0 ); /* ie */\r\nbackground: -o-linear-gradient(top, #4669AF 0%, #001644 100%); /* Opera11.10+ */\r\nbackground: -ms-linear-gradient(top, #4669AF 0%, #001644 100%); /* IE10+ */\r\nbackground: linear-gradient(top, #4669AF 0%, #001644 100%); /* W3C */\r\nborder: 2px solid #000022;', 'Waiting for Bench'),
(3, 'background: #aa0000;\r\nborder-right: 2px solid #aa0000;\r\nborder-left: 2px solid #aa0000;\r\nborder-top: 2px solid #aa0000;\r\nborder-bottom: 1px solid #aa0000;\r\nbackground: -moz-linear-gradient(top, #FF8282 0%, #D10000 50%, #AA0000 51%, #FF8282 100%); /* firefox */\r\nbackground: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#FF8282), color-stop(50%,#D10000), color-stop(51%,#AA0000), color-stop(100%,#FF8282));\r\nbackground: -o-linear-gradient(top, #FF8282 0%, #D10000 50%, #AA0000 51%, #FF8282 100%); /* Opera11.10+ */\r\nbackground: -ms-linear-gradient(top, #FF8282 0%, #D10000 50%, #AA0000 51%, #FF8282 100%); /* IE10+ */\r\nbackground: linear-gradient(top, #FF8282 0%, #D10000 50%, #AA0000 51%, #FF8282 100%); /* W3C */', 'border-right: 2px solid #aa0000;\r\nborder-left: 2px solid #aa0000;\r\nborder-bottom: 2px solid #aa0000;', 'aa0000', 'background: #ff8282; /* Old browsers */\r\nbackground: -moz-linear-gradient(top,  #ff8282 0%, #aa0000 100%); /* FF3.6+ */\r\nbackground: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ff8282), color-stop(100%,#aa0000)); /* Chrome,Safari4+ */\r\nbackground: -webkit-linear-gradient(top,  #ff8282 0%,#aa0000 100%); /* Chrome10+,Safari5.1+ */\r\nbackground: -o-linear-gradient(top,  #ff8282 0%,#aa0000 100%); /* Opera 11.10+ */\r\nbackground: -ms-linear-gradient(top,  #ff8282 0%,#aa0000 100%); /* IE10+ */\r\nbackground: linear-gradient(top,  #ff8282 0%,#aa0000 100%); /* W3C */\r\nborder: 2px solid #000022;', 'Pending / On Hold'),
(4, 'background: #006600;\r\nborder-right: 2px solid #006600;\r\nborder-left: 2px solid #006600;\r\nborder-top: 2px solid #006600;\r\nborder-bottom: 1px solid #006600;\r\nbackground: -moz-linear-gradient(top, #0FE500 0%, #009107 50%, #006006 51%, #0FE500 100%); \r\nbackground: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#0FE500), color-stop(50%,#009107), color-stop(51%,#006006), color-stop(100%,#0FE500)); /* webkit */\r\nbackground: -o-linear-gradient(top, #0FE500 0%, #009107 50%, #006006 51%, #0FE500 100%); /* Opera11.10+ */\r\nbackground: -ms-linear-gradient(top, #0FE500 0%, #009107 50%, #006006 51%, #0FE500 100%); /* IE10+ */\r\nbackground: linear-gradient(top, #0FE500 0%, #009107 50%, #006006 51%, #0FE500 100%); /* W3C */', 'border-right: 2px solid #06600;\r\nborder-left: 2px solid #006600;\r\nborder-bottom: 2px solid #006600;', '006600', 'background: #0fe500; /* Old browsers */\r\nbackground: -moz-linear-gradient(top,  #0fe500 0%, #006006 100%); /* FF3.6+ */\r\nbackground: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#0fe500), color-stop(100%,#006006)); /* Chrome,Safari4+ */\r\nbackground: -webkit-linear-gradient(top,  #0fe500 0%,#006006 100%); /* Chrome10+,Safari5.1+ */\r\nbackground: -o-linear-gradient(top,  #0fe500 0%,#006006 100%); /* Opera 11.10+ */\r\nbackground: -ms-linear-gradient(top,  #0fe500 0%,#006006 100%); /* IE10+ */\r\nbackground: linear-gradient(top,  #0fe500 0%,#006006 100%); /* W3C */\r\nborder: 2px solid #000022;', 'Completed/Ready for Pickup'),
(5, 'background: #aa0000;\r\nborder-right: 2px solid #aa0000;\r\nborder-left: 2px solid #aa0000;\r\nborder-top: 2px solid #aa0000;\r\nborder-bottom: 1px solid #aa0000;\r\nbackground: -moz-linear-gradient(top, #FF8282 0%, #D10000 50%, #AA0000 51%, #FF8282 100%); /* firefox */\r\nbackground: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#FF8282), color-stop(50%,#D10000), color-stop(51%,#AA0000), color-stop(100%,#FF8282));\r\nbackground: -o-linear-gradient(top, #FF8282 0%, #D10000 50%, #AA0000 51%, #FF8282 100%); /* Opera11.10+ */\r\nbackground: -ms-linear-gradient(top, #FF8282 0%, #D10000 50%, #AA0000 51%, #FF8282 100%); /* IE10+ */\r\nbackground: linear-gradient(top, #FF8282 0%, #D10000 50%, #AA0000 51%, #FF8282 100%); /* W3C */', 'border-right: 2px solid #aa0000;\r\nborder-left: 2px solid #aa0000;\r\nborder-bottom: 2px solid #aa0000;', 'aa0000', 'background: #ff8282; /* Old browsers */\r\nbackground: -moz-linear-gradient(top,  #ff8282 0%, #aa0000 100%); /* FF3.6+ */\r\nbackground: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ff8282), color-stop(100%,#aa0000)); /* Chrome,Safari4+ */\r\nbackground: -webkit-linear-gradient(top,  #ff8282 0%,#aa0000 100%); /* Chrome10+,Safari5.1+ */\r\nbackground: -o-linear-gradient(top,  #ff8282 0%,#aa0000 100%); /* Opera 11.10+ */\r\nbackground: -ms-linear-gradient(top,  #ff8282 0%,#aa0000 100%); /* IE10+ */\r\nbackground: linear-gradient(top,  #ff8282 0%,#aa0000 100%); /* W3C */\r\nborder: 2px solid #000022;', 'Picked up by Customer'),
(6, 'background: #aa0000;\r\nborder-right: 2px solid #aa0000;\r\nborder-left: 2px solid #aa0000;\r\nborder-top: 2px solid #aa0000;\r\nborder-bottom: 1px solid #aa0000;\r\nbackground: -moz-linear-gradient(top, #FF8282 0%, #D10000 50%, #AA0000 51%, #FF8282 100%); /* firefox */\r\nbackground: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#FF8282), color-stop(50%,#D10000), color-stop(51%,#AA0000), color-stop(100%,#FF8282));\r\nbackground: -o-linear-gradient(top, #FF8282 0%, #D10000 50%, #AA0000 51%, #FF8282 100%); /* Opera11.10+ */\r\nbackground: -ms-linear-gradient(top, #FF8282 0%, #D10000 50%, #AA0000 51%, #FF8282 100%); /* IE10+ */\r\nbackground: linear-gradient(top, #FF8282 0%, #D10000 50%, #AA0000 51%, #FF8282 100%); /* W3C */', 'border-right: 2px solid #aa0000;\r\nborder-left: 2px solid #aa0000;\r\nborder-bottom: 2px solid #aa0000;', 'aa0000', 'background: #ff8282; /* Old browsers */\r\nbackground: -moz-linear-gradient(top,  #ff8282 0%, #aa0000 100%); /* FF3.6+ */\r\nbackground: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ff8282), color-stop(100%,#aa0000)); /* Chrome,Safari4+ */\r\nbackground: -webkit-linear-gradient(top,  #ff8282 0%,#aa0000 100%); /* Chrome10+,Safari5.1+ */\r\nbackground: -o-linear-gradient(top,  #ff8282 0%,#aa0000 100%); /* Opera 11.10+ */\r\nbackground: -ms-linear-gradient(top,  #ff8282 0%,#aa0000 100%); /* IE10+ */\r\nbackground: linear-gradient(top,  #ff8282 0%,#aa0000 100%); /* W3C */\r\nborder: 2px solid #000022;', 'Waiting for Payment'),
(7, 'background: #b41cf4;\r\nborder-right: 2px solid #b41cf4;\r\nborder-left: 2px solid #b41cf4;\r\nborder-top: 2px solid #b41cf4;\r\nborder-bottom: 1px solid #b41cf4;\r\nbackground: -moz-linear-gradient(top, #D287F2 0%, #9818CE 50%, #8315B2 51%, #D287F2 100%); /* firefox */\r\nbackground: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#D287F2), color-stop(50%,#9818CE), color-stop(51%,#8315B2), color-stop(100%,#D287F2)); /* webkit */\r\nbackground: -o-linear-gradient(top, #D287F2 0%, #9818CE 50%, #8315B2 51%, #D287F2 100%); /* Opera11.10+ */\r\nbackground: -ms-linear-gradient(top, #D287F2 0%, #9818CE 50%, #8315B2 51%, #D287F2 100%); /* IE10+ */\r\nbackground: linear-gradient(top, #D287F2 0%, #9818CE 50%, #8315B2 51%, #D287F2 100%); /* W3C */', 'border-right: 2px solid #b41cf4;\r\nborder-left: 2px solid #b41cf4;\r\nborder-bottom: 2px solid #b41cf4;', 'b41cf4', 'background: #d287f2; /* Old browsers */\r\nbackground: -moz-linear-gradient(top,  #d287f2 0%, #8315b2 100%); /* FF3.6+ */\r\nbackground: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#d287f2), color-stop(100%,#8315b2)); /* Chrome,Safari4+ */\r\nbackground: -webkit-linear-gradient(top,  #d287f2 0%,#8315b2 100%); /* Chrome10+,Safari5.1+ */\r\nbackground: -o-linear-gradient(top,  #d287f2 0%,#8315b2 100%); /* Opera 11.10+ */\r\nbackground: -ms-linear-gradient(top,  #d287f2 0%,#8315b2 100%); /* IE10+ */\r\nbackground: linear-gradient(top,  #d287f2 0%,#8315b2 100%); /* W3C */\r\nborder: 2px solid #000022;', 'Ready to Sell'),
(8, 'background: #ff6600;\r\nborder-right: 2px solid #ff6600;\r\nborder-left: 2px solid #ff6600;\r\nborder-top: 2px solid #ff6600;\r\nborder-bottom: 1px solid #ff6600;\r\nbackground: -moz-linear-gradient(top, #FFCC00 0%, #FF9900 50%, #FF6600 51%, #FFCC00 100%); /* firefox */\r\nbackground: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#FFCC00), color-stop(50%,#FF9900), color-stop(51%,#FF6600), color-stop(100%,#FFCC00)); /* webkit */\r\nbackground: -o-linear-gradient(top, #FFCC00 0%, #FF9900 50%, #FF6600 51%, #FFCC00 100%); /* Opera11.10+ */\r\nbackground: -ms-linear-gradient(top, #FFCC00 0%, #FF9900 50%, #FF6600 51%, #FFCC00 100%); /* IE10+ */\r\nbackground: linear-gradient(top, #FFCC00 0%, #FF9900 50%, #FF6600 51%, #FFCC00 100%); /* W3C */', 'border-right: 2px solid #ff6600;\r\nborder-left: 2px solid #ff6600;\r\nborder-bottom: 2px solid #ff6600;', 'ff6600', 'background: #ffcc00; /* Old browsers */\r\nbackground: -moz-linear-gradient(top,  #ffcc00 0%, #ff6600 100%); /* FF3.6+ */\r\nbackground: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffcc00), color-stop(100%,#ff6600)); /* Chrome,Safari4+ */\r\nbackground: -webkit-linear-gradient(top,  #ffcc00 0%,#ff6600 100%); /* Chrome10+,Safari5.1+ */\r\nbackground: -o-linear-gradient(top,  #ffcc00 0%,#ff6600 100%); /* Opera 11.10+ */\r\nbackground: -ms-linear-gradient(top,  #ffcc00 0%,#ff6600 100%); /* IE10+ */\r\nbackground: linear-gradient(top,  #ffcc00 0%,#ff6600 100%); /* W3C */\r\nborder: 2px solid #000022;', 'On Service Call'),
(9, 'border-right: 2px solid #f30084;\r\nborder-left: 2px solid #f30084;\r\nborder-top: 2px solid #f30084;\r\nborder-bottom: 1px solid #f30084;\r\nbackground: #f30084;\r\nbackground: -moz-linear-gradient(top, #F29DCA 0%, #F248A3 50%, #CE006E 51%, #F29DCA 100%); /* firefox */\r\nbackground: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#F29DCA), color-stop(50%,#F248A3), color-stop(51%,#CE006E), color-stop(100%,#F29DCA));\r\nbackground: -o-linear-gradient(top, #F29DCA 0%, #F248A3 50%, #CE006E 51%, #F29DCA 100%); /* Opera11.10+ */\r\nbackground: -ms-linear-gradient(top, #F29DCA 0%, #F248A3 50%, #CE006E 51%, #F29DCA 100%); /* IE10+ */\r\nbackground: linear-gradient(top, #F29DCA 0%, #F248A3 50%, #CE006E 51%, #F29DCA 100%); /* W3C */', 'border-right: 2px solid #f30084;\r\nborder-left: 2px solid #f30084;\r\nborder-bottom: 2px solid #f30084;', 'f30084', 'background: #f29dca; /* Old browsers */\r\nbackground: -moz-linear-gradient(top,  #f29dca 0%, #ce006e 100%); /* FF3.6+ */\r\nbackground: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#f29dca), color-stop(100%,#ce006e)); /* Chrome,Safari4+ */\r\nbackground: -webkit-linear-gradient(top,  #f29dca 0%,#ce006e 100%); /* Chrome10+,Safari5.1+ */\r\nbackground: -o-linear-gradient(top,  #f29dca 0%,#ce006e 100%); /* Opera 11.10+ */\r\nbackground: -ms-linear-gradient(top,  #f29dca 0%,#ce006e 100%); /* IE10+ */\r\nbackground: linear-gradient(top,  #f29dca 0%,#ce006e 100%); /* W3C */\r\nborder: 2px solid #000022;', 'Remote Support Sessions'),
(50, 'border-top: 2px solid #000000;\r\nborder-left: 2px solid #000000;\r\nborder-right: 2px solid #000000;\r\nborder-bottom: 1px solid #000000;\r\nbackground: #333333; /* old browsers */\r\nbackground: -moz-linear-gradient(top, #A8A8A8 0%, #4F4F4F 50%, #232323 51%, #A8A8A8 100%);\r\nbackground: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#A8A8A8), color-stop(50%,#4F4F4F), color-stop(51%,#232323), color-stop(100%,#A8A8A8));\r\nbackground: -o-linear-gradient(top, #A8A8A8 0%,#4F4F4F 50%,#232323 51%,#A8A8A8 100%); /* Opera11.10+ */\r\nbackground: -ms-linear-gradient(top, #A8A8A8 0%,#4F4F4F 50%,#232323 51%,#A8A8A8 100%); /* IE10+ */\r\nbackground: linear-gradient(top, #A8A8A8 0%,#4F4F4F 50%,#232323 51%,#A8A8A8 100%); /* W3C */', 'border-right: 2px solid #000000;\r\nborder-left: 2px solid #000000;\r\nborder-bottom: 2px solid #000000;', '000000', '', 'Standard Title Boxes'),
(51, 'border-top: 2px solid #000000;\r\nborder-left: 2px solid #000000;\r\nborder-right: 2px solid #000000;\r\nborder-bottom: 1px solid #000000;\r\nbackground: #e0e0e0; /* Old browsers */\r\nbackground: -moz-linear-gradient(top,  #e0e0e0 0%, #939393 50%, #727272 52%, #aaaaaa 100%); /* FF3.6+ */\r\nbackground: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#e0e0e0), color-stop(50%,#939393), color-stop(52%,#727272), color-stop(100%,#aaaaaa)); /* Chrome,Safari4+ */\r\nbackground: -webkit-linear-gradient(top,  #e0e0e0 0%,#939393 50%,#727272 52%,#aaaaaa 100%); /* Chrome10+,Safari5.1+ */\r\nbackground: -o-linear-gradient(top,  #e0e0e0 0%,#939393 50%,#727272 52%,#aaaaaa 100%); /* Opera 11.10+ */\r\nbackground: -ms-linear-gradient(top,  #e0e0e0 0%,#939393 50%,#727272 52%,#aaaaaa 100%); /* IE10+ */\r\nbackground: linear-gradient(top,  #e0e0e0 0%,#939393 50%,#727272 52%,#aaaaaa 100%); /* W3C */', 'border-right: 2px solid #000000;\r\nborder-left: 2px solid #000000;\r\nborder-bottom: 2px solid #000000;', '000000', '', 'Standard Inventory Title Boxes'),
(0, 'border-right: 2px solid #88AA00;\r\nborder-left: 2px solid #88AA00;\r\nborder-top: 2px solid #88AA00;\r\nborder-bottom: 1px solid #88AA00;\r\nbackground: #88AA00;\r\nbackground: -moz-linear-gradient(top, #E4FFA8 0%, #96BC00 50%, #88AA00 51%, #E4FFA8 100%); /* firefox */\r\nbackground: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#E4FFA8), color-stop(50%,#96BC00),color-stop(51%,#88AA00), color-stop(100%,#E4FFA8)); /* webkit */\r\nbackground: -o-linear-gradient(top, #E4FFA8 0%, #96BC00 50%, #88AA00 51%, #E4FFA8 100%); /* Opera11.10+ */\r\nbackground: -ms-linear-gradient(top, #E4FFA8 0%, #96BC00 50%, #88AA00 51%, #E4FFA8 100%); /* IE10+ */\r\nbackground: linear-gradient(top, #E4FFA8 0%, #96BC00 50%, #88AA00 51%, #E4FFA8 100%); /* W3C */', 'border-right: 2px solid #88AA00;\r\nborder-left: 2px solid #88AA00;\r\nborder-bottom: 2px solid #88AA00;', '88AA00', '', '100')";


@mysql_query($sql1, $rs_connect);
@mysql_query($sql2, $rs_connect);
@mysql_query($sql3, $rs_connect);
@mysql_query($sql4, $rs_connect);
@mysql_query($sql5, $rs_connect);
@mysql_query($sql6, $rs_connect);
@mysql_query($sql7, $rs_connect);
@mysql_query($sql8, $rs_connect);


while (list($key, $val) = each($cstatus)) {
$rs_ics = "INSERT INTO boxstyles (statusid, headerstyle, bodystyle, selectorcolor, floaterstyle, boxtitle) VALUES ('$key', 'border-right: 2px solid #88AA00;\r\nborder-left: 2px solid #88AA00;\r\nborder-top: 2px solid #88AA00;\r\nborder-bottom: 1px solid #88AA00;\r\nbackground: #88AA00;\r\nbackground: -moz-linear-gradient(top, #E4FFA8 0%, #96BC00 50%, #88AA00 51%, #E4FFA8 100%); /* firefox */\r\nbackground: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#E4FFA8), color-stop(50%,#96BC00),color-stop(51%,#88AA00), color-stop(100%,#E4FFA8)); /* webkit */\r\nbackground: -o-linear-gradient(top, #E4FFA8 0%, #96BC00 50%, #88AA00 51%, #E4FFA8 100%); /* Opera11.10+ */\r\nbackground: -ms-linear-gradient(top, #E4FFA8 0%, #96BC00 50%, #88AA00 51%, #E4FFA8 100%); /* IE10+ */\r\nbackground: linear-gradient(top, #E4FFA8 0%, #96BC00 50%, #88AA00 51%, #E4FFA8 100%); /* W3C */', 'border-right: 2px solid #88AA00;\r\nborder-left: 2px solid #88AA00;\r\nborder-bottom: 2px solid #88AA00;', '88AA00', 'background: #e4ffa8; /* Old browsers */\r\nbackground: -moz-linear-gradient(top,  #e4ffa8 0%, #88aa00 100%); /* FF3.6+ */\r\nbackground: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#e4ffa8), color-stop(100%,#88aa00)); /* Chrome,Safari4+ */\r\nbackground: -webkit-linear-gradient(top,  #e4ffa8 0%,#88aa00 100%); /* Chrome10+,Safari5.1+ */\r\nbackground: -o-linear-gradient(top,  #e4ffa8 0%,#88aa00 100%); /* Opera 11.10+ */\r\nbackground: -ms-linear-gradient(top,  #e4ffa8 0%,#88aa00 100%); /* IE10+ */\r\nbackground: linear-gradient(top,  #e4ffa8 0%,#88aa00 100%); /* W3C */\r\nborder: 2px solid #000022;', '$val');";
@mysql_query($rs_ics, $rs_connect);
}

$sql9 = "ALTER TABLE cart CHANGE addtime addtime INT NOT NULL";
$sql10 = "UPDATE cart SET addtime = cart_item_id";

$sql11 = "ALTER TABLE invoice_items CHANGE addtime addtime INT NOT NULL";
$sql12 = "UPDATE invoice_items SET addtime = cart_item_id";

$sql13 = "ALTER TABLE rinvoice_items CHANGE addtime addtime INT NOT NULL";
$sql14 = "UPDATE rinvoice_items SET addtime = cart_item_id";

$sql15 = "ALTER TABLE sold_items ADD addtime INT NOT NULL";
$sql16 = "UPDATE sold_items SET addtime = sold_id";

$sql17 = "ALTER TABLE repaircart CHANGE addtime addtime INT NOT NULL";
$sql18 = "UPDATE repaircart SET addtime = cart_item_id";

$sql19 = "ALTER TABLE savedcarts ADD addtime INT NOT NULL";

@mysql_query($sql9, $rs_connect);
@mysql_query($sql10, $rs_connect);
@mysql_query($sql11, $rs_connect);
@mysql_query($sql12, $rs_connect);
@mysql_query($sql13, $rs_connect);
@mysql_query($sql14, $rs_connect);
@mysql_query($sql15, $rs_connect);
@mysql_query($sql16, $rs_connect);
@mysql_query($sql17, $rs_connect);
@mysql_query($sql18, $rs_connect);
@mysql_query($sql19, $rs_connect);

header("Location: databaseupgrade-1.34to1.35.php?func=do_upgrade2");
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
