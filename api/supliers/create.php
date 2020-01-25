<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Supliers.php';

$database = new Database();
$db = $database->connect();

$supliers = new Supliers($db);

$method = $_SERVER['REQUEST_METHOD'];
if($method != 'POST'){
  echo json_encode(
    array('message' => "Supliers Not Created")
  );
}else{
  $url = file_get_contents("php://input");

  parse_str($url, $data);

  $supliers->nama = $data['nama'];
  $supliers->alamat = $data['alamat'];
  $supliers->tlp = $data['tlp'];
  $supliers->email = $data['email'];
  $supliers->created_at = date('Y-m-d');

 if($supliers->create()){
   echo json_encode(
     array('message' => 'Suplier Created')
   );
 }else{
  echo json_encode(
    array('message' => 'Suplier Not Created')
  );
 }

}