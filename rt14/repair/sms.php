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


function nothing() {
echo "nothing";
}

function smssend() {


if (array_key_exists('nomodal',$_REQUEST)) {
$nomodal = $_REQUEST['nomodal'];
} else {
$nomodal = "0";
}


$smsnumber = $_REQUEST['smsnumber'];
$woid = $_REQUEST['woid'];

require_once("common.php");
if(($gomodal != 1) || ($nomodal != 1)) {
require("header.php");
} else {
require("headerempty.php");
}

require("deps.php");
if(($gomodal != 1) || ($nomodal != 1)) {
start_blue_box(pcrtlang("Send SMS Message")." (".pcrtlang("gateway").": $mysmsgateway)");
} else {
echo "<font class=text16heading>".pcrtlang("Send SMS Message")." (".pcrtlang("gateway").": $mysmsgateway)</font><br><br>";
}


echo "<form action=sms.php?func=smssend2 method=post name=theform>";
echo "<table>";

echo "<tr><td><font class=text12b>".pcrtlang("SMS Number").":</font><input type=hidden name=woid value=$woid></td>";
echo "<td><input type=text class=textbox name=smsnumber value=\"$mysmsprefix$smsnumber\"></td></tr>";

$storeinfoarray = getstoreinfo($defaultuserstore);


echo "<tr><td><font class=text12b>".pcrtlang("Quick Message").":</font></td>";
echo "<td><select name=myoptions onchange='document.getElementById(\"smsmessage\").value=this.options[this.selectedIndex].value '>";
$rs_ql = "SELECT * FROM smstext ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
echo "<option value=\"\">".pcrtlang("choose a message or write your own below")."</option>";
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$smstextid = "$rs_result_q1->smstextid";
$smstext = "$rs_result_q1->smstext";
$theorder = "$rs_result_q1->theorder";
if (strlen($smstext) > 80) {
$smstextshort = substr("$smstext", 0, 80)."...";
} else {
$smstextshort = $smstext;
}
echo "<option value=\"$smstext\">$smstextshort</option>";
}
echo "</select></td></tr>";


echo "<tr><td><font class=text12b>".pcrtlang("Message").":</font><br><input type=hidden name=woid value=$woid></td>";

echo "<td><textarea cols=60 rows=4 name=smsmessage id=smsmessage class=textbox name=smsbox></textarea>";

echo "<br><font class=textgreen12b>".pcrtlang("Characters Remaining").": <span id=\"charsLeft\"></span></font></td></tr>";
echo "<tr><td><br><input type=submit value=\"".pcrtlang("Send SMS")."\" class=ibutton></td><td></td></tr>";

if ($mysmsgateway == "smsglobal") {



?>
<script type="text/javascript">
$('#smsmessage').limit('600','#charsLeft');
</script>
<?php

} elseif ($mysmsgateway == "twilio") {
?>
<script type="text/javascript">
$('#smsmessage').limit('1600','#charsLeft');
</script>
<?php


} else {

?>
<script type="text/javascript">
$('#smsmessage').limit('150','#charsLeft');
</script>
<?php

}

echo "</form></table>";

if(($gomodal != 1) || ($nomodal != 1)) {
stop_blue_box();

require_once("footer.php");
}



}




function smssend2() {

require_once("common.php");
require("deps.php");


$smsnumber = $_REQUEST['smsnumber'];
$smsmessage = $_REQUEST['smsmessage'];

#$smsnumber = "$mysmsprefix".substr("$smsnumber", 1);

$smsmessagesafe = pv("$smsmessage");

if (array_key_exists('woid',$_REQUEST)) {
$woid = $_REQUEST['woid'];
} else {
$woid = 0;
}

if (array_key_exists('groupid',$_REQUEST)) {
$groupid = $_REQUEST['groupid'];
} else {
$groupid = 0;
}


if (array_key_exists('phonenumbers',$_REQUEST)) {
$phnumbers_il = $_REQUEST['phonenumbers'];
} else {
$phnumbers_il = "";
}

if (array_key_exists('emails',$_REQUEST)) {
$emails_il = $_REQUEST['emails'];
} else {
$emails_il = "";
}


if (array_key_exists('dropoff',$_REQUEST)) {
$dropoff = $_REQUEST['dropoff'];
} else {
$dropoff = "";
}

if (array_key_exists('pickup',$_REQUEST)) {
$pickup = $_REQUEST['pickup'];
} else {
$pickup = "";
}



if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');



if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}


