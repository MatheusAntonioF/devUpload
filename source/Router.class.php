<?php

namespace DevUpload;

class Router{
    /*Armazenamento das rotas e dos parámetros atuais do HTTP*/
    private $routes = [];
    private static $params = [];

    /*Verifica se método chamado é GET ou POST*/
    private function validate($method){
        return in_array($method,['get','post']);
    }
    /*Chamado sempre que existe uma chamada nessa classe, caso a chamada
    seja válida, irá separar e validar os argumentos recebidos,
    devendo receber uma string e uma função. E por fim armazena no
    array de rotas */
    public function __call(string $method, array $args){
        $method = strtolower($method);
        
        if(!$this->validate($method)){
            return false;
        }
        [$route,$action] = $args;
        if(!isset($action) or !is_callable($action)){
            return false;
        }
        $this->routes[$method][$route] = $action;
        return true;
    }
    /*Dá inicio a aplicação, verificando se existem rotas com o método
    HTTP atual(POST ou GET), se existe a rota definida pelo paramêtro GET r.
    E por fim chamando o callable da rota correspondente, finalizando a aplicação
    exibindo o seu retorno(a resposta do Controller) */
    public function run(){
        $method = strtolower($_SERVER['REQUEST_METHOD']) ?? 'get';
        $route = $_GET['r'] ?? '/';

        if(!isset($this->routes[$method])){
            die('405 Method não permitido');
        }
        if(!isset($this->routes[$method][$route])){
            die('404 Error');
        }
        self::$params = $this->getParams($method);

        die($this->routes[$method][$route]());

        
    }
    /*Pega as variáveis correspondente ao método atual, sendo os dados
    enviados pelo cliente */
    private function getParams($method){
        if($method == 'get'){
            return $_GET;
        }
        return $_POST;
    }
    /*Getter para que o controlador possa pegar os dados da requisição do cliente */
    public static function getRequest(){
        return self::$params;
    }
}