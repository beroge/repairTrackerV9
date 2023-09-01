<?php

# MySQL Database information
$dbhost = "localhost";
$dbuname = "dbuser";
$dbpass = "dbpass";
$dbname = "pcrepairtracker";

$pcrt_stylesheet = "style.css";

#timezone - go to http://www.php.net/manual/en/timezones.php for acceptable values.
$pcrt_timezone = "America/Detroit";

# The day to start calendar weeks: Sunday or Monday.
$pcrt_weekstart = "Sunday";

#PCRT System Language. 
$mypcrtlanguage = "en-us";

#Location of the ledger folder:
$domain = "http://yourwebsite.com/ledger";

# Uncomment this line if you are having problems having to login again when processing ssl payments. Make sure to not remove the leading dot. 
#$cookiedomain = ".mydomain.com";

# Your System Name
$sitename = "PC Repair Tracker";

# Email Mailer Settings
# $pcrt_mailer: valid settings are ( mail | pearsmtp | pearphpmailer | pearsmtpauth )
# "mail" uses the builtin php mail function,
# "pearsmtp" uses the default pear smtp method,
# "pearphpmailer" the native php mailer through pear,
# "pearsmtpauth" uses pear and allows you to specify any smtp server with a username and password and/or custom port
# If you choose to use the pearsmtpauth you must specify your server host, username, password, and port number
$pcrt_mailer = "pearphpmailer";
# SMTP Server Hostname. Default: localhost Prefix with ssl:// to send securely if your server supports it
$pcrt_pear_host = "smtp.yourserver.com";
# SMTP Port: (25,587,465)
$pcrt_pear_port = "587";
# SMTP Username
$pcrt_pear_username = "you@yourserver.com";
# SMTP Password
$pcrt_pear_password = "secret";
# Path to Pear Modules - uncomment both lines to use.
#$pearpath = "/home/userfolder/php";
#ini_set("include_path", "$pearpath:" . ini_get("include_path"));


# Your Logo 
$logo = "../repair/images/logo.png";
$printablelogo = "../repair/images/logoprintable.png";

# Set monetary symbol
# &#36; for dollars, &8364; for euros, &#163; for pounds
$money = "&#36;";

# Date/Time Settings
# Month Options: <FULL_MONTH_NAME> <ABBR_MONTH_NAME> <NUMBERIC_MONTH_LEADING_ZERO> <NUMERIC_MONTH_NO_LEADING_ZERO>
# Day Options: <NUMERIC_DAY_LEADING_ZERO> <NUMERIC_DAY_NO_LEADING_ZERO> <DAY_OF_WEEK_ABBR> <DAY_OF_WEEK_FULL> <ENGLISH_SUFFIX>
# Year Options: <4_DIGIT_YEAR> <2_DIGIT_YEAR>
# Time Options: <HOURS_NO_LEADING_ZERO> <HOURS_LEADING_ZERO> <24_HOURS_NO_LEADING_ZEROS> <24_HOURS_LEADING_ZERO> <MINUTES> <SECONDS> <AM_PM_LOWERCASE> <AM_PM_UPPERCASE>
$pcrt_time = "24_HOURS_NO_LEADING_ZERO:MINUTES AM_PM_UPPERCASE";
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

# Word for Tax i.e. Tax, VAT, etc
$t_tax = "Tax";

#######################################
#Do not modify anything below this line
#######################################

require("dinit.php");
