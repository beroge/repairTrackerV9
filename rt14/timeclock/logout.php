<?php
/***************************************************************************
 *   copyright            : (C) 2020 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/

include("deps.php");
require_once("common.php");

$message = "<font class=text20b>".pcrtlang("You are logged out")."</font><br><br><a href=./ class=boldlink>".pcrtlang("Login")."</a>";

if(isset($ipofpc)) {
userlog(31,'','',pcrtlang("Logged Out"));
}

session_destroy();



?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../repair/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo pcrtlang("Logout"); ?></title>

</head>
<body>


<br><br><center>

<table style="width:300px"><tr><td style="text-align:center">

<div class=notify>
<br>
<?php echo "$message"; ?>
<br><br>
</div>

</td></tr></table>

</center>


</body>

</html>
