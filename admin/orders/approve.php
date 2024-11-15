<?php

include '../../connect.php';

$orderid = filterRequest('orderid');
$userid = filterRequest('userid');

$data = array(
    "orders_status" => 1
);
updateData('orders',$data,"orders_id = $orderid AND orders_status = 0");

// sendGCM('Order Approved',"Your Order has been approved !","users$userid","22",'refreshorder');
insertNotify("Order Approved","Your Order has been approved !",$userid,"users$userid",'22','refreshorder');