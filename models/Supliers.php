<?php
class Supliers{
  private $conn;
  private $table = 'supliers';

  public $idsupliers;
  public $nama;
  public $alamat;
  public $tlp;
  public $email;
  public $created_at;

  public function __construct($db){
    $this->conn = $db;
  }

  public function read(){
    $query = 'SELECT * FROM ' . $this->table . ' ORDER BY idsupliers ASC';

    $stmt = $this->conn->prepare($query);

    $stmt->execute();

    return $stmt;
  }

  public function create(){
    $query = 'INSERT INTO ' . $this->table . ' SET nama = :nama, alamat = :alamat, tlp = :tlp, email = :email, created_at = :created_at';    

    $stmt = $this->conn->prepare($query);

    $this->nama = htmlspecialchars(strip_tags($this->nama));
    $this->alamat = htmlspecialchars(strip_tags($this->alamat));
    $this->tlp = htmlspecialchars(strip_tags($this->tlp));
    $this->email = htmlspecialchars(strip_tags($this->email));
    $this->created_at = htmlspecialchars(strip_tags($this->created_at));

    $stmt->bindParam(':nama', $this->nama);
    $stmt->bindParam(':alamat', $this->alamat);
    $stmt->bindParam(':tlp', $this->tlp);
    $stmt->bindParam(':email', $this->email);
    $stmt->bindParam(':created_at', $this->created_at);

    if($stmt->execute()){
      return true;
    }

    printf("ERROR: %s.\n", $stmt->error);
    return false;
  }

  public function update(){
    $query = 'UPDATE ' . $this->table . '
              SET nama = :nama, alamat = :alamat, tlp = :tlp, email = :email, created_at = :created_at
              WHERE idsupliers = :idsupliers';   

    $stmt = $this->conn->prepare($query);
    $this->idsupliers = htmlspecialchars(strip_tags($this->idsupliers));
    $this->nama = htmlspecialchars(strip_tags($this->nama));
    $this->alamat = htmlspecialchars(strip_tags($this->alamat));
    $this->tlp = htmlspecialchars(strip_tags($this->tlp));
    $this->email = htmlspecialchars(strip_tags($this->email));
    $this->created_at = htmlspecialchars(strip_tags($this->created_at));

    $stmt->bindParam(':idsupliers', $this->idsupliers);
    $stmt->bindParam(':nama', $this->nama);
    $stmt->bindParam(':alamat', $this->alamat);
    $stmt->bindParam(':tlp', $this->tlp);
    $stmt->bindParam(':email', $this->email);
    $stmt->bindParam(':created_at', $this->created_at);
    
    if($stmt->execute()){
      return true;
    }

    printf("ERROR: %s.\n", $stmt->error);
    return false;
  }

  public function delete(){
    $query = 'DELETE FROM ' . $this->table . ' WHERE idsupliers = :idsupliers'; 

    $stmt = $this->conn->prepare($query);
    $this->idsupliers = htmlspecialchars(strip_tags($this->idsupliers));

    $stmt->bindParam(':idsupliers', $this->idsupliers);
    
    if($stmt->execute()){
      return true;
    }

    printf("ERROR: %s.\n", $stmt->error);
    return false;
  }

}