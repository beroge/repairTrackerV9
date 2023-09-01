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
echo "nothing";
}

function browsemessages() {

require("deps.php");
require_once("common.php");

require("header.php");

$userlist = "";
$userlistarray = array();
$rs_qu = "SELECT * FROM users";
$rs_result1 = mysqli_query($rs_connect, $rs_qu);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$userid = "$rs_result_q1->userid";
$uname = "$rs_result_q1->username";
$useremail = "$rs_result_q1->useremail";
$usermobile = "$rs_result_q1->usermobile";
$enabled = "$rs_result_q1->enabled";
if(($uname != "$ipofpc") && ($enabled == 1)) {
$userlist .= "$uname,";
}
$userlistarray[$userid] = "$uname";
}

$userlist = substr($userlist, 0, -1);

echo "<table style=\"width:100%\" class=pad10><tr><td style=\"width:60%;vertical-align:top;\">";

if (isset($_REQUEST['showthread'])) {

$threadtoshow = $_REQUEST['showthread'];

echo "<div id=threaddisplay></div>";

?>
<script type="text/javascript">
$(document).ready(function () {
                $.get('imessages.php?func=displaythread&threadtoshow=<?php echo "$threadtoshow"; ?>', function(data) {
                $('#threaddisplay').html(data);
                });
        window.threadTimer = setInterval(function() {
                $.get('imessages.php?func=displaythread&threadtoshow=<?php echo "$threadtoshow"; ?>', function(data) {
                $('#threaddisplay').html(data);
                });
        }, 10000);
});
</script>
<?php


echo "<form action=imessages.php?func=sendmessage method=post id=messageform>";
echo "<table style=\"width:100%\">";
echo "<tr><td style=\"width:30px;\">";
echo "<span id=livenotification style=\"color:#ffcd38\"> <i class=\"fa fa-bolt fa-lg fa-fw faa-flash animated\"></i></span>";
echo "<a href=\"javascript:void(0);\" id=livenotificationturnon class=\"linkbuttonmedium linkbuttongray radiusall colormegray\" style=\"display:none\"> <i class=\"fa fa-bolt fa-lg\"></i></a>";

?>
<script type="text/javascript">
$('#livenotificationturnon').click(function () {
                $('#livenotification').show();
                $('#livenotificationturnon').hide();
                $.get('imessages.php?func=displaythread&threadtoshow=<?php echo "$threadtoshow"; ?>', function(data) {
                $('#threaddisplay').html(data);
                });
        window.threadTimer = setInterval(function() {
                $.get('imessages.php?func=displaythread&threadtoshow=<?php echo "$threadtoshow"; ?>', function(data) {
                $('#threaddisplay').html(data);
                });
        }, 10000);
});
</script>
<?php


echo "</td><td><textarea class=textbox name=message style=\"width:100%;box-sizing:border-box\"></textarea><input type=hidden name=showthread value=\"$threadtoshow\"></td>";
echo "<td style=\"width:15%\"><button type=submit class=button><i class=\"fa fa-paper-plane fa-lg\"></i> ".pcrtlang("Send")."</button></td></tr>";
echo "</table>";
echo "</form>";

?>
<script type='text/javascript'>
$(document).ready(function(){
$('#messageform').submit(function(e) { // catch the form's submit event
        e.preventDefault();
        $.ajax({ // create an AJAX call...
        data: $(this).serialize(), // get the form data
        type: $(this).attr('method'), // GET or POST
        url: $(this).attr('action'), // the file to call
        success: function(response) { // on success..
                $.get('imessages.php?func=displaythread&threadtoshow=<?php echo "$threadtoshow"; ?>', function(data) {
                $('#threaddisplay').html(data);
                });
        $('#messageform').each (function(){
          this.reset();
        });
    }
    });
});
});
</script>

<?php



}
#end of thread display


echo "</td><td style=\"vertical-align:top;\">";

echo "<a href=\"javascript:void(0);\" class=\"linkbuttongray linkbuttonmedium radiusall\" style=\"display:block;border-radius:3px;\" id=newmessageadd>".pcrtlang("New Message")."
<i class=\"fa fa-chevron-down\" style=\"float:right\"></i></a>";

echo "<div id=newmessagebox style=\"display:none;box-sizing:border-box;\">";

