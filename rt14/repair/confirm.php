<?php

/***************************************************************************
 *   copyright            : (C) 2020 PCRepairTracker.com
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



function confirm() {
require("deps.php");
require_once("common.php");

$url = $_REQUEST['url'];
$divload = $_REQUEST['divload'];
$divloadcontentlink = $_REQUEST['divloadcontentlink'];
$question = $_REQUEST['question'];

echo "<div style=\"position:relative;min-height:200px;\">";
echo "<div class=\"sizemelarger\" style=\"display:inline:block;text-align:center\">";
echo "<table><tr><td style=\"padding:20px\"><i class=\"fa fa-question-circle fa-5x\"></i></td><td style=\"padding:20px;\">".pcrtlang("$question")."</td></tr></table>";
echo "</div>";
echo "<span style=\"position:absolute;bottom:20px;right:20px;\">";
echo "<a href=\"javascript:void(0);\" onclick=\"javascript:$(document).trigger('close.facebox')\" class=\"linkbuttonlarge linkbuttonblack radiusall\" style=\"width:100px;text-align:center;\"><i class=\"fa fa-times fa-lg fa-fw\" style=\"color:#ff5555\"></i> ".pcrtlang("No")."</a>";
echo "&nbsp;&nbsp;<a href=\"$url\" class=\"catchclass linkbuttonlarge linkbuttonblack radiusall\" style=\"width:100px;text-align:center;\"><i class=\"fa fa-check fa-lg fa-fw\" style=\"color:#00ff00\"></i> ".pcrtlang("Yes")."</a>";
echo "</span>";
echo "</div>";

if($divload != "") {
?>
<script type="text/javascript">
$(document).ready(function(){
$('.catchclass').click(function (e) {
                e.preventDefault();
                $('.ajaxspinner').toggle();
                var url = $(this).attr('href');
                $.get(url, function () {
                $.get('<?php echo "$divloadcontentlink"; ?>', function(data) {
                $('#<?php echo "$divload"; ?>').html(data);
                $('.ajaxspinner').toggle();
		$(document).trigger('close.facebox');
                });
                });
                });
});
</script>
<?php
}

}


function confirmdeletenote() {
require("deps.php");
require_once("common.php");

$url = $_REQUEST['url'];
$question = $_REQUEST['question'];
$woid = $_REQUEST['woid'];

echo "<div style=\"position:relative;min-height:200px;\">";
echo "<div class=\"sizemelarger\" style=\"display:inline:block;text-align:center\">";
echo "<table><tr><td style=\"padding:20px\"><i class=\"fa fa-question-circle fa-5x\"></i></td><td style=\"padding:20px;\">".pcrtlang("$question")."</td></tr></table>";
echo "</div>";
echo "<span style=\"position:absolute;bottom:20px;right:20px;\">";
echo "<a href=\"javascript:void(0);\" onclick=\"javascript:$(document).trigger('close.facebox')\" class=\"linkbuttonlarge linkbuttonblack radiusall\" style=\"width:100px;text-align:center;\"><i class=\"fa fa-times fa-lg fa-fw\" style=\"color:#ff5555\"></i> ".pcrtlang("No")."</a>";
echo "&nbsp;&nbsp;<a href=\"$url\" class=\"catchclass linkbuttonlarge linkbuttonblack radiusall\" style=\"width:100px;text-align:center;\"><i class=\"fa fa-check fa-lg fa-fw\" style=\"color:#00ff00\"></i> ".pcrtlang("Yes")."</a>";
echo "</span>";
echo "</div>";

?>
<script type="text/javascript">
$(document).ready(function(){
$('.catchclass').on('click', function(e) {
                e.preventDefault(); 
		$('.ajaxspinner').toggle();
                var url = $(this).attr('href');
                $.get(url, function () {
                $.get('ajaxhelpers.php?func=wonotesarea&pcwo=<?php echo "$woid"; ?>&notetype=0', function(data) {
                $('#custnotearea').html(data);
                });
                $.get('ajaxhelpers.php?func=wonotesarea&pcwo=<?php echo "$woid"; ?>&notetype=1', function(data) {
                $('#technotearea').html(data);
		$(document).trigger('close.facebox');
		$('.ajaxspinner').toggle();
                });
                });
        });
});
</script>
<?php


}


switch($func) {

    default:
    confirm();
    break;

    case "confirm":
    confirm();
    break;

    case "confirmdeletenote":
    confirmdeletenote();
    break;


}
