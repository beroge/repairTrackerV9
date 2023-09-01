<?php
require_once("validate.php");
require_once("deps.php");
require_once("common.php");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo pcrtlang("Customer Portal"); ?></title>

    <script src="bs/jquery.min.js"></script>
    <script src="bs/bootstrap.min.js"></script>
    <script src="bs/restables.js"></script>


    <!-- Bootstrap core CSS -->
    <link href="bs/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="bs/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="bs/navbar-fixed-top.css" rel="stylesheet">

    <link href="style.css" rel="stylesheet">

<link rel="apple-touch-icon" sizes="57x57" href="favicon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="favicon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="favicon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="favicon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="favicon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="favicon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="favicon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="favicon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="favicon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
<link rel="manifest" href="favicon/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">

<link rel="stylesheet" href="../repair/fa5/css/all.min.css">
<link rel="stylesheet" href="../repair/fa5/css/v4-shims.min.css">
<link rel="stylesheet" href="../repair/fa5/font-awesome-animation.min.css">


  
  </head>

  <body>

    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a href="<?php echo "$homepage"; ?>"><img src=<?php echo "$logo"; ?> style="height:50px;"></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="./"><i class="fa fa-home fa-lg"></i> <?php echo pcrtlang("Home"); ?></a></li>

            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-home fa-lg"></i> <?php echo pcrtlang("Account"); ?> <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="customer.php?func=viewcustomer"><i class="fa fa-file-text-o fa-lg"></i> <?php echo pcrtlang("Your Info"); ?></a></li>

<?php


$rs_findpc = "SELECT * FROM pc_group WHERE grpemail = '$portallogin' AND grpemail != ''";
$rs_result = mysqli_query($rs_connect, $rs_findpc);

if(mysqli_num_rows($rs_result) > 1) {

echo "<li role=\"separator\" class=\"divider\"></li>";
echo "<li class=\"dropdown-header\">".pcrtlang("Switch Accounts")."</li>";


while ($rs_result_q = mysqli_fetch_object($rs_result)) {
$pcgroupname = "$rs_result_q->pcgroupname";
$pcgroupid = "$rs_result_q->pcgroupid";
$grpemail = "$rs_result_q->grpemail";

if("$pcgroupid" == "$portalgroupid") {
echo "<li><a href=\"account.php?func=switchaccount&grpemail=$grpemail&pcgroupidset=$pcgroupid\"><i class=\"fa fa-briefcase fa-lg\"></i> $pcgroupname <i class=\"fa fa-asterisk text-info\"></i></a></li>";
} else {
echo "<li><a href=\"account.php?func=switchaccount&grpemail=$grpemail&pcgroupidset=$pcgroupid\"><i class=\"fa fa-briefcase fa-lg\"></i> $pcgroupname</a></li>";
}
}

}
?>

              </ul>
            </li>


            <li><a href="sr.php"><i class="fa fa-comment fa-lg"></i> <?php echo pcrtlang("Request Service"); ?></a></li>
	    <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
		<i class="fa fa-money fa-lg"></i> <?php echo pcrtlang("Billing"); ?> <span class="caret"></span></a>
              <ul class="dropdown-menu">
    		<li><a href="invoice.php?func=browseinvoices"><i class="fa fa-file-text-o fa-lg"></i> <?php echo pcrtlang("Invoices"); ?></a></li>
            	<li><a href="receipt.php?func=browsereceipts"><i class="fa fa-file-text-o fa-lg"></i> <?php echo pcrtlang("Receipts"); ?></a></li>
              </ul>
            </li>

            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-briefcase fa-lg"></i> <?php echo pcrtlang("Services"); ?> <span class="caret"></span></a>
              <ul class="dropdown-menu">
	    	<li><a href="rinvoice.php?func=browseri"><i class="fa fa-retweet fa-lg fa-fw"></i> <?php echo pcrtlang("Recurring Services"); ?></a></li>
            	<li><a href="wo.php?func=browseworkorders"><i class="fa fa-clipboard fa-lg fa-fw"></i> <?php echo pcrtlang("Work Orders"); ?></a></li>
                <li><a href="botc.php?func=view"><i class="fa fa-clock-o fa-lg fa-fw"></i> <?php echo pcrtlang("Block of Time Services"); ?></a></li>
		<li><a href="sr.php"><i class="fa fa-comment-o fa-lg fa-fw"></i> <?php echo pcrtlang("Submit Service Requests"); ?></a></li>
              </ul>
            </li>


            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-download fa-lg"></i> <?php echo pcrtlang("Downloads"); ?> <span class="caret"></span></a>
              <ul class="dropdown-menu">

<?php
$rs_df = "SELECT * FROM portaldownloads WHERE groupid = '0' ORDER BY downloadfiletitle DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_df);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$downloadid = "$rs_result_q1->downloadid";
$downloadfilename = "$rs_result_q1->downloadfilename";
$downloadfiletitle = "$rs_result_q1->downloadfiletitle";
echo "<li><a href=\"customer.php?func=getfile&downloadid=$downloadid&groupid=0\"><i class=\"fa fa-download fa-lg\"></i> $downloadfiletitle</a></li>";
}
?>

<?php
$rs_df = "SELECT * FROM portaldownloads WHERE groupid = '$portalgroupid' ORDER BY downloadfiletitle DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_df);
if(mysqli_num_rows($rs_result1) != 0) {
echo "<li role=\"separator\" class=\"divider\"></li>";
echo " <li class=\"dropdown-header\">".pcrtlang("My Downloads")."</li>";

while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$downloadid = "$rs_result_q1->downloadid";
$downloadfilename = "$rs_result_q1->downloadfilename";
$downloadfiletitle = "$rs_result_q1->downloadfiletitle";
echo "<li><a href=\"customer.php?func=getfile&downloadid=$downloadid&groupid=$portalgroupid\"><i class=\"fa fa-download fa-lg\"></i> $downloadfiletitle</a></li>";
}
}
?>



              </ul>
            </li>


            <li><a href="logout.php"><i class="fa fa-sign-out fa-lg"></i> Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container"><br><br><br>

