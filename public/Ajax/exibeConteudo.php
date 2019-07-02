<?php
require_once __DIR__.'/../../vendor/autoload.php';

use DevUpload\Model\ConteudoModel;

//Recebe dados pelo método $_POST
$fk_pastCont = $_POST['fk_pastCont'];

$conteudos = (new ConteudoModel)->retornaArquivos($fk_pastCont);

//Percorre os conteudos listados devolvendo em formato de html
foreach($conteudos as $conteudo){
    echo "<tr> <td> {$conteudo['contNome']} </td>
        <td class='elementoNaDireita' >
            <button class='btn btn-outline'>
                <span class='glyphicon glyphicon-pencil'></span>
            </button>
            <button class='btn btn-outline'>
                <span class='glyphicon glyphicon-floppy-remove '>
            </button>
        </td>
    </tr>";
}