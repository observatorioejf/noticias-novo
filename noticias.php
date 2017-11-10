<section class="panel">
    <div class="revenue-head9">
        <span><h3><b>Notícias:</b></h3></span>
    </div>
    <div class="flat-carousal">
        <div id="owl-demo2" class="owl-carousel owl-theme" style="height: 460px; max-width: 570px;">
            <?php
            include 'conn.php';
            mysqli_select_db($conn, "noticias") or die(mysqli_error($conn));
            $query = "SELECT * FROM tb_noticias WHERE ativada=true ORDER BY id DESC";
            $result = mysqli_query($conn, $query);

            while ($obj = mysqli_fetch_object($result)) {
                $usuario1 = explode('@', $obj->usuario)[1];
                $usuario = explode('.', $usuario1)[0];
                $fonte = strtoupper($usuario);
                $id = $obj->id;
                (int)$tamanho = $obj->tamanho_imagem;
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
                    . "	         <center><img src='Imagens/$foto' style='max-width: $tamanho%;' class=''></center>"
                    . "	         <br>"
                    . "	         <h1 style='margin-bottom: 5px'>$obj->titulo</h1><p style=' text-align: center; font-size: 90%; font-style: italic'>Fonte: $fonte</p>"
                    . "	     </a>"
                    . "	</div>"
                    . "</center>";
            }
            ?>
        </div>
    </div>
</section>