SELECT OR REPLACE items1view.* , 1 as favourite FROM `items1view`
INNER JOIN favourite ON favourite.favourite_itemsid = items1view.items_id AND favourite.favourite_usersid = 43
UNION ALL 
SELECT items1view.* , 0 as favourite  FROM items1view 
WHERE items_id !=(SELECT items1view.items_id FROM `items1view`
 INNER JOIN favourite ON favourite.favourite_itemsid = items1view.items_id AND favourite.favourite_usersid = 43)
;


CREATE OR REPLACE VIEW myfavourite AS
SELECT favourite.* , items.* , users.users_id FROM favourite 
INNER JOIN items ON favourite.favourite_itemsid = items.items_id
INNER JOIN users ON favourite.favourite_usersid = users.users_id;


SELECT items1view.* , 1 as favourite ,(items_price - ((items_price * items_discount) / 100 )) as itemspricediscount FROM `items1view`
INNER JOIN favourite
ON favourite.favourite_itemsid = items1view.items_id AND favourite.favourite_usersid = $userid
WHERE items_cat = $categoryid
UNION ALL 
SELECT items1view.* , 0 as favourite ,(items_price - ((items_price * items_discount) / 100 )) as itemspricediscount FROM items1view 
WHERE items_cat	 = $categoryid AND items_id NOT IN (SELECT items1view.items_id FROM `items1view`
INNER JOIN favourite ON favourite.favourite_itemsid = items1view.items_id AND favourite.favourite_usersid = $userid)

CREATE OR Replace VIEW cartview AS
SELECT items.* , cart.* , sum(items.items_price - items.items_price * items_discount/100) as itemsprice , COUNT(items.items_id) AS countitems FROM items 
INNER JOIN cart ON cart.cart_itemsid = items.items_id
WHERE cart_orders = 0
 GROUP BY cart.cart_itemsid , cart.cart_usersid

CREATE OR Replace VIEW ordersview AS
Select orders.* , address.* FROM orders
LEFT JOIN address ON address.address_id = orders.orders_address

CREATE OR Replace VIEW orderdetailsview AS
SELECT ordersview.*, items.* , cart.* , sum(items.items_price - items.items_price * items_discount/100) as itemsprice , COUNT(items.items_id) AS countitems FROM items 
INNER JOIN cart ON cart.cart_itemsid = items.items_id
INNER JOIN ordersview ON ordersview.orders_id = cart.cart_orders
WHERE cart_orders != 0
 GROUP BY cart.cart_itemsid , cart.cart_usersid , cart.cart_orders

CREATE OR REPLACE VIEW itemstopselling AS
SELECT COUNT(cart_id) as countitems ,cart.* , items.* FROM cart 
INNER JOIN items ON items.items_id = cart.cart_itemsid 
WHERE cart_orders !=0
GROUP BY cart_itemsid ;