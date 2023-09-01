<?php

require("deps.php");
require_once("common.php");

$thedate = date("Y-m-d");

if(!isset($pcrt_weekstart)) {
$pcrt_weekstart = "Sunday";
}

if ($pcrt_weekstart == "Sunday") {
if(date("w") == 0) {
$thedate2 = date("Y-m-d");
} else {
$thedate2 = date("Y-m-d",strtotime("last Sunday"));
}

} else {

if(date("N") == 1) {
$thedate2 = date("Y-m-d");
} else {
$thedate2 = date("Y-m-d",strtotime("last Monday"));
}
}



if ($pcrt_weekstart == "Sunday") {
$lthedate = date("Y-m-d",strtotime("last Saturday"));
$lthedate2 = date("Y-m-d",strtotime("last Saturday") - 518400);
} else {
$lthedate = date("Y-m-d",strtotime("last Sunday"));
$lthedate2 = date("Y-m-d",strtotime("last Sunday") - 518400);
}

$rs_find_wo = "SELECT * FROM pc_wo WHERE dropdate > '$thedate2 00:00:00' AND pcstatus != '7'";
$rs_result = mysqli_query($rs_connect, $rs_find_wo);
$wothisweek = mysqli_num_rows($rs_result);

$rs_find_wo = "SELECT * FROM pc_wo WHERE dropdate > '$lthedate2 00:00:00' AND dropdate < '$lthedate 11:59:59' AND pcstatus != '7'";
$rs_result = mysqli_query($rs_connect, $rs_find_wo);
$wolastweek = mysqli_num_rows($rs_result);

$rs_find_sr = "SELECT * FROM servicerequests WHERE sreq_datetime > '$thedate2 00:00:00'";
$rs_result = mysqli_query($rs_connect, $rs_find_sr);
$srthisweek = mysqli_num_rows($rs_result);

$rs_find_sr = "SELECT * FROM servicerequests WHERE sreq_datetime > '$lthedate2 00:00:00' AND sreq_datetime < '$lthedate 11:59:59'";
$rs_result = mysqli_query($rs_connect, $rs_find_sr);
$srlastweek = mysqli_num_rows($rs_result);

$rs_find_m = "SELECT * FROM messages WHERE messagedatetime > '$thedate2 00:00:00' AND messagedirection = 'in'";
$rs_result = mysqli_query($rs_connect, $rs_find_m);
$mthisweek = mysqli_num_rows($rs_result);

$rs_find_m = "SELECT * FROM messages WHERE messagedatetime > '$lthedate2 00:00:00' AND messagedatetime < '$lthedate 11:59:59' AND messagedirection = 'in'";
$rs_result = mysqli_query($rs_connect, $rs_find_m);
$mlastweek = mysqli_num_rows($rs_result);

echo "<div id=toparea></div>";

echo "<table class=pad10 style=\"width:100%;\">";
echo "<tr>";

$accentcolor = "#4bc2ff";
echo "<td style=\"width:34%;vertical-align:top;\"><div class=radiustop style=\"background:#ffffff;border-top: #cccccc 1px solid;border-right: #cccccc 1px solid;border-left: #cccccc 1px solid;padding:20px\">";
echo "<span style=\"color:$accentcolor\" class=\"boldme sizemelarger\">$wothisweek</span> &nbsp;";
echo "<span class=\"boldme sizemelarger\">".pcrtlang("This Week")."</span><br>";
echo "<span style=\"color:$accentcolor\" class=\"boldme sizemelarger\">$wolastweek</span> &nbsp;";
echo "<span class=\"boldme sizemelarger\">".pcrtlang("Last Week")."</span></div>";
echo "<div class=radiusbottom style=\"background:$accentcolor; padding:20px; color:#FFFFFF\">";
echo "<span class=boldme style=\"line-height:28px\"> ".pcrtlang("Work Orders")."<i class=\"fa fa-wrench fa-2x floatright\"></i></span></div></td>";


