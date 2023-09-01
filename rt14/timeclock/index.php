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
                                                                                                    
function clock() {

if (array_key_exists('punchresult',$_REQUEST)) {
if (array_key_exists('lastactionpunch',$_REQUEST)) {
$lastactionpunch = $_REQUEST['lastactionpunch'];
} else {
$lastactionpunch = "";
}
$lastactionwho = $_REQUEST['lastactionwho'];
if (array_key_exists('lastactiontime',$_REQUEST)) {
$lastactiontime = $_REQUEST['lastactiontime'];
} else {
$lastactiontime = "";
}

if (array_key_exists('error',$_REQUEST)) {
$error = $_REQUEST['error'];
} else {
$error = "";
}
$punchresult = $_REQUEST['punchresult'];
} else {
$punchresult = "";
}


require("deps.php");
require("common.php");
require("headerstatus.php");       


$vip = $_SERVER['REMOTE_ADDR'];
if(filter_var($vip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
$vip2 = explode('.',$vip);
$ins_newip = "$vip2[0].$vip2[1].$vip2[2]";
$rs_update_ip = "UPDATE allowedip SET lastaccess = NOW() WHERE ipaddress = '$ins_newip'";
@mysqli_query($rs_connect, $rs_update_ip);
}




       
echo "<FORM name=clockform method=post action=index.php?func=punch>";

?>

<table style="margin-left:auto;margin-right:auto"><tr><td>
<TABLE style="margin-left:auto;margin-right:auto">
<TR>
<TD><center>
<INPUT TYPE="text" NAME="Input" id="Input" Size="10" class=textboxbig style="text-align:center;"></center>

<SCRIPT language="JavaScript">
$("#Input").focus();

$("#Input").blur(function() {
    setTimeout(function() { $("#Input").focus(); }, 800);
});

</script>

</TD>
</TR>
<TR>
<TD>
<center>
<INPUT class=bigbuttontimeclock TYPE="button" NAME="one"   VALUE=" 1 " OnClick="clockform.Input.value += '1'" OnMouseDown = "this.className='bigbuttonpressedtimeclock'" OnMouseUp="this.className='bigbuttontimeclock'">
<INPUT class=bigbuttontimeclock TYPE="button" NAME="two"   VALUE=" 2 " OnCLick="clockform.Input.value += '2'" OnMouseDown = "this.className='bigbuttonpressedtimeclock'" OnMouseUp="this.className='bigbuttontimeclock'">
<INPUT class=bigbuttontimeclock TYPE="button" NAME="three" VALUE=" 3 " OnClick="clockform.Input.value += '3'" OnMouseDown = "this.className='bigbuttonpressedtimeclock'" OnMouseUp="this.className='bigbuttontimeclock'">
</center></td></tr><tr><td><center>
<INPUT class=bigbuttontimeclock TYPE="button" NAME="four"  VALUE=" 4 " OnClick="clockform.Input.value += '4'" OnMouseDown = "this.className='bigbuttonpressedtimeclock'" OnMouseUp="this.className='bigbuttontimeclock'">
<INPUT class=bigbuttontimeclock TYPE="button" NAME="five"  VALUE=" 5 " OnCLick="clockform.Input.value += '5'" OnMouseDown = "this.className='bigbuttonpressedtimeclock'" OnMouseUp="this.className='bigbuttontimeclock'">
<INPUT class=bigbuttontimeclock TYPE="button" NAME="six"   VALUE=" 6 " OnClick="clockform.Input.value += '6'" OnMouseDown = "this.className='bigbuttonpressedtimeclock'" OnMouseUp="this.className='bigbuttontimeclock'">
</center></td></tr><tr><td><center>
<INPUT class=bigbuttontimeclock TYPE="button" NAME="seven" VALUE=" 7 " OnClick="clockform.Input.value += '7'" OnMouseDown = "this.className='bigbuttonpressedtimeclock'" OnMouseUp="this.className='bigbuttontimeclock'">
<INPUT class=bigbuttontimeclock TYPE="button" NAME="eight" VALUE=" 8 " OnCLick="clockform.Input.value += '8'" OnMouseDown = "this.className='bigbuttonpressedtimeclock'" OnMouseUp="this.className='bigbuttontimeclock'">
<INPUT class=bigbuttontimeclock TYPE="button" NAME="nine"  VALUE=" 9 " OnClick="clockform.Input.value += '9'" OnMouseDown = "this.className='bigbuttonpressedtimeclock'" OnMouseUp="this.className='bigbuttontimeclock'">
</center></td></tr><tr><td><center>
<INPUT class=bigbuttontimeclock TYPE="button" NAME="zero"  VALUE=" 0 " OnClick="clockform.Input.value += '0'" OnMouseDown = "this.className='bigbuttonpressedtimeclock'" OnMouseUp="this.className='bigbuttontimeclock'">
</center><br>
</TD>
</TR>

<tr><td><center>
<br><br><INPUT class=bigbuttontimeclock TYPE="button" NAME="clear" VALUE="<?php echo pcrtlang("Reset"); ?>" onclick="parent.location='index.php'" OnMouseDown = "this.className='bigbuttonpressedtimeclock'" OnMouseUp="this.className='bigbuttontimeclock'">
<INPUT class=bigbuttontimeclock TYPE="submit" NAME="clear" VALUE="<?php echo pcrtlang("Enter"); ?>"  onclick="this.disabled=true;this.value='<?php echo pcrtlang("Wait"); ?>..'; this.form.submit();">
</center><br>
<br><br></TD>
</TR>


</TABLE>
</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td valign=top>
<center><br>
<img src="<?php echo "$logo"; ?>"><br><br>

<INPUT TYPE="text" name="clock" size="11" class=textboxbig style="text-align:center;">
<br><br><br>
<INPUT TYPE="text" name="date" size="20" class=textboxblank style="text-align:center;"><br>
<INPUT TYPE="hidden" name="sdate" size="18">
<INPUT TYPE="hidden" name="hdate" size="16">

<SCRIPT language="JavaScript">
<!--
startclock();
//-->
</SCRIPT>

</form>
<br><br>
<?php
if($punchresult != "") {

if($punchresult == 1) {

echo "<span class=\"sizemelarger boldme\">".pcrtlang("Last Action").":</span><br>";

if($lastactionpunch == "in") {
start_box_cb("199E1F");
} else {
start_box_cb("CE2123");

}
echo "<span class=\"sizemelarger colormewhite boldme\">$lastactionwho<br>$lastactiontime<br></span><span style=\"font-size:40px\" class=\"colormewhite\">$lastactionpunch</span>";
stop_box();

} else {
echo "<span class=\"sizemelarger colormered\">".pcrtlang("Error").":</span><br>";
start_box_cb("AA1DA6");
echo "<span class=\"sizemelarger colormewhite boldme\">$error</span>";
stop_box();

}


}
?>


</center>

</td></tr></table>




<?php




$a=1;
     
echo "</form>";



require("footerstatus.php");
                                                                                                                             
}




function punch() {
require("deps.php");
require("common.php");

$clocknumber2 = $_REQUEST['Input'];
$datestring = $_REQUEST['hdate'];
$timestring = $_REQUEST['clock'];

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}


$checkletter = substr("$clocknumber2", -1);

if ($checkletter == "A") {
$punchtype = "0";
$clocknumber = substr("$clocknumber2", 0, -1);
} else {
$punchtype = "1";
$clocknumber = "$clocknumber2";
}

$thedatetime =  date("Y-m-d H:i:s",strtotime("$timestring $datestring"));

$thedatetime2 = pcrtdate("$pcrt_longdate", "$thedatetime")." ".pcrtdate("$pcrt_time", "$thedatetime");

$thepcunixtime = strtotime("$timestring $datestring");
$theunixtime = time();

$timediffsl = abs($thepcunixtime - $theunixtime);


$ue_thedatetime = urlencode($thedatetime2);

if (($datestring == "") || ($timestring == "")) {
$punchresult = 0;
$error = pcrtlang("Sorry, Please try to repunch");
$ue_error = urlencode($error);
header("Location: index.php?error=$ue_error&punchresult=$punchresult&lastactionwho=unknown");
} elseif ($timediffsl > 86401) {
$punchresult = 0;
$error = pcrtlang("It appears that the time or date settings<br> on this computer are incorrect.<br>Please contact your manager.");
$ue_error = urlencode($error);
header("Location: index.php?error=$ue_error&punchresult=$punchresult&lastactionwho=unknown");

} else {





$rs_find_punch_status = "SELECT * FROM punches WHERE employeeid = '$clocknumber' ORDER BY punchin DESC LIMIT 1";
$punchchkq = mysqli_query($rs_connect, $rs_find_punch_status);

$totalpunches = mysqli_num_rows($punchchkq);


if($totalpunches == '0') {
$currentpunchstatus = "out";
} else {
$rs_result_q1 = mysqli_fetch_object($punchchkq);
$currentpunchstatus = "$rs_result_q1->punchstatus";
$currentpunchid = "$rs_result_q1->punchid";
}


$rs_find_employee = "SELECT * FROM employees WHERE clocknumber = '$clocknumber' LIMIT 1";
$employeechkq = mysqli_query($rs_connect, $rs_find_employee);
$employeecount = mysqli_num_rows($employeechkq);

if($employeecount == "0") {
$punchresult = 0;
$error = pcrtlang("Sorry, That clock number<br>does not exist");
$ue_error = urlencode($error);
header("Location: index.php?error=$ue_error&punchresult=$punchresult&lastactionwho=$ue_employeename");
} else {
$rs_result_e1 = mysqli_fetch_object($employeechkq);
$employeename = "$rs_result_e1->employeename";
$isactive = "$rs_result_e1->isactive";
$ue_employeename = urlencode($employeename);

if($isactive == 0) {
$punchresult = 0;
$error = pcrtlang("Sorry, Your Clock number is not active");
$ue_error = urlencode($error);
header("Location: index.php?error=$ue_error&punchresult=$punchresult&lastactionwho=$ue_employeename");


} else {
$punchresult = 1;

if($currentpunchstatus == "out") {
$rs_insert_punch = "INSERT INTO punches (employeeid,punchstatus,punchin,punchtype) VALUES ('$clocknumber','in','$thedatetime','$punchtype')";
@mysqli_query($rs_connect, $rs_insert_punch);
$lastactionpunch = "in";
} else {
$rs_update_punch = "UPDATE punches SET punchstatus = 'out', punchout = '$thedatetime', theout = '$timestring $datestring', punchtypeout = '$punchtype' WHERE punchid = '$currentpunchid'";
@mysqli_query($rs_connect, $rs_update_punch);
$lastactionpunch = "out";
}
header("Location: index.php?lastactionwho=$ue_employeename&lastactiontime=$ue_thedatetime&lastactionpunch=$lastactionpunch&punchresult=$punchresult");

}
}

}

}






switch($func) {
                                                                                                    
    default:
    clock();
    break;
                                
    case "clock":
    clock();
    break;

  case "punch":
    punch();
    break;



}

?>
