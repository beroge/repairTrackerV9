<?php require("validate.php");
require("deps.php");
require_once("common.php");

$startpagetime = microtime(true);


?>
<!DOCTYPE html>

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<link rel="apple-touch-icon" sizes="57x57" href="favicon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="favicon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="favicon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="favicon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="favicon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="favicon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="favicon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="favicon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="favicon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
<link rel="manifest" href="favicon/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">


 <link href="jq/facebox.css" media="screen" rel="stylesheet" type="text/css" />
  <script src="jq/jquery.js" type="text/javascript"></script>
  <script src="jq/facebox.js" type="text/javascript"></script>
  <script type="text/javascript">
    jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        loadingImage : '../repair/jq/loading.gif',
        closeImage : '../repair/jq/closelabel.png'
      })
    })
  </script>

<script src="jq/howler.js"></script>
<script>
    var sound = new Howl({
      src: ['sounds/notify.ogg', 'sounds/notify.mp3']
    });
</script>

<script src="../repair/jq/select2.min.js"></script>
<link rel="stylesheet" href="../repair/jq/select2.min.css">

<?php

if (preg_match("/smssend/i", $_SERVER['REQUEST_URI'])) {
echo "<script src=\"jq/jquery.limit-1.2.js\" type=\"text/javascript\"></script>";
}


$storeinfoarray = getstoreinfo($defaultuserstore);


if (preg_match("/index/i", $_SERVER['REQUEST_URI'])) {


$rs_ql = "SELECT * FROM users WHERE username = '$ipofpc'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$touchrefresh = "$rs_result_q1->touchrefresh";

if ($touchrefresh > "10") {
echo "<meta http-equiv=\"refresh\" content=\"$touchrefresh;url=touch.php\">";

}

}

?>


<title><?php echo "$ipofpc | $sitename"; ?></title>

<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=ISO-8859-1">
<meta NAME="AUTHOR" CONTENT="Luke Stroven">

<?php
if(!isset($pcrt_stylesheet)) {
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\">";
} else {
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"$pcrt_stylesheet\">";
}
?>


<link rel="stylesheet" href="fa5/css/all.min.css">
<link rel="stylesheet" href="fa5/css/v4-shims.min.css">
<link rel="stylesheet" href="fa5/font-awesome-animation.min.css">


</head>

<body bgcolor="#FFFFFF" id=top>

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
<a href="../repair/pc.php?func=returnpc" class=notifybarlink><i class="fa fa-sign-in fa-lg"></i> <?php echo pcrtlang("Check-in"); ?></a><a href="../repair/pc.php?func=checkoutpc" class=notifybarlink><i class="fa fa-sign-out fa-lg"></i> <?php echo pcrtlang("Checkout"); ?></a><a href="../repair/touch.php" class=notifybarlink><i class="fa fa-tachometer fa-lg"></i> <?php echo pcrtlang("Dashboard"); ?></a><a href="../store/reports.php" class=notifybarlink><i class="fa fa-line-chart fa-lg"></i> <?php echo pcrtlang("Reports"); ?></a>
</td>
<td>
<form action=pc.php?func=showpc method=post onkeypress="return event.keyCode != 13;"><input type=text class=textbox name=pcid size=8 required=required autocomplete=off id=autosearchbox onkeyup="window.scrollTo(0, 0)"><button class=button style="padding:6px"><i class="fa fa-search"></i></button></form>
</td>
<td style="text-align:left;">

<?php
echo "<div id=notify>";
echo "</div>";

#wip

$rs_qlu = "SELECT * FROM employees WHERE linkeduser = '$ipofpc'";
$rs_resultlu = mysqli_query($rs_connect, $rs_qlu);

if($rs_resultlu) {
$lucount = mysqli_num_rows($rs_resultlu);
if($lucount == 1) {
$rs_result_lu = mysqli_fetch_object($rs_resultlu);
$eid = "$rs_result_lu->employeeid";
$cn = "$rs_result_lu->clocknumber";

$rs_find_punch_status = "SELECT * FROM punches WHERE employeeid = '$cn' ORDER BY punchin DESC LIMIT 1";
$punchchkq = mysqli_query($rs_connect, $rs_find_punch_status);
$totalpunches = mysqli_num_rows($punchchkq);
if($totalpunches == '0') {
$currentpunchstatus = "out";
} else {
$rs_result_q1 = mysqli_fetch_object($punchchkq);
$currentpunchstatus = "$rs_result_q1->punchstatus";
}

} else {
$currentpunchstatus = "unlinked";
}
} else {
$currentpunchstatus = "unlinked";
}

