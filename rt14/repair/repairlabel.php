<?php 

/***************************************************************************
 *   copyright            : (C) 2021 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/
require("deps.php");
require("common.php");
require_once("validate.php");


$storeinfoarray = getstoreinfo($defaultuserstore);

$name2 = htmlspecialchars($_REQUEST['name'], ENT_QUOTES, "UTF-8");
$company2 = htmlspecialchars($_REQUEST['company'], ENT_QUOTES, "UTF-8");
$pcid = $_REQUEST['pcid'];
$businessname2 = htmlspecialchars($storeinfoarray['storename'], ENT_QUOTES, "UTF-8");
$phone2 = htmlspecialchars($storeinfoarray['storephone'], ENT_QUOTES, "UTF-8");
$pcphone2 = htmlspecialchars($_REQUEST['pcphone'], ENT_QUOTES, "UTF-8");
$pcmake2 = htmlspecialchars($_REQUEST['pcmake'], ENT_QUOTES, "UTF-8");
$woid = $_REQUEST['woid'];
$name = $_REQUEST['name'];

if (array_key_exists('backurl',$_REQUEST)) {
$backurl = $_REQUEST['backurl'];
} else {
$backurl = "index.php";
}





mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_ql = "SELECT * FROM stores WHERE storeid = '$defaultuserstore'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$labeldata5 = "$rs_result_q1->tempasset";

$labeldata = str_replace(
  array('PCRT_CUSTOMER_NAME','PCRTPCID','PCRT_YOUR_STORE_NAME','PCRT_STORE_PHONE','PCRTWOID','PCRT_MAKE','PCRT_CUSTOMER_PHONE','PCRT_CUSTOMER_COMPANY'), 
  array(addslashes("$name2"),"$pcid",addslashes("$businessname2"),addslashes("$phone2"),"$woid",addslashes("$pcmake2"),addslashes("$pcphone2"),addslashes("$company2")), 
  $labeldata5
);

if (!array_key_exists('dymojsapi',$_REQUEST)) {
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"printrepairlabel.label\"");
echo $labeldata; 
} else {
$dymojsapi = $_REQUEST['dymojsapi'];
if($dymojsapi == "html") {
#####

require("header.php");

$name_ue = urlencode($_REQUEST['name']);
$company_ue = urlencode($_REQUEST['company']);
$businessname_ue = urlencode($storeinfoarray['storename']);
$phone_ue = urlencode($storeinfoarray['storephone']);
$pcphone_ue = urlencode($_REQUEST['pcphone']);
$pcmake_ue = urlencode($_REQUEST['pcmake']);

start_blue_box(pcrtlang("Print Asset Label"));


?>



            <label for="printersSelect"><?php echo pcrtlang("Select Printer"); ?>:</label><br>
            <select id="printersSelect"></select>

<br><br><table><tr><td>
<?php echo pcrtlang("Label Qty"); ?>:</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td colspan=5><?php echo pcrtlang("Select Roll (Twin Turbo Printer Only)"); ?>:</td></tr>
<tr><td><input type=number value=1 name=labelqty id=labelcount class=textbox min="1" max="50">
</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td style="vertical-align:top; width:100px; text-align:left;">
<div class="radiobox">
<input type=radio id="Left" value="Left" name="labelside"><label for="Left"><i class="fa fa-chevron-left fa-lg"></i> <?php echo pcrtlang("Left"); ?></input></label></div> </td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td style="vertical-align:top; width:100px; text-align:center;">
<div class="radiobox"><input type=radio id="Auto" value="Auto" name="labelside" checked><label for="Auto"> <?php echo pcrtlang("Auto"); ?></input></label></div></td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td style="vertical-align:top; width:100px; text-align:right;">
<div class="radiobox"><input type=radio id="Right" value="Right" name="labelside"><label for="Right"> <?php echo pcrtlang("Right"); ?> <i class="fa fa-chevron-right fa-lg"></i></input></label></div>
</td></tr>

<tr><td>
</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td colspan=5><?php echo pcrtlang("Print Speed"); ?>:</td></tr>
<tr><td colspan=2 style=text-align:center>
<button id="printButton" class="linkbuttonlarge linkbuttongray radiusall" style="width:150px;">&nbsp;&nbsp;&nbsp;<i class="fa fa-print fa-lg"></i>&nbsp;&nbsp;&nbsp;<br><?php echo pcrtlang("Print"); ?></button></td><td style="vertical-align:top; width:100px; text-align:center;">
<div class="radiobox">
<input type=radio id="BarcodeAndGraphics" value="BarcodeAndGraphics" name="labelspeed"><label for="BarcodeAndGraphics"> <?php echo pcrtlang("Fine"); ?></input></label></div> </td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td style="vertical-align:top; width:100px; text-align:center;">
<div class="radiobox"><input type=radio id="AutoS" value="Auto" name="labelspeed"><label for="AutoS"> <?php echo pcrtlang("Auto"); ?></input></label></div></td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td style="vertical-align:top; width:100px; text-align:center;">
<div class="radiobox"><input type=radio id="Draft" value="Text" name="labelspeed" checked><label for="Draft"> <?php echo pcrtlang("Draft"); ?> </input></label></div>
</td></tr>



</table>
<?php

start_box();
echo "<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img id=\"labelImage\" src=\"\" alt=\"label preview\"><br><br>";
stop_box();


echo "<br><button class=\"linkbuttonmedium linkbuttongray radiusleft\" onclick=\"parent.location='$backurl'\"><i class=\"fa fa-chevron-left fa-lg\"></i> ".pcrtlang("Back")."</button><button class=\"linkbuttonmedium linkbuttongray\" onclick=\"parent.location='index.php?pcwo=$woid'\"><i class=\"fa fa-clipboard fa-lg\"></i> ".pcrtlang("Back to Work Order")."</button><button onclick=\"parent.location='repairlabel.php?pcid=$pcid&name=$name_ue&company=$company_ue&woid=$woid&pcmake=$pcmake_ue&pcphone=$pcphone_ue&backurl=index.php'\" class=\"linkbuttonmedium linkbuttongray\"><i class=\"fa fa-download fa-lg\"></i> ".pcrtlang("Download Label")."</button>";
echo "<button class=\"linkbuttonmedium linkbuttongray radiusright\" onclick=\"parent.location='pc.php?func=benchsheet&woid=$woid'\">
<i class=\"fa fa-plug fa-lg\"></i> ".pcrtlang("Bench Sheet")."</button><br><br>";


?>

<script src="jq/DYMO.Label.Framework.latest.js" type="text/javascript" charset="UTF-8"></script>
<script src="repairlabel.php?pcid=<?php echo "$pcid"; ?>&name=<?php echo "$name_ue"; ?>&company=<?php echo "$company_ue"; ?>&woid=<?php echo "$woid"; ?>&pcmake=<?php echo "$pcmake_ue"; ?>&pcphone=<?php echo "$pcphone_ue"; ?>&dymojsapi=yes&backurl=index.php" type="text/javascript" charset="UTF-8"></script>



<?php

stop_blue_box();
require_once("footer.php");

#####
} else {
header('Content-Type: text/javascript');
$labeldata2 = str_replace("\r\n", "\\\n", "$labeldata");
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
                alert("<?php echo "No DYMO printers can be found. Please install the DYMO labelwriter software"; ?>.");
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
