
<?php

/***************************************************************************
 *   copyright            : (C) 2017 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/


require_once("validate2.php");
include_once("common.php");

if ($gomodal == 1) {
$therel = "rel=facebox";
} else {
$therel = "";
}


echo "<table><tr><td style=\"vertical-align:top;\">";


echo "<span class=menuheading><i class=\"fa fa-store fa-lg\"></i> ".pcrtlang("Store")."</span>";


$rs_find_stores = "SELECT * FROM stores WHERE storeenabled = '1' ORDER BY storesname ASC";
$rs_result_stores = mysqli_query($rs_connect,$rs_find_stores);

while($rs_result_storeq = mysqli_fetch_object($rs_result_stores)) {
$rs_storesname = "$rs_result_storeq->storesname";
$rs_storeid = "$rs_result_storeq->storeid";

if ($rs_storeid == $defaultuserstore) {
echo "<a href=\"../repair/admin.php?func=setuserdefaultstore&setuserdefaultstore=$rs_storeid\" class=menulink style=\"pointer-events:none;\"><img src=../repair/images/store.png class=menuicon> $rs_storesname <i class=\"fa fa-check-circle fa-lg menuicon\"></i></a>";
} else {
echo "<a href=\"../repair/admin.php?func=setuserdefaultstore&setuserdefaultstore=$rs_storeid\" class=menulink><img src=../repair/images/store.png class=menuicon> $rs_storesname</a>";
}
}



echo "</td><td style=\"vertical-align:top;\">";

echo "<a href=../repair/imessages.php?func=browsemessages class=menulink><img src=../repair/images/sr.png class=menuicon> ".pcrtlang("Chat")."</a>";

echo "<a href=../repair/pc.php?func=frameit class=menulink><img src=../repair/images/tools.png class=menuicon> ".pcrtlang("Tools &amp Docs")."</a>";
echo "<a href=../repair/admin.php class=menulink><img src=../repair/images/admin.png class=menuicon> ".pcrtlang("Settings")."</a>";

$ruri = urlencode($_SERVER['REQUEST_URI']);
echo "<a href=../repair/admin.php?func=switchuser&ruri=$ruri class=menulink><img src=../repair/images/sync.png class=menuicon> ".pcrtlang("Switch User")."</a>";

echo "<a href=\"../timeclock/\" class=menulink><img src=../repair/images/clock.png class=menuicon> ".pcrtlang("Timeclock")."</a>";

if (perm_check("41")) {
echo "<a href=\"../ledger/\" class=menulink><img src=../repair/images/deposits.png class=menuicon> ".pcrtlang("Ledger")."</a>";
}

echo "<a href=\"../repair/logout.php\" class=menulink><img src=../repair/images/logout.png class=menuicon> ".pcrtlang("Logout")."</a>";

echo "</td></tr></table>";
