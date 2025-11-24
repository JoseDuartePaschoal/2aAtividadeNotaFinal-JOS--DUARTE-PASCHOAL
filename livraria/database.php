<?php

$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "livraria";

$con = mysqli_connect($host, $usuario, $senha, $banco);

if (!$con) {
    die("Erro ao conectar: " . mysqli_connect_error());
}
?>