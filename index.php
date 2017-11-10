<?php
include("validacao.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gerenciador de notícias</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="css/font-awesome.css" rel="stylesheet"/>
    <link rel="stylesheet" href="css/DT_bootstrap.css"/>
    <!--toastr-->
    <link href="css/toastr.css" rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" href="css/owl.carousel.css" type="text/css">

    <!--right slidebar-->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet"/>
    <style>
        th, td {
            text-align: center;
        }

        .modal-open {
            overflow-y: scroll;
        }

        html {
            min-height: 101%;
        }

        #modal-dialog-interna {
            overflow-y: initial !important
        }

        #modal-body-interna {
            max-height: 490px;
            overflow-y: auto;
        }
    </style>
</head>
<?php
if (isset($_SESSION['imagemTemp'])) {
    unlink('croped/' . $_SESSION['imagemTemp']);
    unset($_SESSION['imagemTemp']);
}
?>
<body>
<section id="container" class="sidebar-closed" style="padding-left: 7%; padding-right: 7%">
    <!--header start-->
    <header class="header blue-bg" style="background-color: #00cccc;text-align: center">
        <!--logo start-->
        <a href="index.php" class="logo">
            <center>Gerenciamento de notícias</center>
        </a>
        <!--logo end-->
        <div class="top-nav ">
            <ul class="nav pull-right top-menu" style="margin-top: 7px">
                <div class="btn-group">
                    <a href="logout.php">
                        <button id="editable-sample_new" class="btn green">
                            Sair <i class="fa fa-reply-all"></i>
                        </button>
                    </a>
                </div>
            </ul>
        </div>
    </header>
    <!--header end-->
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper ">
            <!-- page start-->
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">

                            <div class="clearfix">
                                <div class="btn-group">
                                        <button id="ver-posts" class="btn btn-primary">
                                            Ver Posts <i class="fa fa-search-plus"></i>
                                        </button>
                                </div>
                                <div class="btn-group">
                                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"
                                            type="button">Criar Post <span class="caret"></span></button>
                                    <ul role="menu" class="dropdown-menu">
                                        <li><a href="cadastrar_noticia_externa.php">Com link externo</a></li>
                                        <li><a href="cadastrar_noticia_interna.php">Post interno</a></li>
                                    </ul>
                                </div>
                            </div>
                        </header>
                        <div class="panel-body">
                            <div class="adv-table">
                                <div class="space15"></div>
                                <table width="100%" class="display table table-bordered table-striped " id="example"
                                       data-order="[[ 4, &quot;desc&quot; ],[ 0, &quot;desc&quot; ]]">
                                    <thead>
                                    <tr align="center">
                                        <td width="6%"><b>ID</b></td>
                                        <td width="10%"><b>Data</b></td>
                                        <td><b>Título</b></td>
                                        <td><b>Endereço</b></td>
                                        <td width="8%"><b>Exibir</b></td>
                                        <td width="8%"><b>Mostrar no histórico</b></td>
                                        <td width="10%"><b>Operações</b></td>
                                    </tr>
                                    </thead>
                                </table>
                                <div id="modalEditarExterna" aria-hidden="true" aria-labelledby="myModalLabel"
                                     role="dialog" tabindex="-1" class="modal fade top-modal-without-space">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button aria-hidden="true" data-dismiss="modal" class="close"
                                                        type="button">×
                                                </button>
                                                <h4 class="modal-title">Editar post</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form id="frmEditarExterna" role="form" action="noticia_update.php"
                                                      method="post">
                                                    <input type="hidden" name="ativada" id="ativada"/>
                                                    <input type="hidden" name="id" id="id"/>
                                                    <input type="hidden" name="texto" value=""/>
                                                    <input type="hidden" name="action" value="alterar"/>
                                                    <div class="form-group">
                                                        <label for="titulo">Título da notícia</label>
                                                        <input type="text" class="form-control" name="titulo"
                                                               id="titulo">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="endereco">Endereço da notícia</label>
                                                        <input type="text" class="form-control" name="endereco"
                                                               id="endereco">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Exibir post</label>
                                                        <div class="btn-row">
                                                            <div class="btn-group" data-toggle="buttons">
                                                                <label class="btn btn-default option1">
                                                                    <input type="radio" onclick="ativa_sim()"
                                                                           name="ativada" id="option1" value="1"> Sim
                                                                </label>
                                                                <label class="btn btn-default option2">
                                                                    <input type="radio" onclick="ativa_nao()"
                                                                           name="ativada" id="option2" value="0"> Não
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="group-historico-externa" class="form-group">
                                                        <label>Exibir no histórico?</label>
                                                        <div class="btn-row">
                                                            <div class="btn-group" data-toggle="buttons">
                                                                <label class="btn btn-default option3">
                                                                    <input type="radio" onclick="ativa_sim()"
                                                                           name="exibir_historico" id="option3"
                                                                           value="1"> Sim
                                                                </label>
                                                                <label class="btn btn-default option4">
                                                                    <input type="radio" onclick="ativa_nao()"
                                                                           name="exibir_historico" id="option4"
                                                                           value="0"> Não
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-default">Alterar</button>
                                                        <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Fechar
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="modalEditarInterna" aria-hidden="true" aria-labelledby="myModalLabel"
                                     role="dialog" tabindex="-1" class="modal fade top-modal-without-space">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button aria-hidden="true" data-dismiss="modal" class="close"
                                                        type="button">×
                                                </button>
                                                <h4 class="modal-title">Editar post</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form id="frmEditarInterna" role="form" action="FuncoesNoticias.php"
                                                      method="post">
                                                    <input type="hidden" name="ativada" id="ativadaInterna"/>
                                                    <input type="hidden" name="id" id="idInterna"/>
                                                    <input type="hidden" name="endereco" id="enderecoInterna"/>
                                                    <input type="hidden" name="action" value="alterar"/>
                                                    <div class="form-group">
                                                        <label for="tituloInterna">Título do post</label>
                                                        <input type="text" class="form-control" name="titulo"
                                                               id="tituloInterna">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="texto">Texto:</label>
                                                        <textarea id="texto" class="form-control"
                                                                  name="texto" required></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Exibir post</label>
                                                        <div class="btn-row">
                                                            <div class="btn-group" data-toggle="buttons">
                                                                <label class="btn btn-default option1interna">
                                                                    <input type="radio" onclick="ativa_sim()"
                                                                           name="ativada" id="option1interna" value="1">
                                                                    Sim
                                                                </label>
                                                                <label class="btn btn-default option2interna">
                                                                    <input type="radio" onclick="ativa_nao()"
                                                                           name="ativada" id="option2interna" value="0">
                                                                    Não
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="group-historico-interna" class="form-group">
                                                        <label>Exibir no histórico?</label>
                                                        <div class="btn-row">
                                                            <div class="btn-group" data-toggle="buttons">
                                                                <label class="btn btn-default option3interna">
                                                                    <input type="radio" onclick="ativa_sim()"
                                                                           name="exibir_historico" id="option3interna"
                                                                           value="1"> Sim
                                                                </label>
                                                                <label class="btn btn-default option4interna">
                                                                    <input type="radio" onclick="ativa_nao()"
                                                                           name="exibir_historico" id="option4interna"
                                                                           value="0"> Não
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-default">Alterar</button>
                                                        <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Fechar
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="modalDetalhes" class="modal fade top-modal-without-space" role="dialog">
                                    <div class="modal-dialog" style="min-width: 620px;">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;
                                                </button>
                                                <h4 class="modal-title">Visualizar post</h4>
                                            </div>
                                            <div class="modal-body" style="background-color: #f1f2f7;">
                                                <section class="panel"
                                                         style="">
                                                    <div class="revenue-head9">
                                                        <h3><b>Notícias:</b></h3>
                                                    </div>
                                                    <div class="flat-carousal" style="background: white;">
                                                        <div id="owl-demo" class="owl-carousel owl-theme"
                                                             style="height: 460px; max-width: 570px;">
                                                            <div class="text-center">
                                                                <a id="enderecoVisualizar" target="_blank"
                                                                   class="enderecoNoticia"><br>
                                                                    <span id="spanBr"></span>
                                                                    <center><img id="imgVisualizar" src=""
                                                                                 class="img-responsive"/></center>
                                                                    <br>
                                                                    <h1 id="tituloVisualizar"
                                                                        style="font-size: 14pt;font-family: inherit;font-weight: 400;margin-bottom: 5px"></h1>
                                                                    <p id="fonte"
                                                                       style=' text-align: center; font-size: 90%; font-style: italic'></p>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>
                                                <form id="frmAlterarImg" class="form-horizontal"
                                                      enctype="multipart/form-data" role="form">
                                                    <div class="form-group">
                                                        <label class="col-lg-4 control-label" for="tamanhoImg">Tamanho
                                                            da imagem
                                                            (%):</label>
                                                        <input id="tamanhoImg" name="tamanho" class="form-control"
                                                               type="number" min="50" max="100" value="90"
                                                               style="width: 12%"/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-4 control-label" for="espacoImg">Distância
                                                            do topo:</label>
                                                        <input id="espacoImg" class="form-control" type="number" min="0"
                                                               max="10" value="0" style="width: 12%"/>
                                                        <input type="hidden" name="espacos" id="espacosFrmEnviar"/>
                                                        <input type="hidden" name="action"
                                                               value="alterarImagem"/>
                                                        <input type="hidden" name="id" id="idAlterarImg"/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-4 control-label"></label>
                                                        <button type="submit" class="btn btn-default">Alterar</button>
                                                    </div>

                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                                    Fechar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="modalExcluir" class="modal fade " role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;
                                                </button>
                                                <h4 class="modal-title">Excluir notícia</h4>
                                            </div>
                                            <form id="frmExcluir" role="form" method="POST">
                                                <input type="hidden" name="action" value="remover"/>
                                                <input type="hidden" name="img" id="img"/>
                                                <div class="modal-body">
                                                    <input type="hidden" name="id" id="idExcluir"/>
                                                    <center>Tem certeza que deseja excluir a notícia:<br><br> <b
                                                                id="tituloExcluir"></b>?
                                                    </center>
                                                </div>
                                                <div class="modal-footer">
                                                    <center>
                                                        <button type="submit" class="btn btn-default">Excluir</button>
                                                        <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Fechar
                                                        </button>
                                                    </center>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div id="modalNoticias" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;
                                                </button>
                                                <h4 class="modal-title">Visualização de notícias</h4>
                                            </div>
                                            <div class="modal-body" style="background: #f1f2f7;">
                                                <div style="clip: rect(0px,500px,480px,0px);margin-bottom: 0px;">
                                                    <span id="todas-noticias"></span>
                                                    <!--                                                    --><?php //include 'noticias.php';?>
                                                    <center>
                                                        <!--                                                        <iframe id="iframeNoticias" width="500px" height="480px"-->
                                                        <!--                                                                frameborder="0" src="noticias.php#noticia"-->
                                                        <!--                                                                scrolling="no"></iframe>-->
                                                    </center>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                                    Fechar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="modalNoticiaInterna" class="modal fade top-modal-without-space" role="dialog"
                                     style="">
                                    <div id="modal-dialog-interna" class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;
                                                </button>
                                                <h4 class="modal-title">Post</h4>
                                            </div>
                                            <div id="modal-body-interna" class="modal-body" style="padding: 40px">
                                                <center><h3 id="tituloNoticiaInterna"></h3><br>
                                                    <img id="imgNoticiaInterna" class="img-responsive" src=""
                                                         style="width: 80%;"/><br>
                                                    <p id="textoNoticiaInterna"></p></center>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                                    Fechar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <!--page end-->
        </section>
    </section>
    <!--main content end-->
