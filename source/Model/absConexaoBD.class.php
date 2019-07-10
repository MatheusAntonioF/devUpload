<?php

namespace DevUpload\Model;

use \PDO;

abstract class AbsConexaoBD extends \PDO {
    private $PDO;
    protected $pdoStatment;
    private $confUTF8 = "charset=utf8";
    private $dbName = "devUpload";
    private $host = "localhost";
    private $usuario = "root";
    private $senha = "440731";
    private $opcoes = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    /**
     * dbname
     * host
     * usuario
     * senha
     */
    public function __construct(){
        try{     
            $this->PDO = parent::__construct("mysql:host={$this->host};dbname={$this->dbName};{$this->confUTF8}",$this->usuario,$this->senha, $this->opcoes);   
            
        }catch(PDOException $ex){
            $this->geraLogDeErro("Erro na conexão com o Banco de dados na classe ConexaoBD", $ex->getMessage);
            die("Não foi possível conectar-se ao SGBD");
        }
    }

    // Método para consultas no SGBD utilizando a biblioteca PDO
    // o parametro $query será o sql a ser executado
    // o parametro $arrayDeValores será os valores que foram substituidas na $query por ?
    public function executaPs($query, $arrayDeValores){
        // Trata as exceções do método prepare
        try {            
            $preparou = parent::prepare($query);  
            if($preparou){
                //Continua               
                $this->pdoStatment = $preparou;        
            }else{    
                return false;
            }

        } catch (Exception $erro) {
            $this->geraLogDeErro($query, $erro->getMessage());
            return false;
        }
        
        // Trata as exceções do método execute
        try {
            $executou = $this->pdoStatment->execute(array_values($arrayDeValores));  
            if($executou){          
                return true;
            }else{
                return false;
            }
            
        } catch (Exception $erro) {
            $this->geraLogDeErro($query, $erro->getMessage());
            return false;
        }

    }

    //Retorna os dados da última consulta realizada
    public function leTabelaBD(){
        return $this->pdoStatment->fetch();
    }

    // Retorna a quantidade de linhas afetadas pela consulta no SGBD
    public function qtdDeLinhas(){  
        return $this->pdoStatment->rowCount();
    }
    
    // Método para gerar o log de erros do sistema
    function geraLogDeErro($query, $mensagemDeErro) {
        global $diretorios;

        $conteudo_file = '===================================================================================' . PHP_EOL;
        $conteudo_file .= 'Hora: ' . date("H:i:s") . ' | Script: ' . $_SERVER['SCRIPT_NAME'] . PHP_EOL;
        $conteudo_file .= "Query executada: " . $query . ": " . $mensagemDeErro . PHP_EOL . PHP_EOL;

        $diretoriosDeLogs = $_SERVER['DOCUMENT_ROOT'] . "/devUpload/source/BD/Logs";

        // Se o diretório não existir, cria-o
        if (!is_dir($diretoriosDeLogs)) {
            mkdir($diretoriosDeLogs);
            
        }
        $fopen = fopen($diretoriosDeLogs . "/erros_" . date("Ymd") . ".log", "a");
        fwrite($fopen, $conteudo_file);
        fclose($fopen);
    }   
}