<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Users.php';

$database = new Database();
$db = $database->connect();

$users = new Users($db);

$method = $_SERVER['REQUEST_METHOD'];
if($method != 'GET'){
  echo json_encode(
    array('message' => "No Users Found")
  );
}else{
 $result = $users->read();

 $num = $result->rowCount();

 if($num >0){
  $user_arr = array();
  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $user_item = array(
      'idusers' => $idusers,
      'username' => $username,
      'password' => $password,
      'role' => $role,
      'foto' => $foto
    );

    array_push($user_arr, $user_item);
  }
  echo json_encode($user_arr);
 }else{
  echo json_encode(
    array('message' => "No Users Found")
  );
 }
}