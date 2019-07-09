<?php

namespace DevUpload\Model;

use DevUpload\Model\AbsConexaoBD;

class ConteudoModel extends AbsConexaoBD{
    private $contId;
    private $conteudo;
    private $contNome;
    private $fk_pastCont;
    private $contCaminho;

    public function __construct($contId = null, $conteudo = null, $contNome = null, $fk_pastCont = null, $contCaminho = null){
        parent::__construct();
        $this->contId = $contId;
        $this->conteudo = $conteudo;
        $this->contNome = $contNome;
        $this->fk_pastCont = $fk_pastCont;
        $this->contCaminho = $contCaminho;
    }
    
    //Upload de arquivo no SGBD
    public function uploadArquivo(){
        $query = "INSERT INTO Conteudos (conteudo, contNome, contCaminho , fk_pastCont) VALUES  (?, ?, ?, ?)";
        
        //Converte fk_pastCont para int quando for inserido no SGBD
        $this->fk_pastCont = (int) $this->fk_pastCont;

        $arrayDeValores = array($this->conteudo, $this->contNome, $this->contCaminho, $this->fk_pastCont);


        $inseriu = self::executaPs($query, $arrayDeValores);
        


        if($inseriu){
            return true;
        }else{
            return false;
        }
    }

    public function excluirArquivo($contId){
        $query = "SELECT contNome FROM Conteudos WHERE contId = ?";

        $arrayDeValores = array($contId);

        self::executaPs($query, $arrayDeValores);

        $contNome = $this->leTabelaBD();
        
        $diretorioArquivo = $_SERVER['DOCUMENT_ROOT'] . "/devUpload/public/uploaded/";

        rmdir($diretorioArquivo.$contNome['contNome']);

        $query = "DELETE FROM Conteudos WHERE contId = ?";

        $arrayDeValores = array($contId);

        $excluido = self::executaPs($query, $arrayDeValores);

        if($excluido){
            return true;
        }else{
            return false;
        }
    }

    //Retorna todos os arquivos armazenados no SGBD
    public function retornaArquivos($fk_pastCont){
        //Faz um cast transformando de String para int
        $fk_pastCont = (int) $fk_pastCont;

        $query = "SELECT contNome, contId, contCaminho FROM Conteudos WHERE fk_pastCont = ?";

        $arrayDeValores = array($fk_pastCont);

        $retornou = self::executaPs($query, $arrayDeValores);

        if($retornou){
            //Continua
        }else{
            return false;
        }

        $conteudos = $this->pdoStatment->fetchAll();

        return $conteudos;
        
    }
}