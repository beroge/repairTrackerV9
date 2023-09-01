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
echo "<br><br><a href=databaseupgrade-1.36to1.37.php?func=do_upgrade>Click Here</a> to upgrade the database from 1.36 to the 1.37 version of PC Repair Tracker.<br><br>";
stop_box();

require_once("footer.php");
                                                                                                    
}


function do_upgrade() {
require_once("validate.php");
require("deps.php");
require("common.php");

$rs_connect = @mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect the db");
$rs_select_db = @mysql_select_db($dbname, $rs_connect) or die("Couldn't select the db");



$sql1 = "ALTER  DATABASE $dbname CHARACTER SET utf8 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT COLLATE utf8_general_ci";
$sql2 = "ALTER  TABLE assetphotos CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql3 = "ALTER  TABLE attachments CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql4 = "ALTER  TABLE benches CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql5 = "ALTER  TABLE boxstyles CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql6 = "ALTER  TABLE cart CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql7 = "ALTER  TABLE claimsigtext CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql8 = "ALTER  TABLE commonproblems CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql9 = "ALTER  TABLE currentcustomer CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql10 = "ALTER  TABLE currentpayments CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql11 = "ALTER  TABLE custsource CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql12 = "ALTER  TABLE deposits CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql13 = "ALTER  TABLE frameit CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql14 = "ALTER  TABLE inventory CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql15 = "ALTER  TABLE invoices CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql16 = "ALTER  TABLE invoice_items CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql17 = "ALTER  TABLE maincats CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql18 = "ALTER  TABLE onorder CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql19 = "ALTER  TABLE ordernumber CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql20 = "ALTER  TABLE pc_group CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql21 = "ALTER  TABLE pc_owner CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql22 = "ALTER  TABLE pc_scan CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql23 = "ALTER  TABLE pc_scans CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql24 = "ALTER  TABLE pc_wo CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql25 = "ALTER  TABLE photos CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql26 = "ALTER  TABLE quicklabor CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql27 = "ALTER  TABLE receipts CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql28 = "ALTER  TABLE repaircart CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql29 = "ALTER  TABLE rinvoices CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql30 = "ALTER  TABLE rinvoice_items CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql31 = "ALTER  TABLE savedcarts CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql32 = "ALTER  TABLE savedpayments CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql33 = "ALTER  TABLE serviceremindercanned CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql34 = "ALTER  TABLE servicereminders CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql35 = "ALTER  TABLE servicerequests CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql36 = "ALTER  TABLE shoplist CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql37 = "ALTER  TABLE smstext CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql38 = "ALTER  TABLE sold_items CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql39 = "ALTER  TABLE stickynotes CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql40 = "ALTER  TABLE stickytypes CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql41 = "ALTER  TABLE stock CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql42 = "ALTER  TABLE stockcounts CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql43 = "ALTER  TABLE stores CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql44 = "ALTER  TABLE storevars CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql45 = "ALTER  TABLE sub_cats CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql46 = "ALTER  TABLE taxes CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql47 = "ALTER  TABLE techdocs CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql48 = "ALTER  TABLE userlog CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
$sql49 = "ALTER  TABLE users CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";

mysql_query("SET NAMES utf8");


$sql50 = "ALTER  TABLE savedpayments CHANGE receipt_id receipt_id INT NOT NULL";
$sql51 = "ALTER  TABLE receipts CHANGE invoice_id invoice_id INT NOT NULL";
$sql52_2 = "ALTER  TABLE receipts CHANGE woid woid INT NOT NULL";

$sql53 = "ALTER  TABLE assetphotos ADD INDEX ( pcid )";
$sql54 = "ALTER  TABLE attachments ADD INDEX ( woid )";
$sql55 = "ALTER  TABLE attachments ADD INDEX ( pcid )";
$sql56 = "ALTER  TABLE benches ADD INDEX ( storeid )";
$sql57 = "ALTER  TABLE boxstyles ADD INDEX ( statusid )"; 
$sql58 = "ALTER  TABLE cart ADD INDEX ( cart_item_id )";
$sql59 = "ALTER  TABLE claimsigtext ADD INDEX ( woid )";
$sql60 = "ALTER  TABLE deposits ADD INDEX ( woid )";
$sql61 = "ALTER  TABLE deposits ADD INDEX ( receipt_id )";
$sql62 = "ALTER  TABLE inventory ADD INDEX ( stock_id )";
$sql63 = "ALTER  TABLE invoices ADD INDEX ( woid )";
$sql64 = "ALTER  TABLE invoices ADD INDEX ( receipt_id )";
$sql65 = "ALTER  TABLE invoice_items ADD INDEX ( invoice_id )";
$sql66 = "ALTER  TABLE pc_owner ADD INDEX ( pcgroupid )";
$sql67 = "ALTER  TABLE pc_scan ADD INDEX ( woid )";
$sql68 = "ALTER  TABLE pc_wo ADD INDEX ( pcid )";
$sql69 = "ALTER  TABLE receipts ADD INDEX ( woid )";
$sql70 = "ALTER  TABLE receipts ADD INDEX ( invoice_id )";
$sql71 = "ALTER  TABLE repaircart ADD INDEX ( pcwo )";
$sql72 = "ALTER  TABLE savedpayments ADD INDEX ( receipt_id )";
$sql73 = "ALTER  TABLE sold_items ADD INDEX ( receipt )";
$sql74 = "ALTER  TABLE stickynotes ADD INDEX ( refid )";
$sql75 = "ALTER  TABLE stockcounts ADD INDEX ( stockid )";
$sql76 = "ALTER  TABLE userlog ADD INDEX ( refid )";
$sql77 = "ALTER  TABLE userlog ADD INDEX ( actionid )";
$sql77_1 = "ALTER TABLE pc_wo ADD INDEX ( pcstatus ) ";
$sql77_2 = "ALTER TABLE pc_wo ADD INDEX ( storeid ) ";

$sql78 = "ALTER  TABLE  cart CHANGE  cart_price  cart_price FLOAT( 11, 5 ) NOT NULL DEFAULT  '0.00000'";
$sql79 = "ALTER  TABLE  cart CHANGE  itemtax  itemtax DECIMAL( 11, 5 ) NOT NULL";
$sql80 = "ALTER  TABLE  cart CHANGE  origprice  origprice DECIMAL( 11, 5 ) NOT NULL";
$sql81 = "ALTER  TABLE  cart CHANGE  ourprice  ourprice DECIMAL( 11, 5 ) NOT NULL DEFAULT  '0.00000'";
$sql82 = "ALTER  TABLE  currentpayments CHANGE  amount  amount DECIMAL( 11, 5 ) NOT NULL";
$sql83 = "ALTER  TABLE  deposits CHANGE  amount  amount DECIMAL( 11, 5 ) NOT NULL";
$sql84 = "ALTER  TABLE  inventory CHANGE  inv_price  inv_price FLOAT( 11, 5 ) NOT NULL DEFAULT  '0.00000'";
$sql85 = "ALTER  TABLE  invoice_items CHANGE  cart_price  cart_price FLOAT( 11, 5 ) NOT NULL DEFAULT  '0.00000'";
$sql86 = "ALTER  TABLE  invoice_items CHANGE  itemtax  itemtax DECIMAL( 11, 5 ) NOT NULL DEFAULT  '0.00000'";
$sql87 = "ALTER  TABLE  invoice_items CHANGE  origprice  origprice DECIMAL( 11, 5 ) NOT NULL";
$sql88 = "ALTER  TABLE  invoice_items CHANGE  ourprice  ourprice DECIMAL( 11, 5 ) NOT NULL DEFAULT  '0.00000'";
$sql89 = "ALTER  TABLE  receipts CHANGE  grandtotal  grandtotal FLOAT( 11, 5 ) NOT NULL DEFAULT  '0.00000'";
$sql90 = "ALTER  TABLE  receipts CHANGE  grandtax  grandtax FLOAT( 11, 5 ) NOT NULL DEFAULT  '0.00000'";
$sql91 = "ALTER  TABLE  repaircart CHANGE  cart_price  cart_price FLOAT( 11, 5 ) NOT NULL DEFAULT  '0.00000'";
$sql92 = "ALTER  TABLE  repaircart CHANGE  itemtax  itemtax DECIMAL( 11, 5 ) NOT NULL DEFAULT  '0.00000'";
$sql93 = "ALTER  TABLE  repaircart CHANGE  origprice  origprice DECIMAL( 11, 5 ) NOT NULL";
$sql94 = "ALTER  TABLE  repaircart CHANGE  ourprice  ourprice DECIMAL( 11, 5 ) NOT NULL DEFAULT  '0.00000'";
$sql95 = "ALTER  TABLE  rinvoice_items CHANGE  cart_price  cart_price FLOAT( 11, 5 ) NOT NULL DEFAULT  '0.00000'";
$sql96 = "ALTER  TABLE  rinvoice_items CHANGE  itemtax  itemtax DECIMAL( 11, 5 ) NOT NULL DEFAULT  '0.00000'";
$sql97 = "ALTER  TABLE  rinvoice_items CHANGE  origprice  origprice DECIMAL( 11, 5 ) NOT NULL";
$sql98 = "ALTER  TABLE  rinvoice_items CHANGE  ourprice  ourprice DECIMAL( 11, 5 ) NOT NULL DEFAULT  '0.00000'";
$sql99 = "ALTER  TABLE  savedcarts CHANGE  cart_price  cart_price FLOAT( 11, 5 ) NOT NULL DEFAULT  '0.00000'";
$sql100 = "ALTER  TABLE  savedcarts CHANGE  itemtax  itemtax DECIMAL( 11, 5 ) NOT NULL";
$sql101 = "ALTER  TABLE  savedcarts CHANGE  origprice  origprice DECIMAL( 11, 5 ) NOT NULL";
$sql102 = "ALTER  TABLE  savedcarts CHANGE  ourprice  ourprice DECIMAL( 11, 5 ) NOT NULL DEFAULT  '0.00000'";
$sql103 = "ALTER  TABLE  savedpayments CHANGE  amount  amount DECIMAL( 11, 5 ) NOT NULL";
$sql104 = "ALTER  TABLE  sold_items CHANGE  sold_price  sold_price FLOAT( 11, 5 ) NOT NULL DEFAULT  '0.00000'";
$sql105 = "ALTER  TABLE  sold_items CHANGE  itemtax  itemtax DECIMAL( 11, 5 ) NOT NULL DEFAULT  '0.00000'";
$sql106 = "ALTER  TABLE  sold_items CHANGE  origprice  origprice DECIMAL( 11, 5 ) NOT NULL";
$sql107 = "ALTER  TABLE  sold_items CHANGE  ourprice  ourprice DECIMAL( 11, 5 ) NOT NULL DEFAULT  '0.00000'";
$sql108 = "ALTER  TABLE  stock CHANGE  stock_price  stock_price FLOAT( 11, 5 ) NOT NULL DEFAULT  '0.00000'";
$sql109 = "ALTER  TABLE  taxes CHANGE  taxrateservice  taxrateservice DECIMAL( 11, 5 ) NOT NULL DEFAULT  '0.0000'";
$sql110 = "ALTER  TABLE  taxes CHANGE  taxrategoods  taxrategoods DECIMAL( 11, 5 ) NOT NULL DEFAULT  '0.0000'";


$sql111 = "CREATE TABLE languages (
  language varchar(5) character set utf8 collate utf8_bin NOT NULL,
  languagestring varchar(200) character set utf8 collate utf8_bin NOT NULL,
  basestring varchar(200) character set utf8 collate utf8_bin NOT NULL,
  KEY language (language),
  KEY basestring (basestring)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin";


$sql112 = "ALTER TABLE stores ADD checkoutreceipt MEDIUMTEXT NOT NULL AFTER claimticket";

$sql113 = "ALTER TABLE pc_wo ADD thesigcr MEDIUMTEXT NOT NULL ,
ADD showsigcr INT NOT NULL DEFAULT '1'";

$sql114 = "ALTER TABLE stores ADD tempasset MEDIUMTEXT NOT NULL ,
ADD tempaddress MEDIUMTEXT NOT NULL ,
ADD temppricetag MEDIUMTEXT NOT NULL ,
ADD temppricetagserial MEDIUMTEXT NOT NULL";

$sql115 = <<<TEMPLATESQL
UPDATE stores SET tempasset = '<?xml version="1.0" encoding="utf-8"?>\r\n<DieCutLabel Version="8.0" Units="twips">\r\n	<PaperOrientation>Landscape</PaperOrientation>\r\n	<Id>Address</Id>\r\n	<PaperName>30252 Address</PaperName>\r\n	<DrawCommands>\r\n		<RoundRectangle X="0" Y="0" Width="1581" Height="5040" Rx="270" Ry="270" />\r\n	</DrawCommands>\r\n	<ObjectInfo>\r\n		<BarcodeObject>\r\n			<Name>Barcode</Name>\r\n			<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n			<BackColor Alpha="0" Red="255" Green="255" Blue="255" />\r\n			<LinkedObjectName></LinkedObjectName>\r\n			<Rotation>Rotation0</Rotation>\r\n			<IsMirrored>False</IsMirrored>\r\n			<IsVariable>True</IsVariable>\r\n			<Text>PCRTPCID</Text>\r\n			<Type>Code39</Type>\r\n			<Size>Medium</Size>\r\n			<TextPosition>Bottom</TextPosition>\r\n			<TextFont Family="Arial" Size="16" Bold="True" Italic="False" Underline="False" Strikeout="False" />\r\n			<CheckSumFont Family="Arial" Size="7.3125" Bold="False" Italic="False" Underline="False" Strikeout="False" />\r\n			<TextEmbedding>None</TextEmbedding>\r\n			<ECLevel>0</ECLevel>\r\n			<HorizontalAlignment>Center</HorizontalAlignment>\r\n			<QuietZonesPadding Left="0" Top="0" Right="0" Bottom="0" />\r\n		</BarcodeObject>\r\n		<Bounds X="331" Y="833" Width="4440.47265625" Height="660" />\r\n	</ObjectInfo>\r\n	<ObjectInfo>\r\n		<TextObject>\r\n			<Name>Text</Name>\r\n			<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n			<BackColor Alpha="0" Red="255" Green="255" Blue="255" />\r\n			<LinkedObjectName></LinkedObjectName>\r\n			<Rotation>Rotation0</Rotation>\r\n			<IsMirrored>False</IsMirrored>\r\n			<IsVariable>True</IsVariable>\r\n			<HorizontalAlignment>Center</HorizontalAlignment>\r\n			<VerticalAlignment>Top</VerticalAlignment>\r\n			<TextFitMode>ShrinkToFit</TextFitMode>\r\n			<UseFullFontHeight>True</UseFullFontHeight>\r\n			<Verticalized>False</Verticalized>\r\n			<StyledText>\r\n				<Element>\r\n					<String>PCRT_YOUR_STORE_NAME</String>\r\n					<Attributes>\r\n						<Font Family="Arial" Size="10" Bold="False" Italic="False" Underline="False" Strikeout="False" />\r\n						<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n					</Attributes>\r\n				</Element>\r\n			</StyledText>\r\n		</TextObject>\r\n		<Bounds X="331" Y="76.5407725321887" Width="4350" Height="239.070386266094" />\r\n	</ObjectInfo>\r\n	<ObjectInfo>\r\n		<TextObject>\r\n			<Name>TEXT</Name>\r\n			<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n			<BackColor Alpha="0" Red="255" Green="255" Blue="255" />\r\n			<LinkedObjectName></LinkedObjectName>\r\n			<Rotation>Rotation0</Rotation>\r\n			<IsMirrored>False</IsMirrored>\r\n			<IsVariable>False</IsVariable>\r\n			<HorizontalAlignment>CenterBlock</HorizontalAlignment>\r\n			<VerticalAlignment>Top</VerticalAlignment>\r\n			<TextFitMode>ShrinkToFit</TextFitMode>\r\n			<UseFullFontHeight>True</UseFullFontHeight>\r\n			<Verticalized>False</Verticalized>\r\n			<StyledText>\r\n				<Element>\r\n					<String>PCRT_STORE_PHONE</String>\r\n					<Attributes>\r\n						<Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\r\n						<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n					</Attributes>\r\n				</Element>\r\n			</StyledText>\r\n		</TextObject>\r\n		<Bounds X="1064.39055793991" Y="327.618025751073" Width="2880" Height="221.523605150215" />\r\n	</ObjectInfo>\r\n	<ObjectInfo>\r\n		<TextObject>\r\n			<Name>TEXT_1</Name>\r\n			<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n			<BackColor Alpha="0" Red="255" Green="255" Blue="255" />\r\n			<LinkedObjectName></LinkedObjectName>\r\n			<Rotation>Rotation0</Rotation>\r\n			<IsMirrored>False</IsMirrored>\r\n			<IsVariable>False</IsVariable>\r\n			<HorizontalAlignment>CenterBlock</HorizontalAlignment>\r\n			<VerticalAlignment>Top</VerticalAlignment>\r\n			<TextFitMode>ShrinkToFit</TextFitMode>\r\n			<UseFullFontHeight>True</UseFullFontHeight>\r\n			<Verticalized>False</Verticalized>\r\n			<StyledText>\r\n				<Element>\r\n					<String>PCRT_CUSTOMER_NAME</String>\r\n					<Attributes>\r\n						<Font Family="Arial" Size="12" Bold="True" Italic="False" Underline="False" Strikeout="False" />\r\n						<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n					</Attributes>\r\n				</Element>\r\n			</StyledText>\r\n		</TextObject>\r\n		<Bounds X="1059.17596566523" Y="557.317596566524" Width="2880" Height="221.523605150215" />\r\n	</ObjectInfo>\r\n</DieCutLabel>', tempaddress = '<?xml version="1.0" encoding="utf-8"?>\r\n<DieCutLabel Version="8.0" Units="twips">\r\n	<PaperOrientation>Landscape</PaperOrientation>\r\n	<Id>Address</Id>\r\n	<PaperName>30252 Address</PaperName>\r\n	<DrawCommands>\r\n		<RoundRectangle X="0" Y="0" Width="1581" Height="5040" Rx="270" Ry="270" />\r\n	</DrawCommands>\r\n	<ObjectInfo>\r\n		<TextObject>\r\n			<Name>TEXT</Name>\r\n			<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n			<BackColor Alpha="0" Red="255" Green="255" Blue="255" />\r\n			<LinkedObjectName></LinkedObjectName>\r\n			<Rotation>Rotation0</Rotation>\r\n			<IsMirrored>False</IsMirrored>\r\n			<IsVariable>False</IsVariable>\r\n			<HorizontalAlignment>Left</HorizontalAlignment>\r\n			<VerticalAlignment>Top</VerticalAlignment>\r\n			<TextFitMode>ShrinkToFit</TextFitMode>\r\n			<UseFullFontHeight>True</UseFullFontHeight>\r\n			<Verticalized>False</Verticalized>\r\n			<StyledText>\r\n				<Element>\r\n					<String>PCRT_CUSTOMER_NAME</String>\r\n					<Attributes>\r\n						<Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\r\n						<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n					</Attributes>\r\n				</Element>\r\n			</StyledText>\r\n		</TextObject>\r\n		<Bounds X="331" Y="150" Width="4037.38197424893" Height="301.738197424893" />\r\n	</ObjectInfo>\r\n	<ObjectInfo>\r\n		<TextObject>\r\n			<Name>TEXT_1</Name>\r\n			<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n			<BackColor Alpha="0" Red="255" Green="255" Blue="255" />\r\n			<LinkedObjectName></LinkedObjectName>\r\n			<Rotation>Rotation0</Rotation>\r\n			<IsMirrored>False</IsMirrored>\r\n			<IsVariable>False</IsVariable>\r\n			<HorizontalAlignment>Left</HorizontalAlignment>\r\n			<VerticalAlignment>Top</VerticalAlignment>\r\n			<TextFitMode>ShrinkToFit</TextFitMode>\r\n			<UseFullFontHeight>True</UseFullFontHeight>\r\n			<Verticalized>False</Verticalized>\r\n			<StyledText>\r\n				<Element>\r\n					<String>PCRT_ADDRESS1</String>\r\n					<Attributes>\r\n						<Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\r\n						<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n					</Attributes>\r\n				</Element>\r\n			</StyledText>\r\n		</TextObject>\r\n		<Bounds X="331" Y="431.266094420601" Width="4037.38197424893" Height="301.738197424893" />\r\n	</ObjectInfo>\r\n	<ObjectInfo>\r\n		<TextObject>\r\n			<Name>TEXT_2</Name>\r\n			<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n			<BackColor Alpha="0" Red="255" Green="255" Blue="255" />\r\n			<LinkedObjectName></LinkedObjectName>\r\n			<Rotation>Rotation0</Rotation>\r\n			<IsMirrored>False</IsMirrored>\r\n			<IsVariable>False</IsVariable>\r\n			<HorizontalAlignment>Left</HorizontalAlignment>\r\n			<VerticalAlignment>Top</VerticalAlignment>\r\n			<TextFitMode>ShrinkToFit</TextFitMode>\r\n			<UseFullFontHeight>True</UseFullFontHeight>\r\n			<Verticalized>False</Verticalized>\r\n			<StyledText>\r\n				<Element>\r\n					<String>PCRT_ADDRESS2</String>\r\n					<Attributes>\r\n						<Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\r\n						<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n					</Attributes>\r\n				</Element>\r\n			</StyledText>\r\n		</TextObject>\r\n		<Bounds X="331" Y="717.746781115879" Width="4037.38197424893" Height="301.738197424893" />\r\n	</ObjectInfo>\r\n	<ObjectInfo>\r\n		<TextObject>\r\n			<Name>TEXT_3</Name>\r\n			<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n			<BackColor Alpha="0" Red="255" Green="255" Blue="255" />\r\n			<LinkedObjectName></LinkedObjectName>\r\n			<Rotation>Rotation0</Rotation>\r\n			<IsMirrored>False</IsMirrored>\r\n			<IsVariable>False</IsVariable>\r\n			<HorizontalAlignment>Left</HorizontalAlignment>\r\n			<VerticalAlignment>Top</VerticalAlignment>\r\n			<TextFitMode>ShrinkToFit</TextFitMode>\r\n			<UseFullFontHeight>True</UseFullFontHeight>\r\n			<Verticalized>False</Verticalized>\r\n			<StyledText>\r\n				<Element>\r\n					<String>PCRT_ADDRESS3</String>\r\n					<Attributes>\r\n						<Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\r\n						<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n					</Attributes>\r\n				</Element>\r\n			</StyledText>\r\n		</TextObject>\r\n		<Bounds X="331" Y="1032.87553648069" Width="4037.38197424893" Height="301.738197424893" />\r\n	</ObjectInfo>\r\n</DieCutLabel>', temppricetag = '<?xml version="1.0" encoding="utf-8"?>\r\n<DieCutLabel Version="8.0" Units="twips">\r\n	<PaperOrientation>Landscape</PaperOrientation>\r\n	<Id>Address</Id>\r\n	<PaperName>30252 Address</PaperName>\r\n	<DrawCommands>\r\n		<RoundRectangle X="0" Y="0" Width="1581" Height="5040" Rx="270" Ry="270" />\r\n	</DrawCommands>\r\n	<ObjectInfo>\r\n		<BarcodeObject>\r\n			<Name>Barcode</Name>\r\n			<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n			<BackColor Alpha="0" Red="255" Green="255" Blue="255" />\r\n			<LinkedObjectName></LinkedObjectName>\r\n			<Rotation>Rotation0</Rotation>\r\n			<IsMirrored>False</IsMirrored>\r\n			<IsVariable>True</IsVariable>\r\n			<Text>PCRTSTOCKID</Text>\r\n			<Type>Code39</Type>\r\n			<Size>Medium</Size>\r\n			<TextPosition>Bottom</TextPosition>\r\n			<TextFont Family="Arial" Size="12" Bold="True" Italic="False" Underline="False" Strikeout="False" />\r\n			<CheckSumFont Family="Arial" Size="7.3125" Bold="False" Italic="False" Underline="False" Strikeout="False" />\r\n			<TextEmbedding>None</TextEmbedding>\r\n			<ECLevel>0</ECLevel>\r\n			<HorizontalAlignment>Center</HorizontalAlignment>\r\n			<QuietZonesPadding Left="0" Top="0" Right="0" Bottom="0" />\r\n		</BarcodeObject>\r\n		<Bounds X="331" Y="817.403449717509" Width="4440.47265625" Height="675.596550282491" />\r\n	</ObjectInfo>\r\n	<ObjectInfo>\r\n		<TextObject>\r\n			<Name>Text</Name>\r\n			<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n			<BackColor Alpha="0" Red="255" Green="255" Blue="255" />\r\n			<LinkedObjectName></LinkedObjectName>\r\n			<Rotation>Rotation0</Rotation>\r\n			<IsMirrored>False</IsMirrored>\r\n			<IsVariable>True</IsVariable>\r\n			<HorizontalAlignment>Left</HorizontalAlignment>\r\n			<VerticalAlignment>Top</VerticalAlignment>\r\n			<TextFitMode>ShrinkToFit</TextFitMode>\r\n			<UseFullFontHeight>True</UseFullFontHeight>\r\n			<Verticalized>False</Verticalized>\r\n			<StyledText>\r\n				<Element>\r\n					<String>PCRT_STORE_NAME</String>\r\n					<Attributes>\r\n						<Font Family="Arial" Size="14" Bold="True" Italic="False" Underline="False" Strikeout="False" />\r\n						<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n					</Attributes>\r\n				</Element>\r\n			</StyledText>\r\n		</TextObject>\r\n		<Bounds X="331" Y="88" Width="3175.42918454936" Height="289.51932535458" />\r\n	</ObjectInfo>\r\n	<ObjectInfo>\r\n		<TextObject>\r\n			<Name>TEXT</Name>\r\n			<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n			<BackColor Alpha="0" Red="255" Green="255" Blue="255" />\r\n			<LinkedObjectName></LinkedObjectName>\r\n			<Rotation>Rotation0</Rotation>\r\n			<IsMirrored>False</IsMirrored>\r\n			<IsVariable>False</IsVariable>\r\n			<HorizontalAlignment>Left</HorizontalAlignment>\r\n			<VerticalAlignment>Top</VerticalAlignment>\r\n			<TextFitMode>ShrinkToFit</TextFitMode>\r\n			<UseFullFontHeight>True</UseFullFontHeight>\r\n			<Verticalized>False</Verticalized>\r\n			<StyledText>\r\n				<Element>\r\n					<String>PCRT_STOCK_NAME</String>\r\n					<Attributes>\r\n						<Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\r\n						<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n					</Attributes>\r\n				</Element>\r\n			</StyledText>\r\n		</TextObject>\r\n		<Bounds X="331" Y="402.103004291845" Width="3286.8025751073" Height="278.819742489271" />\r\n	</ObjectInfo>\r\n	<ObjectInfo>\r\n		<TextObject>\r\n			<Name>TEXT_1</Name>\r\n			<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n			<BackColor Alpha="0" Red="255" Green="255" Blue="255" />\r\n			<LinkedObjectName></LinkedObjectName>\r\n			<Rotation>Rotation0</Rotation>\r\n			<IsMirrored>False</IsMirrored>\r\n			<IsVariable>False</IsVariable>\r\n			<HorizontalAlignment>Left</HorizontalAlignment>\r\n			<VerticalAlignment>Top</VerticalAlignment>\r\n			<TextFitMode>ShrinkToFit</TextFitMode>\r\n			<UseFullFontHeight>True</UseFullFontHeight>\r\n			<Verticalized>False</Verticalized>\r\n			<StyledText>\r\n				<Element>\r\n					<String>PCRT_PRICE</String>\r\n					<Attributes>\r\n						<Font Family="Arial" Size="16" Bold="False" Italic="False" Underline="False" Strikeout="False" />\r\n						<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n					</Attributes>\r\n				</Element>\r\n			</StyledText>\r\n		</TextObject>\r\n		<Bounds X="3677.60944206009" Y="110.407725321888" Width="1241.330472103" Height="576.759656652361" />\r\n	</ObjectInfo>\r\n</DieCutLabel>', temppricetagserial = '<?xml version="1.0" encoding="utf-8"?>\r\n<DieCutLabel Version="8.0" Units="twips">\r\n	<PaperOrientation>Landscape</PaperOrientation>\r\n	<Id>Address</Id>\r\n	<PaperName>30252 Address</PaperName>\r\n	<DrawCommands>\r\n		<RoundRectangle X="0" Y="0" Width="1581" Height="5040" Rx="270" Ry="270" />\r\n	</DrawCommands>\r\n	<ObjectInfo>\r\n		<BarcodeObject>\r\n			<Name>Barcode</Name>\r\n			<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n			<BackColor Alpha="0" Red="255" Green="255" Blue="255" />\r\n			<LinkedObjectName></LinkedObjectName>\r\n			<Rotation>Rotation0</Rotation>\r\n			<IsMirrored>False</IsMirrored>\r\n			<IsVariable>True</IsVariable>\r\n			<Text>PCRTSTOCKID</Text>\r\n			<Type>Code39</Type>\r\n			<Size>Medium</Size>\r\n			<TextPosition>Bottom</TextPosition>\r\n			<TextFont Family="Arial" Size="12" Bold="True" Italic="False" Underline="False" Strikeout="False" />\r\n			<CheckSumFont Family="Arial" Size="7.3125" Bold="False" Italic="False" Underline="False" Strikeout="False" />\r\n			<TextEmbedding>None</TextEmbedding>\r\n			<ECLevel>0</ECLevel>\r\n			<HorizontalAlignment>Center</HorizontalAlignment>\r\n			<QuietZonesPadding Left="0" Top="0" Right="0" Bottom="0" />\r\n		</BarcodeObject>\r\n		<Bounds X="331" Y="1000.75109863281" Width="4440.47265625" Height="492.248901367188" />\r\n	</ObjectInfo>\r\n	<ObjectInfo>\r\n		<TextObject>\r\n			<Name>Text</Name>\r\n			<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n			<BackColor Alpha="0" Red="255" Green="255" Blue="255" />\r\n			<LinkedObjectName></LinkedObjectName>\r\n			<Rotation>Rotation0</Rotation>\r\n			<IsMirrored>False</IsMirrored>\r\n			<IsVariable>True</IsVariable>\r\n			<HorizontalAlignment>Left</HorizontalAlignment>\r\n			<VerticalAlignment>Top</VerticalAlignment>\r\n			<TextFitMode>ShrinkToFit</TextFitMode>\r\n			<UseFullFontHeight>True</UseFullFontHeight>\r\n			<Verticalized>False</Verticalized>\r\n			<StyledText>\r\n				<Element>\r\n					<String>PCRT_STORE_NAME</String>\r\n					<Attributes>\r\n						<Font Family="Arial" Size="14" Bold="True" Italic="False" Underline="False" Strikeout="False" />\r\n						<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n					</Attributes>\r\n				</Element>\r\n			</StyledText>\r\n		</TextObject>\r\n		<Bounds X="331" Y="88" Width="3146.78111587983" Height="289.519317626953" />\r\n	</ObjectInfo>\r\n	<ObjectInfo>\r\n		<TextObject>\r\n			<Name>TEXT</Name>\r\n			<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n			<BackColor Alpha="0" Red="255" Green="255" Blue="255" />\r\n			<LinkedObjectName></LinkedObjectName>\r\n			<Rotation>Rotation0</Rotation>\r\n			<IsMirrored>False</IsMirrored>\r\n			<IsVariable>False</IsVariable>\r\n			<HorizontalAlignment>Left</HorizontalAlignment>\r\n			<VerticalAlignment>Top</VerticalAlignment>\r\n			<TextFitMode>ShrinkToFit</TextFitMode>\r\n			<UseFullFontHeight>True</UseFullFontHeight>\r\n			<Verticalized>False</Verticalized>\r\n			<StyledText>\r\n				<Element>\r\n					<String>PCRT_STOCK_NAME</String>\r\n					<Attributes>\r\n						<Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\r\n						<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n					</Attributes>\r\n				</Element>\r\n			</StyledText>\r\n		</TextObject>\r\n		<Bounds X="348.188841201717" Y="453.669520431322" Width="3155.02157343918" Height="278.819732666016" />\r\n	</ObjectInfo>\r\n	<ObjectInfo>\r\n		<TextObject>\r\n			<Name>TEXT_1</Name>\r\n			<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n			<BackColor Alpha="0" Red="255" Green="255" Blue="255" />\r\n			<LinkedObjectName></LinkedObjectName>\r\n			<Rotation>Rotation0</Rotation>\r\n			<IsMirrored>False</IsMirrored>\r\n			<IsVariable>False</IsVariable>\r\n			<HorizontalAlignment>Left</HorizontalAlignment>\r\n			<VerticalAlignment>Top</VerticalAlignment>\r\n			<TextFitMode>ShrinkToFit</TextFitMode>\r\n			<UseFullFontHeight>True</UseFullFontHeight>\r\n			<Verticalized>False</Verticalized>\r\n			<StyledText>\r\n				<Element>\r\n					<String>PCRT_PRICE</String>\r\n					<Attributes>\r\n						<Font Family="Arial" Size="16" Bold="False" Italic="False" Underline="False" Strikeout="False" />\r\n						<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n					</Attributes>\r\n				</Element>\r\n			</StyledText>\r\n		</TextObject>\r\n		<Bounds X="3568.42919188405" Y="93.2188698437081" Width="1269.97853343784" Height="513.733895756145" />\r\n	</ObjectInfo>\r\n	<ObjectInfo>\r\n		<TextObject>\r\n			<Name>TEXT_2</Name>\r\n			<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n			<BackColor Alpha="0" Red="255" Green="255" Blue="255" />\r\n			<LinkedObjectName></LinkedObjectName>\r\n			<Rotation>Rotation0</Rotation>\r\n			<IsMirrored>False</IsMirrored>\r\n			<IsVariable>False</IsVariable>\r\n			<HorizontalAlignment>Center</HorizontalAlignment>\r\n			<VerticalAlignment>Top</VerticalAlignment>\r\n			<TextFitMode>ShrinkToFit</TextFitMode>\r\n			<UseFullFontHeight>True</UseFullFontHeight>\r\n			<Verticalized>False</Verticalized>\r\n			<StyledText>\r\n				<Element>\r\n					<String>PCRT_SERIAL_NUMBER</String>\r\n					<Attributes>\r\n						<Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\r\n						<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n					</Attributes>\r\n				</Element>\r\n			</StyledText>\r\n		</TextObject>\r\n		<Bounds X="360.1630859375" Y="712.017150878906" Width="4398.34765625" Height="232.982833862305" />\r\n	</ObjectInfo>\r\n</DieCutLabel>'
TEMPLATESQL;



$sql116 = "CREATE TABLE wonotes (
  noteid int(11) NOT NULL auto_increment,
  notetype int(11) NOT NULL,
  thenote mediumtext NOT NULL,
  noteuser text NOT NULL,
  notetime datetime NOT NULL,
  woid int(11) NOT NULL,
  UNIQUE KEY noteid (noteid),
  KEY notetype (notetype),
  KEY woid (woid)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";



###


@mysql_query($sql1, $rs_connect);
@mysql_query($sql2, $rs_connect);
@mysql_query($sql3, $rs_connect);
@mysql_query($sql4, $rs_connect);
@mysql_query($sql5, $rs_connect);
@mysql_query($sql6, $rs_connect);
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
@mysql_query($sql17, $rs_connect);
@mysql_query($sql18, $rs_connect);
@mysql_query($sql19, $rs_connect);
@mysql_query($sql20, $rs_connect);
@mysql_query($sql21, $rs_connect);
@mysql_query($sql22, $rs_connect);
@mysql_query($sql23, $rs_connect);
@mysql_query($sql24, $rs_connect);
@mysql_query($sql25, $rs_connect);
@mysql_query($sql26, $rs_connect);
@mysql_query($sql27, $rs_connect);
@mysql_query($sql28, $rs_connect);
@mysql_query($sql29, $rs_connect);
@mysql_query($sql30, $rs_connect);
@mysql_query($sql31, $rs_connect);
@mysql_query($sql32, $rs_connect);
@mysql_query($sql33, $rs_connect);
@mysql_query($sql34, $rs_connect);
@mysql_query($sql35, $rs_connect);
@mysql_query($sql36, $rs_connect);
@mysql_query($sql37, $rs_connect);
@mysql_query($sql38, $rs_connect);
@mysql_query($sql39, $rs_connect);
@mysql_query($sql40, $rs_connect);
@mysql_query($sql41, $rs_connect);
@mysql_query($sql42, $rs_connect);
@mysql_query($sql43, $rs_connect);
@mysql_query($sql44, $rs_connect);
@mysql_query($sql45, $rs_connect);
@mysql_query($sql46, $rs_connect);
@mysql_query($sql47, $rs_connect);
@mysql_query($sql48, $rs_connect);
@mysql_query($sql49, $rs_connect);
@mysql_query($sql50, $rs_connect);
@mysql_query($sql51, $rs_connect);
@mysql_query($sql52_2, $rs_connect);
@mysql_query($sql53, $rs_connect);
@mysql_query($sql54, $rs_connect);
@mysql_query($sql55, $rs_connect);
@mysql_query($sql56, $rs_connect);
@mysql_query($sql57, $rs_connect);
@mysql_query($sql58, $rs_connect);
@mysql_query($sql59, $rs_connect);
@mysql_query($sql60, $rs_connect);
@mysql_query($sql61, $rs_connect);
@mysql_query($sql62, $rs_connect);
@mysql_query($sql63, $rs_connect);
@mysql_query($sql64, $rs_connect);
@mysql_query($sql65, $rs_connect);
@mysql_query($sql66, $rs_connect);
@mysql_query($sql67, $rs_connect);
@mysql_query($sql68, $rs_connect);
@mysql_query($sql69, $rs_connect);
@mysql_query($sql70, $rs_connect);
@mysql_query($sql71, $rs_connect);
@mysql_query($sql72, $rs_connect);
@mysql_query($sql73, $rs_connect);
@mysql_query($sql74, $rs_connect);
@mysql_query($sql75, $rs_connect);
@mysql_query($sql76, $rs_connect);
@mysql_query($sql77, $rs_connect);
@mysql_query($sql77_1, $rs_connect);
@mysql_query($sql77_2, $rs_connect);
@mysql_query($sql78, $rs_connect);
@mysql_query($sql79, $rs_connect);
@mysql_query($sql80, $rs_connect);
@mysql_query($sql81, $rs_connect);
@mysql_query($sql82, $rs_connect);
@mysql_query($sql83, $rs_connect);
@mysql_query($sql84, $rs_connect);
@mysql_query($sql85, $rs_connect);
@mysql_query($sql86, $rs_connect);
@mysql_query($sql87, $rs_connect);
@mysql_query($sql88, $rs_connect);
@mysql_query($sql89, $rs_connect);
@mysql_query($sql90, $rs_connect);
@mysql_query($sql91, $rs_connect);
@mysql_query($sql92, $rs_connect);
@mysql_query($sql93, $rs_connect);
@mysql_query($sql94, $rs_connect);
@mysql_query($sql95, $rs_connect);
@mysql_query($sql96, $rs_connect);
@mysql_query($sql97, $rs_connect);
@mysql_query($sql98, $rs_connect);
@mysql_query($sql99, $rs_connect);
@mysql_query($sql100, $rs_connect);
@mysql_query($sql101, $rs_connect);
@mysql_query($sql102, $rs_connect);
@mysql_query($sql103, $rs_connect);
@mysql_query($sql104, $rs_connect);
@mysql_query($sql105, $rs_connect);
@mysql_query($sql106, $rs_connect);
@mysql_query($sql107, $rs_connect);
@mysql_query($sql108, $rs_connect);
@mysql_query($sql109, $rs_connect);
@mysql_query($sql110, $rs_connect);
@mysql_query($sql111, $rs_connect);
@mysql_query($sql112, $rs_connect);
@mysql_query($sql113, $rs_connect);
@mysql_query($sql114, $rs_connect);
@mysql_query($sql115, $rs_connect);
@mysql_query($sql116, $rs_connect);


$rs_findpc = "SELECT * FROM pc_wo";
$rs_result = mysql_query($rs_findpc, $rs_connect);

while($rs_result_q = mysql_fetch_object($rs_result)) {
$technotes = pv("$rs_result_q->technotes");
$custnotes = pv("$rs_result_q->custnotes");
$notesbyuser = pv("$rs_result_q->notesbyuser");
$dropdate = "$rs_result_q->dropdate";
$woid = "$rs_result_q->woid";


if($technotes != "") {
$rs_findpew = "SELECT * FROM wonotes WHERE woid = '$woid' AND notetype = 1";
$rs_resultew = mysql_query($rs_findpew, $rs_connect);
if (mysql_num_rows($rs_resultew) == "0") {
$instech = "INSERT INTO wonotes (notetype,thenote,noteuser,notetime,woid) VALUES ('1','$technotes','$notesbyuser','$dropdate','$woid')";
@mysql_query($instech, $rs_connect);
}
}

if($custnotes != "") {
$rs_findpew2 = "SELECT * FROM wonotes WHERE woid = '$woid' AND notetype = 0";
$rs_resultew2 = mysql_query($rs_findpew2, $rs_connect);
if (mysql_num_rows($rs_resultew2) == "0") {
$inscust = "INSERT INTO wonotes (notetype,thenote,noteuser,notetime,woid) VALUES ('0','$custnotes','$notesbyuser','$dropdate','$woid')";
@mysql_query($inscust, $rs_connect);
}
}

}



header("Location: databaseupgrade-1.36to1.37.php?func=do_upgrade2");
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
