<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Products.php';

$database = new Database();
$db = $database->connect();

$products = new Products($db);

$method = $_SERVER['REQUEST_METHOD'];
if($method != 'PUT'){
  echo json_encode(
    array('message' => "Products Not Updated")
  );
}else{
  $url = file_get_contents("php://input");

  parse_str($url, $data);
  $products->idproducts = $data['idproducts'];

  $products->nama = $data['nama'];
  $products->idcategories = $data['idcategories'];
  $products->harga = $data['harga'];
  $products->stok = $data['stok'];
  $products->created_at = date('Y-m-d');

 if($products->update()){
   echo json_encode(
     array('message' => 'Product Updated')
   );
 }else{
  echo json_encode(
    array('message' => 'Product Not Updated')
  );
 }

}