$accentcolor2 = "#FF5F4B";
echo "<td style=\"width:33%;vertical-align:top;\"><div class=radiustop style=\"background:#ffffff;border-top: #cccccc 1px solid;border-right: #cccccc 1px solid;border-left: #cccccc 1px solid;padding:20px\">";
echo "<span style=\"color:$accentcolor2\" class=\"boldme sizemelarger\">$srthisweek</span> &nbsp;";
echo "<span class=\"boldme sizemelarger\">".pcrtlang("This Week")."</span><br>";
echo "<span style=\"color:$accentcolor2\" class=\"boldme sizemelarger\">$srlastweek</span> &nbsp;";
echo "<span class=\"boldme sizemelarger\">".pcrtlang("Last Week")."</span></div>";
echo "<div class=radiusbottom style=\"background:$accentcolor2; padding:20px; color:#FFFFFF\">";
echo "<span class=\"boldme\" style=\"line-height:28px\"> ".pcrtlang("Service Requests")."<i class=\"fa fa-comments fa-2x floatright\"></i></span></div></td>";

$accentcolor3 = "#4BD34B";
echo "<td style=\"width:33%;vertical-align:top;\"><div class=radiustop style=\"background:#ffffff;border-top: #cccccc 1px solid;border-right: #cccccc 1px solid;border-left: #cccccc 1px solid;padding:20px\">";
echo "<span style=\"color:$accentcolor3\" class=\"boldme sizemelarger\">$mthisweek</span> &nbsp;";
echo "<span class=\"boldme sizemelarger\">".pcrtlang("This Week")."</span><br>";
echo "<span style=\"color:$accentcolor3\" class=\"boldme sizemelarger\">$mlastweek</span> &nbsp;";
echo "<span class=\"boldme sizemelarger\">".pcrtlang("Last Week")."</span></div>";
echo "<div class=radiusbottom style=\"background:$accentcolor3; padding:20px; color:#FFFFFF\">";
echo "<span class=boldme style=\"line-height:28px\"> ".pcrtlang("Incoming Messages")."<i class=\"fa fa-mobile fa-2x floatright\"></i></span></div></td>";



echo "</tr></table>";

### Stickies ################################################################################

$currentdate = date('Y-m-d');

$rs_findnotes52 = "SELECT * FROM stickynotes WHERE stickyduedate >= '$currentdate' ORDER BY stickyduedate ASC LIMIT 20";

$rs_result_n5 = mysqli_query($rs_connect, $rs_findnotes52);

echo "<br><br>";

echo "<div class=radiustop style=\"background:#ffbb00; padding:20px; color:#FFFFFF\">";
echo "<span class=boldme style=\"line-height:28px\"> ".pcrtlang("Upcoming Sticky Notes")."<i class=\"fa fa-sticky-note fa-2x floatright\"></i></span></div>";
echo "<div style=\"background:#ffffff;border-right: #ffbb00 1px solid;border-left: #ffbb00 1px solid;padding:10px\">";

echo "<div class=\"scrolling-sticky-flexbox\">";

echo "<div style=\"flex: 0 0 10px;\"></div>";

