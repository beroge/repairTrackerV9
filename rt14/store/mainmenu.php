<?php

/***************************************************************************
 *   copyright            : (C) 2012 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/


require_once("validate2.php");
require_once("deps.php");
require_once("common.php");


start_blue_box(pcrtlang("Search Receipts"));
echo pcrtlang("Enter a part of the customers name or a receipt")." #";
echo "<form action=receipt.php?func=search_receipt method=post>";
echo "<input type=text class=textbox name=thesearch>";
echo "<br><input type=submit class=button value=\"".pcrtlang("Search Receipts")."\"></form>";

stop_blue_box();

echo "<br><br>";


start_blue_box(pcrtlang("Search Invoices"));
echo pcrtlang("Enter an invoice # or part of the customers name");
echo "<form action=invoice.php?func=searchinvoices2 method=post>";
echo "<input type=text class=textbox name=searchterm>";
echo "<br><input type=submit class=button value=\"".pcrtlang("Search Invoices")."\"></form>";

stop_blue_box();

echo "<br><br>";




?>

