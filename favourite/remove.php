<?php

include "../connect.php";
 

$userid = filterRequest('userid');
$itemid = filterRequest('itemid');




    // sendEmail($email,"Your Verify Code","Verify Code is '$verifycode'");
    deleteData('favourite',"favourite_usersid = $userid AND favourite_itemsid =$itemid" );
