<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/OrderDetails.php';

$database = new Database();
$db = $database->connect();

$orderdetails = new OrderDetails($db);

$method = $_SERVER['REQUEST_METHOD'];
if($method != 'POST'){
  echo json_encode(
    array('message' => "Check Out Not Created")
  );
}else{
  $orderdetails->idcustomers = $_POST['idcustomers'];
  $orderdetails->total = $_POST['total'];
  $orderdetails->orders = json_decode($_POST['orders']);
  $orderdetails->created_at = date('Y-m-d');

  $db->beginTransaction();

  try{
    $orderdetails->checkout();
    $db->commit();
    echo json_encode(
      array('message' => 'Check Out Created')
    );
  }catch(Exception $e){
    $db->rollBack();
    echo json_encode(
      array('message' => 'Check Out Not Created')
    );
  }

}
