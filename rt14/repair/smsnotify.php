<?php
                                                                                                    
/***************************************************************************
 *   copyright            : (C) 2020 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/

require_once("validate.php");

function smssend($smsnumber,$smsmessage) {

#$smsnumber = $_REQUEST['smsnumber'];
#$smsmessage = $_REQUEST['smsmessage'];

require_once("common.php");
require("deps.php");


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

	post_it($SMS_Data, "http://sms1.redoxygen.net/sms.dll?Action=SendSMS");


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
#        fpassthru($fp);
	
        if (!$fp) {
                echo "Problem with $bulksmsurl, Cannot connect\n";
        }
	$response = @stream_get_contents($fp);
        if ($response === false) {
                echo "Problem reading data from $bulksmsurl, No status returned\n";
        }

        }



do_post_request($bulksmsurl, $bulksmsdata);



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
    
    sendSMS($content);
    
    
} elseif ($mysmsgateway == "clickatell") {


    $user = "$clickatelluser";
    $password = "$clickatellpassword";
    $api_id = "$clickatell_api_id";
    $baseurl ="$clickatellbaseurl";
 
    $text = urlencode("$smsmessage");
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
            $clickresult = "Success! Message ID: ". $send[1];
        } else {
             $clickresult = "Failed to Send Message";
        }
    } else {
         $clickresult = "Authentication Failure: ". $ret[0];
    }

########################################################################################################
} elseif ($mysmsgateway == "clickatellrest") {

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
                            $clickresult = "Success!";
                            } else {
                            $clickresult = "Failed to Send Message";
                            }

                            
##########################################################################################################

} elseif ($mysmsgateway == "twilio") {


require('twilio/Twilio/autoload.php');

$client = new \Twilio\Rest\Client($twilio_account_sid, $twilio_auth_token);
$client->messages->create(
  "$smsnumber", // Text any number
  array(
  'from' => "$twilio_sms_number", // From a Twilio number in your account
  'body' => "$smsmessage"
  )
);


} elseif ($mysmsgateway == "freesmsgateway.com") {

$url = "http://www.freesmsgateway.com/api_send";

$post_contacts = array("$smsnumber");
$json_contacts = json_encode($post_contacts);

$fields = array(
'access_token'=>"$freesmsgatewaycom_access_token",
'message'=>urlencode("$smsmessage"),
'send_to'=>'post_contacts',
'post_contacts'=>urlencode($json_contacts)
);

$fields_string = '';

foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string,'&');

$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_POST,count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);

curl_close($ch);



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

do_post_request('http://www.mymobileapi.com/api5/http5.aspx', $data);  //Sends the post, and returns the result from the server.


} else {

echo "Error: No SMS Gateway specified";
}

}

?>
