<?php
include "database.php";

$id = $_GET["id"];

$stmt = $db->prepare("UPDATE tarefas SET concluida = 1 WHERE id = ?");
$stmt->execute([$id]);

header("Location: index.php");
exit;
?>