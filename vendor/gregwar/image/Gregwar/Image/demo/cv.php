<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

$connection = mysqli_connect('perdiz-d', 'u_danilo', 'u_danilo');

mysqli_select_db($connection, 'test');

$result = mysqli_query($connection, "select teste from tbl_noticias");

//var_dump($result);

$v = (int) mysqli_fetch_assoc($result)['teste'];

//var_dump($v);

$v2 = $v + 1;

mysqli_query($connection, "update tbl_noticias set teste = $v2 where id = 1");

