<?php 
    $pdo = new PDO('mysql:host=localhost;dbname=cms','root','');
    $sobre = $pdo->prepare("SELECT * FROM `tb_sobre`");
    $sobre->execute();
    $sobre = $sobre->fetch()['sobre'];

    $caminho_img = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'img/';
?>
<!doctype html>
<html lang="pt-br">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="css/style.css">

    <title>Painel frontender</title>
</head>

<body>
    <nav class="navbar navbar-fixed-top navbar-default">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Papagaio Team</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul id="menu-principal" class="nav navbar-nav">
                    <li class="li active"><a href="#" ref_sys="sobre">Editar Sobre</a></li>
                    <li class="li"><a href="#about" ref_sys="cadastrar_equipe">Cadastrar Equipe</a></li>
                    <li class="li"><a href="#contact" ref_sys="lista_equipe">Gerenciar Equipe</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="?sair"><span class="glyphicon glyphicon-off"></span> Sair!</a></li>
                </ul>
            </div>
        </div>
    </nav>

<div style="position:relative;top:50px;" class="box">
    <header id="header">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <h2><span class="glyphicon glyphicon-cog"></span>Painel de controle</h2>
                </div>
                <div class="col-md-3">
                    <p><span class="glyphicon glyphicon-time"></span> Seu ultimo login foi em: 12/06/2018</p>
                </div>
            </div>
        </div>
    </header>

    <section class="bread">
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="#">Equipe</a></li>
                <li><a href="">Sobre</a></li>
                <li><a href="#">Gerenciar</a></li>
            </ol>
        </div>
    </section>
    <section class="principal">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="list-group">
                        <a href="" class="list-group-item  active cor-padrao" ref_sys="sobre"><span class="glyphicon glyphicon-pencil "></span> Sobre</a>
                        <a href="" class="list-group-item" ref_sys="cadastrar_equipe"><span class="glyphicon glyphicon-pencil"></span> Cadastrar Equipe</a>
                        <a href="" class="list-group-item" ref_sys="lista_equipe"><span class="glyphicon glyphicon-list-alt"></span> Lista Equipe</a>
                    </div>
                </div>
                <div class="col-md-9">
                    <?php 
                        if (isset($_POST['editar_sobre'])){
                            $sobre = $_POST['sobre'];
                            $pdo->exec("DELETE FROM `tb_sobre`");
                            $sql = $pdo->prepare("INSERT INTO `tb_sobre` VALUES (null,?)");
                            $sql->execute(array($sobre));
                            $sobre = $pdo->prepare("SELECT * FROM `tb_sobre`");
                            $sobre->execute();
                            $sobre = $sobre->fetch()['sobre'];
                            echo '<div class="alert alert-success" role="alert">O campo <b>Sobre<b> foi editado com sucesso!</div> ';
                        }else if(isset($_POST['cadastrar_equipe'])){
                            $nome = $_POST['nome'];
                            $descricao = $_POST['descricao'];
                            $imagem = $caminho_img.$_POST['url_imagem'];
                            $sql = $pdo->prepare("INSERT INTO `tb_equipe` VALUES (null,?,?,?)");
                            $sql->execute(array($nome, $descricao, $imagem));
                            echo '<div class="alert alert-success" role="alert">O campo <b>Equipe<b> foi editado com sucesso!</div> ';

                        }

                     ?>
                    <div id="sobre_section" class="panel panel-default">
                        <div class="panel-heading cor-padrao">
                            <h3 class="panel-title">Sobre</h3>
                        </div>
                        <div class="panel-body">
                            <form method="post">
                                <div class="form-group">
                                    <label for="code">Código HTML:</label>
                                    <textarea name="sobre" style="height: 240px;resize: vertical;" class="form-control"><?php echo $sobre; ?></textarea>
                                </div>
                                <input type="hidden" name="editar_sobre" value="">
                                <button type="submit" name="acao" class="btn btn-default cor-padrao">Salvar</button>
                            </form>
                        </div>
                    </div>

                    <div  id="cadastrar_equipe_section" class="panel panel-default">
                        <div class="panel-heading cor-padrao">
                            <h3 class="panel-title">Cadastrar Equipe</h3>
                        </div>
                        <div class="panel-body">
                            <form method="post">
                                <div class="form-group">
                                    <label for="nome">Nome do membro:</label>
                                    <input type="text" name="nome" class="form-control">
                                    <label for="url_imagem">Nome da imagem (upada em <b>/img</b>):</label>
                                    <input type="text" name="url_imagem" class="form-control">
                                    <label for="code">Descrição do membro:</label>
                                    <textarea name="descricao" style="height: 140px;resize: vertical;" class="form-control"></textarea>
                                </div>
                                <input type="hidden" name="cadastrar_equipe">
                                <button type="submit" class="btn btn-default cor-padrao">Salvar</button>
                            </form>
                        </div>
                    </div>

                    <div  id="lista_equipe_section" class="panel panel-default">
                        <div class="panel-heading cor-padrao">
                            <h3 class="panel-title">Membros da equipe</h3>
                        </div>
                        <div class="panel-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID:</th>
                                        <span class="vertical-divider"></span>
                                        <th>Nome do membro:</th>
                                        <span class="vertical-divider"></span>
                                        <th>Ação:</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $selecionarMembros = $pdo->prepare("SELECT `id`,`nome` FROM `tb_equipe`");
                                        $selecionarMembros->execute();
                                        $membros = $selecionarMembros->fetchAll();
                                        foreach($membros as $key=>$value){ 
                                     ?>
                                    <tr>
                                      <th><?php print $value['id']; ?></th>
                                      <th><?php print $value['nome']; ?></th>
                                      <th><button id_membro="<?php print $value['id']; ?>" type="submit" class="deletar-membro btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Excluir</button></th>
                                    </tr>
                                <?php } ?>
                                    <!-- <tr>
                                        <th>2</th>
                                        <th>duardin</th>
                                        <th><button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Excluir</button></th>
                                    </tr>
                                    <tr>
                                        <th>3</th>
                                        <th>roquero maluco</th>
                                        <th><button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Excluir</button></th>
                                    </tr> -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>
<br>
<br>
<br>
<br>
<br>
    <!-- Footer -->
    <footer class="page-footer text-center">
        <!-- Footer Elements -->
        <div class="container">
            <!-- Grid row-->
            <div class="row">
                <!-- Grid column -->
                <div class="col-md-12 py-5">
                    <div class="mb-5 flex-center">
                        <!-- Facebook -->
                        <a class="fb-ic" href="https://www.facebook.com/eduardo.santosd" target="_blank">
                            <i class="fab fa-facebook-f fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
                        </a>
                        <!-- Twitter -->
                        <a class="tw-ic" href="https://twitter.com/ricoeduardo_" target="_blank">
                            <i class="fab fa-twitter fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
                        </a>
                        <!--Linkedin -->
                        <a class="li-ic" href="https://www.linkedin.com/in/eduardosantos22/" target="_blank">
                            <i class="fab fa-linkedin-in fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
                        </a>
                        <!--Instagram-->
                        <a class="ins-ic" href="https://www.instagram.com/_richeduard/" target="_blank">
                            <i class="fab fa-instagram fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
                        </a>
                    </div>
                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row-->
        </div>
        <!-- Footer Elements -->
        <!-- Copyright -->
        <div class="footer-copyright text-center py-3">© 2019 Copyright: Rico_Eduardo
        </div>
        <!-- Copyright -->
    </footer>
    </div> <!-- div box -->
    
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>

    <script src="js/bootstrap.js"></script>
    <script src="js/main.js"></script>
</body>

</html>