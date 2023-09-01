<?php

require_once("deps.php");

function pv($value) {
require("deps.php");
$rs_connect = mysqli_connect($dbhost, $dbuname, $dbpass, $dbname) or die("Couldn't connect the db");
mysqli_query($rs_connect, "SET NAMES utf8");

$value2 = trim($value);
 if (get_magic_quotes_gpc()) {
   return addslashes($value2);
 } else {
   return mysqli_real_escape_string($rs_connect, $value2);
 }
}

function pf($value) {
require("deps.php");
$value2 = trim($value);
   return htmlspecialchars($value2);
}


function pcrtlang($string) {
require("deps.php");
$rs_connect = mysqli_connect($dbhost, $dbuname, $dbpass, $dbname) or die("Couldn't connect the db");
mysqli_query($rs_connect, "SET NAMES utf8");
$safestring = pv($string);
$findstring = "SELECT languagestring FROM languages WHERE basestring LIKE BINARY '$safestring' AND language = '$mypcrtlanguage'";
$findstringq = @mysqli_query($rs_connect, $findstring);
if(mysqli_num_rows($findstringq) == 0) {
$findbasestring = "SELECT basestring FROM languages WHERE basestring LIKE BINARY '$safestring'";
$findbasestringq = @mysqli_query($rs_connect, $findbasestring);
if(mysqli_num_rows($findbasestringq) == 0) {
$addstring = "INSERT INTO languages (language,languagestring,basestring) VALUES ('en-us','$safestring','$safestring')";
@mysqli_query($rs_connect, $addstring);
}
return "$string";
} else {
$rs_result_qs = mysqli_fetch_object($findstringq);
return "$rs_result_qs->languagestring";
}
return $string;
}



if (array_key_exists('amount',$_REQUEST)) {
$amount = $_REQUEST['amount'];
} else {
$amount = "0";
}

if (array_key_exists('stripeToken',$_REQUEST)) {
$stripetoken = $_REQUEST['stripeToken'];
} else {
$stripetoken = "";
}


?>

<!DOCTYPE html>

<html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title><?php echo pcrtlang("Pay Invoice"); ?></title>

</head>

<body><br>

<div style="width:200;margin-left:auto;margin-right:auto;border: #cccccc 2px solid;padding:10px;border-radius:5px;"><center>

<img src=images/logo.png style="width:175px;"><br><br>


<?php

if($stripetoken == "") {

?>

<form action="stripepay.php?amount=<?php echo "$amount"; ?>" method="POST">
  <script
    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
    data-key="<?php echo "$stripe_api_key_public"; ?>"
    data-amount="<?php echo "$amount"; ?>"
    data-name="<?php echo pcrtlang("Pay Invoice"); ?>"
    data-description="<?php echo pcrtlang("Charges"); ?>"
    data-image="images/logo.png"
    data-locale="auto">
  </script>
</form>

<?php

} else {

$amounttopaycents = "$amount";

require_once('stripe/init.php');

$isapproved = 1;

try {
\Stripe\Stripe::setApiKey("$stripe_api_key");
$ch = \Stripe\Charge::create(array(
  "amount" => "$amounttopaycents",
  "currency" => "$stripe_currency",
  "source" => "$stripetoken",
  "description" => pcrtlang("Card Charge"))
);

}
  catch (Exception $e) {
    $chargeerror = $e->getMessage();
$isapproved = 0;
}



if ($isapproved == 0) {
echo "<font size=6>".pcrtlang("Credit Card Declined")."</font><br><br>";
$thereason = $chargeerror;
echo pcrtlang("Reason").":<br><br><font color=red size=5>$thereason $amount</font>";
} else {
echo "<h3>".pcrtlang("Thank You!")."</h3>"; 

}



}
?>


</center></div>

</body>
</html>
