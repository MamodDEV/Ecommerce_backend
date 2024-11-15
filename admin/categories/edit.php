<?php

include "../../connect.php";

$id = filterRequest('id');

$name = filterRequest('name');

$namear = filterRequest('namear');

$imgold = filterRequest('imgold');

$res = imageUpload("../../upload/categories/",'files');

if($res == 'empty'){
    $data = [
        "categories_name" => $name,
        "categories_name_ar" =>$namear,
    ];
}else{
    deleteFile("../../upload/categories/",$imgold);
    $data = [
        "categories_name" => $name,
        "categories_name_ar" =>$namear,
        "categories_image" => $res
    ];
}

updateData("categories",$data,"categories_id = $id");
