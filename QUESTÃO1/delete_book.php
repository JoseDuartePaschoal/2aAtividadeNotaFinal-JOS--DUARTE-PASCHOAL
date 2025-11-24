<?php
include "database.php";

$id = $_POST['id'];

$stmt = $db->prepare("DELETE FROM livros WHERE id = :id");
$stmt->bindValue(":id", $id);
$stmt->execute();

header("Location: index.php");
exit();