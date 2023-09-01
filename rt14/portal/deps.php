<?php


#MySQL Database information
$dbhost = "localhost";
$dbuname = "EnterDatabaseUsername";
$dbpass = "EnterDatabasePassword";
$dbname = "EnterDatabaseName";

#timezone - go to http://www.php.net/manual/en/timezones.php for accepable values.
$pcrt_timezone = "America/Detroit";

# The day to start calendar weeks: Sunday or Monday.
$pcrt_weekstart = "Sunday";


#Array of Available Languages. Do not Remove the en-us default language
$pcrtmasterlanguagelist = array(
"en-us" => "English (United States)",
"en-gb" => "English (Great Britian)"
);

#PCRT System Language. Choose a value from above.
$mypcrtlanguage = "en-us";

#Business Name
$businessname = "PC Repair Tracker";

#Store Email
$storeemail = "you@website.com";

# Service line that prints below your logo on receipts
$servicebyline = "Computer Parts Sales &amp; Service";

#Business Homepage
$homepage = "http://www.yoursite.com";

#Location of the portal folder:
$domain = "http://www.yoursite.com/tracker/portal";

#Secure location of the portal folder:
$securedomain = "https://www.yoursite.com/tracker/portal";

# Autofire Print Dialogs 0 = no, 1 = yes
$autoprint = "1";

# Allow automatic group creation when email address is matched on an asset.
$pcrt_allowgroupcreation = "yes";

# Number of days old an invoice is considered overdue
$invoiceoverduedays = "21";

#Your Logo
$logo = "images/logo.png";
$printablelogo = "images/logoprintable.png";

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
$pcrt_pear_port = "587";
# SMTP Username
$pcrt_pear_username = "";
# SMTP Password
$pcrt_pear_password = "";
# Path to Pear Modules - uncomment both lines to use.
#$pearpath = "/home/userfolder/php";
#ini_set("include_path", "$pearpath:" . ini_get("include_path"));


# Set Monetary Symbol
# &#36; for dollars, &8364; for euros, &#163; for pounds
$money = "&#36;";

# Date/Time Settings
# Month Options: FULL_MONTH_NAME ABBR_MONTH_NAME NUMBERIC_MONTH_LEADING_ZERO NUMERIC_MONTH_NO_LEADING_ZERO
# Day Options: NUMERIC_DAY_LEADING_ZERO NUMERIC_DAY_NO_LEADING_ZERO DAY_OF_WEEK_ABBR DAY_OF_WEEK_FULL ENGLISH_SUFFIX
# Year Options: 4_DIGIT_YEAR 2_DIGIT_YEAR
# Time Options: HOURS_NO_LEADING_ZERO HOURS_LEADING_ZERO 24_HOURS_NO_LEADING_ZEROS 24_HOURS_LEADING_ZERO MINUTES SECONDS AM_PM_LOWERCASE AM_PM_UPPERCASE
$pcrt_time = "HOURS_NO_LEADING_ZERO:MINUTES AM_PM_UPPERCASE";
$pcrt_shortdate = "4_DIGIT_YEAR-NUMERIC_MONTH_LEADING_ZERO-NUMERIC_DAY_LEADING_ZERO";
$pcrt_mediumdate = "ABBR_MONTH_NAME NUMERIC_DAY_NO_LEADING_ZERO, 4_DIGIT_YEAR";
$pcrt_longdate = "FULL_MONTH_NAME NUMERIC_DAY_NO_LEADING_ZERO, 4_DIGIT_YEAR";


#Address Labels

$pcrt_address1 = "Street Address/PO BOX";
$pcrt_address2 = "Apt/Suite Number";
#City, Town, Etc
$pcrt_city = "City";
#State, Province, Etc
$pcrt_state = "State";
#Zip, Postal Code, Etc
$pcrt_zip = "ZIP";

# Forms Signature Pad
# Allowed values: yes, no, topaz
$enablesignaturepad_forms = "no";


#demo mode
$demo = "no";


###############################
#Payment Methods
###############################
# Possible Values:  = "AuthorizeNetCP" "Stripe" "PayPal"
$paymentplugin = "";


#AuthorizeNetCP (Card Present) Settings does not apply to "generic" credit card or AuthorizeNet
$AuthorizeNetUrlCP = "https://cardpresent.authorize.net/gateway/transact.dll";
$AuthorizeNetLoginIDCP = "";
$AuthorizeNetTranKeyCP = "";

#Stripe Settings
$stripe_api_key = "sk_test_XXXXXXXXXXXXXXX";
$stripe_api_key_public = "pk_test_XXXXXXXXXXXXXX";
$stripe_currency = "usd";

#PayPal Payments Pro Settings
$PayPalenvironment = 'live';    // or 'beta-sandbox' or 'live'
$PayPalUsername = "ppu";
$PayPalPassword = "ppp";
$PayPalSignature = "ppsig";
$PayPalCountryCode = "US";      // US or other valid country code
$PayPalCurrencyCode = "USD";    // or other currency ('GBP', 'EUR', 'JPY', 'CAD', 'AUD')


#######################################
#Do not modify anything below this line
#######################################


require("dinit.php");