if ($mysmsgateway == "redoxygen") {

function post_it($datastream, $url)
{	
	$url = preg_replace("@^http://@i", "", $url);
	$host = substr($url, 0, strpos($url, "/"));
	$uri = strstr($url, "/");

	$reqbody = "";
	
	foreach($datastream as $key=>$val)
	{
		if (!empty($reqbody)) $reqbody.= "&";
		$reqbody.= $key."=".urlencode($val);
	}
	
	$contentlength = strlen($reqbody);
	$reqheader = "POST $uri HTTP/1.1\r\n".
	"Host: $host\n". "User-Agent: Mozilla/4.01 [en] (WinXP; I)\r\n".
	"Content-Type: application/x-www-form-urlencoded\r\n".
	"Content-Length: $contentlength\r\n\r\n".
	"$reqbody\r\n";

	$socket = fsockopen($host, 80, $errno, $errstr);

	if (!$socket)
	{
		$result["errno"] = $errno;
		$result["errstr"] = $errstr;
		return $result;
	}

	fputs($socket, $reqheader);

	while (!feof($socket))
	{
		$result[] = fgets($socket, 4096);
	}

	fclose($socket);
	
	return $result;
}


	$SMS_Data["Recipient"] = $smsnumber;
	$SMS_Data["Message"] = $smsmessage;

	$Result = post_it($SMS_Data, "http://sms1.redoxygen.net/sms.dll?Action=SendSMS");

	if ($Result[7] == 0)
	{

		$smssuccess = 1;

if($woid != 0) {
userlog(14,$woid,'woid',"$smsnumber - $smsmessagesafe");
}
	}
	else
	{
		$smssuccess = 0;
	}


$rs_insert_message = "INSERT INTO messages (messagefrom,messageto,messagebody,messagedatetime,messagevia,messageservice,woid,groupid,messagedirection)
VALUES ('$ipofpc','$smsnumber','$smsmessagesafe','$currentdatetime','sms','redoxygen','$woid','$groupid','out')";
@mysqli_query($rs_connect, $rs_insert_message);



} elseif ($mysmsgateway == "bulksms") {

$bulksmsnumber = preg_replace('/(\W*)/', '', $smsnumber);

if (!isset($bulksmsurl)) {
	$bulksmsurl = 'http://usa.bulksms.com/eapi/submission/send_sms/2/2.0';
}
	$bulksmsdata = "username=$bulksmsusername&password=$bulksmspassword&message=".urlencode("$smsmessage")."&msisdn=$bulksmsnumber";


 function do_post_request($bulksmsurl, $bulksmsdata, $optional_headers = null)
        {
	$params = array('http'      => array(
                'method'       => 'POST',
                'content'      => $bulksmsdata,
                       ));
        if ($optional_headers !== null) {
                $params['http']['header'] = $optional_headers;
        }

        $ctx = stream_context_create($params);
        $fp = fopen($bulksmsurl, 'rb', false, $ctx);
        $smssuccess = 1;
        fpassthru($fp);
	
        if (!$fp) {
                echo "Problem with $bulksmsurl, Cannot connect\n";
        $smssuccess = 0;
	}
	$response = @stream_get_contents($fp);
        if ($response === false) {
                echo "Problem reading data from $bulksmsurl, No status returned\n";
        $smssuccess = 0;        
	}

	return $response;
        }



	$response = do_post_request($bulksmsurl, $bulksmsdata);

if($woid != 0) {
userlog(14,$woid,'woid',"$smsnumber - $smsmessagesafe");
}


$rs_insert_message = "INSERT INTO messages (messagefrom,messageto,messagebody,messagedatetime,messagevia,messageservice,woid,groupid,messagedirection)
VALUES ('$ipofpc','$smsnumber','$smsmessagesafe','$currentdatetime','sms','bulksms','$woid','$groupid','out')";
@mysqli_query($rs_connect, $rs_insert_message);



} elseif ($mysmsgateway == "smsglobal") {




  function sendSMS($content) {
        $ch = curl_init('http://www.smsglobal.com.au/http-api.php');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec ($ch);
        curl_close ($ch);
        return $output;    
    }

    $smsglobalusername = "$smsglobalusername";
    $smsglobalpassword = "$smsglobalpassword";
    $smsglobalnumber = preg_replace('/(\W*)/', '', $smsnumber);
    $destination = "$smsglobalnumber";
    $source    = "$smsglobalsource";
    $text = "$smsmessage";
        
    $content =  'action=sendsms'.
		'&maxsplit=4'.
                '&user='.rawurlencode($smsglobalusername).
                '&password='.rawurlencode($smsglobalpassword).
                '&to='.rawurlencode($destination).
                '&from='.rawurlencode($source).
                '&text='.rawurlencode($text);

    
    $smsglobal_response = sendSMS($content);
    
    //Sample Response
    //OK: 0; Sent queued message ID: 04b4a8d4a5a02176 SMSGlobalMsgID:6613115713715266 

echo "$smsglobal_response";
    
    $explode_response = explode('SMSGlobalMsgID:', $smsglobal_response);

    if(count($explode_response) >= 2) { //Message Success

        $smsglobal_message_id = $explode_response[1];
        
        //SMSGlobal Message ID
        $smssuccess = 1;

if($woid != 0) {
userlog(14,$woid,'woid',"$smsnumber - $smsmessagesafe");
}

$rs_insert_message = "INSERT INTO messages (messagefrom,messageto,messagebody,messagedatetime,messagevia,messageservice,woid,groupid,messagedirection)
VALUES ('$ipofpc','$smsnumber','$smsmessagesafe','$currentdatetime','sms','smsglobal','$woid','$groupid','out')";
@mysqli_query($rs_connect, $rs_insert_message);

    } else { //Message Failed
        $smssuccess = 0;
        
        //SMSGlobal Response
     #   echo $smsglobal_response;    
    } 



#################################################################################
} elseif ($mysmsgateway == "clickatell") {

    $user = "$clickatelluser";
    $password = "$clickatellpassword";
    $api_id = "$clickatell_api_id";
    $baseurl ="$clickatellbaseurl";
 
  $text = bin2hex(iconv('UTF-8', 'UTF-16BE', $smsmessage));
  $to = "$smsnumber";
 
    // auth call
    $url = "$baseurl/http/auth?user=$user&password=$password&api_id=$api_id";
 
    // do auth call
    $ret = file($url);
 
    // explode our response. return string is on first line of the data returned
    $sess = explode(":",$ret[0]);
    if ($sess[0] == "OK") {
 
        $sess_id = trim($sess[1]); // remove any whitespace
        $url = "$baseurl/http/sendmsg?session_id=$sess_id&to=$to&text=$text&from=$clickatellfrom&MO=1&unicode=1";
 

        // do sendmsg call
        $ret = file($url);
        $send = explode(":",$ret[0]);
 
        if ($send[0] == "ID") {
            $clickresult = pcrtlang("Success! Message ID").": ". $send[1];

if($woid != 0) {
userlog(14,$woid,'woid',"$smsnumber - $smsmessagesafe");
}

$rs_insert_message = "INSERT INTO messages (messagefrom,messageto,messagebody,messagedatetime,messagevia,messageservice,woid,groupid,messagedirection)
VALUES ('$ipofpc','$smsnumber','$smsmessagesafe','$currentdatetime','sms','clickatell','$woid','$groupid','out')";
@mysqli_query($rs_connect, $rs_insert_message);

        $smssuccess = 1;
        } else {
	$smssuccess = 0;
        }
    } else {
         $clickresult = pcrtlang("Authentication Failure").": ". $ret[0];
        $smssuccess = 0;
    }



########################################################################################################
} elseif ($mysmsgateway == "clickatellrest") {

    $user = "$clickatelluser";
        $password = "$clickatellpassword";
            $api_id = "$clickatell_api_id";

            $numbers[] = "$smsnumber";
            $data = json_encode(array("content"=>$smsmessage,"to"=>$numbers,"from"=>"$clickatellfrom","charset"=>"UTF-8"));

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL,            "https://platform.clickatell.com/messages");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST,           1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,     $data);
            curl_setopt($ch, CURLOPT_HTTPHEADER,     array(
                "X-Version: 1",
                    "Content-Type: application/json",
                        "Accept: application/json",
                            "Authorization: $api_id"
                            ));

                            $result = curl_exec ($ch);

                            $statusarray = json_decode($result);
                            $status = $statusarray->messages['0']->accepted;


