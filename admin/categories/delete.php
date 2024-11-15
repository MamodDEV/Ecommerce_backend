<?php


include "../../connect.php";


$id = filterRequest("id");

$img = filterRequest("img");

deleteFile("../../upload/categories/",$img);

deleteData("categories","categories_id = $id");