<?php
require("validate2.php");
require_once("common.php");


showpcs();

echo "<br>";

$rewoor = pcrtlang("Recent Work Orders");
start_blue_box("$rewoor");

recentwork();

stop_blue_box();

echo "<br>";

?>
