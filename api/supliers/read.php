<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Supliers.php';

$database = new Database();
$db = $database->connect();

$supliers = new Supliers($db);

$method = $_SERVER['REQUEST_METHOD'];
if($method != 'GET'){
  echo json_encode(
    array('message' => "No Supliers Found")
  );
}else{
 $result = $supliers->read();

 $num = $result->rowCount();

 if($num >0){
  $cust_arr = array();
  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $cust_item = array(
      'idsupliers' => $idsupliers,
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
    array('message' => "No Supliers Found")
  );
 }
}