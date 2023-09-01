<?php

/***************************************************************************
 *   copyright            : (C) 2020 PCRepairTracker.com
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


if (array_key_exists("ruri", $_REQUEST)) {
$ruri = $_REQUEST['ruri'];
} else {
$ruri = "../repair";
}

if (array_key_exists("method", $_REQUEST)) {
$method = $_REQUEST['method'];
} else {
$method = "";
}


if(!isset($_SESSION["username2fa"])) {
header("Location: login.php");
}



if(isset($_SESSION["username2fa"])&&isset($_POST["password2fa"])) {
$user = $_SESSION["username2fa"];
$pass2fa = $_POST["password2fa"];
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

$rs_clear_ip = "DELETE FROM loginattempts WHERE attempttime < '$lesshour'";
$rs_result = mysqli_query($rs_connect, $rs_clear_ip);

$rs_find_ip = "SELECT * FROM loginattempts WHERE ipaddress = '$ipaddress' AND username = '$user'";
$rsfind_result = mysqli_query($rs_connect, $rs_find_ip);


if(isset($passwords2fa[$user])) if(password_verify("$pass2fa", $passwords2fa[$user])) $validated = true;




if(!$validated) {
require("deps.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

$rs_insert_ip = "INSERT INTO loginattempts (username,ipaddress,attempttime) VALUES ('$user','$ipaddress','$currentdatetime');";
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

$sessionloggeduser = "username_"."$user";


$_SESSION['username'] = $_SESSION['username2fa'];
$_SESSION[$sessionloggeduser] = $_SESSION['username2fa'];
unset($_SESSION["username2fa"]);

if("$method" == "POST") {

if (preg_match("/store/i", $ruri)) {
$gotouri = urlencode("../store");
header("Location: loglogin.php?gotouri=$gotouri");
} else {
$gotouri = urlencode("../repair");
header("Location: loglogin.php?gotouri=$gotouri");
}


} else {
if($ruri != "") {
$gotouri = urlencode($ruri);
header("Location: loglogin.php?gotouri=$gotouri");
} else {
$gotouri = urlencode("../repair");
header("Location: loglogin.php?gotouri=$gotouri");
}
}


} else {
$failedlogin = "1"; 
}
//End login code
}
?>
<!DOCTYPE html>
<html>
<head>
<?php
if(!isset($pcrt_stylesheet)) {
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../repair/style.css\">";
} else {
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../repair/$pcrt_stylesheet\">";
}
?>
<link rel="stylesheet" href="../repair/fa5/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="ani.css">
<title><?php echo pcrtlang("2FA Login"); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script>
<!--
function sf(){document.loginbox2fa.password2fa.focus();}
// -->
</script>


</head>
<body onLoad=sf()>
<center><br><br><img src="<?php echo "$logo"; ?>" class="animated bounceIn">
<br><br><br><table><tr><td>
<form name="loginbox2fa" action="login2f.php" method="post" autocomplete="off">

<span class=boldme><?php echo pcrtlang("SMS Code"); ?>:</span></td><td><input id=password2fa type="text" name="password2fa" class="textbox" autocomplete="off"></td></tr>
<tr><td colspan=2 style="text-align:center;"><input type="hidden" name="ruri" value="<?php echo "$ruri"; ?>">
<input type="hidden" name="method" value="<?php echo "$method"; ?>"><br>
<input type="submit" value="<?php echo pcrtlang("Login"); ?>" class="button">

</form></td></tr></table>


<?php

if (isset($failedlogin)) {
if (isset($exceededattempts)) {
echo "<br><br><div class=notify style=\"width:250px\"><span class=colormered>".pcrtlang("Sorry, max login attempts exceeded").".</span></div>";
} else {
echo "<br><br><div class=notify style=\"width:250px\"><span class=colormered>".pcrtlang("Sorry, Invalid Code").".</span></div>";
}

}



?>


<br><br><a href=login.php class="linkbuttongray linkbuttonsmall radiusall"><?php echo pcrtlang("Start Over"); ?></a>

</center>

<!-- pcrt_v8 -->

</body>

</html>
