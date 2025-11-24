<?php
include "database.php";

$titulo = $_POST['titulo'];
$autor = $_POST['autor'];
$ano = $_POST['ano'];

$stmt = $db->prepare("INSERT INTO livros (titulo, autor, ano) VALUES (:t, :a, :n)");
$stmt->bindValue(":t", $titulo);
$stmt->bindValue(":a", $autor);
$stmt->bindValue(":n", $ano);

$stmt->execute();

header("Location: index.php");
exit();