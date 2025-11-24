<?php include "database.php"; ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Gerenciador de Tarefas</title>
<style>
    body { font-family: Arial; margin: 40px; background: #f2f2f2; }
    h2 { margin-top: 30px; }
    .tarefa { background: white; padding: 10px; margin: 6px 0; border-radius: 5px; }
    .botao { margin-left: 10px; }
</style>
</head>
<body>

<h1>Minhas Tarefas</h1>

<form action="add_tarefa.php" method="POST">
    <input type="text" name="descricao" placeholder="Descrição da tarefa" required>
    <input type="date" name="vencimento">
    <button type="submit">Adicionar</button>
</form>

<hr>

<h2>Tarefas Pendentes</h2>
<?php
$pendentes = $db->query("SELECT * FROM tarefas WHERE concluida = 0 ORDER BY vencimento ASC");
foreach ($pendentes as $t) {
    echo "<div class='tarefa'>";
    echo "<strong>" . htmlspecialchars($t['descricao']) . "</strong>";
    if ($t['vencimento']) echo " - vence em: " . $t['vencimento'];

    echo "<a class='botao' href='update_tarefa.php?id={$t['id']}'>Concluir</a>";
    echo "<a class='botao' href='delete_tarefa.php?id={$t['id']}'>Excluir</a>";
    echo "</div>";
}
?>

<h2>Tarefas Concluídas</h2>
<?php
$concluidas = $db->query("SELECT * FROM tarefas WHERE concluida = 1");
foreach ($concluidas as $t) {
    echo "<div class='tarefa' style='opacity:0.6'>";
    echo "<strike>" . htmlspecialchars($t['descricao']) . "</strike>";
    echo "<a class='botao' href='delete_tarefa.php?id={$t['id']}'>Excluir</a>";
    echo "</div>";
}
?>

</body>
</html>