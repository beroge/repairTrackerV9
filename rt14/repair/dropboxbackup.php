<?php



require_once("validate.php");

require("deps.php");

require("common.php");

if (!isset($dropboxaccessToken)) {
die(pcrtlang("Please configure your dropbox credentials in the configuration first."));
}


perm_boot("29");


if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

$setdate = "UPDATE stores SET lastbackup = '$currentdatetime'";
@mysqli_query($rs_connect, $setdate);


require("header.php");

start_blue_box(pcrtlang("Backup to Dropbox"));

echo pcrtlang("Backing up database to Dropbox")."....";


set_time_limit(500);

function mysql_dump() {
require("deps.php");


mysqli_query($rs_connect, "SET NAMES 'utf8'");

$database = $dbname;
define("lnbr", "\n");
$query = '';

$databasesql = "SHOW TABLES FROM $database";
$tables = @mysqli_query($rs_connect, $databasesql);
while ($row = @mysqli_fetch_row($tables)) { $table_list[] = $row[0]; }

for ($i = 0; $i < @count($table_list); $i++) {

$query .= 'DROP TABLE IF EXISTS `' . $table_list[$i] . '`;' . lnbr;

$results = mysqli_query($rs_connect, "SHOW CREATE TABLE $table_list[$i]");
while ($row = @mysqli_fetch_assoc($results)) {
$query .= $row['Create Table'];
}


$query .= ';' . str_repeat(lnbr, 2);

$results = mysqli_query($rs_connect, 'SELECT * FROM ' . $table_list[$i]);

while ($row = @mysqli_fetch_assoc($results)) {

$query .= 'INSERT INTO `' . $table_list[$i] .'` (';

$data = Array();

foreach($row as $key => $value) { $data['keys'][] = $key; $data['values'][] = addslashes($value); }

$query .= join($data['keys'], ', ') . ')' . lnbr . 'VALUES (\'' . join($data['values'], '\', \'') . '\');' . lnbr;

}

$query .= str_repeat(lnbr, 2);

}

return $query;
}

$prefix = "pcrt_db_";
$backupFilename = $prefix.date('Y_m_d__H_i_s').".sql";

$file = mysql_dump();

set_time_limit(500);

$zip = new ZipArchive;
$res = $zip->open('../attachments/'.$backupFilename.'.zip', ZipArchive::CREATE);
if ($res === TRUE) {
    $zip->addFromString($backupFilename, $file);
    $zip->close();
    echo "<br><br>".pcrtlang("Zip successful");
} else {
    echo "<br><br>".pcrtlang("Failed to zip database file");
}

$size = formatBytes(filesize('../attachments/'.$backupFilename.'.zip'));

echo "<br><br>".pcrtlang("Zip filesize").": $size";

echo "<br><br>".pcrtlang("Uploading to Dropbox")."....";

set_time_limit(500);


$path = '../attachments/'.$backupFilename.'.zip';
$fp = fopen($path, 'rb');
$size = filesize($path);

$cheaders = array("Authorization: Bearer $dropboxaccessToken",
                  'Content-Type: application/octet-stream',
                  'Dropbox-API-Arg: {"path":"/'.$backupFilename.'.zip",  "mode":"add"}');

$ch = curl_init('https://content.dropboxapi.com/2/files/upload');
curl_setopt($ch, CURLOPT_HTTPHEADER, $cheaders);
curl_setopt($ch, CURLOPT_PUT, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_INFILE, $fp);
curl_setopt($ch, CURLOPT_INFILESIZE, $size);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

echo "<pre>";
echo json_encode(json_decode($response), JSON_PRETTY_PRINT);
echo "</pre>";
curl_close($ch);
fclose($fp);


echo "<br><br>".pcrtlang("Deleting Temp File")."....";

unlink('../attachments/'.$backupFilename.'.zip');

echo "<br><br>".pcrtlang("Finished")."!";



stop_blue_box();

require("footer.php");
