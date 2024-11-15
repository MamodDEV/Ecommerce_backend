<?php


include "../connect.php";

$id = filterRequest("id");

getAllData('ordersview',"orders_userid = $id ");