while($rs_result_qn5 = mysqli_fetch_object($rs_result_n5)) {
$stickyid = "$rs_result_qn5->stickyid";
$stickyaddy1 = "$rs_result_qn5->stickyaddy1";
$stickyaddy2 = "$rs_result_qn5->stickyaddy2";
$stickycity = "$rs_result_qn5->stickycity";
$stickystate = "$rs_result_qn5->stickystate";
$stickyzip = "$rs_result_qn5->stickyzip";
$stickyphone = "$rs_result_qn5->stickyphone";
$stickyemail = "$rs_result_qn5->stickyemail";
$stickyduedate = "$rs_result_qn5->stickyduedate";
$stickytypeid = "$rs_result_qn5->stickytypeid";
$stickyuser = "$rs_result_qn5->stickyuser";
$stickynote_orig = "$rs_result_qn5->stickynote";
$stickynote = nl2br($stickynote_orig);
$stickyname = "$rs_result_qn5->stickyname";
$stickycompany = "$rs_result_qn5->stickycompany";
$refid = "$rs_result_qn5->refid";
$reftype = "$rs_result_qn5->reftype";


$rs_qst = "SELECT * FROM stickytypes WHERE stickytypeid = '$stickytypeid'";
$rs_resultst1 = mysqli_query($rs_connect, $rs_qst);
if(mysqli_num_rows($rs_resultst1) == "1") {
$rs_result_stq1 = mysqli_fetch_object($rs_resultst1);
$stickytypename = "$rs_result_stq1->stickytypename";
$stickybordercolor = "$rs_result_stq1->bordercolor";
$stickynotecolor = "$rs_result_stq1->notecolor";
$stickynotecolor2 = "$rs_result_stq1->notecolor2";
} else {
$stickytypename = pcrtlang("Undefined");
$stickybordercolor = "000000";
$stickynotecolor = "ffffff";
$stickynotecolor2 = "cccccc";
}

#wip

#echo "<div style=\"flex: 0 0 250px;\">";
echo "<div style=\"flex: 0 0 250px; margin-bottom:10px;border:1px solid #$stickybordercolor;background:#$stickynotecolor;
background: linear-gradient(to bottom, #$stickynotecolor 0%, #$stickynotecolor2 100%);\">";

echo "<div style=\"background:#$stickybordercolor;padding:5px;\"><span class=\"colormewhite sizemelarge boldme\">$stickytypename</span><br>
<span class=\"colormewhite boldme\">$stickyname<span></div>";


echo "<div style=\"padding:3px;\">";

if("$stickycompany" != "") {
echo "<br><span style=\"color:#$stickybordercolor;\">$stickycompany</span><br>";
}

$stickynote2 = preg_replace('/([a-zA-Z]{30})(?![^a-zA-Z])/', '$1 ', $stickynote);

echo "<br><span style=\"color:#$stickybordercolor;\">$stickynote2</span><br>";

$stickyduedate2 = date("M j, Y, g:i a",strtotime($stickyduedate));
echo "<br><span class=\"sizemesmaller\" style=\"color:#$stickybordercolor;\">".pcrtlang("Date/Due Date").": $stickyduedate2</span>";

if ($stickyuser != "none") {
echo "<br><span class=\"sizemesmaller\" style=\"color:#$stickybordercolor;\">".pcrtlang("Assigned To").": $stickyuser</span>";
}

if ($stickyaddy1 != "") {
echo "<br><span class=\"sizemesmaller\" style=\"color:#$stickybordercolor;\">$stickyaddy1</span>";
}

if ($stickyaddy2 != "") {
echo "<br><span class=\"sizemesmaller\" style=\"color:#$stickybordercolor;\">$stickyaddy2</span>";
}

if (($stickycity != "") || ($stickystate != "") || ($stickyzip != "")){
echo "<br><span class=\"sizemesmaller\" style=\"color:#$stickybordercolor;\">$stickycity, $stickystate $stickyzip</span>";
}

if ($stickyphone != "") {
echo "<br><span class=\"sizemesmaller\" style=\"color:#$stickybordercolor;\">$stickyphone</span>";
}

if ($stickyemail != "") {
echo "<br><a href=\"mailto:$stickyemail\" class=\"linkbuttontiny linkbuttonopaque radiusall\"><i class=\"fa fa-envelope fa-lg\"></i> $stickyemail</a><br>";
}
if ($refid != "0") {

if ($reftype == "woid") {
echo "<br><a href=\"index.php?pcwo=$refid\" class=\"linkbuttontiny linkbuttonopaque radiusall\"><i class=\"fa fa-clipboard fa-lg\"></i> ".pcrtlang("Work Order")." #$refid</a>";
} elseif ($reftype == "pcid") {
echo "<br><a href=\"pc.php?func=showpc&pcid=$refid\" class=\"linkbuttontiny linkbuttonopaque radiusall\"><i class=\"fa fa-tag fa-lg\"></i> ".pcrtlang("PCID")." #$refid</a>";
} elseif ($reftype == "groupid") {
echo "<br><a href=\"group.php?func=viewgroup&pcgroupid=$refid\" class=\"linkbuttontiny linkbuttonopaque radiusall\"><i class=\"fa fa-group fa-lg\"></i> ".pcrtlang("Group ID")."
#$refid</a>";
}


}




#echo "</div>";

echo "</div></div>";


echo "<div style=\"flex: 0 0 10px;\"></div>";

}

echo "</div></div>";

$rs_findnotes_old = "SELECT * FROM stickynotes WHERE stickyduedate < '$currentdate' AND showonwall = '1'";
$rs_result_oldnote = mysqli_query($rs_connect, $rs_findnotes_old);
$old_note_count = mysqli_num_rows($rs_result_oldnote);

echo "<div class=radiusbottom style=\"background:#ffbb00; padding:10px; color:#FFFFFF\">";
echo "<a href=\"stickydisplay.php\" class=\"linkbuttonopaque linkbuttonmedium radiusall\" style=\"display:block\">".pcrtlang("Past Due Sticky Notes On Wall")." ($old_note_count)</a></div>";

echo "<br>";


##############################################################################################
# Average Repair Time

echo "<table class=pad10 style=\"width:100%;\">";
echo "<tr>";

$accentcolor4 = "#777777";
echo "<td><div class=radiustop style=\"background:#ffffff;border-top: #cccccc 1px solid;border-right: #cccccc 1px solid;border-left: #cccccc 1px solid;padding:20px\">";


?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.2/Chart.bundle.min.js"></script>
<center><canvas id="myLineChart" width="700" height="200"></canvas></center>
<?php


echo "</div><div class=radiusbottom style=\"background:$accentcolor4; padding:20px; color:#FFFFFF\">";
echo "<span class=boldme style=\"line-height:28px\"> ".pcrtlang("Average Repair Time")."<i class=\"fa fa-clock-o fa-2x floatright\"></i></span></div></td>";

echo "</tr></table>";



$shift = 0;

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}

