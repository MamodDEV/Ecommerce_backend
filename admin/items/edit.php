<?php

include "../../connect.php";

$id = filterRequest('id');



$name = filterRequest('name');

$namear = filterRequest('namear');
$desc = filterRequest('desc');
$descar = filterRequest('descar');
$count = filterRequest('count');
$active = filterRequest('active');
$price = filterRequest('price');
$discount = filterRequest('discount');
$catid = filterRequest('catid');
$time = filterRequest('time');

$imgold = filterRequest('imgold');

$res = imageUpload("../../upload/items/",'files');

if($res == 'empty'){
    $data = [
        "items_name" => $name,
        "items_name_ar" =>$namear,
        "items_desc" => $desc,
        "items_desc_ar" => $descar,
        "items_count" => $count,
        "items_active" => $active,
        "items_price" => $price,
        "items_discount" => $discount,
        "items_cat" => $catid,
        "items_data" => $time
    ];
}else{
    deleteFile("../../upload/items/",$imgold);
    $data = [
        "items_name" => $name,
        "items_name_ar" =>$namear,
        "items_desc" => $desc,
        "items_desc_ar" => $descar,
        "items_count" => $count,
        "items_active" => $active,
        "items_price" => $price,
        "items_discount" => $discount,
        "items_cat" => $catid,
        "items_image" => $res,
        "items_data" => $time
    ];
}

updateData("items",$data,"items_id = $id");
