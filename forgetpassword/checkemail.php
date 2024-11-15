<?php 
include("../connect.php");

$email = filterRequest('email');
$verifycode = rand(10000, 99999);



$stmt = $con->prepare("SELECT * FROM users Where users_email = ?");
$stmt ->execute(array($email));

$count = $stmt->rowCount();

result($count);

if($count > 0){
    // sendEmail($email,"Your Verify Code","Verify Code is '$verifycode'");
    $data =array(
        'users_verifycode'=>$verifycode,
    );
    updateData('users',$data,"users_email = '$email'",false);
}
?>