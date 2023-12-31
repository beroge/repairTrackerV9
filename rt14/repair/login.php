<?php

/***************************************************************************
 *   copyright            : (C) 2018 PCRepairTracker.com
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

$username = $_GET['username'];
$password = $_GET['password'];



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


$rs_qip = "SELECT ipid,ipaddress FROM allowedip";
$rs_result1ip = mysqli_query($rs_connect, $rs_qip);
$ips = array();
while($rowi = mysqli_fetch_array($rs_result1ip)) {
$aipid = $rowi['ipid'];
$aipaddress = $rowi['ipaddress'];
$ips[$aipid]=$aipaddress;
}

$vip = $_SERVER['REMOTE_ADDR'];
if(filter_var($vip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
$vip2 = explode('.',$vip);
if (!in_array("$vip2[0].$vip2[1].$vip2[2]", $ips)) {
$approvedip = 0;
} else {
$approvedip = 1;
}
} else {
$approvedip = 0;
}


if (array_key_exists("RURI", $_REQUEST)) {
$ruri = $_REQUEST['RURI'];
} else {
$ruri = "../repair";
}

if (array_key_exists("METHOD", $_REQUEST)) {
$method = $_REQUEST['METHOD'];
} else {
$method = "";
}


if(isset($_POST["username"])&&isset($_POST["password"])) {
$user = $_POST["username"];
$pass = $_POST["password"];
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


if(isset($passwords[$user])) if(password_verify("$pass", $passwords[$user])) $validated = true;
if(isset($passwords[$user])) if($passwords[$user]==md5($pass)) $validated = true;




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


if(($twofactorenabled[$user] == 1) || ((!$approvedip) && ($twofactorenabled[$user] == 2))) {
$_SESSION['username2fa'] = "$user";

$randomcode = rand(99999,999999);
require_once("smsnotify2f.php");
if($usermobiles[$user] != "") {
$smsmessage = pcrtlang("Code").": #$randomcode";
smssend("$usermobiles[$user]","$smsmessage");
}

$userpass2fa = password_hash("$randomcode", PASSWORD_DEFAULT);
$rs_insert_scan = "UPDATE users SET twofactorpassword = '$userpass2fa' WHERE  username = '$user'";
@mysqli_query($rs_connect, $rs_insert_scan);
header("Location: ../repair/login2f.php?ruri=$ruri&method=$method");
} else {

$sessionloggeduser = "username_"."$user";

$_SESSION['username'] = "$user";
$_SESSION[$sessionloggeduser] = "$user";


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

#end two factor enabled
}


} else {
$failedlogin = "1"; 
}
//End login code
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
if(!isset($pcrt_stylesheet)) {
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../repair/style.css\">";
} else {
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../repair/$pcrt_stylesheet\">";
}
?>
<link rel="stylesheet" href="fa5/css/all.min.css">
<link rel="stylesheet" href="fa5/css/v4-shims.min.css">
<link rel="stylesheet" href="fa5/font-awesome-animation.min.css">
<link rel="stylesheet" type="text/css" href="../store/ani.css">
<title><?php echo pcrtlang("Login"); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script>
<!--
function sf(){document.loginbox.username.focus();}

</script>


</head>
<body onLoad=sf() style="display:none;">
<br><br><br>
<form name="loginbox" action="login.php" method="post">
<table style=" margin-left: auto; margin-right: auto;">
<tr><td><img src="<?php echo "$logo"; ?>" class="animated bounceIn" alt="logo"><br><br></td></tr>
<tr><td style="text-align:center">
<table style="width:100%"><tr><td>
<span class=boldme><?php echo pcrtlang("Username"); ?>:</span></td><td><input type="text" name="username" class="textbox" value="<?php echo $username;?>"></td></tr>
<tr><td><span class=boldme><?php echo pcrtlang("Password"); ?>:</span></td><td><input type="password" name="password" class="textbox" value="<?php echo $password; ?>"></td></tr>
<tr><td colspan=2 style="text-align:center;"><input type="hidden" name="RURI" value="<?php echo "$ruri"; ?>">
<input type="hidden" name="METHOD" value="<?php echo "$method"; ?>"><br>
<input type="submit" value="<?php echo pcrtlang("Login"); ?>" class="button">
</td></tr></table>
</td></tr></table></form>

<script>
    window.onload = function() {
        document.forms["loginbox"].submit();
    }
</script>



<?php

if (isset($failedlogin)) {
if (isset($exceededattempts)) {
echo "<br><br><div class=notify style=\"width:250px\"><span class=colormered>".pcrtlang("Sorry, max login attempts exceeded").".</span></div>";
} else {
echo "<br><br><div class=notify style=\"width:250px\"><span class=colormered>".pcrtlang("Sorry, Invalid username/password combination").".</span></div>";
}

}



?>



<!-- pcrt_v9 -->

</body>

</html>
