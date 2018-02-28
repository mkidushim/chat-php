<?php
header('Content-Type: application/json');
require_once 'socket.php';

$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = 'digital';
$dbName = 'chat';
$response = array(
  'status'=>'NO',
  'content'=>''
);
$m = new mysqli($dbHost,$dbUser,$dbPass,$dbName);
if($m->connect_errno){
  $response['content'] = 'Error connecting to the db.';
  echo json_encode($response);
  exit;
}
$msg = 'meow';
if(isset($_REQUEST['message'])){
  $msg = $_REQUEST['message'];
}
//patient on ios app
$patientId = '2';
//er or doctor at web browser
$doctorId = '1';
$sql = "INSERT INTO `message` (`from_user_id`,`to_user_id`,`message`) values ('$patientId','$doctorId','$msg')";
if(!$m->query($sql)){
  $response['content'] = 'Query error.';
  echo json_encode($response);
  exit;
}
//doctor socket id
$sql = "SELECT `socketid` FROM `user` where `id`='$doctorId'";
$res = $m->query($sql);
$did = $res->fetch_assoc()['socketid'];
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version1X;
require __DIR__ . '/vendor/autoload.php';
$client = new Client(new Version1X('http://localhost:3000'));
$client->initialize();
$client->emit('add-message-php', ['toSocketId'=>$did,'fromUserId' => $patientId,'toUserId' => $doctorId,'message'=>$msg]);
$client->close();

// $response['content'] = 'Success';
// echo json_encode($response);
?>