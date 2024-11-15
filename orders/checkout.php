<?php

include "../connect.php";

$userid = filterRequest('userid');
$addressid = filterRequest('addressid');
$type = filterRequest('type');
$pricedelivery = filterRequest('pricedelivery');
$price = filterRequest('price');
$couponid = filterRequest('coupon');
$discountcoupon = filterRequest('discountcoupon');
$paymentmethod = filterRequest('paymentmethod');
$totalprice = $price + $pricedelivery;

//delivery price

if($type == '1'){
    $pricedelivery = 0;
}


//check Coupon
$now = date('Y-m-d H:i:s');
$checkcoupon = getData('coupon', "coupon_id = '$couponid' AND coupon_count > 0 AND coupon_expiredate < '$now'",null,false);
if($checkcoupon  > 0){
    $totalprice = $totalprice - $price*$discountcoupon/100;
    $stmt = $con->prepare("UPDATE `coupon` SET `coupon_count` = `coupon_count` - 1 WHERE `coupon_id` = $couponid");
    $stmt->execute();
}
$data = array(
    "orders_userid" => $userid,
    "orders_address" => $addressid,
    "orders_type" => $type,
    "orders_pricedelivery" => $pricedelivery,
    "orders_price" => $price,
    "orders_totalprice" => $totalprice,
    "orders_coupon" => $couponid,     
    "orders_paymentmethod" => $paymentmethod,
);

$count = insertData('orders',$data,false);

if($count > 0){
    $stmt = $con->prepare("SELECT MAX(orders_id) FROM orders");
    $stmt ->execute();
    $maxid = $stmt->fetchColumn();
    $data = array("cart_orders"=>$maxid);
    updateData("cart",$data,"cart_usersid = $userid AND cart_orders = 0");
}