$punchstylearray = array("out" => "colormered faa-flash animated", "in" => "colormegreen", "unlinked" => "")


?>

</td><td style="padding:0px;width:200px;">
<ul id="navgo_rightnew">
<li><a class="primary_linkgo_rightnew" href="javascript:void(0)">
<i class="fa fa-user  <?php echo $punchstylearray[$currentpunchstatus]; ?>"></i> <?php echo $ipofpc; ?> </a><div class="dropdowngo_rightnew">
<?php
require_once("topnavmenuvertnew_right.php");
?>
</div></li></ul>

</td></tr></table>

</div>



<div id="autosearch"></div>
<script type="text/javascript">

$(document).ready(function(){
  var globalTimeout = null;
  $("input#autosearchbox").keyup(function(){
    if(this.value.length<3) {
      $("div#autosearch").slideUp(200,function(){
        return false;
      });
    }else{
           var encoded = encodeURIComponent(this.value);
  if (globalTimeout != null) {
    clearTimeout(globalTimeout);
  }
  globalTimeout = setTimeout(function() {
    globalTimeout = null;
        $('div#autosearch').load('autosearch.php?func=pc&search='+encoded).slideDown(200);
}, 300);
    }
  });
});
</script>


<table class=interface>
    <tr>
        <td style="width:30%;background:#<?php echo "$storeinfoarray[interfacecolor1]"; ?>; padding:50px 20px 20px 20px;"></td>
        <td style="width:70%;background:#<?php echo "$storeinfoarray[interfacecolor2]"; ?>; padding:50px 20px 20px 40px;"></td></tr>

    <tr>
        <td style="width:30%;background:#<?php echo "$storeinfoarray[interfacecolor1]"; ?>; padding:0px 20px 20px 20px;vertical-align:top;">

<?php
if (array_key_exists('fademessage',$_REQUEST)) {

if (array_key_exists('fademessagetype',$_REQUEST)) {
$fademessagetype = "$_REQUEST[fademessagetype]";
} else {
$fademessagetype = "notice";
}
echo "<div class=fademessagediv$fademessagetype>$_REQUEST[fademessage]</div>";

?>
<script type="text/javascript">

$(document).ready(function(){
   setTimeout(function(){
  $("div.fademessagediv<?php echo "$fademessagetype"; ?>").slideUp("10000", function () {
  $("div.fademessagediv<?php echo "$fademessagetype"; ?>").remove();
      });

}, 11000);
 });
</script>

<?php


}
?>


<script type="text/javascript">
$(document).ready(function () {
                $.get('ajaxhelpers.php?func=refreshnotifications', function(data) {
                $('#notify').html(data);
                });
        setInterval(function() {
                $.get('ajaxhelpers.php?func=refreshnotifications', function(data) {
                $('#notify').html(data);
                });
        }, 60000);
});
</script>


<script type="text/javascript">
$(document).ready(function () {
                $.get('srmenu.php', function(data) {
                $('#servicerequests').html(data);
                });
        setInterval(function() {
                $.get('srmenu.php', function(data) {
                $('#servicerequests').html(data);
                });
        }, 480000);
});
</script>
<div id="servicerequests" class="servicerequests"></div>


<script type="text/javascript">
$(document).ready(function () {
                $.get('sidemenu.php', function(data) {
                $('#sidemenu').html(data);
                });
	setInterval(function() {
  		$.get('sidemenu.php', function(data) {
    		$('#sidemenu').html(data);
  		});
	}, 120000);
});
</script>
<div id="sidemenu" class="sidemenu"></div>



</td>
        <td style="width:70%;height:700px;vertical-align:top; background:#<?php echo "$storeinfoarray[interfacecolor2]"; ?>; padding:20px 20px 20px 20px;">

<div class=mainworkorder id=mainworkorder>
