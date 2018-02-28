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

$uname = 'dry';
if(isset($_REQUEST['username'])){
  $uname = $_REQUEST['username'];
}
$sql = "SELECT `id` FROM `user` where `username`='$uname'";
$res = $m->query($sql);
$uid = $res->fetch_assoc()['id'];
$sql = "UPDATE `user` SET `online`='N' where `id`='$uid'";
$m->query($sql);
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version1X;
require __DIR__ . '/vendor/autoload.php';
$client = new Client(new Version1X('http://localhost:3000'));
$client->initialize();
// $client->connect(['query', 'userId=$uid']);
$client->emit('chat-list-php', ['userId'=>$uid,'connected'=>false]);
$client->close();

// $response['content'] = $server_output;
// echo json_encode($response);
?>