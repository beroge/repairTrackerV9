<?php
require("deps.php");

function pv($value) {
require("deps.php");
$value2 = trim($value);
   return mysqli_real_escape_string($rs_connect, $value2);
}


if (array_key_exists('hash',$_REQUEST)) {
$hash = pv($_REQUEST['hash']);
$rs_ql = "SELECT storehash FROM stores WHERE storehash = '$hash'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$totalresult = mysqli_num_rows($rs_result1);
} else {
$totalresult = 0;
}

if ($totalresult == 0) {
die();
}




$number = pv($_POST['From']);
$body = pv($_POST['Body']);
$to = pv($_POST['To']);

$mediacount = pv($_POST['NumMedia']);

$mediaurls = array();

$startcount = 0;
while($startcount < $mediacount) {
$holder = "MediaUrl".$startcount;
$mediaurls[] = $_POST["$holder"];
$startcount++;
}

$smediaurls = serialize($mediaurls);


$messageraw = pv(serialize($_POST));

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

$rs_insert_message = "INSERT INTO messages (messagefrom,messageto,messagebody,messageraw,messagedatetime,messagevia,messageservice,messagedirection,mediaurls) VALUES ('$number','$to','$body','$messageraw','$currentdatetime','sms','twilio','in','$smediaurls')";
@mysqli_query($rs_connect, $rs_insert_message);


header('Content-Type: text/xml');
echo "<Response></Response>";
