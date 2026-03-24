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
                    "nome_completo" => $nome_completo,
                    "cor_do_olho" => $cor_do_olho,
                    "tamanho" => $tamanho
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
        
        if($this->pessoa->nome_completo != null) {
            $pessoa_arr = array(
                "id" =>  $this->pessoa->id,
                "nome_completo" => $this->pessoa->nome_completo,
                "cor_do_olho" => $this->pessoa->cor_do_olho,
                "tamanho" => $this->pessoa->tamanho
            );
            JsonView::render($pessoa_arr, 200);
        } else {
            JsonView::render(array("mensagem" => "Pessoa não encontrada."), 404);
        }
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"));
        if(!empty($data->nome_completo) && !empty($data->cor_do_olho) && !empty($data->tamanho)) {
            $this->pessoa->nome_completo = $data->nome_completo;
            $this->pessoa->cor_do_olho = $data->cor_do_olho;
            $this->pessoa->tamanho = $data->tamanho;

            if($this->pessoa->create()) {
                JsonView::render(array("mensagem" => "Pessoa criada com sucesso."), 201);
            } else {
                JsonView::render(array("mensagem" => "Não foi possível criar a pessoa."), 503);
            }
        } else {
            JsonView::render(array("mensagem" => "Dados incompletos."), 400);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"));
        $this->pessoa->id = $id;

        if(!empty($data->nome_completo) && !empty($data->cor_do_olho) && !empty($data->tamanho)) {
            $this->pessoa->nome_completo = $data->nome_completo;
            $this->pessoa->cor_do_olho = $data->cor_do_olho;
            $this->pessoa->tamanho = $data->tamanho;

            if($this->pessoa->update()) {
                JsonView::render(array("mensagem" => "Pessoa atualizada com sucesso."), 200);
            } else {
                JsonView::render(array("mensagem" => "Não foi possível atualizar a pessoa."), 503);
            }
        } else {
            JsonView::render(array("mensagem" => "Dados incompletos."), 400);
        }
    }

    public function delete($id) {
        $this->pessoa->id = $id;

        if($this->pessoa->delete()) {
            JsonView::render(array("mensagem" => "Pessoa deletada com sucesso."), 200);
        } else {
            JsonView::render(array("mensagem" => "Não foi possível deletar a pessoa."), 503);
        }
    }
}
