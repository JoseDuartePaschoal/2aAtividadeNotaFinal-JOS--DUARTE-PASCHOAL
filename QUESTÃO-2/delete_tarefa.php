<?php
include "database.php";

$id = $_GET["id"];

$stmt = $db->prepare("DELETE FROM tarefas WHERE id = ?");
$stmt->execute([$id]);

header("Location: index.php");
exit;
?>