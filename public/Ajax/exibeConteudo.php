<?php
require_once __DIR__.'/../../vendor/autoload.php';

use DevUpload\Model\ConteudoModel;

//Recebe dados pelo método $_POST
$fk_pastCont = $_POST['fk_pastCont'];

$conteudos = (new ConteudoModel)->retornaArquivos($fk_pastCont);

// <a href="" rel="noopener noreferrer" downlaod></a>

//Percorre os conteudos listados devolvendo em formato de html
foreach($conteudos as $conteudo){
    var_dump($conteudo['contCaminho']);
    echo "<tr> 
        <td hidden value='{$conteudo['contId']}'>
            {$conteudo['contId']}
        </td>
        <td> 
            <a href='{$conteudo['contCaminho']}' download>{$conteudo['contNome']}</a>            
        </td>
        <td class='elementoNaDireita' >
            <button class='btn btn-outline 'onclick='excluiArquivo(this);' name='btnExcluiArquivo' data-toggle='modal' data-target='#modalExcluiArquivo'>
                <span class='glyphicon glyphicon-floppy-remove'>
            </button>
        </td>
    </tr>";
}