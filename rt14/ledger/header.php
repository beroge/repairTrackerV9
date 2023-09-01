<?php

/***************************************************************************
 *   copyright            : (C) 2012 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/

$startpagetime = microtime(true);

require_once("validate.php");
require_once("deps.php");
require_once("common.php");
perm_boot("41");
$storeinfoarray = getstoreinfo($defaultuserstore);
?>
<!DOCTYPE html>
<html>
<head>

<title><?php echo "$ipofpc | $sitename"; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta NAME="AUTHOR" CONTENT="Luke Stroven">

<link rel="apple-touch-icon" sizes="57x57" href="../repair/favicon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="../repair/favicon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="../repair/favicon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="../repair/favicon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="../repair/favicon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="../repair/favicon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="../repair/favicon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="../repair/favicon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="../repair/favicon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="../repair/favicon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="../repair/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="../repair/favicon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="../repair/favicon/favicon-16x16.png">
<link rel="manifest" href="../repair/favicon/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">


<?php
if(!isset($pcrt_stylesheet)) {
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../repair/style.css\">";
} else {
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../repair/$pcrt_stylesheet\">";
}
?>

<link rel="stylesheet" href="../repair/fa5/css/all.min.css">
<link rel="stylesheet" href="../repair/fa5/css/v4-shims.min.css">
<link rel="stylesheet" href="../repair/fa5/font-awesome-animation.min.css">

 <link href="../repair/jq/facebox.css" media="screen" rel="stylesheet" type="text/css" />
  <script src="../repair/jq/jquery.js" type="text/javascript"></script>
  <script src="../repair/jq/facebox.js" type="text/javascript"></script>
  <script type="text/javascript">
    jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        loadingImage : '../repair/jq/loading.gif',
        closeImage : '../repair/jq/closelabel.png'
      })
    })
  </script>

<script src="../repair/jq/howler.js"></script>
<script>
    var sound = new Howl({
      src: ['../repair/sounds/notify.ogg', '../repair/sounds/notify.mp3']
    });
</script>


</head>

<body>


<div id=topnavbarfixed style="white-space: nowrap;">
<table style="border-collapse:collapse;width:100%"><tr><td style="padding:0px;width:200px;">

<?php
if(strlen("$storeinfoarray[storesname]") > 24) {
$menufontsize = "font-size:12px;";
} elseif(strlen("$storeinfoarray[storesname]") > 15) {
$menufontsize = "font-size:14px;";
} else {
$menufontsize = "";
}
?>


<ul id="navgonew"><li><a class="primary_linkgonew" href="javascript:void(0)" style="<?php echo "$storeinfoarray[linestyle] $menufontsize"; ?>">
<i class="fa fa-bars"></i> <?php echo "$storeinfoarray[storesname]"; ?></a><div class="dropdowngonew">
<?php
require_once("topnavmenuvertnew.php");
?>
</div></li></ul>

</td><td>
<a href="../repair/" class=notifybarlink><i class="fa fa-wrench fa-lg"></i> <?php echo pcrtlang("Repair"); ?></a><a href="../store/" class=notifybarlink><i class="fa fa-store fa-lg"></i> <?php echo pcrtlang("Store"); ?></a><a href="../timeclock/" class=notifybarlink><i class="fa fa-calculator fa-lg"></i> <?php echo pcrtlang("Timeclock"); ?></a>
</td><td>









</td><td style="text-align:right;">

<?php
echo "<div id=notify>";
echo "</div>";
?>

</td><td style="padding:0px;width:200px;">
<ul id="navgo_rightnew">
<li><a class="primary_linkgo_rightnew" href="javascript:void(0)">
<i class="fa fa-user"></i> <?php echo $ipofpc; ?> </a><div class="dropdowngo_rightnew">
<?php
require_once("topnavmenuvertnew_right.php");
?>
</div></li></ul>

</td></tr></table>

</div>

<table class=interface>
    <tr>
        <td style="width:30%;background:#<?php echo $storeinfoarray['interfacecolor1']; ?>;padding:50px 20px 20px 20px;"></td>
        <td style="width:70%;background:#<?php echo $storeinfoarray['interfacecolor2']; ?>;padding:50px 20px 20px 40px;"></td></tr>

    <tr>
       	<td style="width:30%;background:#<?php echo $storeinfoarray['interfacecolor1']; ?>;padding:0px 20px 20px 20px;vertical-align:top">



<?php


if ($gomodal == 1) {
$therel = "rel=facebox";
} else {
$therel = "";
}


$rs_qlfirstenabled = "SELECT ledgerid FROM gl WHERE ledgerenabled = '1' LIMIT 1";
$rs_result1firstenabled = mysqli_query($rs_connect, $rs_qlfirstenabled);
$countledger2 = mysqli_num_rows($rs_result1firstenabled);

if($countledger2 != 0) {

if($userledgerid == "0") {
echo "<a href=\"javascript:void(0);\" class=\"linkbuttonlarge linkbuttongray radiusall displayblock\" id=ledgerchange><i class=\"fa fa-book fa-lg\">
</i> ".pcrtlang("Choose Ledger")." <i class=\"fa fa-chevron-down fa-lg floatright\" id=ledtog></i></a>";
} else {
$rs_find_ledgername = "SELECT * FROM gl WHERE ledgerid = '$userledgerid'";
$rs_result_ledgername = mysqli_query($rs_connect,$rs_find_ledgername);
$rs_result_ledgernameq = mysqli_fetch_object($rs_result_ledgername);
$ledgername = "$rs_result_ledgernameq->ledgername";
$ledgermethod = "$rs_result_ledgernameq->method";
echo "<a href=\"javascript:void(0);\" class=\"linkbuttonlarge linkbuttongray radiusall displayblock\" id=ledgerchange><i class=\"fa fa-book fa-lg\">
</i> $ledgername ";
if($ledgermethod == 1) {
echo "&nbsp;<i class=\"fa fa-money-bill-wave fa-lg colormegreen\"></i>";
} else {
echo "&nbsp;<i class=\"fa fa-chart-line fa-lg colormeblue\"></i>";
}

echo "<i class=\"fa fa-chevron-down fa-lg floatright\" id=ledtog></i></a>";
}


echo "<div id=ledgerselectorbox style=\"display:none;\">";

$rs_find_linkedstores = "SELECT * FROM gl WHERE ledgerid != '$userledgerid'";
$rs_result_linkedstores = mysqli_query($rs_connect,$rs_find_linkedstores);
while($rs_result_linkedstoreq = mysqli_fetch_object($rs_result_linkedstores)) {
$ledgerid = "$rs_result_linkedstoreq->ledgerid";
$ledgername = "$rs_result_linkedstoreq->ledgername";
$ledgeran = "$rs_result_linkedstoreq->ledgeran";
$linkedstore = "$rs_result_linkedstoreq->linkedstore";
$ledgermethod = "$rs_result_linkedstoreq->method";
echo "<a href=\"ledgers.php?func=changeledger&ledger=$ledgerid\" class=\"linkbuttonlarge linkbuttongray displayblock\" id=ledgerchange><i class=\"fa fa-book fa-lg\"></i> $ledgername";

echo "<span class=floatright>";
if($ledgermethod == 1) {
echo "<i class=\"fa fa-money-bill-wave fa-lg\"></i>";
} else {
echo "<i class=\"fa fa-chart-line fa-lg\"></i>";
}
echo "</span></a>";

}
echo "</div>";


?>
<script type='text/javascript'>
$('#ledgerchange').click(function(){
  $('#ledgerselectorbox').toggle('1000');
  $('#ledtog').toggleClass("fa-chevron-up fa-chevron-down");
  $('#ledgerchange').toggleClass("radiusall radiustop");
});
</script>
<?php





echo "<br><br>";


echo "<a href=\"./\" class=\"linkbuttongray linkbuttonlarge displayblock\"><i class=\"fa fa-home fa-lg fa-fw\"></i> ".pcrtlang("Home")."</a>";

if($userledgertype == 1) {
echo "<a href=\"strans.php\" class=\"linkbuttongray linkbuttonlarge displayblock\"><i class=\"fa fa-cash-register fa-lg fa-fw\"></i> ".pcrtlang("Transactions")."</a>";
} else {
echo "<a href=\"dtrans.php\" class=\"linkbuttongray linkbuttonlarge displayblock\"><i class=\"fa fa-cash-register fa-lg fa-fw\"></i> ".pcrtlang("Transactions")."</a>";
}



if((count(explode_list($userlinkedstore))) > 0) {

$rs_find_income = "SELECT * FROM glsaccounts WHERE accounttype = 'income' AND ledgerid = '$userledgerid'";
$rs_result_income = mysqli_query($rs_connect,$rs_find_income);
$incomeexists = mysqli_num_rows($rs_result_income);
if($incomeexists > 0) {

if($userledgertype == 1) {
echo "<a href=\"strans.php?func=importsales\" class=\"linkbuttongray linkbuttonlarge displayblock\"><i class=\"fa fa-file-import fa-lg fa-fw\"></i> ".pcrtlang("Import Sales")."</a>";
} else {
echo "<a href=\"dtrans.php?funct=importsales\" class=\"linkbuttongray linkbuttonlarge displayblock\"><i class=\"fa fa-file-import fa-lg fa-fw\"></i> ".pcrtlang("Import Sales")."</a>";
}

}

}

if($userledgertype == 1) {
echo "<a href=\"saccounts.php\" class=\"linkbuttongray linkbuttonlarge displayblock\"><i class=\"fa fa-money-check fa-lg fa-fw\"></i> ".pcrtlang("Accounts")."</a>";
} else {
echo "<a href=\"daccounts.php\" class=\"linkbuttongray linkbuttonlarge displayblock\"><i class=\"fa fa-money-check fa-lg fa-fw\"></i> ".pcrtlang("Accounts")."</a>";
}


echo "<a href=\"payees.php\" class=\"linkbuttongray linkbuttonlarge displayblock\"><i class=\"fa fa-list-alt fa-lg fa-fw\"></i> ".pcrtlang("Payees")."</a>";

if($userledgertype == 1) {
echo "<a href=\"sreports.php\" class=\"linkbuttongray linkbuttonlarge displayblock\"><i class=\"fa fa-money-check fa-lg fa-fw\"></i> ".pcrtlang("Reports")."</a>";
} else {
echo "<a href=\"dreports.php\" class=\"linkbuttongray linkbuttonlarge displayblock\"><i class=\"fa fa-money-check fa-lg fa-fw\"></i> ".pcrtlang("Reports")."</a>";
}


# End if no ledgers present
}


?>

<script type="text/javascript">
$(document).ready(function () {
                $.get('../repair/ajaxhelpers.php?func=refreshnotifications', function(data) {
                $('#notify').html(data);
                });
        setInterval(function() {
                $.get('../repair/ajaxhelpers.php?func=refreshnotifications', function(data) {
                $('#notify').html(data);
                });
        }, 60000);
});
</script>



</td>
        <td style="width:70%; vertical-align:top; background:#<?php echo $storeinfoarray['interfacecolor2']; ?>; padding:20px 40px 20px 20px;">
