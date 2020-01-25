<?php
class PurchaseDetails{
  private $conn;

  public $idsupliers;
  public $total;
  public $purchases;
  public $created_at;

  public function __construct($db){
    $this->conn = $db;
  }

  public function checkout(){
    $query1 = 'INSERT INTO purchases SET idsupliers = :idsupliers, total = :total, created_at = :created_at';

    $stmt = $this->conn->prepare($query1);
    $stmt->bindParam(':idsupliers', $this->idsupliers);
    $stmt->bindParam(':total', $this->total);
    $stmt->bindParam(':created_at', $this->created_at);
    $stmt->execute();

    $lastidpurchase = $this->conn->lastInsertId();
	
	 echo json_encode(
      array('message' => $lastidpurchase)
    );

    foreach ($this->purchases as $row) {
      $query2 = 'INSERT INTO purchasedetails SET idpurchases ='.$lastidpurchase.', idproducts ='.$row->idproducts.', qty ='.$row->qty.', created_at = :created_at';

      $stmt = $this->conn->prepare($query2);
      $stmt->bindParam(':created_at', $this->created_at);
      $stmt->execute();

      $updatestok = $row->stok + $row->qty;

      $query3 = 'UPDATE products
              SET stok ='.$updatestok.', created_at = :created_at WHERE idproducts ='.$row->idproducts.' ';

      $stmt = $this->conn->prepare($query3);
      $stmt->bindParam(':created_at', $this->created_at);
      $stmt->execute();
    }
  }














  // $query2 = 'INSERT INTO purchasedetails SET idpurchases ='.$lastidpurchase.', idproducts ='.$row->idproducts.', qty ='.$row->qty.', created_at = :created_at';



}