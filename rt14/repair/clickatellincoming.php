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




$number = pv($_REQUEST['from']);
$body = pv($_REQUEST['text']);
$to = pv($_REQUEST['to']);

$messageraw = pv(serialize($_POST));

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

$rs_insert_message = "INSERT INTO messages (messagefrom,messageto,messagebody,messageraw,messagedatetime,messagevia,messageservice,messagedirection) VALUES ('$number','$to','$body','$messageraw','$currentdatetime','sms','clickatell','in')";
@mysqli_query($rs_connect, $rs_insert_message);


