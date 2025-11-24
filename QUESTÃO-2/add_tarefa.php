<?php
include "database.php";

$descricao = $_POST["descricao"];
$venc = $_POST["vencimento"] ?? null;

$stmt = $db->prepare("INSERT INTO tarefas (descricao, vencimento) VALUES (?, ?)");
$stmt->execute([$descricao, $venc]);

header("Location: index.php");
exit;
?>