<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Users.php';

$database = new Database();
$db = $database->connect();

$users = new Users($db);

$method = $_SERVER['REQUEST_METHOD'];
if($method != 'POST'){
  echo json_encode(
    array('message' => "Users Not Created")
  );
}else{
  $users->username = $_POST['username'];
  $users->password = $_POST['password'];
  $users->role = $_POST['role'];

  $users->foto = $_FILES['foto']['name'];
  $users->fototype = $_FILES['foto']['type'];
  $users->fotosize = $_FILES['foto']['size'];
  $users->fototemp = $_FILES['foto']['tmp_name'];//file foto temporary diletakkan

  $users->created_at = date('Y-m-d');

  $path = $_SERVER['DOCUMENT_ROOT']."/superposapi/upload/".$users->foto;//set upload folder path

  if(empty($users->foto)){
    $errorMsg = "Please Enter your name foto";
  }else if($users->fototype === "image/jpg" || $users->fototype === "image/jpeg" || $users->fototype === "image/png" || $users->fototype === "image/gif"){
    if(!file_exists($path) && $users->fotosize < 50000000){
      move_uploaded_file($users->fototemp, $path);
    }else{
      $errorMsg = "File Already exists or file is to large";
    }
  }else{
      $errorMsg = "File must JPG/JPEG/PNG/GIF";
  }

  if(!isset($errorMsg)){
    if($users->create()){
      echo json_encode(
        array('message' => 'User Created')
      );
    }else{
     echo json_encode(
       array('message' => 'User Not Created')
     );
    }

  } else{
    echo json_encode(
      array('message' => 'User Not Created')
    );
  }
}







