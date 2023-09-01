<?php

/***************************************************************************
 *   copyright            : (C) 2017 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/


include("deps.php");
$validated = false;

if(isset($_SESSION["portallogin"])) {
$loginemail = $_SESSION["portallogin"];
$rs_chk_group = "SELECT * FROM pc_group WHERE grpemail = '$loginemail'";
$checkforgroup = @mysqli_query($rs_connect, $rs_chk_group);
if (mysqli_num_rows($checkforgroup) != "0") {
$validated = true;
}
}


if($validated) {
//Ok - continue
} else {
//Go to login page

?>
<script>
top.location.href="login.php";
</script>
<?php

die("<br><br><a href=login.php style=\"background:#ff0000;padding:8px;border-radius:3px;color:#ffffff;text-decoration:none;font-family:helvetica;\"><i style=\"fa fa-exclamation-triangle fa-lg\"></i> please login</a>");


exit;
}
