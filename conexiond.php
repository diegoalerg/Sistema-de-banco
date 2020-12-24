<?php
$host = '127.0.0.1.'; //IP del servidor
$db = 'banco';      //Base de datos
$port = 3306;         //Puerto
$charset = 'utf8';  //Set de caracteres

$dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=$port";

$user = 'root';
$pass ='';

//Opciones de configuracion
$opt = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,

];

//Instancia de PDO.
$pdo = new PDO($dsn, $user, $pass, $opt);


?>