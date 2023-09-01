<?php
/***************************************************************************
 *   copyright            : (C) 2018 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/

include("deps.php");
require_once("common.php");

$message = pcrtlang("You are logged out")."<br><br><a href=\"./\" class=\"ui-btn ui-corner-all ui-shadow ui-btn-inline\" data-ajax=\"false\">".pcrtlang("Login")."</a>";

if(isset($ipofpc)) {
userlog(31,'','',pcrtlang("Logged Out"));
}

session_destroy();


?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo pcrtlang("Logout"); ?></title>

<?php require("headincludes.php"); ?>

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
