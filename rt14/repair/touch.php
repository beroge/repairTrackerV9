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
                                                                                                    
function record() {

$woid = $_REQUEST['woid'];

require_once("deps.php");
require_once("touchheader.php");
require_once("common.php");
require("brandicon.php");




$rs_findpcid = "SELECT * FROM pc_wo WHERE woid = '$woid'";
$rs_result1 = mysqli_query($rs_connect, $rs_findpcid);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$pcid = "$rs_result_q1->pcid";
$prob = "$rs_result_q1->probdesc";
$theprobsindb2 = "$rs_result_q1->commonproblems";

if ($theprobsindb2 != "") {
$theprobsindb3 = unserialize($theprobsindb2);
} else {
$theprobsindb3 = array();
}

if (is_array($theprobsindb3)) {
$theprobsindb = $theprobsindb3;
} else {
$theprobsindb = array();
}


}


$rs_findpic = "SELECT * FROM assetphotos WHERE pcid = '$pcid' AND highlight='1'";
$rs_resultpic2 = mysqli_query($rs_connect, $rs_findpic);


if (mysqli_num_rows($rs_resultpic2) != "0") {
$rs_resultpic_q2 = mysqli_fetch_object($rs_resultpic2);
$assetphotoid = "$rs_resultpic_q2->assetphotoid";
$largeicon = brandicon("$pcmake");
echo "<table style=\"margin-left:auto;margin-right:auto;\"><tr><td><img src=images/pcs/$largeicon border=0></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>";
echo "<img src=pc.php?func=getpcimage&photoid=$assetphotoid border=1 width=256></td></tr></table>";
} else {
$largeicon = brandicon("$pcmake");
echo "<center><img src=images/pcs/$largeicon border=0></center>";
}

echo "<br><br><center><span class=sizeme2x>$prob</span><br>";

foreach($theprobsindb as $key => $val) {
echo "<span class=sizeme2x>&bull; $val</span><br>";
}

echo "<br>";



$rs_findstatii = "SELECT * FROM boxstyles WHERE selectablestatus = '1' ORDER BY displayedorder ASC";
$rs_result_st = mysqli_query($rs_connect, $rs_findstatii);
while($rs_result_stq = mysqli_fetch_object($rs_result_st)) {
$thestatii[] = "$rs_result_stq->statusid";
}


reset($thestatii);
echo "<span class=\"linkbuttonlarge linkbuttongraylabel radiusleft\"><i class=\"fa fa-cog fa-lg\"></i> ".pcrtlang("Status").":&nbsp;&nbsp;</span>";

echo "<a href=\"javascript:void(0);\" class=\"linkbuttonlarge linkbuttonopaque2 textoutline\" id=statuschange style=\"background:#$boxstyles[selectorcolor];display:inline\">$boxstyles[boxtitle]
<i class=\"fa fa-chevron-down fa-lg\"></i></a>";

echo "<div id=statusselectorbox style=\"display:none;\">";

reset($thestatii);
foreach($thestatii as $k => $v) {
$rs_gets2 = "SELECT * FROM boxstyles WHERE statusid = '$v'";
$rs_results2 = mysqli_query($rs_connect, $rs_gets2);
$rs_result_qs2 = mysqli_fetch_object($rs_results2);
$selectorcolor2 = "$rs_result_qs2->selectorcolor";
$boxtitle2 = "$rs_result_qs2->boxtitle";

#wip

if($pcstatus == $v) {
echo "<a href=\"touch.php?func=stat_change&woid=$woid&statnum=$v\" class=\"linkbuttonlarge textoutline linkbuttonopaque2 radiusall\" style=\"background:#$selectorcolor2;margin:5px;\">$boxtitle2</a>";
} else {
echo "<a href=\"touch.php?func=stat_change&woid=$woid&statnum=$v\" class=\"linkbuttonlarge textoutline linkbuttonopaque2 radiusall\" style=\"background:#$selectorcolor2;margin:5px;\">$boxtitle2</a>";
}


}


echo "</div>";

?>
<script type='text/javascript'>
$('#statuschange').click(function(){
  $('#statusselectorbox').toggle('1000');
  $("i",this).toggleClass("fa-chevron-up fa-chevron-down");
});
</script>
<?php



###################################################



##########
echo "<br><br>";
start_box();
echo "<table><tr><td width=50% valign=top><h4>&nbsp;<img src=images/scan.png border=0 align=absmiddle> ".pcrtlang("Scans")."&nbsp;</h4><br><table>";
$rs_foundscan = "SELECT * FROM pc_scan WHERE woid = '$woid' ORDER BY scantime ASC";
$rs_result_fs = mysqli_query($rs_connect, $rs_foundscan);
while($rs_result_fsr = mysqli_fetch_object($rs_result_fs)) {
$scanid = "$rs_result_fsr->scanid";
$scantype = "$rs_result_fsr->scantype";
$scannum = "$rs_result_fsr->scannum";
$scantime = "$rs_result_fsr->scantime";
$customprogname = "$rs_result_fsr->customprogname";
$customprintinfo = "$rs_result_fsr->customprintinfo";
$customscantype = "$rs_result_fsr->customscantype";

$scantime2 = date('h:i:s m-j-y', strtotime($scantime));

if ($scantype != "0") {
$rs_foundscan_name = "SELECT * FROM pc_scans WHERE scanid = '$scantype'";
$rs_result_fs_name = mysqli_query($rs_connect, $rs_foundscan_name);
$rs_result_fsr_name = mysqli_fetch_object($rs_result_fs_name);
$scantypeid = "$rs_result_fsr_name->scanid";
$scantypeprogname = "$rs_result_fsr_name->progname";
$scantypeicon = "$rs_result_fsr_name->progicon";
$myscantype = "$rs_result_fsr_name->scantype";
} else {
$myscantype = $customscantype;
}

if (($myscantype == 0) || ($customscantype == 0)) {

if ($myscantype == 0) {
echo "<tr><td>";

if ($scantype == 0) {
echo "<img src=images/hand.png>";
} else {
echo "<img src=images/scans/$scantypeicon>";
}


echo "</td><td>";

if ($customprogname != "") {
echo "$customprogname";
} else {
echo "$scantypeprogname";
}



if ($scannum != 0) {
echo " - <span class=colormered>$scannum ".pcrtlang("item(s) found")."</span>";
} else {
echo "<span class=colormeblue> - ".pcrtlang("no items found")."</span>";
}


echo "</td></tr>";
}
}
}
echo "</table><br>";

#############2

echo "<h4>&nbsp;<img src=images/actionicon.png border=0 align=absmiddle> ".pcrtlang("Actions")."&nbsp;</h4><br><table>";
$rs_foundscan1d = "SELECT * FROM pc_scan WHERE woid = '$woid' ORDER BY scantime ASC";
$rs_result_fs1d = mysqli_query($rs_connect, $rs_foundscan1d);
while($rs_result_fsr1d = mysqli_fetch_object($rs_result_fs1d)) {
$scanid1d = "$rs_result_fsr1d->scanid";
$scantype1d = "$rs_result_fsr1d->scantype";
$scannum1d = "$rs_result_fsr1d->scannum";
$customprogname1d = "$rs_result_fsr1d->customprogname";
$customprintinfo1d = "$rs_result_fsr1d->customprintinfo";
$customscantype1d = "$rs_result_fsr1d->customscantype";

if ($scantype1d != "0") {
$rs_foundscan_name1d = "SELECT * FROM pc_scans WHERE scanid = '$scantype1d'";
$rs_result_fs_name1d = mysqli_query($rs_connect, $rs_foundscan_name1d);
$rs_result_fsr_name1d = mysqli_fetch_object($rs_result_fs_name1d);
$scantypeid1d = "$rs_result_fsr_name1d->scanid";
$scantypeprogname1d = "$rs_result_fsr_name1d->progname";
$scantypeicon1d = "$rs_result_fsr_name1d->progicon";
$myscantype1d = "$rs_result_fsr_name1d->scantype";
} else {
$myscantype1d = $customscantype1d;
}

if (($myscantype1d == 1) || ($customscantype1d == 1)) {

echo "<tr><td>";

if ($scantype1d == 0) {
echo "<img src=images/hand.png>";
} else {
echo "<img src=images/scans/$scantypeicon1d>";
}

echo "</td><td>";

if ($customprogname1d != "") {
echo "$customprogname1d";
} else {
echo "$scantypeprogname1d";
}




echo "</td></tr>";
}
}
echo "</table><br>";



