<?php

include './connect.php';
$id = filterRequest('id');

getAllData('notification',"notification_userid = $id ORDER BY notification_id" );