</section>

<!-- js placed at the end of the document so the pages load faster -->
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" language="javascript"
        src="js/jquery.dataTables.min.js"></script>
<script src="ckeditor/ckeditor.js"></script>
<script src="js/owl.carousel.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.js"></script>
<!--toastr-->
<script src="js/toastr.js"></script>
<script src="js/toatrNoticias.js" type="text/javascript"></script>
<script src="js/date-euro.js"></script>

<?php
$messagesList = Array(
    "updateSucesso" => "<script>msgSucesso('Notícia atualizada com sucesso.','Sucesso')</script>",
    "updateErro" => "<script>msgErro('Houve um erro ao atualizar a notícia.','Erro')</script>",
    "deleteSucesso" => "<script>msgSucesso('Notícia excluída com sucesso.','Sucesso')</script>",
    "deleteErro" => "<script>msgErro('Houve um erro ao excluir a notícia.','Erro')</script>",
    "cadastroSucesso" => "<script>msgSucesso('Notícia cadastrada com sucesso.','Sucesso')</script>",
    "cadastroErro" => "<script>msgErro('Houve um erro ao inserir a notícia.','Erro')</script>"
);
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    echo $messagesList[$message];
    unset($_SESSION['message']);
}
?>

<script>
    //inicia o ckeditor
    CKEDITOR.replace('texto');

    //inicia a datatable, define as configurações, e carrega a tabela por meio do arquivo carregarNoticias.php, que retorna os dados em formato JSON
    var dataTable = $('#example').DataTable({
        "ajax": {
            "method": "POST",
            "url": "router.php",
            "data": {
                "action": "buscarTodos"
            }
        },
        "columns": [
            {"data": "id"},
            {"data": "data", "type": "date-euro"},
            {"data": "titulo"},
            {"data": "endereco"},
            {"data": "ativada"},
            {"data": "exibir_historico"},
            {"data": "operacoes"}
        ],
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "Não foram encontrados registros",
            "info": "Página _PAGE_ de _PAGES_",
            "infoEmpty": "Nenhum registro disponível",
            "infoFiltered": "(filtered from _MAX_ total records)"
        },
        responsive: true
    });


    //Caso o usuário clique em algum botão que tenha uma dessas classes, executa a função. Esses são os botões de
    //operações da tabela. A função pega o id do botão, que é igual ao id da notícia, busca a notícia por meio do ajax e
    //e preenche os modais de detalhes, edição e exclusão com as informações da notícia que foi clicada
    $(document).on('click', '.detalhes, .excluir, .editar-interna, .editar-externa', function () {
        var id = $(this).attr("id");
        var fd = new FormData();
        fd.append("action", "buscarPorId");
        fd.append("id", id);
        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4) {
                if (xmlhttp.status === 200) {
//                    console.log(xmlhttp.responseText);
                    var data = JSON.parse(xmlhttp.responseText);
                    preencherTodosOsCampos(data);
                } else {
                    alert('Desculpe, houve um erro no servidor.\n Código do erro: ' + xmlhttp.status);
                }
            }
        };
        xmlhttp.open("POST", "router.php", true);
        xmlhttp.send(fd);
    });

    function tratarBotoesNoticias(ativada, exibir_historico, tipo_noticia) {
        $(".active").removeClass('active');
        if (ativada == 1) {
            $('#group-historico-externa').hide();
            $('#group-historico-interna').hide();
            $("#option1" + tipo_noticia).prop("checked", true);

            $("label.option1" + tipo_noticia).addClass("active");
        }
        else {
            $('#group-historico-externa').show();
            $('#group-historico-interna').show();
            $("#option2" + tipo_noticia).prop("checked", true);
            $("label.option2" + tipo_noticia).addClass("active");
        }
        if (exibir_historico == 1) {
            $("#option3" + tipo_noticia).prop("checked", true);
            $("label.option3" + tipo_noticia).addClass("active");
        } else {
            $("#option4" + tipo_noticia).prop("checked", true);
            $("label.option4" + tipo_noticia).addClass("active");
        }
    }

    $("input[name=ativada]").change(function () {
//            alert("ativada "+this.value);
        $("#option3").prop("checked", true);
        $("#option3interna").prop("checked", true);
        $("label.option4").removeClass("active");
        $("label.option4interna").removeClass("active");
        $("label.option3").removeClass("active");
        $("label.option3interna").removeClass("active");
        if (this.value == 1) {
            $('#group-historico-externa').hide();
            $('#group-historico-interna').hide();


        } else {
            $('#group-historico-externa').show();
            $('#group-historico-interna').show();
        }
    });

    //Caso clique em um botão com a classe detalhes, o modal detalhes é aberto
    $(document).on('click', '.detalhes', function () {
        $("#modalDetalhes").modal('show');
    });

    //Caso clique em um botão com a classe editar-externa, o modal editar-externa é aberto
    $(document).on('click', '.editar-externa', function () {
        $("#modalEditarExterna").modal('show');
    });

    //Caso clique em um botão com a classe editar-interna, o modal editar-interna é aberto
    $(document).on('click', '.editar-interna', function () {
        $("#modalEditarInterna").modal('show');
    });

    //Caso clique em um botão com a classe excluir, o modal excluir é aberto
    $(document).on('click', '.excluir', function () {
        $("#modalExcluir").modal('show');
    });

    //Quando for enviado o formulário excluir, a requisição é feita por meio do ajax.
    $("#frmExcluir").submit(function (event) {
        event.preventDefault();
        var fd = new FormData(this);
        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4) {
                if (xmlhttp.status === 200) {
//                        console.log(xmlhttp.responseText);
                    var response = JSON.parse(xmlhttp.responseText);
                    if (response.code === '200')
                        msgSucesso("Excluído com sucesso.", "Sucesso");
                    else
                        msgErro("Houve um erro na solicitação.", "Erro");
                    //recarrega a tabela sem a necessidade de recarregar a página completa
                    dataTable.ajax.reload();
//                    document.getElementById("iframeNoticias").src = "noticias.php";
                    $("#modalExcluir").modal('hide');
                } else {
                    alert('Desculpe, houve um erro no servidor.\n Código do erro: ' + xmlhttp.status);
                }
            }
        };
        xmlhttp.open("POST", "router.php", true);
        xmlhttp.send(fd);
    });

    //Quando for enviado o formulário EditarExterna, a requisição é feita por meio do ajax.
    $("#frmEditarExterna").submit(function (event) {
        event.preventDefault();
        $("#texto").val(CKEDITOR.instances.texto.getData());
        var fd = new FormData(this);
        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4) {
                if (xmlhttp.status === 200) {
                    var response = JSON.parse(xmlhttp.responseText);
                    if (response.code === '200')
                        msgSucesso("Operação concluída com sucesso.", "Sucesso");
                    else
                        msgErro("Houve um erro na solicitação.", "Erro");
                    dataTable.ajax.reload();
//                    document.getElementById("iframeNoticias").src = "noticias.php";
                    $("#modalEditarExterna").modal('hide');
                } else {
                    alert('Desculpe, houve um erro no servidor.\n Código do erro: ' + xmlhttp.status);
                }
            }
        };
        xmlhttp.open("POST", "router.php", true);
        xmlhttp.send(fd);
    });

    //Quando for enviado o formulário EditarInterna, a requisição é feita por meio do ajax.
    $("#frmEditarInterna").submit(function (event) {
        event.preventDefault();
        $("#texto").val("" + CKEDITOR.instances.texto.getData() + "");
        var fd = new FormData(this);
        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4) {
                if (xmlhttp.status === 200) {
                    var response = JSON.parse(xmlhttp.responseText);
                    if (response.code === '200')
                        msgSucesso("Operação concluída com sucesso.", "Sucesso");
                    else
                        msgErro("Houve um erro na solicitação.", "Erro");
                    dataTable.ajax.reload();
//                    document.getElementById("iframeNoticias").src = "noticias.php";
                    $("#modalEditarInterna").modal('hide');
                } else {
                    alert('Desculpe, houve um erro no servidor.\n Código do erro: ' + xmlhttp.status);
                }
            }
        };
        xmlhttp.open("POST", "router.php", true);
        xmlhttp.send(fd);
    });

    //Quando for enviado o formulário AlterarImg, a requisição é feita por meio do ajax.
    $("#frmAlterarImg").submit(function (event) {
        event.preventDefault();
        var fd = new FormData(this);
        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4) {
                if (xmlhttp.status === 200) {
//                    console.log(xmlhttp.responseText);
                    var response = JSON.parse(xmlhttp.responseText);
                    if (response.code === '200')
                        msgSucesso("Operação concluída com sucesso.", "Sucesso");
                    else
                        msgErro("Houve um erro na solicitação.", "Erro");
                    dataTable.ajax.reload();
//                    document.getElementById("iframeNoticias").src = "noticias.php";
                } else {
                    alert('Desculpe, houve um erro no servidor.\n Código do erro: ' + xmlhttp.status);
                }
            }
        };
        xmlhttp.open("POST", "router.php", true);
        xmlhttp.send(fd);
    });

    //Quando o modalNoticiaInterna for aberto, o modal detalhes é fechado
    $('#modalNoticiaInterna').on('shown.bs.modal', function () {
        $("#modalDetalhes").modal('hide');
    });

    $('#modalNoticias').on('shown.bs.modal', function () {
//        document.getElementById("iframeNoticias").src = "noticias.php";
    });

    //Quando o valor do tamanho da imagem for alterado, muda o css também
    $("#tamanhoImg").change(function () {
        $("#imgVisualizar").css("max-width", this.value + "%");
    });

    $(document).ready(function () {
        $(window).keydown(function (event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                return false;
            }
        });
    });

    //Quando o valor do espaço da imagem for alterado, muda o css também
    $('#espacoImg').change(function () {
        var spanBr = document.getElementById('spanBr');
        var brs = '';
        for (var i = 0; i < this.value; i++) {
            brs = brs + '<br>';
        }
        $('#espacosFrmEnviar').val(brs);
        spanBr.innerHTML = brs;
    });

    function preencherTodosOsCampos(data) {
        if (data.endereco === "Notícia Interna") {
            $("#enderecoVisualizar").attr("href", "#modalNoticiaInterna");
            $("#enderecoVisualizar").attr("target", "_self");
            $("#enderecoVisualizar").attr("data-toggle", "modal");
            $("#tituloNoticiaInterna").html(data.titulo);
            $("#textoNoticiaInterna").html(data.texto);
            $("#imgNoticiaInterna").attr("src", "Imagens/" + data.nome_imagem);
            tratarBotoesNoticias(data.ativada, data.exibir_historico, "interna");
        } else {
            $("#enderecoVisualizar").attr("target", "_blank");
            $("#enderecoVisualizar").attr("href", data.endereco);
            tratarBotoesNoticias(data.ativada, data.exibir_historico, "");
        }
        $("#imgVisualizar").attr("src", "Imagens/" + data.nome_imagem);
        $("#imgVisualizar").css("max-width", data.tamanho_imagem + "%");
        $("#spanBr").html(data.espacos);
        $("#tituloVisualizar").html(data.titulo);
        $("#fonte").html('Fonte: ' + data.fonte);
        $("#ativada").val(data.ativada);
        $("#ativadaInterna").val(data.ativada);
        $("#titulo").val(data.titulo);
        $("#tituloInterna").val(data.titulo);
        $("#endereco").val(data.endereco);
        $("#idAlterarImg").val(data.id);
        $("#enderecoInterna").val(data.endereco);
        $("#tamanhoImg").val(data.tamanho_imagem);
        $("#espacosFrmEnviar").val(data.espacos);
        var a = $("#espacosFrmEnviar").val();
        var b = a.split('>');
        $("#espacoImg").val((b.length - 1)); //alert(a + "  " + (b.length - 1));
        CKEDITOR.instances['texto'].setData(data.texto);
        $("#id").val(data.id);
        $("#idInterna").val(data.id);
        $("#idExcluir").val(data.id);
        $("#img").val(data.nome_imagem);
        $("#tituloExcluir").html(data.titulo);
        $("#tituloInterna").html(data.titulo);
    }
