<?php

namespace DevUpload\Controller;

use DevUpload\Router;

abstract class AbsController{
    
    protected final function view($_name, array $vars = []){
        $_nomeDoArquivo = __DIR__."/../../views/{$_name}.php";
        if(!file_exists($_nomeDoArquivo)){
            die("View {$_name} não foi encontrada");
        }

        include_once $_nomeDoArquivo;
    }
    
    protected final function params($name){
        $params =  Router::getRequest();

        if(!isset($params['name'])){
            return null;
        }
        return $params['name'];
    }
    protected final function redirect(string $to){
        $url = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
        $pastas = explode('?',$_SERVER['REQUEST_URI'])[0];

        header('Location:' . '?r=' . $to);
        exit();
    }
}