###############3
echo "</td><td width=50% valign=top><h4>&nbsp;<img src=images/installicon.png border=0 align=absmiddle> ".pcrtlang("Installed")."&nbsp;</h4><br><table>";
$rs_foundscan2d = "SELECT * FROM pc_scan WHERE woid = '$woid' ORDER BY scantime ASC";
$rs_result_fs2d = mysqli_query($rs_connect, $rs_foundscan2d);
while($rs_result_fsr2d = mysqli_fetch_object($rs_result_fs2d)) {
$scanid2d = "$rs_result_fsr2d->scanid";
$scantype2d = "$rs_result_fsr2d->scantype";
$scannum2d = "$rs_result_fsr2d->scannum";
$customprogname2d = "$rs_result_fsr2d->customprogname";
$customprintinfo2d = "$rs_result_fsr2d->customprintinfo";
$customscantype2d = "$rs_result_fsr2d->customscantype";


if ($scantype2d != "0") {
$rs_foundscan_name2d = "SELECT * FROM pc_scans WHERE scanid = '$scantype2d'";
$rs_result_fs_name2d = mysqli_query($rs_connect, $rs_foundscan_name2d);
$rs_result_fsr_name2d = mysqli_fetch_object($rs_result_fs_name2d);
$scantypeid2d = "$rs_result_fsr_name2d->scanid";
$scantypeprogname2d = "$rs_result_fsr_name2d->progname";
$scantypeicon2d = "$rs_result_fsr_name2d->progicon";
$myscantype2d = "$rs_result_fsr_name2d->scantype";
} else {
$myscantype2d = $customscantype2d;
}

if (($myscantype2d == 2) || ($customscantype2d == 2)) {
echo "<tr><td>";

if ($scantype2d == 0) {
echo "<img src=images/hand.png>";
} else {
echo "<img src=images/scans/$scantypeicon2d>";
}

echo "</td><td>";

if ($customprogname2d != "") {
echo "$customprogname2d";
} else {
echo "$scantypeprogname2d";
}


echo "</td></tr>";
}
}
echo "</table><br>";





###################4
echo "<h4>&nbsp;<img src=images/notesicon.png border=0 align=absmiddle> ".pcrtlang("Notes")."&nbsp;</h4><br><table>";
$rs_foundscan3d = "SELECT * FROM pc_scan WHERE woid = '$woid' ORDER BY scantime ASC";
$rs_result_fs3d  = mysqli_query($rs_connect, $rs_foundscan3d);
while($rs_result_fsr3d = mysqli_fetch_object($rs_result_fs3d)) {
$scanid3d = "$rs_result_fsr3d->scanid";
$scantype3d = "$rs_result_fsr3d->scantype";
$scannum3d = "$rs_result_fsr3d->scannum";
$customprogname3d = "$rs_result_fsr3d->customprogname";
$customprintinfo3d = "$rs_result_fsr3d->customprintinfo";
$customscantype3d = "$rs_result_fsr3d->customscantype";

if ($scantype3d != "0") {
$rs_foundscan_name3d = "SELECT * FROM pc_scans WHERE scanid = '$scantype3d'";
$rs_result_fs_name3d = mysqli_query($rs_connect, $rs_foundscan_name3d);
$rs_result_fsr_name3d = mysqli_fetch_object($rs_result_fs_name3d);
$scantypeid3d = "$rs_result_fsr_name3d->scanid";
$scantypeprogname3d = "$rs_result_fsr_name3d->progname";
$scantypeicon3d = "$rs_result_fsr_name3d->progicon";
$myscantype3d = "$rs_result_fsr_name3d->scantype";
} else {
$myscantype3d = $customscantype3d;
}

if (($myscantype3d == 3) || ($customscantype3d == 3)) {

echo "<tr><td>";

if ($scantype3d == 0) {
echo "<img src=images/hand.png>";
} else {
echo "<img src=images/scans/$scantypeicon3d>";
}

echo "</td><td>";

if ($customprogname3d != "") {
echo "$customprogname3d";
} else {
echo "$scantypeprogname3d";
}


echo "</td></tr>";
}
}
echo "</table></td></tr></table><br>";




###################


stop_box();


require_once("touchfooter.php");
                                                                                                    
}



function notes() {

$pcwo = $_REQUEST['woid'];

require_once("deps.php");
require_once("touchheader.php");
require_once("common.php");






#####

start_box();

echo "<table style=\"width:100%;\"><tr><td><h4>&nbsp;".pcrtlang("Notes for Customer").":&nbsp;($pcname)</h4></td><td style=\"text-align:right;\">";
echo "<INPUT TYPE=button value=\"".pcrtlang("Add Customer Note")."\" onClick=\"parent.location='pc.php?func=addnote&notetype=0&woid=$pcwo&touch=touch'\" class=\"linkbutton2x linkbuttongreen radiusall\"></td></tr></table>\n";

$rs_findnotes = "SELECT * FROM wonotes WHERE woid = '$pcwo' AND notetype = '0' ORDER BY notetime ASC";
$rs_result_n = mysqli_query($rs_connect, $rs_findnotes);
$bubblego = "first";
$usercomm = array();
while($rs_result_qn = mysqli_fetch_object($rs_result_n)) {
$thenote = nl2br("$rs_result_qn->thenote");
$noteuser = "$rs_result_qn->noteuser";
$notetype = "$rs_result_qn->notetype";
$noteid = "$rs_result_qn->noteid";
$notetime2 = "$rs_result_qn->notetime";
$notetime =  date('g:ia n-j-Y', strtotime($notetime2));

if(array_key_exists("$noteuser",$usercomm)) {
$bubblego = $usercomm[$noteuser];
} else {
if($bubblego == "first") {
$bubblego = "left";
} elseif ($prevuser == "noteuser") {
$bubblego = "$thedir";
} else {
$bubblego = "$thediropp";
}
}

if ("$bubblego" == "left") {
echo "<table style=\"width:100%\"><tr><td style=\"width:125px;text-align:center;vertical-align:top;\">";
echo "$noteuser";
echo "<br><span class=\"sizemesmaller\">$notetime</span>";
echo "<INPUT TYPE=button value=\"".pcrtlang("Edit")."\" onClick=\"parent.location='pc.php?func=editnote&woid=$pcwo&noteid=$noteid&touch=touch'\" class=\"linkbutton2x linkbuttongreen radiusall\">\n";
echo "<INPUT TYPE=button value=\" X \" onClick=\"if(confirm('".pcrtlang("Are you sure you wish to permanently delete this note?")."')) { parent.location='pc.php?func=deletenote&woid=$pcwo&noteid=$noteid&notetype=$notetype&touch=touch';}\" class=\"linkbutton2x linkbuttonred radiusall\"><br>\n";



echo "</td><td>";
echo "<div class=\"wonote left\">$thenote</div>";
echo "</td></tr></table>";
$prevuser = "$noteuser";
$thedir = "left";
$thediropp = "right";
} else {
echo "<table style=\"width:100%\"><tr><td>";
echo "<div class=\"wonote right\">$thenote</div></td>";
echo "<td style=\"width:125px;text-align:center;align:top\">";
echo "$noteuser";
echo "<br><span class=\"sizemesmaller\">$notetime</span>";
echo "<INPUT TYPE=button value=\"".pcrtlang("Edit")."\" onClick=\"parent.location='pc.php?func=editnote&woid=$pcwo&noteid=$noteid&touch=touch'\" class=\"linkbuttonlarge linkbuttongreen radiusall\">\n";
echo "<INPUT TYPE=button value=\" X \" onClick=\"if(confirm('".pcrtlang("Are you sure you wish to permanently delete this note?")."')) { parent.location='pc.php?func=deletenote&woid=$pcwo&noteid=$noteid&notetype=$notetype&touch=touch';}\" class=\"linkbuttonlarge linkbuttonred radiusall\"><br>\n";
echo "</td></tr></table>";
$prevuser = "$noteuser";
$thedir = "right";
$thediropp = "left";
}

$usercomm[$noteuser] = "$thedir";



}
stop_box();
echo "<a name=pcnotes1></a><br><br>";
start_box();
#######tech notes

echo "<table style=\"width:100%;\"><tr><td><h4>&nbsp;".pcrtlang("Technician Only Notes/Billing Instructions").":&nbsp;($pcname)</h4></td><td style=\"text-align:right;\">";

echo "<INPUT TYPE=button value=\"".pcrtlang("Add Technician Only Note")."\" onClick=\"parent.location='pc.php?func=addnote&notetype=1&woid=$pcwo&touch=touch'\" class=\"linkbutton2x linkbuttongreen radiusall\"></td></tr></table>\n";

$rs_findnotes = "SELECT * FROM wonotes WHERE woid = '$pcwo' AND notetype = '1' ORDER BY notetime ASC";
$rs_result_n = mysqli_query($rs_connect, $rs_findnotes);
$bubblego = "first";
$usercomm = array();
while($rs_result_qn = mysqli_fetch_object($rs_result_n)) {
$thenote = nl2br("$rs_result_qn->thenote");
$noteuser = "$rs_result_qn->noteuser";
$noteid = "$rs_result_qn->noteid";
$notetype = "$rs_result_qn->notetype";
$notetime2 = "$rs_result_qn->notetime";
$notetime =  date('g:ia n-j-Y', strtotime($notetime2));

if(array_key_exists("$noteuser",$usercomm)) {
$bubblego = $usercomm[$noteuser];
} else {
if($bubblego == "first") {
$bubblego = "left";
} elseif ($prevuser == "noteuser") {
$bubblego = "$thedir";
} else {
$bubblego = "$thediropp";
}
}

if ("$bubblego" == "left") {
echo "<table style=\"width:100%\"><tr><td style=\"width:125px;text-align:center;vertical-align:top;\">";
echo "$noteuser";
echo "<br><span class=\"sizemesmaller\">$notetime</span>";
echo "<INPUT TYPE=button value=\"".pcrtlang("Edit")."\" onClick=\"parent.location='pc.php?func=editnote&woid=$pcwo&noteid=$noteid&touch=touch'\"
class=\"linkbuttonlarge linkbuttongreen radiusall\">\n";
echo "<INPUT TYPE=button value=\" X \" onClick=\"if(confirm('".pcrtlang("Are you sure you wish to permanently delete this note?")."')) { parent.location='pc.php?func=deletenote&woid=$pcwo&noteid=$noteid&notetype=$notetype&touch=touch';}\" class=\"linkbuttonlarge linkbuttonred radiusall\"><br>\n";
echo "</td><td>";
echo "<div class=\"wonote left\">$thenote</div>";
echo "</td></tr></table>";
$prevuser = "$noteuser";
$thedir = "left";
$thediropp = "right";
} else {
echo "<table style=\"width:100%\"><tr><td>";
echo "<div class=\"wonote right\">$thenote</div></td>";
echo "<td style=\"width:125px;text-align:center;align:top\">";
echo "$noteuser";
echo "<br><span class=\"sizemesmaller\">$notetime</span>";
echo "<INPUT TYPE=button value=\"".pcrtlang("Edit")."\" onClick=\"parent.location='pc.php?func=editnote&woid=$pcwo&noteid=$noteid&touch=touch'\"
class=\"linkbuttonlarge linkbuttongreen radiusall\">\n";
echo "<INPUT TYPE=button value=\" X \" onClick=\"if(confirm('".pcrtlang("Are you sure you wish to permanently delete this note?")."')) { parent.location='pc.php?func=deletenote&woid=$pcwo&noteid=$noteid&notetype=$notetype&touch=touch';}\" class=\"linkbuttonlarge linkbuttonred radiusall\"><br>\n";
echo "</td></tr></table>";
$prevuser = "$noteuser";
$thedir = "right";
$thediropp = "left";
}

$usercomm[$noteuser] = "$thedir";

}


stop_box();


####


require_once("touchfooter.php");

}



