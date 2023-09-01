<?php

/***************************************************************************
 *   copyright            : (C) 2010 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/

if (array_key_exists('func',$_REQUEST)) {
$func = "$_REQUEST[func]";
} else {
$func = "";
}

                                                                                                    

function useraccounts() {



require("header.php");
require_once("common.php");
require("deps.php");

if (array_key_exists('showuser',$_REQUEST)) {
$showuser = "$_REQUEST[showuser]";
} else {
$showuser = "";
}

if ($ipofpc != "admin") {
perm_boot("3");
}





start_blue_box(pcrtlang("Users"));


if($ipofpc == "admin") {
$rs_ql = "SELECT * FROM users";
} else {
$rs_ql = "SELECT * FROM users WHERE username != 'admin'";
}



$rs_result1 = mysqli_query($rs_connect, $rs_ql);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$userid = "$rs_result_q1->userid";
$uname = "$rs_result_q1->username";
$userpass = "$rs_result_q1->userpass";
$theperms2 = "$rs_result_q1->timeclockperms";
$lastseen2 = "$rs_result_q1->lastseen";
$locperms = "$rs_result_q1->locperms";
$deptperms = "$rs_result_q1->deptperms";
$lastseen = date("n-j-y, g:i a", strtotime($lastseen2));



$theperms3 = unserialize($theperms2);
if(is_array($theperms3)) {
$theperms = $theperms3;
} else {
$theperms = array();
}

echo "<a name=$uname></a>";
start_box_nested();
echo "<table><tr><td valign=top>";

if("$uname" == "$showuser") {
echo "<br><br><br>";

echo "<form action=admin.php?func=useraccounts2 method=post><input type=hidden name=userid value=$userid><input type=hidden name=showuser value=$uname>";
}
echo "<a href=\"admin.php?func=useraccounts&showuser=$uname#$uname\" class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-user-md fa-lg\"></i> $uname</a></font><br><font class=text10>".pcrtlang("Last Seen").": $lastseen";
echo "</font></td>";
if("$uname" == "$showuser") {

echo "<td valign=top><br><br><br><font class=text12b>".pcrtlang("Password").":</font> <input type=text name=setuserpass size=15 class=textbox><input type=hidden name=uname value=\"$uname\">";
echo "</td><td valign=top><br><br><br><button type=submit class=button><i class=\"fa fa-chevron-left\"></i> ".pcrtlang("Save")."</button></form></td><td valign=top>";

echo "</td></tr><tr><td>";

echo "<font class=text14b>".pcrtlang("User Permissions").":</font><form action=admin.php?func=saveperms method=post><br>";

reset($theperms);
reset($themasterperms);
foreach($themasterperms as $key => $val) {
if (in_array($key, $theperms)) {
echo "<input type=checkbox checked value=\"$key\" name=\"permar[]\"><font class=text12>$val</font></input><br>";
} else {
echo "<input type=checkbox value=\"$key\" name=\"permar[]\"><font class=text12>$val</font></input><br>";
}
}



echo "</td><td colspan=2 valign=bottom><input type=hidden name=usertochange value=\"$uname\"><input type=submit value=\"".pcrtlang("Save Permissions")."\" class=button></form></td></tr>";



echo "<tr><td><br>";

echo "<font class=text14b>".pcrtlang("Department Permissions").":</font><form action=admin.php?func=savedeptperms method=post><br>";

if ($deptperms != "") {
$deptperms3 = unserialize($deptperms);
} else {
$deptperms3 = array();
}
if (is_array($deptperms3)) {
$deptpermsuser = $deptperms3;
} else {
$deptpermsuser = array();
}

$rs_find_depts = "SELECT * FROM departments ORDER BY deptcode ASC";
$rs_result_depts = mysqli_query($rs_connect, $rs_find_depts);
while($rs_result_dq = mysqli_fetch_object($rs_result_depts)) {
$deptname = "$rs_result_dq->deptname";
$deptid = "$rs_result_dq->deptid";
$deptcode = "$rs_result_dq->deptcode";
if (in_array($deptid, $deptpermsuser)) {
echo "<input type=checkbox checked value=\"$deptid\" name=\"deptpermar[]\"><font class=text12>$deptcode $deptname</font></input><br>";
} else {
echo "<input type=checkbox value=\"$deptid\" name=\"deptpermar[]\"><font class=text12>$deptcode $deptname</font></input><br>";
}
}



echo "</td><td colspan=2 valign=bottom><input type=hidden name=usertochange value=\"$uname\"><input type=submit value=\"".pcrtlang("Save Department Permissions")."\" class=button></form></td></tr>";


echo "<tr><td><br>";

echo "<font class=text14b>".pcrtlang("Location Permissions").":</font><form action=admin.php?func=savelocperms method=post><br>";

if ($locperms != "") {
$locperms3 = unserialize($locperms);
} else {
$locperms3 = array();
}
if (is_array($locperms3)) {
$locpermsuser = $locperms3;
} else {
$locpermsuser = array();
}

$rs_find_locs = "SELECT * FROM locations";
$rs_result_locs = mysqli_query($rs_connect, $rs_find_locs);
while($rs_result_lq = mysqli_fetch_object($rs_result_locs)) {
$locname = "$rs_result_lq->locname";
$locid = "$rs_result_lq->locid";
if (in_array($locid, $locpermsuser)) {
echo "<input type=checkbox checked value=\"$locid\" name=\"locpermar[]\"><font class=text12>$locname</font></input><br>";
} else {
echo "<input type=checkbox value=\"$locid\" name=\"locpermar[]\"><font class=text12>$locname</font></input><br>";
}
}



echo "</td><td colspan=2 valign=bottom><input type=hidden name=usertochange value=\"$uname\"><input type=submit value=\"".pcrtlang("Save Location Permissions")."\" class=button></form></td></tr>";
}



echo "</table>";
stop_box();
echo "<br>";
}



echo "<br><font class=text14b>".pcrtlang("Add User: username/password")."</font><br>";
echo "<form action=admin.php?func=useraccountsnew method=post>";
echo "<input type=text name=uname size=30 value=\"\" class=textbox>/<input type=text name=userpass size=15 value=\"\" class=textbox>";
echo "<button type=submit class=ibutton><i class=\"fa fa-chevron-left\"></i> ".pcrtlang("Add User")."</button></form>";

stop_blue_box();

require_once("footer.php");

}


function useraccountsnew() {


require_once("validate.php");

require("deps.php");
require("common.php");

if ($ipofpc != "admin") {
perm_boot("3");
}

$uname = $_REQUEST['uname'];
$userpass = md5($_REQUEST['userpass']);

if (($uname == "") || ($_REQUEST[userpass] == "")) {
die(pcrtlang("please go back and fill both fields"));
}
 

if ($uname == "admin") {
die(pcrtlang("Cannot create account named admin"));
}

function validate_uname($uname2) {
 return preg_match('/[^a-z0-9]/i', $uname2) ? '0' : '1';
}


if (validate_uname($uname) == '0') {
die(pcrtlang("Please choose a username that contains only underscores, dashes, and alphanumeric charachers"));
}






$rs_check = "SELECT * FROM users WHERE username = '$uname'";
$rs_resultchk = mysqli_query($rs_connect, $rs_check);
$exuser = mysqli_num_rows($rs_resultchk);

if ($exuser == 0) {

$rs_insert_scan = "INSERT INTO users (username,userpass) VALUES ('$uname','$userpass')";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=useraccounts&showuser=$uname#$uname");

} else {
die(pcrtlang("Username already exists"));
}


}


function useraccounts2() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ($ipofpc != "admin") {
perm_boot("3");
}



$userid = $_REQUEST['userid'];
$userpass = md5($_REQUEST['setuserpass']);
$uname = $_REQUEST['uname'];

if ($_REQUEST['setuserpass'] == "") {
die(pcrtlang("please go back and enter a password"));
}






$rs_insert_scan = "UPDATE users SET userpass = '$userpass' WHERE userid = '$userid' AND username = '$uname'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=useraccounts&showuser=$uname#$uname");


}


function useraccountsdel() {
require_once("validate.php");

require("deps.php");
require("common.php");

if ($ipofpc != "admin") {
perm_boot("3");
}


$userid = $_REQUEST['userid'];
$uname = $_REQUEST['uname'];





$rs_find_user = "SELECT * FROM users WHERE username = '$uname' AND userid = '$userid'";
$rs_find_userq = mysqli_query($rs_connect, $rs_find_user);

$totresult = mysqli_num_rows($rs_find_userq);

if ($totresult == "1") {
$rs_insert_scan = "DELETE FROM users WHERE userid = '$userid' AND username != 'admin' AND username = '$uname'";
@mysqli_query($rs_connect, $rs_insert_scan);
header("Location: admin.php?func=useraccounts");
} else {
die("Protection Error");
}

}



function admin() {
require_once("header.php");
require_once("common.php");


start_blue_box(pcrtlang("Personal Settings"));




$rs_ql = "SELECT * FROM users WHERE username = '$ipofpc'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$defloc = "$rs_result_q1->defloc";
$gomodalindb = "$rs_result_q1->gomodal";


#echo "<br><form action=admin.php?func=setmodal method=post><font class=text12b>".pcrtlang("Use Modal Windows")."?:</font> ";

#if($gomodalindb == 0) {
#echo "<input type=radio name=modal value=1><font class=text12>".pcrtlang("Yes")."</font> ";
#echo "<input type=radio name=modal value=0 checked><font class=text12>".pcrtlang("No")."</font> ";
#} else {
#echo "<input type=radio name=modal value=1 checked><font class=text12>".pcrtlang("Yes")."</font> ";
#echo "<input type=radio name=modal value=0><font class=text12>".pcrtlang("No")."</font> ";
#}

#echo "<button type=submit class=button><i class=\"fa fa-chevron-left\"></i> ".pcrtlang("Save")."</button></form><br>";


$rs_find_tax = "SELECT * FROM locations";
$rs_result_tax = mysqli_query($rs_connect, $rs_find_tax);
echo "<form method=post action=admin.php?func=setdefloc><font class=text12b>".pcrtlang("Default Location").":</font> <select name=locname class=selects onchange='this.form.submit()'>";

while($rs_result_tq = mysqli_fetch_object($rs_result_tax)) {
$locname = "$rs_result_tq->locname";
$locid = "$rs_result_tq->locid";

if (in_array($locid, $locpermsthisuser)) {
if ($locid == $defloc) {
echo "<option selected value=$locid>$locname</option>";
} else {
echo "<option value=$locid>$locname</option>";
}
}
}
echo "</select><button type=submit class=ibutton><i class=\"fa fa-chevron-left\"></i></button></form>";

stop_blue_box();

echo "<br><br>";

start_blue_box(pcrtlang("Manage"));

if (perm_check("3") || ($ipofpc == "admin")) {
echo "<a href=admin.php?func=useraccounts class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-user fa-lg\"></i> ".pcrtlang("Manage Users")."</a><br><br>";
}


if ($ipofpc == "admin") {
echo "<a href=admin.php?func=showphpinfo class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-code fa-lg\"></i> ".pcrtlang("Show PHP Info")."</a><br><br>";
}


if (perm_check("8") || ($ipofpc == "admin")) {
echo "<a href=admin.php?func=managedept class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-cubes fa-lg\"></i> ".pcrtlang("Manage Departments")."</a><br><br>";
}

if (perm_check("9") || ($ipofpc == "admin")) {
echo "<a href=admin.php?func=manageloc class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-building fa-lg\"></i> ".pcrtlang("Manage Locations")."</a><br><br>";
}

if ($ipofpc == "admin") {
echo "<a href=admin.php?func=editdymotemp class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-credit-card fa-lg\"></i> ".pcrtlang("Edit Dymo Badge Template")."</a><br><br>";
}


stop_blue_box();
require("footer.php");

}




function setmodal() {
require_once("validate.php");

$modal = $_REQUEST['modal'];

require("deps.php");




$rs_insert_scan = "UPDATE users SET gomodal = '$modal' WHERE username = '$ipofpc'";
@mysqli_query($rs_connect, $rs_insert_scan);
header("Location: admin.php");

}

function setautoprint() {
require_once("validate.php");

$autoprint = $_REQUEST['autoprint'];

require("deps.php");




$rs_insert_scan = "UPDATE users SET autoprint = '$autoprint' WHERE username = '$ipofpc'";
@mysqli_query($rs_connect, $rs_insert_scan);
header("Location: admin.php");

}


function saveperms() {
require_once("validate.php");

if (array_key_exists('permar', $_REQUEST)) {
$permar = $_REQUEST['permar'];
} else {
$permar = array();
}

$usertochange = $_REQUEST['usertochange'];


$theperms2 = serialize($permar);

require("deps.php");
require("common.php");
if ($ipofpc != "admin") {
perm_boot("3");
}





$rs_insert_scan = "UPDATE users SET timeclockperms = '$theperms2' WHERE username = '$usertochange'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=useraccounts&showuser=$usertochange#$usertochange");

}

function savedeptperms() {
require_once("validate.php");

if (array_key_exists('deptpermar', $_REQUEST)) {
$deptpermar = $_REQUEST['deptpermar'];
} else {
$deptpermar = array();
}

$usertochange = $_REQUEST['usertochange'];


$theperms2 = serialize($deptpermar);

require("deps.php");
require("common.php");

if ($ipofpc != "admin") {
perm_boot("3");
}





$rs_insert_scan = "UPDATE users SET deptperms = '$theperms2' WHERE username = '$usertochange'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=useraccounts&showuser=$usertochange#$usertochange");


}


function savelocperms() {
require_once("validate.php");

if (array_key_exists('locpermar', $_REQUEST)) {
$locpermar = $_REQUEST['locpermar'];
} else {
$locpermar = array();
}

$usertochange = $_REQUEST['usertochange'];


$theperms2 = serialize($locpermar);

require("deps.php");
require("common.php");

if ($ipofpc != "admin") {
perm_boot("3");
}





$rs_insert_scan = "UPDATE users SET locperms = '$theperms2' WHERE username = '$usertochange'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=useraccounts");
header("Location: admin.php?func=useraccounts&showuser=$usertochange#$usertochange");

}



function showphpinfo() {
require_once("validate.php");

phpinfo();

}




function setdefloc() {
require_once("validate.php");
require("deps.php");
require("common.php");

$setusername = $ipofpc;
$setlocname = $_REQUEST['locname'];




$rs_rm_cart = "UPDATE users SET defloc = '$setlocname' WHERE username = '$setusername'";
@mysqli_query($rs_connect, $rs_rm_cart);

header("Location: admin.php");

}

function setdefloc2() {
require_once("validate.php");
require("deps.php");
require("common.php");

$setusername = $ipofpc;
$setlocname = $_REQUEST['locname'];




$rs_rm_cart = "UPDATE users SET defloc = '$setlocname' WHERE username = '$setusername'";
@mysqli_query($rs_connect, $rs_rm_cart);

header("Location: clock.php");

}



function managedept() {
require("header.php");
require_once("common.php");
require("deps.php");

perm_boot("8");





start_blue_box(pcrtlang("Departments"));

echo "<table class=stocklist><tr><td><font class=text12>".pcrtlang("Dept Code/ID")."</font></td><td><font class=text12>".pcrtlang("Department Name")."</font></td>";
echo "<td></td><td></td></tr>";

$rs_ql = "SELECT * FROM departments ORDER BY deptcode";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$deptid = "$rs_result_q1->deptid";
$deptcode = "$rs_result_q1->deptcode";
$deptname = "$rs_result_q1->deptname";


echo "<tr><td><form action=admin.php?func=editdept&deptid=$deptid method=post><input type=text class=textbox value=\"$deptcode\" name=deptcode></td>";
echo "<td><input type=text class=textbox value=\"$deptname\" name=deptname></td>";
echo "<td><input type=submit class=button value=\"".pcrtlang("Save")."\"></form></td><td>";


$rs_qd = "SELECT * FROM employees WHERE deptid = '$deptid'";
$rs_resultd = mysqli_query($rs_connect, $rs_qd);

if(mysqli_num_rows($rs_resultd) == 0) {
echo "<form action=admin.php?func=deletedept&deptid=$deptid method=post><input type=submit value=\"".pcrtlang("Delete")."\" class=button onClick=\"return confirm('".pcrtlang("Are you sure you wish to delete this Dept")."')\"></form>";
}


echo "</td></tr>";

}

echo "</table>";

stop_box();

echo "<br><br>";


start_blue_box(pcrtlang("Add New Department"));
echo "<table><tr><td><table>";
echo "<form action=admin.php?func=adddept method=post>";
echo "<tr><td><font class=text12>".pcrtlang("Department Code/ID").":</font></td><td><font class=text12b>";
echo "<input type=text name=deptcode size=25 class=\"textbox\"></font></td></tr>";
echo "<tr><td><font class=text12>".pcrtlang("Department Name").":</font></td><td><font class=text12b>";
echo "<input type=text name=deptname  class=\"textbox\" size=25></font></td></tr>";
echo "<tr><td colspan=2><input type=submit value=\"".pcrtlang("Save")."\" class=button></form></td></tr>";
echo "</table></td><td>";
echo "</td></tr></table>";
stop_blue_box();

echo "<br>";

require_once("footer.php");

}



function deletedept() {
require_once("validate.php");

require("deps.php");
require("common.php");

perm_boot("8");

$deptid = pv($_REQUEST['deptid']);




$rs_del_dd = "DELETE FROM departments WHERE deptid = '$deptid'";
@mysqli_query($rs_connect, $rs_del_dd);

header("Location: admin.php?func=managedept");

}



function adddept() {
require_once("validate.php");

require("deps.php");
require("common.php");

perm_boot("8");

$deptcode = pv($_REQUEST['deptcode']);
$deptname = pv($_REQUEST['deptname']);




$rs_insert_dept = "INSERT INTO departments (deptcode,deptname) VALUES ('$deptcode','$deptname')";
@mysqli_query($rs_connect, $rs_insert_dept);

header("Location: admin.php?func=managedept");

}


function editdept() {
require_once("validate.php");

require("deps.php");
require("common.php");

perm_boot("8");

$deptcode = pv($_REQUEST['deptcode']);
$deptname = pv($_REQUEST['deptname']);
$deptid = pv($_REQUEST['deptid']);




$rs_insert_scan = "UPDATE departments SET deptcode = '$deptcode', deptname = '$deptname' WHERE deptid = '$deptid'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=managedept");

}



function manageloc() {
require("header.php");
require_once("common.php");
require("deps.php");

perm_boot("9");





start_blue_box(pcrtlang("Locations"));

echo "<table class=stocklist><tr><td><font class=text12>".pcrtlang("Location")."</font></td>";
echo "<td></td><td></td></tr>";

$rs_ql = "SELECT * FROM locations ORDER BY locname";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$locid = "$rs_result_q1->locid";
$locname = "$rs_result_q1->locname";


echo "<tr><td><form action=admin.php?func=editloc&locid=$locid method=post>";
echo "<input type=text class=textbox value=\"$locname\" name=locname></td>";
echo "<td><input type=submit class=button value=\"".pcrtlang("Save")."\"></form></td><td>";


$rs_qd = "SELECT * FROM employees WHERE location = '$locid'";
$rs_resultd = mysqli_query($rs_connect, $rs_qd);

if(mysqli_num_rows($rs_resultd) == 0) {
echo "<form action=admin.php?func=deleteloc&locid=$locid method=post><input type=submit value=\"".pcrtlang("Delete")."\" class=button onClick=\"return confirm('".pcrtlang("Are you sure you wish to delete this location")."')\"></form>";
}

echo "</td></tr>";

}

echo "</table>";

stop_box();

echo "<br><br>";


start_blue_box(pcrtlang("Add New Location"));
echo "<table><tr><td><table>";
echo "<form action=admin.php?func=addloc method=post>";
echo "<tr><td><font class=text12>".pcrtlang("Location Name").":</font></td><td><font class=text12b>";
echo "<input type=text name=locname  class=\"textbox\" size=25></font></td></tr>";
echo "<tr><td colspan=2><input type=submit value=\"".pcrtlang("Save")."\" class=button></form></td></tr>";
echo "</table></td><td>";
echo "</td></tr></table>";
stop_blue_box();
echo "<br>";

require_once("footer.php");

}



function deleteloc() {
require_once("validate.php");

require("deps.php");
require("common.php");

perm_boot("9");

$locid = pv($_REQUEST['locid']);




$rs_del_l = "DELETE FROM locations WHERE locid = '$locid'";
@mysqli_query($rs_connect, $rs_del_l);

header("Location: admin.php?func=manageloc");

}



function addloc() {
require_once("validate.php");

require("deps.php");
require("common.php");

perm_boot("9");

$locname = pv($_REQUEST['locname']);




$rs_insert_loc = "INSERT INTO locations (locname) VALUES ('$locname')";
@mysqli_query($rs_connect, $rs_insert_loc);

header("Location: admin.php?func=manageloc");

}


function editloc() {
require_once("validate.php");

require("deps.php");
require("common.php");

perm_boot("9");

$locname = pv($_REQUEST['locname']);
$locid = pv($_REQUEST['locid']);




$rs_insert_scan = "UPDATE locations SET locname = '$locname' WHERE locid = '$locid'";
@mysqli_query($rs_connect, $rs_insert_scan);

header("Location: admin.php?func=manageloc");

}





function editdymotemp() {
require("header.php");
require_once("common.php");
require("deps.php");

if ($ipofpc != "admin") {
die("admins only");
}




mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_ql = "SELECT * FROM stores WHERE storedefault = '1'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$tempbadge = "$rs_result_q1->tempbadge";

echo "<form action=admin.php?func=editdymotemp2 method=post>";

echo "<font class=text16bu>".pcrtlang("Edit Dymo Badge Templates")."</font><br><br>";

start_box();
echo "<a href=admin.php>".pcrtlang("Return to Admin")."</a>";
stop_box();
echo "<br><br>";

start_blue_box(pcrtlang("Badge Template"));
echo "<textarea name=badge class=textboxw style=\"width:97%\" rows=1>$tempbadge</textarea>";
echo "<font class=text12>".pcrtlang("Available Variables").":<br>
".pcrtlang("Employee Name").": PCRT_EMPLOYEE_NAME<br>
".pcrtlang("Clock Number").": PCRT_CLOCK_NUMBER<br>
".pcrtlang("Employee Photo").": PCRT_EMPLOYEE_PHOTO
</font>";

echo "<br><br><a href=\"defaultbadge.label\">".pcrtlang("Default Template Download")."</a> | <font class=text12>".pcrtlang("Right Click and Choose Save As")."</font>";


stop_blue_box();
echo "<br><br>";


?>

<script type='text/javascript' src='jq/jquery.autogrow-textarea.js'></script>
<script type='text/javascript'>
  $(function() {
    $('textarea').autogrow();
  });
</script>
<?php

echo "<input type=submit value=\"".pcrtlang("Save")."\" class=button></form><br><br>";

start_box();
echo "<font class=text12>".pcrtlang("Create your label with the Dymo Label Designer software placing the variables shown here as placeholders for fields in the label.");
echo pcrtlang("Then save the file, and then open it with a text editor and paste the template text here.")."</font>";

stop_box();
require_once("footer.php");

}


function editdymotemp2() {
require_once("validate.php");


require("deps.php");
require("common.php");

if ($ipofpc != "admin") {
die("admins only");
}
$badge = pv($_REQUEST['badge']);



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_insert_text = "UPDATE stores SET tempbadge = '$badge'";
@mysqli_query($rs_connect, $rs_insert_text);

header("Location: admin.php");

}



#####

switch($func) {
                                                                                                    
    default:
    admin();
    break;
                                
   case "useraccounts":
    useraccounts();
    break;

  case "useraccountsnew":
    useraccountsnew();
    break;

 case "useraccounts2":
    useraccounts2();
    break;

 case "useraccountsdel":
    useraccountsdel();
    break;

    case "status":
    status();
    break;

case "saveperms":
    saveperms();
    break;

case "savedeptperms":
    savedeptperms();
    break;

case "savelocperms":
    savelocperms();
    break;


case "showphpinfo":
    showphpinfo();
    break;

case "settouch":
    settouch();
    break;

case "setmodal":
    setmodal();
    break;

   case "setdefloc":
    setdefloc();
    break;

   case "setdefloc2":
    setdefloc2();
    break;


   case "setautoprint":
    setautoprint();
    break;

   case "managedept":
    managedept();
    break;

   case "editdept":
    editdept();
    break;

   case "adddept":
    adddept();
    break;

   case "deletedept":
    deletedept();
    break;

   case "manageloc":
    manageloc();
    break;

   case "editloc":
    editloc();
    break;

   case "addloc":
    addloc();
    break;

   case "deleteloc":
    deleteloc();
    break;

   case "editdymotemp":
    editdymotemp();
    break;

   case "editdymotemp2":
    editdymotemp2();
    break;


}

?>


