<?php

require_once __DIR__.'/../vendor/autoload.php';

use DevUpload\Router;

$app = new Router();

$app->get('/', function(){
    return \DevUpload\Controller\IndexController::index();
});

$app->post('/cadastraUsuario', function(){
    return \DevUpload\Controller\IndexController::cadastraUsuario();
});

$app->post('/loginUsuario', function(){   
    return \DevUpload\Controller\IndexController::loginUsuario();
});

$app->get('/out', function(){
    return \DevUpload\Controller\IndexController::logout();
});

$app->post('/cadastraPasta', function(){
    return \DevUpload\Controller\HomeController::cadastraPasta();
});

$app->post('/uploadConteudo', function(){
    return \DevUpload\Controller\HomeController::uploadArquivo();
});

$app->post('/alteraDadosPasta', function(){
    return \DevUpload\Controller\HomeController::alteraDadosPasta();
});

$app->run();