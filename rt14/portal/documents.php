<?php
                                                                                                    
/***************************************************************************
 *   copyright            : (C) 2020 PCRepairTracker.com
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

                                                                                                    

function printform() {

require_once("deps.php");
require_once("common.php");
require_once("validate.php");

$documentid = $_REQUEST['documentid'];


$rs_dsql = "(SELECT DISTINCT(documents.documentid) AS documentid FROM documents,pc_owner,pc_group
WHERE pc_owner.pcgroupid = '$portalgroupid' AND pc_owner.pcid = documents.pcid  AND documents.showinportal = '1'
) UNION (
SELECT documents.documentid AS documentid FROM documents
WHERE documents.groupid = '$portalgroupid'
) UNION (
SELECT DISTINCT(documents.documentid) AS documentid FROM documents,servicecontracts,pc_group
WHERE pc_group.pcgroupid = '$portalgroupid' AND pc_group.pcgroupid = servicecontracts.groupid AND documents.scid = servicecontracts.scid  AND documents.showinportal = '1'
)
ORDER BY documentid ASC";

$rs_result1dsql = mysqli_query($rs_connect, $rs_dsql);
while ($rs_result_perm = mysqli_fetch_object($rs_result1dsql)) {
$formcheck[] = "$rs_result_perm->documentid";
}


if(!in_array("$documentid", $formcheck)) {
die("Access Denied");;
}




$rs_doctemp = "SELECT * FROM documents WHERE documentid = '$documentid'";
$rs_find_template = @mysqli_query($rs_connect, $rs_doctemp);
$rs_find_template_q = mysqli_fetch_object($rs_find_template);
$documentname = "$rs_find_template_q->documentname";
$template = "$rs_find_template_q->documenttemplate";
$template = serializedarraytest($template);
$thesig = "$rs_find_template_q->thesig";
$thesigtopaz = "$rs_find_template_q->thesigtopaz";
$signeddatetime2 = "$rs_find_template_q->signeddatetime";
$signeddatetime = pcrtdate("$pcrt_mediumdate", "$signeddatetime2")." ".pcrtdate("$pcrt_time", "$signeddatetime2");

$rs_qmultistore = "SELECT storeid FROM stores WHERE storedefault = '1'";
$rs_result_multistore = mysqli_query($rs_connect, $rs_qmultistore);
$rs_result_q1 = mysqli_fetch_object($rs_result_multistore);
$defaultstore = "$rs_result_q1->storeid";


printableheader("$documentname");

foreach($template as $key => $val) {



if($template[$key]['type'] == "heading") {
echo "<$val[textsize] style=\"color:$val[color];text-align:$val[alignment];padding:10px;\">$val[label]</$val[textsize]>\n\n";
}

if($template[$key]['type'] == "textarea") {
if (array_key_exists('content',$val)) {
$prefill = $val['content'];
} else {
$prefill = "$val[defaulttext]";
}
echo "<p style=\"color:$val[color];align:$val[alignment];font-size:$val[textsize]px;font-weight:$val[textweight];line-height:1.2;\">$prefill</p>";
}

if($template[$key]['type'] == "text") {
if (!array_key_exists('content',$val)) {
$val['content'] = "";
}
echo "<div style=\"color:$val[color];align:$val[alignment];font-size:$val[textsize]px;font-weight:$val[textweight];line-height:200%\">$val[label]: $val[content]</div>\n\n";
}

if($template[$key]['type'] == "logo") {
$storeinfoarray = getstoreinfo($defaultstore);
$businessinfo = "<span style=\"font-weight:bold\">$storeinfoarray[storename]</span><br>$storeinfoarray[storeaddy1]";
if ("$storeinfoarray[storeaddy2]" != "") {
$businessinfo .= "<br>$storeinfoarray[storeaddy2]";
}
$businessinfo .= "<br>$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]";
$businessinfo .= "<br>".pcrtlang("Phone").": $storeinfoarray[storephone]<br><br><br>";
if(($val['businessinfo'] == "on") && ($val['alignment'] == "left")) {
echo "<table style=\"width:100%\"><tr><td style=\"text-align:left;width:75%\"><img src=\"$logo\" style=\"height:$val[height]px\"></td><td style=\"text-align:right\">$businessinfo</td>
</tr></table>";
} elseif(($val['businessinfo'] == "on") && ($val['alignment'] == "center")) {
echo "<table style=\"width:100%;\"><tr><td style=\"text-align:center;\"><img src=\"$logo\" style=\"height:$val[height]px;\"></td></tr><tr><td style=\"text-align:center\">$businessinfo</td>
</tr></table>";
} elseif(($val['businessinfo'] == "on") && ($val['alignment'] == "right")) {
echo "<table style=\"width:100%\"><tr><td style=\"text-align:left;width:25%\">$businessinfo</td><td style=\"text-align:right\"><img src=\"$logo\" style=\"height:$val[height]px\"></td>
</tr></table>";
} else {
echo "<div style=\"text-align:$val[alignment]\"><img src=\"$logo\" style=\"height:$val[height]px\"></div>";
}
echo "\n\n";
}

if($template[$key]['type'] == "hr") {
echo "<hr style=\"border:$val[height]px solid $val[color]\">\n\n";
}

if($template[$key]['type'] == "list") {
echo "<div><span style=\"color:$val[color];font-size:$val[textsize]px;font-weight:$val[textweight];\">$val[label]</span><br>";
echo "<$val[listtype] style=\"color:$val[color];font-size:$val[textsize]px;font-weight:$val[textweight];\">";
if (array_key_exists('content',$val) && $val['content'] != "") {
foreach($val['content'] as $ckey => $cval) {
echo "<li>$cval</li>";
}
echo "</$val[listtype]></div>\n\n";
}
}

if($template[$key]['type'] == "select") {
echo "<div style=\"padding:5px 0px;\"><span style=\"color:$val[color];font-size:$val[textsize]px;font-weight:$val[textweight];\">$val[label]</span>: ";
if($val['selecttype'] == "dropdown") {
echo "<span style=\"color:$val[color];font-size:$val[textsize]px;font-weight:$val[textweight];\">".$val['selectoption'][$val['content']]."</span>";
} elseif ($val['selecttype'] == "radio") {
if (array_key_exists('content',$val) && !empty($val['content'])) {
$selectedradiooptions = $val['content'];
} else {
$selectedradiooptions = array();
}
foreach($template[$key]['selectoption'] as $skey => $sval) {
        if(in_array($skey, $selectedradiooptions)) {
                echo "<span style=\"color:$val[color];font-size:$val[textsize]px;font-weight:$val[textweight];\"><i class=\"far fa-dot-circle fa-lg\"></i> $sval &nbsp;&nbsp;</span>";
        } else {
                echo "<span style=\"color:$val[color];font-size:$val[textsize]px;font-weight:$val[textweight];\"><i class=\"far fa-circle fa-lg\"></i>  $sval &nbsp;&nbsp;</span>";
        }
}
} else {
foreach($template[$key]['selectoption'] as $skey => $sval) {
if (array_key_exists('content',$val) && !empty($val['content'])) {
$selectedcheckboxoptions = $val['content'];
} else {
$selectedcheckboxoptions = array();
}
        if(in_array($skey, $selectedcheckboxoptions)) {
                echo "<span style=\"color:$val[color];font-size:$val[textsize]px;font-weight:$val[textweight];\"><i class=\"far fa-check-square fa-lg\"></i> $sval &nbsp;&nbsp;</span>";
        } else {
                echo "<span style=\"color:$val[color];font-size:$val[textsize]px;font-weight:$val[textweight];\"><i class=\"far fa-square fa-lg\"></i> $sval &nbsp;&nbsp;</span>";
        }
}
}
echo "</div>\n\n";
}
#}

# Photos

$topkey = max(array_keys($template));

if($template[$key]['type'] == "photo") {
if(($val['alignment'] == "right") || ($val['alignment'] == "left") || ($val['alignment'] == "center")) {
echo "<div style=\"text-align:$val[alignment];\"><img src=\"documents.php?func=getdocphoto&docphotoid=$val[docphotoid]\" style=\"height:$val[height]px;\"></div>\n\n";
} elseif ($val['alignment'] == "floatright") {
echo "<span style=\"text-align:$val[alignment];float:right\"><img src=\"documents.php?func=getdocphoto&docphotoid=$val[docphotoid]\" style=\"height:$val[height]px;padding:10px;\">
</span>\n\n";
if($key == $topkey) {
echo "<div style=\"height:$val[height]px;\"></div>";
}
} else {
echo "<span style=\"text-align:$val[alignment];float:left\"><img src=\"documents.php?func=getdocphoto&docphotoid=$val[docphotoid]\" style=\"height:$val[height]px;padding:10px;\">
</span>\n\n";
if($key == $topkey) {
echo "<div style=\"height:$val[height]px;\"></div>";
}
}
}



#sig code

if($template[$key]['type'] == "signature") {
echo "<div style=\"padding:5px 0px;\"><span style=\"color:$val[color];font-size:$val[textsize]px;font-weight:$val[textweight];\">$val[label]</span>: <br>";

if($signeddatetime2 != "0000-00-00 00:00:00") {
echo "<br>$signeddatetime<br>";
}

if($enablesignaturepad_forms == "yes") {
if ($thesig == "") {
?>
  <form method="post" action="documents.php?func=savesig" class="sigPad"><input type=hidden name=documentid value=<?php echo $documentid; ?>><input type=hidden name=templatekey value=<?php echo $key; ?>>
    <p class="drawItDesc"><?php echo pcrtlang("Use Stylus to write your signature"); ?></p>
    <ul class="sigNav">
      <li class="clearButton"><a href="#clear"><?php echo pcrtlang("Clear Signature"); ?></a></li>
    </ul>
    <div class="sig sigWrapper">
      <div class="typed"></div>
      <canvas class="pad" width="446" height="75"></canvas>
      <input type="hidden" name="output" class="output">
    </div>
    <button type="submit" class=button><?php echo pcrtlang("I accept the terms of this agreement"); ?>.</button>
  </form>

  <script src="../repair/jq/signature/jquery.signaturepad.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.sigPad').signaturePad({drawOnly:true,lineTop:60});
    });
  </script>
  <script src="../repair/jq/signature/json2.min.js"></script>
<?php
} elseif ($thesig != "") {
#echo "<a href=documents.php?func=clearsig&documentid=$documentid class=hideprintedlink>(".pcrtlang("remove signature").")</a><br>";

?>

<div class="sigPad<?php echo $documentid; ?> signed">
  <div class="sigWrapper">
    <canvas class="pad" width="450" height="75"></canvas>
  </div>
</div>

<script>
$(document).ready(function () {
  $('.sigPad<?php echo $documentid; ?>').signaturePad({displayOnly:true}).regenerate(<?php echo $thesig ?>)
})
</script>
<?php

}
}




#start topaz

if($enablesignaturepad_forms == "topaz") {
if ($thesigtopaz == "") {
?>
<br>
<canvas id="cnv" name="cnv" width="500" height="100"></canvas>
<form action="documents.php?func=savesigtopaz" name=FORM1 method=post>
<input id="SignBtn" name="SignBtn" type="button" value="<?php echo pcrtlang("Activate Sig Pad"); ?>"  class=button onclick="javascript:onSign()"/>&nbsp;&nbsp;&nbsp;&nbsp;
<input id="button1" name="ClearBtn" type="button" class=button value="Clear" onclick="javascript:onClear()"/>&nbsp;&nbsp;&nbsp;&nbsp;
<input id="button2" name="DoneBtn" type="button" class=button value="Done" onclick="javascript:onDone()"/>&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" class=button value="Save">&nbsp;&nbsp;&nbsp;&nbsp
<INPUT TYPE=HIDDEN NAME="bioSigData">
<INPUT TYPE=HIDDEN NAME="sigImgData">
<input type=hidden name=documentid value=<?php echo $documentid; ?>>
<input type=hidden NAME="sigImageData" value="">
</form>

<?php

} else {
#echo "<br><a href=documents.php?func=clearsigtopaz&documentid=$documentid class=hideprintedlink>(".pcrtlang("remove signature").")</a><br>";
echo '<br><img src="data:image/png;base64,' . $thesigtopaz . '" />';
}
}
#end topaz


if(($enablesignaturepad_forms != "yes") && ($enablesignaturepad_forms != "topaz")) {

echo "<br><br><br>_____________________________________________________";

}



}
}

#sig code

printablefooter();


}



function savesig() {

require("deps.php");
require("common.php");

$output = pv($_REQUEST['output']);
$documentid = $_REQUEST['documentid'];
require_once("validate.php");

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

$updateform = "UPDATE documents SET thesig = '$output', signeddatetime = '$currentdatetime' WHERE documentid = '$documentid'";
@mysqli_query($rs_connect, $updateform);

header("Location: documents.php?func=printform&documentid=$documentid");

}


function clearsig() {

require("deps.php");
require("common.php");

$documentid = $_REQUEST['documentid'];

require_once("validate.php");

$updateform = "UPDATE documents SET thesig = '', signeddatetime = '0000-00-00 00:00:00' WHERE documentid = '$documentid'";
@mysqli_query($rs_connect, $updateform);

header("Location: documents.php?func=printform&documentid=$documentid");

}


function savesigtopaz() {


require("deps.php");
require("common.php");

$output = pv($_REQUEST['output']);
$documentid = $_REQUEST['documentid'];
require_once("validate.php");

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

$updateform = "UPDATE documents SET thesigtopaz = '$output', signeddatetime = '$currentdatetime'  WHERE documentid = '$documentid'";
@mysqli_query($rs_connect, $updateform);

header("Location: documents.php?func=printform&documentid=$documentid");

}



function clearsigtopaz() {

require("deps.php");
require("common.php");

$documentid = $_REQUEST['documentid'];

require_once("validate.php");

$updateform = "UPDATE documents SET thesigtopaz = '', signeddatetime = '0000-00-00 00:00:00' WHERE documentid = '$documentid'";
@mysqli_query($rs_connect, $updateform);

header("Location: documents.php?func=printform&documentid=$documentid");

}


function getdocphoto() {

require("deps.php");
require("common.php");

$docphotoid = $_REQUEST['docphotoid'];

$rs_findfileid = "SELECT docphotofilename FROM docphotos WHERE docphotoid = '$docphotoid'";
$rs_resultfid = mysqli_query($rs_connect, $rs_findfileid);
$rs_result_qfid = mysqli_fetch_object($rs_resultfid);
$photo_filename = "$rs_result_qfid->docphotofilename";


header("Content-Type: image/jpg; Content-Disposition: inline; filename=\"$photo_filename\"");
readfile("../attachments/$photo_filename");

}



switch($func) {
                                                                                                    
    default:
    nothing();
    break;
                                
 case "printform":
    printform();
    break;

 case "savesig":
    savesig();
    break;

 case "clearsig":
    clearsig();
    break;

 case "savesigtopaz":
    savesigtopaz();
    break;

 case "clearsigtopaz":
    clearsigtopaz();
    break;

 case "getdocphoto":
    getdocphoto();
    break;


}

?>
