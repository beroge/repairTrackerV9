<?php

require("header.php");

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}



if (array_key_exists('paidinvoice',$_REQUEST)) {
echo "<div class=\"bg-success text-center\">";
echo "<br><h3 class=\"text-success\"><i class=\"fa fa-bell fa-lg\"></i> ".pcrtlang("Invoice Paid... Thank You!")."</h3><br>";

if (array_key_exists('receiptnumber',$_REQUEST)) {
echo "<a href=receipt.php?func=printreceipt&receipt=$_REQUEST[receiptnumber]><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Print Receipt")."</a><br><br>";
}
echo "</div>";
}

$rs_findpc = "SELECT * FROM pc_group WHERE pcgroupid = '$portalgroupid'";
$rs_result = mysqli_query($rs_connect, $rs_findpc);
$rs_result_q = mysqli_fetch_object($rs_result);
$grpphone = "$rs_result_q->grpphone";
$grpcellphone = "$rs_result_q->grpcellphone";
$grpworkphone = "$rs_result_q->grpworkphone";
$pcgroupname = "$rs_result_q->pcgroupname";

$messagephone = "$pcgroupname";


echo "<h3>".pcrtlang("Recent Messages")."</h3>";

echo "<div id=notifyarea></div>";

echo "<table style=\"width:100%\"><tr><td style=\"width:75%\" >";
echo "<form action=customer.php?func=addmessage method=post id=calllogform>";
echo "<input type=hidden name=messagephone value=\"$messagephone\">";
echo "<textarea name=themessage class=\"form-control\" required=required  style=\"width:90%;height:55px;\" placeholder=\"".pcrtlang("Enter Message")."\"></textarea>";
echo "</td><td><button type=submit class=\"btn btn-primary\"><i class=\"fa fa-paper-plane fa-lg\"></i> ".pcrtlang("Send Message")."</button>";
echo "</form></td></tr></table>";


require("pajaxcalls.php");
echo "<div id=messagearea>";
displaymessages();
echo "</div>";

?>
<script>
$(document).ready(function(){
$('#calllogform').submit(function(e) { // catch the form's submit event
        e.preventDefault();
        $.ajax({ // create an AJAX call...
        data: $(this).serialize(), // get the form data
        type: $(this).attr('method'), // GET or POST
        url: $(this).attr('action'), // the file to call
        success: function(response) { // on success..
            $('#messagearea').html(response); // update the DIV
        $('#calllogform').each (function(){
          this.reset();
        });
    }
    });
});
});



$(document).ready(function () {
        setInterval(function() {
                $.get('customer.php?func=messageload', function(data) {
                $('#messagearea').html(data);
                });
        }, 60000);
});

</script>

<?php
echo "<a href=messages.php class=\"pull-right\"><i class=\"fa fa-comment-o fa-lg\"></i> ".pcrtlang("Browse Messages")."</a>";

echo "<br><br><br>";

echo "<h3>".pcrtlang("Unpaid Invoices")."</h3>";

#echo "<div class=\"table-responsive\">";
echo "<table id=invoicetable class=\"table table-striped\">";
echo "<thead><tr><th><strong>".pcrtlang("Inv")."#&nbsp;&nbsp;</strong></th><th class=\"visible-lg\">".pcrtlang("Customer Name")."&nbsp;&nbsp;</th><th>".pcrtlang("Invoice Date")."&nbsp;&nbsp;</th>";
echo "<th> ".pcrtlang("Total")." &nbsp;&nbsp;</th><th>".pcrtlang("Actions")."&nbsp;&nbsp;</th></tr></thead><tbody>";


