<?php
class Router {
    private $routes = [];

    public function get($route, $action) {
        $this->addRoute('GET', $route, $action);
    }

    public function post($route, $action) {
        $this->addRoute('POST', $route, $action);
    }

    public function put($route, $action) {
        $this->addRoute('PUT', $route, $action);
    }

    public function delete($route, $action) {
        $this->addRoute('DELETE', $route, $action);
    }

    private function addRoute($method, $route, $action) {
        // Converte a rota amigável com {id} para uma expressão regular visando encontrar os parâmetros
        $routePattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $route);
        $routePattern = '#^' . $routePattern . '$#';
        
        $this->routes[] = [
            'method' => $method,
            'pattern' => $routePattern,
            'action' => $action
        ];
    }

    public function run($requestUrl) {
        $method = $_SERVER['REQUEST_METHOD'];
        $requestUrl = '/' . trim($requestUrl, '/'); // Padroniza colocando a / no começo

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match($route['pattern'], $requestUrl, $matches)) {
                
                // Remove o primeiro elemento do array regex (o match total da URL)
                array_shift($matches); 
                
                // Separa qual Controller e qual Método deve ser chamado
                list($controllerName, $methodName) = explode('@', $route['action']);
                
                // Carega o Controller dinamicamente
                require_once "src/Controllers/{$controllerName}.php";
                $controller = new $controllerName();
                
                // Chama a função designada passando os parâmetros capturados (como o {id})
                call_user_func_array([$controller, $methodName], $matches);
                return;
            }
        }

        // Se passar pelo foreach e não encontrar, exibe "Rota Não Encontrada"
        require_once 'src/Views/JsonView.php';
        JsonView::render(['mensagem' => "Rota não encontrada ou método HTTP ($method) não permitido."], 404);
    }
}
