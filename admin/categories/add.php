<?php


include "../../connect.php";

$stmt= $con->prepare('SET foreign_key_checks = 0');
$stmt->execute();
$name = filterRequest('name');

$namear = filterRequest('namear');

$img = imageUpload("../../upload/categories/",'files');


$data = array(
    "categories_name" => $name,
    "categories_name_ar" =>$namear,
    "categories_image" => $img
);

insertData("categories",$data);
$stmt= $con->prepare('SET foreign_key_checks = 1');
$stmt->execute();