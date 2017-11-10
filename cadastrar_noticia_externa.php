<?php
include("validacao.php");
$usuario1 = explode('@', $_SESSION['UsuarioID'])[1];
$usuario = explode('.', $usuario1)[0];
$fonte = strtoupper($usuario);

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
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet"/>
    <link rel="stylesheet" href="css/jquery.Jcrop.css" type="text/css"/>
    <style>
        .modal-open {
            overflow-y: scroll;
        }

        html {
            min-height: 101%;
        }
    </style>
</head>
<body>


<section id="container" class="sidebar-closed" style="padding-left: 10%; padding-right: 10%">
    <!--header start-->
    <header class="header blue-bg" style="background-color: #00cccc">

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

        <section class="wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <i class="fa fa-check-square-o fa-1x"></i> <font size="3"><a href="index.php"><b>Voltar</b></a></font><br><br>
                        </header>
                        <div class="panel-body">
                            <div class="adv-table">
                                <div class="space15"></div>
                                <form id="cadastro" name="cadastro" method="POST" onsubmit="return false;"
                                      enctype="multipart/form-data">
                                    <!-- Início dos campos do formulário -->
                                    <div class="form-group">
                                        <h3>Titulo da notícia:</h3>
                                        <input required="true" id="titulo" type="text" class="form-control"
                                               name="titulo">
                                    </div>
                                    <div class="form-group">
                                        <h3>Link da notícia:</h3>
                                        <input required="true" id="endereco" type="text" class="form-control"
                                               name="endereco" size="60" maxlength="200">
                                    </div>
                                    <div>
                                        <h3>Imagem:</h3>
                                        <input name="img" accept="image/*" required="true" type="file" id="img"
                                               class="form-control" size="100" maxlength="200"/><br>
                                        <center><img id="imgmodal" class="img-responsive"></center>
                                    </div>
                                    <div>
                                        <input type="hidden" name="y" id="y"/>
                                        <input type="hidden" name="x" id="x"/>
                                        <input type="hidden" name="w" id="w"/>
                                        <input type="hidden" name="h" id="h"/>
                                        <br>
                                        <br>
                                        <button id="btnContinuar" style="" type="submit"
                                                class="btn btn-default pull-right">Continuar
                                        </button>
                                    </div>
                                </form>

                                <!-- Fim dos campos do formulário -->
                                <div id="modalDetalhes" class="modal fade top-modal-without-space" role="dialog">
                                    <div class="modal-dialog" style="min-width: 620px;">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;
                                                </button>
                                                <h4 class="modal-title">Pré-visualização</h4>
                                            </div>
                                            <form id="myFormEnviar" method="POST" enctype="multipart/form-data">
                                                <div class="modal-body" style="background-color: #f1f2f7;">
                                                    <section class="panel" style="position: relative;">
                                                        <div class="revenue-head9">
                                                            <h3><b>Notícias:</b></h3>
                                                        </div>
                                                        <div class="flat-carousal" style="background: white;">
                                                            <div id="owl-demo" class="owl-carousel owl-theme"
                                                                 style="min-height: 460px; max-width: 570px;">
                                                                <div class="text-center">
                                                                    <a id="enderecoVisualizar" target="_blank"><br>
                                                                        <span id="spanBr"></span>
                                                                        <center><img id="imgVisualizar"
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
                                                    Tamanho da imagem (%)
                                                    <input id="tamanhoImg" name="tamanho" class="form-control"
                                                           type="number" min="50" max="100" value="90"
                                                           style="width: 12%"/>
                                                    Distância do topo
                                                    <input id="espacoImg" class="form-control" type="number" min="0"
                                                           max="10" value="0" style="width: 12%"/>
                                                    <input type="hidden" name="espacos" id="espacosFrmEnviar"/>
                                                    <input type="hidden" name="titulo" id="tituloFrmEnviar"/>
                                                    <input type="hidden" name="endereco" id="enderecoFrmEnviar"/>
                                                    <input type="hidden" name="img" id="imgFrmEnviar"/>
                                                    <input type="hidden" name="action"
                                                           value="inserirExterna"/>
                                                </div>
                                                <div class="modal-footer">
                                                    <center><b>Deseja enviar esta notícia?</b><br><br>
                                                        <button id="cadastrar" name="cadastrar" type="submit"
                                                                class="btn btn-default">Enviar
                                                        </button>
                                                        <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Cancelar
                                                        </button>
                                                    </center>
                                                </div>
                                            </form>
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
<script src="js/jquery.Jcrop.min.js"></script>
<script>
    var fonte = "<?php echo $fonte; ?>";
    var jcrop_api;
    //initJcrop();
    function initJcrop() {
        $('#imgmodal').Jcrop({
            onRelease: function releaseCheck() {
                jcrop_api.setOptions({allowSelect: true});
            },
            onChange: showCoords,
            onSelect: showCoords,
            boxWidth: 500,
            minSize: [80, 80],
            maxSize: [0, 0]
        }, function () {
            jcrop_api = this;
            jcrop_api.animateTo([100, 100, 400, 300]);
        });
    }

    $("#img").change(function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById("imgmodal").src = e.target.result;
                initJcrop();
                if (jcrop_api !== undefined) {
                    jcrop_api.setImage(e.target.result);
                    jcrop_api.animateTo([100, 100, 400, 300]);
                }
            };
            reader.readAsDataURL(this.files[0]);
            return false;
        }
    });

    //Quando clica no botão continuar, a imagem inserida é enviada ao servidor, cortada, e retornado o nome da imagem cortada. Depois, é inserida no modal detalhes, junto oom título e link,
    //e o modal é exibido ao usuário com a pré-visualização da notícia
    $("#cadastro").submit(function () {
        $("#tituloVisualizar").html($("#titulo").val());
        $("#tituloFrmEnviar").val($("#titulo").val());
        $("#enderecoVisualizar").attr("href", $("#endereco").val());
        $("#enderecoFrmEnviar").val($("#endereco").val());
        $("#fonte").html("Fonte: " + fonte);
        xmlhttp = new XMLHttpRequest();
        fd = new FormData(this);
        var btnContinuar = $("#btnContinuar");
        btnContinuar.html("Aguarde...");
        btnContinuar.prop("disabled", true);
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4) {
                if (xmlhttp.status === 200) {
                    if (xmlhttp.responseText !== "erro") {
                        $("#imgVisualizar").attr("src", "croped/" + xmlhttp.responseText);
                        $("#imgFrmEnviar").val(xmlhttp.responseText);
                        $("#modalDetalhes").modal('show');
                    } else {
                        alert('Arquivo inválido. Verifique o formato ou o tamanho do arquivo.');
                    }
                } else {
                    alert('Desculpe, houve um erro no servidor.\n Código do erro: ' + xmlhttp.status);
                }
                btnContinuar.html("Continuar");
                btnContinuar.prop("disabled", false);
            }
        };
        xmlhttp.open("POST", "crop.php", true);
        xmlhttp.send(fd);
    });

    //Caso o usuário feche o modal de detalhes, a imagem que foi cortada anteriormente é apagada do servidor via requisição ajax
    $('#modalDetalhes').on('hidden.bs.modal', function (e) {
        xmlhttp = new XMLHttpRequest();
        fd = new FormData();
        fd.append("action", "apagarImagemTemp");
        xmlhttp.open("POST", "router.php", true);
        xmlhttp.send(fd);
    });

    // Quando for confirmado o envio da notícia, é feita a requisição ajax para cadastro e redirecionado para o index
    $("#myFormEnviar").submit(function (event) {
        event.preventDefault();
        var fd = new FormData(this);
        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4) {
                if (xmlhttp.status === 200) {
                    window.location = 'index.php';
                } else {
                    alert('Desculpe, houve um erro no servidor.\n Código do erro: ' + xmlhttp.status);
                }
            }
        };
        xmlhttp.open("POST", "router.php", true);
        xmlhttp.send(fd);
    });

    function showCoords(c) {
        document.getElementById("x").value = c.x;
        document.getElementById("y").value = c.y;
        document.getElementById("w").value = c.w;
        document.getElementById("h").value = c.h;
    }

    $('#endereco').change(function () {
        if (this.value.toLowerCase() === "Notícia interna".toLowerCase() ||
            this.value.toLowerCase() === "Noticia interna".toLowerCase()) {
            alert('Endereço inválido');
            this.value = "";
        }
    });

    $("#imgVisualizar").css("max-width",  $("#tamanhoImg").val() + "%");

    $("#tamanhoImg").change(function () {
        $("#imgVisualizar").css("max-width",  $("#tamanhoImg").val() + "%");
    });

    $(document).ready(function () {
        $(window).keydown(function (event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                return false;
            }
        });
    });

    $('#espacoImg').change(function () {
        var spanBr = document.getElementById('spanBr');
        var brs = '';
        for (var i = 0; i < this.value; i++) {
            brs = brs + '<br>';
        }
        $('#espacosFrmEnviar').val(brs);
        spanBr.innerHTML = brs;
    });

</script>

</body>
</html>