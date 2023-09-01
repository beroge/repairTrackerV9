<?php

/***************************************************************************
 *   copyright            : (C) 2020 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/

// Step 1: Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

require("header.php");

echo "<script type=\"text/javascript\">document.title = \"".pcrtlang("Repair Home")."\";</script>";

?>

<table style="width:100%"><tr><td>

<script type='text/javascript' src='jq/jquery.autogrow-textarea.js'></script>

<?php

require("deps.php");
require_once("common.php");

if (isset($_REQUEST['pcwo'])) {
    $pcwo = $_REQUEST['pcwo'];
} else {
    $pcwo = "";
}

if (isset($_REQUEST['scrollto'])) {
    $scrollto = $_REQUEST['scrollto'];
} else {
    $scrollto = "top";
}

if ($pcwo != "") {

    // Step 2: Check if 'wo.php' file exists and the path is correct
    try {
        $file = 'wo.php';
        if (file_exists($file)) {
            $workorderorig = 1;
            global $workorderorig;
            
            ?>

            <script type="text/javascript">
                $.get('wo.php?pcwo=<?php echo "$pcwo"; ?>&time=<?php echo time(); ?>&scrollto=<?php echo "$scrollto"; ?>', function(data) {
                    $('#mainworkorder').html(data);
                });
            </script>

            <?php
        } else {
            throw new Exception("File 'wo.php' not found.");
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    require("home.php");
}

?>

</td></tr></table>

<?php 
require("footer.php");
?>
