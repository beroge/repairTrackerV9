<?php

/***************************************************************************
 *   copyright            : (C) 2010 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/


include_once("deps.php");

function pv($value) {
include("deps.php");
$value2 = trim($value);
 if (get_magic_quotes_gpc()) {
   return addslashes($value2);
 } else {
   return mysqli_real_escape_string($rs_connect, $value2);
 }
}


function pcrtlang($string) {

require("deps.php");

$safestring = pv($string);
$findbasestring = "SELECT * FROM languages WHERE basestring LIKE BINARY '$safestring'";
$findbasestringq = @mysqli_query($rs_connect, $findbasestring);
if(mysqli_num_rows($findbasestringq) == 0) {
$addstring = "INSERT INTO languages (language,languagestring,basestring) VALUES ('en-us','$safestring','$safestring')";
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



if (array_key_exists("RURI", $_REQUEST)) {
$ruri = $_REQUEST['RURI'];
} else {
$ruri = "./";
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

if(isset($passwords[$user])) if(password_verify("$pass", $passwords[$user])) $validated = true;
if(isset($passwords[$user])) if($passwords[$user]==md5($pass)) $validated = true;

if($validated) {


$_SESSION['username'] = "$user";
$_SESSION['username_'.$user] = "$user";


$vip = $_SERVER['REMOTE_ADDR'];



if(filter_var($vip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) { 
$vip2 = explode('.',$vip);
if (!in_array("$vip2[0].$vip2[1].$vip2[2]", $ips)) {
$ins_newip = "$vip2[0].$vip2[1].$vip2[2]";

$rs_insert_ip = "INSERT INTO allowedip  (ipaddress,dateadded,lastaccess) VALUES ('$ins_newip',NOW(),NOW())";
@mysqli_query($rs_connect, $rs_insert_ip);
}
}



if("$method" == "POST") {

header("Location: ./");

} else {
header("Location: $ruri");
}


} else {
echo pcrtlang("Invalid username/password combination.");
}
//End login code
}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../repair/style.css">
<link rel="stylesheet" href="../repair/fa/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="../store/ani.css">

<title>Login</title>
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
<font class=text12b><?php echo pcrtlang("Username"); ?>:</font></td><td><input type="text" name="username" class="textbox"></td></tr>
<tr><td><font class=text12b><?php echo pcrtlang("Password"); ?>:</font></td><td><input type="password" name="password" class="textbox"></td></tr>
<tr><td colspan=2 style="text-align:center;"><input type="hidden" name="RURI" value="<?php echo "$ruri"; ?>">
<input type="hidden" name="METHOD" value="<?php echo "$method"; ?>"><br>
<input type="submit" value="<?php echo pcrtlang("Login"); ?>" class="button">

</form></td></tr></table>


<br><br>
<?php
echo "<font class=text12>".$_SERVER['REMOTE_ADDR']."</font>";
?>
</center>
</body>

</html>