function recordscan1() {

$woid = $_REQUEST['woid'];

require("deps.php");
require("touchheader.php");       
       




echo "<FORM name=Calc method=post action=touch.php?func=add_scan>";
echo "<input type=hidden name=woid value=$woid>";            

?>

<TABLE style="margin-left:auto;margin-right:auto;">
<TR>
<TD style="text-align:center">
<INPUT TYPE="text" NAME="Input" Size="10" class=textbox style="FONT-SIZE: 20px;">

<TD style="text-align:center">
<INPUT class="linkbutton2x linkbuttongray radiusall" TYPE="button" NAME="one"   VALUE="  1  " OnClick="Calc.Input.value += '1'" OnMouseDown = "this.className='linkbutton2x linkbuttongray radiusall'" OnMouseUp="this.className='linkbutton2x linkbuttongray radiusall'">
<INPUT class="linkbutton2x linkbuttongray radiusall" TYPE="button" NAME="two"   VALUE="  2  " OnCLick="Calc.Input.value += '2'" OnMouseDown = "this.className='linkbutton2x linkbuttongray radiusall'" OnMouseUp="this.className='linkbutton2x linkbuttongray radiusall'">
<INPUT class="linkbutton2x linkbuttongray radiusall" TYPE="button" NAME="three" VALUE="  3  " OnClick="Calc.Input.value += '3'" OnMouseDown = "this.className='linkbutton2x linkbuttongray radiusall'" OnMouseUp="this.className='linkbutton2x linkbuttongray radiusall'">

<INPUT class="linkbutton2x linkbuttongray radiusall" TYPE="button" NAME="four"  VALUE="  4  " OnClick="Calc.Input.value += '4'" OnMouseDown = "this.className='linkbutton2x linkbuttongray radiusall'" OnMouseUp="this.className='linkbutton2x linkbuttongray radiusall'">
<INPUT class="linkbutton2x linkbuttongray radiusall" TYPE="button" NAME="five"  VALUE="  5  " OnCLick="Calc.Input.value += '5'" OnMouseDown = "this.className='linkbutton2x linkbuttongray radiusall'" OnMouseUp="this.className='linkbutton2x linkbuttongray radiusall'">
<INPUT class="linkbutton2x linkbuttongray radiusall" TYPE="button" NAME="six"   VALUE="  6  " OnClick="Calc.Input.value += '6'" OnMouseDown = "this.className='linkbutton2x linkbuttongray radiusall'" OnMouseUp="this.className='linkbutton2x linkbuttongray radiusall'">

<INPUT class="linkbutton2x linkbuttongray radiusall" TYPE="button" NAME="seven" VALUE="  7  " OnClick="Calc.Input.value += '7'" OnMouseDown = "this.className='linkbutton2x linkbuttongray radiusall'" OnMouseUp="this.className='linkbutton2x linkbuttongray radiusall'">
<INPUT class="linkbutton2x linkbuttongray radiusall" TYPE="button" NAME="eight" VALUE="  8  " OnCLick="Calc.Input.value += '8'" OnMouseDown = "this.className='linkbutton2x linkbuttongray radiusall'" OnMouseUp="this.className='linkbutton2x linkbuttongray radiusall'">
<INPUT class="linkbutton2x linkbuttongray radiusall" TYPE="button" NAME="nine"  VALUE="  9  " OnClick="Calc.Input.value += '9'" OnMouseDown = "this.className='linkbutton2x linkbuttongray radiusall'" OnMouseUp="this.className='linkbutton2x linkbuttongray radiusall'">

<INPUT class="linkbutton2x linkbuttongray radiusall" TYPE="button" NAME="zero"  VALUE="  0  " OnClick="Calc.Input.value += '0'" OnMouseDown = "this.className='linkbutton2x linkbuttongray radiusall'" OnMouseUp="this.className='linkbutton2x linkbuttongray radiusall'">
<br>
</TD>
</TR>
</TABLE>


<?php




$a=1;
     
#echo "<table cellspacing=10 border=0 align=center><tr>";
 
echo "<div class=\"flextouchicon-container radioboxtouchicon\">";                                                                     

$rs_findscans = "SELECT * FROM pc_scans  WHERE scantype = '0' AND active = '1' ORDER BY theorder DESC";
$rs_result_s = mysqli_query($rs_connect, $rs_findscans);
while($rs_result_q_s = mysqli_fetch_object($rs_result_s)) {
$scanid = "$rs_result_q_s->scanid";
$progname = "$rs_result_q_s->progname";
$progicon = "$rs_result_q_s->progicon";

$rs_chkscans = "SELECT * FROM pc_scan WHERE scantype = '$scanid' AND woid = '$woid'";
$rs_chkresult_s = mysqli_query($rs_connect, $rs_chkscans);
$numc = mysqli_num_rows($rs_chkresult_s);
if ($numc == 0) {

echo "<div class=\"flextouchicon-item\">";
echo "<input type=radio id=$scanid name=scanid value=$scanid><label for=$scanid><img src=images/scans/l_$progicon width=84>";
echo "<br>$progname</label>";
echo "</div>";

} else {

echo "<div class=\"flextouchicon-item\">";
echo "<input type=radio id=$scanid name=scanid value=$scanid><label for=$scanid><img src=images/scans/gl_$progicon width=84>";
echo "<br><span class=\"colormegray italme\">$progname</span></label>";
echo "</div>";


}

$a++;
if ($a > 5) {
#echo "</tr><tr>";
$a=1;
}

}

#echo "</tr></table>";

echo "</div>";

?>
<center>
<INPUT class="linkbutton2x linkbuttonred radiusall" TYPE="button" NAME="clear" VALUE="  <?php echo pcrtlang("Clear"); ?>  " OnClick="Calc.Input.value = ''" OnMouseDown = "this.className='linkbutton2x linkbuttonred radiusall'" OnMouseUp="this.className='linkbutton2x linkbuttonred radiusall'">
<INPUT class="linkbutton2x linkbuttongreen radiusall" TYPE="submit" NAME="clear" VALUE="  <?php echo pcrtlang("Enter"); ?>  " OnMouseDown = "this.className='linkbutton2x linkbuttongreen radiusall'" OnMouseUp="this.className='linkbutton2x linkbuttongreen radiusall'">
</center>
<?php

echo "</form>";


require("touchfooter.php");
                                                                                                                             
}




function recordscan2() {

$woid = $_REQUEST['woid'];
$scantype = $_REQUEST['scantype'];

require("deps.php");
require("touchheader.php");

echo "<div class=flextouchicon-container>";

$rs_findscans = "SELECT * FROM pc_scans  WHERE scantype = '$scantype' AND active = '1' ORDER BY theorder DESC";

$rs_result_s = mysqli_query($rs_connect, $rs_findscans);
while($rs_result_q_s = mysqli_fetch_object($rs_result_s)) {
$scanid = "$rs_result_q_s->scanid";
$progname = "$rs_result_q_s->progname";
$progicon = "$rs_result_q_s->progicon";

$rs_chkscans = "SELECT * FROM pc_scan WHERE scantype = '$scanid' AND woid = '$woid'";
$rs_chkresult_s = mysqli_query($rs_connect, $rs_chkscans);
$numc = mysqli_num_rows($rs_chkresult_s);
if ($numc == 0) {

echo "<div class=flextouchicon-item>";
echo "<a href=touch.php?func=add_scan2&scanid=$scanid&woid=$woid&scantype=$scantype class=imagelink><img src=images/scans/l_$progicon width=84 border=0></a>";
echo "<br><span class=boldme>$progname</span>";
echo "</div>";

} else {

echo "<div class=flextouchicon-item>";
echo "<a href=touch.php?func=del_scan&scanid=$scanid&woid=$woid&scantype=$scantype class=imagelink><img src=images/scans/gl_$progicon width=84 border=0></a>";
echo "<br><span class=\"colormegray italme\">$progname</span></label>";
echo "</div>";
}


}
echo "</form>";


require("touchfooter.php");

}






