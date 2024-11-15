<?php

include "../../connect.php";

$orderid = filterRequest('orderid');

$userid = filterRequest('userid');


$type = filterRequest('ordertype');

if($type == "0"){
    $data = array('orders_status'=>2);

}else{
    $data = array('orders_status'=>4);

}

updateData('orders',$data,"orders_id = $orderid AND orders_status = 1");

insertNotify('success',"The Order has been Approved ",$userid,"users$userid","none","none");
if($type == "0"){
    // sendGCM('alert','There is an order waiting for approval','delivery','none','none'); 
}
