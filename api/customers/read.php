<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Customers.php';

$database = new Database();
$db = $database->connect();

$customers = new Customers($db);

$method = $_SERVER['REQUEST_METHOD'];
if($method != 'GET'){
  echo json_encode(
    array('message' => "No Customers Found")
  );
}else{
 $result = $customers->read();

 $num = $result->rowCount();

 if($num >0){
  $cust_arr = array();
  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $cust_item = array(
      'idcustomers' => $idcustomers,
      'nama' => $nama,
      'alamat' => $alamat,
      'tlp' => $tlp,
      'email' => $email
    );

    array_push($cust_arr, $cust_item);
  }
  echo json_encode($cust_arr);
 }else{
  echo json_encode(
    array('message' => "No Customers Found")
  );
 }
}