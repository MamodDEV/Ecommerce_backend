<?php

define("MB", 1048576);
function filterRequest($requestname)
{   
  return  htmlspecialchars(strip_tags($_POST[$requestname]));
}

    function getAllData($table, $where = null, $values = null,$json = true)
    {
        global $con;
        $data = array();

        if ($where == null ){
            $stmt = $con->prepare("SELECT  * FROM $table ");

        }else{
        $stmt = $con->prepare("SELECT  * FROM $table WHERE   $where ");
        }

        $stmt->execute($values);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $count  = $stmt->rowCount();
        if($json == true){

            if ($count > 0){
                echo json_encode(array("status" => "success", "data" => $data));
            } else {
                echo json_encode(array("status" => "failure"));
            }
            return $count;
        }else{
            if($count >0 ){
                return array("status" => "success", "data" => $data);
            }else{
                return array("status" => "failure");
            }
        }
}

function getData($table, $where = null, $values = null,$json = true)
{
    global $con;
    $data = array();
    $stmt = $con->prepare("SELECT * FROM $table WHERE $where");
    $stmt->execute($values);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $count  = $stmt->rowCount();
    if($json == true){

    if ($count > 0){
        echo json_encode(array("status" => "success", "data" => $data));
    } else {
        echo json_encode(array("status" => "failure"));
    }
}else{
    return $count;

    }
}
function insertData($table, $data, $json = true)
{
    global $con;
    foreach ($data as $field => $v)
        $ins[] = ":" . $field;
    $ins = implode(',', $ins);
    $fields = implode(',', array_keys($data));
    $sql = "INSERT INTO $table ($fields) VALUES ($ins)";

    $stmt = $con->prepare($sql);
    foreach ($data as $f => $v) {
        $stmt->bindValue(":" . $f, $v);
    }
    $stmt->execute();
    $count = $stmt->rowCount();

    if ($json == true) {
    if ($count > 0) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "failure"));
    }
  }
    return $count;
}


function updateData($table, $data, $where, $json = true)
{
    global $con;
    $cols = array();
    $vals = array();

    foreach ($data as $key => $val) {
        $vals[] = "$val";
        $cols[] = "`$key` =  ? ";
    }
    $sql = "UPDATE $table SET " . implode(', ', $cols) . " WHERE $where";

    $stmt = $con->prepare($sql);
    $stmt->execute($vals);
    $count = $stmt->rowCount();
    if ($json == true) {
    if ($count > 0) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "failure"));
    }
    }
    return $count;
}

function deleteData($table, $where, $json = true)
{
    global $con;
    $stmt = $con->prepare("DELETE FROM $table WHERE $where");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($json == true) {
        if ($count > 0) {
            echo json_encode(array("status" => "success"));
        } else {
            echo json_encode(array("status" => "failure"));
        }
    }
    return $count;
}

function imageUpload($dir ,$imageRequest)
{
    if(isset($_FILES[$imageRequest])){
        global $msgError;
        $imagename  = rand(1000, 10000) . $_FILES[$imageRequest]['name'];
        $imagetmp   = $_FILES[$imageRequest]['tmp_name'];
        $imagesize  = $_FILES[$imageRequest]['size'];
        $allowExt   = array("jpg", "png", "gif", "mp3", "pdf","svg");
        $strToArray = explode(".", $imagename);
        $ext        = end($strToArray);
        $ext        = strtolower($ext);
      
        if (!empty($imagename) && !in_array($ext, $allowExt)) {
          $msgError = "EXT";
        }
        if ($imagesize > 2 * MB) {
          $msgError = "size";
        }
        if (empty($msgError)) {
          move_uploaded_file($imagetmp,  $dir . $imagename);
          return $imagename;
        } else {
          return "fail";
        }
    }else{
        return 'empty';
    }

}



function deleteFile($dir, $imagename)
{
    if (file_exists($dir . "/" . $imagename)) {
        unlink($dir . "/" . $imagename);
    }
}

