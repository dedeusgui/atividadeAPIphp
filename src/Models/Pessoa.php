<?php
class Pessoa {
    private $conn;
    private $table_name = "guilherme";

    public $id;
    public $peso;
    public $altura;
    public $cor_cabelo;
    public $cor_olho;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = "SELECT id, peso, altura, cor_cabelo, cor_olho FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    public function readOne() {
        $query = "SELECT id, peso, altura, cor_cabelo, cor_olho FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            $this->peso = $row['peso'];
            $this->altura = $row['altura'];
            $this->cor_cabelo = $row['cor_cabelo'];
            $this->cor_olho = $row['cor_olho'];
        }
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET peso=:peso, altura=:altura, cor_cabelo=:cor_cabelo, cor_olho=:cor_olho";
        $stmt = $this->conn->prepare($query);

        $this->peso = htmlspecialchars(strip_tags($this->peso));
        $this->altura = htmlspecialchars(strip_tags($this->altura));
        $this->cor_cabelo = htmlspecialchars(strip_tags($this->cor_cabelo));
        $this->cor_olho = htmlspecialchars(strip_tags($this->cor_olho));

        $stmt->bindParam(":peso", $this->peso);
        $stmt->bindParam(":altura", $this->altura);
        $stmt->bindParam(":cor_cabelo", $this->cor_cabelo);
        $stmt->bindParam(":cor_olho", $this->cor_olho);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET peso=:peso, altura=:altura, cor_cabelo=:cor_cabelo, cor_olho=:cor_olho WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->peso = htmlspecialchars(strip_tags($this->peso));
        $this->altura = htmlspecialchars(strip_tags($this->altura));
        $this->cor_cabelo = htmlspecialchars(strip_tags($this->cor_cabelo));
        $this->cor_olho = htmlspecialchars(strip_tags($this->cor_olho));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":peso", $this->peso);
        $stmt->bindParam(":altura", $this->altura);
        $stmt->bindParam(":cor_cabelo", $this->cor_cabelo);
        $stmt->bindParam(":cor_olho", $this->cor_olho);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
