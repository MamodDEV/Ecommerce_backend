<?php


include "../connect.php";

$id = filterRequest('id');

getAllData('myfavourite','favourite_usersid = ?',array($id));