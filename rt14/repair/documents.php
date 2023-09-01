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

                                                                                                    

function listtemplates() {
require_once("deps.php");
require_once("common.php");
require("header.php");
require_once("validate.php");

perm_boot("40");

start_blue_box(pcrtlang("Form Templates"));

echo "<a href=../repair/admin.php class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-circle-left fa-lg\"></i> ".pcrtlang("Go Back to Settings")."</a><br><br>";

echo "<form action=\"documents.php?func=newtemplate\" method=post>";

echo "<input type=text class=textbox name=templatename placeholder=\"".pcrtlang("Enter Template Name")."\">";

echo "<button type=submit class=\"button\">
<i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Create New Template")."</button></form><br>";

echo "<table class=standard>";

$rs_finddoc = "SELECT * FROM doctemplates ORDER BY doctemplatename ASC";
$rs_finddoc2 = @mysqli_query($rs_connect, $rs_finddoc);
while ($rs_find_doc_q = mysqli_fetch_object($rs_finddoc2)) {
$doctemplateid = "$rs_find_doc_q->doctemplateid";
$doctemplatename = "$rs_find_doc_q->doctemplatename";
$doctemplatecreated = "$rs_find_doc_q->doctemplatecreated";

echo "<tr><td>$doctemplatename</td><td>$doctemplatecreated</td><td>";

echo "<a href=\"documents.php?func=edittemplate&doctemplateid=$doctemplateid\" class=\"linkbuttonsmall linkbuttongray radiusleft\">
<i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("edit")."</a>";

echo "<a href=\"documents.php?func=deletetemplate&doctemplateid=$doctemplateid\" class=\"linkbuttonsmall linkbuttongray radiusleft\"
  onClick=\"return confirm('".pcrtlang("Are you sure you want to delete this?")."')\"><i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("delete")."</a>";

echo "</td></tr>";


}
echo "</table>";
stop_blue_box();

start_blue_box(pcrtlang("Form Image Library"));

echo "<form action=documents.php?func=addphoto method=post enctype=\"multipart/form-data\">";
echo "<table width=100%>";
echo "<tr><td>".pcrtlang("Photo to Upload").":</td><td><input type=file name=photo>";
echo "</td></tr>";
echo "<tr><td>&nbsp;</td><td><input type=submit class=button value=\"".pcrtlang("Upload Photo")."\"></form></td></tr>";
echo "</table>";

echo "<div style=\"display:flex;flex-flow: row wrap;\">";
$rs_findimg = "SELECT * FROM docphotos WHERE docphotoarchived = '0'";
$rs_findimg2 = @mysqli_query($rs_connect, $rs_findimg);
while ($rs_find_img_q = mysqli_fetch_object($rs_findimg2)) {
$docphotofilename = "$rs_find_img_q->docphotofilename";
$docphotoid = "$rs_find_img_q->docphotoid";
echo "<span style=\"flex-wrap:wrap\">";
echo "<img src=\"documents.php?func=getdocphoto&docphotoid=$docphotoid\" class=assetimage style=\"height:100px;\"> ";
echo "<a href=\"documents.php?func=deletedocphoto&docphotoid=$docphotoid&docphotofilename=$docphotofilename\" 
class=\"linkbuttontiny linkbuttonred radiusall\" style=\"position:relative;right:30px;top:-100px;\"><i class=\"fa fa-times\"></i></a>";
echo "</span>";
}
echo "</div>";

stop_blue_box();

require_once("footer.php");
}


##########

