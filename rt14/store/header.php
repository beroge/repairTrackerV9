<?php

/***************************************************************************
 *   copyright            : (C) 2021 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/

$startpagetime = microtime(true);

require_once("validate.php");
require_once("deps.php");
require_once("common.php");
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


<script type="text/javascript">

var persistmenu="yes" //"yes" or "no". Make sure each SPAN content contains an incrementing ID starting at 1 (id="sub1", id="sub2", etc)
var persisttype="sitewide" //enter "sitewide" for menu to persist across site, "local" for this page only

if (document.getElementById){ 
document.write('<style type="text/css">\n')
document.write('.submenu{display: none;}\n')
document.write('</style>\n')
}

function SwitchMenu(obj){
	if(document.getElementById){
	var el = document.getElementById(obj);
	var ar = document.getElementById("masterdiv").getElementsByTagName("span");
		if(el.style.display != "block"){ 
			for (var i=0; i<ar.length; i++){
				if (ar[i].className=="submenu")
				ar[i].style.display = "none";
			}
			el.style.display = "block";
		}else{
			el.style.display = "none";
		}
	}
}

function get_cookie(Name) { 
var search = Name + "="
var returnvalue = "";
if (document.cookie.length > 0) {
offset = document.cookie.indexOf(search)
if (offset != -1) { 
offset += search.length
end = document.cookie.indexOf(";", offset);
if (end == -1) end = document.cookie.length;
returnvalue=unescape(document.cookie.substring(offset, end))
}
}
return returnvalue;
}

function onloadfunction(){
if (persistmenu=="yes"){
var cookiename=(persisttype=="sitewide")? "switchmenu" : window.location.pathname
var cookievalue=get_cookie(cookiename)
if (cookievalue!="")
document.getElementById(cookievalue).style.display="block"
}
}

function savemenustate(){
var inc=1, blockid=""
while (document.getElementById("sub"+inc)){
if (document.getElementById("sub"+inc).style.display=="block"){
blockid="sub"+inc
break
}
inc++
}
var cookiename=(persisttype=="sitewide")? "switchmenu" : window.location.pathname
var cookievalue=(persisttype=="sitewide")? blockid+";path=/" : blockid
document.cookie=cookiename+"="+cookievalue+";SameSite=Strict"
}

if (window.addEventListener)
window.addEventListener("load", onloadfunction, false)
else if (window.attachEvent)
window.attachEvent("onload", onloadfunction)
else if (document.getElementById)
window.onload=onloadfunction

if (persistmenu=="yes" && document.getElementById)
window.onunload=savemenustate

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
<a href="../repair/pc.php?func=returnpc" class=notifybarlink><i class="fa fa-sign-in fa-lg"></i> <?php echo pcrtlang("Check-in"); ?></a><a href="../repair/pc.php?func=checkoutpc" class=notifybarlink><i class="fa fa-sign-out fa-lg"></i> <?php echo pcrtlang("Checkout"); ?></a><a href="../store/cart.php" class=notifybarlink><i class="fa fa-shopping-cart fa-lg"></i> <?php echo pcrtlang("Cart"); ?></a><a href="../store/reports.php" class=notifybarlink><i class="fa fa-line-chart fa-lg"></i><?php echo pcrtlang("Reports"); ?></a>
</td><td>
<form action=receipt.php?func=detailedsearch method=post><input type=text class=textbox autocomplete=off id=autosearchbox name=thesearch size=8 required=required onkeyup="window.scrollTo(0, 0)"><button class=button style="padding:6px;"><i class="fa fa-search"></i></button></form>

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
        $('div#autosearch').load('autosearch.php?func=possearch&search='+encoded).slideDown(200);
}, 300);
    }
  });
});
</script>

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


start_blue_box(pcrtlang("Inventory Lookup"));

echo "<form action=stock.php?func=show_stock_detail method=post>";
echo "<input type=text class=textbox style=\"width:160px;\" name=\"stockid\" placeholder=\"".pcrtlang("Enter Stock Id #")."\">";
echo "<button type=submit class=button><i class=\"fa fa-eye\"></i> ".pcrtlang("View")."</button></form>";


echo "<form action=stock.php?func=search_stock method=post>";
echo "<input type=text class=textbox style=\"width:160px;\" name=thesearch placeholder=\"".pcrtlang("Enter Item Description")."\">";
echo "<button type=submit class=button><i class=\"fa fa-search\"></i> ".pcrtlang("Search")."</button></form>";


stop_blue_box();

echo "<br>";

showmaincategories();

echo "<br><br>";

start_blue_box(pcrtlang("Quick Timers"));

echo "<form action=timer.php?func=timerstart method=post>";
echo "<input name=timername  style=\"width:160px;\"  class=textbox placeholder=\"".pcrtlang("Task Description")."\">";
echo "<button type=submit class=button><i class=\"fa fa-clock-o fa-lg\"></i> ".pcrtlang("Start Timer")."</button></form><br>";

function time_elapsed($secs){

    $bit = array(
        'y' => $secs / 31556926 % 12,
        'w' => $secs / 604800 % 52,
        'd' => $secs / 86400 % 7,
        'h' => $secs / 3600 % 24,
        'm' => $secs / 60 % 60,
        );

    foreach($bit as $k => $v)
        if($v > 0)$ret[] = $v . $k;

if(!isset($ret)) {
$ret[] = "0m";
}

    return join(' ', $ret);
    }


###

$rs_findtimers = "SELECT * FROM timers WHERE woid = '0' AND pcgroupid = '0' AND byuser = '$ipofpc' ORDER BY timerstart ASC";
$rs_result_t = mysqli_query($rs_connect, $rs_findtimers);
while($rs_result_qt = mysqli_fetch_object($rs_result_t)) {
$timername = "$rs_result_qt->timerdesc";
$timerstart = "$rs_result_qt->timerstart";
$timerstop = "$rs_result_qt->timerstop";
$timertotal = "$rs_result_qt->timertotal";
$timerid = "$rs_result_qt->timerid";
$billedout = "$rs_result_qt->billedout";
$timerbyuser = "$rs_result_qt->byuser";

$timerstart_2822 = date('r', strtotime("$timerstart"));

$timerstartdate2 = date('n-j-Y', strtotime($timerstart));
$timerstarttime2 = date('g:ia', strtotime($timerstart));
$timerstoptime2 = date('g:ia', strtotime($timerstop));


$startepoch = strtotime($timerstart);
$stopepoch = time();
$startseconds = $stopepoch - $startepoch;

if($timerstop == "0000-00-00 00:00:00") {
echo "<div class=timeritemactive><table style=\"width:100%\"><tr><td colspan=2><span class=boldme>$timername</span></td></tr>
<tr>
<td> <span class=boldme>".pcrtlang("Start Time").":</span> <span class=\"colormegreen boldme\">$timerstarttime2</span></td>
<td><span class=boldme>".pcrtlang("Time Elapsed").":</span> <span class=\"colormered boldme\"><i class=\"fa fa-spinner fa-lg fa-spin\"></i></span> ";

?>

<label id="<?php echo "$timerid"; ?>hours" class="colormered boldme">0</label><span class="colormered boldme">:</span><label id="<?php echo "$timerid"; ?>minutes" class="colormered boldme">00</label><span class="colormered boldme">:</span><label id="<?php echo "$timerid"; ?>seconds" class="colormered boldme">00</label>
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


echo "</td></tr>
<td><form action=timer.php?func=timereditprog&timerid=$timerid method=post><button type=submit class=button><i class=\"fa fa-edit\"></i> ".pcrtlang("Edit")."</button></form></td>
<td><form action=timer.php?func=timerstop&timerid=$timerid method=post><button type=submit class=ibutton><i class=\"fa fa-stop\"></i> ".pcrtlang("Stop")."</button></form></td>
</tr></table></div>";

} else {

$startstamp = strtotime("$timerstart");
$stopstamp = strtotime("$timerstop");

$elapsedtime = $stopstamp - $startstamp;
$elapsedhuman = time_elapsed($elapsedtime);

echo "<div class=timeritem><table style=\"width:100%\"><tr><td colspan=2 style=\"vertical-align:top;\"><span class=boldme>$timername:</span> <span class=boldme>$elapsedhuman</span></td>";
echo "<td>";

if($billedout == 0) {
echo "<form action=timer.php?func=timerbillfirst&timerid=$timerid&billtime=$elapsedtime method=post>
<input type=hidden name=timerdesc value=\"$timername\">
<input type=submit value=\"".pcrtlang("Bill Hours")."\" class=button></form>";

}

echo "</td></tr>
<tr>
<td colspan=3> ".pcrtlang("Start Time").": <span class=\"colormegreen boldme\">$timerstarttime2</span>
".pcrtlang("Stop Time").": <span class=\"colormered boldme\">$timerstoptime2</span></td></tr><tr>
<td><form action=timer.php?func=timerdelete&timerid=$timerid method=post><button type=submit class=ibutton style=\"padding:5px 2px;\"><i class=\"fa fa-times\"></i> ".pcrtlang("Delete")."</button></form></td>
<td><form action=timer.php?func=timeredit&timerid=$timerid method=post><button type=submit class=button style=\"padding:5px 2px;\"><i class=\"fa fa-edit\"></i> ".pcrtlang("Edit")."</button></form></td>
<td><form action=timer.php?func=timerstart method=post><input type=hidden name=timername value=\"$timername\"><button type=submit class=button style=\"padding:5px 2px;\"><i class=\"fa fa-clock-o\"></i> ".pcrtlang("Resume")."</button></form>
</td></tr></table></div>";

}

}



###


stop_blue_box();

echo "<br><br>";


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
        <td style="width:70%; vertical-align:top; background:#<?php echo $storeinfoarray['interfacecolor2']; ?>; padding:0px 20px 20px 20px;">
