<?php

include "../connect.php";
 

$favid = filterRequest('favid');



    // sendEmail($email,"Your Verify Code","Verify Code is '$verifycode'");
    deleteData('favourite',"favourite_id = $favid" );
