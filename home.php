<?php

include "./connect.php";

$alldata = [];
$categories = getAllData('categories',null,null,false);

$alldata['status'] = "success";

$alldata['categories'] = $categories;

$settings = getAllData('setting',null,null,false);

$alldata['settings'] = $settings;

$stmt = $con ->prepare(
    "SELECT topSellingView.*,(items_price - ((items_price * items_discount) / 100 )) as itemspricediscount FROM `topSellingView`
    ORDER BY countitem DESC
    ");
    $stmt ->execute();
    $count  = $stmt->rowCount();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($count > 0){
       $items= (array("status" => "success", "data" => $data));
        $alldata['items'] = $items;

echo json_encode($alldata);
    } else {
        echo json_encode(array("status" => "failure"));
    }
// $items = getAllData('items1view','items_discount != 0',null,false);

