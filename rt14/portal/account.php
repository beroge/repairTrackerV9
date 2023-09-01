<?php

/***************************************************************************
 *   copyright            : (C) 2017 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/

if (array_key_exists('func',$_REQUEST)) {
$func = $_REQUEST['func'];
} else {
$func = "";
}


function register() {

require("includes.php");
require("deps.php");

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

    <!-- Bootstrap core CSS -->
    <link href="bs/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="bs/ie10-viewport-bug-workaround.css" rel="stylesheet">


<link rel="stylesheet" href="fa/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="ani.css">
<title><?php echo pcrtlang("Register"); ?></title>

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
<form name="loginbox" action="account.php?func=register2" method="post">
<i class="fa fa-envelope fa-lg"></i>&nbsp;&nbsp;</td><td> <input type="text" name="username" class="form-control" placeholder="<?php echo pcrtlang("Enter Email Address"); ?>"></td></tr>
<tr><td colspan=2 style="text-align:center;">
<br>
<input type="submit" value="<?php echo pcrtlang("Register - Reset Password"); ?>" class="btn btn-default">
</form>

</td></tr></table>


</center>

</body>

</html>

<?php

}









function register2() {

require("includes.php");
require("deps.php");

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
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

    <!-- Bootstrap core CSS -->
    <link href="bs/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="bs/ie10-viewport-bug-workaround.css" rel="stylesheet">


<link rel="stylesheet" href="fa/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="ani.css">
<title><?php echo pcrtlang("Register"); ?></title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">


</head>
<body>
<center><br><br><img src="<?php echo "$logo"; ?>" class="animated bounceIn">
<br><br><br><table><tr><td><?php echo pcrtlang("Check your Email"); ?><br><br><a href=.\><?php echo pcrtlang("Login"); ?></a>
</td></tr></table>

<?php 

$portalemail = pv($_REQUEST["username"]);

$rs_chk_group2 = "SELECT * FROM pc_group WHERE grpemail = '$portalemail' ORDER BY pcgroupid ASC LIMIT 1";
$checkforgroup2 = @mysqli_query($rs_connect, $rs_chk_group2);
if (mysqli_num_rows($checkforgroup2) == "0") {
$rs_findowner = "SELECT * FROM pc_owner WHERE pcemail = '$portalemail' ORDER BY pcid DESC LIMIT 1";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);

if (mysqli_num_rows($rs_result2) != "0") {

$rs_result_q2 = mysqli_fetch_object($rs_result2);
$pcid = "$rs_result_q2->pcid";
$pcname = "$rs_result_q2->pcname";
$pccompany = "$rs_result_q2->pccompany";
$pcphone = "$rs_result_q2->pcphone";
$pccellphone = "$rs_result_q2->pccellphone";
$pcworkphone = "$rs_result_q2->pcworkphone";
$pcemail = "$rs_result_q2->pcemail";
$pcaddress = "$rs_result_q2->pcaddress";
$pcaddress2 = "$rs_result_q2->pcaddress2";
$pccity = "$rs_result_q2->pccity";
$pcstate = "$rs_result_q2->pcstate";
$pczip = "$rs_result_q2->pczip";

if($pcrt_allowgroupcreation == "yes") {
$rs_insert_group = "INSERT INTO pc_group (pcgroupname,grpcompany,grpaddress1,grpaddress2,grpcity,grpstate,grpzip,grpemail,grpphone,grpcellphone,grpworkphone) VALUES ('$pcname','$pccompany','$pcaddress','$pcaddress2','$pccity','$pcstate','$pczip','$pcemail','$pcphone','$pccellphone','$pcworkphone')";
@mysqli_query($rs_connect, $rs_insert_group);
$newpcgroupid = mysqli_insert_id($rs_connect);
$addassets_sql = "UPDATE pc_owner SET pcgroupid = '$newpcgroupid' WHERE pcemail = '$portalemail'";
@mysqli_query($rs_connect, $addassets_sql);
}
}
}

$rs_chk_group = "SELECT * FROM pc_group WHERE grpemail = '$portalemail' ORDER BY pcgroupid ASC LIMIT 1";
$checkforgroup = @mysqli_query($rs_connect, $rs_chk_group);
if (mysqli_num_rows($checkforgroup) != "0") {
$rs_result_q = mysqli_fetch_object($checkforgroup);
$portalpassword = "$rs_result_q->portalpassword";
if($portalpassword == "") {
$randompass =  random_password(10);
$randomhash = password_hash("$randompass", PASSWORD_DEFAULT);
$setpassword = "UPDATE pc_group SET portalpassword = '$randomhash' WHERE grpemail = '$portalemail' AND portalpassword = ''";
@mysqli_query($rs_connect, $setpassword);
require_once("sendenotify.php");
$from = $storeemail;
$to = "$portalemail";
$subject = "$businessname -".pcrtlang("Portal Login");
$plaintext = pcrtlang("Your login password is").": $randompass\n\n$domain";
$htmltext = pcrtlang("Your login password is").": $randompass<br><br><a href=$domain>$domain</a>";
sendenotify("$from","$to","$subject","$plaintext","$htmltext");

} else {
$randompass =  random_password(10);
$randomhash = password_hash("$randompass", PASSWORD_DEFAULT);
$setpassword = "UPDATE pc_group SET portalpasswordauth = '$randomhash' WHERE grpemail = '$portalemail'";
@mysqli_query($rs_connect, $setpassword);
require_once("sendenotify.php");
$from = $storeemail;
$to = "$portalemail";
$subject = "$businessname -".pcrtlang("Portal Login - Reset Password");
$plaintext = pcrtlang("Please Reset Your Password").": $domain/account.php?func=passwordreset&portalemail=$portalemail&hash=$randompass\n\n".pcrtlang("If you did not request this password reset, ignore this email.");
$htmltext = pcrtlang("Please Reset Your Password").": <a href=$domain/account.php?func=passwordreset&portalemail=$portalemail&hash=$randompass>$domain/account.php?func=passwordreset&portalemail=$portalemail&hash=$randompass</a><br><br>".pcrtlang("If you did not request this password reset, ignore this email.");
sendenotify("$from","$to","$subject","$plaintext","$htmltext");

}

}






 ?>


</center>

</body>

</html>

<?php

}






function passwordreset() {

require("includes.php");
require("deps.php");

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
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

    <!-- Bootstrap core CSS -->
    <link href="bs/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="bs/ie10-viewport-bug-workaround.css" rel="stylesheet">


<link rel="stylesheet" href="fa/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="ani.css">
<title><?php echo pcrtlang("Register"); ?></title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">


</head>
<body>
<center><br><br><img src="<?php echo "$logo"; ?>" class="animated bounceIn">
<br><br><br><table><tr><td><?php echo pcrtlang("Check your Email"); ?><br><br><a href=.\><?php echo pcrtlang("Login"); ?></a>
</td></tr></table>

<?php

$hash = pv($_REQUEST["hash"]);
$portalemail = pv($_REQUEST["portalemail"]);

$rs_chk_group = "SELECT * FROM pc_group WHERE grpemail = '$portalemail' ORDER BY pcgroupid ASC LIMIT 1";
$checkforgroup = @mysqli_query($rs_connect, $rs_chk_group);
if (mysqli_num_rows($checkforgroup) != "0") {
$rs_result_q = mysqli_fetch_object($checkforgroup);
$portalpasswordauth = "$rs_result_q->portalpasswordauth";
if($portalpasswordauth != "") {
if(password_verify("$hash", "$portalpasswordauth")) {
$randompass =  random_password(10);
$randomhash = password_hash("$randompass", PASSWORD_DEFAULT);
$setpassword = "UPDATE pc_group SET portalpassword = '$randomhash' WHERE grpemail = '$portalemail'";
@mysqli_query($rs_connect, $setpassword);
require_once("sendenotify.php");
$from = $storeemail;
$to = "$portalemail";
$subject = "$businessname -".pcrtlang("Portal Login");
$plaintext = pcrtlang("Your login password is").": $randompass\n\n$domain";
$htmltext = pcrtlang("Your login password is").": $randompass<br><br><a href=$domain>$domain</a>";
sendenotify("$from","$to","$subject","$plaintext","$htmltext");
}
}
}

?>

</center>

</body>
</html>

<?php

}


function updatepassword() {

require("includes.php");
require("deps.php");

$passwor = pv($_REQUEST["passwor"]);

if(strlen("$passwor") < 6) {
die("Password too short.");
}

$hashpass = password_hash("$passwor", PASSWORD_DEFAULT);
$setpassword = "UPDATE pc_group SET portalpassword = '$hashpass' WHERE grpemail = '$portallogin'";
@mysqli_query($rs_connect, $setpassword);

header("Location: customer.php?func=viewcustomer&passsaved=1");

}


function switchaccount() {

require("includes.php");
require("deps.php");

$pcgroupidset = pv($_REQUEST["pcgroupidset"]);
$grpemail = pv($_REQUEST["grpemail"]);

$checkit = "SELECT * FROM pc_group WHERE grpemail = '$grpemail' AND pcgroupid = '$pcgroupidset'";
$checkforgroup2 = @mysqli_query($rs_connect, $checkit);
if (mysqli_num_rows($checkforgroup2) == "0") {
die("error");
} else {
$_SESSION['groupid'] = "$pcgroupidset";
header("Location: ./");
}


}



switch($func) {

    default:
    register();
    break;

    case "register2":
    register2();
    break;

    case "passwordreset":
    passwordreset();
    break;

    case "updatepassword":
    updatepassword();
    break;

    case "switchaccount":
    switchaccount();
    break;


}

