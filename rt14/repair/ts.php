<?php


$json = file_get_contents('php://input');
$action = json_decode($json, true);






$cont = "";
while (list($key, $val) = each($action)) {
$cont .= "$key : $val /n";
}

$file = fopen("../d7/test.txt","w");
echo fwrite($file,"$cont");
fclose($file);



?>
