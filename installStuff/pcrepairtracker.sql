
SET NAMES utf8;
SET SESSION sql_mode='';

-- 
-- Database: `pcrt`
-- 



CREATE TABLE IF NOT EXISTS `absenses` (
  `abid` int(11) NOT NULL AUTO_INCREMENT,
  `abdate` datetime NOT NULL,
  `abreason` int(11) NOT NULL DEFAULT '0',
  `eid` int(11) NOT NULL,
  `abnotes` text NOT NULL,
  PRIMARY KEY (`abid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



-- --------------------------------------------------------

CREATE TABLE `assetphotos` (
  `assetphotoid` int(11) NOT NULL auto_increment,
  `pcid` int(11) NOT NULL,
  `photofilename` text NOT NULL,
  `highlight` int(11) NOT NULL default '0',
  PRIMARY KEY  (`assetphotoid`)
) ENGINE=MyISAM ;


-- 
-- Table structure for table `attachments`
-- 

CREATE TABLE IF NOT EXISTS `attachments` (
  `attach_id` int(11) NOT NULL AUTO_INCREMENT,
  `attach_title` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `attach_filename` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `attach_size` int(11) NOT NULL,
  `attach_dcount` int(11) NOT NULL,
  `attach_keywords` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `pcid` int(11) NOT NULL,
  `woid` int(11) NOT NULL,
  `groupid` int(11) NOT NULL,
  `scid` int(11) NOT NULL DEFAULT '0',
  `attach_cat` int(11) NOT NULL,
  `attach_date` datetime NOT NULL,
  UNIQUE KEY `attach_id` (`attach_id`),
  KEY `woid` (`woid`),
  KEY `pcid` (`pcid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;




CREATE TABLE `benches` (
  `benchid` int(11) NOT NULL auto_increment,
  `benchname` mediumtext collate utf8_unicode_ci NOT NULL,
  `benchcolor` mediumtext collate utf8_unicode_ci NOT NULL,
  `storeid` int(11) NOT NULL,
  UNIQUE KEY `benchid` (`benchid`),
  KEY `storeid` (`storeid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
-- 
-- Dumping data for table `benches`
-- 

INSERT INTO `benches` (`benchid`, `benchname`, `benchcolor`, `storeid`) VALUES (1, 'North Bench', 'f6f6f6', 1),
(2, 'South Bench', 'd4d4ff', 1),
(3, 'Laptop Bench', 'fff4c6', 1),
(4, 'East Bench', 'b0ffa5', 1);




-- --------------------------------------------------------

-- 
-- Table structure for table `blockcontract`
-- 

CREATE TABLE `blockcontract` (
  `blockid` int(11) NOT NULL auto_increment,
  `blocktitle` text NOT NULL,
  `blocknote` text NOT NULL,
  `blockstart` date NOT NULL,
  `pcgroupid` int(11) NOT NULL default '0',
  `contractclosed` int(11) NOT NULL default '0',
  `hourscache` float(11,2) NOT NULL default '0.00',
  UNIQUE KEY `blockid` (`blockid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `blockcontracthours`
-- 

CREATE TABLE `blockcontracthours` (
  `blockcontracthoursid` int(11) NOT NULL auto_increment,
  `blockhours` float(11,2) NOT NULL,
  `blockhoursdate` date NOT NULL,
  `blockcontractid` int(11) NOT NULL,
  `invoiceid` int(11) NOT NULL,
  UNIQUE KEY `blockcontractid` (`blockcontracthoursid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;




-- --------------------------------------------------------

-- 
-- Table structure for table `boxstyles`
-- 

CREATE TABLE IF NOT EXISTS `boxstyles` (
  `statusid` int(11) NOT NULL,
  `selectorcolor` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `boxtitle` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `displayedstatus` int(11) NOT NULL DEFAULT '1',
  `selectablestatus` int(11) NOT NULL DEFAULT '1',
  `displayedorder` int(11) NOT NULL DEFAULT '1000',
  `statusoptions` text COLLATE utf8_unicode_ci NOT NULL,
  `collapsedstatus` int(11) NOT NULL DEFAULT '0',
  KEY `statusid` (`statusid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `boxstyles`
--

INSERT INTO `boxstyles` (`statusid`, `selectorcolor`, `boxtitle`, `displayedstatus`, `selectablestatus`, `displayedorder`, `statusoptions`) VALUES
(2, '0050ef', 'On the Bench', 1, 1, 0, 'a:18:{i:0;s:8:"bcompany";i:1;s:6:"bwoids";i:2;s:9:"bskedjobs";i:3;s:10:"bassettype";i:4;s:11:"bdaysinshop";i:5;s:9:"bpassword";i:6;s:9:"bmakeicon";i:7;s:12:"bstatuscheck";i:8;s:15:"bdevicepriority";i:9;s:4:"bmsp";i:10;s:8:"eproblem";i:11;s:13:"eassigneduser";i:12;s:12:"estatuscheck";i:13;s:4:"emsp";i:14;s:9:"workbench";i:15;s:8:"mcompany";i:16;s:9:"mskedjobs";i:17;s:4:"mmsp";}'),
(52, '0050ef', 'Invoice List Box', 0, 0, 1000, ''),
(53, 'e51400', 'Overdue Invoice Box', 0, 0, 1000, ''),
(1, '003aae', 'Waiting for Bench', 1, 1, 20, 'a:10:{i:0;s:8:"bcompany";i:1;s:9:"bskedjobs";i:2;s:10:"bassettype";i:3;s:11:"bdaysinshop";i:4;s:9:"bmakeicon";i:5;s:12:"bstatuscheck";i:6;s:4:"bmsp";i:7;s:8:"eproblem";i:8;s:12:"estatuscheck";i:9;s:4:"emsp";}'),
(3, 'e51400', 'Pending / On Hold', 1, 1, 25, 'a:7:{i:0;s:8:"bcompany";i:1;s:11:"bdaysinshop";i:2;s:17:"bpreferredcontact";i:3;s:9:"bmakeicon";i:4;s:8:"eproblem";i:5;s:6:"enotes";i:6;s:7:"ecnotes";}'),
(4, '008800', 'Completed/Ready for Pickup', 1, 1, 35, 'a:14:{i:0;s:8:"bcompany";i:1;s:6:"bwoids";i:2;s:10:"bassettype";i:3;s:11:"bdaysinshop";i:4;s:11:"brepaircart";i:5;s:17:"bpreferredcontact";i:6;s:9:"bmakeicon";i:7;s:12:"bstatuscheck";i:8;s:15:"bdevicepriority";i:9;s:8:"eproblem";i:10;s:6:"enotes";i:11;s:7:"ecnotes";i:12;s:13:"eassigneduser";i:13;s:12:"estatuscheck";}'),
(5, '8e0f05', 'Picked up by Customer', 0, 1, 30, ''),
(6, 'e51400', 'Waiting for Payment', 1, 1, 55, 'a:6:{i:0;s:8:"bcompany";i:1;s:11:"bdaysinshop";i:2;s:11:"brepaircart";i:3;s:9:"bmakeicon";i:4;s:6:"enotes";i:5;s:10:"eassettype";}'),
(7, 'aa00ff', 'Ready to Sell', 0, 1, 60, ''),
(8, 'ff8000', 'On Service Call', 1, 1, 5, 'a:5:{i:0;s:8:"eproblem";i:1;s:6:"enotes";i:2;s:7:"ecnotes";i:3;s:10:"epasswords";i:4;s:10:"eassettype";}'),
(9, 'dd006f', 'Remote Support Sessions', 1, 1, 15, 'a:9:{i:0;s:8:"bcompany";i:1;s:9:"bskedjobs";i:2;s:9:"bpassword";i:3;s:13:"bassigneduser";i:4;s:17:"bpreferredcontact";i:5;s:8:"eproblem";i:6;s:6:"enotes";i:7;s:7:"ecnotes";i:8;s:10:"eassettype";}'),
(50, '000000', 'Standard Title Boxes', 0, 0, 1000, ''),
(51, '4b4b4b', 'Standard Inventory Title Boxes', 0, 0, 1000, ''),
(101, 'a4c400', 'Waiting for Parts', 1, 1, 45, '');



-- 
-- Table structure for table `cart`
-- 

CREATE TABLE IF NOT EXISTS `cart` (
  `cart_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `cart_price` decimal(20,5) NOT NULL DEFAULT '0.00000',
  `cart_type` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `cart_stock_id` int(11) NOT NULL DEFAULT '0',
  `labor_desc` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `return_sold_id` int(11) NOT NULL DEFAULT '0',
  `restocking_fee` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `price_alt` int(11) NOT NULL DEFAULT '0',
  `addtime` int(11) NOT NULL,
  `ipofpc` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `taxex` int(11) NOT NULL,
  `itemtax` decimal(11,5) NOT NULL,
  `origprice` decimal(11,5) NOT NULL,
  `discounttype` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `ourprice` decimal(11,5) NOT NULL DEFAULT '0.00000',
  `itemserial` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `quantity` decimal(11,2) NOT NULL DEFAULT '1.00',
  `unit_price` decimal(11,5) NOT NULL DEFAULT '0.00000',
  `printdesc` text COLLATE utf8_unicode_ci NOT NULL,
  `discountname` text COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `cart_item_id` (`cart_item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `checks`
--

CREATE TABLE `checks` (
  `checkid` int(11) NOT NULL AUTO_INCREMENT,
  `checkname` text NOT NULL,
  PRIMARY KEY (`checkid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


INSERT INTO `checks` (`checkid`, `checkname`) VALUES
(2, 'Wifi'),
(3, 'Wired Network Adapter'),
(4, 'Safe Browser Homepage'),
(5, 'Missing Drivers'),
(6, 'Hard Drive Smart Test'),
(7, 'PUP Toolbars'),
(8, 'Sound'),
(9, 'DVD Drive'),
(10, 'Touchscreen'),
(11, 'Power Jack'),
(12, 'USB Ports'),
(13, 'Screen Hinges'),
(14, 'Battery'),
(15, 'No Malicious Browser Extensions'),
(16, 'Updates Current'),
(17, 'Current Anti-Virus'),
(18, 'Drive under 10% Fragmentation');



-- --------------------------------------------------------


-- 
-- Table structure for table `claimsigtext`
-- 

CREATE TABLE `claimsigtext` (
  `sigtextid` int(11) NOT NULL auto_increment,
  `sigtext` mediumtext collate utf8_unicode_ci NOT NULL,
  `woid` int(11) NOT NULL,
  PRIMARY KEY  (`sigtextid`),
  KEY `woid` (`woid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;



--
-- Table structure for table `creds`
--

CREATE TABLE IF NOT EXISTS `creds` (
  `credid` int(11) NOT NULL AUTO_INCREMENT,
  `creddesc` text NOT NULL,
  `creduser` text NOT NULL,
  `credpass` text NOT NULL,
  `patterndata` text NOT NULL,
  `groupid` int(11) NOT NULL DEFAULT '0',
  `pcid` int(11) NOT NULL DEFAULT '0',
  `credq` text NOT NULL,
  `creda` text NOT NULL,
  `credtype` int(11) NOT NULL DEFAULT '1',
  `creddate` datetime NOT NULL,
  PRIMARY KEY (`credid`),
  KEY `groupid` (`groupid`),
  KEY `pcid` (`pcid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `creddesc` (
  `creddescid` int(11) NOT NULL AUTO_INCREMENT,
  `credtitle` text NOT NULL,
  `creddescorder` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`creddescid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


INSERT INTO `creddesc` (`creddescid`, `credtitle`, `creddescorder`) VALUES
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
(11, 'Server Share', 25);


-- 
-- Table structure for table `commonproblems`
-- 

CREATE TABLE `commonproblems` (
  `probid` int(11) NOT NULL auto_increment,
  `theproblem` mediumtext collate utf8_unicode_ci NOT NULL,
  `custviewable` int(11) NOT NULL default '0',
  UNIQUE KEY `probid` (`probid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
-- 
-- Dumping data for table `commonproblems`
-- 

INSERT INTO `commonproblems` (`probid`, `theproblem`) VALUES (1, 'Virus/Rogue Cleaning'),
(3, 'Tuneup'),
(4, 'Backup Important Data First'),
(5, 'Reload Operating System'),
(6, 'Install New AntiVirus'),
(7, 'Internal Physical Cleaning'),
(8, 'Replace Bad Capacitors'),
(9, 'Computer does not Boot'),
(10, 'Computer does not power on'),
(11, 'Replace Bad LCD Screen'),
(15, 'Internet Doesn''t Work'),
(13, 'Computer has noisy fan'),
(16, 'Blue Screening'),
(17, 'Upgrade Memory');


-- --------------------------------------------------------

-- 
-- Table structure for table `currentcustomer`
-- 


CREATE TABLE `currentcustomer` (
  `cfirstname` mediumtext collate utf8_unicode_ci NOT NULL,
  `caddress` mediumtext collate utf8_unicode_ci NOT NULL,
  `caddress2` mediumtext collate utf8_unicode_ci NOT NULL,
  `ccity` mediumtext collate utf8_unicode_ci NOT NULL,
  `cstate` mediumtext collate utf8_unicode_ci NOT NULL,
  `czip` mediumtext collate utf8_unicode_ci NOT NULL,
  `cphone` mediumtext collate utf8_unicode_ci NOT NULL,
  `cemail` mediumtext collate utf8_unicode_ci NOT NULL,
  `byuser` mediumtext collate utf8_unicode_ci NOT NULL,
  `woid` text collate utf8_unicode_ci NOT NULL,
  `invoiceid` text collate utf8_unicode_ci NOT NULL,
  `pcgroupid` int(11) NOT NULL default '0',
  `rinvoiceid` int(11) NOT NULL default '0',
  `ccompany` mediumtext collate utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Table structure for table `currentpayments`
-- 

CREATE TABLE `currentpayments` (
  `paymentid` int(11) NOT NULL auto_increment,
  `pfirstname` mediumtext collate utf8_unicode_ci NOT NULL,
  `plastname` mediumtext collate utf8_unicode_ci NOT NULL,
  `paddress` mediumtext collate utf8_unicode_ci NOT NULL,
  `paddress2` mediumtext collate utf8_unicode_ci NOT NULL,
  `pcity` mediumtext collate utf8_unicode_ci NOT NULL,
  `pstate` mediumtext collate utf8_unicode_ci NOT NULL,
  `pzip` mediumtext collate utf8_unicode_ci NOT NULL,
  `pphone` mediumtext collate utf8_unicode_ci NOT NULL,
  `pemail` mediumtext collate utf8_unicode_ci NOT NULL,
  `byuser` mediumtext collate utf8_unicode_ci NOT NULL,
  `amount` decimal(11,5) NOT NULL,
  `paymentplugin` mediumtext collate utf8_unicode_ci NOT NULL,
  `cc_number` mediumtext collate utf8_unicode_ci NOT NULL,
  `cc_expmonth` int(11) NOT NULL,
  `cc_expyear` int(11) NOT NULL,
  `cc_transid` mediumtext collate utf8_unicode_ci NOT NULL,
  `cc_confirmation` mediumtext collate utf8_unicode_ci NOT NULL,
  `cc_cid` int(11) NOT NULL,
  `cc_track1` mediumtext collate utf8_unicode_ci NOT NULL,
  `cc_track2` mediumtext collate utf8_unicode_ci NOT NULL,
  `chk_dl` mediumtext collate utf8_unicode_ci NOT NULL,
  `chk_number` mediumtext collate utf8_unicode_ci NOT NULL,
  `paymentstatus` mediumtext collate utf8_unicode_ci NOT NULL,
  `paymenttype` mediumtext collate utf8_unicode_ci NOT NULL,
  `cc_cardtype` mediumtext collate utf8_unicode_ci NOT NULL,
  `custompaymentinfo` mediumtext collate utf8_unicode_ci NOT NULL,
  `isdeposit` int(11) NOT NULL default '0',
  `depositid` int(11) NOT NULL default '0',
  `pcompany` mediumtext collate utf8_unicode_ci NOT NULL,
  `cashchange` text collate utf8_unicode_ci NOT NULL,
  UNIQUE KEY `paymentid` (`paymentid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;




-- 
-- Table structure for table `custsource`
-- 

CREATE TABLE `custsource` (
  `custsourceid` int(11) NOT NULL auto_increment,
  `thesource` mediumtext collate utf8_unicode_ci NOT NULL,
  `sourceenabled` int(11) NOT NULL default '1',
  `sourceicon` mediumtext collate utf8_unicode_ci NOT NULL,
  `showonreport` int(11) NOT NULL default '1',
  PRIMARY KEY  (`custsourceid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `custsource`
-- 

INSERT INTO `custsource` (`custsourceid`, `thesource`, `sourceenabled`, `sourceicon`, `showonreport`) VALUES (1, 'Yellow Pages', 1, 'yp.png', 1),
(2, 'Website', 1, 'www.png', 1),
(3, 'Unknown', 1, 'unknown.png', 0),
(4, 'Word of Mouth Referral', 1, 'wordofmouth.png', 1),
(5, 'Billboard Advertising', 1, 'billboard.png', 1),
(6, 'Email or Mailed Newsletter', 1, 'emailornewsletter.png', 1),
(7, 'Social Network Referral', 1, 'facebook.png', 1),
(8, 'Flyer', 1, 'flyer.png', 1),
(9, 'Google Adwords', 1, 'googleadwords.png', 1),
(10, 'Business Networking', 1, 'linkedin.png', 1),
(11, 'Phone Book', 1, 'phonebook.png', 1),
(12, 'Existing Customer', 1, 'regularcustomer.png', 0),
(13, 'Sponsorship Advertising', 1, 'sponsor.png', 1),
(14, 'Store Drive By', 1, 'storedriveby.png', 1),
(15, 'Newspaper Advertising ', 1, 'newspaper.png', 1);



-- --------------------------------------------------------


--
-- Table structure for table `denoms`
--

CREATE TABLE `denoms` (
  `denomid` int(11) NOT NULL AUTO_INCREMENT,
  `denomvalue` decimal(11,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`denomid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


INSERT INTO `denoms` (`denomid`, `denomvalue`) VALUES
(1, '0.05'),
(12, '0.01'),
(3, '0.25'),
(4, '0.10'),
(5, '0.50'),
(6, '1.00'),
(7, '5.00'),
(8, '10.00'),
(9, '20.00'),
(10, '50.00'),
(11, '100.00');


--
-- Table structure for table `deposits`
--

CREATE TABLE IF NOT EXISTS `deposits` (
  `depositid` int(11) NOT NULL AUTO_INCREMENT,
  `pfirstname` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `plastname` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `paddress` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `paddress2` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `pcity` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `pstate` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `pzip` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `pphone` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `pemail` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `byuser` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(11,5) NOT NULL,
  `paymentplugin` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `cc_number` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `cc_expmonth` int(11) NOT NULL,
  `cc_expyear` int(11) NOT NULL,
  `cc_transid` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `cc_confirmation` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `cc_cid` int(11) NOT NULL,
  `cc_track1` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `cc_track2` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `chk_dl` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `chk_number` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `paymentstatus` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `paymenttype` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `cc_cardtype` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custompaymentinfo` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `woid` int(11) NOT NULL,
  `receipt_id` int(11) NOT NULL,
  `dstatus` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `depdate` datetime NOT NULL,
  `applieddate` datetime NOT NULL,
  `storeid` int(11) NOT NULL,
  `appliedstoreid` int(11) NOT NULL,
  `thesig` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `showsigdep` int(11) NOT NULL DEFAULT '1',
  `thesigtopaz` text COLLATE utf8_unicode_ci NOT NULL,
  `showsigdeptopaz` int(11) NOT NULL DEFAULT '1',
  `pcompany` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `cashchange` text COLLATE utf8_unicode_ci NOT NULL,
  `cashchange2` text COLLATE utf8_unicode_ci NOT NULL,
  `invoiceid` int(11) NOT NULL DEFAULT '0',
  `parentdeposit` int(11) NOT NULL DEFAULT '0',
  `registerid` int(11) NOT NULL DEFAULT '0',
  `aregisterid` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `depositid` (`depositid`),
  KEY `woid` (`woid`),
  KEY `receipt_id` (`receipt_id`),
  KEY `invoiceid` (`invoiceid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1000 ;



CREATE TABLE IF NOT EXISTS `discounts` (
  `discountid` int(11) NOT NULL AUTO_INCREMENT,
  `discounttitle` text NOT NULL,
  `discountamount` decimal(11,5) NOT NULL,
  `discounttype` int(11) NOT NULL DEFAULT '1',
  `theorder` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`discountid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;


INSERT INTO `discounts` (`discountid`, `discounttitle`, `discountamount`, `discounttype`, `theorder`) VALUES
(1, '5% Off', '5.00000', 1, 15),
(2, '$10 Off', '10.00000', 2, 5),
(3, 'Returning Customer Discount', '10.00000', 1, 25),
(11, 'Customer Referral Discount', '15.00000', 1, 20),
(12, '10% Off', '10.00000', 1, 10),
(13, '$20 Off', '20.00000', 2, 0);



CREATE TABLE IF NOT EXISTS `docphotos` (
  `docphotoid` int(11) NOT NULL AUTO_INCREMENT,
  `docphotofilename` varchar(200) NOT NULL,
  `docphotoarchived` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`docphotoid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `doctemplates` (
  `doctemplateid` int(11) NOT NULL AUTO_INCREMENT,
  `doctemplatename` text NOT NULL,
  `doctemplatecreated` datetime NOT NULL,
  `doctemplate` text NOT NULL,
  PRIMARY KEY (`doctemplateid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `documents` (
  `documentid` int(11) NOT NULL AUTO_INCREMENT,
  `documentname` text NOT NULL,
  `documenttemplate` text NOT NULL,
  `groupid` int(11) NOT NULL DEFAULT '0',
  `pcid` int(11) NOT NULL DEFAULT '0',
  `scid` int(11) NOT NULL DEFAULT '0',
  `thesig` text NOT NULL,
  `thesigtopaz` text NOT NULL,
  `showinportal` int(11) NOT NULL DEFAULT '0',
  `signeddatetime` datetime NOT NULL,
  PRIMARY KEY (`documentid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;





-- 
-- Table structure for table `frameit`
-- 

CREATE TABLE `frameit` (
  `frameitid` int(11) NOT NULL auto_increment,
  `frameitname` mediumtext collate utf8_unicode_ci NOT NULL,
  `frameiturl` mediumtext collate utf8_unicode_ci NOT NULL,
  UNIQUE KEY `frameitid` (`frameitid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `frameit`
-- 

INSERT INTO `frameit` (`frameitid`, `frameitname`, `frameiturl`) VALUES (6, 'Ninite', 'http://www.ninite.com'),
(12, 'Blacklist Check', 'http://www.mxtoolbox.com/blacklists.aspx'),
(11, 'Acer Support', 'http://us.acer.com/ac/en/US/content/support'),
(7, 'Speedtest', 'http://www.speedtest.net'),
(8, 'Dell Warranty', 'http://support.dell.com/support/topics/global.aspx/support/my_systems_info/details'),
(9, 'HP Warranty', 'http://h10025.www1.hp.com/ewfrf/wc/weInput?cc=us&lc=en'),
(10, 'Toshiba Warranty', 'http://www.warranty.toshiba.com');



-- --------------------------------------------------------

--
-- Table structure for table `gl`
--

CREATE TABLE IF NOT EXISTS `gl` (
  `ledgerid` int(11) NOT NULL AUTO_INCREMENT,
  `ledgername` text NOT NULL,
  `ledgeran` text NOT NULL,
  `linkedstore` text NOT NULL,
  `method` int(11) NOT NULL DEFAULT '1',
  `type` int(11) NOT NULL DEFAULT '1',
  `ledgerenabled` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ledgerid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `glpayees`
--

CREATE TABLE IF NOT EXISTS `glpayees` (
  `payeeid` int(11) NOT NULL AUTO_INCREMENT,
  `payeename` text NOT NULL,
  `payeecontact` text NOT NULL,
  `payeeaddy1` text NOT NULL,
  `payeeaddy2` text NOT NULL,
  `payeecity` text NOT NULL,
  `payeestate` text NOT NULL,
  `payeezip` text NOT NULL,
  `payeeemail` text NOT NULL,
  `payeeaccountno` text NOT NULL,
  `payeephone` text NOT NULL,
  PRIMARY KEY (`payeeid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `glsaccounts`
--

CREATE TABLE IF NOT EXISTS `glsaccounts` (
  `accountid` int(11) NOT NULL AUTO_INCREMENT,
  `ledgerid` int(11) NOT NULL,
  `accountname` text NOT NULL,
  `accounttype` varchar(20) NOT NULL,
  `linkedtaxid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`accountid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=100 ;

-- --------------------------------------------------------

--
-- Table structure for table `glstrans`
--

CREATE TABLE IF NOT EXISTS `glstrans` (
  `transid` int(11) NOT NULL AUTO_INCREMENT,
  `transnumber` varchar(60) NOT NULL,
  `transdate` datetime NOT NULL,
  `transdesc` varchar(200) NOT NULL,
  `ledgerid` int(11) NOT NULL,
  `receiptid` int(11) NOT NULL,
  `invoiceid` int(11) NOT NULL,
  `baddebttransid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`transid`),
  KEY `ledgerid` (`ledgerid`),
  KEY `receiptid` (`receiptid`),
  KEY `invoiceid` (`invoiceid`),
  KEY `transdate` (`transdate`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000 ;

-- --------------------------------------------------------

--
-- Table structure for table `glstransdet`
--

CREATE TABLE IF NOT EXISTS `glstransdet` (
  `transdetid` int(11) NOT NULL AUTO_INCREMENT,
  `transid` int(11) NOT NULL,
  `accountid` int(11) NOT NULL,
  `expense` decimal(11,5) NOT NULL,
  `income` decimal(11,5) NOT NULL,
  `transdetdesc` varchar(120) NOT NULL,
  `payee` int(11) NOT NULL,
  PRIMARY KEY (`transdetid`),
  KEY `transid` (`transid`),
  KEY `accountid` (`accountid`),
  KEY `payee` (`payee`),
  KEY `income` (`income`),
  KEY `expense` (`expense`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000 ;




--
-- Table structure for table `imessages`
--

CREATE TABLE IF NOT EXISTS `imessages` (
  `imessageid` int(11) NOT NULL AUTO_INCREMENT,
  `imessagedate` datetime NOT NULL,
  `imessage` text CHARACTER SET utf8 NOT NULL,
  `imessagefrom` varchar(50) CHARACTER SET utf8 NOT NULL,
  `imessageinvolves` varchar(200) CHARACTER SET utf8 NOT NULL,
  `imessagereadby` varchar(200) CHARACTER SET utf8 NOT NULL,
  `imessagereferences` text NOT NULL,
  PRIMARY KEY (`imessageid`),
  KEY `imessagedate` (`imessagedate`),
  KEY `imessagereadby` (`imessagereadby`),
  KEY `imessageinvolves` (`imessageinvolves`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



-- 
-- Table structure for table `inventory`
-- 

CREATE TABLE `inventory` (
  `inv_id` int(11) NOT NULL auto_increment,
  `stock_id` int(11) NOT NULL default '0',
  `inv_price` float(11,5) NOT NULL default '0.00000',
  `inv_quantity` int(11) NOT NULL default '0',
  `inv_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `storeid` int(11) NOT NULL,
  `itemserial` mediumtext collate utf8_unicode_ci NOT NULL,
  `supplierid` int(11) NOT NULL default '0',
  `suppliername` text collate utf8_unicode_ci NOT NULL,
  `parturl` text collate utf8_unicode_ci NOT NULL,
  `partnumber` text collate utf8_unicode_ci NOT NULL,
  `ponumber` text COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `inv_id` (`inv_id`),
  KEY `stock_id` (`stock_id`),
  KEY `storeid` (`storeid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;



--
-- Table structure for table `invoiceterms`
--

CREATE TABLE IF NOT EXISTS `invoiceterms` (
  `invoicetermsid` int(11) NOT NULL AUTO_INCREMENT,
  `invoicetermstitle` text NOT NULL,
  `invoicetermsdays` int(11) NOT NULL,
  `invoicetermslatefee` decimal(3,2) NOT NULL,
  `theorder` int(11) NOT NULL DEFAULT '0',
  `invoicetermsdefault` int(11) NOT NULL DEFAULT '0',
  `taxid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`invoicetermsid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `invoiceterms`
--

INSERT INTO `invoiceterms` (`invoicetermsid`, `invoicetermstitle`, `invoicetermsdays`, `invoicetermslatefee`, `theorder`, `invoicetermsdefault`, `taxid`) VALUES
(1, 'Net 14', 14, '0.00', 0, 1, 1);




CREATE TABLE IF NOT EXISTS `invoice_items` (
  `cart_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `cart_price` float(11,5) NOT NULL DEFAULT '0.00000',
  `cart_type` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `cart_stock_id` int(11) NOT NULL DEFAULT '0',
  `labor_desc` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `return_sold_id` int(11) NOT NULL DEFAULT '0',
  `restocking_fee` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `price_alt` int(11) NOT NULL DEFAULT '0',
  `addtime` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `taxex` int(11) NOT NULL DEFAULT '0',
  `itemtax` decimal(11,5) NOT NULL DEFAULT '0.00000',
  `origprice` decimal(11,5) NOT NULL,
  `discounttype` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `ourprice` decimal(11,5) NOT NULL DEFAULT '0.00000',
  `itemserial` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `quantity` decimal(11,2) NOT NULL DEFAULT '1.00',
  `unit_price` decimal(11,5) NOT NULL DEFAULT '0.00000',
  `printdesc` text COLLATE utf8_unicode_ci NOT NULL,
  `discountname` text COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `cart_item_id` (`cart_item_id`),
  KEY `invoice_id` (`invoice_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE IF NOT EXISTS `invoices` (
  `invoice_id` int(11) NOT NULL AUTO_INCREMENT,
  `invstatus` int(11) NOT NULL DEFAULT '1',
  `invname` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `invaddy1` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `invaddy2` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `invemail` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `invphone` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `invdate` datetime NOT NULL,
  `woid` text COLLATE utf8_unicode_ci NOT NULL,
  `receipt_id` int(11) NOT NULL DEFAULT '0',
  `invcity` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `invstate` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `invzip` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `byuser` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `preinvoice` int(11) NOT NULL DEFAULT '0',
  `invnotes` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `storeid` int(11) NOT NULL,
  `iorq` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `rinvoice_id` int(11) NOT NULL DEFAULT '0',
  `thesig` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `showsiginv` int(11) NOT NULL DEFAULT '1',
  `thesigtopaz` text COLLATE utf8_unicode_ci NOT NULL,
  `showsiginvtopaz` int(11) NOT NULL DEFAULT '1',
  `invcompany` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `pcgroupid` int(11) NOT NULL DEFAULT '0',
  `invoicetermsid` int(11) NOT NULL DEFAULT '0',
  `latefeeid` int(11) NOT NULL DEFAULT '0',
  `duedate` datetime NOT NULL,
  KEY `invoice_id` (`invoice_id`),
  KEY `receipt_id` (`receipt_id`),
  KEY `pcgroupid` (`pcgroupid`),
  KEY `invstatus` (`invstatus`),
  KEY `rinvoice_id` (`rinvoice_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1000 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `languages`
-- 

CREATE TABLE `languages` (
  `language` varchar(5) character set utf8 collate utf8_bin NOT NULL,
  `languagestring` varchar(200) character set utf8 collate utf8_bin NOT NULL,
  `basestring` varchar(200) character set utf8 collate utf8_bin NOT NULL,
  KEY `language` (`language`),
  KEY `basestring` (`basestring`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


CREATE TABLE `loginattempts` (
  `username` text NOT NULL,
  `ipaddress` text NOT NULL,
  `attempttime` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `mainassetinfofields` (
  `mainassetfieldid` int(11) NOT NULL AUTO_INCREMENT,
  `mainassetfieldname` mediumtext NOT NULL,
  `matchword` mediumtext NOT NULL,
  `showonclaim` int(11) NOT NULL DEFAULT '0',
  `showonrepair` int(11) NOT NULL DEFAULT '0',
  `showoncheckout` int(11) NOT NULL DEFAULT '0',
  `showonpricecard` int(11) NOT NULL DEFAULT '0',
  `showonbenchsheet` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`mainassetfieldid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=118 ;


INSERT INTO `mainassetinfofields` (`mainassetfieldid`, `mainassetfieldname`, `matchword`, `showonclaim`, `showonrepair`, `showoncheckout`, `showonpricecard`) VALUES (1, 'Windows Product Key', 'windowsproductkey', 0, 0, 0, 0),
(2, 'Operating System', 'operatingsystem', 1, 1, 1, 1),
(3, 'Screen Size', '', 0, 0, 0, 0),
(4, 'Graphics Card', 'videocard', 0, 0, 0, 0),
(5, 'Optical Drive Type', '', 0, 0, 0, 0),
(100, 'Memory (RAM)', 'ram', 1, 1, 1, 1),
(101, 'Processor (CPU)', 'cpu', 1, 1, 1, 1),
(102, 'Hard Drive', 'partition', 1, 1, 1, 1),
(103, 'Condition', '', 0, 0, 0, 0),
(104, 'Serial No/Service Tag', 'serial', 1, 1, 1, 0),
(106, 'Internal Storage', '', 0, 0, 0, 0),
(113, 'Partition Type', 'partitiontype', 1, 0, 0, 0),
(114, 'Anti-Virus', 'antivirus', 1, 0, 0, 0),
(115, 'Mac Address', 'macaddress', 0, 0, 0, 0),
(116, 'BIOS', 'bios', 0, 0, 0, 0),
(117, 'Installed On', 'installedon', 0, 0, 0, 0);


--
-- Table structure for table `mainassettypes`
--

CREATE TABLE IF NOT EXISTS `mainassettypes` (
  `mainassettypeid` int(11) NOT NULL AUTO_INCREMENT,
  `mainassetname` mediumtext NOT NULL,
  `mainassetdefault` int(11) NOT NULL,
  `subassetlist` mediumtext NOT NULL,
  `assetinfofields` mediumtext NOT NULL,
  `showscans` int(11) NOT NULL DEFAULT '1',
  `mspdevice` int(11) NOT NULL DEFAULT '1',
  `mainassetchecks` text NOT NULL,
  PRIMARY KEY (`mainassettypeid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `mainassettypes`
--

INSERT INTO `mainassettypes` (`mainassettypeid`, `mainassetname`, `mainassetdefault`, `subassetlist`, `assetinfofields`, `showscans`, `mspdevice`) VALUES
(1, 'Computer', 1, 'a:11:{i:0;s:10:"Power Cord";i:1;s:7:"Printer";i:2;s:12:"System Discs";i:3;s:7:"Display";i:4;s:5:"Modem";i:5;s:6:"Router";i:6;s:11:"Flash Drive";i:7;s:17:"External HD or CD";i:8;s:5:"Mouse";i:9;s:8:"Keyboard";i:10;s:7:"AirCard";}', 'a:14:{i:0;s:3:"101";i:1;s:3:"100";i:2;s:3:"102";i:3;s:1:"2";i:4;s:3:"104";i:5;s:1:"1";i:6;s:1:"5";i:7;s:1:"4";i:8;s:3:"103";i:9;s:3:"113";i:10;s:3:"114";i:11;s:3:"115";i:12;s:3:"116";i:13;s:3:"117";}', 1, 1),
(2, 'Laptop', 0, 'a:9:{i:0;s:20:"Laptop Power Adapter";i:1;s:10:"Laptop Bag";i:2;s:7:"Printer";i:3;s:12:"System Discs";i:4;s:6:"Router";i:5;s:11:"Flash Drive";i:6;s:17:"External HD or CD";i:7;s:5:"Mouse";i:8;s:7:"AirCard";}', 'a:10:{i:0;s:3:"101";i:1;s:3:"100";i:2;s:3:"102";i:3;s:1:"3";i:4;s:1:"2";i:5;s:1:"1";i:6;s:1:"4";i:7;s:3:"104";i:8;s:1:"5";i:9;s:3:"103";}', 1, 1),
(3, 'Phone', 0, 'a:5:{i:0;s:7:"Charger";i:1;s:20:"USB Sync/Charge Cord";i:2;s:10:"Phone Case";i:3;s:8:"Sim Card";i:4;s:11:"Car Charger";}', 'a:5:{i:0;s:1:"2";i:1;s:3:"101";i:2;s:3:"100";i:3;s:3:"106";i:4;s:3:"104";}', 1, 1),
(4, 'Printer', 0, 'a:2:{i:0;s:10:"Power Cord";i:1;s:13:"Install Discs";}', 'a:1:{i:0;s:3:"104";}', 0, 0),
(5, 'Router', 0, 'a:2:{i:0;s:10:"Power Cord";i:1;s:5:"Modem";}', 'a:1:{i:0;s:3:"104";}', 1, 1),
(6, 'Tablet', 0, 'a:7:{i:0;s:7:"Printer";i:1;s:5:"Mouse";i:2;s:8:"Keyboard";i:3;s:7:"Charger";i:4;s:20:"USB Sync/Charge Cord";i:5;s:8:"Sim Card";i:6;s:11:"Car Charger";}', 'a:4:{i:0;s:1:"2";i:1;s:3:"103";i:2;s:3:"104";i:3;s:3:"106";}', 1, 1),
(7, 'Other', 0, 'a:0:{}', 'a:3:{i:0;s:1:"2";i:1;s:3:"104";i:2;s:1:"1";}', 1, 0),
(10, 'Ticket Only', 0, 'a:0:{}', 'a:0:{}', 0, 0),
(11, 'Server', 0, '', 'a:9:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"5";i:3;s:3:"100";i:4;s:3:"101";i:5;s:3:"102";i:6;s:3:"104";i:7;s:3:"113";i:8;s:3:"114";}', 1, 1),
(12, 'Workstation', 0, '', 'a:10:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"3";i:3;s:1:"4";i:4;s:1:"5";i:5;s:3:"100";i:6;s:3:"101";i:7;s:3:"102";i:8;s:3:"104";i:9;s:3:"114";}', 1, 1);




CREATE TABLE `maincats` (
  `cat_id` int(11) NOT NULL auto_increment,
  `cat_name` mediumtext collate utf8_unicode_ci NOT NULL,
  `cat_total_items` int(11) NOT NULL default '0',
  PRIMARY KEY  (`cat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=21 ;


-- 
-- Dumping data for table `maincats`
-- 

INSERT INTO `maincats` (`cat_id`, `cat_name`, `cat_total_items`) VALUES (1, 'Drives', 0),
(2, 'Keyboards and Mice', 0),
(9, 'Sound', 0),
(4, 'Networking', 0),
(5, 'Digital Camera', 0),
(6, 'Video', 0),
(7, 'Gaming', 0),
(8, 'Cables and Adapters', 0),
(16, 'Printers and Scanners', 0),
(12, 'Misc', 0),
(11, 'Cases and Power Supplies', 0),
(15, 'Media', 0),
(17, 'CPU/Mainboard/RAM', 0),
(18, 'Software', 0),
(19, 'Computer Systems', 0),
(20, 'Consumer Electronics', 0);

-- --------------------------------------------------------


CREATE TABLE IF NOT EXISTS `messages` (
  `messageid` int(11) NOT NULL AUTO_INCREMENT,
  `messagebody` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `messagefrom` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `messageto` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `messagevia` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `messageservice` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `messagedatetime` datetime NOT NULL,
  `messageraw` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `woid` int(11) NOT NULL DEFAULT '0',
  `groupid` int(11) NOT NULL DEFAULT '0',
  `pcid` int(11) NOT NULL DEFAULT '0',
  `messagedirection` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `mediaurls` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`messageid`),
  KEY `woid` (`woid`),
  KEY `groupid` (`groupid`),
  KEY `pcid` (`pcid`),
  KEY `messagedatetime` (`messagedatetime`),
  KEY `messagefrom` (`messagefrom`),
  KEY `messageto` (`messageto`),
  KEY `messagedirection` (`messagedirection`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- 
-- Table structure for table `onorder`
-- 

CREATE TABLE `onorder` (
  `ooid` int(11) NOT NULL auto_increment,
  `item` varchar(80) collate utf8_unicode_ci NOT NULL default '',
  `reason` varchar(80) collate utf8_unicode_ci NOT NULL default '',
  `notes` varchar(120) collate utf8_unicode_ci NOT NULL default '',
  UNIQUE KEY `ooid` (`ooid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `ordernumber`
-- 

CREATE TABLE `ordernumber` (
  `ordernumber` int(11) NOT NULL auto_increment,
  `placeholder` mediumtext collate utf8_unicode_ci NOT NULL,
  UNIQUE KEY `ordernumber` (`ordernumber`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

-- 
-- Table structure for table `pc_group`
-- 


CREATE TABLE `pc_group` (
  `pcgroupid` int(11) NOT NULL auto_increment,
  `pcgroupname` mediumtext collate utf8_unicode_ci NOT NULL,
  `grpphone` mediumtext collate utf8_unicode_ci NOT NULL,
  `grpcellphone` mediumtext collate utf8_unicode_ci NOT NULL,
  `grpworkphone` mediumtext collate utf8_unicode_ci NOT NULL,
  `grpemail` mediumtext collate utf8_unicode_ci NOT NULL,
  `grpaddress1` mediumtext collate utf8_unicode_ci NOT NULL,
  `grpaddress2` mediumtext collate utf8_unicode_ci NOT NULL,
  `grpcity` mediumtext collate utf8_unicode_ci NOT NULL,
  `grpstate` mediumtext collate utf8_unicode_ci NOT NULL,
  `grpzip` mediumtext collate utf8_unicode_ci NOT NULL,
  `grpprefcontact` mediumtext collate utf8_unicode_ci NOT NULL,
  `grpcustsourceid` int(11) NOT NULL,
  `grpnotes` mediumtext collate utf8_unicode_ci NOT NULL,
  `grpcompany` mediumtext collate utf8_unicode_ci NOT NULL,
  `portalpassword` mediumtext collate utf8_unicode_ci NOT NULL,
  `portalpasswordauth` mediumtext collate utf8_unicode_ci NOT NULL,
  `tags` text COLLATE utf8_unicode_ci NOT NULL,
  `notifytime` datetime NOT NULL,
  PRIMARY KEY  (`pcgroupid`)
) ENGINE=MyISAM AUTO_INCREMENT=100 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=100 ;


-- --------------------------------------------------------

-- 
-- Table structure for table `pc_owner`
-- 

CREATE TABLE IF NOT EXISTS `pc_owner` (
  `pcid` int(11) NOT NULL AUTO_INCREMENT,
  `pcname` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `pcphone` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `pcmake` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `pcemail` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `pcaddress` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `pcaddress2` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `pcstate` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `pccity` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `pczip` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `pccellphone` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `pcworkphone` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `pcextra` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `pcgroupid` int(11) NOT NULL DEFAULT '0',
  `custsourceid` int(11) NOT NULL DEFAULT '0',
  `prefcontact` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `pcnotes` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `pccompany` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `mainassettypeid` int(11) NOT NULL DEFAULT '1',
  `scid` int(11) NOT NULL DEFAULT '0',
  `scpriceid` int(11) NOT NULL DEFAULT '0',
  `tags` text COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `pcid` (`pcid`),
  KEY `pcgroupid` (`pcgroupid`),
  KEY `scid` (`scid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1000 ;


-- --------------------------------------------------------

-- 
-- Table structure for table `pc_scan`
-- 

CREATE TABLE `pc_scan` (
  `scanid` int(11) NOT NULL auto_increment,
  `scantype` int(11) NOT NULL default '0',
  `scannum` int(11) NOT NULL default '0',
  `woid` int(11) NOT NULL default '0',
  `scantime` datetime NOT NULL default '0000-00-00 00:00:00',
  `customprogname` mediumtext collate utf8_unicode_ci NOT NULL,
  `customprogword` mediumtext collate utf8_unicode_ci NOT NULL,
  `customprintinfo` mediumtext collate utf8_unicode_ci NOT NULL,
  `customscantype` int(11) NOT NULL default '100',
  `byuser` mediumtext collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`scanid`),
  KEY `woid` (`woid`),
  KEY `scantype` (`scantype`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

-- 
-- Table structure for table `pc_scans`
-- 

CREATE TABLE `pc_scans` (
  `scanid` int(11) NOT NULL auto_increment,
  `progname` mediumtext collate utf8_unicode_ci NOT NULL,
  `progword` mediumtext collate utf8_unicode_ci NOT NULL,
  `progicon` mediumtext collate utf8_unicode_ci NOT NULL,
  `hasinfo` int(11) NOT NULL default '0',
  `printinfo` mediumtext collate utf8_unicode_ci NOT NULL,
  `theorder` int(11) NOT NULL default '0',
  `scantype` int(11) NOT NULL default '0',
  `active` int(11) NOT NULL default '1',
  PRIMARY KEY  (`scanid`)
) ENGINE=MyISAM AUTO_INCREMENT=74 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=74 ;


-- 
-- Dumping data for table `pc_scans`
-- 

INSERT INTO `pc_scans` (`scanid`, `progname`, `progword`, `progicon`, `hasinfo`, `printinfo`, `theorder`, `scantype`, `active`) VALUES (1, 'Ad-Aware Scan', 'Spyware scan', 'adaware.png', 0, '', 5, 0, 1),
(2, 'AVG Anti-VIRUS Scan', 'Virus Scan', 'avg.png', 0, '', 10, 0, 1),
(3, 'Spybot Scan', 'Spyware Scan', '3l_spybot.png', 0, '', 5, 0, 1),
(4, 'Defrag', 'Defragmented Hard Drive', 'defrag.png', 1, 'When a computer saves files on your computer, it looks for the first available space on the hard drive to put it. Many times files are save in many small open areas instead of one big open area. Defragging moves files that are split up all over the place and puts them all in one place on the hard drive which increases the performance of loading these files.', 10, 1, 1),
(5, 'Cleaned Temp Folders', 'Cleaned Temp Folders', 'tempclean.png', 1, 'Many programs leave various temporary use files laying around the computer which never get used again and just take up space. We cleaned all these from your computer.', 10, 1, 1),
(6, 'Hi-Jack This Scan', 'Browser Hi-Jacks Removed', 'hijack.png', 0, '', 8, 0, 1),
(7, 'CHKDSK', 'Thorough Hard Disk Check', 'hd.png', 1, 'We ran a special program that checks all the files and the filesystem on your computer and repairs them if problems are found. This check also identifies bad hard drive sectors and marks them so that the computer will no longer try to use them.', 3, 1, 1),
(8, 'SCANDISK', 'Thorough Hard Disk Check', 'hd.png', 1, 'We ran a special program that checks all the files and the filesystem on your computer and repairs them if problems are found. This check also identifies bad hard drive sectors and marks them so that the computer will no longer try to use them.', -1, 1, 0),
(9, 'Avira Scan', 'Virus Scan', 'freeav.png', 0, '', 3, 0, 0),
(10, 'Verified Dial-up Settings', 'Verified Dial-up Settings', 'dialup.png', 1, 'Your computer was checked or set-up for dialup internet service.', 1, 1, 1),
(11, 'Firefox', 'Installed or Updated Firefox', '11l_firefox.png', 1, 'Mozilla Firefox is a web browser alternative to Microsoft Internet Explorer. It can do everything that Internet Explorer can do. The more you use Firefox and the less you use Internet Explorer, the less likely you are to get viruses and spyware. One other advantage is due to the fact that Firefox is not tied to the Windows Operating System like Internet Explorer is, problems with Firefox won''t effect your whole computer like what happens often with Internet Explorer. ', 8, 2, 1),
(12, 'OpenOffice', 'Installed or Updated OpenOffice', 'openoffice.png', 1, 'OpenOffice.org is a free Office Suite comparable to Microsoft Office. It offers a spreadsheet, word processing, presentations, and more as well as the ability to read Microsoft Office documents. Why spend $150 plus for Microsoft Office? Anyone can download this software for free @ <u>www.openoffice.org</u>', 8, 2, 1),
(13, 'Thunderbird', 'Installed or Updated Thunderbird', 'thunderbird.png', 1, 'Thunderbird is an email program that can be used as an alternative to Outlook Express on Windows XP or Windows Mail on Vista. It also has many features not found Outlook Express such as powerful spam filtering. Thunderbird is also a great email program for Windows 7 users now that Microsoft has no longer includes an email program on Windows 7.', 0, 2, 1),
(14, 'Windows Updates', 'Installed Windows Updates', 'updates.png', 1, 'Your computer had all the necessary updates from Microsoft installed. Installing updates keeps your computer running faster, adds new features, fixes software glitches and helps protect your computer from getting infected by viruses.', 10, 1, 1),
(15, 'Windows Defender Scan', 'Spyware Scan', 'windowsdefender.png', 0, '', 3, 0, 0),
(16, 'Backed up Hard Drive', 'Backed up Hard Drive', 'backup.png', 1, 'Your computer hard drive data was backed up.', 2, 1, 1),
(18, 'Spybot', 'Installed or Updated Spybot Search and Destroy', '18l_spybot.png', 1, 'Spybot Search and Destroy is a great program for scanning and removing spyware from your computer. It also includes an immunization feature that blocks known websites that distribute spyware.', 0, 2, 1),
(19, 'AVG Anti-Virus', 'Installed or Updated AVG Anti-Virus', 'avg.png', 1, 'AVG Anti-Virus Free Edition is a better performing free anti-virus and anti-spyware program. It also provides real-time virus protection. It also automatically keeps itself updated. It uses much less memory, scans faster and it doesn''t bog your computer down like many alternatives. They also offer paid versions of the program, but the free version does everything you need. About once a year they release a new Free version that you must manually upgrade to.', 10, 2, 1),
(17, 'Ad-Aware', 'Installed or Updated Ad-Aware', 'adaware.png', 1, 'Ad-Aware is a free program that removes spyware from your computer. It must be manually run to check for spyware.', 0, 2, 1),
(20, 'Panda Anti-Virus Scan', 'Virus Scan', 'panda.png', 0, '', 3, 0, 0),
(21, 'Trendmicro AV Scan', 'Virus Scan', 'trend.png', 0, '', 4, 0, 1),
(22, 'Crap Cleaner', 'Invalid Registry Entries', 'ccleaner.png', 0, '', 8, 0, 1),
(23, 'Ran CD Lens Cleaner', 'Cleaned CD/DVD Laser Lens', 'cdrom.png', 1, 'We ran a cleaner disc on your computers cd or dvd drive which cleans the dust off of the laser lense helping reduce skips and lower performance problems.', 0, 1, 1),
(24, 'Blew Dust out of Case', 'Cleaned Dust from inside PC Case', 'caseclean.png', 1, 'We blew the dust and dirt out of your computer. Dust buildup in a computer can cause overheating can and very often does cause permanent damage to your computer.', 10, 1, 1),
(25, 'Windows Defender', 'Installed or Updated Microsoft Windows Defender', 'windowsdefender.png', 1, 'Microsoft Windows Defender is a free program that removes spyware from your computer. It provides a realtime protection against spyware. ', -1, 2, 0),
(26, 'Avira', 'Installed or Updated Avira', 'freeav.png', 1, 'Avira is a great virus scanner that works very well on older computers and/or slower computers.', -1, 2, 0),
(27, 'F-Secure AV Scan', 'Virus Scan', 'fprot.png', 0, '', 4, 0, 1),
(28, 'Comp Assoc AV Scan', 'Virus Scan', 'ca.png', 0, '', 4, 0, 1),
(29, 'Bit Defender AV Scan', 'Virus Scan', 'bitdefender.png', 0, '', 4, 0, 1),
(30, 'Computer Full Of Dust', 'Computer Full Of Dust', 'caseclean.png', 1, 'Computer was found to be full of dust. Excess dust can lead to overheating, computer instability, and or damage to your computer system. Dust also is the number one  cause of defective or poorly performing CD/DVD ROM drives and floppy drives. We highly recommend blowing the dust out of your computer case with canned dry air at least every 6 months. Keeping computers off of the floor can also help reduce the amount of dust in a computer system due to the fact that when people walk around thier feet kick up alot of dust that ends up sucked into the tower.', 4, 3, 1),
(31, 'XP &lt; 256MB of RAM', 'XP &lt; 256MB of RAM', 'memory.png', 1, 'You system runs Windows XP and has less than 256MB of memory. While Microsoft recommends a bear minimum of 128MB of memory, most Windows XP Machines use almost 128MB of RAM with out any other programs open. Your systems performance would be noticably increased by adding more memory. Ask us for details!', -1, 3, 0),
(32, 'Bad Sectors found on HD', 'Bad Sectors found on Hard Drive', 'hd.png', 1, 'Bad sectors were found on your hard drive. These sectors were marked as bad so that your computer will no longer attempt to use them. While many computers operate fine after discovering bad sectors, this could be a sign of an impending Hard Drive failure. Extra care should be taken to backup important documents and files. If your hard drive fails, everything on the computer will be lost. ', 4, 3, 1),
(33, 'Poor Modem Performance', 'Poor Modem Performance', 'dialup.png', 1, 'Your modem performed at a speed lower than the typical speed we see from average computers. You may also experience disconnects more frequently than most. While you modem will still work, increased speed and reliabilty could be acheived by replacing the modem in your computer.  ', 4, 3, 1),
(34, 'Rogue (Fake) AV Programs Removed', 'Rogue (Fake) AV Programs Removed', 'rogue.png', 1, '<table width=100% border=1 cellspacing=0 bordercolor=#000000><tr><td>\r\n<br><center>\r\n<b><font size=2>Rogue (Fake) Anti-Virus Software: How to Spot It & Avoid It!</font></b><br><br>\r\n<img src=/repair/images/rogue2.gif><br><br>\r\n</center>\r\n<font size=2>\r\nHave you seen this advertisement or similar pop-up messages?  A free PC scan or an offer to clean your computer of supposedly infected files are often attempts by malevolent persons or organizations to install malicious software (malware) such as a Trojan horse, keylogger, or spyware. Such software is referred to as rogue (fake) anti-virus malware.\r\n<br><br>\r\n<b>How can my system get infected?</b><br>\r\nThe primary way rogue anti-virus software gets on your system is the result of you clicking on a malicious link in an advertisement or similar pop-up message.  The wording contained in the advertisement is usually something alarming, designed to get your attention and attempt to convince to you scan your PC or clean it immediately with the offered tool.  The names of the fake programs sound legitimate, and often, in a further attempt to make the malware appear legitimate, the programs may prompt you to pay for an annual subscription to the service. \r\n<br><br>\r\nAny kind of website could host ads for rogue anti-virus: news sites, sports pages, and social networking sites as well as "riskier" sites such as hacker blogs.  Some varieties of rogue anti-virus programs will also get installed on your machine just by you visiting a website with a malicious ad or code, and you might never know you''ve been impacted. \r\n<br><br>\r\n<b>Won''t my valid anti-virus and anti-spyware program protect my computer?</b><br>\r\nThough good anti-virus and anti-spyware programs will protect against many threats, they cannot protect against all malware threats, especially the newest ones.  There are millions of different versions of malware, with hundreds more being created and used every day.  It may take a day, a week, or even longer for anti-virus companies to develop and distribute an update to detect and clean the newest malware. Also nowadays many malwares install a piece of software known as a rootkit, which will hide the viruses from your antivirus software, which will keep itself from being detected.\r\n<br><br>\r\n<b>What can rogue anti-virus software do to my computer?</b><br>\r\nJust about anything,   Rogue anti-virus software might perform many activities, including installing files to monitor your computer use or steal credentials, installing backdoor programs, or adding your computer to a zombie botnet.  The malware might even use your computer as a vehicle for compromising other systems in your home or workplace network.\r\n<br><br>\r\nRogue anti-virus software can also modify systems files and registry entries so that even when you clean off some infected files or registry keys others might remain, or even allow the infections to be restored and active again after your system is rebooted.  For example, one recent rogue anti-virus program reportedly installed several malicious Trojan files, and also made over two-dozen different changes to ensure that the malware stayed on the system and stayed running.  This type of malware also often blocks access to valid security sites (anti-virus and anti-spyware companies, and operating system and application update sites) so that you won''t be able to patch or clean your system by visiting those valid sites.\r\n<br><br>\r\n<b>What can I do to protect my computer?</b><br>\r\n<ol>\r\n<li>Don''t click on pop-up ads that advertise anti-virus or anti-spyware programs.  Even though pop-up ads are used for valid advertising they can also be used for malicious purposes, like getting you to install fake security programs.  If you are interested in a security product, search for it and visit its homepage, don''t get to it through a pop-up ad.\r\n<li>If you become trapped in a webpage or pop-up that is trying to force you into accepting or downloading something just turn the computer off or restart the computer. Don''t click OK hoping that you will be able to click no later, it will be too late.\r\n<li>Use and regularly update firewalls, anti-virus, and anti-spyware programs.  It is very important to use and keep these programs updated regularly so they can protect your computer against the most recent threats.  If possible, update them automatically and at least daily.\r\n<li>Properly update operating systems, browsers, and other software programs.  Keep your system and programs updated and patched so that your computer will not be exposed to known vulnerabilities and attacks.\r\n<li>Keep backups of important files.  Sometimes cleaning infections can be very easy; sometimes they can be very difficult.  You may find that an infection has affected your computer so much that the operating system and applications need to be reinstalled.  In cases like this, it is best to have your important data backed up already so you can restore your system without fear of losing your data.\r\n<li>Regularly scan and clean your computer.  If your organization already has configured this on your computer, do not disable it.  If you need to scan your computer yourself, schedule regular scans in your programs.  Also, several trusted anti-virus and anti-spyware vendors offer free scans and cleaning.  Access these types of services from reputable companies and from their webpage, not from an unexpected pop-up.\r\n</ol>\r\n</font>\r\n</td></tr>\r\n</table>', 10, 1, 1),
(35, 'Windows Failed to Validate', 'Windows Failed to Validate', 'pirated.png', 1, 'Upon attempting to perform Windows Updates, your computer failed to validate as Genuine Authentic Windows. This is usually a sign that the product key used to install Windows was not valid. In order to resolve this issue you must contact Microsoft for a valid product key or purchase a new legal copy of Microsoft Windows. Microsoft does not allow Windows Updates to be performed on computers that do not pass validation, which can leave you more vulnerable to Spyware and Viruses', 4, 3, 1),
(36, 'CD/DVD Rom Defective/Poor Performance', 'CD/DVD Rom Defective/Poor Performance', 'cdrom.png', 1, 'Your CD/DVD-ROM drive was found to be performing poorly or not at all. Dust is usually the number one cause of all Optical Drive failures. This problem may prevent you from being able to load software onto your computer.', 4, 3, 1),
(37, 'Insufficient Memory', 'Insufficient Memory', 'memory.png', 1, 'Your system was found to be using more Memory than is currently installed. When this happens, your Hard Drive is used as temporary memory which can result in poor, lagging performance. Upgrading the memory in your computer would provide a noticable speed increase.', 1, 3, 1),
(38, 'Norton, Trend Micro or McAfee Antivirus still Installed', 'Norton, Trend Micro or McAfee Antivirus still Installed', 'slow.png', 1, 'Your system was found has either Norton, Trend Micro or McAfee installed. These programs are known for their poor performance. They use excessive amounts of memory compared to other alternatives slowing your computer down. They quite often are unable to remove viruses that are loaded into memory.  The also many times come with firewalls that go haywire and prevent you from getting online. Why pay for these programs when there are free alternatives available that just work better?', 1, 3, 1),
(39, 'Norton, Trend Micro or McAfee Antivirus Removed', 'Norton, Trend Micro or McAfee Antivirus Removed', 'nortonmcafee.png', 1, 'Your system was found to have out-of-date or corrupted installations of either Norton, Trend Micro or McAfee Anti-Virus.  These programs are known for their poor performance. They use excessive amounts of memory compared to other alternatives slowing your computer down. They quite often are unable to remove viruses that are loaded into memory.  Why pay for these programs when there are free alternatives available that just work better? For these reasons we have removed these anti-virus programs and replaced them with free, better performing alternatives.', 1, 1, 1),
(40, 'Operating System Reloaded', 'Operating System Reloaded', 'hd2.png', 1, 'The Operating System on your computer was reloaded. This means that everything was wiped from the Hard Drive and the Operating System was freshly installed. Any software, printers, or other devices that you had added since buying the computer will need to be re-installed.', 10, 1, 1),
(41, 'Operating System Reloaded w/Backup', 'Operating System Reloaded w/Backup', 'hd2.png', 1, 'The Operating System on your computer was reloaded. This means that everything was wiped from the Hard Drive and the Operating System was freshly installed. Any software, printers, or other devices that you had added since buying the computer will need to be re-installed.\r\n<br><br>\r\nWe also backed up all or part of the files on your Hard Drive before reloading your computer. These backup files are located on the Desktop in a folder named Backup. While it is generally not possible to recover programs from this backup, your documents and data will be accessible once the corresponding program has been re-installed on your computer.\r\n', 10, 1, 1),
(42, 'Hard Drive Low on Space', 'Hard Drive Low on Space', 'hd.png', 1, 'Your hard disk drive was found to be low on disk space. Low hard disk drive space can result in slow performance, instability, and preventing you from loading new software programs. The solution is to add more space by either adding or replacing the hard drive, or removing programs that you no longer use from the computer. You can use the <i>Add/Remove Programs</i> icon in the control panel to remove unused programs. Be careful to only remove programs you are positive are no longer needed.', 5, 3, 1),
(45, 'AVG Anti-SPYWARE Scan', 'Spyware scan', 'avg.png', 0, '', 3, 0, 0),
(46, 'Operating System Reloaded  (Non Destructive)', 'Operating System Reload (Non Destructive)', 'hd2.png', 1, 'The Operating System on your computer was reloaded over top of the old Operating system leaving your files and the majority of your settings intact. This type of reload is usually the last thing we can do to fix operating system problems without wiping the hard drive completely empty and reloading Windows.', 10, 1, 1),
(47, 'CCleaner', 'Installed or Updated CCleaner', 'ccleaner.png', 1, 'CCleaner, short for Crap Cleaner, provides and easy 1 click way to clean your system of temp files, tracking cookies and temporary Internet files. It also supports removing stale Windows registry entries.', 9, 2, 1),
(48, 'Performance Note: AOL Client Software', 'Performance Note: AOL Client Software', 'aol.png', 1, 'Your system was found to have the AOL client software installed. AOL uses alot of system memory. System performance can be increased by removing AOL if you no longer use it. AOL can be safely removed by using the <b>Add/Remove Programs</b> feature in the Windows Control Panel. This is not to be confused with the AOL instant messanger known as AIM which is fine.', 0, 3, 1),
(49, 'Performance Note: Kodak Easy Share', 'Performance Note: Kodak Easy Share', 'kodak.png', 1, 'Your system was found to have the Kodak Easyshare Digital Camera software installed. Easyshare uses alot of system memory. System performance can be increased by removing Easyshare if you no longer use it or no longer own a Kodak digital camera. Easyshare can be safely removed by using the <b>Add/Remove Programs</b> feature in the Windows Control Panel. ', 0, 3, 1),
(50, 'Performance Note: AT&T Yahoo Client Software', 'Performance Note: AT&T Yahoo Client Software', 'att.png', 1, 'Your system was found to have the ATT Yahoo client software installed. The ATT/Yahoo software uses alot of system memory. Especially if you use their online protection software which is just rebranded inferior software made by a 3rd party company. System performance can be increased by removing the ATT/Yahoo software if you no longer use the ATT/Yahoo internet service. This software can be safely removed by using the <b>Add/Remove Programs</b> feature in the Windows Control Panel. ', 0, 3, 1),
(51, 'Computer has Windows 98/ME ', 'Computer has Windows 95/98/ME/2000 ', 'windows98.png', 1, 'Your computer is running the Microsoft Windows 98, 2000, or ME operating system. These operating systems are no longer supported by Microsoft as of July of 2006. What this means is that newly released software is no longer guaranteed to work on your computer. It also means that Microsoft will no longer fix bugs and other security problems with the operating system on your computer, which means your system will be more susceptible to viruses and spyware. Also you can no longer buy a new off the shelf printer that will work with it. Many other newer hardware and software items will no longer work with it.\r\n\r\nIt may be possible to upgrade your system to a newer version of Windows, but it is probably more wise to consider shopping for a newer computer.', 1, 3, 1),
(52, 'Spyware Doctor Scan', 'Spyware scan', 'spywaredoctor.png', 0, '', 8, 0, 1),
(53, 'Adobe Acrobat', 'Installed or Updated Adobe Acrobat Reader', 'adobe.png', 1, 'Adobe Acrobat is a program to read PDF files that are commonly used on the Internet for documents.', 6, 2, 1),
(54, 'Java', 'Installed or Updated Java', 'java.png', 1, 'Java is a system commonly used to power websites like Pogo and Yahoo games.', 6, 2, 1),
(73, 'Google Chrome', 'Google Chrome', '73google-chrome-icon.png', 1, 'Google Chrome is a browser that combines a minimal design with sophisticated technology to make the web faster, safer, and easier.', 1, 2, 1),
(58, 'MS Security Essentials Scan', 'Malware scan', 'mse.png', 0, '', 7, 0, 1),
(59, 'Memory Tested', 'Memory passed thorough test', 'memory.png', 1, 'The memory or RAM in your computer was tested with a very extensive test to make sure it is free from defect. Bad memory can cause random crashes. Your computer passed these tests.', 3, 1, 1),
(60, 'Hard Drive Tested', 'Hard Drive passed thorough test', 'hd2.png', 1, 'The hard drive in your computer received a thorough physical test and passed the test. Quite often this test can detect hard drive problems before they happen. When hard drives go bad, many times everything save on the computer is lost.', 3, 1, 1),
(61, 'Risky File Sharing Programs Found', 'Risky File Sharing Programs Found', 'limewire.png', 1, 'Filesharing programs such as Limewire, Frostwire, or Bit Torrent, were found on your computer. While these types of things are popular on the Internet because the facilitate the free downloading of copyrighted music, videos, and software, they are also a large source of Viruses and other Malware. These free downloads can become very expensive when what you think is a free program or song ends up being a virus that damages your computer or steals private information like passwords or other confidential information. Illegal downloading of copyrighted works can also result in legal action against you if you are caught.', 10, 3, 1),
(62, 'Microsoft Security Essentials', 'Installed or Updated Microsoft Security Essentials', 'mse.png', 1, 'Microsoft Security Essentials is a free Anti-Virus and Anti Spyware program from Microsoft that is very lightweight and works great on computers with lower amounts of memory. ', 9, 2, 1),
(63, 'Manually Removed Viruses', 'Manually Removed Viruses', 'hand.png', 0, '', 12, 0, 1),
(64, 'Malwarebytes Scan', 'Spyware Scan', 'malwarebytes.png', 0, '', 5, 0, 1),
(65, 'Hot Running Laptop', 'Hot Running Laptop', 'hottop.png', 1, 'Your laptop runs very hot. We highly recommend blowing the dust out of the fan vent every 3 months. We also highly recommend purchasing a laptop cooling pad. A laptop cooling pad costs less then $30 and can help prevent premature failure.', 4, 3, 1),
(66, 'Upgraded Internet Explorer', 'Upgraded Internet Explorer', 'ie.png', 1, 'We upgraded the Internet Explorer browser on your computer to the latest version.', 1, 1, 1),
(67, 'PC Decrapifier', 'Cleaned Out Trialware', 'decrap.png', 1, 'Most computers when purchased new are loaded full of trialware, Toolbars, advertising and Internet offers, and other worthless crap. We removed this junk from you computer which helps it run faster and be less cluttered.', 3, 1, 1),
(68, 'Viruses & Spyware Removed', 'Viruses & Spyware Removed', 'virus.png', 1, 'Your computer was cleaned of all know viruses, spyware and other malware which can cause lockups, slowness, information stolen from your computer, the ability of a hacker to use your computer in a botnet to attack or spam other computers on the Internet and other problems.', 1, 1, 1),
(69, 'PC Decrapifier', 'Trialware & Preloaded Junk', 'decrap.png', 0, '', 5, 0, 1),
(70, 'Eset Nod32 Antivirus', 'Virus Scan', 'eset.png', 0, '', 4, 0, 1),
(72, 'CD Burner XP Pro', 'CD Burner XP Pro', '72cdburnerxppro.png', 1, 'CD Burner XP Pro is a great free program for burning Data and Audio CD''s', 0, 2, 1);


-- --------------------------------------------------------

-- 
-- Table structure for table `pc_wo`
-- 

CREATE TABLE IF NOT EXISTS `pc_wo` (
  `woid` int(11) NOT NULL AUTO_INCREMENT,
  `pcid` int(11) NOT NULL DEFAULT '0',
  `probdesc` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `virusesfound` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custnotes` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `technotes` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `dropdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pickupdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `readydate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `skeddate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `sked` int(11) NOT NULL DEFAULT '0',
  `pcstatus` int(11) NOT NULL DEFAULT '0',
  `called` int(11) NOT NULL DEFAULT '1',
  `thepass` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custassets` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `bench` int(11) NOT NULL,
  `workarea` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `pcpriority` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `cibyuser` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `notesbyuser` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `cobyuser` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `commonproblems` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `storeid` int(11) NOT NULL,
  `thesig` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `thesigwo` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `assigneduser` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `showsigct` int(11) NOT NULL DEFAULT '1',
  `showsigrr` int(11) NOT NULL DEFAULT '1',
  `thesigcr` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `showsigcr` int(11) NOT NULL DEFAULT '1',
  `thesigtopaz` text COLLATE utf8_unicode_ci NOT NULL,
  `showsigcttopaz` int(11) NOT NULL DEFAULT '1',
  `showsigrrtopaz` int(11) NOT NULL DEFAULT '1',
  `showsigcrtopaz` int(11) NOT NULL DEFAULT '1',
  `thesigwotopaz` text COLLATE utf8_unicode_ci NOT NULL,
  `thesigcrtopaz` text COLLATE utf8_unicode_ci NOT NULL,
  `slid` int(11) NOT NULL DEFAULT '0',
  `wochecks` text COLLATE utf8_unicode_ci NOT NULL,
  `wocheckstime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `servicepromiseid` int(11) NOT NULL DEFAULT '0',
  `promisedtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`woid`),
  KEY `pcid` (`pcid`),
  KEY `pcstatus` (`pcstatus`),
  KEY `storeid` (`storeid`),
  KEY `sked` (`sked`),
  KEY `slid` (`slid`),
  KEY `dropdate` (`dropdate`),
  KEY `pickupdate` (`pickupdate`),
  KEY `promisedtime` (`promisedtime`),
  KEY `servicepromiseid` (`servicepromiseid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1000 ;

-- 
-- Table structure for table `photos`
-- 

CREATE TABLE `photos` (
  `photo_id` int(11) NOT NULL auto_increment,
  `photo_filename` mediumtext collate utf8_unicode_ci NOT NULL,
  `stock_item` int(11) NOT NULL default '0',
  UNIQUE KEY `photo_id` (`photo_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;



--
-- Table structure for table `portaldownloads`
--

CREATE TABLE IF NOT EXISTS `portaldownloads` (
  `downloadid` int(11) NOT NULL AUTO_INCREMENT,
  `downloadfilename` text NOT NULL,
  `downloadfiletitle` text NOT NULL,
  `storedas` text NOT NULL,
  `groupid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`downloadid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



--
-- Table structure for table `portalloginattempts`
--

CREATE TABLE IF NOT EXISTS `portalloginattempts` (
  `portalusername` text NOT NULL,
  `ipaddress` text NOT NULL,
  `attempttime` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



-- --------------------------------------------------------

-- 
-- Table structure for table `quicklabor`
-- 

CREATE TABLE IF NOT EXISTS `quicklabor` (
  `quickid` int(11) NOT NULL AUTO_INCREMENT,
  `labordesc` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `laborprice` decimal(11,2) NOT NULL DEFAULT '0.00',
  `theorder` int(11) NOT NULL DEFAULT '0',
  `printdesc` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`quickid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `quicklabor`
-- 

INSERT INTO `quicklabor` (`quickid`, `labordesc`, `laborprice`) VALUES (1, 'Virus/Spyware Removal', 100),
(2, 'Operating System Reload', 300),
(3, 'Data Backup', 75),
(4, 'Minimum Bench Fee', 35),
(5, 'Tune up/Bench Fee', 60),
(6, 'Tune up/Bench Fee', 35),
(7, 'Component Install', 250),
(8, 'Install CD-ROM', 100);

-- --------------------------------------------------------
-- --------------------------------------------------------

-- 
-- Table structure for table `receipts`
-- 


CREATE TABLE IF NOT EXISTS `receipts` (
  `receipt_id` int(11) NOT NULL AUTO_INCREMENT,
  `pay_type` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `person_name` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `address1` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `address2` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `ccnumber` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `ccexpdate` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `driverslc` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `check_number` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `grandtotal` float(11,5) NOT NULL DEFAULT '0.00000',
  `date_sold` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `grandtax` float(11,5) NOT NULL DEFAULT '0.00000',
  `paywith` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `taxex` int(11) NOT NULL DEFAULT '1',
  `transid` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `confirmation` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `byuser` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `city` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `state` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `zip` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `email` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `woid` text COLLATE utf8_unicode_ci NOT NULL,
  `invoice_id` text COLLATE utf8_unicode_ci NOT NULL,
  `storeid` int(11) NOT NULL,
  `thesig` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `showsigrec` int(11) NOT NULL DEFAULT '1',
  `thesigtopaz` text COLLATE utf8_unicode_ci NOT NULL,
  `showsigrectopaz` int(11) NOT NULL DEFAULT '1',
  `company` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `registerid` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `receipt_id` (`receipt_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1000 ;

-- --------------------------------------------------------

--
-- Table structure for table `regclose`
--

CREATE TABLE `regclose` (
  `regcloseid` int(11) NOT NULL AUTO_INCREMENT,
  `registerid` int(11) NOT NULL DEFAULT '0',
  `storeid` int(11) NOT NULL DEFAULT '0',
  `paymentplugin` text COLLATE utf8_unicode_ci NOT NULL,
  `opendate` datetime NOT NULL,
  `closeddate` datetime NOT NULL,
  `closedby` text COLLATE utf8_unicode_ci NOT NULL,
  `counttotal` decimal(11,5) NOT NULL,
  `expectedtotal` decimal(11,2) NOT NULL DEFAULT '0.00',
  `variance` decimal(11,5) NOT NULL,
  `balanceforward` decimal(11,5) NOT NULL,
  `removedtotal` decimal(11,5) NOT NULL,
  `countarray` text COLLATE utf8_unicode_ci NOT NULL,
  `notes` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`regcloseid`),
  KEY `registerid` (`registerid`),
  KEY `storeid` (`storeid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------


--
-- Table structure for table `registers`
--

CREATE TABLE `registers` (
  `registerid` int(11) NOT NULL AUTO_INCREMENT,
  `registername` text CHARACTER SET utf8 NOT NULL,
  `registerstoreid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`registerid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------




-- 
-- Table structure for table `repaircart`
-- 

CREATE TABLE IF NOT EXISTS `repaircart` (
  `cart_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `cart_price` float(11,5) NOT NULL DEFAULT '0.00000',
  `cart_type` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `cart_stock_id` int(11) NOT NULL DEFAULT '0',
  `labor_desc` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `return_sold_id` int(11) NOT NULL DEFAULT '0',
  `restocking_fee` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `price_alt` int(11) NOT NULL DEFAULT '0',
  `addtime` int(11) NOT NULL,
  `pcwo` int(11) NOT NULL DEFAULT '0',
  `taxex` int(11) NOT NULL DEFAULT '0',
  `itemtax` decimal(11,5) NOT NULL DEFAULT '0.00000',
  `origprice` decimal(11,5) NOT NULL,
  `discounttype` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `ourprice` decimal(11,5) NOT NULL DEFAULT '0.00000',
  `itemserial` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `quantity` decimal(11,2) NOT NULL DEFAULT '1.00',
  `unit_price` decimal(11,5) NOT NULL DEFAULT '0.00000',
  `printdesc` text COLLATE utf8_unicode_ci NOT NULL,
  `discountname` text COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `cart_item_id` (`cart_item_id`),
  KEY `pcwo` (`pcwo`),
  KEY `cart_stock_id` (`cart_stock_id`),
  KEY `taxex` (`taxex`),
  KEY `cart_price` (`cart_price`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `rinvoice_items`
-- 

CREATE TABLE IF NOT EXISTS `rinvoice_items` (
  `cart_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `cart_price` float(11,5) NOT NULL DEFAULT '0.00000',
  `cart_type` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `cart_stock_id` int(11) NOT NULL DEFAULT '0',
  `labor_desc` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `return_sold_id` int(11) NOT NULL DEFAULT '0',
  `restocking_fee` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `price_alt` int(11) NOT NULL DEFAULT '0',
  `addtime` int(11) NOT NULL,
  `rinvoice_id` int(11) NOT NULL,
  `taxex` int(11) NOT NULL DEFAULT '0',
  `itemtax` decimal(11,5) NOT NULL DEFAULT '0.00000',
  `origprice` decimal(11,5) NOT NULL,
  `discounttype` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `ourprice` decimal(11,5) NOT NULL DEFAULT '0.00000',
  `itemserial` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `quantity` decimal(11,2) NOT NULL DEFAULT '1.00',
  `unit_price` decimal(11,5) NOT NULL DEFAULT '0.00000',
  `printdesc` text COLLATE utf8_unicode_ci NOT NULL,
  `discountname` text COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `cart_item_id` (`cart_item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

-- 
-- Table structure for table `rinvoices`
-- 

CREATE TABLE `rinvoices` (
  `rinvoice_id` int(11) NOT NULL auto_increment,
  `invactive` int(11) NOT NULL default '1',
  `invname` mediumtext collate utf8_unicode_ci NOT NULL,
  `invaddy1` mediumtext collate utf8_unicode_ci NOT NULL,
  `invaddy2` mediumtext collate utf8_unicode_ci NOT NULL,
  `invemail` mediumtext collate utf8_unicode_ci NOT NULL,
  `invphone` mediumtext collate utf8_unicode_ci NOT NULL,
  `invthrudate` date NOT NULL,
  `reinvoicedate` date NOT NULL,
  `invterms` int(11) NOT NULL default '0',
  `invinterval` mediumtext collate utf8_unicode_ci NOT NULL,
  `invcity` mediumtext collate utf8_unicode_ci NOT NULL,
  `invstate` mediumtext collate utf8_unicode_ci NOT NULL,
  `invzip` mediumtext collate utf8_unicode_ci NOT NULL,
  `byuser` mediumtext collate utf8_unicode_ci NOT NULL,
  `invnotes` mediumtext collate utf8_unicode_ci NOT NULL,
  `storeid` int(11) NOT NULL,
  `pcgroupid` int(11) NOT NULL default '0',
  `invcompany` mediumtext collate utf8_unicode_ci NOT NULL,
  `blockcontractid` int(11) NOT NULL default '0',
  `blockhours` int(11) NOT NULL default '0',
 `invoicetermsid` int(11) NOT NULL DEFAULT '0',
  KEY `rinvoice_id` (`rinvoice_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;



-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `rwo` (
  `rwoid` int(11) NOT NULL AUTO_INCREMENT,
  `pcid` int(11) NOT NULL,
  `rwodate` date NOT NULL,
  `rwointerval` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `rwotask` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `rwostatus` int(11) NOT NULL DEFAULT '1',
  `tasksummary` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `rwostoreid` int(11) NOT NULL,
  PRIMARY KEY (`rwoid`),
  UNIQUE KEY `rwoid` (`rwoid`),
  KEY `pcid` (`pcid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `savedcards`
--

CREATE TABLE IF NOT EXISTS `savedcards` (
  `savedcardid` int(11) NOT NULL AUTO_INCREMENT,
  `savedcardfour` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `savedcardexpmonth` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `savedcardexpyear` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `savedcardname` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `sccid` int(11) NOT NULL,
  `savedcardbrand` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `savedcardprocid` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `savedcarddefault` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`savedcardid`),
  UNIQUE KEY `savedcardid` (`savedcardid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `savedcardscustomers`
--

CREATE TABLE IF NOT EXISTS `savedcardscustomers` (
  `sccid` int(11) NOT NULL AUTO_INCREMENT,
  `sccprocid` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `sccplugin` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `groupid` int(11) NOT NULL,
  PRIMARY KEY (`sccid`),
  UNIQUE KEY `sccid` (`sccid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------
-- 
-- Table structure for table `savedcarts`
-- 

CREATE TABLE IF NOT EXISTS `savedcarts` (
  `cart_price` float(11,5) NOT NULL DEFAULT '0.00000',
  `cart_type` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `cart_stock_id` int(11) NOT NULL DEFAULT '0',
  `labor_desc` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `return_sold_id` int(11) NOT NULL DEFAULT '0',
  `restocking_fee` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `price_alt` int(11) NOT NULL DEFAULT '0',
  `cartname` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `savedwhen` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `taxex` int(11) NOT NULL,
  `itemtax` decimal(11,5) NOT NULL,
  `origprice` decimal(11,5) NOT NULL,
  `discounttype` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `ourprice` decimal(11,5) NOT NULL DEFAULT '0.00000',
  `itemserial` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `addtime` int(11) NOT NULL,
  `iskit` int(11) NOT NULL DEFAULT '0',
  `quantity` decimal(11,2) NOT NULL DEFAULT '1.00',
  `unit_price` decimal(11,5) NOT NULL DEFAULT '0.00000',
  `printdesc` text COLLATE utf8_unicode_ci NOT NULL,
  `discountname` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Table structure for table `savedpayments`
-- 

CREATE TABLE `savedpayments` (
  `paymentid` int(11) NOT NULL auto_increment,
  `pfirstname` mediumtext collate utf8_unicode_ci NOT NULL,
  `plastname` mediumtext collate utf8_unicode_ci NOT NULL,
  `paddress` mediumtext collate utf8_unicode_ci NOT NULL,
  `paddress2` mediumtext collate utf8_unicode_ci NOT NULL,
  `pcity` mediumtext collate utf8_unicode_ci NOT NULL,
  `pstate` mediumtext collate utf8_unicode_ci NOT NULL,
  `pzip` mediumtext collate utf8_unicode_ci NOT NULL,
  `pphone` mediumtext collate utf8_unicode_ci NOT NULL,
  `pemail` mediumtext collate utf8_unicode_ci NOT NULL,
  `receipt_id` int(11) NOT NULL,
  `amount` decimal(11,5) NOT NULL,
  `paymentplugin` mediumtext collate utf8_unicode_ci NOT NULL,
  `cc_number` mediumtext collate utf8_unicode_ci NOT NULL,
  `cc_expmonth` int(11) NOT NULL,
  `cc_expyear` int(11) NOT NULL,
  `cc_transid` mediumtext collate utf8_unicode_ci NOT NULL,
  `cc_confirmation` mediumtext collate utf8_unicode_ci NOT NULL,
  `cc_cid` mediumtext collate utf8_unicode_ci NOT NULL,
  `chk_dl` mediumtext collate utf8_unicode_ci NOT NULL,
  `chk_number` mediumtext collate utf8_unicode_ci NOT NULL,
  `paymentstatus` mediumtext collate utf8_unicode_ci NOT NULL,
  `paymenttype` mediumtext collate utf8_unicode_ci NOT NULL,
  `paymentdate` datetime NOT NULL,
  `cc_cardtype` mediumtext collate utf8_unicode_ci NOT NULL,
  `custompaymentinfo` mediumtext collate utf8_unicode_ci NOT NULL,
  `storeid` int(11) NOT NULL,
  `pcompany` mediumtext collate utf8_unicode_ci NOT NULL,
  `cashchange` text collate utf8_unicode_ci NOT NULL,
  `registerid` int(11) NOT NULL DEFAULT '0',
  `depositid` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `paymentid` (`paymentid`),
  KEY `receipt_id` (`receipt_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;



-- --------------------------------------------------------

--
-- Table structure for table `scprices`
--

CREATE TABLE IF NOT EXISTS `scprices` (
  `scpriceid` int(11) NOT NULL AUTO_INCREMENT,
  `labordesc` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `laborprice` decimal(11,2) NOT NULL DEFAULT '0.00',
  `theorder` int(11) NOT NULL DEFAULT '0',
  `mainassettypeid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`scpriceid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;





-- --------------------------------------------------------

--
-- Table structure for table `servicecontracts`
--

CREATE TABLE IF NOT EXISTS `servicecontracts` (
  `scid` int(11) NOT NULL AUTO_INCREMENT,
  `scstartdate` date NOT NULL,
  `scexpdate` date NOT NULL,
  `scname` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `sccontactperson` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `scdesc` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `scperusercharge` decimal(11,5) NOT NULL,
  `scusers` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `scactive` int(11) NOT NULL DEFAULT '1',
  `groupid` int(11) NOT NULL DEFAULT '0',
  `rinvoice` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`scid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;



CREATE TABLE IF NOT EXISTS `servicepromises` (
  `servicepromiseid` int(11) NOT NULL AUTO_INCREMENT,
  `sptitle` text NOT NULL,
  `sptype` int(11) NOT NULL,
  `sptime` int(11) NOT NULL,
  `sptimeofday` time NOT NULL DEFAULT '00:00:00',
  `theorder` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`servicepromiseid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;


INSERT INTO `servicepromises` (`servicepromiseid`, `sptitle`, `sptype`, `sptime`, `sptimeofday`, `theorder`) VALUES
(1, '1 Hour', 1, 3600, '00:00:00', 40),
(2, '2 Hours', 1, 7200, '00:00:00', 35),
(3, '3 Hours', 1, 10800, '00:00:00', 30),
(4, 'Tomorrow End of Day', 2, 86400, '17:00:00', 15),
(5, 'End of Today', 2, 0, '17:00:00', 20),
(12, '4 Hours', 1, 14400, '00:00:00', 25),
(16, '2 Days End of Day', 2, 172800, '17:00:00', 10),
(17, '3 Days End of Day', 2, 259200, '17:00:00', 5),
(18, '1 Week End of Day', 2, 604800, '17:00:00', 0);



-- 
-- Table structure for table `serviceremindercanned`
-- 

CREATE TABLE `serviceremindercanned` (
  `srid` int(11) NOT NULL auto_increment,
  `srtitle` mediumtext collate utf8_unicode_ci NOT NULL,
  `srtext` mediumtext collate utf8_unicode_ci NOT NULL,
  `srorder` int(11) NOT NULL,
  UNIQUE KEY `srid` (`srid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;
-- 
-- Dumping data for table `serviceremindercanned`
-- 

INSERT INTO `serviceremindercanned` (`srid`, `srtitle`, `srtext`, `srorder`) VALUES (1, 'Anti-Virus Renewal', 'Your Anti-Virus software subscription will expire soon. Please give us a call or stop in to our store at your convenience to inquire about renewing your subscription so that your computer will continue to be protected by the latest threats.', 20),
(2, 'Dust Cleaning', 'Your computer is due to have the dirt and dust cleaned from the inside. Dust build up is leading cause of overheating. Continued overheating can cause permanent and costly damage to your computer. Please contact us to inquire about having this service performed on your computer.', 30),
(3, 'Computer Tuneup', 'This message is just to remind you that it has been a while since your computer last had a tuneup performed. Regular tuneups can help insure top performance of your computer as well as preventing serious problems that can be caught earlier before they happen. We can also make sure your anti-virus is performing properly. Please contact us to ask about all the details.', 10),
(4, 'Disk Defragmentation & Cleanup', 'It is recommended that your computer be defragged for optimum performance. This is a great task to start before you go to bed for the night. Select the "Defraggler" icon on your desktop and click the defrag button to start the process. \r\n\r\nIt is also recommend to clean out your temp folders by selecting the "CCleaner" icon on your desktop and hitting the "Run Cleaner" button to perform a cleanup on your computer', 15),
(5, 'Thank You for your Business!', 'Thank you for choosing us as your computer service company!', 0),
(6, 'Check Your Backup', 'This is just a reminder to make sure to check your backup system on your computer to make sure it is running correctly. If you would like some help with this, feel free to give us a call.', 25),
(7, 'Get a 20% Discount', 'Bring this page in to receive a free dust cleaning or 20% off the regular price of a full tuneup for this computer. This offer is valid within 14 days of the date at the top of this page', 5);


-- 
-- Table structure for table `servicereminders`
-- 

CREATE TABLE IF NOT EXISTS `servicereminders` (
  `srid` int(11) NOT NULL AUTO_INCREMENT,
  `srpcid` int(11) NOT NULL,
  `srnote` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `srdate` date NOT NULL,
  `srcanned` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `srsent` int(11) NOT NULL DEFAULT '0',
  `recurringinterval` text COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `srid` (`srid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;



-- 
-- Table structure for table `servicerequests`
-- 

CREATE TABLE `servicerequests` (
  `sreq_id` int(11) NOT NULL auto_increment,
  `sreq_ip` mediumtext collate utf8_unicode_ci NOT NULL,
  `sreq_agent` mediumtext collate utf8_unicode_ci NOT NULL,
  `sreq_name` mediumtext collate utf8_unicode_ci NOT NULL,
  `sreq_homephone` mediumtext collate utf8_unicode_ci NOT NULL,
  `sreq_cellphone` mediumtext collate utf8_unicode_ci NOT NULL,
  `sreq_workphone` mediumtext collate utf8_unicode_ci NOT NULL,
  `sreq_addy1` mediumtext collate utf8_unicode_ci NOT NULL,
  `sreq_addy2` mediumtext collate utf8_unicode_ci NOT NULL,
  `sreq_city` mediumtext collate utf8_unicode_ci NOT NULL,
  `sreq_state` mediumtext collate utf8_unicode_ci NOT NULL,
  `sreq_zip` mediumtext collate utf8_unicode_ci NOT NULL,
  `sreq_email` mediumtext collate utf8_unicode_ci NOT NULL,
  `sreq_problem` mediumtext collate utf8_unicode_ci NOT NULL,
  `sreq_model` mediumtext collate utf8_unicode_ci NOT NULL,
  `sreq_datetime` datetime NOT NULL,
  `sreq_processed` int(11) NOT NULL default '0',
  `storeid` int(11) NOT NULL default '0',
  `sreq_custsourceid` int(11) NOT NULL default '0',
  `sreq_company` mediumtext collate utf8_unicode_ci NOT NULL,
  `sreq_pcid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`sreq_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
-- --------------------------------------------------------

-- 
-- Table structure for table `shoplist`
-- 

CREATE TABLE `shoplist` (
  `shopid` int(11) NOT NULL auto_increment,
  `qty` int(11) NOT NULL default '0',
  `itemdesc` mediumtext collate utf8_unicode_ci NOT NULL,
  `itemstatus` mediumtext collate utf8_unicode_ci NOT NULL,
  `byuser` mediumtext collate utf8_unicode_ci NOT NULL,
  `stockid` int(11) NOT NULL default '0',
  UNIQUE KEY `shopid` (`shopid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `shoplist`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `smstext`
-- 

CREATE TABLE `smstext` (
  `smstextid` int(11) NOT NULL auto_increment,
  `smstext` mediumtext collate utf8_unicode_ci NOT NULL,
  `theorder` int(11) NOT NULL default '0',
  PRIMARY KEY  (`smstextid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

-- 
-- Dumping data for table `smstext`
-- 

INSERT INTO `smstext` (`smstextid`, `smstext`, `theorder`) VALUES (1, 'Your repair is completed and ready for pickup!\r\n-PC Repair Tracker', 15),
(2, 'Please call the office at 111-111-1111\r\n-PC Repair Tracker', 10),
(4, 'Please Call the office at 111-111-1111, we need your password\r\n-PC Repair Tracker', 0),
(5, 'Your computer is taking longer than expected, will be ready tomorrow\r\n-PC Repair Tracker', 5);



-- --------------------------------------------------------

-- 
-- Table structure for table `sold_items`
-- 

CREATE TABLE IF NOT EXISTS `sold_items` (
  `sold_id` int(11) NOT NULL AUTO_INCREMENT,
  `receipt` int(11) NOT NULL DEFAULT '0',
  `sold_price` decimal(11,5) NOT NULL DEFAULT '0.00000',
  `return_flag` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `return_receipt` text COLLATE utf8_unicode_ci NOT NULL,
  `stockid` int(11) NOT NULL DEFAULT '0',
  `labor_desc` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `sold_type` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `return_sold_id` int(11) NOT NULL DEFAULT '0',
  `date_sold` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `taxex` int(11) NOT NULL DEFAULT '0',
  `itemtax` decimal(11,5) NOT NULL DEFAULT '0.00000',
  `origprice` decimal(11,5) NOT NULL,
  `discounttype` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `price_alt` int(11) NOT NULL DEFAULT '0',
  `ourprice` decimal(11,5) NOT NULL DEFAULT '0.00000',
  `itemserial` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `addtime` int(11) NOT NULL,
  `registerid` int(11) NOT NULL DEFAULT '0',
  `quantity` decimal(11,2) NOT NULL DEFAULT '1.00',
  `unit_price` decimal(11,5) NOT NULL DEFAULT '0.00000',
  `printdesc` text COLLATE utf8_unicode_ci NOT NULL,
  `discountname` text COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `sold_id` (`sold_id`),
  KEY `receipt` (`receipt`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `specialorders`
-- 

CREATE TABLE IF NOT EXISTS `specialorders` (
  `spoid` int(11) NOT NULL AUTO_INCREMENT,
  `spopartname` text NOT NULL,
  `spoprice` decimal(11,5) NOT NULL DEFAULT '0.00000',
  `spocost` decimal(11,5) NOT NULL DEFAULT '0.00000',
  `spowoid` int(11) NOT NULL DEFAULT '0',
  `sposupplierid` int(11) NOT NULL DEFAULT '0',
  `sposuppliername` text NOT NULL,
  `spopartnumber` text NOT NULL,
  `spoparturl` text NOT NULL,
  `spotracking` text NOT NULL,
  `spostatus` int(11) NOT NULL DEFAULT '0',
  `spodate` datetime NOT NULL,
  `spoopenclosed` int(11) NOT NULL DEFAULT '0',
  `spostoreid` int(11) NOT NULL,
  `sponotes` text NOT NULL,
  `quantity` decimal(11,5) NOT NULL DEFAULT '1.00000',
  `unit_price` decimal(11,5) NOT NULL DEFAULT '0.00000',
  `printdesc` text NOT NULL,
  UNIQUE KEY `spoid` (`spoid`),
  KEY `spowoid` (`spowoid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `stickynotes`
-- 

CREATE TABLE `stickynotes` (
  `stickyid` int(11) NOT NULL auto_increment,
  `stickyaddy1` mediumtext collate utf8_unicode_ci NOT NULL,
  `stickyaddy2` mediumtext collate utf8_unicode_ci NOT NULL,
  `stickycity` mediumtext collate utf8_unicode_ci NOT NULL,
  `stickystate` mediumtext collate utf8_unicode_ci NOT NULL,
  `stickyzip` mediumtext collate utf8_unicode_ci NOT NULL,
  `stickyphone` mediumtext collate utf8_unicode_ci NOT NULL,
  `stickyemail` mediumtext collate utf8_unicode_ci NOT NULL,
  `stickyduedate` datetime NOT NULL,
  `stickyduedateend` datetime NOT NULL,
  `stickytypeid` int(11) NOT NULL,
  `stickyuser` mediumtext collate utf8_unicode_ci NOT NULL,
  `stickynote` mediumtext collate utf8_unicode_ci NOT NULL,
  `stickyname` mediumtext collate utf8_unicode_ci NOT NULL,
  `refid` int(11) NOT NULL default '0',
  `reftype` mediumtext collate utf8_unicode_ci NOT NULL,
  `showonwall` tinyint(4) NOT NULL default '1',
  `storeid` int(11) NOT NULL,
  `stickycompany` mediumtext collate utf8_unicode_ci NOT NULL,
  UNIQUE KEY `stickyid` (`stickyid`),
  KEY `refid` (`refid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;



-- 
-- Table structure for table `stickytypes`
-- 

CREATE TABLE `stickytypes` (
  `stickytypeid` int(11) NOT NULL auto_increment,
  `stickytypename` mediumtext collate utf8_unicode_ci NOT NULL,
  `bordercolor` mediumtext collate utf8_unicode_ci NOT NULL,
  `notecolor` mediumtext collate utf8_unicode_ci NOT NULL,
  `notecolor2` mediumtext collate utf8_unicode_ci NOT NULL,
  UNIQUE KEY `stickytypeid` (`stickytypeid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;


-- 
-- Dumping data for table `stickytypes`
-- 

INSERT INTO `stickytypes` (`stickytypeid`, `stickytypename`, `bordercolor`, `notecolor`, `notecolor2`) VALUES (1, 'Scheduled Service Call', '00a908', 'ffffff', 'b4ff96'),
(2, 'Return a Call', '0f00d0', 'ffffff', '90f3ff'),
(4, 'Order a Part', 'c48f00', 'ffffff', 'fff889'),
(5, 'Scheduled Remote Session', 'fb4700', 'ffffff', 'ffc990'),
(6, 'Quote Request', 'd9000a', 'ffe4e5', 'ffcdcf'),
(7, 'Task', '960094', 'ffd7ff', 'ff9bfe');



-- 
-- Table structure for table `stock`
-- 
CREATE TABLE IF NOT EXISTS `stock` (
  `stock_id` int(11) NOT NULL AUTO_INCREMENT,
  `stock_title` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `stock_desc` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `stock_cat` int(11) NOT NULL DEFAULT '0',
  `stock_price` float(11,5) NOT NULL DEFAULT '0.00000',
  `dis_cont` int(11) NOT NULL DEFAULT '0',
  `stock_upc` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `avg_cost` float(11,5) NOT NULL DEFAULT '0.00000',
  `stock_pdesc` text COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `stock_id` (`stock_id`),
  KEY `stock_upc` (`stock_upc`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1000 ;


-- --------------------------------------------------------

CREATE TABLE `stockcounts` (
  `stockcountid` int(11) NOT NULL auto_increment,
  `stockid` int(11) NOT NULL,
  `storeid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL default '0',
  `lastcounted` datetime NOT NULL,
  `maintainstock` int(11) NOT NULL default '0',
  `minstock` int(11) NOT NULL default '0',
  `maxstock` int(11) NOT NULL default '1',
  `reorderqty` int(11) NOT NULL default '1',
  `reqcount` int(11) NOT NULL default '0',
  PRIMARY KEY  (`stockcountid`),
  KEY `stockid` (`stockid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;



--
-- Table structure for table `stocknoninv`
--

CREATE TABLE IF NOT EXISTS `stocknoninv` (
  `niid` int(11) NOT NULL AUTO_INCREMENT,
  `ni_title` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `ni_desc` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `ni_price` float(11,5) NOT NULL DEFAULT '0.00000',
  `ni_pdesc` text COLLATE utf8_unicode_ci NOT NULL,
  `theorder` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `niid` (`niid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


--
-- Table structure for table `storagelocations`
--

CREATE TABLE `storagelocations` (
  `slid` int(11) NOT NULL AUTO_INCREMENT,
  `slname` text COLLATE utf8_unicode_ci NOT NULL,
  `theorder` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`slid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------




-- 
-- Table structure for table `stores`
-- 

CREATE TABLE `stores` (
  `storeid` int(11) NOT NULL auto_increment,
  `storesname` mediumtext collate utf8_unicode_ci NOT NULL,
  `storename` mediumtext collate utf8_unicode_ci NOT NULL,
  `storeaddy1` mediumtext collate utf8_unicode_ci NOT NULL,
  `storeaddy2` mediumtext collate utf8_unicode_ci NOT NULL,
  `storecity` mediumtext collate utf8_unicode_ci NOT NULL,
  `storestate` mediumtext collate utf8_unicode_ci NOT NULL,
  `storezip` mediumtext collate utf8_unicode_ci NOT NULL,
  `storeemail` mediumtext collate utf8_unicode_ci NOT NULL,
  `storephone` mediumtext collate utf8_unicode_ci NOT NULL,
  `storedefault` int(11) NOT NULL default '0',
  `storeenabled` int(11) NOT NULL default '1',
  `quotefooter` mediumtext collate utf8_unicode_ci NOT NULL,
  `invoicefooter` mediumtext collate utf8_unicode_ci NOT NULL,
  `repairsheetfooter` mediumtext collate utf8_unicode_ci NOT NULL,
  `returnpolicy` mediumtext collate utf8_unicode_ci NOT NULL,
  `depositfooter` mediumtext collate utf8_unicode_ci NOT NULL,
  `thankyouletter` mediumtext collate utf8_unicode_ci NOT NULL,
  `claimticket` mediumtext collate utf8_unicode_ci NOT NULL,
  `checkoutreceipt` mediumtext collate utf8_unicode_ci NOT NULL,
  `linecolor1` varchar(6) collate utf8_unicode_ci NOT NULL default 'dddddd',
  `linecolor2` varchar(6) collate utf8_unicode_ci NOT NULL default 'dddddd',
  `bgcolor1` varchar(6) collate utf8_unicode_ci NOT NULL default 'ffffff',
  `bgcolor2` varchar(6) collate utf8_unicode_ci NOT NULL default 'ffffff',
  `logo` mediumtext collate utf8_unicode_ci NOT NULL,
  `printlogo` mediumtext collate utf8_unicode_ci NOT NULL,
  `storehash` mediumtext collate utf8_unicode_ci NOT NULL,
  `ccemail` mediumtext collate utf8_unicode_ci NOT NULL,
  `oncalluser` mediumtext collate utf8_unicode_ci NOT NULL,
  `tempasset` mediumtext collate utf8_unicode_ci NOT NULL,
  `tempaddress` mediumtext collate utf8_unicode_ci NOT NULL,
  `temppricetag` mediumtext collate utf8_unicode_ci NOT NULL,
  `temppricetagserial` mediumtext collate utf8_unicode_ci NOT NULL,
  `tempbadge` text collate utf8_unicode_ci NOT NULL,
  `lastbackup` datetime NOT NULL,
  UNIQUE KEY `storeid` (`storeid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;


INSERT INTO `stores` (`storeid`, `storesname`, `storename`, `storeaddy1`, `storeaddy2`, `storecity`, `storestate`, `storezip`, `storeemail`, `storephone`, `storedefault`, `storeenabled`, `quotefooter`, `invoicefooter`, `repairsheetfooter`, `returnpolicy`, `depositfooter`, `thankyouletter`, `claimticket`, `checkoutreceipt`, `tempasset`, `tempaddress`, `temppricetag`, `temppricetagserial`) VALUES (1, 'Store 1', 'My Business Name', 'MyAddress', '', 'MyCity', 'MyZip', '12345', 'me@email.com', '123-123-1234', 1, 1, '<font class=text16b>Thank-You for your consideration.</font><br><font class=text12>Please note that these prices are subject to change.</font>', '<font class=text16b>Thank-You for your patronage.</font><br><font class=text12>Please pay this invoice within 2 weeks of the invoice date.</font>', '<font class=text10> End of Report</font>', '<font class=text10b> Return Policy:</font><font class=text10> Motherboards, memory and processors must be returned within 7 days for refund. All other items that are returned or exchanged for different items are subject to a 20% restocking fee.\r\n We may, at our discretion only charge a 5% restocking fee provided the item is returned with non-ripped packaging in un-used condition. Items must be returned with a receipt. No returns or refunds on consumable items, printer cartridges, services, or items returned incomplete or without all original packaging. All returns over $25 are either credited back to the customers credit card, or issued a company check within 14 days.</font>', '<font class=text10b>Deposit Policy:</font> <font class=text10> Please keep this receipt for your own records.</font>', '<font class=text12b>Thank-You for choosing My Company for your recent service work.</font>\r\n\r\n<font class=text12>We want you to be satisfied with the level of service we have provided you. If you have any further issues or questions, do not hesitate to contact us. We want you to be 100% satisfied with our work.\r\n\r\nWe also welcome feedback and reviews on our Google Places page located here: <a href=http://g.co/maps/>My Google Places Page</a>. If you have any immediate issues though, be sure to contact us directly, we are ready and eager to solve any issue.\r\n\r\nThanks Again for choosing us, and please remember us for any future needs.\r\n\r\nSincerely,\r\nThe Staff of My Company</font>', '<font class=text12b>Thank-You for choosing My Company to repair your computer.\r\nPlease keep this ticket and present at the time of pick-up of your computer.</font>\r\n\r\n<font class=text12>Please be advised that while nothing will be done by our techs to purposely cause loss of data and files from your computer, mechanical failure of computer components can happen with out warning, and virus infections can cause un-predictable problems. If you have important information on your computer such as family pictures or financial records, and wish to minimize your risk of data loss, please inquire about our back up services which can be performed before intensive diagnostic tests or virus scans are performed.\r\n\r\nPlease keep in mind also that if the Operating System Reload Service is required, you will be contacted first by us before we perform the service. You may opt to have us backup your information before we perform the service for an additional charge. An Operating System Reload requires that the computer hard drive be formatted and erased before reinstalling the Operating System software. An Operating System reload also requires that you reinstall all printer drivers, and additional computer programs you may have installed since the original purchase of the computer. We cannot restore computer programs from backup. They must be re-installed from their original sources.\r\n\r\nFeel free to call us to check on the status of your computer any time. Most repairs take 1-4 business days to complete.\r\nIf you would like to see your computer repaired as fast as possible, feel free to call us and ask about the possibility and costs of a memory upgrade that can speed up the repair process.</font>\r\n\r\n<font class=text12b>Abandoned Computers</font>\r\n<font class=text12>Computers that are diagnosed as non-repairable or not cost effective for repair, will be disposed of if abandoned for over 60 days at our sole discretion. Any computers abandoned over 180 days without prior arrangements will be disposed of at our discretion. It is the customers responsibility to verify that we have the correct contact information on file which also appears printed on this sheet.</font>', '<font class=text12>The below signed agrees that all items have been returned or "signed-off" on by the customer, that all items have been returning in an acceptable condition, and that My Company is no longer responsible for the customers property.</font>', '<?xml version="1.0" encoding="utf-8"?>\r\n<DieCutLabel Version="8.0" Units="twips">\r\n	<PaperOrientation>Landscape</PaperOrientation>\r\n	<Id>Address</Id>\r\n	<PaperName>30252 Address</PaperName>\r\n	<DrawCommands>\r\n		<RoundRectangle X="0" Y="0" Width="1581" Height="5040" Rx="270" Ry="270" />\r\n	</DrawCommands>\r\n	<ObjectInfo>\r\n		<BarcodeObject>\r\n			<Name>Barcode</Name>\r\n			<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n			<BackColor Alpha="0" Red="255" Green="255" Blue="255" />\r\n			<LinkedObjectName></LinkedObjectName>\r\n			<Rotation>Rotation0</Rotation>\r\n			<IsMirrored>False</IsMirrored>\r\n			<IsVariable>True</IsVariable>\r\n			<Text>PCRTPCID</Text>\r\n			<Type>Code39</Type>\r\n			<Size>Medium</Size>\r\n			<TextPosition>Bottom</TextPosition>\r\n			<TextFont Family="Arial" Size="16" Bold="True" Italic="False" Underline="False" Strikeout="False" />\r\n			<CheckSumFont Family="Arial" Size="7.3125" Bold="False" Italic="False" Underline="False" Strikeout="False" />\r\n			<TextEmbedding>None</TextEmbedding>\r\n			<ECLevel>0</ECLevel>\r\n			<HorizontalAlignment>Center</HorizontalAlignment>\r\n			<QuietZonesPadding Left="0" Top="0" Right="0" Bottom="0" />\r\n		</BarcodeObject>\r\n		<Bounds X="331" Y="833" Width="4440.47265625" Height="660" />\r\n	</ObjectInfo>\r\n	<ObjectInfo>\r\n		<TextObject>\r\n			<Name>Text</Name>\r\n			<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n			<BackColor Alpha="0" Red="255" Green="255" Blue="255" />\r\n			<LinkedObjectName></LinkedObjectName>\r\n			<Rotation>Rotation0</Rotation>\r\n			<IsMirrored>False</IsMirrored>\r\n			<IsVariable>True</IsVariable>\r\n			<HorizontalAlignment>Center</HorizontalAlignment>\r\n			<VerticalAlignment>Top</VerticalAlignment>\r\n			<TextFitMode>ShrinkToFit</TextFitMode>\r\n			<UseFullFontHeight>True</UseFullFontHeight>\r\n			<Verticalized>False</Verticalized>\r\n			<StyledText>\r\n				<Element>\r\n					<String>PCRT_YOUR_STORE_NAME</String>\r\n					<Attributes>\r\n						<Font Family="Arial" Size="10" Bold="False" Italic="False" Underline="False" Strikeout="False" />\r\n						<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n					</Attributes>\r\n				</Element>\r\n			</StyledText>\r\n		</TextObject>\r\n		<Bounds X="331" Y="76.5407725321887" Width="4350" Height="239.070386266094" />\r\n	</ObjectInfo>\r\n	<ObjectInfo>\r\n		<TextObject>\r\n			<Name>TEXT</Name>\r\n			<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n			<BackColor Alpha="0" Red="255" Green="255" Blue="255" />\r\n			<LinkedObjectName></LinkedObjectName>\r\n			<Rotation>Rotation0</Rotation>\r\n			<IsMirrored>False</IsMirrored>\r\n			<IsVariable>False</IsVariable>\r\n			<HorizontalAlignment>CenterBlock</HorizontalAlignment>\r\n			<VerticalAlignment>Top</VerticalAlignment>\r\n			<TextFitMode>ShrinkToFit</TextFitMode>\r\n			<UseFullFontHeight>True</UseFullFontHeight>\r\n			<Verticalized>False</Verticalized>\r\n			<StyledText>\r\n				<Element>\r\n					<String>PCRT_STORE_PHONE</String>\r\n					<Attributes>\r\n						<Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\r\n						<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n					</Attributes>\r\n				</Element>\r\n			</StyledText>\r\n		</TextObject>\r\n		<Bounds X="1064.39055793991" Y="327.618025751073" Width="2880" Height="221.523605150215" />\r\n	</ObjectInfo>\r\n	<ObjectInfo>\r\n		<TextObject>\r\n			<Name>TEXT_1</Name>\r\n			<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n			<BackColor Alpha="0" Red="255" Green="255" Blue="255" />\r\n			<LinkedObjectName></LinkedObjectName>\r\n			<Rotation>Rotation0</Rotation>\r\n			<IsMirrored>False</IsMirrored>\r\n			<IsVariable>False</IsVariable>\r\n			<HorizontalAlignment>CenterBlock</HorizontalAlignment>\r\n			<VerticalAlignment>Top</VerticalAlignment>\r\n			<TextFitMode>ShrinkToFit</TextFitMode>\r\n			<UseFullFontHeight>True</UseFullFontHeight>\r\n			<Verticalized>False</Verticalized>\r\n			<StyledText>\r\n				<Element>\r\n					<String>PCRT_CUSTOMER_NAME</String>\r\n					<Attributes>\r\n						<Font Family="Arial" Size="12" Bold="True" Italic="False" Underline="False" Strikeout="False" />\r\n						<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n					</Attributes>\r\n				</Element>\r\n			</StyledText>\r\n		</TextObject>\r\n		<Bounds X="1059.17596566523" Y="557.317596566524" Width="2880" Height="221.523605150215" />\r\n	</ObjectInfo>\r\n</DieCutLabel>', '<?xml version="1.0" encoding="utf-8"?>\r\n<DieCutLabel Version="8.0" Units="twips">\r\n	<PaperOrientation>Landscape</PaperOrientation>\r\n	<Id>Address</Id>\r\n	<PaperName>30252 Address</PaperName>\r\n	<DrawCommands>\r\n		<RoundRectangle X="0" Y="0" Width="1581" Height="5040" Rx="270" Ry="270" />\r\n	</DrawCommands>\r\n	<ObjectInfo>\r\n		<TextObject>\r\n			<Name>TEXT</Name>\r\n			<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n			<BackColor Alpha="0" Red="255" Green="255" Blue="255" />\r\n			<LinkedObjectName></LinkedObjectName>\r\n			<Rotation>Rotation0</Rotation>\r\n			<IsMirrored>False</IsMirrored>\r\n			<IsVariable>False</IsVariable>\r\n			<HorizontalAlignment>Left</HorizontalAlignment>\r\n			<VerticalAlignment>Top</VerticalAlignment>\r\n			<TextFitMode>ShrinkToFit</TextFitMode>\r\n			<UseFullFontHeight>True</UseFullFontHeight>\r\n			<Verticalized>False</Verticalized>\r\n			<StyledText>\r\n				<Element>\r\n					<String>PCRT_CUSTOMER_NAME</String>\r\n					<Attributes>\r\n						<Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\r\n						<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n					</Attributes>\r\n				</Element>\r\n			</StyledText>\r\n		</TextObject>\r\n		<Bounds X="331" Y="150" Width="4037.38197424893" Height="301.738197424893" />\r\n	</ObjectInfo>\r\n	<ObjectInfo>\r\n		<TextObject>\r\n			<Name>TEXT_1</Name>\r\n			<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n			<BackColor Alpha="0" Red="255" Green="255" Blue="255" />\r\n			<LinkedObjectName></LinkedObjectName>\r\n			<Rotation>Rotation0</Rotation>\r\n			<IsMirrored>False</IsMirrored>\r\n			<IsVariable>False</IsVariable>\r\n			<HorizontalAlignment>Left</HorizontalAlignment>\r\n			<VerticalAlignment>Top</VerticalAlignment>\r\n			<TextFitMode>ShrinkToFit</TextFitMode>\r\n			<UseFullFontHeight>True</UseFullFontHeight>\r\n			<Verticalized>False</Verticalized>\r\n			<StyledText>\r\n				<Element>\r\n					<String>PCRT_ADDRESS1</String>\r\n					<Attributes>\r\n						<Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\r\n						<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n					</Attributes>\r\n				</Element>\r\n			</StyledText>\r\n		</TextObject>\r\n		<Bounds X="331" Y="431.266094420601" Width="4037.38197424893" Height="301.738197424893" />\r\n	</ObjectInfo>\r\n	<ObjectInfo>\r\n		<TextObject>\r\n			<Name>TEXT_2</Name>\r\n			<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n			<BackColor Alpha="0" Red="255" Green="255" Blue="255" />\r\n			<LinkedObjectName></LinkedObjectName>\r\n			<Rotation>Rotation0</Rotation>\r\n			<IsMirrored>False</IsMirrored>\r\n			<IsVariable>False</IsVariable>\r\n			<HorizontalAlignment>Left</HorizontalAlignment>\r\n			<VerticalAlignment>Top</VerticalAlignment>\r\n			<TextFitMode>ShrinkToFit</TextFitMode>\r\n			<UseFullFontHeight>True</UseFullFontHeight>\r\n			<Verticalized>False</Verticalized>\r\n			<StyledText>\r\n				<Element>\r\n					<String>PCRT_ADDRESS2</String>\r\n					<Attributes>\r\n						<Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\r\n						<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n					</Attributes>\r\n				</Element>\r\n			</StyledText>\r\n		</TextObject>\r\n		<Bounds X="331" Y="717.746781115879" Width="4037.38197424893" Height="301.738197424893" />\r\n	</ObjectInfo>\r\n	<ObjectInfo>\r\n		<TextObject>\r\n			<Name>TEXT_3</Name>\r\n			<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n			<BackColor Alpha="0" Red="255" Green="255" Blue="255" />\r\n			<LinkedObjectName></LinkedObjectName>\r\n			<Rotation>Rotation0</Rotation>\r\n			<IsMirrored>False</IsMirrored>\r\n			<IsVariable>False</IsVariable>\r\n			<HorizontalAlignment>Left</HorizontalAlignment>\r\n			<VerticalAlignment>Top</VerticalAlignment>\r\n			<TextFitMode>ShrinkToFit</TextFitMode>\r\n			<UseFullFontHeight>True</UseFullFontHeight>\r\n			<Verticalized>False</Verticalized>\r\n			<StyledText>\r\n				<Element>\r\n					<String>PCRT_ADDRESS3</String>\r\n					<Attributes>\r\n						<Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\r\n						<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n					</Attributes>\r\n				</Element>\r\n			</StyledText>\r\n		</TextObject>\r\n		<Bounds X="331" Y="1032.87553648069" Width="4037.38197424893" Height="301.738197424893" />\r\n	</ObjectInfo>\r\n</DieCutLabel>', '<?xml version="1.0" encoding="utf-8"?>\r\n<DieCutLabel Version="8.0" Units="twips">\r\n	<PaperOrientation>Landscape</PaperOrientation>\r\n	<Id>Address</Id>\r\n	<PaperName>30252 Address</PaperName>\r\n	<DrawCommands>\r\n		<RoundRectangle X="0" Y="0" Width="1581" Height="5040" Rx="270" Ry="270" />\r\n	</DrawCommands>\r\n	<ObjectInfo>\r\n		<BarcodeObject>\r\n			<Name>Barcode</Name>\r\n			<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n			<BackColor Alpha="0" Red="255" Green="255" Blue="255" />\r\n			<LinkedObjectName></LinkedObjectName>\r\n			<Rotation>Rotation0</Rotation>\r\n			<IsMirrored>False</IsMirrored>\r\n			<IsVariable>True</IsVariable>\r\n			<Text>PCRTSTOCKID</Text>\r\n			<Type>Code39</Type>\r\n			<Size>Medium</Size>\r\n			<TextPosition>Bottom</TextPosition>\r\n			<TextFont Family="Arial" Size="12" Bold="True" Italic="False" Underline="False" Strikeout="False" />\r\n			<CheckSumFont Family="Arial" Size="7.3125" Bold="False" Italic="False" Underline="False" Strikeout="False" />\r\n			<TextEmbedding>None</TextEmbedding>\r\n			<ECLevel>0</ECLevel>\r\n			<HorizontalAlignment>Center</HorizontalAlignment>\r\n			<QuietZonesPadding Left="0" Top="0" Right="0" Bottom="0" />\r\n		</BarcodeObject>\r\n		<Bounds X="331" Y="817.403449717509" Width="4440.47265625" Height="675.596550282491" />\r\n	</ObjectInfo>\r\n	<ObjectInfo>\r\n		<TextObject>\r\n			<Name>Text</Name>\r\n			<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n			<BackColor Alpha="0" Red="255" Green="255" Blue="255" />\r\n			<LinkedObjectName></LinkedObjectName>\r\n			<Rotation>Rotation0</Rotation>\r\n			<IsMirrored>False</IsMirrored>\r\n			<IsVariable>True</IsVariable>\r\n			<HorizontalAlignment>Left</HorizontalAlignment>\r\n			<VerticalAlignment>Top</VerticalAlignment>\r\n			<TextFitMode>ShrinkToFit</TextFitMode>\r\n			<UseFullFontHeight>True</UseFullFontHeight>\r\n			<Verticalized>False</Verticalized>\r\n			<StyledText>\r\n				<Element>\r\n					<String>PCRT_STORE_NAME</String>\r\n					<Attributes>\r\n						<Font Family="Arial" Size="14" Bold="True" Italic="False" Underline="False" Strikeout="False" />\r\n						<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n					</Attributes>\r\n				</Element>\r\n			</StyledText>\r\n		</TextObject>\r\n		<Bounds X="331" Y="88" Width="3175.42918454936" Height="289.51932535458" />\r\n	</ObjectInfo>\r\n	<ObjectInfo>\r\n		<TextObject>\r\n			<Name>TEXT</Name>\r\n			<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n			<BackColor Alpha="0" Red="255" Green="255" Blue="255" />\r\n			<LinkedObjectName></LinkedObjectName>\r\n			<Rotation>Rotation0</Rotation>\r\n			<IsMirrored>False</IsMirrored>\r\n			<IsVariable>False</IsVariable>\r\n			<HorizontalAlignment>Left</HorizontalAlignment>\r\n			<VerticalAlignment>Top</VerticalAlignment>\r\n			<TextFitMode>ShrinkToFit</TextFitMode>\r\n			<UseFullFontHeight>True</UseFullFontHeight>\r\n			<Verticalized>False</Verticalized>\r\n			<StyledText>\r\n				<Element>\r\n					<String>PCRT_STOCK_NAME</String>\r\n					<Attributes>\r\n						<Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\r\n						<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n					</Attributes>\r\n				</Element>\r\n			</StyledText>\r\n		</TextObject>\r\n		<Bounds X="331" Y="402.103004291845" Width="3286.8025751073" Height="278.819742489271" />\r\n	</ObjectInfo>\r\n	<ObjectInfo>\r\n		<TextObject>\r\n			<Name>TEXT_1</Name>\r\n			<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n			<BackColor Alpha="0" Red="255" Green="255" Blue="255" />\r\n			<LinkedObjectName></LinkedObjectName>\r\n			<Rotation>Rotation0</Rotation>\r\n			<IsMirrored>False</IsMirrored>\r\n			<IsVariable>False</IsVariable>\r\n			<HorizontalAlignment>Left</HorizontalAlignment>\r\n			<VerticalAlignment>Top</VerticalAlignment>\r\n			<TextFitMode>ShrinkToFit</TextFitMode>\r\n			<UseFullFontHeight>True</UseFullFontHeight>\r\n			<Verticalized>False</Verticalized>\r\n			<StyledText>\r\n				<Element>\r\n					<String>PCRT_PRICE</String>\r\n					<Attributes>\r\n						<Font Family="Arial" Size="16" Bold="False" Italic="False" Underline="False" Strikeout="False" />\r\n						<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n					</Attributes>\r\n				</Element>\r\n			</StyledText>\r\n		</TextObject>\r\n		<Bounds X="3677.60944206009" Y="110.407725321888" Width="1241.330472103" Height="576.759656652361" />\r\n	</ObjectInfo>\r\n</DieCutLabel>', '<?xml version="1.0" encoding="utf-8"?>\r\n<DieCutLabel Version="8.0" Units="twips">\r\n	<PaperOrientation>Landscape</PaperOrientation>\r\n	<Id>Address</Id>\r\n	<PaperName>30252 Address</PaperName>\r\n	<DrawCommands>\r\n		<RoundRectangle X="0" Y="0" Width="1581" Height="5040" Rx="270" Ry="270" />\r\n	</DrawCommands>\r\n	<ObjectInfo>\r\n		<BarcodeObject>\r\n			<Name>Barcode</Name>\r\n			<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n			<BackColor Alpha="0" Red="255" Green="255" Blue="255" />\r\n			<LinkedObjectName></LinkedObjectName>\r\n			<Rotation>Rotation0</Rotation>\r\n			<IsMirrored>False</IsMirrored>\r\n			<IsVariable>True</IsVariable>\r\n			<Text>PCRTSTOCKID</Text>\r\n			<Type>Code39</Type>\r\n			<Size>Medium</Size>\r\n			<TextPosition>Bottom</TextPosition>\r\n			<TextFont Family="Arial" Size="12" Bold="True" Italic="False" Underline="False" Strikeout="False" />\r\n			<CheckSumFont Family="Arial" Size="7.3125" Bold="False" Italic="False" Underline="False" Strikeout="False" />\r\n			<TextEmbedding>None</TextEmbedding>\r\n			<ECLevel>0</ECLevel>\r\n			<HorizontalAlignment>Center</HorizontalAlignment>\r\n			<QuietZonesPadding Left="0" Top="0" Right="0" Bottom="0" />\r\n		</BarcodeObject>\r\n		<Bounds X="331" Y="1000.75109863281" Width="4440.47265625" Height="492.248901367188" />\r\n	</ObjectInfo>\r\n	<ObjectInfo>\r\n		<TextObject>\r\n			<Name>Text</Name>\r\n			<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n			<BackColor Alpha="0" Red="255" Green="255" Blue="255" />\r\n			<LinkedObjectName></LinkedObjectName>\r\n			<Rotation>Rotation0</Rotation>\r\n			<IsMirrored>False</IsMirrored>\r\n			<IsVariable>True</IsVariable>\r\n			<HorizontalAlignment>Left</HorizontalAlignment>\r\n			<VerticalAlignment>Top</VerticalAlignment>\r\n			<TextFitMode>ShrinkToFit</TextFitMode>\r\n			<UseFullFontHeight>True</UseFullFontHeight>\r\n			<Verticalized>False</Verticalized>\r\n			<StyledText>\r\n				<Element>\r\n					<String>PCRT_STORE_NAME</String>\r\n					<Attributes>\r\n						<Font Family="Arial" Size="14" Bold="True" Italic="False" Underline="False" Strikeout="False" />\r\n						<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n					</Attributes>\r\n				</Element>\r\n			</StyledText>\r\n		</TextObject>\r\n		<Bounds X="331" Y="88" Width="3146.78111587983" Height="289.519317626953" />\r\n	</ObjectInfo>\r\n	<ObjectInfo>\r\n		<TextObject>\r\n			<Name>TEXT</Name>\r\n			<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n			<BackColor Alpha="0" Red="255" Green="255" Blue="255" />\r\n			<LinkedObjectName></LinkedObjectName>\r\n			<Rotation>Rotation0</Rotation>\r\n			<IsMirrored>False</IsMirrored>\r\n			<IsVariable>False</IsVariable>\r\n			<HorizontalAlignment>Left</HorizontalAlignment>\r\n			<VerticalAlignment>Top</VerticalAlignment>\r\n			<TextFitMode>ShrinkToFit</TextFitMode>\r\n			<UseFullFontHeight>True</UseFullFontHeight>\r\n			<Verticalized>False</Verticalized>\r\n			<StyledText>\r\n				<Element>\r\n					<String>PCRT_STOCK_NAME</String>\r\n					<Attributes>\r\n						<Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\r\n						<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n					</Attributes>\r\n				</Element>\r\n			</StyledText>\r\n		</TextObject>\r\n		<Bounds X="348.188841201717" Y="453.669520431322" Width="3155.02157343918" Height="278.819732666016" />\r\n	</ObjectInfo>\r\n	<ObjectInfo>\r\n		<TextObject>\r\n			<Name>TEXT_1</Name>\r\n			<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n			<BackColor Alpha="0" Red="255" Green="255" Blue="255" />\r\n			<LinkedObjectName></LinkedObjectName>\r\n			<Rotation>Rotation0</Rotation>\r\n			<IsMirrored>False</IsMirrored>\r\n			<IsVariable>False</IsVariable>\r\n			<HorizontalAlignment>Left</HorizontalAlignment>\r\n			<VerticalAlignment>Top</VerticalAlignment>\r\n			<TextFitMode>ShrinkToFit</TextFitMode>\r\n			<UseFullFontHeight>True</UseFullFontHeight>\r\n			<Verticalized>False</Verticalized>\r\n			<StyledText>\r\n				<Element>\r\n					<String>PCRT_PRICE</String>\r\n					<Attributes>\r\n						<Font Family="Arial" Size="16" Bold="False" Italic="False" Underline="False" Strikeout="False" />\r\n						<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n					</Attributes>\r\n				</Element>\r\n			</StyledText>\r\n		</TextObject>\r\n		<Bounds X="3568.42919188405" Y="93.2188698437081" Width="1269.97853343784" Height="513.733895756145" />\r\n	</ObjectInfo>\r\n	<ObjectInfo>\r\n		<TextObject>\r\n			<Name>TEXT_2</Name>\r\n			<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n			<BackColor Alpha="0" Red="255" Green="255" Blue="255" />\r\n			<LinkedObjectName></LinkedObjectName>\r\n			<Rotation>Rotation0</Rotation>\r\n			<IsMirrored>False</IsMirrored>\r\n			<IsVariable>False</IsVariable>\r\n			<HorizontalAlignment>Center</HorizontalAlignment>\r\n			<VerticalAlignment>Top</VerticalAlignment>\r\n			<TextFitMode>ShrinkToFit</TextFitMode>\r\n			<UseFullFontHeight>True</UseFullFontHeight>\r\n			<Verticalized>False</Verticalized>\r\n			<StyledText>\r\n				<Element>\r\n					<String>PCRT_SERIAL_NUMBER</String>\r\n					<Attributes>\r\n						<Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\r\n						<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\r\n					</Attributes>\r\n				</Element>\r\n			</StyledText>\r\n		</TextObject>\r\n		<Bounds X="360.1630859375" Y="712.017150878906" Width="4398.34765625" Height="232.982833862305" />\r\n	</ObjectInfo>\r\n</DieCutLabel>');


-- 
-- Table structure for table `storevars`
-- 

CREATE TABLE `storevars` (
  `varid` int(11) NOT NULL auto_increment,
  `value` mediumtext collate utf8_unicode_ci NOT NULL,
  `varname` mediumtext collate utf8_unicode_ci NOT NULL,
  UNIQUE KEY `varid` (`varid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- 
-- Table structure for table `sub_cats`
-- 

CREATE TABLE `sub_cats` (
  `sub_cat_id` int(11) NOT NULL auto_increment,
  `sub_cat_name` mediumtext collate utf8_unicode_ci NOT NULL,
  `sub_cat_item_total` int(11) NOT NULL default '0',
  `sub_cat_parent` int(11) NOT NULL default '0',
  UNIQUE KEY `sub_cat_id` (`sub_cat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=101 ;

-- 
-- Dumping data for table `sub_cats`
-- 

INSERT INTO `sub_cats` (`sub_cat_id`, `sub_cat_name`, `sub_cat_item_total`, `sub_cat_parent`) VALUES (3, '56k Modems', 0, 4),
(4, 'Printer Cables', 0, 8),
(5, 'Sound Cards', 0, 9),
(6, 'USB Cables', 1, 8),
(7, 'KVM & Monitor Cables', 0, 8),
(8, 'Cases', 0, 11),
(9, 'Power Supplies', 0, 11),
(10, 'Memory Card Readers', 0, 5),
(11, 'CD-ROM', 0, 1),
(12, 'CD-RW', 0, 1),
(13, 'DVD-ROM', 0, 1),
(14, 'Game Controllers', 0, 7),
(15, 'Keyboards', 0, 2),
(16, 'Mice', 0, 2),
(17, 'Mouse Pads', 0, 2),
(18, 'Network Cards', 0, 4),
(19, 'Wireless Routers', 0, 4),
(20, 'Network Hubs & Switches', 0, 4),
(21, 'Wireless Network Cards', 0, 4),
(22, 'Floppy Drives', 0, 1),
(23, 'AGP Video Cards', 0, 6),
(24, 'Headphones', 0, 9),
(25, 'Surge Protectors', 0, 11),
(40, 'Serial Cables', 0, 8),
(68, 'PC Mods', 0, 11),
(56, 'InkJet', 0, 16),
(26, 'USB Hubs', 0, 8),
(38, 'Network & Ethernet', 0, 8),
(33, 'Cleaners', 0, 12),
(35, 'Speaker Systems', 0, 9),
(84, 'Inkjet Cartridges', 0, 16),
(82, 'RAM - DDR2', 0, 17),
(89, 'Notebook Computers', 0, 19),
(27, 'Controller Cards', 0, 8),
(44, 'DSL Modems', 0, 4),
(34, 'Game Adapters/Cables', 0, 7),
(47, 'CDRW DVD Combo Drives', 0, 1),
(29, 'CDR Blank Disks', 0, 15),
(30, 'Wireless Mice/Keyboards', 0, 2),
(46, 'Motherboards - Intel', 0, 17),
(45, 'CPU - Intel ', 0, 17),
(55, 'Racks and Cages', 0, 1),
(53, 'CD DVD Cases', 0, 15),
(62, 'Floppy Disks', 0, 15),
(76, 'PCI Express', 0, 6),
(85, 'Corded Phones', 0, 20),
(80, 'Custom Ready Built Systems', 0, 19),
(31, 'Routers', 0, 4),
(32, 'All-in-one ', 0, 16),
(41, 'CPU - AMD', 0, 17),
(60, 'Microphones', 0, 9),
(50, 'Operating Systems', 0, 18),
(54, 'RAM - SDRAM', 0, 17),
(88, 'Cases', 0, 15),
(36, 'CPU Fans & Heatsinks', 0, 17),
(43, 'Case Fans', 0, 11),
(37, 'Power Splitters & Adapters', 0, 11),
(39, 'Keyboard Adapters', 0, 8),
(42, 'Web Cams', 0, 6),
(90, 'Notebook Accessories', 0, 19),
(75, 'Special Order', 0, 12),
(52, 'UPS', 0, 11),
(51, 'DVD Media', 0, 15),
(59, 'Drive Cables', 0, 8),
(48, 'RAM - DDR', 0, 17),
(58, 'DVD-RW', 0, 1),
(66, 'USB Flash Drives', 0, 1),
(61, 'Phone Cords & Adapters', 0, 8),
(49, '3.5 IDE Hard Drives', 0, 1),
(64, 'Driver Controllers', 0, 1),
(81, 'Used Systems', 0, 19),
(72, 'Batteries', 0, 12),
(57, 'Flatbed Scanners', 0, 16),
(65, 'CD Labels', 0, 15),
(73, 'PCI Video Cards', 0, 6),
(71, 'Office Suites', 0, 18),
(91, 'Coax', 0, 8),
(63, 'Motherboards - AMD', 0, 17),
(69, 'Monitors/Displays', 0, 6),
(70, 'Video Capture', 0, 6),
(77, 'Mice -- Generic', 0, 2),
(67, 'Audio Cables', 0, 8),
(79, 'RAM - SODIMMS', 0, 17),
(74, 'Printer Paper', 0, 12),
(78, 'Keyboards - Generic', 0, 2),
(83, '3.5 SATA Hard Drives', 0, 1),
(86, 'Cordless Phones', 0, 20),
(87, 'Media Other', 0, 15),
(92, 'Speaker Wire', 0, 8),
(93, 'AC Power', 0, 8),
(94, 'AV Cables', 0, 8),
(95, 'External Hard Drives', 0, 1),
(98, 'Memory Cards', 0, 15),
(100, 'Toners', 0, 16),
(96, '2.5 IDE Hard Drives', 0, 1),
(97, '2.5 SATA Hard Drive', 1, 1),
(99, 'Laser Printers', 0, 16);




-- 
-- Table structure for table `suppliers`
-- 

CREATE TABLE `suppliers` (
  `supplierid` int(11) NOT NULL auto_increment,
  `suppliername` text NOT NULL,
  `supplieraddress1` text NOT NULL,
  `supplieraddress2` text NOT NULL,
  `suppliercity` text NOT NULL,
  `supplierstate` text NOT NULL,
  `supplierzip` text NOT NULL,
  `supplierphone` text NOT NULL,
  `supplieremail` text NOT NULL,
  `supplierwebsite` text NOT NULL,
  `suppliernotes` text NOT NULL,
  `supplieraccountno` text NOT NULL,
  UNIQUE KEY `supplierid` (`supplierid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `swatches`
--

CREATE TABLE IF NOT EXISTS `swatches` (
  `swatchid` int(11) NOT NULL AUTO_INCREMENT,
  `sw1` text NOT NULL,
  `sw2` text NOT NULL,
  `sw3` text NOT NULL,
  `sw4` text NOT NULL,
  PRIMARY KEY (`swatchid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=55 ;

--
-- Dumping data for table `swatches`
--

INSERT INTO `swatches` (`swatchid`, `sw1`, `sw2`, `sw3`, `sw4`) VALUES
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
(54, 'f4f4f4', 'bcbcbc', 'ffffff', '515151');



CREATE TABLE IF NOT EXISTS `custtags` (
  `tagid` int(11) NOT NULL AUTO_INCREMENT,
  `thetag` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `tagenabled` int(11) NOT NULL DEFAULT '1',
  `tagicon` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `theorder` int(11) NOT NULL,
  PRIMARY KEY (`tagid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=26 ;

--
-- Dumping data for table `custtags`
--

INSERT INTO `custtags` (`tagid`, `thetag`, `tagenabled`, `tagicon`, `theorder`) VALUES
(1, 'Crappy Computer', 1, '1f4a9.png', 0),
(2, 'Great Customer', 1, '1f4b0.png', 105),
(3, 'Slow Paying Customer', 1, '1f422.png', 95),
(5, 'Night Shift Customer', 1, '1f303.png', 30),
(6, 'Refuse Service', 1, '26d4.png', 110),
(7, 'Gamer', 1, '1f3ae.png', 35),
(8, 'Previous Water Damage', 1, '1f4a6.png', 5),
(9, 'Doctor', 1, '1f3e8.png', 40),
(10, 'Premier Business Client', 1, '1f4bc.png', 50),
(11, 'Buggy Computer', 1, '1f41e.png', 10),
(12, 'Special Needs', 1, '267f.png', 60),
(13, 'Slow Computer', 1, '1f40c.png', 15),
(14, 'Always Call Customer', 1, '1f4de.png', 100),
(15, 'Smoker', 1, '1f6ad.png', 55),
(16, 'Online Gambler', 1, '2663.png', 65),
(17, 'Cash Only', 1, '1f4b5.png', 115),
(19, 'Temperamental', 1, '1f621.png', 70),
(20, 'Hard of Hearing', 1, '1f442.png', 80),
(21, '-Customer Tags', 1, '', 85),
(22, '-Device Tags', 1, '', 20),
(23, '-Billing Tags', 1, '', 120),
(24, 'Government/Politician', 1, '1f451.png', 25),
(25, 'Tax Exempt', 1, '1f4b5.png', 90);



-- 
-- Table structure for table `taxes`
-- 

CREATE TABLE `taxes` (
  `taxid` int(11) NOT NULL auto_increment,
  `taxname` mediumtext collate utf8_unicode_ci NOT NULL,
  `taxrateservice` decimal(11,5) NOT NULL default '0.00000',
  `taxrategoods` decimal(11,5) NOT NULL default '0.00000',
  `taxenabled` int(11) NOT NULL default '1',
  `shortname` mediumtext collate utf8_unicode_ci NOT NULL,
  `isgrouprate` int(11) NOT NULL default '0',
  `compositerate` mediumtext collate utf8_unicode_ci NOT NULL,
  `delme` mediumtext collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`taxid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;
-- 
-- Dumping data for table `taxes`
-- 

INSERT INTO `taxes` (`taxid`, `taxname`, `taxrateservice`, `taxrategoods`, `taxenabled`, `shortname`, `isgrouprate`, `compositerate`) VALUES (1, 'Tax Exempt', 0.00000, 0.00000, 1, 'EX', 0, ''),
(2, 'Old Tax Rate', 0.00000, 0.00000, 1, '', 0, '');


-- 
-- Table structure for table `techdocs`
-- 

CREATE TABLE `techdocs` (
  `techdoccatid` int(11) NOT NULL auto_increment,
  `techdoccatname` mediumtext collate utf8_unicode_ci NOT NULL,
  UNIQUE KEY `techdoccatid` (`techdoccatid`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;
-- 
-- Dumping data for table `techdocs`
-- 

INSERT INTO `techdocs` (`techdoccatid`, `techdoccatname`) VALUES (1, 'Windows XP'),
(2, 'Windows 7'),
(3, 'Windows Vista'),
(4, 'Networking'),
(5, 'Virus Removal'),
(6, 'Hardware'),
(7, 'Apple - MAC'),
(8, 'Printers'),
(9, 'Routers'),
(10, 'Software'),
(12, 'Other');

-- --------------------------------------------------------


CREATE TABLE `timers` (
  `timerid` int(11) NOT NULL auto_increment,
  `woid` int(11) NOT NULL,
  `timerstart` datetime NOT NULL default '0000-00-00 00:00:00',
  `timerstop` datetime NOT NULL default '0000-00-00 00:00:00',
  `timertotal` int(11) NOT NULL default '0',
  `timerdesc` mediumtext NOT NULL,
  `billedout` int(11) NOT NULL default '0',
  `byuser` text NOT NULL,
  `pcgroupid` int(11) NOT NULL default '0',
  `blockcontractid` int(11) NOT NULL,
  `savedround` int(11) NOT NULL default '0',
  PRIMARY KEY  (`timerid`),
  KEY `woid` (`woid`),
  KEY `pcgroupid` (`pcgroupid`),
  KEY `blockcontractid` (`blockcontractid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- 
-- Table structure for table `travellog`
-- 

CREATE TABLE `travellog` (
  `tlid` int(11) NOT NULL auto_increment,
  `tlwo` int(11) NOT NULL default '0',
  `tldate` datetime NOT NULL,
  `tlmiles` decimal(11,1) NOT NULL,
  `traveluser` text NOT NULL,
  UNIQUE KEY `tlid` (`tlid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------


CREATE TABLE `userlog` (
  `userlogid` int(11) NOT NULL auto_increment,
  `actionid` int(11) NOT NULL,
  `thedatetime` datetime NOT NULL,
  `refid` int(11) NOT NULL,
  `reftype` varchar(15) collate utf8_unicode_ci NOT NULL,
  `loggeduser` varchar(30) collate utf8_unicode_ci NOT NULL,
  `mensaje` mediumtext collate utf8_unicode_ci NOT NULL,
  UNIQUE KEY `userlogid` (`userlogid`),
  KEY `refid` (`refid`),
  KEY `actionid` (`actionid`),
  KEY `reftype` (`reftype`),
  KEY `loggeduser` (`loggeduser`),
  KEY `thedatetime` (`thedatetime`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

-- 
-- Table structure for table `users`
-- 

CREATE TABLE IF NOT EXISTS `users` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `userpass` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `currenttaxid` int(11) NOT NULL DEFAULT '1',
  `scanrecordview` int(11) NOT NULL DEFAULT '0',
  `theperms` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `lastseen` datetime NOT NULL,
  `touchrefresh` int(11) NOT NULL DEFAULT '300',
  `gomodal` tinyint(1) NOT NULL DEFAULT '0',
  `touchwide` tinyint(4) NOT NULL DEFAULT '3',
  `stickywide` tinyint(4) NOT NULL DEFAULT '3',
  `autoprint` tinyint(4) NOT NULL DEFAULT '1',
  `touchview` int(11) NOT NULL DEFAULT '2',
  `floatbar` int(11) NOT NULL DEFAULT '1',
  `defaultstore` int(11) NOT NULL DEFAULT '0',
  `statusview` int(11) NOT NULL DEFAULT '0',
  `useremail` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `usermobile` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `narrow` int(11) NOT NULL DEFAULT '0',
  `narrowct` int(11) NOT NULL DEFAULT '0',
  `timeclockperms` text COLLATE utf8_unicode_ci NOT NULL,
  `defloc` tinyint(4) NOT NULL DEFAULT '1',
  `locperms` text COLLATE utf8_unicode_ci NOT NULL,
  `deptperms` text COLLATE utf8_unicode_ci NOT NULL,
  `pin` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `enabled` int(11) NOT NULL DEFAULT '1',
  `lastmessage` int(11) NOT NULL DEFAULT '0',
  `notifytime` datetime NOT NULL,
  `promiseview` int(11) NOT NULL DEFAULT '0',
  `twofactor` int(11) NOT NULL DEFAULT '0',
  `twofactorpassword` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `ledgerid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

-- 
-- Dumping data for table `users`
-- 

INSERT INTO `users` (`userid`, `username`, `userpass`, `currenttaxid`, `theperms`, `lastseen`, `defaultstore`) VALUES (1, 'admin', '3c41ff681c1e3dcb68b4d8573bf1c74c', 0, '',NOW(),'1');


CREATE TABLE `wonotes` (
  `noteid` int(11) NOT NULL auto_increment,
  `notetype` int(11) NOT NULL,
  `thenote` mediumtext NOT NULL,
  `noteuser` text NOT NULL,
  `notetime` datetime NOT NULL,
  `woid` int(11) NOT NULL,
  UNIQUE KEY `noteid` (`noteid`),
  KEY `notetype` (`notetype`),
  KEY `woid` (`woid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



-- 
-- Table structure for table `allowedip`
-- 

CREATE TABLE `allowedip` (
  `ipid` int(11) NOT NULL auto_increment,
  `ipaddress` text collate utf8_unicode_ci NOT NULL,
  `dateadded` date NOT NULL,
  `lastaccess` date NOT NULL,
  PRIMARY KEY  (`ipid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `departments`
-- 

CREATE TABLE `departments` (
  `deptid` int(11) NOT NULL auto_increment,
  `deptcode` mediumtext collate utf8_unicode_ci NOT NULL,
  `deptname` mediumtext collate utf8_unicode_ci NOT NULL,
  UNIQUE KEY `deptid` (`deptid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `employees`
-- 

CREATE TABLE `employees` (
  `employeeid` int(11) NOT NULL auto_increment,
  `clocknumber` int(11) default '0',
  `employeename` varchar(255) collate utf8_unicode_ci default NULL,
  `isactive` int(11) NOT NULL default '1',
  `location` int(11) NOT NULL default '1',
  `deptid` int(11) NOT NULL default '0',
  `fulltime` int(11) NOT NULL default '0',
  `linkeduser` text COLLATE utf8_unicode_ci NOT NULL,
  `wage` decimal(11,2) NOT NULL,
  PRIMARY KEY  (`employeeid`),
  KEY `clocknumber` (`clocknumber`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `ephotos`
-- 

CREATE TABLE `ephotos` (
  `ephotoid` int(11) NOT NULL auto_increment,
  `eid` int(11) NOT NULL,
  `photofilename` mediumtext collate utf8_unicode_ci NOT NULL,
  `addtime` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`ephotoid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `locations`
-- 

CREATE TABLE `locations` (
  `locid` int(11) NOT NULL auto_increment,
  `locname` mediumtext collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`locid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `punches`
-- 

CREATE TABLE `punches` (
  `punchid` int(11) NOT NULL auto_increment,
  `employeeid` int(11) NOT NULL,
  `punchstatus` mediumtext collate utf8_unicode_ci NOT NULL,
  `punchin` datetime NOT NULL,
  `punchout` datetime NOT NULL,
  `medit` mediumtext collate utf8_unicode_ci NOT NULL,
  `thein` mediumtext collate utf8_unicode_ci NOT NULL,
  `theout` mediumtext collate utf8_unicode_ci NOT NULL,
  `editnote` mediumtext collate utf8_unicode_ci NOT NULL,
  `servertime` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `punchtype` int(11) NOT NULL default '1',
  `punchtypeout` int(11) NOT NULL default '1',
  `breakin` datetime NOT NULL,
  `breakout` datetime NOT NULL,
  PRIMARY KEY  (`punchid`),
  KEY `employeeid` (`employeeid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