$currentdatetime = date('Y-m-d H:i:s');

$today = date('N');

$thefirstday = (time() - (86400 * $today));

$thefirstdaytime = 604799 + strtotime(date('Y-m-d 00:00:00', $thefirstday));

$theprev = 0;

while($shift < 53) {

if($shift > 0) {
$weeksago[] = "$shift ".pcrtlang("Weeks Ago");
} else {
$weeksago[] = pcrtlang("This Week");
}



$rs_findwotime = "SELECT SUM(TIMESTAMPDIFF(SECOND,dropdate,readydate)) AS totalseconds FROM pc_wo WHERE readydate != '0000-00-00 00:00:00' AND storeid = '$defaultuserstore' AND sked = '0' AND pcstatus != '7' AND pcstatus != '6' AND readydate < DATE_ADD(dropdate, INTERVAL 10 day) AND (WEEK(dropdate) = WEEK(DATE_SUB('$currentdatetime', INTERVAL $shift week)) AND YEAR(dropdate) = YEAR(DATE_SUB('$currentdatetime', INTERVAL $shift week)))";
$rs_findwotimewo = "SELECT woid FROM pc_wo WHERE readydate != '0000-00-00 00:00:00' AND storeid = '$defaultuserstore' AND sked = '0'  AND pcstatus != '7' AND pcstatus != '6' AND readydate < DATE_ADD(dropdate, INTERVAL 10 day) AND (WEEK(dropdate) = WEEK(DATE_SUB('$currentdatetime', INTERVAL $shift week)) AND YEAR(dropdate) = YEAR(DATE_SUB('$currentdatetime', INTERVAL $shift week)))";



$rs_resulttime = mysqli_query($rs_connect, $rs_findwotime);
$rs_result_qwo = mysqli_fetch_object($rs_resulttime);
$totalseconds = "$rs_result_qwo->totalseconds";
$rs_resulttimewo = mysqli_query($rs_connect, $rs_findwotimewo);
$totaltimerecords = mysqli_num_rows($rs_resulttimewo);

if ($totaltimerecords > 2) {
$averagetime = ($totalseconds / $totaltimerecords) / 86400;
$thedaysonbench = number_format($averagetime,1);
$theaverage[] = "$thedaysonbench";
$theprev = "$thedaysonbench";
} else {
$theaverage[] = "$theprev";
}
$shift = $shift + 2;
}


$theaveragejson = json_encode($theaverage);
$weeksagojson = json_encode($weeksago);

