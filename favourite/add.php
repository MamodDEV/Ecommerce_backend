<?php

include "../connect.php";
 

$userid = filterRequest('userid');
$itemsid = filterRequest('itemid');



$data =array(
    'favourite_itemsid'=>$itemsid,
    'favourite_usersid'=>$userid,
    );
    // sendEmail($email,"Your Verify Code","Verify Code is '$verifycode'");
    insertData('favourite',$data);
