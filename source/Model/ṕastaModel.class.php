<?php

namespace DevUpload\Model;

use DevUpload\Model\AbsConexaoBD;

class PastaModel extends AbsConexaoBD{
    private $pastId;
    private $pastNome;
    private $fk_userPast;
    private $userEmail;

    public function __construct($pastId = null, $pastNome = null, $fk_userPast = null, $userEmail = null){
        parent::__construct();
        $this->pastId = $pastId;
        $this->pastNome = $pastNome;
        $this->fk_userPast = $fk_userPast;
        $this->userEmail = $userEmail;
    }

    //Cadastra pasta no SGBD
    public function cadastraNovaPasta(){
        $query = "SELECT * FROM Pastas WHERE pastNome = '?' ";

        $arrayDeValores = array($this->pastNome);

        $executou = self::executaPs($query, $arrayDeValores);

        if($executou){
            //Se pastNome existir retorna 0
            if($this->qtdDeLinhas() >= 1){
                return 0;
            }else{
                unset($query);
            }
        }
        //Retorna o id do usuario pelo email cadastrado
        $query = "SELECT userId FROM Usuarios WHERE userEmail = ?";
        $arrayDeValores = array($this->userEmail);

        self::executaPs($query, $arrayDeValores);

        $userId = $this->leTabelaBD();
        $this->fk_userPast = $userId['userId'];


        $query = "INSERT INTO Pastas (pastNome, fk_userPast) VALUES (?, ?)";

        $arrayDeValores = array($this->pastNome, $this->fk_userPast);

        $executou = self::executaPs($query, $arrayDeValores);

        if($executou){
            return true;
        }else{
            return false;
        }

    }
    public function retornaTodasAsPastas(){
        
        // Verifica se existe um session ativo
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $userEmail = $_SESSION['userEmail'];
        
        //Retorna o id do usuario pelo email cadastrado
        $query = "SELECT userId FROM Usuarios WHERE userEmail = '?'";
        $arrayDeValores = array($this->userEmail);

        self::executaPs($query, $arrayDeValores);

        $userId = $this->leTabelaBD();
        var_dump($userId);
        $this->fk_userPast = $userId['userId'];
        
        echo "<br>";

        $this->fk_userPast = $userId['userId'];

        $query = "SELECT * FROM Pastas WHERE fk_userPast = ?"; 
        $arrayDeValores = array($this->fk_userPast);
        self::executaPs($query, $arrayDeValores);

        echo "FK";
        var_dump($this->fk_userPast);
 
        $pastas  = $this->leTabelaBD();

        return $pastas;

    }

    public function getPastId(){
        return $this->pastId;
    }
    
    public function getPastNome(){
        return $this->pastNome;
    }
    public function setPastNome($pastNome){
        return $this->pastNome = $pastNome;
    }

}