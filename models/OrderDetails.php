<?php
class OrderDetails{
  private $conn;

  public $idcustomers;
  public $total;
  public $orders;
  public $created_at;

  public function __construct($db){
    $this->conn = $db;
  }

  public function checkout(){
    $query1 = 'INSERT INTO orders SET idcustomers = :idcustomers, total = :total, created_at = :created_at';

    $stmt = $this->conn->prepare($query1);
    $stmt->bindParam(':idcustomers', $this->idcustomers);
    $stmt->bindParam(':total', $this->total);
    $stmt->bindParam(':created_at', $this->created_at);
    $stmt->execute();

    $lastidorder = $this->conn->lastInsertId();

    foreach ($this->orders as $row) {
      $query2 = 'INSERT INTO orderdetails SET idorders ='.$lastidorder.', idproducts ='.$row->idproducts.', qty ='.$row->qty.', created_at = :created_at';

      $stmt = $this->conn->prepare($query2);
      $stmt->bindParam(':created_at', $this->created_at);
      $stmt->execute();

      $updatestok = $row->stok - $row->qty;

      $query3 = 'UPDATE products
              SET stok ='.$updatestok.', created_at = :created_at WHERE idproducts ='.$row->idproducts.' ';

      $stmt = $this->conn->prepare($query3);
      $stmt->bindParam(':created_at', $this->created_at);
      $stmt->execute();
    }
  }



}