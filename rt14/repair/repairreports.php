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


function dailystatus() {

require("deps.php");
require_once("validate.php");
require_once("common.php");

$theyear = date('Y-m-d');

printableheader(pcrtlang("Daily Repair Status Report for")." $thenow");


echo "<p style=\"text-align:center\"><span class=sizeme20>".pcrtlang("Daily Repair Status Report for")." $thenow</span></p><br>";
echo "<table class=standard>";

if (array_key_exists('plus30',$_REQUEST)) {
$rs_findpcs3 = "SELECT * FROM pc_wo WHERE storeid = '$defaultuserstore' AND pcstatus != '0' AND pcstatus != '5'  AND pcstatus != '7' 
AND DATE_SUB(NOW(), INTERVAL 1 MONTH) > dropdate ORDER BY pcstatus ASC, dropdate DESC";
} else {
$rs_findpcs3 = "SELECT * FROM pc_wo WHERE storeid = '$defaultuserstore' AND pcstatus != '0' AND pcstatus != '5'  AND pcstatus != '7' 
AND DATE_SUB(NOW(), INTERVAL 1 MONTH) < dropdate ORDER BY pcstatus ASC, dropdate DESC";
}



$rs_result = mysqli_query($rs_connect, $rs_findpcs3);

while($rs_result_q = mysqli_fetch_object($rs_result)) {

$pcid = "$rs_result_q->pcid";
$woid = "$rs_result_q->woid";
$dropdate = "$rs_result_q->dropdate";
$workarea = "$rs_result_q->workarea";
$pcpriorityindb = "$rs_result_q->pcpriority";
$thepass = "$rs_result_q->thepass";
$probdesc = "$rs_result_q->probdesc";
$called = "$rs_result_q->called";
$commonproblems = "$rs_result_q->commonproblems";
$assigneduser = "$rs_result_q->assigneduser";
$skeddate = "$rs_result_q->skeddate";
$sked = "$rs_result_q->sked";
$pcstatus = "$rs_result_q->pcstatus";

$dropdatestring = strtotime($dropdate);
$dropdatestringdiff = time() - $dropdatestring;

$rs_findowner = "SELECT pcname,pcmake,pccompany,mainassettypeid,prefcontact,pcphone,pcemail,pccellphone,pcworkphone,scid FROM pc_owner WHERE pcid = '$pcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);

$rs_result_q2 = mysqli_fetch_object($rs_result2);
$pcname = "$rs_result_q2->pcname";
$pcmake = "$rs_result_q2->pcmake";
$pccompany = "$rs_result_q2->pccompany";
$mainassettypeidindb = "$rs_result_q2->mainassettypeid";
$prefcontact = "$rs_result_q2->prefcontact";
$pcphone = "$rs_result_q2->pcphone";
$pcemail = "$rs_result_q2->pcemail";
$pccellphone = "$rs_result_q2->pccellphone";
$pcworkphone = "$rs_result_q2->pcworkphone";
$scid = "$rs_result_q2->scid";

$boxstyles = getboxstyle("$pcstatus");

echo "<tr><td><i class=\"fa fa-bookmark fa-lg\" style=\"color:#$boxstyles[selectorcolor]\"></i></td><td>$pcname</td>";
echo "<td>$pccompany</td>";
echo "<td>$pcmake</td>";
echo "<td><i class=\"fa fa-history\"></i> ".elaps("$dropdate")."</td>";
echo "<td><i class=\"fa fa-tag\"></i> $pcid</td>";
echo "<td><i class=\"fa fa-clipboard\"></i> $woid</td>";

echo "</tr>";

}

echo "</table>";

if (!array_key_exists('plus30',$_REQUEST)) {
echo "<br><br><p style=\"text-align:center\"><span class=sizeme20>".pcrtlang("Checkins Today")."</span></p><br>";
echo "<table class=standard>";

$rs_findpcs3 = "SELECT * FROM pc_wo WHERE storeid = '$defaultuserstore' AND dropdate LIKE '$theyear%' ORDER BY pcstatus ASC, dropdate DESC";
$rs_result = mysqli_query($rs_connect, $rs_findpcs3);

while($rs_result_q = mysqli_fetch_object($rs_result)) {

$pcid = "$rs_result_q->pcid";
$woid = "$rs_result_q->woid";
$dropdate = "$rs_result_q->dropdate";
$workarea = "$rs_result_q->workarea";
$pcpriorityindb = "$rs_result_q->pcpriority";
$thepass = "$rs_result_q->thepass";
$probdesc = "$rs_result_q->probdesc";
$called = "$rs_result_q->called";
$commonproblems = "$rs_result_q->commonproblems";
$assigneduser = "$rs_result_q->assigneduser";
$skeddate = "$rs_result_q->skeddate";
$sked = "$rs_result_q->sked";
$pcstatus = "$rs_result_q->pcstatus";

$dropdatestring = strtotime($dropdate);
$dropdatestringdiff = time() - $dropdatestring;

$rs_findowner = "SELECT pcname,pcmake,pccompany,mainassettypeid,prefcontact,pcphone,pcemail,pccellphone,pcworkphone,scid FROM pc_owner WHERE pcid = '$pcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);

$rs_result_q2 = mysqli_fetch_object($rs_result2);
$pcname = "$rs_result_q2->pcname";
$pcmake = "$rs_result_q2->pcmake";
$pccompany = "$rs_result_q2->pccompany";
$mainassettypeidindb = "$rs_result_q2->mainassettypeid";
$prefcontact = "$rs_result_q2->prefcontact";
$pcphone = "$rs_result_q2->pcphone";
$pcemail = "$rs_result_q2->pcemail";
$pccellphone = "$rs_result_q2->pccellphone";
$pcworkphone = "$rs_result_q2->pcworkphone";
$scid = "$rs_result_q2->scid";

$boxstyles = getboxstyle("$pcstatus");

echo "<tr><td><i class=\"fa fa-bookmark fa-lg\" style=\"color:#$boxstyles[selectorcolor]\"></i></td><td>$pcname</td>";
echo "<td>$pccompany</td>";
echo "<td>$pcmake</td>";
echo "<td><i class=\"fa fa-history\"></i> ".elaps("$dropdate")."</td>";
echo "<td><i class=\"fa fa-tag\"></i> $pcid</td>";
echo "<td><i class=\"fa fa-clipboard\"></i> $woid</td>";

echo "</tr>";

}

echo "</table>";


echo "<br><br><p style=\"text-align:center\"><span class=sizeme20>".pcrtlang("Checkouts Today")."</span></p><br>";
echo "<table class=standard>";

$rs_findpcs3 = "SELECT * FROM pc_wo WHERE storeid = '$defaultuserstore' AND pcstatus = '5'  AND pickupdate LIKE '$theyear%' ORDER BY dropdate DESC";
$rs_result = mysqli_query($rs_connect, $rs_findpcs3);

while($rs_result_q = mysqli_fetch_object($rs_result)) {

$pcid = "$rs_result_q->pcid";
$woid = "$rs_result_q->woid";
$dropdate = "$rs_result_q->dropdate";
$workarea = "$rs_result_q->workarea";
$pcpriorityindb = "$rs_result_q->pcpriority";
$thepass = "$rs_result_q->thepass";
$probdesc = "$rs_result_q->probdesc";
$called = "$rs_result_q->called";
$commonproblems = "$rs_result_q->commonproblems";
$assigneduser = "$rs_result_q->assigneduser";
$skeddate = "$rs_result_q->skeddate";
$sked = "$rs_result_q->sked";
$pcstatus = "$rs_result_q->pcstatus";

$dropdatestring = strtotime($dropdate);
$dropdatestringdiff = time() - $dropdatestring;

$rs_findowner = "SELECT pcname,pcmake,pccompany,mainassettypeid,prefcontact,pcphone,pcemail,pccellphone,pcworkphone,scid FROM pc_owner WHERE pcid = '$pcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);

$rs_result_q2 = mysqli_fetch_object($rs_result2);
$pcname = "$rs_result_q2->pcname";
$pcmake = "$rs_result_q2->pcmake";
$pccompany = "$rs_result_q2->pccompany";
$mainassettypeidindb = "$rs_result_q2->mainassettypeid";
$prefcontact = "$rs_result_q2->prefcontact";
$pcphone = "$rs_result_q2->pcphone";
$pcemail = "$rs_result_q2->pcemail";
$pccellphone = "$rs_result_q2->pccellphone";
$pcworkphone = "$rs_result_q2->pcworkphone";
$scid = "$rs_result_q2->scid";

$boxstyles = getboxstyle("$pcstatus");

echo "<tr><td><i class=\"fa fa-bookmark fa-lg\" style=\"color:#$boxstyles[selectorcolor]\"></i></td><td>$pcname</td>";
echo "<td>$pccompany</td>";
echo "<td>$pcmake</td>";
echo "<td><i class=\"fa fa-history\"></i> ".elaps("$dropdate")."</td>";
echo "<td><i class=\"fa fa-tag\"></i> $pcid</td>";
echo "<td><i class=\"fa fa-clipboard\"></i> $woid</td>";

echo "</tr>";

}

echo "</table>";

}

printablefooter();


}



######

switch($func) {
                                                                                                    
    default:
    dailystatus();
    break;
                                
    case "dailystatus":
    dailystatus();
    break;


}

?>

