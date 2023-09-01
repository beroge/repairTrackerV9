<?php
echo "<script src=\"../repair/jq/jquery.js\" type=\"text/javascript\"></script>\n\n";
?>

 <link href="../repair/jq/facebox.css" media="screen" rel="stylesheet" type="text/css" />
  <script src="../repair/jq/facebox.js" type="text/javascript"></script>
  <script type="text/javascript">
    jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        loadingImage : '../repair/jq/loading.gif',
        closeImage : '../repair/jq/closelabel.png'
      })
    })
  </script>

