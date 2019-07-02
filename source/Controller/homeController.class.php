<?php

namespace DevUpload\Controller;

use DevUpload\Model\PastaModel;
use DevUpload\Model\ConteudoModel;

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
            return self::view('home');

        }else{
            self::adicionaMensagensDeErro("Preencha todos os campos");
            return self::view('home');
        }
    }
    public static function alteraDadosPasta(){
        $novoNome = $_POST['pastNome'];
        $fk_usePast = $_POST['fk_userPast'];

        echo "PASS";

        if(!empty($novoNome) && !empty($fk_userPast)){

            $pastaModel = new PastaModel(null, $novoNome, $fk_userPast, null);

            $pastaModel->alteraDadosPasta();

            return self::view('home');
        }else{
            self::adicionaMensagensDeErro("Preencha todos os campos");
            return self::view('home');
        }
    }

    //Faz o upload do conteúdo selecionado pelo usuário
    public static function uploadArquivo(){
        if(isset($_FILES['arquivo'])){
            $contNome = $_FILES['arquivo']['name'];
            $tmpArquivo = $_FILES['arquivo']['tmp_name'];
            $tamanhoArquivo = $_FILES['arquivo']['size'];

            $fk_pastCont = $_POST['fk_pastCont'];

            $fp = fopen($tmpArquivo,"rb");
            $conteudo = fread($fp, $tamanhoArquivo);
            $conteudo = addslashes($conteudo);
            fclose($fp);

            $conteudoModel = new ConteudoModel(null, $conteudo, $contNome, $fk_pastCont);
            
            $conteudoModel->uploadArquivo();

            move_uploaded_file($_FILES['arquivo']['tmp_name'],'uploaded/'.$contNome);

            return self::view('home');
        }else{
            //Arquivo não selecionado
            self::adicionaMensagensDeErro("Por favor selecione um arquivo");
        }
        
    }
    public static function adicionaMensagensDeErro($msg){
        self::$mensagens[] = $msg;
    }
}