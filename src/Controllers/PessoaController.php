<?php
require_once 'src/Views/JsonView.php';

class PessoaController {
    private $db;
    private $pessoa;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->pessoa = new Pessoa($this->db);
    }

    public function getAll() {
        $stmt = $this->pessoa->read();
        $num = $stmt->rowCount();

        if ($num > 0) {
            $pessoas_arr = array();
            $pessoas_arr["dados"] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $pessoa_item = array(
                    "id" => $id,
                    "peso" => $peso,
                    "altura" => $altura,
                    "cor_cabelo" => $cor_cabelo,
                    "cor_olho" => $cor_olho
                );
                array_push($pessoas_arr["dados"], $pessoa_item);
            }
            JsonView::render($pessoas_arr, 200);
        } else {
            JsonView::render(array("mensagem" => "Nenhum dado encontrado."), 404);
        }
    }
    
    public function getById($id) {
        $this->pessoa->id = $id;
        $this->pessoa->readOne();
        
        if($this->pessoa->peso != null) {
            $pessoa_arr = array(
                "id" =>  $this->pessoa->id,
                "peso" => $this->pessoa->peso,
                "altura" => $this->pessoa->altura,
                "cor_cabelo" => $this->pessoa->cor_cabelo,
                "cor_olho" => $this->pessoa->cor_olho
            );
            JsonView::render($pessoa_arr, 200);
        } else {
            JsonView::render(array("mensagem" => "Pessoa não encontrada."), 404);
        }
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"));
        if(!empty($data->peso) && !empty($data->altura) && !empty($data->cor_cabelo) && !empty($data->cor_olho)) {
            $this->pessoa->peso = $data->peso;
            $this->pessoa->altura = $data->altura;
            $this->pessoa->cor_cabelo = $data->cor_cabelo;
            $this->pessoa->cor_olho = $data->cor_olho;

            if($this->pessoa->create()) {
                JsonView::render(array("mensagem" => "Dados criados com sucesso."), 201);
            } else {
                JsonView::render(array("mensagem" => "Não foi possível criar os dados."), 503);
            }
        } else {
            JsonView::render(array("mensagem" => "Dados incompletos."), 400);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"));
        $this->pessoa->id = $id;

        if(!empty($data->peso) && !empty($data->altura) && !empty($data->cor_cabelo) && !empty($data->cor_olho)) {
            $this->pessoa->peso = $data->peso;
            $this->pessoa->altura = $data->altura;
            $this->pessoa->cor_cabelo = $data->cor_cabelo;
            $this->pessoa->cor_olho = $data->cor_olho;

            if($this->pessoa->update()) {
                JsonView::render(array("mensagem" => "Dados atualizados com sucesso."), 200);
            } else {
                JsonView::render(array("mensagem" => "Não foi possível atualizar os dados."), 503);
            }
        } else {
            JsonView::render(array("mensagem" => "Dados incompletos."), 400);
        }
    }

    public function delete($id) {
        $this->pessoa->id = $id;

        if($this->pessoa->delete()) {
            JsonView::render(array("mensagem" => "Dados deletados com sucesso."), 200);
        } else {
            JsonView::render(array("mensagem" => "Não foi possível deletar os dados."), 503);
        }
    }
}
