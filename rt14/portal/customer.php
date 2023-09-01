<?php
                                                                                                    
/***************************************************************************
 *   copyright            : (C) 2017 PCRepairTracker.com
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


function nothing() {

echo "Nothing to see here";

}


function viewcustomer() {

require("deps.php");
require("header.php");

if($portalgroupid == "") {
die("Error");
}

echo "<h3>".pcrtlang("Your Info")."</h3><br>";

$rs_findpc = "SELECT * FROM pc_group WHERE pcgroupid = '$portalgroupid'";
$rs_result = mysqli_query($rs_connect, $rs_findpc);
$rs_result_q = mysqli_fetch_object($rs_result);
$pcgroupname = "$rs_result_q->pcgroupname";
$grpcompany = "$rs_result_q->grpcompany";
$grpphone = "$rs_result_q->grpphone";
$grpcellphone = "$rs_result_q->grpcellphone";
$grpworkphone = "$rs_result_q->grpworkphone";
$grpaddress = "$rs_result_q->grpaddress1";
$grpaddress2 = "$rs_result_q->grpaddress2";
$grpcity = "$rs_result_q->grpcity";
$grpstate = "$rs_result_q->grpstate";
$grpzip = "$rs_result_q->grpzip";
$grpemail = "$rs_result_q->grpemail";

echo "<table class=\"table table-striped\">";
echo "<tr><td><i class=\"fa fa-hashtag fa-lg pull-right fa-fw\"></i></td><td><strong>$portalgroupid</strong></td></tr>";
echo "<tr><td><i class=\"fa fa-user fa-lg pull-right fa-fw\"></i></td><td><strong>$pcgroupname</strong></td></tr>";
if($grpcompany != "") {
echo "<tr><td><i class=\"fa fa-building fa-lg pull-right fa-fw\"></i></td><td>$grpcompany</td></tr>";
}
echo "<tr><td><i class=\"fa fa-map-marker fa-lg pull-right fa-fw\"></i></td><td>$grpaddress</td></tr>";
if($grpaddress2 != "") {
echo "<tr><td></td><td>$grpaddress2</td></tr>";
}
echo "<tr><td></td><td>$grpcity, $grpstate $grpzip</td></tr>";
echo "<tr><td></td><td></td></tr>";
if($grpphone != "") {
echo "<tr><td><i class=\"fa fa-phone fa-lg pull-right fa-fw\"></i></td><td>$grpphone</td></tr>";
}
if($grpcellphone != "") {
echo "<tr><td><i class=\"fa fa-mobile fa-lg pull-right fa-fw\"></i></td><td>$grpcellphone</td></tr>";
}
if($grpworkphone != "") {
echo "<tr><td><i class=\"fa fa-briefcase fa-lg pull-right fa-fw\"></i></td><td>$grpworkphone</td></tr>";
}
if($grpemail != "") {
echo "<tr><td><i class=\"fa fa-envelope fa-lg pull-right fa-fw\"></i></td><td>$grpemail</td></tr>";
}


echo "</table><br>";

echo "<h3>".pcrtlang("Change Your Password")."</h3><br>";

if (array_key_exists('passsaved',$_REQUEST)) {
echo "<p class=\"text-success\"><i class=\"fa fa-bell fa-lg\"></i> ".pcrtlang("Password Updated...")."</p><br><br>";
}

?>



    <script type="text/javascript">
        $(document).ready(function() {
            $('#example-progress-bar').strengthMeter('progressBar', {
                container: $('#example-progress-bar-container'),
		hierarchy: {
	    	'0': 'progress-bar-danger',
    		'20': 'progress-bar-warning',
    		'40': 'progress-bar-success'
}
            });
        });
    </script>
    <form class="form-horizontal" method=post action=account.php?func=updatepassword>
        <div class="form-group">
            <label class="form-label col-sm-2"><?php echo pcrtlang("Password"); ?></label>
            <div class="col-sm-4">
                <input type="text" name="passwor" placeholder="<?php echo pcrtlang("Password ..."); ?>" class="form-control" id="example-progress-bar" autocomplete="off" minlength=6/>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label col-sm-2"><?php echo pcrtlang("Password Strength"); ?></label>
            <div class="col-sm-4" id="example-progress-bar-container">
     
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button class="btn btn-primary"><?php echo pcrtlang("Update"); ?></button>
            </div>
        </div>
    </form>




<script type="text/javascript" src="bs/password-score.js"></script>
<script type="text/javascript" src="bs/password-score-options.js"></script>
<script type="text/javascript" src="bs/bootstrap-strength-meter.js"></script>







<?php

require("footer.php");
}

##########


function messageload() {

require_once("common.php");
require("deps.php");

require("pajaxcalls.php");

displaymessages();

}



function addmessage() {
require_once("validate.php");
require("deps.php");
require("common.php");

$themessage = pv($_REQUEST['themessage']);
$messagephone = pv($_REQUEST['messagephone']);

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

$rs_insert_message = "INSERT INTO messages (messagefrom,messagebody,messagedatetime,messagevia,groupid,messagedirection)
VALUES ('$messagephone','$themessage','$currentdatetime','im','$portalgroupid','in')";

@mysqli_query($rs_connect, $rs_insert_message);

require("pajaxcalls.php");
displaymessages();

}


function getfile() {

require("deps.php");
require("common.php");

$downloadid = pv($_REQUEST['downloadid']);
$groupid = pv($_REQUEST['groupid']);

$rs_findfileid = "SELECT * FROM portaldownloads WHERE downloadid = '$downloadid' AND groupid = '$groupid'";
$rs_resultfid = mysqli_query($rs_connect, $rs_findfileid);

if(mysqli_num_rows($rs_resultfid) != 0) {

$rs_result_qfid = mysqli_fetch_object($rs_resultfid);
$download_filename = "$rs_result_qfid->downloadfilename";
$storedas = "$rs_result_qfid->storedas";

header('Content-Type: application/octet-stream');
header("Content-Disposition: attachment; filename=\"$download_filename\"");
readfile("./downloads/$storedas");

} else {
echo "Error";
}

}



switch($func) {
                                                                                                    
    default:
    nothing();
    break;
                                
    case "viewcustomer":
    viewcustomer();
    break;

    case "messageload":
    messageload();
    break;

    case "addmessage":
    addmessage();
    break;

    case "getfile":
    getfile();
    break;


}

