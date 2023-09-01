<?php

require("deps.php");
require("common.php");
require('twilio/Twilio/autoload.php');

$client = new \Twilio\Rest\Client($twilio_account_sid, $twilio_auth_token);


foreach ($client->messages->read() as $message) {
    echo "From: ".$message->from."<br>";
    echo "To: ".$message->to."<br>";
    echo "Message: ".$message->body."<br><br>";

echo "<br><br><hr>";
print_r($message);
echo "<br><br>";
}



?>
