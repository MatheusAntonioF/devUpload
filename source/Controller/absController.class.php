<?php

namespace DevUpload\Controller;

use DevUpload\Router;

abstract class AbsController{
    
    // Redireciona a ṕagina para a respectiva view dentro da pasta /views
    protected final function view($_name, array $vars = []){
        $_nomeDoArquivo = __DIR__."/../../views/{$_name}.php";
        if(!file_exists($_nomeDoArquivo)){
            die("View {$_name} não foi encontrada");
        }
        include_once $_nomeDoArquivo;
    }

    //Retorna os parâmetros passadas pela URL
    protected final function params($name){
        $params =  Router::getRequest();

        if(!isset($params['name'])){
            return null;
        }
        return $params['name'];
    }

    //Verifica se existe um session ativo, caso contrario ativa
    protected final function verificaSession(){
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    //Redireciona a página para um caminho específico
    protected final function redirect(string $to){
        $url = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
        $pastas = explode('?',$_SERVER['REQUEST_URI'])[0];

        header('Location:' . '?r=' . $to);
        exit();
    }
}