<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/PurchaseDetails.php';

$database = new Database();
$db = $database->connect();

$purchasedetails = new PurchaseDetails($db);

$method = $_SERVER['REQUEST_METHOD'];
if($method != 'POST'){
  echo json_encode(
    array('message' => "Check Out Not Created")
  );
}else{
  $purchasedetails->idsupliers = $_POST['idsupliers'];
  $purchasedetails->total = $_POST['total'];
  $purchasedetails->purchases = json_decode($_POST['purchases']);
  $purchasedetails->created_at = date('Y-m-d');

  $db->beginTransaction();

  try{
    $purchasedetails->checkout();
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