function edittemplate() {

require_once("deps.php");
require_once("common.php");
require("header.php");
require_once("validate.php");

perm_boot("40");

$doctemplateid = $_REQUEST['doctemplateid'];


start_blue_box(pcrtlang("Edit Template"));

$rs_doctemp = "SELECT * FROM doctemplates WHERE doctemplateid = '$doctemplateid'";
$rs_find_template = @mysqli_query($rs_connect, $rs_doctemp);
$rs_find_template_q = mysqli_fetch_object($rs_find_template);
$template = "$rs_find_template_q->doctemplate";
$template = serializedarraytest($template);

#echo "<pre>";
#print_r($template);
#echo "</pre>";

echo "<center><button id=editbutton class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-down fa-lg\"></i> ".pcrtlang("Toggle Editing Buttons")."</button>";
echo "&nbsp;&nbsp;<a href=\"documents.php\" class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-list-alt fa-lg\"></i> ".pcrtlang("Template List")."</a>";
echo "</center><br><br>";

echo "<div style=\"background:#777777;padding:30px;\"><div style=\"width:700px;margin-left:auto;margin-right:auto;background:#ffffff; 
box-shadow: 10px 10px 8px #000000;padding:40px 20px 40px 20px;\">";

foreach($template as $key => $val) {


if($template[$key]['type'] == "heading") {
echo "<$val[textsize] style=\"color:$val[color];text-align:$val[alignment]\">$val[label]</$val[textsize]>\n\n";
}

if($template[$key]['type'] == "textarea") {
echo "<p style=\"color:$val[color];align:$val[alignment];font-size:$val[textsize]px;font-weight:$val[textweight]\">";
if($val['defaulttext'] == "") {
$words = 0;
while($words < 30) {
echo pcrtlang("Sample Text")." ";
$words++;
}
} else {
echo "$val[defaulttext]";
}
echo "</p>\n\n";
}

if($template[$key]['type'] == "text") {
echo "<div style=\"color:$val[color];align:$val[alignment];font-size:$val[textsize]px;font-weight:$val[textweight];line-height:200%\">$val[label]: ".pcrtlang("Sample Text")."</div>\n\n";
}

if($template[$key]['type'] == "logo") {
$storeinfoarray = getstoreinfo($defaultuserstore);
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
echo "<li>".pcrtlang("Item")." 1</li><li>".pcrtlang("Item")." 2</li><li>".pcrtlang("Item")." 3</li>";
echo "</$val[listtype]></div>\n\n";
}

if($template[$key]['type'] == "select") {
echo "<div style=\"padding:5px 0px;\"><span style=\"color:$val[color];font-size:$val[textsize]px;font-weight:$val[textweight];\">$val[label]</span><br>";
if($val['selecttype'] == "dropdown") {
echo "<select>";
foreach($template[$key]['selectoption'] as $skey => $sval) {
echo "<option>$sval</option>";
}
echo "</select>";
} elseif ($val['selecttype'] == "radio") {
foreach($template[$key]['selectoption'] as $skey => $sval) {
echo "<input type=radio name=same[]> $sval &nbsp;&nbsp;";
}
} else {
foreach($template[$key]['selectoption'] as $skey => $sval) {
echo "<input type=checkbox> $sval &nbsp;&nbsp;";
}
}
echo "</div>\n\n";
}

if($template[$key]['type'] == "signature") {
echo "<div><span style=\"color:$val[color];font-size:$val[textsize]px;font-weight:$val[textweight];\">$val[label]</span><br>";
echo "<i class=\"fa fa-signature fa-3x\"></i>";
echo "</div>\n\n";
}


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




$topkey = max(array_keys($template));

echo "<div class=hideable style=\"text-align:center;display:none;\">";
echo "<span class=\"linkbuttonsmall linkbuttongraylabel radiusleft\">";
if(in_array('floatleft', $val)) {
echo "<i class=\"fa fa-arrow-left fa-lg\"></i>";
} elseif(in_array('floatright', $val)) {
echo "<i class=\"fa fa-arrow-right fa-lg\"></i>";
} else {
echo "<i class=\"fa fa-arrow-up fa-lg\"></i>";
}


if($val['type'] == "text") {
echo " <i class=\"fa fa-pencil fa-lg\"></i>";
} elseif($val['type'] == "textarea") { 
echo " <i class=\"fa fa-paragraph fa-lg\"></i>";
} elseif($val['type'] == "logo") {
echo " <img src=$logo style=\"height:13px\">";
} elseif($val['type'] == "hr") {
echo " <i class=\"fa fa-minus fa-lg\"></i>";
} elseif($val['type'] == "select") {

if($val['selecttype'] == "radio") {
echo " <i class=\"fa fa-dot-circle fa-lg\"></i>";
} elseif($val['selecttype'] == "checkbox") {
echo " <i class=\"fa fa-check-square fa-lg\"></i>";
} else {
echo " <i class=\"fa fa-caret-square-down fa-lg\"></i>";
}

} elseif($val['type'] == "signature") {
echo " <i class=\"fa fa-signature fa-lg\"></i>";
} elseif($val['type'] == "photo") {
echo " <i class=\"fa fa-photo fa-lg\"></i>";
} elseif($val['type'] == "heading") {
echo " <i class=\"fa fa-heading fa-lg\"></i>";
} elseif($val['type'] == "list") {
echo " <i class=\"fa fa-list fa-lg\"></i>";
} else {
}

echo "</span>";

echo "<a href=\"documents.php?func=deleteline&key=$key&doctemplateid=$doctemplateid\" class=\"linkbuttonsmall linkbuttongray\" onClick=\"return confirm('".pcrtlang("Are you sure you want to delete this?")."')\">
<i class=\"fa fa-trash fa-lg\"></i> ".pcrtlang("delete")."</a>";
if($key > 0) {
echo "<a href=\"documents.php?func=moveline&key=$key&direction=up&doctemplateid=$doctemplateid\" class=\"linkbuttonsmall linkbuttongray\">
<i class=\"fa fa-chevron-up fa-lg\"></i> ".pcrtlang("up")."</a>";
}
if($key < $topkey) {
echo "<a href=\"documents.php?func=moveline&key=$key&direction=down&doctemplateid=$doctemplateid\" class=\"linkbuttonsmall linkbuttongray radiusright\">
<i class=\"fa fa-chevron-down fa-lg\"></i>".pcrtlang("down")."</a>";
}
echo "<br></div>\n\n";


}

echo "</div></div>";

?>
<script type='text/javascript'>
$('#editbutton').click(function(){
  $('.hideable').toggle('1000');
  $("i",this).toggleClass("fa-chevron-up fa-chevron-down");
});
</script>
<?php


echo "<br><br><table class=bigstandard><tr><th>";

echo "<i class=\"fa fa-plus fa-lg fa-fw\"></i> ".pcrtlang("Add to Template")."</th>";
echo "<th>";

echo "&nbsp;&nbsp;&nbsp;<a href=\"javascript:void(0);\" class=\"linkbuttontiny linkbuttongray radiusall\" id=logotoggle>
<img src=$logo style=\"height:18px\"></a> ";

echo "&nbsp;&nbsp;&nbsp;<a href=\"javascript:void(0);\" class=\"linkbuttontiny linkbuttongray radiusall\" id=headingtoggle>
<i class=\"fa fa-heading fa-2x\"></i></a> ";

echo "&nbsp;&nbsp;&nbsp;<a href=\"javascript:void(0);\" class=\"linkbuttontiny linkbuttongray radiusall\" id=texttoggle>
<i class=\"fa fa-pencil-alt fa-2x\"></i></a>";

echo "&nbsp;&nbsp;&nbsp;<a href=\"javascript:void(0);\" class=\"linkbuttontiny linkbuttongray radiusall\" id=textareatoggle>
<i class=\"fa fa-paragraph fa-2x\"></i></a>";

echo "&nbsp;&nbsp;&nbsp;<a href=\"javascript:void(0);\" class=\"linkbuttontiny linkbuttongray radiusall\" id=hrtoggle>
<i class=\"fa fa-minus fa-2x\"></i></a>";

echo "&nbsp;&nbsp;&nbsp;<a href=\"javascript:void(0);\" class=\"linkbuttontiny linkbuttongray radiusall\" id=listtoggle>
<i class=\"fa fa-clipboard-list fa-2x\"></i></a>";

echo "&nbsp;&nbsp;&nbsp;<a href=\"javascript:void(0);\" class=\"linkbuttontiny linkbuttongray radiusall\" id=selecttoggle>
<i class=\"fa fa-tasks fa-2x\"></i></a>";

echo "&nbsp;&nbsp;&nbsp;<a href=\"javascript:void(0);\" class=\"linkbuttontiny linkbuttongray radiusall\" id=phototoggle>
<i class=\"fa fa-photo fa-2x\"></i></a>";

if(!empty($template)) {
if(!in_array('signature', $template[$key])) {
echo "&nbsp;&nbsp;&nbsp;<a href=\"javascript:void(0);\" class=\"linkbuttontiny linkbuttongray radiusall\" id=sigtoggle>
<i class=\"fa fa-signature fa-2x\"></i></a>";
}
}

echo "</th>";
echo "</tr></table>";


echo "<div id=heading class=close style=\"display:none\"><form action=documents.php?func=savetemplate method=post><input type=hidden name=doctemplateid value=$doctemplateid><input type=hidden name=fieldtype value=heading>";
echo "<table>";
echo "<tr><td>".pcrtlang("Label Name").":</td><td><input type=text class=textbox name=label></td></tr>";
echo "<tr><td>".pcrtlang("Heading Size").":</td><td><select name=textsize><option value=h1>h1</option><option value=h2>h2</option>
<option value=h3>h3</option><option selected value=h4>h4</option><option value=h5>h5</option><option value=h6>h6</option></select></td></tr>";
echo "<tr><td>".pcrtlang("Text Color").":</td><td><input type=color name=color size=6 value=\"#000000\"></td></tr>";
echo "<tr><td>".pcrtlang("Alignment").":</td><td><select name=alignment><option value=left>".pcrtlang("Left")."</option>
<option value=center>".pcrtlang("Center")."</option><option value=right>".pcrtlang("Right")."</option></td></tr>";
echo "<tr><td></td><td><input type=submit class=button value=\"".pcrtlang("Add Heading")."\"></td></tr>";
echo "</table></form></div>";


echo "<div id=textarea class=close style=\"display:none\"><form action=documents.php?func=savetemplate method=post><input type=hidden name=doctemplateid value=$doctemplateid>
<input type=hidden name=fieldtype value=textarea>";
echo "<table>";
echo "<tr><td>".pcrtlang("Label Name").":</td><td><input type=text class=textbox name=label></td></tr>";
echo "<tr><td>".pcrtlang("Text Size").":</td><td><select name=textsize><option value=10>10px</option><option value=12>12px</option>
<option selected value=14>14px</option><option value=16>16px</option><option value=20>20px</option><option value=24>24px</option></select></td></tr>";
echo "<tr><td>".pcrtlang("Text Weight").":</td><td><select name=textweight><option value=normal>normal</option><option value=bold>".pcrtlang("bold")."</option></select></td></tr>";
echo "<tr><td>".pcrtlang("Text Color").":</td><td><input type=color name=color size=6 value=\"#000000\"></td></tr>";
echo "<tr><td>".pcrtlang("Alignment").":</td><td><select name=alignment><option value=left>".pcrtlang("Left")."</option>
<option value=center>".pcrtlang("Center")."</option><option value=right>".pcrtlang("Right")."</option></td></tr>";
echo "<tr><td>".pcrtlang("Default Text").":</td><td><textarea class=textbox name=defaulttext style=\"width:600px;height:300px;\"></textarea></td></tr>";
echo "<tr><td>".pcrtlang("Editing Locked?").":</td><td><input type=checkbox name=editinglocked></td></tr>";

echo "<tr><td></td><td><input type=submit class=button value=\"".pcrtlang("Add Textbox")."\"></td></tr>";
echo "</table></form></div>";

echo "<div id=text class=close style=\"display:none\"><form action=documents.php?func=savetemplate method=post><input type=hidden name=doctemplateid value=$doctemplateid>
<input type=hidden name=fieldtype value=text>";
echo "<table>";
echo "<tr><td>".pcrtlang("Label Name").":</td><td><input type=text class=textbox name=label></td></tr>";
echo "<tr><td>".pcrtlang("Text Size").":</td><td><select name=textsize><option value=10>10px</option><option value=12>12px</option>
<option selected value=14>14px</option><option value=16>16px</option><option value=20>20px</option><option value=24>24px</option></select></td></tr>";
echo "<tr><td>".pcrtlang("Text Weight").":</td><td><select name=textweight><option value=normal>normal</option><option value=bold>".pcrtlang("bold")."</option></select></td></tr>";
echo "<tr><td>".pcrtlang("Text Color").":</td><td><input type=color name=color size=6 value=\"#000000\"></td></tr>";
echo "<tr><td>".pcrtlang("Alignment").":</td><td><select name=alignment><option value=left>".pcrtlang("Left")."</option>
<option value=center>".pcrtlang("Center")."</option><option value=right>".pcrtlang("Right")."</option></td></tr>";
echo "<tr><td></td><td><input type=submit class=button value=\"".pcrtlang("Add Text Field")."\"></td></tr>";
echo "</table></form></div>";

echo "<div id=logo class=close style=\"display:none\"><form action=documents.php?func=savetemplate method=post><input type=hidden name=doctemplateid value=$doctemplateid>
<input type=hidden name=fieldtype value=logo>";
echo "<table>";
echo "<tr><td>".pcrtlang("Logo Height").":</td><td><select name=height><option value=50>50px</option><option value=75>75px</option><option value=100>100px</option>
<option value=125>125px</option><option selected value=150>150px</option><option value=175>175px</option><option value=200>200px</option><option value=250>250px</option></select></td></tr>";
echo "<tr><td>".pcrtlang("Alignment").":</td><td><select name=alignment><option value=left>".pcrtlang("Left")."</option>
<option value=center>".pcrtlang("Center")."</option><option value=right>".pcrtlang("Right")."</option></td></tr>";
echo "<tr><td>".pcrtlang("Include Business Contact Info").":</td><td><input type=checkbox name=businessinfo></td></tr>";
echo "<tr><td></td><td><input type=submit class=button value=\"".pcrtlang("Add Business Logo")."\"></td></tr>";
echo "</table></form></div>";

echo "<div id=hr class=close style=\"display:none\"><form action=documents.php?func=savetemplate method=post><input type=hidden name=doctemplateid value=$doctemplateid>
<input type=hidden name=fieldtype value=hr>";
echo "<table>";
echo "<tr><td>".pcrtlang("Divider Height").":</td><td><select name=height><option value=1>1px</option><option selected value=2>2px</option><option value=3>3px</option>
<option value=5>5px</option><option value=10>10px</option><option value=15>15px</option><option value=20>20px</option><option value=30>30px</option></select></td></tr>";
echo "<tr><td>".pcrtlang("Color").":</td><td><input type=color name=color size=6 value=\"#777777\"></td></tr>";
echo "<tr><td></td><td><input type=submit class=button value=\"".pcrtlang("Add Divider")."\"></td></tr>";
echo "</table></form></div>";

echo "<div id=list class=close style=\"display:none\"><form action=documents.php?func=savetemplate method=post><input type=hidden name=doctemplateid value=$doctemplateid>
<input type=hidden name=fieldtype value=list>";
echo "<table>";
echo "<tr><td>".pcrtlang("Label Name").":</td><td><input type=text class=textbox name=label></td></tr>";
echo "<tr><td>".pcrtlang("Text Size").":</td><td><select name=textsize><option value=10>10px</option><option value=12>12px</option>
<option selected value=14>14px</option><option value=16>16px</option><option value=20>20px</option><option value=24>24px</option></select></td></tr>";
echo "<tr><td>".pcrtlang("Text Weight").":</td><td><select name=textweight><option value=normal>normal</option><option value=bold>".pcrtlang("bold")."</option></select></td></tr>";
echo "<tr><td>".pcrtlang("Text Color").":</td><td><input type=color name=color size=6 value=\"#000000\"></td></tr>";
echo "<tr><td>".pcrtlang("List Type").":</td><td><select name=listtype><option value=ul>".pcrtlang("Un-Ordered List")."</option>
<option value=ol>".pcrtlang("Ordered List")."</option></td></tr>";
echo "<tr><td></td><td><input type=submit class=button value=\"".pcrtlang("Add List")."\"></td></tr>";
echo "</table></form></div>";

echo "<div id=select class=close style=\"display:none\"><form action=documents.php?func=savetemplate method=post><input type=hidden name=doctemplateid value=$doctemplateid>
<input type=hidden name=fieldtype value=select>";
echo "<table>";
echo "<tr><td>".pcrtlang("Label Name").":</td><td><input type=text class=textbox name=label></td></tr>";
echo "<tr><td>".pcrtlang("Text Size").":</td><td><select name=textsize><option value=10>10px</option><option value=12>12px</option>
<option selected value=14>14px</option><option value=16>16px</option><option value=20>20px</option><option value=24>24px</option></select></td></tr>";
echo "<tr><td>".pcrtlang("Text Weight").":</td><td><select name=textweight><option value=normal>normal</option><option value=bold>".pcrtlang("bold")."</option></select></td></tr>";
echo "<tr><td>".pcrtlang("Text Color").":</td><td><input type=color name=color size=6 value=\"#000000\"></td></tr>";
echo "<tr><td>".pcrtlang("Select Type").":</td><td><select name=selecttype><option value=dropdown>".pcrtlang("Dropdown List")."</option>
<option value=radio>".pcrtlang("Radio Button List")."</option><option value=checkbox>".pcrtlang("Checkbox List")."</option></td></tr>";

echo "<tr><td colspan=2><table class=standard id=selectlist><tr><th>".pcrtlang("Options")."</th><th>
<a id=\"add\" href=\"javascript:void(0)\" class=\"linkbuttongray linkbuttonmedium radiusall floatright\"><i class=\"fa fa-plus\"></i></a></th></tr>";
echo "<tr class=asset><td colspan=2><input size=35 class=textbox type=text name=selectoption[]></td></tr>";
?>
<script type="text/javascript">
    $(document).ready(function() {
        $("#add").click(function() {
          $('#selectlist tbody>tr:last').clone(true).insertAfter('#selectlist tbody>tr:last');
          return false;
        });
    });
</script>
<?php
echo "</table>";
echo "</td></tr>";

echo "<tr><td></td><td><input type=submit class=button value=\"".pcrtlang("Add List")."\"></td></tr>";
echo "</table></form></div>";



echo "<div id=sig class=close style=\"display:none\"><form action=documents.php?func=savetemplate method=post><input type=hidden name=doctemplateid value=$doctemplateid>
<input type=hidden name=fieldtype value=signature>";
echo "<table>";
echo "<tr><td>".pcrtlang("Label Name").":</td><td><input type=text class=textbox name=label></td></tr>";
echo "<tr><td>".pcrtlang("Text Size").":</td><td><select name=textsize><option value=10>10px</option><option value=12>12px</option>
<option selected value=14>14px</option><option value=16>16px</option><option value=20>20px</option><option value=24>24px</option></select></td></tr>";
echo "<tr><td>".pcrtlang("Text Weight").":</td><td><select name=textweight><option value=normal>normal</option><option value=bold>".pcrtlang("bold")."</option></select></td></tr>";
echo "<tr><td>".pcrtlang("Text Color").":</td><td><input type=color name=color size=6 value=\"#000000\"></td></tr>";
echo "<tr><td></td><td><input type=submit class=button value=\"".pcrtlang("Add Signature Box")."\"></td></tr>";
echo "</table></form></div>";

echo "<div id=photo class=close style=\"display:none\"><form action=documents.php?func=savetemplate method=post><input type=hidden name=doctemplateid value=$doctemplateid>
<input type=hidden name=fieldtype value=photo>";
echo "<table>";
echo "<tr><td>".pcrtlang("Alignment").":</td><td><select name=alignment><option value=left>".pcrtlang("Left")."</option>
<option value=center>".pcrtlang("Center")."</option><option value=right>".pcrtlang("Right")."</option><option value=floatleft>".pcrtlang("Float Left")."</option><option value=floatright>".pcrtlang("Float Right")."</option></td></tr>";
echo "<tr><td>".pcrtlang("Image Height").":</td><td><select name=height><option value=25>25px</option><option selected value=50>50px</option><option value=75>75px</option>
<option value=100>100px</option><option value=125>125px</option><option value=150>150px</option><option value=175>175px</option><option value=200>200px</option><option value=225>225px</option><option value=250>250px</option><option value=275>275px</option><option value=300>300px</option><option value=350>350px</option><option value=400>400px</option></select></td></tr>";
echo "</table>";
echo "<div style=\"display:flex;flex-flow: row wrap;\">";
$rs_findimg = "SELECT * FROM docphotos WHERE docphotoarchived = '0'";
$rs_findimg2 = @mysqli_query($rs_connect, $rs_findimg);
while ($rs_find_img_q = mysqli_fetch_object($rs_findimg2)) {
$docphotofilename = "$rs_find_img_q->docphotofilename";
$docphotoid = "$rs_find_img_q->docphotoid";
echo "<span style=\"flex-wrap:wrap\">";
echo "<label for=$docphotoid><img src=\"documents.php?func=getdocphoto&docphotoid=$docphotoid\" class=assetimage style=\"height:50px;\"></label>";
echo "<input type=radio value=$docphotoid name=docphotoid id=$docphotoid style=\"position:relative;right:20px;top:-52px;\">";
echo "</span>";
}
echo "</div>";
echo "<br><input type=submit class=button value=\"".pcrtlang("Add Photo")."\">";
echo "</form></div>";


?>

<script type='text/javascript'>
$('#logotoggle').click(function(){
  $('.close').hide('1000');
  $('#logo').toggle('1000');
});

$('#headingtoggle').click(function(){
  $('.close').hide('1000');
  $('#heading').toggle('1000');
});

$('#texttoggle').click(function(){
  $('.close').hide('1000');
  $('#text').toggle('1000');
});

$('#textareatoggle').click(function(){
  $('.close').hide('1000');
  $('#textarea').toggle('1000');
});

$('#hrtoggle').click(function(){
  $('.close').hide('1000');
  $('#hr').toggle('1000');
});

$('#listtoggle').click(function(){
  $('.close').hide('1000');
  $('#list').toggle('1000');
});

$('#selecttoggle').click(function(){
  $('.close').hide('1000');
  $('#select').toggle('1000');
});

$('#sigtoggle').click(function(){
  $('.close').hide('1000');
  $('#sig').toggle('1000');
});

$('#phototoggle').click(function(){
  $('.close').hide('1000');
  $('#photo').toggle('1000');
});


</script>
<?php


stop_blue_box();
require_once("footer.php");


}


