<?php

$pcpriority = array('blue' => '1','green' => '2','red' => '2');

while (list($key, $val) = each($pcpriority)) {
echo "$key - $val <br>";
}

echo "<br><br>";

foreach($pcpriority as $key2 => $val2) {
echo "$key2 - $val2 <br>";
}

echo "<br><br>";

foreach($pcpriority as $key2 => $val2) {
echo "$key2 - $val2 <br>";
}

