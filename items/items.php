<?php

include "../connect.php";

$categoryid= filterRequest('id');
$userid= filterRequest('userid');
//  getAllData('items1view',"categories_id =$categoryid ");

$stmt = $con ->prepare(
"SELECT items1view.* , 1 as favourite ,(items_price - ((items_price * items_discount) / 100 )) as itemspricediscount FROM `items1view`
INNER JOIN favourite
ON favourite.favourite_itemsid = items1view.items_id AND favourite.favourite_usersid = $userid
WHERE items_cat = $categoryid
UNION ALL 
SELECT items1view.* , 0 as favourite ,(items_price - ((items_price * items_discount) / 100 )) as itemspricediscount FROM items1view 
WHERE items_cat	 = $categoryid AND items_id NOT IN (SELECT items1view.items_id FROM `items1view`
INNER JOIN favourite ON favourite.favourite_itemsid = items1view.items_id AND favourite.favourite_usersid = $userid)"
);
$stmt ->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
$count  = $stmt->rowCount();
if ($count > 0){
    echo json_encode(array("status" => "success", "data" => $data));
} else {
    echo json_encode(array("status" => "failure"));
}