$rs_find_invoicest = @mysqli_query($rs_connect, $rs_invoicest);
$rs_invoices = "(SELECT DISTINCT(invoices.invoice_id),invoices.invname,invoices.invstatus,invoices.invemail,invoices.woid,invoices.receipt_id,invoices.invdate,
invoices.invcompany,invoices.pcgroupid,invoices.invphone,invoices.invaddy1,invoices.invaddy2,invoices.invcity,invoices.invstate,invoices.invzip FROM invoices, pc_wo, pc_owner WHERE invoices.invstatus = 1 AND pc_owner.pcgroupid = '$portalgroupid' AND pc_owner.pcid = pc_wo.pcid AND invoices.iorq != 'quote' 
AND (pc_wo.woid = invoices.woid OR invoices.woid LIKE CONCAT('%\_',pc_wo.woid,'\_%'))) 
UNION (SELECT invoices.invoice_id,invoices.invname,invoices.invstatus,invoices.invemail,invoices.woid,invoices.receipt_id,invoices.invdate,invoices.invcompany,invoices.pcgroupid,invoices.invphone,invoices.invaddy1,invoices.invaddy2,invoices.invcity,invoices.invstate,invoices.invzip 
FROM invoices,rinvoices WHERE  invoices.invstatus = 1 AND invoices.rinvoice_id = rinvoices.rinvoice_id AND rinvoices.pcgroupid = '$portalgroupid' AND invoices.iorq != 'quote') 
UNION (SELECT invoices.invoice_id,invoices.invname,invoices.invstatus,invoices.invemail,invoices.woid,invoices.receipt_id,invoices.invdate,invoices.invcompany,invoices.pcgroupid,invoices.invphone,invoices.invaddy1,invoices.invaddy2,invoices.invcity,invoices.invstate,invoices.invzip
FROM invoices WHERE  invoices.invstatus = 1 AND invoices.pcgroupid = '$portalgroupid' AND invoices.iorq != 'quote')
UNION (SELECT invoices.invoice_id,invoices.invname,invoices.invstatus,invoices.invemail,invoices.woid,invoices.receipt_id,invoices.invdate,invoices.invcompany,invoices.pcgroupid,invoices.invphone,invoices.invaddy1,invoices.invaddy2,invoices.invcity,invoices.invstate,invoices.invzip
FROM invoices,blockcontracthours,blockcontract WHERE  invoices.invstatus = 1 AND blockcontracthours.invoiceid = invoices.invoice_id AND blockcontract.pcgroupid = '$portalgroupid' AND blockcontract.blockid = blockcontracthours.blockcontractid AND invoices.iorq != 'quote')
ORDER BY invdate DESC";

$rs_find_invoices = @mysqli_query($rs_connect, $rs_invoices);
while($rs_find_invoices_q = mysqli_fetch_object($rs_find_invoices)) {
$invoice_id = "$rs_find_invoices_q->invoice_id";
$invname = "$rs_find_invoices_q->invname";
$invcompany = "$rs_find_invoices_q->invcompany";
$invstatus = "$rs_find_invoices_q->invstatus";
$invemail = "$rs_find_invoices_q->invemail";
$invphone = "$rs_find_invoices_q->invphone";
$invaddy1 = "$rs_find_invoices_q->invaddy1";
$invaddy2 = "$rs_find_invoices_q->invaddy2";
$invcity = "$rs_find_invoices_q->invcity";
$invstate = "$rs_find_invoices_q->invstate";
$invzip = "$rs_find_invoices_q->invzip";
$invwoid = "$rs_find_invoices_q->woid";
$invpcgroupid = "$rs_find_invoices_q->pcgroupid";
$invrec = "$rs_find_invoices_q->receipt_id";
$invdate = "$rs_find_invoices_q->invdate";
$invdate2 = date("F j, Y", strtotime($invdate));
$findinvtotal = "SELECT SUM(cart_price) AS invsubtotal, SUM(itemtax) AS invtax FROM invoice_items WHERE invoice_id = '$invoice_id'";
$findinvq = @mysqli_query($rs_connect, $findinvtotal);
$findinva = mysqli_fetch_object($findinvq);
$invtax = "$findinva->invtax";
$invsubtotal = "$findinva->invsubtotal";
$invtotal2 = $invtax + $invsubtotal;
$invtotal = number_format($invtotal2, 2, '.', '');


$invname_ue = urlencode($invname);
$invcompany_ue = urlencode($invcompany);
$invemail_ue = urlencode($invemail);
$invphone_ue = urlencode($invphone);
$invaddy1_ue = urlencode($invaddy1);
$invaddy2_ue = urlencode($invaddy2);
$invcity_ue = urlencode($invcity);
$invstate_ue = urlencode($invstate);
$invzip_ue = urlencode($invzip);

echo "<tr><td>$invoice_id</td><td class=\"visible-lg\"><span class=boldme>$invname</span>";
if ("$invcompany" != "") {
echo "<br>$invcompany";
}

$finddeposits = "SELECT SUM(amount) AS totaldep FROM deposits WHERE invoiceid = '$invoice_id'";
$finddepositsq = @mysqli_query($rs_connect, $finddeposits);
$finddepositsa = mysqli_fetch_object($finddepositsq);
$totaldep = "$finddepositsa->totaldep";
$balance = $invtotal - $totaldep;


echo "</td><td>$invdate2</td><td>$money$invtotal";
if(($totaldep != 0) && ($balance != 0)) {
echo "<br>".pcrtlang("Balance").": $money".mf("$balance");
}

echo "</td>";
echo "<td><a href=invoice.php?func=printinv&invoice_id=$invoice_id><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Print")."</a>";



