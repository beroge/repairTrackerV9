<?php 

/***************************************************************************
 *   copyright            : (C) 2010 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/

require_once("validate2.php"); 
require_once("common.php");
$storeinfoarray = getdefaultstoreinfo();


?>
<br><br><br>
</td>


</table>

<table class=interface>
    <tr>
        <td style="width:30%;background:#<?php echo $storeinfoarray['interfacecolor1']; ?>;padding:5px"></td>
        <td style="width:70%;background:#eeeeee;padding:10px 50px 10px 10px">

<font class=text12eng>
<?php




echo pcrtlang("online users").": ";
if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');
$rs_find_cart_pur = "SELECT username FROM users WHERE lastseen > DATE_SUB('$currentdatetime', INTERVAL 1 HOUR) AND username != 'admin'";
$rs_result_pur = mysqli_query($rs_connect, $rs_find_cart_pur);
while($rs_result_pur_q = mysqli_fetch_object($rs_result_pur)) {
$usern = "$rs_result_pur_q->username";
echo " | $usern ";
}
?>

<span style="float:right">This system &copy;<?php echo date("Y"); ?> PC Repair Tracker v8
<?php

$totalpagetime = microtime(true) - $startpagetime;
echo "<br>$totalpagetime";

?>

</span></font>
</td></tr>
</table>



</body>

</html>
