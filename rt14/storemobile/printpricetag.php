<?php 

/***************************************************************************
 *   copyright            : (C) 2012 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/
require("deps.php");
require("common.php");
require_once("validate.php");

$storeinfoarray = getstoreinfo($defaultuserstore);

$name = htmlspecialchars($_REQUEST['name'], ENT_QUOTES, "UTF-8");
$price = mf($_REQUEST['price']);
$stockid = $_REQUEST['stockid'];

$businessname2 = htmlspecialchars($storeinfoarray['storename'], ENT_QUOTES, "UTF-8");
$storephone2 = htmlspecialchars($storeinfoarray['storephone'], ENT_QUOTES, "UTF-8");



mysqli_query($rs_connect, "SET NAMES 'utf8'");

$rs_ql = "SELECT * FROM stores WHERE storeid = '$defaultuserstore'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$rs_result_q1 = mysqli_fetch_object($rs_result1);


if (array_key_exists('itemserial',$_REQUEST)) {
$itemserial2 = $_REQUEST['itemserial'];
if($itemserial2 != "") {
$itemserial = htmlspecialchars("$itemserial2", ENT_QUOTES, "UTF-8");
$labeldata5 = "$rs_result_q1->temppricetagserial";
} else {
$itemserial = "";
$labeldata5 = "$rs_result_q1->temppricetag";
}
} else {
$itemserial = "";
$labeldata5 = "$rs_result_q1->temppricetag";
}

if (array_key_exists('itemupc',$_REQUEST)) {
$itemupc2 = $_REQUEST['itemupc'];
$itemupc = htmlspecialchars("$itemupc2", ENT_QUOTES, "UTF-8");
} else {
$itemupc = "";
}


$labeldata = str_replace(
  array('PCRT_STORE_NAME','PCRT_STORE_PHONE','PCRT_STOCK_NAME','PCRT_PRICE','PCRT_SERIAL_NUMBER','PCRTSTOCKID','PCRTUPC'),
  array("$businessname2", "$storephone2", "$name","$money$price",pcrtlang("SN")."# $itemserial","$stockid","$itemupc"),
  $labeldata5
);



if (!array_key_exists('dymojsapi',$_REQUEST)) {
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"printpricetag.label\"");
echo $labeldata; 
} else {
$dymojsapi = $_REQUEST['dymojsapi'];
if($dymojsapi == "html") {
#####

require("header.php");


$name_ue = urlencode($_REQUEST['name']);
$itemserial_ue = urlencode($itemserial);
$price_ue = urlencode($_REQUEST['price']);
$stockid_ue = urlencode($_REQUEST['stockid']);
$itemupc_ue = urlencode($_REQUEST['itemupc']);

echo "<h3>".pcrtlang("Print Price Label")."</h3>";


?>

            <label for="printersSelect"><?php echo pcrtlang("Select Printer"); ?>:</label><br>
            <select id="printersSelect"></select>

<br><br>
<?php echo pcrtlang("Label Qty"); ?>:
<input type=number value=1 name=labelqty id=labelcount min="1" max="50">

<?php echo pcrtlang("Select Roll (Twin Turbo Printer Only)"); ?>:
<fieldset data-role="controlgroup"  data-type="horizontal">
<input type=radio id="Left" value="Left" name="labelside"><label for="Left"><i class="fa fa-chevron-left fa-lg"></i> <?php echo pcrtlang("Left"); ?></input></label>
<input type=radio id="Auto" value="Auto" name="labelside" checked><label for="Auto"> <?php echo pcrtlang("Auto"); ?></input></label>
<input type=radio id="Right" value="Right" name="labelside"><label for="Right"> <?php echo pcrtlang("Right"); ?> <i class="fa fa-chevron-right fa-lg"></i></input></label>
</fieldset>

<?php echo pcrtlang("Print Speed"); ?>:
<fieldset data-role="controlgroup" data-type="horizontal">
<input type=radio id="BarcodeAndGraphics" value="BarcodeAndGraphics" name="labelspeed"><label for="BarcodeAndGraphics"> <?php echo pcrtlang("Fine"); ?></input></label>
<input type=radio id="AutoS" value="Auto" name="labelspeed"><label for="AutoS"> <?php echo pcrtlang("Auto"); ?></input></label>
<input type=radio id="Draft" value="Text" name="labelspeed" checked><label for="Draft"> <?php echo pcrtlang("Draft"); ?> </input></label>
</fieldset>

<br><button class=button onclick="window.history.back();"><i class="fa fa-chevron-left fa-lg"></i> <?php echo pcrtlang("Back"); ?></button>
<button id="printButton"><i class="fa fa-print fa-lg"></i> <?php echo pcrtlang("Print"); ?></button><br><br>


<?php
echo "<button type=button onClick=\"parent.location='printpricetag.php?price=$price_ue&stockid=$stockid_ue&name=$name_ue&itemserial=$itemserial&itemupc=$itemupc_ue'\"><i class=\"fa fa-download fa-lg\"></i> ".pcrtlang("Download Label")."</button><br><br>";
?>

<?php
echo "<br><br><img id=\"labelImage\" src=\"\" alt=\"label preview\"><br><br>";
?>

<script src = "../repair/jq/DYMO.Label.Framework.latest.js" type="text/javascript" charset="UTF-8"> </script>
<script src = "printpricetag.php?price=<?php echo "$price_ue"; ?>&name=<?php echo "$name_ue"; ?>&stockid=<?php echo "$stockid_ue"; ?>&itemserial=<?php echo "$itemserial"; ?>&itemupc=<?php echo "$itemupc_ue"; ?>&dymojsapi=yes" type="text/javascript" charset="UTF-8"> </script>



<?php

require_once("footer.php");

#####
} else {
header('Content-Type: application/javascript');
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
