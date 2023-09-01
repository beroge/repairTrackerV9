<?php

#MySQL Database information
$dbhost = "localhost";
$dbuname = "";
$dbpass = "";
$dbname = "pcrepairtracker";

#timezone - go to http://www.php.net/manual/en/timezones.php for accepable values.
$pcrt_timezone = "America/Detroit";

#PCRT System Language.
$mypcrtlanguage = "en-us";


#Address Labels

$pcrt_address1 = "Street Address/PO BOX";
$pcrt_address2 = "Apt/Suite Number";
#City, Town, Etc
$pcrt_city = "City";
#State, Province, Etc
$pcrt_state = "State";
#Zip, Postal Code, Etc
$pcrt_zip = "ZIP";

#Maximum number of Service Requests per IP within X number of days (helps slow down spammers) 
$maxcount = 50;
$withindays = 2;

# Notifications
# Send Email to OnCall Technician
$oncallsendemail = "yes";
# Send text message to OnCall Technician
$oncallsendsms = "no";

# Allow user to choose a store/location
$allowusertochoosestore = "yes";

#ReCaptcha Settings - Go here to sign up and get your keys: https://www.google.com/recaptcha/admin
# I would recommend only using the captcha if you have the SMS feature enabled and want to cut down on sms spam.
$recaptcha_enable = "no";
$recaptcha_public_key = "";
$recaptcha_private_key = "";


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


#SMS Gateway to use: allowed values: redoxygen, bulksms, smsglobal, clickatell, google, twilio, freesmsgateway.com, mymobileapi.com, none

$mysmsgateway = "none";
$mysmsprefix = "1-";

# Filter SMS Number
# 0 = No Change to SMS Number
# 1 = Strip First Character from the Number

$smsnumberfilter = 0;

#SMS Global settings
$smsglobalusername = "";
$smsglobalpassword = "";
#SMS source/from: MSIDSN or Sender ID that the message will appear from. Eg: 61409317436 (Do not use + before the country code)
$smsglobalsource = "";

#BulkSMS settings
$bulksmsurl = "http://usa.bulksms.com/eapi/submission/send_sms/2/2.0";
$bulksmsusername = "";
$bulksmspassword = "";

#Red Oxygen SMS Settings
$SMS_Data["AccountID"] = "";
$SMS_Data["Email"] = "";
$SMS_Data["Password"] = "";

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

# FreeSMSGateway.com
$freesmsgatewaycom_access_token = "";

#MyMobileAPI.com
$mymobileapi_username = "";
$mymobileapi_password = "";



