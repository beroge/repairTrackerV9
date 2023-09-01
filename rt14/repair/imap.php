<?php

require("deps.php");
require("validate.php");

$imap_username = "";
$imap_password = "";
$imap_hostname = "imap.gmail.com";
$imap_folder = "d7";



































function getFileExtension($fileName){
   $parts=explode(".",$fileName);
   return $parts[count($parts)-1];
}

/* connect to imap */
$hostname = '{'."$imap_hostname".':993/imap/ssl}'."$imap_folder";
$username = $imap_username;
$password = $imap_password;

$imap = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());

$message_count = imap_num_msg($imap);
for ($m = 1; $m <= $message_count; ++$m){

    $header = imap_header($imap, $m);
    //print_r($header);


// - Code for future reference.
//    $email[$m]['from'] = $header->from[0]->mailbox.'@'.$header->from[0]->host;
//    $email[$m]['fromaddress'] = $header->from[0]->personal;
//    $email[$m]['to'] = $header->to[0]->mailbox;
//    $email[$m]['subject'] = $header->subject;
//    $email[$m]['message_id'] = $header->message_id;
//    $email[$m]['date'] = $header->udate;

//    $from = $email[$m]['fromaddress'];
//    $from_email = $email[$m]['from'];
//    $to = $email[$m]['to'];
//    $subject = $email[$m]['subject'];

//    echo $from_email . '</br>';
//    echo $to . '</br>';
//    echo $subject . '</br>';

$emailsubject = $header->subject;

$emailsubject = array_values(array_filter(explode('_',preg_replace('/[^a-z0-9]/i', '_', $emailsubject))));

$zipfilename = $emailsubject[1]."_".$emailsubject[0]."_d7_Report.zip";


    $structure = imap_fetchstructure($imap, $m);

    $attachments = array();
    if(isset($structure->parts) && count($structure->parts)) {

        for($i = 0; $i < count($structure->parts); $i++) {

            $attachments[$i] = array(
                'is_attachment' => false,
                'filename' => '',
                'name' => '',
                'attachment' => ''
            );

            if($structure->parts[$i]->ifdparameters) {
                foreach($structure->parts[$i]->dparameters as $object) {
                    if(strtolower($object->attribute) == 'filename') {
                        $attachments[$i]['is_attachment'] = true;
                        $attachments[$i]['filename'] = $object->value;
                    }
                }
            }

            if($structure->parts[$i]->ifparameters) {
                foreach($structure->parts[$i]->parameters as $object) {
                    if(strtolower($object->attribute) == 'name') {
                        $attachments[$i]['is_attachment'] = true;
                        $attachments[$i]['name'] = $object->value;
                    }
                }
            }

            if($attachments[$i]['is_attachment']) {
                $attachments[$i]['attachment'] = imap_fetchbody($imap, $m, $i+1);
                if($structure->parts[$i]->encoding == 3) { // 3 = BASE64
                    $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
                }
                elseif($structure->parts[$i]->encoding == 4) { // 4 = QUOTED-PRINTABLE
                    $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
                }
            }
        }
    }



    foreach ($attachments as $key => $attachment) {
        $contents = $attachment['attachment'];
		if($attachment['name'] != "") {
        		file_put_contents("$d7_report_upload_directory"."$zipfilename", $contents);
			echo "Saved: $zipfilename<br>"; 
		}

   }



    imap_delete($imap, $m);
}
imap_expunge($imap);
imap_close($imap);
