<?php
class Pessoa {
    private $conn;
    private $table_name = "sobre_mim";

    public $id;
    public $nome_completo;
    public $cor_do_olho;
    public $tamanho;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = "SELECT id, nome_completo, cor_do_olho, tamanho FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    public function readOne() {
        $query = "SELECT id, nome_completo, cor_do_olho, tamanho FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            $this->nome_completo = $row['nome_completo'];
            $this->cor_do_olho = $row['cor_do_olho'];
            $this->tamanho = $row['tamanho'];
        }
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET nome_completo=:nome_completo, cor_do_olho=:cor_do_olho, tamanho=:tamanho";
        $stmt = $this->conn->prepare($query);

        $this->nome_completo = htmlspecialchars(strip_tags($this->nome_completo));
        $this->cor_do_olho = htmlspecialchars(strip_tags($this->cor_do_olho));
        $this->tamanho = htmlspecialchars(strip_tags($this->tamanho));

        $stmt->bindParam(":nome_completo", $this->nome_completo);
        $stmt->bindParam(":cor_do_olho", $this->cor_do_olho);
        $stmt->bindParam(":tamanho", $this->tamanho);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET nome_completo=:nome_completo, cor_do_olho=:cor_do_olho, tamanho=:tamanho WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->nome_completo = htmlspecialchars(strip_tags($this->nome_completo));
        $this->cor_do_olho = htmlspecialchars(strip_tags($this->cor_do_olho));
        $this->tamanho = htmlspecialchars(strip_tags($this->tamanho));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":nome_completo", $this->nome_completo);
        $stmt->bindParam(":cor_do_olho", $this->cor_do_olho);
        $stmt->bindParam(":tamanho", $this->tamanho);
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
