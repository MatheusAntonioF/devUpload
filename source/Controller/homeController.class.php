<?php

namespace DevUpload\Controller;

use DevUpload\Model\PastaModel;

final class HomeController extends AbsController{
    protected static $mensagens;

    public function __construct(){
        $this->mensagens = array();
    }

    //Função para cadastra novas pastas
    public static function cadastraPasta(){
        //Recebe dado da pasta pelo método POST
        $pastNome = addslashes($_POST['pastNome']);

        // Verifica se existe um session ativo
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $userEmail = $_SESSION['userEmail'];

        //Verifica se o campo foi preenchido
        if( !empty($pastNome) ){
            //Cria novo PastaModel para receber os dados da View por $_POST
            $pastaModel = new PastaModel(null,$pastNome, null, $userEmail);

            $inserido = $pastaModel->cadastraNovaPasta();

            /*Se retornar 0 -> Email já cadastrado */
            if($inserido == 0){
                
                self::adicionaMensagensDeErro("Pasta já existente");
                

            }
            /*Cadastrado com sucesso */
            echo "VOCÊ É FODA";

        }else{
            self::adicionaMensagensDeErro("Preencha todos os campos");
            return self::view('home');
        }
    }
    public static function adicionaMensagensDeErro($msg){
        self::$mensagens[] = $msg;
    }
}