function add_scan() {
require_once("validate.php");                                                                                                                                               
require("deps.php");
require("common.php");

$woid = $_REQUEST['woid'];
$scanid = $_REQUEST['scanid'];
$Input = $_REQUEST['Input'];

if (!array_key_exists('scanid',$_REQUEST)) {
die("no scan selected<br><br><INPUT TYPE=button value=\"".pcrtlang("Go Back")."\" onClick=\"history.go(-1)\">");
} else {
if ($scanid == "") {
die("no scan selected<br><br><INPUT TYPE=button value=\"".pcrtlang("Go Back")."\" onClick=\"history.go(-1)\">");
} else {
$scanid = $_REQUEST['scanid'];
}
}


if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}


$currentdatetime = date('Y-m-d H:i:s');



$rs_insert_scan = "INSERT INTO pc_scan (scantype,scannum,woid,scantime,byuser) VALUES ('$scanid','$Input','$woid','$currentdatetime','$ipofpc')";
@mysqli_query($rs_connect, $rs_insert_scan);

$findname = "SELECT progname FROM pc_scans WHERE scanid = '$scanid'";
$findnameq = mysqli_query($rs_connect, $findname);
$rs_result = mysqli_fetch_object($findnameq);
$progname = "$rs_result->progname";


userlog(3,$woid,'woid',"$progname");


header("Location: touch.php?func=record&woid=$woid");


}



function add_scan2() {
require_once("validate.php");
require("deps.php");
require("common.php");

$woid = $_REQUEST['woid'];
$scanid = $_REQUEST['scanid'];
$scantype = $_REQUEST['scantype'];

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}


$currentdatetime = date('Y-m-d H:i:s');


$rs_insert_scan = "INSERT INTO pc_scan (scantype,woid,scantime,byuser) VALUES ('$scanid','$woid','$currentdatetime','$ipofpc')";
@mysqli_query($rs_connect, $rs_insert_scan);


$findname = "SELECT progname FROM pc_scans WHERE scanid = '$scanid'";
$findnameq = mysqli_query($rs_connect, $findname);
$rs_result = mysqli_fetch_object($findnameq);
$progname = "$rs_result->progname";


userlog(3,$woid,'woid',"$progname");


header("Location: touch.php?func=recordscan2&woid=$woid&scantype=$scantype");


}


function del_scan() {
require_once("validate.php");
require("deps.php");

$woid = $_REQUEST['woid'];
$scanid = $_REQUEST['scanid'];
$scantype = $_REQUEST['scantype'];




$rs_insert_scan = "DELETE FROM pc_scan WHERE woid = '$woid' AND scantype = '$scanid'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: touch.php?func=recordscan2&woid=$woid&scantype=$scantype");


}



function settouchview() {
require_once("validate.php");
require("deps.php");
require("common.php");

$settouchview = $_REQUEST['settouchview'];




$rs_insert_scan = "UPDATE users SET touchview = '$settouchview' WHERE username = '$ipofpc'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: touch.php");


}



function status() {

require("headerstatus.php");
require("deps.php");
require_once("common.php");
require("brandicon.php");




$rs_ql = "SELECT touchwide,statusview FROM users WHERE username = '$ipofpc'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$touchwide = "$rs_result_q1->touchwide";
$statusview = "$rs_result_q1->statusview";

#$rs_findnotes5 = "SELECT * FROM pc_wo WHERE pcstatus = '$touchview' AND storeid = '$defaultuserstore' ORDER BY workarea";

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}


$daystart = date('Y-m-d')." 00:00:00";

#####
if($touchview == 2) {
if($statusview == 0) {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus = '2' AND storeid = '$defaultuserstore' AND ((sked = '0') OR (sked = '1' AND DATE_ADD('$daystart', INTERVAL 2 DAY) > skeddate)) ORDER BY workarea, dropdate ASC";
} elseif($statusview == 1) {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus = '2' AND storeid = '$defaultuserstore' AND assigneduser = '$ipofpc' AND ((sked = '0') OR (sked = '1' AND DATE_ADD('$daystart', INTERVAL 2 DAY) > skeddate)) ORDER BY workarea, dropdate ASC";
} elseif($statusview == 2) {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus = '2' AND storeid = '$defaultuserstore' AND sked = '1' ORDER BY workarea, skeddate ASC";
} else {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus = '2' AND storeid = '$defaultuserstore' AND assigneduser = '$ipofpc' AND sked = '1' ORDER BY workarea, skeddate ASC";
}
}

if($touchview == 8) {
if($statusview == 0) {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus = '8' AND storeid = '$defaultuserstore' AND ((sked = '0') OR (sked = '1' AND DATE_ADD('$daystart', INTERVAL 2 DAY) > skeddate)) ORDER BY dropdate ASC";
} elseif($statusview == 1) {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus = '8' AND storeid = '$defaultuserstore' AND assigneduser = '$ipofpc' AND ((sked = '0') OR (sked = '1' AND DATE_ADD('$daystart', INTERVAL 2 DAY) > skeddate)) ORDER BY dropdate ASC";
} elseif($statusview == 2) {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus = '8' AND storeid = '$defaultuserstore' AND sked = '1' ORDER BY skeddate ASC";
} else {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus = '8' AND storeid = '$defaultuserstore' AND assigneduser = '$ipofpc' AND sked = '1' ORDER BY skeddate ASC";
}
}

if($touchview == 9) {
if($statusview == 0) {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus = '9' AND storeid = '$defaultuserstore' AND ((sked = '0') OR (sked = '1' AND DATE_ADD('$daystart', INTERVAL 2 DAY) > skeddate)) ORDER BY dropdate ASC";
} elseif($statusview == 1) {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus = '9' AND storeid = '$defaultuserstore' AND assigneduser = '$ipofpc' AND ((sked = '0') OR (sked = '1' AND DATE_ADD('$daystart', INTERVAL 2 DAY) > skeddate)) ORDER BY dropdate ASC";
} elseif($statusview == 2) {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus = '9' AND storeid = '$defaultuserstore' AND sked = '1' ORDER BY skeddate ASC";
} else {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus = '9' AND storeid = '$defaultuserstore' AND assigneduser = '$ipofpc' AND sked = '1' ORDER BY skeddate ASC";
}
}

if($touchview == 1) {
if($statusview == 0) {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus = '1' AND storeid = '$defaultuserstore' AND ((sked = '0') OR (sked = '1' AND DATE_ADD('$daystart', INTERVAL 2 DAY) > skeddate)) ORDER BY dropdate ASC";
} elseif($statusview == 1) {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus = '1' AND storeid = '$defaultuserstore' AND assigneduser = '$ipofpc' AND ((sked = '0') OR (sked = '1' AND DATE_ADD('$daystart', INTERVAL 2 DAY) > skeddate)) ORDER BY dropdate ASC";
} elseif($statusview == 2) {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus = '1' AND storeid = '$defaultuserstore' AND sked = '1' ORDER BY skeddate ASC";
} else {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus = '1' AND storeid = '$defaultuserstore' AND assigneduser = '$ipofpc' AND sked = '1' ORDER BY skeddate ASC";
}
}

if($touchview == 3) {
if($statusview == 0) {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus = '3' AND storeid = '$defaultuserstore' AND ((sked = '0') OR (sked = '1' AND DATE_ADD('$daystart', INTERVAL 2 DAY) > skeddate)) ORDER BY dropdate ASC";
} elseif($statusview == 1) {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus = '3' AND storeid = '$defaultuserstore' AND assigneduser = '$ipofpc' AND ((sked = '0') OR (sked = '1' AND DATE_ADD('$daystart', INTERVAL 2 DAY) > skeddate)) ORDER BY dropdate ASC";
} elseif($statusview == 2) {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus = '3' AND storeid = '$defaultuserstore' AND sked = '1' ORDER BY skeddate ASC";
} else {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus = '3' AND storeid = '$defaultuserstore' AND assigneduser = '$ipofpc' AND sked = '1' ORDER BY skeddate ASC";
}
}

if($touchview > 99) {
if($statusview == 0) {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus = '$touchview' AND storeid = '$defaultuserstore' AND ((sked = '0') OR (sked = '1' AND DATE_ADD('$daystart', INTERVAL 2 DAY) > skeddate)) ORDER BY dropdate ASC";
} elseif($statusview == 1) {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus = '$touchview' AND storeid = '$defaultuserstore' AND assigneduser = '$ipofpc' AND ((sked = '0') OR (sked = '1' AND DATE_ADD('$daystart', INTERVAL 2 DAY) > skeddate)) ORDER BY dropdate ASC";
} elseif($statusview == 2) {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus = '$touchview' AND storeid = '$defaultuserstore' AND sked = '1' ORDER BY skeddate ASC";
} else {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus = '$touchview' AND storeid = '$defaultuserstore' AND assigneduser = '$ipofpc' AND sked = '1' ORDER BY skeddate ASC";
}
}

