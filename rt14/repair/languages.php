<?php

/***************************************************************************
 *   copyright            : (C) 2010 PCRepairTracker.com
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


function langbrowse() {

require_once("header.php");



require("deps.php");
require_once("common.php");

echo "<a href=../repair/admin.php class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-circle-left fa-lg\"></i> ".pcrtlang("Go Back to Settings")."</a><br><br>";

if (array_key_exists("pageNumber", $_REQUEST)) {
$pageNumber = $_REQUEST['pageNumber'];
} else {
$pageNumber = 1;
}

if (array_key_exists("sortby", $_REQUEST)) {
$sortby = $_REQUEST['sortby'];
} else {
$sortby = "basestring_asc";
}

if (array_key_exists("langtoedit", $_REQUEST)) {
$langtoedit = $_REQUEST['langtoedit'];
} else {
$langtoedit = "en-us";
}

if (array_key_exists("searchstring", $_REQUEST)) {
$searchstring2 = $_REQUEST['searchstring'];
if(strlen("$searchstring2") < 1) {
$searchstring = "nonenonenonenone";
} else {
$searchstring = pv("$searchstring2");
}
} else {
$searchstring = "nonenonenonenone";
}




$results_per_page = 40;

if ($pageNumber == "") {
$offset = "0";
} else {
$offset = ($pageNumber * $results_per_page) - $results_per_page;
}



require("deps.php");
require_once("common.php");





if("$searchstring" == "nonenonenonenone") {
if ("$sortby" == "basestring_asc") {
$rs_find_lang_items = "SELECT * FROM languages WHERE language = '$langtoedit' ORDER BY basestring ASC LIMIT $offset,$results_per_page";
} elseif ("$sortby" == "basestring_desc") {
$rs_find_lang_items = "SELECT * FROM languages WHERE language = '$langtoedit' ORDER BY basestring DESC LIMIT $offset,$results_per_page";
} elseif ("$sortby" == "languagestring_desc") {
$rs_find_lang_items = "SELECT * FROM languages WHERE language = '$langtoedit' ORDER BY languagestring ASC LIMIT $offset,$results_per_page";
} else {
$rs_find_lang_items = "SELECT * FROM languages WHERE language = '$langtoedit' ORDER BY languagestring DESC LIMIT $offset,$results_per_page";
}

} else {
$rs_find_lang_items = "SELECT * FROM languages WHERE (languagestring LIKE '%$searchstring%' OR basestring LIKE '%$searchstring%') AND language = '$langtoedit' ORDER BY basestring ASC LIMIT $offset,$results_per_page";
}


$rs_result = mysqli_query($rs_connect, $rs_find_lang_items);

if("$searchstring" == "nonenonenonenone") {
$rs_find_lang_items_total = "SELECT * FROM languages WHERE language = '$langtoedit'";
$rs_result_total = mysqli_query($rs_connect, $rs_find_lang_items_total);
} else {
$rs_find_lang_items_total = "SELECT * FROM languages WHERE (languagestring LIKE '%$searchstring%' OR basestring LIKE '%$searchstring%') AND language = '$langtoedit'";
$rs_result_total = mysqli_query($rs_connect, $rs_find_lang_items_total);
}

start_blue_box(pcrtlang("Browse/Edit Languages"));

if(isset($pcrtmasterlanguagelist)) {
foreach($pcrtmasterlanguagelist as $key => $val) {
echo "<a href=\"languages.php?langtoedit=$key&sortby=basestring_asc\" class=\"linkbuttonsmall linkbuttongray\">$val</a>";
}
}

$dupfind = "SELECT basestring, COUNT(*) total FROM languages GROUP BY language,basestring HAVING total > 1";
$rs_result_df = mysqli_query($rs_connect, $dupfind);
$dupcount = mysqli_num_rows($rs_result_df);

echo "<a href=\"languages.php?func=optlang\" class=\"linkbuttonsmall linkbuttongray radiusall floatright\">".pcrtlang("Remove Duplicate Strings")." ($dupcount)</a><br><br>";

if("$langtoedit" != "en-us") {
echo "<a href=\"languages.php?func=updatestringlist&langtoedit=$langtoedit\" class=\"linkbuttonsmall linkbuttongray\">".pcrtlang("Update String list for")." $pcrtmasterlanguagelist[$langtoedit]</a><br><br>";
}

echo "<form method=post action=languages.php><input type=text name=searchstring class=textbox><input type=hidden name=langtoedit value=\"$langtoedit\"><input type=submit value=\"Search Strings\" class=button></form><br>";

start_box();
echo "<center>";
#browse here
$totalentry = mysqli_num_rows($rs_result_total);
$prevpage = $pageNumber - 1;
$nextpage = $pageNumber + 1;

if ($pageNumber > 1) {
echo "<a href=languages.php?func=langbrowse&pageNumber=$prevpage&sortby=$sortby&langtoedit=$langtoedit&searchstring=$searchstring class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-left fa-lg\"></i></a>";
}

$total_results = $totalentry;
$results_per_page = $results_per_page;
$html = get_paged_nav($total_results, $results_per_page, false);
echo "$html";

if (($totalentry / $results_per_page) > $pageNumber) {
echo "<a href=languages.php?func=langbrowse&pageNumber=$nextpage&sortby=$sortby&langtoedit=$langtoedit&searchstring=$searchstring class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-right fa-lg\"></i></a>";
}
echo "</center>";
stop_box();
echo "<br>";

echo "<form action=languages.php?func=savestrings&langtoedit=$langtoedit&pageNumber=$pageNumber&sortby=$sortby&searchstring=$searchstring method=post><table class=doublestandard>";
echo "<tr><th style=\"width:10%;\">&nbsp;</th><th style=\"width:40%;\">".pcrtlang("Base String");
if("$searchstring" == "nonenonenonenone") {
echo "<a href=languages.php?pageNumber=$pageNumber&sortby=basestring_asc&langtoedit=$langtoedit class=imagelink><img src=\"../store/images/up.png\" border=0></a>";
echo "<a href=languages.php?pageNumber=$pageNumber&sortby=basestring_desc&langtoedit=$langtoedit class=imagelink><img src=\"../store/images/down.png\" border=0></a>";
}
echo "</th>";
echo "<th style=\"width:50%;\">".pcrtlang("Language").": $pcrtmasterlanguagelist[$langtoedit]";
if("$searchstring" == "nonenonenonenone") {
echo "<a href=languages.php?pageNumber=$pageNumber&sortby=languagestring_asc&langtoedit=$langtoedit class=imagelink><img src=\"../store/images/up.png\" border=0></a>";
echo "<a href=languages.php?pageNumber=$pageNumber&sortby=languagestring_desc&langtoedit=$langtoedit class=imagelink><img src=\"../store/images/down.png\" border=0></a>";
}
echo "</th>";

echo "</tr>";

$a = 2;

while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_basestring = "$rs_result_q->basestring";
$rs_languagestring = "$rs_result_q->languagestring";


echo "<tr><td>".pcrtlang("Displayed").":</td><td>$rs_basestring</td>";
echo "<td>$rs_languagestring</td>";


echo "</tr><tr><td>".pcrtlang("Raw").":</td><td>";

if (strlen("$rs_languagestring") < 35) {
echo "<input readonly type=text class=textboxnoborder value=\"".pfnotrim("$rs_basestring")."\" style=\"width:90%;\" name=\"basestring[]\">";
} else {
echo "<textarea readonly class=textboxnoborder style=\"width:90%;\" name=\"basestring[]\">".pfnotrim("$rs_basestring")."</textarea>";
}

echo "</td>";

echo "<td>";

if (strlen("$rs_languagestring") < 35) {
echo "<input type=text class=textbox value=\"".pfnotrim("$rs_languagestring")."\" style=\"width:90%;\" name=\"languagestring[]\">";
} else {
echo "<textarea class=textbox style=\"width:90%;\" name=\"languagestring[]\">".pfnotrim("$rs_languagestring")."</textarea>";
}


echo "</td>";


echo "</tr>";

$a++;

}

?>

<script type='text/javascript' src='jq/jquery.autogrow-textarea.js'></script>

<script type='text/javascript'>
  $(function() {
    $('textarea').autogrow();
  });
</script>

<?php


echo "</table><br><br><input type=submit class=button value=\"".pcrtlang("Save Strings")."\"></form>";

stop_blue_box();

echo "<br>";

start_box();
echo "<center>";
#browse here
$totalentry = mysqli_num_rows($rs_result_total);
$prevpage = $pageNumber - 1;
$nextpage = $pageNumber + 1;

if ($pageNumber > 1) {
echo "<a href=languages.php?func=langbrowse&pageNumber=$prevpage&sortby=$sortby&langtoedit=$langtoedit&searchstring=$searchstring class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-left fa-lg\"></i></a>";
}

$total_results = $totalentry;
$results_per_page = $results_per_page;
$html = get_paged_nav($total_results, $results_per_page, false);
echo "$html";

if (($totalentry / $results_per_page) > $pageNumber) {
echo "<a href=languages.php?func=langbrowse&pageNumber=$nextpage&sortby=$sortby&langtoedit=$langtoedit&searchstring=$searchstring class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-right fa-lg\"></i></a>";
}

echo "</center>";
stop_box();

require("footer.php");

}


function updatestringlist() {

require("deps.php");
require("common.php");

$langtoedit = "$_REQUEST[langtoedit]";

if($langtoedit == "en-us") {
die("Error: You cannot repopulate the en-us language strings");
}

$findbasestrings = "SELECT * FROM languages WHERE language = 'en-us'";

$findbasestringsq = @mysqli_query($rs_connect, $findbasestrings);
while($rs_result_q = mysqli_fetch_object($findbasestringsq)) {
$rs_basestring = pv("$rs_result_q->basestring");

$findbasestringexisting = "SELECT * FROM languages WHERE language = '$langtoedit' AND basestring LIKE BINARY '$rs_basestring'";
$findbasestringexistingq = @mysqli_query($rs_connect, $findbasestringexisting);

if(mysqli_num_rows($findbasestringexistingq) == 0) {

$addstring = "INSERT INTO languages (language,languagestring,basestring) VALUES ('$langtoedit','$rs_basestring','$rs_basestring')";
@mysqli_query($rs_connect, $addstring);
}
}

header("Location: languages.php?langtoedit=$langtoedit&sortby=basestring_asc");

}


function savestrings() {

require("deps.php");
require("common.php");

$langtoedit = "$_REQUEST[langtoedit]";
$pageNumber = "$_REQUEST[pageNumber]";
$basestring = $_REQUEST['basestring'];
$languagestring = $_REQUEST['languagestring'];
$sortby = "$_REQUEST[sortby]";
$searchstring = "$_REQUEST[searchstring]";

foreach($basestring as $key => $val) {
$languagestring2 = pv($languagestring[$key]);
$basestring2 = pv($basestring[$key]);

$updatestring = "UPDATE languages SET languagestring = '$languagestring2' WHERE basestring LIKE BINARY '$basestring2' AND language = '$langtoedit'";
@mysqli_query($rs_connect, $updatestring);


}


header("Location: languages.php?langtoedit=$langtoedit&sortby=$sortby&pageNumber=$pageNumber&searchstring=$searchstring");

}



function optlang() {
require_once("validate.php");
require("deps.php");
require_once("common.php");

$findstring = "SELECT languagestring,basestring FROM languages WHERE language = '$mypcrtlanguage'";

$findstringq = @mysqli_query($rs_connect, $findstring);
$langblobsave = array();
while ($rs_result_qs = mysqli_fetch_object($findstringq)) {
$langstring = "$rs_result_qs->languagestring";
$basestring = "$rs_result_qs->basestring";
if(!isset($langblobsave[$basestring])) {
$langblobsave[$basestring] = $langstring;
}
}

$clearstrings = "DELETE FROM languages WHERE language = '$mypcrtlanguage'";
@mysqli_query($rs_connect, $clearstrings);

foreach($langblobsave as $base => $string) {
$insertstrings = "INSERT INTO languages (basestring,languagestring,language) VALUES ('$base','$string','$mypcrtlanguage')";
@mysqli_query($rs_connect, $insertstrings);
}

header("Location: languages.php");
}



######

switch($func) {
                                                                                                    
    default:
    langbrowse();
    break;
                                
    case "langbrowse":
    langbrowse();
    break;

    case "updatestringlist":
    updatestringlist();
    break;

    case "savestrings":
    savestrings();
    break;

    case "optlang":
    optlang();
    break;


}


