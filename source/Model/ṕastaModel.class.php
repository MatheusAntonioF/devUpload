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

    //Exclui pasta do SGBD
    public function excluiPasta($pastId){
        $query = "DELETE FROM Pastas WHERE pastId = ?";

        $arrayDeValores = array($pastId);

        $excluido = self::executaPs($query, $arrayDeValores);

        if($excluido){
            return true;
        }else{
            return false;
        }
    }
    
    //Altera dados da pasta
    public function alteraDadosPasta(){
        $query = "UPDATE Pastas SET pastNome = ? WHERE pastId = ?";

        $arrayDeValores = array($this->pastNome, $this->pastId);

        $alterou = self::executaPs($query, $arrayDeValores);
        
        if($alterou){
            return true;
        }else{
            return false;
        }
    }

    //Retorna todas as pastas armazenadas no SGBD
    public function retornaTodasAsPastas(){
        // Verifica se existe um session ativo
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $userEmail = $_SESSION['userEmail'];

        //Retorna o id do usuario pelo email cadastrado
        $query = "SELECT userId FROM Usuarios WHERE userEmail = ?";
        $arrayDeValores = array($userEmail);

        self::executaPs($query, $arrayDeValores);

        //Retorna o userId logado
        $userId = $this->leTabelaBD();

        $this->fk_userPast = $userId['userId'];

        $query = "SELECT * FROM Pastas WHERE fk_userPast = ?"; 
        $arrayDeValores = array($this->fk_userPast);

        self::executaPs($query, $arrayDeValores);

        $leu = $pastas = $this->pdoStatment->fetchAll();

        if($leu){
            //Continua
        }else{
            return false;
        }

        return $pastas;
    }

    /* GETTERS AND SETTERS */
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