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



$json = file_get_contents('php://input');
$postdata = json_decode($json, true);

if (is_array($postdata)) {

if (array_key_exists('ticket_number', $postdata)) {

$title = pv($postdata['title']);
$ticketnumber = pv($postdata['ticket_number']);
$reporturl = pv($postdata['logpath']);

if (is_numeric($ticketnumber)) {

$rs_findwo = "SELECT * FROM pc_wo WHERE woid = '$ticketnumber'";
$rs_result = mysqli_query($rs_connect, $rs_findwo);
$total = mysqli_num_rows($rs_result);
if($total != 0) {

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$thenow = date('Y-m-d H:i:s');



$rs_insert_report = "INSERT INTO attachments (attach_title,attach_filename,attach_size,woid,attach_date) VALUES ('$title','$reporturl','0','$ticketnumber','$thenow')";
@mysqli_query($rs_connect, $rs_insert_report);




}
}
}
}


?>