?>

<script>

var data = {
    labels:  <?php echo $weeksagojson; ?>,
    datasets: [
        {
            label: "<?php echo pcrtlang("Days") ?>",
            fill: true,
            lineTension: .5,
            backgroundColor: "rgba(119,119,119,0.4)",
            borderColor: "rgba(119,119,119,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(119,119,119,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php echo $theaveragejson; ?>,
            spanGaps: false,
        }
   ]
};

var ctx = document.getElementById("myLineChart");
var myLineChart = new Chart(ctx, {
    type: 'line',
    data: data,
 options: {
        responsive: false
    }
});

</script>


<?php


################################################

echo "<br><br><table class=pad10 style=\"width:100%;\">";
echo "<tr>";



$accentcolor2 = "#d787ff";
echo "<td style=\"width:50%;vertical-align:top;\">";
echo "<div class=radiustop style=\"background:$accentcolor2; padding:20px; color:#FFFFFF\">";
echo "<span class=boldme style=\"line-height:28px\"> ".pcrtlang("Device Types Past Month")."<i class=\"fa fa-desktop fa-2x floatright\"></i></span></div>";
echo "<div class=radiusbottom style=\"background:#ffffff;border-bottom: #cccccc 1px solid;border-right: #cccccc 1px solid;border-left: #cccccc 1px solid;padding:20px\">";

$matnames = array();
$matcount = array();

?>
<canvas id="BarChart" width="350" height="400"></canvas>
<?php

$rs_findmat = "SELECT * FROM mainassettypes";
$rs_result_n = mysqli_query($rs_connect, $rs_findmat);
while($rs_result_qn = mysqli_fetch_object($rs_result_n)) {
$matid = "$rs_result_qn->mainassettypeid";
$matname = "$rs_result_qn->mainassetname";
$matnames[$matid] = "$matname";
$matcount[$matid] = "0";
}

$rs_find_wo = "SELECT * FROM pc_wo WHERE dropdate > DATE_SUB(NOW(), INTERVAL 30 day)";
$rs_result = mysqli_query($rs_connect, $rs_find_wo);
while($rs_result_q5 = mysqli_fetch_object($rs_result)) {
$pcid = "$rs_result_q5->pcid";
$rs_findowner = "SELECT * FROM pc_owner WHERE pcid = '$pcid'";
$rs_resultt = mysqli_query($rs_connect, $rs_findowner);
$rs_result_q = mysqli_fetch_object($rs_resultt);
$womatid = "$rs_result_q->mainassettypeid";
$matcount[$womatid] = $matcount[$womatid] + 1;
}

$theservicejson = json_encode(array_values($matnames));
$servicetotaljson = json_encode(array_values($matcount));






?>


<script>

var data = {
    labels: <?php echo $theservicejson; ?>,
    datasets: [
        {
            label: "<?php echo pcrtlang("Device Type"); ?>",
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1,
            data: <?php echo $servicetotaljson; ?>,
        }
    ]
};

var ctx = document.getElementById("BarChart");
var BarChart = new Chart(ctx, {
    type: 'horizontalBar',
    data: data,
options: {
        responsive: false
    }
});


</script>
<?php



echo "</td>";

$accentcolor3 = "#0077EE";
echo "<td style=\"width:50%;vertical-align:top;\">";
echo "<div class=radiustop style=\"background:$accentcolor3; padding:20px; color:#FFFFFF\">";
echo "<span class=boldme style=\"line-height:28px\"> ".pcrtlang("Top Services Past Month")."<i class=\"fa fa-briefcase fa-2x floatright\"></i></span></div>";
echo "<div class=radiusbottom style=\"background:#ffffff;border-bottom: #cccccc 1px solid;border-right: #cccccc 1px solid;border-left: #cccccc 1px solid;padding:20px\">";

$theservice = array();
$servicetotal = array();

?>
<canvas id="BarChartST" width="350" height="400"></canvas>
<?php

$rs_find_current_woid = "SELECT COUNT(sold_price) AS servicecount, labor_desc FROM sold_items WHERE date_sold > DATE_SUB(NOW(), INTERVAL 30 day) AND sold_type = 'labor' GROUP BY labor_desc ORDER BY servicecount DESC LIMIT 10";
$rs_result_pur = mysqli_query($rs_connect, $rs_find_current_woid);

