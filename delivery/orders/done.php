<?php

include '../../connect.php';

$orderid = filterRequest('orderid');
$userid = filterRequest('userid');
$data = array(
    "orders_status" => 4
);
updateData('orders',$data,"orders_id = $orderid AND orders_status =3");

// sendGCM('Order Approved',"Your Order has been approved !","users$userid","22",'refreshorder');
// insertNotify("Order Approved","Your Order has been delivered !",$userid,"users$userid",'22','refreshorder');

// sendGCM('alert',"Order $orderid has been delivered to the customer!","services",'none','none');