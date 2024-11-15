<?php 

include '../connect.php';
$usersid = filterRequest('userid');
$itemsid = filterRequest('itemid');

$stmt = $con->prepare("SELECT COUNT(cart.cart_id) as countitem FROM `cart` WHERE cart_usersid = $usersid AND cart.cart_itemsid = $itemsid AND cart_orders = 0 LIMIT 1 ");

$stmt->execute();

$data = $stmt->fetch(PDO::FETCH_ASSOC);

$count = $stmt->rowCount();

if($count > 0){
    echo json_encode(array('status' => 'success', "data" => $data));
}
else{
    echo json_encode(array('status' => 'success', 'data' => "0"));

}
