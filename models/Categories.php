<?php
class Categories{
  private $conn;
  private $table = 'categories';

  public $idcategories;
  public $nama;
  public $deskripsi;
  public $created_at;

  public function __construct($db){
    $this->conn = $db;
  }

  public function read(){
    $query = 'SELECT * FROM ' . $this->table . ' ORDER BY idcategories ASC';

    $stmt = $this->conn->prepare($query);

    $stmt->execute();

    return $stmt;
  }

  public function create(){
    $query = 'INSERT INTO ' . $this->table . ' SET nama = :nama, deskripsi = :deskripsi, created_at = :created_at';    

    $stmt = $this->conn->prepare($query);

    $this->nama = htmlspecialchars(strip_tags($this->nama));
    $this->deskripsi = htmlspecialchars(strip_tags($this->deskripsi));
    $this->created_at = htmlspecialchars(strip_tags($this->created_at));

    $stmt->bindParam(':nama', $this->nama);
    $stmt->bindParam(':deskripsi', $this->deskripsi);
    $stmt->bindParam(':created_at', $this->created_at);

    if($stmt->execute()){
      return true;
    }

    printf("ERROR: %s.\n", $stmt->error);
    return false;
  }

  public function update(){
    $query = 'UPDATE ' . $this->table . '
              SET nama = :nama, deskripsi = :deskripsi, created_at = :created_at
              WHERE idcategories = :idcategories';   

    $stmt = $this->conn->prepare($query);
    $this->idcategories = htmlspecialchars(strip_tags($this->idcategories));
    $this->nama = htmlspecialchars(strip_tags($this->nama));
    $this->deskripsi = htmlspecialchars(strip_tags($this->deskripsi));
    $this->created_at = htmlspecialchars(strip_tags($this->created_at));

    $stmt->bindParam(':idcategories', $this->idcategories);
    $stmt->bindParam(':nama', $this->nama);
    $stmt->bindParam(':deskripsi', $this->deskripsi);
    $stmt->bindParam(':created_at', $this->created_at);
    
    if($stmt->execute()){
      return true;
    }

    printf("ERROR: %s.\n", $stmt->error);
    return false;
  }

  public function delete(){
    $query = 'DELETE FROM ' . $this->table . ' WHERE idcategories = :idcategories'; 

    $stmt = $this->conn->prepare($query);
    $this->idcategories = htmlspecialchars(strip_tags($this->idcategories));

    $stmt->bindParam(':idcategories', $this->idcategories);
    
    if($stmt->execute()){
      return true;
    }

    printf("ERROR: %s.\n", $stmt->error);
    return false;
  }

}