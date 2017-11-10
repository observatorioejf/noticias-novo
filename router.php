<?php

include_once 'conn.php';
include_once 'control/NoticiasController.php';

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_POST))
    header("Location: index.php");


//Pega qual ação foi solicitada
$action = $_POST['action'];

//Cria uma instância da classe de controle passando a conexão e os dados que foram recebidos no post
$noticiasController = new NoticiasController($conn, $_POST);

//Chama a função que veio na requisição e retorna a resposta
echo $noticiasController->$action();