s<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Users.php';

$database = new Database();
$db = $database->connect();

$users = new Users($db);

$method = $_SERVER['REQUEST_METHOD'];
if($method != 'DELETE'){
  echo json_encode(
    array('message' => "Users Not DELETED")
  );
}else{
  $users->idusers = $_GET['id'];
  $users->foto = $_GET['foto'];

 if($users->delete()){
   echo json_encode(
     array('message' => 'User DELETED')
   );
 }else{
  echo json_encode(
    array('message' => 'User Not DELETED')
  );
 }

}