function savetemplate() {
require_once("validate.php");
require("deps.php");
require("common.php");

perm_boot("40");

$doctemplateid = $_REQUEST['doctemplateid'];
$fieldtype = $_REQUEST['fieldtype'];

#print_r($_REQUEST);
#die();

$rs_doctemp = "SELECT * FROM doctemplates WHERE doctemplateid = '$doctemplateid'";
$rs_find_template = @mysqli_query($rs_connect, $rs_doctemp);

$rs_find_template_q = mysqli_fetch_object($rs_find_template);
$templateindb = "$rs_find_template_q->doctemplate";

$template = serializedarraytest($templateindb);

$nextkey = max(array_keys($template)) + 1;

if($fieldtype == "heading") {
$textsize = $_REQUEST['textsize'];
$color = $_REQUEST['color'];
$label = $_REQUEST['label'];
$alignment = $_REQUEST['alignment'];
$template[$nextkey][type] = "heading"; 
$template[$nextkey][textsize] = "$textsize";
$template[$nextkey][color] = "$color";
$template[$nextkey][alignment] = "$alignment";
$template[$nextkey][label] = "$label";
}

if($fieldtype == "textarea") {
$textweight = $_REQUEST['textweight'];
$textsize = $_REQUEST['textsize'];
$color = $_REQUEST['color'];
$label = $_REQUEST['label'];
$alignment = $_REQUEST['alignment'];
$defaulttext = $_REQUEST['defaulttext'];
$template[$nextkey][type] = "textarea";
$template[$nextkey][textweight] = "$textweight";
$template[$nextkey][textsize] = "$textsize";
$template[$nextkey][color] = "$color";
$template[$nextkey][alignment] = "$alignment";
$template[$nextkey][label] = "$label";
$template[$nextkey][defaulttext] = "$defaulttext";
if(array_key_exists('editinglocked', $_REQUEST)) {
$template[$nextkey][editinglocked] = "yes";
} else {
$template[$nextkey][editinglocked] = "no";
}
}

if($fieldtype == "text") {
$textweight = $_REQUEST['textweight'];
$textsize = $_REQUEST['textsize'];
$color = $_REQUEST['color'];
$label = $_REQUEST['label'];
$alignment = $_REQUEST['alignment'];
$template[$nextkey][type] = "text";
$template[$nextkey][textweight] = "$textweight";
$template[$nextkey][textsize] = "$textsize";
$template[$nextkey][color] = "$color";
$template[$nextkey][alignment] = "$alignment";
$template[$nextkey][label] = "$label";
}

if($fieldtype == "logo") {
$height = $_REQUEST['height'];
$alignment = $_REQUEST['alignment'];
$businessinfo = $_REQUEST['businessinfo'];
$template[$nextkey][type] = "logo";
$template[$nextkey][height] = "$height";
$template[$nextkey][alignment] = "$alignment";
$template[$nextkey][businessinfo] = "$businessinfo";
}

if($fieldtype == "hr") {
$height = $_REQUEST['height'];
$color = $_REQUEST['color'];
$template[$nextkey][type] = "hr";
$template[$nextkey][height] = "$height";
$template[$nextkey][color] = "$color";
}

if($fieldtype == "list") {
$textweight = $_REQUEST['textweight'];
$textsize = $_REQUEST['textsize'];
$color = $_REQUEST['color'];
$label = $_REQUEST['label'];
$listtype = $_REQUEST['listtype'];
$template[$nextkey][type] = "list";
$template[$nextkey][textweight] = "$textweight";
$template[$nextkey][textsize] = "$textsize";
$template[$nextkey][color] = "$color";
$template[$nextkey][listtype] = "$listtype";
$template[$nextkey][label] = "$label";
}

if($fieldtype == "select") {
$textweight = $_REQUEST['textweight'];
$textsize = $_REQUEST['textsize'];
$color = $_REQUEST['color'];
$label = $_REQUEST['label'];
$selecttype = $_REQUEST['selecttype'];
$selectoption = $_REQUEST['selectoption'];
$template[$nextkey][type] = "select";
$template[$nextkey][textweight] = "$textweight";
$template[$nextkey][textsize] = "$textsize";
$template[$nextkey][color] = "$color";
$template[$nextkey][selecttype] = "$selecttype";
$template[$nextkey][selectoption] = $selectoption;
$template[$nextkey][label] = "$label";
}

if($fieldtype == "signature") {
$label = $_REQUEST['label'];
$textweight = $_REQUEST['textweight'];
$textsize = $_REQUEST['textsize'];
$color = $_REQUEST['color'];
$template[$nextkey][textweight] = "$textweight";
$template[$nextkey][textsize] = "$textsize";
$template[$nextkey][color] = "$color";
$template[$nextkey][type] = "signature";
$template[$nextkey][label] = "$label";
}

if($fieldtype == "photo") {
$alignment = $_REQUEST['alignment'];
$height = $_REQUEST['height'];
$docphotoid = $_REQUEST['docphotoid'];
$template[$nextkey][type] = "photo";
$template[$nextkey][docphotoid] = "$docphotoid";
$template[$nextkey][alignment] = "$alignment";
$template[$nextkey][height] = "$height";
}



$template = serialize($template);
$rs_insert_field = "UPDATE doctemplates SET doctemplate = '$template' WHERE doctemplateid = '$doctemplateid'";
@mysqli_query($rs_connect, $rs_insert_field);

header("Location: documents.php?func=edittemplate&doctemplateid=$doctemplateid");

}



