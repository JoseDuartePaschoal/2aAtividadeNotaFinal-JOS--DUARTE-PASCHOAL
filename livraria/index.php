<?php
$db = new PDO("sqlite:livraria.db");

$db->exec("CREATE TABLE IF NOT EXISTS livros (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    titulo TEXT,
    autor TEXT,
    ano INTEGER
)");

if (isset($_POST['add'])) {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $ano = $_POST['ano'];

    if (!empty($titulo) && !empty($autor) && !empty($ano)) {
        $stmt = $db->prepare("INSERT INTO livros (titulo, autor, ano) VALUES (?, ?, ?)");
        $stmt->execute([$titulo, $autor, $ano]);
    }
    header("Location: index.php");
    exit;
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $db->exec("DELETE FROM livros WHERE id = $id");
    header("Location: index.php");
    exit;
}

$editando = false;
$livroEditar = null;

if (isset($_GET['edit'])) {
    $editando = true;
    $idEditar = $_GET['edit'];
    $resultado = $db->query("SELECT * FROM livros WHERE id = $idEditar");
    $livroEditar = $resultado->fetch(PDO::FETCH_ASSOC);
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $ano = $_POST['ano'];

    $stmt = $db->prepare("UPDATE livros SET titulo = ?, autor = ?, ano = ? WHERE id = ?");
    $stmt->execute([$titulo, $autor, $ano, $id]);

    header("Location: index.php");
    exit;
}

$livros = $db->query("SELECT * FROM livros ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Sistema de Livraria (PHP/SQLite)</title>
<style>
    body { font-family: Arial; margin: 20px; }
    .box { padding: 10px; border: 1px solid #ccc; margin-bottom: 20px; }
    input[type=text], input[type=number] { padding: 5px; width: 200px; }
    table { width: 100%; border-collapse: collapse; margin-top: 15px; }
    table th, table td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    .btn { padding: 4px 10px; cursor: pointer; }
    .btn-excluir { background: red; color: white; border: none; }
    .btn-editar { background: #007bff; color: white; border: none; }
</style>
</head>
<body>

<h2>Sistema de Livraria (PHP/SQLite)</h2>
<hr>

<div class="box">
    <h3><?php echo $editando ? "Editar Livro" : "Adicionar Novo Livro"; ?></h3>

    <form method="POST">
        <?php if ($editando): ?>
            <input type="hidden" name="id" value="<?= $livroEditar['id'] ?>">
        <?php endif; ?>

        Título: <br>
        <input type="text" name="titulo" value="<?= $editando ? $livroEditar['titulo'] : "" ?>"><br><br>

        Autor: <br>
        <input type="text" name="autor" value="<?= $editando ? $livroEditar['autor'] : "" ?>"><br><br>

        Ano de Publicação: <br>
        <input type="number" name="ano" value="<?= $editando ? $livroEditar['ano'] : "" ?>"><br><br>

        <?php if ($editando): ?>
            <button class="btn" type="submit" name="update">Salvar Alterações</button>
            <a href="index.php">Cancelar</a>
        <?php else: ?>
            <button class="btn" type="submit" name="add">Adicionar Livro</button>
        <?php endif; ?>
    </form>
</div>

<h3>Livros Cadastrados</h3>

<table>
    <tr>
        <th>ID</th>
        <th>Título</th>
        <th>Autor</th>
        <th>Ano</th>
        <th>Ação</th>
    </tr>

    <?php foreach ($livros as $l): ?>
        <tr>
            <td><?= $l['id'] ?></td>
            <td><?= $l['titulo'] ?></td>
            <td><?= $l['autor'] ?></td>
            <td><?= $l['ano'] ?></td>
            <td>
                <a href="index.php?edit=<?= $l['id'] ?>">
                    <button class="btn-editar btn">Editar</button>
                </a>
                <a href="index.php?delete=<?= $l['id'] ?>" onclick="return confirm('Excluir este livro?');">
                    <button class="btn-excluir btn">Excluir</button>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>