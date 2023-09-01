<?php

# MySQL Database information
$dbhost = "localhost";
$dbuname = "ben";
$dbpass = "root";
$dbname = "rtVer9";


#timezone - go to http://www.php.net/manual/en/timezones.php for acceptable values.
$pcrt_timezone = "America/Detroit";

# The day to start calendar weeks: Sunday or Monday.
$pcrt_weekstart = "Sunday";

#Array of Available Languages. Do not Remove the en-us default language.
$pcrtmasterlanguagelist = array("en-us" => "English (United States)","en-gb" => "English (Great Britian)");

#PCRT System Language. Choose a value from above.
$mypcrtlanguage = "en-us";

# Units Setting: METRIC or IMPERIAL
$pcrt_units = "IMPERIAL";

# Full path to the "store" folder
$domain = "http://www.yourdomain.com/store";

#Secure Location of the store folder: This is the URL used when entering complete credit card numbers
$securedomain = "https://www.yourdomain.com/store";

# Uncomment this line if you are having problems having to login again when processing ssl payments. Make sure to not remove the leading dot.
#$cookiedomain = ".mydomain.com";

# Alternate PCRT Stylesheet default: style.css
$pcrt_stylesheet = "style.css";


# Array with color for order planning feature
$shopliststatus = array('Need to Order' => 'ffaaaa', 'Ordered' => 'aaaaff', 'Need Supplier' => 'fff284', 'Requested by Customer' => 'ff8d65', 'Future Expansion Item' => '98ff98');

# Your System Name
$sitename = "PC Repair Tracker - Point of Sale";

# Email Mailer Settings
# $pcrt_mailer: valid settings are ( mail | pearsmtp | pearphpmailer | pearsmtpauth )
# "mail" uses the builtin php mail function,
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


# Your Logo 
$logo = "images/logo.png";
$printablelogo = "images/logoprintable.png";

# Service line that prints below your logo on receipts
$servicebyline = "Computer Parts Sales &amp; Service";

# Number of days old an invoice is considered overdue
$invoiceoverduedays = "21";

# Default Recurring Invoice Period: 1W, 2W, 1M, 2M, 3M, 6M, 1Y
$recurringinvoiceinterval = "1M";

#Number of days after sale that returns are allowed only by the admin user.
$returndays = 14;

# Set monetary symbol
# &#36; for dollars, &#8364; for euros, &#163; for pounds
$money = "&#36;";

# Tax Inclusive Line Items
# 0 = no, 1 = yes
$taxinclusive = 0;


#Address Labels

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


#demo mode
$demo = "no";

###############################
#Payment Methods
###############################
# Below are all the plugins currently available, remove the ones you do not plan on using.
# Possible Values:  = array('Cash','Check','GenericCreditCard','AuthorizeNet','AuthorizeNetCP','PayPal','CustomPayment','SagePayments','Bluepay','Stripe','MyVirtualMerchant','FirstData','Payeezy','Square');
$paymentplugins = array('Cash','Check','GenericCreditCard');

# Stored Credit Card Plugins - Must be an exaxt match of the values in the store/deps.php file
# Possible Values:  = array('Stripe','PayPal','AuthorizeNetCIM');
$storedpaymentplugins = array();


# Checks written over this amount with require the user to enter a drivers license number.
$pcrt_driverslc_minimum = 100;

# AuthorizeNet Settings does not apply to "generic" credit card or AuthorizeNetCP
# $AuthorizeNetUrl = "https://test.authorize.net/gateway/transact.dll";
$AuthorizeNetUrl = "https://secure.authorize.net/gateway/transact.dll";
$AuthorizeNetLoginID = "";
$AuthorizeNetTranKey = "";

# AuthorizeNetCP (Card Present) Settings does not apply to "generic" credit card or AuthorizeNet
$AuthorizeNetUrlCP = "https://cardpresent.authorize.net/gateway/transact.dll";
$AuthorizeNetLoginIDCP = "";
$AuthorizeNetTranKeyCP = "";

# AuthorizeNet XML CIM stored cards plugin.
$AuthorizeNetCIM_apilogin = ""; // Keep this secure.
$AuthorizeNetCIM_transactionkey = ""; // Keep this secure.
$AuthorizeNetCIM_apihost = "api2.authorize.net";
$AuthorizeNetCIM_apipath = "/xml/v1/request.api";

# PayPal Website Payments Pro Settings
$PayPalenvironment = 'sandbox'; // or 'beta-sandbox' or 'live' or 'sandbox'
$PayPalUsername = "";
$PayPalPassword = "";
$PayPalSignature = "";
$PayPalCountryCode = "US";      // US or other valid country code
$PayPalCurrencyCode = "USD";    // or other currency ('GBP', 'EUR', 'JPY', 'CAD', 'AUD')

# PayPal REST Api Credentials
$PaypalclientId = "";
$PaypalclientSecret = "";
$Paypalmode = "live";
$PayPalRestCurrencyCode = "USD";    // or other currency ('GBP', 'EUR', 'JPY', 'CAD', 'AUD')

# Sage Payments Settings
#Merchant ID
$SagePayments_mid = "";
#Merchant Key
$SagePayments_mkey = "";

# Bluepay Settings
$BluepayNetUrl = "https://secure.bluepay.com/gateway/transact.dll";
$BluepayAccountId = "";
$BluepaySecretKey = "";

# Stripe Settings
$stripe_api_key = "sk_test_sdfgsdfgsdfgsdfgsdfg";
$stripe_api_key_public = "pk_test_sdfgsdfgsdfgsdfg";
$stripe_currency = "usd";

# MyVirtualMerchant Settings - Elavon Inc.
# Production URL: https://www.myvirtualmerchant.com/VirtualMerchant/process.do
$mvm_url = "https://demo.myvirtualmerchant.com/VirtualMerchantDemo/process.do";
$mvm_merchant_id = "";
$mvm_user_id = "";
$mvm_pin = "";

#First Data Global E4
$firstdataglobale4_url = 'https://api.globalgatewaye4.firstdata.com/transaction/v11';
$firstdataglobale4_gatewayid = "";
$firstdataglobale4_password = "";

#Payeezy
$payeezy_gatewayid = "";
$payeezy_password = "";

# Square
# Must create an "App" at https://connect.squareup.com/apps
# You will also find your Personal Access Token here.
# Must run this from a linux command line to fetch your location ids:
# curl -H "Authorization: Bearer PERSONAL ACCESS_TOKEN" https://connect.squareup.com/v2/locations
$SquareApplicationId = "";
$SquareLocationId = "";
$SquareAccessToken = "";



#Custom Payment Definitions
#Do not print these fields with these names on receipts
$CustomPaymentPrintExclude = array('Bank Account Number','Routing Number');

# Paypal Payment Link for Emailed Invoices
# Your Paypal Email Address
$paypalonlineemail = "";
# Your Currency Code:
# Common Values: USD = US Dollars, EUR = Euro, AUD = Austrailian Dollar, CAD = Canadian Dollar, GBP = Pound Sterling
$paypalcountrycurrencycode = "USD";


###############################

# Word for Tax i.e. Tax, VAT, etc
$t_tax = "Tax";

# Show Shortname or Full Tax Name on tax totals on receipts and invoices. Valid Settings (short|full)
$pcrt_showtax_total = "short";

#Allowed values: yes, no, topaz
#Receipt Signature Pad
$enablesignaturepad_receipt = "no";
#Invoice Signature Pad
$enablesignaturepad_invoice = "no";
#Deposit Receipt Signature Pad
$enablesignaturepad_deposits = "no";



#######################################
#Do not modify anything below this line
#######################################

require("dinit.php");
