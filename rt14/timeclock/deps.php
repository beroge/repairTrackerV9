<?php

# MySQL Database information
$dbhost = "localhost";
$dbuname = "ben";
$dbpass = "root";
$dbname = "rtVer9";


#timezone - go to http://www.php.net/manual/en/timezones.php for accepable values.
$pcrt_timezone = "America/Detroit";

# The day to start calendar weeks: Sunday or Monday.
$pcrt_weekstart = "Sunday";

# The day to start work weeks: Sunday or Monday.
$pcrt_workweekstart = "Sunday";

# 12 or 24 hour clock
$pcrt_hours24 = "12";

#PCRT System Language.
$mypcrtlanguage = "en-us";

$sitename = "PCRT Timeclock";
$systemname = "PCRT Timeclock";

# Domain
$domain = "http://yourdomain.com/PCRT/timeclock/";

#Your Logo
$logo = "../repair/images/logo.png";

# Date/Time Settings
# Month Options: FULL_MONTH_NAME   ABBR_MONTH_NAME   NUMBERIC_MONTH_LEADING_ZERO   NUMERIC_MONTH_NO_LEADING_ZERO
# Day Options: NUMERIC_DAY_LEADING_ZERO   NUMERIC_DAY_NO_LEADING_ZERO   DAY_OF_WEEK_ABBR   DAY_OF_WEEK_FULL ENGLISH_SUFFIX
# Year Options: 4_DIGIT_YEAR   2_DIGIT_YEAR
# Time Options: HOURS_NO_LEADING_ZERO   HOURS_LEADING_ZERO   24_HOURS_NO_LEADING_ZEROS   24_HOURS_LEADING_ZERO   MINUTES   SECONDS   AM_PM_LOWERCASE   AM_PM_UPPERCASE
$pcrt_time = "HOURS_NO_LEADING_ZERO:MINUTES AM_PM_UPPERCASE";
$pcrt_shortdate = "4_DIGIT_YEAR-NUMERIC_MONTH_LEADING_ZERO-NUMERIC_DAY_LEADING_ZERO";
$pcrt_mediumdate = "ABBR_MONTH_NAME NUMERIC_DAY_NO_LEADING_ZERO, 4_DIGIT_YEAR";
$pcrt_longdate = "FULL_MONTH_NAME NUMERIC_DAY_NO_LEADING_ZERO, 4_DIGIT_YEAR";

#demo mode
$demo = "no";

#######################################
#Do not modify anything below this line
#######################################

require("dinit.php");
