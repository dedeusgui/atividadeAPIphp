<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

require_once 'config/Database.php';
require_once 'src/Models/Pessoa.php';
require_once 'src/Controllers/PessoaController.php';

$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

$controller = new PessoaController();

// Rotas: /api/sobre
if ($url[0] == 'api' && isset($url[1]) && $url[1] == 'sobre') {
    $method = $_SERVER['REQUEST_METHOD'];
    
    if ($method == 'GET') {
        if(isset($url[2])) {
            $controller->getById($url[2]);
        } else {
            $controller->getAll();
        }
    } elseif ($method == 'POST') {
        $controller->create();
    } elseif ($method == 'PUT') {
        if(isset($url[2])) {
            $controller->update($url[2]);
        } else {
            require_once 'src/Views/JsonView.php';
            JsonView::render(['mensagem' => 'ID não informado para atualização.'], 400);
        }
    } elseif ($method == 'DELETE') {
        if(isset($url[2])) {
            $controller->delete($url[2]);
        } else {
            require_once 'src/Views/JsonView.php';
            JsonView::render(['mensagem' => 'ID não informado para deleção.'], 400);
        }
    } else {
        require_once 'src/Views/JsonView.php';
        JsonView::render(['mensagem' => 'Método não suportado. Usar GET, POST, PUT ou DELETE.'], 405);
    }
} else {
    require_once 'src/Views/JsonView.php';
    JsonView::render(['mensagem' => 'Rota não encontrada. Tente GET /api/sobre ou GET /api/sobre/{id}'], 404);
}
