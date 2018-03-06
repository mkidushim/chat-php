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

$uname = 'mike';
if(isset($_REQUEST['username'])){
  $uname = $_REQUEST['username'];
}
$sql = "SELECT `id` FROM `patient` where `email`='$uname'";
$res = $m->query($sql);
$r = $res->fetch_assoc();
$uid = $r['id'];
$sql = "UPDATE `ft_appt` SET `online`='1' where `patient_id`='$uid'";
$m->query($sql);
$sql = "SELECT `hospital_id` FROM `ft_appt` where `patient_id`='$uid'";
$res = $m->query($sql);
$r = $res->fetch_assoc();
$hid = $r['hospital_id'];
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
// $client->connect(['query', 'userId=$uid']);
$client->emit('chat-list-php', ['hid'=>$hid,'userId'=>$uid,'connected'=>false]);
$client->close();

// $response['content'] = $server_output;
// echo json_encode($response);
?>