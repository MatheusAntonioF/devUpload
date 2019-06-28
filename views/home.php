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

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        
        <!-- Jquery -->
        <script type="text/javascript" src="Jquery/jquery.js"></script>

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
                        $userEmail = $_SESSION['userEmail'];
                        
                        $usuarioModel = (new UsuarioModel)->retornaUsuario($userEmail);
                        
                        $userNome = $usuarioModel->getUserNome();
                        
                        echo $userNome;
                    ?>                    
                </p>
                <div class="elementoNoCentro">
                    <button id="btnNovo" class="elementoNoCentro btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#modalCadastroArquivos">
                        NOVO
                    </button>
                </div>
                <!-- Modal Cadastro -->
                <div class="modal" id="modalCadastroArquivos">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header textoBranco fundoCorDoSistema">
                                <h4 class="modal-title">Nova Pasta</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body"> 
                                <br>                       
                                <form action="?r=/cadastraPasta" method="post">
                                    <!-- Cadastro Nome -->
                                    <label for="inputPastNome" class="corDoSistema">Nome</label>
                                    <input type="text" name="pastNome" id="inputPastNome" class="form-control" placeholder="Escolha um nome">                         
                                    <button type="submit" class="btn btn-primary topEstilizado">Enviar</button>

                                </form>
                            </div>
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    use DevUpload\Model\PastaModel;

                    $pasta = new PastaModel();

                    $pastas = $pasta->retornaTodasAsPastas();
                    var_dump($pastas);
                ?>
                

            </div>
            <div class="col-sm-9" id="divConteudo">

            </div>
        </div>


        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>
<!-- <script>
    // Função que será executada quando option de estado por selecionada
    $("#inputUserEstado").on("click",function(){
        // busca valor de input
        var idEstado = $("#inputUserEstado").val();
        
        $.ajax({
            url:'/Ajax/retornaCidades.php',
            type:'POST',
            data:{id:idEstado},

            // Antes da requisição
            beforeSend: function(){
                $("#divCidade").css({'display':'block'});
                $("#userCidades").html("Carregando...");
            },

            // Requisição bem sucedida
            success: function(data){
                $("#divCidade").css({'display':'block'});
                $("#userCidades").html(data);
            }
            
            // Falha na Requição
            ,error: function(data){
                $("#divCidade").css({'display':'block'});
                $("#userCidades").html("Erro ao carregar cidades! Por favor, contate o responsável pelo sistema.");
            }
        })


    });
</script> -->