if($paymentplugin != "") {
if($totaldep == 0) {
$invtotal = urlencode("$invtotal");
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=$paymentplugin".".php?func=add&invoiceid=$invoice_id&invtotal=$invtotal&amounttopay=$invtotal&invtax=$invtax>
<i class=\"fa fa-credit-card fa-lg\"></i> ".pcrtlang("Pay Invoice")."</a>";
} else {
if($balance > 0) {
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=$paymentplugin".".php?func=add&invoiceid=$invoice_id&invtotal=$invtotal&amounttopay=$balance&invtax=$invtax>
<i class=\"fa fa-credit-card fa-lg\"></i> ".pcrtlang("Pay Invoice Balance")."</a>";
}
}
}


echo "</td></tr>";
}
echo "</tbody>";
echo "</table>";

################################




echo "<h3>".pcrtlang("Forms & Contracts")."</h3>";
#wip
$rs_dsql = "(SELECT DISTINCT(documents.documentid) AS documentid, documents.documentname AS documentname, documents.thesig AS thesig, documents.thesigtopaz AS thesigtopaz, documents.showinportal AS showinportal FROM documents,pc_owner,pc_group
WHERE pc_owner.pcgroupid = '$portalgroupid' AND pc_owner.pcid = documents.pcid  AND documents.showinportal = '1'
) UNION (
SELECT documents.documentid AS documentid, documents.documentname AS documentname, documents.thesig AS thesig, documents.thesigtopaz AS thesigtopaz, documents.showinportal AS showinportal FROM documents
WHERE documents.groupid = '$portalgroupid'
) UNION (
SELECT DISTINCT(documents.documentid) AS documentid, documents.documentname AS documentname, documents.thesig AS thesig, documents.thesigtopaz AS thesigtopaz,
documents.showinportal AS showinportal FROM documents,servicecontracts,pc_group
WHERE pc_group.pcgroupid = '$portalgroupid' AND pc_group.pcgroupid = servicecontracts.groupid AND documents.scid = servicecontracts.scid  AND documents.showinportal = '1'
)
ORDER BY documentname ASC";


$rs_result1dsql = mysqli_query($rs_connect, $rs_dsql);
$total_documents = mysqli_num_rows($rs_result1dsql);

echo "<table id=formstable class=\"table table-striped\">";

echo "<thead><tr><th><strong>".pcrtlang("Contract Name")."&nbsp;&nbsp;</strong></th><th>".pcrtlang("Actions")."</th></tr></thead><tbody>";

