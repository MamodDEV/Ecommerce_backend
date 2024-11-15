<?php

include "../connect.php";
 

$usersid = filterRequest('userid');
$itemsid = filterRequest('itemid');

$count = getData('cart',"cart_usersid = $usersid AND cart_itemsid =$itemsid AND cart_orders = 0",null,false);


$data = array(
    "cart_usersid"=>$usersid,
    "cart_itemsid"=>$itemsid,
) ;

insertData('cart',$data);