<?php
//include_once('session.php');

 
//Conexão CRUD com o banco MySQL 
$dbHost = "localhost";
$dbUsuario = "root";
$dbPassword = ""; 
$db = "db_pst-backups_rms";

$conexao = new mysqli($dbHost,$dbUsuario,$dbPassword,$db) or die (mysqli_error());


//if ($conexao->connect_error) {
//  die("Connection failed: " . $conexao->connect_error);
//}
//echo "Connected successfully";


?>
