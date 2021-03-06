<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Categories.php';

$database = new Database();
$db = $database->connect();

$categories = new Categories($db);

$method = $_SERVER['REQUEST_METHOD'];
if($method != 'PUT'){
  echo json_encode(
    array('message' => "Categories Not Updated")
  );
}else{
  $url = file_get_contents("php://input");

  parse_str($url, $data);
  $categories->idcategories = $data['idcategories'];

  $categories->nama = $data['nama'];
  $categories->deskripsi = $data['deskripsi'];
  $categories->created_at = date('Y-m-d');

 if($categories->update()){
   echo json_encode(
     array('message' => 'Category Updated')
   );
 }else{
  echo json_encode(
    array('message' => 'Category Not Updated')
  );
 }

}