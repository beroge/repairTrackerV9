<?php

function pv($value) {
require("deps.php");
$rs_connect = mysqli_connect($dbhost, $dbuname, $dbpass, $dbname) or die("Couldn't connect the db");
mysqli_query($rs_connect, "SET NAMES utf8");
mysqli_query($rs_connect, "SET SESSION sql_mode=''");

$value2 = trim($value);
   return mysqli_real_escape_string($rs_connect, $value2);
}

function pf($value) {
require("deps.php");


$value2 = trim($value);
   return htmlspecialchars($value2);
}


function pcrtlang($string) {
require("deps.php");
$rs_connect = mysqli_connect($dbhost, $dbuname, $dbpass, $dbname) or die("Couldn't connect the db");
mysqli_query($rs_connect, "SET NAMES utf8");
mysqli_query($rs_connect, "SET SESSION sql_mode=''");
$safestring = pv($string);
$findstring = "SELECT languagestring FROM languages WHERE basestring LIKE BINARY '$safestring' AND language = '$mypcrtlanguage'";
$findstringq = @mysqli_query($rs_connect, $findstring);
if(mysqli_num_rows($findstringq) == 0) {
$findbasestring = "SELECT basestring FROM languages WHERE basestring LIKE BINARY '$safestring'";
$findbasestringq = @mysqli_query($rs_connect, $findbasestring);
if(mysqli_num_rows($findbasestringq) == 0) {
$addstring = "INSERT INTO languages (language,languagestring,basestring) VALUES ('en-us','$safestring','$safestring')";
@mysqli_query($rs_connect, $addstring);
}
return "$string";
} else {
$rs_result_qs = mysqli_fetch_object($findstringq);
return "$rs_result_qs->languagestring";
}
return $string;
}


function filtersmsnumber($value) {
require("deps.php");
if(!isset($smsnumberfilter)) {
return "$value";
} else {
if($smsnumberfilter == "0") {
return "$value";
} elseif ($smsnumberfilter == "1") {
return substr("$value", 1);
} else {
return "$value";
}
}
}