if($touchview == 4) {
if($statusview == 0) {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus = '4' AND storeid = '$defaultuserstore' AND DATE_SUB(NOW(), INTERVAL 1 MONTH) < dropdate ORDER BY dropdate ASC";
} elseif($statusview == 1) {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus = '4' AND storeid = '$defaultuserstore' AND assigneduser = '$ipofpc' AND DATE_SUB(NOW(), INTERVAL 1 MONTH) < dropdate ORDER BY dropdate ASC";
} elseif($statusview == 2) {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus = '4' AND storeid = '$defaultuserstore' AND DATE_SUB(NOW(), INTERVAL 1 MONTH) < dropdate ORDER BY dropdate ASC";
} else {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus = '4' AND storeid = '$defaultuserstore' AND assigneduser = '$ipofpc' AND DATE_SUB(NOW(), INTERVAL 1 MONTH) < dropdate ORDER BY dropdate ASC";
}
}

if($touchview == 6) {
if($statusview == 0) {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus = '6' AND storeid = '$defaultuserstore' ORDER BY workarea, dropdate ASC";
} elseif($statusview == 1) {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus = '6' AND storeid = '$defaultuserstore' AND assigneduser = '$ipofpc' ORDER BY workarea, dropdate ASC";
} elseif($statusview == 2) {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus = '6' AND storeid = '$defaultuserstore' ORDER BY workarea, dropdate ASC";
} else {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus = '6' AND storeid = '$defaultuserstore' AND assigneduser = '$ipofpc' ORDER BY workarea, dropdate ASC";
}
}

if($touchview == 7) {
if($statusview == 0) {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus = '7' AND storeid = '$defaultuserstore' ORDER BY workarea, dropdate ASC";
} elseif($statusview == 1) {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus = '7' AND storeid = '$defaultuserstore' AND assigneduser = '$ipofpc' ORDER BY workarea, dropdate ASC";
} elseif($statusview == 2) {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus = '7' AND storeid = '$defaultuserstore' ORDER BY workarea, dropdate ASC";
} else {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus = '7' AND storeid = '$defaultuserstore' AND assigneduser = '$ipofpc' ORDER BY workarea, dropdate ASC";
}
}

if($touchview == 0) {
if($statusview == 0) {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus != '5' AND pcstatus != '7' AND pcstatus != '0' AND storeid = '$defaultuserstore' AND ((sked = '0') OR (sked = '1' AND DATE_ADD('$daystart', INTERVAL 2 DAY) > skeddate)) ORDER BY dropdate ASC";
} elseif($statusview == 1) {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus != '5' AND pcstatus != '7' AND pcstatus != '0' AND storeid = '$defaultuserstore' AND assigneduser = '$ipofpc' AND ((sked = '0') OR (sked = '1' AND DATE_ADD('$daystart', INTERVAL 2 DAY) > skeddate)) ORDER BY dropdate ASC";
} elseif($statusview == 2) {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus != '5' AND pcstatus != '7' AND pcstatus != '0' AND storeid = '$defaultuserstore' AND sked = '1' ORDER BY skeddate ASC";
} else {
$rs_fetchwo = "SELECT * FROM pc_wo WHERE pcstatus != '5' AND pcstatus != '7' AND pcstatus != '0' AND storeid = '$defaultuserstore' AND assigneduser = '$ipofpc' AND sked = '1' ORDER BY skeddate ASC";
}
}


#####

$rs_result_n5 = mysqli_query($rs_connect, $rs_fetchwo);
$totalpcsonbench = mysqli_num_rows($rs_result_n5);

$cellwide = floor((100 / $touchwide));


####

$rs_qc = "SELECT * FROM boxstyles";
$rs_result1 = mysqli_query($rs_connect, $rs_qc);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$statusid = "$rs_result_q1->statusid";
$selectorcolor = "$rs_result_q1->selectorcolor";
$boxtitle = "$rs_result_q1->boxtitle";
$selectorcolors[$statusid] = "$selectorcolor";
$boxtitles[$statusid] = "$boxtitle";
}


if($touchview == 0) {
$lighter = "#333333";
} else {
$lighter = adjustBrightness("$selectorcolors[$touchview]", 75);
}


$touchback = <<<TOUCHBACK
background: linear-gradient($lighter 0%,#ffffff 100%);
width:100%;
border-collapse:collapse;
TOUCHBACK;

#####



$boxstylegb = getboxstyle(50);



$a = $touchwide;

echo "<table style=\"$touchback;\">";

echo "<tr><td colspan=$touchwide align=center>";

echo "<table style=\"width:97%;\"><tr><td style=\"text-align:left;\">";
echo "<button TYPE=button onClick=\"parent.location='index.php'\" class=\"linkbutton2x linkbuttongray radiusall\"><i class=\"fa fa-arrow-circle-left\"></i> ".pcrtlang("Repair")."</button>";
echo "</td><td style=\"text-align:center;\">";

$boxstyle1 = getboxstyle(2);
$boxstyle8 = getboxstyle(8);
$boxstyle9 = getboxstyle(9);

echo "<INPUT TYPE=button value=\"$boxtitles[2]\" onClick=\"parent.location='touch.php?func=settouchview&settouchview=2'\" class=\"linkbutton2x radiusall textoutline\" style=\"background:#$boxstyle1[selectorcolor];color:white\">&nbsp;&nbsp;";

echo "<INPUT TYPE=button value=\"$boxtitles[8]\" onClick=\"parent.location='touch.php?func=settouchview&settouchview=8'\" class=\"linkbutton2x radiusall textoutline\" style=\"background:#$boxstyle8[selectorcolor];color:white\">&nbsp;&nbsp;";

echo "<INPUT TYPE=button value=\"$boxtitles[9]\" onClick=\"parent.location='touch.php?func=settouchview&settouchview=9'\" 
class=\"linkbutton2x radiusall textoutline\" style=\"background:#$boxstyle9[selectorcolor];color:white\"> ";

echo "<INPUT TYPE=button value=\"".pcrtlang("All")."\" onClick=\"parent.location='touch.php?func=settouchview&settouchview=0'\"
class=\"linkbutton2x radiusall linkbuttongray\">";

echo "<td><td style=\"text-align:right;\">";

echo "<button TYPE=button onClick=\"parent.location='../store/cart.php'\" class=\"linkbutton2x linkbuttongray radiusall\">".pcrtlang("Sale")." <i class=\"fa fa-arrow-circle-right\"></i></button>";

echo "</td></tr></table>";

echo "</td></tr>";

echo "<tr><td>\n\n";

echo "<div class=\"flextouch-container\">";

while($rs_result_qn5 = mysqli_fetch_object($rs_result_n5)) {
$custnotes5 = "$rs_result_qn5->custnotes";
$thepass5 = "$rs_result_qn5->thepass";
$pcid = "$rs_result_qn5->pcid";
$woid = "$rs_result_qn5->woid";
$workarea = "$rs_result_qn5->workarea";
$pcpriorityindb = "$rs_result_qn5->pcpriority";
$skeddate = "$rs_result_qn5->skeddate";
$sked = "$rs_result_qn5->sked";
$pcstatus = "$rs_result_qn5->pcstatus";
$servicepromiseid = "$rs_result_qn5->servicepromiseid";
$promisedtime = "$rs_result_qn5->promisedtime";
$pickupdate = "$rs_result_qn5->pickupdate";

if ($pcpriorityindb != "") {
$picon = $pcpriority[$pcpriorityindb];
} else {
$picon = "";
}

$storeworkareas = array();

$rs_qb = "SELECT * FROM benches";
$rs_resultb = mysqli_query($rs_connect, $rs_qb);
while($rs_result_qb = mysqli_fetch_object($rs_resultb)) {
$benchid = "$rs_result_qb->benchid";
$benchname = "$rs_result_qb->benchname";
$benchcolor = "$rs_result_qb->benchcolor";
$storeworkareas[$benchname] = $benchcolor;
}

if ($workarea == "") {
$bgcolor = "eeeeee";
$thebench = "";
} else {
$bgcolor = $storeworkareas["$workarea"];
$thebench = "<span class=floatright style=\"padding:8px;\"><i class=\"fa fa-plug fa-lg\"></i> $workarea</span>";
}


$rs_findowner = "SELECT * FROM pc_owner WHERE pcid = '$pcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
while($rs_result_q2 = mysqli_fetch_object($rs_result2)) {
$pcname = "$rs_result_q2->pcname";
$pcmake = "$rs_result_q2->pcmake";
$mainassettypeidindb = "$rs_result_q2->mainassettypeid";
$mainassettype = getassettypename($mainassettypeidindb);

$rs_findpic = "SELECT * FROM assetphotos WHERE pcid = '$pcid' AND highlight = '1'";
$rs_resultpic2 = mysqli_query($rs_connect, $rs_findpic);


echo "\n\n<div class=\"flextouch-item\" style=\"border-bottom:#$bgcolor 7px solid;position:relative\">";

if($touchview == 0) {
#wip
$boxstylearray = getboxstyle($pcstatus);
$boxtitle = getboxtitles($pcstatus);
echo "<span style=\"background:#$boxstylearray[selectorcolor];margin-left:-10px;padding:4px;\" class=radiusright><span class=\"colormewhite textoutline\">$boxtitle[$pcstatus]</span></span><br><br>";
}

echo "<table style=\"width:100%\"><tr><td style=\"text-align:center;\">";



$pcname2 = urlencode($pcname);

echo "<a href=\"touch.php?func=record&woid=$woid&pcid=$pcid&pcname=$pcname2\" class=\"imagelink\">";



if (mysqli_num_rows($rs_resultpic2) != "0") {
$rs_resultpic_q2 = mysqli_fetch_object($rs_resultpic2);
$assetphotoid = "$rs_resultpic_q2->assetphotoid";
echo "<img src=pc.php?func=getpcimage&photoid=$assetphotoid border=0 width=128><br>";
} else {
$largeicon = brandicon("$pcmake $mainassettype");
echo "<img src=images/pcs/$largeicon border=0>";
}
echo "</a>";


if (mysqli_num_rows($rs_resultpic2) != "0") {
$medicon = brandicon("$pcmake");
echo "<img src=images/pcs/$medicon border=0 width=64>";
echo "<br>";
}


echo "</td><td style=\"text-align:center;\">";

echo "<span class=\"sizemelarger boldme\">$pcname</span>";

if ($picon != "") {
echo " <img src=images/$picon align=absmiddle>";
}

echo "<br>";


if ($workarea != "") {
echo "<i class=\"fa fa-plug fa-lg\"></i>&nbsp;$workarea&nbsp;<br>";
}


echo " <i class=\"fa fa-tag fa-lg\"></i> $pcid <i class=\"fa fa-clipboard fa-lg\"></i> $woid<br>";


echo "<br><span class=sizemelarger>$pcmake<br></span>";


if($sked == 1) {
echo "<img src=images/clock.png style=\"vertical-align:middle\"> ";
skedwhen("$skeddate");
echo "<br>";
}

if(($servicepromiseid != 0) && ($pickupdate == "0000-00-00 00:00:00")) {
echo servicepromiseicon("$promisedtime","label");
echo "<br>";
}


$rs_findcreds = "SELECT * FROM creds WHERE pcid = '$pcid' AND credtype < '3' ORDER BY creddate DESC";
$rs_result_creds = mysqli_query($rs_connect, $rs_findcreds);
while($rs_result_qcreds = mysqli_fetch_object($rs_result_creds)) {
$creddesc = "$rs_result_qcreds->creddesc";
$creduser = "$rs_result_qcreds->creduser";
$credpass = "$rs_result_qcreds->credpass";
$credtype = "$rs_result_qcreds->credtype";
$patterndata = "$rs_result_qcreds->patterndata";
if($credtype == 1) {
echo "<br><span class=\"sizeme16 boldme\">$creddesc: <br><i class=\"fa fa-user\"></i> $creduser <i class=\"fa fa-key\"></i> $credpass</span>";
} else {
echo "<br><span class=\"sizeme16 boldme\">$creddesc: <br><i class=\"fa fa-thumb-tack\"></i> $credpass</span>";
}
}

$rs_findcreds = "SELECT * FROM creds WHERE pcid = '$pcid' AND credtype = '3' ORDER BY creddate DESC";
$rs_result_creds = mysqli_query($rs_connect, $rs_findcreds);
require_once("patterns.php");
while($rs_result_qcreds = mysqli_fetch_object($rs_result_creds)) {
$creddesc = "$rs_result_qcreds->creddesc";
$patterndata = "$rs_result_qcreds->patterndata";
echo "<br><br><span class=sizeme10>$creddesc:</span><br>";
echo draw3x3("$patterndata","small");
}





echo "</td>";


#echo "<td>";

#echo "<span style=\"float:right;\">";
#echo "<a href=\"touch.php?func=record&woid=$woid&pcid=$pcid&pcname=$pcname2\" class=\"barlinkstatus\" style=\"background:#777777;\"> 
#<i class=\"fa fa-hand-o-up fa-lg\"></i> </a><br><br>";

#echo "<a href=\"index.php?pcwo=$woid\" class=\"barlinkstatus\" style=\"background:#777777;\"> <i class=\"fa fa-edit fa-lg\"></i> </a>";

#echo "</span>";
#echo "</td>";
echo "</tr>";

echo "</table>";

echo "<br><br><div class=\"linkbuttongraycontainer\" style=\"bottom:0px;left:0px;position:absolute;width:100%;\">";

echo "<a href=\"touch.php?func=record&woid=$woid&pcid=$pcid&pcname=$pcname2\" class=\"linkbuttonmedium linkbuttongray\">
<i class=\"fa fa-hand-o-up fa-lg\"></i> ".pcrtlang("touch edit")."</a>";

echo "<a href=\"index.php?pcwo=$woid\" class=\"linkbuttonmedium linkbuttongray\"> <i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("edit")."</a>";

echo "$thebench";

echo "</div>";

echo "</div>\n\n";

}

}


echo "</div>";

echo "</td></tr></table>";
echo "<br><br><center>";

$statuscolors = getstatusselectorcolors();
$boxtitles = getboxtitles();

$coptions = "";
$rs_qc = "SELECT * FROM boxstyles WHERE statusid > 99";
$rs_result1 = mysqli_query($rs_connect, $rs_qc);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$statusid = "$rs_result_q1->statusid";
$selectorcolor2 = "$rs_result_q1->selectorcolor";
$boxtitle2 = "$rs_result_q1->boxtitle";
if ($statusid == $touchview) {
$coptions .= "<option selected value=\"$statusid\" class=touchstatusdrop style=\"background:#$selectorcolor2\">$boxtitle2</option>";
} else {
$coptions .= "<option value=\"$statusid\" class=touchstatusdrop style=\"background:#$selectorcolor2\">$boxtitle2</option>";
}
}


