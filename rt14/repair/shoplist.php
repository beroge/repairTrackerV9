<?php
                                                                                                    
                                                                                                    
function nothing() {
require_once("header.php");


require_once("footer.php");
                                                                                                    
}

function add_item($itemdesc,$status) {

require("deps.php");
require("common.php");





$rs_insert_cart = "INSERT INTO shoplist (itemdesc,itemstatus) VALUES  ('$itemdesc','$status')";
@mysqli_query($rs_connect, $rs_insert_cart);

header("Location: $domain/index.php");

}



function remove_item($item_id) {

require("deps.php");
require("common.php");





$rs_delete_cart = "DELETE FROM shoplist WHERE shopid = '$item_id'";
@mysqli_query($rs_connect, $rs_delete_cart);

header("Location: $domain/index.php");
}


function loadsavecart($pcwo) {

require("deps.php");
require("common.php");



$rs_find_cart_items = "SELECT * FROM repaircart WHERE pcwo = '$pcwo'";
$rs_result = mysqli_query($rs_connect, $rs_find_cart_items);

$rs_rm_cart = "DELETE FROM cart";
@mysqli_query($rs_connect, $rs_rm_cart);


while($rs_result_q = mysqli_fetch_object($rs_result)) {
$rs_cart_price = "$rs_result_q->cart_price";
$rs_cart_type = "$rs_result_q->cart_type";
$rs_cart_stock_id = "$rs_result_q->cart_stock_id";
$rs_labor_desc = "$rs_result_q->labor_desc";
$rs_return_sold_id = "$rs_result_q->return_sold_id";
$rs_restocking_fee = "$rs_result_q->restocking_fee";
$rs_price_alt = "$rs_result_q->price_alt";

$rs_insert_cart = "INSERT INTO cart (cart_price,cart_type,cart_stock_id,labor_desc,return_sold_id,restocking_fee,price_alt) VALUES  ('$rs_cart_price','$rs_cart_type','$rs_cart_stock_id','$rs_labor_desc','$rs_return_sold_id','$rs_restocking_fee','$rs_price_alt')";
@mysqli_query($rs_connect, $rs_insert_cart);

}
header("Location: /store/cart.php");
}




switch($func) {
                                                                                                    
    default:
    nothing();
    break;
                                
    case "add_item":
    add_item($itemdesc,$status);
    break;

                                   
    case "remove_item":
    remove_item($item_id);
    break;
                                 
    case "loadsavecart":
    loadsavecart($pcwo);
    break;

    case "add_scan":
    add_scan($woid,$scanprog,$thecount);
    break;

    case "rm_scan":
    rm_scan($woid,$scanid);
    break;

    case "checkout":
    checkout($woid);
    break;

    case "printit":
    printit($woid);
    break;

    case "view":
    view($woid);
    break;


    case "showpc":
    showpc($pcid);
    break;

    case "returnpc":
    returnpc();
    break;

    case "returnpc2":
    returnpc2($pcid);
    break;

    case "returnpc3":
    returnpc3($custname,$custphone,$pcmake,$prob_desc,$pcid);
    break;

    case "editowner":
    editowner($pcid,$woid);
    break;

    case "editowner2":
    editowner2($custname,$custphone,$pcmake,$pcid,$woid);
    break;

    case "editproblem":
    editproblem($woid,$custname);
    break;

    case "editproblem2":
    editproblem2($woid,$problem);
    break;

    case "movewo":
    movewo($woid,$pcid);
    break;

    case "movewo2":
    movewo2($woid,$npcid,$rmpcid,$pcid);
    break;


    case "stats":
    stats();
    break;
                                                                                                                             


}

?>
