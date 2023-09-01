<?php

require("header.php");

if (isset($_REQUEST['pcwo'])) {
$pcwo = $_REQUEST['pcwo'];
} else {
$pcwo = "";
}


if ($pcwo != "") {

#require("wo.php");
?>
<script type="text/javascript">
$.get('wo.php?pcwo=<?php echo $pcwo; ?>', function(data) {
    $('#mainwo').html(data).enhanceWithin('create');
  });
</script>
<div id="mainwo"></div>

<?php



} else {

require("stickydisplay.php");


}

require("footer.php");

?>



