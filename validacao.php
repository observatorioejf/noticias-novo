<?php
if (!isset($_SESSION)) {
    session_start();
}
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/errors_log.txt');
error_reporting(E_ALL);

if (!isset($_SESSION['UsuarioID'])) {
    session_destroy();
    header("Location:login.php");
    exit;
}