function moveline() {
require_once("validate.php");
require("deps.php");
require("common.php");

perm_boot("40");

$doctemplateid = $_REQUEST['doctemplateid'];
$key = $_REQUEST['key'];
$direction = $_REQUEST['direction'];

$rs_doctemp = "SELECT * FROM doctemplates WHERE doctemplateid = '$doctemplateid'";
$rs_find_template = @mysqli_query($rs_connect, $rs_doctemp);

$rs_find_template_q = mysqli_fetch_object($rs_find_template);
$templateindb = "$rs_find_template_q->doctemplate";

$template = serializedarraytest($templateindb);

# new key > old key
if($direction == "up") {
$keyup = $key - 1;
$template[123456789] = $template[$key];
unset($template[$key]);
$template[$key] = $template[$keyup];
unset($template[$keyup]);
$template[$keyup] = $template[123456789];
unset($template[123456789]);
} else {
$keyup = $key + 1;
$template[123456789] = $template[$key];
unset($template[$key]);
$template[$key] = $template[$keyup];
unset($template[$keyup]);
$template[$keyup] = $template[123456789];
unset($template[123456789]);
}


ksort($template);

$template = serialize(array_values($template));
$rs_insert_field = "UPDATE doctemplates SET doctemplate = '$template' WHERE doctemplateid = '$doctemplateid'";
@mysqli_query($rs_connect, $rs_insert_field);

header("Location: documents.php?func=edittemplate&doctemplateid=$doctemplateid");

}


