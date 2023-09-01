<?php 

/***************************************************************************
 *   copyright            : (C) 2010 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/
require("deps.php");
require("common.php");
require_once("validate.php");


perm_boot("6");

$name2 = htmlspecialchars($_REQUEST['name'], ENT_QUOTES, "UTF-8");
$clocknumber = $_REQUEST['clocknumber'];
$backurl = $_REQUEST['backurl'];
$eidp = $_REQUEST['eid'];




mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_ql = "SELECT * FROM stores WHERE storedefault = '1'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$labeldata5 = "$rs_result_q1->tempbadge";





function base64_encode_image ($filename=string,$filetype=string) {
    if ($filename) {
#$imgbinary = fread(fopen($filename, "r"), filesize($filename));
$imageraw = imagecreatefromjpeg($filename);
if(!$imageraw) {
die("Failed to open image");
}

imagefilter($imageraw, IMG_FILTER_GRAYSCALE);
imagefilter($imageraw, IMG_FILTER_BRIGHTNESS, 80);

ob_start();
$imgbinary2 = imagejpeg($imageraw);
imagedestroy($imgbinary2);
$imgbinary = ob_get_clean();

        return base64_encode($imgbinary);
    }
}


$rs_assetphotos = "SELECT * FROM ephotos WHERE eid = '$eidp' ORDER BY addtime DESC LIMIT 1";
$rs_result_aset = mysqli_query($rs_connect, $rs_assetphotos);

$prows = mysqli_num_rows($rs_result_aset);

if ($prows != 0) {
$rs_result_aset2 = mysqli_fetch_object($rs_result_aset);
$photofilename = "$rs_result_aset2->photofilename";
$emp_photo2 = "ephotos/$photofilename";
} else {
$emp_photo2 = "nophoto.png";
}



$emp_photo =  base64_encode_image("$emp_photo2","png");



$labeldata = str_replace(
  array('PCRT_EMPLOYEE_NAME','PCRT_CLOCK_NUMBER','PCRT_EMPLOYEE_PHOTO'), 
  array(addslashes("$name2"),addslashes("$clocknumber"),"$emp_photo"), 
  $labeldata5
);

if (!array_key_exists('dymojsapi',$_REQUEST)) {
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"badge.label\"");
echo $labeldata; 
} else {
$dymojsapi = $_REQUEST['dymojsapi'];
if($dymojsapi == "html") {
#####

require("header.php");

$name_ue = urlencode($_REQUEST['name']);
$clocknumber_ue = urlencode($_REQUEST['clocknumber']);

start_blue_box(pcrtlang("Print Employee Badge"));


?>



            <label for="printersSelect"><font class=text12b><?php echo pcrtlang("Select Printer"); ?>:</font></label><br>
            <select id="printersSelect"></select>

<br><br><table><tr><td>
<font class=text12b><?php echo pcrtlang("Label Qty"); ?>:</font></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td colspan=5><font class=text12b><?php echo pcrtlang("Select Roll (Twin Turbo Printer Only)"); ?>:</font></td></tr>
<tr><td><input type=number value=1 name=labelqty id=labelcount class=textbox min="1" max="50">
</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td style="vertical-align:top; width:100px; text-align:left;">
<div class="radiobox">
<input type=radio id="Left" value="Left" name="labelside"><label for="Left">&laquo; <?php echo pcrtlang("Left"); ?></input></label></div> </td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td style="vertical-align:top; width:100px; text-align:center;">
<div class="radiobox"><input type=radio id="Auto" value="Auto" name="labelside" checked><label for="Auto"> <?php echo pcrtlang("Auto"); ?></input></label></div></td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td style="vertical-align:top; width:100px; text-align:right;">
<div class="radiobox"><input type=radio id="Right" value="Right" name="labelside"><label for="Right"> <?php echo pcrtlang("Right"); ?> &raquo;</input></label></div>
</td></tr>

<tr><td>
</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td colspan=5><font class=text12b><?php echo pcrtlang("Print Speed"); ?>:</font></td></tr>
<tr><td>
</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td style="vertical-align:top; width:100px; text-align:center;">
<div class="radiobox">
<input type=radio id="BarcodeAndGraphics" value="BarcodeAndGraphics" name="labelspeed" checked><label for="BarcodeAndGraphics"> <?php echo pcrtlang("Fine"); ?></input></label></div> </td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td style="vertical-align:top; width:100px; text-align:center;">
<div class="radiobox"><input type=radio id="AutoS" value="Auto" name="labelspeed"><label for="AutoS"> <?php echo pcrtlang("Auto"); ?></input></label></div></td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td style="vertical-align:top; width:100px; text-align:center;">
<div class="radiobox"><input type=radio id="Draft" value="Text" name="labelspeed"><label for="Draft"> <?php echo pcrtlang("Draft"); ?> </input></label></div>
</td></tr>



</table>


<br><button class=button onclick="parent.location='<?php echo "$backurl"; ?>'">&laquo;<?php echo pcrtlang("Back"); ?></button>&nbsp;&nbsp;&nbsp;
<button id="printButton" class=button><?php echo pcrtlang("Print"); ?></button><br><br>

<?php
echo "<a href=\"badge.php?clocknumber=$clocknumber&eid=$eidp&name=$name_ue&backurl=index.php\" class=boldlink>".pcrtlang("Download Badge")."</a><br><br>";
?>

<?php
start_box_nested();

echo "<a href=\"badge.php?clocknumber=$clocknumber&eid=$eidp&dymojsapi=html&name=$name_ue&backurl=$backurl\" class=boldlink>".pcrtlang("Reload Badge Photo")."</a>";

echo "<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img id=\"labelImage\" src=\"\" alt=\"label preview\"><br><br>";
stop_box();
?>

<script src="jq/DYMO.Label.Framework.latest.js" type="text/javascript" charset="UTF-8"></script>
<script src="badge.php?clocknumber=<?php echo "$clocknumber"; ?>&name=<?php echo "$name_ue"; ?>&eid=<?php echo "$eidp"; ?>&dymojsapi=yes&backurl=index.php" type="text/javascript" charset="UTF-8"></script>



<?php

stop_blue_box();

############################################################
echo "<br><br>";
start_blue_box("Take Employee Photo");

?>
	<table align=top><tr><td valign=top>
	<font class=text14b><?php echo pcrtlang("Upload Employee Photos"); ?></font><br><br>
	
	<!-- First, include the JPEGCam JavaScript Library -->
	<script type="text/javascript" src="webcam.js"></script>
	
	<!-- Configure a few settings -->
	<script language="JavaScript">
		webcam.set_api_url( 'badgephoto.php?func=takepicture2&eid=<?php echo "$eidp"; ?>' );
		webcam.set_quality( 90 ); // JPEG quality (1 - 100)
		webcam.set_shutter_sound( true ); // play shutter click sound
	</script>
	
	<!-- Next, write the movie to the page at 320x240 -->
	<script language="JavaScript">
		document.write( webcam.get_html(320, 240) );
	</script>
	
	<!-- Some buttons for controlling things -->
	<br/><form><br><br>
		<input type=button class=button value="<?php echo pcrtlang("Configure"); ?>..." onClick="webcam.configure()">
		&nbsp;&nbsp;
		<input type=button class=button value="<?php echo pcrtlang("Capture"); ?>" onClick="webcam.freeze()">
		&nbsp;&nbsp;
		<input type=button class=ibutton value="<?php echo pcrtlang("Upload"); ?>" onClick="do_upload()">
		&nbsp;&nbsp;
		<input type=button class=button value="<?php echo pcrtlang("Reset"); ?>" onClick="webcam.reset()">
	</form>
	
	<!-- Code to handle the server response (see test.php) -->
	<script language="JavaScript">
		webcam.set_hook( 'onComplete', 'my_completion_handler' );
		
		function do_upload() {
			// upload to server
			document.getElementById('upload_results').innerHTML = '<font class=text12><?php echo pcrtlang("Uploading"); ?>...</font><br>';
			webcam.upload();
		}
		
		function my_completion_handler(msg) {
			// extract URL out of PHP output
			if (msg.match(/(http\:\/\/\S+)/)) {
				var image_url = RegExp.$1;
				// show JPEG image in page
				document.getElementById('upload_results').innerHTML = 
					'<font class=textblue12b><?php echo pcrtlang("Upload Successful"); ?>...</font><br><br>' + 
					'<img src="' + image_url + '">';
				
				// reset camera for another shot
				webcam.reset();
			}
			else alert("PHP Error: " + msg);
		}
	</script>
	
	</td><td width=50>&nbsp;</td><td valign=top>
		<div id="upload_results" style="background-color:#eee;"></div>

<?php

echo "</td></tr></table><br><a href=>".pcrtlang("Reload Applet")."</a>";

stop_blue_box();
echo "<br><br>";
start_blue_box(pcrtlang("Alternate Method"));	
echo "<form action=badgephoto.php?func=addemployeephoto2 method=post enctype=\"multipart/form-data\">";
echo "<table width=100%>";
echo "<tr><td><font class=text14b>".pcrtlang("Take Photo").":</font></td><td><input type=file name=photo accept=\"image/*;capture=camera\">";
echo "<input type=hidden name=woid value=$eidp><input type=hidden name=eid value=$eidp></td></tr>";
echo "<tr><td>&nbsp;</td><td><br><br><br><input type=submit class=button value=\"".pcrtlang("Upload Photo")."\"></form></td></tr>";
echo "</table>";


stop_blue_box();





##############################################################




require_once("footer.php");

#####
} else {
$labeldata2 = str_replace("\r\n", "\\\n", "$labeldata");
#$labeldata2 = "$labeldata";
?>
(function()
{


    // called when the document completly loaded
    function onload()
    {
        var printButton = document.getElementById('printButton');
        var printerName = document.getElementById('printerName');

	function loadPrinters()
        {
            var printers = dymo.label.framework.getPrinters();
            if (printers.length == 0)
            {
               alert("<?php echo pcrtlang("No DYMO printers can be found. Please install the DYMO labelwriter software"); ?>.");
                return;
            }

            for (var i = 0; i < printers.length; i++)
            {
                var printer = printers[i];
                if (printer.printerType == "LabelWriterPrinter")
                {
                    var printerName = printer.name;

                    var option = document.createElement('option');
                    option.value = printerName;
                    option.appendChild(document.createTextNode(printerName));
                    printersSelect.appendChild(option);
                }
            }
        }

// preview
       function updatePreview()
        {

                var labelXml = '<?php echo $labeldata2; ?>';
                var label = dymo.label.framework.openLabelXml(labelXml);

            if (!label)
                return;

            var pngData = label.render();

            var labelImage = document.getElementById('labelImage');
            labelImage.src = "data:image/png;base64," + pngData;
        }



        // prints the label
        printButton.onclick = function()
        {
            try
            {
                // open label
                var labelXml = '<?php echo $labeldata2; ?>';
                var label = dymo.label.framework.openLabelXml(labelXml);

	var labelcount = document.getElementById('labelcount');
//	printParamsXml = dymo.label.framework.createLabelWriterPrintParamsXml({copies: labelcount.value});

var radioButtons = document.getElementsByName("labelside");
for (var x = 0; x < radioButtons.length; x ++) {
if (radioButtons[x].checked) {
      var LabelSide = radioButtons[x].value;
}
}

var radioButtonsSpeed = document.getElementsByName("labelspeed");
for (var x = 0; x < radioButtonsSpeed.length; x ++) {
if (radioButtonsSpeed[x].checked) {
      var LabelSpeed = radioButtonsSpeed[x].value;
}
}


                var printerName = document.getElementById('printersSelect');

var printers = dymo.label.framework.getPrinters();
var printer = printers[printerName.value];

if (typeof printer.isTwinTurbo != "undefined")
    {
        if (printer.isTwinTurbo)
        printParamsXml = dymo.label.framework.createLabelWriterPrintParamsXml({copies: labelcount.value, twinTurboRoll: LabelSide, printQuality: LabelSpeed});
        else
        printParamsXml = dymo.label.framework.createLabelWriterPrintParamsXml({copies: labelcount.value, printQuality: LabelSpeed});
    }
else
    {
        printParamsXml = dymo.label.framework.createLabelWriterPrintParamsXml({copies: labelcount.value, printQuality: LabelSpeed});
    }

//alert(LabelSide);
//alert(printer.isTwinTurbo);
//alert(printParamsXml);

                label.print(printerName.value,printParamsXml);
            }
            catch(e)
            {
                alert(e.message || e);
            }
        }
       loadPrinters();
       updatePreview();
    };

    // register onload event
    if (window.addEventListener)
        window.addEventListener("load", onload, false);
    else if (window.attachEvent)
        window.attachEvent("onload", onload);
    else
        window.onload = onload;

} ());
<?php
}
}



?>

