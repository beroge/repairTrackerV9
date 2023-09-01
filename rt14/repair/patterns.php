<?php

function draw3x3($pattern,$size) {

$number = rand();




if($size == "normal") {
$output = "<canvas id=myCanvas$number width=80 height=80></canvas>";
$points[1] = "10, 10";
$points[2] = "40, 10";
$points[3] = "70, 10";
$points[4] = "10, 40";
$points[5] = "40, 40";
$points[6] = "70, 40";
$points[7] = "10, 70";
$points[8] = "40, 70";
$points[9] = "70, 70";

$pointsn[1] = "7, 15";
$pointsn[2] = "37, 15";
$pointsn[3] = "67, 15";
$pointsn[4] = "7, 45";
$pointsn[5] = "37, 45";
$pointsn[6] = "67, 45";
$pointsn[7] = "7, 75";
$pointsn[8] = "37, 75";
$pointsn[9] = "67, 75";
} else {
$output = "<canvas id=myCanvas$number width=60 height=60></canvas>";
$points[1] = "10, 10";
$points[2] = "30, 10";
$points[3] = "50, 10";
$points[4] = "10, 30";
$points[5] = "30, 30";
$points[6] = "50, 30";
$points[7] = "10, 50";
$points[8] = "30, 50";
$points[9] = "50, 50";

$pointsn[1] = "7, 15";
$pointsn[2] = "27, 15";
$pointsn[3] = "47, 15";
$pointsn[4] = "7, 34";
$pointsn[5] = "27, 34";
$pointsn[6] = "47, 34";
$pointsn[7] = "7, 54";
$pointsn[8] = "27, 54";
$pointsn[9] = "47, 54";

}



$numstring = str_split($pattern);

$output.= "<script>";

$output .= "var c = document.getElementById(\"myCanvas$number\");";
$output .= "var ctx = c.getContext(\"2d\");";
$output .= "ctx.lineWidth=5;";
$output .= "ctx.strokeStyle=\"#777777\";";
$output .= "ctx.lineCap=\"round\";";
$output .= "ctx.lineJoin=\"round\";";
$output .= "ctx.beginPath();";
$thepoint = "$numstring[0]";
$output .= "ctx.moveTo($points[$thepoint]);";

$startnum = 1;

foreach($numstring as $key => $val) {
$output .= "ctx.lineTo($points[$val]);\n";
}
reset($numstring);

$output .= "ctx.stroke();";

$output .= "ctx.beginPath();";
$output .= "ctx.fillStyle=\"#00FF00\";";
$thepoint2 = "$numstring[0]";
$output .= "ctx.arc($points[$thepoint2],10,0,2*Math.PI);";
$output .= "ctx.fill();";
$output .= "ctx.closePath();";


foreach($numstring as $key => $val) {
$output .= "ctx.beginPath();\n";
$output .= "ctx.fillStyle=\"#777777\";\n";
$output .= "ctx.arc($points[$val],8,0,2*Math.PI);\n";
$output .= "ctx.fill();\n";

$output .= "ctx.font = \"12px Arial\";";
$output .= "ctx.fillStyle=\"#ffffff\";\n";
$output .= "ctx.fillText(\"$startnum\",$pointsn[$val]);";

$startnum++;

}

$output .= "</script>";

return $output;

}

