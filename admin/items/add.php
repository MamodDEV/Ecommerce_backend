<?php


include "../../connect.php";

$stmt= $con->prepare('SET foreign_key_checks = 0');
$stmt->execute();

$table= 'items';
$name = filterRequest('name');

$namear = filterRequest('namear');
$desc = filterRequest('desc');
$descar = filterRequest('descar');
$count = filterRequest('count');
$price = filterRequest('price');
$discount = filterRequest('discount');
$catid = filterRequest('catid');
$time = filterRequest('time');

$img = imageUpload("../../upload/items/",'files');


$data = array(
    "items_name" => $name,
    "items_name_ar" =>$namear,
    "items_desc" => $desc,
    "items_desc_ar" => $descar,
    "items_image" => $img,
    "items_count" => $count,
    "items_active" => "1",
    "items_price" => $price,
    "items_discount" => $discount,
    "items_data" => $time,
    "items_cat" => $catid
);

insertData($table,$data);
$stmt= $con->prepare('SET foreign_key_checks = 1');
$stmt->execute();