<?php

# MySQL Database information
$dbhost = "localhost";
$dbuname = "ben";
$dbpass = "root";
$dbname = "rtVer9";

# timezone - go to http://www.php.net/manual/en/timezones.php for acceptable values.
$pcrt_timezone = "America/Detroit";

# The day to start calendar weeks: Sunday or Monday.
$pcrt_weekstart = "Sunday";

# Array of Available Languages. Do Not Remove the en-us default language.
$pcrtmasterlanguagelist = array("en-us" => "English (United States)","en-gb" => "English (Great Britian)");

# PCRT System Language. Choose a value from above.
$mypcrtlanguage = "en-us";

# Units Setting: METRIC or IMPERIAL
$pcrt_units = "IMPERIAL";

$sitename = "PC Repair Tracker System";

# Full Path to repair folder
$domain = "http://www.yourdomain.com/repair";

# Location of the repair status script: example: http://pcrepairtracker.com/repairstatus/index.php
$pcrt_repairstatusscript = "you need to enter the location of your repairstatus scripts in the repair deps.php file";

# Alternate PCRT Stylesheet default: style.css
$pcrt_stylesheet = "style.css";

# Array of Customer Assets with icons stored in images/assets/
$custassets = array("Laptop Power Adapter" => "charger.png","Laptop Bag" => "laptopbag.png","Power Cord" => "powercord.png","Printer" => "printer.png","System Discs" => "rdisc.png","Display" => "monitor.png","Modem" => "modem.png","Router" => "router.png","Flash Drive" => "flashdrive.png","External HD or CD" => "exthd.png" ,"Mouse" => "mouse.png","Keyboard" => "keyboard.png","AirCard" => "aircard.png","Charger" => "usbcharger.png","USB Sync/Charge Cord" => "synccord.png","Phone Case" => "phonecase.png","Sim Card" => "simcards.png","Car Charger" => "carcharger.png","Install Discs" => "installdiscs.png");

# Array of PC Priority's in the form of "Status Name" => "image contained in the repair/images folder". Must have at least one value
$pcpriority = array("High Priority" => "phigh.png","Medium Priority" => "pmedium.png","Low Priority" => "plow.png");

# Array of Customer Source Icons
$custsourceicons = array("billboard.png","emailornewsletter.png","facebook.png","flyer.png","googleadwords.png","linkedin.png","phonebook.png","regularcustomer.png","sponsor.png","storedriveby.png","unknown.png","wordofmouth.png","www.png","yp.png","newspaper.png");

# Your Logo
$logo = "images/logo.png";
$printablelogo = "images/logoprintable.png";

# d7 Integration - Report Upload Folder - Uncomment this to use it after creating your d7 directory.
#$d7_report_upload_directory = "../d7/";

# UVK Integration - Report Upload Folder
$uvk_report_upload_directory = "../uvk/";

# Email Mailer Settings
# $pcrt_mailer: valid settings are ( mail | pearsmtp | pearphpmailer | pearsmtpauth )
# "mail" uses the builtin php mail function, no need to configure the other settings
# "pearsmtp" uses the default pear smtp method,
# "pearphpmailer" the native php mailer through pear,
# "pearsmtpauth" uses pear and allows you to specify any smtp server with a username and password and/or custom port
# If you choose to use the pearsmtpauth you must specify your server host, username, password, and port number
$pcrt_mailer = "mail";
# SMTP Server Hostname. Default: localhost Prefix with ssl:// to send securely if your server supports it
$pcrt_pear_host = "localhost";
# SMTP Port: (25,587,465)
$pcrt_pear_port = "25";
# SMTP Username
$pcrt_pear_username = "my_smtp_username";
# SMTP Password
$pcrt_pear_password = "my_smtp_password";
# Path to Pear Modules - uncomment both lines to use.
#$pearpath = "/home/userfolder/php";
#ini_set("include_path", "$pearpath:" . ini_get("include_path"));


# Word for Tax i.e. Tax, VAT, etc
$t_tax = "Tax";

# Set monetary symbol
# &#36; for dollars, &#8364; for euros, &#163; for pounds
$money = "&#36;";


# Number of days old an invoice is considered overdue
$invoiceoverduedays = "21";


# Tax Inclusive Line Items
# 0 = no, 1 = yes
$taxinclusive = 0;


#Stored Credit Card Plugins - Must be an exaxt match of the values in the store/deps.php file
# Possible Values:  = array('Stripe','PaypalRest','AuthorizeNetCIM');
$storedpaymentplugins = array();


