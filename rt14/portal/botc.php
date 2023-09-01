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


function nothing() {

echo "Nothing to see here";

}



##########

function view() {
require_once("validate.php");

include("deps.php");
include("common.php");

require("header.php");

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}


echo "<h3>".pcrtlang("Block of Time Services")."</h3>";


?>

<script type='text/javascript'>

   function pad(val)
        {
            var valString = val + "";
            if(valString.length < 2)
            {
                return "0" + valString;
            }
            else
            {
                return valString;
            }
        }


</script>

<?php
function time_elapsed($secs){

    $bit = array(
        'y' => $secs / 31556926 % 12,
        'w' => $secs / 604800 % 52,
        'd' => $secs / 86400 % 7,
        'h' => $secs / 3600 % 24,
        'm' => $secs / 60 % 60,
 #       's' => $secs % 60
        );

    foreach($bit as $k => $v)
        if($v > 0)$ret[] = $v . $k;

if(!isset($ret)) {
$ret[] = "0m";
}

    return join(' ', $ret);
    }

function array_sort_by_column(&$array, $column, $direction = SORT_ASC) {
    $reference_array = array();

    foreach($array as $key => $row) {
        $reference_array[$key] = $row[$column];
    }

    array_multisort($reference_array, $direction, $array);
}





$rs_bcs = "SELECT * FROM blockcontract WHERE pcgroupid = '$portalgroupid' AND contractclosed = '0'";
$rs_find_bcs = @mysqli_query($rs_connect, $rs_bcs);

