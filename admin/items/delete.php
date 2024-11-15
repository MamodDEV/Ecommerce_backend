<?php


include "../../connect.php";

$stmt= $con->prepare('SET foreign_key_checks = 0');
$stmt->execute();

$id = filterRequest("id");

$img = filterRequest("img");

deleteFile("../../upload/items/",$img);

deleteData("items","items_id = $id");
$stmt= $con->prepare('SET foreign_key_checks = 1');
$stmt->execute();