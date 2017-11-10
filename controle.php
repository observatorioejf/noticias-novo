<?php
if (!isset($_POST['login'])) {
    header("Location: login.php");
}

include 'conn.php';
mysqli_select_db($conn, "adm") or print_r(mysqli_error($conn));

$stmtConsulta = mysqli_prepare($conn, "select * from tb_noticias_usuario where login_usuario=? and senha_usuario=?");
$stmtConsulta->bind_param("ss", $login, $senha);

$login = $_POST['login'];
$senha = $_POST['senha'];

$stmtConsulta->execute();

$result = $stmtConsulta->get_result();


if ($result->num_rows != 0) {
    if (!isset($_SESSION)) {
        session_start();
    }
    $_SESSION['UsuarioID'] = $login;
	
	//Salva o log 
	$ip = $_SERVER['REMOTE_ADDR']; // Salva o IP do visitante
	$hora = date('Y-m-d H:i:s');
	$usuario = $_SESSION['UsuarioID'];
	$tabela = "-";
	$sistema = "Noticias";
	
	$mensagem = "Logon confirmado.";
	$mensagem = mysqli_real_escape_string($conn, $mensagem);
	
	mysqli_select_db($conn, "adm") or print(mysqli_error($conn));
	
	$sql = "INSERT INTO logs VALUES (NULL, '" . $hora . "', '" . $ip . "', '" . $mensagem . "', '" . $tabela . "', '" . $usuario . "', '" . $sistema . "')";
	mysqli_query($conn, $sql);
	
    echo true;
} else {
	//Salva o log 
	$ip = $_SERVER['REMOTE_ADDR']; // Salva o IP do visitante
	$hora = date('Y-m-d H:i:s');
	$usuario = $login;
	$tabela = "-";
	$sistema = "Noticias";
	
	$mensagem = "Falha no Logon.";
	$mensagem = mysqli_real_escape_string($conn, $mensagem);
	
	mysqli_select_db($conn, "adm") or print(mysqli_error($conn));
	
	$sql = "INSERT INTO logs VALUES (NULL, '" . $hora . "', '" . $ip . "', '" . $mensagem . "', '" . $tabela . "', '" . $usuario . "', '" . $sistema . "')";
	mysqli_query($conn, $sql);
	
    echo false;
}



