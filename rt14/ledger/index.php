<?php 

/***************************************************************************
 *   copyright            : (C) 2020 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/

require("deps.php");
require_once("common.php");

perm_boot("41");

require("header.php"); 

echo "<script type=\"text/javascript\">document.title = \"".pcrtlang("Ledger")."\";</script>";


$rs_qlfirstenabled = "SELECT ledgerid FROM gl WHERE ledgerenabled = '1' LIMIT 1";
$rs_result1firstenabled = mysqli_query($rs_connect, $rs_qlfirstenabled);
$countledger2 = mysqli_num_rows($rs_result1firstenabled);

if($countledger2 != 0) {



$thedate = date("Y-m-d");

if(!isset($pcrt_weekstart)) {
$pcrt_weekstart = "Sunday";
}

$year = date("Y");
$lastyear = $year - 1;

$m = 1;

$chartincome = array();
$chartexpense = array();


echo "<table class=pad10 style=\"width:100%;\">";
echo "<tr>";

$accentcolor4 = "#777777";
echo "<td><div class=radiustop style=\"background:#ffffff;border-top: #cccccc 1px solid;border-right: #cccccc 1px solid;border-left: #cccccc 1px solid;padding:20px\">";

?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.2/Chart.bundle.min.js"></script>

<canvas id="myLineChart" width="700px;" height="200px"></canvas>
<?php

echo "</div><div class=radiusbottom style=\"background:$accentcolor4; padding:20px; color:#FFFFFF\">";
echo "<span class=boldme style=\"line-height:28px\"> ".pcrtlang("Income/Expense")."</span><span class=\"floatright sizemelarger boldme\"><i class=\"fa fa-chart-line fa-lg\"></i> $year</span></div></td>";

echo "</tr></table>";




while($m < 13) {

$rs_find_e = "SELECT SUM(expense) AS dtotal, SUM(income) AS ctotal FROM glstransdet,glstrans,glsaccounts
WHERE glstrans.ledgerid = '$userledgerid' AND glstrans.transid = glstransdet.transid
AND glstransdet.accountid = glsaccounts.accountid AND glsaccounts.accounttype = 'expense'
AND MONTH(glstrans.transdate) = '$m' AND YEAR(glstrans.transdate) = '$year'";
$rs_result_e = mysqli_query($rs_connect, $rs_find_e);
$rs_result_e_q = mysqli_fetch_object($rs_result_e);
$rs_dtotal_e = "$rs_result_e_q->dtotal";
$rs_ctotal_e = "$rs_result_e_q->ctotal";
$balance_e = tnv($rs_ctotal_e) - tnv($rs_dtotal_e);
$chartexpense[] = "$balance_e";

$rs_find_i = "SELECT SUM(expense) AS dtotal, SUM(income) AS ctotal FROM glstransdet,glstrans,glsaccounts
WHERE glstrans.ledgerid = '$userledgerid' AND glstrans.transid = glstransdet.transid
AND glstransdet.accountid = glsaccounts.accountid AND glsaccounts.accounttype = 'income'
AND MONTH(glstrans.transdate) = '$m' AND YEAR(glstrans.transdate) = '$year'";
$rs_result_i = mysqli_query($rs_connect, $rs_find_i);
$rs_result_i_q = mysqli_fetch_object($rs_result_i);
$rs_dtotal_i = "$rs_result_i_q->dtotal";
$rs_ctotal_i = "$rs_result_i_q->ctotal";
$balance_i = tnv($rs_ctotal_i) - tnv($rs_dtotal_i);
$chartincome[] = "$balance_i";

$chartprofit[] = tnv($balance_i) + tnv($balance_e);

$m++;

}

###


$chartincomejson = json_encode($chartincome);
$chartexpensejson = json_encode($chartexpense);
$chartprofitjson = json_encode($chartprofit);
$months = "[\"".pcrtlang("January")."\", \"".pcrtlang("February")."\", \"".pcrtlang("March")."\", \"".pcrtlang("April")."\", \"".pcrtlang("May")."\", \"".pcrtlang("June")."\", \"".pcrtlang("July")."\", \"".pcrtlang("August")."\", \"".pcrtlang("September")."\", \"".pcrtlang("October")."\", \"".pcrtlang("November")."\", \"".pcrtlang("December")."\"]";



?>

<script>

var data = {
    labels:  <?php echo $months; ?>,
    datasets: [
        {
            label: "<?php echo pcrtlang("Income"); ?>",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(75,192,0,0.4)",
            borderColor: "rgba(75,192,0,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php echo $chartincomejson; ?>,
            spanGaps: false,
        },
        {
            label: "<?php echo pcrtlang("Expense") ?>",
            fill: false,
            lineTension: 0.1,
	    backgroundColor: "rgba(255,89,89,0.4)",
            borderColor: "rgba(255,89,89,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php echo $chartexpensejson; ?>,
            spanGaps: false,
        },
       {
            label: "<?php echo pcrtlang("Profit") ?>",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(0,0,0,0.4)",
            borderColor: "rgba(0,0,0,0.4)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php echo $chartprofitjson; ?>,
            spanGaps: false,
        }


    ]
};

var ctx = document.getElementById("myLineChart");
var myLineChart = new Chart(ctx, {
    type: 'line',
    data: data,
 options: {
        responsive: true
    }
});

</script>

<?php

$expenseaccountarray = array();
$expensetotalsarray = array();
$expensetotalsarrayprojected = array();
$expensetotalsarrayly = array();

$rs_find_acc = "SELECT * FROM glsaccounts WHERE ledgerid = '$userledgerid' AND accounttype = 'expense'";
$rs_result_acc = mysqli_query($rs_connect, $rs_find_acc);
while($rs_result_acc_q = mysqli_fetch_object($rs_result_acc)) {
$accountid = "$rs_result_acc_q->accountid";
$accountname = "$rs_result_acc_q->accountname";

$expenseaccountarray[] = "$accountname";

$rs_find_e = "SELECT SUM(expense) AS dtotal, SUM(income) AS ctotal FROM glstransdet,glstrans,glsaccounts
WHERE glstrans.ledgerid = '$userledgerid' AND glstrans.transid = glstransdet.transid
AND glstransdet.accountid = glsaccounts.accountid
AND glsaccounts.accountid = glstransdet.accountid
AND glstransdet.accountid = '$accountid'
AND glstrans.transdate LIKE '$year%'";
$rs_result_e = mysqli_query($rs_connect, $rs_find_e);
$rs_result_e_q = mysqli_fetch_object($rs_result_e);
$rs_dtotal_e = "$rs_result_e_q->dtotal";
$rs_ctotal_e = "$rs_result_e_q->ctotal";
$balance_e = tnv($rs_ctotal_e) - tnv($rs_dtotal_e);
$pbalance_e = abs("$balance_e");

$expensetotalsarray[] = mf("$pbalance_e");
$expensetotalsarrayprojected[] = mf((365 / date('z')) * $pbalance_e);


$rs_find_e = "SELECT SUM(expense) AS dtotal, SUM(income) AS ctotal FROM glstransdet,glstrans,glsaccounts
WHERE glstrans.ledgerid = '$userledgerid' AND glstrans.transid = glstransdet.transid
AND glstransdet.accountid = glsaccounts.accountid
AND glsaccounts.accountid = glstransdet.accountid
AND glstransdet.accountid = '$accountid'
AND glstrans.transdate LIKE '$lastyear%'";
$rs_result_e = mysqli_query($rs_connect, $rs_find_e);
$rs_result_e_q = mysqli_fetch_object($rs_result_e);
$rs_dtotal_e = "$rs_result_e_q->dtotal";
$rs_ctotal_e = "$rs_result_e_q->ctotal";
$balance_e = tnv($rs_ctotal_e) - tnv($rs_dtotal_e);
$pbalance_e = abs("$balance_e");

$expensetotalsarrayly[] = mf("$pbalance_e");


}

$elements = count($expensetotalsarray);

$canvasheight = $elements * 36;

echo "<table class=pad10 style=\"width:100%;\">";
echo "<tr>";

$accentcolor2 = "#777777";
echo "<td><div class=radiustop style=\"background:#ffffff;border-top: #cccccc 1px solid;border-right: #cccccc 1px solid;border-left: #cccccc 1px solid;padding:20px\">";

echo "<canvas id=\"accountBarChart\" width=\"700px;\" height=\"$canvasheight"."px\"></canvas>";


echo "</div><div class=radiusbottom style=\"background:$accentcolor2; padding:20px; color:#FFFFFF\">";
echo "<span class=boldme style=\"line-height:28px\"> ".pcrtlang("Expense Accounts")."</span><span class=\"floatright sizemelarger boldme\"><i class=\"fa fa-money-check fa-lg\">
</i></span></div></td>";

echo "</tr></table>";



$expensetotalsarrayjson = json_encode($expensetotalsarray);
$expensetotalsarrayprojectedjson = json_encode($expensetotalsarrayprojected);
$expensetotalsarrayjsonly = json_encode($expensetotalsarrayly);
$expenseaccountarrayjson = json_encode($expenseaccountarray);

#echo "$expensetotalsarrayjson<br>";
#echo "$chartincomejson<br>";
#echo "$expenseaccountarrayjson";


$colorstouse = array();
$colors = array("#f44336","#e81e63","#9c27b0","#673ab7","#3f51b5","#2196f3","#03a9f4","#00bcd4","#009688","#4caf50","#8bc34a","#cddc39","#ffeb3b","#ffc107","#ff9800","#ff5722","#795548","#9e9e9e","#607d8b"); 
foreach($colors as $key => $val) {
if($key < $elements) {
$colorstouse[] = $val;
}
}

$colorstousejson = json_encode($colorstouse);
#wip

?>

<script>
var ctx = document.getElementById('accountBarChart');
var myChart2 = new Chart(ctx, {
    type: 'horizontalBar',
    data: {
        labels: <?php echo "$expenseaccountarrayjson"; ?>,
        datasets: [{
	    label: '<?php echo "$year ".pcrtlang("Expense"); ?>',
            data:  <?php echo $expensetotalsarrayjson; ?>,
            backgroundColor: <?php echo $colorstousejson; ?>
	    },
	    {
            label: '<?php echo "$year ".pcrtlang("Expense (Projected)"); ?>',
            data:  <?php echo $expensetotalsarrayprojectedjson; ?>,
            backgroundColor: <?php echo $colorstousejson; ?>
            },    
            {
            label: '<?php echo "$lastyear ".pcrtlang("Expense"); ?>',
            data:  <?php echo $expensetotalsarrayjsonly; ?>,
            backgroundColor: <?php echo $colorstousejson; ?>
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>

<?php

#end no ledgers present
}


require("footer.php"); 
?>
