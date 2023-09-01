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
$value2 = trim($value);
require("deps.php");
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
$ruri = "../repairmobile";
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


if(isset($passwords[$user])) if($passwords[$user]==$pass) $validated = true;

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
header("Location: ../repairmobile/login2f.php?ruri=$ruri&method=$method");

} else {

$_SESSION['username'] = "$user";
$_SESSION['username_'.$user] = "$user";

if("$method" == "POST") {

if (preg_match("/store/i", $ruri)) {
$gotouri = urlencode("../store");
header("Location: loglogin.php?gotouri=$gotouri");
} else {
$gotouri = urlencode("../repairmobile");
header("Location: loglogin.php?gotouri=$gotouri");
}


} else {
$gotouri = urlencode($ruri);
header("Location: loglogin.php?gotouri=$gotouri");
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
<html>
<head>

<?php require("headincludes.php"); ?>


<link rel="stylesheet" type="text/css" href="../store/ani.css">
<title><?php echo pcrtlang("Login"); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">


</head>
<body>
<div data-role="page">
<center><br><br><img src="<?php echo "../store/$logo"; ?>" class="animated bounceIn">
<form action="login.php" method="post" data-ajax="false">
<br><br><br><table class=plain><tr><td>
<i class="fa fa-user fa-lg"></i></td><td><input autofocus type="text" name="username"></td></tr>
<tr><td><i class="fa fa-key fa-lg"></i></td><td><input type="password" name="password"></td></tr>
<tr><td colspan=2 style="text-align:center;"><input type="hidden" name="RURI" value="<?php echo "$ruri"; ?>">
<input type="hidden" name="METHOD" value="<?php echo "$method"; ?>"><br>
<button type="submit"><?php echo pcrtlang("Login"); ?></button>

</td></tr></table></form>

<?php

if (isset($failedlogin)) {
if (isset($exceededattempts)) {
echo "<br><br><div class=notify style=\"width:250px\"><font class=textred12>".pcrtlang("Sorry, max login attempts exceeded").".</font></div>";
} else {
echo "<br><br><div class=notify style=\"width:250px\"><font class=textred12>".pcrtlang("Sorry, Invalid username/password combination").".</font></div>";
}

}

?>


</center>
</div>
<!-- pcrt_v8 -->

</body>

</html>
