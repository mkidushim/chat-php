<?php
header('Content-Type: application/json');
require_once 'socket.php';

$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = 'Monster.';
$dbName = 'mtm';
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
$patientId = '43';
//er or doctor at web browser
$doctorId = '1';
$apptId = '3';
$sql = "INSERT INTO `ft_chat` (`patient_id`,`user_id`,`content`,`sender`,`appt_id`) values ('$patientId','$doctorId','$msg','patient','$apptId')";
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
$options = [
    'context' => [
      'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false
      ]
    ]
];
require __DIR__ . '/vendor/autoload.php';
$client = new Client(new Version1X('https://mike.fusionofideas.com:4000',$options));
$client->initialize();
$client->emit('add-message-php', ['socket'=>$did,'fromUserId' => $patientId,'toUserId' => $doctorId,'message'=>$msg,'sender'=>'patient']);
$client->close();

// $response['content'] = 'Success';
// echo json_encode($response);
?>