if ($status == 1) {
                            $clickresult = pcrtlang("Success!");
			        $smssuccess = 1;
				if($woid != 0) {
                            	userlog(14,$woid,'woid',"$smsnumber - $smsmessagesafe");
				}
				$rs_insert_message = "INSERT INTO messages (messagefrom,messageto,messagebody,messagedatetime,messagevia,messageservice,woid,groupid,messagedirection)
				VALUES ('$ipofpc','$smsnumber','$smsmessagesafe','$currentdatetime','sms','clickatellrest','$woid','$groupid','out')";
				@mysqli_query($rs_connect, $rs_insert_message);
                            } else {
                            $clickresult = pcrtlang("Failed to Send Message");
				print_r($statusarray);				
		       		$smssuccess = 0;
                            }





##########################################################################################################
} elseif ($mysmsgateway == "twilio") {

require('twilio/Twilio/autoload.php');
#use Twilio\Rest\Client;

if (array_key_exists('assetphotoid',$_REQUEST)) {
$storeinfoarray = getstoreinfo($defaultuserstore);
$assetphotoid = $_REQUEST['assetphotoid'];
if($assetphotoid != 0) {
$mediaurl = "$domain"."/therest.php?func=getpcimage&photoid=$assetphotoid&api_key=$storeinfoarray[storehash]";
$mediaurl2 = "pc.php?func=getpcimage&photoid=$assetphotoid";
$mediaurls[] = "$mediaurl2";
$mediaurlsserialized = serialize($mediaurls);
} else {
$assetphotoid = "0";
$mediaurlsserialized = "";    
}    
} else {
$assetphotoid = "0";
$mediaurlsserialized = "";
}


$client = new \Twilio\Rest\Client($twilio_account_sid, $twilio_auth_token);

if($assetphotoid == 0) {
$client->messages->create(
  "$smsnumber", // Text any number
  array(
  'from' => "$twilio_sms_number", // From a Twilio number in your account
  'body' => "$smsmessage"
  )
);

} else {
$client->messages->create(
  "$smsnumber", // Text any number
  array(
  'from' => "$twilio_sms_number", // From a Twilio number in your account
  'body' => "$smsmessage",
  'mediaUrl' => "$mediaurl"
  )
);

}


if($woid != 0) {
userlog(14,$woid,'woid',"$smsnumber - $smsmessagesafe");
} 



$rs_insert_message = "INSERT INTO messages (messagefrom,messageto,messagebody,messagedatetime,messagevia,messageservice,woid,groupid,messagedirection,mediaurls)
VALUES ('$ipofpc','$smsnumber','$smsmessagesafe','$currentdatetime','sms','twilio','$woid','$groupid','out','$mediaurlsserialized')";
@mysqli_query($rs_connect, $rs_insert_message);



} elseif ($mysmsgateway == "mymobileapi.com") {

//This code block can be customised. 
//The $data array contains data that must be modified as per the API documentation. The array contains data that you will post to the server
$data= array(
"Type"=> "sendparam", 
"Username" => "$mymobileapi_username",
"Password" => "$mymobileapi_password",
"live" => "true",
"numto" => "$smsnumber",
"data1" => "$smsmessage"
) ; //This contains data that you will send to the server.
$data = http_build_query($data); //builds the post string ready for posting



//Posts data to server and recieves response from server
//DO NOT EDIT unless you are sure of your changes
  function do_post_request($url, $data, $optional_headers = null)
  {
     $params = array('http' => array(
                  'method' => 'POST',
                  'content' => $data
               ));
     if ($optional_headers !== null) {
        $params['http']['header'] = $optional_headers;
     }
     $ctx = stream_context_create($params);
     $fp = @fopen($url, 'rb', false, $ctx);
     if (!$fp) {
        throw new Exception("Problem with $url, $php_errormsg");
     }
     $response = @stream_get_contents($fp);
     if ($response === false) {
        throw new Exception("Problem reading data from $url, $php_errormsg");
     }
     $response;
     return formatXmlString($response);
     
  }
?>

<?php
//takes the XML output from the server and makes it into a readable xml file layout
//DO NOT EDIT unless you are sure of your changes
function formatXmlString($xml) 
{  
  
  // add marker linefeeds to aid the pretty-tokeniser (adds a linefeed between all tag-end boundaries)
  $xml = preg_replace('/(>)(<)(\/*)/', "$1\n$2$3", $xml);
  
  // now indent the tags
  $token      = strtok($xml, "\n");
  $result     = ''; // holds formatted version as it is built
  $pad        = 0; // initial indent
  $matches    = array(); // returns from preg_matches()
  
  // scan each line and adjust indent based on opening/closing tags
  while ($token !== false) : 
  
    // test for the various tag states
    
    // 1. open and closing tags on same line - no change
    if (preg_match('/.+<\/\w[^>]*>$/', $token, $matches)) : 
      $indent=0;
    // 2. closing tag - outdent now
    elseif (preg_match('/^<\/\w/', $token, $matches)) :
      $pad--;
    // 3. opening tag - don't pad this one, only subsequent tags
    elseif (preg_match('/^<\w[^>]*[^\/]>.*$/', $token, $matches)) :
      $indent=1;
    // 4. no indentation needed
    else :
      $indent = 0; 
    endif;
    
    // pad the line with the required number of leading spaces
    $line    = str_pad($token, strlen($token)+$pad, ' ', STR_PAD_LEFT);
    $result .= $line . "\n"; // add to the cumulative result, with linefeed
    $token   = strtok("\n"); // get the next token
    $pad    += $indent; // update the pad size for subsequent lines    
  endwhile; 
  
  return $result;
}


$smsresult = do_post_request('http://www.mymobileapi.com/api5/http5.aspx', $data);  //Sends the post, and returns the result from the server.

if($woid != 0) {
userlog(14,$woid,'woid',"$smsnumber - $smsmessagesafe");
}

$rs_insert_message = "INSERT INTO messages (messagefrom,messageto,messagebody,messagedatetime,messagevia,messageservice,woid,groupid,messagedirection)
VALUES ('$ipofpc','$smsnumber','$smsmessagesafe','$currentdatetime','sms','mymobileapi.com','$woid','$groupid','out')";
@mysqli_query($rs_connect, $rs_insert_message);



} elseif ($mysmsgateway == "reliancesms.com") {

$smsnumber2 = urlencode("$smsnumber");
$smsmessage2 = urlencode("$smsmessage");

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://45.35.15.135/API/pushsms.aspx?loginID=$reliancesms_password&password=reliancesms_password&mobile=$smsnumber2&text=$smsmessage2&senderid=168&route_id=1&Unicode=0");
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_exec($ch);
	curl_close($ch);
#	echo 'Your sms sent successfully';

if($woid != 0) {
userlog(14,$woid,'woid',"$smsnumber - $smsmessagesafe");
}

$rs_insert_message = "INSERT INTO messages (messagefrom,messageto,messagebody,messagedatetime,messagevia,messageservice,woid,groupid,messagedirection)
VALUES ('$ipofpc','$smsnumber','$smsmessagesafe','$currentdatetime','sms','reliancesms.com','$woid','$groupid','out')";
@mysqli_query($rs_connect, $rs_insert_message);


} else {

echo pcrtlang("Error: No Gateway specified");
}


