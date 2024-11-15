<?php 
include("../connect.php");

$email = filterRequest('email');

$verifycode = filterRequest('verifycode');


$stmt = $con->prepare("SELECT * FROM users Where users_email = '$email' AND users_verifycode = '$verifycode' ");
$stmt ->execute();

$count = $stmt->rowCount();


result($count);


?>