echo "<form action=touch.php?func=settouchview method=post><span class=sizeme2x>".pcrtlang("All Status Views").":</span><select name=settouchview class=touchstatusdropselector onchange='this.form.submit()'>";
if ($touchview == 1) {
echo "<option selected value=1 class=touchstatusdrop style=\"background:#$statuscolors[1]\">$boxtitles[1]</option>";
} else {
echo "<option value=1 class=touchstatusdrop style=\"background:#$statuscolors[1]\">$boxtitles[1]</option>";
}
if ($touchview == 2) {
echo "<option selected value=2 class=touchstatusdrop style=\"background:#$statuscolors[2]\">$boxtitles[2]</option>";
} else {
echo "<option value=2 class=touchstatusdrop style=\"background:#$statuscolors[2]\">$boxtitles[2]</option>";
}
if ($touchview == 8) {
echo "<option selected value=8 class=touchstatusdrop style=\"background:#$statuscolors[8]\">$boxtitles[8]</option>";
} else {
echo "<option value=8 class=touchstatusdrop style=\"background:#$statuscolors[8]\">$boxtitles[8]</option>";
}
if ($touchview == 9) {
echo "<option selected value=9 class=touchstatusdrop style=\"background:#$statuscolors[9]\">$boxtitles[9]</option>";
} else {
echo "<option value=9 class=touchstatusdrop style=\"background:#$statuscolors[9]\">$boxtitles[9]</option>";
}

if ($touchview == 3) {
echo "<option selected value=3 class=touchstatusdrop style=\"background:#$statuscolors[3]\">$boxtitles[3]</option>";
} else {
echo "<option value=3 class=touchstatusdrop style=\"background:#$statuscolors[3]\">$boxtitles[3]</option>";
}
if ($touchview == 4) {
echo "<option selected value=4 class=touchstatusdrop style=\"background:#$statuscolors[4]\">$boxtitles[4]</option>";
} else {
echo "<option value=4 class=touchstatusdrop style=\"background:#$statuscolors[4]\">$boxtitles[4]</option>";
}
if ($touchview == 6) {
echo "<option selected value=6 class=touchstatusdrop style=\"background:#$statuscolors[6]\">$boxtitles[6]</option>";
} else {
echo "<option value=6 class=touchstatusdrop style=\"background:#$statuscolors[6]\">$boxtitles[6]</option>";
}
if ($touchview == 7) {
echo "<option selected value=7 class=touchstatusdrop style=\"background:#$statuscolors[7]\">$boxtitles[7]</option>";
} else {
echo "<option value=7 class=touchstatusdrop style=\"background:#$statuscolors[7]\">$boxtitles[7]</option>";
}

echo "$coptions";

echo "</select></form>";


#####

if ($statusview == 0) {
$viewdisabled0 = "disabled class=progbuttonoff";
$viewdisabled1 = "class=progbutton";
$viewdisabled2 = "class=progbutton";
$viewdisabled3 = "class=progbutton";
} elseif ($statusview == 1) {
$viewdisabled0 = "class=progbutton";
$viewdisabled1 = "disabled class=progbuttonoff";
$viewdisabled2 = "class=progbutton";
$viewdisabled3 = "class=progbutton";
} elseif ($statusview == 2) {
$viewdisabled0 = "class=progbutton";
$viewdisabled1 = "class=progbutton";
$viewdisabled2 = "disabled class=progbuttonoff";
$viewdisabled3 = "class=progbutton";
} else {
$viewdisabled0 = "class=progbutton";
$viewdisabled1 = "class=progbutton";
$viewdisabled2 = "class=progbutton";
$viewdisabled3 = "disabled class=progbuttonoff";
}


if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}

$daystart = date('Y-m-d')." 00:00:00";


if($touchview == '4') {
$rs_findtotalpcs = "SELECT * FROM pc_wo WHERE storeid = '$defaultuserstore' AND pcstatus = '$touchview' AND DATE_SUB(NOW(), INTERVAL 1 MONTH) < dropdate";
} elseif($touchview == '6') {
$rs_findtotalpcs = "SELECT * FROM pc_wo WHERE storeid = '$defaultuserstore' AND pcstatus = '$touchview'";
} elseif($touchview == '0') {
$rs_findtotalpcs = "SELECT * FROM pc_wo WHERE storeid = '$defaultuserstore' AND pcstatus != '5' AND pcstatus != '7' AND pcstatus != '0'";
} else {
$rs_findtotalpcs = "SELECT * FROM pc_wo WHERE storeid = '$defaultuserstore' AND pcstatus = '$touchview' AND ((DATE_ADD('$daystart', INTERVAL 2 DAY) > skeddate) OR (sked = 0))";
}

