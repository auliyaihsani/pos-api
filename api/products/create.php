<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Products.php';

$database = new Database();
$db = $database->connect();

$products = new Products($db);

$method = $_SERVER['REQUEST_METHOD'];
if($method != 'POST'){
  echo json_encode(
    array('message' => "Products Not Created")
  );
}else{
  $url = file_get_contents("php://input");

  parse_str($url, $data);

  $products->nama = $data['nama'];
  $products->idcategories = $data['idcategories'];
  $products->harga = $data['harga'];
  $products->stok = $data['stok'];
  $products->created_at = date('Y-m-d');

 if($products->create()){
   echo json_encode(
     array('message' => 'Product Created')
   );
 }else{
  echo json_encode(
    array('message' => 'Product Not Created')
  );
 }

}