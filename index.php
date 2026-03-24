<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Content-Type: application/json; charset=UTF-8");

require_once 'config/Database.php';
require_once 'src/Models/Pessoa.php';
require_once 'src/Core/Router.php';

// Limpa URL
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '/';

// Cria central de roteamento visual
$router = new Router();

// ============================================
//               HUB DE ROTAS (API)
// ============================================

// SELECT
$router->get('/api/sobre',       'PessoaController@getAll');
$router->get('/api/sobre/{id}',  'PessoaController@getById');

// INSERT
$router->post('/api/sobre',      'PessoaController@create');

// UPDATE
$router->put('/api/sobre/{id}',  'PessoaController@update');

// DELETE
$router->delete('/api/sobre/{id}','PessoaController@delete');


// ============================================
// Executa o roteador
$router->run($url);
