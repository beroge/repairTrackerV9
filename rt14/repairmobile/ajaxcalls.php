<?php

/***************************************************************************
 *   copyright            : (C) 2014 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/


function loadwonotes($woid, $notetype) {

require("deps.php");
require_once("common.php");





$rs_findnotes = "SELECT * FROM wonotes WHERE woid = '$woid' AND notetype = '$notetype' ORDER BY notetime ASC";
$rs_result_n = mysqli_query($rs_connect, $rs_findnotes);
$bubblego = "first";
$usercomm = array();
while($rs_result_qn = mysqli_fetch_object($rs_result_n)) {
$thenote = parseforlinks(nl2br("$rs_result_qn->thenote"));
$noteuser = "$rs_result_qn->noteuser";
$notetype = "$rs_result_qn->notetype";
$noteid = "$rs_result_qn->noteid";
$notetime2 = "$rs_result_qn->notetime";

if ($notetype == 1) {
$switchnotetype = 0;
$thenotearea = "technotearea";
} else {
$switchnotetype = 1;
$thenotearea = "custnotearea";
}


$notetime = pcrtdate("$pcrt_time", "$notetime2")." ".pcrtdate("$pcrt_shortdate", "$notetime2");


echo "<table class=nostyle style=\"width:100%\"><tr><td colspan=3>";
echo "<strong>$noteuser</strong> ";
echo "&bull; $notetime";
echo "</td></tr><tr><td colspan=3>";
echo "$thenote";
echo "</td></tr><tr><td>";
echo "<button onClick=\"parent.location='pc.php?func=editnote&woid=$woid&noteid=$noteid'\"><i class=\"fa fa-edit fa-lg\"></i></button></td><td>";
echo "<form action=\"pc.php?func=deletenote&woid=$woid&noteid=$noteid&notetype=$notetype&ajaxcall=yes\" id=\"custnotedelete$noteid\" method=post>";



echo "<button type=submit><i class=\"fa fa-times fa-lg\"></i></button>";


echo "</form></td><td>";
echo "<button onClick=\"parent.location='pc.php?func=convertnote&woid=$woid&noteid=$noteid&notetype=$switchnotetype&touch=no'\"><i class=\"fa fa-exchange fa-lg\"></i></button>";
echo "</td></tr></table><br>";



?>
<script type='text/javascript'>
$(document).ready(function(){
$('#custnotedelete<?php echo "$noteid"; ?>').submit(function(e) { // catch the form's submit event
        e.preventDefault();
        	$.ajax({ // create an AJAX call...
		beforeSend: function(request) {
			if (confirm('<?php echo pcrtlang("Are you sure you wish to delete this..."); ?>')) {
			} else {
			return false;
			}		
		},
        	data: $(this).serialize(), // get the form data
        	type: $(this).attr('method'), // GET or POST
        	url: $(this).attr('action'), // the file to call
        	success: function(response) { // on success..
            	$('#<?php echo "$thenotearea"; ?>').html(response); // update the DIV
	}
    });
});
});

</script>
<?php




}

?>
<script>
$('#custnotearea').enhanceWithin('create');
$('#technotearea').enhanceWithin('create');
</script>
<?php

}

#####################################


function displaymessages($phonenumbers,$emails,$woid,$pickup,$dropoff) {

require("deps.php");
require_once("common.php");

$phnumbers = explode_list($phonenumbers);
$emailsexploded = explode_list_email($emails);

foreach ($phnumbers as $key=>&$value) {
    if (strlen($value) < 7) {
        unset($phnumbers[$key]);
    }
}

reset($phnumbers);

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');


if($pickup == "0000-00-00 00:00:00") {
$pickup2 =  date('Y-m-d H:i:s', (strtotime($currentdatetime) + 86400));
} else {
$pickup2 =  date('Y-m-d H:i:s', (strtotime($pickup) + 604800));
}

$dropoff2 =  date('Y-m-d H:i:s', (strtotime($dropoff) - 604800));

$numberstosearch = "";

foreach($phnumbers as $key => $val) {
$numberstosearch .= " OR  TRIM(REPLACE(REPLACE(messagefrom,'-',''),' ',''))  LIKE '%".substr("$val", -7)."'";
$numberstosearch .= " OR messagefrom LIKE '%".substr("$val", -7)."'";
}

if($woid != 0) {
$numberstosearch .= " OR woid = '$woid'";
}

foreach($emailsexploded as $key => $val) {
if (filter_var($val, FILTER_VALIDATE_EMAIL)) {
$numberstosearch .= " OR messagefrom = '$val'";
}
}

$rs_findmessages = "SELECT * FROM messages WHERE 1=2 $numberstosearch AND messagedatetime > '$dropoff2' AND messagedatetime < '$pickup2'
ORDER BY messagedatetime DESC";


$rs_result_n = mysqli_query($rs_connect, $rs_findmessages);

echo "<table class=standard>";

while($rs_result_qn = mysqli_fetch_object($rs_result_n)) {
$messageid = "$rs_result_qn->messageid";
$messagebody = "$rs_result_qn->messagebody";
$messagefrom = "$rs_result_qn->messagefrom";
$messagevia = "$rs_result_qn->messagevia";
$messagedatetime2 = "$rs_result_qn->messagedatetime";
$mediaurls = serializedarraytest("$rs_result_qn->mediaurls");

$imageatt = "";
foreach($mediaurls as $key => $val) {
$imageatt .= "<a href=\"$val\" class=\"assetpreview\"><img src=$val height=50 class=\"assetimage\"></a> ";
}

if($messagevia == "call") {
$viaicon = "<i class=\"fa fa-phone fa-lg\"></i>";
} elseif($messagevia == "sms") {
$viaicon = "<i class=\"fa fa-mobile fa-lg\"></i>";
} elseif($messagevia == "im") {
$viaicon = "<i class=\"fa fa-comment fa-lg\"></i>";
} elseif($messagevia == "email") {
$viaicon = "<i class=\"fa fa-envelope-o fa-lg\"></i>";
} else {
$viaicon = "";
}


$messagedatetime = pcrtdate("$pcrt_time", "$messagedatetime2")."<br>".pcrtdate("$pcrt_shortdate", "$messagedatetime2");

$messagedirection = "$rs_result_qn->messagedirection";
if($messagedirection == "in") {
echo "<tr><td><i class=\"fa fa-reply fa-lg colormeblue\"></i> $viaicon<span>$messagefrom</span> </td>";
echo "<td colspan=1><i class=\"fa fa-clock-o fa-lg\"></i> <span>$messagedatetime</span> </td><td></td></tr><tr>";
echo "<td colspan=2><i class=\"fa fa-comment fa-lg\"></i> <span>$messagebody</span> <br>$imageatt</td><td>";
if($messagevia == "call") {
echo "<a href=\"pc.php?func=deletemessage&woid=$woid&messageid=$messageid\" data-ajax=\"false\" class=\"ui-btn ui-corner-all ui-shadow ui-mini\" onClick=\"return confirm('".pcrtlang("Are you sure you wish to delete this message?")."');\"><i class=\"fa fa-trash fa-lg\"></i></a>";
}
echo "</td></tr>";
} elseif($messagedirection == "out") {
echo "<tr><td>$viaicon <i class=\"fa fa-share fa-lg\"></i> <span>$messagefrom</span> </td>";
echo "<td colspan=1><i class=\"fa fa-clock-o fa-lg\"></i> <span>$messagedatetime</span> </td><td></td></tr><tr>";
echo "<td colspan=2><i class=\"fa fa-comment fa-lg\"></i> <span>$messagebody</span> <br>$imageatt</td><td>";
if($messagevia == "call") {
echo "<a href=\"pc.php?func=deletemessage&woid=$woid&messageid=$messageid\" data-ajax=\"false\"  class=\"ui-btn ui-corner-all ui-shadow ui-mini\" onClick=\"return confirm('".pcrtlang("Are you sure you wish to delete this message?")."');\" ><i class=\"fa fa-trash fa-lg\"></i></a>";
}
echo "</td></tr>";
} else {
echo "<tr><td><i class=\"fa fa-user-md fa-lg\"></i> <span>$messagefrom</span> </td>";
echo "<td colspan=1><i class=\"fa fa-clock-o fa-lg\"></i> <span>$messagedatetime</span> </td><td></td></tr><tr>";
echo "<td colspan=2><i class=\"fa fa-comment fa-lg\"></i> <span>$messagebody</span> </td><td>";
if($messagevia == "call") {
echo "<a href=\"pc.php?func=deletemessage&woid=$woid&messageid=$messageid\" data-ajax=\"false\" class=\"ui-btn ui-corner-all ui-shadow ui-mini\" onClick=\"return confirm('".pcrtlang("Are you sure you wish to delete this message?")."');\" ><i class=\"fa fa-trash fa-lg\"></i></a>";
}
echo "</td></tr>";
}

}

echo "</table>";

}





?>
