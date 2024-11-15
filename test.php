<?php 

include './connect.php';
require 'C:/xampp/phpMyAdmin/vendor/autoload.php';
use Firebase\JWT\JWT;


$jsonInfo = json_decode(file_get_contents("C:\Users\lions\Desktop\service-account.json"), true);
$privateKey = $jsonInfo['private_key'];


$nowInSeconds = time();
$payload = [
    'iss' => $jsonInfo['client_email'],
    'sub' => $jsonInfo['client_email'],
    'aud' => 'https://identitytoolkit.googleapis.com/google.identity.identitytoolkit.v1.IdentityToolkit',
    'iat' => $nowInSeconds,
    'exp' => $nowInSeconds + 3600, // Set expiration time (1 hour)
];

// $accessToken = jwt::encode($payload, $privateKey, 'RS256');

sendGCM('hey','alers comen','users','sdsd','nno');

