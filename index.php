<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Content-Type: application/json; charset=UTF-8");

require_once 'config/Database.php';
require_once 'src/Models/Pessoa.php';
require_once 'src/Core/Router.php';

// Limpa URL
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '/';

// Cria o centro gerador de rotas
$router = new Router();

// ============================================
//               HUB DE ROTAS (API)
// ============================================

// LER
$router->get('/guilherme',       'PessoaController@getAll');
$router->get('/guilherme/{id}',  'PessoaController@getById');

// CRIAR
$router->post('/guilherme',      'PessoaController@create');

// ATUALIZAR
$router->put('/guilherme/{id}',  'PessoaController@update');

// DELETAR
$router->delete('/guilherme/{id}','PessoaController@delete');


// ============================================
// Faz o Router instanciar e executar os códigos da URL enviada
$router->run($url);
