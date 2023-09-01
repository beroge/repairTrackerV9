<?php

require_once("deps.php");

function pv($value) {
require("deps.php");
$value2 = trim($value);
   return mysqli_real_escape_string($rs_connect, $value2);
}

function pcrtlang($string) {

require("deps.php");

$safestring = pv($string);
$findbasestring = "SELECT * FROM languages WHERE basestring LIKE BINARY '$safestring'";
$findbasestringq = @mysqli_query($rs_connect, $findbasestring);
if(mysqli_num_rows($findbasestringq) == 0) {
$addstring = "INSERT INTO languages (language,languagestring,basestring) VALUES ('$mypcrtlanguage','$safestring','$safestring')";
@mysqli_query($rs_connect, $addstring);
}

$findstring = "SELECT languagestring FROM languages WHERE basestring LIKE BINARY '$safestring' AND language = '$mypcrtlanguage'";

$findstringq = @mysqli_query($rs_connect, $findstring);
if(mysqli_num_rows($findstringq) == 0) {
return "$string";
} else {
$rs_result_qs = mysqli_fetch_object($findstringq);
return "$rs_result_qs->languagestring";
}
}

$rs_qmultistore = "SELECT storeid FROM stores WHERE storedefault = '1'";
$rs_result_multistore = mysqli_query($rs_connect, $rs_qmultistore);
$rs_result_q1 = mysqli_fetch_object($rs_result_multistore);
$defaultstore = "$rs_result_q1->storeid";

function getstoreinfo($storetoget) {

include("deps.php");

$rs_ql = "SELECT * FROM stores WHERE storeid = '$storetoget'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$storename = "$rs_result_q1->storename";
$storephone = "$rs_result_q1->storephone";

$storeinfo = array("storename" => "$storename", "storephone" => "$storephone");

return $storeinfo;
}


$storea = getstoreinfo($defaultstore);
$storename = $storea['storename'];
$storephone = $storea['storephone'];


echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

echo "<Response>
<Say voice=\"alice\">".pcrtlang("Hello").". ".pcrtlang("You have reached the text messaging number for")." $storename.</Say>
<Pause length=\"1\"/><Say voice=\"alice\">Forwarding your call to our voice line.</Say>
<Dial timeout=\"60\" record=\"true\">$storephone</Dial>
</Response>";


