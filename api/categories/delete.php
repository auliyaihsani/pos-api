<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Categories.php';

$database = new Database();
$db = $database->connect();

$categories = new Categories($db);

$method = $_SERVER['REQUEST_METHOD'];
if($method != 'DELETE'){
  echo json_encode(
    array('message' => "Categories Not DELETED")
  );
}else{
  $url = file_get_contents("php://input");

  parse_str($url, $data);

  $categories->idcategories = $_GET['id'];

 if($categories->delete()){
   echo json_encode(
     array('message' => 'Category DELETED')
   );
 }else{
  echo json_encode(
    array('message' => 'Category Not DELETED')
  );
 }

}