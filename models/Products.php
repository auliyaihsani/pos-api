<?php
class Products{
  private $conn;
  private $table = 'products';

  public $idproducts;
  public $nama;
  public $idcategories;
  public $namacategories;
  public $harga;
  public $stok;
  public $created_at;

  public function __construct($db){
    $this->conn = $db;
  }

  public function read(){
    $query = 'SELECT c.nama as namacategories, p.* FROM ' . $this->table. ' as p, categories as c WHERE p.idcategories = c.idcategories ORDER BY idproducts ASC';

    $stmt = $this->conn->prepare($query);

    $stmt->execute();

    return $stmt;
  }

  public function create(){
    $query = 'INSERT INTO ' . $this->table . ' SET nama = :nama, idcategories = :idcategories, harga = :harga, stok = :stok, created_at = :created_at';    

    $stmt = $this->conn->prepare($query);

    $this->nama = htmlspecialchars(strip_tags($this->nama));
    $this->idcategories = htmlspecialchars(strip_tags($this->idcategories));
    $this->harga = htmlspecialchars(strip_tags($this->harga));
    $this->stok = htmlspecialchars(strip_tags($this->stok));
    $this->created_at = htmlspecialchars(strip_tags($this->created_at));

    $stmt->bindParam(':nama', $this->nama);
    $stmt->bindParam(':idcategories', $this->idcategories);
    $stmt->bindParam(':harga', $this->harga);
    $stmt->bindParam(':stok', $this->stok);
    $stmt->bindParam(':created_at', $this->created_at);

    if($stmt->execute()){
      return true;
    }

    printf("ERROR: %s.\n", $stmt->error);
    return false;
  }

  public function update(){
    $query = 'UPDATE ' . $this->table . '
              SET nama = :nama, idcategories = :idcategories, harga = :harga, stok = :stok, created_at = :created_at
              WHERE idproducts = :idproducts';   

    $stmt = $this->conn->prepare($query);
    $this->idproducts = htmlspecialchars(strip_tags($this->idproducts));
    $this->nama = htmlspecialchars(strip_tags($this->nama));
    $this->idcategories = htmlspecialchars(strip_tags($this->idcategories));
    $this->harga = htmlspecialchars(strip_tags($this->harga));
    $this->stok = htmlspecialchars(strip_tags($this->stok));
    $this->created_at = htmlspecialchars(strip_tags($this->created_at));

    $stmt->bindParam(':idproducts', $this->idproducts);
    $stmt->bindParam(':nama', $this->nama);
    $stmt->bindParam(':idcategories', $this->idcategories);
    $stmt->bindParam(':harga', $this->harga);
    $stmt->bindParam(':stok', $this->stok);
    $stmt->bindParam(':created_at', $this->created_at);
    
    if($stmt->execute()){
      return true;
    }

    printf("ERROR: %s.\n", $stmt->error);
    return false;
  }

  public function delete(){
    $query = 'DELETE FROM ' . $this->table . ' WHERE idproducts = :idproducts'; 

    $stmt = $this->conn->prepare($query);
    $this->idproducts = htmlspecialchars(strip_tags($this->idproducts));

    $stmt->bindParam(':idproducts', $this->idproducts);
    
    if($stmt->execute()){
      return true;
    }

    printf("ERROR: %s.\n", $stmt->error);
    return false;
  }

}