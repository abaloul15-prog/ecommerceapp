<?php

require_once __DIR__ . '/vendor/autoload.php';
use Firebase\JWT\JWT;

// ==========================================================
//  Copyright Reserved Wael Wael Abo Hamza (Course Ecommerce)
// ==========================================================

// date_default_timezone_set("Europe/Brussels");

define("MB", 1048576);

function filterRequest($requestname)
{
  return  htmlspecialchars(strip_tags($_POST[$requestname]));
}

function getAllData($table, $where = null, $values = null, $json = true)
{
    global $con;
    $data = array();
    if ($where == null) {
        $stmt = $con->prepare("SELECT  * FROM $table ");
    } else {
       $stmt = $con->prepare("SELECT  * FROM $table WHERE   $where ");
    }
    
    $stmt->execute($values);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count  = $stmt->rowCount();
    if ($json == true) {
        if ($count > 0){
        echo json_encode(array("status" => "success", "data" => $data));
    } else {
        echo json_encode(array("status" => "failure"));
    }
    return $count;
    } else {
        if ($count > 0) {
       return array("status" => "success", "data" => $data);
        } else {
return array("status" => "failure");
        }
        
    }
    
}

function getData($table, $where = null, $values = null , $json = true)
{
    global $con;
    $data = array();
    $stmt = $con->prepare("SELECT  * FROM $table WHERE   $where ");
    $stmt->execute($values);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $count  = $stmt->rowCount();
    if ($json == true) {
if ($count > 0){
        echo json_encode(array("status" => "success", "data" => $data));
    } else {
        echo json_encode(array("status" => "failure"));
    }
} else{ 
    return $count; 
}
}

function insertData($table, $data, $json = true)
{
    global $con;
    foreach ($data as $field => $v)
        $ins[] = ':' . $field;
    $ins = implode(',', $ins);
    $fields = implode(',', array_keys($data));
    $sql = "INSERT INTO $table ($fields) VALUES ($ins)";

    $stmt = $con->prepare($sql);
    foreach ($data as $f => $v) {
        $stmt->bindValue(':' . $f, $v);
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

function imageUpload($dir,$imageRequest)
{
 if (isset($_FILES[$imageRequest])) {
     global $msgError;
  $imagename  = rand(1000, 10000) . $_FILES[$imageRequest]['name'];
  $imagetmp   = $_FILES[$imageRequest]['tmp_name'];
  $imagesize  = $_FILES[$imageRequest]['size'];
  $allowExt   = array('mp3','MP3','pdf','PDF','png','jpg','jpeg','gif','bmp','webp','tiff','tif','avif','heic','heif','raw','cr2','cr3','nef','arw','dng','ico','psd','xcf','PNG','JPG','JPEG','GIF','BMP','WEBP','TIFF','TIF','AVIF','HEIC','HEIF','RAW','CR2','CR3','NEF','ARW','DNG','ICO','PSD','XCF','svg', 'SVG', 'ai', 'AI', 'eps', 'EPS');
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
    move_uploaded_file($imagetmp,  $dir . "/" . $imagename);
    return $imagename;
  } else {
    return "fail";
  }
 } else {
   return "empty";
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

function printFailure($message = "none"){
    echo json_encode(array("status" => "failure" , "message" => $message)); 
}

function printSuccess($message = "none"){
    echo json_encode(array("status" => "success" , "message" => $message)); 
}

function result($count){
    if ($count > 0) {
       printSuccess();
    } else {
        printFailure(); 
    }
}

function sendEmail($to , $title , $body){


$header = "From: contact@runkst.com\r\n";
mail($to , $title , $body , $header);


}


function sendGCM($title, $message, $topic, $pageid, $pagename)
{
    // $url = 'https://fcm.googleapis.com/fcm/send';

    // Load service account
    $saPath = __DIR__ . '/service-account.json';
    if (!file_exists($saPath)) {
        return json_encode(['error' => 'service-account.json not found']);
    }
    $serviceAccount = json_decode(file_get_contents($saPath), true);
    $projectId = $serviceAccount['project_id'] ?? null;
    if (!$projectId) {
        return json_encode(['error' => 'Invalid service-account.json']);
    }

    // Prepare OAuth2 token
    $now = time();
    $payload = [
        'iss' => $serviceAccount['client_email'],
        'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
        'aud' => 'https://oauth2.googleapis.com/token',
        'iat' => $now,
        'exp' => $now + 3600
    ];
    $jwt = JWT::encode($payload, $serviceAccount['private_key'], 'RS256');

    // Exchange JWT for access token
    $ch = curl_init('https://oauth2.googleapis.com/token');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
        'assertion'  => $jwt
    ]));
    $resp = curl_exec($ch);
    curl_close($ch);
    $tokenResp = json_decode($resp, true);
    if (empty($tokenResp['access_token'])) {
        return $resp; // return raw error if failed
    }
    $accessToken = $tokenResp['access_token'];

    // Prepare v1 API payload
    $topic = preg_replace('#^/topics/#', '', $topic); // remove legacy /topics/ if present

    // $fields = array(
    //     "to" => '/topics/' . $topic,
    //     'priority' => 'high',
    //     'content_available' => true,

    //     'notification' => array(
    //         "body" =>  $message,
    //         "title" =>  $title,
    //         "click_action" => "FLUTTER_NOTIFICATION_CLICK",
    //         "sound" => "default"

    //     ),
    //     'data' => array(
    //         "pageid" => $pageid,
    //         "pagename" => $pagename
    //     )

    // );


    // $fields = json_encode($fields);

$fields = [
    "message" => [
        "topic" => $topic,
        "notification" => [
            "title" => $title,
            "body"  => $message
        ],
        "data" => [
            "pageid"   => (string)$pageid,
            "pagename" => (string)$pagename
        ],
        "android" => [
            "notification" => [
                "sound" => "default",
                "click_action" => "FLUTTER_NOTIFICATION_CLICK"
            ],
            "priority" => "HIGH"
        ],
        "apns" => [
            "payload" => [
                "aps" => [
                    "sound" => "default",
                    "content-available" => 1
                ]
            ]
        ]
    ]
];
    $fields = json_encode($fields);

    // cURL to send notification
    $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";


    // $headers = array(
    //     'Authorization: key=' . "",
    //     'Content-Type: application/json'
    // );

    $headers = [
        'Authorization: Bearer ' . $accessToken,
        'Content-Type: application/json'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
   
}

function insertNotification($title, $body , $usersid, $topic, $pageid, $pagename){
    global $con;
    $stmt = $con->prepare("INSERT INTO `notification`(`notification_title`, `notification_body`, `notification_usersid`) VALUES ( ? , ? , ? )");
    $stmt->execute(array( $title, $body , $usersid ));
    sendGCM( $title, $body, $topic, $pageid, $pagename);
    $count = $stmt->rowCount();
    return $count;
 }