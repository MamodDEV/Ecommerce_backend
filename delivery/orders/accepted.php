<?php


include "../../connect.php";

$id = filterRequest('deliveryid');
getAllData('ordersview'," (orders_delivery = $id AND orders_status = 3) ");