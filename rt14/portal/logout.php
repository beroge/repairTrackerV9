<?php
/***************************************************************************
 *   copyright            : (C) 2012 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/

include("deps.php");
require_once("common.php");

$message = pcrtlang("You are logged out")."<br><br><a href=\"./\">".pcrtlang("Login")."</a>";

#if(isset($ipofpc)) {
#userlog(31,'','',pcrtlang("Logged Out"));
#}

session_destroy();


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



<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo pcrtlang("Logout"); ?></title>

</head>
<body>


<br><br><center>

<table style="width:300px"><tr><td style="text-align:center">

<?php
echo "<br><br><div style=\"width:250px\"><p class=\"bg-danger text-danger\">$message</p></div>";
?>

</td></tr></table>

</center>


</body>

</html>