echo "<form action=imessages.php?func=sendmessage method=post>";
echo "<table class=standard style=\"width:100%\">";
echo "<tr><td style=\"width:15%\">".pcrtlang("To")." </td><td><input id=\"myUsers\" type=text name=to value=\"$userlist\"></td></tr>";
echo "<tr><td style=\"width:15%\">".pcrtlang("Message")." </td><td><textarea class=textbox name=message style=\"width:100%;box-sizing:border-box\"></textarea></td></tr>";
echo "<tr><td style=\"width:15%\"></td><td><button type=submit class=button><i class=\"fa fa-paper-plane fa-lg\"></i> ".pcrtlang("Send")."</button></td></tr>";
echo "</table>";
echo "</form>";

echo "</div>";

?>
<script src="../repair/jq/selectize.js"></script>
<link rel="stylesheet" href="../repair/jq/selectize.css">

<script>
$('#myUsers').selectize({
    plugins: ['remove_button'],
    delimiter: ',',
    persist: false,
    create: false,
items: false,
});
</script>

<script type='text/javascript'>
$('#newmessageadd').click(function(){
  $('#newmessagebox').toggle('1000');
  $("i",this).toggleClass("fa-chevron-up fa-chevron-down");
});
</script>

<?php

echo "<br>";

echo "<div id=conversationlist></div>";

?>
<script type="text/javascript">
$(document).ready(function () {
                $.get('imessages.php?func=conversationlist<?php if (isset($_REQUEST['showthread'])) { echo "&showthread=$threadtoshow"; } ?>', function(data) {
                $('#conversationlist').html(data);
                });
        	setInterval(function() {
		$.get('imessages.php?func=conversationlist<?php if (isset($_REQUEST['showthread'])) { echo "&showthread=$threadtoshow"; } ?>', function(data) {
                $('#conversationlist').html(data);
                });
        }, 10000);
});
</script>
<?php




echo "</td></tr></table>";

require("footer.php");


}


function sendmessage() {
require_once("validate.php");
require("deps.php");
require("common.php");

$rs_qu = "SELECT * FROM users";
$rs_result1 = mysqli_query($rs_connect, $rs_qu);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$userid = "$rs_result_q1->userid";
$uname = "$rs_result_q1->username";
$userarray[$uname] = "$userid";
}


if(isset($_REQUEST['to'])) {
$to = $_REQUEST['to'];
$imessageinvolves = explode(',', $to);
$imessageinvolves[] = "$ipofpc";
$useridinvolves = array();
foreach($imessageinvolves as $key => $val) {
$useridinvolves[] = $userarray[$val];
}
$useridinvolves = implode_list_sorted($useridinvolves);
} else {
$useridinvolves = $_REQUEST['showthread'];
}


if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');


$imessage = pv($_REQUEST['message']);

$rs_del_message = "INSERT INTO imessages (imessageinvolves, imessagedate,imessagefrom,imessage) VALUES ('$useridinvolves','$currentdatetime','$ipofpc','$imessage')";
@mysqli_query($rs_connect, $rs_del_message);

header("Location: imessages.php?func=browsemessages&showthread=$useridinvolves");
}