function deleteline() {
require_once("validate.php");
require("deps.php");
require("common.php");

perm_boot("40");

$doctemplateid = $_REQUEST['doctemplateid'];
$key = $_REQUEST['key'];
$direction = $_REQUEST['direction'];

$rs_doctemp = "SELECT * FROM doctemplates WHERE doctemplateid = '$doctemplateid'";
$rs_find_template = @mysqli_query($rs_connect, $rs_doctemp);

$rs_find_template_q = mysqli_fetch_object($rs_find_template);
$templateindb = "$rs_find_template_q->doctemplate";

$template = serializedarraytest($templateindb);

unset($template[$key]);

$template = serialize(array_values($template));
$rs_insert_field = "UPDATE doctemplates SET doctemplate = '$template' WHERE doctemplateid = '$doctemplateid'";
@mysqli_query($rs_connect, $rs_insert_field);

header("Location: documents.php?func=edittemplate&doctemplateid=$doctemplateid");
}


function newtemplate() {
require_once("validate.php");
require("deps.php");
require("common.php");

perm_boot("40");

$templatename = $_REQUEST['templatename'];

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

$rs_insert_template = "INSERT INTO doctemplates (doctemplatename, doctemplatecreated) VALUES ('$templatename','$currentdatetime')";
@mysqli_query($rs_connect, $rs_insert_template);

$lastinsert = mysqli_insert_id($rs_connect);

header("Location: documents.php?func=edittemplate&doctemplateid=$lastinsert");

}


function deletetemplate() {
require_once("validate.php");
require("deps.php");
require("common.php");

perm_boot("40");

$doctemplateid = $_REQUEST['doctemplateid'];

$rs_insert_template = "DELETE FROM doctemplates WHERE doctemplateid = '$doctemplateid'";
@mysqli_query($rs_connect, $rs_insert_template);


header("Location: documents.php");

}




##########

function chooseform() {
require_once("deps.php");
require_once("common.php");

if(array_key_exists('pcid', $_REQUEST)) {
$pcid = $_REQUEST['pcid'];
} else {
$pcid = 0;
}

if(array_key_exists('woid', $_REQUEST)) {
$woid = $_REQUEST['woid'];
} else {
$woid = 0;
}

if(array_key_exists('groupid', $_REQUEST)) {
$groupid = $_REQUEST['groupid'];
} else {
$groupid = 0;
}

if(array_key_exists('scid', $_REQUEST)) {
$scid = $_REQUEST['scid'];
} else {
$scid = 0;
}


if($gomodal != "1") {
require("header.php");
} else {
require_once("validate.php");
}

if($gomodal != "1") {
start_blue_box(pcrtlang("Create New Form"));
} else {
echo "<h4>".pcrtlang("Create New Form")."</h4><br><br>";
}


echo "<table class=standard>";

$rs_finddoc = "SELECT * FROM doctemplates ORDER BY doctemplatename ASC";
$rs_finddoc2 = @mysqli_query($rs_connect, $rs_finddoc);
while ($rs_find_doc_q = mysqli_fetch_object($rs_finddoc2)) {
$doctemplateid = "$rs_find_doc_q->doctemplateid";
$doctemplatename = "$rs_find_doc_q->doctemplatename";
$doctemplatecreated = "$rs_find_doc_q->doctemplatecreated";

echo "<tr><td>$doctemplatename<td>";

echo "<a href=\"documents.php?func=chooseform2&doctemplateid=$doctemplateid&pcid=$pcid&woid=$woid&groupid=$groupid&scid=$scid\" class=\"linkbuttonsmall linkbuttongray radiusall\">
<i class=\"fa fa-check fa-lg\"></i> ".pcrtlang("Pick")."</a>";


echo "</td></tr>";


}
echo "</table>";

if($gomodal != 1) {
stop_blue_box();
}

if($gomodal != 1) {
require_once("footer.php");
}


}


function chooseform2() {
require_once("deps.php");
require_once("common.php");

require_once("validate.php");

$doctemplateid = $_REQUEST['doctemplateid'];

if(array_key_exists('pcid', $_REQUEST)) {
$pcid = $_REQUEST['pcid'];
} else {
$pcid = 0;
}

if(array_key_exists('woid', $_REQUEST)) {
$woid = $_REQUEST['woid'];
} else {
$woid = 0;
}

if(array_key_exists('groupid', $_REQUEST)) {
$groupid = $_REQUEST['groupid'];
} else {
$groupid = 0;
}

if(array_key_exists('scid', $_REQUEST)) {
$scid = $_REQUEST['scid'];
} else {
$scid = 0;
}



$rs_finddoc = "SELECT * FROM doctemplates WHERE doctemplateid = '$doctemplateid'";
$rs_finddoc2 = @mysqli_query($rs_connect, $rs_finddoc);
$rs_find_doc_q = mysqli_fetch_object($rs_finddoc2);
$doctemplate = "$rs_find_doc_q->doctemplate";
$doctemplatename = "$rs_find_doc_q->doctemplatename";

if($pcid != "0") {
$createform = "INSERT INTO documents (documentname, documenttemplate, pcid) VALUES ('$doctemplatename','$doctemplate','$pcid')";
} elseif ($groupid != "0") {
$createform = "INSERT INTO documents (documentname, documenttemplate, groupid) VALUES ('$doctemplatename','$doctemplate','$groupid')";
} else {
$createform = "INSERT INTO documents (documentname, documenttemplate, scid) VALUES ('$doctemplatename','$doctemplate','$scid')";
}


@mysqli_query($rs_connect, $createform);
$documentid = mysqli_insert_id($rs_connect);

header("Location: documents.php?func=editform&documentid=$documentid&woid=$woid&pcid=$pcid&groupid=$groupid&scid=$scid");

}


