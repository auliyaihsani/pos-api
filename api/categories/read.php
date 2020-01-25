<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Categories.php';

$database = new Database();
$db = $database->connect();

$categories = new Categories($db);

$method = $_SERVER['REQUEST_METHOD'];
if($method != 'GET'){
  echo json_encode(
    array('message' => "No Categories Found")
  );
}else{
 $result = $categories->read();

 $num = $result->rowCount();

 if($num >0){
  $cust_arr = array();
  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $cust_item = array(
      'idcategories' => $idcategories,
      'nama' => $nama,
      'deskripsi' => $deskripsi
    );

    array_push($cust_arr, $cust_item);
  }
  echo json_encode($cust_arr);
 }else{
  echo json_encode(
    array('message' => "No Categories Found")
  );
 }
}