function checkAuthenticate()
{
    if (isset($_SERVER['PHP_AUTH_USER'])  && isset($_SERVER['PHP_AUTH_PW'])) {
        if ($_SERVER['PHP_AUTH_USER'] != "wael" ||  $_SERVER['PHP_AUTH_PW'] != "wael12345") {
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Page Not Found';
            exit;
        }
    } else {
        exit;
    }

    // End 

}
function sendGCM($title, $message, $topic, $storyid,$storyname)
{


$serverKey = 'ya29.a0AXooCgvUTj-oyVv9M-kDZaV4VEzTf1xXxAleElANW6hLr1P_caHwb18H6PgbIzkGffN6FRCipDnYbIky-0wV8FJxHHqdKMNEFF6VgqamWI3FvF5gU8ZVumJ2RgLIm1mPYsc4BSVydYJy3NaGsLebSUTpJvbaiVgrTW_zaCgYKAaYSARASFQHGX2MiFNTH-SAxbcLRS-wHZAfUqA0171'; // Replace with your actual server key
// $topic = 'users'; // Replace with the desired topic name

$data = [
    'message' => [
        'topic' => $topic,
        'notification' => [
            'title' => $title,
            'body' => $message,
        ],
        'data'=>[
            'story_id'=>$storyid,
            'story_name'=>$storyname,
        ]
    ],
];

$headers = [
    'Authorization: Bearer ' . $serverKey,
    'Content-Type: application/json',
];

$url = 'https://fcm.googleapis.com/v1/projects/ecommerce-9e9aa/messages:send'; // Replace with your project ID

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$result = curl_exec($ch);
curl_close($ch);

echo $result;



    // $url = 'https://fcm.googleapis.com/v1/project/ecommerce-9e9aa/messages:send';

    // $fields = array(
    //     "message" => array(
    //         "topics"=>$topic,
    //         "notification"=>array(
    //             "title"=>$title,
    //             "body"=>$message
    //         ),
    //         "data"=>array(
    //             "story_id"=>$pageid
    //         )
    //     )



    //     // "to" => '/topics/' . $topic,
    //     // 'priority' => 'high',
    //     // 'content_available' => true,

    //     // 'notification' => array(
    //     //     "body" =>  $message,
    //     //     "title" =>  $title,
    //     //     "click_action" => "FLUTTER_NOTIFICATION_CLICK",
    //     //     "sound" => "default"

    //     // ),
    //     // 'data' => array(
    //     //     "pageid" => $pageid,
    //     //     "pagename" => $pagename
    //     // )

    // );


    // $fields = json_encode($fields);
    // $headers = array(
    //     'Content-Type: application/json',
    //     'Authorization: Bearer=' . "ya29.a0AXooCguJUtQDwnRYVqwvD3Ge38q4kd1Z9VlXtIiVIqrFvQ_CbwJBycQF8z6J7QWHLNzGcBjPxlEmYE1gv83-dAwsUDkXefUBkWzR_rVZ_OtY3_say2PoF54iUZsV0QCAjbP7dvfO5ihnsoreEe_rK6iDzHJdwveDqo02aCgYKAUESARASFQHGX2MiEG2RwBV_G5f7eKAtSA36SA0171"

    // );

    // $ch = curl_init();
    // curl_setopt($ch, CURLOPT_URL, $url);
    // curl_setopt($ch, CURLOPT_POST, true);
    // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

    // $result = curl_exec($ch);
    // return $result;
    // curl_close($ch);
}


function result($count){
    if ($count > 0) {printSuccess();}
    else{printFailure();}
}

function printFailure($message = "none"){
    echo json_encode(array("status"=> "failure",'message'=>$message));

}
function printSuccess($message = "none"){
    echo json_encode(array("status"=> "success",'message'=>$message));

}
function sendEmail($to,$title,$body){
    $header = "From: Support@mamod.com" . "\n" . "CC: kamelkaher@gmail.com";
    mail($to,$title,$body,$header);
}


function insertNotify($title,$body,$userid,$topic,$storyid,$storyname){

    global $con;
    // sendGCM($title,$body,$topic,$storyid,$storyname);
    $stmt = $con->prepare("INSERT INTO `notification`(`notification_title`, `notification_body`, `notification_userid`) VALUES (? , ? , ?) ");
   
     $stmt->execute(array($title,$body,$userid));
     $count = $stmt->rowCount();
     echo $count;

}