function editform() {

require_once("deps.php");
require_once("common.php");
require("header.php");
require_once("validate.php");

$documentid = $_REQUEST['documentid'];

if(array_key_exists('pcid', $_REQUEST)) {
$pcid = $_REQUEST['pcid'];
} else {
$pcid = 0;
}

if(array_key_exists('woid', $_REQUEST)) {
$woid = $_REQUEST['woid'];
} else {
$woid = 0;
}

if(array_key_exists('groupid', $_REQUEST)) {
$groupid = $_REQUEST['groupid'];
} else {
$groupid = 0;
}

if(array_key_exists('scid', $_REQUEST)) {
$scid = $_REQUEST['scid'];
} else {
$scid = 0;
}

start_blue_box(pcrtlang("Edit Form"));

echo "<form action=\"documents.php?func=saveform\" method=post><input type=hidden name=documentid value=\"$documentid\">";

$rs_doctemp = "SELECT * FROM documents WHERE documentid = '$documentid'";
$rs_find_template = @mysqli_query($rs_connect, $rs_doctemp);
$rs_find_template_q = mysqli_fetch_object($rs_find_template);
$documentname = "$rs_find_template_q->documentname";
$template = "$rs_find_template_q->documenttemplate";
$template = serializedarraytest($template);

echo "<div style=\"background:#777777;padding:30px;\"><div style=\"width:700px;margin-left:auto;margin-right:auto;background:#ffffff;
box-shadow: 10px 10px 8px #000000;padding:40px 20px 40px 20px;\">";

#echo "<pre>";
#print_r($template);
#echo "</pre>";

foreach($template as $key => $val) {


if($template[$key]['type'] == "heading") {
echo "<$val[textsize] style=\"color:$val[color];text-align:$key[alignment]\">$val[label]</$val[textsize]>\n\n";
}

if($template[$key]['type'] == "textarea") {
if (array_key_exists('content',$val)) {
$prefill = $val['content'];
} else {
$prefill = "$val[defaulttext]";
}
if($val['editinglocked'] == "no") {
echo "<textarea class=textbox style=\"width:100%;height:200px;\" name=\"content[$key][content]\">";
echo "$prefill";
echo "</textarea>\n\n";
} else {
echo "<p style=\"color:$val[color];align:$val[alignment];font-size:$val[textsize]px;font-weight:$val[textweight]\">$prefill</p>";
}
}

if($template[$key]['type'] == "text") {
if (array_key_exists('content',$val)) {
$prefill = $val['content'];
} else {
$prefill = "";
}
echo "<div style=\"color:$val[color];padding:3px;align:$val[alignment];font-size:$val[textsize]px;font-weight:$val[textweight];line-height:200%\">$val[label]: <input type=text class=textbox name=\"content[$key][content]\" value=\"$prefill\"></div>\n\n";
}

if($template[$key]['type'] == "logo") {
$storeinfoarray = getstoreinfo($defaultuserstore);
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
echo "<table style=\"width:100%\"><tr><td style=\"text-align:center\"><img src=\"$logo\" style=\"height:$val[height]px\"></td></tr><tr><td style=\"text-align:center;width:100%\">$businessinfo</td>
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
$prefill = "";
if (array_key_exists('content',$val) && $val['content'] != "") {
foreach($val['content'] as $ckey => $cval) {
$prefill .= "<tr><td><i class=\"fa fa-list-ul fa-lg\"></i> <input type=text class=textbox name=\"content[$key][content][]\" value=\"$cval\"></td></tr>";
}
$prefill .= "<tr><td><i class=\"fa fa-list-ul fa-lg\"></i> <input type=text class=textbox name=\"content[$key][content][]\"></td></tr>";
} else {
$prefill .= "<tr><td><i class=\"fa fa-list-ul fa-lg\"></i> <input type=text class=textbox name=\"content[$key][content][]\"></td></tr>";
}
echo "<table id=list$key><tr><td><span style=\"color:$val[color];font-size:$val[textsize]px;font-weight:$val[textweight];\">$val[label]</span><a id=\"add$key\" href=\"javascript:void(0)\" class=\"linkbuttongray linkbuttonsmall radiusall floatright\"><i class=\"fa fa-plus\"></i></a></td></tr><tbody>";
echo "$prefill";
?>
<script type="text/javascript">
    $(document).ready(function() {
        $("#add<?php echo $key; ?>").click(function() {
          $('#list<?php echo $key; ?> tbody>tr:last').clone(true).insertAfter('#list<?php echo $key; ?> tbody>tr:last');
          return false;
        });
    });
</script>
<?php
echo "</tbody></table>\n\n";
}

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




if($template[$key]['type'] == "signature") {
echo "<div><span style=\"color:$val[color];font-size:$val[textsize]px;font-weight:$val[textweight];\">$val[label]</span><br>";
echo "<i class=\"fa fa-signature fa-3x\"></i>";
echo "</div>\n\n";
}





if($template[$key]['type'] == "select") {
echo "<div style=\"padding:5px 0px;\"><span style=\"color:$val[color];font-size:$val[textsize]px;font-weight:$val[textweight];\">$val[label]</span><br>";

if($val['selecttype'] == "dropdown") {
if (array_key_exists('content',$val) && $val['content'] != "") {
$selectedoption = $val['content'];
} 
echo "<select name=\"content[$key][content]\">";
foreach($template[$key]['selectoption'] as $skey => $sval) {
if($skey == $selectedoption) {
echo "<option selected value=\"$skey\">$sval</option>";
} else {
echo "<option value=\"$skey\">$sval</option>";
}
}
echo "</select>";
} elseif ($val['selecttype'] == "radio") {
if (array_key_exists('content',$val) && !empty($val['content'])) {
$selectedradiooptions = $val['content'];
} else {
$selectedradiooptions = array();
}
foreach($template[$key]['selectoption'] as $skey => $sval) {
	if(in_array($skey, $selectedradiooptions)) {
		echo "<input type=radio checked value=\"$skey\" name=\"content[$key][content][]\"> $sval &nbsp;&nbsp;";
	} else {
		echo "<input type=radio value=\"$skey\" name=\"content[$key][content][]\"> $sval &nbsp;&nbsp;";
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
		echo "<input type=checkbox checked value=\"$skey\" name=\"content[$key][content][]\"> $sval &nbsp;&nbsp;";
	} else {
                echo "<input type=checkbox value=\"$skey\" name=\"content[$key][content][]\"> $sval &nbsp;&nbsp;";
	}
}
}
echo "</div>\n\n";
}

}

echo "</div></div><br>";

start_box();
echo pcrtlang("Document Name").": <input name=documentname class=textbox value=\"$documentname\" style=\"width:300px;\"><br><br>";

echo "<input type=hidden name=pcid value=$pcid>";
echo "<input type=hidden name=woid value=$woid>";
echo "<input type=hidden name=groupid value=$groupid>";
echo "<input type=hidden name=scid value=$scid>";

echo "<button type=submit class=button><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save Form")."</button>";
echo "<button type=submit class=button formaction=\"documents.php?func=saveform&exit=exit\"><i class=\"fa fa-save fa-lg\"></i> ".pcrtlang("Save Form and Exit")."</button>";
stop_box();

echo "</form>";

stop_blue_box();
require_once("footer.php");


}