while($rs_result_q = mysqli_fetch_object($rs_result_pur)) {
$labor_desc = "$rs_result_q->labor_desc";
$servicecount = "$rs_result_q->servicecount";


if($servicecount > 1) {
$theservice[] = $labor_desc;
$servicetotal[] = $servicecount;
}


}

$theservicejson = json_encode($theservice);
$servicetotaljson = json_encode($servicetotal);

?>


<script>

var data = {
    labels: <?php echo $theservicejson; ?>,
    datasets: [
        {
            label: "<?php echo pcrtlang("Service Count"); ?>",
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1,
            data: <?php echo $servicetotaljson; ?>,
        }
    ]
};

var ctx = document.getElementById("BarChartST");
var BarChartST = new Chart(ctx, {
    type: 'horizontalBar',
    data: data,
options: {
        responsive: false
}
});


</script>
<?php



echo "</div>";
echo "</td>";



echo "</tr></table>";

echo "<table class=pad10 style=\"width:100%\">";

$accentcolor = "#4BD34B";
echo "<td style=\"width:100%;vertical-align:top;\">";
echo "<div class=radiustop style=\"background:$accentcolor; padding:20px; color:#FFFFFF\">";
echo "<span class=boldme style=\"line-height:28px\"> ".pcrtlang("Recent Incoming Messages")."<i class=\"fa fa-mobile fa-2x floatright\"></i></span></div>";
echo "<div class=radiusbottom style=\"background:#ffffff;border-bottom: #cccccc 1px solid;border-right: #cccccc 1px solid;border-left: #cccccc 1px solid;padding:20px\">";



echo "<table class=pad5>";
$rs_findmessages = "SELECT * FROM messages WHERE messagedirection = 'in' ORDER BY messagedatetime DESC LIMIT 6";
$rs_result_n = mysqli_query($rs_connect, $rs_findmessages);
while($rs_result_qn = mysqli_fetch_object($rs_result_n)) {
$messageid = "$rs_result_qn->messageid";
$messagebody = "$rs_result_qn->messagebody";
$messagefrom = "$rs_result_qn->messagefrom";
$messagedatetime = "$rs_result_qn->messagedatetime";

if(strlen($messagebody) > 150) {
$messagebody = substr("$messagebody", 0, 150)."...";
}


#$messagebody = wordwrap($messagebody, 60, "<br />\n", true);

#$res_str = array_chunk(explode(" ",$messagebody),9);
#foreach( $res_str as &$val){
#   $val  = implode(" ",$val);
#}

echo "<tr><td><i class=\"fa fa-user fa-2x\" style=\"color:$accentcolor\"></i></td><td style=\"text-align:left;\"><span class=\"sizemelarger\">$messagebody</span><br><span style=\"color:$accentcolor\">".elaps("$messagedatetime")." ".pcrtlang("ago")."</span></td></tr>";
}
echo "</table>";

echo "<a href=messages.php?func=browsemessages class=\"linkbuttonsmall linkbuttongreen displayblock radiusall\"><i class=\"fa fa-mobile fa-lg\"></i> ".pcrtlang("Browse Messages")."</a>";

echo "</div>";
echo "</td>";
echo "</table>";


?>

<script type='text/javascript'>
$(document).ready(function(){
$('#sidemenu').off('click','.catchloadworkorder');
$('#sidemenu').on('click','.catchloadworkorder',function(e) { // catch the form's submit event
if (typeof messagesInterval != 'undefined') clearInterval(messagesInterval);
        e.preventDefault();
                var url = $(this).attr('href');
                var urlf = url.replace("index", "wo");
                $('html, body').animate({scrollTop: $("#toparea").offset().top-90}, 10);
                $("#mainworkorder").html("<br><br><br><center><i class=\"fas fa-spinner fa-pulse fa-10x colormegray\"></i></center>");
                $.get(urlf, function (data) {
                $('#mainworkorder').html(data);
                });
});
});
</script>




