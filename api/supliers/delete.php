<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Supliers.php';

$database = new Database();
$db = $database->connect();

$supliers = new Supliers($db);

$method = $_SERVER['REQUEST_METHOD'];
if($method != 'DELETE'){
  echo json_encode(
    array('message' => "Supliers Not DELETED")
  );
}else{
  $url = file_get_contents("php://input");

  parse_str($url, $data);

  $supliers->idsupliers = $_GET['id'];

 if($supliers->delete()){
   echo json_encode(
     array('message' => 'Suplier DELETED')
   );
 }else{
  echo json_encode(
    array('message' => 'Suplier Not DELETED')
  );
 }

}