if($touchview == '4') {
$rs_findtotalpcsuser = "SELECT * FROM pc_wo WHERE storeid = '$defaultuserstore' AND pcstatus = '$touchview' AND DATE_SUB(NOW(), INTERVAL 1 MONTH) < dropdate AND assigneduser = '$ipofpc'";
} elseif($touchview == '6') {
$rs_findtotalpcsuser = "SELECT * FROM pc_wo WHERE storeid = '$defaultuserstore' AND pcstatus = '$touchview' AND assigneduser = '$ipofpc'";
} elseif($touchview == '0') {
$rs_findtotalpcsuser = "SELECT * FROM pc_wo WHERE storeid = '$defaultuserstore' AND pcstatus != '5' AND pcstatus != '7' AND pcstatus != '0' AND assigneduser = '$ipofpc'";
} else {
$rs_findtotalpcsuser = "SELECT * FROM pc_wo WHERE storeid = '$defaultuserstore' AND pcstatus = '$touchview' AND assigneduser = '$ipofpc' AND ((DATE_ADD('$daystart', INTERVAL 2 DAY) > skeddate) OR (sked = 0))";
}


if($touchview == '4') {
$rs_findtotalpcs_sked = "SELECT * FROM pc_wo WHERE storeid = '$defaultuserstore' AND pcstatus = '$touchview' AND DATE_SUB(NOW(), INTERVAL 1 MONTH) < dropdate";
} elseif($touchview == '6') {
$rs_findtotalpcs_sked = "SELECT * FROM pc_wo WHERE storeid = '$defaultuserstore' AND pcstatus = '$touchview'";
} elseif($touchview == '0') {
$rs_findtotalpcs_sked = "SELECT * FROM pc_wo WHERE storeid = '$defaultuserstore' AND pcstatus != '5' AND pcstatus != '7' AND pcstatus != '0' AND sked = '1'";
} else {
$rs_findtotalpcs_sked = "SELECT * FROM pc_wo WHERE storeid = '$defaultuserstore' AND pcstatus = '$touchview' AND sked = '1'";
}


if($touchview == '4') {
$rs_findtotalpcsuser_sked = "SELECT * FROM pc_wo WHERE storeid = '$defaultuserstore' AND pcstatus = '$touchview' AND assigneduser = '$ipofpc' AND DATE_SUB(NOW(), INTERVAL 1 MONTH) < dropdate";
} elseif($touchview == '6') {
$rs_findtotalpcsuser_sked = "SELECT * FROM pc_wo WHERE storeid = '$defaultuserstore' AND pcstatus = '$touchview' AND assigneduser = '$ipofpc'";
} elseif($touchview == '0') {
$rs_findtotalpcsuser_sked = "SELECT * FROM pc_wo WHERE storeid = '$defaultuserstore' AND pcstatus != '5' AND pcstatus != '7' AND pcstatus != '0' AND assigneduser = '$ipofpc' AND sked = '1' ";
} else {
$rs_findtotalpcsuser_sked = "SELECT * FROM pc_wo WHERE storeid = '$defaultuserstore' AND pcstatus = '$touchview' AND sked = '1' AND assigneduser = '$ipofpc'";
}


$rs_result_tot = mysqli_query($rs_connect, $rs_findtotalpcs);
$totalpcss_total = mysqli_num_rows($rs_result_tot);

$rs_result_tot_user = mysqli_query($rs_connect, $rs_findtotalpcsuser);
$totalpcssu_total = mysqli_num_rows($rs_result_tot_user);

$rs_result_tot_sked = mysqli_query($rs_connect, $rs_findtotalpcs_sked);
$totalpcss_sked_total = mysqli_num_rows($rs_result_tot_sked);

$rs_result_tot_user_sked = mysqli_query($rs_connect, $rs_findtotalpcsuser_sked);
$totalpcssu_sked_total = mysqli_num_rows($rs_result_tot_user_sked);


echo "<div style=\"text-align:center; width:100%; margin-right:auto; margin-left:auto; padding:4px; white-space:nowrap;\">\n";
echo "<button $viewdisabled0 onClick=\"parent.location='pc.php?func=changestatusview&view=0&touch=touch'\"><img src=images/prog_store.png style=\"vertical-align:middle;\"> $totalpcss_total</button>\n ";
echo "<button $viewdisabled1 onClick=\"parent.location='pc.php?func=changestatusview&view=1&touch=touch'\"><img src=images/prog_user.png style=\"vertical-align:middle;\"> $totalpcssu_total</button>\n ";
echo "<button $viewdisabled2 onClick=\"parent.location='pc.php?func=changestatusview&view=2&touch=touch'\"><img src=images/prog_store_sked.png style=\"vertical-align:middle;\"> $totalpcss_sked_total</button>\n ";
echo "<button $viewdisabled3 onClick=\"parent.location='pc.php?func=changestatusview&view=3&touch=touch'\"><img src=images/prog_user_sked.png style=\"vertical-align:middle;\"> $totalpcssu_sked_total</button>\n";
echo "</div>";



#####



echo "</center>";


require("footerstatus.php");

}

function stat_change() {
require_once("validate.php");
require("deps.php");
require("common.php");


$statnum = $_REQUEST['statnum'];
$woid = $_REQUEST['woid'];

$boxtitles = getboxtitles();

$switchedto = pcrtlang("Switched to");

userlog(32,$woid,'woid',"$switchedto &lt;$boxtitles[$statnum]&gt;");




$rs_insert = "UPDATE pc_wo SET pcstatus = '$statnum' WHERE woid = '$woid'";
@mysqli_query($rs_connect, $rs_insert);

if ($statnum == 4) {
if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');
$rs_update = "UPDATE pc_wo SET readydate = '$currentdatetime' WHERE woid = '$woid'";
@mysqli_query($rs_connect, $rs_update);
}

header("Location: touch.php?func=record&woid=$woid");

}


