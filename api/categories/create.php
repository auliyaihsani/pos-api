<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Categories.php';

$database = new Database();
$db = $database->connect();

$categories = new Categories($db);

$method = $_SERVER['REQUEST_METHOD'];
if($method != 'POST'){
  echo json_encode(
    array('message' => "Categories Not Created")
  );
}else{
  $url = file_get_contents("php://input");

  parse_str($url, $data);

  $categories->nama = $data['nama'];
  $categories->deskripsi = $data['deskripsi'];
  $categories->created_at = date('Y-m-d');

 if($categories->create()){
   echo json_encode(
     array('message' => 'Category Created')
   );
 }else{
  echo json_encode(
    array('message' => 'Category Not Created')
  );
 }

}