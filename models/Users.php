<?php
class Users{
  private $conn;
  private $table = 'users';

  public $idusers;
  public $username;
  public $password;
  public $role;
  public $foto;
  public $created_at;

  public function __construct($db){
    $this->conn = $db;
  }

  public function login(){
    $query = 'SELECT * FROM ' . $this->table . ' WHERE username = :username AND password = :password';
   
    $stmt = $this->conn->prepare($query);   
    
    $this->username = htmlspecialchars(strip_tags($this->username));
    $this->password = htmlspecialchars(strip_tags($this->password));

    $stmt->bindParam(':username', $this->username);
    $stmt->bindParam(':password', $this->password);

    $stmt->execute();

    return $stmt;
  }



  public function read(){
    $query = 'SELECT * FROM ' . $this->table . ' ORDER BY idusers ASC';

    $stmt = $this->conn->prepare($query);

    $stmt->execute();

    return $stmt;
  }

  public function create(){
    $query = 'INSERT INTO ' . $this->table . ' SET username = :username, password = :password, role = :role, foto = :foto, created_at = :created_at';    

    $this->username = htmlspecialchars(strip_tags($this->username));
    $this->password = htmlspecialchars(strip_tags($this->password));
    $this->role = htmlspecialchars(strip_tags($this->role));
    $this->foto = htmlspecialchars(strip_tags($this->foto));
    $this->created_at = htmlspecialchars(strip_tags($this->created_at));

    $stmt->bindParam(':username', $this->username);
    $stmt->bindParam(':password', $this->password);
    $stmt->bindParam(':role', $this->role);
    $stmt->bindParam(':foto', $this->foto);
    $stmt->bindParam(':created_at', $this->created_at);

    $stmt = $this->conn->prepare($query);

    if($stmt->execute()){
      return true;
    }

    printf("ERROR: %s.\n", $stmt->error);
    return false;
  }

  public function delete(){
    $query = 'DELETE FROM ' . $this->table . ' WHERE idusers = :idusers'; 

    $stmt = $this->conn->prepare($query);
    $this->idusers = htmlspecialchars(strip_tags($this->idusers));

    $stmt->bindParam(':idusers', $this->idusers);
    
    if($stmt->execute()){
	  unlink($_SERVER['DOCUMENT_ROOT']."/superposapi/upload/".$this->foto);
      unlink($_SERVER['DOCUMENT_ROOT']."/superposapi/upload".$this->foto);
      return true;
    }

    printf("ERROR: %s.\n", $stmt->error);
    return false;
  }

}