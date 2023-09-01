<?php
                                                                                                    
/***************************************************************************
 *   copyright            : (C) 2010 PCRepairTracker.com
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

                                                                                                    
function nothing() {
require_once("header.php");


require_once("footer.php");
                                                                                                    
}

function esearch() {
require_once("validate2.php");
require("deps.php");
require("common.php");


$searchterm = pv($_REQUEST['search']);




echo "<button id=button class=ibutton style=\"float:right;\"><i class=\"fa fa-times fa-lg\"></i></button>";

?>

<script>
$("#button").click(function() { 
    $("#autosearch2").slideUp(200);
});
</script>
<?php





$rs_fl = "SELECT * FROM employees WHERE employeename LIKE '%$searchterm%' OR clocknumber  LIKE '%$searchterm%'";
$rs_resultfl = mysqli_query($rs_connect, $rs_fl);

if(mysqli_num_rows($rs_resultfl) == 0) {
echo "<font class=textgray12i>".pcrtlang("No Search Results Found")."</font>";
}

while ($rs_result_fl1 = mysqli_fetch_object($rs_resultfl)) {
$ename = "$rs_result_fl1->employeename";
$eid = "$rs_result_fl1->employeeid";
$cn = "$rs_result_fl1->clocknumber";

echo "<a href=employee.php?func=viewemployee&eid=$eid&cn=$cn class=\"linkbuttonsmall linkbuttongray radiusall\"><i class=\"fa fa-user fa-lg\"></i> $ename</a><br>";

}




}



                                                                                                    
switch($func) {

    default:
    nothing();
    break;
                                
    case "esearch":
    esearch();
    break;



}

?>
