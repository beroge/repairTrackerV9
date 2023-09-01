<?php



function brandicon($pcmake) {

$pcimages = array(
"laptop" => "laptop.png",
"notebook" => "laptop.png",
"printer" => "printer.png",
"tablet" => "tablet.png",
"tab" => "tablet.png",
"ticket" => "ticket.png",
"other" => "ticket.png",
"router" => "router.png",
"reader" => "tablet.png",
"ipad" => "ipad.png",
"iphone" => "iphone.png",
"xbox" => "xbox.png",
"ps3" => "ps3.png",
"playstation" => "ps3.png",
"wii" => "wii.png",
"lexmark_printer" => "lexmark_printer.png",
"epson_printer" => "epson_printer.png",
"canon_printer" => "canon_printer.png",
"kodak_printer" => "kodak_printer.png",
"droid" => "android_phone.png",
"compaq" => "compaq_tower.png",
"compaq_laptop_notebook_netbook" => "compaq_laptop.png",
"hp" => "hp_tower.png",
"hp_laptop_notebook_netbook" => "hp_laptop.png",
"hp_tablet_touchpad" => "hp_tablet.png",
"hp_printer" => "hp_printer.png",
"acer" => "acer_tower.png",
"acer_laptop_notebook_netbook" => "acer_laptop.png",
"acer_tablet_iconia" => "acer_tablet.png",
"asus" => "asus_tower.png",
"asus_laptop_notebook_netbook" => "asus_laptop.png",
"lenovo" => "lenovo_tower.png",
"lenovo_laptop_notebook_netbook" => "lenovo_laptop.png",
"lenovo_tablet" => "lenovo_tablet.png",
"toshiba" => "toshiba_tower.png",
"toshiba_laptop_notebook_netbook" => "toshiba_laptop.png",
"toshiba_tablet_thrive" => "toshiba_tablet.png",
"ibm" => "ibm_tower.png",
"ibm_laptop_notebook_netbook_thinkpad" => "ibm_laptop.png",
"gateway" => "gateway_tower.png",
"gateway_laptop_notebook_netbook" => "gateway_laptop.png",
"emachine" => "emachine_tower.png",
"emachine_laptop_notebook_netbook" => "emachine_laptop.png",
"packard" => "packbell_tower.png",
"packard_laptop_notebook_netbook" => "packbell_laptop.png",
"sony" => "sony_tower.png",
"sony_laptop_notebook_netbook" => "sony_laptop.png",
"sony_tablet" => "sony_tablet.png",
"sony_ps3" => "ps3.png",
"apple" => "apple_tower.png",
"apple_laptop_notebook_netbook_macbook" => "apple_laptop.png",
"apple_tablet_ipad" => "ipad.png",
"apple_iphone" => "iphone.png",
"micron" => "micron_tower.png",
"micron_laptop_notebook_netbook" => "micron_laptop.png",
"samsung" => "samsung_tower.png",
"samsung_laptop_notebook_netbook" => "samsung_laptop.png",
"samsung_tablet_galaxy" => "samsung_tablet.png",
"samsung_phone" => "samsung_phone.png",
"clevo" => "clevo_tower.png",
"clevo_laptop_notebook_netbook" => "clevo_laptop.png",
"advent_tower" => "advent_tower.png",
"advent_laptop_notebook_netbook" => "advent_laptop.png",
"fujitsu" => "fujitsu_tower.png",
"fujitsu_laptop_notebook_netbook" => "fujitsu_laptop.png",
"gericom" => "gericom_tower.png",
"gericom_laptop_notebook_netbook" => "gericom_laptop.png",
"gigabyte" => "gigabyte_tower.png",
"gigabyte_laptop_notebook_netbook" => "gigabyte_laptop.png",
"hitachi" => "hitachi_tower.png",
"hitachi_laptop_notebook_netbook" => "hitachi_laptop.png",
"jvc" => "jvc_tower.png",
"jvc_laptop_notebook_netbook" => "jvc_laptop.png",
"lg" => "lg_tower.png",
"lg_laptop" => "lg_laptop.png",
"lg_notebook_notebook_netbook" => "lg_laptop.png",
"nec" => "nec_tower.png",
"nec_laptop_notebook_netbook" => "nec_laptop.png",
"panasonic" => "panasonic_tower.png",
"panasonic_laptop_notebook_netbook_toughbook" => "panasonic_laptop.png",
"siemens" => "siemens_tower.png",
"siemens_laptop_notebook_netbook" => "siemens_laptop.png",
"blackberry" => "blackberry.png",
"blackberry_tablet_playbook" => "blackberry_tablet.png",
"dell" => "dell_tower.png",
"dell_laptop_notebook_netbook" => "dell_laptop.png",
"dell_tablet_streak" => "dell_tablet.png",
"dell_phone" => "dell_phone.png",
"dell_printer" => "dell_printer.png"
);

$counter = array();
foreach($pcimages as $key => $val) {
$keyarray = explode("_", $key);
$thecount = count($keyarray);
foreach($keyarray as $key2 => $val2) {
if (preg_match("/$val2/i", $pcmake)) {
if(!array_key_exists("$key", $counter)) {
$counter[$key] = 0;
}
$counter[$key] = $counter[$key] + 2;
if($thecount == 1) {
$counter[$key] = $counter[$key] + 1;
}
}
}
}
arsort($counter);
$resultcount = count($counter);

if ($resultcount > 0) {
$first2 = array_keys($counter);
$first = array_shift($first2);
$theicon =  $pcimages[$first];
} else {
$theicon = "tower.png";
}

return $theicon;

}

?>
