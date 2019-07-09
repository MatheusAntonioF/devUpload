<?php

namespace DevUpload\Controller;

use DevUpload\Model\PastaModel;
use DevUpload\Model\ConteudoModel;
use DevUpload\Model\UsuarioModel;

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

    //Método para excluir pastas no SGBD
    public function excluiPasta(){
        $pastId = $_POST['pastId'];

        $pastId = (int) $pastId;

        if(!empty($pastId)){
            $excluido = (new PastaModel)->excluiPasta($pastId);

            if($excluido){
                return self::view('home');
            }else{
                self::adicionaMensagensDeErro("Erro ao excluir pasta! Por favor, contate o responsável pelo sistema");
            }
        }
    }

    //Altera os dados da pasta
    public static function alteraDadosPasta(){
        $novoNome = addslashes($_POST['pastNome']);
        $pastId = addslashes($_POST['pastId']);
        $pastId = (int) $pastId;

        if(!empty($novoNome) && !empty($pastId)){

            $pastaModel = new PastaModel($pastId, $novoNome, null, null);

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

            $caminhoCont = "uploaded/".$contNome;

            $fk_pastCont = $_POST['fk_pastCont'];

            //Abre o arquivo enviado / r->leitura do arquivo e b-> força a abertura em modo binário
            $fp = fopen($tmpArquivo,"rb");
            //Lê  os dados de um arquivo externo
            $conteudo = fread($fp, $tamanhoArquivo);
            $conteudo = addslashes($conteudo);
            fclose($fp);

            $conteudoModel = new ConteudoModel(null, $conteudo, $contNome, $fk_pastCont, $caminhoCont);          
            $conteudoModel->uploadArquivo();

            move_uploaded_file($_FILES['arquivo']['tmp_name'],'uploaded/'.$contNome);
            return self::view('home');
        }else{
            //Arquivo não selecionado
            self::adicionaMensagensDeErro("Por favor selecione um arquivo antes de submete-lo");
            return self::view('home');
        }
        
    }

    //Exclui arquivo do SGBD
    public static function excluirArquivo(){
        $contId = addslashes($_POST['contId']);

        $contNome = (new ConteudoModel)->retornaNomeConteudo($contId);
        $caminho = "uploaded/";
        $diretorio = dir($caminho);

        $contNome = $contNome['contNome'];
        
        while($arquivo = $diretorio->read()){
 
            if($arquivo === $contNome){
                unlink($caminho.$contNome);
            }
        }
        $diretorio->close();

        if(!empty($contId)){
            (new ConteudoModel)->excluirArquivo($contId);

            return self::view('home');
        }else{
            self::adicionaMensagensDeErro("Erro ao excluir arquivo! Por favor, contate o responsável pelo sistema");

            return self::view('home');
        }
    }

    //Altera a foto de perfil do usuário
    public function alteraFotoPerfil(){
        $query = "SELECT userFoto FROM Usuarios WHERE userEmail = ?";

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $userEmail = $_SESSION['userEmail'];

        if(isset($_FILES['fotoPerfil'])){
            $nomeFoto = $_FILES['fotoPerfil']['name'];
            $nomeFoto = $userEmail."-"."fotoPerfil";
            $tmpFoto = $_FILES['fotoPerfil']['tmp_name'];
            $tamanhoFoto = $_FILES['fotoPerfil']['size'];
            $tipoFoto = $_FILES['fotoPerfil']['type'];
            
            $verificou = self::verificaTipoFoto($tipoFoto);
            
            if($verificou){
                //Continua
            }else{
                return false;
            }

            $fp = fopen($tmpFoto,"rb");
            $foto = fread($fp, $tamanhoFoto);
            $foto = addslashes($foto);
            fclose($fp);

            $caminho = "perfil/";
            $diretorio = dir($caminho);
            
            $arquivo = $diretorio->read();

            while($arquivo = $diretorio->read()){
                
                $encontrado = strpos($arquivo, $userEmail);

                if($encontrado === false){

                }else{
                    unlink($caminho.$arquivo);
                    $apagou = (new UsuarioModel)->excluiFotoUsuario();

                    if($apagou){

                    }else{

                    }
                }
            }
            $diretorio->close();

            //self::redimensionarFotoPerfil($caminho, $nomeFoto);

            move_uploaded_file($_FILES['fotoPerfil']['tmp_name'],'perfil/'.$nomeFoto);

            (new UsuarioModel)->alteraFotoPerfil($foto);
            self::view('home');
        }else{
            self::adicionaMensagensDeErro("Por favor selecione uma foto antes de alterar");
            self::view('home');
        }
    }
    //Verifica a extensão das fotos
    public function verificaTipoFoto($tipoFoto){
        $png = "png";
        $jpeg = "jpeg";
        $jpg = "jpg";

        if(strpos($tipoFoto, $png)){
            return true;

        }elseif(strpos($tipoFoto, $jpeg)){
            return true;

        }elseif(strpos($tipoFoto, $jpg)){
            return true;
        }
        return false;
    }

    public static function adicionaMensagensDeErro($msg){
        self::$mensagens[] = $msg;
    }
}