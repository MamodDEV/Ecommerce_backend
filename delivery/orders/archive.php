<?php


include "../../connect.php";

$id = filterRequest('deliveryid');

getAllData('ordersview',"orders_status = 4  AND orders_delivery = $id ");