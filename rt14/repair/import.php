<?php


/***************************************************************************
 *   copyright            : (C) 2014 PCRepairTracker.com
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


function pickcsv() {
require_once("header.php");
require("deps.php");
require_once("common.php");


echo "<a href=../repair/admin.php class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-circle-left fa-lg\"></i> ".pcrtlang("Go Back to Settings")."</a><br><br>";

start_blue_box(pcrtlang("Choose CSV to Upload"));
echo "<form action=import.php?func=importcsv method=post>";
echo "<span class=boldme>".pcrtlang("Paste CSV").":</span><br>";
echo "<textarea class=textbox name=csv cols=120 rows=50></textarea><br>";
echo "<input type=submit class=button value=\"".pcrtlang("Read CSV")."\"></form>";
stop_blue_box();


require_once("footer.php");

}



function importcsv() {
require_once("header.php");
require("deps.php");
require_once("common.php");

$csv = trim($_REQUEST['csv']);

function parse_csv ($csv_string, $delimiter = ",", $skip_empty_lines = true, $trim_fields = true)
{
    $enc = preg_replace('/(?<!")""/', '!!Q!!', $csv_string);
    $enc = preg_replace_callback(
        '/"(.*?)"/s',
        function ($field) {
            return urlencode(utf8_encode($field[1]));
        },
        $enc
    );
    $lines = preg_split($skip_empty_lines ? ($trim_fields ? '/( *\R)+/s' : '/\R+/s') : '/\R/s', $enc);
    return array_map(
        function ($line) use ($delimiter, $trim_fields) {
            $fields = $trim_fields ? array_map('trim', explode($delimiter, $line)) : explode($delimiter, $line);
            return array_map(
                function ($field) {
                    return str_replace('!!Q!!', '"', utf8_decode(urldecode($field)));
                },
                $fields
            );
        },
        $lines
    );
}

$csvarray = parse_csv($csv);

start_blue_box(pcrtlang("Import Customer List from CSV"));

echo pcrtlang("The first record has been pulled from your CSV file, match up the fields to the appropriate fields. If you do not have a field that matches, leave it set to [No Match]");

$options = "<option value=\"nomatch\">No Match</option>";
foreach($csvarray[0] as $key => $val) {
$options .= "<option value=\"$key\">$val</option>";
}

echo "<table>";
echo "<tr><td><form action=import.php?func=importcsv2 method=post>".pcrtlang("First Name").": </td><td><select name=fname>$options</select></td>";
echo "<td rowspan=17 style=\"vertical-align:top\"><textarea class=textbox name=csv cols=60 rows=10>$csv</textarea></td></tr>";
echo "<tr><td>".pcrtlang("Last Name").": </td><td><select name=lname>$options</select></td></tr>";
echo "<tr><td>".pcrtlang("Address 1").": </td><td><select name=addy1>$options</select></td></tr>";
echo "<tr><td>".pcrtlang("Address 2").": </td><td><select name=addy2>$options</select></td></tr>";
echo "<tr><td>".pcrtlang("City").": </td><td><select name=city>$options</select></td></tr>";
echo "<tr><td>".pcrtlang("State").": </td><td><select name=state>$options</select></td></tr>";
echo "<tr><td>".pcrtlang("Zip").": </td><td><select name=zip>$options</select></td></tr>";
echo "<tr><td>".pcrtlang("Email").": </td><td><select name=email>$options</select></td></tr>";
echo "<tr><td>".pcrtlang("Company Name").": </td><td><select name=company>$options</select></td></tr>";
echo "<tr><td>".pcrtlang("Phone").": </td><td><select name=phone>$options</select></td></tr>";
echo "<tr><td>".pcrtlang("Notes").": </td><td><select name=notes>$options</select></td></tr>";
echo "<tr><td>".pcrtlang("Cell Phone").": </td><td><select name=cell>$options</select></td></tr>";
echo "<tr><td>".pcrtlang("Work Phone").": </td><td><select name=workphone>$options</select></td></tr>";
echo "<tr><td>".pcrtlang("Model/Make").": </td><td><select name=make>$options</select></td></tr>";
echo "<tr><td colspan=2><br></td></tr>";
echo "<tr><td>".pcrtlang("Select Table to Import to:").": </td><td><select name=whichtable><option value=pcowner>".pcrtlang("Asset/Device Owner Table")."</option>";
echo "<option selected value=pcgroup>".pcrtlang("Group Contact Table")."</option></select></td></tr>";

echo "<tr><td colspan=2><input type=submit class=button value=\"".pcrtlang("Import")."\"></form></td></tr>";

echo "</table>";

stop_blue_box();

require_once("footer.php");

}


function importcsv2() {
require_once("header.php");
require("deps.php");
require_once("common.php");

$csv = trim($_REQUEST['csv']);

$whichtable = $_REQUEST['whichtable'];

$fname = $_REQUEST['fname'];
$lname = $_REQUEST['lname'];
$addy1 = $_REQUEST['addy1'];
$addy2 = $_REQUEST['addy2'];
$state = $_REQUEST['state'];
$zip = $_REQUEST['zip'];
$city = $_REQUEST['city'];
$workphone = $_REQUEST['workphone'];
$cell = $_REQUEST['cell'];
$company = $_REQUEST['company'];
$email = $_REQUEST['email'];
$phone = $_REQUEST['phone'];
$notes = $_REQUEST['notes'];
$make = $_REQUEST['make'];


function parse_csv ($csv_string, $delimiter = ",", $skip_empty_lines = true, $trim_fields = true)
{
    $enc = preg_replace('/(?<!")""/', '!!Q!!', $csv_string);
    $enc = preg_replace_callback(
        '/"(.*?)"/s',
        function ($field) {
            return urlencode(utf8_encode($field[1]));
        },
        $enc
    );
    $lines = preg_split($skip_empty_lines ? ($trim_fields ? '/( *\R)+/s' : '/\R+/s') : '/\R/s', $enc);
    return array_map(
        function ($line) use ($delimiter, $trim_fields) {
            $fields = $trim_fields ? array_map('trim', explode($delimiter, $line)) : explode($delimiter, $line);
            return array_map(
                function ($field) {
                    return str_replace('!!Q!!', '"', utf8_decode(urldecode($field)));
                },
                $fields
            );
        },
        $lines
    );
}

$csvarray = parse_csv($csv);

start_blue_box(pcrtlang("Import Results..."));

foreach($csvarray as $key => $val) {

if(($fname != "nomatch") && ($val["$fname"] != '"')){
$fnameset = $val["$fname"];
} else {
$fnameset = "";
}

if(($lname != "nomatch") && ($val["$lname"] != '"')){
$lnameset = $val["$lname"];
} else {
$lnameset = "";
}

if(($addy1 != "nomatch") && ($val["$addy1"] != '"')){
$addy1set = $val["$addy1"];
} else {
$addy1set = "";
}

if(($addy2 != "nomatch") && ($val["$addy2"] != '"')){
$addy2set = $val["$addy2"];
} else {
$addy2set = "";
}

if(($state != "nomatch") && ($val["$state"] != '"')){
$stateset = $val["$state"];
} else {
$stateset = "";
}

if(($zip != "nomatch") && ($val["$zip"] != '"')){
$zipset = $val["$zip"];
} else {
$zipset = "";
}

if(($city != "nomatch") && ($val["$city"] != '"')){
$cityset = $val["$city"];
} else {
$cityset = "";
}

if(($workphone != "nomatch") && ($val["$workphone"] != '"')){
$workphoneset = $val["$workphone"];
} else {
$workphoneset = "";
}

if(($cell != "nomatch") && ($val["$cell"] != '"')){
$cellset = $val["$cell"];
} else {
$cellset = "";
}

if(($company != "nomatch") && ($val["$company"] != '"')){
$companyset = $val["$company"];
} else {
$companyset = "";
}

if(($email != "nomatch") && ($val["$email"] != '"')){
$emailset = $val["$email"];
} else {
$emailset = "";
}

if(($phone != "nomatch") && ($val["$phone"] != '"')){
$phoneset = $val["$phone"];
} else {
$phoneset = "";
}

if(($notes != "nomatch") && ($val["$notes"] != '"')){
$notesset = $val["$notes"];
} else {
$notesset = "";
}

if(($make != "nomatch") && ($val["$make"] != '"')){
$makeset = $val["$make"];
} else {
$makeset = "";
}



if("$whichtable" == "pcowner") {
$rs_insert_contact = "INSERT INTO pc_owner (pcname,pcphone,pccellphone,pcworkphone,pcmake,pcemail,pcaddress,pcaddress2,pccity,pcstate,pczip,pcnotes,pccompany) 
VALUES ('$fnameset $lnameset','$phoneset','$cellset','$workphoneset','$makeset','$emailset','$addy1set','$addy2set','$cityset','$stateset','$zipset','$notesset','$companyset')";
} else {
$rs_insert_contact = "INSERT INTO pc_group (pcgroupname,grpphone,grpcellphone,grpworkphone,grpemail,grpaddress1,grpaddress2,grpcity,grpstate,grpzip,grpnotes,grpcompany) 
VALUES ('$fnameset $lnameset','$phoneset','$cellset','$workphoneset','$emailset','$addy1set','$addy2set','$cityset','$stateset','$zipset','$notesset','$companyset')";
}



@mysqli_query($rs_connect, $rs_insert_contact);

echo "$fnameset $lnameset<br>";


}






stop_blue_box();

require_once("footer.php");

}


switch($func) {

    default:
    pickcsv();
    break;

    case "importcsv":
    importcsv();
    break;

 case "importcsv2":
    importcsv2();
    break;
	
}


?>