</script>

<script>

    //owl carousel

    $(document).ready(function () {
        $("#owl-demo").owlCarousel({
            navigation: true,
            slideSpeed: 600,
            paginationSpeed: 600,
            singleItem: true,
            autoPlay: true

        });
    });

    //custom select box


    $(document).on('click', '.endereco-noticia-interna', function () {
        var user_id = $(this).attr("id");
        var fd = new FormData();
        fd.append("action", "buscarPorId");
        fd.append("id", user_id);
        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4) {
                if (xmlhttp.status === 200) {
                    var data = JSON.parse(xmlhttp.responseText);
                    $("#tituloNoticiaInterna").html(data.titulo);
                    $("#textoNoticiaInterna").html(data.texto);
                    $("#imgNoticiaInterna").attr("src", "Imagens/" + data.nome_imagem);
                    $('#modalNoticiaInterna').modal('show');
                } else {
                    alert('Desculpe, houve um erro no servidor.\n Código do erro: ' + xmlhttp.status);
                }
            }
        };
        xmlhttp.open("POST", "router.php", true);
        xmlhttp.send(fd);
    });

    $('#ver-posts').click(function () {
        $.ajax({
            url: 'noticias.php',
            type: 'GET',
            success: function (response) {
                $('#todas-noticias').html(response);
                $("#owl-demo2").owlCarousel({
                    navigation: true,
                    slideSpeed: 600,
                    paginationSpeed: 600,
                    singleItem: true,
                    autoPlay: true

                });
                $('#modalNoticias').modal('show');
            }, error: function () {
                console.log('erro');
            }
        });
    });

</script>
</body>
</html>