function displaythread() {
require_once("validate.php");
require("deps.php");
require("common.php");

$threadtoshow = $_REQUEST['threadtoshow'];

if(array_key_exists('offset',$_REQUEST)) {
$offset = $_REQUEST['offset'];
} else {
$offset = 0;
}

$rs_qmlt = "SELECT imessage,imessagefrom,imessagedate FROM imessages WHERE imessageinvolves = '$threadtoshow'";
$rs_result1t = mysqli_query($rs_connect, $rs_qmlt);
$totalinthread = mysqli_num_rows($rs_result1t);


$offsetup = $offset + 5;
$offsetdown = $offset - 5;


echo "<table><tr><td style=\"vertical-align:top\">";

if($offsetup < $totalinthread) {
echo "<a href=\"javascript:void(0);\" id=scrollup class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-up fa-lg fa-fw\"></i></a><br><br>";
} else {
echo "<span class=\"linkbuttonmedium linkbuttongraydisabled radiusall\"><i class=\"fa fa-chevron-up fa-lg fa-fw\"></i></span><br><br>";
}

if($offset > 0) {
echo "<a href=\"javascript:void(0);\" id=scrolldown class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-down fa-lg fa-fw\"></i></a><br><br>";
} else {
echo "<span class=\"linkbuttonmedium linkbuttongraydisabled radiusall\"><i class=\"fa fa-chevron-down fa-lg fa-fw\"></i></span><br><br>";
}



if($offset != 0) {
#echo "<a href=\"imessages.php?func=browsemessages&showthread=$threadtoshow\" id=scrolldown class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-bolt fa-lg fa-fw\"></i></a>";
}

?>

<script type="text/javascript">
$(document).ready(function(){
$('#scrollup').click(function(){
		 clearInterval(threadTimer);
		$('#livenotification').hide();
                $('#livenotificationturnon').show();
                $.get('imessages.php?func=displaythread&threadtoshow=<?php echo "$threadtoshow"; ?>&offset=<?php echo "$offsetup"; ?>', function(data) {
                $('#threaddisplay').html(data);
		});
        });
});
</script>

<script type="text/javascript">
$(document).ready(function(){
$('#scrolldown').click(function(){
                $.get('imessages.php?func=displaythread&threadtoshow=<?php echo "$threadtoshow"; ?>&offset=<?php echo "$offsetdown"; ?>', function(data) {
                $('#threaddisplay').html(data);
                });
        });
});
</script>


<?php


echo "</td><td>";

$rs_qml = "SELECT imessage,imessagefrom,imessagedate FROM imessages WHERE imessageinvolves = '$threadtoshow' ORDER BY imessagedate DESC LIMIT $offset,5";

$threadbuild = "";


$rs_result1 = mysqli_query($rs_connect, $rs_qml);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$imessagefrom = "$rs_result_q1->imessagefrom";
$imessage = "$rs_result_q1->imessage";
$imessagedate = "$rs_result_q1->imessagedate";
$imessagefromfirst = ucfirst(substr("$imessagefrom", 0, 3));
$imessagedate = pcrtdate("$pcrt_mediumdate", "$imessagedate")." ".pcrtdate("$pcrt_time", "$imessagedate");
$threadbuildtemp = "";
if($imessagefrom != "$ipofpc") {
$threadbuildtemp .= "<table><tr><td><span style=\"background:#eeeeee;color:#888888;border-radius:30px/10px;font-size:20px;font-weight:bold;padding:10px;\">$imessagefromfirst</span></td><td>";
$threadbuildtemp .= "<div style=\"background:#eeeeee;border-radius:3px;padding:10px;\">$imessage<br><span class=sizemesmaller>$imessagedate</span></div></td></tr></table>";
} else {
$threadbuildtemp .= "<table><tr><td>";
$threadbuildtemp .= "<div style=\"background:#0090FF;color:#ffffff;border-radius:3px;padding:10px;margin-left:20px;text-align:right;\">$imessage<br><span class=sizemesmaller>$imessagedate</span></div></td>";
$threadbuildtemp .= "<td><span style=\"background:#0090FF;color:#b7e0ff;border-radius:30px/10px;font-size:20px;font-weight:bold;padding:10px;\">$imessagefromfirst</span></td></tr></table>";
}
$threadbuild = "$threadbuildtemp $threadbuild";
}

echo "$threadbuild";

echo "</td></tr></table>";


$rs_qu = "SELECT userid FROM users WHERE username = '$ipofpc'";
$rs_result1 = mysqli_query($rs_connect, $rs_qu);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$userid = "$rs_result_q1->userid";



$rs_qmmr = "SELECT imessagereadby,imessageid FROM imessages WHERE imessageinvolves = '$threadtoshow' ORDER BY imessagedate DESC LIMIT 100";
$rs_result1rb = mysqli_query($rs_connect, $rs_qmmr);
while($rs_result_q1rb = mysqli_fetch_object($rs_result1rb)) {
$imessageid = "$rs_result_q1rb->imessageid";
$imessagereadby = "$rs_result_q1rb->imessagereadby";

$imessagereadbycurrent = explode_list($imessagereadby);
if(!in_array($userid, $imessagereadbycurrent)) {
$imessagereadbycurrent[] = $userid;
$imessagereadbycurrentimploded = implode_list_sorted(array_unique(array_filter($imessagereadbycurrent)));
$updatereadby = "UPDATE imessages SET imessagereadby = '$imessagereadbycurrentimploded' WHERE imessageid = '$imessageid'";
mysqli_query($rs_connect, $updatereadby);
}
}


}



