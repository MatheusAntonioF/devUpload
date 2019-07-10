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
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <!-- Arquivos para exibir/ocultar senhas-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>   
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-show-password/1.0.3/bootstrap-show-password.min.js"></script>

    <title>DevUpload</title>

  </head>
  <body>
    <!-- inicio da divIncial -->
    <div id="divInicial" class="col-sm-12">
        <!-- inicio do navBar -->
        <nav id="navBarInicial" class="navbar navbar-expand-sm fixed-top  " >
            <p id="navBarBrand" class="navbar-brand textoBranco">
                <span>Dev</span>Upload
            </p>  
            <div id="divNavBar" class="nav-item">
                <button type="button" class="btn btn-outline-primary" id="btnCadastro" data-toggle="modal" data-target="#modalCadastro">Cadastre-se</button>
            </div> 
        </nav>

        <!-- Modal Cadastro de usuário ----------------------------------------------------------------------------------------------------------------------->
        <div class="modal" id="modalCadastro">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header textoBranco fundoCorDoSistema">
                        <h4 class="modal-title">Cadastro</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <br>                        
                        <form action="?r=/cadastraUsuario" method="POST">
                            
                            <!-- Cadastro nome -->
                            <div class="col-sm-6">
                                <label for="userNomeCad" class="corDoSistema">Nome</label>
                                <input type="text" name="userNome" id="userNomeCad" class="form-control" placeholder="Seu nome..." >
                            </div>
                            <!-- Cadastro apelido -->
                            <div class="col-sm-6">
                                <label for="userApelidoCad" class="corDoSistema">Apelido</label>
                                <input type="text" name="userApelido" id="userApelidoCad" class="form-control" placeholder="Escolha uma apelido" >
                            </div>
                         
                            <!-- Cadastro Email -->
                            <div class="col-sm-12 topEstilizado">
                                <label for="userEmailCad" class="corDoSistema">Email</label>
                                <input type="email" name="userEmail" id="userEmailCad" class="form-control" placeholder="Digite seu email...">
                                <small>Será enviado uma mensagem de confirmação para seu email! Fique atento.</small>
                            </div>
                
                            <!-- Cadastro Senha -->
                            <div class="col-sm-12 topEstilizado">
                                <label for="userSenha" class="corDoSistema">Senha</label>
                                <input type="password" name="userSenha" id="userSenha" class="form-control" placeholder="Escolha uma senha" data-toggle="password">
                                <small>Fique tranquilo! Sua senha será criptografada.</small>
                            </div>
                            <div class="col-sm-5 topEstilizado">
                                <button type="submit" class="btn btn-success">Enviar</button>
                            </div>
                            
                        </form>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!--Fim model---------------------------------------------------------------------------------------------------------------------------- -->
        <div class="container elementoNoCentro" >  
            <img src="Imagens/devInicial.png" alt="" srcset="">
            <p>Development by Matheus Felipe Antonio</p>
        
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalLogin">Efetue Login</button>
        </div>
        <br>
    
        <?php 
            $mensagensExists = \DevUpload\Controller\IndexController::$mensagens;

            if(!is_null($mensagensExists)):
        ?>
        <div class="col-sm-4"></div>
        
        <div id="divErros" class="d-flex justify-content-center col-sm-4">
            
            <!-- Inicia Bloco php -->                    
            <?php 
                $mensagens = \DevUpload\Controller\IndexController::$mensagens;
                foreach($mensagens as $mensagem): ?>
    
                <p id="pErros" class="elementoNoCentro h4 ">
                    <strong>
                        Atenção: 
                        <?php echo $mensagem; ?>
                    </strong>
                </p>
                    
            <?php endforeach; ?>    
        </div>
        <div class="col-sm-4"></div>
        
        <?php
            endif;
        ?>    
        <br>
        <br><br>
        
        <!-- Modal Login ------------------------------------------------------------------------------------------------------------------------------------>
        <div class="modal" id="modalLogin">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header textoBranco fundoCorDoSistema">
                        <h4 class="modal-title">Login</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <br>
                        <form action="?r=/loginUsuario" method="POST">
                            <!-- Login Email -->    
                            <div class="input-group">
                                <label for="userEmail" class="corDoSistema">Email</label>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">@</div>
                                    <input type="email" name="userEmail" class="form-control" id="userEmail" placeholder="Email">
                                </div>                             
                            </div>
                            <br>
                            <!-- Login Senha -->
                            <div class="input-group">
                                <label for="userSenha" class="corDoSistema">Senha</label>
                                <input type="password" name="userSenha" class="form-control" id="userSenha" placeholder="Senha" data-toggle="password">
                                <div class="row">
                                    <div class="col-sm-7"></div>
                                    <div class="col-sm-5">
                                        <a href="http://" target="_blank" rel="noopener noreferrer">Esqueceu sua senha?</a>
                                    </div>
                                
                                </div>
                            </div>
                            <br>
                            <!-- Login Submit -->
                            <button type="submit" class="btn btn-success" id="btnLoginUsuario">Entrar</button>
                        </form>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fim model-------------------------------------------------------------------------------------------------------------------------------- -->
        <br>
        <br>
        
        <div class="container">
            <div class="row" id="divInfo">
                <div class="col-sm-5 elementoNoCentro textoBranco" id="coluna1">
                    <h3 class="corDoSistema">Tech usadas</h3>
                    <p>
                    Esse site foi desenvolvido com viés didático para aprendizado independente apenas.
                    Dentro das tecnologias usadas podem ser citadas o uso do PHP no back-end utlizado 
                    majoritariamente para gerenciar 
                    o site e suas requisições. No front-end foi utilizado HTML para a estruturação das páginas, 
                    juntamente com o framework Bootstrap para sua estilização e responsividade. Para deixar o site 
                    mais intuitivo foi utilizado JavaScript deixando o site mais interativo para o usuário.
                    </p>
                </div>
                <div class="col-sm-2">

                </div>
                <div class="col-sm-5 elementoNoCentro textoBranco" id="coluna2">
                    <h3 class="corDoSistema">Sobre o Site</h3>
                    <p>
                    Esse site tem como funcionalidades armazenar pastas e arquivos criados pelo usuário 
                    por meio do upload de arquivos. Para ter acesso as funcionalidades é necessário realizar login padrão, 
                    possuindo também a funcionalidade de cadastro para novos usuários. A Exibição das pastas e arquivos são 
                    feitas através de tabelas estilizadas para um maior entendimento do usuário. Tal funcionalidade foi
                    baseada no site do Google Drive onde todas essas funcionalidades podem ser encontradas.
                    </p>
                </div>
            </div>
        </div>
   </div>

    <!--Script auxiliar para ocultar/exibir senhas-->
    <script type="text/javascript">
        $("#userSenha").password('toggle');
        $("#senhaLogin").password('toggle');
    </script>
  </body>
</html>
   