while($rs_find_bcs_q = mysqli_fetch_object($rs_find_bcs)) {
$blockid = "$rs_find_bcs_q->blockid";
$blocktitle = "$rs_find_bcs_q->blocktitle";
$blocknote = "$rs_find_bcs_q->blocknote";
$blockstart = "$rs_find_bcs_q->blockstart";
$contractclosed = "$rs_find_bcs_q->contractclosed";

$blocktitle_ue = urlencode("$blocktitle");


echo "<div class=\"panel panel-primary\">";
echo "<div class=\"panel-heading\">";
echo "<h3 class=\"panel-title\">$blocktitle</h3></div>";
echo "<div class=\"panel-body\">";

echo "<div class=\"table-responsive\">";
echo "<table style=\"width:100%\">";
echo "<tr><td style=\"vertical-align:top;width:20%\"><span class=boldme>".pcrtlang("Start Date").":</span></td><td style=\"vertical-align:top;width:50%\">$blockstart</td>";

echo "<td rowspan=2>";

$rs_checkrinvoice2 = "SELECT * FROM rinvoices WHERE blockcontractid = '$blockid'";
$rs_result_rci2 = mysqli_query($rs_connect, $rs_checkrinvoice2);


echo "</td>";

echo "</tr>";
echo "<tr><td style=\"vertical-align:top\"><strong>".pcrtlang("Notes").":</strong></td><td style=\"vertical-align:top\">$blocknote</td></tr>";
echo "</table><br>";



#lines

$masterlist = array();
$timebalance = 0;

$rs_findblockhours = "SELECT * FROM blockcontracthours WHERE blockcontractid = '$blockid'";
$rs_result_bh = mysqli_query($rs_connect, $rs_findblockhours);
while($rs_result_qbh = mysqli_fetch_object($rs_result_bh)) {
$blockhours = "$rs_result_qbh->blockhours";
$blockcontracthoursid = "$rs_result_qbh->blockcontracthoursid";
$blockhoursdate = "$rs_result_qbh->blockhoursdate";
$invoiceid = "$rs_result_qbh->invoiceid";
$masterlist[] = array("linetype" => "blockhours", "blockhours" => "$blockhours", "thedate" => "$blockhoursdate 0000-00-00 00:00:00", "invoiceid" => "$invoiceid", "thedateonly" => "$blockhoursdate", "blockcontracthoursid" => "$blockcontracthoursid");
}


$rs_findtimers = "SELECT * FROM timers WHERE blockcontractid = '$blockid'";
$rs_result_t = mysqli_query($rs_connect, $rs_findtimers);
while($rs_result_qt = mysqli_fetch_object($rs_result_t)) {
$timername = "$rs_result_qt->timerdesc";
$timerstart = "$rs_result_qt->timerstart";
$timerstop = "$rs_result_qt->timerstop";
$timertotal = "$rs_result_qt->timertotal";
$timerid = "$rs_result_qt->timerid";
$billedout = "$rs_result_qt->billedout";
$timerbyuser = "$rs_result_qt->byuser";
$woid = "$rs_result_qt->woid";
$savedround = "$rs_result_qt->savedround";


$timerstart_2822 = date('r', strtotime("$timerstart"));

$timerstartdate2 = date('n-j-Y', strtotime($timerstart));
$timerstarttime2 = date('g:ia', strtotime($timerstart));
$timerstoptime2 = date('g:ia', strtotime($timerstop));

$startepoch = strtotime($timerstart);
$stopepoch = time();
$startseconds = $stopepoch - $startepoch;

$masterlist[] = array("savedround" => "$savedround", "timerid" => "$timerid", "linetype" => "timer", "timername" => "$timername", "thedate" => "$timerstart", "timerstop" => "$timerstop", "timeruser" => "$timerbyuser", "woid" => "$woid");
}


array_sort_by_column($masterlist, 'thedate');

echo "<table class=\"table\">";
echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><th style=\"text-align:right;\">".pcrtlang("Actual")."</th><th style=\"text-align:right;\">".pcrtlang("Applied")."</th><th style=\"text-align:right;\">".pcrtlang("Totals")."</th></tr>";


$runningtime = 0;

foreach($masterlist as $key => $subarray) {

#timercode start
if($subarray['linetype'] == "timer") {

$timername = $subarray['timername']; 
$timerstart = $subarray['thedate'];
$timerstop = $subarray['timerstop'];
$timerid = $subarray['timerid'];
$timerbyuser = $subarray['timeruser'];
$woid = $subarray['woid'];
$savedround = $subarray['savedround'];

$timerstart_2822 = date('r', strtotime("$timerstart"));

$timerstartdate2 = date('Y-n-j', strtotime($timerstart));
$timerstarttime2 = date('g:ia', strtotime($timerstart));
$timerstoptime2 = date('g:ia', strtotime($timerstop));


$startepoch = strtotime($timerstart);
$stopepoch = time();
$startseconds = $stopepoch - $startepoch;



if($timerstop == "0000-00-00 00:00:00") {
echo "<tr><td style=\"border-left:#F2AD0E 10px solid;\">$timername";

echo "</td><td>$timerbyuser </td>
<td><span class=text-success>$timerstartdate2 $timerstarttime2</span></td>
<td>";

?>
 <i class="fa fa-spinner fa-lg fa-spin text-success"></i>
<label id="<?php echo "$timerid"; ?>hours" class="text-success">0</label><span class=text-success>:</font><label id="<?php echo "$timerid"; ?>minutes" class="text-success">00</label><span class=text-success>:</span><label id="<?php echo "$timerid"; ?>seconds" class="text-success">00</label>
    <script type="text/javascript">
        var hoursLabel<?php echo "$timerid"; ?> = document.getElementById("<?php echo "$timerid"; ?>hours");
        var minutesLabel<?php echo "$timerid"; ?> = document.getElementById("<?php echo "$timerid"; ?>minutes");
        var secondsLabel<?php echo "$timerid"; ?> = document.getElementById("<?php echo "$timerid"; ?>seconds");
        var totalSeconds<?php echo "$timerid"; ?> = <?php echo "$startseconds"; ?>;
        setInterval(setTime<?php echo "$timerid"; ?>, 1000);

   function setTime<?php echo "$timerid"; ?>()
        {
            ++totalSeconds<?php echo "$timerid"; ?>;
            secondsLabel<?php echo "$timerid"; ?>.innerHTML = pad(totalSeconds<?php echo "$timerid"; ?>%60);
            minutesLabel<?php echo "$timerid"; ?>.innerHTML = pad(parseInt(totalSeconds<?php echo "$timerid"; ?>/60) %60);
            hoursLabel<?php echo "$timerid"; ?>.innerHTML = parseInt(totalSeconds<?php echo "$timerid"; ?>/3600);
        }

    </script>

<?php


echo "</td><td colspan=2>";
echo "</td><td></td><td></td><td></td><td></td><td></td></tr>";

} else {

$startstamp = strtotime("$timerstart");
$stopstamp = strtotime("$timerstop");

$elapsedtime = $stopstamp - $startstamp;
$timeusedact =  mf($elapsedtime / 3600);


if($savedround == 15) {
$elapsedtime2 = ($elapsedtime - ($elapsedtime % 900)) + 900; 
$runningtime = $runningtime - $elapsedtime2;
} elseif($savedround == 30) {
$elapsedtime2 = ($elapsedtime - ($elapsedtime % 1800)) + 1800;
$runningtime = $runningtime - $elapsedtime2;
} elseif($savedround == 60) {
$elapsedtime2 = ($elapsedtime - ($elapsedtime % 3600)) + 3600;
$runningtime = $runningtime - $elapsedtime2;
} else {
$elapsedtime2 = $elapsedtime;
$runningtime = $runningtime - $elapsedtime2;
}

$timeused =  mf($elapsedtime2 / 3600);

$timebalance = mf($runningtime / 3600);

$elapsedhuman = time_elapsed($elapsedtime);



echo "<tr><td style=\"vertical-align:top; border-left: #FF4938 10px solid;\">$timername";

echo "</td><td>$timerbyuser</td>
<td>$timerstartdate2 $timerstarttime2</td>
<td>$timerstoptime2</td><td colspan=4>";

echo "</td><td style=\"text-align:right;\"></td><td style=\"text-align:right;\">-$timeused</td><td style=\"text-align:right;\">$timebalance</td></tr>";

}





} else {
#timercode stop
#line item start


$blockhours = $subarray['blockhours'];
$thedateonly = $subarray['thedateonly'];
$invoiceid = $subarray['invoiceid'];

$rs_checkinvoice = "SELECT invstatus FROM invoices WHERE invoice_id = '$invoiceid'";
$rs_result_ci = mysqli_query($rs_connect, $rs_checkinvoice);
$rs_result_qci = mysqli_fetch_object($rs_result_ci);
$invstatus = "$rs_result_qci->invstatus";


if($invstatus == 2) {
$runningtime = $runningtime + (3600 * $blockhours);
} else {
$runningtime = $runningtime;
}

$timebalance = mf($runningtime / 3600);

echo "<tr><td colspan=2 style=\"vertical-align:top; border-left: #98D25F 10px solid;\">".pcrtlang("Purchased Hours")."";



if(($invstatus == 3) && ($contractclosed == 0)) {
echo "<a href=blockcontract.php?func=deletehoursinvoice&pcgroupid=$pcgroupid&blockcontracthoursid=$blockcontracthoursid class=\"linkbuttonsmall linkbuttongray\">delete</a>";
}

echo "</td><td>$thedateonly</td>";
echo "<td colspan=5><a href=invoice.php?func=printinv&invoice_id=$invoiceid class=\"linkbuttonsmall linkbuttongray\">".pcrtlang("Invoice")." #$invoiceid</a>";

if($invstatus != 2) {
echo " (".pcrtlang("Unpaid").")";
}

$rs_checkrinvoice = "SELECT * FROM rinvoices WHERE blockcontractid = '$blockid'";
$rs_result_rci = mysqli_query($rs_connect, $rs_checkrinvoice);

if (mysqli_num_rows($rs_result_rci) == "1") {
$rs_result_qrci = mysqli_fetch_object($rs_result_rci);
$rinvoice_id = "$rs_result_qrci->rinvoice_id";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Invoice: #$rinvoice_id <a href=rinvoice.php?func=browseri class=\"linkbuttonsmall linkbuttongray\">".pcrtlang("View Recurring Invoices")."</a>";
}


echo "</td>";

echo "<td style=\"text-align:right;\">+".mf("$blockhours")."</td>";

if($invstatus != 2) {
echo "<td style=\"text-align:right;\">+".mf("0")."</td>";
} else {
echo "<td style=\"text-align:right;\">+".mf("$blockhours")."</td>";
}

echo "<td style=\"text-align:right;\">$timebalance</td></tr>";


}


}


echo "<tr><td colspan=11 style=\"text-align:right;\">".pcrtlang("Remaining Time").": $timebalance</td></tr>";

$rs_update_h = "UPDATE blockcontract SET hourscache = '$timebalance' WHERE blockid = '$blockid'";
@mysqli_query($rs_connect, $rs_update_h);


echo "</table>";

echo "</div></div></div>";

}


require("footer.php");



}

























switch($func) {
                                                                                                    
    default:
    nothing();
    break;
                                
    case "view":
    view();
    break;



}

