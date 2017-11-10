<!doctype html>
<html>
    <head>
        <!-- Bootstrap core CSS 
        <link href="http://getbootstrap.com/dist/css/bootstrap.css" rel="stylesheet" /> -->
        <style>
            .modal-open {
                overflow-y: scroll;
            }
            html {
                min-height: 101%;
            }
            #modal-dialog-interna{
                overflow-y: initial !important
            }
            #modal-body-interna{
                max-height: 500px;
                overflow-y: auto;
            }
        </style>
    </head>
    <body>
        <section class="panel" >
            <div class="revenue-head9">
                <span><h3><b>Notícias:</b></h3></span>
                <a href="historico_noticias.php" class="pull-right" style="color: #ccffff; text-decoration: underline;margin-right: 3%;">Histórico</a>
            </div>
            <div class="flat-carousal">
                <div id="owl-demo" class="owl-carousel owl-theme" style="height: 420px">
                    <?php
                    if (mysqli_select_db($conn, "noticias")) {
                        $query = "SELECT * FROM tb_noticias WHERE ativada=true ORDER BY id DESC";
                        $result = mysqli_query($conn, $query);

                        while ($obj = mysqli_fetch_object($result)) {
//                            $usuario = substr((explode('@', $obj->usuario))[1] , 0,3);
//                            $fonte = ($usuario == 'cjf') ? strtoupper($usuario) : strtoupper(substr((explode('@', $obj->usuario))[1] , 0,4));

                            $usuario1 = explode('@', $obj->usuario)[1];
                            $usuario = explode('.', $usuario1)[0];
                            $fonte = strtoupper($usuario);
                            $id = $obj->id;
                            (int) $tamanho = $obj->tamanho_imagem;
                            $foto = $obj->nome_imagem;
                            if ($obj->endereco == "Notícia Interna") {
                                $endereco = "<a href ='#modalNoticiaInterna' data-toggle='modal' class='endereco-noticia-interna' id='$id' >"; #modalNoticiaInterna";
                            } else
                                $endereco = "<a href ='$obj->endereco' target = '_blank' class='enderecoNoticia'>";
                            echo ""
                            . "<center>"
                            . "	<div class = 'text-center' >"
                            . "	     $endereco<br>"
                            . "	     $obj->espacos"
                            . "	         <center><img src='sistemas/noticias/Imagens/$foto' style='max-width: $tamanho%;' class=''></center>"
                            . "	         <br>"
                            . "	         <h1 style='margin-bottom: 5px'>$obj->titulo</h1><p style=' text-align: center; font-size: 90%; font-style: italic'>Fonte: $fonte</p>"
                            . "	     </a>"
                            . "	</div>"
                            . "</center>";
                        }
                    } else {
                        echo ""
                        . "<center>"
                        . "	<div class = 'text-center' >"
                        . "	     <br><br><br>"
                        . "	         <center><img src='img/em_atualizacao.jpg' class='img-responsive'></center>"
                        . "	         <br>"
                        . "	         <h1><h1>"
                        . "	     "
                        . "	</div>"
                        . "</center>";
                    }
                    ?>
                </div>
            </div>
        </section>

        <div id="modalNoticiaInterna" class="modal fade top-modal-without-space" role="dialog" >                                              
            <div id="modal-dialog-interna" class="modal-dialog" style="width: 38%">                                                                      
                <div class="modal-content">                                                                 
                    <div class="modal-header">                                                              
                        <button type="button" class="close" data-dismiss="modal">&times;</button>           
                        <h4 class="modal-title">Notícia</h4>                                           
                    </div>  
                    <div id="modal-body-interna" class="modal-body" style="padding: 40px">                                                         
                        <center> <h3 id="tituloNoticiaInterna"></h3><br>
                            <img id="imgNoticiaInterna" class = "img-responsive" style="max-width: 75%;"/><br>
                            <p id="textoNoticiaInterna"></p></center>
                    </div>                                                                              
                    <div class="modal-footer">                                                          
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>   
                    </div>
                </div>                                                                                      
            </div>                                                                                          
        </div>
        <!--script for this page only (MODAL)-->
        <script src="js/gritter.js" type="text/javascript"></script>
        <script src="js/pulstate.js" type="text/javascript"></script>
        <script>

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

        </script>
    </body>
</html>