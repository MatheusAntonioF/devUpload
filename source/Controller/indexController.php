<?php

namespace DevUpload\Controller;

use DevUpload\Model\UsuarioModel;

final class IndexController extends AbsController{
    protected static $mensagens;
    
    public function __construct(){
        $this->mensagens = array();
    }

    public static function index(){
        return self::view('index');
    }
    // Função para cadastrar novo usuário
    public static function cadastraUsuario(){       
        /*Recebe dados do usuário pelo método post*/
        $userNome = addslashes($_POST['userNome']);
        $userApelido = addslashes($_POST['userApelido']);
        $userEmail = addslashes($_POST['userEmail']);
        $userSenha = addslashes($_POST['userSenha']);


        // Verifica se todos os campos foram preechidos
        if (!empty($userNome) && !empty($userApelido) && !empty($userEmail) && !empty($userSenha)) {
                
            /* cria novo usuarioModel para receber os dados da view por $_POST*/
            $usuarioModel = new UsuarioModel(null, $userNome, $userApelido, $userEmail, $userSenha);
            
            $inserido = $usuarioModel->criaNovoUsuario();
            
            /*Se retornar 0 -> Email já cadastrado */
            if($inserido == 0){
                
                self::adicionaMensagensDeErro("Email já cadastrado");
                return self::view('index');

            }
            /*Cadastrado com sucesso */
            self::adicionaMensagensDeErro("Usuário cadastrado com sucesso");

            // Verifica se existe um session ativo
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }
            $_SESSION['userEmail'] = $userEmail;
            return self::view('home');
        }else{

            self::adicionaMensagensDeErro("Preencha todos os campos");
            return self::view('index');
        }
        
    }

    // Função para fazer login
    public static function loginUsuario(){
        // Recebe dados do usuário pelo método post
        $userEmail = addslashes($_POST['userEmail']);
        $userSenha = addslashes($_POST['userSenha']);

        if(!empty($userEmail) && !empty($userSenha)){
            $usuarioModel = new UsuarioModel(null, null ,null ,$userEmail, $userSenha);

            $logou = $usuarioModel->loginUsuario(); 

            if($logou){
                self::verificaSession();
                
                $_SESSION['userEmail'] = $userEmail;  

                self::adicionaMensagensDeErro("Login feito com sucesso");
                return self::view('home');
            }else{
                self::adicionaMensagensDeErro("Usuário não encontrado");
                return self::view('index');
            }
        }else{
            self::adicionaMensagensDeErro("Preencha todos os campos");
            return self::view('index');
        }



        // verifica se existe um session ativo
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $_SESSION['userEmail'] = $userEmail;

        return seld::view('home');
    }

    //Adiciona mensagem de erro em uma array
    public static function adicionaMensagensDeErro($msg){
        self::$mensagens[] = $msg;
    }
}