function wochecks() {

$pcwo = $_REQUEST['woid'];

require_once("deps.php");
require_once("touchheader.php");
require_once("common.php");


$rs_findpcid = "SELECT * FROM pc_wo WHERE woid = '$woid'";
$rs_result1 = mysqli_query($rs_connect, $rs_findpcid);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$pcid = "$rs_result_q1->pcid";
$wochecks = "$rs_result_q1->wochecks";



$rs_findowner = "SELECT * FROM pc_owner WHERE pcid = '$pcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
$rs_result_q2 = mysqli_fetch_object($rs_result2);
$mainassettypeidindb = "$rs_result_q2->mainassettypeid";


$rs_sq = "SELECT * FROM mainassettypes WHERE mainassettypeid = '$mainassettypeidindb'";
$rs_result1 = mysqli_query($rs_connect, $rs_sq);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$mainassetchecksindb = serializedarraytest("$rs_result_q1->mainassetchecks");


if(count($mainassetchecksindb) > 0) {

start_box();


$wochecks = serializedarraytest("$wochecks");


echo "<table class=standard>";

echo "<tr><th colspan=2>".pcrtlang("Pre Checks")."</th><th colspan=2>".pcrtlang("Post Checks")."</th></tr>";

#wip
$rs_checks = "SELECT * FROM checks";
$rs_checksq = mysqli_query($rs_connect, $rs_checks);
while($rs_result_cq = mysqli_fetch_object($rs_checksq)) {
$checkid = "$rs_result_cq->checkid";
$checkname = "$rs_result_cq->checkname";


if (in_array($checkid, $mainassetchecksindb)) {

if(array_key_exists("$checkid", $wochecks)) {
if(isset($wochecks[$checkid][0])) {
$precheck = $wochecks[$checkid][0];
} else {
$precheck = 0;
}

if(isset($wochecks[$checkid][1])) {
$postcheck = $wochecks[$checkid][1];
} else {
$postcheck = 0;
}
} else {
$precheck = 0;
$postcheck = 0;
}

# not checked = 0, not applicable = 1, pass = 2, fail = 3

echo "<tr><td>$checkname</td><td>";
if($precheck == 0) {
echo "<a href=touch.php?func=setcheck&checktype=0&checkvalue=0&woid=$pcwo&checkid=$checkid class=\"linkbuttonmedium linkbuttonblack radiusleft nopointerevents\">
<i class=\"fa fa-square-o  fa-lg\"></i></a>";
echo "<a href=touch.php?func=setcheck&checktype=0&checkvalue=1&woid=$pcwo&checkid=$checkid class=\"linkbuttonmedium linkbuttongray\">
<i class=\"fa fa-minus fa-lg\"></i></a>";
echo "<a href=touch.php?func=setcheck&checktype=0&checkvalue=2&woid=$pcwo&checkid=$checkid class=\"linkbuttonmedium linkbuttongray\">
<i class=\"fa fa-check fa-lg\"></i></a>";
echo "<a href=touch.php?func=setcheck&checktype=0&checkvalue=3&woid=$pcwo&checkid=$checkid class=\"linkbuttonmedium linkbuttongray radiusright\">
<i class=\"fa fa-warning fa-lg\"></i></a>";
} elseif($precheck == 1) {
echo "<a href=touch.php?func=setcheck&checktype=0&checkvalue=0&woid=$pcwo&checkid=$checkid class=\"linkbuttonmedium linkbuttongray radiusleft\">
<i class=\"fa fa-square-o  fa-lg\"></i></a>";
echo "<a href=touch.php?func=setcheck&checktype=0&checkvalue=1&woid=$pcwo&checkid=$checkid class=\"linkbuttonmedium linkbuttonblack nopointerevents\">
<i class=\"fa fa-minus fa-lg\"></i></a>";
echo "<a href=touch.php?func=setcheck&checktype=0&checkvalue=2&woid=$pcwo&checkid=$checkid class=\"linkbuttonmedium linkbuttongray\">
<i class=\"fa fa-check fa-lg\"></i></a>";
echo "<a href=touch.php?func=setcheck&checktype=0&checkvalue=3&woid=$pcwo&checkid=$checkid class=\"linkbuttonmedium linkbuttongray radiusright\">
<i class=\"fa fa-warning fa-lg\"></i></a>";
} elseif($precheck == 2) {
echo "<a href=touch.php?func=setcheck&checktype=0&checkvalue=0&woid=$pcwo&checkid=$checkid class=\"linkbuttonmedium linkbuttongray radiusleft\">
<i class=\"fa fa-square-o  fa-lg\"></i></a>";
echo "<a href=touch.php?func=setcheck&checktype=0&checkvalue=1&woid=$pcwo&checkid=$checkid class=\"linkbuttonmedium linkbuttongray\">
<i class=\"fa fa-minus fa-lg\"></i></a>";
echo "<a href=touch.php?func=setcheck&checktype=0&checkvalue=2&woid=$pcwo&checkid=$checkid class=\"linkbuttonmedium linkbuttongreen nopointerevents\">
<i class=\"fa fa-check fa-lg\"></i></a>";
echo "<a href=touch.php?func=setcheck&checktype=0&checkvalue=3&woid=$pcwo&checkid=$checkid class=\"linkbuttonmedium linkbuttongray radiusright\">
<i class=\"fa fa-warning fa-lg\"></i></a>";
} elseif($precheck == 3) {
echo "<a href=touch.php?func=setcheck&checktype=0&checkvalue=0&woid=$pcwo&checkid=$checkid class=\"linkbuttonmedium linkbuttongray radiusleft\">
<i class=\"fa fa-square-o fa-lg\"></i></a>";
echo "<a href=touch.php?func=setcheck&checktype=0&checkvalue=1&woid=$pcwo&checkid=$checkid class=\"linkbuttonmedium linkbuttongray\">
<i class=\"fa fa-minus fa-lg\"></i></a>";
echo "<a href=touch.php?func=setcheck&checktype=0&checkvalue=2&woid=$pcwo&checkid=$checkid class=\"linkbuttonmedium linkbuttongray\">
<i class=\"fa fa-check fa-lg\"></i></a>";
echo "<a href=touch.php?func=setcheck&checktype=0&checkvalue=3&woid=$pcwo&checkid=$checkid class=\"linkbuttonmedium linkbuttonred radiusright nopointerevents\">
<i class=\"fa fa-warning fa-lg\"></i></a>";
} else {
}


echo "</td><td>$checkname</td><td>";

if($postcheck == 0) {
echo "<a href=touch.php?func=setcheck&checktype=1&checkvalue=0&woid=$pcwo&checkid=$checkid class=\"linkbuttonmedium linkbuttonblack radiusleft nopointerevents\">
<i class=\"fa fa-square-o  fa-lg\"></i></a>";
echo "<a href=touch.php?func=setcheck&checktype=1&checkvalue=1&woid=$pcwo&checkid=$checkid class=\"linkbuttonmedium linkbuttongray\">
<i class=\"fa fa-minus fa-lg\"></i></a>";
echo "<a href=touch.php?func=setcheck&checktype=1&checkvalue=2&woid=$pcwo&checkid=$checkid class=\"linkbuttonmedium linkbuttongray\">
<i class=\"fa fa-check fa-lg\"></i></a>";
echo "<a href=touch.php?func=setcheck&checktype=1&checkvalue=3&woid=$pcwo&checkid=$checkid class=\"linkbuttonmedium linkbuttongray radiusright\">
<i class=\"fa fa-warning fa-lg\"></i></a>";
} elseif($postcheck == 1) {
echo "<a href=touch.php?func=setcheck&checktype=1&checkvalue=0&woid=$pcwo&checkid=$checkid class=\"linkbuttonmedium linkbuttongray radiusleft\">
<i class=\"fa fa-square-o  fa-lg\"></i></a>";
echo "<a href=touch.php?func=setcheck&checktype=1&checkvalue=1&woid=$pcwo&checkid=$checkid class=\"linkbuttonmedium linkbuttonblack nopointerevents\">
<i class=\"fa fa-minus fa-lg\"></i></a>";
echo "<a href=touch.php?func=setcheck&checktype=1&checkvalue=2&woid=$pcwo&checkid=$checkid class=\"linkbuttonmedium linkbuttongray\">
<i class=\"fa fa-check fa-lg\"></i></a>";
echo "<a href=touch.php?func=setcheck&checktype=1&checkvalue=3&woid=$pcwo&checkid=$checkid class=\"linkbuttonmedium linkbuttongray radiusright\">
<i class=\"fa fa-warning fa-lg\"></i></a>";
} elseif($postcheck == 2) {
echo "<a href=touch.php?func=setcheck&checktype=1&checkvalue=0&woid=$pcwo&checkid=$checkid class=\"linkbuttonmedium linkbuttongray radiusleft\">
<i class=\"fa fa-square-o  fa-lg\"></i></a>";
echo "<a href=touch.php?func=setcheck&checktype=1&checkvalue=1&woid=$pcwo&checkid=$checkid class=\"linkbuttonmedium linkbuttongray\">
<i class=\"fa fa-minus fa-lg\"></i></a>";
echo "<a href=touch.php?func=setcheck&checktype=1&checkvalue=2&woid=$pcwo&checkid=$checkid class=\"linkbuttonmedium linkbuttongreen nopointerevents\">
<i class=\"fa fa-check fa-lg\"></i></a>";
echo "<a href=touch.php?func=setcheck&checktype=1&checkvalue=3&woid=$pcwo&checkid=$checkid class=\"linkbuttonmedium linkbuttongray radiusright\">
<i class=\"fa fa-warning fa-lg\"></i></a>";
} elseif($postcheck == 3) {
echo "<a href=touch.php?func=setcheck&checktype=1&checkvalue=0&woid=$pcwo&checkid=$checkid class=\"linkbuttonmedium linkbuttongray radiusleft\">
<i class=\"fa fa-square-o fa-lg\"></i></a>";
echo "<a href=touch.php?func=setcheck&checktype=1&checkvalue=1&woid=$pcwo&checkid=$checkid class=\"linkbuttonmedium linkbuttongray\">
<i class=\"fa fa-minus fa-lg\"></i></a>";
echo "<a href=touch.php?func=setcheck&checktype=1&checkvalue=2&woid=$pcwo&checkid=$checkid class=\"linkbuttonmedium linkbuttongray\">
<i class=\"fa fa-check fa-lg\"></i></a>";
echo "<a href=touch.php?func=setcheck&checktype=1&checkvalue=3&woid=$pcwo&checkid=$checkid class=\"linkbuttonmedium linkbuttonred radiusright nopointerevents\">
<i class=\"fa fa-warning fa-lg\"></i></a>";
} else {

}

echo "</td></tr>";
}

}


echo "</table>";

stop_box();

echo "<br>";

}


require_once("touchheader.php");
}


function setcheck() {

require("deps.php");
require("common.php");

$checkid = $_REQUEST['checkid'];
$woid = $_REQUEST['woid'];
$checktype = $_REQUEST['checktype'];
$checkvalue = $_REQUEST['checkvalue'];

require_once("validate.php");

$rs_findpc = "SELECT * FROM pc_wo WHERE woid = '$woid'";
$rs_result = mysqli_query($rs_connect, $rs_findpc);
$rs_result_q = mysqli_fetch_object($rs_result);
$wochecks = serializedarraytest("$rs_result_q->wochecks");

$wochecks[$checkid][$checktype] = $checkvalue;

if($checkvalue == 1) {
$wochecks[$checkid][0] = 1;
$wochecks[$checkid][1] = 1;
} else {
$wochecks[$checkid][$checktype] = $checkvalue;
}

$wochecksins = serialize($wochecks);

#wip

$set_wc = "UPDATE pc_wo SET wochecks = '$wochecksins' WHERE woid = '$woid'";
@mysqli_query($rs_connect, $set_wc);

header("Location: touch.php?func=wochecks&woid=$woid");

}



switch($func) {
                                                                                                    
    default:
    status();
    break;
                                
    case "record":
    record();
    break;

    case "recordscan1":
    recordscan1();
    break;
                                   
    case "add_scan":
    add_scan();
    break;

    case "add_scan2":
    add_scan2();
    break;

   case "del_scan":
    del_scan();
    break;


    case "recordscan2":
    recordscan2();
    break;

    case "status":
    status();
    break;

  case "settouchview":
    settouchview();
    break;

  case "notes":
    notes();
    break;

  case "stat_change":
    stat_change();
    break;

  case "wochecks":
    wochecks();
    break;

  case "setcheck":
    setcheck();
    break;


}

