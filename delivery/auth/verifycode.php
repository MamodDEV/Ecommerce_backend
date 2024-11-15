<?php 
include("../../connect.php");

$email = filterRequest('email');

$verifycode = filterRequest('verifycode');


$stmt = $con->prepare("SELECT * FROM delivery Where delivery_email = '$email' AND delivery_verifycode = '$verifycode' ");
$stmt ->execute();

$count = $stmt->rowCount();

if($count > 0){
    $data = array(
        "delivery_approve" => "1"
    );
    updateData('delivery',$data,"delivery_email = '$email'");
}
else {
    printFailure("Verify Code Not Correct ");
}


?>