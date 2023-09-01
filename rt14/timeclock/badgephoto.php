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


function none() {

}


function takepicture2() {

require("deps.php");
require_once("validate.php");
require("common.php");


$eidp = $_REQUEST['eid'];

$filename = "$eidp-" . time() . '.jpg';




$rs_insert_pic = "INSERT INTO ephotos (eid,photofilename) VALUES ('$eidp','$filename')";
@mysqli_query($rs_connect, $rs_insert_pic);

$result = file_put_contents("./ephotos/$filename", file_get_contents('php://input') );
if (!$result) {
	print "ERROR: Failed to write data, check permissions on the pcphotos directory ($filename)\n";
	exit();
}

$url = 'http://' . $_SERVER['HTTP_HOST'] . '/ephotos'
        . '/' . $filename;
print "$url\n";
#print "./ephotos/$filename\n";

}





function removephoto() {

require("deps.php");
require("common.php");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}

$photofilename = $_REQUEST['photofilename'];
$photoid = $_REQUEST['photoid'];
$pcid = $_REQUEST['pcid'];
$woid = $_REQUEST['woid'];

require_once("validate.php");




$rs_set_p = "DELETE FROM assetphotos WHERE pcid = '$pcid' AND assetphotoid = '$photoid'";
@mysqli_query($rs_connect, $rs_set_p);

if (file_exists("../pcphotos/$photofilename")) {
unlink("../pcphotos/$photofilename");
}


header("Location: index.php?pcwo=$woid");

}

function addemployeephoto2() {

require("deps.php");
require_once("validate.php");
require("common.php");


$eidp = $_REQUEST['eid'];

$photofilename = "$eidp-" . time() . '.jpg';
$origphotofilename = basename($_FILES['photo']['name']);

function validate_conn($v_filename) {
   return preg_match('/\.jpg$/i', $v_filename) ? '1' : '0';
}


if (validate_conn($origphotofilename) == '0') {
die(pcrtlang("File must also be a jpg"));
}


$uploaddir = "./ephotos/";
$uploadfile = $uploaddir . basename($_FILES['photo']['name']);
if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile)) {
} else {
    echo "Failed to save your image to the ephotos directory. Might want to check your permissions.\n";
}

exec("convert -geometry '320>x240>' ./ephotos/$origphotofilename ./ephotos/$photofilename");

$problem_message = "";
if (!file_exists("./ephotos/$photofilename")) {
$problem_message = "Failed to create image using ImageMagick from the command line. Looking for Apache Module...<br><br>";

if (class_exists('Imagick')) {
  $img = new Imagick();
  $img->readImage("./ephotos/$origphotofilename");
  $img->scaleImage(320,240,true);
  $img->writeImage("./ephotos/$photofilename");
  $img->clear();
  $img->destroy();
$problem_message = "ImageMagick Apache Module found... Attempting to save image...<br><br>";
if (!file_exists("./ephotos/$photofilename")) {
$problem_message = "Image Save Failed. Trying GD Module...<br><br>";
}
} else {
$problem_message = "ImageMagick Apache Module not available... Trying GD Module...<br><br>";
}
}

if (!file_exists("./ephotos/$photofilename")) {

define('THUMBNAIL_IMAGE_MAX_WIDTH', 320);
define('THUMBNAIL_IMAGE_MAX_HEIGHT', 240);

function generate_image_thumbnail($source_image_path, $thumbnail_image_path)
{
    list($source_image_width, $source_image_height, $source_image_type) = getimagesize($source_image_path);
    switch ($source_image_type) {
        case IMAGETYPE_GIF:
            $source_gd_image = imagecreatefromgif($source_image_path);
            break;
        case IMAGETYPE_JPEG:
            $source_gd_image = imagecreatefromjpeg($source_image_path);
            break;
        case IMAGETYPE_PNG:
            $source_gd_image = imagecreatefrompng($source_image_path);
            break;
    }
    if ($source_gd_image === false) {
        return false;
    }
    $source_aspect_ratio = $source_image_width / $source_image_height;
    $thumbnail_aspect_ratio = THUMBNAIL_IMAGE_MAX_WIDTH / THUMBNAIL_IMAGE_MAX_HEIGHT;
    if ($source_image_width <= THUMBNAIL_IMAGE_MAX_WIDTH && $source_image_height <= THUMBNAIL_IMAGE_MAX_HEIGHT) {
        $thumbnail_image_width = $source_image_width;
        $thumbnail_image_height = $source_image_height;
    } elseif ($thumbnail_aspect_ratio > $source_aspect_ratio) {
        $thumbnail_image_width = (int) (THUMBNAIL_IMAGE_MAX_HEIGHT * $source_aspect_ratio);
        $thumbnail_image_height = THUMBNAIL_IMAGE_MAX_HEIGHT;
    } else {
        $thumbnail_image_width = THUMBNAIL_IMAGE_MAX_WIDTH;
        $thumbnail_image_height = (int) (THUMBNAIL_IMAGE_MAX_WIDTH / $source_aspect_ratio);
    }
    $thumbnail_gd_image = imagecreatetruecolor($thumbnail_image_width, $thumbnail_image_height);
    imagecopyresampled($thumbnail_gd_image, $source_gd_image, 0, 0, 0, 0, $thumbnail_image_width, $thumbnail_image_height, $source_image_width, $source_image_height);
    imagejpeg($thumbnail_gd_image, $thumbnail_image_path, 90);
    imagedestroy($source_gd_image);
    imagedestroy($thumbnail_gd_image);
    return true;
}

generate_image_thumbnail("./ephotos/$origphotofilename", "./ephotos/$photofilename");
if (!file_exists("./ephotos/$photofilename")) {
$problem_message = "Image Save Failed using GD...<br><br>";
}
}



if (file_exists("./ephotos/$origphotofilename")) {
unlink("./ephotos/$origphotofilename");
}

if (!file_exists("./ephotos/$photofilename")) {
die("$problem_message");
}








$rs_insert_pic = "INSERT INTO ephotos (eid,photofilename) VALUES ('$eidp','$photofilename')";
@mysqli_query($rs_connect, $rs_insert_pic);


header("Location: employee.php?func=viewemployee&eid=$eidp");

}


function getimage() {

require("deps.php");

$vip = $_SERVER['REMOTE_ADDR'];

$vip2 = explode('.',$vip);

if (!in_array("$vip2[0].$vip2[1].$vip2[2]", $ips)) {
require("validate.php");
}


$ephotoid = $_REQUEST['ephotoid'];




$rs_findfileid = "SELECT photofilename FROM ephotos WHERE ephotoid = '$ephotoid'";
$rs_resultfid = mysqli_query($rs_connect, $rs_findfileid);
$rs_result_qfid = mysqli_fetch_object($rs_resultfid);
$photo_filename = "$rs_result_qfid->photofilename";


header("Content-Type: image/jpg; Content-Disposition: inline; filename=\"$photo_filename\"");
readfile("./ephotos/$photo_filename");

}



switch($func) {
                                                                                                    
    default:
    none();
    break;
                                
 
case "takepicture2":
    takepicture2();
    break;

case "removephoto":
    removephoto();
    break;


case "addemployeephoto2":
    addemployeephoto2();
    break;

case "getimage":
    getimage();
    break;


}

?>