if (!array_key_exists('noajax',$_REQUEST)) {
if (array_key_exists('singlemessage',$_REQUEST)) {
require("ajaxcalls.php");
displaymessagessinglenumber("$smsnumber");
} else {
require("ajaxcalls.php");
displaymessages("$phnumbers_il","$emails_il","$woid","$pickup","$dropoff");
}
} else {
if (array_key_exists('groupid',$_REQUEST)) {
$pcgroupid = $_REQUEST['groupid'];
header("Location: group.php?func=viewgroup&pcgroupid=$pcgroupid&groupview=sms");
}
}



}



function smsload() {

$woid2 = $_REQUEST['woid'];
$phnumbers_il2 = $_REQUEST['phonenumbers'];
$emails_il2 = $_REQUEST['emails'];
$dropoff2 = $_REQUEST['dropoff'];
$pickup2 = $_REQUEST['pickup'];

require_once("common.php");
require("deps.php");


require("ajaxcalls.php");

displaymessages("$phnumbers_il2","$emails_il2","$woid2","$pickup2","$dropoff2");

}

function smsloadsinglenumber() {

$phnumber = $_REQUEST['phnumber'];

require_once("common.php");
require("deps.php");

require("ajaxcalls.php");

displaymessagessinglenumber("$phnumber");

}



switch($func) {
                                                                                                    
    default:
    nothing();
    break;
                                

case "smssend":
    smssend();
    break;

case "smssend2":
    smssend2();
    break;

case "smsload":
    smsload();
    break;

case "smsloadsinglenumber":
    smsloadsinglenumber();
    break;


}


