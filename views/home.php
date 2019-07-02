<?php
    use \DevUpload\Model\UsuarioModel;
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <!--  meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!--CSS próprio-->
        <link rel="stylesheet" href="CSS/estilo.css">

         <!-- Jquery -->
         <script type="text/javascript" src="JQuery/jquery.js"></script>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        
       

        <!-- Arquivos para exibir/ocultar senhas-->
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>   
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-show-password/1.0.3/bootstrap-show-password.min.js"></script>

        <title>DevUpload</title>
    </head>
    <body>
        <div class="row" id="divInicialMenu">
            <div class="col-sm-3" id="divMenu">
                <img src="Imagens/usuario.png" alt="usuario" id="imgUsuario" class="img-responsive rounded mx-auto d-block">
                <br>
                
                <p id="pUserNome" class="corDoSistema elementoNoCentro h1">
                    <?php
                        // Verifica se existe um session ativo
                        if (session_status() !== PHP_SESSION_ACTIVE) {
                            session_start();
                        }

                        $userEmail = $_SESSION['userEmail'];
                        
                        $usuarioModel = (new UsuarioModel)->retornaUsuario($userEmail);
                        
                        $userNome = $usuarioModel->getUserNome();

                        
                        echo $userNome;
                    ?>                    
                </p>
                <div class="elementoNoCentro">
                    <button id="btnNovo" class="elementoNoCentro btn btn-outline-primary btn-lg btn-block" data-toggle="modal" data-target="#modalCadastroArquivos">
                        NOVO
                    </button>
                </div>
                <!-- Modal Cadastro -->
                <div class="modal" id="modalCadastroArquivos">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header textoBranco fundoCorDoSistema">
                                <h1 class="modal-title">Nova Pasta</h1>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body"> 
                                <br>                       
                                <form action="?r=/cadastraPasta" method="post">
                                    <!-- Cadastro Nome -->
                                    <label for="inputPastNome" class="corDoSistema">Nome</label>
                                    <input type="text" name="pastNome" id="inputPastNome" class="form-control" placeholder="Escolha um nome">                         
                                    <button type="submit" id="btnCadastraPasta" class="btn btn-primary topEstilizado" >Enviar</button>

                                </form>
                            </div>
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>                
                <table class="table table-hover  topEstilizado">
                    <tbody>
                        <?php
                            use DevUpload\Model\PastaModel;

                            $pasta = new PastaModel();
                            $pastas = $pasta->retornaTodasAsPastas();
                           
                            foreach($pastas as $pasta):                           
                        ?>
                        <tr>
                                <td hidden>
                                    <?php echo $pasta['pastId'] ?>

                                </td>
                                <td scope="row" name="tdpastNome" class="elementoNoCentro"> 
                                    <button type="button" class="btn btn-outline-primary btnMenu" id="btnMenu"> <?php echo $pasta['pastNome'] ?> </button>
                                </td>
                                <td class="elementoNaDireita">
                                    <button class="btn btn-outline" >
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </button>
                                    
                                    <button class="btn btn-outline">
                                        <span class="glyphicon glyphicon-edit btnAltera" data-toggle="modal" data-target="#modalAlteraDadosPasta"></span>
                                    </button>
                                </td>
                        </tr>
                        <?php  endforeach; ?>

                    </tbody>
                </table>
                <!-- Modal Altera dados da pasta ------------------------------------------------------------------------------------------------->
                <div class="modal" id="modalAlteraDadosPasta">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header textoBranco fundoSecundarioDoSistema">
                                    <h1 class="modal-title">Altera dados</h1>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body"> 
                                    <br>                       
                                    <form action="?r=/alteraDadosPasta" method="post" >
                                        <input type="hidden" name="fk_userPast" id="pastId" value="">
                                        <!-- Altera Nome -->
                                        <label for="inputPastNome" class="corDoSistema">Novo nome</label>
                                        <input type="text" name="pastNome" id="inputPastNome" class="form-control" placeholder="Escolha um nome">                         
                                        <button type="submit" id="btnCadastraPasta" class="btn btn-primary topEstilizado" >Enviar</button>
                                    </form>
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- Fim Model --------------------------------------------------------------------------------------------------------------------->

            </div>
            <div class="col-sm-9" id="divConteudo">
                <div class="card" id="cardTituloConteudo">
                    <div class="card-header elementoNoCentro">
                        <h2 class="corSecundariaDoSistema">
                            <strong>Upload de arquivo</strong> 
                        </h2>
                    </div>
                    <div class="card-body elementoNoCentro">
                         <button class="btn btn-outline-primary btn-lg" data-toggle="modal" data-target="#modalUploadArquivos">
                             Novo
                            <span class="glyphicon glyphicon-upload "></span>
                         </button>       

                    </div>
                    <!-- Modal Cadastro ----------------------------------------------------------------------------------------------------------->
                    <div class="modal" id="modalUploadArquivos">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header textoBranco fundoSecundarioDoSistema">
                                    <h1 class="modal-title">Novo Conteúdo</h1>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body"> 
                                    <br>                       
                                    <form action="?r=/uploadConteudo" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="fk_pastCont" id="fk_pastCont" value="">
                                        <label for="arquivo">Escolha o arquivo</label>
                                        <input type="file" class="form-control-file" name="arquivo" id="arquivo">
                                        <button type="submit" class="btn btn-success topEstilizado" id="enviaArquivo" disabled>Enviar</button>
                                    </form>
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>  
                    <!-- Fim Model --------------------------------------------------------------------------------------------------------------------->
                </div>
                <!-- Table do conteúdo -->
                <table class="table table-hover table table-striped  topEstilizado">
                    <thead class="fundoSecundarioDoSistema textoBranco">
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col" class="elementoNaDireita" id="thConteudo">Opções</th>
                            </tr>
                    </thead>
                    <tbody id="tableConteudo">

                    </tbody>
                </table>
            </div>
        </div>


        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>
<script>
    $('.btnAltera').on("click",function(){
        var pastId = $('td:first', $(this).parents('tr')).text(); 
        document.getElementById('pastId').value = pastId;
    });

    //Desabilita botão se o arquivo não for selecionado
    function verificaMostraBotao(){
        $('input[type=file]').each(function(index){
            if ($('input[type=file]').eq(index).val() != ""){
                $('#enviaArquivo').removeAttr('disabled');
            }else{

            }
        }
    )};

    $('input[type=file]').on("change", function(){
        verificaMostraBotao();
    });

    //Função do ajax para alimentar a tabela de conteúdo
    $('.btnMenu').on("click",function(){
        var pastId = $('td:first', $(this).parents('tr')).text(); 
        document.getElementById('fk_pastCont').value = pastId;
        
        $.ajax({
            url:'/Ajax/exibeConteudo.php',
            type:'POST',
            data:{fk_pastCont:pastId},

            // Antes da requisição
            beforeSend: function(){
                
            },
            // Requisição bem sucedida
            success: function(data){
                $('#tableConteudo').html(data);
            }     
            // Falha na Requição
            ,error: function(data){
                alert("Erro ao carregar arquivos! Por favor, contate o responsável pelo sistema");
            }

        })

    });



</script>