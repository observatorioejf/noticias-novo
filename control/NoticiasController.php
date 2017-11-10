<?php
if (!isset($_SESSION)) {
    session_start();
}

class NoticiasController {
    private $conn;
    private $mensagem;
    private $data;

    public function __construct($conn, $data) {
        $this->data = $data;
        $this->conn = $conn;
        mysqli_select_db($this->conn, "noticias");
    }

    function buscarTodos() {
        $stmt = mysqli_prepare($this->conn, "SELECT * FROM tb_noticias");
        $stmt->execute();
        $result = $stmt->get_result();
        return $this->ajustarNoticiasParaTabela($result);
    }

    function buscarPorId() {
        $id = $this->data['id'];
        $stmt = mysqli_prepare($this->conn, "SELECT * FROM tb_noticias WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $noticia = $result->fetch_assoc();
        $usuario1 = explode('@', $noticia['usuario'])[1];
        $usuario = explode('.', $usuario1)[0];
        $fonte = strtoupper($usuario);
        $noticia['fonte'] = $fonte;

        return (json_encode($noticia));
    }

    function alterar() {
       // $this->data['titulo'], $this->data['endereco'], $this->data['texto'], $this->data['ativada'], $this->data['exibir_historico'], $this->data['id']
        $titulo = $this->data['titulo'];
        $endereco = $this->data['endereco'];
        $texto =  $this->data['texto'];
        $ativada = $this->data['ativada'];
        $exibir_historico = $this->data['exibir_historico'];
        $id = $this->data['id'];
        $stmt = mysqli_prepare($this->conn, "UPDATE tb_noticias SET titulo=?, endereco=? , texto=?, ativada=?, exibir_historico=? WHERE id=?");
        $stmt->bind_param("sssiii", $titulo, $endereco, $texto, $ativada, $exibir_historico, $id);
        $result = $stmt->execute();

        $this->prepararMensagemLogAlterar($id, $titulo, $endereco, $ativada, $texto, $exibir_historico);
        $this->log_noticia();

        if ($result)
            return '{"code":"200", "message":"Ok"}';
        else
            return '{"code":"400", "message":"Bad request"}';
    }

    function alterarImagem() {
        //$this->data['tamanho'], $this->data['espacos'], $this->data['id']
        $tamanho = $this->data['tamanho'];
        $espacos = $this->data['espacos'];
        $id = $this->data['id'];
        $stmt = mysqli_prepare($this->conn, "UPDATE tb_noticias SET tamanho_imagem=?, espacos=? WHERE id=?");
        $stmt->bind_param("ssi", $tamanho, $espacos, $id);
        $result = $stmt->execute();
        if ($result)
            return '{"code":"200", "message":"Ok"}';
        else
            return '{"code":"400", "message":"Bad request"}';
    }

    function apagarImagemTemp(){
        try {
            unlink('croped/' . $_SESSION['imagemTemp']);
            unset($_SESSION['imagemTemp']);
            return '{"code":"200", "message":"Ok"}';
        } catch (exception $e){
            return '{"code":"400", "message":"Bad request"}';
        }
    }

    function inserirExterna() {
        //$this->data['endereco'], $this->data['titulo'], $this->data['img'], $this->data['tamanho'], $this->data['espacos'], $_SESSION['UsuarioID']
        $endereco = $this->data['endereco'];
        $titulo = $this->data['titulo'];
        $nome_imagem = $this->data['img'];
        $tamanho_imagem = $this->data['tamanho'];
        $espacos = $this->data['espacos'];
        $usuario = $_SESSION['UsuarioID'];
        $hora = date('Y-m-d H:i:s');
        $stmt = mysqli_prepare($this->conn, "INSERT INTO tb_noticias (endereco, titulo, nome_imagem, tamanho_imagem, ativada, espacos, data, usuario) VALUES (?,?,?,?,true,?,?,?)");
        $stmt->bind_param("sssssss", $endereco, $titulo, $nome_imagem, $tamanho_imagem, $espacos, $hora, $usuario);
        $result = $stmt->execute();

        $this->mensagem = mysqli_real_escape_string($this->conn, "Inserção <br> titulo = $titulo, nome_imagem = $nome_imagem, tamanho_imagem = $tamanho_imagem, espacos = $espacos.");
        if($result)
            $this->log_noticia();

        if ($result) {
            rename('croped/' . $this->data['img'], 'Imagens/' . $this->data['img']);
            unset($_SESSION['imagemTemp']);
            $_SESSION['message'] = "cadastroSucesso";
            return '{"code":"200", "message":"Ok"}';
        }
        else {
            unlink('croped/' . $_SESSION['imagemTemp']);
            unset($_SESSION['imagemTemp']);
            $_SESSION['message'] = "cadastroErro";
            return '{"code":"400", "message":"Bad request"}';
        }
    }

    function inserirInterna() {
        //$this->data['titulo'], $this->data['img'], $this->data['tamanho'], $this->data['texto'], $this->data['espacos'], $_SESSION['UsuarioID']
        $titulo = $this->data['titulo'];
        $nome_imagem = $this->data['img'];
        $tamanho_imagem = $this->data['tamanho'];
        $texto = $this->data['texto'];
        $espacos = $this->data['espacos'];
        $usuario = $_SESSION['UsuarioID'];
        $hora = date('Y-m-d H:i:s');
        $stmt = mysqli_prepare($this->conn, "INSERT INTO tb_noticias (endereco, titulo, nome_imagem, tamanho_imagem, texto, ativada, espacos, data, usuario) VALUES ('Notícia Interna',?,?,?,?,true,?,?,?)");
        $stmt->bind_param("sssssss", $titulo, $nome_imagem, $tamanho_imagem, $texto, $espacos, $hora, $usuario);
        $result = $stmt->execute();

        $this->mensagem = mysqli_real_escape_string($this->conn, "Inserção  <br> titulo = $titulo, nome_imagem = $nome_imagem, tamanho_imagem = $tamanho_imagem, texto = $texto, espacos = $espacos..");
        if($result)
            $this->log_noticia();

        if ($result) {
            rename('croped/' . $this->data['img'], 'Imagens/' . $this->data['img']);
            unset($_SESSION['imagemTemp']);
            $_SESSION['message'] = "cadastroSucesso";
            return '{"code":"200", "message":"Ok"}';
        }
        else {
            unlink('croped/' . $_SESSION['imagemTemp']);
            unset($_SESSION['imagemTemp']);
            $_SESSION['message'] = "cadastroErro";
            return '{"code":"400", "message":"Bad request"}';
        }
    }

    function remover() {
        $id = $this->data['id'];
        $img = $this->data['img'];
        $stmt = mysqli_prepare($this->conn, "DELETE FROM tb_noticias WHERE id=?");
        $stmt->bind_param("i", $id);

        $querySelect = ("select * from tb_noticias where id=$id");
        $select = mysqli_query($this->conn, $querySelect);
        $obj = mysqli_fetch_object($select);

        $titulo = $obj->titulo;
        $endereco = $obj->endereco;
        $texto= $obj->texto;

        $this->mensagem = mysqli_real_escape_string($this->conn, "Remoção ID = $id <br> titulo = $titulo, endereco = $endereco, texto = $texto.");

        $result = $stmt->execute();

        if($result)
            $this->log_noticia();

        if ($result) {
            unlink('Imagens/' . $img);
            return '{"code":"200", "message":"Ok"}';
        }
        else
            return '{"code":"400", "message":"Bad request"}';
    }

    function log_noticia(){
        //Dados do Sistema:
        $ip = $_SERVER['REMOTE_ADDR']; // Salva o IP do visitante
        $hora = date('Y-m-d H:i:s');
        $usuario = $_SESSION['UsuarioID'];
        $tabela = "noticias.tb_noticias";
        $sistema = "Noticias";

        mysqli_select_db($this->conn, "adm");
        $sql = "INSERT INTO logs VALUES (NULL, '" . $hora . "', '" . $ip . "', '" . $this->mensagem . "', '" . $tabela . "', '" . $usuario . "', '" . $sistema . "')";
        mysqli_query($this->conn, $sql);
    }

    function ajustarNoticiasParaTabela($resultado){
        $rows = Array();
        while ($obj = $resultado->fetch_assoc()) :
            $date = date("d/m/Y H:i:s", strtotime($obj['data']));
            $noticias['data'] = $date;
            $noticias['id'] = $obj['id'];
            $noticias['titulo'] = $obj['titulo'];
            if($obj['endereco'] == "Notícia Interna"){
                $classEditar = "editar-interna";
            } else {
                $classEditar = "editar-externa";
            }
            $noticias['endereco'] = $obj['endereco'];
            $noticias['ativada'] = ($obj['ativada'] !== 0) ? "Sim" : "Não";
            $noticias['exibir_historico'] = ($obj['exibir_historico'] !== 0) ? "Sim" : "Não";
            $noticias['operacoes'] = '<button title="Ver" id="'.$obj['id'].'" type ="button" class="btn btn-primary btn-xs detalhes"><i class="fa fa-search-plus"></i></button>&nbsp;' .
                '<button title="Editar" id="'.$obj['id'].'" type ="button" class="btn btn-primary btn-xs '.$classEditar.'"><i class="fa fa-pencil"></i></button>&nbsp;' .
                '<button title="Excluir" id="'.$obj['id'].'" type ="button" class="btn btn-primary btn-xs excluir"><i class="fa fa-times"></i></button>';
            $rows["data"][] = $noticias;
        endwhile;

        return json_encode($rows);
    }

    function prepararMensagemLogAlterar($id, $titulo, $endereco, $ativada, $texto, $exibir_historico){
        $querySelect = ("select * from tb_noticias where id=$id");
        $select = mysqli_query($this->conn, $querySelect);
        $obj = mysqli_fetch_object($select);

        $titulo_antigo = $obj->titulo;
        $endereco_antigo = $obj->endereco;
        $ativada_antigo = $obj->ativada;
        $texto_antigo = $obj->texto;
        $historico_antigo = $obj->exibir_historico;


        $this->mensagem = "Alterações ID = $id ";

        if ($titulo != $titulo_antigo)
            $this->mensagem .= "<br> titulo = $titulo_antigo, para titulo = $titulo";

        if ($endereco != $endereco_antigo)
            $this->mensagem .= "<br> endereco = $endereco_antigo, para endereco = $endereco";

        if ($ativada != $ativada_antigo)
            $this->mensagem .= "<br> ativada = $ativada_antigo, para ativada = $ativada";

        if ($texto != $texto_antigo)
            $this->mensagem .= "<br> texto = $texto_antigo, para texto = $texto";
        if ($exibir_historico != $historico_antigo)
            $this->mensagem .= "<br> exibir_historico = $historico_antigo, para exibir_historico = $exibir_historico";

        $this->mensagem .= ".";
        $this->mensagem = mysqli_real_escape_string($this->conn, $this->mensagem);
    }

}