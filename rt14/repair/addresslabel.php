<?php 

/***************************************************************************
 *   copyright            : (C) 2018 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/
require("deps.php");


$pcname = htmlspecialchars($_REQUEST['pcname'], ENT_QUOTES, "UTF-8");
$pccompany = htmlspecialchars($_REQUEST['pccompany'], ENT_QUOTES, "UTF-8");
if("$pccompany" == "") {
$labelname = "$pcname";
} else {
$labelname = "$pccompany";
}

$pcaddress1 = htmlspecialchars($_REQUEST['pcaddress1'], ENT_QUOTES, "UTF-8");
$pcaddress2 = htmlspecialchars($_REQUEST['pcaddress2'], ENT_QUOTES, "UTF-8");
$pccity = htmlspecialchars($_REQUEST['pccity'], ENT_QUOTES, "UTF-8");
$pcstate = htmlspecialchars($_REQUEST['pcstate'], ENT_QUOTES, "UTF-8");
$pczip = htmlspecialchars($_REQUEST['pczip'], ENT_QUOTES, "UTF-8");

if (array_key_exists('backurl',$_REQUEST)) {
$backurl = $_REQUEST['backurl'];
} else {
$backurl = "repair/";
}

require_once("common.php");
require_once("validate.php");



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_ql = "SELECT * FROM stores WHERE storeid = '$defaultuserstore'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$labeldata5 = "$rs_result_q1->tempaddress";

if($pcaddress2 == "") {
$line1 = "$pcaddress1";
$line2 = "$pccity, $pcstate $pczip";
$line3 = "";
} else {
$line1 = "$pcaddress1";
$line2 = "$pcaddress2";
$line3 = "$pccity, $pcstate $pczip";
}

$labeldata = str_replace(
  array('PCRT_CUSTOMER_NAME','PCRT_ADDRESS1','PCRT_ADDRESS2','PCRT_ADDRESS3'),
  array(addslashes("$labelname"), addslashes("$line1"),addslashes("$line2"),addslashes("$line3")),
  $labeldata5
);

if (!array_key_exists('dymojsapi',$_REQUEST)) {
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"printaddress.label\"");
echo $labeldata; 
} else {
$dymojsapi = $_REQUEST['dymojsapi'];
if($dymojsapi == "html") {
#####

require("header.php");

$pcname = htmlspecialchars($_REQUEST['pcname'], ENT_QUOTES, "UTF-8");
$pccompany = htmlspecialchars($_REQUEST['pccompany'], ENT_QUOTES, "UTF-8");
if("$pccompany" == "") {
$labelname = "$pcname";
} else {
$labelname = "$pccompany";
}



$name_ue = urlencode($_REQUEST['pcname']);
$company_ue = urlencode($_REQUEST['pccompany']);
$pcaddress1_ue = urlencode($_REQUEST['pcaddress1']);
$pcaddress2_ue = urlencode($_REQUEST['pcaddress2']);
$pccity_ue = urlencode($_REQUEST['pccity']);
$pcstate_ue = urlencode($_REQUEST['pcstate']);
$pczip_ue = urlencode($_REQUEST['pczip']);

start_blue_box(pcrtlang("Print Address Label"));


?>

            <label for="printersSelect"><span class="boldme"><?php echo pcrtlang("Select Printer"); ?>:</span></label><br>
            <select id="printersSelect"></select>

<br><br><table><tr><td>
<span class="boldme"><?php echo pcrtlang("Label Qty"); ?>:</span></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td colspan=5><span class="boldme"><?php echo pcrtlang("Select Roll (Twin Turbo Printer Only)"); ?>:</span></td></tr>
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
<td colspan=5><span class="boldme"><?php echo pcrtlang("Print Speed"); ?>:</span></td></tr>
<tr><td>
</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td style="vertical-align:top; width:100px; text-align:center;">
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

<br><button class=button onclick="parent.location='<?php echo "$backurl"; ?>'">&laquo;<?php echo pcrtlang("Back"); ?></button>&nbsp;&nbsp;&nbsp;
<button id="printButton" class=button><?php echo pcrtlang("Print"); ?></button><br><br>



<?php
echo "<a href=\"addresslabel.php?pcname=$name_ue&pccompany=$company_ue&pcaddress1=$pcaddress1_ue&pcaddress2=$pcaddress2_ue&pccity=$pccity_ue&pcstate=$pcstate_ue&pczip=$pczip_ue\" class=\"linkbuttonmedium linkbuttongray radiusall\">".pcrtlang("Download Label")."</a><br><br>";
?>

<?php
start_box();
echo "<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img id=\"labelImage\" src=\"\" alt=\"label preview\"><br><br>";
stop_box();
?>

<script src = "jq/DYMO.Label.Framework.latest.js" type="text/javascript" charset="UTF-8"> </script>
<script src = "addresslabel.php?pcname=<?php echo "$name_ue"; ?>&pccompany=<?php echo "$company_ue"; ?>&pcaddress1=<?php echo "$pcaddress1_ue"; ?>&pcaddress2=<?php echo "$pcaddress2_ue"; ?>&pccity=<?php echo "$pccity_ue"; ?>&pcstate=<?php echo "$pcstate_ue"; ?>&pczip=<?php echo "$pczip_ue"; ?>&dymojsapi=yes" type="text/javascript" charset="UTF-8"> </script>



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
//      printParamsXml = dymo.label.framework.createLabelWriterPrintParamsXml({copies: labelcount.value});

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

