<?php

/***************************************************************************
 *   copyright            : (C) 2017 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/

require_once("deps.php");
require_once("validate2.php");



$rs_ql = "SELECT gomodal,autoprint,defaultstore,floatbar,narrow,narrowct FROM users WHERE username = '$ipofpc'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$gomodal = "$rs_result_q1->gomodal";
$autoprint = "$rs_result_q1->autoprint";
$defaultuserstore = "$rs_result_q1->defaultstore";
$floatbar = "$rs_result_q1->floatbar";
$receiptsnarrow = "$rs_result_q1->narrow";
$narrowct = "$rs_result_q1->narrowct";

function start_blue_box($blue_title) {
        $boxstyle = getboxstyle(50);
        echo "<div class=colortitletopround style=\"background:#$boxstyle[selectorcolor]\"><span class=\"sizemelarge colormewhite textoutline boldme\">$blue_title</span></div><div class=whitebottom>";
}

function stop_blue_box() {
        echo "</div>\n";
}

function start_gray_box($gray_title) {
        $boxstyle = getboxstyle(51);
        echo "<div class=colortitletopround style=\"background:#$boxstyle[selectorcolor]\"><span class=\"sizemelarge colormewhite textoutline boldme\">$gray_title</span></div><div class=whitebottom>";
}

function stop_gray_box() {
        echo "</div>\n";
}


function start_color_box($statusid,$title) {
        $boxstyle = getboxstyle($statusid);
        echo "<div class=\"colortitletopround\" style=\"background:#$boxstyle[selectorcolor]\">\n";
        echo "<span class=\"sizemelarge colormewhite textoutline boldme\">$title</span></div>\n";
        echo "<div class=whitebottom>\n";
}

function start_color_altbox($statusid,$title,$total) {
        $boxstyle = getboxstyle($statusid);
        echo "<div class=\"colortitletopround\" style=\"background:#$boxstyle[selectorcolor];\">\n";
        echo "<span class=\"sizemelarge colormewhite textoutline boldme\">$title</span><span style=\"background:#ffffff;font-family:Open Sans;font-weight:bold;color:#$boxstyle[selectorcolor];padding:1px;border-radius:3px;float:right;box-sizing:border-box;opacity:.8;\">&nbsp;$total&nbsp;</span></div>\n";
        echo "<div class=whitebottom>\n";
}


function start_color_boxnobottomround($statusid,$title) {
        $boxstyle = getboxstyle($statusid);
        echo "<div class=\"colortitletopround\" style=\"background:#$boxstyle[selectorcolor]\">\n";
        echo "$title</div>\n";
        echo "<div class=whitemiddle>\n";
}

function start_color_boxnoround($statusid,$title) {
        $boxstyle = getboxstyle($statusid);
        echo "<div class=\"colortitle\" style=\"background:#$boxstyle[selectorcolor]\">\n";
        echo "<span class=\"sizemelarge colormewhite textoutline boldme\">$title</span></div>\n";
        echo "<div class=whitebottom>\n";
}

function stop_color_box() {
        echo "</div>\n";
}

function start_box() {
        echo "<div class=startbox>\n";
}

function start_box_nested() {
        echo "<div class=startbox_nested>\n";
}

function start_box_cb($bgcolor) {
        echo "<div style=\"background:#$bgcolor\" class=colorbox>\n";
}

function start_box_cb_nested($bgcolor) {
        echo "<div style=\"background:#$bgcolor\" class=colorbox_nested>\n";
}


function stop_box() {
        echo "</div>\n";
}

function start_moneybox() {
        echo "<div class=moneybox>\n";
}

function start_moneybox_nested() {
        echo "<div class=moneybox_nested>\n";
}

function ufloater($title) {
        $boxstyle = getboxstyle(50);
        echo "<div id=\"uquickbar\">";
        echo "<div class=\"colortitletopround\" style=\"text-align:center;padding:1px;background:#$boxstyle[selectorcolor]\">\n";
        echo "<span class=\"colormewhite textoutline boldme\">$title</span></div>\n";
}

function ustopfloater() {
        echo "</div>\n";
}


function showmaincategories() {
                                                                                                                             
require("deps.php");

$rs_ql = "SELECT defaultstore FROM users WHERE username = '$ipofpc'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$defaultuserstore = "$rs_result_q1->defaultstore";

$rs_insert_main_cat = "SELECT * FROM maincats ORDER BY cat_name ASC";
$rs_result = mysqli_query($rs_connect, $rs_insert_main_cat);

$rs_findassettypes = "SELECT * FROM mainassettypes ORDER BY mainassetname ASC";
$rs_resultat = mysqli_query($rs_connect, $rs_findassettypes);

echo "<center><div id=\"masterdiv\">";

###

$totalassets = 0;

echo "<div class=\"menutitle\" onclick=\"SwitchMenu('cts')\">".pcrtlang("Carts")."<br></div><span class=\"submenu\" id=\"cts\">";
echo "<a href=cart.php?func=show_savecart class=\"linkbuttongray linkbuttonlarge displayblock\"><i class=\"fa fa-shopping-cart fa-lg\"></i> ".pcrtlang("Saved Carts")."</a>";
echo "<a href=cart.php?func=show_savecart&iskit=1 class=\"linkbuttongray linkbuttonlarge displayblock\"><i class=\"fa fa-shopping-basket fa-lg\"></i> ".pcrtlang("Kits")."</a>";
echo "</span>";

echo "<div class=\"menutitle\" onclick=\"SwitchMenu('rts')\">".pcrtlang("Ready to Sell")."<br></div><span class=\"submenu\" id=\"rts\">";

while($rs_resultat_q = mysqli_fetch_object($rs_resultat)) {
$mainassettypeid = "$rs_resultat_q->mainassettypeid";
$mainassetname = "$rs_resultat_q->mainassetname";

$rs_findassets = "SELECT * FROM pc_wo,pc_owner WHERE pc_wo.pcstatus = '7' AND pc_owner.mainassettypeid = '$mainassettypeid' AND pc_wo.pcid = pc_owner.pcid AND pc_wo.storeid = '$defaultuserstore'";
$rs_resultassets = mysqli_query($rs_connect, $rs_findassets);
$numberofassets = mysqli_num_rows($rs_resultassets);

$totalassets = $totalassets + $numberofassets;

if($numberofassets > 0) {

echo "<a href=cart.php?func=show_savecarts&mainassettypeid=$mainassettypeid class=\"linkbuttongray linkbuttonlarge displayblock\" style=\"padding:3px;\">$mainassetname
<span style=\"float:right;\">$numberofassets</span></a>";

}
}

echo "<a href=cart.php?func=show_savecarts class=\"linkbuttongray linkbuttonlarge displayblock\" style=\"padding:3px;\">".pcrtlang("All")."
<span style=\"float:right;\">$totalassets</span></a>";

echo "</span>";

####

$a = 1;
while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_catid = "$rs_result_q->cat_id";
$rs_catname = "$rs_result_q->cat_name";
                                                                                                                             
echo "<div class=\"menutitle\" onclick=\"SwitchMenu('sub$a')\">$rs_catname<br></div><span class=\"submenu\" id=\"sub$a\">";
                                                                                                                             
$rs_find_sub_cat = "SELECT * FROM sub_cats WHERE sub_cat_parent = '$rs_catid' ORDER BY sub_cat_name ASC";
$rs_find_result = mysqli_query($rs_connect, $rs_find_sub_cat);
                                                                                                                             
while($rs_find_result_q = mysqli_fetch_object($rs_find_result)) {
$rs_subcatid = "$rs_find_result_q->sub_cat_id";
$rs_subcatname = "$rs_find_result_q->sub_cat_name";
$rs_subcat_items = "$rs_find_result_q->sub_cat_item_total";

if ($rs_subcat_items > 0) { 
                                                                                                                            
echo "<a href=stock.php?func=show_stock&category=$rs_subcatid class=\"linkbuttongray linkbuttonlarge displayblock\" style=\"padding:3px;\">$rs_subcatname <span style=\"float:right;\">$rs_subcat_items</span></a>";
			}

}
echo "</span>";	
$a++;
	}
echo "</div></center>";


}


function updatecategories() {
require("deps.php");


$rs_reset_counters = "UPDATE sub_cats SET sub_cat_item_total = '0'";
@mysqli_query($rs_connect, $rs_reset_counters);
$rs_count_stock = "SELECT stock_id,stock_cat FROM stock WHERE dis_cont = '0'";
$rs_result_count = mysqli_query($rs_connect, $rs_count_stock);
while($rs_result_count_q = mysqli_fetch_object($rs_result_count)) {
$rs_catid = "$rs_result_count_q->stock_cat";
$rs_stockid = "$rs_result_count_q->stock_id";

$rs_count_stock2 = "SELECT quantity FROM stockcounts WHERE stockid = '$rs_stockid' AND quantity > 0";
$rs_result_count2 = mysqli_query($rs_connect, $rs_count_stock2);
$rs_result_count3 = mysqli_num_rows($rs_result_count2);

if ($rs_result_count3 > 0) {
$rs_count = "UPDATE sub_cats SET sub_cat_item_total = sub_cat_item_total+1 WHERE sub_cat_id = '$rs_catid'";
@mysqli_query($rs_connect, $rs_count);
}
}

$rs_reset_counters2 = "UPDATE maincats SET cat_total_items = '0'";
@mysqli_query($rs_connect, $rs_reset_counters2);
$rs_count_stock2 = "SELECT * FROM sub_cats";
$rs_result_count2 = mysqli_query($rs_connect, $rs_count_stock2);
while($rs_result_count_q2 = mysqli_fetch_object($rs_result_count2)) {
$rs_catid2 = "$rs_result_count_q2->sub_cat_parent";
$rs_count2 = "UPDATE maincats SET cat_total_items = cat_total_items+1 WHERE cat_id = '$rs_catid2'";
@mysqli_query($rs_connect, $rs_count2);
}


}



function elaps($dropdate) {
require("deps.php");
if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}

$thenum = strtotime($dropdate);
$thediff = time() - $thenum;
if($thediff > 259200) {
$daydiff = number_format($thediff / 86400,0)." ".pcrtlang("days");
} elseif($thediff > 86400) {
$daydiff = number_format($thediff / 84600,1)." ".pcrtlang("days");
} elseif($thediff > 3600) {
$daydiff = number_format($thediff / 3600,1)." ".pcrtlang("hours");
} else {
$daydiff = number_format($thediff / 60,0)." ".pcrtlang("min");
}


return "$daydiff";
}




function cartcheck() {
require("deps.php");


$rs_find_total = "SELECT SUM(addtime) as cartprice FROM cart WHERE ipofpc = '$ipofpc'";

$rs_result_count = mysqli_query($rs_connect, $rs_find_total);
while($rs_result_count_q = mysqli_fetch_object($rs_result_count)) {
$rs_total2 = "$rs_result_count_q->cartprice";
$rs_total = substr("$rs_total2", 0, 5);
}
return $rs_total;
}

function getsalestaxrate($taxid) {
require("deps.php");


$findtaxsql = "SELECT * FROM taxes WHERE taxid = $taxid";
$findtaxq = @mysqli_query($rs_connect, $findtaxsql);
$findtaxa = mysqli_fetch_object($findtaxq);
$taxrate = "$findtaxa->taxrategoods";
return $taxrate;
}

function getservicetaxrate($taxid) {
require("deps.php");


$findtaxsql = "SELECT * FROM taxes WHERE taxid = $taxid";
$findtaxq = @mysqli_query($rs_connect, $findtaxsql);
$findtaxa = mysqli_fetch_object($findtaxq);
$taxrate = "$findtaxa->taxrateservice";
return $taxrate;
}

function gettaxname($taxid) {
require("deps.php");


$findtaxsql = "SELECT * FROM taxes WHERE taxid = $taxid";
$findtaxq = @mysqli_query($rs_connect, $findtaxsql);
$findtaxa = mysqli_fetch_object($findtaxq);
$taxname = "$findtaxa->taxname";
return $taxname;
}

function gettaxshortname($taxid) {
require("deps.php");

$findtaxsql = "SELECT * FROM taxes WHERE taxid = $taxid";
$findtaxq = @mysqli_query($rs_connect, $findtaxsql);
$findtaxa = mysqli_fetch_object($findtaxq);
$taxname = "$findtaxa->shortname";
return $taxname;
}


function getusertaxid() {
require("deps.php");
$usernamechk = $ipofpc;

$findtaxsql = "SELECT * FROM users WHERE username = '$usernamechk'";
$findtaxq = @mysqli_query($rs_connect, $findtaxsql);
$findtaxa = mysqli_fetch_object($findtaxq);
$usertaxid = "$findtaxa->currenttaxid";
return $usertaxid;
}


function isgrouprate($taxid) {
require("deps.php");

$findtaxgsql = "SELECT isgrouprate FROM taxes WHERE taxid = $taxid";
$findtaxgq = @mysqli_query($rs_connect, $findtaxgsql);
$findtaxga = mysqli_fetch_object($findtaxgq);
$isgrouprate = "$findtaxga->isgrouprate";
return $isgrouprate;
}

function getgrouprates($taxid) {
require("deps.php");

$findtaxgsql = "SELECT compositerate FROM taxes WHERE taxid = $taxid";
$findtaxgq = @mysqli_query($rs_connect, $findtaxgsql);
$findtaxga = mysqli_fetch_object($findtaxgq);
$compositerate2 = "$findtaxga->compositerate";
$compositerate = unserialize($compositerate2);
return $compositerate;
}




function get_paged_nav($num_results, $num_per_page=40, $show=false)
{
    // Set this value to true if you want all pages to be shown,
    // otherwise the page list will be shortened.
    $full_page_list = false;

    // Get the original URL from the server.
    $url = $_SERVER['REQUEST_URI'];

    // Initialize the output string.
    $output = '';

    // Remove query vars from the original URL.
    if(preg_match('#^([^\?]+)(.*)$#isu', $url, $regs))
        $url = $regs[1];

    // Shorten the get variable.
    $q = $_GET;

    // Determine which page we're on, or set to the first page.
    if(isset($q['pageNumber']) AND is_numeric($q['pageNumber'])) $page = $q['pageNumber'];
    else $page = 1;

    // Determine the total number of pages to be shown.
    $total_pages = ceil($num_results / $num_per_page);
    // Begin to loop through the pages creating the HTML code.
    for($i=1; $i<=$total_pages; $i++)
    {
        // Assign a new page number value to the pageNumber query variable.
        $q['pageNumber'] = $i;

        // Initialize a new array for storage of the query variables.
        $tmp = array();
        foreach($q as $key=>$value)
            $tmp[] = "$key=$value";

        // Create a new query string for the URL of the page to look at.
        $qvars = implode("&amp;", $tmp);

        // Create the new URL for this page.
        $new_url = $url . '?' . $qvars;

        // Determine whether or not we're looking at this page.
        if($i != $page)
        {
            // Determine whether or not the page is worth showing a link for.
            // Allows us to shorten the list of pages.
            if($full_page_list == true

          OR $i == $page-5
            OR $i == $page-4
            OR $i == $page-3
            OR $i == $page-2
         OR $i == $page-1
                OR $i == $page+1
                OR $i == 1
                OR $i == $total_pages
                OR $i == floor($total_pages/2)
                OR $i == floor($total_pages/2)+1
           OR $i == floor($total_pages/2)+2
           OR $i == floor($total_pages/2)+3
           OR $i == floor($total_pages/2)+4
           OR $i == floor($total_pages/2)+5

                )
                {
                    $output .= "<a href='$new_url' class=\"linkbuttonmedium linkbuttongray radiusall\">$i</a> ";
                }
                else
                    $output .= '. ';
        }
        else
        {
            // This is the page we're looking at.
            $output .= "<span class=\"linkbuttonmedium linkbuttongraylabel radiusall\">$i</span> ";
        }
    }

    // Remove extra dots from the list of pages, allowing it to be shortened.
    $output = preg_replace('#(\. ){2,}#', ' .. ', $output);
#  $output = ereg_replace('(\. ){2,}', ' .. ', $output); 
   // Determine whether to show the HTML, or just return it.
    if($show) echo $output;

    return($output);
}

function pv($value) {
require("deps.php");
$value2 = trim($value);
   return mysqli_real_escape_string($rs_connect, $value2);
}

function pf($value) {
$value2 = trim($value);
   return htmlspecialchars($value2);
}


function mf($value) {
if(empty($value)) {
return "0.00";
} else {
return number_format($value, 2, '.', '');
}
}

function limf($pretax,$tax) {
require("deps.php");
if(empty($pretax)) {
$pretax = "0.00";
}
if(empty($tax)) {
$tax = "0.00";
}
if(isset($taxinclusive)){
if($taxinclusive == 1) {
$value = $pretax + $tax;
} else {
$value = $pretax;
}
} else {
$value = $pretax;
}
return number_format($value, 2, '.', '');
}


function qf($value) {
if(empty($value)) {
return "0";
} else {
return $value + 0;
}
}



function mfexp($number) {
if(empty($number)) {
return "0.00";
} else {
        if (($number * pow(10 , 2 + 1) % 10 ) == 5)  //if next not significant digit is 5
            $number -= pow(10 , -(2+1));
       return number_format($number, 2, '.', '');
}
}


function ii($value) {
if(($value % 1) == 0) {
return "true";
} else {
return "false";
}
}



$themasterperms = array(
"1" => pcrtlang("Manage Scans, Installs, Actions, Notes"),
"2" => pcrtlang("Manage Quick Labor"),
"4" => pcrtlang("Delete Receipts"),
"5" => pcrtlang("Run Monthly, Quarterly, Yearly Sales Reports"),
"6" => pcrtlang("Manage Inventory"),
"7" => pcrtlang("View User Activity Reports"),
"8" => pcrtlang("Manage Customer Sources"),
"9" => pcrtlang("View Customer Source Reports"),
"10" => pcrtlang("View Customer Email/CSV Lists"),
"11" => pcrtlang("Manage Common Problems/Requests"),
"12" => pcrtlang("Manage Sticky Note Types"),
"13" => pcrtlang("Manage SMS Default Texts"),
"14" => pcrtlang("Process Recurring Invoices"),
"15" => pcrtlang("Delete Recent Invoices"),
"16" => pcrtlang("Manage Service Reminder Messages"),
"17" => pcrtlang("Send/Process Service Reminders"),
"18" => pcrtlang("Manage On Call Users"),
"19" => pcrtlang("Delete Sticky Notes Assigned to other Techs"),
"20" => pcrtlang("Edit Sticky Notes Assigned to other Techs"),
"21" => pcrtlang("Move Receipts Between Stores"),
"22" => pcrtlang("Refund Labor"),
"23" => pcrtlang("Browse Supplier Info"),
"24" => pcrtlang("Edit Supplier Info"),
"25" => pcrtlang("Browse Receipts"),
"26" => pcrtlang("View the Day Reports"),
"26" => pcrtlang("View the Day Reports"),
"27" => pcrtlang("Manage Service Contract Pricing"),
"28" => pcrtlang("Process Recurring Work Orders"),
"29" => pcrtlang("Create Backups and Send to Dropbox"),
"30" => pcrtlang("Close Registers/Switch Receipt Register"),
"31" => pcrtlang("Manage Storage Locations"),
"32" => pcrtlang("Manage Portal Downloads"),
"33" => pcrtlang("Delete Messages (SMS,Email,Call Log,Portal Messages)"),
"34" => pcrtlang("View Group Customer Credentials"),
"35" => pcrtlang("Edit Customer Tags"),
"36" => pcrtlang("Mark or Unmark Stock Items as Discontinued"),
"37" => pcrtlang("View All Tech Message Conversations"),
"38" => pcrtlang("Manage Service Promises"),
"39" => pcrtlang("Manage Discounts"),
"40" => pcrtlang("Manage Form Templates"),
"41" => pcrtlang("Access Ledger"),
"42" => pcrtlang("Create New Ledgers"),
"43" => pcrtlang("Manage Invoice Terms")
);



function perm_check($permid) {

include("deps.php");

$pcrt_select_parms_q = "SELECT theperms FROM users WHERE username = '$ipofpc'";
$frc_result_parms = @mysqli_query($rs_connect, $pcrt_select_parms_q);

$parmsa = mysqli_fetch_array($frc_result_parms);
$frc_perms = "$parmsa[theperms]";

if($frc_perms == "") {
$theperms = array();
} else {
$theperms = unserialize($frc_perms);
}

if ("$ipofpc" == "admin") {
return true;
} else {
        if (in_array($permid, $theperms)) {
                return true;
        } else {
                return false;
        }
}
}





function perm_boot($permid) {

include("deps.php");

$pcrt_select_parms_q = "SELECT theperms FROM users WHERE username = '$ipofpc'";
$frc_result_parms = @mysqli_query($rs_connect, $pcrt_select_parms_q);

$parmsa = mysqli_fetch_array($frc_result_parms);
$frc_perms = "$parmsa[theperms]";

if($frc_perms == "") {
$theperms = array();
} else {
$theperms = unserialize($frc_perms);
}

if (!in_array($permid, $theperms) && ("$ipofpc" != "admin")) {
       die("Access Denied - Please ask your admin for access to this function $permid");
}
}



$loggedactions = array(
"1" => pcrtlang("Created a New Work Order"),
"2" => pcrtlang("Checked Out a Work Order"),
"3" => pcrtlang("Recorded a Scan, Install, Action, or Note"),
"4" => pcrtlang("Saved Customer or Technician Notes"),
"5" => pcrtlang("Printed Customer Repair Sheet"),
"6" => pcrtlang("Emailed Customer Repair Sheet"),
"7" => pcrtlang("Uploaded Asset Photo"),
"8" => pcrtlang("Created Repair Invoice"),
"9" => pcrtlang("Completed Sale"),
"10" => pcrtlang("Created Invoice"),
"11" => pcrtlang("Changed Customer Call Status"),
"12" => pcrtlang("Emailed Claim Ticket"),
"13" => pcrtlang("Printed Claim Ticket"),
"14" => pcrtlang("Sent SMS Message"),
"15" => pcrtlang("Emailed Invoice"),
"16" => pcrtlang("Edited Invoice"),
"17" => pcrtlang("Created Quote"),
"18" => pcrtlang("Edited Quote"),
"19" => pcrtlang("Emailed Quote"),
"20" => pcrtlang("Created Repair Quote"),
"21" => pcrtlang("Printed or Viewed Invoice"),
"22" => pcrtlang("Printed Quote"),
"23" => pcrtlang("Customer Status Check"),
"24" => pcrtlang("Printed Thank You Letter"),
"25" => pcrtlang("Emailed Thank You Letter"),
"26" => pcrtlang("Uploaded an Attachment"),
"27" => pcrtlang("Emailed Receipt"),
"28" => pcrtlang("Viewed or Printed Receipt"),
"29" => pcrtlang("Created Recurring Invoice"),
"30" => pcrtlang("Logged In"),
"31" => pcrtlang("Logged Out"),
"32" => pcrtlang("Changed Work Order Status"),
"33" => pcrtlang("Added Service Reminder"),
"34" => pcrtlang("Emailed Service Reminder"),
"35" => pcrtlang("Printed Service Reminder"),
"36" => pcrtlang("Added a Special Order Part")
);


function userlog($actionid,$refid,$reftype,$mensaje) {
require("deps.php");
if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$mensaje2 = pv($mensaje);
$usernamechk = $ipofpc;

$logactionsql = "INSERT INTO userlog (actionid,thedatetime,refid,reftype,loggeduser,mensaje) VALUES ('$actionid',NOW(),'$refid','$reftype','$usernamechk','$mensaje2')";
@mysqli_query($rs_connect, $logactionsql);
}

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$thenow = date('Y-m-d H:i:s');
$rs_insert_time = "UPDATE users SET lastseen = '$thenow' WHERE username = '$ipofpc'";
@mysqli_query($rs_connect, $rs_insert_time);


$rs_qmultistore = "SELECT storeid FROM stores WHERE storedefault = '1'";
$rs_result_multistore = mysqli_query($rs_connect, $rs_qmultistore);
$rs_result_q1 = mysqli_fetch_object($rs_result_multistore);
$defaultstore = "$rs_result_q1->storeid";

$rs_multistorecheck = "SELECT * FROM stores WHERE storeenabled = '1'";
$rs_multistorecheckresult = mysqli_query($rs_connect, $rs_multistorecheck);
$activestorecount = mysqli_num_rows($rs_multistorecheckresult);

function getstoreinfo($storetoget) {

include("deps.php");



$rs_ql = "SELECT * FROM stores WHERE storeid = '$storetoget'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$storesname = "$rs_result_q1->storesname";
$storename = "$rs_result_q1->storename";
$storeaddy1 = "$rs_result_q1->storeaddy1";
$storeaddy2 = "$rs_result_q1->storeaddy2";
$storecity = "$rs_result_q1->storecity";
$storestate = "$rs_result_q1->storestate";
$storezip = "$rs_result_q1->storezip";
$storeemail = "$rs_result_q1->storeemail";
$storeccemail = "$rs_result_q1->ccemail";
$storephone = "$rs_result_q1->storephone";
$quotefooter = "$rs_result_q1->quotefooter";
$invoicefooter = "$rs_result_q1->invoicefooter";
$repairsheetfooter = "$rs_result_q1->repairsheetfooter";
$returnpolicy = "$rs_result_q1->returnpolicy";
$depositfooter = "$rs_result_q1->depositfooter";
$thankyouletter = "$rs_result_q1->thankyouletter";
$claimticket = "$rs_result_q1->claimticket";
$checkoutreceipt = "$rs_result_q1->checkoutreceipt";
$linecolor1 = "$rs_result_q1->linecolor1";
$linecolor2 = "$rs_result_q1->linecolor2";
$bgcolor1 = "$rs_result_q1->bgcolor1";
$bgcolor2 = "$rs_result_q1->bgcolor2";
$storehash = "$rs_result_q1->storehash";

$interfacecolor1 = "$bgcolor1";
$interfacecolor2 = "$bgcolor2";

$linestyle = "background: #$linecolor2;
background: linear-gradient(to bottom, #$linecolor1 0%,#$linecolor2 100%);";


$storeinfo = array("storesname" => "$storesname", "storename" => "$storename", "storeaddy1" => "$storeaddy1", "storeaddy2" => "$storeaddy2", "storecity" => "$storecity", "storestate" => "$storestate", "storezip" => "$storezip", "storeemail" => "$storeemail", "storephone" => "$storephone", "quotefooter" => "$quotefooter", "invoicefooter" => "$invoicefooter", "repairsheetfooter" => "$repairsheetfooter", "returnpolicy" => "$returnpolicy", "depositfooter" => "$depositfooter", "thankyouletter" => "$thankyouletter", "claimticket" => "$claimticket", "checkoutreceipt" => "$checkoutreceipt", "interfacecolor1" => "$interfacecolor1", "interfacecolor2" => "$interfacecolor2", "linestyle" => "$linestyle", "storehash" => "$storehash","storeccemail" => "$storeccemail");

return $storeinfo;
}


function checkstorecount($stock_id) {
require("deps.php");

$rs_find_stores = "SELECT * FROM stores WHERE storeenabled = '1'";
$rs_result_stores = mysqli_query($rs_connect, $rs_find_stores);
	while($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
	$rs_storeid = "$rs_result_storeq->storeid";
	$rs_checkstockcounts = "SELECT * FROM stockcounts WHERE storeid = '$rs_storeid' AND stockid = '$stock_id'";
	$rs_result_sc = mysqli_query($rs_connect, $rs_checkstockcounts);
	$sc_result = mysqli_num_rows($rs_result_sc);
		if ($sc_result == 0) {
		$insertstore = "INSERT INTO stockcounts (stockid, storeid, quantity) VALUES ('$stock_id','$rs_storeid','0')";
		@mysqli_query($rs_connect, $insertstore);
		}
	}
}


function getourprice($stockid) {
require("deps.php");



$rs_qop = "SELECT inv_price FROM inventory WHERE stock_id = $stockid ORDER BY inv_date DESC LIMIT 1";
$rs_result1 = mysqli_query($rs_connect, $rs_qop);
$rs_result_q1 = mysqli_fetch_object($rs_result1);

$rs_qop2 = "SELECT avg_cost FROM stock WHERE stock_id = '$stockid'";
$rs_result2 = mysqli_query($rs_connect, $rs_qop2);
$rs_result_q2 = mysqli_fetch_object($rs_result2);

$avg_cost = "$rs_result_q2->avg_cost";
if ($avg_cost != "0") {
$ourprice = "$avg_cost";
} else {
$ourprice = "$rs_result_q1->inv_price";
}
return $ourprice;
}


function invoiceorquote($invoiceid) {
require("deps.php");
$rs_iorqq = "SELECT iorq FROM invoices WHERE invoice_id = $invoiceid";
$rs_result1 = mysqli_query($rs_connect, $rs_iorqq);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$iorq2 = "$rs_result_q1->iorq";
if ($iorq2 == "quote") {
$iorq = "quote";
} else {
$iorq =	"invoice";
}
return $iorq;
}


function trim_value(&$value)
{
    $value = trim($value);
}


function available_serials($stockid) {

require("deps.php");

$itemserialblob = "";
$itemserialblob_sold = "";
$itemserialblob_return = "";

$rs_find_serial = "SELECT * FROM inventory WHERE stock_id = '$stockid' AND itemserial != ''";
$rs_find_serial_q = @mysqli_query($rs_connect, $rs_find_serial);
while($rs_find_result_q = mysqli_fetch_object($rs_find_serial_q)) {
$itemserials = "$rs_find_result_q->itemserial";
$itemserialblob .= "$itemserials\n";
}
if(mysqli_num_rows($rs_find_serial_q) > 0) {
$itemserialarray = explode("\n", trim($itemserialblob));
} else {
$itemserialarray = array();
}

$rs_find_serial_sold = "SELECT * FROM sold_items WHERE stockid = '$stockid' AND itemserial != '' AND sold_type != 'refund'";
$rs_find_serial_q_sold = @mysqli_query($rs_connect, $rs_find_serial_sold);
while($rs_find_result_q_sold = mysqli_fetch_object($rs_find_serial_q_sold)) {
$itemserials_sold = "$rs_find_result_q_sold->itemserial";
$itemserialblob_sold .= "$itemserials_sold\n";
}
if(mysqli_num_rows($rs_find_serial_q_sold) > 0) {
$itemserialarray_sold = explode("\n", trim($itemserialblob_sold));
} else {
$itemserialarray_sold = array();
}

$rs_find_serial_repaircart = "SELECT * FROM pc_wo WHERE pcstatus != '5'";
$rs_find_serial_q_repaircart = @mysqli_query($rs_connect, $rs_find_serial_repaircart);
while($rs_find_result_q_repaircart = mysqli_fetch_object($rs_find_serial_q_repaircart)) {
$activeworkorders = "$rs_find_result_q_repaircart->woid";
$rs_find_serial_repaircart_items = "SELECT * FROM repaircart WHERE pcwo = '$activeworkorders'";
$rs_find_serial_q_repaircart_items = @mysqli_query($rs_connect, $rs_find_serial_repaircart_items);
while($rs_find_result_q_repaircart_items = mysqli_fetch_object($rs_find_serial_q_repaircart_items)) {
$activeworkorderserial = "$rs_find_result_q_repaircart_items->itemserial";
$itemserialarray_sold[] = "$activeworkorderserial";
}
}


$rs_find_serial_cart_items = "SELECT * FROM cart";
$rs_find_serial_q_cart_items = @mysqli_query($rs_connect, $rs_find_serial_cart_items);
while($rs_find_result_q_cart_items = mysqli_fetch_object($rs_find_serial_q_cart_items)) {
$activeworkorderserial = "$rs_find_result_q_cart_items->itemserial";
$itemserialarray_sold[] = "$activeworkorderserial";
}


$rs_find_serial_openinvoice = "SELECT * FROM invoices WHERE invstatus = '1'";
$rs_find_serial_q_openinvoice = @mysqli_query($rs_connect, $rs_find_serial_openinvoice);
while($rs_find_result_q_openinvoice = mysqli_fetch_object($rs_find_serial_q_openinvoice)) {
$activeinvoices = "$rs_find_result_q_openinvoice->invoice_id";
$rs_find_serial_invoice_items = "SELECT * FROM invoice_items WHERE invoice_id = '$activeinvoices'";
$rs_find_serial_q_invoice_items = @mysqli_query($rs_connect, $rs_find_serial_invoice_items);
while($rs_find_result_q_invoice_items = mysqli_fetch_object($rs_find_serial_q_invoice_items)) {
$activeinvoiceserial = "$rs_find_result_q_invoice_items->itemserial";
$itemserialarray_sold[] = "$activeinvoiceserial";
}
}



$rs_find_serial_return = "SELECT * FROM sold_items WHERE stockid = '$stockid' AND itemserial != '' AND sold_type = 'refund'";
$rs_find_serial_q_return = @mysqli_query($rs_connect, $rs_find_serial_return);
while($rs_find_result_q_return = mysqli_fetch_object($rs_find_serial_q_return)) {
$itemserials_return = "$rs_find_result_q_return->itemserial";
$itemserialblob_return .= "$itemserials_return\n";
}
if(mysqli_num_rows($rs_find_serial_q_return) > 0) {
$itemserialarray_return = explode("\n", trim($itemserialblob_return));
} else {
$itemserialarray_return = array();
}



foreach($itemserialarray_return as $remove){
       	foreach($itemserialarray_sold as $k=>$v){
            if((string)$v === (string)$remove){
                unset($itemserialarray_sold[$k]);
                break;
            }
        }
    }


array_walk($itemserialarray, 'trim_value');
array_walk($itemserialarray_sold, 'trim_value');

$availser = array_diff($itemserialarray, $itemserialarray_sold);

sort($availser);

return $availser;

}


function getboxstyle($statusid) {
require("deps.php");



$rs_qc = "SELECT * FROM boxstyles WHERE statusid = '$statusid'";
$rs_result1 = mysqli_query($rs_connect, $rs_qc);
$rs_result_q1 = mysqli_fetch_object($rs_result1);

$boxstyle = array();
$boxstyle['selectorcolor'] = "$rs_result_q1->selectorcolor";
$boxstyle['boxtitle'] = "$rs_result_q1->boxtitle";

return $boxstyle;

}



function pcrtnotifynew() {
require("deps.php");
require_once("validate.php");

$pcrtnotify2 = "";
$pcrtnotify3 = "";
$pcrtnotify = "";
if (perm_check("14")) {
$findrinvsql = "SELECT * FROM rinvoices WHERE reinvoicedate < NOW() AND invactive = '1'";
$findrinvq = @mysqli_query($rs_connect, $findrinvsql);
$totalready = mysqli_num_rows($findrinvq);
if($totalready > 0) {
$pcrtnotify .= "<a href=../store/rinvoice.php?func=runinvoices class=\"notifybadge tooltip\" data-badge=\"$totalready\"><i class=\"fa fa-file-text faa-tada animated fa-2x\"></i><span>".pcrtlang("Recurring Invoices are ready to be created.")."</span></a>";
}

}

if (perm_check("17")) {
$findsrsql = "SELECT * FROM servicereminders WHERE srdate < NOW() AND srsent != '1'";
$findsrq = @mysqli_query($rs_connect, $findsrsql);
$totalsr = mysqli_num_rows($findsrq);
if($totalsr > 0) {
$pcrtnotify .= "<a href=../repair/servicereminder.php?func=runsr class=\"notifybadge tooltip\" data-badge=\"$totalsr\"><i class=\"fa fa-bell faa-ring animated fa-2x\"></i><span>".pcrtlang("Service Reminders are ready to be sent.")."</span></a>";
}
}

if (perm_check("28")) {
$findrwosql = "SELECT * FROM rwo WHERE rwodate < NOW()";
$findrwoq = @mysqli_query($rs_connect, $findrwosql);
$totalrwo = mysqli_num_rows($findrwoq);
if($totalrwo > 0) {
$pcrtnotify .= "<a href=../repair/rwo.php?func=runrwo class=\"notifybadge tooltip\" data-badge=\"$totalrwo\"><i class=\"fa fa-clipboard faa-tada animated fa-2x\"></i><span>".pcrtlang("Recurring Work Orders are due.")."</span></a>";
}
}



$findsreqsql = "SELECT * FROM servicerequests WHERE sreq_processed = '0'";
$findsreqq = @mysqli_query($rs_connect, $findsreqsql);
$totalsreq = mysqli_num_rows($findsreqq);
if($totalsreq > 0) {
$pcrtnotify .= "<a href=../repair/servicerequests.php?func=runsreq class=\"notifybadge tooltip\" data-badge=\"$totalsreq\"><i class=\"fa fa-comment faa-tada animated fa-2x\"></i><span>".pcrtlang("Service Requests are pending.")."</span></a>";
}

if (perm_check("6")) {
$rs_ql = "SELECT defaultstore FROM users WHERE username = '$ipofpc'";
$rs_result1 = mysqli_query($rs_connect, $rs_ql);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$defaultuserstore = "$rs_result_q1->defaultstore";
$findrecountsql = "SELECT * FROM stockcounts WHERE reqcount = '1' AND storeid = '$defaultuserstore'";
$findrecountq = @mysqli_query($rs_connect, $findrecountsql);
$totalsrecount2 = mysqli_num_rows($findrecountq);
if($totalsrecount2 > 0) {
$pcrtnotify .= "<a href=categories.php?func=stockrecount class=\"notifybadge tooltip\" data-badge=\"$totalsrecount2\">
<i class=\"fa fa-cubes faa-tada animated fa-2x\"></i><span>".pcrtlang("Inventory Recount Requested.")."</span></a>";
}
}

if ($pcrtnotify != "") {
$pcrtnotifyout = $pcrtnotify2;
$pcrtnotifyout .= $pcrtnotify;
$pcrtnotifyout .= $pcrtnotify3;
} else {
$pcrtnotifyout = "";
}


return $pcrtnotifyout;
}




function getstatusselectorcolors() {
require("deps.php");



$rs_qc = "SELECT statusid,selectorcolor FROM boxstyles";
$rs_result1 = mysqli_query($rs_connect, $rs_qc);
$statusselectorcolors = array();
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$statusid = "$rs_result_q1->statusid";
$statuscolor = "$rs_result_q1->selectorcolor";
$statusselectorcolors[$statusid] = $statuscolor;

}
return $statusselectorcolors;

}
function getboxtitles() {
require("deps.php");



$rs_qc = "SELECT statusid,boxtitle FROM boxstyles";
$rs_result1 = mysqli_query($rs_connect, $rs_qc);
$boxtitles = array();
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$statusid = "$rs_result_q1->statusid";
$boxtitle = "$rs_result_q1->boxtitle";
$boxtitles[$statusid] = $boxtitle;

}
return $boxtitles;

}


#########################################

function buildlangblob() {
require("deps.php");
$findstring = "SELECT languagestring,basestring FROM languages WHERE language = '$mypcrtlanguage'";
$findstringq = @mysqli_query($rs_connect, $findstring);
$langblobmain = array();
while ($rs_result_qs = mysqli_fetch_object($findstringq)) {
$langstring = "$rs_result_qs->languagestring";
$basestring = "$rs_result_qs->basestring";
$langblobmain[$basestring] = $langstring;
}
return $langblobmain;
}

function pcrtlang($string) {
require("deps.php");
static $langblobmain = false;
if(!$langblobmain) {
$langblob = buildlangblob();
$langblobmain = $langblob;
}
if (array_key_exists($string, $langblobmain)) {
return $langblobmain[$string];
} else {
$safestring = pv($string);
$addstring = "INSERT INTO languages (language,languagestring,basestring) VALUES ('$mypcrtlanguage','$safestring','$safestring')";
@mysqli_query($rs_connect, $addstring);
$langblobmain[$string] = $string;
return "$string";
}
}


########################################


function picktime($selectname,$pretime) {
echo "<select name=$selectname class=selecttimepicker>";
$hours = array(12,1,2,3,4,5,6,7,8,9,10,11);
$ampms = array('AM','PM');

if (preg_match('/AM/i', $pretime)) {
$amorpm = "AM";
} else {
$amorpm = "PM";
}

$gettime2 = explode(" ", $pretime);
$gettime = $gettime2[0];
$thehourarray = explode(":", $gettime);

$thehour = $thehourarray[0];
$theminute = $thehourarray[1];

foreach($ampms as $key => $ampm) {
foreach($hours as $key => $hour) {
if($pretime == "$hour:00 $ampm") {
echo "<option selected value=\"$hour:00 $ampm\" style=\"background:#cccccc;\">$hour:00 $ampm</option>";
} else {
echo "<option value=\"$hour:00 $ampm\" style=\"background:#cccccc;\">$hour:00 $ampm</option>";
}

if(("$amorpm" == "$ampm") && ($thehour == $hour) && (($theminute > 0) && ($theminute < 15))) {
echo "<option selected value=\"$pretime\" style=\"background:#ffcccc;\">$pretime</option>";
}

if($pretime == "$hour:15 $ampm") {
echo "<option selected value=\"$hour:15 $ampm\" class=selecttimepickeroption>$hour:15 $ampm</option>";
} else {
echo "<option value=\"$hour:15 $ampm\" class=selecttimepickeroption>$hour:15 $ampm</option>";
}

if(("$amorpm" == "$ampm") && ($thehour == $hour) && (($theminute > 15) && ($theminute < 30))) {
echo "<option selected value=\"$pretime\" style=\"background:#ffcccc;\">$pretime</option>";
}

if($pretime == "$hour:30 $ampm") {
echo "<option selected value=\"$hour:30 $ampm\" class=selecttimepickeroption>$hour:30 $ampm</option>";
} else {
echo "<option value=\"$hour:30 $ampm\" class=selecttimepickeroption>$hour:30 $ampm</option>";
}

if(("$amorpm" == "$ampm") && ($thehour == $hour) && (($theminute > 30) && ($theminute < 45))) {
echo "<option selected value=\"$pretime\" style=\"background:#ffcccc;\">$pretime</option>";
}


if($pretime == "$hour:45 $ampm") {
echo "<option selected value=\"$hour:45 $ampm\" class=selecttimepickeroption>$hour:45 $ampm</option>";
} else {
echo "<option value=\"$hour:45 $ampm\" class=selecttimepickeroption>$hour:45 $ampm</option>";
}
if(("$amorpm" == "$ampm") && ($thehour == $hour) && (($theminute > 45) && ($theminute <= 59))) {
echo "<option selected value=\"$pretime\" style=\"background:#ffcccc;\">$pretime</option>";
}

}
reset($hours);
}


echo "</select>";

}



function serializedarraytest($array) {
if ($array != "") {
$arrayout2 = unserialize($array);
if (is_array($arrayout2)) {
$arrayout = $arrayout2;
} else {
$arrayout = array();
}
} else {
$arrayout = array();
}

return $arrayout;
}




function pcrtdate($timestring,$timestamp) {

require("deps.php");
if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}


if(!is_numeric($timestamp)) {
$timestamp = strtotime($timestamp);
}

$dateconv = str_replace(
  array('FULL_MONTH_NAME','ABBR_MONTH_NAME','NUMERIC_MONTH_LEADING_ZERO','NUMERIC_MONTH_NO_LEADING_ZERO','NUMERIC_DAY_LEADING_ZERO','NUMERIC_DAY_NO_LEADING_ZERO', 'DAY_OF_WEEK_ABBR','DAY_OF_WEEK_FULL','ENGLISH_SUFFIX','4_DIGIT_YEAR','2_DIGIT_YEAR','24_HOURS_NO_LEADING_ZERO','24_HOURS_LEADING_ZERO','HOURS_NO_LEADING_ZERO','HOURS_LEADING_ZERO','MINUTES','SECONDS','AM_PM_LOWERCASE','AM_PM_UPPERCASE'),
  array(pcrtlang(date("F",$timestamp)),pcrtlang(date("M",$timestamp)),date("m",$timestamp),date("n",$timestamp),date("d",$timestamp),date("j",$timestamp),pcrtlang(date("D",$timestamp)),pcrtlang(date("l",$timestamp)),date("S",$timestamp),date("Y",$timestamp),date("y",$timestamp),date("G",$timestamp),date("H",$timestamp),date("g",$timestamp),date("h",$timestamp),date("i",$timestamp),date("s",$timestamp),date("a",$timestamp),date("A",$timestamp)),
  $timestring
);

return $dateconv;

}



function implode_list($value) {
if(is_array($value)) {
if(count($value) > 1) {
$newvalue = "_";
foreach($value as $key => $valueitem) {
$newvalue .= "$valueitem"."_";
}
} else {
foreach($value as $key => $valueitem) {
$newvalue .= "$valueitem";
}
}
} else {
$newvalue = "$value";
}
return $newvalue;
}


function explode_list($value) {
if (strpos($value, '_') === false) {
return array_filter(array($value));
} else {
return array_values(array_filter(explode("_", "$value")));
}
}


function addhttp($url) {
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://" . $url;
    }
    return $url;
}


function printableheader($title) {

global $autoprint;

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php
echo "<title>$title</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../repair/printstyle.css\">";
echo "<link rel=\"stylesheet\" href=\"../repair/fa5/css/all.min.css\">";
echo "<link rel=\"stylesheet\" href=\"../repair/fa5/css/v4-shims.min.css\">";
echo "<link rel=\"stylesheet\" href=\"../repair/fa5/font-awesome-animation.min.css\">";
echo "</head>";

if($autoprint == 1) {
echo "<body class=printpagebg onLoad=\"window.print()\">";
} else {
echo "<body class=printpagebg>";
}

echo "<div class=printbar>";
echo "<button onClick=\"window.history.back()\" class=bigbutton><img src=images/left.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Return")."</button>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<button onClick=\"print();\" class=bigbutton><img src=images/print.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Print")."</button>";
echo "</div>";
echo "<div class=printpage>";

}



function printablefooter() {
echo "</div>";
echo "</body></html>";
}



function stockavailability($stockid,$storeid,$quantity) {

require("deps.php");




$checkopeninvoices = "SELECT invoice_items.cart_stock_id FROM invoice_items,invoices WHERE invoice_items.cart_stock_id = '$stockid' AND invoice_items.invoice_id = invoices.invoice_id AND invoices.invstatus = '1' AND invoices.storeid = '$storeid' AND invoices.iorq != 'quote'";
$checkopeninvoices_q = mysqli_query($rs_connect, $checkopeninvoices);

$countoninvoices = mysqli_num_rows($checkopeninvoices_q);

#####


$fillrcarr = "SELECT repaircart.pcwo AS pcwo FROM repaircart,pc_wo WHERE repaircart.cart_stock_id = '$stockid' AND repaircart.pcwo = pc_wo.woid AND pc_wo.pcstatus != '5' AND pc_wo.storeid = '$storeid'";


$fillrcarr_q = mysqli_query($rs_connect, $fillrcarr);
$countonwo = mysqli_num_rows($fillrcarr_q);

if($countonwo == 0) {
$thewoids = array();
}

$thewoidswithinvoices = array();
$woidswithoutinvoices = array();

while ($fillrcarr_resultq = mysqli_fetch_object($fillrcarr_q)) {
$thewoid = "$fillrcarr_resultq->pcwo";
$thewoids[] = $thewoid;

$rs_find_wo_inv = "SELECT * FROM invoices WHERE woid = '$thewoid' AND iorq != 'quote'";
$rs_result_wo_inv = mysqli_query($rs_connect, $rs_find_wo_inv);
if (mysqli_num_rows($rs_result_wo_inv) != 0) {
$thewoidswithinvoices[] = $thewoid;
} 
}


foreach($thewoids as $key => $val) {
if(!in_array("$val", $thewoidswithinvoices)) {
$woidswithoutinvoices[] = $val;
}
}

$countonwowithoutinvoices = count($woidswithoutinvoices);


$tavail = ($quantity - $countoninvoices) - $countonwowithoutinvoices;

$storea = getstoreinfo($storeid);
$storesname = $storea['storesname'];

$quantityarray['store'] = "$storeid $storesname";
$quantityarray['countoninvoice'] = $countoninvoices;
$quantityarray['countonwo'] = $countonwo;
$quantityarray['countonwowithoutinvoices'] = $countonwowithoutinvoices;
$quantityarray['available'] = $tavail;


return $quantityarray;

}

function getcurrentregister() {
if (array_key_exists("registerid", $_COOKIE)) {
$registerid = $_COOKIE['registerid'];
} else {
$registerid = 0;
}
return $registerid;
}



function groupbyinvoice($invoice_id) {
require("deps.php");
$rs_invoicest = "(SELECT pc_owner.pcgroupid AS groupid FROM invoices, pc_wo, pc_owner WHERE  pc_owner.pcid = pc_wo.pcid AND pc_owner.pcgroupid != '0'
AND invoices.invoice_id = '$invoice_id' AND (pc_wo.woid = invoices.woid OR invoices.woid LIKE CONCAT('%\_',pc_wo.woid,'\_%')))
UNION (SELECT rinvoices.pcgroupid AS groupid FROM invoices,rinvoices WHERE invoices.rinvoice_id = rinvoices.rinvoice_id
AND invoices.rinvoice_id = '$invoice_id' AND rinvoices.pcgroupid != '0')
UNION (SELECT pcgroupid AS groupid FROM invoices WHERE invoice_id = '$invoice_id' AND pcgroupid != '0')
UNION (SELECT DISTINCT(blockcontract.pcgroupid) AS groupid
FROM invoices,blockcontracthours,blockcontract WHERE blockcontracthours.invoiceid = '$invoice_id'
AND  blockcontract.blockid = blockcontracthours.blockcontractid AND blockcontract.pcgroupid != '0') LIMIT 1";


$findgroupmatch = @mysqli_query($rs_connect, $rs_invoicest);
$totalmatch1 = mysqli_num_rows($findgroupmatch);
if($totalmatch1 != 0) {
$findgroupmatchobj = mysqli_fetch_object($findgroupmatch);
$groupid = "$findgroupmatchobj->groupid";
} else {
$groupid = 0;
}
return $groupid;
}


function fetchtagdata() {
require("deps.php");
$rs_sq = "SELECT * FROM custtags ORDER BY theorder DESC";
$rs_result1 = mysqli_query($rs_connect, $rs_sq);
while($rs_result_q1 = mysqli_fetch_object($rs_result1)) {
$tagid = "$rs_result_q1->tagid";
$thetag = "$rs_result_q1->thetag";
$tagicon = "$rs_result_q1->tagicon";
$tagenabled = "$rs_result_q1->tagenabled";
$theorder = "$rs_result_q1->theorder";
$primero = mb_substr("$thetag", 0, 1);

if("$primero" != "-") {
$tagdata[$tagid] = array('tagid' => "$tagid",'thetag' => "$thetag",'tagicon' => "$tagicon",'tagenabled' => "$tagenabled");
}
}
return $tagdata;
}



function displaytags($pcid,$groupid,$size) {
require("deps.php");

if($pcid != "0") {
$rs_tq = "SELECT tags FROM pc_owner WHERE pcid = '$pcid'";
$rs_result1 = mysqli_query($rs_connect, $rs_tq);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$tags = "$rs_result_q1->tags";
$tagsarray = explode_list($tags);
} else {
$tagsarray = array();
}

if($groupid != "0") {
$rs_tq = "SELECT tags FROM pc_group WHERE pcgroupid = '$groupid'";
$rs_result1 = mysqli_query($rs_connect, $rs_tq);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$tagsgroup = "$rs_result_q1->tags";
$tagsgrouparray = explode_list($tagsgroup);
} else {
$tagsgrouparray = array();
}

$combinedtagsarray = array_unique(array_merge($tagsarray,$tagsgrouparray));

if(!empty($combinedtagsarray)) {
static $tagdata = false;
if(!$tagdata) {
$tagdata2 = fetchtagdata();
$tagdata = $tagdata2;
}
foreach($combinedtagsarray as $tagkey => $tagval) {
        if(!empty($tagval)) {
        echo "<img src=../repair/images/tags/".$tagdata[$tagval]['tagicon']." width=\"$size\"> ";
        }
}
} else {
}


}

function tnv($value) {
if(!is_numeric($value)) {
return 0;	
} else {
return "$value";	
}
}


function paymentlogo($paymenttype) {
if (preg_match('/check/i', $paymenttype) || preg_match('/cheque/i', $paymenttype)) {
$paymentlogo = "<i class=\"fa fa-money-check fa-3x\" style=\"color:#00B6CE;\"></i>";
} elseif (preg_match('/cash/i', $paymenttype)) {
$paymentlogo = "<i class=\"fa fa-money-bill-alt fa-3x\" style=\"color:#79a87c;\"></i>";
} elseif (preg_match('/stripe/i', $paymenttype)) {
$paymentlogo = "<i class=\"fa fa-cc-stripe fa-3x\" style=\"color:#0090e0\"></i>";
} elseif (preg_match('/paypal/i', $paymenttype)) {
$paymentlogo = "<i class=\"fa fa-cc-paypal fa-3x\" style=\"color:#005ea6\"></i>";
} elseif (preg_match('/square/i', $paymenttype)) {
$paymentlogo = "<i class=\"fa fa-square fa-3x\"></i>";
} elseif (preg_match('/authorize/i', $paymenttype)) {
$paymentlogo = "<i class=\"fa fa-adn fa-3x\" style=\"color:#4c8bbc\"></i>";
} elseif (preg_match('/bank/i', $paymenttype) || preg_match('/note/i', $paymenttype)) {
$paymentlogo = "<i class=\"fa fa-university fa-3x\"></i>";
} elseif (preg_match('/credit/i', $paymenttype) || preg_match('/card/i', $paymenttype)) {
$paymentlogo = "<i class=\"fa fa-credit-card fa-3x\" style=\"color:#2B3E91\"></i>";
} else {
$paymentlogo = "<i class=\"fa fa-wallet fa-3x\" style=\"color:#875c00\"></i>";
}
return $paymentlogo;
}


function getinvoicetermstitle($invoicetermsid) {
require("deps.php");
$rs_sl = "SELECT * FROM invoiceterms WHERE invoicetermsid = '$invoicetermsid'";
$rs_result1 = mysqli_query($rs_connect, $rs_sl);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$invoicetermstitle = "$rs_result_q1->invoicetermstitle";
return "$invoicetermstitle";
}

function getinvoicetermsdefault() {
require("deps.php");
$rs_sl = "SELECT * FROM invoiceterms WHERE invoicetermsdefault = '1' LIMIT 1";
$rs_result1 = mysqli_query($rs_connect, $rs_sl);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$invoicetermsid = "$rs_result_q1->invoicetermsid";
return "$invoicetermsid";
}



function processlatefees($invoiceid) {
require("deps.php");

$rs_invoices = "SELECT * FROM invoices WHERE invoice_id = '$invoiceid'";
$rs_find_invoices = @mysqli_query($rs_connect, $rs_invoices);
$rs_find_invoices_q = mysqli_fetch_object($rs_find_invoices);
$latefeeid = "$rs_find_invoices_q->latefeeid";
$invoicetermsid = "$rs_find_invoices_q->invoicetermsid";
$duedate = "$rs_find_invoices_q->duedate";

$numberofmonths = floor(((time() - strtotime($duedate)) / 2592000));

if($numberofmonths > 0) { 
if($latefeeid != 0) {
$findinvtotal = "SELECT SUM(cart_price) AS invsubtotal FROM invoice_items WHERE invoice_id = '$invoiceid' AND cart_item_id != '$latefeeid'";
} else {
$findinvtotal = "SELECT SUM(cart_price) AS invsubtotal FROM invoice_items WHERE invoice_id = '$invoiceid'";
}
$findinvq = @mysqli_query($rs_connect, $findinvtotal);
$findinva = mysqli_fetch_object($findinvq);
$invsubtotal = "$findinva->invsubtotal";

$finddeposits = "SELECT SUM(amount) AS deposittotal FROM deposits WHERE invoiceid = '$invoiceid'";
$finddepositsq = @mysqli_query($rs_connect, $finddeposits);
$finddepositsa = mysqli_fetch_object($finddepositsq);
$deposittotal = "$finddepositsa->deposittotal";

$invsubtotal = tnv($invsubtotal) - tnv($deposittotal);

if($invsubtotal > 0) {
$rs_sl = "SELECT * FROM invoiceterms WHERE invoicetermsid = '$invoicetermsid'";
$rs_result1 = mysqli_query($rs_connect, $rs_sl);
$rs_result_q1 = mysqli_fetch_object($rs_result1);
$invoicetermslatefee = "$rs_result_q1->invoicetermslatefee";
$invoicelatefeetaxid = "$rs_result_q1->taxid";

		if($invoicetermslatefee > 0) {
			$latefeelabel = pcrtlang("Late Fee");
			$taxrate = getsalestaxrate($invoicelatefeetaxid);
			$latefeeamount = (($numberofmonths * ($invoicetermslatefee * .01)) * $invsubtotal);

			#die("$numberofmonths g $invoicetermslatefee g $invsubtotal");
			$addtime = time();
			$latefeetax = $latefeeamount * $taxrate;
			if($latefeeid == 0) {
			$rs_insert_cart = "INSERT INTO invoice_items (invoice_id,cart_price,labor_desc,cart_type,taxex,itemtax,addtime,unit_price,quantity)
			VALUES ('$invoiceid','$latefeeamount','$latefeelabel','labor','$invoicelatefeetaxid','$latefeetax','$addtime','$latefeeamount','1')";
			@mysqli_query($rs_connect, $rs_insert_cart);
                	$latefeeitemid = mysqli_insert_id($rs_connect);
                	$insertfeelink = "UPDATE invoices SET latefeeid = '$latefeeitemid' WHERE invoice_id = '$invoiceid'";
                	@mysqli_query($rs_connect, $insertfeelink);
			} else {
			$rs_insert_cart = "UPDATE invoice_items SET cart_price = '$latefeeamount', labor_desc = '$latefeelabel', taxex = '$invoicelatefeetaxid', addtime = '$addtime', itemtax = '$latefeetax', unit_price = '$latefeeamount' WHERE cart_item_id = '$latefeeid'";
			@mysqli_query($rs_connect, $rs_insert_cart);
			}

		} else {
			$rs_clear_items = "DELETE FROM invoice_items WHERE cart_item_id = $latefeeid";
			@mysqli_query($rs_connect, $rs_clear_items);
			                $rs_clear_lid = "UPDATE invoices SET latefeeid = '0' WHERE invoice_id = $invoiceid";
                			@mysqli_query($rs_connect, $rs_clear_lid);
		}
	} else {	
		if($latefeeid != 0) {
		$rs_clear_items = "DELETE FROM invoice_items WHERE cart_item_id = $latefeeid";
		@mysqli_query($rs_connect, $rs_clear_items);
		$rs_clear_lid = "UPDATE invoices SET latefeeid = '0' WHERE invoice_id = $invoiceid";
                @mysqli_query($rs_connect, $rs_clear_lid);
		}
	}
#end of negative balance invoice from large deposit
	}

}