function saveform() {

require_once("deps.php");
require_once("common.php");
require_once("validate.php");

$documentid = $_REQUEST['documentid'];
$documentname = $_REQUEST['documentname'];
$content = $_REQUEST['content'];

$woid = $_REQUEST['woid'];
$pcid = $_REQUEST['pcid'];
$groupid = $_REQUEST['groupid'];
$scid = $_REQUEST['scid'];


$rs_doctemp = "SELECT * FROM documents WHERE documentid = '$documentid'";
$rs_find_template = @mysqli_query($rs_connect, $rs_doctemp);
$rs_find_template_q = mysqli_fetch_object($rs_find_template);
$template = "$rs_find_template_q->documenttemplate";
$template = serializedarraytest($template);


foreach($content as $key => $val) {

foreach($val['content'] as $keyx=>$valuex)
{
    if(is_null($valuex) || $valuex == '')
        unset($content[$key]['content'][$keyx]);
}


$template[$key]['content'] = $content[$key]['content'];
}

$template = serialize($template);

$updateform = "UPDATE documents SET documenttemplate = '$template', documentname = '$documentname' WHERE documentid = '$documentid'";
@mysqli_query($rs_connect, $updateform);

if(!array_key_exists('exit',  $_REQUEST)) {
header("Location: documents.php?func=editform&documentid=$documentid&woid=$woid&pcid=$pcid&groupid=$groupid");
} elseif($woid != 0) {
header("Location: index.php?pcwo=$woid");
} elseif ($groupid != "0") {
header("Location: group.php?func=viewgroup&groupview=forms&pcgroupid=$groupid");
} else {
header("Location: msp.php?func=viewservicecontract&scid=$scid");
}

#echo "<pre>";
#print_r($_REQUEST);
#echo  "split";
#print_r($template);
#echo "</pre>";


}


function deleteform() {

require_once("deps.php");
require_once("common.php");
require_once("validate.php");

$documentid = $_REQUEST['documentid'];

if(array_key_exists('pcid', $_REQUEST)) {
$pcid = $_REQUEST['pcid'];
} else {
$pcid = 0;
}

if(array_key_exists('woid', $_REQUEST)) {
$woid = $_REQUEST['woid'];
} else {
$woid = 0;
}

if(array_key_exists('groupid', $_REQUEST)) {
$groupid = $_REQUEST['groupid'];
} else {
$groupid = 0;
}

if(array_key_exists('scid', $_REQUEST)) {
$scid = $_REQUEST['scid'];
} else {
$scid = 0;
}

$rs_doctemp = "DELETE FROM documents WHERE documentid = '$documentid'";
$rs_find_template = @mysqli_query($rs_connect, $rs_doctemp);

if($woid != "0") {
header("Location: index.php?pcwo=$woid");
} elseif ($groupid != "0") {
header("Location: group.php?func=viewgroup&groupview=forms&pcgroupid=$groupid");
} else {
header("Location: msp.php?func=viewservicecontract&scid=$scid");
}

}





function printform() {

require_once("deps.php");
require_once("common.php");
require_once("validate.php");

$documentid = $_REQUEST['documentid'];

if(array_key_exists('pcid', $_REQUEST)) {
$pcid = $_REQUEST['pcid'];
} else {
$pcid = 0;
}

if(array_key_exists('woid', $_REQUEST)) {
$woid = $_REQUEST['woid'];
} else {
$woid = 0;
}

if(array_key_exists('groupid', $_REQUEST)) {
$groupid = $_REQUEST['groupid'];
} else {
$groupid = 0;
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
$storeinfoarray = getstoreinfo($defaultuserstore);
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
<?php
echo "<input type=hidden name=pcid value=$pcid>";
echo "<input type=hidden name=woid value=$woid>";
echo "<input type=hidden name=groupid value=$groupid>";
?>

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
echo "<a href=documents.php?func=clearsig&documentid=$documentid class=hideprintedlink>(".pcrtlang("remove signature").")</a><br>";

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

<?php
echo "<input type=hidden name=pcid value=$pcid>";
echo "<input type=hidden name=woid value=$woid>";
echo "<input type=hidden name=groupid value=$groupid>";
?>


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
echo "<br><a href=documents.php?func=clearsigtopaz&documentid=$documentid class=hideprintedlink>(".pcrtlang("remove signature").")</a><br>";
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

if(array_key_exists('pcid', $_REQUEST)) {
$pcid = $_REQUEST['pcid'];
} else {
$pcid = 0;
}

if(array_key_exists('woid', $_REQUEST)) {
$woid = $_REQUEST['woid'];
} else {
$woid = 0;
}

if(array_key_exists('groupid', $_REQUEST)) {
$groupid = $_REQUEST['groupid'];
} else {
$groupid = 0;
}

if(array_key_exists('scid', $_REQUEST)) {
$scid = $_REQUEST['scid'];
} else {
$scid = 0;
}

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

$updateform = "UPDATE documents SET thesig = '$output', signeddatetime = '$currentdatetime' WHERE documentid = '$documentid'";
@mysqli_query($rs_connect, $updateform);

header("Location: documents.php?func=printform&documentid=$documentid&woid=$woid&pcid=$pcid&groupid=$groupid&scid=$scid");

}


function clearsig() {

require("deps.php");
require("common.php");

if(array_key_exists('pcid', $_REQUEST)) {
$pcid = $_REQUEST['pcid'];
} else {
$pcid = 0;
}

if(array_key_exists('woid', $_REQUEST)) {
$woid = $_REQUEST['woid'];
} else {
$woid = 0;
}

if(array_key_exists('groupid', $_REQUEST)) {
$groupid = $_REQUEST['groupid'];
} else {
$groupid = 0;
}

if(array_key_exists('scid', $_REQUEST)) {
$scid = $_REQUEST['scid'];
} else {
$scid = 0;
}

$documentid = $_REQUEST['documentid'];

require_once("validate.php");

$updateform = "UPDATE documents SET thesig = '', signeddatetime = '0000-00-00 00:00:00' WHERE documentid = '$documentid'";
@mysqli_query($rs_connect, $updateform);

header("Location: documents.php?func=printform&documentid=$documentid&woid=$woid&pcid=$pcid&groupid=$groupid&scid=$scid");

}


function savesigtopaz() {


require("deps.php");
require("common.php");

if(array_key_exists('pcid', $_REQUEST)) {
$pcid = $_REQUEST['pcid'];
} else {
$pcid = 0;
}

if(array_key_exists('woid', $_REQUEST)) {
$woid = $_REQUEST['woid'];
} else {
$woid = 0;
}

if(array_key_exists('groupid', $_REQUEST)) {
$groupid = $_REQUEST['groupid'];
} else {
$groupid = 0;
}

if(array_key_exists('scid', $_REQUEST)) {
$scid = $_REQUEST['scid'];
} else {
$scid = 0;
}

$output = pv($_REQUEST['output']);
$documentid = $_REQUEST['documentid'];
require_once("validate.php");

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

$updateform = "UPDATE documents SET thesigtopaz = '$output', signeddatetime = '$currentdatetime'  WHERE documentid = '$documentid'";
@mysqli_query($rs_connect, $updateform);

header("Location: documents.php?func=printform&documentid=$documentid&woid=$woid&pcid=$pcid&groupid=$groupid&scid=$scid");

}



function clearsigtopaz() {

require("deps.php");
require("common.php");

if(array_key_exists('pcid', $_REQUEST)) {
$pcid = $_REQUEST['pcid'];
} else {
$pcid = 0;
}

if(array_key_exists('woid', $_REQUEST)) {
$woid = $_REQUEST['woid'];
} else {
$woid = 0;
}

if(array_key_exists('groupid', $_REQUEST)) {
$groupid = $_REQUEST['groupid'];
} else {
$groupid = 0;
}

if(array_key_exists('scid', $_REQUEST)) {
$scid = $_REQUEST['scid'];
} else {
$scid = 0;
}

$documentid = $_REQUEST['documentid'];

require_once("validate.php");

$updateform = "UPDATE documents SET thesigtopaz = '', signeddatetime = '0000-00-00 00:00:00' WHERE documentid = '$documentid'";
@mysqli_query($rs_connect, $updateform);

header("Location: documents.php?func=printform&documentid=$documentid&woid=$woid&pcid=$pcid&groupid=$groupid&scid=$scid");

}




function addphoto() {

require("deps.php");
require("common.php");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}


$photofilename = "documents-" . time() . '.jpg';
$origphotofilename = basename($_FILES['photo']['name']);

function validate_conn($v_filename) {
return preg_match('/^[a-z0-9_ -\.]+\.(jpeg|jpg)$/i', $v_filename) ? '1' : '0';
}


if (validate_conn($origphotofilename) == '0') {
die(pcrtlang("File must also be a jpg"));
}



$uploaddir = "../attachments/";
$uploadfile = $uploaddir . basename($_FILES['photo']['name']);
if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile)) {
} else {
    echo "Failed to save your image to the attachments directory. Might want to check your file system permissions.\n";
}

