<?php

namespace DevUpload\Model;

use DevUpload\Model\AbsConexaoBD;

class UsuarioModel extends AbsConexaoBD{
    private $userId;
    private $userNome;
    private $userApelido;
    private $userEmail;
    private $userSenha;
    private $userFoto;

    public function __construct($userId = null, $userNome = null, $userApelido = null, $userEmail = null, $userSenha = null){
        parent::__construct();
        $this->userId = $userId;
        $this->userNome = $userNome;
        $this->userApelido = $userApelido;
        $this->userEmail = $userEmail;
        $this->userSenha = $userSenha;
          
    }

    // Cria um novo usuario no SGBD
    public function criaNovoUsuario(){
        $query = "SELECT userId FROM Usuarios WHERE userEmail = ?";
        
        $arrayDeValores = array($this->getUserEmail());

        $executou = self::executaPs($query, $arrayDeValores);

        if ($executou) {
            // Se email existir retorna 0
            if ($this->qtdDeLinhas() >= 1 ){ 
                return 0;
            }else{
                unset($query);            
            }
        }
        $query = "INSERT INTO Usuarios (userNome, userApelido, userEmail, userSenha) VALUES (?, ?, ?, ?)";
        
        $arrayDeValores = array($this->getUserNome(), $this->getUserApelido(), $this->getUserEmail(), $this->getUserSenha());
        
        $executou = self::executaPs($query, $arrayDeValores);
        
        /* Verifica se a execução foi bem sucedida*/
        if ($executou){ 
            return true;
        }else{ 
            return false;
        }               
    } 

    // Verifica e valida os dados de login do usuário 
    public function loginUsuario(){
        $query = "SELECT userEmail, userSenha FROM Usuarios WHERE userEmail = ? AND userSenha = ?";

        $arrayDeValores = array($this->getUserEmail(), $this->getUserSenha());

        $executou = parent::executaPs($query, $arrayDeValores);

        // Verifica se a execução foi bem sucedida
        if($executou){
            // Verifica se os dados existem
            if($this->qtdDeLinhas() == 1){
                return true;
            }else{
                
                return false;
            }
        }
    }

    // Busca no SGBD um usuário e retorna um objeto do tipo UsuarioModel
    public function retornaUsuario($userEmail){
        $query = "SELECT * FROM Usuarios WHERE userEmail = ?";
        
        $arrayDeValores = array($userEmail);

        $executou = parent::executaPs($query,$arrayDeValores);
             
        if ($executou) {
            // Verifica se os dados existem
            if ($this->qtdDeLinhas() >= 1){ 
                // Continua
                
            }else{ 
                return 0;
            }
        }else{
            return false;
        }        

        $leu = $objetoBD = $this->leTabelaBD();

        if($leu){
            // Continua
        }else{
            return false;
        }
        
        return new UsuarioModel($objetoBD['userId'],$objetoBD['userNome'],$objetoBD['userApelido'],$objetoBD['userEmail'], $objetoBD['userSenha']);
    }

    //Altera a foto do usuário no SGBD
    public function alteraFotoPerfil($foto){
        $apagou = $this->excluiFotoUsuario();
        
        if($apagou){
            $query = "UPDATE Usuarios SET userFoto = ?";

            $arrayDeValores = array($foto);

            self::executaPs($query, $arrayDeValores);
        }else{
            return false;
        }
    }

    //Exclui a foto do usuário no SGBD
    public function excluiFotoUsuario(){
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $userEmail = $_SESSION['userEmail'];

        $query = "UPDATE Usuarios SET userFoto = ? WHERE userEmail = ?";

        $arrayDeValores = array(null, $userEmail);

        $apagou = self::executaPs($query, $arrayDeValores);

        return $apagou;
    }


    /*GETTERS AND SETTERS */
    function getUserId() {
        return $this->userId;
    }

    function getUserNome() {
        return $this->userNome;
    }

    function getUserEmail() {
        return $this->userEmail;
    }

    function getUserFoto() {
        return $this->userFoto;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setUserNome($userNome) {
        $this->userNome = $userNome;
    }

    function setUserEmail($userEmail) {
        $this->userEmail = $userEmail;
    }

    function setUserFoto($userFoto) {
        $this->userFoto = $userFoto;
    }

    function getUserApelido() {
        return $this->userApelido;
    }

    function setUserNickName($userApelido) {
        $this->userApelido = $userApelido;
    }

    function getUserSenha() {
        return $this->userSenha;
    }

    function setUserSenha($userSenha) {
        $this->userSenha = $userSenha;
    }
}
