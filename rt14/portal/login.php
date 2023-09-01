<?php

/***************************************************************************
 *   copyright            : (C) 2017 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/

include_once("deps.php");

function pv($value) {
require("deps.php");
$value2 = trim($value);
   return mysqli_real_escape_string($rs_connect, $value2);
}


function pcrtlang($string) {

require("deps.php");

$safestring = pv($string);
$findbasestring = "SELECT * FROM languages WHERE basestring LIKE BINARY '$safestring'";
$findbasestringq = @mysqli_query($rs_connect, $findbasestring);
if(mysqli_num_rows($findbasestringq) == 0) {
$addstring = "INSERT INTO languages (language,languagestring,basestring) VALUES ('$mypcrtlanguage','$safestring','$safestring')";
@mysqli_query($rs_connect, $addstring);
}

$findstring = "SELECT languagestring FROM languages WHERE basestring LIKE BINARY '$safestring' AND language = '$mypcrtlanguage'";

$findstringq = @mysqli_query($rs_connect, $findstring);
if(mysqli_num_rows($findstringq) == 0) {
return "$string";
} else {
$rs_result_qs = mysqli_fetch_object($findstringq);
return "$rs_result_qs->languagestring";
}
}


if(isset($_POST["username"])&&isset($_POST["password"])) {

if (!filter_var($_POST["username"], FILTER_VALIDATE_EMAIL)) {
die("Please Enter Proper Email Address.");
}


$user = pv($_POST["username"]);
$pass = pv($_POST["password"]);
$validated = false;

#check code here

require("deps.php");




$ipaddress = $_SERVER['REMOTE_ADDR'];

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

#Set time here for how many minutes before login attempts are expired.
$loginattempts_expiretime_minutes = 60; 

$lesshourstamp = (strtotime($currentdatetime) - (60 * $loginattempts_expiretime_minutes));

$lesshour = date('Y-m-d H:i:s', $lesshourstamp);

$rs_clear_ip = "DELETE FROM portalloginattempts WHERE attempttime < '$lesshour'";
$rs_result = mysqli_query($rs_connect, $rs_clear_ip);

$rs_find_ip = "SELECT * FROM portalloginattempts WHERE ipaddress = '$ipaddress' AND portalusername = '$user'";
$rsfind_result = mysqli_query($rs_connect, $rs_find_ip);

#wip

$rs_chk_password = "SELECT portalpassword,pcgroupid FROM pc_group WHERE grpemail = '$user' ORDER BY pcgroupid LIMIT 1";
$checkforgroup = @mysqli_query($rs_connect, $rs_chk_password);
if (mysqli_num_rows($checkforgroup) != "0") {
$rs_result_q = mysqli_fetch_object($checkforgroup);
$portalpassword = "$rs_result_q->portalpassword";
$groupid = "$rs_result_q->pcgroupid";
if(password_verify("$pass", "$portalpassword")) $validated = true;
if($portalpassword==md5($pass)) $validated = true;
}


if(!$validated) {
require("deps.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

$rs_insert_ip = "INSERT INTO portalloginattempts (portalusername,ipaddress,attempttime) VALUES ('$user','$ipaddress','$currentdatetime');";
$rs_result = mysqli_query($rs_connect, $rs_insert_ip);
}

$userloginattempts = mysqli_num_rows($rsfind_result);

#Set max login attempts here
$maxloginattempts = 4;

if($userloginattempts > $maxloginattempts) {
$validated = false;
$exceededattempts = 1;
}


if($validated) {

$_SESSION['portallogin'] = "$user";
$_SESSION['groupid'] = "$groupid";

header("Location: loglogin.php");

} else {
$failedlogin = "1"; 
}
//End login code
}
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Customer Portal</title>

    <!-- Bootstrap core CSS -->
    <link href="bs/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="bs/ie10-viewport-bug-workaround.css" rel="stylesheet">


<link rel="stylesheet" href="fa/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="ani.css">
<title><?php echo pcrtlang("Portal Login"); ?></title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script>
<!--
function sf(){document.loginbox.username.focus();}
// -->
</script>


</head>
<body onLoad=sf()>
<center><br><br><img src="<?php echo "$logo"; ?>" class="animated bounceIn">
<br><br><br><table><tr><td>
<form name="loginbox" action="login.php" method="post">
<?php echo pcrtlang("Email"); ?>:</td><td><input type="email" name="username" class="form-control"></td></tr>
<tr><td><?php echo pcrtlang("Password"); ?>:</td><td><input type="password" name="password" class="form-control"></td></tr>
<tr><td></td><td>
<br>
<input type="submit" value="<?php echo pcrtlang("Login"); ?>" class="btn btn-default">
</form>
&nbsp;&nbsp;&nbsp;&nbsp;<a href="account.php"><?php echo pcrtlang("Register - Forgot Password"); ?></a>

</td></tr></table>

<?php

if (isset($failedlogin)) {
if (isset($exceededattempts)) {
echo "<br><br><div style=\"width:250px\"><p class=\"bg-danger text-danger\">".pcrtlang("Sorry, max login attempts exceeded").".</p></div>";
} else {
echo "<br><br><div style=\"width:250px\"><p class=\"bg-danger text-danger\">".pcrtlang("Sorry, Invalid username/password combination").".</p></div>";
}

}



?>


</center>

<!-- pcrt_v5 -->

</body>

</html>