# Address Labels

$pcrt_address1 = "Street Address/PO BOX";
$pcrt_address2 = "Apt/Suite Number";
#City, Town, Etc
$pcrt_city = "City";
#State, Province, Etc
$pcrt_state = "State";
#Zip, Postal Code, Etc
$pcrt_zip = "ZIP";

# Date/Time Settings
# Month Options: FULL_MONTH_NAME ABBR_MONTH_NAME NUMBERIC_MONTH_LEADING_ZERO NUMERIC_MONTH_NO_LEADING_ZERO
# Day Options: NUMERIC_DAY_LEADING_ZERO NUMERIC_DAY_NO_LEADING_ZERO DAY_OF_WEEK_ABBR DAY_OF_WEEK_FULL ENGLISH_SUFFIX
# Year Options: 4_DIGIT_YEAR 2_DIGIT_YEAR
# Time Options: HOURS_NO_LEADING_ZERO HOURS_LEADING_ZERO 24_HOURS_NO_LEADING_ZEROS 24_HOURS_LEADING_ZERO MINUTES SECONDS AM_PM_LOWERCASE AM_PM_UPPERCASE
$pcrt_time = "HOURS_NO_LEADING_ZERO:MINUTES AM_PM_UPPERCASE";
$pcrt_shortdate = "4_DIGIT_YEAR-NUMERIC_MONTH_LEADING_ZERO-NUMERIC_DAY_LEADING_ZERO";
$pcrt_mediumdate = "ABBR_MONTH_NAME NUMERIC_DAY_NO_LEADING_ZERO, 4_DIGIT_YEAR";
$pcrt_longdate = "FULL_MONTH_NAME NUMERIC_DAY_NO_LEADING_ZERO, 4_DIGIT_YEAR";


# SMS Gateway to use: allowed values: redoxygen, bulksms, smsglobal, clickatell, clickatellrest, twilio, mymobileapi.com, none
# Twilio is highly recommended as it has better handling of numbers and higher deliverablity.

$mysmsgateway = "none";
$mysmsprefix = "1-";

# Filter SMS Number
# 0 = No Change to SMS Number
# 1 = Strip First Character from the Number

$smsnumberfilter = 0;

#SMS Global settings
$smsglobalusername = "myusername";
$smsglobalpassword = "mypassword";
#SMS source/from: MSIDSN or Sender ID that the message will appear from. Eg: 61409317436 (Do not use + before the country code)
$smsglobalsource = "MyNumber";

#BulkSMS settings
$bulksmsurl = "http://usa.bulksms.com/eapi/submission/send_sms/2/2.0";
$bulksmsusername = "yourusername";
$bulksmspassword = "yourpassword";

#Red Oxygen SMS Settings
$SMS_Data["AccountID"] = "CI000000000";
$SMS_Data["Email"] = "you@someplace.com";
$SMS_Data["Password"] = "mypassword";

#Clickatell SMS Settings
$clickatelluser = "yourusername";
$clickatellpassword = "yourpassword";
$clickatell_api_id = "api_id";
$clickatellbaseurl = "http://api.clickatell.com";
$clickatellfrom = "";

#Twilio SMS Settings
$twilio_account_sid = "";
$twilio_auth_token = "";
$twilio_sms_number = "+1 111-222-3333";

#MyMobileAPI.com
$mymobileapi_username = "";
$mymobileapi_password = "";


#Number of Recent Jobs to show at bottom of status list
$showrecentjobs = 15;

#demo mode
$demo = "no";

# Allowed values: yes, no, topaz
# Claim Ticket Signature Pad
$enablesignaturepad_claimticket = "no";
# Repair Report Signature Pad
$enablesignaturepad_repairreport = "no";
# Checkout Receipt Signature Pad
$enablesignaturepad_checkoutreceipt = "no";
# Forms Signature Pad
$enablesignaturepad_forms = "no";

# Your Dropbox Credentials
# Must have a Dropbox Account
# Go to "My Apps" at https://www.dropbox.com/developers/apps to create an "App"
# Select "Create an App, pick "Dropbox API", pick "App Folder", give it a unique name.
# Generate and copy the token and enter it here.
# Make sure attachements folder is writable permissions wise.
$dropboxaccessToken = '';


# Google Maps API Key:
$googlemapsapikey = "";
# You must signup for one to use this feature here:
# https://developers.google.com/maps/documentation/javascript/get-api-key#get-an-api-key



#######################################
#Do not modify anything below this line
#######################################

require("dinit.php");
