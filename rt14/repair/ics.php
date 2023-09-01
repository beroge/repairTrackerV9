<?php

require("deps.php");

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}


$storeid = $_REQUEST['storeid'];

if (array_key_exists('user',$_REQUEST)) {
$theuser = $_REQUEST['user'];
} else {
$theuser = "all";
}




$rs_ql = "SELECT storehash FROM stores WHERE storeid = '$storeid'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$storehash = "$rs_result_q1->storehash";


if (array_key_exists('hash',$_REQUEST)) {
$hash = $_REQUEST['hash'];
if ($hash != "$storehash") {
die("access denied");
}
} else {
die("access denied");
}


if (array_key_exists('download',$_REQUEST)) {
$download = "yes";
} else {
$download = "no";
}


$icsfile = "BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:PCRT\r\nX-WR-TIMEZONE:$pcrt_timezone\r\n";

function geticaldate($time, $incl_time = true) {
require("deps.php");
if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
    return $incl_time ? date('Ymd\THis', $time) : date('Ymd', $time);
}

function prepvar($var) {
$var2 = trim($var);
$var3 = str_replace(",","\,","$var2");
return $var3;
}


if ($theuser == "all") {
$rs_findnotes52 = "SELECT * FROM stickynotes WHERE storeid = '$storeid' AND stickyduedate > (DATE_SUB(NOW(), INTERVAL 12 week))";

$rs_findwo = "SELECT * FROM pc_wo WHERE sked = '1' AND pcstatus != '7' AND pcstatus != '6' AND pcstatus != '5' AND pcstatus != '4'
AND storeid = '$storeid' AND skeddate > (DATE_SUB(NOW(), INTERVAL 12 week)) ORDER BY skeddate ASC";

} else {
$rs_findnotes52 = "SELECT * FROM stickynotes WHERE stickyuser = '$theuser' AND stickyduedate > (DATE_SUB(NOW(), INTERVAL 12 week))";

$rs_findwo = "SELECT * FROM pc_wo WHERE sked = '1' AND pcstatus != '7' AND pcstatus != '6' AND pcstatus != '5'
AND pcstatus != '4' AND skeddate > (DATE_SUB(NOW(), INTERVAL 12 week)) AND storeid = '$storeid' AND assigneduser = '$theuser' ORDER BY skeddate ASC";
}

$rs_result_n5 = mysqli_query($rs_connect, $rs_findnotes52);

while($rs_result_qn5 = mysqli_fetch_object($rs_result_n5)) {
$stickyid = "$rs_result_qn5->stickyid";
$stickyaddy1 = prepvar($rs_result_qn5->stickyaddy1);
$stickyaddy2 = prepvar($rs_result_qn5->stickyaddy2);
$stickycity = prepvar($rs_result_qn5->stickycity);
$stickystate = prepvar($rs_result_qn5->stickystate);
$stickyzip = prepvar($rs_result_qn5->stickyzip);
$stickyphone = prepvar($rs_result_qn5->stickyphone);
$stickyemail = prepvar($rs_result_qn5->stickyemail);
$stickyduedate = "$rs_result_qn5->stickyduedate";
$stickytypeid = "$rs_result_qn5->stickytypeid";
$stickyuser = prepvar($rs_result_qn5->stickyuser);
$stickynote2 = prepvar($rs_result_qn5->stickynote);
$stickyname = prepvar($rs_result_qn5->stickyname);
$refid = "$rs_result_qn5->refid";

if ($stickyemail == "") {
$stickyemail2 = "unknown";
} else {
$stickyemail2 = "$stickyemail";
}

$stickynote3 = str_replace("\n", "\\n", "$stickynote2");
$stickynote = str_replace("\r", "", "$stickynote3");

$stickytime_stamp = geticaldate(time());

$getstart = strtotime($stickyduedate);
$stickytime_st = geticaldate($getstart);

$getend = (strtotime($stickyduedate) + 3600);;
$stickytime_end = geticaldate($getend);

$seq = time();

$icsfile .= "BEGIN:VEVENT\r\nUID:$stickyid\r\nSEQUENCE:$seq\r\nDTSTAMP:$stickytime_stamp\r\nORGANIZER;CN=$stickyname:MAILTO:$stickyemail2\r\nDTSTART;TZID=$pcrt_timezone:$stickytime_st\r\nDTEND;TZID=$pcrt_timezone:$stickytime_end\r\nSUMMARY:$stickyname\r\nLOCATION:$stickyaddy1\, $stickyaddy2\, $stickycity\, $stickystate $stickyzip\r\nDESCRIPTION:$stickyphone\\n$stickynote\r\nEND:VEVENT\r\n";

}

$rs_result_wo = mysqli_query($rs_connect, $rs_findwo);

while($rs_result_q = mysqli_fetch_object($rs_result_wo)) {
$pcid = "$rs_result_q->pcid";
$woid = "$rs_result_q->woid";
$probdesc =  prepvar(substr("$rs_result_q->probdesc", 0, 50)."...");
$pcstatus = "$rs_result_q->pcstatus";
$skeddate = "$rs_result_q->skeddate";

$rs_findowner = "SELECT * FROM pc_owner WHERE pcid = '$pcid'";
$rs_result2 = mysqli_query($rs_connect, $rs_findowner);
$rs_result_q2 = mysqli_fetch_object($rs_result2);
$pcname = prepvar("$rs_result_q2->pcname");
$pcmake =  prepvar("$rs_result_q2->pcmake");
$pcemail =  prepvar("$rs_result_q2->pcemail");
$pccompany =  prepvar("$rs_result_q2->pccompany");
$thedatewo = date('g:i A', strtotime("$skeddate"));
$pcphone =  prepvar("$rs_result_q2->pcphone");
$pcaddy1 =  prepvar("$rs_result_q2->pcaddress");
$pcaddy2 =  prepvar("$rs_result_q2->pcaddress2");
$pccity =  prepvar("$rs_result_q2->pccity");
$pcstate =  prepvar("$rs_result_q2->pcstate");
$pczip =  prepvar("$rs_result_q2->pczip");


$skeddate_stamp = geticaldate(time());

$seq = time();

if ($pcemail == "") {
$pcemail2 = "unknown";
} else {
$pcemail2 = "$pcemail";
}

$getstartsw = strtotime($skeddate);
$skedtime_stsw = geticaldate($getstartsw);

$getendsw = (strtotime($skeddate) + 3600);;
$skedtime_endsw = geticaldate($getendsw);


$icsfile .= "BEGIN:VEVENT\r\nUID:$woid"."wo\r\nSEQUENCE:$seq\r\nDTSTAMP:$skeddate_stamp\r\nORGANIZER;CN=$pcname:MAILTO:$pcemail2\r\nDTSTART;TZID=$pcrt_timezone:$skedtime_stsw\r\nDTEND;TZID=$pcrt_timezone:$skedtime_endsw\r\nSUMMARY:$pcname\r\nLOCATION:$pcaddy1\, $pcaddy2\, $pccity\, $pcstate $pczip\r\nDESCRIPTION:$pcphone\\n$probdesc\r\nEND:VEVENT\r\n";


}


$icsfile .= "END:VCALENDAR\r\n";

if ($download == "yes") {
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"pcrt.ics\"");
}
echo $icsfile;

?>