if ($total_documents > 0) {

while($rs_result_dsql1 = mysqli_fetch_object($rs_result1dsql)) {
$documentid = "$rs_result_dsql1->documentid";
$documentname = "$rs_result_dsql1->documentname";
$documentthesig = "$rs_result_dsql1->thesig";
$documentthesigtopaz = "$rs_result_dsql1->thesigtopaz";
$documentshowinportal = "$rs_result_dsql1->showinportal";


if(($documentthesig != "") || ($documentthesigtopaz != "")) {
$signatureexists = "yes";
} else {
$signatureexists = "no";
}


echo "<tr><td>$documentname ";

if($signatureexists == "yes") {
echo "<i class=\"fa fa-signature fa-lg\"></i>";
}

echo "</td><td>";

if($signatureexists == "yes") {
echo "<a href=\"documents.php?func=printform&documentid=$documentid\" class=\"linkbuttonsmall linkbuttongray radiusright\">
<i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("print")."</a>";
} else {
echo "<a href=\"documents.php?func=printform&documentid=$documentid\" class=\"linkbuttonsmall linkbuttongray radiusright\">
<i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("sign & print")."</a>";
}

echo "</td></tr>";


}

}


echo "</tbody></table>";


###################################





echo "<h3>".pcrtlang("Open Work Orders")."</h3>";

#echo "<div class=\"table-responsive\">";
echo "<table id=workordertable class=\"table table-striped\">";

echo "<thead><tr><th><strong>".pcrtlang("Status")."&nbsp;&nbsp;</strong></th><th>".pcrtlang("Name")."&nbsp;&nbsp;</th><th>Date&nbsp;&nbsp;</th>";
echo "<th> ".pcrtlang("Make")." &nbsp;&nbsp;</th><th>".pcrtlang("Problem/Task")."</th><th>".pcrtlang("Actions")."</th></tr></thead><tbody>";

$rs_wo = "SELECT pc_wo.woid,pc_wo.probdesc,pc_wo.dropdate,pc_wo.pcid,pc_wo.pcstatus FROM pc_wo, pc_owner WHERE pc_owner.pcgroupid = '$portalgroupid' AND pc_owner.pcid = pc_wo.pcid ORDER BY pc_wo.dropdate DESC";


$rs_find_wo = @mysqli_query($rs_connect, $rs_wo);
while($rs_find_wo_q = mysqli_fetch_object($rs_find_wo)) {
$woid = "$rs_find_wo_q->woid";
$probdesc = "$rs_find_wo_q->probdesc";
$dropdate = "$rs_find_wo_q->dropdate";
$pcid = "$rs_find_wo_q->pcid";
$dropdate2 = date("F j, Y", strtotime($dropdate));
$pcstatus = "$rs_find_wo_q->pcstatus";

$findcompname = "SELECT * FROM pc_owner WHERE pcid = '$pcid'";
$findcompq = @mysqli_query($rs_connect, $findcompname);
$findcompa = mysqli_fetch_object($findcompq);
$compname = "$findcompa->pcname";
$compcompany = "$findcompa->pccompany";
$compmake = "$findcompa->pcmake";

if(($pcstatus != '5') && ($pcstatus != '7')) {

$boxstyles = getboxstyle("$pcstatus");

$thestatus = "<i class=\"fa fa-bookmark fa-lg\" style=\"color:#$boxstyles[selectorcolor]\"></i> $boxstyles[boxtitle]";


echo "<tr><td>$thestatus</td><td>$compname</td><td>$dropdate2</td><td>$compmake";
if("$compcompany" != "") {
echo "<br>$compcompany";
}
echo "</td><td style=\"width:30%\">$probdesc</td><td><a href=wo.php?func=printrepairreport&woid=$woid><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Repair Report")."</a></td></tr>";
}

}


echo "</tbody></table>";

#echo "</div>";




require("footer.php");

?>

<script>
$(document).ready(function () {
    $('#invoicetable').resTables();
});

$(document).ready(function () {
    $('#workordertable').resTables();
});



</script>

