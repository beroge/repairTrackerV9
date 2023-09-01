<?php
require_once("validate.php");
include 'phpqrcode.php';
$qrdata = $_REQUEST['qrdata'];
QRcode::png("$qrdata");
?>