function conversationlist() {
require_once("validate.php");
require("deps.php");
require("common.php");


$userlist = "";
$userlistarray = array();
$rs_qu = "SELECT * FROM users";
$rs_result1 = mysqli_query($rs_connect, $rs_qu);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$userid = "$rs_result_q1->userid";
$uname = "$rs_result_q1->username";
$useremail = "$rs_result_q1->useremail";
$usermobile = "$rs_result_q1->usermobile";
$enabled = "$rs_result_q1->enabled";
if(($uname != "$ipofpc") && ($enabled == 1)) {
$userlist .= "$uname,";
}
$userlistarray[$userid] = "$uname";
}


$rs_qu = "SELECT userid FROM users WHERE username = '$ipofpc'";
$rs_result1qu = mysqli_query($rs_connect, $rs_qu);
$rs_result_q1qu = mysqli_fetch_object($rs_result1qu);
$currentuserid = "$rs_result_q1qu->userid";

#$rs_qm = "SELECT DISTINCT(imessageinvolves),imessage,imessagefrom,imessagereadby,MAX(imessagedate) AS imessagedate FROM imessages GROUP BY imessageinvolves ORDER BY imessagedate DESC LIMIT 20";

$rs_qm = "SELECT imessageinvolves,imessage,imessagefrom,imessagereadby,imessagedate FROM imessages WHERE imessagedate IN (SELECT MAX(imessagedate) FROM imessages GROUP BY imessageinvolves) ORDER BY imessagedate DESC LIMIT 20";


$rs_result1 = mysqli_query($rs_connect, $rs_qm);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$imessageinvolves = "$rs_result_q1->imessageinvolves";
$imessage = "$rs_result_q1->imessage";
$imessagedate = "$rs_result_q1->imessagedate";
$imessagereadby = "$rs_result_q1->imessagereadby";

$countunread = "SELECT imessageid FROM imessages WHERE imessageinvolves = '$imessageinvolves' AND imessagereadby NOT LIKE '%\_$currentuserid\_%'";
$rs_curesult = mysqli_query($rs_connect, $countunread);
$totalunreadinthread = mysqli_num_rows($rs_curesult);

if (preg_match("/_$currentuserid"."_/i", $imessageinvolves) || perm_check("37")) {
$useridinvolvesusernames = "";
$imessageinvolvesusernames = "";
$imessageinvolvesarray = explode_list($imessageinvolves);
foreach($imessageinvolvesarray as $key => $val) {
if($userlistarray[$val] != "$ipofpc") {
$useridinvolvesusernames .= $userlistarray[$val].", ";
} else {
if(perm_check("37")) {
$useridinvolvesusernames = pcrtlang("Me").", $useridinvolvesusernames";
}
}

}

$useridinvolvesusernames = substr($useridinvolvesusernames, 0, -2);

echo "<a href=\"imessages.php?func=browsemessages&showthread=$imessageinvolves\">";

if (isset($_REQUEST['showthread'])) {
$threadtoshowh = $_REQUEST['showthread'];
if("$imessageinvolves" == "$threadtoshowh") {
echo "<div class=badgeclickonwhite style=\"border: #0090FF 2px solid;\">";
} else {
echo "<div class=badgeclickonwhite>";
}
} else {
echo "<div class=badgeclickonwhite>";
}
echo "<table style=\"width:100%;\">";
echo "<tr><td style=\"width:25px\"><i class=\"fa fa-comment fa-2x\"></i>";
echo "</td><td>";

$imessagereadbyexploded = explode_list($imessagereadby);

if(!in_array($currentuserid, $imessagereadbyexploded)) {
echo "<span class=\"boldme sizemelarge\">$useridinvolvesusernames</span>";
} else {
echo "<span class=\"sizemelarge\">$useridinvolvesusernames</span>";
}

echo "<br>".elapsfriendly("$imessagedate");
echo "</td><td style=\"width:25px;\">";

if(!in_array($currentuserid, $imessagereadbyexploded)) {
echo "<span class=\"colormewhite sizemelarge boldme\" style=\"background:#ff0000;border-radius:3px;padding:3px;\">$totalunreadinthread</span>";
}

echo "</td></tr>";
echo "</table></div></a>";


}

}

}





switch($func) {
                                                                                                    
    default:
    browsemessages();
    break;
                                

case "browsemessages":
    browsemessages();
    break;

case "smssend2":
    smssend2();
    break;

case "sendmessage":
    sendmessage();
    break;

case "displaythread":
    displaythread();
    break;

case "conversationlist":
    conversationlist();
    break;

}

?>