exec("convert -resize '1024>x768>' ../attachments/$origphotofilename ../attachments/$photofilename");

$problem_message = "";
if (!file_exists("../attachments/$photofilename")) {
$problem_message = pcrtlang("Failed to create image using ImageMagick from the command line. Looking for Apache Module...")."<br><br>";

if (class_exists('Imagick')) {
  $img = new Imagick();
  $img->readImage("../attachments/$origphotofilename");
  $img->scaleImage(1024,768,true);
  $img->writeImage("../attachments/$photofilename");
  $img->clear();
  $img->destroy();
$problem_message = pcrtlang("ImageMagick Apache Module found... Attempting to save image...")."<br><br>";
if (!file_exists("../attachments/$photofilename")) {
$problem_message = pcrtlang("Image Save Failed. Trying GD Module...")."<br><br>";
}
} else {
$problem_message = pcrtlang("ImageMagick Apache Module not available... Trying GD Module...")."<br><br>";
}
}

if (!file_exists("../attachments/$photofilename")) {

define('THUMBNAIL_IMAGE_MAX_WIDTH', 1024);
define('THUMBNAIL_IMAGE_MAX_HEIGHT', 768);

function generate_image_thumbnail($source_image_path, $thumbnail_image_path)
{
    list($source_image_width, $source_image_height, $source_image_type) = getimagesize($source_image_path);
    switch ($source_image_type) {
        case IMAGETYPE_GIF:
            $source_gd_image = imagecreatefromgif($source_image_path);
            break;
        case IMAGETYPE_JPEG:
            $source_gd_image = imagecreatefromjpeg($source_image_path);
            break;
        case IMAGETYPE_PNG:
            $source_gd_image = imagecreatefrompng($source_image_path);
            break;
    }
    if ($source_gd_image === false) {
        return false;
    }
    $source_aspect_ratio = $source_image_width / $source_image_height;
    $thumbnail_aspect_ratio = THUMBNAIL_IMAGE_MAX_WIDTH / THUMBNAIL_IMAGE_MAX_HEIGHT;
    if ($source_image_width <= THUMBNAIL_IMAGE_MAX_WIDTH && $source_image_height <= THUMBNAIL_IMAGE_MAX_HEIGHT) {
        $thumbnail_image_width = $source_image_width;
        $thumbnail_image_height = $source_image_height;
    } elseif ($thumbnail_aspect_ratio > $source_aspect_ratio) {
        $thumbnail_image_width = (int) (THUMBNAIL_IMAGE_MAX_HEIGHT * $source_aspect_ratio);
        $thumbnail_image_height = THUMBNAIL_IMAGE_MAX_HEIGHT;
    } else {
        $thumbnail_image_width = THUMBNAIL_IMAGE_MAX_WIDTH;
        $thumbnail_image_height = (int) (THUMBNAIL_IMAGE_MAX_WIDTH / $source_aspect_ratio);
    }
    $thumbnail_gd_image = imagecreatetruecolor($thumbnail_image_width, $thumbnail_image_height);
    imagecopyresampled($thumbnail_gd_image, $source_gd_image, 0, 0, 0, 0, $thumbnail_image_width, $thumbnail_image_height, $source_image_width, $source_image_height);
    imagejpeg($thumbnail_gd_image, $thumbnail_image_path, 90);
    imagedestroy($source_gd_image);
    imagedestroy($thumbnail_gd_image);
    return true;
}

generate_image_thumbnail("../attachments/$origphotofilename", "../attachments/$photofilename");
if (!file_exists("../attachments/$photofilename")) {
$problem_message = pcrtlang("Image Save Failed using GD...")."<br><br>";
}
}



if (file_exists("../attachments/$origphotofilename")) {
unlink("../attachments/$origphotofilename");
}

if (!file_exists("../attachments/$photofilename")) {
die("$problem_message");
}

$rs_insert_pic = "INSERT INTO docphotos (docphotofilename) VALUES ('$photofilename')";
@mysqli_query($rs_connect, $rs_insert_pic);

header("Location: documents.php");

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

function deletedocphoto() {

require("deps.php");
require("common.php");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}

$docphotofilename = $_REQUEST['docphotofilename'];
$docphotoid = $_REQUEST['docphotoid'];

require_once("validate.php");

$rs_set_p = "UPDATE docphotos SET docphotoarchived = '1' WHERE docphotoid = '$docphotoid'";
@mysqli_query($rs_connect, $rs_set_p);

header("Location: documents.php");

}


function portalswitch() {

require_once("deps.php");
require_once("common.php");
require_once("validate.php");

$documentid = $_REQUEST['documentid'];
$showinportal = $_REQUEST['showinportal'];

if(array_key_exists('pcid', $_REQUEST)) {
$pcid = $_REQUEST['pcid'];
} else {
$pcid = 0;
}

if(array_key_exists('woid', $_REQUEST)) {
$woid = $_REQUEST['woid'];
} else {
$woid = 0;
}

if(array_key_exists('groupid', $_REQUEST)) {
$groupid = $_REQUEST['groupid'];
} else {
$groupid = 0;
}

if(array_key_exists('scid', $_REQUEST)) {
$scid = $_REQUEST['scid'];
} else {
$scid = 0;
}

$rs_doctemp = "UPDATE documents SET showinportal = '$showinportal' WHERE documentid = '$documentid'";
$rs_find_template = @mysqli_query($rs_connect, $rs_doctemp);

if($woid != "0") {
header("Location: index.php?pcwo=$woid");
} elseif ($groupid != "0") {
header("Location: group.php?func=viewgroup&groupview=forms&pcgroupid=$groupid");
} else {
header("Location: msp.php?func=viewservicecontract&scid=$scid");
}

}




switch($func) {
                                                                                                    
    default:
    listtemplates();
    break;
                                
    case "edittemplate":
    edittemplate();
    break;

  case "savetemplate":
    savetemplate();
    break;

 case "deletetemplate":
    deletetemplate();
    break;

 case "moveline":
    moveline();
    break;

 case "deleteline":
    deleteline();
    break;

 case "newtemplate":
    newtemplate();
    break;

 case "chooseform":
    chooseform();
    break;

 case "chooseform2":
    chooseform2();
    break;

 case "editform":
    editform();
    break;

 case "saveform":
    saveform();
    break;

 case "deleteform":
    deleteform();
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

 case "addphoto":
    addphoto();
    break;

 case "getdocphoto":
    getdocphoto();
    break;

 case "deletedocphoto":
    deletedocphoto();
    break;

 case "portalswitch":
    portalswitch();
    break;

}

?>
