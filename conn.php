<?php
/*
 * 
$host = "perdiz-d";
$user = "u_danilo";
$pass = "u_danilo";
$banco = "test";
 * 
 */
$host = "localhost";
$user = "root";
$pass = "";
$banco = "test";

$conn = mysqli_connect($host, $user, $pass) or die(mysqli_error($conn));
//mysqli_select_db($conn, $banco) or die(mysqli_error($conn));


//include '../conn.php';


mysqli_query($conn,"SET NAMES 'utf8'");
mysqli_query($conn,'SET character_set_connection=utf8');
mysqli_query($conn,'SET character_set_client=utf8');
mysqli_query($conn,'SET character_set_results=utf8');

