<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Customers.php';

$database = new Database();
$db = $database->connect();

$customers = new Customers($db);

$method = $_SERVER['REQUEST_METHOD'];
if($method != 'PUT'){
  echo json_encode(
    array('message' => "Customers Not Updated")
  );
}else{
  $url = file_get_contents("php://input");

  parse_str($url, $data);
  $customers->idcustomers = $data['idcustomers'];

  $customers->nama = $data['nama'];
  $customers->alamat = $data['alamat'];
  $customers->tlp = $data['tlp'];
  $customers->email = $data['email'];
  $customers->created_at = date('Y-m-d');

 if($customers->update()){
   echo json_encode(
     array('message' => 'Customer Updated')
   );
 }else{
  echo json_encode(
    array('message' => 'Customer Not Updated')
  );
 }

}