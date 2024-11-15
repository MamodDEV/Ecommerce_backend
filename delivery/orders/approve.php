<?php

include '../../connect.php';

$orderid = filterRequest('orderid');
$userid = filterRequest('userid');
$deliveryid =filterRequest('deliveryid');
$data = array(
    "orders_status" => 3,
    "orders_delivery" => $deliveryid
);
updateData('orders',$data,"orders_id = $orderid AND orders_status = 2");

// insertNotify("Order Approved","Your Order in on the way !",$userid,"users$userid",'22','refreshorder');

// sendGCM('alert',"order has been approved by delivery $deliveryid","services",'none','none');
// sendGCM('alert',"order has been approved by deliver " . $deliveryid,"delivery",'none','none');